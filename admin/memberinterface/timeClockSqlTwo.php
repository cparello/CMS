<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class timeClockSql {

private $employeeName = null;
private $timeLine = null;
private $idCard = null;
private $timeClockList = null;
private $timeClockRecords = null;
private $userId = null;
private $timeClockDate = null;
private $clockInDate =null;
private $clockOutDate = null;
private $clockInDateTime = null;
private $clockOutDateTime = null;
private $clockInTime = null;
private $clockOutTime = null;
private $tableHeader = null;
private $counter = 1;
private $readOnly = null;
private $jsDate = null;
private $timeClockKey = null;
private $updateInDateTime = null;
private $updateOutDateTime = null;



function setIdCard($idCard) {
     $this->idCard = $idCard;
     }
function setTimeLine($timeLine) {
     $this->timeLine = $timeLine;
     }
function setUserId($userId) {
     $this->userId = $userId;
     }
function setEmployeeName($employeeName) {
     $this->employeeName = $employeeName;
     }

//this sets up for updates
function setClockInDate($clockInDate) {
     $this->clockInDate = $clockInDate;
     }
function setClockInTime($clockInTime) {
     $this->clockInTime = $clockInTime;
     }
function setClockOutDate($clockOutDate) {
     $this->clockOutDate = $clockOutDate;
     }
function setClockOutTime($clockOutTime) {
     $this->clockOutTime = $clockOutTime;
     }
function setTimeClockKey($timeClockKey) {
     $this->timeClockKey = $timeClockKey;
     }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-----------------------------------------------------------------------------------------------------------------------
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
//-----------------------------------------------------------------------------------------------------------------------
function loadTableHeader()  {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Timeclock Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock In Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock In Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock Out Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock Out Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Select Clock</font></th>
</tr>\n";    

$this->tableHeader = $table_header;

}
//-----------------------------------------------------------------------------------------------------------------------
function formatTimeClockList() {
             
//create color rows
static $cell_count = 1;
       if($cell_count == 2) {
          $color = "#D8D8D8";
          $cell_count = "";
          }else{
          $color = "#FFFFFF";
          }
          $cell_count = $cell_count + 1;
     
$name_bracket ='[]';     
     
$clock_in_date_id = "clock_in_date$this->counter";
$clock_in_date_name = "$clock_in_date_id$name_bracket"; 
$clock_in_time_id = "clock_in_time$this->counter";
$clock_in_time_name = "$clock_in_time_id$name_bracket"; 
 
$clock_out_date_id = "clock_out_date$this->counter";
$clock_out_date_name = "$clock_out_date_id$name_bracket"; 
$clock_out_time_id = "clock_out_time$this->counter";
$clock_out_time_name = "$clock_out_time_id$name_bracket"; 
 
 $this->timeClockRecords .="<tr id=\"a$this->counter\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->timeClockDate</b></font></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_in_date_id\" type=\"text\" id=\"$clock_in_date_id\" value=\"$this->clockInDate\" size=\"10\" maxlength=\"10\" $this->readOnly\" /></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_in_time_id\" type=\"text\" id=\"$clock_in_time_id\" value=\"$this->clockInTime\" size=\"5\" maxlength=\"5\"/></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_out_date_id\" type=\"text\" id=\"$clock_out_date_id\" value=\"$this->clockOutDate\" size=\"10\" maxlength=\"10\"/></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_out_time_id\" type=\"text\" id=\"$clock_out_time_id\" value=\"$this->clockOutTime\" size=\"5\" maxlength=\"5\"/></td>
<td align=\"left\"  valign =\"top\"><input type=\"checkbox\" name=\"update[]\" value=\"$this->counter|$this->timeClockKey\" onClick=\"return changeColor(this,'a$this->counter','$color',$this->counter,'$this->jsDate')\"/></td>
</tr>\n";

 $this->counter++;

}
//-----------------------------------------------------------------------------------------------------------------------
function formatInOutDate() {

$clockInDateTimeArray = explode(" ", $this->clockInDateTime);
$clockOutDateTimeArray = explode(" ", $this->clockOutDateTime);

$this->clockInDate = date("m/d/Y", strtotime($clockInDateTimeArray[0]));
$this->clockOutDate = date("m/d/Y", strtotime($clockOutDateTimeArray[0]));

if($this->clockOutDate == '12/31/1969') {
  $this->clockOutDate = '00/00/0000';
  }

$clockInTimeArray = explode(":", $clockInDateTimeArray[1]);
$clockInHour = $clockInTimeArray[0];
$clockInMinutes = $clockInTimeArray[1];
$this->clockInTime = "$clockInHour:$clockInMinutes";

$clockOutTimeArray = explode(":", $clockOutDateTimeArray[1]);
$clockOutHour = $clockOutTimeArray[0];
$clockOutMinutes = $clockOutTimeArray[1];
$this->clockOutTime = "$clockOutHour:$clockOutMinutes";

}
//-----------------------------------------------------------------------------------------------------------------------
function loadTimelineList() {

$dbMain = $this->dbconnect();

      for($i=0; $i < $this->timeLine; $i++)  {
      
           $this->timeClockDate =  date("M j, Y"  ,mktime(0, 0, 0, date('m'), date('d')-$i, date('Y')));
           $this->clockInDate =  date("Y-m-d"  ,mktime(0, 0, 0, date('m'), date('d')-$i, date('Y')));
           $this->jsDate = date("m/d/Y"  ,mktime(0, 0, 0, date('m'), date('d')-$i, date('Y')));
           
             $stmt = $dbMain ->prepare("SELECT timeclock_key, clock_in, clock_out FROM timeclock WHERE  id_card='$this->idCard' AND DATE(clock_in) ='$this->clockInDate'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($timeclock_key, $clock_in, $clock_out); 
             //$stmt->fetch();            
             $rowCount = $stmt->num_rows;
            
             if($rowCount != 0)  {
           
                    while ($stmt->fetch()) { 
                               $this->timeClockKey = $timeclock_key;
                               $this->clockInDateTime = $clock_in;
                               $this->clockOutDateTime = $clock_out;
                               $this->formatInOutDate();
                               $this->readOnly = 'readonly="readonly" ';
                               $this->formatTimeClockList();                                                     
                             }
               
                }else{
                $this->timeClockKey = 0;
                $this->clockInDateTime = null;
                $this->clockOutDateTime = null;
                $this->clockOutDate = null;
                $this->clockInDate = null;
                $this->clockInTime = null;
                $this->clockOutTime = null;
                $this->readOnly = null;
                $this->formatTimeClockList();                
                }

              }    

}
//------------------------------------------------------------------------------------------------------------------------
function loadTimeClock() {

switch ($this->timeLine) {
    case 1:
    $this->loadTimelineList();    
    break;    
    case 2:
    $this->loadTimelineList();    
    break;        
    case 7:
    $this->loadTimelineList();
    break;    
    case 14:
    $this->loadTimelineList();
    break;    
    case 30:
    $this->loadTimelineList();
    break;     
    }
    
    $this->loadTableHeader();    
    

$this->timeClockList = "$this->tableHeader$this->timeClockRecords";
$this->loadEmployeeName();

}
//------------------------------------------------------------------------------------------------------------------------
function insertClockTime() {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO timeclock VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiss', $timeClockKey, $userId, $idCard, $clockIn, $clockOut); 

$timeClockKey = null;
$userId = $this->userId;
$idCard = $this->idCard;
$clockIn = $this->updateInDateTime;
$clockOut = $this->updateOutDateTime;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }	

   $stmt->close();

}
//------------------------------------------------------------------------------------------------------------------------
function updateClockTime() {

$dbMain = $this->dbconnect();

$sql = "UPDATE timeclock SET clock_in= ?, clock_out =? WHERE timeclock_key = ? AND user_id = ?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssii' , $clockIn, $clockOut, $timeClockKey, $userId);

$clockIn = $this->updateInDateTime;
$clockOut = $this->updateOutDateTime;
$timeClockKey = $this->timeClockKey;
$userId = $this->userId;



if(!$stmt->execute())  {
  printf("Error: %s.\n", $stmt->error);
  }	

  $stmt->close();
}
//------------------------------------------------------------------------------------------------------------------------
function updateTimeClock() {

$dateStringIn = "$this->clockInDate $this->clockInTime";
$dateStringOut = "$this->clockOutDate $this->clockOutTime";

$this->updateInDateTime = date("Y-m-d H:i:s", strtotime($dateStringIn)); 
$this->updateOutDateTime = date("Y-m-d H:i:s", strtotime($dateStringOut));

if($this->timeClockKey == 0) {
   $this->insertClockTime();
   }
   
if($this->timeClockKey > 0) {
   $this->updateClockTime();    
   }


}
//------------------------------------------------------------------------------------------------------------------------
function getTimeClockListings() {
     return($this->timeClockList);
     }
function getEmployeeName() {
     return($this->employeeName);
     }
     
function getConfirmation() {
 $this->confirmationMessage = "Employee $this->employeeName Timeclock Successfully Updated";
 return($this->confirmationMessage);
}


}
?>