<?php
//error_reporting(E_ALL);
session_start();


class monthlyBillingSelector {


function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}

function setBool($bool){
    $this->bool = $bool;
}
function setStart($start){
    $this->monthStart = $start;
}
function setEnd($end){
    $this->monthEnd = $end;
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
$dbMain = $this->dbconnect();
    
    
$this->serviceIdArray = "";



       
$counter = 1;
                //echo "$cycDay $cycDate $this->dueDate";
                
$crTotal = 0;
$achTotal = 0;
$totalBilling = 0;
               // echo "test";
$stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key, cycle_date, billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key != '' AND (monthly_billing_type = 'CR' OR monthly_billing_type = 'BA') ORDER BY contract_key ASC");//>=
if(!$stmt999->execute())  {
                        	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                              }	      
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->cycleDate, $this->billingAmount, $monthly_billing_type); 
while($stmt999->fetch()){
    
    
   

                    $this->statusCount = 0;
                   
                   
                    
                   
                   
                    $stmt = $dbMain->prepare("SELECT service_id,start_date, MAX(end_date) FROM monthly_services  WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'");//>=
                    $stmt->execute();  
                    $stmt->store_result();      
                    $stmt->bind_result($service_id, $start_date, $end_date); 
                    while($stmt->fetch()){
                        $this->serviceIdArray .= "$service_id|";
                    }
                    $stmt->close(); 
                    
                    $reportStart = "2014-01-01 00:00:00";
                    $startSecs = strtotime($start_date);
                    $reportStartSecs = strtotime($reportStart);
                    
                    
                    //echo"test2 $this->contractKey";
                        $billing_amount = $this->billingAmount;
                        $this->checkAccountStatus();
                     //   echo " $this->statusCount ";
                        if ($this->statusCount >= 1 AND $reportStartSecs <= $startSecs){
                      
                           echo "$this->contractKey<br>";
                           
                            $counter++;
                            $totalBilling += $this->billingAmount;
                            
                            $pid = "";
                            $processed = "N";
                            $imported = "N";
                            $paymentType = "MS";
                            $authID = "";
                            $attemptNumber = 0;
                            $responseMessage = "";
                            $response = "";
                            $responseComments = "";
                            $avsResponse = "";
                            $responseType = "";
                            $exactReponse = "";
                            $exactCode = "";
                            $tranasctionTag = "";
                            $outstandingBalance = "";  
                            $batchId = "";                          
                             //echo "test;";
                          
                         
                            
                            //echo "ck $this->contractKey, cd $this->cycleDate, ba $this->billingAmount pp $this->prePayCount sc $this->statusCount msc $this->monthlySettledCount servcred $this->creditCount ba $billing_amount servcreddis $this->serviceCreditDiscount mbt $monthly_billing_type<br>";
                        
                        
                       }
                         $this->contractKey = "";
                         $this->cycleDate = "";
                         $this->billingAmount = "";
                         $monthly_billing_type = "";
                         $this->serviceIdArray = "";
                         $contract_location = "";
                         $contract_date = "";
                         $club_id = "";
}
                      echo "count $counter";
                         //insert total projected here
                $stmt999->close();
}
//==============================================================================================
function fileMaker(){
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->pastDays);
    $stmt->fetch();
    $stmt->close();        
    
   
   $this->countRecord();
        
}
//===============================================
function getBatchId(){
    return($this->batchId);
}
}
$upload = new monthlyBillingSelector();
$upload->fileMaker();
$msBatchId = $upload->getBatchId();
include"rateGuarenteeSelector.php";
$upload = new rateFeeSelector();
$upload->countRecord();
$rfBatchId = $upload->getBatchId();
include"enhanceFeeSelector.php";
$upload = new enhanceFeeSelector();
$upload->countRecord();
$efBatchId = $upload->getBatchId();

include"processScheduledCCTransactions.php";

/*include"updateTablesSuccessfulTransactions.php";
$update = new updateTablesSucessfulTransaction();
$update->moveData();

include"updateTablesFailedTransactions.php";
$update = new updateTablesFailedTransaction();
$update->moveData();*/

?>