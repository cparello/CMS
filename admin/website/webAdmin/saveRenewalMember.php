<?php
include "renewalSalesSql.php";
session_start();

$number_new_memberships = $_REQUEST['number_new_memberships'];
$card_type = $_REQUEST['card_type'];
$card_name = $_REQUEST['card_name'];
$card_number = $_REQUEST['card_number'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$credit_pay = $_REQUEST['credit_pay'];
$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_num = $_REQUEST['account_num'];
$aba_num = $_REQUEST['aba_num'];
$ach_pay = $_REQUEST['ach_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$check_pay = $_REQUEST['check_pay'];
$topic = $_REQUEST['topic'];
$message = $_REQUEST['message'];
$check_number = $_REQUEST['check_number'];
$monthly_billing_selected = $_REQUEST['monthly_billing_selected'];
$commission_credit = $_REQUEST['commission_credit'];
$member_info_array = $_REQUEST['member_info_array'];
$emg_info_array = $_REQUEST['emg_info_array'];
$note_user = $_REQUEST['note_user'];
$topic = $_REQUEST['topic'];
$message = $_REQUEST['message'];
$priority = $_REQUEST['priority'];
$target_app = $_REQUEST['target_app'];

//get the cc info 
$card_type = trim($card_type);
$card_name = trim($card_name);
$card_number = trim($card_number);
//replace anything that is not a number
$card_number = preg_replace("/[^0-9 .]+/", "" ,$card_number);
$card_cvv = trim($card_cvv);
$card_month = trim($card_month);
$card_year = trim($card_year);
$credit_pay = trim($credit_pay);
//create an experation date array for later division
$card_exp_date_array ="$card_year $card_month";

//get banking info
$bank_name = trim($bank_name);
$account_type = trim($account_type);
$account_name = trim($account_name);
$account_num = trim($account_num);
$aba_num = trim($aba_num);
$ach_pay = trim($ach_pay);

//get cash
$cash_pay = trim($cash_pay);
//get check
$check_pay = trim($check_pay);

//for notes
$topic = trim($topic);
$message = trim($message);


//overide_pin  set to Y if set N if not
//print_r($_POST);
//echo"$monthly_billing_selected<br><br>$member_info_array<br><br>$emg_info_array";
//exit;
$salesSql = $_SESSION['salesSql'];

//first see if the contract key is set. If not then exit with warning
$contract_key = $salesSql-> getContractKey();
if($contract_key == null) {
echo"System error. Please contact your administrator";
exit;
}

if(!isset($_SESSION['userContractKey'])){
//cc info
$salesSql-> setCardType($card_type);
$salesSql-> setCardName($card_name);
$salesSql-> setCardNumber($card_number);
$salesSql-> setCardCvv($card_cvv);
$salesSql-> setCardExpDate($card_exp_date_array);

//banking info
$salesSql-> setBankName($bank_name);
$salesSql-> setAccountType($account_type);
$salesSql-> setAccountName($account_name);
$salesSql-> setAccountNumber($account_num);
$salesSql-> setAbaNumber($aba_num);

//set the initial payment type
$salesSql-> setCreditPayment($credit_pay);
$salesSql-> setAchPayment($ach_pay);
$salesSql-> setCashPayment($cash_pay);
$salesSql-> setCheckPayment($check_pay);

//if the check number is not set we set it if the check pay field is not null
if($check_pay != "") {
  $salesSql-> setCheckNumber($check_number);
  }

//set the monthly billing
$salesSql-> setMonthlyBilling($monthly_billing_selected);

//sets the overide pin if entered
$overide_pin = "";
  if($overide_pin == "") {
      $overide_status = 'N';
     } 
$salesSql-> setOveridePin($overide_pin);

//set the commission credit
$salesSql-> setCommissionCredit($commission_credit);  //is the email address needs to be parsed

//sets up all of the member info not the contract info plus the emergancy contact info
$salesSql-> setMemberInfoArray($member_info_array);
$salesSql-> setEmgContactArray($emg_info_array);

//sets up the account status to current
$account_status = 'CU';
$salesSql-> setAccountStatus($account_status);

//set renewal to no since this is for saving initial sales
$renewal = 'N';
$upgrade = 'N';
$internet = 'N';
$salesSql-> setRenewal($renewal);
$salesSql-> setUpgrade($upgrade);
$salesSql-> setInternet($internet);

//save all of the info
$salesSql-> saveBankingInfo();
$salesSql-> saveCreditInfo();
$salesSql-> saveGroupInfo();
$salesSql-> saveContractInfo();
$salesSql-> saveMemberInfo();
$salesSql-> saveServices();
$salesSql-> saveInitialPayments();


//this sets up monthly billing if a monthly service was selected
if($monthly_billing_selected != "")  {
   $salesSql-> saveMonthlyBilling();
  }

//sets up notes if a topic is present or subject
if($topic != "" &&  $message != "") {
   //set notes for this contract
   $note_user = $_SESSION['user_id'];
   $salesSql-> setNoteUser($note_user);
   $salesSql-> setNoteTopic($topic);
   $salesSql-> setNoteMessage($message);
   $salesSql-> setNotePriority($priority);
   $salesSql-> setTargetApp($target_app);
   $salesSql-> saveNote();
   
}
echo "test";
}

//deletes the current sql contract session
unset($_SESSION['salesSql']);
//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Contract $contract_key Successfully Saved";

//opens the sales form
//include "salesForm.php";

exit;

?>