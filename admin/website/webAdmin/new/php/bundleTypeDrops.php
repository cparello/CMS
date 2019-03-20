<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  bundleTypeDrops{

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleName = null;
private  $rowCount = null;
private  $headerType = null;


function setLocationId($locationId) {
        $this->locationId = $locationId;
         }
 
function setTypeId($typeId) {
        $this->typeId = $typeId;
        }

function setHeaderType($headerType) {
        $this->headerType = $headerType;
        }


//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function loadSelectedMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT bundle_id, bundle_name, location_id FROM bundle_type WHERE type_id = '$this->typeId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bundle_id, $bundle_name, $location_id); 
 $rowCount = $stmt->num_rows;

 $this->rowCount = $rowCount;

if($rowCount > 0) {

    while ($stmt->fetch()) { 
    
               $type_select .= "<option value=\"$bundle_id,$location_id\">$bundle_name</option>\n";         
            }

  }    
  
     switch($this->headerType) {
        case 1:
        $choose_type = "<option value>Select Class Type</option>\n";
        break;
        default:
        $choose_type = "<option value>Select Schedule Bundle</option>\n";
        break;
       }
    
             
return "$choose_type$type_select";            
 

}
//-----------------------------------------------------------------------------------------------------
function loadFullMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT bundle_id, bundle_name, location_id FROM bundle_type WHERE bundle_id != '' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bundle_id, $bundle_name, $location_id); 
 $rowCount = $stmt->num_rows;

if($rowCount > 0) {

    while ($stmt->fetch()) { 
                                    
               $type_select .= "<option value=\"$bundle_id,$location_id\">$bundle_name</option>\n";         
            }

}    
   
   $choose_type = "<option value>Select Schedule Bundle</option>\n";
             
   return "$choose_type$type_select";            

$stmt->close();
}
//-----------------------------------------------------------------------------------------------------------
function getRowCount() {
         return($this->rowCount);
         }

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$header_type = $_REQUEST['header_type'];

if($ajax_switch == "1") {
//echo "$schedule_type";
//exit;
$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setTypeId($schedule_type);
$bundle_type_drops = $bundleDrops-> loadSelectedMenu();
$row_count = $bundleDrops-> getRowCount();

if($row_count == 0) {
   $bundle_type_drops  = "1|bull";
   }else{
   $bundle_type_drops = "2|$bundle_type_drops"; 
   }
   
echo"$bundle_type_drops";
exit;

}
//-------------------------------------------------------------------------------

if($ajax_switch == "2") {

$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setTypeId($schedule_type);
$bundleDrops-> setHeaderType($header_type);
$bundle_type_drops = $bundleDrops-> loadSelectedMenu();
$row_count = $bundleDrops-> getRowCount();

if($row_count == 0) {
   $bundle_type_drops  = "1|bull";
   }else{
   $bundle_type_drops = "2|$bundle_type_drops"; 
   }
   
echo"$bundle_type_drops";
exit;
}









?>