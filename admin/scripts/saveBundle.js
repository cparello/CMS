$(document).ready(function() {
//----------------------------------------------------------------
$("#button1").click( function() {

var ajaxSwitch = 1;
var serviceArray = "";
var serviceCheck = "";
var checkValue = "";
var scheduleType = $("#schedule_type").val();
var bundleType = $("#bundle_type").val();
var nameSake = $("#bundle_type option:selected").text();



if(scheduleType == "") {
  alert('Please select a \"Schedule Category\"');
          $("#schedule_type").focus();
             return false;
 }

if(bundleType == "") {
  alert('Please create or select a name for your Schedule Category');
          $("#bundleType").focus();
             return false;
 }

$(".service:checked").each(function(){
   serviceCheck += $(this).val();      
   checkValue = $(this).val();
   serviceArray +=(checkValue+',');
   
  });		

if(serviceCheck == "") {
  alert('Please select a service or services for your schedule');
          return false;
          }


var bundleTypeArray = bundleType.split(',');
var bundleId = bundleTypeArray[0];
var locationId = bundleTypeArray[1];

    $.ajax ({
                type: "POST",
                url: "saveBundle.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId, location_id: locationId, service_array: serviceArray},               
                     success: function(data) {  
//alert(data);
                   if(data != 2) {
                     alert('There was an error saving this Schedule Bundle');
                             return false;                       
                     }
                   if(data == 2) {
                           $("#listHouse").html("");
                           $("#listHouse").hide("fast");
                           $('[name=schedule_type]').val( '' );
                           $('[name=bundle_type]').val( '' );
                           
                     alert('Schedule Bundle \"' +nameSake+ '\" Successfully Saved');
                                                  
                     }                     
                         
                         }//end function success
               }); //end ajax 

});
//---------------------------------------------------------------
});