<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  guestPassServices{

private $clubId;
private $dropList;
private $userId;
private $serviceAnd = "AND service_type LIKE '%Guest%'";
private $serviceSwitch = null;
private $groupType = 'S';
private $scriptSalt = 1;


   
function setClubId($clubId) {
$this->clubId = $clubId;
}

function setDropList($dropList) {
$this->dropList = $dropLis;
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

function setScriptSalt($scriptSalt) {
$this->scriptSalt =$scriptSalt;
}


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//============================================================================
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
$selectHeader = "<select multiple=\"yes\" size=\"5\" name=\"service_types1[]\" id=\"service_types1\">\n";                 
            
if($this->clubId == 0) {
  $this->serviceAnd = null;
  }else{
  $this->serviceAnd = "OR club_id= '0'";
  }

   
$stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE club_id ='$this->clubId' $this->serviceAnd"); 
      if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		   
      $stmt->store_result();      
      $stmt->bind_result($service_key,$service_type,$service_desc,$club_id,$group_type, $bundle_class); 
      
      
    while ($stmt->fetch()) {                            
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
                                     }
                                 
                              //if(preg_match("/\bguest\b/i", $service_type)) {      
                                  $options .= "<option value=\"$club_id|$service_key\">$service_type  $service_location</option>\n";
                                  //}
                                                      
                }
                
                               //if there are no options available state it here
                               if($options == null)  {
                                   $options = '<option value="">Currently no new Services available</option>';                              
                                  }
                
                
                               //hear is the object for multiple records
                                $drop_select = "$selectHeader  $options </select>";
                                
              
                                $this->dropList = $drop_select;  
                               
                                return($this->dropList);
                                
 $stmt->close();                               
 }        
      
//====================================================================   
function getDropList() {
return($this->dropList);
}


      
}

//======================================================================
//this handles ajax calls when a sales position is clicked on the employee type list
$service_switch = $_REQUEST['service_switch'];
$club_id = $_REQUEST['club_id'];

if($service_switch == 1)  {

$service_drop = new guestPassServices();
$service_drop->setClubId($club_id);
$service_drop->setServiceSwitch($service_switch);
$services_list = $service_drop->makeDropDown(); 

echo"$services_list";
exit;
}


//=====================================================================





     
?>