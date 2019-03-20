<?php
$searchTemplate = <<<SEARCHTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/search_services.css">
$javaScript1
$javaScript2
$javaScript3


	<title>Search Edit Accounts</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
Search Client Accounts  
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by:</u>
</td>
</tr>
<tr>
<td>
<select name="search_by" id="search_by">
<option value="1">Contract Holder Name</option>
<option value="2">Contract ID Number</option>
<option value="3">Group, Organization or Family Name</option>
<option value="4">Last 4 of Credit Card Number</option>
<option value="5">Member Name</option>
<option value="6">Last 4 of Bank Account Number</option>
</select> 
</td>
</tr>
<tr>
<td>
<input  name="search_name" type="text" id="search_name" size="25"  onkeypress="searchKeyPress(event);" maxlength="30"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="name"  id="name" value="Search" onClick="return searchMembers(this.id);"/>
</td>
</tr>
</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>


<script>
    function searchKeyPress(e)
    {
        if (typeof e == 'undefined' && window.event) { e = window.event; }
        if (e.keyCode == 13)
        {
            document.getElementById('name').click();
        }
    }
    </script>
</body>
</html>
SEARCHTEMPLATE;


echo"$searchTemplate";
?>