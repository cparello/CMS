$(document).ready(function(){
     $('#credit_pay').prop('disabled', true);
//---------------------------------------------------------
function saveScheduleSale(memberId, serviceKey, classNumber, serviceCost, locationId) {

var ajaxSwitch = 1;
var contractKey = $('#contract_key').val();
saveBillingPayments(); 
$.ajax ({
                type: "POST",
                url: "php/saveScheduleSale.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, member_id: memberId, service_key: serviceKey, class_number: classNumber, service_cost: serviceCost, location: locationId, contractKey: contractKey},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var purchaseBit = dataArray[0]; 
                     var purchaseId = dataArray[1];                      
                    
                          if(purchaseBit == 1) {                    
                                $('#purchase_marker').val(purchaseId);
                            }else{
                                $('#msgBox5').html('There was an error processing this request!'+data+' ');
                                $("#msgBox5").css( { "color" : "red"} );
                                return false;            
                           }
                      
                     }//end function success
                 }); //end ajax 

}
//---------------------------------------------------------
function loadClassListTwo(scheduleType, eventDate)  {

var ajaxSwitch =1;


$.ajax ({
                type: "POST",
                url: "php/loadClassList.php",
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
                            $('#msgBox5').html('There was an error processing this request!'+data+' ');
                            $("#msgBox5").css( { "color" : "red"} );
                            return false;        
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
                url: "php/loadClassOptions.php",
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
                            $('#msgBox5').html('There was an error processing this request!'+data+' ');
                            $("#msgBox5").css( { "color" : "red"} );
                            return false;        
                            }                     
                                          
                     }//end function success
                 }); //end ajax 


}
//---------------------------------------------------------
function saveSchedulerMember(memberId, serviceKey, classNumber, firstName, lastName, email, phone, locationId) {

var ajaxSwitch = 1;
var contractKey = $('#contract_key').val();
//alert(firstName+'\n'+lastName+'\n'+email+'\n'+phone+'\n'+memberId+'\n'+serviceKey+'\n'+classNumber);

    $.ajax ({
                 type: "POST",
                 url: "php/saveScheduleMember.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, first_name: firstName, last_name: lastName, email_address: email, phone_number: phone, member_id: memberId, service_key: serviceKey, class_number: classNumber, location: locationId, contractKey: contractKey},              
                 success: function(data) {    
                
                    if(data != 1) {
                        $('#msgBox5').html('There was an error processing this request!'+data+' ');
                        $("#msgBox5").css( { "color" : "red"} );
                        return false;                                   
                       }
                                                                                  
                     }//end function success
            }); //end ajax              


}
//---------------------------------------------------------
function checkPhoneNumber(phoneValue)  {

phoneValue = phoneValue.replace(/\s+/g, " ");
var error = "";
var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        $("#sm_phone").val(formattedPhoneNumber);
        return error;
     }else{
        error =  'You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number';       return error;           
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
var errors = "";

        if(emailValue == "")  {
          //alert("Email address cannot be blank");
         // $("#sm_email").focus(); 
        //  return false;
          errors = errors + "Email address cannot be blank<br>";
        }
        
		if(emailValue.indexOf(at)==-1){
		 //  alert("You have entered an invalid email address");
          // $("#sm_email").focus();
		  // return false;
           errors = errors + "You have entered an invalid email address<br>";
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		 //  alert("You have entered an invalid email address");
         //  $("#sm_email").focus();
		   //return false;
           errors = errors + "You have entered an invalid email address<br>";
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		 // alert("You have entered an invalid email address");	
        //  $("#sm_email").focus();
		 // return false;
          errors = errors + "You have entered an invalid email address<br>";
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		  //  alert("You have entered an invalid email address");
          ////  $("#sm_email").focus();
		  //  return false;
            errors = errors + "You have entered an invalid email address<br>";
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		  //  alert("You have entered an invalid email address");
          //  $("#sm_email").focus();
		   /// return false;
            errors = errors + "You have entered an invalid email address<br>";
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		   // alert("You have entered an invalid email address");
          //  $("#sm_email").focus();
		  //  return false;
            errors = errors + "You have entered an invalid email address<br>";
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		   // alert("You have entered an invalid email address");
           // $("#sm_email").focus();
		   // return false;
            errors = errors + "You have entered an invalid email address<br>";		 
         }

return errors;
}
//---------------------------------------------------------
function saveBillingPayments() {

var  creditPay = $('#credit_pay').val();
//var  feeAmount = $('#fee_amount').val();
//var  transKey = $('#trans_key').val();

var transactionKey = $('#transaction_key').val();
var contractKey = $('#contract_key').val();

    $.ajax ({
                 type: "POST",
                 url: "php/saveBillingPayments.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_pay: creditPay, transaction_key: transactionKey,  contract_key: contractKey},              
                 success: function(data) {    
                //alert(data);
                    if(data == 1) {
                       $('#data_bool').val(data);                                
                       }else{  
                       $('#msgBox5').html('Failed!'+data+' ');
                        $("#msgBox5").css( { "color" : "red"} );
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
var errors = "";

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");
cardName= cardName.replace(/\s+/g, "");
cardCvv= cardCvv.replace(/\s+/g, "");

        if(cardType == "") {
            errors = errors + "Please select a card type<br>";
            }

         if(cardName == "") {
            errors = errors + "Please enter the name on the Card<br>";
            }
            
         if(cardNumber == "") {
            errors = errors + "Please enter a credit card number<br>";
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
            errors = errors + "Invalid " +cardText+ " Credit Card Number<br>";
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
       errors = errors + "Invalid Credit Card Number<br>";
      }


        if(cardCvv == "") {
            errors = errors + "Please enter the security code<br>";          
          }
          
         if(isNaN(cardCvv)) {
           errors = errors + "Security Code may only contain Numbers<br>";
          }

        if(cardCvv.length < cvvLength)  {
          errors = errors + "Security Code is too short<br>";
          }
      
        if(cardCvv.length > cvvLength)  {
         errors = errors + "Security Code is too long<br>";
         }
    
    
 if(cardMonth == "")  {
    errors = errors + "Please select the \"Card Month\"<br>";
    }      
    
 if(cardYear == "")  {
    errors = errors + "Please select the \"Card Year\"<br>";  
    }                
      
 return   errors;   
}      

//===================================================
$('#purchase_class').click(function() {
        
      $('#msgBox5').html('');
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
      var classDate = $(".datepicker").val();
      var classText = $("#class_text").val();
      var typeId = $("#type_id").val();
      var locationId  = $("#location").val();
      var className = $("#class_name").val();
      var timeSlot = $("#time_slot").val();
      var bookingCount = $('#booking_count').val();
      var groupType = "";
      var groupTypeTwo = "";
      var ajaxSwitch = 1;
      var errors = "";

    /*  $('input:radio[name=sessions]').each(function() {
           if($(this).is(':checked')) {
               serviceArray =  $(this).val(); 
               serviceArray = serviceArray.split(",");
               serviceCost = serviceArray[0];
               serviceKey = serviceArray[1];               
               classNumber = $(this).attr('id'); 
               $('#credit_pay').val(serviceCost);                    
              }
        });  */
      var servBuff = $('input:radio[name=sessions]:checked').val(); 
      var serviceArray = servBuff.split(",");
      serviceCost = serviceArray[0];
      serviceKey = serviceArray[1];  
      classNumber =  $('input:radio[name=sessions]:checked').attr('id');             
      $('#credit_pay').val(serviceCost);     
      var  creditPay = $('#credit_pay').val();    

//set vars for  confirmation
var serviceCostText = serviceCost;     
      className = className.trim();


    if(memberId == "" AND document.getElementById('non_member').checked == false) {
      errors = errors + "Member Id field cannot be empty";
      }
       
    if(serviceCost == "") {
                errors = errors + "Please select the number of classes to purchase.<br>";
       }

      $('#credit_pay').val(creditPay)  
      creditPay = creditPay.replace(/\s+/g, "");
      
if(creditPay == "") {
   creditPay = 0;
  }        
      
     creditPay = parseFloat(creditPay);   
     
     
     serviceCost = parseFloat(serviceCost); 
      
   var paymentTotal = creditPay;    
 
   //make sure the contact info is filled out
   if(firstName == "") {
                 errors = errors + "Please fill out the \"First Name\" field.<br>";
      }
 
   if(lastName == "") {

                 errors = errors + "Please fill out the \"Last Name\" field.<br>";
      } 
 
   if(email == "") {
                 errors = errors + "Please fill out the \"Email\" field.<br>";
      }else{
      var emailBool = checkEmail(email);
            if(emailBool != "") {
               errors = errors + emailBool;
              }             
      }
 
   if(phone == "") {
                 errors = errors + "Please fill out the \"Phone\" field.<br>";
      }else{      
      var phoneBool = checkPhoneNumber(phone);
            if(phoneBool != "") {
               errors = errors + phoneBool;
              }              
      }

   var creditBool = validCreditCard(); 
   if(creditBool != "") {
               errors = errors + creditBool;
              }       
              
              if (errors != ""){
                    $('#msgBox5').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#msgBox5").css( { "color" : "red"} );
                    return false;
              }
 //set up confirm text
/* if(classNumber > 1 && bookingCount != '0') {
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
     }     */                
                       
                       
  
  //send off to payment processor
  if(creditPay > 0) {
  
    $(this).prop("disabled",true);
    //$(this).attr("class", "button2");
  
  var cardType = $('#card_type').val();
  var cardNumber = $('#card_number').val();
  var cardName = $('#card_name').val();
  var cardCvv = $('#card_cvv').val();
  var cardMonth = $('#card_month').val();
  var cardYear = $('#card_year').val();


//alert(creditPay+ '\n' +cashPay+ '\n' +checkPay);
    
  
    $.ajax ({
                 type: "POST",
                 url: "php/processClassPurchase.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {credit_payment: creditPay, card_type: cardType, card_number: cardNumber, card_name: cardName, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, memberId: memberId},              
                 success: function(data) {    
                 //alert(data);
                    var dataArray = data.split('|');
                    var paymentStatus = dataArray[0];
                    var transactionId = dataArray[1];   
                    var contractKey = dataArray[2];
                    
                    $('#contract_key').val(contractKey);
                    $('#transaction_key').val(transactionId);              
                
                    if(paymentStatus == 1) {
                        $('#purchase_class').prop("disabled",true);
                        //$('#purchase_class').attr("class", "button1");     
                        saveSchedulerMember(memberId, serviceKey, classNumber, firstName, lastName, email, phone, locationId);
                        saveScheduleSale(memberId, serviceKey, classNumber, serviceCostText, locationId);
                        //alert('Payment of '+serviceCostText+' successfully processed'); 
                        $('#msgBox5').html('Payment of '+serviceCostText+' successfully processed');
                        $("#msgBox5").css( { "color" : "green"} );                                           
                       }else{
                             $('#purchase_class').prop("disabled",false);
                            // $('#purchase_class').attr("class", "button1"); 
                             $('#msgBox5').html('There was an error processing this transaction ' +data+ 'Please recheck your CC info or use a different card.');
                             $("#msgBox5").css( { "color" : "red"} );
                             return false;                                                
                       }
                                                                                  
                     }//end function success
            }); //end ajax              
         
       }
 
 
//book class if booking count is not 0 
//===========================================
 if(bookingCount != '0') {
 
$.ajax ({
                type: "POST",
                url: "php/bookClass.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, member_id: memberId, schedule_id: scheduleId, bundle_id: bundleId, class_date: classDate, type_id: typeId, location: locationId, time_slot: timeSlot},               
                     success: function(data) {  
                        alert(data);
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
                            var textBuff = $('#msgBox5').html();
                             $('#msgBox5').html(textBuff+'<br>'+classText+ ' successfully booked');
                             $("#msgBox5").css( { "color" : "green"} );    
                             //alert(classText+ ' successfully booked');
                                     $('#memberId').val("");
                                     $('#memberId').focus();
                                       loadClassListTwo(typeId, classDate);
                                     
                                       if(bookingCount == 0) {
                                         var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' is fully booked for this date and time');
                                        $("#msgBox5").css( { "color" : "red"} );    
                                         //alert(classText+ ' is fully booked for this date and time');
                                         }
                                        
                                     
                            }else if(successBit == 2) {
                                        $('#memberId').val("");
                                           if(groupType == "") {
                                              groupTypeTwo = 'S';
                                             }
                                           
                                        if(bookingCount == 0) {
                                        var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' is fully booked for this date and time.');
                                            $("#msgBox5").css( { "color" : "red"} );      
                                          }     
                                              loadClassListTwo(typeId, classDate);                              
                                              loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                                                
                             }else if(successBit == 3) {                           
                                          if(memberType == 'G') {
                                             memberType = 'N';
                                            }
                                           
                                           if(groupType == 'S' || groupType == 'F') {
                                             groupTypeTwo = 'S';
                                             }                                             
                                                   
                                  
                                        if(bookingCount == 0) {
                                         var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' is fully booked for this date and time.');
                                         $("#msgBox5").css( { "color" : "red"} );      
                                          }                                          
                                               loadClassListTwo(typeId, classDate);                    
                                               loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                                
                                               var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' have expired.  Use the form below to purchase more classes.');
                                                $("#msgBox5").css( { "color" : "red"} );    
                             
                           
                              }else if(successBit == 4) { 
                                               loadClassListTwo(typeId, classDate);
                                               var textBuff = $('#msgBox5').html();
                                                $('#msgBox5').html(textBuff+'<br>This class has already been booked by this member');
                                                $("#msgBox5").css( { "color" : "red"} );     
                                        
                                        
                              }else if(successBit == 5) {          
                                                       
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
                                          var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' is fully booked for this date and time.');
                                         $("#msgBox5").css( { "color" : "red"} );     
                                          }                                   
                                               loadClassListTwo(typeId, classDate);
                                               loadClassOptionsThree(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);                                        
                                               var textBuff = $('#msgBox5').html();
                                        $('#msgBox5').html(textBuff+'<br>'+classText+ ' service does not exist for this member.  Use the form below to purchase classes.');
                                                $("#msgBox5").css( { "color" : "red"} );    
                                        
                                        
                              }else{
                             alert(data); 
                             $('#msgBox5').html('Failed! '+data+'');
                             $("#msgBox5").css( { "color" : "red"} );                                
                             }
                                          
                     }//end function success
                 }); //end ajax 
 
 
 
   }
//================================================ 
 
 return false;      

          
});
//--------------------------------------------------------------------------------------



 });