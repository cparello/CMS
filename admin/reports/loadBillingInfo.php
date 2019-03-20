<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  balData{

function setFee($fee){
    $this->fee = $fee;
}
function setBillProb($billProb){
    $this->billProb = $billProb;
}
function setBatch($batch){
    $this->batch = $batch;
}
function  setMeth($meth){
     $this->meth = $meth;
}
//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {
 
    
    $dbMain = $this->dbconnect();
    
    switch($this->meth){
        case 'CC'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'CC'";
        break;
        case 'ACH'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'ACH'";
        break;
        case '0':
            $sqlSearch2 = "AND transaction_type != ''";
        break;
        }
   
    $this->reportType = 'BX';
    
    switch($this->billProb){
        case '0'://all bill probs
            $sqlSearch = "batch_id = '$this->batch' AND response != '100' AND response != '202'";
        break;
        case '1':// all active
            $sqlSearch = "batch_id = '$this->batch'";
        break;
        case 'EXP'://expired
            $sqlSearch = "batch_id = '$this->batch' AND response = '223'";
        break;
        case 'MIS'://missing info
            $sqlSearch = "batch_id = '$this->batch' AND response = '440'";
        break;
        case 'STOP'://stop pay
            $sqlSearch = "batch_id = '$this->batch' AND response = '261'";
        break;
        case 'DUP'://duplicates
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'INV':// invalid card
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'STATE'://stop pay by customer
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'DEC'://all dec;lines
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'NSF'://nsf
           $sqlSearch = "batch_id = '$this->batch' AND response = '202'";
        break;
        case 'PICK'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '250' OR response = '251' OR response = '252' OR response = '252')";
        break;
        case 'ISS'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '200' OR response = '204')";
        break;
    }
   
    
    $bool = 0;
    $counter = 1;
  
  //$this->rows .= "<div id=\"totals\"> <h2>Renewal List:</h2>
 // </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Code</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Response</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  </tr>
  </thead>
  <tbody>"; 
  
  
  
  
  $stmt3 = $dbMain ->prepare("SELECT SUM(billing_amount), COUNT(*) as count FROM batch_recurring_records WHERE $sqlSearch $sqlSearch2");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($total, $numTrans);
    $stmt3->fetch();
    $stmt3->close();
    
    $stmt3 = $dbMain ->prepare("SELECT SUM(billing_amount), COUNT(*) as count FROM batch_recurring_records WHERE batch_id = '$this->batch' AND response != '100'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($totalFailed, $numTransFailed);
    $stmt3->fetch();
    $stmt3->close();
    
    $stmt3 = $dbMain ->prepare("SELECT SUM(billing_amount), COUNT(*) as count FROM batch_recurring_records WHERE batch_id = '$this->batch' AND response = '100'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($totalApproved, $numTransApproved);
    $stmt3->fetch();
    $stmt3->close();
    
    $totTrans = $numTransFailed + $numTransApproved;
    $percentSuccess = round(($numTransApproved/$totTrans)*100);
    
    $stmt3 = $dbMain ->prepare("SELECT contract_key, billing_amount, response, processor_response, cycle_start_month, cycle_start_year, processed FROM batch_recurring_records WHERE $sqlSearch $sqlSearch2");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->amount, $this->response, $this->procResponse, $month, $year, $processed);
    while($stmt3->fetch()){
        $this->expDate = date("M j, Y" ,strtotime($end_date));
       
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
        $stmt->fetch();
        $stmt->close();
        
        if(preg_match('/000/',$this->primaryPhone)){
            $this->primaryPhone = $this->cellPhone;
        }
    
        $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
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
                $disabledEmail = "<span id=\"email\" class=\"email colorChange\">$this->emailAddress</span>";
            }else{
                $color = "black";
                $disabledEmail = "<a id=\"email\" class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>";
            }             
            
        
        
        if($bool == 0){
            $className = "row1";
            $bool = 1;
        }elseif($bool == 1){
            $className = "row2";
            $bool = 0;
        }
        if($processed == "N"){
            $this->rows .=   " 
                <tr  class=\"$className tableCenter\">
                <td>
                $counter
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($this->contractKey);\" ><span id=\"contract_key\">$this->contractKey</span></a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($this->contractKey);\" ><span id=\"name\">$this->firstName $this->middleName $this->lastName</span></a>
                </td> 
                <td>
                $disabledText1
                </td>
                <td>
                <span id=\"p_sms_attempts\">$this->pSmsAtt</span>
                </td>
                <td>
                $disabledHome
                </td>
                <td>
                <span id=\"p_call_attempts\">$this->pCallAtt</span>
                </td>
                <td>
                $disabledEmail
                </td>
                <td>
                <span id=\"email_attempts\">$this->emailAtt</span>
                </td>
                <td>
                <span id=\"response\">$this->response</span>
                </td>
                <td>
                <span id=\"pResponse\">$this->procResponse</span>
                </td>
                <td>
                <span id=\"price\">$this->amount</span>
                </td>
                <input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
                <input type=\"hidden\" id=\"month\" value=\"$month\"/>
                <input type=\"hidden\" id=\"year\" value=\"$year\"/>
                </tr>\n";
        }
        

                        
        
        $count++;
        $counter++;
        $balance_due  = "";
        $todays_payment  = "";
        $min_total_due  = "";
        $due_date  = "";
        $contract_key  = "";
        $mem_fname  = "";
        $mem_lname  = "";
        $this->doNotCallCell  = "";
        $this->doNotCallHome  = "";
        $this->doNotEmail  = "";
        $this->doNotText  = "";
        $this->doNotMail  = "";
        $this->preferedContactMethod  = "";
        $this->pSmsAtt  = "";
        $this->pCallAtt  = "";
        $this->cSmsAtt  = "";
        $this->cCallAtt   = "";
        $this->emailAtt  = "";
        $this->contractKey  = "";
        $this->monthlyBillingType  = "";
        $this->amount  = "";
        $this->response  = "";
        $this->procResponse  = "";
        $month  = "";
        $year  = "";
        $processed = "";
    }
    $stmt3->close();

    
     $this->rows .= "</tbody></table>";
     
     $firstRow = " <div id=\"totals\">
                          <span id=\"tot1\">Report:</span>
                          <span id=\"tot2\"><u>Selection Total</u><br>  $$total</span>
                          <span id=\"tot3\"><u>Number of Transactions</u><br>  $numTrans</span>
                          <span id=\"tot4\"></span>
                          <span id=\"tot5\">Batch:</span>
                          <span id=\"tot6\"><u>Amount Approved</u><br>  $$totalApproved</span>
                          <span id=\"tot7\"><u>Number Approved</u><br>  $numTransApproved</span>
                          <span id=\"tot8\"><u>Amount Failed</u><br>  $$totalFailed</span>
                          <span id=\"tot9\"><u>Number Failed</u><br>  $numTransFailed</span>
                          <span id=\"tot10\"><u>Approval Percentage</u><br>  $percentSuccess%</span>
                          <br> <h2>Services Sold:</h2>
                    </div>"; 
                    
                    
    $this->rows = "$firstRow$this->rows";
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal List: $counter records</h2>
  //</div>$this->rows"; 
   
    
   
    
}
//===============================================================================================
function checkAccountStatus() {
$count = 0;
$dbMain = $this->dbconnect();

$idArray = explode('|',$this->serviceIdArray);

foreach($idArray as $id){
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$totalCount += $count;
//echo"test fubar fubar xxxxxx  $count<br>";
 }
$this->statusCount = $totalCount;
}
//-------------------------------------------------------------------------------------------------
function loadData2() {
 
    
    $dbMain = $this->dbconnect();
    
    switch($this->billProb){
        case 'CHECK'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CH'";
        break;
        case 'STATE'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CA'";
        break;
        default:
            $sqlSearch2 = "monthly_billing_type = 'CA' OR monthly_billing_type = 'CH'";
        break;
        }
   
    $this->reportType = 'BZ';
    
    
   
    
    $bool = 0;
    $counter = 1;
  
  //$this->rows .= "<div id=\"totals\"> <h2>Renewal List:</h2>
 // </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Due Date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain ->prepare("SELECT contract_key, monthly_billing_type, billing_amount FROM monthly_payments WHERE  $sqlSearch2  AND billing_amount > '0'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->monthlyBillingType, $this->amount);
    while($stmt3->fetch()){
        $this->serviceIdArray = "";
        $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($service_id); 
        while($stmt->fetch()){
                        $this->serviceIdArray .= "$service_id|";
                        $service_id = "";
            }
        $stmt->close();
        $this->checkAccountStatus();
        
        if($this->statusCount >= 1 AND $this->amount > 0){
            $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->nextDueDate);
            $stmt->fetch();
            $stmt->close();
            $this->nextDueDate = date("M j, Y" ,strtotime($this->nextDueDate));
            
            if(preg_match('/000/',$this->primaryPhone)){
                $this->primaryPhone = $this->cellPhone;
            }
        
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
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
            
        
        
                if($bool == 0){
                    $className = "row1";
                    $bool = 1;
                }elseif($bool == 1){
                    $className = "row2";
                    $bool = 0;
                }
                $this->rows .=   " 
                        <tr  class=\"$className tableCenter\">
                        <td>
                        $counter
                        </td>
                        <td>
                        <a  href=\"#\" onclick=\"doSomething($this->contractKey);\" ><span id=\"contract_key\">$this->contractKey</span></a>
                        </td>
                        <td>
                        <a  href=\"#\" onclick=\"doSomething($this->contractKey);\" ><span id=\"name\">$this->firstName $this->middleName $this->lastName</span></a>
                        </td> 
                        <td>
                        $disabledText1
                        </td>
                        <td>
                        <span id=\"p_sms_attempts\">$this->pSmsAtt</span>
                        </td>
                        <td>
                        $disabledHome
                        </td>
                        <td>
                        <span id=\"p_call_attempts\">$this->pCallAtt</span>
                        </td>
                        <td>
                        $disabledEmail
                        </td>
                        <td>
                        <span id=\"email_attempts\">$this->emailAtt</span>
                        </td>
                        <td>
                        <span id=\"dueDate\">$this->nextDueDate</span>
                        </td>
                        <td>
                        <span id=\"price\">$this->amount</span>
                        </td>
                        <input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
                        <input type=\"hidden\" id=\"month\" value=\"$month\"/>
                        <input type=\"hidden\" id=\"year\" value=\"$year\"/>
                        </tr>\n";
        
                                
                
                $count++;
                $counter++;
                $balance_due  = "";
                $todays_payment  = "";
                $min_total_due  = "";
                $due_date  = "";
                $contract_key  = "";
                $mem_fname  = "";
                $mem_lname  = "";
                $this->doNotCallCell  = "";
                $this->doNotCallHome  = "";
                $this->doNotEmail  = "";
                $this->doNotText  = "";
                $this->doNotMail  = "";
                $this->preferedContactMethod  = "";
                $this->pSmsAtt  = "";
                $this->pCallAtt  = "";
                $this->cSmsAtt  = "";
                $this->cCallAtt   = "";
                $this->emailAtt  = "";
                $this->contractKey  = "";
                $this->monthlyBillingType  = "";
                $this->amount  = "";
                $account_status = "";
        }
        
        
    }
    $stmt3->close();
    
$this->rows .= "</tbody></table>";
    
}
//-------------------------------------------------------------------------------------------------
function loadSmsALL() {
 
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_name, $business_nick); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT business_phone, contact_email FROM business_info WHERE bus_id != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_phone, $contact_email); 
    $stmt->fetch();
    $stmt->close();
    
    switch($this->meth){
        case 'CC'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'CC'";
        break;
        case 'ACH'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'ACH'";
        break;
        case '0':
            $sqlSearch2 = "AND transaction_type != ''";
        break;
        }
   
    $this->reportType = 'BX';
    
    switch($this->billProb){
        case '0'://all bill probs
            $sqlSearch = "batch_id = '$this->batch' AND response != '100' AND response != '202'";
        break;
        case '1':// all active
            $sqlSearch = "batch_id = '$this->batch'";
        break;
        case 'EXP'://expired
            $sqlSearch = "batch_id = '$this->batch' AND response = '223'";
        break;
        case 'MIS'://missing info
            $sqlSearch = "batch_id = '$this->batch' AND response = '440'";
        break;
        case 'STOP'://stop pay
            $sqlSearch = "batch_id = '$this->batch' AND response = '261'";
        break;
        case 'DUP'://duplicates
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'INV':// invalid card
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'STATE'://stop pay by customer
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'DEC'://all dec;lines
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'NSF'://nsf
           $sqlSearch = "batch_id = '$this->batch' AND response = '202'";
        break;
        case 'PICK'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '250' OR response = '251' OR response = '252' OR response = '252')";
        break;
        case 'ISS'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '200' OR response = '204')";
        break;
    }
   
    
    $bool = 0;
    $counter = 1;
    
    $stmt3 = $dbMain ->prepare("SELECT contract_key, billing_amount, response, processor_response, cycle_start_month, cycle_start_year, processed FROM batch_recurring_records WHERE $sqlSearch $sqlSearch2");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->amount, $this->response, $this->procResponse, $month, $year, $processed);
    while($stmt3->fetch()){
       // $this->expDate = date("M j, Y" ,strtotime($end_date));
       
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
        $stmt->fetch();
        $stmt->close();
        
        
    
        $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            if(preg_match('/000/',$this->primaryPhone)){
                $this->primaryPhone = $this->cellPhone;
                $whichPhone = "num_text_cell";
                $texts = $this->cSmsAtt +1;
            }else{
                $whichPhone = "num_text_primary";
                $texts = $this->pSmsAtt +1;
            }
        
            $stmt99 = $dbMain ->prepare("SELECT do_not_email, do_not_text FROM contact_preferences WHERE contract_key = '$this->contractKey'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotEmail, $this->doNotText);
             $stmt99->fetch();
             $stmt99->close();  
                

            if($this->doNotText != "Y" AND $processed == "N"){
                 $stmt99 = $dbMain ->prepare("SELECT COUNT(*) as count FROM account_phone_spam_check WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
                 $stmt99->execute();      
                 $stmt99->store_result();      
                 $stmt99->bind_result($count);
                 $stmt99->fetch();
                 $stmt99->close();  
                 
                 if ($count == 0){
                    $no = '0';
                    $yes = '1';
                    $sql = "INSERT INTO account_phone_spam_check VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('isiiiiiii', $this->contractKey, $this->reportType, $month, $year, $no, $yes, $no, $no, $no); 
                    $stmt->execute();
                    $stmt->close(); 
                 }else{
                     $sql = "UPDATE account_phone_spam_check SET $whichPhone= ? WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'";
                     $stmt = $dbMain->prepare($sql);
                     $stmt->bind_param('s', $texts);
                     $stmt->execute();
                     $stmt->close(); 
                 }
                 
                
                
                
                    $title = "$business_nick Billing";
                    $carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
                     $phoneStripped = preg_replace("/[^0-9]/","", $this->primaryPhone);
                     
                     $headers  = "From: info@$business_name.com\r\n";
                    $headers .= "Content-type: text/html\r\n"; 
                            
                    $message1 = "$this->firstName $this->lastName, Your $business_name account failed: $this->procResponse Date: $month-$year. Please contact us at 818-954-0021";
                    $message2 = " or info2@burbankathleticclub.com.";
                     
                    $message = wordwrap($message, 70, "\r\n");
                    foreach($carriers As $domain){
                        //echo "test";
                        $address = "$phoneStripped@$domain";
                        mail($address, "$title", $message1, $headers);   
                        mail($address, "$title", $message2, $headers);
                    }
            }
            if($this->doNotEmail == "Y"){
                $color = "red";
                $disabledEmail = "<span id=\"email\" class=\"email colorChange\">$this->emailAddress</span>";
            }else{
                $color = "black";
                $disabledEmail = "<a id=\"email\" class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>";
            }             
            
        
      

                        
        
        $count++;
        $counter++;
        $balance_due  = "";
        $todays_payment  = "";
        $min_total_due  = "";
        $due_date  = "";
        $contract_key  = "";
        $mem_fname  = "";
        $mem_lname  = "";
        $this->doNotCallCell  = "";
        $this->doNotCallHome  = "";
        $this->doNotEmail  = "";
        $this->doNotText  = "";
        $this->doNotMail  = "";
        $this->preferedContactMethod  = "";
        $this->pSmsAtt  = "";
        $this->pCallAtt  = "";
        $this->cSmsAtt  = "";
        $this->cCallAtt   = "";
        $this->emailAtt  = "";
        $this->contractKey  = "";
        $this->monthlyBillingType  = "";
        $this->amount  = "";
        $this->response  = "";
        $this->procResponse  = "";
        $month  = "";
        $year  = "";
        $processed = "";
        
    }
    $stmt3->close();
    
}
//===============================================================================================
function loadSmsAll2() {
 
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_name, $business_nick); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT business_phone, contact_email FROM business_info WHERE bus_id != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_phone, $contact_email); 
    $stmt->fetch();
    $stmt->close();
    
    switch($this->billProb){
        case 'CHECK'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CH'";
        break;
        case 'STATE'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CA'";
        break;
        default:
            $sqlSearch2 = "monthly_billing_type = 'CA' OR monthly_billing_type = 'CH'";
        break;
        }
   
    $this->reportType = 'BZ';
    
    
   
    
    $bool = 0;
    $counter = 1;
  

    $stmt3 = $dbMain ->prepare("SELECT contract_key, monthly_billing_type, billing_amount FROM monthly_payments WHERE  $sqlSearch2  AND billing_amount > '0'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->monthlyBillingType, $this->amount);
    while($stmt3->fetch()){
        $this->serviceIdArray = "";
        $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($service_id); 
        while($stmt->fetch()){
                        $this->serviceIdArray .= "$service_id|";
                        $service_id = "";
            }
        $stmt->close();
        $this->checkAccountStatus();
        
        if($this->statusCount >= 1 AND $this->amount > 0){
            $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->nextDueDate);
            $stmt->fetch();
            $stmt->close();
            $this->nextDueDate = date("M j, Y" ,strtotime($this->nextDueDate));
            
            $dueSecs = strtotime($this->nextDueDate);
            $todaySecs = time();
            
               $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            if(preg_match('/000/',$this->primaryPhone)){
                $this->primaryPhone = $this->cellPhone;
                $whichPhone = "num_text_cell";
                $texts = $this->cSmsAtt +1;
                $numP = 1;
                
            }else{
                $whichPhone = "num_text_primary";
                $texts = $this->pSmsAtt +1;
            }
        
            $stmt99 = $dbMain ->prepare("SELECT do_not_email, do_not_text FROM contact_preferences WHERE contract_key = '$this->contractKey'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotEmail, $this->doNotText);
             $stmt99->fetch();
             $stmt99->close();  
                

            if($this->doNotText != "Y"){
                $stmt99 = $dbMain ->prepare("SELECT COUNT(*) as count FROM account_phone_spam_check WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
                 $stmt99->execute();      
                 $stmt99->store_result();      
                 $stmt99->bind_result($count);
                 $stmt99->fetch();
                 $stmt99->close();  
                 
                 if ($count == 0){
                    $no = '0';
                    $sql = "INSERT INTO account_phone_spam_check VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('isiiiiiii', $this->contractKey, $this->reportType, $month, $year, $no, $no, $no, $no, $no); 
                    $stmt->execute();
                    $stmt->close(); 
                 }else{
                     $sql = "UPDATE account_phone_spam_check SET $whichPhone= ? WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'";
                     $stmt = $dbMain->prepare($sql);
                     $stmt->bind_param('s', $texts);
                     $stmt->execute();
                     $stmt->close(); 
                 }
               
                
                
                    $title = "$business_nick Billing";
                    $carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
                     $phoneStripped = preg_replace("/[^0-9]/","", $this->primaryPhone);
                     
                     $headers  = "From: info@$business_name.com\r\n";
                    $headers .= "Content-type: text/html\r\n"; 
                            
                    $message1 = "$this->firstName $this->lastName, Your $business_name account failed: $this->procResponse Date: $month-$year. Please contact us at $business_phone or $contact_email.";
                    
                     
                    $message = wordwrap($message, 70, "\r\n");
                    foreach($carriers As $domain){
                        //echo "test";
                        $address = "$phoneStripped@$domain";
                        mail($address, "$title", $message1, $headers);   
                    }
            }
           
                $count++;
                $counter++;
                $balance_due  = "";
                $todays_payment  = "";
                $min_total_due  = "";
                $due_date  = "";
                $contract_key  = "";
                $mem_fname  = "";
                $mem_lname  = "";
                $this->doNotCallCell  = "";
                $this->doNotCallHome  = "";
                $this->doNotEmail  = "";
                $this->doNotText  = "";
                $this->doNotMail  = "";
                $this->preferedContactMethod  = "";
                $this->pSmsAtt  = "";
                $this->pCallAtt  = "";
                $this->cSmsAtt  = "";
                $this->cCallAtt   = "";
                $this->emailAtt  = "";
                $this->contractKey  = "";
                $this->monthlyBillingType  = "";
                $this->amount  = "";
                $account_status = "";
        }
        
        
    }
    $stmt3->close();
}
//-------------------------------------------------------------------------------------------------
function loadEmailALL() {
 
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_name, $business_nick); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT business_phone, contact_email FROM business_info WHERE bus_id != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_phone, $contact_email); 
    $stmt->fetch();
    $stmt->close();
    
    switch($this->meth){
        case 'CC'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'CC'";
        break;
        case 'ACH'://all bill probs
            $sqlSearch2 = "AND transaction_type = 'ACH'";
        break;
        case '0':
            $sqlSearch2 = "AND transaction_type != ''";
        break;
        }
   
    $this->reportType = 'BX';
    
    switch($this->billProb){
        case '0'://all bill probs
            $sqlSearch = "batch_id = '$this->batch' AND response != '100' AND response != '202'";
        break;
        case '1':// all active
            $sqlSearch = "batch_id = '$this->batch'";
        break;
        case 'EXP'://expired
            $sqlSearch = "batch_id = '$this->batch' AND response = '223'";
        break;
        case 'MIS'://missing info
            $sqlSearch = "batch_id = '$this->batch' AND response = '440'";
        break;
        case 'STOP'://stop pay
            $sqlSearch = "batch_id = '$this->batch' AND response = '261'";
        break;
        case 'DUP'://duplicates
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'INV':// invalid card
            $sqlSearch = "batch_id = '$this->batch' AND response = '220'";
        break;
        case 'STATE'://stop pay by customer
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'DEC'://all dec;lines
           $sqlSearch = "batch_id = '$this->batch' AND response != '100'";
        break;
        case 'NSF'://nsf
           $sqlSearch = "batch_id = '$this->batch' AND response = '202'";
        break;
        case 'PICK'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '250' OR response = '251' OR response = '252' OR response = '252')";
        break;
        case 'ISS'://PICKUP
            $sqlSearch = "batch_id = '$this->batch' AND (response = '200' OR response = '204')";
        break;
    }
   
    
    $bool = 0;
    $counter = 1;
  
    $stmt3 = $dbMain ->prepare("SELECT contract_key, billing_amount, response, processor_response, cycle_start_month, cycle_start_year, processed FROM batch_recurring_records WHERE $sqlSearch $sqlSearch2");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->amount, $this->response, $this->procResponse, $month, $year, $processed);
    while($stmt3->fetch()){
        $this->expDate = date("M j, Y" ,strtotime($end_date));
       
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
        $stmt->fetch();
        $stmt->close();
        
        $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
        $stmt99->execute();      
        $stmt99->store_result();                       
        $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
        $stmt99->fetch();
        $stmt99->close();   
        
        $emails = $this->emailAtt + 1;
        
        $stmt99 = $dbMain ->prepare("SELECT do_not_email, do_not_text FROM contact_preferences WHERE contract_key = '$this->contractKey'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($this->doNotEmail, $this->doNotText);
        $stmt99->fetch();
        $stmt99->close();  

        if($this->doNotEmail != "Y" AND $processed == "N"){
                 $stmt99 = $dbMain ->prepare("SELECT COUNT(*) as count FROM account_phone_spam_check WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
                 $stmt99->execute();      
                 $stmt99->store_result();      
                 $stmt99->bind_result($count);
                 $stmt99->fetch();
                 $stmt99->close();  
                 
                 if ($count == 0){
                    $no = '0';
                    $emAtt = 1;
                    $sql = "INSERT INTO account_phone_spam_check VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('isiiiiiii', $this->contractKey, $this->reportType, $month, $year, $no, $no, $no, $no, $emAtt); 
                    $stmt->execute();
                    $stmt->close(); 
                 }else{
                     $sql = "UPDATE account_phone_spam_check SET num_emails= ? WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'";
                     $stmt = $dbMain->prepare($sql);
                     $stmt->bind_param('s', $emails);
                     $stmt->execute();
                     $stmt->close(); 
                 }
            
                   
                
                    $title = "$business_nick Billing";
                    
                    $headers  = "From: info@$business_name.com\r\n";
                    $headers .= "Content-type: text/html\r\n"; 
                            
                    $message1 = "$this->firstName $this->lastName,\n Your $business_name account billing has failed: $this->procResponse \n Date: $month-$year.\n Please contact us at $business_phone or $contact_email.\n $business_nick";
                    
                    $message1 = wordwrap($message1, 70, "\r\n");
                    mail($this->emailAddress, "$title", $message1, $headers);   
            
            }             
        
        $count++;
        $counter++;
        $balance_due  = "";
        $todays_payment  = "";
        $min_total_due  = "";
        $due_date  = "";
        $contract_key  = "";
        $mem_fname  = "";
        $mem_lname  = "";
        $this->doNotCallCell  = "";
        $this->doNotCallHome  = "";
        $this->doNotEmail  = "";
        $this->doNotText  = "";
        $this->doNotMail  = "";
        $this->preferedContactMethod  = "";
        $this->pSmsAtt  = "";
        $this->pCallAtt  = "";
        $this->cSmsAtt  = "";
        $this->cCallAtt   = "";
        $this->emailAtt  = "";
        $this->contractKey  = "";
        $this->monthlyBillingType  = "";
        $this->amount  = "";
        $this->response  = "";
        $this->procResponse  = "";
        $month  = "";
        $year  = "";
        $processed = "";
    }
    $stmt3->close();
    
    
}
//===============================================================================================
function loadEmailAll2() {
 
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_name, $business_nick); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT business_phone, contact_email FROM business_info WHERE bus_id != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_phone, $contact_email); 
    $stmt->fetch();
    $stmt->close();
    
    switch($this->billProb){
        case 'CHECK'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CH'";
        break;
        case 'STATE'://all bill probs
            $sqlSearch2 = "monthly_billing_type = 'CA'";
        break;
        default:
            $sqlSearch2 = "monthly_billing_type = 'CA' OR monthly_billing_type = 'CH'";
        break;
        }
   
    $this->reportType = 'BX';
    
    $bool = 0;
    $counter = 1;

    $stmt3 = $dbMain ->prepare("SELECT contract_key, monthly_billing_type, billing_amount FROM monthly_payments WHERE  $sqlSearch2  AND billing_amount > '0'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey, $this->monthlyBillingType, $this->amount);
    while($stmt3->fetch()){
        $this->serviceIdArray = "";
        $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($service_id); 
        while($stmt->fetch()){
                        $this->serviceIdArray .= "$service_id|";
                        $service_id = "";
            }
        $stmt->close();
        $this->checkAccountStatus();
        
        if($this->statusCount >= 1 AND $this->amount > 0){
            $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey' ");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($this->nextDueDate);
            $stmt->fetch();
            $stmt->close();
            $this->nextDueDate = date("M j, Y" ,strtotime($this->nextDueDate));
            
            $dueSecs = strtotime($this->nextDueDate);
            $todaySecs = time();
            
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $emails = $this->emailAtt + 1;
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$this->contractKey'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotCallCell, $this->doNotCallHome, $this->doNotEmail, $this->doNotText, $this->doNotMail, $this->preferedContactMethod);
             $stmt99->fetch();
             $stmt99->close();  
           
            if($this->doNotEmail != "Y" AND $dueSecs < $todaySecs){
                $stmt99 = $dbMain ->prepare("SELECT COUNT(*) as count FROM account_phone_spam_check WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
                 $stmt99->execute();      
                 $stmt99->store_result();      
                 $stmt99->bind_result($count);
                 $stmt99->fetch();
                 $stmt99->close();  
                 
                 if ($count == 0){
                    $no = '0';
                    $emAtt = 1;
                    $sql = "INSERT INTO account_phone_spam_check VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('isiiiiiii', $this->contractKey, $this->reportType, $month, $year, $no, $no, $no, $no, $emAtt); 
                    $stmt->execute();
                    $stmt->close(); 
                 }else{
                     $sql = "UPDATE account_phone_spam_check SET num_emails= ? WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'";
                     $stmt = $dbMain->prepare($sql);
                     $stmt->bind_param('s', $emails);
                     $stmt->execute();
                     $stmt->close(); 
                 }
                 
                
                 $title = "$business_nick Billing";
                  
                  $headers  = "From: info@$business_name.com\r\n";
                  $headers .= "Content-type: text/html\r\n"; 
                  
                  $message1 = "$this->firstName $this->lastName, Your $business_name account is past due. Date due: $this->nextDueDate. Please contact us at $business_phone or $contact_email.";
                  
                  $message1 = wordwrap($message1, 70, "\r\n");
                  mail($this->emailAddress, "$title", $message1, $headers);   
                  
            }          
                
                $count++;
                $counter++;
                $balance_due  = "";
                $todays_payment  = "";
                $min_total_due  = "";
                $due_date  = "";
                $contract_key  = "";
                $mem_fname  = "";
                $mem_lname  = "";
                $this->doNotCallCell  = "";
                $this->doNotCallHome  = "";
                $this->doNotEmail  = "";
                $this->doNotText  = "";
                $this->doNotMail  = "";
                $this->preferedContactMethod  = "";
                $this->pSmsAtt  = "";
                $this->pCallAtt  = "";
                $this->cSmsAtt  = "";
                $this->cCallAtt   = "";
                $this->emailAtt  = "";
                $this->contractKey  = "";
                $this->monthlyBillingType  = "";
                $this->amount  = "";
                $account_status = "";
        }
        
        
    }
    $stmt3->close();
}
//======================================================
function getRows(){
    return($this->rows);
}
}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$meth = $_REQUEST['meth'];
$batch = $_REQUEST['batch'];
$bill_prob = $_REQUEST['bill_prob'];

$batchArr = explode('|',$batch);
$batch = $batchArr[0];
$fee = $batchArr[1];

if($ajax_switch == "1") {
    
$attendence = new balData();
$attendence-> setFee($fee);
$attendence-> setMeth($meth);
$attendence-> setBatch($batch);
$attendence-> setBillProb($bill_prob);

if($bill_prob == 'STATE' OR $bill_prob == 'CHECK'){
    $attendence-> loadData2();
}else{
  $attendence-> loadData();  
}

$rows = $attendence-> getRows();

echo"$rows";
exit;


}

if($ajax_switch == "2") {
    
$attendence = new balData();
$attendence-> setFee($fee);
$attendence-> setMeth($meth);
$attendence-> setBatch($batch);
$attendence-> setBillProb($bill_prob);

if($bill_prob == 'STATE' OR $bill_prob == 'CHECK'){
    $attendence-> loadSmsAll2();
}else{
  $attendence-> loadSmsAll();  
}



echo"1";
exit;


}

if($ajax_switch == "3") {
    
$attendence = new balData();
$attendence-> setFee($fee);
$attendence-> setMeth($meth);
$attendence-> setBatch($batch);
$attendence-> setBillProb($bill_prob);

if($bill_prob == 'STATE' OR $bill_prob == 'CHECK'){
    $attendence-> loadEmailAll2();
}else{
  $attendence-> loadEmailAll();  
}

echo"1";
exit;


}

?>