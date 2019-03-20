$(document).ready(function() {
//-----------------------------------------------------------------
$("#service_location").change( function() {

var productNameDrop = "<option value>Select Product</option>";
     $("#product").html(productNameDrop);

});
//----------------------------------------------------------------
$("#retail_category").live("change", function(event) {

var clubId = $("#service_location").val();
var categoryType = $("option:selected", this).val();
var optionDrops = "";
var ajaxSwitch = 1;

  if(categoryType != "") {  
        
        $.ajax ({
                type: "POST",
                url: "retailProductDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, category_type: categoryType},               
                     success: function(data) { 
                     //alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#product").html(data);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------

});


