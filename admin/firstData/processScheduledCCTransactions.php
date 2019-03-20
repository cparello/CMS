<?php
class SoapClientHMAC extends SoapClient {
  public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
	global $context;
	require"../dbConnect.php";

    $stmt = $dbMain ->prepare("SELECT hmac, key_id FROM billing_gateway_fields WHERE club_id= '3551'");
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

//=================================================================================
class ExtendedClient extends SoapClient {

   function __construct($wsdl, $options = null) {
     parent::__construct($wsdl, $options);
   }

// This section inserts the UsernameToken information in the outgoing SOAP message.
   function __doRequest($request, $location, $action, $version) {
//echo"foo bar tesr@@@@@@@@@@@@@@@@@@@@@";
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
         //echo "$request";

	  //printf( "Modified Request:\n*$request*\n" );

     } catch (DOMException $e) {
         die( 'Error adding UsernameToken: ' . $e->code);
     }

     return parent::__doRequest($request, $location, $action, $version);
   }
}

$ajaxSwitch = $_REQUEST['ajaxSwitch'];

if($ajaxSwitch == 1){
require"../dbConnect.php";

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
$stmt = $dbMain ->prepare("SELECT exp_bool, max_retries, nsf_bool, exp_month, exp_year FROM billing_gateway_main_fields WHERE gateway_key= '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($ccExpOverideBool, $maxRetries, $nsf_bool, $exp_month, $exp_year);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, languagefd, link FROM billing_gateway_fields WHERE club_id= '3551'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gatewayID, $password, $language, $link);
$stmt->fetch();
$stmt->close();

$transactionType = "00";

$todayDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));//
$todaySecs = strtotime($todayDay);

//echo "test";
$stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, payment_type, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_year, transaction_type FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND processed = 'N' AND club_id = '3551'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($payment_id, $contract_key, $payment_type, $attempt_number, $billing_amount, $cycle_start_day, $cycle_start_month, $cycle_start_year, $transaction_type);
while($stmt99->fetch()){
    $expBool = 1;
    $transaction_type = trim($transaction_type);
     //echo "test $contract_key";  
     switch($attempt_number){
        case 1:
            $diffSecs = 259200;
        break;
        case 2:
            $diffSecs = 518400;
        break;
        default:
            $diffSecs = 1;
        break;
     } 
    
    //$diffSecs = $attempt_number * 86400 + 172800;
    $startDate = date('Y-m-d H:i:s',mktime(0,0,0,$cycle_start_month, $cycle_start_day, $cycle_start_year));
    $startSecs = strtotime($startDate);
    //echo "$cycle_start_month, $cycle_start_day, $cycle_start_year<br>";
    $timeBuffer = $startSecs + $diffSecs;
    //$t1 = date('Y-m-d H:i:s',$todaySecs);
    // $t2 = date('Y-m-d H:i:s',$timeBuffer);
    // $t3 = date('Y-m-d H:i:s',$startSecs);
    //echo "$contract_key $attempt_number todaySECS $todaySecs > BUFFERSECS $timeBuffer startsecs $startSecs diffsecs $diffSecs<br>";
    if($attempt_number == 0 OR $todaySecs >= $timeBuffer){
    
      if ($attempt_number <= $maxRetries){
       
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
            //echo "ba $billing_amount";
        if ($billing_amount > 0) { 
        
            
       if($transaction_type == 'CC'){
             //echo "<br><br><br>ckey $contract_key $transaction_type<br>";
        //echo "test";
            $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
            $stmt->fetch();
            $stmt->close();
            
            $expDateSecs = strtotime($card_exp_date);
            $todayDateTest = date('Y-m-d H:i:s');
            $todayDateTestSecs = strtotime($todayDateTest);
            
            
            //echo "<br><br>*************exp Date secs $expDateSecs  TODAY SECS $todayDateTestSecs*************";
            
            if($expDateSecs >= $todayDateTestSecs){
                $cardMonth = date('m',strtotime($card_exp_date));
                $cardYear = date('y',strtotime($card_exp_date));
                }elseif($ccExpOverideBool == 'Yes'){
                    $cardMonth = "$exp_month";
                    $cardYear = "$exp_year";
                }
                //echo "billed";
                $expBool = 0;
                    $cardNumber = trim($card_number);
                    
                    $cardName = "$card_fname $card_lname";
                    //$amount = "10.00";
                    
                    $trxnProperties = array(
                      "User_Name"=>"",
                      "Secure_AuthResult"=>"",
                      "Ecommerce_Flag"=>"2",   // 2 = recurring   R= retail
                      "XID"=>"",
                      "ExactID"=>"$gatewayID",				    //Payment Gateway
                      "CAVV"=>"",
                      "Password"=>"$password",					                //Gateway Password
                      "CAVV_Algorithm"=>"",
                      "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                      "Reference_No"=>$contract_key,
                      "Customer_Ref"=>$payment_type,
                      "Reference_3"=>"",
                      "Client_IP"=>"",					                    //This value is only used for fraud investigation.
                      "Client_Email"=>$email,			//This value is only used for fraud investigation.
                      "Language"=>$language,				//English="en" French="fr"
                      "Card_Number"=>$cardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$cardMonth . $cardYear,//This value should be in the format MM/YY.
                      "CardHoldersName"=>$cardName,
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>"",
                      "Transaction_Tag"=>"",
                      "DollarAmount"=>$billing_amount,
                      "VerificationStr1"=>$address,
                      "VerificationStr2"=>"",
                      "CVD_Presence_Ind"=>"0",
                      "Secure_AuthRequired"=>"",
                      "Currency"=>"",
                      "PartialRedemption"=>"",
                      
                      // Level 2 fields 
                      "ZipCode"=>"",
                      "Tax1Amount"=>"",
                      "Tax1Number"=>"",
                      "Tax2Amount"=>"",
                      "Tax2Number"=>"",
                      
                      "SurchargeAmount"=>"",	//Used for debit transactions only
                      "PAN"=>""							//Used for debit transactions only
                      );
                   
                    
                    $client = new SoapClientHMAC($link);
                    $trxnResult = $client->SendAndCommit($trxnProperties);
                    
               /*     echo "<H3><U>Transaction Properties BEFORE Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnProperties as $key=>$value){
                    echo " <TR><TD>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";
                
                echo "<H3><U>Transaction Properties AFTER Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnResult as $key=>$value){
                    $value = nl2br($value);
                    echo " <TR><TD valign='top'>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";*/
                        
                    
                   
            
            
           
            
        }elseif($transaction_type == 'ACH'){
            $expBool = 3;
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
            
            if ($reply->reasonCode == "100"){
            
            }
            $authId = $reply->requestID;
            $transactionTag = $reply->requestID;
            $bankResponseCode = $reply->reasonCode;
            $bankMessage = $reply->decision;
            $bankResponseCode2 = $reply->decision;
            $exactResponseCode = $reply->reasonCode;
            $exactMessage = $reply->decision;
            $avsResponse = "None";
            
             /*if($account_type == 'C' OR $account_type == 'S'){
                $checkType = 'P';
            }else{
                 $checkType = 'B';
            }
            
           
            
            $checkNumber = 1;
            
            
                  $trxnPropertiesAch = array(
                  "Ecommerce_Flag"=>"8",  // 2 = recurring   R= retail
                  "ExactID"=>"$gatewayID",				    //Payment Gateway
                  "Password"=>"$password",					                //Gateway Password
                  "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                  "Reference_No"=>$contract_key,
                  "Customer_Ref"=>$payment_type,	                    //This value is only used for fraud investigation.
                  "Client_Email"=>$email,			//This value is only used for fraud investigation.
                  "Language"=>$language,				//English="en" French="fr"
                  "CheckNumber"=>$checkNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                  "CheckType"=>$checkType,//"P" (personal check), or "C" (corporate check).
                  "CustomerName"=>$customerName,
                  "BankAccountNumber"=>$bankAccountNumber,
                  "BankRoutingNumber"=>$bankRoutingNumber,
                  "CustomerID"=>$license_number,
                  "CustomerIDType"=>$customerIdType, // 0 = dl
                  "Address"=>$address,
                  "DollarAmount"=>$billing_amount,
                  "Currency"=>"USD",    //https://firstdata.zendesk.com/entries/450214-supported-currencies
                    );
              echo " \"Ecommerce_Flag\"=>\"8\",  // 2 = recurring   R= retail
                  \"ExactID\"=>\"$gatewayID\",				    //Payment Gateway
                  \"Password\"=>\"$password\",					                //Gateway Password
                  \"Transaction_Type\"=>$transactionType,//Transaction Code I.E. Purchase=\"00\" Pre-Authorization=\"01\" etc.
                  \"Reference_No\"=>$contract_key,
                  \"Customer_Ref\"=>$payment_type,	                    //This value is only used for fraud investigation.
                  \"Client_Email\"=>$email,			//This value is only used for fraud investigation.
                  \"Language\"=>$language,				//English=\"en\" French=\"fr\"
                  \"CheckNumber\"=>$checkNumber,		    //For Testing, Use Test#s VISA=\"4111111111111111\" MasterCard=\"5500000000000004\" etc.
                  \"CheckType\"=>$checkType,//\"P\" (personal check), or \"C\" (corporate check).
                  \"CustomerName\"=>$customerName,
                  \"BankAccountNumber\"=>$bankAccountNumber,
                  \"BankRoutingNumber\"=>$bankRoutingNumber,
                  \"CustomerID\"=>$license_number,
                  \"CustomerIDType\"=>$customerIdType,
                  \"Address\"=>$address,
                  \"DollarAmount\"=>$billing_amount,
                  \"Currency\"=>\"USD\", ";
                
                $client = new SoapClientHMAC($link);
                $trxnResult = $client->SendAndCommitCheck($trxnPropertiesAch);*/
               //  echo "test"; 
                
               /* echo "<H3><U>Transaction Properties BEFORE Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnPropertiesAch as $key=>$value){
                    echo " <TR><TD>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";
                
                echo "<H3><U>Transaction Properties AFTER Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnResult as $key=>$value){
                    $value = nl2br($value);
                    echo " <TR><TD valign='top'>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";*/
                        }
        
      
           
            
            if(@$client->fault){
                // there was a fault, inform
                print "<B>FAULT:  Code: {$client->faultcode} <BR />";
                print "String: {$client->faultstring} </B>";
                $trxnResult["CTR"] = "There was an error while processing. No TRANSACTION DATA IN CTR!";
            }
            //var_dump($trxnResult) ;
            
            if($expBool == 0){
                 $authId = $trxnResult->Authorization_Num;
                $transactionTag = $trxnResult->Transaction_Tag;
                $bankResponseCode = $trxnResult->Bank_Resp_Code;
                $bankMessage = $trxnResult->Bank_Message;
                $bankResponseCode2 = $trxnResult->Bank_Resp_Code_2;
                $exactResponseCode = $trxnResult->EXact_Resp_Code;
                $exactMessage = $trxnResult->EXact_Message;
                $avsResponse = $trxnResult->AVS;
                $attempt_number++;
            }elseif($expBool == 3){
                //DO NOTHING
                $attempt_number++;
            }else{
                $authId = "None";
                $transactionTag = "None";
                $bankResponseCode = '999';
                $bankMessage = "Expired Card";
                $bankResponseCode2 = "Expired Card";
                $exactResponseCode = '999';
                $exactMessage = "Expired Card";
                $avsResponse = "None";
                //$attempt_number = 3;
            }
            //echo "<br>expBool $expBool<br>";
           
             
            if ($bankResponseCode == '100'){
                $processed = 'Y';
                $outstandingBalance = 'N';
            }else{
                
                if($nsf_bool == 'Yes'){
                    switch($bankResponseCode){
                        case '302'; //nsf 
                            $processed = 'N';
                        break;
                        case '521'; //wrong currency 502 losrt  501 pickiup 522 exp 571
                            $processed = 'N';
                        break;
                        case '000'; //nsf 
                            $processed = 'N';
                        break;
                        case '301'; //nsf 
                            $processed = 'N';
                        break;
                        case '902'; //nsf 
                            $processed = 'N';
                        break;
                        default:
                            $processed = 'Y';
                            $attempt_number = 3;
                        break;
                    }
                    
                    }else{
                        $processed = 'N';
                        //$attempt_number++;
                    }
                $outstandingBalance = 'Y';
            }
            
        }else{
                $authId = "None";
                $transactionTag = "None";
                $bankResponseCode = '999';
                $bankMessage = "$0 amount";
                $bankResponseCode2 = "$0 amount";
                $exactResponseCode = '999';
                $exactMessage = "$0 amount";
                $avsResponse = "None";
                $processed = 'Y';
                $attempt_number = 3;
                $outstandingBalance = 'Y';
        }
            $sql = "UPDATE billing_scheduled_recuring_payments SET attempt_number = ?, processed = ?, response_message = ?, response = ?, response_2 = ? ,avs_response = ?, exact_reponse = ?, exact_code = ?, transaction_tag = ?, authorization_id = ?, outstanding_balance = ? WHERE contract_key = '$contract_key' AND payment_id = '$payment_id'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('issssssssss', $attempt_number, $processed, $bankMessage, $bankResponseCode, $bankResponseCode2, $avsResponse, $exactMessage, $exactResponseCode, $transactionTag, $authId, $outstandingBalance);
            if(!$stmt->execute())  {
                            	printf("Error:updateEHFEE %s.\n", $stmt->error);
                                  }	
                
            $stmt->close();
            //echo"<br>tetetetet $authId";
            
    }
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




$stmt99->close();
//===============================================================================================================================
//===============================================================================================================================
class SoapClientHMAC2 extends SoapClient {
  public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
	global $context;
	require"../dbConnect.php";

    $stmt = $dbMain ->prepare("SELECT hmac, key_id FROM billing_gateway_fields WHERE club_id= '3552'");
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
  
  public function SoapClientHMAC2($wsdl, $options = NULL) {
	global $context;
	$context = stream_context_create();
	$options['stream_context'] = $context;
	return parent::SoapClient($wsdl, $options);
  }
}



require"../dbConnect.php";
//echo "test $contract_key";

$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, languagefd, link FROM billing_gateway_fields WHERE club_id= '3552'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gatewayID, $password, $language, $link);
$stmt->fetch();
$stmt->close();

$transactionType = "00";

$todayDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
$todaySecs = strtotime($todayDay);


$stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, payment_type, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_year, transaction_type FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND processed = 'N' AND club_id = '3552'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($payment_id, $contract_key, $payment_type, $attempt_number, $billing_amount, $cycle_start_day, $cycle_start_month, $cycle_start_year, $transaction_type);
while($stmt99->fetch()){
    $expBool = 1;
    $transaction_type = trim($transaction_type);
    
     switch($attempt_number){
        case 1:
            $diffSecs = 259200;
        break;
        case 2:
            $diffSecs = 518400;
        break;
        default:
            $diffSecs = 1;
        break;
     } 
     
    //$diffSecs = $attempt_number * 86400 + 172800;
    $startDate = date('Y-m-d H:i:s',mktime(0,0,0,$cycle_start_month, $cycle_start_day, $cycle_start_year));
    $startSecs = strtotime($startDate);
    //echo "$cycle_start_month, $cycle_start_day, $cycle_start_year<br>";
    $timeBuffer = $startSecs + $diffSecs;
    //$t1 = date('Y-m-d H:i:s',$todaySecs);
    // $t2 = date('Y-m-d H:i:s',$timeBuffer);
    // $t3 = date('Y-m-d H:i:s',$startSecs);
     //echo "$contract_key $attempt_number $todaySecs > $timeBuffer <br>";
    if($attempt_number == 0 OR $todaySecs >= $timeBuffer){
    
      if ($attempt_number <= $maxRetries){
       
            $stmt = $dbMain ->prepare("SELECT email, license_number, street, city, state, zip FROM contract_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($email, $license_number, $streetAddress, $city, $state, $zip);
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
            
         if ($billing_amount > 0) {     
            
       if($transaction_type == 'CC'){
             //echo "<br><br><br>ckey $contract_key $transaction_type<br>";
        //echo "test";
            $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
            $stmt->fetch();
            $stmt->close();
            
            $expDateSecs = strtotime($card_exp_date);
            $todayDateTest = date('Y-m-d H:i:s');
            $todayDateTestSecs = strtotime($todayDateTest);
            
            
            //echo "<br><br>*************exp Date secs $expDateSecs  TODAY SECS $todayDateTestSecs*************";
            
             if($expDateSecs >= $todayDateTestSecs){
                $cardMonth = date('m',strtotime($card_exp_date));
                $cardYear = date('y',strtotime($card_exp_date));
                }elseif($ccExpOverideBool == 'Yes'){
                    $cardMonth = "$exp_month";
                    $cardYear = "$exp_year";
                }
                //echo "billed";
                $expBool = 0;
                    $cardNumber = trim($card_number);
                    
                    $cardName = "$card_fname $card_lname";
                    //$amount = "10.00";
                    
                    $trxnProperties = array(
                     "User_Name"=>"",
                      "Secure_AuthResult"=>"",
                      "Ecommerce_Flag"=>"2",   // 2 = recurring   R= retail
                      "XID"=>"",
                      "ExactID"=>"$gatewayID",				    //Payment Gateway
                      "CAVV"=>"",
                      "Password"=>"$password",					                //Gateway Password
                      "CAVV_Algorithm"=>"",
                      "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                      "Reference_No"=>$contract_key,
                      "Customer_Ref"=>$payment_type,
                      "Reference_3"=>"",
                      "Client_IP"=>"",					                    //This value is only used for fraud investigation.
                      "Client_Email"=>$email,			//This value is only used for fraud investigation.
                      "Language"=>$language,				//English="en" French="fr"
                      "Card_Number"=>$cardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$cardMonth . $cardYear,//This value should be in the format MM/YY.
                      "CardHoldersName"=>$cardName,
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>"",
                      "Transaction_Tag"=>"",
                      "DollarAmount"=>$billing_amount,
                      "VerificationStr1"=>$address,
                      "VerificationStr2"=>"",
                      "CVD_Presence_Ind"=>"0",
                      "Secure_AuthRequired"=>"",
                      "Currency"=>"",
                      "PartialRedemption"=>"",
                      
                      // Level 2 fields 
                      "ZipCode"=>"",
                      "Tax1Amount"=>"",
                      "Tax1Number"=>"",
                      "Tax2Amount"=>"",
                      "Tax2Number"=>"",
                      
                      "SurchargeAmount"=>"",	//Used for debit transactions only
                      "PAN"=>""											//Used for debit transactions only
                      );
                   
                    
                    $client = new SoapClientHMAC2($link);
                    $trxnResult = $client->SendAndCommit($trxnProperties);
                    
               /*     echo "<H3><U>Transaction Properties BEFORE Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnProperties as $key=>$value){
                    echo " <TR><TD>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";
                
                echo "<H3><U>Transaction Properties AFTER Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnResult as $key=>$value){
                    $value = nl2br($value);
                    echo " <TR><TD valign='top'>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";*/
                        
                    
                   
            
            
           
            
        }elseif($transaction_type == 'ACH'){
             $expBool = 3;
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
            
            if ($reply->reasonCode == "100"){
            
            }
            $authId = $reply->requestID;
            $transactionTag = $reply->requestID;
            $bankResponseCode = $reply->reasonCode;
            $bankMessage = $reply->decision;
            $bankResponseCode2 = $reply->decision;
            $exactResponseCode = $reply->reasonCode;
            $exactMessage = $reply->decision;
            $avsResponse = "None";
            
             /*if($account_type == 'C' OR $account_type == 'S'){
                $checkType = 'P';
            }else{
                 $checkType = 'B';
            }
            
           
            $country = "US";
            $customerName = "$account_fname $account_lname";
            $customerIdType = "0";
            $address = "$streetAddress|$zip|$city|$state|$country";
            $address = strtoupper($address);
            $checkNumber = 1;
            
            
                  $trxnPropertiesAch = array(
                  "Ecommerce_Flag"=>"8",  // 2 = recurring   R= retail
                  "ExactID"=>"$gatewayID",				    //Payment Gateway
                  "Password"=>"$password",					                //Gateway Password
                  "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                  "Reference_No"=>$contract_key,
                  "Customer_Ref"=>$payment_type,	                    //This value is only used for fraud investigation.
                  "Client_Email"=>$email,			//This value is only used for fraud investigation.
                  "Language"=>$language,				//English="en" French="fr"
                  "CheckNumber"=>$checkNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                  "CheckType"=>$checkType,//"P" (personal check), or "C" (corporate check).
                  "CustomerName"=>$customerName,
                  "BankAccountNumber"=>$bankAccountNumber,
                  "BankRoutingNumber"=>$bankRoutingNumber,
                  "CustomerID"=>$license_number,
                  "CustomerIDType"=>$customerIdType, // 0 = dl
                  "Address"=>$address,
                  "DollarAmount"=>$billing_amount,
                  "Currency"=>"USD",    //https://firstdata.zendesk.com/entries/450214-supported-currencies
                    );
              echo " \"Ecommerce_Flag\"=>\"8\",  // 2 = recurring   R= retail
                  \"ExactID\"=>\"$gatewayID\",				    //Payment Gateway
                  \"Password\"=>\"$password\",					                //Gateway Password
                  \"Transaction_Type\"=>$transactionType,//Transaction Code I.E. Purchase=\"00\" Pre-Authorization=\"01\" etc.
                  \"Reference_No\"=>$contract_key,
                  \"Customer_Ref\"=>$payment_type,	                    //This value is only used for fraud investigation.
                  \"Client_Email\"=>$email,			//This value is only used for fraud investigation.
                  \"Language\"=>$language,				//English=\"en\" French=\"fr\"
                  \"CheckNumber\"=>$checkNumber,		    //For Testing, Use Test#s VISA=\"4111111111111111\" MasterCard=\"5500000000000004\" etc.
                  \"CheckType\"=>$checkType,//\"P\" (personal check), or \"C\" (corporate check).
                  \"CustomerName\"=>$customerName,
                  \"BankAccountNumber\"=>$bankAccountNumber,
                  \"BankRoutingNumber\"=>$bankRoutingNumber,
                  \"CustomerID\"=>$license_number,
                  \"CustomerIDType\"=>$customerIdType,
                  \"Address\"=>$address,
                  \"DollarAmount\"=>$billing_amount,
                  \"Currency\"=>\"USD\", ";
                
                $client = new SoapClientHMAC($link);
                $trxnResult = $client->SendAndCommitCheck($trxnPropertiesAch);*/
               //  echo "test"; 
                
               /* echo "<H3><U>Transaction Properties BEFORE Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnPropertiesAch as $key=>$value){
                    echo " <TR><TD>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";
                
                echo "<H3><U>Transaction Properties AFTER Processing</U></H3>";
                echo "<TABLE border='0'>\n";
                echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
                foreach($trxnResult as $key=>$value){
                    $value = nl2br($value);
                    echo " <TR><TD valign='top'>$key</TD><TD>:$value</TD></TR>\n";
                }
                echo "</TABLE>\n";*/
                        }
        
      
            
            
            if(@$client->fault){
                // there was a fault, inform
                print "<B>FAULT:  Code: {$client->faultcode} <BR />";
                print "String: {$client->faultstring} </B>";
                $trxnResult["CTR"] = "There was an error while processing. No TRANSACTION DATA IN CTR!";
            }
            //var_dump($trxnResult) ;
            
            if($expBool == 0){
                 $authId = $trxnResult->Authorization_Num;
                $transactionTag = $trxnResult->Transaction_Tag;
                $bankResponseCode = $trxnResult->Bank_Resp_Code;
                $bankMessage = $trxnResult->Bank_Message;
                $bankResponseCode2 = $trxnResult->Bank_Resp_Code_2;
                $exactResponseCode = $trxnResult->EXact_Resp_Code;
                $exactMessage = $trxnResult->EXact_Message;
                $avsResponse = $trxnResult->AVS;
                $attempt_number++;
            }elseif($expBool == 3){
                //DO NOTHING
                $attempt_number++;
            }else{
                $authId = "None";
                $transactionTag = "None";
                $bankResponseCode = '999';
                $bankMessage = "Expired Card";
                $bankResponseCode2 = "Expired Card";
                $exactResponseCode = '999';
                $exactMessage = "Expired Card";
                $avsResponse = "None";
                //$attempt_number = 3;
            }
            //echo "<br>expBool $expBool<br>";
           
             
            if ($bankResponseCode == '100'){
                $processed = 'Y';
                $outstandingBalance = 'N';
            }else{
                 if($nsf_bool == 'Yes'){
                    switch($bankResponseCode){
                        case '302'; //nsf 
                            $processed = 'N';
                        break;
                        case '521'; //wrong currency 502 losrt  501 pickiup 522 exp 571
                            $processed = 'N';
                        break;
                        case '000'; //nsf 
                            $processed = 'N';
                        break;
                        case '301'; //nsf 
                            $processed = 'N';
                        break;
                        case '902'; //nsf 
                            $processed = 'N';
                        break;
                        default:
                            $processed = 'Y';
                            $attempt_number = 3;
                        break;
                    }
                    
                    }else{
                        $processed = 'N';
                        //$attempt_number++;
                    }
                $outstandingBalance = 'Y';
            }
            
            
             }else{
                $authId = "None";
                $transactionTag = "None";
                $bankResponseCode = '999';
                $bankMessage = "$0 amount";
                $bankResponseCode2 = "$0 amount";
                $exactResponseCode = '999';
                $exactMessage = "$0 amount";
                $avsResponse = "None";
                $processed = 'Y';
                $attempt_number = 3;
                $outstandingBalance = 'Y';
        }
            
            
            $sql = "UPDATE billing_scheduled_recuring_payments SET attempt_number = ?, processed = ?, response_message = ?, response = ?, response_2 = ? ,avs_response = ?, exact_reponse = ?, exact_code = ?, transaction_tag = ?, authorization_id = ?, outstanding_balance = ? WHERE contract_key = '$contract_key' AND payment_id = '$payment_id'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('issssssssss', $attempt_number, $processed, $bankMessage, $bankResponseCode, $bankResponseCode2, $avsResponse, $exactMessage, $exactResponseCode, $transactionTag, $authId, $outstandingBalance);
            if(!$stmt->execute())  {
                            	printf("Error:updateEHFEE %s.\n", $stmt->error);
                                  }	
                
            $stmt->close();
            //echo"<br>tetetetet $authId";
            
    }
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




$stmt99->close();

//===============================================================================================================================
//===============================================================================================================================

include"updateTablesSuccessfulTransaction.php";
$update = new updateTablesSucessfulTransaction();
$update->moveData();

}else{
    echo "99";
    exit;
}
//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();

?>