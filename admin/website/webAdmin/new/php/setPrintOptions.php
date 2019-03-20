<?php
session_start();


class printOptions {

private $printFormat = null;

 //connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------
function loadReceiptType() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT print_type FROM print_options WHERE print_marker ='1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($printType);         
$stmt->fetch(); 

$this->printFormat = $printType;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


$stmt->close();
}
//--------------------------------------------------------------
function getPrintFormat() {
    return($this->printFormat);
    }


}
//===================================
$ajax_switch = $_REQUEST['ajax_switch'];
$member_id = $_REQUEST['member_id'];
$purchase_marker = $_REQUEST['purchase_marker'];
$purchase_type = $_REQUEST['purchase_type'];
$printFormat = $_REQUEST['printFormat'];

if($ajax_switch == 1) {

$_SESSION['purchase_marker'] = $purchase_marker;
$_SESSION['purchase_type'] = $purchase_type;

$load = new printOptions();
$load-> loadReceiptType();
$printFormat = $load-> getPrintFormat();

$_SESSION['print_format'] = $printFormat;

echo"$printFormat";
exit;
}

//------------------------------------------------------------------
if($ajax_switch == 2) {

  $load = new printOptions();
  $load-> loadReceiptType();
  $printFormat = $load-> getPrintFormat();
  $_SESSION['print_format'] = $printFormat;
  $_SESSION['member_id'] = $member_id;
  
  echo"$printFormat";
  exit;  
  }












?>