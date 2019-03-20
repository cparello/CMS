<?php


class  changeServiceDatesPif{

private $serviceKey = null;
private $contractKey = null;
private $signupDate = null;
private $proDateStart = null;
private $proDateEnd = null;
private $startDate =null;
private $endDate = null;
private $yearRange = null;
private $monthRange = null;
private $plusMinus = null;
private $originalSignUpDate = null;
private $serviceSummary = null;


//these are all of the vars set by the upgrade form
function setServiceKey($serviceKey)  {
              $this->serviceKey = $serviceKey;
              }
function setContractKey($contractKey)  {
              $this->contractKey = $contractKey;
              }              
function setYearRange($yearRange)  {
              $this->yearRange = $yearRange;
              }      
function setMonthRange($monthRange)  {
              $this->monthRange = $monthRange;
              }    
function setPlusMinus($plusMinus)  {
              $this->plusMinus = $plusMinus;
              }


//---------------------------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------
function updateContractInfo()  {

//update the existing records
$dbMain = $this->dbconnect();
$sql = "UPDATE contract_info SET signup_date= ? WHERE contract_key = '$this->contractKey' AND signup_date='$this->originalSignUpDate'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('s',$this->signupDate);						

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close();


}
//-------------------------------------------------------------------------------------------
function updateInitialPayments()  {

//update the existing records
$dbMain = $this->dbconnect();
$sql = "UPDATE initial_payments SET signup_date= ? WHERE contract_key = '$this->contractKey' AND signup_date='$this->originalSignUpDate'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('s',$this->signupDate);						

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close();
}
//-------------------------------------------------------------------------------------------
function updatePifService()  {

//update the existing records
$dbMain = $this->dbconnect();
$sql = "UPDATE paid_full_services SET signup_date= ?, start_date= ?, end_date= ?  WHERE contract_key = '$this->contractKey' AND service_key= '$this->serviceKey' AND signup_date='$this->originalSignUpDate'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('sss',$this->signupDate, $this->startDate, $this->endDate);						



if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close();

}
//-------------------------------------------------------------------------------------------
function loadPifService()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain->prepare("SELECT  signup_date,  start_date, end_date FROM paid_full_services WHERE contract_key ='$this->contractKey'  AND  service_key= '$this->serviceKey' AND signup_date ='$this->originalSignUpDate'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($signup_date, $start_date, $end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();   
$stmt->close();

//create the new date ranges
$signupDate = strtotime("$this->plusMinus$this->monthRange month" , strtotime($signup_date)) ;
$this->signupDate = date('Y-m-d H:i:s' , $signupDate);

$startDate = strtotime("$this->plusMinus$this->monthRange month" , strtotime($start_date)) ;
$this->startDate = date('Y-m-d',$startDate);

$endDate = strtotime("$this->plusMinus$this->monthRange month" , strtotime($end_date)) ;
$this->endDate = date('Y-m-d',$endDate);


$this->serviceSummary = "
New Signup Date:   $this->signupDate 
<br> 
Orig Signup Date:  $signup_date
<br><br>
New Start Date:  $this->startDate 
<br> 
Orig Start Date:  $start_date 
<br><br> 
New End Date: $this->endDate 
<br> 
Orig End Date:  $end_date";



}
//------------------------------------------------------------------------------------------------
function loadLastSignup()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT signup_date FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($signup_date);
$stmt->fetch();
 
 
$this->originalSignUpDate = $signup_date;

$stmt->close();
 }
//------------------------------------------------------------------------------------------------

function getServiceSummary()  {
              return($this->serviceSummary);
              }


}

$contract_key = '1639';
$service_key = '154';
$month_range = '2';
$plus_minus = '-';

$changeService = new changeServiceDatesPif();
$changeService-> setPlusMinus($plus_minus);
$changeService-> setContractKey($contract_key);
$changeService-> setServiceKey($service_key);
$changeService-> setMonthRange($month_range);

//load the service and contract dates
$changeService-> loadLastSignup();
$changeService-> loadPifService();


//update tables
$changeService->updateInitialPayments();
$changeService->updatePifService();
$changeService->updateContractInfo(); 

$service_summary = $changeService-> getServiceSummary();

echo"$service_summary";
exit;
?>