<?php
require"../../../../nmi/nmiGatewayClass.php";
session_start();
require "gatewayAuth.php";
//require "../../../cybersource/cybersourceSoapClient.php";
//echo "fubar";
//exit;
require"../../../../cybersource/parseGatewayFields.php";

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
require"../../../../dbConnect.php";
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
if(strlen($ccCardYear) == 4){
    $ccCardYear = substr($ccCardYear,2,2);
}



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
    
    
    
    


    $name = "$ccFirstName $ccLastName";
     $amount = $this->creditPayment;
    $reference = "CMP Website Scheduler Purchase";
        //credit"";//
        $ccnumber = $ccCardNumber;//"4111111111111111";
        $ccexp = "$ccCardMonth$ccCardYear";//"1010";
        $cvv = "";
            //==================
        //$vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
        $orderId = "$this->contractKey $reference";
        $merchField1 = "$this->contractKey $reference";
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        if(isset($_SESSION['track1'])){
            $track1 = $_SESSION['track1'];
        }else{
             $track1 = "";
        }
        if(isset($_SESSION['track2'])){
            $track2 = $_SESSION['track2'];
        }else{
             $track2 = "";
        }
        //$dupSecs = 3000;
            //======================== 
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
        
        $ccAuthDecision = $gw->responses['responsetext'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];


 if($ccAuthReasonCode != 100) {
    /*$dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT description FROM cs_error_codes WHERE error_code = '$ccAuthReasonCode'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($description);
    $stmt->fetch();
    $stmt->close();*/
    
           $this->paymentStatus = "$ccAuthDecision: $ccAuthReasonCode";
           $this->transactionId = $transaction_id;  
      }else{      
           $this->paymentStatus = 1;
           $this->transactionId = $transaction_id;
      }

/*}else{
     $this->paymentStatus = 1;
     $this->transactionId = "847TEST7723";
}*/
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
function getContractKey() {
       return($this->contractKey);
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
require"../../../../dbConnect.php"; 
$credit_payment = $_REQUEST['credit_payment'];
$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$cash_payment = $_REQUEST['cash_payment'];
$check_payment = $_REQUEST['check_payment'];
$memberId = $_REQUEST['memberId'];
$newNonMemBool = $_REQUEST['newNonMemBool'];   
$email = $_REQUEST['email'];

if($newNonMemBool == 1){
             
          $stmt = $dbMain ->prepare("SELECT contact_email FROM business_info WHERE bus_id='1000' ");
          $stmt->execute();      
          $stmt->store_result();      
          $stmt->bind_result($contact_email);
          $stmt->fetch();
          $stmt->close();
    
          $contract_key = null;
          $memberId = null;
          
          $sql = "INSERT INTO contract_keys VALUES (?)";
           $stmt = $dbMain->prepare($sql);
           $stmt->bind_param('i', $contract_marker);
           $contract_marker = null;
           if(!$stmt->execute())  {
            	printf("Error:contract_keys %s.\n", $stmt->error);
               }
            $contract_key = $stmt->insert_id; 
            $stmt->close();  
          
          $sql = "INSERT INTO web_barcodes VALUES (?, ?)";
          $stmt = $dbMain->prepare($sql);
          $stmt->bind_param('ii', $memberId, $contract_key);
          if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }
           
           $memberId = $stmt->insert_id; 
           $stmt->close(); 
           
           
           
           $msg = "Please use this barcode: $memberId to schedule for classes now. Your customer reference number is $contract_key.";
           $headers  = "From: $contact_email\r\n";
           $headers .= "Content-type: text/html\r\n";
           mail($email,"Barcode",$msg,$headers);
           
           
    }else{
        $stmt = $dbMain->prepare("SELECT contract_key FROM member_info WHERE member_id = '$memberId'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($contract_key);   
        $stmt->fetch();   
        $stmt->close();
        
    }
  

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


echo"$payment_status|$transaction_id|$contract_key|$memberId";
exit;




?>