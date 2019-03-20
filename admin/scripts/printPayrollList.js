$(document).ready(function() {
//----------------------------------------------------------------
function loadPayrollList() {

window.open('payrollListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var ajaxSwitch = 1;
var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var reportName = "";

if(reportType == 'P') {

var clubId = $("#service_location").val();
var paymentCycle = $("#payment_cycle").val();
var compType = $("#compensation_type").val();
var empType = $("#employee_type").val();
var otType = $("#ot_type").val();
this.reportName = "";


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


$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Payroll Report") {
   reportName = 'NA';
  }    


        $.ajax ({
                type: "POST",
                url: "loadPayrollListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, service_location: clubId, payment_cycle: paymentCycle, compensation_type: compType, employee_type: empType, ot_type: otType, from_date: fromDate, to_date: toDate, report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                     //   alert(data);
                       
                         loadPayrollList();
                                                                           
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