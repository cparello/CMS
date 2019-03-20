<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  serviceDrops{

private  $clubId = null;
private  $serviceKey;
private  $commissionList;
private  $accessList;

function setClubId($clubId) {
        $this->clubId = $clubId;
         }
 
function setServiceKey($serviceKey) {
        $this->serviceKey = $serviceKey;
        }

function setCommissionList($commissionList) {
        $this->commissionList = $commissionList;
        }
  
  

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//=================================================================================
function loadServiceMenu($service_term, $separator) {
          
          if($service_term == null) {
          $choose_duration = "
          <option value>Choose Duration</option>\n
          <option value=\"C\">Class(s)</option>\n
          <option value=\"D\">Days</option>\n
          <option value=\"W\">Weeks</option>\n
          <option value=\"M\">Months</option>\n   
          <option value=\"Y\">Years</option>$separator";
           }else{           
           switch($service_term) {          
             case"C":
             $option_name = "Class(s)";
             break;
             case"D":
             $option_name = "Days";
             break;
             case"W":
             $option_name = "Weeks";
             break;
             case"M":
             $option_name = "Months";
             break;
             case"Y":
             $option_name = "Years";
             break;             
            }
          $choose_duration = "
          <option value=\"$service_term\" selected>$option_name</option>\n
          <option value=\"C\">Class(s)</option>\n
          <option value=\"D\">Days</option>\n
          <option value=\"W\">Weeks</option>\n
          <option value=\"M\">Months</option>\n   
          <option value=\"Y\">Years</option>$separator";                
           }
           
return "$choose_duration";            
}

//========================================================================
function parseMenus()   {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT service_term FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_term);   

    while ($stmt->fetch()) {                  
              $term_select .= $this->loadServiceMenu($service_term, $separator);        
           }

$stmt->close();

return "$term_select";

}

//========================================================================
function parseQuantity()   {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT service_quantity FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_quantity);   



while ($stmt->fetch()) {     

            if($service_quantity == "0") {
               $service_quantity = " ";
                }

              $quantity .= "$service_quantity$separator";        
           }

return "$quantity";

$stmt->close();
}
//=========================================================================
function parseCost()   {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_cost);   



while ($stmt->fetch()) {     

            if($service_cost == "0.00") {
               $service_cost = "";
                }

              $cost .= "$service_cost$separator";        
           }

return "$cost";

$stmt->close();
}
//================================================================================
function parseKey()   {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT cost_key FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cost_key);   



while ($stmt->fetch()) {     

              $costKey .= "$cost_key$separator";        
           }

return "$costKey";

$stmt->close();
}

//this loads the menue for either a flat fee or a percent
//================================================================================
function loadCommissionMenu($commissionType, $separator)   {

if($commissionType == null)  {
           $choose_type = "
          <option value>Compensation Type</option>\n
          <option value=\"F\">Flat Rate</option>\n
          <option value=\"P\">Percentage</option>$separator\n";
}else{           
           switch($commissionType) {          
             case"F":
             $option_name = "Flat rate";
             break;
             case"P":
             $option_name = "Percentage";
             break;
            }
            $choose_type ="
          <option value=\"$commissionType\" selected>$option_name</option>\n
          <option value=\"F\">Flat Rate</option>\n
          <option value=\"P\">Percentage</option>$separator\n";
}


return "$choose_type";

}
//=================================================================================
function parseCommissionMenu()   {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT flat_fee,  commission_percent FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($flat_rate, $commission_percent);   

    while ($stmt->fetch()) {  
    
              //find out iit is a flat rate or a percent
              if(($flat_rate == null) && ($commission_percent == null)) {
                 $commission_type = null;
                 $commission_amount = null;
                }elseif($flat_rate != null) {
                 $commission_type = 'F';
                 $commission_amount = $flat_rate;
                }elseif($commission_percent != null) {
                 $commission_type ='P';
                 $commission_amount = $commission_percent;
                }
                
               $commission_list .= "$commission_amount$separator";
               
               
              $com_select .= $this->loadCommissionMenu($commission_type, $separator);        
           }

$stmt->close();

$this->commissionList = $commission_list;

return "$com_select";

}
//========================================================================
function  parseAccessLimit()  {

$dbMain = $this->dbconnect();
$clubId= $this->clubId; 
$serviceKey = $this->serviceKey;
$separator ='|';

$stmt = $dbMain ->prepare("SELECT access_limit FROM service_cost WHERE service_key = '$serviceKey' ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($access_limit);   

    while ($stmt->fetch()) {                  
              $accessList .= "$access_limit$separator";        
           }

$stmt->close();

return  $accessList;

}
//========================================================================
function  getCommissionList()   {
 return($this->commissionList);
}

//========================================================================


}

?>