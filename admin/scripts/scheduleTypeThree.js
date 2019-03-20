$(document).ready(function() {

//-----------------------------------------------------------------
$("#button1").click( function() {

var typeId = $("#type_id").val();
var typeName = $("#type_name").val();
var typeDescription = $("#type_description").val();
var serviceLocation = $("#service_location").val();
var ajaxSwitch = 2;

if(typeName == "") {
  alert('Please provide a \"Type Name\"');
       $("#type_name").focus();
         return false;
   }


 $.ajax ({
                type: "POST",
                url: "parseScheduleType.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, type_name: typeName, service_location: serviceLocation, type_description: typeDescription, type_id: typeId},               
                     success: function(data) { 
                     //alert(data);
                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                     var nameSake = dataArray[1];
                     
                       if(successBit == 1) {
                         alert('The Category Name "' +nameSake+ '" already exists for this Service Location');
                                  return false;                       
                         }
                         
                       if(successBit == 2) { 
                          var confirmation = ('Category Name "' +nameSake+ '" Successfully Updated');
                               $("#conf").html(confirmation);                       
                        }
                         
                         

                         }//end function success
                 }); //end ajax 





});
//-----------------------------------------------------------------









});