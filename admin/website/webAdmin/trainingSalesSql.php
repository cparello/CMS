<?php
session_start();

//require"../../cybersource/gatewayAuth.php";
//require"../../cybersource/cybersourceSoapClient.php";
//require"../../cybersource/parseGatewayFields.php";

//date_default_timezone_set('America/Los_Angeles');
class  salesSql{


function setLength($length) {
    $this->numberOfNewMembers = $length;
    }
function setHostBool($hostBool) {
    $this->hostBool = $hostBool;
    }
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

function setMonthlyBillingType($monthlyBillingType) {
         $this->monthlyBillingType = $monthlyBillingType;
         }         
         
//overide pin set to either Yif entered or N if not
function setOveridePin($overidePin) {
       $this->overidePin = $overidePin;
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
   function setNameAddArray($name_add_array){
   $this->nameAddArray = $name_add_array;
   } 
   function setEmergConArray($emg_contact_array) {
   $this->emgContactArray = $emg_contact_array;
   } 
   function setHostBillingInfoArray($host_billing_info_array) {
   $this->hostBillingInfoArray = $host_billing_info_array;
   } 
   function  setSalesArray($sale_array){
   $this->saleArray = $sale_array;
   } 
   function setMonthlyBilling($monthlyBillingSelected){ 
   $this->monthlyBillingSelected = $monthlyBillingSelected;
   } 
   
function setSetAdditionalService($totalServiceArray){ 
   $this->totalServiceArray = $totalServiceArray;
   } 
function  setGearArray($totalGearArray){ 
   $this->totalGearArray = $totalGearArray;
   } 
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//these methods are for parsing prior to SQL inserts
//-----------------------------------------------------------------------------------------------------
function paymentHistory() {       
     
   require('../../helper_apps/paymentHistory.php');  


}
//-----------------------------------------------------------------------------------------------------
function parseAccountHolderName() {

if($this->nameSwitch == null) {
  $this->accountFirst = "";
  $this->accountMiddle = "";
  $this->accountLast = "";
  
  }else{
  
       $account_name_array = explode(' ', $this->nameSwitch);
       $array_count = count($account_name_array);
 //echo"etetetett    $array_count    rtrtyrtyrt ";
 // exit;
  
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
    
  $card_array =  explode('-', $this->cardExpDate);
  $card_year = "$card_array[0]"; 
  $card_month = $card_array[1]; 
  //echo "$card_month";
   // exit;
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



//-------------------------------------------------------------------------------------------
function loadUnitPrice() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_cost, service_info.service_key, service_term FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key WHERE service_type = '$this->serviceNamePurchased' AND service_quantity = '$this->serviceQuantityPurchased'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->serviceCost, $this->serviceKey, $this->serviceTerm);   
$stmt->fetch();   
$stmt->close();
}
//-------------------------------------------------------------------------------------------
function parseStartEndDates() {
    
$month = date('m');
$day = date('d');
$year = date('Y');

$this->startDate = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month  , $day, $year));

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month  , $day+$this->serviceQuantityPurchased, $year));
        break;
        case "W":
        $days = $this->serviceQuantityPurchased * 7;
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month  , $day+$days, $year));
        break;
        case "M":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month+$this->serviceQuantityPurchased, $day, $year));
        break;
        case "Y":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23,59,59, $month, $day, $year+$this->serviceQuantityPurchased));
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
function saveAccountStatus() {

$dbMain = $this->dbconnect();

$statusId = $this->statusId;
$contractKey = $this->contractKey; 
$serviceKey = $this->serviceKey;
$accountStatus = $this->accountStatus;
$statusDate = $this->signupDate;
$clubId = $this->clubId;
$servicePrice = $this->serviceCost;
//echo"$statusId, $contractKey, $serviceKey , $accountStatus, $statusDate, $clubId, $servicePrice";
//exit;
$sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissid', $statusId, $contractKey, $serviceKey , $accountStatus, $statusDate, $clubId, $servicePrice);
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//=====================================================
function saveBankingInfo() {
    
     
if(!isset($_SESSION['userContractKey'])){
    
        $this->nameSwitch = $this->accountName;
        
        $this->parseAccountHolderName();
        
        $dbMain = $this->dbconnect();
        
        $sql = "INSERT INTO banking_info VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('isssssss', $this->contractKey, $this->bankName, $this->accountType, $this->accountFirst, $this->accountMiddle, $this->accountLast, $this->accountNumber, $this->abaNumber); 
        if(!$stmt->execute())  {
        	printf("Error: BANK %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
}
}
//=====================================================
function saveCreditInfo() {
     
if(!isset($_SESSION['userContractKey'])){
        $this->nameSwitch = $this->cardName;
        
        $this->parseAccountHolderName();
        
        $expDate = $this->formatCreditDate();
        
        $dbMain = $this->dbconnect();
        //echo "$this->contractKey, $this->accountFirst, $this->accountMiddle, $this->accountLast, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $this->cardType, $this->cardNumber, $this->cardCvv, $expDate";
        //exit;
        $sql = "INSERT INTO credit_info VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('isssssssssss', $this->contractKey, $this->accountFirst, $this->accountMiddle, $this->accountLast, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $this->cardType, $this->cardNumber, $this->cardCvv, $expDate); 
        if(!$stmt->execute())  {
        	printf("Error: credit ttt%s.\n", $stmt->error);
           }		
        $stmt->close(); 
}
}
//====================================================
function saveGroupInfo() {
 
 if(!isset($_SESSION['userContractKey'])){
        $contractKey = $this->contractKey;
        $groupType = 'S';
        $groupNumber = 1;
        $groupName = 'NA';
        $groupAddress = 'NA';
        $groupPhone = 'NA';
        
        $dbMain = $this->dbconnect();
        $sql = "INSERT INTO member_groups VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('isisss', $contractKey, $groupType, $groupNumber, $groupName, $groupAddress, $groupPhone);
         if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
}
}
//==============================================
function saveContractInfo()  {
    
$this->saveSignature();

$dbMain = $this->dbconnect();

$contractId = $this->contractId;
//convert the contract quit grace period into seconds
$contractQuitSeconds = $this->contractQuit * 86400;
$currentTimeSecs = time();
$this->contractQuit = $currentTimeSecs + $contractQuitSeconds;

//set the signup date to use for service ids
$this->signupDate = date("Y-m-d H:m:s"); 

// $this->payQuit, $this->hostType, $this->firstName, $this->middleName, $this->lastName, $this->street, $this->city, $this->state, $this->zip, $this->primaryPhone, $this->cellPhone, $this->email, $this->dob, $this->licenseNumber, $this->gracePeriod
if(!isset($_SESSION['userContractKey'])){
       $contractQuit = $this->contractQuit;
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
    }else{
        $contractQuit = $this->payQuit;
        $clientFirst = $this->firstName;
        $clientMiddle = $this->middleName;
        $clientLast = $this->lastName;
        $clientStreet = $this->street;
        $clientCity = $this->city;
        $clientState = $this->state;
        $clientZip = $this->zip;
        $clientHomePhone = $this->primaryPhone;
        $clientCellPhone = $this->cellPhone;
        $clientEmail = $this->email;
        $clientDob = $this->dob;
        $clientLicense = $this->licenseNumber;
    }

$userId = $this->userID;
$contractKey = $this->contractKey;
$contractType = 'U';
$transfer = $this->transfer;
$signDate = $this->signupDate; 
$clubId = $this->clubId;
$contractLocation = 'Website';
$contractDate = date("Y-m-d");  //this might be different from signup date make the same for now
$termsConditions = $this->terms;

$hostType = $this->hostType;

$gracePeriod = 30;//$this->gracePeriod; 
$contractHtml = "";

$sql = "INSERT INTO contract_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssisssisssssssisssssis', $contractId, $userId, $contractKey, $contractType, $transfer, $signDate, $clubId, $contractLocation, $contractDate, $termsConditions, $contractQuit, $hostType, $clientFirst, $clientMiddle, $clientLast, $clientStreet, $clientCity, $clientState, $clientZip, $clientHomePhone, $clientCellPhone, $clientEmail, $clientDob, $clientLicense, $gracePeriod, $contractHtml);
if(!$stmt->execute())  {
	printf("Error: CONTRACT %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================
function insertMember() {
 
if(!isset($_SESSION['userContractKey'])){
        $dbMain = $this->dbconnect();
        
        $generalId = $this->generalId;
        $contractKey = $this->contractKey;
        $memberId = "";
        $firstName = $this->memberFirst;
        $middleName = $this->memberMiddle;
        $lastName = $this->memberLast;
        $street = $this->memberStreet;
        $city = $this->memberCity;
        $state = $this->memberState;
        $zip = $this->memberZip;
        $primePhone = $this->memberPhone;
        $cellPhone = $this->memberCell;
        $email = $this->memberEmail;
        $dob_orig = $this->memberDob;
        $dob = date("Y-m-d", strtotime($dob_orig));
        $license = $this->memberLiscense;
        $emgName = $this->memberEmergName;
        $emgRelation = $this->memberEmergRelation;
        $emgPhone = $this->memberEmergPhone;
        $liabilityTerms = $this->terms;
        $memberPhoto = "";
        
        $sql = "INSERT INTO member_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiissssssissssssssss', $generalId, $contractKey, $memberId, $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primePhone, $cellPhone, $email, $dob, $license, $emgName, $emgRelation, $emgPhone, $liabilityTerms, $memberPhoto);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        
        $stmt->close(); 
 }        
}
//===================================================
function insertClassCount() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_class_count VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isii', $contractKey, $groupType, $serviceKey, $classCount);
$stmt->execute();

$contractKey = $this->contractKey;
$groupType = 'S';
$serviceKey = $this->serviceKey;
$classCount = $this->serviceQuantityPurchased * 1;

if(!$stmt->execute())  {
	printf("Error: CLASS COUNT %s.\n", $stmt->error);
   }		


$stmt->close();

}
//-----------------------------------------------------------------------------------------
function insertPaidFull() {


$dbMain = $this->dbconnect();

$serviceId = $this->serviceId;

$this->serviceType = "P";
$trans = $this->transfer;
$contractKey = $this->contractKey;
$groupType = 'S';
$groupNumber = 1;
$serviceKey = $this->serviceKey;
$clubId = $this->clubId;
$serviceName = $this->serviceNamePurchased;
$serviceQuantity = $this->serviceQuantityPurchased;
$serviceTerm = $this->serviceTerm;
$unitPrice = $this->serviceCost;
//--------------------------------------------------------------
//for renew rate if it is set to NA
$unitRenewRate = $this->serviceCost;
//-------------------------------------------------------------
$groupPrice = $this->serviceCost;
$groupRenewRate = sprintf("%.2f", $groupNumber * $unitRenewRate);
//-------------------------------------------------

//-----------------------------------------------------
$startDate = $this->startDate;
$endDate = $this->endDate;

//sales person
$userId = $this->userID;

$signup = $this->signupDate;

//echo "$serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $trans";
//exit;
$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $trans);
//$stmt->execute();
if(!$stmt->execute())  {
	printf("Error: PIF %s.\n", $stmt->error);
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
//==================================================
function saveInitialPayments() {

$dbMain = $this->dbconnect();

$contractKey = $this->contractKey;
$processFeeMonthly = 0;
$processFeePif = $this->upgradeFeeSingleTwo;
$enhanceFee = 0;
$newMemberFee = 0.00;
$todaysPayment = $this->todaysPayment;
$cashPayment = 0.00;
$checkPayment = 0.00;
$achPayment = $this->achPayment;
$creditPayment = $this->creditPayment;
$balanceDue = 0.00;
//-------------------------------------------------
//------------------------------------------------
$dueDate = date("Y-m-d");
$processDate = date("Y-m-d");
//----------------------------------------------------
//check to see if there is a balance due. if not mark status as paid
if($balanceDue == "0.00")  {
   $dueStatus = "P";
   $historyDueStatus = 'PF';
   }else{
   $dueStatus = "G";
   $historyDueStatus = 'BD';
   }
//---------------------------------------------------
$minTotalDue = $this->todaysPayment;
$signDate = $this->signupDate;
$clubId = $this->clubId;
$category = 'U';
$internet = 'Y';

$sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iddddddddddsssdsiss', $contractKey, $processFeeMonthly, $processFeePif, $enhanceFee, $newMemberFee, $todaysPayment, $cashPayment, $checkPayment, $achPayment, $creditPayment, $balanceDue, $dueDate, $processDate, $dueStatus, $minTotalDue, $signDate, $clubId, $category, $internet);
if(!$stmt->execute())  {
	printf("Error: INITIAL PAYMENTS %s.\n", $stmt->error);
   }		

$stmt->close(); 

//here we set the payment history
$this->balanceDue = 0.00;
$this->dueDate = date("Y-m-d");
$this->paymentDescription = "Personal Training Upgrade";
$this->checkNumber = 0;
$this->bundled = 'N';
$this->rejectFeeCheck = 0;
$this->rejectFeeCredit = 0;
$this->rejectFeeAch = 0;
$this->lateFeeAll = 0;
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

//================================================
function insertSale()  {

$dbMain = $this->dbconnect();
$salesKey = "";
$locationId = 0;
$contractLocation = "Website";
$userId = $this->userID;
$groupType = 'S';
$groupNumber = 1;
$clubId = $this->clubId;
$serviceKey = $this->serviceKey;
$serviceName = $this->serviceNamePurchased;
$serviceQuantity = $this->serviceQuantityPurchased;
$serviceTerm = $this->serviceTerm;
if ($serviceTerm == 'M'){
    $serviceType = "E";
}else{
    $serviceType = "P";
}

$unitPrice = $this->serviceCost;  //in case of price overide this checks the original price
$groupPrice = $unitPrice * $groupNumber;  //plays off the original cost
$overidePin = "N";
$overideUnitPrice = $this->serviceCost;
$overideGroupPrice = $this->serviceCost;
$contractKey = $this->contractKey;

//sets the paid full membership to T
if(($this->serviceTerm == 'Y') || ($this->serviceTerm == 'W') || ($this->serviceTerm == 'D') || ($this->serviceTerm == 'PF'))  { 
   $termType = 'T';
   }else{
   $termType = $this->termType;
   }


$renewal = "N";
$upgrade = "Y";
$internet = "Y";
$saleDateTime = $this->signupDate;
$amPm = date("a");
$earlyRenewalBoon = 'N';
$salesNew = 'Y';

//echo "$salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew";
//exit;
//this checks to see if the client is eligable for an enhancement fee then saves the info. this also gets the guarantee fee if it exists and saves

$sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisisiiisissddsddissssssss', $salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew);
  if(!$stmt->execute())  {
	printf("Error: SALE %s.\n", $stmt->error);
   }		

$stmt->close(); 

//echo "jsdhjkdfh";
//exit;
//include"commissionRecords.php";

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
//=======================================================================================================
function loadTermsConditions()   {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT pt_liability_waiver FROM website_training_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pt_liability_waiver);
$stmt->fetch();
$stmt->close();

$this->terms = "$pt_liability_waiver";

}  
//=======================================================================================================
function loadInfo()  {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT club_id, contract_location, pay_quit, host_type, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number, grace_period, MAX(contract_date) FROM contract_info WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->clubId, $this->contractLocation, $this->payQuit, $this->hostType, $this->firstName, $this->middleName, $this->lastName, $this->street, $this->city, $this->state, $this->zip, $this->primaryPhone, $this->cellPhone, $this->email, $this->dob, $this->licenseNumber, $this->gracePeriod, $contract_date);
$stmt->fetch();
$stmt->close();

$this->contractClientInfo = "$this->firstName|$this->middleName|$this->lastName|$this->street|$this->city|$this->state|$this->zip|$this->primaryPhone|$this->cellPhone|$this->email|$this->dob";
}       
//================================================
function loadMain()  {

$dbMain = $this->dbconnect();

$this->loadTermsConditions();
$stmt = $dbMain ->prepare("SELECT upgrade_fee_single_two FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->upgradeFeeSingleTwo);   
$stmt->fetch();   
$stmt->close();

$this->userID = '99';
$this->pifQuantity = 0;
$this->eftQuantity = 0;

$saleArray = explode('@',$this->saleArray);
$memberArray = explode('#',$this->nameAddArray);
$emgContactArray = explode('#',$this->emgContactArray);

$totalServiceArray = explode('~',$this->totalServiceArray);
$totalGearArray = explode('~',$this->totalGearArray);
//echo"hostBOOL $this->hostBool";

//var_dump($saleArray);
//exit;
//var_dump($memberArray);
//var_dump($emgContactArray);
 $counter = 0; 
$monthProcFeeBool = 0;
$pifProcFeeBool = 0;
foreach($saleArray as $sale){
    $sArray = explode(',',$sale);
    $sNameBuff = explode('-',$sArray[0]);
    
    $this->serviceNamePurchased = trim($sNameBuff[0]);
    $this->clubName = trim($sNameBuff[1]);
    $this->numberOfServicePourchased = trim($sArray[1]);
    $this->servicePricePurchased = trim($sArray[2]);
    $this->serviceQuantityPurchased = trim($sArray[3]);
    
    $stmt = $dbMain ->prepare("SELECT club_id FROM club_info WHERE club_name = '$this->clubName'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->clubId);   
    $stmt->fetch();   
    $stmt->close();
    
    if ($this->clubId == 0){
        $this->clubId = 0;
    }
        $this->transfer = "N";
        $this->pifServicesTotal += $sArray[2];
        $this->pifQuantity += $this->numberOfServicePourchased;
    
    $this->transferArray .= "$this->transfer|";
    
    
    
    $this->todaysPayment = $this->servicePricePurchased;
    $this->todaysPaymentTotal += $this->todaysPayment;
    //echo"xx$this->serviceQuantityPurchased $this->serviceNamePurchased";
    //exit;
     if (is_numeric($this->serviceQuantityPurchased)) {
        //do nothing
        }else{
            $buff = explode(' ',$this->serviceQuantityPurchased);
            $this->serviceQuantityPurchased = $buff[0];
        }
  
    for($i=1;$i<=$this->numberOfServicePourchased;$i++){
        //var_dump($memberArray[$counter]);
       // echo " i $i # $this->numberOfServicePourchased name $this->serviceNamePurchased <br>";
      
        
        //echo"$this->hostBool";
        //exit;
       
            $this->termType = "T";
        
                        $memberInforArray = explode('|',$memberArray[$counter]);
                    if ($this->hostBool == 0){
                        
                        $this->contractClientInfo = $memberArray[$counter];
                        
                        $this->hostType = 'M';
                        $this->clientFirst = $memberInforArray[0];
                        $this->clientMiddle = $memberInforArray[1];
                        $this->clientLast = $memberInforArray[2];
                        $this->clientStreet = $memberInforArray[3];
                        $this->clientCity = $memberInforArray[4];
                        $this->clientState = $memberInforArray[5];
                        $this->clientZip = $memberInforArray[6];
                        $this->clientHomePhone = $memberInforArray[7];
                        $this->clientCellPhone = $memberInforArray[8];
                        $this->clientEmail = $memberInforArray[9];
                        $dob = $memberInforArray[10];
                        
                        // echo"$dob";
                        //exit;
                        $dobArray = explode('/',$dob);
                        $this->clientDob = date("Y-m-d", mktime(0,0,0,$dobArray[0],$dobArray[1],$dobArray[2]));
                        $this->clientLicense =  "none given"; //$memberInforArray[11];
                    }else{
                        $this->hostType = 'L';
                        $this->contractClientInfo = $this->hostBillingInfoArray;
                        $hostBillingInfoArray = explode('|',$this->hostBillingInfoArray);
                        
                        
                        
                        $this->clientFirst = $hostBillingInfoArray[0];
                        $this->clientMiddle = $hostBillingInfoArray[1];
                        $this->clientLast = $hostBillingInfoArray[2];
                        $this->clientStreet = $hostBillingInfoArray[3];
                        $this->clientCity = $hostBillingInfoArray[4];
                        $this->clientState = $hostBillingInfoArray[5];
                        $this->clientZip = $hostBillingInfoArray[6];
                        $this->clientHomePhone = $hostBillingInfoArray[7];
                        $this->clientCellPhone = $hostBillingInfoArray[8];
                        $this->clientEmail = $hostBillingInfoArray[9];
                        $dob = $hostBillingInfoArray[10];
                        $dobArray = explode('/',$dob);
                        $this->clientDob = date("Y-m-d", mktime(0,0,0,$dobArray[0],$dobArray[1],$dobArray[2]));
                        $this->clientLicense = "none given"; //$hostBillingInfoArray[11];
                        
                    }
                    
                    
                    $this->memberFirst = $memberInforArray[0];
                    $this->memberMiddle = $memberInforArray[1];
                    $this->memberLast = $memberInforArray[2];
                    $this->memberStreet = $memberInforArray[3];
                    $this->memberCity = $memberInforArray[4];
                    $this->memberState = $memberInforArray[5];
                    $this->memberZip = $memberInforArray[6];
                    $this->memberPhone = $memberInforArray[7];
                    $this->memberCell = $memberInforArray[8];
                    $this->memberEmail = $memberInforArray[9];
                    $this->memberDob = $memberInforArray[10];
                    $dobArray = explode('/',$this->memberDob);
                    $this->memberDob = date("Y-m-d", mktime(0,0,0,$dobArray[0],$dobArray[1],$dobArray[2]));
                    $this->memberLiscense =  "none given"; //$memberInforArray[11];
                    
                    
                    $emgContactInforArray = explode('|',$emgContactArray[$counter]);
                    $this->memberEmergName = $emgContactInforArray[0];
                    $this->memberEmergRelation = $emgContactInforArray[1];
                    $this->memberEmergPhone = $emgContactInforArray[2];
                        
                    
                    //parse the date of birth
                    
                    
                    
                    
                  
          
                   
                $this-> loadUnitPrice();
                        
                //echo"$this->serviceKey,   xx$this->serviceQuantityPurchased x x$this->serviceNamePurchased x";
                //exit;
                $this-> parseStartEndDates();
                   
                if(!isset($_SESSION['userContractKey'])){
                    $this-> createContractKey();
                }else{
                   $this->contractKey =  $_SESSION['userContractKey'];
                   $this->loadInfo();
                }
//echo "fubar";
//exit;     
                $this->contractKeyArray .="$this->contractKey|";
                
                $liabiltyBool = "No";
                $dateSigned = "";
                $sql = "INSERT INTO website_purchase_liability_signed VALUES (?, ?, ?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('iss', $this->contractKey, $liabiltyBool, $dateSigned);
                if(!$stmt->execute())  {
               	    printf("Error: %s.\n", $stmt->error);
                               }		
                $stmt->close(); 
                
                if(!isset($_SESSION['userContractKey'])){
                    $this-> saveBankingInfo();
                    $this-> saveCreditInfo();
                    $this-> saveGroupInfo();
                    $this->insertMember();
                }
                  
                $this-> saveContractInfo();
                $this-> saveInitialPayments();
                //this sets up monthly billing if a monthly service was selected
                //echo "$this->monthlyBillingSelected";
                //exit;
                // if(preg_match('/monthly/i',$this->serviceNamePurchased)) {
                //         $this->insertMonthly();
                //         $this-> saveMonthlyBilling();
                //    }else{
                         $this->insertPaidFull();
                //    }
               /* if($this->monthlyBillingSelected != "")  {
                    $this->insertMonthly();
                   $this-> saveMonthlyBilling();
                  }else{
                    $this->insertPaidFull();
                  }*/
                  $counter++;
                  //=========================================================================================

     
    foreach($totalServiceArray as $xtraService){
       
        $xtraArray = explode('|',$xtraService);
           $xtraServiceName = $xtraArray[0];
           $xtraServiceKey = $xtraArray[1];
           $xtraServiceQuantity = $xtraArray[2];
           $xtraServiceTermText = $xtraArray[3];
           $xtraServiceCost = $xtraArray[4];
           
           
           
           $xtraServiceNumberPurchased = $xtraArray[5];
           
           $test = $xtraServiceNumberPurchased - $counter;
            //echo "test $test  #pur $xtraServiceNumberPurchased  count $counter name $xtraServiceName";
           // exit;
           if ($test >= 0){
            $this->todaysPaymentTotal += $xtraServiceCost;
            
                $stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost WHERE service_key = '$xtraServiceKey' AND service_quantity = '$xtraServiceQuantity'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($service_cost);   
                $stmt->fetch();   
                $stmt->close();
                //echo "$xtraServiceKey $xtraServiceQuantity";
                //exit;       
                        $serviceTerm = substr($xtraServiceTermText,0,1);
                    
                    if (preg_match('/monthly/i',$xtraServiceName)){
                    
                 
                    if($this->monthlyBillingSelected == "CR" ){
                           $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM credit_info WHERE contract_key = '$this->contractKey'");
                        $stmt->execute();      
                        $stmt->store_result();      
                        $stmt->bind_result($count);   
                        $stmt->fetch();   
                        $stmt->close();
                        
                        if($count == 0){
                            
                                $sql = "INSERT INTO credit_info VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $dbMain->prepare($sql);
                                $stmt->bind_param('isssssssssss', $this->contractKey, $this->accountFirst, $this->accountMiddle, $this->accountLast, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $this->cardType, $this->cardNumber, $this->cardCvv, $expDate); 
                                if(!$stmt->execute())  {
                                	printf("Error: credit ttt%s.\n", $stmt->error);
                                   }		
                                $stmt->close(); 
                        }else{
                            
                             $sql = "UPDATE credit_info SET card_number = ?, card_cvv = ?, card_exp_date = ? WHERE contract_key = '$this->contractKey'";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('sss', $this->cardNumber, $this->cardCvv, $expDate);
                            if(!$stmt->execute())  {
                                            	printf("Error:updateCredit %s.\n", $stmt->error);
                                                  }	
                                
                            $stmt->close();
                            }
                    
                    }elseif($this->monthlyBillingSelected == "BA" ){
                                    $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM banking_info WHERE contract_key = '$this->contractKey'");
                                    $stmt->execute();      
                                    $stmt->store_result();      
                                    $stmt->bind_result($count);   
                                    $stmt->fetch();   
                                    $stmt->close();
                                    
                                    if($count == 0){
                            
                                            $sql = "INSERT INTO banking_info VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                            $stmt = $dbMain->prepare($sql);
                                            $stmt->bind_param('isssssss', $this->contractKey, $this->bankName, $this->accountType, $this->accountFirst,                                                 $this->accountMiddle, $this->accountLast, $this->accountNumber, $this->abaNumber); 
                                            if(!$stmt->execute())  {
                                            	printf("Error: BANK %s.\n", $stmt->error);
                                               }		
                                            
                                            $stmt->close(); 
                        }else{
                            
                             $sql = "UPDATE banking_info SET bank_name = ?, account_type = ?, account_number = ?, routing_number = ? WHERE contract_key = '$this->contractKey'";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('ssss', $this->bankName, $this->accountType, $this->accountNumber, $this->abaNumber);
                            if(!$stmt->execute())  {
                                            	printf("Error:updateBANK %s.\n", $stmt->error);
                                                  }	
                                
                            $stmt->close();
                            }
                    }
                    
                       
                    
                    
                        if (preg_match('/open/i',$xtraServiceName)){
                            $termType = "O";
                        }else{
                            $termType = "T"; 
                        }
                        //insert  monthlyserices,accoun status, month_payments, credit_info/bank,   sales,  pay_history as upgrade
                        
              
                        $monthlyDues = $service_cost/$xtraServiceQuantity;
                        $this->monthlyDues += $monthlyDues;
                        $this->monthlyDues = sprintf("%.2f", $this->monthlyDues);
                        
                        $termType = "T"; 
                        $groupType = "S";
                        $groupNumber = 1;
                        $startDate = date('Y-m-d H:i:s');
                        $transfer = "N";
                           // $serviceId = "";
                            //$groupType = "S";
                            //$groupNumber = 1;
                            $initiationFee = 0;
                            $downPayment = 0;
                            $proRateDues = 0;
                            $proDateStart = date('Y-m-d H:i:s');
                            $proDateEnd = date('Y-m-d H:i:s');
                            $startDate = date('Y-m-d H:i:s');
                            $endDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m')+$xtraServiceQuantity,date('d'),date('Y')));
                            $trans = 'Y';
                            $mid = "";
                            $sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iisiissiddddsddddssssiss', $mid, $this->contractKey, $groupType, $groupNumber, $xtraServiceKey, $this->clubId, $xtraServiceName, $xtraServiceQuantity, $xtraServiceCost, $xtraServiceCost, $xtraServiceCost, $xtraServiceCost, $termType, $initiationFee, $downPayment, $monthlyDues, $proRateDues, $proDateStart, $proDateEnd, $startDate, $endDate, $this->userID, $startDate, $trans);
                            $stmt->execute();
                            if(!$stmt->execute())  {
                            	printf("Error: %s.\n monthly", $stmt->error);
                               }		
                             $this->statusId = $stmt->insert_id;
                            $stmt->close(); 
                            
                            $status = 'CU';
                            $sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iiissid',  $this->statusId, $this->contractKey, $xtraServiceKey , $status, $startDate, $this->clubId, $xtraServiceCost);
                            if(!$stmt->execute())  {
                            	printf("Error: STATUS %s. \n", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                            
                            if ($this->monthlyBillingSelected == "CR"){
                                $achPayment = 0;
                                $creditPayment = $xtraServiceCost;
                            }else{
                                $achPayment = $xtraServiceCost;
                                $creditPayment = 0;
                            }
                            
                            $dueStatus = 'P';
                            $newMemebrFee = 0;
                            $cash = 0;
                            $check = 0;
                            $balanceDue = 0;
                            $upgrade = "U";
                            $new = "Y";
                            $process_fee_single_two = 0;
                            $enhance_fee = 0;
                            $sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iddddddddddsssdsiss', $this->contractKey, $this->upgradeFeeSingleTwo, $process_fee_single_two, $enhance_fee, $newMemebrFee, $xtraServiceCost, $cash, $check, $achPayment, $creditPayment, $balanceDue, $startDate, $startDate, $dueStatus, $xtraServiceCost, $startDate, $this->clubId, $upgrade, $new);
                            if(!$stmt->execute())  {
                            	printf("Error: INITIAL %s.\n", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                            
                            $stmt = $dbMain ->prepare("SELECT COUNT(*) as count, billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
                        $stmt->execute();      
                        $stmt->store_result();      
                        $stmt->bind_result($count, $billing_amount);   
                        $stmt->fetch();   
                        $stmt->close();
                        
                        if($count == 0){
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
                              
                            $billingStatus = "G";
                             $sql = "INSERT INTO monthly_payments VALUES (?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('issds', $this->contractKey, $this->monthlyBillingSelected, $billingDate, $monthlyDues, $billingStatus);
                            if(!$stmt->execute())  {
                            	printf("Error: %s.\n", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                        }else{
                            
                            $newMonthlyAmount = $monthlyDues + $billing_amount;
                             $sql = "UPDATE monthly_payments SET billing_amount = ? WHERE contract_key = '$this->contractKey'";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('d', $newMonthlyAmount);
                            if(!$stmt->execute())  {
                                            	printf("Error:updateEHFEE %s.\n", $stmt->error);
                                                  }	
                                
                            $stmt->close();
                            }
                            
                            $sid = "";
                            $serviceType = "E";
                            $new_sale = "Y";
                            $early_renewal = "N";
                            $am_pm = date('A');
                            $internet = "Y";
                            $upgrade = "Y";
                            $renewal = "N";
                            
                            $sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iisisiiisissddsddissssssss', $sid, $this->clubId, $this->clubName, $this->userID, $groupType, $groupNumber, $this->clubId, $xtraServiceKey, $xtraServiceName, $xtraServiceQuantity, $serviceTerm, $serviceType, $service_cost, $service_cost, $sid,$service_cost, $service_cost, $this->contractKey, $termType, $renewal, $upgrade, $internet, $startDate, $am_pm, $early_renewal, $new_sale);
                              if(!$stmt->execute())  {
                            	printf("Error: %s.\n", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                            
                    }else{
                        //   echo"fubar";
                       // exit;
                                    
                         $termType = "T"; 
                        $groupType = "S";
                        $groupNumber = 1;
                        $startDate = date('Y-m-d H:i:s');
                        $transfer = "N";
                        switch($serviceTerm){
                            case 'C':
                                        
                                        $sql = "INSERT INTO member_class_count VALUES (?,?,?,?)";
                                        $stmt = $dbMain->prepare($sql);
                                        $stmt->bind_param('isii', $this->contractKey, $groupType, $xtraServiceKey, $xtraServiceQuantity);
                                        $stmt->execute();
                                        if(!$stmt->execute())  {
                                        	printf("Error: %s.\n", $stmt->error);
                                           }		
                                        
                                        
                                        $stmt->close();
                                        
                                        $endDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d'),2040));
                            break;
                            case 'D':
                                $endDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d')+$xtraServiceQuantity,date('Y')));
                            break;
                            case 'W':
                                $tempTerm = $xtraServiceQuantity*7;
                                $endDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d')+$tempTerm,date('Y')));
                            break;
                            case 'Y':
                                $endDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d'),date('Y')+$xtraServiceQuantity));
                            break;
                        }
                        $gid = "";
                            $sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iisiissisddddssiss', $gid, $this->contractKey, $groupType, $groupNumber, $xtraServiceKey, $this->clubId, $xtraServiceName, $xtraServiceQuantity, $serviceTerm, $service_cost, $service_cost, $service_cost, $service_cost, $startDate, $endDate, $this->userID, $startDate, $transfer);
                            //$stmt->execute();
                            if(!$stmt->execute())  {
                            	printf("Error: %s.\n pif", $stmt->error);
                               }		
                               
                            $this->statusId = $stmt->insert_id;
                            $stmt->close(); 
                            
                            $accountStatus = 'CU';
                            $sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iiissid', $this->statusId, $this->contractKey, $xtraServiceKey , $accountStatus, $startDate, $this->clubId, $xtraServiceCost);
                            if(!$stmt->execute())  {
                            	printf("Error: status %s.\n as", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                            
                           if($achPayment == ""){
                            $achPayment = 0;
                           }
                           if($creditPayment == ""){
                            $creditPayment = 0;
                           }
                            $new_member_fee = 0;
                            $cash_payment = 0;
                            $check_payment = 0;
                            $balanceDue = 0;
                            $due_status = 'P';
                            $sales_category = "U";
                            $internet =  "Y";
                            $process_fee_single = 0;
                            $enhance_fee = 0;
                            $sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iddddddddddsssdsiss', $this->contractKey, $process_fee_single, $this->upgradeFeeSingleTwo, $enhance_fee, $new_member_fee, $xtraServiceCost, $cash_payment, $check_payment, $achPayment, $creditPayment, $balanceDue, $startDate, $startDate, $due_status, $xtraServiceCost, $startDate, $this->clubId, $sales_category, $internet);
                            if(!$stmt->execute())  {
                            	printf("Error: initial %s.\n", $stmt->error);
                               }		
                            
                            $stmt->close(); 
                            
                            $sales_key = "";
                            $service_type = "P";
                            $overidePin = "N";
                            $renewal = "";
                            $upgrade = "";
                            $internet = "";
                            $amPm = date('A');
                            $earlyRenew = "N";
                            $newSale = "Y";
                            $sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iisisiiisissddsddissssssss', $sales_key, $this->clubId, $this->clubName, $this->userID, $groupType, $groupNumber, $this->clubId, $xtraServiceKey, $xtraServiceName, $xtraServiceQuantity, $serviceTerm, $service_type, $service_cost, $service_cost,$overidePin, $service_cost, $service_cost, $this->contractKey, $termType, $renewal, $upgrade, $internet, $startDate, $amPm, $earlyRenew, $newSale);
                              if(!$stmt->execute())  {
                            	printf("Error: %s.\n sales", $stmt->error);
                               }		
                            
                            $stmt->close();
                          
                            
                        
                    }
            
            
        }
        
        }
                  
                
                  
                    }  
                    $this->serviceTermArray .= "$this->serviceTerm|";
                    
  
    
} //echo "eft $this->eftQuantity pif $this->pifQuantity";
//exit;
$totalGearArray = explode('~',$this->totalGearArray);  
 
 foreach($totalGearArray as $xtraGear){
       
        $xtraGearArray = explode('|',$xtraGear);
        $xtraGearMarker = $xtraGearArray[0];
        $xtraGearCost = $xtraGearArray[1];
        $xtraGearNumberPurchased = $xtraGearArray[2];
        
        $this->todaysPaymentTotal += $xtraGearCost * $xtraGearNumberPurchased;
        
        $sql = "UPDATE club_inventory SET inventory=? WHERE inventory_marker='$xtraGearMarker' ";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('i' , $inventory); 
                     
        $inventory = $this->inventory - $xtraGearNumberPurchased;
                     
        if(!$stmt->execute())  {    
          printf("Error: %s.\n", $stmt->error );
          }
                  
        $stmt->close();
        
        
        
}

  echo "1";
  exit;
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
    return($this->transferArray);  
    }    
function getProRateDues() {
    return($this->proRateDues);  
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
    return($this->todaysPaymentTotal);  
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
       return($this->monthlyBillingSelected);
       }
function getDatePicker() {
       return($this->datePicker);
       } 
function getSig() {
       return($this->signature);
       } 
function getSignupDate() {
       return($this->signupDate);
       } 
function getSalesArray() {
       return($this->saleArray);
       }
function getServiceTermArray() {
       return($this->serviceTermArray);
       } 
      
function getPifLength() {
       return($this->pifQuantity);
       }
function getEftLength() {
       return($this->eftQuantity);
       }
function getProcessFeeMonth() {
       return($this->processFeeMonthly);
       }
function getProcessFeePIF() {
       return($this->processFeePif);
       }
function getConKeyArray() {
       return($this->contractKeyArray);
       }
function getTotalServiceArray() {
       return($this->totalServiceArray);
       }       
  function getTotalGearArray() {
       return($this->totalGearArray);
       }      
}

?>