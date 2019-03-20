$(document).ready(function() {
//---------------------------------------------------------------
function loadReport() {

window.open('collectionReportWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------
$("#printBut").click( function() {

var collectionType = $("#collection_type").val();
var collectionCategory = $("#colCat").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var summaryRows = $("#summary_rows").val();
var barPrint = $("#bar_print").val();
var linePrint = $("#line_print").val();
var switchBit = $("#switch_bit").val();
var printChart = "";
var collectionTypeDrops = "";
var collectionCategoryDrops = "";
var select = "";
var optionDropsArray = "";
var reportType = 'C';
var ajaxSwitch = 1;

//setup unversal vars
this.reportName = "";
this.collectionTypeName = "";
this.collectionCategoryName = "";


if(collectionType == "") {
  alert('Please select a \"Collection Category\"');
  $("#collection_type").focus();
  return false;
  
  }else{
          
        if(collectionCategory == "") {
        
                switch (collectionType) {
                  case "P":
                  alert('Please select a \"Collection Attempt\"');         
                  break;
                  case "D":
                  alert('Please select a \"Transaction Type\"');                        
                  break;
                  case "I":
                  alert('Please select a \"Club Location\"');          
                  break;   
                 }
      
              $("#colCat").focus();
                return false;
         }
  }


//sets up the labels for the printed report.  To and from dates will reflect the first of the year to the currrent date if left blank
if(fromDate == "")  {
   fromDate = "first";
  }
if(toDate == "")  {
   toDate = "today";
  }  
  


//sets up saved html for drop down drill downs when a saved report is loaded
$("#collection_type > option").each(function() {
     if(this.selected != false) {
        collectionTypeName = this.text;        
        }
  });
  
$("#colCat > option").each(function() {
     if(this.selected != false) {
        collectionCategoryName = this.text;
        }
  });

$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Collection Report") {
   reportName = 'NA';
  }    


if(switchBit == "1") {
  printChart = barPrint;
  }else if(switchBit == "2"){
  printChart = linePrint;
  }

 
        $.ajax ({
                type: "POST",
                url: "loadCollectionReportVariables.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, from_date: fromDate, to_date: toDate, collection_type: collectionTypeName, collection_type_index: collectionType, collection_category: collectionCategoryName, summary_rows: summaryRows, print_chart: printChart},               
                     success: function(data) { 
                     
                            loadReport();
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});