$(document).ready(function(){
//--------------------------------------------------------------------------------------
$("#createPass").click(function() {
//alert();
//check to see if the form fields are filled out
var firstName = $("#first_name").val();
var lastName = $("#last_name").val();
var phone= $("#phone").val(); 
var email = $("#email").val();
var confirmEmail = $("#confirm_email").val();
var ajaxSwitch = 1;
var errors = "";

if(firstName == "") {
   //alert('Please supply a \"First Name\"');
   errors = errors + "Please supply a \"First Name\"";
          // return false;
   }
if(lastName == "") {
    errors = errors + "Please supply a \"last Name\"";
   //alert('Please supply a \"last Name\"');
       //    return false;
   }

//take care of phone and reformat if needed
if(phone == "") {
  // alert('Please supply a \"Phone\" number');
      //     return false;
      errors = errors + "Please supply a \"Phone\" number";
   }
phone = phone.replace(/\s+/g, " ");
var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phone)) {
    var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
        $("#phone").val(formattedPhoneNumber);       
     }else{
               //alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               //$("#phone").focus();
               //return false; 
               errors = errors + "You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number";              
    }
       
//check the email address and validate       
if(email == "") {
   //alert('Please supply a \"Guest Email\" address');
    //       return false;
    errors = errors + "Please supply a \"First Name\"";
   }
if(confirmEmail == "") {
   //alert('Please confirm your \"Confirm Guest Email\" address');
   //        return false;
   errors = errors + "Please supply a \"First Name\"";
   }
var at="@";
var dot=".";
var lat=email.indexOf(at);
var lstr=email.length;
var ldot=email.indexOf(dot);

		if(email.indexOf(at)==-1){
		   //alert("You have entered an invalid email address");
           //$("#email").focus();
		  // return false;
          errors = errors + "You have entered an invalid email address";
		}

		if(email.indexOf(at)==-1 || email.indexOf(at)==0 || email.indexOf(at)==lstr){
		  // alert("You have entered an invalid email address");
          // $("#email").focus();
		  // return false;
          errors = errors + "You have entered an invalid email address";
		}

		if(email.indexOf(dot)==-1 || email.indexOf(dot)==0 || email.indexOf(dot)==lstr){
		  //alert("You have entered an invalid email address");	
         // $("#email").focus();
		 // return false;
         errors = errors + "You have entered an invalid email address";
		}

		 if(email.indexOf(at,(lat+1))!=-1){
		   // alert("You have entered an invalid email address");
          //  $("#email").focus();
		  //  return false;
          errors = errors + "You have entered an invalid email address";
		 }

		 if(email.substring(lat-1,lat)==dot || email.substring(lat+1,lat+2)==dot){
		  //  alert("You have entered an invalid email address");
          //  $("#email").focus();
		  //  return false;
          errors = errors + "You have entered an invalid email address";
		 }

		 if(email.indexOf(dot,(lat+2))==-1){
		  //  alert("You have entered an invalid email address");
          //  $("#email").focus();
		   // return false;
           errors = errors + "You have entered an invalid email address";
		 }
		
		 if(email.indexOf(" ")!=-1){
		   // alert("You have entered an invalid email address");
           // $("#email").focus();
		   // return false;	
           errors = errors + "You have entered an invalid email address";	 
         }
         
var lat=confirmEmail.indexOf(at);
var lstr=confirmEmail.length;
var ldot=confirmEmail.indexOf(dot);

		if(confirmEmail.indexOf(at)==-1){
		  // alert("You have entered an invalid confirmEmail address");
          // $("#confirm_email").focus();
		  // return false;
          errors = errors + "You have entered an invalid confirmEmail address";
		}

		if(confirmEmail.indexOf(at)==-1 || confirmEmail.indexOf(at)==0 || confirmEmail.indexOf(at)==lstr){
		//   alert("You have entered an invalid confirm Email address");
        //   $("#confirm_email").focus();
		//   return false;
        errors = errors + "You have entered an invalid confirmEmail address";
		}

		if(confirmEmail.indexOf(dot)==-1 || confirmEmail.indexOf(dot)==0 || confirmEmail.indexOf(dot)==lstr){
		  //alert("You have entered an invalid confirm Email address");	
         // $("#confirm_email").focus();
		 // return false;
         errors = errors + "You have entered an invalid confirmEmail address";
		}

		 if(confirmEmail.indexOf(at,(lat+1))!=-1){
		 //   alert("You have entered an invalid confirm Email address");
         //   $("#confirm_email").focus();
		 //   return false;
         errors = errors + "You have entered an invalid confirmEmail address";
		 }

		 if(confirmEmail.substring(lat-1,lat)==dot || confirmEmail.substring(lat+1,lat+2)==dot){
		   // alert("You have entered an invalid confirm Email address");
           // $("#confirm_email").focus();
		   // return false;
           errors = errors + "You have entered an invalid confirmEmail address";
		 }

		 if(confirmEmail.indexOf(dot,(lat+2))==-1){
		  //  alert("You have entered an invalid confirm Email address");
          //  $("#confirm_email").focus();
		  //  return false;
          errors = errors + "You have entered an invalid confirmEmail address";
		 }
		
		 if(confirmEmail.indexOf(" ")!=-1){
		   // alert("You have entered an invalid confirm Email address");
           // $("#confirm_email").focus();
		   // return false;
           errors = errors + "You have entered an invalid confirmEmail address";		 
         }
         
         if(errors != ""){
                    $('#msgBox').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#msgBox").css( { "color" : "red"} );
                    $("#msgBox").css( { "font-size": "30px"} );
                     $('#createPass').prop('disabled', false);
                    return false;
                }

$.ajax ({
           type: "POST",
           url: "php/mcEmailGuestPass.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {first_name: firstName, last_name: lastName, phone: formattedPhoneNumber, email: email, ajax_switch: ajaxSwitch},               
           success: function(data) {    
                 
         if(data == 1) {
            //alert('Guest Pass Successfully Emailed');
             $('#msgBox').html('Guest Pass Successfully Emailed');
             $("#msgBox").css( { "color" : "green"} );
             $("#msgBox").css( { "font-size": "30px"} );
           }else{
           //alert(data);
           $('#msgBox').html('Failed!'+data);
             $("#msgBox").css( { "color" : "red"} );
             $("#msgBox").css( { "font-size": "30px"} );
           return false;
           }
                       
                                                                           
         }//end function success
        }); //end ajax 

 });
//-------------------------------------------------------------------------------------------
});