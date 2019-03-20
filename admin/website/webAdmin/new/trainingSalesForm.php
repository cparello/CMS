<?php
include_once('php/connection.php');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/signature_pad.css">
      <style>
      .centerBoxa{
        margin:auto;
      }
      #successBox{
      text-align: center;  
    }
     .button2 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button3 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button4 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button5 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button6 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button7 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button8 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
 .button9 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
.button10 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
.button11 {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: 1rem 2rem 1.0625rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
.clear {
    border-style: solid;
    border-width: 0px;
    cursor: pointer;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
    font-weight: normal;
    line-height: normal;
    margin: 0px 0px 1.25rem;
    position: relative;
    text-decoration: none;
    text-align: center;
    -moz-appearance: none;
    border-radius: 0px;
    display: inline-block;
    padding: .5rem .5rem .5rem;
    font-size: 1rem;
    background-color: #008CBA;
    border-color: #007095;
    color: #FFF;
    transition: background-color 300ms ease-out 0s;
}
    </style>
        <script>
        $(document).ready(function() {
           $("#masterTotal").css({"color": "red"});
           var totalPrice = $('#totalPrice').val();
           $('#masterTotal').html(totalPrice);
            //submit
             $('.b21').click(function() {
                $(".b21").attr("disabled", "disabled");
                //var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                //var serviceDetails = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                if($('input:radio[name=serviceOptions1]:checked').val() == undefined){
                    $('.b21').prop('disabled', false);
                    return false;
                    }
                var serviceDetails = $('input:radio[name=serviceOptions1]:checked').val();
                var dataArray = serviceDetails.split("|");
                         var serviceKey = dataArray[0];
                         var quantity = dataArray[1];
                         var term = dataArray[2];
                         var price = dataArray[3];
                         var name = dataArray[4];
                //alert(term);
                price = parseFloat(price);
                quantity = parseFloat(quantity);
                
                var bool = 1;
                 var str= term.match(/Month/);
                 if (str == 'Month'){
                    price = price/quantity;
                    price = price.toFixed(2);
                    var currentMonthDues = $('#monthDues').val();
                    currentMonthDues = parseFloat(currentMonthDues);
                    price = parseFloat(price);
                    currentMonthDues = currentMonthDues + price;
                    $('#monthDues').val(currentMonthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+currentMonthDues);
                    $('#monthly_bool').val(bool);
                      var cycleDay = document.getElementById('cycleDay').value;
                    var pastDay = document.getElementById('pastDay').value;
                    var rejectionFee = document.getElementById('rejectionFee').value;
                    var lateFee = document.getElementById('lateFee').value;
                    var monthlyDues = document.getElementById('monthDues').value;
                    if(bool != "0")  {
                        var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                    
                   // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                    document.getElementById('verifyEft').innerHTML = eftHtml;
                     }
                   
                    }
                
               
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#secondaryPurchase').val();
            
            var purchaseArray = ''+serviceKey+'|'+quantity+'|'+term+'|'+price+'|'+name+'@';
            $('#secondaryPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+name+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+quantity+'&nbsp;'+term+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //======================================================================================================
            $('.b22').click(function() {
                $(".b22").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
               // var serviceDetails = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                if($('input:radio[name=serviceOptions2]:checked').val() == undefined){
                    $('.b22').prop('disabled', false);
                    return false;
                    }
               var serviceDetails = $('input:radio[name=serviceOptions2]:checked').val();
                var dataArray = serviceDetails.split("|");
                         var serviceKey = dataArray[0];
                         var quantity = dataArray[1];
                         var term = dataArray[2];
                         var price = dataArray[3];
                         var name = dataArray[4];
                //alert(term);
                price = parseFloat(price);
                quantity = parseFloat(quantity);
                
                var bool = 1;
                 var str= term.match(/Month/);
                 if (str == 'Month'){
                    price = price/quantity;
                    price = price.toFixed(2);
                    var currentMonthDues = $('#monthDues').val();
                    currentMonthDues = parseFloat(currentMonthDues);
                    price = parseFloat(price);
                    currentMonthDues = currentMonthDues + price;
                    $('#monthDues').val(currentMonthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+currentMonthDues);
                    $('#monthly_bool').val(bool);
                      var cycleDay = document.getElementById('cycleDay').value;
                    var pastDay = document.getElementById('pastDay').value;
                    var rejectionFee = document.getElementById('rejectionFee').value;
                    var lateFee = document.getElementById('lateFee').value;
                    var monthlyDues = document.getElementById('monthDues').value;
                    if(bool != "0")  {
                        var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                    
                   // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                    document.getElementById('verifyEft').innerHTML = eftHtml;
                     }
                 
                    
                    }
                
               
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#secondaryPurchase').val();
            
            var purchaseArray = ''+serviceKey+'|'+quantity+'|'+term+'|'+price+'|'+name+'@';
            $('#secondaryPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+name+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+quantity+'&nbsp;'+term+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //===================================================================================================================
            $('.b23').click(function() {
                $(".b23").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                //var serviceDetails = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                 if($('input:radio[name=serviceOptions3]:checked').val() == undefined){
                    $('.b23').prop('disabled', false);
                    return false;
                    }
                var serviceDetails = $('input:radio[name=serviceOptions3]:checked').val();
                var dataArray = serviceDetails.split("|");
                         var serviceKey = dataArray[0];
                         var quantity = dataArray[1];
                         var term = dataArray[2];
                         var price = dataArray[3];
                         var name = dataArray[4];
                //alert(term);
                price = parseFloat(price);
                quantity = parseFloat(quantity);
                
                var bool = 1;
                 var str= term.match(/Month/);
                 if (str == 'Month'){
                    price = price/quantity;
                    price = price.toFixed(2);
                    var currentMonthDues = $('#monthDues').val();
                    currentMonthDues = parseFloat(currentMonthDues);
                    price = parseFloat(price);
                    currentMonthDues = currentMonthDues + price;
                    $('#monthDues').val(currentMonthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+currentMonthDues);
                    $('#monthly_bool').val(bool);
                      var cycleDay = document.getElementById('cycleDay').value;
                    var pastDay = document.getElementById('pastDay').value;
                    var rejectionFee = document.getElementById('rejectionFee').value;
                    var lateFee = document.getElementById('lateFee').value;
                    var monthlyDues = document.getElementById('monthDues').value;
                    if(bool != "0")  {
                        var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                    
                   // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                    document.getElementById('verifyEft').innerHTML = eftHtml;
                     }
                    
                    
                    }
                
               
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#secondaryPurchase').val();
            
            var purchaseArray = ''+serviceKey+'|'+quantity+'|'+term+'|'+price+'|'+name+'@';
            $('#secondaryPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+name+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+quantity+'&nbsp;'+term+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //=========================================================================================================================
            $('.b24').click(function() {
                $(".b24").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
               // var serviceDetails = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                if($('input:radio[name=serviceOptions4]:checked').val() == undefined){
                    $('.b24').prop('disabled', false);
                    return false;
                    }
               var serviceDetails = $('input:radio[name=serviceOptions4]:checked').val();
                var dataArray = serviceDetails.split("|");
                         var serviceKey = dataArray[0];
                         var quantity = dataArray[1];
                         var term = dataArray[2];
                         var price = dataArray[3];
                         var name = dataArray[4];
                //alert(term);
                price = parseFloat(price);
                quantity = parseFloat(quantity);
                
                var bool = 1;
                 var str= term.match(/Month/);
                 if (str == 'Month'){
                    price = price/quantity;
                    price = price.toFixed(2);
                    var currentMonthDues = $('#monthDues').val();
                    currentMonthDues = parseFloat(currentMonthDues);
                    price = parseFloat(price);
                    currentMonthDues = currentMonthDues + price;
                    $('#monthDues').val(currentMonthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+currentMonthDues);
                    $('#monthly_bool').val(bool);
                      var cycleDay = document.getElementById('cycleDay').value;
                    var pastDay = document.getElementById('pastDay').value;
                    var rejectionFee = document.getElementById('rejectionFee').value;
                    var lateFee = document.getElementById('lateFee').value;
                    var monthlyDues = document.getElementById('monthDues').value;
                    if(bool != "0")  {
                        var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                    
                   // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                    document.getElementById('verifyEft').innerHTML = eftHtml;
                     }
                    
                    }
                
               
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#secondaryPurchase').val();
            
            var purchaseArray = ''+serviceKey+'|'+quantity+'|'+term+'|'+price+'|'+name+'@';
            $('#secondaryPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+name+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+quantity+'&nbsp;'+term+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //=================================================================================================================
            $('.b25').click(function() {
                $(".b25").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                //var serviceDetails = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                 if($('input:radio[name=serviceOptions5]:checked').val() == undefined){
                    $('.b25').prop('disabled', false);
                    return false;
                    }
                var serviceDetails = $('input:radio[name=serviceOptions5]:checked').val();
                var dataArray = serviceDetails.split("|");
                         var serviceKey = dataArray[0];
                         var quantity = dataArray[1];
                         var term = dataArray[2];
                         var price = dataArray[3];
                         var name = dataArray[4];
                //alert(term);
                price = parseFloat(price);
                quantity = parseFloat(quantity);
                
                var bool = 1;
                 var str= term.match(/Month/);
                 if (str == 'Month'){
                    price = price/quantity;
                    price = price.toFixed(2);
                    var currentMonthDues = $('#monthDues').val();
                    currentMonthDues = parseFloat(currentMonthDues);
                    price = parseFloat(price);
                    currentMonthDues = currentMonthDues + price;
                    $('#monthDues').val(currentMonthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+currentMonthDues);
                    $('#monthly_bool').val(bool);
                      var cycleDay = document.getElementById('cycleDay').value;
                    var pastDay = document.getElementById('pastDay').value;
                    var rejectionFee = document.getElementById('rejectionFee').value;
                    var lateFee = document.getElementById('lateFee').value;
                    var monthlyDues = document.getElementById('monthDues').value;
                    if(bool != "0")  {
                        var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                    
                   // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                    document.getElementById('verifyEft').innerHTML = eftHtml;
                     }
                    
                    
                    }
                
               
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#secondaryPurchase').val();
            
            var purchaseArray = ''+serviceKey+'|'+quantity+'|'+term+'|'+price+'|'+name+'@';
            $('#secondaryPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+name+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+quantity+'&nbsp;'+term+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //===============================================================================================================
            
            $('.b31').click(function() {
                $(".b31").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                var gearName = $(this).attr('gearName');
                var price = $(this).attr('gearPrice');
                //alert(term);
                price = parseFloat(price);
                
                
              
                
            var blank = "";
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#gearPurchase').val();
            
            var purchaseArray = ''+gearName+'|'+price+'@';
            $('#gearPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+gearName+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+blank+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //==================================================================================
            $('.b32').click(function() {
                $(".b32").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                var gearName = $(this).attr('gearName');
                var price = $(this).attr('gearPrice');
                //alert(term);
                price = parseFloat(price);
                
                
              
                
            var blank = "";
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#gearPurchase').val();
            
            var purchaseArray = ''+gearName+'|'+price+'@';
            $('#gearPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+gearName+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+blank+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //====================================================================================================
            $('.b33').click(function() {
                $(".b33").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                var gearName = $(this).attr('gearName');
                var price = $(this).attr('gearPrice');
                //alert(term);
                price = parseFloat(price);
                
                
              
                
            var blank = "";
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#gearPurchase').val();
            
            var purchaseArray = ''+gearName+'|'+price+'@';
            $('#gearPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+gearName+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+blank+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //============================================================================================
            $('.b34').click(function() {
                $(".b34").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
                var gearName = $(this).attr('gearName');
                var price = $(this).attr('gearPrice');
                //alert(term);
                price = parseFloat(price);
                
                
              
                
            var blank = "";
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#gearPurchase').val();
            
            var purchaseArray = ''+gearName+'|'+price+'@';
            $('#gearPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+gearName+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+blank+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //=================================================================================================
            $('.b35').click(function() {
                $(".b35").attr("disabled", "disabled");
                var name = $(this).parents().eq(2).find('input[type=radio]:checked').attr('name');
                //alert(name);                
               var gearName = $(this).attr('gearName');
                var price = $(this).attr('gearPrice');
                //alert(term);
                price = parseFloat(price);
                
                
              
                
            var blank = "";
            var muliplyer = 1;
            var totalPrice = $('#totalPrice').val();
            price = parseFloat(price);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = price+totalPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            
            var tempPurArray = $('#gearPurchase').val();
            
            var purchaseArray = ''+gearName+'|'+price+'@';
            $('#gearPurchase').val(tempPurArray+purchaseArray);
            
                                    
            var purchaseHistoryHtml = $(".margin-top-bottom").html();
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</tbody>", ""); 
                purchaseHistoryHtml = purchaseHistoryHtml.replace("</table>", ""); 
            var html = '<tr><td id="servName"><b>'+gearName+'</b></td><td><b>'+muliplyer+'</b></td><td id="servPrice"><b>$'+price+'</b></td><td id="termQuan"><b>'+blank+'</b></td><td><input class="clear" id="clear" value="Clear" type="button"></td></tr>';
          
           $(".margin-top-bottom").html(purchaseHistoryHtml+html+"</tbody></table>");
            $('input:radio[name='+name+']:checked').prop('checked', false);
            });
            //===================================================================================================
         
        });
    </script>
    
    <script>
      $(function(){
        $(document).on("click","#clear", function(){
            
            //var answer1 = confirm('Would you like to remove this line from your purchase?');
           //                    if (!answer1) {
          //                           return false;
          //                           }
            var servName = $(this).parents().eq(1).find('#servName').html();
            servName = servName.replace("<b>", "");
            servName = servName.replace("</b>", "");
            
            
            
            var servPrice = $(this).parents().eq(1).find('#servPrice').html();
            //alert(servPrice);
            servPrice = servPrice.replace("<b>", "");
            servPrice = servPrice.replace("</b>", "");
            servPrice = servPrice.replace("$", "");
            servPrice = parseFloat(servPrice);
            
            var servTermQuan = $(this).parents().eq(1).find('#termQuan').html();
           
                 var str= servTermQuan.match(/Month/);
                 if (str == 'Month'){
                    var monthDues = $('#monthDues').val();
                    monthDues = parseFloat(monthDues);
                    monthDues = monthDues - servPrice;
                    monthDues = monthDues.toFixed(2);
                    $('#monthDues').val(monthDues);
                    $('#monthTotal').html('Monthly Payment:  $'+monthDues);
                    if(monthDues <= 0){
                        var bool = 0;
                        $('#monthly_bool').val(bool);
                        document.getElementById('verifyEft').innerHTML = null;
                        $('#monthTotal').html('');
                    }
                    
                    
                    }
                    
            var totalPrice = $('#totalPrice').val();
            servPrice = parseFloat(servPrice);
            totalPrice = parseFloat(totalPrice);
            var totalPrice = totalPrice-servPrice;
            $('#totalPrice').val(totalPrice);
            $('#masterTotal').html(totalPrice);
            
            $('tr:contains('+servName+')').remove(); 
            
            
         //var html = $(this).remove();
            //alert(servName);
            });
        });
    </script>
    <script type="text/javascript" src="js/checkTrainingSalesFieldsv2.js"></script>
</head>
<body>
    <?php 
    include_once('inc/header.php'); 
    $serviceName = $_REQUEST['service_name'];
    $numClasses = $_REQUEST['num_classes'];
    $total = $_REQUEST['total'];
    $qty = $_REQUEST['qty'];
    $serviceKey = $_REQUEST['serviceKey'];
    
    if (!isset($_SESSION['userContractKey'])) {
        $alreadyMember = 0;
        $stateSelect = "<option value=\"\">Select State (Required)</option>";
    } else {
        $alreadyMember = 1;
        $contractKey = $_SESSION['userContractKey'];
        $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob FROM member_info WHERE contract_key = '$contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($first_nameM, $middle_nameM, $last_nameM, $streetM, $cityM, $stateM, $zipM, $primary_phoneM, $cell_phoneM, $emailM, $dobM);
        $stmt->fetch();
        $stmt->close();
        
        $dobM = date('m-d-Y',strtotime($dobM));
        
        if(trim($stateM) == ""){
            $stateSelect = "<option value=\"\">Select State (Required)</option>";
        }else{
            $stateSelect = "<option value=\"$stateM\" selected>$stateM</option>";
        }
        
    }
    
    $servNameArr = explode('-',$serviceName);
    $clubName = $servNameArr[1];
    if(preg_match('/All/g',$clubName)){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }else{
        $stmt = $dbMain->prepare("SELECT club_id FROM club_info  WHERE club_name LIKE '%$clubName%'");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }
    
    //$clubId = 3551;
    

    $purchaseArray = "$serviceKey|$serviceName|$total|$qty|$numClasses";
    
    for($i=1;$i<=$qty;$i++){
        $memInfoListings .= "
        <div class=\"row\">
        <div class=\"small-12 large-12\">
        <p><strong>Member Information $i</strong></p>
        </div>
        <div class=\"small-12 large-4 columns\">
        <input tabindex=\"125\" name=\"first_name[]\" type=\"text\" id=\"first_name$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"First Name(REQUIRED)\"  required>
        <input tabindex=\"128\" name=\"street_address[]\" type=\"text\" id=\"street_address$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Street Address(REQUIRED)\"  required>
        <input tabindex=\"131\" name=\"zip_code[]\" type=\"text\" id=\"zip_code$i\" value=\"\" placeholder=\"Zip Code(REQUIRED)\" onclick=\"return checkServices(this.name,this.id)\" >
        <input  tabindex=\"134\" name=\"dob[]\" type=\"text\" id=\"dob$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Date of Birth (MM/DD/YYYY)(REQUIRED)\" required>
        </div>
        
        <div class=\"small-12 large-4 columns\">
        <input tabindex=\"126\" name=\"middle_name[]\" type=\"text\" id=\"middle_name$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Middle Name (optional)\">
        <input tabindex=\"129\" name=\"city[]\" type=\"text\" id=\"city$i\" value=\"\"  onclick=\"return checkServices(this.name,this.id)\" placeholder=\"City(REQUIRED)\" required>
        <input tabindex=\"132\" name=\"home_phone[]\" type=\"text\" id=\"home_phone$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Phone(REQUIRED)\" required>
        </div>
        
        <div class=\"small-12 large-4 columns\">
        <input tabindex=\"127\" name=\"last_name[]\" type=\"text\" id=\"last_name$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Last Name(REQUIRED)\" required>
        <select tabindex=\"130\" name=\"state[]\" id=\"state$i\" required>
            <option value=\"\">Select State(REQUIRED)</option>
            <option value=\"AL\">Alabama</option>
            <option value=\"AK\">Alaska</option>
            <option value=\"AZ\">Arizona</option>
            <option value=\"AR\">Arkansas</option>
            <option value=\"CA\">California</option>
            <option value=\"CO\">Colorado</option>
            <option value=\"CT\">Connecticut</option>
            <option value=\"DE\">Delaware</option>
            <option value=\"DC\">Wash. D.C.</option>
            <option value=\"FL\">Florida</option>
            <option value=\"GA\">Georgia</option>
            <option value=\"HI\">Hawaii</option>
            <option value=\"ID\">Idaho</option>
            <option value=\"IL\">Illinois</option>
            <option value=\"IN\">Indiana</option>
            <option value=\"IA\">Iowa</option>
            <option value=\"KS\">Kansas</option>
            <option value=\"KY\">Kentucky</option>
            <option value=\"LA\">Louisiana</option>
            <option value=\"ME\">Maine</option>
            <option value=\"MD\">Maryland</option>
            <option value=\"MA\">Massachusetts</option>
            <option value=\"MI\">Michigan</option>
            <option value=\"MN\">Minnesota</option>
            <option value=\"MS\">Mississippi</option>
            <option value=\"MO\">Missouri</option>
            <option value=\"MT\">Montana</option>
            <option value=\"NE\">Nebraska</option>
            <option value=\"NV\">Nevada</option>
            <option value=\"NH\">New Hampshire</option>
            <option value=\"NJ\">New Jersey</option>
            <option value=\"NM\">New Mexico</option>
            <option value=\"NY\">New York</option>
            <option value=\"NC\">North Carolina</option>
            <option value=\"ND\">North Dakota</option>
            <option value=\"OH\">Ohio</option>
            <option value=\"OK\">Oklahoma</option>
            <option value=\"OR\">Oregon</option>
            <option value=\"PA\">Pennsylvania</option>
            <option value=\"RI\">Rhode Island</option>
            <option value=\"SC\">So. Carolina</option>
            <option value=\"SD\">So. Dakota</option>
            <option value=\"TN\">Tennessee</option>
            <option value=\"TX\">Texas</option>
            <option value=\"UT\">Utah</option>
            <option value=\"VT\">Vermont</option>
            <option value=\"VA\">Virginia</option>
            <option value=\"WA\">Washington</option>
            <option value=\"WV\">West Virginia</option>
            <option value=\"WI\">Wisconsin</option>
            <option value=\"WY\">Wyoming</option>
        </select>
        <input tabindex=\"133\" name=\"email[]\" type=\"text\" id=\"email$i\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Email(REQUIRED)\"  required>
            </div></div>";
    }
    
    
    $stmt = $dbMain ->prepare("SELECT enhance_fee, rejection_fee, rate_fee, late_fee, maintnence_fee FROM fees WHERE fee_num = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($enhance_fee, $rejection_fee, $rate_fee, $late_fee, $m_fee);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT cycle_day, past_day FROM billing_cycle WHERE cycle_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($cycle_day, $past_day);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT pt_liability_waiver FROM website_training_options WHERE web_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($pt_liability_waiver);
    $stmt->fetch();
    $stmt->close();
    
    $monthly_bool = 0;
    
    $yearDrop = date("Y");
    /*for($i=0;$i<=10;$i++){
        $year = date("Y");
        $year = $year + $i;
        $yearDrop .= "<option value=\"$year\" >$year</option>";
    }*/
   
    
    $stmt = $dbMain ->prepare("SELECT service1, service2, service3, service4, service5, servicePhoto1, servicePhoto2, servicePhoto3, servicePhoto4, servicePhoto5, gear1, gear2, gear3, gear4, gear5, gearPhoto1, gearPhoto2, gearPhoto3, gearPhoto4, gearPhoto5 FROM website_membership_options WHERE web_key = '1'");
   
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service1, $service2, $service3, $service4, $service5, $servicePhoto1, $servicePhoto2, $servicePhoto3, $servicePhoto4, $servicePhoto5, $gear1, $gear2, $gear3, $gear4, $gear5, $gearPhoto1, $gearPhoto2, $gearPhoto3, $gearPhoto4, $gearPhoto5);
    $stmt->fetch();
    $stmt->close();
    //echo "test";
    
    if($gear1 !=""){
    $stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$gear1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($retailCost1, $clubInvMarker1);
    $stmt->fetch();
    $stmt->close();
    
    $gear1Html = "<li>
            	<img src=\"img/$gearPhoto1\" alt=\"\"><br>
                <strong><span class=\"gearName\">$gear1</span></strong><br>
            	$<span class=\"gearPrice\">$retailCost1</span><br>
                <input  tabindex=\"40\"  type=\"button\" class=\"button7 b31\" id=\"addItem\" gearName=\"$gear1\" gearPrice=\"$retailCost1\" value=\"Add\">
            </li>";
    }else{
        $gear1Html = "";
    }
    
    if($gear2 !=""){
    $stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$gear2'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($retailCost2, $clubInvMarker2);
    $stmt->fetch();
    $stmt->close();
    
    $gear2Html = "<li>
            	<img src=\"img/$gearPhoto2\" alt=\"\"><br>
                <strong><span class=\"gearName\">$gear2</span></strong><br>
            	$<span class=\"gearPrice\">$retailCost2</span><br>
                <input  tabindex=\"50\"  type=\"button\" class=\"button8 b32\" id=\"addItem\" gearName=\"$gear2\" gearPrice=\"$retailCost2\" value=\"Add\">
            </li>";
    }else{
        $gear2Html = "";
    }
    
    if($gear3 !=""){
    $stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$gear3'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($retailCost3, $clubInvMarker3);
    $stmt->fetch();
    $stmt->close();
    
    $gear3Html = "<li>
            	<img src=\"img/$gearPhoto3\" alt=\"\"><br>
                <strong><span class=\"gearName\">$gear3</span></strong><br>
            	$<span class=\"gearPrice\">$retailCost3</span><br>
                <input  tabindex=\"60\"  type=\"button\" class=\"button9 b33\" id=\"addItem\" gearName=\"$gear3\" gearPrice=\"$retailCost3\" value=\"Add\">
            </li>";
    }else{
        $gear3Html = "";
    }
    
    if($gear4 !=""){
    $stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$gear4'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($retailCost4, $clubInvMarker4);
    $stmt->fetch();
    $stmt->close();
    
    $gear4Html = "<li>
            	<img src=\"img/$gearPhoto4\" alt=\"\"><br>
                <strong><span class=\"gearName\">$gear4</span></strong><br>
            	$<span class=\"gearPrice\">$retailCost4</span><br>
                <input  tabindex=\"70\"  type=\"button\" class=\"button10 b34\" id=\"addItem\" gearName=\"$gear4\" gearPrice=\"$retailCost4\" value=\"Add\">
            </li>";
    }else{
        $gear4Html = "";
    }
    
    if($gear5 !=""){
    $stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$gear5'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($retailCost5, $clubInvMarker5);
    $stmt->fetch();
    $stmt->close();
    
    $gear5Html = "<li>
            	<img src=\"img/$gearPhoto5\" alt=\"\"><br>
                <strong><span class=\"gearName\">$gear5</span></strong><br>
            	$<span class=\"gearPrice\">$retailCost5</span><br>
                <input  tabindex=\"80\"  type=\"button\" class=\"button11 b35\" id=\"addItem\" gearName=\"$gear5\" gearPrice=\"$retailCost5\" value=\"Add\">
            </li>";
    }else{
        $gear5Html = "";
    }
    
     $service1Buff = explode('-',$service1);
    $service1 = trim($service1Buff[0]);
    
    if($service1 !=""){
        
   
    
    $counter = 0;
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$service1' ORDER BY service_cost ASC
    ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
        while($stmt->fetch()){
            $serviceKeyArray1[$counter] = $service_key;
            $serviceCostArray1[$counter] = $service_cost;
            $serviceQuantityArray1[$counter] = $service_quantity;
            if ($service_quantity > 1){
                $buff = "s";
            }else{
                $buff = "";
            }
            switch($service_term){
                case 'C':
                if ($buff == 's'){
                    $buff = 'es';
                }
                $serviceTermArray1[$counter] = "Class$buff";
                break;
                case 'D':
                $serviceTermArray1[$counter] = "Day$buff";
                break;
                case 'W':
                $serviceTermArray1[$counter] = "Week$buff";
                break;
                case 'M':
                $serviceTermArray1[$counter] = "Month$buff";
                break;
                case 'Y':
                $serviceTermArray1[$counter] = "Year$buff";
                break;
            }
            $counter++;
        }
    $stmt->close();
    $servicePrice1a = $serviceCostArray1[0];
    $servicePrice1b = $serviceCostArray1[1];
    $servicePrice1c = $serviceCostArray1[2];
    $servicePrice1d = $serviceCostArray1[3];
    $serviceTerm1a = $serviceTermArray1[0];
    $serviceTerm1b = $serviceTermArray1[1];
    $serviceTerm1c = $serviceTermArray1[2];
    $serviceTerm1d = $serviceTermArray1[3];
    $serviceQuantity1a = $serviceQuantityArray1[0];
    $serviceQuantity1b = $serviceQuantityArray1[1];
    $serviceQuantity1c = $serviceQuantityArray1[2];
    $serviceQuantity1d = $serviceQuantityArray1[3];
    $serviceKey1 = $serviceKeyArray1[0];
    
    if(preg_match('/Month/',$serviceTerm1a)){
        $priceBuff1 = sprintf("%.2f", ($servicePrice1a/$serviceQuantity1a));
        $priceBuff1 = "$priceBuff1/M";
        $priceBuff2 = sprintf("%.2f", ($servicePrice1b/$serviceQuantity1b));
        $priceBuff2 = "$priceBuff2/M";
        $priceBuff3 = sprintf("%.2f", ($servicePrice1c/$serviceQuantity1c));
        $priceBuff3 = "$priceBuff3/M";
        $priceBuff4 = sprintf("%.2f", ($servicePrice1d/$serviceQuantity1d));
        $priceBuff4 = "$priceBuff4/M";
    }else{
        $priceBuff1 = $servicePrice1a;
        $priceBuff2 = $servicePrice1b;
        $priceBuff3 = $servicePrice1c;
        $priceBuff4 = $servicePrice1d;
    }
    
    $service1Html = " <li>
            	<img src=\"img/$servicePhoto1\" alt=\"\"><br>
                <strong> $service1</strong><br>
            	<input  tabindex=\"10\" type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1a|$serviceTerm1a|$servicePrice1a|$service1\"><span style=\"color: #;\">&nbsp;  $serviceQuantity1a $serviceTerm1a $$priceBuff1 </span></input><br>
                <input  tabindex=\"11\" type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1b|$serviceTerm1b|$servicePrice1b|$service1\"><span style=\"color: #;\">&nbsp; $serviceQuantity1b $serviceTerm1b $$priceBuff2 </span></input><br>
                <input tabindex=\"12\" type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1c|$serviceTerm1c|$servicePrice1c|$service1\"><span style=\"color: #;\">&nbsp; $serviceQuantity1c $serviceTerm1c $$priceBuff3 </span></input><br>
                <input tabindex=\"13\" type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1d|$serviceTerm1d|$servicePrice1d|$service1\"><span style=\"color: #;\">&nbsp; $serviceQuantity1d $serviceTerm1d $$priceBuff4 </span></input><br>
                <input tabindex=\"14\" type=\"button\" class=\"button2 b21\"  id=\"addItem\" value=\"Add\">

            </li>";
     }else{
        $service1Html = "";
     }
    //echo "$serviceKey1|$serviceQuantity1a|$serviceTerm1a|$servicePrice1a|$service1";
    
    
     $service2Buff = explode('-',$service2);
    $service2 = trim($service2Buff[0]);
    
    if($service2 !=""){
    $counter = 0;
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$service2' ORDER BY service_cost ASC
    ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
        while($stmt->fetch()){
            $serviceKeyArray2[$counter] = $service_key;
            $serviceCostArray2[$counter] = $service_cost;
            $serviceQuantityArray2[$counter] = $service_quantity;
            if ($service_quantity > 1){
                $buff = "s";
            }else{
                $buff = "";
            }
            switch($service_term){
                case 'C':
                if ($buff == 's'){
                    $buff = 'es';
                }
                $serviceTermArray2[$counter] = "Class$buff";
                break;
                case 'D':
                $serviceTermArray2[$counter] = "Day$buff";
                break;
                case 'W':
                $serviceTermArray2[$counter] = "Week$buff";
                break;
                case 'M':
                $serviceTermArray2[$counter] = "Month$buff";
                break;
                case 'Y':
                $serviceTermArray2[$counter] = "Year$buff";
                break;
            }
            $counter++;
        }
    $stmt->close();
    $servicePrice2a = $serviceCostArray2[0];
    $servicePrice2b = $serviceCostArray2[1];
    $servicePrice2c = $serviceCostArray2[2];
    $servicePrice2d = $serviceCostArray2[3];
    $serviceTerm2a = $serviceTermArray2[0];
    $serviceTerm2b = $serviceTermArray2[1];
    $serviceTerm2c = $serviceTermArray2[2];
    $serviceTerm2d = $serviceTermArray2[3];
    $serviceQuantity2a = $serviceQuantityArray2[0];
    $serviceQuantity2b = $serviceQuantityArray2[1];
    $serviceQuantity2c = $serviceQuantityArray2[2];
    $serviceQuantity2d = $serviceQuantityArray2[3];
    $serviceKey2 = $serviceKeyArray2[0];
    
    if(preg_match('/Month/',$serviceTerm2a)){
        $priceBuff1 = sprintf("%.2f", ($servicePrice2a/$serviceQuantity2a));
        $priceBuff1 = "$priceBuff1/M";
        $priceBuff2 = sprintf("%.2f", ($servicePrice2b/$serviceQuantity2b));
        $priceBuff2 = "$priceBuff2/M";
        $priceBuff3 = sprintf("%.2f", ($servicePrice2c/$serviceQuantity2c));
        $priceBuff3 = "$priceBuff3/M";
        $priceBuff4 = sprintf("%.2f", ($servicePrice2d/$serviceQuantity2d));
        $priceBuff4 = "$priceBuff4/M";
    }else{
        $priceBuff1 = $servicePrice2a;
        $priceBuff2 = $servicePrice2b;
        $priceBuff3 = $servicePrice2c;
        $priceBuff4 = $servicePrice2d;
    }
    
    $service2Html = " <li>
            	<img src=\"img/$servicePhoto2\" alt=\"\"><br>
                <strong> $service2</strong><br>
            	<input tabindex=\"15\" type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2a|$serviceTerm2a|$servicePrice2a|$service2\"><span style=\"color: #;\">&nbsp;  $serviceQuantity2a $serviceTerm2a $$priceBuff1 </span></input><br>
                <input tabindex=\"16\" type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2b|$serviceTerm2b|$servicePrice2b|$service2\"><span style=\"color: #;\">&nbsp; $serviceQuantity2b $serviceTerm2b $$priceBuff2 </span></input><br>
                <input tabindex=\"17\" type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2c|$serviceTerm2c|$servicePrice2c|$service2\"><span style=\"color: #;\">&nbsp; $serviceQuantity2c $serviceTerm2c $$priceBuff3 </span></input><br>
                <input tabindex=\"18\" type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2d|$serviceTerm2d|$servicePrice2d|$service2\"><span style=\"color: #;\">&nbsp; $serviceQuantity2d $serviceTerm2d $$priceBuff4 </span></input><br>
                <input tabindex=\"19\" type=\"button\" class=\"button3 b22\"  id=\"addItem\" value=\"Add\">

            </li>";
     }else{
        $service2Html = "";
     }
    
    
     $service3Buff = explode('-',$service3);
    $service3 = trim($service3Buff[0]);
    
    if($service3 !=""){
    $counter = 0;
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$service3' ORDER BY service_cost ASC
    ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
        while($stmt->fetch()){
            $serviceKeyArray3[$counter] = $service_key;
            $serviceCostArray3[$counter] = $service_cost;
            $serviceQuantityArray3[$counter] = $service_quantity;
            if ($service_quantity > 1){
                $buff = "s";
            }else{
                $buff = "";
            }
            switch($service_term){
                case 'C':
                if ($buff == 's'){
                    $buff = 'es';
                }
                $serviceTermArray3[$counter] = "Class$buff";
                break;
                case 'D':
                $serviceTermArray3[$counter] = "Day$buff";
                break;
                case 'W':
                $serviceTermArray3[$counter] = "Week$buff";
                break;
                case 'M':
                $serviceTermArray3[$counter] = "Month$buff";
                break;
                case 'Y':
                $serviceTermArray3[$counter] = "Year$buff";
                break;
            }
            $counter++;
        }
    $stmt->close();
    $servicePrice3a = $serviceCostArray3[0];
    $servicePrice3b = $serviceCostArray3[1];
    $servicePrice3c = $serviceCostArray3[2];
    $servicePrice3d = $serviceCostArray3[3];
    $serviceTerm3a = $serviceTermArray3[0];
    $serviceTerm3b = $serviceTermArray3[1];
    $serviceTerm3c = $serviceTermArray3[2];
    $serviceTerm3d = $serviceTermArray3[3];
    $serviceQuantity3a = $serviceQuantityArray3[0];
    $serviceQuantity3b = $serviceQuantityArray3[1];
    $serviceQuantity3c = $serviceQuantityArray3[2];
    $serviceQuantity3d = $serviceQuantityArray3[3];
    $serviceKey3 = $serviceKeyArray3[0];
    
    if(preg_match('/Month/',$serviceTerm3a)){
        $priceBuff1 = sprintf("%.2f", ($servicePrice3a/$serviceQuantity3a));
        $priceBuff1 = "$priceBuff1/M";
        $priceBuff2 = sprintf("%.2f", ($servicePrice3b/$serviceQuantity3b));
        $priceBuff2 = "$priceBuff2/M";
        $priceBuff3 = sprintf("%.2f", ($servicePrice3c/$serviceQuantity3c));
        $priceBuff3 = "$priceBuff3/M";
        $priceBuff4 = sprintf("%.2f", ($servicePrice3d/$serviceQuantity3d));
        $priceBuff4 = "$priceBuff4/M";
    }else{
        $priceBuff1 = $servicePrice3a;
        $priceBuff2 = $servicePrice3b;
        $priceBuff3 = $servicePrice3c;
        $priceBuff4 = $servicePrice3d;
    }
    
    $service3Html = " <li>
            	<img src=\"img/$servicePhoto3\" alt=\"\"><br>
                <strong> $service3</strong><br>
            	<input tabindex=\"20\" type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3a|$serviceTerm3a|$servicePrice3a|$service3\"><span style=\"color: #;\">&nbsp;  $serviceQuantity3a $serviceTerm3a $$priceBuff1 </span></input><br>
                <input tabindex=\"21\" type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3b|$serviceTerm3b|$servicePrice3b|$service3\"><span style=\"color: #;\">&nbsp; $serviceQuantity3b $serviceTerm3b $$priceBuff2 </span></input><br>
                <input tabindex=\"22\" type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3c|$serviceTerm3c|$servicePrice3c|$service3\"><span style=\"color: #;\">&nbsp; $serviceQuantity3c $serviceTerm3c $$priceBuff3 </span></input><br>
                <input tabindex=\"23\" type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3d|$serviceTerm3d|$servicePrice3d|$service3\"><span style=\"color: #;\">&nbsp; $serviceQuantity3d $serviceTerm3d $$priceBuff4 </span></input><br>
                <input tabindex=\"24\" type=\"button\" class=\"button4 b23\"  id=\"addItem\" value=\"Add\">

            </li>";
     }else{
        $service3Html = "";
     }
    
     $service4Buff = explode('-',$service4);
    $service4 = trim($service4Buff[0]);
    
    if($service4 !=""){
    $counter = 0;
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$service4' ORDER BY service_cost ASC
    ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
        while($stmt->fetch()){
            $serviceKeyArray4[$counter] = $service_key;
            $serviceCostArray4[$counter] = $service_cost;
            $serviceQuantityArray4[$counter] = $service_quantity;
            if ($service_quantity > 1){
                $buff = "s";
            }else{
                $buff = "";
            }
            switch($service_term){
                case 'C':
                if ($buff == 's'){
                    $buff = 'es';
                }
                $serviceTermArray4[$counter] = "Class$buff";
                break;
                case 'D':
                $serviceTermArray4[$counter] = "Day$buff";
                break;
                case 'W':
                $serviceTermArray4[$counter] = "Week$buff";
                break;
                case 'M':
                $serviceTermArray4[$counter] = "Month$buff";
                break;
                case 'Y':
                $serviceTermArray4[$counter] = "Year$buff";
                break;
            }
            $counter++;
        }
    $stmt->close();
    $servicePrice4a = $serviceCostArray4[0];
    $servicePrice4b = $serviceCostArray4[1];
    $servicePrice4c = $serviceCostArray4[2];
    $servicePrice4d = $serviceCostArray4[3];
    $serviceTerm4a = $serviceTermArray4[0];
    $serviceTerm4b = $serviceTermArray4[1];
    $serviceTerm4c = $serviceTermArray4[2];
    $serviceTerm4d = $serviceTermArray4[3];
    $serviceQuantity4a = $serviceQuantityArray4[0];
    $serviceQuantity4b = $serviceQuantityArray4[1];
    $serviceQuantity4c = $serviceQuantityArray4[2];
    $serviceQuantity4d = $serviceQuantityArray4[3];
    $serviceKey4 = $serviceKeyArray4[0];
    
    if(preg_match('/Month/',$serviceTerm4a)){
        $priceBuff1 = sprintf("%.2f", ($servicePrice4a/$serviceQuantity4a));
        $priceBuff1 = "$priceBuff1/M";
        $priceBuff2 = sprintf("%.2f", ($servicePrice4b/$serviceQuantity4b));
        $priceBuff2 = "$priceBuff2/M";
        $priceBuff3 = sprintf("%.2f", ($servicePrice4c/$serviceQuantity4c));
        $priceBuff3 = "$priceBuff3/M";
        $priceBuff4 = sprintf("%.2f", ($servicePrice4d/$serviceQuantity4d));
        $priceBuff4 = "$priceBuff4/M";
    }else{
        $priceBuff1 = $servicePrice4a;
        $priceBuff2 = $servicePrice4b;
        $priceBuff3 = $servicePrice4c;
        $priceBuff4 = $servicePrice4d;
    }
    
    $service4Html = " <li>
            	<img src=\"img/$servicePhoto4\" alt=\"\"><br>
                <strong> $service4</strong><br>
            	<input tabindex=\"25\" type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4a|$serviceTerm4a|$servicePrice4a|$service4\"><span style=\"color: #;\">&nbsp;  $serviceQuantity4a $serviceTerm4a $$priceBuff1 </span></input><br>
                <input tabindex=\"26\" type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4b|$serviceTerm4b|$servicePrice4b|$service4\"><span style=\"color: #;\">&nbsp; $serviceQuantity4b $serviceTerm4b  $$priceBuff2 </span></input><br>
                <input tabindex=\"27\" type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4c|$serviceTerm4c|$servicePrice4c|$service4\"><span style=\"color: #;\">&nbsp; $serviceQuantity4c $serviceTerm4c  $$priceBuff3 </span></input><br>
                <input tabindex=\"28\" type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4d|$serviceTerm4d|$servicePrice4d|$service4\"><span style=\"color: #;\">&nbsp; $serviceQuantity4d $serviceTerm4d  $$priceBuff4 </span></input><br>
                <input tabindex=\"29\" type=\"button\" class=\"button5 b24\"  id=\"addItem\" value=\"Add\">

            </li>";
     }else{
        $service4Html = "";
     }
    
     $service5Buff = explode('-',$service5);
    $service5 = trim($service5Buff[0]);
    
    if($service5 !=""){
    $counter = 0;
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$service5' ORDER BY service_cost ASC
    ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
        while($stmt->fetch()){
            $serviceKeyArray5[$counter] = $service_key;
            $serviceCostArray5[$counter] = $service_cost;
            $serviceQuantityArray5[$counter] = $service_quantity;
            if ($service_quantity > 1){
                $buff = "s";
            }else{
                $buff = "";
            }
            switch($service_term){
                case 'C':
                if ($buff == 's'){
                    $buff = 'es';
                }
                $serviceTermArray5[$counter] = "Class$buff";
                break;
                case 'D':
                $serviceTermArray5[$counter] = "Day$buff";
                break;
                case 'W':
                $serviceTermArray5[$counter] = "Week$buff";
                break;
                case 'M':
                $serviceTermArray5[$counter] = "Month$buff";
                break;
                case 'Y':
                $serviceTermArray5[$counter] = "Year$buff";
                break;
            }
            $counter++;
        }
    $stmt->close();
    $servicePrice5a = $serviceCostArray5[0];
    $servicePrice5b = $serviceCostArray5[1];
    $servicePrice5c = $serviceCostArray5[2];
    $servicePrice5d = $serviceCostArray5[3];
    $serviceTerm5a = $serviceTermArray5[0];
    $serviceTerm5b = $serviceTermArray5[1];
    $serviceTerm5c = $serviceTermArray5[2];
    $serviceTerm5d = $serviceTermArray5[3];
    $serviceQuantity5a = $serviceQuantityArray5[0];
    $serviceQuantity5b = $serviceQuantityArray5[1];
    $serviceQuantity5c = $serviceQuantityArray5[2];
    $serviceQuantity5d = $serviceQuantityArray5[3];
    $serviceKey5 = $serviceKeyArray5[0];
    
    if(preg_match('/Month/',$serviceTerm5a)){
        $priceBuff1 = sprintf("%.2f", ($servicePrice5a/$serviceQuantity5a));
        $priceBuff1 = "$priceBuff1/M";
        $priceBuff2 = sprintf("%.2f", ($servicePrice5b/$serviceQuantity5b));
        $priceBuff2 = "$priceBuff2/M";
        $priceBuff3 = sprintf("%.2f", ($servicePrice5c/$serviceQuantity5c));
        $priceBuff3 = "$priceBuff3/M";
        $priceBuff4 = sprintf("%.2f", ($servicePrice5d/$serviceQuantity5d));
        $priceBuff4 = "$priceBuff4/M";
    }else{
        $priceBuff1 = $servicePrice5a;
        $priceBuff2 = $servicePrice5b;
        $priceBuff3 = $servicePrice5c;
        $priceBuff4 = $servicePrice5d;
    }
    
    $service5Html = " <li>
            	<img src=\"img/$servicePhoto5\" alt=\"\"><br>
                <strong> $service5</strong><br>
            	<input tabindex=\"30\" type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5a|$serviceTerm5a|$servicePrice5a|$service5\"><span style=\"color: #;\">&nbsp;  $serviceQuantity5a $serviceTerm5a $ $priceBuff1 </span></input><br>
                <input tabindex=\"31\" type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5b|$serviceTerm5b|$servicePrice5b|$service5\"><span style=\"color: #;\">&nbsp; $serviceQuantity5b $serviceTerm5b  $ $priceBuff2 </span></input><br>
                <input tabindex=\"32\" type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5c|$serviceTerm5c|$servicePrice5c|$service5\"><span style=\"color: #;\">&nbsp; $serviceQuantity5c $serviceTerm5c  $ $priceBuff3 </span></input><br>
                <input tabindex=\"33\" type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5d|$serviceTerm5d|$servicePrice5d|$service5\"><span style=\"color: #;\">&nbsp; $serviceQuantity5d $serviceTerm5d  $ $priceBuff4 </span></input><br>
                <input tabindex=\"34\" type=\"button\" class=\"button6 b25\"  id=\"addItem\" value=\"Add\">

            </li>";
     }else{
        $service5Html = "";
     }
    ?>
    
    <div class="row margin-top-bottom">
    	<h1>Purchase Summary</h1>
        <table width="100%">
            <thead>
                <tr>
                    <th width="50%">Item</th>
                    <th width="10%">QTY</th>
                    <th width="15%">Price</th>
                    <th width="15%">Service Length</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td><?php echo $serviceName?> </td>
                    <td><?php echo $qty?></td>
                    <td>$<?php echo $total?></td>
                    <td><?php echo $numClasses?>&nbsp;Classes</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="row text-center">
    	<h3>Customers Who Bought This Item Also Bought</h3>
        <ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-5">
             <?php echo $service1Html ?>
            
            <?php echo $service2Html ?>
            
            <?php echo $service3Html ?>
            
            <?php echo $service4Html ?>
            
            <?php echo $service5Html ?>
            
            <?php echo $gear1Html ?>
            
            <?php echo $gear2Html ?>
            
            <?php echo $gear3Html ?>
            
            <?php echo $gear4Html ?>
            
            <?php echo $gear5Html ?>
        </ul>
    </div>
    
    <div class="row margin">
    	<h3>Personal Training Waiver</h3>
        <div style="border:1px solid #c9c9c9; overflow:scroll; height:250px; width:100%"><p><?php echo $pt_liability_waiver ?></p>
        </div>
        <input  tabindex="90"  type="checkbox" name="terms_conditions" id="terms_conditions"  value=""/> I have read Personal Training ASSUMPTION OF RISK, WAIVER AND RELEASE OF LIABILITY, AND INDEMNITY AGREEMENT DECLARATIONS.
    </div>
    
    <div class="row">
        <div class="small-12 large-12">
        <h3>Membership Information</h3>
        <strong><input  tabindex="95"  type="checkbox" name="liability_host" id="liability_host"  value=""/> Is the member a minor under 18 years of age?</strong><br>
        <strong><input  tabindex="100"  type="checkbox" name="billing_info" id="billing_info"  value=""/> Is the billing info different than the membership info?</strong>
        </div>
        <span id="hostInfo"></span>
        
    </div>
    
   
        
        
        <?php echo $memInfoListings ?>
        
    
    
    <div class="row">
        <div class="small-12 large-12">
            <h3>Payment Information</h3>
            <p>Today's Payment: $<span id="masterTotal">0.00</span></p>
            <span id="monthTotal"></span>
            <div class="verifyPay">
                <span id="verifyEft"></span>
                <span id="verifyRate"></span>
                <span id="verifyEnhance"></span>
                </div>
        </div>
    </div>
    
    <div class="row">
    <span id="monthlyText"></span>
        <div class="large-4 centerBoxa">
        <ul class="pricing-table">
        <li class="title">Select Payment method</li>
        
        <select   tabindex="160" name="billType" id="billType" required>
                <option value="NO">Select Billing Type(REQUIRED)</option>
                <option value="CR">Credit Card</option>
                <option value="BA">Bank</option>
            </select>
             </ul>
        <span id="payErrors"></span>
        <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=HMhTdG4LpgKmCFiXrmkdxZolqMhZjoAKMExZVVo0kJCGHYzZVPkcryx1k1ET"></script></span>
        <span id="creditPay"></span>
         <span id="bankPay"></span>    
        </div>
        
        
    </div>
    
     <div id="successBox">
    
    </div>
    
    <div class="row">
	   <div class="large-4 centerBoxa confirm">
           <ul class="pricing-table">
                <li class="title">Membership Agreement</li>
                <p>
                    <strong>I, &nbsp;<input tabindex="180" name="input_name" id="input_name" type="text">
                        &nbsp;hereby consent to the use of an electronic signature to record my commitment
                        to the terms of this Agreement, which I acknowledge I have read the Terms and Conditions in full, and I acknowledge that I am of legal age. A copy of this Membership Agreement will be available for printing and sent to me via an email.</strong>
                </p>
              <input type="button" value="Submit Information" id="submitPt" class="button buttonSubmit buttonPassesGreen buttonSize">
            </ul>
        </div>
     </div>
    <input type="hidden" id="numSales" name="numSales" value="<?php echo $qty ?>">
    <input type="hidden" id="origServiceKey" name="origServiceKey" value="<?php echo $serviceKey ?>">
    <input type="hidden" id="origServiceName" name="origServiceName" value="<?php echo $serviceName ?>">
    <input type="hidden" id="origNumClasses" name="origNumClasses" value="<?php echo $numClasses ?>">
    <input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $total ?>">
    <input type="hidden" id="purchaseArray" name="purchaseArray" value="<?php echo $purchaseArray ?>">
    <input type="hidden" id="secondaryPurchase" name="secondaryPurchase" value="">
    <input type="hidden" id="gearPurchase" name="gearPurchase" value="">
    <input name="alreadyMember" id="alreadyMember" value="" type="hidden">
    <input name="host_info_array" id="host_info_array" value="" type="hidden">
    <input name="nameAddArray" id="nameAddArray" value="" type="hidden">
    <input name="emg_info_array" id="emg_info_array" value="" type="hidden">
    <input type="hidden" name="monthDues" id="monthDues" value="0"/>
    <input type="hidden" name="cycleDay" id="cycleDay" value="<?php echo $cycle_day ?>"/>
    <input type="hidden" name="pastDay" id="pastDay" value="<?php echo $past_day ?>"/>
    <input type="hidden" name="enhanceFee" id="enhanceFee" value="<?php echo $enhance_fee ?>"/>
    <input type="hidden" name="rejectionFee" id="rejectionFee" value="<?php echo $rejection_fee ?>"/>
    <input type="hidden" name="mFee" id="mFee" value="<?php echo $m_fee ?>"/>
    <input type="hidden" name="lateFee" id="lateFee" value="<?php echo $late_fee ?>"/>
    <input type="hidden" name="rateFee" id="rateFee" value="<?php echo $rate_fee ?>"/>
    <input type="hidden" name="month_bit"  id="month_bit" value="1111"/>    
    <input type="hidden" name="monthly_bool"  id="monthly_bool" value="<?php echo $monthly_bool ?>"/> 
    <input type="hidden" name="clubId"  id="clubId" value="<?php echo $clubId ?>"/> 
    <input type="hidden" name="yearDrop"  id="yearDrop" value="<?php echo $yearDrop ?>"/> 
    
    
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>