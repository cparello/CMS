$(document).ready(function() {
//---------------------------------------------------------
function loadScheduleListTwo(bundleType, scheduleType) {

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
//----------------------------------------------------------
function parseAccessDays(dayString) {

var stringArray = dayString.split("");
var sun = stringArray[0];
var mon = stringArray[1];
var tue = stringArray[2];
var wed = stringArray[3];
var thur = stringArray[4];
var fri = stringArray[5];
var sat = stringArray[6];


$('.accessDay:checkbox:').each(function() {
     dayWeek = $(this).val();
           
        if(dayWeek == sun) {
            this.checked = true;
           }
        if(dayWeek == mon) {
            this.checked = true;
           }           
        if(dayWeek == tue) {
            this.checked = true;
           }            
        if(dayWeek == wed) {
            this.checked = true;
           }    
        if(dayWeek == thur) {
            this.checked = true;
           }    
        if(dayWeek == fri) {
            this.checked = true;
           }    
        if(dayWeek == sat) {
            this.checked = true;
           }    
           
  });       
}
//---------------------------------------------------------
function parseClassTimes(classTime) {

       //takes care of hour first
       var timeArrayOne = classTime.split(":");    
       var hourNum =  timeArrayOne[0];    
       var hour = (hourNum+':');
       
       //take care of minutes
       var minutePm = timeArrayOne[1];
       var minutePmArray = minutePm.split(" ");
       var minutes = minutePmArray[0];             
             if(minutes == '00') {
                minutes = '0';
                }
             if(minutes == '05') {
                minutes = '5';
                } 

       //take care of am pm
       var ampm = minutePmArray[1];
         
    $('#hour option').each(function(){    
        if($(this).val() == hour)
            $(this).attr('selected','selected');            
       });
       
    $('#minutes option').each(function(){    
        if($(this).val() == minutes)
            $(this).attr('selected','selected');            
       });

    $('#AP option').each(function(){    
        if($(this).val() == ampm)
            $(this).attr('selected','selected');            
       });

}
//---------------------------------------------------------
function parseRecursiveDate(recursive, classDate) {

       $('input:radio[name=recur]').each(function() {
            if($(this).val() == recursive) {
               $(this).attr('checked','checked'); 
               }
             
            if(recursive == 'N') {
              $("#datePick").show("slow");
              $("#datepicker").val(classDate);
              }else{
              $("#datePick").hide();
              }
               
          });
}
//---------------------------------------------------------
function parseInstructor(instructor) {

    $('#instructor option').each(function(){    
        if($(this).val() == instructor)
            $(this).attr('selected','selected');            
       });

}
//---------------------------------------------------------
function parseRoom(room) {

    $('#room option').each(function(){    
        if($(this).val() == room)
            $(this).attr('selected','selected');            
       });

}
//---------------------------------------------------------
function parseActiveStatus(activeStatus) {

       $('input:radio[name=active]').each(function() {
            if($(this).val() == activeStatus) {
               $(this).attr('checked','checked'); 
               }
         });      
}
//---------------------------------------------------------
$(".button2").live("click", function() {

var ajaxSwitch = 2;
var scheduleId = this.id;
var buttonType = this.value;
var dayWeek = null;
    
 $(this).closest('tr').css('backgroundColor', '#ffdc87');
 $(this).closest('tr').siblings().css('backgroundColor', '');

//---------------------------------------------------------------------------------------------------------
if(buttonType == 'Edit') {

   var addEdit = 'E';
         $("#addEdit").val(addEdit);
         $("#button1").val('Edit Schedule');
         $("#schedule_id").val(scheduleId);
         
        
$.ajax ({
                type: "POST",
                url: "loadScheduleList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_id: scheduleId},               
                     success: function(data) {  
                     
                         var dataArray = data.split("|");
                         var successBit = dataArray[0];
                         var dayString = dataArray[1];
                         var classTime = dataArray[2];
                         var recursive = dataArray[3];
                         var classDate = dataArray[4];
                         var capacity = dataArray[5];
                         var minutes = dataArray[6];
                         var instructor = dataArray[7];
                         var room = dataArray[8];
                         var activeStatus = dataArray[9];
         
                               $('.accessDay:checkbox:').each(function() {
                                    this.checked = false;
                                  });
         
                               parseAccessDays(dayString);
                               parseClassTimes(classTime);
                               parseRecursiveDate(recursive, classDate);
                               parseInstructor(instructor);
                               parseRoom(room);
                               parseActiveStatus(activeStatus);
                              $("#classMinutes").val(minutes);
                              $("#capacity").val(capacity);
               
                                  if(successBit  != 1) {
                                     alert('The following error occurred: ' +data);
                                    }                     
                                          
                     }//end function success
                 }); //end ajax          
                        
}
//--------------------------------------------------------------------------------------------------------------
if(buttonType == 'Delete') {

      ajaxSwitch = 3;
var bundleName = "";
var bundleType = $("#bundle_type").val();
var scheduleType = $("#schedule_type").val();
var timeSlot  = $(this).closest('tr').find('td:eq(1)').text();
      timeSlot = $.trim(timeSlot);
var dayWeek = $(this).closest('tr').find('td:eq(0)').text();


$("#bundle_type > option").each(function() {
     if(this.selected == true) {
        bundleName = this.text;   
        }     
  });
  
var answer = confirm('This will permantly delete the '+timeSlot+' for '+bundleName+'. Do you wish to continue?');
if (!answer) {
return false;

}else{


 $.ajax ({
                type: "POST",
                url: "addEditSchedules.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, schedule_id: scheduleId},               
                     success: function(data) { 
                        
                          if(data == 1) {
                             alert(timeSlot+' time slot for '+bundleName+' successfully deleted');
                                    loadScheduleListTwo(bundleType, scheduleType);
                            }else{
                             alert('There was an error deleting this Class Schedule: '+data);
                            }
                      
                         }//end function success
                 }); //end ajax 

}






}


return false;

});
//---------------------------------------------------------------
});
