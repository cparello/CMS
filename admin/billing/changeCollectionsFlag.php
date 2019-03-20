<?php
session_start();


class  changeCollectionsFlag{

function setContractKey($contractKey) {
          $this->contractKey = $contractKey;
          }
function setPastAmount($amount) {
          $this->amount = $amount;
          }
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function changeFlag() {
$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM billing_collections WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($billing_amount);
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT member_id FROM member_info WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($member_id);
 $stmt->fetch();
 $stmt->close();
 
 $months = round($this->amount/$billing_amount);
 
 $todaysDate = date('Y-m-d H:i:s');
 
 if($count == 0){
    $sql = "INSERT INTO billing_collections VALUES (?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('idis', $this->contractKey, $this->amount, $months, $todaysDate);
    $stmt->execute();
    $stmt->close(); 
    
    $status = "CO";

    $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s', $status);
    if(!$stmt->execute())  {
        printf("Error:updateStatus %s.\n", $stmt->error);
    }	
    $stmt->close();
    
    $userId = '55';
	$amPm = 'PM';
	$noteTopic = 'Member Put in Collections';
	$noteMessage = "Member put into collections because they were $months months past due and owe $$this->amount";
	$noteCategory = 'MI';
	$priority = 'H';
	$targetApp = 'MI';
    
    $sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iisssssiss',$this->contractKey,$userId,$todaysDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$member_id,$priority,$targetApp);
	if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
	$stmt->close();
    
    $this->result = 1;
 }else{
    $sql = "DELETE FROM billing_collections WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->execute();
    $stmt->close();
    
    $status = "CU";

    $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s', $status);
    if(!$stmt->execute())  {
        printf("Error:updateStatus %s.\n", $stmt->error);
    }	
    $stmt->close();
    
    $userId = '55';
	$amPm = 'PM';
	$noteTopic = 'Member removed from Collections';
	$noteMessage = "Member was removed from collections mode is now live.";
	$noteCategory = 'MI';
	$priority = 'H';
	$targetApp = 'MI';
    
    $sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iisssssiss',$this->contractKey,$userId,$todaysDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$member_id,$priority,$targetApp);
	if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
	$stmt->close();
    
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
$contract_key = $_REQUEST['contract_key'];
$past_amount = $_REQUEST['past_amount'];

//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new changeCollectionsFlag();
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> setPastAmount($past_amount); 
$loadPricing-> changeFlag();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>