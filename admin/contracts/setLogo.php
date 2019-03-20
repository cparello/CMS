<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$_FILES = $_REQUEST['_FILES'];

include "logoSql.php";
$logo_sql = new logoSql();

if($marker == 1)  {
include "logoImage.php";

$logo_image = new logoImage();
$logo_image->setImageFile($_FILES);
$error_message = $logo_image->loadImage();

$errorHtml = "<span class=\"errors\">$error_message</span>";

//check to see if there are no errors and if not display confirmation
if($error_message == null)  {
   $errorHtml = null;
   $image_name = $logo_image-> getImageFileName();
   $file_path = $logo_image-> getImageFilePath();
   $width_height = $logo_image-> getImageFileAspect();
   $confirmation = $logo_image->getConfirmation();
   
   //updat the database the new image info
   $logo_sql-> setImagePath($file_path);
   $logo_sql-> setImageName($image_name);
   $logo_sql-> setImageAspect($width_height);
   $error_message2 = $logo_sql->updateLogo();
if($error_message2 == null) {   
   $confirmation = $logo_sql->getConfirmation();
   }else{
   $errorHtml = "<span class=\"errors\">$error_message2</span>";   
   }
  }
}

//get the image info from the database for the current image to display the html
$logo_sql->loadLogo();
$image_name = $logo_sql-> getImageName();
$file_path = $logo_sql-> getImagePath();
$width_height = $logo_sql-> getImageAspect();

//sets up the varibles for the form template
$submit_link = 'setLogo.php';
$submit_name = 'update';
$submit_title = "Set Logo";
$page_title  = 'Set Company Logo';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/logo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtLogo.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(21);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/logoTemplate.php";

?>