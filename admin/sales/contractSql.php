<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

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
        $this->transfer  = $transfer;
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
//------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------
function parseStartEndDates() {

      
$month = date('m',strtotime($this->datePicker));
$day = date('d',strtotime($this->datePicker));
$year = date('Y',strtotime($this->datePicker));

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
$stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect, contract_terms, liability_terms, contract_quit FROM contract_defaults WHERE contract_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($image_name, $image_path, $image_aspect, $contract_terms, $this->liabilityTerms, $contract_quit);   
$stmt->fetch();   

$this->imageName = $image_name;
$this->imagePath = $image_path;
$this->imageAspect = $image_aspect;
$this->contractTerms = $contract_terms;
$this->contractQuit = $contract_quit;

$stmt->close();

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

$productFieldArray =  explode("|", $this->productRow);
$serviceName = $this->serviceName = $productFieldArray[0];

//for renew rate if it is set to NA
if($productFieldArray[1] == 'NA') {
  $unitRenewRate = 'NA';
  $groupRenewRate = 'NA';
  }else{
  $unitRenewRate = $productFieldArray[1];
  $groupRenewRate = sprintf("%.2f", $this->groupNumber * $unitRenewRate);
  }
  
$unitPrice = $productFieldArray[2];  
$serviceQuantity = preg_replace("/[^0-9]/", "", $productFieldArray[3]);
$serviceTermText = $productFieldArray[3];

//send to get start and end dates
$durationArray  =  explode(" ", $serviceTermText);
$this->serviceDuration = $durationArray[0];
$this->serviceTerm = substr($durationArray[1], 0, 1);
$this->parseStartEndDates();


$groupPrice = $productFieldArray[4];

//gets the service location
$this->serviceKey = trim($productFieldArray[5]);
$this->loadServiceLocation();


if($this->groupNumber == 1)  {
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
$serviceName
</td>
<td class=\"fieldValues\">
 $this->serviceLocation
</td>
<td class=\"fieldValues\" >
$serviceTermText
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
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$serviceName</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$this->serviceLocation</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$serviceTermText</font></th>
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

$productFieldArray =  explode("|", $this->productRow);

$serviceName = $productFieldArray[0];
$unitRenewRate = $productFieldArray[1];
$unitPrice = $productFieldArray[2];
$numberMonthsText = $productFieldArray[3];
$groupPrice = $productFieldArray[4];

//gets the service location
$this->serviceKey = trim($productFieldArray[5]);
$this->loadServiceLocation();

$groupRenewRate = sprintf("%.2f", $this->groupNumber * $unitRenewRate);

//calcs the monthly payment
$numberMonths = preg_replace("/[^0-9]/", "", $productFieldArray[3]);
//$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);

//setup vars for enhance and payment guarantee fees
$this->monthlyServiceName = $serviceName;
$this->numberMonths = $numberMonths;
$this->serviceTerm = 'M';
$this->serviceDuration = $numberMonths;
$this->parseStartEndDates();

$groupPrice = $groupPrice - $this->downPaymentDivisor;
$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);



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
$serviceName
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
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$this->groupNumber</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;$serviceName</font></th>
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

$productListArray = explode("@", $this->productListArray);
$productCount = count($productListArray);

//echo"<h1>$productCount</h1>";

$this->downPaymentDivisor = $this->downPayment / ($productCount - 1);

$productCount = $productCount -1;

for($i=0; $i < $productCount; $i++)  {

         if($i == $productCount - 1)  {
            $this->productDivider = "";  
            }else{
            $this->productDivider = "<tr><td colspan=\"4\" class=\"fieldValues pad2\"><p class=\"dash\"></p></td></tr>"; 
            }  
           
      $this->productRow = $productListArray[$i];
            if(preg_match("/Month\(s\)/", $this->productRow)) {
                if((preg_match("/membership/i", $this->productRow)) && ($this->termType == "O")) {
                   $this->guaranteeFlag = 1;
                  }
            
              $this->parseMonthly();
              }else{
              $this->parsePaidFull();              
              }     
                           
     }

}
//=====================================
function loadInitialPayments()  {

$dueDateArray = explode(",", $this->dueDate);
$this->dueDate = "$dueDateArray[1], $dueDateArray[2]";

if(($this->downPayment == "") || ($this->downPayment == 0))  {
   $downPaymentRow = "";
   }else{
   $this->downPayment = sprintf("%.2f", $this->downPayment);
   $downPaymentRow = "<tr><td class=\"nameTitles2\">Down Payment:</td><td class=\"nameSakes2\">$this->downPayment</td><td class=\"nameSakes3\"></td></tr>";
   $downPaymentRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Down Payment:</b>&nbsp;&nbsp;&nbsp;$$this->downPayment</font></th>
   </tr>";
   }

if($this->initiationFee == 0) {
   $initiationFeeRow = "";
   }else{
   $this->initiationFee = sprintf("%.2f", $this->initiationFee);
   $initiationFeeRow =  "<tr><td class=\"nameTitles2\">Initiation Fee:</td><td class=\"nameSakes2\">$this->initiationFee</td><td class=\"nameSakes3\"></td></tr>";
   $initiationFeeRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Initiation Fee:</b>&nbsp;&nbsp;&nbsp;$$this->initiationFee</font></th>
   </tr>";
   }

if($this->processFeeEft == "") {
   $processFeeEftRow = "";
   }else{
   $processFeeEftRow = "<tr><td class=\"nameTitles2\">Processing Fee (Monthly Services):</td><td class=\"nameSakes2\">$this->processFeeEft</td><td class=\"nameSakes3\"></td></tr>";
   $processFeeEftRowEmail = "<tr>
    <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->processFeeEft</font></th>
    </tr>";
    
   }

if(($this->proRateDues == "") || ($this->proRateDues == "undefined")) {
   $proRateDuesRow = "";
   }else{
   $proRateDuesRow = "<tr><td class=\"nameTitles2\">Prorate Dues (Monthly Services):</td><td class=\"nameSakes2\">$this->proRateDues</td><td class=\"nameSakes3\"></td></tr>";
   $proRateDuesRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Prorate Dues (Monthly Services):</b>&nbsp;&nbsp;&nbsp;$$this->proRateDues</font></th>
   </tr>";
   }

if($this->processFeePif == "") {
   $processFeePifRow = "";
   }else{
   $processFeePifRow = "<tr><td class=\"nameTitles2\">Processing Fee (PIF Services):</td><td class=\"nameSakes2\">$this->processFeePif</td><td class=\"nameSakes3\"></td></tr>";
   $processFeePifRowEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Processing Fee (PIF Services):</b>&nbsp;&nbsp;&nbsp;$$this->processFeePif</font></th>
   </tr>";
   }

if($this->pifServicesTotal == "undefined") {
   $pifServicesTotal = "";
   }else{
   $pifServicesTotal = "<tr><td class=\"nameTitles2\">Paid In Full Service Cost(s):</td><td class=\"nameSakes2\">$this->pifServicesTotal</td><td class=\"nameSakes3\"></td></tr>";
   $pifServicesTotalEmail = "<tr>
   <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>Paid In Full Service Cost(s):</b>&nbsp;&nbsp;&nbsp;$$this->pifServicesTotal</font></th>
   </tr>";
   }

$totalDue = $this->todaysPayment + $this->balanceDue;
$totalDue = sprintf("%.2f",$totalDue);

//$this->todaysPayment  = sprintf("%.2f",$this->todaysPayment);


$totalDueRow = "<tr><td class=\"nameTitles2 pad\">TOTAL DUE:</td><td class=\"nameSakes4 pad\">$totalDue</td><td class=\"nameSakes3\"></td></tr>";
$totalDueRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TOTAL DUE:</b>&nbsp;&nbsp;&nbsp;$$totalDue</font></th>
</tr>";

$todaysPaymentRow = "<tr><td class=\"nameTitles2\">TODAYS PAYMENT:</td><td class=\"nameSakes2\">$this->todaysPayment</td><td class=\"nameSakes3\"></td></tr>";
$todaysPaymentRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>TODAYS PAYMENT:</b>&nbsp;&nbsp;&nbsp;$$this->todaysPayment</font></th>
</tr>";

$balanceDueRow = "<tr><td class=\"nameTitles2\">BALANCE DUE:</td><td class=\"nameSakes2\">$this->balanceDue</td><td class=\"nameSakes3\">DUE DATE:<span class=\"dueDate\">$this->dueDate</span></td></tr>";
$balanceDueRowEmail = "<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>BALANCE DUE:</b>&nbsp;&nbsp;&nbsp;$$this->balanceDue</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\"><b>DUE DATE:</b>&nbsp;&nbsp;&nbsp;$this->dueDate</font></th>
</tr>";

$this->initialPayments = "$downPaymentRow $initiationFeeRow $processFeeEftRow $proRateDuesRow $processFeePifRow $pifServicesTotal $totalDueRow $todaysPaymentRow $balanceDueRow";

$this->initialPaymentsEmail = "$downPaymentRowEmail $initiationFeeRowEmail $processFeeEftRowEmail $proRateDuesRowEmail $processFeePifRowEmail $pifServicesTotalEmail $totalDueRowEmail $todaysPaymentRowEmail $balanceDueRowEmail";
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
   $stmt->bind_result($feeNum, $processFeeSingle, $processFeeFamily, $processFeeBusiness, $processFeeOrganization, $processFeeSingle2, $processFeeFamily2, $processFeeBusiness2, $processFeeOrganization2, $upgradeFeeSingle, $upgradeFeeFamily, $upgradeFeeBusiness, $upgradeFeeOrganization, $upgradeFeeSingle2, $upgradeFeeFamily2, $upgradeFeeBusiness2, $upgradeFeeOrganization2, $upgradeFeeSingle3, $upgradeFeeFamily3, $upgradeFeeBusiness3, $upgradeFeeOrganization3,$renewalFeeSingle, $renewalFeeFamily, $renewalFeeBusiness, $renewalFeeOrganization, $renewalFeeSingle2, $renewalFeeFamily2, $renewalFeeBusiness2, $renewalFeeOrganization2, $cancelFee, $enhanceFee, $rejectionFee, $renewalPercent, $earlyRenewalPercent, $earlyRenewalGrace, $standardRenewalGrace, $lateFee, $cardFee, $rateFee, $holdFee, $holdGrace, $memberHoldFee, $transferFee, $nsfFee, $classPercent, $maintFee); 
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
$this->maintFee = $maintFee;

$this->createGeneralTerms();

}
//=====================================
function checkMaintnenceFee() {

if($this->maintFee == "0.00") {
    $this->maintnenceRequest = "";
    
   }else{

if(($this->serviceTerm == "M") && (preg_match("/membership/i", $this->monthlyServiceName)) && ($this->numberMonths >= 12)) {   
     
   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT m_cycle, term_switch FROM member_maintnence_cycle WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->mCycle, $this->mTermSwitch);
   $stmt->fetch();
   
    $day = date("d");
    $month = date("m");
    $year = date("Y");
$maintnenceCycleDateString = "$month/$day/$year";
$maintnenceCycleDateSecs = strtotime($maintnenceCycleDateString);

$maintnenceAnnualOnly = date("F jS", mktime(0, 0, 0, $month + 12, $day, $year));

//fro semi annual dates
$maintnenceCycleDateSecsAnnual = date("F jS", $maintnenceCycleDateSecs + 15724800+(86400*3));
$maintnenceCycleDateSecsAnnual2 = date("F jS", $maintnenceCycleDateSecs + (15724800 * 2)+(86400*3)); 

//for quarterly dates
$maintnenceCycleDateQuarter2 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year)); 
$maintnenceCycleDateQuarter3 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$maintnenceCycleDateQuarter4 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$maintnenceCycleDateQuarter5 = date("F jS", mktime(0, 0, 0, $month + 12, $day, $year));

//for monthly dates
$maintnenceCycleDateMonths2 = date("F jS", mktime(0, 0, 0, $month + 1, $day, $year)); 
$maintnenceCycleDateMonths3 = date("F jS", mktime(0, 0, 0, $month + 2, $day, $year));
$maintnenceCycleDateMonths4 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year));
$maintnenceCycleDateMonths5 = date("F jS", mktime(0, 0, 0, $month + 4, $day, $year));
$maintnenceCycleDateMonths6 = date("F jS", mktime(0, 0, 0, $month + 5, $day, $year));
$maintnenceCycleDateMonths7 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$maintnenceCycleDateMonths8 = date("F jS", mktime(0, 0, 0, $month + 7, $day, $year));
$maintnenceCycleDateMonths9 = date("F jS", mktime(0, 0, 0, $month + 8, $day, $year));
$maintnenceCycleDateMonths10 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$maintnenceCycleDateMonths11 = date("F jS", mktime(0, 0, 0, $month + 10, $day, $year));
$maintnenceCycleDateMonths12 = date("F jS", mktime(0, 0, 0, $month + 11, $day, $year));
 $maintnenceCycleDateMonths13 = date("F jS", mktime(0, 0, 0, $month + 12, $day, $year));  
   
   switch($this->mCycle) {
    case "A":
        $this->maintnenceFee = sprintf("%.2f", $this->maintFee / 1);
        $this->maintnenceRequest ="<p>I acknowledge that an annual maintnence fee of <span class=\"boldLine\">\$$this->maintnenceFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$maintnenceAnnualOnly</span> of this year and on <span class=\"boldLine\">$maintnenceAnnualOnly</span> of each year thereafter. If there is no year provided the maintnence fee will be automatically drafted on the following year.</p>"; 
        break;
    case "B":
        $this->maintnenceFee = sprintf("%.2f", $this->maintFee / 2);
        $this->maintnenceRequest ="<p>I acknowledge that a bi-annual maintnence fee of <span class=\"boldLine\">\$$this->maintnenceFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$maintnenceCycleDateSecsAnnual</span> and <span class=\"boldLine\">$maintnenceCycleDateSecsAnnual2</span> of this year and on <span class=\"boldLine\">$maintnenceCycleDateSecsAnnual</span> and <span class=\"boldLine\">$maintnenceCycleDateSecsAnnual2</span> of each year thereafter. If there is no year provided the rate maintnence fee will be automatically drafted on the following year on the same dates.</p>";
        break;
    case "Q":
       $this->maintnenceFee = sprintf("%.2f", $this->maintFee / 4);
       $this->maintnenceRequest = "<p>I acknowledge that a quarterly maintnence fee of <span class=\"boldLine\">\$$this->maintnenceFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$annualCycleDate</span> and $maintnenceCycleDateQuarter2, $maintnenceCycleDateQuarter3, $maintnenceCycleDateQuarter4 and $maintnenceCycleDateQuarter5  of this year and on  $maintnenceCycleDateQuarter2, $maintnenceCycleDateQuarter3, $maintnenceCycleDateQuarter4, and $maintnenceCycleDateQuarter5  of each year thereafter. If there is no year provided the maintnence fee will be automatically drafted on the following year on the same dates of each quarter.</p>";
        break;
    case "M":
        $this->maintnenceFee = sprintf("%.2f", $this->maintFee / 12);
        $this->monthlyDues = $this->monthlyDues + $this->maintnenceFee;
        $this->maintnenceRequest ="<p>I acknowledge that a monthly maintnence fee of <span class=\"boldLine\">\$$this->maintnenceFee</span>  will be charged to each contract for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$day</span> of every month of this year and on day <span class=\"boldLine\">$day</span> of every month of each year thereafter. If there is no year provided the maintnence fee will be automatically drafted on the following year on the same dates of each month.</p>";
        break;
    }
               //checks to see if g fee is applicaple
               switch ($this->mTermSwitch) {
                   case "T":
                   if($this->termType == "O") {                      
                      $this->maintnenceRequest = "";
                      }
                   break;
                   case "O":
                   if($this->termType == "T") {
                      $this->maintnenceRequest = "";
                      }              
                   break;
                   case "B":
                   if(($this->termType == "T") || ($this->termType == "O")) {
                      $this->maintnenceRequest;
                      }    
                   break;
                }
    
  }
  
  
  
  
  
 }

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
  
 $this->collectionDates = "<p class=\"collect\">The first payment of <span class=\"boldLine\">\$$this->monthlyDues</span> shall be collected on <span class=\"boldLine\">$billingDate</span> for the month of <span class=\"boldLine\">$nextDate</span>.</p>";

}
//=====================================
function loadCancelation() {

$this->cancelationTerms ="<p>Cancellation: I understand that I am in full control of my payment in accordance with this service agreement,
and if at any time, after the $this->contractQuit day cancellation procedure above, I decide to discontinue, I will simply notify $this->businessName , in writing by no later than 10th of the desired month of cancellation. (This provision does not apply to a Paid In Full Service Agreement or Open Ended Service Aggreement) Notification after the 10th of the desired month will require an additional1 month fees. Not applicable to any cancellation fees otherwise due. To cancel, I will include a legible copy of agreement or cancellation form, ORIGINAL MEMBERSHIP CARD and \$$this->cancelationFee cancellation fee. Such notice shall be sent to $this->businessName, $this->businessAddress. Any variations from the cancellation procedure may result in a delay in processing cancellation.</p>";

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
    $this->checkMaintnenceFee();
//   }

if($this->eftEnhanceFlag == 1) {
    $this->loadEftEnhanceCycle();
   }
 
$this->loadBillingDate();
$this->loadCancelation();

$separator = "<p class=\"line\"></p>";
 
    switch($this->monthlyBillingType) {
    case "CR":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my credit card company to make a payment of <span class=\"boldLine\">\$$this->monthlyDues</span> and charge it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> <p> By providing a check as payment, I authorize you to use information from my check to make a one-time electronic funds transfer (EFT) or draft from my account, or to process the payment as a check transaction.  When you use information from my check to make an EFT, funds may be withdrawn from my account as soon as the same day my payment is received, and I will not receive my check back from my financial institution.   The account referenced above is a (check one):  Consumer account   Business account If my payment is returned unpaid, I authorize you or your service provider to  collect my payment and my state’s return fee set forth below by EFT(s) or draft(s) from my account.  I understand that I can revoke this authorization by sending written notice to $this->businessAddress in such time and manner as to afford ____ a reasonable opportunity to act on it.  If this payment is from a corporate owned account, I make these authorizations as an authorized corporate representative and agree that the entity will be bound by the NACHA Operating Rules.  </p>$this->guaranteeRequest $this->enhanceRequest $this->maintnenceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "BA":
        $this->transactionRequest = "$transactionDivStart <p>I authorize my bank to make an ACH payment of <span class=\"boldLine\">\$$this->monthlyDues</span> and post it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> will be assessed and drafted for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and drafted should any monthly payment becomes <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->maintnenceRequest $this->collectionDates  $this->cancelationTerms $separator $endDiv";
        break;
    case "CH":
        $this->transactionRequest = "$transactionDivStart <p>I acknowledge that a check payment of <span class=\"boldLine\">\$$this->monthlyDues</span> is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I authorize a service fee of <span class=\"boldLine\">\$$this->rejectionFee</span> to be assessed and billed for any check returned for insufficient funds or for any other reason. I acknowledge a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->maintnenceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
        break;
    case "CA":         
        $this->transactionRequest ="$transactionDivStart <p>I acknowledge that a cash payment of <span class=\"boldLine\">\$$this->monthlyDues</span> is to be made by day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract.  I acknowledge that a late fee of <span class=\"boldLine\">\$$this->lateFee</span> will be assessed and billed should any monthly payment become <span class=\"boldLine\">$this->pastDueGrace</span> days past due. I acknowledge that any cash payment is subject to verification of authenticity and in the event the cash is found to be counterfeit the business and or company is required to hold the currency and report it to the proper authorities. I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> $this->guaranteeRequest $this->enhanceRequest $this->maintnenceRequest $this->collectionDates $this->cancelationTerms $separator $endDiv";
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