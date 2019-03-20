$(document).ready(function() {
//----------------------------------------------------------------
$("#saveBut").click( function() {

   $("#chartSave").show("slow");

});
//---------------------------------------------------------------
$("#menu_exit").click( function() {

   $("#chartSave").hide("slow");

});
//---------------------------------------------------------------
$("#button2").click( function() {

var ajaxSwitch = 1;
var scheduleType = $("#schedule_type").val();
var bundleName = $("#bundle_name").val();

if(bundleName == "") {
  alert('Please enter a \"Schedule Name\"');
  $("#bundle_name").focus();
  return false;
  }


if(scheduleType == "") {
  alert('Please select a \"Schedule Category\" before creating a name for this schedule');
  $("#schedule_type").focus();
  return false;
  }




$.ajax ({
                type: "POST",
                url: "saveScheduleName.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_name: bundleName},               
                     success: function(data) {  

                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                     var nameSake = dataArray[1];
                     
                       if(successBit == 1) {
                         alert('The Schedule Name "' +nameSake+ '" already exists for this Schedule Category');
                                  return false;                       
                         }
                         
                       if(successBit == 2) {                                                             
                                  var bundleId = dataArray[2];
                                  var bundleDrops = dataArray[3];                                                                   
                                       $("#bundle_type").html(bundleDrops);
                                        // loadServicesOne(bundleId);                                  
                                         alert('Schedule Name "' +nameSake+ '" Successfully Saved. Choose this name from the drop down menu in order to view service options'); 
                         }
                         
                         

                         }//end function success
                 }); //end ajax 



});
//---------------------------------------------------------------
});