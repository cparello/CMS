<?php
include "salesSql.php";
include"gatewayAuth.php";
include"../../cybersource/cybersourceSoapClient.php";
include"../../cybersource/parseGatewayFields.php";
session_start();
$clubId = $_REQUEST['clubId'];
$_SESSION['location_id'] = $clubId;

//========================================================================================
class SoapClientHMAC extends SoapClient {
  public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
	global $context;
	require"../../dbConnect.php";

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


//=======================================================
require"../../dbConnect.php";
    if ($clubId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }
   // echo "club id $club_id";
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, languagefd, link FROM billing_gateway_fields WHERE club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gatewayID, $password, $language, $link);
$stmt->fetch();
$stmt->close();
//===========================================
//===========================================
$authOptions = new gatewayAuth();
$authOptions-> loadGatewayOptions();
$merchantId = $authOptions-> getMerchantId();
$transactionKey = $authOptions-> getTransactionKey();
$accessLink = $authOptions-> getAccessLink();

define( 'MERCHANT_ID', $merchantId );
define( 'TRANSACTION_KEY', $transactionKey);
define( 'WSDL_URL', $accessLink);
//============================================
//echo "$clubId";
//exit;
$card_type=$_REQUEST['card_type'];
$card_name=$_REQUEST['card_name'];
$card_number=$_REQUEST['card_number'];
$card_cvv=$_REQUEST['card_cvv'];
$card_month=$_REQUEST['card_month'];
$card_year=$_REQUEST['card_year'];
$credit_pay=$_REQUEST['credit_pay'];
$bank_name=$_REQUEST['bank_name'];
$account_type=$_REQUEST['account_type'];
$account_name=$_REQUEST['account_name'];
$account_number=$_REQUEST['account_number'];
$routing_number=$_REQUEST['routing_number'];
$account_street=$_REQUEST['account_street'];
$account_city=$_REQUEST['account_city'];
$account_state=$_REQUEST['account_state'];
$account_zip=$_REQUEST['account_zip'];
$account_phone=$_REQUEST['account_phone'];
$account_email=$_REQUEST['account_email'];
$lic_number=$_REQUEST['lic_number'];
$ach_pay=$_REQUEST['ach_pay'];
$merchant_reference_code=$_REQUEST['merchant_reference_code'];
$totalServiceArray=$_REQUEST['totalServiceArray'];
$totalGearArray=$_REQUEST['totalGearArray'];
$transactionBool = 0;


if($credit_pay != "" ||  $ach_pay != "") {
    
$totalServiceArray = urldecode($totalServiceArray);
$totalGearArray = urldecode($totalGearArray);
$totalServiceArray = trim($totalServiceArray);
$totalGearArray = trim($totalGearArray);

//here is where we format the variables 
$card_type = urldecode($card_type);
$card_name = urldecode($card_name);
$card_number = urldecode($card_number);
$card_cvv = urldecode($card_cvv);
$card_month = urldecode($card_month);
$card_year = urldecode($card_year);
$credit_pay = urldecode($credit_pay);

$card_type = trim($card_type);
$card_name = trim($card_name);
$card_number = trim($card_number);
$card_cvv = trim($card_cvv);
$card_month = trim($card_month);
$card_year = trim($card_year);
$credit_pay = trim($credit_pay);


$bank_name = urldecode($bank_name);
$account_type = urldecode($account_type);
$account_name = urldecode($account_name);
$account_number = urldecode($account_number);
$routing_number = urldecode($routing_number);
$account_street = urldecode($account_street);
$account_city = urldecode($account_city);
$account_state = urldecode($account_state);
$account_zip = urldecode($account_zip);
$account_phone = urldecode($account_phone);
$account_email = urldecode($account_email);
$lic_number = urldecode($lic_number);
$ach_pay = urldecode($ach_pay);

$bank_name = trim($bank_name);
$account_type = trim($account_type);
$account_name = trim($account_name);
$account_number =trim($account_number);
$routing_number = trim($routing_number);
$account_street = trim($account_street);
$account_city = trim($account_city);
$account_state = trim($account_state);
$account_zip = trim($account_zip);
$account_phone = trim($account_phone);
$account_email = trim($account_email);
$lic_number = trim($lic_number);
$ach_pay = trim($ach_pay);

//echo"$account_street";
//exit;

//replace anything that is not a number for cc routing number bank account number
$card_number = preg_replace("/[^0-9 .]+/", "" ,$card_number);
$routing_number = preg_replace("/[^0-9 .]+/", "" ,$routing_number);
$account_number = preg_replace("/[^0-9 .]+/", "" ,$account_number);

//create marker for type of transactions
$achBool = $ach_pay;
$ccBool = $credit_pay;
if($achBool == 0) {
  $achBool = "";
  }
if($ccBool == 0) {
  $ccBool = "";
  }

$ach_pay = number_format($ach_pay, 2, '.', '');
$credit_pay = number_format($credit_pay, 2, '.', '');

  $fieldParse = new parseGatewayFields(); 
  $fieldParse-> setCardName($card_name);
  $fieldParse-> setAchName($account_name);
  $fieldParse-> setCardType($card_type);
  $fieldParse-> setAccountType($account_type);
  $fieldParse-> setAccountPhone($account_phone);
  //$fieldParse-> setCardYear($card_year);
  $fieldParse-> parsePaymentFields();
 
  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
 // $ccCardYear = $fieldParse-> getCardYear();
  $ccCardYear = $card_year;
  $ccCardMonth = $card_month;
  $ccCardNumber = $card_number;
  $ccCardCvv = $card_cvv;
  $ccCardPayment = $credit_pay;
  
 // echo"$ccCardCvv";
//  exit;

  //reassign vars for ACH  
  $achFirstName = $fieldParse-> getAchFirstName();
  $achLastName = $fieldParse-> getAchLastName();  
  $achStreetAddress = $account_street;
  $achCity = $account_city;
  $achState = $account_state;
  $achZip = $account_zip;
  $achPhone = $fieldParse-> getAccountPhone(); 
  $achEmail = $account_email;
  $achDriversLic = $lic_number;
  $achAccountType = $fieldParse-> getAccountType();
  $achRoutingNumber = $routing_number;
  $achAccountNumber = $account_number;
  $achPayment = $ach_pay;

//echo"ACH: $achCity  CC: $achState";
//exit;

//#######################################################################################
//do comparisons for cc and  ach.  If both are not null then we do a pre authorization. Also parsse vars for cs
if($achBool != "" &&  $ccBool != "") {
// echo "rest $accessLink $transactionKey $merchantId";
//exit;
    //first check the cc card for validation
   /* $request = new stdClass();
    $request->merchantID = MERCHANT_ID;
    $request->merchantReferenceCode = "CC Website Member Sales";
    $request->clientLibrary = "PHP";
    $request->clientLibraryVersion = phpversion();
    $request->clientEnvironment = php_uname();  
    
    $ccAuthService = new stdClass();	
    $billTo = new stdClass();
    $businessRules = new stdClass();
    $card = new stdClass();
    $purchaseTotals = new stdClass();
	$item = new stdClass();   
	$pos = new stdClass();
	   
  	$ccAuthService->run = "true";
  	$ccAuthService->commerceIndicator = "retail";
    $request->ccAuthService = $ccAuthService;
    
    $pos->cardPresent = "Y";
    $pos->terminalCapability = "2";
    $pos->entryMode = "keyed";
    $request->pos = $pos;
  
	$billTo->firstName = $ccFirstName;
	$billTo->lastName = $ccLastName;
    $billTo->street1 = $account_street;
	$billTo->city = $account_city;
	$billTo->state = $account_state;
	$billTo->postalCode = $account_zip;
	$billTo->country = "US";
    $billTo->email = $account_email;
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
	
	$item->unitPrice = $ccCardPayment;
	$item->quantity = "1";
	$item->id = "0";
	$request->item = array($item);	
	
	$soapClient = new ExtendedClient(WSDL_URL, array());	
	$reply = $soapClient->runTransaction($request);	
	$ccAuthDecision = $reply->decision;
	$ccAuthReasonCode = $reply->reasonCode;
	$ccAuthRequestId = $reply->requestID;
    
//-------------------------------------------------------------------------------
//check bank info next if auth on cc was sucessful
if($ccAuthReasonCode != 100) {
  $card_result = 'The Credit Card that was entered has been DECLINED';
  echo"$card_result";
  exit;
  
  }else{*/
    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;
        
    $request = new stdClass();
    $request->merchantID = MERCHANT_ID;
    $request->merchantReferenceCode = "ACH Website Member Sales";
    $request->clientLibrary = "PHP";
    $request->clientLibraryVersion = phpversion();
    $request->clientEnvironment = php_uname();  
    
    $ecDebitService = new stdClass();
    $billTo = new stdClass();
    $item = new stdClass();
    $purchaseTotals = new stdClass();
    $check = new stdClass();
  
    $ecDebitService->run = "true";
    $ecDebitService->paymentMode = "0";
    $request->ecDebitService = $ecDebitService;
    
	$billTo->firstName = $achFirstName;
	$billTo->lastName = $achLastName;
    $billTo->street1 = $achStreetAddress;
	$billTo->city = $achCity;
	$billTo->state = $achState;
	$billTo->postalCode = $achZip;		
	$billTo->country = "US";
	$billTo->phoneNumber = $achPhone;	
    $billTo->email = $achEmail;
    //$billTo->driversLicenseNumber = $achDriversLic;
    //$billTo->driversLicenseState = $achState;
	$request->billTo = $billTo;    

	$item->unitPrice = $achPayment;
	$item->quantity = "1";
	$item->id = "0";
	$request->item = array($item);
	
	$purchaseTotals->currency = "USD";
	//$purchaseTotals->grandTotalAmount = $achPayment;
	$request->purchaseTotals = $purchaseTotals;
	
	$check->accountNumber = $achAccountNumber;
	$check->accountType = $achAccountType;
	$check->bankTransitNumber = $achRoutingNumber;
	   //if($achAccountType == "X") {
	   //   $secVal = 'PPD';
	   //  }else{
	   //   $secVal = 'PPD';
	 //    }
	 
	 $secVal = 'PPD';
	 
	$check->secCode = $secVal;
	$request->check = $check;
	
    $soapClient = new ExtendedClient(WSDL_URL, array());
	$reply = $soapClient->runTransaction($request);	
	$achAuthDecision = $reply->decision;
	$achAuthReasonCode = $reply->reasonCode;
	$achAuthRequestId = $reply->requestID;
	 $_SESSION['ach_request_id'] = $achAuthRequestId;
     
	$debitReasonCode = $reply->ecDebitReply->reasonCode;
    $debitSettleMethod = $reply->ecDebitReply->settlementMethod;
    $debitDateTime= $reply->ecDebitReply->requestDateTime;
    $debitAmount = $reply->ecDebitReply->amount;
    $debitVerificationLevel = $reply->ecDebitReply->verificationLevel;
    $debitReconcileID = $reply->ecDebitReply->reconciliationID;	
//---------------------------------------------------------------------------------------------------- 
//if both the cc and ach transactions are successful then we settle the cc transaction else spit back an error
if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. ";
    echo"$ach_result";
    exit;   
   }else{
    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;
	$check = null;
	
    /*$request = new stdClass();
    $request->merchantID = MERCHANT_ID;
    $request->merchantReferenceCode = "CC Website Member Sales";
    $request->clientLibrary = "PHP";
    $request->clientLibraryVersion = phpversion();
    $request->clientEnvironment = php_uname();  
    
    $ccCaptureService = new stdClass();
    $purchaseTotals = new stdClass();
    $item = new stdClass();
    
    $ccCaptureService->run = "true";
    $ccCaptureService->authRequestID = $ccAuthRequestId;
    $request->ccCaptureService = $ccCaptureService;    
    
	$purchaseTotals->currency = "USD";
	$request->purchaseTotals = $purchaseTotals;
	
	$item->unitPrice = $ccCardPayment;
	$item->quantity = "1";
	$item->id = "0";
	$request->item = array($item);	    

	$soapClient = new ExtendedClient(WSDL_URL, array());	
	$reply = $soapClient->runTransaction($request);	
	$ccAuthDecision = $reply->decision;
	$ccAuthReasonCode = $reply->reasonCode;
	$ccAuthRequestId = $reply->requestID;*/
    $transactionType = "00";
    $reference = "CC Member Sales";
    $name = "$ccFirstName $ccLastName";
    
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
                      "Client_Email"=>$account_email,			//This value is only used for fraud investigation.
                      "Language"=>$language,				//English="en" French="fr"
                      "Card_Number"=>$ccCardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$ccCardMonth . $ccCardYear,//This value should be in the format MM/YY.
                      "CardHoldersName"=>$name,
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>$_POST["tbPOS_Authorization_Num"],
                      "Transaction_Tag"=>$_POST["tbPOS_Transaction_Tag"],
                      "DollarAmount"=>$ccCardPayment,
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
        
 
    if($ccAuthReasonCode != 100) {
          $card_result = 'There was an error processing this transaction.  This Credit Card will not be charged';
            echo"$card_result";
            exit;
       }else{
            $_SESSION['cc_request_id'] = $ccAuthRequestId;
           $card_result = 1;
           $transactionBool = 1;
           
          echo"$card_result";
          //exit;       
       }
 
 
   }//end cc transaction fulfillment
    
 //}//end banking and or ccc settlement

}//end if ach and cc present
//#####################################################################
//this is for ach only
if($achBool != "" &&  $ccBool == "") {

    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;
        
    $request = new stdClass();
    $request->merchantID = MERCHANT_ID;
    $request->merchantReferenceCode = "ACH Website Member Sales";
    $request->clientLibrary = "PHP";
    $request->clientLibraryVersion = phpversion();
    $request->clientEnvironment = php_uname();  
    
    $ecDebitService = new stdClass();
    $billTo = new stdClass();
    $item = new stdClass();
    $purchaseTotals = new stdClass();
    $check = new stdClass();
  
    $ecDebitService->run = "true";
    $ecDebitService->paymentMode = "0";
    $request->ecDebitService = $ecDebitService;
    
	$billTo->firstName = $achFirstName;
	$billTo->lastName = $achLastName;
    $billTo->street1 = $achStreetAddress;
	$billTo->city = $achCity;
	$billTo->state = $achState;
	$billTo->postalCode = $achZip;		
	$billTo->country = "US";
	$billTo->phoneNumber = $achPhone;	
    $billTo->email = $achEmail;
    //$billTo->driversLicenseNumber = $achDriversLic;
    //$billTo->driversLicenseState = $achState;
	$request->billTo = $billTo;    

	$item->unitPrice = $achPayment;
	$item->quantity = "1";
	$item->id = "0";
	$request->item = array($item);
	
	$purchaseTotals->currency = "USD";
	//$purchaseTotals->grandTotalAmount = $achPayment;
	$request->purchaseTotals = $purchaseTotals;
	
	$check->accountNumber = $achAccountNumber;
	$check->accountType = $achAccountType;
	$check->bankTransitNumber = $achRoutingNumber;
	//   if($achAccountType == "X") {
	 //     $secVal = 'PPD';
	 //    }else{
	 //     $secVal = 'PPD';
	 //    }
	     
	$secVal = 'PPD';    
	$check->secCode = $secVal;
	$request->check = $check;
	
    $soapClient = new ExtendedClient(WSDL_URL, array());
	$reply = $soapClient->runTransaction($request);	
	$achAuthDecision = $reply->decision;
	$achAuthReasonCode = $reply->reasonCode;
	$achAuthRequestId = $reply->requestID;
	
	$debitReasonCode = $reply->ecDebitReply->reasonCode;
    $debitSettleMethod = $reply->ecDebitReply->settlementMethod;
    $debitDateTime= $reply->ecDebitReply->requestDateTime;
    $debitAmount = $reply->ecDebitReply->amount;
    $debitVerificationLevel = $reply->ecDebitReply->verificationLevel;
    $debitReconcileID = $reply->ecDebitReply->reconciliationID;	


if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. ERROR: $debitReasonCode";
    echo"$ach_result";
    exit;   
   }else{   
    $_SESSION['ach_request_id'] = $achAuthRequestId;
    $card_result = 1; 
    $transactionBool = 1;
           
    echo"$card_result";
   // exit;          
   }

}
//######################################################################
//this is for credit cards only
if($ccBool != "" &&  $achBool == "") {

    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;


    //first check the cc card for validation
    /*$request = new stdClass();
    $request->merchantID = MERCHANT_ID;
    $request->merchantReferenceCode = "CC Website Member Sales";
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
  	//$ccAuthService->commerceIndicator = "retail";
    $request->ccAuthService = $ccAuthService;
    
    $ccCaptureService->run = "true";
    $request->ccCaptureService = $ccCaptureService;
    
    //$pos->cardPresent = "Y";
    //$pos->terminalCapability = "2";
   // $pos->entryMode = "keyed";
  //  $request->pos = $pos;
  
	$billTo->firstName = $ccFirstName;
	$billTo->lastName = $ccLastName;
    $billTo->street1 = $account_street;  //NA
	$billTo->city = $account_city; //NA
	$billTo->state = $account_state; //CA
	$billTo->postalCode = $account_zip; // 11111
	$billTo->country = "US";
    $billTo->email = $account_email;  //null@ANY.com
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
	
	$item->unitPrice = $ccCardPayment;
	$item->quantity = "1";
	$item->id = "029";
	$request->item = array($item);	
	
	$soapClient = new ExtendedClient(WSDL_URL, array());	
	$reply = $soapClient->runTransaction($request);	
	$ccAuthDecision = $reply->decision;
	$ccAuthReasonCode = $reply->reasonCode;
	$ccAuthRequestId = $reply->requestID;*/
    
     $transactionType = "00";
    $reference = "CC Member Sales";
    $name = "$ccFirstName $ccLastName";
    
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
                      "Client_Email"=>$account_email,			//This value is only used for fraud investigation.
                      "Language"=>$language,				//English="en" French="fr"
                      "Card_Number"=>$ccCardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$ccCardMonth . $ccCardYear,//This value should be in the format MM/YY.
                      "CardHoldersName"=>$name,
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>$_POST["tbPOS_Authorization_Num"],
                      "Transaction_Tag"=>$_POST["tbPOS_Transaction_Tag"],
                      "DollarAmount"=>$ccCardPayment,
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

    if($ccAuthReasonCode != 100) {
       $card_result = 'The Credit Card that was entered has been DECLINED';
         echo"$card_result";
         exit;
  
      }else{
            $_SESSION['cc_request_id'] = $ccAuthRequestId;
           $card_result = 1;
           $transactionBool = 1;
           
          echo"$card_result";
          //exit;       

      }

}
//#############################################################################################
//this sets up if there is monthly billing involved


}
if($transactionBool == 1){
$name_add_array=$_REQUEST['name_add_array'];
//var_dump($name_add_array);
//exit;
$emg_contact_array=$_REQUEST['emg_contact_array'];
$host_billing_info_array=$_REQUEST['host_billing_info_array'];
$sale_array=$_REQUEST['sale_array'];
$length=$_REQUEST['length'];
$monthlyBillingSelected = $_REQUEST['monthlyBillingSelected'];
$hostBool = $_REQUEST['hostBool'];
$sig = $_REQUEST['sig'];

include "webAdmin/salesSql.php";
$salesSql = new salesSql();

//set the sales form variables
$salesSql-> setNameAddArray($name_add_array);
$salesSql-> setHostBool($hostBool);
$salesSql-> setEmergConArray($emg_contact_array);
$salesSql-> setHostBillingInfoArray($host_billing_info_array);
$salesSql-> setSalesArray($sale_array);  //this to be parsed
$salesSql-> setMonthlyBilling($monthlyBillingSelected);  //to be parsed contains the name and adress info
$salesSql-> setLength($length);
$salesSql-> setSig($sig);
$salesSql-> setSetAdditionalService($totalServiceArray);
$salesSql-> setGearArray($totalGearArray);


$card_exp_date_array = date('Y-m-d',mktime(0,0,0,$card_month,1,$card_year));
//cc info
$salesSql-> setCardType($card_type);
$salesSql-> setCardName($card_name);
$salesSql-> setCardNumber($card_number);
$salesSql-> setCardCvv($card_cvv);
$salesSql-> setCardExpDate($card_exp_date_array);
$salesSql-> setCcRequestId($ccAuthRequestId);
$salesSql-> setCreditPayment($credit_pay);
//banking info

$salesSql-> setBankName($bank_name);
$salesSql-> setAccountType($account_type);
$salesSql-> setAccountName($account_name);
$salesSql-> setAccountNumber($account_number);
$salesSql-> setAbaNumber($routing_number);
$salesSql-> setAchRequestId($achAuthRequestId);
$salesSql-> setAchPayment($ach_pay);
//set the initial payment type


//set the monthly billing



//sets up the account status to current
$account_status = 'CU';
$salesSql-> setAccountStatus($account_status);

//set renewal to no since this is for saving initial sales
$renewal = 'N';
$upgrade = 'N';
$internet = 'N';
$salesSql-> setRenewal($renewal);
$salesSql-> setUpgrade($upgrade);
$salesSql-> setInternet($internet);

$_SESSION['salesSql'] = $salesSql;  
//echo"fub ar";
//exit;
$salesSql-> loadMain();//save all of the info




//sets up notes if a topic is present or subject


//deletes the current sql contract session

//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Contract $contract_key Successfully Saved";



}

?>