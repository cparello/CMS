<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$contract_key = $_REQUEST['contract_key'];
$member_id = $_REQUEST['member_id'];
$whichBackBut = $_REQUEST['whichBackBut'];
//echo "<br>account info $whichBackBut";

unset($_SESSION['title_text']);
unset($_SESSION['item_text']);
unset($_SESSION['item_amount']);
unset($_SESSION['fee_text']);
unset($_SESSION['fee_amount']);
unset($_SESSION['total_amount']);
unset($_SESSION['contract_key_receipt']);
unset($_SESSION['payment_type']);
unset($_SESSION['payment_date']);
unset($_SESSION['business_name']);
unset($_SESSION['club_name']);
unset($_SESSION['club_address']);
unset($_SESSION['club_phone']);
unset($_SESSION['print_format']);



include"memberInfoThree.php";
$loadMembers = new memberInfoThree();
$loadMembers-> setContractKey($contract_key);
$loadMembers-> loadContactInfo();
$member_content = $loadMembers-> getMemberContent();


//getst the target dropdown for notes
$targetApp = 'assignment_member';
$target_app_id = 'MI';
$x_box = 1;
$mem_switch = 1;

include "../utilities/noteSql.php";
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();

//gets the contract header and the note form
include"../utilities/memberNotes.php";
$memberNotes = new memberNotes();
$memberNotes-> setXbox($x_box);
$memberNotes-> setMemSwitch($mem_switch);
$memberNotes-> setContractKey($contract_key);
$memberNotes-> loadContractHeader();
$memberNotes-> setTargetDrops($target_drops);
$memberNotes-> loadNoteForm(); 

//get the note list
$memberNotes-> setTargetAppId($target_app_id);
$memberNotes-> parseNoteStatus();
$memberNotes-> loadNoteList();
$account_notes_array = $memberNotes-> getNotePage();
$account_notes_array = explode("|", $account_notes_array);
$account_notes_one = $account_notes_array[0];
$account_note_count = $account_notes_array[1];
$account_note_count = trim($account_note_count);
$contract_key_notes = $contract_key;
//echo"$account_notes_one";
//exit;

include"loadAccountInfo.php";
$loadAccount = new loadAccountInfo();
$loadAccount-> setContractKey($contract_key);
$loadAccount-> loadAccount();
$holder_name = $loadAccount-> getHolderName();
$association = $loadAccount-> getAssociation();
$service_list = $loadAccount-> getServiceList();
$monthlyBool = $loadAccount-> getMonthlyServicesBool();
$monthlyBillingType = $loadAccount-> getMonthlyBillingType();
$monthlyPaymentAmount = $loadAccount-> getMonthlyPaymentAmount();
//echo "###$$#$$monthlyBillingType $monthlyPaymentAmount";
//compares the member with the contract holder in order to disable or enable payment options
$member_id = trim($member_id);
//echo"$member_id";
if($member_id != "") {
  $loadAccount-> setMemberId($member_id);
  $loadAccount-> loadPaymentAccess();
  $payment_access = $loadAccount-> getPaymentAccess();
  }else{
  $payment_access = 'Y';
  }
//echo "month bool $monthlyBool";
include "pastDueBalanceDue.php";
$parseDue = new  pastDueBalanceDue();
//$parseDue-> loadCycleDate();
$parseDue-> setContractKey($contract_key);
$parseDue-> loadCycleDate();
$parseDue-> loadRecordCount();
$past_due_monthly = $parseDue-> getPastDueTotal();


//exit;

$parseDue-> checkInitialPaymentBalanceDue();
$initial_payment_due = $parseDue-> getInitialPaymentBalanceDue();
$status_tag = $parseDue-> getStatusTag();
$parseDue-> checkNsfTransactions();
$nsf_check_payment = $parseDue-> getNsfCheckPayment();
$nsf_check_number =  $parseDue-> getNsfCheckNumber();

$parseDue-> checkDeclinedTransactions();
$declined_payment = $parseDue-> getDeclinedPayment();
$reason_description = $parseDue-> getReasonDescription();
$reason_code = $parseDue-> getReasonCode();

if ($monthlyBool == 0){
    $past_due_monthly = 0;
    $nsf_check_payment = 0;
    $declined_payment = 0;
}

$transaction_key = 'XX';
if($past_due_monthly > 0) {
  $account_status = "<span class=\"redOne\">HOLD: Account Past Due</span>";
  $late_fee = $parseDue-> getLateFee();
  $transaction_key = 'PD';
  }
  //echo "sdsds $status_tag bd $initial_payment_due bool $monthlyBool";
if($initial_payment_due > 0) {
   if($status_tag == 'P') {
      $account_status = "<span class=\"redOne\">HOLD: Initial Payment Balance Due</span>";
      }elseif($status_tag == 'G') {
      $account_status = "<span class=\"redOne\">Initial Payment Balance Due</span>";
      }
  $transaction_key = 'ID';
  }else{
    $initial_payment_due = 0;
  }  
if($nsf_check_payment > 0) {
  $account_status = "<span class=\"redOne\">HOLD: NSF Check Payment</span>";
  $nsf_fee = $parseDue-> getNsfFee();
  $transaction_key = 'IF';
  }    
if($declined_payment > 0) {  
  $trans_type = $parseDue-> getTransactionType();
  $trans_key = $parseDue-> getTransKey();
  $account_status = "<span class=\"redOne\">HOLD: Declined $trans_type Payment</span> <a href=\"javascript: void\" id=\"pos1\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"></a>";
  $reason_decline = "<input type=\"hidden\" id=\"reason_description\" name=\"reason_description\" value=\"$reason_description\"/>";
  //$javaScript12 = "<script type=\"text/javascript\" src=\"../scripts/helpPopsTwo.js\"></script>";  
  $pop_div = "
  <div class=\"popHint\"   id=\"popup\" style=\"display: none;\">
  <div class=\"menu_form_header\" id=\"popup_drag\">
  <img class=\"menu_form_exit\"   id=\"popup_exit\" src=\"../images/popx.png\" alt=\"\" />
  <span id= \"contHint\">
  </span>
  </div>
  </div>";  
  $rejection_fee = $parseDue-> getRejectionFee();
  $transaction_key = 'EF';
  }    
//echo"pdm $past_due_monthly ipd $initial_payment_due nsf $nsf_check_payment declined_payment $declined_payment  rd $reason_description";


include"accountPaymentForms.php";
$loadForm = new accountPaymentForms();
$loadForm-> setMonthlyServicesBool($monthlyBool);
$loadForm-> setContractKey($contract_key);
$loadForm-> setTransactionKey($transaction_key);
$loadForm-> setTransactionType($trans_type);
$loadForm-> setReasonCode($reason_code);
$loadForm-> setTransKey($trans_key);
$loadForm-> setLateFee($late_fee);
$loadForm-> setNsfFee($nsf_fee);
$loadForm-> setNsfCheckNumber($nsf_check_number);
$loadForm-> setRejectionFee($rejection_fee);
$loadForm-> setPastDueMonthly($past_due_monthly);
$loadForm-> setInitialPaymentDue($initial_payment_due);
$loadForm-> setNsfCheckPayment($nsf_check_payment);
$loadForm-> setDeclinedPayment($declined_payment);
$loadForm-> parsePaymentForm();
$payment_form = $loadForm-> getPaymentForm();
$styleSheet1 = "<link rel=\"stylesheet\" href=\"../css/accountInfoTwo.css\">";
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/billingPayments.js\"></script>";
if($initial_payment_due > 0) {
  $bp_available = 1;
      }else{
        $bp_available = $monthlyBool;
      }
//echo"$bp_available $transaction_key";
//$account_status = "See Services and Member Information Below";


//echo "$initial_payment_due == 0 && $past_due_monthly == 0 &&  $nsf_check_payment == 0 && $declined_payment == 0";
  /*PREPAYMENT HAS BEEN DISABLED FOR NOW CANT GET DIFF FORM TO OPEN INDEPENDANTLY*/
if($initial_payment_due == 0 && $past_due_monthly == 0 &&  $nsf_check_payment == 0 && $declined_payment == 0) {
   $account_status = "See Services and Member Information Below";
     
   include "prePaymentsSqlTwo.php";
   $loadRecords = new prePaymentsSqlTwo();
   $loadRecords-> setContractKey($contract_key);
   $loadRecords-> loadCommissionCredit();
   $loadRecords-> loadCurrentListings();
   $loadRecords-> loadPrePaymentDuration();
   $loadRecords-> createForm();
       
   
   $payment_form2 = $loadRecords-> getPrePayContent();    
   $styleSheet2 = $loadRecords-> getStyleSheet();
   //$javaScript14 = "<script type=\"text/javascript\" src=\"../scripts/checkPrePayTwo.js\"></script>";
   
   //checks to see if ther are no payment options
   /*if($payment_form == "") {
     $bp_available = 0;
     }else{
     $bp_available = 1;
     }*/
   
   $monthly_payment = $loadRecords-> getMonthlyPayment();
   $billing_date_array = $loadRecords-> getBillingDateArray();
   $key_list = $loadRecords-> getKeyList();  
   $payment_form2 = $loadRecords-> getPrePayContent();
   
   }
   
 //echo "pa $payment_access";
  
if($payment_access == 'Y') {
    $disabled = "";
   }else{
    $disabled =  'disabled = "disabled"';   
   }
  
if(isset($_SESSION['confirmation_message'])) {
    $confirmation_message = $_SESSION['confirmation_message'];
    unset($_SESSION['confirmation_message']); 
    }else{
    $confirmation_message = "";
    }
switch($monthlyBillingType){
    case 'CR':
        $mText = "Credit card";
    break;
    case 'CH':
    $mText = "Check";
    break;
    case 'CA':
    $mText = "Cash";
    break;
    case 'BA':
    $mText = "Bank Draft";
    break;
}
//echo "mba $monthlyPaymentAmount $monthlyBool";
if ($monthlyPaymentAmount != '' AND $monthlyBool != 0){
    $monthlyPaymentInfo = "<tr>
<td class=\"black tdHead\">
Monthly Payment Information
</td>
<td class=\"blackTwo\">
$$monthlyPaymentAmount billed by $mText.
</td>
</tr>";
}else{
    $monthlyPaymentInfo = "";
}


$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/showPaymentOptions.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/loadCamera.js\"></script>";
$javaScript5 = "<script type=\"text/javascript\" src=\"../scripts/showAccountNotes.js\"></script>";
$javaScript6 = "<script type=\"text/javascript\" src=\"../scripts/checkMembersTwo.js\"></script>";
$javaScript7 = "<script type=\"text/javascript\" src=\"../scripts/showHideMembers.js\"></script>";
$javaScript8 = "<script type=\"text/javascript\" src=\"../scripts/printReceiptOwed.js\"></script>";
$javaScript9 = "<script type=\"text/javascript\" src=\"../scripts/reloadAccount.js\"></script>";
$javaScript10 = "<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
$javaScript11 = "<script type=\"text/javascript\" src=\"../scripts/printMemberWaiver.js\"></script>";
$javaScript12 = "<script type=\"text/javascript\" src=\"../scripts/helpPopsTwo.js\"></script>";
$javascript13 = "<script type=\"text/javascript\" src=\"../scripts/showPrePayOptions.js\"></script>";
$javaScript14 = "<script type=\"text/javascript\" src=\"../scripts/checkPrePayTwov2.js\"></script>";
$javascript15 = "<script type=\"text/javascript\" src=\"../scripts/openAttendanceReport.js\"></script>";
$javascript16 = "<script type=\"text/javascript\" src=\"../scripts/goBackToListMember.js\"></script>";

include  "../templates/accountInfoTemplateTwo.php";


?>