$(document).ready(function(){
//--------------------------------------------------------------------------------------
$(":submit").live('click', function() {

var subBut = $(this).attr('id');
var dropCatValue = $("#category_id").val();
var dropStatValue = $("#status_id").val();
var barCodeValue = $("#bar_code").val();     
var productDesc = $("#product_desc").val();
var ajaxSwitch = 1;

switch(subBut) {
case "bar":

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
       var searchSql = barCodeValue;   
        
  break;
case "desc":

      if(productDesc == "") {
         alert('Please provide a product description');
                $("#product_desc").focus();
                 return false;
        }
        var searchSql = productDesc;
        
  break;
case "cat":

      if(dropCatValue == "") {
         alert('Please select product category');
               return false;
        }
        var searchSql = dropCatValue;
        
  break;
case "stat":

      if(dropStatValue == "") {
         alert('Please select order status');
               return false;
        }
        var searchSql = dropStatValue;
        
  break;
}


$.ajax ({
                 type: "POST",
                 url: "checkOrders.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {sub_but: subBut, search_sql: searchSql, ajax_switch: ajaxSwitch},               
                 success: function(data) {    

                 if(data == 0) {
                   alert('There is currently no order that meets your search criterior');
                           return false;
                    }
               
                 if(data != 0)  {
                    var answer = confirm('There are currently ' +data+ ' order(s) that match your query. Do you wish to view these orders?');
                            
                        if(answer) {      
                           $("#search_type").val(subBut);
                           $('#form1').submit();            
                           }else{       
                                return false;    
                           }                                                                                                                                            
                     }                    
               
               
                               
                 }//end function success
           }); //end ajax 


return false;



         

});
//--------------------------------------------------------------------------------------------





    
   
});