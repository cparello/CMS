<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "prePaymentsSql.php";

$contract_key = $_SESSION['contract_key'];

$loadRecords = new prePaymentsSql();
$loadRecords-> setContractKey($contract_key);
$loadRecords-> loadAccountHolder();
$account_info = $loadRecords-> getAccountInfo();
$loadRecords-> loadCurrentListings();
$current_services = $loadRecords-> getCurrentServices();
$loadRecords-> loadPrePaymentDuration();
$pre_pay_form = $loadRecords-> getPrepayForm();
$monthly_payment = $loadRecords-> getMonthlyPayment();
$billing_date_array = $loadRecords-> getBillingDateArray();
$key_list = $loadRecords-> getKeyList();
$loadRecords-> loadGuarentee();
$rate_date_array = $loadRecords-> getRateDateArray();
$prepay_rate_form = $loadRecords-> getPrePayFormRate();
$rate_fee = $loadRecords-> getRatefee();
$loadRecords-> loadEnhance();
$enhance_date_array = $loadRecords-> getEnhanceDateArray();
$prepay_enhance_form = $loadRecords-> getPrePayFormEnhance();
$enhance_fee = $loadRecords-> getEnhancefee();
$loadRecords-> loadMaint();
$m_date_array = $loadRecords-> getMDateArray();
$prepay_m_form = $loadRecords-> getPrePayFormM();
$m_fee = $loadRecords-> getMfee();
$pastFlag = $loadRecords-> getPastDueFlag();

//get personal info
$street_address = $loadRecords-> getStreetAddress();
$city = $loadRecords-> getCity();
$state = $loadRecords-> getState();
$zip = $loadRecords-> getZipCode();
$primary_phone = $loadRecords-> getPrimaryPhone();
$license_number = $loadRecords-> getLicenseNumber();
$email_address = $loadRecords-> getEmailAddress();
//echo "fubar";

 //get banking and cc info 
$bank_name = $loadRecords-> getBankName();
$account_type = $loadRecords-> getAccountType();
$account_name = $loadRecords-> getAccountName();
$account_number = $loadRecords-> getAccountNumber();
$routing_number = $loadRecords-> getRoutingNumber();
$card_name = $loadRecords-> getCardName();
$card_type = $loadRecords-> getCardType();
$card_number = $loadRecords-> getCardNumber();
$card_cvv = $loadRecords-> getCardCvv();
$card_exp_date = $loadRecords-> getCardExpDate();
$current_monthly_payments = $loadRecords-> getMonthlyPayments();
$monthly_billing_type = $loadRecords-> getMonthlyBillingType();
$group_type = $loadRecords-> getGroupType();


function cc_masking($card_number) {
    return substr($card_number, 0, 4) . str_repeat("X", strlen($card_number) - 8) . substr($card_number, -4);
}


$card_number_masked = cc_masking($card_number);

$account_number_masked = cc_masking($account_number);

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






//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(30);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtManual.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/checkPrePayv2.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/goBackToList.js\"></script>";

include "../templates/infoTemplate2.php";
include "../templates/prePaymentsTemplate.php";

?>