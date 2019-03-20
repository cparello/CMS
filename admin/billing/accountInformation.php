<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
if(isset($_REQUEST['rp_ckey'])){
     $contract_key = $_REQUEST['rp_ckey']; 
     $where_from = 1;
}elseif(isset($_REQUEST['rp_ckey2'])){
     $contract_key = $_REQUEST['rp_ckey2']; 
     $where_from = 3;
}elseif(isset($_REQUEST['rp_ckey3'])){
     $contract_key = $_REQUEST['rp_ckey3']; 
     $where_from = 4;
}elseif(isset($_REQUEST['rp_ckey4'])){
     $contract_key = $_REQUEST['rp_ckey4']; 
     $where_from = 5;
}elseif(isset($_REQUEST['rp_ckey5'])){
     $contract_key = $_REQUEST['rp_ckey5']; 
     $where_from = 6;
}elseif(isset($_REQUEST['rp_ckey6'])){
     $contract_key = $_REQUEST['rp_ckey6']; 
     $where_from = 7;
}else{
   $contract_key = $_SESSION['contract_key']; 
   $where_from = 2;
}
///echo "dfsd $contract_key";

$user_id = $_SESSION['user_id'];

include "accountInfoSql.php";


$loadRecords = new accountInfoSql();
$loadRecords-> setContractKey($contract_key);
$loadRecords-> loadAccountHolder();

//get the group info if available
$groupForm = $loadRecords-> getGroupForm();
$group_type = $loadRecords-> getGroupType();
$type_name_orig = $loadRecords-> getGroupName();

//get the account holder information
$name_disabled = $loadRecords-> getNameDisabled();
$disabled = 'disabled = "disabled"';
$first_name = $loadRecords-> getFirstName(); 
$middle_name = $loadRecords-> getMiddleName();
$last_name = $loadRecords-> getLastName();
$street_address = $loadRecords-> getStreetAddress();
$city = $loadRecords-> getCity();
$state_list = $loadRecords-> getStateList();
$state = $loadRecords-> getState();
$zip_code = $loadRecords-> getZipCode();
$primary_phone = $loadRecords-> getPrimaryPhone();
$cell_phone = $loadRecords-> getCellPhone();
$email_address = $loadRecords-> getEmailAddress();
$dob = $loadRecords-> getDob();
$lic_num = $loadRecords-> getLicenseNumber();
//echo "bool $corpBool";
$corp_flag = $loadRecords-> getCorpFlag();
$collections_flag = $loadRecords-> getCollectionsFlag();
//creates address array in case of contact info upgrade
$contact_list = "$first_name|$middle_name|$last_name|$street_address|$city|$state|$zip_code|$primary_phone|$cell_phone|$email_address|$dob|$lic_num";

//load the service records and price adjustments for members deleted
$loadRecords-> loadCurrentListings();
//$loadRecords-> createAvailableRefunds(); 

$service_summary = $loadRecords-> getServiceSummary();
$enhance_cycle = $loadRecords-> getEnhanceCycle();
$enhance_fee = $loadRecords-> getEnhanceFee();
$guarantee_cycle = $loadRecords-> getGuaranteeCycle();
$guarantee_fee = $loadRecords-> getGuaranteeFee();
$available_refunds = $loadRecords-> getAvailableRefunds();
$bundled_refunds = $loadRecords-> getBundledRefund();
$single_refunds = $loadRecords->getSingleRefund();
$partial_payment_refund = $loadRecords-> getPartialPaymentRefund();

//checks the name disabled field if it is true then we know this is a non tranferable account. If it is null it is transferable
if($name_disabled == "") {
   $first_name_orig = $first_name;
   $middle_name_orig = $middle_name;
   $last_name_orig = $last_name;
   $transfer_fee = $loadRecords-> getTransferFee();
   $transfer_bit = 1;
}else{
   $type_name_orig = "";
   $first_name_orig = "";
   $middle_name_orig = "";
   $last_name_orig = "";
   $transfer_bit = "";
   $transfer_fee = "";
}

//this sets up  a message if no refunds are available
if($bundled_refunds == "" && $single_refunds == "" && $available_refunds == "")  {
   $no_refund = "<tr><td colspan=\"5\" class=\"black2 tile2\">No Refunds Available</td></tr>"; 
   $disabled = null;
   $acc_flag = null;
   $group_refund = 0;
   }else{
   $no_refund = "";
   $refund_disable_keys = $loadRecords-> getDisabledKeyList();
   $refund_service_total = $loadRecords-> getRefundServiceTotal();
   //gets the check boxes for the payment fields if there is a refund available
   $refund_checkbox = $loadRecords->loadRefundCheckBoxes();
   $refund_summary = "<tr><td  class=\"black6 tile7\">Refund Summary: <input  name=\"refund_balance\" type=\"text\" id=\"refund_balance\" value=\"0.00\" size=\"7\" maxlength=\"8\" /></td>$refund_checkbox</tr>";    
   $invoice_bit = "<input type=\"hidden\" name=\"invoice_bit\"  id=\"invoice_bit\" value=\"\"/>";
   $javaScript14 = "<script type=\"text/javascript\" src=\"../scripts/printRefundInvoice.js\"></script>";
   $acc_flag = 1;
   $group_refund = 1;
   }

$cancelation_fee = $loadRecords-> getCancelationFee();
$hold_fee = $loadRecords-> getHoldFee();
$hold_grace = $loadRecords-> getHoldGrace();
$member_hold_fee = $loadRecords-> getMemberHoldFee();
$nsf_fee = $loadRecords-> getNsfFee();
$cc_reject_fee = $loadRecords->getCcRejectFee();
$late_fee = $loadRecords-> getLateFee();
$past_due_grace =  $loadRecords-> getPastDueGrace();
//$past_due_balance = $loadRecords-> getPastDueBalance();
$total_balance_due = $loadRecords-> getTotalBalanceDue();

//we check the monthly settled table to see if the account is past due
include "pastDueMonthly.php";
$testPastDue = new  pastDueMonthly();
$testPastDue-> setContractKey($contract_key);
$testPastDue-> loadRecordCount();
$past_due_balance = $testPastDue-> getPastDueTotal();

if($past_due_balance == 0) {
  $past_due_balance = "0.00";
  }
//$past_due_balance = "0.00";  
$total_balance_due =  $total_balance_due + $past_due_balance;
$total_balance_due = sprintf("%01.2f", $total_balance_due);
  
//we set the past due balance in case the account is past due  as well as a rejected payemnt
$loadRecords-> setPastDueBalance($past_due_balance);
$rejection_list = $loadRecords->loadRejectedPayments();

//since this class is in the sales system we need to set up a user id so the script wont bounce
//this gets the summary of current services
//$_SESSION['user_id'] = "666";
include "accountUpgradeList.php";
$loadSummaryRecords = new accountUpgradeList();
$loadSummaryRecords-> setContractKey($contract_key);
$loadSummaryRecords-> setCancelationFee($cancelation_fee);
$loadSummaryRecords-> setCancelFeeList($refund_disable_keys);
$loadSummaryRecords-> loadCurrentListings();
//echo "test";
$summary_records = $loadSummaryRecords-> getBillingListings();
$billing_field_count = $loadSummaryRecords-> getBillingFieldCount();
$group_price_array = $loadSummaryRecords-> getGroupPriceArray();
$cancel_balance = $loadSummaryRecords-> getCancelBalance();
$monthly_service_count = $loadSummaryRecords-> getMonthCount();
$service_count = $loadSummaryRecords-> getServiceCount();
$cancel_count = $loadSummaryRecords-> getCancelCount();
$key_list_billing = $loadSummaryRecords-> getKeyListBilling();
$group_number = $loadSummaryRecords-> getGroupNumber();
//unset($_SESSION['user_id']);
//echo "canc count $cancel_count";

//get the service credits if they exist
$loadRecords-> loadServiceCredits();
$service_credits = $loadRecords-> getServiceCredits();

//here we adjust the group numbers if a refund was requested
if($member_count != "")  {
   if($member_count != 0)  {
        if($group_number != $member_count) {
           $updateAccount-> setGroupNumber($group_number);
           $updateAccount-> setMemberCount($member_count);
           $updateAccount-> deleteContractMembers();
           }   
      }
 }

//get the group info member listings if available
$loadRecords-> setCancelBalance($cancel_balance);
$loadRecords-> setGroupRefund($group_refund);
$loadRecords-> setServiceCount($service_count);
$loadRecords-> setCancelCount($cancel_count);
$loadRecords-> loadMemberListings();
$group_listings = $loadRecords-> getGroupListings();


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
$current_monthly_payments = $loadRecords-> getMonthlyPayment();
$month_billing_type = $loadRecords-> getMonthlyBillingType();
$nextDueDate = $loadRecords-> getNextDueDate();
$pastDays = $loadRecords-> getPastDays();

function cc_masking($card_number) {
    return substr($card_number, 0, 4) . str_repeat("X", strlen($card_number) - 8) . substr($card_number, -4);
}
$month = date('m',strtotime($nextDueDate));
$day = date('d',strtotime($nextDueDate));
$year = date('Y',strtotime($nextDueDate));


$card_number_masked = cc_masking($card_number);
$account_number_masked = cc_masking($account_number);

if($corp_flag == 0){
    $corpBool = "Not Flagged!";
}else{
    $corpBool = "Flagged!";
}


if($collections_flag == 0){
    $collectionsBool = "Current!";
}else{
    $collectionsBool = "Collections!";
}



//echo"%%%%%%%%%%%%%%%%%%%%%%%%%  $current_monthly_payments";
//if the current monthly payments are null, set to zero for js scripts
if($current_monthly_payments == "" || $current_monthly_payments <= 0) {
     $current_monthly_payments = '0.00';
     $monthlyBillingStuff = "";
  }else{
    $monthlyBillingStuff = "&nbsp;<td align=\"left\" class=\"black spacer1\">
    Current Bill Date: &nbsp;
    </td>
    <td>
    <input type=\"text\" id=\"dateMonth\" size=\"1\" value=\"$month\" />&nbsp;<input type=\"text\" id=\"dateDay\" size=\"1\" value=\"$day\" disabled=\"disabled\"/>&nbsp;<input type=\"text\" id=\"dateYear\" size=\"2\" value=\"$year\" />&nbsp;<input id=\"changeDate\" name=\"changeDate\" value=\"Set Date\" pastDays=\"$pastDays\" fieldUser3=\"$user_id\" fieldCKey2=\"$contract_key\" class=\"button1\" type=\"submit\">
    </td>
    &nbsp;
    <td align=\"left\" class=\"black spacer1\">
    Billing Amount: &nbsp;
    </td>
    <td>
    <input type=\"text\" id=\"modBillAmount\" size=\"6\" value=\"$current_monthly_payments\" />&nbsp;<input id=\"changeBillAmount\" name=\"changeBillAmount\" value=\"Set Billing Amount\" fieldCKey3=\"$contract_key\" fieldUser2=\"$user_id\" class=\"button1\" type=\"submit\">
    </td>
    <td><input type=\"submit\" name=\"past\" id=\"past\" value=\"Print/Email Past Due Invoice\" class=\"button1\" fieldCKey5=\"$contract_key\"/></td>
    ";
  }
  $corpFlag = "<tr>
    <td align=\"left\" class=\"black spacer1\">
    Corporate Flag: &nbsp;
    </td>
    <td>
    <input type=\"text\" id=\"corpFlag\" size=\"10\" value=\"$corpBool\" />&nbsp;<input id=\"changeCorpFlag\" name=\"changeCorpFlag\" value=\"Set Corporate Flag\" fieldCKey4=\"$contract_key\" fieldUser4=\"$user_id\" class=\"button1\" type=\"submit\">
    </td>
    </tr>";
     $collections = "<tr>
    <td align=\"left\" class=\"black spacer1\">
    Collections Status: &nbsp;
    </td>
    <td>
    <input type=\"text\" id=\"collections\" size=\"10\" value=\"$collectionsBool\" />&nbsp;<input id=\"changeCollectionsFlag\" name=\"changeCollectionsFlag\" value=\"Set Collections Flag\" fieldCKey6=\"$contract_key\" fieldUser6=\"$user_id\" class=\"button1\" type=\"submit\">
    </td>
    </tr>";

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

//this sets the last day of the month for contract refund use
$daysInMonth = date("t");
$dayOfMonth = date("j");
if($daysInMonth == $dayOfMonth) {
  $last_day = 1;
  }else{
  $last_day = "";
  }
  
if ($_SESSION['canceled_services'])  {
    $canceled_service_list = $_SESSION['canceled_services'];
    $list = explode('@',$canceled_service_list);
    foreach($list as $cancedService){
        $serviceDetails = explode(',',$cancedService);
        $key = $serviceDetails[0];
        $name = $serviceDetails[1];
        $userId = $serviceDetails[1];
        $key = trim($key);
        if($key !=""){
            $reactivateServiceList .= "<input id=\"reactivate\" name=\"reactivate\" value=\"$name\" fieldKey=\"$key\" fieldCKey=\"$contract_key\" fieldUser=\"$userId\" class=\"button1\" type=\"submit\">&nbsp;&nbsp;&nbsp;";
   
        }
         }
}

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/setMonthlyBilling.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/showDiv2.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/showDiv3.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/accountInfo_v1.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/checkBillingFields_v2.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/openContract.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/checkMembers.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/memberNotes.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/showNotes.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/sortCols.js\"></script>";
//$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/jquery.livequery.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/setPayHistoryVoidRecord.js\"></script>";
$javaScript16 ="<script type=\"text/javascript\" src=\"../scripts/openAttendanceReport2.js\"></script>";
$javaScript17 ="<script type=\"text/javascript\" src=\"../scripts/goBackToList_v1.js\"></script>";
$javaScript18 ="<script type=\"text/javascript\" src=\"../scripts/reactivateService.js\"></script>";
$javaScript19 ="<script type=\"text/javascript\" src=\"../scripts/changeNextDueDate.js\"></script>";
$javaScript20 ="<script type=\"text/javascript\" src=\"../scripts/showEmailPastDueInvoice.js\"></script>";
$javaScript21 ="<script type=\"text/javascript\" src=\"../scripts/updateContactPrefs.js\"></script>";
$javaScript22 ="<script type=\"text/javascript\" src=\"../scripts/changeLocations_v1.js\"></script>";
//echo "test $nextDueDate";
include "../templates/accountInfoTemplate.php";

?>