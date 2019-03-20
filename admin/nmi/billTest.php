 <?php
 require"../dbConnect.php";
 require"nmiGatewayClass.php";

 $stmt99 = $dbMain ->prepare("SELECT contract_key FROM billing_vault_id WHERE contract_key != ''");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($contract_key);
    while($stmt99->fetch()){
        //echo "test";
                $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$contract_key'");//>=
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
                
                $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$club_id'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($userName, $password);
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
                $stmt->fetch();
                $stmt->close();
                
             //  echo "test";
                
             //   $ccnumber = $this->cardNumber;//"4111111111111111";
                
                $ccexp = date('my',strtotime($card_exp_date));
                $cvv = "";
                //==================
                //$orderId = "CC Member Sales Pre-Auth";
                $merchField1 = "CC Vault Update $contract_key";
                $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
                $vaultFunction = "update_customer";
                $vaultId = "$contract_key";
                $orderId = "Update $contract_key";
                //======================== 
                
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultCC($card_number, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1, $card_fname, $card_lname, $merchField1);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
        
        
                echo "$contract_key  $ccAuthReasonCode $ccAuthDecision<br>";
                //exit;
                }
            
            $stmt99->close();
            
            
            ?>