$(document).ready(function(){
//--------------------------------------------------------------------------------------
$(":submit").live('click', function() {

var subBut = $(this).attr('id');
var dropCatValue = $("#pos_category").val();
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
}


$.ajax ({
                 type: "POST",
                 url: "checkInventory.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {sub_but: subBut, search_sql: searchSql, ajax_switch: ajaxSwitch},               
                 success: function(data) {    

                 if(data == 0) {
                   alert('There is currently no inventory that meets your search criterior.');
                           return false;
                    }
                                 
                                  
                 if(data != 0)  {
                    var answerTwo = confirm('There are currently inventory item(s) that match your query.  Do you wish to view these items, assign or reassign these to specific locations?');
                            
                        if(answerTwo) {      
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