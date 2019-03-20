<?php
session_start();
$ajax_switch = $_REQUEST['ajax_switch'];
$type_id = $_REQUEST['type_id'];
$schedule_id = $_REQUEST['schedule_id'];
$bundle_id = $_REQUEST['bundle_id'];
$location = $_REQUEST['location'];
$class_date = $_REQUEST['class_date'];
$time_slot = $_REQUEST['time_slot'];
$class_text = $_REQUEST['class_text'];
$class_name = $_REQUEST['class_name'];
$instructor_name = $_REQUEST['instructor_name'];
$room_name = $_REQUEST['room_name'];
              
                     

if($ajax_switch == 1) {

$_SESSION['type_id'] = $type_id;
$_SESSION['schedule_id'] = $schedule_id;
$_SESSION['bundle_id'] = $bundle_id;
$_SESSION['location'] = $location;
$_SESSION['class_date'] = $class_date;
$_SESSION['time_slot'] = $time_slot;
$_SESSION['class_text'] = $class_text;
$_SESSION['class_name'] = $class_name;
$_SESSION['instructor_name'] = $instructor_name;
$_SESSION['room_name'] = $room_name;

echo"$ajax_switch";
exit;

}

?>

