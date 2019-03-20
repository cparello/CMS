<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class collectionListWindow {

private  $collectionCategory = null;
private  $collectionType = null;
private  $fromDate = null;
private  $toDate = null;
private  $reportName = null;
private  $reportType = null;
private  $businessNick = null;
private  $businessStreet = null;
private  $businessCity = null;
private  $businessState = null;
private  $businessZip = null;
private  $businessPhone = null;
private  $amountDue = null;
private  $contractKey = null;
private  $firstName = null;
private  $middleName = null;
private  $lastName = null;
private  $primaryPhone = null;
private  $cellPhone = null;
private  $emailAddress = null;
private  $clientStreet = null;
private  $clientCity = null;
private  $clientState = null;
private  $clientZip = null;
private  $sqlTable1 = null;
private  $sqlTable2 = null;
private  $searchSql1 = null;
private  $searchSql2 = null;
private  $selectSql1 = null;
private  $selectSql2 = null;
private  $counter = 1;


function setCollectionCategory($collectionCategory) {
        $this->collectionCategory = $collectionCategory;
         }

function setCollectionType($collectionType) {
        $this->collectionType = $collectionType;
         }

function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
         }
         
function setToDate($toDate) {
        $this->toDate = $toDate;
         } 
         
function setReportType($report_type) {
        $this->reportType = $report_type;
         }       
         
function setReportName($report_name) {
        $this->reportName = $report_name;
         }                  
         
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------------------
function loadSqlStatements() {

switch($this->collectionType) {
        case "P":         

         $this->sqlTable1 = "past_due_attempts";
         $this->selectSql1 = "billing_total, contract_key";
         
         if($this->collectionCategory == "0") {
             $this->searchSql1 = "contract_key != '0' AND attempt_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attempt_date DESC";
            }else{
             $this->searchSql1 = "num_attempts = '$this->collectionCategory' AND attempt_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attempt_date DESC";
            }          

        break;
        case "D":
                
          if($this->collectionCategory == "0") {
             $this->sqlTable1 = "rejected_payments"; 
             $this->selectSql1 = "payment_amount, contract_key";
             $this->searchSql1 = "contract_key != '0' AND reject_bit != '1' AND last_attempt_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY last_attempt_date DESC";
             
             $this->sqlTable2 = "nsf_checks";
             $this->selectSql2 = "check_payment, contract_key";
             $this->searchSql2 = "contract_key != '0' AND check_bit != '1' AND nsf_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY nsf_date DESC";           
            }
            
          if($this->collectionCategory == "CC") {
             $this->sqlTable1 = "rejected_payments";
             $this->selectSql1 = "payment_amount, contract_key";
             $this->searchSql1 = "contract_key != '0' AND reject_bit != '1' AND transaction_type = 'C' AND last_attempt_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY last_attempt_date DESC";
             }
             
          if($this->collectionCategory == "AH") {
             $this->sqlTable1 = "rejected_payments"; 
             $this->selectSql1 = "payment_amount, contract_key";
             $this->searchSql1 = "contract_key != '0' AND reject_bit != '1' AND transaction_type = 'A' AND last_attempt_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY last_attempt_date DESC"; 
             }
             
          if($this->collectionCategory == "CH") {
             $this->sqlTable2 = "nsf_checks";
             $this->selectSql2 = "check_payment, contract_key";
             $this->searchSql2 = "contract_key != '0' AND check_bit != '1' AND nsf_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY nsf_date DESC";           
             }
            
            
 
        break;
        case "I":
        
        $todaysDate = date("Y-m-d H:i:s");
        $this->sqlTable1 = "initial_payments";
        $this->selectSql1 = "balance_due, contract_key";
          if($this->collectionCategory == "0") {            
            $this->searchSql1 = "club_id != '0' AND due_status = 'G' AND  due_date < '$todaysDate'  AND signup_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY signup_date DESC";                 
             }else{
            $this->searchSql1 = "club_id = '$this->collectionCategory' AND due_status = 'G' AND  due_date < '$todaysDate' AND signup_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY signup_date DESC";                 ;
            }


        break;
     }



}
//-----------------------------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_nick,  business_street, business_city, business_state, business_zip, business_phone FROM  business_info WHERE bus_id = '1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_nick,  $business_street, $business_city, $business_state, $business_zip, $business_phone);
$stmt->fetch();

$this->businessNick = $business_nick;
$this->businessStreet = $business_street;
$this->businessCity = $business_city;
$this->businessState = $business_state;
$this->businessZip = $business_zip;
$this->businessPhone = $business_phone;


}
//------------------------------------------------------------------------------------------
function loadContactInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($first_name, $middle_name, $last_name, $primary_phone, $cell_phone, $email, $street, $city, $state, $zip);
$stmt->fetch();

$this->firstName = $first_name;
$this->middleName = $middle_name;
$this->lastName = $last_name;
$this->primaryPhone = $primary_phone;
$this->cellPhone = $cell_phone;
$this->emailAddress = $email;
$this->clientStreet = $street;
$this->clientCity = $city;
$this->clientState = $state;
$this->clientZip = $zip;

$stmt->close();

}
//-----------------------------------------------------------------------------------------
function parseListTwo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql2 FROM $this->sqlTable2 WHERE $this->searchSql2 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($amountDue, $contractKey);

while ($stmt->fetch()) {

           $this->amountDue = $amountDue;
           $this->contractKey = $contractKey;
           $this->loadContactInfo();
           $this->parseTableRow();

         }
         
$stmt->close();
}
//-----------------------------------------------------------------------------------------
function parseListOne() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql1 FROM $this->sqlTable1 WHERE $this->searchSql1 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($amountDue, $contractKey);

while ($stmt->fetch()) {

           $this->amountDue = $amountDue;
           $this->contractKey = $contractKey;
           $this->loadContactInfo();
           $this->parseTableRow();

         }
         
$stmt->close();
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->primaryPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->cellPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"mailto:$this->emailAddress\">$this->emailAddress</a></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clientStreet $this->clientCity $this->clientState $this->clientZip</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->amountDue</b></font>
</td>
</tr>\n";


$this->counter++;


}
//------------------------------------------------------------------------------------------
function loadListings() {

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Retail Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="addressDiv" class="black4">
$this->businessNick
<br>
$this->businessStreet
<br>
$this->businessCity, $this->businessState $this->businessZip
<br>
$this->businessPhone  
</div>

<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6">$this->reportName</span>
</div>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">#</font></th>
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Key</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Client Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">H Phone</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">C Phone</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Email Address</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Mailing Address</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Amount Due</font></th>
</tr>

REPORTHEADER;

echo"$reportHeader";

switch($this->collectionType) {
        case "P":         
        $this->parseListOne();
        break;
        
        case "D":        
        if($this->collectionCategory == "0") {
           $this->parseListOne();
           $this->parseListTwo();
           }           
        if($this->collectionCategory == "CC") {
           $this->parseListOne();
           }
        if($this->collectionCategory == "AH") {           
           $this->parseListOne();
           }
        if($this->collectionCategory == "CH") { 
           $this->parseListTwo();
           }
        break;
        
        case "I":        
        $this->parseListOne();
        break;
               
        }

echo"</table>\n</div>";



}
//------------------------------------------------------------------------------------------


}
//====================================================
$report_name = $_SESSION['report_name'];
$report_type = $_SESSION['report_type'];
$from_date = $_SESSION['from_date'];
$to_date = $_SESSION['to_date'];
$collection_type = $_SESSION['collection_type'];
$collection_category = $_SESSION['collection_category'];


unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['collection_type']);
unset($_SESSION['collection_category']);


   $from_date = trim($from_date);
   $to_date = trim($to_date);
   
   if($from_date != "") {
      $start_date = date("Y-m-d H:i:s", strtotime($from_date));
     }else{
      $start_date = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
     }
   if($to_date != "") {
      $year = date("Y", strtotime($to_date));
      $month = date("m", strtotime($to_date));
      $day = date("d", strtotime($to_date));
      $end_date = date("Y-m-d H:i:s",mktime(23,59,59,$month,$day,$year));
     }else{
      $end_date = date("Y-m-d H:i:s");
     }   
          

    $listings = new collectionListWindow();
    $listings-> setCollectionCategory($collection_category);    
    $listings-> setCollectionType($collection_type);
    $listings-> setReportType($report_type);
    $listings-> setReportName($report_name);
    $listings-> setFromDate($start_date);
    $listings-> setToDate($end_date);
    $listings-> loadSqlStatements();
    $listings-> loadBusinessInfo();
    $listings-> loadListings();







//--------------------------------------------------------------------------------

?>























