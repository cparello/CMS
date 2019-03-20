<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  savedReports {

private  $userId = null;
private  $reportType = null;
private  $reportSql = null;
private  $reportKey = null;
private  $sqlCode = null;
private  $reportName = null;
private  $reportDrop = null;
private  $retailDrop = null;
private  $salesDrop = null;
private  $collectibleDrop = null;
private  $payrollDrop = null;
private  $renewableDrop = null;
private  $expiredDrop = null;
private  $monthlyDrop = null;
private  $flowDrop = null;
private  $holdCancelDrop = null;
private  $activeInactiveDrop = null;
private  $clubAttendanceDrop = null;
private  $classAttendanceDrop = null;
private  $commissionDrop = null;


function setReportType($reportType) {
        $this->reportType = $reportType;
        }
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------------
function parseReportDrops() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT report_key, report_name FROM saved_reports WHERE user_id='$this->userId' AND report_type='$this->reportType'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($reportKey, $reportName);
   $rowCount = $stmt->num_rows;
   
   if($rowCount != 0) {
   
        while($stmt->fetch()) {
                 
                 $this->reportDrop .= "<option value=\"$reportKey\">$reportName</option>\n";   
     
                 }
      }

   if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services function loadMonthlyServices", $stmt->error);
      }
   
$stmt->close();      


}
//---------------------------------------------------------------------------------------------------------------------------
function loadReportDrops() {

$this->userId = $_SESSION['user_id'];

switch ($this->reportType) {
        case "F":
        $this->parseReportDrops();
        $this->flowDrop = $this->reportDrop;
        break;
        case "S":
        $this->parseReportDrops();
        $this->salesDrop = $this->reportDrop;
        break;
        case "P":
        $this->parseReportDrops();
        $this->payrollDrop = $this->reportDrop;
        break;
        case "C":
        $this->parseReportDrops();
        $this->collectibleDrop = $this->reportDrop;
        break;
        case "R":
        $this->parseReportDrops();
        $this->retailDrop = $this->reportDrop;
        break; 
        case "E":
        $this->parseReportDrops();
        $this->expiredDrop = $this->reportDrop;
        break;  
        case "M":
        $this->parseReportDrops();
        $this->monthlyDrop = $this->reportDrop;
        break;  
        case "H":
        $this->parseReportDrops();
        $this->holdCancelDrop = $this->reportDrop;
        break;  
        case "A":
        $this->parseReportDrops();
        $this->activeInactiveDrop = $this->reportDrop;
        break;   
        case "CA":
        $this->parseReportDrops();
        $this->clubAttendanceDrop = $this->reportDrop;
        break;
        case "EA":
        $this->parseReportDrops();
        $this->classAttendanceDrop = $this->reportDrop;
        break;   
        case "CO":
        $this->parseReportDrops();
        $this->commissionDrop = $this->reportDrop;
        break;             
      }



}
//------------------------------------------------------------------------------------------------------------------------------
function getSalesReportDrops() {
             return($this->salesDrop);
             }

function getPayrollReportDrops() {
             return($this->payrollDrop);
             }

function getCollectibleReportDrops() {
             return($this->collectibleDrop);
             }

function getRenewableReportDrops() {
             return($this->renewableDrop);
             }

function getExpiredReportDrops() {
             return($this->expiredDrop);
             }

function getFlowDrops() {
             return($this->flowDrop);
             }
             
function getRetailDrops() {
             return($this->retailDrop);
             }
             
function getMonthlySettledDrops() {
             return($this->monthlyDrop);
             } 
             
function getHoldCancelDrops() {
             return($this->holdCancelDrop);
             } 
             
function getActiveInactiveDrops() {
             return($this->activeInactiveDrop);
             }                   
             
function getClubAttendanceDrops() {
             return($this->clubAttendanceDrop);
             }                        

function getClassAttendanceDrops() {
             return($this->classAttendanceDrop);
             }      

function getCommissionReportDrops() {
             return($this->commissionDrop);
             }      

}
?>