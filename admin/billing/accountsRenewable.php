<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//unset the contract key
if (isset($_SESSION['contract_key']))  {
   unset($_SESSION['contract_key']);
}
include"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($clubName, $club_id); 
   while($stmt->fetch()){
    $clubName = trim($clubName);
    $clubDrop .="<option value=\"$club_id\">$clubName</option>";
    }
$clubDrop .="<option value=\"0\">All Clubs</option>";
//create date dropdowns
$dateStartMinusOne = date("M j, Y"  ,mktime(0, 0, 0, date("m")+2, 1, date("Y")));
$dateStartSecsMinusOne = strtotime($dateStartMinusOne);
$month1 = date('F',$dateStartSecsMinusOne);
$dateStartMinusTwo = date("M j, Y"  ,mktime(0, 0, 0, date("m")+3, 1, date("Y")));
$dateStartSecsMinusTwo = strtotime($dateStartMinusTwo);
$month2 = date('F',$dateStartSecsMinusTwo);
$dateStartMinusThree = date("M j, Y"  ,mktime(0, 0, 0, date("m")+4, 1, date("Y")));
$dateStartSecsMinusThree = strtotime($dateStartMinusThree);
$month3 = date('F',$dateStartSecsMinusThree);
//$dateStart = date("M j, Y"  ,mktime(0, 0, 0, date("m")+1, 1, date("Y")));
//$dateStartSecs = strtotime($dateStart);
//$month4 = date('F',$dateStartSecs);//<option value=\"$dateStartSecs\">$month4</option>

$options ="
<option value=\"$dateStartSecsMinusOne\">$month1</option>
<option value=\"$dateStartSecsMinusTwo\">$month2</option>
<option value=\"$dateStartSecsMinusThree\">$month3</option>";
$dateStartMinusZ6 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-13, 1, date("Y")));
$dateStartSecsMinusZ6 = strtotime($dateStartMinusZ6);
$monthN6 = date('F',$dateStartSecsMinusZ6);
$dateStartMinusZ5 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-12, 1, date("Y")));
$dateStartSecsMinusZ5 = strtotime($dateStartMinusZ5);
$monthN5 = date('F',$dateStartSecsMinusZ5);
$dateStartMinusZ4 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-11, 1, date("Y")));
$dateStartSecsMinusZ4 = strtotime($dateStartMinusZ4);
$monthN4 = date('F',$dateStartSecsMinusZ4);
$dateStartMinusZ3 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-10, 1, date("Y")));
$dateStartSecsMinusZ3 = strtotime($dateStartMinusZ3);
$monthN3 = date('F',$dateStartSecsMinusZ3);
$dateStartMinusZ2 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-9, 1, date("Y")));
$dateStartSecsMinusZ2 = strtotime($dateStartMinusZ2);
$monthN2 = date('F',$dateStartSecsMinusZ2);
$dateStartMinusZ1 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-8, 1, date("Y")));
$dateStartSecsMinusZ1 = strtotime($dateStartMinusZ1);
$monthN1 = date('F',$dateStartSecsMinusZ1);
$dateStartMinusZ = date("M j, Y"  ,mktime(0, 0, 0, date("m")-7, 1, date("Y")));
$dateStartSecsMinusZ = strtotime($dateStartMinusZ);
$month0 = date('F',$dateStartSecsMinusZ);
$dateStartMinusOne = date("M j, Y"  ,mktime(0, 0, 0, date("m")-6, 1, date("Y")));
$dateStartSecsMinusOne = strtotime($dateStartMinusOne);
$month1 = date('F',$dateStartSecsMinusOne);
$dateStartMinusTwo = date("M j, Y"  ,mktime(0, 0, 0, date("m")-5, 1, date("Y")));
$dateStartSecsMinusTwo = strtotime($dateStartMinusTwo);
$month2 = date('F',$dateStartSecsMinusTwo);
$dateStartMinusThree = date("M j, Y"  ,mktime(0, 0, 0, date("m")-4, 1, date("Y")));
$dateStartSecsMinusThree = strtotime($dateStartMinusThree);
$month3 = date('F',$dateStartSecsMinusThree);
$dateStartMinus4 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-3, 1, date("Y")));
$dateStartSecsMinus4 = strtotime($dateStartMinus4);
$month4 = date('F',$dateStartSecsMinus4);
$dateStartMinus5 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-2, 1, date("Y")));
$dateStartSecsMinus5 = strtotime($dateStartMinus5);
$month5 = date('F',$dateStartSecsMinus5);
$dateStartMinus6 = date("M j, Y"  ,mktime(0, 0, 0, date("m")-1, 1, date("Y")));
$dateStartSecsMinus6 = strtotime($dateStartMinus6);
$month6 = date('F',$dateStartSecsMinus6);
$dateStart = date("M j, Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")));
$dateStartSecs = strtotime($dateStart);
$month7 = date('F',$dateStartSecs);

$options2 ="
<option value=\"$dateStartSecsMinusZ6\">$monthN6</option>
<option value=\"$dateStartSecsMinusZ5\">$monthN5</option>
<option value=\"$dateStartSecsMinusZ4\">$monthN4</option>
<option value=\"$dateStartSecsMinusZ3\">$monthN3</option>
<option value=\"$dateStartSecsMinusZ2\">$monthN2</option>
<option value=\"$dateStartSecsMinusZ1\">$monthN1</option>
<option value=\"$dateStartSecsMinusZ\">$month0</option>
<option value=\"$dateStartSecsMinusOne\">$month1</option>
<option value=\"$dateStartSecsMinusTwo\">$month2</option>
<option value=\"$dateStartSecsMinusThree\">$month3</option>
<option value=\"$dateStartSecsMinus4\">$month4</option>
<option value=\"$dateStartSecsMinus5\">$month5</option>
<option value=\"$dateStartSecsMinus6\">$month6</option>
<option value=\"$dateStartSecs\">$month7</option>";


/*$dateStartMinusOne = date("M j, Y"  ,mktime(0, 0, 0, date("m")-3, 1, date("Y")));
$dateStartSecsMinusOne = strtotime($dateStartMinusOne);
$month1 = date('F',$dateStartSecsMinusOne);
$dateStartMinusTwo = date("M j, Y"  ,mktime(0, 0, 0, date("m")-2, 1, date("Y")));
$dateStartSecsMinusTwo = strtotime($dateStartMinusTwo);
$month2 = date('F',$dateStartSecsMinusTwo);
$dateStartMinusThree = date("M j, Y"  ,mktime(0, 0, 0, date("m")-1, 1, date("Y")));
$dateStartSecsMinusThree = strtotime($dateStartMinusThree);
$month3 = date('F',$dateStartSecsMinusThree);*/
$dateStart = date("M j, Y"  ,mktime(0, 0, 0, date("m")+1, 1, date("Y")));
//echo "$dateStart";
$dateStartSecs = strtotime($dateStart);
$month4 = date('F',$dateStartSecs);

$options3 ="
<option value=\"$dateStartSecs\">$month4</option>";

/*<option value=\"$dateStartSecsMinusOne\">$month1</option>
<option value=\"$dateStartSecsMinusTwo\">$month2</option>
<option value=\"$dateStartSecsMinusThree\">$month3</option>*/

$defaultDate = strtotime("+30 day");
$defaultDate = date("M j, Y",$defaultDate);

//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(55);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtRenewable.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/accountsRenewable.js\"></script>";

include "../templates/infoTemplate2.php";
include "../templates/accountsRenewableTemplate.php";



?>