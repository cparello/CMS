<?php
session_start();
$club_id = $_REQUEST['club_id'];

include"../../dbConnect.php";
include"loadWebsitePreferences.php";
include "loadStuff.php"; 
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$stmt = $dbMain ->prepare("SELECT number_memberships, membership1, membership2, membership3, membership4, membership5, membership6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($numberMemberships, $membership1, $membership2, $membership3, $membership4, $membership5, $membership6, $descrip1, $descrip2, $descrip3, $descrip4, $descrip5, $descrip6, $boxColor, $textColor);
$stmt->fetch();
$stmt->close();
//echo "test";
$stmt = $dbMain ->prepare("SELECT process_fee_single, process_fee_single_two FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($monthly_process_fee, $pif_process_fee);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($homeClubName);
$stmt->fetch();
$stmt->close();

if($monthly_process_fee != '0.00'){
    $monthlyProcessFeeHtml1 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process1\">$$monthly_process_fee</span></b></p>";
    $monthlyProcessFeeHtml2 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process2\">$$monthly_process_fee</span></b></p>";
    $monthlyProcessFeeHtml3 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process3\">$$monthly_process_fee</span></b></p>";
    $monthlyProcessFeeHtml4 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process4\">$$monthly_process_fee</span></b></p>";
    $monthlyProcessFeeHtml5 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process5\">$$monthly_process_fee</span></b></p>";
    $monthlyProcessFeeHtml6 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process6\">$$monthly_process_fee</span></b></p>";
}else{
    $monthlyProcessFeeHtml1 = "";
    $monthlyProcessFeeHtml2 = "";
    $monthlyProcessFeeHtml3 = "";
    $monthlyProcessFeeHtml4 = "";
    $monthlyProcessFeeHtml5 = "";
    $monthlyProcessFeeHtml6 = "";
    }

if($pif_process_fee != '0.00'){
    $pifProcessFeeHtml1 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process1\">$$pif_process_fee</span></b></p>";
    $pifProcessFeeHtml2 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process2\">$$pif_process_fee</span></b></p>";
    $pifProcessFeeHtml3 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process3\">$$pif_process_fee</span></b></p>";
    $pifProcessFeeHtml4 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process4\">$$pif_process_fee</span></b></p>";
    $pifProcessFeeHtml5 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process5\">$$pif_process_fee</span></b></p>";
    $pifProcessFeeHtml6 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee: &nbsp; <span id=\"process6\">$$pif_process_fee</span></b></p>";
}else{
    $pifProcessFeeHtml1 = "";
    $pifProcessFeeHtml2 = "";
    $pifProcessFeeHtml3 = "";
    $pifProcessFeeHtml4 = "";
    $pifProcessFeeHtml5 = "";
    $pifProcessFeeHtml6 = "";
    }



$memArray1 = explode('-',$membership1);
$memArray1[0] = trim($memArray1[0]);
//echo "$memArray1[0]";
$mem1 = $memArray1[0];
$loc1 = $memArray1[1];
if(preg_match('/All/i',$memArray1[1])){
    $clubIdLocal = "0";
    $club_name1 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name1 = $homeClubName;
}
//echo "$mem1 $clubIdLocal $loc1";
if(preg_match('/monthly/i',$mem1)){
    $sql1 = "AND service_quantity = '12'";
}else{$sql1 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem1' $sql1 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key1, $service_type1, $club_id1, $service_cost1, $service_term1, $service_quantity1);
$stmt->fetch();
$rowCount1 = $stmt->num_rows;
$stmt->close();
if($rowCount1 == 0){
    $loc1 = trim($loc1);
     $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name1 = $loc1;
   // echo "fix $club_id_servicefix";
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem1' $sql1 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key1, $service_type1, $club_id1, $service_cost1, $service_term1, $service_quantity1);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term1 == "M"){
    $cost1 = sprintf("%.2f", $service_cost1/$service_quantity1);
    $priceText1 = "a month for<span id=\"pifYears1\"> 12 Months</span>";
     $monthly_amount = trim($cost1);
     $current_day_number = date(d);
     $month_days_number = date(t);
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount1 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml1 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee: &nbsp;<span id=\"prorate1\">$$pro_rate_amount1</span></b></p>";
     $monthlyPaymentHtml1 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month:&nbsp;$$cost1</b></p>";
}else{
    $cost1 = $service_cost1;
    $priceText1 = "for <span id=\"pifYears1\">1 Year</span> ";
    $proRateHtml1 = "";
    $pro_rate_amount1 = 0;
    $yearRadioButtons1 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions1\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions1\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions1\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</input></b>
                           </div>";
    }

;
$memArray2 = explode('-',$membership2);
$memArray1[0] = trim($memArray2[0]);
//echo "$memArray1[0]";
$mem2 = $memArray2[0];
$loc2 = $memArray2[1];
if(preg_match('/All/i',$memArray2[1])){
   $clubIdLocal = "0";
    $club_name2 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name2 = $homeClubName;
}
//echo "$membership2  $loc2";
if(preg_match('/monthly/i',$mem2)){
    $sql2 = "AND service_quantity = '12'";
}else{$sql2 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem2' $sql2 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key2, $service_type2, $club_id2, $service_cost2, $service_term2, $service_quantity2);
$stmt->fetch();
$rowCount2 = $stmt->num_rows;
$stmt->close();
if($rowCount2 == 0){
    $loc2 = trim($loc2);
    $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc2'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name2 = $loc2;
    
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem2' $sql2 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key2, $service_type2, $club_id2, $service_cost2, $service_term2, $service_quantity2);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term2 == "M"){
    $cost2 = sprintf("%.2f", $service_cost2/$service_quantity2);
    $priceText2 = "a month for <span id=\"pifYears2\">12 Months</span>";
    $monthly_amount = trim($cost2);
     $current_day_number = date('d');
     $month_days_number = date('t');
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount2 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml2 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee:
 &nbsp;<span id=\"prorate2\">$$pro_rate_amount2</span></b></p>";
     $monthlyPaymentHtml2 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month:&nbsp;$$cost2</b></p>";
}else{
    $cost2 = $service_cost2;
    $priceText2 = "for <span id=\"pifYears2\">1 Year</span> ";
    $proRateHtml2 = "";
    $pro_rate_amount2 = 0;
    $yearRadioButtons2 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions2\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions2\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions2\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</span></input></b>
                           </div>";
    }



$memArray3 = explode('-',$membership3);
$memArray3[0] = trim($memArray3[0]);
//echo "$memArray1[0]";
$mem3 = $memArray3[0];
$loc3 = $memArray3[1];
if(preg_match('/All/i',$memArray3[1])){
    $clubIdLocal = "0";
    $club_name3 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name3 = $homeClubName;
}
if(preg_match('/monthly/i',$mem3)){
    $sql3 = "AND service_quantity = '12'";
}else{$sql3 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem3' $sql3 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key3, $service_type3, $club_id3, $service_cost3, $service_term3, $service_quantity3);
$stmt->fetch();
$rowCount3 = $stmt->num_rows;
$stmt->close();
if($rowCount3 == 0){
    $loc3 = trim($loc3);
    $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc3'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name3 = $loc3;
    
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem3' $sql3 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key3, $service_type3, $club_id3, $service_cost3, $service_term3, $service_quantity3);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term3 == "M"){
    $cost3 = sprintf("%.2f", $service_cost3/$service_quantity3);
    $priceText3 = "a month for <span id=\"pifYears3\">12 Months</span>";
    $monthly_amount = trim($cost3);
     $current_day_number = date(d);
     $month_days_number = date(t);
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount3 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml3 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee:
     &nbsp;<span id=\"prorate3\">$$pro_rate_amount3</span></b></p>";
     $monthlyPaymentHtml3 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month:&nbsp;$$cost3</b></p>";
}else{
    $cost3 = $service_cost3;
    $priceText3 = "for <span id=\"pifYears3\">1 Year</span> ";
    $proRateHtml3 = "";
    $pro_rate_amount3 = 0;
    $yearRadioButtons3 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions3\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions3\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions3\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</span></input></b>
                           </div>";
    }


$memArray4 = explode('-',$membership4);
$memArray4[0] = trim($memArray4[0]);
//echo "$memArray1[0]";
$mem4 = $memArray4[0];
$loc4 = $memArray4[1];
if(preg_match('/All/i',$memArray4[1])){
    $clubIdLocal = "0";
    $club_name4 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name4 = $homeClubName;
}
if(preg_match('/monthly/i',$mem4)){
    $sql4 = "AND service_quantity = '12'";
}else{$sql4 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem4' $sql4 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key4, $service_type4, $club_id4, $service_cost4, $service_term4, $service_quantity4);
$stmt->fetch();
$rowCount4 = $stmt->num_rows;
$stmt->close();
if($rowCount4 == 0){
    $loc4 = trim($loc4);
     $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc4'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name4 = $loc4;
    
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem4' $sql4 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key4, $service_type4, $club_id4, $service_cost4, $service_term4, $service_quantity4);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term4 == "M"){
    $cost4 = sprintf("%.2f", $service_cost4/$service_quantity4);
    $priceText4 = "a month for<span id=\"pifYears4\"> 12 Months</span>";
    $monthly_amount = trim($cost4);
     $current_day_number = date(d);
     $month_days_number = date(t);
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount4 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml4 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee:
    &nbsp;<span id=\"prorate4\">$$pro_rate_amount4</span></b></p>";
     $monthlyPaymentHtml4 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month:&nbsp;$$cost4</b></p>";
}else{
    $cost4 = $service_cost4;
    $priceText4 = "for <span id=\"pifYears4\">1 Year</span> ";
    $proRateHtml4 = "";
    $pro_rate_amount4 = 0;
    $yearRadioButtons4 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions4\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions4\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions4\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</span></input></b>
                           </div>";
    }


$memArray5 = explode('-',$membership5);
$memArray5[0] = trim($memArray5[0]);
//echo "$memArray5[0]";
$mem5 = $memArray5[0];
$loc5 = $memArray5[1];
if(preg_match('/All/i',$memArray5[1])){
   $clubIdLocal = "0";
    $club_name5 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name5 = $homeClubName;
}
if(preg_match('/monthly/i',$mem5)){
    $sql5 = "AND service_quantity = '12'";
}else{$sql5 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem5' $sql5 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key5, $service_type5, $club_id5, $service_cost5, $service_term5, $service_quantity5);
$stmt->fetch();
$rowCount5 = $stmt->num_rows;
$stmt->close();
if($rowCount5 == 0){
    $loc5 = trim($loc5);
     $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc5'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name5 = $loc5;
    
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem5' $sql5 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key5, $service_type5, $club_id5, $service_cost5, $service_term5, $service_quantity5);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term5 == "M"){
    $cost5 = sprintf("%.2f", $service_cost5/$service_quantity5);
    $priceText5 = "a month for<span id=\"pifYears5\"> 15 Months</span>";
    $monthly_amount = trim($cost5);
     $current_day_number = date(d);
     $month_days_number = date(t);
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount5 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml5 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee: &nbsp;<span id=\"prorate5\">$$pro_rate_amount5</span></b></p>";
     $monthlyPaymentHtml5 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month:&nbsp; $$cost5</b></p>";
}else{
    $cost5 = $service_cost5;
    $priceText5 = "for <span id=\"pifYears5\">1 Year</span> ";
    $proRateHtml5 = "";
    $pro_rate_amount5 = 0;
    $yearRadioButtons5 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions5\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions5\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions5\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</span></input></b>
                           </div>";
    }

$memArray6 = explode('-',$membership6);
$memArray6[0] = trim($memArray6[0]);
//echo "$memArray6[0]";
$mem6 = $memArray6[0];
$loc6 = $memArray6[1];
if(preg_match('/All/i',$memArray6[1])){
    $clubIdLocal = "0";
    $club_name6 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name6 = $homeClubName;
}
if(preg_match('/monthly/i',$mem6)){
    $sql6 = "AND service_quantity = '12'";
}else{$sql6 = "AND service_quantity = '1'";}
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem6' $sql6 AND club_id = '$clubIdLocal'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key6, $service_type6, $club_id6, $service_cost6, $service_term6, $service_quantity6);
$stmt->fetch();
$rowCount6 = $stmt->num_rows;
$stmt->close();
if($rowCount6 == 0){
    $loc6 = trim($loc6);
    $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$loc6'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($club_id_servicefix);
    $stmt->fetch();
    $stmt->close();
    
    $club_name6 = $loc6;
    
    $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem6' $sql6 AND club_id = '$club_id_servicefix'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($service_key6, $service_type6, $club_id6, $service_cost6, $service_term6, $service_quantity6);
    $stmt->fetch();
    $stmt->close();
}
if ($service_term6 == "M"){
    $cost6 = sprintf("%.2f", $service_cost6/$service_quantity6);
    $priceText6 = "a month for<span id=\"pifYears6\"> 16 Months</span>";
    $monthly_amount = trim($cost6);
     $current_day_number = date(d);
     $month_days_number = date(t);
     $daily_amount = $monthly_amount / $month_days_number;
     $date_difference = $month_days_number - $current_day_number;
     $pro_rate_amount = $date_difference * $daily_amount;
     $pro_rate_amount6 = sprintf("%.2f", $pro_rate_amount);
     if($pro_rate_amount == "" || $pro_rate_amount == 0) {
          $pro_rate_amount = '0.00';
        }
     $proRateHtml6 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Prorate Fee:
&nbsp;<span id=\"prorate6\">$$pro_rate_amount6</span></b></p>";
     $monthlyPaymentHtml6 =  "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>First Month: &nbsp;$$cost6</b></p>";
}else{
    $cost6 = $service_cost6;
    $priceText6 = "for <span id=\"pifYears6\">1 Year</span> ";
    $proRateHtml6 = "";
    $pro_rate_amount6 = 0;
    $yearRadioButtons6 = " <div class=\"radButtons\">
                            <b><input type=\"radio\" name=\"yearOptions6\" value=\"1\"><span style=\"color: #$textColor;\">&nbsp;1 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions6\" value=\"2\"><span style=\"color: #$textColor;\">&nbsp;2 Year</span></input>&nbsp;&nbsp;&nbsp;
                           <input type=\"radio\" name=\"yearOptions6\" value=\"3\"><span style=\"color: #$textColor;\">&nbsp;3 Year</span></input></b>
                           </div>";
    }
    
$stmt = $dbMain ->prepare("SELECT billing_setup FROM billing_setup WHERE setup_id = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing_setup);
$stmt->fetch();
$stmt->close();

if(preg_match('/monthly/i',$membership1)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll1 = "$proRateHtml1$monthlyProcessFeeHtml1";
        $totalDue1 = sprintf("%.2f",$pro_rate_amount1+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll1 = "$proRateHtml1$monthlyPaymentHtml1$monthlyProcessFeeHtml1";
        $totalDue1 = sprintf("%.2f",$pro_rate_amount1+$monthly_process_fee+$cost1); 
    break;
    case 3:
        $monthlyHtmlAll1 = "$monthlyPaymentHtml1$monthlyProcessFeeHtml1";
        $totalDue1 = sprintf("%.2f",$monthly_process_fee+$cost1); 
    break;
}   
} else{
        $monthlyHtmlAll1 = "$pifProcessFeeHtml1";
        $totalDue1 = sprintf("%.2f",$service_cost1+$pif_process_fee); 
}


if(preg_match('/monthly/i',$membership2)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll2 = "$proRateHtml2$monthlyProcessFeeHtml2";
        $totalDue2 = sprintf("%.2f",$pro_rate_amount2+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll2 = "$proRateHtml2$monthlyPaymentHtml2$monthlyProcessFeeHtml2";
        $totalDue2 = sprintf("%.2f",$pro_rate_amount2+$monthly_process_fee+$cost2); 
        //echo"$pro_rate_amount2+$monthly_process_fee+$cost2";
    break;
    case 3:
        $monthlyHtmlAll2 = "$monthlyPaymentHtml2$monthlyProcessFeeHtml2";
        $totalDue2 = sprintf("%.2f",$monthly_process_fee+$cost2); 
    break;
}  
} else{
        $monthlyHtmlAll2 = "$pifProcessFeeHtml2";
        $totalDue2 = sprintf("%.2f",$service_cost2+$pif_process_fee); 
}

if(preg_match('/monthly/i',$membership3)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll3 = "$proRateHtml3$monthlyProcessFeeHtml3";
        $totalDue3 = sprintf("%.2f",$pro_rate_amount3+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll3 = "$proRateHtml3$monthlyPaymentHtml3$monthlyProcessFeeHtml3";
        $totalDue3 = sprintf("%.2f",$pro_rate_amount3+$monthly_process_fee+$cost3); 
        break;
    case 3:
        $monthlyHtmlAll3 = "$monthlyPaymentHtml3$monthlyProcessFeeHtml3";
        $totalDue3 = sprintf("%.2f",$monthly_process_fee+$cost3); 
    break;
}      
} else{
        $monthlyHtmlAll3 = "$pifProcessFeeHtml3";
        $totalDue3 = sprintf("%.2f",$service_cost3+$pif_process_fee); 
}

if(preg_match('/monthly/i',$membership4)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll4 = "$proRateHtml4$monthlyProcessFeeHtml4";
        $totalDue4 = sprintf("%.2f",$pro_rate_amount4+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll4 = "$proRateHtml4$monthlyPaymentHtml4$monthlyProcessFeeHtml4";
        $totalDue4 = sprintf("%.2f",$pro_rate_amount4+$monthly_process_fee+$cost4); 
        break;
    case 3:
        $monthlyHtmlAll4 = "$monthlyPaymentHtml4$monthlyProcessFeeHtml4";
        $totalDue4 = sprintf("%.2f",$monthly_process_fee+$cost4); 
    break;
}      
} else{
        $monthlyHtmlAll4 = "$pifProcessFeeHtml4";
        $totalDue4 = sprintf("%.2f",$service_cost4+$pif_process_fee); 
}

if(preg_match('/monthly/i',$membership5)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll5 = "$proRateHtml5$monthlyProcessFeeHtml5";
        $totalDue5 = sprintf("%.2f",$pro_rate_amount5+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll5 = "$proRateHtml5$monthlyPaymentHtml5$monthlyProcessFeeHtml5";
        $totalDue5 = sprintf("%.2f",$pro_rate_amount5+$monthly_process_fee+$cost5); 
        break;
    case 3:
        $monthlyHtmlAll5 = "$monthlyPaymentHtml5$monthlyProcessFeeHtml5";
        $totalDue5 = sprintf("%.2f",$monthly_process_fee+$cost5); 
    break;
}      
} else{
        $monthlyHtmlAll5 = "$pifProcessFeeHtml5";
        $totalDue5 = sprintf("%.2f",$service_cost5+$pif_process_fee); 
}

if(preg_match('/monthly/i',$membership6)){
switch($billing_setup){
    case 1:
        $monthlyHtmlAll6 = "$proRateHtml6$monthlyProcessFeeHtml6";
        $totalDue6 = sprintf("%.2f",$pro_rate_amount6+$monthly_process_fee); 
    break;
    case 2:
        $monthlyHtmlAll6 = "$proRateHtml6$monthlyPaymentHtml6$monthlyProcessFeeHtml6";  
        $totalDue6 = sprintf("%.2f",$pro_rate_amount6+$monthly_process_fee+$cost6); 
    break;
    case 3:
        $monthlyHtmlAll6 = "$monthlyPaymentHtml6$monthlyProcessFeeHtml6";
        $totalDue6 = sprintf("%.2f",$monthly_process_fee+$cost6);
    break;
}    
} else{
        $monthlyHtmlAll6 = "$pifProcessFeeHtml6";
        $totalDue6 = sprintf("%.2f",$service_cost6+$pif_process_fee); 
}
    

if($numberMemberships == 1){
     $divBoxes = "<div class=\"block s1x1 p1x1\">
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    $monthlyHtmlAll1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                   <br>
                    $yearRadioButtons1
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    
                  </div>";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 410px;                      
    }   ";
   $cssBox2 = "";
   $cssBox3 = "";
   $cssBox4 = "";
   $cssBox5 = "";
   $cssBox6 = "";
   }
if($numberMemberships == 2){
     $divBoxes = 
             "<div class=\"block s1x1 p1x1\">
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
              <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    $monthlyHtmlAll1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                   <br>
                    $yearRadioButtons1
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    <br>
                    
              </div>
              <div class=\"block s1x1 p1x2\">
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership2\"> $service_type2&nbsp;-&nbsp;$club_name2</span></b></p>
              <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip2</b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost2\">$$cost2</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText2</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              
                    $monthlyHtmlAll2
                    <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total2\">$$totalDue2</span></b></p>
                    <br>
                    $yearRadioButtons2
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                        <input type='text' name='quantity2' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                    </form>
                    <br>
                    
              </div>
            ";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 440px;                      
    }   ";
   $cssBox2 = ".p1x2 {                             
    top: 300px;                         
    left: 780px;                      
    }  ";
   $cssBox3 = "";
   $cssBox4 = "";
   $cssBox5 = "";
   $cssBox6 = "";
   }   
if($numberMemberships == 3){
     $divBoxes = 
             "<div class=\"block s1x1 p1x1\">
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
              <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                    <br>
                    $yearRadioButtons1
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    <br>
                    
              </div>
              <div class=\"block s1x1 p1x2\">
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership2\"> $service_type2&nbsp;-&nbsp;$club_name2</span></b></span></p>
              <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip2</b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost2\">$$cost2</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText2</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll2
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total2\">$$totalDue2</span></b></p>
                    <br>
                    $yearRadioButtons2
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                        <input type='text' name='quantity2' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                    </form>
                    <br>
                    
                    
              </div>
              <div class=\"block s1x1 p1x3\">
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership3\"> $service_type3&nbsp;-&nbsp;$club_name3</span></b></span></p>
              <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip3</b></p>
              <br>
              <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost3\">$$cost3</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText3</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                   
                    $monthlyHtmlAll3
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total3\">$$totalDue3</span></b></p>
                    <br>
                    $yearRadioButtons3
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                        <input type='text' name='quantity3' value='0' class='qty'/>
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                    </form>
                    <br>
                    <center><input type='button' value='Purchase'  id='qty' class='buttonPurchase buttonPasses$middleButtons buttonSize' field='number_memberships'/></center>

              </div>";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 260px;                      
    }   ";
   $cssBox2 = "p1x2 {                             
    top: 300px;                         
    left: 620px;                      
    }  ";
   $cssBox3 = "p1x3 {                             
    top: 300px;                         
    left: 985px;                      
    }      ";
   $cssBox4 = "";
   $cssBox5 = "";
   $cssBox6 = "";
   }      
if($numberMemberships == 4){
     $divBoxes = 
                "<div class=\"block s1x1 p1x1\">
                    <p class=\"caption-header txt-gray\" ><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll1
                    <br>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                  <br>
                    $yearRadioButtons1
                     <br>
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty'/>
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <center><input type='button' value='Purchase'  id='qty' class='buttonPurchase buttonPasses$middleButtons buttonSize' field='number_memberships'/></center>
                    
                </div>
                <div class=\"block s1x1 p1x2\">
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership2\"> $service_type2&nbsp;-&nbsp;$club_name2</span></b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip2</b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost2\">$$cost2</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText2</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll2
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total2\">$$totalDue2</span></b></p>
                    <br>
                    $yearRadioButtons2
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                        <input type='text' name='quantity2' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                    </form>
                    <br>
                    
                   
                </div>
                <div class=\"block s1x1 p1x3\">
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership3\">$service_type3&nbsp;-&nbsp;$club_name3</span></b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip3</b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost3\">$$cost3</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText3</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll3
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total3\">$$totalDue3</span></b></p>
     <br>
                    $yearRadioButtons3
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                        <input type='text' name='quantity3' value='0' class='qty'/>
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                    </form>
                    <br>
                    <center><input type='button' value='Purchase'  id='qty' class='buttonPurchase buttonPasses$middleButtons buttonSize' field='number_memberships'/></center>
                </div>
                <div class=\"block s1x1 p2x1\">
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership4\">$service_type4&nbsp;-&nbsp;$club_name4</span></b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip4</b></p>
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost4\">$$cost4</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText4</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll4
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total4\">$$totalDue4</span></b></p>
                    <br>
                    $yearRadioButtons4
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                        <input type='text' name='quantity4' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                    </form>
                    <br>
                    
                </div>";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 460px;                      
    }   ";
   $cssBox2 = "p1x2 {                             
    top: 300px;                         
    left: 620px;                      
    }  ";
   $cssBox3 = "p1x3 {                             
    top: 300px;                         
    left: 985px;                      
    }      ";
   $cssBox4 = "p2x1 {                             
    top: 800px;                         
    left: 410px;                      
    }   ";
   $cssBox5 = "";
   $cssBox6 = "";
   }      
   if($numberMemberships == 5){
     $divBoxes = "<div class=\"block s1x1 p1x1\">
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                    <br>
                    $yearRadioButtons1
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    <br>
                    
    </div>
    <div class=\"block s1x1 p1x2\">
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership2\"> $service_type2&nbsp;-&nbsp;$club_name2</span></b></p>
<p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
<br>
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip2</b></p>
<br>
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost2\">$$cost2</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText2</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll2
                    <br>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                   <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total2\">$$totalDue2</span></b></p>
                    <br>
                    $yearRadioButtons2
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                        <input type='text' name='quantity2' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                    </form>
                    <br>
                    
    </div>
    <div class=\"block s1x1 p1x3\">
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership3\"> $service_type3&nbsp;-&nbsp;$club_name3</span></b></p>
    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip3</b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost3\">$$cost3</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText3</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll3
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total3\">$$totalDue3</span></b></p>
                    <br>
                    $yearRadioButtons3
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                        <input type='text' name='quantity3' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                    </form>
                    <br>
                    
    </div>
    <div class=\"block s1x1 p2x1\">
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership4\"> $service_type4&nbsp;-&nbsp;$club_name4</span></b></p>
    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip4</b></p>
    <br>
    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost4\">$$cost4</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText4</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                   
                    $monthlyHtmlAll4
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total4\">$$totalDue4</span></b></p>
                    <br>
                    $yearRadioButtons4
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                        <input type='text' name='quantity4' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                    </form>
                    <br>
                    
    </div>
    <div class=\"block s1x1 p2x2\">
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership5\"> $service_type5&nbsp;-&nbsp;$club_name5</span></b></p>
<p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
<br>
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip5</b></p>
<br>
<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost5\">$$cost5</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText5</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll5
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total5\">$$totalDue5</span></b></p>
                    <br>
                    $yearRadioButtons5
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity5' field2='cost5' field3='total5' field4='process5' field5='prorate5'/>
                        <input type='text' name='quantity5' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity5' field2='cost5' field3='total5' field4='process5' field5='prorate5'/>
                    </form>
                    <br>
                    
    </div>";
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 260px;                      
    }   ";
   $cssBox2 = "p1x2 {                             
    top: 300px;                         
    left: 620px;                      
    }  ";
   $cssBox3 = "p1x3 {                             
    top: 300px;                         
    left: 985px;                      
    }      ";
   $cssBox4 = "p2x1 {                             
    top: 800px;                         
    left: 440px;                      
    }   ";
   $cssBox5 = "p2x2 {                             
    top: 800px;                         
    left: 720px;                      
    }  ";
   $cssBox6 = "";
   }      
   if($numberMemberships == 6){
   $cssBox1 = "p1x1 {                             
    top: 300px;                         
    left: 260px;                      
    }   ";
   $cssBox2 = "p1x2 {                             
    top: 300px;                         
    left: 620px;                      
    }  ";
   $cssBox3 = "p1x3 {                             
    top: 300px;                         
    left: 985px;                      
    }      ";
   $cssBox4 = "p2x1 {                             
    top: 800px;                         
    left: 260px;                      
    }   ";
   $cssBox5 = "p2x2 {                             
    top: 800px;                         
    left: 620px;                      
    }  ";
   $cssBox6 = "p2x3 {                             
    top: 800px;                         
    left: 985px;                      
    }  ";
    $divBoxes = "<div class=\"block s1x1 p1x1\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $service_type1&nbsp;-&nbsp;$club_name1</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip1</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost1\">$$cost1</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText1</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll1
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total1\">$$totalDue1</span></b></p>
                    <br>
                    $yearRadioButtons1
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                        <input type='text' name='quantity1' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity1' field2='cost1' field3='total1' field4='process1' field5='prorate1'/>
                    </form>
                    <br>
                    
                </div>
                <div class=\"block s1x1 p1x2\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership2\"> $service_type2&nbsp;-&nbsp;$club_name2</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip2</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost2\">$$cost2</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText2</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll2
                    <br>
                  <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                  <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total2\">$$totalDue2</span></b></p>
                  <br>
                    $yearRadioButtons2
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                        <input type='text' name='quantity2' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity2' field2='cost2' field3='total2' field4='process2' field5='prorate2'/>
                    </form>
                    <br>
                    
                </div>
                <div class=\"block s1x1 p1x3\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership3\"> $service_type3&nbsp;-&nbsp;$club_name3</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip3</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost3\">$$cost3</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText3</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll3
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total3\">$$totalDue3</span></b></p>
                    <br>
                    $yearRadioButtons3
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                        <input type='text' name='quantity3' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity3' field2='cost3' field3='total3' field4='process3' field5='prorate3'/>
                    </form>
                    <br>
                    
                </div>
                <div class=\"block s1x1 p2x1\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership4\"> $service_type4&nbsp;-&nbsp;$club_name4</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip4</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost4\">$$cost4</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText4</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll4
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total4\">$$totalDue4</span></b></p>
                    <br>
                    $yearRadioButtons4
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                        <input type='text' name='quantity4' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity4' field2='cost4' field3='total4' field4='process4' field5='prorate4'/>
                    </form>
                    <br>
                    
                </div>
                <div class=\"block s1x1 p2x2\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership5\"> $service_type5&nbsp;-&nbsp;$club_name5</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip5</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost5\">$$cost5</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText5</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll5
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total5\">$$totalDue5</span></b></p>
                    <br>
                    $yearRadioButtons5
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                   
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity5' field2='cost5' field3='total5' field4='process5' field5='prorate5'/>
                        <input type='text' name='quantity5' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity5' field2='cost5' field3='total5' field4='process5' field5='prorate5'/>
                    </form>
                    <br>
                    
                </div>
                <div class=\"block s1x1 p2x3\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:20px;\"><b><span id=\"membership6\"> $service_type6&nbsp;-&nbsp;$club_name6</span></b></p>
                <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$descrip6</b></p>
                <br>
                <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:30px;\"><b><span id=\"cost6\">$$cost6</span></b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>$priceText6</b></p>
                    <p class=\"caption-header txt-gray\"><b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></p>
                    
                    $monthlyHtmlAll6
                    <br>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Total Due Today:</b></p>
                    <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:25px;\"><b><span id=\"total6\">$$totalDue6</span></b></p>
                   <br>
                    $yearRadioButtons6
                     <br>
                     <p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Quantity:</b></p>                                          
                    <form id='myform' method='POST' action='#'>
                        <input type='button' value='-' class='qtyminus buttonPasses$middleButtons buttonSize'  field='quantity6' field2='cost6' field3='total6' field4='process6' field5='prorate6'/>
                        <input type='text' name='quantity6' value='0' class='qty' />
                        <input type='button' value='+' class='qtyplus buttonPasses$middleButtons buttonSize'  field='quantity6' field2='cost6' field3='total6' field4='process6' field5='prorate6'/>
                    </form>
                    <br>
                    
                </div>";
               }      
               




include "webTemplates/joinPageTemplate.php";

?>