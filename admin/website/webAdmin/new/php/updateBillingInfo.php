<?php
session_start();

require"../../../../nmi/nmiGatewayClass.php";

class  updateBillingInfo{

function setContractKey($contractKey) {
          $this->contractKey = $contractKey;
          }
function setFirstName($first_name) {
          $this->firstName = $first_name;
          }
function setMidName($middle_name) {
          $this->middleName = $middle_name;
          } 
function setLastName($last_name) {
          $this->lastName = $last_name;
          }
function setStreet($street_address) {
          $this->streetAddress = $street_address;
          } 
function setCity($city) {
          $this->city = $city;
          }
function setState($state) {
          $this->state = $state;
          } 
function setZip($zip_code) {
          $this->zipCode = $zip_code;
          }
function setPhone($phone) {
          $this->phone = $phone;
          } 
function setEmail($email) {
          $this->email = $email;
          }
function setDob($dob) {
          $this->dob = $dob;
          }
          
function setCardType($card_type) {
          $this->cardType = $card_type;
          }
function setCardNumber($card_number) {
          $this->cardNumber = $card_number;
          } 
function setMonth($card_month) {
          $this->cardMonth = $card_month;
          }
function setYear($card_year) {
          $this->cardYear = $card_year;
          } 
function setBankName($bank_name) {
          $this->bankName = $bank_name;
          }
function setAccountType($account_type) {
          $this->accountType = $account_type;
          } 
function setAccountNumber($account_number) {
          $this->accountNumber = $account_number;
          }
function setRoutingNumber($routing_number) {
          $this->routingNumber = $routing_number;
          }
 
//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function changeInfo() {
$dbMain = $this->dbconnect();

$this->result = 1;

$sql = "UPDATE contract_info SET first_name = ?, middle_name = ?, last_name = ?, street = ?, city = ?, state = ?, zip = ?, primary_phone = ?, cell_phone = ?,email = ?, dob = ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssss', $this->firstName,$this->middleName,$this->lastName,$this->streetAddress,$this->city,$this->state,$this->zipCode,$this->phone,$this->phone,$this->email,$this->dob);
if(!$stmt->execute())  {
    printf("Error:updateStatus %s.\n", $stmt->error);
    $this->result = 2;
}	
$stmt->close();


}
//-------------------------------------------------------------------------------------------------------------------
function changeBankInfo() {
    
    $dbMain = $this->dbconnect();
    
    $this->result = 1;
    
    $sql = "UPDATE banking_info SET account_fname = ?, account_mname = ?, account_lname = ?, bank_name = ?, account_type = ?, account_number = ?, routing_number = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('sssssss', $this->firstName,$this->middleName,$this->lastName,$this->bankName,$this->accountType,$this->accountNumber,$this->routingNumber);
    if(!$stmt->execute())  {
        printf("Error:updateStatus %s.\n", $stmt->error);
        $this->result = 2;
    }	
    $stmt->close();

            $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
            $stmt->execute();  
            $stmt->store_result();      
            $stmt->bind_result($clubId); 
            $stmt->fetch();
            $stmt->close();
            
        
        
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if($count == 0){
        $vaultFunction = "add_customer";
        $merch1 = "Add Ach Vault ID";
    }else{
        $vaultFunction = "update_customer";
        $merch1 = "Update Ach Vault ID";
    }
    
            $payTypeFlag = "check";//"creditcard"; // '' or 'check'
            $secCode = "PPD";
            $vaultId = "$this->contractKey";
            $checkname = "$this->firstName $this->lastName";	//The name on the customer's ACH account.
            
            if($this->accountType == 'C'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($this->accountType == 'B'){
               $account_holder_type = "business";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($this->accountType == 'S'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "savings";//*** checking/savings
            }      
                        //========================
            
            $gw = new gwapi;
            $gw->setLogin("$userName", "$password");
            $r = $gw->doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkname, $this->routingNumber, $this->accountNumber, $account_holder_type, $account_type, $merch1, $secCode);
            $reasonCode = $gw->responses['response_code'];
            
            
            //echo "sdfjkhdjkfhsdjkhsjkdjshdfdjkshjk $reasonCode";
            if($reasonCode == 100){
                $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('is', $this->contractKey, $vaultId);
                $stmt->execute();
                $stmt->close();
            }

}
//-------------------------------------------------------------------------------------------------------------------
function changeCcInfo() {
$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($club_id); 
$stmt->fetch();
$stmt->close();
            
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$club_id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($userName, $password);
$stmt->fetch();
$stmt->close();

$ccnumber = $this->cardNumber;//"4111111111111111";
$ccexp = "$this->cardMonth$this->cardYear";//"1010";
$cvv = "";
    //==================
$orderId = "CC Member Sales Pre-Auth $this->contractKey";
$merchField1 = "CC Member Sales Pre-Auth";
$payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
$vaultFunction = "";
$vaultId = "$this->contractKey";
    //========================
$gw = new gwapi;
$gw->setLogin("$userName", "$password");
$r = $gw->doPreAuthCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $merchField1, $ccFirstName, $ccLastName, $orderId);
$ccAuthDecision = $gw->responses['responsetext'];
$authCode = $gw->responses['authcode'];    
$transactionId = $gw->responses['transactionid'];
$preAuthReasonCode = $gw->responses['response_code'];

if($preAuthReasonCode == 100){
    $cardCvv = "";
    $this->result = 1;
    $expDate = date('Y-m-d H:i:s',mktime(23,59,59,$this->cardMonth,date('t'),$this->cardYear));
    $sql = "UPDATE credit_info SET card_fname = ?, card_mname = ?, card_lname = ?, card_street = ?, card_city = ?, card_zip = ?, card_state = ?, card_type = ?, card_number = ?, card_exp_date = ?, card_cvv = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('sssssssssss', $this->firstName,$this->middleName,$this->lastName,$this->streetAddress,$this->city,$this->zipCode,$this->state,$this->cardType,$this->cardNumber,$expDate, $cardCvv);
    if(!$stmt->execute())  {
        printf("Error:updateStatus %s.\n", $stmt->error);
        $this->result = 2;
    }	
    $stmt->close();

    $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM billing_vault_id WHERE contract_key= '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if($count == 0){
        $vaultFunction = "add_customer";
        $merch1 = "Add CC Vault ID $this->contractKey";
    }else{
        $vaultFunction = "update_customer";
        $merch1 = "Update CC Vault ID $this->contractKey";
    }
    
    $ccnumber = $this->cardNumber;//"4111111111111111";
    $expDateNmi = date('my',strtotime($expDate));
    //$ccexp = "$card_month$card_year";//"1010";
    $cvv = "";
    //==================
    //$orderId = "CC Member Sales Pre-Auth";
    //$merchField1 = "CC Vault Update";
    $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
    //$vaultFunction = "update_customer";
    $vaultId = "$this->contractKey";
    //========================
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $r = $gw->doVaultCC($ccnumber, $expDate, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1, $this->firstName,$this->lastName, $merch1);
    $ccAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $ccAuthReasonCode = $gw->responses['response_code'];
    
    if($ccAuthReasonCode == 100){
            $sql = "INSERT INTO billing_vault_id VALUES (?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('is', $this->contractKey, $vaultId);
            $stmt->execute();
            $stmt->close();
    }


    
    
    
    
    
}else{
    $this->result = 2;
}




}
//======================================================================================
function getResult() {
          return($this->result);
          }

    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$first_name = $_REQUEST['first_name'];
$middle_name = $_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$street_address = $_REQUEST['street_address'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip_code = $_REQUEST['zip_code'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];
$dob = $_REQUEST['dob'];
$contract_key = $_REQUEST['contract_key'];
//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new updateBillingInfo();
$loadPricing-> setFirstName($first_name);
$loadPricing-> setMidName($middle_name); 
$loadPricing-> setLastName($last_name);
$loadPricing-> setStreet($street_address); 
$loadPricing-> setCity($city);
$loadPricing-> setState($state); 
$loadPricing-> setZip($zip_code);
$loadPricing-> setPhone($phone); 
$loadPricing-> setEmail($email);
$loadPricing-> setDob($dob);
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeInfo();
$result = $loadPricing->getResult();
echo"$result";
exit;
}

$card_type = $_REQUEST['card_type'];
$card_number = $_REQUEST['card_number'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];

if($ajax_switch == 3) {
//echo "$card_month $card_year $contract_key $ajax_switch";
//exit;
$loadPricing = new updateBillingInfo();
$loadPricing-> setFirstName($first_name);
$loadPricing-> setMidName($middle_name); 
$loadPricing-> setLastName($last_name);
$loadPricing-> setStreet($street_address); 
$loadPricing-> setCity($city);
$loadPricing-> setState($state); 
$loadPricing-> setZip($zip_code);
$loadPricing-> setCardType($card_type);
$loadPricing-> setCardNumber($card_number); 
$loadPricing-> setMonth($card_month);
$loadPricing-> setYear($card_year); 
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeCcInfo();
$result = $loadPricing->getResult();
echo"$result";
exit;
}


$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_number = $_REQUEST['account_number'];
$routing_number = $_REQUEST['routing_number'];

if($ajax_switch == 2) {

$loadPricing = new updateBillingInfo();
$loadPricing-> setFirstName($first_name);
$loadPricing-> setMidName($middle_name); 
$loadPricing-> setLastName($last_name);
$loadPricing-> setBankName($bank_name);
$loadPricing-> setAccountType($account_type); 
$loadPricing-> setAccountNumber($account_number);
$loadPricing-> setRoutingNumber($routing_number); 
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeBankInfo();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>