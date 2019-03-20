$(document).ready(function() {

//----------------------------------------------------------------
function loadScheduleList(bundleType, scheduleType) {

var ajaxSwitch =1;
var typeArray = bundleType.split(",");
var bundleId = typeArray[0];

$.ajax ({
                type: "POST",
                url: "loadScheduleList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     
                          if(successBit == 1) {                             
                             $("#classList").html(listings);
                             $("#listings").tablesorter();
                             $('#listings.tablesorter').tablesorter({
                                scrollHeight: 101,
                                widgets: ['scroller']
                               });                 
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
                 


}
//----------------------------------------------------------------
function resetFormFields() {

$("#form").trigger('reset');
$("#button1").val('Add Schedule');
$("#schedule_id").val("");
$("#hour").val("");
$("#minutes").val("");
$("#AP").val("");
$("#instructor").val("");
$("#room").val("");

//takes care of recursive radios
var recursive = 'Y';
      $('input:radio[name=recur]').each(function() {
            if($(this).val() == recursive) {
               $(this).attr('checked','checked'); 
               $("#datePick").hide();
               }
        });
//takes care of active status
var active = 'Y';
      $('input:radio[name=active]').each(function() {
            if($(this).val() == active) {
               $(this).attr('checked','checked'); 
               }
        });

}
//----------------------------------------------------------------
$("#button1").click( function() {

var ajaxSwitch = "";
var addEdit = $("#addEdit").val();
var scheduleType = $("#schedule_type").val();
var bundleType = $("#bundle_type").val();
var hour = $("#hour").val();
var minutes = $("#minutes").val();
var ampm = $("#AP").val();
var recursiveStatus = $('input:radio[name=recur]:checked').val();
var activeStatus = $('input:radio[name=active]:checked').val();
var classCapacity = $("#capacity").val();
var classMinutes = $("#classMinutes").val();
var instructorId = $("#instructor").val();
var roomId = $("#room").val();
var scheduleId = $("#schedule_id").val();
var eventDate = "";
var dayWeek = "";
var dayArray = "";
var timeStart = "";
var bundleName = "";


if(scheduleType == "") {
  alert('Please select a \"Schedule Category\"');
         return false;
   }

if(bundleType == "") {
  alert('Please select a \"Class Type\"');
         return false;
   }


if($('.accessDay:checkbox:checked').length == 0) {
  alert('Please check at least one \"days of class\" check box');
          return false;          
   }else{      
   $('.accessDay:checkbox:').each(function() {
        if(this.checked) {
           dayWeek = $(this).val();
          }else{
           dayWeek = 0;
          }          
         dayArray += dayWeek
       });       
    }


if(hour == "") {
  alert('Please select the \"Hour\" for this class');
         return false;
  }

if(minutes == "") {
  alert('Please select the \"Minutes\" for this class');
         return false;
  }


if(recursiveStatus == "N") {
   eventDate = $("#datepicker").val();
        if(eventDate == "") {
           alert('Please provide a date for this session');
                   return false;
          }else{
          var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
                   if(!(date_regex.test(eventDate))) {
                     alert('The date you entered is not in the correct format.  Please use \"mm/dd/yyyy\" ');
                            return false;
                     }                    
          }
  }


if(classCapacity == "") {
   alert('Please enter the capacity for this class');
           return false;
  }else{
         if(isNaN(classCapacity)) {
           alert('Please use numbers only in the \"Capacity\" field');
                   return false;
          }
  }


if(classMinutes == "") {
   alert('Please enter the minutes for this class');
           return false;
  }else{
         if(isNaN(classMinutes)) {
           alert('Please use numbers only in the \"Minutes of Class\" field');
                   return false;
          }
  }


if(instructorId == "") {
   alert('Please select an instructor for this class');
          return false;
  }

if(roomId == "") {
   alert('Please select a room for this class');
          return false;
  }


if(addEdit == "A") {
   ajaxSwitch = 1;
   }else if(addEdit == "E") {
   ajaxSwitch = 2;
   }


$("#bundle_type > option").each(function() {
     if(this.selected == true) {
        bundleName = this.text;   
        }     
  });


$.ajax ({
                type: "POST",
                url: "addEditSchedules.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_type: bundleType, class_hour: hour, class_minutes: minutes, am_pm: ampm, recursive_status: recursiveStatus, active_status: activeStatus, class_capacity: classCapacity, session_minutes: classMinutes, event_date: eventDate, day_array: dayArray, instructor_id: instructorId, room_id: roomId, schedule_id: scheduleId},               
                     success: function(data) {  
                  //alert(data);
                     var dataArray = data.split('|');
                     var successBit = dataArray[0];                           

                       if(ajaxSwitch == 1) {
                          if(successBit == 1) {
                                                        
                                  alert('Schedule for '+bundleName+ ' successfully saved.');
                                  loadScheduleList(bundleType, scheduleType);
                                  $("#form").trigger('reset'); 
                          
                            }else{
                            alert(data);
                            }
                                              
                        }
                         
 
                       if(ajaxSwitch == 2) {
                          if(successBit == 1) {
                                                               
                                 resetFormFields();
                               
                                  alert('Schedule for '+bundleName+ ' successfully Updated.');
                                  loadScheduleList(bundleType, scheduleType);
                          
                            }else{
                            alert(data);
                            }
                                              
                        } 
 
 

                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
$("#bundle_type").live("change", function(event) {

var addEdit = 'A';
var scheduleType = $("#schedule_type").val();
var bundleType = $("#bundle_type").val();

$("#addEdit").val(addEdit);
$("#form").trigger('reset');
$("#button1").val('Add Schedule');
$("#schedule_id").val("");
$("#hour").val("");
$("#minutes").val("");
$("#AP").val("");
$("#instructor").val("");
$("#room").val("");

//takes care of recursive radios
var recursive = 'Y';
      $('input:radio[name=recur]').each(function() {
            if($(this).val() == recursive) {
               $(this).attr('checked','checked'); 
               $("#datePick").hide();
               }
        });
//takes care of active status
var active = 'Y';
      $('input:radio[name=active]').each(function() {
            if($(this).val() == active) {
               $(this).attr('checked','checked'); 
               }
        });
        
        
    if(bundleType != "") {
      loadScheduleList(bundleType, scheduleType);
      }else{
      $("#classList").html("");
      }


}); 
//----------------------------------------------------------------
$(".recursiveTwo").click(function() {
    if( $('.recursiveTwo:checked').length > 0 ) {
        $("#datePick").show("slow");
    } else {
        $("#datePick").hide();
    }
}); 
//----------------------------------------------------------------
$(".recursiveOne").click(function() {
    if( $('.recursiveOne:checked').length > 0 ) {
        $("#datepicker").val("");
        $("#datePick").hide();
       } 
}); 
//---------------------------------------------------------------

});











