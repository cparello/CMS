<?php
session_start();

//error_reporting(E_ALL);
class enhanceFeeSelector {

function setDay($day){
    $this->day = $day;
}

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//===============================================================================================
function checkAccountStatus() {
$count = 0;
$dbMain = $this->dbconnect();

$idArray = explode('|',$this->serviceIdArray);

foreach($idArray as $id){
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$totalCount += $count;
//echo"test fubar fubar xxxxxx  $count<br>";
 }
$this->statusCount = $totalCount;
}
//===============================================================================================
function countRecord(){

$this->serviceIdArray = "";
$dbMain = $this->dbconnect();

$counter = 1;
                //echo "$cycDay $cycDate $this->dueDate";        
$crTotal = 0;
$achTotal = 0;
$totalBilling = 0;
               // echo "test";
$stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key, eft_cycle, eft_cycle_date, enhance_fee FROM member_enhance_eft WHERE contract_key != '' ORDER BY contract_key ASC");//>=
$stmt999->execute();     
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->eftCycle, $this->eftCycleDate, $this->billingAmount); 
while($stmt999->fetch()){
    
    switch($this->eftCycle){
        case 'A':
            // do nothing
        break;
        case 'B':
            $this->billingAmount = sprintf("%01.2f", ($this->billingAmount/2));
        break;
        case 'Q':
            $this->billingAmount = sprintf("%01.2f", ($this->billingAmount/4));
        break;
        case 'M':
            $this->billingAmount = sprintf("%01.2f", ($this->billingAmount/12));
        break;
    }
    
    $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$this->contractKey'");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($contract_location, $contract_date); 
    $stmt->fetch();
    $stmt->close();
    
    $vault_id = 0;
    $stmt = $dbMain->prepare("SELECT vault_id FROM billing_vault_id  WHERE contract_key = '$this->contractKey'");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($vault_id); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT club_id FROM club_info  WHERE club_name = '$contract_location'");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($club_id); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($mainClubId); 
    $stmt->fetch();
    $stmt->close();
    
    if ($club_id == 0 OR $club_id == ""){
        $club_id = $mainClubId;
    }
    //echo "test";
   
                    $this->statusCount = 0;                 
                    $mStart = date('m'); 
                    $yearStart = date('Y');       
                    $todaysDate = date('Y-m-d H:i:s',mktime(0,0,0,$mStart,$this->day,$yearStart));
                    $month = date('m',strtotime($this->eftCycleDate));
                    $year = date('Y',strtotime($this->eftCycleDate));
                    
                    if($todaysDate >= $this->eftCycleDate){
                         //echo "test; $todaysDate  $this->eftCycleDate";
                                $customerBillingDate = date('d',strtotime($this->eftCycleDate));
                                
                                $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
                                $stmt->execute();  
                                $stmt->store_result();      
                                $stmt->bind_result($service_id); 
                                while($stmt->fetch()){
                                    $this->serviceIdArray .= "$service_id|";
                                }
                                $stmt->close();
                                
                                $stmt = $dbMain->prepare("SELECT monthly_billing_type FROM monthly_payments  WHERE contract_key = '$this->contractKey'");//>=
                                $stmt->execute();  
                                $stmt->store_result();      
                                $stmt->bind_result($monthly_billing_type); 
                                $stmt->fetch();
                                $stmt->close();
                                
                                    $this->checkAccountStatus();
                                    if ($this->statusCount >= 1){
                                   
                                          if($monthly_billing_type == 'CR') {
                                                    $transactionType = "CC";
                                                    $crTotal += $this->billingAmount;
                                            }else {                                                     //if($monthly_billing_type == 'BA')
                                                    $achTotal += $this->billingAmount;
                                                    $transactionType = "ACH";
                                            }
                                        $counter++;
                                        $totalBilling += $this->billingAmount;
                                        
                                        $pid = "";
                                        $processed = "N";
                                        $imported = "N";
                                        $recordBatched = "N";
                                        $outstandingBalance = "N"; 
                                        $paymentType = "MS";
                                        $authID = "";
                                        $transactionId = "";
                                        $attemptNumber = 1;
                                        $processorResponse = "";
                                        $response = "";
                                        $avsResponse = "";
                                        $cvvResponse = "";
                                       
                                         
                                        $batchId = "";                          
                                         //echo "test;";
                                        $stmt = $dbMain ->prepare("SELECT count(*) as count FROM batch_recurring_records WHERE contract_key ='$this->contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$yearStart'");
                                        $stmt->execute();      
                                        $stmt->store_result();      
                                        $stmt->bind_result($count);
                                        $stmt->fetch();
                                        $stmt->close();
                                        
                                        if ($count == 0 AND $this->billingAmount > 0){
                                          
                                            $sql = "INSERT INTO batch_recurring_records VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                                            $stmt = $dbMain->prepare($sql);
                                            $stmt->bind_param('iiiisssssssssssssdssss',$pid, $batchId, $club_id, $this->contractKey, $vault_id, $recordBatched, $processed, $imported, $outstandingBalance, $paymentType, $transactionType, $authID, $transactionId, $attemptNumber, $mStart, $customerBillingDate, $yearStart, $this->billingAmount, $response, $processorResponse, $avsResponse, $cvvResponse);
                                            $stmt->execute();
                                            $stmt->close();
                                           // echo "ttetet";
                                      }
                                  
                             }
                                    
                    }
   $this->contractKey = '';
   $this->eftCycle = '';
   $this->eftCycleDate = '';
   $this->billingAmount = '';
   $this->serviceIdArray = "";
   $contract_location = "";
   $contract_date = "";
   $club_id = ""; 
    $vault_id = "0"; 
    $monthly_billing_type = "";            
}
$stmt999->close();
$this->counter = $counter; 
}

//===============================================
function getCount(){
    return ($this->counter);
}
}
//$upload = new enhanceFeeSelector();
//$upload->countRecord();

//include"processScheduledCCTransactions.php";

/*include"updateTablesSuccessfulTransaction.php";
$update = new updateTablesSucessfulTransaction();
$update->moveData();

include"updateTablesFailedTransaction.php";
$update = new updateTablesFailedTransaction();
$update->moveData();*/


?>