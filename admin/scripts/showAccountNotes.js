$(document).ready(function(){

//---------------------------------------------------------------------------------------
$('#account_notes').click(function() { 
   
       $("#masking").show(500);
       $("#notesTable").show(500);
      
});   
//--------------------------------------------------------------------------------------- 
 $('.closeThree').live("click", function() {

       $("#masking").hide(500);
       $("#notesTable").hide(500);
        
 });
 //---------------------------------------------------------------------------------------
$('#reportNotes').live("click", function(event){
    
    // find where the click originated from
    var trigger = event.target;
    
    // if it has a class of "ShowHide"
    // THEN toggle the next row
    if(trigger.className == 'ShowHide')
    {
        // toggle away
        $(trigger).closest('tr').next('.hiddenTR').toggle();
    }
}); 
 //---------------------------------------------------------------------------------------
$("input[name='priority']").live("change", function(){

    var colorId = this.id;
 
  switch(colorId)  {
         case 'low':
         $("#yellow2").show(50);
         $("#orange2").hide();
         $("#red2").hide();
         break;
         case 'medium':
         $("#orange2").show(50);
         $("#yellow2").hide();
         $("#red2").hide();
         break; 
         case 'high':
         $("#red2").show(50);
         $("#orange2").hide();
         $("#yellow2").hide();
         break;          
         }     

 });
 //---------------------------------------------------------------------------------------
$('.saveNote').live("click", function() { 


var priorityVal = $("input[name='priority']:checked").val();
var targetVal = $("#target_app").val();
var noteTopicVal = $("#topic").val();
var noteMessageVal = $("#message").val();
var fromApp = 'MI';
var contractKey = $("#contract_key_notes").val();
var ajaxSwitch = 2;

     if(noteTopicVal == "") {           
        alert('Please Enter a Note Topic');
        $("#topic").focus();
        return false;
        }

     if(noteMessageVal == "") {           
        alert('Please Enter a Message');
        $("#message").focus();
        return false;
        }

//sets for confirmation message
var confirmationTopic = noteTopicVal;

//clean out any special chars
noteTopicVal = noteTopicVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
noteMessageVal = noteMessageVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');

//here we enter the ajax code to send the message
if(priorityVal != "" && targetVal != "" && noteTopicVal != "" && noteMessageVal != "") {

  priorityVal = encodeURIComponent(priorityVal);
  targetVal = encodeURIComponent(targetVal);
  noteTopicVal = encodeURIComponent(noteTopicVal);
  noteMessageVal = encodeURIComponent(noteMessageVal);

    $.ajax ({
                 type: "POST",
                 url: "../utilities/memberNotes.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, priority: priorityVal, target_app: targetVal, message: noteMessageVal, topic: noteTopicVal, from_app: fromApp, contract_key: contractKey},              
                 success: function(data) {    
               
                  var dataArray = data.split("|");
                  var noteForm = dataArray[0];
                  var noteNumber = dataArray[1];
                  
                  noteForm = noteForm.replace(/<div class="notesTable" id="notesTable">/g,'');
                  var buttonVal = ('Notes  (' +noteNumber+ ')');
                  
                if(isNaN(noteNumber)) {
                     alert(data);
                     return false;
                    }else{
                     $("#notesTable").html(noteForm);
                     $('#account_notes').val(buttonVal);
                     alert('Note "' +confirmationTopic+ '" successfully sent');
                    }
                    
                                                              
                     }//end function success
              }); //end ajax              

}

 });
 //---------------------------------------------------------------------------------------
 $('.delNote').live("click", function() { 


    
var ajaxSwitch = 3;
//sets for confirmation message
//alert('fu');
//alert(date);
var message = $(this).attr('message2');
var topic = $(this).attr('topic2');
var contractKey = $(this).attr('contract_key2');
//alert(' msg '+message+' topic '+topic+' ckey '+contractKey);
var confirmationTopic = topic;

 var answer1 = confirm("Are you sure you want to delete this note?   " + confirmationTopic);
                               if (!answer1) {
                                      return false;
                                     }         

  //priorityVal = encodeURIComponent(priorityVal);
  //targetVal2 = encodeURIComponent(app);
  noteTopicVal = encodeURIComponent(topic);
  noteMessageVal = encodeURIComponent(message);
  contractKey = encodeURIComponent(contractKey);
  //date = encodeURIComponent(date);
  ajaxSwitch = encodeURIComponent(ajaxSwitch);
  
  
//alert('kjkjsdfjsdfkj');
 $.ajax ({
                 type: "POST",
                 url: "../utilities/memberNotes.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, message: noteMessageVal, topic: noteTopicVal, contract_key: contractKey},              
                 success: function(data) {    
               //alert(data);
                  
                  
                if(data = 1) { 
                    alert('Note "' +confirmationTopic+ '" successfully Deleted!');
                     
                    }else{
                     alert(data);
                     return false;
                    }
                    
                                                              
                     }//end function success
              }); //end ajax  
              //alert('fjhsdhjjds');            

 });
 //====================================================
 
 });