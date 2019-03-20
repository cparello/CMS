<?php
include "upgradeSql.php";
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
$upgradeSql = $_SESSION['upgradeSql'];

$group_type = $upgradeSql-> getGroupType(); 
$group_name = $upgradeSql-> getGroupName(); 
$group_info_array = $upgradeSql-> getGroupInfoArray();
$address_info_array = $upgradeSql-> getAddressInfoArray(); 
$product_list_array = $upgradeSql-> getProductListArray();
$new_members = $upgradeSql-> getNewMembers();
$current_prorate_array =$upgradeSql-> getCurrentProrateArray();
$transfer = $upgradeSql-> getTransfer();
$pro_rate_dues = $upgradeSql-> getProRateDues();
$proc_fee_eft = $upgradeSql-> getProcFeeEft();
$initial_fees_eft = $upgradeSql-> getInitialFeesEft(); 
$monthly_payment = $upgradeSql-> getMonthlyPayment();
$new_monthly_payment = $upgradeSql-> getNewMonthlyPayment(); 
$current_monthly_prorate = $upgradeSql-> getCurrentMonthlyProrate();
$total_monthly_services = $upgradeSql-> getTotalMonthlyServices();
$open_ended = $upgradeSql-> getTermType();
$initiation_fee = $upgradeSql-> getInitiationFee();
$new_total_pif_services = $upgradeSql-> getNewTotalPifServices();
$proc_fee_pif = $upgradeSql-> getProcFeePif();
$new_pif_grand_total = $upgradeSql-> getNewPifgrandTotal();
$current_pif_prorate_total = $upgradeSql-> getCurrentPifProrateTotal(); 
$new_current_pif_grand_total = $upgradeSql-> getNewCurrentPifGrandTotal();
$current_renew_total = $upgradeSql-> getCurrentRenewTotal();
$current_monthly_payment = $upgradeSql-> getCurrentMonthlyPayment();
$new_member_fee = $upgradeSql-> getNewMemberFee();
$new_services_total = $upgradeSql-> getNewServicesTotal();
$new_renewal_rate_total = $upgradeSql-> getNewRenewalRateTotal();
$minimum_total_due = $upgradeSql-> getMinimumTotalDue();
$todays_payment = $upgradeSql-> getTodaysPayment();
$balance_due = $upgradeSql-> getBalanceDue();
$balance_due_date = $upgradeSql-> getDueDate();
$contract_key = $upgradeSql-> getContractKey();
$group_number = $upgradeSql-> getGroupNumber();
//$middle_name = $upgradeSql-> getMiddleName();
//$last_name = $upgradeSql-> getLastName();
$monthly_billing_type = $upgradeSql-> getMonthlyBillingType();
$sig = $upgradeSql-> getSig();
//echo "test";
include "upgradeContractSql.php";
$upgradeContractSql = new upgradeContractSql();
$upgradeContractSql-> setGroupType($group_type); 
$upgradeContractSql-> setGroupName($group_name); 
$upgradeContractSql-> setGroupInfoArray($group_info_array);
$upgradeContractSql-> setAddressInfoArray($address_info_array); 
$upgradeContractSql-> setProductListArray($product_list_array);
$upgradeContractSql-> setNewMembers($new_members);
$upgradeContractSql-> setCurrentProrateArray($current_prorate_array);
$upgradeContractSql-> setTransfer($transfer);
$upgradeContractSql-> setProRateDues($pro_rate_dues);
$upgradeContractSql-> setProcFeeEft($proc_fee_eft);
$upgradeContractSql-> setInitialFeesEft($initial_fees_eft); 
$upgradeContractSql-> setMonthlyPayment($monthly_payment);
$upgradeContractSql-> setNewMonthlyPayment($new_monthly_payment); 
$upgradeContractSql-> setCurrentMonthlyProrate($current_monthly_prorate);
$upgradeContractSql-> setTotalMonthlyServices($total_monthly_services);
$upgradeContractSql-> setTermType($open_ended);
$upgradeContractSql-> setInitiationFee($initiation_fee);
$upgradeContractSql-> setNewTotalPifServices($new_total_pif_services);
$upgradeContractSql-> setProcFeePif($proc_fee_pif);
$upgradeContractSql-> setNewPifgrandTotal($new_pif_grand_total);
$upgradeContractSql-> setCurrentPifProrateTotal($current_pif_prorate_total); 
$upgradeContractSql-> setNewCurrentPifGrandTotal($new_current_pif_grand_total);
$upgradeContractSql-> setCurrentRenewTotal($current_renew_total);
$upgradeContractSql-> setCurrentMonthlyPayment($current_monthly_payment);
$upgradeContractSql-> setNewMemberFee($new_member_fee);
$upgradeContractSql-> setNewServicesTotal($new_services_total);
$upgradeContractSql-> setNewRenewalRateTotal($new_renewal_rate_total);
$upgradeContractSql-> setMinimumTotalDue($minimum_total_due);
$upgradeContractSql-> setTodaysPayment($todays_payment);
$upgradeContractSql-> setBalanceDue($balance_due);
$upgradeContractSql-> setDueDate($balance_due_date);
$upgradeContractSql-> setContractKey($contract_key);
$upgradeContractSql-> setGroupNumber($group_number);
$upgradeContractSql-> setMonthlyBillingType($monthly_billing_type);

$upgradeContractSql-> loadUpgradeContractDefaults(); 
$upgradeContractSql-> loadContractTerms();
$logo_image = $upgradeContractSql-> getLogoImage();
$upgrade_header = $upgradeContractSql-> getContractTypeHeader();

$upgradeContractSql-> parseContactInfo();
$street_address = $upgradeContractSql-> getStreetAddress();
$primary_phone = $upgradeContractSql-> getPrimaryPhone();
$cell_phone = $upgradeContractSql-> getCellPhone();
$email_address = $upgradeContractSql-> getEmailAddress();

$upgradeContractSql-> parseGroupInfo();
$group_info = $upgradeContractSql-> getGroupTypeInfo();

$upgradeContractSql-> loadBusinessInfo();
$business_name = $upgradeContractSql-> getBusinessName();
$business_dba = $upgradeContractSql-> getBusinessDba();

$upgradeContractSql-> loadCurrentServices();
$upgrade_header1 = $upgradeContractSql-> getUpgradeHeader1();

$upgradeContractSql-> loadNewServices();
$new_services = $upgradeContractSql-> getNewServices();

$pro_rows = $upgradeContractSql-> getProrateTableRows();

$upgradeContractSql-> loadInitialPayments();
$initial_payments = $upgradeContractSql-> getInitialPayments();
$initial_payments_email = $upgradeContractSql->  getInitPayRowsEmail();

$contract_terms = $upgradeContractSql-> getContractTerms();
$terms_css = $upgradeContractSql-> getTermsCss();

$upgradeContractSql-> checkEnhanceFee();
$upgradeContractSql-> checkCurrentEnhanceFeeEft();
$upgradeContractSql-> checkCurrentGuaranteeFee();
$upgradeContractSql-> loadMonthlyTransactionRequest();
$transaction_request = $upgradeContractSql-> getTransactionRequest(); 

$upgradeContractSql-> loadSignupSection(); 
$signup_section = $upgradeContractSql-> getSignupSection();
$new_services_email = $upgradeContractSql-> getNewServicesEmail();
$pro_tables_email = $upgradeContractSql-> getProTablesEmail();
$emp_name = $upgradeContractSql-> getEmpName();
$name = $upgradeContractSql-> getName();
$cName = $upgradeContractSql-> getCName();

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";

include "../templates/upgradeContractTemplate.php";

$upgradeSql-> setContractHtml($upgradeTemplate);
$_SESSION['upgradeSql'] = $upgradeSql;
?>