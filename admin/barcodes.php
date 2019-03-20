<?php


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
require"dbConnect.php";
return $dbMain;
}

//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//===============================================================================================
function checkAccountStatus() {
$count = 0;
$dbMain = $this->dbconnect();
$totalCount = 0;

$stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($service_id); 
while($stmt->fetch()){
        $stmt1 = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$service_id'");
        $stmt1->execute();      
        $stmt1->store_result();      
        $stmt1->bind_result($count);
        $stmt1->fetch();
        $stmt1->close();
        $totalCount += $count;
                                    
        $service_id = "";
                    }
                    $stmt->close();

$this->statusCount = $totalCount;
}
//===============================================================================================
function checkServiceCredit() {
    
$this->serviceCreditDiscount = 0;
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) FROM service_credits WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

$this->creditCount = $count;

if ($this->creditCount >= '1'){
    $stmt999 = $dbMain ->prepare("SELECT service_key FROM service_credits WHERE contract_key='$this->contractKey'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($service_key);
    while($stmt999->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT service_term FROM service_cost WHERE service_key='$service_key'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_term);
        $stmt->fetch(); 
        $stmt->close();
        
        if ($service_term == 'M'){
            $stmt = $dbMain ->prepare("SELECT unit_price, number_months, MAX(end_date) FROM monthly_services WHERE service_key='$service_key' AND contract_key='$this->contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($unit_price, $number_months, $end_date);
            $stmt->fetch(); 
            $stmt->close();
            $this->serviceCreditDiscount +=  sprintf("%01.2f", ($unit_price/$number_months));
        }
        
    }
    $stmt999->close();
}else{
    $this->creditCount = 0;
}
 

}
//==================================================================================================
function checkSettledPaymentsCount() {
    
$dbMain = $this->dbconnect();    
$contract_key = '';
$stmt = $dbMain ->prepare("SELECT contract_key, next_payment_due_date FROM monthly_settled WHERE contract_key='$this->contractKey' AND next_payment_due_date <= '$this->dueDate' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $next_payment_due_date);
$stmt->fetch();
$stmt->close();

$this->nextPaymentDueDate = $next_payment_due_date;
//echo "next due date $next_payment_due_date <br>";
if ($contract_key == $this->contractKey){
    $this->monthlySettledCount = 0;
}else{
    $this->monthlySettledCount = 1;
}

if ($contract_key == '' OR $contract_key == 0){
    $this->monthlySettledCount = 0;
}
}
//==============================================================================================
function readWriteData(){
        
        $dbMain = $this->dbconnect();
    
    
    $stmt = $dbMain->prepare("SELECT member_id FROM member_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->barcode);   
    $stmt->fetch();   
         

        $this->outFile .= "$this->contractKey, T$this->barcode \r\n";
        
        //echo "$this->outFile<br><br>";
                                    
           

}
//==============================================================================================
function fileMaker(){
    
    $dbMain = $this->dbconnect();
    
    $billingDate = 25;//date('d');    
    
$this->serviceIdArray = "";

$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->pastDay);
$stmt->fetch();
$stmt->close();

$counter = 1;
                //echo "$cycDay $cycDate $this->dueDate";
                
$crTotal = 0;
$achTotal = 0;
$totalBilling = 0;
    $stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key, cycle_date, billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key != '' AND DAY(cycle_date) = '$billingDate' AND (monthly_billing_type = 'CR' OR monthly_billing_type = 'BA') ORDER BY contract_key ASC");
if(!$stmt999->execute())  {
                        	printf("Error:FUBAR TWO %s.\n", $stmt->error);
                              }	      
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey, $this->cycleDate, $this->billingAmount, $monthly_billing_type); 
while($stmt999->fetch()){
    //echo "test $counter $this->contractKey<br>";
        $this->statusCount = 0;
                    $this->prePayCount = 0;
                    $this->creditCount = 1;
                    $this->monthlySettledCount = 0;
                    
                    
                    $customerBillingDate = date('d',strtotime($this->cycleDate));
                    
                    if(date('d') < $customerBillingDate){
                        $mStart = date('m')-1;//8;
                        $yStart = date('Y');
                        $billingDate = date('d');//25;
                    }elseif(date('d') == $customerBillingDate){
                        $mStart = date('m');//8;
                        $yStart = date('Y');
                        $billingDate = date('d');//25;
                    }elseif(date('d') > $customerBillingDate){
                        $mStart = date('m');//8;
                        $yStart = date('Y');
                        $billingDate = date('d');//25;
                    }
                    
                    //$mStart = 8;//date('m');//8;
                    //    $yStart = 2014;//date('Y');
                    //    $billingDate = 25;//date('d');//25;
                   // $cycDate = date("F j, Y",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
                    $this->dueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
                    
                    //$this->nextBillDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate-$this->pastDay,$yStart));                                                            
                    
                    $yearStart = date('Y',strtotime($this->dueDate));
                   
                    
                    
                    
                   
                    
                    //echo"test2 $this->contractKey";
                        $billing_amount = $this->billingAmount;
                        $this->checkAccountStatus();
                     //   echo " $this->statusCount ";
                        if ($this->statusCount >= 1){
                           
                           // echo "test key $this->contractKey due date $this->dueDate";  
                            $this->checkPrepay();
                     //   echo " $this->prePayCount ";
                            if ($this->prePayCount == 0){
                                
                                $this->checkSettledPaymentsCount();
                                $this->checkServiceCredit(); 
                      //  echo " $this->monthlySettledCount $this->dueDate$dateFlag<br>";                                                                                                
                                if ($this->monthlySettledCount == 0){
                                    
                                    
                                    $mStart = date('m')-1;//8;
                                    $yStart = date('Y');
                                    $billingDate = date('d');//25;
                                    $dueMonth = date('m',strtotime($this->nextPaymentDueDate));
                                    $dueDay = date('d',strtotime($this->nextPaymentDueDate));
                                    $dueYear = date('Y',strtotime($this->nextPaymentDueDate));
                                    $this->dueDate = date('Y-m-d H:i:s',mktime(23,59,59,1,25,2015));
                                    
                                        if($this->creditCount >= 1){
                                                
                                            $this->billingAmount = sprintf("%01.2f", ($this->serviceCreditDiscount - $this->billingAmount));
                                        }
                                        
                                        if($this->billingAmount > 0){
                                           $this->readWriteData();
                                            $counter++;
                                            
                                        }
                                         //echo "test $counter<br>"; 
                                        
                                    
                                }
                                }
                            
                            }
             $this->cycleDate = "";
             $this->billingAmount = "";
             $monthly_billing_type = "";
             $this->contractKey = "";
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
             $this->bankName = "";
             $this->bankAccountType = "";
             $this->eftCheckingAccountNumber = "";
             $this->routingNumber = "";
             $this->CardCreditCardType = "";
             $this->CardCreditCardNumber = "";
             $this->CardCreditCardExpirationDate = "";
             $this->monthlyBillingType = "";
             $this->dueDate = "";
             $this->billingAmount = "";
             }
        $stmt999->close();
        
        $fileHeader = "contractKey, barcode \r\n";
        
        $this->outFile = "$fileHeader$this->outFile";
    //echo "$this->outFile";
    
     $ourFileName = "exitFile.csv";
     $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
     fwrite($ourFileHandle, $this->outFile);  
     fclose($ourFileHandle);

}
//==============================================================================================
}
$makeFile = new createExitFile();
$makeFile->fileMaker();

?>