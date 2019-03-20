$(document).ready(function(){
//----------------------------------------------------------
function loadClassList(scheduleType, eventDate)  {

var ajaxSwitch =1;


$.ajax ({
                type: "POST",
                url: "schedule/loadClassList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, event_date: eventDate},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     
                          if(successBit == 1) {                             
                             $("#classList").html(listings);
                             $("#listings").tablesorter();
                             $('#listings.tablesorter').tablesorter({
                                scrollHeight: 385,
                                widgets: ['scroller']
                               });                 
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 

}
//--------------------------------------------------------------
function loadClassOptionsTwo(scheduleType, clubId, className, barCodeType, groupType, firstName, lastName, phone, email) {

var ajaxSwitch = 1;
     className = className.trim();
     
  //takes non member member radios
  var memType = 'N';
      $('input:radio[name=active]').each(function() {
            if($(this).val() == memType) {
               $(this).attr('checked','checked'); 
               }
        });     

//var test =('Scedule Type: '+scheduleType+'\n Club ID: '+clubId+'\n ClassName: '+className+'\n Barcode Type: '+barCodeType);

//alert(test);
//return false;

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
                     
                          if(successBit == 1) {                             
                             $("#classOptions").html(listings);
                             $("#sm_fname").val(firstName);
                             $("#sm_lname").val(lastName);
                             $("#sm_email").val(email);
                             $("#sm_phone").val(phone);
                              
                            }else if(successBit == 2) {
                            alert('A bundle class does not exist for this service. Please set this up in the administration interface in order to display class pricing');
                              
                            }else{
                            alert(data);                            
                            }                     
                                          
                     }//end function success
                 }); //end ajax 


}
//----------------------------------------------------------
$('#form1').submit(function() {


var actionType = $("#bookClass").val();
var memberId = $('#memberId').val();
var scheduleId = $("#schedule_id").val();
var bundleId = $("#bundle_id").val();
var classDate = $("#datepicker").val();
var classText = $("#class_text").val();
var typeId = $("#type_id").val();
var locationId  = $("#location_id").val();
var className = $("#class_name").val();
var timeSlot = $("#time_slot").val();
var groupType = "";
var groupTypeTwo = "";
var ajaxSwitch = 1;
var groupTypeText = "";
         
        
      //check for guest pass
       var guestSalt = memberId.charAt(0);
              if(guestSalt == 'G') {
                 memberId = memberId.substr(1);
                }       
       var taSalt = memberId.charAt(0);
              if(taSalt == 'T') {
                 memberId = memberId.substr(1);
                 
                }        
         

 if(memberId== "") {
           alert('Please fill out the Member ID Number field');
           $("#memberId").focus();
           return false;
           }
 if(memberId == "0") {
           alert('The Member ID  field cannot be set to zero');
           $("#memberId").focus();
           return false;
           }         
if(isNaN(memberId)) {
           alert('The Member ID Number field may only contain numbers');
           $("#memberId").focus();
           return false;
           }
if(memberId.length < 4) {
           alert('The Member ID Number number is too short');
           $("#memberId").focus();
           return false;
           }

//checks to see if this is a cancel then chanes the ajax switch
if(actionType == 'Cancel Class') {
   ajaxSwitch = 2;
   }


//alert(taSalt+' sfd '+memberId);
$.ajax ({
                type: "POST",
                url: "schedule/bookClass.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, member_id: memberId, schedule_id: scheduleId, bundle_id: bundleId, class_date: classDate, type_id: typeId, location: locationId, time_slot: timeSlot, ta_salt: taSalt},               
                     success: function(data) {  
             // alert(data);
                              var dataArray = data.split('|');                        
                              var successBit = dataArray[0]; 
                              var bookingCount = dataArray[1];
                              var memberType = dataArray[2];
                              var bookingStatus = dataArray[3];                              
                                    groupType = dataArray[4];
                              var firstName = dataArray[5]; 
                              var lastName = dataArray[6]; 
                              var phone = dataArray[7]; 
                              var email = dataArray[8];
                                                            
                              
                              //set booking count
                              $('#booking_count').val(bookingCount);
                                                                 
                          if(successBit == 1) {   
                          
                             alert(classText+ ' successfully booked');
                                     $('#memberId').val("");
                                     $('#memberId').focus();
                                       loadClassList(typeId, classDate);
                                     
                                       if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time');
                                                 $("#masking").hide(500);
                                                 $("#bookWindow").hide(500);
                                         }
                                        
                                     
                            }else if(successBit == 2) {
                                        $('#memberId').val("");
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show(); 
                                           
                                           if(groupType == "") {
                                              groupTypeTwo = 'S';
                                             }
                                           
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');   
                                          }     
                                                 loadClassList(typeId, classDate);                                                                                       
                                                 loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                                 
                                              
                                         alert('There are no records associated with this member id');     
                                                
                             }else if(successBit == 3) { 
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show();                                         
                                                         
                                           if(guestSalt == 'G') {
                                             $('#memberId').val("");
                                             }
                                                                                                              
                                           if(memberType == 'G') {
                                              memberType = 'N';
                                             }
                                           
                                           if(groupType == 'S' || groupType == 'F') {
                                             groupTypeTwo = 'S';
                                             }                                             
                                                   
                                           if(groupType == "") {
                                             groupTypeTwo = 'S';
                                             }
                                             
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');   
                                          }                                          
                                               loadClassList(typeId, classDate);                    
                                               loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                                
                                                alert(classText+ ' have expired.  Use the form below to purchase more classes.');
                             
                           
                              }else if(successBit == 4) { 
                                               loadClassList(typeId, classDate);
                                                alert('This class has already been booked by this member');   
                                        
                                        
                              }else if(successBit == 5) {          
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show();                                         
                                        
                                           if(guestSalt == 'G') {
                                             $('#memberId').val("");
                                             }
                                                                                
                                           if(memberType == 'G') {
                                               memberType = 'N';
                                              }
                                                                                                
                                           if(groupType == 'S' || groupType == 'F') {
                                              groupTypeTwo = 'S';
                                             }    
                                             
                                           if(groupType == "") {
                                             groupTypeTwo = 'S';
                                             }
                                  
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');   
                                          }                                   
                                               loadClassList(typeId, classDate);
                                               loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                        
                                                alert(classText+ ' service does not exist for this member.  Use the form below to purchase classes.');
                              
                              }else if(successBit == 6) {          
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show();                                         
                                        
                                           if(guestSalt == 'G') {
                                             $('#memberId').val("");
                                             }
                                                                                
                                           if(memberType == 'G') {
                                               memberType = 'N';
                                              }
                                                                                                
                                           if(groupType == 'S' || groupType == 'F' || groupType == 'B' || groupType == 'O' ) {
                                              groupTypeTwo = 'S';
                                             }    
                                             
                                           if(groupType == 'B') {
                                              groupTypeText = 'Business Member.';
                                             }
                                             
                                           if(groupType == 'O') {
                                              groupTypeText = 'Organization Member.';
                                             }                                             
                                             
                                           if(groupType == "") {
                                             groupTypeTwo = 'S';
                                             }
                                  
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');   
                                          }                                   
                                               loadClassList(typeId, classDate);
                                               loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                        
                                                alert(classText+ ' service has reached the quota for this '+groupTypeText+'  Use the form below to purchase classes.');                                
                                
                              }else if(successBit == 7) {
                                
                                   alert('There are no services associated with this member Id');
                                                                      
                              }else if(successBit == 8) {   
                                   
                                   alert(classText+ ' has not been booked for this member Id');
                                   
                              }else if(successBit == 9) {     
                              
                                          loadClassList(typeId, classDate);                              
                                          alert(classText+ ' has been successfully canceled for this member Id');
                                          
                              }else if(successBit == 10) {            
                                       
                                   alert('This class date and time is greater than the end date for this guest pass');
                                       
                              }else if(successBit == 11) {            
                                       
                                   alert('This class cannot be canceled because it is less than 24 hrs until the class time');
                                       
                              }else if(successBit == 12) {            
                                       
                                   alert('This member has recieved the maximun number of Training Assesments!');
                                       
                              }else{
                             alert(data);                             
                             }
                                          
                     }//end function success
                 }); //end ajax 

return false;

 });
 //-------------------------------------------------------
});