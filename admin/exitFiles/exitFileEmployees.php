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
    $stmt = $dbMain->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, emergency_contact, emergency_phone, social_security, email FROM employee_info WHERE user_id = '$this->userId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->emp_fname, $this->emp_mname, $this->emp_lname, $this->emp_street, $this->emp_city, $this->emp_state, $this->emp_zip, $this->emp_phone1, $this->emp_phone2, $this->emergency_contact, $this->emergency_phone, $this->social_security, $this->email);   
    $stmt->fetch();
    $stmt->close();
    
    $ourFileName = "employees.txt";
    $ourFileHandle = fopen($ourFileName, 'a');
    
    $this->file = "\"$this->userId\",\"$this->emp_fname\",\" $this->emp_mname\",\" $this->emp_lname\",\" $this->emp_street\",\" $this->emp_city\",\" $this->emp_state\",\" $this->emp_zip\",\" $this->emp_phone1\",\" $this->emp_phone2\",\" $this->emergency_contact\",\" $this->emergency_phone\",\" $this->social_security\",\" $this->email\" \n";
        
    fwrite($ourFileHandle, $this->file);                
                  
    fclose($ourFileHandle);          
  
}
//==============================================================================================
function fileMaker(){
    
    $ourFileName = "employees.txt";
    $ourFileHandle = fopen($ourFileName, 'a');
    
    $this->file = "  userId, emp_fname,   emp_mname,   emp_lname,   emp_street,   emp_city,   emp_state,   emp_zip,   emp_phone1,   emp_phone2,   emergency_contact,   emergency_phone,   social_security,   email\n";
        
    fwrite($ourFileHandle, $this->file);                
                  
    fclose($ourFileHandle);          
    
    $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT DISTINCT user_id FROM employee_info WHERE user_id != '0'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->userId);
    while ($stmt->fetch()) { 
                echo"$this->userId  <br> ";
                $this->readData();
                
                $this->userId = "";
                $this->emp_fname = "";
                $this->emp_mname = "";
                $this->emp_lname = "";
                $this->emp_street = "";
                $this->emp_city = "";
                $this->emp_state = "";
                $this->emp_zip = "";
                $this->emp_phone1 = "";
                $this->emp_phone2 = "";
                $this->emergency_contact = "";
                $this->emergency_phone = "";
                $this->social_security = "";
                $this->email = "";
             }
    $stmt->close();
    

}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>