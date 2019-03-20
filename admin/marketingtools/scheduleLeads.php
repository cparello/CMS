<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//error_reporting(E_ALL);
class ptStatsAndSales{

private $contractKey = null;
private $barCode = null;
private $firstName = null;
private $midName = null;
private $lastName = null;
private $phone = null;
private $email = null;
private $street = null;
private $color = null;

function setUserId($user_id){
    $this->userId = $user_id;
}
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

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id='$this->userId' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($emp_fname, $emp_mname, $emp_lname);
$stmt->fetch();  
$stmt->close(); 

$emp_fname = trim($emp_fname);
$emp_fname = strtolower($emp_fname);
$emp_fname = ucfirst($emp_fname);

$emp_mname = trim($emp_mname);
$emp_mname = strtolower($emp_mname);
$emp_mname = ucfirst($emp_mname);

$emp_lname = trim($emp_lname);
$emp_lname = strtolower($emp_lname);
$emp_lname = ucfirst($emp_lname);

$name = "$emp_fname $emp_mname $emp_lname";
$this->name = $name;

$counter = 1;
$html = "<tr>
    </tr>
<div id=\"reportName\"> 
<span class=\"black5\">Name of Sales Person:</span>
&nbsp;
<span class=\"black6\"><strong>$this->name &nbsp &nbsp Appointment's that were not Closed</strong></span>
</div>


<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lead's Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lead's Phone #</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Note</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date</font></th>
</tr>";


$stmt999 = $dbMain ->prepare("SELECT appointment_id, user_id, first_name, last_name, phone, notes, appointment_date_time FROM sales_appointments WHERE  user_id ='$this->userId' AND (appointment_date_time BETWEEN '$this->rangeStart' AND '$this->rangeEnd') ORDER BY appointment_date_time DESC");
             $stmt999->execute();      
             $stmt999->store_result();      
             $stmt999->bind_result($appointment_id, $user_id, $first_name, $last_name, $phone, $notes, $appointment_date_time);         
             $rowCount = $stmt999->num_rows;
             $this->numAppointments = $rowCount;
           
             //echo "<br>rc $rowCount $this->rangeStart' AND '$this->rangeEnd $instructor_id<br>";
       //if($rowCount != 0)  {
           
                    while ($stmt999->fetch()) {  
                        
                            $formattedDate = date('F j Y', strtotime($appointment_date_time));
                            
                            
                           $contract_key = '';
                               $stmt = $dbMain ->prepare("SELECT contract_key, count(*) as count FROM contract_info WHERE contract_date >= '$appointment_date_time' AND (primary_phone = '$phone' OR cell_phone = '$phone') AND first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%'");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($contract_key, $count);
                            $stmt->fetch();  
                            $stmt->close();
                            
                            if (($contract_key != '0' AND $contract_key != '') AND $count >= 1){
                                
                            }else{
                                 $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name $last_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font>
                                        </td>  
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$notes</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$formattedDate</b></font>
                                        </td>\n";
                                         $counter++;
                            }
                            
                           
                               
                    
                     }
                             if ($rowCount == 0){
                                        $html .= "<tr>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"3\" color=\"black\"><b>No Appointments</b></font>
                                        </td>\n";
                            }
                          
           $this->salesFromAppts = $salesFromAppts;
           $this->apptHtml = "$html</table>\n</div><br><br>";
        /* }else{
           $this->apptHtml = "";
         }*/
         
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

echo $finalHtml;
//exit;
}
//==============================================================================================
function moveData(){
  


$this->loadSalesApptData();

$this->formatPayrollRecord();

//echo "Done!";
}
//===============================================

}
$user_id = $_REQUEST['user_id'];
$rangeStart = $_REQUEST['datepicker1'];
$rangeEnd  = $_REQUEST['datepicker2'];

$rangeStart = "$rangeStart 00:00:00";
$rangeStart = date('Y-m-d H:i:s', strtotime($rangeStart));
$rangeEnd = "$rangeEnd 23:59:59";
$rangeEnd = date('Y-m-d H:i:s', strtotime($rangeEnd));

//echo "$user_id $rangeStart $rangeEnd";
$report = new ptStatsAndSales();
$report-> setUserId($user_id);
$report-> setRangeStart($rangeStart);
$report->setRangeEnd($rangeEnd);
$report->moveData();










?>