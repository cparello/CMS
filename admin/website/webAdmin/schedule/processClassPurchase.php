<?php
session_start();
require "gatewayAuth.php";
require "../../../cybersource/cybersourceSoapClient.php";
require"../../../cybersource/parseGatewayFields.php";
//===============================================================================================
class SoapClientHMAC extends SoapClient {
  public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
	global $context;
	require"../../../../dbConnect.php";

    $clubId = $_SESSION['location_id'];

    if ($clubId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }

    $stmt = $dbMain ->prepare("SELECT hmac, key_id FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($hmackey, $keyid);
    $stmt->fetch();
    $stmt->close();
     // <-- Insert the Key ID here
	$hashtime = date("c");
	$hashstr = "POST\ntext/xml; charset=utf-8\n" . sha1($request) . "\n" . $hashtime . "\n" . parse_url($location,PHP_URL_PATH);
	$authstr = base64_encode(hash_hmac("sha1",$hashstr,$hmackey,TRUE));
	if (version_compare(PHP_VERSION, '5.3.11') == -1) {
		ini_set("user_agent", "PHP-SOAP/" . PHP_VERSION . "\r\nAuthorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request));
	} else {
		stream_context_set_option($context,array("http" => array("header" => "authorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request))));
	}
    return parent::__doRequest($request, $location, $action, $version, $one_way);
  }
  
  public function SoapClientHMAC($wsdl, $options = NULL) {
	global $context;
	$context = stream_context_create();
	$options['stream_context'] = $context;
	return parent::SoapClient($wsdl, $options);
  }
}
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



$clubId = $_SESSION['location_id'];
    $dbMain = $this->dbconnect();
    if ($clubId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, languagefd, link FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($gatewayID, $password, $language, $link);
    $stmt->fetch();
    $stmt->close();
        
    $transactionType = "00";
    $name = "$ccFirstName $ccLastName";
    $reference = "CMP Website Scheduler Purchase";
    $trxnProperties = array(
                      "User_Name"=>"",
                      "Secure_AuthResult"=>"",
                      "Ecommerce_Flag"=>"R",   // 2 = recurring   R= retail
                      "XID"=>"",
                      "ExactID"=>"$gatewayID",				    //Payment Gateway
                      "CAVV"=>"",
                      "Password"=>"$password",					                //Gateway Password
                      "CAVV_Algorithm"=>"",
                      "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                      "Reference_No"=>$reference,
                      "Customer_Ref"=>$merchant_reference_code,
                      "Reference_3"=>$_POST["tbPOS_Reference_3"],
                      "Client_IP"=>"",					                    //This value is only used for fraud investigation.
                      "Client_Email"=>"",			//This value is only used for fraud investigation.
                      "Language"=>$language,				//English="en" French="fr"
                      "Card_Number"=>$ccCardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$ccCardMonth . $ccCardYear,//This value should be in the format MM/YY.
                      "CardHoldersName"=>$name,
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>$_POST["tbPOS_Authorization_Num"],
                      "Transaction_Tag"=>$_POST["tbPOS_Transaction_Tag"],
                      "DollarAmount"=>$this->creditPayment,
                      "VerificationStr1"=>$_POST["tbPOS_VerificationStr1"],
                      "VerificationStr2"=>"",
                      "CVD_Presence_Ind"=>"",
                      "Secure_AuthRequired"=>"",
                      "Currency"=>"",
                      "PartialRedemption"=>"",
                      
                      // Level 2 fields 
                      "ZipCode"=>$_POST["tbPOS_ZipCode"],
                      "Tax1Amount"=>$_POST["tbPOS_Tax1Amount"],
                      "Tax1Number"=>$_POST["tbPOS_Tax1Number"],
                      "Tax2Amount"=>$_POST["tbPOS_Tax2Amount"],
                      "Tax2Number"=>$_POST["tbPOS_Tax2Number"],
                      
                      "SurchargeAmount"=>$_POST["tbPOS_SurchargeAmount"],	//Used for debit transactions only
                      "PAN"=>$_POST["tbPOS_PAN"]							//Used for debit transactions only
                      );
                   
                    
      $client = new SoapClientHMAC($link);
      $trxnResult = $client->SendAndCommit($trxnProperties);
                    
      $ccAuthRequestId = $trxnResult->Authorization_Num;
      $ccAuthReasonCode = $trxnResult->Bank_Resp_Code;
      $ccAuthDecision = $trxnResult->Bank_Message;    



/*$authOptions = new gatewayAuth();
  $authOptions-> loadGatewayOptions();
  $merchantId = $authOptions-> getMerchantId();
  $transactionKey = $authOptions-> getTransactionKey();
  $accessLink = $authOptions-> getAccessLink();

  define( 'MERCHANT_ID', $merchantId );
  define( 'TRANSACTION_KEY', $transactionKey);
  define( 'WSDL_URL', $accessLink);

  //first check the cc card for validation
  $request = new stdClass();
  $request->merchantID = MERCHANT_ID;
  $request->merchantReferenceCode = "CMP Scheduler Purchase";
  $request->clientLibrary = "PHP";
  $request->clientLibraryVersion = phpversion();
  $request->clientEnvironment = php_uname();  

    $ccAuthService = new stdClass();
    $ccCaptureService = new stdClass();
    $billTo = new stdClass();
    $businessRules = new stdClass();
    $card = new stdClass();
    $purchaseTotals = new stdClass();
	$item = new stdClass();   
	$pos = new stdClass();
  
   	$ccAuthService->run = "true";
  	$ccAuthService->commerceIndicator = "retail";
    $request->ccAuthService = $ccAuthService;
    
    $ccCaptureService->run = "true";
    $request->ccCaptureService = $ccCaptureService;
  
////////////////////////////////////////////////////////////////////////////////////////////////
 
    $pos->cardPresent = "Y";
    $pos->terminalCapability = "2";
    $pos->entryMode = "keyed";
    $request->pos = $pos;
  
	$billTo->firstName = $ccFirstName;
	$billTo->lastName = $ccLastName;
    $billTo->street1 = "NA";
	$billTo->city = "NA";
	$billTo->state = "CA";
	$billTo->postalCode = "11111";
	$billTo->country = "US";
    $billTo->email = "null@ANY.com";
	$request->billTo = $billTo;
	
    $businessRules->ignoreAVSResult = "true";
    $request->businessRules = $businessRules;
    
    $card->accountNumber = $ccCardNumber;
	$card->expirationMonth = $ccCardMonth;
	$card->expirationYear = $ccCardYear;
	$card->cardType = $ccCardType;
	$card->cvIndicator = "1";
	$card->cvNumber = $ccCardCvv;
	$request->card = $card;

	$purchaseTotals->currency = "USD";
	$request->purchaseTotals = $purchaseTotals;
	
	$item->unitPrice = $this->creditPayment;
	$item->quantity = "1";
	$item->id = "0";
	$request->item = array($item);	
	
	$soapClient = new ExtendedClient(WSDL_URL, array());	
	$reply = $soapClient->runTransaction($request);	
	$ccAuthDecision = $reply->decision;
	$ccAuthReasonCode = $reply->reasonCode;
	$ccAuthRequestId = $reply->requestID;*/

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