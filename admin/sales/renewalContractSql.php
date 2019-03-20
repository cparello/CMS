<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//date_default_timezone_set('America/Los_Angeles');
//=======================================================

//==============================================end timeout

class  renewalContractSql{

private $contractKey = null;
private $serviceKey = null;
private $logoImage = null;
private $imageName = null;
private $imagePath = null;
private $imageAspect = null;
private $renewalTypeHeader = "Service Renewal Agreement";
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $contractTerms = null;
private $contractLocation = null;
private $businessName = null;
private $businessAddress = null;
private $businessDba = null;
private $groupType = null;
private $groupName = null;
private $groupTypeInfo = null;
private $productList = null;
private $productRow = null;
private $serviceLocation = null;
private $serviceTermText = null;
private $serviceTerm = null;
private $serviceQuantity = null;
private $productDivider = null;
private $summaryTableRows = null;
private $renewalFee = null;
private $serviceTotal = null;
private $grandTotal = null;
private $todaysPayment = null;
private $balanceDue = null;
private $balanceDueDate = null;
private $initialPayments = null;
private $genericTerms = null;
private $rejectionFee = null;
private $lostCardFee = null;
private $renewalGracePeriod = null;
private $startDate = null;
private $endDate = null;


function setPastDue($pastDueAmount) {
       $this->pastDueAmount = $pastDueAmount;
       }
function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setGroupType($groupType) {
       $this->groupType = $groupType;
       }
function setGroupName($groupName) {
       $this->groupName = $groupName;
       }
function setProductListArray($productList) {
       $this->productList = $productList;
       }
function setRenewalFee($renewalFee) {
       $this->renewalFee = $renewalFee;
       }
function setServiceTotal($serviceTotal) {
       $this->serviceTotal = $serviceTotal;
       }
function setGrandTotal($grandTotal) {
       $this->grandTotal = $grandTotal;
       }
 function setTodaysPayment($todaysPayment) {
       $this->todaysPayment = $todaysPayment;
       }
function setBalanceDue($balanceDue) {
       $this->balanceDue = $balanceDue;
       }
function setBalanceDueDate($balanceDueDate) {
       $this->balanceDueDate = $balanceDueDate;
       }  
function setPifOutBool($pif_out_bool){
        $this->pifOutBool = $pif_out_bool;
        }
function setPifOutTime($pif_out_time){
        $this->pifOutTime = $pif_out_time;
        }
function setPifOutMoneyOwed($pif_out_money_owed){
            $this->pifOutMoneyOwed = $pif_out_money_owed;
        }
function setYearQuantity($year_quantity){
            $this->newServiceQuantity = $year_quantity;
        }  
function  setOldKey($old_key){
    $this->oldKey = $old_key;
}
function  setChangedServiceBool($changed_service_bool){
    $this->changedServiceBool = $changed_service_bool;
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
//----------------------------------------------------------------
function parseServiceTermText() {

  switch ($this->serviceTerm) {
        case "C":
        $this->serviceTermText = "$this->newServiceQuantity Class(s)";
        break;
        case "D":
        $this->serviceTermText = "$this->newServiceQuantity Day(s)";
        break;
        case "W":
        $this->serviceTermText = "$this->newServiceQuantity Weeks(s)";
        break;
        case "Y":
        $this->serviceTermText = "$this->newServiceQuantity Year(s)";
        break;  
      }


}
//----------------------------------------------------------------
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
//-----------------------------------------------------------------
function loadContractLocation()  {
/*for now this is set manually. the final version will look for the assigned IP address of the browser and use a sql table to designate the club id and the location name etc*/

$this->locationId = '6883';
$todaysDate = date("F j, Y");
$this->contractLocation = "<p>Executed at $this->businessName $this->businessAddress on $todaysDate</p>";

}
//--------------------------------------------------------------------
function formatLogoImage() {

$this->logoImage = "<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"$this->imagePath$this->imageName\" $this->imageAspect /></a>";

}
//======================================
function loadRenewalContractDefaults()  {

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

$this->renewalTypeHeader = "$this->groupType $this->renewalTypeHeader";

$stmt->close();

$this->formatLogoImage();

}
//======================================
function parseContactInfo($contactInfo) {
$this-> loadSalesPersonName();
if($contactInfo != 'NA')  {

     $contactInfo = explode("|", $contactInfo);
     $this->streetAddress = "$contactInfo[0] $contactInfo[1], $contactInfo[2] $contactInfo[3]";
     $this->primaryPhone = $contactInfo[4];
     $this->cellPhone = $contactInfo[5];
     $this->emailAddress = $contactInfo[6];
     
   }else{
   
  $dbMain = $this->dbconnect();
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
//=======================================
function parseGroupInfo($groupInfo)  {

if($groupInfo != 'NA') {

//parse the group type info
$group_info_array = explode("|", $groupInfo);
$groupAddress = $group_info_array[0];
$groupPhone = $group_info_array[1];

 switch($this->groupType) {
        case "Single":
        $this->groupTypeInfo = "";
        break;
        case "Family":
        $this->groupTypeInfo = "";
        break;
        case "Business":
        $titleName = "Business";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$this->groupType Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$this->groupType Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";        
        break;
        case "Organization":
        $titleName = "Organization";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$this->groupType Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$this->groupType Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";                        
        break;
        }

  }else{
  
  
          if(($this->groupType == "Business") || ($this->groupType == "Organization")) {
  
             $dbMain = $this->dbconnect();
             $stmt = $dbMain ->prepare("SELECT group_type, group_name, group_address, group_phone FROM member_groups WHERE contract_key ='$this->contractKey'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($group_type, $group_name, $group_address, $group_phone);
             $stmt->fetch();

            $this->groupAddress = $group_address;
            $this->groupPhone = $group_phone;
            $this->groupName = $group_name;
            $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$this->groupType Name:</td><td class=\"nameSakes\">$this->groupName</td></tr><tr><td class=\"nameTitles\">$this->groupType Address</td><td class=\"nameSakes\">$this->groupAddress $this->groupPhone</td></tr>";  
            $stmt->close();
            }  
  }

}
//=========================================
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_name, business_dba, business_address FROM company_names WHERE business_name !='' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_name, $business_dba, $business_address);   
$stmt->fetch(); 
$stmt->close(); 

$this->businessName = $business_name;
$this->businessDba = $business_dba;
$this->businessAddress = $business_address;

}
//=========================================
function parseStartEndDates() {

$startDateArray = explode(" ", $this->startDate);
$dateArray = $startDateArray[0];
$dateArrayOne = explode("-", $dateArray);

$year = $dateArrayOne[0];
$month = $dateArrayOne[1];
$day = $dateArrayOne[2];

//reset start date to 0 hours min secs
$this->startDate = date("F j, Y"  ,mktime(0, 0, 0, $month, $day, $year));

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = 'NA';
        break;
        case "D":
        $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month, $day+$this->newServiceQuantity, $year));
        break;
        case "W":
        $days = $this->newServiceQuantity * 7;
        $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month, $day+$days, $year));
        break;
        case "M":
        $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month+$this->newServiceQuantity, $day, $year));
        break;
        case "Y":
        if ($this->newServiceQuantity == '.25'){
            $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month+3, $day, $year));
        }elseif($this->newServiceQuantity == '.50'){ 
            $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month+6, $day, $year));
        }else{
          $this->endDate = date("F j, Y"  ,mktime(23, 59, 59, $month, $day, $year+$this->newServiceQuantity));  
        }
        break;  
      }

}
//------------------------------------------------------------------------
function loadGracePeriod() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gracePeriod);   
$stmt->fetch();   

return "$gracePeriod";

 $stmt->close();
}
//-------------------------------------------------------------------------
function parseStartDate() {

$gracePeriod = $this->loadGracePeriod();
$gracePeriodSeconds = $gracePeriod * 86400;
$startDateSeconds = strtotime($this->startDate);

//echo"$this->startDate";

$todaysDateSeconds = time();

//check to see if eligible
$renewalLimitSeconds = $startDateSeconds + $gracePeriodSeconds;

  if(($todaysDateSeconds > $startDateSeconds) && ($startDateSeconds < $renewalLimitSeconds)) {
    $this->startDate = date("Y-m-d H:i:s");    
    }


}
//------------------------------------------------------------------------
function parseServices() {

//parse the services selected
$productFieldArray =  explode("|", $this->productRow);
$this->serviceKey = $productFieldArray[0];
$this->standardRenewal = $productFieldArray[1];
$this->earlyRenewal = $productFieldArray[2];

$dbMain = $this->dbconnect();

if($this->pifOutBool == 0){
    
     if ($this->changedServiceBool == 1){
        //first we get all of the pertinant data from the original contract last generated
            $stmt = $dbMain ->prepare("SELECT group_number, club_id,  service_quantity, service_term, end_date FROM paid_full_services WHERE  contract_key = '$this->contractKey' AND service_key = '$this->oldKey' ORDER BY signup_date DESC LIMIT 1");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($group_number, $club_id,  $service_quantity, $service_term, $end_date);
             $stmt->fetch();
             $stmt->close();
             
             $stmt = $dbMain ->prepare("SELECT service_type, service_cost FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_key = '$this->serviceKey' AND service_quantity = '$this->newServiceQuantity'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($newServiceName, $newServiceCost);
                $stmt->fetch();
                $stmt->close();
            
            
            $this->groupNumber = $group_number;
            $this->clubId = $club_id;
            $this->serviceName = $newServiceName;
            //$this->newServiceQuantity = $service_quantity;
            $this->serviceTerm = $service_term;
            $this->unitPrice = $newServiceCost;
            $this->unitRenewRate = $newServiceCost;
            $this->groupPrice = $newServiceCost;
     }else{
            $stmt = $dbMain ->prepare("SELECT   group_number, club_id, service_name,  service_quantity, service_term, unit_price, unit_renew_rate,  group_price, group_renew_rate, end_date FROM paid_full_services WHERE  contract_key = '$this->contractKey' AND service_key = '$this->serviceKey' ORDER BY signup_date DESC LIMIT 1");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($group_number, $club_id, $service_name,  $service_quantity, $service_term, $unit_price, $unit_renew_rate,  $group_price, $group_renew_rate, $end_date);
             $stmt->fetch();
             $stmt->close();
            
            
            $this->groupNumber = $group_number;
            $this->clubId = $club_id;
            $this->serviceName = $service_name;
            //$this->newServiceQuantity = $service_quantity;
            $this->serviceTerm = $service_term;
            $this->unitPrice = $unit_price;
            $this->unitRenewRate = $unit_renew_rate;
            $this->groupPrice = $group_price;
     }

}else{
    $stmt = $dbMain ->prepare("SELECT group_type, group_number FROM member_groups WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($group_type, $group_number);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT service_type, club_id, service_quantity, service_term, service_cost FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key WHERE service_info.service_key =  '$this->serviceKey' AND service_quantity = '$this->newServiceQuantity' ORDER BY service_cost ASC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceName, $this->clubId, $this->serviceQuantity, $this->serviceTerm, $this->unitPrice);
    $stmt->fetch();
    $stmt->close();
    $this->unitRenewRate = $this->unitPrice;
    $this->groupPrice = $this->unitPrice;
    $this->groupNumber = $group_number;
    //echo"$this->newServiceQuantity === $group_type $this->serviceName, $this->clubId, $this->serviceQuantity, $this->serviceTerm, $this->unitPrice ";
    //exit;
}


//now we compare to see if this is a standard renewal or early renewal
if($this->earlyRenewal != 'NA') {
   $this->groupRenewRate = $this->earlyRenewal;
   }else{
   $this->groupRenewRate = $this->standardRenewal;
   }


$groupNumber = $this->groupNumber;
$this->loadServiceLocation();
$this->parseServiceTermText();

if($this->pifOutBool == 0){
$unitPrice = sprintf("%.2f", $this->groupRenewRate / $groupNumber);
$unitRenewRate = sprintf("%.2f", $this->groupRenewRate / $groupNumber);
}else{
    $unitPrice = sprintf("%.2f", ($this->groupRenewRate-$this->pifOutMoneyOwed) / $groupNumber);
    $unitRenewRate = sprintf("%.2f", ($this->groupRenewRate-$this->pifOutMoneyOwed) / $groupNumber);  
}
//if a single meber ship change to NA for the following
if($this->groupType == "Single")  {
  $groupPrice = 'NA';
  $groupRenewRate = 'NA';
  }else{
  $groupPrice = $this->groupRenewRate;
  $groupRenewRate = $this->groupRenewRate;
  }
if($this->pifOutBool == 0){
//parse the start and end dates
    $this->startDate = $end_date;
    $this->pifOutTime = 'NA';
    $this->pifOutMoneyOwed = 'NA';
//next check to see if the service has expired and if it is in the grace period

$this->parseStartDate();
$this->parseStartEndDates();
}else{
    $this->startDate = date("F j, Y");
    $this->endDate = date("F j, Y"  ,mktime(0, 0, 0, date('m')+$this->pifOutTime, date('d'), date('Y')+$this->newServiceQuantity));
    $this->pifOutMoneyOwed = sprintf("%.2f",$this->pifOutMoneyOwed); 
    $this->pifOutMoneyOwed = "$$this->pifOutMoneyOwed";
    $this->pifOutTime = "$this->pifOutTime Months";
}

$this->summaryTableRows .="
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
$this->serviceTermText
</td>

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
<td class=\"fieldHeader\">
Group Renew Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$$unitPrice
</td>
<td class=\"fieldValues\">
$$unitRenewRate
</td>
<td class=\"fieldValues\">
$groupPrice
</td>
<td class=\"fieldValues\">
$groupRenewRate
</td>
</tr>

<tr>
<td class=\"fieldHeader\">
Start Date
</td>
<td colspan=\"1\" class=\"fieldHeader\">
End Date
</td>
<td colspan=\"2\" class=\"fieldHeader\">
Buyout Months
</td>
<td colspan=\"2\" class=\"fieldHeader\">
Buyout Amount
</td>
<td colspan=\"2\" class=\"fieldHeader\">
Past Due Amount
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->startDate
</td>
<td colspan=\"1\" class=\"fieldValues\">
$this->endDate
</td>
<td colspan=\"2\" class=\"fieldValues\">
$this->pifOutTime
</td>
<td colspan=\"2\" class=\"fieldValues\">
$this->pifOutMoneyOwed
</td>
<td colspan=\"2\" class=\"fieldValues\">
$$this->pastDueAmount
</td>
</tr>



$this->productDivider
";

$this->summaryTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Quantity</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Duration</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceTermText</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Unit Cost</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Unit Renew Rate</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Cost</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Group Renew Rate</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$$unitPrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$$unitRenewRate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$groupPrice</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$groupRenewRate</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Buyout Months</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Buyout Amount</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Past Due Amount</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->pifOutTime</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->pifOutMoneyOwed</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$$this->pastDueAmount</font></th>
</tr>



$this->productDivider
";
}
//=========================================
function loadServices()  {

$productListArray = explode("#", $this->productList);
$productCount = count($productListArray);
$productCount = $productCount -1;

for($i=0; $i < $productCount; $i++)  {

            if($i == $productCount - 1)  {
            $this->productDivider = "";  
            }else{
            $this->productDivider = "<tr><td colspan=\"4\" class=\"fieldValues pad2\"><p class=\"dash\"></p></td></tr>"; 
            }  


       $this->productRow = $productListArray[$i];
       $this->parseServices();                             
     }
     
}

//=========================================
function loadInitialPayments()  {

$dueDateArray = explode(",", $this->balanceDueDate);
$this->balanceDueDate = "$dueDateArray[1], $dueDateArray[2]";

$this->todaysPayment = sprintf("%.2f", $this->todaysPayment);


 $renewalFeeRow = "<tr><td class=\"nameTitles2\">Renewal Fee:</td><td class=\"nameSakes2\">$this->renewalFee</td><td class=\"nameSakes3\"></td></tr>";
 $servicesTotalRow = "<tr><td class=\"nameTitles2\">Services Total:</td><td class=\"nameSakes2\">$this->serviceTotal</td><td class=\"nameSakes3\"></td></tr>";
 $totalDueRow = "<tr><td class=\"nameTitles2 pad\">TOTAL DUE:</td><td class=\"nameSakes4 pad\">$this->grandTotal</td><td class=\"nameSakes3\"></td></tr>";
 $todaysPaymentRow = "<tr><td class=\"nameTitles2\">TODAYS PAYMENT:</td><td class=\"nameSakes2\">$this->todaysPayment</td><td class=\"nameSakes3\"></td></tr>";
 $balanceDueRow = "<tr><td class=\"nameTitles2\">BALANCE DUE:</td><td class=\"nameSakes2\">$this->balanceDue</td><td class=\"nameSakes3\">DUE DATE:<span class=\"dueDate\">$this->balanceDueDate</span></td></tr>";
 
 $renewalFeeRowEmail = "<tr>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->renewalFee</font></th>
 </tr>";
 $servicesTotalRowEmail = "<tr>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->serviceTotal</font></th>
 </tr>";
 $totalDueRowEmail = "<tr>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TOTAL DUE:</b>&nbsp;&nbsp;&nbsp;</font></th>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->grandTotal</font></th>
 </tr>";
 $todaysPaymentRowEmail = "<tr>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TODAYS PAYMENT:</b>&nbsp;&nbsp;&nbsp;</font></th>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->todaysPayment</font></th>
 </tr>";
 $balanceDueRowEmail = "<tr>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Balance Due:<b/>&nbsp;&nbsp;&nbsp;$this->balanceDue</font></th>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>DUE DATE:</b></font></th>
 <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->balanceDueDate</font></th>
 </tr>";
 
 $this->initialPayments =  "$renewalFeeRow $servicesTotalRow $totalDueRow $todaysPaymentRow $balanceDueRow";
    $this->initialPaymentsEmail =  "$renewalFeeRowEmail $servicesTotalRowEmail $totalDueRowEmail $todaysPaymentRowEmail $balanceDueRowEmail";
}
//=========================================
function createGeneralTerms() {

$payQuitBlurb = "YOU, THE BUYER, MAY CANCEL THIS AGREEMENT AT ANY TIME PRIOR TO MIDNIGHT OF THE $this->contractQuit  BUSINESS
DAY AFTER THE DATE OF THIS AGREEMENT, EXCLUDING SUNDAYS AND HOLIDAYS.";

$replacementCardBlurb = "I ACKNOWLEDGE THAT IN THE EVENT MY MEMBERSHIP CARD IS LOST, STOLEN, OR DESTROYED I AGREE TO PAY A MEMBERSHIP CARD REPLACEMENT FEE OF \$$this->lostCardFee IN ORDER TO BE ISSUED A REPLACEMENT CARD.";

$renewalGraceBlurb ="PAID IN FULL MEMBERSHIPS ARE ELGIBLE FOR RENEWAL UNDER THE TERMS OF THIS CONTRACT WITHIN $this->renewalGracePeriod DAYS UPON THE EXPIRATION OF TERMS OF SERVICE.";

$this->contractTerms = "$this->genericTerms $renewalGraceBlurb $replacementCardBlurb $payQuitBlurb";

}
//=========================================
function loadContractTerms() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT rejection_fee, standard_renewal_grace, card_fee FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($rejectionFee, $standardRenewalGrace, $cardFee); 
   $stmt->fetch();
   
   
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();

$this->genericTerms = strtoupper($this->contractTerms);
//a rejection fee for overdrafts
$this->rejectionFee = $rejectionFee;
//lost card fee
$this->lostCardFee = $cardFee;
//number of days where after contract expires members can renew
$this->renewalGracePeriod = $standardRenewalGrace;


$this->createGeneralTerms();

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
//=========================================




//=========================================

function getLogoImage() {
        return($this->logoImage);
        }
function getRenewalTypeHeader() {
        return($this->renewalTypeHeader);
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
function getPrimaryPhone() {
       return($this->primaryPhone);
       }          
function getCellPhone() {
       return($this->cellPhone);
       }          
function getEmailAddress() {
       return($this->emailAddress);
       }          
function getContractLocation() {
       return($this->contractLocation);
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
function getSummaryTableRows() {
       return($this->summaryTableRows);
       }
function getInitialPayments() {
       return($this->initialPayments);
       }
function getContractTerms() {
       return($this->contractTerms);
       }
function getSig() {
       return($this->signature);
       } 
function getInitPaymentsEmail() {
       return($this->initialPaymentsEmail);
       }  
function getSummaryRowsEmail() {
       return($this->summaryTableRowsEmail);
       }
function getEmpName() {
       return($this->employeeName);
       }              
}
?>