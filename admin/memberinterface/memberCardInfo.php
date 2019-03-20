<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memberCardInfo {

private $memberId = null;
private $contractKey = null;
private $cardHolderForm = null;
private $paymentForm = null;
private $cardHolderScript = null;
private $cardFee = null;
private $memberName = null;
private $memberAddress = null;
private $memberPhoto = null;
private $monthDrop = null;
private $yearDrop = null;



function setContractKey($contractKey) {
        $this->contractKey = $contractKey;
        }
function setMemberId($memberId) {
        $this->memberId = $memberId;
        }


 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==================================================
function checkFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT card_fee  FROM fees WHERE fee_num='1' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($card_fee);
  $stmt->fetch();

  $this->cardFee = $card_fee;

$stmt->close();

}
//----------------------------------------------------------------------------------------
function loadMemberInfo() {

$dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, street, city, state, zip, member_photo  FROM member_info WHERE contract_key='$this->contractKey' AND member_id='$this->memberId' ");   
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name, $street, $city, $state, $zip, $member_photo);
  $stmt->fetch();
        
                 $this->memberName = "$first_name $middle_name $last_name";             
                 $this->memberAddress = "$street $city, $state $zip";
                 
                 if($member_photo == "") {                    
                    $this->memberPhoto = 'no_photo.jpg';
                    }else{
                    $this->memberPhoto = $member_photo;                    
                    }
                        
$stmt->close();
          
}
//----------------------------------------------------------------------------------------
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
<table id="secTab" align="left" cellspacing="3" cellpadding="3">
<tr>
<td class="black3">
Card Fee: <span class="empTxt2">$this->cardFee</span>
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
<input  name="card_number" type="text" id="card_number" value="$card_number" size="25" maxlength="25"/>
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
<td colspan= "4" class="tabPad3">&nbsp;</td>
</tr>


<tr>
<td class="grey" valign=\"top\">
Waive Card Fee:
</td>
<td>
<input  name="overide_pin" type="text" class="fieldColor" id="overide_pin" value="Enter Manager Pin Number" size="20" maxlength="4"/>
</td>
<td align="right" colspan= "2">
<input type="button" name="update" id="update" value="Reassign Card Number" class="button1" />
<input type="button" name="receipt" id="re" value="Print Receipt" class="button1 re" />
<input type="hidden" id="member_id" name="member_id" value="$this->memberId"/>
<input type="hidden" id="contract_key" name="contract_key" value="$this->contractKey"/>
<input type="hidden" id="member_name" name="member_name" value="$this->memberName"/>
<input type="hidden" id="adjust_bool" name="adjust_bool" value="N"/>
<input type="hidden" id="card_fee" name="card_fee" value="$this->cardFee"/>
<input type="hidden" id="purchase_marker" name="purchase_marker" value=""/>
<input type="hidden" id="purchase_total" name="purchase_total" value=""/>
</form>

</td>
</tr>



</table>

PAYMENTFORM;





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
//------------------------------------------------------------------------------------------------------------------------------------
function loadSessionVariables() {

$_SESSION['title_text'] = 'New ID Card Payment';
$_SESSION['item_text'] = 'Amount Charged';
$_SESSION['item_amount'] = $this->dueAmount;
$_SESSION['fee_text'] = 'New Card Fee';
$_SESSION['fee_amount'] = $this->feeAmount;
$_SESSION['total_amount'] = $this->totalDue;
$_SESSION['contract_key_receipt'] = $this->contractKey;

$_SESSION['business_name'] = $this->businessName;
$_SESSION['club_name'] = $this->clubName;
$_SESSION['club_address'] = $this->clubAddress;
$_SESSION['club_phone'] = $this->clubPhone;


}
//---------------------------------------------------------------------------------------
function parseHolderForm() {

if($this->cardFee > 0) {

$this->loadPaymentForm();
$this->cardHolderScript = 'reassignTwo.js';
$this->cardHolderForm = "<table align=\"center\">
<tr>
<td rowspan=\"10\" valign=\"top\" class=\"padLft\" id=\"empPhoto\">
<img src=\"../memberphotos/$this->memberPhoto\" width=\"125\" height=\"150\" id=\"memPic\" onError=\"this.src = '../memberphotos/no_photo.jpg'\"> 
</td>
<td class=\"black pTopTwo\" valign=\"top\">
Member Name:
</td>
</tr>
<tr>
<td class=\"empTxt\" valign=\"top\">
$this->memberName
</td>
</tr>

<tr>
<td class=\"black pTopTwo\" valign=\"top\">
Member Address:
</td>
</tr>
<tr>
<td class=\"empTxt\" valign=\"top\">
$this->memberAddress
</td>
</tr>

<tr>
<td class=\"black pTopTwo\" valign=\"top\">
Current Card Number:
</td>
</tr>
<tr>
<td id=\"currentCard\" class=\"empTxt\" valign=\"top\">
$this->memberId
</td>
</tr>

<tr>
<td class=\"black pTopTwo\" valign=\"top\">
New Card Number:
</td>
</tr>
<tr>
<td valign=\"top\">
<form id=\"form1\">
<input  name=\"id_card\" type=\"text\" id=\"id_card\" size=\"20\" maxlength=\"30\" value=\"\"/>
</td>
</tr>
</table>";

   
  }else{
  
$this->paymentForm = null;
$this->cardHolderScript = 'reassignOne.js';
$this->cardHolderForm ="
<table border=\"0\" align=\"center\" cellpadding=\"5\">
<tr>
<td class=\"black\">
Member Name:
</td>
<td class=\"empTxt\">
$this->memberName
</td>
</tr>

<tr>
<td class=\"black\">
Member Address:
</td>
<td class=\"empTxt\">
$this->memberAddress
</td>
</tr> 

<tr>
<td class=\"black\" valign=\"top\">
Member Photo:
</td>
<td>
<img src=\"../memberphotos/$this->memberPhoto\" width=\"110\" height=\"135\" id=\"memPic\" onError=\"this.src = '../memberphotos/no_photo.jpg'\">
</td>
</tr> 

<tr>
<td class=\"black\">
Current Card Number:
</td>
<td id=\"currentCard\" class=\"empTxt\">
$this->memberId
</td>
</tr> 

<tr>
<td class=\"black\">
New Card Number:
</td>
<td>
<form id=\"form1\">
<input  name=\"id_card\" type=\"text\" id=\"id_card\" size=\"20\" maxlength=\"30\" value=\"\"/>
</td>
</tr> 

<tr>
<td class=\"pTopThree\">
&nbsp;
</td>
<td class=\"pTopThree\">
<input  type=\"submit\" class=\"button1\" name=\"reassign_id\" value=\"Reassign Card Number\"/>
<input type=\"button\" name=\"receipt\" value=\"Print Receipt\" class=\"button1 re\" />
<input type=\"hidden\" id=\"member_id\" name=\"member_id\" value=\"$this->memberId\"/>
<input type=\"hidden\" id=\"contract_key\" name=\"contract_key\" value=\"$this->contractKey\"/>
<input type=\"hidden\" id=\"member_name\" name=\"member_name\" value=\"$this->memberName\"/>
<input type=\"hidden\" id=\"purchase_marker\" name=\"purchase_marker\" value=\"\"/>
<input type=\"hidden\" id=\"purchase_total\" name=\"purchase_total\" value=\"\"/>
</form>
</td>
</tr> 

</table>";  
  }


$this->loadClubInfo();
$this->loadBusinessInfo();
$this->loadSessionVariables();
}
//----------------------------------------------------------------------------------------
function loadMemberCardHolder() {

$this->loadMemberInfo();
$this->checkFees();
$this->parseHolderForm();


}
//==================================================
function getCardHolderForm() {
       return($this->cardHolderForm);
       }
function getPaymentForm() {
       return($this->paymentForm);
       }
function getCardHolderScript() {
       return($this->cardHolderScript);
       }


}






?>