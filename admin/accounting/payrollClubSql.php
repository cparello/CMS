 <?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
error_reporting(0);
class payrollClubSql {

private $payrollCycle = null;
private $clubLocation = null;
private $payrollResult = null;
private $userId = null;
private $typeKey = null;
private $idCard = null;
private $lastParollCloseDate = null;
private $whereSql = null;

private $employeeType = null;
private $compensationType = null;
private $compensationAmount = null;
private $hoursProjected = null;
private $totalHours = null;
private $hourlyWages = null;
private $salaryWage = null;
private $commissionTotal = null;
private $subTotal = null;
private $clubName = null;
private $empFname = null;
private $empMname = null;
private $empLname = null;
private $empFullName = null;
private $totalAmount = null;
private $compTypeDesc = null;
private $tableHeader = null;
private $counter = 1;
private $recordList = null;
private $cycleDesc = null;
private $basePay = null;
private $baseProrateAmount = null;
private $closeDate = null;
private $consolidate = null;

private $addSubOneArray = null;
private $addSubTwoArray = null;
private $addSubThreeArray = null;
private $addSubFourArray = null;
private $addSubTotalArray = null;

private $insertArray = null;


private $totalHoursLeft = null;
private $oTHoursTier1 = null;
private $oTMinsTier1 = null;
private $oTHoursTier2 = null;
private $oTMinsTier2 = null;
private $cycleDivisor = null;
private $OT = null;
private $dailyHours = null;
private $dailyMins = null;
private $oTWeek1 = null;
private $oTWeek2 = null;
private $dailyOvertime = null;
private $weeklyOvertime = null;
private $overtimeTier1 = null;
private $overtimeTier2 = null;
private $businessState = null;
private $seventhDayOt = null;
private $seventhDayDoubTime = null;
private $datetime1 = null;
private $datetime2 = null;
private $oTNextDay = null;
private $previousDayPastMidnight = null;



function setPayrollCycle($payrollCycle) {
          $this->payrollCycle = $payrollCycle;
          }
function setClubLocation($clubLocation) {
          $this->clubLocation = $clubLocation;
          }
function setDateStart($date_start){
          $this->dateStart = $date_start;
          }
function setDateEnd($date_end){
          $this->dateEnd = $date_end;
          }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------
function loadBaseProrateAmount() {

$dayOfMonth = date("j");
$endOfMonth = date("t");
$todaysDate = date("Y-m-d");
$dayOfWeek = date("w");
$dayOfWeek = $dayOfWeek +1;
$month = date("n", strtotime($todaysDate));
$year = date("Y", strtotime($todaysDate));
//$this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year));



 switch ($this->payrollCycle) {
            case "D":
                 $this->baseProrateAmount = '0.00';
                 //$this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year));
            break;
            case "W":
                 if($dayOfWeek <= 7) {                        
                        //$this->closeDate = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, strtotime( 'This Saturday'), $year));
                        $datetime1 = new DateTime($todaysDate);
                        $datetime2 = new DateTime($this->closeDate);
                        $interval = $datetime1->diff($datetime2);
                        $days = $interval->format('%d');   
                        
                             if($this->compensationType == 'H' || $this->compensationType == 'HC') {
                                $prorateHours = $this->totalHoursLeft;
                                $baseProrateAmount = $prorateHours * $this->compensationAmount;
                                $this->baseProrateAmount = sprintf("%01.2f", $baseProrateAmount);
                               }
                             if($this->compensationType == 'S' || $this->compensationType == 'SC') {
                                $this->baseProrateAmount = '0.00';
                                }
                   }

            break;
            case "B";
                 /*if(($dayOfMonth <= 20) AND ($dayOfMonth > 5)){
                    $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), 14, date('Y')));    
                    }elseif($dayOfMonth <= 5){
                      $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m')-1, $endOfMonth, date('Y')));
                    }else{
                        $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), $endOfMonth, date('Y')));
                    }*/
                                  
                        $datetime1 = new DateTime($todaysDate);
                        $datetime2 = new DateTime($this->closeDate);
                        $interval = $datetime1->diff($datetime2);
                        $days = $interval->format('%d'); 

                             if($this->compensationType == 'H' || $this->compensationType == 'HC') {
                                $prorateHours = $this->totalHoursLeft;
                                $baseProrateAmount = $prorateHours * $this->compensationAmount;
                                $this->baseProrateAmount = sprintf("%01.2f", $baseProrateAmount);
                               }
                             if($this->compensationType == 'S' || $this->compensationType == 'SC') {
                                $this->baseProrateAmount = '0.00';
                                }
                               
            break;
            case "M";
               /* if(($dayOfMonth < $endOfMonth) AND ($dayOfMonth > 5)) {                    
                   $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), $endOfMonth, date('Y'))); 
                   }elseif(($dayOfMonth <= 5)){
                     $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m')-1, $endOfMonth, date('Y')));
                   }else{
                    $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year));
                   }*/

                        $datetime1 = new DateTime($todaysDate);
                        $datetime2 = new DateTime($this->closeDate);
                        $interval = $datetime1->diff($datetime2);
                        $days = $interval->format('%d'); 

                             if($this->compensationType == 'H' || $this->compensationType == 'HC') {
                                $prorateHours = $this->totalHoursLeft;
                                $baseProrateAmount = $prorateHours * $this->compensationAmount;
                                $this->baseProrateAmount = sprintf("%01.2f", $baseProrateAmount);
                               }
                             if($this->compensationType == 'S' || $this->compensationType == 'SC') {
                                $this->baseProrateAmount = '0.00';
                                }

            break;
            }

}
//---------------------------------------------------------------------------------------------------------------------
function formatRecords() {

if($this->totalHours > 0 OR $this->sessionsPerformed > 0 OR $this->sessionsPerformedTA) {
        
                                   //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                           $cell_count = $cell_count + 1;
                               
        
 $this->recordList .="<tr id=\"a$this->counter\" style=\"background-color: $color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->idCard</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->empFullName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->employeeType</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clubName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->compTypeDesc</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->totalHours</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->totalAmount</b></font></td>
<td align=\"left\" valign =\"top\"><input type=\"button\" name=\"process\" id=\"process\" value=\"Details\" onClick=\"getDetails('$this->insertArray');\"></td>
<td align=\"left\" valign =\"top\"><input type=\"checkbox\" name=\"process[]\" value=\"$this->insertArray\" onClick=\"return checkSelection(this,'$color','a$this->counter')\" checked/></td>
</tr>\n";

$this->counter++;

}

}
//---------------------------------------------------------------------------------------------------------------------
function loadDeductionsAdditions() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two, add_sub_desc_two,  add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three, add_sub_four, add_sub_desc_four, add_sub_amount_four FROM add_sub_recursive WHERE type_key = '$this->typeKey' AND user_id='$this->userId' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two, $add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four);
$stmt->fetch();
$rowCount = $stmt->num_rows;

if($rowCount != 0)  {

// employeeAddSubArray += (userId+ '|' +typeKey+ '|' +radioCheckOne+ '|' +amountValueOne+ '|' +descriptionValueOne+ '|' +recursiveResultOne+ '|' +radioCheckTwo+ '|' +amountValueTwo+ '|' +descriptionValueTwo+ '|' +recursiveResultTwo+ '|' +radioCheckThree+ '|' +amountValueThree+ '|' +descriptionValueThree+ '|' +recursiveResultThree+ '|' +radioCheckFour+ '|' +amountValueFour+ '|' +descriptionValueFour+ '|' +recursiveResultFour+ '@')

switch ($add_sub_one) {
    case "E":
    $this->recurseCheckOne = 'N';
    $this->addSubAmountOne = null;
    $this->addSubDescOne = null;
    $this->addSubOneArray = "$add_sub_one|$this->addSubDescOne|$this->addSubAmountOne|$this->recurseCheckOne|";
    break;
    case "A": 
    $this->recurseCheckOne = 'Y';
    $this->addSubAmountOne = $add_sub_amount_one;
    $this->addSubDescOne = $add_sub_desc_one;
    $this->totalAmount = $this->subTotal + $this->addSubAmountOne;
    $this->addSubOneArray = "$add_sub_one|$this->addSubDescOne|$this->addSubAmountOne|$this->recurseCheckOne|";
    break;
    case "S":
    $this->recurseCheckOne = 'Y';
    $this->addSubAmountOne = $add_sub_amount_one;
    $this->addSubDescOne = $add_sub_desc_one;
    $this->totalAmount = $this->subTotal - $this->addSubAmountOne;
    $this->addSubOneArray = "$add_sub_one|$this->addSubDescOne|$this->addSubAmountOne|$this->recurseCheckOne|";
    break;
    }

switch ($add_sub_two) {
    case "E":
    $this->recurseCheckTwo = 'N';
    $this->addSubAmountTwo = null;
    $this->addSubDescTwo = null;
    $this->addSubTwoArray = "$add_sub_two|$this->addSubDescTwo|$this->addSubAmountTwo|$this->recurseCheckTwo|";
    break;
    case "A": 
    $this->recurseCheckTwo = 'Y';
    $this->addSubAmountTwo = $add_sub_amount_two;
    $this->addSubDescTwo = $add_sub_desc_two;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal + $this->addSubAmountTwo;
              }else{
              $this->totalAmount = $this->subTotal + $this->addSubAmountTwo;
              }                       
    $this->addSubTwoArray = "$add_sub_two|$this->addSubDescTwo|$this->addSubAmountTwo|$this->recurseCheckTwo|";
    break;
    case "S":
    $this->recurseCheckTwo = 'Y';
    $this->addSubAmountTwo = $add_sub_amount_two;
    $this->addSubDescTwo = $add_sub_desc_two;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal - $this->addSubAmountTwo;
              }else{
              $this->totalAmount = $this->subTotal - $this->addSubAmountTwo;
              }    
    $this->addSubTwoArray = "$add_sub_two|$this->addSubDescTwo|$this->addSubAmountTwo|$this->recurseCheckTwo|"; 
    break;
    }

switch ($add_sub_three) {
    case "E":
    $this->recurseCheckThree = 'N';
    $this->addSubAmountThree = null;
    $this->addSubDescThree = null;
    $this->addSubThreeArray = "$add_sub_three|$this->addSubDescThree|$this->addSubAmountThree|$this->recurseCheckThree|";
    break;
    case "A": 
    $this->recurseCheckThree = 'Y';
    $this->addSubAmountThree = $add_sub_amount_three;
    $this->addSubDescThree = $add_sub_desc_three;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal + $this->addSubAmountThree;
              }else{
              $this->totalAmount = $this->subTotal + $this->addSubAmountThree;
              }     
    $this->addSubThreeArray = "$add_sub_three|$this->addSubDescThree|$this->addSubAmountThree|$this->recurseCheckThree|";
    break;
    case "S":
    $this->recurseCheckThree = 'Y';
    $this->addSubAmountThree = $add_sub_amount_three;
    $this->addSubDescThree = $add_sub_desc_three;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal - $this->addSubAmountThree;
              }else{
              $this->totalAmount = $this->subTotal - $this->addSubAmountThree;
              }     
    $this->addSubThreeArray = "$add_sub_three|$this->addSubDescThree|$this->addSubAmountThree|$this->recurseCheckThree|";
    break;
    }

switch ($add_sub_four) {
    case "E":
    $this->recurseCheckFour = 'N';
    $this->addSubAmountFour = null;
    $this->addSubDescFour = null;
    $this->addSubFourArray = "$add_sub_four|$this->addSubDescFour|$this->addSubAmountFour|$this->recurseCheckFour|";
    break;
    case "A": 
    $this->recurseCheckFour = 'Y';
    $this->addSubAmountFour = $add_sub_amount_four;
    $this->addSubDescFour = $add_sub_desc_four;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal + $this->addSubAmountFour;
              }else{
              $this->totalAmount = $this->subTotal + $this->addSubAmountFour;
              }     
    $this->addSubFourArray = "$add_sub_four|$this->addSubDescFour|$this->addSubAmountFour|$this->recurseCheckFour|";
    break;
    case "S":
    $this->recurseCheckFour = 'Y';
    $this->addSubAmountFour = $add_sub_amount_four;
    $this->addSubDescFour = $add_sub_desc_four;
           if($this->totalAmount == null) {    
              $this->totalAmount = $this->subTotal - $this->addSubAmountFour;
              }else{
              $this->totalAmount = $this->subTotal - $this->addSubAmountFour;
              }     
    $this->addSubFourArray = "$add_sub_four|$this->addSubDescFour|$this->addSubAmountFour|$this->recurseCheckFour|";
    break;
    }                                            

  if(($add_sub_one == 'E') && ($add_sub_two == 'E') && ($add_sub_three == 'E') && ($add_sub_four == 'E')) {
      $this->totalAmount = $this->subTotal;      
     }

$this->addSubTotalArray = "$this->addSubOneArray$this->addSubTwoArray$this->addSubThreeArray$this->addSubFourArray";
          

   }else{
   $this->totalAmount = $this->subTotal;
   $emptyAddSub = 'E|||N|E|||N|E|||N|E|||N|';
   $this->addSubTotalArray = "$emptyAddSub";
   } 

}
//---------------------------------------------------------------------------------------------------------------------
function loadSalesBonusPayData() {

$dbMain = $this->dbconnect();
$this->salesHtmlArray = '';
$stmt = $dbMain ->prepare("SELECT bonus_switch, bonus_type, num_sales_tier_1, num_sales_tier_2, sales_tot_tier_1, sales_tot_tier_2, payout_tier_1, payout_tier_2 FROM sales_pay_options WHERE sales_setup_key = '1' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($bonus_switch, $bonus_type, $num_sales_tier_1, $num_sales_tier_2, $sales_tot_tier_1, $sales_tot_tier_2, $payout_tier_1, $payout_tier_2);
$stmt->fetch();  
$stmt->close(); 

$htmlBeg = "<tr></tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Sales</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales: $this->bonusTotSales</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales: $this->bonusNumSales</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Bonus Payout: $$this->bonusPayout</font></th>
</tr>
";


 
$html = "<
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Sales Listing</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Commission Amount</font></th>
</tr>";   

$total = 0;
$counter = 0;

    
        $stmt = $dbMain ->prepare("SELECT unit_price, overide_pin, overide_unit_price, contract_key, sale_date_time FROM sales_info WHERE user_id = '$this->userId' AND (sale_date_time BETWEEN  '$this->dateStart' AND '$this->dateEnd')");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($unit_price, $overide_pin, $overide_unit_price, $contract_key, $sale_date_time); 
        while($stmt->fetch()){
            if($overide_unit_price == 0.00){
                $total += $unit_price;
                $price = $unit_price;
            }else{
                $total += $overide_unit_price;
                $price = $overide_unit_price;
            }
           //echo "sales data test";
            $counter++;
            
            
             $rangeStart = date("Y-m-d H:i:s",mktime(0,0,0,date('m',strtotime($sale_date_time)),date('d',strtotime($sale_date_time)),date('Y',strtotime($sale_date_time))));
            $rangeEnd = date("Y-m-d H:i:s",mktime(23,59,59,date('m',strtotime($sale_date_time)),date('d',strtotime($sale_date_time)),date('Y',strtotime($sale_date_time))));
            //echo "$rangeStart $rangeEnd";
            $stmt99 = $dbMain ->prepare("SELECT commission FROM commission_credit WHERE  user_id='$this->userId' AND (sale_date_time BETWEEN '$rangeStart' AND '$rangeEnd')");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($commission);         
             $stmt99->fetch();
             $stmt99->close();
            
            $stmt99 = $dbMain ->prepare("SELECT first_name, last_name FROM contract_info WHERE contract_key = '$contract_key' ");
            $stmt99->execute();      
            $stmt99->store_result(); 
            $stmt99-> bind_result($first_name, $last_name);
            $stmt99->fetch();  
            $stmt99->close(); 
            
            $first_name = trim($first_name);
            $first_name = strtolower($first_name);
            $first_name = ucfirst($first_name);
            
            $last_name = trim($last_name);
            $last_name = strtolower($last_name);
            $last_name = ucfirst($last_name);
            
            $name = "$first_name $last_name";
            
            $this->salesHtmlArray .= "$name,$price,$contract_key,$commission~";
            
            //echo "$name,$price,$contract_key,$commission<br>";
            
            $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$price</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$commission</b></font>
                                        </td>
                                        </tr>\n";
            
        }
        
        $stmt->close();
        
if($bonus_switch == '1'){
   if ($bonus_type == 'S'){ 
        if ($total >= $sales_tot_tier_1 AND $total < $sales_tot_tier_2){
            $payout = $payout_tier_1;
        }elseif ($total > $sales_tot_tier_1 AND $total >= $sales_tot_tier_2){
            $payout = $payout_tier_2;
        }elseif ($total < $sales_tot_tier_1){
            $payout = 0;
        }
   }else{
        if ($counter >= $num_sales_tier_1 AND $counter < $num_sales_tier_2){
            $payout = $payout_tier_1;
        }elseif ($counter > $num_sales_tier_1 AND $counter >= $num_sales_tier_2){
            $payout = $payout_tier_2;
        }elseif ($counter < $num_sales_tier_1){
            $payout = 0;
        }
    }
}else{
    $payout = 0;
}
//echo "bt $bonus_type tot $total c $counter num $num_sales_tier_1 num $num_sales_tier_2 tot1 $sales_tot_tier_1 tot2 $sales_tot_tier_2";
$this->salesHtml = "$htmlBeg$html";


$this->bonusNumSales = $counter;
$this->bonusTotSales = sprintf("%01.2f", $total);
$this->bonusPayout = sprintf("%01.2f", $payout);

$salesHtmlArrayBeg = "$this->bonusTotSales,$this->bonusNumSales,$this->bonusPayout@";

$this->salesHtmlArray = "$salesHtmlArrayBeg$this->salesHtmlArray";

//echo"num $this->bonusNumSales tot $this->bonusTotSales pay $this->bonusPayout uid $this->userId<br>";
}
//---------------------------------------------------------------------------------------------------------------------
function loadLastPayrollCloseDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(close_date)  FROM payroll_settled WHERE type_key = '$this->typeKey' AND user_id = '$this->userId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($close_date); 
             $stmt->fetch();

$this->lastParollCloseDate = $close_date;

}
//=========================================================================================================================
function makeDaysEndMidnight() {
$dbMain = $this->dbconnect();
$stmt99 = $dbMain ->prepare("SELECT timeclock_key, user_id, clock_in, clock_out FROM timeclock WHERE  id_card='$this->idCard' AND clock_out > '$this->closeDate'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($timeclock_key, $user_id, $clock_in, $clock_out);         
             $rowCount = $stmt99->num_rows;
             
       if($rowCount != 0)  {
           
                    while ($stmt99->fetch()) { 
                        $day1 = date('d', strtotime($clock_in));
                        $day2 = date('d', strtotime($clock_out));
                        //echo "$day1     $day2";
                        
                        if ($day1 != $day2){
                            // echo"ttttttttttttttttttttttttttttteeeeeeeeeeessssssssssssssssssssssssssstttttttttttttt";
                            $day = explode('-',$clock_in);
                            $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $day[1], $day1, $day[0]));//"$day[0]-$day[1]-$day[2] 23:59:59";
                            //$datetime1 = new DateTime($datetime1);
                            
                            $sql = "UPDATE timeclock SET clock_out = ?  WHERE timeclock_key = '$timeclock_key'";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('s', $dayEnd);
                            $stmt->execute();        
                            $stmt->close();
                            
                            $dayArray = explode('-',$clock_out);
                            $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $dayArray[1], $day2, $dayArray[0]));//"$day2[0]-$day2[1]-$day2[2] 00:00:00";
                            $time_key = "";                            
                            $sql = "INSERT INTO timeclock VALUES (?,?,?,?,?)";
                            $stmt = $dbMain->prepare($sql);
                            $stmt->bind_param('iiiss',$time_key, $user_id, $this->idCard,$dayStart,$clock_out);
                            $stmt->execute();        
                            $stmt->close();
                        }
                }
        }
}
//======================================================================================================================
function calculateDailyOT(){
   
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT ot_hourly_state_rule, ot_secondary_hourly_state_rule, ot_weekly_state_rule FROM payroll_ot_rules_hours WHERE state='$this->payrollState'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($ot_hourly_state_rule,$ot_secondary_hourly_state_rule, $ot_weekly_state_rule); 
    $stmt->fetch();
    
   //echo"idcard $this->idCard dHours $this->dailyHours  dMins $this->dailyMins dsecs $this->dailySecs";
    if ($ot_hourly_state_rule != 0) {
        if ($this->payrollState != 'CO'){
    if ($this->dailyHours >= $ot_hourly_state_rule){
        switch ($this->dailyHours) {
        case 8:
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier1 =  $this->oTMinsTier1 + $this->dailyMins;  
            $this->oTSecsTier1 = $this->oTSecsTier1 + $this->dailySecs;  
            break;    
        case 9:
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier1 =  $this->oTMinsTier1 + $this->dailyMins; 
            $this->oTSecsTier1 = $this->oTSecsTier1 + $this->dailySecs;   
            break;
        case 10:
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier1 =  $this->oTMinsTier1 + $this->dailyMins;
            $this->oTSecsTier1 = $this->oTSecsTier1 + $this->dailySecs;  
            break;
        case 11:
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier1 =  $this->oTMinsTier1 + $this->dailyMins;
            $this->oTSecsTier1 = $this->oTSecsTier1 + $this->dailySecs;    
            break;
        case 12:
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier2 =  $this->oTMinsTier2 + $this->dailyMins;
            $this->oTSecsTier2 = $this->oTSecsTier2 + $this->dailySecs;    
            break;    
        default:
            $hours_tier_1 = 12 - $ot_hourly_state_rule;
            $hours_tier_2 = $this->dailyHours - $ot_secondary_hourly_state_rule;
            $this->oTHoursTier1 = $this->oTHoursTier1 + $hours_tier_1; // ot hours over 8
            $this->oTHoursTier2 = $this->oTHoursTier2 + $hours_tier_2; // ot hours over 12
            $this->oTMinsTier2 =  $this->oTMinsTier2 + $this->dailyMins;
            $this->oTSecsTier2 = $this->oTSecsTier2 + $this->dailySecs;
            break;
            }
       
      }
      }else{
        if ($this->dailyHours >= $ot_hourly_state_rule){
            $this->oTHoursTier1 = $this->oTHoursTier1 + ($this->dailyHours - $ot_hourly_state_rule); // ot hours over 8
            $this->oTMinsTier1 =  $this->oTMinsTier1 + $this->dailyMins;
            $this->oTSecsTier1 = $this->oTSecsTier1 + $this->dailySecs;    
         
            }
      }
      }
     // echo "HoursTier1  $this->oTHoursTier1   MinsTier1  $this->oTMinsTier1 SecsTier1 $this->oTSecsTier1 HoursTier2   $this->oTHoursTier2  MinsTier2  $this->oTMinsTier2  SecsTier2 $this->oTSecsTier2<br>";
      }

//==================================================================================================================
function loadMonday($selectDate) {

$dayWeek = date("N", strtotime($selectDate));
$dayOfMonth = date("j", strtotime($selectDate));


$month = date("n", strtotime($selectDate));
$year = date("Y", strtotime($selectDate));


switch($dayWeek) {
        case "1":
        $day = date("d", strtotime($selectDate));
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $day, $year));     
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 6, $year));  
        break;
        
        case "2":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 1, $year)); 
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 5, $year)); 
        break;
        
        case "3":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 2, $year));
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 4, $year)); 
        
        break;        
        
        case "4":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 3, $year)); 
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 3, $year)); 
        break;          
        
        case "5":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 4, $year)); 
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 2, $year)); 
        break;           
        
        case "6":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 5, $year)); 
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth + 1, $year)); 
        break;           
        
        case "7":
        $monDay = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth - 6, $year)); 
        $sunDay = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year)); 
        break;            
        }


$dateArray = array($monDay, $sunDay);

return $dateArray;
}
//========================================================================================================
function calcWeeklyOT(){
    //echo"<br><br><br><br><br><br><br><br>";
    $dbMain = $this->dbconnect();

    $this->weeklyOvertime = 0;
    $otMTier1 = 0;
    $otMTier2 = 0;
    
    
     $stmt = $dbMain ->prepare("SELECT ot_hourly_state_rule, ot_secondary_hourly_state_rule, ot_weekly_state_rule FROM payroll_ot_rules_hours WHERE state='$this->payrollState'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($ot_hourly_state_rule,$ot_secondary_hourly_state_rule, $ot_weekly_state_rule); 
    $stmt->fetch();
    
    $dayOfMonth = date("j");
    $endOfMonth = date("t");
    $todaysDate = date("Y-m-d");
    $dayOfWeek = date("w");
    $dayOfWeek = $dayOfWeek +1;
    $todaysDate = date("Y-m-d");
    $month = date("n", strtotime($todaysDate));
    $year = date("Y", strtotime($todaysDate));
    $todayNumDay = date("d", strtotime($todaysDate));

    switch ($this->payrollCycle) {
            case "D":

                 $this->closeDate = date("Y-m-d H:i:s",mktime( 23, 59, 59, $month, $todayNumDay, $year));
                 $dayStart = date("Y-m-d H:i:s",mktime( 0, 0, 0, $month, $todayNumDay, $year));
                 

                 
                 $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$this->closeDate' AND id_card ='$this->idCard'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($clock_in, $clock_out);     
                     
                 while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + date('i',mktime (0,$parts[1],$parts[2],0,0,0));
                                        $this->dailySecs = $this->dailySecs + date('s',mktime (0,$parts[1],$parts[2],0,0,0));
                                        }                       
                              $stmt->close();
                              
                              $this->calculateDailyOT();                                  
                               
                               $hours = $this->dailyHours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                                                              
                               $minutes = $this->dailyMins - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $this->dailySecs - $this->oTSecsTier2 - $this->oTSecsTier1;
                               
                               if ($hours < 0){
                                    $hours = 0;
                                }
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                              
                                $this->oTWeek1 = "$this->oTHoursTier1.$this->oTMinsTier1.$this->oTSecsTier1";                              
                                $this->overtimeTier2 = "$this->oTHoursTier2.$this->oTMinsTier2.$this->oTSecsTier2";
                              
                              //echo "daystart $dayStart close $this->closeDate otwk1 $this->oTWeek1 ottier2 $this->overtimeTier2 dh $this->dailyHours dm $this->dailyMins ds $this->dailySecs";
                                
                               
            break;
            case "W":
            //echo "month $month<br>";
                 /*if($dayOfWeek <= 7) {                        
                        $this->closeDate = date('Y-m-d H:i:s', mktime(23, 59, 59, $month, strtotime( 'This Saturday'), $year));
                   }*/
                    //$date = explode('-',$this->closeDate);
                    //echo "d1 $date[1]<br>";
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $firstday1 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $dayOfMonth-7, $year));
                    $endweek1 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $dayOfMonth, $year));
                    
                    $monArray1 = $this->loadMonday($firstday1);
                    $firstday1 = $monArray1[0];
                    $endweek1 = $monArray1[1];   
                    
                    $this->closeDate = $endweek1;
                      
                    $start1 = date('d', strtotime($firstday1));
                    $end1 = date('d', strtotime($endweek1)); 
                   
                    //echo"FUBAR $this->closeDate <br> $start1 $end1 <br> $start2 $end2  fd $firstday1  ew $endweek1<br>";
                     
                           //echo"$this->idCard <br> $this->closeDate";
                           
                    if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart1 = date("n", strtotime($firstday1));
                    $monthEnd1 = date("n", strtotime($endweek1));
                    
                    $this->otDateRange = "$monthStart1/$start1-$monthEnd1/$end1"; 
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart1, $start1+$i, $year));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart1, $start1+$i, $year));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + date('i',mktime (0,$parts[1],$parts[2],0,0,0));
                                        $this->dailySecs = $this->dailySecs + date('s',mktime (0,$parts[1],$parts[2],0,0,0));
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek1 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek1 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                                 
                                //echo "idcard  $this->idCard  WEEKLYthis->oTWeek1  $this->oTWeek1     firstday1 $firstday1  endweek1  $endweek1   WEEKLYtotalHours   $hours   this->overtimeTier2 $this->overtimeTier2  7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay doubtime minutes $tier2Mins  OTMINS $t1minsWeek1     otmintier1 $this->oTMinsTier1  7thday mins   $minutesOT  MINUTES $minutes<br>";
            break;
            case "B";
                 if(($dayOfMonth <= 20) AND ($dayOfMonth > 5)){
                    $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), 15, date('Y')));
                    //$dateArray = explode("-",$this->closeDate);  //////////////////testing
                    //$this->closeDate = "2012-08-$dateArray[2]";  // testing     
                    }elseif($dayOfMonth <= 5){
                      $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m')-1, $endOfMonth, date('Y')));
                        //$dateArray = explode("-",$this->closeDate);  //////////////////testing
                    //$this->closeDate = "2012-08-$dateArray[2]";  // testing             
                    }else{
                        $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), $endOfMonth, date('Y')));
                          //$dateArray = explode("-",$this->closeDate);  //////////////////testing
                    //$this->closeDate = "2012-08-$dateArray[2]";  // testing     
                    }
                    
                    $date = explode('-',$this->closeDate);
                    $firstday1 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-14, $date[0]));
                    $endweek1 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2]-8, $date[0]));
                    $firstday2 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-7, $date[0]));
                    $endweek2 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2], $date[0]));
                    
                    $monArray1 = $this->loadMonday($firstday1);
                    $firstday1 = $monArray1[0];
                    $endweek1 = $monArray1[1];      
                    
                    $monArray2 = $this->loadMonday($firstday2);
                    $firstday2 = $monArray2[0];
                    $endweek2 = $monArray2[1];                        
                    
                                       
                    $start1 = date('d', strtotime($firstday1));
                    $end1 = date('d', strtotime($endweek1)); 
                    $start2 = date('d', strtotime($firstday2));
                    $end2 = date('d', strtotime($endweek2));
                    
                    $monthStart1 = date("n", strtotime($firstday1));
                    $monthEnd1 = date("n", strtotime($endweek1));
					 $monthStart2 = date("n", strtotime($firstday2));
                    $monthEnd2 = date("n", strtotime($endweek2));
                     
                    
                    //echo"FUBAR <br> $start1 $end1 <br> $start2 $end2  <br>";
                    
                    
                               
                           //echo"$this->idCard <br> $this->closeDate";
                           
                    if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $this->oTWeek1 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart1 = date("n", strtotime($firstday1));
                    $monthEnd1 = date("n", strtotime($endweek1));
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart1, $start1+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart1, $start1+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        /*if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }*/
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + date('i',mktime (0,$parts[1],$parts[2],0,0,0));
                                        $this->dailySecs = $this->dailySecs + date('s',mktime (0,$parts[1],$parts[2],0,0,0));
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer =  $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek1 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek1 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                                
                                
                                //echo "idcard  $this->idCard  WEEKLYthis->oTWeek1  $this->oTWeek1     firstday1 $start1  endweek1  $end1   WEEKLYtotalHours   $hours   this->overtimeTier2 $this->overtimeTier2  7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay <br>";
                    if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart2 = date("n", strtotime($firstday2));
                    $monthEnd2 = date("n", strtotime($endweek2));
                    
                    $this->otDateRange = "$monthStart1/$start1-$monthEnd2/$end2"; 
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart2, $start2+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart2, $start2+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        /*if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }*/
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + date('i',mktime (0,$parts[1],$parts[2],0,0,0));
                                        $this->dailySecs = $this->dailySecs + date('s',mktime (0,$parts[1],$parts[2],0,0,0));
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                              // $hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek2 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek2 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek2 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek2 = $this->oTWeek2 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek2 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek2 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek2 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek2 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek2 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek2 = $this->oTWeek2 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek2 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek2 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                               //echo "$this->idCard  WEEKLYthis->oTWeek2  $this->oTWeek2     firstday2 $start2  endweek2  $end2   WEEKLYtotalHours   $hours this->overtimeTier2  $this->overtimeTier2   7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay<br>"; 
       
            break;
            case "M";
                if(($dayOfMonth < $endOfMonth) AND ($dayOfMonth > 5)) {                    
                   $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m'), $endOfMonth, date('Y'))); 
                   }elseif(($dayOfMonth <= 5)){
                     $this->closeDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m')-1, $endOfMonth, date('Y')));
                   }else{
                    $this->closeDate = $todaysDate;
                   }
                   $date = explode('-',$this->closeDate);
                   echo "$this->closeDate  $date[2]<br>";
                    $firstday1 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-28, $date[0]));
                    $endweek1 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2]-22, $date[0]));
                    $firstday2 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-21, $date[0]));
                    $endweek2 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2]-15, $date[0]));
                    $firstday3 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-14, $date[0]));
                    $endweek3 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2]-8, $date[0]));
                    $firstday4 = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $date[1], $date[2]-7, $date[0]));
                    $endweek4 =  date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $date[1], $date[2], $date[0]));
                    
                    
                    $monArray1 = $this->loadMonday($firstday1);
                    $firstday1 = $monArray1[0];
                    $endweek1 = $monArray1[1];      
                    
                    $monArray2 = $this->loadMonday($firstday2);
                    $firstday2 = $monArray2[0];
                    $endweek2 = $monArray2[1];  
                    
                    $monArray3 = $this->loadMonday($firstday3);
                    $firstday3 = $monArray3[0];
                    $endweek3 = $monArray3[1];      
                    
                    $monArray4 = $this->loadMonday($firstday4);
                    $firstday4 = $monArray4[0];
                    $endweek4 = $monArray4[1];                                  
                    
                                       
                    $start1 = date('d', strtotime($firstday1));
                    $end1 = date('d', strtotime($endweek1)); 
                    
                    $start2 = date('d', strtotime($firstday2));
                    $end2 = date('d', strtotime($endweek2));
                    
                    $start3 = date('d', strtotime($firstday3));
                    $end3 = date('d', strtotime($endweek3)); 
                    
                    $start4 = date('d', strtotime($firstday4));
                    $end4 = date('d', strtotime($endweek4));
                   
                   $monthStart1 = date("n", strtotime($firstday1));
                    $monthEnd1 = date("n", strtotime($endweek1));
					 $monthStart2 = date("n", strtotime($firstday2));
                    $monthEnd2 = date("n", strtotime($endweek2));
                     $monthStart3 = date("n", strtotime($firstday3));
                    $monthEnd3 = date("n", strtotime($endweek3));
                     $monthStart4 = date("n", strtotime($firstday4));
                    $monthEnd4 = date("n", strtotime($endweek4));

                    
                    //echo"FUBAR <br> $start1 $end1 <br> $start2 $end2  <br> $start3 $end3 <br>  $start4 $end4<br>";
                    
                    
                               
                           //echo"$this->idCard <br> $this->closeDate";
                           
                    if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart1 = date("n", strtotime($firstday1));
                    $monthEnd1 = date("n", strtotime($endweek1));
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart1, $start1+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart1, $start1+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + $parts[1];
                                        $this->dailySecs = $this->dailySecs + $parts[2];
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek1 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek1 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek1 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek1 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek1 = $this->oTWeek1 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek1 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek1 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                                
                                
                                //echo "idcard  $this->idCard  WEEKLYthis->oTWeek1  $this->oTWeek1     firstday1 $start1  endweek1  $end1   WEEKLYtotalHours   $hours   this->overtimeTier2 $this->overtimeTier2  7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay <br>";
                      if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart2 = date("n", strtotime($firstday2));
                    $monthEnd2 = date("n", strtotime($endweek2));
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart2, $start2+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart2, $start2+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + $parts[1];
                                        $this->dailySecs = $this->dailySecs + $parts[2];
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek2 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek2 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek2 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek2 = $this->oTWeek2 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek2 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek2 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek2 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek2 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek2 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek2 = $this->oTWeek2 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek2 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek2 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                              // echo "$this->idCard  WEEKLYthis->oTWeek2  $this->oTWeek2     firstday2 $start2  endweek2  $end2   WEEKLYtotalHours   $hours this->overtimeTier2  $this->overtimeTier2   7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay<br>"; 
                    
                               
                           //echo"$this->idCard <br> $this->closeDate";
                           
                     if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart3 = date("n", strtotime($firstday3));
                    $monthEnd3 = date("n", strtotime($endweek3));
                    
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart3, $start3+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart3, $start3+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + $parts[1];
                                        $this->dailySecs = $this->dailySecs + $parts[2];
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek3 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek3 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek3 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek3 = $this->oTWeek3 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek3 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek3 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek3 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek3 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek3 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek3 = $this->oTWeek3 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek3 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek3 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                                
                                
                              //  echo "idcard  $this->idCard  WEEKLYthis->oTWeek3  $this->oTWeek3     firstday3 $start3  endweek3  $end3   WEEKLYtotalHours   $hours   this->overtimeTier2 $this->overtimeTier2  7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay <br>";
                      if ($this->payrollState == 'CA'){
                        $seventhDay = 1;
                    }else {
                        $seventhDay = 0;
                        }
                    $secondsArray = 0;
                    $secondsArrayOT  = 0;
                    $doubTime = 0;
                    $doubTimeMins = 0;
                    $doubTimeSecs = 0;
                    $this->oTHoursTier1 = 0;
                    $this->oTMinsTier1 = 0;
                    $this->oTSecsTier1 = 0;
                    $this->oTHoursTier2 = 0;
                    $this->oTMinsTier2 = 0; 
                    $this->oTSecsTier2 = 0;
                    $minutes = 0;
                     $seventhDayBuffer = 0;
                    //$this->overtimeTier2 = 0;     
                    
                    $dayCount = 7;
                    for($i = 0; $i <= 6; $i++){
                    if ($i < 10){
                        $i = "0$i";
                            } 
                    $this->dailyHours = 0;
                    $this->dailyMins = 0; 
                    $this->dailySecs = 0;
                    
                    $monthStart4 = date("n", strtotime($firstday4));
                    $monthEnd4 = date("n", strtotime($endweek4));
                    
                    $this->otDateRange = "$monthStart1/$start1-$monthEnd4/$end4"; 
                        
                    $dayStart = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $monthStart4, $start4+$i, $date[0]));
                    $dayEnd = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $monthStart4, $start4+$i, $date[0]));
                    
                    //echo "dayStart  $dayStart  dayEnd   $dayEnd<br>";
                
                            $stmt = $dbMain ->prepare("SELECT clock_in, clock_out FROM timeclock WHERE clock_out BETWEEN '$dayStart'  AND '$dayEnd' AND id_card ='$this->idCard'");
                             $stmt->execute();      
                             $stmt->store_result();      
                             $stmt->bind_result($clock_in, $clock_out);         
                             $rowCount = $stmt->num_rows;
                             if($rowCount != 0)  {
                                    while ($stmt->fetch()) {
                                        $datetime1 = new DateTime($clock_in);
                                        $datetime2 = new DateTime($clock_out);
                                        $interval = $datetime1->diff($datetime2);
                                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                                        $parts = explode(':', $hoursMinsSecs);
                                        if ($parts[1] == '59'){
                                            $parts[1] = 0;                           //
                                            $parts[0] = $parts[0] + 1;
                                           }
                                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                                        $this->dailyHours = $this->dailyHours + $parts[0];
                                        $this->dailyMins = $this->dailyMins + $parts[1];
                                        $this->dailySecs = $this->dailySecs + $parts[2];
                                        if (($dayCount == 1) AND ($rowCount >= 2) AND ($seventhDay == 1)){
                                            $seventhDayBuffer = $seventhDayBuffer + $parts[0];
                                            $rowCount = $rowCount - 1;
                                        }
                                        if (($dayCount == 1) AND ($seventhDay == 1)){
                                            if ($this->dailyHours >= 8){
                                                //echo "tester****************";
                                                $doubTime = $this->dailyHours - '8';
                                                $doubTimeMins = $this->dailyMins;
                                                $doubTimeSecs = $this->dailySecs;
                                                $seconds = 8 * 60 * 60;
                                                $secondsArrayOT .= "$seconds|";
                                                
                                            }else{
                                                 $secondsArrayOT .= "$seconds|";
                                            }
                                        }else{
                                             $secondsArray .= "$seconds|";
                                        }
                                       
                                        }
                                         $dayCount = $dayCount - 1;
                                        }else{
                                            $seventhDay = 0;
                                            $dayCount = $dayCount - 1;
                                        } 
                                     //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;   
                                     
                                        
                                    $this->calculateDailyOT();       
                                    if (($doubTime > '0') or ($doubTimeMins > '0')){
                                        
                                        if ($doubTime > '4'){
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - 4;// so dont doublecount daily ot
                                             $this->oTHoursTier2 = $this->oTHoursTier2 - ($doubTime - 4);
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeMins;
                                             $this->oTMinsTier2 = $this->oTMinsTier2 - $doubTimeSecs;
                                             }else{
                                             $this->oTHoursTier1 = $this->oTHoursTier1 - $doubTime;
                                             $this->oTMinsTier1 = $this->oTMinsTier1 - $doubTimeMins;
                                             $this->oTSecsTier1 = $this->oTSecsTier1 - $doubTimeSecs;
                                         }
                                    }      
                              }                       
                              $stmt->close();
                              
                              $this->overtimeTier2 = $this->overtimeTier2 + $this->oTHoursTier2 + $doubTime;
                              /*$otMTier1 = $this->oTMinsTier1 + $otMTier1;
                              $otMTier2 = $this->oTMinsTier2 + $otMTier2;
                              $otSTier1 = $this->oTSecsTier1 + $otSTier1;
                              $otSTier2 = $this->oTSecsTier2 + $otSTier2;*/
                              //$this->overtimeTier2 = "$this->overtimeTier2.$this->oTMinsTier2";
                              //$this->oTMinsTier2 = $this->oTMinsTier2 + $doubTimeMins;
                              
                              
                              $secondsArrayOT = explode("|", $secondsArrayOT);
                               $totalSecondsOT = array_sum($secondsArrayOT);
                               $hoursOT = floor($totalSecondsOT / 3600);
                               $hoursOT = $hoursOT - $seventhDayBuffer;
                               //$minutesOT = trim($minutesOT);
                               
                               //$hoursOT =  date('G',mktime (0,0,$totalSecondsOT,0,0,0));
                               $minutesOT =  date('i',mktime (0,0,$totalSecondsOT,0,0,0));
                               $secondsOT =  date('s',mktime (0,0,$totalSecondsOT,0,0,0));
                               
                               //$totalHoursOT = "$hoursOT.$minutesOT";// 7thday ot
                               
                               $secondsArray = explode("|", $secondsArray);
                               $totalSeconds = array_sum($secondsArray);
                               $hours = floor($totalSeconds / 3600);//weekly ot total hours
                               //$minutes = floor(($totalSeconds / 60) % 60);
                               
                               //$hours =  date('G',mktime (0,0,$totalSeconds,0,0,0));
                               $minutes =  date('i',mktime (0,0,$totalSeconds,0,0,0));
                               $secondsREG =  date('s',mktime (0,0,$totalSeconds,0,0,0));
                               
                               
                               $hours = $hours - $this->oTHoursTier1 - $this->oTHoursTier2;//dont count daily and weekly
                               
                               /*$mins = $this->oTMinsTier1 + $this->oTMinsTier2;
                               $minutes = abs($minutes - $mins);
                               if ($minutes >= 60){
                                $minutes = $minutes - 60;
                                $hours = $hours + 1;
                               }
                               
                               $totalHours = "$hours.$minutes";// weekly ot - daily ot*/
                               
                               $minutes = $minutes - $this->oTMinsTier2 - $this->oTMinsTier1;
                               $secondsREG = $secondsREG - $this->oTSecsTier2 - $this->oTSecsTier1;
                               if ($minutes < 0){
                                    $minutes = 0;
                                }
                                if ($secondsREG < 0){
                                    $secondsREG = 0;
                                }
                               
                               if ($hours > $ot_weekly_state_rule){
                                $this->oTWeek4 = $hours - $ot_weekly_state_rule + $hoursOT + $this->oTHoursTier1;
                                
                                //echo "ottier1 $this->oTMinsTier1 minsot  $minutesOT  mins  $minutes  otminstier2 $this->oTMinsTier2<br>";
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT + $secondsREG;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT + $minutes;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek4 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek4 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek4 = $this->oTWeek4 + $h;
                                //echo "@@@ h $h m $m s $s";
                                //$parseTier1Mins = $tier1Mins / 60;
                                //$tier1Array = explode('.',$parseTier1Mins);
                                //$t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier2 + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier2 + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek4 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek4 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                              //  echo "otminst2  $otMTier2  doubtimemins  $doubTimeMins  tott2mins $tier2Mins<br>";
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                               }else{
                                $this->oTWeek4 = $this->oTHoursTier1 + $hoursOT;
                                
                                $tier1Secs = $this->oTSecsTier1 + $secondsOT;
                                $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                                
                                $h =  date('G',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1minsWeek4 =  date('i',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                $t1secsWeek4 =  date('s',mktime (0,$tier1Mins,$tier1Secs,0,0,0));
                                 $this->oTWeek4 = $this->oTWeek4 + $h;
                                
                              
                               // $tier1Mins = $this->oTMinsTier1 + $minutesOT;
                              //  $parseTier1Mins = $tier1Mins / 60;
                               // $tier1Array = explode('.',$parseTier1Mins);
                              //  $t1minsWeek1 = $tier1Mins - ($tier1Array[0]*60);
                               
                                //$this->oTWeek1 = "$this->oTWeek1.$t1mins";
                                $tier2Secs = $this->oTSecsTier + $doubTimeSecs;
                                $tier2Mins = $this->oTMinsTier + $doubTimeMins;
                                $h2 =  date('G',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2minsWeek4 =  date('i',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $t2secsWeek4 =  date('s',mktime (0,$tier2Mins,$tier2Secs,0,0,0));
                                $this->overtimeTier2 = $this->overtimeTier2 + $h2;
                                
                                //$parseTier2Mins = $tier2Mins / 60;
                                //$tier2Array = explode('.',$parseTier2Mins);
                                //$t2minsWeek1 = $tier2Mins - ($tier2Array[0]*60);
                                
                                //$this->overtimeTier2 = "$this->overtimeTier2.$t2mins";
                                //$this->oTHoursTier2 = $this->oTHoursTier2 + $doubTime;
                                //$this->oTHoursTier2 = "$this->oTHoursTier2.$this->oTMinsTier2";
                                }
                             //  echo "$this->idCard  WEEKLYthis->oTWeek2  $this->oTWeek4     firstday4 $start4  endweek4  $end4   WEEKLYtotalHours   $hours this->overtimeTier2  $this->overtimeTier2   7THDAYtotalHoursOT   $hoursOT 7THDAY doubTime  $doubTime  seventhDay  $seventhDay<br>"; 
       
            break;
            }
            if ($this->payrollCycle != "D") {
       
            $t1minsWeek2 = $t1minsWeek2 - $t1minsWeek1;
            if ($t1minsWeek2 < 0){
               $t1minsWeek2 = 0; 
            }
            $t1minsWeek3 = $t1minsWeek3 - $t1minsWeek2 - $t1minsWeek1;
             if ($t1minsWeek3 < 0){
               $t1minsWeek3 = 0; 
            }
            $t1minsWeek4 = $t1minsWeek4 - $t1minsWeek3 - $t1minsWeek2 - $t1minsWeek1;
            if ($t1minsWeek4 < 0){
               $t1minsWeek4 = 0; 
            }
            /*$t1secsWeek2 = $t1secsWeek2 - $t1secsWeek1;
            if ($t1secsWeek2 < 0){
               $t1secsWeek2 = 0; 
            }
            $t1secsWeek3 = $t1secsWeek3 - $t1secsWeek2 - $t1secsWeek1;
             if ($t1secsWeek3 < 0){
               $t1secsWeek3 = 0; 
            }
            $t1secsWeek4 = $t1secsWeek4 - $t1secsWeek3 - $t1secsWeek2 - $t1secsWeek1;
            if ($t1secsWeek4 < 0){
               $t1secsWeek4 = 0; 
            }*/
            
            $totTier1Mins = $t1minsWeek1 + $t1minsWeek2 + $t1minsWeek3 + $t1minsWeek4;
            $totTier1Secs = $t1secsWeek1 + $t1secsWeek2 + $t1secsWeek3 + $t1secsWeek4;
            
       
            $T1H =  date('G',mktime (0,$totTier1Mins,$totTier1Secs,0,0,0));
            $T1M =  date('i',mktime (0,$totTier1Mins,$totTier1Secs,0,0,0));
            $T1S =  date('s',mktime (0,$totTier1Mins,$totTier1Secs,0,0,0));
            
            
            
           // $parseTotTier1Mins = $totTier1Mins / 60;
            //$totTier1Array = explode('.',$parseTotTier1Mins);
            //$totT1mins = $totTier1Mins - ($totTier1Array[0]*60);
            $this->oTWeek4 = $this->oTWeek4 + $T1H;
            
            
            /*$t2minsWeek2 = $t2minsWeek2 - $t2minsWeek1;
            if ($t2minsWeek2 < 0){
               $t2minsWeek2 = 0; 
            }
            $t2minsWeek3 = $t2minsWeek3 - $t2minsWeek2 - $t2minsWeek1;
             if ($t2minsWeek3 < 0){
               $t2minsWeek3 = 0; 
            }
            $t2minsWeek4 = $t2minsWeek4 - $t2minsWeek3 - $t2minsWeek2 - $t2minsWeek1;
            if ($t2minsWeek4 < 0){
               $t2minsWeek4 = 0; 
            }*/
            $totTier2Mins = $t2minsWeek1 + $t2minsWeek2 + $t2minsWeek3 + $t2minsWeek4;
            $totTier2Secs = $t2secsWeek1 + $t2secsWeek2 + $t2secsWeek3 + $t2secsWeek4;
            
       
            $T2H =  date('G',mktime (0,$totTier2Mins,$totTier2Secs,0,0,0));
            $T2M =  date('i',mktime (0,$totTier2Mins,$totTier2Secs,0,0,0));
            $T2S =  date('s',mktime (0,$totTier2Mins,$totTier2Secs,0,0,0));
            
            
            
            //$parseTotTier2Mins = $totTier2Mins / 60;
            //$totTier2Array = explode('.',$parseTotTier2Mins);
            //$totT2mins = $totTier2Mins - ($totTier2Array[0]*60);
            $this->overtimeTier2 = $this->overtimeTier2 + $T2H;
           /* 
            $lengtht1 = strlen($totT1mins);
            if($lengtht1 == 1){
                $totT1mins = "0$totT1mins";
            }
            
            $lengtht2 = strlen($totT2mins);
            if($lengtht2 == 1){
                $totT2mins = "0$totT2mins";
            }*/
            $this->overtimeTier2 = "$this->overtimeTier2.$T2M.$T2S";
            
    //echo "wk1 $this->oTWeek1 wk2 $this->oTWeek2 wk3 $this->oTWeek3 wk4 $this->oTWeek4";        
    $this->weeklyOvertime = $this->oTWeek1 + $this->oTWeek2 + $this->oTWeek3 + $this->oTWeek4;
    $this->weeklyOvertime = "$this->weeklyOvertime.$T1M.$T1S";
    }else if ($this->payrollCycle == "D") {
       //$this->overtimeTier2 = $this->oTHoursTier2;
       $this->weeklyOvertime =  $this->oTWeek1;
    }
    //echo "<br>this->weeklyOvertime  $this->weeklyOvertime   this->overtimeTier2  $this->overtimeTier2<br>";
}

//======================================================================================================================
function loadHours() {
    
$this->loadSalesBonusPayData();

$this->loadLastPayrollCloseDate();
$this->makeDaysEndMidnight();

$this->OT = 0;
$this->dailyOvertime = 0;
$this->overtimeTier2 = 0;

if($this->lastParollCloseDate == "") {
   $this->lastParollCloseDate = '000-00-00 00:00:00';
   }


  /*if($this->payrollCycle == "W"){
    $this->cycleDivisor = .5;
  } else if ($this->payrollCycle == "B"){
     $this->cycleDivisor = 1;
  } else if ($this->payrollCycle == "M"){
     $this->cycleDivisor = 2;
  }*/
   
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT ot_hourly_state_rule, ot_secondary_hourly_state_rule, ot_weekly_state_rule FROM payroll_ot_rules_hours WHERE state ='$this->payrollState'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($ot_hourly_state_rule,$ot_secondary_hourly_state_rule, $ot_weekly_state_rule); 
$stmt->fetch();
//echo "<br>  id $this->idCard $this->dateStart $this->dateEnd";
$stmt = $dbMain ->prepare("SELECT timeclock_key, clock_in, clock_out FROM timeclock WHERE  id_card='$this->idCard' AND (clock_out BETWEEN '$this->dateStart' AND '$this->dateEnd')");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($timeclock_key, $clock_in, $clock_out);         
             $rowCount = $stmt->num_rows;
             
       if($rowCount != 0)  {
           
                    while ($stmt->fetch()) { 
                        //echo "<br>  cin  $clock_in cout $clock_out<br>";
                        $datetime1 = new DateTime($clock_in);
                        $datetime2 = new DateTime($clock_out);
                      
                        $interval = $datetime1->diff($datetime2);
                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                        $parts = explode(':', $hoursMinsSecs);
                        //echo "h $parts[0] m $parts[1] s $parts[2]<br>";
                        if ($ot_hourly_state_rule != '0'){
                        if ($parts[0] > $ot_hourly_state_rule){
                            $parts[0] = 8;
                            $parts[1] = 0;
                            $parts[2] = 0;
                        }
                        }
                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                        $secondsArray .= "$seconds|";
                          
                        //$this->dailyHours = $parts[0];
                        //$this->dailyMins = $parts[1];
                        //$this->calculateDailyOT();
                        }
                        
                     
                // $this->calculateWeeklyOT();
                $this->calcWeeklyOT();
                
                //$this->calculateDailyOT();
                
                
                //$this->totalHoursLeft = $this->hoursProjected * $this->cycleDivisor;
                  
               $secondsArray = explode("|", $secondsArray);
               $totalSeconds = array_sum($secondsArray);
               //echo"**$totalSeconds";
               $hours = floor($totalSeconds / 3600);
               $RegTimeM =  date('i',mktime (0,0,$totalSeconds,0,0,0));
               $RegTimeS =  date('s',mktime (0,0,$totalSeconds,0,0,0));
               
               /*$minutes = floor(($totalSeconds / 60) % 60);
               if ($minutes == '59'){
                $minutes = 0;
                $hours = $hours + 1;
               }*/
               $totalHours = "$hours.$RegTimeM<br>";//.$RegTimeS
               
//echo "$totalHours";
              
                
              //$totalHours = $totalHours - $this->weeklyOvertime - $this->overtimeTier2;//************debugothourstier2 is zeroed out
                
              $this->totalHoursLeft = $this->hoursProjected - $totalHours;
              if ($this->totalHoursLeft < 0){
                $this->totalHoursLeft = 0;
                $totalHours = $this->hoursProjected;
                }
               //$this->totalHours = sprintf("%01.2f", $totalHours);
               
              if (($this->compensationType == 'S') OR ($this->compensationType == "SC")){
                $totalHours = $this->weeklyOvertime + $this->overtimeTier2 + $totalHours;
                //$this->OT = 0;
                //$this->OT = sprintf("%01.2f", $this->OT);
              
              // $this->overtimeTier2 = 0;
                //$this->overtimeTier2 = sprintf("%01.2f", $this->overtimeTier2);
                /*$array = explode(".",$totalHours);
                $parser = $array[1] /60;
                $array2 = explode(".",$parser);
                $h = $array[0] + $array2[0];
                $m = $array[1] - ($array2[0] * 60);
                $totalHours = "$h.$m";*/
                 $this->totalHours = sprintf("%01.2f", $totalHours);
                
              }else{
                //$totalHours = $this->weeklyOvertime + $this->overtimeTier2 + $totalHours;
                //$this->OT = ($this->compensationAmount * 1.5) * $this->weeklyOvertime;
                //$this->OT = sprintf("%01.2f", (($this->compensationAmount * 1.5) * $this->weeklyOvertime));
              
                //$this->overtimeTier2 = (($this->compensationAmount * 2) * $this->overtimeTier2);
                //$this->overtimeTier2 = sprintf("%01.2f", (($this->compensationAmount * 2) * $this->overtimeTier2));
                
                 /*$array = explode(".",$totalHours);
                $parser = $array[1] /60;
                $array2 = explode(".",$parser);
                $h = $array[0] + $array2[0];
                $m = $array[1] - ($array2[0] * 60);
                $totalHours = "$h.$m";*/
                $this->totalHours = sprintf("%01.2f", $totalHours);
              }
           }else{
           $this->totalHours = 0;
           }
}
//---------------------------------------------------------------------------------------------------------------------
function loadCommissionTotal() {
//echo "commission data test";
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT commision_payout_type, delay FROM sales_pay_options WHERE sales_setup_key = '1' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($commision_payout_type, $delay);
$stmt->fetch();  
$stmt->close(); 

  $html = "<tr></tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Commission Returns</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Commission Amount</font></th>
</tr>
";
//echo "dood $this->userId";
$flag = 'Y';
if($commision_payout_type == 'I'){
    $searchSql = " AND (sale_date_time BETWEEN '$this->dateStart' AND '$this->dateEnd')";
}else{
    $rangeStart = date("Y-m-d H:i:s",mktime(0,0,0,date('m',strtotime($this->dateStart)),date('d',strtotime($this->dateStart))-$delay,date('Y',strtotime($this->dateStart))));
    $rangeEnd = date("Y-m-d H:i:s",mktime(23,59,59,date('m',strtotime($this->dateEnd)),date('d',strtotime($this->dateEnd))-$delay,date('Y',strtotime($this->dateEnd))));
    $searchSql = " AND (sale_date_time BETWEEN '$rangeStart' AND '$rangeEnd')";
    
    $stmt = $dbMain ->prepare("SELECT commission_key, commission_amount, contract_key FROM commission_returns WHERE  user_id='$this->userId' AND monies_recovered != 'Y' ");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($commission_key, $commission, $contract_key);         
             $rowCount2 = $stmt->num_rows;
             
       if($rowCount2 != 0)  {
           
                    while ($stmt->fetch()) {                     
                              $commissionArray2 .="$commission|";
                              $sql = "UPDATE commission_returns SET monies_recovered = ? WHERE commission_key = '$commission_key'";
                                $stmt99 = $dbMain->prepare($sql);
                                $stmt99->bind_param('s', $flag);
                                if(!$stmt99->execute())  {
                                    return($this->errorMessage);
                                    printf("Error: %s.\n", $stmt->error);
                                	exit;
                                   }
                                $stmt99->close();
                                
                                $stmt99 = $dbMain ->prepare("SELECT first_name, last_name FROM contract_info WHERE contract_key = '$contract_key' ");
                                $stmt99->execute();      
                                $stmt99->store_result(); 
                                $stmt99-> bind_result($first_name, $last_name);
                                $stmt99->fetch();  
                                $stmt99->close(); 
                                
                                $first_name = trim($first_name);
                                $first_name = strtolower($first_name);
                                $first_name = ucfirst($first_name);
                                
                                $last_name = trim($last_name);
                                $last_name = strtolower($last_name);
                                $last_name = ucfirst($last_name);
                                
                                $this->comishHtmlArray .= "$contract_key,$name,$commission@";
                                
                                $name = "$first_name $last_name";
                                $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$-$commission</b></font>
                                        </td>  
                                        </tr>\n"; 
                              }

           $commissionArray2 = explode("|", $commissionArray2);
           $this->commissionReturnTotal = array_sum($commissionArray2);
           
           //echo "fu $this->commissionReturnTotal";
           //exit;
           
         }else{
           $this->commissionReturnTotal = 0;
         }
}

$stmt = $dbMain ->prepare("SELECT commission FROM commission_credit WHERE  user_id='$this->userId' $searchSql");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($commission);         
             $rowCount = $stmt->num_rows;
             
       if($rowCount != 0)  {
           
                    while ($stmt->fetch()) {                     
                              $commissionArray .="$commission|";
                              }

           $commissionArray = explode("|", $commissionArray);
           $this->commissionTotal = array_sum($commissionArray);
           
         }else{
           $this->commissionTotal = 'NA';
         }
$this->commissionReturnHtml = $html;
}
//----------------------------------------------------------------------------------------------------
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
$emp_fname = trim($emp_fname);
$emp_lname = trim($emp_lname);

$name = "$emp_fname $emp_mname $emp_lname";

$stmt = $dbMain ->prepare("SELECT instructor_id FROM instructor_info WHERE instructor_name LIKE '%$name%' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($instructor_id);
$stmt->fetch();  
$stmt->close(); 

$counter = 0;
$html = "
<td class=\"black\">
<b>Member Name</b>
</td>
<td  class=\"black\">
<b>Contract Key</b>
</td>
<td class=\"black\">
<b>Training Service</b>
</td>
<td class=\"black\">
<b>Per session Pay</b>
</td>
<td class=\"black\">
<b>Session Date</b>
</td>
<td class=\"black\">
<b>On Clock?</b>
</td>
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

$stmt999 = $dbMain ->prepare("SELECT instructor_id, member_id, session_date, service_key FROM pt_sessions_performed WHERE  instructor_id ='$instructor_id' AND (session_date BETWEEN '$this->dateStart' AND '$this->dateEnd') ORDER BY session_date DESC");
             $stmt999->execute();      
             $stmt999->store_result();      
             $stmt999->bind_result($instructor_id, $member_id, $session_date, $service_key);         
             $rowCount = $stmt999->num_rows;
             
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
                                    <td class=\"black\">
                                    $first_name $last_name
                                    </td>
                                    <td  class=\"black\">
                                    $contract_key
                                    </td>
                                    <td class=\"black\">
                                    $service_type
                                    </td>
                                    <td class=\"black\">
                                    $$session_price
                                    </td>
                                    <td class=\"black\">
                                    $formattedDate
                                    </td>
                                    <td class=\"black\">
                                    $onClock
                                    </td>
                                    </tr>";
                                $this->htmlArray .= "$first_name $last_name,$contract_key,$service_type,$session_price,$formattedDate,$onClock*";
                     
                            if (preg_match('/1/2/',$service_type)){
                                $counter += .5;
                            }else{
                                $counter++;
                            }
                              
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
                            $htmlBeg = "<td>
                                <center><h3>Personal Training</h3></center>
                                </td>
                                <tr>
                                <td>
                                <b>Sessions Performed:</b> &nbsp;$this->sessionsPerformed
                                </td>
                                <td>
                                <b>Sessions Performed on the clock:</b> &nbsp; $this->trainingOnClockHours
                                </td>
                                <td>
                                <b>PT Total:</b> &nbsp; $$this->ptTotal
                                </td>
                                <td>
                                <b>PT Performance Bonus:</b> &nbsp; $$this->extraPerformanceMoney
                                </td>
                                <tr><br><br>";
              
            $this->htmlArray .= "@$this->sessionsPerformed,$this->trainingOnClockHours,$this->ptTotal,$this->extraPerformanceMoney";
           $this->ptHtml = "$htmlBeg$html";
         }else{
           $this->ptTotal = 'NA';
           $this->ptHtml = "";
         }
         
         

$counter2 = 0;
$htmlTA = "
<td class=\"black\">
<b>Member Name</b>
</td>
<td  class=\"black\">
<b>Contract Key</b>
</td>
<td class=\"black\">
<b>Training Service</b>
</td>
<td class=\"black\">
<b>Per session Pay</b>
</td>
<td class=\"black\">
<b>Session Date</b>
</td>
<td class=\"black\">
<b>On Clock?</b>
</td>
</tr>";
//echo "$paid_training_assesments $htmlTA";
//exit;
$this->htmlArrayTA = "";
// echo "test2";


$stmt999 = $dbMain ->prepare("SELECT instructor_id, member_id, session_date, service_key FROM pt_training_assesments_performed WHERE  instructor_id ='$instructor_id' AND (session_date BETWEEN '$this->dateStart' AND '$this->dateEnd') ORDER BY session_date DESC");
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
                            
                            $stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key = '$service_key' ");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($service_type);
                            $stmt->fetch();  
                            $stmt->close(); 
                            
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
                                    <td class=\"black\">
                                    $first_name $last_name
                                    </td>
                                    <td  class=\"black\">
                                    $contract_key
                                    </td>
                                    <td class=\"black\">
                                    $service_type
                                    </td>
                                    <td class=\"black\">
                                    $$payAmount
                                    </td>
                                    <td class=\"black\">
                                    $formattedDate
                                    </td>
                                    <td class=\"black\">
                                    $onClock
                                    </td>
                                    </tr>";
                                $this->htmlArrayTA .= "$first_name $last_name,$contract_key,$service_type,$payAmount,$formattedDate,$onClock*";
                     
                                $counter2++;
                              }
                            
                            $this->ptTotalTA = sprintf("%01.2f", $session_totals2);
                            
                            $this->sessionsPerformedTA = $counter2;
                            $this->assesmentsOFFClockHours = $assesments_off_clock_hours;
                            $htmlBegTA = "<td>
                                <center><h3>Assesments:</h3></center>
                                </td>
                                <tr>
                                <td>
                                <b>Assesments Performed:</b> &nbsp;$this->sessionsPerformedTA
                                </td>
                                <td>
                                <b>Assesmnets Performed off the clock:</b> &nbsp; $this->assesmentsOFFClockHours
                                </td>
                                <td>
                                <b>Assesment Total:</b> &nbsp; $$this->ptTotalTA
                                </td>
                                <tr><br><br>";
              
            $this->htmlArrayTA .= "@$this->sessionsPerformedTA,$this->assesmentsOFFClockHours,$this->ptTotalTA";
           $this->ptHtmlTA = "$htmlBegTA$htmlTA";
         }else{
           $this->ptTotalTA = 0;
           $this->ptHtmlTA = "";
         }





}
//---------------------------------------------------------------------------------------------------------------------
function loadEmployeeInfo() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT user_id, id_card, comp_type, comp_amount, hours_projected  FROM basic_compensation WHERE type_key = '$this->typeKey' AND payment_cycle= '$this->payrollCycle'");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($user_id, $id_card, $comp_type, $comp_amount, $hours_projected); 
         
         while ($stmt->fetch()) {    
                   $this->userId = $user_id;
                   $this->idCard = $id_card;
                   $this->compensationType = $comp_type;
                   $this->compensationAmount = $comp_amount;
                   $this->hoursProjected = $hours_projected;
                   $this->loadContactInfo();
                   
                   switch ($this->compensationType) {
                               case "S":
                               $this->loadHours();
                               $this->loadPtPayroll();
                               $this->hourlyWages = 'NA';
                               $this->OT = 'NA';
                               $this->overtimeTier2 = 'NA';
                               $this->salaryWage = sprintf("%01.2f", $this->compensationAmount);
                               $this->commissionTotal = 'NA';
                               $this->subTotal = sprintf("%01.2f", $this->salaryWage + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout);
                               $this->compTypeDesc = 'Salary';
                               $this->basePay = $this->salaryWage;
                               break;
                               case "H":
                               $this->loadHours();
                               $this->loadPtPayroll();
                               $this->hourlyWages = sprintf("%01.2f", ($this->totalHours-$this->trainingOnClockHours) * $this->compensationAmount);
                               $array = explode('.',$this->weeklyOvertime);
                               $dollars = $array[0] * ($this->compensationAmount * 1.5);
                               $cents = ($array[1]/60) * ($this->compensationAmount * 1.5);                                                                                             //echo "wkot $this->weeklyOvertime a0 $array[0]  a1 $array[1]  comp $this->compensationAmount";
                               $this->OT = sprintf("%01.2f", ($dollars + $cents));
                               $arrayDT = explode('.',$this->overtimeTier2);                               
                               $dollarsDT = $arrayDT[0] * ($this->compensationAmount * 2);
                               $centsDT = ($arrayDT[1]/60) * ($this->compensationAmount * 2);                               
                               $this->overtimeTier2 = sprintf("%01.2f", ($dollarsDT + $centsDT));
                               $this->salaryWage = 'NA';
                               $this->commissionTotal = 'NA';
                               $this->subTotal = sprintf("%01.2f", $this->hourlyWages + $this->OT + $this->overtimeTier2 + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout);
                               $this->compTypeDesc = 'Hourly';
                               $this->basePay = $this->hourlyWages;
                               //echo"<br>$id_card hw $this->hourlyWages  h $this->totalHours th $this->trainingOnClockHours c $this->compensationAmount ot $this->OT + ot2 $this->overtimeTier2 + pt $this->ptTotal + exp $this->extraPerformanceMoney + pta $this->ptTotalTA <br>";
                               break;
                               case "C":
                               $this->loadHours();
                               $this->loadPtPayroll();
                               $this->hourlyWages = 'NA';
                               $this->OT = 'NA';
                               $this->overtimeTier2 = 'NA';
                               $this->salaryWage = 'NA';
                               $this->loadCommissionTotal();
                               $this->subTotal = $this->commissionTotal - $this->commissionReturnTotal + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout;
                               $this->compTypeDesc = 'Commission';
                               $this->basePay = 'NA';
                               break;
                               case "SC":
                               $this->loadHours();
                               $this->loadPtPayroll();
                               $this->hourlyWages = 'NA';
                               $this->OT = 'NA';
                               $this->overtimeTier2 = 'NA';
                               $this->compTypeDesc = 'Salary/Commission';
                               $this->salaryWage = sprintf("%01.2f", $this->compensationAmount + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout);
                               $this->basePay = $this->salaryWage;
                               $this->loadCommissionTotal();
    
                               if($this->commissionTotal == 'NA') {
                                 $this->subTotal = $this->salaryWage;
                                 }else{
                                 $this->subTotal = sprintf("%01.2f", $this->salaryWage + $this->commissionTotal - $this->commissionReturnTotal);
                                 }    
                   
                               break;  
                               case "HC":
                               $this->loadHours();
                               $this->loadPtPayroll();
                               $this->hourlyWages = sprintf("%01.2f", ($this->totalHours-$this->trainingOnClockHours) * $this->compensationAmount);
                                $array = explode('.',$this->weeklyOvertime);
                               $dollars = $array[0] * ($this->compensationAmount * 1.5);
                               $cents = ($array[1]/60) * ($this->compensationAmount * 1.5);
                               $this->OT = sprintf("%01.2f", ($dollars + $cents));
                               $arrayDT = explode('.',$this->overtimeTier2);
                               $dollarsDT = $arrayDT[0] * ($this->compensationAmount * 2);
                               $centsDT = ($arrayDT[1]/60) * ($this->compensationAmount * 2);
                               $this->overtimeTier2 = sprintf("%01.2f", ($dollarsDT + $centsDT));
                               $this->salaryWage = 'NA';
                               $this->compTypeDesc = 'Hourly/Commission';
                               $this->basePay = $this->hourlyWages;
                               $this->loadCommissionTotal();
    
                               if($this->commissionTotal == 'NA') {
                                 $this->subTotal = sprintf("%01.2f", $this->hourlyWages - $this->commissionReturnTotal + $this->OT + $this->overtimeTier2 + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout);
                                 }else{
                                 $this->subTotal = sprintf("%01.2f", $this->hourlyWages - $this->commissionReturnTotal + $this->commissionTotal + $this->OT + $this->overtimeTier2 + $this->ptTotal + $this->extraPerformanceMoney + $this->ptTotalTA+$this->bonusPayout);
                                 }    
    
                               break;    
                             }
                             
                    $this->loadDeductionsAdditions();
                    $this->loadBaseProrateAmount();
                    
                    $paymentDate = 'NA';
                    $this->insertArray="$this->userId|$this->typeKey|$this->payrollCycle|$this->compensationType|$this->hoursProjected|$this->totalHours|$this->addSubTotalArray$this->commissionTotal|$this->basePay|$this->overtimeTier2|$this->OT|$this->baseProrateAmount|$this->totalAmount|$paymentDate|$this->closeDate|$this->consolidate|$this->empFullName|$this->idCard|$this->otDateRange|$this->ptTotal|$this->extraPerformanceMoney|$this->htmlArray|$this->ptTotalTA|$this->htmlArrayTA|$this->sessionsPerformed|$this->trainingOnClockHours|$this->ptTotalTA|$this->sessionsPerformedTA|$this->assesmentsOFFClockHours|$this->commissionReturnTotal|$this->bonusNumSales|$this->bonusTotSales|$this->bonusPayout|$this->salesHtmlArray|$this->comishHtmlArray";
       
                    
                    $this->formatRecords();
                    
      $this->ptTotal = 0;
      $this->extraPerformanceMoney = 0;
      $this->htmlArray = 0;
      $this->ptTotalTA = 0;
      $this->htmlArrayTA = 0;
      $this->sessionsPerformed = 0;
      $this->trainingOnClockHours = 0;
      $this->ptTotalTA = 0;
      $this->sessionsPerformedTA = 0;
      $this->assesmentsOFFClockHours  = 0; 
      $this->commissionReturnTotal = 0;               
              }

}
//----------------------------------------------------------------------------------------------------------------------
function loadContactInfo()    {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id='$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($emp_fname, $emp_mname, $emp_lname); 
$stmt->fetch();

$this->empFname = $emp_fname;
$this->empMname = $emp_mname;
$this->empLname = $emp_lname;
$this->empFullName ="$emp_fname $emp_mname $emp_lname";
              
}
//----------------------------------------------------------------------------------------------------------------------
function loadClubName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id='$this->clubId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($club_name); 
             $stmt->fetch();

 $this->clubName = $club_name;
}
//----------------------------------------------------------------------------------------------------------------------
function loadEmployeeType() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key='$this->typeKey'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($employee_type, $club_id); 
             $stmt->fetch();

             $this->employeeType = $employee_type;
             $this->clubId = $club_id;
             
                $stmt = $dbMain ->prepare("SELECT state FROM club_info WHERE club_id = '$club_id' ");
                $stmt->execute();      
                $stmt->store_result(); 
                $stmt-> bind_result($this->payrollState);
                $stmt->fetch();  
                $stmt->close(); 
             
             $this->loadClubName(); 
             $this->loadEmployeeInfo();
}
//----------------------------------------------------------------------------------------------------------------------
function loadTypeKeys() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT type_key  FROM employee_type WHERE $this->whereSql ORDER BY club_id DESC");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($type_key); 
             
             while ($stmt->fetch()) {                        
                       $this->typeKey = $type_key;
                       $this->loadEmployeeType();                       
                      }

}
//----------------------------------------------------------------------------------------------------------------------
function loadTableHeader()  {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee ID</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Job Description</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Payment Type</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Total Hours</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Payment Total</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">View Details</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Select</font></th>
</tr>\n";    

$this->tableHeader = $table_header;

}
//----------------------------------------------------------------------------------------------------------------------
function loadPayrollRecords() {

 switch ($this->payrollCycle) {
            case "D":
            $this->cycleDesc = 'Daily';
            break;
            case "W":
            $this->cycleDesc = 'Weekly';
            break;
            case "B";
            $this->cycleDesc = 'Bi-Monthly';
            break;
            case "M";
            $this->cycleDesc = 'Bi-Monthly';
            break;
            }



     if($this->clubLocation == 0) {
       $this->whereSql = "club_id != '' ";
       $this->loadTypeKeys();
       }else{
       $this->whereSql = "club_id = '$this->clubLocation' ";
       $this->loadTypeKeys();
       }

 $this->loadTableHeader();


}
//---------------------------------------------------------------------------------------------------------------------
function getRecordList() {
          return($this->recordList);
          }
function getTableHeader() {
          return($this->tableHeader);
          }
function getCycleDescription() {
          return($this->cycleDesc);
          }
function getDateStart() {
          return($this->dateStart);
          }
function getDateEnd() {
          return($this->dateEnd);
          }


}
?>