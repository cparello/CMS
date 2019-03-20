$(document).ready(function() {
//----------------------------------------------------------------
function parseIdInfo(idInfo) {

var idInfoArray = idInfo.split("|");
var first = idInfoArray[0];
var mid = idInfoArray[1];
var last = idInfoArray[2];
var state = idInfoArray[3];
var city = idInfoArray[4];
var $nameArray = idInfoArray[5];

$('#first_name1').val(first);
$('#middle_name1').val(mid);
$('#last_name1').val(last);
$('#street_address1').val($nameArray);
$('#city1').val(city);
$('#state1').val(state);

}
//----------------------------------------------------------------
$('#userForm1').change(function() {

var ajaxSwitch = 1;
var idInfo = $('#first_name1').val();
//alert(idInfo);



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
                        //alert(data);
                        parseIdInfo(data);
                                                                                    
                         }//end function success
                 }); //end ajax 


   }else{
   
      if(idInfo.match(/\;/g))  {
   
           var idNameTwo = $('#first_name1').val();       
           var idArray = idInfo.split(";");   
           var idNameTwo = idArray[0];
                $('#first_name1').val(idNameTwo);   
        }
 }     
              
}); 
//--------------------------------------------------------------
}); 


