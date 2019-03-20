<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$numberPackages = $_REQUEST['numberPackages'];
$package1 = $_REQUEST['package1'];
$package2 = $_REQUEST['package2'];
$package3 = $_REQUEST['package3'];
$package4 = $_REQUEST['package4'];
$package5 = $_REQUEST['package5'];
$package6 = $_REQUEST['package6'];

$descrip1 = $_REQUEST['descrip1'];
$descrip2 = $_REQUEST['descrip2'];
$descrip3 = $_REQUEST['descrip3'];
$descrip4 = $_REQUEST['descrip4'];
$descrip5 = $_REQUEST['descrip5'];
$descrip6 = $_REQUEST['descrip6'];

$boxColor = $_REQUEST['boxColor'];
$textColor = $_REQUEST['textColor'];

$liability = $_REQUEST['liability'];


//exit;
include "websiteTrainerBuyPageSql.php";


//if form is submitted save to database
if ($marker == 1) {

    $updateCycles = new websiteTrainerBuyPageSql();
    $updateCycles -> setNumberPackages($numberPackages);
    $updateCycles -> setPackage1($package1);
    $updateCycles -> setPackage2($package2);
    $updateCycles -> setPackage3($package3);
    $updateCycles -> setPackage4($package4);
    $updateCycles -> setPackage5($package5);
    $updateCycles -> setPackage6($package6);
    $updateCycles -> setDescrip1($descrip1);
    $updateCycles -> setDescrip2($descrip2);
    $updateCycles -> setDescrip3($descrip3);
    $updateCycles -> setDescrip4($descrip4);
    $updateCycles -> setDescrip5($descrip5);
    $updateCycles -> setDescrip6($descrip6);
    $updateCycles -> setBoxColor($boxColor);
    $updateCycles -> setTextColor($textColor);
    $updateCycles -> setLiability($liability);
   $confirmation = $updateCycles -> updateWebsiteTrainerPackageOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websiteTrainerBuyPageSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteTrainerPackageOptions();

$numberPackages = $loadSalesPay -> getNumberPackages();
$package1 = $loadSalesPay -> getPackage1();
$package2 = $loadSalesPay -> getPackage2();
$package3 = $loadSalesPay -> getPackage3();
$package4 = $loadSalesPay -> getPackage4();
$package5 = $loadSalesPay -> getPackage5();
$package6 = $loadSalesPay -> getPackage6();
$descrip1 = $loadSalesPay -> getDescrip1();
$descrip2 = $loadSalesPay -> getDescrip2();
$descrip3 = $loadSalesPay -> getDescrip3();
$descrip4 = $loadSalesPay -> getDescrip4();
$descrip5 = $loadSalesPay -> getDescrip5();
$descrip6 = $loadSalesPay -> getDescrip6();
$boxColor = $loadSalesPay -> getBoxColor();
$textColor = $loadSalesPay -> getTextColor();
$liability = $loadSalesPay -> getLiability();
//echo "fubar";
//exit;

//sets up the varibles for the form template
$submit_link = 'editTrainerBuyPage.php';
$submit_name = 'update';
$submit_title = "Update Website Trainer Buy Page Options";
$page_title  = 'Website Trainer Buy Page Options';
//$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websiteJoinPage.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteTrainerBuyPage.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";





include"../../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT service_type, club_id FROM service_info WHERE service_type LIKE '%Train%'  AND group_type = 'S'");
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
    $packageSelecthtml .= "<option value=\"$service_type - $club_name\">$service_type &nbsp;- $club_name</option>";
   }
//echo"fubar0";
$stmt->close();


include "webTemplates/websiteTrainerBuyPageSetupTemplate.php";

?>