<?php
include "employeeSql.php";
include "../getDrops.php";
include "employeeTypeDrops.php";

session_start(); 

if (!isset($_SESSION['admin_access']))  {
exit;
}

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

$mHours = ($mondayStart1 - $mondayEnd1) + ($mondayStart2 - $mondayEnd2);
$tuHours = ($tuesdayStart1 - $tuesdayEnd1) +  ($tuesdayStart2 - $tuesdayEnd2);
$weHours = ($wednesdayStart1 - $wednesdayEnd1) +  ($wednesdayStart2 - $wednesdayEnd2);
$thHours = ($thursdayStart1 - $thursdayEnd1) +  ($thursdayStart2 - $thursdayEnd2);
$frHours = ($fridayStart1 - $fridayEnd1) +  ($fridayStart2 - $fridayEnd2 );
$saHours = ($saturdayStart1 - $saturdayEnd1) +  ($saturdayStart2 - $saturdayEnd2);
$suHours = ($sundayStart1 - $sundayEnd1) +  ($sundayStart2 - $sundayEnd2);
$totHours = $mHours + $tuHours +  $weHours + $thHours + $frHours + $saHours + $suHours;


//this filters out an non numeric charachters
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
//echo "$first_name";
//exit;

$_SESSION['employee']= new employeeSql();
$employee_info = $_SESSION['employee']; 	
//$employee_info = new employeeSql();
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
$employee_info ->setEmail($email);

$employee_info ->setTypeKey1($employee_type1);
$employee_info ->setCompensationType1($compensation_type1);
$employee_info ->setCompensationAmount1($payment_amount1);
$employee_info ->setPaymentCycle1($payment_cycle1);
$employee_info ->setIdCard1($id_card1);
$employee_info ->setHoursProjected1($hours_projected1);

$employee_info ->setTypeKey2($employee_type2);
$employee_info ->setCompensationType2($compensation_type2);
$employee_info ->setCompensationAmount2($payment_amount2);
$employee_info ->setPaymentCycle2($payment_cycle2);
$employee_info ->setIdCard2($id_card2);
$employee_info ->setHoursProjected2($hours_projected2);

$employee_info ->setTypeKey3($employee_type3);
$employee_info ->setCompensationType3($compensation_type3);
$employee_info ->setCompensationAmount3($payment_amount3);
$employee_info ->setPaymentCycle3($payment_cycle3);
$employee_info ->setIdCard3($id_card3);
$employee_info ->setHoursProjected3($hours_projected3);

$employee_info ->setTypeKey4($employee_type4);
$employee_info ->setCompensationType4($compensation_type4);
$employee_info ->setCompensationAmount4($payment_amount4);
$employee_info ->setPaymentCycle4($payment_cycle4);
$employee_info ->setIdCard4($id_card4);
$employee_info ->setHoursProjected4($hours_projected4);

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
$_SESSION['employee'] = $employee_info;




//if is is an imediate save 
if (isset($_POST['save']))       {


$save_it = 'save';
$employee_info->setContinueAdd($save_it);
$confirmation = $employee_info->saveEmployee();
//gets the user id in case we need to set commissions
$emp_user_id = $employee_info->getUserId();

//check to see if this is not null and then parse
if(isset($_POST['service_types1'])) {
        //loop through the check boxes
         foreach($_POST['service_types1'] as $value1) {
               $valueArray = explode("|", $value1);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }

//check to see if this is not null and then parse
if(isset($_POST['service_types2'])) {
        //loop through the check boxes
         foreach($_POST['service_types2'] as $value2) {
               $valueArray = explode("|", $value2);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }


//check to see if this is not null and then parse
if(isset($_POST['service_types3'])) {
        //loop through the check boxes
         foreach($_POST['service_types3'] as $value3) {
               $valueArray = explode("|", $value3);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }


//check to see if this is not null and then parse
if(isset($_POST['service_types4'])) {
        //loop through the check boxes
         foreach($_POST['service_types4'] as $value4) {
               $valueArray = explode("|", $value4);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }



}//end save


//set the vars to null in order to display the page
$first_name = "";
$middle_name="";
$last_name="";
$street_address = "";
$city="";
//$state="";
$zip_code="";
$home_phone="";
$cell_phone="";
$emergency_contact="";
$emergency_phone="";
$user_name1="";
$pass_word1="";
$pass_word2="";
$payment_amount1="";
$payment_amount2="";
$payment_amount3="";
$payment_amount4="";
$payment_cycle1 = "";
$payment_cycle2 = "";
$payment_cycle3 = "";
$payment_cycle4 = "";
$compensation_type1 ="";
$compensation_type2 = "";
$compensation_type3 = "";
$compensation_type4 = "";
$employee_type1 = "";
$employee_type2 = "";
$employee_type3 = "";
$employee_type4 = "";
$id_card1 = "";
$id_card2 = "";
$id_card3 = "";
$id_card4 = "";
$hours_projected1 = "";
$hours_projected2 = "";
$hours_projected3 = "";
$hours_projected4 = "";
$email = "";
$ss_number = "";
//set the values for the dropdowns in the main form
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
$employeeDrops-> setTypeKey($employee_type1);
$drop_menu_emp1 = $employeeDrops-> loadTypeMenu(); 
$employeeDrops-> setTypeKey($employee_type2);
$drop_menu_emp2 = $employeeDrops-> loadTypeMenu(); 
$employeeDrops-> setTypeKey($employee_type3);
$drop_menu_emp3 = $employeeDrops-> loadTypeMenu(); 
$employeeDrops-> setTypeKey($employee_type4);
$drop_menu_emp4 = $employeeDrops-> loadTypeMenu(); 

//sets up the varibles for the form template
$submit_link = 'addEmployee.php';
$submit_name = 'save';
$page_title  = 'Add Employee Contact / Job Description';
$button_title = 'Save Employee Contact / Job Description(s)';
$file_permissions = "";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/employeeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/userName.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/showServices.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployee.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/checkIdCard.js\"></script>";

$idCardCall = "onChange=\"return checkIdCard(this.value, this.id)\"";

//secondary title for if a sales position is chosen
$secondary_title = 'Add Sales Services';


//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(4);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

include "../templates/employeeTemplate2.php";
?>