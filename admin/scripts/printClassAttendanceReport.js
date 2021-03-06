$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('classAttendanceReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var scheduleType = $("#schedule_type").val();
var serviceLocation = $("#service_location").val();
var className = $("#class_name").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var select = "";
var optionDropsArray = "";
var reportType = 'EA';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.scheduleTypeName = "";
this.serviceLocationName = "";
this.classTypeName = "";

if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
 }

if(scheduleType == "") {
  alert('Please select a \"Schedule  Type\"');
  $("#schedule_type").focus();
  return false;
 }

if(className == "") {
  alert('Please select a \"Class Name\"');
  $("#class_name").focus();
  return false;
 }
 

//sets up the labels for the printed report.  To and from dates will reflect the first of the year to the currrent date if left blank
if(fromDate == "")  {
   fromDate = "first";
  }
if(toDate == "")  {
   toDate = "today";
  }  
  


//sets up saved html for drop down drill downs when a saved report is loaded
$("#schedule_type > option").each(function() {
     if(this.selected != false) {
        scheduleTypeName = this.text;        
        }
  });
  
$("#service_location > option").each(function() {
     if(this.selected != false) {
        serviceLocationName = this.text;
        }
  });
  
$("#class_name > option").each(function() {
     if(this.selected != false) {
        classTypeName = this.text;
        }
  });  

$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Class Attendance Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }

 
        $.ajax ({
                type: "POST",
                url: "loadClassAttendanceReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, schedule_type: scheduleTypeName,  service_location: serviceLocationName, class_name: classTypeName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});