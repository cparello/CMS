$(document).ready(function(){

//---------------------------------------------------------
function reassignIdCard() {

var idCard = $('#id_card').val();
var adjustBool =  $('#adjust_bool').val();
var memberId = $('#member_id').val();
var contractKey = $('#contract_key').val();
var memberName = $('#member_name').val();

 $.ajax ({
                 type: "POST",
                 url: "reassignCardSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_card: idCard, member_id: memberId, contract_key: contractKey},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       
                       var newImage = ('../memberphotos/' +idCard+ '.jpg');                       
                             $("#memPic").attr("src", newImage);
                             $('#currentCard').html(idCard);
                             $('#member_id').val(idCard);
                       
                       alert('Card number for ' +memberName+ ' successfully reassigned');
                              return false;                
                       }else{  
                       alert('There was an error processing the New Card Number');
                              return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax            

return false;

}
//---------------------------------------------------------
function validCreditCard() {

var cardType = $('#card_type').val();
var cardNumber = $('#card_number').val();
var cardName = $('#card_name').val();
var cardCvv = $('#card_cvv').val();
var cardMonth = $('#card_month').val();
var cardYear = $('#card_year').val();

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");
cardName= cardName.replace(/\s+/g, "");
cardCvv= cardCvv.replace(/\s+/g, "");

        if(cardType == "") {
           alert('Please select a card type');
           $("#card_type").focus();
            return false;
            }

         if(cardName == "") {
            alert('Please enter the name on the Card');
            $("#card_name").focus();
            return false;
            }
            
         if(cardNumber == "") {
            alert('Please enter a credit card number');
            $("#card_number").focus();
            return false;
            }

   if (cardType == "Visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Visa';
      var cvvLength = 3; 
     }else if(cardType == "MC") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Master Card';
      var cvvLength = 3;
      }else if(cardType == "Disc") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Discover';
      var cvvLength = 4;
      }else if(cardType == "Amex") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
      var cardText = 'American Express';
      var cvvLength = 4;
       }else if(cardType == "Diners") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
      var cardText = 'Diners Club';
      }
   
  
         if(!re.test(cardNumber)) {  
            alert('Invalid ' +cardText+ ' Credit Card Number');
            $("#card_number").focus();
            return false;
           }
          
   
   var checksum = 0;
   for (var i=(2-(cardNumber.length % 2)); i<= cardNumber.length; i+=2) {
      checksum += parseInt(cardNumber.charAt(i-1));
       }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(cardNumber.length % 2) + 1; i<cardNumber.length; i+=2) {
      var digit = parseInt(cardNumber.charAt(i-1)) * 2;
      if (digit < 10) { 
      checksum += digit; 
      }else{ 
      checksum += (digit-9); 
      }
   }   
   
   if ((checksum % 10) == 0) {
       //do nothing
       }else{
       alert('Invalid Credit Card Number');       
       $("#card_number").focus();
       return false;
      }


        if(cardCvv == "") {
           alert('Please enter the security code');
           $("#card_cvv").focus();
            return false;           
          }
          
         if(isNaN(cardCvv)) {
           alert('Security Code may only contain Numbers');
           $("#card_cvv").focus(); 
           return false;
          }

        if(cardCvv.length < cvvLength)  {
          alert('Security Code is too short');
          $("#card_cvv").focus();   
          return false;
          }
      
        if(cardCvv.length > cvvLength)  {
         alert('Security Code is too long');
         $("#card_cvv").focus();  
         return false;
         }
    
    
 if(cardMonth == "")  {
    alert('Please select the \"Card Month\"');
    $("#card_month").focus();
    return false;            
    }      
    
 if(cardYear == "")  {
    alert('Please select the \"Card Year\"');
    $("#card_year").focus();
    return false;            
    }                
      
      
}      
//---------------------------------------------------------
function  checkPaymentFields(test)  {

var creditBool;

switch(test)  {
case 'CH':
return true;
break;

case 'CA':
return true;
break;

case 'CR':
creditBool = validCreditCard(); 
return creditBool;
break;

}


}
//---------------------------------------------------------
// focus on id card field when the page is loaded
var barCode = "";

$(window).load(function () {
  $("#id_card").focus();    
   });
//--------------------------------------------------------
$('#update').click(function() {
  
var idCard = $('#id_card').val();
var adjustBool =  $('#adjust_bool').val();
var memberId = $('#member_id').val();
var contractKey = $('#contract_key').val();
var memberName = $('#member_name').val();
var paymentArray = [];

 if(idCard == "") {
           alert('Please fill out the New Card Number field');
           $("#id_card").focus();
           return false;
           }
 if(idCard == "0") {
           alert('The New Card Number field cannot be set to zero');
           $("#id_card").focus();
           return false;
           }         
if(isNaN(idCard)) {
           alert('The New Card Number field may only contain numbers');
           $("#id_card").focus();
           return false;
           }
if(idCard.length < 4) {
           alert('The New Card Number number is too short');
           $("#id_card").focus();
           return false;
           }
      
if(adjustBool == 'Y') {  
    
    
           
 $.ajax ({
                 type: "POST",
                 url: "reassignCardSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_card: idCard, member_id: memberId, contract_key: contractKey},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       
                       var newImage = ('../memberphotos/' +idCard+ '.jpg');                       
                             $("#memPic").attr("src", newImage);
                             $('#currentCard').html(idCard);
                             $('#member_id').val(idCard);
                       
                       alert('Card number for ' +memberName+ ' successfully reassigned');
                       $('#re').prop("disabled",true);
                        $('#re').attr("class", "button1"); 
                              return false;                
                       }else{  
                       alert('There was an error processing the New Card Number');
                              return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax            

return false;

      }else{
      
      var  cashPay = $('#cash_pay').val();
      var  checkPay = $('#check_pay').val();
      var  creditPay = $('#credit_pay').val();
      var  checkNumber = $('#check_number').val();
      var  cardFee = $('#card_fee').val();
      
      if(cashPay == "" &&  checkPay == "" &&  creditPay == "") {
          alert('Please enter a value into one of the \"Payment Fields\"');
                  return false;                 
          }
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      creditPay = creditPay.replace(/\s+/g, "");
      cashPay = cashPay.replace(/\s+/g, "");
      checkPay = checkPay.replace(/\s+/g, "");
      
//make sure only one payment field is filled out
      if(creditPay != "") {
         paymentArray.push(creditPay);
        }
      if(cashPay != "") {
         paymentArray.push(cashPay);
        }      
      if(checkPay != "") {
         paymentArray.push(checkPay);
        }       
        
      if(paymentArray.length > 1) {
         alert('Please select only one type of payment');
                 return false;
        }      
      
            
if(creditPay != "")  {
      if(isNaN(creditPay)) {
         alert('Credit Payment can only contain numbers');
         $("#credit_pay").focus();
         return false;         
         }else{
         var creditBool = checkPaymentFields('CR');
                if(creditBool == false) {
                   return false; 
                  }         
         }
   }


if(cashPay != "")  {
     if(isNaN(cashPay)) {
        alert('Cash Payment can only contain numbers');
        $("#cash_pay").focus();
        return false;        
        }
  }

if(checkPay != "")  {
     if(isNaN(checkPay)) {
        alert('Check Payment can only contain numbers');
        $("#check_pay").focus();
        return false;        
        }else{
        
            if(checkNumber == "") {
               alert('Please enter the check number');
                   $("#check_number").focus();
                      return false;
                }else{
                    if(isNaN(checkNumber)) {
                       alert('Check Number can only contain numbers');
                       $("#check_number").focus();
                       return false;
                      }
                }
             
        }             
  }    
      
      
//make sure that the total matches the card fee amount      
if(checkPay == "") {
   checkPay = 0;
   }
if(cashPay == "") {
   cashPay = 0;
  }      
if(creditPay == "") {
   creditPay = 0;
  }        
      
     checkPay = parseFloat(checkPay);
     cashPay = parseFloat(cashPay);
     creditPay = parseFloat(creditPay);   
     
     cardFee = parseFloat(cardFee); 
      
   var paymentTotal = checkPay + cashPay + creditPay;    
      
       if(paymentTotal < cardFee)  {
                       alert('You have entered a value or values less than the \"Card Fee\"');
                               return false;
                      }
                   if(paymentTotal > cardFee)  {
                       alert('You have entered a value or values greater than the \"Card Fee\"');
                       return false;
                       }
  
  //send off to payment processor
  if(creditPay > 0 || cashPay > 0 || checkPay > 0) {
    
    $(this).prop("disabled",true);
    $(this).attr("class", "button2");
  
  var cardType = $('#card_type').val();
  var cardNumber = $('#card_number').val();
  var cardName = $('#card_name').val();
  var cardCvv = $('#card_cvv').val();
  var cardMonth = $('#card_month').val();
  var cardYear = $('#card_year').val();

  
    $.ajax ({
                 type: "POST",
                 url: "processIdCardPayment.php",
                 cache: false,
                 dataType: 'html', 
                 data: {credit_payment: creditPay, card_type: cardType, card_number: cardNumber, card_name: cardName, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, contract_key: contractKey},              
                 success: function(data) {    
                 //alert(data);
                    if(data == 1) {
                       $('#update').prop("disabled",true);
                       $('#update').attr("class", "button2"); 
                       $('#purchase_marker').val(data);
                       $('#purchase_total').val(paymentTotal);
                       reassignIdCard();               
                       }else{  
                       $('#update').prop("disabled",false);
                       $('#update').attr("class", "button2");                        
                       alert(data);
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    }
      
 return false;      
} //end else



           
          

});
//--------------------------------------------------------------------------------------
$("#overide_pin").focus(function () {

 var overidePin = $("#overide_pin").val();
       if(overidePin == "Enter Manager Pin Number") {
          $("#overide_pin").val(" ");
          $('#overide_pin')[0].type = 'password'; 
          }
 
   
});
//--------------------------------------------------------
$('#overide_pin').keyup(function() { 

   var overidePin = $("#overide_pin").val();
   var adjustBool;
         if(overidePin.length == "4") {

     $.ajax ({
                 type: "POST",
                 url: "../sales/checkPin2.php",
                 cache: false,
                 dataType: 'html', 
                 data: {pin: overidePin},               
                 success: function(data) {    
                 
                 if(data == 1) {
                      alert('You have entered an invalid PIN number');
                              $("#overide_pin").val("");
                                 var adjustBool = "N";
                              $('input[id=adjust_bool]').val(adjustBool);
                   }
                 
                 if(data == 2) {
                       var adjustBool = "Y";
                   $('input[id=adjust_bool]').val(adjustBool);
                 
                   }
                 
                      }//end function success
               }); //end ajax 

            }
});   
//--------------------------------------------------------------------------------------------   













 });