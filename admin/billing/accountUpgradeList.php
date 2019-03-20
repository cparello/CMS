<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}


class  accountUpgradeList {

private $contractKey = null;
private $serviceKey = null;
private $serviceId = null;
private $selectedServiceKey = null;
private $serviceQuantity = null;
private $primaryListing =null;
private $pifServices = null;
private $monthlyServices = null;
private $currentServices = null;
private $serviceType =null;
private $fieldCount = 1;
private $billingFieldCount = 1;
private $keyList = null;
private $keyListBilling = null;
private $membershipFlag = null;
private $startDate = null;
private $endDate = null;
private $dailyRateArray = null;
private $proFieldCount = null;
private $serviceSalt = null;
private $maxSignupDate = null;
private $sqlSwap = null;
private $settledCount = null;

private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $city = null;
private $state = null;
private $zipCode = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress =null;
private $licenseNumber = null;

private $stateList =null;
private $disabled = null;
private $tableHeader = null;
private $tableFooter =null;
private $checked = null;
private $existingListHeader = null;

private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;
private $groupRows = null;
private $groupMarker = null;
private $groupType = null;
private $groupTypeHeader = null;
private $groupNumber = null;
private $monthGovernor = null;
private $monthEndDate = null;
private $monthlyPayment = null;
private $monthlyBillingType = null;
private $totalRenewRate = null;
private $serviceEndDate = null;

private $accountInfo = null;
private $accountStatus = null;

private $commissionCredit = null;
private $commissionId = null;

//for banking and cc  info
private  $bankName = null;
private  $accountType = null;
private  $accountName = null;
private  $accountNumber = null;
private  $routingNumber = null;
private  $cardName = null;
private  $cardType = null;
private  $cardNumber = null;
private  $cardCvv = null;
private  $cardExpDate = null;

private  $upgradeFee = null;
private  $feeSql = null;
private  $transfer = null;
private  $transferStatus = null;


//this is for the billing system
private  $monthlyBillingServices = null;
private  $pifBillingServices = null;
private  $billingListings = null;
private  $termType = null;
private  $cancelationFee = null;
private  $monthlySignupDate = null;
private  $cancelFeeList = null;
private  $accountBillingStatus = null;
private  $backgroundColor = '#fff';
private  $expiredDisabled =null;
private  $canceledDisabled =null;
private  $holdDisabled =null;
private  $holdCheck = null;
private  $holdBit = null;
private  $holdFlag = null;
private  $serviceStatusBilling = null;
private  $holdChecked = null;
private  $pastDay = null;
private  $groupPriceArray = null;
private  $cancelBalance = null;
private  $monthCount = 0;
private  $monthBit = null;
private  $fontClass = null;
private  $serviceCount = 0;
private  $cancelCount = 0;
private  $monthlyDues = null;

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }              
function setServiceKey($serviceKey) {
                 $this->serviceKey = $serviceKey;
              }  
function setSelectedServiceKey($selectedServiceKey) {
                 $this->selectedServiceKey = $selectedServiceKey;
              }                    
function setCancelationFee($cancelationFee) {
                 $this->cancelationFee = $cancelationFee;
                 }
function setCancelFeeList($cancelFeeList) {
                 $this->cancelFeeList =  $cancelFeeList;
                 }


     
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//------------------------------------------------------------------------------------------------
function monthlySettledCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) FROM monthly_settled WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($settled_count);
$stmt->fetch();

$this->settledCount = $settled_count;

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();

}
//------------------------------------------------------------------------------------------------
function dailyRate()  {

if($this->endDate != 'NA') {

     $start_date = strtotime($this->startDate);
     $end_date = strtotime($this->endDate);
     $duration_date = $end_date - $start_date;
     $duration_days = $duration_date / 86400;
     $daily_rate = $this->groupPrice / $duration_days;
  // $daily_rate = sprintf("%.2f", $daily_rate);
    
    // $precision = 2;    
    // $pow = pow(10, $precision);
   //  $daily_rate = ( ceil ( $pow * $daily_rate ) + ceil ( $pow * $daily_rate - ceil ( $pow * $daily_rate ) ) ) / $pow;           
     $end_date_mil = $end_date * 1000;
     
     
  }else{
      $daily_rate = $this->groupPrice;
      $end_date_mil = 'NA';
  }
  
  
//$service_term =   ereg_replace("[^A-Z]", "", $this->serviceTerm);
 $service_term =   preg_replace("/[^A-Z]/", "", $this->serviceTerm); 

$this->dailyRateArray .= "$daily_rate $end_date_mil $this->serviceSalt $this->groupRenewRate $this->serviceKey $service_term|";

$this->totalRenewRate += $this->groupRenewRate;

}
//------------------------------------------------------------------------------------------------
function getMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();  

}
//------------------------------------------------------------------------------------------------
function checkAccountStatusFull()  {
 
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
//if($account_status == 'CA') {
   return $account_status;
//  }
  

    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    


}
//------------------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;

 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//------------------------------------------------------------------------------------------------
function loadColorCodes() {
$dbMain = $this->dbconnect();
  if($this->pastDay == null) {
  
   
   $stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num ='1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();
   
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
   $stmt->close();       
   }
   
    $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM billing_collections WHERE contract_key='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
   //echo "test $this->serviceKey status $this->accountStatus<br>";
   $this->pastDay = $past_day;
   
   $service_end_date_array = explode('-', $this->serviceEndDate);
   $year = $service_end_date_array[0];
   $month = $service_end_date_array[1];
   $day = $service_end_date_array[2];
   
   $end_grace_date = date("Y-m-d"  ,mktime(0, 0, 0, $month, $day+$past_day, $year));
   
 //  echo"$end_grace_date";
   $todays_date = date("Y-m-d");
   $service_end_date = $this->serviceEndDate;
   
   $end_grace_date  = strtotime($end_grace_date);
   $todays_date  = strtotime($todays_date);
   $service_end_date  = strtotime($service_end_date);
  
        //check to see if the service has expired
    if($this->serviceEndDate != '0000-00-00 00:00:00') {
          if($service_end_date < $todays_date) {
             $this->serviceStatusBilling = 'EX';
             }
       }    
           
  $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM billing_collections WHERE contract_key='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();  
    
    if($count > 0){
        $this->serviceStatusBilling = "CO";
    }     
 
 switch($this->serviceStatusBilling) {          
             case"EX":
             $this->backgroundColor = '#CCC'; 
             $this->expiredDisabled = '';
             $this->canceledDisabled = null; 
             $this->holdDisabled = null;
             $this->holdChecked = null;
             $this->holdBit = 0;
             $this->holdFlag = 1;
             $this->fontClass = 'exText';
             break;
             case"HO":
             $this->backgroundColor = '#900';
             $this->holdDisabled = 'disabled="disabled"';
             $this->holdChecked = 'checked';
             $this->holdBit = 1;
             $this->holdFlag = 0;
             $this->expiredDisabled = null;            
             $this->canceledDisabled = null;
             $this->fontClass = 'keyText';
             break;
             case"CA":
             $this->backgroundColor = '#06C';
             $this->canceledDisabled = 'disabled="disabled"';
             $this->holdDisabled = null;
             $this->expiredDisabled = null;
             $this->holdChecked = null;
             $this->holdBit = 0;
             $this->holdFlag = 1;
             $this->fontClass = 'keyText';
             break;
             case"CO":
             $this->backgroundColor = '#7FFF00';
             $this->canceledDisabled = 'disabled="disabled"';
             $this->holdDisabled = null;
             $this->expiredDisabled = null;
             $this->holdChecked = null;
             $this->holdBit = 0;
             $this->holdFlag = 1;
             $this->fontClass = 'keyText';
             break;
             default:
             $this->canceledDisabled = null;
             $this->holdDisabled = null;
             $this->expiredDisabled = null;
             $this->backgroundColor = '#fff';
             $this->holdChecked = null;
             $this->holdBit = 0;
             $this->holdFlag = 0;
             $this->fontClass = 'keyText';
           }
            
 
 

      
}

//------------------------------------------------------------------------------------------------
function checkCommissionCredit()  {

$dbMain = $this->dbconnect();
$result = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_id ='$this->commissionId'"); 
$row_count = $result->num_rows; 

if($row_count == 0) {
   $this->commissionCredit = $_SESSION['user_name'];
  }else{
   $row = $result->fetch_array(MYSQLI_NUM);
   $this->commissionCredit = $row[1];
  }
  
//$result->close(); 

}
//------------------------------------------------------------------------------------------------
function parseServiceTerm() {

switch($this->serviceTerm) {          
             case"C":
             $this->serviceTerm = 'Class(s)';
             break;
             case"D":
             $this->serviceTerm = 'Day(s)';
             break;
             case"W":
             $this->serviceTerm = 'Week(s)';
             break;
             case"M":
             $this->serviceTerm = 'Month(s)';
             break;
             case"Y":
             $this->serviceTerm = 'Year(s)';
             break;
             }
}
//------------------------------------------------------------------------------------------------     
function loadClubName() {

$dbMain = $this->dbconnect();
$result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                 $this->serviceLocation = $row[0];
                                                               
                    if($this->clubId == "0")  {
                        $this->serviceLocation = 'All Locations';
                      }
//$result->close(); 
}
//------------------------------------------------------------------------------------------------
function stateSelect() {
require "../helper_apps/stateSelect.php";
}
//------------------------------------------------------------------------------------------------
function loadUpgradeFee() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT $this->feeSql FROM fees WHERE fee_num = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($upgrade_fee);
   $stmt->fetch();
      
      $this->upgradeFee = $upgrade_fee;
            
$stmt->close();                                                                                                                   
}
//------------------------------------------------------------------------------------------------
function loadPaymentTypes() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT bank_name, account_type, account_fname, account_mname,  account_lname, account_number,  routing_number, card_fname,   card_mname,  card_lname, card_type, card_number,  card_cvv,  card_exp_date FROM banking_info, credit_info WHERE banking_info.contract_key ='$this->contractKey' AND credit_info.contract_key ='$this->contractKey'");
 echo($dbMain->error);
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bank_name, $account_type, $account_fname, $account_mname, $account_lname, $account_number, $routing_number, $card_fname, $card_mname, $card_lname, $card_type, $card_number, $card_cvv, $card_exp_date);
 $stmt->fetch();

//change zeros to null for form fields
if($routing_number == 0) {
   $routing_number = null;
   }
if($card_cvv == 0) {
   $card_cvv = null;
   }


$this->bankName = $bank_name;
$this->accountType = $account_type;
$this->accountName = "$account_fname $account_mname $account_lname";
$this->accountNumber = $account_number;
$this->routingNumber = $routing_number;
$this->cardName = "$card_fname $card_mname $card_lname";
$this->cardType = $card_type;
$this->cardNumber = $card_number;
$this->cardCvv = $card_cvv;
$this->cardExpDate = $card_exp_date;


$stmt->close();     

}
//==========================================================================
function loadGroupInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_name, group_address, group_phone FROM member_groups WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_name, $group_address, $group_phone);
$stmt->fetch();

$this->groupAddress = $group_address;
$this->groupPhone = $group_phone;
$this->groupName = $group_name;


switch($group_type) {          
             case"S":
             $this->groupType = 'S';
             $this->groupTypeHeader = 'Single';
             $this->feeSql = 'upgrade_fee_single_two';
             break;
             case"F":
             $this->groupType = 'F';
             $this->groupTypeHeader = 'Family';
             $this->feeSql = 'upgrade_fee_family_two';
             break;
             case"B":
             $this->groupType = 'B';
             $this->groupTypeHeader = 'Business';
             $this->feeSql = 'upgrade_fee_business_two';
             $this->groupMarker = 1;
             break;
             case"O":
             $this->groupType = 'O';
             $this->groupTypeHeader = 'Organization';
             $this->feeSql = 'upgrade_fee_organization_two';
             $this->groupMarker = 1;
             break;
             }

$this->groupRows = "
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Name:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\">$group_name</td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Address:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\"><input name=\"group_address\" type=\"text\" id=\"group_address\" value=\"$this->groupAddress\" size=\"50\" maxlength=\"50\" onFocus=\"return checkServices(this.name,this.id)\" disabled=\"disabled\" /></td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Phone:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\"><input name=\"group_phone\" type=\"text\" id=\"group_phone\" value=\"$this->groupPhone\" size=\"20\" maxlength=\"25\" onFocus=\"return checkServices(this.name,this.id)\" disabled=\"disabled\"/></td>
</tr>";

switch($group_type) {          
             case"S":
             $this->groupRows = null;
             $this->groupMarker = null;
             break;
             case"F":
             $this->groupRows = null;
             $this->groupMarker = null;
             break;
             }
             
//get the renewal fee             
 $this->loadUpgradeFee();          

}
//=========================================================================
function createExistingListing() {



$proRate ="<input type=\"text\" name=\"pro[]\" id=\"pro\" value=\"\" size=\"8\" maxlength=\"8\" disabled=\"disabled\"/>";

$this->proFieldCount = $this->fieldCount;

$this->existingListHeader  = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">#</th>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Location</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Type</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Term</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Quantity</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Current Rate</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Renew  Rate </th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Renew Date</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Commission Credit</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Pro Rate</th>
</tr>";



$listing = "
<tr id=\"a$this->fieldCount\" style=\"background-color: $this->color\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->fieldCount.</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->serviceLocation</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->serviceName</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->serviceType</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->serviceQuantity $this->serviceTerm</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupNumber</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupPrice</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupRenewRate</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->endDate</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->commissionCredit</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$proRate</td>
</tr>";

return "$listing";

}
//=========================================================================
function createBillingListing()  {

if($this->accountStatus == 'CA') {
   $this->cancelCount++;
  }

switch($this->serviceTerm) {          
             case"Class(s)":
             $term_balance = 'NA';
             $this->monthBit = 0;
             $credit_bit = 0;
             $this->expiredDisabled = "";
             break;
             case"Day(s)":
             $term_balance = 'NA';
             $this->monthBit = 0;             
             $credit_bit = 1;
             break;
             case"Week(s)":
             $term_balance = 'NA';
             $this->monthBit = 0;             
             $credit_bit = 1;
             break;             
             case"Month(s)":
                //get the month count
                $this->monthCount++;
                $this->monthBit = 1;
                //check to see if this is open ended or term then set the amount due
                if($this->termType == 'O')  {    
                
                   $term_balance = $this->cancelationFee;
                   
                  }else if($this->termType == 'T') {     
                  
                  //calculates the daily rate for the service based on the full term
                  $start_date = strtotime($this->monthlySignupDate);
                  $end_date = strtotime($this->endDate);
                  $duration_date = $end_date - $start_date;
                  $duration_days = $duration_date / 86400;
                  $numMonthseft = $duration_days / 30;
                  
                  //load settled count to fix bug in new subscription cancel rates
                  $this->monthlySettledCount();
                  if($this->settledCount > 0) {
                      $daily_rate = $this->groupPrice / $duration_days;
                      }else{
                      $daily_rate = $this->groupPrice / $duration_days;
                      }
     
                   //calc the curent prorate
                  $todays_date = time();
                  
                  if($todays_date <= $end_date) {
                     $duration_date = $end_date - $todays_date;
                     $duration_days = $duration_date / 86400;
                     $term_balance =sprintf("%.2f",$duration_days * $daily_rate);    
                 //$term_balance = sprintf("%.2f",$numMonthseft * $this->groupPrice); 
                     }else{
                     $term_balance = '0.00';
                     //$this->canceledDisabled = "";
                     $this->expiredDisabled = "";
                     }
                     
                  }
             $credit_bit = 2;
             break;
                          
             case"Year(s)":
             $term_balance = 'NA';
             $this->monthBit = 0;
             $credit_bit = 1;
             break;
             }

//set the drop downs for the credit service
if($credit_bit == 1) {
  $option_values ="<option value=\"D\" selected>Day</option>
   <option value=\"W\" >Week</option>
   <option value=\"M\" >Month</option>
   <option value=\"Y\" >Year</option>";
  }else if($credit_bit == 0)  {
  $option_values ="<option value=\"C\" selected>Class(s)</option>";
  }else if($credit_bit == 2)  {
  $option_values ="<option value=\"M\" selected>Month(s)</option>";
  }
  
  
//this is set to disable the cancel function in the Available Holds / Cancelations / Credit Terms  section  
 $cancel_list_array = explode(" ", $this->cancelFeeList);    
 if (in_array("$this->serviceKey", $cancel_list_array)) {
    $disabled = 'disabled';    
    }else{
    $disabled = "";
    }

 
 

$billing_listing ="
 <tr id=\"b$this->billingFieldCount\"  bgcolor=\"$this->backgroundColor\">
 <td class=\"$this->fontClass tile2\">
  $this->serviceName
 </td>
 <td class=\"$this->fontClass tile2\">
  $this->serviceType
 </td> 
 <td class=\"$this->fontClass tile2\">
  $this->serviceQuantity $this->serviceTerm
 </td>      
 <td class=\"$this->fontClass tile2\" id=\"g$this->billingFieldCount\">
  $this->groupNumber
 </td>  
 <td class=\"$this->fontClass tile2\" id=\"p$this->billingFieldCount\">
  $this->groupPrice
 </td>   
 <td class=\"$this->fontClass tile2\">
  $this->endDate
 </td>
 
 <td class=\"$this->fontClass tile2\">
 <input type=\"hidden\" name=\"serv_keys$this->billingFieldCount\"  id=\"serv_keys$this->billingFieldCount\" value=\"$this->billingFieldCount|$this->contractKey|$this->serviceKey|$this->serviceId\" $this->expiredDisabled$this->holdDisabled$this->canceledDisabled/>
 
<input name=\"serv_num$this->billingFieldCount\" type=\"text\" id=\"serv_num$this->billingFieldCount\" value=\"\" size=\"2\" maxlength=\"2\"  onKeyUp=\"return creditServiceTerm(this.value,this.id, 'cancel$this->billingFieldCount', 'cancel_cost$this->billingFieldCount', 'hold$this->billingFieldCount' );\" $this->expiredDisabled$this->holdDisabled$this->canceledDisabled/>
&nbsp;
<select  name=\"serv_credit$this->billingFieldCount\" id=\"serv_credit$this->billingFieldCount\" $this->expiredDisabled$this->holdDisabled$this->canceledDisabled/>
$option_values
</select>&nbsp;&nbsp;&nbsp;
 <input type=\"checkbox\" name=\"servAdjust[]\" id=\"subtract$this->billingFieldCount\" value=\"$this->billingFieldCount|$this->contractKey|$this->serviceKey|$this->accountStatus|$this->monthlyDues|$this->serviceId|1\"/>
 </td>
 
 <td class=\"$this->fontClass tile2\">
<input type=\"checkbox\" name=\"cancel[]\" id=\"cancel$this->billingFieldCount\" value=\"$this->billingFieldCount|$this->contractKey|$this->serviceKey|$this->serviceId|$this->monthlyDues\" onClick=\"changeColor2(this, 'b$this->billingFieldCount', 'hold$this->billingFieldCount', 'cancel_cost$this->billingFieldCount', 'serv_credit$this->billingFieldCount', 'serv_num$this->billingFieldCount', 'serv_keys$this->billingFieldCount' , '$this->monthBit');\" $disabled $this->expiredDisabled$this->holdDisabled$this->canceledDisabled/>

 <input name=\"cancel_cost$this->billingFieldCount\" type=\"text\" id=\"cancel_cost$this->billingFieldCount\" value=\"$term_balance\" size=\"7\" maxlength=\"8\" onKeyUp =\"setCancelFee(this.value, 'cancel$this->billingFieldCount'); return checkNan(this.value,this.name);\" onFocus=\"return checkAvailable(this.value, this.id);\" $disabled $this->expiredDisabled$this->holdDisabled$this->canceledDisabled/>
 </td>  
 
 <td class=\"$this->fontClass tile2\">
 <input type=\"checkbox\" name=\"hold[]\" id=\"hold$this->billingFieldCount\" value=\"$this->billingFieldCount|$this->contractKey|$this->serviceKey|$this->accountStatus|$this->monthlyDues|$this->serviceId|$this->holdFlag\" onClick=\"return changeColor3(this,'b$this->billingFieldCount',$this->holdBit,'cancel_cost','cancel','serv_credit','serv_num','serv_keys',$this->holdFlag);\" $this->expiredDisabled$this->canceledDisabled $this->holdChecked/>
 </td>   
 </tr>";

$this->billingFieldCount++;     

//create the array for group price
$indi_rate = sprintf("%.2f",$this->groupPrice / $this->groupNumber);
$this->groupPriceArray .= "$indi_rate|";

//set up list for group credits if beyond the refund period
if($term_balance != 'NA') {
  $this->cancelBalance = $this->cancelBalance + $term_balance;
}

return "$billing_listing";



}

//=========================================================================
function loadPifServices()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_id, group_type, group_number, club_id, service_name,  service_quantity, service_term,  group_price, group_renew_rate, start_date, end_date, user_id, signup_date FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey' $this->sqlSwap  ORDER BY service_id DESC LIMIT 1 ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_id, $group_type, $group_number, $club_id, $service_name, $service_quantity, $service_term, $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $signupDate);
$rowCount = $stmt->num_rows;  

if($rowCount  != 0)  {
$stmt->fetch();

//here we create a flag if they have a membership
if(preg_match("/membership/i", $service_name)) {
  $this->membershipFlag = 1;
  }

$this->serviceId = $service_id;
$this->serviceType = 'Paid In Full';
$this->groupNumber = $group_number;
$this->clubId = $club_id; 
$this->loadClubName();
$this->serviceName = $service_name;
$this->serviceQuantity = $service_quantity;
$this->serviceTerm = $service_term;
  //sets term as string
$this->parseServiceTerm();
$this->groupPrice = $group_price;
$this->signupDate = $signupDate;

//this is for non time services like classes
if($group_renew_rate == "0.00")  {
    $this->groupRenewRate = 'NA';
   }else{
    $this->groupRenewRate = $group_renew_rate;
   }


$this->startDate = $start_date;
$this->commissionId = $user_id;
$this->checkCommissionCredit();

//this is for non time services like classes
if($end_date == "0000-00-00 00:00:00")  {
   $this->serviceEndDate = "0000-00-00 00:00:00";
   $this->endDate = 'NA';
   }else{
    //parse to english the end date and create a var to check the grace period for a renewal if eligable
     $this->serviceEndDate = $end_date;
     $end_date  = strtotime($end_date);
     $this->endDate = date("F j, Y", $end_date);     
   }

//this sets up the payment per day for prorate in the upgrade form
$this->serviceSalt = 0;
$this->dailyRate();

$this->color = '#ffffff';
$this->checked = null;
$this->j = 0;
//$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
//$this->tableFooter = "</table>";
$this->checkAccountStatus();


     //make sure the account has not already been canceld or is on hold  or expired                       
 if(($this->accountStatus != "CA") &&  ($this->accountStatus != "EX")) { 
            $this->pifServices .= $this->createExistingListing();
            $this->serviceStatusBilling = $this->accountStatus;
             
            $this->loadColorCodes();  
    
            $this->pifBillingServices  .=  $this->createBillingListing();                       
            }else{
            $this->sqlSwap = "AND service_id != '$this->serviceId'  ";
            $this->loadPifServices();
            }            
                                                    
    
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 



}
$this->sqlSwap = null;
}
//==========================================================================
function loadMonthlyServices()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_id, group_type, group_number, club_id, service_name,  number_months,  group_price, group_renew_rate, start_date, end_date, user_id, term_type, signup_date, monthly_dues FROM monthly_services WHERE contract_key ='$this->contractKey' AND service_key = '$this->serviceKey'  $this->sqlSwap  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result( $service_id, $group_type, $group_number, $club_id, $service_name,  $number_months,  $group_price, $group_renew_rate, $start_date, $end_date, $user_id, $term_type, $signup_date, $monthly_dues);
$rowCount = $stmt->num_rows;  

if($rowCount  != 0)  {
$stmt->fetch();   

$this->serviceId = $service_id;
//get the monthly payment
$this->getMonthlyPayment();
$this->monthlySignupDate = $signup_date;
$this->monthlyDues = $monthly_dues;

//here we create a flag if they have a membership
if(preg_match("/membership/i", $service_name)) {
  $this->membershipFlag = 1;
  }

//this sets up the number of months for upgrade list available
$this->monthGovernor = $number_months;

$this->serviceType = 'Monthly';
$this->groupNumber = $group_number;
$this->clubId = $club_id; 
$this->loadClubName();
$this->serviceName = $service_name;
$this->serviceQuantity = $number_months;
$this->serviceTerm = 'M';
$this->termType = $term_type;
  //sets term as string
$this->parseServiceTerm();
$this->groupPrice = $group_price;

//this is for non time services like classes
if($group_renew_rate == "0.00")  {
    $this->groupRenewRate = 'NA';
   }else{
    $this->groupRenewRate = $group_renew_rate;
   }


$this->startDate = $start_date;
$this->commissionId = $user_id;
$this->checkCommissionCredit();

//this is for non time services like classes
if($end_date == "0000-00-00 00:00:00")  {
   $this->serviceEndDate = "0000-00-00 00:00:00";
   $this->endDate = 'NA';
   }else{
    //parse to english the end date
     $this->serviceEndDate = $end_date;
     $end_date  = strtotime($end_date);
     $this->endDate = date("F j, Y", $end_date);
     $this->monthEndDate = $end_date;
   }

//this sets up the payment per day for prorate in the upgrade form
$this->serviceSalt = 1;
$this->dailyRate();

$this->color = '#ffffff';
$this->checked = null;
$this->j = 0;
$this->checkAccountStatus();
                               
     //make sure the account has not already been canceld or is on hold  or expired                      
 if(($this->accountStatus != "CA") &&  ($this->accountStatus != "EX")) {  
         $this->monthlyServices .= $this->createExistingListing();
         $this->serviceStatusBilling = $this->accountStatus;
         $this->loadColorCodes();         
         $this->monthlyBillingServices  .=  $this->createBillingListing();
         }else{
         $this->sqlSwap = "AND service_id != '$this->serviceId'  ";  
         $this->loadMonthlyServices();
         }  
      

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }


$stmt->close(); 

}
$this->sqlSwap = null;
}
//==========================================================================
function loadCurrentListings()  {

$dbMain = $this->dbconnect();

//first we start with pif services
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM paid_full_services WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_key);
$rowCount = $stmt->num_rows;
$this->serviceCount = $this->serviceCount + $rowCount;

             if($rowCount == 0) {
                 $this->pifServices = null;                
               }else{               
                    while ($stmt->fetch()) {  
                             $this->serviceKey = $service_key;
                             $this->keyList .= "$service_key,";
                             $this->keyListBilling .= "P$service_key,";
                            
                             $cancelValue = $this->checkAccountStatusFull();
                              
                             if($cancelValue != 'CA') {   
                               $this->loadPifServices();  
                               $this->fieldCount++;
                               }
                             }                             
               }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

//now we hit the monthly services
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM monthly_services WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_key);
$rowCount = $stmt->num_rows;
$this->serviceCount = $this->serviceCount + $rowCount;

             if($rowCount == 0) {
                 $this->monthlyServices = null;                
               }else{               
                    while ($stmt->fetch()) {  
                             $this->serviceKey = $service_key;                             
                             $this->keyList .= "$service_key,";
                            $this->keyListBilling .= "M$service_key,";
                             
                             $cancelValue = $this->checkAccountStatusFull();
                             if($cancelValue != 'CA') {
                                 $this->loadMonthlyServices();  
                                 $this->fieldCount++;
                                 }
                             }                                
               }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 



$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
$this->tableFooter = "</table>";


$this->currentServices = "$this->tableHeader $this->listHeader $this->existingListHeader $this->pifServices $this->monthlyServices $this->tableFooter";

$this->billingListings = "$this->monthlyBillingServices  $this->pifBillingServices";
   
}
//==========================================================================

//ORDER BY contract_date DESC LIMIT 1
//==========================================================================
function loadAccountHolder()   {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, transfer, license_number FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $trans, $license_number);
 $stmt->fetch();

$this->commissionCredit = $user_id;
$this->firstName = $first_name;
$this->middleName = $middle_name;
$this->lastName = $last_name;
$this->streetAddress = $street;
$this->city = $city;
$this->state = $state;
$this->zipCode = $zip; 
$this->primaryPhone = $primary_phone;
$this->cellPhone = $cell_phone;
$this->emailAddress = $email;
$this->transfer = $trans;
$this->licenseNumber = $license_number;

//set up the transfer radio
$this->loadTransferStatus();

//this gets any prvious payment types like cc info and ach
$this->loadPaymentTypes();


$this->disabled = 'disabled="disabled"';
$this->stateSelect();
$this->loadGroupInfo();


$this->accountInfo = <<<ACCOUNTINFO
<table align="left"  border="0" cellspacing="2" cellpadding="2" width=100% >
<tr>
<td align="left" valign ="middle" class="keyText">Account Number:</td>
<td align="left"  valign ="middle"class="keyText2">$this->contractKey</td>
</tr>
<tr>
<td align="left" valign ="middle" class="keyText">Account Type:</td>
<td align="left"  valign ="middle"class="keyText2">$this->groupTypeHeader</td>
</tr>

$this->groupRows

<tr>
<td align="left" valign ="middle" class="keyText">Host Name:</td>
<td align="left"  valign ="middle"class="keyText2">$this->firstName   $this->middleName  $this->lastName</td>
</tr>
<tr>
<td align="left" valign ="top" class="keyText" rowspan="2">Host Address:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="street_address" type="text" id="street_address" value="$this->streetAddress" size="25" maxlength="50" onFocus="return checkServices(this.name,this.id)" disabled="disabled" /> <input name="city" type="text" id="city" value="$this->city" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>
<tr>

<td align="left"  valign ="middle"class="keyText2">
$this->stateList
<input name="zip" type="text" id="zip" value="$this->zipCode" size="10" maxlength="5" onFocus="return checkServices(this.name,this.id)" disabled="disabled"/>
</td>
</tr>

<tr>
<td align="left" valign ="middle" class="keyText">Phone Numbers:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="primary_phone" type="text" id="primary_phone" value="$this->primaryPhone" size="20" maxlength="25" onFocus="return checkServices(this.name,this.id)" disabled="disabled"/> <input name="cell_phone" type="text" id="cell_phone" value="$this->cellPhone" size="20" maxlength="25" onFocus="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>



<tr>
<td align="left" valign ="middle" class="keyText">Email Address:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="email" type="text" id="email" value="$this->emailAddress" size="20" maxlength="25" onFocus="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>
</table>
ACCOUNTINFO;


//SELECT something, anything, but , please, not, the , dreaded , evil , "select star" FROM my_table WHERE my_date = ( select max(my_date) from my_table )
//AND contract_date = ( select max(contract_date) FROM contract_info)


}
//===========================================================================
function loadTransferStatus()  {

if($this->transfer == "N")  {


$this->transferStatus ="
<tr>
<td class=\"black\">
Non Transferable:
</td>
<td>
<input name=\"trans\" type=\"radio\"  value=\"N\" checked disabled=\"disabled\"/>
</td>
</tr>";

   }else{
   
$this->transferStatus ="
<tr>
<td class=\"black\">
Transferable:
</td>
<td>
<input name=\"trans\" type=\"radio\"  value=\"Y\" checked disabled=\"disabled\"/>
</td>
</tr>";   
   
   }

}
//===========================================================================
function getTransferStatus() {
             return($this->transferStatus);
             }
function getContractKey() {
             return($this->contractKey);
             }
function getGroupType() {
             return($this->groupType);
             }     
function getGroupMarker() {
             return($this->groupMarker);
             }             
function getAccountInfo() {
             return($this->accountInfo);
             }
function getPifServices() {
             return($this->pifServices);
             }
function getMonthlyServices() {
             return($this->monthlyServices);
             }
function getKeyList() {
             return($this->keyList);
             }
function getKeyListBilling() {
             return($this->keyListBilling);
             }             
function getMembershipFlag() {
             return($this->membershipFlag);
             }
function getCurrentServices() {
             return($this->currentServices);
             }
function getServiceQuantity() {
             return($this->serviceQuantity);
             }
function getGroupNumber() {
            return($this->groupNumber);
            }
function getMonthGovernor() {
            return($this->monthGovernor);
            }
function getGroupName() {
             return($this->groupName);
             }
function getGroupAddress() {
             return($this->groupAddress);
             }
function getGroupPhone() {
             return($this->groupPhone);         
             }   
function getFirstName() {
             return($this->firstName);
             } 
function getMiddleName() {
             return($this->middleName);
             }                          
function getLastName() {
             return($this->lastName);
             }                  
function getStreetAddress() {
             return($this->streetAddress);
             }
function getCity() {
             return($this->city);
             }
  function getState() {
             return($this->state);
             }           
 function getZipCode() {
             return($this->zipCode);
             }            
 function getPrimaryPhone() {
             return($this->primaryPhone);
             }            
 function getCellPhone() {
             return($this->cellPhone);
             }            
function getEmailAddress() {
             return($this->emailAddress);
             }                     
function getLicenseNumber() {
             return($this->licenseNumber);
             }                     
            

//banking and cc info
function getBankName() {
          return($this->bankName);
          }
function getAccountType() {          
          return($this->accountType);
          }
function getAccountName() {          
          return($this->accountName);
          }
function getAccountNumber() {          
          return($this->accountNumber);
          }
function getRoutingNumber() {          
          return($this->routingNumber);
          }
function getCardName() {          
          return($this->cardName);
          }
function getCardType() {
         return($this->cardType);
         }
function getCardNumber() {         
         return($this->cardNumber);
         }
function getCardCvv() {         
         return($this->cardCvv);
         }
function getCardExpDate() {         
         return($this->cardExpDate);
         }
function getMonthEndDate() {
         return($this->monthEndDate);
         }
function getMonthlyPayments() {
         return($this->monthlyPayment);
         }
function getMonthlyBillingType() {
         return($this->monthlyBillingType);
         }
function getDailyRateArray() {
         return($this->dailyRateArray);
         }
function getProFieldCount() {
         return($this->proFieldCount);
         }
function getTotalRenewRate() {
         $this->totalRenewRate = sprintf ("%01.2f", $this->totalRenewRate);
         return($this->totalRenewRate);
         }
function getBillingListings() {
        return($this->billingListings);
        }
function getBillingFieldCount() {
        return($this->billingFieldCount);
        }
function getGroupPriceArray() {
        return($this->groupPriceArray);
        }
function getCancelBalance() {
        return($this->cancelBalance);
        }          
function getMonthCount() {
        return($this->monthCount);
        }
function getServiceCount() {
        return($this->serviceCount);
        } 
function getCancelCount() {
        return($this->cancelCount);
        }  
             
          
              
}              
              