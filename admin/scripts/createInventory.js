$(document).ready(function(){
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------   
 $("select").change(function(){
 
          var dropCatValue = this.value;
               if(dropCatValue != "") {
                  $('#pos_cat_new').attr('disabled', '');
                  }else{
                  $('#pos_cat_new').removeAttr('disabled', '');
                  }
});

$('#pos_cat_new').keyup(function() {

          var newCatValue = $("#pos_cat_new").val();
               if(newCatValue != "") {
                  $('#pos_category').attr('disabled', '');
                  }else{
                  $('#pos_category').removeAttr('disabled', '');
                  }
                  
});  
//--------------------------------------------------------------------------------------------
$('#form1').submit(function(event) {

var submitForm = false;
var newCatValue = $("#pos_cat_new").val();
var dropCatValue = $("#pos_category").val();
var barCodeValue = $("#bar_code").val();     
var productDesc = $("#product_desc").val();
var wholeCost = $("#whole_cost").val(); 
var retailCost = $("#retail_cost").val();
var salesTax = $("#sales_tax").val();
var inventory = $("#inventory").val();
var ajaxSwitch = 2;


if(newCatValue == "" && dropCatValue == "") {
   alert('Please choose or create a product category');
           return false;
  }


      if(barCodeValue == "") {
         alert('Please provide a \"Bar Code\"');
                $("#bar_code").focus();
                 return false;
        }
        
      if(isNaN(barCodeValue)) {
         alert('\"Bar Code\" value must be a number');
                $("#bar_code").focus();
                 return false;
        }       

      if(productDesc == "") {
         alert('Please provide a product description');
                $("#product_desc").focus();
                 return false;
        }       


      if(wholeCost == "") {
         alert('Please provide the \"Wholesale Cost\"');
                $("#whole_cost").focus();
                 return false;
        }       

      if(isNaN(wholeCost)) {
         alert('\"Wholesale Cost\" may only contain numbers');
                $("#whole_cost").focus();
                 return false;
        }       

      if(retailCost == "") {
         alert('Please provide the \"Retail Cost\"');
                $("#retail_cost").focus();
                 return false;
        }       

      if(isNaN(retailCost)) {
         alert('\"Retail Cost\" may only contain numbers');
                $("#retail_cost").focus();
                 return false;
        }       

      if(salesTax != "") {
            if(isNaN(salesTax)) {
               alert('\"Sales Tax\" may only contain numbers');
                $("#sales_tax").focus();
                 return false;
               }             
        }
     

        
      if(inventory == "") {
         alert('Please enter a value into the \"Inventory\" field');
                $("#inventory").focus();
                 return false;
        }       

      if(isNaN(inventory)) {
         alert('\"Inventory\" field may only contain numbers');
                $("#inventory").focus();
                 return false;
        }               


$.ajax ({
                 type: "POST",
                 url: "checkInventory.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {bar_code: barCodeValue, new_cat_val: newCatValue, ajax_switch: ajaxSwitch},               
                 success: function(data) {    

                 if(data == 1) {
                   alert('A bar code for this product already exists');
                           return false;
                    }
               
                 if(data == 2)  {
                   alert('The category you created already exists');
                           return false;                                                                                                                      
                     }                    
               
                 if(data == 3)  {
                   submitForm = true;
                   }                      
                               
                 }//end function success
           }); //end ajax 


  return submitForm;
          

        

});
//--------------------------------------------------------------------------------------------
$('.pullConf').focus(function(){
$('#conf').html("");
});
//--------------------------------------------------------------------------------------------





    
   
});