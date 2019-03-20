<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class loadPastDue {

private $contractKey = null;
private $currentMonthDueDate = null;
private $nextPaymentDueDate = null;
private $monthsPastDue = null;
private $nextMonthDueDate = null;
private $settledCount = 0;
private $prePayCount = null;
private $monthlyCount = null;
private $todaysDate = null;
private $listType = null;
private $counter = 1;
private $color = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $clientStreet = null;
private $clientCity = null;
private $clientState = null;
private $clientZip = null;
private $daysPastDue = null;
private $monthlyPayment = null;
private $monthlyBillingType = null;
private $billingTotal = null;
private $lateFee = null;
private $pastDueHeader = null;
private $pastDueText = null;
private $defaultAttempts = null;
private $pastDueFreq = null;
private $attemptDate = null;
private $attemptNum = null;
private $finalNum = '10';
private $invoiceHeader = null;
private $finalHeader = null;
private $finalText = null;
private $currentStatementDate = null;
private $statementRangeEndDate = null;
private $statementRangeStartDate =  null;
private $businessName = null;
private $businessStreet = null;
private $businessCity = null;
private $businessState = null;
private $businessZip = null;
private $parseLength = 0;
private $invoice = null;
private $mailHeader = null;
private $mailFooter = null;
private $printableInvoice = null;
private $amendKey = null;
private $imageName = null;
private $pastDay = null;
private $nextDueDaysPast = null;
private $cycleDay = null;

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------
function filterPrepayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function filterCredits() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM service_credits WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->creditCount = $count;


$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function filterMonthlyPayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM monthly_payments WHERE contract_key='$this->contractKey' AND billing_amount != '0.00'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();


 $this->monthlyCount = $count;
   

$stmt->close();
}

//---------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();

$this->loadPastDay();

$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($next_payment_due_date);
$stmt->fetch(); 
$rowCount = $stmt->num_rows();
$stmt->close();

    if($rowCount == 0){
        echo "2";
        exit;
    }
    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay-$this->pastDay,$dueYear));
    $dueDateSecs = strtotime($dueDate);
   
    $customerBillingDate = date('d',strtotime($dueDate));
    
    if(date('d') < $customerBillingDate){
        $mStart = date('m')-1;//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }elseif(date('d') == $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }elseif(date('d') > $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }
    $currentDueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
    
    $startMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,1,$this->pastYear)));
    $endMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,date('t'),$this->pastYear)));
                     
    $this->filterPrepayments();
    $this->filterCredits();
    
    if($this->prePayCount == 0 AND $this->creditCount == 0) { 
                            
                if($next_payment_due_date != "") {
                                
                    $stmt1 = $dbMain ->prepare("SELECT MAX(payment_id), response_message FROM billing_scheduled_recuring_payments WHERE contract_key ='$this->contractKey'  AND response != '100'");
                    $stmt1->execute();      
                    $stmt1->store_result();      
                    $stmt1->bind_result($payment_id, $this->responseMessage);
                    $stmt1->fetch();
                    $stmt1->close();
                                
                    $datetime1 = new DateTime($dueDate);
                    $datetime2 = new DateTime($currentDueDate);
                    $interval = $datetime1-> diff($datetime2);                    
                    $this->daysPastDue = $interval-> format('%d'); 
                    $this->monthsPastDue = $interval-> format('%m'); 
                    $this->monthsPastDue++;
                    if ($this->monthsPastDue > 0){
                        $this->formatRecords();
                    }
                }elseif($next_payment_due_date == "") {
                                
                    $stmt1 = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key ='$this->contractKey'");
                    $stmt1->execute();      
                    $stmt1->store_result();      
                    $stmt1->bind_result($cycle_date);
                    $stmt1->fetch();
                    $stmt1->close();
   
                    //create the past due day and monthly cycle date from monthly payment
                    $cycle_day = date("d", strtotime($cycle_date));
                    $pastDueDay = $this->pastDay + $cycle_day;
                    $cycleMonth = date("m", strtotime($cycle_date));
                    $cycleYear = date("Y", strtotime($cycle_date));
                    $monthlyPaymentsDueDate= date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $cycleMonth, $pastDueDay, $cycleYear));
                    $monthlyPaymentsDueDateSecs = strtotime($monthlyPaymentsDueDate);
                    $todaysDateSecs = time();
                                 
                    if($todaysDateSecs >= $monthlyPaymentsDueDateSecs) {      
                        $datetime1 = new DateTime($monthlyPaymentsDueDate);
                        $datetime2 = new DateTime($currentDueDate);
                        $interval = $datetime1-> diff($datetime2);                    
                        $this->daysPastDue = $interval-> format('%d'); 
                        $this->monthsPastDue = $interval-> format('%m'); 
                        $this->monthsPastDue++;
                        if ($this->monthsPastDue > 0){            
                            $this->formatRecords(); 
                            }
                        }     
                                 
                    }
                          
                }
                  
   $contract_key = "";
   $next_payment_due_date = "";   
   $this->responseMessage = "";               
   

}
//--------------------------------------------------------------------------------------------------------------------
function loadPastDay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$this->pastDay = $past_day;

}
//---------------------------------------------------------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_nick, mailing_street, mailing_city, mailing_state, mailing_zip FROM business_info WHERE bus_id = '1000'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($businessName, $mailingStreet, $mailingCity, $mailingState, $mailingZip);
$stmt->fetch();

$this->businessName = $businessName;
$this->businessStreet = $mailingStreet;
$this->businessCity = $mailingCity;
$this->businessState = $mailingState;
$this->businessZip = $mailingZip;

$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------------
function insertPastDueAttempts() {

       $dbMain = $this->dbconnect();
       $sql = "INSERT INTO past_due_attempts VALUES (?, ?, ?, ?)";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('isid', $contractKey, $attemptDate, $numAttempts, $billingTotal);

       $contractKey = $this->contractKey; 
       $attemptDate = date("Y-m-d H:i:s");
       $numAttempts = $this->attemptNum;
       $billingTotal = $this->billingTotal;
       
       if(!$stmt->execute())  {
	      printf("Error: insertPastDueAttempts %s.\n", $stmt->error);
          }		

          $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updatePastDueAttempts() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE past_due_attempts SET num_attempts= ?, attempt_date= ?, billing_total= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('isd', $numAttempts, $attemptDate, $billingTotal);
     
     $attemptDate = date("Y-m-d H:i:s");
     $numAttempts = $this->attemptNum;
     $billingTotal = $this->billingTotal;

      if(!$stmt->execute())  {
	    printf("Error: updatePastDueAttempts%s.\n", $stmt->error);
        }		

     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function loadPastDueParameters() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_header, past_txt, past_attempts, past_freq, final_header, final_txt FROM invoice_options WHERE invoice_key = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($past_header, $past_txt, $past_attempts, $past_freq, $final_header, $final_txt);
$stmt->fetch();

$this->pastDueHeader = $past_header;
$this->pastDueText = $past_txt;
$this->defaultAttempts = $past_attempts;
$this->pastDueFreq = $past_freq;
$this->finalHeader = $final_header;
$this->finalText = $final_txt;

$stmt->close();  

}
//--------------------------------------------------------------------------------------------------------------------
function loadPastDueAttempts() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT attempt_date, num_attempts FROM past_due_attempts WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$rowCount = $stmt->num_rows;
$stmt->bind_result($attempt_date, $num_attempts);
$stmt->fetch();

$this->attemptDate = $attempt_date;
$this->attemptNum = $num_attempts;

$stmt->close(); 


if($rowCount > 0) {
          //creates the attmpt date ratio. if the date is greater than the interval then we process the query
         if($this->attemptDate != "") {
            $currentMonthDueDateSecs = strtotime($this->currentMonthDueDate);
            $attemptDateSecs = strtotime($this->attemptDate);
            $attemptDaysSecs = $this->pastDueFreq * 86400;
            $nextAttemptDateSecs = $attemptDateSecs + $attemptDaysSecs;   
            }

                  if($currentMonthDueDateSecs >= $nextAttemptDateSecs) {

                         If($this->attemptNum == $this->defaultAttempts) { 

                                 switch($this->attemptNum) {          
                                          case"1":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"2":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"3":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"4":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                        }      
                                        
                            }elseif($this->attemptNum <  $this->defaultAttempts) {
                            
                                 switch($this->attemptNum) {          
                                          case"1":
                                          $this->invoiceHeader = 'SECOND NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updatePastDueAttempts();
                                          break;
                                          case"2":
                                          $this->invoiceHeader = 'THIRD NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updatePastDueAttempts();
                                          break;
                                          case"3":
                                          $this->invoiceHeader = 'FOURTH NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updatePastDueAttempts();
                                          break;
                                          case"4":
                                          $this->invoiceHeader = 'FINAL NOTICE'; 
                                          $this->updatePastDueAttempts();
                                          break;
                                        }                                  
                            }
                                                        
                     }

  }else{
                     
  $this->invoiceHeader = 'FIRST NOTICE';
  $this->attemptNum = 1;
  $this->insertPastDueAttempts();
                     
                     
 }
//end rowcount

}
//--------------------------------------------------------------------------------------------------------------------
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
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

        
               
                    if($this->monthsPastDue >= 1) {
                        $this->monthlyPayment = ($this->monthlyPayment * $this->monthsPastDue) + $this->lateFee;     
                    }else{
                     $this->monthlyPayment = 0;
                     }
  


$this->billingTotal = $this->monthlyPayment;
$this->billingTotal = number_format("$this->billingTotal",2);

$this->monthlyPayment = number_format("$this->monthlyPayment",2);

 if(!$stmt->execute())  {
	printf("Error: loadMonthlyPayment%s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//------------------------------------------------------------------------------------------------------------------
function loadContactInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($first_name, $middle_name, $last_name, $primary_phone, $cell_phone, $email, $street, $city, $state, $zip);
$stmt->fetch();

$this->firstName = $first_name;
$this->middleName = $middle_name;
$this->lastName = $last_name;
$this->primaryPhone = $primary_phone;
$this->cellPhone = $cell_phone;
$this->emailAddress = $email;
$this->clientStreet = $street;
$this->clientCity = $city;
$this->clientState = $state;
$this->clientZip = $zip;

$stmt->close();

}
//------------------------------------------------------------------------------------------------------------------
function parseInvoices() {
    
include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();
$this->loadBusinessInfo();
$this->loadFees();
$this->loadPastDueParameters();
$this->counter = 1;
$this->parseLength = 0;
   

//creates the invoice number
$invoiceSalt = rand(1000, 9000);
$sep = '-';
$invoiceNumber = "$this->contractKey$sep$invoiceSalt";
//echo $invoiceNumber;
//exit;
$in = in;


$this->invoice = <<<PARSEINVOICES
<div class="printBreak">
<table align="center" width="76%" cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" class="threeEight">
<div id="fromWindow$this->parseLength" class="fromWindow">
$this->businessName
<br>
$this->businessStreet
<br>
$this->businessCity $this->businessState $this->businessZip
</div>
</td>
<td class="threeEight">
<div id="logoInfo$this->parseLength" class="logoInfo">
<a href="javascript: void(0)" onClick="printPage()"><img class="displayed" src="../images/$image_name" width="118" height="46"></a>
Invoice Number: &nbsp; $invoiceNumber
Statement Date:  &nbsp; $this->currentStatementDate
<br>
Contract Number: &nbsp; $this->contractKey
</div>
</td>
</tr>

<tr>
<td class="toSpacer">
<div id="toWindow$this->parseLength" class="toWindow">
$this->firstName $this->middleName $this->lastName
<br>
$this->clientStreet
<br>
$this->clientCity $this->clientState $this->clientZip
</div>
</td>
<td class="threeEightTwo">
<div id="noteLable$this->parseLength" class="noteLable">
Note:
</div>
</td>
<td class="threeEightThree">
<div id="noteText$this->parseLength" class="noteText">
$this->pastDueText  <br><br><br>
</div>
</td>
</tr>

<tr>
<td align="left" colspan="2" class="threeEightFour">
<span class="left">
Statement Period:  $this->statementRangeStartDate - $this->statementRangeEndDate  
</span>
</td>
<td align="right" class="threeEightFour">
<span class="right">
$this->invoiceHeader
</span>
</div>
</td>
</tr>

<tr>
<td align="center" colspan="3">
<div id="bodyTable$this->parseLength" class="bodyTable">
<div id="bodyTableHeader$this->parseLength" class="bodyTableHeader">
<table id="tHead0" width="100%">
<tr>
<th align="left" class="innerOne">
DATE
</th>
<th align="left" class="innerOne">
CHECK #
</th>
<th align="left" class="innerOne">
DESCRIPTION
</th>
<th align="left" class="innerOne">
CHARGES
</th>
<th align="left" class="innerOne">
CREDITS
</th>
<th align="left" class="innerOne">
BALANCE
</th>
</tr>
</div>

<tr>
<td align="left" class="innerTwo">
$this->currentStatementDate
</td>
<td align="left" class="innerTwo">
&nbsp;
</td>
<td align="left" class="innerTwo">
Monthly Dues
</td>
<td align="left" class="innerTwo">
$this->monthlyPayment
</td>
<td align="left" class="innerTwo">
0.00
</td>
<td align="left" class="innerTwo">
$this->monthlyPayment
</td>
</tr>

<tr>
<td align="left" class="innerTwo">
$this->currentStatementDate
</td>
<td align="left" class="innerTwo">
&nbsp;
</td>
<td align="left" class="innerTwo">
Late Fee
</td>
<td align="left" class="innerTwo">
$this->lateFee
</td>
<td align="left" class="innerTwo">
0.00
</td>
<td align="left" class="innerTwo">
$this->billingTotal
</td>
</tr>

<tr>
<td align="left" class="innerTwo"> 
Credit Card was Declined by Bank because: $this->responseMessage.
</td>
</tr>

</table>
</div>
</td>
</tr>

<tr>
<td colspan="3" align="center" class="threeEightFive">
<div id="dueSum$this->parseLength" class="dueSum">
Total Due on Receipt: &nbsp; $this->billingTotal
</div>
</td>
</tr>

<tr>
<td align="left" class="threeEightFive">
<div id="makePayment$this->parseLength" class="makePayment">
<span class="blackBold">MAKE PAYMENT</span>
<br>
<span class="lightItalic">If mailing a check or money order please include your member number</span>
<p>
<span class="lightItalic">Make checks payable to: &nbsp; $this->businessName</span>
<br>
<span class="lightItalic">Mail payments to: &nbsp; $this->businessStreet $this->businessCity $this->businessState $this->businessZip</span>
</p>
<p>
<span class="lightNormal">$this->firstName $this->middleName $this->lastName</span>
<br>
<span class="lightNormalTwo">Statement Date: &nbsp; $this->currentStatementDate</span>
<br>
<span class="lightNormalTwo">Invoice Number: &nbsp; $invoiceNumber</span>
<br>
<span class="lightNormalTwo">Member Number: &nbsp; $this->contractKey</span>
<br><br>
<span class="lightNormalThree">Please fill in Total Amount Paid ________________</span>
</p>
</div>
</td>

<td align="right" colspan="2">
<div id="makePaymentTwo$this->parseLength" class="makePaymentTwo">
<div id="keyContent$this->parseLength" class="keyContent">

<div id="whiteOne$this->parseLength" class="whiteOne">
</div>
<div id="checkTextOne$this->parseLength" class="checkTextOne">
<span class="keyText">Credit Card</span>
</div>
<div id="whiteTwo$this->parseLength" class="whiteTwo">
</div>
<div id="checkTextTwo$this->parseLength" class="checkTextTwo">
<span class="keyText">Check</span>
</div>
<div id="whiteThree$this->parseLength" class="whiteThree">
</div>
<div id="checkTextThree$this->parseLength" class="checkTextThree">
<span class="keyText">Money Order</span>
</div>

<div id="makePayTwoB$this->parseLength" class="makePayTwoB">
<span class="lightNormalThree">Card Number _______________________________</span>
</div>

<div class="spacer">
<div id="whiteOneB$this->parseLength" class="whiteOneB">
</div>
<div id="checkTextOneB$this->parseLength" class="checkTextOneB">
<span class="keyText">Mastercard&nbsp;</span>
</div>
<div id="whiteTwoB$this->parseLength" class="whiteTwoB">
</div>
<div id="checkTextTwoB$this->parseLength" class="checkTextTwoB">
<span class="keyText">Visa&nbsp;</span>
</div>
<div id="whiteThreeB$this->parseLength" class="whiteThreeB">
</div>
<div id="checkTextThreeB$this->parseLength" class="checkTextThreeB">
<span class="keyText">AMEX</span>
</div>
<div id="whiteFourB$this->parseLength" class="whiteFourB">
</div>
<div id="checkTextFourB$this->parseLength" class="checkTextFourB">
<span class="keyText">Disc</span>
</div>

<div id="makePayTwoC$this->parseLength" class="makePayTwoC">
<span class="lightNormalThree">Name On Card _______________________________</span>
<p>
<span class="lightNormalThree">Expiration Date (Month/ Year) _____________</span>
</p>
<p>
<span class="lightNormalThree">Security Code _____________</span>
</p>
<p>
<span class="lightNormalThree">Signature _______________________________</span>
</p>
</div>

</div>
</div>
</div>

</td>
</tr>
</table>
</div>\n\n
PARSEINVOICES;


$this->invoiceEmail = <<<PARSEINVOICES2
<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="reportName"> 
<span class="black5"><b><u>From:</u></b></span>
&nbsp;
<span class="black6"><strong>$this->businessName
<br>
$this->businessStreet
<br>
$this->businessCity $this->businessState $this->businessZip</strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b>Invoice Number:</b></span>
&nbsp;
<span class="black6"><strong>$invoiceNumber</strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b>Statement Date:</b></span>
&nbsp;
<span class="black6"><strong>$this->currentStatementDate</strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b>Contract Number:</b></span>
&nbsp;
<span class="black6"><strong>$this->contractKey</strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b><u>To:</u></b></span>
&nbsp;
<span class="black6"><strong>$this->firstName $this->middleName $this->lastName
<br>
$this->clientStreet
<br>
$this->clientCity $this->clientState $this->clientZip</strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b>Note:</b></span>
&nbsp;
<span class="black6"><strong>$this->pastDueText </strong></span>
</div>
<br>
<div id="reportName"> 
<span class="black5"><b>Statement Period:</b></span>
&nbsp;
<span class="black6"><strong>$this->statementRangeStartDate - $this->statementRangeEndDate   </strong></span>
</div>
<br>
<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">DATE</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">CHECK #</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">DESCRIPTION</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">CHARGES</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">CREDITS</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">BALANCE</font></th>
</tr>

<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->currentStatementDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>Monthly Dues</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->monthlyPayment</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>0.00</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->billingTotal</b></font>
</td>
</tr>

<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->currentStatementDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>Late Fee</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->lateFee</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>0.00</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"grey\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->billingTotal</b></font>
</td>
</tr>

<div id="reportName"> 
<span class="black5"><b>Decline Reason:</b></span>
&nbsp;
<span class="black6"><strong>$this->responseMessage</strong></span>
</div>

<div id="reportName"> 
<span class="black5"><b>Total Due on Receipt:</b> &nbsp;</span>
&nbsp;
<span class="black6"><strong>$this->billingTotal</strong></span>
</div>


<tr>
<td align="left" class="threeEightFive">
<div id="makePayment$this->parseLength" class="makePayment">
<span class="blackBold"><strong>MAKE PAYMENT</strong></span>
<br>
<span class="lightItalic"><b>If mailing a check or money order please include your member number<b></span>
<p>
<span class="lightItalic"><b>Make checks payable to:</b> &nbsp; $this->businessName</span>
<br>
<span class="lightItalic"><b>Mail payments to:</b> &nbsp; $this->businessStreet $this->businessCity $this->businessState $this->businessZip</span>
</p>
<p>
<span class="lightNormal">$this->firstName $this->middleName $this->lastName</span>
<br>
<span class="lightNormalTwo"><b>Statement Date:</b> &nbsp; $this->currentStatementDate</span>
<br>
<span class="lightNormalTwo"><b>Invoice Number:</b> &nbsp; $invoiceNumber</span>
<br>
<span class="lightNormalTwo"><b>Member Number:</b> &nbsp; $this->contractKey</span>
<br><br>
<span class="lightNormalThree"><b>Please fill in Total Amount Paid</b> ________________</span>
</p>
</div>
</td>

<td align="right" colspan="2">
<div id="makePaymentTwo$this->parseLength" class="makePaymentTwo">
<div id="keyContent$this->parseLength" class="keyContent">

<div id="whiteOne$this->parseLength" class="whiteOne">
</div>
<div id="checkTextOne$this->parseLength" class="checkTextOne">
<span class="keyText"><b>(CIRCLE ONE)</b>  Credit Card</span>
</div>
<div id="whiteTwo$this->parseLength" class="whiteTwo">
</div>
<div id="checkTextTwo$this->parseLength" class="checkTextTwo">
<span class="keyText">Check</span>
</div>
<div id="whiteThree$this->parseLength" class="whiteThree">
</div>
<div id="checkTextThree$this->parseLength" class="checkTextThree">
<span class="keyText">Money Order</span>
</div>
<br>
<div id="makePayTwoB$this->parseLength" class="makePayTwoB">
<span class="lightNormalThree">Card Number _______________________________</span>
</div>

<div class="spacer">
<div id="whiteOneB$this->parseLength" class="whiteOneB">
</div>
<div id="checkTextOneB$this->parseLength" class="checkTextOneB">
<span class="keyText"><b>(CIRCLE CARD TYPE)</b> Mastercard&nbsp;</span>
</div>
<div id="whiteTwoB$this->parseLength" class="whiteTwoB">
</div>
<div id="checkTextTwoB$this->parseLength" class="checkTextTwoB">
<span class="keyText">Visa&nbsp;</span>
</div>
<div id="whiteThreeB$this->parseLength" class="whiteThreeB">
</div>
<div id="checkTextThreeB$this->parseLength" class="checkTextThreeB">
<span class="keyText">AMEX</span>
</div>
<div id="whiteFourB$this->parseLength" class="whiteFourB">
</div>
<div id="checkTextFourB$this->parseLength" class="checkTextFourB">
<span class="keyText">Disc</span>
</div>
<br>

<div id="makePayTwoC$this->parseLength" class="makePayTwoC">
<span class="lightNormalThree"><b>Name On Card</b> _______________________________</span>
<p>
<span class="lightNormalThree"><b>Expiration Date (Month/ Year)</b> _____________</span>
</p>
<p>
<span class="lightNormalThree"><b>Security Code</b> _____________</span>
</p>
<p>
<span class="lightNormalThree"><b>Signature</b> _______________________________</span>
</p>
</div>

</div>
</div>
</div>

</td>
</tr>
</table>
</div>\n\n
PARSEINVOICES2;

}
//--------------------------------------------------------------------------------------------------------------------------
function formatRecords() {

$this->currentMonthDueDate =  date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , $this->nextDueDaysPast, date("Y")));
$this->nextMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $this->nextDueDaysPast, date("Y")));

$this->currentStatementDate =  date("m-d-Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$this->statementRangeEndDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m"), $this->nextDueDaysPast, date("Y")));
$this->statementRangeStartDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m")-1  , $this->cycleDay, date("Y")));

          //create color rows
            static $cell_count = 1;
                  if($cell_count == 2) {
                      $this->color = "#D8D8D8";
                      $cell_count = "";
                      }else{
                      $this->color = "#FFFFFF";
                                   }
                      $cell_count = $cell_count + 1;

         
$this->loadContactInfo();
$this->loadMonthlyPayment();  
$this->loadPastDueAttempts();               
$this->parseInvoices();
       
$this->mailFooter = "</body>\n</html>"; 
$this->printableInvoice = "$this->mailHeader \n $this->invoice \n $this->mailFooter";

}
//------------------------------------------------------------------------------------------------------------------
function loadListType() {
  
  $this->loadHeader();
  $this->loadRecordCount();
}
//--------------------------------------------------------------------------------------------------------------------
function loadHeader() {

$titleDiv = "";
$cssFIle = 'mail4.css';
 // $printFile ="<link rel=\"stylesheet\"  media=\"print\" href=\"../css/printInvoice.css\">";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";
   
$this->mailHeader = <<<LISTINGS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$printFile
$javaScript1
$javaScript2

<title>Past Due $this->currentStatementDate</title>

</head>
<body>
LISTINGS;
}
//-------------------------------------------------------------------------------------------------------------------
function getPrintableInvoice() {
             return($this->printableInvoice);
             }
function getPrintableInvoiceEmail() {
             return($this->invoiceEmail);
             }
function getBusinessName() {
             return($this->businessName);
             }

}//end class
//----------------------------------------------------------------------
$contract_key = $_REQUEST['contractKey'];
$ajax_switch = $_REQUEST['ajaxSwitch'];
$emailBool = $_REQUEST['emailBool'];

//echo "$contract_key";
//exit;
if($ajax_switch == 1) {
  $checkPast = new loadPastDue();
  $checkPast-> setContractKey($contract_key);
  $checkPast-> loadListType();
  $record = $checkPast-> getPrintableInvoice();
  $recordEmail = $checkPast-> getPrintableInvoiceEmail();
  $business_name = $checkPast-> getBusinessName();
  if($emailBool == 1){
    //echo"fubar";
    //exit;
    $headers  = "From: $business_name@$business_name.com\r\n";
    $headers .= "Content-type: text/html\r\n"; 
    mail('christopherparello@gmail.com','past due invoice',$recordEmail,$headers);
    echo"3";
    exit;
  }else{
    echo"$record";
    exit;
  }
  
  }











?>