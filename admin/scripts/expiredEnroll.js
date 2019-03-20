//--------------------------------------------------------------------------------------
function loadResults(dateRange, listType, termType)  {


window.location.href = "parseExpiredEnroll.php?list_type=" +listType+  "&date_range=" +dateRange+ "&term_type=" +termType;


}
//--------------------------------------------------------------------------------------
$(document).ready(function(){

//this handles the form submission for early renewals
$('#per').bind('click', function(event) { 


var ajaxSwitch = 1;
var listType  =  $('input:radio[name=er]:checked').val();
var dateRange = $('#er_range').val();
var termType = 'T';

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate an Expired/ Re-enrollment list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Expired/ Re-enrollment notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Expired/ Re-enrollment letters for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "loadExpiredCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, date_range: dateRange},               
                 success: function(data) {
                // alert(data);
                           if(data == 0) {                          
                              alert('There are currently no Expired/ Re-enrollment accounts to list');
                                      return false;
                             }else{
                             
                             var alertPrompt = (alertTxt+data);
                                                                                                                  
                                var r = confirm(alertPrompt+ ' accounts. Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(dateRange, listType, termType);
                                             }else{
                                             return false;
                                             }                                                                        
                                
                                                                                              
                             }
                             
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------





});  //end of ready function