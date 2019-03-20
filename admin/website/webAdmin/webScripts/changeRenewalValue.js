$(document).ready(function(){
    //alert('fu');
   var contractKey = $("#contractKey").val();
   if (contractKey == ""){
     alert("You must be logged in to use this page! You will be redirected to the home screen. Please click Member Sign-In then proceed.");
     location.href = 'webIndex.php';
     return false;
   }
   var selectedServiceQuanntity = $("#selectedQuantity").val();
   
   /*var serviceQuantity = $("#service_quantity").val();
   if (serviceQuantity == 1){
    var yearSelected = 0;
   }else if (serviceQuantity == 2){
    var yearSelected = 1;
   }else if (serviceQuantity == 3){
    var yearSelected = 2;
   }*/
   //alert(serviceQuantity+' '+yearSelected);
$('input:radio[name=yearOptions1]:nth('+selectedServiceQuanntity+')').attr('checked',true);
});
//===================================================================================================

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
        var starDate = $("#start_date").val();
        var discount = $("#discount").val();
        
        //alert('fubar'+serviceName+yearValue1);
        
        $.ajax ({
                type: "POST",
                url: "loadRenewalPricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue1, starDate: starDate, discount: discount},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     var termText = dataArray[3];
                     var endDate = dataArray[4];
                     var newDiscount = dataArray[5];
                     
                          if(successBit == 1) {                             
                             $("#cost1").html('$'+price);
                             $("#total1").html('$'+totPrice);     
                             $("#pifYears1").html(yearValue1+' '+termText+'');
                             $("#newEndDate").html(endDate);
                             $("#discountText").html(newDiscount);
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
    
var serviceName1 = $("#membership1").html();
 var servName = serviceName1.split('&');
var locationArr = servName[2].split(';');
serviceName1 = ""+servName[0]+"-"+locationArr[1];
serviceName1 = serviceName1.replace("<span id=\"membership1\">", "");
serviceName1 = serviceName1.replace("</span>", "");

var yearValue1 = $('input:radio[name=yearOptions1]:checked').val();  
var totalSale1 = $("#total1").html();
totalSale1 = totalSale1.replace("<span id=\"total1\">", "");
totalSale1 = totalSale1.replace("</span>", "");  
totalSale1 = totalSale1.replace("$", "");

//alert(locationArr[1]);
//alert(serviceName1);
/*if(serviceName1 != null){
   
var numberMemberships1 = $("input[name=quantity1]").val();



if (yearValue1 == undefined){
    var yearValue1 = $("#pifYears1").html();
    yearValue1 = yearValue1.replace("<span id=\"pifYears1\">", "");
    yearValue1 = yearValue1.replace("</span>", "");  
}
}
    
*/

var ajaxSwitch = 1;
var serviceName  = serviceName1;
var yearValue  = yearValue1;
var totSale  = totalSale1;
 //alert(numMembershipArray);
location.href = 'launchRenewalSalesForm.php?service_name='+serviceName+'&service_quantity='+yearValue+'&service_cost='+totSale+'&ajax_switch='+ajaxSwitch; 

          

});
//--------------------------------------------------------------------------------------



 });
 //===============================================================================================================

