<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout

class  accountRenewList {

private $contractKey = null;
private $selectedServiceKey = null;
private $selectedRenewRate = null;
private $serviceKey = null;
private $renewType = null;
private $primaryListing = null;
private $secondaryListings = null;
private $serviceLocation = null;
private $clubId = null;
private $serviceName = null;
private $serviceQuantity = null;
private $serviceTerm = null;
private $unitPrice = null;
private $unitRenewRate = null;
private $groupPrice = null;
private $groupRenewRate = null;
private $startDate = null;
private $endDate = null;
private $listHeader = null;
private $fieldCount = 1;
private $color = null;
private $pifServices = null;

private $commissionCredit = null;
private $commissionId = null;

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

private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;
private $groupRows = null;
private $groupMarker = null;
private $groupType = null;

private $accountInfo = null;

private  $earlyRenewalGrace = null;
private  $earlyRenewalPercent = null;
private  $accountStatus = null;
private  $renewalFee = null;
private  $feeSql = null;

private  $earlyField = null;
private  $earlyType = null;


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


function setEarlyRenewalGrace($earlyRenewalGrace) {
                 $this->earlyRenewalGrace = $earlyRenewalGrace;
              }
              
function setEarlyRenewalPercent($earlyRenewalPercent) {
                 $this->earlyRenewalPercent = $earlyRenewalPercent;
              }

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }
              
function setServiceKey($serviceKey) {
                 $this->serviceKey = $serviceKey;
              }     
              
function setSelectedServiceKey($selectedServiceKey) {
                 $this->selectedServiceKey = $selectedServiceKey;
              }                           
              
function setRenewType($renewType) {
                 $this->renewType = $renewType;
              }     
              
              
              
              


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//--------------------------------------------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------------------------------------------
function stateSelect() {
require "../helper_apps/stateSelect.php";
}
//---------------------------------------------------------------------------------------------------------------------------------
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
//----------------------------------------------------------------------------------------------------------------------------------
function loadRenewalFee() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT $this->feeSql FROM fees WHERE fee_num = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($renewal_fee);
   $stmt->fetch();
      
      $this->renewalFee = $renewal_fee;
            
$stmt->close();                                                                                                                   
}
//---------------------------------------------------------------------------------------------------------------------------------
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
//-------------------------------------------------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
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
//---------------------------------------------------------------------------------------------------------------------------------
function checkPastGrace() {
if ($this->renewType != 'P'){
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num ='1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();
   
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
        if($service_end_date < $todays_date) {
           $this->accountStatus  = 'EX';
           $this->color = '#390'; 
          
              if($todays_date > $end_grace_date) {
                 $this->renewType = 'X';         
                }else{
                 $this->renewType = 'S';
               }                     
         }      
      
           
 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       
    }  
}
//--------------------------------------------------------------------------------------------------------------------------------
function checkEarlyRenewalStatus()  {

if ($this->renewType != 'P'){
$todaysDate = date("Y-m-d");
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(end_date) AS result_count FROM paid_full_services  WHERE contract_key= '$this->contractKey' AND service_key='$this->serviceKey' AND end_date > '$todaysDate' AND end_date <= '$this->earlyRenewalGrace' AND service_term != 'C'");
 $stmt->execute();      
 $stmt->store_result();  
 $stmt->bind_result($result_count);
 $stmt->fetch();
 
 //echo"$result_count  $this->contractKey  $this->earlyRenewalGrace <br>";
 if ($this->renewType != 'X'){
    if($result_count != 0) { 
        $this->renewType = 'E';
    }else{
        $this->renewType = 'S';
    }
 }
 
  

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    
    }
}
//==============================================================================================
//=========================================================================
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
$this->groupTypeDrop = $group_type;

switch($group_type) {          
             case"S":
             $this->groupType = 'Single';
             $this->feeSql = 'renewal_fee_single_two';
             break;
             case"F":
             $this->groupType = 'Family';
             $this->feeSql = 'renewal_fee_family_two';
             break;
             case"B":
             $this->groupType = 'Business';
             $this->feeSql = 'renewal_fee_business_two';
             $this->groupMarker = 1;
             break;
             case"O":
             $this->groupType = 'Organization';
             $this->feeSql = 'renewal_fee_organization_two';
             $this->groupMarker = 1;
             break;
             }

$this->groupRows = "
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupType Name:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\">$group_name</td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupType Address:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\"><input name=\"group_address\" type=\"text\" id=\"group_address\" value=\"$this->groupAddress\" size=\"50\" maxlength=\"50\" onClick=\"return checkServices(this.name,this.id)\" disabled=\"disabled\" /></td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupType Phone:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\"><input name=\"group_phone\" type=\"text\" id=\"group_phone\" value=\"$this->groupPhone\" size=\"20\" maxlength=\"25\" onClick=\"return checkServices(this.name,this.id)\" disabled=\"disabled\"/></td>
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
 $this->loadRenewalFee();          

}
//=============================================================================
function loadServicePriceExpired(){
    
$dbMain = $this->dbconnect();
$term = substr($this->serviceTerm, 0, 1);
//echo "$this->selectedServiceKey $this->serviceQuantity $this->serviceTerm $term";
$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost WHERE service_key ='$this->selectedServiceKey' AND service_quantity = '$this->serviceQuantity' AND service_term = '$term'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->expiredServiceCost);
$stmt->fetch();

}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

  if($this->monthsPastDue >= 1) {
     $this->monthlyPayment = ($this->monthlyPayment * $this->monthsPastDue) + $this->lateFee;     
    }else{
         $this->monthlyPayment = 0;
    }


$this->billingTotal = $this->monthlyPayment;
$this->billingTotal = number_format("$this->billingTotal",2);

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//========================================================================
function createListing() {
$term = substr($this->serviceTerm, 0, 1);

switch($term){
    case 'D':
         $yearDrop =  "<form action=\"\" method=\"get\" id=\"myform\"> 
            <select name=\"year_quantity\" id=\"year_quantity\"> 
            <option value=\"$this->serviceQuantity\" selected>$this->serviceQuantity $this->serviceTerm</option>            
            <option value=\"30\">30 $this->serviceTerm</option>
            <option value=\"60\">60 $this->serviceTerm</option>
            <option value=\"90\">90 $this->serviceTerm</option>
            </select>";
    break;
    case 'W':
           $yearDrop = "<form action=\"\" method=\"get\" id=\"myform\"> 
        <select name=\"year_quantity\" id=\"year_quantity\"> 
              <option value=\"$this->serviceQuantity\" selected>$this->serviceQuantity $this->serviceTerm</option>            
              <option value=\"4\">4 $this->serviceTerm</option>
              <option value=\"12\">12 $this->serviceTerm</option>
              <option value=\"26\">26 $this->serviceTerm</option>
            </select>";
    break;
    case 'Y':
          $yearDrop =  "<form action=\"\" method=\"get\" id=\"myform\"> 
        <select name=\"year_quantity\" id=\"year_quantity\"> 
              <option value=\"$this->serviceQuantity\" selected>$this->serviceQuantity $this->serviceTerm</option>   
              <option value=\".25\">3 Months</option>
              <option value=\".5\">6 Months</option>    
              <option value=\"1\">1 $this->serviceTerm</option>
              <option value=\"2\">2 $this->serviceTerm</option>
              <option value=\"3\">3 $this->serviceTerm</option>
            </select>";
    break;
}



if($this->renewType == 'P'){
    $diffServiceDrop = "<form action=\"\" method=\"get\" id=\"myform\"> 
    <select name=\"service_name_drop\" id=\"service_name_drop\">" ;
}else{
 $diffServiceDrop = "<form action=\"\" method=\"get\" id=\"myform\"> 
<select name=\"service_name_drop\" id=\"service_name_drop\">
<option value=\"$this->serviceKey\" selected>$this->serviceName</option>" ;   
}

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT service_info.service_key, service_type FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type LIKE '%membership%' AND service_quantity = '$this->serviceQuantity' AND service_term = '$term' AND group_type = '$this->groupTypeDrop'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($newServiceKey, $newServiceType);
while($stmt->fetch()){
    $diffServiceDrop .= "<option value=\"$newServiceKey\">$newServiceType</option>";
}
$stmt->close();

$diffServiceDrop .= "</select></td>";



//check to see if the renew type is a early renew to create a form field
if($this->renewType == "E") {
    $this->earlyTest = 1;
$early_a ="early$this->fieldCount";
$early_b ='[]';
$early = "$early_a$early_b";
  $earlyRenewField ="<input type=\"text\" name=\"$early\" id=\"$early_a\" value=\"$this->groupRenewRate\" size=\"8\" maxlength=\"8\"  onClick=\"return rateChange(this.value, this.id, 'renew$this->fieldCount')\"/ >";
   }elseif($this->renewType == "S") {
   $earlyRenewField = 'NA';
   $early_a = 'NA';
   $this->earlyTest = 0;
 }elseif($this->renewType == 'X') {
   $earlyRenewField = 'NA';
   $early_a = 'NA';
   $this->earlyTest = 0;
 }elseif($this->renewType == 'P') {
   $earlyRenewField = 'NA';
   $early_a = 'NA';
   $this->earlyTest = 0;
 }


if($this->renewType == 'X'){
$standard_a ="standard$this->fieldCount";
$standard_b ='[]';
$standard = "$standard_a$standard_b";
$standardRenewField ="<input type=\"text\" name=\"$standard\" id=\"$standard_a\" value=\"$this->groupRenewRate\" size=\"8\" maxlength=\"8\"  onClick=\"return rateChange(this.value, this.id, 'renew$this->fieldCount','$early_a')\" $this->disabled />";
}elseif($this->renewType == 'S'){
    $standard_a ="standard$this->fieldCount";
    $standard_b ='[]';
    $standard = "$standard_a$standard_b";
    $standardRenewField ="<input type=\"text\" name=\"$standard\" id=\"$standard_a\" value=\"$this->groupRenewRate\" size=\"8\" maxlength=\"8\"  onClick=\"return rateChange(this.value, this.id, 'renew$this->fieldCount','$early_a')\" $this->disabled />"; 
}elseif($this->renewType == 'P'){
    $standard_a ="standard$this->fieldCount";
    $standard_b ='[]';
    $standard = "$standard_a$standard_b";
    $standardRenewField ="<input type=\"text\" name=\"$standard\" id=\"$standard_a\" value=\"$this->groupRenewRate\" size=\"8\" maxlength=\"8\"  onClick=\"return rateChange(this.value, this.id, 'renew$this->fieldCount','$early_a')\" $this->disabled />"; 
}

//used to send an id for the primary listing
$this->earlyField = $early_a;


$commissionField = "<input  name=\"commission_credit[]\" type=\"text\" id=\"commission_credit$this->fieldCount\" value=\"$this->commissionCredit\" size=\"15\" maxlength=\"30\" onChange=\"return checkUser2(this.value,this.id,'$this->commissionCredit')\"/>";


$this->listHeader = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">#</th>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Service Location</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Term</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Quantity</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Current Rate</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Renew  Rate </th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Early Renew</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Renew Date</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Commission Credit</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">&nbsp;</th>
</tr>";



$listing = "
<tr id=\"a$this->fieldCount\" style=\"background-color: $this->color\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->fieldCount.</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->serviceLocation</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$diffServiceDrop</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$yearDrop</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupNumber</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupPrice</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$standardRenewField</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$earlyRenewField</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->endDate</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$commissionField</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">
<input type=\"checkbox\" name=\"renew[]\" id=\"renew$this->fieldCount\" value=\"$this->serviceKey\" onClick=\"return selectService(this,'a$this->fieldCount','$this->color','$standard_a','$early_a','$this->groupRenewRate');\" $this->checked /></td>
</tr>";

return "$listing";


}
//==========================================================================
function retrieveSecondaryListings()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name,  service_quantity, service_term,  group_price, group_renew_rate, start_date, end_date, user_id FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey' AND service_term != 'C' ORDER BY signup_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($group_type, $group_number, $club_id, $service_name, $service_quantity, $service_term, $group_price, $group_renew_rate, $start_date, $end_date, $user_id);
$stmt->fetch();


$this->groupNumber = $group_number;
$this->clubId = $club_id; 
$this->loadClubName();
$this->serviceName = $service_name;
$this->serviceQuantity = $service_quantity;
$this->serviceTerm = $service_term;
  //sets term as string
$this->parseServiceTerm();
$this->groupPrice = $group_price;
$this->groupRenewRate = $group_renew_rate;
$this->startDate = $start_date;
$this->commissionId = $user_id;
$this->checkCommissionCredit();
  //used to see if they are within the grace period for renewal if expired
$this->serviceEndDate = $end_date;
  //parse to english the end date
$end_date  = strtotime($end_date);
$this->endDate = date("F j, Y", $end_date);
$this->color = '#ffffff';
$this->checked = null;
$this->j = 0;
//$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
//$this->tableFooter = "</table>";
$this->checkAccountStatus();
                               
     //make sure the account has not already been canceld or is on hold                         
 if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                                  
          $this->checkPastGrace();
                                                                                         
            if($this->renewType != null) { 
               $this->fieldCount++;
                       if($this->earlyRenewalPercent == 0 AND  $this->renewType != 'X') {
                           $this->renewType == "S";
                         }else{
                           $this->checkEarlyRenewalStatus(); 
                         }   
                             
                    //$this->pifServices .= $this->createListing();                                                                                                                                                                                                         
                }
      }                                                 


   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 


}
//===========================================================================
function loadSecondaryListings()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM paid_full_services WHERE contract_key ='$this->contractKey' AND service_key !='$this->selectedServiceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_key);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $this->pifServices = null;
                
               }else{
               
                    while ($stmt->fetch()) {  
                             $this->serviceKey = $service_key;
                             $this->retrieveSecondaryListings();                             
                             }      
                             
               }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
$this->tableFooter = "</table>";


if($this->pifServices != null) {
$this->secondaryListings = "$this->tableHeader $this->listHeader $this->pifServices $this->tableFooter";
}else{
$this->secondaryListings = "<span class=\"blackBold\">No Other Services Available for Renewal</span>";
}



}
//=============================================================================
function loadPifOutService(){
    
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT group_type FROM member_groups WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type);
$stmt->fetch();
$stmt->close();
//echo "$this->selectedServiceKey $this->serviceQuantity $this->serviceTerm $term";
$stmt = $dbMain ->prepare("SELECT service_cost, service_type, service_quantity, service_term FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key WHERE service_type LIKE '%Membership%' AND service_quantity = '1' AND service_term = 'Y' AND group_type = '$group_type' ORDER BY service_cost ASC LIMIT 1
 ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->serviceCostPifOut, $this->serviceTypePifOut, $this->serviceQuantityPifOut, $this->serviceTermPifOut);
$stmt->fetch();

}
//=============================================================================
function loadMonthlyService(){
    
$dbMain = $this->dbconnect();
  //echo "loadmonthly fubar $this->contractKey $this->selectedServiceKey";
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name, number_months, group_price, group_renew_rate,
 start_date, MAX(end_date), user_id FROM monthly_services WHERE contract_key ='$this->contractKey' AND service_key='$this->selectedServiceKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->group_typeMonthly, $this->group_numberMonthly, $this->club_idMonthly, $this->service_nameMonthly, $this->number_monthsMonthly, $this->group_priceMonthly, $this->group_renew_rateMonthly, $this->start_dateMonthly, $this->end_dateMonthly, $this->user_idMonthly);
$stmt->fetch(); 
$stmt->close(); 

$end_date_monthlyarray = explode(' ',$this->end_dateMonthly);
$startDateSecs = strtotime($this->start_dateMonthly);
$todays_date = date("Y-m-d");
$todays_dateSecs  = strtotime($todays_date);
$service_end_dateSecs  = strtotime($end_date_monthlyarray[0]);

if ($todays_dateSecs < $startDateSecs){
    $secs = $startDateSecs;
}else{
    $secs = $todays_dateSecs;
}
//echo"td $todays_date ed $end_date_monthlyarray[0]";
        //check to see if the service has expired
if($service_end_dateSecs > $secs) {
    $secsLeft = $service_end_dateSecs - $secs;
    $secondsInADay = 86400;

    $days = floor($secsLeft / $secondsInADay);
    $this->timeOwed = sprintf("%01.0f", $days/30);
    $this->moneyOwed =  sprintf("%01.2f",($this->group_priceMonthly/$this->number_monthsMonthly)*$this->timeOwed);
    //echo "to $this->timeOwed mo $this->moneyOwed secleft $secsLeft  prices $this->group_priceMonthly/$this->number_monthsMonthly";
}else{
    $this->timeOwed = 0;
    $this->moneyOwed = 0;
}

}
//=============================================================================
function loadPrimaryListing()  {

$dbMain = $this->dbconnect();

if($this->renewType == 'P'){
    $stmt = $dbMain ->prepare("SELECT DISTINCT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($next_payment_due_date);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($past_day);
    $stmt->fetch();
    $stmt->close();

    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay-$past_day,$dueYear));
    $dueDateSecs = strtotime($dueDate);

    $customerBillingDate = date('d',strtotime($dueDate));
                    
    if(date('d') < $customerBillingDate){
        $mStart = date('m')-1;//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }elseif(date('d') == $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }elseif(date('d') > $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $billingDate = date('d');//25;
    }
    $currentDueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
    if($next_payment_due_date != "") {
        
        $datetime1 = new DateTime($dueDate);
        $datetime2 = new DateTime($currentDueDate);
        $interval = $datetime1-> diff($datetime2);                    
        $this->daysPastDue = $interval-> format('%d'); 
        $this->monthsPastDue = $interval-> format('%m'); 
        //$this->monthsPastDue++;
        if ($this->monthsPastDue > 0){
            $this->loadMonthlyPayment();
                                  //echo "test 1 d $this->daysPastDue m $this->monthsPastDue cd $currentDueDate dd $dueDate<br>";
        }else{
            $this->billingTotal = 0;
        }
        }elseif($next_payment_due_date == "") {
                                
                                $stmt1 = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key ='$this->contractKey'");
                                $stmt1->execute();      
                                $stmt1->store_result();      
                                $stmt1->bind_result($cycle_date);
                                $stmt1->fetch();
                                $stmt1->close();
   
                                 //create the past due day and monthly cycle date from monthly payment
                                 $cycle_day = date("d", strtotime($cycle_date));
                                 $pastDueDay = $this->pastDay + $cycle_day;
                                 $cycleMonth = date("m", strtotime($cycle_date));
                                 $cycleYear = date("Y", strtotime($cycle_date));
                                 $monthlyPaymentsDueDate= date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $cycleMonth, $pastDueDay, $cycleYear));
                                 $monthlyPaymentsDueDateSecs = strtotime($monthlyPaymentsDueDate);
                                 $todaysDateSecs = time();
                                 
                                  if($todaysDateSecs >= $monthlyPaymentsDueDateSecs) {      
                                       $datetime1 = new DateTime($monthlyPaymentsDueDate);
                                       $datetime2 = new DateTime($currentDueDate);
                                       $interval = $datetime1-> diff($datetime2);                    
                                       $this->daysPastDue = $interval-> format('%d'); 
                                       $this->monthsPastDue = $interval-> format('%m'); 
                                       //$this->monthsPastDue++;
                                       if ($this->monthsPastDue > 0){
                                        $this->loadMonthlyPayment();
                                        //echo "test2 d $this->daysPastDue m $this->monthsPastDue $this->contractKey<br>";
                                       }else{
                                            $this->billingTotal = 0;
                                        }
                                     }     
                                 
                               }
                          
}



$stmt = $dbMain ->prepare("SELECT DISTINCT group_type, group_number, club_id, service_name,  service_quantity, service_term,  group_price, group_renew_rate, start_date, end_date, user_id FROM paid_full_services WHERE contract_key ='$this->contractKey' AND service_key='$this->selectedServiceKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_number, $club_id, $service_name, $service_quantity, $service_term, $group_price, $group_renew_rate, $start_date, $end_date, $user_id);
$stmt->fetch();
 //echo"fubar $this->renewType";
 if($this->renewType != 'P'){
    $this->groupNumber = $group_number;
 
    $this->clubId = $club_id; 
    $this->loadClubName();
    
    $this->serviceName = $service_name;
    $this->serviceQuantity = $service_quantity;
    $this->serviceTerm = $service_term;
    //sets term as string
    $this->parseServiceTerm();
    
    $this->groupPrice = $group_price;
    
    if($this->renewType == 'X'){
        $this->loadServicePriceExpired();
        $this->groupRenewRate = sprintf("%01.2f",$this->expiredServiceCost);
        $this->selectedRenewRate = sprintf("%01.2f",$this->expiredServiceCost);
    }else{
        $this->groupRenewRate = sprintf("%01.2f",$group_renew_rate);
        $this->selectedRenewRate = sprintf("%01.2f",$group_renew_rate);
    }
    
    $this->startDate = $start_date;
    
    
    
    $this->commissionId = $user_id;
    $this->checkCommissionCredit();
    
    //parse to english the end date
    $end_date  = strtotime($end_date);
    $this->endDate = date("F j, Y", $end_date);
    $this->pifBool = 0;
    }else{
        $this->pifBool = 1;
        //echo"fubar";
        $this->loadMonthlyService();
        $this->loadPifOutService();
        $this->groupNumber = $this->group_numberMonthly;
        $this->clubId = $this->club_idMonthly; 
        $this->loadClubName();
        
         
        $this->serviceName = $this->serviceTypePifOut;
        $this->serviceQuantity = $this->serviceQuantityPifOut;
        $this->serviceTerm = $this->serviceTermPifOut;
        //sets term as string
        $this->parseServiceTerm();
        
        $this->groupPrice = sprintf("%01.2f", $this->group_priceMonthly/$this->number_monthsMonthly);
        
        $this->groupRenewRate = sprintf("%01.2f", $this->serviceCostPifOut + $this->moneyOwed + $this->billingTotal);
        $this->selectedRenewRate = sprintf("%01.2f", $this->serviceCostPifOut + $this->moneyOwed + $this->billingTotal);
        
        $this->commissionId = $this->user_idMonthly;
        $this->checkCommissionCredit();
        
        $end_date  = strtotime($this->end_dateMonthly);
        $this->endDate = date("F j, Y", $end_date);
        if ($this->timeOwed == '0'){
            $this->pifOutText = "&nbsp;$this->timeOwed Months left on your term. $$this->moneyOwed added.";
        }else{
            $this->pifOutText = "&nbsp;$this->timeOwed Months left on your term. $$this->moneyOwed added.";
        }
        
    }
 

$this->color = '#ffffff';
$this->checked = 'checked';
$this->serviceKey = $this->selectedServiceKey;
$this->j = 0;



$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
$this->tableFooter = "</table>";

//parse the listing
$primary_listing = $this->createListing();
$this->primaryListing = "$this->tableHeader $this->listHeader $primary_listing $this->tableFooter";
//used to preset the early renew for js script
$this->earlyType = $this->earlyField;


$this->loadSecondaryListings();

}

//ORDER BY contract_date DESC LIMIT 1
//AND contract_date = ( select max(contract_date) FROM contract_info)"
//==========================================================================
function loadAccountHolder()   {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, license_number FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $license_number);
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
$this->licenseNumber = $license_number;

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
<td align="left"  valign ="middle"class="keyText2">$this->groupType</td>
</tr>

$this->groupRows

<tr>
<td align="left" valign ="middle" class="keyText">Host Name:</td>
<td align="left"  valign ="middle"class="keyText2">$this->firstName   $this->middleName  $this->lastName</td>
</tr>
<tr>
<td align="left" valign ="top" class="keyText" rowspan="2">Host Address:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="street_address" type="text" id="street_address" value="$this->streetAddress" size="25" maxlength="50" onClick="return checkServices(this.name,this.id)" disabled="disabled" /> <input name="city" type="text" id="city" value="$this->city" size="25" maxlength="30" onClick="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>
<tr>

<td align="left"  valign ="middle"class="keyText2">
$this->stateList
<input name="zip" type="text" id="zip" value="$this->zipCode" size="10" maxlength="5" onClick="return checkServices(this.name,this.id)" disabled="disabled"/>
</td>
</tr>

<tr>
<td align="left" valign ="middle" class="keyText">Phone Numbers:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="primary_phone" type="text" id="primary_phone" value="$this->primaryPhone" size="20" maxlength="25" onClick="return checkServices(this.name,this.id)" disabled="disabled"/> <input name="cell_phone" type="text" id="cell_phone" value="$this->cellPhone" size="20" maxlength="25" onClick="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>



<tr>
<td align="left" valign ="middle" class="keyText">Email Address:</td>
<td align="left"  valign ="middle"class="keyText2"><input name="email" type="text" id="email" value="$this->emailAddress" size="20" maxlength="25" onClick="return checkServices(this.name,this.id)" disabled="disabled"/></td>
</tr>
</table>
ACCOUNTINFO;


//SELECT something, anything, but , please, not, the , dreaded , evil , "select star" FROM my_table WHERE my_date = ( select max(my_date) from my_table )
//AND contract_date = ( select max(contract_date) FROM contract_info)


}
//===========================================================================

function getContractKey() {
             return($this->contractKey);
             }
function getAccountInfo() {
             return($this->accountInfo);
             }
function getSelectedRenewRate() {
            return($this->selectedRenewRate);
            }
             
function getListHeader() {
             return($this->listHeader);
             }
function getPrimaryListing() {
             return($this->primaryListing);
             }
function getSecondaryListings() {
             return($this->secondaryListings);
             }
             
function getGroupMarker() {
             return($this->groupMarker);
             }
function getGroupAddress() {
             return($this->groupAddress);
             }
function getGroupPhone() {
             return($this->groupPhone);
             }
function getGroupName() {
             return($this->groupName);
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
function getGroupType() {
             return($this->groupType);
             }      
function getRenewalFee() {
             return($this->renewalFee);
             }                    
function getFieldCount() {
            return($this->fieldCount);
            }
function getEarlyType() {
            return($this->earlyType);
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
         
//this is for the printed contracts
function getFirstName() {
         return($this->firstName);
         }
function getMiddleName() {
         return($this->middleName);
         }         
function getLastName() {
         return($this->lastName);
         }
function getPifOutText(){
         return($this->pifOutText);
         }
function getPifOutBool(){
          return($this->pifBool);
          }
function getPifOutTimeOwed(){
         return($this->timeOwed);
         }
function getPifOutMoneyOwed(){
          return($this->moneyOwed);
          }          
function getEarlyTest(){
          return($this->earlyTest);
          }
function getQuantity(){
          return($this->serviceQuantity);
          } 
function getPastDueAmount(){
          return($this->billingTotal);
          }           

}
?>