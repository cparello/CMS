$(document).ready(function() {

//this.idTest = "";

  $(".header2").toggle(function() {
      
                    $(this).css("color", "#FFFFFF");
                    $(this).find('span').html('+');	
  
   //    idTest = $(this).closest("div").attr("id");
     //                if(idTest == "sectionTwo") {
   //                    $("#sectionTwo").css("height", "Auto");
     //                 }     
  
               },function() {
                    $(this).css("color", "#FCB040");                    
                    $(this).find('span').html('-');	      
                    
  //     idTest = $(this).closest("div").attr("id");
 //                    if(idTest == "sectionTwo") {
 //                      $("#sectionTwo").css("height", "Auto");
//                      }              
              
               });

  jQuery('.sectionContent').show();
  
 // toggle the componenet with class msg_body
  jQuery('.header2').click(function()  {
              
   jQuery(this).next('.sectionContent').slideToggle(500);
     
  });
  //-----------------------------------------------------------------

  //-----------------------------------------------------------------
});