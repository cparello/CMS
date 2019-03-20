<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class employeeTimeClock {

private $employeePhoto = null;
private $employeeName = null;
private $employeeType = null;
private $idCard = null;
private $typeKey = null;
private $userId = null;
private $clockStatus = null;
private $clockTime = null;
private $timeClockKey = null;




function setIdCard($idCard) {
       $this->idCard = $idCard;
       }
function setTypeKey($typeKey) {
       $this->typeKey = $typeKey;
       }
function setUserId($userId) {
       $this->userId = $userId;
       }
       
       

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================
function loadEmployeeName() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id = '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname);
   $stmt->fetch();

   $this->employeeName = "$emp_fname $emp_mname $emp_lname";

$stmt->close();   

}
//-------------------------------------------------------------------------------------------------------------
function loadEmployeeType() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT employee_type, club_id FROM employee_type WHERE type_key = '$this->typeKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($employee_type, $club_id);
   $stmt->fetch();
   $stmt->close();

$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_name);
   $stmt->fetch();
   $stmt->close();

$this->employeeType = "$employee_type  $club_name";

}
//-------------------------------------------------------------------------------------------------------------
function loadEmployeePhoto() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT member_photo FROM employee_photo WHERE user_id = '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($employee_photo);
   $stmt->fetch();
   $stmt->close();

     if($employee_photo == "")  {
        $photoName = 'no_photo.jpg';
        }else{
        $photoName = $employee_photo;
        }

$this->employeePhoto = "<img src=\"../employeephotos/$photoName\" width=\"150\" height=\"175\" onClick=\"return loadCamera('$this->userId','$this->employeeName');\" onError=\"this.src = '../memberphotos/no_photo.jpg'\">";
             
}
//-------------------------------------------------------------------------------------------------------------
function updateTimeClock() {

$dbMain = $this->dbconnect();
$sql = "UPDATE timeclock SET clock_out= ? WHERE timeclock_key = '$this->timeClockKey'";						
		$stmt = $dbMain->prepare($sql);
		$stmt->bind_param('s',$clock_out);						

 $clock_out = date("Y-m-d H:i:s");

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }

$this->clockStatus = '<span style="color: #0066CC">CLOCKED OUT</span>';
$this->clockTime = date('F j, Y   H:i');

}
//-------------------------------------------------------------------------------------------------------------
function insertTimeClock() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO timeclock VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiss', $timeClockKey, $userId, $idCard, $inDateTime, $outDateTime); 

$timeClockKey = $this->timeClockKey;
$userId = $this->userId;
$idCard = $this->idCard;
$inDateTime = date("Y-m-d H:i:s");
$outDateTime = '0000-00-00 00:00:00';

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }	
$stmt->close();

$this->clockStatus = '<span style="color: #339900">CLOCKED IN</span>';
$this->clockTime = date('F j, Y   H:i');

}
//-------------------------------------------------------------------------------------------------------------
function parseTimeClock() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT MAX(timeclock_key) FROM timeclock WHERE user_id = '$this->userId' AND id_card='$this->idCard' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($timeclock_key);
   $stmt->fetch();
   $stmt->close();


   $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE timeclock_key='$timeclock_key' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($clock_in, $clockout);
   $stmt->fetch();
   $row_count = $stmt->num_rows;
   $stmt->close();

   if($row_count == 0) {
      //we do an insert
      $this->insertTimeClock();
   
     }else{
      
          if($clockout == '0000-00-00 00:00:00') {
             //do an update to set the clock out time
             $this->timeClockKey = $timeclock_key;
             $this->updateTimeClock();
             }else{
             //do an insert as a clockin
             $this->insertTimeClock();
             }
          
     }


}
//-------------------------------------------------------------------------------------------------------------
function loadTimeClock() {

$this->loadEmployeeName();
$this->loadEmployeeType();
$this->loadEmployeePhoto();
$this->parseTimeClock();

}
//-------------------------------------------------------------------------------------------------------------

function getEmployeePhoto() {
    return($this->employeePhoto);
    }
function getEmployeeName() {
    return($this->employeeName);
    }
function getEmployeeType() {
    return($this->employeeType);
    }
function getClockStatus() {
    return($this->clockStatus);
    }    
function getClockTime() {
    return($this->clockTime);
    }     

}
//=====================================================================
include  "../dbConnect.php";          
$id_card = $_REQUEST['id_card'];
    
//get the basic member info
$result = $dbMain ->query(" SELECT type_key, user_id FROM basic_compensation WHERE id_card = '$id_card'"); 
$row_count = $result->num_rows; 

     if($row_count == 0) {
         $message = 1;
         $dbMain->close();     
         echo"$message";     
         exit;
       
         }else{
       
         $row = $result->fetch_array(MYSQLI_NUM);
         $type_key = $row[0]; 
         $user_id = $row[1]; 
         
         $parseEmployee = new employeeTimeClock();
         $parseEmployee-> setIdCard($id_card);
         $parseEmployee-> setTypeKey($type_key);
         $parseEmployee-> setUserId($user_id);
         
         $parseEmployee-> loadTimeClock();
         
         $employee_name = $parseEmployee-> getEmployeeName();
         $employee_photo = $parseEmployee-> getEmployeePhoto();
         $employee_type = $parseEmployee-> getEmployeeType();
         $clock_status = $parseEmployee-> getClockStatus();
         $clock_time = $parseEmployee-> getClockTime();

         $content_array = "$employee_name|$employee_photo|$id_card|$employee_type|$clock_status|$clock_time"; 
        
         echo"$content_array";     
         exit;                                                                                                                  
      }
 
?>