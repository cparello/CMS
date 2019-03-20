$(document).ready(function() {

  $(".header").toggle(function() {
                    $(this).css("color", "#FCB040");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FFFFFF");
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
document.getElementById('note').style.visibility = 'hidden';
}




}
//-----------------------------------------------------------------------------------------