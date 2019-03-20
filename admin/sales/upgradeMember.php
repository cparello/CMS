<?php
include "upgradeSql.php";
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}

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

$upgradeSql = $_SESSION['upgradeSql'];

//first see if the contract key is set. If not then exit with warning
$contract_key = $upgradeSql-> getContractKey();
if($contract_key == null) {
echo"System error. Please contact your administrator";
exit;
}

//cc info
$upgradeSql-> setCardType($card_type);
$upgradeSql-> setCardName($card_name);
$upgradeSql-> setCardNumber($card_number);
$upgradeSql-> setCardCvv($card_cvv);
$upgradeSql-> setCardExpDate($card_exp_date_array);

//banking info
$upgradeSql-> setBankName($bank_name);
$upgradeSql-> setAccountType($account_type);
$upgradeSql-> setAccountName($account_name);
$upgradeSql-> setAccountNumber($account_num);
$upgradeSql-> setAbaNumber($aba_num);

//set the initial payment type
$upgradeSql-> setCreditPayment($credit_pay);
$upgradeSql-> setAchPayment($ach_pay);
$upgradeSql-> setCashPayment($cash_pay);
$upgradeSql-> setCheckPayment($check_pay);

//if the check number is not set we set it if the check pay field is not null
if($check_pay != "") {
  $upgradeSql-> setCheckNumber($check_number);
  }

//set the monthly billing if exits
$upgradeSql-> setMonthlyBillingType($monthly_billing_selected);
$upgradeSql-> setOriginalMonthlyBillingType($original_billing_type);

//sets the overide pin if entered
$overide_pin = $_SESSION['overide_pin'];
  if($overide_pin == "") {
      $overide_pin = 'N';
     } 
$upgradeSql-> setOveridePin($overide_pin);

//set the commission credit for new services
$upgradeSql-> setNewCommissionCredit($commission_credit);  //is the email address needs to be parsed

//sets up the account status to current
$account_status = 'CU';
$upgradeSql-> setAccountStatus($account_status);

//set renewal to yes 
$renewal = 'N';
$upgrade = 'Y';
$internet = 'N';
$upgradeSql-> setRenewal($renewal);
$upgradeSql-> setUpgrade($upgrade);
$upgradeSql-> setInternet($internet);

//----------------------------------------------------------------------------
//save all of the info
           $upgradeSql-> updateBankingInfo();
           $upgradeSql-> updateCreditInfo();
//----------------------------------------------------------------------------
//if contact info is checked then update
if(isset($_POST['change_info']))  {

        //check the group info first
       $group_info = $upgradeSql-> getGroupInfoArray();
       if($group_info != 'NA') {
          $upgradeSql-> updateGroupInfo();
          }

        //now check if address info has been changed  
        $address_info = $upgradeSql-> getAddressInfoArray();
       if($address_info != 'NA') {
          $upgradeSql-> parseAddressInfo();
          }
                  
   }
//--------------------------------------------------------------------------
//sets the commision credit for the new services
 $upgradeSql->  setNewCommissionCredit($commission_credit);
 $upgradeSql-> parseComissionId();
//---------------------------------------------------------------------------
$upgradeSql-> saveContractInfo();
$upgradeSql-> saveNewServices();
$upgradeSql-> saveCurrentServices();
$upgradeSql-> saveMemberInfo();
$upgradeSql-> saveInitialPayments();

//this sets up monthly billing if a monthly service was selected
if($monthly_billing_selected != "")  {
       
       //check to see if this is a new monthly billing so we eaither upgrade or save as a new monthly payment
      $billingExists = $upgradeSql-> checkMonthlyBilling();
       If($billingExists == 0)  {
          $upgradeSql-> saveMonthlyBilling();
          }else{
          $upgradeSql-> updateMonthlyBilling();
          }
         
  }
//---------------------------------------------------------------------------
//sets up notes if a topic is present or subject
if($topic != "" &&  $message != "") {
   //set notes for this contract
   $note_user = $_SESSION['user_id'];
   $upgradeSql-> setNoteUser($note_user);
   $upgradeSql-> setNoteTopic($topic);
   $upgradeSql-> setNoteMessage($message);
   $upgradeSql-> setNotePriority($priority);
   $upgradeSql-> setTargetApp($target_app);
   $upgradeSql-> saveNote();
}


//deletes the current sql contract session
unset($_SESSION['upgradeSql']);
//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Selected service(s) for contract $contract_key successfully Upgraded";

//this reloads he search page using the contract key as a search pram
$contract_id = $contract_key;

//opens the sales form
include "searchMemberAccounts.php";

include "accountList.php";



?>