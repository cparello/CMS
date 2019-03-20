$(document).ready(function() {
//-----------------------------------------------------------------------
$(window).load(function () {
  $("#upc_number").focus();
  });
//-----------------------------------------------------------------------
$('#form1').submit(function() {

var ajaxSwitch = 1;
var upcNumber = $("#upc_number").val(); 
      upcNumber = $.trim(upcNumber);
      
      if(upcNumber == "") {
        alert('Please supply a UPC number');
                $("#upc_number").focus();
                return false;
        }


      if(isNaN(upcNumber)) {
         alert('UPC value must be a number');
                $("#upc_number").val("");
                $("#upc_number").focus();
                 return false;
        }       

$.ajax ({
                 type: "POST",
                 url: "checkOutList.php",
                 cache: false,
                 dataType: 'html', 
                 data: {upc_number: upcNumber, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Invalid UPC Number or inventory is not  avalable');
                       }else{  
                       
                           var dataArray = data.split('|');
                           var dataRow = dataArray[0];
                           var itemPrice = dataArray[1];
                                 itemPrice = parseFloat(itemPrice);
                           var total = $("#total").text();
                                 total = parseFloat(total);
                          
                                 total = total + itemPrice;
                                 total = total.toFixed(2);
                                 $("#total").text(total);
                                                            
                         $('#contentWindow tr:last').after(dataRow);  
                      }
                                             
                     }//end function success
              }); //end ajax 


$("#upc_number").val("");
$("#upc_number").focus();


return false;

}); 
//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
$('#set_id').click(function() {

var ajaxSwitch = 1;
var idNumber = $("#id_number").val(); 
      idNumber = $.trim(idNumber);
var idType = $('input:radio[name=id_type]:checked').val();   
    idType = $.trim(idType);
//alert(idNumber);
//alert(idType);
    if(idType == "") {
        alert('Please select a ID type');
                $("#id_type").focus();
                return false;
        }  
     
      if(idNumber == "") {
        alert('Please supply a ID number');
                $("#id_number").focus();
                return false;
        }


      if(isNaN(idNumber)) {
         alert('ID value must be a number');
                $("#id_number").val("");
                $("#id_number").focus();
                 return false;
        }       
  
$.ajax ({
                 type: "POST",
                 url: "idLookUpChecker.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_number: idNumber, ajax_switch: ajaxSwitch, id_type: idType},               
                 success: function(data) { 
                   //alert(data); 
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var contractKey = dataArray[1];
                     var name = dataArray[2];
                  
                    if(successBit == 1) {
                       alert('Invalid ID Number');
                       $("#id_number").val("");
                       $("#id_number").focus();
                       }else{  
                        alert(name+' has been found.');
                       $("#contract_key").val(contractKey);
                      
                      }
                                             
                     }//end function success
              }); //end ajax 
}); 
//-----------------------------------------------------------------------
$('.removeIt').live("click", function(event) {

var itemTotal = $(this).parents('tr:first').find('td').eq(5).text();
      itemTotal = parseFloat(itemTotal);
var total = $("#total").text();     
      total = parseFloat(total);
      
      total = total - itemTotal;
      total = total.toFixed(2);
      $("#total").text(total);
                         
$(this).parents('tr').remove();
$("#upc_number").focus();


}); 
//-----------------------------------------------------------------------

});

