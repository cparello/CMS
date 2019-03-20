<?php
session_start();

include"../../dbConnect.php";
include"loadWebsitePreferences.php";
include "loadStuff.php"; 
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

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
    $pifProcessFeeHtml1 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Renewal Fee: &nbsp; <span id=\"process1\">$$renewal_fee_single_two</span></b></p>";
    }else{
    $pifProcessFeeHtml1 = "";
    }
 
$stmt = $dbMain-> prepare("SELECT service_key, MAX(end_date), service_quantity, service_term, unit_renew_rate, club_id, service_name FROM paid_full_services WHERE contract_key = '$contractKey' AND service_name LIKE '%Membership%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $end_date, $service_quantity, $service_term, $unit_renew_rate, $club_id, $service_name);
$stmt->fetch();
$stmt->close();

echo "$end_date $contractKey";

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
        
        
    break;
    case 'D':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Day";
        }else{
            $service_term_textNew = "Days";
        }
        
        
    break;
    case 'W':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Week";
        }else{
            $service_term_textNew = "Weeks";
        }
        
        
    break;
    case 'Y':
        if ($service_quantityNew == 1){
            $service_term_textNew = "Year";
        }else{
            $service_term_textNew = "Years";
        }
        
        
    break;
}
    $yearRadioButtons1 .= " <input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantityNew\"><span style=\"color: #$textColor;\">&nbsp;$service_quantityNew $service_term_textNew</input>&nbsp;&nbsp;&nbsp;<br>";
    $counter++;
}
$stmt->close();

$yearRadioButtons1 .= "</b>
                           </div>";
if ($discountPercent !=0){                          
$discountStuff = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>You Save: $<span id=\"discountText\">$discountText</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Discount : $discountPercent %</b></p>";
    } 

     $divBoxes = "<div class=\"block s1x1 p1x1\">
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_name&nbsp;<br><br>&nbsp;$club_name</span></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$renewText</b></p>
                    $discountStuff
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>                                                
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$endDateText</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>New End Date:&nbsp;&nbsp;&nbsp;<span id=\"newEndDate\">$newEndDateText</span></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    $pifProcessFeeHtml1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                   <br>
                    $yearRadioButtons1
                    </div>";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 625px;                      
    }   ";
   

  
    
                  
               


 

include "webTemplates/renewPageTemplate.php";

?>