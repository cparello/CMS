$(document).ready(function(){ 

//----------------------------------------------------------------------
$(window).load(function () {

var confMessage = "";
        
        if(confMessage != "") {
           alert(confMessage);
           }
           
});
//----------------------------------------------------------------------
function savePrePayment() {

var  creditPay = $('#credit_pay2').val();
var  cashPay = $('#cash_pay2').val();
var  checkPay = $('#check_pay2').val();
var  checkNumber = $('#check_number2').val();
var  monthlyPayment = $('#monthly_payment').val();
var  prePayRestartDate = $('#prepay_restart_date').val();
var  prePayTotal = $('#prepay_total2').val();
var  numMonths = $('#num_months2').val();
var  keyList = $('#key_list2').val();

var contractKey = $('#contract_key2').val();

//alert ('jfhjdfh  '+cashPay);

    $.ajax ({
                 type: "POST",
                 url: "savePrePaymentsTwo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_pay: creditPay, cash_pay: cashPay, check_pay: checkPay, check_number: checkNumber, contract_key: contractKey, monthly_payment: monthlyPayment, prepay_restart_date: prePayRestartDate, prepay_total: prePayTotal, num_months: numMonths, key_list: keyList},              
                 success: function(data) {    
                //alert('rererer  '+data);
                    if(data == 1) {
                       $('#data_bool').val(data);                                
                       }else{  
                       alert(data);
                       return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              

}
//--------------------------------------------------------------------------------------------
function checkPrePay(contractKey)  {
    
var bit = "1";
$.ajax ({
                 type: "POST",
                 async:   false,
                 url: "../billing/prePayInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: contractKey},               
                 success: function(data) {
                    //alert(data);
                           if(data == 1) {
                             $('#bool2').val(bit);
                              //alert('A pre-payment already exists for this contract');
                                      
                             }
                     }//end function success
              }); //end ajax                       
     
 }
 //-------------------------------------------------------------------------------------------
$("#num_months_m").change(function() {
//alert('fu');
 // var prePayTotal = document.form2.prepay_total.value;
  var mFee = $('#m_fee').val();        
  var mDateArray = $('#m_date_array').val();
        mDateArray = mDateArray.split("|");
        var singleMonthDate = mDateArray[0];
  
    
     if(this.value != "") {

    var numMonths = this.value;
          numMonths = parseInt(numMonths);
          mFee = parseFloat(mFee);
          
          if(numMonths == 1) {
            var previousTot = $('#prepay_total_m').val();
            if(previousTot == 0 || previousTot == ""){
                    $('#prepay_total_m').val(mFee);
                    var combinedTot = $('#prepay_total_combined').val();
                    //alert(combinedTot);
                    if(combinedTot != ""){
                         combinedTot = parseFloat(combinedTot);
                    }else{
                     combinedTot = 0;
                     combinedTot = parseFloat(combinedTot);
                    }
                   $('#prepay_total_combined').val(mFee + combinedTot);
                   $('#next_payment_m').html(singleMonthDate);
                   $('#prepay_restart_date_m').val(singleMonthDate);
              }else{
                var combinedTot = $('#prepay_total_combined').val();
                var tempTot = $('#prepay_total_m').val();
                combinedTot = parseFloat(combinedTot);
                tempTot = parseFloat(tempTot);
                combinedTot = combinedTot - tempTot +mFee;
                combinedTot = combinedTot.toFixed(2);
                $('#prepay_total_combined').val(combinedTot); 
                $('#prepay_total_m').val(mFee); 
                $('#next_payment_m').html(singleMonthDate);
                $('#prepay_restart_date_m').val(singleMonthDate);
              }
          
            }else{
                     var previousTot = $('#prepay_total_m').val();
                    if(previousTot != 0 || previousTot != ""){
                         var combinedTot = $('#prepay_total_combined').val();
                         combinedTot = parseFloat(combinedTot);
                         previousTot = parseFloat(previousTot);
                         $('#prepay_total_combined').val(combinedTot - previousTot);
                     }
                         var prePayTotal = numMonths * mFee; 
                         
                           var combinedTot = $('#prepay_total_combined').val();
                               if(combinedTot != ""){
                                         combinedTot = parseFloat(combinedTot);
                                    }else{
                                     combinedTot = 0;
                                     combinedTot = parseFloat(combinedTot);
                                    }
                                    var tot = prePayTotal + combinedTot;
                                    tot = tot.toFixed(2);
                                $('#prepay_total_combined').val(tot);
                               prePayTotal = prePayTotal.toFixed(2);
                               $('#prepay_total_m').val(prePayTotal);
                               
                            
                         
                         var dateArrayLength = mDateArray.length;
                               dateArrayLength = dateArrayLength - 1;
                        
                          for(var i=0; i <= dateArrayLength; i++) {                    
                                    if(this.value == i) {
                                       var dateVal = mDateArray[i-1];
                                             $('#next_payment_m').html(dateVal);
                                             $('#prepay_restart_date_m').val(dateVal);
                                      }            
                               }
                    
            }
       
    }else{
        var combinedTot = $('#prepay_total_combined').val();
        if(combinedTot != ""){
                             combinedTot = parseFloat(combinedTot);
                        }else{
                         combinedTot = 0;
                         combinedTot = parseFloat(combinedTot);
                        }
        var prePayTot = $('#prepay_total_m').val();
        if(prePayTot != ""){
                             prePayTot = parseFloat(prePayTot);
                        }else{
                         prePayTot = 0;
                         prePayTot = parseFloat(prePayTot);
                        }
        $('#prepay_total_combined').val(combinedTot - prePayTot);
         $('#prepay_total_m').val("");
         var currentMonthDate = $('#current_month_date').val();
         $('#next_payment_m').html(currentMonthDate);
         $('#prepay_restart_date_m').val("");
    }


});
 //-------------------------------------------------------------------------------------------
$("#num_months_rate").change(function() {
//alert('fu');
 // var prePayTotal = document.form2.prepay_total.value;
  var rateFee = $('#rate_fee').val();        
  var billingDateArray = $('#rate_date_array').val();
        billingDateArray = billingDateArray.split("|");
        var singleMonthDate = billingDateArray[0];
  
    
     if(this.value != "") {

    var numMonths = this.value;
          numMonths = parseInt(numMonths);
          rateFee = parseFloat(rateFee);
          
          if(numMonths == 1) {
            var previousTot = $('#prepay_total_rate').val();
            if(previousTot == 0 || previousTot == ""){
                    $('#prepay_total_rate').val(rateFee);
                    var combinedTot = $('#prepay_total_combined').val();
                    //alert(combinedTot);
                    if(combinedTot != ""){
                         combinedTot = parseFloat(combinedTot);
                    }else{
                     combinedTot = 0;
                     combinedTot = parseFloat(combinedTot);
                    }
                   $('#prepay_total_combined').val(rateFee + combinedTot);
                   $('#next_payment_rate').html(singleMonthDate);
                   $('#prepay_restart_date_rate').val(singleMonthDate);
              }else{
                var combinedTot = $('#prepay_total_combined').val();
                var tempTot = $('#prepay_total_rate').val();
                combinedTot = parseFloat(combinedTot);
                tempTot = parseFloat(tempTot);
                combinedTot = combinedTot - tempTot +rateFee;
                combinedTot = combinedTot.toFixed(2);
                $('#prepay_total_combined').val(combinedTot); 
                $('#prepay_total_rate').val(rateFee); 
                $('#next_payment_rate').html(singleMonthDate);
                $('#prepay_restart_date_rate').val(singleMonthDate);
              }
          
            }else{
                     var previousTot = $('#prepay_total_rate').val();
                    if(previousTot != 0 || previousTot != ""){
                         var combinedTot = $('#prepay_total_combined').val();
                         combinedTot = parseFloat(combinedTot);
                         previousTot = parseFloat(previousTot);
                         $('#prepay_total_combined').val(combinedTot - previousTot);
                     }
                         var prePayTotal = numMonths * rateFee; 
                         
                           var combinedTot = $('#prepay_total_combined').val();
                               if(combinedTot != ""){
                                         combinedTot = parseFloat(combinedTot);
                                    }else{
                                     combinedTot = 0;
                                     combinedTot = parseFloat(combinedTot);
                                    }
                                    var tot = prePayTotal + combinedTot;
                                    tot = tot.toFixed(2);
                                $('#prepay_total_combined').val(tot);
                               prePayTotal = prePayTotal.toFixed(2);
                               $('#prepay_total_rate').val(prePayTotal);
                               
                            
                         
                         var dateArrayLength = billingDateArray.length;
                               dateArrayLength = dateArrayLength - 1;
                        
                          for(var i=0; i <= dateArrayLength; i++) {                    
                                    if(this.value == i) {
                                       var dateVal = billingDateArray[i-1];
                                             $('#next_payment_rate').html(dateVal);
                                             $('#prepay_restart_date_rate').val(dateVal);
                                      }            
                               }
                    
            }
       
    }else{
        var combinedTot = $('#prepay_total_combined').val();
        if(combinedTot != ""){
                             combinedTot = parseFloat(combinedTot);
                        }else{
                         combinedTot = 0;
                         combinedTot = parseFloat(combinedTot);
                        }
        var prePayTot = $('#prepay_total_rate').val();
        if(prePayTot != ""){
                             prePayTot = parseFloat(prePayTot);
                        }else{
                         prePayTot = 0;
                         prePayTot = parseFloat(prePayTot);
                        }
        $('#prepay_total_combined').val(combinedTot - prePayTot);
         $('#prepay_total_rate').val("");
         var currentMonthDate = $('#current_rate_date').val();
         $('#next_payment_rate').html(currentMonthDate);
         $('#prepay_restart_date_rate').val("");
    }


});
 //-------------------------------------------------------------------------------------------
$("#num_months_enhance").change(function() {
//alert('fu');
 // var prePayTotal = document.form2.prepay_total.value;
  var enhanceFee = $('#enhance_fee').val();        
  var billingDateArray = $('#enhance_date_array').val();
        billingDateArray = billingDateArray.split("|");
        var singleMonthDate = billingDateArray[0];
  
    
     if(this.value != "") {

    var numMonths = this.value;
          numMonths = parseInt(numMonths);
          enhanceFee = parseFloat(enhanceFee);
          
          if(numMonths == 1) {
            var previousTot = $('#prepay_total_enhance').val();
            if(previousTot == 0 || previousTot == ""){
                    $('#prepay_total_enhance').val(enhanceFee);
                    var combinedTot = $('#prepay_total_combined').val();
                    //alert(combinedTot);
                    if(combinedTot != ""){
                         combinedTot = parseFloat(combinedTot);
                    }else{
                     combinedTot = 0;
                     combinedTot = parseFloat(combinedTot);
                    }
                   $('#prepay_total_combined').val(enhanceFee + combinedTot);
                   $('#next_payment_enhance').html(singleMonthDate);
                   $('#prepay_restart_date_enhance').val(singleMonthDate);
              }else{
                var combinedTot = $('#prepay_total_combined').val();
                var tempTot = $('#prepay_total_enhance').val();
                combinedTot = parseFloat(combinedTot);
                tempTot = parseFloat(tempTot);
                combinedTot = combinedTot - tempTot +enhanceFee;
                combinedTot = combinedTot.toFixed(2);
                $('#prepay_total_combined').val(combinedTot); 
                $('#prepay_total_enhance').val(enhanceFee); 
                $('#next_payment_enhance').html(singleMonthDate);
                $('#prepay_restart_date_enhance').val(singleMonthDate);
              }
          
            }else{
                     var previousTot = $('#prepay_total_enhance').val();
                    if(previousTot != 0 || previousTot != ""){
                         var combinedTot = $('#prepay_total_combined').val();
                         combinedTot = parseFloat(combinedTot);
                         previousTot = parseFloat(previousTot);
                         $('#prepay_total_combined').val(combinedTot - previousTot);
                     }
                         var prePayTotal = numMonths * enhanceFee; 
                         
                           var combinedTot = $('#prepay_total_combined').val();
                               if(combinedTot != ""){
                                         combinedTot = parseFloat(combinedTot);
                                    }else{
                                     combinedTot = 0;
                                     combinedTot = parseFloat(combinedTot);
                                    }
                                    var tot = prePayTotal + combinedTot;
                                    tot = tot.toFixed(2);
                                $('#prepay_total_combined').val(tot);
                               prePayTotal = prePayTotal.toFixed(2);
                               $('#prepay_total_enhance').val(prePayTotal); 
                               
                            
                         
                         var dateArrayLength = billingDateArray.length;
                               dateArrayLength = dateArrayLength - 1;
                        
                          for(var i=0; i <= dateArrayLength; i++) {                    
                                    if(this.value == i) {
                                       var dateVal = billingDateArray[i-1];
                                             $('#next_payment_enhance').html(dateVal);
                                             $('#prepay_restart_date_enhance').val(dateVal);
                                      }            
                               }
                    
            }
       
    }else{
        var combinedTot = $('#prepay_total_combined').val();
        if(combinedTot != ""){
                             combinedTot = parseFloat(combinedTot);
                        }else{
                         combinedTot = 0;
                         combinedTot = parseFloat(combinedTot);
                        }
        var prePayTot = $('#prepay_total_enhance').val();
        if(prePayTot != ""){
                             prePayTot = parseFloat(prePayTot);
                        }else{
                         prePayTot = 0;
                         prePayTot = parseFloat(prePayTot);
                        }
        $('#prepay_total_combined').val(combinedTot - prePayTot);
         $('#prepay_total_enhance').val("");
         var currentMonthDate = $('#current_enhance_date').val();
         $('#next_payment_enhance').html(currentMonthDate);
         $('#prepay_restart_date_enhance').val("");
    }


});
//-------------------------------------------------------------------------------------------
$("#num_months2").change(function() {
//alert('fu');
 // var prePayTotal = document.form2.prepay_total.value;
  var monthlyPayment = $('#monthly_payment').val();        
  var billingDateArray = $('#billing_date_array').val();
        billingDateArray = billingDateArray.split("|");
        var singleMonthDate = billingDateArray[1];
  
    
     if(this.value != "") {

    var numMonths = this.value;
          numMonths = parseInt(numMonths);
          monthlyPayment = parseFloat(monthlyPayment);
          
          if(numMonths == 1) {
            var previousTot = $('#prepay_total2').val();
            if(previousTot == 0 || previousTot == ""){
                    $('#prepay_total2').val(monthlyPayment);
                    var combinedTot = $('#prepay_total_combined').val();
                    //alert(combinedTot);
                    if(combinedTot != ""){
                         combinedTot = parseFloat(combinedTot);
                    }else{
                     combinedTot = 0;
                     combinedTot = parseFloat(combinedTot);
                    }
                   $('#prepay_total_combined').val(monthlyPayment + combinedTot);
                   $('#next_payment2').html(singleMonthDate);
                   $('#prepay_restart_date').val(singleMonthDate);
              }else{
                var combinedTot = $('#prepay_total_combined').val();
                var tempTot = $('#prepay_total2').val();
                combinedTot = parseFloat(combinedTot);
                tempTot = parseFloat(tempTot);
                combinedTot = combinedTot - tempTot +monthlyPayment;
                combinedTot = combinedTot.toFixed(2);
                $('#prepay_total_combined').val(combinedTot); 
                $('#prepay_total2').val(monthlyPayment); 
                $('#next_payment2').html(singleMonthDate);
                $('#prepay_restart_date').val(singleMonthDate);
              }
          
            }else{
                     var previousTot = $('#prepay_total2').val();
                    if(previousTot != 0 || previousTot != ""){
                         var combinedTot = $('#prepay_total_combined').val();
                         combinedTot = parseFloat(combinedTot);
                         previousTot = parseFloat(previousTot);
                         $('#prepay_total_combined').val(combinedTot - previousTot);
                     }
                         var prePayTotal = numMonths * monthlyPayment; 
                         
                           var combinedTot = $('#prepay_total_combined').val();
                               if(combinedTot != ""){
                                         combinedTot = parseFloat(combinedTot);
                                    }else{
                                     combinedTot = 0;
                                     combinedTot = parseFloat(combinedTot);
                                    }
                                    var tot = prePayTotal + combinedTot;
                                    tot = tot.toFixed(2);
                                $('#prepay_total_combined').val(tot);
                               prePayTotal = prePayTotal.toFixed(2);
                               $('#prepay_total2').val(prePayTotal);
                               
                            
                         
                         var dateArrayLength = billingDateArray.length;
                               dateArrayLength = dateArrayLength - 1;
                        
                          for(var i=0; i <= dateArrayLength; i++) {                    
                                    if(this.value == i) {
                                       var dateVal = billingDateArray[i];
                                             $('#next_payment2').html(dateVal);
                                             $('#prepay_restart_date').val(dateVal);
                                      }            
                               }
                    
            }
       
    }else{
        var combinedTot = $('#prepay_total_combined').val();
        if(combinedTot != ""){
                             combinedTot = parseFloat(combinedTot);
                        }else{
                         combinedTot = 0;
                         combinedTot = parseFloat(combinedTot);
                        }
        var prePayTot = $('#prepay_total2').val();
        if(prePayTot != ""){
                             prePayTot = parseFloat(prePayTot);
                        }else{
                         prePayTot = 0;
                         prePayTot = parseFloat(prePayTot);
                        }
        $('#prepay_total_combined').val(combinedTot - prePayTot);
         $('#prepay_total2').val("");
         var currentMonthDate = $('#current_month_date').val();
         $('#next_payment2').html(currentMonthDate);
         $('#prepay_restart_date').val("");
    }


});
//--------------------------------------------------------------------------------------
function checkPaymentFields(monthVal)  {

var creditBool;

switch(monthVal)  {
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
//--------------------------------------------------------------------------------------
function validCreditCard() {

var cardType = $('#card_type2').val();
var cardNumber = $('#card_number2').val();
var cardName = $('#card_name2').val();
var cardCvv = $('#card_cvv2').val();
var cardMonth = $('#card_month2').val();
var cardYear = $('#card_year2').val();

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");
cardName= cardName.replace(/\s+/g, "");
cardCvv= cardCvv.replace(/\s+/g, "");

        if(cardType == "") {
           alert('Please select a card type');
           $('#card_type2').focus();
            return false;
            }

         if(cardName == "") {
            alert('Please enter the name on the Card');
            $('#card_name2').focus();
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
            $('#card_number2').focus();
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
       $('#card_number2').focus();
       return false;
      }


        if(cardCvv == "") {
           alert('Please enter the security code');
           $('#card_cvv2').focus();
            return false;           
          }
          
         if(isNaN(cardCvv)) {
           alert('Security Code may only contain Numbers');
           $('#card_cvv2').focus();  
           return false;
          }

        if(cardCvv.length < cvvLength)  {
          alert('Security Code is too short');
          $('#card_cvv2').focus();   
          return false;
          }
      
        if(cardCvv.length > cvvLength)  {
         alert('Security Code is too long');
         $('#card_cvv2').focus();  
         return false;
         }
    
    
 if(cardMonth == "")  {
    alert('Please select the \"Card Month\"');
    $('#card_month2').focus();
    return false;            
    }      
    
 if(cardYear == "")  {
    alert('Please select the \"Card Year\"');
    $('#card_year2').focus();
    return false;            
    }                
      
      
}    

//------------------------------------------------------------------------------------------------------------
$('#update2').click(function() {
  //alert('fu22');
var contractKey = $('#contract_key2').val();
var purchaseMarker = $('#purchase_marker2').val();
var paymentArray = [];
      
      var  cashPay = $('#cash_pay2').val();
      var  checkPay = $('#check_pay2').val();
      var  creditPay = $('#credit_pay2').val();
      var  checkNumber = $('#check_number2').val();
      var  prePayTotal = $('#prepay_total2').val();
      var  numMonths = $('#num_months2').val();      
      var  prePayRestartDate = $('#prepay_restart_date').val();
      var  numMonths = $('#num_months2').val();
      var  monthlyPayment = $('#monthly_payment').val();
      
        //alert(cashPay);
      
       if(numMonths == "") {
           alert('Please select a value from the \"Prepaid Months\" drop down menu');
            return false;                                         
          }
       if(prePayTotal == "") {
          alert('Please select a value from the \"Prepaid Months\" drop down menu');
            return false;                                         
         }
      
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
         $("#credit_pay2").focus();
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
        $("#cash_pay2").focus();
        return false;        
        }
  }

if(checkPay != "")  {
     if(isNaN(checkPay)) {
        alert('Check Payment can only contain numbers');
        $("#check_pay2").focus();
        return false;        
        }else{
        
            if(checkNumber == "") {
               alert('Please enter the check number');
                   $("#check_number2").focus();
                      return false;
                }else{
                    if(isNaN(checkNumber)) {
                       alert('Check Number can only contain numbers');
                       $("#check_number2").focus();
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
     
     prePayTotal = parseFloat(prePayTotal); 
      
   var paymentTotal = checkPay + cashPay + creditPay;    
      
       if(paymentTotal < prePayTotal)  {
                       alert('You have entered a value or values less than the \"Pre Payment Total\"');
                               return false;
                      }
                   if(paymentTotal > prePayTotal)  {
                       alert('You have entered a value or values greater than the \"Pre Payment Total\"');
                       return false;
                       }
  
  //send off to payment processor
  if(creditPay > 0 || cashPay > 0 || checkPay > 0) {
  
    $(this).prop("disabled",true);
    $(this).attr("class", "button2");
  
  var cardType = $('#card_type2').val();
  var cardNumber = $('#card_number2').val();
  var cardName = $('#card_name2').val();
  var cardCvv = $('#card_cvv2').val();
  var cardMonth = $('#card_month2').val();
  var cardYear = $('#card_year2').val();
  

  //check to see if form has allready been submitted for payemnt
if(purchaseMarker != "") {
   alert('This transaction has already been processed');
           return false;
  }
    
  var answer = confirm("This will process this transaction.  Do you wish to continue?");
   if (!answer) {
      return false;
     }                       

checkPrePay(contractKey);
var testBool = $('#bool2').val();
     if(testBool == "1") {
        //alert('A pre-payment already exists for this contract');
        //return false;
             var answer = confirm("A pre-payment already exists for this contract.  Do you wish to continue?");
             if (!answer) {
             return false;
                }          
        }
//alert('fu    '+testBool);
  
    $.ajax ({
                 type: "POST",
                 url: "processPrePayment.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_payment: creditPay, card_type: cardType, card_number: cardNumber, card_name: cardName, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, contract_key: contractKey, pre_pay_restart_date: prePayRestartDate, number_months: numMonths, monthly_payment: monthlyPayment},              
                 success: function(data) {    
                //alert('fu22   '+data);
                    if(data == 1) {
                             savePrePayment();
                             var bool = $('#data_bool').val();
                             //alert(bool);
                            if(bool == 1) {
                              $('#purchase_marker2').val(bool);                               
                               alert('Transaction for contract '+contractKey+ ' successfully processed'); 
                              }else{
                              alert('There was an error processing this transaction'+bool);                                      
                              }
                                     
                       }else if(data == 2 ) {  
                       $('#update2').prop("disabled",false);
                       $('#update2').attr("class", "button1");
                       alert("This Credit Card has been declined");                       
                       }else{
                       $('#update2').prop("disabled",false);
                       $('#update2').attr("class", "button1");    
                       //alert('xxxxxx   '+data);
                       return false;
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    }
      
 return false;      

          

});
//--------------------------------------------------------------------------------------


 });