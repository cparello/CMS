<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$numberMemberships = $_REQUEST['numberMemberships'];
$membership1 = $_REQUEST['membership1'];
$membership2 = $_REQUEST['membership2'];
$membership3 = $_REQUEST['membership3'];
$membership4 = $_REQUEST['membership4'];
$membership5 = $_REQUEST['membership5'];
$membership6 = $_REQUEST['membership6'];

$descrip1 = $_REQUEST['descrip1'];
$descrip2 = $_REQUEST['descrip2'];
$descrip3 = $_REQUEST['descrip3'];
$descrip4 = $_REQUEST['descrip4'];
$descrip5 = $_REQUEST['descrip5'];
$descrip6 = $_REQUEST['descrip6'];

$boxColor = $_REQUEST['boxColor'];
$textColor = $_REQUEST['textColor'];
$boxColorPromo = $_REQUEST['boxColorPromo'];
$textColorPromo = $_REQUEST['textColorPromo'];

$service1 = $_REQUEST['service1'];
$service2 = $_REQUEST['service2'];
$service3 = $_REQUEST['service3'];
$service4 = $_REQUEST['service4'];
$service5 = $_REQUEST['service5'];

$servicePhoto1 = $_REQUEST['servicePhoto1'];
$servicePhoto2 = $_REQUEST['servicePhoto2'];
$servicePhoto3 = $_REQUEST['servicePhoto3'];
$servicePhoto4 = $_REQUEST['servicePhoto4'];
$servicePhoto5 = $_REQUEST['servicePhoto5'];

$gear1 = $_REQUEST['gear1'];
$gear2 = $_REQUEST['gear2'];
$gear3 = $_REQUEST['gear3'];
$gear4 = $_REQUEST['gear4'];
$gear5 = $_REQUEST['gear5'];

$gearPhoto1 = $_REQUEST['gearPhoto1'];
$gearPhoto2 = $_REQUEST['gearPhoto2'];
$gearPhoto3 = $_REQUEST['gearPhoto3'];
$gearPhoto4 = $_REQUEST['gearPhoto4'];
$gearPhoto5 = $_REQUEST['gearPhoto5'];

$mem1 = $_REQUEST['mem1'];
$mem2 = $_REQUEST['mem2'];
$mem3 = $_REQUEST['mem3'];
$mem4 = $_REQUEST['mem4'];
$mem5 = $_REQUEST['mem5'];
$mem6 = $_REQUEST['mem6'];
//echo "mem3 $mem3";
//exit;
include "websiteJoinPageSql.php";


//if form is submitted save to database
if ($marker == 1) {

    $updateCycles = new websiteJoinPageSql();
    $updateCycles -> setNumberMemberships($numberMemberships);
    $updateCycles -> setMembership1($membership1);
    $updateCycles -> setMembership2($membership2);
    $updateCycles -> setMembership3($membership3);
    $updateCycles -> setMembership4($membership4);
    $updateCycles -> setMembership5($membership5);
    $updateCycles -> setMembership6($membership6);
    $updateCycles -> setMem1($mem1);
    $updateCycles -> setMem2($mem2);
    $updateCycles -> setMem3($mem3);
    $updateCycles -> setMem4($mem4);
    $updateCycles -> setMem5($mem5);
    $updateCycles -> setMem6($mem6);
    $updateCycles -> setDescrip1($descrip1);
    $updateCycles -> setDescrip2($descrip2);
    $updateCycles -> setDescrip3($descrip3);
    $updateCycles -> setDescrip4($descrip4);
    $updateCycles -> setDescrip5($descrip5);
    $updateCycles -> setDescrip6($descrip6);
    $updateCycles -> setBoxColor($boxColor);
    $updateCycles -> setTextColor($textColor);
    $updateCycles -> setBoxColorPromo($boxColorPromo);
    $updateCycles -> setTextColorPromo($textColorPromo);
    $updateCycles -> setService1($service1);
    $updateCycles -> setService2($service2);
    $updateCycles -> setService3($service3);
    $updateCycles -> setService4($service4);
    $updateCycles -> setService5($service5);
    $updateCycles -> setServicePhoto1($servicePhoto1);
    $updateCycles -> setServicePhoto2($servicePhoto2);
    $updateCycles -> setServicePhoto3($servicePhoto3);
    $updateCycles -> setServicePhoto4($servicePhoto4);
    $updateCycles -> setServicePhoto5($servicePhoto5);
    
    $updateCycles -> setGear1($gear1);
    $updateCycles -> setGear2($gear2);
    $updateCycles -> setGear3($gear3);
    $updateCycles -> setGear4($gear4);
    $updateCycles -> setGear5($gear5);
    $updateCycles -> setGearPhoto1($gearPhoto1);
    $updateCycles -> setGearPhoto2($gearPhoto2);
    $updateCycles -> setGearPhoto3($gearPhoto3);
    $updateCycles -> setGearPhoto4($gearPhoto4);
    $updateCycles -> setGearPhoto5($gearPhoto5);

   $confirmation = $updateCycles -> updateWebsiteMembershipOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websiteJoinPageSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteMembershipOptions();
//echo "test";
$numberMemberships = $loadSalesPay -> getNumberMemberships();
$membership1 = $loadSalesPay -> getMembership1();
$membership2 = $loadSalesPay -> getMembership2();
$membership3 = $loadSalesPay -> getMembership3();
$membership4 = $loadSalesPay -> getMembership4();
$membership5 = $loadSalesPay -> getMembership5();
$membership6 = $loadSalesPay -> getMembership6();

$mem1 = $loadSalesPay -> getMem1();
$mem2 = $loadSalesPay -> getMem2();
$mem3 = $loadSalesPay -> getMem3();
$mem4 = $loadSalesPay -> getMem4();
$mem5 = $loadSalesPay -> getMem5();
$mem6 = $loadSalesPay -> getMem6();

$descrip1 = $loadSalesPay -> getDescrip1();
$descrip2 = $loadSalesPay -> getDescrip2();
$descrip3 = $loadSalesPay -> getDescrip3();
$descrip4 = $loadSalesPay -> getDescrip4();
$descrip5 = $loadSalesPay -> getDescrip5();
$descrip6 = $loadSalesPay -> getDescrip6();
$boxColor = $loadSalesPay -> getBoxColor();
$textColor = $loadSalesPay -> getTextColor();
$boxColorPromo = $loadSalesPay -> getBoxColorPromo();
$textColorPromo = $loadSalesPay -> getTextColorPromo();
$service1 = $loadSalesPay -> getService1();
$service2 = $loadSalesPay -> getService2();
$service3 = $loadSalesPay -> getService3();
$service4 = $loadSalesPay -> getService4();
$service5 = $loadSalesPay -> getService5();
$servicePhoto1 = $loadSalesPay -> getServicePhoto1();
$servicePhoto2 = $loadSalesPay -> getServicePhoto2();
$servicePhoto3 = $loadSalesPay -> getServicePhoto3();
$servicePhoto4 = $loadSalesPay -> getServicePhoto4();
$servicePhoto5 = $loadSalesPay -> getServicePhoto5();
$gear1 = $loadSalesPay -> getGear1();
$gear2 = $loadSalesPay -> getGear2();
$gear3 = $loadSalesPay -> getGear3();
$gear4 = $loadSalesPay -> getGear4();
$gear5 = $loadSalesPay -> getGear5();
$gearPhoto1 = $loadSalesPay -> getGearPhoto1();
$gearPhoto2 = $loadSalesPay -> getGearPhoto2();
$gearPhoto3 = $loadSalesPay -> getGearPhoto3();
$gearPhoto4 = $loadSalesPay -> getGearPhoto4();
$gearPhoto5 = $loadSalesPay -> getGearPhoto5();

//sets up the varibles for the form template
$submit_link = 'editJoinPage.php';
$submit_name = 'update';
$submit_title = "Update Website Join Page Options";
$page_title  = 'Website Join Page Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"new/js/websiteJoinPage.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteJoinPage.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";

$dir = "pictures/servicePhotos/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions1 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions2 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions3 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions4 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
    
$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions5 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
$dir = "pictures/gear/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $gearDropOptions1 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $gearDropOptions2 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $gearDropOptions3 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $gearDropOptions4 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
    
$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $gearDropOptions5 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }                
                 

if($mem1 == 1){
    $m1Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m1Selected = "<option value=\"0\" selected>No</option>";
}

if($mem2 == 1){
    $m2Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m2Selected = "<option value=\"0\" selected>No</option>";
}

if($mem3 == 1){
    $m3Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m3Selected = "<option value=\"0\" selected>No</option>";
}

if($mem4 == 1){
    $m4Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m4Selected = "<option value=\"0\" selected>No</option>";
}

if($mem5 == 1){
    $m5Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m5Selected = "<option value=\"0\" selected>No</option>";
}

if($mem6 == 1){
    $m6Selected = "<option value=\"1\" selected>Yes</option>";
}else{
    $m6Selected = "<option value=\"0\" selected>No</option>";
}

include"../../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT service_type, club_id FROM service_info WHERE service_type LIKE '%Membership%'  AND group_type = 'S'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($service_type, $club_id);
   while($stmt->fetch()){
    if($club_id != '0'){
        $stmt99 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
         $stmt99->execute();      
         $stmt99->store_result();      
         $stmt99->bind_result($club_name);
         $stmt99->fetch();
         $stmt99->close();
    }else{
        $club_name = "All Locations";
    }
    $membershipSelecthtml .= "<option value=\"$service_type - $club_name\">$service_type &nbsp;- $club_name</option>";
   }
//echo"fubar0";
$stmt->close();

$stmt = $dbMain ->prepare("SELECT service_type, club_id FROM service_info WHERE service_type NOT LIKE '%Membership%'  AND group_type = 'S'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($service_type, $club_id);
   while($stmt->fetch()){
    if($club_id != '0'){
        $stmt99 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
         $stmt99->execute();      
         $stmt99->store_result();      
         $stmt99->bind_result($club_name);
         $stmt99->fetch();
         $stmt99->close();
    }else{
        $club_name = "All Locations";
    }
    $serviceSelecthtml .= "<option value=\"$service_type - $club_name\">$service_type &nbsp;- $club_name</option>";
   }
//echo"fubar0";
$stmt->close();

$stmt = $dbMain ->prepare("SELECT product_desc FROM club_inventory WHERE product_desc != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($product_desc);
   while($stmt->fetch()){
    $gearSelecthtml .= "<option value=\"$product_desc\">$product_desc</option>";
   }
//echo"fubar0";
$stmt->close();


include "webTemplates/websiteJoinPageSetupTemplate.php";

?>