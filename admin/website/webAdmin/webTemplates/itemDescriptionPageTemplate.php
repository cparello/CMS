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
<div class="row float-l">

<div class="inner">
<div class="headerContainer">
  <table border="0" width="996" cellpadding="0" cellspacing="0">
    <tbody>
    <center>$buttonsHtmlMiddle</center>
  </tbody>
  </table>
</div>
<div class="mainContent">
<!-- TemplateBeginEditable name="body" -->
<script src="../javascripts/jquery-1.8.3.min.js"></script>
	<script src="webScripts/jquery.elevatezoom.js"></script>

   <!-- LADIES -->
      

<table class="productTable" align="center" bgcolor="#FFFFFF" border="0" height="1111" width="910" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td align="left" height="411" valign="top" width="425"><table border="0" width="403" cellspacing="0">
            <tbody><tr>
              <td align="center" valign="top" width="100%"><img id="zoom_01" src="pictures/gear/$pictureMain" data-zoom-image="pictures/gear/$pictureMain" height="575" width="600"></td>
            </tr>
          </tbody></table></td>
          <td height="254" valign="top" width="477">
            <table border="0" width="100%" cellspacing="1">
              <tbody><tr>
                <td align="right" height="37" valign="top"><span class="prod_title">$product_desc</span></td>
              </tr>
              <tr>
                <td class="prodCopy" align="right" height="16" valign="top">$description.</td>
              </tr>
              <tr>
               
              </tr>
              <tr>
                <td align="left" height="1" valign="middle">
                  <div class="priceBox">$$retail_cost</div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top"><table border="0" width="100%" cellpadding="5" cellspacing="0">
                  <tbody><tr>
                     <td class="buttonRight"><button class="buttonLocation$middleButtons butColor buttonSize2" id="add" name="add" value="add" type="buttonLocation$middleButtons">Add to Cart</button>&nbsp;<button class="buttonLocation$middleButtons butColor buttonSize2" name="back" id="back" value="back" type="buttonLocation$middleButtons">Back</button></td>
                  </tr>
                  <tr>
                  <td>
                  &nbsp;
                  </td>
                  </tr>
                  <tr>
                  <td class="buttonRight">
                    <button class="buttonLocation$middleButtons butColor buttonSize2" name="checkOut" id="checkOut" value="checkOut" type="buttonLocation$middleButtons">Check Out</button>
                  </td>
                  </tr>
                </tbody></table></td>
              </tr>
            </tbody></table>
    </td></tr><tr>
          <td colspan="2" align="right" height="22" valign="middle">&nbsp;</td>
    </tr><tr>
          <td colspan="2" class="relatedBar" align="right" height="25" valign="middle">If you like this item, you might also like these...</td>
    </tr><tr>
          <td colspan="2" align="left" height="106" valign="top"><table border="0" width="100%" cellpadding="5" cellspacing="0">
            <tbody><tr>
              $upsellLike
            </tr>
      </tbody></table></td>
    </tr><tr>
      <td colspan="2" align="left" valign="top"><table border="0" width="100%" cellpadding="0" cellspacing="0">
          
      </table></td>
  </tr></tbody></table>

<input type="hidden" name="product_array" id="product_array" value="$productArray"/>
<input type="hidden" name="current_cat" id="current_cat" value="$category_id"/>
        
      

<div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:308px;top:142px;height:575px;width:600px;"><div style="width: 400px;" class="zoomWindowContainer"><div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: -85.2837px -308.28px; width: 600px; height: 613px; float: left; cursor: crosshair; background-repeat: no-repeat; position: absolute; background-image: url(&quot;pictures/gear/$pictureMain&quot;); top: 0px; left: 0px; display: none;" class="zoomWindow">&nbsp;</div></div></div>
<div style="width: 400px;" class="zoomWindowContainer"><div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: -85.2837px -308.28px; width: 600px; height: 613px; float: left; cursor: crosshair; background-repeat: no-repeat; position: absolute; background-image: url(&quot;pictures/gear/$pictureMain&quot;); top: 0px; left: 0px; display: none;" class="zoomWindow">&nbsp;</div></div>
<div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: -85.2837px -308.28px; width: 600px; height: 613px; float: left; cursor: crosshair; background-repeat: no-repeat; position: absolute; background-image: url(&quot;pictures/gear/$pictureMain&quot;); top: 0px; left: 0px; display: none;" class="zoomWindow">&nbsp;</div>
<script>
    $('#zoom_01').elevateZoom({
    zoomType: "inner",
cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 750
   }); 
</script>
<!-- TemplateEndEditable -->
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