<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//error_reporting(E_ALL);
class scheduleApptStats{

private $contractKey = null;
private $barCode = null;
private $firstName = null;
private $midName = null;
private $lastName = null;
private $phone = null;
private $email = null;
private $street = null;
private $color = null;

function setRangeStart($rangeStart){
    $this->rangeStart = $rangeStart;
}
function setRangeEnd($rangeEnd){
    $this->rangeEnd = $rangeEnd;
}   
  
//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}
//============================================================================================================
function loadSalesApptData() {
    $salesFromAppts = 0;
$training_on_clock_hours = 0;
//echo"################# kaskljklasjjsdjaskdjkl";
$dbMain = $this->dbconnect();

$counterUID = 1;
$stmt = $dbMain ->prepare("SELECT DISTINCT user_id FROM employee_type JOIN basic_compensation ON basic_compensation.type_key = employee_type.type_key WHERE employee_type LIKE '%sale%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_id); 
while($stmt->fetch()){
    $arrayUserID[$counterUID] = $user_id;
   $counterUID++;
}
$stmt->close();

$counterUID = 1;
foreach($arrayUserID as $userId){
        $stmt = $dbMain ->prepare("SELECT emp_fname, emp_lname FROM employee_info  WHERE user_id = '$userId'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($emp_fname, $emp_lname); 
        $stmt->fetch();
        $stmt->close();
        
        $emp_fname = strtolower($emp_fname);
        $emp_fname = ucfirst($emp_fname);
        $emp_lname = strtolower($emp_lname);
        $emp_lname = ucfirst($emp_lname);
        
        $name = "$emp_fname $emp_lname";
        if (strlen($name)>17){
            $lNameTrim = substr($emp_lname,0,1);
            $name = "$emp_fname $lNameTrim.";
        }
        $arrayUserNames[$counterUID] = $name;
        $counterUID++;
}
$counter = 1;

$countNew = 1;
$html = "<tr>
    </tr>
<div id=\"reportName\"> 
<span class=\"black5\">Sales Appointment Report:</span>
&nbsp;
<span class=\"black6\"><strong>&nbsp &nbsp </strong></span>
</div>

<div id=\"listings\">
<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"></font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">&nbsp;&nbsp;&nbsp;&nbsp;</font></th>";

foreach($arrayUserID as $id){
    $html .= "<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">$arrayUserNames[$countNew]</font></th>";
    
  $countNew++;  
}

$html .= "</tr>";

$interval = strtotime($this->rangeEnd)-strtotime($this->rangeStart);
$days = round($interval/86400);

$counterUID = 1;
for($z=0;$z<=$days;$z++){
     $start = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($this->rangeStart)),date('d',strtotime($this->rangeStart))+$z,date('Y',strtotime($this->rangeStart))));
        $end = date('Y-m-d H:i:s',mktime(23,59,59,date('m',strtotime($this->rangeStart)),date('d',strtotime($this->rangeStart))+$z,date('Y',strtotime($this->rangeStart))));
        
        $date = date('D F j Y',strtotime($start));
    $html .= "<tr>
            <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
            <font face=\"Arial\" size=\"1\" color=\"black\"></font>
            </td>";
            
            
            
  foreach($arrayUserID AS $id){
   
        
       
        
        $stmt999 = $dbMain ->prepare("SELECT COUNT(*) as count FROM sales_appointments WHERE  user_id ='$id' AND (appointment_date_time BETWEEN '$start' AND '$end') ORDER BY appointment_date_time DESC");
        $stmt999->execute();      
        $stmt999->store_result();      
        $stmt999->bind_result($count);         
        $this->numAppointments = $rowCount;
        $stmt999->fetch();
                 
        $apptCountArray[$id] = $this->numAppointments;
        
          $html .= "<td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
            </td>\n";
        $counterUID++;
    }
    $html .= "</tr>";
    }

    $this->apptHtml = "$html</table>\n</div><br><br>";
    
}
//===========================================================================================================
function formatPayrollRecord()  {
$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
 <link rel=\"stylesheet\" href=\"../css/printReport.css\">
 <script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />
  </head>
  <div id=\"logoDiv\">
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/contract_logo.png\"  /></a>
</div>
  ";

$finalHtml = "$message$this->apptHtml</html>";
//echo "dddfuck you";
echo $finalHtml;
//exit;
}
//==============================================================================================
function moveData(){
  
//echo "test   Done!";

$this->loadSalesApptData();
$this->formatPayrollRecord();

//echo "Done!";
}
//===============================================

}
$rangeStart = $_REQUEST['datepicker1'];
$rangeEnd  = $_REQUEST['datepicker2'];

$rangeStart = "$rangeStart 00:00:00";
$rangeStart = date('Y-m-d H:i:s', strtotime($rangeStart));
$rangeEnd = "$rangeEnd 23:59:59";
$rangeEnd = date('Y-m-d H:i:s', strtotime($rangeEnd));

//echo "$user_id $rangeStart $rangeEnd";
$report = new scheduleApptStats();
$report-> setRangeStart($rangeStart);
$report-> setRangeEnd($rangeEnd);
$report->moveData();










?>