<?php
include "salesSql.php";
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



$salesSql = $_SESSION['salesSql'];

$salesSql-> loadClubLocation();
$location_id = $salesSql-> getLocationId();
$club_location = $salesSql->getClubLocation();
$product_list = $salesSql-> getProductList();
$contractKey = $salesSql-> getContractKey();
$monthly_billing_type = $salesSql-> getMonthlyBillingType();
$group_type = $salesSql-> getGroupType();
$group_type_info = $salesSql-> getGroupTypeInfo();
$client_info = $salesSql-> getContractClientInfo();
$group_number = $salesSql-> getGroupNumber();
$term_type = $salesSql-> getTermType();
$transfer = $salesSql-> getTransfer();
$pro_rate_dues = $salesSql-> getProRateDues();
$process_fee_eft = $salesSql-> getProcessFeeMonthly();
$down_payment = $salesSql-> getDownPayment();
$initiation_fee = $salesSql-> getInitiationFee();
$process_fee_pif = $salesSql-> getProcessFeePif();
$pre_paid_services = $salesSql-> getPifServicesTotal();
$today_payment = $salesSql-> getTodaysPayment(); 
$balance_due = $salesSql-> getBalanceDue();
$balance_due_date = $salesSql->getDueDate();
$monthly_payment = $salesSql-> getMonthlyDues();
$date_picker = $salesSql-> getDatePicker();
$sig = $salesSql-> getSig();


include "contractSql.php";
$contractSql = new contractSql();
$contractSql-> loadContractDefaults();
$logo_image = $contractSql-> getLogoImage();
$contract_terms = $contractSql-> getContractTerms();
$contract_quit = $contractSql-> getContractQuit();

//set the vars for the contract header
$contract_type = 'S';
$contractSql-> setDatePicker($date_picker);
$contractSql-> setSig($sig);
$contractSql-> setGroupType($group_type);
$contractSql-> setGroupTypeInfo($group_type_info);
$contractSql-> parseGroupTypeInfo();
$contractSql-> setContractType($contract_type);
$contractSql-> loadContractType();
$contract_type_header = $contractSql-> getContractTypeHeader();
$contractSql-> parseContactInfo($client_info);
$group_info = $contractSql-> getGroupTypeInfo();
$first_name = $contractSql-> getFirstName();
$middle_name = $contractSql-> getMiddleName();
$last_name = $contractSql-> getLastName();
$street_address = $contractSql-> getStreetAddress();
$primary_phone = $contractSql-> getPrimaryPhone();
$cell_phone = $contractSql-> getCellPhone();
$email_address = $contractSql-> getEmailAddress();

$contractSql-> loadBusinessInfo();
$business_name = $contractSql-> getBusinessName();
$business_dba = $contractSql-> getBusinessDba();

$contractSql-> setDownPayment($down_payment);
$contractSql-> setTermType($term_type);
$contractSql-> setGroupNumber($group_number);
$contractSql-> setProductListArray($product_list);
$contractSql-> setTransfer($transfer);
$contractSql-> loadProductSummarys();

$summary_rows = $contractSql-> getSummaryTableRows();
$summary_rows_email = $contractSql-> getSummaryEmailRows();

$contractSql-> setProRateDues($pro_rate_dues);
$contractSql-> setProcessFeeMonthly($process_fee_eft);

$contractSql-> setInitiationFee($initiation_fee);
$contractSql-> setProcessFeePif($process_fee_pif);
$contractSql-> setPifServicesTotal($pre_paid_services);
$contractSql-> setTodaysPayment($today_payment);
$contractSql-> setBalanceDue($balance_due);
$contractSql-> setDueDate($balance_due_date);
$contractSql-> loadInitialPayments();
$initial_payments = $contractSql-> getInitialPayments();
$initial_payments_email = $contractSql-> getInitialEmailRows();
$contractSql-> loadContractTerms();
$contract_terms = $contractSql-> getContractTerms();
$liability_terms = $contractSql-> getLiabilityTerms();
$emp_name = $contractSql-> getEmpName();
$contractSql-> setMonthlyDues($monthly_payment);
$contractSql-> setMonthlyBillingType($monthly_billing_type);


$contractSql-> checkEnhanceFee();
$contractSql-> loadMonthlyTransactionRequest();
$transaction_request = $contractSql-> getTransactionRequest(); 

$contractSql-> loadSignupSection(); 
$signup_section = $contractSql-> getSignupSection();



$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";


include "../templates/contractTemplate.php";

$salesSql-> setContractHtml($contractTemplate);
$_SESSION['salesSql'] = $salesSql;
?>