$(document).ready(function() {
//----------------------------------------------------------------
$("#schedule_type").change( function() {

var ajaxSwitch = 1;
var scheduleType = $("#schedule_type").val();
var scheduleText = $("#schedule_type option:selected").text();
//alert(scheduleType);
$.ajax ({
                type: "POST",
                url: "php/bundleTypeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType},               
                     success: function(data) {  
//alert(data);
                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                           $("#listHouse").html("");
                           $("#listHouse").hide("fast");
                                          
                       if(successBit == 1) {
                         alert('There are currently no \"Schedule Names\" associated with "' +scheduleText+ '"');
                                 var bundleContent = "<option value>Select Schedule Bundle</option>";
                                       $("#bundle_type").html(bundleContent);                              
                                           return false;                       
                         }
                         
                       if(successBit == 2) {                                                                                               
                                  var bundleDrops = dataArray[1];                                                                   
                                       $("#bundle_type").html(bundleDrops);
                         }
                         
                         

                         }//end function success
                 }); //end ajax 



});
//---------------------------------------------------------------
});