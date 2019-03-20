$(document).ready(function(){

//===================================================
$('#create').click(function() {
 // alert();
var barcode = $('#barcode').val();
var test = $('#checkTest').val();
var ps1 = $('#password1').val();
var ps2 = $('#password2').val();


if (test != 1){
    alert('Please verify your information with us first by typing in your barcode, zipcode and email address. Then click the CHECK INFORMATION button')
    return false;   
}

      if(barcode == "") {
          alert('Please enter a value into the barcode');
                  return false;                 
          }
          
          if(ps1 == "") {
          alert('Please enter your password');
                  return false;                 
          }
          
          if(ps1.length < 8) {
          alert('Your password must be atleast 8 characters');
                  return false;                 
          }
          
          if(ps2 == "") {
          alert('Please confirm your password');
                  return false;                 
          }
          
      if(ps2.length < 8) {
          alert('Your password must be atleast 8 characters');
                  return false;                 
          }
          
      if(ps1 != ps2) {
          alert('Your passwords do not match!');
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
   $(this).prop("disabled",true);
  $(this).attr("id", "create");
                       
  //alert(ps1);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "saveUserPassword.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, ps1: ps1},              
                 success: function(data) {    
                //alert(data)
                         
                    if(data == 1) {
                           alert('Account login successfully created.');
                          window.location.assign("memberLoginPage.php?member=1")
                                 
                       }else{  
                       alert('Account login creation failed!')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });