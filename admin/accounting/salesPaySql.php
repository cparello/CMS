<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  salesPaySql{

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



function setDelay($delay){
   $this->delay = $delay;
}
function setBonusThresholdType($bonusThresholdType){
    $this->bonusThresholdType = $bonusThresholdType;
}
function setNumSalesTier1($tier1){
    $this->numSalesTier1 = $tier1;
}
function setNumSalesTier2($tier2){
    $this->numSalesTier2 = $tier2;
}
function setSalesTotTier1($salesTotTier1){
    $this->salesTotTier1 = $salesTotTier1;
}
function setSalesTotTier2($salesTotTier2){
    $this->salesTotTier2 = $salesTotTier2;
}
function setCurrentPaymentSetup($currentPaymentSetup){
    $this->currentPaymentSetup = $currentPaymentSetup;
}
function setCurrentBonusSetup($currentBonusSetup){
    $this->currentBonusSetup = $currentBonusSetup;
}
function setPayoutTier1($payoutTier1){
    $this->payoutTier1 = $payoutTier1;
}
function setPayoutTier2($payoutTier2){
    $this->payoutTier2 = $payoutTier2;
}
       

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadSalesPayOptions()  {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT commision_payout_type, delay, bonus_switch, bonus_type, num_sales_tier_1, num_sales_tier_2, sales_tot_tier_1, sales_tot_tier_2, payout_tier_1, payout_tier_2  FROM sales_pay_options WHERE sales_setup_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->currentPaymentSetup, $this->delay, $this->currentBonusSetup, $this->bonusThresholdType,$this->numSalesTier1, $this->numSalesTier2, $this->salesTotTier1, $this->salesTotTier2, $this->payoutTier1, $this->payoutTier2);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();


}
//----------------------------------------------------------------------------------
function updateSalesPayOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE sales_pay_options SET commision_payout_type = ?, delay = ?, bonus_switch = ?, bonus_type = ?, num_sales_tier_1 = ?, num_sales_tier_2 = ?, sales_tot_tier_1 = ?, sales_tot_tier_2 = ?, payout_tier_1 = ?, payout_tier_2 = ? WHERE sales_setup_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sissiiiiii', $this->currentPaymentSetup, $this->delay, $this->currentBonusSetup, $this->bonusThresholdType,$this->numSalesTier1, $this->numSalesTier2, $this->salesTotTier1, $this->salesTotTier2, $this->payoutTier1, $this->payoutTier2);
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 
//echo"<br>t4";
$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================


function getDelay(){
    return($this->delay);
}
function getBonusThresholdType(){
    return($this->bonusThresholdType);
}
function getNumSalesTier1(){
    return($this->numSalesTier1);
}
function getNumSalesTier2(){
    return($this->numSalesTier2);
}
function getSalesTotTier1(){
    return($this->salesTotTier1);
}
function getSalesTotTier2(){
    return($this->salesTotTier2);
}
function getCurrentPaymentSetup(){
    return($this->currentPaymentSetup);
}
function getCurrentBonusSetup(){
    return($this->currentBonusSetup);
}
function getPayoutTier1(){
    return($this->payoutTier1);
}
function getPayoutTier2(){
    return($this->payoutTier2);
}

}


?>