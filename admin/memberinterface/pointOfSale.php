<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include"accountPaymentForms.php";
$loadForm = new accountPaymentForms();
$loadForm-> loadMonthYearDrops();
$year_drop = $loadForm-> getYearDrop();
$month_drop = $loadForm-> getMonthDrop();

//this resets the session variables for refunds etc

if(isset($_SESSION['cash_payment'])) {
   unset($_SESSION['cash_payment']);      
  }
if(isset($_SESSION['check_payment'])) {
   unset($_SESSION['check_payment']);       
  } 
if(isset($_SESSION['ach_payment'])) {
   unset($_SESSION['ach_payment']);       
  }   
if(isset($_SESSION['credit_payment'])) {
   unset($_SESSION['credit_payment']);       
  }    
if(isset($_SESSION['product_array'])) {
   unset($_SESSION['product_array']);       
  } 
if(isset($_SESSION['business_name'])) {
   unset($_SESSION['business_name']);       
  } 
if(isset($_SESSION['club_name'])) {
   unset($_SESSION['club_name']);       
  } 
if(isset($_SESSION['club_address'])) {
   unset($_SESSION['club_address']);       
  }   
if(isset($_SESSION['club_phone'])) {
   unset($_SESSION['club_phone']);       
  }     
if(isset($_SESSION['sales_tax'])) {
   unset($_SESSION['sales_tax']);       
  }     
if(isset($_SESSION['retail_cost'])) {
   unset($_SESSION['retail_cost']);       
  }     
if(isset($_SESSION['total_cost'])) {
   unset($_SESSION['total_cost']);       
  } 
if(isset($_SESSION['purchase_date'])) {
   unset($_SESSION['purchase_date']);       
  }       
  include"../dbConnect.php";
   $stmt = $dbMain ->prepare("SELECT pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10 FROM pos_setup_options WHERE pos_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($pos1, $pos2, $pos3, $pos4, $pos5, $pos6, $pos7, $pos8, $pos9, $pos10);
   $stmt->fetch();
   $stmt->close();
   
   $strSize = 21;
   
   if($pos1 !=""){
    $pos1AR = explode('|',$pos1);
    $pos1D = $pos1AR[0];
    $pos1D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos1D, $strSize," ", STR_PAD_BOTH));
    $but1 = "<button class=\"button9\" name=\"$pos1\" value=\"$pos1\" type=\"submit\">$pos1D</button>";
   }else{
     $but1 = "";
   }
   
   
 if($pos2 !=""){
    $pos2AR = explode('|',$pos2);
    $pos2D = $pos2AR[0];
    $pos2D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos2D, $strSize," ", STR_PAD_BOTH));
    $but2 = "<button class=\"button9\" name=\"$pos2\" value=\"$pos2\" type=\"submit\">$pos2D</button>";
   }else{
     $but2 = "";
   }
   if($pos3 !=""){
    $pos3AR = explode('|',$pos3);
    $pos3D = $pos3AR[0];
    $pos3D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos3D, $strSize," ", STR_PAD_BOTH));
    $but3 = "<button class=\"button9\" name=\"$pos3\" value=\"$pos3\" type=\"submit\">$pos3D</button>";
   }else{
     $but3 = "";
   }
   if($pos4 !=""){
    $pos4AR = explode('|',$pos4);
    $pos4D = $pos4AR[0];
    $pos4D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos4D, $strSize," ", STR_PAD_BOTH));
    $but4 = "<button class=\"button9\" name=\"$pos4\" value=\"$pos4\" type=\"submit\">$pos4D</button>";
   }else{
     $but4 = "";
   }
   if($pos5 !=""){
    $pos5AR = explode('|',$pos5);
    $pos5D = $pos5AR[0];
    $pos5D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos5D, $strSize," ", STR_PAD_BOTH));
    $but5 = "<button class=\"button9\" name=\"$pos5\" value=\"$pos5\" type=\"submit\">$pos5D</button>";
   }else{
     $but5 = "";
   }
   if($pos6 !=""){
    $pos6AR = explode('|',$pos6);
    $pos6D = $pos6AR[0];
    $pos6D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos6D, $strSize," ", STR_PAD_BOTH));
    $but6 = "<button class=\"button9\" name=\"$pos6\" value=\"$pos6\" type=\"submit\">$pos6D</button>";
   }else{
     $but6 = "";
   }
   if($pos7 !=""){
    $pos7AR = explode('|',$pos7);
    $pos7D = $pos7AR[0];
    $pos7D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos7D, $strSize," ", STR_PAD_BOTH));
    $but7 = "<button class=\"button9\" name=\"$pos7\" value=\"$pos7\" type=\"submit\">$pos7D</button>";
   }else{
     $but7 = "";
   }
   if($pos8 !=""){
    $pos8AR = explode('|',$pos8);
    $pos8D = $pos8AR[0];
    $pos8D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos8D, $strSize," ", STR_PAD_BOTH));
    $but8 = "<button class=\"button9\" name=\"$pos8\" value=\"$pos8\" type=\"submit\">$pos8D</button>";
   }else{
     $but8 = "";
   }
   if($pos9 !=""){
    $pos9AR = explode('|',$pos9);
    $pos9D = $pos9AR[0];
    $pos9D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos9D, $strSize," ", STR_PAD_BOTH));
    $but9 = "<button class=\"button9\" name=\"$pos9\" value=\"$pos9\" type=\"submit\">$pos9D</button>";
   }else{
     $but9 = "";
   }
   if($pos10 !=""){
    $pos10AR = explode('|',$pos10);
    $pos10D = $pos10AR[0];
    $pos10D = str_replace(" ", "&nbsp;&nbsp;", str_pad($pos10D, $strSize," ", STR_PAD_BOTH));
    $but10 = "<button class=\"button9\" name=\"$pos10\" value=\"$pos10\" type=\"submit\">$pos10D</button>";
   }else{
     $but10 = "";
   }
 
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/pointOfSale_v2.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/processPosPayment_v2.js\"></script>";
$javaScript4= "<script type=\"text/javascript\" src=\"../scripts/posPrintOptions.js\"></script>";
$javaScript5= "<script type=\"text/javascript\" src=\"../scripts/refundPosPurchase_v2.js\"></script>";
$javaScript6= "<script type=\"text/javascript\" src=\"../scripts/refundExchange_v2.js\"></script>";
$javaScript7= "<script type=\"text/javascript\" src=\"../scripts/refExPrintOptionsv1.js\"></script>";
$javaScript8= "<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";

include "../templates/pointOfSaleTemplate.php";



?>