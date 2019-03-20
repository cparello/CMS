<?php
$employeeServiceListsTemplate = <<<SERVICELIST

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/service_lists.css">
<link rel="stylesheet" href="../css/info.css">
<script type="text/javascript" src="../scripts/employeeServiceLists.js"></script>
$javaScript1
$javaScript2


<title>Edit  Add Employee Services</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
Edit Services For $emp_name 
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
$string_list

$save_button
</table>
</div>



<div class="popHint" id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit" id="popup_exit" src="../images/popx.png" alt="" />
<span id="contHint">
</span>
</div>
</div>


</body>
</html>
SERVICELIST;

echo"$employeeServiceListsTemplate";

?>