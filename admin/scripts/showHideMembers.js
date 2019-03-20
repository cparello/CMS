$(document).ready(function(){

//----------------------------------------------------------
 $('.closeFour').live("click", function() {

      $("#masking").hide(500);
      $("#holdWindow").hide(500);
       
      $("#mem_member_key").val("");
      $("#mem_member_id").val("");
      $("#mem_member_name").val("");
      $("#mem_contract_key").val(""); 
      $("#hold_message").val("");
      
      
      var manText ='Enter Manager Pin Number';
      var adjustBool ='N';
            $("#overide_pin").val(manText);
            $("#adjust_bool").val(adjustBool);
 });
//--------------------------------------------------
$('.showHideTwo').live("click", function(event){
    
        var trigger = event.target;
              $(trigger).closest('tr').next('.hiddenTR').toggle(100);

}); 
//-----------------------------------------------------
$('.holdMem').live("click", function(e){
    
     var memberKey = $(this).attr('data-memberKey'); 
     var memberName = $(this).attr('data-memberName');
     var contractKey = $(this).attr('data-contractKey');
     
     var memberElementId = $(this).attr('data-memberElementId');
     var memberElementId = ('#' +memberElementId);
     var memberId = $(memberElementId).val();
          
     if(memberName == 'NA') {
       alert('Please setup a membership for this account');
       return false;
       }
       
     if(memberId == '0') {
       alert('Please create a \"Member ID\" for this member');
       return false;
       }     

      $("#mem_member_key").val(memberKey);
      $("#mem_member_id").val(memberId);
      $("#mem_member_name").val(memberName);
      $("#mem_contract_key").val(contractKey);

      var closeWin = (memberName+ '<span class="closeFour">X</span>'); 

      $("#memHoldName").html(closeWin);
      $("#memHoldId").text(memberId);

       var offset = $(this).offset(); 
       var offsetTop = offset.top - 230;
            
     $("#masking").show(500);     
     $("#holdWindow").css('left',offset.Left);    
     $("#holdWindow").css('top',offsetTop);
     $("#holdWindow").show(500);

}); 
//-----------------------------------------------------
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
//-----------------------------------------------------
$('#form3').submit(function(e) {

var adjustBool = $('#adjust_bool').val();
var memberKey = $("#mem_member_key").val();
var memberId = $("#mem_member_id").val();
var memberName = $("#mem_member_name").val();
var contractKey = $("#mem_contract_key").val();
var holdMessage = $("#hold_message").val();      
      
if(adjustBool == 'N') {
  alert('Please enter a valid manager pin number');
         return false;
         }

 if(holdMessage == "") {
           alert('Please fill out the \"Hold Reason\" text area');
           $("#hold_message").focus();
           return false;
           }

holdMessage = holdMessage.replace(/[^\.\! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
holdMessage = encodeURIComponent(holdMessage);

    $.ajax ({
                 type: "POST",
                 url: "processMemberHold.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {contract_key: contractKey, mem_member_key: memberKey, mem_member_id: memberId, mem_member_name: memberName, hold_message: holdMessage},              
                 success: function(data) {    

                    if(data == 1) {
                             window.location.href = ('viewAccountInfo.php?contract_key=' +contractKey);
                              }else{
                              alert('There was an error processing this transaction' +data);                                      
                              }
                                                                                  
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      
           
 e.preventDefault();    


}); 
//------------------------------------------------------
$('.memNotes').live("click", function(e){
    
     var memberKey = $(this).attr('data-memberKey'); 
     var memberName = $(this).attr('data-memberName');
     var contractKey = $(this).attr('data-contractKey');
     
     var memberElementId = $(this).attr('data-memberElementId');
     var memberElementId = ('#' +memberElementId);
     var memberId = $(memberElementId).val();
     var noteButtonId= $(this).attr('id');
     var ajaxSwitch = 1;
                 
          
     if(memberName == 'NA') {
       alert('Please setup a membership for this account');
       return false;
       }
       
     if(memberId == '0') {
       alert('Please create a \"Member ID\" for this member');
       return false;
       }     

   $.ajax ({
                 type: "POST",
                 url: "../utilities/memberNotesTwo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, member_key: memberKey, contract_key: contractKey, member_id: memberId, member_name: memberName, note_button_id: noteButtonId},              
                 success: function(data) {    
                 
                     $("#memberNotes").html(data);
                                                                                  
                     }//end function success
              }); //end ajax              


       var offset = $(this).offset(); 
       var offsetTop = offset.top - 320;
            
     $("#masking").show(500);     
     $("#memberNotes").css('left',offset.Left);    
     $("#memberNotes").css('top',offsetTop);
     $("#memberNotes").show(500);

}); 
//------------------------------------------------------
$(".prioType").live("click", function(){

    var colorId = this.id;
    
  switch(colorId)  {
         case 'low':
         $("#yellow3").show(50);
         $("#orange3").hide();
         $("#red3").hide();
         break;
         case 'medium':
         $("#orange3").show(50);
         $("#yellow3").hide();
         $("#red3").hide();
         break; 
         case 'high':
         $("#red3").show(50);
         $("#orange3").hide();
         $("#yellow3").hide();
         break;          
         }     

 });
//------------------------------------------------------
 $('.closeFive').live("click", function() {
 
      $("#masking").hide(500);
      $("#memberNotes").hide(500);
  
 });
//-------------------------------------------------------
$('.saveMemberNoteTwo').live("click", function() { 


var priorityVal = $("input[name='priority_two']:checked").val();
var targetVal = $("#target_app_two").val();
var noteTopicVal = $("#topic_two").val();
var noteMessageVal = $("#message_two").val();
var fromApp = 'MI';
var contractKey = $("#contract_key_notes").val();
var memberKey = $(this).attr('data-memberKey'); 
var memberName = $(this).attr('data-memberName');
var noteButtonId = $(this).attr('data-noteButtonId');
var ajaxSwitch = 2;

//alert('Priority: ' +priorityVal+ '\nTarget: ' +targetVal+ '\nTopic: ' +noteTopicVal+ '\nMessage: ' +noteMessageVal+ '\nFrom App: ' +fromApp+ '\nContract Key: ' +contractKey+ '\nMember Key: ' +memberKey+ '\nMember Name: ' +memberName+ '\nAjax Switch: ' +ajaxSwitch+ '\nNote Button ID: ' +noteButtonId);


     if(noteTopicVal == "") {           
        alert('Please Enter a Note Topic');
        $("#topic_two").focus();
        return false;
        }

     if(noteMessageVal == "") {           
        alert('Please Enter a Message');
        $("#message_two").focus();
        return false;
        }
        
        
//sets for confirmation message
var confirmationTopic = noteTopicVal;

//clean out any special chars
noteTopicVal = noteTopicVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
noteMessageVal = noteMessageVal.replace(/[^\.\! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');

//here we enter the ajax code to send the message
if(priorityVal != "" && targetVal != "" && noteTopicVal != "" && noteMessageVal != "") {

  priorityVal = encodeURIComponent(priorityVal);
  targetVal = encodeURIComponent(targetVal);
  noteTopicVal = encodeURIComponent(noteTopicVal);
  noteMessageVal = encodeURIComponent(noteMessageVal);


    $.ajax ({
                 type: "POST",
                 url: "../utilities/memberNotesTwo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, priority: priorityVal, target_app: targetVal, message: noteMessageVal, topic: noteTopicVal, from_app: fromApp, contract_key: contractKey, member_key: memberKey, member_name: memberName, note_button_id: noteButtonId},              
                 success: function(data) {    
               
                  var dataArray = data.split("|");
                  var noteForm = dataArray[0];
                  var noteNumber = dataArray[1];
                  
                  
                  var buttonVal = ('Member Notes  (' +noteNumber+ ')');
                  var noteButId = ('#' +noteButtonId);
                  
                if(isNaN(noteNumber)) {
                     alert(data);
                     return false;
                    }else{
                     $("#memberNotes").html(noteForm);                     
                     
                     $(noteButId).val(buttonVal);
                      alert('Note "' +confirmationTopic+ '" for ' +memberName+ ' successfully sent');
                    }
                    
                                                              
                     }//end function success
              }); //end ajax              

}

 });
//-------------------------------------------------------
}); 