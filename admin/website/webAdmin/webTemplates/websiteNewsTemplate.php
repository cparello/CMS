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
<center><u>Website Newsletter Setup</u>   </center> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Owners Letter:</center>
</td>
<td>
<textarea class="notes" name="ownersLetter" rows="2" cols="48">$ownersLetter</textarea>
<a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Club News:</center>
</td>
<td>
<textarea class="notes" name="clubNews" rows="2" cols="48">$clubNews</textarea><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Special Offer:</center>
</td>
<td>
<textarea class="notes" name="specialOffer" rows="2" cols="48">$specialOffer</textarea><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Q and A:</center>
</td>
<td>
<textarea class="notes" name="qna" rows="2" cols="48">$qna</textarea><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Testimonials:</center>
</td>
<td>
<textarea class="notes" name="testimonials" rows="2" cols="48">$testimonials</textarea><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Upcoming Events:</center>
</td>
<td>
<textarea class="notes" name="upcomingEvents" rows="2" cols="48">$upcomingEvents</textarea><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos6', 6 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>New Partnership:</center>
</td>
<td>
<textarea class="notes" name="partner" rows="2" cols="48">$partner</textarea><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos7', 7 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Misc 1:</center>
</td>
<td>
Title:<input  name="misc1T" type="text" id="misc1T" value="$misc1T" size="20" maxlength="30" />
<textarea class="notes" name="misc1C" rows="2" cols="48">$misc1C</textarea><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos8', 8 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Misc 2:</center>
</td>
<td>
Title:<input  name="misc2T" type="text" id="misc2T" value="$misc2T" size="20" maxlength="30" />
<textarea class="notes" name="misc2C" rows="2" cols="48">$misc2C</textarea><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos9', 9 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>



<tr>
<td  colspan="2" align="left">
<br>
<a class="more up bold" target="" title="$submit_title">
<center><button class="button" type="submit" value="login" name="Update">$submit_title</button></center>
</a>
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


