<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//===================================================timeout start
if(!isset($_SESSION['isLoggedIn']) || !($_SESSION['isLoggedIn']))
{
	//code for authentication comes here
	//ASSUME USER IS VALID
	$_SESSION['isLoggedIn'] = true;
	/////////////////////////////////////////
	$_SESSION['timeOut'] = 3600;
	$logged = time();
	$_SESSION['loggedAt']= $logged;	
	//showLoggedIn();
}
else
{
	require 'timeCheck.php';
	$hasSessionExpired = checkIfTimedOut();
	if($hasSessionExpired)
	{
		session_unset();
		header("Location: ../admin/mainLogin.php");
		exit;
	}
	else
	{
		$_SESSION['loggedAt']= time();// update last accessed time
		//showLoggedIn();
	}

}
	function showLoggedIn()
	{
		echo'<html>';
		echo'<head>';
		echo'<script type="text/javascript" src="ajax.js"></script>';
		echo'</head>';
		echo'<body>';
			echo'<p>';
				echo'Page 1. User is logged in currently.Timeout has been set to 5 seconds. If you stay inactive for more then 5 seconds, you will be logged out automatically and redirected to home page.';
			echo'</p>';
			echo'<br/>';
			echo'<p><a href="second.php">Go to second page</a></p>';
			echo'<br/><br/><br/><p><a href="">Back to article</a></p>';
		echo'</body>';
		echo'</html>';
	}
//=====================================================timeoutend
//*****************************************************
//THIS IS FOR THE NEXT PAGE TO KEEP CONNECTION ALIVE
//****************************************************
/*	if(!isset($_SESSION['isLoggedIn']) || !($_SESSION['isLoggedIn']))
	{
		//user is not logged in
		// simply redirect to index.html
		session_unset();
		header("Location:index.html");	
	}
	else
	{
		// user is logged in
		require 'timeCheck.php';
		$hasSessionExpired = checkIfTimedOut();
		if($hasSessionExpired)
		{
			session_unset();
			header("Location:index.html");	
			exit;
		}
		else
		{
			$_SESSION['loggedAt']= time();// update last accessed time
			showLoggedIn();
		}
	}
	
	function showLoggedIn()
	{
		echo'<html>';
		echo'<head>';
		echo'<script type="text/javascript" src="ajax.js"></script>';
		echo'</head>';
		echo'<body>';
			echo'<p>';
				echo'Page2. User is logged in currently.Timeout has been set to 5 seconds. If you stay inactive for more then 5 seconds, you will be logged out automatically and redirected to home page.';
			echo'</p>';
			echo'<br/>';
			echo'<p><a href="first.php">Back to first page</a></p>';
			echo'<br/><br/><br/><p><a href="">Back to article</a></p>';
		echo'</body>';
		echo'</html>';
	}*/
//================================================================
include '../dbConnect.php';
$userId  = $_SESSION['user_id'];
$sql = "SELECT user_name FROM admin_passwords WHERE user_id = '$userId'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user);
$stmt->fetch();
$stmt->close(); 

$userName = $user;
//echo "fu $userId";

$sql = "SELECT type_key FROM basic_compensation WHERE user_id = '$userId'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($typeKey);
while($stmt->fetch()){
    $sql = "SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$typeKey'";
    $stmt11 = $dbMain->prepare($sql);
    $stmt11->execute();      
    $stmt11->store_result();      
    $stmt11->bind_result($employeeType, $locationId);
    $stmt11->fetch();
    $stmt11->close(); 
    
    
    
    if (preg_match("/sales/i", $employeeType)) {
        $sql = "SELECT id_card  FROM basic_compensation WHERE type_key = '$typeKey' AND user_id = '$userId'";
        $stmt11 = $dbMain->prepare($sql);
        $stmt11->execute();      
        $stmt11->store_result();      
        $stmt11->bind_result($id_card);
        $stmt11->fetch();
        $stmt11->close(); 
        
        $empTypeKey = $typeKey;
        $_SESSION['location_id'] = $locationId; 
        $sql = "SELECT  emp_fname  FROM employee_info WHERE  user_id = '$userId'";
        $stmt11 = $dbMain->prepare($sql);
        $stmt11->execute();      
        $stmt11->store_result();      
        $stmt11->bind_result($firstName);
        $stmt11->fetch();
        $_SESSION['user_name'] = $userName;
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_fname'] = $firstName; 
        $_SESSION['id_card'] = $id_card; 
    }   
}
$stmt->close();  


//get the session vars for index menu for the menu page
$admin_header = $_SESSION['header_admin'];
$user  =  $_SESSION['user_name'];
$userId  = $_SESSION['user_id'];
$footer_admin = $_SESSION['footer_admin'];
$userFirstName = $_SESSION['user_fname'];





$sales_app = <<<SALESAPP

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/indexSales.css">
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/ajaxTimeout.js"></script>
<script type="text/javascript" src="../scripts/backToAccess.js"></script>
<title>$admin_header</title>
</head>

<body>
<input id="goBackAccess" name="goBackAccess" value="Go Back" class="button1" type="submit">
<div id="headerHouse" class="headerHouse">
<div id="headerImg" class="headerImg">
<div class="imgPos">
<img src="../images/logo2.gif" border="0" />
</div>
</div>
</div>

<div id= "divStripe1" class="divStripe1">
</div>

<div id= "divStripe2" class="divStripe2">
<div class="topMenu">
  <a href="salesForm.php#new_member" target="content">New Member Application</a>
  <a href="scheduleUpdate.php" target="content">Sales Shedule</a>
  <a href="salesForm.php#searchIt" target="content">Search Member</a>
</div>
<div id="logTxt" class="logTxt">
<div class="txtForm">
<span class="hello">Hello $userFirstName</span>
| <span class="log"><a class="logOut" href = "../mainLogin.php">Log out</a></span>
<br>
Logged In:  $user
</div>
</div>
</div>


<div id="container" class="container">

<div id="contentHeader" class="contentHeader">
$admin_header  
</div>

<div id="contentFrame" class="contentFrame">
<iframe src="salesForm.php" width="1040" height="520" frameborder="0" name="content" id="content" scrolling="auto">
</iframe>
</div>

</div>

<div class="footer">
$footer_admin
<img src="../images/logo_mantistree.png" class="logo_mantistree" />
</div>  

<script>
  $(document).ready(function(){
    $("#container").height($(document).height() - $("#headerHouse").height() - $("#divStripe1").height() - $("#divStripe2").height() - $(".footer").height());
    $("#contentFrame").height($("#container").height());
    $("#content").height($("#container").height());
    /**/
    $("#container").width($(document).width());
    $("#contentHeader").width($("#container").width() - parseInt($("#contentHeader").css("padding-left").replace("px", "")));
    $("#contentFrame").width($("#container").width());
    $("#content").width($("#container").width());
    /**/
  });
</script>

</body>
</html>
SALESAPP;

echo"$sales_app";

?>