
//===================================================================================================
$(document).ready(function() {
   
   $("#remove").click( function() {
       
        var itemId = $(this).attr('itemId');
        var  ajaxSwitch = 1;
        
        var r = confirm('This will remove this item from your cart. Are you sure?');                                
        if(r == true) {
        
         $.ajax ({
                type: "POST",
                url: "removeFromCart.php",
                cache: false,
                dataType: 'html', 
                data: {ajaxSwitch: ajaxSwitch, itemId: itemId},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            window.location = "shoppingCart.php";    
                            }           
                     }//end function success
                 }); 
                 }else{
                    return false;
                 }
       
    });
    // This button will decrement the value till 0
     $("#purchase").click( function() {
        
        var billAmount = $('#total').val(); 
        var  ajaxSwitch = 1;
        
         $.ajax ({
                type: "POST",
                url: "changeBillingAmount.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, bill_amount: billAmount, contract_key: contractKey},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            alert('Billing Amount has been updated! Page will be reloaded.');
                            window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
                            //$('#month').val(billAmount);  
                               
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        //alert(process);
        //alert(dueToday);
       
    });
    
    
   
});

