<?php
require"../nmi/nmiGatewayClass.php";
class receiveUpdaterFile{

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function fileMaker(){
    
$dbMain = $this->dbconnect();


$lines = file("../firstDataUpdaterFiles/AUDXMBUR.02122016.033808.TXT") or die ("cant open file");


foreach ($lines as $line) {
    $count99 == "";
    $past_due_amount == "";
    
    $firstTwoChars = substr($line,0,2);
    if ($firstTwoChars == "C1"){
       $response =  substr($line,59,6);//UPDATE EXPIRY CONTAC **04NS **05NS **06NS **11NS **12NS **19NS **30NS 
       $closedIndicator =  substr($line,65,1);
       $contractKey =  substr($line,45,13);
       $contractKey = trim($contractKey);
       $expDate =  substr($line,40,4);
       $cardNum =  substr($line,24,16);
       $cardNum = trim($cardNum);
       $association =  substr($line,23,1);
       $month = substr($expDate,0,2);
       $year =  substr($expDate,2,2);
       
       $account_status = "";
       $stmt = $dbMain->prepare("SELECT account_status FROM account_status  WHERE contract_key = '$contractKey'");//>=
       $stmt->execute();  
       $stmt->store_result();      
       $stmt->bind_result($account_status); 
       $stmt->fetch();
       $stmt->close();
       
       
    
            
       echo "<br>resppnse $response closedIND $closedIndicator contract key $contractKey expdate $expDate month $month year $year cardnum $cardNum assoc $association<br>";
       
       if ($closedIndicator == "C"){
         $closedMessage = "This credit card account has been closed.";
       }else{
        $closedMessage = "";
       }
       
       switch($response){
        case "UPDATE":
            
            
            $newExpDate = date('Y-m-d H:i:s',mktime(23,59,59,$month,28,$year));
            
            $sql = "UPDATE credit_info SET card_exp_date = ?, card_number = ?  WHERE contract_key = '$contractKey'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('ss', $newExpDate, $cardNum);
            $stmt->execute();
            $stmt->close();
    
            $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($clubId); 
            $stmt->fetch();
            $stmt->close();
    
                
                $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($userName, $password);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT card_fname, card_lname FROM credit_info WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($card_fname, $card_lname);
                $stmt->fetch();
                $stmt->close();
                
                if($count == 0){
                    $vaultFunction = "add_customer";
                    $merch1 = "Add CC Vault ID";
                }else{
                    $vaultFunction = "update_customer";
                    $merch1 = "Update CC Vault ID";
                }
                
                $ccnumber = $this->cardNumber;//"4111111111111111";
                
                $ccexp = "$month$year";//"1010";
                $cvv = "";
                //==================
                //$orderId = "CC Member Sales Pre-Auth";
                //$merchField1 = "CC Vault Update";
                $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
                //$vaultFunction = "update_customer";
                $vaultId = "$contractKey";
                $orderId = "Update $contractKey";
                //========================
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultCC($cardNum, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1, $card_fname, $card_lname, $orderId);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
                
                if($ccAuthReasonCode == 100 AND $count == 0){
                    $sql = "INSERT INTO billing_vault_id VALUES (?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contractKey, $vaultId); 
                    $stmt->execute();
                    $stmt->close(); 
                }
                
              if($account_status == 'CO'){
                 $status = "CU";
                 $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$contractKey'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('s', $status);
                 $stmt->execute();  
                 $stmt->close(); 
                 
                 $sql = "DELETE FROM billing_collections WHERE contract_key = '$contractKey'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->execute();  
                 $stmt->close(); 
                                        
                 $noteMessage2 = "The customer has been removed from collections.";
                }else{
                    $noteMessage2 = "";
                }                       
                
            
            $userId = 'NA';
        	$noteDate = date('Y-m-d H:i:s');
        	$amPm = 'NA';
        	$noteTopic = 'Updater';
        	$noteMessage = "Credit Card Number updated by account updater. $noteMessage2";
        	$noteCategory = 'MI';
        	$memberId = "0";
        	$priority = 'L';
        	$targetApp = 'MI';
        	
        	
        	$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
        	$stmt = $dbMain->prepare($sql);
        	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
        	$stmt->execute();
        	$stmt->close();
            
            
            $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM batch_recurring_records WHERE contract_key= '$contractKey' AND outstanding_balance = 'Y' AND processed = 'N'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($past_due_amount);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$contractKey'");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($contract_location, $contract_date); 
            $stmt->fetch();
            $stmt->close();
            
            $vault_id = 0;
            $stmt = $dbMain->prepare("SELECT vault_id FROM billing_vault_id  WHERE contract_key = '$contractKey'");//>=
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
            
            $pid = "";
            $processed = "N";
            $imported = "N";
            $recordBatched = "N";
            $outstandingBalance = "N"; 
            $paymentType = "PD";
            $authID = "";
            $transactionId = "";
            $attemptNumber = 1;
            $processorResponse = "";
            $response = "";
            $avsResponse = "";
            $cvvResponse = "";
            $mStart = date('m');
            $yStart = date('Y'); 
            $customerBillingDate = date('d');
            $batchId = "";      
            $transactionType = 'CC';                    
                             //echo "test;";
            $stmt = $dbMain ->prepare("SELECT count(*) as count FROM batch_recurring_records WHERE contract_key ='$contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$yStart'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($count99);
            $stmt->fetch();
            $stmt->close();
                            
            if ($count99 == 0 AND $past_due_amount > 0){
                              
                $sql = "INSERT INTO batch_recurring_records VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('iiiisssssssssssssdssss',$pid, $batchId, $club_id, $contractKey, $vault_id, $recordBatched, $processed, $imported, $outstandingBalance, $paymentType, $transactionType, $authID, $transactionId, $attemptNumber, $mStart, $customerBillingDate, $yStart, $past_due_amount, $response, $processorResponse, $avsResponse, $cvvResponse);
                $stmt->execute();
                $stmt->close();
            }
            
          
               
            
            
        break;
        case "EXPIRY":
            
            
            $newExpDate = date('Y-m-d H:i:s',mktime(23,59,59,$month,28,$year));
            
            $sql = "UPDATE credit_info SET card_exp_date = ?  WHERE contract_key = '$contractKey'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('s', $newExpDate);
            $stmt->execute();
            $stmt->close();
    
            $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($clubId); 
            $stmt->fetch();
            $stmt->close();
    
                $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($userName, $password);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT card_fname, card_lname FROM credit_info WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($card_fname, $card_lname);
                $stmt->fetch();
                $stmt->close();
                
                if($count == 0){
                    $vaultFunction = "add_customer";
                    $merch1 = "Add CC Vault ID";
                }else{
                    $vaultFunction = "update_customer";
                    $merch1 = "Update CC Vault ID";
                }
                
                $ccnumber = $this->cardNumber;//"4111111111111111";
                
                $ccexp = "$month$year";//"1010";
                $cvv = "";
                //==================
                //$orderId = "CC Member Sales Pre-Auth";
                //$merchField1 = "CC Vault Update";
                $orderId = "Update $contractKey";
                $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
                //$vaultFunction = "update_customer";
                $vaultId = "$contractKey";
                //========================
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultCC($cardNum, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1, $card_fname, $card_lname, $orderId);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
                
                if($ccAuthReasonCode == 100  AND $count == 0){
                    $sql = "INSERT INTO billing_vault_id VALUES (?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contractKey, $vaultId); 
                    $stmt->execute();
                    $stmt->close(); 
                }
            
             if($account_status == 'CO'){
                 $status = "CU";
                 $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$contractKey'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('s', $status);
                 $stmt->execute();  
                 $stmt->close(); 
                 
                 $sql = "DELETE FROM billing_collections WHERE contract_key = '$contractKey'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->execute();  
                 $stmt->close(); 
                                        
                 $noteMessage2 = "The customer has been removed from collections.";
                }else{
                    $noteMessage2 = "";
                }            
            
            $userId = 'NA';
        	$noteDate = date('Y-m-d H:i:s');
        	$amPm = 'NA';
        	$noteTopic = 'Updater';
        	$noteMessage = "Credit Card Number updated by account updater. $noteMessage2";
        	$noteCategory = 'MI';
        	$memberId = "0";
        	$priority = 'L';
        	$targetApp = 'MI';
            
        	$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
        	$stmt = $dbMain->prepare($sql);
        	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
        	$stmt->execute();
        	$stmt->close();
            
            
            $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM batch_recurring_records WHERE contract_key= '$contractKey' AND outstanding_balance = 'Y' AND processed = 'N'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($past_due_amount);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$contractKey'");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($contract_location, $contract_date); 
            $stmt->fetch();
            $stmt->close();
            
            $vault_id = 0;
            $stmt = $dbMain->prepare("SELECT vault_id FROM billing_vault_id  WHERE contract_key = '$contractKey'");//>=
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
            
            $pid = "";
            $processed = "N";
            $imported = "N";
            $recordBatched = "N";
            $outstandingBalance = "N"; 
            $paymentType = "PD";
            $authID = "";
            $transactionId = "";
            $attemptNumber = 1;
            $processorResponse = "";
            $response = "";
            $avsResponse = "";
            $cvvResponse = "";
            $mStart = date('m');
            $yStart = date('Y'); 
            $customerBillingDate = date('d');
            $batchId = "";      
            $transactionType = 'CC';                    
                             //echo "test;";
            $stmt = $dbMain ->prepare("SELECT count(*) as count FROM batch_recurring_records WHERE contract_key ='$contractKey' AND payment_type='$paymentType' AND cycle_start_month = '$mStart' AND cycle_start_day = '$customerBillingDate' AND cycle_start_year = '$yStart'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($count99);
            $stmt->fetch();
            $stmt->close();
                            
            if ($count99 == 0 AND $past_due_amount > 0){
                              
                $sql = "INSERT INTO batch_recurring_records VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('iiiisssssssssssssdssss',$pid, $batchId, $club_id, $contractKey, $vault_id, $recordBatched, $processed, $imported, $outstandingBalance, $paymentType, $transactionType, $authID, $transactionId, $attemptNumber, $mStart, $customerBillingDate, $yStart, $past_due_amount, $response, $processorResponse, $avsResponse, $cvvResponse);
                $stmt->execute();
                $stmt->close();
            }
            
        break;
        case "CONTAC":
            
            $stmt = $dbMain ->prepare("SELECT email, first_name, last_name FROM contract_info WHERE contract_key ='$contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($email, $first_name, $last_name);
            $stmt->fetch();
            $stmt->close();
            
            $stmt22 = $dbMain->prepare("SELECT contact_email, business_phone, business_nick, business_name FROM business_info WHERE bus_id = '1000'");
            $stmt22->execute();
            $stmt22->store_result();
            $stmt22->bind_result($contact_email, $business_phone, $business_nick, $business_name);
            $stmt22->fetch();
            $stmt22->close();
            
            $headers  = "From: $contact_email\r\n";
            $headers .= "Content-type: text/html\r\n";
                
            $message2 = "Hello $first_name $last_name, Your Credit Card on file at $business_name has been closed by your bank. Please email us at: $contact_email or call us at $business_phone, to update your card on file ASAP. Thank You, $business_nick";  
            //mail($email, "$business_name Failed Payments", $message2, $headers);
            
            
            
            
            
            if ($closedIndicator == "C"){
                        $stmt = $dbMain ->prepare("SELECT count(*) FROM batch_recurring_records WHERE payment_type = 'MS' AND outstanding_balance = 'Y' AND contract_key = '$contractKey'");
                        $stmt->execute();      
                        $stmt->store_result();      
                        $stmt->bind_result($countPast);
                        $stmt->fetch();
                        $stmt->close();  
                                
                        $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM batch_recurring_records WHERE outstanding_balance = 'Y' AND contract_key = '$contractKey'");
                        $stmt->execute();      
                        $stmt->store_result();      
                        $stmt->bind_result($amount);
                        $stmt->fetch();
                        $stmt->close(); 
                                    
                        $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_collections WHERE contract_key = '$contractKey'");
                        $stmt->execute();      
                        $stmt->store_result();      
                        $stmt->bind_result($count2);
                        $stmt->fetch();
                        $stmt->close();  
                                    
                        if($count2 == 0){
                            $collectionsDate = date('Y-m-d H:i:s');
                            $sql = "INSERT INTO billing_collections VALUES (?,?,?,?)";
                           	$stmt = $dbMain->prepare($sql);
                           	$stmt->bind_param('idis',$contractKey, $amount, $countPast, $collectionsDate);
                           	$stmt->execute();
                            $this->batchId = $stmt->insert_id;
                           	$stmt->close();
                                        
                            $status = "CO";
                            $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$contractKey'";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('s', $status);
                            $stmt->execute();  
                            $stmt->close(); 
                                        
                            $noteMessage = "The customers account has been closed by their bank. They have been sent to collections. Please contact.";
                            
                                    }
       }else{
            $noteMessage = "Please contact the customer about there card number. $closedMessage";
       }
            
            $userId = 'NA';
        	$noteDate = date('Y-m-d H:i:s');
        	$amPm = 'NA';
        	$noteTopic = 'Updater';
        	$noteCategory = 'MI';
        	$memberId = "0";
        	$priority = 'L';
        	$targetApp = 'MI';
            
        	$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
        	$stmt = $dbMain->prepare($sql);
        	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
        	$stmt->execute();
        	$stmt->close();
            
            
        break;
        default:
            $userId = 'NA';
        	$noteDate = date('Y-m-d H:i:s');
        	$amPm = 'NA';
        	$noteTopic = 'Updater';
        	$noteMessage = "An error occured when attempting to update this card number ERROR: $response.";
        	$noteCategory = 'MI';
        	$memberId = "0";
        	$priority = 'L';
        	$targetApp = 'MI';
            
        	$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
        	$stmt = $dbMain->prepare($sql);
        	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
        	$stmt->execute();
        	$stmt->close();
            
            
        break;
       }
       echo "<br>AMOUNT $past_due_amount<br>";
    }
    
    
       $firstTwoChars =  "";
       $response =  "";
       $closedIndicator =  "";
       $contractKey =  "";
       $expDate =  "";
       $cardNum =  "";
       $association =  "";
       $closedMessage = "";
    
    }

}
//==============================================================================================
}
$makeFile = new receiveUpdaterFile();
$makeFile->fileMaker();

?>