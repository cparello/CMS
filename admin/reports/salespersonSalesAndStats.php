<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//error_reporting(E_ALL);
class statsAndSales{

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
<span class=\"black6\"><strong>$this->name &nbsp &nbsp Sales Appointment Report</strong></span>
</div>


<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lead's Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Lead's Phone #</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Note</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Closed</font></th>
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
                               $stmt = $dbMain ->prepare("SELECT contract_key, count(*) as count FROM contract_info WHERE (contract_date BETWEEN '$this->rangeStart' AND '$this->rangeEnd') AND (primary_phone = '$phone' OR cell_phone = '$phone') AND first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%'");
                            $stmt->execute();      
                            $stmt->store_result(); 
                            $stmt-> bind_result($contract_key, $count);
                            $stmt->fetch();  
                            $stmt->close();
                            
                            if (($contract_key != '0' AND $contract_key != '') AND $count >= 1){
                                $salesFromAppts++;
                                $closed = 'Yes';
                            }else{
                                $closed = 'No';
                            }
                            
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
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$closed</b></font>
                                        </td>\n";
                               
                     $counter++;
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
//==============================================================================================
function loadSalesData(){
  
$dbMain = $this->dbconnect();

$total = 0; 
$counter = 0;
 $htmlSales = "
<div id=\"listings\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\">Sales: &nbsp;&nbsp;Sales Report</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Date</font></th>
</tr>";




$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key, service_name, sale_date_time  FROM sales_info WHERE user_id = '$this->userId'  AND (sale_date_time BETWEEN '$this->rangeStart' AND '$this->rangeEnd')");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key, $service_name, $sale_date_time);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    $formattedDate = date('F j Y', strtotime($sale_date_time));
    $stmt = $dbMain ->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key' ");
    $stmt->execute();      
    $stmt->store_result(); 
    $stmt-> bind_result($first_name, $last_name);
    $stmt->fetch();  
    $stmt->close(); 
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
    $htmlSales .= "<tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name $last_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$price</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$formattedDate</b></font>
                                        </td>
                                        </tr>\n";
     }

$stmt999->close();

$htmlSales .= "</table>\n</div><br><br>";

$this->htmlSales = $htmlSales;
$this->totaleSales = $total;
$this->salesCount = $counter;


$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,1,1,date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesYTD = $total;
$this->salesCountYTD = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')-1));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesLY = $total;
$this->salesCountLY = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-30,date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesL30 = $total;
$this->salesCountL30 = $counter;

$yearStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m')-6,date('d'),date('Y')));
$total = 0; 
$counter = 0;
$stmt999 = $dbMain ->prepare("SELECT group_price, overide_group_price, overide_pin, contract_key FROM sales_info WHERE user_id = '$this->userId'  AND sale_date_time > '$yearStart'");
$stmt999->execute();      
$stmt999->store_result();      
$stmt999->bind_result($group_price, $overide_group_price, $overide_pin, $contract_key);         
$rowCount2 = $stmt999->num_rows;
           
while ($stmt999->fetch()) { 
    if ($overide_pin == 'Y'){
        $price = $overide_group_price;
    }else{
        $price = $group_price;
    }
    $total += $price;
    
    $counter++;
     }

$stmt999->close();

$this->totaleSalesL6 = $total;
$this->salesCountL6 = $counter;

}
//===============================================================================================
function makeStats(){

    $this->closingPercentage = ($this->salesFromAppts/$this->numAppointments)*100;
    
    $htmlStats = "
                <div id=\"listings\">
                <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>                
                 <tr>
                <th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#303030\">Sales Person Stats</font></th>
                </tr>               
                <tr>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># of Appt's</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Count</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Closing %</font></th>
                </tr>";

$this->closingPercentage = sprintf("%01.2f",$this->closingPercentage);

$htmlStats .= "<tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSales</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->numAppointments</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCount</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->closingPercentage %</b></font>
                                        </td>
                                        </tr>\n";
                                    
                                    
                                    
                $htmlStats .= "<tr>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Year to Date:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last 30 Days:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last 6 Month:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last Year:</font></th>
                <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total:</font></th>
                </tr>
                <tr>
                    <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountYTD</b></font>
                                        </td> 
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesYTD</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountL30</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesL30</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountL6</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesL6</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->salesCountLY</b></font>
                                        </td>
                                        <td align=\"left\" valign =\"top\" bgcolor=\"#FFFFF0\">
                                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$this->totaleSalesLY</b></font>
                                        </td>
                                        </tr></table>\n</div><br><br>";                    
                                    
                                
                                    
 
 

 


 


                            
$this->htmlStats = $htmlStats;

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

$finalHtml = "$message$this->apptHtml<br><br>$this->htmlStats<br><br>$this->htmlSales
</html>";
//echo "dddfuck you";
echo $finalHtml;
//exit;
}
//==============================================================================================
function moveData(){
  

$this->loadSalesData();
$this->loadSalesApptData();
$this->makeStats();

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
$report = new statsAndSales();
$report-> setUserId($user_id);
$report-> setRangeStart($rangeStart);
$report->setRangeEnd($rangeEnd);
$report->moveData();










?>