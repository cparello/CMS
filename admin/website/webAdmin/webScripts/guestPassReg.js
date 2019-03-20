$(document).ready(function(){
//--------------------------------------------------------------------------------------
function emailGuestPass(barCodeInt) {

//var barCodeInt = $("#bar_code_int").val();
var barCode = ('G'+barCodeInt);
var imageName = (barCode+'.jpg');
var imagePath = '../../barcodes/'

$.ajax ({
           type: "POST",
           url: "../../marketingtools/emailGuestPass.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {bar_code_int: barCodeInt, image_name: imageName, image_path: imagePath},               
           success: function(data) {    
                 
         if(data == 1) {
            alert('Guest Pass Successfully Emailed');
           }else{
           alert(data);
           return false;
           }
                       
                                                                           
         }//end function success
        }); //end ajax 
}
//-------------------------------------------------------------------------------------------
$("#createPass").live("click", function(event) {

//check to see if the form fields are filled out
var firstName = $("#first_name").val();
var lastName = $("#last_name").val();
var phone= $("#phone").val(); 
var email = $("#email").val();
var confirmEmail = $("#confirm_email").val();
var location = $("#location").val();

if(firstName == "") {
   alert('Please supply a \"First Name\"');
           return false;
   }
if(lastName == "") {
   alert('Please supply a \"last Name\"');
           return false;
   }

//take care of phone and reformat if needed
if(phone == "") {
   alert('Please supply a \"Phone\" number');
           return false;
   }
phone = phone.replace(/\s+/g, " ");
var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phone)) {
    var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
        $("#phone").val(formattedPhoneNumber);       
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               $("#phone").focus();
               return false;               
    }
       
//check the email address and validate       
if(email == "") {
   alert('Please supply a \"Guest Email\" address');
           return false;
   }
if(confirmEmail == "") {
   alert('Please confirm your \"Confirm Guest Email\" address');
           return false;
   }
var at="@";
var dot=".";
var lat=email.indexOf(at);
var lstr=email.length;
var ldot=email.indexOf(dot);

		if(email.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           $("#email").focus();
		   return false;
		}

		if(email.indexOf(at)==-1 || email.indexOf(at)==0 || email.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           $("#email").focus();
		   return false;
		}

		if(email.indexOf(dot)==-1 || email.indexOf(dot)==0 || email.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          $("#email").focus();
		  return false;
		}

		 if(email.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            $("#email").focus();
		    return false;
		 }

		 if(email.substring(lat-1,lat)==dot || email.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            $("#email").focus();
		    return false;
		 }

		 if(email.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            $("#email").focus();
		    return false;
		 }
		
		 if(email.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            $("#email").focus();
		    return false;		 
         }
         
var lat=confirmEmail.indexOf(at);
var lstr=confirmEmail.length;
var ldot=confirmEmail.indexOf(dot);

		if(confirmEmail.indexOf(at)==-1){
		   alert("You have entered an invalid confirmEmail address");
           $("#confirm_email").focus();
		   return false;
		}

		if(confirmEmail.indexOf(at)==-1 || confirmEmail.indexOf(at)==0 || confirmEmail.indexOf(at)==lstr){
		   alert("You have entered an invalid confirm Email address");
           $("#confirm_email").focus();
		   return false;
		}

		if(confirmEmail.indexOf(dot)==-1 || confirmEmail.indexOf(dot)==0 || confirmEmail.indexOf(dot)==lstr){
		  alert("You have entered an invalid confirm Email address");	
          $("#confirm_email").focus();
		  return false;
		}

		 if(confirmEmail.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid confirm Email address");
            $("#confirm_email").focus();
		    return false;
		 }

		 if(confirmEmail.substring(lat-1,lat)==dot || confirmEmail.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid confirm Email address");
            $("#confirm_email").focus();
		    return false;
		 }

		 if(confirmEmail.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid confirm Email address");
            $("#confirm_email").focus();
		    return false;
		 }
		
		 if(confirmEmail.indexOf(" ")!=-1){
		    alert("You have entered an invalid confirm Email address");
            $("#confirm_email").focus();
		    return false;		 
         }
//alert(location);         
         
//alert(confirmEmail);
//now we send this off to save
var ajaxSwitch = 3;

$.ajax ({
                 type: "POST",
                 url: "../../marketingtools/registerGuestSql.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {first_name: firstName, last_name: lastName, phone: formattedPhoneNumber, email: email, ajax_switch: ajaxSwitch, location: location},               
                 success: function(data) {    
  // alert(data);                  
                  var dataArray = data.split("|");
                         barCodeInt = dataArray[0];
                         saveBit = dataArray[1];
                   //alert(barCodeInt); 
                  
                        if(saveBit != undefined) {
                             alert('Guest registration successful for '+firstName+' '+lastName+'.');
                            //end ajax 
                              
                             if(saveBit == 1) {
                                setTimeout( 1000);
                                
                                var barCode = ('G'+barCodeInt);
                                var barWidth = 270;
                                var barHeight = 80;
                                var barQuality = 100;
                                var barFormat = 'jpeg';
                                var streamType = 2
                                var ajaxSwitch = 1;
                                var imageName = (barCode+'.jpg');
                                var imagePath = '../../barcodes/'
                                
                                //alert('barcode: '+barCode+'\nwidth: '+barWidth+'\nheight: '+barHeight+'\nquality: '+barQuality+'\nformat: '+barFormat+'\nstream_type: '+streamType+'\nimage_name: '+imageName+'\nimage_path: '+imagePath+'\najax_switch: '+ajaxSwitch);
                                //alert(barCode);
                                
                                
                                $.ajax ({
                                           type: "POST",
                                           url: "../../memberinterface/barCode.php",
                                           cache: false,
                                           async:false,
                                           dataType: 'html', 
                                           data: {barcode: barCode, width: barWidth, heigth: barHeight, quality: barQuality, format: barFormat, stream_type: streamType, image_name: imageName, image_path: imagePath, ajax_switch: ajaxSwitch},               
                                           success: function(data) {    
                                                 
                                          if(data == 1) {
                                             emailGuestPass(barCodeInt);
                                            }else{
                                             alert(data);
                                            return false;
                                           }                       
                                                                                                           
                                         }//end function success
                                        }); //end ajax 
                                
                                
                                
                                
                                
                                
                                  var parameters = "";
                                  parameters = parameters+'?bar_code_int='+barCodeInt;
                                  window.open("../../memberinterface/printGuestPass.php" +parameters+ "","","scrollbars=yes,menubar=no,height=525,width=400,resizable=no,toolbar=no,location=no,status=no");  
                                  }else{
                                    alert(data);
                                    return false;
                                 }
                          }else{
                           alert(data);
                           return false;                    
                          }
                                                                           
                     }//end function success
              }); //end ajax 


 });
//-------------------------------------------------------------------------------------------
});