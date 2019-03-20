<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  guestPassServicesTwo{

private $locationId = null;
private $passId = null;
private $dropListCurrent = null;
private $dropListAvailable = null;
private $userId = null;
private $serviceAnd = "AND service_type LIKE '%Guest%'";
private $serviceSwitch = null;
private $groupType = 'S';
private $scriptSalt = 1;


   
function setLocationId($locationId) {
$this->locationId = $locationId;
}

function setPassId($passId) {
$this->passId = $passId;
}

function setUserId($userId) {
$this->userId = $userId;
}

function setServiceSql($serviceSql) {
$this->serviceSql = $serviceSql;
}

function setServiceAnd($serviceAnd) {
$this->serviceAnd = $serviceAnd;
}

function setServiceSwitch($serviceSwitch) {
$this->serviceSwitch = $serviceSwitch;
}

function setScriptSalt($scriptSalt) {
$this->scriptSalt =$scriptSalt;
}


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//============================================================================
function makeDropDownAvailable()  { 

if($this->locationId == 0) {
   $allService = null;
   }else{
   $allService = "OR club_id='0'";
   }


$dbMain = $this->dbconnect();
$dbMain->query("CREATE TEMPORARY TABLE temp_service_info  LIKE service_info");
$dbMain->query("INSERT INTO temp_service_info SELECT * FROM service_info WHERE club_id='$this->locationId' $allService");

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM guest_pass_services WHERE pass_id ='$this->passId' "); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key); 

 while ($stmt->fetch()) {          
          $dbMain->query("DELETE FROM temp_service_info WHERE service_key ='$service_key'");
          }


$stmt2 = $dbMain ->prepare("SELECT service_key, service_type, club_id  FROM temp_service_info WHERE club_id='$this->locationId' $allService"); 
      if(!$stmt2->execute())  {
	     printf("Error: %s.\n", $stmt2->error);
          }		   
      $stmt2->store_result();      
      $stmt2->bind_result($serviceKey, $serviceType, $clubId); 

    while ($stmt2->fetch()) {   
                            
             $result = $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$clubId'");
                            $row = mysqli_fetch_array($result, MYSQLI_NUM);
                            $club_name = $row[0];
                                  
                       if($club_name == "")  {
                          $club_name = 'All Locations';
                         }
                                if(preg_match("/\bguest\b/i", $serviceType)) { 
                                   $options .= "<option value=\"$clubId|$serviceKey\">$serviceType  $club_name</option>\n"; 
                                   }
             }
                                       
 //if there are no options available state it here
                               if($options == null)  {
                                   $options = '<option value="">Currently no new Services available</option>';                              
                                  }
                                
                               //here is the object for multiple records
                                $selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types2[]\" id=\"service_types2\">\n";
                                $drop_select = "$selectHeader  $options </select>";
                                              
                               $this->dropListAvailable = $drop_select;  
                               
 $stmt->close();                                                               
 $stmt2->close();                               
}
//-------------------------------------------------------------------------------------------------------------------------------------
function makeDropDownCurrent()   { 

$dbMain = $this->dbconnect();
//create the select type  
$selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types1[]\" id=\"service_types1\">\n";                 
            
if($this->clubId == 0) {
  $this->serviceAnd = null;
  }else{
  $this->serviceAnd = "OR club_id= '0'";
  }

   
$stmt = $dbMain ->prepare("SELECT club_id, service_key FROM guest_pass_services WHERE pass_id ='$this->passId'"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($club_id, $service_key); 
            
      
    while ($stmt->fetch()) {      
    
                                 $result1 = $dbMain ->query("SELECT service_type FROM service_info WHERE service_key ='$service_key'");
                                 $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
                                 $service_type = $row1[0];    
    
                                 $result2  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
                                 $service_location = $row2[0];
                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
                                     }
                                                                   
                                  $options .= "<option value=\"$club_id|$service_key\">$service_type  $service_location</option>\n";                                  
                                                      
                }
                
                               //if there are no options available state it here
                               if($options == null)  {
                                   $options = '<option value="">Currently no new Services available</option>';                              
                                  }
                
                
                               //hear is the object for multiple records
                                $drop_select = "$selectHeader  $options </select>";
                                
              
                                $this->dropListCurrent = $drop_select;  
                               
                                                                
 $stmt->close();                               
 }        
      
//====================================================================   
function getDropListCurrent() {
return($this->dropListCurrent);
}
function getDropListAvailable() {
return($this->dropListAvailable);
}

      
}

//======================================================================
//this handles ajax calls when a sales position is clicked on the employee type list
/*
if($service_switch == 1)  {

$service_drop = new guestPassServices();
$service_drop->setClubId($club_id);
$service_drop->setServiceSwitch($service_switch);
$services_list = $service_drop->makeDropDown(); 

echo"$services_list";
exit;
}
*/

//=====================================================================





     
?>