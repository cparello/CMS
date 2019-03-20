<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];


//echo "mem3 $mem3";
//exit;
include "posPageSql.php";


//if form is submitted save to database
if ($marker == 1) {
    
$pos1 = $_REQUEST['pos1'];
$pos2 = $_REQUEST['pos2'];
$pos3 = $_REQUEST['pos3'];
$pos4 = $_REQUEST['pos4'];
$pos5 = $_REQUEST['pos5'];
$pos6 = $_REQUEST['pos6'];
$pos7 = $_REQUEST['pos7'];

$pos8 = $_REQUEST['pos8'];
$pos9 = $_REQUEST['pos9'];
$pos10 = $_REQUEST['pos10'];




    $updatePos = new posPageSql();
    $updatePos -> setPos1($pos1);
    $updatePos -> setPos2($pos2);
    $updatePos -> setPos3($pos3);
    $updatePos -> setPos4($pos4);
    $updatePos -> setPos5($pos5);
    $updatePos -> setPos6($pos6);
    $updatePos -> setPos7($pos7);
    $updatePos -> setPos8($pos8);
    $updatePos -> setPos9($pos9);
    $updatePos -> setPos10($pos10);
    
    

   $confirmation = $updatePos -> updatePosOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadPos = new posPageSql();
//echo"fubar 1";
$loadPos -> loadPosOptions();

$pos1 = $loadPos -> getPos1();
$pos2 = $loadPos -> getPos2();
$pos3 = $loadPos -> getPos3();
$pos4 = $loadPos -> getPos4();
$pos5 = $loadPos -> getPos5();
$pos6 = $loadPos -> getPos6();
$pos7 = $loadPos -> getPos7();
$pos8 = $loadPos -> getPos8();
$pos9 = $loadPos -> getPos9();
$pos10 = $loadPos -> getPos10();

$pos1AR = explode('|',$pos1);
$pos1D = $pos1AR[0];
$pos2AR = explode('|',$pos2);
$pos2D = $pos2AR[0];
$pos3AR = explode('|',$pos3);
$pos3D = $pos3AR[0];
$pos4AR = explode('|',$pos4);
$pos4D = $pos4AR[0];
$pos5AR = explode('|',$pos5);
$pos5D = $pos5AR[0];
$pos6AR = explode('|',$pos6);
$pos6D = $pos6AR[0];
$pos7AR = explode('|',$pos7);
$pos7D = $pos7AR[0];
$pos8AR = explode('|',$pos8);
$pos8D = $pos8AR[0];
$pos9AR = explode('|',$pos9);
$pos9D = $pos9AR[0];
$pos10AR = explode('|',$pos10);
$pos10D = $pos10AR[0];
//sets up the varibles for the form template
$submit_link = 'editPosPage.php';
$submit_name = 'update';
$submit_title = "Update POS Page Options";
$page_title  = 'POS Page Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"new/js/websiteJoinPage.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteJoinPage.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


include"../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT inventory_marker, product_desc, retail_cost, sales_tax, bar_code, category_id FROM pos_inventory WHERE inventory_marker != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($inventory_marker, $product_desc, $retail_cost, $sales_tax, $bar_code, $category_id);
   while($stmt->fetch()){
            $stmt99 = $dbMain ->prepare("SELECT category_name FROM pos_category WHERE category_id = '$category_id'");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($cat);
            $stmt99->fetch();
            $stmt99->close();
    
        $posDrop .= "<option value=\"$product_desc|$inventory_marker|$retail_cost|$sales_tax|$bar_code|$cat\">$product_desc</option>";
   }

$stmt->close();



include "../templates/posPageSetupTemplate.php";

?>