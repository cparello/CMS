
//------------------------------------------------------------------------------------------
function toggleNoteDiv(radID) {

 switch(radID)  {
         case 'low':
         document.getElementById("yellow2").style.visibility = "visible";
         document.getElementById("orange2").style.visibility = "hidden";
         document.getElementById("red2").style.visibility = "hidden";
         break;
         case 'medium':
         document.getElementById("orange2").style.visibility = "visible";
         document.getElementById("yellow2").style.visibility = "hidden";
         document.getElementById("red2").style.visibility = "hidden";
         break; 
         case 'high':
         document.getElementById("red2").style.visibility = "visible";
         document.getElementById("orange2").style.visibility = "hidden";
         document.getElementById("yellow2").style.visibility = "hidden";
         break;          
         }     

}

//-------------------------------------------------------------------------
function sendNote(fromApp) {

    var priorityVal;  
    var radioButtons = document.getElementsByName("priority");
          for (var x = 0; x < radioButtons.length; x++) {
               if (radioButtons[x].checked) {
                  priorityVal = radioButtons[x].value;
                  }
               }

     var appObj = document.getElementById("target_app");
     var targetVal = appObj.options[appObj.selectedIndex].value;

     
     var noteTopicVal = document.getElementById('topic').value;
           if(noteTopicVal == "") {           
             alert('Please Enter a Note Topic');
             document.getElementById('topic').focus();
             return false;
             }


      var noteMessageVal = document.getElementById('message').value;
            if(noteMessageVal == "") {           
             alert('Please Enter a Message');
             document.getElementById('message').focus();
             return false;
             }


//here we enter the ajax code to send the message
if(priorityVal != "" && targetVal != "" && noteTopicVal != "" && noteMessageVal != "") {

//sets for confirmation message
var confirmationTopic = noteTopicVal;

//clean out any special chars
noteTopicVal = noteTopicVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
noteMessageVal = noteMessageVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');

  priorityVal = encodeURIComponent(priorityVal);
  targetVal = encodeURIComponent(targetVal);
  noteTopicVal = encodeURIComponent(noteTopicVal);
  noteMessageVal = encodeURIComponent(noteMessageVal);

  var parameters = "";
  parameters = parameters+'priority='+priorityVal;
  parameters = parameters+'&target_app='+targetVal;
  parameters = parameters+'&message='+noteMessageVal;
  parameters = parameters+'&topic='+noteTopicVal;
  parameters = parameters+'&from_app='+fromApp;

//get ajax request object  and send the params to the form object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

 
xmlHttp.open("POST", "../utilities/saveMemberNote.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");

xmlHttp.onreadystatechange= function() { 

        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {                              
                           alert('Note "' +confirmationTopic+ '" successfully sent');
                           }else{   
                          // alert(successKey);
                            alert('There was an error sending this note');
                           return false;                         
                           }                             
             }
}

xmlHttp.send(parameters);


}


}
//-------------------------------------------------------------------------
function deleteNote(date, topic, msg, contractKey) {
    
    var confirmationTopic = topic;
    
    var answer1 = confirm("Are you sure you want to delete this note?   " + confirmationTopic);
                               if (!answer1) {
                                      return false;
                                     }         
                                     
var ajaxSwitch = 3;
//sets for confirmation message


  //priorityVal = encodeURIComponent(priorityVal);
  //targetVal = encodeURIComponent(app);
  noteTopicVal = encodeURIComponent(topic);
  noteMessageVal = encodeURIComponent(msg);
  contractKey = encodeURIComponent(contractKey);
  date = encodeURIComponent(date);
  ajaxSwitch = encodeURIComponent(ajaxSwitch);
  


  var parameters = "";
  parameters = parameters+'date='+date;
  //parameters = parameters+'&target_app='+targetVal;
  parameters = parameters+'&message='+noteMessageVal;
  parameters = parameters+'&topic='+noteTopicVal;
  parameters = parameters+'&contract_key='+contractKey;
  parameters = parameters+'&ajax_switch='+ajaxSwitch;
//get ajax request object  and send the params to the form object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

 //alert('date '+date + ' msg '+msg + ' key '+contractKey + ' ajax '+ajaxSwitch);
xmlHttp.open("POST", "../utilities/memberNotes.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");

xmlHttp.onreadystatechange= function() { 

        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert('key '+successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {                              
                           alert('Note "' +confirmationTopic+ '" successfully deleted');
                           }else{   
                          // alert(successKey);
                            alert('There was an error deleting this note');
                           return false;                         
                           }                             
             }
}

xmlHttp.send(parameters);





}