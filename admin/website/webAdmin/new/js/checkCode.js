$(document).ready(function(){

//===================================================
$('#check').click(function() {
//alert();
var barcode = $('#barcode').val();
var name = $('#name').val();
var code = $('#code').val();
var errors = "";
      if(name == "") {
          //alert('Please verify your info with us first.');
              //    return false;                 
           errors = "Please verify your info with us first.";
           $("#msgBox3").html(errors);    
          }
     
     if (errors != ""){
        $("#msgBox3").css( { "color" : "red"} );
        return false;
        }                   
 // alert(barcode);
 // alert(code);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "php/checkAuthCode.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, code: code},              
                 success: function(data) {    
                //alert(data)
                
                    if(data == 1) {
                            
                             $('#checkTest').val(data);
                             // alert(name+' Your authorization code has been verified please create a password.');

                                $("#msgBox3").html(name+' Your authorization code has been verified please create a password.');   
                                $("#msgBox3").css( { "color" : "green"} ); 
                                     
                       }else{  
                       //alert('Your authorization code could not be verified in our database.')
                        errors = "'Your authorization code could not be verified in our database.'";
                        $("#msgBox3").html(errors);   
                        $("#msgBox3").css( { "color" : "green"} ); 
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });