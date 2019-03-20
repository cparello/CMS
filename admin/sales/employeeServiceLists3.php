<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class employeeServiceLists {

private $userId;
private $serviceKey;
private $divCount;
private $groupType;
private $singleRows;
private $familyRows;
private $businessRows;
private $organizationRows;


function setServiceKey($serviceKey)  {
		$this->serviceKey = $serviceKey;
		  }
function setUserId($userId) {
        $this->userId = $userId;
        }        
function setGroupType($groupType) {
       $this->groupType = $groupType;
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
function getTerms($service_key,$comp_type, $field_id)  {

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
                       
                     $radio = "<input type=\"radio\" name=\"$comp_type\" value=\"$service_cost\" size=\"3\" maxlength=\"3\"/ onClick=\"deleteOthers(this.name);return passServiceCosts('$service_key','$service_quantity $term_name','$this->serviceType', this.value, this.name, '$this->cellCount$this->groupType');\"/>&nbsp;";   
                     
                    // setField(this.value, '$field_id'); 
                       
                     if($service_term == null) {
                        $service_quantity = 'N/A';
                        $term_name = "";
                        $service_cost ="";
                        $radio = "";
                        }

                  $termsArray .= "$radio $service_quantity $term_name $service_cost|";
                  


      }
      
     
return "$termsArray";      
      
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
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                  

                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
                                     }
                                     
                                  
     $this->serviceType = $service_type;                       
                                 
                                                                 
                              
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
       
 $this->cellCount++;
 
                                       
$comp_type_a="comp_type$this->groupType$this->cellCount";
$comp_type_b ='[]';
$comp_type ="$comp_type_a$comp_type_b";

$comp_a ="comp$this->groupType$this->cellCount";
$comp_b ='[]';
$comp = "$comp_a$comp_b";


$termsArray = $this->getTerms($service_key, $comp_type, $comp_a); 
                                  $terms = explode("|", $termsArray);
                                  $term1 = $terms[0];
                                  $term2 = $terms[1];  
                                  $term3 = $terms[2];
                                  $term4 = $terms[3];



//this sets up the renewal rate if it is a class or a date string  
$checkString = "$term1 $term2 $term3 $term4";
if(preg_match("/Class\(s\)/", $checkString)) {
  $disabled = 'disabled="disabled"';
  $rate_value = 'NA';
  }else{
  $disabled = null;
  $rate_value = null;
  }



$records .="<tr id=\"a$i\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->cellCount</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type<br><span class=\"locationColor\">$service_location</span></b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term1</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term2</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term3</b></font></td>
<td align=\"left\"  valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$term4</b></font></td>
<td align=\"left\"  valign =\"top\"><input type=\"text\" name=\"$comp\" id=\"$comp_a\" value=\"\" size=\"8\" maxlength=\"8\" disabled=\"disabled\" onClick=\"return fieldChange(this.value, '$this->cellCount$this->groupType', this.name);\"/ >
</td>
<td align=\"left\"  valign =\"top\"><input type=\"text\" name=\"$comp\" id=\"$comp_a\" value=\"$rate_value\" size=\"8\" maxlength=\"8\" $disabled onClick=\"return fieldChange2(this.value, this.name)\"/ >
</td>
<td align=\"left\"  valign =\"top\"><input  type=\"button\" name=\"save1\" value=\"Clear\" onClick=\"clearRowGroup('$comp_type','$comp','$this->cellCount$this->groupType')\"/>
</td>
</tr>
";




$checkString = null;
}



//this sets up the number of rows of a grouptype and creates the summary divs to delete in javascript
 switch($this->groupType) {          
                       case"S":
                       $this->singleRows = $this->cellCount;
                       $this->singleSummaryDivs= $this->createSummaryDivs($this->singleRows, $this->groupType);
                       break;
                       case"F":
                       $this->familyRows = $this->cellCount;
                       $this->familySummaryDivs= $this->createSummaryDivs($this->familyRows, $this->groupType);
                       break;
                       case"B":
                       $this->businessRows = $this->cellCount;
                       $this->businessSummaryDivs= $this->createSummaryDivs($this->businessRows, $this->groupType);
                       break;
                       case"O":
                       $this->organizationRows = $this->cellCount;
                       $this->organizationSummaryDivs= $this->createSummaryDivs($this->organizationRows, $this->groupType);
                       break;
                       }

return "$records";



}


//====================================================================
function loadServiceLists()    {

$table_header = "<table align=\"left\" border=\"1\" rules=\"none\" frame=\"box\" cellspacing=\"0\" cellpadding=\"1\" width=100% >
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\" bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term1</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term2</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 3</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Term 4</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewal Rate</font></th>
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
 
 

     while ($stmt->fetch()) {  
               $this->serviceKey = $service_key;
               $serviceList .= $this->makeServiceList();
               }


//this handles if there is are no records athorized for this user
if($serviceList == null)  {
$table_header ='<table>';
}

$this->cellCount = null;

return "$table_header$serviceList";



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








}
?>