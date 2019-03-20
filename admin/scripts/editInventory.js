$(document).ready(function(){
//--------------------------------------------------------------------------------------
$(":submit").live('click', function() {

var subBut = $(this).attr('id');

if(subBut != 'delete') {

var posCat = ('#pos_category'+subBut);
var barCode = ('#bar_code'+subBut);
var productDesc = ('#product_desc'+subBut);
var wholeCost = ('#whole_cost'+subBut);
var retailCost = ('#retail_cost'+subBut);
var quantity = ('#quantity'+subBut);
var editSwitch = ('#edit_switch'+subBut);
var originalCost = ('#original_cost'+subBut);

var dropCatValue = $(posCat).val();
var barCodeValue = $(barCode).val(); 
var productDescValue = $(productDesc).val();
var wholeCostValue = $(wholeCost).val();
var retailCostValue = $(retailCost).val();
var quantityValue = $(quantity).val();
var originalCostValue = $(originalCost).val();

      barCodeValue = $.trim(barCodeValue);
      productDescValue = $.trim(productDescValue);
      wholeCostValue = $.trim(wholeCostValue);
      retailCostValue = $.trim(retailCostValue);
      quantityValue = $.trim(quantityValue);


      if(barCodeValue == "") {
         alert('Please provide a \"Bar Code\"');
                $(barCode).focus();
                 return false;
        }
        
      if(isNaN(barCodeValue)) {
         alert('\"Bar Code\" value must be a number');
                $(barCode).focus();
                 return false;
        }                       

      if(productDescValue == "") {
         alert('Please provide a \"Product description\"');
                $(productDesc).focus();
                 return false;
        }

      if(wholeCostValue == "") {
         alert('Please provide the \"Cost\" value');
                $(wholeCost).focus();
                 return false;
        }       

      if(isNaN(wholeCostValue)) {
         alert('\"Cost\" field may only contain numbers');
                $(wholeCost).focus();
                 return false;
        }       

      if(retailCostValue == "") {
         alert('Please provide the \"Price\" value');
                $(retailCost).focus();
                 return false;
        }       

      if(isNaN(retailCostValue)) {
         alert('\"Price\" field may only contain numbers');
                $(retailCost).focus();
                 return false;
        }       
        

if(quantityValue != "") {
      if(isNaN(quantityValue)) {
         alert('\"Quantity\" field may only contain numbers');
                $(quantity).focus();
                 return false;
        }               
  }


if(originalCostValue != wholeCostValue) {
      var editSwitchValue = 'new';
        $(editSwitch).val(editSwitchValue);   
        
  }else{
      var editSwitchValue = 'update';
        $(editSwitch).val(editSwitchValue);
  }



}//end if not delete


});
//--------------------------------------------------------------------------------------------

   
});