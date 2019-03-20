$(document).ready(function() {

  $(".header").toggle(function() {
                    $(this).css("color", "#FFFFFF");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FCB040");
                    $(this).find('span').html('+');	
               });

  jQuery('.content').hide();
 // toggle the componenet with class msg_body
  jQuery('.header').click(function()  {
                 
   jQuery(this).next('.content').slideToggle(500);
     
  });
});

//-------------------------------------------------------------------------------------------
function openNotes(noteSwitch) {

//var openCheck = document.form1.open_notes;
//if(openCheck.checked == true) {


if(noteSwitch == 1) {
document.getElementById('note').style.visibility = 'visible';
}else{

if(document.form1.topic.value != "" &&  document.form1.message.value == "") {
   alert('Please enter a note message');
   document.form1.message.focus();
   return false;
  }

if(document.form1.message.value != "" &&  document.form1.topic.value == "") {
   alert('Please enter a note topic');
   document.form1.topic.focus();
   return false;
  }

if(document.form1.topic.value != "" && document.form1.message.value != "") {
    if(document.form1.target_app.value == "") {
       alert('Please Select a Target Group');
       document.form1.target_app.focus();
       return false;
      }
  }

document.getElementById('note').style.visibility = 'hidden';
}


}
//-----------------------------------------------------------------------------------------