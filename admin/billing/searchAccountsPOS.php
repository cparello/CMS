<?php
session_start();
//error_reporting(E_ALL);
if (!isset($_SESSION['admin_access']))  {
exit;
}

$marker = $_REQUEST['marker'];




//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];
$marker = $_REQUEST['marker'];

//If the the form has been submitted then do the search
if ($marker == 1)  {

include "posDropList3.php";
$getList = new accountDropList();

if (isset($_SESSION['account_search_sql']))  {
    $search_sql = $_SESSION['account_search_sql'];
    $getList-> setSearchSql($search_sql);
    $account_list = $getList-> loadAccountList(); 
    unset($_SESSION['account_search_sql']);
 }

echo "$account_list";
exit;

}
//------------------------------------------------------------------------------------------------
//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(27);
$info_text = $getText -> createTextInfo();
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/searchPosHistory.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPos2.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/searchAccountsTemplatePOS.php";

?>