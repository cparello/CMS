
//===================================================================================================
$(document).ready(function() {
     var flagBool = $('#flag_bool').val();  
     if(flagBool == 0){
        $("#corpFlag").css({"background-color": "green"});
        $("#corpFlag").css({"color": "white"});
     }else{
         $("#corpFlag").css({"background-color": "red"});
         $("#corpFlag").css({"color": "black"});
     }
     
     var flagBool = $('#collect_bool').val();  
     if(flagBool == 0){
        $("#collections").css({"background-color": "green"});
        $("#collections").css({"color": "white"});
     }else{
         $("#collections").css({"background-color": "red"});
         $("#collections").css({"color": "black"});
     }
    
    
//jQuery(document).ready(function(){
    // This button will increment the value
   // $('#changeDate').click(function(e){
   $("#changeDate").click( function() {
        //alert();
        // Stop acting like a button
        //e.preventDefault();
        // Get the field name
        var dueDateMonth = $('#dateMonth').val();  
        var dueDateDay = $('#dateDay').val();
        var dueDateYear = $('#dateYear').val(); 
        var contractKey = $(this).attr('fieldCKey2');
        var pastDays = $(this).attr('pastDays');
        var  ajaxSwitch = 1;
        var userId = $(this).attr('fieldUser3');
        
         $.ajax ({
                type: "POST",
                url: "changeNextDueDate.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, date_month: dueDateMonth, date_day: dueDateDay, date_year: dueDateYear, contract_key: contractKey, past_days: pastDays},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            alert('Next payment due date has been updated! Page will be reloaded!')
                            window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";    
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        //alert(process);
        //alert(dueToday);
       
    });
    // This button will decrement the value till 0
     $("#changeBillAmount").click( function() {
        //alert();
        // Stop acting like a button
        //e.preventDefault();
        // Get the field name
        var billAmount = $('#modBillAmount').val();   
        var contractKey = $(this).attr('fieldCKey3');
         var userId = $(this).attr('fieldUser2');
        
        billAmount = parseInt(billAmount);
        billAmount = billAmount.toFixed(2);
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
    
     $("#changeCorpFlag").click( function() {
        //alert();
        // Stop acting like a button
        //e.preventDefault();
        // Get the field name
        //var corpFlag = $('#corpFlag').val();   
        var contractKey = $(this).attr('fieldCKey4');
         var userId = $(this).attr('fieldUser4'); 
                
        var  ajaxSwitch = 1;
        
         $.ajax ({
                type: "POST",
                url: "changeCorpFlag.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, contract_key: contractKey},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            alert('Flag set! Member will be stopped at checkin. Page will be reloaded.');
                            window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
                            //$('#month').val(billAmount);  
                            $("#corpFlag").css({"background-color": "red"});
                            $("#corpFlag").css({"color": "black"});
                               
                            }else if(data == 2){
                                alert('Flag removed! Member will be not stopped at checkin. Page will be reloaded.');
                                window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
                                $("#corpFlag").css({"background-color": "green"});
                                $("#corpFlag").css({"color": "white"});
                            //$('#month').val(billAmount);  
                            }else{
                                alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        //alert(process);
        //alert(dueToday);
       
    });
    
    
    
     $("#changeCollectionsFlag").click( function() {
        
        // Stop acting like a button
        //e.preventDefault();
        // Get the field name
        //var corpFlag = $('#corpFlag').val();   
        var contractKey = $(this).attr('fieldCKey6');
         var userId = $(this).attr('fieldUser6'); 
         
        var pastAmount = $('#past_due_balance').val(); 
            //alert();    
        var  ajaxSwitch = 1;
        
         $.ajax ({
                type: "POST",
                url: "changeCollectionsFlag.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, contract_key: contractKey, past_amount: pastAmount},               
                     success: function(data) {  
//alert(data);
                          if(data == 1) { 
                            alert('Flag set! Member will be put in collections mode. Page will be reloaded.');
                            window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
                            //$('#month').val(billAmount);  
                            $("#collectionsFlag").css({"background-color": "red"});
                            $("#collectionsFlag").css({"color": "black"});
                               
                            }else if(data == 2){
                                alert('Flag removed! Member will taken out of collections mode. Page will be reloaded.');
                                window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
                                $("#collectionsFlag").css({"background-color": "green"});
                                $("#collectionsFlag").css({"color": "white"});
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

