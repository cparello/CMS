<?php
//echo "test";
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
<center><u>Website Join Page Setup</u>   </center> 
</td>
</tr>


<tr>
<td class="black" width="225">
<center>Number of Website Membership Options:</center>
</td>
<td>
<input id="numberMemberships" type="text" maxlength="1" size="45" value="$numberMemberships" name="numberMemberships" tabindex="5"></input><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership Option 1:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem1" id="mem1"></center>
$m1Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership1" id="membership1"></center>
<option value="$membership1" selected>$membership1</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership Option 2:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem2" id="mem2"></center>
$m2Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership2" id="membership2"></center>
<option value="$membership2" selected>$membership2</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>


<tr>
<td class="black">
<center>Membership Option 3:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem3" id="mem3"></center>
$m3Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership3" id="membership3"></center>
<option value="$membership3" selected>$membership3</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership Option 4:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem4" id="mem4"></center>
$m4Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership4" id="membership4"></center>
<option value="$membership4" selected>$membership4</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership Option 5:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem5" id="mem5"></center>
$m5Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership5" id="membership5"></center>
<option value="$membership5" selected>$membership5</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos6', 6 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>


<tr>
<td class="black">
<center>Membership Option 6:</center>
</td>
<td>
<center>Highlight<select tabindex= "1" name="mem6" id="mem6"></center>
$m6Selected
<option value="1">Yes</option>  
<option value="0">No</option> 
</select><select tabindex= "1" name="membership6" id="membership6"></center>
<option value="$membership6" selected>$membership6</option>  
$membershipSelecthtml
</select><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos7', 7 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<center><u>Membership Descriptions</u>   </center> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 1:</center>
</td>
<td>
<textarea class="notes" name="descrip1" rows="2" cols="48">$descrip1</textarea><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos8', 8 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 2:</center>
</td>
<td>
<textarea class="notes" name="descrip2" rows="2" cols="48">$descrip2</textarea><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos9', 9 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 3:</center>
</td>
<td>
<textarea class="notes" name="descrip3" rows="2" cols="48">$descrip3</textarea><a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos10', 10 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 4:</center>
</td>
<td>
<textarea class="notes" name="descrip4" rows="2" cols="48">$descrip4</textarea><a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos11', 11 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 5:</center>
</td>
<td>
<textarea class="notes" name="descrip5" rows="2" cols="48">$descrip5</textarea><a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos12', 12 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Membership 6:</center>
</td>
<td>
<textarea class="notes" name="descrip6" rows="2" cols="48">$descrip6</textarea><a href="javascript: void" id="pos13" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos13', 13 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<center><u>Colors</u>   </center> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Title Background Color:</center>
</td>
<td>
<input id="boxColor" type="text" maxlength="6" size="45" value="$boxColor" name="boxColor" tabindex="5"></input><a href="javascript: void" id="pos14" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos14', 14 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Title Text Color:</center>
</td>
<td>
<input id="textColor" type="text" maxlength="6" size="45" value="$textColor" name="textColor" tabindex="5"></input><a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos15', 15 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Title Promo Background Color:</center>
</td>
<td>
<input id="boxColorPromo" type="text" maxlength="6" size="45" value="$boxColorPromo" name="boxColorPromo" tabindex="5"></input><a href="javascript: void" id="pos14" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos14', 14 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black" width="225">
<center>Title Promo Text Color:</center>
</td>
<td>
<input id="textColorPromo" type="text" maxlength="6" size="45" value="$textColorPromo" name="textColorPromo" tabindex="5"></input><a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos15', 15 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<center><u>Marketing Upsell Options</u>   </center> 
</td>
</tr>

<tr>
<td class="black">
<center>Service Option 1:</center>
</td>
<td>
<center><select tabindex= "1" name="service1" id="service1"></center>
<option value="$service1" selected>$service1</option>  
$serviceSelecthtml
</select><a href="javascript: void" id="pos16" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos16', 16 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
<center>Service Photo 1:</center>
</td>
<td>
<center><select tabindex= "1" name="servicePhoto1" id="servicePhoto1"></center>
<option value="$servicePhoto1" selected>$servicePhoto1</option>  
$dropOptions1
</select><a href="javascript: void" id="pos161" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos161', 161 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Service Option 2:</center>
</td>
<td>
<center><select tabindex= "1" name="service2" id="service2"></center>
<option value="$service2" selected>$service2</option>  
$serviceSelecthtml
</select><a href="javascript: void" id="pos17" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos17', 17 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Service Photo 2:</center>
</td>
<td>
<center><select tabindex= "1" name="servicePhoto2" id="servicePhoto2"></center>
<option value="$servicePhoto2" selected>$servicePhoto2</option>  
$dropOptions2
</select><a href="javascript: void" id="pos171" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos171', 171 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Service Option 3:</center>
</td>
<td>
<center><select tabindex= "1" name="service3" id="service3"></center>
<option value="$service3" selected>$service3</option>  
$serviceSelecthtml
</select><a href="javascript: void" id="pos18" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos18', 18 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Service Photo 3:</center>
</td>
<td>
<center><select tabindex= "1" name="servicePhoto3" id="servicePhoto3"></center>
<option value="$servicePhoto3" selected>$servicePhoto3</option>  
$dropOptions3
</select><a href="javascript: void" id="pos181" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos181', 181 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Service Option 4:</center>
</td>
<td>
<center><select tabindex= "1" name="service4" id="service4"></center>
<option value="$service4" selected>$service4</option>  
$serviceSelecthtml
</select><a href="javascript: void" id="pos19" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos19', 19 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Service Photo 4:</center>
</td>
<td>
<center><select tabindex= "1" name="servicePhoto4" id="servicePhoto4"></center>
<option value="$servicePhoto4" selected>$servicePhoto4</option>  
$dropOptions4
</select><a href="javascript: void" id="pos191" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos191', 191 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Service Option 5:</center>
</td>
<td>
<center><select tabindex= "1" name="service5" id="service5"></center>
<option value="$service5" selected>$service5</option>  
$serviceSelecthtml
</select><a href="javascript: void" id="pos20" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos20', 20 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Service Photo 5:</center>
</td>
<td>
<center><select tabindex= "1" name="servicePhoto5" id="servicePhoto5"></center>
<option value="$servicePhoto5" selected>$servicePhoto5</option>  
$dropOptions5
</select><a href="javascript: void" id="pos201" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos201', 201 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<center><u>Marketing Upsell Gear</u>   </center> 
</td>
</tr>

<tr>
<td class="black">
<center>Gear Option 1:</center>
</td>
<td>
<center><select tabindex= "1" name="gear1" id="gear1"></center>
<option value="$gear1" selected>$gear1</option>  
$gearSelecthtml
</select><a href="javascript: void" id="pos21" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos21', 21 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
<center>Gear Photo 1:</center>
</td>
<td>
<center><select tabindex= "1" name="gearPhoto1" id="gearPhoto1"></center>
<option value="$gearPhoto1" selected>$gearPhoto1</option>  
$gearDropOptions1
</select><a href="javascript: void" id="pos22" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos22', 22 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Gear Option 2:</center>
</td>
<td>
<center><select tabindex= "1" name="gear2" id="gear2"></center>
<option value="$gear2" selected>$gear2</option>  
$gearSelecthtml
</select><a href="javascript: void" id="pos23" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos23', 23 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Gear Photo 2:</center>
</td>
<td>
<center><select tabindex= "1" name="gearPhoto2" id="gearPhoto2"></center>
<option value="$gearPhoto2" selected>$gearPhoto2</option>  
$gearDropOptions2
</select><a href="javascript: void" id="pos24" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos24', 24 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Gear Option 3:</center>
</td>
<td>
<center><select tabindex= "1" name="gear3" id="gear3"></center>
<option value="$gear3" selected>$gear3</option>  
$gearSelecthtml
</select><a href="javascript: void" id="pos25" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos25', 25 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Gear Photo 3:</center>
</td>
<td>
<center><select tabindex= "1" name="gearPhoto3" id="gearPhoto3"></center>
<option value="$gearPhoto3" selected>$gearPhoto3</option>  
$gearDropOptions3
</select><a href="javascript: void" id="pos26" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos26', 26 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Gear Option 4:</center>
</td>
<td>
<center><select tabindex= "1" name="gear4" id="gear4"></center>
<option value="$gear4" selected>$gear4</option>  
$gearSelecthtml
</select><a href="javascript: void" id="pos27" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos27', 27 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Gear Photo 4:</center>
</td>
<td>
<center><select tabindex= "1" name="gearPhoto4" id="gearPhoto4"></center>
<option value="$gearPhoto4" selected>$gearPhoto4</option>  
$gearDropOptions4
</select><a href="javascript: void" id="pos28" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos28', 28 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
&nbsp;
</tr>

<tr>
<td class="black">
<center>Gear Option 5:</center>
</td>
<td>
<center><select tabindex= "1" name="gear5" id="gear5"></center>
<option value="$gear5" selected>$gear5</option>  
$gearSelecthtml
</select><a href="javascript: void" id="pos29" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos29', 29 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
<center>Gear Photo 5:</center>
</td>
<td>
<center><select tabindex= "1" name="gearPhoto5" id="gearPhoto5"></center>
<option value="$gearPhoto5" selected>$gearPhoto5</option>  
$gearDropOptions5
</select><a href="javascript: void" id="pos30" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos30', 30 );" /><img src="../../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td  colspan="2" align="left">
<br>
<a class="more up bold" target="" title="$submit_title">
<center><button class="button" type="submit" value="login" id="Update" name="Update">$submit_title</button></center>
</a>
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>



<tr>
<td>
<center><u><h2>Hex Colors<h2><u></center>
</td>
</tr>
<tr>
<td>Black</td>
<td>000000</td>
<td bgcolor="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>


<tr>
<td>Navy</td>
<td>000080</a></td>
<td bgcolor="#000080">&nbsp;</td>
</tr>


<tr>
<td>DarkBlue</td>
<td>00008B</td>
<td bgcolor="#00008B">&nbsp;</td>
</tr>


<tr>
<td>MediumBlue</td>
<td>0000CD</td>
<td bgcolor="#0000CD">&nbsp;</td>
</tr>


<tr>
<td>Blue</td>
<td>0000FF</td>
<td bgcolor="#0000FF">&nbsp;</td>
</tr>


<tr>
<td>DarkGreen</td>
<td>006400</td>
<td bgcolor="#006400">&nbsp;</td>
</tr>


<tr>
<td>Green</td>
<td>008000</td>
<td bgcolor="#008000">&nbsp;</td>
</tr>


<tr>
<td>Teal</td>
<td>008080</td>
<td bgcolor="#008080">&nbsp;</td>
</tr>


<tr>
<td>DarkCyan</td>
<td>008B8B</a></td>
<td bgcolor="#008B8B">&nbsp;</td>
</tr>


<tr>
<td>DeepSkyBlue</td>
<td>00BFFF</td>
<td bgcolor="#00BFFF">&nbsp;</td>
</tr>


<tr>
<td>DarkTurquoise</td>
<td>00CED1</td>
<td bgcolor="#00CED1">&nbsp;</td>
</tr>


<tr>
<td>MediumSpringGreen</td>
<td>00FA9A</td>
<td bgcolor="#00FA9A">&nbsp;</td>
</tr>


<tr>
<td>Lime</td>
<td>00FF00</td>
<td bgcolor="#00FF00">&nbsp;</td>
</tr>


<tr>
<td>SpringGreen</td>
<td>00FF7F</td>
<td bgcolor="#00FF7F">&nbsp;</td>
</tr>


<tr>
<td>Aqua</td>
<td>00FFFF</td>
<td bgcolor="#00FFFF">&nbsp;</td>
</tr>


<tr>
<td>Cyan</td>
<td>00FFFF</td>
<td bgcolor="#00FFFF">&nbsp;</td>
</tr>


<tr>
<td>MidnightBlue</td>
<td>191970</td>
<td bgcolor="#191970">&nbsp;</td>
</tr>


<tr>
<td>DodgerBlue</td>
<td>1E90FF</td>
<td bgcolor="#1E90FF">&nbsp;</td>
</tr>


<tr>
<td>LightSeaGreen</td>
<td>20B2AA</td>
<td bgcolor="#20B2AA">&nbsp;</td>
</tr>


<tr>
<td>ForestGreen</td>
<td>228B22</td>
<td bgcolor="#228B22">&nbsp;</td>
</tr>


<tr>
<td>SeaGreen</td>
<td>2E8B57</td>
<td bgcolor="#2E8B57">&nbsp;</td>
</tr>


<tr>
<td>DarkSlateGray</td>
<td>2F4F4F</td>
<td bgcolor="#2F4F4F">&nbsp;</td>
</tr>


<tr>
<td>LimeGreen</td>
<td>32CD32</td>
<td bgcolor="#32CD32">&nbsp;</td>
</tr>


<tr>
<td>MediumSeaGreen</td>
<td>3CB371</td>
<td bgcolor="#3CB371">&nbsp;</td>
</tr>


<tr>
<td>Turquoise</td>
<td>40E0D0</td>
<td bgcolor="#40E0D0">&nbsp;</td>
</tr>


<tr>
<td>RoyalBlue</td>
<td>4169E1</td>
<td bgcolor="#4169E1">&nbsp;</td>
</tr>


<tr>
<td>SteelBlue</td>
<td>4682B4</td>
<td bgcolor="#4682B4">&nbsp;</td>
</tr>


<tr>
<td>DarkSlateBlue</td>
<td>483D8B</td>
<td bgcolor="#483D8B">&nbsp;</td>
</tr>


<tr>
<td>MediumTurquoise</td>
<td>48D1CC</td>
<td bgcolor="#48D1CC">&nbsp;</td>
</tr>


<tr>
<td>Indigo</td>
<td>4B0082</td>
<td bgcolor="#4B0082">&nbsp;</td>
</tr>


<tr>
<td>DarkOliveGreen</td>
<td>556B2F</td>
<td bgcolor="#556B2F">&nbsp;</td>
</tr>


<tr>
<td>CadetBlue</td>
<td>5F9EA0</td>
<td bgcolor="#5F9EA0">&nbsp;</td>
</tr>


<tr>
<td>CornflowerBlue</td>
<td>6495ED</td>
<td bgcolor="#6495ED">&nbsp;</td>
</tr>


<tr>
<td>MediumAquaMarine</td>
<td>66CDAA</td>
<td bgcolor="#66CDAA">&nbsp;</td>
</tr>


<tr>
<td>DimGray</td>
<td>696969</td>
<td bgcolor="#696969">&nbsp;</td>
</tr>


<tr>
<td>SlateBlue</td>
<td>6A5ACD</td>
<td bgcolor="#6A5ACD">&nbsp;</td>
</tr>


<tr>
<td>OliveDrab</td>
<td>6B8E23</td>
<td bgcolor="#6B8E23">&nbsp;</td>
</tr>


<tr>
<td>SlateGray</td>
<td>708090</td>
<td bgcolor="#708090">&nbsp;</td>
</tr>


<tr>
<td>LightSlateGray</td>
<td>778899</td>
<td bgcolor="#778899">&nbsp;</td>
</tr>


<tr>
<td>MediumSlateBlue</td>
<td>7B68EE</td>
<td bgcolor="#7B68EE">&nbsp;</td>
</tr>


<tr>
<td>LawnGreen</td>
<td>7CFC00</td>
<td bgcolor="#7CFC00">&nbsp;</td>
</tr>


<tr>
<td>Chartreuse</td>
<td>7FFF00</td>
<td bgcolor="#7FFF00">&nbsp;</td>
</tr>


<tr>
<td>Aquamarine</td>
<td>7FFFD4</td>
<td bgcolor="#7FFFD4">&nbsp;</td>
</tr>


<tr>
<td>Maroon</td>
<td>800000</td>
<td bgcolor="#800000">&nbsp;</td>
</tr>


<tr>
<td>Purple</td>
<td>800080</td>
<td bgcolor="#800080">&nbsp;</td>
</tr>


<tr>
<td>Olive</td>
<td>808000</td>
<td bgcolor="#808000">&nbsp;</td>
</tr>


<tr>
<td>Gray</td>
<td>808080</td>
<td bgcolor="#808080">&nbsp;</td>
</tr>


<tr>
<td>SkyBlue</td>
<td>87CEEB</td>
<td bgcolor="#87CEEB">&nbsp;</td>
</tr>


<tr>
<td>LightSkyBlue</td>
<td>87CEFA</td>
<td bgcolor="#87CEFA">&nbsp;</td>
</tr>


<tr>
<td>BlueViolet</td>
<td>8A2BE2</td>
<td bgcolor="#8A2BE2">&nbsp;</td>
</tr>


<tr>
<td>DarkRed</td>
<td>8B0000</td>
<td bgcolor="#8B0000">&nbsp;</td>
</tr>


<tr>
<td>DarkMagenta</td>
<td>8B008B</td>
<td bgcolor="#8B008B">&nbsp;</td>
</tr>


<tr>
<td>SaddleBrown</td>
<td>8B4513</td>
<td bgcolor="#8B4513">&nbsp;</td>
</tr>


<tr>
<td>DarkSeaGreen</td>
<td>8FBC8F</td>
<td bgcolor="#8FBC8F">&nbsp;</td>
</tr>


<tr>
<td>LightGreen</td>
<td>90EE90</td>
<td bgcolor="#90EE90">&nbsp;</td>
</tr>


<tr>
<td>MediumPurple</td>
<td>9370DB</td>
<td bgcolor="#9370DB">&nbsp;</td>
</tr>


<tr>
<td>DarkViolet</td>
<td>9400D3</td>
<td bgcolor="#9400D3">&nbsp;</td>
</tr>


<tr>
<td>PaleGreen</td>
<td>98FB98</td>
<td bgcolor="#98FB98">&nbsp;</td>
</tr>


<tr>
<td>DarkOrchid</td>
<td>9932CC</td>
<td bgcolor="#9932CC">&nbsp;</td>
</tr>


<tr>
<td>YellowGreen</td>
<td>9ACD32</td>
<td bgcolor="#9ACD32">&nbsp;</td>
</tr>


<tr>
<td>Sienna</td>
<td>A0522D</td>
<td bgcolor="#A0522D">&nbsp;</td>
</tr>


<tr>
<td>Brown</td>
<td>A52A2A</td>
<td bgcolor="#A52A2A">&nbsp;</td>
</tr>


<tr>
<td>DarkGray</td>
<td>A9A9A9</td>
<td bgcolor="#A9A9A9">&nbsp;</td>
</tr>


<tr>
<td>LightBlue</td>
<td>ADD8E6</td>
<td bgcolor="#ADD8E6">&nbsp;</td>
</tr>


<tr>
<td>GreenYellow</td>
<td>ADFF2F</td>
<td bgcolor="#ADFF2F">&nbsp;</td>
</tr>


<tr>
<td>PaleTurquoise</td>
<td>AFEEEE</td>
<td bgcolor="#AFEEEE">&nbsp;</td>
</tr>


<tr>
<td>LightSteelBlue</td>
<td>B0C4DE</td>
<td bgcolor="#B0C4DE">&nbsp;</td>
</tr>


<tr>
<td>PowderBlue</td>
<td>B0E0E6</td>
<td bgcolor="#B0E0E6">&nbsp;</td>
</tr>


<tr>
<td>FireBrick</td>
<td>B22222</td>
<td bgcolor="#B22222">&nbsp;</td>
</tr>


<tr>
<td>DarkGoldenRod</td>
<td>B8860B</td>
<td bgcolor="#B8860B">&nbsp;</td>
</tr>


<tr>
<td>MediumOrchid</td>
<td>BA55D3</td>
<td bgcolor="#BA55D3">&nbsp;</td>
</tr>


<tr>
<td>RosyBrown</td>
<td>BC8F8F</td>
<td bgcolor="#BC8F8F">&nbsp;</td>
</tr>


<tr>
<td>DarkKhaki</td>
<td>BDB76B</td>
<td bgcolor="#BDB76B">&nbsp;</td>
</tr>


<tr>
<td>Silver</td>
<td>C0C0C0</td>
<td bgcolor="#C0C0C0">&nbsp;</td>
</tr>


<tr>
<td>MediumVioletRed</td>
<td>C71585</td>
<td bgcolor="#C71585">&nbsp;</td>
</tr>


<tr>
<td>IndianRed</td>
<td>CD5C5C</td>
<td bgcolor="#CD5C5C">&nbsp;</td>
</tr>


<tr>
<td>Peru</td>
<td>CD853F</td>
<td bgcolor="#CD853F">&nbsp;</td>
</tr>


<tr>
<td>Chocolate</td>
<td>D2691E</td>
<td bgcolor="#D2691E">&nbsp;</td>
</tr>


<tr>
<td>Tan</td>
<td>D2B48C</td>
<td bgcolor="#D2B48C">&nbsp;</td>
</tr>


<tr>
<td>LightGray</td>
<td>D3D3D3</td>
<td bgcolor="#D3D3D3">&nbsp;</td>
</tr>


<tr>
<td>Thistle</td>
<td>D8BFD8</td>
<td bgcolor="#D8BFD8">&nbsp;</td>
</tr>


<tr>
<td>Orchid</td>
<td>DA70D6</td>
<td bgcolor="#DA70D6">&nbsp;</td>
</tr>


<tr>
<td>GoldenRod</td>
<td>DAA520</td>
<td bgcolor="#DAA520">&nbsp;</td>
</tr>


<tr>
<td>PaleVioletRed</td>
<td>DB7093</td>
<td bgcolor="#DB7093">&nbsp;</td>
</tr>


<tr>
<td>Crimson</td>
<td>DC143C></td>
<td bgcolor="#DC143C">&nbsp;</td>
</tr>


<tr>
<td>Gainsboro</td>
<td>DCDCDC</td>
<td bgcolor="#DCDCDC">&nbsp;</td>
</tr>


<tr>
<td>Plum</td>
<td>DDA0DD</td>
<td bgcolor="#DDA0DD">&nbsp;</td>
</tr>


<tr>
<td>BurlyWood</td>
<td>DEB887</td>
<td bgcolor="#DEB887">&nbsp;</td>
</tr>


<tr>
<td>LightCyan</td>
<td>E0FFFF</td>
<td bgcolor="#E0FFFF">&nbsp;</td>
</tr>


<tr>
<td>Lavender</td>
<td>E6E6FA</td>
<td bgcolor="#E6E6FA">&nbsp;</td>
</tr>


<tr>
<td>DarkSalmon</td>
<td>E9967A</td>
<td bgcolor="#E9967A">&nbsp;</td>
</tr>


<tr>
<td>Violet</td>
<td>EE82EE</td>
<td bgcolor="#EE82EE">&nbsp;</td>
</tr>


<tr>
<td>PaleGoldenRod</td>
<td>EEE8AA</td>
<td bgcolor="#EEE8AA">&nbsp;</td>
</tr>


<tr>
<td>LightCoral</td>
<td>F08080</td>
<td bgcolor="#F08080">&nbsp;</td>
</tr>


<tr>
<td>Khakii</td>
<td>F0E68C</td>
<td bgcolor="#F0E68C">&nbsp;</td>
</tr>


<tr>
<td>AliceBlue</td>
<td>F0F8FF</td>
<td bgcolor="#F0F8FF">&nbsp;</td>
</tr>


<tr>
<td>HoneyDew</td>
<td>F0FFF0</td>
<td bgcolor="#F0FFF0">&nbsp;</td>
</tr>


<tr>
<td>Azure</td>
<td>F0FFFF</td>
<td bgcolor="#F0FFFF">&nbsp;</td>
</tr>


<tr>
<td>SandyBrown</td>
<td>F4A460</td>
<td bgcolor="#F4A460">&nbsp;</td>
</tr>


<tr>
<td>Wheat</td>
<td>F5DEB3</td>
<td bgcolor="#F5DEB3">&nbsp;</td>
</tr>


<tr>
<td>Beige</td>
<td>F5F5DC</td>
<td bgcolor="#F5F5DC">&nbsp;</td>
</tr>


<tr>
<td>WhiteSmoke</td>
<td>F5F5F5</td>
<td bgcolor="#F5F5F5">&nbsp;</td>
</tr>


<tr>
<td>MintCream</td>
<td>F5FFFA</td>
<td bgcolor="#F5FFFA">&nbsp;</td>
</tr>


<tr>
<td>GhostWhite</td>
<td>F8F8FF</td>
<td bgcolor="#F8F8FF">&nbsp;</td>
</tr>


<tr>
<td>Salmon</td>
<td>FA8072</td>
<td bgcolor="#FA8072">&nbsp;</td>
</tr>


<tr>
<td>AntiqueWhite</td>
<td>FAEBD7</td>
<td bgcolor="#FAEBD7">&nbsp;</td>
</tr>


<tr>
<td>Linen</td>
<td>FAF0E6</td>
<td bgcolor="#FAF0E6">&nbsp;</td>
</tr>


<tr>
<td>LightGoldenRodYellow</td>
<td>FAFAD2</td>
<td bgcolor="#FAFAD2">&nbsp;</td>
</tr>


<tr>
<td>OldLace</td>
<td>FDF5E6</td>
<td bgcolor="#FDF5E6">&nbsp;</td>
</tr>


<tr>
<td>Red</td>
<td>FF0000</td>
<td bgcolor="#FF0000">&nbsp;</td>
</tr>


<tr>
<td>Fuchsia</td>
<td>FF00FF</td>
<td bgcolor="#FF00FF">&nbsp;</td>
</tr>


<tr>
<td>Magenta</td>
<td>FF00FF</td>
<td bgcolor="#FF00FF">&nbsp;</td>
</tr>


<tr>
<td>DeepPink</td>
<td>FF1493</td>
<td bgcolor="#FF1493">&nbsp;</td>
</tr>


<tr>
<td>OrangeRed</td>
<td>FF4500</td>
<td bgcolor="#FF4500">&nbsp;</td>
</tr>


<tr>
<td>Tomato</td>
<td>FF6347</td>
<td bgcolor="#FF6347">&nbsp;</td>
</tr>


<tr>
<td>HotPink</td>
<td>FF69B4</td>
<td bgcolor="#FF69B4">&nbsp;</td>
</tr>


<tr>
<td>Coral</td>
<td>FF7F50</td>
<td bgcolor="#FF7F50">&nbsp;</td>
</tr>


<tr>
<td>DarkOrange</td>
<td>FF8C00</td>
<td bgcolor="#FF8C00">&nbsp;</td>
</tr>


<tr>
<td>LightSalmon</td>
<td>FFA07A</td>
<td bgcolor="#FFA07A">&nbsp;</td>
</tr>


<tr>
<td>Orange</td>
<td>FFA500</td>
<td bgcolor="#FFA500">&nbsp;</td>
</tr>


<tr>
<td>LightPink</td>
<td>FFB6C1</td>
<td bgcolor="#FFB6C1">&nbsp;</td>
</tr>


<tr>
<td>Pink</td>
<td>FFC0CB</td>
<td bgcolor="#FFC0CB">&nbsp;</td>
</tr>


<tr>
<td>Gold</td>
<td>FFD700</td>
<td bgcolor="#FFD700">&nbsp;</td>
</tr>


<tr>
<td>PeachPuff</td>
<td>FFDAB9</td>
<td bgcolor="#FFDAB9">&nbsp;</td>
</tr>


<tr>
<td>NavajoWhite</td>
<td>FFDEAD</td>
<td bgcolor="#FFDEAD">&nbsp;</td>
</tr>


<tr>
<td>Moccasin</td>
<td>FFE4B5</td>
<td bgcolor="#FFE4B5">&nbsp;</td>
</tr>


<tr>
<td>Bisque</td>
<td>FFE4C4</td>
<td bgcolor="#FFE4C4">&nbsp;</td>
</tr>


<tr>
<td>MistyRose</td>
<td>FFE4E1</td>
<td bgcolor="#FFE4E1">&nbsp;</td>
</tr>


<tr>
<td>BlanchedAlmond</td>
<td>FFEBCD</td>
<td bgcolor="#FFEBCD">&nbsp;</td>
</tr>


<tr>
<td>PapayaWhip</td>
<td>FFEFD5</td>
<td bgcolor="#FFEFD5">&nbsp;</td>
</tr>


<tr>
<td>LavenderBlush</td>
<td>FFF0F5</td>
<td bgcolor="#FFF0F5">&nbsp;</td>
</tr>


<tr>
<td>SeaShell</td>
<td>FFF5EE</td>
<td bgcolor="#FFF5EE">&nbsp;</td>
</tr>


<tr>
<td>Cornsilk</td>
<td>FFF8DC</td>
<td bgcolor="#FFF8DC">&nbsp;</td>
</tr>


<tr>
<td>LemonChiffon</td>
<td>FFFACD</td>
<td bgcolor="#FFFACD">&nbsp;</td>
</tr>


<tr>
<td>FloralWhite</td>
<td>FFFAF0</td>
<td bgcolor="#FFFAF0">&nbsp;</td>
</tr>


<tr>
<td>Snow</td>
<td>FFFAFA</td>
<td bgcolor="#FFFAFA">&nbsp;</td>
</tr>


<tr>
<td>Yellow</td>
<td>FFFF00</td>
<td bgcolor="#FFFF00">&nbsp;</td>
</tr>


<tr>
<td>LightYellow</td>
<td>FFFFE0</td>
<td bgcolor="#FFFFE0">&nbsp;</td>
</tr>


<tr>
<td>Ivory</td>
<td>FFFFF0</td>
<td bgcolor="#FFFFF0">&nbsp;</td>
</tr>


<tr>
<td>White</td>
<td>FFFFFF</td>
<td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;</td>
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


