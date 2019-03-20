<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class printGuestPass {

private  $passId =null;
private  $passTitle = null;
private  $duration = null;
private  $passDateStart = null;
private  $passDateEnd = null;
private  $passTopic = null;
private  $passMessage = null;
private  $serviceList = null;
private  $serviceKey = null;
private  $guestPass = null;
private  $guestName = null;
private  $guestPhone = null;
private  $guestEmail = null;
private  $barCodeInt = null;
private  $barCodeInsert = null;
private  $barCode = null;
private  $startDate = null;
private  $endDate = null;
private  $locationId = null;
private  $logoImage = null;
private  $imageAspect = null;
private  $serviceLocation = null;


function setBarCodeInt($barCodeInt) {
          $this->barCodeInt = $barCodeInt;
          }
          

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//================================================================
function loadServiceList() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type, club_id FROM service_info WHERE service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceType, $clubId);
$stmt->fetch();
$stmt->close();

$result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$clubId'");
                       $row = mysqli_fetch_array($result, MYSQLI_NUM);
                       $this->serviceLocation = $row[0];
                                  
                                  if($this->serviceLocation == "")  {
                                     $this->serviceLocation = 'All Locations';
                                     }


$this->serviceList .= "<b>$serviceType $this->serviceLocation<b><br>";


}
//----------------------------------------------------------------------------------------------------------------
function loadServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_key FROM guest_pass_services WHERE pass_id='$this->passId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceKey);

while ($stmt->fetch()) { 
        $this->serviceKey = $serviceKey;
        $this->loadServiceList();
        }


$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------
function loadPassInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pass_title, location_id,  pass_topic, pass_message FROM guest_pass WHERE pass_id='$this->passId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passTitle, $locationId,  $passTopic, $passMessage);
$stmt->fetch();

$this->passTitle = $passTitle;
$this->locationId = $locationId;
$this->passTopic = $passTopic;
$this->passMessage = $passMessage;

$stmt->close();



}
//--------------------------------------------------------------------------------------------------------------
function loadLogo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect FROM contract_defaults WHERE contract_key='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($imageName, $imagePath, $imageAspect);
$stmt->fetch();

$this->logoImage = "$imagePath$imageName";
$this->imageAspect = $imageAspect;
  
$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------
function parseGuestPass() {

if($this->passTopic == "" &&  $this->passMessage == "") {
   $promoBlurb = "";
   }else{
   $promoBlurb = "
   <span class=\"blackBold\">
     <b>$this->passTopic</b>
   </span>
   <br>
    <b>$this->passMessage</b>";
   }


$this->guestPass= <<<GUESTPASS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css" media="all">

#passHolder  {
position: relative;
text-align: center;
top: 15px;
width: 3in;
height: 5in;
margin: 0 auto;
margin-left: auto; 
margin-right: auto;
border-style: solid;
border-width: 1px;
border-color: black;
border-top-right-radius: 8px;
border-top-left-radius: 8px; 
border-bottom-right-radius: 8px;
border-bottom-left-radius: 8px;
}

#logoImg {
position: relative;
top: 10px;
}

#guestHeader {
position: relative;
top: 15px;
font-size: 19pt;
font-weight: 50;
font-style: normal;
font-family: "Georgia";
color: #000;
}

#guestInfo {
position: relative;
top: 30px;
font-size: 10pt;
font-weight: 400;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #000000;
}

.hr {
  border: 0;
  width: 60%;
  height: 1px;
  color: #000;
  background-color: #000;
}

#serviceInfo {
position: relative;
top: 25px;
font-size: 10pt;
font-weight: 400;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #666666;
}

#promo {
position: relative;
top: 40px;
margin-left: auto; 
margin-right: auto;
padding-right: 20px;
padding-left: 20px;
padding-top: 10px;
padding-bottom: 10px;
background-color: #F0F0F0;
font-size: 10pt;
font-weight: 400;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #000;
}

.blackBold {
font-weight: 700;
}

#barCode {
position: absolute;
top: 4in;
margin-left: auto; 
margin-right: auto;
}

</style>

<head>
<script type="text/javascript" src="../scripts/printPage.js"></script>
<title>Guest Pass</title>
</head>
<body>


<div id="passHolder">

<div id="logoImg">
<a href="javascript: void(0)" onClick="printPage()"><img src="$this->logoImage"border="0" $this->imageAspect\></a>
</div>

<div id="guestHeader">
<b>Guest Pass</b>
</div>

<div id="guestInfo">
<b>$this->guestName</b>
<br>
<b>$this->passTitle</b>
<br>
<b>$this->duration Days</b>
<br>
<b>Exp: $this->endDate</b>
<p>
<hr class="hr"/>
</p>
</div>

<div id="serviceInfo">
<b>$this->serviceList</b>
</div>

<div id="promo">
<b>$promoBlurb</b>
</div>


<div id="barCode">
<img src="barCode.php?barcode=G$this->barCodeInt&amp;width=270&amp;height=80&amp;quality=100&amp;format=png&amp;stream_type=1"> 
</div>



</div>


</body>
</html>
GUESTPASS;




}
//-------------------------------------------------------------------------------------------------------------
function createGuestPass() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pass_id, duration, end_date, guest_name FROM guest_register WHERE bar_code='$this->barCodeInt'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passId, $duration, $endDate, $guestName);
$stmt->fetch();

$this->passId = $passId;
$this->duration = $duration;
$this->endDate = date("n/j/Y",  strtotime($endDate));
$this->guestName = $guestName;

$stmt->close();


$this->loadPassInfo();
$this->loadServices();
$this->loadLogo();
$this->parseGuestPass();



//$this->guestPass = "Image:  <img src=\"$this->logoImage\"border=\"0\" \> <br>Name:  $this->guestName <br> Title: $this->passTitle <br> Duration: $this->duration Days <br> Exp: $this->endDate <br><br> Services:  <br> $this->serviceList  <br><br> Pass Topic: $this->passTopic <br> Pass message: $this->passMessage <br><br> BarCode: $this->barCodeInt";


}
//==============================================================
//these are the links for the table list that are more than one item
function getGuestPass()   {
	return($this->guestPass);
    } 

}
//-------------------------------------------------------------------------------------------------------------
$bar_code_int = $_REQUEST['bar_code_int'];

$loadPass = new printGuestPass();
$loadPass-> setBarCodeInt($bar_code_int);
$loadPass-> createGuestPass();
$guestPass = $loadPass-> getGuestPass();

echo"$guestPass";

?>