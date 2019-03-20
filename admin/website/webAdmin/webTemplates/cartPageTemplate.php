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
    <script src="webScripts/addToCart.js" type="text/javascript"></script>
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
top: 1500px;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em;
}
.buttonSize{
    padding: 2px 4px;
}
.buttonSize2{
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

.block {                            
    position: absolute;
    //background: grey;               
    //border: 1px solid black;          
    }                                                    
                                      
.s1x1 {                             
    height: 60%;                    
    width: 15%; 
    text-align:center;
    font:16px arial,sans-serif;
    background-color: #$boxColor;
    color: #000000;
    text-decoration-color: #F0FFFF;
    -moz-text-decoration-color:  #F0FFFF;    
    padding-top: 10px;   
    padding-right: 15px;   
    padding-left: 15px;        
    } 
    
.$cssBox1  
.$cssBox2
.$cssBox3 
.$cssBox4 
.$cssBox5 
.$cssBox6

#myform {
    text-align: center;
    padding: 5px;
    //border: 1px dotted #ccc;
    margin: 2%;
}
.qty {
    width: 40px;
    height: 25px;
    text-align: center;
}
//input.qtyplus { width:25px; height:25px;}
//input.qtyminus { width:25px; height:25px;}  
input {
    line-height: 23px;
    text-indent: 5px;
}
input {
    margin: 0px 7px 0px 7px;
}     
.caption-header {
    padding-left: 0px;
}       
#paymentInfoTab {
    position: relative;
    top: 75px;
    left: 0px;
    margin-bottom: 15px;
    margin-top: 15px;
    height: 30px;
    width: 500px;
}    
.headerContainer{
    top: 75px;
    margin-top: 15px;
     margin-bottom: 15px;
}
.mainContent {
    background-color: #FFF;
    margin-top: -10px;
}
.tagContainer {
    width: 937px;
    margin-right: auto;
    margin-left: auto;
    text-align: right;
    color: #FFF;
    background-color: #FFF;
}
.priceBox{
     margin-top: 15px;
     margin-bottom: 15px;
}
.prod_title {
    font-size: 55px;
    color: #666;
    font-weight: 700;
    text-transform: uppercase;
}
.priceBox {
    width: 200px;
    height: 59px;
    float: right;
    padding-top: 23px;
    text-align: right;
    padding-right: 23px;
    font-size: 49px;
    font-weight: 400;
    padding-bottom: 23px;
}
.buttonRight{
     text-align: right;
     margin-top: 15px;
     margin-bottom: 15px;
}
.relatedBar {
    background-color: #$topLinkBar;
    font-size: 18px;
    font-weight: 600;
    padding-right: 15px;
    text-transform: uppercase;
    color: #$navTextColor;    
}
.prod_title {
    color: #000;
}
.contentFooter {
    top: 1165px;
    posistion: relative;
}
#main-footer {
    width: 100%;
  
}
.cartList{
     margin-top: 100px;
     margin-bottom: 15px;
     margin-right: auto;
     margin-left: auto;
     width: 50%;
     float: none;
     
}
.textTop{
  text-decoration: underline; 
  font-weight: bold; 
  font-size: 18px;
}
.textItem{
  text-decoration: none; 
  font-weight: normal; 
  font-size: 18px;
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
<div class="row">

<div class="cartList">
<h2>Items in cart</h2>
$html
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