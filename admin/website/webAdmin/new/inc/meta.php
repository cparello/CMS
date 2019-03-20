<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $bus_name ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Lato:300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/foundation.min.css" />
<link rel="stylesheet" href="css/style.css" />
<style>
.botLinks3:Link {
text-decoration:none;
color: #FFFFFF;
}
.botLinks3:visited{
text-decoration:none;
color: #FFFFFF;
}
.botLinks3:active{
text-decoration:none;
color: #FFFFFF;
}
a.botLinks3:hover { 
text-decoration:none;
color: #1F52FF; 
}

.headerContact  {
position: absolute;
top: 5px;
left: 20px;
width: 280px;
height:260px; 
text-align: left;
font-size: 9pt;
font-weight: 400;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #FFFFFF;
overflow: auto;
z-index: 4;
}

.privacy {
position: relative;
bottom: 350px;
left: 175px;
width: 300px; 
height:260px; 
border-style: solid; 
border-width:2px;
border-color: #C5C4CC;
background: #000000;
background-repeat: repeat ;
padding-bottom: 0px;
display:none;
z-index: 3;
}
.popx2 {
position: relative; 
top: 0px; 
left: 0px; 
display:none;
z-index: 6;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/vendor/modernizr.js"></script>
	<script>
        $(document).ready(function() {
            function pop(url) {
            newwindow=window.open(url,'name','height=500,width=375,scrollbars=yes');
            }
            
            function pop1(url) {
            newwindow=window.open(url,'name','height=200,width=300,scrollbars=no');
            }
             $("a.botLinks3",this).click(function() {           
                   $("#privacy").fadeIn(1000); 
                   $("#popx2").fadeIn(1000); 
                });   
             $(".popx2",this).click(function() {                                  
                   $("#privacy").fadeOut("slow"); 
                   $("#popx2").fadeOut("slow"); 
                }); 
                
             }); 
                </script>    
 <?php                
$stmt = $dbMain ->prepare("SELECT banner_text_color, top_link_bar_text, banner_back_color, top_link_bar, ann_color, mid_but_bar, middle_buttons_color, bottom_bar_color, announcment_1_headline, announcment_1_copy, announcment_2_headline, announcment_2_copy, announcment_3_headline, announcment_3_copy,announcment_4_headline, announcment_4_copy, club_info_headline1, club_info_copy1, club_info_headline2, club_info_copy2, facebook_business_page_name, twitter_handle, youtube_chanel_name, email, photo1, photo2, announcement_font, announcement_font_color, club_info_font, club_info_font_color, business_font, business_font_color, but_color, yelp_page, google_plus, instagram, linked_in, pinterest, buttonColor, buttonTextColor, buttonBorderColor, buttonHoverColor, buttonFocusColor FROM website_colors WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($bannerTextColor, $topLinkBarText, $bannerBackColor, $topLinkBar, $annColor, $midButBar, $middleButtons, $bottomBar, $announcmentOneHead, $announcmentOneCopy, $announcmentTwoHead ,$announcmentTwoCopy ,$announcmentThreeHead, $announcmentThreeCopy, $announcmentFourHead, $announcmentFourCopy, $clubInfoOneHead, $clubInfoOneCopy, $clubInfoTwoHead, $clubInfoTwoCopy, $faceBookBusinessName, $twitterHandle, $youtubeChannel, $email , $photo1, $photo2, $announcementFont, $announcementFontColor, $clubInfoFont, $clubInfoFontColor, $businessFont, $businessFontColor, $butColor, $yelpPage , $googlePlus, $instagram, $linkedIn, $pinterest, $buttonColor, $buttonTextColor, $buttonBorderColor, $buttonHoverColor, $buttonFocusColor);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
?>
<style>
    nav, footer, .top-bar, .top-bar-section li:not(.has-form) a:not(.button), .top-bar-section li:hover:not(.has-form) a:not(.button), .top-bar-section .dropdown li:not(.has-form):not(.active) > a:not(.button), .top-bar-section .dropdown li:hover:not(.has-form):not(.active) > a:not(.button) {
    background: #<?php echo $topLinkBar ?> none repeat scroll 0% 0%;
    color: #<?php echo $topLinkBarText ?>;
}
#cover h1 {
    color: #<?php echo $bannerTextColor ?>;
    background: #<?php echo $bannerBackColor ?>;
}
#cover{
    background: #<?php echo $bannerBackColor ?>;
}
#icons i {
    background: #<?php echo $topLinkBar ?> none repeat scroll 0% 0%;
    
}
.txtColor{
    color: #<?php echo $butColor ?>
}
#hp-content {
    background: #<?php echo $annColor ?> none repeat scroll 0% 0%;

}
button:focus, .button:focus {
    background-color: #<?php echo $buttonFocusColor ?>;
}
button:hover,  .button:hover, {
    background-color: #<?php echo $buttonHoverColor ?>;
}
button, .button {
    background-color: #<?php echo $buttonColor ?>;
    border-color: #<?php echo $buttonBorderColor ?>;
    color: #<?php echo $buttonTextColor ?>;
}
    </style>