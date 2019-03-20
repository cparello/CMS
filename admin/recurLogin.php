<?php
session_start();
$_SESSION['admin_access'] = "Cartman";
$_SESSION['file_permissions'];
include  "dbConnect.php";
include "headFoot.php";

$getHeadFoot = new headFoot();
$getHeadFoot -> loadNames();


//get the date
$year = $getHeadFoot -> getFooterDate();
//get the Nick name for the busines
$nick_name = $getHeadFoot -> getBusinessNickName();
//get the full name for the business
$full_name = $getHeadFoot -> getBusinessName(); 
//for the copywrite name
$copy_name = $getHeadFoot -> getCopyWriteName();

$_SESSION['nick'] = $nick_name;

//create the fotter to pass on to subsequent pages
$footer_admin = "&copy; $year  $copy_name";
$_SESSION['footer_admin'] = $footer_admin;

//create the title of the admin pages
$header_admin = "$nick_name Recursive Billing Portal";
$_SESSION['header_admin'] = $header_admin;



?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/mainLogin.css">
<script type="text/javascript" src="scripts/mainLogin.js"></script>
<script type="text/javascript" src="scripts/sendPass.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title> <?php echo $header_admin ?></title>
</head>
<body>


<div class="logForm">
  <form id="form1" name="form1" method="post" action="/admin/billingPortal.php" onSubmit="return send_id()">
    <table align="center">
        <tr>
        <td class="header" colspan="2">
        <?php echo $header_admin ?>
        </td>
        </tr> 
         
        <tr>
        <td colspan="2">
        <table align="center" class="tabTwo">       
        <tr>       
        <th colspan="2">
         Username:
        </th>   
        </tr>        
        <tr>       
        <td colspan="2">
        <input name="username" type="text" id="username" size="25" maxlength="50" />
        </td>    
        </tr>      
        <tr>
        <th colspan="2">
        Password:
        </th>     
        </tr>        
        <tr>     
        <td colspan="2">
        <input name="password" type="password" id="password" size="25" maxlength="10" />
        </td> 
        </tr>      
        <tr>
        <td id="idContent1" colspan="2">   
        </td>              
        </tr>      
        <tr>             
        <td class="left">        
        <a href="#" onclick="return sendPass(1);" class="forgot">Forgot your Password?</a>
        </td>
        <td class="right">
        <input type="submit" name="Submit" value="Log In" class="button"/>
        </td>   
        </tr>        
        </table>
        </td>
        </tr>
   
       <tr>
       <td align="left" class="padLeft">
       <img src="images/cmp_logo_login.png"border="0" \>
        </td>
        <td align="right" class="copyWrite padRight">
        <?php echo $footer_admin ?>
        </td>
        </tr>
        
       </table>
       
       
       
       
  </form>
  
  </div>

</body>
</html>