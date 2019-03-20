<?php
session_start();
//=======================================================

if(!isset($_SESSION['isLoggedIn']) || !($_SESSION['isLoggedIn']))
	{
		//user is not logged in
		// simply redirect to index.html
		session_unset();
		header("Location:https://cmpdevsite.com/admin/sales/login.php");	
	}
	else
	{
		// user is logged in
		require 'timeCheck.php';
		$hasSessionExpired = checkIfTimedOut();
		if($hasSessionExpired)
		{
			session_unset();
			header("Location:https://cmpdevsite.com/admin/sales/login.php");	
			exit;
		}
		else
		{
			$_SESSION['loggedAt']= time();// update last accessed time
			//showLoggedIn();
		}
	}

//==============================================end timeout


//gets the confirmation message fr a saved sale
if(isset($_SESSION['confirmation_message'])) {
    $confirmation_message = $_SESSION['confirmation_message'];
     unset($_SESSION['confirmation_message']);
     unset($_SESSION['contract_key']);
	 unset($_SESSION['lib_address_array']); 
	 unset($_SESSION['lib_emg_contact_array']); 
   }else{
   $confirmation_message ="";
   }
 echo "<br><br><br>$confirmation_message"; 
//sets up the default balance due date
$term_days = 0;
$balance_due_date = date('D,  F j, Y', strtotime("+$term_days days"));

include '../dbConnect.php';
$sql = "SELECT billing_setup FROM billing_setup WHERE setup_id = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing_switch);
$stmt->fetch();
$stmt->close();  




$commission_credit = $_SESSION['user_name'];
$userId  = $_SESSION['user_id'];
$_SESSION['overide_pin'] = 'N';

//get the processing fees
include "../contracts/feesSql.php";
//load the form content
$loadFees = new feesSql();
$loadFees -> loadFees();
$process_fee_single = $loadFees -> getProcessFeeSingle();
$process_fee_family = $loadFees -> getProcessFeeFamily();
$process_fee_business = $loadFees -> getProcessFeeBusiness();
$process_fee_organization = $loadFees -> getProcessFeeOrganization();

$process_fee_single2 = $loadFees -> getProcessFeeSingle2();
$process_fee_family2 = $loadFees -> getProcessFeeFamily2();
$process_fee_business2 = $loadFees -> getProcessFeeBusiness2();
$process_fee_organization2 = $loadFees -> getProcessFeeOrganization2();
$ren_percent = $loadFees -> getRenewalPercent();

//add a  decimal to the ren_percent since it was saved as a whole number
$string_length = strlen($ren_percent);
if($string_length == 1) {
$ren_percent = ".0$ren_percent";
}elseif($string_length == 2) {
$ren_percent = ".$ren_percent";
}

//uncheck this once I find the bug
$month_service = "";

$single_fees ="$process_fee_single|$process_fee_single2";
$family_fees ="$process_fee_family|$process_fee_family2";
$business_fees ="$process_fee_business|$process_fee_business2";
$organization_fees ="$process_fee_organization|$process_fee_organization2";

//set the vars for group types
$group_type_single = 'S';
$group_type_family  = 'F';
$group_type_business  = 'B';
$group_type_organization  = 'O';

include "employeeServiceLists3.php";
$emp_service_lists = new employeeServiceLists();
$emp_service_lists ->setUserId($userId);


//first we set the single group type
$emp_service_lists ->setGroupType($group_type_single);
$string_list_single = $emp_service_lists ->loadServiceLists();
//this gets the number of rows
$single_rows = $emp_service_lists ->getSingleRows();
//set the drop down services to not show or show if records are present
if($string_list_single == '<table>') {
$single_list_header = null;
}else{
$single_list_header = '<p class="header">Single Membership Services<span class="plus">+</span></p>';
}


//set for family
$emp_service_lists ->setGroupType($group_type_family);
$string_list_family = $emp_service_lists ->loadServiceLists();
//this gets the number of rows
$family_rows = $emp_service_lists ->getFamilyRows();
//set the drop down services to not show or show if records are present
if($string_list_family == '<table>') {
$family_list_header = null;
}else{
$family_list_header = '<p class="header">Family Membership Services<span class="plus">+</span></p>';
}

//set for business
$emp_service_lists ->setGroupType($group_type_business);
$string_list_business = $emp_service_lists ->loadServiceLists();
//this gets the number of rows
$business_rows = $emp_service_lists ->getBusinessRows();
//set the drop down services to not show or show if records are present
if($string_list_business == '<table>') {
$business_list_header = null;
}else{
$business_list_header = '<p class="header">Business Membership Services<span class="plus">+</span></p>';
}

//set for business
$emp_service_lists ->setGroupType($group_type_organization);
$string_list_organization = $emp_service_lists ->loadServiceLists();
//this gets the number of rows
$organization_rows = $emp_service_lists ->getOrganizationRows();
//set the drop down services to not show or show if records are present
if($string_list_organization == '<table>') {
$organization_list_header = null;
}else{
$organization_list_header = '<p class="header">Organization Membership Services<span class="plus">+</span></p>';
}

//get the summary divs
$single_summary_divs = $emp_service_lists ->getSingleSummaryDivs();
$family_summary_divs = $emp_service_lists ->getFamilySummaryDivs();
$business_summary_divs = $emp_service_lists ->getBusinessSummaryDivs();
$organization_summary_divs = $emp_service_lists ->getOrganizationSummaryDivs();

//this sets up the default group contact form when page is initialy loaded
//first we check to see if single group type is present then create this as the default
include "contactForms.php";
$contact_forms = new contactForms();

if($single_list_header != null)  {
$contact_forms ->setGroupType($group_type_single);
$group_type = $group_type_single;
}elseif(($single_list_header == null) && ($family_list_header != null)) {
$contact_forms ->setGroupType($group_type_family);
$group_type = $group_type_family;
}elseif(($single_list_header == null) && ($family_list_header == null) && ($business_list_header != null)) {
$contact_forms ->setGroupType($group_type_business);
$group_type = $group_type_business;
}elseif(($single_list_header == null) && ($family_list_header == null) && ($business_list_header == null) && ($organization_list_header != "")) {
$contact_forms ->setGroupType($group_type_organization);
$group_type = $group_type_organization;
}

//create the contact forms
$contact_forms ->loadGroupForms();
//get the contact forms
$group_info_form = $contact_forms ->getGroupInfoForm();
$group_form = $contact_forms ->getGroupForm();

//get the form for the service status
include "statusForms.php";
$status_type = 'N';
$status_form = new statusForms();
$status_form -> setStatusType($status_type);
$status_form -> loadStatusForms();
$status_type = $status_form-> getStatusForm();
$form_header = $status_form-> getFormTypeHeader();



//this will set up the available payment options
$g = 'G';
$m = 'M';
include "../contracts/paymentOptionsSql.php";
$get_permissions = new paymentOptionsSql();
//first set the pay type first get the general perms
$get_permissions-> setOptionType($g);
$get_permissions-> loadOptionPerms();
$get_permissions-> loadOptionsDisabled();
$cash_disabled1 = $get_permissions-> getCashDisabled();
$check_disabled1 = $get_permissions-> getCheckDisabled();
$credit_disabled1 = $get_permissions-> getCreditDisabled();
$ach_disabled1 = $get_permissions-> getAchDisabled();
//get the month perms and save to hidden field
$get_permissions-> setOptionType($m);
$get_permissions-> loadOptionPerms();
$month_bit = $get_permissions-> getOptionPerms();

//variables for drop downs for cc and ach
$script_event = 'onFocus="return checkServices(this.name,this.id)"';
$account_tab = "";
$month_tab = "";
$year_tab = "";
$type_tab = "";

include "../forms/bankForms.php";
$bank_forms = new bankForms();
$bank_forms -> setAccountDropTab($account_tab);
$bank_forms -> setAccountDropScript($script_event);
$bank_forms -> setAccountDropDisable($ach_disabled1);
$bank_forms -> createAccountDrop();
$account_drop = $bank_forms -> getAccountDrop();


include "../forms/cardForms.php";
$card_forms = new cardForms();
$card_forms -> setTypeDropTab($type_tab);
$card_forms -> setTypeDropScript($script_event);
$card_forms -> setTypeDropDisable($credit_disabled1);

$card_forms -> setMonthDropDisable($credit_disabled1);
$card_forms -> setMonthDropScript($script_event);
$card_forms -> setMonthDropTab($month_tab);

$card_forms -> setYearDropDisable($credit_disabled1);
$card_forms -> setYearDropScript($script_event);
$card_forms -> setYearDropTab($year_tab);

$card_forms -> createTypeDrop();
$card_forms -> createMonthDrop();
$card_forms -> createYearDrop();
$month_drop = $card_forms ->getMonthDrop();
$year_drop = $card_forms ->getYearDrop();
$type_drop = $card_forms -> getTypeDrop();



include "../helper_apps/parseAgents.php";
$parse_agents = new parseAgents();
$parse_agents-> setUserAgentArray($_SERVER['HTTP_USER_AGENT']);
$parse_agents-> loadUserAgent();
$parse_switch = $parse_agents-> getVersionSwitch();
$agent = $parse_agents-> getBrowserType();

//getst the target dropdown for notes
$targetApp = 'assignment_sales';
include "../utilities/noteSql.php";
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();

 include "../templates/notePopTemplate.php";
 
$class_date = date("m/d/Y"); 

//$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jquery_latest.js\"></script>";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/mathFunctions.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/clearRowGroup.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/checkPin.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/setContactDivs.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/checkSalesFields.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/checkUser.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/printContract.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/cancelContract.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/searchMemberAccounts.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
$javaScript13 = "<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript14 = "<script type=\"text/javascript\" src=\"../scripts/helpTxtSales.js\"></script>";
$javaScript15 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript16 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript17 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript18 = "<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.js\"></script>";
$javaScript19 = "<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.scroller.js\"></script>";
$javaScript20 = "<script type=\"text/javascript\" src=\"../scripts/signaturePad.js\"></script>";
$javaScript21 = "<script type=\"text/javascript\" src=\"../scripts/signature_pad.js\"></script>";
//include the proper css and html template based on the switch
//version switch depends on browser. 2 is for IE less than vers 8 or FF version 4.   3 is for IE 8 or Chrome. 1 is for FF less then vers 4. 4 is for IE 9 +
//universal for sales forms
include "../templates/searchButtonTemplate.php";

$numberRepDay = date('N');
switch($numberRepDay){
    case 1:
        $monDate = date('F j Y',strtotime($todaysDate));
        $tueDate = date('F j Y',strtotime('+ 1 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime('+ 2 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime('+ 3 day'.$todaysDate));
        $friDate = date('F j Y',strtotime('+ 4 day'.$todaysDate));
        $satDate = date('F j Y',strtotime('+ 5 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime('+ 6 day'.$todaysDate));
    break;
    case 2:
        $monDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime($todaysDate));
        //echo"$todaysDate $tueDate";
        $wedDate = date('F j Y',strtotime('+ 1 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime('+ 2 day'.$todaysDate));
        $friDate = date('F j Y',strtotime('+ 3 day'.$todaysDate));
        $satDate = date('F j Y',strtotime('+ 4 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime('+ 5 day'.$todaysDate));
    break;
    case 3:
        $monDate = date('F j Y',strtotime('- 2 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime($todaysDate));
        $thuDate = date('F j Y', strtotime('+ 1 day'.$todaysDate));
        $friDate = date('F j Y',strtotime('+ 2 day'.$todaysDate));
        $satDate = date('F j Y',strtotime('+ 3 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime('+ 4 day'.$todaysDate));
    break;
    case 4:
        $monDate = date('F j Y',strtotime('- 3 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime('- 2 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime($todaysDate));
        $friDate = date('F j Y',strtotime('+ 1 day'.$todaysDate));
        $satDate = date('F j Y',strtotime('+ 2 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime('+ 3 day'.$todaysDate));
    break;
    case 5:
        $monDate = date('F j Y',strtotime('- 4 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime('- 3 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime('- 2 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $friDate = date('F j Y',strtotime($todaysDate));
        $satDate = date('F j Y', strtotime('+ 1 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime('+ 2 day'.$todaysDate));
    break;
    case 6:
        $monDate = date('F j Y',strtotime('- 5 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime('- 4 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime('- 3 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime('- 2 day'.$todaysDate));
        $friDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $satDate = date('F j Y',strtotime($todaysDate));
        $sunDate = date('F j Y',strtotime('+ 1 day'.$todaysDate));
    break;
    case 7:
        $monDate = date('F j Y',strtotime('- 6 day'.$todaysDate));
        $tueDate = date('F j Y',strtotime('- 5 day'.$todaysDate));
        $wedDate = date('F j Y',strtotime('- 4 day'.$todaysDate));
        $thuDate = date('F j Y',strtotime('- 3 day'.$todaysDate));
        $friDate = date('F j Y',strtotime('- 2 day'.$todaysDate));
        $satDate = date('F j Y',strtotime('- 1 day'.$todaysDate));
        $sunDate = date('F j Y',strtotime($todaysDate));
    break;
}
 

if($parse_switch == 1)  {
   $sales_form_css = 'salesForm2.css';
    include "../templates/salesServiceLists2Template.php";
}elseif($parse_switch == 2)  {
    $sales_form_css = 'salesForm.css';
     include "../templates/salesServiceListsTemplate.php";
}elseif($parse_switch == 3)  {
    $sales_form_css = 'salesForm.css';
     include "../templates/salesServiceLists3Template.php";
}elseif($parse_switch == 4)  {
    $sales_form_css = 'salesForm.css';
     include "../templates/salesServiceLists3Template.php";
}





exit;


?>




