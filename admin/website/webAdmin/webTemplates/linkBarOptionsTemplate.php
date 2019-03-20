<?php
$userTemplate = <<<PAYOPSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="webCss/linkBar_options.css">
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
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return setBitMaps();">

<table border="0" width="80%" align="center">
<tr>
<td colspan="5" class="grey" align="left">
<center><u>Link Bar Edit</u></center>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Link Bar Text Color:</center>
</td>
<td>
<input id="navTextColor" type="text" maxlength="6" size="45" value="$navTextColor" name="navTextColor" tabindex="5"></input><a href="javascript: void" id="pos99" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos99', 99 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td colspan="5" class="grey" align="left">
<center><u><h3>About Us</h3></u>
All:&nbsp;<select tabindex= "1" name="aboutUs" id="aboutUs"></center>
<option value="$aboutUs" selected>$aboutUs</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>

<table align=\"center\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
<tbody>
<tr>
<td class="black">
Going Green: &nbsp;<center><select tabindex= "1" name="goingGreen" id="goingGreen"></center>
<option value="$goingGreen" selected>$goingGreen</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Schedule a Visit: &nbsp;<center><select tabindex= "1" name="visit" id="visit"></center>
<option value="$visit" selected>$visit</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>  
<td>
<td class="black">
Owner Information: &nbsp;<center><select tabindex= "1" name="ownerInfo" id="ownerInfo"></center>
<option value="$ownerInfo" selected>$ownerInfo</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Our Mission: &nbsp;<center><select tabindex= "1" name="mission" id="mission"></center>
<option value="$mission" selected>$mission</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<td>
<td class="black">
Contact Us: &nbsp;<center><select tabindex= "1" name="contact" id="contact"></center>
<option value="$contact" selected>$contact</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<td>
<td class="black">
Photo Gallery: &nbsp;<center><select tabindex= "1" name="photo" id="photo"></center>
<option value="$photo" selected>$photo</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<td>
</tr>
</tbody></table>



<tr>
<td colspan="5" class="grey" align="left">
<center><u><h3>Classes</h3></u>
All:&nbsp;<select tabindex= "1" name="classes" id="classes"></center>
<option value="$classes" selected>$classes</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../../images/question-mark.png" class="alignTop"></a>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>


<table align=\"center\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
<tbody>
<tr>
<td class="black">
Schedule: &nbsp;<center><select tabindex= "1" name="schedule" id="schedule"></center>
<option value="$schedule" selected>$schedule</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Class Descriptions: &nbsp;<center><select tabindex= "1" name="classDescriptions" id="classDescriptions"></center>
<option value="$classDescriptions" selected>$classDescriptions</option>  
<<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Instructors: &nbsp;<center><select tabindex= "1" name="instructors" id="instructors"></center>
<option value="$instructors" selected>$instructors</option>  
<<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
</tr>

<tr>
<td class="black">
Group Fitness: &nbsp;<center><select tabindex= "1" name="groupx" id="groupx"></center>
<option value="$groupx" selected>$groupx</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Spinning: &nbsp;<center><select tabindex= "1" name="spinning" id="spinning"></center>
<option value="$spinning" selected>$spinning</option>  
<<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td>
<td class="black">
Yoga: &nbsp;<center><select tabindex= "1" name="yoga" id="yoga"></center>
<option value="$yoga" selected>$yoga</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Boxing: &nbsp;<center><select tabindex= "1" name="boxing" id="boxing"></center>
<option value="$boxing" selected>$boxing</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td>
<td class="black">
Zumba: &nbsp;<center><select tabindex= "1" name="zumba" id="zumba"></center>
<option value="$zumba" selected>$zumba</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
</tr>
</tbody></table>

<tr>
<td>
&nbsp;
</td>
</tr>

<tr>
<td colspan="5" class="grey" align="left">
<center><u><h3>Personal Training</h3></u>
All:&nbsp;<select tabindex= "1" name="pt" id="pt"></center>
<option value="$pt" selected>$pt</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3 );" /><img src="../../images/question-mark.png" class="alignTop"></a>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>


<table align=\"center\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
<tbody>
<tr>
<td class="black">
Trainers: &nbsp;<center><select tabindex= "1" name="trainer" id="trainer"></center>
<option value="$trainer" selected>$trainer</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Packages: &nbsp;<center><select tabindex= "1" name="package" id="package"></center>
<option value="$package" selected>$package</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td>
<td class="black">
Small Group Training: &nbsp;<center><select tabindex= "1" name="groupTrain" id="groupTrain"></center>
<option value="$groupTrain" selected>$groupTrain</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Training Information: &nbsp;<center><select tabindex= "1" name="trainInfo" id="trainInfo"></center>
<option value="$trainInfo" selected>$trainInfo</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
</tr>
</tbody></table>

<tr>
<td>
&nbsp;
</td>
</tr>

<tr>
<td colspan="5" class="grey" align="left">
<center><u><h3>Newsletter</h3></u>
All:&nbsp;<select tabindex= "1" name="news" id="news"></center>
<option value="$news" selected>$news</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4 );" /><img src="../../images/question-mark.png" class="alignTop"></a>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>

<table align=\"center\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
<tbody>
<tr>
<td class="black">
Sign up: &nbsp;<center><select tabindex= "1" name="newsSign" id="newsSign"></center>
<option value="$newsSign" selected>$newsSign</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Cancel: &nbsp;<center><select tabindex= "1" name="newsCanc" id="newsCanc"></center>
<option value="$newsCanc" selected>$newsCanc</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<td>
<td class="black">
View Newsletter: &nbsp;<center><select tabindex= "1" name="viewNews" id="viewNews"></center>
<option value="$viewNews" selected>$viewNews</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
</tr>
</tbody></table>

<tr>
<td>
&nbsp;
</td>
</tr>

<tr>
<td colspan="5" class="grey" align="left">
<center><u><h3>Store</h3></u>
All:&nbsp;<select tabindex= "1" name="store" id="store"></center>
<option value="$store" selected>$store</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5 );" /><img src="../../images/question-mark.png" class="alignTop"></a>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
</tr>


<table align=\"center\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
<tbody>
<tr>
<td class="black">
Clearance: &nbsp;<center><select tabindex= "1" name="clearence" id="clearence"></center>
<option value="$clearence" selected>$clearence</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Gear: &nbsp;<center><select tabindex= "1" name="gear" id="gear"></center>
<option value="$gear" selected>$gear</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>  
<td>
<td class="black">
Catalog: &nbsp;<center><select tabindex= "1" name="catalog" id="catalog"></center>
<option value="$catalog" selected>$catalog</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td class="black">
Supplements: &nbsp;<center><select tabindex= "1" name="supp" id="supp"></center>
<option value="$supp" selected>$supp</option>  
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<td>
</tr>
</tbody></table>

<tr>
<td colspan="5" align="left" class="subPad">
<a class="more up bold" target="" title="$page_title">
<center><button class="button" type="submit" value="login" name="Update">$page_title</button></center>
</a>
<input type="hidden" name="marker" value="1" />
$hidden
<input type="hidden" name="gen_bit"  id="gen_bit" value=""/>
<input type="hidden" name="month_bit"  id="month_bit" value=""/>

</form>
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
PAYOPSTEMPLATE;


echo"$userTemplate";

?>
