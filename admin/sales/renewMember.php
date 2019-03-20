<?php
include "renewalSql.php";
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
//chop the group type since it is a word
$group_type = substr($group_type, 0, 1);

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
$renewalSql = $_SESSION['renewalSql'];

//first see if the contract key is set. If not then exit with warning
$contract_key = $renewalSql-> getContractKey();
if($contract_key == null) {
echo"System error. Please contact your administrator";
exit;
}

//cc info
$renewalSql-> setCardType($card_type);
$renewalSql-> setCardName($card_name);
$renewalSql-> setCardNumber($card_number);
$renewalSql-> setCardCvv($card_cvv);
$renewalSql-> setCardExpDate($card_exp_date_array);

//banking info
$renewalSql-> setBankName($bank_name);
$renewalSql-> setAccountType($account_type);
$renewalSql-> setAccountName($account_name);
$renewalSql-> setAccountNumber($account_num);
$renewalSql-> setAbaNumber($aba_num);

//set the initial payment type
$renewalSql-> setCreditPayment($credit_pay);
$renewalSql-> setAchPayment($ach_pay);
$renewalSql-> setCashPayment($cash_pay);
$renewalSql-> setCheckPayment($check_pay);

//if the check number is not set we set it if the check pay field is not null
if($check_pay != "") {
  $renewalSql-> setCheckNumber($check_number);
  }

//sets the overide pin if entered
$overide_pin = $_SESSION['overide_pin'];
  if($overide_pin == "") {
      $overide_status = 'N';
     }      
$renewalSql-> setOveridePin($overide_pin);

//sets up the account status to current
$account_status = 'CU';
$renewalSql-> setAccountStatus($account_status);

//set renewal to yes 
$renewal = 'Y';
$upgrade = 'N';
$internet = 'N';
$renewalSql-> setRenewal($renewal);
$renewalSql-> setUpgrade($upgrade);
$renewalSql-> setInternet($internet);

$renewalSql-> setGroupType($group_type);

//----------------------------------------------------------------------------
//save all of the info
$renewalSql-> updateBankingInfo();
$renewalSql-> updateCreditInfo();
//----------------------------------------------------------------------------
//if contact info is checked then update
if(isset($_POST['change_info']))  {

        //check the group info first
       $group_info = $renewalSql-> getGroupInfo();
       if($group_info != 'NA') {
          $renewalSql-> updateGroupInfo();
          }

        //now check if address info has been changed  
        $address_info = $renewalSql-> getAddressInfo();
       if($address_info != 'NA') {
          $renewalSql-> parseAddressInfo();
          }
                  
   }
//---------------------------------------------------------------------------
//now we create the new amended upgrade contract
$renewalSql-> saveContractInfo();
$renewalSql-> saveServices();
$renewalSql-> saveInitialPayments();
//---------------------------------------------------------------------------

//sets up notes if a topic is present or subject
if($topic != "" &&  $message != "") {
   //set notes for this contract
   $note_user = $_SESSION['user_id'];
   $renewalSql-> setNoteUser($note_user);
   $renewalSql-> setNoteTopic($topic);
   $renewalSql-> setNoteMessage($message);
   $renewalSql-> setNotePriority($priority);   
   $renewalSql-> setTargetApp($target_app);
   $renewalSql-> saveNote();
}


//deletes the current sql contract session
unset($_SESSION['renewalSql']);
//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Selected service(s) for contract $contract_key successfully renewed";

//this reloads he search page using the contract key as a search pram
$contract_id = $contract_key;

//opens the sales form
include "searchMemberAccounts.php";

include "accountList.php";


//exit;

?>