$(document).ready(function() {
//-----------------------------------------------------------------------
$('#checkin').click(function() {
    //alert();
      if(document.getElementById('checkin').checked == false){
        $('#checkinHID').val('N');
      }else{
        $('#checkinHID').val('Y');
      }
      
}); 
//-----------------------------------------------------------------------
$('#memint').click(function() {
    
      if(document.getElementById('memint').checked == false){
        $('#memintHID').val('N');
      }else{
        $('#memintHID').val('Y');
      }
      
}); 
//-----------------------------------------------------------------------
$('#sales').click(function() {
    
      if(document.getElementById('sales').checked == false){
        $('#salesHID').val('N');
      }else{
        $('#salesHID').val('Y');
      }
      
}); 
//-----------------------------------------------------------------------
$('#admin').click(function() {
    
      if(document.getElementById('admin').checked == false){
        $('#adminHID').val('N');
      }else{
        $('#adminHID').val('Y');
      }
      
}); 
//-----------------------------------------------------------------------
$('#schedule').click(function() {
    
      if(document.getElementById('schedule').checked == false){
        $('#scheduleHID').val('N');
      }else{
        $('#scheduleHID').val('Y');
      }
      
}); 
//-----------------------------------------------------------------------
$('#billing').click(function() {
    
      if(document.getElementById('billing').checked == false){
        $('#billingHID').val('N');
      }else{
        $('#billingHID').val('Y');
      }
}); 
//-----------------------------------------------------------------------

});