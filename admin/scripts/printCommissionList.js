$(document).ready(function() {
//----------------------------------------------------------------
function loadCommissionList() {

window.open('commissionListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var ajaxSwitch = 1;
var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var reportName = "";

if(reportType == 'CO') {

var clubId = $("#service_location").val();
var employeeType = $("#employee_type").val();
var employeeName = $("#employee_name").val();
var serviceType = $("#service_type").val();
this.reportName = "";


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


$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Commission Report") {
   reportName = 'NA';
  }    


        $.ajax ({
                type: "POST",
                url: "loadCommissionListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, service_location: clubId, employee_type: employeeType, employee_name: employeeName, service_type: serviceType, from_date: fromDate, to_date: toDate, report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                     //   alert(data);
                       
                         loadCommissionList();
                                                                           
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