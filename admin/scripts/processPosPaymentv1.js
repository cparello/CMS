$(document).ready(function(){
//---------------------------------------------------------
function parsePurchase(transactionId, cardName, cardNumber, total, cardMonth, cardYear, token, card_type) {

var barCodeArray = $('#bar_code_array').val();
var purchaseCost = $('#total_due').val();
var contractKey = $("#contract_key").val();

var ajaxSwitch = 1;

if($('input:radio[name=cof]:checked').val() == 2){
     var cofBool = 2;
     cardName = $("#cof_name").val();
     }
 $.ajax ({
                 type: "POST",
                 url: "processPosPurchase.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {bar_code_array: barCodeArray, purchase_cost: purchaseCost, ajax_switch: ajaxSwitch, transaction_id: transactionId, cardName: cardName, cardNumber: cardNumber, total: total, cardMonth: cardMonth, cardYear: cardYear, contractKey: contractKey, cofBool: cofBool, token: token, card_type: card_type},              
                 success: function(data) {    
               // alert('process pos purchase '+ data +' '+barCodeArray);
                   var dataArray = data.split('|');
                   var dataBool = dataArray[0];
                   var purchaseMarkerValue = dataArray[1];
                //alert(dataBool);
                    if(dataBool == 1) {
                      $('#data_bool').val(dataBool); 
                      $('#purchase_marker').val(purchaseMarkerValue);
                       }else{  
                      $('#data_bool').val(dataBool);                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
  
}
//--------------------------------------------------------
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

//===================================================
//$('#form2').submit(function() {

$('#purchase_items').live("click", function(event) {
  
var contractKey = $('#contract_key').val();
contractKey = $.trim(contractKey);

if (contractKey == ""){
    var answer = confirm("You have not linked this transaction to a member.  Do you wish to continue?");
   if (!answer) {
      return false;
     }
}



var swipeBool = $('#swipe_bool').val();
 var paymentArray = [];
 
      var  cashPay = $('#cash_pay').val();
      var  checkPay = $('#check_pay').val();
      var  creditPay = $('#credit_pay').val();
      var  checkNumber = $('#check_number').val();
      var  totalDue = $("#total").text();
      var  purchaseMarker = $('#purchase_marker').val();
      var contractKey = $("#contract_key").val();
      
      if(totalDue == '0' || totalDue == '0.00') {
         alert('Please enter an item(s) to purchase');
                  $("#upc_number").focus();
                    return false;
         }
          //var test = $('input:radio[name=cof]:checked').val(); 
         // alert(test);
     if($('input:radio[name=cof]:checked').val() == undefined){
        var cof = 1;
     }else{
        var cof =  $('input:radio[name=cof]:checked').val();
     }      
     
     
 
    if(cof == 1){
      
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
     
     totalDue = parseFloat(totalDue); 
      
   var paymentTotal = checkPay + cashPay + creditPay;    
      
       if(paymentTotal < totalDue)  {
                       alert('You have entered a value or values less than the \"Total Due\"');
                               return false;
                      }
                   if(paymentTotal > totalDue)  {
                       alert('You have entered a value or values greater than the \"Total Due\"');
                       return false;
                       }
  }
  //send off to payment processor
  if(creditPay > 0 || cashPay > 0 || checkPay > 0 ||  cof == 2) {
  
     if(cof == 2){
        var cofBool = 2;
        creditPay = totalDue;
        creditPay = parseFloat(creditPay);
        }else{
            var cofBool = 1;
        }
  
    $(this).prop("disabled",true);
    $(this).attr("class", "button2");
  
  var cardType = $('#card_type').val();
  var cardNumber = $('#card_number').val();
  var cardName = $('#card_name').val();
  var cardCvv = $('#card_cvv').val();
  var cardMonth = $('#card_month').val();
  var cardYear = $('#card_year').val();

  var barCodeArray = "";

//gets the barcodes and places them into an array
 $("tr.item").each(function() { 
    var itemBar = $(this).find('td').eq(1).text();
          barCodeArray += (itemBar+"|");  
   });

//check to see if form has allready been submitted for payemnt
if(purchaseMarker != "") {
  $('#purchase_items').prop("disabled",false);
  $('#purchase_items').attr("class", "button1"); 
   alert('This transaction has already been processed');
           return false;
  }
  
  
  var answer = confirm("This will process this POS transaction.  Do you wish to continue?");
   if (!answer) {
      return false;
     }
    // creditPay = parseFloat(creditPay);
    // cashPay = parseFloat(cashPay);
    // checkPay = parseFloat(checkPay);
var total = creditPay;
    
    $.ajax ({
                 type: "POST",
                 url: "processPosPayment.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_payment: creditPay, card_type: cardType, card_number: cardNumber, card_name: cardName, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, contract_key: contractKey, cash_payment: cashPay, check_payment: checkPay, contractKey: contractKey, cofBool: cofBool},              
                 success: function(data) {    
               // alert(data);
                    var dataArray = data.split('|');
                    var paymentStatus = dataArray[0];
                    var paymentType = dataArray[1];
                    var transactionId = dataArray[2];
                    var token = dataArray[3];
                    var card_type = dataArray[4];
                    var cardMonth = dataArray[5];
                    var cardYear = dataArray[6];
                    
                    if(paymentStatus == 1) {
                             $('#purchase_items').prop("disabled",false);
                            // $('#purchase_items').attr("class", "button1");  
                             $('#bar_code_array').val(barCodeArray);
                             $('#total_due').val(totalDue);
                             parsePurchase(transactionId, cardName, cardNumber, total, cardMonth, cardYear, token, card_type);
                             var bool = $('#data_bool').val();
                             //alert(bool);
                            if(bool == 1) {
                              alert('Purchase transaction successfully completed');                              
                              }else{                              
                                if(paymentType == 'CREDIT') {                                   
                                   alert('There was an error processing this transaction. The credit card transaction was approved however there was the following error when saving this purcahase' +bool);                                    
                                   }else{
                                    alert('There was an error processing this transaction.' +bool);
                                   }
                              }       
                       }else{  
                        alert('Credit Card transaction has been declined');
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
  
    }
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });