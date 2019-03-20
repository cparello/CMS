<?php
require"../nmi/nmiGatewayClass.php";
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}


require"../dbConnect.php";


//============================================
$card_name=$_REQUEST['card_name'];
$card_number=$_REQUEST['card_number'];
$card_month=$_REQUEST['card_month'];
$card_year=$_REQUEST['card_year'];
$ajax_switch=$_REQUEST['ajax_switch'];
$contractKey=$_REQUEST['contractKey'];
//here is where we format the variables 


if($ajax_switch == "1"){
  
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($club_id); 
        $stmt->fetch();
        $stmt->close();
         
        
        $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$club_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($userName, $password);
        $stmt->fetch();
        $stmt->close();
        
        $cardBuff = explode(' ',$card_name);
        $fname = $cardBuff[0];
        $lname = $cardBuff[1];
        $ccnumber = $card_number;//"4111111111111111";
        $ccexp = "$card_month$card_year";//"1010";
        $cvv = "";
        
        $orderId = "CC Billing Pre-Auth $contractKey";
        $merchField1 = "CC Billing Pre-Auth $contractKey";
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        $vaultFunction = "";
        $vaultId = "$contractKey";
       
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doPreAuthCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $merchField1, $fname, $lname, $orderId);
        $ccAuthDecision = $gw->responses['responsetext'];
        $authCode = $gw->responses['authcode'];    
        $transactionId = $gw->responses['transactionid'];
        $preAuthReasonCode = $gw->responses['response_code'];
      
      if($preAuthReasonCode == 100){
                $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                
                if($count == 0){
                    $vaultFunction = "add_customer";
                    $merch1 = "Add CC Vault ID $contractKey";
                    
                    $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $contractKey, $vaultId); 
                    $stmt->execute();
                    $stmt->close();
                }else{
                    $vaultFunction = "update_customer";
                    $merch1 = "Update CC Vault ID $contractKey";
                }
                
                
                $gw = new gwapi;
                $gw->setLogin("$userName", "$password");
                $r = $gw->doVaultCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1, $fname, $lname, $merch1);
                $ccAuthDecision = $gw->responses['responsetext'];
                $authCode = $gw->responses['authcode'];    
                $transactionId = $gw->responses['transactionid'];
                $ccAuthReasonCode = $gw->responses['response_code'];
                
                if($ccAuthReasonCode == 100){
                    echo"1|$ccAuthReasonCode|$ccAuthDecision";
                    exit;       
                }else{
                     echo"2|$ccAuthReasonCode|$ccAuthDecision";
                     exit;
                }
      }
      
      
      
     /*  $ccnumber = $card_number;//"4111111111111111";
    $ccexp = "$card_month$card_year";//"1010";
    $cvv = "";
    //==================
    //$orderId = "CC Member Sales Pre-Auth";
    $merchField1 = "CC Member Sales Pre-Auth";
    $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
    $vaultFunction = "";
    $vaultId = "";
    //========================
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $r = $gw->doValidate($ccnumber, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1);
    $ccAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $ccAuthReasonCode = $gw->responses['response_code'];

    if($ccAuthReasonCode != 100) {
       
         echo"2|$ccAuthReasonCode|$ccAuthDecision";
         exit;
  
      }else{
          echo"1|$ccAuthReasonCode|$ccAuthDecision";
          exit;       

      }*/

}

?>