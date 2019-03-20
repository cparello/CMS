<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class snapShotContentGuest {

private  $passId =null;
private  $passTitle = null;
private  $duration = null;
private  $passDateEnd = null;
private  $passDateStart = null;
private  $serviceList = null;
private  $serviceKey = null;
private  $guestName = null;
private  $barCodeInt = null;
private  $barCode = null;
private  $locationId = null;
private  $serviceLocation = null;
private  $guestPassLocationId = null;
private  $guestPassType = null;
private  $locationArray = null;
private  $allBit = null;
private  $borderColor = null;
private  $attendanceFlag = null;
private  $guestFlag = null;
private  $guestFlagText = null;
private  $attendanceHistory = null;


function setBarCodeInt($barCodeInt) {
          $this->barCodeInt = $barCodeInt;
          }
function setLocationId($locationId) {
          $this->locationId = $locationId;
          }
function setPassId($passId) {
          $this->passId = $passId;
          }
function setDuration($duration) {
          $this->duration = $duration;
          }
function setGuestName($guestName) {
          $this->guestName = $guestName;
          }       
function setPassDateEnd($passDateEnd) {
          $this->passDateEnd = $passDateEnd;
          }            
function setPassDateStart($passDateStart) {
          $this->passDateStart = $passDateStart;
          }                
       
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}       
//=======================================================
function loadGuestPassType() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pass_title, location_id FROM guest_pass WHERE pass_id='$this->passId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passTitle, $locationId);
$stmt->fetch();

$this->passTitle = "$this->duration Day $passTitle";
$this->guestPassLocationId = $locationId;

$endDate = date('m/d/Y', strtotime($this->passDateEnd));
$this->guestPassType = "$this->passTitle<br>(Exp. $endDate)";

$stmt->close();


}
//-------------------------------------------------------------------------------------------------
function loadServiceList() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type, club_id FROM service_info WHERE service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceType, $clubId);
$stmt->fetch();
$stmt->close();

$result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$clubId'");
                       $row = mysqli_fetch_array($result, MYSQLI_NUM);
                       $this->serviceLocation = $row[0];
                                  
                                  if($this->serviceLocation == "")  {
                                     $this->serviceLocation = 'All Locations';
                                     $clubId = '0';
                                     }


$this->serviceList .= "$serviceType $this->serviceLocation<br>";
$this->locationArray .="$clubId,";

}
//----------------------------------------------------------------------------------------------------------------
function loadServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_key FROM guest_pass_services WHERE pass_id='$this->passId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceKey);

while ($stmt->fetch()) { 
        $this->serviceKey = $serviceKey;
        $this->loadServiceList();
        }


$stmt->close();

}
//-------------------------------------------------------------------------------------------------
function loadGuestFlag() {

//first check accessibility
$locationArray = explode(",", $this->locationArray);
$allClubsId = '0';
  if(!in_array($this->locationId, $locationArray)) {
    
      if(in_array($allClubsId, $locationArray)) {
         $this->borderColor = '#33FF00';
         $this->guestFlagText = 'Guest Access Granted';
         $this->attendanceFlag = 'N';
         $this->allBit = '1';
         
         }else{
         
         $this->borderColor = '#FF3300'; 
         $this->guestFlagText = 'Non Access Guest';
         $this->attendanceFlag = 'Y'; 
         $this->allBit = '0';
         }
                  
         $this->guestFlag ="
         <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
         <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->guestFlagText</div>";       
         
     }
     
if(in_array($this->locationId, $locationArray)) {   

         $this->borderColor = '#33FF00';
         $this->guestFlagText = 'Guest Access Granted';
         $this->attendanceFlag = 'N';

    }else{
    
          if($this->allBit == '1') {
             $this->borderColor = '#33FF00';
             $this->guestFlagText = 'Guest Access Granted';
             $this->attendanceFlag = 'N';
            }else{
             $this->borderColor = '#FF3300'; 
             $this->guestFlagText = 'Non Access Guest';
             $this->attendanceFlag = 'Y';            
            }
      
         $this->guestFlag ="
         <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
         <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->guestFlagText</div>";       
            
   }
     
//now we check to see if the pass has expired   
$endDateInt = strtotime($this->passDateEnd);
$currentDateInt = time();

if($currentDateInt > $endDateInt) {
   $this->borderColor = '#FF3300'; 
   $this->guestFlagText = 'Guest Pass Expired';
   $this->attendanceFlag = 'Y'; 
   $this->guestFlag ="
   <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
   <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->guestFlagText</div>";      
  }


}
//-------------------------------------------------------------------------------------------------
function parsePhotoImage() {

$photoName = 'no_photo.jpg';
$this->imageTag = "<img src=\"../memberphotos/$photoName\" width=\"150\" height=\"175\" style=\"border:5px solid $this->borderColor\" onError=\"this.src = '../memberphotos/no_photo.jpg'\">";
            
}
//-------------------------------------------------------------------------------------------------
function loadGuestFreq() {

 $guestSince =  date('M j, Y', strtotime($this->passDateStart)); 
 
 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT MAX(attendance_date) FROM guest_attendance WHERE  location_id = '$this->locationId' AND bar_code='$this->barCodeInt'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($attendance_date);
 $stmt->fetch();

 if($attendance_date == "") {
    $attendanceDate = 'NA';
    }else{
    $attendanceDate =  date('M j, Y  H:i', strtotime($attendance_date));   
    }
   
 $this->attendanceHistory  = "Guest Since:  $guestSince<br>Last Attended:  $attendanceDate";
   
$stmt->close();

}
//-------------------------------------------------------------------------------------------------
function insertAttendanceRecord() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO guest_attendance VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiss', $locationId, $barcode, $attendanceDate, $attendanceFlag);

$locationId = $this->locationId;
$barcode = $this->barCodeInt;
$attendanceDate = date("Y-m-d H:i:s");
$attendanceFlag = $this->attendanceFlag;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 


$sql = "INSERT INTO attendance_records VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissss', $locationId, $barcode, $attendanceDate, $attendanceFlag, $attendanceType, $checkInType);

$locationId = $this->locationId;
$barcode = $this->barCodeInt;
$attendanceDate = date("Y-m-d H:i:s");
$attendanceFlag = $this->attendanceFlag;
$attendanceType = "GP";
$checkInType = "BC";

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//-------------------------------------------------------------------------------------------------
function loadGuestPassStatus() {

$this->loadGuestPassType();
$this->loadServices();
$this->loadGuestFlag();
$this->parsePhotoImage();
$this->loadGuestFreq();
$this->insertAttendanceRecord();

}
//------------------------------------------------------------------------------------------------
function getGuessPassType() {
       return($this->guestPassType);
       }
function getServiceList() {
       return($this->serviceList);
       }
function getGuestFlag() {
       return($this->guestFlag);
       }
function getImageTag() {
       return($this->imageTag);
       }
function getAttendanceHistory() {
       return($this->attendanceHistory);
       }


}
//=======================================================

include  "../dbConnect.php";    
     
$barcode_int = $_REQUEST['barcode_int'];
$location_id = $_REQUEST['location_id'];

//get the basic member info
$result = $dbMain ->query(" SELECT pass_id, start_date, end_date, guest_name, duration FROM guest_register WHERE bar_code = '$barcode_int'"); 
$row_count = $result->num_rows; 

     if($row_count == 0) {
         $message = 1;
         $dbMain->close();     
         echo"$message";     
         exit;
       
         }else{
       
         $row = $result->fetch_array(MYSQLI_NUM);
         $pass_id = $row[0]; 
         $start_date = $row[1];
         $end_date = $row[2];
         $guest_name = $row[3];
         $duration = $row[4];
         
         $parseGuest = new snapShotContentGuest();
         $parseGuest-> setBarCodeInt($barcode_int);
         $parseGuest-> setLocationId($location_id);
         $parseGuest-> setPassId($pass_id);
         $parseGuest-> setPassDateStart($start_date);
         $parseGuest-> setPassDateEnd($end_date);
         $parseGuest-> setGuestName($guest_name);
         $parseGuest-> setDuration($duration);
         $parseGuest-> loadGuestPassStatus();
         
         $guest_pass_type = $parseGuest-> getGuessPassType();
         $guest_flag = $parseGuest-> getGuestFlag();         
         $service_list = $parseGuest-> getServiceList();
         $image_tag = $parseGuest-> getImageTag();
         $attendance_history = $parseGuest-> getAttendanceHistory();
         $association = 'Single Guest';
         $emergency_info = 'NA';
         
         $content_array = "$guest_name|$image_tag|$emergency_info|$association|$guest_pass_type|$guest_flag|$service_list|$attendance_history";
        echo"$content_array";     
        exit;      
         }

?>