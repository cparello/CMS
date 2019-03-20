$(document).ready(function(){
//---------------------------------------------------------------------------------------
function loadRoster() {

window.open('schedule/rosterWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------------------------------
function loadClassBlurb(className, classDate, timeSlot) {

className = className.trim();
timeSlot = timeSlot.trim();

var classBlurb = (className+ ' at ' +timeSlot+ ' on ' +classDate);

$("#class_text").val(classBlurb);

}
//---------------------------------------------------------------------------------------
function resetFormFields() {

  //takes non member member radios
  var memType = 'M';
      $('input:radio[name=active]').each(function() {
            if($(this).val() == memType) {
               $(this).attr('checked','checked'); 
               }
        });

  $("#memberId").val("");
  $("#card_type").val("");
  $("#bank_name").val("");
  $("#card_name").val("");
  $("#account_type").val("");
  $("#card_number").val("");
  $("#account_name").val("");
  $("#card_cvv").val("");
  $("#account_num").val("");
  $("#card_month").val("");
  $("#card_year").val("");
  $("#aba_num").val("");
  $("#credit_pay").val("");
  $("#ach_pay").val("");
  $("#cash_pay").val("");
  $("#check_pay").val("");
  $("#check_number").val("");
  $("#sm_fname").val(""); 
  $("#sm_lname").val("");
  $("#sm_email").val("");
  $("#sm_phone").val("");
  $("#booking_count").val("");
  $("#purchase_marker").val("");


}
//----------------------------------------------------------------------------------------
function loadClassOptions(scheduleType, clubId, className, barCodeType, groupType) {

var ajaxSwitch = 1;
     className = className.trim();

$.ajax ({
                type: "POST",
                url: "schedule/loadClassOptions.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, club_id: clubId, search_string: className, bar_code_type: barCodeType, group_type: groupType},               
                     success: function(data) {  
                     
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     alert(successBit);
                          if(successBit == 1) {                             
                             $("#classOptions").html(listings);
                                        
                            }else if(successBit == 2) {
                            alert('A bundle class does not exist for this service. Please set this up in the administration interface in order to display class pricing');
                              
                            }else{
                            alert(data);                            
                            }                                    
                                          
                     }//end function success
                 }); //end ajax 


}
//---------------------------------------------------------------------------------------
$("input:radio[name=active]").click(function() {

var scheduleTypeArray = $("#schedule_type").val();
      scheduleTypeArray = scheduleTypeArray.split(",");
var scheduleType = scheduleTypeArray[0];
var clubId = scheduleTypeArray[1];
var className = $("#class_name").val();
var barCodeType = $(this).val();
var groupType = 'S';
            
            if($(this).val() == 'M') {
              $("#memField").show("slow");
              $("#memberId").focus();
                 resetFormFields();
              $("#classOptions").hide();
              $("#paymentWindow").hide();
              $("#nmInfo").hide();
                 
              }else{              
              $("#memField").hide();
              $("#classOptions").show("slow");
              $("#paymentWindow").show("slow");
              $("#nmInfo").show();              
              loadClassOptions(scheduleType, clubId, className, barCodeType, groupType);
              }
               
});
//---------------------------------------------------------------------------------------
$('.book').live("click",function() { 

   var idArray =  $(this).attr("id");
   var timeSlot  = $(this).closest('tr').find('td:eq(0)').text();
         timeSlot = timeSlot.trim();
   var className = $(this).closest('tr').find('td:eq(1)').text();
   var classDate = $("#datepicker").val();
   var classText = (className+ '&nbsp;&nbsp;&nbsp;&nbsp;'+classDate+'&nbsp;&nbsp;' +timeSlot);
   var typeText = 'Book Class:';
   
   
   //split the id array to get the schedule id and the bundle id
     idArray = idArray.split(" ");
     var scheduleId = idArray[0];
     var bundleId = idArray[1];
           $("#schedule_id").val(scheduleId);
           $("#bundle_id").val(bundleId);
           $("#time_slot").val(timeSlot);
             loadClassBlurb(className, classDate, timeSlot);

       $("#bookClass").attr('value', 'Book Class');
       $("#radioMN").show();
       $("#bookCancel").html(typeText);           
       $("#classType").html(classText);
       $('#class_name').val(className);
       $("#masking").show(500);
       $("#bookWindow").show(500);
       $("#memberId").focus();

    
});   
//---------------------------------------------------------------------------------------
$('.cancel').live("click",function() { 

   var idArray =  $(this).attr("id");
   var timeSlot  = $(this).closest('tr').find('td:eq(0)').text();
         timeSlot = timeSlot.trim();
   var className = $(this).closest('tr').find('td:eq(1)').text();
   var classDate = $("#datepicker").val();
   var classText = (className+ '&nbsp;&nbsp;&nbsp;&nbsp;'+classDate+'&nbsp;&nbsp;' +timeSlot);
   var typeText = 'Cancel Class:';
   
   //split the id array to get the schedule id and the bundle id
     idArray = idArray.split(" ");
     var scheduleId = idArray[1];
     var bundleId = idArray[2];
           $("#schedule_id").val(scheduleId);
           $("#bundle_id").val(bundleId);
           $("#time_slot").val(timeSlot);
             loadClassBlurb(className, classDate, timeSlot);   
             
       $("#bookClass").attr('value', 'Cancel Class');
       $("#radioMN").hide();
       $("#bookCancel").html(typeText);
       $("#classType").html(classText);
       $('#class_name').val(className);
       $("#masking").show(500);
       $("#bookWindow").show(500);
       $("#memberId").focus();   


});  
//--------------------------------------------------------------------------------------
$('.print').live("click",function() { 

   var ajaxSwitch = 1;
   var idArray =  $(this).attr("id");
   var timeSlot  = $(this).closest('tr').find('td:eq(0)').text();
         timeSlot = timeSlot.trim();
   var className = $(this).closest('tr').find('td:eq(1)').text();
   var instructor = $(this).closest('tr').find('td:eq(2)').text();
   var room = $(this).closest('tr').find('td:eq(5)').text();
   
   var classDate = $("#datepicker").val();
   var classText = (className+ '&nbsp;&nbsp;&nbsp;&nbsp;'+classDate+'&nbsp;&nbsp;' +timeSlot);

   //split the id array to get the schedule id and the bundle id
     idArray = idArray.split(" ");
     var scheduleId = idArray[1];
     var bundleId = idArray[2];
           $("#schedule_id").val(scheduleId);
           $("#bundle_id").val(bundleId);
           $("#time_slot").val(timeSlot);
           
             loadClassBlurb(className, classDate, timeSlot); 

           $('#class_name').val(className);

     var typeId = $("#type_id").val();
     var locationId = $("#location_id").val();
     var classText = $("#class_text").val();
     
 
 $.ajax ({
                type: "POST",
                url: "schedule/loadScheduleSession.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, type_id: typeId, schedule_id: scheduleId, bundle_id: bundleId, location: locationId, class_date: classDate, time_slot: timeSlot, class_text: classText, class_name: className, instructor_name: instructor, room_name: room},               
                     success: function(data) {  

                         if(data == 1) {
                            loadRoster();           
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 

}); 
//--------------------------------------------------------------------------------------
$('.close').click(function() { 

       $("#masking").hide(500);
       $("#bookWindow").hide(500);
          resetFormFields();
       $("#memField").show();
       $("#classOptions").hide();
       $("#paymentWindow").hide();
       $("#nmInfo").hide();   
        
 });
 //--------------------------------------------------------------------------------------
 $('.closeTwo').click(function() { 

       $("#masking").hide(500);
       $("#bookWindow").hide(500);
        
 });
 //---------------------------------------------------------------------------------------
 });