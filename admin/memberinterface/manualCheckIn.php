<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class manualCheckIn {

private $memberId = null;
private $locationId = null;
private $memberFullName = null;
private $successBit = null;
private $successArray = null;
private $contractKey = null;
private $membershipType = null;


function setMemberId($memberId) {
          $this->memberId = $memberId;
          }
function setLocationId($locationId) {
          $this->locationId = $locationId;
          }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//======================================================
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_name FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_name);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               
                    while ($stmt->fetch()) {  

                               $this->serviceName = $service_name;  
                               
                               if(preg_match("/Membership/i", $this->serviceName)) {
                                   $this->membershipType = true;
                                  }
                                                                                             
                                
                             } //end while
                             
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

}
//-----------------------------------------------------------------------------------------------
function loadMonthlyServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_name FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_name);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
                
               }else{
               
                    while ($stmt->fetch()) {  

                               $this->serviceName = $service_name;
                               
                                 if(preg_match("/Membership/i", $this->serviceName)) {
                                     $this->membershipType = true;
                                    }
                                      
                              
                             }
               }
               
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      

}                      
//-----------------------------------------------------------------------------------------------
function loadMemberName() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, contract_key  FROM member_info WHERE member_id='$this->memberId' ");  
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name, $contract_key);
  $stmt->fetch();

  $this->memberFullName = "$first_name $middle_name $last_name";
  $this->contractKey = $contract_key;

  $stmt->close();

}
//-----------------------------------------------------------------------------------------------
function insertCheckInRecord() {

$this->loadMemberName();

$dbMain = $this->dbconnect();
$sql = "INSERT INTO attendance_records VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissss', $locationId, $memberId, $attendanceDate, $attendanceFlag, $attendanceType, $checkInType);

$locationId = $this->locationId;
$memberId = $this->memberId;
$attendanceDate = date("Y-m-d H:i:s");
$attendanceFlag = 'N';
$checkInType = 'MA';

 if($this->membershipType == null) {
   $attendanceType = "SA"; 
   }else{
   $attendanceType = "MA";   
   }


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->successBit = '1';
   }

$this->successArray = "$this->memberFullName|$this->successBit";

$stmt->close(); 
}
//======================================================
function getSuccessArray() {
        return($this->successArray);
        }


}

$member_id = $_REQUEST['member_id'];
$location_id = $_SESSION['location_id'];

$checkIn = new manualCheckIn();
$checkIn-> setLocationId($location_id);
$checkIn-> setMemberId($member_id);
$checkIn-> loadMemberName();
$checkIn-> loadPifServices();
$checkIn-> loadMonthlyServices();
$checkIn-> insertCheckInRecord();
$success_array = $checkIn-> getSuccessArray();

echo"$success_array ";
exit;

?>