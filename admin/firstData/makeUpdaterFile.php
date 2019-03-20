<?php
include('Net/SFTP.php');
//include('SSH2.php');
include('Crypt/RSA.php');
//error_reporting(E_ALL);
class createUpdaterFile{

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//===============================================================================================
function checkAccountStatus() {
$count = 0;
$dbMain = $this->dbconnect();

$idArray = explode('|',$this->serviceIdArray);

foreach($idArray as $id){
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status !='CA' AND contract_key='$this->contractKey' AND service_id = '$id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$totalCount += $count;
//echo"test fubar fubar xxxxxx  $count<br>";
 }
$this->statusCount = $totalCount;
}
//==============================================================================================
function fileMakerAllCreditCards(){


 
$dbMain = $this->dbconnect();
//echo "start";
$stmt = $dbMain->prepare("SELECT counter, test_mode, visa_bool, mc_bool, disc_bool, dns_name, port, merchant_name, job_name, north_south, visa_bin, mastercard_ica, discover_pid, discover_mailbox_id, discover_se_number, file_type, merchant_number, card_processor_name_info FROM billing_updater_options WHERE billing_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $testMode, $visaBool, $mcBool, $discBool, $dns_name, $port, $fdMerchantName, $newJobName, $northOrSouth, $visaBIN, $masterCardICA, $discover_pid, $discover_mailbox_id, $discover_se_number, $fileType, $fdMerchantNumber, $cardProcessorNameInfo);
$stmt->fetch();
$stmt->close();


$testMode = trim($testMode);
$testLength = strlen($testMode);
if($testLength < 4 OR $testMode == "LIVE"){
    //$dPadPad = 6 - $dPidLength;
    $testMode = "";
    $testMode = str_pad($testMode, 4);
} 

$discover_pid = trim($discover_pid);
$dPidLength = strlen($discover_pid);
if($dPidLength < 6){
    //$dPadPad = 6 - $dPidLength;
    $discover_pid = str_pad($discover_pid, 6, "0", STR_PAD_LEFT);
} 

$visaBIN = trim($visaBIN);
$vBinLength = strlen($visaBIN);
if($vBinLength < 6){
    //$vBinPad = 6 - $vBinLength;
    $vBinPad = str_pad($visaBIN, 6, "0", STR_PAD_LEFT);
} 

$masterCardICA = trim($masterCardICA);
$mIcaLength = strlen($masterCardICA);
if($mIcaLength < 6){
    //$mIcaPad = 6 - $mIcaLength;
    $masterCardICA = str_pad($masterCardICA, 6, "0", STR_PAD_LEFT);
}
//$fdMerchantName = "BURBANK AC CAU";//25 chars 
$fdMerchantName = trim($fdMerchantName);
$nameLength = strlen($fdMerchantName);
if($nameLength < 25){
    //$namePad = 25 - $nameLength;
    $fdMerchantName = str_pad($fdMerchantName, 25);
}
//$fdMerchantNumber = "267526675884";
$fdMerchantNumber = trim($fdMerchantNumber);
$merhNumLength = strlen($fdMerchantNumber);
if($merhNumLength < 12){
    //$merchNumPad = 12 - $merhNumLength;
    $fdMerchantNumber = str_pad($fdMerchantNumber, 12, "0", STR_PAD_LEFT);
} 

$discover_se_number = trim($discover_se_number);
$discoverSeLength = strlen($discover_se_number);
if($discoverSeLength < 15){
    //$merchNumPad = 12 - $merhNumLength;
    $discover_se_number = str_pad($discover_se_number, 15);
} 

//$northOrSouth = "N";
//$testMode = "Test";
//$cardProcessorNameInfo = "                         ";
//$fileType = "CAU1";
$creationDate = date('my');
$header = "00 $fdMerchantName $fdMerchantNumber    $creationDate                      $northOrSouth$testMode$fileType\r\n";
if ($visaBool == "Y"){
    $visaInfRecord = "01V                $visaBIN          $cardProcessorNameInfo                    \r\n";
}else{
    $visaInfRecord = "";
}
if ($mcBool == "Y"){
    $mastercardInfRecord = "01M                $masterCardICA          $cardProcessorNameInfo                    \r\n";
}else{
    $mastercardInfRecord = "";
}
if ($discBool == "Y"){
    $discoverInfRecord = "01D                $discover_pid$discover_mailbox_id          $cardProcessorNameInfo                    \r\n";
}else{
    $discoverInfRecord = "";
}
    
$ourFileName = "../firstDataUpdaterFiles/cauUpdateFile.$newJobName.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

//$count = 5;
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_key, card_number, card_exp_date, card_type FROM credit_info WHERE card_number != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->contractKey, $cardNumber, $expDate, $cardType);
    while ($stmt->fetch()) { 
        echo "test $this->contractKey<br>";
        $cardExpDate = date('my',strtotime($expDate));
        $cardNumber = str_replace(' ','',$cardNumber);
        $cardNumber = trim($cardNumber);
        $cardLength = strlen($cardNumber);
        if($cardLength < 16){
            //echo "needs pad";
            //$cardPad = 16-$cardLength;
            $cardNumber = str_pad($cardNumber, 16);
        }
       // $test =  strlen($cardNumber);
        //echo "ckey $this->contractKey card $cardNumber length $cardLength padlength $test<br>";
        $keyLength = strlen($this->contractKey);
        if($keyLength < 13){
            $this->contractKey = str_pad($this->contractKey, 13);
        }
        switch($cardType){
            case 'Visa':
                $cardTypeCode = "V";
                if($testMode == "TEST"){
                    $cardNumber = "4012000000000024";///comment out for live
                } 
                $cardDetailRecord .= "C1$cardTypeCode$cardNumber$cardExpDate                      $this->contractKey                      \r\n";//card num must be 16 chars
                $count++;
            break;
            case 'MC':
                $cardTypeCode = "M";
                if($testMode == "TEST"){
                    $cardNumber = "5442980000000016";///comment out for live
                } 
                $cardDetailRecord .= "C1$cardTypeCode$cardNumber$cardExpDate                      $this->contractKey                      \r\n";//card num must be 16 chars
                $count++;
            break;
            default:
            break;
        }
        $this->contractKey = "";
        $cardNumber = "";
        $expDate = "";
        $cardType = "";
        
             }
$stmt->close();


$countLength = strlen($count);
if($countLength < 9){
   $count = str_pad($count, 9, "0", STR_PAD_LEFT);
        }

$seventyRecord = "70 $fdMerchantName $fdMerchantNumber                      $discover_se_number  \r\n";
$eightyRecord = "80 $fdMerchantName $fdMerchantNumber    $count                          \r\n";
    
$file = "$header$visaInfRecord$mastercardInfRecord$discoverInfRecord$cardDetailRecord$seventyRecord$eightyRecord";    
fwrite($ourFileHandle, $file);                
                
fclose($ourFileHandle);
/*echo "start2";
$ssh = new Net_SSH2($dns_name);//$dns_name
$key = new Crypt_RSA();
echo "start3";
$key->loadKey(file_get_contents('../../../../../.ssh/id_rsa.pub'));//
echo "test$key";
if (!$ssh->login('MSOD-001775', $key)) {
    exit('Login Failed');
}

//++++++++++++++++++++++++++++
echo "test$key";
// open a file pointer, $port
$sftp = new Net_SFTP($dns_name);

$key = new Crypt_RSA();
echo "test2";
$key->loadKey(file_get_contents('id_rsa.pub'));
echo "$key";
if (!$sftp->login('MSOD-001775', $key)) {
    exit('Login Failed');
}

// copies filename.local to filename.remote on the SFTP server
$sftp->put('filename.remote', 'filename.local', NET_SFTP_LOCAL_FILE);
//++++++++++++++++++++++++++++++++++++++++++
*/

//echo "done";
}
//==============================================================================================
function fileMakerCurrentMonthlyMembers(){

$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT counter, test_mode, visa_bool, mc_bool, disc_bool, dns_name, port, merchant_name, job_name, north_south, visa_bin, mastercard_ica, discover_pid, discover_mailbox_id, discover_se_number, file_type, merchant_number, card_processor_name_info FROM billing_updater_options WHERE billing_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $testMode, $visaBool, $mcBool, $discBool, $dns_name, $port, $fdMerchantName, $newJobName, $northOrSouth, $visaBIN, $masterCardICA, $discover_pid, $discover_mailbox_id, $discover_se_number, $fileType, $fdMerchantNumber, $cardProcessorNameInfo);
$stmt->fetch();
$stmt->close();

$testMode = trim($testMode);
$testLength = strlen($testMode);
if($testLength < 4 OR $testMode == "LIVE"){
    //$dPadPad = 6 - $dPidLength;
    $testMode = "";
    $testMode = str_pad($testMode, 4);
} 

$discover_pid = trim($discover_pid);
$dPidLength = strlen($discover_pid);
if($dPidLength < 6){
    //$dPadPad = 6 - $dPidLength;
    $discover_pid = str_pad($discover_pid, 6, "0", STR_PAD_LEFT);
} 

$visaBIN = trim($visaBIN);
$vBinLength = strlen($visaBIN);
if($vBinLength < 6){
    //$vBinPad = 6 - $vBinLength;
    $vBinPad = str_pad($visaBIN, 6, "0", STR_PAD_LEFT);
} 

$masterCardICA = trim($masterCardICA);
$mIcaLength = strlen($masterCardICA);
if($mIcaLength < 6){
    //$mIcaPad = 6 - $mIcaLength;
    $masterCardICA = str_pad($masterCardICA, 6, "0", STR_PAD_LEFT);
}
//$fdMerchantName = "BURBANK AC CAU";//25 chars 
$fdMerchantName = trim($fdMerchantName);
$nameLength = strlen($fdMerchantName);
if($nameLength < 25){
    //$namePad = 25 - $nameLength;
    $fdMerchantName = str_pad($fdMerchantName, 25);
}
//$fdMerchantNumber = "267526675884";
$fdMerchantNumber = trim($fdMerchantNumber);
$merhNumLength = strlen($fdMerchantNumber);
if($merhNumLength < 12){
    //$merchNumPad = 12 - $merhNumLength;
    $fdMerchantNumber = str_pad($fdMerchantNumber, 12, "0", STR_PAD_LEFT);
} 

$discover_se_number = trim($discover_se_number);
$discoverSeLength = strlen($discover_se_number);
if($discoverSeLength < 15){
    //$merchNumPad = 12 - $merhNumLength;
    $discover_se_number = str_pad($discover_se_number, 15);
} 

//$northOrSouth = "N";
//$testMode = "Test";
//$cardProcessorNameInfo = "                         ";
//$fileType = "CAU1";
$creationDate = date('my');
$header = "00 $fdMerchantName $fdMerchantNumber    $creationDate                      $northOrSouth$testMode$fileType\r\n";
if ($visaBool == "Y"){
    $visaInfRecord = "01V                $visaBIN          $cardProcessorNameInfo                    \r\n";
}else{
    $visaInfRecord = "";
}
if ($mcBool == "Y"){
    $mastercardInfRecord = "01M                $masterCardICA          $cardProcessorNameInfo                    \r\n";
}else{
    $mastercardInfRecord = "";
}
if ($discBool == "Y"){
    $discoverInfRecord = "01D                $discover_pid$discover_mailbox_id          $cardProcessorNameInfo                    \r\n";
  //  echo "test1";
}else{
    $discoverInfRecord = "";
    //echo "test2";
}
   // echo "$discBool";
$ourFileName = "../firstDataUpdaterFiles/cauUpdateFile.$newJobName.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

//$count = 5;
$dbMain = $this->dbconnect();
$stmt99 = $dbMain ->prepare("SELECT DISTINCT contract_key FROM monthly_payments  WHERE contract_key != '' AND monthly_billing_type = 'CR' ORDER BY contract_key ASC");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($this->contractKey);
    while ($stmt99->fetch()) { 
        //echo "startfvdfvfba";
        $this->statusCount = "";
        $this->serviceIdArray = "";
        
        $stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($service_id); 
        while($stmt->fetch()){
            $this->serviceIdArray .= "$service_id|";
                    }
        $stmt->close();
        
        //var_dump($this->serviceIdArray);
        
        
        $this->checkAccountStatus();
                        //echo "$this->contractKey $this->statusCount ";
        if ($this->statusCount >= 1){
            //echo "test;";
                $stmt11 = $dbMain ->prepare("SELECT contract_key, card_number, card_exp_date, card_type FROM credit_info WHERE contract_key = '$this->contractKey'");
                $stmt11->execute();      
                $stmt11->store_result();      
                $stmt11->bind_result($contract_key, $cardNumber, $expDate, $cardType);
                $stmt11->fetch();
                $stmt11->close();
                //echo "<br>$this->contractKey $cardNumber, $expDate, $cardType   $contract_key<br>";
                $cardExpDate = date('my',strtotime($expDate));
                $cardNumber = str_replace(' ','',$cardNumber);
                $cardNumber = trim($cardNumber);
                $cardLength = strlen($cardNumber);
                if($cardLength < 16){
                    //echo "needs pad";
                    //$cardPad = 16-$cardLength;
                    $cardNumber = str_pad($cardNumber, 16);
                }
               // $test =  strlen($cardNumber);
                //echo "ckey $this->contractKey card $cardNumber length $cardLength padlength $test<br>";
                $keyLength = strlen($this->contractKey);
                if($keyLength < 13){
                    $this->contractKey = str_pad($this->contractKey, 13);
                }
                switch($cardType){
                    case 'Visa':
                   // echo "visa";
                        $cardTypeCode = "V";
                        if($testMode == "TEST"){
                            $cardNumber = "4012000000000024";///comment out for live
                        } 
                        $cardDetailRecord .= "C1$cardTypeCode$cardNumber$cardExpDate                      $this->contractKey                      \r\n";//card num must be 16 chars
                        $count++;
                    break;
                    case 'MC':
                    //echo "MC";
                        $cardTypeCode = "M";
                        if($testMode == "TEST"){
                            $cardNumber = "5442980000000016";///comment out for live
                        } 
                        $cardDetailRecord .= "C1$cardTypeCode$cardNumber$cardExpDate                      $this->contractKey                      \r\n";//card num must be 16 chars
                        $count++;
                    break;
                    default:
                    break;
                }
        }
        $this->contractKey = "";
        $cardNumber = "";
        $expDate = "";
        $cardType = "";
        
             }
$stmt99->close();


$countLength = strlen($count);
if($countLength < 9){
   $count = str_pad($count, 9, "0", STR_PAD_LEFT);
        }

$seventyRecord = "70 $fdMerchantName $fdMerchantNumber                      $discover_se_number  \r\n";
$eightyRecord = "80 $fdMerchantName $fdMerchantNumber    $count                          \r\n";
    
$file = "$header$visaInfRecord$mastercardInfRecord$discoverInfRecord$cardDetailRecord$seventyRecord$eightyRecord";    
fwrite($ourFileHandle, $file);                
                
fclose($ourFileHandle);
/*echo "start2";
$ssh = new Net_SSH2($dns_name);//$dns_name
$key = new Crypt_RSA();
echo "start3";
$key->loadKey(file_get_contents('../../../../../.ssh/id_rsa.pub'));//
echo "test$key";
if (!$ssh->login('MSOD-001775', $key)) {
    exit('Login Failed');
}

//++++++++++++++++++++++++++++
echo "test$key";
// open a file pointer, $port
$sftp = new Net_SFTP($dns_name);

$key = new Crypt_RSA();
echo "test2";
$key->loadKey(file_get_contents('id_rsa.pub'));
echo "$key";
if (!$sftp->login('MSOD-001775', $key)) {
    exit('Login Failed');
}

// copies filename.local to filename.remote on the SFTP server
$sftp->put('filename.remote', 'filename.local', NET_SFTP_LOCAL_FILE);
//++++++++++++++++++++++++++++++++++++++++++
*/

//echo "done";
}
//==============================================================================================
function chooseWhich(){
    
$dbMain = $this->dbconnect();

//echo "start";

$stmt = $dbMain->prepare("SELECT select_bool FROM billing_updater_options WHERE billing_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($selectBool);
$stmt->fetch();
$stmt->close();

if ($selectBool == "All"){
    $this->fileMakerAllCreditCards();
}else{
    $this->fileMakerCurrentMonthlyMembers();
}
    
}
//==========================================================================================
}
$makeFile = new createUpdaterFile();
$makeFile->chooseWhich();

?>