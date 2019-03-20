<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class payrollListWindow {

private  $seviceLocation = null;
private  $paymentCycle = null;
private  $compensationType = null;
private  $employeeType = null;
private  $overtimeType = null;
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

private  $userId = null;
private  $typeKey = null; 
private  $consolidate = null;
private  $totalHours = null;
private  $overtime = null; 
private  $otHoursTier2 = null;
private  $commissionAmount = null;
private  $basePaymentAmount = null;
private  $totalPaymentAmount = null; 
private  $paymentDate = null;
private  $employeeName = null;
private  $idCard = null;

private  $sqlTable1 = null;
private  $searchSql1 = null;
private  $selectSql1 = null;
private  $counter = 1;


function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
         }
         
function setPaymentCycle($paymentCycle) {
        $this->paymentCycle = $paymentCycle;
         }         
         
function setCompensationType($compensationType) {
        $this->compensationType = $compensationType;
         }        

function setEmployeeType($employeeType) {
        $this->employeeType = $employeeType;
         }     

function setOvertimeType($overtimeType) {
        $this->overtimeType = $overtimeType;
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
     

$this->sqlTable1 = "payroll_settled";
$this->selectSql1 = "user_id, type_key, consolidate, total_hours, overtime, ot_hours_tier_2, commission_amount, base_payment_amount, total_payment_amount, payment_date";
                 
          
$clubSQL = "club_id = '$this->serviceLocation' ";

if($this->paymentCycle == '0') {
  $paymentSQL = "payment_cycle !=''";
  }else{
  $paymentSQL = "payment_cycle ='$this->paymentCycle'";
  }

if($this->compensationType == '0') {
  $compSQL = "comp_type !='' ";
  }else{
  $compSQL = "comp_type ='$this->compensationType'";
  }  

if($this->employeeType == '0') {
  $empSQL = "type_key !='' ";
  }else{
  $empSQL = "type_key ='$this->employeeType'";
  }  
  
if($this->otType != "") {
      switch($this->otType) {
            case "0":
             $otSQL = " AND (ot_hours_tier_2 > '0.00' OR overtime > '0.00') ";
            break;
            case "1":
             $otSQL = " AND overtime > '0.00'";
            break;
            case "2":
             $otSQL = " AND ot_hours_tier_2 > '0.00'";
            break;
            }
  }else{
  $otSQL = "";
  }
  

$this->searchSql1 = "$clubSQL AND $paymentSQL AND $compSQL AND $empSQL $otSQL AND payment_date BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY payment_date DESC";
//echo"$this->searchSql1";
//exit;

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
function loadEmployeeInfo() {

$dbMain = $this->dbconnect();
        
        $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id = '$this->userId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_name, $middle_name, $last_name);
        $stmt->fetch();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        
    if($rowCount > 0) {          
    
        $this->employeeName = "$first_name $middle_name $last_name";
       
      }else{
          
        $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_archives WHERE user_id = '$this->userId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_name, $middle_name, $last_name);
        $stmt->fetch();
        $rowCount = $stmt->num_rows;
        $stmt->close();
          
        $this->employeeName = "$first_name $middle_name $last_name";  
      }

//get id number
        $stmt = $dbMain ->prepare("SELECT id_card FROM basic_compensation WHERE user_id = '$this->userId' AND type_key= '$this->typeKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($id_card);
        $stmt->fetch();
        $rowCount2 = $stmt->num_rows;        
        $stmt->close();
        
      if($rowCount2 > 0) {
         $this->idCard = $id_card;      
        }else{
        $this->idCard = 'NA';      
        }
        

}
//-----------------------------------------------------------------------------------------
function parseListOne() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql1 FROM $this->sqlTable1 WHERE $this->searchSql1 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($userId, $typeKey, $consolidate, $totalHours, $overtime, $otHoursTier2, $commissionAmount, $basePaymentAmount, $totalPaymentAmount, $paymentDate);

while ($stmt->fetch()) {
          
           $this->userId = $userId;
           $this->typeKey = $typeKey; 
           $this->consolidate = $consolidate;
           $this->totalHours = $totalHours;
           $this->overtime = $overtime; 
           $this->otHoursTier2 = $otHoursTier2;
           $this->commissionAmount = $commissionAmount;
           $this->basePaymentAmount = $basePaymentAmount;
           $this->totalPaymentAmount = $totalPaymentAmount; 
           $this->paymentDate = $paymentDate;           
                      
           $this->loadEmployeeInfo();
           $this->parseTableRow();

         }
         
$stmt->close();
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

$paymentDateSecs = strtotime($this->paymentDate);
$paymentDate = date("M j, Y g:i A" ,$paymentDateSecs); 


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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$paymentDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->idCard</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->employeeName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->consolidate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->totalHours</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->overtime</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->otHoursTier2</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->commissionAmount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->basePaymentAmount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->totalPaymentAmount</b></font>
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
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Date</font></th>
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Employee ID</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Employee Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Consolidate</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Hours</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">OT 1</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">OT 2</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Commision</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Base Pay</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Total</font></th>
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
$service_location = $_SESSION['service_location'];
$payment_cycle = $_SESSION['payment_cycle'];
$compensation_type = $_SESSION['compensation_type'];
$employee_type = $_SESSION['employee_type'];
$ot_type = $_SESSION['ot_type'];


unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['service_location']);
unset($_SESSION['payment_cycle']);
unset($_SESSION['compensation_type']);
unset($_SESSION['employee_type']);
unset($_SESSION['ot_type']);


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
          

    $listings = new payrollListWindow(); 
    $listings-> setServiceLocation($service_location);
    $listings-> setPaymentCycle($payment_cycle);
    $listings-> setCompensationType($compensation_type);
    $listings-> setEmployeeType($employee_type);
    $listings-> setOvertimeType($ot_type);
    $listings-> setReportType($report_type);
    $listings-> setReportName($report_name);
    $listings-> setFromDate($start_date);
    $listings-> setToDate($end_date);
    $listings-> loadSqlStatements();
    $listings-> loadBusinessInfo();
    $listings-> loadListings();







//--------------------------------------------------------------------------------

?>























