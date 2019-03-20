<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//get the session vars for index menu for the menu page
$admin_header = $_SESSION['header_admin'];
$filePerm = $_SESSION['file_permissions']; 
$user  =  $_SESSION['user_name'];
$userId  = $_SESSION['user_id'];
$footer_admin = $_SESSION['footer_admin'];
$userFirstName = $_SESSION['user_fname'];


include "getLinks.php";

//get the file permissions
$file_permissions = $_SESSION['file_permissions'];

$getMenu = new getLinks();
$getMenu -> setFilePerms($file_permissions);
$getMenu -> loadMenus();
$handle =  $getMenu -> getFileLinks();





$login_menu = <<<LOGMEN

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/index_v1.css">
<script type="text/javascript" src="scripts/jqueryNew.js"></script>
<script type="text/javascript" src="scripts/showHide.js"></script>
<script type="text/javascript" src="scripts/switchTabs.js"></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="scripts/jquery.livequery.js"></script>
<script type="text/javascript" src="scripts/adminBackToAccess.js"></script>
<title>Dashboard</title>
</head>

<body>
<input id="goBackAccess" name="goBackAccess" value="Go Back" class="button1" type="submit">
<div id="headerHouse" class="headerHouse">
<div id="headerImg" class="headerImg">
<div class="imgPos">
<img src="images/logo2.gif" border="0" />
</div>
</div>
</div>

<div id= "divStripe1" class="divStripe1">
</div>

<div id= "divStripe2" class="divStripe2">
<div id="logTxt" class="logTxt">
<div class="txtForm">
<span class="hello">Hello $userFirstName</span>
| <span class="log"><a class="logOut" href = "mainLogin.php">Log out</a></span>
<br>
Logged In:  $user 
</div>
</div>
</div>


<div id="container" class="container">

<div class="msg_list">
$handle 
</div>	



<div id="contentHeader" class="tabHeader">
Club Manager Pro Administration
</div>

<div id="contentFrame" class="contentFrame">
<iframe src="frame_c.html" width="855" height="520" frameborder="0" name="content" id="content" scrolling="auto">
</iframe>
</div>

</div>

<div class="footer">
$footer_admin
<img src="images/logo_mantistree.png" class="logo_mantistree" />
</div>  

<script>
  $(document).ready(function(){
    $("#container").height($(document).height() - $("#headerHouse").height() - $("#divStripe1").height() - $("#divStripe2").height() - $(".footer").height());
    $(".msg_list").height($("#container").height() - parseInt($(".msg_list").css("padding-top").replace("px", "")));
    $("#contentFrame").height($("#container").height());
    $("#content").height($("#container").height());
  });
</script>

</body>
</html>
LOGMEN;

echo"$login_menu";

?>