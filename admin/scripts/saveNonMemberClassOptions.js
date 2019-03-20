$(document).ready(function() {
//--------------------------------------------------------------------
$("#set_prices").click( function() {

var quan1 = $("#quan1").val();
var quan2 = $("#quan2").val();
var quan3 = $("#quan3").val();
var quan4 = $("#quan4").val();

var price1 = $("#price1").val();
var price2 = $("#price2").val();
var price3 = $("#price3").val();
var price4 = $("#price4").val();
//alert(price2);
var ajaxSwitch = "1";

        $.ajax ({
                type: "POST",
                url: "nonMemberClassOptions.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, quan1: quan1, quan2: quan2, quan3: quan3, quan4: quan4 , price1: price1, price2: price2, price3: price3, price4: price4},               
                     success: function(data) { 
                          //alert(data);
                           if(data == "1") {
                           alert('Non Member Classes successfully updated');
                            }else{
                            alert(data);
                            }
                                                 
                         }//end function success
                 }); //end ajax 

});
//===========================================
});