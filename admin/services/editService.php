<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "serviceSql.php";

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];


//--------------------------------------------------------------------------------------
//this sets up the check boxes
function parseChecked($accessBitMap, $index_num)  {

      $accessBitArray = str_split($accessBitMap);
      $checked = $accessBitArray[$index_num];

      if($checked == 1)  {
        $check_status = "checked";
       }else{
        $check_status = "";
       }

   return $check_status;
   
   }
//---------------------------------------------------------------------------------------
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
$access4 = $_REQUEST['access4'];
$search_string = $_REQUEST['search_string'];
$service_key = $_REQUEST['service_key'];
$cost_key = $_REQUEST['cost_key'];
$club_name = $_REQUEST['club_name'];
$club_id = $_REQUEST['club_id'];
$commission_type1 = $_REQUEST['commission_type1'];
$commission_type2 = $_REQUEST['commission_type2'];
$commission_type3 = $_REQUEST['commission_type3'];
$commission_type4 = $_REQUEST['commission_type4'];


if($marker == 1)  {
  //this is for if the edit has been submitted, updates the form and parses results


$accesslevel = $_SESSION['access_level'];


//this is needed to pass the club name from the form since the original list has the same var as the form
$updateService = new serviceSql();
$updateService ->setClubId($service_location);
$club_name = $updateService ->loadClubName(); 

//this trims the varsan gets rid of unwanted charachters
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


//now we update the database with the new info

//here we set the service key and the cost key array
$updateService -> setServiceKey($service_key);
$updateService -> setCostKey($cost_key);

$updateService -> setGroupType($group_type);
$updateService -> setServiceType($service_type);
$updateService -> setServiceDesc($service_desc);
$updateService -> setServiceLocation($service_location);
$updateService -> setBundleClass($bundle);

$updateService -> setServiceQuantityOne($service_quantity1);
$updateService -> setDurationOne($duration1);
$updateService -> setServiceCostOne($service_cost1);
$updateService -> setAccessLevelOne($access1);

$updateService -> setServiceQuantityTwo($service_quantity2);
$updateService -> setDurationTwo($duration2);
$updateService -> setServiceCostTwo($service_cost2);
$updateService -> setAccessLevelTwo($access2);

$updateService -> setServiceQuantityThree($service_quantity3);
$updateService -> setDurationThree($duration3);
$updateService -> setServiceCostThree($service_cost3);
$updateService -> setAccessLevelThree($access3);

$updateService -> setServiceQuantityFour($service_quantity4);
$updateService -> setDurationFour($duration4);
$updateService -> setServiceCostFour($service_cost4);
$updateService -> setAccessLevelThree($access4);

//this sets up if there is a percent or null in the commission type
switch($commission_type1) {          
                       case"F":
                       $updateService ->setFlatFeeOne($commission_amount1);
                       $updateService ->setCommissionPercentOne(null);                    
                       break;
                       case"P":
                       $updateService ->setFlatFeeOne(null);
                       $updateService ->setCommissionPercentOne($commission_amount1);                        
                       break;
                       case"":
                       $updateService ->setFlatFeeOne(null);
                       $updateService ->setCommissionPercentOne(null);   
                       break;
                       }                     
switch($commission_type2) {          
                       case"F":
                       $updateService ->setFlatFeeTwo($commission_amount2);
                       $updateService ->setCommissionPercentTwo(null);                    
                       break;
                       case"P":
                       $updateService ->setFlatFeeTwo(null);
                       $updateService ->setCommissionPercentTwo($commission_amount2);                        
                       break;
                       case"":
                       $updateService ->setFlatFeeTwo(null);
                       $updateService ->setCommissionPercentTwo(null);   
                       break;
                       }                     
switch($commission_type3) {          
                       case"F":
                       $updateService ->setFlatFeeThree($commission_amount3);
                       $updateService ->setCommissionPercentThree(null);                    
                       break;
                       case"P":
                       $updateService ->setFlatFeeThree(null);
                       $updateService ->setCommissionPercentThree($commission_amount3);                        
                       break;
                       case"":
                       $updateService ->setFlatFeeThree(null);
                       $updateService ->setCommissionPercentThree(null);   
                       break;
                       }                     
switch($commission_type4) {          
                       case"F":
                       $updateService ->setFlatFeeFour($commission_amount4);
                       $updateService ->setCommissionPercentFour(null);                    
                       break;
                       case"P":
                       $updateService ->setFlatFeeFour(null);
                       $updateService ->setCommissionPercentFour($commission_amount4);                        
                       break;
                       case"":
                       $updateService ->setFlatFeeFour(null);
                       $updateService ->setCommissionPercentFour(null);   
                       break;
                       }                     



$confirmation = $updateService -> updateService();

include "groupDrops.php";
include "serviceDrops.php";
include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setClubId($service_location);
$clubDrops -> setServiceLocation($club_name);
$drop_menu = $clubDrops -> loadMenu();

//this sets up the drop menues for the service duration
$serviceDrops = new serviceDrops();
$serviceDrops -> setClubId($service_location);
$serviceDrops -> setServiceKey($service_key);


$groupDrops = new groupDrops();
$groupDrops -> setGroupType($group_type);
$group_menu = $groupDrops -> loadGroupMenu(); 


//get the array for the service duration drops
$serviceMenus = $serviceDrops->parseMenus();
//split the service menu array
$serviceMenuArray = explode("|",$serviceMenus);
$serviceMenu1 = $serviceMenuArray[0];
$serviceMenu2 = $serviceMenuArray[1];
$serviceMenu3 = $serviceMenuArray[2];
$serviceMenu4 = $serviceMenuArray[3];

//now get the comission type menu
$commissionMenus = $serviceDrops->parseCommissionMenu();
$commissionMenuArray = explode("|",$commissionMenus);
$commissionMenu1 = $commissionMenuArray[0];
$commissionMenu2 = $commissionMenuArray[1];
$commissionMenu3 = $commissionMenuArray[2];
$commissionMenu4 = $commissionMenuArray[3];

//now we get the commission or flat fee amount
$commissionAmount = $serviceDrops->getCommissionList();
$commissionAmountArray = explode("|",$commissionAmount);
$commission_amount1 = $commissionAmountArray[0];
$commission_amount2 = $commissionAmountArray[1];
$commission_amount3 = $commissionAmountArray[2];
$commission_amount4 = $commissionAmountArray[3];


//now we get the access limit
$accessLimits = $serviceDrops->parseAccessLimit();
$accessLimitsArray = explode("|",$accessLimits);
$access1 = $accessLimitsArray[0];
$access2 = $accessLimitsArray[1];
$access3 = $accessLimitsArray[2];
$access4 = $accessLimitsArray[3];

//get the check status
$checked_one_1 = parseChecked($access1, 0);
$checked_one_2 = parseChecked($access1, 1);
$checked_one_3 = parseChecked($access1, 2);
$checked_one_4 = parseChecked($access1, 3);
$checked_one_5 = parseChecked($access1, 4);
$checked_one_6 = parseChecked($access1, 5);
$checked_one_7 = parseChecked($access1, 6);

$checked_two_1 = parseChecked($access2, 0);
$checked_two_2 = parseChecked($access2, 1);
$checked_two_3 = parseChecked($access2, 2);
$checked_two_4 = parseChecked($access2, 3);
$checked_two_5 = parseChecked($access2, 4);
$checked_two_6 = parseChecked($access2, 5);
$checked_two_7 = parseChecked($access2, 6);

$checked_three_1 = parseChecked($access3, 0);
$checked_three_2 = parseChecked($access3, 1);
$checked_three_3 = parseChecked($access3, 2);
$checked_three_4 = parseChecked($access3, 3);
$checked_three_5 = parseChecked($access3, 4);
$checked_three_6 = parseChecked($access3, 5);
$checked_three_7 = parseChecked($access3, 6);

$checked_four_1 = parseChecked($access4, 0);
$checked_four_2 = parseChecked($access4, 1);
$checked_four_3 = parseChecked($access4, 2);
$checked_four_4 = parseChecked($access4, 3);
$checked_four_5 = parseChecked($access4, 4);
$checked_four_6 = parseChecked($access4, 5);
$checked_four_7 = parseChecked($access4, 6);


//sets up the varibles for the form template
$submit_link = 'editService.php';
$submit_name = 'update';
$page_title  = "Edit Service $service_type";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/serviceCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtService.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/disableServiceDuration.js\"></script>";
$service_key_hidden = "<input type=\"hidden\" name=\"service_key\" value=\"$service_key\" />";
$cost_key_hidden = "<input type=\"hidden\" name=\"cost_key\" value=\"$cost_key\"/>\n";

if($bundle == 'Y') {
  $check_default1 = "";
  $check_default2 = 'checked';  
  $javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/disableServiceDurationTwo.js\"></script>";  
  }elseif($bundle == 'N') {
  $check_default2 = ""; 
  $check_default1 = 'checked';  
  }

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(16);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/serviceTemplate.php";

}

//===============================================================

//check to see if this is an edit or a delete
if (isset($_POST['edit']))       {


include "groupDrops.php";
$groupDrops = new groupDrops();
$groupDrops -> setGroupType($group_type);
$group_menu = $groupDrops -> loadGroupMenu(); 


include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setClubId($club_id);
$clubDrops -> setServiceLocation($service_location);

$drop_menu = $clubDrops -> loadMenu();

include "serviceDrops.php";
$serviceDrops = new serviceDrops();
$serviceDrops -> setClubId($clubId);
$serviceDrops -> setServiceKey($service_key);

//get the array for the drops
$serviceMenus = $serviceDrops->parseMenus();
//split the service menu array
$serviceMenuArray = explode("|",$serviceMenus);
$serviceMenu1 = $serviceMenuArray[0];
$serviceMenu2 = $serviceMenuArray[1];
$serviceMenu3 = $serviceMenuArray[2];
$serviceMenu4 = $serviceMenuArray[3];


//now get the vars for the service quantity
$serviceQuantity = $serviceDrops->parseQuantity();
$serviceQuantityArray = explode("|",$serviceQuantity);
$service_quantity1 = $serviceQuantityArray[0];
$service_quantity2 = $serviceQuantityArray[1];
$service_quantity3 = $serviceQuantityArray[2];
$service_quantity4 = $serviceQuantityArray[3];

//get the vars fopr the cost
$serviceCost = $serviceDrops->parseCost();
$serviceCostArray = explode("|",$serviceCost);
$service_cost1 = $serviceCostArray[0];
$service_cost2 = $serviceCostArray[1];
$service_cost3 = $serviceCostArray[2];
$service_cost4 = $serviceCostArray[3];

//now get the comission type menu
$commissionMenus = $serviceDrops->parseCommissionMenu();
$commissionMenuArray = explode("|",$commissionMenus);
$commissionMenu1 = $commissionMenuArray[0];
$commissionMenu2 = $commissionMenuArray[1];
$commissionMenu3 = $commissionMenuArray[2];
$commissionMenu4 = $commissionMenuArray[3];

//now we get the commission or flat fee amount
$commissionAmount = $serviceDrops->getCommissionList();
$commissionAmountArray = explode("|",$commissionAmount);
$commission_amount1 = $commissionAmountArray[0];
$commission_amount2 = $commissionAmountArray[1];
$commission_amount3 = $commissionAmountArray[2];
$commission_amount4 = $commissionAmountArray[3];

//now we get the access limit
$accessLimits = $serviceDrops->parseAccessLimit();
$accessLimitsArray = explode("|",$accessLimits);
$access1 = $accessLimitsArray[0];
$access2 = $accessLimitsArray[1];
$access3 = $accessLimitsArray[2];
$access4 = $accessLimitsArray[3];

//get the check status
$checked_one_1 = parseChecked($access1, 0);
$checked_one_2 = parseChecked($access1, 1);
$checked_one_3 = parseChecked($access1, 2);
$checked_one_4 = parseChecked($access1, 3);
$checked_one_5 = parseChecked($access1, 4);
$checked_one_6 = parseChecked($access1, 5);
$checked_one_7 = parseChecked($access1, 6);

$checked_two_1 = parseChecked($access2, 0);
$checked_two_2 = parseChecked($access2, 1);
$checked_two_3 = parseChecked($access2, 2);
$checked_two_4 = parseChecked($access2, 3);
$checked_two_5 = parseChecked($access2, 4);
$checked_two_6 = parseChecked($access2, 5);
$checked_two_7 = parseChecked($access2, 6);

$checked_three_1 = parseChecked($access3, 0);
$checked_three_2 = parseChecked($access3, 1);
$checked_three_3 = parseChecked($access3, 2);
$checked_three_4 = parseChecked($access3, 3);
$checked_three_5 = parseChecked($access3, 4);
$checked_three_6 = parseChecked($access3, 5);
$checked_three_7 = parseChecked($access3, 6);

$checked_four_1 = parseChecked($access4, 0);
$checked_four_2 = parseChecked($access4, 1);
$checked_four_3 = parseChecked($access4, 2);
$checked_four_4 = parseChecked($access4, 3);
$checked_four_5 = parseChecked($access4, 4);
$checked_four_6 = parseChecked($access4, 5);
$checked_four_7 = parseChecked($access4, 6);


if($bundle == 'Y') {
  $check_default1 = "";
  $check_default2 = 'checked';  
  $javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/disableServiceDurationTwo.js\"></script>";  
  }elseif($bundle == 'N') {
  $check_default2 = ""; 
  $check_default1 = 'checked';  
  }
//----------------------------------------------------------------------------------------


//get the cost key for th update submit
$cost_key = $serviceDrops->parseKey();
$cost_key_hidden = "<input type=\"hidden\" name=\"cost_key\" value=\"$cost_key\"/>\n";


//sets up the varibles for the form template
$submit_link = 'editService.php';
$submit_name = 'update';
$page_title  = "Edit Service $service_type";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/serviceCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtService.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/disableServiceDuration.js\"></script>";

$service_key_hidden = "<input type=\"hidden\" name=\"service_key\" value=\"$service_key\" />";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(16);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/serviceTemplate.php";



}

//===================================================================================
if (isset($_POST['delete']))       {

$deleteService = new serviceSql();
$deleteService -> setServiceType($service_type);
$deleteService -> setServiceLocation($service_location);
$deleteService -> setServiceKey($service_key);

$confirmation = $deleteService -> deleteService();



//set the search type to three which is all
$search_type = "4";

include "serviceLists.php";
$getLists = new serviceLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();
//$result2 = $getLists -> getUserForm();

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(15);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";



//check tp see if there are multi results or not
if($result1 != "") {
include "../templates/serviceListTemplate.php";
exit;
}


}




?>