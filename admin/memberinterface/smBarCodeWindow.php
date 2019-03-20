<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class smBarCodeWindow {


private $memberId= null;
private $purchaseDate = null;
private $clubId = null;
private $printFormat = null;
private $busnessName = null;
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;
private $productDescription = null;
private $receiptItems = null;
private $receiptFormat = null;
private $invoiceType = null;
private $imageName = null;



function setMemberId($memberId) {
         $this->memberId = $memberId;
         }

function setPrintFormat($printFormat) {
         $this->printFormat = $printFormat;
         }
         
function setImageName($imageName) {
         $this->imageName = $imageName;
         }
         
function setClubId($clubId) {
         $this->clubId = $clubId;
         }         

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT  business_name FROM company_names WHERE business_name !='' "); 
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name);      
 $stmt->fetch();
 
$this->businessName = $business_name;


$stmt->close();
}
//---------------------------------------------------------------------------------
function loadClubInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_name, club_address, club_phone  FROM club_info WHERE club_id ='$this->clubId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_name, $club_address, $club_phone); 
$stmt->fetch();

$this->clubName = $club_name;
$this->clubAddress = $club_address;
$this->clubPhone = $club_phone;


$stmt->close();

}
//---------------------------------------------------------------------------------
function formatReceipt() {


$invoiceType = "<tr><td colspan=\"2\" align=\"center\">BAR CODE COPY</td></tr>";   
 
$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/receiptPrint.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<title>Bar Code Copy</title>
</head>
<body>';

$header = "<table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=100%>
<tr><td colspan=\"2\" align=\"center\"><a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/$this->imageName\" width=\"69\" height=\"27\"/></a></td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->businessName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubAddress</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubPhone<br><br></td></tr>";

$this->receiptItems = "<tr><td colspan=\"2\"><img src=\"barCode.php?barcode=$this->memberId&width=260&height=75&quality=100&format=jpeg&stream_type=1\"> <td></tr>";

$buffer = "<tr><td colspan=\"2\" align=\"center\">&nbsp;</td></tr>";
$footer = "</table></body></html>";


$this->receiptFormat = "$receiptHeader $header $buffer $buffer $this->receiptItems $buffer  $buffer $buffer  $invoiceType $footer";

}
//---------------------------------------------------------------------------------
function formatLetterReceipt() {


$invoiceType = "BAR CODE COPY";   
  

$headerLogoName = strtoupper($this->businessName);

$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/letterReceipt.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<title>Sales Receipt</title>
</head>
<body>';

$headerLogo = "<div id=\"header\" class=\"header\">
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/$this->imageName\" width=\"138\" height=\"54\"/></a>
<br>
<span class=\"logoTxt\">$headerLogoName</span>
</div>";

$headerInfo = "<div id=\"headerInfo\" class=\"headerInfo\">
$this->businessName
<br>
$this->clubName
<br>
$this->clubAddress
<br>
$this->clubPhone
</div>";

$this->receiptItems .= "<tr><td class=\"itemName\" align=\"center\"><br><br><br><br><br><br><br><br><img src=\"barCode.php?barcode=$this->memberId&width=260&height=75&quality=100&format=jpeg&stream_type=1\"><td></tr>";

$itemWindow ="<div id=\"itemContent\">
<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=95%>
$this->receiptItems
</table>
</div>";



$receiptFooter = "<div id=\"infoFooter\" class=\"infoFooter\">
$invoiceType
<br>
&nbsp;
</div>";

$footer = "</body></html>";

$this->receiptFormat = "$receiptHeader $headerLogo $headerInfo $itemWindow $totalsWindow $receiptFooter $footer";

}
//---------------------------------------------------------------------------------
function loadBarCodeReciept() {

$this->loadBusinessInfo();
$this->loadClubInfo();

   if($this->printFormat == 'L') {
      $this->formatLetterReceipt();
     }elseif($this>printFormat == 'R') {
      $this->formatReceipt();               
     }

}
//---------------------------------------------------------------------------------
function getReceiptFormat() {
      return($this->receiptFormat);
      }



}
//==============================================
include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

$member_id= $_SESSION['member_id'];
$print_format = $_SESSION['print_format'];

$club_id = $_SESSION['location_id'];   //do not unset

$loadReceipt = new smBarcodeWindow();
$loadReceipt-> setClubId($club_id);
$loadReceipt-> setMemberId($member_id);
$loadReceipt-> setPrintFormat($print_format);
$loadReceipt-> setImageName($image_name);
$loadReceipt-> loadBarCodeReciept();
$receiptFormat = $loadReceipt-> getReceiptFormat();


unset($_SESSION['member_id']);
unset($_SESSION['print_format']);

echo"$receiptFormat";
exit;

?>












