$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('payrollReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var clubId = $("#service_location").val();
var paymentCycle = $("#payment_cycle").val();
var compType = $("#compensation_type").val();
var empType = $("#employee_type").val();
var otType = $("#ot_type").val();


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
this.paymentCycleName = "";
this.compTypeName = "";
this.empTypeName = "";
this.otTypeName = "";



if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(paymentCycle == "") {
  alert('Please select a \"Payment Cycle\"');
  $("#payment_cycle").focus();
  return false;
  }

if(compType == "") {
  alert('Please select a \"Compensation Type\"');
  $("#compensation_type").focus();
  return false;
  }
  
if(empType == "") {
  alert('Please select an \"Employee Type\"');
  $("#employee_type").focus();
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
  
$("#payment_cycle > option").each(function() {
     if(this.selected != false) {
        paymentCycleName = this.text;
        }
  });

$("#compensation_type > option").each(function() {
     if(this.selected != false) {
        compTypeName = this.text;
        }
  });

$("#employee_type > option").each(function() {
     if(this.selected != false) {
        empTypeName = this.text;
        }
  });

$("#ot_type > option").each(function() {
     if(this.selected != false) {
        otTypeName = this.text;
        }
  });

 
$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    
  
  
if(reportName == "Select Payroll Report") {
   reportName = 'NA';
  } 
  
if(otTypeName == "Select Overtime") {
   otTypeName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }


  
        $.ajax ({
                type: "POST",
                url: "loadPayrollReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, club_name: clubName, payment_cycle_name: paymentCycleName, compensation_name: compTypeName, employee_type_name: empTypeName, ot_type_name: otTypeName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});