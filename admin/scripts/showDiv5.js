$(document).ready(function() {
//-----------------------------------------------------------------------

 $(".header").toggle(function() {
                   $(this).css("color", "#FFFFFF");
                   $(this).css("border-bottom", "1px solid #4A4B4C");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FCB040");
                    $(this).css("border-bottom", "1px solid #FFFFFF");   
                    $(this).find('span').html('+');	
                    
               });

 $('.content').hide();
 
 $('.header').click(function(event) { 
    var trigger = event.target;             
     $(trigger).closest('tr').next('.content').toggle(100);     
  });

//-----------------------------------------------------------------------
});
