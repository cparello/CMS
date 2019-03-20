<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

$visaBool = $_REQUEST['visaBool'];
$mcBool = $_REQUEST['mcBool'];
$discBool = $_REQUEST['discBool'];
$merchantNumber = $_REQUEST['merchantNumber'];
$fileType = $_REQUEST['fileType'];
$testMode = $_REQUEST['testMode'];
$dnsName = $_REQUEST['dnsName'];
$port = $_REQUEST['port'];
$merchantName = $_REQUEST['merchantName'];
$jobName = $_REQUEST['jobName'];
$northSouth = $_REQUEST['northSouth'];
$visaBin = $_REQUEST['visaBin'];
$mcIca = $_REQUEST['mcIca'];
$discoverPid = $_REQUEST['discoverPid'];
$discoverMailboxId = $_REQUEST['discoverMailboxId'];  //r = all     w = wells
$discoverSeNumber = $_REQUEST['discoverSeNumber'];
$card_processor_name_info = $_REQUEST['card_processor_name_info'];
$select_bool = $_REQUEST['select_bool'];

include "fdCauOptionsSql.php";


$visaBool = trim($visaBool);
$mcBool = trim($mcBool);
$discBool = trim($discBool);
$card_processor_name_info = trim($card_processor_name_info);
$testMode = trim($testMode);
$dnsName = trim($dnsName);
$port = trim($port);
$merchantName = trim($merchantName);
$jobName = trim($jobName);
$northSouth = trim($northSouth);
$visaBin = trim($visaBin);
$mcIca = trim($mcIca);
$discoverPid = trim($discoverPid);
$discoverMailboxId = trim($discoverMailboxId);
$discoverSeNumber = trim($discoverSeNumber);
$merchantNumber = trim($merchantNumber);
$fileType = trim($fileType);
$select_bool = trim($select_bool);

$counter = 3;
if ($visaBool == "Y"){
    $counter++;
}
if ($mcBool == "Y"){
    $counter++;
}
if ($discBool == "Y"){
    $counter++;
}

//sets up the varibles for the form template
$submit_link = 'editFdCauOptions.php';
$submit_name = 'update';
$submit_title = "Update Options";
$page_title  = 'Edit FirstData&#0174 Credit Card Account Updater Options';
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtFdCau.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";

//if form is submitted save to database
if ($marker == 1) {
$updateInfo = new fdCauOptionSql();
$updateInfo-> setRecordCount($counter);
$updateInfo-> setSelectBool($select_bool);
$updateInfo-> setCardProcessorNameInfo($card_processor_name_info);
$updateInfo-> setTestMode($testMode);
$updateInfo-> setVisaBool($visaBool);
$updateInfo-> setMcBool($mcBool);
$updateInfo-> setDiscBool($discBool);
$updateInfo-> setDnsName($dnsName);
$updateInfo-> setPort($port);
$updateInfo-> setMerchantName($merchantName);
$updateInfo-> setJobName($jobName);
$updateInfo-> setNorthSouth($northSouth);
$updateInfo-> setVisaBin($visaBin);
$updateInfo-> setMasterCardIca($mcIca);
$updateInfo-> setDiscoverPid($discoverPid);
$updateInfo-> setDiscoverMailboxId($discoverMailboxId);
$updateInfo-> setDiscoverSeNumber($discoverSeNumber);
$updateInfo-> setFileType($fileType);
$updateInfo-> setMerchantNumber($merchantNumber);
$confirmation = $updateInfo-> updateCauOptions();
}



$loadInfo = new fdCauOptionSql();

$loadInfo-> loadCauOptions();

$card_processor_name_info = $loadInfo-> cardProcessorNameInfo();
$testMode = $loadInfo-> getTestMode();
$visaBool = $loadInfo-> getVisaBool();
$mcBool = $loadInfo-> getMcBool();
$discBool = $loadInfo-> getDiscBool();
$dnsName = $loadInfo-> getDnsName();
$port = $loadInfo-> getPort();
$merchantName = $loadInfo-> getMerchantName();
$jobName = $loadInfo-> getJobName();
$northSouth = $loadInfo-> getNorthSouth();
$visaBin = $loadInfo-> getVisaBin();
$mcIca = $loadInfo-> getMasterCardIca();
$discoverPid = $loadInfo-> getDiscoverPid();
$discoverMailboxId = $loadInfo-> getDiscoverMailboxId();
$discoverSeNumber = $loadInfo-> getDiscoverSeNumber();//echo "test1 $hmac1";
$fileType = $loadInfo-> getFileType();
$merchantNumber = $loadInfo-> getMerchantNumber();//echo "test1 $hmac1";
$select_bool = $loadInfo-> getSelectBool();//echo "test1 $hmac1";

switch($testMode) {
        case "TEST":
        $x1 ="selected";
        break;
        case "LIVE":
        $z1="selected";
        break;
        
      }
//echo "$testMode   x1 $x1  z1 $z1";
$testSelectList = "
<option value=\"TEST\" $x1>TEST</option>
<option value=\"LIVE\" $z1>LIVE</option>";

switch($visaBool) {
        case "Y":
        $x2 ="selected";
        break;
        case "N":
        $z2="selected";
        break;
        
      }

$visaSelectList = "
<option value=\"Y\" $x2>Yes</option>
<option value=\"N\" $z2>No</option>";

switch($mcBool) {
        case "Y":
        $x3 ="selected";
        break;
        case "N":
        $z3="selected";
        break;
        
      }

$mcSelectList = "
<option value=\"Y\" $x3>Yes</option>
<option value=\"N\" $z3>No</option>";

switch($discBool) {
        case "Y":
        $x4 ="selected";
        break;
        case "N":
        $z4="selected";
        break;
        
      }

$discSelectList = "
<option value=\"Y\" $x4>Yes</option>
<option value=\"N\" $z4>No</option>";

switch($northSouth) {
        case "S":
        $T ="selected";
        break;
        case "N":
        $O="selected";
        break;
        
      }

$northSouthSelectList = "
<option value=\"S\" $T>South</option>
<option value=\"N\" $O>North</option>";

switch($discoverMailboxId) {
        case "R":
        $R ="selected";
        break;
        case "W":
        $W="selected";
        break;
        
      }

$mailboxSelectList = "
<option value=\"R\" $R>All Banks</option>
<option value=\"W\" $W>Wells Fargo</option>";
//echo "test";
//load the form content


//echo "<br><br>$select_bool gdfgdfgdf";
switch($select_bool) {
        case "All":
        $Rxx ="selected";
        break;
        case "Current":
        $Wzz="selected";
        break;
        
      }
$selectBoolSelectList  = "
<option value=\"All\" $Rxx>All Credit Cards</option>
<option value=\"Current\" $Wzz>Current Monthly Accounts</option>";


include "../templates/infoTemplate2.php";
include "../templates/fdCauOptionsTemplate.php";




?>
