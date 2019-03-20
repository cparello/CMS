<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$service_location = $_REQUEST['service_location'];
$title = $_REQUEST['title'];
$term_one = $_REQUEST['term_one'];
$term_two = $_REQUEST['term_two'];
$term_three = $_REQUEST['term_three'];
$term_four = $_REQUEST['term_four'];
$pass_topic = $_REQUEST['pass_topic'];
$pass_desc = $_REQUEST['pass_desc'];


if (isset($_POST['save']))       {

include "saveGuestPass.php";

$savePass = new saveGuestPass();
$savePass-> setLocationId($service_location);
$savePass-> setGuestPassTitle($title);
$savePass-> setTermOne($term_one);
$savePass-> setTermTwo($term_two);
$savePass-> setTermThree($term_three);
$savePass-> setTermFour($term_four);
$savePass-> setGuestPassTopic($pass_topic);
$savePass-> setGuestPassDescription($pass_desc);
$savePass-> saveGuestPassBasic();

     if(isset($_POST['service_types1'])) {
        //loop through the check boxes
         foreach($_POST['service_types1'] as $value1) {
               $valueArray = explode("|", $value1);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1]; 
               $savePass-> setClubId($club_id);
               $savePass-> setServiceKey($service_key);
               $savePass-> saveServices();                      
              }              
        }
        
$confirmation = "Guest Pass $title Successfully Saved";   

}




$all_select =0;
include "../clubs/clubDrops.php";
$club_id = '0';
$service_location = 'All';
$clubDrops = new clubDrops();
$clubDrops-> setClubId($club_id);
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setServiceLocation($service_location);
$drop_menu = $clubDrops -> loadMenu(); 

include "../marketingtools/guestPassServices.php";
$club_id = '0';
$emp_type = '1';
$service_switch = '1';
$service_drop = new guestPassServices();
$service_drop->setClubId($club_id);
$services_list = $service_drop->makeDropDown(); 




$page_title = 'Create Guest Pass';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtGuestPass.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/createGuestPass.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(43);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/createGuestPassTemplate.php";


?>