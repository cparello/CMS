<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  ptPaySql{

private $monthlyBillingDay = null;

private $guaranteeAnnualDate = null;
private $guaranteeCycle = null;
private $guaranteeFeeTotal = null;
private $guaranteeSelectList = null;
private $guaranteeSummaryText = null;
private $guaranteeFeePayment = null;

private $enhanceFeeTotal = null;
private $enhanceFeePayment = null;
private $eftEnhanceSelectList = null;
private $enhanceSummaryText = null;
private $eftEnhanceCycle = null;
private $pifEnhanceDate = null;


private $cycleSelected = null;
private $selectList = null;
private $cycleDivisor = null;
private $paymentSummaryText = null;
private $feePayment = null;
private $markerText = null;
private $gTermSwitch = null;
private $gTermSelectList = null;
private $eTermSwitch = null;
private $eTermSelectList = null;



function setPercentage($percentage){
   $this->percentage = $percentage;
}
function setFlat1Hr($flat1Hr){
   $this->flat1Hr = $flat1Hr; 
}
function setFlatHalfHr($flatHalfhour){
    $this->flatHalfHour = $flatHalfhour;
}
function setTier1($tier1){
    $this->tier1 = $tier1;
}
function setTier2($tier2){
    $this->tier2 = $tier2;
}
function setTier3($tier3){
    $this->tier3 = $tier3;
}
function setHourlyBump1($hourlyBump1){
    $this->hourlyBump1 = $hourlyBump1;
}
function setHourlyBump2($hourlyBump2){
    $this->hourlyBump2 = $hourlyBump2;
}
function setHourlyBump3($hourlyBump3){
    $this->hourlyBump3 = $hourlyBump3;
}
function setCurrentPaymentSetup($currentPaymentSetup){
    $this->currentPaymentSetup = $currentPaymentSetup;
}
function setCurrentBonusSetup($currentBonusSetup){
    $this->currentBonusSetup = $currentBonusSetup;
}
function  setNumAssesments($num_assesments){
    $this->numAssesments = $num_assesments;
}
function setPaidAssesments($paid_assesments){
    $this->paidAssements = $paid_assesments;
}
function setPaidAssesmentAmount($paid_assesment_amount){
    $this->paidAssesmentAmount = $paid_assesment_amount;
}
function setRemindersOn($reminders_on){
    $this->remindersOn = $reminders_on;
}
function setReminderHours($reminder_hours){
    $this->reminderHours = $reminder_hours;
}
       

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadPtPayOptions()  {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT use_pt_performance_pay, percent_or_flat_rate, session_price_percent, session_tier_1, hourly_bump_1, session_tier_2, hourly_bump_2, session_tier_3, hourly_bump_3, trainers_normal_hourly, trainers_normal_half_hourly, training_assesments_given, paid_training_assesments,ta_pay_amount, reminders, reminder_time_hours  FROM pt_pay_options WHERE pt_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1,$this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour, $this->numAssesments, $this->paidAssements, $this->paidAssesmentAmount, $this->remindersOn, $this->reminderHours);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();


}
//----------------------------------------------------------------------------------
function updatePtPayOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
$dbMain = $this->dbconnect();
$sql = "UPDATE pt_pay_options SET use_pt_performance_pay= ?, percent_or_flat_rate = ?, session_price_percent = ?, session_tier_1= ?, hourly_bump_1= ?, session_tier_2= ?, hourly_bump_2= ?, session_tier_3= ?, hourly_bump_3= ?, trainers_normal_hourly= ?, trainers_normal_half_hourly= ?, training_assesments_given = ?, paid_training_assesments = ?, ta_pay_amount = ?,  reminders = ?,  reminder_time_hours = ? WHERE pt_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isdidididddisdsi', $this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour, $this->numAssesments, $this->paidAssements, $this->paidAssesmentAmount, $this->remindersOn, $this->reminderHours);
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 

$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================


function getPercentage(){
    return($this->percentage);
}
function getFlat1Hr(){
   return($this->flat1Hr); 
}
function getFlatHalfHr(){
    return($this->flatHalfHour);
}
function getTier1(){
    return($this->tier1);
}
function getTier2(){
    return($this->tier2);
}
function getTier3(){
    return($this->tier3);
}
function getHourlyBump1(){
    return($this->hourlyBump1);
}
function getHourlyBump2(){
    return($this->hourlyBump2);
}
function getHourlyBump3(){
    return($this->hourlyBump3);
}
function getCurrentPaymentSetup(){
    return($this->currentPaymentSetup);
}
function getCurrentBonusSetup(){
    return($this->currentBonusSetup);
}
function getTrainingAssesmnetsGiven(){
    return($this->numAssesments);
}
function getPaidTrainingAssesments(){
    return($this->paidAssements);
}
function getTaPayAmount(){
    return($this->paidAssesmentAmount);
}
function getReminders(){
    return($this->remindersOn);
}
function getReminderTimeHours(){
    return($this->reminderHours);
}

}


?>