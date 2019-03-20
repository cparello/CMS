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
                <table align="middle" border="0" cellspacing="0" cellpadding="4" width=50%>
                 <tr >
                <th  align="left"  bgcolor="#FFFFFF"><font face="Arial" size="5" color="#303030">Get your Guest Pass</font></th>
                
                </tr>
                <tr>
                <th align="left"  bgcolor="#FFFFFF"><font face="Arial" size="1" color="#303030">Come and try $gymName! All fields are required.</font></th>
                
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
        
        </div>
       
    </div>
</div>
        </div>

   
    

$footer
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>