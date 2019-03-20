<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
class serviceCreditCS {

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

function setMonthlybillingType($monthlyBillingType){
    $this->monthlyBillingType = $monthlyBillingType;
}
function setCreditSecs($creditSecs){
    $this->creditSecs = $creditSecs;
}
function setServiceTerm($serviceCreditTerm){
    $this->serviceCreditTerm = $serviceCreditTerm;
}
function setServiceKey($serviceKey){
    $this->serviceKey = $serviceKey;
}
function setContractKey($contractKey){
    $this->contractKey = $contractKey;
}
function  setBool($addSubBool){
    $this->addSubBool = $addSubBool;
}
//===================================================================
function addClass(){
    
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain-> prepare("SELECT class_count FROM member_class_count WHERE service_key = '$this->serviceKey' AND contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($c_total);
    $stmt->fetch();
    $stmt->close();
    
    
    $c_total = trim($c_total);
    
    if (($c_total == '') OR ($c_total == '0')){
    $stmt = $dbMain-> prepare("SELECT class_count  FROM schedular_member_class_count WHERE service_key = '$this->serviceKey' AND sm_contract_key = '$this->contractKey' LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($c_total);
    $stmt->fetch();   
    $stmt->close();
    
    $c_total = trim($c_total);
    
    }
    if ($c_total == ''){
        
        $stmt = $dbMain-> prepare("SELECT member_id  FROM member_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($member_id);
        $stmt->fetch();   
        $stmt->close();
        
        $contractKey = $this->contractKey;
        $barcode = $member_id;
        $serviceKey = $this->serviceKey;
        $classCount = $this->creditSecs;
        
        
        $dbMain = $this->dbconnectTwo();
    	$sql = "INSERT INTO schedular_member_class_count VALUES (?,?,?,?)";
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('iiii',$contractKey, $barcode, $serviceKey, $classCount);
    	if(!$stmt->execute())  {
                	printf("Error:class_count %s.\n", $stmt->error);
                      }	
    	$stmt->close();    
    }else{
        $classCount =  $this->creditSecs + $c_total;
        $sql = "UPDATE schedular_member_class_count SET class_count = ? WHERE sm_contract_key = '$this->contractKey' AND service_key = '$this->serviceKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('i',  $classCount);
        if(!$stmt->execute())  {
                    	printf("Error:updateschedclaasscount %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    
}
//===================================================================
/*function loadMemberInfo(){
    
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT street, city, state, zip, email, license_number, primary_phone FROM contract_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($street, $city, $state, $zip, $email, $license_number, $primary_phone);
    $stmt->fetch();
    $stmt->close();
    
    $this->street = trim($street);
    $this->city = trim($city);
    $this->state = trim($state);
    $this->zip = trim($zip);
    $this->email = trim($email);
    $this->licenseNumber = trim($license_number);
    $this->phone = trim($primary_phone);
}*/
//=================================================================
/*function createServiceDates() {
    
    $dbMain = $this->dbconnect();

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($this->creditSecs / $secondsInADay);

    // extract hours
    $hourSeconds = $this->creditSecs % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    
    


    $stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date), payment_amount  FROM monthly_settled WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($next_payment_due_date, $payment_amount);
    $stmt->fetch();
    $stmt->close();
    
    $next_payment_due_date = trim($next_payment_due_date);
    
    if ($next_payment_due_date == ''){
        $stmt = $dbMain ->prepare("SELECT cycle_date, billing_amount  FROM monthly_payments WHERE contract_key ='$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($next_payment_due_date, $payment_amount);
        $stmt->fetch();
        $stmt->close();
    }
    
    $stmt = $dbMain ->prepare("SELECT unit_price, MAX(signup_date), number_months  FROM monthly_services WHERE contract_key ='$this->contractKey' AND service_key = '$this->serviceKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($unit_price, $signup_date, $number_months);
    $stmt->fetch();
    $stmt->close();
    
    $unit_price = $unit_price/$number_months;
    
    
    $day = date("d", strtotime($next_payment_due_date));
    $month = date("m", strtotime($next_payment_due_date));
    $year = date("Y", strtotime($next_payment_due_date));
    
     switch($this->serviceCreditTerm) {     
                        case"D":
                        $this->serviceStartDate = date("Ymd", mktime(0, 0, 0, $month, $day+$days, $year));
                        $this->numPayments = $days;
                        $this->frequency = "daily";
                        break; 
                        case"W":
                        $temp = sprintf("%01.0f", $days/7);
                        $this->serviceStartDate = date("Ymd", mktime(0, 0, 0, $month, $day+$days, $year)); 
                        $this->numPayments = $temp;
                        $this->frequency = "weekly";
                        break; 
                        case"M":
                        $temp = sprintf("%01.0f", $days/30);
                        $this->serviceStartDate = date("Ymd", mktime(0, 0, 0, $month+$temp, $day, $year));
                        $this->numPayments = $temp;
                        $this->frequency = "monthly";
                        break; 
                        case"Y":
                        $temp = sprintf("%01.0f", $days/365);
                        $this->serviceStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year+$temp2));
                        $this->frequency = "yearly";
                        $this->numPayments = $temp;
                        break; 
                      }
                      
    $this->tempServiceStartDate = date("Ymd", strtotime($next_payment_due_date));
    $this->tempServicePaymentAmout = sprintf("%01.2f", $payment_amount-$unit_price);
    $this->monthlyPayment = $payment_amount;
    

   
}
//==================================================================
     function deleteSubscription(){
        
        $dbMain = $this->dbconnect();
        
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
                
              $sql = "INSERT INTO failed_deletions VALUES (?,?,?)";
              $stmt1 = $dbMain->prepare($sql);
              $stmt1->bind_param('isi', $this->contractKey, $this->subscriptionID,  $this->ccAuthReasonCode2);

              if (!$stmt1->execute()) {  
                    printf("Error: %s.inswert failed delete \n", $stmt1->error);
                }
               $stmt1->close();
                 //$this->paymentStatus = 2;  
            }
       //$this->price = $reply2->paySubscriptionRetrieveReply->recurringAmount;
        $this->city = $reply2->paySubscriptionRetrieveReply->city;
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
        }

    }*/
    //===================================================================
 /*   function alterCCSubscription()  {
        
    $dbMain = $this->dbconnect();
    
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


            $recurringSubscriptionInfo->frequency = $this->frequency; //mo clue
            $recurringSubscriptionInfo->amount = $this->monthlyPayment;
            $recurringSubscriptionInfo->startDate = $this->serviceStartDate; // need to find code YYYYMMDD
            $request3->recurringSubscriptionInfo = $recurringSubscriptionInfo;


            $subscription->paymentMethod = "credit card";
            $subscription->title = 'Monthly Dues CC';
            $request3->subscription = $subscription;


            $reply3 = $soapClient->runTransaction($request3);
            
            //var_dump($request3);

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

        


    }*/
//===========================================================================================
/*function ccTempSubscription(){
    $dbMain = $this->dbconnect();
    
    
    
    if($this->tempServicePaymentAmout != '0.00'){
        
    $stmt = $dbMain ->prepare("SELECT subscription_id  FROM cs_service_credit_subscriptions WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($subscription_id);
    $stmt->fetch();
    $stmt->close();
    
    $subscription_id = trim($subscription_id);
    
    if ($subscription_id != ''){
        $this->subscriptionID = $subscription_id;
        $this->deleteSubscription();
    }
        
    
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

            $recurringSubscriptionInfo->amount = $this->tempServicePaymentAmout;
            $recurringSubscriptionInfo->numberOfPayments = $this->numPayments;
            $recurringSubscriptionInfo->automaticRenew = "false";
            $recurringSubscriptionInfo->frequency = $this->frequency; //mo clue
            $recurringSubscriptionInfo->startDate = $this->tempServiceStartDate; // need to find code YYYYMMDD
            $request3->recurringSubscriptionInfo = $recurringSubscriptionInfo;



            $subscription->paymentMethod = "credit card";
            $subscription->title = 'Monthly Dues CC';
            $request3->subscription = $subscription;


            $reply3 = $soapClient->runTransaction($request3);
            
            // var_dump($request3);

            $ccAuthDecision = $reply3->decision;
            $ccAuthReasonCode = $reply3->reasonCode;
            $ccAuthRequestId = $reply3->requestID;
            $subscriptionID = $reply3->paySubscriptionCreateReply->subscriptionID;

            $subscripType = 'MS';
            $monthlyBillingType = 'CR';
            $frequency = "monthly";
    
    
    if ($ccAuthReasonCode == 100) {
        
        $stmt = $dbMain ->prepare("SELECT subscription_id  FROM cs_service_credit_subscriptions WHERE contract_key ='$this->contractKey' AND subscription_type = 'MS'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($subscription_id);
        $stmt->fetch();
        $stmt->close();
        
        $subscription_id = trim($subscription_id);
        
        if ($subscription_id == ''){
            $sql = "INSERT INTO cs_service_credit_subscriptions VALUES (?,?,?,?,?)";
            $stmt1 = $dbMain->prepare($sql);
            $stmt1->bind_param('isssd', $this->contractKey, $subscriptionID, $monthlyBillingType, $subscripType, $this->tempServicePaymentAmout);

            if (!$stmt1->execute()) {
                printf("Error: %s.inswert failed trans\n", $stmt1->error);
            }
            
            $stmt1->close();
        }else{
            $sql = "UPDATE cs_service_credit_subscriptions  SET subscription_id = ?, service_credit_monthly_payment = ?  WHERE contract_key = '$this->contractKey' AND subscription_type ='MS'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('sd', $subscriptionID, $this->tempServicePaymentAmout);
            if (!$stmt->execute()) {
                               printf("Error: %s.insert subscrip\n", $stmt->error);
            }
    
            $stmt->close();
        }
        $this->paymentStatus = 1; 
                                        
            } else {

                $sql = "INSERT INTO failed_subscriptions VALUES (?,?,?,?,?,?)";
                $stmt1 = $dbMain->prepare($sql);
                $stmt1->bind_param('issdis', $this->contractKey, $subscripType, $monthlyBillingType, $this->monthlyPayment, $ccAuthReasonCode, $frequency);

                if (!$stmt1->execute()) {
                    printf("Error: %s.inswert failed trans\n", $stmt1->error);
                }

                $stmt1->close();
                //$this->paymentStatus = 2;  
            }
            }
}
//===================================================================
function alterACHSubscription(){
    
    $dbMain = $this->dbconnect();
    
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
    $recurringSubscriptionInfo->frequency = $this->frequency; //mo clue
    $recurringSubscriptionInfo->amount = $this->monthlyPayment;
    $recurringSubscriptionInfo->startDate = $this->serviceStartDate;// need to find code YYYYMMDD
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
    
    
}
//[=============================[==========================================================================]]
function achTempSubscription(){
    
    if($this->tempServicePaymentAmout != '0.00'){
    
     $dbMain = $this->dbconnect();
     
      $stmt = $dbMain ->prepare("SELECT subscription_id  FROM cs_service_credit_subscriptions WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($subscription_id);
    $stmt->fetch();
    $stmt->close();
    
    $subscription_id = trim($subscription_id);
    
    if ($subscription_id != ''){
        $this->subscriptionID = $subscription_id;
        $this->deleteSubscription();
    }
    
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
    $recurringSubscriptionInfo->frequency = $this->frequency; //mo clue
    $recurringSubscriptionInfo->amount = $this->tempServicePaymentAmout;
    $recurringSubscriptionInfo->startDate = $this->tempServiceStartDate;// need to find code YYYYMMDD
    $recurringSubscriptionInfo->numberOfPayments = $this->numPayments;
    $recurringSubscriptionInfo->automaticRenew = "false";
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
                
        $stmt = $dbMain ->prepare("SELECT subscription_id  FROM cs_service_credit_subscriptions WHERE contract_key ='$this->contractKey' AND subscription_type = 'MS'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($subscription_id);
        $stmt->fetch();
        $stmt->close();
        
        $subscription_id = trim($subscription_id);
        
        if ($subscription_id == ''){
            $sql = "INSERT INTO cs_service_credit_subscriptions VALUES (?,?,?,?,?)";
            $stmt1 = $dbMain->prepare($sql);
            $stmt1->bind_param('isssd', $this->contractKey, $subscriptionID, $monthlyBillingType, $subscripType, $this->tempServicePaymentAmout);

            if (!$stmt1->execute()) {
                printf("Error: %s.inswert failed trans\n", $stmt1->error);
            }
            
            $stmt1->close();
        }else{
            $sql = "UPDATE cs_service_credit_subscriptions  SET subscription_id = ?, service_credit_monthly_payment = ?  WHERE contract_key = '$this->contractKey' AND subscription_type ='MS'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('sd', $subscriptionID, $this->tempServicePaymentAmout);
            if (!$stmt->execute()) {
                               printf("Error: %s.insert subscrip\n", $stmt->error);
            }
    
            $stmt->close();
        }
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
    
    if ($ccAuthReasonCode == 100) {
                
        $sql = "UPDATE cs_service_credit_subscriptions  SET subscription_id = ?  WHERE contract_key = '$this->contractKey' AND subscription_type ='MS'";
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
}
//===================================================
function loadSubscription(){
    
      $dbMain = $this->dbconnect();
    $stmt = $dbMain->prepare("SELECT subscription_id, billing_type FROM cs_subscriptions WHERE contract_key = '$this->contractKey' AND subscription_type = 'MS' ");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($subscription_id, $billing_type);
    $stmt->fetch();
    $stmt->close();
    
    $subscription_id = trim($subscription_id);
    //echo "fubar $this->billingType $this->ccAuthReasonCode2";
// exit;
    if ($subscription_id != '') {
    
    $this->subscriptionID = $subscription_id;
    $this->billingType = $billing_type;
    
    $this->deleteSubscription();
    $this->loadMemberInfo();
 
 
    if ($this->billingType == 'CR' AND $this->ccAuthReasonCode2 == '100'){
       
            $stmt = $dbMain->prepare("SELECT card_fname, card_lname, card_number, card_cvv, card_exp_date, card_type FROM credit_info WHERE contract_key = '$this->contractKey'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($this->ccFirstName, $this->ccLastName, $this->ccCardNumber, $this->ccCardCvv, $expDate,  $cardType);
            $stmt->fetch();
            $stmt->close();
            
            $this->ccFirstName = trim($this->ccFirstName);
            $this->ccLastName = trim($this->ccLastName);
            $this->ccCardNumber = trim($this->ccCardNumber);
            $this->ccCardCvv = trim($this->ccCardCvv);
            $expDate = trim($expDate);
            $cardType = trim($cardType);
            
            
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
        
       // $this->billingDate = date("Ymd",strtotime($this->prepayRestartDate));
        //echo "$this->billingDate";
        
        $this->alterCCSubscription();
        $this->ccTempSubscription();
        
    }elseif ($this->billingType == 'BA' AND $this->ccAuthReasonCode2 == '100'){
        $stmt = $dbMain->prepare("SELECT account_fname, account_lname, account_number, routing_number FROM banking_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->ACHFirstName, $this->ACHLastName, $this->accountNumber, $this->abaNumber);
        $stmt->fetch();
        $stmt->close();
        
        $this->ACHFirstName = trim($this->ACHFirstName);
        $this->ACHLastName = trim($this->ACHLastName);
        $this->accountNumber = trim($this->accountNumber);
        $this->abaNumber = trim($this->abaNumber);
        
        //$process = new processPrePayment();
        //$process->setContractKey($contract_key);
       // $process->setPrepayRestartDate($pre_pay_restart_date);
        //$this->billingDate = date("Ymd", strtotime($this->prepayRestartDate));
        
        $this->alterACHSubscription();
        $this->achTempSubscription();
    }
    
 }
}*/
//================================================================================================
function extendPIFMembership(){
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT MAX(service_id), MAX(end_date) FROM paid_full_services WHERE contract_key = '$this->contractKey' AND service_term != 'C' AND service_key = '$this->serviceKey'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($service_id, $end_date);
    $stmt->fetch();
    $stmt->close();
    
    $day = date("d", strtotime($end_date));
    $month = date("m", strtotime($end_date));
    $year = date("Y", strtotime($end_date));
    
    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($this->creditSecs / $secondsInADay);

    // extract hours
    $hourSeconds = $this->creditSecs % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    //echo "fgdfgdgdfgdfgdfgd $this->addSubBool vxcvxcvxcv $this->creditSecs";
   // if($this->addSubBool == 1){
         switch($this->serviceCreditTerm) {     
                        case"D":
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day+$days, $year));
                        break; 
                        case"W":
                        //$temp = sprintf("%01.0f", $days/7);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day+$days, $year)); 
                        break; 
                        case"M":
                        $temp = sprintf("%01.0f", $days/30);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month+$temp, $day, $year));
                        break; 
                        case"Y":
                        $temp = sprintf("%01.0f", $days/365);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year+$temp));
                        break; 
                      }
    /*}else if($this->addSubBool == 2){
        switch($this->serviceCreditTerm) {     
                        case"D":
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day-$days, $year));
                        break; 
                        case"W":
                        //$temp = sprintf("%01.0f", $days/7);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day-$days, $year)); 
                        break; 
                        case"M":
                        //$temp = sprintf("%01.0f", $days/30);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day-$days, $year));
                        break; 
                        case"Y":
                        $temp = sprintf("%01.0f", $days/365);
                        $newEndDate = date("Ymd", mktime(0, 0, 0, $month, $day-$days, $year));
                        break; 
                      }
    }*/
    
    $sql = "UPDATE paid_full_services  SET end_date = ?  WHERE contract_key = '$this->contractKey' AND service_id ='$service_id'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $newEndDate);
        if (!$stmt->execute()) {
                           printf("Error: %s.update PIF endate\n", $stmt->error);
        }

        $stmt->close();                  
    
    
    
    
}
//==============================================================================================
function changeMonthlySettledDate(){
    
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->pastDays); 
    $stmt->fetch();
    $stmt->close();
    
    $this->nextPaymentDueDate = "";
    $stmt = $dbMain->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->nextPaymentDueDate); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT DAY(cycle_date) FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->cycleDay); 
    $stmt->fetch();
    $stmt->close();
    
    $months = round($this->creditSecs/86400/30);
    
    $secsMinus = $this->pastDays*86400;
    $month = date('m',strtotime($this->nextPaymentDueDate)-$secsMinus);
    $day = date('d',strtotime($this->nextPaymentDueDate)-$secsMinus);
    $year = date('y',strtotime($this->nextPaymentDueDate)-$secsMinus);
    
    $realDate = date('Y-m-d H:i:s',mktime(23,59,59,$month,$day,$year)); 
    
    $newSettledDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m',strtotime($realDate))+$months,$this->cycleDay+$this->pastDays,date('Y',strtotime($realDate)))); //
    
   // echo "$realDate $newSettledDate   secs $secsMinus pastDays  $this->pastDays $month $day $year   month $months cycday $this->cycleDay";
   // exit;
    
    $sql = "UPDATE monthly_settled SET next_payment_due_date = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s', $newSettledDate);
    if(!$stmt->execute())  {
 	  printf("Error:updateEHFEE %s.\n", $stmt->error);
     }	          
    $stmt->close();
  
    
    
}

//==============================================================================================
function moveData(){
    $dbMain = $this->dbconnect();
    //echo "fubar";
    //exit;
    if($this->serviceCreditTerm == 'C'){
        $this->addClass();
    }else{
        
      $stmt = $dbMain->prepare("SELECT service_term FROM service_cost WHERE service_key = '$this->serviceKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($service_term);
        $stmt->fetch();
        $stmt->close();
        
        
        if ($service_term == 'M'){
            //$this->createServiceDates();
        //$this->loadSubscription();
          $this->changeMonthlySettledDate();
        }else{
            $this->extendPIFMembership();
        }   
    }
    
    
    
}

//===========================================================================================================
}


?>