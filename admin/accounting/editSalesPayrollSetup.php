<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$delay = $_REQUEST['delay'];
$current_payment_setup = $_REQUEST['sales_pay_type'];
$payoutTier1 = $_REQUEST['payout_tier_1'];
$payoutTier2 = $_REQUEST['payout_tier_2'];
$bonus_threshold_type = $_REQUEST['bonus_switch'];
$currentBonusSetup = $_REQUEST['performance_switch'];
$numSalesTier1 = $_REQUEST['num_sales_tier_1'];
$salesTotTier1 = $_REQUEST['sales_tot_tier_1'];
$numSalesTier2 = $_REQUEST['num_sales_tier_2'];
$salesTotTier2 = $_REQUEST['sales_tot_tier_2'];


//echo "$current_payment_setup";
//exit;
include "../accounting/salesPaySql.php";


//if form is submitted save to database
if ($marker == 1) {
//echo "fubat test";
   $updateCycles = new salesPaySql();
   $updateCycles ->setDelay($delay);
   $updateCycles ->setBonusThresholdType($bonus_threshold_type);
   $updateCycles ->setPayoutTier1($payoutTier1);
   $updateCycles ->setPayoutTier2($payoutTier2);
   $updateCycles ->setNumSalesTier1($numSalesTier1);
   $updateCycles ->setNumSalesTier2($numSalesTier2);
   $updateCycles ->setSalesTotTier1($salesTotTier1);
   $updateCycles ->setSalesTotTier2($salesTotTier2);
  //  echo "fubat test222";
   $updateCycles ->setCurrentPaymentSetup($current_payment_setup);
   $updateCycles ->setCurrentBonusSetup($currentBonusSetup);
   $confirmation = $updateCycles -> updateSalesPayOptions();
   //echo"fubar222";
  
}


//echo"fubar";
$loadSalesPay = new salesPaySql();

$loadSalesPay -> loadSalesPayOptions();


$delay = $loadSalesPay -> getDelay();
$bonus_threshold_type = $loadSalesPay -> getBonusThresholdType();
$numSalesTier1 = $loadSalesPay -> getNumSalesTier1();
$numSalesTier2 = $loadSalesPay -> getNumSalesTier2();
$salesTotTier1 = $loadSalesPay -> getSalesTotTier1();
$salesTotTier2 = $loadSalesPay -> getSalesTotTier2();
$current_payment_setup = $loadSalesPay -> getCurrentPaymentSetup();
$currentBonusSetup = $loadSalesPay -> getCurrentBonusSetup();
$payoutTier1 = $loadSalesPay -> getPayoutTier1();
$payoutTier2 = $loadSalesPay -> getPayoutTier2();

if ($currentBonusSetup == 1){
    $bonusText = "ON";
    }else{
        $bonusText = "OFF";
    }
if ($current_payment_setup == 'D'){
    $text = "Delayed";
}else{
    $text = "Instant";
}
if ($bonus_threshold_type == 'S'){
    $bonusTextType = "Sales Total";
    }else{
        $bonusTextType = "Number of Sales";
    }



//sets up the varibles for the form template
$submit_link = 'editSalesPayrollSetup.php';
$submit_name = 'update';
$submit_title = "Update Sales Payroll Options";
$page_title  = 'Edit Sales Payroll Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/salesPay.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtSalesPay.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/salesPayrollTemplate.php";

?>