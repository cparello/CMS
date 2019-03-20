<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  fdMerchantSql{
    
function   setMaxRetry($max_retry) {
        $this->maxRetry = $max_retry;
        }
function   setMaxCycsRetry($max_fail_cycles) {
        $this->maxFailCycles = $max_fail_cycles;
        }
function   setExpBool($exp_bool) {
        $this->expBool = $exp_bool;
        }
function   setNsfBool($nsf_bool) {
        $this->nsfBool = $nsf_bool;
        }
function   setEmailBool($email_bool) {
        $this->emailBool = $email_bool;
        }
function   setExpMonth($exp_month) {
        $this->expMonth = $exp_month;
        }
function   setExpYear($exp_year) {
        $this->expYear = $exp_year;
        }
        
function   setHmac1($hmac1) {
        $this->hmac1 = $hmac1;
        }
function   setKeyId1($key_id1) {
        $this->keyId1 = $key_id1;
        }
function   setGatewayId1($gateway_id1) {
        $this->gatewayId1 = $gateway_id1;
        }
function   setGatewayPass1($gateway_pass1) {
        $this->gatewayPass1 = $gateway_pass1;
        }
function   setGatewayLanguage1($gateway_lang1) {
        $this->gatewayLang1 = $gateway_lang1;
        }

function   setLink1($account_mode1) {
        $this->accountMode1 = $account_mode1;
        }  
function   setHmac2($hmac2) {
        $this->hmac2 = $hmac2;
        }
function   setKeyId2($key_id2) {
        $this->keyId2 = $key_id2;
        }
function   setGatewayId2($gateway_id2) {
        $this->gatewayId2 = $gateway_id2;
        }
function   setGatewayPass2($gateway_pass2) {
        $this->gatewayPass2 = $gateway_pass2;
        }
function   setGatewayLanguage2($gateway_lang2) {
        $this->gatewayLang2 = $gateway_lang2;
        }
function   setLink2($account_mode2) {
        $this->accountMode2 = $account_mode2;
        }     
function    setClubId1($clubId1) {
        $this->clubId1 = $clubId1;
        }     
function    setClubId2($clubId2) {
        $this->clubId2 = $clubId2;
        }            
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateProcessorOptions()     {
//create a confirmation message for errors
$this->confirmationMessage = "There was an error updating the Transaction Processor Options";
//echo "test444 $this->hmac1, $this->keyId1, $this->gatewayId1, $this->gatewayPass1, $this->gatewayLang1, $this->maxRetry1, $this->maxFailCycles1, $this->accountMode1 $this->clubId1 dfgdgdf";

$dbMain = $this->dbconnect();

$sql = "UPDATE billing_gateway_main_fields SET max_retries= ?, max_cycles_retry= ?, email_bool = ? WHERE gateway_key = '1'";//, exp_bool = ?, nsf_bool = ?, exp_month = ?, exp_year = ?
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iis', $this->maxRetry, $this->maxFailCycles,  $this->emailBool);//, $this->expMonth, $this->expYear	$this->expBool, $this->nsfBool,		
$stmt->execute();
$stmt->close();

//echo "<br><br><br>TESTTTTTTTTTTTTTTTTT    $this->hmac1, $this->keyId1, $this->gatewayId1, $this->gatewayPass1, $this->gatewayLang1, $this->accountMode1";


$sql = "UPDATE billing_gateway_fields SET  gateway_id= ?, passwordfd= ? WHERE club_id = '$this->clubId1'";//hmac= ?, key_id= ?,, languagefd= ?, link= ? 
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $this->gatewayId1, $this->gatewayPass1);	
$stmt->execute(); //$this->hmac1, $this->keyId1,, $this->gatewayLang1, $this->accountMode1
$stmt->close();
   
$sql = "UPDATE billing_gateway_fields SET  gateway_id= ?, passwordfd= ?  WHERE club_id = '$this->clubId2'";//hmac= ?, key_id= ?,
$stmt = $dbMain->prepare($sql);//, languagefd= ?, link = ?
$stmt->bind_param('ss', $this->gatewayId2, $this->gatewayPass2);	//			, $this->gatewayLang2, $this->accountMode2		$this->hmac2, $this->keyId2, 
$stmt->execute();
$stmt->close();
  
   $this->confirmationMessage = "Gateway Options Successfully Updated";
   return($this->confirmationMessage);
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadMerchantOptions() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving this Merchant Information";

$dbMain = $this->dbconnect();

$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id); 
while($stmt1->fetch()){
    $clubIDArray[$clubIdCounter] = $club_id;
    $clubIdCounter++;
}
$stmt1->close(); 

$clubId1 = $clubIDArray[0];
$clubId2 = $clubIDArray[1];

$stmt = $dbMain ->prepare("SELECT max_retries, max_cycles_retry, email_bool FROM billing_gateway_main_fields WHERE gateway_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->maxRetry, $this->maxFailCycles, $this->emailBool); 
   $stmt->fetch();
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();

   $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id = '$clubId1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->gatewayId1, $this->gatewayPass1); 
   $stmt->fetch();
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();
   //echo "test2 $clubId1 $this->hmac1";
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id = '$clubId2'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->gatewayId2, $this->gatewayPass2); 
   $stmt->fetch();
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();


 

}
//==================================================================================================
function  getMaxRetry(){
    return($this->maxRetry);
    }
function  getMaxCyclesRetry(){
    return($this->maxFailCycles);
    }
function    getExpBool(){
    return($this->expBool);
    }
function    getNsfBool(){
    return($this->nsfBool);
    }
function    getEmailBool(){
    return($this->emailBool);
    }
function  getExpMonth(){
    return($this->expMonth);
    }
function  getExpYear(){
    return($this->expYear);
    }
function getHmac1(){
    return($this->hmac1);
}
function  getKeyId1(){
    return($this->keyId1);
    }
function  getGatewayId1(){
    return($this->gatewayId1);
    }
function  getGatewayPassword1(){
    return($this->gatewayPass1);
    }
function  getGatewayLanguage1(){
    return($this->gatewayLang1);
    }
function  getLink1(){
    return($this->link1);
    }

function getHmac2(){
    return($this->hmac2);
}
function  getKeyId2(){
    return($this->keyId2);
    }
function  getGatewayId2(){
    return($this->gatewayId2);
    }
function  getGatewayPassword2(){
    return($this->gatewayPass2);
    }
function  getGatewayLanguage2(){
    return($this->gatewayLang2);
    }
function  getLink2(){
    return($this->link2);
    }

}
?>