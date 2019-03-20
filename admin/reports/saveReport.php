<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  saveReport {

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
private  $flowDrop = null;
private  $monthlyDrop = null;
private  $holdCancelDrop = null;
private  $activeInactiveDrop = null;
private  $clubAttendanceDrop = null;
private  $classAttendanceDrop = null;
private  $commissionDrop = null;
private  $optionsArray = null;


function setUserId($userId) {
        $this->userId = $userId;
        }

function setReportType($reportType) {
        $this->reportType = $reportType;
        }
        
function setReportName($reportName) {
        $this->reportName = $reportName;
        }        
        
function setOptionsArray($optionsArray) {
        $this->optionsArray = $optionsArray;
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
                 
                 if($this->reportKey == $reportKey) {
                    $selected = 'selected';
                    }else{
                    $selected = "";
                    }
                    
                 
                 $this->reportDrop .= "<option value=\"$reportKey\"$selected>$reportName</option>\n";   
     
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
function saveReport() {

$this->userId = $_SESSION['user_id'];


$dbMain = $this->dbconnect();
$sql = "INSERT INTO saved_reports VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisss', $reportKey, $userId, $reportName, $optionDrops, $reportType); 

$reportKey = null;
$userId = $this->userId;
$reportName = $this->reportName;
$optionDrops = $this->optionsArray;
$reportType = $this->reportType;


if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	//printf("Error: %s. save report\n", $stmt->error);
   }		

$this->reportKey = $stmt->insert_id; 
$stmt->close(); 

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
             
function getCommissionDrops() {
             return($this->commissionDrop);
             }      
             

}
//============================================================================

$ajax_switch = $_REQUEST['ajax_switch'];
$report_name = $_REQUEST['report_name'];
$options_array = $_REQUEST['options_array'];
$report_type = $_REQUEST['report_type'];

if($ajax_switch == 1) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$sales_report_drops = $save-> getSalesReportDrops();

$salesOptionParent ='<option value="">Select Sales Report</option>';

$salesReportReturn = "1|$salesOptionParent \n $sales_report_drops";

echo"$salesReportReturn";
exit;

}
//--------------------------------------------------------------
if($ajax_switch == 2) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$revenue_report_drops = $save-> getFlowDrops();

$revenueOptionParent ='<option value="">Select Revenue Report</option>';

$revenueReportReturn = "1|$revenueOptionParent \n $revenue_report_drops";

echo"$revenueReportReturn";
exit;

}
//------------------------------------------------------------
if($ajax_switch == 3) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$retail_report_drops = $save-> getRetailDrops();

$retailOptionParent ='<option value="">Select Retail Report</option>';

$retailReportReturn = "1|$retailOptionParent \n $retail_report_drops";

echo"$retailReportReturn";
exit;

}
//------------------------------------------------------------
if($ajax_switch == 4) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$collection_report_drops = $save-> getCollectibleReportDrops();

$collectionOptionParent ='<option value="">Select Collection Report</option>';

$collectionReportReturn = "1|$collectionOptionParent \n $collection_report_drops";

echo"$collectionReportReturn";
exit;

}
//----------------------------------------------------------
if($ajax_switch == 5) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$expire_report_drops = $save-> getExpiredReportDrops();

$expireOptionParent ='<option value="">Select Renewable Report</option>';

$expireReportReturn = "1|$expireOptionParent \n $expire_report_drops";

echo"$expireReportReturn";
exit;

}
//---------------------------------------------------------
if($ajax_switch == 6) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$monthly_report_drops = $save-> getMonthlySettledDrops();

$monthlyOptionParent ='<option value="">Select Settled Report</option>';

$monthlyReportReturn = "1|$monthlyOptionParent \n $monthly_report_drops";

echo"$monthlyReportReturn";
exit;

}
//--------------------------------------------------------
if($ajax_switch == 7) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$hc_report_drops = $save-> getHoldCancelDrops();

$hcOptionParent ='<option value="">Select Hold Cancel Report</option>';

$hcReportReturn = "1|$hcOptionParent \n $hc_report_drops";

echo"$hcReportReturn";
exit;

}
//--------------------------------------------------------
if($ajax_switch == 8) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$ai_report_drops = $save-> getActiveInactiveDrops();

$aiOptionParent ='<option value="">Select Active Inactive Report</option>';

$aiReportReturn = "1|$aiOptionParent \n $ai_report_drops";

echo"$aiReportReturn";
exit;

}
//--------------------------------------------------------
if($ajax_switch == 9) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$ca_report_drops = $save-> getClubAttendanceDrops();

$caOptionParent ='<option value="">Select Club Attendance Report</option>';

$caReportReturn = "1|$caOptionParent \n $ca_report_drops";

echo"$caReportReturn";
exit;

}
//-------------------------------------------------------
if($ajax_switch == 10) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$ea_report_drops = $save-> getClassAttendanceDrops();

$eaOptionParent ='<option value="">Select Class Attendance Report</option>';

$eaReportReturn = "1|$eaOptionParent \n $ea_report_drops";

echo"$eaReportReturn";
exit;

}
//-------------------------------------------------------
if($ajax_switch == 11) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$pr_report_drops = $save-> getPayrollReportDrops();

$prOptionParent ='<option value="">Select Payroll Report</option>';

$prReportReturn = "1|$prOptionParent \n $pr_report_drops";

echo"$prReportReturn";
exit;

}
//-------------------------------------------------------
if($ajax_switch == 12) {

$report_name = trim($report_name);

$save = new saveReport();
$save-> setUserId($user_id);
$save-> setReportType($report_type);
$save-> setReportName($report_name);
$save-> setOptionsArray($options_array);
$save-> saveReport();
$save-> loadReportDrops();
$cr_report_drops = $save-> getCommissionDrops();

$crOptionParent ='<option value="">Select Commission Report</option>';

$crReportReturn = "1|$crOptionParent \n $cr_report_drops";

echo"$crReportReturn";
exit;

}
//------------------------------------------------------

?>









