$(document).ready(function(){

  $("select").change(function(){
 
              var locationValue = this.value;
              var ajaxBit = 1;

$.ajax ({
                 type: "POST",
                 url: "memIntPasswordsSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {service_location: locationValue, ajax_bit: ajaxBit},               
                 success: function(data) {    
                 //alert(data);
                                var dataArray = data.split("|");
                                var usrName = dataArray[0];
                                var passWord = dataArray[1];                              
                                                                  
                               $("#usr_name").val(usrName);                                
                               $("#pass_word").val(passWord);
                               
                     }//end function success
              }); //end ajax 
                 
                 var confirmClear = '&nbsp;';
              $('#conf').html(confirmClear);
    });
//-----------------------------------------------------------------------------
$('#set_passwords').bind('click', function(event) { 

         var usrName = $("#usr_name").val();
         var passWord = $("#pass_word").val();
         var locationValue = $("#service_location").val();
         var ajaxBit = 2;

          if(locationValue == "") {
            alert('Please select an \"Interface Location\"');
             $("#service_location").focus();
             return false;
             }

          if(usrName == "" || usrName == 'NA') {
            alert('Please supply an \"Interface User Name\"');
            $("#usr_name").focus();
            return false;
            }

          if(passWord == "" || passWord == 'NA') {
            alert('Please supply an \"Interface Password\"');
            $("#pass_word").focus();
            return false;
            }

$.ajax ({
                 type: "POST",
                 url: "memIntPasswordsSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {service_location: locationValue, usr_name: usrName, pass_word: passWord, ajax_bit: ajaxBit},               
                 success: function(data) {    
         
                 if(data == 1) {
                   alert('The \"Interface User Name\" you entered is already in use');
                         $("#usr_name").focus();
                            return false;                                      
                      }
                 if(data == 2) {
                     var confirm = 'Interface User Name and Password Successfully Updated';
                    $('#conf').html(confirm);
                   }
                 if(data == 3) {
                   alert('There was an error processing your request');
                         $("#usr_name").focus();
                            return false;                                      
                      }
                               
                     }//end function success
              }); //end ajax 




  });
});