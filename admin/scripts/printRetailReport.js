$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('retailReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var clubId = $("#service_location").val();
var categoryType = $("#retail_category").val();
var productName = $("#product").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var clubIdDrops = "";
var categoryTypeDrops = "";
var productNameDrops = "";
var select = "";
var optionDropsArray = "";
var reportType = 'R';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.clubName = "";
this.categoryName = "";
this.productName = "";


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(categoryType == "") {
  alert('Please select a \"Retail Category\"');
  $("#retail_category").focus();
  return false;
  }

if(productName == "") {
  alert('Please select a \"Product Name\"');
  $("#product").focus();
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
  
$("#retail_category > option").each(function() {
     if(this.selected != false) {
        categoryName = this.text;
        }
  });


$("#product > option").each(function() {
     if(this.selected != false) {
        productName = this.text;
        }
  });
  
$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    
  
if(reportName == "Select Retail Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }

  
        $.ajax ({
                type: "POST",
                url: "loadRetailReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, club_name: clubName, category_name: categoryName, product_name: productName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});