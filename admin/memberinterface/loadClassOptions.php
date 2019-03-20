<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  loadClassOptions {

private  $searchString = null;
private  $scheduleType = null;
private  $clubId = null;
private  $barCodeType = null;
private  $groupType = null;
private  $serviceKey = null;
private  $radioButtons = null;
private  $radioGroup = null;
private  $classStatus = null;
private  $serviceCost = null;
private  $classPercent = null;


function setSearchString($searchString) {
              $this->searchString = $searchString;
              }

function setScheduleType($scheduleType) {
              $this->scheduleType = $scheduleType;
              }
              
function setClubId($clubId) { 
              $this->clubId = $clubId;
              }
              
function setBarCodeType($barCodeType) { 
              $this->barCodeType = $barCodeType;
              }              

function setGroupType($groupType) { 
              $this->groupType = $groupType;
              }              



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------------------
function loadClassPercent() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT class_percent FROM fees WHERE fee_num='1'");  
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($classPercent); 
   $stmt->fetch();

   $percentLength = strlen($classPercent);
   $percentOne = '.0';
   $percentTwo = '.';
   
   switch ($percentLength) {
           case "1":
           $this->classPercent = "$percentOne$classPercent";
           break;
           case "2":
           $this->classPercent = "$percentTwo$classPercent";
           break;
           case "3":
           $this->classPercent = $classPercent;
           break;
         }
    
   $stmt->close();

}
//----------------------------------------------------------------------------------------------------------------
function loadServiceClasses() {

    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT service_cost, service_term, service_quantity, cost_key FROM service_cost WHERE service_key='$this->serviceKey' ORDER BY service_quantity ASC");     
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($serviceCost, $serviceTerm, $serviceQuantity, $costKey); 
    $rowCount = $stmt->num_rows;
    
    if($rowCount > 0) {
        
       while ($stmt->fetch()) {  
       
             if($this->barCodeType == 'N') {
                $servicePercent = $serviceCost * $this->classPercent;
                $serviceCost = $serviceCost + $servicePercent;                
                }
                
                $classCost = number_format($serviceCost,2);
       
                if($serviceTerm == 'C') {                    
                    $this->radioButtons .= "<td valign =\"baseline\" class=\"black tabPad4\" id=\"$costKey\"><input type=\"radio\" id=\"$serviceQuantity\" name=\"sessions\" value=\"$classCost,$this->serviceKey\"/>&nbsp; $serviceQuantity Class(s) $classCost</td>\n";                                     
                   }
    
              }
         
         $this->classStatus = 1;
                 
       }
       
  if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }      
       
   $stmt->close();    
/*       
| cost_key           | int(10) unsigned          | NO   | PRI | NULL    | auto_increment |
| service_key        | int(10)                   | YES  | MUL | NULL    |                |
| service_cost       | decimal(10,2)             | YES  |     | NULL    |                |
| service_term       | enum('C','D','W','M','Y') | YES  | MUL | NULL    |                |
| service_quantity   | int(10)                   | YES  | MUL | NULL    |                |
| flat_fee           | decimal(10,2)             | YES  |     | NULL    |                |
| commission_percent | int(10)                   | YES  |     | NULL    |                |
| access_limit       | char(7)                   | YES  |     | NULL    |   
*/
}
//----------------------------------------------------------------------------------------------------------------
function loadRecords()   {   

    $dbMain = $this->dbconnect();
    $stmt = $dbMain->prepare("SELECT * FROM service_info WHERE service_type LIKE '%$this->searchString%' AND club_id= '$this->clubId' AND group_type= '$this->groupType' AND bundle_class='Y' "); 
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_type, $service_desc, $club_id, $group_type, $bundle_class);
    $rowCount = $stmt->num_rows;
   
   if($rowCount > 0) {
   
       while ($stmt->fetch()) {     
                 $this->serviceKey = $service_key;
                 $this->loadServiceClasses();                                                                          
                }
     
         if(!$stmt->execute())  {
        	printf("Error: %s.\n  monthly_payments function loadRecords", $stmt->error);
           } 
     
     
       $stmt->close();      
        
       $this->radioGroup = "
       <table align=\"left\" cellspacing=\"3\" cellpadding=\"3\">
       <form id=\"form2\">
       <tr>
       $this->radioButtons
       </tr>
       </table>";
       
    }else{
    $this->classStatus = 2;
    }
     
     
     
}     
//----------------------------------------------------------------------------------------------------------------------
   function getRadioGroup()   {
		return($this->radioGroup);
    	} 

   function getClassStatus()   {
		return($this->classStatus);
    	} 


}
//====================================================================
$schedule_type = $_REQUEST['schedule_type'];
$ajax_switch = $_REQUEST['ajax_switch'];
$search_string = $_REQUEST['search_string'];
$club_id = $_REQUEST['club_id'];
$bar_code_type = $_REQUEST['bar_code_type'];
$group_type = $_REQUEST['group_type'];

if($ajax_switch == 1) {

$load = new loadClassOptions();
$load-> setScheduleType($schedule_type);
$load-> setSearchString($search_string);
$load-> setClubId($club_id);
$load-> setBarCodeType($bar_code_type);
$load-> setGroupType($group_type);
$load-> loadClassPercent();
$load-> loadRecords();
$class_status = $load-> getClassStatus();
$radio_group = $load-> getRadioGroup();
 
$radio_group_array = "$class_status|$radio_group";
echo"$radio_group_array";
exit;

}






?>