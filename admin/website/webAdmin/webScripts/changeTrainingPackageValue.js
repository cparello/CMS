$(document).ready(function(){
$('input:radio[name=yearOptions1]:nth(3)').attr('checked',true);
$('input:radio[name=yearOptions2]:nth(3)').attr('checked',true);
$('input:radio[name=yearOptions3]:nth(3)').attr('checked',true);
$('input:radio[name=yearOptions4]:nth(3)').attr('checked',true);
$('input:radio[name=yearOptions5]:nth(3)').attr('checked',true);
$('input:radio[name=yearOptions6]:nth(3)').attr('checked',true);
});
//===================================================================================================
jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
         var costField = $(this).attr('field2');
         var totField = $(this).attr('field3');
         var processField = $(this).attr('field4');
         var prorateField = $(this).attr('field5');
        var dueToday = $("#"+costField+"").html();
        var process = $("#"+processField+"").html();
        var prorate = $("#"+prorateField+"").html();
        //alert(process);
        //alert(dueToday);
        dueToday = dueToday.replace("$", "");
        //dueToday = dueToday.replace("</span>", "");
        dueToday = parseFloat(dueToday);
       // dueToday = dueToday.toFixed(2);
        if (process != null){
        process = process.replace("$", "");
        //dueToday = dueToday.replace("</span>", "");
        process = parseFloat(process);
       // process = process.toFixed(2);
         }else{
            process = parseFloat(0);
        }
        
        if (prorate != null){
             prorate = prorate.replace("$", "");
            //dueToday = dueToday.replace("</span>", "");
            prorate = parseFloat(prorate);
        }else{
            prorate = parseFloat(0);
        }
       
       // prorate = prorate.toFixed(2);
        //alert(process);
        //alert(prorate);
        //alert(dueToday);
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            var quantity = currentVal + 1;
             var newTotal = (dueToday+process+prorate)*quantity;
             //alert(newTotal);
             newTotal = parseFloat(newTotal);
              newTotal = newTotal.toFixed(2);
            $("#"+totField+"").html('$'+newTotal);
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            $("#"+totField+"").html(dueToday);
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        var costField = $(this).attr('field2');
        var totField = $(this).attr('field3');
         var processField = $(this).attr('field4');
         var prorateField = $(this).attr('field5');
        var dueToday = $("#"+costField+"").html();
        var process = $("#"+processField+"").html();
        var prorate = $("#"+prorateField+"").html();
        //alert(dueToday);
        dueToday = dueToday.replace("$", "");
        //dueToday = dueToday.replace("</span>", "");
        dueToday = parseFloat(dueToday);
        //dueToday = dueToday.toFixed(2);
         if (process != null){
                process = process.replace("$", "");
                //dueToday = dueToday.replace("</span>", "");
                process = parseFloat(process);
               // process = process.toFixed(2);
         }else{
            process = parseFloat(0);
        }
        
        if (prorate != null){
             prorate = prorate.replace("$", "");
            //dueToday = dueToday.replace("</span>", "");
            prorate = parseFloat(prorate);
        }else{
            prorate = parseFloat(0);
        }
       // prorate = prorate.toFixed(2);
        //alert(dueToday);
      
        //alert(fieldName);
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one 
            var quantity = currentVal - 1;
             var newTotal = (dueToday+process+prorate)*quantity;
              newTotal = parseFloat(newTotal);
              newTotal = newTotal.toFixed(2);
            $("#"+totField+"").html('$'+newTotal);
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            $("#"+totField+"").html('$0.00');
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});

//===================================================================================================

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=yearOptions1]');
    radios1.on('change', function() {
    yearValue1 = $('input:radio[name=yearOptions1]:checked').val();    
        var serviceName = $("#membership1").html();
        serviceName = serviceName.replace("<span id=\"membership1\">", "");
        serviceName = serviceName.replace("</span>", "");
        $('input[name=quantity1]').val(0);
        //alert('fubar'+serviceName+yearValue1);
      //  alert('fu'+serviceName+' '+yearValue1+'');
        $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue1},               
                     success: function(data) {  
//alert(data);
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     
                          if(successBit == 1) {                             
                             $("#cost1").html('$'+price);
                             $("#total1").html('$'+totPrice);     
                              if (yearValue1 == 1){
                                $("#pifYears1").html(yearValue1+' Class');   
                             }else{
                                $("#pifYears1").html(yearValue1+' Classes');  
                             }               
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios2 = $('input[name=yearOptions2]');
    radios2.on('change', function() {
    yearValue2 = $('input:radio[name=yearOptions2]:checked').val();    
        var serviceName = $("#membership2").html();
        serviceName = serviceName.replace("<span id=\"membership2\">", "");
        serviceName = serviceName.replace("</span>", "");
       // alert('fubar'+serviceName+yearValue2);
       $('input[name=quantity2]').val(0);
        
         $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue2},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     
                          if(successBit == 1) {                             
                             $("#cost2").html('$'+price);
                             $("#total2").html('$'+totPrice); 
                              if (yearValue2 == 1){
                                $("#pifYears2").html(yearValue2+' Class');   
                             }else{
                                $("#pifYears2").html(yearValue2+' Classes');  
                             }        
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios3 = $('input[name=yearOptions3]');
    radios3.on('change', function() {
    yearValue3 = $('input:radio[name=yearOptions3]:checked').val();    
        var serviceName = $("#membership3").html();
        serviceName = serviceName.replace("<span id=\"membership3\">", "");
        serviceName = serviceName.replace("</span>", "");
        //alert('fubar'+serviceName+yearValue3);
        $('input[name=quantity3]').val(0);
        
         $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue3},               
                     success: function(data) {  
                   // alert(data);
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                    
                    //  alert(successBit);
                          if(successBit == 1) {  
                           // alert('test');
                             $("#cost3").html('$'+price);
                             $("#total3").html('$'+totPrice); 
                              if (yearValue3 == 1){
                                $("#pifYears3").html(yearValue3+' Class');   
                             }else{
                                $("#pifYears3").html(yearValue3+' Classes');  
                             }               
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios4 = $('input[name=yearOptions4]');
    radios4.on('change', function() {
    yearValue4 = $('input:radio[name=yearOptions4]:checked').val();    
        var serviceName = $("#membership4").html();
        serviceName = serviceName.replace("<span id=\"membership4\">", "");
        serviceName = serviceName.replace("</span>", "");
        //alert('fubar'+serviceName+yearValue4);
        $('input[name=quantity4]').val(0);
        
         $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue4},               
                     success: function(data) {  
                  //  alert(data);
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     
                          if(successBit == 1) {                             
                             $("#cost4").html('$'+price);
                             $("#total4").html('$'+totPrice);  
                              if (yearValue4 == 1){
                                $("#pifYears4").html(yearValue4+' Class');   
                             }else{
                                $("#pifYears4").html(yearValue4+' Classes');  
                             }              
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios5 = $('input[name=yearOptions5]');
    radios5.on('change', function() {
    yearValue5 = $('input:radio[name=yearOptions5]:checked').val();    
        var serviceName = $("#membership5").html();
        serviceName = serviceName.replace("<span id=\"membership5\">", "");
        serviceName = serviceName.replace("</span>", "");
       // alert('fubar'+serviceName+yearValue5);
       $('input[name=quantity5]').val(0);
        
         $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue5},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     
                          if(successBit == 1) {                             
                             $("#cost5").html('$'+price);
                             $("#total5").html('$'+totPrice);
                             if (yearValue5 == 1){
                                $("#pifYears5").html(yearValue5+' Class');   
                             }else{
                                $("#pifYears5").html(yearValue5+' Classes');  
                             }            
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios6 = $('input[name=yearOptions6]');
    radios6.on('change', function() {
    yearValue6 = $('input:radio[name=yearOptions6]:checked').val();    
        var serviceName = $("#membership6").html();
        serviceName = serviceName.replace("<span id=\"membership6\">", "");
        serviceName = serviceName.replace("</span>", "");
      //  alert('fubar'+serviceName+yearValue6);
      $('input[name=quantity6]').val(0);
        
         $.ajax ({
                type: "POST",
                url: "loadTrainingPackagePricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue6},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     
                          if(successBit == 1) {                             
                             $("#cost6").html('$'+price);
                             $("#total6").html('$'+totPrice); 
                             if (yearValue6 == 1){
                                $("#pifYears6").html(yearValue6+' Class');   
                             }else{
                                $("#pifYears6").html(yearValue6+' Classes');  
                             }
                                         
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
    });
});
//===============================================================================================================
$(document).ready(function(){

$('#purchase').click(function() {
     var alreadyMember = $('#alreadyMember').val(); 
    
    if(alreadyMember == 0)  {
                    var answer1 = confirm("You are not logged in! If you are already a member please click cancel and login to your account first. If you are not a member click ok to continue. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }
    
var serviceName1 = $("#membership1").html();

//alert(locationArr[1]);
//alert(serviceName1);
if(serviceName1 != null){
    var servName = serviceName1.split('&');
var locationArr = servName[2].split(';');
serviceName1 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships1 = $("input[name=quantity1]").val();
var yearValue1 = $('input:radio[name=yearOptions1]:checked').val();  
serviceName1 = serviceName1.replace("<span id=\"membership1\">", "");
serviceName1 = serviceName1.replace("</span>", "");
var totalSale1 = $("#total1").html();
totalSale1 = totalSale1.replace("<span id=\"total1\">", "");
totalSale1 = totalSale1.replace("</span>", "");  
totalSale1 = totalSale1.replace("$", "");
if (yearValue1 == undefined){
    var yearValue1 = $("#pifYears1").html();
    yearValue1 = yearValue1.replace("<span id=\"pifYears1\">", "");
    yearValue1 = yearValue1.replace("</span>", "");  
}
}
var serviceName2 = $("#membership2").html();

if(serviceName2 != null){
    var servName = serviceName2.split('&');
var locationArr = servName[2].split(';');
serviceName2 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships2 = $("input[name=quantity2]").val();
var yearValue2 = $('input:radio[name=yearOptions2]:checked').val(); 
serviceName2 = serviceName2.replace("<span id=\"membership2\">", "");
serviceName2 = serviceName2.replace("</span>", "");
var totalSale2 = $("#total2").html();
totalSale2 = totalSale2.replace("<span id=\"total2\">", "");
totalSale2 = totalSale2.replace("</span>", "");
totalSale2 = totalSale2.replace("$", "");
if (yearValue2 == undefined){
    var yearValue2 = $("#pifYears2").html();
    yearValue2 = yearValue2.replace("<span id=\"pifYears2\">", "");
    yearValue2 = yearValue2.replace("</span>", "");  
} 
}

var serviceName3 = $("#membership3").html();

if(serviceName3 != null){
    var servName = serviceName3.split('&');
var locationArr = servName[2].split(';');
serviceName3 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships3 = $("input[name=quantity3]").val();
var yearValue3 = $('input:radio[name=yearOptions3]:checked').val();  
serviceName3 = serviceName3.replace("<span id=\"membership3\">", "");
serviceName3 = serviceName3.replace("</span>", "");
var totalSale3 = $("#total3").html();
totalSale3 = totalSale3.replace("<span id=\"total3\">", "");
totalSale3 = totalSale3.replace("</span>", "");
totalSale3 = totalSale3.replace("$", "");
if (yearValue3 == undefined){
    var yearValue3 = $("#pifYears3").html();
    yearValue3 = yearValue3.replace("<span id=\"pifYears3\">", "");
    yearValue3 = yearValue3.replace("</span>", "");  
}
}
var serviceName4 = $("#membership4").html();

if(serviceName4 != null){
    var servName = serviceName4.split('&');
var locationArr = servName[2].split(';');
serviceName4 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships4 = $("input[name=quantity4]").val();
var yearValue4 = $('input:radio[name=yearOptions4]:checked').val();  
serviceName4 = serviceName4.replace("<span id=\"membership4\">", "");
serviceName4 = serviceName4.replace("</span>", "");
var totalSale4 = $("#total4").html();
totalSale4 = totalSale4.replace("<span id=\"total4\">", "");
totalSale4 = totalSale4.replace("</span>", ""); 
totalSale4 = totalSale4.replace("$", "");
if (yearValue4 == undefined){
    var yearValue4 = $("#pifYears4").html();
    yearValue4 = yearValue4.replace("<span id=\"pifYears4\">", "");
    yearValue4 = yearValue4.replace("</span>", "");  
}
}
var serviceName5 = $("#membership5").html();

if(serviceName5 != null){
    var servName = serviceName5.split('&');
var locationArr = servName[2].split(';');
serviceName5 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships5 = $("input[name=quantity5]").val();
var yearValue5 = $('input:radio[name=yearOptions5]:checked').val();  
var totalSale5 = $("#total5").html();
totalSale5 = totalSale5.replace("<span id=\"total5\">", "");
totalSale5 = totalSale5.replace("</span>", "");  
serviceName5 = serviceName5.replace("<span id=\"membership5\">", "");
serviceName5 = serviceName5.replace("</span>", ""); 
totalSale5 = totalSale5.replace("$", "");
if (yearValue5 == undefined){
    var yearValue5 = $("#pifYears5").html();
    yearValue5 = yearValue5.replace("<span id=\"pifYears5\">", "");
    yearValue5 = yearValue5.replace("</span>", "");  
}
}

var serviceName6 = $("#membership6").html();

if(serviceName6 != null){
    var servName = serviceName6.split('&');
var locationArr = servName[2].split(';');
serviceName6 = ""+servName[0]+"-"+locationArr[1];
var numberMemberships6 = $("input[name=quantity6]").val();
var yearValue6 = $('input:radio[name=yearOptions6]:checked').val();  
var totalSale6 = $("#total6").html();
totalSale6 = totalSale6.replace("<span id=\"total6\">", "");
totalSale6 = totalSale6.replace("</span>", "");  
serviceName6 = serviceName6.replace("<span id=\"membership6\">", "");
serviceName6 = serviceName6.replace("</span>", ""); 
totalSale6 = totalSale6.replace("$", "");
if (yearValue6 == undefined){
    var yearValue6 = $("#pifYears6").html();
    yearValue6 = yearValue6.replace("<span id=\"pifYears6\">", "");
    yearValue6 = yearValue6.replace("</span>", "");  
}
}
var tot1 = $("input[name=quantity1]").val();
if (tot1 == undefined){
    tot1 = 0;
}
var tot2 = $("input[name=quantity2]").val();
if (tot2 == undefined){
    tot2 = 0;
}
var tot3 = $("input[name=quantity3]").val();
if (tot3 == undefined){
    tot3 = 0;
}
var tot4 = $("input[name=quantity4]").val();
if (tot4 == undefined){
    tot4 = 0;
}
var tot5 = $("input[name=quantity5]").val();
if (tot5 == undefined){
    tot5 = 0;
}
var tot6 = $("input[name=quantity6]").val();
if (tot6 == undefined){
    tot6 = 0;
}

//alert($("input[name=quantity6]").val());
var totalQuantity = tot1 + tot2 + tot3 + tot4 + tot5 + tot6;

//alert(totalQuantity);
if (totalQuantity == 0){
    alert('Please select at least one training package before clicking Purchase.');
    return false;   
}
var ajaxSwitch = 1;
  var numMembershipArray = [numberMemberships1, numberMemberships2, numberMemberships3, numberMemberships4, numberMemberships5, numberMemberships6];
  var serviceNameArray  = [serviceName1, serviceName2, serviceName3, serviceName4, serviceName5, serviceName6];
  var yearValueArray  = [yearValue1, yearValue2, yearValue3, yearValue4, yearValue5, yearValue6];
  var totSaleArray  = [totalSale1, totalSale2, totalSale3, totalSale4, totalSale5, totalSale6];
   // alert(numMembershipArray);
    
   location.href = 'launchTrainingSalesForm.php?number_memberships='+numMembershipArray+'&service_name='+serviceNameArray+'&service_quantity='+yearValueArray+'&service_cost='+totSaleArray+'&ajax_switch='+ajaxSwitch; 
    
/*    $.ajax ({
                 type: "POST",
                 url: "launchSalesForm.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {number_memberships: numMembershipArray, service_name: serviceNameArray, service_quantity: yearValueArray, service_cost: totSaleArray, ajax_switch: ajaxSwitch},              
                 success: function(data) {    
                //alert(data)
                         
                    if(data == 1) {
                           alert('Account login successfully created.');
                          window.location.assign("memberLoginPage.php?member=1")
                                 
                       }else{  
                       alert('Account login creation failed!')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;*/      

          

});
//--------------------------------------------------------------------------------------



 });
 //===============================================================================================================

