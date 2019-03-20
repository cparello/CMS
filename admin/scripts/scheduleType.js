$(document).ready(function() {

//-----------------------------------------------------------------
$("#button1").click( function() {

var typeName = $("#type_name").val();
var typeDescription = $("#type_description").val();
var serviceLocation = $("#service_location").val();
var ajaxSwitch = 1;

if(typeName == "") {
  alert('Please provide a \"Category Name\"');
       $("#type_name").focus();
         return false;
   }

if(serviceLocation == "") {
  alert('Please provide a \"Service Location\"');
       $("#service_location").focus();
         return false;
   }


 $.ajax ({
                type: "POST",
                url: "parseScheduleType.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, type_name: typeName, service_location: serviceLocation, type_description: typeDescription},               
                     success: function(data) { 
                     
                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                     var nameSake = dataArray[1];
                     
                       if(successBit == 1) {
                         alert('The Category Name "' +nameSake+ '" already exists for this Service Location');
                                  return false;                       
                         }
                         
                       if(successBit == 2) { 
                          var confirmation = ('Category Name "' +nameSake+ '" Successfully Saved');
                               $("#conf").html(confirmation);                       
                        }
                         
                         

                         }//end function success
                 }); //end ajax 





});
//-----------------------------------------------------------------









});