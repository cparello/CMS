this.buttonpressed = "";

$(document).ready(function(){
//--------------------------------------------------------------------------------------
function checkEmail(emailValue, emailField)  {

// this checks the validity of the email to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("Email address cannot be blank");
          $(emailField).focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           $(emailField).focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           $(emailField).focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          $(emailField).focus();
		  return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            $(emailField).focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            $(emailField).focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            $(emailField).focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            $(emailField).focus();
		    return false;		 
         }


}
//--------------------------------------------------------------------------------------
function checkPhoneNumber(phoneValue, phoneField)  {

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        $(phoneField).val(formattedPhoneNumber);
        return true;
     }else{
        alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               $(phoneField).focus();
                 return false;               
    }
    
}
//--------------------------------------------------------------------------------------     
    $('.submitbutton').click(function() {
          buttonpressed = $(this).attr('name');
     });
//--------------------------------------------------------------------------------------
 $('form').submit(function(event) {
   
var idString = $(this).closest('form').attr("name");
var salt = idString.replace(/\D/g,'');

var firstNameField = ('#first_name' +salt); 
var firstName = $(firstNameField).val();

var lastNameField = ('#last_name' +salt); 
var lastName = $(lastNameField).val();

var phoneField = ('#phone' +salt); 
var phoneNumber = $(phoneField).val();

var emailField = ('#email' +salt); 
var emailAddress = $(emailField).val();

var memberIdField = ('#member_id' +salt); 
var memberId = $(memberIdField).val();

var contractKeyField = ('#contract_key' +salt); 
var contractKey = $(contractKeyField).val();

var ajaxSwitch = "";


   //make sure the contact info is filled out
   if(firstName == "") {
      alert('Please fill out the \"First Name\" field.');
              $(firstNameField).focus();
                 return false;
      }
 
   if(lastName == "") {
      alert('Please fill out the \"Last Name\" field.');
              $(lastNameField).focus();
                 return false;
      } 
 
   if(emailAddress == "") {
      alert('Please fill out the \"Email\" field.');
              $(emailField).focus();
                 return false;
      }else{
      var emailBool = checkEmail(emailAddress, emailField);
            if(emailBool == false) {
               return false;
              }             
      }
 
   if(phoneNumber == "") {
      alert('Please fill out the \"Phone\" field.');
              $(phoneField).focus();
                 return false;
      }else{      
      var phoneBool = checkPhoneNumber(phoneNumber, phoneField);
            if(phoneBool == false) {
               return false;
              }              
      }

   if(memberId == "") {
      alert('Please fill out the \"Id Number\" field.');
              $(memberIdField).focus();
                 return false;
      } 


   if(buttonpressed == "edit") {
      ajaxSwitch = 1;
     }else if(buttonpressed == "print") {
      ajaxSwitch = 2;
     }



    if(ajaxSwitch == 2) {
    
       $.ajax ({
            type: "POST",
            url: "../pos/setPrintOptions.php",
            cache: false,
            dataType: 'html', 
            data: {ajax_switch: ajaxSwitch, member_id: memberId},               
                 success: function(data) {    
                //  alert(data);
                 if(data == "R") {
                   window.open('smBarCodeWindow.php','','scrollbars=yes,menubar=no,height=400,width=275,resizable=no,toolbar=no,location=no,status=no');
                   }else if(data == "L") {                     
                   window.open('smBarCodeWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');                   
                   }else{
                   alert(data);
                   }
                                             
                     }//end function success
              }); //end ajax 
    
    
     }


  
    if(ajaxSwitch == 1) {
    
       $.ajax ({
            type: "POST",
            url: "updateSmMemberInfo.php",
            cache: false,
            dataType: 'html', 
            data: {ajax_switch: ajaxSwitch, member_id: memberId, contract_key: contractKey, first_name: firstName, last_name: lastName, email_address: emailAddress, phone_number: phoneNumber},               
                 success: function(data) {    
                //  alert(data);
                 if(data == 1) {
                    alert('Non Member \"'+firstName+' '+lastName+'\" successfully updated');          
                   }else{
                   alert(data);
                   }
                                             
                     }//end function success
              }); //end ajax 
    
    
     }


return false;
   
  });
//--------------------------------------------------------------------------------------------      
});