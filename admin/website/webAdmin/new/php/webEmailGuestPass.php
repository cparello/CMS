<?php
session_start();

class emailGuestPass {

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
private  $barCodeInt = null;
private  $barCodeInsert = null;
private  $barCode = null;
private  $startDate = null;
private  $endDate = null;
private  $locationId = null;
private  $serviceLocation = null;
private  $guestEmail = null;
private  $imagePath = null;
private  $imageName = null;
private  $result = null;
private  $markerId =1;
private  $fromAddress = null;
private  $replyAddress = null;
private  $fromName = null;
private  $introMessage = null;


function setBarCodeInt($barCodeInt) {
          $this->barCodeInt = $barCodeInt;
          }
function setImagePath($imagePath) {
          $this->imagePath = $imagePath;
          }
function setImageName($imageName) {
          $this->imageName = $imageName;
         }            

//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
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


$this->serviceList .= "$serviceType $this->serviceLocation\n";


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
//-------------------------------------------------------------------------------------------------------------
function parseGuestPassEmail() {

if($this->passTopic == "" &&  $this->passMessage == "") {
   $promoBlurb = "";
   }else{
   $passTopic = strtoupper($this->passTopic);
   $promoBlurb = "$passTopic\n$this->passMessage";
   }


$from_mail = $this->fromAddress;
$from_name = $this->fromName;
$replyto = $this->replyAddress;
$subject = $this->passTitle;
$message ="
Hello $this->guestName 

$this->introMessage

$this->serviceList
Expiration Date:  $this->endDate

$promoBlurb";


    $file = "$this->imagePath$this->imageName";
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    
    
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$this->imageName."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$this->imageName."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    
    if (mail($this->guestEmail, $subject, "", $header)) {
       $this->result = 1;
       }else{
        echo "mail send ... ERROR!";
       }

//delete the file from the server
unlink($file);


}
//-------------------------------------------------------------------------------------------------------------
function loadEmailDefaults() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT from_address, reply_address, from_name, intro_message FROM guest_pass_email WHERE  marker_id ='$this->markerId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($fromAddress, $replyAddress, $fromName, $introMessage);         
             $stmt->fetch(); 
             
             $this->fromAddress = $fromAddress;
             $this->replyAddress = $replyAddress;
             $this->fromName = $fromName;
             $this->introMessage = $introMessage;             
                          
             $stmt->close(); 


}
//-------------------------------------------------------------------------------------------------------------
function createGuestPassEmail() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pass_id, duration, end_date, guest_name, guest_email FROM guest_register WHERE bar_code='$this->barCodeInt'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passId, $duration, $endDate, $guestName, $guestEmail);
$stmt->fetch();

$this->passId = $passId;
$this->duration = $duration;
$this->endDate = date("n/j/Y",  strtotime($endDate));
$this->guestName = $guestName;
$this->guestEmail = $guestEmail;

$stmt->close();


$this->loadPassInfo();
$this->loadServices();
$this->loadEmailDefaults();
$this->parseGuestPassEmail();

return $this->result;

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
$image_name = $_REQUEST['image_name'];
$image_path = $_REQUEST['image_path'];

$emailPass = new emailGuestPass();
$emailPass-> setBarCodeInt($bar_code_int);
$emailPass-> setImagePath($image_path);
$emailPass-> setImageName($image_name);

$result = $emailPass-> createGuestPassEmail();


echo"$result";

?>