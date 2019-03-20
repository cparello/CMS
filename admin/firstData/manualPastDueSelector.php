<?php
//error_reporting(E_ALL);
session_start();


class pastDueSelector {


function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//===============================================================================================
function countRecord(){
    $dbMain = $this->dbconnect(); 
            
        
        $mStart = date('m');
        $yearStart = date('Y');
        $customerBillingDate = date('d'); 
        
         $pid = "";
         $processed = "N";
         $imported = "N";
         $paymentType = "PD";
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
         $stmt = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_recuring_payments WHERE contract_key ='$this->contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_year = '$yearStart'");
         $stmt->execute();      
         $stmt->store_result();      
         $stmt->bind_result($count);
         $stmt->fetch();
         $stmt->close();
         
         if($count<=0){
            $sql = "INSERT INTO billing_scheduled_recuring_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('iiiissssssisssdssssssss',$pid, $batchId, $this->clubId, $this->contractKey, $processed, $imported, $outstandingBalance, $paymentType, $this->monthlyBillingType, $authID, $attemptNumber, $mStart, $customerBillingDate, $yearStart, $this->billingAmount, $responseMessage, $response, $response2, $avsResponse, $responseType, $exactReponse, $exactCode, $tranasctionTag );
            if(!$stmt->execute())  {
           	    printf("Error:billing_scheduled_recuring_payments %s.\n", $stmt->error);
                }	
            $stmt->close();
         }
        
        
        //echo "ckey $this->contractKey numMonths $this->numberMonthsOwed monthAmount $this->billingAmount total $totalOwed<br>";
        //$this->bigTotal += $totalOwed; 
    
    
   

}
//==============================================================================================
function fileMaker(){
    
$dbMain = $this->dbconnect();

$stmt99 = $dbMain ->prepare("SELECT contract_key, transaction_type, club_id FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND outstanding_balance = 'Y'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($this->contractKey, $this->monthlyBillingType, $this->clubId);
while($stmt99->fetch()){
    echo "test";
    $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM billing_scheduled_recuring_payments WHERE contract_key = '$this->contractKey' AND outstanding_balance = 'Y'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->billingAmount);
    $stmt->fetch();
    $stmt->close();
    
        $this->countRecord();
        
        $this->contractKey = "";
        $this->monthlyBillingType = "";
        $this->clubId = "";
        $this->billingAmount = "";
    }
$stmt99->close();   
  // echo "teste BIG TOT $this->bigTotal";
        
}
//===============================================
}


?>