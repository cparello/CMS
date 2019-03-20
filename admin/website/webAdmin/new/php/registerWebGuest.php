<?php
session_start();
class  registerGuestSql{

private  $passId =null;
private  $passTitle = null;
private  $duration = null;
private  $passMessage = null;
private  $passDateStart = null;
private  $passDateEnd = null;
private  $passTopic = null;
private  $serviceList = null;
private  $serviceKey = null;
private  $guestPass = null;
private  $guestName = null;
private  $guestPhone = null;
private  $guestEmail = null;
private  $interestOne = null;
private  $interestTwo = null;
private  $barCodeInt = null;
private  $barCodeInsert = null;
private  $barCode = null;
private  $startDate = null;
private  $endDate = null;
private  $saveBit = null;



function setPassId($passId) {
          $this->passId = $passId;
          }
function setDuration($duration) {
          $this->duration = $duration;
          }
function setGuestName($guestName) {
          $this->guestName = $guestName;
          }
function setGuestPhone($guestPhone) {
          $this->guestPhone = $guestPhone;
          }          
function setGuestEmail($guestEmail) {
          $this->guestEmail = $guestEmail;
          }                  
function setInterestOne($interestOne) {         
          $this->interestOne = $interestOne;
          }
function setInterestTwo($interestTwo) {         
          $this->interestTwo = $interestTwo;
          }          
function setBarCodeInt($barCodeInt) {
          $this->barCodeInt = $barCodeInt;
          }



//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}
//================================================================
function loadStartEndDates() {

$this->startDate = date("Y-m-d H:i:s");
$this->endDate = date("Y-m-d H:i:s"  ,mktime(date("H"), date("i"), date("s"), date("m"), date("d")+$this->duration, date("Y")));

}
//---------------------------------------------------------------------------------------------------------------
function registerGuest() {
//echo "fu test";
//exit;
$this->loadStartEndDates();

$location_id = $_SESSION['location_id'];
$barCode = $this->barCodeInsert;
$passId = $this->passId;
$duration = $this->duration;
$startDate = $this->startDate; 
$endDate = $this->endDate;
$guestName = $this->guestName; 
$guestPhone = $this->guestPhone;
$guestEmail = $this->guestEmail;
$interestOne = $this->interestOne;
$interestTwo = $this->interestTwo;
$quoted_price = "WEB";

$dbMain = $this->dbconnect();

$count1 = 0;
$count2 = 0;
$count3 = 0;
$sum = 0;

$stmt = $dbMain ->prepare("SELECT count(*) FROM guest_register WHERE guest_email LIKE '%$guestEmail%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count1);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT count(*) FROM guest_register WHERE guest_name LIKE '%$guestName%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count2);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT count(*) FROM member_info WHERE email LIKE '%$guestEmail%' AND first_name LIKE '%$fname%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count3);
$stmt->fetch();
$stmt->close();

$sum = $count1 + $count2 + $count3;

if($sum == 0){
$sql = "INSERT INTO guest_register VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssssssss', $barCode, $passId, $duration, $startDate, $endDate, $guestName, $guestPhone, $guestEmail, $interestOne, $interestTwo, $location_id, $quoted_price);   
$stmt->execute();
$this->barCodeInt = $stmt->insert_id; 
$this->saveBit = "1";
$stmt->close(); 
$guestResult = "$this->barCodeInt|$this->saveBit";
return $guestResult;
}else{
    return 99;
}

}
//-------------------------------------------------------------------------------------------------------------------
function updateGuest() {

$this->loadStartEndDates();

$passId = $this->passId;
$duration = $this->duration;
$startDate = $this->startDate; 
$endDate = $this->endDate;

$dbMain = $this->dbconnect();
$sql = "UPDATE guest_register SET pass_id=?, duration=?, start_date=?, end_date=?  WHERE bar_code= '$this->barCodeInt'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiss' , $passId, $duration, $startDate, $endDate);              
$stmt->execute();   
$stmt->close(); 

$updateResult = 1;
return $updateResult;

}
//======================================================================================


    
}
//--------------------------------------------------------------------------------------

$pass_id = $_REQUEST['pass_id'];
$duration = $_REQUEST['duration'];
$guest_name = $_REQUEST['guest_name'];
$guest_phone = $_REQUEST['guest_phone'];
$guest_email = $_REQUEST['guest_email'];
$interest_one = $_REQUEST['interest_one'];
$interest_two = $_REQUEST['interest_two'];
$ajax_switch = $_REQUEST['ajax_switch'];
$bar_code_int = $_REQUEST['bar_code_int'];


$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone = $_REQUEST['phone']; 
$email  = $_REQUEST['email'];  
$location = $_REQUEST['location'];   
                


if($ajax_switch == 1) {

$saveGuest = new registerGuestSql();
$saveGuest-> setPassId($pass_id);
$saveGuest-> setDuration($duration);
$saveGuest-> setGuestName($guest_name);
$saveGuest-> setGuestPhone($guest_phone);
$saveGuest-> setGuestEmail($guest_email);
$saveGuest-> setInterestOne($interest_one);
$saveGuest-> setInterestTwo($interest_two);
$result1 = $saveGuest-> registerGuest();

echo"$result1";
exit;
}
//==============================
if($ajax_switch == 2) {

$updateGuest = new registerGuestSql();
$updateGuest-> setPassId($pass_id);
$updateGuest-> setDuration($duration);
$updateGuest-> setBarCodeInt($bar_code_int);
$result2 = $updateGuest-> updateGuest();

echo"$result2";
exit;
}


if($ajax_switch == 3) {

include "../../../../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT pass_id FROM guest_pass WHERE location_id = '$location'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pass_id);
$stmt->fetch();
$stmt->close();
//echo "fubar";
//exit;
$_SESSION['location_id'] = $location;

if ($pass_id == ""){
    $pass_id = 0;
}

$stmt = $dbMain ->prepare("SELECT guestPassLength FROM website_locations_setup WHERE club_name = (SELECT club_name FROM club_info WHERE club_id = '$location')");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($duration);
$stmt->fetch();
$stmt->close();
//echo "$duration";
//exit;
$interest_one = "Website";
$interest_Two = "Website";
$guest_name = "$first_name $last_name";
//echo "$pass_id $duration $guest_name $phone $email $interest_one $interest_Two";
//exit;
$saveGuest = new registerGuestSql();
$saveGuest-> setPassId($pass_id);
$saveGuest-> setDuration($duration);
$saveGuest-> setGuestName($guest_name);
$saveGuest-> setGuestPhone($phone);
$saveGuest-> setGuestEmail($email);
$saveGuest-> setInterestOne($interest_one);
$saveGuest-> setInterestTwo($interest_Two);



$result1 = $saveGuest-> registerGuest();
$resultArr = explode('|',$result1);
$barCodeInt = $resultArr[0];
/*    
include"../../memberinterface/barCode.php";  
                     
$text = 1;     
$format = 'jpeg';
$quality = 100;
$width = 270;
$height =  80;
$barcode = ('G'+$barCodeInt); 
$type = 2;
$image_name = ($barcode+'.jpg');
$image_path = '/barcodes/';
                         
$parseBar = new barCode();
$parseBar-> setText($text); 
$parseBar-> setFormat($format);
$parseBar-> setQuality($quality);
$parseBar-> setWidth($width);
$parseBar-> setBHeight($height);
$parseBar-> setBarCode($barcode);
$parseBar-> setType($type); 
$parseBar-> setImagePath($image_path);
$parseBar-> setImageName($image_name);
$parseBar-> parseImageSave();
*/


echo"$result1";
exit;
}








?>