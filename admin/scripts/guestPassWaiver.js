$(document).ready(function(){
//----------------------------------------------------------------------------------
function openLiabiltyWindow()  {

window.open('liabilityWindowTwo.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//----------------------------------------------------------------------------------
$("#waiver").live("click", function(event) {

var guestName = $("#guest_name").val();
var guestPhone= $("#guest_phone").val(); 
var guestEmail = $("#guest_email").val();
var contractKey = 'NA';

//below we open and print out the form
 var libNameAddArray = (guestName+'|||NA||||'+guestPhone+'|NA|'+guestEmail+'|NA|NA'); 
 var libAddressArray = encodeURIComponent(libNameAddArray);


$.ajax ({
           type: "POST",
           url: "createLiabilityObjectTwo.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {lib_address_array: libAddressArray, contract_key: contractKey},               
           success: function(data) {    
              if(data == 1) {                              
                openLiabiltyWindow();
                }else{   
                 alert('There was an error printing this form');
                 return false;                         
                }                          
                                                                           
         }//end function success
        }); //end ajax 



});
//---------------------------------------------------------------------------------
});