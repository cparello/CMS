$(document).ready(function() {
//----------------------------------------------------------------
function loadRenewableList() {

window.open('renewableListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();

if(reportType == 'E') {

var ajaxSwitch = 1;
var renewType = $("#renew_type").val();
var serviceLocation = $("#service_location").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
this.reportName = "";


if(renewType == "") {
  alert('Please select a \"Renewable Category\"');
  $("#renew_type").focus();
  return false;
 }

if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
 }


$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Renewable Report") {
   reportName = 'NA';
  }    




        $.ajax ({
                type: "POST",
                url: "loadRenewableListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, renew_type: renewType, service_location: serviceLocation, from_date: fromDate, to_date: toDate, report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                        //alert(data);
                       
                         loadRenewableList();
                                                                           
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