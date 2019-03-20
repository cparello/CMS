<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];


//If the the form has been submitted then do the search
if ($marker == 1)  {

$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];

include "userLists.php";
$getLists = new userLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();
//$result2 = $getLists -> getUserForm();


//check tp see if there are multi results or not
if($result1 != "") {
include "infoText.php";
$getText = new infoText();
$getText -> setTextNum(3);
$info_text = $getText -> createTextInfo();
include "templates/infoTemplate.php";
include "templates/userListsTemplate.php";
exit;
}else{



}




//echo"$result1";
//exit;








}

//print out the search form
include "infoText.php";
$getText = new infoText();
$getText -> setTextNum(2);
$info_text = $getText -> createTextInfo();
include "templates/infoTemplate.php";
include "templates/searchUsersTemplate.php";

?>