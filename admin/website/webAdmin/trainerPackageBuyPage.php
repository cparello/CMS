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

 if(!isset($_SESSION['userContractKey'])){
                    $alreadyMember = 0;
                    }else{
                        $alreadyMember = 1;
                    }

$stmt = $dbMain ->prepare("SELECT number_packages, package1, package2, package3, package4, package5, package6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color FROM website_training_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($numberMemberships, $package1, $package2, $package3, $package4, $package5, $package6, $descrip1, $descrip2, $descrip3, $descrip4, $descrip5, $descrip6, $boxColor, $textColor);
$stmt->fetch();
$stmt->close();
//echo "test";
$stmt = $dbMain ->prepare("SELECT upgrade_fee_single FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($upgrade_fee_single);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($homeClubName);
$stmt->fetch();
$stmt->close();

if($upgrade_fee_single != '0.00'){
    $upgradeFeeHtml1 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process1\">$$upgrade_fee_single</span></b></p>";
    $upgradeFeeHtml2 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process2\">$$upgrade_fee_single</span></b></p>";
    $upgradeFeeHtml3 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process3\">$$upgrade_fee_single</span></b></p>";
    $upgradeFeeHtml4 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process4\">$$upgrade_fee_single</span></b></p>";
    $upgradeFeeHtml5 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process5\">$$upgrade_fee_single</span></b></p>";
    $upgradeFeeHtml6 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process6\">$$upgrade_fee_single</span></b></p>";
}else{
    $upgradeFeeHtml1 = "";
    $upgradeFeeHtml2 = "";
    $upgradeFeeHtml3 = "";
    $upgradeFeeHtml4 = "";
    $upgradeFeeHtml5 = "";
    $upgradeFeeHtml6 = "";
    }




$memArray1 = explode('-',$package1);
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

$yearRadioButtons1 = " <div class=\"radButtons\">";
//echo "$mem1 $clubIdLocal $loc1";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem1' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key1, $service_type1, $club_id1, $service_cost1, $service_term1, $service_quantity1);
while($stmt->fetch()){
    if ($service_term1 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity1 == 1){
        $termText = "Class";
    }
    
    $yearRadioButtons1 .= "<b><input type=\"radio\" name=\"yearOptions1\" value=\"$service_quantity1\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity1 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost1 = $service_cost1;
$priceText1 = "for <span id=\"pifYears1\">$service_quantity1 $termText</span> ";
$yearRadioButtons1 .=   "</div>";
    

$memArray2 = explode('-',$package2);
$memArray2[0] = trim($memArray2[0]);
//echo "$memArray2[0]";
$mem2 = $memArray2[0];
$loc2 = $memArray2[1];
if(preg_match('/All/i',$memArray2[1])){
    $clubIdLocal = "0";
    $club_name2 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name2 = $homeClubName;
}

$yearRadioButtons2 = " <div class=\"radButtons\">";
//echo "$mem2 $clubIdLocal $loc2";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem2' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key2, $service_type2, $club_id2, $service_cost2, $service_term2, $service_quantity2);
while($stmt->fetch()){
    if ($service_term2 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity2 == 1){
        $termText = "Class";
    }
    $yearRadioButtons2 .= "<b><input type=\"radio\" name=\"yearOptions2\" value=\"$service_quantity2\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity2 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost2 = $service_cost2;
$priceText2 = "for <span id=\"pifYears2\">$service_quantity2 $termText</span> ";
$yearRadioButtons2 .=   "</div>";



$memArray3 = explode('-',$package3);
$memArray3[0] = trim($memArray3[0]);
//echo "$memArray3[0]";
$mem3 = $memArray3[0];
$loc3 = $memArray3[1];
if(preg_match('/All/i',$memArray3[1])){
    $clubIdLocal = "0";
    $club_name3 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name3 = $homeClubName;
}

$yearRadioButtons3 = " <div class=\"radButtons\">";
//echo "$mem3 $clubIdLocal $loc3";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem3' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key3, $service_type3, $club_id3, $service_cost3, $service_term3, $service_quantity3);
while($stmt->fetch()){
    if ($service_term3 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity3 == 1){
        $termText = "Class";
    }
    $yearRadioButtons3 .= "<b><input type=\"radio\" name=\"yearOptions3\" value=\"$service_quantity3\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity3 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost3 = $service_cost3;
$priceText3 = "for <span id=\"pifYears3\">$service_quantity3 $termText</span> ";
$yearRadioButtons3 .=   "</div>";


$memArray4 = explode('-',$package4);
$memArray4[0] = trim($memArray4[0]);
//echo "$memArray4[0]";
$mem4 = $memArray4[0];
$loc4 = $memArray4[1];
if(preg_match('/All/i',$memArray4[1])){
    $clubIdLocal = "0";
    $club_name4 = "All Locations";
}else{
    $clubIdLocal = "$club_id";
    
    $club_name4 = $homeClubName;
}

$yearRadioButtons4 = " <div class=\"radButtons\">";
//echo "$mem4 $clubIdLocal $loc4";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem4' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key4, $service_type4, $club_id4, $service_cost4, $service_term4, $service_quantity4);
while($stmt->fetch()){
    if ($service_term4 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity4 == 1){
        $termText = "Class";
    }
    $yearRadioButtons4 .= "<b><input type=\"radio\" name=\"yearOptions4\" value=\"$service_quantity4\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity4 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost4 = $service_cost4;
$priceText4 = "for <span id=\"pifYears4\">$service_quantity4 $termText</span> ";
$yearRadioButtons4 .=   "</div>";


$memArray5 = explode('-',$package5);
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

$yearRadioButtons5 = " <div class=\"radButtons\">";
//echo "$mem5 $clubIdLocal $loc5";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem5' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key5, $service_type5, $club_id5, $service_cost5, $service_term5, $service_quantity5);
while($stmt->fetch()){
    if ($service_term5 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity5 == 1){
        $termText = "Class";
    }
    $yearRadioButtons5 .= "<b><input type=\"radio\" name=\"yearOptions5\" value=\"$service_quantity5\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity5 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost5 = $service_cost5;
$priceText5 = "for <span id=\"pifYears5\">$service_quantity5 $termText</span> ";
$yearRadioButtons5 .=   "</div>";

$memArray6 = explode('-',$package6);
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

$yearRadioButtons6 = " <div class=\"radButtons\">";
//echo "$mem6 $clubIdLocal $loc6";
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem6' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key6, $service_type6, $club_id6, $service_cost6, $service_term6, $service_quantity6);
while($stmt->fetch()){
    if ($service_term6 == "C"){
        $termText = "Classes";
    }
    if ($service_quantity6 == 1){
        $termText = "Class";
    }
    $yearRadioButtons6 .= "<b><input type=\"radio\" name=\"yearOptions6\" value=\"$service_quantity6\"><span style=\"color: #$textColor;\">&nbsp;$service_quantity6 $termText</input>&nbsp;&nbsp;&nbsp;</b><br>";
}
$stmt->close();
$cost6 = $service_cost6;
$priceText6 = "for <span id=\"pifYears6\">$service_quantity6 $termText</span> ";
$yearRadioButtons6 .=   "</div>";



$totalDue1 = sprintf("%.2f",$service_cost1+$upgrade_fee_single); 
$totalDue2 = sprintf("%.2f",$service_cost2+$upgrade_fee_single);
$totalDue3 = sprintf("%.2f",$service_cost3+$upgrade_fee_single);
$totalDue4 = sprintf("%.2f",$service_cost4+$upgrade_fee_single);
$totalDue5 = sprintf("%.2f",$service_cost5+$upgrade_fee_single);
$totalDue6 = sprintf("%.2f",$service_cost6+$upgrade_fee_single);
    

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
               




include "webTemplates/trainerBuyPageTemplate.php";

?>