<?php
$userTemplate = <<<USERTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/users.css">
<link rel="stylesheet" href="css/pop_hint.css">
<link rel="stylesheet" href="css/info.css">
<script type="text/javascript" src="scripts/jqueryNew.js"></script>
<script type="text/javascript" src="scripts/acessApp.js"></script>
$javaScript1
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="userForm">
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return send_id()">

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>User Information</u>
</td>
</tr>

<tr>
<td class="black">
First Name:
</td>
<td>
<input tabindex= "1" name="first_name" type="text" id="first_name" value= "$first_name" size="25" maxlength="30" onFocus="killHeader()"/>    
<td>
</tr>

<tr>
<td class="black">
Last Name:
</td>
<td>
<input tabindex= "2" name="last_name" type="text" id="last_name" value="$last_name" size="25" maxlength="30"/>    
<td>
</tr>


<tr>
<td class="black">
User Name:
</td>
<td>
<input tabindex= "3" name="username" type="text" id="username" value="$username"size="25" maxlength="50"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1 );" /><img src="images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Password:
</td>
<td>
<input tabindex= "4" name="password" type="text" id="password" value="$password" size="25" maxlength="10"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="images/question-mark.png" class="alignMiddle"></a>        
<td>
</tr>

<tr>
<td colspan="2" class="grey">
<u>Access Level</u>
</td>
</tr>

$handle

<tr>
<td colspan="2" class="grey">
<u>App Acess</u>
</td>
</tr>

<tr>
<td class="black">
Checkin Interface:
</td>
<td>
<input type="checkbox" id="checkin" name="checkin" value="15" $checkedCheckin>    
<td>
</tr> 

<tr>
<td class="black">
Member Interface:
</td>
<td>
<input type="checkbox" id="memint" name="memint" value="15" $checkedMemint>    
<td>
</tr> 

<tr>
<td class="black">
Sales Interface:
</td>
<td>
<input type="checkbox" id="sales"  name="sales" value="15" $checkedSales>    
<td>
</tr> 

<tr>
<td class="black">
Admin Interface:
</td>
<td>
<input type="checkbox"  id="admin" name="admin" value="15" $checkedAdmin>    
<td>
</tr> 

<tr>
<td class="black">
Sales Schedule:
</td>
<td>
<input type="checkbox" id="schedule" name="schedule" value="15" $checkedSched>    
<td>
</tr> 

<tr>
<td class="black">
Billing Interface:
</td>
<td>
<input type="checkbox" id="billing" name="billing" value="15" $checkedBill>    
<td>
</tr> 

<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="$submit_name" value="$page_title" />
<input type="hidden" name="marker" value="1" />
<input type="hidden" id="checkinHID" name="checkinHID" value="$checkIn" />
<input type="hidden" id="memintHID" name="memintHID" value="$memInt" />
<input type="hidden" id="salesHID" name="salesHID" value="$sales" />
<input type="hidden" id="adminHID" name="adminHID" value="$admin" />
<input type="hidden" id="scheduleHID" name="scheduleHID" value="$schedule" />
<input type="hidden" id="billingHID" name="billingHID" value="$billing" />
$hidden
</td>
</tr>

<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>


</form>
</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
USERTEMPLATE;


echo"$userTemplate";

?>


