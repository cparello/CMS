$(document).ready(function() {
//-----------------------------------------------------------------
function redirectPage() {

window.location.href = "editScheduleBundle.php";

}
//-----------------------------------------------------------------
$("#button2").click( function() {

var ajaxSwitch = 1;
var scheduleType = $("#schedule_type").val();
var bundleId = $("#bundle_id").val();
var bundleNameOrig = $("#bundle_name_orig").val();

var answer = confirm('This will permantly delete the Schedule Bundle \"' +bundleNameOrig+ '\". Do you wish to continue?');
if (!answer) {
return false;

}else{


 $.ajax ({
                type: "POST",
                url: "deleteBundle.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId},               
                     success: function(data) { 
                        
                          if(data == 1) {
                             alert('Schedule Category "' +bundleNameOrig+ '" Successfully Deleted');
                             redirectPage();
                            }else{
                             alert('There was an error deleting this Schedule Bundle: '+data);
                            }
                      
                         }//end function success
                 }); //end ajax 

}

 });
 //---------------------------------------------------------------
 });