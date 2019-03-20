<?php
 session_start();
include_once('php/connection.php');
$club_id = $_REQUEST['club_id'];
$contractKey = $_SESSION['userContractKey'];
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php');
    $count = 0;
    $stmt99 = $dbMain ->prepare("SELECT DISTINCT service_key FROM paid_full_services WHERE contract_key = '$contractKey'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($service_key);
    $rowCount2 = $stmt99->num_rows;
    while($stmt99->fetch()){
       
        $stmt = $dbMain ->prepare("SELECT service_name, MAX(end_date) FROM paid_full_services WHERE contract_key = '$contractKey' AND service_key = '$service_key' AND service_name LIKE '%Membership%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_name, $end_date);
        $stmt->fetch();
        $stmt->close();
        $endBuff = $end_date;
        
        $endDate = date('m-d-y',strtotime($end_date));
        $nowSecs = time();
        $expSecs = strtotime($end_date);
        
        if($nowSecs <= $expSecs){
            $count++;
        }
        
        $service_key = "";
        
    }
    $stmt99->close();
    
   
    if ($count == 0){
    
         $stmt22 = $dbMain ->prepare("SELECT DISTINCT service_key, service_name, monthly_dues, end_date, service_id FROM monthly_services WHERE contract_key = '$contractKey' AND service_name LIKE '%Membership%'");
        $stmt22->execute();      
        $stmt22->store_result();      
        $stmt22->bind_result($service_key, $service_name, $monthly_dues, $end_date, $service_id);
        $rowCount1 = $stmt22->num_rows;
        while($stmt22->fetch()){
            $stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$contractKey' AND service_key = '$service_key' AND service_id = '$service_id'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($account_status);
                $stmt->fetch();
                $stmt->close();
           
            if($account_status == 'CU'){
                $endDateSecs = strtotime($end_date);
                $nowSecs = time();
                $diff = $nowSecs - $endDateSecs;
                $numMonths = round($diff/30,2);
                $buyOut = sprintf('%.2f',$numMonths * $monthly_dues);
                
            }
        
    }
    $stmt22->close();
    }
    
    
$stmt = $dbMain ->prepare("SELECT late_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($lateFee);
$stmt->fetch();


$stmt->close();     
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key='$contractKey'");
$stmt->execute();      
$stmt->store_result();  
$numRows = $stmt->num_rows;
$stmt->bind_result($next_payment_due_date);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();


$stmt = $dbMain ->prepare("SELECT MAX(cycle_date) FROM monthly_payments WHERE contract_key ='$contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);
$stmt->fetch();
$stmt->close();

$todaysDateSecs = time();

if($next_payment_due_date != "") {
     $monthlySettledDueDateSecs = strtotime($next_payment_due_date);
     
      if($todaysDateSecs >= $monthlySettledDueDateSecs) {
          $nextPaymentDueDate = $next_payment_due_date;
          $todaysDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), date("d"), date("Y")));
           $datetime1 = new DateTime($nextPaymentDueDate);
           $datetime2 = new DateTime($todaysDate);
           $interval = $datetime1-> diff($datetime2);                    
           $daysPastDue = $interval-> format('%d');
           $monthsPastDue = $interval-> format('%m');
           $yearsPastDue = $interval-> format('%y');
           
           if($monthsPastDue >= 1) {
           
               if($yearsPastDue >= 1) {
                  $months = $yearsPastDue * 12;  
                  $monthsPastDue = $monthsPastDue + $months;
                  if($yearText > 1){
                    $yearText = "$yearsPastDue Years and ";
                  }else if($yearText == 1){
                    $yearText = "$yearsPastDue Year and ";
                  }else{
                    $yearText = "";
                  }
                 }
                                  
             $pastDueTotal = ($monthlyPayment * $monthsPastDue) + $lateFee;
              $pastDueTotal = sprintf("%01.2f", $pastDueTotal);            
             }else{
                $pastDueTotal = 0;
             }
        }
        
   }elseif($next_payment_due_date == "") {
    //echo "test";
     //create the past due day and monthly cycle date from monthly payment
     $cycle_day = date("d", strtotime($cycle_date));
     $pastDueDay = $past_day + $cycle_day;
     $cycleMonth = date("m", strtotime($cycle_date));
     $cycleYear = date("Y", strtotime($cycle_date));
     $monthlyPaymentsDueDate= date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $cycleMonth, $pastDueDay, $cycleYear));
     $monthlyPaymentsDueDateSecs = strtotime($monthlyPaymentsDueDate);
   
// $this->testSecs = "$monthlyPaymentsDueDateSecs <br> $todaysDateSecs";
     
      if($todaysDateSecs >= $monthlyPaymentsDueDateSecs) {
         $nextPaymentDueDate = $monthlyPaymentsDueDate;
         $todaysDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), date("d"), date("Y")));
           $datetime1 = new DateTime($nextPaymentDueDate);
           $datetime2 = new DateTime($todaysDate);
           $interval = $datetime1-> diff($datetime2);                    
           $daysPastDue = $interval-> format('%d');
           $monthsPastDue = $interval-> format('%m');
           $yearsPastDue = $interval-> format('%y');
           
       //  $testSecs =  "dgdfgf $monthsPastDue";
           
           if($monthsPastDue >= 1) {
           
               if($yearsPastDue >= 1) {
                  $months = $yearsPastDue * 12;  
                  $monthsPastDue = $monthsPastDue + $months;
                  if($yearText > 1){
                    $yearText = "$yearsPastDue Years and ";
                  }else if($yearText == 1){
                    $yearText = "$yearsPastDue Year and ";
                  }else{
                    $yearText = "";
                  }
                  
                 }
                                  
             $pastDueTotal = ($monthlyPayment * $monthsPastDue) + $lateFee;
             $pastDueTotal = sprintf("%01.2f", $pastDueTotal);             
             }else{
                $pastDueTotal = 0;
             }
        }     
     
  }

if($count <= 0){
    $renewText = "Monthly Buyout";
    if($pastDueTotal > 0){
        $pastDueHtml = "<p><b>Your monthly membership is past Due $<span id=\"pastDueAmount\">$pastDueTotal</span>&nbsp; for being $yearText $monthsPastDue months behind.</b></p>"; 
    }
    if($buyOut > 0){
        $buyOutHtml = "<p><b>Your monthly membership still has $numMonths month(s) left on its term to continue $<span id=\"buyOutAmount\">$buyOut</span>&nbsp; will be added to the cost of the membership.</b></p>"; 
    }
}else{
    $pastDueHtml = "";
    $buyOutHtml = "";
}



     ?>
    <style>
    .row {
    
    text-align: center;
    }
    .large-4 {
    width: 100%;
    }
</style>
    <script>
        $(document).ready(function(){
    //alert('fu');
   var contractKey = $("#contractKey").val();
   var count = $("#counter").val();
   if (contractKey == ""){
    // alert("You must be logged in to use this page! You will be redirected to the home screen. Please click Member Sign-In then proceed.");
    // location.href = 'index.php';
    
     $('#error').html('You must be logged in to use this page! Please click Member Sign-In at the top of the screen then click renew.');
     $("#error").css( { "color" : "red"} );
     $('#purchase').prop('disabled', true);
     return false;
   }
   if (count == "0"){
    
     $('#error').html('You have a monthly membership and cannot renew your membership at this time. Please call your local club for options that you have.');
     $("#error").css( { "color" : "red"} );
     $('#purchase').prop('disabled', true);
     return false;
   }
   var selectedServiceQuanntity = $("#selectedQuantity").val();
   
   /*var serviceQuantity = $("#service_quantity").val();
   if (serviceQuantity == 1){
    var yearSelected = 0;
   }else if (serviceQuantity == 2){
    var yearSelected = 1;
   }else if (serviceQuantity == 3){
    var yearSelected = 2;
   }*/
   //alert(serviceQuantity+' '+yearSelected);
$('input:radio[name=yearOptions1]:nth('+selectedServiceQuanntity+')').attr('checked',true);
});
//===================================================================================================

//===================================================================================================

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=yearOptions1]');
    radios1.on('change', function() {
    yearValue1 = $('input:radio[name=yearOptions1]:checked').val();    
        var serviceName = $("#membership1").html();
        serviceName = serviceName.replace("<span id=\"membership1\">", "");
        serviceName = serviceName.replace("</span>", "");
        $('input[name=quantity1]').val(0);
        var starDate = $("#start_date").val();
        var discount = $("#discount").val();
        
        //alert('name'+serviceName+' yearVal '+yearValue1+' start '+starDate+' discount '+discount);
        
        $.ajax ({
                type: "POST",
                url: "php/loadRenewalPricing.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, service_name: serviceName, service_quantity: yearValue1, starDate: starDate, discount: discount},               
                     success: function(data) {  
//alert(data);
                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var price = dataArray[1];
                     var totPrice = dataArray[2];
                     var termText = dataArray[3];
                     var endDate = dataArray[4];
                     var newDiscount = dataArray[5];
                     
                          if(successBit == 1) {                             
                             $("#cost1").html('$'+price);
                             $("#total1").html('$'+totPrice);     
                             $("#pifYears1").html(yearValue1+' '+termText+'');
                             $("#newEndDate").html(endDate);
                             $("#discountText").html(newDiscount);
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});


//===============================================================================================================
$(document).ready(function(){

$('#purchase').click(function() {
    
var serviceName1 = $("#membership1").html();
 var servName = serviceName1.split('&');
var locationArr = servName[2].split(';');
serviceName1 = ""+servName[0]+"-"+locationArr[1];
serviceName1 = serviceName1.replace("<span id=\"membership1\">", "");
serviceName1 = serviceName1.replace("</span>", "");

var yearValue1 = $('input:radio[name=yearOptions1]:checked').val();  
//alert(yearValue1);
//return false;
var totalSale1 = $("#total1").html();
totalSale1 = totalSale1.replace("<span id=\"total1\">", "");
totalSale1 = totalSale1.replace("</span>", "");  
totalSale1 = totalSale1.replace("$", "");

//alert(locationArr[1]);
//alert(serviceName1);
/*if(serviceName1 != null){
   
var numberMemberships1 = $("input[name=quantity1]").val();



if (yearValue1 == undefined){
    var yearValue1 = $("#pifYears1").html();
    yearValue1 = yearValue1.replace("<span id=\"pifYears1\">", "");
    yearValue1 = yearValue1.replace("</span>", "");  
}
}
    
*/

var ajaxSwitch = 1;

 //alert(numMembershipArray);
location.href = 'renewalSalesForm.php?service_name='+serviceName1+'&service_quantity='+yearValue1+'&service_cost='+totalSale1+'&ajax_switch='+ajaxSwitch+'&serviceKey='+serviceKey; 

          

});
//--------------------------------------------------------------------------------------



 });
 //===============================================================================================================
    </script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Renew</h1></div>
    
    <?php
   

//include"../../dbConnect.php";


$contractKey = $_SESSION['userContractKey'];

$stmt = $dbMain ->prepare("SELECT box_color, text_color FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($boxColor, $textColor);
$stmt->fetch();
$stmt->close();
 
 
$stmt = $dbMain ->prepare("SELECT renewal_fee_single, renewal_percent, early_renewal_percent, early_renewal_grace, standard_renewal_grace FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($renewal_fee_single_two, $renewal_percent, $early_renewal_percent, $early_renewal_grace, $standard_renewal_grace);
$stmt->fetch();
$stmt->close();

//echo "$renewal_fee_single_two";
 
 if($renewal_fee_single_two != '0.00'){
    $pifProcessFeeHtml1 = "<p><b>Renewal Fee: &nbsp; <span id=\"process1\">$$renewal_fee_single_two</span></b></p>";
    }else{
    $pifProcessFeeHtml1 = "";
    }
 
$stmt = $dbMain-> prepare("SELECT service_key, MAX(end_date), service_quantity, service_term, unit_renew_rate, club_id, service_name FROM paid_full_services WHERE contract_key = '$contractKey' AND service_name LIKE '%Membership%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $end_date, $service_quantity, $service_term, $unit_renew_rate, $club_id, $service_name);
$stmt->fetch();
$stmt->close();

//echo "$end_date $contractKey";

$startDate = $end_date;

$totalDue1 = sprintf("%.2f", $unit_renew_rate + $renewal_fee_single_two);
 
$gracePeriodSeconds = $standard_renewal_grace * 86400;
$startDateSeconds = strtotime($startDate);
$endDateSecs =  strtotime($end_date);
$todaysDateSeconds = time();


//check to see if eligible
$renewalLimitSeconds = $startDateSeconds + $gracePeriodSeconds;

//echo "<br> nowSecs $todaysDateSeconds end $endDateSecs  renwal peroid $renewalLimitSeconds<br>";

  if(($todaysDateSeconds > $endDateSecs) && ($todaysDateSeconds <= $renewalLimitSeconds)) {
    //echo "standard renew";
    $startDate = date("Y-m-d H:i:s");
    $renewalBool = 1;  //norm renew
    $discount =  sprintf("%.2f",(($renewal_percent/100)*$unit_renew_rate));
    $totalDue1 = sprintf("%.2f", $unit_renew_rate + $renewal_fee_single_two - $discount);
    $renewText = "Standard Renewal";
    
    $discountText = "$discount";
    $discountPercent = $renewal_percent;
    $cost1 = sprintf("%.2f", $unit_renew_rate-$discount);
    
    }elseif(($todaysDateSeconds > $endDateSecs) && ($todaysDateSeconds > $renewalLimitSeconds)){
      //  echo "experired renew";
        $startDate = date("Y-m-d H:i:s");
        $renewalBool = 0;  //expired re-enroll
        
        $stmt = $dbMain-> prepare("SELECT service_cost  FROM service_cost WHERE service_key = '$service_key' AND service_quantity = '$service_quantity'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_cost);
        $stmt->fetch();
        $stmt->close();
        
        $unit_renew_rate = $service_cost;
        
        $totalDue1 = sprintf("%.2f", $service_cost + $renewal_fee_single_two);
        
        $renewText = "Expired/ Re-Enroll";
        $discountText = "0";
        $cost1 = sprintf("%.2f", $unit_renew_rate);
    }else{
       // echo "early renew";
        //early renew
        $discount =  sprintf("%.2f",(($early_renewal_percent/100)*$unit_renew_rate));
        $renewalBool = 2;  //norm renew
        $totalDue1 = sprintf("%.2f", $unit_renew_rate + $renewal_fee_single_two - (($early_renewal_percent/100)*$unit_renew_rate));
        $renewText = "Early Renewal";
        $discountText = "$discount";
        $discountPercent = $early_renewal_percent;
        
        $cost1 = sprintf("%.2f", $unit_renew_rate-$discount);
    }
    
$startFormatted = date('F j Y',strtotime($startDate));
$endDateFormatted = date('F j Y',strtotime($end_date));


$descrip1 = "New Start Date: &nbsp;&nbsp;&nbsp;$startFormatted";
$endDateText = "Current End Date: &nbsp;&nbsp;&nbsp;$endDateFormatted";



switch($service_term){
    case 'C':
        if ($service_quantity == 1){
            $service_term_text = "Class";
        }else{
            $service_term_text = "Classes";
        }
        
    break;
    case 'D':
        if ($service_quantity == 1){
            $service_term_text = "Day";
        }else{
            $service_term_text = "Days";
        }
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($startFormatted)),date('d',strtotime($startFormatted))+$service_quantity,date('Y',strtotime($startFormatted))));
        
    break;
    case 'W':
        if ($service_quantity == 1){
            $service_term_text = "Week";
        }else{
            $service_term_text = "Weeks";
        }
        $days = $service_quantity*7;
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($startFormatted)),date('d',strtotime($startFormatted))+$days,date('Y',strtotime($startFormatted))));
        
    break;
    case 'Y':
        if ($service_quantity == 1){
            $service_term_text = "Year";
        }else{
            $service_term_text = "Years";
        }
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($startFormatted)),date('d',strtotime($startFormatted)),date('Y',strtotime($startFormatted))+$service_quantity));
        
    break;
}
$newEndDateText = " $newEndDateFormatted";

if ($club_id != 0){
    $stmt = $dbMain-> prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_name);
    $stmt->fetch();
    $stmt->close();
}else{
    $club_name = "All Locations";
}



$priceText1 = "for <span id=\"pifYears1\">$service_quantity&nbsp; $service_term_text</span> ";
$proRateHtml1 = "";
$pro_rate_amount1 = 0;

$yearRadioButtons1 = "<div class=\"radButtons\">
                            <b>";

$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_quantity, service_term FROM service_cost WHERE service_key = '$service_key'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_quantityNew, $service_termNew);
while($stmt->fetch()){
    if($service_quantity == $service_quantityNew){
            $selectedQuantity = $counter;
        }
    switch($service_termNew){
    case 'C':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Class";
        }else{
            $service_term_textNew = "Classes";
        }
        
            $yearRadioButtons1 .= " <input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantityNew\">&nbsp;$service_quantityNew $service_term_textNew</input><br>";
            $counter++;
        
        
    break;
    case 'D':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Day";
        }else{
            $service_term_textNew = "Days";
        }
        if($service_quantityNew <= "365"){
            $yearRadioButtons1 .= " <input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantityNew\">&nbsp;$service_quantityNew $service_term_textNew</input><br>";
            $counter++;
        }
        
    break;
    case 'W':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Week";
        }else{
            $service_term_textNew = "Weeks";
        }
        if($service_quantityNew <= "52"){
            $yearRadioButtons1 .= " <input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantityNew\">&nbsp;$service_quantityNew $service_term_textNew</input><br>";
            $counter++;
        }
        
    break;
    case 'Y':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Year";
            $yearRadioButtons1 .= " <input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantityNew\">&nbsp;$service_quantityNew $service_term_textNew</input><br>";
            $counter++;
        }else{
            $service_term_textNew = "Years";
        }
        
        
    break;
}
    
}
$stmt->close();

$yearRadioButtons1 .= "</b>
                           </div>";
if ($discountPercent !=0){                          
$discountStuff = "<p><b>You Save: $<span id=\"discountText\">$discountText</span></b></p>
                    <p><b>Discount : $discountPercent %</b></p>";
    } 

     $divBoxes = "<div class=\"row\">
                    <span id=\"error\"></span>
                    
                    
                <div class=\"small-12 large-4 columns\">
                <ul class=\"pricing-table\">
                    <p><b><span id=\"membership1\"> $service_name&nbsp;<br><br>&nbsp;$club_name</span></b></p>
                    <p><b><u><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></u></b></p>
                    <p><b>$renewText</b></p>
                    $discountStuff
                    <p><b><u><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></u></b></p>
                    <br>                                                
                    <p><b>$endDateText</b></p>
                    <p><b>$descrip1</b></p>
                    <p><b>New End Date:&nbsp;&nbsp;&nbsp;<span id=\"newEndDate\">$newEndDateText</span></b></p>
                   <p><b><u><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></u></b></p>
                    <p><b><span id=\"cost1\">$$cost1</span></b>&nbsp;&nbsp;&nbsp;&nbsp;<b>$priceText1</b></p>
                   
                    
                    $pifProcessFeeHtml1
                    <br>
                    <p><b>Total Due Today:</b></p>
                   <p><b><span id=\"total1\">$$totalDue1</span></b></p>
                   <p><b><u><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></u></b></p>
                    $yearRadioButtons1
                    </ul>
                    <input type='button' value='Renew' id='purchase' class='button' field='number_memberships'/><input type='button' value='Go Back' id='back' class='button' field='none' onclick=\"location.href = 'index.php';\"/>
                    </div>
                    </div>
                    
                     <input type=\"hidden\" name=\"contractKey\" id=\"contractKey\" value=\"$contractKey\"/>
                    <input type=\"hidden\" name=\"service_quantity\" id=\"service_quantity\" value=\"$service_quantity\"/>
                    <input type=\"hidden\" name=\"start_date\" id=\"start_date\" value=\"$startDate\"/>
                    <input type=\"hidden\" name=\"discount\" id=\"discount\" value=\"$discountPercent\"/>
                    <input type=\"hidden\" name=\"selectedQuantity\" id=\"selectedQuantity\" value=\"$selectedQuantity\"/>
                    <input type=\"hidden\" name=\"serviceKey\" id=\"serviceKey\" value=\"$service_key\"/>
                    <input type=\"hidden\" name=\"counter\" id=\"counter\" value=\"$count\"/>";
                    
  
   
 echo $divBoxes;
    ?>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>