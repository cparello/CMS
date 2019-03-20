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


function setFirstName($first) {
          $this->first = $first;
          }
function setLastName($last) {
          $this->last = $last;
          }
function setEmail($email) {
          $this->email = $email;
         }  
function setPhone($phone) {
          $this->phone = $phone;
         }            

//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------
function createGuestPassEmail() {

$dbMain = $this->dbconnect();
$message ="
LEAD:
$this->first $this->last
$this->phone
$this->email
";


   
    $uid = md5(uniqid(time()));
    
    $header = "From: Burbank Athletic Club <info@burbankathleticclub.com>\r\n";
    $header .= "Reply-To: info@burbankathleticclub.com\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    
mail("themanclinic@gmail.com", "BAC Lead", "", $header);
//mail("christopherparello@gmail.com", "BAC Lead", "", $header);

$smSalesKey = "";
$sql = "INSERT INTO man_clinic_leads VALUES (?, ?, ?, ?, ?)";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('issss', $smSalesKey, $this->first, $this->last, $this->email, $this->phone);
     if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }
    $stmt->close();

}
//==============================================================


}
//-------------------------------------------------------------------------------------------------------------
$ajax = $_REQUEST['ajax_switch'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];

$emailPass = new emailGuestPass();
$emailPass-> setFirstName($first_name);
$emailPass-> setLastName($last_name);
$emailPass-> setPhone($phone);
$emailPass-> setEmail($email);
$emailPass-> createGuestPassEmail();


echo"1";
exit;
?>