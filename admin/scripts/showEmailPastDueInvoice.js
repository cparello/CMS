
//--------------------------------------------------------------------------------------
$(document).ready(function(){

//this handles the form submission for past due
$('#past').bind('click', function(event) { 
    
//alert();

//$(this).prop("disabled",true);
//$(this).attr("class", "button2");

var ajaxSwitch = 1;
var contractKey = $(this).attr('fieldCKey5');
var r = confirm('Would you like to email a copy to member? OK to email. CANCEL to view.');                                
 if(r == true) {
    var emailBool = 1;   
    $.ajax ({
                 type: "POST",
                 url: "mailLoadPastDueInvoice.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajaxSwitch: ajaxSwitch, contractKey: contractKey, emailBool: emailBool},               
                 success: function(data) {
                    //alert(data);
                           if(data == 3) {   
                              alert('Email sent!');
                                      return false;
                             }                             
                             }
                   
              }); //end ajax 
    }else{
       var emailBool = 2;
        window.open('mailLoadPastDueInvoice.php?ajaxSwitch=' +ajaxSwitch+ '&contractKey=' +contractKey+ '&emailBool=' +emailBool+'','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
        }
            
});
//--------------------------------------------------------------------------------------


});  //end of ready function