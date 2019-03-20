<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class viewIndiDetails {

private $detailsArray = null;
private $details = null;

private $userId = null;
private $typeKey = null;
private $addSubOne = null;
private $addSubAmountOne = null;
private $addSubDescOne = null;
private $recursiveOne = null;
private $addSubTwo = null;
private $addSubAmountTwo = null;
private $addSubDescTwo = null;
private $recursiveTwo = null;
private $addSubThree = null;
private $addSubAmountThree = null;
private $addSubDescThree = null;
private $recursiveThree = null;
private $addSubFour = null;
private $addSubAmountFour = null;
private $addSubDescFour = null;
private $recursiveFour = null;
private $commissionAmount = null;
private $salary = null;
private $hourlyWages = null;
private $hoursProjected = null;
private $totalHours = null;
private $subTotal = null;
private $indiPrintTemplate = null;
private $printPageHeader = null;
private $printPageFooter = null;
private $imageName = null;


private $basePaymentAmount = null;
private $baseProrateAmount = null;
private $totalPaymentAmount = null;
private $paymentDate = null;
private $closeDate = null;
private $employeeName = null;
private $employeeId = null;

private $counter = 1;
private $addSubRows = null;
private $detailsCount = 1;

private $businessName = null;
private $mailingStreet = null;
private $mailingCity = null;
private $mailingState = null;
private $mailingZip = null;
private $businessPhone = null;

function setDetailsArray($detailsArray) {
           $this->detailsArray = $detailsArray;
           }

function setImageName($imageName) {
              $this->imageName = $imageName;
              }
function setHoursList($hours_list) {
              $this->hoursList = $hours_list;
              }
function setPtHtml($pt_html){
    $this->ptHtml = $pt_html;
}
function setPtHtmlTA($pt_html_ta){
    $this->ptHtmlTA = $pt_html_ta;
}
function setOt1($ot1){
    $this->ot1 = str_replace('|','',$ot1);
}
function setOt2($ot2){
    $this->ot2 = str_replace('|','',$ot2);
}
function setCommissReturns($commissReturns){
    $this->commissshReturns = $commissReturns;
}
function setSalesHtml($salesHtml){
    $this->salesHtml = $salesHtml;
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
   $cArray = explode('@',$this->commissshReturns);
   
    
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
        $totCommissh += $commission;
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
    $totCommissh =  sprintf("%01.2f", $totCommissh);
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
    
$this->salesHtmlNew .= "<tr>
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
   
$aHtml =" <tr>
<td class=\"grey1\">
Assesment Total:
</td>
<td class=\"grey1 pad\">
$$this->ptTotalTA
</td>
</tr>";
}

if($this->sessionsPerformed == 0 OR $this->sessionsPerformed = ''){
    $pHtml = '';
}else{
   
$pHtml =" <tr>
<td class=\"grey1\">
Pt Total:
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
    
$this->indiPrintTemplate .= <<<INDIPRINTTEMPLATE
<div id="house$this->detailsCount">
<div id="logo" class="logo">
<a href="#" onClick="printIndiRecord();return false;"><img  src="../images/$this->imageName" width="139" height="54" border="0"></a>
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
$$totCommissh
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
Overtime
</td>
<td class="grey1 pad">
$$this->ot1
</td>
</tr>

<tr>
<td class="grey1">
Double Time
</td>
<td class="grey1 pad">
$$this->ot2
</td>
</tr>

$sHtml
$aHtml


$pHtml

<tr>
<td class="grey1">
Hours Projected
</td>
<td class="grey1 pad">
$this->hoursProjected
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
NA
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
</div>


<div id="adjustment">
<tr>$this->hoursListHtml </tr>
$this->salesHtmlNew
$htmlCoommisgReturn
$html
$htmlTA
</div>

<div id="botPad">
</div>
</div>
INDIPRINTTEMPLATE;


$this->totalPaymentAmount = null;
$this->addSubRows = null;
$this->counter = 1;



}
//--------------------------------------------------------------------
function filterDetails() {

$this->paymentDate = date("Y-m-d H:m:s");

//if($this->commissionAmount == 'NA') {
//   $this->commissionAmount = '0.00';
 //  }
   
$dbMain = $this->dbconnect();

$tempTable = "CREATE TEMPORARY TABLE IF NOT EXISTS `indi_details` (
          `user_id` INT(20) NOT NULL,
          `type_key` int(20) NOT NULL,
          `add_sub_one` ENUM('E','A','S') NOT NULL,
          `add_sub_amount_one` DECIMAL(10,2) NULL,
          `add_sub_desc_one` CHAR(30) NULL,
          `recursive_one` ENUM('Y','N') NOT NULL,
          `add_sub_two` ENUM('E','A','S') NOT NULL,
          `add_sub_amount_two` DECIMAL(10,2) NULL,
          `add_sub_desc_two` CHAR(30) NULL,
          `recursive_two` ENUM('Y','N') NOT NULL,
          `add_sub_three` ENUM('E','A','S') NOT NULL,
          `add_sub_amount_three` DECIMAL(10,2) NULL,
          `add_sub_desc_three` CHAR(30) NULL,
          `recursive_three` ENUM('Y','N') NOT NULL,
          `add_sub_four` ENUM('E','A','S') NOT NULL,
          `add_sub_amount_four` DECIMAL(10,2) NULL,
          `add_sub_desc_four` CHAR(30) NULL,
          `recursive_four` ENUM('Y','N') NOT NULL
          )";

   
$dbMain-> query($tempTable);
$dbMain-> query("INSERT INTO indi_details (user_id, type_key, add_sub_one, add_sub_amount_one, add_sub_desc_one, recursive_one,  add_sub_two, add_sub_amount_two, add_sub_desc_two, recursive_two, add_sub_three,  add_sub_amount_three, add_sub_desc_three, recursive_three, add_sub_four,  add_sub_amount_four, add_sub_desc_four, recursive_four)VALUES ('$this->userId', '$this->typeKey', '$this->addSubOne', '$this->addSubAmountOne', '$this->addSubDescOne', '$this->recursiveOne', '$this->addSubTwo', '$this->addSubAmountTwo', '$this->addSubDescTwo', '$this->recursiveTwo', '$this->addSubThree',  '$this->addSubAmountThree', '$this->addSubDescThree', '$this->recursiveThree', '$this->addSubFour',  '$this->addSubAmountFour', '$this->addSubDescFour', '$this->recursiveFour')");



$stmt = $dbMain ->prepare("SELECT add_sub_one,  add_sub_amount_one, add_sub_desc_one, recursive_one  FROM indi_details WHERE add_sub_one != 'E'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($add_sub_one, $add_sub_amount_one, $add_sub_desc_one, $recursive_one); 
             $stmt->fetch();
             $rowCount1 = $stmt->num_rows;
             
       if($rowCount1 != 0)  {            
           switch ($add_sub_one) {
                  case "S":
                   $deductAdd = 'Deduction';  
                   $this->totalPaymentAmount = $this->subTotal - $add_sub_amount_one;
                  break;    
                  case "A":
                   $deductAdd = 'Addition';
                   $this->totalPaymentAmount = $this->subTotal + $add_sub_amount_one;
                  break;                      
                }
                
           switch ($recursive_one) {
                  case "Y":
                   $recursive = 'Yes';
                  break;    
                  case "N":
                   $recursive = 'No';
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
$stmt2 = $dbMain ->prepare("SELECT add_sub_two,  add_sub_amount_two, add_sub_desc_two, recursive_two  FROM indi_details WHERE add_sub_two != 'E'");
             $stmt2->execute();      
             $stmt2->store_result();      
             $stmt2->bind_result($add_sub_two, $add_sub_amount_two, $add_sub_desc_two, $recursive_two); 
             $stmt2->fetch();
             $rowCount2 = $stmt2->num_rows;
             
       if($rowCount2 != 0)  {            
           switch ($add_sub_two) {
                  case "S":
                   $deductAdd = 'Deduction';
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal - $add_sub_amount_two;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount - $add_sub_amount_two;
                          }                          
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal + $add_sub_amount_two;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount + $add_sub_amount_two;
                          }       
                  break;                      
               }
               
           switch ($recursive_two) {
                  case "Y":
                   $recursive = 'Yes';
                  break;    
                  case "N":
                   $recursive = 'No';
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
$stmt3 = $dbMain ->prepare("SELECT add_sub_three,  add_sub_amount_three, add_sub_desc_three, recursive_three  FROM indi_details WHERE add_sub_three != 'E'");
             $stmt3->execute();      
             $stmt3->store_result();      
             $stmt3->bind_result($add_sub_three,  $add_sub_amount_three, $add_sub_desc_three, $recursive_three); 
             $stmt3->fetch();
             $rowCount3 = $stmt3->num_rows;
             
       if($rowCount3 != 0)  {            
           switch ($add_sub_three) {
                  case "S":
                   $deductAdd = 'Deduction'; 
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal - $add_sub_amount_three;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount - $add_sub_amount_three;
                          }                    
                  break;    
                  case "A":
                   $deductAdd = 'Addition';
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal + $add_sub_amount_three;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount + $add_sub_amount_three;
                          }                    
                  break;                      
               }
               
           switch ($recursive_three) {
                  case "Y":
                   $recursive = 'Yes';
                  break;    
                  case "N":
                   $recursive = 'No';
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
$stmt4 = $dbMain ->prepare("SELECT add_sub_four,  add_sub_amount_four, add_sub_desc_four, recursive_four  FROM indi_details WHERE add_sub_four != 'E'");
             $stmt4->execute();      
             $stmt4->store_result();      
             $stmt4->bind_result($add_sub_four,  $add_sub_amount_four, $add_sub_desc_four, $recursive_four); 
             $stmt4->fetch();
             $rowCount4 = $stmt4->num_rows;
             
       if($rowCount4 != 0)  {            
           switch ($add_sub_four) {
                  case "S":
                   $deductAdd = 'Deduction';
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal - $add_sub_amount_four;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount - $add_sub_amount_four;
                          }                    
                  break;    
                  case "A":
                   $deductAdd = 'Addition'; 
                     if($this->totalPaymentAmount == null) {    
                          $this->totalPaymentAmount = $this->subTotal - $add_sub_amount_four;
                          }else{
                           $this->totalPaymentAmount = $this->totalPaymentAmount - $add_sub_amount_four;
                          }                    
                  break;                      
                }
                
           switch ($recursive_four) {
                  case "Y":
                   $recursive = 'Yes';
                  break;    
                  case "N":
                   $recursive = 'No';
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
                
                $this->totalPaymentAmount = $this->subTotal;
                }
             
  $this->totalPaymentAmount = sprintf("%01.2f", $this->totalPaymentAmount);
  $this->paymentDate   = date("F j, Y", strtotime($this->paymentDate));
  $this->loadBusinessInfo();               
  $this->createDetailsHtml();       
         

}
//====================================================================
function makeHtml(){
      $this->hoursListHtml = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\"><b>Timeclock Report</b></font></th>
</tr>
<tr>
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hours List</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clock in</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Clock out</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Hours Worked</font></th>
</tr>";
   
    $array1 = explode('|',$this->hoursList);
    //var_dump($array1);
    foreach($array1 as $info){
        $array2 = explode(',',$info);
        $this->hoursListHtml .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$array2[0]</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$array2[2]</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$array2[3]</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$array2[1]</b></font>
                                        </td>
                                        </tr>
                                        \n";
       /* $this->hoursListHtml  .= "<tr>
                            <td>$array2[0]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$array2[2]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$array2[3]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$array2[1]<br></td>
                            </tr>";*/
    }
}
//--------------------------------------------------------------------
function formatDetails() {
 $this->makeHtml();

$this->printPageHeader = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
\"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<link rel=\"stylesheet\" href=\"../css/payrollPrintIndi.css\"/>
<script type=\"text/javascript\" src=\"../scripts/printIndiRecord.js\"></script>

	<title>Payroll Details</title>
</head>
<body>";

$this->printPageFooter ="
</body>
</html>";


$details = explode("@", $this->detailsArray);

foreach($details as $recordsArray) {
        
         if($recordsArray != "") {

             $detailsArray = explode("|", $recordsArray);
            
            $this->userId = $detailsArray[0];
            $this->typeKey = $detailsArray[1];
            $this->addSubOne = $detailsArray[2];
            $this->addSubAmountOne = $detailsArray[3];
            $this->addSubDescOne = $detailsArray[4];
            $this->recursiveOne = $detailsArray[5];
            $this->addSubTwo = $detailsArray[6];
            $this->addSubAmountTwo = $detailsArray[7];
            $this->addSubDescTwo = $detailsArray[8];
            $this->recursiveTwo = $detailsArray[9];
            $this->addSubThree = $detailsArray[10];
            $this->addSubAmountThree = $detailsArray[11];
            $this->addSubDescThree = $detailsArray[12];
            $this->recursiveThree = $detailsArray[13];
            $this->addSubFour = $detailsArray[14];
            $this->addSubAmountFour = $detailsArray[15];
            $this->addSubDescFour = $detailsArray[16];
            $this->recursiveFour = $detailsArray[17];
            $this->commissionAmount = $detailsArray[18];
            $this->salary = $detailsArray[19];
            $this->hourlyWages = $detailsArray[20];
            $this->hoursProjected = $detailsArray[21];
            $this->totalHours = $detailsArray[22];
            $this->subTotal = $detailsArray[23];   
            $this->employeeId = $detailsArray[24];   
            $this->employeeName = $detailsArray[25]; 
            $this->filterDetails();
            $this->detailsCount++;
          }

}

$indiPrintForm = "$this->printPageHeader$this->indiPrintTemplate$this->printPageFooter"; 
$_SESSION['indi_print_form'] = $indiPrintForm;
$this->details = "1";   
   
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

$details_array = $_REQUEST['details_array'];
$hours_list = $_REQUEST['hours_list'];
$pt_html = $_REQUEST['pt_html'];
$pt_html_ta = $_REQUEST['pt_html_ta'];
$ot1 = $_REQUEST['ot1'];
$ot2 = $_REQUEST['ot2'];
$commissReturns = $_REQUEST['commissReturns'];
$salesHtml = $_REQUEST['salesHtml'];
//#########################################
include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

$loadDetails = new viewIndiDetails();
$loadDetails-> setDetailsArray($details_array);
$loadDetails-> setHoursList($hours_list);
$loadDetails-> setOt1($ot1);
$loadDetails-> setOt2($ot2);
$loadDetails-> setPtHtml($pt_html);
$loadDetails-> setPtHtmlTA($pt_html_ta);
$loadDetails-> setImageName($image_name);
$loadDetails-> setCommissReturns($commissReturns);
$loadDetails-> setSalesHtml($salesHtml);
$loadDetails-> formatDetails();
$detailsHtml = $loadDetails-> getDetails();

echo"$detailsHtml";





?>