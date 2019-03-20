<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$mem_holder = $_REQUEST['mem_holder'];
$search_name = $_REQUEST['search_name'];
$id_number = $_REQUEST['id_number'];
//If the the form has been submitted then do the search
if ($marker == 1)  {

include "memberCardList.php";
$getList = new memberCardList();
$location_id = $_SESSION['location_id'];

switch ($mem_holder) {
        case "C":
                if($search_name != "") {
                   $search_sql = $_SESSION['account_search_sql'];
                   $getList-> setSearchSql($search_sql);
                   $getList-> setLocationId($location_id);
                   $getList-> loadAccountList();
                   $list_results = $getList-> getListings();
                   unset($_SESSION['account_search_sql']);
                   }else{
                   $getList-> setContractKey($id_number); 
                   $getList-> setLocationId($location_id);
                   $getList-> loadAccountList();
                   $list_results = $getList-> getListings();
                   }
                   $form_header = "Contract Holder Results";
        break;
        case "M":
                 if($search_name != "") {
                   $search_sql = $_SESSION['member_search_sql'];
                   $getList-> setSearchSql($search_sql);
                   $getList-> setLocationId($location_id);
                   $getList-> loadMemberList();
                   $list_results = $getList-> getListings();
                   unset($_SESSION['member_search_sql']);
                   }else{
                   $getList-> setMemberId($id_number);
                   $getList-> setLocationId($location_id);
                   $getList-> loadMemberList();
                   $list_results = $getList-> getListings();
                   }
                   $form_header = "Reassign Card Member Results";
        break;
        }


include "../templates/cardHolderListTemplate.php";
exit;

}
//------------------------------------------------------------------------------------------------
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/searchMemberCard.js\"></script>";


include "../templates/searchMemberCardTemplate.php";

?>