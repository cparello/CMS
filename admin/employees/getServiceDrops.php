<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  makeServiceDrops{

private $clubId;
private $empTypeCat;
private $dropList;
private $serviceHeader;
private $userId;
private $serviceSql = 'service_info';
private $holder;
private $serviceAnd = null;
private $serviceSwitch = null;
private $groupType;
private $scriptSalt = 1;

function setHolder($holder) {
$this->holder = $holder;
}
   
function setClubId($clubId) {
$this->clubId = $clubId;
}

function setEmpTypeCat($empTypeCat) {
$this->empTypeCat = $empTypeCat;
}

function setDropList($dropList) {
$this->dropList = $dropLis;
}

function setServiceHeader($serviceHeader) {
$this->serviceHeader = $serviceHeader;
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

function setGroupType($groupType) {
$this->groupType = $groupType;
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
function createServiceAnd()  {

switch($this->serviceSwitch) {
        case"1":
        $this->serviceAnd = "OR club_id='0'";
        break;
        case"2":
        $this->serviceAnd = "OR club_id='0' AND group_type = '$this->groupType'";
        break;
        case"3":
        $this->serviceAnd = "OR club_id='0' AND group_type = '$this->groupType'";
        break;
        }

}
//=============================================================================
function createCategoryDrops()   {

//this passes the dbconeect object if comming from the crete parse list method
$dbMain =$this->holder;

//if the make drop down method is called directly it create a new instance of the database connect object
if($dbMain == null) {
$dbMain = $this->dbconnect();
}

switch($this->empTypeCat) {          
                       case"1":
                       $selectHeader = "<select name=\"category_types1[]\" id=\"category_types1\" onChange=\"showSelect$this->scriptSalt(1, this.value);\">\n<option value=\"\">Select Category</option>\n";                 
                       break;
                       case"2":
                       $selectHeader = "<select name=\"category_types2[]\" id=\"category_types2\"onChange=\"showSelect$this->scriptSalt(2, this.value);\">\n<option value=\"\">Select Category</option>\n";                      
                       break;
                       case"3":
                       $selectHeader = "<select name=\"category_types3[]\" id=\"category_types3\"onChange=\"showSelect$this->scriptSalt(3, this.value);\">\n<option value=\"\">Select Category</option>\n"; 
                       break;
                       case"4":
                       $selectHeader = "<select name=\"category_types4[]\" id=\"category_types4\"onChange=\"showSelect$this->scriptSalt(4, this.value);\">\n<option value=\"\">Select Category</option>\n"; 
                       break;                       
                       }                     





$stmt = $dbMain ->prepare("SELECT DISTINCT group_type FROM $this->serviceSql WHERE club_id ='$this->clubId' OR club_id='0'"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($group_type); 

         while ($stmt->fetch()) {   


            switch($group_type) {          
                       case"S":
                       $categoryName = "Single Services"; 
                       $categoryValue = "$group_type|$this->clubId";
                       break;
                       case"F":
                       $categoryName = "Family Services"; 
                       $categoryValue = "$group_type|$this->clubId";                    
                       break;
                       case"B":
                       $categoryName = "Business Services"; 
                       $categoryValue = "$group_type|$this->clubId";
                       break;
                       case"O":
                       $categoryName = "Organization Services"; 
                       $categoryValue = "$group_type|$this->clubId";
                       break;                       
                       }   

                       $options .= "<option value=\"$categoryValue\">$categoryName</option>\n";

                 }
                 
           if($options == null)  {
              $options = '<option value="">Categories Unavailable</option>';                              
                                  }
           
           
           $drop_select = "$selectHeader  $options </select>";
           
                                 //here is the object for multiple records
                                $drop_select = "$selectHeader  $options </select>";
                                             
                                $this->categoryList = $drop_select;  
                                $this->categoryHeader = 'Available Categories:';
                                return($this->categoryList);
                                
 $stmt->close();  
           
}
//==============================================================================
function createParseList() {

if($this->clubId == null)  {
   $this->dropList = null;
   $this->serviceHeader = null;
   return null;
 }

$dbMain = $this->dbconnect();

$dbMain->query("CREATE TEMPORARY TABLE temp_service_info  LIKE service_info");
$dbMain->query("INSERT INTO temp_service_info SELECT * FROM service_info WHERE club_id='$this->clubId' OR club_id='0' ");

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM commission_compensation WHERE  user_id='$this->userId'"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key); 

 while ($stmt->fetch()) {          
          $dbMain->query("DELETE FROM temp_service_info WHERE service_key ='$service_key'");
          }
$this->serviceSql = 'temp_service_info';

$this->serviceAnd = "OR club_id='0'";
$this->holder = $dbMain;
$this->makeDropDown();
$this->scriptSalt = 2;
$this->createCategoryDrops();

//reset to original defaults
$this->serviceSql = 'service_info';

}
//==============================================================================
function makeDropDown()   { 

//this sets the visibel service list to a null value if it is not a sales position
if($this->clubId == null)  {
   $this->dropList = null;
   $this->serviceHeader = null;
   return null;
 }

//this passes the dbconeect object if comming from the crete parse list method
$dbMain =$this->holder;

//if the make drop down method is called directly it create a new instance of the database connect object
if($dbMain == null) {
$dbMain = $this->dbconnect();
}

//create the select type  
  switch($this->empTypeCat) {          
                       case"1":
                       $selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types1[]\" id=\"service_types1\">\n";                 
                       break;
                       case"2":
                       $selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types2[]\" id=\"service_types2\">\n";                     
                       break;
                       case"3":
                       $selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types3[]\" id=\"service_types3\">\n"; 
                       break;
                       case"4":
                       $selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types4[]\" id=\"service_types4\">\n"; 
                       break;                       
                       }                     

   
$stmt = $dbMain ->prepare("SELECT * FROM $this->serviceSql WHERE club_id ='$this->clubId' $this->serviceAnd"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key,$service_type,$service_desc,$club_id,$group_type,$bundle_class); 
      
      
    while ($stmt->fetch()) {   
                        
    
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All';
                                     }
                                    
                                   if(!preg_match("/\bguest\b/i", $service_type)) {                                    
                                       $options .= "<option value=\"$club_id|$service_key\">$service_type  $service_location</option>\n";
                                      }               
                }
                
                               //if there are no options available state it here
                               if($options == null)  {
                                   $options = '<option value="">Currently no new Services available</option>';                              
                                  }
                
                
                               //hear is the object for multiple records
                                $drop_select = "$selectHeader  $options </select>";
                                
              
                                $this->dropList = $drop_select;  
                                $this->serviceHeader = 'Available Service Types:';
                                return($this->dropList);
                                
 $stmt->close();                               
 }        
      
//====================================================================   
function getDropList() {
return($this->dropList);
}

function getServiceHeader() {
return($this->serviceHeader);
}

function getCategoryHeader() {
return($this->categoryHeader);
}

function getCategoryList() {
return($this->categoryList);
}

      
}

//======================================================================
$emp_type = $_REQUEST['emp_type'];
$serve_loc = $_REQUEST['serve_loc'];
$service_switch = $_REQUEST['service_switch'];
$sid = $_REQUEST['sid']; 
//this handles ajax calls when a sales position is clicked on the employee type list
if($service_switch == 1)  {

$serve_loc_array = explode("|", $serve_loc);
$club_id = $serve_loc_array[1];

$service_drop = new makeServiceDrops();
$service_drop->setEmpTypeCat($emp_type);
$service_drop->setClubId($club_id);
$service_drop->setServiceSwitch($service_switch);
$service_drop->createServiceAnd();
$services_list = $service_drop->makeDropDown(); 
$category_list = $service_drop->createCategoryDrops();

echo"$services_list:$category_list";
exit;
}

//----------------------------------------------------------------------------------------------
//this is for specific group types
if($service_switch == 2)  {

$serve_loc_array = explode("|", $serve_loc);
$group_type = $serve_loc_array[0];
$club_id = $serve_loc_array[1];

$service_drop = new makeServiceDrops();
$service_drop->setEmpTypeCat($emp_type);
$service_drop->setClubId($club_id);
$service_drop->setGroupType($group_type);
$service_drop->setServiceSwitch($service_switch);
$service_drop->createServiceAnd();
$services_list = $service_drop->makeDropDown(); 

echo"$services_list";
exit;
}

//---------------------------------------------------------------------------------------------
if($service_switch == 3)  {

$serve_loc_array = explode("|", $serve_loc);
$group_type = $serve_loc_array[0];
$club_id = $serve_loc_array[1];
$employee_id = $serve_loc_array[2];

$service_drop = new makeServiceDrops();
$service_drop->setEmpTypeCat($emp_type);
$service_drop->setClubId($club_id);
$service_drop->setGroupType($group_type);
$service_drop->setUserId($employee_id);
$service_drop->setServiceSwitch($service_switch);
$service_drop->createServiceAnd();
$service_drop->createParseList();
$services_list = $service_drop->getDropList();

echo"$services_list";
exit;

}
//=====================================================================





     
?>