<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  serviceListTwo {

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $holder = null;
private  $clubId = null;
private  $clubName = null;
private  $serviceKey = null;
private  $serviceName = null;
private  $serviceDuration = null;
private  $tableContent = null;
private  $groupType = null;


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
function loadServiceName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT service_type, group_type FROM service_info WHERE service_key = '$this->serviceKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($service_type, $group_type); 
 $stmt->fetch();
 
 $this->serviceName = $service_type;
 
    switch($group_type) {          
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
 
 $stmt->close();

}
//--------------------------------------------------------------------------------------
function loadDurationTypes() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT DISTINCT service_term FROM service_cost WHERE service_key = '$this->serviceKey'");
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

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
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

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_key, location_id FROM bundle_lists WHERE bundle_id ='$this->bundleId'"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key, $location_id); 

         while ($stmt->fetch()) {   
                   
                   $this->clubId = $location_id;
                   $this->serviceKey = $service_key;
                   $this->loadServiceName();
                   $this->loadClubName();
                   $this->loadDurationTypes();
                                     
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
			                 $this->serviceName
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
function loadServiceList() {

$this->loadCurrentList();

}
//--------------------------------------------------------------------------------------
function getTableContent() {
         return($this->tableContent);
         }



}
//==================================================
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

  $list = new serviceListTwo();
  $list-> setTypeId($schedule_type);
  $list-> setLocationId($location_id);
  $list-> setBundleId($bundle_id);
  $list-> loadServiceList();
  $service_list = $list-> getTableContent();
  
  echo"$service_list";

  }










