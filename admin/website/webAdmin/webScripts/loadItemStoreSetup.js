$(document).ready(function(){

$('#load').click(function() {
$("#marker").val(0);
 var marker = 0;
 var itemId = $("#itemId").val();
 //alert(itemId);
location.href = 'editStoreProductsInfoPage.php?itemId='+itemId+'&marker='+marker+''; 
    

          

});
//--------------------------------------------------------------------------------------



 });
 //===============================================================================================================

