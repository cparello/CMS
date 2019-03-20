function openLiabiltyWindow()  {

window.open('liabilityWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//---------------------------------------------------------------------
function openContractWindow()  {
//alert('Open Contract Window'); 
window.open('contractWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//---------------------------------------------------------------------
function setMonthlyBilling()  {
if(document.getElementById('monthly_billing1').checked == true) {
  document.form1.monthly_billing_selected.value = 'CR';
  monthlyBillingType =  'CR';
}
if(document.getElementById('monthly_billing2').checked == true) {
  document.form1.monthly_billing_selected.value = 'BA';
  monthlyBillingType =  'BA';
}

if(document.getElementById('monthly_billing3').checked == true) {
  document.form1.monthly_billing_selected.value = 'CA';
  monthlyBillingType =  'CA';
}

if(document.getElementById('monthly_billing4').checked == true) {
  document.form1.monthly_billing_selected.value = 'CH';
  monthlyBillingType =  'CH';
}

}

//---------------------------------------------------------------------
function checkDobs(dobValue, dobIndex)  {

var dobName = document.getElementById(dobIndex);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   document.getElementById(dobIndex).value ="";
   dobName.focus();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        document.getElementById(dobIndex).value ="";
        dobName.focus();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         document.getElementById(dobIndex).value ="";
         dobName.focus();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   document.getElementById(dobIndex).value ="";
                                   dobName.focus();                                  
                                   return false;                                                                   
                                  }       
        }
      
            
      
   }

}
//-------------------------------------------------------------------------------------------------------------------------
function checkEmails(emailValue, emailIndex)  {

var fieldName = document.getElementById(emailIndex);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          document.getElementById(emailIndex).value ="";
          fieldName.focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailIndex).value ="";
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailIndex).value ="";
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(emailIndex).value ="";
          fieldName.focus();
		   return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;		 
         }

}
//---------------------------------------------------------------------------------------------------------
function checkZipCodes(zipValue, zipIndex)  {

var zipName = document.getElementById(zipIndex);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');
   document.getElementById(zipIndex).value = "";
   zipName.focus();
   return false;
}
if(zipValue.length < 5) {
  alert('The Zip Code you entered is too short');
  document.getElementById(zipIndex).value = "";
  zipName.focus();
  return false;
}

}

//--------------------------------------------------------------------------------------------------------
function checkPhoneNumbers(phoneValue, phoneIndex)  {

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneIndex).value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneIndex).value = "";
               document.getElementById(phoneIndex).focus();
               return false;
    }
    
    
}



//===================================
$(document).ready(function() {

  $(".buttonSubmit").click(function() {
    
    var saleArray = $('#sale_array').val();
    var termsViewed = $('terms_viewed').val(); 
      
       if($('#number_new_memberships').val() > 1){
           alert('You must fill out the liablilty host section due to the fact that you are signing up more than one person.')
        }
        
        if(termsViewed != 1){
           alert('You must read the terms and conditions before preceding.')
        }
            var groupType = $("#group_type").val();

            switch(groupType)  {
            case 'S':
            var length = $('#number_new_memberships').val();
            break;
            }
            
             
            
            var i;
            var memberInfoArray = "";
            var memberEmgContArray = "";
            length = parseInt(length);
            var nameAddArray = "";
            var emgContArray = "";
            
            for(i=1; i <= length; i++)  {
            
            var firstName = '#first_name'+i;
            var middleName = '#middle_name'+i;
            var lastName = '#last_name'+i;
            var streetAddress = '#street_address'+i;
            var cityName = '#city'+i;
            var stateName = '#state'+i;
            var zipCodeNumber = '#zip_code'+i;
            var homePhoneNumber = '#home_phone'+i;
            var cellPhoneNumber = '#cell_phone'+i;
            var emailAddress = '#email'+i;
            var dobDate = '#dob'+i;
            var licNumber = '#lic_num'+i;
            var emgName = '#econt_name'+i;
            var emgRelation = '#econt_relation'+i;
            var emgPhone = '#econt_phone'+i;
            
            //var index = 0;
            //var streetAddressArray = document.getElementsByName('street_address[]');
            //var streetAddress = streetAddressArray[index].value;
            //alert(streetAddress);
            //return false;
            
            var first = $(firstName).val();
            var middle = $(middleName).val();
            var last = $(lastName).val();
            var street = $(streetAddress).val();
            var city = $(cityName).val();
            var state = $(stateName).val();
            var zipCode = $(zipCodeNumber).val();
            var homePhone = $(homePhoneNumber).val();
            var cellPhone = $(cellPhoneNumber).val();
            var email = $(emailAddress).val();
            var dob = $(dobDate).val();
            var license= $(licNumber).val();
            var eName = $(emgName).val();
            var eRelation = $(emgRelation).val();
            var ePhone = $(emgPhone).val();
            //nameAddArray = nameAddArray.replace(/#/g, "");
            street = street.replace(/#/g, "Num");            
            //alert(length);
            //alert(streetAddress);
            //alert(street);
            nameAddArray += (first+'|'+middle+'|'+last+'|'+street+'|'+city+'|'+state+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+email+'|'+dob+'|'+license+'#');
            emgContArray += (eName+'|'+eRelation+'|'+ePhone+'#');
            }
              // alert(nameAddArray);
            $("#member_info_array").val(nameAddArray);
            $("#emg_info_array").val(emgContArray);
      
      
            var nameSalt;
            //now get the address and name info
              if($('input[name=liability_host]:checked').val() == true)   {
                nameSalt = '_lib';
                var boolLib = checkLiabilityContact();
                  if(boolLib == false) {
                     return false;
                     }
                }else{
                    nameSalt = 1;
                    var bool2 = checkPrimaryContact();
                    if(bool2 == false) {
                       return false;
                     }
                }
                //check if the liability host is checked

            var streetAddress = '#street_address'+nameSalt;
            var cityName = '#city'+nameSalt;
            var stateName = '#state'+nameSalt;
            var zipCodeNumber = '#zip_code'+nameSalt;
            var homePhoneNumber = '#home_phone'+nameSalt;
            var emailAddress = '#email'+nameSalt;
            var licNumber = '#lic_num'+nameSalt;
                  
            var streetBill = $(streetAddress).val();
            var cityBill = $(cityName).val();
            var stateBill = $(stateName).val();
            var zipCodeBill = $(zipCodeNumber).val();
            var homePhoneBill = $(homePhoneNumber).val();
            var emailBill = $(emailAddress).val();
            var licenseBill = $(licNumber).val();
                
        
            //do a check onthe credit csrd to auth netif present
            var cardType = $("#card_type").val();
            var cardName = $("#card_name").val();
            var cardNumber = $("#card_number").val();
            var cardCvv = $("#card_cvv").val();
            var cardMonth = $("#card_month").val();
            var cardYear = $("#card_year").val();
            var creditPayment = $("#credit_pay").val();       
            
            var bankName = $("#bank_name").val();
            var accountType = $("#account_type").val();
            var accountName = $("#account_name").val();
            var accountNumber = $("#account_num").val();
            var routingNumber = $("#aba_num").val();
            var achPayment = $("#ach_pay").val();
           // var creditPayment = $("#credit_pay").val();
            var cashPayment = $("#cash_pay").val();
            var checkPayment = $("#check_pay").val();
            var checkNumber = $("#check_number").val();
            var checkNumberField = $("#check_number").val();
            var checkNumberFieldName = 'check_number';
           
           
            //here we make sure that a monthly billing cycle is selected if it exists for the service
            var radioSwitch = $("#setMonth1").html();
             if(radioSwitch != "") {
                var monthlyBillingSelected = "";

                if($('input[name=monthly_billing1]:checked').val() == true) {
                  $("monthly_billing_selected").val('CR');
                  monthlyBillingSelected = 'CR';
                }
                if($('input[name=monthly_billing2]:checked').val() == true) {
                  $("monthly_billing_selected").val('BA');
                  monthlyBillingSelected = 'BA';
                }
                
                if($('input[name=monthly_billing3]:checked').val() == true) {
                  $("monthly_billing_selected").val('CA');
                  monthlyBillingSelected = 'CA';
                }
                
                if($('input[name=monthly_billing4]:checked').val() == true) {
                $("monthly_billing_selected").val('CH');
                monthlyBillingSelected = 'CH';
                }
                
                if($('input[name=monthly_billing1]:checked').val() != true && $('input[name=monthly_billing2]:checked').val() != true && $('input[name=monthly_billing3]:checked').val() != true && $('input[name=monthly_billing4]:checked').val() != true){
                    alert('Please select a Monthly billing option.');
                    return false;
                }
               }   
               
               
               
                
                 
                if(achPayment == "" && creditPayment == "")  {
                    alert('Please enter a payment amount into one or more of the following fields: \"Credit Payment\", \"ACH Payment\"');
                    return false;
                    }  
                                           
                    //make sure the payment amount is the same as todays payment also make sure cc or bank feilds are filled out
                    var todaysPayment = $("#today_payment").val();
                                  todaysPayment = todaysPayment.toFixed(2);
                                  
                    if(achPayment == "") {
                       achPayment = 0;  
                       }else{
                       var bankName = document.form1.bank_name.value;
                       var accountType = document.form1.account_type.value;
                       var accountName = document.form1.account_name.value;
                       var accountNumber = document.form1.account_num.value;
                       var routingNumber = document.form1.aba_num.value;
                       var routingValue = document.getElementById('aba_num').value;
                       var routingName = document.getElementById('aba_num');
                       var i;
                       var n;
                       var t;


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

            if(routingNumber == "")  {
             alert('Please enter the Routing Number');
             document.form1.aba_num.focus();
             return false;            
            }  
            
            
                            
                             
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
                              
                              
                            if(creditPayment == "") {  
                              creditPayment = 0;
                              }else{
                                var cardType = document.form1.card_type.value;
                                var cardName = document.form1.card_name.value;
                                var cardNumber = document.form1.card_number.value;
                                var cardCvv = document.form1.card_cvv.value;
                                var cardMonth = document.form1.card_month.value;
                                var cardYear = document.form1.card_year.value;




           if(cardType == "")  {
             alert('Please select a \"Card Type\"');
             document.form1.card_type.focus();
             return false;            
            }     

            if(cardName == "")  {
             alert('Please enter the \"Name on Card\"');
             document.form1.card_name.focus();
             return false;            
            }            

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
            

            if(cardCvv == "")  {
             alert('Please enter the \"Security Code\"');
             document.form1.card_cvv.focus();
             return false;            
            } 
            
            if(cardCvv != "")  {
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
                    cvvLength = 3; 
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
                            
                            achPayment = parseFloat(achPayment);
                            creditPayment = parseFloat(creditPayment);          
                            
                            
                            var paymentTotals = achPayment + creditPayment;
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


var sig = document.form1.input_name.value;

 if(sig == '')  {
                    var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }


  
               
              

                //disable save button to prevent double charges
                $(".buttonSubmit").attr("disabled", "disabled");
                     //alert('fu');
                
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
                street = encodeURIComponent(street);
                city = encodeURIComponent(city);
                state = encodeURIComponent(state);
                zipCode = encodeURIComponent(zipCode);
                homePhone = encodeURIComponent(homePhone);
                email = encodeURIComponent(email);
                licNumber = encodeURIComponent(licNumber);
                achPayment = encodeURIComponent(achPayment);
                
                
                 $.ajax ({
                 type: "POST",
                 url: "contractCardCheck.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {card_type: cardType, card_name: cardName, card_number: cardNumber, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, credit_pay: creditPayment, bank_name: bankName, account_type: accountType, account_name: accountName, account_number: accountNumber, routing_number: routingNumber, account_street: streetBill, account_city: cityBill, account_state: stateBill, account_zip: zipCodeBill, account_phone: homePhoneBill, account_email: emailBill, lic_number: licenseBill, ach_pay: achPayment},              
                 success: function(data) {    
                alert(data)
                         
                    if(data != 1) {
                        $('.buttonSubmit').prop('disabled', false);
                        alert(data);
                        $( "#card_type" ).focus();
                       }else if(data == 1) {
                        setTimeout('openContractWindow()', 1000);                  
                                             }
                                             
                     }//end function success
                    
              }); //end ajax              
         
        
    });
});
//--------------------------------------------------------
$(document).ready(function() {

  $(".header").toggle(function() {
                    $(this).css("color", "#FFFFFF");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FCB040");
                    $(this).find('span').html('+');	
               });

  jQuery('.content').hide();
 // toggle the componenet with class msg_body
  jQuery('.header').click(function()  {
               $('terms_viewed').val('1');  
   jQuery(this).next('.content').slideToggle(500);
     
  });
});
//------------------------------------------------------------------------------------------------------------------------------------------------
function setPaymentRadioButtons(monthTotal)   {

var monthlyBool = document.getElementById('monthly_bool').value;
//get the file permissions for the radios
var monthBit = document.form1.month_bit.value;
var monthBitArray = monthBit.split("");
var creditDisabled;
var bankDisabled;
var cashDisabled;
var checkDisabled;

if(monthBitArray[0] == 1) {
    cashDisabled = "";
    }else{
    cashDisabled ='disabled="disabled"';
    }
    
if(monthBitArray[1] == 1) {
    checkDisabled = "";
    }else{
    checkDisabled ='disabled="disabled"';
    }

if(monthBitArray[2] == 1) {
    bankDisabled = "";
    }else{
    bankDisabled ='disabled="disabled"';
    }    
    
if(monthBitArray[3] == 1) {
    creditDisabled = "";
    }else{
    creditDisabled ='disabled="disabled"';
    }    


var buttonTitle= 'Set Monthly Billing:';
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id)"'+creditDisabled+'/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"'+bankDisabled+'/>';
var cashRadio =  '<input type="radio"  id="monthly_billing3" name="monthly_billing"   value="CA" onClick="return checkServices(this.name,this.id)"'+cashDisabled+'/>';
var checkRadio =  '<input type="radio" id="monthly_billing4"  name="monthly_billing"  value="CH" onClick="return checkServices(this.name,this.id)"'+checkDisabled+'/>';

if(monthlyBool == "0")  {
document.getElementById('setMonth1').innerHTML = "";
document.getElementById('setMonth2').innerHTML = "";
document.getElementById('setMonth3').innerHTML = "";
document.getElementById('setMonth4').innerHTML = "";
document.getElementById('setMonthCredit').innerHTML = "";
document.getElementById('setMonthBank').innerHTML = "";
document.getElementById('setMonthCash').innerHTML = "";
document.getElementById('setMonthCheck').innerHTML = "";
}else{
document.getElementById('setMonth1').innerHTML = buttonTitle;
document.getElementById('setMonth2').innerHTML = buttonTitle;
document.getElementById('setMonth3').innerHTML = buttonTitle;
document.getElementById('setMonth4').innerHTML = buttonTitle;
document.getElementById('setMonthCredit').innerHTML = creditRadio;
document.getElementById('setMonthBank').innerHTML = bankRadio;
document.getElementById('setMonthCash').innerHTML = cashRadio;
document.getElementById('setMonthCheck').innerHTML = checkRadio;
}

}
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
function setTodaysPayment()  {
//alert(todaysPayment);
var totalDue;
var balanceDue;
var balanceDueForm;

setPaymentRadioButtons();

totalDue = document.getElementById('balance_due').value;
totalDueBackup = document.getElementById('balance_due_backup').value;
todaysPayment = document.getElementById('today_payment').value;
//alert('today pay '+totalDue);
//alert(monthlyPayment);
if(isNaN(todaysPayment)) {
  todaysPayment = 0;
  }

totalDue = parseFloat(totalDue);

todaysPayment = parseFloat(todaysPayment);

  
balanceDue = totalDueBackup - todaysPayment;
balanceDueForm = balanceDue;
balanceDueForm = balanceDueForm.toFixed(2);

if(totalDue == 0) {
balanceDue = 0;
todaysPayment = 0;
balanceDueForm = "";

//set the balance due date
//setBalanceDueDate();

}


balanceDue = balanceDue.toFixed(2); 
//
todaysPayment = todaysPayment.toFixed(2);
if(isNaN(balanceDue)) {
  balanceDue = totalDueBackup;
  }
document.form1.balance_due.value = balanceDueForm;
document.getElementById('balance_due').value = balanceDue;
//document.getElementById('today_payment').value = todaysPayment;
document.getElementById('todayPayTwoTotal').innerHTML = todaysPayment;

}
//================================================================
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

//---------------------------------------------------------------------------------------------------------------------------------------------
function getMemberNumber()   {

              var memberNumber = document.form1.mem_num.value;
                    if(memberNumber == "") {
                      memberNumber = 1;
                     }
              return memberNumber;
}
//---------------------------------------------------------------------------------------------------------------------------------------------

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
function checkLiabilityContact()   {

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




          if(firstName == "") {
            alert('Please fill out the Liability Host  First Name field');
            document.getElementById('first_name_lib').focus();
            return false;
            }

          if(lastName == "") {
           alert('Please fill out the Liability Host  Last Name field');
           document.getElementById('last_name_lib').focus();
           return false;
           }

          if(streetAddress == "") {
           alert('Please fill out the Liability Host  Street Address field');
           document.getElementById('street_address_lib').focus();
           return false;
           }

          if(city == "") {
           alert('Please fill out the Liability Host  City field');
           document.getElementById('city_lib').focus();
           return false;
           }

          if(state == "") {
           alert('Please select a Liability Host State');
           document.getElementById('state_lib').focus();
           return false;
           }

          if(zipCode == "") {
           alert('Please fill out the Liability Host  Zip Code field');
           document.getElementById('zip_code_lib').focus();
           return false;
           }

         if(homePhone == "") {
          alert('Please fill out the Liability Host  Primary Phone field');
          document.getElementById('home_phone_lib').focus();
          return false;
          }

          if(cellPhone == "") {
           alert('Please fill out the Liability Host  Cell Phone field');
           document.getElementById('cell_phone_lib').focus();
           return false;
           }

          if(email == "") {
           alert('Please fill out the Liability Host  Email Address field');
           document.getElementById('email_lib').focus();
           return false;
           }

          if(dob == "") {
           alert('Please fill out the Liability Host  Date of Birth field');
           document.getElementById('dob_lib').focus();
           return false;
           }

          if(licNumber == "") {
           alert('Please fill out the Liability Host  Drivers License field');
           document.getElementById('lic_num_lib').focus();
           return false;
           }


if(firstName == "" &&  lastName == "" &&  streetAddress == "" && city == "" && state == "" &&  zipCode == "" && homePhone == "" && cellPhone == "" && email == "" && dob == "" && licNumber == "" ) {
alert('Please fill out all of the Liability Host Information');
document.getElementById('first_name_lib').focus();
return false;
}



}

//------------------------------------------------------------------------------------------------------------------------------------------
function checkPrimaryContact()   {

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




         if(firstName == "") {
           alert('Please fill out the ' +primaryContact+ ' First Name field');
           document.getElementById('first_name1').focus();
           return false;
           }


          if(lastName == "") {
             alert('Please fill out the ' +primaryContact+ ' Last Name field');
             document.getElementById('last_name1').focus();
             return false;
             }




          if(streetAddress == "") {
            alert('Please fill out the ' +primaryContact+ ' Street Address field');
            document.getElementById('street_address1').focus();
            return false;
            }
         
            
            

         if(city == "") {
           alert('Please fill out the ' +primaryContact+ ' City field');
           document.getElementById('city1').focus();
           return false;
          }
            
          
          

        if(state == "") {
          alert('Please select a ' +primaryContact+ ' State');
          document.getElementById('state1').focus();
          return false;
         }

         

        if(zipCode == "") {
          alert('Please fill out the ' +primaryContact+ ' Zip Code field');
          document.getElementById('zip_code1').focus();
          return false;
         }
     
         
         

        if(homePhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Primary Phone field');
          document.getElementById('home_phone1').focus();
          return false;
          }
  



         if(cellPhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Cell Phone field');
          document.getElementById('cell_phone1').focus();
          return false;
          }




          if(email == "") {
           alert('Please fill out the ' +primaryContact+ ' Email Address field');
           document.getElementById('email1').focus();
           return false;
           }
       
           
                     

           if(dob == "") {
            alert('Please fill out the ' +primaryContact+ ' Date of Birth field');
            document.getElementById('dob1').focus();
            return false;
            }

                       

            if(licNumber == "") {
              alert('Please fill out the ' +primaryContact+ ' Drivers License field');
              document.getElementById('lic_num1').focus();
              return false;
              }

    if(contactName == "")  {
       alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Name field');
       document.getElementById('econt_name1').focus();
       return false;
       }

     if(contactRelation == "")  {
      alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Relation field');
      document.getElementById('econt_relation1').focus();
      return false;
      }

    if(contactPhone == "")  {
     alert('Please fill out all of the '  +contactAll+ ' Emergency Contact Phone field');
     document.getElementById('econt_phone1').focus();
     return false;
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

serviceTotal = document.getElementById('balance_due').innerHTML;
serviceTotal = parseFloat(serviceTotal);
todaysPayment = document.form1.today_payment.value;
//balanceDueDate = document.form1.due_date.value;

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

this.primaryContact = "Member";




         
         

//============================================================




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

}




