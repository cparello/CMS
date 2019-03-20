<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$imagefile = $_FILES['imagefile']['tmp_name'];
//$_FILES = $_REQUEST['_FILES'];
$instructor_name = $_REQUEST['instructor_name'];
$instructor_description = $_REQUEST['instructor_description'];
$type_id = $_REQUEST['type_id'];
$image_bit = $_REQUEST['image_bit'];
$file_extension = $_REQUEST['file_extension'];
$instructor_id = $_REQUEST['instructor_id'];
//echo "$imagefile <br> $instructor_name<br> $instructor_description<br> $type_id<br>  $image_bit <br> $file_extension<br> $instructor_id<br>";

if(isset( $_POST['edit'])) {

    if($imagefile == "") {
       $image_bit = 0;
       $file_extension = null;
   
       }else{
  
       include "instructorImage.php";
      $instructorImage = new instructorImage();
      $instructorImage-> setImageFile($_FILES);
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

     
     include "instructorSql.php";
     $edit = new instructorSql();
     $edit-> setInstructorName($instructor_name);
     $edit-> setInstructorDescription($instructor_description);
     $edit-> setTypeId($type_id);
     $edit-> setImageBit($image_bit);
     $edit-> setFileExtension($file_extension);
     $edit-> setInstructorId($instructor_id);
     $edit-> updateInstructor();
     $image_name = $edit-> getImageName();


  echo "test  $image_name";
     if($image_bit == 1) {
        $instructorImage-> setImageName($image_name);
        $instructorImage-> loadImage(); 
       }


      //sets up confirmation message if there is a problem uploading an image
      if($error_message != null) {
        $confirmation = "Instructor '$instructor_name' successfully added to '$type_name'.  However, the following error occurred when uploading this instructor photo.\n
        $error_message \n\n Please try uploading another image file for this profile.";
         }else{
         $confirmation = "Instructor '$instructor_name' successfully updates to '$type_name'.";
         }

}
//--------------------------------------------------------------------------------------------------------------------------------
if(isset( $_POST['delete'])) {

     include "instructorSql.php";
     $delete = new instructorSql();
     $delete-> setTypeId($type_id);
     $delete-> setInstructorId($instructor_id);
     $delete-> deleteInstructor();
     $delete_status = $delete-> getDeleteStatus();
     
      if($delete_status == 1) {
         $confirmation = "Instructor '$instructor_name' successfully deleted from '$type_name'.";
         }else{
         $confirmation = "There was an error deleting this profile";
         }

}

//--------------------------------------------------------------------------------------------------------------------------------

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editInstructorsList.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/instructorConfirmation.js\"></script>";




 include "editInstructorsList.php";
 $list = new editInstructorsList();
 $list-> setTypeId($type_id);
 $list-> setTypeName($type_name);
 $list-> loadRecords();
 $drop_list = $list-> getDropList();
 $info_bit = 75;
 $page_title  = "Edit Instructors for $type_name";
 $page_template = "instructorsListTemplate.php";  

                         
//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum($info_bit);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";    

include "../templates/$page_template";
exit;






?>