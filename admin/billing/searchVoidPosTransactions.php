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
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
 



//=================================================== 
function  loadInvoiceCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(item_marker) AS marker_count  FROM merchant_sales WHERE  purchase_marker = '$this->invoice'");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($marker_count);
$stmt->fetch();

//echo "fubar $marker_count";
//exit;

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
function getResultCount() {
          return($this->resultCount);
          }
        

 }//end of class
 

$invoice = $_REQUEST['invoice'];
$sid = $_REQUEST['sid'];


$invoice = urldecode($invoice);
$invoice = trim($invoice);

 
 //echo "fu $invoice bar ";
 //exit;  
$searchMember = new searchPosSales();



if($invoice != "") {
   $searchMember-> setInvoice($invoice);
   $searchMember-> loadInvoiceCount();
  }




$result_count = $searchMember-> getResultCount();

//check to see if this is coming from an ajax call. if not do it sever side
if($sid != "")  {
   echo"$result_count";
   exit;
   }  
?>