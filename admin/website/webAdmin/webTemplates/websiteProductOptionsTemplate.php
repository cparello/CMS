<?php

$back2list_text = $_REQUEST['cat']?"Back (to the products list)":"To the Products List";
//$back2list_tail = $_REQUEST['cat']?"?search_type=cat&pos_category=$_REQUEST[categoryName]":"";
$back2list_tail = $_REQUEST['cat']?"?marker=1&search_type=cat&pos_category=$_REQUEST[cat]":"";

$salesPayrollTemplate = <<<CYCLETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html> 

<head>
<link rel="stylesheet" href="../../css/fees.css">
<link rel="stylesheet" href="../../css/pop_hint.css">
<link rel="stylesheet" href="../../css/info.css">
<link rel="stylesheet" href="../../css/website_admin.css">
<style>
.button {
   border-top: 1px solid #bdbec0;
   background: #bdbec0;
   background: -webkit-gradient(linear, left top, left bottom, from(#bdbec0), to(#bdbec0));
   background: -webkit-linear-gradient(top, #bdbec0, #bdbec0);
   background: -moz-linear-gradient(top, #bdbec0, #bdbec0);
   background: -ms-linear-gradient(top, #bdbec0, #bdbec0);
   background: -o-linear-gradient(top, #bdbec0, #bdbec0);
   padding: 10px; /*20px 40px;*/
   -webkit-border-radius: 0px;
   -moz-border-radius: 0px;
   border-radius: 0px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 20px; /*24px;*/
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;
   width: 300px;
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
<script src="webScripts/loadItemStoreSetup.js" type="text/javascript"></script>
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
<tr>
<td align="left" colspan="2" class="grey">
<center><u>Website Product Info</u>   </center> 
</td>
</tr>

<tr>
<td class="black">
1.  Select Product:&nbsp;&nbsp;
</td>
<td>
<select name="itemId"  id="itemId" class="black3" onChange="$('#load').click();" />
<option value="$itemId" selected>$product_desc</option>
$type_select
</select>
</td>
</tr>

<tr>
<td class="black" valign="top">
2. Product Description:&nbsp;&nbsp;
</td>
<td>
<textarea class="notes" cols="48" rows="2" id="itemDescription" name="itemDescription">$itemDescription</textarea>
</td>
</tr>


<tr>
<td class="black" width="225">
3. Product Photo:
</td>
<td>
<img src="$dir$itemPicture" alt="$product_desc" class="itemPicture_img" />
<select tabindex= "1" name="itemPicture" id="itemPicture"></center>
 <option value="$itemPicture" selected>$itemPicture</option>
$dropOptions
</select><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4);" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>


<tr>
<td  colspan="2" align="left">
<br>
<div align="center">
<a class="more up bold" target="" title="$submit_title">
<button class="button" type="submit" value="login" name="Update">$submit_title</button>
</a>
<br /><br />
<a class="more up bold" target="" title="(Re)Load Product Details">
<button class="button" type="submit" value="login" id="load" name="load">(Re)Load Product Details</button>
</a>
<input type="hidden" id="marker" name="marker" value="1" />
<input type="hidden" id="search_type" name="search_type" value="$_REQUEST[search_type]" />
<input type="hidden" id="cat" name="cat" value="$_REQUEST[cat]" />
</form>
<br /><br />
<a href="../../pos/searchInventory.php$back2list_tail" class="more up bold" target="content" title="$back2list_text">
<button class="button" type="button" value="back2list" id="back2list" name="back2list">$back2list_text</button>
</a>
</div>
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


