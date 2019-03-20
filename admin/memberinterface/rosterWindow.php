<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class rosterWindow {

private  $clubId = null;
private  $typeId = null;
private  $scheduleId = null;
private  $bundleId = null;
private  $locationId = null;
private  $classDate = null;
private  $timeSlot = null;
private  $classText = null;
private  $className = null;
private  $rosterList = null;
private  $memType = null;
private  $memberId = null;
private  $firstName = null;
private  $lastName = null;
private  $email = null;
private  $phone = null;
private  $counter = 1;


function setClubId($clubId) {
        $this->clubId = $clubId;
        }        

function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
        
function setScheduleId($scheduleId) {
        $this->scheduleId = $scheduleId;
        }

function setBundleId($bundleId) {
        $this->bundleId = $bundleId;
        }

function setLocationId($locationId) {
        $this->locationId = $locationId;
        }

function setClassDate($classDate) {
        $this->classDate = $classDate;
        }
        
function setTimeSlot($timeSlot) {
        $this->timeSlot = $timeSlot;
        }  

function setClassText($classText) {
        $this->classText = $classText;
        }

function setClassName($className) {
        $this->className = $className;
        }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//-------------------------------------------------------------------------------------
function checkMember() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(contract_key) AS count FROM member_info WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
    if($count > 0) {
      $this->memType = 'M';   
      }else{
      $this->memType = null;
      }
      
}
//--------------------------------------------------------------------------------------
function checkNonMember() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(sm_member_id ) AS count FROM schedular_member_info WHERE sm_member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
   if($count > 0) {
      $this->memType = 'N';   
     }

}
//--------------------------------------------------------------------------------------
function checkGuestPass() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(pass_id) AS count FROM guest_register WHERE bar_code = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
   if($count > 0) {
      $this->memType = 'G';       
     }else{
      $this->memType = null;
     }

}
//-------------------------------------------------------------------------------------
function checkStatus() {

 //first check the guest pass
  $this->checkGuestPass();

   if($this->memType == null) {
      $this->checkMember();
     }

   if($this->memType == null) {     
     $this->checkNonMember();
    }

}
//-------------------------------------------------------------------------------------
function loadMemberInfo() {


$dbMain = $this->dbconnect();

   switch ($this->memType) {
               case "G":               
               $stmt = $dbMain ->prepare("SELECT guest_name, guest_phone, guest_email FROM guest_register WHERE bar_code = '$this->memberId'");
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($guestName, $guestPhone, $guestEmail);
               $stmt->fetch();
               $stmt->close();
               
               //split the name since it occupies one field
               $guestNameArray = explode(" ", $guestName);
               $arrayCount = count($guestNameArray);

                if($arrayCount == 1) {
                  $this->firstName = $guestNameArray[0];
                  }
                if($arrayCount == 2) {
                  $this->firstName = $guestNameArray[0];
                  $this->lastName = $guestNameArray[1];
                  }
                if($arrayCount == 3) {
                  $this->firstName = $guestNameArray[0];
                  $this->lastName = $guestNameArray[2];
                  }

               $this->phone = $guestPhone;
               $this->email = $guestEmail;               
               
               break;
               case "M":
               $stmt = $dbMain ->prepare("SELECT first_name, last_name, primary_phone, email FROM member_info WHERE member_id = '$this->memberId'");
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($firstName, $lastName, $phone, $email);
               $stmt->fetch();
               $stmt->close();
               
               $this->firstName = $firstName;
               $this->lastName = $lastName;
               $this->phone = $phone;
               $this->email = $email;
               
               break;
               case "N":
               $stmt = $dbMain ->prepare("SELECT sm_fname, sm_lname, sm_phone, sm_email FROM schedular_member_info WHERE sm_member_id='$this->memberId' ");  
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($smFirstName, $smLastName, $smPhone, $smEmail);
               $stmt->fetch();
               $stmt->close();
               
               $this->firstName = $smFirstName;
               $this->lastName = $smLastName;
               $this->phone = $smPhone;
               $this->email = $smEmail;               
               break;
               }


}
//--------------------------------------------------------------------------------------
function loadRosterList() {

$classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";


 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT member_id FROM class_bookings WHERE bundle_id='$this->bundleId' AND schedule_id='$this->scheduleId' AND club_id='$this->clubId' AND class_date_time='$classDateTime' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($memberId);


        while ($stmt->fetch()) {
                 $this->memberId = $memberId;
                 $this->checkStatus();
                 $this->loadMemberInfo();
                 
                 $this->rosterList .= "<tr>
                 <td align=\"left\" class=\"listText\">$this->counter</td> 
                 <td align=\"left\" class=\"listText\">$this->lastName</td>
                 <td align=\"left\" class=\"listText\">$this->firstName</td>
                 <td align=\"left\" class=\"listText\">$this->memberId</td>
                 <td align=\"left\" class=\"listText\">$this->phone</td>
                 <td align=\"left\" class=\"listText\"></td>
                 </tr>\n";
                 
                 $this->counter++;
                }
                
 $stmt->close();
 
/* 
CREATE TABLE class_bookings (
booking_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//type_id INT(20) NOT NULL,
//schedule_id INT(20) NOT NULL,
//bundle_id INT(20) NOT NULL,
//location_id INT(20) NOT NULL,
//club_id INT(20) NOT NULL,
member_id INT(20) NOT NULL,
service_key INT(20) NOT NULL,
class_date_time DATETIME NOT NULL
*/

}

//-------------------------------------------------------------------------------------

function getRosterList() {
       return($this->rosterList);
       }





}
//============================================

$club_id = $_SESSION['location_id'];  //do not unset  
$type_id = $_SESSION['type_id'];
$schedule_id = $_SESSION['schedule_id'];
$bundle_id = $_SESSION['bundle_id'];
$location = $_SESSION['location'];
$class_date = $_SESSION['class_date'];
$time_slot = $_SESSION['time_slot'];
$class_text = $_SESSION['class_text'];
$class_name = $_SESSION['class_name'];
$instructor_name = $_SESSION['instructor_name'];
$room_name = $_SESSION['room_name'];
$footer_admin = $_SESSION['footer_admin']; 

unset($_SESSION['type_id']);
unset($_SESSION['schedule_id']);
unset($_SESSION['bundle_id']);
unset($_SESSION['location']);
unset($_SESSION['class_date']);
unset($_SESSION['time_slot']);
unset($_SESSION['class_text']);
unset($_SESSION['class_name']);
unset($_SESSION['instructor_name']);
unset($_SESSION['room_name']);

$print = new rosterWindow();
$print-> setClubId($club_id);
$print-> setTypeId($type_id);
$print-> setScheduleId($schedule_id);
$print-> setBundleId($bundle_id);
$print-> setLocationId($location);
$print-> setClassDate($class_date);
$print-> setTimeSlot($time_slot);
$print-> setClassText($class_text);
$print-> setClassName($class_name);
$print-> loadRosterList();
$roster_list = $print-> getRosterList();

//sets up the date and time this list was generated
$postTime = date("g:h A", time());
$postDate = date("n/j/Y", time());



$printRosterTemplate = <<<PRINTROSTERTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/rosterWindow.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Class Roster</title>

</head>
<body>
<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png" /></a>
</div>

<div id="postTimeDiv" class="black1">
Class Roster:  &nbsp;<span class="black2">As of $postTime &nbsp; $postDate</span>
</div>

<div id="classInfo">
<table cellpadding="2">
<tr>
<td class="black1 pad2">
Class Name:
</td>
<td width="350" class="black2 pad1 pad2">
$class_name
</td>
<td class="black1 pad2">
Class Date:
</td>
<td class= "black2 pad1 pad2">
$class_date
</td>
</tr>

<tr>
<td class="black1">
Instructor:
</td>
<td width="350" class="black2 pad1">
$instructor_name
</td>
<td class="black1">
Class Time:
</td>
<td class= "black2 pad1">
$time_slot
</td>
</tr>

<tr>
<td class="black1 pad3">
Room:
</td>
<td width="350" class="black2 pad1 pad3" colspan="2">
$room_name
</td>
</tr>
</table>
</div>

<div id="rosterHeader">
<span class="black3">Class Roster</span>
</div>

<div id="list">
<table align="left"  cellspacing="0" cellpadding="0" width=100% style="border: 1px solid black;">
<tr bgcolor="black">
<th align="left">&nbsp</th>
<th align="left" class="whiteHeader">Last Name</th>
<th align="left" class="whiteHeader">First Name</th>
<th align="left" class="whiteHeader">Member #</th>
<th align="left" class="whiteHeader">Phone #</th>
<th align="left" class="whiteHeader">Attendence</th>
</tr>
$roster_list



</table>
</div>


</body>
</html>
PRINTROSTERTEMPLATE;

echo"$printRosterTemplate";
exit;

?>










