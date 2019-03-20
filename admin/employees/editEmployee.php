<?php
include "employeeSql.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$emp_full_name = $_REQUEST['emp_full_name'];
$emp_user_id = $_REQUEST['emp_user_id'];


include "../getDrops.php";
include "employeeTypeDrops.php";
include "getServiceDrops.php";
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];



//================================================================
if (isset($_POST['delete']))       {

$delete = new employeeSql();
$delete-> setEmpFullName($emp_full_name);
$delete-> setUserId($emp_user_id);
$confirmation = $delete-> deleteEmployee();


$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];
$drop_description = $_SESSION['drop_description'];


include "employeeLists.php";
$getLists = new employeeLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists ->setDropDescription($drop_description);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();



//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(7);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";



//check tp see if there are multi results or not
if($result1 != "") {
include "../templates/employeeListTemplate.php";
exit;
}

}

//===============================================================

if (isset($_POST['edit']))       {

$load = new employeeSql();
$load-> setUserId($emp_user_id);
$load-> loadEmployee();

$first_name = $load-> getEmpFirstName();
$middle_name = $load-> getEmpMiddleName(); 
$last_name = $load-> getEmpLastName();
$street_address = $load-> getEmpStreet(); 
$city = $load-> getEmpCity(); 
$state = $load-> getEmpState();
//echo "st $state";
$zip_code = $load-> getEmpZip();
$home_phone = $load-> getEmpPhone1();
$cell_phone = $load-> getEmpPhone2();
$emergency_contact = $load-> getEmergencyContact();
$emergency_phone = $load-> getEmergencyPhone();
$user_name1 = $load-> getUserName(); 
$pass_word1= $load-> getPassWord();
$pass_word2 = $pass_word1;
$full_name = $load-> getEmpFullName();
$ss_number = $load-> getSocialSecurity();

//this gets the keys fo the employee type drops
$employee_type1 = $load->getTypeKey1();
$employee_type2 = $load->getTypeKey2();
$employee_type3 = $load->getTypeKey3();
$employee_type4 = $load->getTypeKey4();

//this gets the compensation type for the dropdowns
$compensation_type1 = $load-> getCompensationType1();
$compensation_type2 = $load-> getCompensationType2();
$compensation_type3 = $load-> getCompensationType3();
$compensation_type4 = $load-> getCompensationType4();


//get the compensation amount 
$payment_amount1 = $load-> getCompensationAmount1();
$payment_amount2 = $load-> getCompensationAmount2();
$payment_amount3 = $load-> getCompensationAmount3();
$payment_amount4 = $load-> getCompensationAmount4();

//this sets up the values for the payment cycle drops
$payment_cycle1 = $load-> getPaymentCycle1();
$payment_cycle2 = $load-> getPaymentCycle2();
$payment_cycle3 = $load-> getPaymentCycle3();
$payment_cycle4 = $load-> getPaymentCycle4();

//gets the id card numbers
$id_card1 = $load-> getIdCard1();
$id_card2 = $load-> getIdCard2();
$id_card3 = $load-> getIdCard3();
$id_card4 = $load-> getIdCard4();

//get the hours projected
$hours_projected1 = $load-> getHoursProjected1();
$hours_projected2 = $load-> getHoursProjected2();
$hours_projected3 = $load-> getHoursProjected3();
$hours_projected4 = $load-> getHoursProjected4();
$email = $load-> getEmail();
$monday_start_1 = $load-> getMondayStart1();

$monday_end_1 = $load-> getMondayEnd1();
$monday_start_2 = $load-> getMondayStart2();
$monday_end_2 = $load-> getMondayEnd2() ;
$tuesday_start_1 = $load-> getTuesdayStart1();
$tuesday_end_1 = $load-> getTuesdayEnd1();
$tuesday_start_2 = $load-> getTuesdayStart2();
$tuesday_end_2 = $load-> getTuesdayEnd2();
$wednesday_start_1 = $load-> getWednesdayStart1();
$wednesday_end_1 = $load->  getWednesdayEnd1();
$wednesday_start_2 = $load-> getWednesdayStart2();
$wednesday_end_2 = $load-> getWednesdayEnd2();
$thursday_start_1 = $load-> getThursdayStart1();
$thursday_end_1 = $load-> getThursdayEnd1();
$thursday_start_2 = $load-> getThursdayStart2();
$thursday_end_2 = $load-> getThursdayEnd2();
$friday_start_1 = $load-> getFridayStart1();
$friday_end_1 = $load-> getFridayEnd1();
$friday_start_2 = $load-> getFridayStart2();
$friday_end_2 = $load-> getFridayEnd2();
$saturday_start_1 = $load-> getSaturdayStart1();
$saturday_end_1 = $load-> getSaturdayEnd1();
$saturday_start_2 = $load-> getSaturdayStart2();
$saturday_end_2 = $load-> getSaturdayEnd2();
$sunday_start_1 = $load-> getSundayStart1();
$sunday_end_1 = $load-> getSundayEnd1();
$sunday_start_2 = $load-> getSundayStart2();
$sunday_end_2 = $load-> getSundayEnd2();

/*echo "$mHours = ($monday_end_1 - $monday_start_1) + ($monday_end_2 - $monday_start_2);
$tuHours = ($tuesday_end_1 - $tuesday_start_1) +  ($tuesday_end_2 - $tuesday_start_2);
$weHours = ($wednesday_end_1 - $wednesday_start_1) +  ($wednesday_end_2 - $wednesday_start_2);
$thHours = ($thursday_end_1 - $thursday_start_1) +  ($thursday_end_2 - $thursday_start_2);
$frHours = ($friday_end_1 - $friday_start_1) +  ($friday_end_2 -  $friday_start_2);
$saHours = ($saturday_end_1 - $saturday_start_1) +  ($saturday_end_2 - $saturday_start_2);
$suHours = ($sunday_end_1 - $sunday_start_1) +  ($sunday_end_2 - $sunday_start_2);
$totHours = $mHours + $tuHours +  $weHours + $thHours + $frHours + $saHours + $suHours;";*/
//these are the constant apps
$mHours = ($monday_end_1 - $monday_start_1) + ($monday_end_2 - $monday_start_2);
$tuHours = ($tuesday_end_1 - $tuesday_start_1) +  ($tuesday_end_2 - $tuesday_start_2);
$weHours = ($wednesday_end_1 - $wednesday_start_1) +  ($wednesday_end_2 - $wednesday_start_2);
$thHours = ($thursday_end_1 - $thursday_start_1) +  ($thursday_end_2 - $thursday_start_2);
$frHours = ($friday_end_1 - $friday_start_1) +  ($friday_end_2 -  $friday_start_2);
$saHours = ($saturday_end_1 - $saturday_start_1) +  ($saturday_end_2 - $saturday_start_2);
$suHours = ($sunday_end_1 - $sunday_start_1) +  ($sunday_end_2 - $sunday_start_2);
$totHours = $mHours + $tuHours +  $weHours + $thHours + $frHours + $saHours + $suHours;



//sets up the varibles for the form template
$page_title  = "Edit Employee $full_name";




}

//================================================================================
if (isset($_POST['update']))       {
$id_card1 = $_REQUEST['id_card1'];
$id_card2 = $_REQUEST['id_card2'];
$id_card3 = $_REQUEST['id_card3'];
$id_card4  = $_REQUEST['id_card4'];
$hours_projected1 = $_REQUEST['hours_projected1'];
$hours_projected2 = $_REQUEST['hours_projected2'];
$hours_projected3 = $_REQUEST['hours_projected3'];
$hours_projected4 = $_REQUEST['hours_projected4'];
$first_name = $_REQUEST['first_name'];
$middle_name = $_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$street_address = $_REQUEST['street_address'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip_code = $_REQUEST['zip_code'];
$home_phone = $_REQUEST['home_phone'];
$cell_phone = $_REQUEST['cell_phone'];
$emergency_contact = $_REQUEST['emergency_contact'];
$emergency_phone = $_REQUEST['emergency_phone'];
$user_name1 = $_REQUEST['user_name1'];
$pass_word1 = $_REQUEST['pass_word1'];
$pass_word2 = $_REQUEST['pass_word2'];
$ss_number = $_REQUEST['ss_number'];
$employee_type1 = $_REQUEST['employee_type1'];
$compensation_type1 = $_REQUEST['compensation_type1'];
$payment_amount1 = $_REQUEST['payment_amount1'];
$payment_cycle1 = $_REQUEST['payment_cycle1'];
$employee_type2 = $_REQUEST['employee_type2'];
$compensation_type2 = $_REQUEST['compensation_type2'];
$payment_amount2 = $_REQUEST['payment_amount2'];
$payment_cycle2 = $_REQUEST['payment_cycle2'];
$employee_type3 = $_REQUEST['employee_type3'];
$compensation_type3 = $_REQUEST['compensation_type3'];
$payment_amount3 = $_REQUEST['payment_amount3'];
$payment_cycle3 = $_REQUEST['payment_cycle3'];
$employee_type4 = $_REQUEST['employee_type4'];
$compensation_type4 = $_REQUEST['compensation_type4'];
$payment_amount4 = $_REQUEST['payment_amount4'];
$payment_cycle4 = $_REQUEST['payment_cycle4'];
$service_key = $_REQUEST['service_key'];
$club_id = $_REQUEST['club_id'];
$email = $_REQUEST['email'];
$monday_start_1 = $_REQUEST['monday_start_1'];
$monday_end_1 = $_REQUEST['monday_end_1'];
$monday_start_2 = $_REQUEST['monday_start_2'];
$monday_end_2 = $_REQUEST['monday_end_2'];
$tuesday_start_1 = $_REQUEST['tuesday_start_1'];;
$tuesday_end_1 = $_REQUEST['tuesday_end_1'];
$tuesday_start_2 = $_REQUEST['tuesday_start_2'];
$tuesday_end_2 = $_REQUEST['tuesday_end_2'];
$wednesday_start_1 = $_REQUEST['wednesday_start_1'];
$wednesday_end_1 = $_REQUEST['wednesday_end_1'];
$wednesday_start_2 = $_REQUEST['wednesday_start_2'];
$wednesday_end_2 = $_REQUEST['wednesday_end_2'];
$thursday_start_1 = $_REQUEST['thursday_start_1'];
$thursday_end_1 = $_REQUEST['thursday_end_1'];
$thursday_start_2  = $_REQUEST['thursday_start_2'];
$thursday_end_2  = $_REQUEST['thursday_end_2'];
$friday_start_1 = $_REQUEST['friday_start_1'];
$friday_end_1  = $_REQUEST['friday_end_1'];
$friday_start_2  = $_REQUEST['friday_start_2'];
$friday_end_2  = $_REQUEST['friday_end_2'];
$saturday_start_1  = $_REQUEST['saturday_start_1'];
$saturday_end_1  = $_REQUEST['saturday_end_1'];
$saturday_start_2  = $_REQUEST['saturday_start_2'];
$saturday_end_2  = $_REQUEST['saturday_end_2'];
$sunday_start_1  = $_REQUEST['sunday_start_1'];
$sunday_end_1  = $_REQUEST['sunday_end_1'];
$sunday_start_2  = $_REQUEST['sunday_start_2'];
$sunday_end_2 = $_REQUEST['sunday_end_2'];


$mHours = ($monday_end_1 - $monday_start_1) + ($monday_end_2 - $monday_start_2);
$tuHours = ($tuesday_end_1 - $tuesday_start_1) +  ($tuesday_end_2 - $tuesday_start_2);
$weHours = ($wednesday_end_1 - $wednesday_start_1) +  ($wednesday_end_2 - $wednesday_start_2);
$thHours = ($thursday_end_1 - $thursday_start_1) +  ($thursday_end_2 - $thursday_start_2);
$frHours = ($friday_end_1 - $friday_start_1) +  ($friday_end_2 -  $friday_start_2);
$saHours = ($saturday_end_1 - $saturday_start_1) +  ($saturday_end_2 - $saturday_start_2);
$suHours = ($sunday_end_1 - $sunday_start_1) +  ($sunday_end_2 - $sunday_start_2);
$totHours = $mHours + $tuHours +  $weHours + $thHours + $frHours + $saHours + $suHours;


//this filters out an non numeric characheters
$payment_amount1 = trim($payment_amount1);
$payment_amount2 = trim($payment_amount2);
$payment_amount3 = trim($payment_amount3);
$payment_amount4 = trim($payment_amount4);
$payment_amount1 = preg_replace("/[^0-9 .]+/", "" ,$payment_amount1); 
$payment_amount2 = preg_replace("/[^0-9 .]+/", "" ,$payment_amount2); 
$payment_amount3 = preg_replace("/[^0-9 .]+/", "" ,$payment_amount3); 
$payment_amount4 = preg_replace("/[^0-9 .]+/", "" ,$payment_amount4); 

$id_card1 = trim($id_card1);
$id_card2 = trim($id_card2);
$id_card3 = trim($id_card3);
$id_card4 = trim($id_card4);
$id_card1 = preg_replace("/[^0-9 .]+/", "" ,$id_card1);
$id_card2 = preg_replace("/[^0-9 .]+/", "" ,$id_card2);
$id_card3 = preg_replace("/[^0-9 .]+/", "" ,$id_card3);
$id_card4 = preg_replace("/[^0-9 .]+/", "" ,$id_card4);

$hours_projected1 = trim($hours_projected1);
$hours_projected2 = trim($hours_projected2);
$hours_projected3 = trim($hours_projected3);
$hours_projected4 = trim($hours_projected4);
$hours_projected1 = preg_replace("/[^0-9 .]+/", "" ,$hours_projected1); 
$hours_projected2 = preg_replace("/[^0-9 .]+/", "" ,$hours_projected2); 
$hours_projected3 = preg_replace("/[^0-9 .]+/", "" ,$hours_projected3); 
$hours_projected4 = preg_replace("/[^0-9 .]+/", "" ,$hours_projected4); 

$employee_info = new employeeSql();
$employee_info->setUserId($emp_user_id);
$employee_info ->setEmpFirstName($first_name); 
$employee_info ->setEmpMiddleName($middle_name); 
$employee_info ->setEmpLastName($last_name); 
$employee_info ->setEmpStreet($street_address);
$employee_info ->setEmpCity($city);
$employee_info ->setEmpState($state);
$employee_info ->setEmpZip($zip_code);
$employee_info ->setEmpPhone1($home_phone);
$employee_info ->setEmpPhone2($cell_phone);
$employee_info ->setEmergencyContact($emergency_contact);
$employee_info ->setEmergencyPhone($emergency_phone);
$employee_info ->setUserName($user_name1);
$employee_info ->setPassWord($pass_word1);
$employee_info ->setSocialSecurity($ss_number);

$employee_info ->setTypeKey1($employee_type1);
$employee_info ->setCompensationType1($compensation_type1);
$employee_info ->setCompensationAmount1($payment_amount1);
$employee_info ->setPaymentCycle1($payment_cycle1);

$employee_info ->setTypeKey2($employee_type2);
$employee_info ->setCompensationType2($compensation_type2);
$employee_info ->setCompensationAmount2($payment_amount2);
$employee_info ->setPaymentCycle2($payment_cycle2);

$employee_info ->setTypeKey3($employee_type3);
$employee_info ->setCompensationType3($compensation_type3);
$employee_info ->setCompensationAmount3($payment_amount3);
$employee_info ->setPaymentCycle3($payment_cycle3);

$employee_info ->setTypeKey4($employee_type4);
$employee_info ->setCompensationType4($compensation_type4);
$employee_info ->setCompensationAmount4($payment_amount4);
$employee_info ->setPaymentCycle4($payment_cycle4);

$employee_info ->setIdCard1($id_card1);
$employee_info ->setIdCard2($id_card2);
$employee_info ->setIdCard3($id_card3);
$employee_info ->setIdCard4($id_card4);

$employee_info ->setHoursProjected1($hours_projected1);
$employee_info ->setHoursProjected2($hours_projected2);
$employee_info ->setHoursProjected3($hours_projected3);
$employee_info ->setHoursProjected4($hours_projected4);
$employee_info ->setMondayStart1($monday_start_1);
$employee_info ->setMondayEnd1($monday_end_1);
$employee_info ->setMondayStart2($monday_start_2);
$employee_info ->setMondayEnd2($monday_end_2) ;
$employee_info ->setTuesdayStart1($tuesday_start_1);
$employee_info ->setTuesdayEnd1($tuesday_end_1);
$employee_info ->setTuesdayStart2($tuesday_start_2);
$employee_info ->setTuesdayEnd2($tuesday_end_2);
$employee_info ->setWednesdayStart1($wednesday_start_1);
$employee_info ->setWednesdayEnd1($wednesday_end_1);
$employee_info ->setWednesdayStart2($wednesday_start_2);
$employee_info ->setWednesdayEnd2($wednesday_end_2);
$employee_info ->setThursdayStart1($thursday_start_1);
$employee_info ->setThursdayEnd1($thursday_end_1);
$employee_info ->setThursdayStart2($thursday_start_2);
$employee_info ->setThursdayEnd2($thursday_end_2);
$employee_info ->setFridayStart1($friday_start_1);
$employee_info ->setFridayEnd1($friday_end_1);
$employee_info ->setFridayStart2($friday_start_2);
$employee_info ->setFridayEnd2($friday_end_2);
$employee_info ->setSaturdayStart1($saturday_start_1);
$employee_info ->setSaturdayEnd1($saturday_end_1);
$employee_info ->setSaturdayStart2($saturday_start_2);
$employee_info ->setSaturdayEnd2($saturday_end_2);
$employee_info ->setSundayStart1($sunday_start_1);
$employee_info ->setSundayEnd1($sunday_end_1);
$employee_info ->setSundayStart2($sunday_start_2);
$employee_info ->setSundayEnd2($sunday_end_2);


include "serviceSave.php";


//-----------------------------------------------------------------------------------------------------------------
//if the check box  is set to delete then update
if (isset($_POST['access1'])) {
$employee_info ->setTypeKey1(null);
$employee_info ->setPaymentCycle1(null);
$employee_info ->setCompensationType1(null);
$employee_info ->setCompensationAmount1(null);
$employee_type1 = $_REQUEST['employee_type1'];
$employee_type2 = $_REQUEST['employee_type2'];
$employee_type3 = $_REQUEST['employee_type3'];
$employee_type4 = $_REQUEST['employee_type4'];
//this sets up the club id  for the deletion of the sales commission service types
$employee_info->deleteServices($employee_type1);

//set the visuals for the drop downs
$employee_type1 = null;
$payment_cycle1 = null;
$compensation_type1 = null;
$payment_amount1 = null;
$id_card1 = null;
$hours_projected1 = null;
}


//if the check box  is set to delete then update
if (isset($_POST['access2'])) {
$employee_info ->setTypeKey2(null);
$employee_info ->setPaymentCycle2(null);
$employee_info ->setCompensationType2(null);
$employee_info ->setCompensationAmount2(null);

//this sets up the club id  for the deletion of the sales commission service types
$employee_info->deleteServices($employee_type2);

//set the visuals for the drop downs
$employee_type2 = null;
$payment_cycle2 = null;
$compensation_type2 = null;
$payment_amount2 = null;
$id_card2 = null;
$hours_projected2 = null;
}


//if the check box  is set to delete then update
if (isset($_POST['access3'])) {
$employee_info ->setTypeKey3(null);
$employee_info ->setPaymentCycle3(null);
$employee_info ->setCompensationType3(null);
$employee_info ->setCompensationAmount3(null);

//this sets up the club id  for the deletion of the sales commission service types
$employee_info->deleteServices($employee_type3);

//set the visuals for the drop downs
$employee_type3 = null;
$payment_cycle3 = null;
$compensation_type3 = null;
$payment_amount3 = null;
$id_card3 = null;
$hours_projected3 = null;
}


//if the check box  is set to delete then update
if (isset($_POST['access4'])) {
$employee_info ->setTypeKey4(null);
$employee_info ->setPaymentCycle4(null);
$employee_info ->setCompensationType4(null);
$employee_info ->setCompensationAmount4(null);

//this sets up the club id  for the deletion of the sales commission service types
$employee_info->deleteServices($employee_type4);

//set the visuals for the drop downs
$employee_type4 = null;
$payment_cycle4 = null;
$compensation_type4 = null;
$payment_amount4 = null;
$id_card4 = null;
$hours_projected4 = null;
}

//---------------------------------------------------------------------------------------------------------------------

$confirmation = $employee_info ->updateEmployee();

$page_title  = "Edit Employee $first_name $middle_name $last_name";



}
//================================================================




$submit_link = 'editEmployee.php';
$submit_name = 'update';
$button_title = 'Update Employee Contact / Type Information';
$file_permissions = "";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/employeeCheck2.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/userName2.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/commissionFields.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/showServices.js\"></script>";   //will need to adjust this for edit mode
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployee.js\"></script>";


$onLoad = '  onLoad="comFields()"';
$hidden = "<input name=\"emp_user_id\" type=\"hidden\" id=\"emp_user_id\" value=\"$emp_user_id\" />";
$userIdVar =",'$emp_user_id'";
/*
$state = $_REQUEST['state'];
$compensation_type1 = $_REQUEST['compensation_type1'];
$payment_amount1 = $_REQUEST['payment_amount1'];
$compensation_type2 = $_REQUEST['compensation_type2'];
$payment_amount2 = $_REQUEST['payment_amount2'];
$compensation_type3 = $_REQUEST['compensation_type3'];
$payment_amount3 = $_REQUEST['payment_amount3'];
$compensation_type4 = $_REQUEST['compensation_type4'];
$payment_amount4 = $_REQUEST['payment_amount4'];
$employee_type1 = $_REQUEST['employee_type1'];
$employee_type2 = $_REQUEST['employee_type2'];
$employee_type3 = $_REQUEST['employee_type3'];
$employee_type4 = $_REQUEST['employee_type4'];*/
//get the state for the dropdown menu
$state_option = getStateOption($state);
$cycle_option1 = getPaymentCycle($payment_cycle1);
$cycle_option2 = getPaymentCycle($payment_cycle2);
$cycle_option3 = getPaymentCycle($payment_cycle3);
$cycle_option4 = getPaymentCycle($payment_cycle4);
$compensation_option1 = getCompensationType($compensation_type1);
$compensation_option2 = getCompensationType($compensation_type2);
$compensation_option3 = getCompensationType($compensation_type3);
$compensation_option4 = getCompensationType($compensation_type4);

$employeeDrops = new employeeTypeDrops();


//this gets the employee drop downs
//this sets  flag keys so that employee types are not duplicated in othe drop downs
$types_array = "$employee_type1|$employee_type2|$employee_type3|$employee_type4|";
$employeeDrops->setEmpTypeArray($types_array);



$employeeDrops-> setTypeKey($employee_type1);
$drop_menu_emp1 = $employeeDrops-> loadTypeMenu(); 
//this sets a flag using the club id as to creating the service drop down if the employe is in sales
$marker1 = $employeeDrops->getMarker();

$employeeDrops-> setTypeKey($employee_type2);
$drop_menu_emp2 = $employeeDrops-> loadTypeMenu(); 
//this sets a flag as to creating the service drop down if the employe is in sales
$marker2 = $employeeDrops->getMarker();

$employeeDrops-> setTypeKey($employee_type3);
$drop_menu_emp3 = $employeeDrops-> loadTypeMenu(); 
//this sets a flag as to creating the service drop down if the employe is in sales
$marker3 = $employeeDrops->getMarker();

$employeeDrops-> setTypeKey($employee_type4);
$drop_menu_emp4 = $employeeDrops-> loadTypeMenu(); 
//this sets a flag as to creating the service drop down if the employe is in sales
$marker4 = $employeeDrops->getMarker();



//now we parse out the service lists if the exist
$service_drop = new makeServiceDrops();
//set the employee id number
$service_drop->setUserId($emp_user_id);

//first we set the employee type category   and the club id
$service_drop->setEmpTypeCat(1);
$service_drop->setClubId($marker1);
$service_drop->createParseList();
$service_header1 = $service_drop->getServiceHeader();
$service_list1 = $service_drop->getDropList();
//get the drop down group types
$category_header1 = $service_drop->getCategoryHeader();
$category_list1 = $service_drop->getCategoryList();



//add the javascript pop up link
if($service_list1 != null) {
$service_list1 = "$service_list1 <a href=\"javascript: void\" id=\"pos3\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -20, -70, 'pos3', 3 );\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
}

$service_drop->setEmpTypeCat(2);
$service_drop->setClubId($marker2);
$service_drop->createParseList();
$service_header2 = $service_drop->getServiceHeader();
$service_list2 = $service_drop->getDropList();
//get the drop down group types
$category_header2 = $service_drop->getCategoryHeader();
$category_list2 = $service_drop->getCategoryList();

//add the javascript pop up link
if($service_list2 != null) {
$service_list2 = "$service_list2 <a href=\"javascript: void\" id=\"pos5\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -20, -70, 'pos5', 3 );\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
}

$service_drop->setEmpTypeCat(3);
$service_drop->setClubId($marker3);
$service_drop->createParseList();
$service_header3 = $service_drop->getServiceHeader();
$service_list3 = $service_drop->getDropList();
//get the drop down group types
$category_header3 = $service_drop->getCategoryHeader();
$category_list3 = $service_drop->getCategoryList();

//add the javascript pop up link
if($service_list3 != null) {
$service_list3 = "$service_list3 <a href=\"javascript: void\" id=\"pos4\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -20, -70, 'pos4', 3 );\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
}

$service_drop->setEmpTypeCat(4);
$service_drop->setClubId($marker4);
$service_drop->createParseList();
$service_header4 = $service_drop->getServiceHeader();
$service_list4 = $service_drop->getDropList();
//get the drop down group types
$category_header4 = $service_drop->getCategoryHeader();
$category_list4 = $service_drop->getCategoryList();

//add the javascript pop up link
if($service_list4 != null) {
$service_list4 = "$service_list4 <a href=\"javascript: void\" id=\"pos6\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -20, -70, 'pos6', 3 );\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
}


//now we create check  boxes to delete the employee type if the option is selected
//first we create for employee type one
if($employee_type1 != null)  {
    $emp_delete_desc1 = 'Reset Employee Type:';
    $emp_delete_check1 = "<input type=\"checkbox\" name=\"access1\" value=\"1\" ><a href=\"javascript: void\" id=\"pos7\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -3, 0, 'pos7', 4 );\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"/></a>";
     }else{
     $emp_delete_desc1 = null;
     $emp_delete_check1 = null;
     }
     
if($employee_type2 != null)  {
    $emp_delete_desc2 = 'Reset Employee Type:';
    $emp_delete_check2 = "<input type=\"checkbox\" name=\"access2\" value=\"1\"><a href=\"javascript: void\" id=\"pos8\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -3, -100, 'pos8', 4 );\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"/></a>";
     }else{
     $emp_delete_desc2 = null;
     $emp_delete_check2 = null;
     }
     
if($employee_type3 != null)  {
    $emp_delete_desc3 = 'Reset Employee Type:';
    $emp_delete_check3 = "<input type=\"checkbox\" name=\"access3\" value=\"1\"><a href=\"javascript: void\" id=\"pos9\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -3, 0, 'pos9', 4 );\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"/></a>";
     }else{
     $emp_delete_desc3 = null;
     $emp_delete_check3 = null;
     }     

  if($employee_type4 != null)  {
    $emp_delete_desc4 = 'Reset Employee Type:';
    $emp_delete_check4 = "<input type=\"checkbox\" name=\"access4\" value=\"1\" ><a href=\"javascript: void\" id=\"pos10\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -3, -100, 'pos10', 4 );\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"/></a>";
     }else{
     $emp_delete_desc4 = null;
     $emp_delete_check4 = null;
     }   
//===============================================================

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(7);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

switch($monday_start_1) {
    case '0':
        $monday_start_1_txt = "No Shift";
    break;
    case '1':
        $monday_start_1_txt = "1 AM";
    break;
    case '2':
        $monday_start_1_txt = "2 AM";
    break;
    case '3':
        $monday_start_1_txt = "3 AM";
    break;
    case '4':
        $monday_start_1_txt = "4 AM";
    break;
    case '5':
        $monday_start_1_txt = "5 AM";
    break;
    case '6':
        $monday_start_1_txt = "6 AM";
    break;
    case '7':
        $monday_start_1_txt = "7 AM";
    break;
    case '8':
        $monday_start_1_txt = "8 AM";
    break;
    case '9':
        $monday_start_1_txt = "9 AM";
    break;
    case '10':
        $monday_start_1_txt = "10 AM";
    break;
    case '11':
        $monday_start_1_txt = "11 AM";
    break;
    case '12':
        $monday_start_1_txt = "12 PM";
    break;
    case '13':
        $monday_start_1_txt = "1 PM";
    break;
    case '14':
        $monday_start_1_txt = "2 PM";
    break;
    case '15':
        $monday_start_1_txt = "3 PM";
    break;
    case '16':
        $monday_start_1_txt = "4 PM";
    break;
    case '17':
        $monday_start_1_txt = "5 PM";
    break;
    case '18':
        $monday_start_1_txt = "6 PM";
    break;
    case '19':
        $monday_start_1_txt = "7 PM";
    break;
    case '20':
        $monday_start_1_txt = "8 PM";
    break;
    case '21':
        $monday_start_1_txt = "9 PM";
    break;
    case '22':
        $monday_start_1_txt = "10 PM";
    break;
    case '23':
        $monday_start_1_txt = "11 PM";
    break;
    case '24':
        $monday_start_1_txt = "12 AM";
    break;
    
}

switch($monday_end_1) {
    case '0':
        $monday_end_1_txt = "No Shift";
    break;
    case '1':
        $monday_end_1_txt = "1 AM";
    break;
    case '2':
        $monday_end_1_txt = "2 AM";
    break;
    case '3':
        $monday_end_1_txt = "3 AM";
    break;
    case '4':
        $monday_end_1_txt = "4 AM";
    break;
    case '5':
        $monday_end_1_txt = "5 AM";
    break;
    case '6':
        $monday_end_1_txt = "6 AM";
    break;
    case '7':
        $monday_end_1_txt = "7 AM";
    break;
    case '8':
        $monday_end_1_txt = "8 AM";
    break;
    case '9':
        $monday_end_1_txt = "9 AM";
    break;
    case '10':
        $monday_end_1_txt = "10 AM";
    break;
    case '11':
        $monday_end_1_txt = "11 AM";
    break;
    case '12':
        $monday_end_1_txt = "12 PM";
    break;
    case '13':
        $monday_end_1_txt = "1 PM";
    break;
    case '14':
        $monday_end_1_txt = "2 PM";
    break;
    case '15':
        $monday_end_1_txt = "3 PM";
    break;
    case '16':
        $monday_end_1_txt = "4 PM";
    break;
    case '17':
        $monday_end_1_txt = "5 PM";
    break;
    case '18':
        $monday_end_1_txt = "6 PM";
    break;
    case '19':
        $monday_end_1_txt = "7 PM";
    break;
    case '20':
        $monday_end_1_txt = "8 PM";
    break;
    case '21':
        $monday_end_1_txt = "9 PM";
    break;
    case '22':
        $monday_end_1_txt = "10 PM";
    break;
    case '23':
        $monday_end_1_txt = "11 PM";
    break;
    case '24':
        $monday_end_1_txt = "12 AM";
    break;
    
}
switch($monday_start_2) {
    case '0':
        $monday_start_2_txt = "No Shift";
    break;
    case '1':
        $monday_start_2_txt = "1 AM";
    break;
    case '2':
        $monday_start_2_txt = "2 AM";
    break;
    case '3':
        $monday_start_2_txt = "3 AM";
    break;
    case '4':
        $monday_start_2_txt = "4 AM";
    break;
    case '5':
        $monday_start_2_txt = "5 AM";
    break;
    case '6':
        $monday_start_2_txt = "6 AM";
    break;
    case '7':
        $monday_start_2_txt = "7 AM";
    break;
    case '8':
        $monday_start_2_txt = "8 AM";
    break;
    case '9':
        $monday_start_2_txt = "9 AM";
    break;
    case '10':
        $monday_start_2_txt = "10 AM";
    break;
    case '11':
        $monday_start_2_txt = "11 AM";
    break;
    case '12':
        $monday_start_2_txt = "12 PM";
    break;
    case '13':
        $monday_start_2_txt = "1 PM";
    break;
    case '14':
        $monday_start_2_txt = "2 PM";
    break;
    case '15':
        $monday_start_2_txt = "3 PM";
    break;
    case '16':
        $monday_start_2_txt = "4 PM";
    break;
    case '17':
        $monday_start_2_txt = "5 PM";
    break;
    case '18':
        $monday_start_2_txt = "6 PM";
    break;
    case '19':
        $monday_start_2_txt = "7 PM";
    break;
    case '20':
        $monday_start_2_txt = "8 PM";
    break;
    case '21':
        $monday_start_2_txt = "9 PM";
    break;
    case '22':
        $monday_start_2_txt = "10 PM";
    break;
    case '23':
        $monday_start_2_txt = "11 PM";
    break;
    case '24':
        $monday_start_2_txt = "12 AM";
    break;
    
}

switch($monday_end_2) {
    case '0':
        $monday_end_2_txt = "No Shift";
    break;
    case '1':
        $monday_end_2_txt = "1 AM";
    break;
    case '2':
        $monday_end_2_txt = "2 AM";
    break;
    case '3':
        $monday_end_2_txt = "3 AM";
    break;
    case '4':
        $monday_end_2_txt = "4 AM";
    break;
    case '5':
        $monday_end_2_txt = "5 AM";
    break;
    case '6':
        $monday_end_2_txt = "6 AM";
    break;
    case '7':
        $monday_end_2_txt = "7 AM";
    break;
    case '8':
        $monday_end_2_txt = "8 AM";
    break;
    case '9':
        $monday_end_2_txt = "9 AM";
    break;
    case '10':
        $monday_end_2_txt = "10 AM";
    break;
    case '11':
        $monday_end_2_txt = "11 AM";
    break;
    case '12':
        $monday_end_2_txt = "12 PM";
    break;
    case '13':
        $monday_end_2_txt = "1 PM";
    break;
    case '14':
        $monday_end_2_txt = "2 PM";
    break;
    case '15':
        $monday_end_2_txt = "3 PM";
    break;
    case '16':
        $monday_end_2_txt = "4 PM";
    break;
    case '17':
        $monday_end_2_txt = "5 PM";
    break;
    case '18':
        $monday_end_2_txt = "6 PM";
    break;
    case '19':
        $monday_end_2_txt = "7 PM";
    break;
    case '20':
        $monday_end_2_txt = "8 PM";
    break;
    case '21':
        $monday_end_2_txt = "9 PM";
    break;
    case '22':
        $monday_end_2_txt = "10 PM";
    break;
    case '23':
        $monday_end_2_txt = "11 PM";
    break;
    case '24':
        $monday_end_2_txt = "12 AM";
    break;
    
}
//echo $tuesday_start_1;
switch($tuesday_start_1) {
    case '0':
        $tuesday_start_1_txt = "No Shift";
    break;
    case '1':
        $tuesday_start_1_txt = "1 AM";
    break;
    case '2':
        $tuesday_start_1_txt = "2 AM";
    break;
    case '3':
        $tuesday_start_1_txt = "3 AM";
    break;
    case '4':
        $tuesday_start_1_txt = "4 AM";
    break;
    case '5':
        $tuesday_start_1_txt = "5 AM";
    break;
    case '6':
        $tuesday_start_1_txt = "6 AM";
    break;
    case '7':
        $tuesday_start_1_txt = "7 AM";
    break;
    case '8':
        $tuesday_start_1_txt = "8 AM";
    break;
    case '9':
        $tuesday_start_1_txt = "9 AM";
    break;
    case '10':
        $tuesday_start_1_txt = "10 AM";
    break;
    case '11':
        $tuesday_start_1_txt = "11 AM";
    break;
    case '12':
        $tuesday_start_1_txt = "12 PM";
    break;
    case '13':
        $tuesday_start_1_txt = "1 PM";
    break;
    case '14':
        $tuesday_start_1_txt = "2 PM";
    break;
    case '15':
        $tuesday_start_1_txt = "3 PM";
    break;
    case '16':
        $tuesday_start_1_txt = "4 PM";
    break;
    case '17':
        $tuesday_start_1_txt = "5 PM";
    break;
    case '18':
        $tuesday_start_1_txt = "6 PM";
    break;
    case '19':
        $tuesday_start_1_txt = "7 PM";
    break;
    case '20':
        $tuesday_start_1_txt = "8 PM";
    break;
    case '21':
        $tuesday_start_1_txt = "9 PM";
    break;
    case '22':
        $tuesday_start_1_txt = "10 PM";
    break;
    case '23':
        $tuesday_start_1_txt = "11 PM";
    break;
    case '24':
        $tuesday_start_1_txt = "12 AM";
    break;
    
}

switch($tuesday_end_1) {
    case '0':
        $tuesday_end_1_txt = "No Shift";
    break;
    case '1':
        $tuesday_end_1_txt = "1 AM";
    break;
    case '2':
        $tuesday_end_1_txt = "2 AM";
    break;
    case '3':
        $tuesday_end_1_txt = "3 AM";
    break;
    case '4':
        $tuesday_end_1_txt = "4 AM";
    break;
    case '5':
        $tuesday_end_1_txt = "5 AM";
    break;
    case '6':
        $tuesday_end_1_txt = "6 AM";
    break;
    case '7':
        $tuesday_end_1_txt = "7 AM";
    break;
    case '8':
        $tuesday_end_1_txt = "8 AM";
    break;
    case '9':
        $tuesday_end_1_txt = "9 AM";
    break;
    case '10':
        $tuesday_end_1_txt = "10 AM";
    break;
    case '11':
        $tuesday_end_1_txt = "11 AM";
    break;
    case '12':
        $tuesday_end_1_txt = "12 PM";
    break;
    case '13':
        $tuesday_end_1_txt = "1 PM";
    break;
    case '14':
        $tuesday_end_1_txt = "2 PM";
    break;
    case '15':
        $tuesday_end_1_txt = "3 PM";
    break;
    case '16':
        $tuesday_end_1_txt = "4 PM";
    break;
    case '17':
        $tuesday_end_1_txt = "5 PM";
    break;
    case '18':
        $tuesday_end_1_txt = "6 PM";
    break;
    case '19':
        $tuesday_end_1_txt = "7 PM";
    break;
    case '20':
        $tuesday_end_1_txt = "8 PM";
    break;
    case '21':
        $tuesday_end_1_txt = "9 PM";
    break;
    case '22':
        $tuesday_end_1_txt = "10 PM";
    break;
    case '23':
        $tuesday_end_1_txt = "11 PM";
    break;
    case '24':
        $tuesday_end_1_txt = "12 AM";
    break;
    
}
switch($tuesday_start_2) {
    case '0':
        $tuesday_start_2_txt = "No Shift";
    break;
    case '1':
        $tuesday_start_2_txt = "1 AM";
    break;
    case '2':
        $tuesday_start_2_txt = "2 AM";
    break;
    case '3':
        $tuesday_start_2_txt = "3 AM";
    break;
    case '4':
        $tuesday_start_2_txt = "4 AM";
    break;
    case '5':
        $tuesday_start_2_txt = "5 AM";
    break;
    case '6':
        $tuesday_start_2_txt = "6 AM";
    break;
    case '7':
        $tuesday_start_2_txt = "7 AM";
    break;
    case '8':
        $tuesday_start_2_txt = "8 AM";
    break;
    case '9':
        $tuesday_start_2_txt = "9 AM";
    break;
    case '10':
        $tuesday_start_2_txt = "10 AM";
    break;
    case '11':
        $tuesday_start_2_txt = "11 AM";
    break;
    case '12':
        $tuesday_start_2_txt = "12 PM";
    break;
    case '13':
        $tuesday_start_2_txt = "1 PM";
    break;
    case '14':
        $tuesday_start_2_txt = "2 PM";
    break;
    case '15':
        $tuesday_start_2_txt = "3 PM";
    break;
    case '16':
        $tuesday_start_2_txt = "4 PM";
    break;
    case '17':
        $tuesday_start_2_txt = "5 PM";
    break;
    case '18':
        $tuesday_start_2_txt = "6 PM";
    break;
    case '19':
        $tuesday_start_2_txt = "7 PM";
    break;
    case '20':
        $tuesday_start_2_txt = "8 PM";
    break;
    case '21':
        $tuesday_start_2_txt = "9 PM";
    break;
    case '22':
        $tuesday_start_2_txt = "10 PM";
    break;
    case '23':
        $tuesday_start_2_txt = "11 PM";
    break;
    case '24':
        $tuesday_start_2_txt = "12 AM";
    break;
    
}

switch($tuesday_end_2) {
    case '0':
        $tuesday_end_2_txt = "No Shift";
    break;
    case '1':
        $tuesday_end_2_txt = "1 AM";
    break;
    case '2':
        $tuesday_end_2_txt = "2 AM";
    break;
    case '3':
        $tuesday_end_2_txt = "3 AM";
    break;
    case '4':
        $tuesday_end_2_txt = "4 AM";
    break;
    case '5':
        $tuesday_end_2_txt = "5 AM";
    break;
    case '6':
        $tuesday_end_2_txt = "6 AM";
    break;
    case '7':
        $tuesday_end_2_txt = "7 AM";
    break;
    case '8':
        $tuesday_end_2_txt = "8 AM";
    break;
    case '9':
        $tuesday_end_2_txt = "9 AM";
    break;
    case '10':
        $tuesday_end_2_txt = "10 AM";
    break;
    case '11':
        $tuesday_end_2_txt = "11 AM";
    break;
    case '12':
        $tuesday_end_2_txt = "12 PM";
    break;
    case '13':
        $tuesday_end_2_txt = "1 PM";
    break;
    case '14':
        $tuesday_end_2_txt = "2 PM";
    break;
    case '15':
        $tuesday_end_2_txt = "3 PM";
    break;
    case '16':
        $tuesday_end_2_txt = "4 PM";
    break;
    case '17':
        $tuesday_end_2_txt = "5 PM";
    break;
    case '18':
        $tuesday_end_2_txt = "6 PM";
    break;
    case '19':
        $tuesnday_end_2_txt = "7 PM";
    break;
    case '20':
        $tuesday_end_2_txt = "8 PM";
    break;
    case '21':
        $tuesday_end_2_txt = "9 PM";
    break;
    case '22':
        $tuesday_end_2_txt = "10 PM";
    break;
    case '23':
        $tuesday_end_2_txt = "11 PM";
    break;
    case '24':
        $tuesday_end_2_txt = "12 AM";
    break;
    
}
switch($wednesday_start_1) {
    case '0':
        $wednesday_start_1_txt = "No Shift";
    break;
    case '1':
        $wednesday_start_1_txt = "1 AM";
    break;
    case '2':
        $wednesday_start_1_txt = "2 AM";
    break;
    case '3':
        $wednesday_start_1_txt = "3 AM";
    break;
    case '4':
        $wednesday_start_1_txt = "4 AM";
    break;
    case '5':
        $wednesday_start_1_txt = "5 AM";
    break;
    case '6':
        $wednesday_start_1_txt = "6 AM";
    break;
    case '7':
        $wednesday_start_1_txt = "7 AM";
    break;
    case '8':
        $wednesday_start_1_txt = "8 AM";
    break;
    case '9':
        $wednesday_start_1_txt = "9 AM";
    break;
    case '10':
        $wednesday_start_1_txt = "10 AM";
    break;
    case '11':
        $wednesday_start_1_txt = "11 AM";
    break;
    case '12':
        $wednesday_start_1_txt = "12 PM";
    break;
    case '13':
        $wednesday_start_1_txt = "1 PM";
    break;
    case '14':
        $wednesday_start_1_txt = "2 PM";
    break;
    case '15':
        $wednesday_start_1_txt = "3 PM";
    break;
    case '16':
        $wednesday_start_1_txt = "4 PM";
    break;
    case '17':
        $wednesday_start_1_txt = "5 PM";
    break;
    case '18':
        $wednesday_start_1_txt = "6 PM";
    break;
    case '19':
        $wednesday_start_1_txt = "7 PM";
    break;
    case '20':
        $wednesday_start_1_txt = "8 PM";
    break;
    case '21':
        $wednesday_start_1_txt = "9 PM";
    break;
    case '22':
        $wednesday_start_1_txt = "10 PM";
    break;
    case '23':
        $wednesday_start_1_txt = "11 PM";
    break;
    case '24':
        $wednesday_start_1_txt = "12 AM";
    break;
    
}

switch($wednesday_end_1) {
    case '0':
        $wednesday_end_1_txt = "No Shift";
    break;
    case '1':
        $wednesday_end_1_txt = "1 AM";
    break;
    case '2':
        $wednesday_end_1_txt = "2 AM";
    break;
    case '3':
        $wednesday_end_1_txt = "3 AM";
    break;
    case '4':
        $wednesday_end_1_txt = "4 AM";
    break;
    case '5':
        $wednesday_end_1_txt = "5 AM";
    break;
    case '6':
        $wednesday_end_1_txt = "6 AM";
    break;
    case '7':
        $wednesday_end_1_txt = "7 AM";
    break;
    case '8':
        $wednesday_end_1_txt = "8 AM";
    break;
    case '9':
        $wednesday_end_1_txt = "9 AM";
    break;
    case '10':
        $wednesday_end_1_txt = "10 AM";
    break;
    case '11':
        $wednesday_end_1_txt = "11 AM";
    break;
    case '12':
        $wednesday_end_1_txt = "12 PM";
    break;
    case '13':
        $wednesday_end_1_txt = "1 PM";
    break;
    case '14':
        $wednesday_end_1_txt = "2 PM";
    break;
    case '15':
        $wednesday_end_1_txt = "3 PM";
    break;
    case '16':
        $wednesday_end_1_txt = "4 PM";
    break;
    case '17':
        $wednesday_end_1_txt = "5 PM";
    break;
    case '18':
        $wednesday_end_1_txt = "6 PM";
    break;
    case '19':
        $wednesday_end_1_txt = "7 PM";
    break;
    case '20':
        $wednesday_end_1_txt = "8 PM";
    break;
    case '21':
        $wednesday_end_1_txt = "9 PM";
    break;
    case '22':
        $wednesday_end_1_txt = "10 PM";
    break;
    case '23':
        $wednesday_end_1_txt = "11 PM";
    break;
    case '24':
        $wednesday_end_1_txt = "12 AM";
    break;
    
}
switch($wednesday_start_2) {
    case '0':
        $wednesday_start_2_txt = "No Shift";
    break;
    case '1':
        $wednesday_start_2_txt = "1 AM";
    break;
    case '2':
        $wednesday_start_2_txt = "2 AM";
    break;
    case '3':
        $wednesday_start_2_txt = "3 AM";
    break;
    case '4':
        $wednesday_start_2_txt = "4 AM";
    break;
    case '5':
        $wednesday_start_2_txt = "5 AM";
    break;
    case '6':
        $wednesday_start_2_txt = "6 AM";
    break;
    case '7':
        $wednesday_start_2_txt = "7 AM";
    break;
    case '8':
        $wednesday_start_2_txt = "8 AM";
    break;
    case '9':
        $wednesday_start_2_txt = "9 AM";
    break;
    case '10':
        $wednesday_start_2_txt = "10 AM";
    break;
    case '11':
        $wednesday_start_2_txt = "11 AM";
    break;
    case '12':
        $wednesday_start_2_txt = "12 PM";
    break;
    case '13':
        $wednesday_start_2_txt = "1 PM";
    break;
    case '14':
        $wednesday_start_2_txt = "2 PM";
    break;
    case '15':
        $wednesday_start_2_txt = "3 PM";
    break;
    case '16':
        $wednesday_start_2_txt = "4 PM";
    break;
    case '17':
        $wednesday_start_2_txt = "5 PM";
    break;
    case '18':
        $wednesday_start_2_txt = "6 PM";
    break;
    case '19':
        $wednesday_start_2_txt = "7 PM";
    break;
    case '20':
        $wednesday_start_2_txt = "8 PM";
    break;
    case '21':
        $wednesday_start_2_txt = "9 PM";
    break;
    case '22':
        $wednesday_start_2_txt = "10 PM";
    break;
    case '23':
        $wednesday_start_2_txt = "11 PM";
    break;
    case '24':
        $wednesday_start_2_txt = "12 AM";
    break;
    
}

switch($wednesday_end_2) {
    case '0':
        $wednesday_end_2_txt = "No Shift";
    break;
    case '1':
        $wednesday_end_2_txt = "1 AM";
    break;
    case '2':
        $wednesday_end_2_txt = "2 AM";
    break;
    case '3':
        $wednesday_end_2_txt = "3 AM";
    break;
    case '4':
        $wednesday_end_2_txt = "4 AM";
    break;
    case '5':
        $wednesday_end_2_txt = "5 AM";
    break;
    case '6':
        $wednesday_end_2_txt = "6 AM";
    break;
    case '7':
        $wednesday_end_2_txt = "7 AM";
    break;
    case '8':
        $wednesday_end_2_txt = "8 AM";
    break;
    case '9':
        $wednesday_end_2_txt = "9 AM";
    break;
    case '10':
        $wednesday_end_2_txt = "10 AM";
    break;
    case '11':
        $wednesday_end_2_txt = "11 AM";
    break;
    case '12':
        $wednesday_end_2_txt = "12 PM";
    break;
    case '13':
        $wednesday_end_2_txt = "1 PM";
    break;
    case '14':
        $wednesday_end_2_txt = "2 PM";
    break;
    case '15':
        $wednesday_end_2_txt = "3 PM";
    break;
    case '16':
        $wednesday_end_2_txt = "4 PM";
    break;
    case '17':
        $wednesday_end_2_txt = "5 PM";
    break;
    case '18':
        $wednesday_end_2_txt = "6 PM";
    break;
    case '19':
        $wednesday_end_2_txt = "7 PM";
    break;
    case '20':
        $wednesday_end_2_txt = "8 PM";
    break;
    case '21':
        $wednesday_end_2_txt = "9 PM";
    break;
    case '22':
        $wednesday_end_2_txt = "10 PM";
    break;
    case '23':
        $wednesday_end_2_txt = "11 PM";
    break;
    case '24':
        $wednesday_end_2_txt = "12 AM";
    break;
    
}
switch($thursday_start_1) {
    case '0':
        $thursday_start_1_txt = "No Shift";
    break;
    case '1':
        $thursday_start_1_txt = "1 AM";
    break;
    case '2':
        $thursday_start_1_txt = "2 AM";
    break;
    case '3':
        $thursday_start_1_txt = "3 AM";
    break;
    case '4':
        $thursday_start_1_txt = "4 AM";
    break;
    case '5':
        $thursday_start_1_txt = "5 AM";
    break;
    case '6':
        $thursday_start_1_txt = "6 AM";
    break;
    case '7':
        $thursday_start_1_txt = "7 AM";
    break;
    case '8':
        $thursday_start_1_txt = "8 AM";
    break;
    case '9':
        $thursday_start_1_txt = "9 AM";
    break;
    case '10':
        $thursday_start_1_txt = "10 AM";
    break;
    case '11':
        $thursday_start_1_txt = "11 AM";
    break;
    case '12':
        $thursday_start_1_txt = "12 PM";
    break;
    case '13':
        $thursday_start_1_txt = "1 PM";
    break;
    case '14':
        $thursday_start_1_txt = "2 PM";
    break;
    case '15':
        $thursday_start_1_txt = "3 PM";
    break;
    case '16':
        $thursday_start_1_txt = "4 PM";
    break;
    case '17':
        $thursday_start_1_txt = "5 PM";
    break;
    case '18':
        $thursday_start_1_txt = "6 PM";
    break;
    case '19':
        $thursday_start_1_txt = "7 PM";
    break;
    case '20':
        $thursday_start_1_txt = "8 PM";
    break;
    case '21':
        $thursday_start_1_txt = "9 PM";
    break;
    case '22':
        $thursday_start_1_txt = "10 PM";
    break;
    case '23':
        $thursday_start_1_txt = "11 PM";
    break;
    case '24':
        $thursday_start_1_txt = "12 AM";
    break;
    
}

switch($thursday_end_1) {
    case '0':
        $thursday_end_1_txt = "No Shift";
    break;
    case '1':
        $thursday_end_1_txt = "1 AM";
    break;
    case '2':
        $thursday_end_1_txt = "2 AM";
    break;
    case '3':
        $thursday_end_1_txt = "3 AM";
    break;
    case '4':
        $thursday_end_1_txt = "4 AM";
    break;
    case '5':
        $thursday_end_1_txt = "5 AM";
    break;
    case '6':
        $thursday_end_1_txt = "6 AM";
    break;
    case '7':
        $thursday_end_1_txt = "7 AM";
    break;
    case '8':
        $thursday_end_1_txt = "8 AM";
    break;
    case '9':
        $thursday_end_1_txt = "9 AM";
    break;
    case '10':
        $thursday_end_1_txt = "10 AM";
    break;
    case '11':
        $thursday_end_1_txt = "11 AM";
    break;
    case '12':
        $thursday_end_1_txt = "12 PM";
    break;
    case '13':
        $thursday_end_1_txt = "1 PM";
    break;
    case '14':
        $thursday_end_1_txt = "2 PM";
    break;
    case '15':
        $thursday_end_1_txt = "3 PM";
    break;
    case '16':
        $thursday_end_1_txt = "4 PM";
    break;
    case '17':
        $thursday_end_1_txt = "5 PM";
    break;
    case '18':
        $thursday_end_1_txt = "6 PM";
    break;
    case '19':
        $thursday_end_1_txt = "7 PM";
    break;
    case '20':
        $thursday_end_1_txt = "8 PM";
    break;
    case '21':
        $thursday_end_1_txt = "9 PM";
    break;
    case '22':
        $thursday_end_1_txt = "10 PM";
    break;
    case '23':
        $thursday_end_1_txt = "11 PM";
    break;
    case '24':
        $thursday_end_1_txt = "12 AM";
    break;
    
}
switch($thursday_start_2) {
    case '0':
        $thursday_start_2_txt = "No Shift";
    break;
    case '1':
        $thursday_start_2_txt = "1 AM";
    break;
    case '2':
        $thursday_start_2_txt = "2 AM";
    break;
    case '3':
        $thursday_start_2_txt = "3 AM";
    break;
    case '4':
        $thursday_start_2_txt = "4 AM";
    break;
    case '5':
        $thursday_start_2_txt = "5 AM";
    break;
    case '6':
        $thursday_start_2_txt = "6 AM";
    break;
    case '7':
        $thursday_start_2_txt = "7 AM";
    break;
    case '8':
        $thursday_start_2_txt = "8 AM";
    break;
    case '9':
        $thursday_start_2_txt = "9 AM";
    break;
    case '10':
        $thursday_start_2_txt = "10 AM";
    break;
    case '11':
        $thursday_start_2_txt = "11 AM";
    break;
    case '12':
        $thursday_start_2_txt = "12 PM";
    break;
    case '13':
        $thursday_start_2_txt = "1 PM";
    break;
    case '14':
        $thursday_start_2_txt = "2 PM";
    break;
    case '15':
        $thursday_start_2_txt = "3 PM";
    break;
    case '16':
        $thursday_start_2_txt = "4 PM";
    break;
    case '17':
        $thursday_start_2_txt = "5 PM";
    break;
    case '18':
        $thursday_start_2_txt = "6 PM";
    break;
    case '19':
        $thursday_start_2_txt = "7 PM";
    break;
    case '20':
        $thursday_start_2_txt = "8 PM";
    break;
    case '21':
        $thursday_start_2_txt = "9 PM";
    break;
    case '22':
        $thursday_start_2_txt = "10 PM";
    break;
    case '23':
        $thursday_start_2_txt = "11 PM";
    break;
    case '24':
        $thursday_start_2_txt = "12 AM";
    break;
    
}

switch($thursday_end_2) {
    case '0':
        $thursday_end_2_txt = "No Shift";
    break;
    case '1':
        $thursday_end_2_txt = "1 AM";
    break;
    case '2':
        $thursday_end_2_txt = "2 AM";
    break;
    case '3':
        $thursday_end_2_txt = "3 AM";
    break;
    case '4':
        $thursday_end_2_txt = "4 AM";
    break;
    case '5':
        $thursday_end_2_txt = "5 AM";
    break;
    case '6':
        $thursday_end_2_txt = "6 AM";
    break;
    case '7':
        $thursday_end_2_txt = "7 AM";
    break;
    case '8':
        $thursday_end_2_txt = "8 AM";
    break;
    case '9':
        $thursday_end_2_txt = "9 AM";
    break;
    case '10':
        $thursday_end_2_txt = "10 AM";
    break;
    case '11':
        $thursday_end_2_txt = "11 AM";
    break;
    case '12':
        $thursday_end_2_txt = "12 PM";
    break;
    case '13':
        $thursday_end_2_txt = "1 PM";
    break;
    case '14':
        $thursday_end_2_txt = "2 PM";
    break;
    case '15':
        $thursday_end_2_txt = "3 PM";
    break;
    case '16':
        $thursday_end_2_txt = "4 PM";
    break;
    case '17':
        $thursday_end_2_txt = "5 PM";
    break;
    case '18':
        $thursday_end_2_txt = "6 PM";
    break;
    case '19':
        $thursday_end_2_txt = "7 PM";
    break;
    case '20':
        $thursday_end_2_txt = "8 PM";
    break;
    case '21':
        $thursday_end_2_txt = "9 PM";
    break;
    case '22':
        $thursday_end_2_txt = "10 PM";
    break;
    case '23':
        $thursday_end_2_txt = "11 PM";
    break;
    case '24':
        $thursday_end_2_txt = "12 AM";
    break;
    
}
switch($friday_start_1) {
    case '0':
        $friday_start_1_txt = "No Shift";
    break;
    case '1':
        $friday_start_1_txt = "1 AM";
    break;
    case '2':
        $friday_start_1_txt = "2 AM";
    break;
    case '3':
        $friday_start_1_txt = "3 AM";
    break;
    case '4':
        $friday_start_1_txt = "4 AM";
    break;
    case '5':
        $friday_start_1_txt = "5 AM";
    break;
    case '6':
        $friday_start_1_txt = "6 AM";
    break;
    case '7':
        $friday_start_1_txt = "7 AM";
    break;
    case '8':
        $friday_start_1_txt = "8 AM";
    break;
    case '9':
        $friday_start_1_txt = "9 AM";
    break;
    case '10':
        $friday_start_1_txt = "10 AM";
    break;
    case '11':
        $friday_start_1_txt = "11 AM";
    break;
    case '12':
        $friday_start_1_txt = "12 PM";
    break;
    case '13':
        $friday_start_1_txt = "1 PM";
    break;
    case '14':
        $friday_start_1_txt = "2 PM";
    break;
    case '15':
        $friday_start_1_txt = "3 PM";
    break;
    case '16':
        $friday_start_1_txt = "4 PM";
    break;
    case '17':
        $friday_start_1_txt = "5 PM";
    break;
    case '18':
        $friday_start_1_txt = "6 PM";
    break;
    case '19':
        $friday_start_1_txt = "7 PM";
    break;
    case '20':
        $friday_start_1_txt = "8 PM";
    break;
    case '21':
        $friday_start_1_txt = "9 PM";
    break;
    case '22':
        $friday_start_1_txt = "10 PM";
    break;
    case '23':
        $friday_start_1_txt = "11 PM";
    break;
    case '24':
        $friday_start_1_txt = "12 AM";
    break;
    
}

switch($friday_end_1) {
    case '0':
        $friday_end_1_txt = "No Shift";
    break;
    case '1':
        $friday_end_1_txt = "1 AM";
    break;
    case '2':
        $friday_end_1_txt = "2 AM";
    break;
    case '3':
        $friday_end_1_txt = "3 AM";
    break;
    case '4':
        $friday_end_1_txt = "4 AM";
    break;
    case '5':
        $friday_end_1_txt = "5 AM";
    break;
    case '6':
        $friday_end_1_txt = "6 AM";
    break;
    case '7':
        $friday_end_1_txt = "7 AM";
    break;
    case '8':
        $friday_end_1_txt = "8 AM";
    break;
    case '9':
        $friday_end_1_txt = "9 AM";
    break;
    case '10':
        $friday_end_1_txt = "10 AM";
    break;
    case '11':
        $friday_end_1_txt = "11 AM";
    break;
    case '12':
        $friday_end_1_txt = "12 PM";
    break;
    case '13':
        $friday_end_1_txt = "1 PM";
    break;
    case '14':
        $friday_end_1_txt = "2 PM";
    break;
    case '15':
        $friday_end_1_txt = "3 PM";
    break;
    case '16':
        $friday_end_1_txt = "4 PM";
    break;
    case '17':
        $friday_end_1_txt = "5 PM";
    break;
    case '18':
        $friday_end_1_txt = "6 PM";
    break;
    case '19':
        $friday_end_1_txt = "7 PM";
    break;
    case '20':
        $friday_end_1_txt = "8 PM";
    break;
    case '21':
        $friday_end_1_txt = "9 PM";
    break;
    case '22':
        $friday_end_1_txt = "10 PM";
    break;
    case '23':
        $friday_end_1_txt = "11 PM";
    break;
    case '24':
        $friday_end_1_txt = "12 AM";
    break;
    
}
switch($friday_start_2) {
    case '0':
        $friday_start_2_txt = "No Shift";
    break;
    case '1':
        $friday_start_2_txt = "1 AM";
    break;
    case '2':
        $friday_start_2_txt = "2 AM";
    break;
    case '3':
        $friday_start_2_txt = "3 AM";
    break;
    case '4':
        $friday_start_2_txt = "4 AM";
    break;
    case '5':
        $friday_start_2_txt = "5 AM";
    break;
    case '6':
        $friday_start_2_txt = "6 AM";
    break;
    case '7':
        $friday_start_2_txt = "7 AM";
    break;
    case '8':
        $friday_start_2_txt = "8 AM";
    break;
    case '9':
        $friday_start_2_txt = "9 AM";
    break;
    case '10':
        $friday_start_2_txt = "10 AM";
    break;
    case '11':
        $friday_start_2_txt = "11 AM";
    break;
    case '12':
        $friday_start_2_txt = "12 PM";
    break;
    case '13':
        $friday_start_2_txt = "1 PM";
    break;
    case '14':
        $friday_start_2_txt = "2 PM";
    break;
    case '15':
        $friday_start_2_txt = "3 PM";
    break;
    case '16':
        $friday_start_2_txt = "4 PM";
    break;
    case '17':
        $friday_start_2_txt = "5 PM";
    break;
    case '18':
        $friday_start_2_txt = "6 PM";
    break;
    case '19':
        $friday_start_2_txt = "7 PM";
    break;
    case '20':
        $friday_start_2_txt = "8 PM";
    break;
    case '21':
        $friday_start_2_txt = "9 PM";
    break;
    case '22':
        $friday_start_2_txt = "10 PM";
    break;
    case '23':
        $friday_start_2_txt = "11 PM";
    break;
    case '24':
        $friday_start_2_txt = "12 AM";
    break;
    
}

switch($friday_end_2) {
    case '0':
        $friday_end_2_txt = "No Shift";
    break;
    case '1':
        $friday_end_2_txt = "1 AM";
    break;
    case '2':
        $friday_end_2_txt = "2 AM";
    break;
    case '3':
        $friday_end_2_txt = "3 AM";
    break;
    case '4':
        $friday_end_2_txt = "4 AM";
    break;
    case '5':
        $friday_end_2_txt = "5 AM";
    break;
    case '6':
        $friday_end_2_txt = "6 AM";
    break;
    case '7':
        $friday_end_2_txt = "7 AM";
    break;
    case '8':
        $friday_end_2_txt = "8 AM";
    break;
    case '9':
        $friday_end_2_txt = "9 AM";
    break;
    case '10':
        $friday_end_2_txt = "10 AM";
    break;
    case '11':
        $friday_end_2_txt = "11 AM";
    break;
    case '12':
        $friday_end_2_txt = "12 PM";
    break;
    case '13':
        $friday_end_2_txt = "1 PM";
    break;
    case '14':
        $friday_end_2_txt = "2 PM";
    break;
    case '15':
        $friday_end_2_txt = "3 PM";
    break;
    case '16':
        $friday_end_2_txt = "4 PM";
    break;
    case '17':
        $friday_end_2_txt = "5 PM";
    break;
    case '18':
        $friday_end_2_txt = "6 PM";
    break;
    case '19':
        $friday_end_2_txt = "7 PM";
    break;
    case '20':
        $friday_end_2_txt = "8 PM";
    break;
    case '21':
        $friday_end_2_txt = "9 PM";
    break;
    case '22':
        $friday_end_2_txt = "10 PM";
    break;
    case '23':
        $friday_end_2_txt = "11 PM";
    break;
    case '24':
        $friday_end_2_txt = "12 AM";
    break;
    
}
switch($saturday_start_1) {
    case '0':
        $saturday_start_1_txt = "No Shift";
    break;
    case '1':
        $saturday_start_1_txt = "1 AM";
    break;
    case '2':
        $saturday_start_1_txt = "2 AM";
    break;
    case '3':
        $saturday_start_1_txt = "3 AM";
    break;
    case '4':
        $saturday_start_1_txt = "4 AM";
    break;
    case '5':
        $saturday_start_1_txt = "5 AM";
    break;
    case '6':
        $saturday_start_1_txt = "6 AM";
    break;
    case '7':
        $saturday_start_1_txt = "7 AM";
    break;
    case '8':
        $saturday_start_1_txt = "8 AM";
    break;
    case '9':
        $saturday_start_1_txt = "9 AM";
    break;
    case '10':
        $saturday_start_1_txt = "10 AM";
    break;
    case '11':
        $saturday_start_1_txt = "11 AM";
    break;
    case '12':
        $saturday_start_1_txt = "12 PM";
    break;
    case '13':
        $saturday_start_1_txt = "1 PM";
    break;
    case '14':
        $saturday_start_1_txt = "2 PM";
    break;
    case '15':
        $saturday_start_1_txt = "3 PM";
    break;
    case '16':
        $saturday_start_1_txt = "4 PM";
    break;
    case '17':
        $saturday_start_1_txt = "5 PM";
    break;
    case '18':
        $saturday_start_1_txt = "6 PM";
    break;
    case '19':
        $saturday_start_1_txt = "7 PM";
    break;
    case '20':
        $saturday_start_1_txt = "8 PM";
    break;
    case '21':
        $saturday_start_1_txt = "9 PM";
    break;
    case '22':
        $saturday_start_1_txt = "10 PM";
    break;
    case '23':
        $saturday_start_1_txt = "11 PM";
    break;
    case '24':
        $saturday_start_1_txt = "12 AM";
    break;
    
}

switch($saturday_end_1) {
    case '0':
        $saturday_end_1_txt = "No Shift";
    break;
    case '1':
        $saturday_end_1_txt = "1 AM";
    break;
    case '2':
        $saturday_end_1_txt = "2 AM";
    break;
    case '3':
        $saturday_end_1_txt = "3 AM";
    break;
    case '4':
        $saturday_end_1_txt = "4 AM";
    break;
    case '5':
        $saturday_end_1_txt = "5 AM";
    break;
    case '6':
        $saturday_end_1_txt = "6 AM";
    break;
    case '7':
        $saturday_end_1_txt = "7 AM";
    break;
    case '8':
        $saturday_end_1_txt = "8 AM";
    break;
    case '9':
        $saturday_end_1_txt = "9 AM";
    break;
    case '10':
        $saturday_end_1_txt = "10 AM";
    break;
    case '11':
        $saturday_end_1_txt = "11 AM";
    break;
    case '12':
        $saturday_end_1_txt = "12 PM";
    break;
    case '13':
        $saturday_end_1_txt = "1 PM";
    break;
    case '14':
        $saturday_end_1_txt = "2 PM";
    break;
    case '15':
        $saturday_end_1_txt = "3 PM";
    break;
    case '16':
        $saturday_end_1_txt = "4 PM";
    break;
    case '17':
        $saturday_end_1_txt = "5 PM";
    break;
    case '18':
        $saturday_end_1_txt = "6 PM";
    break;
    case '19':
        $saturday_end_1_txt = "7 PM";
    break;
    case '20':
        $saturday_end_1_txt = "8 PM";
    break;
    case '21':
        $saturday_end_1_txt = "9 PM";
    break;
    case '22':
        $saturday_end_1_txt = "10 PM";
    break;
    case '23':
        $saturday_end_1_txt = "11 PM";
    break;
    case '24':
        $saturday_end_1_txt = "12 AM";
    break;
    
}
switch($saturday_start_2) {
    case '0':
        $saturday_start_2_txt = "No Shift";
    break;
    case '1':
        $saturday_start_2_txt = "1 AM";
    break;
    case '2':
        $saturday_start_2_txt = "2 AM";
    break;
    case '3':
        $saturday_start_2_txt = "3 AM";
    break;
    case '4':
        $saturday_start_2_txt = "4 AM";
    break;
    case '5':
        $saturday_start_2_txt = "5 AM";
    break;
    case '6':
        $saturday_start_2_txt = "6 AM";
    break;
    case '7':
        $saturday_start_2_txt = "7 AM";
    break;
    case '8':
        $saturday_start_2_txt = "8 AM";
    break;
    case '9':
        $saturday_start_2_txt = "9 AM";
    break;
    case '10':
        $saturday_start_2_txt = "10 AM";
    break;
    case '11':
        $saturday_start_2_txt = "11 AM";
    break;
    case '12':
        $saturday_start_2_txt = "12 PM";
    break;
    case '13':
        $saturday_start_2_txt = "1 PM";
    break;
    case '14':
        $saturday_start_2_txt = "2 PM";
    break;
    case '15':
        $saturday_start_2_txt = "3 PM";
    break;
    case '16':
        $saturday_start_2_txt = "4 PM";
    break;
    case '17':
        $saturday_start_2_txt = "5 PM";
    break;
    case '18':
        $saturday_start_2_txt = "6 PM";
    break;
    case '19':
        $saturday_start_2_txt = "7 PM";
    break;
    case '20':
        $saturday_start_2_txt = "8 PM";
    break;
    case '21':
        $saturday_start_2_txt = "9 PM";
    break;
    case '22':
        $saturday_start_2_txt = "10 PM";
    break;
    case '23':
        $saturday_start_2_txt = "11 PM";
    break;
    case '24':
        $saturday_start_2_txt = "12 AM";
    break;
    
}

switch($saturday_end_2) {
    case '0':
        $saturday_end_2_txt = "No Shift";
    break;
    case '1':
        $saturday_end_2_txt = "1 AM";
    break;
    case '2':
        $saturday_end_2_txt = "2 AM";
    break;
    case '3':
        $saturday_end_2_txt = "3 AM";
    break;
    case '4':
        $saturday_end_2_txt = "4 AM";
    break;
    case '5':
        $saturday_end_2_txt = "5 AM";
    break;
    case '6':
        $saturday_end_2_txt = "6 AM";
    break;
    case '7':
        $saturday_end_2_txt = "7 AM";
    break;
    case '8':
        $saturday_end_2_txt = "8 AM";
    break;
    case '9':
        $saturday_end_2_txt = "9 AM";
    break;
    case '10':
        $saturday_end_2_txt = "10 AM";
    break;
    case '11':
        $saturday_end_2_txt = "11 AM";
    break;
    case '12':
        $saturday_end_2_txt = "12 PM";
    break;
    case '13':
        $saturday_end_2_txt = "1 PM";
    break;
    case '14':
        $saturday_end_2_txt = "2 PM";
    break;
    case '15':
        $saturday_end_2_txt = "3 PM";
    break;
    case '16':
        $saturday_end_2_txt = "4 PM";
    break;
    case '17':
        $saturday_end_2_txt = "5 PM";
    break;
    case '18':
        $saturday_end_2_txt = "6 PM";
    break;
    case '19':
        $saturday_end_2_txt = "7 PM";
    break;
    case '20':
        $saturday_end_2_txt = "8 PM";
    break;
    case '21':
        $saturday_end_2_txt = "9 PM";
    break;
    case '22':
        $saturday_end_2_txt = "10 PM";
    break;
    case '23':
        $saturday_end_2_txt = "11 PM";
    break;
    case '24':
        $saturday_end_2_txt = "12 AM";
    break;
    
}
switch($sunday_start_1) {
    case '0':
        $sunday_start_1_txt = "No Shift";
    break;
    case '1':
        $sunday_start_1_txt = "1 AM";
    break;
    case '2':
        $sunday_start_1_txt = "2 AM";
    break;
    case '3':
        $sunday_start_1_txt = "3 AM";
    break;
    case '4':
        $sunday_start_1_txt = "4 AM";
    break;
    case '5':
        $sunday_start_1_txt = "5 AM";
    break;
    case '6':
        $sunday_start_1_txt = "6 AM";
    break;
    case '7':
        $sunday_start_1_txt = "7 AM";
    break;
    case '8':
        $sunday_start_1_txt = "8 AM";
    break;
    case '9':
        $sunday_start_1_txt = "9 AM";
    break;
    case '10':
        $sunday_start_1_txt = "10 AM";
    break;
    case '11':
        $sunday_start_1_txt = "11 AM";
    break;
    case '12':
        $sunday_start_1_txt = "12 PM";
    break;
    case '13':
        $sunday_start_1_txt = "1 PM";
    break;
    case '14':
        $sunday_start_1_txt = "2 PM";
    break;
    case '15':
        $sunday_start_1_txt = "3 PM";
    break;
    case '16':
        $sunday_start_1_txt = "4 PM";
    break;
    case '17':
        $sunday_start_1_txt = "5 PM";
    break;
    case '18':
        $sunday_start_1_txt = "6 PM";
    break;
    case '19':
        $sunday_start_1_txt = "7 PM";
    break;
    case '20':
        $sunday_start_1_txt = "8 PM";
    break;
    case '21':
        $sunday_start_1_txt = "9 PM";
    break;
    case '22':
        $sunday_start_1_txt = "10 PM";
    break;
    case '23':
        $sunday_start_1_txt = "11 PM";
    break;
    case '24':
        $sunday_start_1_txt = "12 AM";
    break;
    
}

switch($sunday_end_1) {
    case '0':
        $sunday_end_1_txt = "No Shift";
    break;
    case '1':
        $sunday_end_1_txt = "1 AM";
    break;
    case '2':
        $sunday_end_1_txt = "2 AM";
    break;
    case '3':
        $sunday_end_1_txt = "3 AM";
    break;
    case '4':
        $sunday_end_1_txt = "4 AM";
    break;
    case '5':
        $sunday_end_1_txt = "5 AM";
    break;
    case '6':
        $sunday_end_1_txt = "6 AM";
    break;
    case '7':
        $sunday_end_1_txt = "7 AM";
    break;
    case '8':
        $sunday_end_1_txt = "8 AM";
    break;
    case '9':
        $sunday_end_1_txt = "9 AM";
    break;
    case '10':
        $sunday_end_1_txt = "10 AM";
    break;
    case '11':
        $sunday_end_1_txt = "11 AM";
    break;
    case '12':
        $sunday_end_1_txt = "12 PM";
    break;
    case '13':
        $sunday_end_1_txt = "1 PM";
    break;
    case '14':
        $sunday_end_1_txt = "2 PM";
    break;
    case '15':
        $sunday_end_1_txt = "3 PM";
    break;
    case '16':
        $sunday_end_1_txt = "4 PM";
    break;
    case '17':
        $sunday_end_1_txt = "5 PM";
    break;
    case '18':
        $sunday_end_1_txt = "6 PM";
    break;
    case '19':
        $sunday_end_1_txt = "7 PM";
    break;
    case '20':
        $sunday_end_1_txt = "8 PM";
    break;
    case '21':
        $sunday_end_1_txt = "9 PM";
    break;
    case '22':
        $sunday_end_1_txt = "10 PM";
    break;
    case '23':
        $sunday_end_1_txt = "11 PM";
    break;
    case '24':
        $sunday_end_1_txt = "12 AM";
    break;
    
}
switch($sunday_start_2) {
    case '0':
        $sunday_start_2_txt = "No Shift";
    break;
    case '1':
        $sunday_start_2_txt = "1 AM";
    break;
    case '2':
        $sunday_start_2_txt = "2 AM";
    break;
    case '3':
        $sunday_start_2_txt = "3 AM";
    break;
    case '4':
        $sunday_start_2_txt = "4 AM";
    break;
    case '5':
        $sunday_start_2_txt = "5 AM";
    break;
    case '6':
        $sunday_start_2_txt = "6 AM";
    break;
    case '7':
        $sunday_start_2_txt = "7 AM";
    break;
    case '8':
        $sunday_start_2_txt = "8 AM";
    break;
    case '9':
        $sunday_start_2_txt = "9 AM";
    break;
    case '10':
        $sunday_start_2_txt = "10 AM";
    break;
    case '11':
        $sunday_start_2_txt = "11 AM";
    break;
    case '12':
        $sunday_start_2_txt = "12 PM";
    break;
    case '13':
        $sunday_start_2_txt = "1 PM";
    break;
    case '14':
        $sunday_start_2_txt = "2 PM";
    break;
    case '15':
        $sunday_start_2_txt = "3 PM";
    break;
    case '16':
        $sunday_start_2_txt = "4 PM";
    break;
    case '17':
        $sunday_start_2_txt = "5 PM";
    break;
    case '18':
        $sunday_start_2_txt = "6 PM";
    break;
    case '19':
        $sunday_start_2_txt = "7 PM";
    break;
    case '20':
        $sunday_start_2_txt = "8 PM";
    break;
    case '21':
        $sunday_start_2_txt = "9 PM";
    break;
    case '22':
        $sunday_start_2_txt = "10 PM";
    break;
    case '23':
        $sunday_start_2_txt = "11 PM";
    break;
    case '24':
        $sunday_start_2_txt = "12 AM";
    break;
    
}

switch($sunday_end_2) {
    case '0':
        $sunday_end_2_txt = "No Shift";
    break;
    case '1':
        $sunday_end_2_txt = "1 AM";
    break;
    case '2':
        $sunday_end_2_txt = "2 AM";
    break;
    case '3':
        $sunday_end_2_txt = "3 AM";
    break;
    case '4':
        $sunday_end_2_txt = "4 AM";
    break;
    case '5':
        $sunday_end_2_txt = "5 AM";
    break;
    case '6':
        $sunday_end_2_txt = "6 AM";
    break;
    case '7':
        $sunday_end_2_txt = "7 AM";
    break;
    case '8':
        $sunday_end_2_txt = "8 AM";
    break;
    case '9':
        $sunday_end_2_txt = "9 AM";
    break;
    case '10':
        $sunday_end_2_txt = "10 AM";
    break;
    case '11':
        $sunday_end_2_txt = "11 AM";
    break;
    case '12':
        $sunday_end_2_txt = "12 PM";
    break;
    case '13':
        $sunday_end_2_txt = "1 PM";
    break;
    case '14':
        $sunday_end_2_txt = "2 PM";
    break;
    case '15':
        $sunday_end_2_txt = "3 PM";
    break;
    case '16':
        $sunday_end_2_txt = "4 PM";
    break;
    case '17':
        $sunday_end_2_txt = "5 PM";
    break;
    case '18':
        $sunday_end_2_txt = "6 PM";
    break;
    case '19':
        $sunday_end_2_txt = "7 PM";
    break;
    case '20':
        $sunday_end_2_txt = "8 PM";
    break;
    case '21':
        $sunday_end_2_txt = "9 PM";
    break;
    case '22':
        $sunday_end_2_txt = "10 PM";
    break;
    case '23':
        $sunday_end_2_txt = "11 PM";
    break;
    case '24':
        $sunday_end_2_txt = "12 AM";
    break;
    
}


include "../templates/employeeTemplate2.php";


?>
