<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}


require"../nmi/nmiGatewayClass.php";
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";

//date_default_timezone_set('America/Los_Angeles');
class  salesSql{

private $contractId = null;
private $generalId = null;
private $contractKey = null;
private $contractType = null;
private $groupType = null;
private $groupNumber = null;
private $groupTypeInfo = null;   //this is an array that needs to be parsed
private $contractClientInfo = null;  //this is an array that needs to be parsed
private $hostType = null;
private $productList = null;  //this is an array that needs to be parsed
private $transfer = null;
private $proRateDues = null;
private $processFeeMonthly = null;
private $downPayment = null;
private $totalFeesEft = null;
private $monthlyDues = null;
private $monthlyServicesTotal = null;
private $termType = null;
private $initiationFee = null;
private $pifServicesTotal = null;
private $processFeePif = null;
private $pifGrandTotal = null;
private $servicesTotal = null;
private $renewalRateTotal = null;
private $minTotalDue = null;
private $todaysPayment = null;
private $balanceDue = null;
private $dueDate = null;
private $comissionId = null;
private $accountStatus = null;
private $renewal = null;
private $upgrade = null;
private $internet = null;
private $signUpDate = null;
private $guaranteeFee = null;
private $enhanceFee = null;
private $newMemberFee = 0;
private $eftEnhanceCycle = null;
private $pifCycleDate = null;  //this is for enhance fees
private $eftGuaranteeCycle = null;
private $annualCycleDate = null;    //this is for guarantee fees
private $paymentDescription = 'New Service';

private $memberInfoArray = null;  //contains all of the members stuff needs to be parsed
private $emgContactArray = null;  //contains the emergancey contact info needs to be parsed

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
private $ccRequestId = null;

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
private $monthlyBillingType = null;  //the same as a bove but used for the contract print out

//override status
private $overidePin = null;

//notes on the contract
private $noteTopic = null;
private $noteMessage = null;
private $noteUser = null;  //this is the user id of the logged in user
private $noteList;  //since there could be lots of notes this will hold a list of these notes 
private $noteCategory = 'NS';
private $notePriority = null;
private $targetApp = null;

//comission credit
private $commissionCredit = null;   //is email address needs to translate to user id
private $typeKey = null;
private $idCard = null;

//this is for the club location to be set
private $clubLocation;
private $locationId;

//contract terms and miscellaneous
private $termsConditions;
private $contractQuit;
private $liabiliyTerms;
private $gracePeriod;
private $nameSwitch;
private $contractHtml = null;
private $historyKey = null;
private $serviceId = null;
private $statusId = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $termSwitch = null;
private $enhTermSwitch = null;

//cybersource
private $psReasonCode = null;
private $subscriptionID = null;
private $subscriptionType = null;  //cmp type for Monthly Service: MS, Enhance Fee: EF, Rate Guarantee: RG
private $csBillingAmount = null;
private $frequency = null;


function setTermsConditions($termsConditions) {
    $this->termsConditions = $termsConditions;
    }
function setContractQuit($contractQuit) {
    $this->contractQuit = $contractQuit; 
    }
function setLiabiltyTerms($liabilityTerms) {    
    $this->liabilityTerms = $liabilityTerms;
    }
function setGracePeriod($gracePeriod) {    
   $this->gracePeriod = $gracePeriod;
   }
function setContractHtml($contractHtml) {
   $this->contractHtml =$contractHtml;
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
         
//overide pin set to either Yif entered or N if not
function setOveridePin($overidePin) {
       $this->overidePin = $overidePin;
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
       

//sets up all of the gym users contact and emg contact info. needs to be parsed
function setMemberInfoArray($memberInfoArray) {
        $this->memberInfoArray = $memberInfoArray;
        }
function setEmgContactArray($emgContactArray) {
        $this->emgContactArray = $emgContactArray;
        }


//for sales and contract stuff
function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setCommissionCredit($commissionCredit) {
     $this->commissionCredit = $commissionCredit;
     }
function setContractType($contractType) {
       $this->contractType = $contractType;
       }
function setGroupType($groupType) {
       $this->groupType = $groupType;
       }       
function setGroupNumber($groupNumber) {
      $this->groupNumber = $groupNumber;
      }      
function setGroupTypeInfo($groupTypeInfo) {
      $this->groupTypeInfo = $groupTypeInfo;
      }     
function setContractClientInfo($contractClientInfo) {
     $this->contractClientInfo = $contractClientInfo;
     }     
function setHostType($hostType) {
     $this->hostType = $hostType;
     }    
function setProductList($productList) {
     $this->productList = $productList;
     }     
function setTransfer($transfer) {
    $this->transfer = $transfer;
    }    
function setProRateDues($proRateDues) {
    $this->proRateDues = $proRateDues;
    }    
function setProcessFeeMonthly($processFeeMonthly) {
   $this->processFeeMonthly = $processFeeMonthly;
   }   
function setDownPayment($downPayment) {
   $this->downPayment = $downPayment;
   }   
function setTotalFeesEft($totalFeesEft) {
   $this->totalFeesEft = $totalFeesEft;
   }   
function setMonthlyDues($monthlyDues) {
   $this->monthlyDues = $monthlyDues;
   }    
function setMonthlyServicesTotal($monthlyServicesTotal) {
   $this->monthlyServicesTotal = $monthlyServicesTotal;
   }   
function setTermType($termType) {
    $this->termType = $termType;
    }    
function setInitiationFee($initiationFee) {
    $this->initiationFee = $initiationFee;
    }    
function setPifServicesTotal($pifServicesTotal) {
    $this->pifServicesTotal = $pifServicesTotal;
    }    
function setProcessFeePif($processFeePif) {
    $this->processFeePif = $processFeePif;
    }    
function setPifGrandTotal($pifGrandTotal) {
    $this->pifGrandTotal = $pifGrandTotal;
    }    
function setServicesTotal($servicesTotal) {
   $this->servicesTotal = $servicesTotal;
   }   
function setRenewalRateTotal($renewalRateTotal) {
    $this->renewalRateTotal = $renewalRateTotal;
    }    
function setMinTotalDue($minTotalDue) {
    $this->minTotalDue = $minTotalDue;
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
function setClubLocation($clubLocation) {
   $this->clubLocation = $clubLocation;
   }
function setLocationId($locationId) {
   $this->locationId= $locationId;
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
function setDatePicker($datepicker) {
   $this->datePicker = $datepicker;
   } 
function setSig($sig) {
   $this->signature = $sig;
   } 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//these methods are for parsing prior to SQL inserts
//-----------------------------------------------------------------------------------------------------
function paymentHistory() {       
     
   require('../helper_apps/paymentHistory.php');  


}
//-----------------------------------------------------------------------------------------------------
/*function saveFailedSubscriptions() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO failed_subscriptions VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issdis', $contractKey, $subscriptionType, $billingType, $billingAmount, $reasonCode, $frequency); 

$contractKey = $this->contractKey;
$subscriptionType = $this->subscriptionType;
$billingType = $this->monthlyBilling;
$billingAmount = $this->csBillingAmount;
$reasonCode = $this->psReasonCode;
$frequency = $this->frequency;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
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
$billingType = $this->monthlyBilling;
$subscriptionType = $this->subscriptionType;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}*/
//-----------------------------------------------------------------------------------------------------
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
//-----------------------------------------------------------------------------------------------------
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
function parseComissionId() {

$dbMain = $this->dbconnect();

$this->comissionId = $_SESSION['user_id'];

   $stmt = $dbMain ->prepare("SELECT user_name FROM admin_passwords WHERE user_id ='$this->comissionId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->commissionCredit);
   $stmt->fetch();
   
   
   //$this->comissionId = $user_id;
   
   if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }   
   $stmt->close();  

         $result2 = $dbMain ->prepare("SELECT type_key, id_card  FROM basic_compensation WHERE  user_id = '$this->comissionId'"); 
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
                                                                   
                                                                       if($club_id == $this->locationId) {
                                                                           $this->typeKey = $type_key;
                                                                           $this->idCard = $id_card;                                                                           
                                                                         }
                                                                         
                                                                     }        
                                                     }

                                             }
}
//-----------------------------------------------------------------------------------------
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

   $stmt = $dbMain ->prepare("SELECT contract_terms, contract_quit, liability_terms FROM contract_defaults WHERE contract_key = '1'");
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
//-------------------------------------------------------------------------------------------------
function parseContractClientInfo() {

$contract_client_array =  explode("|", $this->contractClientInfo);
$this->clientFirst = $contract_client_array[0];
$this->clientMiddle = $contract_client_array[1];
$this->clientLast = $contract_client_array[2];
$this->clientStreet = $contract_client_array[3];
$this->clientCity = $contract_client_array[4];
$this->clientState = $contract_client_array[5];
$this->clientZip = $contract_client_array[6];
$this->clientHomePhone = $contract_client_array[7];
$this->clientCellPhone = $contract_client_array[8];
$this->clientEmail = $contract_client_array[9];
//parse the date of birth
$dob = $contract_client_array[10];
$this->clientDob = date("Y-m-d", strtotime($dob));
$this->clientLicense =  $contract_client_array[11];

}
//-----------------------------------------------------------------------------------------------
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

//--------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------
function insertEftEnhanceCycle()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_enhance_eft VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issd', $contractKey, $eftCycle, $eftCycleDate, $this->enhanceFee); 

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
/*if($this->monthlyBilling == 'CR' || $this->monthlyBilling == 'BA') {

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
  if($this->monthlyBilling == 'CR') {
    
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
  if($this->monthlyBilling == 'BA') {

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
	   //   $secVal = 'PPD';
	   //  }else{
	   //   $secVal = 'PPD';
	  //   }
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
Reason Code: $this->psReasonCode";
*/  
  
  
  
}
//---------------------------------------------------------------------------------------------
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
//---------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
function insertGuaranteeCycle() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_guarantee_eft VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issd', $contractKey, $eftCycle, $eftCycleDate, $this->gauranteeFee); 

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
/*if($this->monthlyBilling == 'CR' || $this->monthlyBilling == 'BA') {

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
  if($this->monthlyBilling == 'CR') {
    
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
  if($this->monthlyBilling == 'BA') {

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
	   //   $secVal = 'PPD';
	  //   }else{
	 //     $secVal = 'PPD';
	 //    }
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
Reason Code: $this->psReasonCode";
}*/




}
//--------------------------------------------------------------------------------------------
function insertMaintnenceCycle() {

//break up the guarentee cycle date
$day = date("d");
$month = date("m");
$year = date("Y");

    switch ($this->mCycle) {
        case "A":
            $divisor = 1;
            $frequency = 'annually';
            $this->maintnenceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1)); 
          
        break;
        case "B":
            $divisor = 2;
            $frequency = 'semi-annually';
            $this->maintnenceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month+6, $day, $year));                                 
                   
        break;
        case "Q":
            $divisor = 4;
            $frequency = 'quarterly';
            $this->maintnenceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month+3, $day, $year));                
               
        break;
        case "M":
            $divisor = 12;
            $frequency = 'monthly';
            $this->maintnenceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month+1, $day, $year));                 
            
        break;
       }
$mFee = sprintf("%.2f", $this->maintnenceFee / $divisor);
$this->frequency = $frequency; 
     
$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_maintnence_eft VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issd', $this->contractKey, $this->mCycle, $this->maintnenceCycleDate, $this->maintnenceFee); 
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 



}
//--------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------
function loadMaintnenceCycles() {
       
         $dbMain = $this->dbconnect();
         $stmt = $dbMain ->prepare("SELECT m_cycle, term_switch FROM member_maintnence_cycle WHERE cycle_num = '1'");
         $stmt->execute();      
         $stmt->store_result();      
         $stmt->bind_result($this->mCycle, $this->mTermSwitch);   
         $stmt->fetch();   
         $stmt->close();
}
//---------------------------------------------------------------------------------------------
function loadEnhanceGuaranteeFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT enhance_fee, rate_fee, maintnence_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($enhance_fee, $rate_fee, $maintnence_fee);   
$stmt->fetch();   
$stmt->close();

$this->enhanceFee = $enhance_fee;
$this->gauranteeFee = $rate_fee;
$this->maintnenceFee = $maintnence_fee;

//sets up the enhance fees
if($this->enhanceFee != "0.00")  {
   $this->loadEnhanceCycles();
          //check to see if the service is a membership
        if(preg_match("/membership/i", $this->serviceName)) {        
               //now check to see if this is a pif
             if($this->serviceTerm == "Y") {             
                 $this->insertPifEnhanceCycle();
                }elseif(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->serviceName)) && ($this->serviceQuantity >= 12)) {      
                
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
        if(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->serviceName)) && ($this->serviceQuantity >= 12)) {                    
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
if($this->maintnenceFee != "0.00")  {
        if(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->serviceName)) && ($this->serviceQuantity >= 12)) {                    
           $this->loadMaintnenceCycles();
           
           switch ($this->mTermSwitch) {
                   case "T":
                   if($this->termType != "O") {
                      $this->insertMaintnenceCycle();
                      }
                   break;
                   case "O":
                   if($this->termType != "T") {
                      $this->insertMaintnenceCycle();
                      }              
                   break;
                   case "B":
                   if(($this->termType == "T") || ($this->termType == "O")) {
                      $this->insertMaintnenceCycle();
                      }    
                   break;
                }
                   
           
          }   
  }
}
//---------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT cycle_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_day);   
$stmt->fetch();   

$todayDay = date("d");
//check if iis past or present then generate the billing date
if($cycle_day > $todayDay)  {
  $billingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , $cycle_day, date("Y")));
  }
if($cycle_day <= $todayDay)  {
  $billingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $cycle_day, date("Y")));
  }

return "$billingDate";

$stmt->close();
}

//-------------------------------------------------------------------------------------------
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
//-------------------------------------------------------------------------------------------
function parseStartEndDates() {
    
$month = date('m',strtotime($this->datePicker));
$day = date('d',strtotime($this->datePicker));
$year = date('Y',strtotime($this->datePicker));

$this->startDate = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month  , $day, $year));

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month  , $day+$this->serviceQuantity, $year));
        break;
        case "W":
        $days = $this->serviceQuantity * 7;
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month  , $day+$days, $year));
        break;
        case "M":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month+$this->serviceQuantity, $day, $year));
        break;
        case "Y":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month, $day, $year+$this->serviceQuantity));
        break;  
      }

}
//=====================================================
function createContractKey() {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO contract_keys VALUES (?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $contract_marker);
$contract_marker = null;
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$this->contractKey = $stmt->insert_id; 
$stmt->close();  

}
//======================================================
function deleteContractKey()  {

$dbMain = $this->dbconnect();

$sql = "DELETE FROM contract_keys WHERE contract_key = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $contractKey);
			$contractKey = $this->contractKey; 			
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}
		
		unset($_SESSION['salesSql']);
		unset($_SESSION['contract_key']);
		unset($_SESSION['lib_address_array']); 
		unset($_SESSION['lib_emg_contact_array']); 
		
	    $delete_key = 1;
		return $delete_key;
				
}
//======================================================
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
//=====================================================
function saveBankingInfo() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO banking_info VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isssssss', $contractKey, $bankName, $accountType, $accountFirst, $accountMiddle, $accountLast, $accountNumber, $abaNumber); 

$contractKey = $this->contractKey; 
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
//=====================================================
function saveCreditInfo() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO credit_info VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isssssssssss', $contractKey, $cardFirst, $cardMiddle, $cardLast, $cardStreet, $cardCity, $cardState, $cardZip, $cardType, $cardNumber, $cardCvv, $expDate); 

$contractKey = $this->contractKey; 

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
//====================================================
function saveGroupInfo() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_groups VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isisss', $contractKey, $groupType, $groupNumber, $groupName, $groupAddress, $groupPhone);

$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;

//parse the group type info
$group_info_array = explode("|", $this->groupTypeInfo);
$groupName = $group_info_array[0];
$groupAddress = $group_info_array[1];
$groupPhone = $group_info_array[2];

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//==============================================
function saveContractInfo()  {
    
$this->saveSignature();

$dbMain = $this->dbconnect();
$sql = "INSERT INTO contract_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssisssisssssssisssssis', $contractId, $userId, $contractKey, $contractType, $transfer, $signDate, $clubId, $contractLocation, $contractDate, $termsConditions, $contractQuit, $hostType, $clientFirst, $clientMiddle, $clientLast, $clientStreet, $clientCity, $clientState, $clientZip, $clientHomePhone, $clientCellPhone, $clientEmail, $clientDob, $clientLicense, $gracePeriod, $contractHtml);


$contractId = $this->contractId;

//get the user id for the commission credit
$this->parseComissionId();
//loads the liabilty terms
$this->loadContractTerms();
//parses the client info from the array
$this->parseContractClientInfo();
//gets the club location where contract was signed
$this->loadClubLocation();

//convert the contract quit grace period into seconds
$contractQuitSeconds = $this->contractQuit * 86400;
$currentTimeSecs = time();
$this->contractQuit = $currentTimeSecs + $contractQuitSeconds;

//set the signup date to use for service ids
$this->signupDate = date("Y-m-d H:m:s"); 

$userId = $this->comissionId;
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
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================
function insertMember() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissssssissssssssss', $generalId, $contractKey, $memberId, $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primePhone, $cellPhone, $email, $dob, $license, $emgName, $emgRelation, $emgPhone, $liabilityTerms, $memberPhoto);

$member_content = explode("|", $this->memberRow); 
$emergency_content = explode("|", $this->emgRow);

$generalId = $this->generalId;
$contractKey = $this->contractKey;
$memberId = "";
$firstName = $member_content[0];
$middleName = $member_content[1];
$lastName = $member_content[2];
$street = $member_content[3];
$city = $member_content[4];
$state = $member_content[5];
$zip = $member_content[6];
$primePhone = $member_content[7];
$cellPhone = $member_content[8];
$email = $member_content[9];
$dob_orig = $member_content[10];
$dob = date("Y-m-d", strtotime($dob_orig));
$license = $member_content[11];
$emgName = $emergency_content[0];
$emgRelation = $emergency_content[1];
$emgPhone = $emergency_content[2];
$liabilityTerms = $this->liabilityTerms;
$memberPhoto = "";

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================
function saveMemberInfo() {

$groupCount = $this->groupNumber;
$memberInfoArray =  explode("#",  $this->memberInfoArray);
$emgContactArray =  explode("#",  $this->emgContactArray);

for($i=0; $i < $groupCount; $i++)  {
     $this->memberRow = $memberInfoArray[$i];
     $this->emgRow = $emgContactArray[$i];
     $this->insertMember();
    }

}
//===================================================
function insertMonthly() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissiddddsddddssssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $numberMonths, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $termType, $initiationFee, $downPayment, $monthlyDues, $proRateDues, $proDateStart, $proDateEnd, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute();


$productFieldArray =  explode("|", $this->productRow);
$this->serviceTerm = "M";
$this->serviceType = "E";


$serviceId = $this->serviceId;
$trans = $this->transfer;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey = trim($productFieldArray[5]);
$clubId = $this->clubId = $this->loadClubId($serviceKey);
$serviceName = $this->serviceName = $productFieldArray[0];
$numberMonths = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[3]);
$unitPrice = $this->unitPrice = $productFieldArray[2];
$unitRenewRate = $productFieldArray[1];
$groupPrice = $this->groupPrice = $productFieldArray[4];
$groupRenewRate = sprintf("%.2f", $groupNumber * $unitRenewRate);
$termType = $this->termType;
$initiationFee = $this->initiationFee;  //set as overall for multiple mm services
$downPayment = $this->downPayment;  //set as overall for multiple mm services
$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);
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
$proRateDues = sprintf("%.2f", $pro_rate_amount);
$proDateStart = date("Y-m-d"); 
$proDateEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("t"), date("Y")));
$startDate= date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
//---------------------------------------------------
//add to end date
$termMonths = $numberMonths + 1;
//---------------------------------------------------
$endDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+$termMonths  ,1, date("Y")));

//sales person
$userId = $this->comissionId;

$signup = $this->signupDate;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$this->statusId = $stmt->insert_id;
$stmt->close(); 
  
$this->saveAccountStatus();
$this->insertSale();  
  
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
<br><br><br>";
 */
}
//===================================================
function insertClassCount() {

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
//-----------------------------------------------------------------------------------------
function insertPaidFull() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $trans);
$stmt->execute();


$serviceId = $this->serviceId;
$productFieldArray =  explode("|", $this->productRow);
$this->serviceType = "P";
$trans = $this->transfer;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey = trim($productFieldArray[5]);
$clubId = $this->clubId = $this->loadClubId($serviceKey);
$serviceName = $this->serviceName = $productFieldArray[0];
$serviceQuantity = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[3]);
$serviceTerm = $this->serviceTerm = preg_replace("/[^A-Z]/", "", $productFieldArray[3]);
$unitPrice = $this->unitPrice = $productFieldArray[2];
//--------------------------------------------------------------
//for renew rate if it is set to NA
if($productFieldArray[1] == 'NA') {
  $unitRenewRate = 0;
  }else{
  $unitRenewRate = $productFieldArray[1];
  }
//-------------------------------------------------------------
$groupPrice = $this->groupPrice = $productFieldArray[4];
$groupRenewRate = sprintf("%.2f", $groupNumber * $unitRenewRate);
//-------------------------------------------------
//parse the end and start dates for pif
$this->parseStartEndDates();
//-----------------------------------------------------
$startDate = $this->startDate;
$endDate = $this->endDate;

//sales person
$userId = $this->comissionId;

$signup = $this->signupDate;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$this->statusId = $stmt->insert_id;
$stmt->close(); 

//if this is a class, insert into member class count table
if($this->serviceTerm == "C") {
   $this->insertClassCount();
  }


$this->saveAccountStatus();
$this->insertSale(); 

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
//===================================================
function saveServices()  {

$productListArray = explode("@", $this->productList);
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
//==================================================
function saveInitialPayments() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iddddddddddsssdsiss', $contractKey, $processFeeMonthly, $processFeePif, $enhanceFee, $newMemberFee, $todaysPayment, $cashPayment, $checkPayment, $achPayment, $creditPayment, $balanceDue, $dueDate, $processDate, $dueStatus, $minTotalDue, $signDate, $clubId, $category, $internet);

$contractKey = $this->contractKey;
$processFeeMonthly = $this->processFeeMonthly;
$processFeePif = $this->processFeePif;
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
$balanceDue = trim($balanceDue);
if($balanceDue == "0.00" OR $balanceDue == "undefined"  OR $balanceDue == "")  {
   $dueStatus = "P";
   $historyDueStatus = 'PF';
   }else{
   $dueStatus = "G";
   $historyDueStatus = 'BD';
   }
//---------------------------------------------------
$minTotalDue = $this->minTotalDue;
$signDate = $this->signupDate;
$clubId = $this->locationId;
$category = 'N';
$internet = 'N';

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

//here we set the payment history
//---------------------------------------------------------------------------------
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
//=================================================
function saveMonthlyBilling() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_payments VALUES (?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issds', $contractKey, $monthlyBillingType, $cycleDate, $billingAmount, $billingStatus);

$contractKey = $this->contractKey;
$monthlyBillingType = $this->monthlyBilling;
$cycleDate = $this->loadCycleDate();
$billingAmount = $this->monthlyDues;
$billingStatus = "G";

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

/*if($monthlyBillingType == 'CR' || $monthlyBillingType == 'BA') {

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
$this->monthlyDues = number_format($this->monthlyDues, 2, '.', '');

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
  $billingAmount = $this->monthlyDues;
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
Billing Amount: $billingAmount
<br>
Billing Date: $billingDate";

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
";
*/

}
//================================================
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
$memberId = 0;
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



CREATE TABLE  account_notes  (    
contract_key  INT(20) NOT NULL,
user_id INT(10) NOT NULL,
note_date DATETIME NOT NULL,
am_pm CHAR(2) NOT NULL,
note_topic CHAR(50) NOT NULL,
note_message TEXT NOT NULL
*/
}
//================================================
function insertSale()  {

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
$unitPrice = $this->loadUnitPrice();  //in case of price overide this checks the original price
$groupPrice = $unitPrice * $groupNumber;  //plays off the original cost
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
$salesNew = 'Y';

//this checks to see if the client is eligable for an enhancement fee then saves the info. this also gets the guarantee fee if it exists and saves
$this->loadEnhanceGuaranteeFees();

  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
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
//=====================================================
//contract info
function getContractKey() {
       return($this->contractKey);       
       }       
function getContractType() {
       return($this->contractType);       
       }
function getGroupType() {
       return($this->groupType);  
       }       
function getGroupNumber() {
      return($this->groupNumber);  
      }      
function getGroupTypeInfo() {
      return($this->groupTypeInfo);  
      }      
function getContractClientInfo() {
     return($this->contractClientInfo);  
     }     
function getHostType() {
     return($this->hostType);  
     }   
function getProductList() {
     return($this->productList);  
     }     
function getTransfer() {
    return($this->transfer);  
    }    
function getProRateDues() {
    return($this->proRateDues);  
    }    
function getProcessFeeMonthly() {
   return($this->processFeeMonthly);  
   }  
function getDownPayment() {
   return($this->downPayment);  
   }   
function getTotalFeesEft() {
   return($this->totalFeesEft);  
   }   
function getMonthlyDues() {
    return($this->monthlyDues);  
    }    
function getMonthlyServicesTotal() {
   return($this->monthlyServicesTotal);  
   }   
function getTermType() {
   return($this->termType);  
   }    
function getInitiationFee() {
   return($this->initiationFee);  
   }    
function getPifServicesTotal() {
   return($this->pifServicesTotal);  
   }   
function getProcessFeePif() {
    return($this->processFeePif);  
    }    
function getPifGrandTotal() {
    return($this->pifGrandTotal);  
    }    
function getServicesTotal() {
   return($this->servicesTotal);  
   }   
function getRenewalRateTotal() {
    return($this->renewalRateTotal);  
    }   
function getMinTotalDue() {
    return($this->minTotalDue);  
    }    
function getTodaysPayment() {
    return($this->todaysPayment);  
    }    
function getBalanceDue() {
    return($this->balanceDue);  
    }    
function getDueDate() {
    return($this->dueDate);  
    }
function getClubLocation() {
   return($this->clubLocation);
   }
function getLocationId() {
   return($this->locationId);
   }    
    

//get cc info
function getCardType() {
       return($this->cardType);
       }
function getCardName() {
       return($this->cardName);
       }
function getCardNumber() {
       return($this->cardNumber);
       }
function getCardCvv() {
       return($this->cardCvv);
       }
function getCardExpDate() {
       return($this->cardExpDate);
       }

//get banking info
function getBankName() {
      return($this->bankName);
      }
function getAccountType() {
     return($this->accountType);
     }
function getAccountName() {
     return($this->accountName);
     }
function getAccountNumber() {
    return($this->accountNumber);
    }
function getAbaNumber() {
    return($this->abaNumber);
    }


//get initial payment types
function getCashPayment() {
       return($this->cashPayment);
       }
function getCreditPayment() {
       return($this->creditPayment);
       }
function getAchPayment() {
       return($this->achPayment);
       }
function getCheckPayment() {
       return($this->checkPayment);
       }

//contact and emg contact arrays
function getMemberInfoArray() {
        return($this->memberInfoArray);
        }
function getEmgContactArray() {
        return($this->emgContactArray);
        }

//monthly billing type
function getMonthlyBilling() {
         return($this->monthlyBilling);
         }

//get the overide pin
function getOveridePin() {
       return($this->overidePin);
       }

//notes in this cae a list of notes
function getNoteList() {
        return($this->noteList);
        }

//this is the monthly billing type for contracts
function getMonthlyBillingType() {
       return($this->monthlyBillingType);
       }
function getDatePicker() {
       return($this->datePicker);
       } 
function getSig() {
       return($this->signature);
       } 


}

?>