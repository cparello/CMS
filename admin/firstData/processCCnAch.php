<?php

require"../dbConnect.php";
class ExtendedClient extends SoapClient {

   function __construct($wsdl, $options = null) {
     parent::__construct($wsdl, $options);
   }

// This section inserts the UsernameToken information in the outgoing SOAP message.
   function __doRequest($request, $location, $action, $version) {

     $user = MERCHANT_ID;
     $password = TRANSACTION_KEY;

     $soapHeader = "<SOAP-ENV:Header xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\"><wsse:Security SOAP-ENV:mustUnderstand=\"1\"><wsse:UsernameToken><wsse:Username>$user</wsse:Username><wsse:Password Type=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText\">$password</wsse:Password></wsse:UsernameToken></wsse:Security></SOAP-ENV:Header>";

     $requestDOM = new DOMDocument('1.0');
     $soapHeaderDOM = new DOMDocument('1.0');

     try {

         $requestDOM->loadXML($request);
	 $soapHeaderDOM->loadXML($soapHeader);

	 $node = $requestDOM->importNode($soapHeaderDOM->firstChild, true);
	 $requestDOM->firstChild->insertBefore(
         	$node, $requestDOM->firstChild->firstChild);

         $request = $requestDOM->saveXML();

	 // printf( "Modified Request:\n*$request*\n" );

     } catch (DOMException $e) {
         die( 'Error adding UsernameToken: ' . $e->code);
     }

     return parent::__doRequest($request, $location, $action, $version);
   }
}
//===========================================================================================================
//////////////////////////////CYBERSOURCE
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once"../cybersource/gatewayAuth.php";
    $authOptions = new gatewayAuth();
    $authOptions-> loadGatewayOptions();
    $merchantId = $authOptions-> getMerchantId();
    $transactionKey = $authOptions-> getTransactionKey();
    $accessLink = $authOptions-> getAccessLink();
    
    define( 'MERCHANT_ID', $merchantId );
    define( 'TRANSACTION_KEY', $transactionKey);
    define( 'WSDL_URL', $accessLink);
    
    $soapClient = new ExtendedClient(WSDL_URL, array());
//====================================================================================================
echo "test";

$todayDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));//
$todaySecs = strtotime($todayDay);

//echo "test";
$stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, payment_type, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_year FROM batch_recurring_records WHERE contract_key != '' AND processed = 'N' AND transaction_type = 'ACH'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($payment_id, $contract_key, $payment_type, $attempt_number, $billing_amount, $cycle_start_day, $cycle_start_month, $cycle_start_year);
while($stmt99->fetch()){
       
            $stmt = $dbMain ->prepare("SELECT email, license_number, street, city, state, zip, primary_phone  FROM contract_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($email, $license_number, $streetAddress, $city, $state, $zip, $primary_phone);
            $stmt->fetch();
            $stmt->close();
            
            if ($email == ""){
                $email = "none@email.com";
            }
            if ($city == ""){
                $city = "Burbank";
            }
            if ($streetAddress == ""){
                $streetAddress = "123 easy st";
            }
            if ($state == ""){
                $state = "CA";
            }
            if ($zip == ""){
                $zip = "91501";
            }
            if ($primary_phone == ""){
                $primary_phone = "(818)-222-2222";
            }
            $country = "US";
            $address = "$streetAddress|$zip|$city|$state|$country";
            $address = strtoupper($address);
         
           // echo "<br><br><br>ckey $contract_key $transaction_type<br>";
            $stmt = $dbMain ->prepare("SELECT account_fname, account_lname, account_number, routing_number, account_type FROM banking_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($account_fname, $account_lname, $bankAccountNumber, $bankRoutingNumber, $account_type);
            $stmt->fetch();
            $stmt->close();
            
            if ($email == ""){
                $email = "NONE@EMAIL.COM";
            }
            
            
            $request = new stdClass();
            $request->merchantID = MERCHANT_ID;
            $request->merchantReferenceCode = "$contract_key";
            $request->clientLibrary = "PHP";
            $request->clientLibraryVersion = phpversion();
            $request->clientEnvironment = php_uname();
            //$request->ignoreCardExpiration = 'true';
            
            $billTo = new stdClass();
            $check = new stdClass();
            $purchaseTotals = new stdClass();
        	$item = new stdClass();
        	
        	$billTo->firstName = $account_fname;
        	$billTo->lastName = $account_lname;
        	$billTo->street1 = $streetAddress;
        	$billTo->city = $city;
        	$billTo->state = $state;
        	$billTo->postalCode = $zip;
        	$billTo->country = "US";
        	$billTo->email = $email;
        	$billTo->phoneNumber = $primary_phone;
            //$billTo->driversLicenseNumber = $license_number;
            //$billTo->driversLicenseState = $state;
        	$request->billTo = $billTo;
        
       	    $check->accountNumber = $bankAccountNumber;
            $check->accountType = "C";
            $check->bankTransitNumber = $bankRoutingNumber;
            $check->secCode = 'PPD';
            $request->check = $check;
        
        	$purchaseTotals->currency = "USD";
        	$request->purchaseTotals = $purchaseTotals;
        
        	$item->unitPrice = $billing_amount;
        	$item->quantity = "1";
        	$item->id = "0";
            
            $ecDebitService = new stdClass();
            $ecDebitService->run="true";
            $ecDebitService->commerceIndicator = 'recurring';
            $request->ecDebitService = $ecDebitService;
        
        	$request->item = array($item);
        //var_dump($request);
        	$reply = $soapClient->runTransaction($request);
            
            $authId = $reply->requestID;
            $transactionTag = $reply->requestID;
            $bankResponseCode = $reply->reasonCode;
            $bankMessage = $reply->decision;
            $bankResponseCode2 = $reply->decision;
            $exactResponseCode = $reply->reasonCode;
            $exactMessage = $reply->decision;
            $avsResponse = "None";
            
            if ($reply->reasonCode == "100"){
                $attempt_number++;
                $tot += $billing_amount;
                
                          $processed = 'Y';
                          $sql = "UPDATE batch_recurring_records SET processed = ?, authorization_id = ?, transaction_id = ?, response = ?, processor_response = ?, avs_response = ?, cvv_response = ?  WHERE contract_key = '$contract_key' AND payment_id = '$payment_id'";
                          $stmt = $dbMain->prepare($sql);
                          $stmt->bind_param('sssssss', $processed, $authId, $authId, $bankResponseCode, $exactMessage, $avsResponse, $avsResponse);
                          $stmt->execute();
                          $stmt->close();
                          
                          echo "$contract_key $reply->reasonCode $billing_amount<br>";
            }
        
    
    $contract_key = "";
    $payment_type = "";
    $attempt_number = "";
    $billing_amount = "";
    $payment_id = "";
    $cycle_start_day = "";
    $cycle_start_month = "";
    $cycle_start_year = "";
    $transaction_type = "";
    $account_fname = "";
    $account_lname = "";
    $bankAccountNumber = "";
    $bankRoutingNumber = "";
    $account_type = "";
    $email = "";
    $license_number = "";
    $streetAddress = "";
    $city = "";
    $state = "";
    $zip = "";
    $card_fname= "";
    $card_lname= "";
    $card_number= "";
    $card_exp_date= "";
    $authId = "";
    $transactionTag = "";
    $bankResponseCode = "";
    $bankMessage = "";
    $bankResponseCode2 = "";
    $exactResponseCode = "";
    $exactMessage = "";
    $avsResponse = "";
    $processed = "";
    $outstandingBalance = "";
    }



echo "tot: $tot";
$stmt99->close();
//===============================================================================================================================



//===============================================================================================================================
//===============================================================================================================================

include"updateTablesSuccessfulTransaction.php";
$update = new updateTablesSucessfulTransaction();
$update->moveData();


//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();

?>