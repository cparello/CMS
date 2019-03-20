<?php
//echo "rerererererer";
$stmt = $dbMain ->prepare("SELECT banner_back_color, top_link_bar, ann_color, mid_but_bar, middle_buttons_color, bottom_bar_color, announcment_1_headline, announcment_1_copy, announcment_2_headline, announcment_2_copy, announcment_3_headline, announcment_3_copy,announcment_4_headline, announcment_4_copy, club_info_headline1, club_info_copy1, club_info_headline2, club_info_copy2, facebook_business_page_name, twitter_handle, youtube_chanel_name, email, photo1, photo2, announcement_font, announcement_font_color, club_info_font, club_info_font_color, business_font, business_font_color, but_color FROM website_colors WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($bannerBackColor, $topLinkBar, $annColor, $midButBar, $middleButtons, $bottomBar, $announcmentOneHead, $announcmentOneCopy, $announcmentTwoHead ,$announcmentTwoCopy ,$announcmentThreeHead, $announcmentThreeCopy, $announcmentFourHead, $announcmentFourCopy, $clubInfoOneHead, $clubInfoOneCopy, $clubInfoTwoHead, $clubInfoTwoCopy, $faceBookBusinessName, $twitterHandle, $youtubeChannel, $email, $clubPhoto1, $clubPhoto2, $announcementFont, $announcementFontColor, $clubInfoFont, $clubInfoFontColor, $businessFont, $businessFontColor, $butColor);
$stmt->fetch();

if(!$stmt->execute()) {
    printf("Error: load web stuff%s.\n", $stmt->error);
}
$stmt->close();

switch($businessFont){
    case 'Arial':
        $businessFontCss = "fontArial";
    break;
    case 'Helvetica':
        $businessFontCss = "fontHelvetica";
    break;
    case 'Times':
        $businessFontCss = "fontTimes";
    break;
    case 'serif':
        $businessFontCss = "fontSerif";
    break;
    case 'Georgia':
        $businessFontCss = "fontGeorgia";
    break;
    case 'Sans-serif':
        $businessFontCss = "fontSansSerif";
    break;
}

$stmt = $dbMain ->prepare("SELECT business_name, business_phone FROM business_info WHERE bus_id= '1000'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_name, $business_phone);
$stmt->fetch();

if(!$stmt->execute())  {
    printf("Error: bus info%s.\n", $stmt->error);
}
$stmt->close();



$footer = "<footer id=\"main-footer\">
<div  class=\"contentFooter bottomBack\">
        <div  class=\"busInfo float-l $businessFontCss\">
    <p class=\"txt-color\">$business_name&nbsp;|&nbsp;&nbsp;$business_phone&nbsp;&nbsp;|&nbsp;&nbsp;$email</p>
    <p class=\"txt-color\">&copy; &nbsp; $business_name</p>    
        </div>

        <div  class=\"socialIcons float-r\">
            <a href=\"https://www.facebook.com/pages/$faceBookBusinessName\" style=\"margin:0px 30px 0px 0px\"><img src=\"pictures/Facebook-Logo.png\" width=\"55\" height=\"55\"/></a> 
            <a href=\"https://twitter.com/$twitterHandle\" style=\"margin:0px 30px 0px 0px\"><img src=\"pictures/twitter_icon.jpg\" width=\"52\" height=\"52\" /></a> 
        <a href=\"http://www.youtube.com/user/$youtubeChannel\"><img src=\"pictures/youTube.jpg\" width=\"52\" height=\"52\" /></a> 
        </div>
</div>
</footer>";

?>