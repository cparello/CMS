$(document).ready(function() {
//-----------------------------------------------------------------------
$(window).load(function () {
  $("#upc_number").focus();
  });
//-----------------------------------------------------------------------
$('#set_list').click(function() {


var upcNumber = $("#upc_number").val(); 
      upcNumber = $.trim(upcNumber);
      
      //alert($('input:radio[name=search_type]:checked').val());
      
      if($('input:radio[name=search_type]:checked').val() == 1){
        var ajaxSwitch = 1;
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
      }else if($('input:radio[name=search_type]:checked').val() == 2){
        var ajaxSwitch = 2;
        
      }
      
      

$.ajax ({
                 type: "POST",
                 url: "checkOutList.php",
                 cache: false,
                 dataType: 'html', 
                 data: {upc_number: upcNumber, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                  var dataArray = data.split('@');
                  var test = dataArray[0];
                  var theRest = dataArray[1];
                  
                  
                    if(test == 1) {
                       alert('Invalid UPC Number or inventory is not  avalable');
                       }else if(test == 3){  
                       
                           var dataArray2 = theRest.split('|');
                           var dataRow = dataArray2[0];
                           var itemPrice = dataArray2[1];
                                 itemPrice = parseFloat(itemPrice);
                           var total = $("#total").text();
                                 total = parseFloat(total);
                          
                                 total = total + itemPrice;
                                 total = total.toFixed(2);
                                 $("#total").text(total);
                                                            
                         $('#contentWindow tr:last').after(dataRow);  
                      }else if(test == 2){  
                        alert('That product could not be found. Did you mean one of these? \n'+theRest);
                           
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
    
   // alert('testteast');
    var ajaxSwitch = 1;
    var dataArray = $(this).val();
    dataArray = dataArray.split('|');
    var prodDesc = dataArray[0];
    var invMarker = dataArray[1];  
   // var cost = dataArray[2];  
    //var taxRate = dataArray[3];  
    var barcode = dataArray[4];  
    var cat = dataArray[5];  
    
    $.ajax ({
                 type: "POST",
                 url: "quickAddPriceLookUp.php",
                 cache: false,
                 dataType: 'html', 
                 data: {barcode: barcode, ajax_switch: ajaxSwitch, iMarker: invMarker},               
                 success: function(data) {    
                  //alert(data);
                  var dataArray = data.split('|');
                  var cost = dataArray[0];
                  var taxRate = dataArray[1];
                  
                  if(cost != ""){
                      var total = $("#total").text();
                      total = parseFloat(total);
                      cost = parseFloat(cost);
                      taxRate = parseFloat(taxRate);
                      var subTot = cost +(cost * (taxRate));
                      total = total + subTot;
                      total = total.toFixed(2);
                      $("#total").text(total);
                      
                      cost = cost.toFixed(2);
                      
                      var dataRow = "<tr class=\"item\"><td class=\"black\">1</td><td class=\"black\">"+barcode+"</td><td class=\"black\">"+prodDesc+"</td><td class=\"black\">"+cat+"</td><td class=\"black\">"+cost+"</td><td class=\"black\">"+subTot+"</td><td align=\"right\"><input type=\"button\" name=\"delete\" value=\"Remove\" class=\"removeIt\"></td></tr>"
                                                                                
                      $('#contentWindow tr:last').after(dataRow);  
                   }else{
                    alert('Item not found in club inventory or is out of stock');
                   }
  
                                             
                     }//end function success
              }); //end ajax 
   
  



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
                       //alert('Invalid ID Number');
                       $("#id_number").val("");
                       $("#id_number").focus();
                       $("#radBox").html('Invalid ID Number');
                       }else if(successBit == 3) {  
                        //alert(name+' has been found.');
                        $("#cof_name").val(name);
                        $("#contract_key").val(contractKey);
                        $("#radBox").html(name+"<br> There is no Card on File.");
                      }else if(successBit == 2) {  
                       // alert(name+' has been found.');
                        $("#cof_name").val(name);
                        $("#contract_key").val(contractKey);
                        $("#radBox").html(name+"<br> Bill to Card on File? <br> <input name=\"cof\" value=\"1\" id=\"cof1\" idclass=\"option\" style=\"margin-left:5px;\" checked=\"checked\" type=\"radio\">No \n <input name=\"cof\" value=\"2\" id=\"cof2\" class=\"option\" style=\"margin-left:5px;\" type=\"radio\">Yes");
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
 var cofRad = $('#radBox');
    cofRad.on('change', function() {
        if($('input:radio[name=cof]:checked').val() == 2){
            $("#credit_pay").val("Bill to COF");
            $("#check_pay").val("Bill to COF");
            $("#cash_pay").val("Bill to COF");
            $("#credit_pay").attr("disabled", "disabled");
            $("#check_pay").attr("disabled", "disabled");
            $("#cash_pay").attr("disabled", "disabled");
            $("#check_number").attr("disabled", "disabled");
        }
        });
  //=====================================================================      //alert()
});

