$(document).ready(function(){

//---------------------------------------------------------------------------------------
$('#refund_exchange').click(function() { 
   
       $("#masking").show(500);
       $("#refundWindow").show(500);
     
    
});   
//---------------------------------------------------------------------------------------
$('.close').click(function() { 

       $("#masking").hide(500);
       $("#refundWindow").hide(500);
        
 });
 //--------------------------------------------------------------------------------------
 $('.closeTwo').click(function() { 

       $("#masking").hide(500);
       $("#refundWindow").hide(500);
        
 });
 //---------------------------------------------------------------------------------------
 $('#form3').submit(function() {

var ajaxSwitch = 1;
var displayBool = $('#display_bool_two').val(); 
var invoiceNumber = $("#invoice_number").val(); 
      invoiceNumber = $.trim(invoiceNumber);
      
      if(invoiceNumber == "") {
        alert('Please supply an invoice number');
                $("#invoice_number").focus();
                return false;
        }


      if(isNaN(invoiceNumber)) {
         alert('Invoice value must be a number');
                $("#invoice_number").val("");
                $("#invoice_number").focus();
                 return false;
        }       

if(displayBool == "") {

$.ajax ({
                 type: "POST",
                 url: "refundList.php",
                 cache: false,
                 dataType: 'html', 
                 data: {invoice_number: invoiceNumber, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                 // alert(data);
                    if(data == 1) {
                       alert('Invalid Invoice Number or invoice is not  available');
                       }else if(data == 2) {  
                       alert('An exchange or refund has already been credited to this invoice');
                       }else{
                         $('#contentWindowTwo tr:last').after(data);  
                         $('#display_bool_two').val("1");  
                       }
                                             
                     }//end function success
              }); //end ajax 

}

$("#invoice_number").focus();


return false;

}); 
//---------------------------------------------------------------------------------------
$('.re').live("click", function(event) {

     var listType = $(this).val();
     var checkBoxVal = $('input[name="item[]"]:checked').length;
     var checkBoxes = $('input[name="item[]"]:checked');
     var checkBoxArray = "";
     var ajaxSwitch = 1;
     var returnReason = $("#return_reason").val();
     var  purchaseMarker = $('#purchase_marker').val();
    
     
           if(listType == 'Exchange Product(s)') {
              var typeListText = 'exchange';
              var typeListTextCaps = "EXCHANGE";
              var typeList = 'E';              
              }else{
              var typeListText = 'refund';
              var typeListTextCaps = "REFUND";
              var typeList = 'R';              
              }


           //check to see if form has allready been submitted for payemnt
           if(purchaseMarker != "") {
             alert('This transaction has already been processed');
             return false;
             }
            
      
      
           if(checkBoxVal == 0) {
              alert('Please select a check box(s) that cooresponds to a product or products you wish to '+typeListText);
                      return false;           
              }
              

           if(returnReason == "n" || returnReason == "") {
               alert('Please select a reason for this '+typeListText);
                     $("#return_reason").focus();
                       return false;              
               }
                            

                               
                var answer = confirm('This will create an ' +typeListTextCaps+ ' for the items selected.  Do you wish to continue?');
                      if (!answer) {
                        return false;
                        }   
                          

              $(checkBoxes).each(function(){
                 var checkBoxValue = this.value;
                       checkBoxArray += (checkBoxValue+'^');                                  
                 });


$.ajax ({
            type: "POST",
            url: "refundExchange.php",
            cache: false,
            dataType: 'html', 
            data: {item_array: checkBoxArray, type_list: typeList, return_reason: returnReason, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  
                  var dataArray = data.split("|");
                  var data = dataArray[1];
                  var purchaseMarkerValue = dataArray[0];
                
                 if(data == "1") {
                    alert(typeListTextCaps+ ' successfully recorded.'); 
                    
                           $('#purchase_marker').val(purchaseMarkerValue); 
                           
                           $("input[name='return_type']").each(function(i) {
                              $(this).attr('disabled', 'disabled');
                              });      
                           
                   }else{
                   alert(data);
                   }
                                            
                     }//end function success
              }); //end ajax 


return false;


});
//---------------------------------------------------------------------------------------
$('#form3 :checkbox').live("click", function(event) {

    var cBox = $(this);
    var cBoxValue = $(this).val();
    var cBoxlArray = cBoxValue.split("|");      
    var cBoxTotal = cBoxlArray[1];
          cBoxTotal = parseFloat(cBoxTotal);    
        
    var total = $("#totalTwo").text(); 
          total = parseFloat(total);
    
    
    if(cBox.is(':checked')) {
    
      total = total + cBoxTotal;
      total = total.toFixed(2);
      $("#totalTwo").text(total);
      
      }else{
      
      total = total - cBoxTotal;
      total = total.toFixed(2);
      $("#totalTwo").text(total);   
      
      }
            
});
//---------------------------------------------------------------------------------------
$('input[name=return_type]').change(function(){

    var returnType = this.value;
             
         if(returnType == 'E') {
            var buttonValueOne = 'Exchange Product(s)';
            var buttonValueTwo = 'Exchange Receipt';
            
               $("#return_reason").empty();
                 var optionOne ='<option value="n">Exchange Reason</option>';
                 var optionTwo ='<option value="D">Defective Product</option>';
                 var optionThree ='<option value="E">Equal Exchange</option>';

                 $("#return_reason").append(optionOne);            
                 $("#return_reason").append(optionTwo);   
                 $("#return_reason").append(optionThree);                    
            
           }else if(returnType == 'R') {
            var buttonValueOne = 'Refund Product(s)';
            var buttonValueTwo = 'Refund Receipt';
            
              $("#return_reason").empty();
                 var optionOne ='<option value="n">Return Reason</option>';
                 var optionTwo ='<option value="D">Defective Product</option>';
                 var optionThree ='<option value="O">Overstock Purchase</option>';

                 $("#return_reason").append(optionOne);            
                 $("#return_reason").append(optionTwo);   
                 $("#return_reason").append(optionThree);   
           }
          
     $("#process_type").val(buttonValueOne);
     $("#return_receipt").val(buttonValueTwo);
                                
          
});
//--------------------------------------------------------------------------------------
 });
 
 
 
 
 
 
 
 
 
 
 
 