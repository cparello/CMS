$(document).ready(function(){
//--------------------------------------------------------------------------------------
function emailGuestPass() {

var barCodeInt = $("#bar_code_int").val();
var barCode = ('G'+barCodeInt);
var imageName = (barCode+'.jpg');
var imagePath = '../barcodes/'

$.ajax ({
           type: "POST",
           url: "../marketingtools/emailGuestPass.php",
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
//--------------------------------------------------------------------------------------
$("select").change(function(){
 
              var locationValue = this.value;
              var ajaxSwitch = 1;



if(locationValue != "") {

$.ajax ({
                 type: "POST",
                 url: "../marketingtools/guestPassList.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {service_location: locationValue, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
   //     alert(data);
                  if(data == 0)  {
                      alert('There are currently no guest passes that match this location');
                             return false;                            
                    }
                            
                  if(data != 0)  {
                     $("#contentWindow").html(data);
                                                                                                                                      
                    }
                               
                     }//end function success
              }); //end ajax 

 }

});
//--------------------------------------------------------------------------------------------
$('.head').live("click", function(event) {
  $(this).closest('li').find('.content').not(':animated').slideToggle();
 });
//--------------------------------------------------------------------------------------------
$(".passType").live("change", function(event) {

   var ids = $(this).val();
   var passIdArray = ids.split("|");
   var passId = passIdArray[0];
   var termSalt = passIdArray[1];
   
   
   var termGroup = ('duration'+termSalt);   
   var radioGroup =document.getElementsByName(termGroup);    
   var groupLength = radioGroup.length;
   var radVal = "";
 
   groupLength = parseInt(groupLength);
  
if(groupLength > 1) {
      
 for(var i=0; i < groupLength; i++){
      if(radioGroup[i].checked){
              radVal = radioGroup[i].value;
               $("#term_duration").val(radVal);               
        }
     }     
     
}else{

    if(radioGroup[0].checked) {
         radVal = radioGroup[0].value;
          $("#term_duration").val(radVal);
      }

}

    if(radVal == "") {     
        alert('Please select a Term before making this selection');
                $(this).removeAttr('checked');
                  return false;         
      }   
         

 });
//-------------------------------------------------------------------------------------------
$("#register").live("click", function(event) {

var selectVal = $("input[name=pass_type]:checked").val();

     if(selectVal == undefined) {
       alert('Please choose a \"Select Pass\" form the listings above');
               return false;
       }

   var passIdArray = selectVal.split("|");
   var passId = passIdArray[0];
   var termSalt = passIdArray[1];
      
   var termGroup = ('duration'+termSalt);   
   var radioGroup =document.getElementsByName(termGroup);    
   var groupLength = radioGroup.length;
   var radVal = "";
 
   groupLength = parseInt(groupLength);
  
if(groupLength > 1) {      
 for(var i=0; i < groupLength; i++){
      if(radioGroup[i].checked){
              radVal = radioGroup[i].value;
               $("#term_duration").val(radVal);               
        }
     }          
}else{
    if(radioGroup[0].checked) {
         radVal = radioGroup[0].value;
          $("#term_duration").val(radVal);
      }
}


//check to see if the form fields are filled out
var guestName = $("#guest_name").val();
var guestPhone= $("#guest_phone").val(); 
var guestEmail = $("#guest_email").val();

if(guestName == "") {
   alert('Please supply a \"Guest Name\"');
           return false;
   }


//take care of phone and reformat if needed
if(guestPhone == "") {
   alert('Please supply a \"Guest Phone\" number');
           return false;
   }
guestPhone = guestPhone.replace(/\s+/g, " ");
var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(guestPhone)) {
    var formattedPhoneNumber = guestPhone.replace(regexObj, "($1) $2-$3");
        $("#guest_phone").val(formattedPhoneNumber);       
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               $("#guest_phone").focus();
               return false;               
    }
       
//check the email address and validate       
if(guestEmail == "") {
   alert('Please supply a \"Guest Email\" address');
           return false;
   }

var at="@";
var dot=".";
var lat=guestEmail.indexOf(at);
var lstr=guestEmail.length;
var ldot=guestEmail.indexOf(dot);

		if(guestEmail.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           $("#guest_email").focus();
		   return false;
		}

		if(guestEmail.indexOf(at)==-1 || guestEmail.indexOf(at)==0 || guestEmail.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           $("#guest_email").focus();
		   return false;
		}

		if(guestEmail.indexOf(dot)==-1 || guestEmail.indexOf(dot)==0 || guestEmail.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          $("#guest_email").focus();
		  return false;
		}

		 if(guestEmail.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            $("#guest_email").focus();
		    return false;
		 }

		 if(guestEmail.substring(lat-1,lat)==dot || guestEmail.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            $("#guest_email").focus();
		    return false;
		 }

		 if(guestEmail.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            $("#guest_email").focus();
		    return false;
		 }
		
		 if(guestEmail.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            $("#guest_email").focus();
		    return false;		 
         }

//now we send this off to save
var saveBit = $("#save_bit").val();
var barCodeInt = $("#bar_code_int").val();
var interestOne = $("#guest_interest_one").val();
var interestTwo = $("#guest_interest_two").val();
var ajaxSwitch = 1;

if(saveBit == "" &&  barCodeInt == "") {

$.ajax ({
                 type: "POST",
                 url: "../marketingtools/registerGuestSql.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {pass_id: passId, duration: radVal, guest_name: guestName, guest_phone: formattedPhoneNumber, guest_email: guestEmail, interest_one: interestOne, interest_two: interestTwo, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
   //alert(data);                  
                if(data == 99){
                        alert('They are not eligable for a guest pass.');
                        return false;
                        }
                                                
                       var dataArray = data.split("|");
                         barCodeInt = dataArray[0];
                         saveBit = dataArray[1];
                  
                        if(saveBit != undefined) {
                           $("#save_bit").val(saveBit);
                           $("#bar_code_int").val(barCodeInt);
                             alert('Guest registration successful for '+guestName+'.'); 
                          }else{
                           alert(data);
                           return false;                    
                          }
                                                                           
                    
                }
               
              }); //end ajax 

}else{

 alert('This guest has already been registered');
        return false;    
        
}

 });
//-------------------------------------------------------------------------------------------
$("#preview_print").live("click", function(event) {

   var saveBit = $("#save_bit").val();
   var barCodeInt = $("#bar_code_int").val();
   var ajaxSwitch = 2;

 if(saveBit == "" &&  barCodeInt == "") {
    alert('Please \"Save Registration\" before previewing  and printing this selection');
            return false;
            
    }else{

       var selectVal = $("input[name=pass_type]:checked").val();

       var passIdArray = selectVal.split("|");
       var passId = passIdArray[0];
       var termSalt = passIdArray[1];
      
       var termGroup = ('duration'+termSalt);   
       var radioGroup =document.getElementsByName(termGroup);    
       var groupLength = radioGroup.length;
       var radVal = "";
 
         groupLength = parseInt(groupLength);
  
         if(groupLength > 1) {      
                   for(var i=0; i < groupLength; i++){
                        if(radioGroup[i].checked){
                           radVal = radioGroup[i].value;
                           $("#term_duration").val(radVal);               
                          }
                      }          
            }else{
                    if(radioGroup[0].checked) {
                       radVal = radioGroup[0].value;
                       $("#term_duration").val(radVal);
                       }
             }

//send selection to print 
$.ajax ({
           type: "POST",
           url: "../marketingtools/registerGuestSql.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {pass_id: passId, duration: radVal, bar_code_int: barCodeInt, ajax_switch: ajaxSwitch},               
           success: function(data) {    
                 
if(data == 1) {
  var parameters = "";
  parameters = parameters+'?bar_code_int='+barCodeInt;
  window.open("printGuestPass.php" +parameters+ "","","scrollbars=yes,menubar=no,height=525,width=400,resizable=no,toolbar=no,location=no,status=no");  
  }else{
    alert(data);
    return false;
 }
                       
                                                                           
         }//end function success
        }); //end ajax 

   }


 });
//-------------------------------------------------------------------------------------------
$("#email_pass").live("click", function(event) {

var saveBit = $("#save_bit").val();
   var barCodeInt = $("#bar_code_int").val();
   var ajaxSwitch = 2;

 if(saveBit == "" &&  barCodeInt == "") {
    alert('Please \"Save Registration\" before previewing  and printing this selection');
            return false;
            
    }else{

       var selectVal = $("input[name=pass_type]:checked").val();

       var passIdArray = selectVal.split("|");
       var passId = passIdArray[0];
       var termSalt = passIdArray[1];
      
       var termGroup = ('duration'+termSalt);   
       var radioGroup =document.getElementsByName(termGroup);    
       var groupLength = radioGroup.length;
       var radVal = "";
 
         groupLength = parseInt(groupLength);
  
         if(groupLength > 1) {      
                   for(var i=0; i < groupLength; i++){
                        if(radioGroup[i].checked){
                           radVal = radioGroup[i].value;
                           $("#term_duration").val(radVal);               
                          }
                      }          
            }else{
                    if(radioGroup[0].checked) {
                       radVal = radioGroup[0].value;
                       $("#term_duration").val(radVal);
                       }
             }

//send selection to update database
$.ajax ({
           type: "POST",
           url: "../marketingtools/registerGuestSql.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {pass_id: passId, duration: radVal, bar_code_int: barCodeInt, ajax_switch: ajaxSwitch},               
           success: function(data) {    
                 
if(data != 1) {
    alert(data);
    return false;
   }
                                                                                                  
        }//end function success
        }); //end ajax 

//send to save bar code
var barCode = ('G'+barCodeInt);
var barWidth = 270;
var barHeight = 80;
var barQuality = 100;
var barFormat = 'jpeg';
var streamType = 2
var ajaxSwitch = 1;
var imageName = (barCode+'.jpg');
var imagePath = '../barcodes/'

//alert('barcode: '+barCode+'\nwidth: '+barWidth+'\nheight: '+barHeight+'\nquality: '+barQuality+'\nformat: '+barFormat+'\nstream_type: '+streamType+'\nimage_name: '+imageName+'\nimage_path: '+imagePath+'\najax_switch: '+ajaxSwitch);
//alert(barCode);


$.ajax ({
           type: "POST",
           url: "barCode.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {barcode: barCode, width: barWidth, heigth: barHeight, quality: barQuality, format: barFormat, stream_type: streamType, image_name: imageName, image_path: imagePath, ajax_switch: ajaxSwitch},               
           success: function(data) {    
                 
          if(data == 1) {
             emailGuestPass();
            }else{
             alert(data);
            return false;
           }                       
                                                                           
         }//end function success
        }); //end ajax 


    }

 });
//-------------------------------------------------------------------------------------------
    
   
});