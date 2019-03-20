<?php





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
    <script src="webScripts/webMemberLogin.js" type="text/javascript"></script>
    
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
background:#778899;
height:300px;
padding-left:25px;
padding-top:25px;
padding-bottom:25px;
padding-right:25px;
}

.grid-747  {
width: 390px;
position: relative;
}
.contentFooter  {
top: 165%;
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
h3 {
    font-size: 1.35em;
}
.contentFooter {
    position: relative;
    top: 10px;
}
#main-footer {
    width: 100%;
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
                <a href="/website/webAdmin/shoppingCart.php"><img src="pictures/Shopping-Cart-Icon.jpg" width="52" height="52" alt="Shoppin Cart"/></a><b><span id="numCartItems">&nbsp;$numberOfCartItems</span></b>
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
        
<h1 id="logo"><a href="memberLoginPage.php"><img src="/admin/images/contract_logo.png" alt="Logo"/></a></h1>
<div id="content" class="login">
<div id="left" class="grid-747 float-l">
<h2>Log In</h2>
<p><label for="barcode" class="label">Barcode Number</label>
<input id="barcode" value="" name="barcode" maxlength="320" type="text" tabindex="1" class="input" /></p>
<p><label for="password" class="label">Password</label>
<input id="password" name="password" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>
<p>
<br>
<button class="buttonPasses$middleButtons butColor" id="loginMem" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Log In</span></span></button>
</p>
</ul>
</div>
<div id="right" class="grid-747 float-r boxBack">
<center><h2>Need an account?</h2></center>
<center><u>_______________________________</u></center>
<center><h3>Be a part of $gymName online. Book classes, see your class history, schedule time with a personal trainer, update your account- it's all here!</h3></center>
<br>
<br>
<a class="ui-button button1" href="memberLoginPage.php?member=0">
<center><span class="button-left"><span class="buttonPasses$middleButtons butColor">Create an Account</span></span></a></center>
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