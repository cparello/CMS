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
    $stmt->bind_result($this->serviceIdMonthly ,$this->unitPriceMonthly,$this->initiationFee,$this->downPayment,$this->monthlyDues, $this->startDateMonthly, $this->endDateMonthly, $this->serviceNameMonthly, $this->userId, $this->transfer, $this->serviceKeyMonthly);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->nextPaymentDueDate);   
    $stmt->fetch();   
    $stmt->close();
    $this->nextPaymentDueDate = date('m-d-Y',mktime(0,0,0,date('m',strtotime($this->nextPaymentDueDate)),date('d',strtotime($this->nextPaymentDueDate))-6,date('Y',strtotime($this->nextPaymentDueDate))));
    
    $this->accountStatusMonthly = "";
    $stmt = $dbMain->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_id = '$this->serviceIdMonthly'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->accountStatusMonthly);   
    $stmt->fetch();   
    $stmt->close();
    
    if($this->accountStatusMonthly == 'CU' OR $this->accountStatusMonthly == 'CO'){
        $this->totMonthlyPayment += $this->monthlyDues;
        $this->numberMonthlys++;
        $this->monthlyCSV .= "$this->numberMonthlys\",$this->contractKey\",\"$this->monthlyDues\",\"$this->nextPaymentDueDate\" \n";
    }else if($this->accountStatusMonthly == 'CO'){
        $this->accountStatusMonthly = 'CU';
    }
    
    $stmt = $dbMain->prepare("SELECT monthly_billing_type, cycle_date, billing_amount, billing_status FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->monthlyBillingType,$this->nextBillingDate,$this->nextBillingFee,$this->billingStatus);   
    $stmt->fetch();   
    $stmt->close(); 
 
   $stmt = $dbMain->prepare("SELECT service_id, group_type, group_number,  service_key,  club_id,  service_name,  service_quantity,  service_term,  unit_price,  unit_renew_rate,  group_price,  group_renew_rate,  start_date,  end_date,  transfer FROM paid_full_services WHERE contract_key = '$this->contractKey'  AND service_name LIKE '%Membership%'  ORDER BY end_date DESC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceIdPif,$this->groupType,$this->groupNumber,$this->serviceKeyPif,$this->clubId,$this->serviceNamePif,$this->serviceQuantity,$this->serviceTerm,$this->unitPricePif,$this->unitRenewRate,$this->groupPrice,$this->groupRenewRate,$this->startingDatePif,$this->endDatePif,$this->contractTransfer);   
    $stmt->fetch();   
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey'  AND service_id = '$this->serviceIdPif'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->accountStatusPif);   
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
         $ourFileName = "exitfile.csv";
         $ourFileHandle = fopen($ourFileName, 'a');

        $this->file = "\"$this->contractKey\",\"$this->signupDate\",\"$this->contractDate\",\"$this->hostType\",\"$this->contractFirstName\",\"$this->contractAccountMname\",\"$this->contractLastName\",\"$this->contractStreet\",\"$this->contractCity\",\"$this->contractState\",\"$this->contractZipCode\",\"$this->contractPrimaryPhone\",\"$this->contractCellPhone\",\"$this->contractEmailAddress\",\"$this->contractDateOfBirth\",\"$this->contractLicenseNumber\",\"$this->groupType\",\"$this->groupNumber\",\"$this->groupName\",\"$this->groupAddress \",\"$this->groupPhone\",\"$this->CardFirstName\",\" $this->CardAccountMname\",\" $this->CardLastName\",\" $this->CardAddress\",\" $this->CardCity\",\" $this->CardZtate\",\" $this->CardZipCode\",\" $this->CardCreditCardType\",\" $this->CardCreditCardNumber\",\" $this->CardCreditCardExpirationDate\",\"$this->bankName\",\" $this->bankAccountType\",\" $this->firstName\",\" $this->accountMname\",\" $this->lastName\",\" $this->eftCheckingAccountNumber\",\"  $this->routingNumber\",\" $this->memberId\",\" $this->firstName\",\" $this->middleName\",\" $this->lastName\",\" $this->street\",\" $this->city\",\" $this->state\",\" $this->zip\",\" $this->primaryPhone\",\" $this->cellPhone\",\" $this->email\",\" $this->dob\",\" $this->licenseNumber\",\" $this->emgContact\",\" $this->emgRelationship\",\" $this->emgPhone\",\" $this->memberPhoto\",\" $this->serviceIdMonthly \",\"$this->unitPriceMonthly\",\"$this->initiationFee\",\"$this->downPayment\",\"$this->monthlyDues\",\" $this->startDateMonthly\",\" $this->endDateMonthly\",\" $this->serviceNameMonthly\",\" $this->userId\",\" $this->transfer\",\" $this->serviceKeyMonthly\",\" $this->accountStatusMonthly\",\" $this->monthlyBillingType\",\"$this->nextBillingDate\",\"$this->nextBillingFee\",\"$this->billingStatus\",\" $this->nextPaymentDueDate\",\" $this->numMonths\",\" $this->paymentAmount\",\" $this->serviceKeys\",\" $this->paymentDate\",\" $this->restartDate\",\" $this->serviceId\",\" $this->serviceKey\",\" $this->creditSecNum\",\" $this->creditTerm\",\" $this->creditDate\",\" $this->creditEnd\",\" $this->serviceIdPif\",\"$this->groupType\",\"$this->groupNumber\",\"$this->serviceKeyPif\",\"$this->clubId\",\"$this->serviceNamePif\",\"$this->serviceQuantity\",\"$this->serviceTerm\",\"$this->unitPricePif\",\"$this->unitRenewRate\",\"$this->groupPrice\",\"$this->groupRenewRate\",\"$this->startingDatePif\",\"$this->endDatePif\",\"$this->contractTransfer\",\" $this->accountStatusPif\",\"  $this->serviceKeyClassCount\",\" $this->classCount\",\" $this->serviceKeyClassCountSchedular\",\" $this->classCountSchedular\" \n";
    
    fwrite($ourFileHandle, $this->file);                
                
    fclose($ourFileHandle);               
           

}
//========================================csv======================================================
function fileMaker(){
    $this->numberMonthlys = 1;
    $ourFileName = "exitfile.csv";
         $ourFileHandle = fopen($ourFileName, 'a');

        $this->file = "\"contractKey\",\"signupDate\",\"contractDate\",\"hostType\",\"contractFirstName\",\"contractAccountMname\",\"contractLastName\",\"contractStreet\",\"contractCity\",\"contractState\",\"contractZipCode\",\"contractPrimaryPhone\",\"contractCellPhone\",\"contractEmailAddress\",\"contractDateOfBirth\",\"contractLicenseNumber\",\"groupType\",\"groupNumber\",\"groupName\",\"groupAddress \",\"groupPhone\",\"CardFirstName\",\" CardAccountMname\",\" CardLastName\",\" CardAddress\",\" CardCity\",\" CardZtate\",\" CardZipCode\",\" CardCreditCardType\",\" CardCreditCardNumber\",\" CardCreditCardExpirationDate\",\"bankName\",\" bankAccountType\",\" firstName\",\" accountMname\",\" lastName\",\" eftCheckingAccountNumber\",\"  routingNumber\",\" memberId\",\" firstName\",\" middleName\",\" lastName\",\" street\",\" city\",\" state\",\" zip\",\" primaryPhone\",\" cellPhone\",\" email\",\" dob\",\" licenseNumber\",\" emgContact\",\" emgRelationship\",\" emgPhone\",\" memberPhoto\",\" serviceIdMonthly \",\"unitPriceMonthly\",\"initiationFee\",\"downPayment\",\"monthlyDues\",\" startDateMonthly\",\" endDateMonthly\",\" serviceNameMonthly\",\" userId\",\" transfer\",\" serviceKeyMonthly\",\" accountStatusMonthly\",\" monthlyBillingType\",\"nextBillingDate\",\"nextBillingFee\",\"billingStatus\",\" nextPaymentDueDate\",\" numMonths\",\" paymentAmount\",\" serviceKeys\",\" paymentDate\",\" restartDate\",\" serviceId\",\" serviceKey\",\" creditSecNum\",\" creditTerm\",\" creditDate\",\" creditEnd\",\" serviceIdPif\",\"groupType\",\"groupNumber\",\"serviceKey\",\"clubId\",\"serviceNamePIF\",\"serviceQuantity\",\"serviceTerm\",\"unitPricePIF\",\"unitRenewRate\",\"groupPrice\",\"groupRenewRate\",\"startingDatePIF\",\"endDatePIF\",\"contractTransfer\",\" accountStatusPif\",\"  serviceKeyClassCount\",\" classCount\",\" serviceKeyClassCountSchedular\",\" classCountSchedular\" \n";
    
    fwrite($ourFileHandle, $this->file);                
                
    fclose($ourFileHandle);         
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM contract_info WHERE contract_key != '' ORDER BY contract_key ASC");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->contractKey);
    while ($stmt->fetch()) { 
  
        echo"$this->contractKey<br>";
              $this->readData();
              $this->writeData();
              
              
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
                $this->unitPriceMonthly = "";
                $this->initiationFee = "";
                $this->downPayment = "";
                $this->monthlyDues = "";
                $this->serviceSignUpDate = "";
                $this->startDateMonthly = "";
                $this->endDateMonthly = "";
                $this->serviceNameMonthly = "";
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
                $this->serviceKeyPif = "";
                $this->clubId = "";
                $this->serviceNamePif = "";
                $this->serviceQuantity = "";
                $this->serviceTerm = "";
                $this->unitPricePif = "";
                $this->unitRenewRate = "";
                $this->groupPrice = "";
                $this->groupRenewRate = "";
                $this->startingDatePif = "";
                $this->endDatePif = "";
                $this->contractTransfer = "";
                $this->accountStatusPif = "";
                $this->serviceKeyClassCount = "";
                $this->classCount = "";
                $this->serviceKeyClassCountSchedular = "";
                $this->classCountSchedular = "";
          }
    $stmt->close();
          
          
          $ourFileName = "monthlyBilling.csv";
         $ourFileHandle = fopen($ourFileName, 'a');

        $this->file = "\"number\",\"contractKey\",\"monthlyAmount\" \n $this->monthlyCSV \n count $this->numberMonthlys total $this->totMonthlyPayment ";
    
    fwrite($ourFileHandle, $this->file);                
                
    fclose($ourFileHandle); 
    
echo "test $this->totMonthlyPayment    $this->numberMonthlys";
}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>