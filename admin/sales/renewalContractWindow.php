<?php
include "renewalSql.php";
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
$renewalSql = $_SESSION['renewalSql'];
$product_list = $renewalSql-> getProductList();
$contract_key = $renewalSql-> getContractKey();
$group_info = $renewalSql-> getGroupInfo();
$address_info = $renewalSql-> getAddressInfo();
$renewal_fee = $renewalSql-> getRenewalFee();  
$service_total = $renewalSql-> getServiceTotal(); 
$grand_total = $renewalSql-> getGrandTotal();
$todays_payment = $renewalSql-> getTodaysPayment();
$balance_due = $renewalSql-> getBalanceDue();
$balance_due_date = $renewalSql-> getBalanceDueDate();
$first_name = $renewalSql-> getFirstName();
$middle_name = $renewalSql-> getMiddleName();
$last_name = $renewalSql-> getLastName();
$group_name = $renewalSql->getGroupTypeName();
$group_type = $renewalSql->getGroupTypeContract();
$pif_out_bool = $renewalSql->  getPifOutBool();
$pif_out_time = $renewalSql-> getPifOutTime();
$pif_out_money_owed = $renewalSql-> getPifOutMoneyOwed();
$year_quantity = $renewalSql-> getYearQuantity();
$old_key = $renewalSql-> getOldKey();
$changed_service_bool = $renewalSql-> getChangedServiceBool();      
$sig = $renewalSql-> getSig();
$pastDueAmount = $renewalSql->  getPastDueAmount();

include "renewalContractSql.php";
$renewalContractSql = new renewalContractSql();
$renewalContractSql-> setOldKey($old_key);
$renewalContractSql-> setChangedServiceBool($changed_service_bool);
$renewalContractSql-> setContractKey($contract_key);
$renewalContractSql-> setPastDue($pastDueAmount);
$renewalContractSql-> setGroupType($group_type);
$renewalContractSql-> setPifOutBool($pif_out_bool);
$renewalContractSql-> setPifOutTime($pif_out_time);
$renewalContractSql-> setPifOutMoneyOwed($pif_out_money_owed);
$renewalContractSql-> setYearQuantity($year_quantity);
$renewalContractSql-> loadRenewalContractDefaults();
$logo_image = $renewalContractSql-> getLogoImage();
$renewal_header = $renewalContractSql-> getRenewalTypeHeader();
$renewalContractSql-> parseContactInfo($address_info);
$street_address = $renewalContractSql-> getStreetAddress();
$primary_phone = $renewalContractSql-> getPrimaryPhone();
$cell_phone = $renewalContractSql-> getCellPhone();
$email_address = $renewalContractSql-> getEmailAddress();
$renewalContractSql-> setGroupName($group_name);
$renewalContractSql-> parseGroupInfo($group_info);
$group_info = $renewalContractSql-> getGroupTypeInfo();

$renewalContractSql-> loadBusinessInfo();
$business_name = $renewalContractSql-> getBusinessName();
$business_dba = $renewalContractSql-> getBusinessDba();

$renewalContractSql-> setProductListArray($product_list);
$renewalContractSql-> loadServices();
$summary_rows = $renewalContractSql-> getSummaryTableRows();
$summary_rows_email = $renewalContractSql-> getSummaryRowsEmail();

$renewalContractSql-> setRenewalFee($renewal_fee);
$renewalContractSql-> setServiceTotal($service_total);
$renewalContractSql-> setGrandTotal($grand_total);
$renewalContractSql-> setTodaysPayment($todays_payment);
$renewalContractSql-> setBalanceDue($balance_due);
$renewalContractSql-> setBalanceDueDate($balance_due_date);
$renewalContractSql-> loadInitialPayments();
$initial_payments = $renewalContractSql-> getInitialPayments();
$initial_payments_email = $renewalContractSql-> getInitPaymentsEmail();
$renewalContractSql-> loadContractTerms();
$contract_terms = $renewalContractSql-> getContractTerms();

$renewalContractSql-> loadContractLocation();
$contract_location = $renewalContractSql-> getContractLocation();
$emp_name = $renewalContractSql-> getEmpName();
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";

include "../templates/renewalContractTemplate.php";

$renewalSql-> setContractHtml($renewalTemplate);
$_SESSION['renewalSql'] = $renewalSql;
?>