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
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd, languagefd, link FROM billing_gateway_fields WHERE club_id= '3551'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gatewayID, $password, $language, $link);
$stmt->fetch();
$stmt->close();

$transactionType = "04";

//echo "test";
$stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, payment_type, billing_amount, transaction_tag, authorization_id FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND processed = 'Y' AND club_id = '3551' AND payment_type = 'RF' AND cycle_start_year = '2015'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($payment_id, $contract_key, $payment_type, $billing_amount, $transaction_tag, $authorization_id);
while($stmt99->fetch()){
    echo "test";
            
                    if($billing_amount == 38.00){
                        $refundAmount = 19.00;
                        
                        $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
            $stmt->fetch();
            $stmt->close();
            
            $expDateSecs = strtotime($card_exp_date);
            $todayDateTest = date('Y-m-d H:i:s');
            $todayDateTestSecs = strtotime($todayDateTest);
            
            $cardName = "$card_fname $card_lname";
            //echo "<br><br>*************exp Date secs $expDateSecs  TODAY SECS $todayDateTestSecs*************";
            
           
                $cardMonth = date('m',strtotime($card_exp_date));
                $cardYear = date('y',strtotime($card_exp_date));
                    
                    
                    $trxnProperties = array(
                      "User_Name"=>"",
                      "Secure_AuthResult"=>"",
                      "Ecommerce_Flag"=>"",   // 2 = recurring   R= retail
                      "XID"=>"",
                      "ExactID"=>"$gatewayID",				    //Payment Gateway
                      "CAVV"=>"",
                      "Password"=>"$password",					                //Gateway Password
                      "CAVV_Algorithm"=>"",
                      "Transaction_Type"=>"$transactionType",//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                      "Reference_No"=>"",
                      "Customer_Ref"=>"",
                      "Reference_3"=>"",
                      "Client_IP"=>"",					                    //This value is only used for fraud investigation.
                      "Client_Email"=>"",			//This value is only used for fraud investigation.
                      "Language"=>"$language",				//English="en" French="fr"
                      "Card_Number"=>"$card_number",		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>"$cardMonth . $cardYear",//This value should be in the format MM/YY.
                      "CardHoldersName"=>"$cardName",
                      "Track1"=>"",
                      "Track2"=>"",
                      "Authorization_Num"=>"",
                      "Transaction_Tag"=>"",
                      "DollarAmount"=>"$refundAmount",
                      "VerificationStr1"=>"",
                      "VerificationStr2"=>"",
                      "CVD_Presence_Ind"=>"",
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
                     echo"<br>tetetetet $authId";
            
            if(@$client->fault){
                // there was a fault, inform
                print "<B>FAULT:  Code: {$client->faultcode} <BR />";
                print "String: {$client->faultstring} </B>";
                $trxnResult["CTR"] = "There was an error while processing. No TRANSACTION DATA IN CTR!";
            }
            
               $authId = $trxnResult->Authorization_Num;
                $transactionTag = $trxnResult->Transaction_Tag;
                $bankResponseCode = $trxnResult->Bank_Resp_Code;
                $bankMessage = $trxnResult->Bank_Message;
                $bankResponseCode2 = $trxnResult->Bank_Resp_Code_2;
                $exactResponseCode = $trxnResult->EXact_Resp_Code;
                $exactMessage = $trxnResult->EXact_Message;
                $avsResponse = $trxnResult->AVS;
                
                
                if($bankResponseCode == '100'){
                     $sql = "UPDATE billing_scheduled_recuring_payments SET billing_amount = ? WHERE contract_key = '$contract_key' AND payment_id = '$payment_id'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('d', $refundAmount);
                    if(!$stmt->execute())  {
                                    	printf("Error:updateEHFEE %s.\n", $stmt->error);
                                          }	
                        
                    $stmt->close();
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
    $transaction_tag = "";
    $authorization_id = "";
    $refundAmount = "";
    }
    }




$stmt99->close();
//===============================================================================================================================
//===============================================================================================================================
?>