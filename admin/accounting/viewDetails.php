<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class viewDetails {

private $insertArray = null;
private $details = null;
private $userId = null;
private $typeKey = null;
private $paymentCycle = null;
private $compType = null;
private $hoursProjected = null;
private $totalHours = null;
private $addSubOne = null;
private $addSubDescOne = null;
private $addSubAmountOne = null;
private $addSubTwo = null;
private $addSubDescTwo = null;
private $addSubAmountTwo = null;
private $addSubThree = null;
private $addSubDescThree = null;
private $addSubAmountThree = null;
private $addSubFour = null;
private $addSubDescFour = null;
private $addSubAmountFour = null;
private $commissionAmount = null;
private $basePaymentAmount = null;
private $OT = null;
private $overtimeTier2 = null;
private $baseProrateAmount = null;
private $totalPaymentAmount = null;
private $paymentDate = null;
private $closeDate = null;
private $consolidate = null;
private $employeeName = null;
private $employeeId = null;
private $hourlyWages = null;
private $salary = null;
private $subTotal = null;
private $counter = 1;
private $addSubRows = null;

private $businessName = null;
private $mailingStreet = null;
private $mailingCity = null;
private $mailingState = null;
private $mailingZip = null;
private $businessPhone = null;

function setInsertArray($insertArray) {
           $this->insertArray = $insertArray;
           }
function setHoursList($hours_list) {
              $this->hoursList = $hours_list;
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
//--------------------------------------------------------------------

//--------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_name, mailing_street, mailing_city, mailing_state, mailing_zip, business_phone FROM business_info WHERE bus_id='1'");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($business_name, $mailing_street, $mailing_city, $mailing_state, $mailing_zip, $business_phone);
$stmt->fetch();

$this->businessName = $business_name;
$this->mailingStreet = $mailing_street;
$this->mailingCity = $mailing_city;
$this->mailingState = $mailing_state;
$this->mailingZip = $mailing_zip;
$this->businessPhone = $business_phone;

}
//--------------------------------------------------------------------
function createDetailsHtml() {
$cArray = explode('@',$this->commissionReturnHtml);
   
    
 $htmlCoommisgReturn = "<tr></tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Commission Returns</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Commission Amount</font></th>
</tr>
";

foreach($cArray as $tempArray2){
    $tArray = explode(',',$tempArray2);
    $contract_key = $tArray[0];
    $name = $tArray[1];
    $commission = $tArray[2];
    $commission = trim($commission);
    if ($commission != ''){
        $htmlCoommisgReturn .= "<tr>
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
    
}

    
    
$sArray = explode('@',$this->salesHtml); 
$sArray3 = explode(',',$sArray[0]);
$sArray2 = explode('~',$sArray[1]); 

$this->bonusTotSales = $sArray3[0];
$this->bonusNumSales = $sArray3[1];
$this->bonusPayout = $sArray3[2];

//var_dump($sArray3);

$this->salesHtmlNew = "<tr></tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Sales</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales: $$this->bonusTotSales</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales: $this->bonusNumSales</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Bonus Payout: $$this->bonusPayout</font></th>
</tr>
"; 
    
$this->salesHtmlNew .= "<
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Sales Listing</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Commission Amount</font></th>
</tr>";
//var_dump($sArray2);
foreach($sArray2 as $salesArray){
    $tempArray = explode(',',$salesArray);
    $name = $tempArray[0];
    $price = $tempArray[1];
    $contract_key = $tempArray[2];
    $commission_amount = $tempArray[3];
    
    $name = trim($name);
    if ($name != ''){
    
    $this->salesHtmlNew .= "<tr>
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
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$commission_amount</b></font>
                                        </td>
                                        </tr>\n";
    }
}


    
$totalsArray = explode('@',$this->htmlArray);
    $totalsArray2 = explode(',',$totalsArray[1]);
    $this->sessionsPerformed = $totalsArray2[0];
    if($this->sessionsPerformed != 0){
       $this->trainingOnClockHours = $totalsArray2[1];
    $this->ptTotal = $totalsArray2[2];
    $this->extraPerformanceMoney = $totalsArray2[3];
    
    $htmlBeg = "<tr></tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Personal Training</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sessions Performed: $this->sessionsPerformed</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sessions Performed on the clock: $this->trainingOnClockHours</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">PT Total: $$this->ptTotal</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">PT Performance Bonus: $$this->extraPerformanceMoney</font></th>
</tr>
";
    
    
    
 

$html = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Sessions Report</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Per session Pay</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Session Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">On Clock?</font></th>
</tr>";
    $ptListArray = explode('*',$totalsArray[0]);
    foreach($ptListArray as $ptArray){
        $ptListArray2 = explode(',',$ptArray);
        $name = $ptListArray2[0];
        $contract_key = $ptListArray2[1];
        $service_type = $ptListArray2[2];
        $session_price = $ptListArray2[3];
        $formattedDate = $ptListArray2[4];
        $onClock = $ptListArray2[5];
        $name = trim($name);
        if($name != ''){
            
            $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$name</b></font>
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
            
            
        
        }
        
    }
$html = "$htmlBeg$html"; 
    }else{
        $html = "";
    }
    
        $TAtotalsArray = explode('@',$this->htmlArrayTA);
    $TAtotalsArray2 = explode(',',$TAtotalsArray[1]);
    $this->sessionsPerformedTA = $TAtotalsArray2[0];
    if($this->sessionsPerformedTA != 0){
       $this->assesmentsOffClockHours = $TAtotalsArray2[1];
    $this->ptTotalTA = $TAtotalsArray2[2];
    
    $htmlBegTA = "
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Assesments</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Assesments Performed: $this->sessionsPerformedTA</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Assesments Performed off the clock: $this->assesmentsOffClockHours</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Assesment Total: $$this->ptTotalTA</font></th>
</tr>";

 

$htmlTA = "
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Assesment List</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Per session Pay</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Session Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">On Clock?</font></th>
</tr>";
    $ptListArrayTA = explode('*',$TAtotalsArray[0]);
    foreach($ptListArrayTA as $ptArrayTA){
        $TAptListArray2 = explode(',',$ptArrayTA);
        $name = $TAptListArray2[0];
        $contract_key = $TAptListArray2[1];
        $service_type = $TAptListArray2[2];
        $session_price = $TAptListArray2[3];
        $formattedDate = $TAptListArray2[4];
        $onClock = $TAptListArray2[5];
        $name = trim($name);
        if($name != ''){
            
            $htmlTA .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$name</b></font>
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
            
       
        }
    }
$htmlTA = "$htmlBegTA$htmlTA"; 
    }else{
        $htmlTA = "";
    }
    
if($this->sessionsPerformedTA == 0 OR $this->sessionsPerformedTA = ''){
    $aHtml = '';
}else{
 
$aHtml = "<tr>
<td class=\"grey1\">
Assesment Total
</td>
<td class=\"grey1 pad\">
$$this->ptTotalTA
</td>
</tr>";

}

if($this->sessionsPerformed == 0 OR $this->sessionsPerformed = ''){
    $pHtml = '';
}else{

$pHtml = "
<tr>
<td class=\"grey1\">
Pt Total
</td>
<td class=\"grey1 pad\">
$$this->ptTotal
</td>
</tr>
<tr>
<td class=\"grey1\">
PT Performance Bonus
</td>
<td class=\"grey1 pad\">
$$this->extraPerformanceMoney
</td>
</tr>";
}    
    
if($this->bonusPayout == 0){
    $sHtml = '';
}else{

$sHtml = "
<tr>
<td class=\"grey1\">
Sales Total
</td>
<td class=\"grey1 pad\">
$$this->bonusTotSales
</td>
</tr>
<tr>
<td class=\"grey1\">
Number of Sales
</td>
<td class=\"grey1 pad\">
$this->bonusNumSales
</td>
</tr>
<tr>
<td class=\"grey1\">
Sales Performance Bonus
</td>
<td class=\"grey1 pad\">
$$this->bonusPayout
</td>
</tr>";
}      
$this->subTotal = sprintf("%01.2f", $this->subTotal + $this->ptTotalTA + $this->ptTotal + $this->extraPerformanceMoney - $this->commissionReturnTotal + $this->bonusPayout);
$indiPrintTemplate = <<<INDIPRINTTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/payrollPrintIndi.css">
<script type="text/javascript" src="../scripts/printIndiRecord.js"></script>

	<title>Payroll Details</title>
</head>
<body>


<div id="logo" class="logo">
<a href="#" onClick="printIndiRecord();return false;"><img  src="../images/contract_logo.png" width="139" height="54" border="0"></a>
</div>

<div id="businessInfo" class="businessInfo">
<br>
$this->businessName
<br>
$this->mailingStreet
<br>
$this->mailingCity, $this->mailingState $this->mailingZip
<br>
$this->businessPhone
</div>



<div id="title">
EMPLOYEE DEDUCTIONS AND ADDITIONS FORM
<br>
$this->paymentDate
</div>

<div id="nameDate">
$this->employeeName
<br>
<span class="grey1">$this->employeeId</span>
</div>

<div id="paymentInfoTitle">
I. Payment Information
</div>

<div id="paymentInfoContent">
<table>
<tr>
<td class="grey1">
Commission
</td>
<td class="grey1 pad">
$$this->commissionAmount
</td>
</tr>

<tr>
<td class="grey1">
Commission Returned
</td>
<td class="grey1 pad">
$$this->commissionReturnTotal
</td>
</tr>

<tr>
<td class="grey1">
Salary
</td>
<td class="grey1 pad">
$$this->salary
</td>
</tr>

<tr>
<td class="grey1">
Hourly Wages
</td>
<td class="grey1 pad">
$$this->hourlyWages
</td>
</tr>

<tr>
<td class="grey1">
Hours Projected
</td>
<td class="grey1 pad">
$this->hoursProjected
</td>
</tr>

$aHtml


$pHtml

$sHtml

<tr>
<td class="grey1">
Overtime Hours 1.5 $this->otDateRange 
</td>
<td class="grey1 pad">
$this->OT
</td>
</tr>

<tr>
<td class="grey1">
Overtime Hours Double Time $this->otDateRange
</td>
<td class="grey1 pad">
$this->overtimeTier2
</td>
</tr>

<tr>
<td class="grey1">
Total Hours
</td>
<td class="grey1 pad">
$this->totalHours
</td>
</tr>

<tr>
<td class="grey1">
Subtotal
</td>
<td class="grey1 pad">
$$this->subTotal
</td>
</tr>

<tr>
<td class="grey1 padTwo">
Prorate Estimate
</td>
<td class="grey1 pad padTwo">
$this->baseProrateAmount
</td>
</tr>
</table>
</div>

<div id="deductAddTitle">
II. Deductions and Additions
</div>


<div id="deductAddContent">
<table width="100%">
<tr>
<td>

<table align="left" cellpadding="0" cellspacing="0" class="tProps"/>
<tr>
<th>
&nbsp;&nbsp;&nbsp;&nbsp;
</th>
<th class="tA padBottom">
Description
</th>
<th class="tA padBottom">
Amount
</th>
<th class="tA padBottom">
Deduction or Addition
</th>
<th class="tA padBottom">
Recursive
</th>
</tr>

$this->addSubRows
</table>

</td>
</tr>
</table>
</div>

<div id="adjustment">
<span class="grey2">Adjusted Amount &nbsp; $this->totalPaymentAmount</span>
<tr>$this->hoursList</tr>

<tr>$this->salesHtmlNew</tr>
<tr>$htmlCoommisgReturn</tr>



<tr>$html </tr>



<tr>$htmlTA </tr>
</div>





<div id="botPad">
</div>


</body>
</html>
INDIPRINTTEMPLATE;

$_SESSION['indi_print_form'] = $indiPrintTemplate;

$this->details = "1";

}
//--------------------------------------------------------------------
function filterDetails() {

$this->paymentDate = date("Y-m-d H:m:s");

if($this->commissionAmount == 'NA') {
   $this->commissionAmount = '0.00';
   }
   
$dbMain = $this->dbconnect();

$tempTable = "CREATE TEMPORARY TABLE IF NOT EXISTS `details` (
          `user_id` INT(20) NOT NULL,
          `type_key` int(20) NOT NULL,
          `payment_cycle` ENUM('D','W','B','M') NOT NULL,
          `comp_type` ENUM('S','H','C','SC','HC') NOT NULL,
          `hours_projected`  INT(3) NOT NULL,
          `total_hours` INT(3) NOT NULL,
          `add_sub_one` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_one` CHAR(30) NULL,
          `add_sub_amount_one` DECIMAL(10,2) NULL,
          `add_sub_two` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_two` CHAR(30) NULL,
          `add_sub_amount_two` DECIMAL(10,2) NULL,
          `add_sub_three` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_three` CHAR(30) NULL,
          `add_sub_amount_three` DECIMAL(10,2) NULL,
          `add_sub_four` ENUM('E','A','S') NOT NULL,
          `add_sub_desc_four` CHAR(30) NULL,
          `add_sub_amount_four` DECIMAL(10,2) NULL,
          `commission_amount` DECIMAL(10,2) NULL,
          `base_payment_amount`  DECIMAL(10,2) NOT NULL,
          `ot_hours_tier_2`  INT(3) NOT NULL,
          `overtime`  INT(3) NOT NULL,
          `base_prorate_amount` DECIMAL(10,2) NOT NULL,
          `total_payment_amount` DECIMAL(10,2) NOT NULL,
          `payment_date` DATETIME NOT NULL,
          `close_date` DATE NOT NULL
          )";

   
$dbMain-> query($tempTable);
$dbMain-> query("INSERT INTO details (user_id, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two, add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three, add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, ot_hours_tier_2, overtime,  base_prorate_amount, total_payment_amount, payment_date, close_date)VALUES ('$this->userId', '$this->typeKey', '$this->paymentCycle', '$this->compType', '$this->hoursProjected', '$this->totalHours', '$this->addSubOne', '$this->addSubDescOne', '$this->addSubAmountOne', '$this->addSubTwo', '$this->addSubDescTwo', '$this->addSubAmountTwo', '$this->addSubThree', '$this->addSubDescThree', '$this->addSubAmountThree', '$this->addSubFour', '$this->addSubDescFour', '$this->addSubAmountFour', '$this->commissionAmount', '$this->basePaymentAmount', '$this->overtimeTier2', '$this->OT', '$this->baseProrateAmount', '$this->totalPaymentAmount', '$this->paymentDate', '$this->closeDate')");


$stmt = $dbMain ->prepare("SELECT add_sub_one, add_sub_desc_one, add_sub_amount_one  FROM details WHERE add_sub_one != 'E'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($add_sub_one, $add_sub_desc_one, $add_sub_amount_one); 
             $stmt->fetch();
             $rowCount1 = $stmt->num_rows;
             
       if($rowCount1 != 0)  {            
           switch ($add_sub_one) {
                  case "S":
                   $deductAdd = 'Deduction';  
                   $recursive = 'Yes';
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                   $recursive = 'Yes';
                  break;                      
             }
                $this->addSubRows .= "
                <tr>
                <td class=\"tA tBord\">
                    $this->counter
                </td>
                <td class=\"tA tBord\">
                    $add_sub_desc_one
                </td>
                <td class=\"tA tBord\">
                    $add_sub_amount_one
                </td>
                <td class=\"tA tBord\">
                  $deductAdd
                </td>
                <td class=\"tA tBord\">
                  $recursive
                </td>
                </tr>";
           
           $this->counter++;
         }
$stmt2 = $dbMain ->prepare("SELECT add_sub_two, add_sub_desc_two, add_sub_amount_two  FROM details WHERE add_sub_two != 'E'");
             $stmt2->execute();      
             $stmt2->store_result();      
             $stmt2->bind_result($add_sub_two, $add_sub_desc_two, $add_sub_amount_two); 
             $stmt2->fetch();
             $rowCount2 = $stmt2->num_rows;
             
       if($rowCount2 != 0)  {            
           switch ($add_sub_two) {
                  case "S":
                   $deductAdd = 'Deduction';  
                   $recursive = 'Yes';
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                   $recursive = 'Yes';
                  break;                      
             }
                $this->addSubRows .= "
                <tr>
                <td class=\"tA tBord\">
                    $this->counter
                </td>
                <td class=\"tA tBord\">
                    $add_sub_desc_two
                </td>
                <td class=\"tA tBord\">
                    $add_sub_amount_two
                </td>
                <td class=\"tA tBord\">
                  $deductAdd
                </td>
                <td class=\"tA tBord\">
                  $recursive
                </td>
                </tr>";
           
           $this->counter++;
         }         
$stmt3 = $dbMain ->prepare("SELECT add_sub_three, add_sub_desc_three, add_sub_amount_three  FROM details WHERE add_sub_three != 'E'");
             $stmt3->execute();      
             $stmt3->store_result();      
             $stmt3->bind_result($add_sub_three, $add_sub_desc_three, $add_sub_amount_three); 
             $stmt3->fetch();
             $rowCount3 = $stmt3->num_rows;
             
       if($rowCount3 != 0)  {            
           switch ($add_sub_three) {
                  case "S":
                   $deductAdd = 'Deduction';  
                   $recursive = 'Yes';
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                   $recursive = 'Yes';
                  break;                      
             }
                $this->addSubRows .= "
                <tr>
                <td class=\"tA tBord\">
                    $this->counter
                </td>
                <td class=\"tA tBord\">
                    $add_sub_desc_three
                </td>
                <td class=\"tA tBord\">
                    $add_sub_amount_three
                </td>
                <td class=\"tA tBord\">
                  $deductAdd
                </td>
                <td class=\"tA tBord\">
                  $recursive
                </td>
                </tr>";
           
           $this->counter++;
         }         
$stmt4 = $dbMain ->prepare("SELECT add_sub_four, add_sub_desc_four, add_sub_amount_four  FROM details WHERE add_sub_four != 'E'");
             $stmt4->execute();      
             $stmt4->store_result();      
             $stmt4->bind_result($add_sub_four, $add_sub_desc_four, $add_sub_amount_four); 
             $stmt4->fetch();
             $rowCount4 = $stmt4->num_rows;
             
       if($rowCount4 != 0)  {            
           switch ($add_sub_four) {
                  case "S":
                   $deductAdd = 'Deduction';  
                   $recursive = 'Yes';
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                   $recursive = 'Yes';
                  break;                      
             }
                $this->addSubRows .= "
                <tr>
                <td class=\"tA tBord\">
                    $this->counter
                </td>
                <td class=\"tA tBord\">
                    $add_sub_desc_four
                </td>
                <td class=\"tA tBord\">
                    $add_sub_amount_four
                </td>
                <td class=\"tA tBord\">
                  $deductAdd
                </td>
                <td class=\"tA tBord\">
                  $recursive
                </td>
                </tr>";
         }              
         
         if($rowCount1 == 0 && $rowCount2 == 0 && $rowCount3 == 0 && $rowCount4 == 0) {
                $this->addSubRows = "
                <tr>
                <td class=\"tA tBord\">
                  0
                </td>
                <td class=\"tA tBord\">
                    NA
                </td>
                <td class=\"tA tBord\">
                    NA
                </td>
                <td class=\"tA tBord\">
                    NA
                </td>
                <td class=\"tA tBord\">
                  NA
                </td>
                </tr>";
                }
         
               
         
         switch ($this->compType) {
                 case "H":
                   $this->hourlyWages = $this->basePaymentAmount;
                   $this->salary = 'NA';
                 break;
                 case "S":
                   $this->hourlyWages = 'NA';
                   $this->salary = $this->basePaymentAmount;
                 break;
                 case "SC":
                   $this->hourlyWages = 'NA';
                   $this->salary = $this->basePaymentAmount;
                 break;
                 case "HC":
                   $this->hourlyWages = $this->basePaymentAmount; 
                   $this->salary = 'NA';
                 break;
                 }
  
  $this->subTotal = sprintf("%01.2f", $this->basePaymentAmount + $this->commissionAmount + $this->overtimeTier2 + $this->OT);
           
  $this->paymentDate   = date("F j, Y", strtotime($this->paymentDate));
  $this->loadBusinessInfo();               
  $this->createDetailsHtml();       
         

}
//----------------------------------------------------------------------------------------------------
function loadLastPayrollCloseDate() {
//echo "<br>********************************************************$this->typeKey   $this->userId";
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(close_date)  FROM payroll_settled WHERE type_key = '$this->typeKey' AND user_id = '$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($close_date); 
$stmt->fetch();
$stmt->close();
//echo "<br>********************************************************$close_date";
$this->lastParollCloseDate = $close_date;

}
//========================================================================================================================
function loadHours() {
    
/*$this->loadLastPayrollCloseDate();    

if($this->lastParollCloseDate == "") {
   $this->lastParollCloseDate = '000-00-00 00:00:00';
   }*/
 $dbMain = $this->dbconnect();  
$stmt = $dbMain ->prepare("SELECT id_card  FROM basic_compensation WHERE type_key = '$this->typeKey' AND user_id = '$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($id_card); 
$stmt->fetch();   
$stmt->close();    
  /*if($this->paymentCycle == "W"){
    $this->cycleDivisor = .5;
  } else if ($this->paymentCycle == "B"){
     $this->cycleDivisor = 1;
  } else if ($this->paymentCycle == "M"){
     $this->cycleDivisor = 2;
  }*/
  $this->hoursList .= "
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Timeclock Report</b></font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hours List</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clock in</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clock out</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hours Worked</font></th>
</tr>";
  
  
  
  /*$this->hoursList .= "<tr class=\"Hours\">
                      <td class=\"grey1 tile6\">Hours List&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clock in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clock out&nbsp;&nbsp;&nbsp;Hours Worked<br></td>
                      </tr>";*/
   //echo"<br><br>lst closed dstae  $this->lastParollCloseDate";

$stmt = $dbMain ->prepare("SELECT timeclock_key, clock_in, clock_out FROM timeclock WHERE  id_card='$id_card' AND (clock_out BETWEEN '$this->dateStart' AND '$this->dateEnd') ORDER BY clock_in DESC");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($timeclock_key, $clock_in, $clock_out);         
             $rowCount = $stmt->num_rows;
             
       if($rowCount != 0)  {
           
                    while ($stmt->fetch()) { 
                        
                        $start = strtotime($clock_in);
                        $end = strtotime($clock_out);
                        $diff = $end-$start;
                        $diff = $diff/60/60;
                        //$diff = date('H:i:s',strtotime($diff));
                        $diff =  sprintf("%01.2f", $diff);
                        $hoursDate = date('F j Y',strtotime($clock_in));
                        $in = date('H:i:s',strtotime($clock_in));
                        $out = date('H:i:s',strtotime($clock_out));
                        
                        
                        $this->hoursList .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$hoursDate</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$in</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$out</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$diff</b></font>
                                        </td>
                                        \n";
                        
                        /*$this->hoursList .= "<tr class=\"payInfo2\">
                            <td class=\"grey1 tile6\">$hoursDate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$diff<br></td>
                            </tr>";*/
                                            
                        //$this->hoursList2 .= "$hoursDate,$diff|";
                          
                       
                        }
                        
                     }
           
}
//--------------------------------------------------------------------
function formatDetails() {
    

$insertArray = explode("|", $this->insertArray);

$this->userId = $insertArray[0];
$this->typeKey = $insertArray[1];
$this->paymentCycle = $insertArray[2];
$this->compType = $insertArray[3];
$this->hoursProjected = $insertArray[4];
$this->totalHours = $insertArray[5];
$this->addSubOne = $insertArray[6];
$this->addSubDescOne = $insertArray[7];
$this->addSubAmountOne = $insertArray[8];
$this->addSubTwo = $insertArray[10];
$this->addSubDescTwo = $insertArray[11];
$this->addSubAmountTwo = $insertArray[12];
$this->addSubThree = $insertArray[14];
$this->addSubDescThree = $insertArray[15];
$this->addSubAmountThree = $insertArray[16];
$this->addSubFour = $insertArray[18];
$this->addSubDescFour = $insertArray[19];
$this->addSubAmountFour = $insertArray[20];
$this->commissionAmount = $insertArray[22];
$this->basePaymentAmount = $insertArray[23];
$this->overtimeTier2 = $insertArray[24];
$this->OT = $insertArray[25];
$this->baseProrateAmount = $insertArray[26];
$this->totalPaymentAmount = $insertArray[27];
$this->paymentDate = $insertArray[28];
$this->closeDate = $insertArray[29];
$this->consolidate = $insertArray[30];
$this->employeeName = $insertArray[31];
$this->employeeId = $insertArray[32];
$this->otDateRange = $insertArray[33];
$this->ptTotal = $insertArray[34];
$this->performancePt = $insertArray[35];
$this->htmlArray = $insertArray[36];
$this->ptTotalTA = $insertArray[37];
$this->htmlArrayTA = $insertArray[38];
$this->sessionsPerformed = $insertRecordArray[39];
$this->trainingOnClockHours = $insertRecordArray[40];
$this->ptTotalTA = $insertRecordArray[41];
$this->sessionsPerformedTA = $insertRecordArray[42];
$this->assesmentsOFFClockHours = $insertRecordArray[43];
$this->commissionReturnTotal = $insertArray[44];
$this->bonusNumSales = $insertArray[45];
$this->bonusTotSales = $insertArray[46];
$this->bonusPayout = $insertArray[47];
$this->salesHtml = $insertArray[48];
$this->commissionReturnHtml = $insertArray[49];

$this->loadHours();
$this->filterDetails();


/*
$this->userId 
$this->typeKey
$this->paymentCycle
$this->compType
$this->hoursProjected
$this->addSubOne
$this->addSubDescOne
$this->addSubAmountOne
$this->addSubTwo
$this->addSubDescTwo
$this->addSubAmountTwo
$this->addSubThree
$this->addSubDescThree
$this->addSubAmountThree
$this->addSubFour
$this->addSubDescFour
$this->addSubAmountFour
$this->commissionAmount
$this->basePaymentAmount
$this->baseProrateAmount
$this->totalPaymentAmount
$this->paymentDate
$this->closeDate
$this->consolidate
*/
//user_id   INT(20) NOT NULL,
//type_key INT(20) NOT NULL,
//payment_cycle ENUM("D","W","B","M") NOT NULL,
//comp_type ENUM("S","H","C","SC","HC") NOT NULL,
//hours_projected  INT(3) NOT NULL,
//total_hours INT(3) NOT NULL,
//add_sub_one ENUM("E","A","S") NOT NULL,
//add_sub_desc_one CHAR(30) NULL,
//add_sub_amount_one DECIMAL(10,2) NULL,
//add_sub_two ENUM("E","A","S") NOT NULL,
//add_sub_desc_two CHAR(30) NULL,
//add_sub_amount_two DECIMAL(10,2) NULL,
//add_sub_three ENUM("E","A","S") NOT NULL,
//add_sub_desc_three CHAR(30) NULL,
//add_sub_amount_three DECIMAL(10,2) NULL,
//add_sub_four ENUM("E","A","S") NOT NULL,
//add_sub_desc_four CHAR(30) NULL,
//add_sub_amount_four DECIMAL(10,2) NULL,
//commission_amount DECIMAL(10,2) NULL,
//base_payment_amount  DECIMAL(10,2) NOT NULL, 
//base_prorate_amount DECIMAL(10,2) NOT NULL,
//total_payment_amount DECIMAL(10,2) NOT NULL,
//payment_date DATETIME NOT NULL,
//close_date DATE NOT NULL,
//consolidate ENUM('Y','N') NOT NULL


}
//------------------------------------------------------------------
function getDetails() {
        return($this->details);
        }

}
//$hours_list = $_REQUEST['hours_list'];
$insert_array = $_REQUEST['insert_array'];
$date_start = $_REQUEST['date_start'];
$date_end = $_REQUEST['date_end'];
//#########################################
//echo "d $date_start d $date_end";
//exit;
$loadDetails = new viewDetails();
$loadDetails-> setInsertArray($insert_array);
$loadDetails-> setDateStart($date_start);
$loadDetails-> setDateEnd($date_end);
$loadDetails-> formatDetails();
$detailsHtml = $loadDetails-> getDetails();

echo"$detailsHtml";





?>