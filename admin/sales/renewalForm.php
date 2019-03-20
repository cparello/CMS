<?php
include "accountRenewList.php";
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
//sets up the default balance due date
$term_days = 0;
$balance_due_date = date('D,  F j, Y', strtotime("+$term_days days"));


//set up the renewal percent as a decimal
$early_percent = $_SESSION['earlyRenewalPercent'];
$string_length = strlen($early_percent);
if($string_length == 1) {
$early_percent = ".0$early_percent";
}elseif($string_length == 2) {
$early_percent = ".$early_percent";
}

$accountRenewList = $_SESSION['accountRenewList']; 

$accountRenewList-> loadAccountHolder();
$account_info = $accountRenewList-> getAccountInfo();
$accountRenewList-> loadPrimaryListing();
$primary_renewal = $accountRenewList-> getPrimaryListing();
$available_renewal = $accountRenewList-> getSecondaryListings();
$group_marker = $accountRenewList-> getGroupMarker();
$group_type = $accountRenewList-> getGroupType();
$renewal_fee = $accountRenewList-> getRenewalFee();
$renewal_contract_key = $accountRenewList-> getContractKey();


//get individual listing for reset on form if needed
$group_address2 = $accountRenewList-> getGroupAddress();
$group_phone2 = $accountRenewList-> getGroupPhone();
$group_name = $accountRenewList-> getGroupName();
$street_address2 = $accountRenewList-> getStreetAddress();
$city2 = $accountRenewList-> getCity();
$state2 = $accountRenewList-> getState();
$zip2 = $accountRenewList-> getZipCode();
$primary_phone2 = $accountRenewList-> getPrimaryPhone();
$cell_phone2 = $accountRenewList-> getCellPhone();
$email2 = $accountRenewList-> getEmailAddress();
$selected_renew_rate = $accountRenewList-> getSelectedRenewRate();
$row_count = $accountRenewList-> getFieldCount();
$early_type = $accountRenewList-> getEarlyType();
$first_name = $accountRenewList-> getFirstName();
$middle_name = $accountRenewList-> getMiddleName();
$last_name = $accountRenewList-> getLastName();
$license_number = $accountRenewList-> getLicenseNumber();

//get banking and cc info 
$bank_name = $accountRenewList-> getBankName();
$account_type = $accountRenewList-> getAccountType();
$account_name = $accountRenewList-> getAccountName();
$account_number = $accountRenewList-> getAccountNumber();
$routing_number = $accountRenewList-> getRoutingNumber();
$card_name = $accountRenewList-> getCardName();
$card_type = $accountRenewList-> getCardType();
$card_number = $accountRenewList-> getCardNumber();
$card_cvv = $accountRenewList-> getCardCvv();
$card_exp_date = $accountRenewList-> getCardExpDate();
$pif_out_text = $accountRenewList-> getPifOutText();
$pif_out_bool = $accountRenewList->  getPifOutBool();
$pif_out_time = $accountRenewList->  getPifOutTimeOwed(); 
$pif_out_money_owed = $accountRenewList->  getPifOutMoneyOwed();
$early_test = $accountRenewList->   getEarlyTest();
$past_due_amount = $accountRenewList->   getPastDueAmount();
//echo "$pif_out_bool $pif_out_time $pif_out_money_owed ++++$early_test";
//exit;
          
//selected rand total for pass through
$selected_grand_total = $selected_renew_rate + $renewal_fee;
$selected_grand_total = sprintf ("%01.2f", $selected_grand_total);

$g = 'G';
include "../contracts/paymentOptionsSql.php";
$get_permissions = new paymentOptionsSql();
//first set the pay type first get the general perms
$get_permissions->setOptionType($g);
$get_permissions->loadOptionPerms();
$get_permissions->loadOptionsDisabled();
$cash_disabled1 = $get_permissions->getCashDisabled();
$check_disabled1 = $get_permissions->getCheckDisabled();
$credit_disabled1 = $get_permissions->getCreditDisabled();
$ach_disabled1 = $get_permissions->getAchDisabled();

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

//getst the target dropdown for notes
$targetApp = 'assignment_sales';
include "../utilities/noteSql.php";
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();

 include "../templates/notePopTemplate.php";

//css for lists etc
$renew_css = 'renewForm.css';
//echo"fubar";

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jquery_latest.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/searchMemberAccountsTwo.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/newMemberForm.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/checkRenewFields.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/renewalSelections.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/editAccountInfo.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/checkPin2.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/checkUser2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/printRenewalContract.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/cancelRenewalContract.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
$javaScript20 = "<script type=\"text/javascript\" src=\"../scripts/signaturePad.js\"></script>";
$javaScript21 = "<script type=\"text/javascript\" src=\"../scripts/signature_pad.js\"></script>";

$form_header = "Service Renewal Aggreement";


//universal for sales forms
include "../templates/searchButtonTemplate.php";

//this is the general template
include "../templates/renewalFormTemplate.php";


exit;


//renewalForm.php



?>