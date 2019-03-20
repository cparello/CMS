$(document).ready(function(){
//---------------------------------------------------------
function saveScheduleSale(memberId, serviceKey, classNumber, serviceCost, locationId) {

var ajaxSwitch = 1;

$.ajax ({
                type: "POST",
                url: "saveScheduleSale.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, member_id: memberId, service_key: serviceKey, class_number: classNumber, service_cost: serviceCost, location: locationId},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var purchaseBit = dataArray[0]; 
                     var purchaseId = dataArray[1];                      
                    
                          if(purchaseBit == 1) {                    
                                $('#purchase_marker').val(purchaseId);
                            }else{

                               alert('Their was an error processing this sales record.  '+data);     
                           }
                      
                     }//end function success
                 }); //end ajax 

}
//---------------------------------------------------------
function loadClassListTwo(scheduleType, eventDate)  {

var ajaxSwitch =1;


$.ajax ({
                type: "POST",
                url: "loadClassList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, event_date: eventDate},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     
                          if(successBit == 1) {                             
                             $("#classList").html(listings);
                             $("#listings").tablesorter();
                             $('#listings.tablesorter').tablesorter({
                                scrollHeight: 385,
                                widgets: ['scroller']
                               });                 
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 

}
//--------------------------------------------------------------
function loadClassOptionsThree(scheduleType, clubId, className, barCodeType, groupType, firstName, lastName, phone, email) {

var ajaxSwitch = 1;
     className = className.trim();
     
  //takes non member member radios
  var memType = 'N';
      $('input:radio[name=active]').each(function() {
            if($(this).val() == memType) {
               $(this).attr('checked','checked'); 
               }
        });     

//var test =('Scedule Type: '+scheduleType+'\n Club ID: '+clubId+'\n ClassName: '+className+'\n Barcode Type: '+barCodeType);

//alert(test);
//return false;

$.ajax ({
                type: "POST",
                url: "loadClassOptions.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, club_id: clubId, search_string: className, bar_code_type: barCodeType, group_type: groupType},               
                     success: function(data) {  
                     
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     
                          if(successBit == 1) {                             
                             $("#classOptions").html(listings);
                             $("#sm_fname").val(firstName);
                             $("#sm_lname").val(lastName);
                             $("#sm_email").val(email);
                             $("#sm_phone").val(phone);
                              
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 


}
//---------------------------------------------------------
function saveSchedulerMember(memberId, serviceKey, classNumber, firstName, lastName, email, phone) {

var ajaxSwitch = 1;

//alert(firstName+'\n'+lastName+'\n'+email+'\n'+phone+'\n'+memberId+'\n'+serviceKey+'\n'+classNumber);

    $.ajax ({
                 type: "POST",
                 url: "saveScheduleMember.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, first_name: firstName, last_name: lastName, email_address: email, phone_number: phone, member_id: memberId, service_key: serviceKey, class_number: classNumber},              
                 success: function(data) {    
                
                    if(data != 1) {
                        alert('There was an error processing this request. '+data);                                   
                       }
                                                                                  
                     }//end function success
            }); //end ajax              


}
//---------------------------------------------------------
function checkPhoneNumber(phoneValue)  {

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        $("#sm_phone").val(formattedPhoneNumber);
        return true;
     }else{
        alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               $("#sm_phone").focus();
                 return false;               
    }
    
}
//--------------------------------------------------------
function checkEmail(emailValue)  {

// this checks the validity of the email to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("Email address cannot be blank");
          $("#sm_email").focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           $("#sm_email").focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           $("#sm_email").focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          $("#sm_email").focus();
		  return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            $("#sm_email").focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            $("#sm_email").focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            $("#sm_email").focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            $("#sm_email").focus();
		    return false;		 
         }


}
//---------------------------------------------------------
function saveBillingPayments() {

var  creditPay = $('#credit_pay').val();
var  cashPay = $('#cash_pay').val();
var  checkPay = $('#check_pay').val();
var  feeAmount = $('#fee_amount').val();
var  checkNumber = $('#check_number').val();
var  nsfCheckNumber = $('#nsf_check_number').val();
var  transKey = $('#trans_key').val();

var transactionKey = $('#transaction_key').val();
var contractKey = $('#contract_key').val();

    $.ajax ({
                 type: "POST",
                 url: "saveBillingPayments.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_pay: creditPay, cash_pay: cashPay, check_pay: checkPay, check_number: checkNumber, transaction_key: transactionKey,  contract_key: contractKey, fee_amount: feeAmount, nsf_check_number: nsfCheckNumber, trans_key: transKey},              
                 success: function(data) {    
                //alert(data);
                    if(data == 1) {
                       $('#data_bool').val(data);                                
                       }else{  
                       alert(data);
                       return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              

}
//--------------------------------------------------------------------------------------------------
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
$('#purchase_class').click(function() {
        
      var  cashPay = $('#cash_pay').val();
      var  checkPay = $('#check_pay').val();
      var  creditPay = $('#credit_pay').val();
      var  checkNumber = $('#check_number').val();
      var paymentArray = [];
      var  serviceArray = "";
      var  serviceCost = ""      
      var  serviceKey = "";
      var  classNumber = "";
      
      
      var firstName = $("#sm_fname").val();
      var lastName = $("#sm_lname").val();
      var email = $("#sm_email").val();
      var phone = $("#sm_phone").val();
      var memberId = $('#memberId').val();
      var scheduleId = $("#schedule_id").val();
      var bundleId = $("#bundle_id").val();
      var classDate = $("#datepicker").val();
      var classText = $("#class_text").val();
      var typeId = $("#type_id").val();
      var locationId  = $("#location_id").val();
      var className = $("#class_name").val();
      var timeSlot = $("#time_slot").val();
      var bookingCount = $('#booking_count').val();
      var groupType = "";
      var groupTypeTwo = "";
      var ajaxSwitch = 1;


      $('input:radio[name=sessions]').each(function() {
           if($(this).is(':checked')) {
               serviceArray =  $(this).val(); 
               serviceArray = serviceArray.split(",");
               serviceCost = serviceArray[0];
               serviceKey = serviceArray[1];               
               classNumber = $(this).attr('id');               
              }
        });     

//set vars for  confirmation
var serviceCostText = serviceCost;     
      className = className.trim();


    if(memberId == "") {
      alert('Member Id field cannot be empty');
               $('#memberId').focus();
                 return false;
      }
       
    if(serviceCost == "") {
        alert('Please select the number of classes to purchase');
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
     
     
     serviceCost = parseFloat(serviceCost); 
      
   var paymentTotal = checkPay + cashPay + creditPay;    
      
       if(paymentTotal < serviceCost)  {
                       alert('You have entered a value or values less than the \"Class(s) Cost\"');
                               return false;
                      }
                   if(paymentTotal > serviceCost)  {
                       alert('You have entered a value or values greater than the \"Class(s) Cost\"');
                       return false;
                       }                  
 
 
 
   //make sure the contact info is filled out
   if(firstName == "") {
      alert('Please fill out the \"First Name\" field.');
              $("#sm_fname").focus();
                 return false;
      }
 
   if(lastName == "") {
      alert('Please fill out the \"Last Name\" field.');
              $("#sm_lname").focus();
                 return false;
      } 
 
   if(email == "") {
      alert('Please fill out the \"Email\" field.');
              $("#sm_email").focus();
                 return false;
      }else{
      var emailBool = checkEmail(email);
            if(emailBool == false) {
               return false;
              }             
      }
 
   if(phone == "") {
      alert('Please fill out the \"Phone\" field.');
              $("#sm_phone").focus();
                 return false;
      }else{      
      var phoneBool = checkPhoneNumber(phone);
            if(phoneBool == false) {
               return false;
              }              
      }

 
 //set up confirm text
 if(classNumber > 1 && bookingCount != '0') {
    classNumber = parseInt(classNumber);
    var classNumber2 = classNumber - 1;
    var confirmMessage = ('This will process this transaction for 1 '+classText+' and '+classNumber2+' additional class(s) at a cost of '+serviceCostText+'. Do you wish to continue?');
   } 
   
  if(classNumber > 1 && bookingCount == '0') {   
    var confirmMessage = ('This will process this transaction for '+classNumber+' '+className+' class(s) at a cost of '+serviceCostText+'. Do you wish to continue?');
    }
      
  if(classNumber == 1 && bookingCount != '0') {
    var confirmMessage = ('This will process this transaction for 1 '+classText+' at a cost of '+serviceCostText+'. Do you wish to continue?');
   }
   
  if(classNumber == 1 && bookingCount == '0') { 
   var confirmMessage = ('This will process this transaction for 1 '+className+' class at a cost of '+serviceCostText+'. Do you wish to continue?');
   }
 

  var answer = confirm(confirmMessage);
   if (!answer) {
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


//alert(creditPay+ '\n' +cashPay+ '\n' +checkPay);

    $.ajax ({
                 type: "POST",
                 url: "processClassPurchase.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_payment: creditPay, card_type: cardType, card_number: cardNumber, card_name: cardName, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, cash_payment: cashPay, check_payment: checkPay},              
                 success: function(data) {    
                 
                    var dataArray = data.split('|');
                    var paymentStatus = dataArray[0];
                    var transactionId = dataArray[1];                 
                
                    if(paymentStatus == 1) {
                        $('#purchase_class').prop("disabled",false);
                        $('#purchase_class').attr("class", "button1");     
                        saveSchedulerMember(memberId, serviceKey, classNumber, firstName, lastName, email, phone);
                        saveScheduleSale(memberId, serviceKey, classNumber, serviceCostText, locationId);
                        alert('Payment of '+serviceCostText+' successfully processed'); 
                                                                   
                       }else{
                             $('#purchase_class').prop("disabled",false);
                             $('#purchase_class').attr("class", "button1"); 
                             alert('There was an error processing this transaction ' +data);                                      
                       }
                                                                                  
                     }//end function success
            }); //end ajax              
   
       }
 
 
//book class if booking count is not 0 
//===========================================
 if(bookingCount != '0') {
 
$.ajax ({
                type: "POST",
                url: "bookClass.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, member_id: memberId, schedule_id: scheduleId, bundle_id: bundleId, class_date: classDate, type_id: typeId, location: locationId, time_slot: timeSlot},               
                     success: function(data) {  
              
                              var dataArray = data.split('|');                        
                              var successBit = dataArray[0]; 
                              var bookingCount = dataArray[1];
                              var memberType = dataArray[2];
                              var bookingStatus = dataArray[3];                              
                                    groupType = dataArray[4];
                              var firstName = dataArray[5]; 
                              var lastName = dataArray[6]; 
                              var phone = dataArray[7]; 
                              var email = dataArray[8];
                                                            
                              
                              //set booking count
                              $('#booking_count').val(bookingCount);
                                                                 
                          if(successBit == 1) {   
                          
                             alert(classText+ ' successfully booked');
                                     $('#memberId').val("");
                                     $('#memberId').focus();
                                       loadClassListTwo(typeId, classDate);
                                     
                                       if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time');
                                                 $("#masking").hide(500);
                                                 $("#bookWindow").hide(500);
                                         }
                                        
                                     
                            }else if(successBit == 2) {
                                        $('#memberId').val("");
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show(); 
                                           
                                           if(groupType == "") {
                                              groupTypeTwo = 'S';
                                             }
                                           
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time.');   
                                          }     
                                              loadClassListTwo(typeId, classDate);                              
                                              loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                                                
                             }else if(successBit == 3) { 
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show();                                         
                                                                                     
                                          if(memberType == 'G') {
                                             memberType = 'N';
                                            }
                                           
                                           if(groupType == 'S' || groupType == 'F') {
                                             groupTypeTwo = 'S';
                                             }                                             
                                                   
                                  
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time.');   
                                          }                                          
                                               loadClassListTwo(typeId, classDate);                    
                                               loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                                
                                                alert(classText+ ' have expired.  Use the form below to purchase more classes.');
                             
                           
                              }else if(successBit == 4) { 
                                               loadClassListTwo(typeId, classDate);
                                                alert('This class has already been booked by this member');   
                                        
                                        
                              }else if(successBit == 5) {          
                                        $("#memField").hide();
                                        $("#classOptions").show("slow");
                                        $("#paymentWindow").show("slow");
                                        $("#nmInfo").show();                                         
                                                                                     
                                           if(memberType == 'G') {
                                               memberType = 'N';
                                              }
                                                                                                
                                           if(groupType == 'S' || groupType == 'F') {
                                              groupTypeTwo = 'S';
                                             }    
                                             
                                           if(groupType == "") {
                                             groupTypeTwo = 'S';
                                             }
                                  
                                        if(bookingCount == 0) {
                                         alert(classText+ ' is fully booked for this date and time.');   
                                          }                                   
                                               loadClassListTwo(typeId, classDate);
                                               loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                        
                                                alert(classText+ ' service does not exist for this member.  Use the form below to purchase classes.');
                                        
                                        
                              }else{
                             alert(data);                             
                             }
                                          
                     }//end function success
                 }); //end ajax 
 
 
 
   }
//================================================ 
 
 return false;      

          
});
//--------------------------------------------------------------------------------------



 });