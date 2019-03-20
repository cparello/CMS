
    
//$(document).ready(function() {
//  $("#purchase_items").click(function() {
    function checkShippingDetais() {
    
       var errors = "";
     
       
            var firstName = '#first_name';
            var middleName = '#middle_name';
            var lastName = '#last_name';
            var streetAddress = '#street_address';
            var cityName = '#city';
            var stateName = '#state';
            var zipCodeNumber = '#zip_code';
            var homePhoneNumber = '#home_phone';
            var emailAddress = '#email';
            
            var first = $(firstName).val();
            var middle = $(middleName).val();
            var last = $(lastName).val();
            var street = $(streetAddress).val();
            var city = $(cityName).val();
            var state = $(stateName).val();
            var zipCode = $(zipCodeNumber).val();
            var homePhone = $(homePhoneNumber).val();
            var email = $(emailAddress).val();
            
              if(first == "") {
               //alert('Please fill out the '+firstName+ ' field');
               //document.getElementById(firstName).focus();
               //return false;
               errors = errors + '<br>Please fill out the First Name field.';
        
               }
              if(last == "") {
                 //alert('Please fill out the '+lastName+ ' field');
                 //document.getElementById(lastName).focus();
                 //return false;
                 errors = errors + '<br>Please fill out the Last Name field.';
        
                 }
              if(street == "") {
                //alert('Please fill out the '+streetAddress+ ' field');
                 //document.getElementById(streetAddress).focus();
                //return false;
                errors = errors + '<br>Please fill out the Address field.';
        
                }
              if(city == "") {
               //alert('Please fill out the '+cityName+ ' field');
               //document.getElementById(cityName).focus();
               //return false;
               errors = errors + '<br>Please fill out the City field.';
        
              }
              if(state == "") {
                //alert('Please select a '+stateName+ ' State');
               // document.getElementById(stateName).focus();
                //return false;
                errors = errors + '<br>Please select a State.';
        
               }
              if(zipCode == "") {
                 // alert('Please fill out the '+zipCodeNumber+ ' field');
                 // document.getElementById(zipCodeNumber).focus();
                 // return false;
                  errors = errors + '<br>Please fill out the Zipcode field.';
        
                 }
              if(homePhone == "") {
                 // alert('Please fill out the ' +homePhoneNumber+ ' Primary Phone field');
                  //document.getElementById(homePhoneNumber).focus();
                  //return false;
                  errors = errors + '<br>Please fill out the Primary Phone field.';
        
                  }
              if(email == "") {
                      // alert('Please fill out the '+emailAddress+ ' field');
                     //  document.getElementById(emailAddress).focus();
                     //  return false;
                       errors = errors + '<br>Please fill out the Email field.';
        
                       }
            street = street.replace(/#/g, "Num");            



                errors = errors.trim();
                if(errors != ""){
                    $('#successBox').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#successBox").css( { "color" : "red"} );
                    /*
                    $("#purchase_items").prop('disabled', true);
                    $("#purchase_items").addClass("secondary");
                    */
                    return false;
                } else {
                    //$('#successBox').html('Please wait, your transaction is being processed.');
                    //$("#successBox").css( { "color" : "green"} );
                    $('#successBox').html('');
                    /*
                    $("#purchase_items").prop('disabled', false);
                    $("#purchase_items").removeClass("secondary");
                    */
                    return true;
                }
                
    } // function checkShippingDetais() {
//  }); // $("#purchase_items").click(function() {
//}); // $(document).ready(function() {
//-----------------------------------------------------------------------------------------------------------------------------------
//================================================================

//---------------------------------------------------------------------------------------------------------------------------------------------
function browserKinks() {

// var versionSwitch = document.getElementById('parse_switch').value;

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
function setPaymentListeners(fieldId) {

this.paymentField = fieldId;
var fieldFocus = document.getElementById(paymentField);

//try 
//{
//alert(paymentField);
 var fullFieldValue;
    
    fullFieldValue = $('#'+paymentField+'').val();//this.value;
    //alert(fullFieldValue);
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    
/*}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {
    var fullFieldValue = this.value;
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    });                           
}    */

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

var paymentPattern = /^[a-zA-Z]+_pay$/;
var paymentResult = paymentPattern.test(fieldId);
if(paymentResult == true) {
this.paymentField = fieldId;
setPaymentListeners(fieldId);
}

}




