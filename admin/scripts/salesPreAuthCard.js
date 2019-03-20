$(document).ready(function(){
 //---------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------
$('#pre_auth').live("click", function(event) {
    
var  cardName = $('#card_name').val();
var  cardNumber = $('#card_number').val();    
var  cardMonth = $('#card_month').val();  
var  cardYear = $('#card_year').val();  
var  ajaxSwitch = 1; 
//alert();
if (cardName == "" || cardNumber == ""){
    alert('Please enter Credit Card information before trying to preauthorize the card.');
    return false;
}
              
$.ajax ({
            type: "POST",
            url: "salesPreAuthCard.php",
            cache: false,
            dataType: 'html', 
            data: {card_name: cardName, card_number: cardNumber, card_month: cardMonth, card_year: cardYear, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                //alert(data);
                
                 var dataArray = data.split("|");
                 var data = dataArray[0];
                 var reasonCode = dataArray[1];
                 var reasonMessage = dataArray[2];
                
                 if(data == "1") {
                    alert('Credit Card is valid. Please proceed.'); 
                    $('#preAuthStatus').val('Verified!');
                    $('#preAuthBool').val(1);
                    $("#preAuthStatus").css({"background-color": "green"});
                    $("#preAuthStatus").css({"color": "white"});
                    $('#preauth_marker').val(data); 
                         
                   }else{
                   alert('Credit Card is invalid! ***'+reasonCode+': '+reasonMessage+'*** Please request a new form of payment.'); 
                    $('#preauth_marker').val(data); 
                    $('#preAuthBool').val(2);
                    $('#preAuthStatus').val('Failed! '+reasonCode+':'+reasonMessage+'');
                    $("#preAuthStatus").css({"background-color": "red"});
                   }
                                            
                     }//end function success
              }); //end ajax 


return false;


});
//--------------------------------------------------------------------------------------
 });
 
 
 
 
 
 
 
 
 
 
 
 