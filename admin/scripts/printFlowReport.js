$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('flowReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var clubId = $("#service_location").val();
var flowType = $("#flow_type").val();
var salesType = $("#sales_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var clubIdDrops = "";
var flowTypeDrops = "";
var salesTypeDrops = "";
var select = "";
var optionDropsArray = "";
var reportType = 'S';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.clubName = "";
this.flowName = "";
this.salesType = "";



if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(flowType == "") {
  alert('Please select a \"Cash Flow Type\"');
  $("#flow_type").focus();
  return false;
  }

if(salesType == "") {
  alert('Please select a \"Sales Type\"');
  $("#sales_type").focus();
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
  
$("#flow_type > option").each(function() {
     if(this.selected != false) {
        flowName = this.text;
        }
  });


$("#sales_type > option").each(function() {
     if(this.selected != false) {
        salesType = this.text;
        }
  });
  
$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    
  
if(reportName == "Select Sales Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }



  
        $.ajax ({
                type: "POST",
                url: "loadFlowReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, club_name: clubName, flow_name: flowName, sales_type: salesType, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});