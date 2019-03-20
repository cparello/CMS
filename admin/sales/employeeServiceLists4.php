<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class employeeServiceLists {

private $userId;
private $serviceKey;
private $serviceQuantity = null;
private $divCount;
private $groupType;
private $groupNumber = null;
private $singleRows;
private $familyRows;
private $businessRows;
private $organizationRows;
private $keyList;
private $membershipFlag = null;
private $parseFlag = null;
private $monthGovernor = null;
private $monthDisabled = null;
private $rowDisabled = 0;
private $termsArray;
private $cellCount = 1;
private $cellRows = 0;
private $records = null;

function setMonthGovernor($monthGovernor) {
       $this->monthGovernor = $monthGovernor;
       }
function setServiceKey($serviceKey)  {
	   $this->serviceKey = $serviceKey;
		}
function setUserId($userId) {
       $this->userId = $userId;
        }        
function setGroupType($groupType) {
       $this->groupType = $groupType;
        }
function setKeyList($keyList) {
       $this->keyList = $keyList;
       }
function setMembershipFlag($membershipFlag) {
       $this->membershipFlag = $membershipFlag;
       }
function setGroupNumber($groupNumber) {
       $this->groupNumber = $groupNumber;
       }
function setUpgradeFlag($upgrade_flag){
        $this->upgradeFlag = $upgrade_flag;
        }

function setUpgradeServiceKey($upgrade_service_key){
        $this->upgradeServiceKey = $upgrade_service_key;
        }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------------
//this creates the divs for the summary fields
function createSummaryDivs($numRows, $groupType) {


for ($i = 1; $i <= $numRows; $i++) {   
      $divs .= "<div id=\"$i$groupType\"></div>\n";    
     }

return $divs;
}
//-----------------------------------------------------------------------------------------------------------------------
function checkMonthGovernor() {

if($this->monthGovernor != null)  {

     if($this->serviceQuantity == $this->monthGovernor) {
        $this->monthDisabled = null;
        }else{
        $this->monthDisabled = 'disabled="disabled"';
        //counts to 4 and if true means row is canceled
        $this->rowDisabled++;  
        }

  }else{
   $this->monthDisabled = null;  
  }


}
//-----------------------------------------------------------------------------------------------------------------------
function getTerms($service_key,$comp_type, $field_id)  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT service_cost, service_term, service_quantity, flat_fee, commission_percent FROM service_cost WHERE service_key ='$service_key'   ORDER BY cost_key ASC");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_cost,$service_term, $service_quantity, $flat_fee, $commission_percent); 
      
        

         while ($stmt->fetch()) { 
                       
                       //this sets up a flag for non compatible months
                       $this->monthDisabled = null;
                       $this->serviceQuantity = $service_quantity;
                       
        // if ($service_term != ''){
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
                       $this->checkMonthGovernor();                       
                       break;
                       case"Y":
                       $term_name = 'Year(s)';
                       break;
                       case null:
                       $this->rowDisabled++;
                       break;
                       }
   //      }
                       
                       
                     //here we multiply the service cost by the number of members
                     $service_cost  = $this->groupNumber * $service_cost;   
                     $service_cost = sprintf ("%01.2f", $service_cost);
                       
                     $radio = "<input type=\"radio\" name=\"$comp_type\" value=\"$service_cost\" size=\"3\" maxlength=\"3\"/ onClick=\"deleteOthers(this.name);return passServiceCosts('$service_key','$service_quantity $term_name','$this->serviceType', this.value, this.name, '$this->cellCount$this->groupType');\" $this->monthDisabled />&nbsp;";   
                     
                    // setField(this.value, '$field_id'); 
                                    
                     if($service_term == null) {
                        $service_quantity = 'N/A';
                        $term_name = "";
                        $service_cost ="";
                        $radio = "";
                        }

                  $this->termsArray .= "$radio $service_quantity $term_name $service_cost|";
                  
              // echo"$this->termsArray <br>";
                  
      }
      
                     //this checks to see if the month is not present in the service it returns null
                   if($this->rowDisabled == 4) {
                     $this->termsArray = null;
                     }else{
                     $this->rowDisabled = null;
                     }
                       
      
}
//-----------------------------------------------------------------------------------------------------------------------
function checkFlag() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key ='$this->serviceKey' AND group_type ='$this->groupType'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_type); 
$stmt->fetch();

if(preg_match("/membership/i", $service_type)) {
  $this->parseFlag = 1;
  //echo"$service_type M $this->serviceKey<br>";
  }else{
  $this->parseFlag = null;
  //echo"$service_type Non $this->serviceKey<br>";
  }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 
}
//-----------------------------------------------------------------------------------------------------------------------
//this function gets the listings of services in table format
function makeServiceList()    {


  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT service_key, service_type, club_id FROM service_info WHERE service_key ='$this->serviceKey' AND group_type ='$this->groupType'");

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_key, $service_type, $club_id); 
      
      
                  
                      while ($stmt->fetch()) {  
                
                     // echo"$service_key $service_type <br>";
                      
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                  

                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
                                     }
                                     
                                  
     $this->serviceType = $service_type;                       
                                                                                                  
                          /*    
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
       
 //$this->cellCount++;
 */
                                       
$comp_type_a="comp_type$this->groupType$this->cellCount";
$comp_type_b ='[]';
$comp_type ="$comp_type_a$comp_type_b";

$comp_a ="comp$this->groupType$this->cellCount";
$comp_b ='[]';
$comp = "$comp_a$comp_b";


$this->getTerms($service_key, $comp_type, $comp_a); 

//f the service month exiss in the available upgrades it allows it to print
if($this->termsArray != null)  {

   $terms = explode("|", $this->termsArray);
   $term1 = $terms[0];
   $term2 = $terms[1];  
   $term3 = $terms[2];
   $term4 = $terms[3];

$this->termsArray = null;

//this sets up the renewal rate if it is a class or a date string  
$checkString = "$term1 $term2 $term3 $term4";
if(preg_match("/Class\(s\)/", $checkString)) {
  $disabled = 'disabled="disabled"';
  $rate_value = 'NA';
  }else{
  $disabled = null;
  $rate_value = null;
  }

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


$records ="<tr id=\"a$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->cellCount.</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type<br><span class=\"locationColor\">$service_location</span></b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term1</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term2</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term3</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term4</b></font></td>
<td align=\"left\"  valign =\"top\"><input type=\"text\" name=\"$comp\" id=\"$comp_a\" value=\"\" size=\"8\" maxlength=\"8\" disabled=\"disabled\" onClick=\"return fieldChange(this.value, '$this->cellCount$this->groupType', this.name);\"/ >
</td>
<td align=\"left\"  valign =\"top\"><input type=\"text\" name=\"$comp\" id=\"$comp_a\" value=\"$rate_value\" size=\"8\" maxlength=\"8\" $disabled onClick=\"return fieldChange2(this.value, this.name)\"/ >
</td>
<td align=\"left\"  valign =\"top\"><input type=\"text\" name=\"$comp\" id=\"$comp_a\" value=\"$rate_value\" size=\"8\" maxlength=\"8\" disabled=\"disabled\"/ >
</td>

<td align=\"left\"  valign =\"top\"><input  type=\"button\" name=\"save1\" value=\"Clear\" onClick=\"clearRowGroup('$comp_type','$comp','$this->cellCount$this->groupType')\"/>
</td>
</tr>
";

$this->cellCount++;
$this->cellRows++;
}



$checkString = null;
}



//this sets up the number of rows of a grouptype and creates the summary divs to delete in javascript
 switch($this->groupType) {          
                       case"S":
                       $this->singleRows = $this->cellCount-1;
                       $this->singleSummaryDivs= $this->createSummaryDivs($this->singleRows, $this->groupType);
                       break;
                       case"F":
                       $this->familyRows = $this->cellRows-1;
                       $this->familySummaryDivs= $this->createSummaryDivs($this->familyRows, $this->groupType);
                       break;
                       case"B":
                       $this->businessRows = $this->cellRows-1;
                       $this->businessSummaryDivs= $this->createSummaryDivs($this->businessRows, $this->groupType);
                       break;
                       case"O":
                       $this->organizationRows = $this->cellRows-1;
                       $this->organizationSummaryDivs= $this->createSummaryDivs($this->organizationRows, $this->groupType);
                       break;
                       }

return "$records";



}


//====================================================================
function loadServiceLists()    {

$table_header = "<table align=\"left\"  border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" >
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\" bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term1</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term2</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 3</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 4</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewal Rate</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Adjusted Price</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clear</font></th>

</tr>\n";     

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT DISTINCT commission_compensation.service_key FROM commission_compensation JOIN service_info ON commission_compensation.service_key = service_info.service_key WHERE user_id = '$this->userId' ORDER BY service_type ASC");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($service_key);  
 

 //set the row count in order to change the service list if there is only one row
$rowCount = $stmt->num_rows;
$this->rowCount = $rowCount;
 
 //this sets up the key list to filter out services that the client already has
 $this->keyList = rtrim($this->keyList,  ",");
 $array = explode(",",$this->keyList);



     while ($stmt->fetch()) {  
   
              $this->serviceKey = $service_key;
               
                     //filters out existing services
                  if(!in_array($this->serviceKey,  $array)) { 
                           //here we check to see if there is an existing membership then filter it out if exists

                           if($this->membershipFlag == 1) {
                              $this->checkFlag();
                              }
                             $stmt999 = $dbMain ->prepare("SELECT service_term FROM service_cost WHERE service_key = '$this->serviceKey' LIMIT 1");
                             $stmt999->execute();      
                             $stmt999->store_result();      
                             $stmt999->bind_result($service_term);                             
                             $stmt999->fetch();
                             $stmt999->close();
                             //echo "key $this->serviceKey  term $service_term  pf $this->parseFlag uf $this->upgradeFlag<br>";
                             if ($service_term == 'M' AND $this->parseFlag == 1 AND $this->upgradeFlag == 1){
                                $serviceList .= $this->makeServiceList();
                                $this->newUpgradeServiceKey = $this->serviceKey;
                             }else{
                                 if($this->parseFlag != 1) {
                                    $serviceList .= $this->makeServiceList();                                    
                                    }
                             }
                             
                                  
                    }
               }


//this handles if there is are no records athorized for this user
if($serviceList == null)  {
$table_header ='<table>';
}

$this->cellCount = null;

return "$table_header$serviceList</table>";



exit;


}
//===================================================================
function getSingleRows() {
             return($this->singleRows);
             }
function getFamilyRows() {
             return($this->familyRows);
             }
function getBusinessRows() {
             return($this->businessRows);
             }
function getOrganizationRows() {
             return($this->organizationRows);
             }             
function getSingleSummaryDivs() {
             return($this->singleSummaryDivs);
             }
function getFamilySummaryDivs() {
             return($this->familySummaryDivs);
             }
function getBusinessSummaryDivs(){
             return($this->businessSummaryDivs);
             }
function getOrganizationSummaryDivs(){
             return($this->organizationSummaryDivs);
             }
function getNewUpgradeServiceKey(){
                return($this->newUpgradeServiceKey);
                }







}
?>