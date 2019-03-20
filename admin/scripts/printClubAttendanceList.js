$(document).ready(function() {
//----------------------------------------------------------------
function loadClubAttendanceList() {

window.open('clubAttendanceListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();

if(reportType == 'CA') {

var ajaxSwitch = 1;
var attendanceType = $("#attendance_type").val();
var serviceLocation = $("#service_location").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
this.reportName = "";


if(attendanceType == "") {
  alert('Please select an \"Attendance Category\"');
  $("#attendance_type").focus();
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

  
if(reportName == "Select Club Attendance Report") {
   reportName = 'NA';
  }    




        $.ajax ({
                type: "POST",
                url: "loadClubAttendanceListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, attendance_type: attendanceType, service_location: serviceLocation, from_date: fromDate, to_date: toDate, report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                        //alert(data);
                       
                         loadClubAttendanceList();
                                                                           
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