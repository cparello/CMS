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
                     url: "updateAttemptsContact.php",
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
                                if(reportType == 'SR' || reportType == 'ER'){
                                    var date = $(this).closest('tr').find('#date').text();
                                    var service = $(this).closest('tr').find('#service').text();
                                    var name = $(this).closest('tr').find('#name').text();
                                    var discount = $(this).closest('tr').find('#discount').text();
                                    var price = $(this).closest('tr').find('#price').text();
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                    
                                    $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, date: date, service: service, name: name, discount: discount, price: price, phone: phone, reportType: reportType},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                }
                                if(reportType == 'GP'){
                                    var date = $(this).closest('tr').find('#date').text();
                                    var service = $(this).closest('tr').find('#service').text();
                                    var name = $(this).closest('tr').find('#name').text();
                                    var price = $(this).closest('tr').find('#price').text();
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                    
                                    $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, date: date, service: service, name: name, price: price, phone: phone, reportType: reportType},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                }
                                if(reportType == 'MS'){
                                     var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var paymentMonth = $(this).closest('tr').find('#paymentMonth').text();
                                     var monthlyPayment = $(this).closest('tr').find('#monthlyPayment').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, paymentMonth: paymentMonth, monthlyPayment: monthlyPayment},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 if(reportType == 'PD'){
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var response = $(this).closest('tr').find('#response').text();
                                     var payment = $(this).closest('tr').find('#payment').text();
                                     var monthsPast = $(this).closest('tr').find('#monthsPast').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType , response: response, payment: payment,  monthsPast: monthsPast},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 if(reportType == 'DR'){
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var checkNumber = $(this).closest('tr').find('#checkNumber').text();
                                     var rejectedPayment = $(this).closest('tr').find('#rejectedPayment').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, checkNumber: checkNumber,  rejectedPayment: rejectedPayment},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 if(reportType == 'BL'){
                                    var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var cardNum = $(this).closest('tr').find('#cardNum').text();
                                     var cardExp = $(this).closest('tr').find('#cardExp').text();
                                     var amountOwed = $(this).closest('tr').find('#amountOwed').text();
                                     var reasonDescrip = $(this).closest('tr').find('#reasonDescrip').text();
                                     var transTitle = $(this).closest('tr').find('#transTitle').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, cardNum: cardNum,  cardExp: cardExp, amountOwed: amountOwed, reasonDescrip: reasonDescrip, transTitle: transTitle},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 
                                  if(reportType == 'CO'){
                                     var phone = $(this).closest('tr').find('#p_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var amount_owed = $(this).closest('tr').find('#amount_owed').text();
                                     var months_past_due = $(this).closest('tr').find('#months_past_due').text();
                                     var month_left = $(this).closest('tr').find('#month_left').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, amount_owed: amount_owed, months_past_due: months_past_due, month_left: month_left},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                  
                                
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
                     url: "updateAttemptsContact.php",
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
                     url: "updateAttemptsContact.php",
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
                                if(reportType == 'SR' || reportType == 'ER'){
                                    var date = $(this).closest('tr').find('#date').text();
                                    var service = $(this).closest('tr').find('#service').text();
                                    var name = $(this).closest('tr').find('#name').text();
                                    var discount = $(this).closest('tr').find('#discount').text();
                                    var price = $(this).closest('tr').find('#price').text();
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                    
                                    $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, date: date, service: service, name: name, discount: discount, price: price, phone: phone, reportType: reportType},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                }
                                if(reportType == 'GP'){
                                    var date = $(this).closest('tr').find('#date').text();
                                    var service = $(this).closest('tr').find('#service').text();
                                    var name = $(this).closest('tr').find('#name').text();
                                    var price = $(this).closest('tr').find('#price').text();
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                    
                                    $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, date: date, service: service, name: name, price: price, phone: phone, reportType: reportType},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                }
                                if(reportType == 'MS'){
                                     var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var paymentMonth = $(this).closest('tr').find('#paymentMonth').text();
                                     var monthlyPayment = $(this).closest('tr').find('#monthlyPayment').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, paymentMonth: paymentMonth, monthlyPayment: monthlyPayment},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 if(reportType == 'PD'){
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var response = $(this).closest('tr').find('#response').text();
                                     var payment = $(this).closest('tr').find('#payment').text();
                                     var monthsPast = $(this).closest('tr').find('#monthsPast').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType , response: response, payment: payment,  monthsPast: monthsPast},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 if(reportType == 'DR'){
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var checkNumber = $(this).closest('tr').find('#checkNumber').text();
                                     var rejectedPayment = $(this).closest('tr').find('#rejectedPayment').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, checkNumber: checkNumber,  rejectedPayment: rejectedPayment},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 
                                  if(reportType == 'BL'){
                                    var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var cardNum = $(this).closest('tr').find('#cardNum').text();
                                     var cardExp = $(this).closest('tr').find('#cardExp').text();
                                     var amountOwed = $(this).closest('tr').find('#amountOwed').text();
                                     var reasonDescrip = $(this).closest('tr').find('#reasonDescrip').text();
                                     var transTitle = $(this).closest('tr').find('#transTitle').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, cardNum: cardNum,  cardExp: cardExp, amountOwed: amountOwed, reasonDescrip: reasonDescrip, transTitle: transTitle},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
                                 
                                 if(reportType == 'CO'){
                                     var phone = $(this).closest('tr').find('#c_phone').text();
                                     var name = $(this).closest('tr').find('#name').text();
                                     var amount_owed = $(this).closest('tr').find('#amount_owed').text();
                                     var months_past_due = $(this).closest('tr').find('#months_past_due').text();
                                     var month_left = $(this).closest('tr').find('#month_left').text();
                                     
                                     $.ajax ({
                                         type: "POST",
                                         url: "sendSms.php",
                                         cache: false,
                                         dataType: 'html', 
                                         data: {ajaxSwitch: ajaxSwitch, name: name, phone: phone, reportType: reportType, amount_owed: amount_owed, months_past_due: months_past_due, month_left: month_left},               
                                         success: function(data) {
                                            //alert(data);
                                                   if(data == 1) {  
                                                   
                                                     }else{
                                                        return false;
                                                     }                    
                                                     }
                                           
                                      }); //end ajax 
                                 }
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
                     url: "updateAttemptsContact.php",
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
                     url: "updateAttemptsContact.php",
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