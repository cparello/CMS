<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//print_r($_POST);
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$accesslevel = $_REQUEST['accesslevel'];
$marker = $_REQUEST['marker'];

//sets up the varibles for the form template
$submit_link = 'addUsers.php';
$submit_name = 'save';
$page_title  = 'Add New User';
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"scripts/login2.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"scripts/helpTxtUsers.js\"></script>";
//$info_text
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

//if form is submitted save to database
if ($marker == 1) {

//taken from ajax call on submit of form
$access_level = $_SESSION['access_level'];



//save to the database
include "userSql.php";
$saveUser = new userSql();
$saveUser -> setFirstName($first_name);
$saveUser -> setLastName($last_name);
$saveUser -> setUserName($username);
$saveUser -> setPassWord($password);
$saveUser -> setAccessLevel($access_level);
$confirmation = $saveUser -> saveUser();



}



include "getLinks.php";



//get checkboxes
$getMenu = new getLinks();
$getMenu -> setFilePerms($file_permissions);
$getMenu -> loadMenus();
$handle =  $getMenu -> getCheckBox();

$first_name =  "";
$last_name= "";
$password="";
$username="";

include "infoText.php";
$getText = new infoText();
$getText -> setTextNum(1);
$info_text = $getText -> createTextInfo();

include "templates/infoTemplate.php";
include "templates/userTemplate.php";




?>



