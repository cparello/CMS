<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  loadScheduleList {

private  $scheduleId = null;
private  $typeId = null;
private  $bundleId = null;
private  $locationId = null;
private  $instructorId = null;
private  $instructorName = null;
private  $roomId = null;
private  $roomName = null;
private  $classDays = null;
private  $classTime = null;
private  $classDate = null;
private  $recursive = null;
private  $capacity = null;
private  $minutes = null;
private  $activeStatus = null;
private  $listStatus = null;
private  $scheduleList = null;
private  $listRows = null;
private  $daysList = null;
private  $scheduleArray = null;
private  $scheduleStatus = null;



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
function parseClassDays() {

$daysArray = str_split($this->classDays);
$sun = $daysArray[0];
$mon = $daysArray[1];
$tues = $daysArray[2];
$wed = $daysArray[3];
$thur = $daysArray[4];
$fri = $daysArray[5];
$sat = $daysArray[6];

if($sun != "0") {
   $sunTxt = 'Su';
   }else{
   $sunTxt = "";
   }
if($mon != "0") {
   $monTxt = 'M';
   }else{
   $monTxt = "";
   }
if($tues != "0") {
   $tuesTxt = 'Tu';
   }else{
   $tuesTxt = "";
   }
if($wed != "0") {
   $wedTxt = 'W';
   }else{
   $wedTxt = "";
   }
if($thur != "0") {
   $thurTxt = 'Th';
   }else{
   $thurTxt = "";
   }
if($fri != "0") {
   $friTxt = 'F';
   }else{
   $friTxt = "";
   }
if($sat != "0") {
   $satTxt = 'Sa';
   }else{
   $satTxt = "";
   }

$this->daysList = "$sunTxt $monTxt $tuesTxt $wedTxt $thurTxt $friTxt $satTxt";

}
//-----------------------------------------------------------------------------------------------------
function parseInstructorName() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT instructor_name FROM instructor_info WHERE  instructor_id = '$this->instructorId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($instructorName); 
   $stmt->fetch();

   $this->instructorName = $instructorName;

   $stmt->close();
}
//-----------------------------------------------------------------------------------------------------
function parseRoomName() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT room_name FROM room_names WHERE  room_id = '$this->roomId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($roomName); 
   $stmt->fetch();

   $this->roomName = $roomName;

   $stmt->close();
}
//-----------------------------------------------------------------------------------------------------
function parseListRows() {

$this->parseClassDays();
$this->parseInstructorName();
$this->parseRoomName();
$classTime  = date("g:i A", strtotime($this->classTime));

if($this->activeStatus == "Y") {
   $activeStatus = "Active";
   }else{
   $activeStatus = "On Hold";
   }

$this->listRows .="<tr class=\"stripe\">
<td class=\"black\">
$this->daysList
</td>
<td class=\"black\">
$classTime
</td>
<td class=\"black\">
$this->minutes
</td>
<td class=\"black\">
$this->recursive
</td>
<td class=\"black\">
$this->instructorName
</td>
<td class=\"black\">
$this->capacity
</td>
<td class=\"black\">
$this->roomName
</td>
<td class=\"black\">
$activeStatus
</td>
<td class=\"black\">
<form> 
<input type=\"submit\" class=\"button2\" id=\"$this->scheduleId\" value=\"Edit\"/>
</form>
</td>
<td class=\"black\">
<form>
<input type=\"submit\" class=\"button2\" id=\"$this->scheduleId\" value=\"Delete\"/>
<form>
</td>
</tr>\n";

    
     
}
//-----------------------------------------------------------------------------------------------------
function loadClassSchedule() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM class_schedules WHERE type_id = '$this->typeId' AND bundle_id = '$this->bundleId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($scheduleId, $typeId, $bundleId, $locationId, $instructorId, $roomId, $classDays, $classTime, $classDate, $recursive, $capacity, $minutes, $activeStatus); 
   $rowCount = $stmt->num_rows;

   if($rowCount > 0) {

        while ($stmt->fetch()) { 

                  $this->scheduleId = $scheduleId;
                  $this->instructorId = $instructorId;
                  $this->roomId = $roomId;
                  $this->classDays = $classDays;
                  $this->classTime = $classTime;
                  $this->classDate  = $classDate;
                  $this->recursive = $recursive;
                  $this->capacity  = $capacity;
                  $this->minutes  = $minutes;
                  $this->activeStatus = $activeStatus;
                  $this->parseListRows();                  
                 }
               
     }
                  
$this->listStatus = 1;
   
   $stmt->close();  

$this->scheduleList ="<table id=\"listings\" class=\"tablesorter\" align=\"left\" border=\"0\" rules=\"none\"  cellspacing=\"0\" cellpadding=\"3\" width=\"100%\"> 
<thead>
<tr class=\"tabHead\">
<th class=\"oBtext3\">   
Days
</th>
<th class=\"oBtext3\">
Time
</th>
<th class=\"oBtext3\">
Mins
</th>
<th class=\"oBtext3\">
Recursive
</th>
<th class=\"oBtext3\">
Instructor
</th>
<th class=\"oBtext3\">
Capacity
</th>
<th class=\"oBtext3\">
Location
</th>
<th class=\"oBtext3\">
Status
</th>
<th class=\"oBtext3\">
Edit
</th>
<th class=\"oBtext3\">
Delete
</th>
</tr>
</thead>
<tbody>
$this->listRows
</tbody>
</table>";

/*
iiiiiissssiis

//schedule_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//type_id INT(20) NOT NULL,
//bundle_id INT(20) NOT NULL,
//location_id INT(20) NOT NULL,
//instructor_id INT(20) NOT NULL,
//room_id INT(20) NOT NULL,
//class_days CHAR(7) NOT NULL,
//class_time TIME NOT NULL,
//class_date DATE NULL,
//recursive  ENUM("Y","N") NOT NULL,
//capacity INT(10) NOT NULL,
//minutes INT(10) NOT NULL,
/active_status ENUM("Y","N") NOT NULL
*/

}
//-----------------------------------------------------------------------------------------------------------
function loadScheduleArray() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM class_schedules WHERE schedule_id = '$this->scheduleId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($scheduleId, $typeId, $bundleId, $locationId, $instructorId, $roomId, $classDays, $classTime, $classDate, $recursive, $capacity, $minutes, $activeStatus); 
   $rowCount = $stmt->num_rows;

   if($rowCount > 0) {

   $stmt->fetch(); 

                  $this->scheduleId = $scheduleId;
                  $this->instructorId = $instructorId;
                  $this->roomId = $roomId;
                  $this->classDays = $classDays;
                  $this->classTime = $classTime;
                  $this->classDate  = $classDate;
                  $this->recursive = $recursive;
                  $this->capacity  = $capacity;
                  $this->minutes  = $minutes;
                  $this->activeStatus = $activeStatus;
                  $this->classTime  = date("g:i A", strtotime($this->classTime));  
                  
                  if($this->classDate != null) {
                     $this->classDate  = date("m/d/Y", strtotime($this->classTime));                  
                     }else{
                     $this->classDate = "";
                     }
                
                  $this->scheduleStatus = 1;
                  $this->scheduleArray="$this->classDays|$this->classTime|$this->recursive|$this->classDate|$this->capacity|$this->minutes|$this->instructorId|$this->roomId|$this->activeStatus";    
                                     
     }

$stmt->close();

}
//-----------------------------------------------------------------------------------------------------------
function getListStatus() {
          return($this->listStatus);
          }

function getScheduleList() {
          return($this->scheduleList);
          }

function getScheduleArray() {
          return($this->scheduleArray);
          }

  function getScheduleStatus() {
          return($this->scheduleStatus);
          }        
          

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_id = $_REQUEST['bundle_id'];
$schedule_id = $_REQUEST['schedule_id'];
if($ajax_switch == "1") {
  
    $load = new loadScheduleList();
    $load-> setTypeId($schedule_type);
    $load-> setBundleId($bundle_id);
    $load-> setLocationId($location_id);
    $load-> loadClassSchedule();
    $list_status = $load-> getListStatus();
    $schedule_list = $load-> getScheduleList();
   
    $schedule_array = "$list_status|$schedule_list";
    echo"$schedule_array";
    exit;

}
//-------------------------------------------------------------------------------
if($ajax_switch == "2") {

    $load = new loadScheduleList();
    $load-> setScheduleId($schedule_id);
    $load-> loadScheduleArray();
    $schedule_array = $load-> getScheduleArray();
    $schedule_status = $load-> getScheduleStatus();
    
    $schedule = "$schedule_status|$schedule_array";
    echo"$schedule";
    exit;
   }









?>