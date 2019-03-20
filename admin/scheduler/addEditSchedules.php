<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  addEditSchedules{

private  $scheduleId = null;
private  $typeId = null;
private  $bundleId = null;
private  $locationId = null;
private  $instructorId = null;
private  $roomId = null;
private  $classDays = null;
private  $classTime = null;
private  $classDate = null;
private  $recursive = null;
private  $capacity = null;
private  $minutes = null;
private  $activeStatus = null;
private  $insertStatus = null;
private  $updateStatus = null;
private  $deleteStatus = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }

function setBundleId($bundleId) {
        $this->bundleId = $bundleId;
         }

function setLocationId($locationId) {
        $this->locationId = $locationId;
         }

function setClassTime($classTime) {
        $this->classTime = $classTime;
        }

function setRecursive($recursive) {
        $this->recursive = $recursive;
        }
        
function setActiveStatus($activeStatus) {
        $this->activeStatus = $activeStatus;
        }     
        
function setCapacity($capacity) {
        $this->capacity  = $capacity;
        }                

function setMinutes($minutes) {
        $this->minutes  = $minutes;
        }   

function setClassDate($classDate) {
        $this->classDate  = $classDate;
        }   

function setClassDays($classDays) {
        $this->classDays = $classDays;
        }

function setInstructorId($instructorId) {
        $this->instructorId = $instructorId;
        }

function setRoomId($roomId) {
        $this->roomId = $roomId;
        }

function setScheduleId($scheduleId) {
        $this->scheduleId = $scheduleId;
        }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-----------------------------------------------------------------------------------------------------
function deleteClassSchedule() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM class_schedules WHERE schedule_id= ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $this->scheduleId);
			$stmt->execute();
			$stmt->close();
			$this->deleteStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }

}
//-----------------------------------------------------------------------------------------------------
function updateClassSchedule() {

   $dbMain = $this->dbconnect();
   $sql = "UPDATE class_schedules SET instructor_id= ?, room_id=?, class_days=?, class_time=?, class_date=?, recursive=?, capacity=?, minutes=?, active_status=?  WHERE schedule_id= '$this->scheduleId' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('iissssiis',  $instructorId, $roomId, $classDays, $classTime, $classDate, $recursive, $capacity, $minutes, $activeStatus);
   
   $instructorId = $this->instructorId;
   $roomId = $this->roomId;
   $classDays = $this->classDays;
   $classTime = $this->classTime;
   $classDate = $this->classDate;
   $recursive = $this->recursive;
   $capacity = $this->capacity;
   $minutes = $this->minutes;
   $activeStatus = $this->activeStatus;
   
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }	
   
  $this->updateStatus = 1; 
   
   
   $stmt->close(); 

}
//-----------------------------------------------------------------------------------------------------
function saveClassSchedule() {

    $dbMain = $this->dbconnect();
    $sql = "INSERT INTO class_schedules VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iiiiiissssiis', $scheduleId, $typeId, $bundleId, $locationId, $instructorId, $roomId, $classDays, $classTime, $classDate, $recursive, $capacity, $minutes, $activeStatus);

     $scheduleId = null;
     $typeId = $this->typeId;
     $bundleId = $this->bundleId;
     $locationId = $this->locationId;
     $instructorId = $this->instructorId;
     $roomId = $this->roomId;
     $classDays = $this->classDays;
     $classTime = $this->classTime;
     $classDate = $this->classDate;
     $recursive = $this->recursive;
     $capacity = $this->capacity;
     $minutes = $this->minutes;
     $activeStatus = $this->activeStatus;

      if(!$stmt->execute())  {
          // aver strange error her where it spits out a false error that report name can't be null but the var is saved
          printf("Error: %s. save class schedules\n", $stmt->error);
        }
        
   $this->scheduleId = $stmt->insert_id; 
   $this->insertStatus = 1;
   
   $stmt->close();  

}
//-----------------------------------------------------------------------------------------------------------
function getInsertStatus() {
          return($this->insertStatus);
          }

function getUpdateStatus() {
          return($this->updateStatus);
          }

function getScheduleId() {
          return($this->scheduleId);
          }

function getDeleteStatus() {
          return($this->deleteStatus);
          }

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_type = $_REQUEST['bundle_type'];
$class_hour = $_REQUEST['class_hour'];
$class_minutes = $_REQUEST['class_minutes'];
$am_pm = $_REQUEST['am_pm'];
$recursive_status = $_REQUEST['recursive_status'];
$active_status = $_REQUEST['active_status'];
$class_capacity = $_REQUEST['class_capacity'];
$session_minutes = $_REQUEST['session_minutes'];
$event_date = $_REQUEST['event_date'];
$day_array = $_REQUEST['day_array'];
$instructor_id = $_REQUEST['instructor_id'];
$room_id = $_REQUEST['room_id'];
$schedule_id = $_REQUEST['schedule_id'];
                     


if($ajax_switch == "1") {

//explode the bundle type to get the location id
$bundle_array = explode(",", $bundle_type);
$bundle_id = $bundle_array[0];
$location_id = $bundle_array[1];

//merge the class hours mins and ap pm for time conversion
if($class_minutes == "0") {
   $class_minutes = '00';
   }
if($class_minutes == "5") {
   $class_minutes = '05';
   }

//translate the time stamp to 24 hour clock   
$time_string = "$class_hour$class_minutes $am_pm";

$class_time  = date("H:i:s", strtotime($time_string));

//convert class date to mysql format if it exists
if($event_date != "") { 
  $class_date = date("Y-m-d", strtotime($event_date));
  }
  
$addEdit = new addEditSchedules();
$addEdit-> setTypeId($schedule_type);
$addEdit-> setBundleId($bundle_id);
$addEdit-> setLocationId($location_id);
$addEdit-> setClassTime($class_time);  
$addEdit-> setRecursive($recursive_status);
$addEdit-> setActiveStatus($active_status);
$addEdit-> setCapacity($class_capacity);
$addEdit-> setMinutes($session_minutes);
$addEdit-> setClassDate($class_date);
$addEdit-> setClassDays($day_array);
$addEdit-> setInstructorId($instructor_id);
$addEdit-> setRoomId($room_id);
$addEdit-> saveClassSchedule();
$insert_status = $addEdit-> getInsertStatus();
$schedule_id = $addEdit-> getScheduleId();
   

$save_status = "$insert_status|$schedule_id";
echo"$save_status";
exit;

}
//-------------------------------------------------------------------------------
if($ajax_switch == "2") {

//explode the bundle type to get the location id
$bundle_array = explode(",", $bundle_type);
$bundle_id = $bundle_array[0];
$location_id = $bundle_array[1];

//merge the class hours mins and ap pm for time conversion
if($class_minutes == "0") {
   $class_minutes = '00';
   }
if($class_minutes == "5") {
   $class_minutes = '05';
   }

//translate the time stamp to 24 hour clock   
$time_string = "$class_hour$class_minutes $am_pm";
$class_time  = date("H:i:s", strtotime($time_string));

//convert class date to mysql format if it exists
if($event_date != "") { 
  $class_date = date("Y-m-d", strtotime($event_date));
  }
  
$addEdit = new addEditSchedules();
$addEdit-> setScheduleId($schedule_id);
$addEdit-> setTypeId($schedule_type);
$addEdit-> setBundleId($bundle_id);
$addEdit-> setLocationId($location_id);
$addEdit-> setClassTime($class_time);  
$addEdit-> setRecursive($recursive_status);
$addEdit-> setActiveStatus($active_status);
$addEdit-> setCapacity($class_capacity);
$addEdit-> setMinutes($session_minutes);
$addEdit-> setClassDate($class_date);
$addEdit-> setClassDays($day_array);
$addEdit-> setInstructorId($instructor_id);
$addEdit-> setRoomId($room_id);
$addEdit-> updateClassSchedule();
$update_status = $addEdit-> getUpdateStatus();
$bull = 'bull';
   

$update_status = "$update_status|$bull";
echo"$update_status";
exit;

}
//---------------------------------------------------------------------------------
if($ajax_switch == "3") {

$delete = new addEditSchedules();
$delete-> setScheduleId($schedule_id);
$delete-> deleteClassSchedule();
$delete_status = $delete-> getDeleteStatus();
echo"$delete_status";
exit;

}



?>