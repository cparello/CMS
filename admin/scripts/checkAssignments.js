$(document).ready(function(){
//--------------------------------------------------------------------------------------
  $('.listBar').click(function () {
  
     var listType = $(this).attr('id');
     var checkBoxVal = $('input[name="productMarker[]"]:checked').length;
     var checkBoxes = $('input[name="productMarker[]"]:checked');
     var checkBoxArray = "";
     var fromWhere = 'W';
       
           if(listType == 'printList') {
              var typeListText = 'your inventory';
              var typeList = 'I';              
              }else{
              var typeListText = 'your bar codes';
              var typeList = 'B';              
              }
       
       
           if(checkBoxVal == 0) {
              alert('Please select a check box(s) that cooresponds to a product or products in order to print '+typeListText);
                      return false;           
              }else{
              
              $(checkBoxes).each(function(){
                 var checkBoxValue = this.value;
                       checkBoxArray += (checkBoxValue+'|');                                  
                 });
                
                     $.ajax ({
                        type: "POST",
                        url: "setListOptions.php",
                        cache: false,
                        async: false,
                        dataType: 'html', 
                        data: {check_box_array: checkBoxArray, type_list: typeList, from_where: fromWhere},               
                        success: function(data) {    

                          if(data == 1) {                            window.open('inventoryWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
                            }else{
                            alert(data);
                            }
                          
                                              
                          }//end function success
                       }); //end ajax 
                            
              }
              
   });
//--------------------------------------------------------------------------------------
$('.listBarTwo').click(function () {

       var listId = $(this).attr('id');
       var listIdArray = listId.split("_")
       var listType = listIdArray[0];
       var fromWhere = listIdArray[1];
       var checkBoxArray = "";

       var productMarkerName = ('productMarker'+fromWhere+'[]');
       var checkBoxVal = $('\'input[name="productMarker' +fromWhere+ '[]"]:checked\'').length;
       var checkBoxes =  $('\'input[name="productMarker' +fromWhere+ '[]"]:checked\'');
      
           if(listType == 'printList') {
              var typeListText = 'your inventory';
              var typeList = 'I';              
              }else{
              var typeListText = 'your bar codes';
              var typeList = 'B';              
              }         
              
              
           if(checkBoxVal == 0) {
              alert('Please select a check box(s) that cooresponds to a product or products in order to print '+typeListText);
                      return false;           
              }else{
              
              $(checkBoxes).each(function(){
                 var checkBoxValue = this.value;
                       checkBoxArray += (checkBoxValue+'|');                                  
                 });
                
                
                     $.ajax ({
                        type: "POST",
                        url: "setListOptions.php",
                        cache: false,
                        async: false,
                        dataType: 'html', 
                        data: {check_box_array: checkBoxArray, type_list: typeList, from_where: fromWhere},               
                        success: function(data) {    

                          if(data == 1) {                            window.open('inventoryWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
                            }else{
                            alert(data);
                            }
                          
                                              
                          }//end function success
                       }); //end ajax 
                            
              }         
              
});
//--------------------------------------------------------------------------------------
$(":submit").click(function() {

var subBut = $(this).attr('id');
var subButId = ('#'+subBut);

var formName = $(subButId).get(0).form.id;
var assignNameGeneral = subBut.replace(/\d+/g, '');
var salt = subBut.replace(/\D+/g, '');


if(formName == 'form1' && assignNameGeneral == 'assign') {

   var inventoryId = ('#inventory'+salt);
   var serviceLocationId = ('#service_location'+salt);
   var quantityId = ('#quantity'+salt);
   var productMarkerId = ('#productMarker'+salt);
   
   var inventoryValue = $(inventoryId).html();
   var dropClubValue = $(serviceLocationId).val();
   var quantityValue = $(quantityId).val();
         quantityValue = $.trim(quantityValue);
   var productMarkerIdValue = $(productMarkerId).val();

      if(dropClubValue == "") {
         alert('Please choose a \"Location\" to assign this inventory');
                $(serviceLocationId).focus();
                 return false;
        }

      if(quantityValue == "") {
         alert('Please provide a \"Quantity\" to assign to a location');
                $(quantityId).focus();
                 return false;
        }     

      if(isNaN(quantityValue)) {
         alert('\"Quantity\" field may only contain numbers');
                $(quantityId).focus();
                 return false;
        }               

       inventoryValue = parseInt(inventoryValue);
       quantityValue = parseInt(quantityValue);

       if(quantityValue > inventoryValue) {
         alert('\"Quantity\" is greater than the number of inventory items');
                $(quantityId).focus();
                 return false;       
         }


      $('#inventory_marker').val(productMarkerIdValue);
      $('#salt').val(salt);
     

}else{

var submitForm = true;

$('.question_form').each( function(){

  
     var formName = this.name;
     var inventoryName = ('inventory'+salt);
     var serviceLocationName = ('service_location'+salt);
     var quantityName = ('quantity'+salt);
     var productMarkerName = ('product_marker'+salt);
     var fromWhereName = ('from_where'+salt);
     var retailCostName = ('retail_cost'+salt);
     var salesTaxName = ('sales_tax'+salt);
     
     
     var dropClubValue = document.forms[formName][serviceLocationName].value;
     var inventoryValue = document.forms[formName][inventoryName].value;
     var quantityValue = document.forms[formName][quantityName].value;
           quantityValue = $.trim(quantityValue);
     var productMarkerValue = document.forms[formName][productMarkerName].value;
     var fromWhereValue = document.forms[formName][fromWhereName].value;
     var retailCostValue = document.forms[formName][retailCostName].value;
     var salesTaxValue = document.forms[formName][salesTaxName].value;

    
          if(quantityValue == "" && fromWhereValue != dropClubValue) {                              
             alert('Please provide a \"Quantity\" to assign to a location');
                  document.forms[formName][quantityName].focus();
                   submitForm = false;                                    
             }     
     
     
           if(quantityValue != "" && fromWhereValue != dropClubValue) {
               if(isNaN(quantityValue)) {
                 alert('\"Quantity\" field may only contain numbers');
                  document.forms[formName][quantityName].focus();
                  submitForm = false;
                 }                           
                   
                 inventoryValue = parseInt(inventoryValue);
                 quantityValue = parseInt(quantityValue);

               if(quantityValue > inventoryValue) {
                alert('\"Quantity\" is greater than the number of inventory items');
                 document.forms[formName][quantityName].focus();
                 submitForm = false;       
                }                  
            }
     
     
               if(isNaN(retailCostValue)) {
                 alert('\"Price\" field may only contain numbers');
                  document.forms[formName][retailCostName].focus();
                  submitForm = false;
                 } 
                 
               if(isNaN(salesTaxValue)) {
                 alert('\"Tax\" field may only contain numbers');
                  document.forms[formName][salesTaxName].focus();
                  submitForm = false;
                 }                             
              
                    document.forms[formName]['inventory_marker'].value = productMarkerValue;
                    document.forms[formName]['salt'].value = salt;

                    
     
  });

return submitForm;

}

});
//--------------------------------------------------------------------------------------------

   
});
//--------------------------------------------------------------------------------------------
