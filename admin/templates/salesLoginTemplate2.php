<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$loginForm= <<<LOGFORM
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/mainLogin_v1.css">
<script type="text/javascript" src="../scripts/loginSales2.js"></script>
<script type="text/javascript" src="../scripts/sendEmployeeId.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>$header_admin</title>
</head>
<body>

<div id="headerButThree">
<form id="form9" name="form9" method="post" action="masterScheduleUpdate.php" ">
  <button class="buttonSched" name="schedule" value="Sales Schedule" type="buttonSched">Sales Schedule</button>
  <input type="hidden" id="start_range" name="start_range" value="$start_range" />
  <input type="hidden" id="end_range" name="end_range" value="$end_range" />
</form>
</div>
<div class="logForm">
  <form id="form1" name="form1" method="post" action="indexSales.php" onSubmit="return send_id()">
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
         Employee Id:
        </th>   
        </tr>        
        <tr>       
        <td colspan="2">
        <input name="id_card" type="text" id="id_card" size="25" maxlength="20" />
        </td>    
        </tr>             
        <td id="idContent1" colspan="2">   
        </td>              
        </tr>      
        <tr>             
        <td class="left">        
        <a href="#" onclick="return sendEmployeeId(2);" class="forgot">Forgot your Employee ID?</a>
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
       <img src="../images/cmp_logo_login.png"border="0" \>
        </td>
        <td align="right" class="copyWrite padRight">
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