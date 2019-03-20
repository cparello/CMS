$(document).ready(function(){

//---------------------------------------------------------------------------------------
$('#pre_payments').click(function() { 

  if($('#pre_payments').is(':disabled') == false) {
  
        var bpAvailable = $("#bp_available").val();
              if(bpAvailable == '0') {
                 alert('There are currently no Pre Payment Options for this account');
                         return false;
                 }
  
   
       $("#masking2").show(500);
       $("#paymentWindow2").show(500);
  
     }
    
});   
//---------------------------------------------------------------------------------------
$('.closeFour').click(function() { 

       $("#masking2").hide(500);
       $("#paymentWindow2").hide(500);
        
 });
 //--------------------------------------------------------------------------------------
 $('.closeFive').click(function() { 

       $("#masking2").hide(500);
       $("#paymentWindow2").hide(500);
        
 });
 
 //---------------------------------------------------------------------------------------
 });