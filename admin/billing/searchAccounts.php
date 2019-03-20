<?php
session_start();
//error_reporting(E_ALL);
if (!isset($_SESSION['admin_access']))  {
exit;
}

$marker = $_REQUEST['marker'];


//unset the contract key
if (isset($_SESSION['contract_key']))  {
   unset($_SESSION['contract_key']);
}
if ($marker != 1)  {
    unset($_SESSION['account_search_sql']);
    unset($_SESSION['group_search_sql']);
    unset($_SESSION['cc_search_sql']);
    unset($_SESSION['member_search_sql']);
    unset($_SESSION['bank_search_sql']);
}


//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];
$marker = $_REQUEST['marker'];

//If the the form has been submitted then do the search
if ($marker == 1)  {

include "accountDropList3.php";
$getList = new accountDropList();

if (isset($_SESSION['account_search_sql']))  {
    $search_sql = $_SESSION['account_search_sql'];
    $getList-> setSearchSql($search_sql);
    $account_list = $getList-> loadAccountList(); 
    //unset($_SESSION['account_search_sql']);
 }


if (isset($_SESSION['group_search_sql']))  {
    $search_sql = $_SESSION['group_search_sql'];
    $getList-> setGroupSql($search_sql);
    $account_list = $getList-> loadGroupNames(); 
    //unset($_SESSION['group_search_sql']);
 }

 if (isset($_SESSION['cc_search_sql']))  {
    $search_sql = $_SESSION['cc_search_sql'];
    $getList-> setCCSql($search_sql);
    $account_list = $getList-> loadCCNames(); 
    //unset($_SESSION['cc_search_sql']);
 }
 if (isset($_SESSION['member_search_sql']))  {
    $search_sql = $_SESSION['member_search_sql'];
    $getList-> setMemberSql($search_sql);
    $account_list = $getList-> loadMemberNames(); 
    //unset($_SESSION['member_search_sql']);
 }
 if (isset($_SESSION['bank_search_sql']))  {
    $search_sql = $_SESSION['bank_search_sql'];
    $getList-> setBankSql($search_sql);
    $account_list = $getList-> loadBankNames(); 
    //unset($_SESSION['bank_search_sql']);
 }


$account_list_css = 'accountList2.css';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/setContractRecord.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/setPrePayRecord.js\"></script>";
$form_header = "Client Account Results";
include "../templates/accountListTemplate2.php";
exit;

}
//------------------------------------------------------------------------------------------------
//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(27);
$info_text = $getText -> createTextInfo();
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/searchMemberAccountsAdmin.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtAccounts.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/searchAccountsTemplate.php";

?>