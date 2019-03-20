$(document).ready(function() {

  $(".headerTerms").toggle(function() {
                 //$('terms_viewed').val('1');  
                    $(this).css("color", "#FFFFFF");
                   $(this).find('span').html('-');	
               },function() {
                    $(this).css("color", "#FCB040");
                    $(this).find('span').html('+');	
               });

  $('.contentTerms').hide();
 // toggle the componenet with class msg_body
  $('.headerTerms').click(function()  {
        $('.contentTerms').slideToggle(500);
     
  });
});
//============================================================================
$(document).ready(function() {
    $('.add1').click(function()  {
        //alert('fu');
        if($('input:radio[name=serviceOptions1]:checked').val() == undefined){
            alert('Please select a option for this service before adding.');
            return false;
        }else{
            var data = $('input:radio[name=serviceOptions1]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            
            var str= serviceTerm.match(/Month/);
            if (str == 'Month'){
                var monthTemp = $('#monthDues').val();
                monthTemp = parseFloat(monthTemp);
                var valMonthAdded = servicePrice/serviceQuantity;
                valMonthAdded = parseFloat(valMonthAdded); 
                monthTemp = monthTemp + valMonthAdded;
                monthTemp = monthTemp.toFixed(2);
                $('#monthDues').val(monthTemp);
                document.getElementById('monthly_bool').value = 1;
                var monthBool = 1;
            }else{
                 var monthBool = 0;
            }
            
            var origServicePrice = servicePrice;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add '+serviceName+' for each member you are registering? If you select \"CANCEL\" it will be applied to the primary members account.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           }
            //alert(todayPay);
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           servicePrice = parseFloat(servicePrice);
        //  alert(balanceDue);
          
        //  alert(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           if (monthBool == 0){
                servicePrice = servicePrice * muliplyer;
                var dispPrice = servicePrice.toFixed(2);
                var total = servicePrice + balanceDue + todayPay;
                total = total.toFixed(2);
           }else if (monthBool == 1){
                    valMonthAdded = valMonthAdded * muliplyer;
                    var dispPrice = valMonthAdded.toFixed(2);
                    var total = valMonthAdded + balanceDue + todayPay;
                    total = total.toFixed(2); 
           }
           
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+serviceName+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b style="padding-left: 10px;">'+serviceQuantity+'&nbsp;'+serviceTerm+'</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var service1Array = (serviceName+'|'+serviceKey+'|'+serviceQuantity+'|'+serviceTerm+'|'+origServicePrice+'|'+muliplyer);
           $('#markServOption1').val(service1Array); 
           
           var buttonClass = $("#add1").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea1").html('<center><input type=\'button\' value=\'Clear\' id=\'clear1\' class=\'clear1 '+class1+' buttonClear buttonSize\'></center>');
        }
     
  });
  
   $('.add2').click(function()  {
        if($('input:radio[name=serviceOptions2]:checked').val() == undefined){
            alert('Please select a option for this service before adding.');
            return false;
        }else{
            var data = $('input:radio[name=serviceOptions2]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            
            var str= serviceTerm.match(/Month/);
            if (str == 'Month'){
                var monthTemp = $('#monthDues').val();
                monthTemp = parseFloat(monthTemp);
                var valMonthAdded = servicePrice/serviceQuantity;
                valMonthAdded = parseFloat(valMonthAdded); 
                monthTemp = monthTemp + valMonthAdded;
                monthTemp = monthTemp.toFixed(2);
                $('#monthDues').val(monthTemp);
                document.getElementById('monthly_bool').value = 1;
             var monthBool = 1;
            }else{
                 var monthBool = 0;
            }
            
            var origServicePrice = servicePrice;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add '+serviceName+' for each member you are registering? If you select \"CANCEL\" it will be applied to the primary members account.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           }
            //alert(todayPay);
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           servicePrice = parseFloat(servicePrice);
        //  alert(balanceDue);
          
        //  alert(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           if (monthBool == 0){
                servicePrice = servicePrice * muliplyer;
                var dispPrice = servicePrice.toFixed(2);
                var total = servicePrice + balanceDue + todayPay;
                total = total.toFixed(2);
           }else if (monthBool == 1){
                    valMonthAdded = valMonthAdded * muliplyer;
                    var dispPrice = valMonthAdded.toFixed(2);
                    var total = valMonthAdded + balanceDue + todayPay;
                    total = total.toFixed(2); 
           }
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+serviceName+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b style="padding-left: 10px;">'+serviceQuantity+'&nbsp;'+serviceTerm+'</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var service2Array = (serviceName+'|'+serviceKey+'|'+serviceQuantity+'|'+serviceTerm+'|'+origServicePrice+'|'+muliplyer);
           $('#markServOption2').val(service2Array); 
            var buttonClass = $("#add2").attr("class");
          // alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea2").html('<center><input type=\'button\' value=\'Clear\' id=\'clear2\' class=\'clear2 '+class1+' buttonClear buttonSize\'></center>');
        }
     
  });
  
   $('.add3').click(function()  {
        if($('input:radio[name=serviceOptions3]:checked').val() == undefined){
            alert('Please select a option for this service before adding.');
            return false;
        }else{
            var data = $('input:radio[name=serviceOptions3]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            
            var str= serviceTerm.match(/Month/);
            if (str == 'Month'){
                var monthTemp = $('#monthDues').val();
                monthTemp = parseFloat(monthTemp);
                var valMonthAdded = servicePrice/serviceQuantity;
                valMonthAdded = parseFloat(valMonthAdded); 
                monthTemp = monthTemp + valMonthAdded;
                monthTemp = monthTemp.toFixed(2);
                $('#monthDues').val(monthTemp);
                document.getElementById('monthly_bool').value = 1;
              var monthBool = 1;
            }else{
                 var monthBool = 0;
            }
            
            var origServicePrice = servicePrice;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add '+serviceName+' for each member you are registering? If you select \"CANCEL\" it will be applied to the primary members account.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           }
            //alert(todayPay);
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           servicePrice = parseFloat(servicePrice);
        //  alert(balanceDue);
          
        //  alert(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           if (monthBool == 0){
                servicePrice = servicePrice * muliplyer;
                var dispPrice = servicePrice.toFixed(2);
                var total = servicePrice + balanceDue + todayPay;
                total = total.toFixed(2);
           }else if (monthBool == 1){
                    valMonthAdded = valMonthAdded * muliplyer;
                    var dispPrice = valMonthAdded.toFixed(2);
                    var total = valMonthAdded + balanceDue + todayPay;
                    total = total.toFixed(2); 
           }
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+serviceName+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b style="padding-left: 10px;">'+serviceQuantity+'&nbsp;'+serviceTerm+'</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var service3Array = (serviceName+'|'+serviceKey+'|'+serviceQuantity+'|'+serviceTerm+'|'+origServicePrice+'|'+muliplyer);
           $('#markServOption3').val(service3Array); 
            var buttonClass = $("#add3").attr("class");
         //  alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea3").html('<center><input type=\'button\' value=\'Clear\' id=\'clear3\' class=\'clear3 '+class1+' buttonClear buttonSize\'></center>');
        }
     
  });
  
   $('.add4').click(function()  {
       if($('input:radio[name=serviceOptions4]:checked').val() == undefined){
            alert('Please select a option for this service before adding.');
            return false;
        }else{
            var data = $('input:radio[name=serviceOptions4]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            
            var str= serviceTerm.match(/Month/);
            if (str == 'Month'){
                var monthTemp = $('#monthDues').val();
                monthTemp = parseFloat(monthTemp);
                var valMonthAdded = servicePrice/serviceQuantity;
                valMonthAdded = parseFloat(valMonthAdded); 
                monthTemp = monthTemp + valMonthAdded;
                monthTemp = monthTemp.toFixed(2);
                $('#monthDues').val(monthTemp);
                document.getElementById('monthly_bool').value = 1;
              var monthBool = 1;
            }else{
                 var monthBool = 0;
            }
            
            var origServicePrice = servicePrice;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add '+serviceName+' for each member you are registering? If you select \"CANCEL\" it will be applied to the primary members account.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           }
            //alert(todayPay);
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           servicePrice = parseFloat(servicePrice);
        //  alert(balanceDue);
          
        //  alert(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           if (monthBool == 0){
                servicePrice = servicePrice * muliplyer;
                var dispPrice = servicePrice.toFixed(2);
                var total = servicePrice + balanceDue + todayPay;
                total = total.toFixed(2);
           }else if (monthBool == 1){
                    valMonthAdded = valMonthAdded * muliplyer;
                    var dispPrice = valMonthAdded.toFixed(2);
                    var total = valMonthAdded + balanceDue + todayPay;
                    total = total.toFixed(2); 
           }
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+serviceName+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b style="padding-left: 10px;">'+serviceQuantity+'&nbsp;'+serviceTerm+'</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var service4Array = (serviceName+'|'+serviceKey+'|'+serviceQuantity+'|'+serviceTerm+'|'+origServicePrice+'|'+muliplyer);
           $('#markServOption4').val(service4Array); 
            var buttonClass = $("#add4").attr("class");
        //   alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea4").html('<center><input type=\'button\' value=\'Clear\' id=\'clear4\' class=\'clear4 '+class1+' buttonClear buttonSize\'></center>');
        }
     
  });
  
   $('.add5').click(function()  {
        if($('input:radio[name=serviceOptions5]:checked').val() == undefined){
            alert('Please select a option for this service before adding.');
            return false;
        }else{
            var data = $('input:radio[name=serviceOptions5]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            
            var str= serviceTerm.match(/Month/);
            if (str == 'Month'){
                var monthTemp = $('#monthDues').val();
                monthTemp = parseFloat(monthTemp);
                var valMonthAdded = servicePrice/serviceQuantity;
                valMonthAdded = parseFloat(valMonthAdded); 
                monthTemp = monthTemp + valMonthAdded;
                monthTemp = monthTemp.toFixed(2);
                $('#monthDues').val(monthTemp);
                document.getElementById('monthly_bool').value = 1;
               var monthBool = 1;
            }else{
                 var monthBool = 0;
            }
            
            var origServicePrice = servicePrice;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add '+serviceName+' for each member you are registering? If you select \"CANCEL\" it will be applied to the primary members account.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           }
            //alert(todayPay);
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           servicePrice = parseFloat(servicePrice);
        //  alert(balanceDue);
          
        //  alert(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           if (monthBool == 0){
                servicePrice = servicePrice * muliplyer;
                var dispPrice = servicePrice.toFixed(2);
                var total = servicePrice + balanceDue + todayPay;
                total = total.toFixed(2);
           }else if (monthBool == 1){
                    valMonthAdded = valMonthAdded * muliplyer;
                    var dispPrice = valMonthAdded.toFixed(2);
                    var total = valMonthAdded + balanceDue + todayPay;
                    total = total.toFixed(2); 
           }
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+serviceName+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b style="padding-left: 10px;">'+serviceQuantity+'&nbsp;'+serviceTerm+'</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var service5Array = (serviceName+'|'+serviceKey+'|'+serviceQuantity+'|'+serviceTerm+'|'+origServicePrice+'|'+muliplyer);
           $('#markServOption5').val(service5Array); 
            var buttonClass = $("#add5").attr("class");
        //   alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea5").html('<center><input type=\'button\' value=\'Clear\' id=\'clear5\' class=\'clear5 '+class1+' buttonClear buttonSize\'></center>');
        }
     
  });


 $('.add6').click(function()  {
        
            var data = $('#gearAdd6').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            alert(invMarker);
            alert(cost);
            alert(name);
            
            var origServicePrice = cost;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add a '+name+' for each member you are registering? If you select \"CANCEL\" one will be added for the primary member.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val();
           if(todayPay == ""){
            todayPay = 0;
           } 
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           cost = parseFloat(cost);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var dispPrice = cost.toFixed(2);
           var total = cost + balanceDue + todayPay;
           total = total.toFixed(2);
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+name+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b>&nbsp;</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var gear1Array = (name+'|'+invMarker+'|'+origServicePrice+'|'+muliplyer);
           $('#markGearOption1').val(gear1Array); 
            var buttonClass = $("#add6").attr("class");
          // alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea6").html('<center><input type=\'button\' value=\'Clear\' id=\'clear6\' class=\'clear6 '+class1+' buttonClear buttonSize\'></center>');
        
     
  });

$('.add7').click(function()  {
        
            var data = $('#gearAdd7').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add a '+name+' for each member you are registering? If you select \"CANCEL\" one will be added for the primary member.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
            var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val(); 
           if(todayPay == ""){
            todayPay = 0;
           }
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           
           cost = parseFloat(cost);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var dispPrice = cost.toFixed(2);
           var total = cost + balanceDue + todayPay;
           total = total.toFixed(2);
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+name+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b>&nbsp;</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var gear2Array = (name+'|'+invMarker+'|'+origServicePrice+'|'+muliplyer);
           $('#markGearOption2').val(gear2Array); 
            var buttonClass = $("#add7").attr("class");
       //    alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea7").html('<center><input type=\'button\' value=\'Clear\' id=\'clear7\' class=\'clear7 '+class1+' buttonClear buttonSize\'></center>');
        
     
  });
  
  $('.add8').click(function()  {
        
            var data = $('#gearAdd8').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add a '+name+' for each member you are registering? If you select \"CANCEL\" one will be added for the primary member.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
            var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val(); 
           if(todayPay == ""){
            todayPay = 0;
           }
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
            
           cost = parseFloat(cost);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var dispPrice = cost.toFixed(2);
           var total = cost + balanceDue + todayPay;
           total = total.toFixed(2);
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+name+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b>&nbsp;</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var gear3Array = (name+'|'+invMarker+'|'+origServicePrice+'|'+muliplyer);
           $('#markGearOption3').val(gear3Array); 
            var buttonClass = $("#add8").attr("class");
        //   alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea8").html('<center><input type=\'button\' value=\'Clear\' id=\'clear8\' class=\'clear8 '+class1+' buttonClear buttonSize\'></center>');
        
     
  });
  
  $('.add9').click(function()  {
        
            var data = $('#gearAdd9').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add a '+name+' for each member you are registering? If you select \"CANCEL\" one will be added for the primary member.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
           var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val(); 
           if(todayPay == ""){
            todayPay = 0;
           }
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
            
           cost = parseFloat(cost);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var dispPrice = cost.toFixed(2);
           var total = cost + balanceDue + todayPay;
           total = total.toFixed(2);
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+name+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b>&nbsp;</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var gear4Array = (name+'|'+invMarker+'|'+origServicePrice+'|'+muliplyer);
           $('#markGearOption4').val(gear4Array); 
            var buttonClass = $("#add9").attr("class");
       //    alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea9").html('<center><input type=\'button\' value=\'Clear\' id=\'clear9\' class=\'clear9 '+class1+' buttonClear buttonSize\'></center>');
        
     
  });
  
  $('.add10').click(function()  {
        
            var data = $('#gearAdd10').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            if($('#number_new_memberships').val() > 1){
                var answer1 = confirm('Would you like to add a '+name+' for each member you are registering? If you select \"CANCEL\" one will be added for the primary member.');
                               if (!answer1) {
                                      var muliplyer = 1;
                                     }else{
                                        var muliplyer = $('#number_new_memberships').val();
                                     }
            } else{
               var muliplyer = 1; 
            }
            var balanceDue = $('#balance_due').val();
           var todayPay = $('#today_payment').val(); 
           if(todayPay == ""){
            todayPay = 0;
           }
           balanceDue = parseFloat(balanceDue);
           todayPay = parseFloat(todayPay);
           
           
           cost = parseFloat(cost);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var dispPrice = cost.toFixed(2);
           var total = cost + balanceDue + todayPay;
           total = total.toFixed(2);
           $('#today_payment').val(0);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
          
           var html = '<tr><td colspan="3" class="sumtext"><b>'+name+'</b></td><td colspan="3" class="sumtext sumtextPad"><b>'+muliplyer+'</b></td><td colspan="3" class="sumtext"><b>$'+dispPrice+'</b></td><td colspan="3" class="sumtext"><b>&nbsp;</b></td></tr>';
          
           var purchaseSummary = $("#purchaseSummary").html();
           //alert(purchaseSummary);
           purchaseSummary = purchaseSummary.replace("</table>", "");
           //purchaseSummary += html; 
           $("#purchaseSummary").html(purchaseSummary+html+"</table>");
           var gear5Array = (name+'|'+invMarker+'|'+origServicePrice+'|'+muliplyer);
           $('#markGearOption5').val(gear5Array); 
            var buttonClass = $("#add10").attr("class");
       //    alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea10").html('<center><input type=\'button\' value=\'Clear\' id=\'clear10\' class=\'clear10 '+class1+' buttonClear buttonSize\'></center>');
        
     
  });
  
  $(function(){
   $(document).on("click","#clear1", function(){
    // alert('fu');
            var serv = $('#markServOption1').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[5];
    
            var data = $('input:radio[name=serviceOptions1]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            var origServicePrice = servicePrice;
            var answer1 = confirm('Would you like to remove '+serviceName+' from your purchase?');
                               if (!answer1) {
                                     return false;
                                     }
            
            
           $('input:radio[name=serviceOptions1]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           
           servicePrice = parseFloat(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           servicePrice = servicePrice * muliplyer;
           var total = balanceDue - servicePrice;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
            $('tr:contains('+serviceName+')').remove(); 
          
           $('#markServOption1').val(null); 
           
           var buttonClass = $("#clear1").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea1").html('<center><input type=\'button\' value=\'Add\' id=\'add1\' class=\'add1 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   $(function(){
   $(document).on("click","#clear2", function(){
    // alert('fu');
            var serv = $('#markServOption2').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[5];
            
            var data = $('input:radio[name=serviceOptions1]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            var origServicePrice = servicePrice;
            var answer1 = confirm('Would you like to remove '+serviceName+' from your purchase?');
                               if (!answer1) {
                                     return false;
                                     }
            
            
         $('input:radio[name=serviceOptions2]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           
           servicePrice = parseFloat(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           servicePrice = servicePrice * muliplyer;
           var total = balanceDue - servicePrice;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
            $('tr:contains('+serviceName+')').remove(); 
          
           $('#markServOption2').val(null); 
           
           var buttonClass = $("#clear2").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea2").html('<center><input type=\'button\' value=\'Add\' id=\'add2\' class=\'add2 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear3", function(){
    // alert('fu');
            var serv = $('#markServOption3').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[5];
            
            var data = $('input:radio[name=serviceOptions3]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            var origServicePrice = servicePrice;
            var answer1 = confirm('Would you like to remove '+serviceName+' from your purchase?');
                               if (!answer1) {
                                     return false;
                                     }
            
            
           $('input:radio[name=serviceOptions3]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           
           servicePrice = parseFloat(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           servicePrice = servicePrice * muliplyer;
           var total = balanceDue - servicePrice;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
            $('tr:contains('+serviceName+')').remove(); 
          
           $('#markServOption3').val(null); 
           
           var buttonClass = $("#clear3").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea3").html('<center><input type=\'button\' value=\'Add\' id=\'add3\' class=\'add3 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear4", function(){
    // alert('fu');
            var serv = $('#markServOption4').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[5];
            
            var data = $('input:radio[name=serviceOptions4]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            var origServicePrice = servicePrice;
            var answer1 = confirm('Would you like to remove '+serviceName+' from your purchase?');
                               if (!answer1) {
                                     return false;
                                     }
            
            
            $('input:radio[name=serviceOptions4]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           
           servicePrice = parseFloat(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           servicePrice = servicePrice * muliplyer;
           var total = balanceDue - servicePrice;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
            $('tr:contains('+serviceName+')').remove(); 
          
           $('#markServOption4').val(null); 
           
           var buttonClass = $("#clear4").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea4").html('<center><input type=\'button\' value=\'Add\' id=\'add4\' class=\'add4 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear5", function(){
    // alert('fu');
    
            
             var serv = $('#markServOption5').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[5];
            
            var data = $('input:radio[name=serviceOptions5]:checked').val()
            var dataArray = data.split('|');   
            var serviceKey = dataArray[0]; 
            var serviceQuantity = dataArray[1];
            var serviceTerm = dataArray[2];
            var servicePrice = dataArray[3];
            var serviceName = dataArray[4];
            var origServicePrice = servicePrice;
            var answer1 = confirm('Would you like to remove '+serviceName+' from your purchase?');
                               if (!answer1) {
                                     return false;
                                     }
            
            
            $('input:radio[name=serviceOptions5]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           
           servicePrice = parseFloat(servicePrice);
          
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           servicePrice = servicePrice * muliplyer;
           var total = balanceDue - servicePrice;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
            $('tr:contains('+serviceName+')').remove(); 
          
           $('#markServOption5').val(null); 
           
           var buttonClass = $("#clear5").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
          
           
           $("#buttonArea5").html('<center><input type=\'button\' value=\'Add\' id=\'add5\' class=\'add5 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear6", function(){
    // alert('fu');
            var serv = $('#markGearOption1').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[3];
            
           var data = $('#gearAdd6').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            var answer1 = confirm('Would you like to remove '+name+' from this purchase?');
                               if (!answer1) {
                                      return false;
                                     }
                                     
          $('input:radio[name=serviceOptions6]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           cost = parseFloat(cost);
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var total = balanceDue - cost;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           $('tr:contains('+name+')').remove(); 
           
           $('#markGearOption1').val(null); 
           var buttonClass = $("#clear6").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
           
           $("#buttonArea6").html('<center><input type=\'button\' value=\'Add\' id=\'add6\' class=\'add6 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear7", function(){
    // alert('fu');
            var serv = $('#markGearOption2').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[3];
            
            var data = $('#gearAdd7').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            var answer1 = confirm('Would you like to remove '+name+' from this purchase?');
                               if (!answer1) {
                                      return false;
                                     }
                                     
           $('input:radio[name=serviceOptions7]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           cost = parseFloat(cost);
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var total = balanceDue - cost;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           $('tr:contains('+name+')').remove(); 
           
           $('#markGearOption2').val(null); 
           var buttonClass = $("#clear7").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
           
           $("#buttonArea7").html('<center><input type=\'button\' value=\'Add\' id=\'add7\' class=\'add7 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear8", function(){
    // alert('fu');
            var serv = $('#markGearOption3').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[3];
            var data = $('#gearAdd8').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            var answer1 = confirm('Would you like to remove '+name+' from this purchase?');
                               if (!answer1) {
                                      return false;
                                     }
                                     
           $('input:radio[name=serviceOptions8]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           cost = parseFloat(cost);
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var total = balanceDue - cost;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           $('tr:contains('+name+')').remove(); 
           
           $('#markGearOption3').val(null); 
           var buttonClass = $("#clear8").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
           
           $("#buttonArea8").html('<center><input type=\'button\' value=\'Add\' id=\'add8\' class=\'add8 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear9", function(){
    // alert('fu');
            var serv = $('#markGearOption4').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[3];
            
             var data = $('#gearAdd9').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            var answer1 = confirm('Would you like to remove '+name+' from this purchase?');
                               if (!answer1) {
                                      return false;
                                     }
                                     
           $('input:radio[name=serviceOptions9]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           cost = parseFloat(cost);
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var total = balanceDue - cost;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           $('tr:contains('+name+')').remove(); 
           
           $('#markGearOption4').val(null); 
           var buttonClass = $("#clear9").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
           
           $("#buttonArea9").html('<center><input type=\'button\' value=\'Add\' id=\'add9\' class=\'add9 '+class1+' buttonSize\'></center>');
        
     
  });
   });
   
   $(function(){
   $(document).on("click","#clear10", function(){
    // alert('fu');
            var serv = $('#markGearOption5').val(); 
            //alert(serv);
            var servArray = serv.split('|');
            var muliplyer = servArray[3];
            
            var data = $('#gearAdd10').val();
            var dataArray = data.split('|');   
            var invMarker = dataArray[0]; 
            var cost = dataArray[1];
            var name = dataArray[2];
            var origServicePrice = cost;
            var answer1 = confirm('Would you like to remove '+name+' from this purchase?');
                               if (!answer1) {
                                      return false;
                                     }
                                     
           $('input:radio[name=serviceOptions10]:checked').prop('checked', false);
           var balanceDue = $('#balance_due').val();
           balanceDue = parseFloat(balanceDue);
           cost = parseFloat(cost);
           muliplyer = parseFloat(muliplyer); 
           //alert(muliplyer);
           //alert(servicePrice);
           cost = cost * muliplyer;
           var total = balanceDue - cost;
           total = total.toFixed(2);
           $('#balance_due').val(total);
           $('#balance_due_backup').val(total);
           $('tr:contains('+name+')').remove(); 
           
           $('#markGearOption5').val(null); 
           var buttonClass = $("#clear10").attr("class");
           //alert(buttonClass);
           var classArray = buttonClass.split(' ');
           var class1 = classArray[1];
           
           $("#buttonArea10").html('<center><input type=\'button\' value=\'Add\' id=\'add10\' class=\'add10 '+class1+' buttonSize\'></center>');
        
     
  });
   });

});
//======================================================================
function openLiabiltyWindow()  {

window.open('liabilityWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//---------------------------------------------------------------------
function openContractWindow()  {
//alert('Open Contract Window'); 
window.open('contractWindow.php?ptBool=2','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}


//---------------------------------------------------------------------
//===================================
$(document).ready(function() {

  $(".buttonSubmit").click(function() {
    
    var saleArray = $('#sale_array').val();
    var termsViewed = $('terms_viewed').val(); 
    var clubId = $('#clubId').val(); 
   
        if(document.getElementById('terms_conditions').checked == false){
           alert('You must read and agree to the Terms and Conditions before proceding.');
           return false;
        }
       
            //do a check onthe credit csrd to auth netif present
            var cardType = $("#card_type").val();
            var cardName = $("#card_name").val();
            var cardNumber = $("#card_number").val();
            var cardCvv = $("#card_cvv").val();
            var cardMonth = $("#card_month").val();
            var cardYear = $("#card_year").val();
            var creditPayment = $("#credit_pay").val();       
            
            var bankName = $("#bank_name").val();
            var accountType = $("#account_type").val();
            var accountName = $("#account_name").val();
            var accountNumber = $("#account_num").val();
            var routingNumber = $("#aba_num").val();
            var achPayment = $("#ach_pay").val();
           // var creditPayment = $("#credit_pay").val();
            var cashPayment = $("#cash_pay").val();
            var checkPayment = $("#check_pay").val();
            var checkNumber = $("#check_number").val();
            var checkNumberField = $("#check_number").val();
            var checkNumberFieldName = 'check_number';
            
            //=======================================================================================
            //======================================================================================                        
        
               
                //here we make sure that a monthly billing cycle is selected if it exists for the service
            var radioSwitch = $("#setMonth1").html();
             if(radioSwitch != "") {
                var monthlyBillingSelected = "";

                if(document.getElementById('monthly_billing1').checked == true) {
                  $("monthly_billing_selected").val('CR');
                  monthlyBillingSelected = 'CR';
                }
                if(document.getElementById('monthly_billing2').checked == true) {
                  $("monthly_billing_selected").val('BA');
                  monthlyBillingSelected = 'BA';
                }
                
                 if($("monthDues").val() != 0.00 || $("monthDues").val() != ""){
                  if($('input:radio[name=eftVerify]:checked').val() == undefined || $('input:radio[name=eftVerify]:checked').val() == 'No'){
                        alert('Please read the \"MONTHLY TRANSACTION REQUEST:\" and agree to the terms by selecting yes to continue.');
                        return false;
                    }
                  }  
                 
                if(document.getElementById('monthly_billing1').checked != true && document.getElementById('monthly_billing2').checked != true){
                    alert('Please select a Monthly billing option.');
                    return false;
                }
               }   
               
                achPayment.trim();
                if(achPayment == "" && creditPayment == "")  {
                    alert('Please enter a payment amount into one or more of the following fields: \"Credit Payment\", \"ACH Payment\"');
                    return false;
                    }  
                                           
                    //make sure the payment amount is the same as todays payment also make sure cc or bank feilds are filled out
                    var todaysPayment = $("#today_payment").val();
                    todaysPayment = parseFloat(todaysPayment);
                    todaysPayment = todaysPayment.toFixed(2);
                                  
                    if(achPayment == "") {
                       achPayment = 0;  
                       }else{
                       var bankName = document.getElementById('bank_name').value;
                       var accountType = document.getElementById('account_type').value;
                       var accountName = document.getElementById('account_name').value;
                       var accountNumber = document.getElementById('account_num').value;
                       var routingNumber = document.getElementById('aba_num').value;
                       var routingValue = document.getElementById('aba_num').value;
                       var routingName = document.getElementById('aba_num');
                       var i;
                       var n;
                       var t;


            if(bankName == "")  {
             alert('Please enter a Bank Name');
             document.getElementById('bank_name').focus();
             return false;            
            }                

            if(accountType == "")  {
             alert('Please select an Account Type');
             document.getElementById('account_type').focus();
             return false;            
            }        

            if(accountName == "")  {
             alert('Please enter the name on the account');
             document.getElementById('account_name').focus();
             return false;            
            }     

            if(accountNumber == "")  {
             alert('Please enter the Account Number');
             document.getElementById('account_num').focus();
             return false;            
            }            

            if(routingNumber == "")  {
             alert('Please enter the Routing Number');
             document.getElementById('aba_num').focus();
             return false;            
            }  
            
            
                            
                             
                              if (isNaN(routingValue)) {
                               alert('Routing Number may only contain numbers');
                               document.getElementById('aba_num').value = "";
                               routingName.focus();   
                               return false;
                               }
                            
                              if (routingValue.length < 9) {
                                 alert('Routing Number is too short. Routing number must be 9 charachters in length.');
                                 document.getElementById('aba_num').value = "";
                                 routingName.focus();   
                                 return false;
                                } 
                                
                               if (routingValue.length > 9) {
                                 alert('Routing Number is too long. Routing number must be 9 charachters in length.');
                                 document.getElementById('aba_num').value = "";
                                 routingName.focus();   
                                 return false;
                                } 
                             
                             
                               t = "";
                              for (i = 0; i < routingValue.length; i++) {
                                c = parseInt(routingValue.charAt(i), 10);
                                       if (c >= 0 && c <= 9) {
                                           t = t + c;
                                         }
                                  }
                             
                             
                              n = 0;
                              for (i = 0; i < t.length; i += 3) {
                                   n += parseInt(t.charAt(i),     10) * 3
                                   +  parseInt(t.charAt(i + 1), 10) * 7
                                   +  parseInt(t.charAt(i + 2), 10);
                                   }
                            
                              // If the resulting sum is an even multiple of ten (but not zero),
                              // the aba routing number is good.
                            
                                            if (n != 0 && n % 10 == 0)  {
                                               return true;
                                               }else{
                                                 alert('Routing Number is not in the correct format');
                                                 document.getElementById('aba_num').value = "";
                                                 routingName.focus();   
                                                 return false;
                                                }
  
                              }
                              
                              
                            if(creditPayment == "") {  
                              creditPayment = 0;
                              }else{
                                var cardType = document.getElementById('card_type').value;
                                var cardName = document.getElementById('card_name').value;
                                var cardNumber = document.getElementById('card_number').value;
                                var cardCvv = document.getElementById('card_cvv').value;
                                var cardMonth = document.getElementById('card_month').value;
                                var cardYear = document.getElementById('card_year').value;




           if(cardType == "")  {
             alert('Please select a \"Card Type\"');
             document.getElementById('card_type').focus();
             return false;            
            }     

            if(cardName == "")  {
             alert('Please enter the \"Name on Card\"');
             document.getElementById('card_name').focus();
             return false;            
            }            

            if(cardNumber == "")  {
             alert('Please enter the \"Card Number\"');
             document.getElementById('card_number').focus();
             return false;            
             }
             
             if(cardNumber != "")  {
             var cardBool = validCreditCard();
                  if(cardBool == false) {
                     return false;
                     }             
              }
            

            if(cardCvv == "")  {
             alert('Please enter the \"Security Code\"');
             document.getElementById('card_cvv').focus();
             return false;            
            } 
            
            if(cardCvv != "")  {
            var cardType = document.getElementById('card_type').value;
                    var cvvValue = document.getElementById('card_cvv').value;
                    var cvvName = document.getElementById('card_cvv');
                    var cvvLength;
                    
                    cvvValue = cvvValue.replace(/\s+/g, "");
                    
                    switch(cardType)  {
                    case 'Visa':
                    cvvLength = 3; 
                    break;
                    case 'MC':
                    cvvLength = 3; 
                    break;
                    case 'Amex':
                    cvvLength = 4; 
                    break;
                    case 'Disc':
                    cvvLength = 3; 
                    break;  
                    }
                    
                    
                    if (isNaN(cvvValue)) {
                       alert('Security Code may only contain Numbers');
                       document.getElementById(cvvField).value = "";
                       cvvName.focus();   
                       return false;
                    }
                    
                    if(cvvValue.length < cvvLength)  {
                       alert('Security Code is too short');
                       document.getElementById(cvvField).value = "";
                       cvvName.focus();   
                       return false;
                    }
                    
                    if(cvvValue.length > cvvLength)  {
                       alert('Security Code is too long');
                       document.getElementById(cvvField).value = "";
                       cvvName.focus();   
                       return false;
                    }
        
             }
            
            
            

            if(cardMonth == "")  {
             alert('Please select the \"Card Month\"');
             document.getElementById('card_month').focus();
             return false;            
            }            

            if(cardYear == "")  {
             alert('Please select the \"Card Year\"');
             document.getElementById('card_year').focus();
             return false;            
            }          
                  }          
                            achPayment = parseFloat(achPayment);
                            creditPayment = parseFloat(creditPayment);          
                            
                            
                            var paymentTotals = achPayment + creditPayment;
                            //check to see if amount is greater than todays payment
                                        if(paymentTotals > todaysPayment) {
                                             paymentTotals = paymentTotals.toFixed(2); 
                                             todaysPayment = todaysPayment.toFixed(2); 
                                           alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is greater than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                                            return false;
                                          }
                            
                            //now check to see if it is less
                                        if(paymentTotals < todaysPayment) {
                                             paymentTotals = paymentTotals;//.toFixed(2); 
                                             todaysPayment = todaysPayment;//.toFixed(2); 
                                           alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is less than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                                            return false;
                                          }


var sig = document.getElementById('input_name').value;
//alert(sig);
 if(sig == '')  {
                    var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }


                var xtrService1 = $('#markServOption1').val(); 
                var xtrService2 = $('#markServOption2').val();
                var xtrService3 = $('#markServOption3').val();
                var xtrService4 = $('#markServOption4').val();
                var xtrService5 = $('#markServOption5').val();
                
                
                var totalServiceArray = "";
                if (xtrService1 != ""){
                    totalServiceArray += xtrService1+"~";
                }
                if (xtrService2 != ""){
                    totalServiceArray += xtrService2+"~";
                }
                if (xtrService3 != ""){
                    totalServiceArray += xtrService3+"~";
                }
                if (xtrService4 != ""){
                    totalServiceArray += xtrService4+"~";
                }
                if (xtrService5 != ""){
                    totalServiceArray += xtrService5;
                }
                
                var xtrGear1 = $('#markGearOption1').val(); 
                var xtrGear2 = $('#markGearOption2').val(); 
                var xtrGear3 = $('#markGearOption3').val(); 
                var xtrGear4 = $('#markGearOption4').val(); 
                var xtrGear5 = $('#markGearOption5').val();
                
                var totalGearArray = "";
                if (xtrGear1 != ""){
                    totalGearArray += xtrGear1+"~";
                }
                if (xtrGear2 != ""){
                    totalGearArray += xtrGear2+"~";
                }
                if (xtrGear3 != ""){
                    totalGearArray += xtrGear3+"~";
                }
                if (xtrGear4 != ""){
                    totalGearArray += xtrGear4+"~";
                }
                if (xtrGear5 != ""){
                    totalGearArray += xtrGear5;
                }
              

                //disable save button to prevent double charges
                $(".buttonSubmit").attr("disabled", "disabled");
                     //alert('fu');
                
                //encode card type
                cardType = encodeURIComponent(cardType);
                cardName = encodeURIComponent(cardName);
                cardNumber = encodeURIComponent(cardNumber);
                cardCvv = encodeURIComponent(cardCvv);
                cardMonth = encodeURIComponent(cardMonth);
                cardYear = encodeURIComponent(cardYear);
                creditPayment = encodeURIComponent(creditPayment);
                
                //encode banking info
                bankName = encodeURIComponent(bankName);
                accountType = encodeURIComponent(accountType);
                accountName = encodeURIComponent(accountName);
                accountNumber = encodeURIComponent(accountNumber);
                routingNumber = encodeURIComponent(routingNumber);
                achPayment = encodeURIComponent(achPayment);
                
                //additional sale arrays
                totalServiceArray = encodeURIComponent(totalServiceArray);
                totalGearArray = encodeURIComponent(totalGearArray);
                
                //alert('fu');
                //alert('fu');
                 $.ajax ({
                 type: "POST",
                 url: "contractCardCheckRenewal.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {card_type: cardType, card_name: cardName, card_number: cardNumber, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, credit_pay: creditPayment, bank_name: bankName, account_type: accountType, account_name: accountName, account_number: accountNumber, routing_number: routingNumber, ach_pay: achPayment, sale_array: saleArray, length: length, sig: sig, totalServiceArray: totalServiceArray, totalGearArray: totalGearArray, clubId: clubId, monthlyBillingSelected: monthlyBillingSelected},              
                 success: function(data) {    
                alert(data);
                         
                    if(data != 11) {
                        $('.buttonSubmit').prop('disabled', false);
                        alert(data);
                        $( "#card_type" ).focus();
                       }else if(data == 11) {
                        setTimeout('openContractWindow()', 1000);                  
                                             }
                                             
                     }//end function success
                    
              }); //end ajax              
         
        
    });
});
//------------------------------------------------------------------------------------------------------------------------------------------------
function setPaymentRadioButtons(monthTotal)   {
   
var cycleDay = document.getElementById('cycleDay').value;
var pastDay = document.getElementById('pastDay').value;
var enhanceFee = document.getElementById('enhanceFee').value;
var rejectionFee = document.getElementById('rejectionFee').value;
var lateFee = document.getElementById('lateFee').value;

var monthlyDues = document.getElementById('monthDues').value;
var monthlyBool = document.getElementById('monthly_bool').value;
//get the file permissions for the radios
var monthBit = document.getElementById('month_bit').value;
var monthBitArray = monthBit.split("");
var creditDisabled;
var bankDisabled;
//alert(monthlyBool);

if(monthBitArray[2] == 1) {
    bankDisabled = "";
    }else{
    bankDisabled ='disabled="disabled"';
    }    
    
if(monthBitArray[3] == 1) {
    creditDisabled = "";
    }else{
    creditDisabled ='disabled="disabled"';
    }    


var buttonTitle= 'Set Monthly Billing:';
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id)"'+creditDisabled+'/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"'+bankDisabled+'/>';


if(monthlyBool == "0")  {
document.getElementById('setMonth1').innerHTML = "";
document.getElementById('setMonth2').innerHTML = "";
document.getElementById('setMonthCredit').innerHTML = "";
document.getElementById('setMonthBank').innerHTML = "";
}else{
    var eftHtml = "<b><input type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";

document.getElementById('setMonth1').innerHTML = buttonTitle;
document.getElementById('setMonth2').innerHTML = buttonTitle;
document.getElementById('setMonthCredit').innerHTML = creditRadio;
document.getElementById('setMonthBank').innerHTML = bankRadio;
document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
document.getElementById('verifyEft').innerHTML = eftHtml;


}
}
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
function setTodaysPayment()  {
//alert(todaysPayment);
var totalDue;
var balanceDue;
var balanceDueForm;

setPaymentRadioButtons();



totalDue = document.getElementById('balance_due').value;
totalDueBackup = document.getElementById('balance_due_backup').value;
todaysPayment = document.getElementById('today_payment').value;
if(todaysPayment == ""){
     todaysPayment = 0;
}
//alert('today pay '+totalDue);
//alert(monthlyPayment);
if(isNaN(todaysPayment)) {
  todaysPayment = 0;
  alert('The value you entered is not a number.');
      return false;
  }

totalDue = parseFloat(totalDue);

todaysPayment = parseFloat(todaysPayment);

  
balanceDue = totalDueBackup - todaysPayment;
balanceDueForm = balanceDue;
balanceDueForm = balanceDueForm.toFixed(2);

if(totalDue == 0) {
balanceDue = 0;
//todaysPayment = 0;
balanceDueForm = "";

//set the balance due date
//setBalanceDueDate();

}

if(isNaN(balanceDue)) {
  balanceDue = parseFloat(totalDueBackup);
  }

balanceDue = balanceDue.toFixed(2); 
//
todaysPayment = todaysPayment.toFixed(2);
//if(isNaN(balanceDue)) {
//  balanceDue = totalDueBackup;
//  }
//alert(todaysPayment);
document.getElementById('balance_due').value = balanceDueForm;
//document.getElementById('balance_due').value = balanceDue;
//document.getElementById('today_payment').value = todaysPayment;
document.getElementById('todayPayTwoTotal').innerHTML = todaysPayment;


}
//================================================================
function validCreditCard() {

var cardType = document.getElementById('card_type').value;
var cardNumber = document.getElementById('card_number').value;

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, "");

   if (cardType == "Visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Visa';
     }else if(cardType == "MC") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Master Card';
      }else if(cardType == "Disc") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
      var cardText = 'Discover';
      }else if(cardType == "Amex") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
      var cardText = 'American Express';
       }else if(cardType == "Diners") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
      var cardText = 'Diners Club';
      }
   
  
         if(!re.test(cardNumber)) {  
            alert('Invalid ' +cardText+ ' Credit Card Number');
            document.getElementById('card_number').value ="";
            document.getElementById('card_number').focus();
            return false;
           }

        if(cardType == "") {
           alert('Please select a card type');
           document.getElementById('card_type').focus();
            return false;
            }
          
   
   var checksum = 0;
   for (var i=(2-(cardNumber.length % 2)); i<= cardNumber.length; i+=2) {
      checksum += parseInt(cardNumber.charAt(i-1));
       }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(cardNumber.length % 2) + 1; i<cardNumber.length; i+=2) {
      var digit = parseInt(cardNumber.charAt(i-1)) * 2;
      if (digit < 10) { 
      checksum += digit; 
      }else{ 
      checksum += (digit-9); 
      }
   }
   
   
   
   if ((checksum % 10) == 0) {
       return true; 
       }else{
       alert('Invalid Credit Card Number');
       document.getElementById('card_number').value ="";
       
       document.getElementById('card_number').focus();
       return false;
      }
      
      
}      

//---------------------------------------------------------------------------------------------------------------------------------------------
function getMemberNumber()   {

              var memberNumber = document.getElementById('mem_num').value;
                    if(memberNumber == "") {
                      memberNumber = 1;
                     }
              return memberNumber;
}
//---------------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------------
function browserKinks() {

 var versionSwitch = document.getElementById('parse_switch').value;

// if(versionSwitch != "3") {
     this.phoneField=null;
     this.routeField=null;
     this.dobField=null;
     this.cardField=null;
     this.cvvField=null;
     this.zipField=null;
     this.emailField=null;
 // }


}
//------------------------------------------------------------------------------------------------------------------------------------------------
function checkDayMonth(month, day) {

switch(month)  {
case '01':
 if(day > 31) {
 return false;
 }
break;
case '02':
if(day > 29) {
return false;
}
break;
case '03':
if(day > 31) {
return false;
}
break;
case '04':
if(day > 30) {
return false;
}
break;  
case '05':
if(day >31) {
return false;
}
break;  
case '06':
if(day > 30) {
return false;
}
break;  
case '07':
if(day > 31) {
return false;
}
break; 
case '08':
if(day > 31) {
return false;
}
break; 
case '09':
if(day > 30) {
return false;
}
break; 
case '10':
if(day > 31) {
return false;
}
break;  
case '11':
if(day >30) {
return false;
}
break;  
case '12':
if(day > 31) {
return false;
}
break;  
}


}
//--------------------------------------------------------------------------------------------------------------
function checkDob()  {

var dobValue = document.getElementById(dobField).value;
var dobName = document.getElementById(dobField);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   document.getElementById(dobField).value ="";
   dobName.focus();
   browserKinks();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        document.getElementById(dobField).value ="";
        dobName.focus();
        browserKinks();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         document.getElementById(dobField).value ="";
         dobName.focus();
         browserKinks();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   document.getElementById(dobField).value ="";
                                   dobName.focus();
                                   browserKinks();                                   
                                   return false;                                                                   
                                  }       
        }
      
            
      
   }

}
//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber()  {

var phoneValue = document.getElementById(phoneField).value;
var phoneName = document.getElementById(phoneField);

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneField).value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneField).value = "";
               phoneName.focus();
              browserKinks();
               return false;
    }

}
//----------------------------------------------------------------------------------------------------------------
function checkZipCode()  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');   
 //  setTimeout ('document.getElementById(zipField).focus()',300);
 //  setTimeout ('alert(\'Zip Code may only contain Numbers\')', 300);    
   document.getElementById(zipField).value = "";
   document.getElementById(zipField).focus();
   browserKinks();
   return false;
}
if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('The Zip Code you entered is too short');
  document.getElementById(zipField).value = "";
  browserKinks();
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail()  {

var emailValue = document.getElementById(emailField).value;
var fieldName = document.getElementById(emailField);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          document.getElementById(emailField).value ="";
          fieldName.focus(); 
          browserKinks();
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
          browserKinks();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		    return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;		 
         }




}
//------------------------------------------------------------------------------------------------------------------
function setEmailListeners(fieldId) {

this.emailField = fieldId;
var fieldFocus = document.getElementById(emailField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkEmail()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkEmail()});                           
}          

}
//-------------------------------------------------------------------------------------------------------------------
function setZipListeners(fieldId) {

this.zipField = fieldId;
var fieldFocus = document.getElementById(zipField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkZipCode()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkZipCode()});                           
}          


}
//--------------------------------------------------------------------------------------------------------------------
function setPhoneListeners(fieldId) {

this.phoneField = fieldId;
var fieldFocus = document.getElementById(phoneField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkPhoneNumber()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkPhoneNumber()});                           
}          


}
//--------------------------------------------------------------------------------------------------------------------
function setDobListeners(fieldId) {

this.dobField = fieldId;
var fieldFocus = document.getElementById(dobField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkDob()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkDob()});                           
}          

}
//--------------------------------------------------------------------------------------------------------------------
function setPaymentListeners(fieldId) {

this.paymentField = fieldId;
var fieldFocus = document.getElementById(paymentField);

//try 
//{
//alert(paymentField);
 var fullFieldValue;
    
    fullFieldValue = $('#'+paymentField+'').val();//this.value;
    //alert(fullFieldValue);
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    
/*}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {
    var fullFieldValue = this.value;
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    });                           
}    */


}


//--------------------------------------------------------------------------------------------------------------------------------
function checkGroupInfo(fieldId)  {


var tip = 1;
var  typeName = document.getElementById('type_name').value;
var  typeAddress = document.getElementById('type_address').value;
var  typePhone = document.getElementById('type_phone').value;

if(fieldId != 'type_name')  {
   if(typeName == "") {
      alert('Please enter the ' +smallHeader+ ' Name');
      document.getElementById('type_name').focus();
      return tip;
     }
}else{
return true;
}


if(fieldId != 'type_address')  {
   if(typeAddress == "") {
     alert('Please enter the ' +smallHeader+ ' Address');
     document.getElementById('type_address').focus();
     return tip;
     }
}else{
return true;
}

if(fieldId != 'type_phone')  {
   if(typePhone == "") {
     alert('Please enter the ' +smallHeader+ ' Phone Number');
     document.getElementById('type_phone').focus();
     return tip;
     }
}else{
return true;
}

if(typeName == "" && typeAddress == "" && typePhone == "") {
   alert('Please fill out all of the ' +typeHeader);
   document.getElementById('type_name').focus();
   return tip;
}

}

//-----------------------------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//set an event listener depending on if the fied is an email address zip code or phone number or date of birth
var emailPattern = /email/g;
var emailResult = emailPattern.test(fieldId);
if(emailResult == true) {
this.emailField = fieldId;
setEmailListeners(fieldId);
}
var zipPattern = /zip/g;
var zipResult = zipPattern.test(fieldId);
if(zipResult == true) {
this.zipField = fieldId;
setZipListeners(fieldId);
}
var phonePattern = /phone/g;
var phoneResult = phonePattern.test(fieldId);
if(phoneResult == true) {
this.phoneField = fieldId;
setPhoneListeners(fieldId);
}
var dobPattern = /dob/g;
var dobResult = dobPattern.test(fieldId);
if(dobResult == true) {
this.dobField = fieldId;
setDobListeners(fieldId);
}



var paymentPattern = /^[a-zA-Z]+_pay$/;
var paymentResult = paymentPattern.test(fieldId);
if(paymentResult == true) {
this.paymentField = fieldId;
setPaymentListeners(fieldId);
}


var serviceTotal;
var todaysPayment;
var balanceDueDate;

serviceTotal = document.getElementById('balance_due').innerHTML;
serviceTotal = parseFloat(serviceTotal);
todaysPayment = document.getElementById('today_payment').value;
//balanceDueDate = document.form1.due_date.value;

//make sure they have selected a service value before proceeding
if(serviceTotal == "0.00") {
  alert('Please select a service');
  return false;
}

//make sure they have set todays payment if a service is selected
if(fieldId != 'today_payment')  {
           if(serviceTotal != "0.00" && todaysPayment == "") {
             alert('Please enter \"Todays Payment\"');
             document.getElementById('today_payment').focus();
             return false;
             }
}else{
return true;
}                  
             

//make sure the ballance due date is selected
if(fieldId != 'rem_day')  {
           if(balanceDueDate == "")  {
             alert('Please select the \"Balance Due Date\"');
             document.getElementById('rem_day').focus();
            return false;
            }
}else{
return true;
}      



//check the group type to make sure business or orgnization fields are filled out
var groupType = document.getElementById('group_type').value;

this.primaryContact = "Member";
//------------------------------------------------------------------------------------------------------------------------
function comfirmSale() {

var message = document.getElementById('confirmation_message').value; 

if(message != "") {
   alert(message);
  }
}

}




