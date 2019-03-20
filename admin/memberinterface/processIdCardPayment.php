<?php
require"../nmi/nmiGatewayClass.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
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

//for update
private $accountFirst = null;
private $accountMiddle = null;
private $accountLast = null;
private $nameSwitch = null;



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
function formatCreditDate() {

  $year_front = '20';
  $card_year = "$year_front$this->cardYear"; 
 
  
    switch ($this->cardMonth) {
         case "01":
        $card_day = "31";
        break;
        case "02":
        $card_day = "28";
        break;
        case "03":
        $card_day = "31";
        break;
        case "04":
        $card_day = "30";
        break;
        case "05":
        $card_day = "31";
        break;  
        case "06":
        $card_day = "30";
        break;
        case "07":
        $card_day = "31";
        break;
        case "08":
        $card_day = "31";
        break;    
        case "09":
        $card_day = "30";
        break;  
        case "10":
        $card_day = "31";
        break;  
        case "11":
        $card_day = "30";
        break;  
        case "12":
        $card_day = "31";
        break;        
     }
          
  $credit_date = "$card_year-$this->cardMonth-$card_day 23:59:59";
 

return $credit_date; 

}
//-------------------------------------------------------------------------------------
function parseAccountHolderName() {

if($this->nameSwitch == null) {
  $this->accountFirst = "";
  $this->accountMiddle = "";
  $this->accountLast = "";
  
  }else{
  
       $account_name_array = preg_split('/[\s]+/', $this->nameSwitch);
       $array_count = count($account_name_array);
    
       switch ($array_count) {
         case 0:
               $this->accountFirst = "";
               $this->accountMiddle = "";
               $this->accountLast = $this->nameSwitch;
        break;
        case 1:
             $this->accountFirst = "";
             $this->accountMiddle = "";
             $this->accountLast = $this->nameSwitch;
        break;
        case 2:
             $this->accountFirst = $account_name_array[0];
             $this->accountMiddle = "";
             $this->accountLast = $account_name_array[1];
        break;
        case 3:
             $this->accountFirst = $account_name_array[0];
             $this->accountMiddle = $account_name_array[1];
             $this->accountLast = $account_name_array[2];
        break;
        case 4:
            $this->accountFirst = $account_name_array[0];
            $this->accountMiddle = "";
            $this->accountLast = "$account_name_array[1] $account_name_array[2] $account_name_array[3]";
        break;
     }
   
 }

}
//---------------------------------------------------------------------------------------

//=============================================================================
function updateCardInfo() {
    
$dbMain = $this->dbconnect();

$this->preAuthStatus = 5;

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


      
    $ccnumber = $card_number;//"4111111111111111";
    $ccexp = "$this->cardMonth$this->cardYear";//"1010";
    $cvv = "$this->cardCvv";
    //==================
    $orderId = "CC Member Sales Pre-Auth $this->contractKey";
    $merchField1 = "CC Member Sales Pre-Auth";
    $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
    $vaultFunction = "";
    $vaultId = "$this->contractKey";
    //========================
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $r = $gw->doPreAuthCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $merchField1, $ccFirstName, $ccLastName, $orderId);
    $ccAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $preAuthReasonCode = $gw->responses['response_code'];
    
    
    $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if($count == 0){
                    $vaultFunction = "add_customer";
                    $merch1 = "Add CC Vault ID";
                    $orderId = "$merch1$this->contractKey";
    }else{
                    $vaultFunction = "update_customer";
                    $merch1 = "Update CC Vault ID";
                    $orderId = "$merch1$this->contractKey";
                }

 
    
  
 
  
    if($preAuthReasonCode == 100) {
        
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doVaultCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1, $ccFirstName, $ccLastName, $orderId);
        $ccAuthDecision = $gw->responses['responsetext'];
        $vaultId = $gw->responses['customer_vault_id'];
        $authCode = $gw->responses['authcode'];    
        $transactionId = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];
        
        
        
        
       $sql = "UPDATE credit_info SET card_fname= ?,  card_mname= ?, card_lname= ?, card_type= ?, card_number= ?, card_cvv= ?, card_exp_date= ? WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('sssssss', $cardFirst, $cardMiddle, $cardLast, $cardType, $cardNumber, $cardCvv, $expDate); 
        	
        //divide the name attribute of the account holder
        $this->nameSwitch = $this->cardName;
        $this->parseAccountHolderName();
         $cardFirst = $this->accountFirst;
         $cardMiddle = $this->accountMiddle;
         $cardLast = $this->accountLast;
         $cardType = $this->cardType;
         $cardNumber = $this->cardNumber;
         $cardCvv = $this->cardCvv;
         
        $expDate = $this->formatCreditDate();
        
         if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
        
        //backup for cc updates
        $sql = "INSERT INTO credit_info_updates VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('issssssss', $this->contractKey, $cardFirst, $cardMiddle, $cardLast, $cardType, $cardNumber, $cardCvv, $expDate, $todaysDate);
        
        $todaysDate = date("Y-m-d H:i:s");
           
         if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        $stmt->close();
       $this->preAuthStatus = 1;
              
      }


  
 

}
//-------------------------------------------------------------------------------------
//this will eventually send info to the payment processor
function processPayment() {
   
    if ($this->creditPayment != 0.00){
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


    
$club_id = $_SESSION['location_id'];
    
$dbMain = $this->dbconnect();


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
    
$amount = $this->creditPayment;
    
    //credit"";//
$ccnumber = $ccCardNumber;//"4111111111111111";
$ccexp = "$this->cardMonth$this->cardYear";//"1010";
$cvv = "$this->cardCvv";
    //==================
$reference = "CMP Balance";
$vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
$orderId = "$this->contractKey";
$merchField1 = "$reference $this->contractKey";
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

    
$gw = new gwapi;
$gw->setLogin("$userName", "$password");
$r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
$ccAuthDecision = $gw->responses['responsetext'];
$vaultId = $gw->responses['customer_vault_id'];
$authCode = $gw->responses['authcode'];    
$transactionId = $gw->responses['transactionid'];
$ccAuthReasonCode = $gw->responses['response_code'];
//echo "fubar $ccAuthReasonCode";
  //  exit;

 if($ccAuthReasonCode != 100) {
    
           $this->paymentStatus = "$ccAuthDecision: $ccAuthDecision";
           //$this->transactionId = $ccAuthReasonCode;  
      }else{      
        $_SESSION['cc_request_id'] = $authCode;
           $this->paymentStatus = 1;
           //$this->transactionId = $ccAuthRequestId;
      }
    }
    if ($this->creditPayment == 0.00){
        $this->paymentStatus = 1;
    }
}
//=================================================
function getPaymentStatus() {
       return($this->paymentStatus);
       }
function getPreAuthStatus() {
       return($this->preAuthStatus);
       }


}
//------------------------------------------------------------------------------------
//send to cybersource

$contract_key = $_REQUEST['contract_key'];
$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$contract_key = $_REQUEST['contract_key'];
$ach_payment = $_REQUEST['ach_payment'];
$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_number = $_REQUEST['account_number'];
$aba_number = $_REQUEST['aba_number'];
$credit_payment = $_REQUEST['credit_payment'];
$cc_update = $_REQUEST['cc_update'];


/*$cc_update = 1;
$contract_key = 24800;
$card_type = "Visa";
$card_number = "4111111111111111";
$card_name = "chris parello";
$card_cvv = 123;
$card_month = 12;
$card_year = 15;*/

if($cc_update == 1) {
 
  $update = new processPayment();
  $update-> setContractKey($contract_key);
  $update-> setCardType($card_type);
  $update-> setCardNumber($card_number);
  $update-> setCardName($card_name);
  $update-> setCardCvv($card_cvv);
  $update-> setCardMonth($card_month);
  $update-> setCardYear($card_year);
  $update-> updateCardInfo();
  $pre_auth_status = $update-> getPreAuthStatus();
  //echo "fubsr $pre_auth_status";
//exit; 

  //$update-> updateCSSubscription();
  }



if($credit_payment != "0") {
$process = new processPayment();
$process-> setContractKey($contract_key);
$process-> setAchPayment($ach_payment);
$process-> setBankName($bank_name);
$process-> setAccountType($account_type);
$process-> setAccountName($account_name);
$process-> setAccountNumber($account_number);
$process-> setAbaNumber($aba_number);
$process-> setCreditPayment($credit_payment);
$process-> setCardType($card_type);
$process-> setCardNumber($card_number);
$process-> setCardName($card_name);
$process-> setCardCvv($card_cvv);
$process-> setCardMonth($card_month);
$process-> setCardYear($card_year);
$process-> processPayment();
$payment_status = $process-> getPaymentStatus();


//$requestId = $this->transactionId;
//put the CS request id here
//$_SESSION['cc_request_id'] = $requestId;


}elseif($credit_payment == "0" AND $cc_update == 1 AND $pre_auth_status == 1) {
    $payment_status = 2;
}elseif ($pre_auth_status == 5){
$payment_status = 3;
}else{
   $payment_status = 1; 
}


echo"$payment_status";
exit;




?>