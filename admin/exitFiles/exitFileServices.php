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
    $stmt = $dbMain->prepare("SELECT service_cost, service_term, service_quantity FROM service_cost WHERE service_key = '$this->service_key'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->service_cost, $this->service_term, $this->service_quantity);   
    while($stmt->fetch()){
        $ourFileName = "exitFileServices.txt";
            $ourFileHandle = fopen($ourFileName, 'a');

            $this->file = "\"$this->service_type\",\"$this->service_key\",\"$this->service_cost\",\"$this->service_term\",\"$this->service_quantity\"\n";
    
            fwrite($ourFileHandle, $this->file);                
                
            fclose($ourFileHandle);               
           
           //$this->service_key = "";
           $this->service_cost = "";
           $this->service_term = "";
           $this->service_quantity = "";
    }
    $stmt->close();
    
  $this->contractKey = "";
}
//==============================================================================================
function fileMaker(){
    $ourFileName = "exitFileServices.txt";
            $ourFileHandle = fopen($ourFileName, 'a');

            $this->file = "\"service_name\",\"service_key\",\"service_cost\",\"service_term\",\"service_quantity\"\n";
    
            fwrite($ourFileHandle, $this->file);                
                
            fclose($ourFileHandle);   
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT service_key, service_type FROM service_info WHERE service_key != '0'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->service_key, $this->service_type);
    while ($stmt->fetch()) { 
        echo"$this->contractKey<br>";
              $this->readData();
              $this->service_key = "";
               $this->service_type = "";
             }
    $stmt->close();
    

}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>