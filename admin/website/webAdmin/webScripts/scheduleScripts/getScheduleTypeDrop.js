$(document).ready(function() {

//----------------------------------------------------------------
$("#location").change( function() {

var ajaxSwitch =1;
var clubId = $("#location").val();
   
   if(clubId == "") {
       alert('Please select a club.');
               return false;
     }
//alert(clubId);
$.ajax ({
                type: "POST",
                url: "schedule/scheduleTypeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, clubId: clubId},               
                     success: function(data) {  
                     //alert(data);
                          if(data != "") {                             
                            $('#schedule_type').html(data);        
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
                 


 }); 
//-------------------------------------------------------------------------------
 }); 