<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$id_number = $_REQUEST['id_number'];
$marker = $_REQUEST['marker'];
$mem_holder = $_REQUEST['mem_holder'];
$search_name = $_REQUEST['search_name'];

if($marker != 1){
     unset($_SESSION['id_number']);
     unset($_SESSION['mem_holder']);
     unset($_SESSION['search_name']);
}
//echo "test $marker";
//If the the form has been submitted then do the search
if ($marker == 1)  {

include "holderMemberList.php";
$getList = new holderMemberList();
$location_id = $_SESSION['location_id'];

if(!isset($_SESSION['id_number'])){
    $_SESSION['id_number'] = $id_number;
    $_SESSION['mem_holder'] = $mem_holder;
    $_SESSION['search_name'] = $search_name;
}else{
    $id_number = $_SESSION['id_number'];
    $mem_holder = $_SESSION['mem_holder'];
    $search_name = $_SESSION['search_name'];
}
//echo "$mem_holder";

switch ($mem_holder) {
        case "C":
                if($search_name != "") {
                   $search_sql = $_SESSION['account_search_sql'];
                   $getList-> setSearchSql($search_sql);
                   $getList-> setLocationId($location_id);
                   $getList-> loadAccountList();
                   $list_results = $getList-> getListings();
                   //unset($_SESSION['account_search_sql']);
                   }else{
                   $getList-> setContractKey($id_number); 
                   $getList-> setLocationId($location_id);
                   $getList-> loadAccountList();
                   $list_results = $getList-> getListings();
                   }
                   $form_header = "Contract Holder Results";
                   $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/manualCheckIn.js\"></script>";
        break;
        case "M":
                 if($search_name != "") {
                   $search_sql = $_SESSION['member_search_sql'];
                   $getList-> setSearchSql($search_sql);
                   $getList-> setLocationId($location_id);
                   $getList-> loadMemberList();
                   $list_results = $getList-> getListings();
                   //unset($_SESSION['member_search_sql']);
                   }else{
                   $getList-> setMemberId($id_number);
                   $getList-> setLocationId($location_id);
                   $getList-> loadMemberList();
                   $list_results = $getList-> getListings();
                   }
                   $form_header = "Member Results";
                   $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/manualCheckIn.js\"></script>";
        break;
        case "N":
                 if($search_name != "") {
                   $search_sql = $_SESSION['member_search_sql'];
                   $getList-> setSearchSql($search_sql);
                   $getList-> setLocationId($location_id);
                   $getList-> loadNonMemberList();
                   $list_results = $getList-> getListings();
                   //unset($_SESSION['member_search_sql']);
                   }else{
                   $getList-> setMemberId($id_number);
                   $getList-> setLocationId($location_id);
                   $getList-> loadNonMemberList();
                   $list_results = $getList-> getListings();
                   }
                   $form_header = "Non Member Results";
                   $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/parseNonMemberListing.js\"></script>";
        break;        
        }

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";

include "../templates/holderMemListTemplate.php";
exit;

}
//------------------------------------------------------------------------------------------------
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/searchMembers.js\"></script>";


include "../templates/searchMembersTemplate.php";

?>