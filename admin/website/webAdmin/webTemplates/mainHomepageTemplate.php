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
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em
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
.caption-text3 {
color:#$clubInfoFontColor;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    color: #$navTextColor;
}
.butColor {
    color: #$butColor;
}
#main {
background-color:#$bannerBackColor;
margin-bottom: 0px;
}
.fontGeorgia {
   font-family: Georgia, serif;
   }
   
.fontSerif {
   font-family: serif, Georgia;
   }
   
.fontArial {
   font-family: Arial, Georgia;
   }
.fontHelvetica {
   font-family: Helvetica, Arial, Georgia;
   }
.fontTimes {
   font-family: Times, Helvetica, Arial, Georgia;
   }
.fontSansSerif {
   font-family: Sans-serif, Times, Helvetica, Arial, Georgia;
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
<a href="webIndex.php">test<img src="/admin/images/contract_logo.png" alt="Logo"/></a>
</div>



<div id="main-nav" class="up topLinkBack">	
<div >
<div id="nav-start">&nbsp;</div>
                            

<div class="nav-wrap">
  <center>$navBarUls</center>
</div>

                        </div>	
                    </div>
                    
                </header>
        <div id="main">
            






    <span></span>
    
<ul class="slides">
 <div class="caption">
<h1 style="font-family: graphik-regular-web; margin-top: 5px; margin-left: 0px; color: #$headerColor; margin-bottom: 1px; font-size: $headerSize; letter-spacing: 0.2em; line-height: 1.1em; class="alt1">$headerTxt<br />
$headerTxt2</h1>
<h1 style="font-family: arial,helvetica,sans-serif; font-style: italic; margin-top: 0px; margin-left: 5px; color: #$bodyColor;  margin-bottom: 1px; line-height: 1.1em; letter-spacing: 0.15em; font-size:$bodySize width: 750px; text-transform: uppercase;">$bodyTxt</h1>
<a class="button" style="font-family: graphik-regular-web; letter-spacing: 0.2em; font-size: $bodySize; color: #ffffff; border-color: #ffffff;" href="$promoLink">Click Here!</a>
</div>
    <input type="radio" name="radio-btn" id="img-1" checked />
    <li class="slide-container">
		<div class="slide">
			<img src="pictures/1200x450/$photo1" />
        </div>
		<div class="nav">
			<label for="img-6" class="prev">&#x2039;</label>
			<label for="img-2" class="next">&#x203a;</label>
		</div>
    </li>

    <input type="radio" name="radio-btn" id="img-2" />
    <li class="slide-container">
        <div class="slide">
          <img src="pictures/1200x450/$photo2" />
        </div>
		<div class="nav">
			<label for="img-1" class="prev">&#x2039;</label>
			<label for="img-3" class="next">&#x203a;</label>
		</div>
    </li>

    <input type="radio" name="radio-btn" id="img-3" />
    <li class="slide-container">
        <div class="slide">
          <img src="pictures/1200x450/$photo3" />
        </div>
		<div class="nav">
			<label for="img-2" class="prev">&#x2039;</label>
			<label for="img-4" class="next">&#x203a;</label>
		</div>
    </li>

    <input type="radio" name="radio-btn" id="img-4" />
    <li class="slide-container">
        <div class="slide">
          <img src="pictures/1200x450/$photo4" />
        </div>
		<div class="nav">
			<label for="img-3" class="prev">&#x2039;</label>
			<label for="img-5" class="next">&#x203a;</label>
		</div>
    </li>

    <input type="radio" name="radio-btn" id="img-5" />
    <li class="slide-container">
        <div class="slide">
          <img src="pictures/1200x450/$photo5" />
        </div>
		<div class="nav">
			<label for="img-4" class="prev">&#x2039;</label>
			<label for="img-6" class="next">&#x203a;</label>
		</div>
    </li>

    <input type="radio" name="radio-btn" id="img-6" />
    <li class="slide-container">
        <div class="slide">
          <img src="pictures/1200x450/$photo1" />
        </div>
		<div class="nav">
			<label for="img-5" class="prev">&#x2039;</label>
			<label for="img-1" class="next">&#x203a;</label>
		</div>
    </li>

    <li class="nav-dots">
      <label for="img-1" class="nav-dot" id="img-dot-1"></label>
      <label for="img-2" class="nav-dot" id="img-dot-2"></label>
      <label for="img-3" class="nav-dot" id="img-dot-3"></label>
      <label for="img-4" class="nav-dot" id="img-dot-4"></label>
      <label for="img-5" class="nav-dot" id="img-dot-5"></label>
      <label for="img-6" class="nav-dot" id="img-dot-6"></label>
    </li>
</ul>


</div>
<!-- ROW: club nearby -->
<div class="midBar midButtonBack">
 <center><a href="joinPage.php"><button class="buttonJoin$middleButtons butColor" name="join" value="Join" type="buttonJoin$middleButtons">Join</button></a><a href="locationPage.php?clubName=$clubName"><button class="buttonLocation$middleButtons butColor" name="locations" value="Locations" type="buttonLocation$middleButtons">Location(s)</button></a><a href="guestPassPage.php"><button class="buttonPasses$middleButtons butColor" name="passes" value="Passes" type="buttonPasses$middleButtons"> Guest Passes</button></a></center>
</div> 





<div class="row float-l padRowBottom">

<div class="inner">
        <div id="club-review" class="grid-310 float-r"> 
        <div class="social_footer yesPad" style="width:245px; height:600px; background-color:#$annColor;">
        
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont; font-size:28px;"><b>What's New</b></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;"><u><b>$announcmentOneHead</b></u></span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-text txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">$announcmentOneCopy</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;"><u><b>$announcmentTwoHead</b></u></span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-text txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">$announcmentTwoCopy</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;"><u><b>$announcmentThreeHead</b></u></span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-text txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">$announcmentThreeCopy</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;"><u><b>$announcmentFourHead</b></u></span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
                <p class="caption-text txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">$announcmentFourCopy</span></p>
                <p class="caption-header txt-gray"><span style="color: #$announcementFontColor; font-family: $clubInfoFont;">&nbsp;</span></p>
              
            </div>
        </div>
        <div id="trending" class="grid-650 float-l">
        <div  class="grid-880 float-l noPad padClubInfo">
            <img src="pictures/homePageClubPhotos/$clubPhoto1" alt="picture 1" height="300" width="300">
            <div  class="grid-990 float-r noPad">
            <p class="caption-text3"><span style="font-size:33px; font-family: $clubInfoFont;"><b>$clubInfoOneHead</b> </span></p>       
            <br>
            <p class="caption-text3"><span style="font-family: $clubInfoFont;">$clubInfoOneCopy </span></p>           
            </div>
            </div>
            <br>
            <div  class="grid-880 float-l noPad">
            <img src="pictures/homePageClubPhotos/$clubPhoto2" alt="picture 2" height="300" width="300">
            <div  class="grid-990 float-r noPad">
            <p class="caption-text3"><span style="font-size:33px; font-family: $clubInfoFont;"><b>$clubInfoTwoHead</b></span></p>       
            <br>
            <p class="caption-text3"><span style="font-family: $clubInfoFont;">$clubInfoTwoCopy</span></p>
            </div>
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