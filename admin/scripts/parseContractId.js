$(document).ready(function(){
$('#search_id').bind('keyup', function(event) { 

 var n = $("#search_id").val().length;
 var tv =  $("#search_id").val();
 var clientInfo;
 
//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          tv = tv.slice(0, -1); 
             $("#search_id").val(tv);          
               alert("Please do not use spaces in your query");
                       return false;        
        }
 

//checks to see if the input is a number
      if(isNaN($("#search_id").val())) {
          tv = tv.slice(0, -1); 
             $("#search_id").val(tv);          
               alert("The charachter you entered is not a number");
                       return false;
         }


//check the length to make sure it is greater or equal to four
if(n < 4) {  
     clientInfo = 'Client contact information';
  $("#contract_info").text(clientInfo); 
  }

//now we do an ajax call if the value you is four or greater
if(n >= 4) {  
      $.ajax ({
                 type: "POST",
                 url: "../helper_apps/contractInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: tv},               
                 success: function(data) {
                           if(data != 1) {
                              $('#contract_info').html(data);
                             }else{
                             data = 'No record is associated with this Id Number';
                             $('#contract_info').html(data);
                             }
                     }//end function success
              }); //end ajax
   } //end 4 or greater

});  //end keyup
//----------------------------------------------------------------------------------------------------
//this takes care of the check box that loads the monthly payment and locks the id number
$('#access').bind('click', function(event) { 

if($('INPUT[name=access]').is(':checked')) {

         var tv =  $("#search_id").val();
               tv = $.trim(tv);
         var ms = 1;
         
         if(tv == "")  {
            alert('Please enter a contract value  before locking this account');
                    return false;
           }
       
       $.ajax ({
                 type: "POST",
                 url: "../helper_apps/contractInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: tv, month_switch: ms},               
                 success: function(data) {    
                // alert(data);
                           if (data.indexOf('|') == -1) {                               
                               //document.getElementById('access').checked = false;
                               document.getElementById('monthly').disabled = true;
                               document.getElementById('initial').disabled = true;
                               alert('This account is past due $' +data+ '.  You will not be able to process any Monthly or Initial payments through this interface.  Please use the billing system to update this account');
                              }else{
                                var dataArray = data.split("|");
                                var monthPayment = dataArray[0];
                                var balanceDue = dataArray[1];
                                var lateFee = dataArray[2];
                                var payMount2 = dataArray[3];
                                var processDate = dataArray[4];
                                var cashPaymentOrig = dataArray[5];
                                var checkPaymentOrig = dataArray[6]; 
                                var todaysPaymentOrig = dataArray[7];
                                var signupDate = dataArray[8];
                                
                                //here we check to see the status of initial payments then disable the fields if the are NA
                                if(lateFee == "" || lateFee == 'NA') {
                                  $('#late_fee').attr("disabled", true);
                                  }
                                if(payMount2 == 'NA') {
                                  $('#payment_amount2').attr("disabled", true);
                                  $('#check_number2').attr("disabled", true);
                                  $('#initial').attr("disabled", true);
                                  } 
                                                                  
                               $("#late_fee").val(lateFee);                                
                               $("#balance_due").val(balanceDue);
                               $("#payment_amount2").val(payMount2); 
                               $("#monthly_payment").val(monthPayment);
                               $("#payment_amount").val(monthPayment);    
                               $("#process_date").val(processDate);
                               $("#signup_date").val(signupDate);
                               $("#cash_payment_orig").val(cashPaymentOrig);
                               $("#check_payment_orig").val(checkPaymentOrig);
                               $("#todays_payment_orig").val(todaysPaymentOrig);
                             }
                               
                               
                     }//end function success
              }); //end ajax 
 
     
     $('#search_id').attr("disabled", true);
     $("#monthly_payment").attr('readonly','readonly');
     $("#balance_due").attr('readonly','readonly');
                  
            
   }else{
     var noData = "";   
     $("#monthly_payment").val(noData);
     $("#payment_amount").val(noData); 
     $("#process_date").val(noData);
     $("#signup_date").val(noData);
     $("#cash_payment_orig").val(noData);
     $("#check_payment_orig").val(noData);
     $("#todays_payment_orig").val(noData);
     $('#search_id').attr("disabled", false);
     $("#late_fee").val(noData);
     $("#balance_due").val(noData); 
     $("#payment_amount2").val(noData);
     $('#late_fee').attr("disabled", false);
     $('#payment_amount2').attr("disabled", false);
     $('#check_number2').attr("disabled", false);
     $('#initial').attr("disabled", false);
   }

});
//------------------------------------------------------------------------------------------------
//this handles the radio buttons for monthly payment if cash or check
$("input[name='p_type']").click(function() {

   var cn = "";

    if($("INPUT[name='p_type']:checked").val() == 'cash')  {
         $("#check_number").val(cn);  
         $('#check_number').attr("disabled", true);
       }else{
         $('#check_number').attr("disabled", false);
       }
        
});
//------------------------------------------------------------------------------------------------
//this handles the form submission for monthly payments
$('#monthly').bind('click', function(event) { 

   var cn = $("#check_number").val();
         cn = $.trim(cn);
   var pa = $("#payment_amount").val();
         pa = $.trim(pa); 
   var tv =  $("#search_id").val();
         tv = $.trim(tv); 
   var ms = 2; 
   var clear = "";
   var contractInfo = 'Client contact information';
   var mp =  $("#monthly_payment").val();
         
     if($('INPUT[name=access]').is(':checked')) {
     
           if($("#monthly_payment").val() == 'NA') {
             alert('This is not a valid record to process.');
                     return false;
              }

           if(pa == "") {
             alert('Please enter a value into the payment amount field');
                    return false;
             }
             
//checks to see if the input is a number
var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
             if(!numberRegex.test(pa)) {
                    alert("The value you typed into the Payment Amount field is invalid");
                            return false;   
                }                       

           if($("INPUT[name='p_type']:checked").val() == 'check')  {             
            var pd = 'Monthly Dues Check';
            var pt = 'check';
            var transType = 'CH';
                 if(cn == "") {
                    alert('Please enter the check number before submitting this form');
                            return false;
                   }              
               }
                                             

           if($("INPUT[name='p_type']:checked").val() == 'cash')  { 
              var pd = 'Monthly Dues Cash';
              var pt = 'cash';
              var transType = 'CA';
                    cn = 0;
              }

           //here we set up the ajax submission
     $.ajax ({
                 type: "POST",
                 url: "../helper_apps/contractInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: tv, month_switch: ms, todays_payment: pa, payment_description: pd, check_number: cn, monthly_payment: mp, pay_type: pt, trans_type: transType},               
                 success: function(data) {                                                    
              
                                 alert('Monthly payment for contract \"' +tv+ '\" successfully processed');
                                         $('#search_id').val(clear);
                                         $('#search_id').attr("disabled", false);
                                         $('#contract_info').html(contractInfo);
                                         $('input[name=access]').attr('checked', false);
                                         $('#monthly_payment').val(clear);
                                         $('#payment_amount').val(clear);
                                         $('#check_number').val(clear);
                                         $('#check').prop('checked', true);
                                         $('#cash').prop('checked', false);  
                                         $('#check_number').attr("disabled", false);
                                         
                       
                     }//end function success
              }); //end ajax 


          }else{
          alert('Please check \"View Account\" before submitting this payment');
                  return false;          
          }

});
//-----------------------------------------------------------------------------------------------
//this handles non numeric values typed into the payment amount field
$('#payment_amount').bind('keyup', function(event) { 

 var n = $("#payment_amount").val().length;
 var tv =  $("#payment_amount").val();
 var clientInfo;
 
//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          tv = tv.slice(0, -1); 
             $("#payment_amount").val(tv);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

});
//-----------------------------------------------------------------------------------------------
//handles the check number field for monthly
$('#check_number').bind('keyup', function(event) { 

   var cn = $("#check_number").val();
         cn = $.trim(cn);

//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          cn = cn.slice(0, -1); 
             $("#check_number").val(cn);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

//checks to see if the input is a number
      if(isNaN($("#check_number").val())) {
          cn = cn.slice(0, -1); 
             $("#check_number").val(cn);          
               alert("The charachter you entered is not a number");
                       return false;
         }


});
//======================================================



//functions below handle the initial payments
//-----------------------------------------------------------------------------------------------
//this handles the radio buttons for initial payment if cash or check
$("input[name='p_type2']").click(function() {

   var cn = "";

    if($("INPUT[name='p_type2']:checked").val() == 'cash')  {
         $("#check_number2").val(cn);  
         $('#check_number2').attr("disabled", true);
       }else{
         $('#check_number2').attr("disabled", false);
       }
        
});

//----------------------------------------------------------------------------------------------
//handles the check number field for initial
$('#check_number2').bind('keyup', function(event) { 

   var cn = $("#check_number2").val();
         cn = $.trim(cn);

//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          cn = cn.slice(0, -1); 
             $("#check_number2").val(cn);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

//checks to see if the input is a number
      if(isNaN($("#check_number2").val())) {
          cn = cn.slice(0, -1); 
             $("#check_number2").val(cn);          
               alert("The charachter you entered is not a number");
                       return false;
         }


});
//----------------------------------------------------------------------------------------------
//this handles non numeric values typed into the payment amount field initial
$('#payment_amount2').bind('keyup', function(event) { 

 var n = $("#payment_amount2").val().length;
 var tv =  $("#payment_amount2").val();
 var clientInfo;
 
//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          tv = tv.slice(0, -1); 
             $("#payment_amount2").val(tv);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

});

//----------------------------------------------------------------------------------------------
//this handles the form submission for initial payments
$('#initial').bind('click', function(event) { 

   var cn = $("#check_number2").val();
         cn = $.trim(cn);
   var pa = $("#payment_amount2").val();
         pa = $.trim(pa); 
   var tv =  $("#search_id").val();
         tv =  $.trim(tv); 
   var lf =   $("#late_fee").val();
         lf =   $.trim(lf); 
   var prd = $("#process_date").val();
         prd = $.trim(prd);
   var sud = $("#signup_date").val();
         sud = $.trim(sud);     
         
   var cao = $("#cash_payment_orig").val();
         cao = $.trim(cao);         
   var ceo = $("#check_payment_orig").val();
         ceo = $.trim(ceo);         
   var tpo = $("#todays_payment_orig").val();
         tpo = $.trim(tpo);     
         
   var ms = 3; 
   var clear = "";
   var contractInfo = 'Client contact information';
   var bd =  $("#balance_due").val();
         
     if($('INPUT[name=access]').is(':checked')) {
     
           if($("#balance_due").val() == 'NA') {
             alert('This is not a valid record to process.');
                     return false;
              }

           if(pa == "") {
             alert('Please enter a value into the payment amount field');
                    return false;
             }
             
//checks to see if the input is a number
var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
             if(!numberRegex.test(pa)) {
                    alert("The value you typed into the Payment Amount field is invalid");
                            return false;   
                }   
                
        if(lf != "") {         
             if(!numberRegex.test(lf)) {
                    alert("The value you typed into the Late Fee field is invalid");
                            return false;   
                }                     
           }        

           if($("INPUT[name='p_type2']:checked").val() == 'check')  {             
            var pd = 'Balance Due Check';
            var pt = 'check';
                 if(cn == "") {
                    alert('Please enter the check number before submitting this form');
                            return false;
                   }              
               }
                                             

           if($("INPUT[name='p_type2']:checked").val() == 'cash')  { 
              var pd = 'Balance Due Cash';
              var pt = 'cash';
                    cn = 0;
              }

           //here we set up the ajax submission
     $.ajax ({
                 type: "POST",
                 url: "../helper_apps/contractInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: tv, month_switch: ms, todays_payment: pa, payment_description: pd, check_number: cn, balance_due: bd, pay_type: pt, late_fee: lf, process_date: prd, cash_payment_orig: cao, check_payment_orig: ceo, todays_payment_orig: tpo, signup_date: sud},               
                 success: function(data) {                                                    
           //   alert(data);
                                 alert('Initial payment balance for contract \"' +tv+ '\" successfully processed');
                                         $('#search_id').val(clear);
                                         $('#search_id').attr("disabled", false);
                                         $('#contract_info').html(contractInfo);
                                         $('input[name=access]').attr('checked', false);
                                         $('#monthly_payment').val(clear);
                                         $('#payment_amount').val(clear);
                                         $('#check_number').val(clear);
                                         $('#check').prop('checked', true);
                                         $('#cash').prop('checked', false);  
                                         $('#check_number').attr("disabled", false);
                                         
                                         $("#late_fee").val(clear); 
                                         $("#balance_due").val(clear);
                                         $("#payment_amount2").val(clear); 
                                         $('#check_number2').val(clear);
                                         $('#process_date').val(clear);
                                         $('#signup_date').val(clear);
                                         $("#cash_payment_orig").val(clear);
                                         $("#check_payment_orig").val(clear);
                                         $("#todays_payment_orig").val(clear);
                                         $('#check2').prop('checked', true);
                                         $('#cash2').prop('checked', false); 
                                         $('#check_number2').attr("disabled", false);
                                         $("#late_fee").attr("disabled", false);
                                         
                       
                     }//end function success
              }); //end ajax 


          }else{
          alert('Please check \"View Account\" before submitting this payment');
                  return false;          
          }

});



//----------------------------------------------------------------------------------------------

//this handles nsf entrys
//======================================================
//this handles non numeric values typed into the payment amount field nsf
$('#check_payment_nsf').bind('keyup', function(event) { 

 var n = $("#check_payment_nsf").val().length;
 var cpn =  $("#check_payment_nsf").val();
 
//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          cpn = cpn.slice(0, -1); 
             $("#check_payment_nsf").val(cpn);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

});

//-----------------------------------------------------------------------------------------------
//handles the check number field for nsf
$('#check_number_nsf').bind('keyup', function(event) { 

   var cnn = $("#check_number_nsf").val();
         cnn = $.trim(cnn);

//checks the key code if the space bar is used
     if(event.keyCode == '32') {
          cnn = cnn.slice(0, -1); 
             $("#check_number_nsf").val(cnn);          
               alert("Please do not use spaces in your query");
                       return false;        
        }

//checks to see if the input is a number
      if(isNaN($("#check_number_nsf").val())) {
          cnn = cnn.slice(0, -1); 
             $("#check_number_nsf").val(cnn);          
               alert("The character you entered is not a number");
                       return false;
         }


});

//---------------------------------------------------------------------------------------------
//this handles the form submission for initial payments
$('#nsf').bind('click', function(event) { 

   var cpn = $("#check_payment_nsf").val();
         cpn = $.trim(cpn); 
   var cnn = $("#check_number_nsf").val();
         cnn = $.trim(cnn);
   var tv =  $("#search_id").val();
         tv = $.trim(tv);          
   var ms = 4; 
   var clear = "";     
   var contractInfo = 'Client contact information';
         
 if($('INPUT[name=access]').is(':checked')) {

          if(cpn == "") {
             alert('Please enter a value into the Check Amount field');
                    return false;
             }
             
          if(cnn == "") {
             alert('Please enter a value into the Check Number field');
                    return false;
             }             
             
//checks to see if the input is a number
var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
             if(!numberRegex.test(cpn)) {
                    alert("The value you typed into the Check Amount field is invalid");
                            return false;   
                }   
                
             if(!numberRegex.test(cnn)) {
                    alert("The value you typed into the Check Number field is invalid");
                            return false;   
                }   
                   //checks to see if the check box is checked for page redirection
                  if($('INPUT[name=view]').is(':checked')) {
                        var redirectSwitch = 1;                  
                        }else{
                        var redirectSwitch = 2;
                        }

        //here we set up the ajax submission
     $.ajax ({
                 async: false,
                 type: "POST",
                 url: "../helper_apps/contractInfo.php",
                 cache: false,
                 dataType: 'html', 
                 data: {contract_key: tv, month_switch: ms, check_payment_nsf: cpn, check_number_nsf: cnn, redirect_switch: redirectSwitch},               
                 success: function(data) {                                                    
           //   alert(data);
           
                         if(data == 1) {
                            alert('\"Check Amount\" and \"Check Number\" record do not exist.');                            
                                    return false;                         
                           }
                           
                         if(data == 2) {
                            alert('\"Check Amount\" and \"Check Number\" already exist.');
                                    return false;                         
                           }                           
                                                                                 
                            if(data == 3) {
                                 alert('NSF record for \"' +tv+ '\" successfully uploaded');
                                         $('#search_id').val(clear);
                                         $('#search_id').attr("disabled", false);
                                         $('#contract_info').html(contractInfo);
                                         $('input[name=access]').attr('checked', false);
                                         $('#monthly_payment').val(clear);
                                         $('#payment_amount').val(clear);
                                         $('#check_number').val(clear);
                                         $('#check').prop('checked', true);
                                         $('#cash').prop('checked', false);  
                                         $('#check_number').attr("disabled", false);
                                         $("#check_payment_nsf").val(clear);
                                         $("#check_number_nsf").val(clear);
                                         
                                         $("#late_fee").val(clear); 
                                         $("#balance_due").val(clear);
                                         $("#payment_amount2").val(clear); 
                                         $('#check_number2').val(clear);
                                         $('#process_date').val(clear);
                                         $('#signup_date').val(clear);
                                         $("#cash_payment_orig").val(clear);
                                         $("#check_payment_orig").val(clear);
                                         $("#todays_payment_orig").val(clear);
                                         $('#check2').prop('checked', true);
                                         $('#cash2').prop('checked', false); 
                                         $('#check_number2').attr("disabled", false);
                                         $("#late_fee").attr("disabled", false);
                                         
                                    if(redirectSwitch == 1) {
                                        setTabs();
                                        window.location = "accountInformation.php";                                        
                                       }       
                                         
                                         
                                  }         
                       
                     }//end function success
              }); //end ajax 



    }else{
    alert('Please check \"View Account\" before submitting this info');
            return false;    
    }

});
//---------------------------------------------------------------------------------------------
});  //end of ready function

function setTabs() {

var bg= '#282828';
//var bg = "url(./images/carbon_fibre.png)";

window.parent.document.getElementById('contentHeader').style.backgroundColor = bg;


window.parent.document.getElementById('contentHeader').innerHTML = '<div id="tabOne" class="headText headText2">Account Information</div><div id="tabTwo" class="headText">Payment History</div><div id="tabThree" class="headText">Member Information</div><div id="tabFour" class="headText">Notes</div><div id="tabFive" class="headText">POS History</div>';


}


















