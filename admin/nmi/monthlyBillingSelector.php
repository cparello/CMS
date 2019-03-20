<?php
require "nmiGatewayClass.php";
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
//=================================================================================================================

function doVaultIds(){

$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($clubId); 
$stmt->fetch();
$stmt->close();
                
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_name, $password);
$stmt->fetch();
$stmt->close();

$stmt99 = $dbMain ->prepare("SELECT contract_key, transaction_type FROM batch_recurring_records WHERE contract_key != '' AND processed = 'N' AND vault_id = '0'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($contract_key, $transaction_type);
while($stmt99->fetch()){
    
        

        $transaction_type = trim($transaction_type);
    
            $stmt = $dbMain ->prepare("SELECT COUNT(*) as count  FROM billing_vault_id WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            
            if($count <= 0){
                $stmt = $dbMain ->prepare("SELECT email, street, city, state, zip, primary_phone  FROM contract_info WHERE contract_key= '$contract_key'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($email, $streetAddress, $city, $state, $zip, $primary_phone);
                $stmt->fetch();
                $stmt->close();
                
                
                
                if($transaction_type == 'CC'){
             //echo "<br><br><br>ckey $contract_key $transaction_type<br>";
        //echo "test";
                    $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
                    $stmt->execute();      
                    $stmt->store_result();      
                    $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
                    $stmt->fetch();
                    $stmt->close();
                    
                    
                    
                    $month = date('m',strtotime($card_exp_date));
                    $year = date('y',strtotime($card_exp_date));
                    $ccexp ="$month$year"; 
                    
                    $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
                    $vaultFunction = "add_customer";
                    $vaultId = "$contract_key";
                    $cvv = "";
                    $merch1 = "Creating Vault ID";
                    $orderId = "Create Vault $contract_key";
                     //echo "du";
                        //========================
                    $gw = new gwapi; 
                    $gw->setLogin("$user_name", "$password");
                    $gw->setBilling("$card_fname","$card_lname","","$streetAddress","", "$state",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
                    $r = $gw->doVaultCC($card_number, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1, $card_fname, $card_lname, $orderId);
                    $reasonCode = $gw->responses['response_code'];
                  
                    if($reasonCode == 100){
                        $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
                        $stmt = $dbMain->prepare($sql);
                        $stmt->bind_param('is', $contract_key, $vaultId);
                        $stmt->execute();
                        $stmt->close();
                        
                        $sql = "UPDATE batch_recurring_records SET vault_id = ?  WHERE contract_key = '$contract_key'";
                        $stmt = $dbMain->prepare($sql);
                        $stmt->bind_param('s', $vaultId);
                        $stmt->execute();                    
                        $stmt->close();
                    }
                    
                    
                 // echo "$contract_key $transaction_type $reasonCode<br>";
                   // exit;
            
            
           
            
        }elseif($transaction_type == 'ACH'){
            $expBool = 3;
           // echo "<br><br><br>ckey $contract_key $transaction_type<br>";
            $stmt = $dbMain ->prepare("SELECT account_fname, account_lname, account_number, routing_number, account_type FROM banking_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($account_fname, $account_lname, $bankAccountNumber, $bankRoutingNumber, $account_type_cmp);
            $stmt->fetch();
            $stmt->close();
            
            $payTypeFlag = "check";//"creditcard"; // '' or 'check'
            $vaultFunction = "add_customer";
            $vaultId = "$contract_key";
            $checkname = "$account_fname $account_lname";	//The name on the customer's ACH account.
            
            if($account_type_cmp == 'C'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($account_type_cmp == 'B'){
               $account_holder_type = "business";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($account_type_cmp == 'S'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "savings";//*** checking/savings
            }      
                        //========================
            $orderId = "Create Vault $contract_key";
            $merch1 = "Creating Vault ID";
            $gw = new gwapi;
            $gw->setLogin("$user_name", "$password");
            $gw->setBilling("$account_fname","$account_lname","","$streetAddress","", "$state",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
            $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merch1, $orderId);
            $reasonCode = $gw->responses['response_code'];
                  
            if($reasonCode == 100){
                    $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contract_key, $vaultId);
                    $stmt->execute();
                    $stmt->close();
                    
                    $sql = "UPDATE batch_recurring_records SET vault_id = ?  WHERE contract_key = '$contract_key'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('s', $vaultId);
                    $stmt->execute();                    
                    $stmt->close();
            }
        }
                
                
            }
         
     $contract_key = "";
     $transaction_type = "";
     $clubId = "";
}    
$stmt99->close();
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
   
//$billingDate = $this->day;// date('d');    
    
$this->serviceIdArray = "";



       
$counter = 1;
                //echo "$cycDay $cycDate $this->dueDate";
                
$crTotal = 0;
$achTotal = 0;
$totalBilling = 0;
               // echo "test";
$stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key, cycle_date, billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key != '' AND DAY(cycle_date) = '$this->day' AND (monthly_billing_type = 'CR' OR monthly_billing_type = 'BA') ORDER BY contract_key ASC");//>=
$stmt999->execute();     
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->cycleDate, $this->billingAmount, $monthly_billing_type); 
while($stmt999->fetch()){
    //echo "fubar<br>";
    
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
    
   

                    $this->statusCount = 0;
                    $this->prePayCount = 0;
                    $this->creditCount = 1;
                    $this->monthlySettledCount = 0;
                    
                    
                    $customerBillingDate = date('d',strtotime($this->cycleDate));
                    
                    if($this->day < $customerBillingDate){
                        $mStart = date('m')-1;//8;
                        $yStart = date('Y');
                        $billingDate = $this->day;//25;
                    }elseif($this->day == $customerBillingDate){
                        $mStart = date('m');//8;
                        $yStart = date('Y');
                        $billingDate = $this->day;//25;
                    }elseif($this->day > $customerBillingDate){
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
                            $stmt = $dbMain ->prepare("SELECT count(*) as count FROM batch_recurring_records WHERE contract_key ='$this->contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$yStart'");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($count == 0 AND $this->billingAmount > 0){
                              
                                $sql = "INSERT INTO batch_recurring_records VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                                $stmt = $dbMain->prepare($sql);
                                $stmt->bind_param('iiiisssssssssssssdssss',$pid, $batchId, $club_id, $this->contractKey, $vault_id, $recordBatched, $processed, $imported, $outstandingBalance, $paymentType, $transactionType, $authID, $transactionId, $attemptNumber, $mStart, $customerBillingDate, $yStart, $this->billingAmount, $response, $processorResponse, $avsResponse, $cvvResponse);
                                $stmt->execute();
                                $stmt->close();
                            }
                         
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
                         $vault_id = "0";
                         $this->statusCount = "";
                         $this->prePayCount =  "";
                         $this->creditCount =  "";
                         $this->monthlySettledCount = "";
                         $customerBillingDate = "";
                         $yearStart = "";
                         $mStart = "";
                         $transactionType = "";
                         $paymentType = "";
                         $yStart = "";
                         
                         
                         
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

$day = $_REQUEST['day'];
$ajaxSwitch = $_REQUEST['ajaxSwitch'];

if($ajaxSwitch == 1){
    
    $upload = new monthlyBillingSelector();
    $upload->setDay($day);
    $upload->fileMaker();
    $billCount = $upload->getCount();
    
    include"rateGuarenteeSelector.php";
    $upload2 = new rateFeeSelector();
    $upload2->setDay($day);
    $upload2->countRecord();
    $rfCount = $upload2->getCount();
    
    include"enhanceFeeSelector.php";
    $upload3 = new enhanceFeeSelector();
    $upload3->setDay($day);
    $upload3->countRecord();
    $efCount = $upload3->getCount();
    
    include"maintnenceFeeSelector.php";
    $upload4 = new maintnenceFeeSelector();
    $upload4->setDay($day);
    $upload4->countRecord();
    $mfCount = $upload4->getCount();
    
    
    $upload->doVaultIds();
    //include "verifyCreateVaultId.php";
}
echo "1|$billCount|$rfCount|$efCount|$mfCount";
exit;

?>