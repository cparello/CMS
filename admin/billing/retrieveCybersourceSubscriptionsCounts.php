<?php
session_start();
//error_reporting(E_ALL);
if (!isset($_SESSION['admin_access']))  {
exit;
}
require "../cybersource/gatewayAuth.php";
require "../cybersource/cybersourceSoapClient.php";

class retrieveSubscriptions {
    

function dbconnectOne()   {
require"../dbConnectOne.php";
return $dbMainOne;
}

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setContractKey($contractKey){
    $this->contractKey = $contractKey;
}
//=====================================================================================
function loadBankName(){
    $dbMainOne = $this->dbconnectOne();
    $stmt = $dbMainOne->prepare("SELECT record_type_code FROM ach_directory WHERE routing_number = '$this->checkBankTransitNumber' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($record_type_code);   
    $stmt->fetch();
    $stmt->close();
    
    if ($record_type_code == 2){
	$stmt = $dbMainOne->prepare("SELECT bank_name, new_routing_number FROM ach_directory WHERE routing_number = '$this->checkBankTransitNumber' ");
	$stmt->execute();      
	$stmt->store_result();      
	$stmt->bind_result($bank_name,$new_routing_number);   
	$stmt->fetch();
	$stmt->close();
	
	$this->bankName = $bank_name;
	$this->routingNumber = $new_routing_number;
    }else{   
		$stmt = $dbMainOne->prepare("SELECT bank_name FROM ach_directory WHERE routing_number = '$this->checkBankTransitNumber' ");
		$stmt->execute();      
		$stmt->store_result();      
		$stmt->bind_result($bank_name);   
		$stmt->fetch();
		$stmt->close();
		
		$this->bankName = $bank_name;
	 }
}
//=====================================================================================
function loadCardType(){
    
    switch($this->cardType) {
           case "001":
                  $this->cardType = 'Visa';
           break;
           case "002":
                  $this->cardType = 'MC';           
           break;
           case "003":
                  $this->cardType = 'Amex'; 
           break;
           case "004":
                  $this->cardType = 'Disc';
           break;
         }
}
//================================================================================================
function loadErrorCode(){
    
    $dbMain = $this->dbconnect();
    
    $stmt222 = $dbMain->prepare("SELECT description FROM cs_error_codes WHERE error_code = '$this->reasonCode' ");
		$stmt222->execute();      
		$stmt222->store_result();      
		$stmt222->bind_result($this->reasonDescription);   
		$stmt222->fetch();
		$stmt222->close();
}
//==============================================================================================
function moveData(){
    //echo"fubar";
$dbMain = $this->dbconnect();

$counter = 1;
/*$subHtml = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
        \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<link rel=\"stylesheet\" href=\"../css/accountInfo.css\"/>
<link rel=\"stylesheet\" href=\"../css/notesTwo.css\"/>


<title>Untitled</title>
</head>
";*/
$cancCount = 0;
$holdCount = 0;
$currentCount = 0;
$cancTot = 0;
$holdTot = 0;
$currentTot = 0;
$RGcancCount = 0;
$RGholdCount = 0;
$RGcurrentCount = 0;
$RGcancTot = 0;
$RGholdTot = 0;
$RGcurrentTot = 0;

$authOptions = new gatewayAuth();
$authOptions->loadGatewayOptions();
$merchantId = $authOptions->getMerchantId();
$transactionKey = $authOptions->getTransactionKey();
$accessLink = $authOptions->getAccessLink();

define('MERCHANT_ID', $merchantId);
define('TRANSACTION_KEY', $transactionKey);
define('WSDL_URL', $accessLink);
        
$soapClient = new ExtendedClient(WSDL_URL, array());

  $stmt999 = $dbMain->prepare("SELECT contract_key, subscription_id, subscription_type FROM cs_subscriptions WHERE (contract_key BETWEEN '10001' AND '20000') ORDER BY contract_key ASC");
  $stmt999->execute();      
  $stmt999->store_result();      
  $stmt999->bind_result($contract_key, $subscription_id, $subscription_type); 
  while($stmt999->fetch()){
    
    //$subHtml .= "<h1><div id=\"Subscription &nbsp; $counter\"></div></h1>";
    
                
        
        
        $request = new stdClass();
        $paySubscriptionRetrieveService = new stdClass();
        $purchaseTotals = new stdClass();
        $recurringSubscriptionInfo = new stdClass();


        $request->merchantID = MERCHANT_ID;
        $request->merchantReferenceCode = "$contract_key";
        $request->clientLibrary = "PHP";
        $request->clientLibraryVersion = phpversion();
        $request->clientEnvironment = php_uname();
        
        $paySubscriptionRetrieveService->run = "true";
        $request->paySubscriptionRetrieveService = $paySubscriptionRetrieveService;


        $purchaseTotals->currency = "USD";
        $request->purchaseTotals = $purchaseTotals;

        $recurringSubscriptionInfo->subscriptionID = "$subscription_id";
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        $reply = $soapClient->runTransaction($request);
        
        //var_dump($request);

        $this->ccAuthDecision = $reply->decision;
        $this->ccAuthReasonCode = $reply->reasonCode;
        $this->ccAuthRequestId = $reply->requestID;
        
       
        $this->approvalRequired = $reply->paySubscriptionRetrieveReply->approvalRequired;
        $this->automaticRenew = $reply->paySubscriptionRetrieveReply->automaticRenew;
        $this->cardAccountNumber = $reply->paySubscriptionRetrieveReply->cardAccountNumber;
        $this->cardExpirationYear = $reply->paySubscriptionRetrieveReply->cardExpirationYear;
        $this->cardType = $reply->paySubscriptionRetrieveReply->cardType;
        $this->city = $reply->paySubscriptionRetrieveReply->city;
        $this->country = $reply->paySubscriptionRetrieveReply->country;
        $this->currency = $reply->paySubscriptionRetrieveReply->currency;
        $this->email = $reply->paySubscriptionRetrieveReply->email;
        $this->firstName = $reply->paySubscriptionRetrieveReply->firstName;
        $this->frequency = $reply->paySubscriptionRetrieveReply->frequency;
        $this->lastName = $reply->paySubscriptionRetrieveReply->lastName;
        $this->ownerMerchantID = $reply->paySubscriptionRetrieveReply->ownerMerchantID;
        $this->paymentMethod = $reply->paySubscriptionRetrieveReply->paymentMethod;
        $this->paymentsRemaining = $reply->paySubscriptionRetrieveReply->paymentsRemaining;
        $this->postalCode = $reply->paySubscriptionRetrieveReply->postalCode;
        $this->reasonCode = $reply->paySubscriptionRetrieveReply->reasonCode;
        $this->state = $reply->paySubscriptionRetrieveReply->state;
        $this->status = $reply->paySubscriptionRetrieveReply->status;
        $this->street1 = $reply->paySubscriptionRetrieveReply->street1;
        $this->subscriptionID = $reply->paySubscriptionRetrieveReply->subscriptionID;
        $this->currency = $reply->purchaseTotals->currency;
        //$this->reasonCode = $reply->reasonCode;
        $this->requestID = $reply->requestID;
        $this->title = $reply->paySubscriptionRetrieveReply->title;
        $this->street1 = $reply->paySubscriptionRetrieveReply->street1;
        $this->street2 = $reply->paySubscriptionRetrieveReply->street2;
        $this->startDate = $reply->paySubscriptionRetrieveReply->startDate;
        $this->subscriptionIDNew = $reply->paySubscriptionRetrieveReply->subscriptionIDNew;
        $this->recurringAmount = $reply->paySubscriptionRetrieveReply->recurringAmount;
        $this->checkBankTransitNumber = $reply->paySubscriptionRetrieveReply->checkBankTransitNumber;
        //$this->cardType = $reply->paySubscriptionRetrieveReply->cardType;
        $this->checkAccountNumber = $reply->paySubscriptionRetrieveReply->checkAccountNumber;
        $this->checkAccountType = $reply->paySubscriptionRetrieveReply->checkAccountType;
        $this->cardExpirationMonth = $reply->paySubscriptionRetrieveReply->cardExpirationMonth;
        $this->cardExpirationYear = $reply->paySubscriptionRetrieveReply->cardExpirationYear;
        $this->billPayment = $reply->paySubscriptionRetrieveReply->billPayment;
        $this->secCode = $reply->paySubscriptionRetrieveReply->checkSecCode;
        
        //$this-> loadCardType();
        //$this-> loadBankName();
        //$this-> loadErrorCode();
        //echo" $contract_key  $this->status<br>";
        if (preg_match('Guarantee/i',$this->title)){
            switch ($this->status){
            case 'CURRENT':
                    $RGcurrentCount++;
                    $RGcurrentTot += $this->recurringAmount;
            break;
             case 'HOLD':
                    $RGholdCount++;
                    $RGholdTot  += $this->recurringAmount;
            break;
             case 'CANCELED':
                    $RGcancCount++;
                    $RGcancTot += $this->recurringAmount;
            break;
                }
            
        }else{
            switch ($this->status){
            case 'CURRENT':
                    $currentCount++;
                    $currentTot += $this->recurringAmount;
            break;
             case 'HOLD':
                    $holdCount++;
                    $holdTot  += $this->recurringAmount;
            break;
             case 'CANCELED':
                    $cancCount++;
                    $cancTot += $this->recurringAmount;
            break;
                }
        }
        
        
        
        
             /*   echo"$this->approvalRequired<br>
        $this->automaticRenew<br>
        $this->cardAccountNumber<br>
        $this->cardAccountNumber<br>
        $this->cardExpirationYear<br>
        $this->cardType<br>
        $this->city<br>
        $this->country<br>
        $this->currency<br>
        $this->email<br>
        $this->firstName<br>
        $this->frequency<br>
        $this->lastName<br>
        $this->ownerMerchantID<br>
        $this->paymentMethod<br>
        $this->paymentsRemaining <br>
        $this->postalCode<br>
        $this->reasonCode<br>
        $this->state<br>
        $this->status<br>
        $this->street1 <br>
        $this->subscriptionID <br>
        $this->currency <br>
        $this->reasonCode <br>
        $this->requestID<br>
        $this->title<br>
        $this->street1<br>
        $this->street2 <br>
        $this->startDate<br>
        $this->subscriptionIDNew<br>
        $this->recurringAmount <br>
        $this->checkBankTransitNumber <br>
        $this->cardType<br>
        $this->checkAccountNumber <br>
        $this->checkAccountType <br>
        $this->cardExpirationMonth <br>
        $this->cardExpirationYear<br>
        $this->billPayment<br>";*/
        
        
       /* $subHtml .= "
<div id=\"userForm1\">
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" border=\"0\" class=\"tabBoard1\">
<tr class=\"tabHead\">
<td colspan=\"3\" class=\"oBtext\">
<h3><center>Subscription Information $counter</center></h3>
</td>
<td align=\"right\" class=\"checkText\">
<div id=\"addSet1\"></div>
</td>
</tr>
<tr>
<td class=\"black\">
First Name:
</td>
<td class=\"black\">
Last Name:
</td>
<td class=\"black\">
Street Address:
</td>
<td class=\"black\">
City:
</td>

</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->firstName\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"last_name\" type=\"text\" id=\"last_name\" value=\"$this->lastName\" size=\"25\" maxlength=\"30\"  disabled />
</td>
<td>
<input name=\"street_address\" type=\"text\" id=\"street_address\" value=\"$this->street1 &nbsp; $this->street2\" size=\"25\" maxlength=\"100\" disabled/>
</td>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->city\" size=\"25\" maxlength=\"30\" disabled/>
</td>

<td rowspan=\"7\" valign=\"top\">
&nbsp;
</td>
</tr>
<tr>
<td class=\"black\">
State:
</td>
<td class=\"black\">
Zipcode:
</td>
<td class=\"black\">
Email Address:
</td>
<td class=\"black\">
Country:
</td>

</tr>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->state\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td>
<input name=\"zip_code\" type=\"text\" id=\"zip_code\" value=\"$this->postalCode\" size=\"25\" maxlength=\"5\"  disabled/>
</td>
<td class=\"pad\">
<input  name=\"email\" type=\"text\" id=\"email\" value=\"$this->email\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td class=\"pad\">
<input  name=\"email\" type=\"text\" id=\"email\" value=\"$this->country\" size=\"25\" maxlength=\"30\" disabled/>
</td>

<tr>
<td class=\"black\">
Reason Description:
</td>
</tr>
<tr>
<td class=\"pad\">
<input  name=\"email\" type=\"text\" id=\"email\" value=\"$this->reasonDescription\" size=\"25\" maxlength=\"30\" disabled/>
</td>
</tr>
<tr>
</tr>
</table>
</div>
<br>
<br>
<br>
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" border=\"0\" class=\"tabBoard1\">
<tr class=\"tabHead\">
<td colspan=\"3\" class=\"oBtext\">
Subscription Info
</td>
<td align=\"right\" class=\"checkText\">
<div id=\"addSet1\"></div>
</td>
</tr>
<tr>
<td class=\"black\">
Subscription Title:
</td>
<td class=\"black\">
Status:
</td>
<td class=\"black\">
Start Date:
</td>
<td class=\"black\">
Amount:
</td>
</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->title\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"last_name\" type=\"text\" id=\"last_name\" value=\"$this->status\" size=\"25\" maxlength=\"30\"  disabled />
</td>
<td>
<input name=\"street_address\" type=\"text\" id=\"street_address\" value=\"$this->startDate\" size=\"25\" maxlength=\"100\" disabled/>
</td>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->recurringAmount\" size=\"25\" maxlength=\"30\" disabled/>
</td>

<td rowspan=\"7\" valign=\"top\">
&nbsp;
</td>
</tr>
<tr>
<td class=\"black\">
Frequency:
</td>
<td class=\"black\">
Currency:
</td>
<td class=\"black\">
Approval Required:
</td>
<td class=\"black\">
Automatic Renew:
</td>

</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->frequency\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->currency\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->approvalRequired\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->automaticRenew\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>

</tr>
<tr>
<td class=\"black\">
Subscription ID:
</td>
<td class=\"black\">
Reason Code:
</td>
<td class=\"black\">
Payments Remaining:
</td>
<td class=\"black\">
Visa Bill Payment:
</td>

</tr>
<tr>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->subscriptionID\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td>
<input name=\"zip_code\" type=\"text\" id=\"zip_code\" value=\"$this->reasonCode\" size=\"25\" maxlength=\"5\"  disabled/>
</td>
<td class=\"pad\">
<input  name=\"email\" type=\"text\" id=\"email\" value=\"$this->paymentsRemaining\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->billPayment\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>

</tr>
<tr>
<td class=\"black\">
Payment Method:
</td>
</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->paymentMethod\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
</tr>
</table>
</div>
<br>
<br>
<br>
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" border=\"0\" class=\"tabBoard1\">
<tr class=\"tabHead\">
<td colspan=\"3\" class=\"oBtext\">
Credit Info
</td>
<td align=\"right\" class=\"checkText\">
<div id=\"addSet1\"></div>
</td>
</tr>
<tr>
<td class=\"black\">
Card Type:
</td>
<td class=\"black\">
Card Number:
</td>
<td class=\"black\">
Card Exp. Month:
</td>
<td class=\"black\">
Card Exp. Year:
</td>
</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->cardType\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"last_name\" type=\"text\" id=\"last_name\" value=\"$this->cardAccountNumber\" size=\"25\" maxlength=\"30\"  disabled />
</td>
<td>
<input name=\"street_address\" type=\"text\" id=\"street_address\" value=\"$this->cardExpirationMonth\" size=\"25\" maxlength=\"100\" disabled/>
</td>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->cardExpirationYear\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td rowspan=\"7\" valign=\"top\">
&nbsp;
</td>
</tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" border=\"0\" class=\"tabBoard1\">
<tr class=\"tabHead\">
<td colspan=\"3\" class=\"oBtext\">
Banking Info
</td>
<td align=\"right\" class=\"checkText\">
<div id=\"addSet1\"></div>
</td>
</tr>
<tr>
<td class=\"black\">
Account Number:
</td>
<td class=\"black\">
Routing Number:
</td>
<td class=\"black\">
SEC Code:
</td>
<td class=\"black\">
Bank Name:
</td>
</tr>
<tr>
<td>
<input  name=\"first_name\" type=\"text\" id=\"first_name\" value=\"$this->checkAccountType\" size=\"25\" maxlength=\"60\"  disabled/>     
</td>
<td>
<input  name=\"last_name\" type=\"text\" id=\"last_name\" value=\"$this->checkBankTransitNumber\" size=\"25\" maxlength=\"30\"  disabled />
</td>
<td>
<input name=\"street_address\" type=\"text\" id=\"street_address\" value=\"$this->secCode\" size=\"25\" maxlength=\"100\" disabled/>
</td>
<td>
<input name=\"city\" type=\"text\" id=\"city\" value=\"$this->bankName\" size=\"25\" maxlength=\"30\" disabled/>
</td>
<td rowspan=\"7\" valign=\"top\">
&nbsp;
</td>
</tr>
</table>
</div>
<br>
<br>
<br>
</form>
</div>";*/
$counter++;
        //echo "done<br>";
         }
  $stmt999->close(); 
  echo "Canceled count $cancCount Canceled Total $cancTot Hold Count $holdCount Hold Total $holdTot Current Count $currentCount   Current Total $currentTot ";
  echo "RGCanceled count $RGcancCount RGCanceled Total $RGcancTot RGHold Count $RGholdCount RGHold Total $RGholdTot RGCurrent Count $RGcurrentCount   RGCurrent Total $RGcurrentTot ";
  
 //include "cybersourceInfoTemplate.php";
/*$subHtml .= "</div>
</body>
</html>";*/

//echo $subHtml;
 }

//===========================================================================================================
}
//$contract_key = $_SESSION['contract_key'];
//$contract_key = 5731;
$update = new retrieveSubscriptions();
//$update->setContractKey($contract_key);
$update->moveData();



?>