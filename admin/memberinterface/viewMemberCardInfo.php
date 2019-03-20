<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$contract_key = $_REQUEST['contract_key'];
$member_id = $_REQUEST['member_id'];

include "memberCardInfo.php";
$cardInfo = new memberCardInfo();
$cardInfo-> setContractKey($contract_key);
$cardInfo-> setMemberId($member_id);
$cardInfo-> loadMemberCardHolder();
$card_holder_form = $cardInfo-> getCardHolderForm();
$payment_form = $cardInfo-> getPaymentForm();
$holder_script = $cardInfo-> getCardHolderScript();



//----------------------------------------------------------
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/$holder_script\"></script>";

if($payment_form != "") {
  $javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
  }else{
  $javaScript3 = "";
  }
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/printReceiptOwed2.js\"></script>";

include "../templates/memberCardTemplate.php";

?>