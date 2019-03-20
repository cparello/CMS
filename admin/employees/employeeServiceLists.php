<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class employeeServiceLists {

private $typeKey1 = null;
private $typeKey2 = null;
private $typeKey3 = null;
private $typeKey4 = null;
private $clubId = null;
private $commissionDefaultsArray;
private $flatRate;
private $commissionPercent;
private $optionValue;
private $commissionAmount;

private $optionValue1;
private $commissionAmount1;
private $optionValue2;
private $commissionAmount2;
private $optionValue3;
private $commissionAmount3;
private $optionValue4;
private $commissionAmount4;
private $userId;



function setTypeKey1($typeKey1)  {
		$this->typeKey1 = $typeKey1;
		  }
function setTypeKey2($typeKey2)  {
		$this->typeKey2 = $typeKey2;
		  }
function setTypeKey3($typeKey3)  {
		$this->typeKey3 = $typeKey3;
		  }
function setTypeKey4($typeKey4)  {
		$this->typeKey4 = $typeKey4;
		  }
		  
function setClubId($clubId) {
        $this->clubId = $clubId;
        }
        
function setUserId($userId) {
        $this->userId = $userId;
        }        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------------
function getTerms($service_key)  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT service_cost, service_term, service_quantity, flat_fee, commission_percent FROM service_cost WHERE service_key ='$service_key'   ORDER BY cost_key ASC");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_cost,$service_term, $service_quantity, $flat_rate, $commission_percent); 

         while ($stmt->fetch()) { 
                       switch($service_term) {          
                       case"C":
                       $term_name = 'Class(s)';
                       break;
                       case"D":
                       $term_name = 'Day(s)';
                       break;
                       case"W":
                       $term_name = 'Week(s)';
                       break;
                       case"M":
                       $term_name = 'Month(s)';
                       break;
                       case"Y":
                       $term_name = 'Year(s)';
                       break;
                       }
                       
                     if($service_term == null) {
                        $service_quantity = 'N/A';
                        $term_name = "";
                        $service_cost ="";
                        }

                  $termsArray .= "$service_quantity $term_name $service_cost|";
                  
                  $this->commissionDefaultsArray .= "$flat_rate $commission_percent|";
      }
      
return "$termsArray";      
      
}

//-----------------------------------------------------------------------------------------------------------------------
 function fieldValues()  {
                  
                         if(($this->flatRate == null) && ($this->commissionPercent == null)) {
                            $this->optionValue = "<option value>Pay Type</option>";
                            $this->commissionAmount = null;
                            }elseif($this->flatRate != null) {
                            $this->optionValue = "<option value=\"F\">Flat Fee</option selected>";
                            $this->commissionAmount = $this->flatRate;
                            }elseif($this->commissionPercent != null) {
                            $this->optionValue = "<option value=\"P\">Percent</option selected>";
                            $this->commissionAmount = $this->commissionPercent;
                           }
 }
//-----------------------------------------------------------------------------------------------------------------------
function parseCommissions()  {

    //this gets the commission defaults
     $commissionDefaultsArray = $this->commissionDefaultsArray;
     
 //    echo"$commissionDefaultsArray<br>";
     $commissionDefaults = explode("|", $commissionDefaultsArray);
     $commissionDefaults1 = $commissionDefaults[0];
     $commissionDefaults2 = $commissionDefaults[1];
     $commissionDefaults3 = $commissionDefaults[2];
     $commissionDefaults4 = $commissionDefaults[3];

      //split the array by white  space to see what the defaulsts should br
      $payTypeDefaults1 = explode(" ",  $commissionDefaults1);  
      $this->flatRate =  $payTypeDefaults1[0];
      $this->commissionPercent = $payTypeDefaults1[1];
      $this->fieldValues();
      $this->optionValue1 = $this->optionValue;
      $this->commissionAmount1 =$this->commissionAmount;
       
      $payTypeDefaults2 = explode(" ",  $commissionDefaults2);  
      $this->flatRate =  $payTypeDefaults2[0];
      $this->commissionPercent = $payTypeDefaults2[1];
      $this->fieldValues();
      $this->optionValue2 = $this->optionValue;
      $this->commissionAmount2 =$this->commissionAmount;
      
      $payTypeDefaults3 = explode(" ",  $commissionDefaults3);  
      $this->flatRate =  $payTypeDefaults3[0];
      $this->commissionPercent = $payTypeDefaults3[1];
      $this->fieldValues();
      $this->optionValue3 = $this->optionValue;
      $this->commissionAmount3 =$this->commissionAmount;   
      
      $payTypeDefaults4 = explode(" ",  $commissionDefaults4);  
      $this->flatRate =  $payTypeDefaults4[0];
      $this->commissionPercent = $payTypeDefaults4[1];
      $this->fieldValues();
      $this->optionValue4 = $this->optionValue;
      $this->commissionAmount4 =$this->commissionAmount;
       
       $this->commissionDefaultsArray =null;
       
}
//-----------------------------------------------------------------------------------------------------------------------
//this function gets the listings of services in table format
function makeServiceList()    {

$dbMain = $this->dbconnect();

if($this->clubId == "0")  {
  $stmt = $dbMain ->prepare("SELECT service_key, service_type, club_id FROM service_info WHERE club_id !='' ORDER BY service_type ASC");
  }else{
   $stmt = $dbMain ->prepare("SELECT service_key, service_type, club_id FROM service_info WHERE club_id ='$this->clubId' ORDER BY service_type ASC");
   //$stmt = $dbMain ->prepare("SELECT DISTINCT  service_key FROM commission_compensation WHERE club_id ='$this->clubId' AND user_id ='$this->userId'");
  }
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_key, $service_type, $club_id);  

                     $i = 1;
                      while ($stmt->fetch()) {                            
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                 
                                 
                                 //$result2  =  $dbMain -> query("SELECT service_type FROM service_info WHERE club_id = '$this->clubId'");
                              //   $row1 = mysqli_fetch_array($result2, MYSQLI_NUM);
                              //   $service_type = $row1[0]; 
                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
                                     }
                                     
                                  $termsArray = $this->getTerms($service_key); 
                                  $terms = explode("|", $termsArray);
                                  $term1 = $terms[0];
                                  $term2 = $terms[1];  
                                  $term3 = $terms[2];
                                  $term4 = $terms[3];
                                                                 
                                  //this sets up the drop downs and if the value is a flat rate or a percent
                                  $this->parseCommissions();
                                  $optionValue1 = $this->optionValue1;
                                  $optionValue2 = $this->optionValue2;
                                  $optionValue3 = $this->optionValue3;
                                  $optionValue4 = $this->optionValue4;
                                  $commissionAmount1 = $this->commissionAmount1;
                                  $commissionAmount2 = $this->commissionAmount2;
                                  $commissionAmount3 = $this->commissionAmount3;
                                  $commissionAmount4 = $this->commissionAmount4;
                                
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $color2 = "D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                           $color2 = "FFFFFF";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            
                                            
$comp_type_a="comp_type$i";
$comp_type_b ='[]';
$comp_type ="$comp_type_a$comp_type_b";

$comp_a ="comp$i";
$comp_b ='[]';
$comp = "$comp_a$comp_b";

$records .="<tr id=\"a$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$i</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type <span class=\"locationColor\">$service_location</span></b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term1</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term2</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term3</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term4</b></font></td>
<td align=\"left\"  valign =\"top\"></td>
</tr>
<tr id=\"b$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"></td>
<td align=\"left\" valign =\"top\"></td>
<td align=\"left\" valign =\"top\"><select name=\"$comp_type\" id=\"com_type\">$optionValue1<option value=\"F\">Flat Fee</option><option value=\"P\">Percent</option></select>&nbsp;<input type=\"text\" name=\"$comp\" value=\"$commissionAmount1\" size=\"3\" maxlength=\"3\"/ onKeyUp=\"checkValue(this.value)\"></td>
<td align=\"left\"  valign =\"top\"><select name=\"$comp_type\" id=\"com_type\">$optionValue2<option value=\"F\">Flat Fee</option><option value=\"P\">Percent</option></select>&nbsp;<input type=\"text\" name=\"$comp\" value=\"$commissionAmount2\" size=\"3\" maxlength=\"3\" onKeyUp=\"checkValue(this.value)\"/ ></td>
<td align=\"left\"  valign =\"top\"><select name=\"$comp_type\" id=\"com_type\">$optionValue3<option value=\"F\">Flat Fee</option><option value=\"P\">Percent</option></select>&nbsp;<input type=\"text\" name=\"$comp\" value=\"$commissionAmount3\" size=\"3\" maxlength=\"3\" onKeyUp=\"checkValue(this.value)\" /></td>
<td align=\"left\"  valign =\"top\"><select name=\"$comp_type\" id=\"com_type\">$optionValue4<option value=\"F\">Flat Fee</option><option value=\"P\">Percent</option></select>&nbsp;<input type=\"text\" name=\"$comp\" value=\"$commissionAmount4\" size=\"3\" maxlength=\"3\" onKeyUp=\"checkValue(this.value)\"/ ></td>
<td align=\"left\"  valign =\"top\"><input type=\"checkbox\" name=\"serve[]\" value=\"$i|$club_id|$service_key|\" onClick=\"changeColor(this,'a$i','b$i','$color','$comp_type','$comp')\"/></td>
</tr>";
      $counter = $i++;                                                    
                          }

return "$records";



}
//-------------------------------------------------------------------------------------------------------------------------
//helper app to find if list will return  clubs
function findAll($typeKey)   {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT employee_type, club_id FROM employee_type WHERE type_key = '$typeKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($employee_type, $club_id);   
 $stmt->fetch();


 if (preg_match("/sales/i", $employee_type)) {
    return "$club_id";
   }else{
    return null;
   }

}
//====================================================================
function loadServiceLists()    {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" width=100%>
<form name=\"form1\" action=\"addEmployee.php\" method=\"post\">
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term1</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term2</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 3</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 4</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Select</font></th>
</tr>\n";     



//this sets up the first selection
$this->clubId = $this->findAll($this->typeKey1);
if($this->clubId == "0") {
//this is where we parse the list and return it if it is zero we print all
$allServiceList = $this->makeServiceList();
return "$table_header $allServiceList";
exit;
}
elseif($this->clubId != null) {
$serviceList .= $this->makeServiceList();
}


//this sets up the second selection
$this->clubId = $this->findAll($this->typeKey2);
if($this->clubId == "0") {
//this is where we parse the list and return it if it is zero we print all
$allServiceList = $this->makeServiceList();
return "$table_header $allServiceList";
exit;
}
elseif($this->clubId != null) {
$serviceList .= $this->makeServiceList();
}


//this sets up the third selection
$this->clubId = $this->findAll($this->typeKey3);
if($this->clubId == "0") {
//this is where we parse the list and return it if it is zero we print all
$allServiceList = $this->makeServiceList();
return "$table_header $allServiceList";
exit;
}
elseif($this->clubId != null) {
$serviceList .= $this->makeServiceList();
}


//this sets up the fourth selection
$this->clubId = $this->findAll($this->typeKey4);
if($this->clubId == "0") {
//this is where we parse the list and return it if it is zero we print all
$allServiceList = $this->makeServiceList();
return "$table_header $allServiceList";
exit;
}
elseif($this->clubId != null) {
$serviceList .= $this->makeServiceList();
}


     


return "$table_header$serviceList";

exit;


}
//===================================================================






}
?>