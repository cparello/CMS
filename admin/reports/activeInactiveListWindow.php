<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class activeInactiveListWindow {

private  $categoryType = null;
private  $seviceLocation = null;
private  $dateRange = null;
private  $fromDate = null;
private  $endDate = null;
private  $reportName = null;
private  $reportType = null;
private  $businessNick = null;
private  $businessStreet = null;
private  $businessCity = null;
private  $businessState = null;
private  $businessZip = null;
private  $businessPhone = null;
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
private  $searchSql1 = null;
private  $selectSql1 = null;
private  $rangeCycle =null;
private  $counter = 1;


function setCategoryType($categoryType) {
        $this->categoryType = $categoryType;
         }
         
function setDateRange($dateRange) {
        $this->dateRange = $dateRange;
         }
         

function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
         }

function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
         }
         
function setEndDate($endDate) {
        $this->endDate = $endDate;
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
function loadMinStartDate() {

$dbMain = $this->dbconnect();
 
   $stmt = $dbMain ->prepare("SELECT MIN(signup_date) AS min1 FROM paid_full_services WHERE club_id != '' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($min1);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT MIN(signup_date) AS min2 FROM monthly_services WHERE club_id != '' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($min2);
   $stmt->fetch();
   $stmt->close();

   $minString1 = strtotime($min1);
   $minString2 = strtotime($min2);
   
   if($minString1 == $minString2) {
      $this->fromDate = $min1;  
      }elseif($minString1 < $minString2) {
      $this->fromDate = $min1;
      }else{
      $this->fromDate = $min2;
      }
      

}
//------------------------------------------------------------------------------------------
function loadSqlStatements() {

if($this->dateRange == "AY") {
  $this->loadMinStartDate();
  }

         $this->sqlTable = "paid_full_services";  
         $this->sqlTableTwo = "monthly_services";
         
         if($this->serviceLocation == "0") {
            $this->searchSql = "club_id IS NOT NULL ";
            $this->searchSqlTwo = "club_id IS NOT NULL ";
            }else{            
            $this->searchSql = "club_id = '$this->serviceLocation' ";
            $this->searchSqlTwo = "club_id = '$this->serviceLocation' ";
            }
            
            $this->sumTotal = "group_renew_rate";
            $this->sumTotalTwo = "group_renew_rate";                               

            $this->groupDateStart = "signup_date";
            $this->groupDateEnd = "end_date";
            $this->groupDateStartTwo = "signup_date";
            
            $this->countField = "service_id";
            $this->countFieldTwo = "service_id";


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
$stmt = $dbMain ->prepare("SELECT  first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
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
function checkCancelStatus() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT account_status  FROM account_status WHERE contract_key= '$this->contractKey'");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($status);         
  $stmt->fetch();
  $stmt->close();

  $this->cancelStatus = $status;

}
//-----------------------------------------------------------------------------------------
function parseListOne() {

$dbMain = $this->dbconnect();

if($this->categoryType == 'AA') {

   //pif records
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateEnd > '$this->endDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contractKey1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
           $this->contractKey = $contractKey1;
           $this->checkCancelStatus();
              if($this->cancelStatus != "CA") {
                $this->loadContactInfo();
                $this->parseTableRow();
                }
            }     
                      
   $stmt->close(); 
   
   
   //monthly records
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM $this->sqlTableTwo WHERE $this->searchSqlTwo ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contractKey2);
   $numRows2 = $stmt->num_rows;

   while($stmt->fetch()) {
           $this->contractKey = $contractKey2;
           $this->checkCancelStatus();
              if($this->cancelStatus != "CA") {
                $this->loadContactInfo();
                $this->parseTableRow();
                }                      
           }
        
    $stmt->close(); 
                   
 }
      
//this is for inactive accounts=======================      
if($this->categoryType == 'IA') {   

   //pif records
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateEnd <= '$this->endDate' AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->endDate'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contractKey1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
           $this->contractKey = $contractKey1;
           $this->loadContactInfo();
           $this->parseTableRow();             
            }     
                      
   $stmt->close();       
 
   //monthly records
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM $this->sqlTableTwo WHERE $this->searchSqlTwo ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contractKey2);
   $numRows2 = $stmt->num_rows;

   while($stmt->fetch()) {
           $this->contractKey = $contractKey2;
           $this->checkCancelStatus();
              if($this->cancelStatus == "CA") {
                $this->loadContactInfo();
                $this->parseTableRow();
                }                      
           }
        
    $stmt->close();  
 
 
      
  }
  
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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clientStreet $this->clientCity $this->clientState $this->clientZip</b></font>
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
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Address</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">H Phone</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">C Phone</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Email Address</font></th>


</tr>

REPORTHEADER;

echo"$reportHeader";

$this->parseListOne();

echo"</table>\n</div>";


}
//------------------------------------------------------------------------------------------


}
//====================================================
$report_name = $_SESSION['report_name'];
$report_type = $_SESSION['report_type'];
$date_range = $_SESSION['date_range'];
$category_type = $_SESSION['category_type'];
$service_location = $_SESSION['service_location'];


unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['date_range']);
unset($_SESSION['category_type']);
unset($_SESSION['service_location']);

   if($date_range == "CY") {
      $start_date = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
      }else{
      $start_date = null;
      }
      
      $end_date = date("Y-m-d H:i:s");
          

    $listings = new activeInactiveListWindow();
    $listings-> setCategoryType($category_type);   
    $listings-> setDateRange($date_range);
    $listings-> setServiceLocation($service_location);
    $listings-> setReportType($report_type);
    $listings-> setReportName($report_name);
    $listings-> setFromDate($start_date);
    $listings-> setEndDate($end_date);
    $listings-> loadSqlStatements();
    $listings-> loadBusinessInfo();
    $listings-> loadListings();







//--------------------------------------------------------------------------------

?>























