<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  prePaymentsSqlTwo{

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
private $currentServices = null;

private $monthlyBillingDay = null;
private $prepayForm = null;
private $billingDateArray = "0|";
private $prepayContent = null;
private $paymentForm = null;
private $yearDrop = null;
private $monthDrop = null;
private $styleSheet = null;



function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }    




//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//--------------------------------------------------------------------------------------------------------------------------
function stateSelect() {
require "../helper_apps/stateSelect.php";
}
//---------------------------------------------------------------------------------------------------------------------------------------------
function loadCommissionCredit()   {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_id FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id);
 $stmt->fetch();

$this->commissionCredit = $user_id;

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
	printf("Error: %s.\n", $stmt->error);
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
	printf("Error: %s.\n", $stmt->error);
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
     $this->endDate = date("M j, Y", $end_date);
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
	printf("Error: %s.\n", $stmt->error);
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
	printf("Error: %s.\n", $stmt->error);
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
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$this->tableHeader = "<table align=\"left\" class=\"tablePre\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >";
$this->tableFooter = "</table>";
$this->currentServices = "$this->tableHeader  $this->existingListHeader  $this->monthlyServices $this->tableFooter";

}
//-------------------------------------------------------------------------------------------------------------------
function loadBillingDay() {

$dbMain = $this->dbconnect();
/*
   $stmt = $dbMain ->prepare("SELECT cycle_day FROM billing_cycle WHERE cycle_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cycle_day);
   $stmt->fetch();
*/ 
   $stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cycle_date);
   $stmt->fetch();

   $cycle_day = date("j", strtotime($cycle_date));

   $this->monthlyBillingDay = $cycle_day;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

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
                    <select  name=\"num_months_rate\" id=\"num_months_rate\" $disabled/><option value=\"\" >Select</option>$monthOptions</select>
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
                    <select  name=\"num_months_enhance\" id=\"num_months_enhance\" $disabled/><option value=\"\" >Select</option>$monthOptions</select>
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
                    <select  name=\"num_months_m\" id=\"num_months_m\" $disabled/><option value=\"\" >Select</option>$monthOptions</select>
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
//-------------------------------------------------------------------------------------------------------------------
function loadPrePaymentDuration() {

$this->loadBillingDay();
$this->loadMaint();
$this->loadGuarentee();
$this->loadEnhance();
$todaysDay = date("j");
$todaysDate = date("Y-m-d");

$dbMain = $this->dbconnect();

//check the date of the prepay to make sure the client is not double charged
if($todaysDay >= $this->monthlyBillingDay) {
    $d = new DateTime($todaysDate);
    $d->modify( 'first day of next month' );
    $firstOfBillingMonth =  $d->format( 'Y-m-d' ); 
    $j = 2; 
   }

if($todaysDay < $this->monthlyBillingDay) {
    $d = new DateTime($todaysDate);
    $d->modify( 'first day of this month' );
    $firstOfBillingMonth =  $d->format( 'Y-m-d' );
    $j = 1; 
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
<table align=\"left\" class=\"tablePre\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\" >
<form id=\"form2\">
<tr>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Current Monthly Payment</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Select Prepaid Months</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Prepaid Total</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Next Payment Due</th>
</tr>

<tr>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
$this->monthlyPayment
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
<select  name=\"num_months\" id=\"num_months2\" /><option value=\"\" >Select</option>$monthOptions</select>
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\">
<input name=\"prepay_total\" type=\"text\" id=\"prepay_total2\" size=\"9\" maxlength=\"10\" readonly=\"readonly\"/>
</td>
<td align=\"left\" valign =\"middle\" class=\"keyText3\" id=\"next_payment2\">
$currentDate
</td>
</tr>
$this->prepayFormRate
$this->prepayFormEnhance
$this->prepayFormM
<input type=\"hidden\" name=\"current_month_date\"  id=\"current_month_date\" value=\"$currentDate\"/>
</table>
<div class=totalBox>
Total Owed:<input name=\"prepay_total_combined\" type=\"text\" id=\"prepay_total_combined\" size=\"9\" maxlength=\"10\" readonly=\"readonly\"/>
</div>
";          
            


}

//------------------------------------------------------------------------------------------------------------------- 
function createForm() {

if($this->monthlyServices != "") {

$this->loadPaymentForm();
$this->styleSheet = "<link rel=\"stylesheet\" href=\"../css/accountInfoThree.css\">";

$this->prepayContent = "
<div id=\"innerOne\">
<span class=\"greyTwo\">
<u>Current Monthly Services</u>
</span>
<span class=\"closeFour\">X</span>
</div>

<div id=\"accountResults\">
$this->currentServices
</div>

<div id=\"innerTwo\">
<span class=\"greyTwo\">
<u>Pre Payment Duration</u>
</span>
</div>

<div id=\"preForm\">
$this->prepayForm
</div>

<div id=\"innerThree\">
<span class=\"greyTwo\">
<u>Payment Options</u>
</span>
</div>

<div id=\"payHouse\">
$this->paymentForm
</div>";
}else{

$this->styleSheet = "<link rel=\"stylesheet\" href=\"../css/accountInfoTwo.css\">";
$this->prepayContent = "";

}



}
//-------------------------------------------------------------------------------------------------------------------
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
<select  name="card_month" id="card_month2"/>
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
<select  name="card_year" id="card_year2"/>
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
<input name="card_name" type="text" id="card_name2" value="$card_name" size="25" maxlength="300"/>
</td>
<td class="black2">
Card Type:
</td>
<td class="tile4">
<select name="card_type" id="card_type2"/>
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
<input  name="card_number" type="text" id="card_number2" value="$card_number" size="25" maxlength="22"/>
</td>
<td class="black2">
Security Code:
</td>
<td class="tile4">
<input name="card_cvv" type="text" id="card_cvv2" value="$card_cvv" size="25" maxlength="4"/>
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
<input name="credit_pay" type="text" id="credit_pay2" value="" size="25" maxlength="10"/>
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
<input name="cash_pay2" type="text" id="cash_pay2" value="" size="25" maxlength="10"/>
</td>
<td class="black2 tile5">
Check Payment / Number:
</td>
<td class="tile4 tile5">
<input  name="check_pay2" type="text" id="check_pay2" value="" size="12" maxlength="10"/>
&nbsp;
<input name="check_number" type="text" id="check_number2" value="" size="9" maxlength="10"/>
</td>
</tr>


<tr>
<td class="tabPad4" align="left" colspan= "4">
<input type="button" name="update2" id="update2" value="Process Pre Payment" class="button1" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="receipt" value="Print Receipt" class="button1 re" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="reload" value="Reload Account" class="button1 rl" />
<input type="hidden" id="contract_key2" name="contract_key" value="$this->contractKey"/>
<input type="hidden" name="monthly_payment"  id="monthly_payment" value="$this->monthlyPayment"/>
<input type="hidden" name="billing_date_array"  id="billing_date_array" value="$this->billingDateArray"/>
<input type="hidden" name="prepay_restart_date"  id="prepay_restart_date" value=""/>
<input type="hidden" name="key_list"  id="key_list2" value="$this->keyList"/>
<input type="hidden" name="bool"  id="bool2" value="0"/>
<input type="hidden" id="purchase_marker2" name="purchase_marker" value=""/>
<input type="hidden" name="rate_fee"  id="rate_fee" value="$this->rateFee"/>
<input type="hidden" name="rate_date_array"  id="rate_date_array" value="$this->rateDateArray"/>
<input type="hidden" name="prepay_restart_date_rate"  id="prepay_restart_date_rate" value=""/>

<input type="hidden" name="m_fee"  id="m_fee" value="$this->mfee"/>
<input type="hidden" name="m_date_array"  id="m_date_array" value="$this->mDateArray"/>
<input type="hidden" name="prepay_restart_date_m"  id="prepay_restart_date_m" value=""/>

<input type="hidden" name="enhance_fee"  id="enhance_fee" value="$this->enhancefee"/>
<input type="hidden" name="enhance_date_array"  id="enhance_date_array" value="$this->enhanceDateArray"/>
<input type="hidden" name="prepay_restart_date_enhance"  id="prepay_restart_date_enhance" value=""/>

</form>
</td>
</tr>
</table>

PAYMENTFORM;

}


//------------------------------------------------------------------------------------------------------------------
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
function getKeyList() {
             return($this->keyList);
             }
function getPrePayContent() {
             return($this->prepayContent);
             }
function getStyleSheet() {
             return($this->styleSheet);
             }


}//end class
?>