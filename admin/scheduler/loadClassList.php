<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

date_default_timezone_set('America/Los_Angeles');

//this class formats the dropdown menu for clubs and facilities
class  loadClassList {

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
private  $eventDate = null;
private  $className = null;
private  $timeStamp = null;
private  $eventBit = null;
private  $clubId = null;
private  $bookLink = null;



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

function setEventDate($eventDate) {
        $this->eventDate = $eventDate;
        }

function setTimeStamp($timeStamp) {
        $this->timeStamp = $timeStamp;
        }

function setClubId($clubId) {
        $this->clubId = $clubId;
        }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-----------------------------------------------------------------------------------------------------
function loadCurrentCapacity() {
     
     $classTime = date("H:i:s", strtotime($this->classTime));
     $classDate = date("Y-m-d",strtotime($this->eventDate));
     $classDateTime ="$classDate $classTime";


      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT count(booking_id) AS booking_count FROM class_bookings WHERE schedule_id = '$this->scheduleId' AND class_date_time='$classDateTime' AND club_id='$this->clubId'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($bookingCount);
      $stmt->fetch();
      $stmt->close();
      
      $this->capacity = $this->capacity - $bookingCount;

      

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
function parseClassName() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT bundle_name FROM bundle_type WHERE  bundle_id = '$this->bundleId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($className); 
   $stmt->fetch();

   $this->className = $className;

   $stmt->close();


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
$this->parseClassName();

$listBit = null;
$currentBit = null;
$classDate = "";

//set up todays date for a comparison with the event date for booking future classes
$todaysDate = time();
$todaysDate = strtotime("midnight", $todaysDate);

//set up the curent time
$selectedTime = strtotime($this->eventDate);
$todaysTimeTxt = date("H:i");
$todaysHourMin = strtotime($todaysTimeTxt);
$currentTime = $selectedTime + $todaysHourMin;


//total duration of the class in seconds
$classSeconds = $this->minutes * 60;

//the time of the start of class in seconds
$classStartSeconds = strtotime($this->classTime);

//get the current time then truncted to the begining of the day then add the class time start in seconds
$beginOfDay = strtotime("midnight", $selectedTime);
$classStart = $classStartSeconds + $beginOfDay;

//create the end date by adding the class start with the duration of the class
$classEnd = $classSeconds + $classStart;

//this sets up the display if there is a one time class
if($this->classDate != "") {
   $eventTime = strtotime($this->classDate);
   }

$classTime  = date("g:i A", strtotime($this->classTime));  //for print

//prints out the schedule in real time if the class schedule is for today
if(($this->activeStatus == "Y") && ($todaysDate == $beginOfDay)) {

   if(($currentTime >= $classStart) && ($currentTime <= $classEnd)) {
       $currentBit = 1;
      }
   
   if($classStart >= $currentTime) {
      $listBit = 1;
      }
    
   if($eventTime == $selectedTime) {
      $classDate = $this->classDate ;
      }
      
      
     
   if(($listBit == 1 OR $currentBit == 1) && ($this->classDate == null)) { 
   
      if($this->capacity == 0) {
         $bookIt = "<span class=\"full\">Class Full</span>";
        }else{
         $bookIt = "<a href = \"javascript:void(0)\" class=\"book\" id=\"$this->scheduleId $this->bundleId\">Book</a>";
        }
   
   
        $this->listRows .="<tr class=\"stripe\">
       <td class=\"black2\">
       $classTime
       </td>
       <td class=\"black2\">
       $this->className
       </td>
       <td class=\"black2\">
       $this->instructorName
       </td>
       <td class=\"black2\">
       $this->minutes Mins       
       </td>       
       <td class=\"black2\">
        $this->capacity
       </td>
       <td class=\"black2\">
        $this->roomName
       </td>
       <td class=\"black2\">
        $bookIt
       </td>
       <td class=\"black2\">
        <a href = \"javascript:void(0)\" class=\"cancel\" id=\"C $this->scheduleId $this->bundleId\">Cancel</a>
       </td>
       <td class=\"black2\">
       <a href = \"javascript:void(0)\" class=\"print\" id=\"P $this->scheduleId $this->bundleId\">Print</a>
       </td>
       </tr>\n";
      }
      

  if(($classDate != null) && ($listBit == 1 OR $currentBit == 1)) {
  
     if($this->capacity == 0) {
      $bookIt = "<span class=\"full\">Class Full</span>";
     }else{
      $bookIt = "<a href = \"javascript:void(0)\" class=\"book\" id=\"$this->scheduleId $this->bundleId\">Book</a>";
     }
  
  
        $this->listRows .="<tr class=\"stripe\">
       <td class=\"black2\">
       $classTime
       </td>
       <td class=\"black2\">
       $this->className
       </td>
       <td class=\"black2\">
       $this->instructorName
       </td>
       <td class=\"black2\">
       $this->minutes Mins       
       </td>       
       <td class=\"black2\">
       $this->capacity
       </td>
       <td class=\"black2\">
        $this->roomName
       </td>
       <td class=\"black2\">
        $bookIt
       </td>
       <td class=\"black2\">
        <a href = \"javascript:void(0)\" class=\"cancel\" id=\"C $this->scheduleId $this->bundleId\">Cancel</a>
       </td>
       <td class=\"black2\">
       <a href = \"javascript:void(0)\" class=\"print\" id=\"P $this->scheduleId $this->bundleId\">Print</a>
       </td>
       </tr>\n";  
    }
            
} 

//prints out classes if this is for a future date
if(($this->activeStatus == "Y") && ($this->classDate == null) && ($beginOfDay > $todaysDate)) {

   if($this->capacity == 0) {
      $bookIt = "<span class=\"full\">Class Full</span>";
     }else{
      $bookIt = "<a href = \"javascript:void(0)\" class=\"book\" id=\"$this->scheduleId $this->bundleId\">Book</a>";
     }


   $this->listRows .="<tr class=\"stripe\">
       <td class=\"black2\">
       $classTime
       </td>
       <td class=\"black2\">
       $this->className
       </td>
       <td class=\"black2\">
       $this->instructorName
       </td>
       <td class=\"black2\">
       $this->minutes Mins       
       </td>
       <td class=\"black2\">
       $this->capacity
       </td>
       <td class=\"black2\">
        $this->roomName
       </td>
       <td class=\"black2\">
       $bookIt
       </td>
       <td class=\"black2\">
        <a href = \"javascript:void(0)\" class=\"cancel\" id=\"C $this->scheduleId $this->bundleId\">Cancel</a>
       </td>
       <td class=\"black2\">
       <a href = \"javascript:void(0)\" class=\"print\" id=\"P $this->scheduleId $this->bundleId\">Print</a>
       </td>
       </tr>\n";  
  }

     
}
//-----------------------------------------------------------------------------------------------------
function loadClassSchedules() {
   
  // $timeGovenor = date("H:i:s", mktime(date('H'),date('i'),0,0,0,0)); 
   $dayOfWeek = date('w', strtotime($this->eventDate));
   $dayOfWeek = $dayOfWeek +1;

 //AND class_time >= '$timeGovenor' 

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM class_schedules WHERE type_id = '$this->typeId' AND class_days LIKE '%$dayOfWeek%' ORDER BY class_time ASC");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($scheduleId, $typeId, $bundleId, $locationId, $instructorId, $roomId, $classDays, $classTime, $classDate, $recursive, $capacity, $minutes, $activeStatus); 
   $rowCount = $stmt->num_rows;

   if($rowCount > 0) {

        while ($stmt->fetch()) { 

                  $this->scheduleId = $scheduleId;
                  $this->instructorId = $instructorId;
                  $this->bundleId = $bundleId;
                  $this->roomId = $roomId;
                  $this->classDays = $classDays;
                  $this->classTime = $classTime;
                  $this->classDate  = $classDate;
                  $this->recursive = $recursive;
                  
                  $this->capacity  = $capacity;
                  $this->loadCurrentCapacity();
                  
                  $this->minutes  = $minutes;
                  $this->activeStatus = $activeStatus;
                  $this->parseListRows();                  
                 }
               
     }
                  
$this->listStatus = 1;
   
   $stmt->close();  

//takes care of blank records
if($this->listRows == "") {   
  $this->listRows = "<tr class=\"stripe\">
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>            
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
            <td class=\"black2\">
            NA
            </td>
           </tr>\n";  
  }

$this->scheduleList ="<table id=\"listings\" class=\"tablesorter\" align=\"left\" border=\"0\" rules=\"none\"  cellspacing=\"0\" cellpadding=\"3\" width=\"100%\"> 
<thead>
<tr class=\"tabHead\">
<th class=\"oBtext3\">   
Time
</th>
<th class=\"oBtext3\">
Class Name
</th>
<th class=\"oBtext3\">
Instructor
</th>
<th class=\"oBtext3\">
Duration
</th>
<th class=\"oBtext3\">
Spaces Left
</th>
<th class=\"oBtext3\">
Room
</th>
<th class=\"oBtext3\">
Book
</th>
<th class=\"oBtext3\">
Cancel
</th>
<th class=\"oBtext3\">
Print Roster
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
if($ajax_switch == "1") {
  
    $club_id = $_SESSION['location_id'];
    
    $load = new loadClassList();
    $load-> setTypeId($schedule_type);
    $load-> setEventDate($event_date);
    $load-> setTimeStamp($time_stamp);
    $load-> setClubId($club_id);
    $load-> loadClassSchedules();
    $list_status = $load-> getListStatus();
    $schedule_list = $load-> getScheduleList();
   
    $schedule_array = "$list_status|$schedule_list";
    echo"$schedule_array";
    exit;

}










?>