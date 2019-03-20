$(document).ready(function() {
//----------------------------------------------------------------
function loadActiveInactiveList() {

window.open('activeInactiveListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();


if(reportType == 'A') {

var ajaxSwitch = 1;
var categoryType = $("#category_type").val();
var serviceLocation = $("#service_location").val();
var dateRange = $("#date_range").val();
this.reportName = "";


if(categoryType == "") {
  alert('Please select a \"Category Type\"');
  $("#category_type").focus();
    return false;
  }
  
//weeds out comparison list
if(categoryType == "AC") {
  alert('\"Attrition Comparison\" cannot be used to generate a list.  Please select either the  \"Active Accounts\" or \"Inactive Accounts\" options to generate a list of account holders');
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



$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Active Inactive Report") {
   reportName = 'NA';
  }    


        $.ajax ({
                type: "POST",
                url: "loadActiveInactiveListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, category_type: categoryType, service_location: serviceLocation, date_range: dateRange,  report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                        //alert(data);
                       
                         loadActiveInactiveList();
                                                                           
                         }//end function success
                 }); //end ajax 




}

});
//------------------------------------------------------------------
$("#printListBut").on({
    'mouseover' : function() {
      $(this).attr('src','../images/print-list-on.png');
    },
    mouseout : function() {
  $(this).attr('src','../images/print-list-off.png');
    }
  });
//-----------------------------------------------------------------
});