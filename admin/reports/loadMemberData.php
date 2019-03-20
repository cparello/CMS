<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  balData{

function setClubId($clubId){
    $this->clubId = $clubId;
}
function setCatType($catType){
    $this->catType = $catType;
}
function setDate($date){
    $this->date = $date;
}
function setDate2($date2){
    $this->date2 = $date2;
}

function setPifBool($pifBool){
    $pifArr = explode('|',$pifBool);
    $this->serviceKeySel = $pifArr[0];
    $this->servNameSel = $pifArr[1];
}


//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadGenderData() {
    
    $dbMain = $this->dbconnect();
    

    
    $bool = 0;
    $counter = 1;
    $r1 = 0;
    $r2 = 0;
    $r3 = 0;
    $r4 = 0;
    $r5 = 0;
    $r6 = 0;

    $stmt3 = $dbMain ->prepare("SELECT contract_key, dob FROM member_info WHERE contract_key != ''");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($contract_key, $dob);
    while($stmt3->fetch()){
        if($dob != "1969-12-31 16:00:00" AND $dob != "(000)-000-0000"){
            $yearArr = explode('-',$dob);
            $birthYear = $yearArr[0];
            $nowYear = date('Y');
            $age = $nowYear- $birthYear;
                  
                  if($age < 18){
                    $r1++;
                    }elseif($age >= 18 AND $age < 25){
                    $r2++;
                    }elseif($age >= 25 AND $age < 32){
                    $r3++;
                    }elseif($age >= 32 AND $age < 39){
                    $r4++;
                    }elseif($age >= 39 AND $age < 46){
                    $r5++;
                    }elseif($age >= 53){
                    $r6++;
                    }          
            
            $count++;
            $counter++;
            $contract_key  = "";
            $dob  = "";  
        }
       
    }
    $stmt3->close();
    
      $this->rows = " <div id=\"totals\">
                          <span id=\"tot1X\"><u>Under 18</u><br> $r1 </span>
                          <span id=\"tot2X\"><u>18 - 25</u><br> $r2 </span>
                          <span id=\"tot3X\"><u>25 - 32</u><br> $r3</span>
                          <span id=\"tot4X\"><u>32 - 39</u><br>  $r4</span>
                          <span id=\"tot5X\"><u>39 - 46</u><br> $r5 </span>
                          <span id=\"tot6X\"><u>Over 53</u></span>
                          </div>";  

    
    
    
   
    
}
//-------------------------------------------------------------------------------------------------
function loadHoldData() {
    
    $dbMain = $this->dbconnect();
    

    
    $bool = 0;
    $counter = 1;
    
     $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hold End</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hold Length</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM account_status WHERE account_status = 'HO' ORDER BY status_date ASC");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($contract_key);
    while($stmt3->fetch()){
        
            $stmt = $dbMain->prepare("SELECT service_name, end_date FROM paid_full_services WHERE  contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($service_name, $end_date);
            $stmt->fetch();
            $stmt->close();
            
            if(trim($service_name) == ""){
                $stmt = $dbMain->prepare("SELECT service_name, end_date FROM monthly_services WHERE  contract_key = '$contract_key'");
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($service_name, $end_date);
                $stmt->fetch();
                $stmt->close();
            }
            $end_date = date('F j Y',strtotime($end_date));
            
            $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($mem_fname, $mem_lname);
            $stmt->fetch();
            $stmt->close();
            
            if($bool == 0){
                $className = "row1";
                $bool = 1;
            }elseif($bool == 1){
                $className = "row2";
                $bool = 0;
            }
            
             $this->rows .=    "<tr class=\"$className  tableCenter\">
                <td>
                $counter
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$contract_key</a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$mem_fname $mem_lname</a>
                </td>
                <td>
                $holdEnd
                </td>
                <td>
                $holdLength
                </td>
                <td>
                $service_name
                </td>  
                <td>
                $end_date
                </td>
                </tr>";
        
        
        
       
            $count++;
            $counter++;
            $contract_key  = "";
            $service_key  = "";  
        
       
    }
    $stmt3->close();
    
     

    
    $this->rows .= "</tbody></table>";
    
   
    
}
//-------------------------------------------------------------------------------------------------
function loadPrepayData() {
    
    $dbMain = $this->dbconnect();
    

    
    $bool = 0;
    $counter = 1;
    
      $stmt = $dbMain->prepare("SELECT COUNT(*) as count, SUM(restart_payment) FROM pre_payments WHERE  contract_key != ''");
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($ppCount, $ppayTot);
      $stmt->fetch();
      $stmt->close();
      $this->rows .= " <div id=\"totals\">
                          <span id=\"tot1B\"><u>Number of Prepays</u><br>$ppCount</span>
                          <span id=\"tot2B\"><u>Monthly Prepay Total</u><br>  $$ppayTot</span>\n";  
    
    
  
  $this->rows .= "<br> <h2>Prepayments:</h2>
  </div>"; 
    
     $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepay restart date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepay Length</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepay Amount</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Exp Date</font></th>
  </tr>
  </thead>
  <tbody>"; 
  
  

    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM pre_payments WHERE contract_key != '' ORDER BY restart_date ASC");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($contract_key);
    while($stmt3->fetch()){
        
            $stmt = $dbMain->prepare("SELECT num_months, payment_amount, service_keys, payment_date, restart_date FROM pre_payments WHERE  contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($num_months, $payment_amount, $service_keys, $payment_date, $restart_date);
            $stmt->fetch();
            $stmt->close();
            
            $restart_date =  date('F j Y',strtotime($restart_date));
            $payment_date =  date('F j Y',strtotime($payment_date));
            
            $service_name_list = "";
            $service_keysARR = explode(',',$service_keys);
            $service_keysARR = array_keys(array_flip($service_keysARR));
            foreach($service_keysARR as $service_key_temp){
                if(trim($service_key_temp) != ""){
                    $service_name = "";
                    $end_date = "";
                    $stmt33 = $dbMain->prepare("SELECT service_name, end_date FROM monthly_services WHERE  contract_key = '$contract_key' AND service_key = '$service_key_temp'");
                    $stmt33->execute();
                    $stmt33->store_result();
                    $stmt33->bind_result($service_name, $end_date);
                    $stmt33->fetch();
                    $stmt33->close();
                    
                    $service_name_list .= "$service_name<br>";
                }
                
            }
            $end_date = date('F j Y',strtotime($end_date));
            
            $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($mem_fname, $mem_lname);
            $stmt->fetch();
            $stmt->close();
            
            if($bool == 0){
                $className = "row1";
                $bool = 1;
            }elseif($bool == 1){
                $className = "row2";
                $bool = 0;
            }
            
             $this->rows .=    "<tr class=\"$className  tableCenter\">
                <td>
                $counter
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$contract_key</a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$mem_fname $mem_lname</a>
                </td>
                <td>
                $restart_date
                </td>
                <td>
                $num_months Months
                </td>
                <td>
                $payment_amount
                </td>
                <td>
                $service_name_list
                </td>  
                <td>
                $end_date
                </td>
                </tr>";
        
        
        
       
            $count++;
            $counter++;
            $contract_key  = "";
            $service_key  = "";  
        
       
    }
    $stmt3->close();
    
     

    
    $this->rows .= "</tbody></table>";
    
   
    
    
   
    
}
//-------------------------------------------------------------------------------------------------
function loadCreditData() {
    
    $dbMain = $this->dbconnect();
    

    $monthlysCount = 0;
    $bool = 0;
    $counter = 1;
    
     $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit End</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit Length</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM service_credits WHERE contract_key != ''");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($contract_key);
    while($stmt3->fetch()){
        
            $stmt = $dbMain->prepare("SELECT service_key, credit_sec_num, credit_end FROM service_credits WHERE  contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($service_key, $credit_sec_num, $credit_end );
            $stmt->fetch();
            $stmt->close();
            
            $creditLength = round($credit_sec_num / 86400,2);
            $credit_end = date('F j Y',strtotime($credit_end));
        
            $stmt = $dbMain->prepare("SELECT service_name, end_date FROM paid_full_services WHERE  contract_key = '$contract_key' AND service_key = '$service_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($service_name, $end_date);
            $stmt->fetch();
            $stmt->close();
            
            if(trim($service_name) == ""){
                $stmt = $dbMain->prepare("SELECT service_name, end_date, monthly_dues FROM monthly_services WHERE  contract_key = '$contract_key'  AND service_key = '$service_key'");
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($service_name, $end_date, $monthly_dues);
                $stmt->fetch();
                $stmt->close();
                
                if(trim($service_name) != ""){
                    $monthyTotPay += $monthly_dues;
                    $monthlysCount++;
                }
            }
            $end_date = date('F j Y',strtotime($end_date));
            
            if(trim($service_name) == ""){
                $service_name = "Unavailable";
                $end_date = "Unavailable";
                }
            
            $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($mem_fname, $mem_lname);
            $stmt->fetch();
            $stmt->close();
            
            if($bool == 0){
                $className = "row1";
                $bool = 1;
            }elseif($bool == 1){
                $className = "row2";
                $bool = 0;
            }
            
             $this->rows .=    "<tr class=\"$className  tableCenter\">
                <td>
                $counter
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$contract_key</a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" >$mem_fname $mem_lname</a>
                </td>
                <td>
                $credit_end
                </td>
                <td>
                $creditLength
                </td>
                <td>
                $service_name
                </td>  
                <td>
                $end_date
                </td>
                </tr>";
        
        
        
       
            $count++;
            $counter++;
            $contract_key  = "";
            $service_key  = "";  
            $service_key  = "";
            $credit_sec_num  = "";
            $credit_end  = "";  
            $service_name  = "";
            $end_date  = "";  
            $mem_fname  = ""; 
            $mem_lname  = "";  
            $monthly_dues  = "";
    }
    $stmt3->close();
    
     

    
    $this->rows .= "</tbody></table>";
    
     $topRows = " <div id=\"totals\">
                          <span id=\"tot1B\"><u>Number of Credits</u><br>$counter</span>
                          <span id=\"tot1B\"><u>Number of Monthly Credits</u><br>$monthlysCount</span>
                          <span id=\"tot2B\"><u>Monthly Credit Total</u><br>  $$monthyTotPay</span>\n
                          <br> <h2>Service Credits:</h2>
                    </div>";   
    
    
  
  $this->rows = "$topRows$this->rows";
   
    
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
function loadActiveData() {
    
    $dbMain = $this->dbconnect();
    
    $bool = 0;
    $counter = 1;
    
    if($this->serviceKeySel == 0){
        $searchSQL = "";
    }else{
         $searchSQL = "";
    }
  
  //$this->rows .= "<div id=\"totals\"> <h2>Renewal List:</h2>
 // </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  </tr>
  </thead>
  <tbody>"; 
  
  if($this->serviceKeySel == 0){
    $servKeySQL = "";
  }else{
    $servKeySQL = "AND service_key = '$this->serviceKeySel'";
  }
  
  

    $stmt3 = $dbMain ->prepare("SELECT service_id, contract_key, service_name, service_key, group_price, group_renew_rate, end_date FROM paid_full_services WHERE end_date >= NOW() $servKeySQL ORDER BY end_date ASC");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->serviceId, $contract_key, $this->serviceName, $this->serviceKey, $this->groupPrice, $this->groupRenewRate, $end_date);
    while($stmt3->fetch()){
        $this->expDate = date("M j, Y" ,strtotime($end_date));
        
            if ($this->groupPrice == '0.00'){
                $this->groupPrice = $this->groupRenewRate;
            }
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip, club_id FROM contract_info WHERE contract_key = '$contract_key'  ORDER BY contract_id DESC LIMIT 1");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $club_id);
        $stmt->fetch();
        $stmt->close();
        
        if(preg_match('/000/',$this->primaryPhone)){
            $this->primaryPhone = $this->cellPhone;
        }
    
           
        
        $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$this->serviceKey'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($end_dateMax);
        $stmt99->fetch();
        $stmt99->close();
            
        $maxSecs = strtotime($end_dateMax);
        $endSecs = strtotime($end_date);
            
        if ($maxSecs <= $endSecs AND ($this->club == $club_id OR $this->clubId == 1)){
            
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
                <span id=\"contract_key\">$contract_key</span>
                </td>
                <td>
                <span id=\"name\">$this->firstName $this->middleName $this->lastName</span>
                </td> 
                <td>
                <a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>
                </td>
                <td>
                <a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>
                </td>
                <td>
                <span id=\"service\">$this->servNameSel</span>
                </td>
                <td>
                <span id=\"date\">$this->expDate</span>
                </td>
                <td>
                <span id=\"price\">$this->groupPrice</span>
                </td>
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
    
    
    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM batch_recurring_records WHERE contract_key != ''");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey);
    while($stmt3->fetch()){
            $this->serviceIdArray = "";
            $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey' $servKeySQL");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($service_id); 
            while($stmt->fetch()){
                            $this->serviceIdArray .= "$service_id|";
                }
            $stmt->close();
            $this->checkAccountStatus();
            
            if($this->statusCount >= 1){
                $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip, club_id FROM contract_info WHERE contract_key = '$this->contractKey'  ORDER BY contract_id DESC LIMIT 1");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $club_id);
                $stmt->fetch();
                $stmt->close();
                
                if(preg_match('/000/',$this->primaryPhone)){
                    $this->primaryPhone = $this->cellPhone;
                }
            
                
                $stmt99 = $dbMain ->prepare("SELECT MAX(end_date), service_name, monthly_dues FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'  $servKeySQL");
                $stmt99->execute();      
                $stmt99->store_result();      
                $stmt99->bind_result($end_dateMax, $this->serviceName, $monthly_dues);
                $stmt99->fetch();
                $stmt99->close();
                    
                $maxSecs = strtotime($end_dateMax);
                if($maxSecs < time()){
                    $this->expDate = "M2M";
                }else{
                    $this->expDate = date("M j, Y" ,$maxSecs);
                }
                
                    
                if ($this->club == $club_id OR $this->clubId == 1){
                    
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
                        <span id=\"contract_key\">$this->contractKey</span>
                        </td>
                        <td>
                        <span id=\"name\">$this->firstName $this->middleName $this->lastName</span>
                        </td> 
                        <td>
                        <a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>
                        </td>
                        <td>
                        <a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>
                        </td>
                        <td>
                        <span id=\"service\">$this->serviceName</span>
                        </td>
                        <td>
                        <span id=\"date\">$this->expDate</span>
                        </td>
                        <td>
                        <span id=\"price\">$monthly_dues</span>
                        </td>
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
                $monthly_dues  = "";
                $end_dateMax  = "";
                }
            }
    }
    $stmt3->close();
     $this->rows .= "</tbody></table>";
    
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal List: $counter records</h2>
  //</div>$this->rows"; 
   
    
   
    
}
//-------------------------------------------------------------------------------------------------
function loadInactiveData() {
    
    $dbMain = $this->dbconnect();
    
    $bool = 0;
    $counter = 1;
  $lastYear = date('Y-m-s h:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')-1));
  //$this->rows .= "<div id=\"totals\"> <h2>Renewal List:</h2>
 // </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
  
  <tr class=\" tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain ->prepare("SELECT service_id, contract_key, service_name, service_key, group_price, group_renew_rate, end_date FROM paid_full_services WHERE (end_date BETWEEN '$lastYear' AND NOW())  ORDER BY end_date ASC");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->serviceId, $contract_key, $this->serviceName, $this->serviceKey, $this->groupPrice, $this->groupRenewRate, $end_date);
    while($stmt3->fetch()){
        if($end_date == '0000-00-00 00:00:00' OR trim($end_date) == ''){
            $this->expDate = "NA";
        }else{
            $this->expDate = date("M j, Y" ,strtotime($end_date));
        }
        
        
            if ($this->groupPrice == '0.00'){
                $this->groupPrice = $this->groupRenewRate;
            }
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip, club_id FROM contract_info WHERE contract_key = '$contract_key'  ORDER BY contract_id DESC LIMIT 1");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $club_id);
        $stmt->fetch();
        $stmt->close();
        
        if(preg_match('/000/',$this->primaryPhone)){
            $this->primaryPhone = $this->cellPhone;
        }
    
           
        
        $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$this->serviceKey'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($end_dateMax);
        $stmt99->fetch();
        $stmt99->close();
            
        $maxSecs = strtotime($end_dateMax);
        $endSecs = strtotime($end_date);
            
        if ($maxSecs <= $endSecs AND ($this->club == $club_id OR $this->clubId == 1)){
            
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
                <span id=\"contract_key\">$contract_key</span>
                </td>
                <td>
                <span id=\"name\">$this->firstName $this->middleName $this->lastName</span>
                </td> 
                <td>
                <a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>
                </td>
                <td>
                <a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>
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
    
    
    $stmt3 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM monthly_payments WHERE contract_key != ''");
    $stmt3->execute();      
    $stmt3->store_result();      
    $stmt3->bind_result($this->contractKey);
    while($stmt3->fetch()){
            $this->serviceIdArray = "";
            $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($service_id); 
            while($stmt->fetch()){
                            $this->serviceIdArray .= "$service_id|";
                }
            $stmt->close();
            $this->checkAccountStatus();
            
            if($this->statusCount <= 0){
                $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip, club_id FROM contract_info WHERE contract_key = '$this->contractKey'  ORDER BY contract_id DESC LIMIT 1");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($this->firstName, $this->middleName, $this->lastName, $this->primaryPhone, $this->cellPhone, $this->emailAddress, $this->clientStreet, $this->clientCity, $this->clientState, $this->clientZip, $club_id);
                $stmt->fetch();
                $stmt->close();
                
                if(preg_match('/000/',$this->primaryPhone)){
                    $this->primaryPhone = $this->cellPhone;
                }
            
                
                $stmt99 = $dbMain ->prepare("SELECT MAX(end_date), service_name, monthly_dues FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'");
                $stmt99->execute();      
                $stmt99->store_result();      
                $stmt99->bind_result($end_dateMax, $this->serviceName, $monthly_dues);
                $stmt99->fetch();
                $stmt99->close();
                    
                $maxSecs = strtotime($end_dateMax);
                $this->expDate = date("M j, Y" ,$maxSecs);
                
                if ($this->club == $club_id OR $this->clubId == 1){
                    
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
                        <span id=\"contract_key\">$this->contractKey</span>
                        </td>
                        <td>
                        <span id=\"name\">$this->firstName $this->middleName $this->lastName</span>
                        </td> 
                        <td>
                        <a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>
                        </td>
                        <td>
                        <a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>
                        </td>
                        <td>
                        <span id=\"service\">$this->serviceName</span>
                        </td>
                        <td>
                        <span id=\"date\">$this->expDate</span>
                        </td>
                        <td>
                        <span id=\"price\">$monthly_dues</span>
                        </td>
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
                $monthly_dues  = "";
                $end_dateMax  = "";
                }
            }
    }
    $stmt3->close();
     $this->rows .= "</tbody></table>";
    
   
    //$this->rows = "<div id=\"totals\"> <h2>Renewal List: $counter records</h2>
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
$catType = $_REQUEST['catType'];
$servType = $_REQUEST['servType'];

$clubArr = explode('|',$clubId);
$clubId = $clubArr[0];

if($ajax_switch == "1") {

$all_select =1;
$attendence = new balData();
$attendence-> setClubId($clubId);
$attendence-> setCatType($catType);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> setPifBool($servType);


switch($catType){
        case 'GEN':
          $attendence-> loadGenderData(); 
        break;
        case 'HOL':
          $attendence-> loadHoldData(); 
        break;
        case 'PRE':
          $attendence-> loadPrepayData(); 
        break;
        case 'CRE':
          $attendence-> loadCreditData(); 
        break;
        case 'AA':
          $attendence-> loadActiveData(); 
        break;
        case 'IA':
          $attendence-> loadInactiveData(); 
        break;
    }


$rows = $attendence-> getRows();

echo"$rows";
exit;


}



?>