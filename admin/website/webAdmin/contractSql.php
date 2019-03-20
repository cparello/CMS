<?php
session_start();
//==============================================end timeout
//date_default_timezone_set('America/Los_Angeles');
class  contractSql{

private $logoImage = null;
private $startDate = null;
private $imageName = null;
private $imagePath = null;
private $imageAspect = null;
private $genericTerms = null;
private $contractQuit = null;
private $contractTerms = null;
private $groupType = null;
private $groupTypeInfo = null;
private $contractType = null;
private $contractTypeHeader = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $businessName = null;
private $businessDba = null;
private $businessAddress = null;
private $productListArray = null;
private $productRow = null;
private $groupNumber = null;
private $serviceKey = null;
private $serviceLocation = null;
private $productDivider = null;
private $summaryTableRows = null;
private $termType = null;
private $transfer = null;
private $downPayment = null;
private $proRateDues = null;
private $processFeeEft = null;
private $initiationFee = null;
private $processFeePif = null;
private $pifServicesTotal = null;
private $todaysPayment = null;
private $balanceDue = null;
private $dueDate = null;
private $initialPayments = null;
private $pastDueGrace = null;
private $cancelationFee = null;
private $rejectionFee = null;
private $lateFee = null;
private $lostCardFee = null;
private $renewalGracePeriod = null;
private $enhanceFee = null;
private $enhanceFeeEft = null;
private $enhanceFeePif = null;
private $rateGuaranteeFee = null;
private $monthlyBillingType = null;
private $monthlyDues = null;
private $guaranteeRequest = null;
private $guaranteeFlag = null;
private $eftEnhanceFlag = null;
private $pifEnhanceFlag = null;
private $enhanceRequest = null;
private $enhanceRequestPif = null;
private $eftEnhanceCycle = null;
private $pifEnhanceCycleDate = null;
private $enhanceAnnualCycleDate = null;
private $collectionDates = null;
private $cancelationTerms = null;
private $signupSection = null;
private $contractLocation = null;
private $downPaymentDivisor = null;
private $monthlyServiceName = null;
private $numberMonths = null;
private $enhTermSwitch = null;
private $serviceDuration = null;
private $endDate = null;

function   setTotalGearArray($totalGearArray) {
        $this->totalGearArray = $totalGearArray;
        }

function  setTotalServiceArray($totalServiceArray) {
        $this->totalServiceArray = $totalServiceArray;
        }
function setGroupType($groupType) {
        $this->groupType = $groupType;
        }
function setGroupTypeInfo($groupTypeInfo ) {
        $this->groupTypeInfo = $groupTypeInfo;
        }
function setContractType($contractType) {
        $this->contractType = $contractType;
        }
function setProductListArray($productListArray) {
        $this->productListArray = $productListArray;
        }
function setGroupNumber($groupNumber) {
        $this->groupNumber = $groupNumber;
        }        
function setTermType($termType) {
        $this->termType  = $termType;
        }                
function setTransfer($transfer) {
        $this->transferArray  = $transfer;
        } 
function setDownPayment($downPayment) {
        $this->downPayment = $downPayment;
        }
function setProRateDues($proRateDues) {
        $this->proRateDues = $proRateDues;
        }
function setProcessFeeMonthly($processFeeEft) {
        $this->processFeeEft = $processFeeEft;
        }
function setInitiationFee($initiationFee) {
        $this->initiationFee = $initiationFee;
        } 
function setProcessFeePif($processFeePif) {
        $this->processFeePif = $processFeePif;
        }
function setPifServicesTotal($pifServicesTotal) {
       $this->pifServicesTotal = $pifServicesTotal;
        } 
function setTodaysPayment($todaysPayment) {
       $this->todaysPayment = sprintf("%.2f", $todaysPayment);
       }    
function setBalanceDue($balanceDue) {
       $this->balanceDue = $balanceDue;
       }    
function setDueDate($dueDate) {
       $this->dueDate = $dueDate;
       } 
function setMonthlyBillingType($monthlyBillingType) {
       $this->monthlyBillingType = $monthlyBillingType;
       }   
function setMonthlyDues($monthlyDues) {
       $this->monthlyDues = $monthlyDues;
       }
function setDatePicker($datepicker) {
   $this->datePicker = $datepicker;
   } 
function setSig($sig) {
   $this->signature = $sig;
   } 
function setPifQuantity($pifQuantity) {
   $this->pifQuantity = $pifQuantity;
   }
function setEftQuantity($eftQuantity) {
   $this->eftQuantity = $eftQuantity;
   }
 function setServTermArray($servTermArray){
   $this->termArray = $servTermArray;
   }
   
  function setPtBool($ptBool){
   $this->ptBool = $ptBool;
   }
//------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------
function parseStartEndDates() {

      

      

}
//----------------------------------------------------------------------
function loadContractLocation()  {
/*for now this is set manually. the final version will look for the assigned IP address of the browser and use a sql table to designate the club id and the location name etc*/

$this->locationId = '6883';
$todaysDate = date("F j, Y");
$this->contractLocation = "<p>Executed at $this->businessName $this->businessAddress on $todaysDate</p>";

}
//----------------------------------------------------------------
function loadServiceLocation() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_id FROM service_info WHERE service_key = '$this->serviceKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id);   
 $stmt->fetch();                         
 
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name);   
 $stmt->fetch();                         
 $stmt->close(); 
 
 if($club_id == 0) {
   $this->serviceLocation = "All Locations";
   }else{   
   $this->serviceLocation = $club_name;
   }

}
//----------------------------------------------------------------
function formatLogoImage() {

$this->logoImage = "<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"$this->imagePath$this->imageName\" $this->imageAspect /></a>";

}
//======================================
function loadContractDefaults()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect, contract_terms, contract_quit, liability_terms FROM contract_defaults WHERE contract_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($image_name, $image_path, $image_aspect, $contract_terms, $contract_quit, $this->liabilityTerms);   
$stmt->fetch();   

$this->imageName = $image_name;
$this->imagePath = $image_path;
$this->imageAspect = $image_aspect;
$this->contractTerms = $contract_terms;
$this->contractQuit = $contract_quit;

$stmt->close();

//echo "pt $this->ptBool";
//exit;

if ($this->ptBool == 1){
    $stmt = $dbMain ->prepare("SELECT pt_liability_waiver FROM website_training_options WHERE web_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($pt_liability_waiver);
    $stmt->fetch();
    $stmt->close();
    
    $this->contractTerms = $pt_liability_waiver;
}

$this->formatLogoImage();

}
//=====================================
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

$this->contractTypeHeader = "$titleName $type Agreement";

}
//=====================================
function parseContactInfo($contactInfo) {

 $contactInfo = explode("|", $contactInfo);

$this->firstName = $contactInfo[0];
$this->middleName = $contactInfo[1];
$this->lastName = $contactInfo[2];
$this->streetAddress = "$contactInfo[3] $contactInfo[4], $contactInfo[5] $contactInfo[6]";
$this->primaryPhone = $contactInfo[7];
$this->cellPhone = $contactInfo[8];
$this->emailAddress = $contactInfo[9];
}
//=====================================
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

 $_SESSION['business_name'] = $this->businessName;
 $_SESSION['business_address'] = $this->businessAddress;

}
//=====================================
function parsePaidFull() {

//var_dump($this->productRow);
//exit;

$productFieldArray =  explode(",", $this->productRow);
$serviceName = $this->serviceName = $productFieldArray[0];
$servNameBuff = explode('-',$serviceName);
$sname = trim($servNameBuff[0]);
$serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[3]);

if($this->ptBool == 2){
    $this->transfer = "No";
    $this->pifQuantity = $productFieldArray[1];
    //echo "$sname  vv $serviceQuantity";
    $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT service_term FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key  WHERE service_type = '$sname' AND service_quantity = '$serviceQuantity' LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->serviceTermText);
   $stmt->fetch();
   //.echo "$sname vcvcvc  $serviceQuantity fgdgdfgdfg $this->serviceTermText";
   
    $contractKey = $_SESSION['userContractKey'];
    $stmt = $dbMain-> prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contractKey' AND service_name LIKE '%Membership%'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($end_date);
    $stmt->fetch();
    $stmt->close();
    
    
}

//for renew rate if it is set to NA
if($productFieldArray[1] == 'NA') {
  $unitRenewRate = 'NA';
  $groupRenewRate = 'NA';
  }else{
  $unitRenewRate = sprintf("%.2f", $productFieldArray[2]/$this->pifQuantity);
  $groupRenewRate = sprintf("%.2f", $unitRenewRate);
  }
  
$unitPrice = sprintf("%.2f", $productFieldArray[2]/$this->pifQuantity);  



if ($serviceQuantity > 1){
    $moreBuff1 = "es";
    $moreBuff2 = "s";
    $moreBuff3 = "s";
    $moreBuff4 = "s";
}else{
    $moreBuff1 = "";
    $moreBuff2 = "";
    $moreBuff3 = "";
    $moreBuff4 = "";
}

 

switch($this->serviceTermText){
    case 'C':
     $duration = "Class$moreBuff1";
    break;
    case 'D':
     $duration = "Day$moreBuff2";
    break;
    case 'W':
     $duration = "Week$moreBuff3";
    break;
    case 'Y':
     $duration = "Year$moreBuff4";
    break;
}

$serviceTermText = "$productFieldArray[3] $duration";

//send to get start and end dates
//$durationArray  =  explode(" ", $serviceTermText);
//$this->serviceDuration = $durationArray[0];
$this->serviceTerm = $this->serviceTermText;
$this->serviceDuration = $productFieldArray[3];






if($this->ptBool == 2){    
    $month = date('m',strtotime($end_date));
    $day = date('d',strtotime($end_date));
    $year = date('Y',strtotime($end_date));
    
    $this->endDate = date("F j, Y"  ,mktime(0, 0, 0, $month  , $day, $year));

  switch ($this->serviceTerm) {
        case "C":
        $this->startDate = date('Y-m-d H:i:s');
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->startDate = date("F j, Y"  ,mktime(23,59,59, $month  , $day-$this->serviceDuration, $year));
        break;
        case "W":
        $days = $this->serviceDuration * 7;
        $this->startDate = date("F j, Y"  ,mktime(23,59,59, $month  , $day-$days, $year));
        break;
        case "M":
        $this->startDate = date("F j, Y"  ,mktime(23,59,59, $month-$this->serviceDuration, $day, $year));
        break;
        case "Y":
        $this->startDate = date("F j, Y"  ,mktime(23,59,59, $month, $day, $year-$this->serviceDuration));
        break;  
      }
}else{
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $this->startDate = date("F j, Y"  ,mktime(0, 0, 0, $month  , $day, $year));

  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->endDate = date("F j, Y"  ,mktime(23,59,59, $month  , $day+$this->serviceDuration, $year));
        break;
        case "W":
        $days = $this->serviceDuration * 7;
        $this->endDate = date("F j, Y"  ,mktime(23,59,59, $month  , $day+$days, $year));
        break;
        case "M":
        $this->endDate = date("F j, Y"  ,mktime(23,59,59, $month+$this->serviceDuration, $day, $year));
        break;
        case "Y":
        $this->endDate = date("F j, Y"  ,mktime(23,59,59, $month, $day, $year+$this->serviceDuration));
        break;  
      }
}




$groupPrice = sprintf("%.2f", $productFieldArray[2]/$this->pifQuantity);

//gets the service location
$this->serviceKey = trim($productFieldArray[5]);
$this->loadServiceLocation();


if($this->quantity == 1)  {
$groupPrice = "NA";
$groupRenewRate = "NA";
}

//this is for enhance fee if service qualifies then it is set
if((preg_match("/membership/i", $productFieldArray[0])) && (preg_match("/Year\(s\)/", $productFieldArray[3]))) {
    $this->pifEnhanceFlag = 1;  
   }

  switch($this->transfer) {
        case "N":
        $this->transfer = "No";
        break;
        case "Y":
        $this->transfer = "Yes";
        break;
        }
        

$sDur = explode(' ',$serviceTermText);
$servText = "$sDur[0] $sDur[1]";  

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
$this->pifQuantity
</td>
<td class=\"fieldValues\">
$sname
</td>
<td class=\"fieldValues\">
 $this->serviceLocation
</td>
<td class=\"fieldValues\" >
$servText
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
<td class=\"fieldHeader\">
Group Renew Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$unitPrice
</td>
<td class=\"fieldValues\">
$unitRenewRate
</td>
<td class=\"fieldValues\">
$groupPrice
</td>
<td class=\"fieldValues\">
$groupRenewRate
</td>
</tr>

<tr>
<td class=\"fieldHeader pad\">
Transferable
</td>
<td class=\"fieldHeader pad\">
Start Date
</td>
<td colspan=\"2\" class=\"fieldHeader pad\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$this->transfer
</td>
<td class=\"fieldValues\">
$this->startDate
</td>
<td colspan=\"2\" class=\"fieldValues\">
$this->endDate
</td>
</tr>

$this->productDivider
";



$this->summaryTableRowsEmail .="
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Quantity</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Name</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Location</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Service Duration</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->pifQuantity</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$sname</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$servText</font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Unit Cost</font></th>
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
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Transferable</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->transfer</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>

$this->productDivider
";

}
//=====================================
function parseMonthly() {
//var_dump($this->productRow);
$productFieldArray =  explode(",", $this->productRow);





$serviceName = $productFieldArray[0];
//$unitRenewRate = sprintf("%.2f", $productFieldArray[1]/$this->eftQuantity);
//$unitPrice = sprintf("%.2f", $productFieldArray[2]/$this->eftQuantity);
$numberMonthsText = "$productFieldArray[3]";
//$groupPrice = sprintf("%.2f", $productFieldArray[4]/$this->eftQuantity);

//gets the service location


//$groupRenewRate = sprintf("%.2f", $unitRenewRate);

//calcs the monthly payment
$numberMonths = preg_replace("/[^0-9]/", "", $productFieldArray[3]);
//$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);

//setup vars for enhance and payment guarantee fees
$this->monthlyServiceName = $serviceName;
$this->numberMonths = $numberMonths;
$this->serviceTerm = 'M';
$this->serviceDuration = $numberMonths;
$this->parseStartEndDates();

//$groupPrice = $groupPrice - $this->downPaymentDivisor;
//$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);



//check to see if this is only one member
if($this->groupNumber == 1)  {
$groupPrice = "NA";
$groupRenewRate = "NA";
}

//this is for enhance fee if service qualifies then it is set
if(($numberMonths >= 12) && (preg_match("/membership/i", $productFieldArray[0])) && ($this->termType == "T")) {
    $this->eftEnhanceFlag = 1;  
   }

  switch($this->termType) {
        case "T":
        $termType = "Full Term";
        break;
        case "O":
        $termType = "Open Ended";
        break;
        }
        
$servNameBuff = explode('-',$serviceName);
$sname = $servNameBuff[0];
$clubName = $servNameBuff[1];
$sDur = explode(' ',$serviceTermText);
$servText = "$sDur[0] $sDur[1]"; 

$montharr = explode(' ',$numberMonthsText);
$numMonthsNew = $montharr[0];

$dbMain = $this->dbconnect();

$club_id = 0;
$stmt = $dbMain ->prepare("SELECT club_id FROM club_info WHERE club_name = '$clubName'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_id);   
$stmt->fetch();   
$stmt->close();

if ($club_id == 0 or $club_id == ""){
    $club_id = 0;
}
$club_id = trim($club_id);
$numMonthsNew = trim($numMonthsNew);
$sname = trim($sname);

$stmt = $dbMain ->prepare("SELECT service_info.service_key, service_cost FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_term = 'M' AND club_id = '$club_id' AND service_quantity = '$numMonthsNew' AND service_type = '$sname'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceKey, $unitPrice);   
$stmt->fetch();   
$stmt->close();

//echo "$clubName $club_id    $numMonthsNew       $sname  ***************   $serviceKey, $unitPrice";

$this->serviceKey = $serviceKey; //trim($productFieldArray[5]);
$this->loadServiceLocation();

$unitRenewRate = $unitPrice;
$groupPrice = $unitPrice;
$groupRenewRate = $unitPrice;
$monthlyDues = sprintf("%.2f", $unitPrice/$numMonthsNew);

$this->monthlyDues = $monthlyDues; 

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
$this->eftQuantity
</td>
<td class=\"fieldValues\">
$sname
</td>
<td class=\"fieldValues\">
 $this->serviceLocation
</td>
<td class=\"fieldValues\" >
$numberMonthsText
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
<td class=\"fieldHeader\">
Group Renew Rate
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$unitPrice
</td>
<td class=\"fieldValues\">
$unitRenewRate
</td>
<td class=\"fieldValues\">
$groupPrice
</td>
<td class=\"fieldValues\">
$groupRenewRate
</td>
</tr>

<tr>
<td class=\"fieldHeader pad\">
Monthly Dues
</td>
<td class=\"fieldHeader pad\">
Term Type
</td>
<td  class=\"fieldHeader pad\">
Start Date
</td>
<td class=\"fieldHeader pad\">
End Date
</td>
</tr>

<tr>
<td class=\"fieldValues\">
$monthlyDues
</td>
<td class=\"fieldValues\">
$termType
</td>
<td class=\"fieldValues\">
$this->startDate
</td>
<td class=\"fieldValues\">
$this->endDate
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
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->eftQuantity</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$sname</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$numberMonthsText</font></th>
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
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Monthly Dues</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Term Type</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>Start Date</b></font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;<b>End Date</b></font></th>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$$monthlyDues</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$termType</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->startDate</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->endDate</font></th>
</tr>
$this->productDivider
";


}
//=====================================
function loadProductSummarys()   {
$transArray = explode("|", $this->transferArray);
$termArray = explode("|", $this->termArray);
$productListArray = explode("@", $this->productListArray);
$productCount = count($productListArray);

//echo"<h1>$productCount</h1>";
//var_dump($transArray);
//var_dump($termArray);
//var_dump($productListArray);
if($this->ptBool == 2){
    $this->productDivider = "";
    $this->productRow = $this->productListArray;
    $this->parsePaidFull();
}else{
    $this->downPaymentDivisor = $this->downPayment / ($productCount - 1);

$productCount = $productCount -1;

for($i=0; $i < $productCount; $i++)  {
      $this->serviceTermText = $termArray[$i];
     // echo "$this->serviceTermText";
      $this->transfer = $transArray[$i];
         if($i == $productCount - 1)  {
            $this->productDivider = "";  
            }else{
            $this->productDivider = "<tr><td colspan=\"4\" class=\"fieldValues pad2\"><p class=\"dash\"></p></td></tr>"; 
            }  
           
      $this->productRow = $productListArray[$i];
      //var_dump($productListArray[0]);
            if(!preg_match("/monthly/i", $this->productRow)) {
               $this->parsePaidFull();
              }else{
               if((preg_match("/membership/i", $this->productRow)) && ($this->termType == "O")) {
                   $this->guaranteeFlag = 1;
                  }
            
              $this->parseMonthly();              
              }     
                           
     }
}


}
//=====================================
function loadInitialPayments()  {
    
    
 $totalGearArray = explode('~',$this->totalGearArray);  
 
 foreach($totalGearArray as $xtraGear){
       
        $xtraGearArray = explode('|',$xtraGear);
        $xtraGearName = $xtraGearArray[0];
        $xtraGearMarker = $xtraGearArray[1];
        $xtraGearCost = $xtraGearArray[2];
        $xtraGearNumberPurchased = $xtraGearArray[3];
        
        $xtraGearName = trim($xtraGearName);
        if ($xtraGearName !=""){
             $gearRow .= "<tr><td class=\"nameTitles2\">$xtraGearName (Gear):</td><td class=\"nameSakes2\">$$xtraGearCost</td><td class=\"nameSakes3\">Quantity: &nbsp;$xtraGearNumberPurchased</td></tr>";
             $gearRowEmail .= "<tr>
        <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>$xtraGearName (Gear):</b>&nbsp;&nbsp;&nbsp;$$xtraGearCost  &nbsp;&nbsp;&nbsp;&nbsp; Quantity: &nbsp;$xtraGearNumberPurchased</font></th>
        </tr>";
        }
       
        //echo $xtraServiceName;
        //exit;
}

 
 
 
  
    
    
$serviceUpgradeRow = "";
$serviceUpgradeRowEmail = "";

//var_dump($this->totalServiceArray);
$totalServiceArray = explode('~',$this->totalServiceArray);
foreach($totalServiceArray as $xtraService){
       
        $xtraArray = explode('|',$xtraService);
        $xtraServiceName = $xtraArray[0];
        $xtraServiceKey = $xtraArray[1];
        $xtraServiceQuantity = $xtraArray[2];
        $xtraServiceTermText = $xtraArray[3];
        $xtraServiceCost = $xtraArray[4];
        $xtraServiceNumberPurchased = $xtraArray[5];
        $xtraServiceName = trim($xtraServiceName);
        if ($xtraServiceName !=""){
             $serviceUpgradeRow .= "<tr><td class=\"nameTitles2\">$xtraServiceName (Upgrades):&nbsp;$xtraServiceQuantity&nbsp;&nbsp;$xtraServiceTermText</td><td class=\"nameSakes2\">$$xtraServiceCost</td><td class=\"nameSakes3\">Quantity: &nbsp;$xtraServiceNumberPurchased</td></tr>";
             $serviceUpgradeRowEmail .= "<tr>
        <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>$xtraServiceName (Upgrades):&nbsp;$xtraServiceQuantity&nbsp;&nbsp;$xtraServiceTermText</b>&nbsp;&nbsp;&nbsp;$$xtraServiceCost  &nbsp;&nbsp;&nbsp; Quantity: &nbsp;$xtraServiceNumberPurchased</font></th>
        </tr>";
        }
       
        //echo $xtraServiceName;
        //exit;
}

$dbMain = $this->dbconnect();


$stmt = $dbMain ->prepare("SELECT billing_setup FROM billing_setup WHERE setup_id = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing_setup);   
$stmt->fetch();   
$stmt->close();

switch($billing_setup){
    case '1':
        $firstMonthEftRow = "";
       $firstMonthEftRowEmail = "";
    break;
    case '2':
        if($this->monthlyDues !=""){
            $firstMonthEftRow = "<tr><td class=\"nameTitles2\">First Month (Monthly Services):</td><td class=\"nameSakes2\">$$this->monthlyDues</td><td class=\"nameSakes3\">Quantity: &nbsp;&nbsp;$this->eftQuantity</td></tr>";
       $firstMonthEftRowEmail = "<tr>
        <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>First Month (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->monthlyDues &nbsp;&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;$this->eftQuantity</font></th>
        </tr>";
        }else{
            $firstMonthEftRow = "";
       $firstMonthEftRowEmail = "";
        }
        
    break;
    case '3':
         if($this->monthlyDues !=""){
            $firstMonthEftRow = "<tr><td class=\"nameTitles2\">First Month (Monthly Services):</td><td class=\"nameSakes2\">$$this->monthlyDues</td><td class=\"nameSakes3\">Quantity: &nbsp;&nbsp;$this->eftQuantity</td></tr>";
       $firstMonthEftRowEmail = "<tr>
        <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>First Month (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->monthlyDues &nbsp;&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;$this->eftQuantity</font></th>
        </tr>";
        }else{
            $firstMonthEftRow = "";
       $firstMonthEftRowEmail = "";
        }
    break;
    
}

$dueDateArray = explode(",", $this->dueDate);
$this->dueDate = "$dueDateArray[1], $dueDateArray[2]";


if($this->processFeeEft == "") {
   $processFeeEftRow = "";
   }else{
   $processFeeEftRow = "<tr><td class=\"nameTitles2\">Processing Fee (Monthly Services):</td><td class=\"nameSakes2\">$$this->processFeeEft</td><td class=\"nameSakes3\"></td></tr>";
   $processFeeEftRowEmail = "<tr>
    <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->processFeeEft</font></th>
    </tr>";
    
   }

if(($this->proRateDues == "") || ($this->proRateDues == "undefined")) {
   $proRateDuesRow = "";
   }else{
   $proRateDuesRow = "<tr><td class=\"nameTitles2\">Prorate Dues (Monthly Services):</td><td class=\"nameSakes2\">$$this->proRateDues</td><td class=\"nameSakes3\"></td></tr>";
   $proRateDuesRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Dues (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->proRateDues</font></th>
   </tr>";
   }

if($this->processFeePif == "") {
   $processFeePifRow = "";
   }else{
   $processFeePifRow = "<tr><td class=\"nameTitles2\">Processing Fee (PIF Services):</td><td class=\"nameSakes2\">$$this->processFeePif</td><td class=\"nameSakes3\"></td></tr>";
   $processFeePifRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (PIF Services):</b>&nbsp;&nbsp;&nbsp;$$this->processFeePif</font></th>
   </tr>";
   }

if($this->pifServicesTotal == "undefined" OR $this->pifServicesTotal == 0) {
   $pifServicesTotal = "";
   }else{
   $pifServicesTotal = "<tr><td class=\"nameTitles2\">Paid In Full Service Cost(s):</td><td class=\"nameSakes2\">$$this->pifServicesTotal</td><td class=\"nameSakes3\">Quantity: &nbsp;&nbsp;$this->pifQuantity</td></tr>";
   $pifServicesTotalEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Paid In Full Service Cost(s):</b>&nbsp;&nbsp;&nbsp;$$this->pifServicesTotal &nbsp;&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;$this->pifQuantity</font></th>
   </tr>";
   }

$totalDue = $this->todaysPayment + $this->balanceDue;
$totalDue = sprintf("%.2f",$totalDue);

//$this->todaysPayment  = sprintf("%.2f",$this->todaysPayment);


$totalDueRow = "<tr><td class=\"nameTitles2 pad\">TOTAL DUE:</td><td class=\"nameSakes4 pad\">$$totalDue</td><td class=\"nameSakes3\"></td></tr>";
$totalDueRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TOTAL DUE:</b>&nbsp;&nbsp;&nbsp;$$totalDue</font></th>
</tr>";

$todaysPaymentRow = "<tr><td class=\"nameTitles2\">TODAYS PAYMENT:</td><td class=\"nameSakes2\">$$this->todaysPayment</td><td class=\"nameSakes3\"></td></tr>";
$todaysPaymentRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TODAYS PAYMENT:</b>&nbsp;&nbsp;&nbsp;$$this->todaysPayment</font></th>
</tr>";


$this->initialPayments = "$downPaymentRow $initiationFeeRow $processFeeEftRow $firstMonthEftRow $proRateDuesRow $processFeePifRow $pifServicesTotal $serviceUpgradeRow $gearRow $totalDueRow $todaysPaymentRow";

$this->initialPaymentsEmail = "$downPaymentRowEmail $initiationFeeRowEmail $processFeeEftRowEmail $firstMonthEftRowEmail $proRateDuesRowEmail $processFeePifRowEmail $pifServicesTotalEmail $serviceUpgradeRowEmail $gearRowEmail $totalDueRowEmail $todaysPaymentRowEmail";
}
//=====================================
function createGeneralTerms() {

$payQuitBlurb = "YOU, THE BUYER, MAY CANCEL THIS AGREEMENT AT ANY TIME PRIOR TO MIDNIGHT OF THE $this->contractQuit  BUSINESS
DAY AFTER THE DATE OF THIS AGREEMENT, EXCLUDING SUNDAYS AND HOLIDAYS.";

$replacementCardBlurb = "I ACKNOWLEDGE THAT IN THE EVENT MY MEMBERSHIP CARD IS LOST, STOLEN, OR DESTROYED I AGREE TO PAY A MEMBERSHIP CARD REPLACEMENT FEE OF \$$this->lostCardFee IN ORDER TO BE ISSUED A REPLACEMENT CARD.";

$renewalGraceBlurb ="PAID IN FULL MEMBERSHIPS ARE ELGIBLE FOR RENEWAL UNDER THE TERMS OF THIS CONTRACT WITHIN $this->renewalGracePeriod DAYS UPON THE EXPIRATION OF TERMS OF SERVICE.";

$this->contractTerms = "$this->genericTerms $renewalGraceBlurb $replacementCardBlurb $payQuitBlurb";

}
//=========================================================
function loadContractTerms() {
$this-> loadSalesPersonName();
$dbMain = $this->dbconnect();
  // $stmt = $dbMain ->prepare("SELECT contract_terms, contract_quit FROM contract_defaults WHERE contract_key = '1'");
  // $stmt->execute();      
 //  $stmt->store_result();      
  // $stmt->bind_result($contract_terms, $contract_quit); 
  // $stmt->fetch();

   $stmt = $dbMain ->prepare("SELECT * FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($feeNum, $processFeeSingle, $processFeeFamily, $processFeeBusiness, $processFeeOrganization, $processFeeSingle2, $processFeeFamily2, $processFeeBusiness2, $processFeeOrganization2, $upgradeFeeSingle, $upgradeFeeFamily, $upgradeFeeBusiness, $upgradeFeeOrganization, $upgradeFeeSingle2, $upgradeFeeFamily2, $upgradeFeeBusiness2, $upgradeFeeOrganization2, $upgradeFeeSingle3, $upgradeFeeFamily3, $upgradeFeeBusiness3, $upgradeFeeOrganization3,$renewalFeeSingle, $renewalFeeFamily, $renewalFeeBusiness, $renewalFeeOrganization, $renewalFeeSingle2, $renewalFeeFamily2, $renewalFeeBusiness2, $renewalFeeOrganization2, $cancelFee, $enhanceFee, $rejectionFee, $renewalPercent, $earlyRenewalPercent, $earlyRenewalGrace, $standardRenewalGrace, $lateFee, $cardFee, $rateFee, $holdFee, $holdGrace, $memberHoldFee, $transferFee, $nsfFee, $classPercent); 
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
//=====================================
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
//=====================================
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
                 $this->enhTermSwitch = $term_switch;
         }
}
//=====================================
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
//=====================================
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
  
 $this->collectionDates = "<p class=\"collect\">The first payment of <span class=\"boldLine\">$$this->monthlyDues</span> shall be collected on <span class=\"boldLine\">$billingDate</span> for the month of <span class=\"boldLine\">$nextDate</span>.</p>";

}
//=====================================
function loadCancelation() {

$this->cancelationTerms ="<p>Cancellation: I understand that I am in full control of my payment in accordance with this service agreement,
and if at any time, after the $this->contractQuit day cancellation procedure above, I decide to discontinue, I will simply notify $this->businessName , in writing by no later than 10th of the desired month of cancellation. (This provision does not apply to a Paid In Full Service Agreement or Open Ended Service Aggreement) Notification after the 10th of the desired month will require an additional 1 month of fees. Not applicable to any cancellation fees otherwise due. To cancel, I will include a legible copy of agreement or cancellation form, ORIGINAL MEMBERSHIP CARD and $$this->cancelationFee cancellation fee. Such notice shall be sent to $this->businessName, $this->businessAddress. Any variations from the cancellation procedure may result in a delay in processing cancellation.</p>";

}
//=====================================
function loadMonthlyTransactionRequest() {

if($this->monthlyBillingType != "") {

$transactionDivStart ="
<div id=\"monthlyHeader\">
<span class=\"subHeader\">MONTHLY TRANSACTION REQUEST:</span>
</div>
<div id=\"underline4\"></div>
<div id=\"billingRequest\">";
$endDiv = "</div>";

//checks to see if a g fee is needed then checks if the g fee is available then parses
//if($this->guaranteeFlag == 1) {
    $this->checkGuaranteeFee();
//   }

if($this->eftEnhanceFlag == 1) {
    $this->loadEftEnhanceCycle();
   }
 
$this->loadBillingDate();
$this->loadCancelation();

$separator = "<p class=\"line\"></p>";
 
    switch($this->monthlyBillingType) {
    case "CR":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my credit card company to make a payment of <span class=\"boldLine\">$$this->monthlyDues</span> and charge it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "BA":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my bank to make an ACH payment of <span class=\"boldLine\">$$this->monthlyDues</span> and post it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and drafted for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and drafted should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates  $this->cancelationTerms $separator $endDiv";
        break;
    case "CH":
        $this->transactionRequest = "$transactionDivStart <p>I acknowledge that a check payment of <span class=\"boldLine\">\$$this->monthlyDues</span> is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I authorize a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> to be assessed and billed for any check returned for insufficient funds or for any other reason. I acknowledge a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "CA":         
        $this->transactionRequest ="$transactionDivStart <p>I acknowledge that a cash payment of <span class=\"boldLine\">\$$this->monthlyDues</span> is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract.  I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that any cash payment is subject to verification of authenticity and in the event the cash is found to be counterfeit the business and or company is required to hold the currency and report it to the proper authorities. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;    
    default:
       $this->transactionRequest = "";
   }
}
}
//=====================================
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
//=======================================
function parseGroupTypeInfo()  {

if($this->groupTypeInfo != "") {

//parse the group type info
$group_info_array = explode("|", $this->groupTypeInfo);
$groupName = $group_info_array[0];
$groupAddress = $group_info_array[1];
$groupPhone = $group_info_array[2];

 switch($this->groupType) {
        case "S":
        $this->groupTypeInfo = "";
        break;
        case "F":
        $this->groupTypeInfo = "";
        break;
        case "B":
        $titleName = "Business";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$titleName Name:</td><td class=\"nameSakes\">$groupName</td></tr><tr><td class=\"nameTitles\">$titleName Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";        
        break;
        case "O":
        $titleName = "Organization";
        $this->groupTypeInfo ="<tr><td class=\"nameTitles\">$titleName Name:</td><td class=\"nameSakes\">$groupName</td></tr><tr><td class=\"nameTitles\">$titleName Address</td><td class=\"nameSakes\">$groupAddress $groupPhone</td></tr>";                        
        break;
        }

  }


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
//=======================================
function getLogoImage() {
        return($this->logoImage);
        }
function getContractTerms() {
       return($this->contractTerms);
       }
function getContractQuit() {
       return($this->contractQuit);
       }
function getContractTypeHeader() {
       return($this->contractTypeHeader);
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
function getTransactionRequest() {
       return($this->transactionRequest);
       }
function getSignupSection() {
       return($this->signupSection);
       }
function getGroupTypeInfo() {
       return($this->groupTypeInfo);
       }
function getSig() {
       return($this->signature);
       } 
function getSummaryEmailRows() {
       return($this->summaryTableRowsEmail);
       }  
function getInitialEmailRows() {
       return($this->initialPaymentsEmail);
       }  
function getEmpName() {
       return($this->employeeName);
       }
function getLiabilityTerms() {
       return($this->liabilityTerms);
       }       
      
}
?>