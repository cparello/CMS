$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('clubAttendanceReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var attendanceType = $("#attendance_type").val();
var serviceLocation = $("#service_location").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var select = "";
var optionDropsArray = "";
var reportType = 'CA';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.attendanceTypeName = "";
this.serviceLocationName = "";


if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
 }

if(attendanceType == "") {
  alert('Please select an \"Attendance Category\"');
  $("#attendance_type").focus();
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
$("#attendance_type > option").each(function() {
     if(this.selected != false) {
        attendanceTypeName = this.text;        
        }
  });
  
$("#service_location > option").each(function() {
     if(this.selected != false) {
        serviceLocationName = this.text;
        }
  });

$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Club Attendance Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }

 
        $.ajax ({
                type: "POST",
                url: "loadClubAttendanceReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, attendance_type: attendanceTypeName,  service_location: serviceLocationName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});