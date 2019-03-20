<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  saveScheduleName {

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleName = null;
private  $typeStatus = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }

function setBundleName($bundleName) {
       $this->bundleName = $bundleName;
       }
       
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------------------  
function checkDuplicates() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM bundle_type WHERE bundle_name= '$this->bundleName'  AND location_id= '$this->locationId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();

    if($count > 0) {
       $this->typeStatus = "1|$this->bundleName";
       }else{
       $this->typeStatus = null;
       }
       
if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	printf("Error: %s. check duplicates \n", $stmt->error);
   }	       
       
 $stmt->close();

return $this->typeStatus;

}
//---------------------------------------------------------------------------------------
function loadLocationId() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT location_id FROM schedule_type WHERE type_id = '$this->typeId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($location_id); 
 $stmt->fetch();
 
 $this->locationId = $location_id;

if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	printf("Error: %s. load location id\n", $stmt->error);
   }		

$stmt->close();

}
//--------------------------------------------------------------------------------------
function saveName() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO bundle_type VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isii', $bundleId, $bundleName, $typeId, $locationId);

$bundleId = null;
$bundleName = $this->bundleName;
$typeId = $this->typeId;
$locationId = $this->locationId;

if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	printf("Error: %s. save name\n", $stmt->error);
   }		

$this->bundleId = $stmt->insert_id; 
$stmt->close(); 

}
//--------------------------------------------------------------------------------------
function loadBundleDrops() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT bundle_id, bundle_name, location_id FROM bundle_type WHERE bundle_id != '' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bundle_id, $bundle_name, $location_id); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
                                    
               if($this->bundleId ==  $bundle_id) {
                  $selected = 'selected';
                  }else{
                  $selected = "";
                  }
                                                  
                 $type_select .= "<option value=\"$bundle_id,$location_id\">$bundle_name</option>\n";         
              }

$stmt->close();  
   
   $choose_type = "<option value>Select Schedule Bundle</option>\n";
             
    return "2|$this->bundleName|$this->bundleId|$choose_type$type_select";            

}
//--------------------------------------------------------------------------------------





}
//=================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_name = $_REQUEST['bundle_name'];

if($ajax_switch == "1") {

$bundle_name = preg_replace("/[[:blank:]]+/"," ",$bundle_name);

$save = new saveScheduleName();
$save-> setTypeId($schedule_type);
$save-> setBundleName($bundle_name);
$save-> loadLocationId();
$type_status = $save-> checkDuplicates();

if($type_status == null) {
   $save-> saveName();
   $type_status = $save-> loadBundleDrops();
   echo"$type_status";
   
   }else{
    echo"$type_status";
   }


exit;

}
//--------------------------------------------------------------------------------------




?>