function browserKinks() {

 var versionSwitch = document.form1.parse_switch.value;

 if(versionSwitch != "3") {
     this.phoneField=null;
     this.routeField=null;
     this.dobField=null;
     this.cardField=null;
     this.cvvField=null;
     this.zipField=null;
     this.emailField=null;
  }



}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkCardTypes(fieldId) {

var cardType = document.form1.card_type.value;
var cardName = document.form1.card_name.value;
var cardNumber = document.form1.card_number.value;
var cardCvv = document.form1.card_cvv.value;
var cardMonth = document.form1.card_month.value;
var cardYear = document.form1.card_year.value;



if(fieldId != 'card_type')  { 
           if(cardType == "")  {
             alert('Please select a \"Card Type\"');
             document.form1.card_type.focus();
             return false;            
            }     
}else{
return true;
}


if(fieldId != 'card_name')  {
            if(cardName == "")  {
             alert('Please enter the \"Name on Card\"');
             document.form1.card_name.focus();
             return false;            
            }            
}else{
return true;
}


if(fieldId != 'card_number')  {
            if(cardNumber == "")  {
             alert('Please enter the \"Card Number\"');
             document.form1.card_number.focus();
             return false;            
             }
             
             if(cardNumber != "")  {
             var cardBool = validCreditCard();
                  if(cardBool == false) {
                     return false;
                     }             
              }
            
}else{
return true;
}


if(fieldId != 'card_cvv')  {
            if(cardCvv == "")  {
             alert('Please enter the \"Security Code\"');
             document.form1.card_cvv.focus();
             return false;            
            } 
            
            if(cardCvv != "")  {
            var cvvBool = checkCvv();
             if(cvvBool == false) {
                return false;
                }             
             }
            
            
            
}else{
return true;
}


if(fieldId != 'card_month')  {
            if(cardMonth == "")  {
             alert('Please select the \"Card Month\"');
             document.form1.card_month.focus();
             return false;            
            }            
}else{
return true;
}


if(fieldId != 'card_year')  {
            if(cardYear == "")  {
             alert('Please select the \"Card Year\"');
             document.form1.card_year.focus();
             return false;            
            }          
}else{
return true;
}





}

//----------------------------------------------------------------------------------------------------------------------------------------------
function checkBankTypes(fieldId)   {

var bankName = document.form1.bank_name.value;
var accountType = document.form1.account_type.value;
var accountName = document.form1.account_name.value;
var accountNumber = document.form1.account_num.value;
var routingNumber = document.form1.aba_num.value;


if(fieldId != 'bank_name')  { 
            if(bankName == "")  {
             alert('Please enter a Bank Name');
             document.form1.bank_name.focus();
             return false;            
            }                
}else{
return true;
}


if(fieldId != 'account_type')  { 
            if(accountType == "")  {
             alert('Please select an Account Type');
             document.form1.account_type.focus();
             return false;            
            }        
}else{
return true;
}


if(fieldId != 'account_name')  {
            if(accountName == "")  {
             alert('Please enter the name on the account');
             document.form1.account_name.focus();
             return false;            
            }     
}else{
return true;
}


if(fieldId != 'account_num')  {
            if(accountNumber == "")  {
             alert('Please enter the Account Number');
             document.form1.account_num.focus();
             return false;            
            }            
}else{
return true;
}


if(fieldId != 'aba_num')  {
            if(routingNumber == "")  {
             alert('Please enter the Routing Number');
             document.form1.aba_num.focus();
             return false;            
            }  
            
            if(routingNumber != "")  {
            var routingBool = checkRoutingNumber();
             if(routingBool == false) {
                return false;
                }             
             }            
            
            
            
}else{
return true;
}


}

//-----------------------------------------------------------------------------------------------------------------------------------------------
function checkRoutingNumber() {

 var routingValue = document.form1.aba_num.value;
 var routingName = document.form1.aba_num;
 var i;
 var n;
 var t;

 
  if (isNaN(routingValue)) {
   alert('Routing Number may only contain numbers');
   routingName.focus();   
   return false;
   }

  if (routingValue.length < 9) {
     alert('Routing Number is too short. Routing number must be 9 charachters in length.');
     routingName.focus();   
     return false;
    } 
    
   if (routingValue.length > 9) {
     alert('Routing Number is too long. Routing number must be 9 charachters in length.');
     routingName.focus();   
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
                   return true;
                   }else{
                     alert('Routing Number is not in the correct format');
                     routingName.focus();   
                     return false;
                    }

}

//-----------------------------------------------------------------------------------------------------------------------------------------------
function checkCvv() {

var cardName = document.form1.card_type.value;
var cvvValue = document.form1.card_cvv.value;
var cvvName = document.form1.card_cvv;
var cvvLength;

cvvValue = cvvValue.replace(/\s+/g, "");

switch(cardName)  {
case 'Visa':
cvvLength = 3; 
break;
case 'MC':
cvvLength = 3; 
break;
case 'Amex':
cvvLength = 4; 
break;
case 'Disc':
cvvLength = 4; 
break;  
}


if (isNaN(cvvValue)) {
   alert('Security Code may only contain Numbers');
   cvvName.focus();   
   return false;
}

if(cvvValue.length < cvvLength)  {
   alert('Security Code is too short');
   cvvName.focus();   
   return false;
}

if(cvvValue.length > cvvLength)  {
   alert('Security Code is too long');
   cvvName.focus();   
   return false;
}



}
//------------------------------------------------------------------------------------------------------------------------------------------------
function validCreditCard() {

var cardType = document.form1.card_type.value;
var cardNumber = document.form1.card_number.value;

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");


 if(cardNumber != "") {
          
   if (cardType == "Visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Visa';
     }else if(cardType == "MC") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Master Card';
      }else if(cardType == "Disc") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Discover';
      }else if(cardType == "Amex") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
      var cardText = 'American Express';
       }else if(cardType == "Diners") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
      var cardText = 'Diners Club';
      }
   
  
         if(!re.test(cardNumber)) {  
            alert('Invalid ' +cardText+ ' Credit Card Number');
            document.getElementById('card_number').value ="";
            document.form1.card_number.focus();
            return false;
           }

        if(cardType == "") {
           alert('Please select a card type');
           document.form1.card_type.focus();
            return false;
            }
    /*    
         if(cardNumber == "") {
           alert('Please select a card type');
           document.form1.card_type.focus();
            return false;
            }*/
   
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
       return true; 
       }else{
       alert('Invalid Credit Card Number');       
       document.form1.card_number.focus();
       return false;
      }


}//end if card number is not null
      
      
}      
//------------------------------------------------------------------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber()  {

var phoneValue = document.getElementById(phoneField).value;
var phoneName = document.getElementById(phoneField);

var phoneValue2 = document.getElementById(phoneField2).value;

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneField).value = formattedPhoneNumber;
     }else{
               alert('Resetting Phone Number.  You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneField).value = phoneValue2;
               phoneName.focus();
               browserKinks();
               return false;
    }

}
//----------------------------------------------------------------------------------------------------------------
function checkZipCode()  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

var zip2Value = document.getElementById(zipField2).value;


if (isNaN(zipValue)) {
   alert('Resetting Zip Code. Zip Code may only contain Numbers');     
   document.getElementById(zipField).value = zip2Value;
   document.getElementById(zipField).focus();
   browserKinks();
   return false;
}
if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('Resetting Zip Code. The Zip Code you entered is too short');
  document.getElementById(zipField).value = zip2Value;
  document.getElementById(zipField).focus();
 browserKinks();
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail()  {

var emailValue = document.getElementById(emailField).value;
var fieldName = document.getElementById(emailField);

var emailValue2 = document.getElementById(emailField2).value;

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("Resetting email address. Email Address cannot be blank");
          document.getElementById(emailField).value = emailValue2;
          fieldName.focus(); 
          browserKinks();
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("Resetting email address. You have entered an invalid email address");
		   document.getElementById(emailField).value = emailValue2;
           fieldName.focus();
           browserKinks();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("Resetting email address. You have entered an invalid email address");
		   document.getElementById(emailField).value = emailValue2;
           fieldName.focus();
           browserKinks();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("Resetting email address. You have entered an invalid email address");	
		  document.getElementById(emailField).value = emailValue2;
           fieldName.focus();
           browserKinks();
		    return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("Resetting email address. You have entered an invalid email address");
		    document.getElementById(emailField).value = emailValue2;
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("Resetting email address. You have entered an invalid email address");
		    document.getElementById(emailField).value = emailValue2;
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("Resetting email address. You have entered an invalid email address");
		    document.getElementById(emailField).value = emailValue2;
            fieldName.focus();
            browserKinks();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("Resetting email address. You have entered an invalid email address");
		    document.getElementById(emailField).value = emailValue2;
            fieldName.focus();
            browserKinks();
		    return false;		 
         }




}
//------------------------------------------------------------------------------------------------------------------
function setEmailListeners(fieldId) {

this.emailField = fieldId;
var fieldFocus = document.getElementById(emailField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkEmail()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkEmail()});                           
}          

}
//-------------------------------------------------------------------------------------------------------------------
function setZipListeners(fieldId) {

this.zipField = fieldId;
var fieldFocus = document.getElementById(zipField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkZipCode()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkZipCode()});                           
}          


}
//--------------------------------------------------------------------------------------------------------------------
function setPhoneListeners(fieldId) {

this.phoneField = fieldId;
var fieldFocus = document.getElementById(phoneField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkPhoneNumber()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkPhoneNumber()});                           
}          


}

//----------------------------------------------------------------------------------------------------------------------
function setPaymentListeners(fieldId) {

this.paymentField = fieldId;
var fieldFocus = document.getElementById(paymentField);

try 
{

 fieldFocus.addEventListener ('keyup', function () {checkNan(this.value,paymentField)}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {checkNan(this.value,paymentField)});                           
}    


}


//------------------------------------------------------------------------------------------------------------------------------------------
function checkPrimaryContact()   {

//universal account variables
var streetAddress = document.form1.street_address.value;
var cityName = document.form1.city.value;
var zipCode = document.form1.zip.value;
var primaryPhone = document.form1.primary_phone.value;
var cellPhone = document.form1.cell_phone.value;
var emailAddress = document.form1.email.value;

//hidden original variables
var streetAddress2 = document.form1.street_address2.value;
var cityName2 = document.form1.city2.value;
var zipCode2 = document.form1.zip2.value;
var primaryPhone2 = document.form1.primary_phone2.value;
var cellPhone2 = document.form1.cell_phone2.value;
var emailAddress2 = document.form1.email2.value;


if(streetAddress == "") {
alert('Resetting Street Address. Street Address cannot be blank');
document.form1.street_address.value = streetAddress2;
document.form1.street_address.focus();
return false;
}

if(cityName == "") {
alert('Resetting City Field. City field cannot be blank');
document.form1.city.value = cityName2;
document.form1.city.focus();
return false;
}


if(zipCode == "") {
alert('Resetting Zip Code field. Zip Code field cannot be blank');
document.form1.zip.value = zipCode2;
document.form1.zip.focus();
return false;
}

if(primaryPhone == "") {
alert('Resetting Phone Field. Phone field cannot be blank');
document.form1.primary_phone.value = primaryPhone2;
document.form1.primary_phone.focus();
return false;
}

if(cellPhone == "") {
alert('Resetting Phone Field. Phone field cannot be blank');
document.form1.cell_phone.value = cellPhone2;
document.form1.cell_phone.focus();
return false;
}

if(emailAddress == "") {
alert('Resetting Email Address.  Email Address field cannot be blank');
document.form1.email.value = emailAddress2;
document.form1.email.focus();
return false;
}

}
//--------------------------------------------------------------------------------------------------------------------------------
function resetPrimaryContact() {

//hidden original variables
var streetAddress2 = document.form1.street_address2.value;
var cityName2 = document.form1.city2.value;
var zipCode2 = document.form1.zip2.value;
var primaryPhone2 = document.form1.primary_phone2.value;
var cellPhone2 = document.form1.cell_phone2.value;
var emailAddress2 = document.form1.email2.value;
var state2 = document.form1.state2.value;

//universal account variables
document.form1.street_address.value = streetAddress2;
document.form1.city.value = cityName2;
document.form1.zip.value = zipCode2;
document.form1.primary_phone.value = primaryPhone2;
document.form1.cell_phone.value = cellPhone2;
document.form1.email.value = emailAddress2;
document.form1.state.value = state2;
}
//--------------------------------------------------------------------------------------------------------------------------------
function checkGroupInfo()  {

var groupAddress =  document.form1.group_address.value;
var groupPhone =   document.form1.group_phone.value;

var groupAddress2 =  document.form1.group_address2.value;
var groupPhone2 =   document.form1.group_phone2.value;



if(groupAddress == "") {
   alert('Resetting  '+groupType+' Address.  ' +groupType+' Address cannot be blank');
   document.form1.group_address.value = groupAddress2;
   document.form1.group_address.focus();
   return false;
}

if(groupPhone == "")  {
   alert('Resetting  '+groupType+' Phone.  ' +groupType+' Phone cannot be blank');
   document.form1.group_phone.value = groupPhone2;
   document.form1.group_phone.focus();
   return false;
}

}
//-----------------------------------------------------------------------------------------------------------------------
function resetGroupInfo() {

var groupAddress2 =  document.form1.group_address2.value;
var groupPhone2 =   document.form1.group_phone2.value;

document.form1.group_address.value = groupAddress2;
document.form1.group_phone.value = groupPhone2;

}
//-----------------------------------------------------------------------------------------------------------------------
function editPaymentSummary(fieldId) {

var serviceTotal;
var todaysPayment;
var balanceDueDate;

serviceTotal = document.form1.service_total.value;
serviceTotal = parseFloat(serviceTotal);
todaysPayment = document.form1.today_payment.value;
balanceDueDate = document.form1.due_date.value;

//make sure they have selected a service value before proceeding

 if(serviceTotal == "0.00") {
    alert('Please select a service');
    return false;
   }

//make sure they have set todays payment if a service is selected
   if(fieldId != 'today_payment')  {
              if(todaysPayment == "") {
                 alert('Please enter \"Todays Payment\"');
                 document.form1.today_payment.focus();
                 return false;
                 }
       }else{
                 return true;
       }
      
      
//make sure the ballance due date is selected
   if(fieldId != 'rem_day')  {
          if(balanceDueDate == "")  {
             alert('Please select the \"Balance Due Date\"');
             document.form1.rem_day.focus();
             return false;
             }
       }else{
             return true;
       }





}

//-----------------------------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//for business or org types
var enableFields = document.form1.group_marker.value;

var enableSwitch = document.form1.change_info;

//set universal group type
this.groupType = document.form1.group_type.value;

//set an event listener depending on if the fied is an email address zip code or phone number or date of birth
var emailPattern = /email/g;
var emailResult = emailPattern.test(fieldId);
if(emailResult == true) {
this.emailField = fieldId;
this.emailField2 = fieldId+'2';
setEmailListeners(fieldId);
}
var zipPattern = /zip/g;
var zipResult = zipPattern.test(fieldId);
if(zipResult == true) {
this.zipField = fieldId;
this.zipField2 = fieldId+'2';
setZipListeners(fieldId);
}
var phonePattern = /phone/g;
var phoneResult = phonePattern.test(fieldId);
if(phoneResult == true) {
this.phoneField = fieldId;
this.phoneField2 = fieldId+'2';
setPhoneListeners(fieldId);
}


var paymentPattern = /^[a-zA-Z]+_pay$/;
var paymentResult = paymentPattern.test(fieldId);
if(paymentResult == true) {
this.paymentField = fieldId;
setPaymentListeners(fieldId);
}

//check to see if they have switched to edit the contact info
if(enableSwitch.checked == true) {
   var contactBool = checkPrimaryContact();
          if(contactBool == false) {
             return false;
            }
   
        if(enableFields == 1) {
           var groupBool = checkGroupInfo();
                if(groupBool == false) {
                  return false;
                  }           
           
           }    
           
                      
   }else{
     resetPrimaryContact();   
        if(enableFields == 1) {
           resetGroupInfo();
           }         
   }


//====================================================================================
if(fieldId == 'today_payment') {
//check if service is selected
var boon = editPaymentSummary(fieldId);
      if(boon == false)  {
         return false;
         }else{
         return true;
         }
}

//====================================================================================
if(fieldId == 'rem_day') {
//check if service is selected
var boon = editPaymentSummary(fieldId);
      if(boon == false)  {
         return false;
         }else{
         return true;
         }
}

//=====================================================================================
//print contract form check
if(fieldId == 'print_contract') {
//make sure they have made a selection and the payment stuff before editing the account info
var boon = editPaymentSummary(fieldId);
      if(boon == false)  {
         return false;
     }
}

//=====================================================================================
//make sure they have made a selection and the payment stuff before editing the account info
var boonCheck = editPaymentSummary(fieldId);
      if(boonCheck == false)  {
         return false;
     }     
     
//============================================================
//this tests if the submit or print button is selected and the credit card or banking is partially filled out
if(fieldId == 'print_contract' || fieldId == 'form1')  {


//check to see if the notes fields are visible
var noteFields = document.getElementById('note').style.visibility;

if(noteFields == 'visible') {
  alert('Please \"Save & Close\" the notes section before choosing this option'); 
          return false;
  }

 
//===========================================================     
//finally make sure that at least one payment type has been selected
 var achPayment = document.form1.ach_pay.value;
 var creditPayment = document.form1.credit_pay.value;
 var cashPayment = document.form1.cash_pay.value;
 var checkPayment = document.form1.check_pay.value;
 var checkNumber = document.form1.check_number.value;
 var checkNumberField = document.form1.check_number;
 var checkNumberFieldName = 'check_number';

  if(achPayment == "" && creditPayment == "" && cashPayment == "" && checkPayment == "")  {
      alert('Please enter a payment amount into one or more of the following fields: \"Credit Payment\", \"ACH Payment\", \"Check Payment\" or \"Cash Payment\"');
       return false;
     }  
   
   
   if(achPayment == "") {
       achPayment = 0;  
     }else{
    var achBool =  checkBankTypes(fieldId);
          if(achBool == false) {
             return false;
             }    
      }
   
  if(creditPayment == "") {  
  creditPayment = 0;
  }else{
    var cardBool =  checkCardTypes(fieldId);
          if(cardBool == false) {
             return false;
             }    
  }
   
   
//make sure the payment amount is the same as todays payment
var todaysPayment = document.form1.today_payment.value;
      todaysPayment = parseFloat(todaysPayment);
      
if(achPayment == "") {
  achPayment = 0;  
  }
if(creditPayment == "") {  
  creditPayment = 0;
  }
if(cashPayment == "") {
  cashPayment = 0;
  }
  
  
  
//if a check payment is filled out make sure the check number is entered
if(checkPayment == "") {
  checkPayment = 0;
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
  

achPayment = parseFloat(achPayment);
creditPayment = parseFloat(creditPayment);          
cashPayment =  parseFloat(cashPayment);
checkPayment = parseFloat(checkPayment);

var paymentTotals = achPayment + creditPayment + cashPayment + checkPayment;
//check to see if amount is greater than todays payment
            if(paymentTotals > todaysPayment) {
                 paymentTotals = paymentTotals.toFixed(2); 
                 todaysPayment = todaysPayment.toFixed(2); 
               alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is greater than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                return false;
              }

//now check to see if it is less
            if(paymentTotals < todaysPayment) {
                 paymentTotals = paymentTotals.toFixed(2); 
                 todaysPayment = todaysPayment.toFixed(2); 
               alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is less than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                return false;
              }



}
//===========================================================
//this does the final check before the form is submitted
if(fieldId == 'save')  {

var printSwitch = document.form1.print_switch.value;

               if(printSwitch == "")  {
                 alert('Please print out the Sales Contract before submitting this form');
                        document.form1.print_contract.focus();
                         return false;                           
                        }


var cardType = document.form1.card_type.value;
var cardName = document.form1.card_name.value;
var cardNumber = document.form1.card_number.value;
var cardCvv = document.form1.card_cvv.value;
var cardMonth = document.form1.card_month.value;
var cardYear = document.form1.card_year.value;
var creditPayment = document.form1.credit_pay.value;     

var bankName = document.form1.bank_name.value;
var accountType = document.form1.account_type.value;
var accountName = document.form1.account_name.value;
var accountNumber = document.form1.account_num.value;
var routingNumber = document.form1.aba_num.value;

var streetAddress = document.form1.street_address.value;
var cityName = document.form1.city.value;
var stateName = document.form1.state.value;
var zipCode = document.form1.zip.value;
var homePhone = document.form1.primary_phone.value;
var emailAddress = document.form1.email.value;
var licNumber = document.form1.license_number.value;
var achPayment = document.form1.ach_pay.value; 

//send to cs if cc or ach
if(creditPayment != "" ||  achPayment != "") {

//disable save button to prevent double charges
document.getElementById("save").disabled = true;
document.getElementById("save").style.backgroundImage='url(../images/step_two_alt.png)';

//encode card type
cardType = encodeURIComponent(cardType);
cardName = encodeURIComponent(cardName);
cardNumber = encodeURIComponent(cardNumber);
cardCvv = encodeURIComponent(cardCvv);
cardMonth = encodeURIComponent(cardMonth);
cardYear = encodeURIComponent(cardYear);
creditPayment = encodeURIComponent(creditPayment);

//encode banking info
bankName = encodeURIComponent(bankName);
accountType = encodeURIComponent(accountType);
accountName = encodeURIComponent(accountName);
accountNumber = encodeURIComponent(accountNumber);
routingNumber = encodeURIComponent(routingNumber);
streetAddress = encodeURIComponent(streetAddress);
cityName = encodeURIComponent(cityName);
stateName = encodeURIComponent(stateName);
zipCode = encodeURIComponent(zipCode);
homePhone = encodeURIComponent(homePhone);
emailAddress = encodeURIComponent(emailAddress);
licNumber = encodeURIComponent(licNumber);
achPayment = encodeURIComponent(achPayment);


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
cardParameters = cardParameters+'&account_city='+cityName;
cardParameters = cardParameters+'&account_state='+stateName;
cardParameters = cardParameters+'&account_zip='+zipCode;
cardParameters = cardParameters+'&account_phone='+homePhone;
cardParameters = cardParameters+'&account_email='+emailAddress;
cardParameters = cardParameters+'&lic_number='+licNumber;
cardParameters = cardParameters+'&ach_pay='+achPayment;


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
                           if(cardMessage != 1) {  
                             document.getElementById("save").disabled = false;
                             document.getElementById("save").style.backgroundImage='url(../images/step_two.png)';                           
                             alert(cardMessage);
                             document.form1.card_type.focus();                             
                             }else if(cardMessage == 1) {
                             //now we take all of the JS member info generated fields and store them in an array since FF does not recognize innerHTML fields                           
                             
                             document.getElementById('form1').submit();                          
                             }
                                          
             }
}

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "contractCardCheckThree.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(cardParameters);
//========================================

return false;

}else{
document.getElementById('form1').submit();
}

                 
}
//===========================================================



}

//-----------------------------------------------------------------------------------------------------------------------
function checkNan(numberValue,fieldName)  {

//var fullFieldValue = document.form1.today_payment.value;
var fullFieldValue = document.getElementById(fieldName).value;
var newFieldValue;


if(isNaN(fullFieldValue)) {

newFieldValue = fullFieldValue.slice(0,-1);
document.getElementById(fieldName).value = newFieldValue;

  alert('The value you entered is not a number.');
  return false;
  }

}
//------------------------------------------------------------------------------------------------------------------------
function comfirmSale() {

var message = document.form1.confirmation_merssage.value; 

if(message != "") {
   alert(message);
  }
}







