//--------------------------------------------------------------------------------------
$(document).ready(function(){
    
   $(".p_sms").click( function() { 
    //console.log("test");
    var contractKey = $(this).closest('tr').find('#contract_key').text();
    var reportType = $(this).closest('tr').find('#report_type').val();
    var month = $(this).closest('tr').find('#month').val();
    var year = $(this).closest('tr').find('#year').val();
    var attempts = $(this).closest('tr').find('#p_sms_attempts').text();
    attempts = parseInt(attempts);
    attempts = attempts + 1;
    
    
    var ajaxSwitch = 1;
    
      $.ajax ({
                     type: "POST",
                     url: "../billing/updateAttemptsContact.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                     success: function(data) {
                         ////alert(data);
                               if(data == 1) {  
                                
                                 }else{
                                    return false;
                                 }                          
                                 }
                       
                  }); //end ajax 
                               
      
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var service = $(this).closest('tr').find('#service').text();
                                     var date = $(this).closest('tr').find('#date').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "../billing/sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, service: service, date: date},                       
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   //alert(reportType);  
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax
                                      
   
                                  
                                
                                //console.log(date+' '+service+' '+name+' '+discount+' '+price+' '+phone+' ');
                                
            $(this).closest('tr').find('#p_sms_attempts').html(attempts);
            $(this).closest('tr').find('.p_sms').css( { "color" : "green"} );
            return false;
        });
  
  
   $(".p_call").click( function() { 
    
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
                     url: "../billing/updateAttemptsContact.php",
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
  
   $(".c_sms").click( function() { 
    
    
    var contractKey = $(this).closest('tr').find('#contract_key').text();
    var reportType = $(this).closest('tr').find('#report_type').val();
    var month = $(this).closest('tr').find('#month').val();
    var year = $(this).closest('tr').find('#year').val();
    var attempts = $(this).closest('tr').find('#c_sms_attempts').text();
    attempts = parseInt(attempts);
    attempts = attempts + 1;
    
   // //alert(contractKey +''+reportType+''+ month+''+year +''+attempts +'');
    var ajaxSwitch = 3;
    
      $.ajax ({
                     type: "POST",
                     url: "../billing/updateAttemptsContact.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                     success: function(data) {
                       ////alert(data);
                               if(data == 1) {  
                                ////alert(attempts);
                                //$(this).closest('tr').find('#p_call_attempts').html(attempts);
                                
                                 }else{
                                    return false;
                                 }                          
                                 }
                       
                  }); //end ajax 
                  var ajaxSwitch = 1;
                               
                                 
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var service = $(this).closest('tr').find('#service').text();
                                     var date = $(this).closest('tr').find('#date').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "../billing/sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, service: service, date: date},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   //alert(reportType);  
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax
            $(this).closest('tr').find('#c_sms_attempts').html(attempts);
            $(this).closest('tr').find('.c_sms').css( { "color" : "green"} );
            return false;
        });
  
  
   $(".c_call").click( function() { 
    
      
    var contractKey = $(this).closest('tr').find('#contract_key').text();
    var reportType = $(this).closest('tr').find('#report_type').val();
    var month = $(this).closest('tr').find('#month').val();
    var year = $(this).closest('tr').find('#year').val();
    var attempts = $(this).closest('tr').find('#c_call_attempts').text();
    attempts = parseInt(attempts);
    attempts = attempts + 1;
    
  // //alert(contractKey +''+reportType+''+ month+''+year +''+attempts +'');
    var ajaxSwitch = 4;
    
      $.ajax ({
                     type: "POST",
                     url: "../billing/updateAttemptsContact.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, reportType: reportType, month: month, year: year, contractKey: contractKey, attempts: attempts},               
                     success: function(data) {
                     //  //alert(data);
                               if(data == 1) {  
                                ////alert(attempts);
                                //$(this).closest('tr').find('#p_call_attempts').html(attempts);
                                
                                 }   else{
                                    return false;
                                 }                          
                                 }
                       
                  }); //end ajax 
            $(this).closest('tr').find('#c_call_attempts').html(attempts);
            return false;
        });
        
      $(".email").click( function() { 
    
      
    var contractKey = $(this).closest('tr').find('#contract_key').text();
    var reportType = $(this).closest('tr').find('#report_type').val();
    var month = $(this).closest('tr').find('#month').val();
    var year = $(this).closest('tr').find('#year').val();
    var attempts = $(this).closest('tr').find('#email_attempts').text();
    attempts = parseInt(attempts);
    attempts = attempts + 1;
    
   // //alert(contractKey +''+reportType+''+ month+''+year +''+attempts +'');
    var ajaxSwitch = 5;
    
      $.ajax ({
                     type: "POST",
                     url: "../billing/updateAttemptsContact.php",
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