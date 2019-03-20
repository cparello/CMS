$(document).ready(function() {

//-----------------------------------------------------------------
$("#button1").click( function() {

var scheduleType = $("#schedule_type").val();
var ajaxSwitch = 1;

if(scheduleType == "") {
  alert('Please select a \"Schedule Category\" to edit');
         return false;
   }


window.location.href = 'editScheduleTypeForm.php?type_id=' +scheduleType;


});
//----------------------------------------------------------------
$("#button2").click( function() {

var scheduleType = $("#schedule_type").val();
var typeName = "";
var ajaxSwitch = 1;

if(scheduleType == "") {
  alert('Please select a \"Schedule Category\" to delete');
         return false;
   }

$("#schedule_type > option").each(function() {
     if(this.selected == true) {
        typeName = this.text;       
        }     
  });


var answer = confirm('This will permantly delete the Schedule Category \"' +typeName+ '\".  Do you wish to continue?');
if (!answer) {
return false;

}else{

 $.ajax ({
                type: "POST",
                url: "deleteScheduleType.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType},               
                     success: function(data) { 
                        
                      $("#schedule_type").html(data);
                          var confirmation = ('Schedule Category "' +typeName+ '" Successfully Deleted');
                               $("#conf").html(confirmation);                     
                      
                         }//end function success
                 }); //end ajax 

}



});
//-----------------------------------------------------------------









});