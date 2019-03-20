<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  serviceList {

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $holder = null;
private  $clubId = null;
private  $clubName = null;
private  $serviceKey = null;
private  $serviceDuration = null;
private  $tableContent = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }

function setLocationId($locationId) {
       $this->locationId = $locationId;
       }
       
function setBundleId($bundleId) {
       $this->bundleId = $bundleId;
       }
 
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
 
//--------------------------------------------------------------------------------------
function parseGroupType() {

                switch($this->groupType) {          
                       case"S":
                       $this->groupType = "Single";                 
                       break;
                       case"F":
                       $this->groupType = "Family";                     
                       break;
                       case"B":
                       $this->groupType = "Business"; 
                       break;
                       case"O":
                       $this->groupType = "Organization"; 
                       break;                       
                       }

}
//--------------------------------------------------------------------------------------
function loadDurationTypes() {

 $dbMainTwo = $this->dbconnect();
 $stmt = $dbMainTwo ->prepare("SELECT DISTINCT  service_term FROM service_cost WHERE service_key = '$this->serviceKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($service_term); 
 
    while ($stmt->fetch()) {
    
    
    if($service_term != null) {
    
                switch($service_term) {          
                       case"C":
                       $classes = "Classes";                 
                       break;
                       case"D":
                       $days = "Days";                     
                       break;
                       case"W":
                       $weeks = "Weeks"; 
                       break;
                       case"M":
                       $months = "Months"; 
                       break;
                       case"Y":
                       $years = "Years"; 
                       break;                        
                       }
                  
                                   
                  $serviceDuration .= "$classes,$days,$weeks,$months,$years,";
                   
             }
}


$str = implode(',',array_unique(explode(',', $serviceDuration)));
$str = preg_replace('/[ ,]+/', ' ', trim($str));
$this->serviceDuration = $str;
$serviceDuration = null;

$stmt->close();

}
//--------------------------------------------------------------------------------------
function loadClubName() {

 $dbMainTwo = $this->dbconnect();
 $stmt = $dbMainTwo ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name); 
 $stmt->fetch();

if($club_name == null) {
   $this->clubName = "All Locations";
  }else{
   $this->clubName = $club_name;
  }

$stmt->close();
}
//--------------------------------------------------------------------------------------
function loadCurrentList() {

//this passes the dbconeect object if comming from the crete parse list method
$dbMain =$this->holder;

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_type, club_id, group_type FROM temp_service_info WHERE club_id !=''"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key, $service_type, $club_id, $group_type); 

         while ($stmt->fetch()) {   
                   
                   $this->clubId = $club_id;
                   $this->serviceKey = $service_key;
                   $this->groupType = $group_type;
                   $this->loadClubName();
                   $this->loadDurationTypes();
                   $this->parseGroupType();
                                     
                          static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "odd";
                                           $cell_count = "";
                                   }else{
                                           $color = "even";
                                   }
                                           $cell_count = $cell_count + 1;    
    
    
      $tableRow .= "<tr class=\"$color\">
	        		         <td><input type=\"checkbox\" name=\"service\" value=\"$service_key\" class=\"service\" > </td>
			                 <td class=\"black\">
			                 $service_type
		                     </td>
			                 <td class=\"black\">
			                 $this->serviceDuration
			                 </td>
			                 <td class=\"black\">
			                 $this->clubName
		                     </td>
			                 <td class=\"black\">
			                 $this->groupType
		                     </td>		                     
		                     </tr>";  
    
       
               //  $test .= "$service_type $service_key, $this->serviceDuration  $this->clubName \n";
                   $this->serviceKey = "";

                  }


$tableHeader = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  id=\"listOne\">
	                      <thead>
		                  <tr>
		                  <th class=\"headerList\">&nbsp;</th>
			              <th class=\"headerList\">Services</th>
			              <th class=\"headerList\">Duration Types</th>
			              <th class=\"headerList\">Location</th>
			              <th class=\"headerList\">Group Type</th>
		                  </tr>
	                      </thead>
	                      <tbody>";

$tableEnd = '</tbody></table>';

$this->tableContent = "$tableHeader $tableRow $tableEnd";


}
//--------------------------------------------------------------------------------------
function filterServiceList() {

if($this->locationId == 0) {
  $sqlOr = "";
  }else{
  $sqlOr = "OR (club_id='0')";
  }

$dbMain = $this->dbconnect();
$dbMain->query("CREATE TEMPORARY TABLE temp_service_info  LIKE service_info");
$dbMain->query("INSERT INTO temp_service_info SELECT * FROM service_info WHERE club_id='$this->locationId' $sqlOr");

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM bundle_lists WHERE  bundle_id='$this->bundleId'"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key); 

 while ($stmt->fetch()) {          
          $dbMain->query("DELETE FROM temp_service_info WHERE service_key ='$service_key'");
          }

$this->holder = $dbMain;



}
//--------------------------------------------------------------------------------------
function loadServiceList() {

$this->filterServiceList();
$this->loadCurrentList();

}
//--------------------------------------------------------------------------------------
function getTableContent() {
         return($this->tableContent);
         }





}
//==================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_id = $_REQUEST['bundle_id'];
$location_id = $_REQUEST['location_id'];


if($ajax_switch == 1) {

  $list = new serviceList();
  $list-> setTypeId($schedule_type);
  $list-> setLocationId($location_id);
  $list-> setBundleId($bundle_id);
  $list-> loadServiceList();
  $service_list = $list-> getTableContent();
  
  echo"$service_list";

  }










