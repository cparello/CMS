function validCreditCard() {

var cardType = document.form1.card_type.value;
var cardNumber = document.form1.card_number.value;

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");

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
       document.getElementById('card_number').value ="";
       
       document.form1.card_number.focus();
       return false;
      }
      
      
}      
//----------------------------------------------------------------------------------------------------------------------
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

//---------------------------------------------------------------------
function checkMonthlyService()  {

var monthTotal = document.getElementById('serve_month').innerHTML;
      monthTotal = parseFloat(monthTotal);
      
      if(monthTotal == "0.00") {
        alert('Please select a Monthly service');
        return false;
        }
}
//---------------------------------------------------------------------------------------------------------------------------------------------
function newMemberForm() {

//check to see if a contract id has been generated
if(document.form1.contract_key.value != "") {
  alert('WARNING!  This Contract has not been submitted. To submit this Contract please use the "Step 2 Submit Order" button below.  If you wish to cancel this order,  please use the "Cancel Contract" button at the bottom of this page to start over.');
  document.form1.cancel_contract.focus();
  return false; 
  }else{
  window.location = "salesForm.php";
  }

}
//---------------------------------------------------------------------------------------------------------------------------------------------
function getMemberNumber()   {

              var memberNumber = document.form1.mem_num.value;
                    if(memberNumber == "") {
                      memberNumber = 1;
                     }
              return memberNumber;
}
//---------------------------------------------------------------------------------------------------------------------------------------------
function setMemberInfo()  {

var groupType =  document.form1.group_type.value;

switch(groupType)  {
case 'S':
var length = 1;
break;
case 'F':
var length = getMemberNumber();
break;
case 'B':
var length = getMemberNumber(); 
break;
case 'O':
var  length = getMemberNumber(); 
break;  
}
//alert(length);
var i;
var memberInfoArray = "";
var memberEmgContArray = "";
length = parseInt(length);
var nameAddArray = "";
var emgContArray = "";

for(i=1; i <= length; i++)  {

var firstName = 'first_name'+i;
var middleName = 'middle_name'+i;
var lastName = 'last_name'+i;
var streetAddress = 'street_address'+i;
var cityName = 'city'+i;
var stateName = 'state'+i;
var zipCodeNumber = 'zip_code'+i;
var homePhoneNumber = 'home_phone'+i;
var cellPhoneNumber = 'cell_phone'+i;
var emailAddress = 'email'+i;
var dobDate = 'dob'+i;
var licNumber = 'lic_num'+i;
var emgName = 'econt_name'+i;
var emgRelation = 'econt_relation'+i;
var emgPhone = 'econt_phone'+i;

//var index = 0;
//var streetAddressArray = document.getElementsByName('street_address[]');
//var streetAddress = streetAddressArray[index].value;
//alert(streetAddress);
//return false;

var first = document.getElementById(firstName).value;
var middle = document.getElementById(middleName).value;
var last = document.getElementById(lastName).value;
var street = document.getElementById(streetAddress).value;
var city = document.getElementById(cityName).value;
var state = document.getElementById(stateName).value;
var zipCode = document.getElementById(zipCodeNumber).value;
var homePhone = document.getElementById(homePhoneNumber).value;
var cellPhone = document.getElementById(cellPhoneNumber).value;
var email = document.getElementById(emailAddress).value;
var dob = document.getElementById(dobDate).value;
var license= document.getElementById(licNumber).value;
var eName = document.getElementById(emgName).value;
var eRelation = document.getElementById(emgRelation).value;
var ePhone = document.getElementById(emgPhone).value;

nameAddArray += (first+'|'+middle+'|'+last+'|'+street+'|'+city+'|'+state+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+email+'|'+dob+'|'+license+'#');
emgContArray += (eName+'|'+eRelation+'|'+ePhone+'#');
}
  // alert(nameAddArray);
 document.form1.member_info_array.value = nameAddArray;
 document.form1.emg_info_array.value  = emgContArray;
   
   
  } 
   
//----------------------------------------------------------------------------------------------------------------------------------------------
function setMonthlyBilling()  {

var monthlyBillingSelected = "";

if(document.getElementById('monthly_billing1').checked == true) {
  document.form1.monthly_billing_selected.value = 'CR';
  monthlyBillingSelected = 'CR';
}
if(document.getElementById('monthly_billing2').checked == true) {
  document.form1.monthly_billing_selected.value = 'BA';
  monthlyBillingSelected = 'BA';
}

if(document.getElementById('monthly_billing3').checked == true) {
  document.form1.monthly_billing_selected.value = 'CA';
  monthlyBillingSelected = 'CA';
}

if(document.getElementById('monthly_billing4').checked == true) {
document.form1.monthly_billing_selected.value = 'CH';
monthlyBillingSelected = 'CH';
}

return  monthlyBillingSelected;



}
//---------------------------------------------------------------------------------------------------------------------------------------------
function browserKinks() {

 var versionSwitch = document.form1.parse_switch.value;

// if(versionSwitch != "3") {
     this.phoneField=null;
     this.routeField=null;
     this.dobField=null;
     this.cardField=null;
     this.cvvField=null;
     this.zipField=null;
     this.emailField=null;
 // }


}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkRoutingNumber() {

 var routingValue = document.getElementById('aba_num').value;
 var routingName = document.getElementById('aba_num');
 var i;
 var n;
 var t;

 
  if (isNaN(routingValue)) {
   alert('Routing Number may only contain numbers');
   document.getElementById('aba_num').value = "";
   routingName.focus();   
   return false;
   }

  if (routingValue.length < 9) {
     alert('Routing Number is too short. Routing number must be 9 charachters in length.');
     document.getElementById('aba_num').value = "";
     routingName.focus();   
     return false;
    } 
    
   if (routingValue.length > 9) {
     alert('Routing Number is too long. Routing number must be 9 charachters in length.');
     document.getElementById('aba_num').value = "";
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
                     document.getElementById('aba_num').value = "";
                     routingName.focus();   
                     return false;
                    }

}

//-----------------------------------------------------------------------------------------------------------------------------------------------
function checkCvv() {

var cardName = document.form1.card_type.value;
var cvvValue = document.getElementById('card_cvv').value;
var cvvName = document.getElementById('card_cvv');
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
   document.getElementById(cvvField).value = "";
   cvvName.focus();   
   return false;
}

if(cvvValue.length < cvvLength)  {
   alert('Security Code is too short');
   document.getElementById(cvvField).value = "";
   cvvName.focus();   
   return false;
}

if(cvvValue.length > cvvLength)  {
   alert('Security Code is too long');
   document.getElementById(cvvField).value = "";
   cvvName.focus();   
   return false;
}



}

//------------------------------------------------------------------------------------------------------------------------------------------------
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
//--------------------------------------------------------------------------------------------------------------
function checkDob()  {

var dobValue = document.getElementById(dobField).value;
var dobName = document.getElementById(dobField);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   document.getElementById(dobField).value ="";
   dobName.focus();
   browserKinks();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        document.getElementById(dobField).value ="";
        dobName.focus();
        browserKinks();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         document.getElementById(dobField).value ="";
         dobName.focus();
         browserKinks();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   document.getElementById(dobField).value ="";
                                   dobName.focus();
                                   browserKinks();                                   
                                   return false;                                                                   
                                  }       
        }
      
            
      
   }

}
//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber()  {

var phoneValue = document.getElementById(phoneField).value;
var phoneName = document.getElementById(phoneField);

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneField).value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneField).value = "";
               phoneName.focus();
              browserKinks();
               return false;
    }

}
//----------------------------------------------------------------------------------------------------------------
function checkZipCode()  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');   
 //  setTimeout ('document.getElementById(zipField).focus()',300);
 //  setTimeout ('alert(\'Zip Code may only contain Numbers\')', 300);    
   document.getElementById(zipField).value = "";
   document.getElementById(zipField).focus();
   browserKinks();
   return false;
}
if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('The Zip Code you entered is too short');
  document.getElementById(zipField).value = "";
  browserKinks();
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail()  {

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
          document.getElementById(emailField).value ="";
          fieldName.focus(); 
          browserKinks();
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
          browserKinks();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		    return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
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
//--------------------------------------------------------------------------------------------------------------------
function setDobListeners(fieldId) {

this.dobField = fieldId;
var fieldFocus = document.getElementById(dobField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkDob()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkDob()});                           
}          

}
//--------------------------------------------------------------------------------------------------------------------
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
//----------------------------------------------------------------------------------------------------------------------
function checkPrimaryEmergency(fieldId) {

var contactName = document.getElementById('econt_name1').value;
var contactRelation = document.getElementById('econt_relation1').value;
var contactPhone = document.getElementById('econt_phone1').value;

if(primaryContact == "Member") {
  var contactAll = "";
}else{
  var contactAll = primaryContact;
}


if(fieldId != 'econt_name1')  {
    if(contactName == "")  {
       alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Name field');
       document.getElementById('econt_name1').focus();
       return false;
       }
}else{
return true;
}


if(fieldId != 'econt_relation1')  {
     if(contactRelation == "")  {
      alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Relation field');
      document.getElementById('econt_relation1').focus();
      return false;
      }
}else{
return true;
}     
      

if(fieldId != 'econt_phone1')  {
    if(contactPhone == "")  {
     alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Phone field');
     document.getElementById('econt_phone1').focus();
     return false;
     }
}else{
return true;
}     


if(contactName == "" && contactRelation == "" && contactPhone == "") {
alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Information');
document.getElementById('econt_name1').focus();
return false;
}


}
//------------------------------------------------------------------------------------------------------------------------------------------
function checkLiabilityContact(fieldId)   {

var firstName = document.getElementById('first_name_lib').value;
var middleName = document.getElementById('middle_name_lib').value;
var lastName = document.getElementById('last_name_lib').value;
var streetAddress = document.getElementById('street_address_lib').value;
var city = document.getElementById('city_lib').value;
var state = document.getElementById('state_lib').value;
var zipCode = document.getElementById('zip_code_lib').value;
var homePhone = document.getElementById('home_phone_lib').value;
var cellPhone = document.getElementById('cell_phone_lib').value;
var email = document.getElementById('email_lib').value;
var dob = document.getElementById('dob_lib').value;
var licNumber = document.getElementById('lic_num_lib').value;



if(fieldId != 'first_name_lib')  {
          if(firstName == "") {
            alert('Please fill out the Liability Host  First Name field');
            document.getElementById('first_name_lib').focus();
            return false;
            }
}else{
return true;
}


if(fieldId != 'last_name_lib')  {
          if(lastName == "") {
           alert('Please fill out the Liability Host  Last Name field');
           document.getElementById('last_name_lib').focus();
           return false;
           }
}else{
return true;
}           
           
           
if(fieldId != 'street_address_lib')  {
          if(streetAddress == "") {
           alert('Please fill out the Liability Host  Street Address field');
           document.getElementById('street_address_lib').focus();
           return false;
           }
}else{
return true;
}                    
           
           
if(fieldId != 'city_lib')  {
          if(city == "") {
           alert('Please fill out the Liability Host  City field');
           document.getElementById('city_lib').focus();
           return false;
           }
}else{
return true;
}                           
           
                   
if(fieldId != 'state_lib')  {
          if(state == "") {
           alert('Please select a Liability Host State');
           document.getElementById('state_lib').focus();
           return false;
           }
}else{
return true;
}                     
           

if(fieldId != 'zip_code_lib')  {
          if(zipCode == "") {
           alert('Please fill out the Liability Host  Zip Code field');
           document.getElementById('zip_code_lib').focus();
           return false;
           }
}else{
return true;
}                    
           
           
if(fieldId != 'home_phone_lib')  {
         if(homePhone == "") {
          alert('Please fill out the Liability Host  Primary Phone field');
          document.getElementById('home_phone_lib').focus();
          return false;
          }
}else{
return true;
}  


if(fieldId != 'cell_phone_lib')  {
          if(cellPhone == "") {
           alert('Please fill out the Liability Host  Cell Phone field');
           document.getElementById('cell_phone_lib').focus();
           return false;
           }
}else{
return true;
}             
           
           
if(fieldId != 'email_lib')  {
          if(email == "") {
           alert('Please fill out the Liability Host  Email Address field');
           document.getElementById('email_lib').focus();
           return false;
           }
}else{
return true;
}                
           
           
if(fieldId != 'dob_lib')  {
          if(dob == "") {
           alert('Please fill out the Liability Host  Date of Birth field');
           document.getElementById('dob_lib').focus();
           return false;
           }
}else{
return true;
}                
           
           
if(fieldId != 'lic_num_lib')  {
          if(licNumber == "") {
           alert('Please fill out the Liability Host  Drivers License field');
           document.getElementById('lic_num_lib').focus();
           return false;
           }
}else{
return true;
}              
           

if(firstName == "" &&  lastName == "" &&  streetAddress == "" && city == "" && state == "" &&  zipCode == "" && homePhone == "" && cellPhone == "" && email == "" && dob == "" && licNumber == "" ) {
alert('Please fill out all of the Liability Host Information');
document.getElementById('first_name_lib').focus();
return false;
}



}

//------------------------------------------------------------------------------------------------------------------------------------------
function checkPrimaryContact(fieldId)   {

var firstName = document.getElementById('first_name1').value;
var middleName = document.getElementById('middle_name1').value;
var lastName = document.getElementById('last_name1').value;
var streetAddress = document.getElementById('street_address1').value;
var city = document.getElementById('city1').value;
var state = document.getElementById('state1').value;
var zipCode = document.getElementById('zip_code1').value;
var homePhone = document.getElementById('home_phone1').value;
var cellPhone = document.getElementById('cell_phone1').value;
var email = document.getElementById('email1').value;
var dob = document.getElementById('dob1').value;
var licNumber = document.getElementById('lic_num1').value;

var contactName = document.getElementById('econt_name1').value;
var contactRelation = document.getElementById('econt_relation1').value;
var contactPhone = document.getElementById('econt_phone1').value;


if(primaryContact == "Contact") {
  var contactAll = "";
}else{
  var contactAll = primaryContact;
 }



if(fieldId != 'first_name1')  {
         if(firstName == "") {
           alert('Please fill out the ' +primaryContact+ ' First Name field');
           document.getElementById('first_name1').focus();
           return false;
           }
}else{
return true;
}

if(fieldId != 'last_name1')  {
          if(lastName == "") {
             alert('Please fill out the ' +primaryContact+ ' Last Name field');
             document.getElementById('last_name1').focus();
             return false;
             }
}else{
return true;
}


if(fieldId != 'street_address1')  {
          if(streetAddress == "") {
            alert('Please fill out the ' +primaryContact+ ' Street Address field');
            document.getElementById('street_address1').focus();
            return false;
            }
}else{
return true;
}            
            
            
if(fieldId != 'city1')  {
         if(city == "") {
           alert('Please fill out the ' +primaryContact+ ' City field');
           document.getElementById('city1').focus();
           return false;
          }
}else{
return true;
}                 
          
          
if(fieldId != 'state1')  {
        if(state == "") {
          alert('Please select a ' +primaryContact+ ' State');
          document.getElementById('state1').focus();
          return false;
         }
}else{
return true;
}                
         
         
if(fieldId != 'zip_code1')  {
        if(zipCode == "") {
          alert('Please fill out the ' +primaryContact+ ' Zip Code field');
          document.getElementById('zip_code1').focus();
          return false;
         }
}else{
return true;
}                
         
         
if(fieldId != 'home_phone1')  {       
        if(homePhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Primary Phone field');
          document.getElementById('home_phone1').focus();
          return false;
          }
}else{
return true;
}     


if(fieldId != 'cell_phone1')  {
         if(cellPhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Cell Phone field');
          document.getElementById('cell_phone1').focus();
          return false;
          }
}else{
return true;
}     


if(fieldId != 'email1')  {
          if(email == "") {
           alert('Please fill out the ' +primaryContact+ ' Email Address field');
           document.getElementById('email1').focus();
           return false;
           }
}else{
return true;
}                
           
                     
if(fieldId != 'dob1')  {
           if(dob == "") {
            alert('Please fill out the ' +primaryContact+ ' Date of Birth field');
            document.getElementById('dob1').focus();
            return false;
            }
}else{
return true;
}                        
            
                       
if(fieldId != 'lic_num1')  {
            if(licNumber == "") {
              alert('Please fill out the ' +primaryContact+ ' Drivers License field');
              document.getElementById('lic_num1').focus();
              return false;
              }
}else{
return true;
}      


if(fieldId != 'econt_name1')  {
    if(contactName == "")  {
       alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Name field');
       document.getElementById('econt_name1').focus();
       return false;
       }
}else{
return true;
}


if(fieldId != 'econt_relation1')  {
     if(contactRelation == "")  {
      alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Relation field');
      document.getElementById('econt_relation1').focus();
      return false;
      }
}else{
return true;
}     
      

if(fieldId != 'econt_phone1')  {
    if(contactPhone == "")  {
     alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Phone field');
     document.getElementById('econt_phone1').focus();
     return false;
     }
}else{
return true;
}     





if(firstName == "" &&  lastName == "" &&  streetAddress == "" && city == "" && state == "" &&  zipCode == "" && homePhone == "" && cellPhone == "" && email == "" && dob == "" && licNumber == "" ) {
alert('Please fill out all of the '  +contactAll+ ' Contact Information');
document.getElementById('first_name1').focus();
return false;
}


}
//--------------------------------------------------------------------------------------------------------------------------------
function checkGroupInfo(fieldId)  {


var tip = 1;
var  typeName = document.getElementById('type_name').value;
var  typeAddress = document.getElementById('type_address').value;
var  typePhone = document.getElementById('type_phone').value;

if(fieldId != 'type_name')  {
   if(typeName == "") {
      alert('Please enter the ' +smallHeader+ ' Name');
      document.getElementById('type_name').focus();
      return tip;
     }
}else{
return true;
}


if(fieldId != 'type_address')  {
   if(typeAddress == "") {
     alert('Please enter the ' +smallHeader+ ' Address');
     document.getElementById('type_address').focus();
     return tip;
     }
}else{
return true;
}

if(fieldId != 'type_phone')  {
   if(typePhone == "") {
     alert('Please enter the ' +smallHeader+ ' Phone Number');
     document.getElementById('type_phone').focus();
     return tip;
     }
}else{
return true;
}

if(typeName == "" && typeAddress == "" && typePhone == "") {
   alert('Please fill out all of the ' +typeHeader);
   document.getElementById('type_name').focus();
   return tip;
}

}

//-----------------------------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//set an event listener depending on if the fied is an email address zip code or phone number or date of birth
var emailPattern = /email/g;
var emailResult = emailPattern.test(fieldId);
if(emailResult == true) {
this.emailField = fieldId;
setEmailListeners(fieldId);
}
var zipPattern = /zip/g;
var zipResult = zipPattern.test(fieldId);
if(zipResult == true) {
this.zipField = fieldId;
setZipListeners(fieldId);
}
var phonePattern = /phone/g;
var phoneResult = phonePattern.test(fieldId);
if(phoneResult == true) {
this.phoneField = fieldId;
setPhoneListeners(fieldId);
}
var dobPattern = /dob/g;
var dobResult = dobPattern.test(fieldId);
if(dobResult == true) {
this.dobField = fieldId;
setDobListeners(fieldId);
}



var paymentPattern = /^[a-zA-Z]+_pay$/;
var paymentResult = paymentPattern.test(fieldId);
if(paymentResult == true) {
this.paymentField = fieldId;
setPaymentListeners(fieldId);
}


var serviceTotal;
var todaysPayment;
var balanceDueDate;

serviceTotal = document.getElementById('serve_total').innerHTML;
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
           if(serviceTotal != "0.00" && todaysPayment == "") {
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



//check the group type to make sure business or orgnization fields are filled out
var groupType = document.form1.group_type.value;

switch(groupType)  {
case 'B':
this.smallHeader = "Business";
this.typeHeader = 'Business Information Fields';
this.primaryContact = 'Primary Member';

var boolBus = checkGroupInfo(fieldId);
           if(boolBus == 1) {             
             return false;
            }
           
break;
case 'O':
this.smallHeader = "Organization";
this.typeHeader = 'Organization Information Fields';
this.primaryContact = 'Primary Member';

var boolOrg = checkGroupInfo(fieldId);
           if(boolOrg == 1) {
             return false;
            }

break;  
case 'S':
this.primaryContact = "Member";
break;
case 'F':
this.primaryContact = 'Primary Member';
break;
}



//check if the liability host is checked
var openCheck = document.form1.liability_host;
if(openCheck.checked == true) {
var boolLib = checkLiabilityContact(fieldId);
      if(boolLib == false) {
         return false;
         }
}      




//alert(fieldId);

if(openCheck.checked != true) {
var bool2 = checkPrimaryContact(fieldId);
      if(bool2 == false) {
         return false;
         }
}         
         
         
//=======================================================================================
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
//============================================================
//this tests if the submit or print button is selected and the credit card or banking is partially filled out
if(fieldId == 'print_contract' || fieldId == 'save')  {


//check to see if the notes fields are visible
var noteFields = document.getElementById('note').style.visibility;

if(noteFields == 'visible') {
  alert('Please \"Save & Close\" the notes section before choosing this option'); 
          return false;
  }

this.monthlyBillingType = "";

//here we make sure that a monthly billing cycle is selected if it exists for the service
var radioSwitch = document.getElementById('setMonth1').innerHTML;
 if(radioSwitch != "") {

 if(document.getElementById('monthly_billing1').checked == false  && document.getElementById('monthly_billing2').checked == false && document.getElementById('monthly_billing3').checked == false && document.getElementById('monthly_billing4').checked == false) {
 alert('Please select a Monthly Billing option for this contract');
 return false;                         
  }else{
   var monthlySelected = setMonthlyBilling();
   //alert(monthlySelected);
       if(monthlySelected == 'CR')  {
         var cardBool =  checkCardTypes(fieldId);         
             if(cardBool == false) {
                return false;
                }       
          } 
          
       if(monthlySelected == 'BA')  {
         var bankBool =  checkBankTypes(fieldId);
             if(bankBool == false) {
                return false;
                }       
          }           
          
   
  }
    
  }else if(radioSwitch == "")  {
  document.form1.monthly_billing_selected.value = "";
  monthlyBillingType = "";
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
               
//make sure the payment amount is the same as todays payment also make sure cc or bank feilds are filled out
var todaysPayment = document.form1.today_payment.value;
      todaysPayment = parseFloat(todaysPayment);
      
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

//set the member info for submission
setMemberInfo();                 

//do a check onthe credit csrd to auth netif present
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

var nameSalt;
//now get the address and name info
  if(document.form1.liability_host.checked == true)   {
    nameSalt = '_lib';
    }else{
    nameSalt = 1;
    }
    
var streetAddress = 'street_address'+nameSalt;
var cityName = 'city'+nameSalt;
var stateName = 'state'+nameSalt;
var zipCodeNumber = 'zip_code'+nameSalt;
var homePhoneNumber = 'home_phone'+nameSalt;
var cellPhoneNumber = 'cell_phone'+nameSalt;
var emailAddress = 'email'+nameSalt;
var licNumber = 'lic_num'+nameSalt;

var streetAddress = document.getElementById(streetAddress).value;
var city = document.getElementById(cityName).value;
var state = document.getElementById(stateName).value;
var zipCode = document.getElementById(zipCodeNumber).value;
var homePhone = document.getElementById(homePhoneNumber).value;
var email = document.getElementById(emailAddress).value;
var licNumber = document.getElementById(licNumber).value;

//here we make sure that a monthly billing cycle is selected if it exists for the service
var radioSwitch = document.getElementById('setMonth1').innerHTML;
 if(radioSwitch != "") {
    var monthlySelected = setMonthlyBilling();
   }   
//alert(monthlySelected);
//return false;

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
city = encodeURIComponent(city);
state = encodeURIComponent(state);
zipCode = encodeURIComponent(zipCode);
homePhone = encodeURIComponent(homePhone);
email = encodeURIComponent(email);
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
cardParameters = cardParameters+'&account_city='+city;
cardParameters = cardParameters+'&account_state='+state;
cardParameters = cardParameters+'&account_zip='+zipCode;
cardParameters = cardParameters+'&account_phone='+homePhone;
cardParameters = cardParameters+'&account_email='+email;
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
xmlHttp.open("POST", "contractCardCheck.php", true);
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

var message = document.form1.confirmation_message.value; 

if(message != "") {
   alert(message);
  }
}






