<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}

//gets the confirmation message for renewal
if(isset($_SESSION['confirmation_message'])) {
    $confirmation_message = $_SESSION['confirmation_message'];
     unset($_SESSION['confirmation_message']);
   }else{
   $confirmation_message ="";
   }


//get the search sql from the previously saved session variable
$search_sql = $_SESSION['account_search_sql'];

include "accountDropList2.php";
$getList = new accountDropList();
$getList-> setSearchSql($search_sql);
$getList-> loadEarlyRenewalGrace();
$account_list = $getList-> loadAccountList(); 
//$account_list = $getList-> getAccountList();


//css for lists etc
$account_list_css = 'accountList1.css';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/searchMemberAccounts.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/newMemberForm.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/setRenewalRecord.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/setUpgradeRecord.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/confirmRenew.js\"></script>";


$form_header = "Member Account List";



//universal for sales forms
include "../templates/searchButtonTemplate.php";

//this is the general template
include "../templates/accountListTemplate.php";



exit;

?>