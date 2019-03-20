$(document).ready(function(){

//---------------------------------------------------------------------------------------
$('#payment_options').click(function() { 

  if($('#payment_options').is(':disabled') == false) {
  
        var bpAvailable = $("#bp_available").val();
              if(bpAvailable == '0') {
                 alert('There are currently no Billing and Payment Options for this account');
                         return false;
                 }
  
   
       $("#masking").show(500);
       $("#paymentWindow").show(500);
  
     }
    
});   
//---------------------------------------------------------------------------------------
$('.close').click(function() { 

       $("#masking").hide(500);
       $("#paymentWindow").hide(500);
        
 });
 //--------------------------------------------------------------------------------------
 $('.closeTwo').click(function() { 

       $("#masking").hide(500);
       $("#paymentWindow").hide(500);
        
 });
 //---------------------------------------------------------------------------------------
 });