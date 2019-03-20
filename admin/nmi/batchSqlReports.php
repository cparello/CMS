<?php
class batchSqlReports {


function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=======================================================================================================
function maintFeeBatchInsert(){
$dbMain = $this->dbconnect();

$cycleDateCounter = 0;
$stmt1 = $dbMain->prepare("SELECT DISTINCT(m_cycle_date) FROM member_maintnence_eft WHERE contract_key!='' ORDER BY m_cycle_date ASC");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($eft_cycle_date); 
while($stmt1->fetch()){
    $dateArray[$cycleDateCounter] = $eft_cycle_date;
    $cycleDateCounter++;
}
$stmt1->close(); 
 
$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 


foreach($dateArray as $cycDate){
foreach($clubArray as $clubId){
              
                $mStart = date('m',strtotime($cycDate));//8;
                $yStart = date('Y',strtotime($cycDate));
                $billingDate = date('d',strtotime($cycDate));//25;
            
        //  echo "day $day CLUBID $clubId   month $mStart day $billingDate  year $yStart<br>"; 
        $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberAttempted);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND club_id = '$clubId'  AND response = '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberSuccess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND club_id = '$clubId'  AND response != '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberFailed);
            $stmt->fetch();
            $stmt->close();    
                
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjected);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF'  AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF'  AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response = '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response = '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response = '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response != '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailed);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response != '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND response != '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedAch);
            $stmt->fetch();
            $stmt->close(); 
            
            if ($totalBillingAmountProjected > 0){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_monthly_batch_totals WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'MF' AND club_id = '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $percentage = $totalBillingSucess/$totalBillingAmountProjected;
                
                if ($count >= 1){
                    $sql = "UPDATE billing_monthly_batch_totals SET projected = ?, credit_total_projected = ?, ach_total_projected = ?, collected = ?, collected_cc = ?, collected_ach = ?, failed_amount = ?, failed_amount_cc = ?, failed_amount_ach = ?, percentage_collected = ?, number_attempted = ?, number_success = ?, number_failed = ?  WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'MF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('ddddddddddiii', $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                 $stmt->execute();     
                  $stmt->close(); 
                }else{
                    $bid = "";
                    $batch_type = 'MF';
                    $sql = "INSERT INTO billing_monthly_batch_totals VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                	$stmt = $dbMain->prepare($sql);
                	$stmt->bind_param('isiiiiddddddddddiii',$bid, $batch_type, $clubId, $mStart, $billingDate, $yStart, $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                	$stmt->execute(); 
                    $this->batchId = $stmt->insert_id;
                	$stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET batch_id = ? WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('i', $this->batchId);
                  $stmt->execute();          
                  $stmt->close(); 
                    //create batch id
                }
            }
}
}



}
//=======================================================================================================
function enhanceFeeBatchInsert(){
$dbMain = $this->dbconnect();

$cycleDateCounter = 0;
$stmt1 = $dbMain->prepare("SELECT DISTINCT(eft_cycle_date) FROM member_enhance_eft WHERE contract_key!=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($eft_cycle_date); 
while($stmt1->fetch()){
    $dateArray[$cycleDateCounter] = $eft_cycle_date;
    $cycleDateCounter++;
}
$stmt1->close(); 
 
$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 


foreach($dateArray as $cycDate){
foreach($clubArray as $clubId){
              
                $mStart = date('m',strtotime($cycDate));//8;
                $yStart = date('Y',strtotime($cycDate));
                $billingDate = date('d',strtotime($cycDate));;//25;
            
        //  echo "day $day CLUBID $clubId   month $mStart day $billingDate  year $yStart<br>"; 
        $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberAttempted);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND club_id = '$clubId'  AND response = '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberSuccess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND club_id = '$clubId'  AND response != '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberFailed);
            $stmt->fetch();
            $stmt->close();    
                
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjected);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF'  AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF'  AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response = '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response = '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response = '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response != '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailed);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response != '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND response != '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedAch);
            $stmt->fetch();
            $stmt->close(); 
            
            if ($totalBillingAmountProjected > 0){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_monthly_batch_totals WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'EF' AND club_id = '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $percentage = $totalBillingSucess/$totalBillingAmountProjected;
                
                if ($count >= 1){
                    $sql = "UPDATE billing_monthly_batch_totals SET projected = ?, credit_total_projected = ?, ach_total_projected = ?, collected = ?, collected_cc = ?, collected_ach = ?, failed_amount = ?, failed_amount_cc = ?, failed_amount_ach = ?, percentage_collected = ?, number_attempted = ?, number_success = ?, number_failed = ?  WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'EF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('ddddddddddiii', $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                  $stmt->execute();       
                  $stmt->close(); 
                }else{
                    $bid = "";
                    $batch_type = 'EF';
                    $sql = "INSERT INTO billing_monthly_batch_totals VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                	$stmt = $dbMain->prepare($sql);
                	$stmt->bind_param('isiiiiddddddddddiii',$bid, $batch_type, $clubId, $mStart, $billingDate, $yStart, $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                	$stmt->execute(); 
                    $this->batchId = $stmt->insert_id;
                	$stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET batch_id = ? WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'EF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('i', $this->batchId);
                 $stmt->execute();      
                  $stmt->close(); 
                    //create batch id
                }
            }
}
}



}
//=======================================================================================================
function guaranteeFeeBatchInsert(){
$dbMain = $this->dbconnect();

$cycleDateCounter = 0;
$stmt1 = $dbMain->prepare("SELECT DISTINCT(eft_cycle_date) FROM member_guarantee_eft WHERE contract_key!=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($eft_cycle_date); 
while($stmt1->fetch()){
    $dateArray[$cycleDateCounter] = $eft_cycle_date;
    $cycleDateCounter++;
}
$stmt1->close();  

$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 

foreach($dateArray as $cycDate){
  foreach($clubArray as $clubId){
              
                $mStart = date('m',strtotime($cycDate));//8;
                $yStart = date('Y',strtotime($cycDate));
                $billingDate = date('d',strtotime($cycDate));;//25;
            
          //echo "day $day CLUBID $clubId   month $mStart day $billingDate  year $yStart<br>";
         
         $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberAttempted);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND club_id = '$clubId'  AND response = '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberSuccess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND club_id = '$clubId'  AND response != '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberFailed);
            $stmt->fetch();
            $stmt->close();          
                
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjected);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF'  AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF'  AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response = '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response = '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response = '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response != '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailed);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response != '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND response != '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedAch);
            $stmt->fetch();
            $stmt->close(); 
            
            if ($totalBillingAmountProjected > 0){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_monthly_batch_totals WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'RF' AND club_id = '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $percentage = $totalBillingSucess/$totalBillingAmountProjected;
                
                if ($count >= 1){
                     $sql = "UPDATE billing_monthly_batch_totals SET projected = ?, credit_total_projected = ?, ach_total_projected = ?, collected = ?, collected_cc = ?, collected_ach = ?, failed_amount = ?, failed_amount_cc = ?, failed_amount_ach = ?, percentage_collected = ?, number_attempted = ?, number_success = ?, number_failed = ?  WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'RF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('ddddddddddiii', $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                  $stmt->execute();       
                  $stmt->close(); 
                }else{
                    $bid = "";
                    $batch_type = 'RF';
                    $sql = "INSERT INTO billing_monthly_batch_totals VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                	$stmt = $dbMain->prepare($sql);
                	$stmt->bind_param('isiiiiddddddddddiii',$bid, $batch_type, $clubId, $mStart, $billingDate, $yStart, $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                $stmt->execute(); 
                    $this->batchId = $stmt->insert_id;
                	$stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET batch_id = ? WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'RF' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('i', $this->batchId);
                  $stmt->execute();      
                  $stmt->close(); 
                    //create batch id
                }
            }
}
  
}




}

//=======================================================================================================
function monthlyServiceBatchInsert(){
$dbMain = $this->dbconnect();
    
$cycDayCounter = 0;

$stmt1 = $dbMain->prepare("SELECT DISTINCT DAY(cycle_date) FROM monthly_payments WHERE contract_key!=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($day); 
while($stmt1->fetch()){
    $dayArray[$cycDayCounter] = $day;
    $cycDayCounter++;
}
$stmt1->close(); 

$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 

//var_dump($clubArray);
//var_dump($dayArray);
foreach($clubArray as $clubId){
    foreach($dayArray as $day){
       
               if(date('d') < $day){
                $mStart = date('m')-1;//8;
                $yStart = date('Y');
                $billingDate = $day;//25;
             }elseif(date('d') == $day){
                $mStart = date('m');//8;
                $yStart = date('Y');
                $billingDate = $day;//25;
             }elseif(date('d') > $day){
                $mStart = date('m');//8;
                $yStart = date('Y');
                $billingDate = $day;//25;
                }
          //echo "day $day CLUBID $clubId   month $mStart day $billingDate  year $yStart<br>"; 
          
          $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberAttempted);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND club_id = '$clubId'  AND response = '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberSuccess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND club_id = '$clubId'  AND response != '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberFailed);
            $stmt->fetch();
            $stmt->close();         
                
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjected);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS'  AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS'  AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response = '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response = '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response = '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response != '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailed);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response != '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND response != '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedAch);
            $stmt->fetch();
            $stmt->close(); 
            
            if ($totalBillingAmountProjected > 0){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_monthly_batch_totals WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'MS' AND club_id = '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $percentage = $totalBillingSucess/$totalBillingAmountProjected;
                
                if ($count >= 1){
                    
                                                            
                   // echo "############ $count ############################## month= $mStart AND day =$billingDate AND  year = $yStart AND batch_type = 'MS' AND club_id = '$clubId'test<br>";
                   //echo "$totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed,  $mStart' AND day = '$billingDate' AND  year = '$yStart";                   
                    
                     $sql = "UPDATE billing_monthly_batch_totals SET projected = ?, credit_total_projected = ?, ach_total_projected = ?, collected = ?, collected_cc = ?, collected_ach = ?, failed_amount = ?, failed_amount_cc = ?, failed_amount_ach = ?, percentage_collected = ?, number_attempted = ?, number_success = ?, number_failed = ?  WHERE month= '$mStart' AND day = '$billingDate' AND  year = '$yStart' AND batch_type = 'MS' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  // echo "count $count ";
                  $stmt->bind_param('ddddddddddiii', $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                 
                  $stmt->execute();     
                  $stmt->close(); 
                }else{
                    $bid = "";
                    $batch_type = 'MS';
                    $sql = "INSERT INTO billing_monthly_batch_totals VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                	$stmt = $dbMain->prepare($sql);
                	$stmt->bind_param('isiiiiddddddddddiii',$bid, $batch_type, $clubId, $mStart, $billingDate, $yStart, $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                	$stmt->execute(); 
                    $this->batchId = $stmt->insert_id;
                	$stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET batch_id = ? WHERE cycle_start_month= '$mStart' AND cycle_start_day = '$billingDate' AND  cycle_start_year = '$yStart' AND payment_type = 'MS' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('i', $this->batchId);
                  $stmt->execute();          
                  $stmt->close(); 
                  
                    //create batch id
                }
            }
}
}



}
//================================================================================================
//=======================================================================================================
function pastDueBatchInsert(){
$dbMain = $this->dbconnect();
    
$cycDayCounter = 0;


$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 

//var_dump($clubArray);
//var_dump($dayArray);
foreach($clubArray as $clubId){
       
       $stmt = $dbMain ->prepare("SELECT MAX(cycle_start_month), MAX(cycle_start_year) FROM batch_recurring_records WHERE payment_type = 'PD' AND club_id = '$clubId'");
       $stmt->execute();      
       $stmt->store_result();      
       $stmt->bind_result($mStart, $yStart);
       $stmt->fetch();
       $stmt->close();
               
                //$mStart = date('m');//8;
                //$yStart = date('Y');
               
          //echo "day $day CLUBID $clubId   month $mStart day $billingDate  year $yStart<br>"; 
          
          $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberAttempted);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND club_id = '$clubId'  AND response = '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberSuccess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT COUNT(*) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND club_id = '$clubId'  AND response != '100' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalNumberFailed);
            $stmt->fetch();
            $stmt->close();         
                
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjected);
            $stmt->fetch();
            $stmt->close();
            //echo "test22 $totalBillingAmountProjected    $mStart   $yStart  $clubId";
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD'  AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD'  AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingAmountProjectedAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response = '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucess);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response = '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response = '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingSucessAch);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response != '100' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailed);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response != '100' AND transaction_type = 'CC' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedCc);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT sum(billing_amount) FROM batch_recurring_records WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND response != '100' AND transaction_type = 'ACH' AND club_id = '$clubId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($totalBillingFailedAch);
            $stmt->fetch();
            $stmt->close(); 
            
            if ($totalBillingAmountProjected > 0){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_monthly_batch_totals WHERE month= '$mStart' AND  year = '$yStart' AND batch_type = 'PD' AND club_id = '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $percentage = $totalBillingSucess/$totalBillingAmountProjected;
                
                if ($count >= 1){
                    
                                                            
                   // echo "############ $count ############################## month= $mStart AND day =$billingDate AND  year = $yStart AND batch_type = 'MS' AND club_id = '$clubId'test<br>";
                   //echo "$totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed,  $mStart' AND day = '$billingDate' AND  year = '$yStart";                   
                    //echo "test";
                     $sql = "UPDATE billing_monthly_batch_totals SET projected = ?, credit_total_projected = ?, ach_total_projected = ?, collected = ?, collected_cc = ?, collected_ach = ?, failed_amount = ?, failed_amount_cc = ?, failed_amount_ach = ?, percentage_collected = ?, number_attempted = ?, number_success = ?, number_failed = ?  WHERE month= '$mStart' AND  year = '$yStart' AND batch_type = 'PD' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  // echo "count $count ";
                  $stmt->bind_param('ddddddddddiii', $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                 
                 $stmt->execute();  
                  $stmt->close(); 
                }else{
                    $bid = "";
                    $batch_type = 'PD';
                    $sql = "INSERT INTO billing_monthly_batch_totals VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                	$stmt = $dbMain->prepare($sql);
                	$stmt->bind_param('isiiiiddddddddddiii',$bid, $batch_type, $clubId, $mStart, $billingDate, $yStart, $totalBillingAmountProjected, $totalBillingAmountProjectedCc, $totalBillingAmountProjectedAch, $totalBillingSucess, $totalBillingSucessCc, $totalBillingSucessAch, $totalBillingFailed, $totalBillingFailedCc, $totalBillingFailedAch, $percentage, $totalNumberAttempted, $totalNumberSuccess, $totalNumberFailed);
                	$stmt->execute(); 
                    $this->batchId = $stmt->insert_id;
                	$stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET batch_id = ? WHERE cycle_start_month= '$mStart'  AND  cycle_start_year = '$yStart' AND payment_type = 'PD' AND club_id = '$clubId'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('i', $this->batchId);
                  $stmt->execute();      
                  $stmt->close(); 
                  
                    //create batch id
                }
            }

}



}

//==============================================================================================
function fileMaker(){
$this->monthlyServiceBatchInsert();
$this->enhanceFeeBatchInsert();
$this->guaranteeFeeBatchInsert();
$this->pastDueBatchInsert();
$this->maintFeeBatchInsert();
//echo "test";

//echo "1";
//exit;
}

//===============================================

}
//$upload = new batchSqlReports();
//$upload->fileMaker();
?>