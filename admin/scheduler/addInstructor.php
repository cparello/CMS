<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
//$_FILES = $_REQUEST['_FILES'];
$instructor_name = $_REQUEST['instructor_name'];
$instructor_description = $_REQUEST['instructor_description'];
$schedule_type = $_REQUEST['schedule_type'];
$image_bit = $_REQUEST['image_bit'];
$file_extension = $_REQUEST['file_extension'];
$image_name = $_FILES['imagefile']['name'];
$type_name = $_REQUEST['type_name'];
$imagefile = $_FILES['imagefile']['tmp_name'];

//echo "$imagefile <br> $instructor_name<br> $instructor_description<br> $schedule_type<br>  $image_bit <br> $file_extension<br> $image_name<br>$type_name<br>";

//var_dump($_FILES);
if($marker == 1) {

if($imagefile == "") {
   $image_bit = 0;
   $file_extension = null;
   
  }else{
  
  include "instructorImage.php";
  $instructorImage = new instructorImage();
  $instructorImage->setImageFile($_FILES);
  $instructorImage-> checkImageFiles();
  $error_message = $instructorImage-> getErrorMessage();
  
      if($error_message == null) {
        $image_bit = 1;
        $file_extension = $instructorImage-> getFileExtension();
        }else{
        $image_bit = 0;
        $file_extension = null;
        }
        
  }

//echo "test $file_extension err $error_message bit $image_bit";

include "instructorSql.php";
$save = new instructorSql();
$save-> setInstructorName($instructor_name);
$save-> setInstructorDescription($instructor_description);
$save-> setTypeId($schedule_type);
$save-> setTypeName($type_name);
$save-> setImageBit($image_bit);
$save-> setFileExtension($file_extension);
$save-> addInstructor();
$image_name = $save-> getImageName();


 if($image_bit == 1) {
   $instructorImage-> setImageName($image_name);
   $instructorImage-> loadImage(); 
   }


$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/checkInstructor.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/instructorConfirmation.js\"></script>";


//sets up confirmation message if there is a problem uploading an image
if($error_message != null) {
  $confirmation = "Instructor '$instructor_name' successfully added to '$type_name'.  However, the following error occurred when uploading this instructor photo.\n
  $error_message \n\n Please use the 'Edit Instructors / Class Rooms' interface to add a new photo to this profile.";
  }else{
  $confirmation = "Instructor '$instructor_name' successfully added to '$type_name'.";
  }

$page_title  = "Add Instructor to $type_name";
$page_template = "addInstructorTemplate.php";   
$info_bit = 72;

 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum($info_bit);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";    

include "../templates/$page_template";
exit;



}


?>