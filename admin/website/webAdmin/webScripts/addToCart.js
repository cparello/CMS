$(document).ready(function(){
//--------------------------------------------------------------------------------------
$('#add').click(function() {
 
var ajaxSwitch = 1;
var productArray = $("#product_array").val();
alert(productArray);
 
$.ajax ({
                type: "POST",
                url: "addToCart.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, productArray: productArray},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var cartCount = dataArray[1];

                     
                          if(successBit == 1) {                             
                             $("#numCartItems").html(cartCount);
                             alert('Added to cart!');
                            }else{
                            alert('There was an error adding this item to your cart please try again later!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
 
 
 
 //var catId = this.value;
 
 //location.href = 'storePage.php?cat_id='+catId+''; 
});
//====================================================================
$('#back').click(function() {
 
var cat = $("#current_cat").val();
 location.href = 'storePage.php?cat_id='+cat+''; 
});
//====================================================================

$('#checkOut').click(function() {
 location.href = 'cartPage.php'; 
});
//====================================================================

 });
 //===============================================================================================================

