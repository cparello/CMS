<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  serviceNameDrops {

private  $clubId = null;
private  $employeeArray = null;
private  $serviceNameDrops = null;
private  $userId = null;
private  $serviceName = null;
private  $serviceOption = null;
        
function setEmployeeArray($employeeArray) {
       $this->employeeArray = $employeeArray;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadServiceName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type  FROM service_info WHERE  service_key = '$this->serviceKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_type);
$stmt->fetch();

$this->serviceName = $service_type;

$stmt->close();
}
//---------------------------------------------------------------------------------
function loadServiceNameDrops() {

$dbMain = $this->dbconnect();

$tempTable = "CREATE TEMPORARY TABLE IF NOT EXISTS `services` (
          `service_key` INT(20) NOT NULL,
          `service_name` CHAR(60) NOT NULL
          )";

   
$dbMain-> query($tempTable);

  $employeeArray = explode('|', $this->employeeArray);
  
     foreach($employeeArray AS $userId) {
                                      
                      $stmt = $dbMain ->prepare("SELECT DISTINCT service_key  FROM sales_info WHERE  user_id = '$userId' ");
                      $stmt->execute();      
                      $stmt->store_result();      
                      $stmt->bind_result($service_key);
                      $rowCount = $stmt->num_rows;
     
                           if($rowCount > 0) {
                                   while ($stmt->fetch()) {
                                             $this->serviceKey = $service_key;
                                             $this->loadServiceName();
                                             $dbMain-> query("INSERT INTO services (service_key, service_name)VALUES ('$this->serviceKey', '$this->serviceName')");
                                            }                             
                              }      
                  }
   $stmt->close();

   $stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name  FROM services WHERE  service_key != '' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($serviceKey, $serviceName);
   $rowCount = $stmt->num_rows;
   
    if($rowCount > 0) {
    
          while ($stmt->fetch()) {   
                    $this->serviceOption .= "<option value=\"$serviceKey\">$serviceName</option>\n"; 
                   }
 
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Service Type</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Service Type</option>\n<option value=\"0\">All Service Types</option>\n";
                   }
              
                   $this->serviceNameDrops = "$dropHeader$this->serviceOption"; 
 
 
      }else{
      $this->serviceNameDrops = '0';      
      }
  
 
   $stmt->close();


}
//---------------------------------------------------------------------------------
function getServiceNameDrops() {
           return($this->serviceNameDrops);
           }


}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$employee_array = $_REQUEST['employee_array'];

if($ajax_switch == 1) {

$service = new serviceNameDrops();
$service-> setEmployeeArray($employee_array);
$service-> loadServiceNameDrops();
$service_name_drops = $service-> getServiceNameDrops();

echo"$service_name_drops";
exit;


}
?>