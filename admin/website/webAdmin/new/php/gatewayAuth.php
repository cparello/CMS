<?php
//session_start();
//echo"what the f";
//exit;
class  gatewayAuth{

private $merchantId = null;
private $accountMode = null;
private $transactionKey = null;
private $accessLink = null;


function setMerchantId($merchantId) {
        $this->merchantId = $merchantId;
         }
function setAccountMode($accountMode) {
        $this->accountMode = $accountMode;
         }         

//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function loadGatewayOptions() {

$dbMain = $this->dbconnect();
//echo"tetetet";
//exit;
   $stmt = $dbMain ->prepare("SELECT merchant_id, transaction_key_test, account_mode, test_link, live_link, transaction_key_live FROM gateway_info WHERE transaction_key_test != ''");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($merchantId, $transactionKeyTest, $accountMode, $testLink, $liveLink, $transactionKeyLive); 
   $stmt->fetch();


$this->merchantId = $merchantId; 


if($accountMode == 1) {
  $this->accessLink = $testLink;
  $this->transactionKey = $transactionKeyTest;
  }elseif($accountMode == 2) {
  $this->accessLink = $liveLink;
  $this->transactionKey = $transactionKeyLive;
  }


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }


}
//==================================================================================================
function getMerchantId() {
       return($this->merchantId);
      }

function getTransactionKey() {
       return($this->transactionKey);
      }

function getAccessLink() {
       return($this->accessLink);
     }



}
?>