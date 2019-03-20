<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../nmi/nmiGatewayClass.php";
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";
include "serviceCreditCS.php";

class updateAccountInfo {

private $ajaxSwitch = null;
private $contractKey = null;
private $serviceKey = null;
private $serviceStatus = null;

//sets vars for group types
private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;

//sets the vars for the contract holder info
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $cityName = null;
private $stateValue = null;
private $zipCode = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $dob = null;
private $licenseNumber = null;

//vars for refunds and holds
private $serviceCost = null;
private $refundType = null;
private $monthlyDues = null;
private $monthlyPayment = null;
private $startDate = null;
private $endDate = null;
private $newStartDate = null;
private $newEndDate = null;
private $generalId = null;
private $memberId = null;
private $keyListBilling = null;
private $memberArray = null;
private $memberCount = null;
private $monthlyDuesList = null;
private $memberRefund = null;
private $memberRefundArray = null;
private $cancelType = null;
private $signUpDate = null;
private $originalSignUpDate = null;
private $serviceId = null;
private $contractId = null;
private $accountStatus = null;
private $contractDate = null;
private $refundBit = null;
private $groupNumber = null;
private $cancelCost = null;
private $monthlyBillingDay = null;
private $transactionType = null;
private $fundsAvailable = null;
private $holdFee = null;
private $transferFee = null;
private $holdDate = null;
private $numberMonths = null;
private $proRateDues = null;
private $totalProRateDues = 0;
private $serviceTerm = null;
private $serviceCreditNumber = null;
private $serviceCreditTerm = null;
private $historyKey = null;
private $todaysPayment = null;
private $paymentDescription = null;
private $dueDate = null;
private $balanceDue = null;
private $transKey = null;
private $lateFee = null;
private $rejectionFee = null;
private $rejectedPayment = null;
private $rejectionTotal = null;
private $totalBalanceDue = null;
private $totalPaymentDue = null;
private $pastDueGrace = null;
private $rejectionFeeType = null;
private $rejectionFeeDescription = null;
private $rejectedCheckNumber = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $currentPayment = null;
private $rejectBit = 1;
private $checkBit = 1;
private $cycleDay = null;
private $pastDay = null;
private $pastDueBalance = null;


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

//used to parse the name for credit and banking info
private $nameSwitch = null;
private $accountFirst = null;
private $accountMiddle = null;
private $accountLast = null;

//cyberSource params
private $authIdReference = null;
private $psReasonCode = null;
private $subscriptionID = null;
private $subscriptionId = null;
private $subscriptionType = null;
private $csBillingAmount = null;
private $frequency = null;
private $billingDate = null;
//private $guaranteeBit = null;
//private $enhanceBit = null;
//private $monthlyBit = null;


private $monthlyBillingType = null;
private $transType = null;
private $nextPaymentDueDate = null;


//this is for the refund hold history cancel
private $refundTotal = null;
private $cancelTotal = null;
private $holdTotal = null;
private $chType = null;
private $csHoldBit = null;
private $holdGrace = null;
private $membershipMatch = null;
private $guaranteeBit = null;
private $enhanceBit = null;
private $monthlyBit = null;
private $enhanceCycle = null;
private $enhanceCycleDate = null;
private $enhanceFee = null;
private $guaranteeCycle = null;
private $guaranteeCycleDate = null;
private $guaranteeFee = null;

function setNewMonthlyValue($newValue) {
             $this->newValue = $newValue;
             }
function setHoldGrace($holdGrace) {
             $this->holdGrace = $holdGrace;
             }

function setRefundTotal($refundTotal) {
             $this->refundTotal = $refundTotal;
             }
             
function setCancelTotal($cancelTotal) {
             $this->cancelTotal = $cancelTotal;
             }
             
function setHoldTotal($holdTotal) {
             $this->holdTotal = $holdTotal;
             }             
             
function setChType($chType) {
             $this->chType = $chType;
             }


function setTransType($transType) {
             $this->transType = $transType;
             }

function setRejectedCheckNumber($rejectedCheckNumber) {
            $this->rejectedCheckNumber = $rejectedCheckNumber;
            }

function setRejectedPayment($rejectedPayment) {
             $this->rejectedPayment = $rejectedPayment;
             }
             
function setRejectionFeeType($rejectionFeeType) {
             $this->rejectionFeeType = $rejectionFeeType;
             }
             
function setPastDueGrace($pastDueGrace) {
             $this->pastDueGrace = $pastDueGrace;
             }

function setTransKey($transKey) {
             $this->transKey = $transKey;
             }

function setServiceCreditNumber($serviceCreditNumber) {
              $this->serviceCreditNumber = $serviceCreditNumber;
              }

function setServiceCreditTerm($serviceCreditTerm) {
             $this->serviceCreditTerm = $serviceCreditTerm;
             }

function setContractDate($contractDate) {
            $this->contractDate = $contractDate;
            }

function setAjaxSwitch($ajaxSwitch) {
              $this->ajaxSwitch = $ajaxSwitch;
              }

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setServiceKey($serviceKey) {
              $this->serviceKey = $serviceKey;
              }

function setServiceStatus($serviceStatus) {
              $this->serviceStatus = $serviceStatus;
              }
              
function setServiceCost($serviceCost) {
              $this->serviceCost = $serviceCost;
              }              

function setRefundType($refundType) {
              $this->refundType = $refundType;
              }
              
function setGroupName($groupName) {
              $this->groupName = $groupName;
              }
              
function setGroupAddress($groupAddress) {
              $this->groupAddress = $groupAddress;
              }
              
function setGroupPhone($groupPhone) {
              $this->groupPhone = $groupPhone;
              }

function setFirstName($firstName) {
              $this->firstName = $firstName;
              }
              
function setMiddleName($middleName) {
              $this->middleName = $middleName;
              }
              
function setLastName($lastName) {
              $this->lastName = $lastName;
              }

function setStreetAddress($streetAddress) {
              $this->streetAddress = $streetAddress;
              }
              
function setCityName($cityName) {
              $this->cityName = $cityName;
              }

function setStateValue($stateValue) {
              $this->stateValue = $stateValue;
              }
  
function setZipCode($zipCode) {
              $this->zipCode = $zipCode;
              }
              
function setPrimaryPhone($primaryPhone) {
              $this->primaryPhone = $primaryPhone;
              }
 
function setCellPhone($cellPhone) {
              $this->cellPhone = $cellPhone;
              } 
              
function setEmailAddress($emailAddress) {
              $this->emailAddress = $emailAddress;
              }
              
function setDob($dob) {
              $this->dob = $dob;
              }              
       
function setLicenseNumber($licenseNumber) {
              $this->licenseNumber = $licenseNumber;
              }
              
function setMemberId($memberId) {
              $this->memberId = $memberId;
              }
              
function setGeneralId($generalId) {
              $this->generalId = $generalId;
              } 
     
function setKeyListBilling($keyListBilling) {
              $this->keyListBilling = $keyListBilling;
              }
              
function setMemberRefund($memberRefund) {
              $this->memberRefund = $memberRefund;
              }
              
function setServiceId($serviceId) {
              $this->serviceId = $serviceId;
              }  
              
 function setGroupNumber($groupNumber) {
              $this->groupNumber = $groupNumber;
              }
              
 function setMemberCount($memberCount) {
              $this->memberCount = $memberCount;
              }   
              
function setCancelCost($cancelCost) {
             $this->cancelCost = $cancelCost;
             }
             
function setMonthlyDues($monthlyDues) {
             $this->monthlyDues = $monthlyDues;
             }

function setFundsAvailable($fundsAvailable) {
             $this->fundsAvailable = $fundsAvailable;
             }
             
function setHoldFee($holdFee) {
             $this->holdFee = $holdFee;
             }
             
function setTransferFee($transferFee) {
             $this->transferFee = $transferFee;
             }

function setLateFee($lateFee) {
             $this->lateFee = $lateFee;
             }

function setRejectionFee($rejectionFee) {
             $this->rejectionFee = $rejectionFee;
             }

function setTodaysPayment($todaysPayment) {
             $this->todaysPayment = $todaysPayment;
             }
             
function setPaymentDescription($paymentDescription) {
             $this->paymentDescription = $paymentDescription;
             }

function setRejectionTotal($rejectionTotal) {
             $this->rejectionTotal = $rejectionTotal;
             }

function setPastDueBalance($pastDueBalance) {
             $this->pastDueBalance = $pastDueBalance;
             }

             
function setBalanceDue($balanceDue) {
             $this->balanceDue = $balanceDue;
             }
function setDueDate($dueDate) {
             $this->dueDate = $dueDate;
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
       
function setMonthlyBillingType($monthlyBillingType) {
       $this->monthlyBillingType = $monthlyBillingType;
       }
function setRejectedDate($rejected_date){
        $this->rejectionDate = $rejected_date;
}
function setHistoryKey($history_key){
        $this->historyKey = $history_key;
}
function setBool($addSubBool){
    $this->addSubBool = $addSubBool;
}
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function skipCsPayment() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT MAX(cycle_date) FROM monthly_payments WHERE contract_key = '$this->contractKey' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($cycleDate);  
  $stmt->fetch();

 $cycleDay = date("d", strtotime($cycleDate));
 $todaysDateSecs = time();
 $todaysDay = date("d", strtotime($todaysDateSecs));
 
 if($todaysDay > $cycleDay) {
   //skip payment is set to the next month
  $this->billingDate = date("Ymd"  ,mktime(0, 0, 0, date("m")+1, $cycleDay, date("Y")));
 
  }else if($todaysDay <= $cycleDay) {
  //skip payment is set to this month
  $this->billingDate = date("Ymd"  ,mktime(0, 0, 0, date("m"), $cycleDay, date("Y")));
  }
  
//echo "$this->billingDate ";
//exit;
  //$this->checkDeleteMonthly();
  //$this->createCsSubscription();
  
}
//--------------------------------------------------------------------------------------------------------------------
function loadEnhanceCycles() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT eft_cycle, eft_cycle_date, enhance_fee FROM member_enhance_eft WHERE contract_key = '$this->contractKey' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($enhanceCycle, $enhanceCycleDate, $enhanceFee);  
  $numRows = $stmt->num_rows;
  $stmt->fetch();

  if($numRows > 0) {
  
  $this->enhanceCycle = $enhanceCycle;
  $this->enhanceCycleDate = $enhanceCycleDate;
   
         //needed in order to send to CS  
          switch ($this->enhanceCycle) {
               case "A":
               $this->enhanceFee = $enhanceFee * 1;
               break;
               case "B":
               $this->enhanceFee = $enhanceFee * 2;
               break;
               case "Q":
               $this->enhanceFee = $enhanceFee * 4;
               break;
               case "M":
               $this->enhanceFee = $enhanceFee * 12;
               break;                                      
              }      
  
  }
  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function loadGuaranteeCycles() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT eft_cycle, eft_cycle_date, guarantee_fee FROM member_guarantee_eft WHERE contract_key = '$this->contractKey' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($guaranteeCycle, $guaranteeCycleDate, $guaranteeFee);    
  $numRows = $stmt->num_rows;
  $stmt->fetch();
  
  if($numRows > 0) {
  
  $this->guaranteeCycle = $guaranteeCycle;
  $this->guaranteeCycleDate = $guaranteeCycleDate;
 
        //needed in order to send to CS  
          switch ($this->guaranteeCycle) {
               case "A":
               $this->guaranteeFee = $guaranteeFee * 1;
               break;
               case "B":
               $this->guaranteeFee = $guaranteeFee * 2;
               break;
               case "Q":
               $this->guaranteeFee = $guaranteeFee * 4;
               break;
               case "M":
               $this->guaranteeFee = $guaranteeFee * 12;
               break;                                      
              }   
  
  }
  
  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$stmt->close(); 

}
//----------------------------------------------------------------------------------------------------------------------
function updateCsBillingType() {

//creates monthly subscription
$this->loadCycleDate();
//$this->createCsSubscription();

//creates Enhance Subscriptions if they exist
$this->loadEnhanceCycles();
   if($this->enhanceCycle != null) {
      $this->createEnhanceFeeSubscription();   
     }
     
//creates Enhance Subscriptions if they exist
$this->loadGuaranteeCycles();
   if($this->guaranteeCycle != null) {
      $this->createGuaranteeFeeSubscription();   
     }     


}

//---------------------------------------------------------------------------------------------------------------------
function createGuaranteeFeeSubscription() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_guarantee_eft SET eft_cycle =?,  eft_cycle_date =?, guarantee_fee =?  WHERE contract_key = '$this->contractKey' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssd', $eftCycle, $eftCycleDate, $guaranteeFee);


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


    switch ($this->guaranteeCycle) {
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
$eftCycle = $this->guaranteeCycle;
$eftCycleDate = $this->guaranteeCycleDate;
$guaranteeFee = sprintf("%.2f", $this->guaranteeFee / $divisor);
$this->csBillingAmount = $guaranteeFee;
$this->frequency = $frequency;

if(!$stmt->execute())  {
	printf("Error: member_guarantee_eft  createGuaranteeFeeSubscription %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------
function createEnhanceFeeSubscription() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_enhance_eft SET eft_cycle =?,  eft_cycle_date =?, enhance_fee =?  WHERE contract_key = '$this->contractKey' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssd', $eftCycle, $eftCycleDate, $enhanceFee);


//break up the guarentee cycle date
$day = date("d", strtotime($this->enhanceCycleDate));
$month = date("m", strtotime($this->enhanceCycleDate));
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


    switch ($this->enhanceCycle) {
        case "A":
        $divisor = 1;
        $frequency = 'annually';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);
               }elseif($todaysDateSecs > $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->enhanceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1)); 
               }
        
        break;
        case "B":
        $divisor = 2;
        $frequency = 'semi-annually';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);
                }elseif($todaysDateSecs <= $enhanceCycleDateSecsAnnual) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsAnnual);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsAnnual);
                }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->enhanceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                                 
                }
                                
        break;
        case "Q":
        $divisor = 4;
        $frequency = 'quarterly';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);        
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter2) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter2);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter2);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter3) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter3);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter3);           
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsQuarter4) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsQuarter4);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsQuarter4);
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->enhanceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                
               }
        
        break;
        case "M":
        $divisor = 12;
        $frequency = 'monthly';
            if($todaysDateSecs <= $enhanceCycleDateSecs) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecs);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecs);        
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths2) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths2);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths2);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths3) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths3);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths3);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths4) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths4);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths4);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths5) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths5);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths5);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths6) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths6);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths6);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths7) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths7);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths7);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths8) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths8);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths8);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths9) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths9);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths9);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths10) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths10);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths10);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths11) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths11);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths11);                
               }elseif($todaysDateSecs <= $enhanceCycleDateSecsMonths12) {
                $scStartDate = date("Ymd", $enhanceCycleDateSecsMonths12);
                $this->enhanceCycleDate = date("Y-m-d H:i:s", $enhanceCycleDateSecsMonths12);                
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1)); 
                $this->enhanceCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));                 
               }
                
        break;
       }

$contractKey = $this->contractKey;         
$eftCycle = $this->enhanceCycle;
$eftCycleDate = $this->enhanceCycleDate;
$enhanceFee = sprintf("%.2f", $this->enhanceFee / $divisor);
$this->csBillingAmount = $enhanceFee;
$this->frequency = $frequency;

if(!$stmt->execute())  {
	printf("Error: member_enhance_eft  createEnhanceFeeSubscription %s.\n", $stmt->error);
   }		

$stmt->close(); 




}
//---------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function checkServiceType() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT service_name FROM monthly_services WHERE contract_key='$this->contractKey' AND service_id ='$this->serviceId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($serviceName);   
 $stmt->fetch(); 
 $stmt->close();

if(preg_match("/membership/i", $serviceName)) { 
   $this->membershipMatch = 1;
  }

}
//--------------------------------------------------------------------------------------------------------------------
function testRejectionPayments() {

//emulates payment history mthod
$balanceDue = $this->balanceDue;
if($balanceDue == "0.00")  {
   $historyDueStatus = 'PF';
   }else{
   $historyDueStatus = 'BD';
   }
   
$processDate = date("Y-m-d");

//here we check for null vals in the payment types and convert them to 0 for insert
if($this->creditPayment == "") {
   $creditPayment = 0;
  }else{
  $creditPayment = $this->creditPayment;
  }
  
if($this->achPayment == "") {
   $achPayment = 0;
  }else{
  $achPayment = $this->achPayment;
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
  $cashPayment = $this->cashPayment;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->checkPayment;
  }

$checkNumber = $this->rejectedCheckNumber;


echo"        
Billing Type:  $this->paymentDescription
<br>
Billing Amount:  $this->todaysPayment
<br>
Balance Due:  $this->balanceDue
<br>
Payment Date:  $processDate
<br>
Date Due:  $this->dueDate
<br>
Credit Payment:  $creditPayment
<br>
ACH Payment:  $achPayment
<br>
Cash Payment:  $cashPayment
<br>
Check Payment:  $checkPayment
<br>
Check Number:  $checkNumber
<br>
Trans Key:  $this->transKey
<br>
History Due Status:  $historyDueStatus
<br>
Bundled: $this->bundled
<br>
Late Fee: $this->lateFeeAll
<br>
Reject Fee Check:  $this->rejectFeeCheck
<br>
Reject Fee Credit:  $this->rejectFeeCredit
<br>
Reject Fee ACH:  $this->rejectFeeAch
<br><br>";

}
//--------------------------------------------------------------------------------------------------------------------
function updateRejectLists() {

 //if the rejected payment was a check then we update the nsf table so that we know that a payment has been made and take it ou of rejected payments
  $dbMain = $this->dbconnect();
if($this->rejectedCheckNumber != 0) {
   $sql = "UPDATE nsf_checks SET check_bit= ? WHERE contract_key = '$this->contractKey' AND check_number= '$this->rejectedCheckNumber' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('i',  $checkBit); 
   $checkBit = 1;

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close(); 
  }


if($this->rejectedCheckNumber == 0) {
   $sql = "UPDATE rejected_payments SET reject_bit= ? WHERE contract_key = '$this->contractKey' AND history_key= '$this->transKey' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('i',  $rejectBit); 
   $rejectBit = 1;

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close();  
   
    $stmt = $dbMain ->prepare("SELECT MONTH(last_attempt_date) FROM rejected_payments WHERE contract_key = '$this->contractKey' AND history_key= '$this->transKey'  ");
     $stmt->execute();      
     $stmt->store_result();      
     $stmt->bind_result($month);   
     $stmt->fetch(); 
     $stmt->close();
     
     if($month < 10){
        $month = "0$month";
     }
   
   $sql = "UPDATE batch_recurring_records SET outstanding_balance= ?, processed= ?, imported= ? WHERE contract_key = '$this->contractKey' AND cycle_start_month = '$month'"; //may need to use trans id
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('sss',  $outBal, $val, $val); 
   $outBal = "N";
   $val = "Y";

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close();  
  }


/*if ($this->paymentDescription == 'Past Due'){
    
    $dbMain = $this->dbconnect();
    $sql = "UPDATE rejected_payments SET reject_bit= ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('i',  $rejectBit); 
    $rejectBit = 1;
    if(!$stmt->execute())  {
    printf("Error: %s.\n", $stmt->error);
    }		
    $stmt->close();  
                      
    $sql = "UPDATE batch_recurring_records SET outstanding_balance= ?, processed= ?, imported= ? WHERE contract_key = '$this->contractKey'"; //may need to use trans id
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('sss',  $outBal, $val, $val); 
    $outBal = "N";
    $val = "Y";
    if(!$stmt->execute()) {
    printf("Error: %s.\n", $stmt->error);
    }		
    $stmt->close();   
    }*/

}
//--------------------------------------------------------------------------------------------------------------------
function parseRejectionFeeType() {

 switch ($this->rejectionFeeType) {
        case "NSFC":
        $this->rejectionFeeDescription = "NSF Check Fee";
        break;
        case "NSFA":
        $this->rejectionFeeDescription = "NSF ACH Fee";
        break;
        case "CC":
        $this->rejectionFeeDescription = "CC Rejection Fee";
        break;
       }
}
//--------------------------------------------------------------------------------------------------------------------
function parseRejectionFeeBit() {

 switch ($this->rejectionFeeType) {
        case "NSFC":
        $this->rejectFeeCheck = "1";
        break;
        case "NSFA":
        $this->rejectFeeAch = "1";
        break;
        case "CC":
        $this->rejectFeeCredit = "1";
        break;
       }
}
//--------------------------------------------------------------------------------------------------------------------
function processPaidInFull() {

//we set the payment as bundled if there is a late fe or reject fee to filter out duplicate records when accounting
if($this->rejectionFee != 0 || $this->lateFee != 0) {
   $this->bundled = 'Y';
   }


if ($this->rejectionDate == ''){
    $todaysDate = date("Y-m-d");
    $todaysDateSecs = strtotime($todaysDate);
    $pastDaysSecs = $this->pastDueGrace * 86400;
    $dueDateSecs = $todaysDateSecs + $pastDaysSecs;
    $this->dueDate = date("Y-m-d", $dueDateSecs);
}else{
    $rejectDate = strtotime($this->rejectionDate);
    $pastDaysSecs = $this->pastDueGrace * 86400;
    $dueDateSecs = $rejectDate + $pastDaysSecs;
    $this->dueDate = date("Y-m-d", $dueDateSecs);
}

$this->updateRejectLists();
//echo "$this->pastDueBalance $this->rejectedPayment<br>";
if($this->pastDueBalance != '0.00') {
     if($this->paymentDescription == 'Monthly Dues CC' || $this->paymentDescription == 'Monthly Dues ACH') {
         //here we adjust the payment description for the service
        $serviceSettled = "$this->paymentDescription Declined Settled";
        $this->paymentDescription = $serviceSettled;
        $this->todaysPayment = "0.00";
        $this->balanceDue = $this->totalBalanceDue;
        $this->insertPaymentHistory();
        }else{
            //echo"ttttttt $this->paymentDescription<br>";
            if ($this->paymentDescription == 'Past Due'){
                $serviceSettled = "$this->paymentDescription Settled";
                $this->paymentDescription = $serviceSettled;
                $this->todaysPayment = $this->pastDueBalance; 
                
                   $dbMain = $this->dbconnect();
                   $sql = "UPDATE rejected_payments SET reject_bit= ? WHERE contract_key = '$this->contractKey'";
                   $stmt = $dbMain->prepare($sql);
                   $stmt->bind_param('i',  $rejectBit); 
                   $rejectBit = 1;
                   if(!$stmt->execute())  {
                      printf("Error: %s.\n", $stmt->error);
                     }		
                   $stmt->close();  
                  
                   $sql = "UPDATE batch_recurring_records SET outstanding_balance= ?, processed= ?, imported= ? WHERE contract_key = '$this->contractKey'"; //may need to use trans id
                   $stmt = $dbMain->prepare($sql);
                   $stmt->bind_param('sss',  $outBal, $val, $val); 
                   $outBal = "N";
                   $val = "Y";
                   if(!$stmt->execute())  {
                      printf("Error: %s.\n", $stmt->error);
                     }		
                   $stmt->close();   
            }else{
                $serviceSettled = "$this->paymentDescription Settled";
                $this->paymentDescription = $serviceSettled;
                $this->todaysPayment = $this->rejectedPayment;
        
            }
          //here we adjust the payment description for the service
        $this->balanceDue = $this->totalBalanceDue;
        $this->insertPaymentHistory();       
       }
   }else{
        //here we adjust the payment description for the service
        $serviceSettled = "$this->paymentDescription Settled";
        $this->paymentDescription = $serviceSettled;
        $this->todaysPayment = $this->rejectedPayment;
        $this->balanceDue = $this->totalBalanceDue;
        $this->insertPaymentHistory();         
   }

if($this->lateFee != 0) {
   $this->paymentDescription = "Late Fee";
   $this->todaysPayment = $this->lateFee;
   $this->insertPaymentHistory();
  }


if($this->rejectionFee != 0) {
   $this->parseRejectionFeeType();
   $this->paymentDescription = $this->rejectionFeeDescription;
   $this->todaysPayment = $this->rejectionFee;
   $this->insertPaymentHistory();
  }
  



}
//--------------------------------------------------------------------------------------------------------------------
function processPartial() {

if($this->lateFee > 0) {
    $this->lateFeeAll = 1;
   }

if($this->rejectionFee > 0) {
    $this->parseRejectionFeeBit();
   }

//here we adjust the payment description
$this->paymentDescription = "$this->paymentDescription Partial";
$this->todaysPayment = $this->currentPayment;
$this->balanceDue = $this->totalPaymentDue - $this->todaysPayment;

$todaysDate = date("Y-m-d");
$todaysDateSecs = strtotime($todaysDate);
$pastDaysSecs = $this->pastDueGrace * 86400;
$dueDateSecs = $todaysDateSecs + $pastDaysSecs;
$this->dueDate = date("Y-m-d", $dueDateSecs);
$this->updateRejectLists();
$this->insertPaymentHistory();

//$this->testRejectionPayments();

}
//--------------------------------------------------------------------------------------------------------------------
function parseRejectedPayments() {

//first we add up all the various payment options to se what was collected from the client

if($this->creditPayment == "") {
   $creditPayment = 0;
  }else{
  $creditPayment = $this->creditPayment;
  $this->transType = 'CR';
  }
  
if($this->achPayment == "") {
   $achPayment = 0;
  }else{
  $achPayment = $this->achPayment;
  $this->transType = 'BA';
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
  $cashPayment = $this->cashPayment;
  $this->transType = 'CA';
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->checkPayment;
  $this->transType = 'CH';
  }
  
  
//now we add up the total balance of what is due but first we set the fees  to numeric so we can add them up
if($this->lateFee == null || $this->lateFee == "") {
   $this->lateFee = 0;
   }
if($this->rejectionFee == null || $this->rejectionFee == "") {
   $this->rejectionFee = 0;
   }  
  
  
if($this->pastDueBalance == '0.00') {
   $this->currentPayment = $creditPayment + $achPayment + $cashPayment + $checkPayment;
   $this->totalPaymentDue = $this->lateFee + $this->rejectionFee + $this->rejectedPayment;
   
           //if this is not past due then we insert the monthly settled table
         if($this->paymentDescription == 'Monthly Dues CC' || $this->paymentDescription == 'Monthly Dues ACH') {
             $this->authIdReference = $this->transKey;
             $this->todaysPayment = $this->currentPayment;
             $this->saveMonthlySettled();
             $this->deletePastDueAttempts();             
           }
           
   }else{      
   
        if($this->paymentDescription != 'Monthly Dues CC' && $this->paymentDescription != 'Monthly Dues ACH') {
          $this->currentPayment = $this->rejectionTotal;
          $this->totalPaymentDue = $this->lateFee + $this->rejectionFee + $this->rejectedPayment; 
         
          }else{
           $this->currentPayment = $this->rejectionTotal;
           $this->totalPaymentDue = $this->lateFee + $this->rejectionFee;             
           }
   }



//here we figure the balance due between the current payment and the payment due
if ($this->currentPayment > $this->totalPaymentDue){
    $this->totalBalanceDue = 0;
}else{
    $this->totalBalanceDue = $this->totalPaymentDue - $this->currentPayment;
}



//echo"fubar test!!!!!!!!tbd $this->totalBalanceDue = tpd $this->totalPaymentDue - cp $this->currentPayment rf $this->rejectionFee rt $this->rejectionTotal";

//first we do someting if the total balance has been paid
if($this->totalBalanceDue == 0 || $this->totalBalanceDue == "0.00") {
   $this->totalBalanceDue == "0.00";
   $this->processPaidInFull();
  }else{
   $this->processPartial();
  }




}
//---------------------------------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------------------------------
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
        case 4:
             $this->accountFirst = $account_name_array[0];
             $this->accountMiddle = $account_name_array[1];
             $this->accountLast = "$account_name_array[2] $account_name_array[3]";
        break;
    default:
            $this->accountFirst = "";
            $this->accountMiddle = "";
            $this->accountLast = $this->nameSwitch;
     }
   
 }

}
//--------------------------------------------------------------------------------------------------------------------
function updateBankingInfo() {

$dbMain = $this->dbconnect();
    
$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($club_id); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$club_id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($userName, $password);
$stmt->fetch();
$stmt->close();

$sql = "UPDATE banking_info SET bank_name= ?,  account_type= ?, account_fname= ?, account_mname= ?, account_lname= ?,  account_number= ?, routing_number= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssssi',  $bankName, $accountType, $accountFirst, $accountMiddle, $accountLast, $accountNumber, $abaNumber); 

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
    
$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
    
    if($count == 0){
        $vaultFunction = "add_customer";
        $merch1 = "Add Ach Vault ID $this->contractKey";
    }else{
        $vaultFunction = "update_customer";
        $merch1 = "Update Ach Vault ID $this->contractKey";
    }
    
            $payTypeFlag = "check";//"creditcard"; // '' or 'check'
            $secCode = "PPD";
            $vaultId = "$this->contractKey";
            $checkname = "$accountFirst $accountLast";	//The name on the customer's ACH account.
            
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
            
            $gw = new gwapi;
            $gw->setLogin("$userName", "$password");
            $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $abaNumber, $accountNumber, $account_holder_type, $account_type, $merch1, $merch1, $secCode);
            $reasonCode = $gw->responses['response_code'];
            
            
            //echo "sdfjkhdjkfhsdjkhsjkdjshdfdjkshjk $reasonCode";
            if($reasonCode == 100){
                $sql = "INSERT INTO billing_vault_id VALUES (?, ?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('is', $this->contractKey, $vaultId); 
                $stmt->execute();
                $stmt->close(); 
            }

}
//==================================================================
function updateCreditInfo() {

$dbMain = $this->dbconnect();


$expDate = $this->formatCreditDate();

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
    
     if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }		
    
    $stmt->close(); 
    

}

//--------------------------------------------------------------------------------------------------------------------
function loadPaidFullTerm() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_term, start_date, end_date FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($service_term, $start_date, $end_date);
$stmt->fetch();

$this->serviceTerm = $service_term;
$this->startDate = $start_date;
$this->endDate = $end_date;


 if(!$stmt->execute())  {
	printf("Error: %s.\n  paid_full_services  function loadPaidFullTerm select", $stmt->error);
    }
   
  $stmt->close();  

}
//--------------------------------------------------------------------------------------------------------------------
function updatePaidFullStartEnd() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $signup_date, $transfer);
$stmt->fetch();

 if(!$stmt->execute())  {
	printf("Error: %s.\n  paid_full_services  function updatePaidFullStartEnd select", $stmt->error);
    }   
  $stmt->close();  
  
  
 $start_date = $this->newStartDate;
 $end_date = $this->newEndDate;
 $signup_date = date("Y-m-d H:m:s"); 
 $serviceId = "";
 
 $sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $signup_date, $transfer);

if(!$stmt->execute())  {
	printf("Error: %s.\n  paid_full_services  function updatePaidFullStartEnd insert", $stmt->error);
   }		
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateMonthlyStartEnd() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM monthly_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id, $signup_date, $transfer);
$stmt->fetch();


 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services  function updateMonthlyStartEnd select", $stmt->error);
    }
   
  $stmt->close();  

$serviceId = null;
$pro_rate_dues = $this->proRateDues;
$pro_date_start = date("Y-m-d"); 
$pro_date_end = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("t"), date("Y")));
$start_date = $this->newStartDate;
$end_date = $this->newEndDate;
$signup_date = date("Y-m-d H:m:s"); 

$sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissiddddsddddssssiss' ,$serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id, $signup_date, $transfer);


if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services  function updateMonthlyStartEnd insert", $stmt->error);
   }		

$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthProRate()  {

//get the current day number of the month and the numberof days in the month
$todays_date = time();
$current_day_number = date("j", $todays_date);
$month_days_number = date(t);

//divide the month amount by the number of days
$daily_amount = $this->monthlyDues / $month_days_number;
//get the difference between the days
$date_difference = $month_days_number - $current_day_number;

//create the pro rate amount and format it
$pro_rate_amount = $date_difference * $daily_amount;
$this->proRateDues = sprintf("%.2f", $pro_rate_amount);
$this->totalProRateDues = $this->totalProRateDues + $this->proRateDues;

}
//--------------------------------------------------------------------------------------------------------------------
function loadHoldDate() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT  MAX(hold_date) AS hold_date FROM service_hold WHERE contract_key ='$this->contractKey'  AND  service_key= '$this->serviceKey' AND service_id='$this->serviceId' ORDER BY hold_date DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($hold_date);
   $stmt->fetch();
   
   $this->holdDate = $hold_date;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();


}
//--------------------------------------------------------------------------------------------------------------------
function loadServiceAdjustment() {

$this->loadHoldDate();
$service_hold_date = strtotime($this->holdDate);
$todays_date = time();

//first we make sure that this is a monthly service, then we charge the client accordingly for the current monthly service if applicable
if($this->monthlyDues != 0) {

   $this->loadMonthlyPayment();
   $this->loadStartDate();   
   $this->loadBillingDay();
   
   //here we get the dates, convert to secs then 
   $service_start_date = strtotime($this->startDate);   
   $service_end_date = strtotime($this->endDate);
   $signup_date = strtotime($this->signupDate);
   $hold_date = strtotime($this->holdDate);
   
   
   //subtract to get the time difference of the amount of seconds used from the start of the contract until the hold was implemented
   $service_term_to_hold_date = $service_hold_date - $service_start_date;

   //now we get the number of seconds until the end of the contract
   $hold_date_to_end_date = $service_end_date - $service_hold_date;
   
   //now check to see if the hold date is within the same month as the release date and if a payment has been received.  First we check to see if the hold is within the prorate month at the begining of the signup before the first service month of the contract starts. Since it is paid for we do nothing as far as updating start and end dates or prorate fees
   $signup_month_year = date("Y-m", $signup_date);
   $today_month_year = date("Y-m", $todays_date);
   $start_month_year = date("Y-m", $service_start_date);
   
   if($signup_month_year == $today_month_year) {
     $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
     $this->updateMonthlyPayments();   
     }
   
   //here we check to see if this is the first month of service based on the service start date and todays date.  Then we check the hold day to see if it is greater or less than the billing day. If it is greater than the billing day we do not charge the account since they have already paid for it.  If it is before the billing day then we charge the account based on the number of days until the end of the month.  They 'loadMonthProrate' is charged after all of the monthly services have been parsed through this function and totaled up
   $hold_day = date("j", $hold_date);
   
    if($start_month_year == $today_month_year) {
    
           if($hold_day < $this->monthlyBillingDay) {
              $this->loadMonthProRate();              
              }   
              
        $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
        $this->updateMonthlyPayments();     
        }
        
   //this checks to see if this is a month to month service "one month".  If it is, it prorates or does not prorate based on the hold release day.  This also filters out the possibility of a double charge if it is beyond the first month of the service as stated above
    if($this->numberMonths == 1) {
       if($start_month_year != $today_month_year) {
       
            if($hold_day < $this->monthlyBillingDay) {
                $this->loadMonthProRate();              
               }   
               
           $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
           $this->updateMonthlyPayments();
         }    
      }
                       
   //finally we look for term monthly memberships that are more than one month in duration.  We use  the  number of seconds from the start date to the hold date and the number of seconds from the hold date to the end date of the service to create new start and end dates. Since this case means creating a new service record we change start and end dates and create individual prorate records
   if($this->numberMonths > 1)  {
       if(($start_month_year != $today_month_year)  &&  ($signup_month_year != $today_month_year)) {
       
          $new_start_date = $todays_date - $service_term_to_hold_date;
          $new_end_date =  $todays_date + $hold_date_to_end_date;
          $new_start_date_day = date("j", $new_start_date);
          
          //here we set the start date to the begining of the month in relation to the hold date release day. Then we add the remaining month term minus one to get the full term
          
             $month_term = $this->numberMonths - 1;
             $year_month = date("Y-m", $new_start_date);
             $this->newStartDate = "$year_month-01";
             $newEndDateSecs =  strtotime(date("Y-m-d", strtotime($this->newStartDate)) . "+$month_term month"); 
             $this->newEndDate = date("Y-m-d", $newEndDateSecs);
                        
             //her we create the monthly prorate for the rest of the month and create a new service record to reflect the new term start and end dates. If the hold day is less than the the monthly billing day we prorate the month since the client was not originally charged for the month when they placed the original hold.
              if($hold_day < $this->monthlyBillingDay) {
                 $this->loadMonthProRate();              
                 }                               
              $this->updateMonthlyStartEnd();
               
           $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
           $this->updateMonthlyPayments();       
          }   
     }
//ends if monthly dues is not 0 
}else{

//load the start, end and service type
$this->loadPaidFullTerm();

       //if this is a class we do nothing since it has no experation date
        if($this->serviceType != 'C')  {
        
            //here we get the dates, convert to secs 
             $service_start_date = strtotime($this->startDate);   
             $service_end_date = strtotime($this->endDate);
             $hold_date_formated = date("Y-m-d", $service_hold_date);
             $todays_date_formated =  date("Y-m-d", $todays_date);
              
              //if the hold date is the same as todays date we do nothing since there is no time line to adjust
              if($hold_date_formated != $todays_date_formated) {
              
                 //subtract to get the time difference of the amount of seconds used from the start of the contract until the hold was implemented we also get the number of seconds until the end of the contract
                 $service_term_to_hold_date = $service_hold_date - $service_start_date;                  
                 $hold_date_to_end_date = $service_end_date - $service_hold_date;
              
                        $new_start_date_secs = $todays_date - $service_term_to_hold_date;
                        $new_end_date_secs =  $todays_date + $hold_date_to_end_date;
                        $this->newStartDate = date("Y-m-d", $new_start_date_secs);
                        $this->newEndDate = date("Y-m-d", $new_end_date_secs);
                        $this->updatePaidFullStartEnd();
                        
                }
           }

}//end of else if paid full

}
//---------------------------------------------------------------------------------------------------------------------
function loadBillingDay() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT cycle_day, past_day FROM billing_cycle WHERE cycle_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cycle_day, $past_day);
   $stmt->fetch();
   
   $this->monthlyBillingDay = $cycle_day;
   $this->cycleDay = $cycle_day;
   $this->pastDay = $past_day;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);   
$stmt->fetch(); 
$stmt->close();

$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pastDay);
$stmt->fetch();
$stmt->close(); 
   

$cycleDay = date("d", strtotime($cycle_date));
$todayDay = date("d");
//$this->csHoldBit == 5;
if($this->csHoldBit == 1 || $this->csHoldBit == 2) {

   //$holdGracePeriodSeconds = $this->holdGrace * 86400;
   $todaysDateSecs = time();
   $holdReleaseSecs = $todaysDateSecs;// + $holdGracePeriodSeconds;   
   $releaseDay = date("d", $holdReleaseSecs);
   $releaseMonth = date("m", $holdReleaseSecs);
   $releaseYear = date("Y", $holdReleaseSecs);
      
   
     if($cycleDay > $releaseDay)  {
       $billingDate = date("Ymd"  ,mktime(0, 0, 0, $releaseMonth, $cycleDay, $releaseYear));
       $nextBillingDue = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $releaseMonth, $cycleDay+$pastDay, $releaseYear));
       }
     if($cycleDay < $releaseDay)  {
       $billingDate = date("Ymd"  ,mktime(0, 0, 0, $releaseMonth+1, $cycleDay, $releaseYear));
       $nextBillingDue = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $releaseMonth+1, $cycleDay+$pastDay, $releaseYear));
       }
     if($cycleDay == $releaseDay)  {
       $billingDate = date("Ymd"  ,mktime(0, 0, 0, $releaseMonth, $cycleDay, $releaseYear));
       $nextBillingDue = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $releaseMonth, $cycleDay+$pastDay, $releaseYear));
       }

  }else{
         
      //check if iis past or present then generate the billing date
      if($cycleDay > $todayDay)  {
        $billingDate = date("Ymd"  ,mktime(0, 0, 0, date("m"), $cycleDay, date("Y")));
        $nextBillingDue = date("Ymd"  ,mktime(0, 0, 0, date("m"), $cycleDay+$pastDay, date("Y")));
        }
      if($cycleDay <= $todayDay)  {
        $billingDate = date("Ymd"  ,mktime(0, 0, 0, date("m")+1, $cycleDay, date("Y")));
        $nextBillingDue = date("Ymd"  ,mktime(0, 0, 0, date("m")+1, $cycleDay+$pastDay, date("Y")));
        }
      /*if($cycleDay == $todayDay)  {
        $billingDate = date("Ymd"  ,mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $nextBillingDue = date("Ymd"  ,mktime(0, 0, 0, date("m"), date("d")+$pastDay, date("Y")));
        }
        $billingDate =  "20191212";*/
        
   }

$this->billingDate = $billingDate;
$this->nextPaymentDueDate = $nextBillingDue;
//$this->billingDate = "20171212";

}

//-------------------------------------------------------------------------------------------------------------------
function insertPaymentHistory() {

//$this->dueDate = date("Y-m-d");
//$this->balanceDue = '0.00';

   require('../helper_apps/paymentHistory.php');  

}
//--------------------------------------------------------------------------------------------------------------------
function loadMemberCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(general_id) AS member_count FROM member_info WHERE contract_key ='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($member_count);
$rowCount = $stmt->num_rows;
$stmt->fetch();  
$stmt->close(); 

return $member_count;

}
//--------------------------------------------------------------------------------------------------------------------
function checkAccountStatus() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
  
    if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status function checkAccountStatus", $stmt->error);
      }
   
$stmt->close();    

$this->accountStatus = $account_status;

}
//--------------------------------------------------------------------------------------------------------------------
function insertRefundRecord()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO refund_records VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissd', $contractKey, $serviceKey , $refundType, $refundDate, $refundAmount);

$contractKey = $this->contractKey;
$serviceKey = $this->serviceKey; 
$refundType = $this->refundType;
$refundDate = date("Y-m-d H:m:s");
$refundAmount = $this->serviceCost;

if(!$stmt->execute())  {
	printf("Error: %s.\n  refund_records function insertRefundRecord", $stmt->error);
   }		

$stmt->close(); 



$user_id = 0;
$stmt = $dbMain ->prepare("SELECT user_id, MAX(signup_date) FROM monthly_services WHERE service_key='$this->serviceKey' AND contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($user_id, $signup_date);
$stmt->fetch();
  
    if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status function checkAccountStatus", $stmt->error);
      }
   
$stmt->close();    
if ($user_id == '0' OR $user_id == ''){
    $stmt = $dbMain ->prepare("SELECT user_id, MAX(signup_date) FROM paid_full_services WHERE service_key='$this->serviceKey' AND contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($user_id, $signup_date);
$stmt->fetch();
  
    if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status function checkAccountStatus", $stmt->error);
      }
   
$stmt->close();    
}

$dayStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($signup_date)),date('d',strtotime($signup_date)),date('Y',strtotime($signup_date))));
$dayEnd = date('Y-m-d H:i:s',mktime(23,59,59,date('m',strtotime($signup_date)),date('d',strtotime($signup_date)),date('Y',strtotime($signup_date))));



$stmt = $dbMain ->prepare("SELECT commission FROM commission_credit WHERE user_id = '$user_id' AND service_key='$this->serviceKey' AND (sale_date_time BETWEEN '$dayStart' AND '$dayEnd') LIMIT 1");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($commission);
$stmt->fetch();
  
    if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status function checkAccountStatus", $stmt->error);
      }
   
$stmt->close();    


$moniesRecovered = 'N';
$sql = "INSERT INTO commission_returns VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisds', $commissionKey, $this->contractKey , $user_id, $dayStart, $commission, $moniesRecovered);
if(!$stmt->execute())  {
	printf("Error: %s.\n  refund_records function insertRefundRecord", $stmt->error);
   }		

$stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------
function deleteServiceRefundHolds() {

$dbMain = $this->dbconnect();
$sql = "DELETE FROM service_refund_holds WHERE contract_key = ? AND service_key = ?  AND  refund_hold= ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("iis", $contractKey, $serviceKey, $refundHold);
			$contractKey = $this->contractKey; 
			$serviceKey = $this->serviceKey;
			$refundHold = $this->refundType;
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Error: %s. \n service_refund_holds  function deleteServiceRefundHolds ", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

}
//---------------------------------------------------------------------------------------------------------------------
function insertServiceRefundHolds() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO service_refund_holds VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisds', $contractKey, $serviceKey , $refundDate, $refundAmount, $refundHold);

$contractKey = $this->contractKey;
$serviceKey = $this->serviceKey; 
$refundDate = date("Y-m-d H:m:s");
$refundAmount = $this->serviceCost;
$refundHold = $this->serviceStatus;


if(!$stmt->execute())  {
	printf("Error: %s.\n  service_refund_holds  function insertServceRefundHolds", $stmt->error);
   }		

$stmt->close(); 

}

//--------------------------------------------------------------------------------------------------------------------
function insertServiceHold() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO service_hold VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisd', $contractKey, $serviceId, $serviceKey , $holdDate, $holdFee);

$contractKey = $this->contractKey;
$serviceId = $this->serviceId; 
$serviceKey = $this->serviceKey; 
$holdDate = date("Y-m-d H:m:s");
$holdFee = $this->holdFee;


if(!$stmt->execute())  {
	printf("Error: %s.\n  service_hold  function insertServceHold", $stmt->error);
   }		

$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateServiceStatus()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE account_status SET account_status= ? WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' AND service_id='$this->serviceId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $accountStatus);

$accountStatus = $this->serviceStatus;


 if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status  ", $stmt->error);
   }
   
       //if the ajax switch is set for 1 then do a direct return
         if($this->ajaxSwitch != null) {
               If($this->serviceStatus == 'CU') {
                   $this->loadServiceAdjustment();                            
                  }
                                    
             $success = 1;          
             return $success;
            }
   
             
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateGroupInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_groups SET group_name=?, group_address=? , group_phone=? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sss', $groupName, $groupAddress, $groupPhone);

$groupName = $this->groupName;
$groupAddress = $this->groupAddress;
$groupPhone = $this->groupPhone;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  member_groups  function updateGroupInfo", $stmt->error);
   }
   
 $stmt->close();  

}
//--------------------------------------------------------------------------------------------------------------------
function updateContractInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE contract_info SET first_name= ?, middle_name= ?, last_name= ?, street= ?, city= ?, state=?, zip= ?, primary_phone= ?, cell_phone= ?, email= ?, dob= ?, license_number= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssssisssss', $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primaryPhone, $cellPhone, $email, $dob, $licenseNumber);

$firstName = $this->firstName; 
$middleName = $this->middleName; 
$lastName = $this->lastName; 
$street = $this->streetAddress; 
$city = $this->cityName; 
$state = $this->stateValue; 
$zip = $this->zipCode; 
$primaryPhone = $this->primaryPhone; 
$cellPhone = $this->cellPhone; 
$email = $this->emailAddress; 
$dob = date("Y-m-d", strtotime($this->dob)); 
$licenseNumber = $this->licenseNumber; 


 if(!$stmt->execute())  {
	printf("Error: %s.\n  contract_info  function updateContractInfo", $stmt->error);
   }
   
 $stmt->close();

}

//==================================================================
function insertCancelRecord() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO service_cancel VALUES (?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisds', $contractKey, $serviceKey, $cancelDate, $cancelCost, $cancelType);

$contractKey = $this->contractKey;

if($this->cancelType == 'MB') {
   $serviceKey = 0;
   }else{
   $serviceKey = $this->serviceKey;
   }

$cancelDate = date("Y-m-d H:i:s"); 
$cancelCost = $this->cancelCost;
$cancelType = $this->cancelType;


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
$stmt->close(); 

$this->todaysPayment = $this->cancelCost;
$this->insertPaymentHistory();


}
//-----------------------------------------------------------------------------------------------------------------
function updateMonthlyBillingType() {

$dbMain = $this->dbconnect();
$sql = "UPDATE monthly_payments SET monthly_billing_type=? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $monthlyBillingType);

$monthlyBillingType = $this->monthlyBillingType;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments  function updateMonthlyBillingType", $stmt->error);
   }
             
$stmt->close(); 

}
//-----------------------------------------------------------------------------------------------------------------
function updateMonthlyPayments() {

$dbMain = $this->dbconnect();
$sql = "UPDATE monthly_payments SET billing_amount= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('d', $billingAmount);

$billingAmount = $this->monthlyDues;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments  function updateMonthlyPayments", $stmt->error);
   }
             
$stmt->close(); 


}
//-----------------------------------------------------------------------------------------------------------------
function updateMonthlyPaymentsTwo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE monthly_payments SET billing_amount= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('d', $this->newValue);
 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments  function updateMonthlyPayments", $stmt->error);
   }
             
$stmt->close(); 


}
//------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount, monthly_billing_type, cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $monthly_billing_type, $cycle_date);
$stmt->fetch();

$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $monthly_billing_type;
$this->cycleDate = $cycle_date;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments  function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}

//-------------------------------------------------------------------------------------------------------------------
function loadStartDate()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT start_date, end_date, signup_date, number_months FROM monthly_services WHERE contract_key ='$this->contractKey'  AND  service_key= '$this->serviceKey' AND service_id='$this->serviceId' ORDER BY signup_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($start_date, $end_date, $signup_date, $number_months);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close(); 

$this->startDate = $start_date;
$this->endDate = $end_date;
$this->signupDate = $signup_date;
$this->numberMonths = $number_months;

}
//--------------------------------------------------------------------------------------------------------------------
function parsePifProrates()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pro_rate_price FROM current_pif_upgrades WHERE contract_key ='$this->contractKey'  AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($pro_rate_price);
$stmt->fetch();
$stmt->close();



$this->serviceCost = $pro_rate_price;
$this->serviceStatus = 'CA';
$this->updateServiceStatus();
$this->insertServiceRefundHolds();

}
//--------------------------------------------------------------------------------------------------------------------
function parsePifServices()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_price FROM paid_full_services WHERE contract_key ='$this->contractKey'  AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($group_price);
$stmt->fetch();
$stmt->close();



$this->serviceCost = $group_price;
$this->serviceStatus = 'CA';                        
$this->updateServiceStatus();
$this->insertServiceRefundHolds();

}
//--------------------------------------------------------------------------------------------------------------------
function parseMonthlyProrates() {


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pro_rate_dues FROM current_monthly_upgrades WHERE contract_key ='$this->contractKey'  AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($pro_rate_dues);
$stmt->fetch();
$stmt->close();


//if there are no records for the current element look for a new prorate
if($rowCount == 0)  {
$stmt = $dbMain ->prepare("SELECT pro_rate_dues FROM new_monthly_upgrades WHERE contract_key ='$this->contractKey' AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($pro_rate_dues);
$stmt->fetch();
$stmt->close();
}


if($rowCount == 0)  {
$stmt = $dbMain ->prepare("SELECT monthly_dues FROM monthly_services WHERE contract_key ='$this->contractKey'   AND service_id='$this->serviceId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pro_rate_dues);
$rowCount = $stmt->num_rows;
$stmt->fetch();  
$stmt->close(); 
}
                        

//here we update the monthly payment and set the service status
$this->monthlyDues = $pro_rate_dues;
$this->loadMonthlyPayment();

if($this->monthlyPayment != '0.00') {
   $this->monthlyDues = $this->monthlyPayment - $this->monthlyDues;
   $this->updateMonthlyPayments();
  }

$this->serviceStatus = 'CA';
$this->updateServiceStatus();
$this->insertServiceRefundHolds();   
    
}
//------------------------------------------------------------------------------------------------------------------
function parseRefunds() {

 switch($this->refundType) {     
                        case"BNN":
                        $this->insertRefundRecord();
                        break; 
                        case"BNR":
                        $this->insertRefundRecord();
                        break; 
                        case"BNU":
                        $this->insertRefundRecord();
                        break;
                        case"NCF":
                        $this->insertRefundRecord();
                        break;
                        case"RNF":
                        $this->insertRefundRecord();
                        break;
                        case"UPF":
                        $this->insertRefundRecord();
                        break;
                        case"NMF":
                        $this->insertRefundRecord();
                        break;   
                        case"INF":
                        $this->insertRefundRecord();
                        break;
                        case"DNP":
                        $this->insertRefundRecord();
                        break; 
                        case"SMP":
                        $this->parseMonthlyProrates();
                        //$this->updateCsSubscriptions();
                        $this->loadCycleDate();
                        //$this->createCsSubscription();
                        $this->insertRefundRecord();                        
                        break; 
                        case"SPF":
                        $this->parsePifServices();
                        $this->insertRefundRecord();
                        break;  
                        case"SPP":                        
                        $this->parsePifProrates();
                        $this->insertRefundRecord();
                        break;    
                        case"AS":                        
                        $this->insertRefundRecord();
                        break;                         
                        
                        }             


/*
BNN = Bundled New Fee                                  
BNR = Bundled Renewal Fee
BNU = Bundled Upgrade Fees
NCF = New Contract Fee
RNF = Renewal Fee
UPF = Upgrade Fee
NMF = New Member Fee
INF = Initiation Fee
DNP = Down Payment
SMP = Service Monthly Prorate
SPF = Service Paid in Full
SPP = Service Paid Prorate

*/


}
//------------------------------------------------------------------------------------------------------------------
function parseMonthlyPayment() {

$this->monthlyDuesList = rtrim($this->monthlyDuesList, ",");
$monthlyDuesArray = explode(",", $this->monthlyDuesList);
$this->monthlyDues = array_sum($monthlyDuesArray);
$this->updateMonthlyPayments();  
//echo"<br><br>$this->monthlyDues";
}
//------------------------------------------------------------------------------------------------------------------
function parseMemberRefundsPif() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $signup_date, $transfer);
$stmt->fetch();

    
//get the original signup date so we can create the adjustment contract later
$this->originalSignUpDate = $signup_date;

//switch out the service id for the new insert
$serviceId = $this->serviceId;

//set the original group constant then calculate the new group number
$this->groupConstant = $group_number;
$group_number = $this->groupConstant - $this->memberCount;

//calculate the new group price the new renew rate
$group_price = $unit_price * $group_number;
$group_renew_rate = $unit_renew_rate * $group_number;

$signup_date = $this->signUpDate;


 if(!$stmt->execute())  {
	printf("Error: %s.\n  paid_full_services  function parseMemberRefundsPif select", $stmt->error);
    }
   
  $stmt->close();  

$this->checkAccountStatus();

if($this->accountStatus != 'CA') {

$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissisddddssiss', $serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $signup_date, $transfer);

if(!$stmt->execute())  {
	printf("Error: %s.\n  paid_full_services  function parseMemberRefundsPif insert", $stmt->error);
   }		

$stmt->close(); 

}

}
//------------------------------------------------------------------------------------------------------------------
function parseMemberRefundsMonthly() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM monthly_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id, $signup_date, $transfer);
$stmt->fetch();



//get the original signup date so we can create the adjustment contract later
$this->originalSignUpDate = $signup_date;

//switch out the service id for the new insert
$serviceId = $this->serviceId;

//set the original group constant then calculate the new group number
$this->groupConstant = $group_number;
$group_number = $this->groupConstant - $this->memberCount;

//calculate the new group price the new renew rate
$group_price = $unit_price * $group_number;
$group_renew_rate = $unit_renew_rate * $group_number;

//set these to 0 since they do not apply
$initiation_fee = '0.00';
$down_payment = '0.00';

//calculate the new monthly dues
$unitMonthlyDues =  $monthly_dues / $this->groupConstant;
$monthly_dues = $unitMonthlyDues * $group_number;

//calculate the new prorate dues. 
$unit_pro_rate_dues = $pro_rate_dues / $this->groupConstant;
$pro_rate_dues = $unit_pro_rate_dues * $group_number;

//$unit_pro_rate_dues = round($unit_pro_rate_dues, 2);

$signup_date = $this->signUpDate;

//sets up a list of the new monthly dues to update monthly payments
$this->monthlyDuesList .="$monthly_dues,";

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services  function parseMemberRefundsMonthly select", $stmt->error);
    }
   
  $stmt->close();  

$this->checkAccountStatus();

if($this->accountStatus != 'CA') {


$sql = "INSERT INTO monthly_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissiddddsddddssssiss' ,$serviceId, $contract_key, $group_type, $group_number, $service_key, $club_id, $service_name, $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id, $signup_date, $transfer);


if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services  function parseMemberRefundsMonthly insert", $stmt->error);
   }		

$stmt->close(); 

}

/*

echo"
<p>
CONTRACT KEY: $contract_key
<br> 
GROUP TYPE:  $group_type
<br> 
GROUP NUMBER:  $group_number
<br> 
SERVICE KEY:  $service_key
<br> 
CLUB ID:  $club_id
<br> 
SERVICE NAME:  $service_name
<br> 
NUMBER OF MONTHS:  $number_months
<br> 
UNIT PRICE:  $unit_price
<br> 
UNIT RENEW RATE:  $unit_renew_rate
<br> 
GROUP PRICE:  $group_price
<br>    
GROUP RENEW RATE:  $group_renew_rate
<br> 
TERM TYPE:  $term_type
<br> 
INITIATION FEE:  $initiation_fee
<br> 
DOWN PAYMENT:  $down_payment
<br> 
MONTHLY DUES:  $monthly_dues
<br> 
PRORATE DUES:  $pro_rate_dues
<br> 
PRO DATE START:  $pro_date_start
<br> 
PRO DATE END:  $pro_date_end
<br> 
START DATE:  $start_date
<br>
END DATE:  $end_date
<br> 
USER ID:  $user_id
<br> 
SIGNUP DATE:  $signup_date
<br> 
TRANSFER:  $transfer
</p>";  

*/


  

}
//------------------------------------------------------------------------------------------------------------------
function loadServiceRecords()  {

$keyListArray = explode(",", $this->keyListBilling);
$resultCount = count($keyListArray);
$resultCount = $resultCount - 1;
$i = 0;
while($i <= $resultCount)  {

             $key =  $keyListArray[$i];
             $this->serviceKey = substr("$key", 1); 
             $paidMonth = $key[0];
             
             if($paidMonth == 'M') {
                $this->parseMemberRefundsMonthly();
                }elseif($paidMonth == 'P') {
                $this->parseMemberRefundsPif();
                }
                          
        $i++;
        }



}
//-------------------------------------------------------------------------------------------------------------------
function loadMemberInfo() {
   $this->memberArray .= "$this->generalId|";
   $this->memberRefundArray .= "$this->memberRefund|";
}
//-------------------------------------------------------------------------------------------------------------------
function deleteContractMembers() {

//this deletes members based on refunds fron services if within the grace period. member count is what needs to be deleted from after the refund adjustment

if($this->groupNumber < $this->memberCount) {
   $delete_count = $this->memberCount - $this->groupNumber;


$dbMain = $this->dbconnect();
$sql ="DELETE FROM member_info WHERE contract_key = ? ORDER BY general_id DESC LIMIT $delete_count";

if($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $contractKey);
			$contractKey = $this->contractKey; 
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}


  }
}
//-------------------------------------------------------------------------------------------------------------------
function deleteMember() {

//this deletes individual members based on thier general id 
$dbMain = $this->dbconnect();
$sql = "DELETE FROM member_info WHERE contract_key = ? AND general_id = ? ";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $contractKey, $generalId);
			$contractKey = $this->contractKey; 
			$generalId = $this->generalId;
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

}
//===========================================================
function parseMemberRefunds() {

//create a common signup date
$this->signUpDate = date("Y-m-d H:m:s");

//first we delete the members from the member table
$memberListArray = explode("|", $this->memberArray);
$memberCount = count($memberListArray);
$this->memberCount = $memberCount - 1;
$i = 0;
while($i <= $this->memberCount)  {

          $this->generalId = $memberListArray[$i];
          $this->deleteMember();
             
          $i++;
         }
//+++++++++++++++++++++++++++

//here we enter the amounts into the member refund table
$memberRefundListArray = explode("|", $this->memberRefundArray);
$memberRefundCount = count($memberRefundListArray);
$refundCount = $memberRefundCount;
$j = 0;
while($j <= $refundCount) {
         
          $this->cancelCost = $memberRefundListArray[$j];
          $this->cancelType = 'MB';
          if($this->cancelCost != "") {
             $this->insertCancelRecord();
             }
          
          $j++;          
         }


//++++++++++++++++++++++++++++
// we load the service tables and create a new record and update the monthly payment       

$this->loadServiceRecords();
$this->createAdjustmentContract();
$this->parseMonthlyPayment();


}
//-------------------------------------------------------------------------------------------------------------------
function createAdjustmentContract() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT user_id, transfer, club_id, contract_location, contract_terms, pay_quit, host_type, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number, grace_period FROM contract_info WHERE  contract_key = '$this->contractKey' AND signup_date = '$this->originalSignUpDate'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $transfer, $club_id, $contract_location, $contract_terms, $pay_quit, $host_type, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $dob, $license_number, $grace_period);
 $stmt->fetch();


$contract_id = $this->contractId;
$contract_key = $this->contractKey;
$contract_type = 'A';
$signup_date = $this->signUpDate;
$contract_date = date("Y-m-d");
$contract_html = 'NA';


//we set this to 0 since their will be no refund
$pay_quit = 0;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  contract_info function createAdjustmentContract  select", $stmt->error);
    }
   
  $stmt->close();  


$sql = "INSERT INTO contract_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssisssisssssssisssssis', $contract_id, $user_id, $contract_key, $contract_type, $transfer, $signup_date, $club_id, $contract_location, $contract_date, $contract_terms, $pay_quit, $host_type, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $dob, $license_number, $grace_period, $contract_html);



if(!$stmt->execute())  {
	printf("Error: %s.\n  contract_info function createAdjustmentContract  insert", $stmt->error);
   }		

$stmt->close(); 


}
//-------------------------------------------------------------------------------------------------------------------
function cancelServices() {

     //first check to see if this is a monthly service then adjust the monthly payment
     if($this->monthlyDues != 0) {
           $this->loadMonthlyPayment();
           $this->checkServiceType();
           $this->monthlyDues = $this->monthlyPayment - $this->monthlyDues;
           $this->updateMonthlyPayments();
       }
       
       $this->cancelType = 'SE';
       $this->serviceStatus = 'CA';
       $this->insertCancelRecord();       
       $this->updateServiceStatus();

}
//-----------------------------------------------------------------------------------------------------------------
function holdServices() {

     //first check to see if this is a monthly service then adjust the monthly payment
     if($this->monthlyDues != 0) {
           $this->loadMonthlyPayment();
           if($this->monthlyBillingType == 'CR' || $this->monthlyBillingType == 'BA') {              
              $this->csHoldBit = 1;                            
             }else{
              $this->csHoldBit = 2; 
             }
       }
//echo"
//$this->monthlyPayment <br>
//$this->monthlyBillingType <br>
//$this->cycleDate <br>";
//exit;


       $this->updateServiceStatus();
       $this->insertServiceHold();
       
}
//-----------------------------------------------------------------------------------------------------------------
function holdMember() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_hold VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiis', $contract_key, $general_id, $member_id, $hold_date);

if($this->memberId == 'Unassigned') {
   $this->memberId = 0;
   }
   
$contract_key = $this->contractKey;
$general_id = $this->generalId;
$member_id = $this->memberId;
$hold_date = date("Y-m-d H:m:s");



if(!$stmt->execute())  {
	printf("Error: %s.\n  member_hold function holdMember  insert", $stmt->error);
   }		

$stmt->close(); 

}
//----------------------------------------------------------------------------------------------------------------
function deleteMemberHold() {

$dbMain = $this->dbconnect();
$sql = "DELETE FROM member_hold WHERE contract_key = ? AND general_id = ? ";

	   	if($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $contractKey, $generalId);
			$contractKey = $this->contractKey; 
			$generalId = $this->generalId;
			$stmt->execute();
			$stmt->close();
			
			   // handles ajax cancelation
			 if($this->ajaxSwitch != null) {
			    $success = 1;
			    return $success;
			   }
			
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}




}
//----------------------------------------------------------------------------------------------------------------
function deleteRejectionFee() {

$dbMain = $this->dbconnect();
$sql = "DELETE FROM rejected_payments WHERE contract_key = ? AND history_key = ? ";

	   	if($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->contractKey, $this->historyKey);
			$stmt->execute();
			$stmt->close();
            $success = 1;
            return $success;
   
			
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}




}
//----------------------------------------------------------------------------------------------------------------
function parseCreditServiceTerm() {

if($this->addSubBool == 1){
    switch($this->serviceCreditTerm) {     
                        case"C":
                        $credit_term = 'C';
                        $credit_sec_num = $this->serviceCreditNumber;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = 2050;
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year));

                        break; 
                        case"D":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 86400;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day+$this->serviceCreditNumber, $year));

                        break; 
                        case"W":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 604800;   
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day+($this->serviceCreditNumber*7), $year));
                        break; 
                        case"M":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 2628000;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month+$this->serviceCreditNumber,$day, $year));
                        break; 
                        case"Y":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 31556926;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year+$this->serviceCreditNumber));
                        break; 
                      }
}elseif($this->addSubBool == 2){
    switch($this->serviceCreditTerm) {     
                        case"C":
                        $credit_term = 'C';
                        $credit_sec_num = $this->serviceCreditNumber;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = 2050;
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year));

                        break; 
                        case"D":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 86400;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day-$this->serviceCreditNumber, $year));

                        break; 
                        case"W":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 604800;   
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day-($this->serviceCreditNumber*7), $year));
                        break; 
                        case"M":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 2628000;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month-$this->serviceCreditNumber,$day, $year));
                        break; 
                        case"Y":
                        $credit_term = 'T';
                        $credit_sec_num = $this->serviceCreditNumber * 31556926;
                        $credit_date = date("Y-m-d H:m:s");
                        $year = date("Y");
                        $month = date("m");
                        $day = date("d");
                        $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year-$this->serviceCreditNumber));
                        break; 
                      }
}
//if it is not a class we change everything to seconds so we can use just one record for eithe an insert or an update
 

//check for an existing record
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT credit_term, credit_sec_num FROM service_credits WHERE contract_key='$this->contractKey' AND service_id='$this->serviceId' AND service_key='$this->serviceKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($credit_term_stored, $credit_sec_num_stored);
$rowCount = $stmt->num_rows;
$stmt->fetch();  
$stmt->close(); 

//if the row count is 0 then we do an insert if not we do an upgrade
if($rowCount == 0 AND $this->addSubBool == 1) {

   $sql = "INSERT INTO service_credits VALUES (?,?,?,?,?,?,?)";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('iiiisss', $contract_key, $service_id, $service_key, $credit_sec_num, $credit_term, $credit_date, $credit_end);

   $contract_key = $this->contractKey;
   $service_id = $this->serviceId;
   $service_key = $this->serviceKey;
   
   if(!$stmt->execute())  {
	  printf("Error: %s.\n  service_credits function parseCreditServiceTerm  insert", $stmt->error);
     }		
     $stmt->close(); 
     
     $credit_seconds_total = $credit_sec_num;

}elseif($this->addSubBool == 1){
  
//$credit_seconds_total = $credit_sec_num + $credit_sec_num_stored;
$credit_seconds_total = $credit_sec_num;

 switch($this->serviceCreditTerm) {     
                        case"C":
                            $year = 2050;
                            $month = date("m");
                            $day = date("d");
                            $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year));
                        break;
                        case"D":
                            $days = $credit_seconds_total / 86400;
                            $year = date("Y");
                            $month = date("m");
                            $day = date("d");
                            $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day+$days, $year));
                        break; 
                        case"W":
                            $weeks = $credit_seconds_total / 604800;  
                            $year = date("Y");
                            $month = date("m");
                            $day = date("d");
                            $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day+($weeks*7), $year));
                        break; 
                        case"M":
                            $months = $credit_seconds_total / 2628000;
                            $year = date("Y");
                            $month = date("m");
                            $day = date("d");
                            $credit_end = date("Y-m-d",mktime(0,0,0,$month+$months,$day, $year));
                        break; 
                        case"Y":
                            $years = $credit_seconds_total / 31556926;
                            $year = date("Y");
                            $month = date("m");
                            $day = date("d");
                            $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $years));
                        break; 
                      }
                      }elseif($this->addSubBool == 2){
  
                        $credit_seconds_total = 0 - $credit_sec_num;//$credit_sec_num_stored - $credit_sec_num;
                        
                         switch($this->serviceCreditTerm) {     
                                case"C":
                                    $year = 2050;
                                    $month = date("m");
                                    $day = date("d");
                                    $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $year));
                                break;
                                case"D":
                                    $days = $credit_seconds_total / 86400;
                                    $year = date("Y");
                                    $month = date("m");
                                    $day = date("d");
                                    $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day-$days, $year));
                                break; 
                                case"W":
                                    $weeks = $credit_seconds_total / 604800;  
                                    $year = date("Y");
                                    $month = date("m");
                                    $day = date("d");
                                    $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day-($weeks*7), $year));
                                break; 
                                case"M":
                                    $months = $credit_seconds_total / 2628000;
                                    $year = date("Y");
                                    $month = date("m");
                                    $day = date("d");
                                    $credit_end = date("Y-m-d",mktime(0,0,0,$month-$months,$day, $year));
                                break; 
                                case"Y":
                                    $years = $credit_seconds_total / 31556926;
                                    $year = date("Y");
                                    $month = date("m");
                                    $day = date("d");
                                    $credit_end = date("Y-m-d",mktime(0,0,0,$month,$day, $years));
                                break; 
                              }
                              }
$credit_date = date("Y-m-d H:m:s");


$sql = "UPDATE service_credits SET credit_sec_num= ?, credit_date= ?, credit_end= ? WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' AND service_id='$this->serviceId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iss', $credit_seconds_total, $credit_date, $credit_end);

if(!$stmt->execute())  {
	  printf("Error: %s.\n  service_credits function parseCreditServiceTerm  upgrade", $stmt->error);
     }		
     $stmt->close(); 



$update = new serviceCreditCS();
$update-> setBool($this->addSubBool);
$update-> setMonthlybillingType($this->monthlyBillingType);
$update-> setCreditSecs($credit_seconds_total);
$update-> setContractKey($this->contractKey);
$update-> setServiceTerm($this->serviceCreditTerm);
$update-> setServiceKey($this->serviceKey);
$update->moveData();


}
//---------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {
$this->loadBillingDay();
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT COUNT(contract_key) as contractCount, next_payment_due_date FROM monthly_settled WHERE contract_key='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($contractCount, $next_payment_due_date);
$stmt->fetch();  
$stmt->close();

$stmt = $dbMain->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->cycleDate); 
    $stmt->fetch();
    $stmt->close();
    
     $customerBillingDate = date('d',strtotime($this->cycleDate));
                    
     if(date('d') < $customerBillingDate){
        $mStart = date('m')-1;//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
     }elseif(date('d') == $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
     }elseif(date('d') > $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
                    }


$settledM = date('m',strtotime($next_payment_due_date));
$settledD = date('d',strtotime($next_payment_due_date));
$settledY = date('Y',strtotime($next_payment_due_date));

$billCycStart = date('Y-m-d H:i:s',mktime(23,59,59,$settledM,$settledD - $this->pastDay,$settledY));

$cycM = date('m',strtotime($billCycStart));
$cycD = date('d',strtotime($billCycStart));
$cycY = date('Y',strtotime($billCycStart));



$curM = date('m');
$curD = date('d');
$curY = date('Y');

 $paymentDate = date("Y-m-d H:i:s");
         
 
         
 if (date('d') <= $cycD AND $curM != $mStart){
    $nextPaymentDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $curM  , $cycD+$this->pastDay, $curY));//$cycD
 }else if (date('d') <= $cycD AND $curM == $mStart){
    $nextPaymentDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59,$curM+1  , $cycD+$this->pastDay, $curY));
 }else if (date('d') > $cycD){ //AND $curM == $mStart
    $nextPaymentDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $curM+1  , $cycD+$this->pastDay, $curY));
 }
 
 /*$nextMonthsBillingDateSecs = strtotime($nextMonthsBillingDate);
 $pastDaysDueSecs = $this->pastDay * 86400;
 $nextPaymentDueDateSecs = $nextMonthsBillingDateSecs + $pastDaysDueSecs;
 $nextPaymentDueDate = date("Y-m-d H:i:s",  $nextPaymentDueDateSecs);*/
        
 $transType = $this->transType;//'CR';
        


if ($contractCount > 0){
        
        $sql = "UPDATE monthly_settled SET next_payment_due_date= ?, payment_date = ? WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ss', $nextPaymentDueDate, $paymentDate);
        
        if(!$stmt->execute())  {
        	  printf("Error: %s.\n  update ms", $stmt->error);
             }		
             $stmt->close(); 
    
}else{
    

        $sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iidsss', $this->contractKey, $this->authIdReference, $this->todaysPayment, $paymentDate, $nextPaymentDueDate, $transType);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
           }		
        $stmt->close(); 
}





}

//---------------------------------------------------------------------------------------------------------------
function updateMonthlySettled() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date)  FROM monthly_settled WHERE contract_key='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($nextPaymentDueDate);
$stmt->fetch();  
$numRows = $stmt->num_rows;
$stmt->close(); 

$nextPaymentDueDate = trim($nextPaymentDueDate);

if($nextPaymentDueDate != "") {

   $sql = "UPDATE monthly_settled SET next_payment_due_date= ? WHERE contract_key = '$this->contractKey' AND next_payment_due_date = '$nextPaymentDueDate' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('s', $next_payment_due);

   $next_payment_due = $this->nextPaymentDueDate;

   if(!$stmt->execute())  {
	  printf("Error: %s.\n  service_credits function parseCreditServiceTerm  upgrade", $stmt->error);
     }		
     $stmt->close(); 
      
  }


}
//---------------------------------------------------------------------------------------------------------------
function deletePastDueAttempts()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("DELETE FROM past_due_attempts WHERE contract_key = '$this->contractKey' ");
$stmt->execute();  


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

}

//---------------------------------------------------------------------------------------------------------------
function loadCancelHoldHistory() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO cancel_hold_history VALUES (?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidddss', $chId, $contractKey, $refundTotal, $cancelTotal, $holdTotal, $chType, $chDate);

$chId = "";
$contractKey = $this->contractKey;
$refundTotal = $this->refundTotal;

if($this->chType == 'CM') {
  $cancelTotal = $this->cancelCost;
  }elseif($this->chType == 'CA') {
  $cancelTotal = $this->cancelTotal;
  }else{
  $cancelTotal = null;
  }

$holdTotal = $this->holdTotal;
$chType = $this->chType;
$chDate = date("Y-m-d H:i:s");


if(!$stmt->execute())  {
	printf("Error: %s.\n function loadCancelHoldHistory table cancel_hold_history", $stmt->error);
   }		
$stmt->close(); 


}
//---------------------------------------------------------------------------------------------------------------
function createNewPifEndDate() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key ='$this->contractKey'  AND service_id= '$this->serviceId' AND service_key ='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$stmt->bind_result($endDate);
$stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n function createNewPifEndDate paid_full_services", $stmt->error);
   }		
$stmt->close();

//weeds out classes
if($endDate != '0000-00-00 00:00:00') {

   $stmt = $dbMain ->prepare("SELECT MAX(hold_date) FROM service_hold WHERE contract_key ='$this->contractKey'  AND service_id='$this->serviceId' AND service_key='$this->serviceKey'");
   $stmt->execute();      
   $stmt->store_result(); 
   $stmt->bind_result($holdDate);
   $stmt->fetch();
   
  if(!$stmt->execute())  {
	printf("Error: %s.\n function createNewPifEndDate service_hold", $stmt->error);
   }		
$stmt->close(); 

  $endDateSecs = strtotime($endDate);
  $holdDateSecs = strtotime($holdDate);
  $dateDiff = $endDateSecs - $holdDateSecs;
  $todaysDateSecs = time();
  $newExpDateSecs = $todaysDateSecs + $dateDiff;
  $newExpDate = date("Y-m-d H:i:s", $newExpDateSecs);

  }else{
  $newExpDate = '0000-00-00 00:00:00';
  }
  
$sql = "UPDATE paid_full_services SET end_date= ? WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' AND service_id='$this->serviceId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $endDate);

$endDate = $newExpDate;

 if(!$stmt->execute())  {
	printf("Error: %s.\n update pif  ", $stmt->error);
   }  
$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------------------
function createNewMonthlyEndDate() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT MAX(end_date) FROM monthly_services WHERE contract_key ='$this->contractKey'  AND service_id= '$this->serviceId' AND service_key ='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$stmt->bind_result($endDate);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT MAX(hold_date) FROM service_hold WHERE contract_key ='$this->contractKey'  AND service_id='$this->serviceId' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$stmt->bind_result($holdDate);
$stmt->fetch();

//check the exp date to see if it has expired, if not then we update with the new exp date
   $endDateSecs = strtotime($endDate);
   $holdDateSecs = strtotime($holdDate);
   
   if($endDateSecs > $holdDateSecs) {
   
      $dateDiff = $endDateSecs - $holdDateSecs;
      $todaysDateSecs = time();
      $newExpDateSecs = $todaysDateSecs + $dateDiff;
      $newExpDate = date("Y-m-d H:i:s", $newExpDateSecs);
      
      $sql = "UPDATE monthly_services SET end_date= ? WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' AND service_id='$this->serviceId' ";
      $stmt = $dbMain->prepare($sql);
      $stmt->bind_param('s', $endDate);

      $endDate = $newExpDate;

       if(!$stmt->execute())  {
        	printf("Error: %s.\n update pif  ", $stmt->error);
         }  
       $stmt->close();      
            
     }


}
//#########################################################################

function getMonthlyDues() {
             return($this->monthlyDues);
             }
function getMonthlyPayment() {
             return($this->monthlyPayment);
             }             
function getMemberCount() {
             return($this->memberCount);
             }
function getProRateDues() {
             return($this->proRateDues);
             }
function getTotalProRateDues() {
             return($this->totalProRateDues);
             }
function getCsHoldBit() {
             return($this->csHoldBit);
             }
function getMonthlyBillingType() {
             return($this->monthlyBillingType);
             }  
function getMembershipMatch() {
             return($this->membershipMatch);
             }                 
      
             

}  //end of the class
//=========================================================================

   $ajax_switch  = $_REQUEST['ajax_switch'];
   $contract_key3  = $_REQUEST['contract_key3'];
   $member_id  = $_REQUEST['member_id'];
   $general_id  = $_REQUEST['general_id'];
   $street_address  = $_REQUEST['street_address'];
   $city  = $_REQUEST['city'];
   $state  = $_REQUEST['state'];
   $zip_code  = $_REQUEST['zip_code'];
   $home_phone  = $_REQUEST['home_phone'];
   $email  = $_REQUEST['email'];
   $lic_num  = $_REQUEST['lic_num'];
   $hold_check_array = $_REQUEST['hold_check_array'];
   $history_key = $_REQUEST['history_key'];
   $newValue = $_REQUEST['newValue'];
//this is for the case of an ajax call to release a hold on an existing service
if($ajax_switch == 1) {  

   $updateAccountHold = new updateAccountInfo();
  
   
   $street_address = urldecode($street_address);
   $city = urldecode($city);
   $state = urldecode($state);
   $zip_code = urldecode($zip_code);
   $home_phone = urldecode($home_phone);
   $email = urldecode($email);
   $lic_num = urldecode($lic_num);
   
   $updateAccountHold-> setStreetAddress($street_address);
   $updateAccountHold-> setCityName($city);
   $updateAccountHold-> setStateValue($state);
   $updateAccountHold-> setZipCode($zip_code);
   $updateAccountHold-> setPrimaryPhone($home_phone);
   $updateAccountHold-> setEmailAddress($email);
   $updateAccountHold-> setLicenseNumber($lic_num);
   
   
   $hold_check_array = rtrim($hold_check_array, "@");
   $hold_check_array = explode('@', $hold_check_array);
   $length = count($hold_check_array);
    
   for ($i = 0; $i <= $length; $i++) { 
   
        $holdValues = $hold_check_array[$i];
        $holdValueArray = explode('|', $holdValues);
        $contract_key2 = $holdValueArray[1];
        $service_key = $holdValueArray[2];
        $service_status ='CU';
        $monthly_dues = $holdValueArray[4];        
        $service_id = $holdValueArray[5];
      
         if($service_id != "") {
            $updateAccountHold-> setContractKey($contract_key2);
            $updateAccountHold-> setServiceKey($service_key);
            $updateAccountHold-> setServiceStatus($service_status);
            $updateAccountHold-> setServiceCost($monthly_dues);
            $updateAccountHold-> setServiceId($service_id);
            $success = $updateAccountHold-> updateServiceStatus();  
           
          //if it is a paid full service set the monthly dues to 0 since it is null in the array
           if($monthly_dues == "") {
              $updateAccountHold-> createNewPifEndDate();
              }else{
              $updateAccountHold-> createNewMonthlyEndDate();
              $monthlyBit = 1;
              }
           
            }  
       
       }//end for loop

         //if it is a monthly service then find billing type and process the cs recursive if needed
       if($monthlyBit == 1)  {
          $updateAccountHold-> loadMonthlyPayment();
          $monthlyBillingType =  $updateAccountHold-> getMonthlyBillingType();
          
                    if($monthlyBillingType == 'CR' || $monthlyBillingType == 'BA') {
                       $monthlyPayment = $updateAccountHold-> getMonthlyPayment();
                       $updateAccountHold-> setMonthlyDues($monthlyPayment);                    
                       //$updateAccountHold-> checkDeleteMonthly();
                       $updateAccountHold-> loadCycleDate();
                       //$updateAccountHold-> createCsSubscription();  
                       $updateAccountHold-> updateMonthlySettled();                    
                      }else{
                       $updateAccountHold-> loadCycleDate();
                       $updateAccountHold-> updateMonthlySettled();                                            
                      }
       
         }


$success = 1; 
echo"$success";

}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++
//this handles hold release on members
if($ajax_switch == 2) {  

   $updateMemberHold = new updateAccountInfo();
   $updateMemberHold-> setAjaxSwitch($ajax_switch);
   $updateMemberHold-> setContractKey($contract_key3);
   $updateMemberHold-> setGeneralId($general_id);
   $updateMemberHold-> setMemberId($member_id);
   $success = $updateMemberHold-> deleteMemberHold();
   
   echo"$success";

}


if($ajax_switch == 3) {  

   $deleteFee = new updateAccountInfo();
   $deleteFee-> setContractKey($contract_key3);
   $deleteFee-> setHistoryKey($history_key);
   $success = $deleteFee-> deleteRejectionFee();
   
   echo"$success";

}

if($ajax_switch == 4) {  

   $update = new updateAccountInfo();
   $update-> setContractKey($contract_key3);
   $update-> setNewMonthlyValue($newValue);
   $success = $update-> updateMonthlyPaymentsTwo();
   
   echo"$success";
//<input type="checkbox" name="change_monthly_payment" id="change_monthly_payment" onClick="changeMonthlyPayment($this->contractKey, $this->userId);"/>
}

//NOTES
//we will need to add adjustments for authorise.net 

?>





