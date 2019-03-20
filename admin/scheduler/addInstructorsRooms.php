<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$instructor_room = $_REQUEST['instructor_room'];
$type_name = $_REQUEST['type_name'];
$schedule_type = $_REQUEST['schedule_type'];

if($marker == 1) {

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";


   switch ($instructor_room) {
              case "I":
              $info_bit = 72;
              $page_title  = "Add Instructor to $type_name";
              $page_template = "addInstructorTemplate.php";  
              $javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/checkInstructor.js\"></script>";
              break;
              case "R":
              $info_bit = 73;
              $page_title  = "Add Class Room to $type_name";
              $page_template = "roomTemplate.php"; 
              $javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/checkRoom.js\"></script>";
              break; 
             }
             
             
 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum($info_bit);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";    

include "../templates/$page_template";
exit;
}



include "scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$schedule_type_drops = $typeDrops-> loadMenu();


//sets up the varibles for the form template
$page_title  = 'Add Instructors / Class Rooms';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/addInstructorsRooms.js\"></script>";


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(71);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/addInstructorsRoomsTemplate.php";

?>