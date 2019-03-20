<?php
require"nmiGatewayClass.php";
class receiveUpdaterFile{

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function fileMaker(){
    
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, MIN(club_id) FROM billing_gateway_fields WHERE club_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($userName, $password, $clubId);
$stmt->fetch();
$stmt->close();

//echo "$userName, $password";
//exit;

$stmt33 = $dbMain ->prepare("SELECT DISTINCT contract_key, transaction_type, vault_id FROM batch_recurring_records WHERE contract_key != ''");
$stmt33->execute();      
$stmt33->store_result();      
$stmt33->bind_result($contractKey, $monthly_billing_type, $vault_id);
while($stmt33->fetch()){
    
            if($vault_id == 0){
                $vaultFunction = "add_customer";
            }else{
                $vaultFunction = "update_customer";
                
            }
            
            
            $vaultId = "$contractKey";
            
            if($monthly_billing_type == 'CC'){
                $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_type, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($check_fname, $check_lname, $card_type, $card_number, $card_exp_date);
                $stmt->fetch();
                $stmt->close(); 
                
                $check_fname = trim($check_fname);
                $check_lname = trim($check_lname);
                
                if ($check_fname = "" or $check_lname = ""){
                    $stmt = $dbMain ->prepare("SELECT first_name, last_name, MAX(contract_date) FROM contract_info WHERE contract_key= '$contractKey'");
                    $stmt->execute();      
                    $stmt->store_result();      
                    $stmt->bind_result($check_fname, $check_lname, $contract_date);
                    $stmt->fetch();
                    $stmt->close(); 
                }
                $card_exp_date = strtotime($card_exp_date);
                
                $month = date('m',$card_exp_date);
                $year = date('y',$card_exp_date);
                
                $merch1 = "Update CC Vault ID";
                $ccexp = "$month$year";//"1010";
                $cvv = "";
                
                $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
                
                $orderId = "Update $contractKey";
                //========================
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultCC($card_number, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $contractKey, $merch1, $check_fname, $check_lname, $orderId);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
                
                if($ccAuthReasonCode == 100 AND $vault_id == 0){
                    $sql = "INSERT INTO billing_vault_id VALUES (?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contractKey, $contractKey); 
                    $stmt->execute();
                    $stmt->close(); 
                    
                    $sql = "UPDATE batch_recurring_records SET vault_id = ?  WHERE contract_key = '$contractKey'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('s', $contractKey);
                    $stmt->execute();                    
                    $stmt->close();
                }
                
            }else if ($monthly_billing_type == 'BA'){
                
                $stmt = $dbMain ->prepare("SELECT account_fname, account_lname, account_number, routing_number, account_type FROM banking_info WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($check_fname, $check_lname, $bankAccountNumber, $bankRoutingNumber, $account_type_cmp);
                $stmt->fetch();
                $stmt->close(); 
                
                $check_fname = trim($check_fname);
                $check_lname = trim($check_lname);
                
                if ($check_fname = "" or $check_lname = ""){
                    $stmt = $dbMain ->prepare("SELECT first_name, last_name, MAX(contract_date) FROM contract_info WHERE contract_key= '$contractKey'");
                    $stmt->execute();      
                    $stmt->store_result();      
                    $stmt->bind_result($check_fname, $check_lname, $contract_date);
                    $stmt->fetch();
                    $stmt->close(); 
                }
                
                $payTypeFlag = "check";
                
                
                $checkName = "$check_fname $check_lname";
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
                $orderId = "Create Vault $contractKey";
                $merch1 = "Creating Vault ID";
                
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkName, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merch1, $orderId);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
                
                if($ccAuthReasonCode == 100 AND $vault_id == 0){
                    $sql = "INSERT INTO billing_vault_id VALUES (?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contractKey, $contractKey); 
                    $stmt->execute();
                    $stmt->close(); 
                    
                    $sql = "UPDATE batch_recurring_records SET vault_id = ?  WHERE contract_key = '$contractKey'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('s', $contractKey);
                    $stmt->execute();                    
                    $stmt->close();
                }
            }
            
            
      
        echo "contract key  $contractKey bill type $monthly_billing_type mon $month year $year decision $ccAuthDecision auth $authCode  <br> <br>";   
              
       $vault_id = "";
       $monthly_billing_type =  "";
       $month =  "";
       $year =  "";
       $contractKey =  "";
       $check_fname =  "";
       $check_lname =  "";
       $card_type =  "";
       $card_number =  "";
       $card_exp_date =  "";
       $contract_date =  "";
       $bankAccountNumber =  "";
       $bankRoutingNumber =  "";
       $account_type_cmp =  "";
       $response =  "";
       $closedIndicator =  "";
       $contractKey =  "";
       $expDate =  "";
       $cardNum =  "";
       $association =  "";
       $closedMessage = "";
       $vaultFunction = "";
    
    }
$stmt33->close();

 

}
//==============================================================================================
}
$makeFile = new receiveUpdaterFile();
$makeFile->fileMaker();

?>