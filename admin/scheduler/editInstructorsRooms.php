<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$instructor_room = $_REQUEST['instructor_room'];
$schedule_type = $_REQUEST['schedule_type'];
$type_name = $_REQUEST['type_name'];

if($marker == 1) {

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";


   switch ($instructor_room) {
              case "I":
              include "editInstructorsList.php";
              $list = new editInstructorsList();
              $list-> setTypeId($schedule_type);
              $list-> setTypeName($type_name);
              $list-> loadRecords();
              $drop_list = $list-> getDropList();
              $info_bit = 75;
              $page_title  = "Edit Instructors for $type_name";
              $javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editInstructorsList.js\"></script>";
              $page_template = "instructorsListTemplate.php";  
              break;
              case "R":
              include "editRoomList.php";
              $list = new editRoomList();
              $list-> setTypeId($schedule_type);
              $list-> setTypeName($type_name);
              $list-> loadRecords();
              $drop_list = $list-> getDropList();              
              $info_bit = 76;
              $page_title  = "Edit Class Rooms for $type_name";
              $javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editRoomList.js\"></script>";
              $page_template = "roomListTemplate.php"; 
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
$page_title  = 'Edit Instructors / Class Rooms';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editInstructorsRooms.js\"></script>";


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(74);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/editInstructorsRoomsTemplate.php";

?>