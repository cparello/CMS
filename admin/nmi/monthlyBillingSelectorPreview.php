<?php
//error_reporting(E_ALL);
session_start();


class monthlyBillingSelector {


function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setDay($day){
    $this->day = $day;
}

//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
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
function checkServiceCredit() {
    
$this->serviceCreditDiscount = 0;
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) FROM service_credits WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

$this->creditCount = $count;

if ($this->creditCount >= '1'){
    $stmt999 = $dbMain ->prepare("SELECT service_key FROM service_credits WHERE contract_key='$this->contractKey'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($service_key);
    while($stmt999->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT service_term FROM service_cost WHERE service_key='$service_key'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_term);
        $stmt->fetch(); 
        $stmt->close();
        
        if ($service_term == 'M'){
            $stmt = $dbMain ->prepare("SELECT unit_price, number_months, MAX(end_date) FROM monthly_services WHERE service_key='$service_key' AND contract_key='$this->contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($unit_price, $number_months, $end_date);
            $stmt->fetch(); 
            $stmt->close();
            $this->serviceCreditDiscount +=  sprintf("%01.2f", ($unit_price/$number_months));
        }
        
    }
    $stmt999->close();
}else{
    $this->creditCount = 0;
}
 

}
//==================================================================================================
function checkSettledPaymentsCount() {
    
$dbMain = $this->dbconnect();    
$contract_key = "";
$stmt = $dbMain ->prepare("SELECT contract_key, next_payment_due_date FROM monthly_settled WHERE contract_key='$this->contractKey' AND next_payment_due_date <= '$this->dueDate' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $next_payment_due_date);
$stmt->fetch();
$stmt->close();
//echo "next due date $next_payment_due_date <br>";
if ($contract_key == $this->contractKey){
    $this->monthlySettledCount = 0;
}else{
    $this->monthlySettledCount = 1;
}

if ($contract_key == "" OR $contract_key == 0){
    $this->monthlySettledCount = 0;
}
}
//===============================================================================================
function countRecord(){
$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->pastDays); 
$stmt->fetch();
$stmt->close();
    
$todaysDate =  date("Y-m-d H:i:s");
$sql13 = "DELETE FROM pre_payments WHERE restart_date <= '$todaysDate'";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();
        
$sql13 = "DELETE FROM service_credits WHERE credit_end <= '$todaysDate'";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();    
   
//$billingDate = date('d');    
    
$this->serviceIdArray = "";



       
$counter = 1;
                //echo "$cycDay $cycDate $this->dueDate";
                
$crTotal = 0;
$achTotal = 0;
$totalBilling = 0;
               // echo "test";
$stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key, cycle_date, billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key != '' AND DAY(cycle_date) = '$this->day' AND (monthly_billing_type = 'CR' OR monthly_billing_type = 'BA') ORDER BY contract_key ASC");//>=
if(!$stmt999->execute())  {
                        	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                              }	      
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->cycleDate, $this->billingAmount, $monthly_billing_type); 
while($stmt999->fetch()){
    
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
    
   

                    $this->statusCount = 0;
                    $this->prePayCount = 0;
                    $this->creditCount = 1;
                    $this->monthlySettledCount = 0;
                    
                    
                    $customerBillingDate = date('d',strtotime($this->cycleDate));
                    
                    if(date('d') < $customerBillingDate){
                        $mStart = date('m')-1;//8;
                        $yStart = date('Y');
                        $billingDate = $this->day;//25;
                    }elseif(date('d') == $customerBillingDate){
                        $mStart = date('m');//8;
                        $yStart = date('Y');
                        $billingDate = $this->day;//25;
                    }elseif(date('d') > $customerBillingDate){
                        $mStart = date('m');//8;
                        $yStart = date('Y');
                        $billingDate = $this->day;//25;
                    }
                    
                    //$mStart = 8;//date('m');//8;
                    //    $yStart = 2014;//date('Y');
                    //    $billingDate = 25;//date('d');//25;
                   // $cycDate = date("F j, Y",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
                    $this->dueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate+$this->pastDays,$yStart));
                    
                    $yearStart = date('Y',strtotime($this->dueDate));
                   
                    $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
                    $stmt->execute();  
                    $stmt->store_result();      
                    $stmt->bind_result($service_id); 
                    while($stmt->fetch()){
                        $this->serviceIdArray .= "$service_id|";
                    }
                    $stmt->close();
                    
                    
                    
                    //echo"test2 $this->contractKey";
                        $billing_amount = $this->billingAmount;
                        $this->checkAccountStatus();
                     //   echo " $this->statusCount ";
                        if ($this->statusCount >= 1){
                           // echo "test key $this->contractKey due date $this->dueDate";  
                        $this->checkPrepay();
                     //   echo " $this->prePayCount ";
                        if ($this->prePayCount == 0){
                        $this->checkSettledPaymentsCount();
                        $this->checkServiceCredit(); 
                      //  echo " $this->monthlySettledCount $this->dueDate$dateFlag<br>";                                                                                                
                        if ($this->monthlySettledCount == 0){
                       //     echo " $this->creditCount <br>";
                            if($this->creditCount >= 1){
                                                
                                $this->billingAmount = sprintf("%01.2f", ($this->serviceCreditDiscount - $this->billingAmount));
                              }
                              //echo "fubar ";
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
                            $stmt = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_preview WHERE contract_key ='$this->contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$yearStart'");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($count == 0 AND $this->billingAmount > 0){
                                //echo "ttetet";
                                 // echo "$pid, $this->contractKey, $processed, $paymentType, $transactionType, $authID, $attemptNumber, $month, $this->billingAmount, $responseMessage, $response, $responseComments, $avsResponse, $responseType, $exactReponse, $exactCode ";
                                //exit;
                                //insert each trans here billing_scheduled_recuring_payments
                                $sql = "INSERT INTO billing_scheduled_preview VALUES (?,?,?,?,?,?,?,?,?,?)";
                                $stmt = $dbMain->prepare($sql);
                                $stmt->bind_param('iiiisssssd',$pid, $batchId, $club_id, $this->contractKey, $paymentType, $transactionType, $mStart, $customerBillingDate, $yearStart, $this->billingAmount);
                                if(!$stmt->execute())  {
                                            	printf("Error:billing_scheduled_preview %s.\n", $stmt->error);
                                                  }	
                                $stmt->close();
                            }
                         
                            
                            //echo "ck $this->contractKey, cd $this->cycleDate, ba $this->billingAmount pp $this->prePayCount sc $this->statusCount msc $this->monthlySettledCount servcred $this->creditCount ba $billing_amount servcreddis $this->serviceCreditDiscount mbt $monthly_billing_type<br>";
                        }
                        }
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
                      
                         //insert total projected here
                $stmt999->close();
                
                $this->counter = $counter;
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
function getCount(){
    return ($this->counter);
}
}

/*$year = date("Y");//'2013';
$month = date("m");//'12';
$day = date("j")-1;//'10';

include"dailySalesReport.php";
$report = new emailDSRReports();
$report->setMonth($month);
$report->setDay($day);
$report->setYear($year);
$report->moveData();*/
$day = $_REQUEST['day'];

$upload = new monthlyBillingSelector();
$upload->setDay($day);
$upload->fileMaker();
$billCount = $upload->getCount();

include"rateGuarenteePreview.php";
$upload = new rateFeeSelector();
$upload->setDay($day);
$upload->countRecord();
$rateCount = $upload->getCount();

include"enhanceFeePreview.php";
$upload = new enhanceFeeSelector();
$upload->setDay($day);
$upload->countRecord();
$efCount = $upload->getCount();

include"maintFeePreview.php";
$upload = new maintnenceFeeSelector();
$upload->setDay($day);
$upload->countRecord();
$mfCount = $upload->getCount();


include"batchSqlPreview.php";
$upload = new batchSqlReports();
$upload->fileMaker();

echo "1|$billCount|$rateCount|$efCount|$mfCount";
exit;
/*include"updateTablesSuccessfulTransactions.php";
$update = new updateTablesSucessfulTransaction();
$update->moveData();

include"updateTablesFailedTransactions.php";
$update = new updateTablesFailedTransaction();
$update->moveData();*/

?>