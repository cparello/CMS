<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$billing_day = $_REQUEST['billing_day'];
$pif_enhance_date = $_REQUEST['pif_enhance_date'];
$eft_enhancement_cycle = $_REQUEST['eft_enhancement_cycle'];
$guarantee_annual_date = $_REQUEST['guarantee_annual_date'];
$eft_guarantee_cycle = $_REQUEST['eft_guarantee_cycle'];
$m_cycle = $_REQUEST['m_cycle'];
$eft_term_switch = $_REQUEST['eft_term_switch'];
$enh_term_switch = $_REQUEST['enh_term_switch'];
$m_term_switch = $_REQUEST['m_term_switch'];


include "cycleSql.php";


$billing_day = trim($billing_day);


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new cycleSql();
   $updateCycles -> setMonthlyBillingDay($billing_day);   
   $updateCycles -> setPifEnhanceDate($pif_enhance_date);
   $updateCycles -> setEftEnhanceCycle($eft_enhancement_cycle);   
   $updateCycles -> setGuaranteeAnnualDate($guarantee_annual_date);      
   $updateCycles -> setGuaranteeCycle($eft_guarantee_cycle);
   $updateCycles -> setMCycle($m_cycle);
   $updateCycles -> setGTermSwitch($eft_term_switch);
   $updateCycles -> setETermSwitch($enh_term_switch);
   $updateCycles -> setMTermSwitch($m_term_switch);
   $confirmation = $updateCycles -> updateCycleData();
}



$loadCycles = new cycleSql();
$loadCycles -> loadCycleData();

$billing_day = $loadCycles -> getMonthlyBillingDay();
$pif_enhance_date = $loadCycles -> getPifEnhanceDate();
$enhance_select_list = $loadCycles -> getEftEnhanceSelectList();
$enhance_fee_total = $loadCycles -> getEnhanceFeeTotal();
$enhance_summary_text = $loadCycles -> getEnhanceSummaryText();
$enhance_fee_payment = $loadCycles -> getEnhanceFeePayment();

$guarantee_annual_date = $loadCycles -> getGuaranteeAnnualDate();
$guarantee_select_list = $loadCycles -> getGuaranteeSelectList();
$guarantee_fee_total = $loadCycles -> getGuaranteeFeeTotal();
$guarantee_summary_text = $loadCycles -> getGuaranteeSummaryText();
$guarantee_fee_payment = $loadCycles -> getGuaranteeFeePayment();
$g_term_select_list = $loadCycles -> getGTermSelectedList();
$e_term_select_list = $loadCycles -> getETermSelectedList();

$m_term_select_list = $loadCycles -> getMTermSelectedList();
$maintnence_fee_payment = $loadCycles -> getMFeePayment();
$maintnence_summary_text = $loadCycles -> getMSummaryText();
$maintnence_select_list = $loadCycles -> getMSelectList();
//sets up the varibles for the form template
$submit_link = 'editCycleDates.php';
$submit_name = 'update';
$submit_title = "Update Payment Cycle Dates";
$page_title  = 'Edit Payment Cycle Dates';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/cycles.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCycles.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/cycleTemplate.php";

?>