<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  salesData{

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
function setPifBool($pifBool){
    $pifArr = explode('|',$pifBool);
    $this->pifBool = $pifArr[0];
    $this->servName = $pifArr[1];
}
function setSales($salesBool){
    $this->salesBool = $salesBool;
}
function setGroup($groupBool){
    $this->groupBool = $groupBool;
}
function setEmployee($employee){
    $this->employee = $employee;
}
//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {
      
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
 // exit;
   $dbMain = $this->dbconnect();
   
   
   if($this->employee == 0){
        $searchString5 = "";
    }else{
         $searchString5 = " AND user_id = '$this->employee'";
    }
    
    if($this->clubId == 1){
        $searchString = "";
    }elseif($this->clubId == 0){
         $searchString = " AND (contract_location LIKE '%Website%') AND location_id = '0'";
    }else{
         $searchString = " AND (contract_location LIKE '%$this->clubName%') AND location_id = '$this->clubId'";
    }
    
    switch($this->pifBool){
        case '0':
            $searchString2 = "";
        break;
        case 'E':
            $searchString2 = " AND  service_term = 'M'";
        break;
        case 'P':
            $searchString2 = " AND  service_term != 'M'";
        break;
        default:
            $searchString2 = " AND  service_key = '$this->pifBool'";
        break;
    }
 
    switch($this->salesBool){
        case '0':
            $searchString4 = "";
        break;
        case 'SN':
            $searchString4 = " AND new_sale = 'Y'";
        break;
        case 'SU':
            $searchString4 = " AND upgrade = 'Y'";
        break;
        case 'ARP':
            $searchString4 = " AND renewal = 'Y'";
        break;
        case 'SRP':
            $searchString4 = " AND renewal = 'Y' AND early_renewal = 'N'";
        break;
        case 'ERP':
            $searchString4 = " AND early_renewal = 'Y'";
        break;
    }
    
    switch($this->groupBool){
        case 'S':
            $searchString3 = " AND  group_type = 'S'";
        break;
        case 'F':
            $searchString3 = " AND  group_type = 'F'";
        break;
        case 'B':
            $searchString3 = " AND  group_type = 'B'";
        break;
        case 'O':
            $searchString3 = " AND  group_type = 'O'";
        break;
        case '0':
             $searchString3 = "";
        break;
    }
 
      $bool = 0;
      $total = 0;
      $cc = 0;
      $ca = 0;
      $ch = 0;
      $ach = 0;
      $count = 0;
      $newCount = 0;
      $renewCount = 0;
    $counter = 1;
    $eft = 0;
  
  $date = date('F d Y',strtotime($this->monthStart));
  
    $mStart = date('Y-m-d H:i:s', mktime(0,0,0,$month,1,$year));
    $mEnd = date('Y-m-d H:i:s', mktime(23,59,59,$month2,date('t',strtotime($mStart)),$year2));
    
    $stmt = $dbMain->prepare("SELECT contract_key, service_name, unit_price FROM sales_info WHERE (sale_date_time BETWEEN '$mStart' AND '$mEnd') $searchString");//$searchString $searchString2 $searchString3 $searchString4 $searchString5
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($contract_key, $service_name, $unit_price);
    while($stmt->fetch()){
        
        $stmt22 = $dbMain->prepare("SELECT credit_payment, cash_payment, ach_payment, check_payment  FROM payment_history WHERE contract_key = '$contract_key' AND (payment_date BETWEEN '$mStart' AND '$mEnd') AND (payment_description LIKE '%New Service%' OR payment_description LIKE '%Service Renewal%'  OR payment_description LIKE '%Service Upgrade%'  OR payment_description LIKE '%$service_name%')");
        $stmt22->execute();
        $stmt22->store_result();
        $stmt22->bind_result($credit_payment, $cash_payment, $ach_payment, $check_payment);
        $stmt22->fetch();
        $stmt22->close();
        
        if ($credit_payment != '0.00'){
            $payment = $credit_payment;
        }elseif ($cash_payment != '0.00'){
            $payment = $cash_payment;
        }elseif ($ach_payment != '0.00'){
            $payment = $ach_payment;
        }elseif ($check_payment != '0.00'){
            $payment = $check_payment;
        }
        $currentTot += $payment;
        $credit_payment   = "";
        $cash_payment  = "";
        $ach_payment  = "";
        $check_payment  = "";
        $contract_key  = "";
        $service_name  = "";
        $unit_price  = "";
    }
    $stmt->close();
    
  
    if($this->clubId != 0 AND $this->clubId != 1){
        $stmt = $dbMain->prepare("SELECT quota FROM sales_quotas WHERE club_id = '$this->clubId'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($quota);
        $stmt->fetch();
        $stmt->close();
        
        $salesLeft = sprintf("%01.2f", $quota - $currentTot);
        
        $now = time();
        $mStartecs = strtotime($mStart);
        $mEndSecs = strtotime($mEnd);
        if($now > $mStartecs){
            $dailyGoal = "NA";
        }else{
            $diff = $mEndSecs - $mStartecs;
            $daysLeft = round($diff/date('t',strtotime($mStart)));
            $dailyGoal = sprintf("%01.2f", $salesLeft/$daysLeft);
            $dailyGoal = $dailyGoal * 1000;
        }
        
        
        $this->rows .= " <div id=\"totals\">
          <span id=\"tot1\"<u>Month</u><br> ".date('F',strtotime($this->date))."</span>
          <span id=\"tot2\"<u>Quota</u><br>  $$quota</span>
          <span id=\"tot3\"<u>Monthly Total</u><br>  $$currentTot</span>
          <span id=\"tot4\"<u>Sales Left</u><br>  $$salesLeft</span>
          <span id=\"tot5\"<u>Daily Goal</u><br>  $$dailyGoal</span>";  
    }elseif($this->clubId == 0){
        $this->rows .= "<div id=\"totals\">
        <span id=\"tot\"<u>Monthly Total<br>  $$currentTot</span>";  
    }elseif($this->clubId == 1){
        $stmt = $dbMain->prepare("SELECT SUM(quota) FROM sales_quotas WHERE club_id != ''");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($quota);
        $stmt->fetch();
        $stmt->close();
        
        $salesLeft = sprintf("%01.2f", $quota - $currentTot);
        
        $now = time();
        $mStartecs = strtotime($mStart);
        $mEndSecs = strtotime($mEnd);
        if($now > $mStartecs){
            $dailyGoal = "NA";
        }else{
            $diff = $mEndSecs - $mStartecs;
            $daysLeft = round($diff/date('t',strtotime($mStart)));
            $dailyGoal = sprintf("%01.2f", $salesLeft/$daysLeft);
            $dailyGoal = $dailyGoal * 1000;
        }
  
        $this->rows .= " <div id=\"totals\">
                          <span id=\"tot1B\"><u>Month</u><br>  ".date('F',strtotime($this->date))."</span>
                          <span id=\"tot2B\"><u>Quota</u><br>  $$quota</span>
                          <span id=\"tot3B\"><u>Monthly Total</u><br>  $$currentTot</span>
                          <span id=\"tot4B\"><u>Sales Left</u><br>  $$salesLeft</span>
                          <span id=\"tot5B\"><u>Daily Goal</u><br>  $$dailyGoal</span>\n";  
    }
    
  
  $this->rows .= "<br> <h2>Services Sold:</h2>
  </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=100%>
  <thead>
   <tr>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">#</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Transaction Type</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Service Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Price</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Employee Name</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale, service_quantity, service_key FROM sales_info WHERE (sale_date_time BETWEEN '$this->date' AND '$this->date2') $searchString $searchString2 $searchString3 $searchString4 $searchString5");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale, $service_quantity, $service_key);
    while($stmt3->fetch()){
        $stmt = $dbMain->prepare("SELECT emp_fname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($emp_fname, $emp_lname);
        $stmt->fetch();
        $stmt->close();
        
        if($user_id == 99){
            $emp_fname = "Website";
        }
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT credit_payment, cash_payment, ach_payment, check_payment  FROM payment_history WHERE contract_key = '$contract_key' AND (payment_date BETWEEN '$this->date' AND '$this->date2') AND (payment_description LIKE '%New Service%' OR payment_description LIKE '%Service Renewal%'  OR payment_description LIKE '%Service Upgrade%'  OR payment_description LIKE '%$service_name%')");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($credit_payment, $cash_payment, $ach_payment, $check_payment);
        $stmt->fetch();
        $stmt->close();
        
        $transType = '';
        
        if ($new_sale == 'Y'){
            $newCount++;
        }else{
            $renewCount++;
        }
        
        if ($credit_payment != '0.00'){
            $cc += $credit_payment;
            $transType = 'CC';
            $payment = $credit_payment;
        }elseif ($cash_payment != '0.00'){
            $ca += $cash_payment;
            $transType = 'CA';
            $payment = $cash_payment;
        }elseif ($ach_payment != '0.00'){
            $ach += $ach_payment;
            $transType = 'ACH';
            $payment = $ach_payment;
        }elseif ($check_payment != '0.00'){
            $ch += $check_payment;
            $transType = 'CH';
            $payment = $check_payment;
        }
        
        if (preg_match('/Monthly/i',$service_name)){
            $stmt = $dbMain->prepare("SELECT service_cost  FROM service_cost WHERE service_key = '$service_key' AND service_quantity = '$service_quantity'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($service_cost);
            $stmt->fetch();
            $stmt->close();
            $eft += $service_cost/$service_quantity;
        }
        
        $total += $unit_price;
        //echo \"<tr><td><Center> <strong>Type:</strong> \" . $transType . \" <strong> Service: </strong> \" . $service_name . \" <strong> Cost:  </strong> \" . $unit_price . \" <strong>  Salesperson: </strong> \" . $emp_fname .\" \" . $emp_lname . \"</Center></td></tr>\";
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
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" ><span id=\"contract_key\"></span></a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" ><span id=\"name\">$mem_fname $mem_lname</span></a>
                </td>
                <td>
                $transType
                </td>
                <td>
                $service_name
                </td>  
                <td>
                $$payment
                </td>
                <td>
                $emp_fname  $emp_lname
                </td>
                </tr>";
                        
        
        $count++;
        $counter++;
        $emp_fname = "";
        $emp_lname  = "";
        $credit_payment   = "";
        $cash_payment  = "";
        $ach_payment  = "";
        $check_payment  = "";
        $contract_key  = "";
        $service_name  = "";
        $unit_price  = "";
        $user_id  = "";
        $new_sale  = "";
        $mem_fname  = "";
        $mem_lname  = "";
        $service_quantity = "";
        $service_key = "";
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    $total2 = sprintf("%01.2f", $cc+$ca+$ach+$ch);
    $cc = sprintf("%01.2f", $cc);
    $ca = sprintf("%01.2f", $ca);
    $ach = sprintf("%01.2f", $ach);
    $ch = sprintf("%01.2f", $ch);
    
   
    
     $this->rows .= "</tbody></table>";
    
    $this->rows .=" <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=100%>
    <thead>
    <tr  class=\"tableCenter\">
  <th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Credit Cards</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Cash</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">ACH</font></th>
  <th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Checks</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Number of Sales</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">New</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">New EFT</font></th>
  </tr></thead><tbody>"; 
    
    $this->rows .=    "<tr  class=\"tableCenter\">
                        <td>
                        $$total2
                        </td>
                        <td>
                        $$cc
                        </td>  
                        <td>
                        $$ca
                        </td>
                        <td>
                        $$ach
                        </td>
                        <td>
                        $$ch
                        </td>
                        <td>
                        $count
                        </td>
                        <td>
                        $newCount
                        </td>
                        <td>
                        $renewCount
                        </td>
                        <td>
                        $$eft
                        </td>
                        </tr>
                        </tbody>
                        </table>";
    
   
    
   
    
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
$pifBool = $_REQUEST['pifBool'];
$salesBool = $_REQUEST['salesBool'];
$groupBool = $_REQUEST['groupBool'];
$employee = $_REQUEST['employee'];

$clubArr = explode('|',$clubId);
$clubId = $clubArr[0];
$clubName = $clubArr[1];

if($ajax_switch == "1") {

$all_select =1;
$attendence = new salesData();
$attendence-> setClubId($clubId);
$attendence-> setClubName($clubName);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> setPifBool($pifBool);
$attendence-> setSales($salesBool);
$attendence-> setGroup($groupBool);
$attendence-> setEmployee($employee);
$attendence-> loadData();
$rows = $attendence-> getRows();

echo"$rows";
exit;


}



?>