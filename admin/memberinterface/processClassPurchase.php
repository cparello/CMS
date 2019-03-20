<?php
require"../nmi/nmiGatewayClass.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}



//require "../cybersource/gatewayAuth.php";
//require "../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";

class processPayment {

private $achPayment = null;
private $bankName = null;
private $accountType = null;
private $accountName = null;
private $accountNumber = null;
private $abaNumber = null;

private $creditPayment = null;
private $cardType = null;
private $cardNumber = null;
private $cardName = null;
private $cardCvv = null;
private $cardMonth = null;
private $cardYear = null;

private $contractKey = null;
private $memberId = null;

private $paymentStatus = null;
private $transactionId = null;


function setAchPayment($achPayment) {
       $this->achPayment = $achPayment;
       }
function setBankName($bankName) {
       $this->bankName = $bankName;
       }       
function setAccountType($accountType) {
       $this->accountType = $accountType;
       }        
function setAccountName($accountName) {
       $this->accountName = $accountName;
       }         
function setAccountNumber($accountNumber) {
       $this->accountNumber = $accountNumber;
       }         
function setAbaNumber($abaNumber) {
       $this->abaNumber = $abaNumber;
       }         
       
       
function setCreditPayment($creditPayment) {
       $this->creditPayment = $creditPayment;
       }
function setCardType($cardType) {
       $this->cardType = $cardType;
       }
function setCardNumber($cardNumber) {
       $this->cardNumber = $cardNumber;
       }
function setCardName($cardName) {
       $this->cardName = $cardName;
       }
function setCardCvv($cardCvv) {
       $this->cardCvv = $cardCvv;
       }
function setCardMonth($cardMonth) {
       $this->cardMonth = $cardMonth;
       }
function setCardYear($cardYear) {
       $this->cardYear = $cardYear;
       }


function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setMemberId($memberId) {
       $this->memberId = $memberId;
       }



 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=================================================
//this will eventually send info to the payment processor
function processPayment() {

$fieldParse = new parseGatewayFields(); 
$fieldParse-> setCardName($this->cardName);
$fieldParse-> setAchName($this->accountName);
$fieldParse-> setCardType($this->cardType);
$fieldParse-> setAccountType($this->accountType);
$fieldParse-> setCardExpDate($this->cardYear);
$fieldParse-> parsePaymentFields();

  //reassign vars for CS Credit Cards
$ccFirstName = $fieldParse-> getCredtCardFirstName();
$ccLastName = $fieldParse-> getCredtCardLastName();
$ccCardType = $fieldParse-> getCardType();
$ccCardYear = $fieldParse-> getCardYear();  
$ccCardMonth = $this->cardMonth;
$ccCardNumber = $this->cardNumber;
$ccCardCvv = $this->cardCvv;



 $clubId = $_SESSION['location_id'];
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
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();

    
$amount = $this->creditPayment;
    
    //credit"";//
$ccnumber = $ccCardNumber;//"4111111111111111";
$ccexp = "$ccCardMonth$ccCardYear";//"1010";
$cvv = "$this->cardCvv";
    //==================
    $reference = "CMP Scheduler Purchase";
$vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
$orderId = "$reference $this->contractKey";
$merchField1 = "$reference $this->contractKey";
$payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
$dupSecs = 3000;
$track1 = $_SESSION['track1'];
$track2 = $_SESSION['track2'];
    //======================== 
    
$gw = new gwapi;
$gw->setLogin("$userName", "$password");
$r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $dupSecs, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
$ccAuthDecision = $gw->responses['responsetext'];
$vaultId = $gw->responses['customer_vault_id'];
$authCode = $gw->responses['authcode'];    
$transactionId = $gw->responses['transactionid'];
$ccAuthReasonCode = $gw->responses['response_code'];

 if($ccAuthReasonCode != 100) {
    /*$dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT description FROM cs_error_codes WHERE error_code = '$ccAuthReasonCode'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($description);
    $stmt->fetch();
    $stmt->close();*/
    
           $this->paymentStatus = "$ccAuthDecision: $description";
           $this->transactionId = $ccAuthReasonCode;  
      }else{      
           $this->paymentStatus = 1;
           $this->transactionId = $ccAuthRequestId;
      }


//$this->paymentStatus = 1;
//$this->transactionId= rand(1000,100000);



}
//=================================================
function getPaymentStatus() {
       return($this->paymentStatus);
       }
function getTransactionId() {
       return($this->transactionId);
       }


}
//------------------------------------------------------------------------------------

//echo"$cash_payment  $credit_payment  $check_payment";
//exit;


/*
if($cash_payment != 0) {
   $_SESSION['cash_payment'] = $cash_payment;
  }
if($credit_payment != 0) {
   $_SESSION['credit_payment'] = $credit_payment;
  }
if($check_payment != 0) {
   $_SESSION['check_payment'] = $check_payment;
  }
*/

$credit_payment = $_REQUEST['credit_payment'];
$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$cash_payment = $_REQUEST['cash_payment'];
$check_payment = $_REQUEST['check_payment'];
    
                 

if($credit_payment != 0) {
$process = new processPayment();
$process-> setContractKey($contract_key);
$process-> setCreditPayment($credit_payment);
$process-> setCardType($card_type);
$process-> setCardNumber($card_number);
$process-> setCardName($card_name);
$process-> setCardCvv($card_cvv);
$process-> setCardMonth($card_month);
$process-> setCardYear($card_year);

$process-> processPayment();
$payment_status = $process-> getPaymentStatus();
$transaction_id = $process-> getTransactionId();
  }else{
  $payment_status = 1;
  $trans_salt = 'CMP';
  $transaction_id = rand(1000,10000000);  
  $transaction_id = "$transaction_id$trans_salt";
  }


echo"$payment_status|$transaction_id";
exit;




?>