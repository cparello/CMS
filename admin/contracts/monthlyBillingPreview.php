<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//error_reporting(E_ALL);
class monthlyBillingPreview {


function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setBool($bool){
    $this->bool = $bool;
}
function setMonth($month){
    $this->month = $month;
}
function setYear($year){
    $this->year = $year;
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
//===============================================================================================
function checkAccountStatus() {
$this->statusCount = 0;
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$this->serviceId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->statusCount);
$stmt->fetch();
$stmt->close();
}
//===============================================================================================
function checkServiceCredit() {
    
$this->serviceCreditDiscount = 0;
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) FROM service_credits WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

$this->creditCount = $count;

if ($this->creditCount >= '1'){
    $stmt999 = $dbMain ->prepare("SELECT service_key FROM service_credits WHERE contract_key='$this->contractKey'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($service_key);
    while($stmt999->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT service_term FROM service_cost WHERE service_key='$service_key'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_term);
        $stmt->fetch(); 
        $stmt->close();
        
        if ($service_term == 'M'){
            $stmt = $dbMain ->prepare("SELECT unit_price, number_months, MAX(end_date) FROM monthly_services WHERE service_key='$service_key' AND contract_key='$this->contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($unit_price, $number_months, $end_date);
            $stmt->fetch(); 
            $stmt->close();
            $this->serviceCreditDiscount +=  sprintf("%01.2f", ($unit_price/$number_months));
        }
        
    }
    $stmt999->close();
}else{
    $this->creditCount = 0;
}
 

}
//==================================================================================================
function checkSettledPaymentsCount() {
    
$dbMain = $this->dbconnect();    
/*
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pastDays);
$stmt->fetch();
$stmt->close();

$day = date('d');

$cycleDay = date('d',strtotime($this->cycleDate));

if ($day < $cycleDay){
    $currentDueDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d',strtotime($this->cycleDate))+$pastDays,date('Y')));
}else{
     $currentDueDate = date('Y-m-d H:i:s',mktime(23,59,59,date('m')+1,date('d',strtotime($this->cycleDate))+$pastDays,date('Y')));
}
*/

$contract_key = "";
$stmt = $dbMain ->prepare("SELECT contract_key FROM monthly_settled WHERE contract_key='$this->contractKey' AND next_payment_due_date = '$this->dueDate' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);
$stmt->fetch();
$stmt->close();

if ($contract_key == $this->contractKey){
    $this->monthlySettledCount = 0;
}else{
    $this->monthlySettledCount = 1;
}

$contract_key = "";
$stmt = $dbMain ->prepare("SELECT contract_key FROM monthly_settled WHERE contract_key='$this->contractKey' AND next_payment_due_date <= '$this->dueDate' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);
$stmt->fetch();
$stmt->close();

if ($contract_key == $this->contractKey){
    $this->monthlySettledCountAll = 0;
}else{
    $this->monthlySettledCountAll = 1;
}
//echo " wjwjwjwjwjw $next_payment_due_date <br>";
//$todaysDateSecs = time();


//echo "day $day cycday $cycleDay due date $currentDueDate next due date $next_payment_due_date<br>";
/*$currentDueDateSecs = strtotime($currentDueDate);

$this->nextPaymentDueDate = $next_payment_due_date;
$nextPaymentDueDateSecs = strtotime($this->nextPaymentDueDate);

 if($this->nextPaymentDueDate != "") { 
        
          if($nextPaymentDueDateSecs == $currentDueDateSecs ) {                                                     //$this->currentMonthDueDate
                   $this->monthlySettledCount = 1;
                                                   
             } else{
                $this->monthlySettledCount = 0;
             }              
             
     } 
     

 //handles first payment if overdue
if($this->nextPaymentDueDate == "") {
   $this->monthlySettledCount = 0;
    
  }
 
 
$this->nextPaymentDueDate == ""; */
}
//===============================================================================================
function countRecord(){
   $day = date('d');
    $reportDate = date('F',strtotime("$this->month/$day/$this->year"));
    
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Attendence Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Monthly Billing Preview</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
     <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cycle Date</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Records Expected</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Expected Billing(Based on last month)</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit Total(Expected)</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Total(Expected)</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Billing Records in Database</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Billing in Database</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number Attempted(Next Cycle)</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Attempted(Next Cycle)</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit Attempted</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Attempted(Next Cycle)</font></th>
  </tr>"; 
   
$dbMain = $this->dbconnect();
$this->serviceIdArray = "";
$cycDayCounter = 0;
$stmt1 = $dbMain->prepare("SELECT DISTINCT DAY(cycle_date) FROM monthly_payments WHERE contract_key!=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($day); 
while($stmt1->fetch()){
    $dayArray[$cycDayCounter] = $day;
    $cycDayCounter++;
}
$stmt1->close(); 

//var_dump($dayArray);
$counterRaw = 0;
$totalBillingRaw = 0;


//$mStart = date('m',strtotime($this->monthStart));
//$yStart = date('Y',strtotime($this->monthStart));

foreach($dayArray as $cycDay){
        
                $cycDate = date("F j, Y",mktime(23,59,59,$this->month,$cycDay,$this->year));
                $this->dueDate = date("Y-m-d H:i:s",mktime(23,59,59,$this->month,$cycDay+$this->pastDays,$this->year));
                $counter = 1;
                $counterAll = 1;
                $counterRaw = 1;
                //echo "$cycDay $cycDate $this->dueDate";
                
                $crTotal = 0;
                $achTotal = 0;
                $totalBilling = 0;
                $totalBillingAll = 0;
                $crTotalAll = 0;
                $achTotalAll = 0;
                $totalBillingRaw = 0;
               // echo "test";
                $stmt999 = $dbMain->prepare("SELECT contract_key, cycle_date, billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key != '' ORDER BY contract_key ASC");//>=
                if(!$stmt999->execute())  {
                        	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                              }	      
                $stmt999->store_result();      
                $stmt999->bind_result($this->contractKey, $this->cycleDate, $this->billingAmount, $monthly_billing_type); 
                while($stmt999->fetch()){
                    $this->statusCount = 0;
                    $this->prePayCount = 0;
                    $this->creditCount = 1;
                    $this->monthlySettledCount = 0;
                    
                    $stmt = $dbMain->prepare("SELECT service_id, MAX(end_date) FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
                    $stmt->execute();  
                    $stmt->store_result();      
                    $stmt->bind_result($this->serviceId, $end_date); 
                    $stmt->fetch();
                    $stmt->close();
                    
                    //echo"test2 $this->contractKey<br>";
                        $billing_amount = $this->billingAmount;
                        $this->checkAccountStatus();
                        if ($this->statusCount >= 1){
                            $counterRaw++;
                            $totalBillingRaw += $this->billingAmount;
                        $this->checkPrepay();
                        if ($this->prePayCount == 0){
                        $this->checkSettledPaymentsCount();
                        $this->checkServiceCredit();  
                                                                                                                      
                        if ($this->monthlySettledCount == 0){
                            if($this->creditCount >= 1){
                                //echo "fubar ";                    
                                $this->billingAmount = sprintf("%01.2f", ($this->serviceCreditDiscount - $this->billingAmount));
                              }
                              if($monthly_billing_type == 'CR') {
                                        $crTotal += $this->billingAmount;
                                }else {                                                     //if($monthly_billing_type == 'BA')
                                        $achTotal += $this->billingAmount;
                                }
                            $counter++;
                            $totalBilling += $this->billingAmount;
                            
                            //echo "ck $this->contractKey, cd $this->cycleDate, ba $this->billingAmount pp $this->prePayCount sc $this->statusCount msc $this->monthlySettledCount servcred $this->creditCount ba $billing_amount servcreddis $this->serviceCreditDiscount mbt $monthly_billing_type<br>";
                        }
                        
                         if ($this->monthlySettledCountAll == 0){
                            if($this->creditCount >= 1){
                                //echo "fubar ";                    
                                $this->billingAmount = sprintf("%01.2f", ($this->serviceCreditDiscount - $this->billingAmount));
                              }
                              if($monthly_billing_type == 'CR') {
                                        $crTotalAll += $this->billingAmount;
                                }else {                                                     //if($monthly_billing_type == 'BA')
                                        $achTotalAll += $this->billingAmount;
                                }
                            $counterAll++;
                            $totalBillingAll += $this->billingAmount;
                            
                            //echo "ck $this->contractKey, cd $this->cycleDate, ba $this->billingAmount pp $this->prePayCount sc $this->statusCount msc $this->monthlySettledCount servcred $this->creditCount ba $billing_amount servcreddis $this->serviceCreditDiscount mbt $monthly_billing_type<br>";
                        }
                        }
                       }
                         $this->contractKey = "";
                         $this->cycleDate = "";
                         $this->billingAmount = "";
                         $monthly_billing_type = "";
                         }
                $stmt999->close();
                
                
                echo    "<tr>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$cycDate</b></font>
            </td>    
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$totalBilling</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$crTotal</b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achTotal</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counterRaw</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$totalBillingRaw</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$counterAll</b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$totalBillingAll</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$crTotalAll</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$achTotalAll</b></font>
            </td>
            </tr>\n";
                
            }


echo  "</table>
</div>
</head>
</html>";
    
    $this->totalBilling = $totalBilling;
    $this->creditTotal = $crTotal;
    $this->achTotal = $achTotal;
    $this->counter = $counter;
}
//==================================================================================================
function loadContactInfo(){
    $dbMain = $this->dbconnect();
    
    $stmt1 = $dbMain->prepare("SELECT first_name, last_name, street, city, state,  zip,  email, primary_phone, cell_phone, license_number FROM contract_info WHERE contract_key = '$this->contractKey'");
    $stmt1->execute();      
    $stmt1->store_result();      
    $stmt1->bind_result($this->firstName, $this->lastName, $this->street, $this->city, $this->state,  $this->zip,  $this->email, $this->primaryPhone, $this->cellPhone, $this->licenseNumber); 
    $stmt1->fetch();
    $stmt1->close(); 
                        
    if ($this->email == ""){
        $this->email = 'none@email.com';
    }
    if ($this->street == ""){
        $this->street = 'Street';
    }
    if ($this->city == ""){
        $this->city = 'city';
    }
    if ($this->state == ""){
        $this->state = 'CA';
    }
    if ($this->zip == ""){
        $this->zip = '91504';
    }
    
}
//=====================================================================================
function checkLastReasonCode(){
    $day = date('d');
    $reportDate = date('F',strtotime("$this->month/$day/$this->year"));
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Credit Card Reason Code Report</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Number of Cards</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">General Decline #</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">General Decline Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">NSF #</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">NSF Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Error #</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Error Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Expired #</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Expired Total</font></th>

   </tr>";


    
    $dbMain = $this->dbconnect();
    
    $counter = 1;
    $failed = 0;
    $gd = 0;
    $gdTot = 0;
    $nsf = 0;
    $nsfTot = 0;
    $approval = 0;
    $apTot = 0;
    $exp = 0;
    $expTot = 0;
    $procGD = 0;
    $procGdTot = 0;      
    $invalid = 0;
    $invTot = 0;      
    $notProc = 0;
    $notProcTot = 0;
    
    
    //$month = date('m',strtotime($this->monthStart));
    //$year = date('y',strtotime($this->monthStart));
    
    //echo "$start $end $this->month $this->year";
    
    $stmt999 = $dbMain->prepare("SELECT contract_key, cycle_date, billing_amount FROM monthly_payments  WHERE contract_key != ''");//>=
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($contractKey, $cycleDate, $billingAmount); 
    while($stmt999->fetch()){
        
            $reasonCode = "";
            $this->contractKey = $contractKey;
            $this->billingAmount = $billingAmount;
            $this->cycleDate = $cycleDate;
            $stmt1 = $dbMain->prepare("SELECT DISTINCT response FROM billing_scheduled_recuring_payments WHERE contract_key = '$this->contractKey' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year'");
            $stmt1->execute();      
            $stmt1->store_result();      
            $stmt1->bind_result($reasonCode); 
            $stmt1->fetch();
            $stmt1->close();
           // echo "test<br>";
            //echo "fubar $reasonCode";

            
            if ($reasonCode != 100){
                
            $failed++;
            switch($reasonCode){ 
                case 530: //gen dec
                    $gd++;
                    $gdTot += $this->billingAmount;
                break;
                case 302: //nsf
                    $nsf++;
                    $nsfTot += $this->billingAmount;
                break;
                case 606: //inv trans type
                    $invTransType++;
                    $invTransTypeTot += $this->billingAmount;
                break;
                case 522: //exp
                    $exp++;
                    $expTot += $this->billingAmount;
                break;
                case 999: //exp
                    $exp++;
                    $expTot += $this->billingAmount;
                break;
                case 303: //gen dec by procc
                    $procGD++;
                    $procGdTot += $this->billingAmount;
                break;
                case 591: //inv
                    $invalid++;
                    $invTot += $this->billingAmount;
                break;
                case 502: //lost
                    $lost++;
                    $lostTot += $this->billingAmount;
                break;
                 case 101: //lost
                    $achErr++;
                    $achErrTot += $this->billingAmount;
                break;
                 case 220: //lost
                    $achErr++;
                    $achErrTot += $this->billingAmount;
                break;
                case 233: //lost
                    $achErr++;
                    $achErrTot += $this->billingAmount;
                break;
                 case 825: //lost
                    $noAccount++;
                    $noAccountTot += $this->billingAmount;
                break;
                case 571: // revovke
                    $revoke++;
                    $revokeTot += $this->billingAmount;
                break;
                case 596: // fraud
                    $fraud++;
                    $fraudTot += $this->billingAmount;
                break;
                
            }
             }
                $counter++;
            }
            
            echo  "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$gd</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$gdTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$nsf</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$nsfTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$achErr</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achErrTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$exp</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$expTot</b></font>
</td>
</tr>";

echo" <tr>  
  
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Processor General Decline #</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Processor General Decline Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invalid Card Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invalid Card Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lost Card#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lost Card Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invalid Transaction #</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invalid Transaction Total</font></th>
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th> 
  </tr>"; 

echo"<tr>

<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$procGD</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$procGDTot</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$invalid</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$invTot</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$lost</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$lostTot</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$invTransType</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$invTransType</b></font>
</td>
</tr>";

echo" <tr>  
  
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">No Account #</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">No Account Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Revoke of Auth Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Revoke of Auth Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Suspected Fraud#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Suspected Fraud Total</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th> 
  </tr>"; 
  
  echo"<tr>

<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$noAccount</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$noAccountTot</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$revoke</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$revokeTot</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fraud</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$fraudTot</b></font>
</td>
</tr>";

echo  "</table>
</div>
</head>
</html>";             
    
    $stmt999->close();
    
             
    $this->genDecline = $gd;
    $this->genDeclineTot = $gdTot;
    
    $this->nsfDecline = $nsf;  
    $this->nsfDeclineTot = $nsfTot;
    
    $this->approvalDecline = $approval;
    $this->approvalDeclineTot = $apTot;
    
    $this->expDecline = $exp;  
    $this->expDeclineTot = $expTot;
    
    $this->procGdDecline = $procGD;
    $this->procGdDeclineTot = $procGdTot;
    
    $this->invDecline = $invalid;  
    $this->invDeclineTot = $invTot;
    
    $this->lostDecline = $invalid;  
    $this->lostDeclineTot = $invTot;
    
    $this->notProcCount = $notProc;
    $this->notProcTot = $notProcTot;
    $this->counter = $counter;

    
    
}
//===============================================================================================
function countCollections(){
    $day = date('d');
    $reportDate = date('F',strtotime("$this->month/$day/$this->year"));
    
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard2.js"></script>


<title>Collections Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Collections Report</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Counter</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Address</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount Owed</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Months Past Due</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Months Left On Contract</font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
    </tr>"; 
   
$dbMain = $this->dbconnect();
$this->serviceIdArray = "";
$cycDayCounter = 1;
$startDate = date('Y-m-d H:i:s',mktime(0,0,0,$this->month,1,$this->year));
$endDate = date('Y-m-d H:i:s',mktime(23,59,59,$this->month,date('t'),$this->year));
//echo "$startDate $endDate";
$stmt1 = $dbMain->prepare("SELECT DISTINCT contract_key, amount_owed, monthd_past_due FROM billing_collections WHERE contract_key!='' AND (collections_date BETWEEN '$startDate' AND '$endDate')");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($this->contractKey, $amount_owed, $monthd_past_due); 
while($stmt1->fetch()){
    
    
    $this->loadContactInfo();
    $stmt = $dbMain->prepare("SELECT MAX(end_date) FROM monthly_services WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($end_date); 
    $stmt->fetch();
    $stmt->close();
    
    $this->reportType = "CO";
            
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = 'CO' AND month = '$this->month' AND year = '$this->year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$contract_key'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotCallCell, $this->doNotCallHome, $this->doNotEmail, $this->doNotText, $this->doNotMail, $this->preferedContactMethod);
             $stmt99->fetch();
             $stmt99->close();  
            
           
           if($this->pSmsAtt == ""){
                $this->pSmsAtt = 0;
            }
            if($this->pCallAtt == ""){
                $this->pCallAtt = 0;
            }
            if($this->cSmsAtt == ""){
                $this->cSmsAtt = 0;
            }
            if($this->cCallAtt == ""){
                $this->cCallAtt = 0;
            }
            if($this->emailAtt == ""){
                $this->emailAtt = 0;
                }                 
    
    $endSecs = strtotime($end_date);
    $todaySecs = time();
    $diff = $endSecs - $todaySecs;
    
    if ($diff <= 0){
        $monthLeft = 0;
    }else{
        $monthLeft = round($diff/86400/30);
    }
       if($this->doNotCallCell == "Y"){
        $color = "red";
        $disabledCell = "<span class=\"c_call colorChange\">$this->cellPhone</span>";
    }else{
        $color = "black";
        $disabledCell = "<a class=\"c_call\" href=\"tel:$this->cellPhone\"><span id=\"c_phone\">$this->cellPhone</span></a>";
    }
    if($this->doNotCallHome == "Y"){
        $color = "red";
        $disabledHome = "<span class=\"p_call colorChange\">$this->primaryPhone</span>";
    }else{
        $color = "black";
        $disabledHome = "<a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>";
    }
    if($this->doNotText == "Y"){
        $color = "red";
        $disabledText1 = "<span class=\"p_sms colorChange\">SMS</span>";
        $disabledText2 = "<span class=\"c_sms colorChange\">SMS</span>";
    }else{
        $color = "black";
        $disabledText1 = "<a class=\"p_sms\">SMS</a>";
        $disabledText2 = "<a class=\"c_sms\">SMS</a>";
    }
    if($this->doNotEmail == "Y"){
        $color = "red";
        $disabledEmail = "<span class=\"email colorChange\">$this->email</span>";
    }else{
        $color = "black";
        $disabledEmail = "<a class=\"email\" href=\"mailto:$this->email\">$this->email</a>";
    }
       echo    "<tr>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$cycDayCounter</b></font>
            </td>    
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"contract_key\">$this->contractKey</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"name\">$this->firstName $this->lastName</span></b></b></font>
            </td> 
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$this->street &nbsp;$this->city, &nbsp;$this->state&nbsp; $this->zip</b></font>
            </td>  
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText1</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_sms_attempts\">$this->pSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledHome</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_call_attempts\">$this->pCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText2</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_sms_attempts\">$this->cSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledCell</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_call_attempts\">$this->cCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledEmail</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"email_attempts\">$this->emailAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$<span id=\"amount_owed\">$amount_owed</span></b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"months_past_due\">$monthd_past_due</span></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"month_left\">$monthLeft</span></b></font>
            </td>
            </tr>\n";
    $cycDayCounter++;
    
    
    $this->contractKey = "";
    $amount_owed = "";
    $monthd_past_due = "";
    $collections_date = "";
    $this->pSmsAtt =0;
                  $this->pCallAtt =0;
                  $this->cSmsAtt=0;  
                  $this->cCallAtt=0;
                  $this->emailAtt=0;  
                  $contract_key = 0;   
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";    
}
$stmt1->close(); 




echo  "</table>
</div>
</head>
</html>";
   
}
//==================================================================================================
//==============================================================================================
function fileMaker(){
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->pastDays);
    $stmt->fetch();
    $stmt->close();        
    
    if ($this->bool == 'R'){
        $this->checkLastReasonCode();
        }else if($this->bool == 'Q'){
            $this->countRecord();
        }else if($this->bool == 'C'){
            $this->countCollections();
        }
}
//===============================================

}
//$upload = new monthlyBillingPreview();
//$upload->fileMaker();


?>