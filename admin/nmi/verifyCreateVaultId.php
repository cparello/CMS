<?php
//echo "test";
//exit;
require "nmiGatewayClass.php";
require "../dbConnect.php";

//echo "du";
//$ajaxSwitch = 1;//$_REQUEST['ajaxSwitch'];

//if($ajaxSwitch == 1){



$stmt99 = $dbMain ->prepare("SELECT contract_key, transaction_type, club_id FROM batch_recurring_records WHERE contract_key != '' AND processed = 'N' AND vault_id = ''");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($contract_key, $transaction_type);
while($stmt99->fetch()){
    
        $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($user_name, $password);
        $stmt->fetch();
        $stmt->close();

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
                     //echo "du";
                        //========================
                    $gw = new gwapi; 
                    $gw->setLogin("$user_name", "$password");
                    $gw->setBilling("$card_fname","$card_lname","","$streetAddress","", "$city",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
                    $r = $gw->doValidate($card_number, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1);
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
            $secCode = "PPD";
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
            $merch1 = "Creating Vault ID";
            $gw = new gwapi;
            $gw->setLogin("$user_name", "$password");
            $gw->setBilling("$account_fname","$account_lname","","$streetAddress","", "$city",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
            $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merch1, $secCode);
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
         
     
}    
$stmt99->close();


//}else{
//    echo "99";
//    exit;
//}
//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();

?>