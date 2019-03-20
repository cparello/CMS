$(document).ready(function() {
//-----------------------------------------------------------------
$("#button1").click( function() {

var ajaxSwitch = "";
var serviceCheck = "";
var checkValue = "";
var serviceArray = "";
var scheduleType = $("#schedule_type").val();
var bundleId = $("#bundle_id").val();
var bundleName = $("#bundle_name").val();
      bundleName = bundleName.replace(/\s+/g, ' ');
var bundleNameOrig = $("#bundle_name_orig").val();
      

if(bundleName != bundleNameOrig) {

   ajaxSwitch = 1;
    $.ajax ({
                type: "POST",
                url: "editBundle2.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId, bundle_name: bundleName},               
                     success: function(data) {  
                         
                         if(data == 1) {
                           alert('Schedule name \"'+bundleNameOrig+'\" successfully changed to \"'+bundleName+'\"');
                                   $("#bundle_name_orig").val(bundleName);
                           }else{
                           alert('There was an error saving this Schedule Name: ' +data);
                           }
                                                  
                         }//end function success
               }); //end ajax 

      }

//takes care of deleted services
$(".service:checked").each(function(){
   serviceCheck += $(this).val();      
   checkValue = $(this).val();
   serviceArray +=(checkValue+',');   
  });	
  
if(serviceCheck != "") {  
  
   ajaxSwitch = 2;
    $.ajax ({
                type: "POST",
                url: "editBundle2.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId, bundle_name: bundleName, service_array: serviceArray},               
                     success: function(data) {  
                        
                        if(data == 1) {
                        
                           var bundleNameTwo = $("#bundle_name").val();
                                 $(".service:checked").each(function(){
                                    $(this).closest('tr').remove();
                                        $("#listOne tr:even").css("background-color", "#FFFFFF");
                                        $("#listOne tr:odd").css("background-color", "#D8D8D8");
                                    });	
                                                                        
                                  alert('Selected services associated with \" '+bundleNameTwo+ '\" successfully deleted'); 
                                  
                           }else{
                            alert('There was an error deleting these services' +data);                           
                           }
                                                  
                         }//end function success
               }); //end ajax   
    
  }

});
//---------------------------------------------------------------
$('input:checkbox').live("click", function(event) {
    if ($(this).attr('checked')) {
        $(this).closest('tr').addClass('checked2');
    } else {
        $(this).closest('tr').removeClass('checked2');
    }
});
//---------------------------------------------------------------
});