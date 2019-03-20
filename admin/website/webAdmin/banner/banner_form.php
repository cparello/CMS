<?php
if (!isset($_SESSION)) {
  session_start();
}


$contentForm = <<<CONTENT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css" media="all">

.banPrev  {
position: relative;
text-align: center;
border-style:solid;
border-width:2px;
top: 0px;
width: 550px;
height: 90px;
margin: 0 auto;
margin-left: auto; 
margin-right: auto;
}

.banSkin  {
position: absolute;
top: 15px;
left: 7%;
width: 468px;
height: 60px;
background-image: url('../pictures/banner/$image_name'); 
background-color: #ffffff;
z-index: = 1;
}

.headerText {
text-align: left;
top: 0px;
left: 0px;
margin-top: $header_top_css;
margin-left: $header_left_css;
margin-right: $header_right_css;
font-family: $header_font_css;
letter-spacing: $header_space_css;
font-size: $header_size_css;
font-weight: $header_strength_css;
color: $header_color_css;
width: 468px;
}

.contentText {
text-align: left;
margin-top: $content_top_css;
margin-left: $content_left_css;
margin-right: $content_right_css;
font-family: $content_font_css;
letter-spacing: $content_space_css;
font-size: $content_size_css;
font-weight: $content_strength_css;
color: $content_color_css;
width: 468px;
}

</style>

<head>
<title>Create Edit Banners</title>

<script type="text/javascript" src="../webScripts/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../webScripts/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../webCss/jquery.jcarousel.css" />
<script type="text/javascript" src="../webScripts/bannerValues.js"></script>
<script type="text/javascript" src="../webScripts/changeContent.js"></script>
<link rel="stylesheet" type="text/css" href="../webCss/skin.css" />
<link rel="stylesheet" href="../webCss/cb.css">
<link rel="stylesheet" href="../webCss/jcar.css">


<script language="JavaScript">
window.onload=function()   {
var headerFont = "$header_font";
var contentFont = "$content_font";
var radLengthOne = document.fontstyle1.fsstyle.length;
var radLengthTwo = document.fontstyle2.fsstyle.length;
var i;
var j;

for (i = 0; i < radLengthOne; i++){
    if(document.fontstyle1.fsstyle[i].value == headerFont) {
        document.fontstyle1.fsstyle[i].checked = true;
        }
  }

for (j = 0; j < radLengthTwo; j++){
    if(document.fontstyle2.fsstyle[j].value == contentFont) {
       document.fontstyle2.fsstyle[j].checked = true;
        }
   }   
}
</script>



</head>
<body >


<table width="100%" border="1" align="center">
<tr>
<td>
<form name="fontstyle1">
<p>Header Text Tools</p>
<table align="center" width="300" border="0">
<tr>
<td>
Top
</td>
<td>
Left
</td>
<td>
Right
</td>
</tr>

<tr>
<td>
<input name="headerTop1" type="text" id="headerTop1" value="$header_top" size="3" maxlength="3" onKeyUp="posDiv(this.value,1);">
</td>
<td>
<input name="headerTop2" type="text" id="headerTop2" value="$header_left" size="3" maxlength="3" onKeyUp="posDiv(this.value,2);">
</td>
<td>
<input name="headerTop3" type="text" id="headerTop3" value="$header_right" size="3" maxlength="3" onKeyUp="posDiv(this.value,3);">
</td>
</tr>


<tr>
<td align="center"colspan="3">
<br>
Choose Text
</td>
</tr>

<tr>
<td colspan="3">

<table width="100%" class="out">
<tr>
<td valign="bottom">
<font face="arial" size=2>Arial</font>
</td>
<td valign="bottom">
<font face="Impact" size=2>Impact</font>
</td>
<td valign="bottom">
<font face="Tahoma, Geneva" size=2>Tahoma</font>
</td>
</tr>

<tr>
<td>
<input type="radio" name="fsstyle" value="arial"  onClick="changefont('arial',1)">
</td>
<td>
<input type="radio" name="fsstyle" value="Impact"  onClick="changefont('Impact',2)">
</td>
<td>
<input type="radio" name="fsstyle" value="Tahoma, Geneva"  onClick="changefont('Tahoma, Geneva',3)">
</td>
</tr>

<tr>
<td valign="bottom">
<font face="Courier New" size=2>Courier</font>
</td>
<td valign="bottom">
<font face="Lucida Sans Unicode, Lucida Grande" size=2>Lucida</font>
</td>
<td valign="bottom">
<font face="Comic Sans MS" size=2>Comic Sans</font>
</td>
</tr>

<tr>
<td>
<input type="radio" name="fsstyle" value="Courier New"  onClick="changefont('Courier New',4)">
</td>
<td>
<input type="radio" name="fsstyle" value="Lucida Sans Unicode, Lucida Grande"  onClick="changefont('Lucida Sans Unicode, Lucida Grande',5)">
</td>
<td>
<input type="radio" name="fsstyle" value="Comic Sans MS"  onClick="changefont('Comic Sans MS',6)">
</td>
</tr>
</table>

</td>
</tr>


<tr>
<td>
<br>
Spacing
</td>
<td>
<br>
Size
</td>
<td>
<br>
Strength
</td>
</tr>


<tr>
<td>
<input name="headerSpace" type="text" id="headerSpace" value="$header_space" size="3" maxlength="2" onKeyUp="headAtts(this.value,1,1);">
</td>
<td>
<input name="headerSize" type="text" id="headerSize" value="$header_size" size="3" maxlength="2" onKeyUp="headAtts(this.value,2,1);">
</td>
<td>
<input name="headerStrength" type="text" id="headerStrength" value="$header_strength" size="3" maxlength="3" onKeyUp="headAtts(this.value,3,1);">
</form>
</td>
</tr>

<tr>
<td colspan="3">
<br>
Text Color
</td>
</tr>


<tr>
<td colspan="3">

<table width="100%" class="out">


<tr>
<td>
<input type="button"  name="one" value="" onclick="changeBack('#231F20',1);" style="background-color:#231F20; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="two" value="" onclick="changeBack('#F8991D',1);" style="background-color:#F8991D; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="three" value="" onclick="changeBack('#F9F183',1);" style="background-color:#F9F183; width:25px; height:25px;"></button>
</form>
</td>
</tr>

<tr>
<td>  
<input type="button" name="four" value="" onclick="changeBack('#EB97AF',1);" style="background-color:#EB97AF; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="five" value="" onclick="changeBack('#971B1E',1);" style="background-color:#971B1E; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="six" value="" onclick="changeBack('#8C93B0'1);" style="background-color:#8C93B0; width:25px; height:25px;"></button>
 </td>
</tr>

<tr>
<td>
<input type="button" name="seven" value="" onclick="changeBack('#5E6AB1',1);" style="background-color:#5E6AB1; width:25px; height:25px;"></button>  
</td>
<td>
<input type="button" name="eight" value="" onclick="changeBack('#2C2A7A',1);" style="background-color:#2C2A7A; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="nine" value="" onclick="changeBack('#662D91',1);" style="background-color:#662D91; width:25px; height:25px;"></button>  
</td>
</tr>


<tr>
<td>
<input type="button" name="ten" onclick="changeBack('#0A9F49',1);" style="background-color:#0A9F49; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="eleven" onclick="changeBack('#007070',1);" style="background-color:#007070; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="twelve" onclick="changeBack('#619663',1);" style="background-color:#619663; width:25px; height:25px;"></button>
</td>
</tr>

<tr>
<td>
<input type="button" name="thirteen" onclick="changeBack('#203F1C',1);" style="background-color:#203F1C; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="fourteen" onclick="changeBack('#838337',1);" style="background-color:#838337; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="fifteen" onclick="changeBack('#6C5635',1);" style="background-color:#6C5635; width:25px; height:25px;"></button>
</td>
</tr>


<tr>
<td>
<input type="button" name="sixteen" onclick="changeBack('#FFFFFF',1);" style="background-color:#FFFFFF; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="seventeen" onclick="changeBack('#636467',1);" style="background-color:#636467; width:25px; height:25px;"></button> 
</td>
<td>
<input type="button" name="eighteen" onclick="changeBack('#000066',1);" style="background-color:#000066; width:25px; height:25px;"></button>
</form>
</td>
</tr>
</table>

</td>
</tr>
</table>
</td>

<td>
<p class="pageHeader">
$title_page
</p>
$banner_blurb

<form  name="form1" method="post" action="create_banners.php">
<p class="funcHeader">
Select Background Image
</p>
<center>
$listings
</center>
<p class="funcHeader">
Create Banner Header
</p>
<input name="header" type="text" id="header" value="$header_text" size="78" maxlength="100" onkeyup="writeHeader(this.value,1);">
<p class="funcHeader">
Create Banner Content
</p>
<input name="content" type="text" id="content" value="$content_text" size="78" maxlength="100" onkeyup="writeHeader(this.value,2);">
<p class="funcHeader">
Banner Name
</p>
<input name="name" type="text" id="name" value="$banner_name" size="30" maxlength="30"  onBlur="writeName(this.value);">
<p class="funcHeader">
Banner Link
</p>
<input name="link" type="text" id="link" value="$banner_link" size="30" maxlength="60" onBlur="writeLink(this.value);">


<p class="funcHeader">
$button
</p>
<input type="hidden" name="button_value" value="" width="300" id="buthold"/>
<input type="hidden" name="header_color_temp" value=""  id="header_color_temp"/>
<input type="hidden" name="text_color_temp" value=""  id="text_color_temp"/>
<input type="hidden" name="header_font_temp" value=""  id="header_font_temp"/>
<input type="hidden" name="text_font_temp" value=""  id="text_font_temp"/>
</form>
<p class="funcHeader">
Banner Preview
</p>



<div id="banPrev" class="banPrev">
<div id="banSkin"  class="banSkin">
<div id="headerText"  class="headerText">
$header_text
</div>
<div id="contentText"  class="contentText">
$content_text
</div>
</div>
</div>
</td>

<td>
<form name="fontstyle2">
<p>Content Text Tools</p>
<table align="center" width="300" border="0">
<tr>
<td>
Top
</td>
<td>
Left
</td>
<td>
Right
</td>
</tr>

<tr>
<td>
<input name="headerTop1" type="text" id="textTop1" value="$content_top" size="3" maxlength="3" onKeyUp="posDiv(this.value,4,2);">
</td>
<td>
<input name="headerTop2" type="text" id="textTop2" value="$content_left" size="3" maxlength="3" onKeyUp="posDiv(this.value,5,2);">
</td>
<td>
<input name="headerTop3" type="text" id="textTop3" value="$content_right" size="3" maxlength="3" onKeyUp="posDiv(this.value,6,2);">
</td>
</tr>


<tr>
<td align="center"colspan="3">
<br>
Choose Text
</td>
</tr>

<tr>
<td colspan="3">

<table width="100%" class="out">
<tr>
<td valign="bottom">
<font face="arial" size=2>Arial</font>
</td>
<td valign="bottom">
<font face="Impact" size=2>Impact</font>
</td>
<td valign="bottom">
<font face="Tahoma, Geneva" size=2>Tahoma</font>
</td>
</tr>

<tr>
<td>
<input type="radio" name="fsstyle" value="arial"  onClick="changefont('arial',7)">
</td>
<td>
<input type="radio" name="fsstyle" value="Impact"  onClick="changefont('Impact',8)">
</td>
<td>
<input type="radio" name="fsstyle" value="Tahoma, Geneva"  onClick="changefont('Tahoma, Geneva',9)">
</td>
</tr>

<tr>
<td valign="bottom">
<font face="Courier New" size=2>Courier</font>
</td>
<td valign="bottom">
<font face="Lucida Sans Unicode, Lucida Grande" size=2>Lucida</font>
</td>
<td valign="bottom">
<font face="Comic Sans MS" size=2>Comic Sans</font>
</td>
</tr>

<tr>
<td>
<input type="radio" name="fsstyle" value="Courier New"  onClick="changefont('Courier New',10)">
</td>
<td>
<input type="radio" name="fsstyle" value="Lucida Sans Unicode, Lucida Grande"  onClick="changefont('Lucida Sans Unicode, Lucida Grande',11)">
</td>
<td>
<input type="radio" name="fsstyle" value="Comic Sans MS"  onClick="changefont('Comic Sans MS',12)">
</td>
</tr>
</table>

</td>
</tr>


<tr>
<td>
<br>
Spacing
</td>
<td>
<br>
Size
</td>
<td>
<br>
Strength
</td>
</tr>


<tr>
<td>
<input name="headerSpace" type="text" id="textSpace" value="$content_space" size="3" maxlength="2" onKeyUp="headAtts(this.value,1);">
</td>
<td>
<input name="headerSize" type="text" id="textSize" value="$content_size" size="3" maxlength="2" onKeyUp="headAtts(this.value,2);">
</td>
<td>
<input name="headerStrength" type="text" id="textStrength" value="$content_strength" size="3" maxlength="3" onKeyUp="headAtts(this.value,3);">
</form>
</td>
</tr>

<tr>
<td colspan="3">
<br>
Text Color
</td>
</tr>


<tr>
<td colspan="3">

<table width="100%" class="out">
<tr>
<td>
<input type="button"  name="one" value="" onclick="changeBack('#231F20',2);" style="background-color:#231F20; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="two" value="" onclick="changeBack('#F8991D',2);" style="background-color:#F8991D; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="three" value="" onclick="changeBack('#F9F183',2);" style="background-color:#F9F183; width:25px; height:25px;"></button>
</form>
</td>
</tr>

<tr>
<td>  
<input type="button" name="four" value="" onclick="changeBack('#EB97AF',2);" style="background-color:#EB97AF; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="five" value="" onclick="changeBack('#971B1E',2);" style="background-color:#971B1E; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="six" value="" onclick="changeBack('#8C93B0',2);" style="background-color:#8C93B0; width:25px; height:25px;"></button>
 </td>
</tr>

<tr>
<td>
<input type="button" name="seven" value="" onclick="changeBack('#5E6AB1',2);" style="background-color:#5E6AB1; width:25px; height:25px;"></button>  
</td>
<td>
<input type="button" name="eight" value="" onclick="changeBack('#2C2A7A',2);" style="background-color:#2C2A7A; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="nine" value="" onclick="changeBack('#662D91',2);" style="background-color:#662D91; width:25px; height:25px;"></button>  
</td>
</tr>


<tr>
<td>
<input type="button" name="ten" onclick="changeBack('#0A9F49',2);" style="background-color:#0A9F49; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="eleven" onclick="changeBack('#007070',2);" style="background-color:#007070; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="twelve" onclick="changeBack('#619663',2);" style="background-color:#619663; width:25px; height:25px;"></button>
</td>
</tr>

<tr>
<td>
<input type="button" name="thirteen" onclick="changeBack('#203F1C',2);" style="background-color:#203F1C; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="fourteen" onclick="changeBack('#838337',2);" style="background-color:#838337; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="fifteen" onclick="changeBack('#6C5635',2);" style="background-color:#6C5635; width:25px; height:25px;"></button>
</td>
</tr>


<tr>
<td>
<input type="button" name="sixteen" onclick="changeBack('#FFFFFF',2);" style="background-color:#FFFFFF; width:25px; height:25px;"></button>
</td>
<td>
<input type="button" name="seventeen" onclick="changeBack('#636467',2);" style="background-color:#636467; width:25px; height:25px;"></button> 
</td>
<td>
<input type="button" name="eighteen" onclick="changeBack('#000066',2);" style="background-color:#000066; width:25px; height:25px;"></button>
</form>
</td>
</tr>
</table>

</td>
</tr>
</table>
</td>
</tr>
</table>



</body>
</html>
CONTENT;
?>