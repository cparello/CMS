$(document).ready(function(){

//===================================================
$('#loginMem').click(function() {
 
var barcode = $('#barcode').val();
var password = $('#password').val();

      if(barcode == "") {
          alert('Please enter a value into the barcode field');
                  return false;                 
          }
      if(password == "") {
          alert('Please enter a value into the password field');
                  return false;                 
          }
      
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      barcode = barcode.replace(/\s+/g, "");
     
if(barcode != "")  {
      if(isNaN(barcode)) {
         alert('Barcode can only contain numbers');
         $("#barcode").focus();
         return false;         
         }
   }

//alert();
 if(password.length < 8) {
          alert('Your password must be 8 digits');
                  return false;                 
          }
                       
  //alert(barcode);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "checkLoginInfo.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, password: password},              
                 success: function(data) {    
                //alert(data)
                    var dataArray = data.split("|");
                    var bit = dataArray[0];
                    var contractKey = dataArray[1];
                    var barcode = dataArray[2];
                    var name = dataArray[3];
                
                    if(bit == 1) {
                         alert('Your Logged in!');
                             $('#loginArea').html('<b>Welcome '+name+'!  </b>');
                       }else{  
                       alert('Your information could not be verified in our databsse.');
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });