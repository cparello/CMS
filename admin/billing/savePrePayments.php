<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class savePrePayments {

private $contractKey = null;

//for cc
private $cardType = null;
private $cardName = null;  //this is an array that needs to be parsed
private $cardNumber = null;
private $cardCvv = null;
private $cardExpDate = null;  //set to auth net satandards, needs to be parsed for mysql befor insert
//these are not used through the sales console but could be used later. we set to "" instead of null for SQL insert
private $cardStreet = "";
private $cardCity = "";
private $cardState = "";
private $cardZip = "";

//for banking
private $bankName = null;
private $accountType = null;
private $accountName = null;
private $accountNumber = null;
private $abaNumber = null;

//initial payment types
private $cashPayment = null;
private $creditPayment = null;
private $achPayment = null;
private $checkPayment = null;
private $checkNumber = 0;

//prepayment variables
private $monthlyBillingType = null;
private $monthlyPayment = null;
private $prepayRestartDate = null;
private $prepayNumMonths = null;
private $prepayTotal = null;
private $keyList = null;
private $prepayKey = null;

//account name and address for banking and cc
private $accountFirst = null;
private $accountMiddle = null;
private $accountLast = null;
private $nameSwitch = null;
private $accountStreet = null;
private $accountCity = null;
private $accountState = null;
private $accountZip = null;
private $accountPhone = null;
private $accountEmail = null;
private $accountLicense = null;


//history  payments
private $paymentDescription = null;
private $historyKey = null;
private $todaysPayment = null;
private $dueDate = null;
private $transKey = null;
private $pastDay = null;
private $cycleDay = null;
private $balanceDue = '0.00';
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $ccRequestId = 0;
private $achRequestId = 0;



function setAccountStreet($accountStreet) {
       $this->accountStreet = $accountStreet;
       }
function setAccountCity($accountCity) {
       $this->accountCity = $accountCity;
       }
function setAccountState($accountState) {
       $this->accountState = $accountState;
       }
function setAccountZip($accountZip) {
       $this->accountZip = $accountZip;
       }       
function setAccountPhone($accountPhone) {
       $this->accountPhone = $accountPhone;
       }     
function setAccountEmail($accountEmail) {
       $this->accountEmail = $accountEmail;
       }    
function setAccountLicense($accountLicense) {
       $this->accountLicense = $accountLicense;
       }                 
       

function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setCashPayment($cashPayment) {
       $this->cashPayment = $cashPayment;
       }
function setCreditPayment($creditPayment) {
       $this->creditPayment = $creditPayment;
       }
function setAchPayment($achPayment) {
       $this->achPayment = $achPayment;
       }
function setCheckPayment($checkPayment) {
       $this->checkPayment = $checkPayment;
       }  
function setCheckNumber($checkNumber) {
       $this->checkNumber = $checkNumber;
       }                


//prepayments
function setMonthlyPayment($monthlyPayment) {
       $this->monthlyPayment = $monthlyPayment;
       }
function setPrepayRestartDate($prepayRestartDate) {
       $this->prepayRestartDate = $prepayRestartDate;
       }
function setPrepayNumMonths($prepayNumMonths) {
       $this->prepayNumMonths = $prepayNumMonths;
       }
function setPrepayTotal($prepayTotal) {    
       $this->prepayTotal = $prepayTotal;
       }
function setKeyList($keyList) {
       $this->keyList = $keyList;
       }
       
//paymnet history
function setPaymentDescription($paymentDescription) {
       $this->paymentDescription = $paymentDescription;
       }
function setTodaysPayment($todaysPayment) {
       $this->todaysPayment = $todaysPayment;
       }
function setDueDate($dueDate) {
       $this->dueDate = $dueDate;
       }
function cardNumber($card_number) {
       $this->cardNumber = $card_number;
       }       
function cardType($card_type) {
       $this->cardType = $card_type;
       }   
function cardName($card_name) {
       $this->cardName = $card_name;
       } 
function cardCVV($card_cvv) {
       $this->cardCVV = $card_cvv;
       }  
function cardMonth($card_month) {
       $this->cardMonth = $card_month;
       }
function cardYear($card_year) {
       $this->cardYear = $card_year;
       }       
             
function accountType($account_type) {
       $this->accountType = $account_type;
       }   
function accountName($account_name) {
       $this->accountName = $account_name;
       }   
function accountNumber($account_num) {
       $this->accountNumber = $account_num;
       }       
function routingNumber($aba_num) {
       $this->routingNumber = $aba_num;
       }       
function setMonthlyBillingType($month_billing_type){
    $this->monthlyBillingType = $month_billing_type;
}

function setPrepayRestartDateRate($prepay_restart_date_rate){
    $this->prepayRestartDateRate = $prepay_restart_date_rate;
}

function setPrepayRestartDateEnhance($prepay_restart_date_enhance){
    $this->prepayRestartDateEnhance = $prepay_restart_date_enhance;
}

function setPrepayRestartDateMaint($prepay_restart_date_m){
    $this->prepayRestartDateMaint = $prepay_restart_date_m;
}

function setPrepayTotalRate($prepay_total_rate){
    $this->prepay_total_rate = $prepay_total_rate;
}

function setPrepayTotalEnhance($prepay_total_enhance){
    $this->prepay_total_enhance = $prepay_total_enhance;
}

function setPrepayTotalMaint($prepay_total_maint){
    $this->prepay_total_maint = $prepay_total_maint;
}

//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

   /* //==================================================================
    function deleteSubscription(){
        
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
        
        $dbMain = $this->dbconnect();
        
         if ($this->ccAuthReasonCode2 != 100) {
                
              $sql = "INSERT INTO failed_deletions VALUES (?,?,?)";
              $stmt1 = $dbMain->prepare($sql);
              $stmt1->bind_param('isi', $this->contractKey, $this->subscriptionID, $this->ccAuthReasonCode2);

              if (!$stmt1->execute()) {  
                    printf("Error: %s.insert failed delete\n", $stmt1->error);
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

  /*  }
    //===================================================================
    function alterCCSubscription()
    {
        $fieldParse = new parseGatewayFields();
        $fieldParse->setCardName($this->cardName);
        $fieldParse->setCardType($this->cardType);
        $fieldParse->setCardExpDate($this->cardExpDate);
        $fieldParse->parsePaymentFields();

        //reassign vars for CS Credit Cards
        $this->ccFirstName = $fieldParse->getCredtCardFirstName();
        $this->ccLastName = $fieldParse->getCredtCardLastName();
        $this->ccCardType = $fieldParse->getCardType();
        $this->ccCardYear = $fieldParse->getCardYear();
        $this->ccCardMonth = $this->cardMonth;
        $this->ccCardNumber = $this->cardNumber;
        $this->ccCardCvv = $this->cardCvv;
            
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
            $billTo->street1 = $this->accountStreet;
            $billTo->city = $this->accountCity;
            $billTo->state = $this->accountState;
            $billTo->postalCode = $this->accountZip;
            $billTo->country = "US";
            $billTo->email = $this->accountEmail;
            $billTo->phoneNumber = $this->accountPhone;
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
            $recurringSubscriptionInfo->startDate = $this->prepayRestartDate; // need to find code YYYYMMDD
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
	$billTo->firstName = $this->achFirstName;
     $billTo->lastName = $this->achLastName;
     $billTo->street1 = $this->accountStreet;
     $billTo->city = $this->accountCity;
     $billTo->state = $this->accountState;
     $billTo->postalCode = $this->accountZip;
     $billTo->country = "US";
     $billTo->email = $this->accountEmail;
     $billTo->phoneNumber = $this->accountPhone;
     $billTo->driversLicenseNumber = $this->accountLicense;
     $billTo->driversLicenseState = $this->accountState;
     $request->billTo = $billTo;

	$check = new stdClass();
	 $check->accountNumber = $this->accountNumber;
     $check->accountType = "C";
     $check->bankTransitNumber = $this->routingNumber;
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
    $recurringSubscriptionInfo->startDate = $this->prepayRestartDate;// need to find code YYYYMMDD
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
//===================================================================================================================
function loadBillingCycle() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT cycle_date, monthly_billing_type  FROM monthly_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date, $monthly_billing_type);
$stmt->fetch();
$stmt->close();

/*$stmt = $dbMain->prepare("SELECT subscription_id FROM cs_subscriptions WHERE contract_key = '$this->contractKey' AND subscription_type = 'MS' ");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($subscription_id);
$stmt->fetch();
$stmt->close();*/

$cycle_day = date("d", strtotime($cycle_date));
$this->pastDay = $past_day;
$this->cycleDay = $cycle_day;
$this->monthlyBillingType = $monthly_billing_type;
//$this->subscriptionID = $subscription_id;


}
//--------------------------------------------------------------------------------------------------------------------
function insertPaymentHistory() {

  // require('../helper_apps/paymentHistory.php');  

$dbMain = $this->dbconnect();


$balanceDue = 0;
$processDate = date("Y-m-d");
$historyDueStatus = 'PF';

$statusKey = 0;

//here we check for null vals in the payment types and convert them to 0 for insert
if($this->creditPayment == "") {
   $creditPayment = 0;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }else{
   $creditPayment = $this->prepay_total_rate;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }
  
if($this->achPayment == "") {
  $achPayment = 0;
  $achRequestId =  $_SESSION['ach_request_id'];
  }else{
  $achPayment = $this->prepay_total_rate;
  $achRequestId =  $_SESSION['ach_request_id'];
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
   $cashPayment = $this->prepay_total_rate;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->prepay_total_rate;
  }

$checkNumber = $this->checkNumber;
$this->prepay_total_rate = trim($this->prepay_total_rate);
if($this->prepay_total_rate != ""){
   $paymentDescription = "Guarentee Fee Prepayment";
    $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iiddssssiddddisiiiiss', $this->historyKey, $this->contractKey, $this->prepay_total_rate, $balanceDue, $processDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $this->bundled, $this->rejectFeeCheck, $this->rejectFeeCredit, $this->rejectFeeAch, $this->lateFeeAll, $ccRequestId, $achRequestId);
    if(!$stmt->execute())  {
    	printf("Error: %s.\n  function paymentHistory table payment_history insert1111111", $stmt->error);
       }	
    $newStatusKey = $stmt->insert_id;   
    $stmt->close(); 
    
    if($this->transKey != null) {
      $adjustedStatusKey = $this->transKey;
      }else{
      $adjustedStatusKey = $newStatusKey;
      }
    //here we update the table with the newHistory key.  if there is a problem with the transaction at a later date we will adapt this key as a common key.
    $sql = "UPDATE payment_history SET trans_key= ? WHERE history_key = '$newStatusKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('i',  $adjustedStatusKey);
    if(!$stmt->execute())  {
    	printf("Error: %s.\n function paymentHistory table payment_history update", $stmt->error);
       }		
    $stmt->close(); 
}


//=============================
if($this->creditPayment == "") {
   $creditPayment = 0;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }else{
   $creditPayment = $this->prepay_total_enhance;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }
  
if($this->achPayment == "") {
  $achPayment = 0;
  $achRequestId =  $_SESSION['ach_request_id'];
  }else{
  $achPayment = $this->prepay_total_enhance;
  $achRequestId =  $_SESSION['ach_request_id'];
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
   $cashPayment = $this->prepay_total_enhance;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->prepay_total_enhance;
  }
$this->prepay_total_enhance = trim($this->prepay_total_enhance);
if($this->prepay_total_enhance != ""){
        $paymentDescription = "Enhance Fee Prepayment";
        $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiddssssiddddisiiiiss', $this->historyKey, $this->contractKey, $this->prepay_total_enhance, $balanceDue, $processDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $this->bundled, $this->rejectFeeCheck, $this->rejectFeeCredit, $this->rejectFeeAch, $this->lateFeeAll, $ccRequestId, $achRequestId);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n  function paymentHistory table payment_history insert222222", $stmt->error);
           }	
        $newStatusKey = $stmt->insert_id;   
        $stmt->close(); 
        
        if($this->transKey != null) {
          $adjustedStatusKey = $this->transKey;
          }else{
          $adjustedStatusKey = $newStatusKey;
          }
        //here we update the table with the newHistory key.  if there is a problem with the transaction at a later date we will adapt this key as a common key.
        $sql = "UPDATE payment_history SET trans_key= ? WHERE history_key = '$newStatusKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('i',  $adjustedStatusKey);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function paymentHistory table payment_history update", $stmt->error);
           }		
        $stmt->close();
}
//===========================================================================
if($this->creditPayment == "") {
   $creditPayment = 0;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }else{
   $creditPayment = $this->prepay_total_maint;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }
  
if($this->achPayment == "") {
  $achPayment = 0;
  $achRequestId =  $_SESSION['ach_request_id'];
  }else{
  $achPayment = $this->prepay_total_maint;
  $achRequestId =  $_SESSION['ach_request_id'];
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
   $cashPayment = $this->prepay_total_maint;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->prepay_total_maint;
  }
$this->prepay_total_maint = trim($this->prepay_total_maint);
if($this->prepay_total_maint != ""){
        $paymentDescription = "Maintenance Fee Prepayment";
        $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiddssssiddddisiiiiss', $this->historyKey, $this->contractKey, $this->prepay_total_maint, $balanceDue, $processDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $this->bundled, $this->rejectFeeCheck, $this->rejectFeeCredit, $this->rejectFeeAch, $this->lateFeeAll, $ccRequestId, $achRequestId);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n  function paymentHistory table payment_history insert3333333", $stmt->error);
           }	
        $newStatusKey = $stmt->insert_id;   
        $stmt->close(); 
        
        if($this->transKey != null) {
          $adjustedStatusKey = $this->transKey;
          }else{
          $adjustedStatusKey = $newStatusKey;
          }
        //here we update the table with the newHistory key.  if there is a problem with the transaction at a later date we will adapt this key as a common key.
        $sql = "UPDATE payment_history SET trans_key= ? WHERE history_key = '$newStatusKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('i',  $adjustedStatusKey);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function paymentHistory table payment_history update", $stmt->error);
           }		
        $stmt->close();
}
//============================================
if($this->creditPayment == "") {
   $creditPayment = 0;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }else{
   $creditPayment = $this->todaysPayment;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }
  
if($this->achPayment == "") {
  $achPayment = 0;
  $achRequestId =  $_SESSION['ach_request_id'];
  }else{
  $achPayment = $this->todaysPayment;
  $achRequestId =  $_SESSION['ach_request_id'];
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
   $cashPayment = $this->todaysPayment;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->todaysPayment;
  }
$this->todaysPayment = trim($this->todaysPayment);
if($this->todaysPayment != ""){
        $paymentDescription = "Monthly Service Prepayment";
        $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiddssssiddddisiiiiss', $this->historyKey, $this->contractKey, $this->todaysPayment, $balanceDue, $processDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $this->bundled, $this->rejectFeeCheck, $this->rejectFeeCredit, $this->rejectFeeAch, $this->lateFeeAll, $ccRequestId, $achRequestId);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n  function paymentHistory table payment_history insert", $stmt->error);
           }	
        $newStatusKey = $stmt->insert_id;   
        $stmt->close(); 
        
        if($this->transKey != null) {
          $adjustedStatusKey = $this->transKey;
          }else{
          $adjustedStatusKey = $newStatusKey;
          }
        //here we update the table with the newHistory key.  if there is a problem with the transaction at a later date we will adapt this key as a common key.
        $sql = "UPDATE payment_history SET trans_key= ? WHERE history_key = '$newStatusKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('i',  $adjustedStatusKey);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function paymentHistory table payment_history update 44444", $stmt->error);
           }		
        $stmt->close();
 }
}
//-------------------------------------------------------------------------------------------------------------------
function savePrePayment() {

$dbMain = $this->dbconnect();

$this->prepayRestartDate = trim($this->prepayRestartDate);
if($this->prepayRestartDate != "19691231"){
$paymentDate = date("Y-m-d");
//reformat the restart date for insert
$d =  strtotime($this->prepayRestartDate);
$restartDate = date("Y-m-d", $d);

$stmt = $dbMain ->prepare("SELECT count(*) as count, num_months, payment_amount, service_keys FROM pre_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $num_months, $payment_amount, $service_keys);
$stmt->fetch();
$stmt->close();

if ($count == 0){
    $sql = "INSERT INTO pre_payments VALUES (?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiidsssd', $this->prepayKey, $this->contractKey, $this->prepayNumMonths, $this->prepayTotal, $this->keyList, $paymentDate, $restartDate, $this->monthlyPayment);
if(!$stmt->execute())  {
	printf("Error: %s.\n  function processPrepayment table pre_payments insert", $stmt->error);
   }	
$stmt->close();
}else{
     $months = $this->prepayNumMonths+$num_months;
     $amount = $payment_amount+$this->prepayTotal;
     $service_keys .= ",$this->keyList";
    
     $sql = "UPDATE pre_payments SET num_months = ?, payment_amount = ?, service_keys = ?, payment_date = ?, restart_date = ? ,restart_payment = ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('idsssd', $months, $amount, $service_keys, $paymentDate, $restartDate, $this->monthlyPayment);
     if(!$stmt->execute())  {
    	printf("Error:updateEHFEE %s.\n", $stmt->error);
     }	
     $stmt->close();
}



}
$this->saveMonthlySettled();

}
//---------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();
//echo "test $this->prepayRestartDate";
$this->prepayRestartDate = trim($this->prepayRestartDate);
if($this->prepayRestartDate != "19691231"){
    $transKey =  rand(100, 10000);
    $paymentDate = date("Y-m-d H:i:s");
    
    $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM monthly_settled WHERE contract_key = '$this->contractKey' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);    
    $stmt->fetch();
    $stmt->close(); 
    
    $prepayRestartDateSecs =  strtotime($this->prepayRestartDate);
         $pastDaysDueSecs = $this->pastDay * 86400;
         $nextPaymentDueDateSecs = $prepayRestartDateSecs + $pastDaysDueSecs + 86399;
         $nextPaymentDueDate = date("Y-m-d H:i:s",  $nextPaymentDueDateSecs);
         
         $monthlyBillingType = $this->monthlyBillingType;
         
    if ($count == 0){
        $sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iidsss', $this->contractKey, $transKey, $this->prepayTotal, $paymentDate, $nextPaymentDueDate, $monthlyBillingType);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
           }		
        $stmt->close(); 
    }else{
        
        $sql = "UPDATE monthly_settled SET next_payment_due_date =?,  payment_date =?  WHERE contract_key = '$this->contractKey' ";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ss', $nextPaymentDueDate, $paymentDate);
        if(!$stmt->execute())  {
        	printf("Error: update prepay %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
    }
}
//echo "test $this->prepayRestartDateRate";
$this->prepayRestartDateRate = trim($this->prepayRestartDateRate);
if($this->prepayRestartDateRate != ""){
    $this->prepayRestartDateRate = date('Y-m-d H:i:s',strtotime($this->prepayRestartDateRate));
     $sql = "UPDATE member_guarantee_eft SET eft_cycle_date =?  WHERE contract_key = '$this->contractKey' ";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $this->prepayRestartDateRate);
        if(!$stmt->execute())  {
        	printf("Error: update prepay %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
    }

$this->prepayRestartDateEnhance = trim($this->prepayRestartDateEnhance);
if($this->prepayRestartDateEnhance != ""){
     $this->prepayRestartDateEnhance = date('Y-m-d H:i:s',strtotime($this->prepayRestartDateEnhance));
     $sql = "UPDATE member_enhance_eft SET eft_cycle_date =?  WHERE contract_key = '$this->contractKey' ";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $this->prepayRestartDateEnhance);
        if(!$stmt->execute())  {
        	printf("Error: update prepay %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
    }
 // echo "testtetetet $this->prepayRestartDateMaint";  
$this->prepayRestartDateMaint = trim($this->prepayRestartDateMaint);
if($this->prepayRestartDateMaint != ""){
    
     $this->prepayRestartDateMaint = date('Y-m-d H:i:s',strtotime($this->prepayRestartDateMaint));
     $sql = "UPDATE member_maintnence_eft SET m_cycle_date =?  WHERE contract_key = '$this->contractKey' ";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $this->prepayRestartDateMaint);
        if(!$stmt->execute())  {
        	printf("Error: update prepay %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
    }





}
//--------------------------------------------------------------------------------------------------------------



}
?>