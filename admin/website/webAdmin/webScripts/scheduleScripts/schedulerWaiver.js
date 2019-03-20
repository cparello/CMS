$(document).ready(function(){
//----------------------------------------------------------------------------------
function openLiabiltyWindow()  {

window.open('schedule/liabilityWindowTwo.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//----------------------------------------------------------------------------------
$("#waiver").live("click", function(event) {

var firstName = $("#sm_fname").val();
var lastName = $("#sm_lname").val();
var smPhone= $("#sm_phone").val(); 
var smEmail = $("#sm_email").val();
var contractKey = 'NA';
var attendeeBit = 1;


 //make sure the contact info is filled out
   if(firstName == "") {
      alert('Please fill out the \"First Name\" field.');
              $("#sm_fname").focus();
                 return false;
      }
 
   if(lastName == "") {
      alert('Please fill out the \"Last Name\" field.');
              $("#sm_lname").focus();
                 return false;
      } 
 
   if(smEmail == "") {
      alert('Please fill out the \"Email\" field.');
              $("#sm_email").focus();
                 return false;        
      }
 
   if(smPhone == "") {
      alert('Please fill out the \"Phone\" field.');
              $("#sm_phone").focus();
                 return false;         
      }



//below we open and print out the form
 var libNameAddArray = (firstName+'||'+lastName+'|NA||||'+smPhone+'|NA|'+smEmail+'|NA|NA'); 
 var libAddressArray = encodeURIComponent(libNameAddArray);


$.ajax ({
           type: "POST",
           url: "schedule/createLiabilityObjectTwo.php",
           cache: false,
           async:false,
           dataType: 'html', 
           data: {lib_address_array: libAddressArray, contract_key: contractKey, attendee_bit: attendeeBit},               
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