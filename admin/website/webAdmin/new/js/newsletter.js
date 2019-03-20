$(document).ready(function(){

//-------------------------------------------------------------------------------------------
$("#signupNews").click(function() {
//alert();
//check to see if the form fields are filled out
var firstName = $("#first_name").val();
var lastName = $("#last_name").val();
var email = $("#email").val();
var confirmEmail = $("#confirm_email").val();

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
                     $('#signupNews').prop('disabled', false);
                    return false;
                }
//alert(location);         
         
//alert(confirmEmail);
//now we send this off to save
var ajaxSwitch = 1;

$.ajax ({
                 type: "POST",
                 url: "php/registerNews.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {first_name: firstName, last_name: lastName, email: email, ajax_switch: ajaxSwitch},               
                 success: function(data) {  
                    //alert(data);
                    if(data == 99){ 
                        $('#msgBox').html('You are already registered for the newsletter with this name and/or email address.');
                            $("#msgBox").css( { "color" : "red"} );
                            return false;
                        }
   //alert(data);                  
                        if(data == 1) {
                            // alert('Guest registration successful for '+firstName+' '+lastName+'.');
                            //end ajax 
                            $('#msgBox').html('Newsletter registration successful for '+firstName+' '+lastName+'.');
                            $("#msgBox").css( { "color" : "green"} );
                            }
                                                                           
                     }//end function success
              }); //end ajax 


 });
//-------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------
});