<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout
//date_default_timezone_set('America/Los_Angeles');
class  upgradeContractSql{

private $termType = null;
private $groupType = null;
private $groupName = null;
private $groupInfoArray = null;
private $groupNumber = null;
private $addressInfoArray = null;
private $productListArray = null;
private $newMembers = null;
private $currentProrateArray = null;
private $transfer = null;
private $proRateDues = null;
private $procFeeEft = null;
private $initialFeesEft = null;
private $monthlyBillingType = null;
private $monthlyPayment = null;
private $newMonthlyPayment = null;
private $currentMonthlyProrate = null;
private $totalMonthlyServices = null;
private $initiationFee = null;
private $newTotalPifServices = null;
private $procFeePif = null;
private $newPifGrandTotal = null;
private $currentPifProrateTotal = null;
private $newCurrentPifGrandTotal = null;
private $currentRenewTotal = null;
private $currentMonthlyPayment = null;
private $newMemberFee = null;
private $newServicesTotal = null;
private $newRenewalRateTotal = null;
private $minimumTotalDue = null;
private $todaysPayment = null;
private $balanceDue = null;
private $dueDate = null;
private $contractKey = null;
private $imageName = null;
private $imagePath = null;
private $imageAspect = null;
private $contractTerms = null;
private $contractQuit = null;
private $contractType = "U";
private $contractTypeHeader = null;
private $logoImage = null;
private $streetAddress = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $groupTypeInfo = null;
private $businessName = null;
private $businessAddress = null;
private $businessDba = null;
private $clubId = null;
private $serviceLocation = null;
private $prorateTableRows = null;
private $prorateDivider = null;
private $upgradeHeader1 = null;
private $newServices = null;
private $newTableRows = null;
private $initialPayments = null;
private $termsCss = "terms3";
private $currentGuaranteeFee = null;
private $currentEnhanceFee = null;
private $guaranteeFlag = null;
private $pifEnhanceFlag = null;
private $eftEnhanceFlag = null;
private $transactionRequest = null;
private $signupSection = null;
private $termTypeOrig = null;
private $enhanceTermSwitch = null;
private $guaranteeTermSwitch = null;



function setTermType($termType) {
              $this->termType = $termType;
              }      
function setGroupType($groupType)  {
              $this->groupType = $groupType;
              }
function setGroupName($groupName) {
              $this->groupName = $groupName;
              }              
function setGroupInfoArray($groupInfoArray)  {
              $this->groupInfoArray = $groupInfoArray;
              }
function setGroupNumber($groupNumber)  {
              $this->groupNumber = $groupNumber;
              }              
function setAddressInfoArray($addressInfoArray)  {
              $this->addressInfoArray = $addressInfoArray;
              }
function setProductListArray($productListArray)  {
              $this->productListArray = $productListArray;
              }
function setNewMembers($newMembers)  {
              $this->newMembers = $newMembers;
              }
function setCurrentProrateArray($currentProrateArray)  {
              $this->currentProrateArray = $currentProrateArray;
              }
function setTransfer($transfer)  {
              $this->transfer = $transfer;
              }
function setProRateDues($proRateDues)  {
              $this->proRateDues = $proRateDues;
              }
function setProcFeeEft($procFeeEft)  {
              $this->procFeeEft = $procFeeEft;
              }
function setInitialFeesEft($initialFeesEft)  {
              $this->initialFeesEft = $initialFeesEft;
              }
function setMonthlyPayment($monthlyPayment)  {
              $this->monthlyPayment  = $monthlyPayment ;   //this is for new services selected
              }
function setNewMonthlyPayment($newMonthlyPayment)  {
              $this->newMonthlyPayment = $newMonthlyPayment ;   //this shows the combined monthly payment for new and current services
              }
function setCurrentMonthlyProrate($currentMonthlyProrate)  {
              $this->currentMonthlyProrate= $currentMonthlyProrate;
              }
function setTotalMonthlyServices($totalMonthlyServices)  {
              $this->totalMonthlyServices= $totalMonthlyServices;
              }
function setInitiationFee($initiationFee)  {
              $this->initiationFee= $initiationFee;
              }
function setNewTotalPifServices($newTotalPifServices)  {
              $this->newTotalPifServices= $newTotalPifServices;
              }
function setProcFeePif($procFeePif)  {
              $this->procFeePif= $procFeePif;
              }
function setNewPifgrandTotal($newPifGrandTotal)  {
              $this->newPifGrandTotal= $newPifGrandTotal;
              }
function setCurrentPifProrateTotal($currentPifProrateTotal)  {
              $this->currentPifProrateTotal= $currentPifProrateTotal;
              }
function setNewCurrentPifGrandTotal($newCurrentPifGrandTotal)  {
              $this->newCurrentPifGrandTotal= $newCurrentPifGrandTotal;
              }
function setCurrentRenewTotal($currentRenewTotal)  {
              $this->currentRenewTotal= $currentRenewTotal;
              }
function setCurrentMonthlyPayment($currentMonthlyPayment)  {
              $this->currentMonthlyPayment= $currentMonthlyPayment;
              }
function setNewMemberFee($newMemberFee)  {
              $this->newMemberFee= $newMemberFee;
              }
function setNewServicesTotal($newServicesTotal)  {
              $this->newServicesTotal= $newServicesTotal;
              }
function setNewRenewalRateTotal($newRenewalRateTotal)  {
              $this->newRenewalRateTotal= $newRenewalRateTotal;
              }
function setMinimumTotalDue($minimumTotalDue)  {
              $this->minimumTotalDue= $minimumTotalDue;
              }               
function setTodaysPayment($todaysPayment) {
              $this->todaysPayment = $todaysPayment;
              }           
function setBalanceDue($balanceDue) {
              $this->balanceDue = $balanceDue;
              }
function setDueDate($dueDate) {
              $this->dueDate = $dueDate;
              }
function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }
function setMonthlyBillingType($monthlyBillingType) {
             $this->monthlyBillingType = $monthlyBillingType;
              }   
function setSig($sig) {
   $this->signature = $sig;
   }              
//------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//======================================================
function parseStartEndDates() {

$this->startDate = date("M j, Y");

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = 'NA';
        break;
        case "D":
        $this->endDate = date("M j, Y"  ,mktime(23,59,59, date("m")  , date("d")+$this->serviceDuration, date("Y")));
        break;
        case "W":
        $days = $this->serviceDuration * 7;
        $this->endDate = date("M j, Y"  ,mktime(23,59,59, date("m")  , date("d")+$days, date("Y")));
        break;
        case "M":
        $this->endDate = date("M j, Y"  ,mktime(23,59,59, date("m")+$this->serviceDuration, date("d"), date("Y")));
        break;
        case "Y":
        $this->endDate = date("M j, Y"  ,mktime(23,59,59, date("m"), date("d"), date("Y")+$this->serviceDuration));
        break;  
      }

}
//------------------------------------------------------------------------------------------------
function loadContractLocation()  {
/*for now this is set manually. the final version will look for the assigned IP address of the browser and use a sql table to designate the club id and the location name etc*/

$this->locationId = '6883';
$todaysDate = date("F j, Y");
$this->contractLocation = "<p>Executed at $this->businessName $this->businessAddress on $todaysDate</p>";

}
//=======================================================
function checkCurrentEnhanceFeeEft() {
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT eft_cycle, eft_cycle_date, enhance_fee FROM member_enhance_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$num_rows = $stmt->num_rows;
$stmt->bind_result($eft_cycle, $eft_cycle_date, $enhance_fee);             
$stmt->fetch();
             
if($num_rows != 0)  {                 
     if($eft_cycle == "M") { 
        $this->currentEnhanceFee = $enhance_fee;        
        }                          
   }            

}
//======================================================
function checkCurrentGuaranteeFee() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT eft_cycle, eft_cycle_date, guarantee_fee FROM member_guarantee_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$num_rows = $stmt->num_rows;
$stmt->bind_result($eft_cycle, $eft_cycle_date, $guarantee_fee);             
$stmt->fetch();
             
if($num_rows != 0)  {                 
     if($eft_cycle == "M") { 
        $this->currentGuaranateeFee = $guarantee_fee;     
        }                          
   }            
             
}
//======================================================
function loadClubId()  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT club_id FROM service_info WHERE service_key = '$this->serviceKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id);   
 $stmt->fetch();             
             
 return "$club_id";

 $stmt->close(); 
}
//======================================================
function loadServiceLocation() {


 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name);   
 $stmt->fetch();                         
 $stmt->close(); 
 
 $this->serviceLocation = $club_name;
 
  if($this->clubId == "0")  {
    $this->serviceLocation = 'All Locations';
  }

}
//======================================================
function formatLogoImage() {

$this->logoImage = "<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"$this->imagePath$this->imageName\" $this->imageAspect /></a>";

}
//======================================================
function loadContractType() {

  switch($this->groupType) {
        case "S":
        $titleName = "Single";
        break;
        case "F":
        $titleName = "Family";
        break;
        case "B":
        $titleName = "Business";
        break;
        case "O":
        $titleName = "Organization";
        break;
        }
        
  switch($this->contractType) {
        case "S":
        $type = "Service";
        break;
        case "U":
        $type = "Upgrade";
        break;
        case "B":
        $type = "Renewal";
        break;
       }

$this->contractTypeHeader = "$titleName $type Service Agreement";

}              
//======================================================
function loadUpgradeContractDefaults()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect, contract_terms, contract_quit FROM contract_defaults WHERE contract_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($image_name, $image_path, $image_aspect, $contract_terms, $contract_quit);   
$stmt->fetch();   

$this->imageName = $image_name;
$this->imagePath = $image_path;
$this->imageAspect = $image_aspect;
$this->contractTerms = $contract_terms;
$this->contractQuit = $contract_quit;

$stmt->close();

$this->loadContractType();
$this->formatLogoImage();

}
//=========================================================
function parseContactInfo() {
$this-> loadSalesPersonName();

$dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT  first_name, middle_name, last_name  FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY signup_date DESC LIMIT 1");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name);
  $stmt->fetch();
  $stmt->close();
  $this->name = "$first_name $middle_name $last_name";
  
  $stmt = $dbMain ->prepare("SELECT  first_name, middle_name, last_name  FROM member_info WHERE  contract_key = '$this->contractKey'");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name);
  $stmt->fetch();
  $stmt->close();
  $this->cName = "$first_name $middle_name $last_name";


if($this->addressInfoArray != 'NA')  {

     $contactInfo = explode("|", $this->addressInfoArray);
     $this->streetAddress = "$contactInfo[0] $contactInfo[1], $contactInfo[2] $contactInfo[3]";
     $this->primaryPhone = $contactInfo[4];
     $this->cellPhone = $contactInfo[5];
     $this->emailAddress = $contactInfo[6];
     
   }else{
   
  //$dbMain = $this->dbconnect();
  //first we get all of the pertinant data from the original contract last generated
  $stmt = $dbMain ->prepare("SELECT  street, city, state, zip, primary_phone, cell_phone, email  FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY signup_date DESC LIMIT 1");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($street, $city, $state, $zip, $primary_phone, $cell_phone, $email);
  $stmt->fetch();
  
     $this->streetAddress = "$street $city, $state $zip";
     $this->primaryPhone = $primary_phone;
     $this->cellPhone = $cell_phone;
     $this->emailAddress = $email;  
     
  $stmt->close();
  }
  
}

//=========================================================
function parseGroupInfo()  {

if($this->groupInfoArray != 'NA') {

//parse the group type info
$group_info_array = explode("|", $this->groupInfoArray);
$groupAddress = $group_info_array[0];
$groupPhone = $group_info_array[1];

 switch($this->groupType) {
        case "S":
        $this->groupTypeInfo = "";
        break;
        case "F":
        $this->groupTypeInfo = "";
        break;
        case "B":
        $titleName = "Business";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$titleName Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$titleName Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";        
        break;
        case "O":
        $titleName = "Organization";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$titleName Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$titleName Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";                        
        break;
        }

  }else{
  
  
          if(($this->groupType == "B") || ($this->groupType == "O")) {
          
           switch($this->groupType) {
           case "B":
           $titleName = "Business";
           break;
           case "O":
           $titleName = "Organization";
           break;
           }
                 
             $dbMain = $this->dbconnect();
             $stmt = $dbMain ->prepare("SELECT group_type, group_name, group_address, group_phone FROM member_groups WHERE contract_key ='$this->contractKey'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($group_type, $group_name, $group_address, $group_phone);
             $stmt->fetch();

            $this->groupAddress = $group_address;
            $this->groupPhone = $group_phone;
            $this->groupName = $group_name;
            $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$titleName Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$titleName Address</td><td class=\"nameSakes\">$this->groupAddress $this->groupPhone</td></tr>";  
            $stmt->close();
            }  
  }

}
//=========================================================
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_name, business_dba, business_address FROM company_names WHERE business_name !='' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_name, $business_dba, $business_address);   
$stmt->fetch();   

$this->businessName = $business_name;
$this->businessDba = $business_dba;
$this->businessAddress = $business_address;

}
//=========================================================
function parseCurrentPaidFull() {

 $prorateRowArray = explode("|", $this->prorateRow); 
 $this->proRatePrice = $prorateRowArray[0];
 $this->serviceKey = $prorateRowArray[1];
 $this->dailyRate = $prorateRowArray[3];

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name,  service_quantity, service_term, unit_price, unit_renew_rate, group_price, group_renew_rate, start_date, end_date, user_id FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($group_type, $group_number, $club_id, $service_name, $service_quantity, $service_term, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $start_date, $end_date, $user_id);
$stmt->fetch();

$this->groupType = $group_type;
$this->groupNumber = $group_number + $this->newMembers;
$this->clubId = $club_id;
$this->loadServiceLocation();
$this->serviceName = $service_name;
$this->serviceQuantity = $service_quantity;
$this->serviceTerm = $service_term;
$this->unitPrice = $unit_price;
$this->unitRenewRate = $unit_renew_rate;
$this->groupPrice = sprintf("%.2f", $this->unitPrice * $this->groupNumber);
$this->groupRenewRate = sprintf("%.2f", $this->unitRenewRate * $this->groupNumber);
$this->startDate = date("M j, Y");
$this->endDate = date("M j, Y", strtotime($end_date));

$this->proRenewalRate = sprintf("%.2f", $this->newMembers * $this->unitRenewRate);

//close the current statement
$stmt->close(); 

$this->prorateTableRows .="
<tr>
<td class=\"fieldHeaderTop\">
Prorate Quantity
</td>
<td class=\"fieldHeaderTop\">
Service Name
</td>
<td class=\"fieldHeaderTop\">
Service Location
</td>
<td class=\"fieldHeaderTop\">
Start Date
</td>
<td class=\"fieldHeaderTop\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->newMembers
</td>
<td class=\"fieldValues\">
$this->serviceName 
</td>
<td class=\"fieldValues\">
$this->serviceLocation
</td>
<td class=\"fieldValues\" >
$this->startDate
</td>
<td class=\"fieldValues\" >
$this->endDate
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Prorate Cost
</td>
<td class=\"fieldHeader\">
Prorate Renewal Rate
</td>
<td class=\"fieldHeader\">
New Quantity
</td>
<td class=\"fieldHeader\" colspan=\"2\">
New Renewal Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->proRatePrice
</td>
<td class=\"fieldValues\">
$this->proRenewalRate
</td>
<td class=\"fieldValues\">
$this->groupNumber
</td>
<td class=\"fieldValues\" colspan=\"2\">
$this->groupRenewRate
</td>
</tr>

 $this->prorateDivider 
";

$this->prorateTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->newMembers</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Prorate Cost</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Prorate Renewal Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>New Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>New Renewal Rate</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->proRatePrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->proRenewalRate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupRenewRate</font></th>
</tr>

 $this->prorateDivider 
";

}

//=========================================================
function parseCurrentMonthly()  {

 $prorateRowArray = explode("|", $this->prorateRow); 
 $this->proRatePrice = $prorateRowArray[0];
 $this->serviceKey = $prorateRowArray[1];
 $this->dailyRate = $prorateRowArray[3];
 
 
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, club_id, service_name,  number_months, unit_price, unit_renew_rate, group_price, group_renew_rate, term_type, initiation_fee, down_payment, monthly_dues, pro_rate_dues, pro_date_start, pro_date_end, start_date, end_date, user_id FROM monthly_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey'  ORDER BY service_id DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_number, $club_id, $service_name,  $number_months, $unit_price, $unit_renew_rate, $group_price, $group_renew_rate, $term_type, $initiation_fee, $down_payment, $monthly_dues, $pro_rate_dues, $pro_date_start, $pro_date_end, $start_date, $end_date, $user_id);
$stmt->fetch();

$this->groupType = $group_type;
$this->groupNumber = $group_number + $this->newMembers;
$this->clubId = $club_id;
$this->loadServiceLocation();
$this->serviceName = $service_name;
$this->serviceQuantity = $number_months;
//$this->unitPrice = sprintf("%.2f",$unit_price /  $group_number);
$this->unitPrice = sprintf("%.2f",$unit_price);
$this->unitRenewRate = sprintf("%.2f",$unit_renew_rate);
//$this->unitRenewRate = sprintf("%.2f",$unit_renew_rate * $group_number);


//add the new member to the group price
$this->groupPrice = sprintf("%.2f",$this->unitPrice * $this->groupNumber);
$this->prorateGroupPrice = sprintf("%.2f",$this->unitPrice * $this->newMembers);
$this->groupRenewRate = sprintf("%.2f",$this->unitRenewRate * $this->groupNumber);
$this->termType = $term_type;


//calc the monthly dues
$singleMonthlyDues = $this->singleMonthlyDues = $monthly_dues / $group_number;
$this->monthlyDues = sprintf("%.2f", $singleMonthlyDues * $this->groupNumber);

$this->prorateMonthlyDues = sprintf("%.2f", $singleMonthlyDues * $this->newMembers);


//get the current day number of the month and the numberof days in the month
$current_day_number = date(d);
$month_days_number = date(t);
$date_difference = $month_days_number - $current_day_number;
$this->dailyRate = $this->dailyRate * $this->newMembers;

//create the pro rate amount and format it
//$this->proRateDues = sprintf("%.2f", $date_difference * $this->dailyRate);
$this->proDateStart = date("Y-m-d"); 
$this->proDateEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("t"), date("Y")));
$this->startDate = date("M j, Y"); 
$this->endDate = date("M j, Y", strtotime($end_date));

/*
//check to see if there are guarentee asscociated with this service fees 
 if((preg_match("/membership/i", $this->serviceName)) && ($this->termType == "O")) {
    $this->checkCurrentGuaranteeFee();
   }
if(($this->serviceQuantity >= 12) && (preg_match("/membership/i", $this->serviceName)) && ($this->termType == "T")) {
    $this->checkCurrentEnhanceFeeEft();  
   }   */

//close the current statement
$stmt->close(); 

$this->prorateTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->newMembers</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Monthly Prorate Dues</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Prorate Term Cost</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>New Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>New Renewal Rate</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->prorateMonthlyDues</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->proRatePrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupRenewRate</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>New Monthly Dues</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->monthlyDues</font></th>
</tr>
 $this->prorateDivider 
";

$this->prorateTableRows .="
<tr>
<td class=\"fieldHeaderTop\">
Prorate Quantity
</td>
<td class=\"fieldHeaderTop\">
Service Name
</td>
<td class=\"fieldHeaderTop\">
Service Location
</td>
<td class=\"fieldHeaderTop\">
Start Date
</td>
<td class=\"fieldHeaderTop\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->newMembers
</td>
<td class=\"fieldValues\">
$this->serviceName 
</td>
<td class=\"fieldValues\">
$this->serviceLocation
</td>
<td class=\"fieldValues\" >
$this->startDate
</td>
<td class=\"fieldValues\" >
$this->endDate
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Monthly Prorate Dues
</td>
<td class=\"fieldHeader\">
Prorate Term Cost
</td>
<td class=\"fieldHeader\">
New Quantity
</td>
<td class=\"fieldHeader\" colspan=\"2\">
New Renewal Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->prorateMonthlyDues
</td>
<td class=\"fieldValues\">
$this->proRatePrice
</td>
<td class=\"fieldValues\">
$this->groupNumber
</td>
<td class=\"fieldValues\" colspan=\"2\">
$this->groupRenewRate
</td>
</tr>

<tr>
<td class=\"fieldHeader\"colspan=\"5\">
New Monthly Dues
</td>
</tr>

<tr>
<td class=\"fieldValues\" colspan=\"5\">
$this->monthlyDues  
</td>
</tr>
 $this->prorateDivider 
";

}
//=========================================================
function loadCurrentServices()  {

   if($this->newMembers != 0)  {
   
   $this->upgradeHeader1 = "<span class=\"subHeader\">SERVICE PRORATE SUMMARY</span>";
   
     $currentProrateArray = explode("@", $this->currentProrateArray); 
     $prorateCount = count($currentProrateArray);
     $prorateCount = $prorateCount - 1;
     
                 for($i=0; $i < $prorateCount; $i++)  {
                 
                            if($i == $prorateCount - 1)  {
                                $this->prorateDivider = "";  
                               }else{
                                $this->prorateDivider = "<tr><td colspan=\"5\" class=\"fieldValues pad2\"><p class=\"dash\"></p></td></tr>"; 
                               }  
                 
                          $this->prorateRow = $currentProrateArray[$i];
                             if(preg_match("/M/", $this->prorateRow)) {
                                $this->parseCurrentMonthly();
                                }else{
                                $this->parseCurrentPaidFull();
                                }        
                       }                       
      }else{
      
      $this->upgradeHeader1 = "<span class=\"subHeader\">NEW SERVICE SUMMARY</span>";      
      }
      
            
}

//=========================================================
function parseNewPaidFull() {

$productFieldArray = $this->productFieldArray = explode("|", $this->productRow);

//$this->groupNumber = $this->groupNumber + $this->newMembers;
$this->serviceKey = trim($productFieldArray[7]);
$this->clubId = $this->loadClubId();
$this->loadServiceLocation();
$this->serviceName = $productFieldArray[0];
$this->serviceTermText =  $productFieldArray[5];


//send to get start and end dates
$durationArray  =  explode(" ", $this->serviceTermText);
$this->serviceDuration = $durationArray[0];
$this->serviceTerm = substr($durationArray[1], 0, 1);
$this->parseStartEndDates();



//calc the unit price
$this->unitPrice = sprintf("%.2f", $productFieldArray[6] / $this->groupNumber);
//--------------------------------------------------------------
//for renew rate if it is set to NA
if($productFieldArray[3] == 'NA') {
  $this->unitRenewRate = 'NA';
  }else{
  $this->unitRenewRate = sprintf("%.2f", $productFieldArray[3] / $this->groupNumber);
  }
//-------------------------------------------------------------
$this->groupPrice = $productFieldArray[2];
$this->groupRenewRate = $productFieldArray[3];
//-------------------------------------------------
if($this->groupNumber == 1)  {
$this->groupPrice = "NA";
$this->groupRenewRate = "NA";
}
//------------------------------------------------
  switch($this->transfer) {
        case "N":
        $this->transfer = "No";
        break;
        case "Y":
        $this->transfer = "Yes";
        break;
        }

//this is for enhance fee if service qualifies then it is set
if((preg_match("/membership/i", $this->serviceName)) && (preg_match("/Year\(s\)/", $this->serviceTermText))) {
    $this->pifEnhanceFlag = 1;  
   }


$this->newTableRows .="
<tr>
<td class=\"fieldHeaderTop\">
Quantity
</td>
<td class=\"fieldHeaderTop\">
Service Name
</td>
<td class=\"fieldHeaderTop\">
Service Location
</td>
<td class=\"fieldHeaderTop\">
Service Duration
</td>
<td class=\"fieldHeaderTop\">
Transferable
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->groupNumber
</td>
<td class=\"fieldValues\">
$this->serviceName
</td>
<td class=\"fieldValues\">
 $this->serviceLocation
</td>
<td class=\"fieldValues\">
$this->serviceTermText 
</td>
<td class=\"fieldValues\">
$this->transfer
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Unit Cost
</td>
<td class=\"fieldHeader\">
Unit Renew Rate
</td>
<td class=\"fieldHeader\">
Group Cost
</td>
<td class=\"fieldHeader\" colspan=\"2\">
Group Renew Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->unitPrice
</td>
<td class=\"fieldValues\">
$this->unitRenewRate
</td>
<td class=\"fieldValues\">
$this->groupPrice
</td>
<td class=\"fieldValues\" colspan=\"2\">
$this->groupRenewRate
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Start Date
</td>
<td colspan=\"3\" class=\"fieldHeader\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->startDate
</td>
<td colspan=\"3\" class=\"fieldValues\">
$this->endDate
</td>
</tr>

$this->productDivider
";


$this->newTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Duration</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Transferable</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceTermText</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->transfer</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Unit Cost</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Unit Renew Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Cost</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Renew Rate</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->unitPrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->unitRenewRate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupPrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupRenewRate</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>

$this->productDivider
";
}
//=========================================================
function parseNewMonthly() {

$productFieldArray = $this->productFieldArray = explode("|", $this->productRow);

 
$this->serviceKey = trim($productFieldArray[7]);
$this->clubId = $this->loadClubId();
$this->loadServiceLocation();
$this->serviceName = $productFieldArray[0];
$this->currentDurationText =  $productFieldArray[5];
$this->renewalDurationText = "$productFieldArray[1] Month(s)";
$this->proRatePrice = $productFieldArray[6];
$this->renewalRate = $productFieldArray[3];
$this->groupProRatePrice = $productFieldArray[6];
$this->groupRenewalRate = $productFieldArray[3];


      //check to see if this is a service that needs to be prorated
     if($productFieldArray[1] == "") {        
        $numberMonths = $this->serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[5]);
        $this->groupNumber + $this->newMembers; 
        $this->renewalDurationText = $productFieldArray[5];                
        }else{        
        $numberMonths = $this->serviceQuantity = $productFieldArray[1];
        }

$groupPrice = $this->groupPrice = $productFieldArray[2];
$this->monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);
//--------------------------------------------------------------------
//create a gurarantee flag if this is a new membership and not a stand alone service
if(($numberMonths >= 12) && (preg_match("/membership/i", $this->serviceName))) {
    $this->guaranteeFlag = 1;
    $this->termTypeOrig = $this->termType;
    }
    
//create a flag for enhance fee if needed
if(($numberMonths >= 12) && (preg_match("/membership/i", $this->serviceName))) {
    $this->eftEnhanceFlag = 1;
    $this->termTypeOrig = $this->termType;
    }


//--------------------------------------------------------------------

switch($this->termType) {
        case "T":
        $this->termType = "Full Term";
        break;
        case "O":
        $this->termType = "Open Ended";
        break;
        }


if($this->groupType == "S")  {
   $this->groupProRatePrice = "NA";
   $this->groupRenewalRate = "NA";
   }


$this->serviceTerm = 'M';
$this->serviceDuration = $numberMonths;
$this->parseStartEndDates();

$this->newTableRows .="
<tr>
<td class=\"fieldHeaderTop\">
Quantity
</td>
<td class=\"fieldHeaderTop\">
Service Name
</td>
<td class=\"fieldHeaderTop\">
Service Location
</td>
<td class=\"fieldHeaderTop\">
Current Duration
</td>
<td class=\"fieldHeaderTop\">
Renewal Duration
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->groupNumber
</td>
<td class=\"fieldValues\">
$this->serviceName 
</td>
<td class=\"fieldValues\">
$this->serviceLocation
</td>
<td class=\"fieldValues\" >
$this->currentDurationText 
</td>
<td class=\"fieldValues\" >
$this->renewalDurationText
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Current Rate
</td>
<td class=\"fieldHeader\">
Renew Rate
</td>
<td class=\"fieldHeader\">
Group Rate
</td>
<td class=\"fieldHeader\">
Group Renewal Rate
</td>
</td>
<td class=\"fieldHeader\">
Monthly Dues
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->proRatePrice
</td>
<td class=\"fieldValues\">
$this->renewalRate
</td>
<td class=\"fieldValues\">
$this->groupProRatePrice
</td>
<td class=\"fieldValues\">
$this->groupRenewalRate
</td>
<td class=\"fieldValues\">
$this->monthlyDues
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Term Type
</td>
<td class=\"fieldHeader\">
Start Date
</td>
<td colspan=\"2\" class=\"fieldHeader\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->termType
</td>
<td class=\"fieldValues\">
$this->startDate
</td>
<td colspan=\"2\" class=\"fieldValues\">
$this->endDate
</td>


</tr>

 $this->productDivider"; 
 
 $this->newTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Current Duration</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Renewal Duration</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->currentDurationText</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->renewalDurationText</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Current Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Renew Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Renewal Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Monthly Dues</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->proRatePrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->renewalRate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupProRatePrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->groupRenewalRate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->monthlyDues</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Term Type</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->termType</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>

 $this->productDivider"; 


}
//=========================================================
function loadNewServices()  {

if($this->productListArray != "")  {
      $productListArray = explode("@", $this->productListArray);
      $productCount = count($productListArray);
      $productCount = $productCount -1;

           for($i=0; $i < $productCount; $i++)  {
           
                            if($i == $productCount - 1)  {
                                $this->productDivider = "";  
                               }else{
                                $this->productDivider = "<tr><td colspan=\"5\" class=\"fieldValues pad2\"><p class=\"dash\"></p></td></tr>"; 
                               }                        
           
                   $this->productRow = $productListArray[$i];
                      if(preg_match("/Month\(s\)/", $this->productRow)) {
                        $this->parseNewMonthly();
                        }else{
                        $this->parseNewPaidFull();              
                        }     
                }
     } 
     
   //if there are no new members we switch out the current service rows with new services  
if($this->newMembers == 0)  {
   $this->prorateTableRows =  $this->newTableRows;
   $this->prorateTableRowsEmail =  $this->newTableRowsEmail;
   $this->newServices = "";
   $this->newServicesEmail = "";
   }elseif($this->newTableRows != "") {
   $this->newServices = "       
   <div id=\"initialHeader\">
   <span class=\"subHeader\">NEW SERVICE SUMMARY</span>
   </div>
   <div id=\"underline3\"></div>
   <div id=\"initialPayments\">
   <table cellpadding=\"0\" cellspacing=\"0\">
   $this->newTableRows
   </table>
   </div>";      
   $this->newServicesEmail = " 
   <tr>      
   <h4>NEW SERVICE SUMMARY<h4>
   </tr>
   $this->newTableRows
   </table>";      
   }
     
}
//=========================================================
function parseInitialPayments() {

$dueDateArray = explode(",", $this->dueDate);
$this->dueDate = "$dueDateArray[1], $dueDateArray[2]";

if(($this->initiationFee == 0) || ($this->initiationFee == "")) {
   $initiationFeeRow = "";
   }else{
   $this->initiationFee = sprintf("%.2f", $this->initiationFee);
   $initiationFeeRow = "<tr><td class=\"nameTitles3\">Initiation Fee:</td><td class=\"nameSakes2\">$this->initiationFee</td><td class=\"nameSakes5\"></td></tr>";
   $initiationFeeRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Initiation Fee:</b>&nbsp;$this->initiationFee</font></th>
   </tr>";
   
   }

if(($this->procFeeEft == "undefined") || ($this->procFeeEft == "")){
   $processFeeEftRow = "";
   }else{
   $processFeeEftRow = "<tr><td class=\"nameTitles3\">Processing Fee (New Monthly Services):</td><td class=\"nameSakes2\">$this->procFeeEft</td><td class=\"nameSakes5\"></td></tr>";
   $processFeeEftRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (New Monthly Services):</b></b>&nbsp;$this->procFeeEft</font></th>
   </tr>";
  
   }

if(($this->proRateDues == "") || ($this->proRateDues == "undefined")) {
   $proRateDuesRow = "";
   }else{
   $proRateDuesRow = "<tr><td class=\"nameTitles3\">Prorate Dues (New Monthly Services):</td><td class=\"nameSakes2\">$this->proRateDues</td><td class=\"nameSakes5\"></td></tr>";
   $proRateDuesRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Dues (New Monthly Services):</b>&nbsp;$this->proRateDues</font></th>
   </tr>";
   
   }

if(($this->procFeePif == "") || ($this->procFeePif == "undefined")) {
   $processFeePifRow = "";
   }else{
   $processFeePifRow = "<tr><td class=\"nameTitles3\">Processing Fee (New PIF Services):</td><td class=\"nameSakes2\">$this->procFeePif</td><td class=\"nameSakes5\"></td></tr>";
   $processFeePifRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (New PIF Services):</b>&nbsp;$this->procFeePif</font></th>
   </tr>";
   
   }

if(($this->newTotalPifServices == "undefined") || ($this->newTotalPifServices == "")) {
   $newPifServicesTotal = "";
   }else{
   $newPifServicesTotal = "<tr><td class=\"nameTitles3\">Paid In Full Service Cost(s):</td><td class=\"nameSakes2\">$this->newTotalPifServices</td><td class=\"nameSakes5\"></td></tr>";
   $newPifServicesTotalEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Paid In Full Service Cost(s):</b>&nbsp;$this->newTotalPifServices</font></th>
   </tr>";
   
   }

if(($this->currentMonthlyProrate == "undefined") || ($this->currentMonthlyProrate == "")) {
   $currentMonthlyProrateTotal = "";
   }else{
   $currentMonthlyProrateTotal = "<tr><td class=\"nameTitles3\">Prorate Dues (Current Monthly Services):</td><td class=\"nameSakes2\">$this->currentMonthlyProrate</td><td class=\"nameSakes5\"></td></tr>";
   $currentMonthlyProrateTotalEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Dues (Current Monthly Services):</b>&nbsp;$this->currentMonthlyProrate</font></th>
   </tr>";
   }

if(($this->currentPifProrateTotal  == "undefined") || ($this->currentPifProrateTotal  == "")) {
   $currentPifProrateTotals = "";
   }else{
   $currentPifProrateTotals = "<tr><td class=\"nameTitles3\">Prorate Total (Current PIF Services):</td><td class=\"nameSakes2\">$this->currentPifProrateTotal</td><td class=\"nameSakes5\"></td></tr>";
   $currentPifProrateTotalsEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Total (Current PIF Services):</b>&nbsp;$this->currentPifProrateTotal</font></th>
   </tr>";
   
   }

if(($this->newMemberFee  == "undefined") || ($this->newMemberFee  == "")) {
   $newMemberFeeTotal = "";
   }else{
   $newMemberFeeTotal = "<tr><td class=\"nameTitles3\">New Member(s) Fee:</td><td class=\"nameSakes2\">$this->newMemberFee</td><td class=\"nameSakes5\"></td></tr>";
   $newMemberFeeTotalEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>New Member(s) Fee:</b>&nbsp;$this->newMemberFee</font></th>
   </tr>";
   
   }

$totalDue = $this->todaysPayment + $this->balanceDue;
$totalDue = sprintf("%.2f",$totalDue);
$this->todaysPayment  = sprintf("%.2f",$this->todaysPayment);

$totalDueRow = "<tr><td class=\"nameTitles3 pad\">TOTAL DUE:</td><td class=\"nameSakes4 pad\">$totalDue</td><td class=\"nameSakes5\"></td></tr>";
$totalDueRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b><b>TOTAL DUE:</b></b>&nbsp;&nbsp;&nbsp;$totalDue</font></th>
</tr>";

$todaysPaymentRow = "<tr><td class=\"nameTitles3\">TODAYS PAYMENT:</td><td class=\"nameSakes2\">$this->todaysPayment</td><td class=\"nameSakes5\"></td></tr>";
$todaysPaymentRow = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TODAYS PAYMENT:</b>&nbsp;$this->todaysPayment</font></th>
</tr>";

$balanceDueRow = "<tr><td class=\"nameTitles3\">BALANCE DUE:</td><td class=\"nameSakes2\">$this->balanceDue</td><td class=\"nameSakes5\">DUE DATE:<span class=\"dueDate\">$this->dueDate</span></td></tr>";
$balanceDueRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>BALANCE DUE:</b>&nbsp;$this->balanceDue&nbsp;DUE DATE:&nbsp;$this->dueDate</font></th>
</tr>";



$this->initialPaymentRows = " $initiationFeeRow $processFeeEftRow $proRateDuesRow $processFeePifRow $newPifServicesTotal $newMemberFeeTotal $currentPifProrateTotals $currentMonthlyProrateTotal $totalDueRow $todaysPaymentRow $balanceDueRow";

$this->initialPaymentRowsEmail = " $initiationFeeRowEmail $processFeeEftRowEmail $proRateDuesRowEmail $processFeePifRowEmail $newPifServicesTotalEmail $newMemberFeeTotalEmail $currentPifProrateTotalsEmail $currentMonthlyProrateTotalEmail $totalDueRowEmail $todaysPaymentRowEmail $balanceDueRowEmail";

}
//=========================================================
function loadInitialPayments()  {

$this->parseInitialPayments();

if($this->newMembers == 0) {

$this->initialPayments ="
 <div id=\"initialHeader\">
 <span class=\"subHeader\">INITIAL PAYMENTS</span>
 </div>
 <div id=\"underline3\"></div>
 <div id=\"initialPayments\">
 <table cellpadding=\"0\" cellspacing=\"0\">
  $this->initialPaymentRows
 </table>
 </div>";    
 
}elseif(($this->newMembers != 0) && ($this->productListArray == "")) {

$this->newServices = "";

$this->initialPayments ="
 <div id=\"initialHeader\">
 <span class=\"subHeader\">INITIAL PAYMENTS</span>
 </div>
 <div id=\"underline3\"></div>
 <div id=\"initialPayments\">
 <table cellpadding=\"0\" cellspacing=\"0\">
  $this->initialPaymentRows
 </table>
 </div>";    
 
}elseif(($this->newMembers != 0) && ($this->productListArray != "")) {

$this->initialPayments ="
 <div id=\"initialHeader2\">
 <span class=\"subHeader\">INITIAL PAYMENTS</span>
 </div>
 <div id=\"underline5\"></div>
 <div id=\"initialPayments2\">
 <table cellpadding=\"0\" cellspacing=\"0\">
  $this->initialPaymentRows
 </table>
 </div>";    
 
$this->termsCss = "terms2";
}

}
//=========================================================
function createGeneralTerms() {

$payQuitBlurb = "YOU, THE BUYER, MAY CANCEL THIS AGREEMENT AT ANY TIME PRIOR TO MIDNIGHT OF THE $this->contractQuit  BUSINESS
DAY AFTER THE DATE OF THIS AGREEMENT, EXCLUDING SUNDAYS AND HOLIDAYS.";

$replacementCardBlurb = "I ACKNOWLEDGE THAT IN THE EVENT MY MEMBERSHIP CARD IS LOST, STOLEN, OR DESTROYED I AGREE TO PAY A MEMBERSHIP CARD REPLACEMENT FEE OF \$$this->lostCardFee IN ORDER TO BE ISSUED A REPLACEMENT CARD.";

$renewalGraceBlurb ="PAID IN FULL MEMBERSHIPS ARE ELGIBLE FOR RENEWAL UNDER THE TERMS OF THIS CONTRACT WITHIN $this->renewalGracePeriod DAYS UPON THE EXPIRATION OF TERMS OF SERVICE.";

$this->contractTerms = "$this->genericTerms $renewalGraceBlurb $replacementCardBlurb $payQuitBlurb";

}
//=========================================================
function loadContractTerms() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($feeNum, $processFeeSingle, $processFeeFamily, $processFeeBusiness, $processFeeOrganization, $processFeeSingle2, $processFeeFamily2, $processFeeBusiness2, $processFeeOrganization2, $upgradeFeeSingle, $upgradeFeeFamily, $upgradeFeeBusiness, $upgradeFeeOrganization, $upgradeFeeSingle2, $upgradeFeeFamily2, $upgradeFeeBusiness2, $upgradeFeeOrganization2, $upgradeFeeSingle3, $upgradeFeeFamily3, $upgradeFeeBusiness3, $upgradeFeeOrganization3,$renewalFeeSingle, $renewalFeeFamily, $renewalFeeBusiness, $renewalFeeOrganization, $renewalFeeSingle2, $renewalFeeFamily2, $renewalFeeBusiness2, $renewalFeeOrganization2, $cancelFee, $enhanceFee, $rejectionFee, $renewalPercent, $earlyRenewalPercent, $earlyRenewalGrace, $standardRenewalGrace, $lateFee, $cardFee, $rateFee, $hold_fee, $hold_grace, $memberHoldFee, $transferFee, $nsfFee, $classPercent); 
   $stmt->fetch();
   
   
   $stmt = $dbMain ->prepare("SELECT past_day, cycle_day FROM billing_cycle WHERE cycle_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day, $cycle_day);
   $stmt->fetch();
   
   $this->pastDueGrace = $past_day;
   $this->billingDay = $cycle_day;
   
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();

//number of legal days 
//$this->contractQuit =  $contract_quit;
//generic terms and conditions
$this->genericTerms = strtoupper($this->contractTerms);
//the cancelation fee for contracts
$this->cancelationFee = $cancelFee;
//a rejection fee for overdrafts
$this->rejectionFee = $rejectionFee;
//for late payments
$this->lateFee = $lateFee;
//lost card fee
$this->lostCardFee = $cardFee;
//number of days where after contract expires members can renew
$this->renewalGracePeriod = $standardRenewalGrace;
//fee fo upgrades to the gym
$this->enhanceFee = $enhanceFee;
//rate gurantee fee for monthly members open ended
$this->rateGuaranteeFee = $rateFee;

$this->createGeneralTerms();

}
//========================================================
function checkEnhanceFee() {

      if($this->enhanceFee == "0.00") {
            $this->enhanceRequest = ""; 
            $this->enhanceRequestPif = ""; 
          }else{
                 
                 $dbMain = $this->dbconnect();
                 $stmt = $dbMain ->prepare("SELECT eft_cycle, pif_cycle_date, term_switch  FROM enhance_fee_cycles  WHERE cycle_num = '1'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($eft_cycle, $pif_cycle_date, $term_switch);
                 $stmt->fetch();
                 
                 $this->eftEnhanceCycle = $eft_cycle;
                 $this->pifEnhanceCycleDate = $pif_cycle_date;
                 $this->enhanceAnnualCycleDate = date("F jS", strtotime($this->pifEnhanceCycleDate));
                 $this->enhanceTermSwitch = $term_switch;
                 
                 
                 
         }
}
//========================================================
function  loadEftEnhanceCycle() {

if(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->monthlyServiceName)) && ($this->numberMonths >= 12)) { 

    $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT eft_cycle, pif_cycle_date, term_switch  FROM enhance_fee_cycles  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);
   $stmt->fetch();
   
   //break up the guarentee cycle date
$day = date("d", strtotime($annual_cycle_date));
$month = date("m", strtotime($annual_cycle_date));
$year = date("Y");

$enhanceCycleDateString = "$month/$day/$year";
$enhanceCycleDateSecs = strtotime($enhanceCycleDateString);

//fro semi annual dates
$enhanceCycleDateSecsAnnual = $enhanceCycleDateSecs + 15724800;
$semiOne = date("F jS", $annual_cycle_date); 
$semiAnnual2=  date("F jS", $enhanceCycleDateSecsAnnual); 

//for quarterly dates
$enhanceCycleDateQuarter2 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year)); 
$enhanceCycleDateQuarter3 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateQuarter4 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));

//for monthly dates
$enhanceDay = date('d', strtotime($annual_cycle_date));
$enhanceCycleDateMonths2 = date("F jS", mktime(0, 0, 0, $month + 1, $day, $year)); 
$enhanceCycleDateMonths3 = date("F jS", mktime(0, 0, 0, $month + 2, $day, $year));
$enhanceCycleDateMonths4 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year));
$enhanceCycleDateMonths5 = date("F jS", mktime(0, 0, 0, $month + 4, $day, $year));
$enhanceCycleDateMonths6 = date("F jS", mktime(0, 0, 0, $month + 5, $day, $year));
$enhanceCycleDateMonths7 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateMonths8 = date("F jS", mktime(0, 0, 0, $month + 7, $day, $year));
$enhanceCycleDateMonths9 = date("F jS", mktime(0, 0, 0, $month + 8, $day, $year));
$enhanceCycleDateMonths10 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$enhanceCycleDateMonths11 = date("F jS", mktime(0, 0, 0, $month + 10, $day, $year));
$enhanceCycleDateMonths12 = date("F jS", mktime(0, 0, 0, $month + 11, $day, $year));

$todaysDateSecs = time();
   
   
   $this->enhanceAnnualCycleDate = date("F jS", strtotime($annual_cycle_date));

 switch($this->eftEnhanceCycle) {
        case "A":
        $this->enhanceFeeEft = sprintf("%.2f", $this->enhanceFee / 1);
        $this->enhanceRequest = "<p>I acknowledge that an annual enhancement fee of <span class=\"boldLine\">\$$this->enhanceFeeEft</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> this year and on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year.</p>";
        break;
        case "B":
        $this->enhanceFeeEft = sprintf("%.2f", $this->enhanceFee / 2);
        $this->enhanceRequest = "<p>I acknowledge that a bi-annual enhancement fee of <span class=\"boldLine\">\$$this->enhanceFeeEft</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on <span class=\"boldLine\">$semiOne</span> and <span class=\"boldLine\">$semiAnnual2</span> of this year and on <span class=\"boldLine\">$semiOne</span> and <span class=\"boldLine\">$semiAnnual2</span> of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates.</p>";
        break;
        case "Q":
        $this->enhanceFeeEft = sprintf("%.2f", $this->enhanceFee / 4);
        $this->enhanceRequest = "<p>I acknowledge that a quarterly enhancement fee of <span class=\"boldLine\">\$$this->enhanceFeeEft</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$semiOne</span> $enhanceCycleDateQuarter2 $enhanceCycleDateQuarter3 and $enhanceCycleDateQuarter4 of this year and on day <span class=\"boldLine\">$semiOne</span> $enhanceCycleDateQuarter2 $enhanceCycleDateQuarter3 and $enhanceCycleDateQuarter4 of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates of each quarter.</p>";
        break;
        case "M":
        $this->enhanceFeeEft = sprintf("%.2f", $this->enhanceFee / 12);
        $this->monthlyDues = $this->monthlyDues + $this->enhanceFeeEft;
        $this->monthlyDues = sprintf("%.2f", $this->monthlyDues);
        $this->enhanceRequest = "<p>I acknowledge that a monthly enhancement fee of <span class=\"boldLine\">\$$this->enhanceFeeEft</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$enhanceDay</span> of every month of this year and on day <span class=\"boldLine\">$enhanceDay</span> of every month of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates of each month.</p>";
        break;        
        }
        
               //checks to see if g fee is applicaple
               switch ($this->enhTermSwitch) {
                   case "T":
                   if($this->termType == "O") {                      
                      $this->enhanceRequest = "";
                      }
                   break;
                   case "O":
                   if($this->termType == "T") {
                      $this->enhanceRequest = "";
                      }              
                   break;
                   case "B":
                   if(($this->termType == "T") || ($this->termType == "O")) {
                      $this->enhanceRequest;
                      }    
                   break;
                }        
        
  }

}
//========================================================
function checkGuaranteeFee() {

if($this->rateGuaranteeFee == "0.00") {
    $this->guaranteeRequest = "";
    
   }else{

if(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->monthlyServiceName)) && ($this->numberMonths >= 12)) {   
     
   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT eft_cycle, annual_cycle_date, term_switch  FROM guarantee_fee_cycles  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);
   $stmt->fetch();
   
   $annualCycleDate = date("F jS", strtotime($annual_cycle_date));
$rateDay = date('d', strtotime($annual_cycle_date));   
   
   $day = date("d", strtotime($annual_cycle_date));
$month = date("m", strtotime($annual_cycle_date));
$year = date("Y");
$guaranteeCycleDateString = "$month/$day/$year";
$guaranteeCycleDateSecs = strtotime($guaranteeCycleDateString);

//fro semi annual dates
$guaranteeCycleDateSecsAnnual = date("F jS", $guaranteeCycleDateSecs + 15724800+(86400*3)); 

//for quarterly dates
$guaranteeCycleDateQuarter2 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year)); 
$guaranteeCycleDateQuarter3 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateQuarter4 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));

//for monthly dates
$guaranteeCycleDateMonths2 = date("F jS", mktime(0, 0, 0, $month + 1, $day, $year)); 
$guaranteeCycleDateMonths3 = date("F jS", mktime(0, 0, 0, $month + 2, $day, $year));
$guaranteeCycleDateMonths4 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year));
$guaranteeCycleDateMonths5 = date("F jS", mktime(0, 0, 0, $month + 4, $day, $year));
$guaranteeCycleDateMonths6 = date("F jS", mktime(0, 0, 0, $month + 5, $day, $year));
$guaranteeCycleDateMonths7 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateMonths8 = date("F jS", mktime(0, 0, 0, $month + 7, $day, $year));
$guaranteeCycleDateMonths9 = date("F jS", mktime(0, 0, 0, $month + 8, $day, $year));
$guaranteeCycleDateMonths10 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$guaranteeCycleDateMonths11 = date("F jS", mktime(0, 0, 0, $month + 10, $day, $year));
$guaranteeCycleDateMonths12 = date("F jS", mktime(0, 0, 0, $month + 11, $day, $year));
   
   
   switch($eft_cycle) {
    case "A":
        $this->rateGuaranteeFee = sprintf("%.2f", $this->rateGuaranteeFee / 1);
        $this->guaranteeRequest ="<p>I acknowledge that an annual rate guarantee fee of <span class=\"boldLine\">\$$this->rateGuaranteeFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$annualCycleDate</span> of this year and on <span class=\"boldLine\">$annualCycleDate</span> of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year.</p>"; 
        break;
    case "B":
        $this->rateGuaranteeFee = sprintf("%.2f", $this->rateGuaranteeFee / 2);
        $this->guaranteeRequest ="<p>I acknowledge that a bi-annual rate guarantee fee of <span class=\"boldLine\">\$$this->rateGuaranteeFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$annualCycleDate</span> and <span class=\"boldLine\">$guaranteeCycleDateSecsAnnual</span> of this year and on <span class=\"boldLine\">$annualCycleDate</span> and <span class=\"boldLine\">$guaranteeCycleDateSecsAnnual</span> of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates.</p>";
        break;
    case "Q":
       $this->rateGuaranteeFee = sprintf("%.2f", $this->rateGuaranteeFee / 4);
       $this->guaranteeRequest = "<p>I acknowledge that a quarterly rate guarantee fee of <span class=\"boldLine\">\$$this->rateGuaranteeFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$annualCycleDate</span> and $guaranteeCycleDateQuarter2 $guaranteeCycleDateQuarter3 and $guaranteeCycleDateQuarter4  of this year and on day <span class=\"boldLine\">$annualCycleDate</span> and $guaranteeCycleDateQuarter2 $guaranteeCycleDateQuarter3 and $guaranteeCycleDateQuarter4  of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates of each quarter.</p>";
        break;
    case "M":
        $this->rateGuaranteeFee = sprintf("%.2f", $this->rateGuaranteeFee / 12);
        $this->monthlyDues = $this->monthlyDues + $this->rateGuaranteeFee;
        $this->guaranteeRequest ="<p>I acknowledge that a monthly rate guarantee fee of <span class=\"boldLine\">\$$this->rateGuaranteeFee</span>  will be charged to each contract for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$rateDay</span> of every month of this year and on day <span class=\"boldLine\">$rateDay</span> of every month of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates of each month.</p>";
        break;
    }
               //checks to see if g fee is applicaple
               switch ($term_switch) {
                   case "T":
                   if($this->termType == "O") {                      
                      $this->guaranteeRequest = "";
                      }
                   break;
                   case "O":
                   if($this->termType == "T") {
                      $this->guaranteeRequest = "";
                      }              
                   break;
                   case "B":
                   if(($this->termType == "T") || ($this->termType == "O")) {
                      $this->guaranteeRequest;
                      }    
                   break;
                }
    
  }
  
  
  
  
  
 }

}
//========================================================
function loadBillingDate() {

//calcs the billing date 
$todayDay = date("d");
//check if iis past or present then generate the billing date
if($this->billingDay > $todayDay)  {
  $billingDate = date("F j, Y"  ,mktime(0, 0, 0, date("m")  , $this->billingDay, date("Y")));
  $nextDate = date("F Y"  ,mktime(0, 0, 0, date("m")+1  , $this->billingDay, date("Y")));
  }
if($this->billingDay < $todayDay)  {
  $billingDate = date("F j, Y"  ,mktime(0, 0, 0, date("m")+1  , $this->billingDay, date("Y")));
  $nextDate = date("F Y"  ,mktime(0, 0, 0, date("m")+2  , $this->billingDay, date("Y")));
  }
if($this->billingDay == $todayDay)  {
  $billingDate = date("F j, Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
  $nextDate = date("F Y"  ,mktime(0, 0, 0, date("m")+1  , date("d"), date("Y")));
  }
  
 $this->collectionDates = "<p class=\"collect\">The first payment of <span class=\"boldLine\">\$$this->newMonthlyPayment</span> shall be collected on <span class=\"boldLine\">$billingDate</span> for the month of <span class=\"boldLine\">$nextDate</span>.</p>";

}
//========================================================
function loadCancelation() {

$this->cancelationTerms ="<p>Cancellation: I understand that I am in full control of my payment in accordance with this service agreement,
and if at any time, after the $this->contractQuit day cancellation procedure above, I decide to discontinue, I will simply notify $this->businessName , in writing by no later than 10th of the desired month of cancellation. (This provision does not apply to a Paid In Full Service Agreement or Open Ended Service Aggreement) Notification after the 10th of the desired month will require an additional1 month fees. Not applicable to any cancellation fees otherwise due. To cancel, I will include a legible copy of agreement or cancellation form, ORIGINAL MEMBERSHIP CARD and \$$this->cancelationFee cancellation fee. Such notice shall be sent to $this->businessName, $this->businessAddress. Any variations from the cancellation procedure may result in a delay in processing cancellation.</p>";

}
//========================================================
function loadMonthlyTransactionRequest() {
 
if(($this->monthlyBillingType != "") && ($this->newMonthlyPayment != "")) {

if($this->monthlyDues == $this->newMonthlyPayment) {
   $combinedHeader = "";
   }else{
   $combinedHeader = "COMBINED";
   }
/*
//check for an existing guarantee and enhance fees   
if($this->currentGuaranateeFee != null) {
   $this->newMonthlyPayment = $this->newMonthlyPayment + $this->currentGuaranateeFee;
   $guaranteeBlurb = "including a monthly Rate Guarantee Fee of \$$this->currentGuaranateeFee ";
  }else{
   $guaranteeBlurb = "";
  }

if($this->currentEnhanceFee != null) {
   $this->newMonthlyPayment = $this->newMonthlyPayment + $this->currentEnhanceFee;
   $enhanceBlurb = "including a monthly Enhancement Fee of \$$this->currentEnhanceFee ";
  }else{
   $enhanceBlurb = "";
  }
*/


$transactionDivStart ="
<div id=\"monthlyHeader\">
<span class=\"subHeader\">$combinedHeader MONTHLY TRANSACTION REQUEST:</span>
</div>
<div id=\"underline4\"></div>
<div id=\"billingRequest\">";
$endDiv = "</div>";

//checks to see if a g fee is needed then checks if the g fee is available then parses
if($this->guaranteeFlag == 1) {
    $this->checkGuaranteeFee();
   }

if($this->eftEnhanceFlag == 1) {
    $this->loadEftEnhanceCycle();
   }
 
$this->loadBillingDate();
$this->loadCancelation();

$separator = "<p class=\"line\"></p>";
 
    switch($this->monthlyBillingType) {
    case "CR":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my credit card company to make a payment of <span class=\"boldLine\">\$$this->newMonthlyPayment</span> $guaranteeBlurb $enhanceBlurb and charge it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "BA":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my bank to make an ACH payment of <span class=\"boldLine\">\$$this->newMonthlyPayment</span> $guaranteeBlurb $enhanceBlurb and post it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and drafted for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and drafted should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates  $this->cancelationTerms $separator $endDiv";
        break;
    case "CH":
        $this->transactionRequest = "$transactionDivStart <p>I acknowledge that a check payment of <span class=\"boldLine\">\$$this->newMonthlyPayment</span> $guaranteeBlurb $enhanceBlurb is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I authorize a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> to be assessed and billed for any check returned for insufficient funds or for any other reason. I acknowledge a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "CA":         
        $this->transactionRequest ="$transactionDivStart <p>I acknowledge that a cash payment of <span class=\"boldLine\">\$$this->newMonthlyPayment</span> $guaranteeBlurb $enhanceBlurb is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract.  I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that any cash payment is subject to verification of authenticity and in the event the cash is found to be counterfeit the business and or company is required to hold the currency and report it to the proper authorities. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;    
    default:
       $this->transactionRequest = "";
   }
}
}

//========================================================
function loadPifEnhanceCycle() {

if($this->pifEnhanceFlag == 1) {
$this->enhanceFeePif = sprintf("%.2f", $this->enhanceFee / 1);
//$this->enhanceRequestPif = "<p>I acknowledge that an annual enhancement fee of <span class=\"boldLine\">\$$this->enhanceFeePif</span> will be charged to each Paid In Full member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> this year and on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year.</p>";

$this->enhanceRequestPif = "";
}

}
//=====================================
function loadSignupSection()  {

$this->loadPifEnhanceCycle();
$this->loadContractLocation();
$this->signupSection = "$this->enhanceRequestPif  $this->contractLocation";

}
//===========================================
function loadSalesPersonName(){
    $userId = $_SESSION['user_id'];
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT emp_fname, emp_lname FROM employee_info  WHERE user_id = '$userId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($emp_fname, $emp_lname);
    $stmt->fetch();
     $this->employeeName = "$emp_fname $emp_lname";

}
//====================================
function getName(){
     return($this->name);
}
function getCName(){
     return($this->cName);
}
function getLogoImage() {
        return($this->logoImage);
        }
function getContractTypeHeader() {
        return($this->contractTypeHeader);
        }
function getStreetAddress() {
        return($this->streetAddress);
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
function getGroupTypeInfo() {
       return($this->groupTypeInfo);
       }
function getBusinessName() {
       return($this->businessName);
       }
function getBusinessDba() {
       return($this->businessDba);
       }
function getUpgradeHeader1() {
       return($this->upgradeHeader1);
       }       
function getProrateTableRows() {
       return($this->prorateTableRows);
       }
function getNewServices() {
       return($this->newServices);
       }
function getInitialPayments() {
       return($this->initialPayments);
       }
function getContractTerms() {
       return($this->contractTerms);
       }
function getTermsCss() {
       return($this->termsCss);
       }
function getTransactionRequest() {
       return($this->transactionRequest);
       }
function getSignupSection() {
       return($this->signupSection);
       }
function getSig() {
       return($this->signature);
       } 
function getInitPayRowsEmail() {
       return($this->initialPaymentRowsEmail);
       } 
function getNewServicesEmail() {
       return($this->newServicesEmail);
       }
function getProTablesEmail() {
       return($this->prorateTableRowsEmail);
       }       
function getEmpName() {
       return($this->employeeName);
       }           
        
      
}
?>
