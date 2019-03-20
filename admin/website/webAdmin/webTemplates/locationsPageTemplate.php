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
    <script src="webScripts/guestPassReg.js" type="text/javascript"></script>
    
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
</style>
<style>
  #map-canvas {
    width: 450px;
    height: 300px;
    background-color: #CCC;
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
#main {
background-color:#$bannerBackColor;
margin-bottom: 0px;
}
.row .inner {
    padding-top: 20px;
}
</style>
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false">
    </script>

 <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng($longitude, $Lattitude),
          zoom: 15
        };
                
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
            var marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            title: 'Click to zoom'
          });
        
          google.maps.event.addListener(map, 'center_changed', function() {
            // 3 seconds after the center of the map has changed, pan back to the
            // marker.
            window.setTimeout(function() {
              map.panTo(marker.getPosition());
            }, 3000);
          });
        
          google.maps.event.addListener(marker, 'click', function() {
            map.setZoom(16);
            map.setCenter(marker.getPosition());
          });

      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>


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
<ul class="slides">
 <div class="caption">
<h1 style="font-family: graphik-regular-web; margin-top: 5px; margin-left: 0px; color: #$headerColor; margin-bottom: 1px; font-size: $headerSize; letter-spacing: 0.2em; line-height: 1.1em; class="alt1">$headerTxt<br />
$headerTxt2</h1>
<h1 style="font-family: arial,helvetica,sans-serif; font-style: italic; margin-top: 0px; margin-left: 5px; color: #$bodyColor;  margin-bottom: 1px; line-height: 1.1em; letter-spacing: 0.15em; font-size:$bodySize width: 750px; text-transform: uppercase;">$bodyTxt</h1>
<a class="button" style="font-family: graphik-regular-web; letter-spacing: 0.2em; font-size:$bodySize; color: #ffffff; border-color: #ffffff;" href="/website/webAdmin/$promoLink">Click Here!</a>
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
 <center>$buttonsHtmlMiddle</center>
</div> 






<div class="row float-l">

<div class="inner">
        <div class="aboutClub">
         <div  class="grid-777 float-l noPad">
            <h2><b>$viewedClubName</b> </h2>
            <br>
            <p class="caption-header txt-gray"><span style="font-family: Graphik-Light-Web;">$clubText</span></p>
            <br>
            <tr>
            <td align="left" colspan="2" class="grey">
             <b>Phone:&nbsp;&nbsp;</b>$club_phone
            </td>
            <br>
            <br>
            <td align="left" colspan="2" class="grey">
             <b>Hours:</b><br>$hoursText1, $hoursText2
            </td>
            </tr>
            <br>
            <tr>
            <td align="left" colspan="2" class="grey">
             <br><b>Address:&nbsp;&nbsp;</b>$club_address
            </td>
            <br>            
            <td align="left" colspan="2" class="grey">
             <br><b>Manager:&nbsp;&nbsp;</b>$club_contact
            </td>
            </tr>
            <br>
            <tr>
            <td align="left" colspan="2" class="grey">
             <br><b>Ammenities:</b>
            </td>
            <br>
            <td align="left" colspan="3" class="grey">
             $amenities1 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities2 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities3 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities4 -
            </td>
            <br>
            </tr>
            <tr>
            <td align="left" colspan="3" class="grey">
             $amenities5 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities6 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities7 -
            </td>
            <td align="left" colspan="3" class="grey">
             $amenities8
            </td>
            
            </tr>
            <br>
            <br>
                
                
             
                
                
                <table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>
                 <tr >
                <th  align="left"  bgcolor="#FFFFFF"><font face="Arial" size="5" color="#303030">Get your Guest Pass</font></th>
                
                </tr>
                <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030">Come and try $gymName for $guestPassLength day(s)! All fields are required.</font></th>
                
                </tr>
                   <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>First Name</b></font></th>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>Last Name</b></font></th>
                </tr>
                <tr>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                <font face="Arial" size="1" color="black"><input  name="first_name" type="text" id="first_name" value="" size="20" maxlength="60"/></font>
                </td>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                <font face="Arial" size="1" color="black"><input  name="last_name" type="text" id="last_name" value="" size="20" maxlength="30" /></font>
                </td>
                </tr>
                <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>Email</b></font></th>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>Confirm Email</b></font></th>
                </tr>
                <tr>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                <font face="Arial" size="1" color="black"><input  name="email" type="text" id="email" value="" size="20" maxlength="60"/></font>
                </td>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                <font face="Arial" size="1" color="black"><input  name="confirm_email" type="text" id="confirm_email" value="" size="20" maxlength="30" /></font>
                </td>
                </tr>
                <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>Mobile Number</b></font></th>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><b>Location</b></font></th>
                </tr>
                <tr>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                <font face="Arial" size="1" color="black"><input  name="phone" type="text" id="phone" value="" size="20" maxlength="60" />  </font>
                </td>
                <td align="left" valign ="top" bgcolor="#FFFFF0">
                    <select tabindex= "1" name="location" id="location">
                    <option value="" selected>Please Select</option>  
                    $clubDrop
                    </select>
                </td>
                </tr>
               <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><input type="submit"  class="buttonLocation$middleButtons butColor noPad" name="createPass" id="createPass" value="Get Pass" /></th>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030"><input type="hidden" name="marker" value="1" /></th>
                </tr>
                </table>
                   
            </div>
            <div id="map-canvas" class="float-r"></div>

        </div>
        <div class="scheduleLink float-r"><a href="schedulePage.php" target="" title="View Class Schedule"><font color="white"><font size=7>View</font></font></a>
        <a href="schedulePage.php" target="" title="View Class Schedule"><font color="white"><font size=1>Class Schedule</font></font></a>
        <a href="schedulePage.php" style="margin:0px 30px 0px 0px"><img src="pictures/arrow-grey-right.jpg" width="15" height="15" /></a> 
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