<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include "../../dbConnect.php";
/*
$marker = $_REQUEST['marker'];
$catArray = $_REQUEST['catArray'];
include "websiteStoreOptionsSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteStoreOptionsSql();
   $updateCycles ->setCatArray($catArray);
   $confirmation = $updateCycles -> updateWebsiteStoreOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websiteStoreOptionsSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteStoreOptions();
//echo"fubar0";
$catArray = $loadSalesPay -> getCatArray();
*/
//$catArray = trim($catArray);
//sets up the varibles for the form template
$submit_link = 'editWebsiteStoreOptions.php';
$submit_name = 'update';
$submit_title = "Update Website Store Options Options";
$page_title  = 'Website Store Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/saveUpdateWebCats.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteStoreOptions.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


$stmt = $dbMain ->prepare("SELECT count(*) as count FROM pos_category WHERE category_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();
$stmt->close();

//$catArrayExploded = explode('|',$catArray);

$counter = 1;

$htmlCheckList = "<div class=\"radButtons\">";
 $stmt = $dbMain ->prepare("SELECT category_id, category_name FROM pos_category WHERE category_id != '' ORDER BY category_id ASC");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($category_id, $category_name); 
   while($stmt->fetch()){
        $stmt99 = $dbMain ->prepare("SELECT show_on_web FROM website_store_categories WHERE cat_id = '$category_id'");
        $stmt99->execute();      
        $stmt99->store_result();      
        $stmt99->bind_result($show_on_web); 
        $stmt99->fetch();
        $stmt99->close();
    
          //$catDetails = explode(',',$catArrayExploded[$counter-1]);
          if ($show_on_web == 'Y'){
            $selectedYes = "checked=\"checked\""; 
            $selectedNo = "";
          }else{
            $selectedYes = "";
            $selectedNo = "checked=\"checked\"";
          }
        $htmlCheckList .= "<tr>
                            <td>
                            $category_name
                            </td>
                            <td>
                            <input type=\"radio\" $selectedYes name=\"inventoryOptions$counter\" value=\"Y|$category_id|$category_name\">Yes</input>
                           <input type=\"radio\" $selectedNo name=\"inventoryOptions$counter\" value=\"N|$category_id|$category_name\">No</input>
                           </td>
                           </tr>"; 
        $counter++;  
        $category_id = "";
        $category_name  = "";
        $show_on_web = "";
     }
     $htmlCheckList .= "</div>";
     $stmt->close();
/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteStoreOptionsTemplate.php";

?>