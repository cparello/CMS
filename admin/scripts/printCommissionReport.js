$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('commissionReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var clubId = $("#service_location").val();
var employeeType = $("#employee_type").val();
var employeeName = $("#employee_name").val();
var serviceType = $("#service_type").val();


var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var reportType = 'P';
var ajaxSwitch = 1;


this.reportName = "";
this.clubName = "";
this.employeeTypeName = "";
this.employeeNameName = "";
this.serviceTypeName = "";


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(employeeType == "") {
  alert('Please select an \"Employee Type\"');
  $("#employee_type").focus();
  return false;
  }  

if(employeeName == "") {
  alert('Please select an \"Employee Name\"');
  $("#employee_name").focus();
  return false;
  }

if(serviceType == "") {
  alert('Please select a \"Service Type\"');
  $("#service_type").focus();
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
$("#service_location > option").each(function() {
     if(this.selected != false) {
        clubName = this.text;        
        }
  });
  
$("#employee_type > option").each(function() {
     if(this.selected != false) {
        employeeTypeName = this.text;
        }
  });  
  
    
$("#employee_name > option").each(function() {
     if(this.selected != false) {
        employeeNameName = this.text;
        }
  });

$("#service_type > option").each(function() {
     if(this.selected != false) {
        serviceTypeName = this.text;
        }
  });
 
 
$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    
  
  
if(reportName == "Select Commission Report") {
   reportName = 'NA';
  } 
  


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }


  
        $.ajax ({
                type: "POST",
                url: "loadCommissionReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, club_name: clubName, employee_type_name: employeeTypeName, employee_name_name: employeeNameName, service_type_name: serviceTypeName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});