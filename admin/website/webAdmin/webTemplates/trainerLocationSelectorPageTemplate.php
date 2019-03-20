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
 <link rel="stylesheet" href="../../css/info.css">
<link rel="stylesheet" href="../../css/scheduleType.css">
<link rel="stylesheet" href="../../css/pop_hint.css">
    <link href="webCss/combined.css" rel="stylesheet" type="text/css" />
    <script src="../../scripts/jqueryNew.js" type="text/javascript"></script>
<script type="text/javascript" src="webScripts/scheduleScripts/viewDescrips.js"></script>

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
top: 200px;
position: relative;
}
#main-footer {
    width: 100%;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em;
}
.full-width .row,.full-width .row.float-l,.full-width .row.spacer-btm {
margin-right:0;
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
.row .inner {
    padding-top: 60px;
    margin-right: auto;
    margin-left: auto;
}
.full-width .row, .full-width .row.float-l, .full-width .row.spacer-btm {
    margin-right: 140px;
}
/*#main-nav .nav-wrap {
    margin-left: 85px;
}*/
h1 {
    color: #000;
}
.middle {
    width: 600px;
    margin-left: auto;
    margin-right: auto;
    float: none;
}
.box {
    margin-left: auto;
    margin-right: auto;
}
.black {
    font-size: 12pt;
    font-weight: 500;
    font-style: normal;
    font-family: "Arial","Helvetica","Times",serif;
    color: #000;
    z-index: 2;
}

.gymBox {
    background: #$boxColor;
    width: 275px;
    margin-right: auto;
    //margin-left: auto;
    padding: 15px;
    text-transform: none;
    color: #$textColor;
    height: 100px;
}
select {
    width: 50%;
}
</style>



</head>

<body class=""><script type="text/javascript">
				 var WRInitTime=(new Date()).getTime();
				 </script>
    <img src="pictures/ajax-loader.gif" class="hide" />

    

    <div id="container" class=full-width>
                <header>
                <div class="topRightBuff">                                
                <div class="ShoppingCart float-r">
                <a href="/website/webAdmin/shoppingCart.php"><img src="pictures/Shopping-Cart-Icon.jpg" width="52" height="52" alt="Shoppin Cart"/></a><b><span id="numCartItems">&nbsp;$numberOfCartItems</span></b>
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
            






    <span></span>    
 



<!-- ROW: club nearby -->
<div class="middle">

<div class="inner">
<br><br><br><br><br>
<tr>
<td>
<center><h3>View Our Trainers</h3></center>
</td>
</tr>
<br>
<form name="form1" id="form1" action="trainersPage.php" method="post">

<div class="box gymBox">
<tr>
<td class="black">
<center>1.  Select Location:</center>
</td>
<td>
<center><select tabindex= "1" name="location" id="location">
<option value="" selected>Please Select</option>  
$clubDrop
</select></center>
</td>
</tr>

<tr>
<td>
</td>
<td class="black">
<br>
<input type="submit" id="loadTrainers" class="buttonJoin$middleButtons buttonSize butColor" name="loadTrainers" value="Load Class Descriptions" />
<td>
</tr>
</div>

</div>

</table>
</div>
</div>
</form>
                   
            </div>
            

        </div>
        
        </div>
       
    </div>
</div>
        </div>

   
    

$footer
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>