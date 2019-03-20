<?php
require"../dbConnect.php";
require "nmiGatewayClass.php";

$stmt23 = $dbMain->prepare("SELECT vault_id FROM billing_vault_id  WHERE vault_id != ''");//>=
$stmt23->execute();  
$stmt23->store_result();      
$stmt23->bind_result($vault_id); 
while($stmt23->fetch()){
    
    $stmt999 = $dbMain->prepare("SELECT monthly_billing_type FROM monthly_payments  WHERE contract_key = '$vault_id'");//>=
    $stmt999->execute();     
    $stmt999->store_result();      
    $stmt999->bind_result($monthly_billing_type); 
    $stmt999->fetch();
    $stmt999->close();
    
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
    
    $stmt = $dbMain ->prepare("SELECT email, street, city, state, zip, primary_phone  FROM contract_info WHERE contract_key= '$vault_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($email, $streetAddress, $city, $state, $zip, $primary_phone);
    $stmt->fetch();
    $stmt->close();
    
    if(preg_match('/none/',$email)){
        $email = "";
    }elseif(preg_match('/email/',$email)){
        $email = "";
    }
                
                
                
    if($monthly_billing_type == 'CR'){
             //echo "<br><br><br>ckey $vault_id $transaction_type<br>";
        //echo "test";
        $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$vault_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
        $stmt->fetch();
        $stmt->close();
                    
        $month = date('m',strtotime($card_exp_date));
        $year = date('y',strtotime($card_exp_date));
        $ccexp ="$month$year"; 
                    
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        $vaultFunction = "update_customer";
        $vaultId = "$vault_id";
        $cvv = "";
        $merch1 = "Update Vault ID";
        $orderId = "Update Vault $vault_id";
                     //echo "du";
                        //========================
        $gw = new gwapi; 
        $gw->setLogin("$user_name", "$password");
        $gw->setBilling("$card_fname","$card_lname","","$streetAddress","", "$city",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
        $r = $gw->doVaultCC($card_number, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1, $card_fname, $card_lname, $orderId);
        $reasonCode = $gw->responses['response_code'];
                  
                    if($reasonCode == 100){
                        echo "good $vaultId<br>";
                    }else {"failed $vaultId<br>";}
                    
                    
                 // echo "$contract_key $transaction_type $reasonCode<br>";
                   // exit;
            
            
           
            
        }elseif($monthly_billing_type == 'BA'){
            $expBool = 3;
           // echo "<br><br><br>ckey $vault_id $transaction_type<br>";
            $stmt = $dbMain ->prepare("SELECT account_fname, account_lname, account_number, routing_number, account_type FROM banking_info WHERE contract_key= '$vault_id'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($account_fname, $account_lname, $bankAccountNumber, $bankRoutingNumber, $account_type_cmp);
            $stmt->fetch();
            $stmt->close();
            
            $payTypeFlag = "check";//"creditcard"; // '' or 'check'
            $secCode = "PPD";
            $vaultFunction = "update_customer";
            $vaultId = "$vault_id";
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
            $orderId = "Update Vault $vault_id";
            $merch1 = "Update Vault ID";
            $gw = new gwapi;
            $gw->setLogin("$user_name", "$password");
            $gw->setBilling("$account_fname","$account_lname","","$streetAddress","", "$city",
        "$state","$zip","US","$primary_phone","$primary_phone","$email",
        "");
            $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merch1, $orderId, $secCode);
            $reasonCode = $gw->responses['response_code'];
                  
             if($reasonCode == 100){
                        echo "good $vaultId<br>";
                    }else {"failed $vaultId<br>";}
        }
                
                          
                      
    $vault_id = "";                  
}
$stmt23->close();


?>