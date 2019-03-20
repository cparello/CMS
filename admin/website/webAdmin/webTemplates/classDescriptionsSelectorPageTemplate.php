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
    <script type="text/javascript" src="../../scripts/helpPops.js"></script>
<script type="text/javascript" src="../../scripts/helpTxtCategory.js"></script>
<script type="text/javascript" src="webScripts/scheduleScripts/loadBundleDrops.js"></script>
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
top: 100%;
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
<center><h3>View Class Descriptions</h3></center>
</td>
</tr>
<br>
               <form>
<table border="0" align="center" cellspacing="0" cellpadding="0">

<div class="box">
<tr>
<td class="black">
1.  Select Schedule Category:&nbsp;&nbsp;
</td>
<td>
<select name="schedule_type"  id="schedule_type" class="black3"/>
$schedule_type_drops
</select>
</td>
</tr>

<tr>
<td class="black">
2.  Select Bundle Name:&nbsp;&nbsp;
</td>
<td>
<select name="bundle_type"  id="bundle_type" class="black3"/>
$bundle_type_drops
</select>
</td>
<td>
(OPTIONAL)
</td>
</tr>

<br>

<tr>
<td>
</td>
<td class="black">
<br>
<input type="button" id="classDescrips" class="buttonJoin$middleButtons buttonSize butColor" name="classDescrips" value="Load Class Descriptions" />
<td>
</tr>
</div>
</table>
</div>





<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>


<div class="chartSave"  id="chartSave">
<img class="menu_exit"   id="menu_exit" src="../images/popx.png" alt="" />
<div id="saveForm">
<table cellpadding="2" border="0">
<tr>
<td>
Schedule Name  
</td>
<td>
<input type="text" id="bundle_name" name="bundle_name" size="30" maxlength="40"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td class="tPad" align="right">
<input  type="button" class="button1" id="button2" name="save" value="Save Name"/>
</td>
</tr>
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