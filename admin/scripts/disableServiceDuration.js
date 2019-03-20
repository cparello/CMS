$(document).ready(function() {

//----------------------------------------------------------------------
$("#bundle1").click(function() {
    if( $('#bundle1:checked').length > 0 ) {

         $("select option:contains('Days')").attr("disabled",false);
         $("select option:contains('Weeks')").attr("disabled",false);
         $("select option:contains('Months')").attr("disabled",false);
         $("select option:contains('Years')").attr("disabled",false);
         $("select option:contains('Family')").attr("disabled",false);
         $("select option:contains('Business')").attr("disabled",false);
         $("select option:contains('Organization')").attr("disabled",false);

      }
}); 
//----------------------------------------------------------------------  
$("#bundle2").click(function() {
    if( $('#bundle2:checked').length > 0 ) {
       
       $("select option:contains('Days')").attr("disabled",true);
       $("select option:contains('Weeks')").attr("disabled",true);
       $("select option:contains('Months')").attr("disabled",true);
       $("select option:contains('Years')").attr("disabled",true);
       $("select option:contains('Family')").attr("disabled",true);
       $("select option:contains('Business')").attr("disabled",true);
       $("select option:contains('Organization')").attr("disabled",true);
       
       } 
}); 
//----------------------------------------------------------------------
 });