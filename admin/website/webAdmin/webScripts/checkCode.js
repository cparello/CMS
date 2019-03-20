$(document).ready(function(){

//===================================================
$('#check').click(function() {
//alert();
var barcode = $('#barcode').val();
var name = $('#name').val();
var code = $('#code').val();
      if(name == "") {
          alert('Please verify your info with us first.');
                  return false;                 
          }
     
                       
  alert(barcode);
  alert(code);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "checkAuthCode.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, code: code},              
                 success: function(data) {    
                //alert(data)
                
                    if(data == 1) {
                            
                             $('#checkTest').val(data);
                              alert(name+' Your authorization code has been verified please create a password.');
                                     
                       }else{  
                       alert('Your authorization code could not be verified in our database.')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });