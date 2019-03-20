<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

$max_retry = $_REQUEST['max_retry'];
$max_fail_cycles = $_REQUEST['max_fail_cycles'];
//$exp_bool = $_REQUEST['exp_bool'];
//$nsf_bool = $_REQUEST['nsf_bool'];
$email_bool = $_REQUEST['email_bool'];
//$exp_month = $_REQUEST['exp_month'];
//$exp_year = $_REQUEST['exp_year'];

//$hmac1 = $_REQUEST['hmac1'];
//$key_id1 = $_REQUEST['key_id1'];
$gateway_id1 = $_REQUEST['gateway_id1'];
$gateway_pass1 = $_REQUEST['gateway_pass1'];
//$gateway_lang1 = $_REQUEST['gateway_lang1'];
//$account_mode1 = $_REQUEST['account_mode1'];

//echo"tester $max_retry1 $max_fail_cycles1";

//$hmac2 = $_REQUEST['hmac2'];
//$key_id2 = $_REQUEST['key_id2'];
$gateway_id2 = $_REQUEST['gateway_id2'];
$gateway_pass2 = $_REQUEST['gateway_pass2'];
//$gateway_lang2 = $_REQUEST['gateway_lang2'];
//$account_mode2 = $_REQUEST['account_mode2'];

include "fdMerchantSql.php";

$max_retry = trim($max_retry);
$max_fail_cycles = trim($max_fail_cycles);
//$exp_bool = trim($exp_bool);
//$nsf_bool = trim($nsf_bool);
$email_bool = trim($email_bool);
//$exp_month = trim($exp_month);
//$exp_year = trim($exp_year);

//$hmac1 = trim($hmac1);
//$key_id1 = trim($key_id1);
$gateway_id1 = trim($gateway_id1);
$gateway_pass1 = trim($gateway_pass1);
//$gateway_lang1 = trim($gateway_lang1);
//$account_mode1 = trim($account_mode1);

//$hmac2 = trim($hmac2);
//$key_id2 = trim($key_id2);
$gateway_id2 = trim($gateway_id2);
$gateway_pass2 = trim($gateway_pass2);
//$gateway_lang2 = trim($gateway_lang2);
//$account_mode2 = trim($account_mode2);


//sets up the varibles for the form template
$submit_link = 'editFdMerchantId.php';
$submit_name = 'update';
$submit_title = "Update Options";
$page_title  = 'Edit NMI Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/fdMerchantId.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtFd.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


require"../dbConnect.php";
$clubIdCounter = 0;
$stmt1 = $dbMain->prepare("SELECT club_id, club_name FROM club_info WHERE club_id !=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($club_id, $club_name); 
while($stmt1->fetch()){
    $clubIDArray[$clubIdCounter] = $club_id;
    $clubNameArray[$clubIdCounter] = $club_name;
    $clubIdCounter++;
}
$stmt1->close(); 
$clubName1 = $clubNameArray[0];
$clubName2 = $clubNameArray[1];

$clubId1 = $clubIDArray[0];
$clubId2 = $clubIDArray[1];


//if form is submitted save to database
if ($marker == 1) {
$updateInfo = new fdMerchantSql();
$max_retry--;
$updateInfo-> setMaxRetry($max_retry);
$updateInfo-> setMaxCycsRetry($max_fail_cycles);
//$updateInfo-> setExpBool($exp_bool);
//$updateInfo-> setNsfBool($nsf_bool);
$updateInfo-> setEmailBool($email_bool);
//$updateInfo-> setExpMonth($exp_month);
//$updateInfo-> setExpYear($exp_year);
//echo "$hmac1 $key_id1 $gateway_id1 $gateway_pass1 $account_mode1";
//$updateInfo-> setHmac1($hmac1);
//$updateInfo-> setKeyId1($key_id1);
$updateInfo-> setGatewayId1($gateway_id1);
$updateInfo-> setGatewayPass1($gateway_pass1);
//$updateInfo-> setGatewayLanguage1($gateway_lang1);
//$updateInfo-> setLink1($account_mode1);

//$updateInfo-> setHmac2($hmac2);
//$updateInfo-> setKeyId2($key_id2);
$updateInfo-> setGatewayId2($gateway_id2);
$updateInfo-> setGatewayPass2($gateway_pass2);
//$updateInfo-> setGatewayLanguage2($gateway_lang2);
//$updateInfo-> setLink2($account_mode2);
$updateInfo-> setClubId1($clubId1);
$updateInfo-> setClubId2($clubId2);
$confirmation = $updateInfo-> updateProcessorOptions();
}



//load the form content
$loadInfo = new fdMerchantSql();
$loadInfo-> loadMerchantOptions();

$max_retry = $loadInfo-> getMaxRetry();
$max_retry++;
$max_fail_cycles = $loadInfo-> getMaxCyclesRetry();
//$exp_bool = $loadInfo-> getExpBool();
//$nsf_bool = $loadInfo-> getNsfBool();
$email_bool = $loadInfo-> getEmailBool();
//$exp_month = $loadInfo-> getExpMonth();
//$exp_year = $loadInfo-> getExpYear();
//echo "$exp_bool";

//$hmac1 = $loadInfo-> getHmac1();
//$key_id1 = $loadInfo-> getKeyId1();
$gateway_id1 = $loadInfo-> getGatewayId1();
$gateway_pass1 = $loadInfo-> getGatewayPassword1();//echo "test1 $hmac1";
//$gateway_lang1 = $loadInfo-> getGatewayLanguage1();
//$account_mode1 = $loadInfo-> getLink1();

//$hmac2 = $loadInfo-> getHmac2();
//$key_id2 = $loadInfo-> getKeyId2();
$gateway_id2 = $loadInfo-> getGatewayId2();
$gateway_pass2 = $loadInfo-> getGatewayPassword2();
//$gateway_lang2 = $loadInfo-> getGatewayLanguage2();
//$account_mode2 = $loadInfo-> getLink2();

switch($exp_month) {
        case "01":
        $a1 ="selected";
        break;
        case "02":
        $a2="selected";
        break;
        case "03":
        $a3 ="selected";
        break;
        case "04":
        $a4="selected";
        break;
        case "05":
        $a5 ="selected";
        break;
        case "06":
        $a6="selected";
        break;
        case "07":
        $a7 ="selected";
        break;
        case "08":
        $a8="selected";
        break;
        case "09":
        $a9 ="selected";
        break;
        case "10":
        $a10="selected";
        break;
        case "11":
        $a11 ="selected";
        break;
        case "12":
        $a12="selected";
        break;
        
      }

$expMonthSelectList = "
<option value=\"01\" $a1>January</option>
<option value=\"02\" $a2>February</option>
<option value=\"03\" $a3>March</option>
<option value=\"04\" $a4>April</option>
<option value=\"05\" $a5>May</option>
<option value=\"06\" $a6>June</option>
<option value=\"07\" $a7>July</option>
<option value=\"08\" $a8>August</option>
<option value=\"09\" $a9>September</option>
<option value=\"10\" $a10>October</option>
<option value=\"11\" $a11>November</option>
<option value=\"12\" $a12>December</option>";

$expYearSelectList = "";
$yearStart = date('y');
for($q=0;$q<=8;$q++){
    $actualYear = $yearStart+$q;
    if ($exp_year == $actualYear){
        $xyz="selected";
    }else{
        $xyz = "";
    }
    $expYearSelectList .= "
<option value=\"$actualYear\" $xyz>$actualYear</option>";
}


switch($email_bool) {
        case "Yes":
        $E ="selected";
        break;
        case "No":
        $D="selected";
        break;
        
      }

$emailSelectList = "
<option value=\"Yes\" $E>Yes</option>
<option value=\"NO\" $D>No</option>";


switch($exp_bool) {
        case "Yes":
        $T ="selected";
        break;
        case "No":
        $O="selected";
        break;
        
      }

$expSelectList = "
<option value=\"Yes\" $T>Yes</option>
<option value=\"NO\" $O>No</option>";

switch($nsf_bool) {
        case "Yes":
        $g ="selected";
        break;
        case "No":
        $b="selected";
        break;
        
      }

$nsfSelectList = "
<option value=\"Yes\" $g>Yes</option>
<option value=\"NO\" $b>No</option>";

//echo "account_mode2 $account_mode2";
/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(83);
$info_text = $getText -> createTextInfo();*/

include "../templates/infoTemplate2.php";
include "../templates/fdMerchantIdTemplate.php";




?>
