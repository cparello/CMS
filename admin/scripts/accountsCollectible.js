//--------------------------------------------------------------------------------------
function loadResults(searchType, listType, amendNotice, pastMonth, pastYear)  {

amendNotice = encodeURI(amendNotice);

switch(searchType) {
case 'past':
    alert('list '+listType+' amend '+amendNotice+' pastM '+pastMonth+' Pasty '+pastYear);
window.location.href = "parsePastDue.php?list_type=" +listType+ "&amend=" +amendNotice+ "&pastMonth=" +pastMonth+ "&pastYear=" +pastYear;
  break;
case 'declined':
 window.location.href = "parseDeclinedRejections.php?list_type=" +listType+ "&amend=" +amendNotice;
  break;
case 'monthly':
 window.location.href = "parseMonthlyStatements.php?list_type=" +listType+ "&amend=" +amendNotice;
  break;  
  }


}
//--------------------------------------------------------------------------------------
$(document).ready(function(){

//this handles the form submission for past due
$('#past').bind('click', function(event) { 

  $(this).prop("disabled",true);
  $(this).attr("class", "button2");


var searchType = 'past';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=pd]:checked').val();
var pastMonth  =  $('#past_month').val();
var pastYear  =  $('#past_year').val();
//alert(listType);
switch(listType) {
case 'phone':
  var alertTxt = 'This will generate a Past Due list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'WARNING: This will instantly send out emails.  This will email Past Due notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Past Due invoices for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "pastDueCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, pastMonth: pastMonth, pastYear: pastYear},               
                 success: function(data) {
                           if(data == 0) {   
                             $('#past').prop("disabled",false);
                             $('#past').attr("class", "button1");
                              alert('There are currently no Past Due accounts to list');
                                      return false;
                             }else{
                             
                             var alertPrompt = (alertTxt+data);
                             
                             if(listType != 'mail') {                                                             
                                var r = confirm(alertPrompt+ ' accounts. Do you wish to continue? ');                                
                                           if(r == true) {
                                             loadResults(searchType, listType, amendNotice, pastMonth, pastYear);
                                             }else{
                                             $('#past').prop("disabled",false);
                                             $('#past').attr("class", "button1");                                             
                                             return false;
                                             }                                                                        
                                }
                                
                             if(listType == 'mail') {     
                                $('#past').prop("disabled",false);
                                $('#past').attr("class", "button1"); 
                                var amendNotice = 'Save';                           
                               // var amendNotice = prompt(alertPrompt+ ' accounts.\n If you wish to optionally save these notices as sent\n to the accounts listed above, please type \"Save\"\n in the field below.  Leave this field blank if you do not\n wish save these notices as sent');
                                          // if(amendNotice != null) {
                                              loadResults(searchType, listType, amendNotice, pastMonth, pastYear);
                                          //   }else{
                                         //    return false;
                                          //   }                                         
                                }     
                                                                    
                             }
                     }//end function success
              }); //end ajax
});
//=======================================================================================
$('#reset').bind('click', function(event) { 

var ajaxSwitch = 1;

 var test = confirm('This will reset the attempt number for the invoices to the FIRST ATTEMPT. Are you sure?');
 if(test != true) {
    return false;
 }

  $.ajax ({
                 type: "POST",
                 url: "resetInvoiceNumber.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {
                    if (data == 1){
                        alert('The invoice notice number has been reset to the FIRST ATTEMPT.')
                    }
                         
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------
//this handles the form submission for declined or rejected
$('#declined').bind('click', function(event) { 

  $(this).prop("disabled",true);
  $(this).attr("class", "button2");

var searchType = 'declined';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=dr]:checked').val();

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate a Declined/Rejected list of ';
  var amendNotice = "";
  break;
case 'email':
  var alertTxt = 'This will email Declined/Rejected notices to ';
  var amendNotice = "";
  break;
case 'mail':
  var alertTxt = 'This will generate Declined/Rejected invoices for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "declinedCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {
                           if(data == 0) {  
                              $('#declined').prop("disabled",false);
                              $('#declined').attr("class", "button1");                             
                              alert('There are currently no Declined accounts to list');
                                      return false;
                             }else{
                             var alertPrompt = (alertTxt+data);
                             
                             if(listType != 'mail') {                                                             
                                var r = confirm(alertPrompt+ ' accounts. Do you wish to continue?');                                
                                           if(r == true) {
                                             loadResults(searchType, listType, amendNotice);
                                             }else{
                                              $('#declined').prop("disabled",false);
                                              $('#declined').attr("class", "button1");                                               
                                             return false;
                                             }                                                                        
                                }
                                
                             if(listType == 'mail') {
                                $('#declined').prop("disabled",false);
                                $('#declined').attr("class", "button1");                               
                                var amendNotice = prompt(alertPrompt+ ' accounts.\n If you wish to optionally save these notices as sent\n to the accounts listed above, please type \"Save\"\n in the field below.  Leave this field blank if you do not\n wish save these notices as sent');
                                           if(amendNotice != null) {
                                              loadResults(searchType, listType, amendNotice);
                                             }else{
                                             return false;
                                             }                                         
                                }                                   
                             }
                     }//end function success
              }); //end ajax
});
//--------------------------------------------------------------------------------------
//this handles the form submission for monthly invoices for checks or cash
$('#monthly').bind('click', function(event) { 

  $(this).prop("disabled",true);
  $(this).attr("class", "button2");

var searchType = 'monthly';
var ajaxSwitch = 1;
var listType  =  $('input:radio[name=mi]:checked').val();

switch(listType) {
case 'phone':
  var alertTxt = 'This will generate a list of ';
  break;
case 'email':
  var alertTxt = 'This will email notices to ';
  break;
case 'mail':
  var alertTxt = 'This will generate invoices for ';
  break;  
  }

  $.ajax ({
                 type: "POST",
                 url: "monthlyStatementCount.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {
                           if(data == 0) {
                               $('#monthly').prop("disabled",false);
                               $('#monthly').attr("class", "button1");                             
                              alert('There are currently no Monthly accounts to list');
                                      return false;
                             }else{
                                var alertPrompt = (alertTxt+data);                             
                                var r = confirm(alertPrompt+ ' Monthly \"Manual\" accounts. Do you wish to continue?');
                                          if(r == true) {
                                             loadResults(searchType, listType);
                                             }else{
                                              $('#monthly').prop("disabled",false);
                                              $('#monthly').attr("class", "button1");                                               
                                             return false;
                                             }                                                                    
                             }
                     }//end function success
              }); //end ajax
});
//-------------------------------------------------------------------------------------------------------------------------




});  //end of ready function