<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class loadAccountInfo{

private $contractKey =  null;
private $memberId = null;
private $association = null;
private $holderName = null;
private $accountStatus = null;
private $serviceDuration = null;
private $serviceTerm = null;
private $serviceKey = null;
private $serviceName = null;
private $clubId = null;
private $serviceList = null;
private $cssClass = null;
private $serviceEndDate = null;
private $graceQ = null;
private $earlyRenewalGrace = null;
private $earlyRenewalPercent = null;
private $graceQTwo =null;
private $canceled = null;
private $holderFirst = null;
private $holderMiddle = null;
private $holderLast = null;
private $holderDob = null;
private $paymentAccess = null;
private $memberBit = null;

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
//==============================================================================
function loadPaymentAccess() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, dob FROM member_info WHERE  contract_key = '$this->contractKey' AND member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($first_name, $middle_name, $last_name, $dob);
 $stmt->fetch();

if(($first_name == "$this->holderFirst") && ($middle_name == "$this->holderMiddle") && ($last_name ==  "$this->holderLast") && ($dob == "$this->holderDob")) {  
  $this->paymentAccess = 'Y';
  }else{
  $this->paymentAccess = 'Y';
  }



if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function checkEarlyRenewalStatus()  {

$todaysDate = date("Y-m-d");
$end_date = strtotime($this->serviceEndDate); 
$todaysDate = strtotime($todaysDate);
$early_grace = strtotime($this->earlyRenewalGrace);

if(($end_date > $todaysDate) && ($end_date <= $early_grace)) {
    $this->graceQTwo = " <span class=\"renewal\">Early Renewal Available</span>";  
    }else{
    $this->graceQTwo = null;
    }
      
}
//-----------------------------------------------------------------------------------------------------------------------------------------
function checkPastGrace() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT standard_renewal_grace, early_renewal_grace, early_renewal_percent FROM fees WHERE fee_num ='1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day, $grace_days, $early_renewal_percent);
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
           $this->cssClass = 'greyOne';
          
              if($todays_date > $end_grace_date) {
                 $this->cssClass = 'greyOne';
                 $this->graceQ = null;
                }else{
                 $this->cssClass = 'greyOne';
                 $this->graceQ = " <span class=\"renewal\">Renewal Available</span>";
               }                     
         }      


//sets up for early renewal grace
$graceDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m"), date("d")+$grace_days, date("Y")));
$this->earlyRenewalGrace = $graceDate;
$this->earlyRenewalPercent = $early_renewal_percent;
      
           
 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       
      
}
//-------------------------------------------------------------------------------------------------------------
function checkEligibleRenewal()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT  MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();
 
 
 if($rowCount != 0) { 
        $this->serviceEndDate = $end_date;
        $this->checkPastGrace();          
   }

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;
 
    switch ($this->accountStatus) {
        case "CU":
        $this->cssClass = 'blackTwo';  
        $this->canceled = null;
        break;
        case "EX":
        $this->cssClass = 'greyOne';  
        $this->canceled = null;
        break;
        case "HO":
        $this->cssClass = 'redOne';
        $this->canceled = null;
        break;
        case "CA":
        $this->cssClass = 'blueOne'; 
        $this->canceled = " <span class=\"$this->cssClass\">Service Canceled</span>";
        break;
      }
  

 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function loadAssociation() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT group_type, group_name FROM member_groups WHERE contract_key = '$this->contractKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($group_type, $group_name);
   $stmt->fetch();

 switch ($group_type) {
        case "S":
              if($this->memberBit == 1) {                 
                 $this->association = "Single Membership";
                 }else{
                 $this->association = "Single Services";
                 }
        break;
        case "F":
              if($this->memberBit == 1) {                 
                 $this->association = "Family Membership";
                 }else{
                 $this->association = "Family Services";
                 }
        break;
        case "B":
               $this->association = "$group_name";
        break;  
        case "O":
               $this->association = "$group_name";
        break;        
   } 
   
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-------------------------------------------------------------------------------------------------------------------------------------------
function loadContractHolder() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, dob FROM contract_info WHERE  contract_key = '$this->contractKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($first_name, $middle_name, $last_name, $dob);
 $stmt->fetch();
 
 $this->holderFirst = $first_name;
 $this->holderMiddle = $middle_name;
 $this->holderLast = $last_name;
 $this->holderDob = $dob;

 $this->holderName = "$first_name $middle_name $last_name";

    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    


}
//------------------------------------------------------------------------------------------------------------------------------------------
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  service_quantity, service_term, club_id, end_date, start_date FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $service_quantity, $service_term, $club_id, $end_date, $start_date);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                        $service_name = trim($service_name);
                        if ($service_name != ''){
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;
                               $this->serviceName = $service_name;  
                               $this->clubId = $club_id;                              
                               $endDate = date('m/d/Y', strtotime($end_date));
                               $startDate = date('m/d/Y', strtotime($start_date));
                               
                                  if(preg_match("/Membership/i", $this->serviceName)) {
                                     $this->memberBit = 1; 
                                     }
                                                                                                                                                    
                               $this->checkAccountStatus();
                               
                                  //make sure the account has not already been canceld or is on hold                         
                                  if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                               
                                         if($this->serviceTerm != 'C') {
                                             $this->checkEligibleRenewal();
                                             }else{
                                              $this->graceQ = null;
                                              $this->graceQTwo = null;
                                              $endDate = 'NA';
                                             }
                                                 
                                         if($this->earlyRenewalPercent != 0) {                                          
                                            $this->checkEarlyRenewalStatus(); 
                                            }                                          
                                          
                                     }   
                                     
                             $this->serviceList .= "<span class=\"$this->cssClass\">$this->serviceName (Start $startDate)-(End $endDate)</span> $this->graceQ $this->graceQTwo $this->canceled<br>";                                                     
                             
                                    } 
                                                             
                             } //end while
                             
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------------
function loadMonthlyServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  number_months, club_id, end_date, start_date, service_id FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $number_months, $club_id, $end_date, $start_date, $service_id);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
                $this->monthlyServicesBool = 0;
               }else{
                
                    while ($stmt->fetch()) {  
                        $stmt99 = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$service_key' AND service_id = '$service_id'");
                        $stmt99->execute();      
                        $stmt99->store_result();   
                        $stmt99->bind_result($account_status);
                        $stmt99->fetch();
                        $stmt99->close();
                        //echo "account status $account_status $this->contractKey $service_key $service_id";
                        if ($account_status == 'CU'){
                            $this->monthlyServicesBool = 1;
                        }else{
                            $this->monthlyServicesBool = 0;
                        }
                        $service_name = trim($service_name);
                        if ($service_name != ''){
                            
                        
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $number_months;
                               $this->serviceTerm = 'M';
                               $this->serviceName = $service_name;
                               $this->clubId = $club_id;
                               $endDate = date('m/d/Y', strtotime($end_date));
                               $startDate = date('m/d/Y', strtotime($start_date));
                               
                                  if(preg_match("/Membership/i", $this->serviceName)) {
                                     $this->memberBit = 1; 
                                     }                               
                               
                               $this->checkAccountStatus();
                                                                                                  
                               $this->serviceList .= "<span class=\"$this->cssClass\">$this->serviceName (Start $startDate)-(End $endDate)</span> $this->canceled<br>";  
                              }
                             }
               }
               
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      

}         
//=============================================================================             
function loadMonthlyPayment() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT monthly_billing_type, billing_amount FROM monthly_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->monthlyBillingType, $this->billingAmount);
$stmt->fetch();
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      
//echo "fubar$this->monthlyBillingType, $this->billingAmount";
}                      
//------------------------------------------------------------------------------------------------------------------------------------------
function loadAccount() {

$this->loadContractHolder();
$this->loadPifServices();
$this->loadMonthlyServices();
$this->loadAssociation();
$this->loadMonthlyPayment();

}
//===============================================================================
function getAssociation() {
     return($this->association);
     }
function getHolderName() {
     return($this->holderName);
     }
function getServiceList() {
     return($this->serviceList);
     }
function getPaymentAccess() {
     return($this->paymentAccess);
     }
function getMonthlyServicesBool(){
    return ($this->monthlyServicesBool);
    }
function getMonthlyBillingType(){
    return ($this->monthlyBillingType);
    }
function getMonthlyPaymentAmount(){
    return ($this->billingAmount);
    }
    



}