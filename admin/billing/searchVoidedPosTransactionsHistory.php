<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}

//=======================================================

//==============================================end timeout
//date_default_timezone_set('America/Los_Angeles');
class  searchPosSales{

private  $contractId = null;
private  $memberFullName = null;
private  $memberFirstName = null;
private  $memberMiddleName = null;
private  $memberLastName = null;
private  $memberId = null; 
private  $sqlNameSearch = null;
private  $resultCount = null;
private  $groupName = null;
 
function setBarcode($barcode) {
    $this->barcode = $barcode;
    }
function setInvoice($invoice) {
    $this->invoice= $invoice; 
    }
function setDate($date) {    
    $this->date = $date;
    }
function setCategory($category) {    
   $this->category = $category;
   }
function setMemberLastName($memberLastName) {    
   $this->memberLastName = $memberLastName;
   }
function setSqlNameSearch($sqlNameSearch) {
   $this->sqlNameSearch = $sqlNameSearch;
   }
function setResultCount($resultCount) {
   $this->resultCount = $resultCount;
   } 
function setGroupName($groupName) {
   $this->groupName = $groupName;
   }  
function setCCNum($cc_num){
    $this->ccNum = $cc_num;
}   

  function setEndRange($range2) {
   $this->range2 = $range2;
   }  
function setStartRange($range1){
    $this->range1 = $range1;
}    
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
 


//===================================================
function loadCatCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(category_name) AS cat_count  FROM refund_exchange JOIN refunded_transactions ON refund_exchange.purchase_marker= refunded_transactions.invoice_number  WHERE category_name LIKE  '%$this->category%'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($cat_count);
$stmt->fetch();

$this->resultCount = $cat_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "category_name LIKE  '%$this->category%'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

 }
//=================================================== 
function  loadInvoiceCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(item_marker) AS marker_count  FROM refund_exchange WHERE  purchase_marker = '$this->invoice'");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($marker_count);
$stmt->fetch();

$this->resultCount = $marker_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "purchase_marker = '$this->invoice'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadBarcodeCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(bar_code) AS barcode_count   FROM refund_exchange  WHERE bar_code = '$this->barcode'");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($barcode_count);
$stmt->fetch();

$this->resultCount = $barcode_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "bar_code = '$this->barcode'";


if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadDateCount()  {
    
 $month = date('m',strtotime($this->date));   
 $day = date('d',strtotime($this->date)); 
 
 $start = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day,date('Y')));
 $end = date('Y-m-d H:i:s',mktime(23,59,59,$month,$day,date('Y')));

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(re_date) AS date_count   FROM refund_exchange  WHERE (re_date BETWEEN '$start' AND '$end')");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($date_count);
$stmt->fetch();

$this->resultCount = $date_count;
$_SESSION['account_search_sql'] = "(re_date BETWEEN '$start' AND '$end')";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//=====================================================================
function loadRangeCount(){
    
 $month = date('m',strtotime($this->range1));   
 $day = date('d',strtotime($this->range1)); 
 $year = date('Y',strtotime($this->range1));
 $month2 = date('m',strtotime($this->range2));   
 $day2 = date('d',strtotime($this->range2)); 
 $year2 = date('Y',strtotime($this->range2));
 
 
 $start = date('Y-m-d H:i:s',mktime(0,0,0,$month,$day,$year));
 $end = date('Y-m-d H:i:s',mktime(23,59,59,$month2,$day2,$year2));

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(re_date) AS date_count   FROM refund_exchange  WHERE (re_date BETWEEN '$start' AND '$end')");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($date_count);
$stmt->fetch();

$this->resultCount = $date_count;
$_SESSION['account_search_sql'] = "(re_date BETWEEN '$start' AND '$end')";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function getResultCount() {
          return($this->resultCount);
          }
        

 }//end of class
 
$cat = $_REQUEST['cat'];
$invoice = $_REQUEST['invoice'];
$barcode = $_REQUEST['barcode'];
$date = $_REQUEST['date'];
$sid = $_REQUEST['sid'];
$range1 = $_REQUEST['range1'];
$range2 = $_REQUEST['range2'];

$cat = urldecode($cat);
$cat = trim($cat);
$invoice = urldecode($invoice);
$invoice = trim($invoice);
$barcode = urldecode($barcode);   
$barcode = trim($barcode);
$date = urldecode($date);   
$date = trim($date);
$range1 = urldecode($range1);   
$range1 = trim($range1);
$range2 = urldecode($range2);   
$range2 = trim($range2);
 
 //echo "fu $invoice bar ";
 //exit;  
$searchMember = new searchPosSales();

if($cat != "" &&  $invoice == "" &&  $barcode == "") {
   $searchMember-> setCategory($cat);  
   $searchMember-> loadCatCount();
  }

if($invoice != "" && $cat == "" &&  $barcode == "") {
   $searchMember-> setInvoice($invoice);
   $searchMember-> loadInvoiceCount();
  }

if($invoice == "" && $cat == "" &&  $barcode != "")  {
    $searchMember-> setBarcode($barcode);
    $searchMember-> loadBarcodeCount();
  }
  
if($date != "")  {
   $searchMember-> setDate($date);
   $searchMember-> loadDateCount();
}

if($range1 != "" AND $range2 != "")  {
   $searchMember-> setStartRange($range1);
   $searchMember-> setEndRange($range2);
   $searchMember-> loadRangeCount();
}


$result_count = $searchMember-> getResultCount();

//check to see if this is coming from an ajax call. if not do it sever side
if($sid != "")  {
   echo"$result_count";
   exit;
   }  
?>