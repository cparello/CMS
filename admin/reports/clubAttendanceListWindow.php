<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class clubAttendanceListWindow {

private  $attendanceType = null;
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
private  $serviceName = null;
private  $contractKey = null;
private  $memberId = null;
private  $accessFlag = null;
private  $attendanceDate = null;
private  $memberName = null;
private  $primaryPhone = null;
private  $emailAddress = null;
private  $memberAddress = null;
private  $sqlTable1 = null;
private  $searchSql1 = null;
private  $selectSql1 = null;
private  $counter = 1;


function setAttendanceType($attendanceType) {
        $this->attendanceType = $attendanceType;
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
function loadSqlStatements() {

switch($this->attendanceType) {
        case "AA":         

         $this->sqlTable1 = "attendance_records";
         $this->selectSql1 = "member_id, access_flag, attendance_date, attendance_type";
         
          
         if($this->serviceLocation == "0") {
            $this->searchSql1 = "location_id IS NOT NULL  AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }else{            
            $this->searchSql1 = "location_id = '$this->serviceLocation' AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }         
 
        break;
        case "SA":
                
         $this->sqlTable1 = "attendance_records";
         $this->selectSql1 = "member_id, access_flag, attendance_date, attendance_type";
         
          
         if($this->serviceLocation == "0") {
            $this->searchSql1 = "location_id IS NOT NULL  AND attendance_type='SA' AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }else{            
            $this->searchSql1 = "location_id = '$this->serviceLocation' AND attendance_type='SA'  AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }                       
                
                 
        break;
        case "MA":
        
         $this->sqlTable1 = "attendance_records";
         $this->selectSql1 = "member_id, access_flag, attendance_date, attendance_type";
         
          
         if($this->serviceLocation == "0") {
            $this->searchSql1 = "location_id IS NOT NULL  AND attendance_type='MA' AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }else{            
            $this->searchSql1 = "location_id = '$this->serviceLocation' AND attendance_type='MA'  AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }     


        break;
        case "GP":
        
         $this->sqlTable1 = "attendance_records";
         $this->selectSql1 = "member_id, access_flag, attendance_date, attendance_type";
         
          
         if($this->serviceLocation == "0") {
            $this->searchSql1 = "location_id IS NOT NULL  AND attendance_type='GP' AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
            }else{            
            $this->searchSql1 = "location_id = '$this->serviceLocation' AND attendance_type='GP'  AND attendance_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY attendance_date DESC";
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

switch($this->attendanceType) {
        case "SA":   
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, email, street, city, state, zip FROM member_info WHERE member_id = '$this->memberId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_name, $middle_name, $last_name, $primary_phone, $email, $street, $city, $state, $zip);
        $stmt->fetch();
        $stmt->close();
        $this->memberName = "$first_name $middle_name $last_name";
        $this->primaryPhone = $primary_phone;
        $this->memberAddress = "$street $city $state $zip";
        $this->emailAddress = $email;

        break;
        case "MA":        
        
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, email, street, city, state, zip FROM member_info WHERE member_id = '$this->memberId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_name, $middle_name, $last_name, $primary_phone, $email, $street, $city, $state, $zip);
        $stmt->fetch();
        $stmt->close();
        $this->memberName = "$first_name $middle_name $last_name";
        $this->primaryPhone = $primary_phone;
        $this->memberAddress = "$street $city $state $zip";
        $this->emailAddress = $email;
        
        break;
        case "GP":
        
        $stmt = $dbMain ->prepare("SELECT guest_name, guest_phone, guest_email FROM guest_register WHERE bar_code = '$this->memberId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($guestName, $guestPhone, $guestEmail);
        $stmt->fetch();  
        $stmt->close();
        $this->memberName = $guestName;
        $this->primaryPhone = $guestPhone;
        $this->memberAddress = "GUEST PASS";
        $this->emailAddress = $guestEmail;
                
        break;
      }
        

$stmt->close();

}
//-----------------------------------------------------------------------------------------
function parseListOne() {


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql1 FROM $this->sqlTable1 WHERE $this->searchSql1 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($memberId, $accessFlag, $attendanceDate, $attendanceType);

while ($stmt->fetch()) {

           $this->memberId = $memberId;
           $this->accessFlag = $accessFlag;
           $this->attendanceDate = $attendanceDate;
           $this->attendanceType = $attendanceType;
           $this->loadContactInfo();
           $this->parseTableRow();

         }
         
$stmt->close();
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

$attendanceDateSecs = strtotime($this->attendanceDate);
$attendanceDate = date("M j, Y g:i A" ,$attendanceDateSecs); 


if($this->accessFlag == "Y") {
  $this->color = "#FF3300";
  }else{
   $this->color = "#FFFFFF";
  }


 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberId</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberName</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberAddress</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->primaryPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"mailto:$this->emailAddress\">$this->emailAddress</a></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$attendanceDate</b></font>
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

<title>Club Access Listings</title>

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
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Member ID</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Member Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Member Address</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Primary Phone</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Email Address</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Attendance Date</font></th>
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
$attendance_type = $_SESSION['attendance_type'];
$service_location = $_SESSION['service_location'];


unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['attendance_type']);
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
          

    $listings = new clubAttendanceListWindow();
    $listings-> setAttendanceType($attendance_type);    
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























