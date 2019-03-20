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
function fileMaker(){
    
    $ourFileName = "employeeTypes.csv";
    $ourFileHandle = fopen($ourFileName, 'a');
    
    $this->file = "  type_key, employee_type, employee_description, club_id\n";
        
    fwrite($ourFileHandle, $this->file);                
                  
    fclose($ourFileHandle);          
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT type_key, employee_type, employee_description, club_id FROM employee_type WHERE type_key != '0'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($type_key, $employee_type, $employee_description, $club_id);
    while ($stmt->fetch()) { 
                echo"$type_key  <br> ";
                $ourFileName = "employeeTypes.csv";
                $ourFileHandle = fopen($ourFileName, 'a');
                
                $this->file = " \"$type_key\",\"$employee_type\",\"$employee_description\",\" $club_id\"\n";
                    
                fwrite($ourFileHandle, $this->file);                
                              
                fclose($ourFileHandle);      
                
                $type_key = "";
                $employee_type = "";
                $employee_description = "";
                $club_id = "";
             }
    $stmt->close();
    

}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>