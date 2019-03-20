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



function setAmendKey($amendKey) {
              $this->amendKey = $amendKey;
              }

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setTodaysDate($todaysDate) {
              $this->todaysDate = $todaysDate;
              }

function setListType($listType) {
              $this->listType = $listType;
              }

function setImageName($imageName) {
              $this->imageName = $imageName;
              }
              
function  setPastMonth($pastMonth){
              $this->pastMonth = $pastMonth;
              }
function  setPastYear($pastYear){
              $this->pastYear = $pastYear;
              }
              
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadPdf() {

$monthlyInvoiceDate = date('mdy',strtotime($this->currentStatementDate));

//load the directory path since this is subject to change with each client
$directoryPath = $_SERVER['DOCUMENT_ROOT'];
$directoryArray = explode("/",$directoryPath);
$domainDir = $directoryArray[6];

array_map('unlink', glob("/var/www/vhosts/ems/$domainDir/admin/pastdue/*.pdf"));

$fileName = "PastDue$this->currentStatementDate.pdf";
$invoiceSalt = rand(1000, 9000);
$tempFile = "testFile$invoiceSalt.html";
$contentFile = "/var/www/vhosts/ems/$domainDir/admin/pastdue/$tempFile";

file_put_contents($contentFile, $this->printableInvoice);

exec("/usr/local/bin/wkhtmltopdf  -s Letter --outline -T 0 -B 0 -R 0 -L 0 $contentFile /var/www/vhosts/ems/$domainDir/admin/pastdue/$fileName");

unlink("$contentFile");

//rename the file so it is more legible for download
$fileDate = date("m_d_Y", $monthlyInvoiceDate);
$newFileName = "Past_Due_$fileDate.pdf";

rename("/var/www/vhosts/ems/$domainDir/admin/pastdue/$fileName", "/var/www/vhosts/ems/$domainDir/admin/pastdue/$newFileName");


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
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadStatusCount() {
    $totalCount = 0;
$dbMain = $this->dbconnect();
$stmt99 = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
$stmt99->execute();
$stmt99->store_result();
$stmt99->bind_result($service_id);
while($stmt99->fetch()){
    $stmt = $dbMain ->prepare("SELECT count(*) as count FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$service_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $totalCount += $count;
    }
$stmt99->close();

 
$this->statusCount = $totalCount;


}
//---------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();

$this->loadPastDay();

$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, next_payment_due_date FROM monthly_settled WHERE contract_key != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->contractKey, $next_payment_due_date);

 while ($stmt->fetch()) {

    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay,$dueYear));
    $dueDateSecs = strtotime($dueDate);
    
    $startMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,1,$this->pastYear)));
    $endMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,date('t'),$this->pastYear)));
    
    if($dueDateSecs > $startMonthSecs AND $dueDateSecs < $endMonthSecs){

            $this->reportType = "PD";
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = 'PD' AND month = '$this->pastMonth' AND year = '$this->pastYear'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$this->contractKey'");
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

        $this->loadStatusCount();
        $this->filterPrepayments();
        $this->filterCredits();


        echo "test $this->contractKey $this->prePayCount $this->creditCount  $this->statusCount <br>";


                       if($this->prePayCount == 0 AND $this->creditCount == 0 AND $this->statusCount != 0) {

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
                            if($next_payment_due_date != "") {
                                
                                $stmt1 = $dbMain ->prepare("SELECT MAX(payment_id), processor_response FROM batch_recuring_payments WHERE contract_key ='$this->contractKey'  AND response != '100'");
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
                  } 
                  $contract_key = "";
                  $next_payment_due_date = "";   
                  $this->responseMessage = ""; 
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
 
 
$stmt->close();

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

  //check to see if the amendKey is set by the user. If so then we do an insert if there is no record
  if($this->amendKey != null)  {

       $dbMain = $this->dbconnect();
       $sql = "INSERT INTO past_due_attempts VALUES (?, ?, ?, ?)";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('isid', $contractKey, $attemptDate, $numAttempts, $billingTotal);

       $contractKey = $this->contractKey; 
       $attemptDate = date("Y-m-d H:i:s");
       $numAttempts = $this->attemptNum;
       $billingTotal = $this->billingTotal;
       
       if(!$stmt->execute())  {
	      printf("Error: %s.\n", $stmt->error);
          }		

          $stmt->close(); 
    }
}
//--------------------------------------------------------------------------------------------------------------------
function updatePastDueAttempts() {

  //check to see if the amendKey is set by the user. If so then we do an update if there is a record
  if($this->amendKey != null)  {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE past_due_attempts SET num_attempts= ?, attempt_date= ?, billing_total= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('isd', $numAttempts, $attemptDate, $billingTotal);
     
     $attemptDate = date("Y-m-d H:i:s");
     $numAttempts = $this->attemptNum;
     $billingTotal = $this->billingTotal;

      if(!$stmt->execute())  {
	    printf("Error: %s.\n", $stmt->error);
        }		

     $stmt->close(); 

    }
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
$stmt = $dbMain ->prepare("SELECT COUNT(*) as count, attempt_date, num_attempts FROM past_due_attempts WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
//$rowCount = $stmt->num_rows;
$stmt->bind_result($count, $attempt_date, $num_attempts);
$stmt->fetch();

$this->attemptDate = $attempt_date;
$this->attemptNum = $num_attempts;

$stmt->close(); 


if($count > 0) {
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
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
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
function sendEmail() {
if($this->emailAddress != "" AND $this->doNotEmail != 'Y') {

mail("$this->emailAddress", "$this->invoiceHeader Past Due",

"Hello, $this->firstName $this->middleName $this->lastName

$this->pastDueText
 
Past Due Amount:  $this->monthlyPayment

Thank you,
$this->businessName

(c)$this->businessName.",
"From: $this->businessName<info@burbankathleticclub.com>","-finfo@burbankathleticclub.com"); 

}



 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>  
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->emailAddress</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->monthsPastDue</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->monthlyPayment</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->invoiceHeader</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"#006633\"><b>INVOICE EMAIL SUCCESSFUL </b></font>
</td>
</tr>\n";

}
//------------------------------------------------------------------------------------------------------------------
function createPhoneList() {
    
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
        $disabledEmail = "<span class=\"email colorChange\">$this->emailAddress</span>";
    }else{
        $color = "black";
        $disabledEmail = "<a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>";
    }

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b>$this->counter</b></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"contract_key\">$this->contractKey</span></b></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"name\">$this->firstName $this->middleName $this->lastName</span></b></b></font>
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
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"monthsPast\">$this->monthsPastDue</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"payment\">$this->monthlyPayment</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"response\">$this->responseMessage</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<input type=\"button\" name=\"past\"  id=\"past\" class=\"button1\" value=\"View\" onClick=\"return setContractRecord('$this->contractKey');\"/>
</td>
<input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
<input type=\"hidden\" id=\"month\" value=\"$this->month\"/>
<input type=\"hidden\" id=\"year\" value=\"$this->year\"/>
</tr>\n";

}
//------------------------------------------------------------------------------------------------------------------
function parseInvoices() {

if($this->counter == 1) {
   $this->parseLength = 0;
   }else{
   $this->parseLength = 11;
   }

//creates the invoice number
$invoiceSalt = rand(1000, 9000);
$sep = '-';
$invoiceNumber = "$this->contractKey$sep$invoiceSalt";

$in = in;


$this->invoice .= <<<PARSEINVOICES
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
<a href="javascript: void(0)" onClick="printPage()"><img class="displayed" src="../images/$this->imageName" width="118" height="46"></a>
<br>
Invoice Number: &nbsp; $invoiceNumber
<br>
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
$this->pastDueText  
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

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->primaryPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->cellPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"mailto:$this->emailAddress\">$this->emailAddress</a></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->monthsPastDue</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->monthlyPayment</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->responseMessage</b></font>
</td>
</tr>\n";

}
//--------------------------------------------------------------------------------------------------------------------------
function formatRecords() {
    
$dbMain = $this->dbconnect();

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

  

                                                                                                
  switch($this->listType) {          
               case"phone":
               $this->loadContactInfo();
               $this->loadMonthlyPayment();
               $this->createPhoneList();
               break;
               case"email":
               $this->loadContactInfo();
               $this->loadMonthlyPayment();  
               $this->loadPastDueAttempts();
               $this->sendEmail();
               break;
               case"mail":
                if($this->doNotMail != 'N'){
               $this->loadContactInfo();
               $this->loadMonthlyPayment();  
               $this->loadPastDueAttempts();               
               $this->parseInvoices();
               }
               break;
             }   
             
$stmt = $dbMain ->prepare("SELECT member_id FROM member_info WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($memberId);
$stmt->fetch();
$stmt->close();



$userId = '54';
$noteDate = date("Y-m-d H:i:s");
$amPm = 'PM';
$noteTopic = 'Member Past Due';
$noteMessage = "This member is Past Due $$this->billingTotal. Decline reason: $this->responseMessage.";
$noteCategory = 'BL';
$priority = 'H';
$targetApp = 'MI';

//echo "cid $this->contractKey memberID $memberID <br>$this->contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp<br><br>";
$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssssiss',$this->contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
$stmt->close();                   

$this->counter++;
         
     


if($this->listType != "mail") {
   echo"</div>\n</body>\n</html>";
   }else{   
   $this->mailFooter = "</body>\n</html>"; 
   $this->printableInvoice = "$this->mailHeader \n $this->invoice \n $this->mailFooter";
   }

}
//------------------------------------------------------------------------------------------------------------------
function loadListType() {

  switch($this->listType) {          
               case"phone":
               $this->loadHeader();
               $this->loadRecordCount();
               break;
               case"email":
               $this->loadHeader();
               $this->loadRecordCount();
               break;
               case"mail":
               $this->loadHeader();
               $this->loadRecordCount();
               break;
             }
}
//--------------------------------------------------------------------------------------------------------------------
function loadHeader() {

if($this->listType == "phone") {
  $titleDiv = "
  <div id=\"userHeader\">
   Past Due Phone List 
  </div>";
  $cssFIle = 'phoneEmail.css';
  $tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
  $tabHead = "<style>
  a:hover{
    cursor: pointer;
    cursor: hand;
    }
  .p_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .c_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #email_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .colorChange{
        color: red;
        
    }
  </style>
  <tr>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Months Past Due</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount Owed with late fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Processor Response</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">View Account</font></th>
  </tr>\n";     
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/setContractRecord.js\"></script>";
  }
  
if($this->listType == "email") {
  $titleDiv = "
  <div id=\"userHeader\">
   Past Due Email List 
  </div>";
  $cssFIle = 'phoneEmail.css';
  $tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
  $tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Client Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Days Past Due</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invoice Status</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Status</font></th>
  </tr>\n";       
  }  

if($this->listType == "mail") {
  $titleDiv = "";
  $cssFIle = 'mail4.css';
 // $printFile ="<link rel=\"stylesheet\"  media=\"print\" href=\"../css/printInvoice.css\">";
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";
  }  

if($this->listType != "mail") {

$listingsHeader = <<<LISTINGS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard.js"></script>
<link rel="stylesheet" href="../css/$cssFIle">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Past Due $this->currentStatementDate</title>

</head>
<body>
<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>
<br>
$titleDiv

<div id="listings">
$tableHeadTag
$tabHead
LISTINGS;

echo"$listingsHeader";

}else{

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


//this spits out the list of members while the pdf is being generated
$titleDiv = "
<div id=\"userHeader\">
 Past Due Invoiced
</div>";

$cssFIle = 'mailList.css';
$tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
$tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Client Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Days Past Due</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Processor Response</font></th>
  </tr>\n";        
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/downLoadPdf.js\"></script>";



$listingsHeaderMail = <<<LISTINGSLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Past Due $this->currentStatementDate</title>

</head>
<body>

$titleDiv

<div id="listings">
$tableHeadTag
$tabHead
LISTINGSLIST;

echo"$listingsHeaderMail";


}

}
//-------------------------------------------------------------------------------------------------------------------
function getPrintableInvoice() {
             return($this->printableInvoice);
             }


}//end class
//----------------------------------------------------------------------
/*
$todays_date = date("Y-m-d");

if($ajax_switch == 1) {
  $checkPast = new checkPastDue();
  $checkPast-> setTodaysDate($todays_date);
  $checkPast-> loadCycleDate();
  $record_count = $checkPast-> loadRecordCount();
  echo"$record_count";
  exit;
  }

*/









?>