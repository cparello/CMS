$(document).ready(function() {
//----------------------------------------------------------------
function parseCardInfo(cardInfo) {

var cardInfoArray = cardInfo.split("|");
var cardNumber = cardInfoArray[0];
var cardName = cardInfoArray[1];
var expMonth = cardInfoArray[2];
var expYear = cardInfoArray[3];
var cardType = cardInfoArray[4];


$('#card_number').val(cardNumber);
$('#card_name').val(cardName);
$('#card_month').val(expMonth);
$('#card_year').val(expYear);
$('#card_type').val(cardType);


}
//----------------------------------------------------------------
$('#card_name').change(function() {

var ajaxSwitch = 1;
var cardName = $('#card_name').val();

if(cardName.match(/%B/g)) {

    $.ajax ({
                type: "POST",
                url: "../helper_apps/cardSwipe.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, card_array: cardName},               
                     success: function(data) { 
                        parseCardInfo(data);
                                                                                    
                         }//end function success
                 }); //end ajax 


   }else{
   
      if(cardName.match(/\;/g))  {
   
           var cardNameTwo = $('#card_name').val();       
           var cardArray = cardName.split(";");   
           var cardNameTwo = cardArray[0];
                $('#card_name').val(cardNameTwo);   
        }
 }      
              
}); 
//--------------------------------------------------------------
}); 


