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



$sql = "SELECT billing FROM access_app WHERE user_id = '$userId'";
$stmt = $dbMain->prepare($sql);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing);
$stmt->fetch();
$stmt->close();  

//echo "$userId";
for($i=0;$i<=5;$i++){
    $year = date("Y");
    $year -= $i;
    $yearDrop .= "<option value=\"$year\">$year</option>";
}

$login_menu = <<<LOGMEN

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>


<link rel="stylesheet" href="css/billingPortal_v1.css">
<style>
body {
    text-align: center;
    background: #003D5C;
    margin: 0px;
}
</style>
<script type="text/javascript" src="scripts/jqueryNew.js"></script>
<script type="text/javascript" src="scripts/billingPortalTests_v1.js"></script>
<title>Untitled</title>
</head>
<body>
<div id="headerHouse" class="headerHouse">
<div id="headerImg" class="headerImg">
<div class="imgPos">
<img src="images/logo.jpg"border="0"\ >
</div>
</div>
</div>

<div id= "divStripe1" class="divStripe1">
</div>

<div id= "divStripe2" class="divStripe2">
<div id="logTxt" class="logTxt">
<div class="txtForm">
<span class="hello">Hello $userFirstName</span>
<span class="log"><a class="logOut" href = "recurLogin.php">Log out</a></span>
<br>
Logged In:  $user 
</div>
</div>
</div>


<div id="container" class="container">
<div class="block p1x1 s1x1">
        <span  id="preview"><p>Preview Todays Billing</p></span> 
        
        <br>
        Billing Date: &nbsp;<input name="day" id="day" size="5" maxlength="2" type="text"></input>
        <br>
        <br>
        <table align="center" cellpadding="3" cellspacing="3">
        <tr>
        <td>Monthly</td>
        <td>RF</td>
        <td>EF</td>
        <td>MF</td>
        </tr>
        <tr>
        <td><input name="monthly" id="monthly" size="5" maxlength="2" type="text"></input></td>
        <td><input name="rf" id="rf" size="5" maxlength="2" type="text"></input></td>
        <td><input name="ef" id="ef" size="5" maxlength="2" type="text"></input></td>
        <td><input name="mf" id="mf" size="5" maxlength="2" type="text"></input></td>
        </tr>
        </table>
</div>
<div class="block p1x2 s1x1">
       <span  id="preload"><p>Pre-Load All Billing</p></span>
       
        <br>
        Billing Date: &nbsp;<input name="day2" id="day2" size="5" maxlength="2" type="text"></input>
       <br>
        <br>
        <table align="center" cellpadding="3" cellspacing="3">
        <tr>
        <td>Monthly</td>
        <td>RF</td>
        <td>EF</td>
        <td>MF</td>
        </tr>
        <tr>
        <td><input name="monthly2" id="monthly2" size="5" maxlength="2" type="text"></input></td>
        <td><input name="rf2" id="rf2" size="5" maxlength="2" type="text"></input></td>
        <td><input name="ef2" id="ef2" size="5" maxlength="2" type="text"></input></td>
        <td><input name="mf2" id="mf2" size="5" maxlength="2" type="text"></input></td>
        </tr>
        </table>
</div>
<div class="block p1x3 s1x1">
       <span  id="build"><p>Build Batch File</p></span><br>
       <table align="center" cellpadding="6" cellspacing="6">
        <tr>
        <td>Record Count</td>
        <td></td>
        </tr>
        <tr>
        <td><input name="records" id="records" size="5" maxlength="2" type="text"></input></td>
        <td><button class="button" name="upload" id="upload">Upload File</button></td>
        
        </tr>
        </table>
       
</div>
<div class="block p2x1 s1x1">
        <p>Download & Process Response File</p>  
</div>
<div class="block p2x2 s1x1">
        <h3>View Billing Preview</h3> 
        <table  align="center" border="0" cellpadding="4" cellspacing="0" width="60%">
        <tbody>
        <tr>
        <td>Month</td>
        <td><select name="monthP" id="monthP">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
        </select></td>
        </tr>
        <tr>
        <td>
        Day
        </td>
        <td>
        <select name="dayP" id="dayP">
        <option value="01">1</option>
        <option value="02">2</option>
        <option value="03">3</option>
        <option value="04">4</option>
        <option value="05">5</option>
        <option value="06">6</option>
        <option value="07">7</option>
        <option value="08">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">17</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        </select>
        </td>
        </tr>
        <tr>
        <td>Year</td>
        <td>
        <select name="yearP" id="yearP">
            <option value="">Year</option>
           $yearDrop
            </select>
            </td>
        </tr>
        <tr>
          <td>Fee</td>
            <td>
        <select name="fee" id="fee">
            <option value="RF">Rate Guarentee Fee</option>
            <option value="MS">Monthly Service</option>
            <option value="EF">Enhance Fee</option>
            <option value="MF">Maintenance Fee</option>
            </select>
            </td>
        </tr>
         </tbody>
         </table>
         <br>
         <button class="button" name="view" id="view">View List</button> <button class="button" name="view3" id="view3">View Summary</button>
         
</div>
    <div class="block p2x3 s1x1">
              <h3>View Actual Billing</h3> 
        <table  align="center" border="0" cellpadding="4" cellspacing="0" width="60%">
        <tbody>
        <tr>
        <td>Month</td>
        <td><select name="monthP2" id="monthP2">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
        </select></td>
        </tr>
        <tr>
        <td>
        Day
        </td>
        <td>
        <select name="dayP2" id="dayP2">
        <option value="01">1</option>
        <option value="02">2</option>
        <option value="03">3</option>
        <option value="04">4</option>
        <option value="05">5</option>
        <option value="06">6</option>
        <option value="07">7</option>
        <option value="08">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">17</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        </select>
        </td>
        </tr>
        <tr>
        <td>Year</td>
        <td>
        <select name="yearP2" id="yearP2">
            <option value="">Year</option>
           $yearDrop
            </select>
            </td>
        </tr>
        <tr>
            <td>Fee</td> 
             <td>
        <select name="fee2" id="fee2">
            <option value="RF">Rate Guarentee Fee</option>
            <option value="MS">Monthly Service</option>
            <option value="EF">Enhance Fee</option>
            <option value="MF">Maintenance Fee</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Approved/Failed</td>
            <td>
                <select name="passFail" id="passFail">
                <option value="1">Approved</option>
                <option value="0">Failed</option>
                </select>
            </td>
        </tr>
        
        
         </tbody>
         </table>
         <br>         
         <button class="button" name="view2" id="view2">View List</button><button class="button" name="view4" id="view4">View Summary</button>
         
</div>
</div>

<input type="hidden" id="billing" name="billing" value="$billing"/>
<input type="hidden" id="filename" name="filename" value=""/>
<div class="footer">
$footer_admin
</div>  

</body>
</html>
LOGMEN;

echo"$login_menu";

?>