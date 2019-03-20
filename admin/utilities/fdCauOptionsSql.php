<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  fdCauOptionSql{
    
function   setSelectBool($select_bool){
        $this->selectBool = $select_bool;
        }
function   setRecordCount($counter){
        $this->counter = $counter;
        }
function   setTestMode($testMode) {
        $this->testMode = $testMode;
        }
function   setVisaBool($visaBool) {
        $this->visaBool = $visaBool;
        }
function   setMcBool($mcBool) {
        $this->mcBool = $mcBool;
        }
function   setDiscBool($discBool) {
        $this->discBool = $discBool;
        }
function   setDnsName($dnsName) {
        $this->dnsName = $dnsName;
        }
function   setPort($port) {
        $this->port = $port;
        }
function   setMerchantName($merchantName) {
        $this->merchantName = $merchantName;
        }
function   setJobName($jobName){
        $this->jobName = $jobName;
        }
function   setNorthSouth($northSouth) {
        $this->northSouth = $northSouth;
        }
function  setVisaBin($visaBin) {
        $this->visaBin = $visaBin;
        }
        
function   setMasterCardIca($mcIca) {
        $this->mcIca = $mcIca;
        }
function   setDiscoverPid($discoverPid) {
        $this->discoverPid = $discoverPid;
        }
function   setDiscoverMailboxId($discoverMailboxId) {
        $this->discoverMailboxId = $discoverMailboxId;
        }
        
function setDiscoverSeNumber($discoverSeNumber) {
        $this->discoverSeNumber = $discoverSeNumber;
        }
function   setMerchantNumber($merchantNumber) {
        $this->merchantNumber = $merchantNumber;
        }
        
function setFileType($fileType) {
        $this->fileType = $fileType;
        }
function setCardProcessorNameInfo($card_processor_name_info) {
        $this->cardProcessorNameInfo = $card_processor_name_info;
        }
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateCauOptions()     {

//create a confirmation message for errors
$this->confirmationMessage = "There was an error updating the Transaction Processor Options";
//echo "test444 $this->hmac1, $this->keyId1, $this->gatewayId1, $this->gatewayPass1, $this->gatewayLang1, $this->maxRetry1, $this->maxFailCycles1, $this->accountMode1 $this->clubId1 dfgdgdf";

$dbMain = $this->dbconnect();

$sql = "UPDATE billing_updater_options SET counter = ?, test_mode = ?, visa_bool = ?, mc_bool = ?, disc_bool = ?, dns_name = ?, port = ?, merchant_name = ?, job_name = ?, north_south = ?, visa_bin = ?, mastercard_ica = ?, discover_pid = ?, discover_mailbox_id = ?, discover_se_number = ?, file_type = ?, merchant_number = ?, card_processor_name_info = ?, select_bool = ? WHERE billing_key = '1'";

$stmt = $dbMain->prepare($sql);

echo($dbMain->error);

$stmt->bind_param('sssssssssssssssssss', $this->counter, $this->testMode, $this->visaBool, $this->mcBool, $this->discBool, $this->dnsName, $this->port, $this->merchantName, $this->jobName, $this->northSouth, $this->visaBin, $this->mcIca, $this->discoverPid, $this->discoverMailboxId, $this->discoverSeNumber, $this->fileType, $this->merchantNumber, $this->cardProcessorNameInfo, $this->selectBool);	
					
if(!$stmt->execute())  {
   // echo "fubar";
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = "Firstdata Processor Options Successfully Updated";
   return($this->confirmationMessage);
   }
   
$stmt->close();


}

//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadCauOptions() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving this Merchant Information";

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT test_mode, visa_bool, mc_bool, disc_bool, dns_name, port, merchant_name, job_name, north_south, visa_bin, mastercard_ica, discover_pid, discover_mailbox_id, discover_se_number, file_type, merchant_number, card_processor_name_info, select_bool FROM billing_updater_options WHERE billing_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->testMode, $this->visaBool, $this->mcBool, $this->discBool, $this->dnsName, $this->port, $this->merchantName, $this->jobName, $this->northSouth, $this->visaBin, $this->mcIca, $this->discoverPid, $this->discoverMailboxId, $this->discoverSeNumber, $this->fileType, $this->merchantNumber, $this->cardProcessorNameInfo, $this->selectBool); 
   $stmt->fetch();
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();
}
//==================================================================================================
function  getFileType(){
    return($this->fileType);
    }
function  getMerchantNumber(){
    return($this->merchantNumber);
    }
function  getTestMode(){
    return($this->testMode);
    }
function  getVisaBool(){
    return($this->visaBool);
    }
function  getMcBool(){
    return($this->mcBool);
    }
function  getDiscBool(){
    return($this->discBool);
    }
function  getDnsName(){
    return($this->dnsName);
    }
function    getPort(){
    return($this->port);
    }
function    getMerchantName(){
    return($this->merchantName);
    }
function    getJobName(){
    return($this->jobName);
    }
function  getNorthSouth(){
    return($this->northSouth);
    }
function  getVisaBin(){
    return($this->visaBin);
    }
function getMasterCardIca(){
    return($this->mcIca);
}
function  getDiscoverPid(){
    return($this->discoverPid);
    }
function  getDiscoverMailboxId(){
    return($this->discoverMailboxId);
    }
function  getDiscoverSeNumber(){
    return($this->discoverSeNumber);
    }
function  cardProcessorNameInfo(){
    return($this->cardProcessorNameInfo);
    }
function  getSelectBool(){
    return($this->selectBool);
    }
}
?>