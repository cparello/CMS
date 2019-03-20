<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class commissionListWindow {

private  $seviceLocation = null;
private  $employeeType = null;
private  $employeeNameTwo = null;
private  $serviceType = null;
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
private  $serviceKey = null; 
private  $serviceQuantity = null;
private  $typeKey = null;
private  $commissionAmount = null;
private  $serviceCost = null;
private  $serviceName = null; 
private  $employeeName = null;
private  $saleDateTime = null;
private  $idCard = null;
private  $contractKey = null;

private  $sqlTable1 = null;
private  $searchSql1 = null;
private  $selectSql1 = null;
private  $counter = 1;


function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
         }
                
function setEmployeeType($employeeType) {
        $this->employeeType = $employeeType;
         }    
         
function setEmployeeName($employeeName) {
        $this->employeeName = $employeeName;
         }     
         
function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
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
     

$this->sqlTable1 = "commission_records";
$this->selectSql1 = "service_key, commission, user_id, sale_date_time, employee_type";
                 

if($this->serviceLocation == '0') {
   $clubSQL = "location_id != '' ";
   }else{
   $clubSQL = "location_id = '$this->serviceLocation' ";
   }

if($this->employeeType == '0') {
  $empTypeSQL = "employee_type !=''";
  }else{
  $empTypeSQL = "employee_type ='$this->employeeType'";
  }

if($this->employeeName == '0') {
  $userSQL = "user_id !='' ";
  }else{
  $userSQL = "user_id ='$this->employeeName'";
  }  

if($this->serviceType == '0') {
  $serviceSQL = "service_key !='' ";
  }else{
  $serviceSQL = "service_key ='$this->serviceType'";
  }  
  

$this->searchSql1 = "$clubSQL AND $empTypeSQL AND $userSQL AND $serviceSQL AND sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' ORDER BY sale_date_time DESC";


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
    
        $this->employeeNameTwo = "$first_name $middle_name $last_name";
       
      }else{
          
        $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_archives WHERE user_id = '$this->userId' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_name, $middle_name, $last_name);
        $stmt->fetch();
        $rowCount = $stmt->num_rows;
        $stmt->close();
          
        $this->employeeNameTwo = "$first_name $middle_name $last_name";  
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
function loadServiceInfo() {

$dbMain = $this->dbconnect();

        $stmt = $dbMain ->prepare("SELECT service_name, service_quantity, group_price, contract_key FROM sales_info WHERE user_id = '$this->userId' AND sale_date_time= '$this->saleDateTime' AND service_key='$this->serviceKey' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($serviceName, $serviceQuantity, $groupPrice, $contractKey);
        $stmt->fetch();
       
        $this->serviceName = $serviceName;
        $this->serviceQuantity = $serviceQuantity;
        $this->serviceCost = $groupPrice;
        $this->contractKey = $contractKey;
       
 $stmt->close();
}
//-----------------------------------------------------------------------------------------
function parseListOne() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $this->selectSql1 FROM $this->sqlTable1 WHERE $this->searchSql1 ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($serviceKey, $commissionAmount, $userId, $saleDateTime, $employeeType);

while ($stmt->fetch()) {
          
           $this->serviceKey = $serviceKey;
           $this->commissionAmount = $commissionAmount; 
           $this->userId = $userId;
           $this->saleDateTime = $saleDateTime;
           $this->typeKey = $employeeType;
                             
           $this->loadEmployeeInfo();
           $this->loadServiceInfo();           
           $this->parseTableRow();

         }
         
$stmt->close();
}
//------------------------------------------------------------------------------------------
function parseTableRow() {

$saleDateSecs = strtotime($this->saleDateTime);
$saleDateTime = date("M j, Y g:i A" ,$saleDateSecs); 



$this->color = "#FFFFFF";
  
 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$saleDateTime</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceQuantity</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceCost</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->commissionAmount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->employeeNameTwo</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->idCard</b></font>
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
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Sale Date</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Contract Key</font></th>
<th align="left" bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Service Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Quantity</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Service Cost</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Commission</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Employee Name</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Employee ID</font></th>
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
$employee_type = $_SESSION['employee_type'];
$employee_name = $_SESSION['employee_name'];
$service_type = $_SESSION['service_type'];

unset($_SESSION['report_name']);
unset($_SESSION['report_type']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['service_location']);
unset($_SESSION['employee_type']);
unset($_SESSION['employee_name']);
unset($_SESSION['service_type']);


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
          

    $listings = new commissionListWindow(); 
    $listings-> setServiceLocation($service_location);
    $listings-> setEmployeeType($employee_type);
    $listings-> setEmployeeName($employee_name);
    $listings-> setServiceType($service_type);   
    $listings-> setReportType($report_type);
    $listings-> setReportName($report_name);
    $listings-> setFromDate($start_date);
    $listings-> setToDate($end_date);
    $listings-> loadSqlStatements();
    $listings-> loadBusinessInfo();
    $listings-> loadListings();







//--------------------------------------------------------------------------------

?>























