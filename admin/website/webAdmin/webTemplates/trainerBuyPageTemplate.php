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
    <script src="webScripts/changeTrainingPackageValue.js" type="text/javascript"></script>
    
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
    //border: 1px solid black;          
    }                                                    
                                      
.s1x1 {                             
    height: 470px;                    
    width: 305px; 
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
<br>
<p class="caption-header txt-gray"><span style="color: #000000; font-family: $clubInfoFont; font-size:28px;"><b>Get Fit Now!</b></p>
<br>
<p class="caption-header txt-gray"><span style="color: #000000; font-family: $clubInfoFont; font-size:28px;"><b>Featured Training Packages</b></p>
<br>
<div class="joinBox">
    $divBoxes
    <center><input type='button' value='Purchase' id='purchase' class='buttonPurchase buttonPasses$middleButtons buttonSize' field='number_memberships'/><input type='button' value='Go Back' id='back' class='buttonPurchase buttonPasses$middleButtons buttonSize' field='none' onclick="location.href = 'locationSelectorPage.php';"/></center>
<input type="hidden" name="alreadyMember" id="alreadyMember" value="$alreadyMember"/>
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