<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class saveIndiPayrollSql {

private $userId = null;
private $typeKey = null;
private $addSubOne = null;
private $addSubDescOne = null;
private $addSubAmountOne = null;
private $saveMarkerOne = null;
private $addSubTwo = null;
private $addSubDescTwo = null;
private $addSubAmountTwo = null;
private $saveMarkerTwo = null;
private $addSubThree = null;
private $addSubDescThree = null;
private $addSubAmountThree = null;
private $saveMarkerThree = null;
private $addSubFour = null;
private $addSubDescFour = null;
private $addSubAmountFour = null;
private $saveMarkerFour = null;

private $commissionTotal = null;
private $basePaymentAmount = null;
private $totalPaymentAmount = null;
private $salary = null;
private $hourlyWages = null;
private $hoursProjected = null;
private $totalHours = null;
private $subTotal = null;
private $paymentCycle = null;
private $compensationType = null;
private $employeeName = null;
private $saveAddSub = null;
private $paymentDate = null;
private $closeDate = null;
private $baseProrateAmount = null;
private $consolidate = null;
private $bookKeeping = null;
private $confirmatonMessage = "There was an error processing this request";
private $OT = null;
private $overtimeTier2 = null;
private $clubId = null;

function setUserId($userId) {
      $this->userId = $userId;
      }
function setTypeKey($typeKey) {
      $this->typeKey = $typeKey;
      }
function setAddSubOne($addSubOne) {
      $this->addSubOne = $addSubOne;
      }
function setAddSubDescOne($addSubDescOne) {
      $this->addSubDescOne = $addSubDescOne;
      }
function setAddSubAmountOne($addSubAmountOne) {
      $this->addSubAmountOne = $addSubAmountOne;
      }
function setSaveMarkerOne($saveMarkerOne) {
      $this->saveMarkerOne = $saveMarkerOne;
      }
function setAddSubTwo($addSubTwo) {
      $this->addSubTwo = $addSubTwo;
      }
function setAddSubDescTwo($addSubDescTwo) {
      $this->addSubDescTwo = $addSubDescTwo;
      }
function setAddSubAmountTwo($addSubAmountTwo) {
      $this->addSubAmountTwo = $addSubAmountTwo;
      }
function setSaveMarkerTwo($saveMarkerTwo) {
      $this->saveMarkerTwo = $saveMarkerTwo;
      }
function setAddSubThree($addSubThree) {
      $this->addSubThree = $addSubThree;
      }
function setAddSubDescThree($addSubDescThree) {
      $this->addSubDescThree = $addSubDescThree;
      }
function setAddSubAmountThree($addSubAmountThree) {
      $this->addSubAmountThree = $addSubAmountThree;
      }
function setSaveMarkerThree($saveMarkerThree) {
      $this->saveMarkerThree = $saveMarkerThree;
      }
function setAddSubFour($addSubFour) {
      $this->addSubFour = $addSubFour;
      }
function setAddSubDescFour($addSubDescFour) {
      $this->addSubDescFour = $addSubDescFour;
      }
function setAddSubAmountFour($addSubAmountFour) {
      $this->addSubAmountFour = $addSubAmountFour;
      }
function setSaveMarkerFour($saveMarkerFour) {
      $this->saveMarkerFour = $saveMarkerFour;
      }
  
  
  
function setCommissionTotal($commissionTotal) {
      $this->commissionTotal = $commissionTotal;
      }      
function setSalary($salary) {
      $this->salary = $salary;
      }
function setHourlyWages($hourlyWages) {  
      $this->hourlyWages = $hourlyWages;
      }
      
function setOT($OT) {  
      $this->OT = $OT;
      }      

function setOTDoubTime($OTDoubTime) {  
      $this->overtimeTier2  = $OTDoubTime;
      }            
function setBaseProrateAmount($baseProrateAmount){
        $this->baseProrateAmount = $baseProrateAmount;
        }      
      
function setHoursProjected($hoursProjected) {
      $this->hoursProjected = $hoursProjected;
      }
function setTotalHours($totalHours) {
      $this->totalHours = $totalHours;
      }
function setSubTotal($subTotal) {
      $this->subTotal = $subTotal;
      }
function setPaymentCycle($paymentCycle) {
      $this->paymentCycle = $paymentCycle;
      }
function setCompensationType($compensationType) {
      $this->compensationType = $compensationType;
      }
function setEmployeeName($employeeName) {
      $this->employeeName = $employeeName;
      }
function setSaveAddSub($saveAddSub) {
      $this->saveAddSub = $saveAddSub;
      }
      
function setConsolidate($consolidate) {
      $this->consolidate = $consolidate;
      }
function setBookKeeping($bookKeeping) {
      $this->bookKeeping = $bookKeeping;
      }

function setClubId($clubId) {
      $this->clubId = $clubId;
     }
     
function setPtInfo($ptPayrollData) {
      $this->ptInfo = $ptPayrollData;
      }

function setPtTaInfo($ptPayrollDataTa) {
      $this->ptTaInfo = $ptPayrollDataTa;
     }
function setBonusPayout($bonus_payout) {
      $this->bonusPayout = $bonus_payout;
      }

function setCommissionReturnTot($commissReturnTot) {
      $this->commisshReturn = $commissReturnTot;
     }     
     
     
     
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------
function saveToBookKeeping() {

if($this->bookKeeping != 0) {
   if($this->bookKeeping == 1) {
   
   
       echo"$this->bookKeeping";
       exit;








   }
}
}
//----------------------------------------------------------------------------------------------
function parseCompensation() {

switch ($this->compensationType) {
    case "S":
    $this->commissionTotal = 0;
    $this->basePaymentAmount = $this->salary;
    break;
    case "H": 
    $this->commissionTotal = 0;
    $this->basePaymentAmount = $this->hourlyWages;
    $this->commissionTotal = 0;
    break;
    case "C":
    $this->commissionTotal = $this->commissionTotal;
    $this->basePaymentAmount = 0;
    break;
    case "SC":
    $this->commissionTotal = $this->commissionTotal;
    $this->basePaymentAmount = $this->salary;
    break;
    case "HC":
    $this->commissionTotal = $this->commissionTotal;
    $this->basePaymentAmount = $this->hourlyWages;
    }

}
//----------------------------------------------------------------------------------------------
function parseTotalPaymentAmount() {

   $totalBasePayment = $this->commissionTotal + $this->basePaymentAmount;
      
switch ($this->addSubOne) {
    case "E":
    $totalBasePayment = $totalBasePayment;
    break;
    case "A": 
    $totalBasePayment =  $totalBasePayment + $this->addSubAmountOne; 
    break; 
    case "S":
    $totalBasePayment =  $totalBasePayment - $this->addSubAmountOne;
    break;
    }

switch ($this->addSubTwo) {
    case "E":
    $totalBasePayment = $totalBasePayment;
    break;
    case "A": 
    $totalBasePayment =  $totalBasePayment + $this->addSubAmountTwo; 
    break; 
    case "S":
    $totalBasePayment =  $totalBasePayment - $this->addSubAmountTwo;
    break;
    }

switch ($this->addSubThree) {
    case "E":
    $totalBasePayment = $totalBasePayment;
    break;
    case "A": 
    $totalBasePayment =  $totalBasePayment + $this->addSubAmountThree; 
    break; 
    case "S":
    $totalBasePayment =  $totalBasePayment - $this->addSubAmountThree;
    break;
    }

switch ($this->addSubFour) {
    case "E":
    $totalBasePayment = $totalBasePayment;
    break;
    case "A": 
    $totalBasePayment =  $totalBasePayment + $this->addSubAmountFour; 
    break; 
    case "S":
    $totalBasePayment =  $totalBasePayment - $this->addSubAmountFour;
    break;
    }

$this->totalPaymentAmount = $totalBasePayment;

}

//----------------------------------------------------------------------------------------------
function saveSettled() {
    
$ptArray = explode(',',$this->ptInfo);
$this->sessionsPerformed = $ptArray[0];
$this->trainingOnClockHours = $ptArray[1];
$this->ptTotal = $ptArray[2];
$this->extraPerformanceMoney = $ptArray[3];

$ptArray2 = explode(',',$this->ptTaInfo);
$this->sessionsPerformedTA = $ptArray2[0];
$this->assesmentsOFFClockHours = $ptArray2[1];
$this->ptTotalTA = $ptArray2[2];



$this->parseCompensation();
$this->parseTotalPaymentAmount();
$this->paymentDate = date("Y-m-d H:i:s");
$todaysDate = date("Y-m-d");
$dayOfMonth = date("j", strtotime($todaysDate));
$month = date("n", strtotime($todaysDate));
$year = date("Y", strtotime($todaysDate));
$this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year));;

$userId = $this->userId;
$typeKey = $this->typeKey;
$paymentCycle = $this->paymentCycle;
$compType = $this->compensationType;
$hoursProjected = $this->hoursProjected;
$totalHours = $this->totalHours;
$addSubOne = $this->addSubOne;
$addSubDescOne = $this->addSubDescOne;
$addSubAmountOne = $this->addSubAmountOne;
$addSubTwo = $this->addSubTwo;
$addSubDescTwo = $this->addSubDescTwo;
$addSubAmountTwo = $this->addSubAmountTwo;
$addSubThree = $this->addSubThree;
$addSubDescThree = $this->addSubDescThree;
$addSubAmountThree = $this->addSubAmountThree;
$addSubFour = $this->addSubFour;
$addSubDescFour = $this->addSubDescFour;
$addSubAmountFour = $this->addSubAmountFour;
$commissionAmount = $this->commissionTotal;
$basePaymentAmount = $this->basePaymentAmount;
$OT = $this->OT;
$otHoursTier2 = $this->overtimeTier2;
$baseProrateAmount = $this->baseProrateAmount;
$totalPaymentAmount = $this->totalPaymentAmount;
$paymentDate = $this->paymentDate;
$closeDate = $this->closeDate;
$consolidate = $this->consolidate;
$clubId = $this->clubId;

//echo "fubar test $userId, $typeKey, $paymentCycle, $compType, $hoursProjected, $totalHours, $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour, $commissionAmount, $basePaymentAmount, $otHoursTier2, $OT, $baseProrateAmount, $totalPaymentAmount, $paymentDate, $closeDate, $consolidate, $clubId, $this->sessionsPerformed, $this->ptTotal, $this->extraPerformanceMoney, $this->trainingOnClockHours, $this->sessionsPerformedTA, $this->ptTotalTA, $this->assesmentsOFFClockHours, $this->commisshReturn, $this->bonusPayout";

$dbMain = $this->dbconnect();
$sql = "INSERT INTO payroll_settled VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissiissdssdssdssdddddddsssiddddddddd', $userId, $typeKey, $paymentCycle, $compType, $hoursProjected, $totalHours, $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour, $commissionAmount, $basePaymentAmount, $otHoursTier2, $OT, $baseProrateAmount, $totalPaymentAmount, $paymentDate, $closeDate, $consolidate, $clubId, $this->sessionsPerformed, $this->ptTotal, $this->extraPerformanceMoney, $this->trainingOnClockHours, $this->sessionsPerformedTA, $this->ptTotalTA, $this->assesmentsOFFClockHours, $this->commisshReturn, $this->bonusPayout); 
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }	

//echo "fubar test2323232";
$this->confirmationMessage = "Payroll for $this->employeeName Successfully Processed";
//echo "$this->confirmationMessage";
/*
echo"UserId: $userId 
<br> 
TypeKey: $typeKey 
<br> 
PaymentCycle: $paymentCycle 
<br> 
CompType: $compType 
<br> 
HoursProjected: $hoursProjected
<br>
TotalHours: $totalHours
<br>
AddSubOne: $addSubOne
<br>
AddSubDescOne: $addSubDescOne
<br>
AddSubAmountOne: $addSubAmountOne
<br>
AddSubTwo: $addSubTwo
<br>
AddSubDescTwo: $addSubDescTwo
<br>
AddSubAmountTwo: $addSubAmountTwo
<br>
AddSubThree: $addSubThree
<br>
AddSubDescThree: $addSubDescThree
<br>
AddSubAmountThree: $addSubAmountThree
<br>
AddSubFour: $addSubFour
<br>
AddSubDescFour: $addSubDescFour
<br>
AddSubAmountFour: $addSubAmountFour
<br>
CommissionAmount: $commissionAmount
<br>
BasePaymentAmount: $basePaymentAmount
<br>
BaseProRateAmount: $baseProrateAmount
<br>
TotalPaymentAmount: $totalPaymentAmount
<br>
PaymentDate: $paymentDate
<br>
CloseDate: $closeDate
<br>
Consolidate: $consolidate
<br><br>";
*/
}
//-----------------------------------------------------------------------------------------------
function saveAddSubRecursive() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO add_sub_recursive VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissdssdssdssd', $userId, $typeKey, $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour);

$userId = $this->userId;
$typeKey = $this->typeKey;
$addSubOne = $this->addSubOne;
$addSubDescOne = $this->addSubDescOne; 
$addSubAmountOne = $this->addSubAmountOne;
$addSubTwo = $this->addSubTwo;
$addSubDescTwo = $this->addSubDescTwo;
$addSubAmountTwo = $this->addSubAmountTwo;
$addSubThree = $this->addSubThree; 
$addSubDescThree = $this->addSubDescThree;
$addSubAmountThree = $this->addSubAmountThree; 
$addSubFour = $this->addSubFour;
$addSubDescFour = $this->addSubDescFour;
$addSubAmountFour = $this->addSubAmountFour;


if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//-----------------------------------------------------------------------------------------------
function updateAddSubRecursive() {

$dbMain = $this->dbconnect();
$sql = "UPDATE add_sub_recursive SET  add_sub_one= ?, add_sub_desc_one= ?, add_sub_amount_one= ?, add_sub_two= ?, add_sub_desc_two= ?, add_sub_amount_two= ?, add_sub_three= ?, add_sub_desc_three= ?, add_sub_amount_three= ?, add_sub_four= ?, add_sub_desc_four=?, add_sub_amount_four=? WHERE type_key = '$this->typeKey' AND user_id='$this->userId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssdssdssdssd', $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour);		


$addSubOne = $this->addSubOne;
$addSubDescOne = $this->addSubDescOne; 
$addSubAmountOne = $this->addSubAmountOne;
$addSubTwo = $this->addSubTwo;
$addSubDescTwo = $this->addSubDescTwo;
$addSubAmountTwo = $this->addSubAmountTwo;
$addSubThree = $this->addSubThree; 
$addSubDescThree = $this->addSubDescThree;
$addSubAmountThree = $this->addSubAmountThree; 
$addSubFour = $this->addSubFour;
$addSubDescFour = $this->addSubDescFour;
$addSubAmountFour = $this->addSubAmountFour;


if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
}
//-----------------------------------------------------------------------------------------------
function saveAddSub() {

if($this->saveAddSub == 'Y') {


//first we filter any fields that have amounts or descrips or ad sub details that are not set to save
if($this->saveMarkerOne == 'N') {
   $this->addSubOne = 'E';
   $this->addSubDescOne = "";
   $this->addSubAmountOne = "";
  }
if($this->saveMarkerTwo == 'N') {
   $this->addSubTwo = 'E';
   $this->addSubDescTwo = "";
   $this->addSubAmountTwo = "";
  }
if($this->saveMarkerThree == 'N') {
   $this->addSubThree = 'E';
   $this->addSubDescThree = "";
   $this->addSubAmountThree = "";
  }
if($this->saveMarkerFour == 'N') {
   $this->addSubFour = 'E';
   $this->addSubDescFour = "";
   $this->addSubAmountFour = "";
  }


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM add_sub_recursive WHERE type_key = '$this->typeKey' AND user_id='$this->userId' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($count);
$stmt->fetch();

       if($count == 0) {
          $this->saveAddSubRecursive();
         }else{
          $this->updateAddSubRecursive();  
         }

}


}
//-----------------------------------------------------------------------------------------------
function getConfirmationMessage() {
        return($this->confirmationMessage);
        }






}
?>