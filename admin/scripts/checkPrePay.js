function checkPrePay(contractKey)  {

$(document).ready(function(){     
var bit = 1;
$.ajax ({
                 type: "POST",
                 async:   false,
                 url: "prePayInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: contractKey},               
                 success: function(data) {
                           if(data == 1) {
                              //alert('A pre-payment already exists for this contract');
                                      document.form1.bool.value = bit;
                             }
                     }//end function success
              }); //end ajax                       
 });     
 }
//-------------------------------------------------------------------------------------------
function confirmPrePay(contractKey) {

alert('Pre Payment for Contract '+contractKey+' successfully processed');

}
//-------------------------------------------------------------------------------------------
function setPrePayTotal(obj) {

 // var prePayTotal = document.form1.prepay_total.value;
  var monthlyPayment = document.form1.monthly_payment.value;        
  var billingDateArray = document.form1.billing_date_array.value;
        billingDateArray = billingDateArray.split("|");
        var singleMonthDate = billingDateArray[1];
  
  if(obj.value != "") {

    var numMonths = obj.value;
          numMonths = parseInt(numMonths);
          monthlyPayment = parseFloat(monthlyPayment);
          
          if(numMonths == 1) {
            document.form1.prepay_total.value = monthlyPayment;
            document.getElementById('next_payment').innerHTML = singleMonthDate;
            document.form1.prepay_restart_date.value = singleMonthDate;
            }else{
            
             var prePayTotal = numMonths * monthlyPayment;
                   prePayTotal = prePayTotal.toFixed(2);
                   document.form1.prepay_total.value = prePayTotal;
             
             var dateArrayLength = billingDateArray.length;
                   dateArrayLength = dateArrayLength - 1;
            
              for(var i=0; i <= dateArrayLength; i++) {                    
                        if(obj.value == i) {
                           var dateVal = billingDateArray[i];
                                 document.getElementById('next_payment').innerHTML = dateVal;
                                 document.form1.prepay_restart_date.value = dateVal;
                          }            
                   }
            
            }
       
    }

}
//--------------------------------------------------------------------------------------
function checkNan(numberValue,fieldName)  {

var fullFieldValue = document.getElementById(fieldName).value;
var newFieldValue;


if(isNaN(fullFieldValue)) {

newFieldValue = fullFieldValue.slice(0,-1);
document.getElementById(fieldName).value = newFieldValue;

  alert('The value you entered is not a number.');
  return false;
  }

}
//--------------------------------------------------------------------------------------
function checkPaymentFields(monthVal)  {

var creditBool;
var bankBool;

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

case 'BA':
bankBool = checkBankTypes(); 
return bankBool;
break;
}


}
//--------------------------------------------------------------------------------------
function checkBankTypes()   {

var bankName = document.form1.bank_name.value;
var accountType = document.form1.account_type.value;
var accountName = document.form1.account_name.value;
var accountNumber = document.form1.account_num.value;
var routingValue = document.form1.aba_num.value;
var i;
var n;
var t;

//clear out any garbage charachters
bankName = bankName.replace(/\s+/g, "");
accountName = accountName.replace(/\s+/g, "");
accountNumber = accountNumber.replace(/\s+/g, "");
routingValue = routingValue.replace(/\s+/g, "");


            if(bankName == "")  {
             alert('Please enter a Bank Name');
             document.form1.bank_name.focus();
             return false;            
            }                

            if(accountType == "")  {
             alert('Please select an Account Type');
             document.form1.account_type.focus();
             return false;            
            }        

            if(accountName == "")  {
             alert('Please enter the name on the account');
             document.form1.account_name.focus();
             return false;            
            }     

            if(accountNumber == "")  {
             alert('Please enter the Account Number');
             document.form1.account_num.focus();
             return false;            
            }            


            if(routingValue == "")  {
             alert('Please enter the Routing Number');
             document.form1.aba_num.focus();
             return false;            
            }
            
           if(isNaN(routingValue)) {
             alert('Routing Number may only contain numbers');
             document.form1.aba_num.focus(); 
             return false;
             }

           if(routingValue.length < 9) {
             alert('Routing Number is too short. Routing number must be 9 charachters in length.');
             document.form1.aba_num.focus();    
             return false;
             } 
    
          if(routingValue.length > 9) {
            alert('Routing Number is too long. Routing number must be 9 charachters in length.');
            document.form1.aba_num.focus();    
            return false;
            } 
            
            
  t = "";
  for (i = 0; i < routingValue.length; i++) {
    c = parseInt(routingValue.charAt(i), 10);
           if (c >= 0 && c <= 9) {
               t = t + c;
             }
      }
 
 
  n = 0;
  for (i = 0; i < t.length; i += 3) {
       n += parseInt(t.charAt(i),     10) * 3
       +  parseInt(t.charAt(i + 1), 10) * 7
       +  parseInt(t.charAt(i + 2), 10);
       }

  // If the resulting sum is an even multiple of ten (but not zero),
  // the aba routing number is good.

                if (n != 0 && n % 10 == 0)  {
                   //do nothing
                   }else{
                     alert('Routing Number is not in the correct format');
                     document.form1.aba_num.focus();  
                     return false;
                    }

}

//--------------------------------------------------------------------------------------
function validCreditCard() {

var cardType = document.form1.card_type.value;
var cardNumber = document.form1.card_number.value;
var cardNumberMasked = document.getElementById('card_number_masked').value;

var str= cardNumberMasked.match(/XXXXXXX/);
if (str == 'XXXXXXX'){
    var result = 1;
}else{
    var result = 0;
}
//alert('fu');
//alert(result);
cardNumber.trim();
if (cardNumber == ""){
    cardNumber = document.getElementById('card_number_masked').value;
    document.getElementById('card_number').value = cardNumber;
}else if(cardNumber != cardNumberMasked &&  result != 1){
    cardNumber = document.getElementById('card_number_masked').value;
    document.getElementById('card_number').value = cardNumber;
}
var cardName = document.form1.card_name.value;
var cardCvv = document.form1.card_cvv.value;
var cardMonth = document.form1.card_month.value;
var cardYear = document.form1.card_year.value;

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");
cardName= cardName.replace(/\s+/g, "");
cardCvv= cardCvv.replace(/\s+/g, "");

        if(cardType == "") {
           alert('Please select a card type');
           document.form1.card_type.focus();
            return false;
            }

         if(cardName == "") {
            alert('Please enter the name on the Card');
            document.form1.card_name.focus();
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
            document.form1.card_number_masked.focus();
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
       document.form1.card_number_masked.focus();
       return false;
      }


        if(cardCvv == "") {
           alert('Please enter the security code');
           document.form1.card_cvv.focus();
            return false;           
          }
          
         if(isNaN(cardCvv)) {
           alert('Security Code may only contain Numbers');
           document.form1.card_cvv.focus();  
           return false;
          }

        if(cardCvv.length < cvvLength)  {
          alert('Security Code is too short');
          document.form1.card_cvv.focus();   
          return false;
          }
      
        if(cardCvv.length > cvvLength)  {
         alert('Security Code is too long');
         document.form1.card_cvv.focus();  
         return false;
         }
    
    
 if(cardMonth == "")  {
    alert('Please select the \"Card Month\"');
    document.form1.card_month.focus();
    return false;            
    }      
    
 if(cardYear == "")  {
    alert('Please select the \"Card Year\"');
    document.form1.card_year.focus();
    return false;            
    }                
      
      
}    

//----------------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//if the call is coming from the monthly billing radio buttons we update the hidden field in order to parse it
if(fieldName == "monthly_billing")  {
   var fieldValue = document.getElementById(fieldId).value;
                             document.form1.month_billing_type.value = fieldValue;
  }



//==============================
//once the form has been submitted check the payment fields starting with the set monthly billing if present
if(fieldName == "form1")  {

//set the payment field values for selections for payments and or refunds and error checkin
var creditFieldValue = document.form1.credit_pay.value;
var creditField = document.form1.credit_pay;
var achFieldValue = document.form1.ach_pay.value;
var achField = document.form1.ach_pay;
var cashFieldValue = document.form1.cash_pay.value;
var cashField = document.form1.cash_pay;
var checkFieldValue = document.form1.check_pay.value;
var checkNumber = document.form1.check_number.value;
var checkNumberField = document.form1.check_number;
var checkNumberFieldName = 'check_number';
var checkField = document.form1.check_pay;
var prePayTotal = document.form1.prepay_total.value;
var numMonths = document.form1.num_months.value;
var contractKey = document.form1.contract_key.value;

//alert(contractKey);



 if(numMonths == "") {
    alert('Please select a value from the \"Prepaid Months\" drop down menu');
            return false;                                         
   }
 if(prePayTotal == "") {
    alert('Please select a value from the \"Prepaid Months\" drop down menu');
            return false;                                         
   }

            
//================================
      //clean out garb chars
      creditFieldValue = creditFieldValue.replace(/\s+/g, "");
      achFieldValue = achFieldValue.replace(/\s+/g, "");
      cashFieldValue = cashFieldValue.replace(/\s+/g, "");
      checkFieldValue = checkFieldValue.replace(/\s+/g, "");
      
            
if(creditFieldValue != "")  {
      if(isNaN(creditFieldValue)) {
         alert('Credit Payment can only contain numbers');
         document.form1.credit_pay.focus();
         return false;         
         }else{
         var creditBool = checkPaymentFields('CR');
                if(creditBool == false) {
                   return false;
                  }         
         }
   }

if(achFieldValue != "")  {
      if(isNaN(achFieldValue)) {
         alert('ACH Payment can only contain numbers');
         document.form1.ach_pay.focus();
         return false;         
         }else{
         var achBool = checkPaymentFields('BA');
                if(achBool == false) {
                   return false;
                  }         
         }
   }

if(cashFieldValue != "")  {
     if(isNaN(cashFieldValue)) {
        alert('Cash Payment can only contain numbers');
        document.form1.cash_pay.focus();
        return false;        
        }
  }

if(checkFieldValue != "")  {
     if(isNaN(checkFieldValue)) {
        alert('Check Payment can only contain numbers');
        document.form1.check_pay.focus();
        return false;        
        }
  }

//==================================================================               
  if(creditFieldValue == "" && achFieldValue == "" &&  cashFieldValue == "" &&  checkFieldValue == "") {
      alert('Please enter a value into one of the \"Payment Fields\"');
               return false;           
     }
               
                     if(creditFieldValue == "") {
                       creditFieldValue = 0;
                       }
                     if(achFieldValue == "") {
                       achFieldValue = 0;
                       }
                     if(cashFieldValue == "") {
                       cashFieldValue = 0;
                       }
                       
//if a check payment is filled out make sure the check number is entered
if(checkFieldValue == "") {
  checkFieldValue = 0;
  }else{
      if(checkNumber == "") {
         alert('Please enter the check number');
                 checkNumberField.focus();
                 return false;
          }else{
          var checkNumberBool = checkNan(checkNumber,checkNumberFieldName);
                 if(checkNumberBool == false) {
                    return false;
                   }
          }
  }   
               
                    prePayTotal = parseFloat(prePayTotal);
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);    
                
               var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue;      
               
                       
                   if(paymentTotal < prePayTotal)  {
                       alert('You have entered a value or values less than the \"Pre Payment Total\"');
                               return false;
                      }
                   if(paymentTotal > prePayTotal)  {
                       alert('You have entered a value or values greater than the \"Pre Payment Total\"');
                       return false;
                       }
                       
checkPrePay(contractKey);
var testBool = document.form1.bool.value;
     if(testBool == "1") {
         var answer = confirm("A pre-payment already exists for this contract.  Do you wish to continue?");
             if (!answer) {
             return false;
                }          
        }
     
//send off to CS if needed
 if(creditFieldValue != "" || achFieldValue != "") {

   var cardType = document.form1.card_type.value;
   var cardName = document.form1.card_name.value;
   var cardNumber = document.form1.card_number.value;
  var cardNumberMasked = document.getElementById('card_number_masked').value;

var str= cardNumberMasked.match(/XXXXXXX/);
if (str == 'XXXXXXX'){
    var result = 1;
}else{
    var result = 0;
}
//alert('fu');
//alert(result);
cardNumber.trim();
if (cardNumber == ""){
    cardNumber = document.getElementById('card_number_masked').value;
    document.getElementById('card_number').value = cardNumber;
}else if(cardNumber != cardNumberMasked &&  result != 1){
    cardNumber = document.getElementById('card_number_masked').value;
    document.getElementById('card_number').value = cardNumber;
}
   var cardCvv = document.form1.card_cvv.value;
   var cardMonth = document.form1.card_month.value;
   var cardYear = document.form1.card_year.value;

   var bankName = document.form1.bank_name.value;
   var accountType = document.form1.account_type.value;
   var accountName = document.form1.account_name.value;
   var accountNumber = document.form1.account_num.value;
   var routingNumber = document.form1.aba_num.value;

   var streetAddress = document.form1.street_address.value;
   var city = document.form1.city.value;
   var state = document.form1.state.value;
   var zipCode = document.form1.zip.value;
   var homePhone = document.form1.primary_phone.value;
   var email = document.form1.email_address.value;
   var licNumber = document.form1.license_number.value;


 // alert('CardType: '+cardType+'\n CardName: '+cardName+'\n CardNumber: '+cardNumber+'\n CVV: '+cardCvv+'\n CardMonth: '+cardMonth+'\n CardYear: '+cardYear+'\n\n BankName: '+bankName+'\n AccountType: '+accountType+'\n AccountName: '+accountName+'\n AccountNumber: '+accountNumber+'\n Routing Number: '+routingNumber+'\n\n StreetAddress: '+streetAddress+'\n City: '+city+'\n State: '+state+'\n ZipCode: '+zipCode+'\n HomePhone: '+homePhone+'\n Email: '+email+'\n LicNumber: '+licNumber+);

  

   //encode card type
    cardType = encodeURIComponent(cardType);
    cardName = encodeURIComponent(cardName);
    cardNumber = encodeURIComponent(cardNumber);
    cardCvv = encodeURIComponent(cardCvv);
    cardMonth = encodeURIComponent(cardMonth);
    cardYear = encodeURIComponent(cardYear);
    var creditPayment = encodeURIComponent(creditFieldValue);

    //encode banking info
   bankName = encodeURIComponent(bankName);
   accountType = encodeURIComponent(accountType);
   accountName = encodeURIComponent(accountName);
   accountNumber = encodeURIComponent(accountNumber);
   routingNumber = encodeURIComponent(routingNumber);
   streetAddress = encodeURIComponent(streetAddress);
   city = encodeURIComponent(city);
   state = encodeURIComponent(state);
   zipCode = encodeURIComponent(zipCode);
   homePhone = encodeURIComponent(homePhone);
   email = encodeURIComponent(email);
   licNumber = encodeURIComponent(licNumber);
   var achPayment = encodeURIComponent(achFieldValue);
   contractKey = encodeURIComponent(contractKey);


  var cardParameters = "";
  cardParameters = cardParameters+'card_type='+cardType;
  cardParameters = cardParameters+'&card_name='+cardName;
  cardParameters = cardParameters+'&card_number='+cardNumber;
  cardParameters = cardParameters+'&card_cvv='+cardCvv;
  cardParameters = cardParameters+'&card_month='+cardMonth;
  cardParameters = cardParameters+'&card_year='+cardYear;
  cardParameters = cardParameters+'&credit_pay='+creditPayment;

  cardParameters = cardParameters+'&bank_name='+bankName;
  cardParameters = cardParameters+'&account_type='+accountType;
  cardParameters = cardParameters+'&account_name='+accountName;
  cardParameters = cardParameters+'&account_number='+accountNumber;
  cardParameters = cardParameters+'&routing_number='+routingNumber;
  cardParameters = cardParameters+'&account_street='+streetAddress;
  cardParameters = cardParameters+'&account_city='+city;
  cardParameters = cardParameters+'&account_state='+state;
  cardParameters = cardParameters+'&account_zip='+zipCode;
  cardParameters = cardParameters+'&account_phone='+homePhone;
  cardParameters = cardParameters+'&account_email='+email;
  cardParameters = cardParameters+'&lic_number='+licNumber;
  cardParameters = cardParameters+'&ach_pay='+achPayment;
  cardParameters = cardParameters+'&contractKey='+contractKey;

//get ajax request object  and send the params to the form object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }


//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var cardMessage =  xmlHttp.responseText;
                     //alert(cardMessage);
                           if(cardMessage != 1) {             
                             alert(cardMessage);
                             document.form1.card_type.focus();                             
                             }else if(cardMessage == 1) {                             
                             document.getElementById('form1').submit();                          
                             }
                                          
             }
}

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "prePaymentsCardCheck.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(cardParameters);
//========================================

return false;
    
    
   } //end if cc or ach
                          
}

}

