<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
require"../nmi/nmiGatewayClass.php";
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";

class  upgradeSql {

private $contractId = null;
private $generalId = null;
private $groupType = null;
private $groupInfoArray = null;
private $addressInfoArray = null;
private $productListArray = null;
private $newMembers = null;
private $groupNumber = null;
private $currentProrateArray = null;
private $transfer = null;
private $proRateDues = null;
private $procFeeEft = null;
private $initialFeesEft = null;  //tese are the combined fees and prorates for both current and new monthly services 
private $monthlyPayment = null;
private $newMonthlyPayment = null;
private $currentMonthlyProrate = null;
private $totalMonthlyServices = null;
private $monthlyBillingType = null;
private $originalMonthlyBillingType =null;
private $initiationFee = null;
private $newTotalPifServices = null;
private $procFeePif = null;
private $newPifGrandTotal = null;
private $currentPifProrateTotal = null;
private $newCurrentPifGrandTotal = null;
private $currentRenewTotal = null;
private $currentMonthlyPayment = null;
private $newMemberFee = null;
private $newServicesTotal = null;
private $newRenewalRateTotal = null;
private $minimumTotalDue = null;
private $todaysPayment = null;
private $balanceDue = null;
private $dueDate = null;
private $contractKey = null;
private $contractType = 'U';
private $startDate = null;
private $endDate = null;
private $newComissionId = null;
private $prorateRow = null;
private $historyKey = null;
private $paymentDescription = null;
private $transKey = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $termSwitch = null;
private $enhTermSwitch = null;


//extra fees varables
private $guaranteeFee = null;
private $enhanceFee = null;
private $eftEnhanceCycle = null;
private $pifCycleDate = null;  //this is for enhance fees
private $eftGuaranteeCycle = null;
private $annualCycleDate = null;    //this is for guarantee fees

//for contract printout
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $groupName = null;
private $contractHtml = null;

//address info
private $clientStreet;
private $clientCity;
private $clientState;
private $clientZip;
private $clientHomePhone;
private $clientCellPhone;
private $clientEmail;

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
private $ccRequestId = "";

//for banking
private $bankName = null;
private $accountType = null;
private $accountName = null;
private $accountNumber = null;
private $abaNumber = null;
private $achRequestId = null;

//initial payment types
private $cashPayment = null;
private $creditPayment = null;
private $achPayment = null;
private $checkPayment = null;
private $checkNumber = 0;

//monthly billing
private $monthlyBilling = null;

//override status
private $overidePin = null;

//comission credit
private $newCommissionCredit = null;   //is email address needs to translate to user id
private $typeKey = null;
private $idCard = null;

private $accountStatus = null;
private $renewal = null;
private $upgrade = null;
private $internet = null;
private $termType = null;
private $serviceId = null;
private $statusId = null;

//notes on the contract
private $noteTopic = null;
private $noteMessage = null;
private $noteUser = null;  //this is the user id of the logged in user
private $noteList;  //since there could be lots of notes this will hold a list of these notes 
private $noteCategory = 'US';
private $notePriority = null;
private $targetApp = null;

//cybersource
private $psReasonCode = null;
private $subscriptionID = null;
private $subscriptionType = null;  //cmp type for Monthly Service: MS, Enhance Fee: EF, Rate Guarantee: RG
private $csBillingAmount = null;
private $frequency = null;
private $canceledReasonCode = null;


//these are all of the vars set by the upgrade form
function setGroupType($groupType)  {
              $this->groupType = $groupType;
              }
function setGroupName($groupName)  {
              $this->groupName = $groupName;
              }              
function setGroupInfoArray($groupInfoArray)  {
              $this->groupInfoArray = $groupInfoArray;
              }
function setGroupNumber($groupNumber)  {
              $this->groupNumber = $groupNumber;
              }              
function setAddressInfoArray($addressInfoArray)  {
              $this->addressInfoArray = $addressInfoArray;
              }
function setProductListArray($productListArray)  {
              $this->productListArray = $productListArray;
              }
function setNewMembers($newMembers)  {
              $this->newMembers = $newMembers;
              }
function setCurrentProrateArray($currentProrateArray)  {
              $this->currentProrateArray = $currentProrateArray;
              }
function setTransfer($transfer)  {
              $this->transfer = $transfer;
              }
function setProRateDues($proRateDues)  {
              $this->proRateDues = $proRateDues;
              }
function setProcFeeEft($procFeeEft)  {
              $this->procFeeEft = $procFeeEft;
              }
function setInitialFeesEft($initialFeesEft)  {
              $this->initialFeesEft = $initialFeesEft;
              }
function setMonthlyPayment($monthlyPayment)  {
              $this->monthlyPayment  = $monthlyPayment ;   //this is for new services selected
              }
function setNewMonthlyPayment($newMonthlyPayment)  {
              $this->newMonthlyPayment = $newMonthlyPayment ;   //this shows the combined monthly payment for new and current services
              }
function setCurrentMonthlyProrate($currentMonthlyProrate)  {
              $this->currentMonthlyProrate= $currentMonthlyProrate;
              }
function setTotalMonthlyServices($totalMonthlyServices)  {
              $this->totalMonthlyServices= $totalMonthlyServices;
              }
function setInitiationFee($initiationFee)  {
              $this->initiationFee= $initiationFee;
              }
function setNewTotalPifServices($newTotalPifServices)  {
              $this->newTotalPifServices= $newTotalPifServices;
              }
function setProcFeePif($procFeePif)  {
              $this->procFeePif= $procFeePif;
              }
function setNewPifgrandTotal($newPifGrandTotal)  {
              $this->newPifGrandTotal= $newPifGrandTotal;
              }
function setCurrentPifProrateTotal($currentPifProrateTotal)  {
              $this->currentPifProrateTotal= $currentPifProrateTotal;
              }
function setNewCurrentPifGrandTotal($newCurrentPifGrandTotal)  {
              $this->newCurrentPifGrandTotal= $newCurrentPifGrandTotal;
              }
function setCurrentRenewTotal($currentRenewTotal)  {
              $this->currentRenewTotal= $currentRenewTotal;
              }
function setCurrentMonthlyPayment($currentMonthlyPayment)  {
              $this->currentMonthlyPayment= $currentMonthlyPayment;
              }
function setNewMemberFee($newMemberFee)  {
              $this->newMemberFee= $newMemberFee;
              }
function setNewServicesTotal($newServicesTotal)  {
              $this->newServicesTotal= $newServicesTotal;
              }
function setNewRenewalRateTotal($newRenewalRateTotal)  {
              $this->newRenewalRateTotal= $newRenewalRateTotal;
              }
function setMinimumTotalDue($minimumTotalDue)  {
              $this->minimumTotalDue= $minimumTotalDue;
              } 
function setTodaysPayment($todaysPayment) {
              $this->todaysPayment = $todaysPayment;
              }           
function setBalanceDue($balanceDue) {
              $this->balanceDue = $balanceDue;
              }
function setDueDate($dueDate) {
              $this->dueDate = $dueDate;
              }
function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }


//for credit cards
function setCardType($cardType) {
       $this->cardType = $cardType;
       }
function setCardName($cardName) {
       $this->cardName = $cardName;
       }
function setCardNumber($cardNumber) {
       $this->cardNumber = $cardNumber;
       }
function setCardCvv($cardCvv) {
       $this->cardCvv = $cardCvv;
       }
function setCardExpDate($cardExpDate) {
       $this->cardExpDate = $cardExpDate;
       }
function setCcRequestId($ccRequestId) {
       $this->ccRequestId = $ccRequestId;
       }       

//for banking info
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
function setAchRequestId($achRequestId) {
     $this->achRequestId = $achRequestId;
     }

//for payments on initial contract
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

//monthly billing type set to credit bank ach check or cash
function setMonthlyBilling($monthlyBilling) {
         $this->monthlyBilling = $monthlyBilling;
         }
function setMonthlyBillingType($monthlyBillingType) {
         $this->monthlyBillingType = $monthlyBillingType;
         }
function setOriginalMonthlyBillingType($originalMonthlyBillingType) {
         $this->originalMonthlyBillingType = $originalMonthlyBillingType;
         }          
         

//overide pin set to either Yif entered or N if not
function setOveridePin($overidePin) {
       $this->overidePin = $overidePin;
       }

//this is for new services
function setNewCommissionCredit($newCommissionCredit) {
     $this->newCommissionCredit = $newCommissionCredit;
     }

function setAccountStatus($accountStatus) {
   $this->accountStatus = $accountStatus;
   }
function setRenewal($renewal) {
   $this->renewal = $renewal;
   }
function setUpgrade($upgrade) {
   $this->upgrade = $upgrade;
   }
function setInternet($internet) {
   $this->internet = $internet;
   }   
function setTermType($termType) {
   $this->termType = $termType;
   }      
   
   

//this is for notes on the contract
function setNoteTopic($noteTopic) {
        $this->noteTopic = $noteTopic;
        }
function setNoteMessage($noteMessage) {
       $this->noteMessage = $noteMessage;
       }       
function setNoteUser($noteUser) {
       $this->noteUser = $noteUser;
       }
function setNotePriority($notePriority) {
       $this->notePriority = $notePriority;
       }  
function setTargetApp($targetApp) {
       $this->targetApp = $targetApp;
       }              
       

function setFirstName($firstName) {
             $this->firstName = $firstName;
             } 
function setMiddleName($middleName) {
             $this->middleName = $middleName;
             }                          
function setLastName($lastName) {
             $this->LastName = $lastName;
             }               
                
function setContractHtml($contractHtml) {
   $this->contractHtml =$contractHtml;
   }
function setNewUpgradeServiceKey($new_upgrade_service_key){
    $this->newUpgradeServiceKey =$new_upgrade_service_key;
}
function setSig($sig) {
   $this->signature = $sig;
   } 
   
//methods go here  
//---------------------------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------
/*function cancelCsSubscription() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT subscription_id, billing_type FROM cs_subscriptions WHERE contract_key = '$this->contractKey' AND subscription_type ='MS' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($subscription_id, $billing_type);   
  $stmt->fetch();   
  $numRows = $stmt->num_rows;
  $stmt->close();
  
 if($numRows > 0) {
 
  $authOptions = new gatewayAuth();
  $authOptions-> loadGatewayOptions();
  $merchantId = $authOptions-> getMerchantId();
  $transactionKey = $authOptions-> getTransactionKey();
  $accessLink = $authOptions-> getAccessLink();

    define( 'MERCHANT_ID', $merchantId );
    define( 'TRANSACTION_KEY', $transactionKey);
    define( 'WSDL_URL', $accessLink);

  $request = new stdClass();
  $request->merchantID = MERCHANT_ID;
  $request->merchantReferenceCode = $this->contractKey;
  $request->clientLibrary = "PHP";
  $request->clientLibraryVersion = phpversion();
  $request->clientEnvironment = php_uname();

  $paySubscriptionUpdateService = new stdClass();
  $recurringSubscriptionInfo = new stdClass();

  $paySubscriptionUpdateService->run ="true";
  $request->paySubscriptionUpdateService = $paySubscriptionUpdateService;    
  $recurringSubscriptionInfo->status = "cancel";
  $recurringSubscriptionInfo->subscriptionID = $subscription_id; 
  $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

  $soapClient = new ExtendedClient(WSDL_URL, array());
  $reply = $soapClient->runTransaction($request);

	// To retrieve individual reply fields, follow these examples.
	$decision = $reply->decision;
	$reason_code = $reply->reasonCode;
	$requestID = $reply->requestID;
    $requestToken = $reply->requestToken;	

    
         //insert into failed trans if there is an issue
         if($reason_code != 100) {
    
             $sql = "INSERT INTO failed_subscriptions VALUES (?, ?, ?, ?, ?, ?)";
             $stmt = $dbMain->prepare($sql);
             $stmt->bind_param('issdis', $contractKey, $subscriptionType, $billingType, $billingAmount, $reasonCode, $frequency);  
             
             $contractKey = $this->contractKey;
             $subscriptionType = 'CA';
             $billingType = $billing_type;
             $billingAmount = '0.00'; 
             $reasonCode = $reason_code;
             $frequency = 'monthly';
        
               if(!$stmt->execute())  {
	              printf("Error:  failed_subscriptions cancelCsSubscription    %s.\n", $stmt->error);
                  }		
                $stmt->close();         
        
           }    
    
    $this->canceledReasonCode = $reason_code;
  }else{
    $this->canceledReasonCode = 100;  //if there are no records then this is a switch from cash or check so we set the reason code to 100
  }
  
}
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
function cancelRgSubscription() {
    
 $authOptions = new gatewayAuth();
 $authOptions-> loadGatewayOptions();
 $merchantId = $authOptions-> getMerchantId();
 $transactionKey = $authOptions-> getTransactionKey();
 $accessLink = $authOptions-> getAccessLink();

define( 'MERCHANT_ID', $merchantId );
define( 'TRANSACTION_KEY', $transactionKey);
define( 'WSDL_URL', $accessLink);
    
    
  $dbMain = $this->dbconnect();
  $stmt999 = $dbMain ->prepare("SELECT subscription_id, billing_type FROM cs_subscriptions WHERE contract_key = '$this->contractKey' ");
  $stmt999->execute();      
  $stmt999->store_result();      
  $stmt999->bind_result($subscription_id, $billing_type);   
  while($stmt999->fetch())  {
    
                
              $request = new stdClass();
              $request->merchantID = MERCHANT_ID;
              $request->merchantReferenceCode = $this->contractKey;
              $request->clientLibrary = "PHP";
              $request->clientLibraryVersion = phpversion();
              $request->clientEnvironment = php_uname();
            
              $paySubscriptionUpdateService = new stdClass();
              $recurringSubscriptionInfo = new stdClass();
            
              $paySubscriptionUpdateService->run ="true";
              $request->paySubscriptionUpdateService = $paySubscriptionUpdateService;    
              $recurringSubscriptionInfo->status = "cancel";
              $recurringSubscriptionInfo->subscriptionID = $subscription_id; 
              $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;
            
              $soapClient = new ExtendedClient(WSDL_URL, array());
              $reply = $soapClient->runTransaction($request);
            
            	// To retrieve individual reply fields, follow these examples.
            	$decision = $reply->decision;
            	$reason_code = $reply->reasonCode;
            	$requestID = $reply->requestID;
                $requestToken = $reply->requestToken;	
            
                
                     //insert into failed trans if there is an issue
                     if($reason_code != 100) {
                
                         $sql = "INSERT INTO failed_subscriptions VALUES (?, ?, ?, ?, ?, ?)";
                         $stmt = $dbMain->prepare($sql);
                         $stmt->bind_param('issdis', $contractKey, $subscriptionType, $billingType, $billingAmount, $reasonCode, $frequency);  
                         
                         $contractKey = $this->contractKey;
                         $subscriptionType = 'CA';
                         $billingType = $billing_type;
                         $billingAmount = '0.00'; 
                         $reasonCode = $reason_code;
                         $frequency = 'monthly';
                    
                           if(!$stmt->execute())  {
            	              printf("Error:  failed_subscriptions cancelCsSubscription    %s.\n", $stmt->error);
                              }		
                            $stmt->close();         
                    
                       }    
    
  } 
  
  $stmt999->close();
  
 
 
    
 
  
  
}*/
//-------------------------------------------------------------------------------------------
function loadGroupType(){
  $dbMain = $this->dbconnect();
  
  $stmt = $dbMain ->prepare("SELECT group_type FROM member_groups WHERE contract_key = '$this->contractKey'");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($this->groupType);   
  $stmt->fetch();   
  $stmt->close();
    
}
//=============================================================================
/*function saveFailedSubscriptions() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO failed_subscriptions VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issdis', $contractKey, $subscriptionType, $billingType, $billingAmount, $reasonCode, $frequency); 

$contractKey = $this->contractKey;
$subscriptionType = $this->subscriptionType;
$billingType = $this->monthlyBillingType;
$billingAmount = $this->csBillingAmount;
$reasonCode = $this->psReasonCode;
$frequency = $this->frequency;

if(!$stmt->execute())  {
	printf("Error: failed_subscriptions saveFailedSubscriptions %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//-----------------------------------------------------------------------------------------------------
function saveServiceSubscriptions() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO cs_subscriptions VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $contractKey, $subscriptionID, $billingType, $subscriptionType);  

$contractKey = $this->contractKey;
$subscriptionID = $this->subscriptionID;
$billingType = $this->monthlyBillingType;
$subscriptionType = $this->subscriptionType;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}

//-------------------------------------------------------------------------------------------
function updateServiceSubscriptions() {

$dbMain = $this->dbconnect();
$sql = "UPDATE cs_subscriptions SET subscription_id=?,  billing_type=?  WHERE contract_key = '$this->contractKey' AND subscription_type='MS' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $subscriptionID, $billingType);

$subscriptionID = $this->subscriptionID;
$billingType = $this->monthlyBillingType;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$stmt->close(); 

}*/
//---------------------------------------------------------------------------------------------
function loadPaymentDescription() {

if($this->productListArray != "" && $this->newMembers != 0) {
    $this->paymentDescription =  'Member Service Upgrade';
  }
  
if($this->productListArray != "" && $this->newMembers == 0) {
    $this->paymentDescription =  'Service Upgrade';
  }

if($this->productListArray == "" && $this->newMembers != 0) {
    $this->paymentDescription =  'Member Upgrade';
  }

}
//-------------------------------------------------------------------------------------------
function paymentHistory() {       
     
   require('../helper_apps/paymentHistory.php');  


}
//------------------------------------------------------------------------------------------
function insertPifEnhanceCycle() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_enhance_pif VALUES (?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isd', $contractKey, $pifCycleDate , $enhanceFee);

$contractKey = $this->contractKey;
$pifCycleDate = $this->pifCycleDate; 
$enhanceFee = $this->enhanceFee;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//-------------------------------------------------------------------------------------------
function insertEftEnhanceCycle()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_enhance_eft VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issd', $contractKey, $eftCycle, $eftCycleDate, $enhanceFee);                                                                                                                                                                                                             

//break up the guarentee cycle date
$day = date("d", strtotime($this->pifCycleDate));
$month = date("m", strtotime($this->pifCycleDate));
$year = date("Y");
$enhanceCycleDateString = "$month/$day/$year";
$enhanceCycleDateSecs = strtotime($enhanceCycleDateString);

//fro semi annual dates
$enhanceCycleDateSecsAnnual = $enhanceCycleDateSecs + 15724800;

//for quarterly dates
$enhanceCycleDateQuarter2 = date("Ymd", mktime(0, 0, 0, $month + 3, $day, $year)); 
$enhanceCycleDateQuarter3 = date("Ymd", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateQuarter4 = date("Ymd", mktime(0, 0, 0, $month + 9, $day, $year));
$enhanceCycleDateSecsQuarter2 = strtotime($enhanceCycleDateQuater2);
$enhanceCycleDateSecsQuarter3 = strtotime($enhanceCycleDateQuater3);
$enhanceCycleDateSecsQuarter4 = strtotime($enhanceCycleDateQuater4);

//for monthly dates
$enhanceCycleDateMonths2 = date("Ymd", mktime(0, 0, 0, $month + 1, $day, $year)); 
$enhanceCycleDateMonths3 = date("Ymd", mktime(0, 0, 0, $month + 2, $day, $year));
$enhanceCycleDateMonths4 = date("Ymd", mktime(0, 0, 0, $month + 3, $day, $year));
$enhanceCycleDateMonths5 = date("Ymd", mktime(0, 0, 0, $month + 4, $day, $year));
$enhanceCycleDateMonths6 = date("Ymd", mktime(0, 0, 0, $month + 5, $day, $year));
$enhanceCycleDateMonths7 = date("Ymd", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateMonths8 = date("Ymd", mktime(0, 0, 0, $month + 7, $day, $year));
$enhanceCycleDateMonths9 = date("Ymd", mktime(0, 0, 0, $month + 8, $day, $year));
$enhanceCycleDateMonths10 = date("Ymd", mktime(0, 0, 0, $month + 9, $day, $year));
$enhanceCycleDateMonths11 = date("Ymd", mktime(0, 0, 0, $month + 10, $day, $year));
$enhanceCycleDateMonths12 = date("Ymd", mktime(0, 0, 0, $month + 11, $day, $year));
$enhanceCycleDateSecsMonths2 = strtotime($enhanceCycleDateMonths2);
$enhanceCycleDateSecsMonths3 = strtotime($enhanceCycleDateMonths3);
$enhanceCycleDateSecsMonths4 = strtotime($enhanceCycleDateMonths4);
$enhanceCycleDateSecsMonths5 = strtotime($enhanceCycleDateMonths5);
$enhanceCycleDateSecsMonths6 = strtotime($enhanceCycleDateMonths6);
$enhanceCycleDateSecsMonths7 = strtotime($enhanceCycleDateMonths7);
$enhanceCycleDateSecsMonths8 = strtotime($enhanceCycleDateMonths8);
$enhanceCycleDateSecsMonths9 = strtotime($enhanceCycleDateMonths9);
$enhanceCycleDateSecsMonths10 = strtotime($enhanceCycleDateMonths10);
$enhanceCycleDateSecsMonths11 = strtotime($enhanceCycleDateMonths11);
$enhanceCycleDateSecsMonths12 = strtotime($enhanceCycleDateMonths12);

$todaysDateSecs = time();


    switch ($this->eftEnhanceCycle) {
        case "A":
        $divisor = 1;
        $frequency = 'annually';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);
               }elseif($todaysDateSecs > $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->pifCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1)); 
               }
        
        break;
        case "B":
        $divisor = 2;
        $frequency = 'semi-annually';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);
                }elseif($todaysDateSecs <= $enhanceCycleDateSecsAnnual) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsAnnual);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsAnnual);
                }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->pifCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                                 
                }
                                
        break;
        case "Q":
        $divisor = 4;
        $frequency = 'quarterly';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);        
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter2) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter2);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter2);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter3) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter3);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter3);           
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter4) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter4);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter4);
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->pifCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                
               }
        
        break;
        case "M":
        $divisor = 12;
        $frequency = 'monthly';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);        
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths2) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths2);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths2);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths3) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths3);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths3);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths4) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths4);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths4);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths5) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths5);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths5);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths6) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths6);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths6);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths7) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths7);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths7);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths8) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths8);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths8);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths9) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths9);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths9);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths10) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths10);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths10);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths11) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths11);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths11);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths12) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths12);
                $this->pifCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths12);                
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->pifCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                 
               }
                
        break;
       }

       
$contractKey = $this->contractKey;    
$eftCycle = $this->eftEnhanceCycle;
$eftCycleDate = $this->pifCycleDate;
$enhanceFee = sprintf("%.2f", $this->enhanceFee / $divisor);
$this->csBillingAmount = $enhanceFee;
$this->frequency = $frequency;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

//start subscription
/*if($this->monthlyBillingType == 'CR' || $this->monthlyBillingType == 'BA') {

//trim vars from text fields
$this->cardName = trim($this->cardName);
$this->cardNumber= trim($this->cardNumber);
$this->cardCvv = trim($this->cardCvv);
$this->accountName = trim($this->accountName);
$this->accountNumber = trim($this->accountNumber);
$this->abaNumber = trim($this->abaNumber);
$this->clientStreet = trim($this->clientStreet);
$this->clientCity = trim($this->clientCity);
$this->clientState = trim($this->clientState);
$this->clientZip = trim($this->clientZip);
$this->clientHomePhone = trim($this->clientHomePhone);
$this->clientEmail = trim($this->clientEmail);
$this->clientLicense = trim($this->clientLicense);

//replace anything that is not a number for cc routing number bank account number
$this->cardNumber = preg_replace("/[^0-9 .]+/", "" ,$this->cardNumber);
$this->abaNumber = preg_replace("/[^0-9 .]+/", "" ,$this->abaNumber);
$this->accountNumber = preg_replace("/[^0-9 .]+/", "" ,$this->accountNumber);
$enhanceFee = number_format($enhanceFee, 2, '.', '');

//send off vars to format
  $fieldParse = new parseGatewayFields(); 
  $fieldParse-> setCardName($this->cardName);
  $fieldParse-> setAchName($this->accountName);
  $fieldParse-> setCardType($this->cardType);
  $fieldParse-> setAccountType($this->accountType);
  $fieldParse-> setAccountPhone($this->clientHomePhone);
  $fieldParse-> setCardExpDate($this->cardExpDate);
  $fieldParse-> parsePaymentFields();

  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
  $ccCardYear = $fieldParse-> getCardYear();  
  $ccCardMonth = $fieldParse-> getCardMonth();
  $ccCardNumber = $this->cardNumber;
  $ccCardCvv = $this->cardCvv;


  //reassign vars for ACH  
  $achFirstName = $fieldParse-> getAchFirstName();
  $achLastName = $fieldParse-> getAchLastName();  
  $accountStreet = $this->clientStreet;
  $accountCity = $this->clientCity;
  $accountState = $this->clientState;
  $accountZip = $this->clientZip;
  $accountPhone = $fieldParse-> getAccountPhone(); 
  $accountEmail = $this->clientEmail;
  $accountDriversLic = $this->clientLicense;
  $achAccountType = $fieldParse-> getAccountType();
  $achRoutingNumber = $this->abaNumber;
  $achAccountNumber = $this->accountNumber;
  
  //here we send the info to CS for recursive billing
  //below is the Cyber source soap class
  $authOptions = new gatewayAuth();
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
  $request->merchantReferenceCode = "$contractKey";
  $request->clientLibrary = "PHP";
  $request->clientLibraryVersion = phpversion();
  $request->clientEnvironment = php_uname();  

  $billTo = new stdClass();
  $card = new stdClass();
  $check = new stdClass();
  $purchaseTotals = new stdClass();
  $paySubscriptionCreateService = new stdClass();
  $recurringSubscriptionInfo = new stdClass();
  $subscription = new stdClass();
  $businessRules = new stdClass();
  
  $paySubscriptionCreateService->run = "true";
  $paySubscriptionCreateService->disableAutoAuth = "true";
  $request->paySubscriptionCreateService = $paySubscriptionCreateService;  
  
  $recurringSubscriptionInfo->frequency = $frequency; 
  $recurringSubscriptionInfo->amount = $enhanceFee;
  $recurringSubscriptionInfo->startDate = $scStartDate;
  $request->recurringSubscriptionInfo = $recurringSubscriptionInfo; 
  
  $purchaseTotals->currency = "USD";
  $request->purchaseTotals = $purchaseTotals; 
  
  $businessRules->ignoreAVSResult = "true";
  $request->businessRules = $businessRules;  
////////////////////////////////////////////////////////////////////////////////////////////////
  //takes care of CC EFT
  if($this->monthlyBillingType == 'CR') {
    
     $billTo->firstName = $ccFirstName;
     $billTo->lastName = $ccLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     $request->billTo = $billTo;  

     $card->accountNumber = $ccCardNumber;
	 $card->expirationMonth = $ccCardMonth;
	 $card->expirationYear = $ccCardYear;	
     $card->cardType = $ccCardType;
	 $request->card = $card;

	 $subscription->paymentMethod = "credit card";
     $subscription->title = "Enhancement Fee Credit";
	 $request->subscription = $subscription;
	
  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Takes care of banking eft
  if($this->monthlyBillingType == 'BA') {

     $billTo->firstName = $achFirstName;
     $billTo->lastName = $achLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     //$billTo->driversLicenseNumber = $accountDriversLic;
     //$billTo->driversLicenseState = $accountState;    
     $request->billTo = $billTo;  

     $check->accountNumber = $achAccountNumber;
	 $check->accountType = $achAccountType;
	 $check->bankTransitNumber = $achRoutingNumber;
	 //  if($achAccountType == "X") {
	 //     $secVal = 'WEB';
	 //    }else{
	  //    $secVal = 'WEB';
	//     }
     $secVal = 'PPD';
	 $check->secCode = $secVal;
	 $request->check = $check;
	 
	$subscription->paymentMethod = "check";
    $subscription->title = "Enhancement Fee ACH";
	$request->subscription = $subscription;	 
	 	 
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
//send off to CS and get response    
   $soapClient = new ExtendedClient(WSDL_URL, array());
   $reply = $soapClient->runTransaction($request);
   $decision = $reply->decision;
   $reasonCode = $reply->reasonCode;
   $requestID = $reply->requestID;
   $requestToken = $reply->requestToken;	
   $subscriptionID = $reply->paySubscriptionCreateReply->subscriptionID;
   $this->psReasonCode = $reply->paySubscriptionCreateReply->reasonCode; 
   
      //if descision is accept e.g. 100 then we insert into the subscription table check for inhance fees rate guarantee 
      if($this->psReasonCode == 100) {
         $this->subscriptionID = $subscriptionID;
         $this->subscriptionType = 'EF';
         $this->saveServiceSubscriptions();
         }else{
         $this->subscriptionType = 'EF';         
         $this->saveFailedSubscriptions();
         }
                  
  }
 
echo"CC First Name: $ccFirstName
<br>
CC Last Name: $ccLastName
<br>
Card Number: $ccCardNumber
<br>
Card Type: $ccCardType
<br>
Card CVV: $ccCardCvv
<br>
Card Month:  $ccCardMonth
<br>
Card Year: $ccCardYear
<br>
ACH First Name: $achFirstName
<br>
ACH Last Name: $achLastName
<br>
ACH Type:  $achAccountType
<br>
ACH Acct Numb: $achAccountNumber
<br>
ACH ABA: $achRoutingNumber
<br>
Client Street: $accountStreet
<br>
Client City: $accountCity
<br>
Client State: $accountState 
<br>
Client Zip: $accountZip
<br>
Client Phone:  $accountPhone
<br>
Client Email: $accountEmail
<br>
Client Lic: $accountDriversLic
<br>
Billing Amount: $enhanceFee
<br>
Billing Date: $scStartDate   &nbsp;&nbsp;   $this->pifCycleDate 
<br>
Frequency: $frequency
<br>
Reason Code: $this->psReasonCode
<br>
Reason Code:  $reasonCode";
*/
  
}
//-------------------------------------------------------------------------------------------
function loadEnhanceCycles() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT eft_cycle, pif_cycle_date, term_switch FROM enhance_fee_cycles WHERE cycle_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($eft_cycle, $pif_cycle_date, $term_switch);   
$stmt->fetch();   
$stmt->close();

$this->eftEnhanceCycle = $eft_cycle;
$this->pifCycleDate = $pif_cycle_date;
$this->enhTermSwitch = $term_switch;

}
//-------------------------------------------------------------------------------------------
function insertGuaranteeCycle() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_guarantee_eft VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issd', $contractKey, $eftCycle, $eftCycleDate, $guaranteeFee);                                                                                                                                                                                                             

//break up the guarentee cycle date
$day = date("d", strtotime($this->guaranteeCycleDate));
$month = date("m", strtotime($this->guaranteeCycleDate));
$year = date("Y");
$guaranteeCycleDateString = "$month/$day/$year";
$guaranteeCycleDateSecs = strtotime($guaranteeCycleDateString);

//fro semi annual dates
$guaranteeCycleDateSecsAnnual = $guaranteeCycleDateSecs + 15724800;

//for quarterly dates
$guaranteeCycleDateQuarter2 = date("Ymd", mktime(0, 0, 0, $month + 3, $day, $year)); 
$guaranteeCycleDateQuarter3 = date("Ymd", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateQuarter4 = date("Ymd", mktime(0, 0, 0, $month + 9, $day, $year));
$guaranteeCycleDateSecsQuarter2 = strtotime($guaranteeCycleDateQuater2);
$guaranteeCycleDateSecsQuarter3 = strtotime($guaranteeCycleDateQuater3);
$guaranteeCycleDateSecsQuarter4 = strtotime($guaranteeCycleDateQuater4);

//for monthly dates
$guaranteeCycleDateMonths2 = date("Ymd", mktime(0, 0, 0, $month + 1, $day, $year)); 
$guaranteeCycleDateMonths3 = date("Ymd", mktime(0, 0, 0, $month + 2, $day, $year));
$guaranteeCycleDateMonths4 = date("Ymd", mktime(0, 0, 0, $month + 3, $day, $year));
$guaranteeCycleDateMonths5 = date("Ymd", mktime(0, 0, 0, $month + 4, $day, $year));
$guaranteeCycleDateMonths6 = date("Ymd", mktime(0, 0, 0, $month + 5, $day, $year));
$guaranteeCycleDateMonths7 = date("Ymd", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateMonths8 = date("Ymd", mktime(0, 0, 0, $month + 7, $day, $year));
$guaranteeCycleDateMonths9 = date("Ymd", mktime(0, 0, 0, $month + 8, $day, $year));
$guaranteeCycleDateMonths10 = date("Ymd", mktime(0, 0, 0, $month + 9, $day, $year));
$guaranteeCycleDateMonths11 = date("Ymd", mktime(0, 0, 0, $month + 10, $day, $year));
$guaranteeCycleDateMonths12 = date("Ymd", mktime(0, 0, 0, $month + 11, $day, $year));
$guaranteeCycleDateSecsMonths2 = strtotime($guaranteeCycleDateMonths2);
$guaranteeCycleDateSecsMonths3 = strtotime($guaranteeCycleDateMonths3);
$guaranteeCycleDateSecsMonths4 = strtotime($guaranteeCycleDateMonths4);
$guaranteeCycleDateSecsMonths5 = strtotime($guaranteeCycleDateMonths5);
$guaranteeCycleDateSecsMonths6 = strtotime($guaranteeCycleDateMonths6);
$guaranteeCycleDateSecsMonths7 = strtotime($guaranteeCycleDateMonths7);
$guaranteeCycleDateSecsMonths8 = strtotime($guaranteeCycleDateMonths8);
$guaranteeCycleDateSecsMonths9 = strtotime($guaranteeCycleDateMonths9);
$guaranteeCycleDateSecsMonths10 = strtotime($guaranteeCycleDateMonths10);
$guaranteeCycleDateSecsMonths11 = strtotime($guaranteeCycleDateMonths11);
$guaranteeCycleDateSecsMonths12 = strtotime($guaranteeCycleDateMonths12);

$todaysDateSecs = time();


    switch ($this->eftGuaranteeCycle) {
        case "A":
        $divisor = 1;
        $frequency = 'annually';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);
               }elseif($todaysDateSecs > $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1)); 
               }
        
        break;
        case "B":
        $divisor = 2;
        $frequency = 'semi-annually';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);
                }elseif($todaysDateSecs <= $guaranteeCycleDateSecsAnnual) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsAnnual);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsAnnual);
                }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                                 
                }
                                
        break;
        case "Q":
        $divisor = 4;
        $frequency = 'quarterly';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);        
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsQuarter2) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsQuarter2);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsQuarter2);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsQuarter3) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsQuarter3);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsQuarter3);           
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsQuarter4) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsQuarter4);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsQuarter4);
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                
               }
        
        break;
        case "M":
        $divisor = 12;
        $frequency = 'monthly';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);        
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths2) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths2);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths2);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths3) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths3);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths3);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths4) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths4);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths4);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths5) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths5);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths5);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths6) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths6);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths6);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths7) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths7);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths7);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths8) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths8);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths8);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths9) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths9);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths9);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths10) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths10);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths10);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths11) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths11);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths11);                
               }elseif($todaysDateSecs <= $guaranteeCycleDateSecsMonths12) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsMonths12);
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsMonths12);                
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                 
               }
                
        break;
       }
       
$contractKey = $this->contractKey;    
$eftCycle = $this->eftGuaranteeCycle;
$eftCycleDate = $this->guaranteeCycleDate;
$guaranteeFee = sprintf("%.2f", $this->gauranteeFee / $divisor);
$this->csBillingAmount = $guaranteeFee;
$this->frequency = $frequency;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

//start subscription
/*if($this->monthlyBillingType == 'CR' || $this->monthlyBillingType == 'BA') {

//trim vars from text fields
$this->cardName = trim($this->cardName);
$this->cardNumber= trim($this->cardNumber);
$this->cardCvv = trim($this->cardCvv);
$this->accountName = trim($this->accountName);
$this->accountNumber = trim($this->accountNumber);
$this->abaNumber = trim($this->abaNumber);
$this->clientStreet = trim($this->clientStreet);
$this->clientCity = trim($this->clientCity);
$this->clientState = trim($this->clientState);
$this->clientZip = trim($this->clientZip);
$this->clientHomePhone = trim($this->clientHomePhone);
$this->clientEmail = trim($this->clientEmail);
$this->clientLicense = trim($this->clientLicense);

//replace anything that is not a number for cc routing number bank account number
$this->cardNumber = preg_replace("/[^0-9 .]+/", "" ,$this->cardNumber);
$this->abaNumber = preg_replace("/[^0-9 .]+/", "" ,$this->abaNumber);
$this->accountNumber = preg_replace("/[^0-9 .]+/", "" ,$this->accountNumber);
$guaranteeFee = number_format($guaranteeFee, 2, '.', '');

//send off vars to format
  $fieldParse = new parseGatewayFields(); 
  $fieldParse-> setCardName($this->cardName);
  $fieldParse-> setAchName($this->accountName);
  $fieldParse-> setCardType($this->cardType);
  $fieldParse-> setAccountType($this->accountType);
  $fieldParse-> setAccountPhone($this->clientHomePhone);
  $fieldParse-> setCardExpDate($this->cardExpDate);
  $fieldParse-> parsePaymentFields();

  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
  $ccCardYear = $fieldParse-> getCardYear();  
  $ccCardMonth = $fieldParse-> getCardMonth();
  $ccCardNumber = $this->cardNumber;
  $ccCardCvv = $this->cardCvv;

  //reassign vars for ACH  
  $achFirstName = $fieldParse-> getAchFirstName();
  $achLastName = $fieldParse-> getAchLastName();  
  $accountStreet = $this->clientStreet;
  $accountCity = $this->clientCity;
  $accountState = $this->clientState;
  $accountZip = $this->clientZip;
  $accountPhone = $fieldParse-> getAccountPhone(); 
  $accountEmail = $this->clientEmail;
  $accountDriversLic = $this->clientLicense;
  $achAccountType = $fieldParse-> getAccountType();
  $achRoutingNumber = $this->abaNumber;
  $achAccountNumber = $this->accountNumber;
  
  //here we send the info to CS for recursive billing
  //below is the Cyber source soap class
  $authOptions = new gatewayAuth();
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
  $request->merchantReferenceCode = "$contractKey";
  $request->clientLibrary = "PHP";
  $request->clientLibraryVersion = phpversion();
  $request->clientEnvironment = php_uname();  

  $billTo = new stdClass();
  $card = new stdClass();
  $check = new stdClass();
  $purchaseTotals = new stdClass();
  $paySubscriptionCreateService = new stdClass();
  $recurringSubscriptionInfo = new stdClass();
  $subscription = new stdClass();
  $businessRules = new stdClass();
  
  $paySubscriptionCreateService->run = "true";
  $paySubscriptionCreateService->disableAutoAuth = "true";
  $request->paySubscriptionCreateService = $paySubscriptionCreateService;  
  
  $recurringSubscriptionInfo->frequency = $frequency; 
  $recurringSubscriptionInfo->amount = $guaranteeFee;
  $recurringSubscriptionInfo->startDate = $scStartDate;
  $request->recurringSubscriptionInfo = $recurringSubscriptionInfo; 
  
  $purchaseTotals->currency = "USD";
  $request->purchaseTotals = $purchaseTotals; 
  
  $businessRules->ignoreAVSResult = "true";
  $request->businessRules = $businessRules;  
////////////////////////////////////////////////////////////////////////////////////////////////
  //takes care of CC EFT
  if($this->monthlyBillingType == 'CR') {
    
     $billTo->firstName = $ccFirstName;
     $billTo->lastName = $ccLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     $request->billTo = $billTo;  

     $card->accountNumber = $ccCardNumber;
	 $card->expirationMonth = $ccCardMonth;
	 $card->expirationYear = $ccCardYear;	
     $card->cardType = $ccCardType;
	 $request->card = $card;

	 $subscription->paymentMethod = "credit card";
     $subscription->title = "Rate Guarantee Credit";
	 $request->subscription = $subscription;
	

  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Takes care of banking eft
  if($this->monthlyBillingType == 'BA') {

     $billTo->firstName = $achFirstName;
     $billTo->lastName = $achLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     //$billTo->driversLicenseNumber = $accountDriversLic;
     //$billTo->driversLicenseState = $accountState;    
     $request->billTo = $billTo;  

     $check->accountNumber = $achAccountNumber;
	 $check->accountType = $achAccountType;
	 $check->bankTransitNumber = $achRoutingNumber;
	  // if($achAccountType == "X") {
	 //     $secVal = 'WEB';
	  //   }else{
	  //    
	  //   }
	  
	 $secVal = 'PPD';
	 $check->secCode = $secVal;
	 $request->check = $check;
	 
	$subscription->paymentMethod = "check";
    $subscription->title = "Rate Guarantee ACH";
	$request->subscription = $subscription;	 
	 	 
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
//send off to CS and get response    
   $soapClient = new ExtendedClient(WSDL_URL, array());
   $reply = $soapClient->runTransaction($request);
   $decision = $reply->decision;
   $reasonCode = $reply->reasonCode;
   $requestID = $reply->requestID;
   $requestToken = $reply->requestToken;	
   $subscriptionID = $reply->paySubscriptionCreateReply->subscriptionID;
   $this->psReasonCode = $reply->paySubscriptionCreateReply->reasonCode; 
   
      //if descision is accept e.g. 100 then we insert into the subscription table check for inhance fees rate guarantee 
      if($this->psReasonCode == 100) {
         $this->subscriptionID = $subscriptionID;
         $this->subscriptionType = 'RG';
         $this->saveServiceSubscriptions();
         }else{
         $this->subscriptionType = 'RG';
         $this->saveFailedSubscriptions();         
         }
         
/*        
echo"CC First Name: $ccFirstName
<br>
CC Last Name: $ccLastName
<br>
Card Number: $ccCardNumber
<br>
Card Type: $ccCardType
<br>
Card CVV: $ccCardCvv
<br>
Card Month:  $ccCardMonth
<br>
Card Year: $ccCardYear
<br>
ACH First Name: $achFirstName
<br>
ACH Last Name: $achLastName
<br>
ACH Type:  $achAccountType
<br>
ACH Acct Numb: $achAccountNumber
<br>
ACH ABA: $achRoutingNumber
<br>
Client Street: $accountStreet
<br>
Client City: $accountCity
<br>
Client State: $accountState 
<br>
Client Zip: $accountZip
<br>
Client Phone:  $accountPhone
<br>
Client Email: $accountEmail
<br>
Client Lic: $accountDriversLic
<br>
Billing Amount: $guaranteeFee
<br>
Billing Date: $scStartDate   &nbsp;&nbsp;   $this->guaranteeCycleDate 
<br>
Frequency: $frequency
<br>
PS Reason Code: $this->psReasonCode
<br>
Reason Code:  $reasonCode";



}*/

}
//-------------------------------------------------------------------------------------------
function loadGuaranteeCycles() {
       
         $dbMain = $this->dbconnect();
         $stmt = $dbMain ->prepare("SELECT eft_cycle, annual_cycle_date, term_switch FROM guarantee_fee_cycles WHERE cycle_num = '1'");
         $stmt->execute();      
         $stmt->store_result();      
         $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);   
         $stmt->fetch();   
         $stmt->close();
 
         $this->eftGuaranteeCycle = $eft_cycle;
         $this->guaranteeCycleDate = $annual_cycle_date;  
         $this->termSwitch = $term_switch;
}
//-------------------------------------------------------------------------------------------
function loadEnhanceGuaranteeFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT enhance_fee, rate_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($enhance_fee, $rate_fee);   
$stmt->fetch();   
$stmt->close();

$this->enhanceFee = $enhance_fee;
$this->gauranteeFee = $rate_fee;

//sets up the enhance fees
if($this->enhanceFee != "0.00")  {
   $this->loadEnhanceCycles();
          //check to see if the service is a membership
        if(preg_match("/membership/i", $this->serviceName)) {        
               //now check to see if this is a pif
             if($this->serviceTerm == "Y") {             
                 $this->insertPifEnhanceCycle();
                }elseif(($this->serviceTerm == "PM") && (preg_match("/membership/i", $this->serviceName)) && ($this->serviceQuantity >= 12)) { 
                
                  switch ($this->enhTermSwitch) {
                      case "T":
                      if($this->termType != "O") {
                         $this->insertEftEnhanceCycle();
                         }
                      break;
                      case "O":
                      if($this->termType != "T") {
                         $this->insertEftEnhanceCycle();
                         }              
                      break;
                      case "B":
                      if(($this->termType == "T") || ($this->termType == "O")) {
                         $this->insertEftEnhanceCycle();
                         }    
                      break;
                    }                                
                
                }  
           }
   }
   
//this sets up the rate guarantee fee if monthly open end
if($this->gauranteeFee != "0.00")  {

//echo"Service Term: $this->serviceTerm <br> Service Name: $this->serviceName <br> Service Quantity: $this->serviceQuantity";

        if(($this->serviceTerm == "PM") && (preg_match("/membership/i", $this->serviceName)) && ($this->serviceQuantity >= 12)) {        
           $this->loadGuaranteeCycles();

           switch ($this->termSwitch) {
                   case "T":
                   if($this->termType != "O") {
                      $this->insertGuaranteeCycle();
                      }
                   break;
                   case "O":
                   if($this->termType != "T") {
                      $this->insertGuaranteeCycle();
                      }              
                   break;
                   case "B":
                   if(($this->termType == "T") || ($this->termType == "O")) {
                      $this->insertGuaranteeCycle();
                      }    
                   break;
                }           
           

          }   
  }
  
}
//-------------------------------------------------------------------------------------------
function checkMonthlyBilling() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(*) AS result_count FROM monthly_payments  WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($result_count);
$stmt->fetch();

return "$result_count";

$stmt->close();
}
//------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT cycle_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_day);   
$stmt->fetch();   

$todayDay = date("d");

if($this->upgradedServiceKeyTest == $this->newUpgradeServiceKey){
    $buffer = 1;
}else{
  $buffer = 0;  
}//skips month because already paid cureent month for orig mebership;


//check if iis past or present then generate the billing date
if($cycle_day > $todayDay)  {
  $billingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+$buffer  , $cycle_day, date("Y")));
  }
if($cycle_day <= $todayDay)  {
  $billingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1+$buffer  , $cycle_day, date("Y")));
  }

return "$billingDate";

$stmt->close();
}
//--------------------------------------------------------------------------------------------
function loadUnitPrice() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost WHERE service_key = '$this->serviceKey' AND service_quantity = '$this->serviceQuantity'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_cost);   
$stmt->fetch();   

return "$service_cost";

$stmt->close();
}
//--------------------------------------------------------------------------------------
function deleteUpgrade() {

		unset($_SESSION['upgradeSql']);
		
	    $delete_key = 1;
		return $delete_key;

}
//----------------------------------------------------------------------------------------------------
function checkCommissionId()  {

$dbMain = $this->dbconnect();
$result = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_id ='$this->comissionId'"); 
$row_count = $result->num_rows; 

if($row_count == 0) {
   $this->comissionId = $this->newComissionId;
  }
  
//$result->close(); 

}
//-----------------------------------------------------------------------------------------------------
function parseComissionId() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_id FROM admin_passwords WHERE user_name ='$this->newCommissionCredit'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($user_id);
   $stmt->fetch();

$this->newComissionId = $user_id;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }   
$stmt->close();    

         $result2 = $dbMain ->prepare("SELECT type_key, id_card  FROM basic_compensation WHERE  user_id = '$user_id'"); 
         $result2->execute();      
         $result2->store_result(); 
         $result2->bind_result($type_key, $id_card);      
                                  while ($result2->fetch()) {   
                                                 if($type_key != null)  {                                                 
                                                          $result3 = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$type_key'");
                                                          $result3->execute();      
                                                          $result3->store_result(); 
                                                          $result3->bind_result($employee_type, $club_id);    
                                                          $result3 ->fetch();
                                                         
                                                                   if(preg_match("/sales/i", $employee_type)) {
                                                                   
                                                                      // if($club_id == $this->locationId) {
                                                                           $this->typeKey = $type_key;
                                                                           $this->idCard = $id_card;                                                                           
                                                                       //  }
                                                                         
                                                                     }        
                                                     }

                                             }

}
//----------------------------------------------------------------------------------------------------
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
    default:
            $this->accountFirst = "";
            $this->accountMiddle = "";
            $this->accountLast = $this->nameSwitch;
     }
   
 }

}

//-------------------------------------------------------------------------------------------------------------------
function formatCreditDate() {

if($this->cardExpDate == "") {
  $credit_date = "0000-00-00";
  }else{
  $year_front = '20';
  $card_array =  preg_split('/[\s]+/', $this->cardExpDate);
  $card_year = "$year_front$card_array[0]"; 
  $card_month = $card_array[1]; 
  
    switch ($card_month) {
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
          
  $credit_date = "$card_year-$card_month-$card_day";
  }

return $credit_date; 

}
//-------------------------------------------------------------------------------------------
function parseAddressInfo() {

$contract_address_array =  explode("|", $this->addressInfoArray);

$this->clientStreet = $contract_address_array[0];
$this->clientCity = $contract_address_array[1];
$this->clientState = $contract_address_array[2];
$this->clientZip = $contract_address_array[3];
$this->clientHomePhone = $contract_address_array[4];
$this->clientCellPhone = $contract_address_array[5];
$this->clientEmail = $contract_address_array[6];

}
//-------------------------------------------------------------------------------------------
function loadClubLocation()  {
$dbMain = $this->dbconnect();
$this->locationId = $_SESSION['location_id'];

if ($this->locationId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }else{
        $clubId = $this->locationId;
    }
    

   $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id ='$clubId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_name);
   $stmt->fetch();
  
$this->clubLocation = $club_name;
}
//-------------------------------------------------------------------------------------------
function loadGracePeriod() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gracePeriod);   
$stmt->fetch();   

return "$gracePeriod";

 $stmt->close();
}
//-------------------------------------------------------------------------------------------
function loadContractTerms() {

  $dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT contract_terms, contract_quit, liability_terms  FROM contract_defaults WHERE contract_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($termsConditions, $contractQuit, $liabilityTerms); 
   $stmt->fetch();

$this->contractQuit = $contractQuit; 
$this->termsConditions = $termsConditions;
$this->liabilityTerms = $liabilityTerms;
$this->gracePeriod = $this->loadGracePeriod();

if(!$stmt->execute())  {
    return($this->errorMessage);
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}

//-----------------------------------------------------------------------------------------------------------------------
function loadClubId($service_key)  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT club_id FROM service_info WHERE service_key = '$service_key'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id);   
 $stmt->fetch();             
             
 return "$club_id";

 $stmt->close(); 
}
//----------------------------------------------------------------------------------------------------------------------
function getTermDates() {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT start_date, end_date FROM monthly_services WHERE contract_key='$this->contractKey' ORDER BY service_id DESC LIMIT 1 ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($start_date, $end_date);   
 $stmt->fetch(); 

$this->startDate = $start_date;
$this->endDate = $end_date;


 $stmt->close();
}
//------------------------------------------------------------------------------------------------------------------------
function parseStartEndDates() {

$this->startDate = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, date("m")  , date("d")+$this->serviceQuantity, date("Y")));
        break;
        case "W":
        $days = $this->serviceQuantity * 7;
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, date("m")  , date("d")+$days, date("Y")));
        break;
        case "M":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, date("m")+$this->serviceQuantity, date("d"), date("Y")));
        break;
        case "Y":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, date("m"), date("d"), date("Y")+$this->serviceQuantity));
        break;  
      }

}


//====================================================================
function saveAccountStatus() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissid', $statusId, $contractKey, $serviceKey , $accountStatus, $statusDate, $clubId, $servicePrice);

$statusId = $this->statusId;
$contractKey = $this->contractKey; 
$serviceKey = $this->serviceKey;
$accountStatus = $this->accountStatus;
$statusDate = $this->signupDate;
$clubId = $this->clubId;
$servicePrice = $this->groupPrice;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================================
function updateAccountStatus() {

$dbMain = $this->dbconnect();
$sql = "UPDATE account_status SET account_status= ?, status_date =? WHERE contract_key='$this->contractKey' AND service_key='$this->serviceKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $accountStatus, $statusDate);

$accountStatus = $this->accountStatus;
$statusDate = date("Y-m-d H:i:s");

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================================
function updateBankingInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE banking_info SET bank_name= ?,  account_type= ?, account_fname= ?, account_mname= ?, account_lname= ?,  account_number= ?, routing_number= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssss',  $bankName, $accountType, $accountFirst, $accountMiddle, $accountLast, $accountNumber, $abaNumber); 


$bankName = $this->bankName; 
$accountType = $this->accountType;

//divide the name attribute of the account holder
$this->nameSwitch = $this->accountName;
$this->parseAccountHolderName();
 $accountFirst = $this->accountFirst;
 $accountMiddle = $this->accountMiddle;
 $accountLast = $this->accountLast;

$accountNumber = $this->accountNumber; 
$abaNumber = $this->abaNumber; 

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

if(trim($accountNumber)!=""){
        $this->locationId = $_SESSION['location_id'];
        
        
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
        
        $payTypeFlag = "check";//"creditcard"; // '' or 'check'
        $vaultFunction = "add_customer";
        $vaultId = "$this->contractKey";
        $checkname = "$account_fname $account_lname";	//The name on the customer's ACH account.
                    
        if($this->accountType == 'C'){
            $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
            $account_type = "checking";//*** checking/savings
        }else if($this->accountType == 'B'){
            $account_holder_type = "business";//***	The customer's ACH account entity.Values: 'personal' or 'business'
            $account_type = "checking";//*** checking/savings
        }else if($this->accountType == 'S'){
            $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
            $account_type = "savings";//*** checking/savings
        }      
                                //========================
        $orderId = "Create Vault $this->contractKey";
        $merch1 = "Creating Vault ID";
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $gw->setBilling("$accountFirst","$accountLast","","$this->clientStreet","", "$this->clientState",
                "$this->clientState","$this->clientZip","US","$this->clientHomePhone","$this->clientHomePhone","$this->clientEmail","");
        $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $abaNumber, $accountNumber, $account_holder_type, $account_type, $merch1, $orderId);
        $reasonCode = $gw->responses['response_code'];
                          
        $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('is', $this->contractKey, $vaultId);
        $stmt->execute();
        $stmt->close();
 }
}
//====================================================================
function updateCreditInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE credit_info SET card_fname= ?,  card_mname= ?, card_lname= ?, card_street= ?, card_city= ?,  card_state= ?, card_zip= ?, card_type= ?, card_number= ?, card_cvv= ?, card_exp_date= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssss', $cardFirst, $cardMiddle, $cardLast, $cardStreet, $cardCity, $cardState, $cardZip, $cardType, $cardNumber, $cardCvv, $expDate); 
	
//divide the name attribute of the account holder
$this->nameSwitch = $this->cardName;
$this->parseAccountHolderName();
 $cardFirst = $this->accountFirst;
 $cardMiddle = $this->accountMiddle;
 $cardLast = $this->accountLast;
 $cardStreet = $this->cardStreet;
 $cardCity = $this->cardCity;
 $cardState = $this->cardState;
 $cardZip = $this->cardZip;
 $cardType = $this->cardType;
 $cardNumber = $this->cardNumber;
 $cardCvv = $this->cardCvv;
 
$expDate = $this->formatCreditDate();

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

if(trim($cardNumber)!=""){

        $this->locationId = $_SESSION['location_id'];
        
        
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
        
        $month = date('m',strtotime($expDate));
        $year = date('y',strtotime($expDate));
        $ccexp ="$month$year"; 
                            
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        $vaultFunction = "add_customer";
        $vaultId = "$contractKey";
        $cvv = "";
        $merch1 = "Creating Vault ID";
        $orderId = "Create Vault $contractKey";
                             //echo "du";
                                //========================
        $gw = new gwapi; 
        $gw->setLogin("$userName", "$password");
        $gw->setBilling("$cardFirst","$cardLast","","$cardStreet","", "$cardState",
                "$cardState","$cardZip","US","$this->clientHomePhone","$this->clientHomePhone","$this->clientEmail",
                "");
        $r = $gw->doVaultCC($cardNumber, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merch1, $cardFirst, $cardLast, $orderId);
        $reasonCode = $gw->responses['response_code'];
                          
        $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('is', $contractKey, $vaultId);
        $stmt->execute();
        $stmt->close();
}

}
//==================================================================
function updateGroupInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_groups SET group_address= ?, group_phone= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $groupAddress, $groupPhone);

//parse the group type info
$group_info_array = explode("|", $this->groupInfoArray);
$groupAddress = $group_info_array[0];
$groupPhone = $group_info_array[1];

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================================
function saveNote() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssssiss', $contractKey, $noteUser, $noteDate, $amPm, $noteTopic, $noteMessage, $noteCategory, $memberId, $priority, $targetApp);

$contractKey = $this->contractKey;
$noteUser = $this->noteUser;
$noteDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")  ,date("d"), date("Y")));
$amPm = date("a");
$noteTopic  = $this->noteTopic;
$noteMessage = $this->noteMessage;
$noteCategory = $this->noteCategory;
$memberId = null;
$priority = $this->notePriority;
$targetApp = $this->targetApp;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
$stmt->close(); 


/*
echo"
<h3>Account Notes</h3>
Contract Key:  $contractKey
<br>
Note User:  $noteUser
<br>
Note Date:  $noteDate
<br>
AM PM: $amPm
<br>
Topic:  $noteTopic
<br>
Message:  $noteMessage
<br><br><br>";
*/
}
//---------------------------------------------------------------------------------------------
function saveSignature() {
$this->signature = str_replace(' ','+',$this->signature);
$dbMain = $this->dbconnect();
$date = date('Y-m-d');
$sql = "UPDATE contract_signatures  SET sig_path = ?  WHERE contract_key = '$this->contractKey' AND date = '$date'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $this->signature);
$stmt->execute();        
$stmt->close();
}
//===================================================================
function saveContractInfo()  {
$this->saveSignature();

$dbMain = $this->dbconnect();
//first we get all of the pertinant data from the original contract last generated
$stmt = $dbMain ->prepare("SELECT  host_type, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number  FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_id DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($host_type, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $dob, $license_number);
 $stmt->fetch();
 
 $this->hostType = $host_type;
 $this->clientFirst = $first_name;
 $this->clientMiddle = $middle_name;
 $this->clientLast = $last_name;
  
 //check to see if they have upgraded the address info. if not store the original values
if($this->addressInfoArray == 'NA')  {
    $this->clientStreet = $street;
    $this->clientCity = $city;
    $this->clientState = $state;
    $this->clientZip = $zip;
    $this->clientHomePhone = $primary_phone;
    $this->clientCellPhone = $cell_phone;
    $this->clientEmail = $email;
}
  
  $this->clientDob = $dob;
  $this->clientLicense = $license_number;
  
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
$stmt->close(); 

//-------------------------------------------------------------------------------------------------------------------------
//now we do an insert for the new contract

$sql = "INSERT INTO contract_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssisssisssssssisssssis', $contractId, $userId, $contractKey, $contractType, $transfer, $signDate, $clubId, $contractLocation, $contractDate, $termsConditions, $contractQuit, $hostType, $clientFirst, $clientMiddle, $clientLast, $clientStreet, $clientCity, $clientState, $clientZip, $clientHomePhone, $clientCellPhone, $clientEmail, $clientDob, $clientLicense, $gracePeriod, $contractHtml);

$contractId = $this->contractId;
//loads the liabilty terms
$this->loadContractTerms();

//get the contract location
$this->loadClubLocation();
//set the signup date to use for service ids
$this->signupDate = date("Y-m-d H:m:s"); 

//convert the contract quit grace period into seconds
$contractQuitSeconds = $this->contractQuit * 86400;
$currentTimeSecs = time();
$this->contractQuit = $currentTimeSecs + $contractQuitSeconds;

$userId = $this->newComissionId;
$contractKey = $this->contractKey;
$contractType = $this->contractType;
$transfer = $this->transfer;
$signDate = $this->signupDate; 
$clubId = $this->locationId;
$contractLocation = $this->clubLocation;
$contractDate = date("Y-m-d");  //this might be different from signup date make the same for now
$termsConditions = $this->termsConditions;
$contractQuit = $this->contractQuit;
$hostType = $this->hostType;
$clientFirst = $this->clientFirst;
$clientMiddle = $this->clientMiddle;
$clientLast = $this->clientLast;
$clientStreet = $this->clientStreet;
$clientCity = $this->clientCity;
$clientState = $this->clientState;
$clientZip = $this->clientZip;
$clientHomePhone = $this->clientHomePhone;
$clientCellPhone = $this->clientCellPhone;
$clientEmail = $this->clientEmail;
$clientDob = $this->clientDob;
$clientLicense = $this->clientLicense;
$gracePeriod = $this->gracePeriod; 
$contractHtml = $this->contractHtml;

if(!$stmt->execute())  {
	printf("Error: contract_info %s.\n", $stmt->error);
   }		
$stmt->close(); 


/*
echo"
<h3>Contract Info</h3>
User:  $userId
 <br>
Contract Key:  $contractKey
<br>
Contract Type:   $contractType
<br>
Transfer:  $transfer
<br>
Signup Date: $signDate
<br>
Club Id:   $clubId
<br>
Contract Location: $contractLocation
<br>
Contract Date:  $contractDate
<br>
Terms:  $termsConditions
<br>
Contract Quit:  $contractQuit
<br>
Host Type:  $hostType
<br>
Client First:  $clientFirst
<br>
Client Middle:  $clientMiddle
<br>
Client Last:  $clientLast
<br>
Client Street:  $clientStreet
<br>
Client City:  $clientCity
<br>
Client State:  $clientState
<br>
Client Zip:  $clientZip
<br>
Primary Phone:  $clientHomePhone
<br>
Cell Phone:  $clientCellPhone
<br>
Client Email:  $clientEmail
<br>
DOB:  $clientDob
<br>
Drivers License:  $clientLicense
<br>
Grace Period:  $gracePeriod
<br><br><br><br>";
*/

}
//=====================================================================================
function setNewMonthlyUpgrades()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO new_monthly_upgrades VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiiisddssis', $statusId, $contractKey, $serviceKey, $groupNumber, $proRateQuantity, $proRateTerm, $proRatePrice, $proRateDues, $startDate, $endDate, $userId, $signup);


$productFieldArray = $this->productFieldArray;

$statusId = $this->statusId;
$contractKey = $this->contractKey;
$serviceKey = $this->serviceKey;
$groupNumber = $this->groupNumber;
$proRateQuantity = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[5]);
$proRateTerm = $this->serviceTerm;
$proRatePrice = $this->proRatePrice = $productFieldArray[6];
$proRateDues = sprintf("%.2f", $proRatePrice / $proRateQuantity);
$startDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
$endDate = $this->endDate;
$userId = $this->comissionId = $this->newComissionId;
$signup = $this->signupDate;

$this->serviceTerm = 'PM';
$this->groupPrice = 0;
$this->unitPrice = 0;
$this->insertSale();


if(!$stmt->execute())  {
	printf("Error: new_monthly_upgrades %s.\n", $stmt->error);
   }		
$stmt->close(); 


/*
echo"
<h3>New Monthly Upgrades</h3>
Contract Key:  $contractKey
 <br>
Service Key:  $serviceKey
<br>
Group Number:  $groupNumber
<br> 
Pro Rate Quantity:  $proRateQuantity
<br>
Pro Rate Term:   $proRateTerm
<br>
Pro Rate Price:   $proRatePrice
<br>
Pro Rate Dues:  $proRateDues
<br>
Start Date:   $startDate
<br>
End Date:  $endDate
<br>
Commission Credit:  $userId
<br>
Signup Date:  $signup";
*/

}

//=====================================================================================
function insertMonthly() {
$this->loadGroupType();


$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissiddddsddddssssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $numberMonths, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $termType, $initiationFee, $downPayment, $monthlyDues, $proRateDues, $proDateStart, $proDateEnd, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute();

$productFieldArray = $this->productFieldArray = explode("|", $this->productRow);
$this->serviceTerm = "M";
$this->serviceType = "E";

$trans = $this->transfer;
$serviceId = $this->serviceId;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$serviceKey = $this->serviceKey = trim($productFieldArray[7]);

$this->upgradedServiceKeyTest = $serviceKey;
if($this->upgradedServiceKeyTest == $this->newUpgradeServiceKey){
    $this->cancelCurrentMonthlyMembershipAndSubscription();
}


$clubId = $this->clubId = $this->loadClubId($serviceKey);
$serviceName = $this->serviceName = $productFieldArray[0];

      //check to see if this is a service that needs to be prorated
     if($productFieldArray[1] == "") {
     
        $numberMonths = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[5]);
        $groupNumber = $this->groupNumber + $this->newMembers; 
        $startDate= date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
        //add to end date
        $termMonths = $numberMonths + 1;
        $endDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+$termMonths  ,1, date("Y")));
        $newMonthlyUpgradeBit = 0;
        }else{
        
        $numberMonths = $this->serviceQuantity = $productFieldArray[1];
        $this->groupNumber = $this->groupNumber + $this->newMembers;
        $groupNumber = $this->groupNumber;
        $this->getTermDates();
       //$startDate= date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
        $startDate= $this->startDate;
        $endDate = $this->endDate;
        //this sets the status so we can insert later once we get the new service id(statusid)
        $newMonthlyUpgradeBit = 1;        
       }


$unitPrice = $this->unitPrice = sprintf("%.2f",$productFieldArray[2] / $groupNumber);
$unitRenewRate = sprintf("%.2f",$productFieldArray[3] / $groupNumber);
$groupPrice = $this->groupPrice = $productFieldArray[2];
$groupRenewRate = $productFieldArray[3];
$termType = $this->termType;
$initiationFee = $this->initiationFee;  //set as overall for multiple mm services
$downPayment = $this->downPayment = 0;
$monthlyDues = $this->monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);
//--------------------------------------------------------------------
//get the current day number of the month and the numberof days in the month
$current_day_number = date(d);
$month_days_number = date(t);
//divide the month amount by the number of days
$daily_amount = $monthlyDues / $month_days_number;
//get the difference between the days
$date_difference = $month_days_number - $current_day_number;

//create the pro rate amount and format it
$pro_rate_amount = $date_difference * $daily_amount;
//-------------------------------------------------------------------
$proRateDues = $this->proRateDues =  sprintf("%.2f", $pro_rate_amount);
$proDateStart = date("Y-m-d"); 
$proDateEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("t"), date("Y")));
//---------------------------------------------------

//sales person
$userId = $this->comissionId = $this->newComissionId;
$signup = $this->signupDate;

//for no prorated services
if($productFieldArray[1] == "") {
$this->insertSale();
}


if(!$stmt->execute())  {
	printf("Error: monthly_services %s.\n", $stmt->error);
   }	
   
$this->statusId = $stmt->insert_id;   
$stmt->close(); 

if($newMonthlyUpgradeBit == 1)  {
   $this->setNewMonthlyUpgrades();
  }

$this->saveAccountStatus();

/*
echo"
<h3>Monthly Services</h3>
Contract Key:  $contractKey
 <br>
Group Type:  $groupType
<br>
Group Number:  $groupNumber
<br>
Service Key:  $serviceKey
<br>
Club Id:   $clubId
<br>
Service Name:   $serviceName
<br>
Number Months:   $numberMonths
<br>
Unit Price:  $unitPrice
<br>
Unit Renew:  $unitRenewRate
<br>
Group Price:  $groupPrice
<br>
Group Renew:  $groupRenewRate
<br>
Term Type:  $termType
<br>
Init Fee:   $initiationFee
<br>
Down Pay:   $downPayment
<br>
Monthly Dues:  $monthlyDues
<br>
Pro Dues:   $proRateDues
<br>
Pro Date Start:   $proDateStart
<br>
Pro Date End:    $proDateEnd
<br>
Cont Start:    $startDate
<br>
Cont End:     $endDate
<br>
Field Array 1:  $productFieldArray[1] 
<br><br><br>";
*/

}

//=====================================================================================
function insertClassCount() {
$this->loadGroupType();
$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_class_count VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isii', $contractKey, $groupType, $serviceKey, $classCount);
$stmt->execute();

$contractKey = $this->contractKey;
$groupType = $this->groupType;
$serviceKey = $this->serviceKey;
$classCount = $this->serviceQuantity * $this->groupNumber;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


$stmt->close();

}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function insertPaidFull() {
$this->loadGroupType();
$dbMain = $this->dbconnect();
$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute();

$productFieldArray = $this->productFieldArray = explode("|", $this->productRow);
$this->serviceType = "P";

$trans = $this->transfer;
$serviceId = $this->serviceId;
$contractKey = $this->contractKey;
$groupType = $this->groupType;

$this->groupNumber = $this->groupNumber + $this->newMembers;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey = trim($productFieldArray[7]);
$clubId = $this->clubId = $this->loadClubId($serviceKey);
$serviceName = $this->serviceName = $productFieldArray[0];
$serviceQuantity = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[5]);
$serviceTerm = $this->serviceTerm = preg_replace("/[^A-Z]/", "", $productFieldArray[5]);
//calc the unit price
$unitPrice = $this->unitPrice = sprintf("%.2f", $productFieldArray[6] / $this->groupNumber);
//--------------------------------------------------------------
//for renew rate if it is set to NA
if($productFieldArray[3] == 'NA') {
  $unitRenewRate = $this->unitRenewRate = 0;
  }else{
  $unitRenewRate = $this->unitRenewRate = sprintf("%.2f", $productFieldArray[3] / $this->groupNumber);
  }
//-------------------------------------------------------------
$groupPrice = $this->groupPrice = $productFieldArray[2];
$groupRenewRate = $this->groupRenewRate = $productFieldArray[3];
//-------------------------------------------------
//parse the end and start dates for pif
$this->parseStartEndDates();
//-----------------------------------------------------
$startDate = $this->startDate;
$endDate = $this->endDate;

//sales person
$userId = $this->comissionId = $this->newComissionId;
$signup = $this->signupDate;

$this->insertSale();


if(!$stmt->execute())  {
	printf("Error: paid_full_services %s.\n", $stmt->error);
   }
   
$this->statusId = $stmt->insert_id;   
$stmt->close(); 

//if this is a class, insert into member class count table
if($this->serviceTerm == "C") {
   $this->insertClassCount();
  }

$this->saveAccountStatus();

/*
echo"
<h3>PIF Services</h3>
Contract Key:  $contractKey
 <br>
Group Type:  $groupType
<br>
Group Number:  $groupNumber
<br>
Service Key:  $serviceKey
<br>
Club Id:   $clubId
<br>
Service Name:   $serviceName
<br>
Number Quantity:   $serviceQuantity
<br>
Service Term:  $serviceTerm
<br>
Unit Price:  $unitPrice
<br>
Unit Renew Rate:   $unitRenewRate
<br>
Group Price:    $groupPrice
<br>
Group Renew Rate:  $groupRenewRate
<br>
Start Date:   $startDate
<br>
End Date:   $endDate
<br><br><br><br>";
*/


}

//=====================================================================================
function saveNewServices()  {

if($this->productListArray != "")  {
      $productListArray = explode("@", $this->productListArray);
      $productCount = count($productListArray);
      $productCount = $productCount -1;

           for($i=0; $i < $productCount; $i++)  {
           
                   $this->productRow = $productListArray[$i];
                      if(preg_match("/Month\(s\)/", $this->productRow)) {
                        $this->insertMonthly();
                        }else{
                        $this->insertPaidFull();              
                        }     
                }
     } 
}

//========================================================================================
function currentMonthlyUpgrades()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO current_monthly_upgrades VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiiisddssis', $statusId, $contractKey, $serviceKey, $newMembers, $proRateQuantity, $proRateTerm, $proRatePrice, $proRateDues, $startDate, $endDate, $userId, $signup);

$statusId = $this->statusId;
$contractKey = $this->contractKey;
$serviceKey = $this->serviceKey;
$newMembers = $this->newMembers;

//cals the number of months left for the prorated months
//-----------------------------------------------------------------------------------------------
$startDateString = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
$startDateInt = strtotime($startDateString);
$endDateInt = strtotime($this->endDate);
$dateDifference = $endDateInt - $startDateInt;
$this->proRateQuantity = floor($dateDifference / (60*60*24*30));
//-------------------------------------------------------------------------------------------

$proRateQuantity = $this->proRateQuantity;
$proRateTerm = $this->serviceTerm = 'M';
$proRatePrice = $this->proRatePrice;
$proRateDues = sprintf("%.2f",$this->singleMonthlyDues * $this->newMembers);
$startDate = $startDateString;
$endDate = $this->endDate;
$userId = $this->comissionId;
$signup = $this->signupDate;

//set this for the sales insert
$this->groupNumber = $this->newMembers;
$this->serviceQuantity = $proRateQuantity;
$this->serviceType = 'E';
$this->groupPrice = 0;
$this->unitPrice = 0;
//set the prorate amount records 
$this->serviceTerm = 'PM';


$this->insertSale();


if(!$stmt->execute())  {
	printf("Error: current_monthly_upgrades %s.\n", $stmt->error);
   }		
$stmt->close(); 


/*
echo"
<h3>Current Monthly Upgrades</h3>
Contract Key:  $contractKey
<br>
Service Key:  $serviceKey
<br>
New Members:  $newMembers
<br>
Pro Rate Months:  $proRateQuantity
<br>
Months:  $proRateTerm
<br>
Pro Rate Total: $proRatePrice
<br>
Monthly Pro Rate Dues:  $proRateDues
<br>
Start Date:   $startDate
<br>
End Date:   $endDate
<br>
Commission Credit:   $userId
<br>
Sign Date: $signup
<br><br><br><br>
";
*/

}
//====================================================================================================
function cancelCurrentMonthlyMembershipAndSubscription(){
$dbMain = $this->dbconnect();
    
$stmt = $dbMain ->prepare("SELECT service_info.service_key FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_term = 'M' AND service_type LIKE '%membership%' AND service_info.service_key != '$this->newUpgradeServiceKey' LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key);
$stmt->fetch();
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT monthly_dues FROM monthly_services WHERE service_key = '$service_key' AND contract_key = '$this->contractKey' ORDER BY signup_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->cancMonthlyDues);
$stmt->fetch();
$stmt->close(); 

$account_status = 'CA';

$sql = "UPDATE account_status SET account_status=? WHERE contract_key = '$this->contractKey' AND service_key = '$service_key'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $account_status);
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

//$this->cancelCsSubscription();
//$this->cancelRgSubscription();
  
}
//========================================================================================
function insertCurrentMonthly()  {
$this->loadGroupType();
 $prorateRowArray = explode("|", $this->prorateRow); 
 $this->proRatePrice = $prorateRowArray[0];
 $this->serviceKey = $prorateRowArray[1];
 $this->dailyRate = $prorateRowArray[3];
 
 
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name,  number_months, unit_price, unit_renew_rate, group_price, group_renew_rate, term_type, initiation_fee, down_payment, monthly_dues, pro_rate_dues, pro_date_start, pro_date_end, start_date, end_date, user_id, transfer FROM monthly_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_number, $club_id, $service_name,  $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id, $trans);
$stmt->fetch();

$this->groupType = $group_type;
$this->groupNumber = $group_number + $this->newMembers;
$this->clubId = $club_id;
$this->serviceName = $service_name;
$this->serviceQuantity = $number_months;
$this->transfer = $trans;

//$this->unitPrice = $unit_price;
//$this->unitRenewRate = $unit_renew_rate;
//$this->unitPrice = sprintf("%.2f",$unit_price /  $group_number);
$this->unitPrice = sprintf("%.2f",$unit_price);
//$this->unitRenewRate = sprintf("%.2f",$unit_renew_rate /  $group_number);
$this->unitRenewRate = sprintf("%.2f",$unit_renew_rate);

//add the new member to the group price
$this->groupPrice = sprintf("%.2f",$this->unitPrice * $this->groupNumber);
$this->groupRenewRate = sprintf("%.2f",$this->unitRenewRate * $this->groupNumber);
$this->termType = $term_type;
$this->initiationFee = 0;
$this->downPayment = 0;

//calc the monthly dues
$singleMonthlyDues = $this->singleMonthlyDues = $monthly_dues / $group_number;
$this->monthlyDues = sprintf("%.2f", $singleMonthlyDues * $this->groupNumber);

//get the current day number of the month and the numberof days in the month
$current_day_number = date(d);
$month_days_number = date(t);
$date_difference = $month_days_number - $current_day_number;
$this->dailyRate = $this->dailyRate * $this->newMembers;

//create the pro rate amount and format it
////////////////$this->proRateDues = sprintf("%.2f", $date_difference * $this->dailyRate);

$this->proDateStart = date("Y-m-d"); 
$this->proDateEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("t"), date("Y")));
$this->startDate = $start_date;
$this->endDate = $end_date;


$this->comissionId = $user_id;
$this->checkCommissionId();

//close the current statement
$stmt->close(); 

$sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissiddddsddddssssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $numberMonths, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $termType, $initiationFee, $downPayment, $monthlyDues, $proRateDues, $proDateStart, $proDateEnd, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute();

$serviceId = $this->serviceId;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey;
$clubId = $this->clubId;
$serviceName = $this->serviceName;
$numberMonths = $this->serviceQuantity;
$unitPrice = $this->unitPrice;
$unitRenewRate = $this->unitRenewRate;
$groupPrice = $this->groupPrice;
$groupRenewRate = $this->groupRenewRate;
$termType = $this->termType;
$initiationFee = $this->initiationFee;
$downPayment = $this->downPayment;
$monthlyDues = $this->monthlyDues;
$proRateDues = $this->currentMonthlyProrate;
$proDateStart = $this->proDateStart;
$proDateEnd = $this->proDateEnd;
$startDate = $this->startDate;
$endDate = $this->endDate;
$userId = $this->comissionId;
$signup = $this->signupDate;
$trans = $this->transfer;

if(!$stmt->execute())  {
	printf("Error: monthly_services %s.\n", $stmt->error);
   }	
   
$this->statusId = $stmt->insert_id;    
$stmt->close(); 

$this->saveAccountStatus();
$this->currentMonthlyUpgrades();

/*
echo"
<h3>Current Monthly Services</h3>
Contract Key:  $contractKey
 <br>
Group Type:  $groupType
<br>
Group Number:  $groupNumber
<br>
Service Key:  $serviceKey
<br>
Club Id:   $clubId
<br>
Service Name:   $serviceName
<br>
Number Months:   $numberMonths
<br>
Unit Price:  $unitPrice
<br>
Unit Renew:  $unitRenewRate
<br>
Group Price:  $groupPrice
<br>
Group Renew:  $groupRenewRate
<br>
Term Type:  $termType
<br>
Init Fee:   $initiationFee
<br>
Down Pay:   $downPayment
<br>
Monthly Dues:  $monthlyDues
<br>
Pro Dues:   $proRateDues
<br>
Pro Date Start:   $proDateStart
<br>
Pro Date End:    $proDateEnd
<br>
Cont Start:    $startDate
<br>
Cont End:     $endDate
<br>
Sign Date:     $signup
<br><br><br>";
 */
}
//========================================================================================
function currentPaidFullUpgrades()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO current_pif_upgrades VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiidssis', $statusId, $contractKey, $serviceKey, $newMembers, $proRatePrice, $startDate, $endDate, $userId, $signup);

$statusId = $this->statusId;
$contractKey = $this->contractKey;
$serviceKey = $this->serviceKey;
$newMembers = $this->newMembers;
$proRatePrice = $this->proRatePrice;
$startDate = date("Y-m-d H:i:s"); 

//check to see if it a class so ther is no end date
if($this->serviceTerm == "C") {
   $endDate = '0000-00-00';
   }else{
   $endDate = $this->endDate;
   }

$userId = $this->comissionId;
$signup = $this->signupDate;

//we setthi for the sales table
$this->groupNumber = $this->newMembers;
$this->serviceQuantity = 1;
$this->serviceTerm = 'PF';
$this->serviceType = 'P';
$this->unitPrice = 0;
$this->groupPrice = 0;


if(!$stmt->execute())  {
	printf("Error: current_pif_upgrades %s.\n", $stmt->error);
   }		
$stmt->close(); 

$this->saveAccountStatus();
$this->insertSale();

/*
echo"
<h3>Current PIF Upgrades</h3>
Contract Key:  $contractKey
<br>
Service Key:  $serviceKey
<br>
New Members:  $newMembers
<br>
Pro Rate Price:   $proRatePrice
<br>
Start Date:  $startDate
<br> 
End Date:  $endDate
<br> 
Comission Credit:  $userId
<br>
Sign Date:  $signup
<br><br><br><br>";
*/

}
//========================================================================================
function insertCurrentPaidFull() {
$this->loadGroupType();
 $prorateRowArray = explode("|", $this->prorateRow); 
 $this->proRatePrice = $prorateRowArray[0];
 $this->serviceKey = $prorateRowArray[1];
 $this->dailyRate = $prorateRowArray[3];

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name,  service_quantity, service_term, unit_price, unit_renew_rate, group_price, group_renew_rate, start_date, end_date, user_id, transfer FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY signup_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($group_type, $group_number, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $trans);
$stmt->fetch();

$this->groupType = $group_type;
$this->groupNumber = $group_number + $this->newMembers;
$this->clubId = $club_id;
$this->serviceName = $service_name;
$this->serviceQuantity = $service_quantity;
$this->serviceTerm = $service_term;
$this->unitPrice = $unit_price;
$this->unitRenewRate = $unit_renew_rate;
$this->groupPrice = sprintf("%.2f", $this->unitPrice * $this->groupNumber);
$this->groupRenewRate = sprintf("%.2f", $this->unitRenewRate * $this->groupNumber);
$this->startDate = $start_date;
$this->endDate = $end_date;
$this->transfer = $trans;


$this->comissionId = $user_id;
$this->checkCommissionId();

//close the current statement
$stmt->close(); 


$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute(); 

$serviceId = $this->serviceId;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey;
$clubId = $this->clubId;
$serviceName = $this->serviceName;
$serviceQuantity = $this->serviceQuantity;
$serviceTerm = $this->serviceTerm;
$unitPrice = $this->unitPrice;
$unitRenewRate = $this->unitRenewRate;
$groupPrice = $this->groupPrice;
$groupRenewRate = $this->groupRenewRate;
$startDate = $this->startDate;
$endDate = $this->endDate;
$userId = $this->comissionId;
$signup = $this->signupDate;
$trans = $this->transfer;

if(!$stmt->execute())  {
	printf("Error: paid_full_services %s.\n", $stmt->error);
   }
   
$this->statusId = $stmt->insert_id;    
$stmt->close(); 


$this->currentPaidFullUpgrades();

/*
echo"
<h3>Current PIF Services</h3>
Contract Key:  $contractKey
 <br>
Group Type:  $groupType
<br>
Group Number:  $groupNumber
<br>
Service Key:  $serviceKey
<br>
Club Id:   $clubId
<br>
Service Name:   $serviceName
<br>
Number Quantity:   $serviceQuantity
<br>
Service Term:  $serviceTerm
<br>
Unit Price:  $unitPrice
<br>
Unit Renew Rate:   $unitRenewRate
<br>
Group Price:    $groupPrice
<br>
Group Renew Rate:  $groupRenewRate
<br>
Start Date:   $startDate
<br>
End Date:   $endDate
<br>
Commission Credit:  $userId
<br>
Sign Date:  $signup
<br><br><br><br>";
*/
}
//========================================================================================
function saveCurrentServices()  {

   if($this->newMembers != 0)  {
   
     $currentProrateArray = explode("@", $this->currentProrateArray); 
     $prorateCount = count($currentProrateArray);
     $prorateCount = $prorateCount - 1;
     
                 for($i=0; $i < $prorateCount; $i++)  {

                          $this->prorateRow = $currentProrateArray[$i];
                             if(preg_match("/M/", $this->prorateRow)) {
                                $this->insertCurrentMonthly();
                                }else{
                                $this->insertCurrentPaidFull();
                                }        
                       }
      }
}

//========================================================================================
function insertSale()  {
$this->loadGroupType();
$dbMain = $this->dbconnect();
$sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisisiiisissddsddissssssss', $salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew);

$this->loadClubLocation();
$this->parseComissionId();

$salesKey = "";
$locationId = $this->locationId;
$contractLocation = $this->clubLocation;
$userId = $this->comissionId;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$clubId = $this->clubId;
$serviceKey = $this->serviceKey;
$serviceName = $this->serviceName;
$serviceQuantity = $this->serviceQuantity;
$serviceTerm = $this->serviceTerm;
$serviceType = $this->serviceType;

if(($this->serviceTerm != 'PF') && ($this->serviceTerm != 'PM')) {
$unitPrice = $this->loadUnitPrice();  //in case of price overide this checks the original price
$groupPrice = $unitPrice * $this->groupNumber;  //plays off the original cost
}else{
$unitPrice = $this->unitPrice;
$groupPrice = $this->proRatePrice;
}

$overidePin = $this->overidePin;
$overideUnitPrice = $this->unitPrice;
$overideGroupPrice = $this->groupPrice; 
$contractKey = $this->contractKey;

//sets the paid full membership to T
if(($this->serviceTerm == 'Y') || ($this->serviceTerm == 'W') || ($this->serviceTerm == 'D') || ($this->serviceTerm == 'PF'))  { 
   $termType = 'T';
   }else{
   $termType = $this->termType;
   }

$renewal = $this->renewal;
$upgrade = $this->upgrade;
$internet = $this->internet;
$saleDateTime = $this->signupDate;
$amPm = date("a");
$earlyRenewalBoon = 'N';
$salesNew = 'N';


//this checks to see if the client is eligable for an enhancement fee then saves the info. this also gets the guarantee fee if it exists and saves
$this->loadEnhanceGuaranteeFees();

  if(!$stmt->execute())  {
	printf("Error: sales_info %s.\n", $stmt->error);
   }		

$stmt->close(); 

include"commissionRecords.php";

/*
echo"
<h3>Sales Info</h3>
Location Id: $locationId
<br>
Contract Location: $contractLocation
<br>
Commission Credit:  $userId 
<br>
Group Type:  $groupType
<br>
Group Number: $groupNumber
<br>
Club Id: $clubId
<br>
Service Key:  $serviceKey
<br>
Service Name: $serviceName
<br>
Service Quantity:  $serviceQuantity
<br>
Service Term:  $serviceTerm
<br>
Service Type:  $serviceType
<br>
Unit Price:  $unitPrice
<br>
Group Price:  $groupPrice
<br>
Override Pin: $overidePin
<br>
Override Unit Price:  $overideUnitPrice
<br>
Override Group Price:  $overideGroupPrice
<br>
Contract Key: $contractKey
<br>
Term Type:  $termType
<br>
Sale Date Time:   $saleDateTime
<br>
AM PM:  $amPm
<br><br><br>";
*/

}
//=======================================================================================
function insertMember() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissssssissssssssss', $generalId, $contractKey, $memberId, $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primePhone, $cellPhone, $email, $dob, $license, $emgName, $emgRelation, $emgPhone, $liabilityTerms, $memberPhoto);

$generalId = $this->generalId;
$contractKey = $this->contractKey;
$memberId = "";
$firstName = "";
$middleName = "";
$lastName = "";
$street = "";
$city = "";
$state = "";
$zip = "";
$primePhone = "";
$cellPhone = "";
$email = "";
$dob_orig = "";
$dob = "";
$license = "";
$emgName = "";
$emgRelation = "";
$emgPhone = "";
$liabilityTerms = $this->liabilityTerms;
$memberPhoto = "";



if(!$stmt->execute())  {
	printf("Error: member_info %s.\n", $stmt->error);
   }		

$stmt->close(); 

}

//=======================================================================================
function saveMemberInfo() {

    if($this->newMembers != 0) {
         $groupCount = $this->newMembers;
         for($i=0; $i < $groupCount; $i++)  {
              $this->insertMember();
             }
       }

}
//=======================================================================================
function saveInitialPayments() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iddddddddddsssdsiss', $contractKey, $processFeeMonthly, $processFeePif, $enhanceFee, $newMemberFee, $todaysPayment, $cashPayment, $checkPayment, $achPayment, $creditPayment, $balanceDue, $dueDate, $processDate, $dueStatus, $minTotalDue, $signDate, $clubId, $category, $internet);


$contractKey = $this->contractKey;
$processFeeMonthly = $this->procFeeEft;
$processFeePif = $this->procFeePif;
$enhanceFee = 0;
$newMemberFee = $this->newMemberFee;
$todaysPayment = $this->todaysPayment;
$cashPayment = $this->cashPayment;
$checkPayment = $this->checkPayment;
$achPayment = $this->achPayment;
$creditPayment = $this->creditPayment;
$balanceDue = $this->balanceDue;
//-------------------------------------------------
$d =  strtotime($this->dueDate);
//------------------------------------------------
$dueDate = date("Y-m-d", $d);
$processDate = date("Y-m-d");
//----------------------------------------------------
//check to see if there is a balance due. if not mark status as paid
if($balanceDue == "0.00")  {
   $dueStatus = "P";
   $historyDueStatus = 'PF';
   }else{
   $historyDueStatus = 'BD';
   $dueStatus = "G";
   }
//---------------------------------------------------
$minTotalDue = $this->minimumTotalDue;
$signDate = $this->signupDate;
$clubId = $this->locationId;
$category = $this->contractType;
$internet = 'N';

if(!$stmt->execute())  {
	printf("Error: initial_payments %s.\n", $stmt->error);
   }		

$stmt->close(); 

//here we set the payment history. First we load the payment description
//---------------------------------------------------------------------------------
$this->loadPaymentDescription();
$this->paymentHistory();


/*
echo"
<h3>Initial Payments</h3>
Contract Key:  $contractKey
 <br>
Month Fee:  $processFeeMonthly
<br>
PIF Fee:  $processFeePif
<br>
Enhance Fee:  $enhanceFee
<br>
New Member Fee: $newMemberFee
<br>
Todays Payment:  $todaysPayment
<br>
Cash Payment:   $cashPayment
<br>
Check Payment:   $checkPayment
<br>
ACH Payment:    $achPayment
<br>
Credit Payment:  $creditPayment
<br>
Balance Due:  $balanceDue
<br>
Due Date:   $dueDate
<br>
Process Date:  $processDate
<br>
Due Status:  $dueStatus
<br>
Min Total Due:  $minTotalDue
<br><br><br>";
*/
}

//=======================================================================================
function updateMonthlyBilling()  {

$dbMain = $this->dbconnect();

//check to see if the billing amount element is null, if so then get the original payment amount
if($this->newMonthlyPayment == "" ||  $this->newMonthlyPayment == "0.00" || $this->newMonthlyPayment == "undefined") {
  
    $stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($billing_amount);   
    $stmt->fetch();             
    $this->newMonthlyPayment = $billing_amount;        
    $stmt->close(); 
  }

if($this->upgradedServiceKeyTest == $this->newUpgradeServiceKey){
    $this->newMonthlyPayment -= $this->cancMonthlyDues;
    $this->newMonthlyPayment = sprintf("%.2f",$this->newMonthlyPayment);
}

$sql = "UPDATE monthly_payments SET monthly_billing_type=?, cycle_date=?, billing_amount=?, billing_status=?  WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssds', $monthlyBillingType, $cycleDate, $billingAmount, $billingStatus);

$monthlyBillingType = $this->monthlyBillingType;
$cycleDate = $this->loadCycleDate();
$billingAmount = $this->newMonthlyPayment;
$billingStatus = "G";

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$stmt->close(); 


//cancel the original subscription
//$this->cancelCsSubscription();


/*
      // if cancel is a success then create the subscription 
    if($this->canceledReasonCode == 100) {

           if($this->monthlyBillingType == 'CR' || $this->monthlyBillingType == 'BA') {

               //trim vars from text fields
               $this->cardName = trim($this->cardName);
               $this->cardNumber= trim($this->cardNumber);
               $this->cardCvv = trim($this->cardCvv);
               $this->accountName = trim($this->accountName);
               $this->accountNumber = trim($this->accountNumber);
               $this->abaNumber = trim($this->abaNumber);
               $this->clientStreet = trim($this->clientStreet);
               $this->clientCity = trim($this->clientCity);
               $this->clientState = trim($this->clientState);
               $this->clientZip = trim($this->clientZip);
               $this->clientHomePhone = trim($this->clientHomePhone);
               $this->clientEmail = trim($this->clientEmail);
               $this->clientLicense = trim($this->clientLicense);

               //replace anything that is not a number for cc routing number bank account number
               $this->cardNumber = preg_replace("/[^0-9 .]+/", "" ,$this->cardNumber);
               $this->abaNumber = preg_replace("/[^0-9 .]+/", "" ,$this->abaNumber);
               $this->accountNumber = preg_replace("/[^0-9 .]+/", "" ,$this->accountNumber);
               $this->newMonthlyPayment = number_format($this->newMonthlyPayment, 2, '.', '');

               //send off vars to format
               $fieldParse = new parseGatewayFields(); 
               $fieldParse-> setCardName($this->cardName);
               $fieldParse-> setAchName($this->accountName);
               $fieldParse-> setCardType($this->cardType);
               $fieldParse-> setAccountType($this->accountType);
               $fieldParse-> setAccountPhone($this->clientHomePhone);
               $fieldParse-> setCardExpDate($this->cardExpDate);
               $fieldParse-> parsePaymentFields();

               //reassign vars for CS Credit Cards
               $ccFirstName = $fieldParse-> getCredtCardFirstName();
               $ccLastName = $fieldParse-> getCredtCardLastName();
               $ccCardType = $fieldParse-> getCardType();
               $ccCardYear = $fieldParse-> getCardYear();  
               $ccCardMonth = $fieldParse-> getCardMonth();
               $ccCardNumber = $this->cardNumber;
               $ccCardCvv = $this->cardCvv;


               //reassign vars for ACH  
               $achFirstName = $fieldParse-> getAchFirstName();
               $achLastName = $fieldParse-> getAchLastName();  
               $accountStreet = $this->clientStreet;
               $accountCity = $this->clientCity;
               $accountState = $this->clientState;
               $accountZip = $this->clientZip;
               $accountPhone = $fieldParse-> getAccountPhone(); 
               $accountEmail = $this->clientEmail;
               $accountDriversLic = $this->clientLicense;
               $achAccountType = $fieldParse-> getAccountType();
               $achRoutingNumber = $this->abaNumber;
               $achAccountNumber = $this->accountNumber;
               $billingAmount = $this->newMonthlyPayment;
               $billingDate = date("Ymd", strtotime($cycleDate));
  
                //here we send the info to CS for recursive billing
               //below is the Cyber source soap class
               $authOptions = new gatewayAuth();
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
               $request->merchantReferenceCode = $this->contractKey;
               $request->clientLibrary = "PHP";
               $request->clientLibraryVersion = phpversion();
               $request->clientEnvironment = php_uname();  

               $billTo = new stdClass();
               $card = new stdClass();
               $check = new stdClass();
               $purchaseTotals = new stdClass();
               $paySubscriptionCreateService = new stdClass();
               $recurringSubscriptionInfo = new stdClass();
               $subscription = new stdClass();
               $businessRules = new stdClass();
  
               $paySubscriptionCreateService->run = "true";
               $paySubscriptionCreateService->disableAutoAuth = "true";
               $request->paySubscriptionCreateService = $paySubscriptionCreateService;  
  
               $recurringSubscriptionInfo->frequency = "monthly"; 
               $recurringSubscriptionInfo->amount = $billingAmount;
               $recurringSubscriptionInfo->startDate = $billingDate;
               $request->recurringSubscriptionInfo = $recurringSubscriptionInfo; 
  
               $purchaseTotals->currency = "USD";
               $request->purchaseTotals = $purchaseTotals; 
  
               $businessRules->ignoreAVSResult = "true";
               $request->businessRules = $businessRules;  
  
////////////////////////////////////////////////////////////////////////////////////////////////
 //takes care of CC EFT
               if($this->monthlyBillingType == 'CR') {
    
                  $billTo->firstName = $ccFirstName;
                  $billTo->lastName = $ccLastName;
                  $billTo->street1 = $accountStreet;
                  $billTo->city = $accountCity;
                  $billTo->state = $accountState;
                  $billTo->postalCode = $accountZip;
                  $billTo->country = "US";
                  $billTo->email = $accountEmail;
                  $billTo->phoneNumber = $accountPhone;
                  $request->billTo = $billTo;  

                  $card->accountNumber = $ccCardNumber;
                  $card->expirationMonth = $ccCardMonth;
	              $card->expirationYear = $ccCardYear;	
                  $card->cardType = $ccCardType;
	              $request->card = $card;

	              $subscription->paymentMethod = "credit card";
                  $subscription->title = "EFT Credit";
	              $request->subscription = $subscription;
	

                }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Takes care of banking eft
               if($this->monthlyBillingType == 'BA') {

                  $billTo->firstName = $achFirstName;
                  $billTo->lastName = $achLastName;
                  $billTo->street1 = $accountStreet;
                  $billTo->city = $accountCity;
                  $billTo->state = $accountState;
                  $billTo->postalCode = $accountZip;
                  $billTo->country = "US";
                  $billTo->email = $accountEmail;
                  $billTo->phoneNumber = $accountPhone;
                  //$billTo->driversLicenseNumber = $accountDriversLic;
                  //$billTo->driversLicenseState = $accountState;    
                  $request->billTo = $billTo;  

                  $check->accountNumber = $achAccountNumber;
               	  $check->accountType = $achAccountType;
	              $check->bankTransitNumber = $achRoutingNumber;
	                 if($achAccountType == "X") {
	                    $secVal = 'PPD';
	                   }else{
	                    $secVal = 'PPD';
	                   }
	              $check->secCode = $secVal;
	              $request->check = $check;
	 
	              $subscription->paymentMethod = "check";
                  $subscription->title = "EFT Bank";
	              $request->subscription = $subscription;	 
	 	 
                }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
//send off to CS and get response    
   $soapClient = new ExtendedClient(WSDL_URL, array());
   $reply = $soapClient->runTransaction($request);
   $decision = $reply->decision;
   $reasonCode = $reply->reasonCode;
   $requestID = $reply->requestID;
   $requestToken = $reply->requestToken;	
   $subscriptionID = $reply->paySubscriptionCreateReply->subscriptionID;
   $this->psReasonCode = $reply->paySubscriptionCreateReply->reasonCode;   
   $this->psReasonCode = $reasonCode;
    
    

 echo"CC First Name: $ccFirstName
<br>
CC Last Name: $ccLastName
<br>
Card Number: $ccCardNumber
<br>
Card Type: $ccCardType
<br>
Card CVV: $ccCardCvv
<br>
Card Month:  $ccCardMonth
<br>
Card Year: $ccCardYear
<br>
ACH First Name: $achFirstName
<br>
ACH Last Name: $achLastName
<br>
ACH Type:  $achAccountType
<br>
ACH Acct Numb: $achAccountNumber
<br>
ACH ABA: $achRoutingNumber
<br>
Client Street: $accountStreet
<br>
Client City: $accountCity
<br>
Client State: $accountState 
<br>
Client Zip: $accountZip
<br>
Client Phone:  $accountPhone
<br>
Client Email: $accountEmail
<br>
Client Lic: $accountDriversLic
<br>
Billing Amount: $billingAmount
<br>
Billing Date: $billingDate
<br>
Canceled Reason Code: $this->canceledReasonCode
<br>
Reason Code: $reasonCode
<br>
PS Reason Code: $this->psReasonCode";

    
    
    
   //if descision is accept e.g. 100 then we insert into the subscription table check for inhance fees rate guarantee 
      if($this->psReasonCode == 100) {
         $this->subscriptionID = $subscriptionID;
         $this->subscriptionType = 'MS';
         $this->updateServiceSubscriptions();         
        }else{
         $this->subscriptionType = 'MS';
         $this->csBillingAmount = $billingAmount;
         $this->frequency = "monthly";
         $this->saveFailedSubscriptions();
        }  
  

  
}
    
}//end if reason code is 100
*/
}
//======================================================================================
function saveMonthlyBilling() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_payments VALUES (?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issds', $contractKey, $monthlyBillingType, $cycleDate, $billingAmount, $billingStatus);

$contractKey = $this->contractKey;
$monthlyBillingType = $this->monthlyBillingType;
$cycleDate = $this->loadCycleDate();
$billingAmount = $this->newMonthlyPayment;
$billingStatus = "G";

if(!$stmt->execute())  {
	printf("Error: monthly_payments %s.\n", $stmt->error);
   }		

$stmt->close(); 
/*
if($monthlyBillingType == 'CR' || $monthlyBillingType == 'BA') {

//trim vars from text fields
$this->cardName = trim($this->cardName);
$this->cardNumber= trim($this->cardNumber);
$this->cardCvv = trim($this->cardCvv);
$this->accountName = trim($this->accountName);
$this->accountNumber = trim($this->accountNumber);
$this->abaNumber = trim($this->abaNumber);
$this->clientStreet = trim($this->clientStreet);
$this->clientCity = trim($this->clientCity);
$this->clientState = trim($this->clientState);
$this->clientZip = trim($this->clientZip);
$this->clientHomePhone = trim($this->clientHomePhone);
$this->clientEmail = trim($this->clientEmail);
$this->clientLicense = trim($this->clientLicense);

//replace anything that is not a number for cc routing number bank account number
$this->cardNumber = preg_replace("/[^0-9 .]+/", "" ,$this->cardNumber);
$this->abaNumber = preg_replace("/[^0-9 .]+/", "" ,$this->abaNumber);
$this->accountNumber = preg_replace("/[^0-9 .]+/", "" ,$this->accountNumber);
$this->newMonthlyPayment = number_format($this->newMonthlyPayment, 2, '.', '');

//send off vars to format
  $fieldParse = new parseGatewayFields(); 
  $fieldParse-> setCardName($this->cardName);
  $fieldParse-> setAchName($this->accountName);
  $fieldParse-> setCardType($this->cardType);
  $fieldParse-> setAccountType($this->accountType);
  $fieldParse-> setAccountPhone($this->clientHomePhone);
  $fieldParse-> setCardExpDate($this->cardExpDate);
  $fieldParse-> parsePaymentFields();

  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
  $ccCardYear = $fieldParse-> getCardYear();  
  $ccCardMonth = $fieldParse-> getCardMonth();
  $ccCardNumber = $this->cardNumber;
  $ccCardCvv = $this->cardCvv;


  //reassign vars for ACH  
  $achFirstName = $fieldParse-> getAchFirstName();
  $achLastName = $fieldParse-> getAchLastName();  
  $accountStreet = $this->clientStreet;
  $accountCity = $this->clientCity;
  $accountState = $this->clientState;
  $accountZip = $this->clientZip;
  $accountPhone = $fieldParse-> getAccountPhone(); 
  $accountEmail = $this->clientEmail;
  $accountDriversLic = $this->clientLicense;
  $achAccountType = $fieldParse-> getAccountType();
  $achRoutingNumber = $this->abaNumber;
  $achAccountNumber = $this->accountNumber;
  $billingAmount = $this->newMonthlyPayment;
  $billingDate = date("Ymd", strtotime($cycleDate));
  
  //here we send the info to CS for recursive billing
  //below is the Cyber source soap class
  $authOptions = new gatewayAuth();
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
  $request->merchantReferenceCode = $this->contractKey;
  $request->clientLibrary = "PHP";
  $request->clientLibraryVersion = phpversion();
  $request->clientEnvironment = php_uname();  

  $billTo = new stdClass();
  $card = new stdClass();
  $check = new stdClass();
  $purchaseTotals = new stdClass();
  $paySubscriptionCreateService = new stdClass();
  $recurringSubscriptionInfo = new stdClass();
  $subscription = new stdClass();
  $businessRules = new stdClass();
  
  $paySubscriptionCreateService->run = "true";
  $paySubscriptionCreateService->disableAutoAuth = "true";
  $request->paySubscriptionCreateService = $paySubscriptionCreateService;  
  
  $recurringSubscriptionInfo->frequency = "monthly"; 
  $recurringSubscriptionInfo->amount = $billingAmount;
  $recurringSubscriptionInfo->startDate = $billingDate;
  $request->recurringSubscriptionInfo = $recurringSubscriptionInfo; 
  
  $purchaseTotals->currency = "USD";
  $request->purchaseTotals = $purchaseTotals; 
  
  $businessRules->ignoreAVSResult = "true";
  $request->businessRules = $businessRules;  
  
////////////////////////////////////////////////////////////////////////////////////////////////
  //takes care of CC EFT
  if($monthlyBillingType == 'CR') {
    
     $billTo->firstName = $ccFirstName;
     $billTo->lastName = $ccLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     $request->billTo = $billTo;  

     $card->accountNumber = $ccCardNumber;
	 $card->expirationMonth = $ccCardMonth;
	 $card->expirationYear = $ccCardYear;	
     $card->cardType = $ccCardType;
	 $request->card = $card;

	 $subscription->paymentMethod = "credit card";
     $subscription->title = "EFT Credit";
	 $request->subscription = $subscription;
	

  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Takes care of banking eft
  if($monthlyBillingType == 'BA') {

     $billTo->firstName = $achFirstName;
     $billTo->lastName = $achLastName;
     $billTo->street1 = $accountStreet;
     $billTo->city = $accountCity;
     $billTo->state = $accountState;
     $billTo->postalCode = $accountZip;
     $billTo->country = "US";
     $billTo->email = $accountEmail;
     $billTo->phoneNumber = $accountPhone;
     //$billTo->driversLicenseNumber = $accountDriversLic;
     //$billTo->driversLicenseState = $accountState;    
     $request->billTo = $billTo;  

     $check->accountNumber = $achAccountNumber;
	 $check->accountType = $achAccountType;
	 $check->bankTransitNumber = $achRoutingNumber;
	   if($achAccountType == "X") {
	      $secVal = 'PPD';
	     }else{
	      $secVal = 'PPD';
	     }
	 $check->secCode = $secVal;
	 $request->check = $check;
	 
	$subscription->paymentMethod = "check";
    $subscription->title = "EFT Bank";
	$request->subscription = $subscription;	 
	 	 
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
//send off to CS and get response    
   $soapClient = new ExtendedClient(WSDL_URL, array());
   $reply = $soapClient->runTransaction($request);
   $decision = $reply->decision;
   $reasonCode = $reply->reasonCode;
   $requestID = $reply->requestID;
   $requestToken = $reply->requestToken;	
   $subscriptionID = $reply->paySubscriptionCreateReply->subscriptionID;
   $this->psReasonCode = $reply->paySubscriptionCreateReply->reasonCode;   
   $this->psReasonCode = $reasonCode;
    
   //if descision is accept e.g. 100 then we insert into the subscription table check for inhance fees rate guarantee 
      if($this->psReasonCode == 100) {
         $this->subscriptionID = $subscriptionID;
         $this->subscriptionType = 'MS';
         $this->saveServiceSubscriptions();         
        }else{
         $this->subscriptionType = 'MS';
         $this->csBillingAmount = $billingAmount;
         $this->frequency = "monthly";
         $this->saveFailedSubscriptions();
        }  
/*  
echo"CC First Name: $ccFirstName
<br>
CC Last Name: $ccLastName
<br>
Card Number: $ccCardNumber
<br>
Card Type: $ccCardType
<br>
Card CVV: $ccCardCvv
<br>
Card Month:  $ccCardMonth
<br>
Card Year: $ccCardYear
<br>
ACH First Name: $achFirstName
<br>
ACH Last Name: $achLastName
<br>
ACH Type:  $achAccountType
<br>
ACH Acct Numb: $achAccountNumber
<br>
ACH ABA: $achRoutingNumber
<br>
Client Street: $accountStreet
<br>
Client City: $accountCity
<br>
Client State: $accountState 
<br>
Client Zip: $accountZip
<br>
Client Phone:  $accountPhone
<br>
Client Email: $accountEmail
<br>
Client Lic: $accountDriversLic
<br>
Billing Amount: $billingAmount
<br>
Billing Date: $billingDate";

  
  
}*/


/*
echo"
<h3>Billing Status</h3>
Contract Key: $contractKey
<br>
Billing Type: $monthlyBillingType
<br>
Cycle Date:  $cycleDate
<br>
Billing Amount: $billingAmount
<br>
Billing Status: $billingStatus
<br><br><br>
";*/

}

//======================================================================================

//here are the getter methods
function getGroupType()  {
              return($this->groupType); 
              }
function getGroupName()  {
              return($this->groupName); 
              }              
function getGroupInfoArray()  {
              return($this->groupInfoArray); 
              }
function getAddressInfoArray()  {
              return($this->addressInfoArray); 
              }
function getProductListArray()  {
              return($this->productListArray); 
              }
function getNewMembers()  {
              return($this->newMembers);
              }
function getCurrentProrateArray()  {
              return($this->currentProrateArray); 
              }
function getTransfer()  {
              return($this->transfer);
              }
function getProRateDues()  {
              return($this->proRateDues);
              }
function getProcFeeEft()  {
              return($this->procFeeEft); 
              }
function getInitialFeesEft()  {
              return($this->initialFeesEft); 
              }
function getMonthlyBillingType() {
              return($this->monthlyBillingType);
             }                
function getMonthlyPayment()  {
              return($this->monthlyPayment);   //this is for new services selected
              }
function getNewMonthlyPayment()  {
              return($this->newMonthlyPayment);  //this shows the combined monthly payment for new and current services
              }
function getCurrentMonthlyProrate()  {
              return($this->currentMonthlyProrate);
              }
function getTotalMonthlyServices()  {
              return($this->totalMonthlyServices);
              }
function getOpenEnded()  {
              return($this->openEnded); 
              }
function getInitiationFee()  {
              return($this->initiationFee); 
              }
function getNewTotalPifServices()  {
              return($this->newTotalPifServices); 
              }
function getProcFeePif()  {
              return($this->procFeePif); 
              }
function getNewPifgrandTotal()  {
              return($this->newPifGrandTotal);
              }
function getCurrentPifProrateTotal()  {
              return($this->currentPifProrateTotal); 
              }
function getNewCurrentPifGrandTotal()  {
              return($this->newCurrentPifGrandTotal); 
              }
function getCurrentRenewTotal()  {
              return($this->currentRenewTotal); 
              }
function getCurrentMonthlyPayment()  {
              return($this->currentMonthlyPayment); 
              }
function getNewMemberFee()  {
              return($this->newMemberFee); 
              }
function getNewServicesTotal()  {
              return($this->newServicesTotal); 
              }
function getNewRenewalRateTotal()  {
              return($this->newRenewalRateTotal);
              }
function getMinimumTotalDue()  {
              return($this->minimumTotalDue); 
              } 
function getTodaysPayment() {
              return($this->todaysPayment);
              }           
function getBalanceDue() {
              return($this->balanceDue); 
              }
function getBalanceDueDate() {
              return($this->balanceDueDate); 
              }
function getContractKey() {
              return($this->contractKey); 
              }
function getTermType() {
              return($this->termType);
             }    
function getDueDate() {
             return($this->dueDate);
             }
function getGroupNumber() {
             return($this->groupNumber);
             }
             
function getFirstName() {
             return($this->firstName);
             } 
function getMiddleName() {
             return($this->middleName);
             }                          
function getLastName() {
             return($this->LastName);
             }     
function getSig() {
       return($this->signature);
       }              
             
}
?>