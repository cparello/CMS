$(document).ready(function() {
    
$(function() {
    //alert('fu');
    var ajaxSwitch = 2;
    var radios = $('#bundle_type');
    radios.on('change', function() {
    var bunName = $('#bundle_type').val();  
    //alert(bunName); 
        var dataArray = bunName.split(',');                        
                     var bunId = dataArray[0]; 
                     var location = dataArray[1];
                  
        
         $.ajax ({
                type: "POST",
                url: "updateBundleDescription.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, bunId: bunId},               
                     success: function(data) {  
                       // alert(data);
                            var dataArray = data.split('|');                        
                             var successBit = dataArray[0]; 
                             var description = dataArray[1];
                  
                    
                     
                          if(successBit == 1) {                             
                                $('#bun_descrip').val(description);   
                                         
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});
//----------------------------------------------------------------
$("#button1").click( function() {

var ajaxSwitch = 1;
var serviceArray = "";
var serviceCheck = "";
var checkValue = "";
var scheduleType = $("#schedule_type").val();
var bundleType = $("#bundle_type").val();
var nameSake = $("#bundle_type option:selected").text();
var bundleDescription = $("#bun_descrip").val();

//alert(bundleDescription);

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
 
 if(bundleDescription == "") {
  alert('Please enter a description for your bundle');
          $("#bun_descrip").focus();
             return false;
 }






var bundleTypeArray = bundleType.split(',');
var bundleId = bundleTypeArray[0];
var locationId = bundleTypeArray[1];

    $.ajax ({
                type: "POST",
                url: "updateBundleDescription.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, bundle_id: bundleId, bundleDescription: bundleDescription},               
                     success: function(data) {  
//alert(data);
                   if(data != 2) {
                     alert('There was an error saving this Bundle Description');
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