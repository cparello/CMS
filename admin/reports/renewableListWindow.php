<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class renewableListWindow {

private  $renewType = null;
private  $seviceLocation = null;
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
private  $renewRate = null;
private  $serviceName = null;
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


function setRenewType($renewType) {
        $this->renewType = $renewType;
         }

function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
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
function loadDateRange()  {

if($this->rangeCycle != null) {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT $this->rangeCycle FROM fees WHERE fee_num='1' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($rangeCycle);   
  $stmt->fetch();


  if($this->renewType == 'ER') {
     $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d'),date('Y')));
     $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d')+$rangeCycle,date('Y')));
    }

   if($this->renewType == 'GP') {
     $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d')-$rangeCycle,date('Y')));
     $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d'),date('Y')));
    }  


  }else{
  
  //takes care of standard renewal. the default is 30 days
  $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d'),date('Y')));
  $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d')+30,date('Y')));
  }

}
//------------------------------------------------------------------------------------------
function loadSqlStatements() {

switch($this->renewType) {
        case "ER":         

         $this->sqlTable1 = "paid_full_services";
         $this->selectSql1 = "group_renew_rate, contract_key, service_name";
         
         $this->rangeCycle = "early_renewal_grace";
         $this->loadDateRange();         
         
         if($this->serviceLocation == "0") {
             $this->searchSql1 = "club_id IS NOT NULL AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }elseif($this->serviceLocation == "1") {
             $this->searchSql1 = "club_id = '0' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }else{            
            $this->searchSql1 = "club_id = '$this->serviceLocation' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }         
          

        break;
        case "GP":
                
         $this->sqlTable1 = "paid_full_services";
         $this->selectSql1 = "group_renew_rate, contract_key, service_name";     
                
         $this->rangeCycle = "standard_renewal_grace";
         $this->loadDateRange();                
                
         if($this->serviceLocation == "0") {
             $this->searchSql1 = "club_id IS NOT NULL AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }elseif($this->serviceLocation == "1") {
             $this->searchSql1 = "club_id = '0' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }else{            
            $this->searchSql1 = "club_id = '$this->serviceLocation' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }                
                
                 
        break;
        case "SR":
        
         $this->sqlTable1 = "paid_full_services";
         $this->selectSql1 = "group_renew_rate, contract_key, service_name";     
                
         $this->rangeCycle = null;
         $this->loadDateRange();                
                
         if($this->serviceLocation == "0") {
             $this->searchSql1 = "club_id IS NOT NULL AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }elseif($this->serviceLocation == "1") {
             $this->searchSql1 = "club_id = '0' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }else{            
            $this->searchSql1 = "club_id = '$this->serviceLocation' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }   


        break;
        case "EA":
        
         $this->sqlTable1 = "paid_full_services";
         $this->selectSql1 = "group_renew_rate, contract_key, service_name";                   
                
         if($this->serviceLocation == "0") {
             $this->searchSql1 = "club_id IS NOT NULL AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }elseif($this->serviceLocation == "1") {
             $this->searchSql1 = "club_id = '0' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
            }else{            
            $this->searchSql1 = "club_id = '$this->serviceLocation' AND end_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY end_date DESC";
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
function parseListOne() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql1 FROM $this->sqlTable1 WHERE $this->searchSql1 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($renewRate, $contractKey, $serviceName);

while ($stmt->fetch()) {

           $this->renewRate = $renewRate;
           $this->contractKey = $contractKey;
           $this->serviceName = $serviceName;
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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->renewRate</b></font>
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
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Service Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Amount Due</font></th>
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
$from_date = $_SESSION['from_date'];
$to_date = $_SESSION['to_date'];
$renew_type = $_SESSION['renew_type'];
$service_location = $_SESSION['service_location'];


unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['renew_type']);
unset($_SESSION['service_location']);


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
     //$end_date = date("Y-m-d H:i:s");
      $end_date = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d'),date('Y')));
     }   
          

    $listings = new renewableListWindow();
    $listings-> setRenewType($renew_type);    
    $listings-> setServiceLocation($service_location);
    $listings-> setReportType($report_type);
    $listings-> setReportName($report_name);
    $listings-> setFromDate($start_date);
    $listings-> setToDate($end_date);
    $listings-> loadSqlStatements();
    $listings-> loadBusinessInfo();
    $listings-> loadListings();







//--------------------------------------------------------------------------------

?>























