<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//echo "tets";
//get the session vars for index menu for the menu page
$admin_header = $_SESSION['header_admin'];
$filePerm = $_SESSION['file_permissions']; 
$user  =  $_SESSION['user_name'];
$userId  = $_SESSION['user_id'];
$footer_admin = $_SESSION['footer_admin'];
$userFirstName = $_SESSION['user_fname'];


/*include "getLinks.php";

//get the file permissions
$file_permissions = $_SESSION['file_permissions'];

$getMenu = new getLinks();
$getMenu -> setFilePerms($file_permissions);
$getMenu -> loadMenus();
$handle =  $getMenu -> getFileLinks();
*/
include 'dbConnect.php';

$clubDrop = "";
$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id); 
while ($stmt->fetch()) {
    $clubName = trim($clubName);
    $clubDrop .= '<option value="' . $club_id . '">' . $clubName . '</option>';
}



$sql = "SELECT check_in, mem_int, sales, admin, sales_schedule FROM access_app WHERE user_id = '$userId'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($check_in, $mem_int, $sales, $admin, $sales_schedule);
$stmt->fetch();
$stmt->close();  

//echo "$userId";

$login_menu = <<<LOGMEN

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/accessPoint_v1.css">
<script type="text/javascript" src="scripts/jqueryNew.js"></script>
<script type="text/javascript" src="scripts/checkIdTest_v2.js"></script>
<title>Dashboard</title>
</head>

<body>
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
<div class="block p1x1 s1x1">
       <div class="pic1">
        <p>Check In</p>
       </div> 
        <b>Club:</b>&nbsp;<select id="locationSnap" name="locationSnap">
            <option value="">Select a Club</option>
            $clubDrop       
        </select>
</div>
<div class="block p1x2 s1x1">
       <div class="pic2">
          <p>Member Interface</p> 
       </div>
       <b>Club:</b>&nbsp;<select id="locationMem" name="locationMem">
            <option value="">Select a Club</option>
            $clubDrop       
        </select>
</div>
<div class="block p2x1 s1x1">
    <div class="sales">
        <p>Sales</p> 
    </div> 
</div>
<div class="block p2x2 s1x1">
    <div class="admin">
        <p>Admin</p> 
    </div>         
      
</div>
<div class="block p3x1 s1x1">
        <div class="pic5">
         <p>Sales Schedule</p> 
        </div>
        <b>Club:</b>&nbsp;<select id="locationSched" name="locationSched">
            <option value="">Select a Club</option>
            $clubDrop       
        </select>  
</div>
</div>
<input type="hidden" id="check_in" name="check_in" value="$check_in"/>
<input type="hidden" id="mem_int" name="mem_int" value="$mem_int"/>
<input type="hidden" id="sales" name="sales" value="$sales"/>
<input type="hidden" id="admin" name="admin" value="$admin"/>
<input type="hidden" id="sales_sched" name="sales_sched" value="$sales_schedule"/>
<div class="footer">
$footer_admin
</div>  

</body>
</html>
LOGMEN;

echo"$login_menu";

?>