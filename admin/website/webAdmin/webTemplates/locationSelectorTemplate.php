<?php



//$selectClubButton = "<button class=\"buttonPasses$middleButtons butColor\" id=\"clubSelect\" type=\"submit\" data-text=\"Processing…\"><span class=\"button-left\"><span class=\"button-right\">Select Club</span></span></button>";

$webTemplate = <<<WEBTEMPLATE
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->
<head>
    <meta charset="utf-8">
     
<title>$title</title>
<meta name="description" content="$description" />
    
    
	
    <!-- should be added conditionally for 2012 slider-->
 
    <link href="webCss/combined.css" rel="stylesheet" type="text/css" />
    <script src="../../scripts/jqueryNew.js" type="text/javascript"></script>
    <script src="webScripts/checkClosestZip.js" type="text/javascript"></script>
    <script src="webScripts/checkAreaZip.js" type="text/javascript"></script>

    
<style>
.topLinkBack{
background:#$topLinkBar;
}
.midButtonBack{
background:#$midButBar;
}
.bottomBack{
background:#$bottomBar;
}
.boxBack{
background:#$boxColor;
height:400px;
padding-left:25px;
padding-top:25px;
padding-bottom:25px;
padding-right:25px;
color: #$textColor;
}
.grid-747  {
width: 390px;
position: relative;
height: 400px;
}
.contentFooter  {
top: 300px;
position: relative;
}
#main-footer {
    width: 100%;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em;
}
li a {
    font-size: 1.05em;
}
.buttonSize{
    padding: 2px 4px;
}
.txt-color {
color:#$businessFontColor;
font-family:$businessFont
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    color: #$navTextColor;
}
.butColor {
    color: #$butColor;
}
.gymBox {
    background: #$boxColor;
    width: 600px;
    margin-right: auto;
    margin-left: auto;
    padding: 15px;
    text-transform: none;
    color: #$textColor;
}
h3 {
    font-size: 1.35em;
}
select {
    width: 43.5%;
}
#right {
    font-size: 15px;
}
.changeColor{
    color: #$textColor;
}
select {
    color: #$textColor;
}
</style>




<body class=""><script type="text/javascript">
				 var WRInitTime=(new Date()).getTime();
				 </script>
    <img src="pictures/ajax-loader.gif" class="hide" />

    

    <div id="container" class=full-width>
                <header>
                <div class="topRightBuff">                                
                <div class="ShoppingCart float-r">
                $cartLoader
                </div>
                    <div class="TopRightMain">
                        <div id="loginArea" class="int-nav">
                                   <b>$logHtml</b>
                        </div>	
                        

<div id="global-login" class="mar-t-10">
        <div class="float-r">
            
        </div>
</div>
</div>
</div>
<div class="logo">
<a href="webIndex.php"><img src="/admin/images/contract_logo.png" alt="Logo"/></a>
</div>


<div id="main-nav" class="up topLinkBack">	
<div >
<div id="nav-start">&nbsp;</div>
                            

<div class="nav-wrap">
   $navBarUls
</div>

                        </div>	
                    </div>
                    
                </header>
        <div id="main">


<div class="row float-l">

<div class="inner">

<input type="hidden" id="buttonStorage" name="buttonStorage" value="$selectClubButton"/> 

       
<h1 id="logo"><img src="/admin/images/contract_logo.png" alt="Logo"/></h1>
<div id="content" class="login">
<div id="left" class="grid-747 float-l">
<h2>Find The Closest Location</h2>
<br>
<p><span style="color: #$textColor; font-family: $clubInfoFont; font-size:23px;"><label for="zipcode1" class="label"><u>Zipcode</u></label>
<input id="zipcode1" value="" name="zipcode1" maxlength="320" type="text" tabindex="1" class="input" /></p>
<p>
<br>
<button class="buttonPasses$middleButtons butColor" id="zipCloseSearch" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Search</span></span></button>
</p>
</ul>
</div>


<div id="right" class="grid-747 float-r boxBack">
<center><h2 class="changeColor">Find Locations Near Your Area</h2></center>
<center><u>_______________________________</u></center>
<br>

<center><p><span style="color: #$textColor; font-family: $clubInfoFont; font-size:23px;"><label for="zipcode2" class="label"><u>Zipcode</u></label>
<input id="zipcode2" value="" name="zipcode2" maxlength="320" type="text" tabindex="1" class="input" /></p>
<br>
<p><span style="color: #$textColor; font-family: $clubInfoFont; font-size:23px;"><label for="miles" class="label"><u>Distance</u></label>
<select tabindex= "1" name="miles" id="miles">
<option value="" selected>Please Select</option>  
<option value="5">5 Miles</option>
<option value="10">10 Miles</option>
<option value="25">25 Miles</option>
<option value="50">50 Miles</option>
</select></p>
<br>
<button class="buttonPasses$middleButtons butColor" id="zipAreaSearch" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Search</span></span></button></center>
</div>


      
   
    
</div>
</div>
</div>
$footer

<script src="combined.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript"><!--
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>