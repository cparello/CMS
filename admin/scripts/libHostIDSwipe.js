$(document).ready(function() {
//----------------------------------------------------------------
function parseIdInfo(idInfo) {

var idInfoArray = idInfo.split("|");
var first = idInfoArray[0];
var mid = idInfoArray[1];
var last = idInfoArray[2];
var state = idInfoArray[3];
var city = idInfoArray[4];
var street = idInfoArray[5];

$('#first_name_lib').val(first);
$('#middle_name_lib').val(mid);
$('#last_name_lib').val(last);
$('#street_address_lib').val(street);
$('#city_lib').val(city);
$('#state_lib').val(state);

}
//----------------------------------------------------------------
$('#libHost').change(function() {

var ajaxSwitch = 1;
var idInfo = $('#first_name_lib').val();

var str= idInfo.match(/%/);
//alert(str);
if (str == '%'){

    $.ajax ({
                type: "POST",
                url: "../helper_apps/idSwipe.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, id_array: idInfo},               
                     success: function(data) { 
                        parseIdInfo(data);
                                                                                    
                         }//end function success
                 }); //end ajax 


   }else{
   
      if(idInfo.match(/\;/g))  {
   
           var idNameTwo = $('#first_name_lib').val();       
           var idArray = idInfo.split(";");   
           var idNameTwo = idArray[0];
                $('#first_name_lib').val(idNameTwo);   
        }
 }      
              
}); 
//--------------------------------------------------------------
}); 


