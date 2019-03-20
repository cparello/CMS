<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  selectReport {

private  $reportId = null;
private  $optionDropArray = null;
private  $optionCount = null;
private  $reportType = null;


function setReportId($reportId) {
       $this->reportId = $reportId;
       }
       
function setReportType($reportType) {
       $this->reportType = $reportType;
       }       


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------
function loadDropDownArray() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT option_drops FROM saved_reports WHERE report_key='$this->reportId' AND report_type='$this->reportType'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($optionDropArray);
   $rowCount = $stmt->num_rows;
   $stmt->fetch();
 
  $optionArray = explode("|", $optionDropArray);
  $this->optionDropArray = $optionDropArray;
  
 $stmt->close(); 

}
//------------------------------------------------------------------------------
function getReportType() {
             return($this->reportType);
             }

function getOptionDropArray() {
             return($this->optionDropArray);
             }


}
//=============================================
$ajax_switch = $_REQUEST['ajax_switch'];
$saved_report_id = $_REQUEST['saved_report_id'];
$report_type = $_REQUEST['report_type'];


if($ajax_switch == "1") {

$report = new selectReport();
$report-> setReportId($saved_report_id);
$report-> setReportType($report_type);
$report-> loadDropDownArray();
$report_type = $report-> getReportType();
$option_array = $report-> getOptionDropArray();

$options = "$report_type@$option_array";
echo "$options";
exit;


}