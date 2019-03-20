$(document).ready(function(){

//===================================================
$('#create').click(function() {
 // alert();
var barcode = $('#barcode').val();
var test = $('#checkTest').val();
var ps1 = $('#password1').val();
var ps2 = $('#password2').val();
var email = $('#email').val();

var errors = "";

if (test != 1){
    //alert('Please verify your information with us first by typing in your barcode, zipcode and email address. Then click the CHECK INFORMATION button')
    //return false;  
    errors = errors +  "Please verify your information with us first by typing in your barcode, zipcode and email address. Then click the CHECK INFORMATION button.<br>";
}

      if(barcode == "") {
          //alert('Please enter a value into the barcode');
                 // return false; 
               errors = errors +  "Please enter a value into the barcode.<br>";                   
          }
          
          if(ps1 == "") {
         // alert('Please enter your password');
             //     return false;   
                  errors = errors +  "Please enter your password.<br>";      
                                
          }
          
          if(ps1.length < 8) {
         // alert('Your password must be atleast 8 characters');
          //        return false;     
                  errors = errors +  "Your password must be atleast 8 characters.<br>";                  
          }
          
          if(ps2 == "") {
         // alert('Please confirm your password');
           //       return false;           
                  errors = errors +  "Please confirm your password.<br>";            
          }
          
      if(ps2.length < 8) {
         // alert('Your password must be atleast 8 characters');
             //     return false;    
                  errors = errors +  "Your password must be atleast 8 characters.<br>";                   
          }
          
      if(ps1 != ps2) {
          //alert('Your passwords do not match!');
                 // return false; 
                  errors = errors +  "Your passwords do not match.<br>";                      
          }    
//check to see if fields only contain numbers and make sure payment fields are filled out     
      barcode = barcode.replace(/\s+/g, "");
      
            
 
            
            
            
if(barcode != "")  {
      if(isNaN(barcode)) {
         //alert('Barcode can only contain numbers');
         $("#barcode").focus();
         //return false;    
         errors = errors +  "Please enter a value into the barcode.<br>";           
         }
   }
   if(errors != ""){
        $('#msgBox2').html(errors);
         $("#msgBox2").css( { "color" : "red"} );
         return false;
   }
   //msgBox2
   $(this).prop("disabled",true);
  $(this).attr("id", "create");
                       
  //alert(ps1);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "php/saveUserPassword.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, ps1: ps1, email: email},              
                 success: function(data) {    
                //alert(data)
                         
                    if(data == 1) {
                           //alert('Account login successfully created.');
                           errors = "Account login successfully created."; 
                           $('#msgBox2').html(errors);
                           $("#msgBox2").css( { "color" : "green"} );     
                          window.location.assign("index.php")
                                 
                       }else{  
                       //alert('Account login creation failed!')
                      //  return false;   
                        errors = "Account login creation failed!";  
                        $('#msgBox2').html(errors);
                         $("#msgBox2").css( { "color" : "red"} );                                               
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });