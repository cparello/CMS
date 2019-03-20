<?php
session_start();


class accountPaymentForms {

private $contractKey = null;
private $transactionKey = null;
private $trans_key = null;
private $lateFee = null;
private $nsfFee = null;
private $rejectionFee = null;
private $pastDueMonthly = null;
private $initialPaymentDue = null;
private $nsfCheckPayment = null;
private $nsfCheckNumber = null;
private $declinedPayment = null;
private $paymentForm = null;
private $buttonText = null;
private $feeText = null;
private $feeAmount = null;
private $subTotalText = null;
private $dueAmount = null;
private $totalDue = null;
private $titleText = null;
private $businessName = null;
private $clubId = null;
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;
private $reasonCode = null;
private $transactionType = null;
private $eftCheckBox = null;


function setContractKey($contractKey) {
            $this->contractKey = $contractKey;
            }            
function setTransactionKey($transactionKey) {
            $this->transactionKey = $transactionKey;
            }
function setTransKey($transKey) {
            $this->transKey = $transKey;
            }            
function setLateFee($lateFee) {
            $this->lateFee = $lateFee;
            }
function setNsfFee($nsfFee) {
            $this->nsfFee = $nsfFee;
            }
function setRejectionFee($rejectionFee) {
            $this->rejectionFee = $rejectionFee;
            }
function setPastDueMonthly($pastDueMonthly) {
            $this->pastDueMonthly = $pastDueMonthly;
            }
function setInitialPaymentDue($initialPaymentDue) {
            $this->initialPaymentDue = $initialPaymentDue;
            }
function setNsfCheckPayment($nsfCheckPayment) {
            $this->nsfCheckPayment = $nsfCheckPayment;
            }
function setDeclinedPayment($declinedPayment) {
            $this->declinedPayment = $declinedPayment;
            }
function setNsfCheckNumber($nsfCheckNumber) {
            $this->nsfCheckNumber = $nsfCheckNumber;
            }
function setReasonCode($reasonCode) {
            $this->reasonCode = $reasonCode;
            }
function setTransactionType($transactionType) {
            $this->transactionType = $transactionType;
            }
function setMonthlyServicesBool($monthlyBool){
            $this->monthlyServicesBool = $monthlyBool;
            }




//connect to database
function dbconnect()   {
require"../../../dbConnect.php";
return $dbMain;              
}

//===========================================================================
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT  business_name FROM company_names WHERE business_name !='' "); 
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name);      
 $stmt->fetch();
 
$this->businessName = $business_name;


$stmt->close();
}
//---------------------------------------------------------------------------------
function loadClubInfo() {

$this->clubId = $_SESSION['location_id'];

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_name, club_address, club_phone  FROM club_info WHERE club_id ='$this->clubId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_name, $club_address, $club_phone); 
$stmt->fetch();

$this->clubName = $club_name;
$this->clubAddress = $club_address;
$this->clubPhone = $club_phone;

$stmt->close();

}
//------------------------------------------------------------------------------------------------------------------------------------
function loadSessionVariables() {

$_SESSION['title_text'] = $this->titleText;
$_SESSION['item_text'] = $this->subTotalText;
$_SESSION['item_amount'] = $this->dueAmount;
$_SESSION['fee_text'] = $this->feeText;
$_SESSION['fee_amount'] = $this->feeAmount;
$_SESSION['total_amount'] = $this->totalDue;
$_SESSION['contract_key_receipt'] = $this->contractKey;

$_SESSION['business_name'] = $this->businessName;
$_SESSION['club_name'] = $this->clubName;
$_SESSION['club_address'] = $this->clubAddress;
$_SESSION['club_phone'] = $this->clubPhone;


}
//-----------------------------------------------------------------------------------------------------------------------------------
function parsePaymentForm() {

     switch ($this->transactionKey) {
        case 'PD':
             $this->buttonText = 'Process Account Past Due';
             $this->titleText = 'Account Past Due';
             $this->feeText = "Late Fee:";
             $this->feeAmount = $this->lateFee;
             $this->feeText2 = "";
             $this->feeAmount2 = '';
             $this->subTotalText = 'Past Due Amount:';
             $this->dueAmount = $this->pastDueMonthly;
             $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">"; 
        break;
        case 'ID':
             $this->buttonText = 'Process Initial Payment Balance Due';
             $this->titleText = 'Initial Payment Balance Due';
             $this->feeText = "Due Fee:";
             $this->feeAmount = '0.00';
             $this->feeText2 = "";
             $this->feeAmount2 = '';
             $this->subTotalText = 'Balance Due:';
             $this->dueAmount = $this->initialPaymentDue;
             $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">"; 
        break;
        case 'IF':
             $this->buttonText = 'Process NSF Check Payment';
             $this->titleText ='NSF Check Payment';
             $this->feeText = "NSF Fee:";
             $this->feeAmount = $this->nsfFee;
             $this->feeText2 = "Late Fee:";
             $this->feeAmount2 = $this->lateFee;
             $this->subTotalText = 'NSF Amount:'; 
             $this->dueAmount = $this->nsfCheckPayment;
             $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">"; 
        break;
        case 'EF':
        
              if($this->transactionType == 'Credit Card') {
                 switch ($this->reasonCode) {
                    case '202':
                         $this->buttonText = 'Process Declined Monthly Payment';  
                         $this->titleText = 'Declined Monthly Payment';
                         $this->feeText = "Rejection Fee:";
                         $this->feeAmount = $this->rejectionFee;
                         $this->feeText2 = "Late Fee:";
                         $this->feeAmount2 = $this->lateFee;
                         $this->subTotalText = 'Declined Amount:'; 
                         $this->dueAmount = $this->declinedPayment;
                         $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";
                    break;
                    case '205':
                         $this->buttonText = 'Process Declined Monthly Payment';  
                         $this->titleText = 'Declined Monthly Payment';
                         $this->feeText = "Rejection Fee:";
                         $this->feeAmount = $this->rejectionFee;
                         $this->feeText2 = "Late Fee:";
                         $this->feeAmount2 = $this->lateFee;
                         $this->subTotalText = 'Declined Amount:'; 
                         $this->dueAmount = $this->declinedPayment;
                         $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";                       
                    break;
                    case '231':
                         $this->buttonText = 'Process Declined Monthly Payment';  
                         $this->titleText = 'Declined Monthly Payment';
                         $this->feeText = "Rejection Fee:";
                         $this->feeAmount = $this->rejectionFee;
                         $this->feeText2 = "Late Fee:";
                         $this->feeAmount2 = $this->lateFee;
                         $this->subTotalText = 'Declined Amount:'; 
                         $this->dueAmount = $this->declinedPayment;
                         $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";                       
                    break;
                    case '201':
                         $this->buttonText = 'Process Declined Monthly Payment';  
                         $this->titleText = 'Declined Monthly Payment';
                         $this->feeText = "Rejection Fee:";
                         $this->feeAmount = $this->rejectionFee;
                         $this->feeText2 = "Late Fee:";
                         $this->feeAmount2 = $this->lateFee;
                         $this->subTotalText = 'Declined Amount:'; 
                         $this->dueAmount = $this->declinedPayment;
                         $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";                        
                    break;
                    default:
                         $this->buttonText = 'Process Declined Monthly Payment';
                         $this->titleText = 'Declined Monthly Payment';
                         $this->feeText = "Rejection Fee:";
                         $this->feeAmount = $this->rejectionFee;
                         $this->feeText2 = "Late Fee:";
                         $this->feeAmount2 = $this->lateFee;
                         $this->subTotalText = 'Declined Amount:'; 
                         $this->dueAmount = $this->declinedPayment; 
                         $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";                          
                    break;
                    }
                                               
                 }else{
                  $this->buttonText = 'Process Declined Monthly Payment';
                  $this->titleText = 'Declined Monthly Payment';
                  $this->feeText = "Rejection Fee:";
                  $this->feeAmount = $this->rejectionFee;
                  $this->feeText2 = "Late Fee:";
                  $this->feeAmount2 = $this->lateFee;
                  $this->subTotalText = 'Declined Amount:'; 
                  $this->dueAmount = $this->declinedPayment;
                  $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";                                  
                }
       
        break;
        default:
        
     }
     if ($this->transactionKey == 'XX' AND $this->monthlyServicesBool == 1){
        $this->buttonText = 'Update Credit Card';
        $this->titleText = '';
        $this->feeText = "";
        $this->feeAmount = '';
        $this->feeText2 = "";
        $this->feeAmount2 = '';
        $this->subTotalText = ''; 
        $this->dueAmount = '';
        $this->eftCheckBox = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Card <input type=\"checkbox\" name=\"cc_update\" id=\"cc_update\" value=\"cc_update\">";        
     }

$this->totalDue = $this->feeAmount + $this->feeAmount2 + $this->dueAmount;
$this->totalDue = sprintf("%01.2f", $this->totalDue);

$this->loadBusinessInfo();
$this->loadClubInfo();
$this->loadSessionVariables();

$this->loadPaymentForm();
}
//------------------------------------------------------------------------------------------------------------------------------------
function loadMonthYearDrops() {

$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")+1;
$secondYearValue = date("y")+1;
$thirdYearName = date("Y")+2;
$thirdYearValue = date("y")+2;
$fourthYearName = date("Y")+3;
$fourthYearValue = date("y")+3;
$fifthYearName = date("Y")+4;
$fifthYearValue = date("y")+4;
$sixthYearName = date("Y")+5;
$sixthYearValue = date("y")+5;
$seventhYearName = date("Y")+6;
$seventhYearValue = date("y")+6;

$this->monthDrop = <<<MONTHDROP
<select  name="card_month" id="card_month"/>
<option value="">Month</option>
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04" >April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
MONTHDROP;

$this->yearDrop = <<<YEARDROP
<select  name="card_year" id="card_year"/>
<option value="">Year</option>
<option value="$firstYearValue">$firstYearName</option>
<option value="$secondYearValue">$secondYearName</option>
<option value="$thirdYearValue">$thirdYearName</option>
<option value="$fourthYearValue">$fourthYearName</option>
<option value="$fifthYearValue">$fifthYearName</option>
<option value="$sixthYearValue">$sixthYearName</option>
<option value="$seventhYearValue">$seventhYearName</option>
</select>
YEARDROP;




}
//----------------------------------------------------------------------------------------
function loadPaymentForm() {

$this->loadMonthYearDrops();






$this->paymentForm= <<<PAYMENTFORM
<table id="secTab" align="left" cellspacing="3" cellpadding="3" width="650" >
<tr>
<td class="black3" colspan="3">
<form id="form1">
$this->feeText <span class="empTxt2">$this->feeAmount</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->feeText2 <span class="empTxt2">$this->feeAmount2</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->subTotalText <span class="empTxt2">$this->dueAmount</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Due: <span class="empTxt2">$this->totalDue</span>$this->eftCheckBox
</td>
<td class="closeX">
<span class="close">X</span>
</td>
</tr>


<tr>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile3" width="50%">
Credit Card Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile4" width="50%">
&nbsp;
</td>
</tr>


<tr>
<td class="black2 tile3">
Name on Card:
</td>
<td class="rightBorder">
<input name="card_name" type="text" id="card_name" value="$card_name" size="25" maxlength="300"/>
</td>
<td class="black2">
Card Type:
</td>
<td class="tile4">
<select name="card_type" id="card_type"/>
  <option value>Card Type</option>
  <option value="Visa">Visa</option>
  <option value="MC">MasterCard</option>
  <option value="Amex">American Express</option>
  <option value="Disc">Discover</option>
</select>
</td>
</tr>

<tr>
<td class="black2 tile3">
Card Number:
</td>
<td class="rightBorder">
<input  name="card_number" type="text" id="card_number" value="$card_number" size="25" maxlength="22"/>
</td>
<td class="black2">
Security Code:
</td>
<td class="tile4">
<input name="card_cvv" type="text" id="card_cvv" value="$card_cvv" size="25" maxlength="4"/>
</td>
</tr>

<tr>
<td class="black2 tile3">
Expiration Date:
</td>
<td class="rightBorder">
$this->monthDrop
$this->yearDrop
</td>
<td class="black2">
Credit Payment:
</td>
<td class="tile4">
<input name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10"/>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile3" width="50%">
Cash Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile4" width="50%">
Check Payment
</td>
</tr>


<tr>
<td class="black2 tile3 tile5">
Cash Payment:
</td>
<td class="rightBorder tile5">
<input name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10"/>
</td>
<td class="black2 tile5">
Check Payment / Number:
</td>
<td class="tile4 tile5">
<input  name="check_pay" type="text" id="check_pay" value="" size="12" maxlength="10"/>
&nbsp;
<input name="check_number" type="text" id="check_number" value="" size="9" maxlength="10"/>
</td>
</tr>


<tr>
<td class="tabPad3" align="center" colspan= "4">
<input type="button" name="update" id= "update" value="$this->buttonText" class="button1" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="receipt" value="Print Receipt" class="button1 re" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="reload" value="Reload Account" class="button1 rl" />
<input type="hidden" id="contract_key" name="contract_key" value="$this->contractKey"/>
<input type="hidden" id="total_due" name="total_due" value="$this->totalDue"/>
<input type="hidden" id="fee_amount" name="fee_amount" value="$this->feeAmount"/>
<input type="hidden" id="transaction_key" name="transaction_key" value="$this->transactionKey"/>
<input type="hidden" id="nsf_check_number" name="nsf_check_number" value="$this->nsfCheckNumber"/>
<input type="hidden" id="trans_key" name="trans_key" value="$this->transKey"/>
<input type="hidden" id="purchase_marker" name="purchase_marker" value=""/>

</form>
</td>
</tr>
</table>

PAYMENTFORM;

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function getPaymentForm() {
         return($this->paymentForm);
         }

function getYearDrop() {
         return($this->yearDrop);
         }

function getMonthDrop() {
         return($this->monthDrop);
         }



}
?>