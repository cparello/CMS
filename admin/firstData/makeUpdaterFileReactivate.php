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

//echo "$header";
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
$ourFileName = "../firstDataUpdaterFiles/cauUpdateFileReactivate.$newJobName.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

$array= array(12502,12583,9018,7986,12672,12678,12686,12705,12708,12739,12745,12752,12778,12779,12781,12797,12818,12828,12854,12892,12896,12905,12907,12947,12950,12968,13023,13027,13032,13035,13071,13080,13090,13192,13203,13214,13218,13224,13296,13316,13329,13331,13346,13348,13411,13413,13427,13491,13499,13465,13471,13483,13556,13592,13593,13612,13624,13628,13642,13667,13698,13711,13722,13724,13740,13747,13795,13796,13827,13846,13882,13903,13935,13960,13970,13992,14012,14042,14046,14113,14163,14214,14215,14216,14229,14264,14265,14273,14289,14294,14300,14309,14318,14337,14339,14340,14342,14344,14358,14381,14382,14394,14396,14415,14427,14435,14443,14446,14471,14472,14504,14505,14573,14598,14604,14605,14633,14660,14664,14693,14696,14723,14768,14854,14888,14937,14963,14965,14973,14984,15028,15130,15194,15195,15212,15214,15226,15230,15247,16998,17018,17064,17074,17086,17193,17195,17334,17345,17352,17367,17374,17377,17393,17394,17410,17469,17477,17480,17501,17537,17583,17604,17616,17619,17649,17670,17682,17701,17732,17766,17770,17773,17802,17827,17856,17916,18002,18025,18045,18073,18077,18084,18122,18134,18150,18218,18315,18426,18455,18456,18476,18488,18545,18842,18847,18861,18883,18889,18908,18921,18939,18946,18959,19004,19018,19022,19032,19041,19050,19097,19123,19129,19142,19184,19206,19232,19240,19241,19288,19298,19310,19315,19331,19336,19352,19388,19416,19420,19437,19444,19524,19564,19579,19580,19604,19627,19639,19708,19779,19802,19811,19854,19871,19885,19973,19992,20005,20056,20075,20088,20107,20144,20237,20265,20309,20368,20431,20462,20463,20502,20519,20555,20602,20623,20659,20681,20738,20758,20824,20825,20841,20851,20869,20870,20911,20912,20930,20980,20981,20989,20992,21043,21060,21074,21083,21086,21114,21154,21231,21256,21275,21283,21289,21348,21353,21407,21408,21412,21415,21462,21487,21523,21526,21553,21555,21595,21645,21670,21692,21723,21831,21939,21944,21958,21959,21961,21998,22000,22009,22010,22014,22020,22038,22048,22059,22061,22065,22107,22115,22143,22163,22164,22200,22205,22206,22237,22251,22287,22421,22422,22436,22448,22463,22469,22475,22500,22504,22513,22542,22546,22553,22578,22606,22635,22640,22670,22677,22690,22703,22707,22733,22748,22760,22768,22784,22790,22791,22796,22814,22830,22865,22869,22886,22900,22912,22917,23009,23021,23067,23140,23145,23193,23198,23263,23353,23360,23389,23405,23454,23459,23463,23486,23488,23490,23495,23518,23520,23523,23525,23526,23540,23562,23567,23568,23571,23580,23581,23584,23588,23619,23623,23633,23638,23651,23656,23671,23673,23714,23734,23735,23746,23781,23785,23790,23846,23861,23927,23937,23950,23994,24081,24102,24145,24149,24168,24170,24171,24187,24189,24191,24216,24244,24268,24286,24293,24295,24336,24344,24345,24363,24416,24438,24458,24479,24493,24497,24503,24521,24606,24639,24646,24649,24714,24749,24751,24758,24766,24785,24821,24838,24886,24918,24929,24955,24974,25022,25030,25052,25058,25069,25088,25100,25107,25111,25125,25146,25160,25167,25172,25177,25213,25263,25305,25310,25315,25337,25351,25355,25441,25574,25645,25667,25686,25727,25768,25777,25836,25877,25893,25894,25919,25935,25941,25943,26007,26020,26049,26054,26133,26138,26170,26216,26239,26244,26245,26251,26272,26277,26387,26444,26461,26494,26496,26524,26535,26565,26620,26638,26658,26820,26865,26884,26896,26913,26916,26925,26988,26989,27023,27032,27067,27070,27079,27080,27094,27164,27172,27173,27175,27196,27204,27227,27299,27303,27317,27342,27346,2735,27406,27466,27497,27506,27558,27567,27593,27599,27638,27650,27654,27676,27678,27696,27720,27749,27778,27795,27841,27843,27846,27854,27989,28026,28034,28049,28068,28146,28147,28149,28185,28191,28193,28198,28203,28205,28230,28260,28262,28270,28304,28330,28341,28342,28362,28406,28423,28461,28468,28476,28510,28515,28521,28533,28547,28572,28574,28583,28585,28586,28605,28610,28652,28653,28655,28657,28669,28673,28676,28677,28697,28702,28724,28741,28787,28792,28794,28810,28822,28832,28836,28850,28857,28872,28879,28881,28891,28906,28912,28988,28989,28994,28999,29011,29020,29030,29064,29073,29092,29096,29098,29102,29103,29105,29124,29132,29146,29153,29182,29186,29210,29280,29304,29351,29355,29419,29421,29463,29487,29490,29491,29494,29570,29594,29600,29610,29618,29630,29657,29701,29702,29712,29754,29782,29820,29823,29832,29834,29870,29902,29906,29914,30008,30038,30049,30053,30072,30103,30122,30144,30158,30205,30218,30270,30291,30305,30308,30358,30372,31122,31153,31185,31272,31274,31281,31282,31291,31397,31401,31405,31412,31439,31456,31533,31598,31657,31658,31699,31734,31748,31796,31798,31851,31915,31916,31933,32023,32239,32248,32249,32274,32327,32354,32414,32463,32527,32558,32586,32627,32678,32712,32773,32777,32805,32836,32841,32843,32959,33078,33122,33191,33193,33241,33292,33331,33358,33360,33440,33644);

//$count = 5;
$dbMain = $this->dbconnect();
foreach($array as $this->contractKey) { 
        //echo "startfvdfvfba";
       
                        echo "$this->contractKey $this->statusCount ";
        
            //echo "test;";
                $stmt11 = $dbMain ->prepare("SELECT contract_key, card_number, card_exp_date, card_type FROM credit_info WHERE contract_key = '$this->contractKey'");
                $stmt11->execute();      
                $stmt11->store_result();      
                $stmt11->bind_result($contract_key, $cardNumber, $expDate, $cardType);
                $stmt11->fetch();
                $stmt11->close();
                echo "<br>$this->contractKey $cardNumber, $expDate, $cardType   $contract_key<br>";
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
        
        $this->contractKey = "";
        $cardNumber = "";
        $expDate = "";
        $cardType = "";
        
             }



$countLength = strlen($count);
if($countLength < 9){
   $count = str_pad($count, 9, "0", STR_PAD_LEFT);
        }

$seventyRecord = "70 $fdMerchantName $fdMerchantNumber                      $discover_se_number  \r\n";
$eightyRecord = "80 $fdMerchantName $fdMerchantNumber    $count                          \r\n";
    
$file = "$header$visaInfRecord$mastercardInfRecord$discoverInfRecord$cardDetailRecord$seventyRecord$eightyRecord";    
//echo "$header";
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
    

    $this->fileMakerCurrentMonthlyMembers();

    
}
//==========================================================================================
}
$makeFile = new createUpdaterFile();
$makeFile->chooseWhich();

?>