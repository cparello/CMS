$(document).ready(function() {
//-----------------------------------------------------------------------
$('#create2').click(function() {


var  ajaxSwitch = 1;

$.ajax ({
                 type: "POST",
                 url: "createHtmlContract.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Contract File successfully created');
                       }else{                         
                       alert('There was an error creating this PIF Contract file ' +data);
                       }
                                             
                     }//end function success
              }); //end ajax 




return false;

}); 
//-----------------------------------------------------------------------
$('#create1').click(function() {


var  ajaxSwitch = 2;

$.ajax ({
                 type: "POST",
                 url: "createHtmlContract.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Contract File successfully created');
                       }else{                         
                       alert('There was an error creating this EFT Contract file ' +data);
                       }
                                             
                     }//end function success
              }); //end ajax 




return false;

}); 
//-----------------------------------------------------------------------
$('#download1').click(function() {

var ajaxSwitch = 1;
//alert();
$.ajax ({
                 type: "POST",
                 url: "contractHtmlFileExist.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       location.href = "../offlineContracts/downloadEFT.php";
                       }else{                         
                        alert('This contract file does not currently exist.');
                       }
                                             
                     }//end function success
              }); //end ajax 



return false;

}); 
//-----------------------------------------------------------------------
$('#download2').click(function() {

var ajaxSwitch = 2;

$.ajax ({
                 type: "POST",
                 url: "contractHtmlFileExist.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       location.href = "../offlineContracts/downloadPIF.php";
                       }else{                         
                        alert('This contract file does not currently exist.');
                       }
                                             
                     }//end function success
              }); //end ajax 



return false;

}); 
//-----------------------------------------------------------------------
});

