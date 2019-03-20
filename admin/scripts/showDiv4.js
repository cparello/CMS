$(document).ready(function() {

  $(".header2").toggle(function() {
                    $(this).css("color", "#CCFFFF");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FFFFFF");
                    $(this).find('span').html('+');	
               });

  jQuery('.listContent').hide();
 // toggle the componenet with class msg_body
  jQuery('.header2').click(function()  {
                 
   jQuery(this).next('.listContent').slideToggle(500);
     
  });
  
  
});

