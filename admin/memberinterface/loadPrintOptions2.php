<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class loadPrintOptions {

private $printFormat = null;

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
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

$_SESSION['print_format'] = $this->printFormat;


$stmt->close();
}
//--------------------------------------------------------------
function getPrintFormat() {
    return($this->printFormat);
    }


}
//===================================
$ajax_switch = $_REQUEST['ajax_switch'];
$purchaseTotal = $_REQUEST['purchaseTotal'];

$_SESSION['purchaseTotal'] = $purchaseTotal;

if($ajax_switch == 1) {

$load = new loadPrintOptions();
$load-> loadReceiptType();
$printFormat = $load-> getPrintFormat();

echo"$printFormat";
exit;
}
?>