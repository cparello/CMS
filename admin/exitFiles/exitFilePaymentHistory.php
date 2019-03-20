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
    $stmt = $dbMain->prepare("SELECT payment_amount, balance_due, payment_due_date, payment_date, payment_flag,
	payment_description, trans_key,	credit_payment,	ach_payment, cash_payment, check_payment, check_number,	bundled, reject_fee_check, reject_fee_credit,	reject_fee_ach, late_fee_all FROM payment_history WHERE contract_key = '$this->contractKey'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($this->payment_amount, $this->balance_due, $this->payment_due_date, $this->payment_date, $this->payment_flag,
	$this->payment_description, $this->trans_key,	$this->credit_payment,	$this->ach_payment, $this->cash_payment, $this->check_payment, $this->check_number,	$this->bundled, $this->reject_fee_check, $this->reject_fee_credit,	$this->reject_fee_ach, $this->late_fee_all);
    while($stmt->fetch()){
            $ourFileName = "exitFilePayHist.csv";
            $ourFileHandle = fopen($ourFileName, 'a');

            $this->file = "\"$this->contractKey\",\"$this->payment_amount\",\" $this->balance_due\",\" $this->payment_due_date\",\" $this->payment_date\",\" $this->payment_flag\",\"$this->payment_description\",\" $this->trans_key\",\"	$this->credit_payment\",\"	$this->ach_payment\",\" $this->cash_payment\",\" $this->check_payment\",\" $this->check_number\",\"	$this->bundled\",\" $this->reject_fee_check\",\" $this->reject_fee_credit\",\"	$this->reject_fee_ach\",\" $this->late_fee_all\"\n";

            fwrite($ourFileHandle, $this->file);

            fclose($ourFileHandle);

            $this->payment_amount = "";
            $this->balance_due = "";
            $this->payment_due_date = "";
            $this->payment_date = "";
            $this->payment_flag = "";
        	$this->payment_description = "";
            $this->trans_key = "";
           	$this->credit_payment = "";
            $this->ach_payment = "";
            $this->cash_payment = "";
            $this->check_payment = "";
            $this->check_number = "";
           	$this->bundled = "";
            $this->reject_fee_check = "";
            $this->reject_fee_credit = "";
           	$this->reject_fee_ach = "";
            $this->late_fee_all = "";
    }
    $stmt->close();
}
//==============================================================================================
function fileMaker(){
    $ourFileName = "exitFilePayHist.csv";
            $ourFileHandle = fopen($ourFileName, 'a');

            $this->file = "\"contractKey\",\"payment_amount\",\" balance_due\",\" payment_due_date\",\" payment_date\",\" payment_flag\",\"payment_description\",\" trans_key\",\"	credit_payment\",\"	ach_payment\",\" cash_payment\",\" check_payment\",\" check_number\",\"	bundled\",\" reject_fee_check\",\" reject_fee_credit\",\"	reject_fee_ach\",\" late_fee_all\"\n";
    
            fwrite($ourFileHandle, $this->file);                
                
            fclose($ourFileHandle);
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM contract_info WHERE contract_key != '0' ORDER BY contract_key ASC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($this->contractKey);
    while ($stmt->fetch()) {
              echo"$this->contractKey<br>";
              $this->readData();
              $this->contractKey = "";
             }
    $stmt->close();


}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>