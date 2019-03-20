<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class saveClubPayrollSql {

private $insertArray = null;
private $confirmation = null;

private $userId = null;
private $typeKey = null;
private $paymentCycle = null;
private $compType = null;
private $hoursProjected = null;
private $totalHours = null;
private $addSubOne = null;
private $addSubDescOne = null;
private $addSubAmountOne = null;
private $addSubTwo = null;
private $addSubDescTwo = null;
private $addSubAmountTwo = null;
private $addSubThree = null;
private $addSubDescThree = null;
private $addSubAmountThree = null;
private $addSubFour = null;
private $addSubDescFour = null;
private $addSubAmountFour = null;
private $commissionAmount = null;
private $basePaymentAmount = null;
private $OT = null;
private $overtimeTier2 = null;
private $baseProrateAmount = null;
private $totalPaymentAmount = null;
private $paymentDate = null;
private $closeDate = null;
private $consolidate = null;
private $empFirstName = null;
private $empMidName = null;
private $empLastName = null;
private $empStreet = null;
private $empCity = null;
private $empState = null;
private $empZip = null;
private $empPhoneOne = null;
private $empPhoneTwo = null;
private $socialSecurity = null;
private $payrollId = null;
private $clubId = null;


function setInsertArray($insertArray) {
           $this->insertArray = $insertArray;
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
           
                   
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}           
//----------------------------------------------------------------------------------------------------------
function loadPayPeriodId() {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO qb_payroll_keys VALUES (?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $qb_marker);
$qb_marker = null;
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$this->payrollId = $stmt->insert_id; 
$stmt->close();  


}
//----------------------------------------------------------------------------------------------------------
function loadEmployeeInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security FROM employee_info WHERE user_id = '$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security); 
$stmt->fetch();

$this->empFirstName = $emp_fname;
$this->empMidName = $emp_mname;
$this->empLastName = $emp_lname;
$this->empStreet = $emp_street;
$this->empCity = $emp_city;
$this->empState = $emp_state;
$this->empZip = $emp_zip; 
$this->empPhoneOne = $emp_phone1;
$this->empPhoneTwo = $emp_phone2;
$this->socialSecurity = $social_security;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    
 
}
//----------------------------------------------------------------------------------------------------------
function saveToBookKeeping() {

if($this->bookKeeping != 0) {
   if($this->bookKeeping == 1) {
   
     $this->loadEmployeeInfo();
   
    $dbMain = $this->dbconnect(); 
    
        
    $sql = "INSERT INTO qb_payroll_settled VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iisssssssssiissidssdssdssdssdddddddsssdddddddd', $payroll_id, $user_id, $emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two, $add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $overtime_tier_2,  $OT, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate, $this->ptTotal, $this->extraPerformanceMoney, $this->trainingOnClockHours, $this->sessionsPerformedTA, $this->ptTotalTA, $this->assesmentsOFFClockHours, $this->commissionReturnTotal, $this->bonusPayout); 


    $payroll_id = $this->payrollId;
    $user_id = $this->userId;
    $emp_fname = $this->empFirstName;
    $emp_mname = $this->empMidName;
    $emp_lname = $this->empLastName; 
    $emp_street = $this->empStreet;
    $emp_city = $this->empCity;
    $emp_state = $this->empState;
    $emp_zip = $this->empZip;
    $emp_phone1 = $this->empPhoneOne;
    $emp_phone2 = $this->empPhoneTwo;
    $social_security = $this->socialSecurity;
    $type_key = $this->typeKey;
    $payment_cycle = $this->paymentCycle;
    $comp_type = $this->compType;
    $hours_projected = $this->hoursProjected;
    $total_hours = $this->totalHours;
    $add_sub_one = $this->addSubOne;
    $add_sub_desc_one = $this->addSubDescOne;
    $add_sub_amount_one = $this->addSubAmountOne;
    $add_sub_two = $this->addSubTwo;
    $add_sub_desc_two = $this->addSubDescTwo;
    $add_sub_amount_two = $this->addSubAmountTwo;
    $add_sub_three = $this->addSubThree;
    $add_sub_desc_three = $this->addSubDescThree;
    $add_sub_amount_three = $this->addSubAmountThree;
    $add_sub_four = $this->addSubFour;
    $add_sub_desc_four = $this->addSubDescFour;
    $add_sub_amount_four = $this->addSubAmountFour;
    $commission_amount = $this->commissionAmount;
    $OT = $this->OT;
    $overtime_tier_2 = $this->overtimeTier2;
    $base_payment_amount = $this->basePaymentAmount;
    $base_prorate_amount = $this->baseProrateAmount;
    $total_payment_amount = $this->totalPaymentAmount;
    $payment_date = $this->paymentDate;
    $close_date = $this->closeDate;
    $consolidate = $this->consolidate;

    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 


   }
}

}
//----------------------------------------------------------------------------------------------------------
function insertPayroll() {
//echo "test";
$this->paymentDate = date("Y-m-d H:i:s");

if($this->commissionAmount == 'NA') {
   $this->commissionAmount = '0.00';
   }
   
$dbMain = $this->dbconnect();
/*
$tempTable = "CREATE TEMPORARY TABLE IF NOT EXISTS `details` (
          `user_id` INT(20) NOT NULL,
          `type_key` int(20) NOT NULL,
          `payment_cycle` ENUM('D','W','B','M') NOT NULL,
          `comp_type` ENUM('S','H','C','SC','HC') NOT NULL,
          `hours_projected`  INT(3) NOT NULL,
          `total_hours` INT(3) NOT NULL,
          `add_sub_one` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_one` CHAR(30) NULL,
          `add_sub_amount_one` DECIMAL(10,2) NULL,
          `add_sub_two` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_two` CHAR(30) NULL,
          `add_sub_amount_two` DECIMAL(10,2) NULL,
          `add_sub_three` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_three` CHAR(30) NULL,
          `add_sub_amount_three` DECIMAL(10,2) NULL,
          `add_sub_four` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_four` CHAR(30) NULL,
          `add_sub_amount_four` DECIMAL(10,2) NULL,
          `commission_amount` DECIMAL(10,2) NULL,
          `base_payment_amount`  DECIMAL(10,2) NOT NULL,
          'ot_hours_tier_2' DECIMAL(10,2) NOT NULL,
          'overtime' DECIMAL(10,2) NOT NULL,
          `base_prorate_amount` DECIMAL(10,2) NOT NULL,
          `total_payment_amount` DECIMAL(10,2) NOT NULL,
          `payment_date` DATETIME NOT NULL,
          `close_date` DATETIME NOT NULL,
          `consolidate` ENUM('Y','N') NOT NULL
          )";
   
$dbMain-> query($tempTable);
*/
$stmt = $dbMain ->prepare("SELECT club_id  FROM employee_type WHERE type_key = '$this->typeKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_id); 
$stmt->fetch();
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    


 $sql = "INSERT INTO payroll_settled VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ? ,? ,? ,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iissiissdssdssdssdddddddsssiiddiididd', $this->userId, $this->typeKey, $this->paymentCycle, $this->compType, $this->hoursProjected, $this->totalHours, $this->addSubOne, $this->addSubDescOne, $this->addSubAmountOne, $this->addSubTwo, $this->addSubDescTwo, $this->addSubAmountTwo, $this->addSubThree, $this->addSubDescThree, $this->addSubAmountThree, $this->addSubFour, $this->addSubDescFour, $this->addSubAmountFour, $this->commissionAmount, $this->basePaymentAmount,$this->overtimeTier2,$this->OT, $this->baseProrateAmount, $this->totalPaymentAmount, $this->paymentDate, $this->closeDate, $this->consolidate,$club_id, $this->sessionsPerformed, $this->ptTotal, $this->extraPerformanceMoney, $this->trainingOnClockHours, $this->sessionsPerformedTA, $this->ptTotalTA, $this->assesmentsOFFClockHours, $this->commissionReturnTotal, $this->bonusPayout); 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


 

/*$dbMain-> query("INSERT INTO payroll_settled (user_id, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two, add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three, add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, ot_hours_tier_2, overtime, base_prorate_amount, total_payment_amount, payment_date, close_date, consolidate, club_id)VALUES ('$this->userId', '$this->typeKey', '$this->paymentCycle', '$this->compType', '$this->hoursProjected', '$this->totalHours', '$this->addSubOne', '$this->addSubDescOne', '$this->addSubAmountOne', '$this->addSubTwo', '$this->addSubDescTwo', '$this->addSubAmountTwo', '$this->addSubThree', '$this->addSubDescThree', '$this->addSubAmountThree', '$this->addSubFour', '$this->addSubDescFour', '$this->addSubAmountFour', '$this->commissionAmount', '$this->basePaymentAmount','$this->overtimeTier2','$this->OT', '$this->baseProrateAmount', '$this->totalPaymentAmount', '$this->paymentDate', '$this->closeDate', '$this->consolidate','$this->clubId')");*/


}
//----------------------------------------------------------------------------------------------------------
function loadConfirmation() {

         switch ($this->paymentCycle) {
                 case "D":
                  $cycleType = 'Daily';
                 break;
                 case "W":
                  $cycleType = 'Weekly';
                 break;
                 case "B":
                  $cycleType = 'Bi-Monthly';
                 break;
                 case "M":
                  $cycleType = 'Monthly';
                 break;
                 }

            $closeDateText = date("F j, Y");
            $this->confirmation = "$cycleType payroll ending on close date $closeDateText successfully processed";


}
//----------------------------------------------------------------------------------------------------------
function savePayroll() {


$insertArray = explode("^", $this->insertArray);
$insertArrayCount = count($insertArray);
$insertArrayCount = $insertArrayCount -1;
$i = 0;

while ($i <= $insertArrayCount) {



   $insertRecordArray = $insertArray[$i];
   $insertRecordArray = explode("|", $insertRecordArray);
   
//$tetN = count($insertRecordArray);
//echo"$tetN csdasda $insertArray[$i] <br>";

$this->userId = $insertRecordArray[0];
//echo"%%%%%%%%%%%%%%%%%%%%%%%%%%%%% $this->userId $$$$$$$$$$$$$$$$$$$$$$";
$this->typeKey = $insertRecordArray[1];
$this->paymentCycle = $insertRecordArray[2];
$this->compType = $insertRecordArray[3];
$this->hoursProjected = $insertRecordArray[4];
$this->totalHours = $insertRecordArray[5];
$this->addSubOne = $insertRecordArray[6];
$this->addSubDescOne = $insertRecordArray[7];
$this->addSubAmountOne = $insertRecordArray[8];
$this->addSubTwo = $insertRecordArray[10];
$this->addSubDescTwo = $insertRecordArray[11];
$this->addSubAmountTwo = $insertRecordArray[12];
$this->addSubThree = $insertRecordArray[14];
$this->addSubDescThree = $insertRecordArray[15];
$this->addSubAmountThree = $insertRecordArray[16];
$this->addSubFour = $insertRecordArray[18];
$this->addSubDescFour = $insertRecordArray[19];
$this->addSubAmountFour = $insertRecordArray[20];
$this->commissionAmount = $insertRecordArray[22];
$this->basePaymentAmount = $insertRecordArray[23];
$this->overtimeTier2 = $insertRecordArray[24];
$this->OT = $insertRecordArray[25];
$this->baseProrateAmount = $insertRecordArray[26];
$this->totalPaymentAmount = $insertRecordArray[27];
$this->paymentDate = $insertRecordArray[28];
$this->closeDate = $insertRecordArray[29];
$this->consolidate = $insertRecordArray[30];
$this->empFullName = $insertRecordArray[31];
$this->idCard = $insertRecordArray[32];
$this->otDateRange = $insertRecordArray[33];
$this->ptTotal = $insertRecordArray[34];
$this->extraPerformanceMoney = $insertRecordArray[35];
$this->htmlArray = $insertRecordArray[36];
$this->ptTotalTA = $insertRecordArray[37];
$this->htmlArrayTA = $insertRecordArray[38];
$this->sessionsPerformed = $insertRecordArray[39];
$this->trainingOnClockHours = $insertRecordArray[40];
$this->ptTotalTA = $insertRecordArray[41];
$this->sessionsPerformedTA = $insertRecordArray[42];
$this->assesmentsOFFClockHours = $insertRecordArray[43];
$this->commissionReturnTotal = $insertRecordArray[44];
$this->bonusNumSales = $insertRecordArray[45];
$this->bonusTotSales = $insertRecordArray[46];
$this->bonusPayout = $insertRecordArray[47];
$this->salesHtml = $insertRecordArray[48];
$this->commissionReturnHtml = $insertRecordArray[49];


//echo "khfsljflsjddsfjkj b $this->bonusPayout c $this->commissionReturnTotal ggggg";

if ($this->typeKey != ''){
    $this->insertPayroll();
$this->saveToBookKeeping();
}

$this->loadConfirmation();
$i++;
}




}
//----------------------------------------------------------------------------------------------------------
function getConfirmation() {
        return($this->confirmation);
        }





}