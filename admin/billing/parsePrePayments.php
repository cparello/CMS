<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

require "../cybersource/gatewayAuth.php";
require "../cybersource/cybersourceSoapClient.php";
require "../cybersource/parseGatewayFields.php";

$contract_key = $_SESSION['contract_key'];
$user_id = $_SESSION['user_id'];
$credit_pay = $_REQUEST['credit_pay'];
$ach_pay = $_REQUEST['ach_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$check_pay = $_REQUEST['check_pay'];
$check_number = $_REQUEST['check_number'];
$monthly_payment = $_REQUEST['monthly_payment'];
$prepay_restart_date = $_REQUEST['prepay_restart_date'];
$prepay_restart_date_rate = $_REQUEST['prepay_restart_date_rate'];
$prepay_restart_date_enhance = $_REQUEST['prepay_restart_date_enhance'];
$prepay_restart_date_m = $_REQUEST['prepay_restart_date_m'];
$num_months = $_REQUEST['num_months'];
$prepay_total = $_REQUEST['prepay_total'];
$prepay_total_rate = $_REQUEST['prepay_total_rate'];
$prepay_total_enhance = $_REQUEST['prepay_total_enhance'];
$prepay_total_maint = $_REQUEST['prepay_total_m'];
$key_list = $_REQUEST['key_list'];
$street_address = $_REQUEST['street_address'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$primary_phone = $_REQUEST['primary_phone'];
$email_address = $_REQUEST['email_address'];
$license_number = $_REQUEST['license_number'];
$card_number = $_REQUEST['card_number'];
$card_type = $_REQUEST['card_type'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_num = $_REQUEST['account_num'];
$aba_num = $_REQUEST['aba_num'];
$month_billing_type = $_REQUEST['month_billing_type'];


//get the cc info 
$credit_pay = trim($credit_pay);
//get banking info
$ach_pay = trim($ach_pay);
//get cash
$cash_pay = trim($cash_pay);
//get check
$check_pay = trim($check_pay);

include"savePrePayments.php";
$savePrepay = new savePrePayments;
$savePrepay-> setContractKey($contract_key);

//set the initial payment type
$savePrepay-> setCreditPayment($credit_pay);
$savePrepay-> setAchPayment($ach_pay);
$savePrepay-> setCashPayment($cash_pay);
$savePrepay-> setCheckPayment($check_pay);

if($check_pay != "") {
   $savePrepay-> setCheckNumber($check_number);
  }

//prepay variables
$savePrepay-> setMonthlyPayment($monthly_payment);
$prepay_restart_date = date("Ymd"  , strtotime($prepay_restart_date));
$savePrepay-> setPrepayRestartDate($prepay_restart_date);
$savePrepay-> setPrepayNumMonths($num_months);
$savePrepay-> setPrepayTotal($prepay_total);
$savePrepay-> setKeyList($key_list);

$savePrepay-> setPrepayRestartDateRate($prepay_restart_date_rate);
$savePrepay-> setPrepayRestartDateEnhance($prepay_restart_date_enhance);
$savePrepay-> setPrepayRestartDateMaint($prepay_restart_date_m);
$savePrepay-> setPrepayTotalRate($prepay_total_rate);
$savePrepay-> setPrepayTotalEnhance($prepay_total_enhance);
$savePrepay-> setPrepayTotalMaint($prepay_total_maint);

//account address info
$savePrepay-> setAccountStreet($street_address);
$savePrepay-> setAccountCity($city);
$savePrepay-> setAccountState($state);
$savePrepay-> setAccountZip($zip);
$savePrepay-> setAccountPhone($primary_phone);
$savePrepay-> setAccountEmail($email_address);
$savePrepay-> setAccountLicense($license_number);
$savePrepay-> loadBillingCycle();


//set CC varibles
$savePrepay-> cardNumber($card_number);
$savePrepay-> cardType($card_type);
$savePrepay-> cardName($card_name);
$savePrepay-> cardCVV($card_cvv);
$savePrepay-> cardMonth($card_month);
$savePrepay-> cardYear($card_year);

//set ACH varis
$savePrepay-> accountType($account_type);
$savePrepay-> accountName($account_name);
$savePrepay-> accountNumber($account_num);
$savePrepay-> routingNumber($aba_num);
$monthly_billing = $savePrepay-> setMonthlyBillingType($month_billing_type);
//include"prePaymentsSql.php";
//$prePaySQL = new prePaymentsSql;
//$prePaySQL->loadPaymentTypes();
//echo "fubar $prepay_restart_date";
//exit;

/*if ($monthly_billing = "CR"){
    $savePrepay->deleteSubscription();
    $savePrepay->alterCCSubscription();
}elseif ($monthly_billing == "BA"){
    $savePrepay->deleteSubscription();
    $savePrepay->alterACHSubscription();
}*/


/////////////////////////////////////////////////////////////////////
// Call and creat cs prepay functions here.   Use the savePrePayments Class
/////////////////////////////////////////////////////////////////////





//saves to monthly settled and prepayment tables
$savePrepay-> savePrePayment();

//for payment history
$payment_description = 'Monthly Service Prepaid';
$due_date = date("Y-m-d");
$savePrepay-> setDueDate($due_date);
$savePrepay-> setPaymentDescription($payment_description);
$savePrepay-> setTodaysPayment($prepay_total);
$savePrepay-> insertPaymentHistory();


$prepay_confirm = "confirmPrePay($contract_key);";
include"prePayments.php";


?>