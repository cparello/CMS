$(document).ready(function() {
//----------------------------------------------------------------
$('.rl').click(function() {

var contractKey = $('#contract_key').val();


  var answer = confirm("This will reload the current account info.  It is highly recommended that after each transaction is processed to reload the account in order to view it's status. Do you wish to continue?");
   if (!answer) {
      return false;
     }        

window.location.href = ('viewAccountInfo.php?contract_key=' +contractKey);




}); 
//--------------------------------------------------------------
}); 