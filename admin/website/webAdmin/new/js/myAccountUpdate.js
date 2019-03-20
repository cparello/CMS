$(document).ready(function() {
    
  
    var checkBox = $('#billType');
    checkBox.on('change', function() {
        var billType = $('#billType').val();
        //alert();
        var card_typePre = $('#card_typePre').val();
        card_typePre.trim();
        if(card_typePre ==""){
            card_typePre = "Select a card type";
        }
        var card_numPre = $('#card_numPre').val();
        var card_monthPre = $('#card_monthPre').val();
        var card_yearPre = $('#card_yearPre').val();
        var card_mtxtPre = $('#card_mtxtPre').val();
        var bank_namePre = $('#bank_namePre').val();
        if(bank_namePre == "Unavailable"){
            bank_namePre = "";
        }
        var bank_typePre = $('#bank_typePre').val();
        bank_typePre.trim();
        if(bank_typePre == ""){
            bank_typePre = "Choose a Bank Type";
        }
        var account_numberPre = $('#account_numberPre').val();
        var routing_numberPre = $('#routing_numberPre').val();
        if(routing_numberPre == 0){
            routing_numberPre = "";
        }
        
        if (billType == "CR"){
            for (var i = 0; i < 10; i++) {
                var year = document.getElementById('yearDrop').value;
                //alert(i);
                year = parseFloat(year);
                i = parseFloat(i);
                year = year + i;
                var yearDropPre = yearDropPre + "<option value=\""+year+"\" >"+year+"</option>";
            }
            
             $('#payForms').html("<li class=\"title\">Credit Card Payment</li><select  name=\"card_type\" id=\"card_type\"><option value=\""+card_typePre+"\" selected>"+card_typePre+"</option><option value=\"Visa\" >Visa</option><option value=\"MC\" >MasterCard</option><option value=\"Amex\" >American Express</option><option value=\"Disc\" >Discover</option></select><input name=\"card_number\" type=\"text\" id=\"card_number\" value=\""+card_numPre+"\" placeholder=\"Card Number\"><label>Exp. Month<select name=\"card_month\" id=\"card_month\"><option value=\""+card_monthPre+"\"  selected >"+card_mtxtPre+"</option><option value=\"01\" >January</option><option value=\"02\" >February</option><option value=\"03\" >March</option><option value=\"04\" >April</option><option value=\"05\" >May</option><option value=\"06\" >June</option><option value=\"07\" >July</option><option value=\"08\" >August</option><option value=\"09\" >September</option><option value=\"10\" >October</option><option value=\"11\" >November</option><option value=\"12\" >December</option></select></label><label>Exp. Year<select name=\"card_year\" id=\"card_year\"><option value=\""+card_yearPre+"\" selected>"+card_yearPre+"</option>"+yearDropPre+"</select></label></label>");
        }else if(billType == "BA"){
            $('#payForms').html("<li class=\"title\">Bank Payment</li><input  name=\"bank_name\" type=\"text\" id=\"bank_name\"  value=\""+bank_namePre+"\" placeholder=\"Bank Name\"><select name=\"account_type\" id=\"account_type\"><option value=\""+bank_typePre+"\" selected>"+bank_typePre+"</option><option value=\"C\" >Personal Checking</option><option value=\"B\" >Business Checking</option><option value=\"S\" >Savings</option></select><input name=\"account_num\" type=\"text\" id=\"account_num\" value=\""+account_numberPre+"\" placeholder=\"Account Number\"><input name=\"aba_num\" type=\"text\" id=\"aba_num\" value=\""+routing_numberPre+"\" placeholder=\"Routing Number\">");
        }else if(billType == "NO"){
            $('msgBox').html("You must select a billing option!");
            return false;
        }
    });
    
   

  $("#updateInfo").click(function() {
    
    var errors = "";
    $('#updateInfo').prop('disabled', true);
     var first_name = $('#first_name').val();
     var middle_name = $('#middle_name').val();
     var last_name = $('#last_name').val();
     var street_address = $('#street_address').val();
     var city = $('#city').val(); 
     var state = $('#state').val();
     var zip_code = $('#zip_code').val();
     var phone = $('#home_phone').val();
     var email = $('#email').val();
     var errorEM = checkEmail(email);
     var contract_key = $('#contract_key').val();
     var dob = $('#dob').val();
     var error1 = checkDob(dob);
     var ajax_switch = 1; 
     var billingType = $('#billType').val();
     var month_bool = $('#month_bool').val();
     
     
     errors = errors + error1;
     errors = errors + errorEM;
     
    //====================phone 
     phone = phone.replace(/\s+/g, " ");

        var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        
        if (regexObj.test(phone)) {
            var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
                document.getElementById('home_phone').value = formattedPhoneNumber;
             }else{
                       errors = errors + 'You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number';
                       document.getElementById('home_phone').value = "";
                       
            }
            
       //===========================zip     
    
        if (isNaN(zip_code)) {
          errors = errors + 'Zip Code may only contain Numbers';
        }
        if(zip_code.length < 5) {
           errors = errors + 'The Zip Code you entered is too short';
        } 
     //==================================
   
     if(first_name == "") {
        errors = errors + 'Please fill out the First Name field.';
        }
     if(last_name == "") {
        errors = errors + '<br>Please fill out the Last Name field.';
        }
     if(street_address == "") {
        errors = errors + '<br>Please fill out the Address field.';
        }
     if(city == "") {
        errors = errors + '<br>Please fill out the City field.';
              }
     if(state == "") {
        errors = errors + '<br>Please select a State.';
        }
     if(zip_code == "") {
        errors = errors + '<br>Please fill out the Zipcode field.';
        }
     if(phone == "") {
        errors = errors + '<br>Please fill out the Phone field.';
        }
     if(email == "") {
        errors = errors + '<br>Please fill out the Email field.';
        }
     if(dob == "") {
        errors = errors + '<br>Please fill out the Date of Birth field.';
        }
     if(billingType == "NO" && month_bool != 0) {
        errors = errors + '<br>You MUST choose a billing type.';
        }
        
                if(errors != ""){
                    $('#msgBox').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#msgBox").css( { "color" : "red"} );
                     $('#updateInfo').prop('disabled', false);
                    return false;
                }
                
                
                
                 $.ajax ({
                 type: "POST",
                 url: "php/updateBillingInfo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {first_name: first_name, middle_name: middle_name, last_name: last_name, street_address: street_address, city: city, state: state, zip_code: zip_code, phone: phone, email: email, dob: dob, contract_key: contract_key, ajax_switch: ajax_switch},              
                 success: function(data) {    
                 //alert(data);
                         
                    if(data != 1) {
                        $('#updateInfo').prop('disabled', false);
                         $('#msgBox').html('Update failed!');
                        $("#msgBox").css( { "color" : "red"} );
                       }else if(data == 1) {
                         $('#msgBox').html('Update Successful!.');
                        $("#msgBox").css( { "color" : "green"} );
                                             }
                                             
                     }//end function success
                    
              }); //end ajax   
           
        }); 
         
    $("#updatePay").click(function() {
        var billingType = $('#billType').val();
        var errors = "";
        var contract_key = document.getElementById('contract_key').value;
        var first_name = $('#first_name').val();
         var middle_name = $('#middle_name').val();
         var last_name = $('#last_name').val();
         var street_address = $('#street_address').val();
         var city = $('#city').val(); 
         var state = $('#state').val();
         var zip_code = $('#zip_code').val();
        //alert(billingType);
            if(billingType == 'BA') {
                var ajax_switch = 2;
                var bankName = document.getElementById('bank_name').value;
                var accountType = document.getElementById('account_type').value;
                var accountNumber = document.getElementById('account_num').value;
                var routingNumber = document.getElementById('aba_num').value;
                var routingValue = document.getElementById('aba_num').value;
                var routingName = document.getElementById('aba_num');
                var i;
                var n;
                var t;


             if(bankName == "")  {
                 errors = errors + '<br>Please enter a Bank Name.';        
                }                

             if(accountType == "")  {
                errors = errors + '<br>Please select an Account Type.';       
                }          

              if(accountNumber == "")  {
                errors = errors + '<br>Please enter the Account Number.';         
                }            

                if(routingNumber == "")  {
                errors = errors + '<br>Please enter the Routing Number.';           
                }  
            
            
                            
                             
                              if (isNaN(routingValue)) {
                                errors = errors + '<br>Routing Number may only contain numbers.';
                               }
                            
                              if (routingValue.length < 9) {
                                 errors = errors + '<br>Routing Number is too short. Routing number must be 9 charachters in length.';
                                } 
                                
                               if (routingValue.length > 9) {
                                errors = errors + '<br>Routing Number is too long. Routing number must be 9 charachters in length.';
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
            
                                            if (n != 0 && n % 10 == 0)  {
                                               return true;
                                               }else{
                                                  errors = errors + '<br>Routing Number is not in the correct format.';
                                                }
  
                              
                              
                         }  
                         
            if(billingType == 'CR') {  
                var ajax_switch = 3;
                var cardType = document.getElementById('card_type').value;
                var cardNumber = document.getElementById('card_number').value;
                var cardMonth = document.getElementById('card_month').value;
                var cardYear = document.getElementById('card_year').value;

                if(cardType == "")  {
                    errors = errors + '<br>Please select a \"Card Type\".';          
                }     

                if(cardNumber == "")  {
                    errors = errors + '<br>Please enter the \"Card Number\".';         
                     }
             
                if(cardNumber != "")  {
                     var cardBool = validCreditCard();
                     if(cardBool == false) {
                        return false;
                     }             
                    }
              
                if(cardMonth == "")  {
                    errors = errors + '<br>Please select the \"Card Month\".';   
                    }            

                if(cardYear == "")  {
                    errors = errors + '<br>Please select the \"Card Year\".';         
                    }          
                  }   
                         
            //alert(cardYear);
                
                if(errors != ""){
                    $('#msgBox2').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#msgBox2").css( { "color" : "red"} );
                     $('#updatePay').prop('disabled', false);
                    return false;
                }
                
                 $.ajax ({
                 type: "POST",
                 url: "php/updateBillingInfo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajax_switch, card_type: cardType, card_number: cardNumber, card_month: cardMonth, card_year: cardYear, bank_name: bankName, account_type: accountType, account_number: accountNumber, routing_number: routingNumber, contract_key: contract_key, first_name: first_name, middle_name: middle_name, last_name: last_name, street_address: street_address, city: city, state: state, zip_code: zip_code},              
                 success: function(data) {    
                 //alert(data);
                         
                    if(data != 1) {
                        $('#updatePay').prop('disabled', false);
                         $('#msgBox2').html('Update Failed!');
                        $("#msgBox2").css( { "color" : "red"} );
                       }else if(data == 1){
                         $('#msgBox2').html('Your update was successful.');
                        $("#msgBox2").css( { "color" : "green"} );
                         }
                                             
                     }//end function success
                    
              }); //end ajax    
       });
         
});

//================================================================
function validCreditCard() {

var cardType = document.getElementById('card_type').value;
var cardNumber = document.getElementById('card_number').value;

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
            document.getElementById('card_number').focus();
            return false;
           }

        if(cardType == "") {
           alert('Please select a card type');
           document.getElementById('card_type').focus();
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
       
       document.getElementById('card_number').focus();
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
function checkDob(dobValue)  {

var errorDob = "";
var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
  errorDob = errorDob + '<br>You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ';
  
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        //alert('You have entered an invalid Date of Birth month');
       errorDob = errorDob + '<br>You have entered an invalid Date of Birth month';
        }
        
      if(dobArray[1] > 31) {
        // alert('You have entered an invalid Date for the day of birth');
        errorDob = errorDob + '<br>You have entered an invalid Date for the day of birth';
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   //alert('The day you entered exceeds the number of days in the month');
                                   errorDob = errorDob + '<br>The day you entered exceeds the number of days in the month';                         
                                                                                               
                                  }       
        }
      
            
      
   }
   
   return errorDob;

}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail(emailValue)  {

var emailErr = "";
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
         emailErr = emailErr + '<br>You have entered an invalid email address';
        
        }
        
		if(emailValue.indexOf(at)==-1){
		    emailErr = emailErr + '<br>You have entered an invalid email address';
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   emailErr = emailErr + '<br>You have entered an invalid email address';
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  emailErr = emailErr + '<br>You have entered an invalid email address';
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    emailErr = emailErr + '<br>You have entered an invalid email address';
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    emailErr = emailErr + '<br>You have entered an invalid email address';
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		   
		     emailErr = emailErr + '<br>You have entered an invalid email address';
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    
		    emailErr = emailErr + '<br>You have entered an invalid email address';
         }

return emailErr;


}