<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$pass_id = $_REQUEST['pass_id'];
$pass_title = $_REQUEST['pass_title'];
$location_id = $_REQUEST['location_id'];
$title = $_REQUEST['title'];
$term_one = $_REQUEST['term_one'];
$term_two = $_REQUEST['term_two'];
$term_three = $_REQUEST['term_three'];
$term_four = $_REQUEST['term_four'];
$pass_desc = $_REQUEST['pass_desc'];
$pass_topic = $_REQUEST['pass_topic'];

include"guestPassServicesTwo.php";
include "guestPassList.php";
include "saveGuestPass.php";


//--------------------------------------------------------------------------------------------
if(isset($_POST['delete']))   {

   $delete = new saveGuestPass();
   $delete-> setGuestPassId($pass_id);
   $delete-> setGuestPassTitle($pass_title);
   $delete-> deleteGuestPass();
   $confirmation = $delete-> getConfirmationMessage();
   }
//--------------------------------------------------------------------------------------------
if(isset($_POST['edit']))  {

$serviceLists = new guestPassServicesTwo();
$serviceLists-> setPassId($pass_id);
$serviceLists-> setLocationId($location_id);
$serviceLists-> makeDropDownCurrent();
$serviceLists-> makeDropDownAvailable();
$current_drop = $serviceLists-> getDropListCurrent();
$available_drop = $serviceLists-> getDropListAvailable();


$page_title = 'Edit Guest Pass';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtGuestPass.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editGuestPass.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(45);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/editGuestPassTemplate.php";

exit;
}
//--------------------------------------------------------------------------------------------
if(isset($_POST['update']))  {

$update = new saveGuestPass();
$update-> setGuestPassId($pass_id);
$update-> setLocationId($location_id);
$update-> setGuestPassTitle($title);
$update-> setTermOne($term_one);
$update-> setTermTwo($term_two);
$update-> setTermThree($term_three);
$update-> setTermFour($term_four);
$update-> setGuestPassDescription($pass_desc);
$update-> setGuestPassTopic($pass_topic);
$update-> updateGuestPassBasic();

     if(isset($_POST['service_types1'])) {
        //loop through the check boxes
         foreach($_POST['service_types1'] as $value1) {
               $valueArray = explode("|", $value1);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1]; 
               $update-> setClubId($club_id);
               $update-> setServiceKey($service_key);
               $update-> updateServices();                      
              }              
        }

$confirmation = $update-> getConfirmationMessage();

$serviceLists = new guestPassServicesTwo();
$serviceLists-> setPassId($pass_id);
$serviceLists-> setLocationId($location_id);
$serviceLists-> makeDropDownCurrent();
$serviceLists-> makeDropDownAvailable();
$current_drop = $serviceLists-> getDropListCurrent();
$available_drop = $serviceLists-> getDropListAvailable();


$page_title = 'Edit Guest Pass';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtGuestPass.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editGuestPass.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(45);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/editGuestPassTemplate.php";


exit;
}
//-------------------------------------------------------------------------------------------

$list_format = 1;
$getLists = new guestPassList();
$getLists -> setListFormat($list_format);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(44);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";



//check tp see if there are multi results or not
if($result1 != "") {
include "../templates/guestPassListTemplate.php";
exit;
}


?>