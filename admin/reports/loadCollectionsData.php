<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  balData{

private $reportType = "CX";

function setClubId($clubId){
    $this->clubId = $clubId;
}
function setClubName($clubName){
    $this->clubName = $clubName;
}
function setDate($date){
    $this->date = $date;
}
function setDate2($date2){
    $this->date2 = $date2;
}
//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {
 
    
    $dbMain = $this->dbconnect();
    
    //$this->reportType = "CX";
    
     $this->date2 = trim($this->date2);
    if($this->date2 == ""){
         $this->date2 = $this->date;
    }
    $dateArr = explode('/',$this->date);
    $month = $dateArr[0];
    $day = $dateArr[1];
    $year = $dateArr[2];
    $dateArr2 = explode('/',$this->date2);
    $month2 = $dateArr2[0];
    $day2 = $dateArr2[1];
    $year2 = $dateArr2[2];
    
   $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
   $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month2,$day2,$year2)); 
//echo "nfgnfgnfghfgfgfg$this->date' AND '$this->date2";
 // exit
   
    if($this->clubId == 1){
        $searchString = "";
    }else{
         $searchString = " AND club_id = '$this->clubId'";
    }
   
    
   $bool = 0;
   $counter = 1;
  
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
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date in Collections</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Months Past Due</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Still Owed</font></th>
  </tr>
  </thead>
  <tbody>"; 
  
 
    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM billing_collections WHERE contract_key != '' AND (collections_date BETWEEN '$this->date' AND '$this->date2')");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey);
    while($stmt3->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT amount_owed, monthd_past_due, collections_date FROM billing_collections WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed, $monthd_past_due, $collections_date);
        $stmt->fetch();
        $stmt->close();
        
        $fourMonthsBefore = strtotime($collections_date) + (4 * (30 * 86400));
        $fourMonthsBefore -=  (4 * (30 * 86400));
        $fourMonthsBefore = date('Y-m-d H:i:s',$fourMonthsBefore);
        
        $stmt = $dbMain ->prepare("SELECT SUM(balance_due), count(*) as count FROM payment_history WHERE contract_key = '$this->contractKey' AND payment_flag = 'RE' AND payment_description LIKE '%Monthly Dues %' AND payment_date > '$fourMonthsBefore'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed_fees, $num_fees);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain ->prepare("SELECT MAX(end_date), monthly_dues FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($endDate, $monthly_dues);
        $stmt->fetch();
        $stmt->close();
        
        $monthsLeftContract = round((time() - strtotime($collections_date))/(30 * 86400));
        $stillOwed = round($monthly_dues * $monthsLeftContract, 2) + $amount_owed;
        $monthd_past_due = $monthd_past_due + $monthsLeftContract;
        
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
                <span id=\"collectionsDate\">$collections_date</span>
                </td>
                <td>
                <span id=\"monthsPastDue\">$monthd_past_due</span>
                </td>
                <td>
                <span id=\"price\">$stillOwed</span>
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
        $this->response  = "";
        $this->procResponse  = "";
        $month  = "";
        $year  = "";
        $processed = "";
    }
    $stmt3->close();

    
     $this->rows .= "</tbody></table>";
     
                    
                    
    $this->rows = "$this->rows";
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal List: $counter records</h2>
  //</div>$this->rows"; 
   
    
   
    
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
    
    
   
    
    $bool = 0;
    $counter = 1;
    
  $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM billing_collections WHERE contract_key != '' AND (collections_date BETWEEN '$this->date' AND '$this->date2')");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey);
    while($stmt3->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT amount_owed, monthd_past_due, collections_date FROM billing_collections WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed, $monthd_past_due, $collections_date);
        $stmt->fetch();
        $stmt->close();
        
        $fourMonthsBefore = strtotime($collections_date) + (4 * (30 * 86400));
        $fourMonthsBefore -=  (4 * (30 * 86400));
        $fourMonthsBefore = date('Y-m-d H:i:s',$fourMonthsBefore);
        
        $stmt = $dbMain ->prepare("SELECT SUM(balance_due), count(*) as count FROM payment_history WHERE contract_key = '$this->contractKey' AND payment_flag = 'RE' AND payment_description LIKE '%Monthly Dues %' AND payment_date > '$fourMonthsBefore'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed_fees, $num_fees);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain ->prepare("SELECT MAX(end_date), monthly_dues FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($endDate, $monthly_dues);
        $stmt->fetch();
        $stmt->close();
        
        $monthsLeftContract = round((time() - strtotime($collections_date))/(30 * 86400));
        $stillOwed = round($monthly_dues * $monthsLeftContract, 2) + $amount_owed;
        $monthd_past_due = $monthd_past_due + $monthsLeftContract;
       
        
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
                            
                    $message1 = "$this->firstName $this->lastName, Your $business_name account is in collections. Please contact us at $business_phone";
                    $message2 = " or $contact_email.";
                     
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
    
    
   
    
    $bool = 0;
    $counter = 1;
  
    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM billing_collections WHERE contract_key != '' AND (collections_date BETWEEN '$this->date' AND '$this->date2')");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey);
    while($stmt3->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT amount_owed, monthd_past_due, collections_date FROM billing_collections WHERE contract_key = '$this->contractKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed, $monthd_past_due, $collections_date);
        $stmt->fetch();
        $stmt->close();
        
        $fourMonthsBefore = strtotime($collections_date) + (4 * (30 * 86400));
        $fourMonthsBefore -=  (4 * (30 * 86400));
        $fourMonthsBefore = date('Y-m-d H:i:s',$fourMonthsBefore);
        
        $stmt = $dbMain ->prepare("SELECT SUM(balance_due), count(*) as count FROM payment_history WHERE contract_key = '$this->contractKey' AND payment_flag = 'RE' AND payment_description LIKE '%Monthly Dues %' AND payment_date > '$fourMonthsBefore'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($amount_owed_fees, $num_fees);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain ->prepare("SELECT MAX(end_date), monthly_dues FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($endDate, $monthly_dues);
        $stmt->fetch();
        $stmt->close();
        
        $monthsLeftContract = round((time() - strtotime($collections_date))/(30 * 86400));
        $stillOwed = round($monthly_dues * $monthsLeftContract, 2) + $amount_owed;
        $monthd_past_due = $monthd_past_due + $monthsLeftContract;
       
        
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

        if($this->doNotEmail != "Y"){
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
                            
                    $message1 = "$this->firstName $this->lastName,\n Your $business_name account is in collections.\n You are currently $monthd_past_due months past due.Please contact us at $business_phone or $contact_email.\n $business_nick";
                    
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

//======================================================
function getRows(){
    return($this->rows);
}
}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$clubId = $_REQUEST['clubId'];
$date = $_REQUEST['date'];
$date2 = $_REQUEST['date2'];

$clubArr = explode('|',$clubId);
$clubId = $clubArr[0];
$clubName = $clubArr[1];

if($ajax_switch == "1") {

$all_select =1;
$attendence = new balData();
$attendence-> setClubId($clubId);
$attendence-> setClubName($clubName);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> loadData();
$rows = $attendence-> getRows();

echo"$rows";
exit;


}

if($ajax_switch == "2") {
    
$attendence = new balData();
$attendence-> setClubId($clubId);
$attendence-> setClubName($clubName);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> loadSmsAll();  

echo"1";
exit;


}

if($ajax_switch == "3") {
    
$attendence = new balData();
$attendence-> setClubId($clubId);
$attendence-> setClubName($clubName);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> loadEmailAll();  

echo"1";
exit;


}

?>