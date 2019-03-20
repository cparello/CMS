<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$merchant_id = $_REQUEST['merchant_id'];
$marker = $_REQUEST['marker'];
$account_mode = $_REQUEST['account_mode'];
$cs_user_name = $_REQUEST['cs_user_name'];
$cs_password = $_REQUEST['cs_password'];
$settle_mode = $_REQUEST['settle_mode'];

include "merchantSql.php";

$merchant_id = trim($merchant_id);


//sets up the varibles for the form template
$submit_link = 'editMerchantId.php';
$submit_name = 'update';
$submit_title = "Update Options";
$page_title  = 'Edit CyberSource&#0174 Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/merchantId.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPins.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



//if form is submitted save to database
if ($marker == 1) {
$updateInfo = new merchantSql();
$updateInfo-> setMerchantId($merchant_id);
$updateInfo-> setAccountMode($account_mode);
$confirmation = $updateInfo-> updateProcessorOptions();
}

if ($marker == 2) {
$updateInfo = new merchantSql();
$updateInfo-> setCsUserName($cs_user_name);
$updateInfo-> setCsPassword($cs_password);
$updateInfo-> setSettleMode($settle_mode);
$confirmation = $updateInfo-> updateSettlementOptions();
}


//load the form content
$loadInfo = new merchantSql();
$loadInfo-> loadMerchantOptions();
$merchant_id = $loadInfo-> getMerchantId();
$account_mode = $loadInfo-> getAccountMode();
$settle_mode = $loadInfo-> getSettleMode();
$cs_user_name = $loadInfo-> getCsUserName();
$cs_password = $loadInfo-> getCsPassword();


if($account_mode == 1) {
  $testSelect = 'selected';
  $liveSelect = "";
  }elseif($account_mode == 2) {
  $testSelect = "";
  $liveSelect = 'selected';  
  }else{
  $testSelect = "";
  $liveSelect = ""; 
  }

if($settle_mode == 1) {
  $testSelectTwo = 'selected';
  $liveSelectTwo = "";
  }elseif($settle_mode == 2) {
  $testSelectTwo = "";
  $liveSelectTwo = 'selected';  
  }else{
  $testSelectTwo = "";
  $liveSelectTwo = ""; 
  }




include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(83);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/merchantIdTemplate.php";




?>
