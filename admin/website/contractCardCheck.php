<?php
include "salesSql.php";
include"gatewayAuth.php";
include"../../cybersource/cybersourceSoapClient.php";
include"../../cybersource/parseGatewayFields.php";
session_start();


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

if($credit_pay != "" ||  $ach_pay != "") {
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
 echo "rest $accessLink $transactionKey $merchantId";
exit;
    //first check the cc card for validation
    $request = new stdClass();
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
	
    $request = new stdClass();
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
	$ccAuthRequestId = $reply->requestID;
        
 
    if($ccAuthReasonCode != 100) {
          $card_result = 'There was an error processing this transaction.  This Credit Card will not be charged';
            echo"$card_result";
            exit;
       }else{
            $_SESSION['cc_request_id'] = $ccAuthRequestId;
           $card_result = 1;
           $card_exp_date_array = "$card_year $card_month";
           $salesSql = $_SESSION['salesSql'];
           $salesSql-> setCardType($card_type);
           $salesSql-> setCardName($card_name);
           $salesSql-> setCardNumber($card_number);
           $salesSql-> setCardCvv($card_cvv);
           $salesSql-> setCardExpDate($card_exp_date_array);
           $salesSql-> setCreditPayment($credit_pay);
           $salesSql-> setCcRequestId($ccAuthRequestId);
           $salesSql-> setAchRequestId($achAuthRequestId);
           $_SESSION['salesSql'] = $salesSql;   
           
          echo"$card_result";
          exit;       
       }
 
 
   }//end cc transaction fulfillment
    
 }//end banking and or ccc settlement

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
    $salesSql = $_SESSION['salesSql'];
    $salesSql-> setAchRequestId($achAuthRequestId);
    $_SESSION['salesSql'] = $salesSql;   
           
    echo"$card_result";
    exit;          
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
    $request = new stdClass();
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
	$ccAuthRequestId = $reply->requestID;

    if($ccAuthReasonCode != 100) {
       $card_result = 'The Credit Card that was entered has been DECLINED';
         echo"$card_result";
         exit;
  
      }else{
            $_SESSION['cc_request_id'] = $ccAuthRequestId;
           $card_result = 1;
           $card_exp_date_array = "$card_year $card_month";
           $salesSql = $_SESSION['salesSql'];
           $salesSql-> setCardType($card_type);
           $salesSql-> setCardName($card_name);
           $salesSql-> setCardNumber($card_number);
           $salesSql-> setCardCvv($card_cvv);
           $salesSql-> setCardExpDate($card_exp_date_array);
           $salesSql-> setCreditPayment($credit_pay);
           $salesSql-> setCcRequestId($ccAuthRequestId);
           $_SESSION['salesSql'] = $salesSql;   
           
          echo"$card_result";
          exit;       

      }

}
//#############################################################################################
//this sets up if there is monthly billing involved


}





$number_new_memberships = $_REQUEST['number_new_memberships'];
$card_type = $_REQUEST['card_type'];
$card_name = $_REQUEST['card_name'];
$card_number = $_REQUEST['card_number'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$credit_pay = $_REQUEST['credit_pay'];
$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_num = $_REQUEST['account_num'];
$aba_num = $_REQUEST['aba_num'];
$ach_pay = $_REQUEST['ach_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$check_pay = $_REQUEST['check_pay'];
$topic = $_REQUEST['topic'];
$message = $_REQUEST['message'];
$check_number = $_REQUEST['check_number'];
$monthly_billing_selected = $_REQUEST['monthly_billing_selected'];
$commission_credit = $_REQUEST['commission_credit'];
$member_info_array = $_REQUEST['member_info_array'];
$emg_info_array = $_REQUEST['emg_info_array'];
$note_user = $_REQUEST['note_user'];
$topic = $_REQUEST['topic'];
$message = $_REQUEST['message'];
$priority = $_REQUEST['priority'];
$target_app = $_REQUEST['target_app'];
$salesSql = $_SESSION['salesSql'];
//decode the info from the ajax post
$service_status = $_REQUEST['service_status'];
$group_type = $_REQUEST['group_type'];
$mem_num = $_REQUEST['mem_num'];
$group_type_info_array = $_REQUEST['group_type_info_array'];
$name_address_array = $_REQUEST['name_address_array'];
$liability_host = $_REQUEST['liability_host'];
$product_list_array = $_REQUEST['product_list_array'];
$trans = $_REQUEST['trans'];
$pro_rate_fee = $_REQUEST['pro_rate_fee'];
$process_fee_eft = $_REQUEST['process_fee_eft'];
$down_pay = $_REQUEST['down_pay'];
$total_fees_monthly = $_REQUEST['total_fees_monthly'];
$monthly_payment = $_REQUEST['monthly_payment'];
$serve_month = $_REQUEST['serve_month'];
$open_end = $_REQUEST['open_end'];
$init_fee = $_REQUEST['init_fee'];
$pre_paid_service = $_REQUEST['pre_paid_service'];
$process_fee_pif = $_REQUEST['process_fee_pif'];
$grand_total_pif = $_REQUEST['grand_total_pif'];
$serve_total = $_REQUEST['serve_total'];
$ren_total = $_REQUEST['ren_total'];
$serve_total_due = $_REQUEST['serve_total_due'];
$today_payment = $_REQUEST['today_payment'];
$balance_due = $_REQUEST['balance_due'];
$due_date = $_REQUEST['due_date'];
$monthly_billing_type = $_REQUEST['monthly_billing_type'];
$datepicker = $_REQUEST['datepicker'];
$delete_switch = $_REQUEST['delete_switch'];
$contract_key = $_REQUEST['contract_key'];
$sid = $_REQUEST['sid'];
$key_switch = $_REQUEST['key_switch'];
$sig = $_REQUEST['sig'];

//get the cc info 
$card_type = trim($card_type);
$card_name = trim($card_name);
$card_number = trim($card_number);
$card_number = preg_replace("/[^0-9 .]+/", "" ,$card_number);
$card_cvv = trim($card_cvv);
$card_month = trim($card_month);
$card_year = trim($card_year);
$credit_pay = trim($credit_pay);
$card_exp_date_array ="$card_year $card_month";
$bank_name = trim($bank_name);
$account_type = trim($account_type);
$account_name = trim($account_name);
$account_num = trim($account_num);
$aba_num = trim($aba_num);
$ach_pay = trim($ach_pay);
$cash_pay = trim($cash_pay);
$check_pay = trim($check_pay);



//overide_pin  set to Y if set N if not
//print_r($_POST);
//echo"$monthly_billing_selected<br><br>$member_info_array<br><br>$emg_info_array";
//exit;

//exit;
//decode the info from the ajax post
$service_status = urldecode($service_status);
$group_type = urldecode($group_type);
$mem_num = urldecode($mem_num);
$group_type_info_array = urldecode($group_type_info_array);
$name_address_array = urldecode($name_address_array);
$liability_host = urldecode($liability_host);
$product_list_array = urldecode($product_list_array);
$trans = urldecode($trans);
$pro_rate_fee = urldecode($pro_rate_fee);
$process_fee_eft = urldecode($process_fee_eft);
$down_pay = urldecode($down_pay);
$total_fees_monthly = urldecode($total_fees_monthly);
$monthly_payment = urldecode($monthly_payment);
$serve_month = urldecode($serve_month);
$open_end = urldecode($open_end);
$init_fee = urldecode($init_fee);
$pre_paid_service = urldecode($pre_paid_service);
$process_fee_pif = urldecode($process_fee_pif);
$grand_total_pif = urldecode($grand_total_pif);
$serve_total = urldecode($serve_total);
$ren_total = urldecode($ren_total);
$serve_total_due = urldecode($serve_total_due);
$today_payment = urldecode($today_payment);
$balance_due = urldecode($balance_due);
$due_date = urldecode($due_date);
$monthly_billing_type = urldecode($monthly_billing_type);
$datepicker =  urldecode($datepicker);
//$sig =  urldecode($sig);
//create the sales sql object to store the sales info for the contract forms
include "salesSql.php";
$salesSql = new salesSql();

//this redirects and closes the current sql object session variables as well as deletes the contract key 
if($delete_switch == 1)   {
 $salesSql-> setContractKey($contract_key);
 $delete_key =  $salesSql-> deleteContractKey();
 echo"$delete_key";
 exit;
}

//does a little cleanup for a couple of undefined vars from javascript
if($process_fee_eft == "undefined") {
   $process_fee_eft = "";
   }
if($process_fee_pif == "undefined") {
   $process_fee_pif = "";
   }

//set the sales form variables
$salesSql-> setContractType($service_status);
$salesSql-> setGroupType($group_type);
$salesSql-> setGroupNumber($mem_num);
$salesSql-> setGroupTypeInfo($group_type_info_array);  //this to be parsed
$salesSql-> setContractClientInfo($name_address_array);  //to be parsed contains the name and adress info
$salesSql-> setHostType($liability_host);
$salesSql-> setProductList($product_list_array);  //this to be parsed
$salesSql-> setTransfer($trans);
$salesSql-> setProRateDues($pro_rate_fee);
$salesSql-> setProcessFeeMonthly($process_fee_eft);
$salesSql-> setDownPayment($down_pay);
$salesSql-> setTotalFeesEft($total_fees_monthly);    //this will not be saved into the db. It is used just for reference when creating contracts
$salesSql-> setMonthlyDues($monthly_payment);
$salesSql-> setMonthlyServicesTotal($serve_month);   //used as reference for contracts
$salesSql-> setTermType($open_end);
$salesSql-> setInitiationFee($init_fee);
$salesSql-> setPifServicesTotal($pre_paid_service);   //used as reference for contracts
$salesSql-> setProcessFeePif($process_fee_pif);
$salesSql-> setPifGrandTotal($grand_total_pif);  //shows the total od services and proc fee. for contract reference
$salesSql-> setServicesTotal($serve_total);  //for contract reference. shows pif and monthly service totals
$salesSql-> setRenewalRateTotal($ren_total);  //for contract reference
$salesSql-> setMinTotalDue($serve_total_due);
$salesSql-> setTodaysPayment($today_payment);
$salesSql-> setBalanceDue($balance_due);
$salesSql-> setDueDate($due_date);
$salesSql-> setMonthlyBillingType($monthly_billing_type);
$salesSql-> setDatePicker($datepicker);
$salesSql-> setSig($sig);

if($key_switch == 0) {
   $salesSql-> createContractKey();
   $contract_key =  $salesSql-> getContractKey();
   echo"$contract_key";
   }elseif($key_switch == 1){
   $salesSql-> setContractKey($contract_key);
   echo"$contract_key";
   }

//first see if the contract key is set. If not then exit with warning
$contract_key = $salesSql-> getContractKey();
if($contract_key == null) {
echo"System error. Please contact your administrator";
exit;
}
//cc info
$salesSql-> setCardType($card_type);
$salesSql-> setCardName($card_name);
$salesSql-> setCardNumber($card_number);
$salesSql-> setCardCvv($card_cvv);
$salesSql-> setCardExpDate($card_exp_date_array);

//banking info
$salesSql-> setBankName($bank_name);
$salesSql-> setAccountType($account_type);
$salesSql-> setAccountName($account_name);
$salesSql-> setAccountNumber($account_num);
$salesSql-> setAbaNumber($aba_num);

//set the initial payment type
$salesSql-> setCreditPayment($credit_pay);
$salesSql-> setAchPayment($ach_pay);
$salesSql-> setCashPayment($cash_pay);
$salesSql-> setCheckPayment($check_pay);

//if the check number is not set we set it if the check pay field is not null
if($check_pay != "") {
  $salesSql-> setCheckNumber($check_number);
  }

//set the monthly billing
$salesSql-> setMonthlyBilling($monthly_billing_selected);

//sets the overide pin if entered
$overide_pin = "";
  if($overide_pin == "") {
      $overide_status = 'N';
     } 
$salesSql-> setOveridePin($overide_pin);

//set the commission credit
$salesSql-> setCommissionCredit($commission_credit);  //is the email address needs to be parsed

//sets up all of the member info not the contract info plus the emergancy contact info
$salesSql-> setMemberInfoArray($member_info_array);
$salesSql-> setEmgContactArray($emg_info_array);

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

//save all of the info
$salesSql-> saveBankingInfo();
$salesSql-> saveCreditInfo();
$salesSql-> saveGroupInfo();
$salesSql-> saveContractInfo();
$salesSql-> saveMemberInfo();
$salesSql-> saveServices();
$salesSql-> saveInitialPayments();


//this sets up monthly billing if a monthly service was selected
if($monthly_billing_selected != "")  {
   $salesSql-> saveMonthlyBilling();
  }

//sets up notes if a topic is present or subject


//deletes the current sql contract session
unset($_SESSION['salesSql']);
//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Contract $contract_key Successfully Saved";

//opens the sales form
//include "salesForm.php";

exit;



/*
 echo"ACH Desicion:  $achAuthDecision \n ACH Reason Code: $achAuthReasonCode \n ACH Request ID: $achAuthRequestId \n ACH Debit Reason: $debitReason \n ACH Settle Method: $debitSettleMethod \n ACH Request Date: $debitDateTime \n ACH Debit Amount: $debitAmount \n ACH Debit Verify Level: $debitVerificationLevel \n ACH Reconcile ID: $debitReconcileID \n\n CC Desicion: $ccAuthDecision \n CC Reason Code: $ccAuthReasonCode \n CC Request ID: $ccAuthRequestId \n\n";


 echo"Desicion:  $ccAuthDecision \n Reason Code: $ccAuthReasonCode \n Request ID: $requestId \n  Missing: $testFields \n Invalid: $invalidFields[0] \n AVS Result: $avsResult \n Invalid: $invalid\n\n";
 echo"ccfirstName $ccFirstName \n ccLastName  $ccLastName \n ccCardType $ccCardType \n ccCardYear  $ccCardYear \n ccCardMonth $ccCardMonth \n ccCardCvv $ccCardCvv \n ccCardPayment $ccCardPayment \n ccCardNumber $ccCardNumber \n\n achFirstName $achFirstName \n achLastName $achLastName \n achStreetAddress $achStreetAddress \n achCity $achCity \n achState $achState \n achZip $achZip \n achPhone $achPhone \n achEmail $achEmail \n achDriversLic $achDriversLic \n achAccountType $achAccountType \n achRoutingNumber $achRoutingNumber \n achAccountNumber $achAccountNumber \n achPayment $achPayment \n\n";
*/

?>