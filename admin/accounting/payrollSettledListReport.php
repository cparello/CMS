<?php
session_start();



//===============================================================================

class generatePayrollReport {
    
private $counter = 0;
private $month = null;
private $barcode = null;

function setStart($start){
    $this->start = $start;
}
function setEnd($end){
    $this->end = $end;
}

//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->employeeName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->payment_cycle</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->comp_type</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->total_hours</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->commission_amount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->commission_returned</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->base_payment_amount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->overtime</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->ot_hours_tier_2</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->total_payment_amount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->payment_date</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->close_date</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clubName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->pt_sessions_performed</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->pt_pay_total</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->pt_performance_bonus</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->training_on_the_clock</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->assesments_performed</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->assesment_pay_total</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->assesments_off_clock_hours</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->sales_bonus</b></font>
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

<title>Payroll Settled Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6"><strong>Payroll Settled Report for From: &nbsp; $this->start TO: &nbsp; $this->end</strong></span>
</div>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">#</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Employee Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Payment Cycle</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Compensation Type</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Total Hours</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Commission Amount</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Commission Returned</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Base Payment Amount</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Overtime</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Overtime Time and a Half</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Total Payment Amount</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Payment Date</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Close Date</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Club Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">PT Sessions Performed</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">PT Pay</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">PT Performance Bonus</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Training On Clock</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Assesment Performed</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Assesment Pay</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Assesments Off Clock</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Sales Bonus</font></th>
</tr>

REPORTHEADER;

echo"$reportHeader";

$this->generatePayrollSettledList();


echo"</table>\n</div>";


}
//----------------------------------
//===============================================================================================
function generatePayrollSettledList(){
    $dbMain = $this->dbconnect();
    
    
    $start = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($this->start)),date('d',strtotime($this->start)),date('Y',strtotime($this->start))));
    $end = date('Y-m-d H:i:s',mktime(23,59,59,date('m',strtotime($this->end)),date('d',strtotime($this->end)),date('Y',strtotime($this->end))));
    
    $stmt3 = $dbMain->prepare("SELECT user_id, payment_cycle, comp_type, total_hours, commission_amount, base_payment_amount, ot_hours_tier_2, overtime, total_payment_amount, payment_date, close_date, club_id, pt_sessions_performed, pt_pay_total, pt_performance_bonus, training_on_the_clock, assesments_performed, assesment_pay_total, assesments_off_clock_hours, commission_returned, sales_bonus  FROM payroll_settled WHERE (close_date BETWEEN  '$start' AND '$end')");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($user_id, $this->payment_cycle, $this->comp_type, $this->total_hours, $this->commission_amount, $this->base_payment_amount, $this->ot_hours_tier_2, $this->overtime, $this->total_payment_amount, $this->payment_date, $this->close_date, $this->club_id, $this->pt_sessions_performed, $this->pt_pay_total, $this->pt_performance_bonus, $this->training_on_the_clock, $this->assesments_performed, $this->assesment_pay_total, $this->assesments_off_clock_hours,  $this->commission_returned, $this->sales_bonus);
    while($stmt3->fetch()){
        $this->payment_date = date('F j Y', strtotime($this->payment_date));
        $this->close_date = date('F j Y', strtotime($this->close_date));
        
        $stmt = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->club_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->clubName);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT emp_fname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($first_name, $last_name);
        $stmt->fetch();
        $stmt->close();
        
        switch ($this->payment_cycle){
            case 'D':
                $this->payment_cycle = 'Daily';
            break;
            case 'W':
             $this->payment_cycle = 'Weekly';
            break;
            case 'M':
             $this->payment_cycle = 'Monthly';
            break;
            case 'B':
             $this->payment_cycle = 'Bi-Monthly';
            break;
        }
        
        switch ($this->comp_type){
            case 'S':
                $this->comp_type = 'Salary';
            break;
            case 'H':
             $this->comp_type = 'Hourly';
            break;
            case 'C':
             $this->comp_type = 'Commission';
            break;
            case 'SC':
             $this->comp_type = 'Salary/Commission';
            break;
            case 'HC':
             $this->comp_type = 'Hourly/Commission';
            break;
        }
        
        $first_name = trim($first_name);
        $first_name = strtolower($first_name);
        $first_name = ucfirst($first_name);
                                
        $last_name = trim($last_name);
        $last_name = strtolower($last_name);
        $last_name = ucfirst($last_name);
        
        $this->employeeName = "$first_name $last_name";
        
        $this->parseTableRow();
    }
    $stmt3->close();
    
}
//==============================================================================================


}

$start = $_SESSION['start'];
$end = $_SESSION['end'];

//echo "tttt $emailBool";
//exit;
unset($_SESSION['start']);
unset($_SESSION['end']);
//echo "$start $end";
//exit;
$csUpdate = new generatePayrollReport();
//$month = 'January';
//$barcode = '127985';
$csUpdate-> setStart($start);
$csUpdate-> setEnd($end);
$csUpdate->loadListings();




?>