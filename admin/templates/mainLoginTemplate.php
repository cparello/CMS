<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$loginForm= <<<LOGFORM
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/mainLogin_v1.css">
<script type="text/javascript" src="scripts/mainLogin.js"></script>
<script type="text/javascript" src="scripts/sendPass.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>$header_admin</title>
</head>
<body>


<div class="logForm">
  <form id="form1" name="form1" method="post" action="/admin/accessPoint.php" onSubmit="return send_id()">
    <table align="center">
        <tr>
        <td class="header" colspan="2">
        $header_admin
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
        <td class="left bottom">        
        <a href="#" onclick="return sendPass(1);" class="forgot">Forgot your password?</a>
        </td>
        <td class="right bottom">
        <input type="submit" name="Submit" value="Log In" class="button"/>
        </td>   
        </tr>        
        </table>
        </td>
        </tr>
   
       <tr>
       <td align="left" class="padLeft bottom">
       <img src="images/cmp_logo_login.png" border="0" />
        </td>
        <td align="right" class="copyWrite padRight bottom">
        $footer_admin
        </td>
        </tr>
        
       </table>
       
       
       
       
  </form>
  
  </div>

</body>
</html>
LOGFORM;

echo "$loginForm";
?>