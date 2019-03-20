
//===================================================================================================
jQuery(document).ready(function(){
    // This button will increment the value
    $('#reactivate').click(function(e){
        //alert();
        // Stop acting like a button
        //e.preventDefault();
        // Get the field name
        var serviceKey = $(this).attr('fieldKey');
        var contractKey = $(this).attr('fieldCKey');
        var serviceName = $(this).val();
        var userId = $(this).attr('fieldUser');
        
        
        var  ajaxSwitch = 1;
        
         $.ajax ({
                type: "POST",
                url: "reactivateService.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_key: serviceKey, contract_key: contractKey},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            //$("#reactivate").prop("disabled",true);
                             //$(this).prop("disabled",true);
                            // $(this).attr("id", "reactivate");
                            alert('Service '+serviceName+' has been reactivated!')
                            window.location = "searchAccounts.php?marker=1";     
                            //window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";   
                                         
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        //alert(process);
        //alert(dueToday);
       
    });
    // This button will decrement the value till 0
   
});

