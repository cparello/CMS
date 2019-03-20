<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  balData{

function setClubId($clubId){
    $this->clubId = $clubId;
}
function setRenew($renew){
    $this->renew = $renew;
}
function setDate($date){
    $this->date = $date;
}
function setDate2($date2){
    $this->date2 = $date2;
}
function setMonth($month){
    $this->month = $month;
}
function setYear($year){
    $this->year = $year;
}
//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {
    if(trim($this->date2) == ""){
        $rangeFlag = 0;
    }else{
        $rangeFlag = 1;
    }

    $dateArr = explode('/',$this->date);
    $month = $dateArr[0];
    $day = $dateArr[1];
    $year = $dateArr[2];
    $dateArr2 = explode('/',$this->date2);
    $month2 = $dateArr2[0];
    $day2 = $dateArr2[1];
    $year2 = $dateArr2[2];
    
    $dbMain = $this->dbconnect();
    $stmt99 = $dbMain ->prepare("SELECT early_renewal_grace, standard_renewal_grace FROM fees WHERE fee_num = '1'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($early_renewal_grace, $standard_renewal_grace);
    $stmt99->fetch();
    $stmt99->close();
    
    switch($this->renew){
        case 'EXP':
            $this->reportType = "EX";
            $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day+$standard_renewal_grace,$year));
            $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month,$day+$standard_renewal_grace+$standard_renewal_grace,$year));
        break;
        case 'SRP':
            $this->reportType = "SR";
            $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
            $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month,$day+$standard_renewal_grace,$year));
        break;
        case 'ERP':
            $this->reportType = "ER";
            $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day-$early_renewal_grace,$year));
            $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month,$day,$year));
        break;
        case '0':
            $this->reportType = "RN";
            $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
            $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month2,$day2,$year2));
        break;
        case '1':
            $this->reportType = "RN";
            $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
        break;
    }
    
    if($this->renew == 1 OR $rangeFlag == 0){
        $sqlSearch = "end_date > '$this->date' ORDER BY end_date ASC";
    }else{
        $sqlSearch = "(end_date BETWEEN '$this->date' AND '$this->date2') ORDER BY end_date ASC";
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
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain ->prepare("SELECT service_id, contract_key, service_name, service_key, group_price, group_renew_rate, end_date FROM paid_full_services WHERE $sqlSearch");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->serviceId, $contract_key, $this->serviceName, $this->serviceKey, $this->groupPrice, $this->groupRenewRate, $end_date);
    while($stmt3->fetch()){
        $this->expDate = date("M j, Y" ,strtotime($end_date));
        
            if ($this->groupPrice == '0.00'){
                $this->groupPrice = $this->groupRenewRate;
            }
        
        
        $stmt99 = $dbMain ->prepare("SELECT contract_id, club_id FROM contract_info WHERE contract_key = '$contract_key' ORDER BY contract_id DESC LIMIT 1");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($cid, $club_id);
        $stmt99->fetch();
        $stmt99->close();
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$contract_key' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip);
        $stmt->fetch();
        $stmt->close();
        
        if(preg_match('/000/',$this->primaryPhone)){
            $this->primaryPhone = $this->cellPhone;
        }
    
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = '$this->reportType' AND month = '$month' AND year = '$year'");
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
        
        $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$sevice_key'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($end_dateMax);
        $stmt99->fetch();
        $stmt99->close();
            
        $maxSecs = strtotime($end_dateMax);
        $endSecs = strtotime($end_date);
            
        if ($maxSecs <= $endSecs AND ($this->club == $club_id OR $this->clubId == 1)){
        
        
        
        
        
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
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" ><span id=\"contract_key\"></span></a>
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
                <span id=\"service\">$this->serviceName</span>
                </td>
                <td>
                <span id=\"date\">$this->expDate</span>
                </td>
                <td>
                <span id=\"price\">$this->groupPrice</span>
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
        $this->serviceId  = "";
        $contract_key  = "";
        $this->serviceName  = "";
        $this->serviceKey  = "";
        $this->groupPrice  = "";
        $this->groupRenewRate  = "";
        $end_date  = "";
        }
    }
    $stmt3->close();
    
    
   
    
     $this->rows .= "</tbody></table>";
    
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal List: $counter records</h2>
  //</div>$this->rows"; 
   
    
   
    
}
//-------------------------------------------------------------------------------------------------
function loadData2() {
    
    $bool = 0;
    $counter = 1;


$notRenewedForYear = 0;
$notRenewedForThreeMonths = 0;
$notRenewedForSixMonths  = 0;
$renewingNow = 0;
$newMems = 0;
$expNow = 0;

    $dbMain = $this->dbconnect();
    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM paid_full_services WHERE contract_key != '' AND service_name LIKE '%Membership%'");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($contract_key);
    while($stmt3->fetch()){
        
        
        $stmt99 = $dbMain ->prepare("SELECT COUNT(*) FROM paid_full_services WHERE contract_key = '$contract_key'  AND service_name LIKE '%Membership%'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($numMemsCount);
        $stmt99->fetch();
        $stmt99->close();
        
        $stmt99 = $dbMain ->prepare("SELECT COUNT(*) FROM paid_full_services WHERE contract_key = '$contract_key'  AND service_name LIKE '%Membership%' AND MONTH(end_date) = '$this->month'  AND YEAR(end_date) = '$this->year'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($expiringNowCount);
        $stmt99->fetch();
        $stmt99->close();
        
        $stmt99 = $dbMain ->prepare("SELECT COUNT(*) FROM paid_full_services WHERE contract_key = '$contract_key'  AND service_name LIKE '%Membership%' AND MONTH(start_date) = '$this->month'  AND YEAR(start_date) = '$this->year'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($startingNowCount);
        $stmt99->fetch();
        $stmt99->close();
        
        $stmt99 = $dbMain ->prepare("SELECT MAX(end_date), MONTH(end_date), YEAR(end_date) FROM paid_full_services WHERE contract_key = '$contract_key'  AND service_name LIKE '%Membership%'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($end_date_max, $maxMonth, $maxYear);
        $stmt99->fetch();
        $stmt99->close();
        
        
            
        $nowSecs = time();
        $yearSecs = 365 * 86400;
        $sixMonthsSecs = 182 * 86400;
        $threeMonthsSecs = 91 * 86400;
        $nowSecs = strtotime($end_date_max);
        
        $thrityDaysSecs = 30 * 86400;
        $yearFromEnd = $maxEndSecs + $yearSecs;
        $yearFrom30Day = $yearFromEnd - $thrityDaysSecs;
        $yearMonth = $nowSecs - $yearSecs;
        $yearMonth = date('F',$yearMonth);
        $sixMonthsFromEnd = $maxEndSecs + $sixMonthsSecs;
        $sixMonthsFrom30Day =  $sixMonthsFromEnd - $thrityDaysSecs;
        $sixMonthMonth = $nowSecs - $sixMonthsSecs;
        $sixMonthMonth = date('F',$sixMonthMonth);
        $threeMonthsFromEnd = $maxEndSecs + $threeMonthsSecs;
        $threeMonthsFrom30Day =  $threeMonthsFromEnd - $thrityDaysSecs;
        $threeMonthMonth = $nowSecs - $threeMonthsSecs;
        $threeMonthMonth = date('F',$threeMonthMonth);
        
        if ($yearFromEnd > $nowSecs  AND $yearFrom30Day <= $nowSecs){
            $notRenewedForYear++;
            }
            
        if ($threeMonthsFromEnd > $nowSecs AND $threeMonthsFrom30Day <= $nowSecs){
            $notRenewedForThreeMonths++;
            }
        if ($sixMonthsFromEnd > $nowSecs  AND $sixMonthsFrom30Day <= $nowSecs){
            $notRenewedForSixMonths++;
            }
        if ($numMemsCount > 1 AND $startingNowCount >= 1){
            $renewingNow++;
            }else if($numMemsCount == 1 AND $startingNowCount >= 1){
                $newMems++;
            }
        if ($expiringNowCount >= 1 AND $maxMonth == $this->month AND $maxYear == $this->year){
            $expNow++;
            }
        
        $contract_key = "";
        $numMemsCount = "";
        $expiringNowCount = "";
        $startingNowCount = "";
        $end_date_max = ""; 
        
    }
    $stmt3->close();
    
     if($bool == 0){
            $className = "row1";
            $bool = 1;
        }elseif($bool == 1){
            $className = "row2";
            $bool = 0;
        }
        
        $outstanding = $expNow - $renewingNow;
        $percent = round($renewingNow/$expNow,2)*100;
         $this->rows = " <div id=\"totals\">
                          <span id=\"tot1\"><u>Expiring this Month($this->month)</u><br> $expNow </span>
                          <span id=\"tot2\"><u>Already Renewed</u><br>  $renewingNow</span>
                          <span id=\"tot3\"><u>Outstanding Renewals</u><br>  $outstanding</span>
                          <span id=\"tot4\"><u>Renewal Percentage</u><br>  $percent%</span>
                          <span id=\"tot5\"><u>New Memberships</u><br>  $newMems</span>
                          <span id=\"tot6\"><u>After 3 Months($threeMonthMonth)</u><br>  $notRenewedForThreeMonths</span>
                          <span id=\"tot7\"><u>After 6 Months($sixMonthMonth)</u><br>  $notRenewedForSixMonths</span>
                          <span id=\"tot8\"><u>After 1 Year($yearMonth)</u><br>  $notRenewedForYear</span>\n
                          </div>";  

    
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal Lit: $counter records</h2>
  //</div>$this->rows"; 
   
    
   
    
}
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
$renewType = $_REQUEST['renewType'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$clubArr = explode('|',$clubId);
$clubId = $clubArr[0];

if($ajax_switch == "1") {
    
    if($renewType == 23){
        $all_select =1;
        $attendence = new balData();
        $attendence-> setClubId($clubId);
        $attendence-> setRenew($renewType);
        $attendence-> setMonth($month);
        $attendence-> setYear($year);
        $attendence-> loadData2();
        $rows = $attendence-> getRows();
        
        echo"$rows";
        exit;   
    }else{
        $all_select =1;
        $attendence = new balData();
        $attendence-> setClubId($clubId);
        $attendence-> setRenew($renewType);
        $attendence-> setDate($date);
        $attendence-> setDate2($date2);
        $attendence-> loadData();
        $rows = $attendence-> getRows();
        
        echo"$rows";
        exit;   
    }




}



?>