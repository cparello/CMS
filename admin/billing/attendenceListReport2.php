<?php
session_start();
//===============================================================================

class generateAttendenceReport {
    
private $counter = 0;
private $month = null;
private $barcode = null;

function setMonth($month){
    $this->month = $month;
}
function setYear($year){
    $this->year = $year;
}
function setContractKey($contractKey){
    $this->contractKey = $contractKey;
}  
function setEmailBool($emailBool) {
    $this->emailBool = $emailBool;
}               
//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=========================================================================================
function generateDates(){
    
     //echo "$this->month $this->year $this->monthStart $this->monthEnd";
    switch($this->month){
        case '01':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,1,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,1,31,$this->year));
        break;
        case '02':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,2,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,2,28,$this->year));
        break;
        case '03':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,3,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,3,31,$this->year));
        break;
        case '04':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,4,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,4,30,$this->year));
        break;
        case '05':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,5,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,5,31,$this->year));
        break;
        case '06':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,6,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,6,30,$this->year));
        break;
        case '07':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,7,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,7,31,$this->year));
        break;
        case '08':
             //echo "$this->month $this->year $this->monthStart $this->monthEnd<br>";
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,8,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,8,31,$this->year));
             // echo "$this->month $this->year $this->monthStart $this->monthEnd";
             
        break;
        case '09':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,9,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,9,30,$this->year));
        break;
        case '10':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,10,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,10,31,$this->year));
        break;
        case '11':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,11,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,11,30,$this->year));
        break;
        case '12':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,12,1,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,12,31,$this->year));
              // echo "test2";
        break;
    }
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clubName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->attendanceDate</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->accesFlag</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->attendanceType</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->checkinType</b></font>
</td>
</tr>\n";

$this->html .= "<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clubName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->attendanceDate</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->accesFlag</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->attendanceType</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->checkinType</b></font>
</td>
</tr>";

$this->counter++;


}
//------------------------------------------------------------------------------------------
function loadListings() {
    
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE member_id = '$this->barcode'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($this->firstName, $this->lastName);
    $stmt->fetch();
    $stmt->close();

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Attendence Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>

<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6"><strong>Attendance Report for $this->firstName $this->lastName -------- Month: $this->month Year: $this->year</strong></span>
</div>

<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">#</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Club Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Date</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Access Flag</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Attendance Type</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Checkin Type</font></th>
</tr>

REPORTHEADER;

echo"$reportHeader";
$this->html = $reportHeader;
$this->generateAttendanceList();
$this->html .= "</table>\n</div>";

if ($this->emailBool == 1){
 $dbMain = $this->dbconnect();
 
 $stmt3 = $dbMain->prepare("SELECT email FROM member_info WHERE member_id = '$this->barcode'");
 $stmt3->execute();
 $stmt3->store_result();
 $stmt3->bind_result($email);
 $stmt3->fetch();
 $stmt3->close();
 
 $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result(  $business_name, $business_nick); 
 $stmt->fetch();
 $stmt->close();
 //echo "test";
 $headers  = "From: $business_name@$business_nick.com\r\n";
 $headers .= "Content-type: text/html\r\n"; 
    $message = wordwrap($this->html, 70, "\r\n");
    mail($email, 'Attendance Report', $this->html, $headers);   
}

echo"</table>\n</div>";


}
//----------------------------------
//===============================================================================================
function generateAttendanceList(){
    $dbMain = $this->dbconnect();
   
   // echo "$this->barcode $this->monthStart $this->monthEnd";
    
    $stmt3 = $dbMain->prepare("SELECT location_id, attendance_date, access_flag, attendance_type, check_in_type FROM attendance_records WHERE member_id = '$this->barcode' AND (attendance_date BETWEEN '$this->monthStart' AND '$this->monthEnd')");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($this->locationId, $this->attendanceDate, $this->accesFlag, $this->attendanceType, $this->checkinType );
      while($stmt3->fetch()){
        switch($this->checkinType){
            case 'BC':
             $this->checkinType = 'Barcode';
            break;
            case 'MA':
             $this->checkinType = 'Manual';
            break;
        }
        $this->attendanceDate = date('F j Y g:h:s A', strtotime($this->attendanceDate));
        
        $stmt = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->locationId'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->clubName);
        $stmt->fetch();
        $stmt->close();
        
        $this->parseTableRow();
    }
    $stmt3->close();
    
}
//==============================================================================================
function moveData(){
  
   $dbMain = $this->dbconnect();
   
   $stmt = $dbMain->prepare("SELECT member_id FROM member_info WHERE contract_key = '$this->contractKey'");
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($this->barcode);
   $stmt->fetch();
   $stmt->close();
  // $this->month = 'January';
  //$this->barCode = '120785';
  
   $this->generateDates();
   $this->loadListings();
  
}
//===============================================
}

$contractKey = $_SESSION['contractKey'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];
$emailBool = $_SESSION['emailBool'];

//echo "$month $year";

unset($_SESSION['year']);
unset($_SESSION['month']);
unset($_SESSION['contractKey']);
unset($_SESSION['emailBool']);
//echo "$month $barCode";
$csUpdate = new generateAttendenceReport();

$csUpdate-> setMonth($month);
$csUpdate-> setYear($year);
$csUpdate-> setContractKey($contractKey);
$csUpdate-> setEmailBool($emailBool);
$csUpdate->moveData();




?>