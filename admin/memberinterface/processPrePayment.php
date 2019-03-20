<?php
require"../nmi/nmiGatewayClass.php";
session_start();
if (!isset($_SESSION['admin_access'])) {
    exit;
}

//=======================================================

require "../cybersource/parseGatewayFields.php";

class processPrePayment
{

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
    private $numberMonths = null;
    private $prepayRestartDate = null;
    private $monthlyPayment = null;


    function setNumberMonths($numberMonths)
    {
        $this->numberMonths = $numberMonths;
    }
    function setPrepayRestartDate($prepayRestartDate)
    {
        $this->prepayRestartDate = $prepayRestartDate;
    }
    function setAchPayment($achPayment)
    {
        $this->achPayment = $achPayment;
    }
    function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }
    function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }
    function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }
    function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }
    function setAbaNumber($abaNumber)
    {
        $this->abaNumber = $abaNumber;
    }
    function setMonthlyPayment($monthlyPayment)
    {
        $this->monthlyPayment = $monthlyPayment;
    }

    function setCreditPayment($creditPayment)
    {
        $this->creditPayment = $creditPayment;
    }
    function setCardType($cardType)
    {
        $this->cardType = $cardType;
    }
    function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }
    function setCardName($cardName)
    {
        $this->cardName = $cardName;
    }
    function setCardCvv($cardCvv)
    {
        $this->cardCvv = $cardCvv;
    }
    function setCardMonth($cardMonth)
    {
        $this->cardMonth = $cardMonth;
    }
    function setCardYear($cardYear)
    {
        $this->cardYear = $cardYear;
    }


    function setContractKey($contractKey)
    {
        $this->contractKey = $contractKey;
    }
    function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }


    //connect to database
    function dbconnect()
    {
        require "../dbConnect.php";
        return $dbMain;
    }
    //=================================================
    //this will eventually send info to the payment processor
    function processPayment()
    {

        $dbMain = $this->dbconnect();

        $fieldParse = new parseGatewayFields();
        $fieldParse->setCardName($this->cardName);
        $fieldParse->setAchName($this->accountName);
        $fieldParse->setCardType($this->cardType);
        $fieldParse->setAccountType($this->accountType);
        $fieldParse->setCardExpDate($this->cardYear);
        $fieldParse->parsePaymentFields();

        //reassign vars for CS Credit Cards
        $this->ccFirstName = $fieldParse->getCredtCardFirstName();
        $this->ccLastName = $fieldParse->getCredtCardLastName();
        $this->ccCardType = $fieldParse->getCardType();
        $this->ccCardYear = $fieldParse->getCardYear();
        $this->ccCardMonth = $this->cardMonth;
        $this->ccCardNumber = $this->cardNumber;
        $this->ccCardCvv = $this->cardCvv;

      
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
    $reference = "CMP Prepayment";
        //credit"";//
        $ccnumber = $this->ccCardNumber;//"4111111111111111";
        $ccexp = "$this->ccCardMonth$this->ccCardYear";//"1010";
        $cvv = "$this->cardCvv";
            //==================
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
        //$dupSecs = 3000;
            //======================== 
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
    
    
       
        $ccAuthDecision = $gw->responses['responsetext'];
        $vaultId = $gw->responses['customer_vault_id'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $this->ccAuthReasonCode = $gw->responses['response_code'];
    /*
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
    $reference = "CMP Prepayment";
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
                      "Card_Number"=>$this->ccCardNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                      "Expiry_Date"=>$this->ccCardMonth . $this->ccCardYear,//This value should be in the format MM/YY.
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
      $this->ccAuthReasonCode = $trxnResult->Bank_Resp_Code;
      $ccAuthDecision = $trxnResult->Bank_Message;    */

        if ($this->ccAuthReasonCode != 100) {
            $this->paymentStatus = 2;
            //$this->transactionId = $ccAuthRequestId;
        } else {
            $this->paymentStatus = 1;
        }

        //$this->paymentStatus = 1;


    }
    //==================================================================
   /* function deleteSubscription(){
        
        $authOptions = new gatewayAuth();
        $authOptions->loadGatewayOptions();
        $merchantId = $authOptions->getMerchantId();
        $transactionKey = $authOptions->getTransactionKey();
        $accessLink = $authOptions->getAccessLink();

        define('MERCHANT_ID', $merchantId);
        define('TRANSACTION_KEY', $transactionKey);
        define('WSDL_URL', $accessLink);
        
        $soapClient = new ExtendedClient(WSDL_URL, array());
        
        $request2 = new stdClass();
        $paySubscriptionUpdateService = new stdClass();
        $recurringSubscriptionInfo = new stdClass();


        $request2->merchantID = MERCHANT_ID;
        $request2->merchantReferenceCode = "$this->contractKey";
        $request2->clientLibrary = "PHP";
        $request2->clientLibraryVersion = phpversion();
        $request2->clientEnvironment = php_uname();


        $paySubscriptionUpdateService->run = 'true';
        $request2->paySubscriptionUpdateService = $paySubscriptionUpdateService;

        $recurringSubscriptionInfo->status = "cancel";
        $recurringSubscriptionInfo->subscriptionID = "$this->subscriptionID";
        $request2->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        $reply2 = $soapClient->runTransaction($request2);

        $this->ccAuthDecision2 = $reply2->decision;
        $this->ccAuthReasonCode2 = $reply2->reasonCode;
        $this->ccAuthRequestId2 = $reply2->requestID;
        
         if ($this->ccAuthReasonCode2 != 100) {
                
              $sql = "INSERT INTO failed_subscriptions VALUES (?,?,?)";
              $stmt1 = $dbMain->prepare($sql);
              $stmt1->bind_param('isi', $this->contractKey, $this->subscriptionID,  $this->ccAuthReasonCode2);

              if (!$stmt1->execute()) {  
                    printf("Error: %s.inswert failed trans\n", $stmt1->error);
                }
               $stmt1->close();
                 //$this->paymentStatus = 2;  
            }
       //$this->price = $reply2->paySubscriptionRetrieveReply->recurringAmount;
        /* $this->city = $reply2->paySubscriptionRetrieveReply->city;
        $this->state = $reply2->paySubscriptionRetrieveReply->state;
        $this->email = $reply2->paySubscriptionRetrieveReply->email;
        $this->zip = $reply2->paySubscriptionRetrieveReply->postalCode;
        $street1 = $reply2->paySubscriptionRetrieveReply->street1;
        $street2 = $reply2->paySubscriptionRetrieveReply->street2;
        $this->street = "$street1 $street2";           
           
        if ($this->billingType == 'BA'){
            $this->ACHfirstName = $reply2->paySubscriptionRetrieveReply->firstName;
            $this->ACHlastName = $reply2->paySubscriptionRetrieveReply->lastName;
            $this->accountNumber = $reply2->paySubscriptionRetrieveReply->checkAccountNumber;
            $this->abaNumber = $reply2->paySubscriptionRetrieveReply->checkBankTransitNumber;
            $this->phone = $reply2->paySubscriptionRetrieveReply->phoneNumber;
            $this->liscenseNumber = $reply2->paySubscriptionRetrieveReply->driversLicenseNumber;
            $this->liscenseNumberState = $reply2->paySubscriptionRetrieveReply->driversLicenseState;
        }*/

  //  }
    //===================================================================
 /*   function alterCCSubscription()
    {
            $authOptions = new gatewayAuth();
            $authOptions->loadGatewayOptions();
            $merchantId = $authOptions->getMerchantId();
            $transactionKey = $authOptions->getTransactionKey();
            $accessLink = $authOptions->getAccessLink();
    
            define('MERCHANT_ID', $merchantId);
            define('TRANSACTION_KEY', $transactionKey);
            define('WSDL_URL', $accessLink);
            
            $soapClient = new ExtendedClient(WSDL_URL, array());

        
            $request3 = new stdClass();
            $billTo = new stdClass();
            $card = new stdClass();
            $purchaseTotals = new stdClass();
            $paySubscriptionCreateService = new stdClass();
            $recurringSubscriptionInfo = new stdClass();
            $subscription = new stdClass();


            $request3->merchantID = MERCHANT_ID;
            $request3->merchantReferenceCode = "$this->contractKey";
            $request3->clientLibrary = "PHP";
            $request3->clientLibraryVersion = phpversion();
            $request3->clientEnvironment = php_uname();


            $billTo->firstName = $this->ccFirstName;
            $billTo->lastName = $this->ccLastName;
            $billTo->street1 = $this->street;
            $billTo->city = $this->city;
            $billTo->state = $this->state;
            $billTo->postalCode = $this->zip;
            $billTo->country = "US";
            $billTo->email = $this->email;
            $request3->billTo = $billTo;


            $card->accountNumber = $this->ccCardNumber;
            $card->expirationMonth = $this->ccCardMonth;
            $card->expirationYear = $this->ccCardYear;
            $card->cardType = $this->ccCardType;
            $card->cvIndicator = "1";
            $card->cvNumber = $this->ccCardCvv;
            $request3->card = $card;


            $purchaseTotals->currency = "USD";
            $request3->purchaseTotals = $purchaseTotals;


            $paySubscriptionCreateService->run = "true";
            $paySubscriptionCreateService->disableAutoAuth = "true";
            $request3->paySubscriptionCreateService = $paySubscriptionCreateService;


            $recurringSubscriptionInfo->frequency = "monthly"; //mo clue
            $recurringSubscriptionInfo->amount = $this->monthlyPayment;
            $recurringSubscriptionInfo->startDate = $this->billingDate; // need to find code YYYYMMDD
            $request3->recurringSubscriptionInfo = $recurringSubscriptionInfo;


            $subscription->paymentMethod = "credit card";
            $subscription->title = 'Monthly Dues CC';
            $request3->subscription = $subscription;


            $reply3 = $soapClient->runTransaction($request3);

            $ccAuthDecision3 = $reply3->decision;
            $ccAuthReasonCode3 = $reply3->reasonCode;
            $ccAuthRequestId3 = $reply3->requestID;
            $subscriptionID = $reply3->paySubscriptionCreateReply->subscriptionID;

            $subscripType = 'MS';
            $monthlyBillingType = 'CR';
            $frequency = "monthly";
            
            $dbMain = $this->dbconnect();
            
            if ($ccAuthReasonCode3 == 100) {
                
                $sql = "UPDATE cs_subscriptions  SET subscription_id = ?  WHERE contract_key = '$this->contractKey' AND subscription_type ='MS'";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('s', $subscriptionID);
                if (!$stmt->execute()) {
                    printf("Error: %s.insert subscrip\n", $stmt->error);
                }

                $stmt->close();
                $this->paymentStatus = 1; 
            } else {

                $sql = "INSERT INTO failed_subscriptions VALUES (?,?,?,?,?,?)";
                $stmt1 = $dbMain->prepare($sql);
                $stmt1->bind_param('issdis', $this->contractKey, $subscripType, $monthlyBillingType, $this->monthlyPayment, $ccAuthReasonCode3, $frequency);

                if (!$stmt1->execute()) {
                    printf("Error: %s.inswert failed trans\n", $stmt1->error);
                }

                $stmt1->close();
                 //$this->paymentStatus = 2;  
            }

        


    }
//===================================================================
function alterACHSubscription(){
    
    
     $authOptions = new gatewayAuth();
     $authOptions->loadGatewayOptions();
     $merchantId = $authOptions->getMerchantId();
     $transactionKey = $authOptions->getTransactionKey();
     $accessLink = $authOptions->getAccessLink();

    define('MERCHANT_ID', $merchantId);
    define('TRANSACTION_KEY', $transactionKey);
    define('WSDL_URL', $accessLink);
    
    $soapClient = new ExtendedClient(WSDL_URL, array());

    $request = new stdClass();
	$request->merchantID = MERCHANT_ID;
	$request->merchantReferenceCode = "$this->contractKey";
	$request->clientLibrary = "PHP";
    $request->clientLibraryVersion = phpversion();
    $request->clientEnvironment = php_uname();

	$billTo = new stdClass();
	$billTo->firstName = $this->ACHFirstName;
     $billTo->lastName = $this->ACHLastName;
     $billTo->street1 = $this->street;
     $billTo->city = $this->city;
     $billTo->state = $this->state;
     $billTo->postalCode = $this->zip;
     $billTo->country = "US";
     $billTo->email = $this->email;
     $billTo->phoneNumber = $this->phone;
     $billTo->driversLicenseNumber = $this->liscenseNumber;
     $billTo->driversLicenseState = $this->state;
     $request->billTo = $billTo;

	$check = new stdClass();
	 $check->accountNumber = $this->accountNumber;
     $check->accountType = "C";
     $check->bankTransitNumber = $this->abaNumber;
     $check->secCode = 'WEB';
     $request->check = $check;

	$purchaseTotals = new stdClass();
	$purchaseTotals->currency = "USD";
	$request->purchaseTotals = $purchaseTotals;
    
    $paySubscriptionCreateService = new stdClass();
    $paySubscriptionCreateService->run = "true";
    $request->paySubscriptionCreateService = $paySubscriptionCreateService;
    
    $recurringSubscriptionInfo = new stdClass();
    $recurringSubscriptionInfo->frequency = "monthly"; //mo clue
    $recurringSubscriptionInfo->amount = $this->monthlyPayment;
    $recurringSubscriptionInfo->startDate = $this->billingDate;// need to find code YYYYMMDD
    $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;
    
    $subscription = new stdClass();
	$subscription->paymentMethod = "check";
    $subscription->title = "Monthly Dues ACH";
    $request->subscription = $subscription;

	$reply = $soapClient->runTransaction($request);
    
    $ccAuthDecision3 = $reply->decision;
    $ccAuthReasonCode3 = $reply->reasonCode;
    $ccAuthRequestId3 = $reply->requestID;
    $subscriptionID = $reply->paySubscriptionCreateReply->subscriptionID;
    
    $subscripType = 'MS';
    $monthlyBillingType = 'BA';
    $frequency = "monthly";
    
    $dbMain = $this->dbconnect();
    
    if ($ccAuthReasonCode3 == 100) {
                
        $sql = "UPDATE cs_subscriptions  SET subscription_id = ?  WHERE contract_key = '$this->contractKey' AND subscription_type ='MS'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $subscriptionID);
        if (!$stmt->execute()) {
                           printf("Error: %s.insert subscrip\n", $stmt->error);
        }

        $stmt->close();
        $this->paymentStatus = 1;        
        
                                        
            } else {

                $sql = "INSERT INTO failed_subscriptions VALUES (?,?,?,?,?,?)";
                $stmt1 = $dbMain->prepare($sql);
                $stmt1->bind_param('issdis', $this->contractKey, $subscripType, $monthlyBillingType, $this->monthlyPayment, $ccAuthReasonCode3, $frequency);

                if (!$stmt1->execute()) {
                    printf("Error: %s.inswert failed trans\n", $stmt1->error);
                }

                $stmt1->close();
                //$this->paymentStatus = 2;  
            }
    
    
}*/
//===================================================================
function loadMemberInfo(){
    
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT street, city, state, zip, email, license_number, primary_phone FROM contract_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($street, $city, $state, $zip, $email, $license_number, $primary_phone);
    $stmt->fetch();
    $stmt->close();
    
    $this->street = $street;
    $this->city = $city;
    $this->state = $state;
    $this->zip = $zip;
    $this->email = $email;
    $this->licenseNumber = $license_number;
    $this->phone = $primary_phone;
}
//===================================================
/*function loadSubscription(){
    
      $dbMain = $this->dbconnect();
    $stmt = $dbMain->prepare("SELECT subscription_id, billing_type FROM cs_subscriptions WHERE contract_key = '$this->contractKey' AND subscription_type = 'MS' ");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($subscription_id, $billing_type);
    $stmt->fetch();
    $rowCount = $stmt->num_rows;
    $stmt->close();
    
    if ($rowCount > 0) {
    
    $this->subscriptionID = $subscription_id;
    $this->billingType = $billing_type;
    
    $this->deleteSubscription();
    $this->loadMemberInfo();

    if ($this->billingType == 'CR' AND $this->ccAuthReasonCode2 == '100'){
        if($this->ccCardNumber == ''){
            $stmt = $dbMain->prepare("SELECT card_fname, card_lname, card_number, card_cvv, card_exp_date, card_type FROM credit_info WHERE contract_key = '$this->contractKey'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($this->ccFirstName, $this->ccLastName, $this->ccCardNumber, $this->ccCardCvv, $expDate, $cardType);
            $stmt->fetch();
            $stmt->close();
            
            if($cardType == 'Visa') {
            $this->ccCardType = "001";
            }
            //mastercard
            if($cardType == 'MC') {
            $this->ccCardType = "002";
            }
            //AMX
            if($cardType == 'Amex') {
            $this->ccCardType = "003";
            }
            //Discover
            if($cardType == 'Disc') {
            $this->ccCardType = "004";
            }
            
            //$dateArray = explode('-',$expDate);
            $this->ccCardMonth = date("m",strtotime($expDate));
            $this->ccCardYear = date("Y",strtotime($expDate));
        }
        $this->billingDate = date("Ymd",strtotime($this->prepayRestartDate));
        //echo "$this->billingDate";
        $this->alterCCSubscription();
        
    }elseif ($this->billingType == 'BA' AND $this->ccAuthReasonCode2 == '100'){
        $stmt = $dbMain->prepare("SELECT account_fname, account_lname, account_number, routing_number FROM banking_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->ACHFirstName, $this->ACHLastName, $this->accountNumber, $this->abaNumber);
        $stmt->fetch();
        $stmt->close();
        //$process = new processPrePayment();
        //$process->setContractKey($contract_key);
       // $process->setPrepayRestartDate($pre_pay_restart_date);
        $this->billingDate = date("Ymd", strtotime($this->prepayRestartDate));
        
        $this->alterACHSubscription();
    }
    
 }
}*/
//=================================================
function getPaymentStatus(){
        return ($this->paymentStatus);
    }


}
//------------------------------------------------------------------------------------
//send to cybersource for pre payment
//$billingDate = date("Ymd",strtotime($pre_pay_restart_date));
//echo"$billingDate";
//exit;

$credit_payment = $_REQUEST['credit_payment'];
$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_name = $_REQUEST['card_name'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$contract_key = $_REQUEST['contract_key'];
$pre_pay_restart_date = $_REQUEST['pre_pay_restart_date'];
$number_months = $_REQUEST['number_months'];
$monthly_payment = $_REQUEST['monthly_payment'];             
                 



    $process = new processPrePayment();
    $process->setContractKey($contract_key);
    $process->setPrepayRestartDate($pre_pay_restart_date);
    $process->setNumberMonths($number_months);
    $process->setMonthlyPayment($monthly_payment);

if ($credit_payment != 0) {

    $process->setCreditPayment($credit_payment);
    $process->setCardType($card_type);
    $process->setCardNumber($card_number);
    $process->setCardName($card_name);
    $process->setCardCvv($card_cvv);
    $process->setCardMonth($card_month);
    $process->setCardYear($card_year);
    $process->processPayment();
    $payment_status = $process->getPaymentStatus();

} else {
    $payment_status = 1;
}

if ($payment_status == 1){
    
  
    // $process->loadSubscription();
  

}

//echo"1";
//exit;
//below set up a function for cyber source to cancel subscription
//if payment status is equal to 1 check subscription status, billing type.   If billing type is BA or CR then delete subscription and create new subscrption

//subscription code
//'salesSql.php' line 2300
 //$payment_status = 1;
//$payment_status = 1;
//if credit card is used and rejected set $payment_status to '2', echo and exit;
echo "$payment_status";
exit;




?>