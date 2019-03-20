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
$('.button9').click(function() {

    var dataArray = $(this).val();
    dataArray = dataArray.split('|');
    var prodDesc = dataArray[0];
    var invMarker = dataArray[1];  
    var cost = dataArray[2];  
    var taxRate = dataArray[3];  
    var barcode = dataArray[4];  
    var cat = dataArray[5];  
     
  var total = $("#total").text();
  total = parseFloat(total);
  cost = parseFloat(cost);
  taxRate = parseFloat(taxRate);
  total = total + cost +(cost * (taxRate/100));
  total = total.toFixed(2);
  $("#total").text(total);
  
  cost = cost.toFixed(2);
  
  var dataRow = "<tr class=\"item\"><td class=\"black\">1</td><td class=\"black\">"+barcode+"</td><td class=\"black\">"+prodDesc+"</td><td class=\"black\">"+cat+"</td><td class=\"black\">"+cost+"</td><td class=\"black\">"+cost+"</td><td align=\"right\"><input type=\"button\" name=\"delete\" value=\"Remove\" class=\"removeIt\"></td></tr>"
                                                            
  $('#contentWindow tr:last').after(dataRow);  



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

