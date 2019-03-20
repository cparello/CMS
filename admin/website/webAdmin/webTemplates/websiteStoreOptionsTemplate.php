<?php
$salesPayrollTemplate = <<<CYCLETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html> 

<head>
<link rel="stylesheet" href="../../css/fees.css">
<link rel="stylesheet" href="../../css/pop_hint.css">
<link rel="stylesheet" href="../../css/info.css">
<style>
.button {
   border-top: 1px solid #bdbec0;
   background: #bdbec0;
   background: -webkit-gradient(linear, left top, left bottom, from(#bdbec0), to(#bdbec0));
   background: -webkit-linear-gradient(top, #bdbec0, #bdbec0);
   background: -moz-linear-gradient(top, #bdbec0, #bdbec0);
   background: -ms-linear-gradient(top, #bdbec0, #bdbec0);
   background: -o-linear-gradient(top, #bdbec0, #bdbec0);
   padding: 20px 40px;
   -webkit-border-radius: 0px;
   -moz-border-radius: 0px;
   border-radius: 0px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 24px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;
   }
.button:hover {
   border-top-color: #030303;
   background: #030303;
   color: #ffffff;
   }
.button:active {
   border-top-color: #8bc63f;
   background: #8bc63f;
   }
</style>
<script src="../../scripts/jqueryNew.js" type="text/javascript"></script>
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
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">

<table border="0" align="center" cellspacing="0" cellpadding="0">



$htmlCheckList

<tr>
<td  colspan="2" align="left">
<br>

<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>




<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>
</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
CYCLETEMPLATE;


echo"$salesPayrollTemplate";

?>


