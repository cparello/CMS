$(document).ready(function() {
//----------------------------------------------------------------
$("#day").change( function() {

var ajaxSwitch = 1;
var clubId = $("#location").val();
var day = $("#day").val();
var dayText = $("#day:selected").text();
//alert(clubId);
$.ajax ({
                type: "POST",
                url: "loadHoursDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, day: day, clubId: clubId},               
                     success: function(data) {  
//alert(data);
                     var dataArray = data.split('|');
                     var successBit = dataArray[0];
                     var hourDrop = dataArray[1];
                     var userId = dataArray[2];
                     var name = dataArray[3];
                     var clubName = dataArray[4];
                                          
                       if(successBit == 1) {
                                                                             
                                       $("#time").html(hourDrop);
                                       $("#user_id").val(userId);
                                       $("#emp_name").val(name);
                                        $("#club_name").val(clubName);
                         }
                         
                         

                         }//end function success
                 }); //end ajax 



});
//---------------------------------------------------------------
$("#bookVisit").live("click", function(event) {
//alert('fu');
//check to see if the form fields are filled out
var name = $("#name").val();
var phone= $("#phone").val(); 
var location = $("#location").val();

var time = $("#time").val();
var dataArray = time.split('@');
var time = dataArray[0];
var timeFormatted = dataArray[1];

var day = $("#day").val();
var userId = $("#user_id").val();
var clubName =  $("#club_name").val();


if(name == "") {
   alert('Please supply a \"Name\"');
           return false;
   }
   
if(location == "") {
   alert('Please supply a \"Location\"');
           return false;
   }

if(time == "") {
   alert('Please supply a \"Time\"');
           return false;
   }   
  // alert(time);
   
//take care of phone and reformat if needed
if(phone == "") {
   alert('Please supply a \"Phone\" number');
           return false;
   }
phone = phone.replace(/\s+/g, " ");
var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phone)) {
    var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
        $("#phone").val(formattedPhoneNumber);       
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               $("#phone").focus();
               return false;               
    }
       

//alert(location);         
         
//alert(confirmEmail);
//now we send this off to save
var ajaxSwitch = 1;

$.ajax ({
                 type: "POST",
                 url: "scheduleApointment.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, userId: userId, time: time, name: name, phone: phone},               
                 success: function(data) {    
  // alert(data);                  
                 
                        if(data == 1) {
                            var name = $("#emp_name").val();
                            alert('Appointment Scheduled with '+name+' on '+timeFormatted+' at '+clubName+'');                
                          }
                                                                           
                     }//end function success
              }); //end ajax 


 });
 //=====================================================================================
});