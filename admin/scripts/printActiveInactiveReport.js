$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('activeInactiveReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var categoryType = $("#category_type").val();
var serviceLocation = $("#service_location").val();
var dateRange = $("#date_range").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var select = "";
var optionDropsArray = "";
var reportType = 'A';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.categoryTypeName = "";
this.serviceLocationName = "";
this.dateRangeName = "";


if(categoryType == "") {
  alert('Please select a \"Category Type\"');
  $("#category_type").focus();
    return false;
  }
  
if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
    return false;
  }  
  
if(dateRange == "") {
  alert('Please select a \"Date Range\"');
  $("#date_range").focus();
    return false;
  }    
  


//sets up saved html for drop down drill downs when a saved report is loaded
$("#category_type > option").each(function() {
     if(this.selected != false) {
        categoryTypeName = this.text;        
        }
  });
  
$("#service_location > option").each(function() {
     if(this.selected != false) {
        serviceLocationName = this.text;
        }
  });

$("#date_range > option").each(function() {
     if(this.selected != false) {
        dateRangeName = this.text;
        }
  });

$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Active Inactive Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }

 
        $.ajax ({
                type: "POST",
                url: "loadActiveInactiveReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, date_range: dateRangeName, category_type: categoryTypeName,  service_location: serviceLocationName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});