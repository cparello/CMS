$(document).ready(function() {
//----------------------------------------------------------------
function loadInstructorRooms(scheduleType, scheduleText) {

var ajaxSwitch = 1;

$.ajax ({
                type: "POST",
                url: "loadInstructorsRooms.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType},               
                     success: function(data) {  

                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                                          
                       if(successBit == 1) {
                         alert('There are currently no \"Instructors\" and or \"Class Rooms\" associated with "' +scheduleText+ ' ". Please use the \"Add Instructors / Class Rooms\" application to add this content.');
                                 var instructorContent = "<option value>Select Instructor</option>";
                                 var classRoomContent = "<option value>Select Room</option>";
                                       $("#instructor").html(instructorContent);      
                                       $("#room").html(classRoomContent);
                                           return false;                       
                         }
                         
                       if(successBit == 2) {                                                                                               
                                  var instructorDrops = dataArray[1]; 
                                  var roomDrops = dataArray[2];
                                       $("#instructor").html(instructorDrops);
                                       $("#room").html(roomDrops);
                                      
                         }
                         
                         

                         }//end function success
                 }); //end ajax 



}
//----------------------------------------------------------------
$("#schedule_type").change( function() {

var ajaxSwitch = 2;
var headerType = 1;
var scheduleType = $("#schedule_type").val();
var scheduleText = $("#schedule_type option:selected").text();

$.ajax ({
                type: "POST",
                url: "bundleTypeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, header_type: headerType},               
                     success: function(data) {  

                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                           $("#listHouse").html("");
                           $("#listHouse").hide("fast");
                                          
                       if(successBit == 1) {
                         alert('There are currently no \"Class Names\" associated with "' +scheduleText+ '"');
                                 var bundleContent = "<option value>Select Class Name</option>";
                                       $("#bundle_type").html(bundleContent);                              
                                           return false;                       
                         }
                         
                       if(successBit == 2) {                                                                                               
                                  var bundleDrops = dataArray[1];                                                                   
                                       $("#bundle_type").html(bundleDrops);
                                          loadInstructorRooms(scheduleType, scheduleText);
                                      
                         }
                         
                         

                         }//end function success
                 }); //end ajax 





});
//---------------------------------------------------------------
});