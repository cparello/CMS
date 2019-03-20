<?php
session_start();

//error_reporting(E_ALL);
class enhanceFeeSelector {

function setDay($day){
    $this->day = $day;
}

function dbconnect()   {
require"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/dbConnect.php";
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
if(!$stmt999->execute())  {
                        	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                              }	      
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->eftCycle, $this->eftCycleDate, $enhanceFee); 
while($stmt999->fetch()){
    
    switch($this->eftCycle){
        case 'A':
            // do nothing
        break;
        case 'B':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/2));
        break;
        case 'Q':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/4));
        break;
        case 'M':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/12));
        break;
    }
    
    $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$this->contractKey'");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($contract_location, $contract_date); 
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
                    $todaysDate = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),$this->day,date('Y')));
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
                                                    $crTotal += $enhanceFee;
                                            }else {                                                     //if($monthly_billing_type == 'BA')
                                                    $achTotal += $enhanceFee;
                                                    $transactionType = "ACH";
                                            }
                                        $counter++;
                                        $totalBilling += $enhanceFee;
                                        
                                        $pid = "";
                                        $processed = "N";
                                        $imported = "N";
                                        $paymentType = "EF";
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
                                        $batchId = "";   
                                        
                                        $stmt = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_recuring_payments WHERE contract_key ='$this->contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$month' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$year'");
                                        $stmt->execute();      
                                        $stmt->store_result();      
                                        $stmt->bind_result($count);
                                        $stmt->fetch();
                                        $stmt->close();
                                        
                                        if ($count == 0){
                                            
                                              //echo "$pid, $this->contractKey, $processed, $paymentType, $transactionType, $authID, $attemptNumber, $month, $this->billingAmount, $responseMessage, $response, $responseComments, $avsResponse, $responseType, $exactReponse, $exactCode <br>";
                                            //exit;
                                            //insert each trans here billing_scheduled_recuring_payments
                                $sql = "INSERT INTO billing_scheduled_recuring_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                                $stmt = $dbMain->prepare($sql);
                                $stmt->bind_param('iiiissssssisssdssssssss',$pid, $batchId, $club_id, $this->contractKey, $processed, $imported, $outstandingBalance, $paymentType, $transactionType, $authID, $attemptNumber, $month, $customerBillingDate, $year, $enhanceFee, $responseMessage, $response, $response2, $avsResponse, $responseType, $exactReponse, $exactCode, $tranasctionTag );
                                if(!$stmt->execute())  {
                                            	printf("Error:billing_scheduled_recuring_payments %s.\n", $stmt->error);
                                                  }	
                                $stmt->close();
                                           // echo "ttetet";
                                      }
                                  
                             }
                                    
                    }
   $this->contractKey = '';
   $this->eftCycle = '';
   $this->eftCycleDate = '';
   $enhanceFee = '';
   $this->serviceIdArray = "";
   $contract_location = "";
   $contract_date = "";
   $club_id = "";              
}
$stmt999->close();
}

//===============================================

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