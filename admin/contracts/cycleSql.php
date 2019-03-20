<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  cycleSql{

private $monthlyBillingDay = null;

private $guaranteeAnnualDate = null;
private $guaranteeCycle = null;
private $guaranteeFeeTotal = null;
private $guaranteeSelectList = null;
private $guaranteeSummaryText = null;
private $guaranteeFeePayment = null;

private $enhanceFeeTotal = null;
private $enhanceFeePayment = null;
private $eftEnhanceSelectList = null;
private $enhanceSummaryText = null;
private $eftEnhanceCycle = null;
private $pifEnhanceDate = null;


private $cycleSelected = null;
private $selectList = null;
private $cycleDivisor = null;
private $paymentSummaryText = null;
private $feePayment = null;
private $markerText = null;
private $gTermSwitch = null;
private $gTermSelectList = null;
private $eTermSwitch = null;
private $eTermSelectList = null;



function setMonthlyBillingDay($monthlyBillingDay) {
       $this->monthlyBillingDay = $monthlyBillingDay;
       }

function setPifEnhanceDate($pifEnhanceDate) {
       $this->pifEnhanceDate = $pifEnhanceDate;
       }

function setEftEnhanceCycle($eftEnhanceCycle) {
       $this->eftEnhanceCycle = $eftEnhanceCycle;
       }

function setGuaranteeAnnualDate($guaranteeAnnualDate) {
       $this->guaranteeAnnualDate = $guaranteeAnnualDate;
       }

function setGuaranteeCycle($guaranteeCycle) {
       $this->guaranteeCycle = $guaranteeCycle;
       }

function setGTermSwitch($gTermSwitch) {
       $this->gTermSwitch = $gTermSwitch;
       }
       
function setETermSwitch($eTermSwitch) {
       $this->eTermSwitch = $eTermSwitch;
       }
function setMCycle($m_cycle) {
       $this->mCycle = $m_cycle;
       }
function setMTermSwitch($m_term_switch) {
       $this->mTermSwitch = $m_term_switch;
       }
       

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------
function calculatePayments($feeTotal) {

$this->feePayment = sprintf("%.2f", $feeTotal / $this->cycleDivisor);

}
//-------------------------------------------------------------------------------------
function loadBillingDay() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT cycle_day FROM billing_cycle WHERE cycle_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cycle_day);
   $stmt->fetch();
   
   $this->monthlyBillingDay = $cycle_day;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

}

//----------------------------------------------------------------------------------------
function loadFees()  {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT enhance_fee, rate_fee, maintnence_fee FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->enhanceFeeTotal, $this->guaranteeFeeTotal, $this->MFeeTotal);
   $stmt->fetch();
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();


}
//----------------------------------------------------------------------------------------
function dropDownSelected()  {

 switch($this->cycleSelected) {
        case "A":
        $A ="selected";
        $this->paymentSummaryText = "Annual $this->markerText Fee:";
        $this->cycleDivisor = 1;
        break;
        case "B":
        $B="selected";
        $this->paymentSummaryText = "Bi-Annual $this->markerText Fee:";
        $this->cycleDivisor = 2;
        break;
        case "Q":
        $Q="selected";
        $this->paymentSummaryText = "Quarterly $this->markerText Fee:";
        $this->cycleDivisor = 4;
        break;
        case "M":
        $M="selected";
        $this->paymentSummaryText = "Monthly $this->markerText Fee:";
        $this->cycleDivisor = 12;
        break;
      }

$this->selectList = "
<option value=\"A\" $A>Annual</option>
<option value=\"B\" $B>Bi-Annual</option>
<option value=\"Q\" $Q>Quarterly</option>
<option value=\"M\" $M>Monthly</option>";

if($this->markerText == "Enhancement") {
  $this->calculatePayments($this->enhanceFeeTotal);
  $this->enhanceFeePayment = $this->feePayment;
  }
if($this->markerText == "Guarantee") {
  $this->calculatePayments($this->guaranteeFeeTotal);
  $this->guaranteeFeePayment = $this->feePayment;
  } 
if($this->markerText == "Maintnence") {
  $this->calculatePayments($this->MFeeTotal);
  $this->mFeePayment = $this->feePayment;
  }   

}
//----------------------------------------------------------------------------------------
function gTermTypeSelected() {

 switch($this->gTermSwitch) {
        case "T":
        $T ="selected";
        break;
        case "O":
        $O="selected";
        break;
        case "B":
        $B="selected";
        break;
      }

$this->gTermSelectList = "
<option value=\"T\" $T>Full Term</option>
<option value=\"O\" $O>Open Ended</option>
<option value=\"B\" $B>All Terms</option>";

}
//----------------------------------------------------------------------------------------
function eTermTypeSelected() {

 switch($this->eTermSwitch) {
        case "T":
        $T = "selected";
        break;
        case "O":
        $O= "selected";
        break;
        case "B":
        $B= "selected";
        break;
      }

$this->eTermSelectList = "
<option value=\"T\" $T>Full Term</option>
<option value=\"O\" $O>Open Ended</option>
<option value=\"B\" $B>All Terms</option>";


}
//----------------------------------------------------------------------------------------
function mTermTypeSelected() {

 switch($this->mTermSwitch) {
        case "T":
        $T = "selected";
        break;
        case "O":
        $O= "selected";
        break;
        case "B":
        $B= "selected";
        break;
      }

$this->mTermSelectList = "
<option value=\"T\" $T>Full Term</option>
<option value=\"O\" $O>Open Ended</option>
<option value=\"B\" $B>All Terms</option>";


}
//----------------------------------------------------------------------------------------
function loadEnhanceOptions()  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT eft_cycle, pif_cycle_date, term_switch FROM enhance_fee_cycles WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $pif_cycle_date, $term_switch);
   $stmt->fetch();

$monthDay = date("m/d/", strtotime($pif_cycle_date));
$year = date("Y");
$this->pifEnhanceDate = "$monthDay$year";
$this->cycleSelected = $eft_cycle;
$this->markerText = "Enhancement";
$this->dropDownSelected();
$this->eftEnhanceSelectList = $this->selectList;
$this->enhanceSummaryText = $this->paymentSummaryText;
$this->eTermSwitch = $term_switch;
$this->eTermTypeSelected();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

}
//------------------------------------------------------------------------------------
function loadGuaranteeOptions()  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT eft_cycle, annual_cycle_date, term_switch  FROM guarantee_fee_cycles  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);
   $stmt->fetch();


$monthDay = date("m/d/", strtotime($annual_cycle_date));
$year = date("Y");
$this->guaranteeAnnualDate = "$monthDay$year";
$this->cycleSelected = $eft_cycle;
$this->markerText = "Guarantee";
$this->gTermSwitch = $term_switch;
$this->gTermTypeSelected();
$this->dropDownSelected();
$this->guaranteeSelectList = $this->selectList;
$this->guaranteeSummaryText = $this->paymentSummaryText;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

}
//------------------------------------------------------------------------------------
function loadMaintnenceOptions()  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT m_cycle, term_switch  FROM member_maintnence_cycle  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->cycleSelected, $this->mTermSwitch);
   $stmt->fetch();

$this->markerText = "Maintnence";
$this->mTermTypeSelected();
$this->dropDownSelected();
$this->mSelectList = $this->selectList;
$this->mSummaryText = $this->paymentSummaryText;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

}
//----------------------------------------------------------------------------------
function updateBillingDay() {

$dbMain = $this->dbconnect();
$sql = "UPDATE billing_cycle SET cycle_day= ? WHERE cycle_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $cycleDay);

$cycleDay = $this->monthlyBillingDay;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 

}
//------------------------------------------------------------------------------------
function updateEnhanceOptions()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE enhance_fee_cycles SET eft_cycle=?,  pif_cycle_date=?, term_switch=? WHERE cycle_num = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sss', $eftCycle, $pifCycleDate, $termSwitch);

$eftCycle = $this->eftEnhanceCycle;
$pifCycleDate = date("Y-m-d", strtotime($this->pifEnhanceDate));
$termSwitch = $this->eTermSwitch;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }

$stmt->close(); 

}
//------------------------------------------------------------------------------------
function updateGuaranteeOptions()  {

$dbMain = $this->dbconnect();

if($this->guaranteeAnnualDate == null) {
    $sql = "UPDATE guarantee_fee_cycles SET eft_cycle=? WHERE cycle_num = '1'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s', $eftCycle);
    $eftCycle = $this->guaranteeCycle;
   }else{
    $sql = "UPDATE guarantee_fee_cycles SET eft_cycle=?, annual_cycle_date=?, term_switch=? WHERE cycle_num = '1'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('sss', $eftCycle, $annualCycleDate, $termSwitch);
    $eftCycle = $this->guaranteeCycle;   
    $annualCycleDate = date("Y-m-d", strtotime($this->guaranteeAnnualDate)); 
    $termSwitch = $this->gTermSwitch;
   }

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 

}
//------------------------------------------------------------------------------------
function updateMaintnenceOptions()  {

$dbMain = $this->dbconnect();

$sql = "UPDATE member_maintnence_cycle SET m_cycle=?, term_switch=? WHERE cycle_num = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $this->mCycle, $this->mTermSwitch);
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 

}
//================================================
function loadCycleData()  {

$this->loadFees();
$this->loadBillingDay();
$this->loadEnhanceOptions();
$this->loadGuaranteeOptions();
$this->loadMaintnenceOptions();

}
//================================================
function updateCycleData()  {

$this->updateBillingDay();
$this->updateEnhanceOptions();
$this->updateGuaranteeOptions();
$this->updateMaintnenceOptions();
$this->confirmation_message = "Payment Cycle Dates Successfully Updated";
           return($this->confirmation_message);
}
//================================================


function getMonthlyBillingDay() {
      return($this->monthlyBillingDay);
       }

function getPifEnhanceDate()  {
      return($this->pifEnhanceDate);
      }

function getEftEnhanceSelectList() {
      return($this->eftEnhanceSelectList);
      }

function getEnhanceFeeTotal() {
      return($this->enhanceFeeTotal);
      }

function getEnhanceSummaryText() {
      return($this->enhanceSummaryText);
      }

function getEnhanceFeePayment() {
      return($this->enhanceFeePayment);
      }


function getGuaranteeAnnualDate() {
      return($this->guaranteeAnnualDate);
      }

function getGuaranteeSelectList() {
      return($this->guaranteeSelectList);
      }

function getGuaranteeSummaryText() {
      return($this->guaranteeSummaryText);
      }

function getGuaranteeFeePayment() {
      return($this->guaranteeFeePayment);
      }

function getGuaranteeFeeTotal() {
      return($this->guaranteeFeeTotal);
      }

function getGTermSelectedList() {
      return($this->gTermSelectList);
      }

function getETermSelectedList() {
      return($this->eTermSelectList);
      }
function getMTermSelectedList() {
      return($this->mTermSelectList);
      }
function getMSelectList() {
      return($this->mSelectList);
      }
function getMSummaryText() {
      return($this->mSummaryText);
      }
function getMFeePayment() {
      return($this->mFeePayment);
      }
}


?>