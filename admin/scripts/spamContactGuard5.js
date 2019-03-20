//--------------------------------------------------------------------------------------
$(document).ready(function(){
    
    $('body').on('click', '.p_sms', function () {
            //console.log("test");
            var contractKey = $(this).closest('tr').find('#contract_key').text();
            var reportType = $(this).closest('tr').find('#report_type').val();
            var month = $(this).closest('tr').find('#month').val();
            var year = $(this).closest('tr').find('#year').val();
            var attempts = $(this).closest('tr').find('#p_sms_attempts').text();
            attempts = parseInt(attempts);
            attempts = attempts + 1;
            
            //alert('t1');
            var ajaxSwitch = 1;
            
              
                                        if(reportType == 'BX'){
                                            //alert('t2');
                                            var name = $(this).closest('tr').find('#name').text();
                                            var response = $(this).closest('tr').find('#response').text();
                                            var pResponse = $(this).closest('tr').find('#pResponse').text();
                                            var price = $(this).closest('tr').find('#price').text();
                                            var phone = $(this).closest('tr').find('#p_phone').text();
                                            console.log(name+' name '+response+' response '+pResponse+' descrip '+price+' price '+phone);
                                            $.ajax ({
                                                 type: "POST",
                                                 url: "sendSmsReporting.php",
                                                 cache: false,
                                                 dataType: 'html', 
                                                 data: {ajaxSwitch: ajaxSwitch, month: month, year: year, response: response, pResponse: pResponse, name: name, price: price, phone: phone, reportType: reportType},               
                                                 success: function(data) {
                                                    //alert(data);
                                                           if(data == 1) {  
                                                           
                                                                $.ajax ({
                                                                     type: "POST",
                                                                     url: "updateAttemptsContactReporting.php",
                                                                     cache: false,
                                                                     dataType: 'html', 
                                                                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                                                                     success: function(data) {
                                                                       // alert(data);
                                                                               if(data == 1) {  
                                                                                    
                                                                                 }else{
                                                                                    return false;
                                                                                 }                          
                                                                                 }
                                                                       
                                                                  }); //end ajax 
                                                                
                                                                
                                                                
                                                             }else{
                                                                return false;
                                                             }                    
                                                             }
                                                   
                                              }); //end ajax 
                                        }else if(reportType == 'BZ'){
                                            
                                            var name = $(this).closest('tr').find('#name').text();
                                            var dueDate = $(this).closest('tr').find('#dueDate').text();
                                            var price = $(this).closest('tr').find('#price').text();
                                            var phone = $(this).closest('tr').find('#p_phone').text();
                                            
                                            $.ajax ({
                                                 type: "POST",
                                                 url: "sendSmsReporting.php",
                                                 cache: false,
                                                 dataType: 'html', 
                                                 data: {ajaxSwitch: ajaxSwitch, month: month, year: year, dueDate: dueDate, pResponse: pResponse, name: name, price: price, phone: phone, reportType: reportType},               
                                                 success: function(data) {
                                                    //alert(data);
                                                           if(data == 1) {  
                                                                $.ajax ({
                                                                     type: "POST",
                                                                     url: "updateAttemptsContactReporting.php",
                                                                     cache: false,
                                                                     dataType: 'html', 
                                                                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                                                                     success: function(data) {
                                                                       // alert(data);
                                                                               if(data == 1) {  
                                                                                   
                                                                                 }else{
                                                                                    return false;
                                                                                 }                          
                                                                                 }
                                                                       
                                                                  }); //end ajax 
                                                                                                   
                                                             }else{
                                                                return false;
                                                             }                    
                                                             }
                                                   
                                              }); //end ajax 
                                        }else if(reportType == 'CX'){
                                            //alert('t2');
                                            var name = $(this).closest('tr').find('#name').text();
                                            var monthsPast = $(this).closest('tr').find('#monthsPastDue').text();
                                            var price = $(this).closest('tr').find('#price').text();
                                            var phone = $(this).closest('tr').find('#p_phone').text();
                                            console.log(name+' name '+response+' response '+monthsPast+' monthsPast '+price+' price '+phone);
                                            $.ajax ({
                                                 type: "POST",
                                                 url: "sendSmsReporting.php",
                                                 cache: false,
                                                 dataType: 'html', 
                                                 data: {ajaxSwitch: ajaxSwitch, month: month, year: year, monthsPast: monthsPast, name: name, price: price, phone: phone, reportType: reportType},               
                                                 success: function(data) {
                                                    //alert(data);
                                                           if(data == 1) {  
                                                           
                                                                $.ajax ({
                                                                     type: "POST",
                                                                     url: "updateAttemptsContactReporting.php",
                                                                     cache: false,
                                                                     dataType: 'html', 
                                                                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                                                                     success: function(data) {
                                                                       // alert(data);
                                                                               if(data == 1) {  
                                                                                    
                                                                                 }else{
                                                                                    return false;
                                                                                 }                          
                                                                                 }
                                                                       
                                                                  }); //end ajax 
                                                                
                                                                
                                                                
                                                             }else{
                                                                return false;
                                                             }                    
                                                             }
                                                   
                                              }); //end ajax 
                                        }
                                        $(this).closest('tr').find('#p_sms_attempts').html(attempts);
                                        $(this).closest('tr').find('.p_sms').css( { "color" : "green"} );
                                        return false;    
                   
        });
  
   $('body').on('click', '.p_call', function () {
    
            var contractKey = $(this).closest('tr').find('#contract_key').text();
            var reportType = $(this).closest('tr').find('#report_type').val();
            var month = $(this).closest('tr').find('#month').val();
            var year = $(this).closest('tr').find('#year').val();
            var attempts = $(this).closest('tr').find('#p_call_attempts').text();
            attempts = parseInt(attempts);
            attempts = attempts + 1;
            
           // //alert(contractKey +''+reportType+''+ month+''+year +''+attempts +'');
            var ajaxSwitch = 2;
            
              $.ajax ({
                             type: "POST",
                             url: "updateAttemptsContactReporting.php",
                             cache: false,
                             dataType: 'html', 
                             data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                             success: function(data) {
                           //    //alert(data);
                                       if(data == 1) {  
                                        ////alert(attempts);
                                        //$(this).closest('tr').find('#p_call_attempts').html(attempts);
                                        
                                         }   else{
                                            return false;
                                         }                          
                                         }
                               
                          }); //end ajax 
                    $(this).closest('tr').find('#p_call_attempts').html(attempts);
                    return false;
        });
  
     $('body').on('click', '.email', function () {
    
             // alert();
            var contractKey = $(this).closest('tr').find('#contract_key').text();
            var reportType = $(this).closest('tr').find('#report_type').val();
            var month = $(this).closest('tr').find('#month').val();
            var year = $(this).closest('tr').find('#year').val();
            var attempts = $(this).closest('tr').find('#email_attempts').text();
            attempts = parseInt(attempts);
            attempts = attempts + 1;
            
         //console.log(contractKey +''+reportType+''+ month+''+year +''+attempts +'');
            var ajaxSwitch = 3;
            
              $.ajax ({
                             type: "POST",
                             url: "updateAttemptsContactReporting.php",
                             cache: false,
                             dataType: 'html', 
                             data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                             success: function(data) {
                               //alert(data);
                                       if(data == 1) {  
                                        ////alert(attempts);
                                        //$(this).closest('tr').find('#p_call_attempts').html(attempts);
                                        
                                         }   else{
                                            return false;
                                         }                          
                                         }
                               
                          }); //end ajax 
                    $(this).closest('tr').find('#email_attempts').html(attempts);
                    return false;
                });
  
});  //end of ready function