$(document).ready(function() {
//----------------------------------------------------------------
$("#button1").click( function() {

var ajaxSwitch = 1;
var roomName = $("#room_name").val();
var scheduleType = $("#schedule_type").val();
var scheduleName = $("#type_name").val();
 

if(roomName == "") {
  alert('Please enter the name for the \"Class Room\" that you wish to add');
          $("#room_name").focus();
             return false;
   }
 

$.ajax ({
                type: "POST",
                url: "addRoom.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, room_name: roomName, schedule_type: scheduleType},               
                     success: function(data) { 
                     
                     
                       if(data == 1) {
                         alert('The Class Room Name "' +roomName+ '" already exists for ' +scheduleName);
                                  return false;                       
                         }
                         
                       if(data == 2) { 
                          alert('Class Room Name "' +roomName+ '" Successfully saved for '+scheduleName);
                                  $("#room_name").val('');                      
                        }
                         
                         

                         }//end function success
                 }); //end ajax 



return false;


 
}); 
//-------------------------------------------------------------
});