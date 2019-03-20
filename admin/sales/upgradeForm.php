<?php
include "accountUpgradeList.php";
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================
if(!isset($_SESSION['isLoggedIn']) || !($_SESSION['isLoggedIn']))
	{
		//user is not logged in
		// simply redirect to index.html
		session_unset();
		header("Location:../sales/login.php");	
	}
	else
	{
		// user is logged in
		require 'timeCheck.php';
		$hasSessionExpired = checkIfTimedOut();
		if($hasSessionExpired)
		{
			session_unset();
			header("Location:../sales/login.php");	
			exit;
		}
		else
		{
			$_SESSION['loggedAt']= time();// update last accessed time
			//showLoggedIn();
		}
	}
	
	function showLoggedIn()
	{
		echo'<html>';
		echo'<head>';
		echo'<script type="text/javascript" src="ajax.js"></script>';
		echo'</head>';
		echo'<body>';
			echo'<p>';
				echo'Page2. User is logged in currently.Timeout has been set to 5 seconds. If you stay inactive for more then 5 seconds, you will be logged out automatically and redirected to home page.';
			echo'</p>';
			echo'<br/>';
			echo'<p><a href="first.php">Back to first page</a></p>';
			echo'<br/><br/><br/><p><a href="">Back to article</a></p>';
		echo'</body>';
		echo'</html>';
	}
//==============================================end timeout

$userId  = $_SESSION['user_id'];
$commission_credit = $_SESSION['user_name'];

//sets up the default balance due date
$term_days = 0;
$balance_due_date = date('D,  F j, Y', strtotime("+$term_days days"));

//this we willset as a function for a different time zone once we have  this function created
$todays_date = date('Y-m-d');
$todays_date = strtotime($todays_date);

//get the current day number of the month and the numberof days in the month for month prorate if new members added
$current_day_number = date(d);
$month_days_number = date(t);
//get the difference between the days
$remain_month_days = $month_days_number - $current_day_number;

include '../dbConnect.php';
$sql = "SELECT billing_setup FROM billing_setup WHERE setup_id = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing_switch);
$stmt->fetch();
$stmt->close(); 


//get the existing services and the account info of the client
$accountUpgradeList = $_SESSION['accountUpgradeList']; 
$accountUpgradeList-> loadAccountHolder();
$account_info = $accountUpgradeList-> getAccountInfo();
$accountUpgradeList->loadCurrentListings();
$current_services = $accountUpgradeList-> getCurrentServices();
$group_type = $accountUpgradeList-> getGroupType();
$key_list = $accountUpgradeList-> getKeyList();
$membership_flag = $accountUpgradeList-> getMembershipFlag();
$group_number = $accountUpgradeList-> getGroupNumber();
$month_governor = $accountUpgradeList-> getMonthGovernor();
$month_end_date = $accountUpgradeList-> getMonthEndDate();
$month_billing_type = $accountUpgradeList-> getMonthlyBillingType();
$daily_rate_array = $accountUpgradeList-> getDailyRateArray();
$field_count = $accountUpgradeList-> getProFieldCount();
$total_renew_rate = $accountUpgradeList-> getTotalRenewRate();
$group_marker = $accountUpgradeList-> getGroupMarker();
$contract_key = $accountUpgradeList-> getContractKey();
$transfer_radio = $accountUpgradeList-> getTransferStatus();
$upgrade_flag = $accountUpgradeList-> getUpgradeFlag();
$upgrade_service_key = $accountUpgradeList-> getUpgradeServiceKey();

$first_name = $accountUpgradeList-> getFirstName();
$middle_name = $accountUpgradeList-> getMiddleName();
$last_name = $accountUpgradeList-> getLastName();
$group_name = $accountUpgradeList-> getGroupName();

//get individual listing for reset on form if needed
$group_address2 = $accountUpgradeList-> getGroupAddress();
$group_phone2 = $accountUpgradeList-> getGroupPhone();
$street_address2 = $accountUpgradeList-> getStreetAddress();
$city2 = $accountUpgradeList-> getCity();
$state2 = $accountUpgradeList-> getState();
$zip2 = $accountUpgradeList-> getZipCode();
$primary_phone2 = $accountUpgradeList-> getPrimaryPhone();
$cell_phone2 = $accountUpgradeList-> getCellPhone();
$email2 = $accountUpgradeList-> getEmailAddress();
$license_number = $accountUpgradeList-> getLicenseNumber();


//get banking and cc info 
$bank_name = $accountUpgradeList-> getBankName();
$account_type = $accountUpgradeList-> getAccountType();
$account_name = $accountUpgradeList-> getAccountName();
$account_number = $accountUpgradeList-> getAccountNumber();
$routing_number = $accountUpgradeList-> getRoutingNumber();
$card_name = $accountUpgradeList-> getCardName();
$card_type = $accountUpgradeList-> getCardType();
$card_number = $accountUpgradeList-> getCardNumber();
$card_cvv = $accountUpgradeList-> getCardCvv();
$card_exp_date = $accountUpgradeList-> getCardExpDate();
$current_monthly_payments = $accountUpgradeList-> getMonthlyPayments();
//if the current monthly payments are null, set to zero for js scripts
if($current_monthly_payments == "") {
     $current_monthly_payments = '0.00';
  }

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
$account_tab = 190;
$month_tab = 140;
$year_tab = 150;
$type_tab =100;


include "../forms/bankForms.php";
$bank_forms = new bankForms();
$bank_forms -> setAccountDropTab($account_tab);
$bank_forms -> setAccountDropScript($script_event);
$bank_forms -> setAccountDropDisable($ach_disabled1);
$bank_forms -> setAccountTypeSelected($account_type);
$bank_forms -> createAccountDrop();
$account_drop = $bank_forms -> getAccountDrop();

include "../forms/cardForms.php";
$card_forms = new cardForms();
$card_forms -> setExpirationDate($card_exp_date);  //set only if account is existing
$card_forms -> parseDateSelected(); //set only if it is an existing account

$card_forms -> setTypeDropTab($type_tab);
$card_forms -> setTypeDropScript($script_event);
$card_forms -> setTypeDropDisable($credit_disabled1);
$card_forms -> setCardTypeSelected($card_type);

$card_forms -> setMonthDropScript($script_event);
$card_forms -> setMonthDropTab($month_tab);
$card_forms -> setMonthDropDisable($credit_disabled1);

$card_forms -> setYearDropTab($year_tab);
$card_forms -> setYearDropScript($script_event);
$card_forms -> setYearDropDisable($credit_disabled1);

$card_forms -> createTypeDrop();
$card_forms -> createMonthDrop();
$card_forms -> createYearDrop();
$month_drop = $card_forms -> getMonthDrop();
$year_drop = $card_forms -> getYearDrop();
$type_drop = $card_forms -> getTypeDrop();



//get the services avalable for upgrade
include "employeeServiceLists4.php";
$emp_service_lists = new employeeServiceLists();
$emp_service_lists-> setUserId($userId);
$emp_service_lists-> setGroupType($group_type);
$emp_service_lists-> setGroupNumber($group_number);
$emp_service_lists-> setKeyList($key_list);
$emp_service_lists-> setMembershipFlag($membership_flag);
$emp_service_lists-> setMonthGovernor($month_governor);
$emp_service_lists-> setUpgradeFlag($upgrade_flag);
$emp_service_lists-> setUpgradeServiceKey($upgrade_service_key);
$available_upgrades  = $emp_service_lists-> loadServiceLists();
$new_upgrade_service_key = $emp_service_lists-> getNewUpgradeServiceKey();

//get the summary divs
$single_summary_divs = $emp_service_lists ->getSingleSummaryDivs();
$family_summary_divs = $emp_service_lists ->getFamilySummaryDivs();
$business_summary_divs = $emp_service_lists ->getBusinessSummaryDivs();
$organization_summary_divs = $emp_service_lists ->getOrganizationSummaryDivs();

$single_rows = $emp_service_lists ->getSingleRows();
$family_rows = $emp_service_lists ->getFamilyRows();
$business_rows = $emp_service_lists ->getBusinessRows();
$organization_rows = $emp_service_lists ->getOrganizationRows();

//get the form for the service status
include "statusForms.php";
$status_type = 'U';
$status_form = new statusForms();
$status_form -> setStatusType($status_type);
$status_form -> loadStatusForms();
$status_type = $status_form-> getStatusForm();
$form_header = $status_form-> getFormTypeHeader();


//get the processing fees
include "../contracts/feesSql.php";
//load the form content
$loadFees = new feesSql();
$loadFees -> loadFees();
$process_fee_single = $loadFees -> getUpgradeFeeSingle();
$process_fee_family = $loadFees -> getUpgradeFeeFamily();
$process_fee_business = $loadFees -> getUpgradeFeeBusiness();
$process_fee_organization = $loadFees -> getUpgradeFeeOrganization();

$process_fee_single2 = $loadFees -> getUpgradeFeeSingle2();
$process_fee_family2 = $loadFees -> getUpgradeFeeFamily2();
$process_fee_business2 = $loadFees -> getUpgradeFeeBusiness2();
$process_fee_organization2 = $loadFees -> getUpgradeFeeOrganization2();

$process_fee_single3 = $loadFees -> getUpgradeFeeSingle3();
$process_fee_family3 = $loadFees -> getUpgradeFeeFamily3();
$process_fee_business3 = $loadFees -> getUpgradeFeeBusiness3();
$process_fee_organization3 = $loadFees -> getUpgradeFeeOrganization3();


$ren_percent = $loadFees -> getRenewalPercent();

$single_fees ="$process_fee_single|$process_fee_single2|$process_fee_single3";
$family_fees ="$process_fee_family|$process_fee_family2|$process_fee_family3";
$business_fees ="$process_fee_business|$process_fee_business2|$process_fee_business3";
$organization_fees ="$process_fee_organization|$process_fee_organization2|$process_fee_organization3";

//add a  decimal to the ren_percent since it was saved as a whole number
$string_length = strlen($ren_percent);
if($string_length == 1) {
$ren_percent = ".0$ren_percent";
}elseif($string_length == 2) {
$ren_percent = ".$ren_percent";
}

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
 
//css for lists etc
$upgrade_css = 'upgradeForm.css';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jquery_latest.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/searchMemberAccountsTwo.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/checkUser.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/checkPin3v2.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/newMemberForm.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/checkUpgradeFields.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/monthlySummaryDivs.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/mathFunctions2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/clearRowGroup2.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/editAccountInfo.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/printUpgradeContractv2.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/cancelUpgradeContract.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
$javaScript20 = "<script type=\"text/javascript\" src=\"../scripts/signaturePad.js\"></script>";
$javaScript21 = "<script type=\"text/javascript\" src=\"../scripts/signature_pad.js\"></script>";
$javaScript22 = "<script type=\"text/javascript\" src=\"../scripts/salesPreAuthCard.js\"></script>";
//universal for sales forms
include "../templates/searchButtonTemplate.php";

//this is the general template
include "../templates/upgradeListTemplate.php";



exit;

?>