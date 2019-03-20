$(document).ready(function(){

var barCode = "";

$(window).load(function () {
  $("#id_card").focus();  
  
  var confMessage = $("#confirmation_message").val();
  var data = "";
         if(confMessage != "") {
            alert(confMessage);
            $("#iconfirmation_message").val("");
            
            }
  
  
   });
//---------------------------------------------------------
$('#form1').submit(function() {
  
var adjustBool =  $('#adjust_bool').val();
var idCard = $('#id_card').val();


 if(idCard == "") {
           alert('Please fill out the Employee ID Number field');
           $("#idCard").focus();
           return false;
           }
 if(idCard == "0") {
           alert('The Employee ID Number field cannot be set to zero');
           $("#idCard").focus();
           return false;
           }         
if(isNaN(idCard)) {
           alert('The Employee ID Number field may only contain numbers');
           $("#idCard").focus();
           return false;
           }
if(idCard.length < 4) {
           alert('The Employee ID Number number is too short');
           $("#idCard").focus();
           return false;
           }
  
if(adjustBool == 'N') {

  $.ajax ({
                 type: "POST",
                 url: "employeeTimeClock.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_card: idCard},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Invalid Employee ID Card');
                       }else{  
                
                        var dataArray = data.split("|");
                        var empName = dataArray[0];
                        var empPhoto = dataArray[1];
                        var empNumber = dataArray[2];
                        var jobDesc = dataArray[3];
                        var clockStatus = dataArray[4];
                        var clockTime = dataArray[5];
                   
                        $('#empName').html(empName);
                        $('#empPhoto').html(empPhoto);
                        $('#empNumber').html(empNumber);                        
                        $('#jobDesc').html(jobDesc);                        
                        $('#clockStatus').html(clockStatus);            
                        $('#clockTime').html(clockTime);                                               
                      }
                                             
                     }//end function success
              }); //end ajax 
              
              $('#adjust_bool').val('N');

    }else{
                  var timeLine = 2;
    
     $.ajax ({
                 type: "POST",
                 url: "editTimeClockTwo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_card: idCard, time_line: timeLine},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Invalid Employee ID Card');
                       }else{  
                       $('#employeeContent').html(data);
                                                 
                       }
                                             
                     }//end function success
              }); //end ajax 
              
             $('#adjust_bool').val('Y');
        
    }
    
 $("#id_card").val("");   
 
return false; 
  
   
});   
//-------------------------------------------------------- 
$("#overide_pin").focus(function () {

 var overidePin = $("#overide_pin").val();
       if(overidePin == "Enter Manager Pin Number") {
          $("#overide_pin").val("");
          $('#overide_pin')[0].type = 'password'; 
          }
 
   
});
//--------------------------------------------------------
$('#overide_pin').keyup(function() { 

   var overidePin = $("#overide_pin").val();
   var adjustBool;
         if(overidePin.length == "4") {

     $.ajax ({
                 type: "POST",
                 url: "../sales/checkPin2.php",
                 cache: false,
                 dataType: 'html', 
                 data: {pin: overidePin},               
                 success: function(data) {    
                 
                 if(data == 1) {
                      alert('You have entered an invalid PIN number');
                              $("#overide_pin").val("");
                                 var adjustBool = "N";
                              $('input[id=adjust_bool]').val(adjustBool);
                   }
                 
                 if(data == 2) {
                       var adjustBool = "Y";
                   $('input[id=adjust_bool]').val(adjustBool);
                 
                   }
                 
                      }//end function success
               }); //end ajax 

            }
});   
//--------------------------------------------------------------------------------------------   
   
   
   
   
   
   
   
});   