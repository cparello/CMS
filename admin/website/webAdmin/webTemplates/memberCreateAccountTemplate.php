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
    <script src="webScripts/checkAccount.js" type="text/javascript"></script>
    <script src="webScripts/createAccount.js" type="text/javascript"></script>
    <script src="webScripts/checkCode.js" type="text/javascript"></script>
    
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
.contentFooter  {
top: 600px;
}
.moveLeft  {
left: 10px;
}
.grid-747  {
width: 390px;
height:300px;
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

.autboxForm{
  top: 500px;
  width: 390px;
    height:300px;  
    position: absolute;
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
<div id="left" class="grid-747 float-l moveLeft">
<h2>Verify Information</h2>
<p><label for="name" class="label">Name</label>
<input id="name" value="" name="name" maxlength="320" type="text" tabindex="1" class="input" disabled/><p>
<label for="barcode" class="label">Barcode Number</label>
<input id="barcode" value="" name="barcode" maxlength="320" type="text" tabindex="1" class="input" /></p>
<p><label for="zipcode" class="label">Zipcode</label>
<input id="zipcode" value="" name="zipcode" maxlength="320" type="text" tabindex="1" class="input" /></p>
<p><label for="email" class="label">Email Address</label>
<input id="email" value="" name="email" maxlength="320" type="text" tabindex="1" class="input" /></p>
<br>
<button class="buttonPasses$middleButtons butColor buttonSize" id="search" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Check Information</span></span></button></p>
</div>
<div id="right" class="grid-747 float-r">
<h2>Create a Password</h2>
<p><label for="password1" class="label">Password</label>
<input id="password1" name="password1" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>
<p><label for="password2" class="label">Confirm Password</label>
<input id="password2" name="password2" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>
<p>
<br>
<button class="buttonPasses$middleButtons butColor buttonSize" id="create" "type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Create Account</span></span></button>
<input type="hidden" id="checkTest" name="checkTest" value="" />
</p>
</ul>

</div>
<br>
<div id="authBox" class="autboxForm">
<h2>Authorization Code</h2>
<input id="code" value="" name="code" maxlength="320" type="text" tabindex="5" class="input" /></p>
<br>
<button class="buttonPasses$middleButtons butColor buttonSize" id="check" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Check Code</span></span></button></p>
</div>


      
   
    
</div>
</div>
$footer
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>