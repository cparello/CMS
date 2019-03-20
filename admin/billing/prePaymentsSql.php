<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


//date_default_timezone_set('America/Los_Angeles');
class  prePaymentsSql{

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

private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;
private $groupType = null;
private $groupTypeHeader = null;
private $groupRows = null;


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

private $commissionCredit = null;
private $commissionId = null;
private $accountInfo = null;
private $accountStatus = null;
private $serviceCount = 0;

private $keyList = null;
private $fieldCount = 1;
private $monthlyPayment = null;
private $monthlyBillingType = null;
private $monthlySignupDate = null;
private $monthlyServices = null;
private $monthGovernor = null;
private $serviceType = null;
private $groupNumber = null;
private $clubId = null;
private $groupPrice = null;
private $groupRenewRate = null;

private $serviceKey = null;
private $serviceLocation = null;
private $serviceName = null;
private $serviceQuantity = null;
private $serviceTerm = null;
private $termType = null;
private $startDate = null;
private $endDate = null;
private $serviceEndDate = null;
private $monthEndDate = null;
private $proFieldCount = null;
private $existingListHeader = null;
private $tableHeader = null;
private $tableFooter = null;

private $monthlyBillingDay = null;
private $prepayForm = null;
private $billingDateArray = "0|";



function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }    




//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//--------------------------------------------------------------------------------------------------------------------------
function loadGroupInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_name, group_address, group_phone FROM member_groups WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_name, $group_address, $group_phone);
$stmt->fetch();
$rowCount = $stmt->num_rows;

$this->groupAddress = $group_address;
$this->groupPhone = $group_phone;
$this->groupName = $group_name;


switch($group_type) {          
             case"S":
             $this->groupType = 'S';
             $this->groupTypeHeader = 'Single';            
             break;
             case"F":
             $this->groupType = 'F';
             $this->groupTypeHeader = 'Family';
             break;
             case"B":
             $this->groupType = 'B';
             $this->groupTypeHeader = 'Business';
             break;
             case"O":
             $this->groupType = 'O';
             $this->groupTypeHeader = 'Organization';
             break;
             }


if($this->groupType == 'B' || $this->groupType == 'O') {
$this->groupRows = "
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Name:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\">$group_name</td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Address:</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText2\">$this->groupAddress</td>
</tr>
<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupTypeHeader Phone:</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText2\">$this->groupPhone</td>
</tr>";
}   

$stmt->close(); 
}
//---------------------------------------------------------------------------------------------------------------------------------------------
function stateSelect() {
require "../helper_apps/stateSelect.php";
}
//---------------------------------------------------------------------------------------------------------------------------------------------
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

//------------------------------------------------------------------------------------------------------------------------------------------------
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
$this->licenseNumber = $license_number;

//this gets any prvious payment types like cc info and ach
$this->loadPaymentTypes();

$this->loadGroupInfo();


$this->accountInfo = <<<ACCOUNTINFO
<table align="left"  border="0" cellspacing="2" cellpadding="2" width=100% >
<tr>
<th align="left"  class="tabHeader1" colspan="2">
Account Holder Information
</th>
<tr>

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
<td align="left"  valign ="middle"class="keyText2">$this->firstName  $this->middleName  $this->lastName</td>
</tr>
<tr>
<td align="left" valign ="top" class="keyText">Host Address:</td>
<td align="left"  valign ="middle"class="keyText2">$this->streetAddress $this->city, $this->state $this->zipCode</td>
</tr>


<tr>
<td align="left" valign ="middle" class="keyText">Phone Numbers:</td>
<td align="left"  valign ="middle"class="keyText2">H. $this->primaryPhone &nbsp;&nbsp; C. $this->cellPhone</td>
</tr>

<tr>
<td align="left" valign ="middle" class="keyText">Email Address:</td>
<td align="left"  valign ="middle"class="keyText2">$this->emailAddress</td>
</tr>
</table>
ACCOUNTINFO;


}
//-------------------------------------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_id='$this->serviceId'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;

 
    if(!$stmt->execute())  {
	printf("Error: 11111%s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-------------------------------------------------------------------------------------------------------------------
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
//-------------------------------------------------------------------------------------------------------------------
function loadClubName() {

$dbMain = $this->dbconnect();
$result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                 $this->serviceLocation = $row[0];
                                                               
                    if($this->serviceLocation == "0")  {
                        $this->serviceLocation = 'All Locations';
                      }
//$result->close(); 
}

//-------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

 if(!$stmt->execute())  {
	printf("Error: 222222%s.\n", $stmt->error);
      }
   
$stmt->close();  

}
//-------------------------------------------------------------------------------------------------------------------
function createExistingListing() {


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
</tr>";



$listing = "
<tr id=\"a$this->fieldCount\" style=\"background-color: $this->color\">
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->fieldCount.</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->serviceLocation</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->serviceName</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->serviceType</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->serviceQuantity $this->serviceTerm</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->groupNumber</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->groupPrice</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->groupRenewRate</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->endDate</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">$this->commissionCredit</td>
</tr>";

return "$listing";

}
//------------------------------------------------------------------------------------------------------------------
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
$this->loadMonthlyPayment();
$this->monthlySignupDate = $signup_date;
$this->monthlyDues = $monthly_dues;

//this sets up the number of months for upgrade list available
$this->monthGovernor = $number_months;

$this->serviceType = 'Monthly';
$this->groupNumber = $group_number;
$this->clubId = $club_id; 
$this->loadClubName();
$this->serviceName = $service_name;
$this->serviceQuantity = $number_months;
$this->serviceTerm = 'Month(s)';
$this->termType = $term_type;
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
if($end_date == "0000-00-00")  {
   $this->serviceEndDate = "0000-00-00";
   $this->endDate = 'NA';
   }else{
    //parse to english the end date
     $this->serviceEndDate = $end_date;
     $end_date  = strtotime($end_date);
     $this->endDate = date("F j, Y", $end_date);
     $this->monthEndDate = $end_date;
   }


$this->checkAccountStatus();
                               
     //make sure the account has not already been canceld or is on hold  or expired                      
 if(($this->accountStatus != "CA") &&  ($this->accountStatus != "EX")) {  
         $this->monthlyServices .= $this->createExistingListing();
         }else{
         $this->sqlSwap = "AND service_id != '$this->serviceId'  ";  
         $this->loadMonthlyServices();
         }  
      

   if(!$stmt->execute())  {
	printf("Error: 33333%s.\n", $stmt->error);
      }


$stmt->close(); 

}
$this->sqlSwap = null;
}

//-------------------------------------------------------------------------------------------------------------------
function checkAccountStatusFull()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
if($account_status == 'CA') {
   return $account_status;
  }
  
 
    if(!$stmt->execute())  {
	printf("Error: 444444%s.\n", $stmt->error);
      }
   
$stmt->close();    


}
//-------------------------------------------------------------------------------------------------------------------
function loadCurrentListings()  {

$dbMain = $this->dbconnect();

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
                             
                             $cancelValue = $this->checkAccountStatusFull();
                             if($cancelValue != 'CA') {
                                 $this->loadMonthlyServices();  
                                 $this->fieldCount++;
                                 }
                             }                                
               }

   if(!$stmt->execute())  {
	printf("Error:555555 %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$this->tableHeader = "<table align=\"left\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
$this->tableFooter = "</table>";
$this->currentServices = "$this->tableHeader  $this->existingListHeader  $this->monthlyServices $this->tableFooter";

}
//-------------------------------------------------------------------------------------------------------------------
function loadBillingDay() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
if(!$stmt->execute())  {
	printf("Error: 666666%s.\n", $stmt->error);
   }      
$stmt->store_result();      
$stmt->bind_result($cycle_date);   
$stmt->fetch(); 
$stmt->close();
   
$this->monthlyBillingDay = date("d", strtotime($cycle_date));
}

//-------------------------------------------------------------------------------------------------------------------
function loadPrePaymentDuration() {

$this->loadBillingDay();

$todaysDay = date("j");
$todaysDate = date("Y-m-d");

$dbMain = $this->dbconnect();

//check the date of the prepay to make sure the client is not double charged
if($todaysDay > $this->monthlyBillingDay) {
    $d = new DateTime($todaysDate);
    $d->modify( 'first day of next month' );
    $firstOfBillingMonth =  $d->format( 'Y-m-d' );   
    $x = 1;
   }

if($todaysDay <= $this->monthlyBillingDay) {
    $d = new DateTime($todaysDate);
    $d->modify( 'first day of this month' );
    $firstOfBillingMonth =  $d->format( 'Y-m-d' );   
    $x = 0;
   }


    $datetime1 = new DateTime($firstOfBillingMonth);
    $datetime2 = new DateTime($this->endDate);
    $interval = $datetime1-> diff($datetime2);                    
    $month_num = $interval-> format('%m');
    
    $stmt = $dbMain ->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key ='$this->contractKey'");
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
    
    $stmt999 = $dbMain->prepare("SELECT DAY(cycle_date) FROM monthly_payments  WHERE contract_key = '$this->contractKey'");//>=
    if(!$stmt999->execute())  {
                            	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                                  }	      
    $stmt999->store_result();      
    $stmt999->bind_result($customerBillingDate); 
    $stmt999->fetch();
    $stmt999->close();
    
     $day = date('d');
                    
                    if($day < $customerBillingDate){
                        $mStart = date('m')-1;//8;
                        
                    }elseif($day == $customerBillingDate){
                        $mStart = date('m');//8;
                       
                    }elseif($day > $customerBillingDate){
                        $mStart = date('m');//8;
                        
                    }
                    $dueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate+$past_day, date('Y')));
                    if(strtotime($dueDate) > strtotime($next_payment_due_date)){
                        $this->pastDueFlag = 1;
                    }else{
                        $this->pastDueFlag = 0;
                    }
    
    $stmt = $dbMain ->prepare("SELECT count(*) as count, restart_date FROM pre_payments WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count, $restart_date);
    $stmt->fetch();
    $stmt->close();
    
    if($count == 0){
        // if($month_num == 0 ) {
       $month_num  = 6;
   //   }else{
      // $j = 2;
          for($i=1; $i <= $month_num; $i++) {
               $monthOptions .= "<option value=\"$i\" >$i</option>";     
               
               $billingDate = date("F j, Y"  ,mktime(23, 59, 59, date("m")+$x+$i  , $this->monthlyBillingDay, date("Y")));
               $this->billingDateArray .="$billingDate|";
           //    $j++;
               }
               $currentDate = date('F j, Y',mktime(0,0,0,date('m',strtotime($next_payment_due_date)),date('d',strtotime($next_payment_due_date))-$past_day,date('Y',strtotime($next_payment_due_date))));
    //  }
    }else{
         // if($month_num == 0 ) {
       $month_num  = 6;
   //   }else{
      // $j = 2;
          for($i=1; $i <= $month_num; $i++) {
               $monthOptions .= "<option value=\"$i\" >$i</option>";     
               
               $billingDate = date("F j, Y"  ,mktime(23, 59, 59, date("m",strtotime($restart_date))+$x+$i  , $this->monthlyBillingDay, date("Y")));
               $this->billingDateArray .="$billingDate|";
           //    $j++;
               }
                $currentDate = date('F j, Y',strtotime($restart_date));
    //  }
    }
    
   
    
            
$this->prepayForm  = "


<tr>
<th align=\"left\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Monthly Payment</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Select Prepaid Months</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Monthly Total</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Next Payment Due</th>
</tr>

<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
$this->monthlyPayment
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
<select  name=\"num_months\" id=\"num_months\" onChange = \"setPrePayTotal(this);\"/><option value=\"\" >Select</option>$monthOptions</select>
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
<input name=\"prepay_total\" type=\"text\" id=\"prepay_total\" size=\"9\" maxlength=\"10\" readonly=\"readonly\"/>
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\" id=\"next_payment\">
$currentDate
</td>
</tr>
<input type=\"hidden\" name=\"current_month_date\"  id=\"current_month_date\" value=\"$currentDate\"/>

";          
            


}
//-------------------------------------------------------------------------------------------------------------------
function loadGuarentee() {

$dbMain = $this->dbconnect();

    
$stmt = $dbMain ->prepare("SELECT count(*) as count, eft_cycle, eft_cycle_date, guarantee_fee FROM member_guarantee_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $eft_cycle, $eft_cycle_date, $guarenteeFee);
$stmt->fetch();
$stmt->close();
    
    if($count != 0){
        $currentDuedate = date('F j, Y',strtotime($eft_cycle_date));
        $disabled = "";
    }else{
        $currentDuedate = "Not Available";
        $disabled = "disabled";
    }
        
        $rateDay = date('d',strtotime($eft_cycle_date));
        $todaysSecs = time();
        $eftDateSecs = strtotime($eft_cycle_date);
    
        //check the date of the prepay to make sure the client is not double charged
        if($todaysSecs > $eftDateSecs) {
           //is cycle behind
           }
        
        switch($eft_cycle){
        case 'A':
            $month_num  = 1;
            $x=12;
        break;
        case 'B':
            $guarenteeFee = sprintf("%01.2f", ($guarenteeFee/2));
            $month_num  = 2;
             $x=6;
        break;
        case 'Q':
            $guarenteeFee = sprintf("%01.2f", ($guarenteeFee/4));
            $month_num  = 4;
             $x=3;
        break;
        case 'M':
            $guarenteeFee = sprintf("%01.2f", ($guarenteeFee/12));
            $month_num  = 12;
             $x=1;
        break;
        }
          for($i=1; $i <= $month_num; $i++) {
               $monthOptions .= "<option value=\"$i\">$i</option>";     
               $buff=$x*$i;
               $billingDate = date("F j, Y"  ,mktime(23, 59, 59, date("m",strtotime($eft_cycle_date))+$buff  , $rateDay, date("Y",strtotime($eft_cycle_date))));
               $this->rateDateArray .="$billingDate|";
      
               }
               $this->ratefee = $guarenteeFee;
               $this->prepayFormRate  = "
                    
                    
                    <tr>
                    <th align=\"left\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Guarentee Fee Payment</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Select Prepaid Months</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Guarentee Total</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Next Payment Due</th>
                    </tr>
                    
                    <tr>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    $guarenteeFee
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <select  name=\"num_months_rate\" id=\"num_months_rate\" onChange = \"setRatePrePayTotal(this);\" $disabled/><option value=\"\" >Select</option>$monthOptions</select>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <input name=\"prepay_total_rate\" type=\"text\" id=\"prepay_total_rate\" size=\"9\" maxlength=\"10\" readonly=\"readonly\" $disabled/>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\" id=\"next_payment_rate\" $disabled>
                    $currentDuedate
                    </td>
                    </tr>
                    <input type=\"hidden\" name=\"current_rate_date\"  id=\"current_rate_date\" value=\"$currentDuedate\"/>
                    
                    ";          
   /* }else{
      //NOTHING
      $this->prepayFormRate  = "<input type=\"hidden\" name=\"prepay_total_rate\"  id=\"prepay_total_rate\" value=\"\"/>";
    }*/
    
}

//--------
//-------------------------------------------------------------------------------------------------------------------
function loadEnhance() {
            
$dbMain = $this->dbconnect();

    
$stmt = $dbMain ->prepare("SELECT count(*) as count, eft_cycle, eft_cycle_date, enhance_fee FROM member_enhance_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $eft_cycle, $eft_cycle_date, $enhanceFee);
$stmt->fetch();
$stmt->close();
    
    if($count != 0){
        $currentDuedate = date('F j, Y',strtotime($eft_cycle_date));
        $disabled = "";
    }else{
        $currentDuedate = "Not Available";
        $disabled = "disabled";
    }
        
        
        $enhanceDay = date('d',strtotime($eft_cycle_date));
        $todaysSecs = time();
        $eftDateSecs = strtotime($eft_cycle_date);
    
        //check the date of the prepay to make sure the client is not double charged
        if($todaysSecs > $eftDateSecs) {
           //is cycle behind
           }
        
        switch($eft_cycle){
        case 'A':
            $month_num  = 1;
            $x=12;
        break;
        case 'B':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/2));
            $month_num  = 2;
             $x=6;
        break;
        case 'Q':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/4));
            $month_num  = 4;
             $x=3;
        break;
        case 'M':
            $enhanceFee = sprintf("%01.2f", ($enhanceFee/12));
            $month_num  = 12;
             $x=1;
        break;
        }
          for($i=1; $i <= $month_num; $i++) {
               $monthOptions .= "<option value=\"$i\">$i</option>";     
               $buff=$x*$i;
               $billingDate = date("F j, Y"  ,mktime(23, 59, 59, date("m",strtotime($eft_cycle_date))+$buff  , $enhanceDay, date("Y",strtotime($eft_cycle_date))));
               $this->enhanceDateArray .="$billingDate|";
      
               }
               $this->ratefee = $enhanceFee;
               $this->prepayFormEnhance  = "
                    
                    
                    <tr>
                    <th align=\"left\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Enhance Fee Payment</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Select Prepaid Months</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Enhance Total</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Next Payment Due</th>
                    </tr>
                    
                    <tr>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    $enhanceFee
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <select  name=\"num_months_enhance\" id=\"num_months_enhance\" onChange = \"setEnhancePrePayTotal(this);\"/ $disabled><option value=\"\" >Select</option>$monthOptions</select>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <input name=\"prepay_total_enhance\" type=\"text\" id=\"prepay_total_enhance\" size=\"9\" maxlength=\"10\" readonly=\"readonly\"  $disabled/>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\" id=\"next_payment_enhance\"  $disabled>
                    $currentDuedate
                    </td>
                    </tr>
                   <input type=\"hidden\" name=\"current_enhance_date\"  id=\"current_enhance_date\" value=\"$currentDuedate\"/>
                    
                    ";          
    /*else{
      //NOTHING
      $this->prepayFormEnhance  = "<input type=\"hidden\" name=\"prepay_total_enhance\"  id=\"prepay_total_enhance\" value=\"\"/>";
    }*/
    
}

//--------
//-------------------------------------------------------------------------------------------------------------------
function loadMaint() {

$dbMain = $this->dbconnect();

    
$stmt = $dbMain ->prepare("SELECT count(*) as count, m_cycle, m_cycle_date, m_fee FROM member_maintnence_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $m_cycle, $m_cycle_date, $mFee);
$stmt->fetch();
$stmt->close();
    
    if($count != 0){
        $currentDuedate = date('F j, Y',strtotime($m_cycle_date));
        $disabled = "";
    }else{
        $currentDuedate = "Not Available";
        $disabled = "disabled";
    }
      //  $currentDuedate = date('F j, Y',strtotime($m_cycle_date));
        
        $mDay = date('d',strtotime($m_cycle_date));
        $todaysSecs = time();
        $mDateSecs = strtotime($m_cycle_date);
    
        //check the date of the prepay to make sure the client is not double charged
        if($todaysSecs > $mDateSecs) {
           //is cycle behind
           }
        
        switch($m_cycle){
        case 'A':
            $month_num  = 1;
            $x=12;
        break;
        case 'B':
            $mFee = sprintf("%01.2f", ($mFee/2));
            $month_num  = 2;
             $x=6;
        break;
        case 'Q':
            $mFee = sprintf("%01.2f", ($mFee/4));
            $month_num  = 4;
             $x=3;
        break;
        case 'M':
            $mFee = sprintf("%01.2f", ($mFee/12));
            $month_num  = 12;
             $x=1;
        break;
        }
          for($i=1; $i <= $month_num; $i++) {
               $monthOptions .= "<option value=\"$i\">$i</option>";     
               $buff=$x*$i;
               $billingDate = date("F j, Y"  ,mktime(23, 59, 59, date("m",strtotime($m_cycle_date))+$buff  , $mDay, date("Y",strtotime($m_cycle_date))));
               $this->mDateArray .="$billingDate|";
      
               }
               $this->mfee = $mFee;
               $this->prepayFormM  = "
                    
                   
                    <tr>
                    <th align=\"left\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Maintenance Fee Payment</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Select Prepaid Months</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Maintenance Total</th>
                    <th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Next Payment Due</th>
                    </tr>
                    
                    <tr>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    $mFee
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <select  name=\"num_months_m\" id=\"num_months_m\" onChange = \"setMaintPrePayTotal(this);\"  $disabled/><option value=\"\" >Select</option>$monthOptions</select>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\">
                    <input name=\"prepay_total_m\" type=\"text\" id=\"prepay_total_m\" size=\"9\" maxlength=\"10\" readonly=\"readonly\"  $disabled/>
                    </td>
                    <td align=\"left\" valign =\"middle\" class=\"keyText3\" id=\"next_payment_m\" $disabled>
                    $currentDuedate
                    </td>
                    </tr>
                    <input type=\"hidden\" name=\"current_m_date\"  id=\"current_m_date\" value=\"$currentDuedate\"/>
                   
                    ";          
   /* }else{
      //NOTHING
      $this->prepayFormM  = "<input type=\"hidden\" name=\"prepay_total_rate\"  id=\"prepay_total_rate\" value=\"\"/>";
    }*/
    
}

//--------
//-------------------------------------------------------------------------------------------------------------------
function getAccountInfo() {
             return($this->accountInfo);
             }             
function getCurrentServices() {
             return($this->currentServices);
             }             
function getPrepayForm() {
             return($this->prepayForm);
             } 
function getMonthlyPayment() {
             return($this->monthlyPayment);
             }              
function getBillingDateArray() {
             return($this->billingDateArray);
             } 

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
function getMonthlyPayments() {
         return($this->monthlyPayment);
         } 
function getMonthlyBillingType() {
         return($this->monthlyBillingType);
         }
function getGroupType() {
         return($this->groupType);
         }
function getKeyList() {
         return($this->keyList);
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
function getLicenseNumber() {         
         return($this->licenseNumber);
         }
function getEmailAddress() {         
         return($this->emailAddress);
         }
function getRateDateArray() {         
         return($this->rateDateArray);
         }
function getPrePayFormRate() {         
         return($this->prepayFormRate);
         }
function getRatefee() {         
         return($this->ratefee);
         }
         
function getMDateArray() {         
         return($this->mDateArray);
         }
function getPrePayFormM() {         
         return($this->prepayFormM);
         }
function getMfee() {         
         return($this->mfee);
         }
         
function getEnhanceDateArray() {         
         return($this->enhanceDateArray);
         }
function getPrePayFormEnhance() {         
         return($this->prepayFormEnhance);
         }
function getEnhancefee() {         
         return($this->enhancefee);
         }
function getPastDueFlag() {         
         return($this->pastDueFlag);
         }
}//end class
?>