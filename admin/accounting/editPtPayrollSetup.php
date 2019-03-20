<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$percentage = $_REQUEST['percentage'];
$currentPaymentSetup = $_REQUEST['pt_pay_type'];
$flat1Hr = $_REQUEST['flat_rate_1_hr'];
$flatHalfhour = $_REQUEST['flat_rate_half_hour'];
$currentBonusSetup = $_REQUEST['performance_switch'];
$tier1 = $_REQUEST['tier_1'];
$hourlyBump1 = $_REQUEST['hourly_bump_1'];
$tier2 = $_REQUEST['tier_2'];
$hourlyBump2 = $_REQUEST['hourly_bump_2'];
$tier3 = $_REQUEST['tier_3'];
$hourlyBump3 = $_REQUEST['hourly_bump_3'];


$num_assesments = $_REQUEST['num_assesments'];
$paid_assesments = $_REQUEST['paid_assesments'];
$paid_assesment_amount = $_REQUEST['paid_assesment_amount'];
$reminders_on = $_REQUEST['reminders_on'];
$reminder_hours = $_REQUEST['reminder_hours'];




include "../accounting/ptPaySql.php";


$billing_day = trim($billing_day);


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new ptPaySql();
   $updateCycles ->setPercentage($percentage);
   $updateCycles ->setFlat1Hr($flat1Hr);
   $updateCycles ->setFlatHalfHr($flatHalfhour);
   $updateCycles ->setTier1($tier1);
   $updateCycles ->setTier2($tier2);
   $updateCycles ->setTier3($tier3);
   $updateCycles ->setHourlyBump1($hourlyBump1);
   $updateCycles ->setHourlyBump2($hourlyBump2);
   $updateCycles ->setHourlyBump3($hourlyBump3);
   $updateCycles ->setCurrentPaymentSetup($currentPaymentSetup);
   $updateCycles ->setCurrentBonusSetup($currentBonusSetup);
   $updateCycles ->setNumAssesments($num_assesments);
   $updateCycles ->setPaidAssesments($paid_assesments);
   $updateCycles ->setPaidAssesmentAmount($paid_assesment_amount);
   $updateCycles ->setRemindersOn($reminders_on);
   $updateCycles ->setReminderHours($reminder_hours);
   $confirmation = $updateCycles -> updatePtPayOptions();
   //echo"fubar222";
}


//echo"fubar";
$loadPtPay = new ptPaySql();

$loadPtPay -> loadPtPayOptions();


$percentage = $loadPtPay -> getPercentage();
$flat_rate_1_hr = $loadPtPay -> getFlat1Hr();
$flat_rate_half_hour = $loadPtPay -> getFlatHalfHr();
$tier_1 = $loadPtPay -> getTier1();
$tier_2 = $loadPtPay -> getTier2();
$tier_3 = $loadPtPay -> getTier3();
$hourly_bump_1 = $loadPtPay -> getHourlyBump1();
$hourly_bump_2 = $loadPtPay -> getHourlyBump2();
$hourly_bump_3 = $loadPtPay -> getHourlyBump3();
$current_payment_setup = $loadPtPay -> getCurrentPaymentSetup();
$current_bonus_setup = $loadPtPay -> getCurrentBonusSetup();
$num_assesments = $loadPtPay -> getTrainingAssesmnetsGiven();
$paid_assesments = $loadPtPay -> getPaidTrainingAssesments();
$paid_assesment_amount = $loadPtPay -> getTaPayAmount();
$reminders_on = $loadPtPay -> getReminders();
$reminder_hours = $loadPtPay -> getReminderTimeHours();

if ($current_bonus_setup == 1){
    $bonusText = "ON";
    }else{
        $bonusText = "OFF";
    }
if ($current_payment_setup == 'P'){
    $text = "Percentage";
}else{
    $text = "Flat Rate";
}

if ($paid_assesments == 'Y'){
    $paidText = 'Yes';
}else{
    $paidText = 'No';
}
if ($reminders_on == 'Y'){
    $reminders_on_text = 'Yes';
}else{
    $reminders_on_text = 'No';
}

//sets up the varibles for the form template
$submit_link = 'editPtPayrollSetup.php';
$submit_name = 'update';
$submit_title = "Update Personal Trainer Payroll Options";
$page_title  = 'Edit Personal Trainer Payroll Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/ptPay.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPtPay.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/ptPayrollTemplate.php";

?>