$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('salesReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var clubId = $("#service_location").val();
var groupType = $("#group_type").val();
var serviceType = $("#service_type").val();
var serviceTypeOptions = $("#service_type_options").val();
var salesType = $("#sales_type").val();
var salesName = $("#sales_name").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var clubIdDrops = "";
var groupTypeDrops = "";
var serviceTypeDrops = "";
var serviceTypeOptionsDrops = "";
var salesTypeDrops = "";
var salesNameDrops = "";
var select = "";
var optionDropsArray = "";
var reportType = 'S';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.clubName = "";
this.groupName = "";
this.serviceTypeName = "";
this.serviceTypeOptionsName = "";
this.salesType = "";
this.salesName = "";


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(groupType == "") {
  alert('Please select a \"Group Type\"');
  $("#group_type").focus();
  return false;
  }

if(serviceType == "") {
  alert('Please select a \"Service Type\"');
  $("#service_type").focus();
  return false;
  }

if(serviceTypeOptions == "") {
  alert('Please select one of the \"Service Options\"');
  $("#service_type_options").focus();
  return false;
  }

if(salesType == "") {
  alert('Please select a \"Sales Type\"');
  $("#sales_type").focus();
  return false;
  }

if(salesName == "") {
  alert('Please select a \"Sales Name\"');
  $("#sales_name").focus();
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
  
$("#group_type > option").each(function() {
     if(this.selected != false) {
        groupName = this.text;
        }
  });

$("#service_type > option").each(function() {
     if(this.selected != false) {
        serviceTypeName = this.text;
        }
  });

$("#service_type_options > option").each(function() {
     if(this.selected != false) {
        serviceTypeOptionsName = this.text;
        }
  });

$("#sales_type > option").each(function() {
     if(this.selected != false) {
        salesType = this.text;
        }
  });

$("#sales_name > option").each(function() {
     if(this.selected != false) {
        salesName = this.text;
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
                url: "loadReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, club_name: clubName, group_name: groupName, service_type_name: serviceTypeName, service_type_options_name: serviceTypeOptionsName, sales_type: salesType, sales_name: salesName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});