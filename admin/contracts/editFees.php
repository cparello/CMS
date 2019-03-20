<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$process_fee_single = $_REQUEST['process_fee_single'];
$process_fee_family = $_REQUEST['process_fee_family'];
$process_fee_business = $_REQUEST['process_fee_business'];
$process_fee_organization = $_REQUEST['process_fee_organization'];
$process_fee_single2 = $_REQUEST['process_fee_single2'];
$process_fee_family2 = $_REQUEST['process_fee_family2'];
$process_fee_business2  = $_REQUEST['process_fee_business2'];
$process_fee_organization2  = $_REQUEST['process_fee_organization2'];
$upgrade_fee_single = $_REQUEST['upgrade_fee_single'];
$upgrade_fee_family  = $_REQUEST['upgrade_fee_family'];
$upgrade_fee_business = $_REQUEST['upgrade_fee_business'];
$upgrade_fee_organization  = $_REQUEST['upgrade_fee_organization'];
$upgrade_fee_single2 = $_REQUEST['upgrade_fee_single2'];
$upgrade_fee_family2 = $_REQUEST['upgrade_fee_family2'];
$upgrade_fee_business2 = $_REQUEST['upgrade_fee_business2'];
$upgrade_fee_organization2  = $_REQUEST['upgrade_fee_organization2'];
$renewal_fee_single = $_REQUEST['renewal_fee_single'];
$renewal_fee_family  = $_REQUEST['renewal_fee_family'];
$renewal_fee_business = $_REQUEST['renewal_fee_business'];
$renewal_fee_organization = $_REQUEST[''];
$renewal_fee_single2 = $_REQUEST['renewal_fee_organization'];
$renewal_fee_family2 = $_REQUEST['renewal_fee_family2'];
$renewal_fee_business2  = $_REQUEST['renewal_fee_business2'];
$renewal_fee_organization2 = $_REQUEST['renewal_fee_organization2'];
$transfer_fee = $_REQUEST['transfer_fee'];
$cancel_fee = $_REQUEST['cancel_fee'];
$hold_fee = $_REQUEST['hold_fee'];
$member_hold_fee = $_REQUEST['member_hold_fee'];
$enhance_fee = $_REQUEST['enhance_fee'];
$rejection_fee = $_REQUEST['rejection_fee'];
$nsf_fee = $_REQUEST['nsf_fee'];
$renewal_percent = $_REQUEST['renewal_percent'];
$early_renewal_percent = $_REQUEST['early_renewal_percent'];
$early_renewal_grace = $_REQUEST['early_renewal_grace'];
$standard_renewal_grace = $_REQUEST['standard_renewal_grace'];
$past_due_grace = $_REQUEST['past_due_grace'];
$hold_grace  = $_REQUEST['hold_grace'];
$class_percent = $_REQUEST['class_percent']; 
$late_fee = $_REQUEST['late_fee'];
$card_fee = $_REQUEST['card_fee'];
$rate_fee = $_REQUEST['rate_fee'];
$maintnence_fee = $_REQUEST['maintnence_fee'];

include "feesSql.php";

$process_fee_single = trim($process_fee_single);
$process_fee_family = trim($process_fee_family);
$process_fee_business = trim($process_fee_business);
$process_fee_organization = trim($process_fee_organization);
$process_fee_single2 = trim($process_fee_single2);
$process_fee_family2 = trim($process_fee_family2);
$process_fee_business2 = trim($process_fee_business2);
$process_fee_organization2 = trim($process_fee_organization2);
$upgrade_fee_single = trim($upgrade_fee_single);
$upgrade_fee_family = trim($upgrade_fee_family);
$upgrade_fee_business = trim($upgrade_fee_business);
$upgrade_fee_organization = trim($upgrade_fee_organization);
$upgrade_fee_single2 = trim($upgrade_fee_single2);
$upgrade_fee_family2 = trim($upgrade_fee_family2);
$upgrade_fee_business2 = trim($upgrade_fee_business2);
$upgrade_fee_organization2 = trim($upgrade_fee_organization2);
$renewal_fee_single = trim($renewal_fee_single);
$renewal_fee_family = trim($renewal_fee_family);
$renewal_fee_business = trim($renewal_fee_business);
$renewal_fee_organization = trim($renewal_fee_organization);
$renewal_fee_single2 = trim($renewal_fee_single2);
$renewal_fee_family2 = trim($renewal_fee_family2);
$renewal_fee_business2 = trim($renewal_fee_business2);
$renewal_fee_organization2 = trim($renewal_fee_organization2);

$transfer_fee = trim($transfer_fee);
$cancel_fee = trim($cancel_fee);
$hold_fee = trim($hold_fee); 
$member_hold_fee = trim($member_hold_fee);
$enhance_fee = trim($enhance_fee);
$rejection_fee = trim($rejection_fee);
$nsf_fee = trim($nsf_fee);
$renewal_percent = trim($renewal_percent);
$early_renewal_percent = trim($early_renewal_percent);
$early_renewal_grace = trim($early_renewal_grace);
$standard_renewal_grace= trim($standard_renewal_grace);
$past_due_grace= trim($past_due_grace);
$hold_grace = trim($hold_grace);
$class_percent = trim($class_percent);

$late_fee = trim($late_fee);
$card_fee = trim($card_fee);
$rate_fee = trim($rate_fee);
$maintnence_fee = trim($maintnence_fee);

$process_fee_single = preg_replace("/[^0-9 .]+/", "" ,$process_fee_single);
$process_fee_family = preg_replace("/[^0-9 .]+/", "" ,$process_fee_family);
$process_fee_business = preg_replace("/[^0-9 .]+/", "" ,$process_fee_business);
$process_fee_organization = preg_replace("/[^0-9 .]+/", "" ,$process_fee_organization);
$process_fee_single2 = preg_replace("/[^0-9 .]+/", "" ,$process_fee_single2);
$process_fee_family2 = preg_replace("/[^0-9 .]+/", "" ,$process_fee_family2);
$process_fee_business2 = preg_replace("/[^0-9 .]+/", "" ,$process_fee_business2);
$process_fee_organization2 = preg_replace("/[^0-9 .]+/", "" ,$process_fee_organization2);
$upgrade_fee_single = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_single);
$upgrade_fee_family = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_family);
$upgrade_fee_business = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_business);
$upgrade_fee_organization = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_organization);
$upgrade_fee_single2 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_single2);
$upgrade_fee_family2 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_family2);
$upgrade_fee_business2 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_business2);
$upgrade_fee_organization2 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_organization2);
$upgrade_fee_single3 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_single3);
$upgrade_fee_family3 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_family3);
$upgrade_fee_business3 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_business3);
$upgrade_fee_organization3 = preg_replace("/[^0-9 .]+/", "" ,$upgrade_fee_organization3);
$renewal_fee_single = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_single);
$renewal_fee_family = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_family);
$renewal_fee_business = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_business);
$renewal_fee_organization = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_organization);
$renewal_fee_single2 = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_single2);
$renewal_fee_family2 = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_family2);
$renewal_fee_business2 = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_business2);
$renewal_fee_organization2 = preg_replace("/[^0-9 .]+/", "" ,$renewal_fee_organization2);
$cancel_fee = preg_replace("/[^0-9 .]+/", "" ,$cancel_fee);
$hold_fee = preg_replace("/[^0-9 .]+/", "" ,$hold_fee);
$member_hold_fee = preg_replace("/[^0-9 .]+/", "" ,$member_hold_fee);
$enhance_fee = preg_replace("/[^0-9 .]+/", "" ,$enhance_fee);
$rejection_fee = preg_replace("/[^0-9 .]+/", "" ,$rejection_fee);
$nsf_fee = preg_replace("/[^0-9 .]+/", "" ,$nsf_fee);
$renewal_percent = preg_replace("/[^0-9 .]+/", "" ,$renewal_percent);
$early_renewal_percent = preg_replace("/[^0-9 .]+/", "" ,$early_renewal_percent);
$early_renewal_grace = preg_replace("/[^0-9 .]+/", "" ,$early_renewal_grace);
$standard_renewal_grace =  preg_replace("/[^0-9 .]+/", "" ,$standard_renewal_grace);
$past_due_grace =  preg_replace("/[^0-9 .]+/", "" ,$past_due_grace);
$hold_grace =  preg_replace("/[^0-9 .]+/", "" ,$hold_grace);
$class_percent = preg_replace("/[^0-9 .]+/", "" ,$class_percent);
$late_fee =  preg_replace("/[^0-9 .]+/", "" ,$late_fee);
$card_fee =  preg_replace("/[^0-9 .]+/", "" ,$card_fee);
$rate_fee =  preg_replace("/[^0-9 .]+/", "" ,$rate_fee);
$transfer_fee = preg_replace("/[^0-9 .]+/", "" ,$transfer_fee);
$maintnence_fee = preg_replace("/[^0-9 .]+/", "" ,$maintnence_fee);
//echo"$renewal_percent";
//exit;

//sets up the varibles for the form template
$submit_link = 'editFees.php';
$submit_name = 'update';
$submit_title = "Update Grace Periods/Fees/Rates";
$page_title  = 'Edit Grace Periods/Fees/Rates';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/fees.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtFees.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


$file_permissions = "";
//$javaScript1 = "<script type=\"text/javascript\" src=\"scripts/fees.js\"></script>";
//$info_text
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

//if form is submitted save to database
if ($marker == 1) {
$updateFees = new feesSql();
$updateFees -> setProcessFeeSingle($process_fee_single);
$updateFees -> setProcessFeeFamily($process_fee_family);
$updateFees -> setProcessFeeBusiness($process_fee_business);
$updateFees -> setProcessFeeOrganization($process_fee_organization);

$updateFees -> setProcessFeeSingle2($process_fee_single2);
$updateFees -> setProcessFeeFamily2($process_fee_family2);
$updateFees -> setProcessFeeBusiness2($process_fee_business2);
$updateFees -> setProcessFeeOrganization2($process_fee_organization2);


$updateFees -> setUpgradeFeeSingle($upgrade_fee_single);
$updateFees -> setUpgradeFeeFamily($upgrade_fee_family);
$updateFees -> setUpgradeFeeBusiness($upgrade_fee_business);
$updateFees -> setUpgradeFeeOrganization($upgrade_fee_organization);

$updateFees -> setUpgradeFeeSingle2($upgrade_fee_single2);
$updateFees -> setUpgradeFeeFamily2($upgrade_fee_family2);
$updateFees -> setUpgradeFeeBusiness2($upgrade_fee_business2);
$updateFees -> setUpgradeFeeOrganization2($upgrade_fee_organization2);


//here we set the add member fee to zero for single members
$upgrade_fee_single3 = 0;
$updateFees -> setUpgradeFeeSingle3($upgrade_fee_single3);
$updateFees -> setUpgradeFeeFamily3($upgrade_fee_family3);
$updateFees -> setUpgradeFeeBusiness3($upgrade_fee_business3);
$updateFees -> setUpgradeFeeOrganization3($upgrade_fee_organization3);


$updateFees -> setRenewalFeeSingle($renewal_fee_single);
$updateFees -> setRenewalFeeFamily($renewal_fee_family);
$updateFees -> setRenewalFeeBusiness($renewal_fee_business);
$updateFees -> setRenewalFeeOrganization($renewal_fee_organization);

$updateFees -> setRenewalFeeSingle2($renewal_fee_single2);
$updateFees -> setRenewalFeeFamily2($renewal_fee_family2);
$updateFees -> setRenewalFeeBusiness2($renewal_fee_business2);
$updateFees -> setRenewalFeeOrganization2($renewal_fee_organization2);

$updateFees -> setCancelFee($cancel_fee);
$updateFees -> setHoldFee($hold_fee);
$updateFees -> setMemberHoldFee($member_hold_fee);
$updateFees -> setEnhanceFee($enhance_fee);
$updateFees -> setRejectionFee($rejection_fee);
$updateFees -> setNsfFee($nsf_fee);
$updateFees -> setRenewalPercent($renewal_percent);
$updateFees -> setEarlyRenewalPercent($early_renewal_percent);
$updateFees -> setEarlyRenewalGrace($early_renewal_grace);
$updateFees -> setStandardRenewalGrace($standard_renewal_grace);
$updateFees -> setPastDueGrace($past_due_grace);
$updateFees -> setHoldGrace($hold_grace);
$updateFees -> setClassPercent($class_percent);

$updateFees -> setLateFee($late_fee);
$updateFees -> setCardFee($card_fee);
$updateFees -> setRateFee($rate_fee);
$updateFees -> setTransferFee($transfer_fee);
$updateFees -> setMaintnenceFee($maintnence_fee);

$confirmation = $updateFees -> updateFees();
}


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


$upgrade_fee_single = $loadFees -> getUpgradeFeeSingle();
$upgrade_fee_family = $loadFees -> getUpgradeFeeFamily();
$upgrade_fee_business = $loadFees -> getUpgradeFeeBusiness();
$upgrade_fee_organization = $loadFees -> getUpgradeFeeOrganization();

$upgrade_fee_single2 = $loadFees -> getUpgradeFeeSingle2();
$upgrade_fee_family2 = $loadFees -> getUpgradeFeeFamily2();
$upgrade_fee_business2 = $loadFees -> getUpgradeFeeBusiness2();
$upgrade_fee_organization2 = $loadFees -> getUpgradeFeeOrganization2();

$upgrade_fee_single3 = $loadFees -> getUpgradeFeeSingle3();
$upgrade_fee_family3 = $loadFees -> getUpgradeFeeFamily3();
$upgrade_fee_business3 = $loadFees -> getUpgradeFeeBusiness3();
$upgrade_fee_organization3 = $loadFees -> getUpgradeFeeOrganization3();

$renewal_fee_single = $loadFees -> getRenewalFeeSingle();
$renewal_fee_family = $loadFees -> getRenewalFeeFamily();
$renewal_fee_business = $loadFees -> getRenewalFeeBusiness();
$renewal_fee_organization = $loadFees -> getRenewalFeeOrganization();

$renewal_fee_single2 = $loadFees -> getRenewalFeeSingle2();
$renewal_fee_family2 = $loadFees -> getRenewalFeeFamily2();
$renewal_fee_business2 = $loadFees -> getRenewalFeeBusiness2();
$renewal_fee_organization2 = $loadFees -> getRenewalFeeOrganization2();


$cancel_fee = $loadFees -> getCancelFee();
$hold_fee = $loadFees -> getHoldFee();
$member_hold_fee = $loadFees -> getMemberHoldFee();
$enhance_fee = $loadFees -> getEnhanceFee();
$rejection_fee = $loadFees -> getRejectionFee();
$nsf_fee = $loadFees -> getNsfFee();
$renewal_percent = $loadFees -> getRenewalPercent();
$early_renewal_percent = $loadFees -> getEarlyRenewalPercent();
$eary_renewal_grace = $loadFees -> getEarlyRenewalGrace();
$standard_renewal_grace = $loadFees -> getStandardRenewalGrace();
$past_due_grace = $loadFees -> getPastDueGrace();
$hold_grace = $loadFees -> getHoldGrace();
$class_percent = $loadFees -> getClassPercent();

$late_fee = $loadFees -> getLateFee();
$card_fee = $loadFees -> getCardFee();
$rate_fee = $loadFees -> getRateFee();
$transfer_fee = $loadFees -> getTransferFee();
$maintnence_fee = $loadFees -> getMaintnenceFee();

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(20);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/feesTemplate2.php";




?>
