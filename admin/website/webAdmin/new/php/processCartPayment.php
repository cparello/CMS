<?php
require"../../../../nmi/nmiGatewayClass.php";
session_start();
/*if (!isset($_SESSION['admin_access']))  {
exit;
}*/

$credit_payment = $_REQUEST['credit_payment'];
$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$contract_key = $_REQUEST['contract_key'];
$cash_payment = $_REQUEST['cash_payment'];
$check_payment = $_REQUEST['check_payment'];
$contractKey = $_REQUEST['contractKey'];
$cofBool  = $_REQUEST['cofBool'];            
  
if($cash_payment != 0) {
   $_SESSION['cash_payment'] = $cash_payment;
    $paymentType = 'CASH';
  }
if($credit_payment != 0 OR $cofBool == 2) {
   $_SESSION['credit_payment'] = $credit_payment;
   $paymentType = 'CREDIT';
  }
if($check_payment != 0) {
   $_SESSION['check_payment'] = $check_payment;
   $paymentType = 'CHECK';
  }

//process cc transaction if applicable 
if($credit_payment != 0) {
   
//echo "$contractKey $cofBool";
//exit;
 $clubId = $_SESSION['location_id'];
  
    require"../../../../dbConnect.php";
    if ($clubId == 0 OR $clubId == ""){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();
    
    $reference = "Web Sale";

  
      
        $amount = $credit_payment;
    
        //credit"";//
        $ccnumber = $card_number;//"4111111111111111";
        $ccexp = "$card_month$card_year";//"1010";
        $cvv = "$card_cvv";
            //==================
        $vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
        $orderId = "$contractKey";
        $merchField1 = "$reference $contractKey";
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        $track1 = $_SESSION['track1'];
        $track2 = $_SESSION['track2'];
        //$dupSecs = 3000;
            //======================== 
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2);
    
    
       
        $ccAuthDecision = $gw->responses['responsetext'];
        $vaultId = $gw->responses['customer_vault_id'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];

//print("\$gw->responses="); print_r($gw->responses); exit(); // !debug!
  
 if($ccAuthReasonCode != 100) {
           $payment_status = 2;
      }else{      
           $payment_status = 1;
           
      }

  }else{
  $payment_status = 1;
  $trans_salt = 'CMP';
  $transaction_id = rand(1000,10000000);  
  $transaction_id = "$transaction_id$trans_salt";
  $transToken = "";
  $card_type = "";
  $card_month = "";
  $card_year = "";
  }
echo"$payment_status|$paymentType|$transaction_id|$transToken|$card_type|$card_month|$card_year";
exit;




?>