<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$billing_setup = $_REQUEST['billing_setup'];
$marker = $_REQUEST['marker'];


include "billingSetupSql.php";





//if form is submitted save to database
if ($marker == 1) {
$updateInfo = new billingSetupSql();
$updateInfo-> setNewSetup($billing_setup);
$confirmation = $updateInfo-> updateBillingSetup();
}




//load the form content
$loadInfo = new billingSetupSql();
$loadInfo-> loadCurrentSetup();
$current_setup = $loadInfo-> getCurrentSetup();

switch($current_setup){
    case 1:
        $text = "Initially Process (Prorate + Proccessing Fee)";
        break;
    case 2:
        $text = "Initially Process (First Month + Prorate + Proccessing Fee)";
        break;
    case 3:
        $text = "Initially Process (First Month + Proccessing Fee)";
        break; 
    case 4:
        $text = "Initially Process (First Month + Last Month)";
        break;    
    case 5:
        $text = "Initially Process (Prorate)";
        break;     
}



include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(83);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/monthlyBillingSetupTemplate.php";




?>
