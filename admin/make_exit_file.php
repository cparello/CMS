<?php
set_time_limit(0);
ini_set('memory_limit', '128M');
class createExitFile{

private $contractKey = null;
// banking
private $bankName = null;
private	$bankAccountType = null;
private	$firstName = null;
private	$accountMname = null;
private	$lastName = null;
private	$eftCheckingAccountNumber = null;
private	$routingNumber = null;

//credit
private $CardFirstName = null;
private $CardAccountMname = null;
private	$CardLastName = null;
private	$CardAddress = null;
private	$CardCity = null;
private	$CardZtate = null;
private	$CardZipCode = null;
private	$CardCreditCardType = null;
private	$CardCreditCardNumber = null;
private	$CardCardCvv = null;
private	$CardCreditCardExpirationDate = null;


//groups
private $groupType = null;
private $groupNumber = null;
private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;

// contract

private $signupDate = null;
private $contractDate = null;
private $hostType = null;
private $contractFirstName = null;
private $contractAccountMname = null;
private $contractLastName = null;
private $contractStreet = null;
private $contractCity = null;
private $contractState = null;
private $contractZipCode = null;
private $contractPrimaryPhone = null;
private $contractCellPhone = null;
private $contractEmailAddress = null;
private $contractDateOfBirth = null;
private $contractLicenseNumber = null;

// memeber info

private $barcodeNumber = null;
private $emergencyContact = null;
private $emergencyRelationship = null;
private $emergencyPhoneNumber = null;

//monthly services
private $unitPrice;
private $initiationFee;
private $downPayment;
private $monthlyDues;
private $serviceSignUpDate;

//monthly payments
private $monthlyBillingType;
private $nextBillingDate;
private $nextBillingFee;
private $billingStatus;

    






//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function readData(){
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain->prepare("SELECT bank_name, account_type, account_fname, account_mname, account_lname, account_number, routing_number FROM banking_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->bankName, $this->bankAccountType, $this->firstName, $this->accountMname, $this->lastName, $this->eftCheckingAccountNumber,  $this->routingNumber);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT card_fname, card_mname, card_lname, card_street, card_city, card_state, card_zip, card_type, card_number, card_exp_date FROM credit_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->CardFirstName, $this->CardAccountMname, $this->CardLastName, $this->CardAddress, $this->CardCity, $this->CardZtate, $this->CardZipCode, $this->CardCreditCardType, $this->CardCreditCardNumber, $this->CardCreditCardExpirationDate);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT group_type, group_number, group_name, group_address, group_phone FROM member_groups WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->groupType,$this->groupNumber,$this->groupName,$this->groupAddress ,$this->groupPhone);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT signup_date, contract_date, host_type, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number   FROM contract_info WHERE contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->signupDate,$this->contractDate,$this->hostType,$this->contractFirstName,$this->contractAccountMname,$this->contractLastName,$this->contractStreet,$this->contractCity,$this->contractState,$this->contractZipCode,$this->contractPrimaryPhone,$this->contractCellPhone,$this->contractEmailAddress,$this->contractDateOfBirth,$this->contractLicenseNumber);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT member_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number, emg_contact, emg_relationship, emg_phone_phone, liability_terms, member_photo FROM member_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->memberId, $this->firstName, $this->middleName, $this->lastName, $this->street, $this->city, $this->state, $this->zip, $this->primaryPhone, $this->cellPhone, $this->email, $this->dob, $this->licenseNumber, $this->emgContact, $this->emgRelationship, $this->emgPhone, $this->liabilityTerms, $this->memberPhoto);   
    $stmt->fetch();   
    $stmt->close();
    
    
    $stmt = $dbMain->prepare("SELECT service_id, unit_price, initiation_fee, down_payment, monthly_dues, start_date, end_date, service_name, user_id, transfer, service_key FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_name LIKE '%Membership%'  ORDER BY end_date DESC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceIdMonthly ,$this->unitPrice,$this->initiationFee,$this->downPayment,$this->monthlyDues,$this->serviceSignUpDate, $this->startDate, $this->endDate, $this->serviceName, $this->userId, $this->transfer, $this->serviceKeyMonthly);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_id = '$this->serviceIdMonthly'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->accountStatusMonthly);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT monthly_billing_type, cycle_date, billing_amount, billing_status FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->monthlyBillingType,$this->nextBillingDate,$this->nextBillingFee,$this->billingStatus);   
    $stmt->fetch();   
    $stmt->close(); 
 
   $stmt = $dbMain->prepare("SELECT service_id, group_type, group_number,  service_key,  club_id,  service_name,  service_quantity,  service_term,  unit_price,  unit_renew_rate,  group_price,  group_renew_rate,  start_date,  end_date,  signup_date,  transfer FROM paid_full_services WHERE contract_key = '$this->contractKey'  AND service_name LIKE '%Membership%'  ORDER BY end_date DESC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceIdPif,$this->groupType,$this->groupNumber,$this->serviceKey,$this->clubId,$this->serviceName,$this->serviceQuantity,$this->serviceTerm,$this->unitPrice,$this->unitRenewRate,$this->groupPrice,$this->groupRenewRate,$this->startingDate,$this->endDate,$this->contractTransfer);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey'  AND service_id = '$this->serviceIdPif'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->accountStatusPif);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->nextPaymentDueDate);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT num_months, payment_amount, service_keys, payment_date, restart_date FROM pre_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->numMonths, $this->paymentAmount, $this->serviceKeys, $this->paymentDate, $this->restartDate);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT service_id, service_key, credit_sec_num, credit_term, credit_date, credit_end FROM service_credits WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceId, $this->serviceKey, $this->creditSecNum, $this->creditTerm, $this->creditDate, $this->creditEnd);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT service_key, class_count FROM member_class_count WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceKeyClassCount, $this->classCount);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT service_key, class_count FROM schedular_member_class_count WHERE sm_contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceKeyClassCountSchedular, $this->classCountSchedular);   
    $stmt->fetch();   
    $stmt->close();
}
//==============================================================================================
function writeData(){
         $ourFileName = "exitfile.txt";
         $ourFileHandle = fopen($ourFileName, 'a');

        $this->file = "\"$this->contractKey\",\"$this->signupDate\",\"$this->contractDate\",\"$this->hostType\",\"$this->contractFirstName\",\"$this->contractAccountMname\",\"$this->contractLastName\",\"$this->contractStreet\",\"$this->contractCity\",\"$this->contractState\",\"$this->contractZipCode\",\"$this->contractPrimaryPhone\",\"$this->contractCellPhone\",\"$this->contractEmailAddress\",\"$this->contractDateOfBirth\",\"$this->contractLicenseNumber\",\"$this->groupType\",\"$this->groupNumber\",\"$this->groupName\",\"$this->groupAddress \",\"$this->groupPhone\",\"$this->CardFirstName\",\" $this->CardAccountMname\",\" $this->CardLastName\",\" $this->CardAddress\",\" $this->CardCity\",\" $this->CardZtate\",\" $this->CardZipCode\",\" $this->CardCreditCardType\",\" $this->CardCreditCardNumber\",\" $this->CardCreditCardExpirationDate\",\"$this->bankName\",\" $this->bankAccountType\",\" $this->firstName\",\" $this->accountMname\",\" $this->lastName\",\" $this->eftCheckingAccountNumber\",\"  $this->routingNumber\",\" $this->memberId\",\" $this->firstName\",\" $this->middleName\",\" $this->lastName\",\" $this->street\",\" $this->city\",\" $this->state\",\" $this->zip\",\" $this->primaryPhone\",\" $this->cellPhone\",\" $this->email\",\" $this->dob\",\" $this->licenseNumber\",\" $this->emgContact\",\" $this->emgRelationship\",\" $this->emgPhone\",\" LIABILTY TERMS GO HERE\",\" $this->memberPhoto\",\" $this->serviceIdMonthly \",\"$this->unitPrice\",\"$this->initiationFee\",\"$this->downPayment\",\"$this->monthlyDues\",\"$this->serviceSignUpDate\",\" $this->startDate\",\" $this->endDate\",\" $this->serviceName\",\" $this->userId\",\" $this->transfer\",\" $this->serviceKeyMonthly\",\" $this->accountStatusMonthly\",\" $this->monthlyBillingType\",\"$this->nextBillingDate\",\"$this->nextBillingFee\",\"$this->billingStatus\",\" $this->nextPaymentDueDate\",\" $this->numMonths\",\" $this->paymentAmount\",\" $this->serviceKeys\",\" $this->paymentDate\",\" $this->restartDate\",\" $this->serviceId\",\" $this->serviceKey\",\" $this->creditSecNum\",\" $this->creditTerm\",\" $this->creditDate\",\" $this->creditEnd\",\" $this->serviceIdPif\",\"$this->groupType\",\"$this->groupNumber\",\"$this->serviceKey\",\"$this->clubId\",\"$this->serviceName\",\"$this->serviceQuantity\",\"$this->serviceTerm\",\"$this->unitPrice\",\"$this->unitRenewRate\",\"$this->groupPrice\",\"$this->groupRenewRate\",\"$this->startingDate\",\"$this->endDate\",\"$this->contractTransfer\",\" $this->accountStatusPif\",\"  $this->serviceKeyClassCount\",\" $this->classCount\",\" $this->serviceKeyClassCountSchedular\",\" $this->classCountSchedular\" \n";
    
    fwrite($ourFileHandle, $this->file);                
                
    fclose($ourFileHandle);               
           

}
//==============================================================================================
function fileMaker(){
    
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT contract_key FROM contract_keys WHERE contract_key != '0' LIMIT 10");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->contractKey);
    while ($stmt->fetch()) { 
        echo"$this->contractKey<br><br><br>";
              $this->readData();
              $this->writeData();
              echo"$this->file<br><br><br><br>";
              
                $this->contractKey = "";
                $this->signupDate = "";
                $this->contractDate = "";
                $this->hostType = "";
                $this->contractFirstName = "";
                $this->contractAccountMname = "";
                $this->contractLastName = "";
                $this->contractStreet = "";
                $this->contractCity = "";
                $this->contractState = "";
                $this->contractZipCode = "";
                $this->contractPrimaryPhone = "";
                $this->contractCellPhone = "";
                $this->contractEmailAddress = "";
                $this->contractDateOfBirth = "";
                $this->contractLicenseNumber = "";
                $this->groupType = "";
                $this->groupNumber = "";
                $this->groupName = "";
                $this->groupAddress = "";
                $this->groupPhone = "";
                $this->CardFirstName  = "";
                $this->CardAccountMname = "";
                $this->CardLastName = "";
                $this->CardAddress = "";
                $this->CardCity = "";
                $this->CardZtate = "";
                $this->CardZipCode = "";
                $this->CardCreditCardType = "";
                $this->CardCreditCardNumber = "";
                $this->CardCreditCardExpirationDate = "";
                $this->bankName = "";
                $this->bankAccountType = ""; 
                $this->firstName = "";
                $this->accountMname = "";
                $this->lastName  = "";
                $this->eftCheckingAccountNumber = "";
                $this->routingNumber = "";
                $this->memberId = "";
                $this->firstName  = "";
                $this->middleName = "";
                $this->lastName  = "";
                $this->street  = "";
                $this->city  = "";
                $this->state = "";
                $this->zip = "";
                $this->primaryPhone = "";
                $this->cellPhone = "";
                $this->email = "";
                $this->dob = "";
                $this->licenseNumber = "";
                $this->emgContact = "";
                $this->emgRelationship = "";
                $this->emgPhone = "";
                $this->liabilityTerms  = "";
                $this->memberPhoto = "";
                $this->serviceIdMonthly = "";
                $this->unitPrice = "";
                $this->initiationFee = "";
                $this->downPayment = "";
                $this->monthlyDues = "";
                $this->serviceSignUpDate = "";
                $this->startDate = "";
                $this->endDate = "";
                $this->serviceName = "";
                $this->userId = "";
                $this->transfer = "";
                $this->serviceKeyMonthly = "";
                $this->accountStatusMonthly = "";
                $this->monthlyBillingType = "";
                $this->nextBillingDate = "";
                $this->nextBillingFee = "";
                $this->billingStatus = "";
                $this->nextPaymentDueDate = "";
                $this->numMonths = "";
                $this->paymentAmount = "";
                $this->serviceKeys = "";
                $this->paymentDate = "";
                $this->restartDate = "";
                $this->serviceId = "";
                $this->serviceKey = "";
                $this->creditSecNum = "";
                $this->creditTerm = "";
                $this->creditDate  = "";
                $this->creditEnd  = "";
                $this->serviceIdPif = "";
                $this->groupType = "";
                $this->groupNumber = "";
                $this->serviceKey = "";
                $this->clubId = "";
                $this->serviceName = "";
                $this->serviceQuantity = "";
                $this->serviceTerm = "";
                $this->unitPrice = "";
                $this->unitRenewRate = "";
                $this->groupPrice = "";
                $this->groupRenewRate = "";
                $this->startingDate = "";
                $this->endDate = "";
                $this->contractTransfer = "";
                $this->accountStatusPif = "";
                $this->serviceKeyClassCount = "";
                $this->classCount = "";
                $this->serviceKeyClassCountSchedular = "";
                $this->classCountSchedular = "";
             }
    $stmt->close();
          
    

}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>