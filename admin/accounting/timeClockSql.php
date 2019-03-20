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
function setTimeLineStart($timeLineStart) {
     $this->timeLineStart = $timeLineStart;
     }
function setTimeLineEnd($timeLineEnd) {
     $this->timeLineEnd = $timeLineEnd;
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
function loadTableHeader()  {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Timeclock Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock In Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock In Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock Out Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock Out Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Shift Length</font></th>
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

$cIn = "$this->clockInDate $this->clockInTime";
$cOut = "$this->clockOutDate $this->clockOutTime";
$cIn = strtotime($cIn);
$cOut = strtotime($cOut);
//echo "$cIn $cOut";//
$diff = $cOut - $cIn;//16320
$buff = $diff/3600;
$buff = round($buff, 2); 
$bAr = explode(".",$buff);
$hours = $bAr[0];
$mins = ".$bAr[1]";
$mins = $mins * 60;
$mins = round($mins, 0);

 $this->timeClockRecords .="<style>.time{font-weight: 800;}</style><tr id=\"a$this->counter\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->timeClockDate</b></font></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_in_date_id\" type=\"text\" id=\"$clock_in_date_id\" value=\"$this->clockInDate\" size=\"10\" maxlength=\"10\" $this->readOnly\" /></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_in_time_id\" type=\"text\" id=\"$clock_in_time_id\" value=\"$this->clockInTime\" size=\"5\" maxlength=\"5\"/></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_out_date_id\" type=\"text\" id=\"$clock_out_date_id\" value=\"$this->clockOutDate\" size=\"10\" maxlength=\"10\"/></td>
<td align=\"left\" valign =\"top\"><input name=\"$clock_out_time_id\" type=\"text\" id=\"$clock_out_time_id\" value=\"$this->clockOutTime\" size=\"5\" maxlength=\"5\"/></td>
<td align=\"left\" valign =\"top\"><span class=\"time\">$hours h $mins m</span></td>
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
//echo "tl $this->timeLine xxx";
//exit;
$todaysDate = date('Y-m-d');
$todaySecs = strtotime($todaysDate);
$timeLineStartSecs = strtotime($this->timeLineStart);
$timeLineEndSecs = strtotime($this->timeLineEnd);
$diffSecs = $timeLineEndSecs - $timeLineStartSecs;
$numDays = round($diffSecs/86400);
$numDays++;

      for($i=0; $i < $numDays; $i++)  {
      
           $this->timeClockDate =  date("M j, Y" ,mktime(0, 0, 0, date('m',strtotime($this->timeLineStart)), date('d',strtotime($this->timeLineStart))+$i, date('Y',strtotime($this->timeLineStart))));
           $this->clockInDate =  date("Y-m-d"  ,mktime(0, 0, 0, date('m',strtotime($this->timeLineStart)), date('d',strtotime($this->timeLineStart))+$i, date('Y',strtotime($this->timeLineStart))));
           $this->jsDate = date("m/d/Y"  ,mktime(0, 0, 0, date('m',strtotime($this->timeLineStart)), date('d',strtotime($this->timeLineStart))+$i, date('Y',strtotime($this->timeLineStart))));
           
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
                               $clockInSecs = strtotime($clock_in);
                               $clockOutSecs = strtotime($clock_out);
                               $secs = $clockOutSecs-$clockInSecs;
                               $totalTimeSecs += $secs;
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
$totalTime = date('H:i:s',$totalTimeSecs);
$hours = $totalTimeSecs/60/60;
$hours = sprintf("%01.2f", $hours);
$this->totalsRecords ="<tr id=\"a$this->counter\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b><h3>Total Time:</h3></b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b><h3>$hours</h3></b></font></td>

</tr>\n";
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
    case 60:
    $this->loadTimelineList();
    break;     
    case 90:
    $this->loadTimelineList();
    break;   
    default:
    $this->loadTimelineList();
    break;  
    }
    
    $this->loadTableHeader();    
    

$this->timeClockList = "$this->tableHeader$this->timeClockRecords$this->totalsRecords";

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
function getConfirmation() {
 $this->confirmationMessage = "Employee $this->employeeName Timeclock Successfully Updated";
 return($this->confirmationMessage);
}


}
?>