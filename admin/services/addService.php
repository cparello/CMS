<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//print_r($_POST);
$marker = $_REQUEST['marker'];
$service_quantity1 = $_REQUEST['service_quantity1'];
$service_quantity2 = $_REQUEST['service_quantity2'];
$service_quantity3 = $_REQUEST['service_quantity3'];
$service_quantity4 = $_REQUEST['service_quantity4'];
$service_cost1 = $_REQUEST['service_cost1'];
$service_cost2 = $_REQUEST['service_cost2'];
$service_cost3 = $_REQUEST['service_cost3'];
$service_cost4 = $_REQUEST['service_cost4'];
$commission_amount1 = $_REQUEST['commission_amount1'];
$commission_amount2 = $_REQUEST['commission_amount2'];
$commission_amount3 = $_REQUEST['commission_amount3'];
$commission_amount4 = $_REQUEST['commission_amount4'];
$service_type = $_REQUEST['service_type'];
$service_desc = $_REQUEST['service_desc'];
$service_location = $_REQUEST['service_location'];
$group_type = $_REQUEST['group_type'];
$bundle = $_REQUEST['bundle'];
$duration1 = $_REQUEST['duration1'];
$access1 = $_REQUEST['access1'];
$duration2 = $_REQUEST['duration2'];
$access2 = $_REQUEST['access2'];
$duration3 = $_REQUEST['duration3'];
$access3 = $_REQUEST['access3'];
$duration4 = $_REQUEST['duration4'];
$access4 = $_REQUEST['access4 '];


//sets up the varibles for the form template
$submit_link = 'addService.php';
$submit_name = 'save';
$page_title  = 'Add Services';
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/serviceCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtService.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/disableServiceDuration.js\"></script>";

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

include "serviceDrops.php";
$serviceDrops = new serviceDrops();
$serviceMenu = $serviceDrops->loadServiceMenu($null,$null);
$commissionMenu = $serviceDrops->loadCommissionMenu(null,null);



include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$drop_menu = $clubDrops -> loadMenu(); 

include "groupDrops.php";
$groupDrops = new groupDrops();
$group_menu = $groupDrops -> loadGroupMenu(); 


//if form is submitted save to database
if ($marker == 1) {

//taken from ajax call on submit of form
$access_level = $_SESSION['access_level'];

$service_quantity1 = trim($service_quantity1);
$service_quantity2 = trim($service_quantity2);
$service_quantity3 = trim($service_quantity3);
$service_quantity4 = trim($service_quantity4);
$service_cost1 = trim($service_cost1);
$service_cost2 = trim($service_cost2);
$service_cost3 = trim($service_cost3);
$service_cost4 = trim($service_cost4);

//filter out any non numericle charachters
$service_cost1 = preg_replace("/[^0-9 .]+/", "" ,$service_cost1);
$service_cost2 = preg_replace("/[^0-9 .]+/", "" ,$service_cost2);
$service_cost3 = preg_replace("/[^0-9 .]+/", "" ,$service_cost3);
$service_cost4 = preg_replace("/[^0-9 .]+/", "" ,$service_cost4);
$commission_amount1 = preg_replace("/[^0-9 .]+/", "" ,$commission_amount1);
$commission_amount2 = preg_replace("/[^0-9 .]+/", "" ,$commission_amount2);
$commission_amount3 = preg_replace("/[^0-9 .]+/", "" ,$commission_amount3);
$commission_amount4 = preg_replace("/[^0-9 .]+/", "" ,$commission_amount4);




//echo "$bundle";
///exit;



//save to the database
include "serviceSql.php";
$saveService = new serviceSql();
$saveService -> setServiceType($service_type);
$saveService -> setServiceDesc($service_desc);
$saveService -> setServiceLocation($service_location);
$saveService -> setGroupType($group_type);
$saveService -> setBundleClass($bundle);

$saveService -> setServiceQuantityOne($service_quantity1);
$saveService -> setDurationOne($duration1);
$saveService -> setServiceCostOne($service_cost1);
$saveService -> setAccessLevelOne($access1);

$saveService -> setServiceQuantityTwo($service_quantity2);
$saveService -> setDurationTwo($duration2);
$saveService -> setServiceCostTwo($service_cost2);
$saveService -> setAccessLevelTwo($access2);

$saveService -> setServiceQuantityThree($service_quantity3);
$saveService -> setDurationThree($duration3);
$saveService -> setServiceCostThree($service_cost3);
$saveService -> setAccessLevelThree($access3);

$saveService -> setServiceQuantityFour($service_quantity4);
$saveService -> setDurationFour($duration4);
$saveService -> setServiceCostFour($service_cost4);
$saveService -> setAccessLevelFour($access4);


//this sets up if there is a percent or null in the commission type
switch($commission_type1) {          
                       case"F":
                       $saveService ->setFlatFeeOne($commission_amount1);
                       $saveService ->setCommissionPercentOne(null);                    
                       break;
                       case"P":
                       $saveService ->setFlatFeeOne(null);
                       $saveService ->setCommissionPercentOne($commission_amount1);                        
                       break;
                       case"":
                       $saveService ->setFlatFeeOne(null);
                       $saveService ->setCommissionPercentOne(null);   
                       break;
                       }                     
switch($commission_type2) {          
                       case"F":
                       $saveService ->setFlatFeeTwo($commission_amount2);
                       $saveService ->setCommissionPercentTwo(null);                    
                       break;
                       case"P":
                       $saveService ->setFlatFeeTwo(null);
                       $saveService ->setCommissionPercentTwo($commission_amount2);                        
                       break;
                       case"":
                       $saveService ->setFlatFeeTwo(null);
                       $saveService ->setCommissionPercentTwo(null);   
                       break;
                       }                     
switch($commission_type3) {          
                       case"F":
                       $saveService ->setFlatFeeThree($commission_amount3);
                       $saveService ->setCommissionPercentThree(null);                    
                       break;
                       case"P":
                       $saveService ->setFlatFeeThree(null);
                       $saveService ->setCommissionPercentThree($commission_amount3);                        
                       break;
                       case"":
                       $saveService ->setFlatFeeThree(null);
                       $saveService ->setCommissionPercentThree(null);   
                       break;
                       }                     
switch($commission_type4) {          
                       case"F":
                       $saveService ->setFlatFeeFour($commission_amount4);
                       $saveService ->setCommissionPercentFour(null);                    
                       break;
                       case"P":
                       $saveService ->setFlatFeeFour(null);
                       $saveService ->setCommissionPercentFour($commission_amount4);                        
                       break;
                       case"":
                       $saveService ->setFlatFeeFour(null);
                       $saveService ->setCommissionPercentFour(null);   
                       break;
                       }                     



$confirmation = $saveService-> saveService();

//set the vars to nul so the will not carry
$service_type ="";
$service_desc ="";
$service_location = "";
$service_quantity1 ="";
$duration1 = "";
$service_cost1 ="";
$commission_amount1 ="";
$service_quantity2 ="";
$duration2 = "";
$service_cost2 ="";
$commission_amount2 ="";
$service_quantity3 ="";
$duration3 ="";
$service_cost3 ="";
$commission_amount3 ="";
$service_quantity4 ="";
$duration4 ="";
$service_cost4 ="";
$commission_amount4 ="";
$access1 = "";
$access2 = "";
$access3 = "";
$access4 = "";


}

$check_default1 = 'checked';

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(13);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";



include "../templates/serviceTemplate.php";




?>



