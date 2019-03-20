<?php
include "../../../dbConnect.php";
//this sets up the banner object
include "bannerVars.php";
include "getBannerForm.php";
if (!isset($_SESSION)) {
  session_start();
}

//error_reporting(E_ALL);
$content_form = $_REQUEST['content_form'];
$button_value = $_REQUEST['button_value'];
$banner_id = $_REQUEST['banner_id'];
/*if ($banner_id == ""){
    $banner_id = $_SESSION['banid'];
    $banner_name = $_REQUEST['name'];
     $banner_link = $_REQUEST['link']; 
    $image_name = $_REQUEST['backgroundImage']; //$$$$$$$$$$$$$$$$$$$$$$$$$$$
    $header_text = $_REQUEST['header']; 
    $header_top = $_REQUEST['headerTop1']; 
    $header_left = $_REQUEST['headerTop2']; 
    $header_right = $_REQUEST['headerTop3']; 
    $header_font = $_REQUEST['headerText'];//***********************
    $header_space = $_REQUEST['headerSpace']; 
    $header_size = $_REQUEST['headerSize']; 
    $header_strength = $_REQUEST['headerStrength']; 
    $header_color = $_REQUEST['color']; //88888888888888888
    $content_text = $_REQUEST['content']; 
    $content_top = $_REQUEST['headerTop1']; 
    $content_left = $_REQUEST['headerTop2']; 
    $content_right = $_REQUEST['headerTop3']; 
    $content_font = $_REQUEST['contentText']; 
    $content_space = $_REQUEST['headerSpace']; 
    $content_size = $_REQUEST['headerSize']; 
    $content_strength = $_REQUEST['headerStrength']; 
    $content_color  = $_REQUEST['color']; //%%%%%%%%%%%%%%%%%%%%%%%%%%%%
}else{*/
$banner_name = $_REQUEST['banner_name']; 
$banner_link = $_REQUEST['banner_link']; 
$image_name = $_REQUEST['image_name']; 
$header_text = $_REQUEST['header_text']; 
$header_top = $_REQUEST['header_top']; 
$header_left = $_REQUEST['header_left']; 
$header_right = $_REQUEST['header_right']; 
$header_font = $_REQUEST['header_font'];
$header_space = $_REQUEST['header_space']; 
$header_size = $_REQUEST['header_size']; 
$header_strength = $_REQUEST['header_strength']; 
$header_color = $_REQUEST['header_color']; 
$content_text = $_REQUEST['content_text']; 
$content_top = $_REQUEST['content_top']; 
$content_left = $_REQUEST['content_left']; 
$content_right = $_REQUEST['content_right']; 
$content_font = $_REQUEST['content_font']; 
$content_space = $_REQUEST['content_space']; 
$content_size = $_REQUEST['content_size']; 
$content_strength = $_REQUEST['content_strength']; 
$content_color  = $_REQUEST['content_color']; 
//}



//$id = $_REQUEST['i

//echo "fubar bv $button_value  m $marker x";
//----------------------------------------------------------------------------------------------------------------------------------
//if submit button is set to one, button is set to save 
if($button_value  == 1)  {	
    //echo "fubar13333 bv $button_value banclass";
    
$banners = $_SESSION['banners']; 
//var_dump($banners);
$banner_name = $banners -> getBannerName();
//echo "xxx $banner_name xx $banner_id  x $banners xxx";
$banners -> save();
$banner_blurb = "<p class=\"headerBlurb\">$banner_name Successfully Saved</p>";
}
//--------------------------------------------------------------------------------------------------------------------------------
if($button_value  == 2)   {	
$banners = $_SESSION['banners']; 
//echo "banid11 $banner_id";
        
$banners -> upDate();
//echo "fubar";
$banner_name = $banners -> getBannerName();
$banner_blurb = "<p class=\"headerBlurb\">$banner_name Successfully Updated</p>";
$banner_id = $banners-> getBannerId();	
}
//--------------------------------------------------------------------------------------------------------------------------------
if($button_value  == 3)   {	
$banners = $_SESSION['banners']; 
$banners -> delete();
$banner_name = $banners -> getBannerName();
$banner_blurb = "<p class=\"headerBlurb\">$banner_name Successfully Deleted</p>";
}

//---------------------------------------------------------------------------------------------------------------------------
//here we set up the banner object
unset($_SESSION['banners']);
$_SESSION['banners'] = new bannerVars();
$banners = $_SESSION['banners']; 

//set the defaul css object
$selectCss = new getBannerForm();
$selectCss -> setBannerForm(0);

//echo "ban id22 $banner_id";
//get the banner ID to populate the form
if(isset($banner_id))  {
$newBannerId= $banner_id;
$banners ->load($newBannerId);	 
//now we get all of the feilds from the saved report if needed to populate the form
$image_name = $banners -> getImageName();
$header_text = $banners -> getHeaderText();
$header_top = $banners -> getHeaderTop();
$header_left = $banners -> getHeaderLeft();
$header_right = $banners -> getHeaderRight();
$header_font = $banners -> getHeaderFont();
$header_size = $banners -> getHeaderSIze();
$header_space = $banners -> getHeaderSpace();
$header_strength = $banners -> getHeaderStrength();
$header_color = $banners -> getHeaderColor();

$content_text = $banners -> getContentText();
$content_top = $banners -> getContentTop();
$content_left = $banners -> getContentLeft();
$content_right = $banners -> getContentRight();
$content_font = $banners -> getContentFont();
$content_size = $banners -> getContentSIze();
$content_space = $banners -> getContentSpace();
$content_strength = $banners -> getContentStrength();
$content_color = $banners -> getContentColor();

$banner_name = $banners -> getBannerName();
$banner_link = $banners -> getBannerLink();

//get the css object
$selectCss = new getBannerForm();
$selectCss -> setBannerForm(1);
}

//get the css
$title_page = $selectCss -> getTitlePageCss(); 
$header_top_css = $selectCss -> getHeaderTopCss();
$header_left_css = $selectCss -> getHeaderLeftCss();
$header_right_css = $selectCss -> getHeaderRightCss();
$header_space_css = $selectCss -> getHeaderSpaceCss();
$header_size_css = $selectCss -> getHeaderSizeCss();
$header_strength_css = $selectCss -> getHeaderStrengthCss();
$header_color_css = $selectCss -> getHeaderColorCss();
$header_font_css = $selectCss -> getHeaderFontCss();

$content_top_css = $selectCss -> getContentTopCss();
$content_left_css = $selectCss -> getContentLeftCss();
$content_right_css = $selectCss -> getContentRightCss();
$content_space_css = $selectCss -> getContentSpaceCss();
$content_size_css = $selectCss -> getContentSizeCss();
$content_strength_css = $selectCss -> getContentStrengthCss();
$content_color_css = $selectCss -> getContentColorCss();
$content_font_css = $selectCss -> getContentFontCss();

$button = $selectCss -> getButtons();
$backLink = $selectCss -> getBackLink();

//--------------------------------------------------------------------------------------------------------------------------------
//this designates the class type for the banner images to be displayed in the carasel
include "getBannerBacks.php";

$class_type = 6;
//this is the form name from where it was called
$form_name = 'details1';
//echo "test";//now we get all of the listings for the banner backgrounds
$selectPics = new getBannerBacks();
$selectPics ->setClassType($class_type);
$selectPics ->setBannerImage($image_name);
$selectPics ->setFormName($form_name);
$listings = $selectPics-> getBannerImages();
//---------------------------------------------------------------------------------------------------------------------------------
//we load all of this into the session variable banners
//var_dump($banners);
$_SESSION['banners'] = $banners;
//$_SESSION['banid'] = $banner_id;
//---------------------------------------------------------------------------------------------------------------------------------
include "banner_form.php";
//echo "$image_name";
//exit;
echo"$contentForm";
exit;
?>


    
    
   
