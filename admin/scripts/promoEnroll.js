//--------------------------------------------------------------------------------------
function loadResults(dateRangeStart, dateRangeEnd, listType, termType)  {

window.location.href = "parsePromoEnroll.php?list_type=" +listType+  "&date_range_start=" +dateRangeStart+ "&date_range_end=" +dateRangeEnd+ "&term_type=" +termType;

}
//--------------------------------------------------------------------------------------
$(document).ready(function(){

//this handles the form submission for early renewals
$('#per').bind('click', function(event) { 


var ajaxSwitch = 1;
var listType  =  $('input:radio[name=er]:checked').val();
var dateRangeStart = $('#er_range').val();
var dateRangeEnd = $('#rn_range').val();
var termType = 'T';

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate an Promo list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Promo notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Promo letters for ';
  break;  
case 'sms':
  var alertTxt = 'This will send SMS Promo notices to ';
  var amendNotice = "";
  break;
  }

  $.ajax ({
                 type: "POST",
                 url: "loadPromoCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, date_range_start: dateRangeStart, date_range_end: dateRangeEnd},               
                 success: function(data) {
                // alert(data);
                           if(data == 0) {                          
                              alert('There are currently no Promo accounts to list');
                                      return false;
                             }else{
                             
                             var alertPrompt = (alertTxt+data);
                                                                                                                  
                                var r = confirm(alertPrompt+ ' accounts. Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(dateRangeStart, dateRangeEnd, listType, termType);
                                             }else{
                                             return false;
                                             }                                                                        
                                
                                                                                              
                             }
                             
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------





});  //end of ready function