<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout

class  accountDropList {

private  $searchSql = null;
private  $accountList = null;
private  $earlyRenewalGrace = null;
private  $earlyRenewalPercent = null;
private  $earlyAvailable = null;
private  $backGroundColor = null;
private  $elementDisabled = null;
private  $contractKey = null;
private  $firstName = null;
private  $middleName = null;
private  $lastName = null;
private  $streetAddress = null;
private  $city = null;
private  $state = null;
private  $zipCode = null;
private  $primaryPhone = null;
private  $emailAddress = null;
private  $renewButton = null;
private  $accountStatus = null;
private  $monthlyServices = null;
private  $pifServices = null;
private  $serviceTerm = null;
private  $cellCount = 1;
private  $fontClass = null;

function setSearchSql($searchSql) {
                 $this->searchSql = $searchSql;
              }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------------------------------
function checkPastGrace() {

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
           $this->backGroundColor = '#CCC'; 
           $this->fontClass = 'exText';
          
              if($todays_date > $end_grace_date) {
                 $this->renewButton = 'NA';
                 $this->earlyAvailable = 'NA';  
                 $this->upgradeButton = 'NA'; 
                 $this->expiredButton = "<input  type=\"button\" class=\"button1\" name=\"expired\" value=\"Expired\" onClick=\"return setRenewalRecord('$this->contractKey','$this->serviceKey', this.name);\"/>";
                }else{
                 $this->renewButton = "<input  type=\"button\" class=\"button1\" name=\"renewal\" value=\"Renewal\" onClick=\"return setRenewalRecord('$this->contractKey','$this->serviceKey', this.name);\"/>";
                 $this->earlyAvailable = "<input  type=\"button\" class=\"button1\" name=\"early_renewal\" value=\"Early Renewal\" onClick=\"return setRenewalRecord('$this->contractKey','$this->serviceKey', this.name);\" $this->elementDisabled />";
                 $this->upgradeButton = 'NA';
                 $this->expiredButton = 'NA';
               }                     
         }      
      
           
 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       
      
}
//----------------------------------------------------------------------------------------------------------------------------
function loadEarlyRenewalGrace() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT early_renewal_grace, early_renewal_percent FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($grace_days, $early_renewal_percent);
   $stmt->fetch();

$graceDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m"), date("d")+$grace_days, date("Y")));

$this->earlyRenewalGrace = $graceDate;
$this->earlyRenewalPercent = $early_renewal_percent;
   
$_SESSION['earlyRenewalGrace'] = $graceDate;
$_SESSION['earlyRenewalPercent'] = $early_renewal_percent;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//---------------------------------------------------------------------------------------------------------------------------
function checkEligibleRenewal()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT  MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();
 
 //echo"$rowCount $this->serviceKey <br>";
 
 
 if($rowCount != 0) { 
        $this->renewButton = "<input  type=\"button\" class=\"button1\" name=\"renewal\" value=\"Renewal\" onClick=\"return setRenewalRecord('$this->contractKey','$this->serviceKey', this.name);\"/>"; 
        $this->serviceEndDate = $end_date;
        $this->checkPastGrace();  
        if ($this->renewButton != 'NA'){
           $this->expiredButton = 'NA'; 
        }        
   }else{
        $this->renewButton = 'NA';
   }

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//----------------------------------------------------------------------------------------------------------------------------
function checkEarlyRenewalStatus()  {

$dbMain = $this->dbconnect();

//$stmt = $dbMain ->prepare("SELECT COUNT(end_date) AS result_count FROM paid_full_services  WHERE contract_key= '$this->contractKey' AND service_key='$this->serviceKey' AND end_date > '$todaysDate' AND end_date <= '$this->earlyRenewalGrace' AND service_term != 'C' ORDER BY signup_date ASC LIMIT 1");

$stmt = $dbMain ->prepare("SELECT  max(end_date)  FROM paid_full_services  WHERE contract_key= '$this->contractKey' AND service_key='$this->serviceKey' AND service_term != 'C' ");
 $stmt->execute();      
 $stmt->store_result();  
 $stmt->bind_result($end_date);
 $stmt->fetch();
 
$todaysDate = date("Y-m-d");
$end_date = strtotime($end_date); 
$todaysDate = strtotime($todaysDate);
$early_grace = strtotime($this->earlyRenewalGrace);

if(($end_date > $todaysDate) && ($end_date <= $early_grace)) {
     $this->earlyAvailable = "<input  type=\"button\" class=\"button1\" name=\"early_renewal\" value=\"Early Renewal\" onClick=\"return setRenewalRecord('$this->contractKey','$this->serviceKey', this.name);\" $this->elementDisabled />";
     $this->renewButton = "NA";
     $this->expiredButton = "NA"; 
   }else{
    $this->earlyAvailable = 'NA';
   }


   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//=======================================================================
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
               $this->backGroundColor = "#FFF";
               $this->elementDisabled = "";
               $this->upgradeButton = "<input  type=\"button\" class=\"button1\" name=\"upgrade\" value=\"Upgrade\" onClick=\"return setUpgradeRecord('$this->contractKey','$this->serviceKey', this.name);\" $this->elementDisabled/>"; 
               $this->fontClass = 'keyText';
        break;
        case "EX":
               $this->backGroundColor = '#CCC';              
               $this->elementDisabled = 'disabled="disabled"';
               $this->renewButton = 'NA';
               $this->earlyAvailable = 'NA';  
               $this->upgradeButton = 'NA';
               $this->fontClass = 'exText';
        break;
        case "HO":
               $this->backGroundColor = '#900';
               $this->renewButton = 'NA';
               $this->earlyAvailable = 'NA';  
               $this->upgradeButton = 'NA';
               $this->fontClass = 'keyText';
        break;
        case "CA":
               $this->backGroundColor = '#06C';
               $this->renewButton = 'NA';
               $this->earlyAvailable = 'NA';  
               $this->upgradeButton = 'NA'; 
               $this->pifOutButton = 'NA';
               $this->fontClass = 'keyText';
        break;
      }
  
 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//========================================================================
function parseServiceList()  {


 switch($this->serviceTerm) {
        case "C":
        $this->earlyAvailable = 'NA';
        $this->renewButton = 'NA';
        $term = 'Class(s)';
        break;
        case "D":
        $term = 'Day(s)';
        break;
        case "W":
        $term = 'Week(s)';
        break;
        case "M":
        $this->earlyAvailable = 'NA';
        $this->renewButton = 'NA';
        $term = 'Month(s)';
        break;
        case "Y":
        $term = 'Year(s)';
        break;  
      }


$record_list = "<tr style=\"background-color:  $this->backGroundColor \">
<td align=\"left\" valign =\"middle\" class=\"$this->fontClass\">&nbsp;</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->serviceName</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->serviceDuration  $term</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->earlyAvailable</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->renewButton</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->upgradeButton</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->expiredButton</td>
<td align=\"left\"  valign =\"middle\" class=\"$this->fontClass\">$this->pifOutButton</td>
</tr>";



return $record_list;

}
//========================================================================
function makeClientInfo() {

$this->clientInfo = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">#</th>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Contract ID</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Address</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Primary Phone</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Email</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\"></th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\"></th>
</tr>
<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText\">$this->contractKey</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->firstName $this->middleName  $this->lastName</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->streetAddress $this->city $this->state $this->zipCode</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->primaryPhone</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->emailAddress</td>
</tr>";
}


//========================================================================
function loadMonthlyServices() {

$dbMain = $this->dbconnect();


//$stmt = $dbMain ->prepare("SELECT service_key, service_name,  number_months FROM monthly_services WHERE contract_key ='$this->contractKey' AND  signup_date = (SELECT MAX(signup_date) FROM monthly_services)");

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  number_months FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");


//	$stmt = $dbMain ->prepare("SELECT ms1.service_key, ms1.service_name, ms1.number_months FROM monthly_services ms1 LEFT JOIN monthly_services ms2 ON ms1.service_name = ms2.service_name AND ms1.service_name = ms2.service_name AND ms1.signup_date < ms2.signup_date WHERE ms1.contract_key = '$this->contractKey' AND ms2.contract_key  IS NULL");
		

$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $number_months);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
               $this->pifOutButton = 'NA';
               }else{
                    
                    $this->expiredButton = 'NA';  
                    while ($stmt->fetch()) {  
                                $this->pifOutButton =  "<input  type=\"button\" class=\"button1\" name=\"pif\" value=\"Buyout\" onClick=\"return setRenewalRecord('$this->contractKey','$service_key', this.name);\"/>";
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $number_months;
                               $this->serviceTerm = 'M';
                               $this->serviceName = $service_name;
                               $this->checkAccountStatus();
                               

                               
                               $monthlyServices .= $this->parseServiceList();                               
                             }
              }
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      


$this->monthlyServices = $monthlyServices;

//return $monthlyServices;
                      
}
//========================================================================
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  service_quantity, service_term FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $service_quantity, $service_term);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               $this->pifOutButton = 'NA';
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;
                               $this->serviceName = $service_name;                               
                               $this->checkAccountStatus();
                                     //make sure the account has not already been canceld or is on hold                         
                                  if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                               
                                         if($this->serviceTerm != 'C') {
                                              $this->checkEligibleRenewal();
                                           }
                                                 
                                         if($this->earlyRenewalPercent == 0) {
                                           $this->earlyAvailable = 'NA';
                                           }else{
                                           $this->checkEarlyRenewalStatus(); 
                                          }
                                   }       
                                         
                               $pif_services .= $this->parseServiceList();                               
                             }
                             
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$this->pifServices = $pif_services;

}
//========================================================================
function makeAccountList() {

$service_header = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">&nbsp;</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Duration</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Early Renewal</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Standard Renewal</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Upgrade</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Expired Re-enroll</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">PIF Out</th>
</tr>";  


$service_footer="<tr class=\"endFoot\"><td  class=\"endFoot\" colspan=\"6\">&nbsp;</td></tr>"; 

$account_list = "$this->clientInfo $service_header $this->monthlyServices $this->pifServices $service_footer";


return "$account_list";


}
//========================================================================
function loadAccountList() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, first_name, middle_name, last_name, street, city, state, zip, primary_phone, email FROM contract_info WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $email);
   
    while ($stmt->fetch()) {  

            $this->contractKey = $contract_key;
            $this->firstName = $first_name;
            $this->middleName = $middle_name; 
            $this->lastName = $last_name;
            $this->streetAddress = $street;
            $this->city = $city;
            $this->state = $state;
            $this->zipCode = $zip;
            $this->primaryPhone = $primary_phone;
            $this->emailAddress = $email;
            
            
            //creates the table with all of the client details like name etc 
            $this->makeClientInfo();             
            //get the services 
            $this->loadMonthlyServices();
            $this->loadPifServices();
                                                                 
            $this->cellCount++;

                 $accountList .= $this->makeAccountList();

            }
            
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   

$tableEndTag = '</table>';
$tableTag ="<table align=\"left\"   cellspacing=\"0\" cellpadding=\"1\" width=100% >";
return  "$tableTag $accountList $tableEndTag";


        
}
//======================================================================  

function getAccountList() {
        return($this->accountList);
       }
       
function getEarlyRenewalGrace() {       
        return($this->earlyRenewalGrace);
       }
       
       
       
}
?>