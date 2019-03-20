<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//error_reporting(E_ALL);
class ptStatsAndSales{

private $contractKey = null;
private $barCode = null;
private $firstName = null;
private $midName = null;
private $lastName = null;
private $phone = null;
private $email = null;
private $street = null;
private $color = null;

function setUserId($user_id){
    $this->userId = $user_id;
}
function setRangeStart($rangeStart){
    $this->rangeStart = $rangeStart;
}
function setRangeEnd($rangeEnd){
    $this->rangeEnd = $rangeEnd;
}   
  
//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}
//============================================================================================================
function loadPtPayroll() {
    $assesments_off_clock_hours = 0;
$training_on_clock_hours = 0;

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id='$this->userId' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($emp_fname, $emp_mname, $emp_lname);
$stmt->fetch();  
$stmt->close(); 

$emp_fname = trim($emp_fname);
$emp_fname = strtolower($emp_fname);
$emp_fname = ucfirst($emp_fname);

$emp_mname = trim($emp_mname);
$emp_mname = strtolower($emp_mname);
$emp_mname = ucfirst($emp_mname);

$emp_lname = trim($emp_lname);
$emp_lname = strtolower($emp_lname);
$emp_lname = ucfirst($emp_lname);

$name = "$emp_fname $emp_mname $emp_lname";
$this->name = $name;
$stmt = $dbMain ->prepare("SELECT instructor_id FROM instructor_info WHERE instructor_name LIKE '%$name%' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($instructor_id);
$stmt->fetch();  
$stmt->close(); 

$counter = 0;
$counyer2 = 1;
$html = "<tr>
    </tr>
<div id=\"reportName\"> 
<span class=\"black5\">Name of Trainer:</span>
&nbsp;
<span class=\"black6\"><strong>$this->name &nbsp &nbsp PT Sessions Report</strong></span>
</div>


<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Training Service</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clock?</font></th>
</tr>";
$this->htmlArray = "";
// echo "test2";
$stmt = $dbMain ->prepare("SELECT use_pt_performance_pay, session_price_percent, session_tier_1, hourly_bump_1, session_tier_2,hourly_bump_2, session_tier_3, hourly_bump_3, trainers_normal_hourly, percent_or_flat_rate, trainers_normal_half_hourly, paid_training_assesments, ta_pay_amount  FROM pt_pay_options WHERE  pt_key = '1'");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($use_pt_performance_pay, $session_price_percent, $session_tier_1, $hourly_bump_1, $session_tier_2,$hourly_bump_2, $session_tier_3, $hourly_bump_3, $trainers_normal_hourly, $percent_or_flat_rate, $trainers_normal_half_hourly, $paid_training_assesments, $ta_pay_amount);
$stmt->fetch();  
$stmt->close(); 
//echo"FFFFFFFFFF";

$stmt999 = $dbMain ->prepare("SELECT instructor_id, member_id, session_date, service_key FROM pt_sessions_performed WHERE  instructor_id ='$instructor_id' AND (session_date BETWEEN '$this->rangeStart' AND '$this->rangeEnd') ORDER BY session_date DESC");
             $stmt999->execute();      
             $stmt999->store_result();      
             $stmt999->bind_result($instructor_id, $member_id, $session_date, $service_key);         
             $rowCount = $stmt999->num_rows;
             //echo "<br>rc $rowCount $this->rangeStart' AND '$this->rangeEnd $instructor_id<br>";
       if($rowCount != 0)  {
           
                    while ($stmt999->fetch()) {  
                        
                            $formattedDate = date('F j Y', strtotime($session_date));
                            $stmt = $dbMain ->prepare("SELECT contract_key, first_name, last_name FROM member_info WHERE member_id = '$member_id' ");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($contract_key, $first_name, $last_name);
                            $stmt->fetch();  
                            $stmt->close(); 
                            
                            $stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key = '$service_key' ");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($service_type);
                            $stmt->fetch();  
                            $stmt->close(); 
                            
                            if (strpos($service_type,'1/2') != false){
                                //echo"tetetetet";
                                $divisor = 2;
                                $class_end = date('Y-m-d H:i:s',mktime(date('H',strtotime($session_date)),date('i',strtotime($session_date))+30,date('s',strtotime($session_date)),date('m',strtotime($session_date)),date('d',strtotime($session_date)),date('Y',strtotime($session_date))));
                            }else{
                                $divisor = 1;
                                $class_end = date('Y-m-d H:i:s',mktime(date('H',strtotime($session_date))+1,date('i',strtotime($session_date)),date('s',strtotime($session_date)),date('m',strtotime($session_date)),date('d',strtotime($session_date)),date('Y',strtotime($session_date))));
                            }
                            $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM timeclock WHERE ((clock_in <= '$session_date' AND clock_out >= '$session_date') OR (clock_in <= '$class_end' AND clock_out >= '$class_end')) AND user_id = '$this->userId'");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($count);
                            $stmt->fetch();  
                            $stmt->close(); 
                            
                            //echo"SELECT COUNT(*) as count FROM timeclock WHERE ((clock_in <= '$session_date' AND clock_out >= '$session_date') OR (clock_in <= '$class_end' AND clock_out >= '$class_end')) AND user_id = '$this->userId'";
                            
                            if ($count >= 1){
                                $onClock = 'Yes';
                                switch($divisor){
                                    case 1:
                                         $training_on_clock_hours += 1;
                                    break;
                                    case 2:
                                         $training_on_clock_hours += .5;
                                    break;
                                }
                            }else{
                                $onClock = 'No';
                                                            
                            }
                            
                            if($percent_or_flat_rate == 'P'){
                               $stmt = $dbMain ->prepare("SELECT MAX(sale_date_time), group_price, overide_group_price, service_quantity  FROM sales_info WHERE service_key = '$service_key' AND contract_key = '$contract_key'");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($sale_date_time, $group_price, $overide_group_price, $service_quantity);
                            $stmt->fetch();  
                            $stmt->close();
                            
                            if($overide_group_price == 0.00){
                                $session_price = sprintf("%01.2f", ($group_price/$service_quantity)*$session_price_percent);
                            }else{
                                $session_price = sprintf("%01.2f", ($overide_group_price/$service_quantity)*$session_price_percent);
                            }   
                            }else{
                                if($divisor == 2){
                                    $session_price = $trainers_normal_half_hourly;
                                }else{
                                    $session_price = $trainers_normal_hourly;
                                }
                                
                            }
                          
                            
                            $session_totals += $session_price;
                            
                            $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counyer2</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name $last_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$session_price</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$formattedDate</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$onClock</b></font>
                                        </td>
                                        </tr>\n";
                               
                     
                            if (preg_match('/1/2/',$service_type)){
                                $counter += .5;
                            }else{
                                $counter++;
                            }
                              $counyer2++;
                              }
                              
                            
                            
                            if ($use_pt_performance_pay == 1){
                                if ($counter >= $session_tier_1 AND $counter < $session_tier_2){
                                    $this->extraPerformanceMoney = $counter * $hourly_bump_1;
                                    $this->ptTotal = sprintf("%01.2f", $session_totals);
                                    
                                }
                                if ($counter >= $session_tier_2  AND $counter < $session_tier_3){
                                    $this->extraPerformanceMoney = $counter * $hourly_bump_2;
                                    $this->ptTotal = sprintf("%01.2f", $session_totals);  
                                }
                                if ($counter >= $session_tier_3){
                                    $this->extraPerformanceMoney = $counter * $hourly_bump_3;
                                    $this->ptTotal = sprintf("%01.2f", $session_totals);
                                }
                                if ($counter < $session_tier_1){
                                    $this->ptTotal = sprintf("%01.2f", $session_totals);
                                    $this->extraPerformanceMoney = 0.00;
                                }
                                
                            }else{
                                 $this->ptTotal = sprintf("%01.2f", $session_totals);
                                 $this->extraPerformanceMoney = 0.00;
                            }
                            $this->sessionsPerformed = $counter;
                            $this->trainingOnClockHours = $training_on_clock_hours;
                          
              
            
           $this->ptHtml = "$htmlBeg$html</table>\n</div><br><br>";
         }else{
           $this->ptTotal = 'NA';
           $this->ptHtml = "";
         }
         
         

$counter2 = 0;
$htmlTA = "
<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\">PT Assesments Report</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Per session Pay</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Session Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">On Clock?</font></th>
</tr>";
//echo "$paid_training_assesments $htmlTA";
//exit;

// echo "test2";

$counyer3 = 1;
$stmt999 = $dbMain ->prepare("SELECT instructor_id, member_id, session_date, service_key FROM pt_training_assesments_performed WHERE  instructor_id ='$instructor_id' AND (session_date BETWEEN '$this->rangeStart' AND '$this->rangeEnd') ORDER BY session_date DESC");
             $stmt999->execute();      
             $stmt999->store_result();      
             $stmt999->bind_result($instructor_id, $member_id, $session_date, $service_key);         
             $rowCount2 = $stmt999->num_rows;
           //  echo $this->lastParollCloseDate;
          // exit;
       if($rowCount2 != 0)  {
           
                    while ($stmt999->fetch()) {  
                        
                            $formattedDate = date('F j Y', strtotime($session_date));
                            $stmt = $dbMain ->prepare("SELECT contract_key, first_name, last_name FROM member_info WHERE member_id = '$member_id' ");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($contract_key, $first_name, $last_name);
                            $stmt->fetch();  
                            $stmt->close(); 
                            //echo "$contract_key<br>";
                            $this->taKeyArray .= "$contract_key|";
                            
                            
                            $divisor = 1;
                            $class_end = date('Y-m-d H:i:s',mktime(date('H',strtotime($session_date))+1,date('i',strtotime($session_date)),date('s',strtotime($session_date)),date('m',strtotime($session_date)),date('d',strtotime($session_date)),date('Y',strtotime($session_date))));
                            
                            $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM timeclock WHERE ((clock_in <= '$session_date' AND clock_out >= '$session_date') OR (clock_in <= '$class_end' AND clock_out >= '$class_end')) AND user_id = '$this->userId'");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($count2);
                            $stmt->fetch();  
                            $stmt->close(); 
                            
                            //echo"SELECT COUNT(*) as count FROM timeclock WHERE ((clock_in <= '$session_date' AND clock_out >= '$session_date') OR (clock_in <= '$class_end' AND clock_out >= '$class_end')) AND user_id = '$this->userId'";
                            
                            if ($count2 >= 1){
                                $onClock = 'Yes';
                                $payAmount = 0;
                                $assesments_off_clock_hours = 0;
                            }else{
                                $onClock = 'No';
                                $payAmount = $ta_pay_amount; 
                                $assesments_off_clock_hours = 1;                         
                            }
                            
                            $session_totals2 += $payAmount;
                            
                            $htmlTA .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counyer3</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name $last_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$payAmount</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$formattedDate</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$onClock</b></font>
                                        </td>
                                        </tr>\n";
                               
                                $counyer3++;
                                $counter2++;
                              }
                            $htmlTA .= "</table>\n</div>";
                            $this->ptTotalTA = sprintf("%01.2f", $session_totals2);
                            
                            $this->sessionsPerformedTA = $counter2;
                            $this->assesmentsOFFClockHours = $assesments_off_clock_hours;
                           
            
           $this->ptHtmlTA = "$htmlTA<br><br>";
         }else{
           $this->ptTotalTA = 0;
           $this->ptHtmlTA = "";
         }





}
//==============================================================================================
function loadSalesData(){
  
$dbMain = $this->dbconnect();
//echo "fuck you";
$total = 0; 
$counter = 0;
 $htmlSales = "
<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\">Trainer Sales: &nbsp;&nbsp;PT Sales Report</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Date</font></th>
</tr>";




$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key, service_name, sale_date_time FROM sales_info WHERE user_id = '$this->userId'  AND (sale_date_time BETWEEN '$this->rangeStart' AND '$this->rangeEnd') AND service_name LIKE '%train%'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key, $service_name, $sale_date_time);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $formattedDate = date('F j Y', strtotime($sale_date_time));
    $stmt = $dbMain ->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key' ");
    $stmt->execute();      
    $stmt->store_result(); 
    $stmt-> bind_result($first_name, $last_name);
    $stmt->fetch();  
    $stmt->close(); 
    $this->cKeyArray .= "$contract_key|";
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
    $htmlSales .= "<tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name $last_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$price</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$formattedDate</b></font>
                                        </td>
                                        </tr>\n";
     }

$stmt999->close();

$htmlSales .= "</table>\n</div><br><br>";

$this->htmlSales = $htmlSales;
$this->totaleSales = $total;
$this->salesCount = $counter;


$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,1,1,date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart' AND service_name LIKE '%train%'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $this->cKeyArray .= "$contract_key|";
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesYTD = $total;
$this->salesCountYTD = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')-1));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart' AND service_name LIKE '%train%'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $this->cKeyArray .= "$contract_key|";
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesLY = $total;
$this->salesCountLY = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-30,date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart' AND service_name LIKE '%train%'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $this->cKeyArray .= "$contract_key|";
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesL30 = $total;
$this->salesCountL30 = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m')-6,date('d'),date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart' AND service_name LIKE '%train%'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $this->cKeyArray .= "$contract_key|";
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesL6 = $total;
$this->salesCountL6 = $counter;

}
//===============================================================================================
function makeStats(){
    
           

    
    $this->closingPercentage = ($this->salesFromAssesments/$this->sessionsPerformedTA)*100;
    
    $salesWithoutAssesment = $this->salesCount-$this->salesFromAssesments;
    
    $htmlStats = "
                <div id=\"listings\">
                <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>                
                 <tr>
                <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\">Trainer Stats</font></th>
                </tr>               
                <tr>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># of TA's</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Count</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Closing %</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Session Peformed</font></th>
                </tr>";

$this->closingPercentage = sprintf("%01.2f",$this->closingPercentage);

$htmlStats .= "<tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSales</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->sessionsPerformedTA</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCount</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->closingPercentage %</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->sessionsPerformed</b></font>
                                        </td>
                                        </tr>\n";
                                    
                $htmlStats .= "<tr>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Session Total</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">PT Bonus</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">TA's off Clock</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Not From TA's</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales From TA's</font></th>
                </tr>";                    
                                    
                                    $htmlStats .= "<tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->ptTotal</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->extraPerformanceMoney</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->assesmentsOFFClockHours</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$salesWithoutAssesment</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesFromAssesments</b></font>
                                        </td>
                                        </tr>\n";
                                    
                                    
                $htmlStats .= "<tr>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Year to Date:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last 30 Days:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last 6 Month:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last Year:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                </tr>
                <tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountYTD</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesYTD</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountL30</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesL30</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountL6</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesL6</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountLY</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesLY</b></font>
                                        </td>
                                        </tr></table>\n</div><br><br>";                    
                                    
                                
                                    
 
 

 


 


                            
$this->htmlStats = $htmlStats;

}
//===========================================================================================================
function formatPayrollRecord()  {
$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
 <link rel=\"stylesheet\" href=\"../css/printReport.css\">
 <script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />
  </head>
  <div id=\"logoDiv\">
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/contract_logo.png\"  /></a>
</div>
  ";

$finalHtml = "$message$this->ptHtml<br><br>$this->ptHtmlTA<br><br>$this->htmlStats<br><br>$this->htmlSales
</html>";
//echo "dddfuck you";
echo $finalHtml;
//exit;
}
//==============================================================================================
function moveData(){
  

$this->loadSalesData();
$this->loadPtPayroll();

$saleFromAssesment = 0;

$taArr = explode('|',$this->taKeyArray);
$ckArr = explode('|',$this->cKeyArray);
foreach($taArr as $ta){
  foreach($ckArr as $ck){
    $dupArray = explode('|',$dupTest);
    if ($ck == $ta AND !in_array($ck, $dupArray)){
        $saleFromAssesment++;
        $dupTest .= "$ck|";
    }
}  
}

//var_dump($this->taKeyArray);
//echo "<br>$saleFromAssesment<br>";
//var_dump($this->cKeyArray);
$this->salesFromAssesments = $saleFromAssesment;
$this->makeStats();

$this->formatPayrollRecord();

//echo "Done!";
}
//===============================================

}
$user_id = $_REQUEST['user_id'];
$rangeStart = $_REQUEST['datepicker1'];
$rangeEnd  = $_REQUEST['datepicker2'];

$rangeStart = "$rangeStart 00:00:00";
$rangeStart = date('Y-m-d H:i:s', strtotime($rangeStart));
$rangeEnd = "$rangeEnd 23:59:59";
$rangeEnd = date('Y-m-d H:i:s', strtotime($rangeEnd));

//echo "$user_id $rangeStart $rangeEnd";
$report = new ptStatsAndSales();
$report-> setUserId($user_id);
$report-> setRangeStart($rangeStart);
$report->setRangeEnd($rangeEnd);
$report->moveData();










?>