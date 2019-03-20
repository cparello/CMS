<?php
class  pastDueMonthly {


private $contractKey = null;
private $prePayCount = null;
private $monthlyCount = null;
private $currentMonthDueDate = null;
private $nextMonthDueDate = null;
private $lateFee = null;
private $monthlyPayment = null;
private $nextPaymentDueDate = null;
private $todaysDate = null;
private $daysPastDue = null;
private $pastDueTotal = null;
private $cycleDay = null;
private $pastDay = null;
private $testSecs = null;

function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }



//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT late_fee, nsf_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($late_fee, $nsf_fee, $rejection_fee);
$stmt->fetch();

$this->lateFee = $late_fee;

$stmt->close();  
}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
//$this->todaysDate = date("Y-m-d");
$this->todaysDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), date("d"), date("Y")));
           $datetime1 = new DateTime($this->nextPaymentDueDate);
           $datetime2 = new DateTime($this->todaysDate);
           $interval = $datetime1-> diff($datetime2);                    
           $this->daysPastDue = $interval-> format('%d');
           $this->monthsPastDue = $interval-> format('%m');
           $this->yearsPastDue = $interval-> format('%y');
           
       //  $this->testSecs =  "dgdfgf $this->monthsPastDue";
           
           if($this->monthsPastDue >= 1) {
           
               if($this->yearsPastDue >= 1) {
                  $months = $this->yearsPastDue * 12;  
                  $this->monthsPastDue = $this->monthsPastDue + $months;
                 }
                                  
             $this->monthlyPayment = ($this->monthlyPayment * $this->monthsPastDue) + $this->lateFee;
                          
             }else{
                $this->monthlyPayment = 0;
             }
           

$this->pastDueTotal = $this->monthlyPayment;
$this->pastDueTotal = sprintf("%01.2f", $this->pastDueTotal);



 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthly() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM monthly_payments WHERE contract_key='$this->contractKey' AND billing_amount != '0.00'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();


 $this->monthlyCount = $count;
   

$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadSettledPayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();  
$numRows = $stmt->num_rows;
$stmt->bind_result($next_payment_due_date);
$stmt->fetch();
$stmt->close();


$stmt = $dbMain ->prepare("SELECT MAX(cycle_date) FROM monthly_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);
$stmt->fetch();
$stmt->close();

$todaysDateSecs = time();

if($next_payment_due_date != "") {
     $monthlySettledDueDateSecs = strtotime($next_payment_due_date);
     
      if($todaysDateSecs >= $monthlySettledDueDateSecs) {
          $this->nextPaymentDueDate = $next_payment_due_date;
          $this->loadFees();
          $this->loadMonthlyPayment();
        }
        
   }elseif($next_payment_due_date == "") {
   
     //create the past due day and monthly cycle date from monthly payment
     $cycle_day = date("d", strtotime($cycle_date));
     $pastDueDay = $this->pastDay + $cycle_day;
     $cycleMonth = date("m", strtotime($cycle_date));
     $cycleYear = date("Y", strtotime($cycle_date));
     $monthlyPaymentsDueDate= date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $cycleMonth, $pastDueDay, $cycleYear));
     $monthlyPaymentsDueDateSecs = strtotime($monthlyPaymentsDueDate);
   
// $this->testSecs = "$monthlyPaymentsDueDateSecs <br> $todaysDateSecs";
     
      if($todaysDateSecs >= $monthlyPaymentsDueDateSecs) {
         $this->nextPaymentDueDate = $monthlyPaymentsDueDate;
         $this->loadFees();
         $this->loadMonthlyPayment();       
        }     
     
  }



/*
$this->nextPaymentDueDate = $next_payment_due_date;
  
//          if($this->nextPaymentDueDate != $this->nextMonthDueDate) {   
//              if($this->nextPaymentDueDate != "") {          
//                 $this->loadFees();
//                 $this->loadMonthlyPayment(); 
//                 }
//             } 
 
 
 if($this->nextPaymentDueDate != "" && $this->prePayCount == 0) { 
 
          if($this->nextPaymentDueDate != $this->nextMonthDueDate) {                                                     
                   $this->loadFees();
                   $this->loadMonthlyPayment();                                   
             }
     } 
     
if($this->nextPaymentDueDate != "" && $this->prePayCount > 0) {   
    $prepayEndDate = strtotime($next_payment_due_date);
    $todaysDate = time();
    
      if($todaysDate > $prepayEndDate) {
         $this->loadFees();
         $this->loadMonthlyPayment();      
         }

   } 
 
 
$stmt->close();
*/

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($currentCount);
$stmt->fetch();

       if($currentCount > 0) {
           //check to see if account is monthly
           $this->loadPastDay();
           $this->loadMonthly();
           
               if($this->monthlyCount == 1) {   
                    //check to see if a prepayment has been made                   
                    $this->checkPrepay();
                     
                       if($this->prePayCount == 0) {                        
                           $this->loadSettledPayments();
                        }
                                         
                 } 
             }    
        
 
$stmt->close();

if($this->ajaxSwitch == 1) {
   echo"$this->settledCount";
   exit;
   }
   
}
//---------------------------------------------------------------------------------------------------------------------------------------
function loadPastDay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$this->pastDay = $past_day;

//$stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
//$stmt->execute();      
//$stmt->store_result();      
//$stmt->bind_result($cycle_date);
//$stmt->fetch();
//$stmt->close();   
 

//$this->cycleDay = date("d",strtotime($cycle_date));


//$nextDueDaysPast = $this->pastDay + $this->cycleDay;

//$this->currentMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , $nextDueDaysPast, date("Y")));
//$this->nextMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $nextDueDaysPast, date("Y")));
//$this->nextMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")+1  , $nextDueDaysPast, date("Y")));

//$this->currentStatementDate =  date("m/d/Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
//$this->statementRangeEndDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m"), $nextDueDaysPast, date("Y")));
//$this->statementRangeStartDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m")-1  , $cycle_day, date("Y")));

}
//---------------------------------------------------------------------------------------------------------------------

function getPastDueTotal() {
             return($this->pastDueTotal);
             }

function getTestSecs() {
             return($this->testSecs);
             }


}

/*
if($ajax_switch == 1) {
   $testPastDue = new  pastDueCount();
   $testPastDue-> loadCycleDate();
   $testPastDue-> setAjaxSwitch($ajax_switch);
   $testPastDue-> loadRecordCount();
   }
*/

?>