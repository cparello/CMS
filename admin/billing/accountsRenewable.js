//--------------------------------------------------------------------------------------
function loadResults(searchType, listType, amendNotice, dateVal)  {

amendNotice = encodeURI(amendNotice);

switch(searchType) {
case 'early':
window.location.href = "parseEarly.php?list_type=" +listType+  "&date_start=" +dateVal+ "&amend=" +amendNotice;
  break;
case 'grace':
 window.location.href = "parseGrace.php?list_type=" +listType+  "&date_end=" +dateVal+ "&amend=" +amendNotice;
  break;
case 'standard':
 window.location.href = "parseStandard.php?list_type=" +listType+  "&date_start=" +dateVal+ "&amend=" +amendNotice;
  break;  
  }


}
//--------------------------------------------------------------------------------------
$(document).ready(function(){

//this handles the form submission for early renewals
$('#early').bind('click', function(event) { 

var searchType = 'early';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=er]:checked').val();
var earlyDate = $('#early_date').val();

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate an Early Renewal list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Early Renewal notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Early Renewal letters for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "earlyRenewalCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, date_start: earlyDate, list_type: listType},               
                 success: function(data) {
                 //alert(data);
                           if(data == 0) {                          
                              alert('There are currently no Early Renewal accounts to list');
                                      return false;
                             }else{
                             
                             var alertPrompt = (alertTxt+data);
                                                                                                                  
                                var r = confirm(alertPrompt+ '  Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(searchType, listType, amendNotice, earlyDate);
                                             }else{
                                             return false;
                                             }                                                                        
                                
                                                                                              
                             }
                             
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------
//this handles the form submission for grace period
$('#grace').bind('click', function(event) { 

var searchType = 'grace';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=gp]:checked').val();
var graceDate = $('#grace_date').val();

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate a Grace Period list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Grace Period notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Grace Period invoices for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "gracePeriodCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, date_end: graceDate, list_type: listType},               
                 success: function(data) {
                           if(data == 0) {                          
                              alert('There are currently no Grace Period accounts to list');
                                      return false;
                             }else{
                             var alertPrompt = (alertTxt+data);
                                                                                         
                                var r = confirm(alertPrompt+ ' Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(searchType, listType, amendNotice, graceDate);
                                             }else{
                                             return false;
                                             }                                                                        
                                                              
                             }
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------
//this handles the form submission for standard renewals
$('#standard').bind('click', function(event) { 

var searchType = 'standard';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=sr]:checked').val();
var standardDate = $('#standard_date').val();

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate a Standard Renewal list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Standard Renewal notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Standard Renewal invoices for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "renewalCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, date_start: standardDate,  list_type: listType},               
                 success: function(data) {
                 //alert(data);
                           if(data == 0) {                          
                              alert('There are currently no Standard Renewal accounts to list');
                                      return false;
                             }else{
                             var alertPrompt = (alertTxt+data);
                                                           
                                var r = confirm(alertPrompt+ ' Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(searchType, listType, amendNotice, standardDate);
                                             }else{
                                             return false;
                                             }                                                                        
                                             
                                                                
                             }
                     }//end function success
              }); //end ajax
});
//-------------------------------------------------------------------------------------------------------------------------




});  //end of ready function