function checkPrePay()  {

$(document).ready(function(){ 

var bit = 1;
var contractKey = $("#contract_key_pre").val();

$.ajax ({
                 type: "POST",
                 async:   false,
                 url: "prePayInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: contractKey},               
                 success: function(data) {
                           if(data == 1) {
                              alert('A pre-payment already exists for this contract');
                                        $("#pre_pay_bool").val(bit);
                                      
                             }
                     }//end function success
              }); //end ajax                       
 });     
 }
//---------------------------------------------------------------------------------------------------------------------------
function sendToCyberSource(creditPayment, achPayment, merchantReferenceCode) {
//alert('fu');
var streetAddress = document.getElementById('street_address').value;
var city = document.getElementById('city').value;
var state = document.getElementById('state').value;
var zipCode = document.getElementById('zip_code').value;
var homePhone = document.getElementById('home_phone').value;
var email = document.getElementById('email').value;
var licNumber = document.getElementById('lic_num').value;

var cardType = document.getElementById('card_type').value;
var cardNumber = document.getElementById('card_number').value;
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
var cardName = document.getElementById('card_name').value;
var cardCvv = document.getElementById('card_cvv').value;
var cardMonth = document.getElementById('card_month').value;
var cardYear = document.getElementById('card_year').value;

var bankName = document.getElementById('bank_name').value;
var accountType = document.getElementById('account_type').value;
var accountName = document.getElementById('account_name').value;
var accountNumber = document.getElementById('account_num').value;

var accountNumberMasked = document.getElementById('account_num_masked').value;

var str= accountNumber.match(/XXXXXXX/);
if (str == 'XXXXXXX'){
    var result = 1;
}else{
    var result = 0;
}
//alert('fu');
//alert(result);
accountNumber.trim();
if (accountNumber == ""){
    accountNumber = document.getElementById('account_num_masked').value;
    document.getElementById('account_num').value = accountNumber;
}else if(accountNumber != accountNumberMasked &&  result != 1){
    accountNumber = document.getElementById('account_num_masked').value;
    document.getElementById('account_num').value = accountNumber;
}



var routingNumber = document.getElementById('aba_num').value;

///encode card type
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
city = encodeURIComponent(city);
state = encodeURIComponent(state);
zipCode = encodeURIComponent(zipCode);
homePhone = encodeURIComponent(homePhone);
email = encodeURIComponent(email);
licNumber = encodeURIComponent(licNumber);
achPayment = encodeURIComponent(achPayment);

merchantReferenceCode = encodeURIComponent(merchantReferenceCode);

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
cardParameters = cardParameters+'&merchant_reference_code='+merchantReferenceCode;




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
                             }else if(cardMessage == 1) {                                                  
                             document.getElementById('form1').submit();                          
                             }
                                          
             }
}

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "billingCardCheck.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(cardParameters);
//========================================

return false;


}

//------------------------------------------------------------------------------------------------------------
function checkCredits() {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var servName = 'serv_num'
var serveNameId;
var fieldBit = "";

        for(var j = 2, row; row = serviceTable.rows[j]; j++) {        
                   serveNameId = (servName + rowId);            
                if(document.getElementById(serveNameId).value != "") {
                   fieldBit = 1;
                  }
                rowId++;
            }

return fieldBit;

}
//--------------------------------------------------------------------------------------------------------
function checkRejections() {

var fieldBit = "";
var rejectTotal = "";

try  
{   
 var payDues = document.form1.elements["pay_dues[]"]; 
 var payName = 'pay_dues';
 var payId;
 var rejectTotalName = 'rejection_total';
 var rejectTotalId;

 
 //takes care of multiple rejections so that other section check boxes will not uncheck
 if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         rejectTotalId = (rejectTotalName +i);
         
           if(document.getElementById(payId).checked == true) {              
              fieldBit =1;
              rejectTotal = document.getElementById(rejectTotalId).value;
              //rejectTotal = parseFloat(rejectTotal);
             }               
        }
   }else{
   
   if(document.getElementById("pay_dues1").checked == true) {
     rejectTotal = document.getElementById("rejection_total1").value;
  //   rejectTotal = parseFloat(rejectTotal);
     fieldBit =1;
     }
     
   }

}
catch(err)
{ }//end catch error

var rejectArray = (fieldBit+'|'+rejectTotal);
return  rejectArray;


}
//---------------------------------------------------------------------------------------------------------
function checkTransferStatus() {

var creditPay = document.form1.credit_pay.value;
var achPay = document.form1.ach_pay.value;
var cashPay = document.form1.cash_pay.value;
var checkPay = document.form1.check_pay.value;

var firstNameOrig = document.form1.first_name_orig.value
var middleNameOrig = document.form1.middle_name_orig.value;
var lastNameOrig = document.form1.first_name_orig.value;
var typeNameOrig = document.form1.type_name_orig.value;
    firstNameOrig = firstNameOrig.replace(/^\s+|\s+$/g,"");
    middleNameOrig = middleNameOrig.replace(/^\s+|\s+$/g,"");
    lastNameOrig = lastNameOrig.replace(/^\s+|\s+$/g,"");
    typeNameOrig = typeNameOrig.replace(/^\s+|\s+$/g,"");
    
var transferFee = document.form1.transfer_fee.value;

var firstName = document.form1.first_name.value
var middleName = document.form1.middle_name.value;
var lastName = document.form1.first_name.value;
      firstName = firstName.replace(/^\s+|\s+$/g,"");
      middleName = middleName.replace(/^\s+|\s+$/g,"");
      lastName = lastName.replace(/^\s+|\s+$/g,"");


if(typeNameOrig != "") {
   var typeName = document.form1.type_name_orig.value;
   }else{
   var typeName = "";
   }

if(firstNameOrig != firstName || middleNameOrig != middleName || lastNameOrig != lastName || typeNameOrig != typeName) {

       if(creditPay == "" && achPay == "" &&  cashPay == "" &&  checkPay == "") {
            alert('The contract holder for this account has changed. A $' +transferFee+ ' processing fee will be charged to this account. Please enter a payment amount into one of the payment fields');
            return false;
         }
  
                     if(creditPay == "") {
                       creditPay = 0;
                       }
                     if(achPay == "") {
                       achPay = 0;
                       }
                     if(cashPay == "") {
                       cashPay = 0;
                       }
                    if(checkPay == "") {
                       checkPay = 0;
                       }
               
               
                    creditPay = parseFloat(creditPay);
                    achPay = parseFloat(achPay);
                    cashPay = parseFloat(cashPay);
                    checkPay = parseFloat(checkPay);  
                    transferFee = parseFloat(transferFee);
                
               var paymentTotal = creditPay + achPay + cashPay + checkPay;      
               
                   if(paymentTotal < transferFee)  {
                       alert('You have entered a value or values less than the \"Transfer Fee\"');
                       return false;
                      }
                   if(paymentTotal > transferFee)  {
                       alert('You have entered a value or values greater than the \"Transfer Fee\"');
                       return false;
                       }  
   
  
      var feeConfirmed = 1;
      document.form1.transfer_fee_confirmed.value = feeConfirmed;     
   
         
 }else{
      var feeConfirmed = 0;
      document.form1.transfer_fee_confirmed.value = feeConfirmed;  
      
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



var accountNumberMasked = document.getElementById('account_num_masked').value;

var str= accountNumber.match(/XXXXXXX/);
if (str == 'XXXXXXX'){
    var result = 1;
}else{
    var result = 0;
}
//alert('fu');
//alert(result);
accountNumber.trim();
if (accountNumber == ""){
    accountNumber = document.getElementById('account_num_masked').value;
    document.getElementById('account_num').value = accountNumber;
}else if(accountNumber != accountNumberMasked &&  result != 1){
    accountNumber = document.getElementById('account_num_masked').value;
    document.getElementById('account_num').value = accountNumber;
}



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

//alert(cardNumber);
//alert(cardNumberMasked);
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
            document.form1.card_number.focus();
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
       document.form1.card_number.focus();
       return false;
      }

if(cardCvv != "") {
      //  if(cardCvv == "") {
      //     alert('Please enter the security code');
      //     document.form1.card_cvv.focus();
      //      return false;           
      //    }
          
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
//----------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------
function checkDayMonth(month, day) {

switch(month)  {
case '01':
 if(day > 31) {
 return false;
 }
break;
case '02':
if(day > 29) {
return false;
}
break;
case '03':
if(day > 31) {
return false;
}
break;
case '04':
if(day > 30) {
return false;
}
break;  
case '05':
if(day >31) {
return false;
}
break;  
case '06':
if(day > 30) {
return false;
}
break;  
case '07':
if(day > 31) {
return false;
}
break; 
case '08':
if(day > 31) {
return false;
}
break; 
case '09':
if(day > 30) {
return false;
}
break; 
case '10':
if(day > 31) {
return false;
}
break;  
case '11':
if(day >30) {
return false;
}
break;  
case '12':
if(day > 31) {
return false;
}
break;  
}


}

//-----------------------------------------------------------------------------------------
function checkGroupInfo(fieldName, fieldId)  {

var  typeName = document.getElementById('type_name').value;
var  typeAddress = document.getElementById('type_address').value;
var  typePhone = document.getElementById('type_phone').value;

if(fieldName != 'type_name') {
   if(typeName == "") {
      alert('Please enter the ' +smallHeader+ ' Name');
      document.getElementById('type_name').focus();
      return false;
      }
}

if(fieldName != 'type_address') {
   if(typeAddress == "") {
     alert('Please enter the ' +smallHeader+ ' Address');
     document.getElementById('type_address').focus();
     return false;
     }
}

if(fieldName != 'type_phone') {
   if(typePhone == "") {
     alert('Please enter the ' +smallHeader+ ' Phone Number');
     document.getElementById('type_phone').focus();
     return false;
     }else{
     var bool = checkPhoneNumber('type_phone');
        if(bool == false) {
           return false;
           }
     }
}     
 

if(typeName == "" && typeAddress == "" && typePhone == "") {
   alert('Please fill out all of the ' +typeHeader);
   document.getElementById('type_name').focus();
   return false;
}

}

//---------------------------------------------------------------------------------------------------------
function checkPrimaryContact(fieldName, fieldId)   {

var firstName = document.getElementById('first_name').value;
var middleName = document.getElementById('middle_name').value;
var lastName = document.getElementById('last_name').value;
var streetAddress = document.getElementById('street_address').value;
var cityVal = document.getElementById('city').value;
var stateVal = document.getElementById('state').value;
var zipCode = document.getElementById('zip_code').value;
var homePhone = document.getElementById('home_phone').value;
var cellPhone = document.getElementById('cell_phone').value;
var emailVal = document.getElementById('email').value;
var dobVal = document.getElementById('dob').value;
var licNumber = document.getElementById('lic_num').value;


var primaryContact = 'Contract Holder';


if(fieldName != 'first_name') {
         if(firstName == "") {
           alert('Please fill out the ' +primaryContact+ ' First Name field');
           document.getElementById('first_name').focus();
           return false;
           }
  }


if(fieldName != 'last_name') {
          if(lastName == "") {
             alert('Please fill out the ' +primaryContact+ ' Last Name field');
             document.getElementById('last_name').focus();
             return false;
             }
}


if(fieldName != 'street_address') {
          if(streetAddress == "") {
            alert('Please fill out the ' +primaryContact+ ' Street Address field');
            document.getElementById('street_address').focus();
            return false;
            }
}


if(fieldName != 'city') {            
          if(cityVal == "") {
           alert('Please fill out the ' +primaryContact+ ' City field');
           document.getElementById('city').focus();
           return false;
           }
}
     
      
if(fieldName != 'state') {      
          if(stateVal == "") {
           alert('Please select a ' +primaryContact+ ' State');
           document.getElementById('state').focus();
           return false;
           } 
}


if(fieldName != 'zip_code') {
          if(zipCode == "") {
           alert('Please fill out the ' +primaryContact+ ' Zip Code field');
           document.getElementById('zip_code').focus();
           return false;
           }else{
           var boolZip = checkZipCode('zip_code');
              if(boolZip == false) {
                return false;
                }
           } 
}


if(fieldName != 'home_phone') {               
         if(homePhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Primary Phone field');
          document.getElementById('home_phone').focus();
          return false;
          }else{
          var boolHphone = checkPhoneNumber('home_phone');
              if(boolHphone == false) {
                return false;
                }                 
          }
}


if(fieldName != 'cell_phone') {     
         if(cellPhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Cell Phone field');
          document.getElementById('cell_phone').focus();
          return false;
          }else{
          var boolCphone = checkPhoneNumber('cell_phone');
              if(boolCphone == false) {
                return false;
                }             
          }  
}


if(fieldName != 'email') {
         if(emailVal == "") {
          alert('Please fill out the ' +primaryContact+ ' Email Address field');
          document.getElementById('email').focus();
          return false;
          }else{
          var boolEmail = checkEmail('email');
              if(boolEmail == false) {
                return false;
                }  
          }
}          


if(fieldName != 'dob') {        
          if(dobVal == "") {
           alert('Please fill out the ' +primaryContact+ ' Date of Birth field');
           document.getElementById('dob').focus();
           return false;
           }else{           
           var boolDob = checkDob('dob');
              if(boolDob == false) {
                return false;
                }  
           }                        
}


if(fieldName != 'lic_num') {
          if(licNumber == "") {
           alert('Please fill out the ' +primaryContact+ ' Drivers License field');
           document.getElementById('lic_num').focus();
           return false;
           }
}

}
//---------------------------------------------------------------------------------------------------------
function checkDob(dobField)  {

var dobValue = document.getElementById(dobField).value;
var dobName = document.getElementById(dobField);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   dobName.focus();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        dobName.focus();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         dobName.focus();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   dobName.focus();                                  
                                   return false;                                                                   
                                  }       
        }
            
   }
   

}
//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber(phoneFieldId)  {

var phoneValue = document.getElementById(phoneFieldId).value;
var phoneName = document.getElementById(phoneFieldId);

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneFieldId).value = formattedPhoneNumber;
        return true;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               phoneName.focus();
               return false;               
    }
    
  

}

//---------------------------------------------------------------------------------------------------------------
function checkZipCode(zipField)  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');       
   document.getElementById(zipField).focus();
   return false;
}

if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('The Zip Code you entered is too short');
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail(emailField)  {

var emailValue = document.getElementById(emailField).value;
var fieldName = document.getElementById(emailField);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          fieldName.focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          fieldName.focus();
		  return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;		 
         }



}


//----------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//var to set return result from cybersource and var for reference type of transaction
var paymentResult = "";
var merchantReferenceTag = "";


//if the call is coming from the monthly billing radio buttons we update the hidden field in order to parse it
if(fieldName == "monthly_billing")  {
   var fieldValue = document.getElementById(fieldId).value;
                             document.form1.month_billing_type.value = fieldValue;
                             document.form1.update_monthly.value = "";
                             document.getElementById('billing_type1').checked = false;
                             document.getElementById('billing_type2').checked = false;   
                             document.getElementById('billing_type3').checked = false;   
                             document.getElementById('billing_type4').checked = false;                               

  }


//check the group type to make sure business or orgnization fields are filled out
var groupType = document.form1.group_type.value;

switch(groupType)  {
case 'Business':
this.smallHeader = "Business";
this.typeHeader = 'Business Information Fields';
this.primaryContact = 'Primary Member';

var boolBus = checkGroupInfo(fieldName, fieldId);
           if(boolBus == false) {      
            return false;
            }
           
break;
case 'Organization':
this.smallHeader = "Organization";
this.typeHeader = 'Organization Information Fields';
this.primaryContact = 'Primary Member';

var boolOrg = checkGroupInfo(fieldName, fieldId);
           if(boolOrg == false) {
             return false;
            }

break;  
case 'Single':
this.primaryContact = "Member";
break;
case 'Family':
this.primaryContact = 'Primary Member';
break;
}


var bool1 = checkPrimaryContact(fieldName, fieldId);
      if(bool1 == false) {
        return false;
       }
//=================================================================
function setContactBit() {

var firstName = document.getElementById('first_name').value;
var middleName = document.getElementById('middle_name').value;
var lastName = document.getElementById('last_name').value;
var streetAddress = document.getElementById('street_address').value;
var cityVal = document.getElementById('city').value;
var stateVal = document.getElementById('state').value;
var zipCode = document.getElementById('zip_code').value;
var homePhone = document.getElementById('home_phone').value;
var cellPhone = document.getElementById('cell_phone').value;
var emailVal = document.getElementById('email').value;
var dobVal = document.getElementById('dob').value;
var licNumber = document.getElementById('lic_num').value;
var newVar = "";
var oldVar = "";
var contactBit = "";
      
      firstName = firstName.trim();
      middleName = middleName.trim();
      lastName = lastName.trim();
      streetAddress = streetAddress.trim();
      cityVal = cityVal.trim();
      stateVal = stateVal.trim();
      zipCode = zipCode.trim();
      homePhone = homePhone.trim();
      cellPhone = cellPhone.trim();
      emailVal = emailVal.trim();
      dobVal = dobVal.trim();
      licNumber = licNumber.trim();

var contactListNew =(firstName+'|'+middleName+'|'+lastName+'|'+streetAddress+'|'+cityVal+'|'+stateVal+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+emailVal+'|'+dobVal+'|'+licNumber);
var contactListOrig = document.getElementById('contact_list').value;

var contactArrayNew = contactListNew.split("|");
var contactArrayOrig = contactListOrig.split("|");

 for(var i=0; i < contactListOrig.length;  i++)  { 

           newVar = contactArrayNew[i];
           oldVar = contactArrayOrig[i];
                  
               if(newVar != oldVar) {               
                 document.getElementById('contact_bit').value = 1;
                 contactBit = 1;
                 }
       }

return contactBit;

}
//=================================================================
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
var cancelFieldValue = document.form1.cancelation_balance.value;
var cancelField = document.form1.cancelation_balance;
var holdFieldValue = document.form1.hold_balance.value;
var pastDueFieldValue = document.form1.past_due_balance.value;
var pastDueField = document.form1.past_due_balance;
var monthlyPayment = document.form1.current_monthly_payments.value;
var updateMonthly = document.form1.update_monthly.value;
var refundTrue = "";
var paymentFlag = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue; 
var upgradeServiceBit = document.form1.upgrade_service_bit.value;
var cancelBit = document.form1.cancel_bit.value;

//checks to see if there is a change in the contact info
var contactBit = setContactBit();


try  
{

var monthVal;

if(document.getElementById('monthly_billing1').checked == true) {
  document.form1.month_billing_type.value = 'CR';
  monthVal = 'CR';
}
if(document.getElementById('monthly_billing2').checked == true) {
  document.form1.month_billing_type.value = 'BA';
  monthVal = 'BA';
}

if(document.getElementById('monthly_billing3').checked == true) {
  document.form1.month_billing_type.value = 'CA';
  monthVal = 'CA';
}

if(document.getElementById('monthly_billing4').checked == true) {
document.form1.month_billing_type.value = 'CH';
monthVal = 'CH';
}


  //check the payment fields to see if they r filled out
   var paymentBool = checkPaymentFields(monthVal); 
         if(paymentBool == false) {
            return false;
            }

  }
catch(err)
  {

  }//end catch error
            
//================================
//now check to see if a refund is available and the checkbox payment type refund id checked
try  
{

var refundBalance = document.form1.refund_balance.value;
      refundBalance = parseFloat(refundBalance);

if(document.form1.refund_balance.value != "0.00") {          
    //check to see if a refund element is checked
     if(document.getElementById('refund_check').checked == false) {
        alert('Please check the \"Set Refund Credit\" check box');
        return false;
        }
   }

   
if(document.form1.refund_balance.value == "0.00") {          
    //check to see if a refund element is checked
     if(document.getElementById('refund_check').checked == true) {
        alert('Please select a Service to refund');
        return false;
        }
   }   

 if(document.getElementById('refund_check').checked == true) {
    refundTrue = 1;
   }else{
    refundTrue = 0;   
   }




//if we pass all the criteria then we set the disabled check boxes to enabled in order to send to the php scripts
var refundTable = document.getElementById("secTab3");
var checkBox = refundTable.getElementsByTagName("input");
var input;

         for(var i=0; i < checkBox.length; i++) {
                 input = checkBox[i];              
              if(input.checked == true) {
                  input.disabled = false;
                 }
             }
           
//here we check to see if this is a member refund and if it is we set a bit so that the system can distiguish from a payment
var refundMembersTable = document.getElementById("groupList");
var checkBox = refundMembersTable.getElementsByTagName("input");
var cbNum = 0;
var input;
var membeRefundBit = 0;

for(var i=0; i < checkBox.length; i++) {
    input = checkBox[i];
        if (input.type == "checkbox" && input.checked==true) {
            membeRefundBit = 1;
           }
    }
  document.getElementById("member_refund_bit").value = membeRefundBit;
//alert(membeRefundBit);

//make sure the invoice has been printed out
if(document.getElementById('refund_check').checked == true  &&  document.form1.refund_balance.value != "0.00") {
   var invoiceBit = document.form1.invoice_bit.value;
         if(invoiceBit == "") {
           alert('Please print out the \"Refund Invoice\" before submitting this form');
                   return false;         
           }
   }

}
catch(err)
{

}//end catch error

//================================
//her we check to see if a payment amount is put into any of the payment fields
var creditPay = document.form1.credit_pay.value;
var achPay = document.form1.ach_pay.value;
var cashPay = document.form1.cash_pay.value;
var checkPay = document.form1.check_pay.value;

      //clean out garb chars
      creditPay = creditPay.replace(/\s+/g, "");
      achPay = achPay.replace(/\s+/g, "");
      cashPay = cashPay.replace(/\s+/g, "");
      checkPay = checkPay.replace(/\s+/g, "");
            
if(creditPay != "")  {
      if(isNaN(creditPay)) {
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

if(achPay != "")  {
      if(isNaN(achPay)) {
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

if(cashPay != "")  {
     if(isNaN(cashPay)) {
        alert('Cash Payment can only contain numbers');
        document.form1.cash_pay.focus();
        return false;        
        }
  }

if(checkPay != "")  {
     if(isNaN(checkPay)) {
        alert('Check Payment can only contain numbers');
        document.form1.check_pay.focus();
        return false;        
        }
  }

//======================================================================
//This takes care of piad cancelations if no refunds are available we need make sure that a value is put into the payment fields
var noRefundRow = 2;
var testRefundRows = document.getElementById('secTab3').rows[1].cells[0].innerHTML;

 if(testRefundRows == 'No Refunds Available') { 
 
      if(cancelBit == 1) {
      
                var response =  confirm('This will process the Cancelation of selected service(s) for this account. Do you wish to continue?');
                   if(!response) {         
                       return false;
                      }               
      
        if(cancelFieldValue != '0.00') {
             if( creditFieldValue == "" && achFieldValue == "" &&  cashFieldValue == "" &&  checkFieldValue == "") {
               alert('Please enter a value into one of the \"Payment Fields\"');
                       return false;           
               }
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
               
               
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);    
                
               var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue;      
               
                   if(paymentTotal < cancelFieldValue)  {
                       alert('You have entered a value or values less than the \"Cancelation Balance Summary\"');
                               return false;
                      }
                   if(paymentTotal > cancelFieldValue)  {
                       alert('You have entered a value or values greater than the \"Cancelation Balance Summary\"');
                       return false;
                       }
         
              //send to cybersource
              if(creditFieldValue != 0 || achFieldValue != 0) {
                    var contractKey = $("#contract_key_pre").val();
                   merchantReferenceTag = 'Cancel Service ' + contractKey;
                   paymentResult = sendToCyberSource(creditFieldValue, achFieldValue, merchantReferenceTag);
                        if(paymentResult == false) {
                           return false;
                          }
                  }                                     
         
         
         }
   }

//=======================================================================
//this handles hold balances 
if(holdFieldValue != '0.00') {

      if(creditFieldValue == "" && achFieldValue == "" &&  cashFieldValue == "" &&  checkFieldValue == "") {
      
      //first check to see if this is a service hold
      var hccTable = document.getElementById("secTab4");
      var serviceHoldBox = 'hold';
      var serviceHoldId = "";
      var rowId = 1;
      var holdServiceBit = "";      
                       for (var j = 2, row; row = hccTable.rows[j]; j++)  { 
                               serviceHoldId = (serviceHoldBox + rowId);
                                  if(document.getElementById(serviceHoldId).checked == true) {
                                     holdServiceBit = 1;
                                    }   
                              rowId++ 
                            }
        if(holdServiceBit == 1) {     
                var holdGrace = document.form1.hold_grace.value;
                       var response =  confirm('This will place a Hold on this member\'s service(s) for a period of up to '+holdGrace+' day(s).  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }                              
           }
     
       //if not a service hold then next check for a member hold
       var memberTable = document.getElementById("groupList");
       var memberHoldBox = 'hold_mem';
       var memberHoldId = "";
       var rowIdTwo = 1;
       var holdMemberBit = ""; 
                       for (var k = 2, row; row = memberTable.rows[k]; k++)  { 
                               memberHoldId = (memberHoldBox + rowIdTwo);
                                  if(document.getElementById(memberHoldId).checked == true) {
                                     holdMemberBit = 1;
                                    }   
                              rowIdTwo++ 
                            }
        if(holdMemberBit == 1) {     
                       var response =  confirm('This will place a Hold on this member\'s access to your service locations. However, this account may still be charged for existing monthly fees.  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }                              
           }                            
                            
                            
                                                    
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
               
               
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);    
                
               var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue;      
             
                   if(paymentTotal < holdFieldValue)  {
                       alert('You have entered a value or values less than the \"Hold Balance Summary\"');
                               return false;
                      }
                   if(paymentTotal > holdFieldValue)  {
                       alert('You have entered a value or values greater than the \"Hold Balance Summary\"');
                       return false;
                       }

              //send to cybersource
              if(creditFieldValue != 0 || achFieldValue != 0) {
                 var contractKey = $("#contract_key_pre").val();
                   merchantReferenceTag = 'Service Hold ' + contractKey;
                   paymentResult = sendToCyberSource(creditFieldValue, achFieldValue, merchantReferenceTag);
                        if(paymentResult == false) {
                           return false;
                          }
                  }                            

}

//==================================================================================
//this checks if there are rejections
var rejectArray = checkRejections();
      rejectArray = rejectArray.split('|');

var rejectionTrue = rejectArray[0];
var rejectionTotal = document.form1.total_balance_due.value;//rejectArray[1];


if(rejectionTrue == 1) {

var rejectBalance = document.form1.total_balance_due.value;


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
               
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);    
                
               var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue;      
               

               var response = confirm('This will process the rejected transaction for this account.  Do you wish to continue?');
                     if(!response) {         
                        return false;
                       }  
                       
                   if(paymentTotal > rejectBalance)  {
                         var answer1 = confirm("You have entered a value or values greater than the \"Reject Balance Summary\". Do you wish to continue?");
                        if (!answer1) {
                          return false;
                         }             
                       }               
          
                   if(paymentTotal < rejectBalance)  {
                        var answer1 = confirm("You have entered a value or values less than the \"Reject Balance Summary\". Do you wish to continue?");
                        if (!answer1) {
                          return false;
                         }          
                       }                         
          
          
          
              //send to cybersource
              if(creditFieldValue != 0 || achFieldValue != 0) {
                 var contractKey = $("#contract_key_pre").val();
                   merchantReferenceTag = 'Reject Payment ' + contractKey;
                   paymentResult = sendToCyberSource(creditFieldValue, achFieldValue, merchantReferenceTag);
                        if(paymentResult == false) {
                           return false;
                          }
                  }                                           


}

//==================================================================================
//this checks to see if a credit is assigned
var creditTrue = checkCredits();

             if(creditTrue != "")  {
                       var response =  confirm('This will extend the Service Term of selected service(s). Do you wish to continue?');
                            if(!response) {   
                              document.getElementById("upgrade_service_bit").value = "";
                               return false;
                              }else{
                              document.getElementById("upgrade_service_bit").value = 1;
                              }
                              
               }     

//=================================================================================
//checks to see if there is a chenge to the contract holder if there is a it alerts the user
if(document.form1.transfer_bit.value == 1) {

var transferBool = checkTransferStatus();

       if(transferBool == false) {
          return false;
          }else{
          transferBool = true;
          }
}

//==================================================================================

//checks for past due balance
if(pastDueFieldValue != '0.00') {

      if(creditFieldValue == "" && achFieldValue == "" &&  cashFieldValue == "" &&  checkFieldValue == "") {
               alert('Please enter a \"Past Due Payment\" value into one of the \"Payment Fields\"');
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
               
               
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);  
                    

                
               var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue;    
               
               
                 var response =  confirm('This will process the Past Due Balance on this account.  Do you wish to continue?');
                            if(!response) {   
                               return false;
                              }


               //sets up for a rejection fee. 
              if(rejectionTrue != 1) {
                //alert(rejectionTrue);
              
                   if(paymentTotal < pastDueFieldValue)  {
                     var answer1 = confirm("You have entered a value or values less than the Past Due Balance Summary. Do you wish to continue?");
                        if (!answer1) {
                          return false;
                         }                                              
                       
                      }
                   if(paymentTotal > pastDueFieldValue)  {
                    var answer2 = confirm("You have entered a value or values greater than the Past Due Balance Summary. Do you wish to continue?");
                        if (!answer2) {
                          return false;
                         }    
              
                       }

                }else{
                       
                       
                             pastDueFieldValue = parseFloat(pastDueFieldValue);
                             rejectionTotal = parseFloat(rejectionTotal);
                       var combinedTotal = pastDueFieldValue + rejectionTotal;
                      // alert(rejectionTotal+ '\n'+pastDueFieldValue+ '\n'+combinedTotal);
                       
                   if(paymentTotal < combinedTotal)  {
                        var answer3 = confirm("You have entered a value or values less than the \"Past Due Balance\" and \"Payment Total\" summary\" . Do you wish to continue?");
                        if (!answer3) {
                          return false;
                         }           
                      }
                   if(paymentTotal > combinedTotal)  {
                       alert('You have entered a value or values greater than the \"Past Due Balance\" and \"Payment Total\" summary\"');
                               return false;
                       }                
                
                }
 
 
 
              //send to cybersource
              if(creditFieldValue != 0 || achFieldValue != 0) {
                 var contractKey = $("#contract_key_pre").val();
                   merchantReferenceTag = 'Past Due Payment ' + contractKey;
                   paymentResult = sendToCyberSource(creditFieldValue, achFieldValue, merchantReferenceTag);
                        if(paymentResult == false) {
                           return false;
                          }
                  }
                 
      
}

//==================================================================================
//checks for the monthly payment
if(refundTrue  == "" &&  cancelBit == "" && holdFieldValue == '0.00' &&  pastDueFieldValue == '0.00' && rejectionTrue == "" && creditTrue == "" && updateMonthly == "" && contactBit == "" && upgradeServiceBit == "")  {


var tfc =document.form1.transfer_fee_confirmed.value;
      tfc = parseInt(tfc);

if(tfc == 0)  {

      if(document.form1.month_billing_type.value != "") {

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
                              
                    creditFieldValue = parseFloat(creditFieldValue);
                    achFieldValue = parseFloat(achFieldValue);
                    cashFieldValue = parseFloat(cashFieldValue);
                    checkFieldValue = parseFloat(checkFieldValue);  

              var paymentTotal = creditFieldValue + achFieldValue + cashFieldValue + checkFieldValue; 
              
                    if(paymentTotal != "") {
                    
                      checkPrePay();
                      var prePayBool = document.form1.pre_pay_bool.value;
                            if(prePayBool == "1") {
                               return false;
                              }
                    
                                  
                       var response =  confirm('This will process a Monthly Payment for this account. Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }               
                                 if(paymentTotal < monthlyPayment)  {
                                    alert('You have entered a value or values less than the \"Current Monthly Payment\"');
                                            return false;
                                   }
                                 if(paymentTotal > monthlyPayment)  {
                                   alert('You have entered a value or values greater than the \"Current Monthly Payment\"');
                                            return false;
                                   }  
                   
                                  
              //send to cybersource
              if(creditFieldValue != 0 || achFieldValue != 0) {
                 var contractKey = $("#contract_key_pre").val();
                   merchantReferenceTag = 'Monthly Payment ' + contractKey;
                   paymentResult = sendToCyberSource(creditFieldValue, achFieldValue, merchantReferenceTag);
                        if(paymentResult == false) {
                           return false;
                          }
                  }                                                                                                     
                                   
                                   
                        }else{   
                        
                            if(document.getElementById('hold1').checked == true) {
                               alert('You must release the hold on this account before making a monthly payment');
                                       return false;
                               }else{
                               var monthVal = document.getElementById("month").value; 
                                    if(monthVal != '0.00') {
                                       alert('Please enter a Monthly Payment into one of the payment fields');
                                       return false;
                                      }else if(monthVal == '0.00') {
                                       alert('There are currently no monthly payments to process');
                                       return false
                                      }
                               }
                        
                        }                       

          }
     }        
    
  }
  
  


//===========================================================================================
//checks to see if there is an upgrade for the monthly billing type
if(refundTrue  == "" &&  cancelFieldValue == '0.00' && holdFieldValue == '0.00' &&  pastDueFieldValue == '0.00' && rejectionTrue == "" && creditTrue == "" && paymentFlag == "" && contactBit == "")  {

             if(updateMonthly != "")  {
                       var response =  confirm('This will update the Monthly BillingType for this member. Do you wish to continue?');
                            if(!response) {         
                               return false;
                              } 
                              
                              if (document.getElementById('monthly_billing1').checked != false) {
                                 
                                var cardNumber = document.getElementById('card_number').value;
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
                                var cardName = document.getElementById('card_name').value;
                                var cardMonth = document.getElementById('card_month').value;
                                var cardYear = document.getElementById('card_year').value;
                                
                                var  ajaxSwitch = 1; 
                                
                                  var parameters = "";
                                  parameters = parameters+'ajax_switch='+ajaxSwitch;
                                  parameters = parameters+'&card_name='+cardName;
                                  parameters = parameters+'&card_number='+cardNumber;
                                  parameters = parameters+'&card_month='+cardMonth;
                                  parameters = parameters+'&card_year='+cardYear;
                                
                                //alert('test2'+cardNumber);
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
                                 
                                xmlHttp.open("POST", "billingPreAuthCard.php", false);
                                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xmlHttp.setRequestHeader("Content-length", parameters.length);
                                xmlHttp.setRequestHeader("Connection", "close");
                                xmlHttp.send(parameters);
                                
                                
                                              successKey =  xmlHttp.responseText;
                                               var dataArray = successKey.split("|");
                                                 var data = dataArray[0];
                                                 var reasonCode = dataArray[1];
                                                 var reasonMessage = dataArray[2]; 
                                   
                                               if(data != 1) {
                                                 alert('Credit Card is invalid! ***'+reasonCode+': '+reasonMessage+'*** Please request a new form of payment.');  
                                                          return false;
                                                } 
                                   

                                
                                              
                               /* $.ajax ({
                                            type: "POST",
                                            url: "billingPreAuthCard.php",
                                            cache: false,
                                            dataType: 'html', 
                                            data: {card_name: cardName, card_number: cardNumber, card_month: cardMonth, card_year: cardYear, ajax_switch: ajaxSwitch},               
                                                 success: function(data) {    
                                                alert(data);
                                                
                                                 var dataArray = data.split("|");
                                                 var data = dataArray[0];
                                                 var reasonCode = dataArray[1];
                                                 var reasonMessage = dataArray[2];
                                                
                                                 if(data != "1") {
                                                    alert('Credit Card is invalid! ***'+reasonCode+': '+reasonMessage+'*** Please request a new form of payment.'); 
                                                         
                                                   }
                                                                            
                                                     }//end function success
                                              }); //end ajax 
                                
                                
                               */ //return false;
                              }                            
               }

}
//==================================================================================
//takes care of contact info update
if(refundTrue  == "" &&  cancelFieldValue == '0.00' && holdFieldValue == '0.00' &&  pastDueFieldValue == '0.00' && rejectionTrue == "" && creditTrue == "" && paymentFlag == "")  {

             if(contactBit != "")  {
                       var response =  confirm('This will update the Contact Info for this member. Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }                              
               }      

}
//------------------------------------------------------------------------------------------------------------------------------------------------




}//end form 1





}

