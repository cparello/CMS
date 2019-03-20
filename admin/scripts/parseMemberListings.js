$(document).ready(function(){

  $("select").change(function(){
 
              var locationValue = this.value;
              var ajaxBit = 1;

$.ajax ({
                 type: "POST",
                 url: "newMemListingsSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {service_location: locationValue, ajax_bit: ajaxBit},               
                 success: function(data) {    
                 //alert(data);
                                                                                                                             
                               $("#list_number").val(data);                                
                              
                               
                     }//end function success
              }); //end ajax 
                 
                 var confirmClear = '&nbsp;';
              $('#conf').html(confirmClear);
    });
//-----------------------------------------------------------------------------
$('#set_mlist').bind('click', function(event) { 

         var listNumber = $("#list_number").val();
         var locationValue = $("#service_location").val();
         var ajaxBit = 2;

          if(locationValue == "") {
            alert('Please select an \"Interface Location\"');
             $("#service_location").focus();
             return false;
             }

          if(listNumber == "" || listNumber == '0') {
            alert('Please supply the \"Number of Listings\"');
            $("#list_number").focus();
            return false;
            }


$.ajax ({
                 type: "POST",
                 url: "newMemListingsSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {service_location: locationValue, list_number: listNumber, ajax_bit: ajaxBit},               
                 success: function(data) {    
         //alert(data);
                 if(data == 1) {
                     var confirm = 'New Member Listings Number Successfully Updated';
                    $('#conf').html(confirm);
                   }
                 if(data == 2) {
                   alert('There was an error processing your request');
                         $("#list_number").focus();
                            return false;                                      
                      }
                               
                     }//end function success
              }); //end ajax 




  });
});