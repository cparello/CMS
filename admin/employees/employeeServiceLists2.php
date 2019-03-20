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
private $serviceKey;

private $rowCount;

function setRowCount($rowCount) {
       $this->rowCount = $rowCount;
       }


function setServiceKey($serviceKey)  {
		$this->serviceKey = $serviceKey;
		  }
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

//----------------------------------------------------------------------------------------------------------------------------
function makeInputField($comp, $commissionAmount, $term, $pop_point) {

$term = trim($term);

if($term != "N/A")  {
$field = "<input type=\"text\" name=\"$comp\" value=\"$commissionAmount\" size=\"3\" maxlength=\"3\"/ onKeyUp=\"checkValue(this.value)\"><a href=\"javascript: void\" id=\"$pop_point\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, '$pop_point', 1);\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"></a>";
}else{
$field = "<input type=\"hidden\" name=\"$comp\" value=\"$commissionAmount\" size=\"3\" maxlength=\"5\"/ onKeyUp=\"checkValue(this.value)\">";
}

return "$field";

}

//-----------------------------------------------------------------------------------------------------------------------------
function makeSelectDrop($compType, $optionValue, $term)  {

$term = trim($term);

if($term != "N/A")  {
$drop_list ="<select name=\"$compType\" id=\"com_type\">$optionValue<option value=\"F\">Flat Fee</option><option value=\"P\">Percent</option></select>";
}else{
$drop_list = "<input type=\"hidden\" name=\"$compType\" id=\"com_type\"value=\"\"\>";
}

return "$drop_list";

}
//-----------------------------------------------------------------------------------------------------------------------------
function getCommissionArray($service_key)  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT flat_fee, commission_percent FROM commission_compensation WHERE service_key ='$service_key' AND user_id = '$this->userId'  ORDER BY com_key ASC");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($flat_rate, $commission_percent); 

         while ($stmt->fetch()) { 

                  $commissionDefaultsArray .="$flat_rate $commission_percent|";

                }

return "$commissionDefaultsArray";

}
//-----------------------------------------------------------------------------------------------------------------------
function getTerms($service_key)  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT service_cost, service_term, service_quantity, flat_fee, commission_percent FROM service_cost WHERE service_key ='$service_key'   ORDER BY cost_key ASC");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_cost,$service_term, $service_quantity, $flat_fee, $commission_percent); 

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
                  
                  $this->flatRateServiceArray .= "$flat_fee|";
                  $this->commissionPercentServiceArray .= "$commission_percent|";

      }
      
     
return "$termsArray";      
      
}

//-----------------------------------------------------------------------------------------------------------------------
 function fieldValues()  {
                  
                         if(($this->flatRate == "0.00") && ($this->commissionPercent == 0)) {
                                                 //check to see if there is a default value change in the services done after the service was assigned
                                                 if($this->flatRateDefault != null) {
                                                     $this->optionValue = "<option value=\"F\">Flat Fee</option selected>";
                                                     $this->commissionAmount = $this->flatRateDefault;
                                                     
                                                    }elseif($this->commissionPercentDefault != null) {
                                                               $this->optionValue = "<option value=\"P\">Percent</option selected>";
                                                               $this->commissionAmount = $this->commissionPercentDefault;
                                                    }else{
                         
                                                      $this->optionValue = "<option value>Pay Type</option>";
                                                      $this->commissionAmount = null;
                                                   }   
                                                      
                            }elseif($this->flatRate != "0.00") {
                            $this->optionValue = "<option value=\"F\">Flat Fee</option selected>";
                            $this->commissionAmount = $this->flatRate;
                            }elseif($this->commissionPercent != 0) {
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
     
     //here we split the default price and commission percent arrays
     $flatRateService = explode("|", $this->flatRateServiceArray);
     $flatRateService1 = $flatRateService[0];
     $flatRateService2 = $flatRateService[1];
     $flatRateService3 = $flatRateService[2];
     $flatRateService4 = $flatRateService[3];
     $commissionPercentService= explode("|",$this->commissionPercentServiceArray);
     $commissionPercentService1 = $commissionPercentService[0];
     $commissionPercentService2 = $commissionPercentService[1];
     $commissionPercentService3 = $commissionPercentService[2];
     $commissionPercentService4 = $commissionPercentService[3];
     

      //split the array by white  space to see what the defaulsts should br
      $payTypeDefaults1 = explode(" ",  $commissionDefaults1);  
      $this->flatRate =  $payTypeDefaults1[0];
      $this->commissionPercent = $payTypeDefaults1[1];
      $this->flatRateDefault = $flatRateService1;
      $this->commissionPercentDefault = $commissionPercentService1;    
      $this->fieldValues();
      $this->optionValue1 = $this->optionValue;
      $this->commissionAmount1 =$this->commissionAmount;
       
      $payTypeDefaults2 = explode(" ",  $commissionDefaults2);  
      $this->flatRate =  $payTypeDefaults2[0];
      $this->commissionPercent = $payTypeDefaults2[1];
      $this->flatRateDefault = $flatRateService2;
      $this->commissionPercentDefault = $commissionPercentService2; 
      $this->fieldValues();
      $this->optionValue2 = $this->optionValue;
      $this->commissionAmount2 =$this->commissionAmount;
      
      $payTypeDefaults3 = explode(" ",  $commissionDefaults3);  
      $this->flatRate =  $payTypeDefaults3[0];
      $this->commissionPercent = $payTypeDefaults3[1];
      $this->flatRateDefault = $flatRateService3;
      $this->commissionPercentDefault = $commissionPercentService3; 
      $this->fieldValues();
      $this->optionValue3 = $this->optionValue;
      $this->commissionAmount3 =$this->commissionAmount;   
      
      $payTypeDefaults4 = explode(" ",  $commissionDefaults4);  
      $this->flatRate =  $payTypeDefaults4[0];
      $this->commissionPercent = $payTypeDefaults4[1];
      $this->flatRateDefault = $flatRateService4;
      $this->commissionPercentDefault = $commissionPercentService4; 
      $this->fieldValues();
      $this->optionValue4 = $this->optionValue;
      $this->commissionAmount4 =$this->commissionAmount;
       
       $this->commissionDefaultsArray =null;
       $this->flatRateServiceArray =null;
       $this->commissionPercentServiceArray =null;
}
//-----------------------------------------------------------------------------------------------------------------------
//this function gets the listings of services in table format
function makeServiceList($i, $j)    {

$dbMain = $this->dbconnect();


  $stmt = $dbMain ->prepare("SELECT service_key, service_type, club_id FROM service_info WHERE service_key ='$this->serviceKey'");

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_key, $service_type, $club_id);  

                    
                      while ($stmt->fetch()) {                            
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                 

                                  
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
                                   $this->commissionDefaultsArray = $this->getCommissionArray($service_key);
                                  
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
       
  
//this sets up the positoning for the  pop ups  
$pop_salt1 =  "posa$i";  
$pop_salt2 = "posb$i";  
$pop_salt3 = "posc$i"; 
$pop_salt4 = "posd$i";  

                                       
$comp_type_a="comp_type$i";
$comp_type_b ='[]';
$comp_type ="$comp_type_a$comp_type_b";

$comp_a ="comp$i";
$comp_b ='[]';
$comp = "$comp_a$comp_b";

//this creates the drop downs if they exist
$select_drop_one = $this->makeSelectDrop($comp_type, $optionValue1, $term1);
$select_drop_two = $this->makeSelectDrop($comp_type, $optionValue2, $term2);
$select_drop_three = $this->makeSelectDrop($comp_type, $optionValue3, $term3);
$select_drop_four = $this->makeSelectDrop($comp_type, $optionValue4, $term4);

$field_one = $this->makeInputField($comp, $commissionAmount1, $term1, $pop_salt1);
$field_two = $this->makeInputField($comp, $commissionAmount2, $term2, $pop_salt2);
$field_three = $this->makeInputField($comp, $commissionAmount3, $term3, $pop_salt3);
$field_four = $this->makeInputField($comp, $commissionAmount4, $term4, $pop_salt4);





$records .="<tr id=\"a$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$i</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type<br><span class=\"locationColor\">$service_location</span></b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term1</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term2</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term3</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term4</b></font></td>
<td align=\"left\"  valign =\"top\"></td>
<td align=\"left\"  valign =\"top\"></td>
</tr>
<tr id=\"b$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"></td>
<td align=\"left\" valign =\"top\"></td>
<td align=\"left\" valign =\"top\">$select_drop_one &nbsp;$field_one</td>
<td align=\"left\"  valign =\"top\">$select_drop_two &nbsp;$field_two</td>
<td align=\"left\"  valign =\"top\">$select_drop_three &nbsp;$field_three</td>
<td align=\"left\"  valign =\"top\">$select_drop_four &nbsp;$field_four</td>
<td align=\"left\"  valign =\"top\"><input type=\"checkbox\" name=\"serve[]\" value=\"$i|$club_id|$service_key|\" onClick=\"changeColor(this,'a$i','b$i','$color','$comp_type','$comp',$j)\"/></td>

<td align=\"left\"  valign =\"top\"><input type=\"checkbox\" name=\"delete[]\" value=\"$service_key\" onClick=\"changeColor2(this,'a$i','b$i','$color',$j)\"/></td>
</tr>";






      $counter = $i++;                                                    
                          }

return "$records";



}
//-------------------------------------------------------------------------------------------------------------------------
//helper app to find if list will return  clubs
function findAll($typeKey)   {

$domain = $this->dbconnect();
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
<form name=\"form1\" action=\"parseEmployeeServiceLists.php\" method=\"post\" onSubmit=\"return checkData()\">
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term1</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term2</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 3</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 4</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Update</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Delete</font></th>

</tr>\n";     

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM commission_compensation WHERE user_id = '$this->userId' ORDER BY club_id");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($service_key);  
 
 
 //set the row count in order to change the service list if there is only one row
$rowCount = $stmt->num_rows;
$this->rowCount = $rowCount;
 
 
$i = 1; 
$j = 0;
     while ($stmt->fetch()) { 
     
               $this->serviceKey = $service_key;
               $serviceList .= $this->makeServiceList($i, $j);
               $i++;
               $j++;
              }




return "$table_header$serviceList";

exit;


}
//===================================================================






}
?>