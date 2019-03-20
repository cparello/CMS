<?php
class getBannerForm   extends bannerVars {

public $title_page = "Create Banners";
public $header_top_css;
public $header_left_css;
public $header_right_css;
public $header_space_css;
public $header_size_css;
public $header_strength_css;
public $header_color_css;
public $header_font_css;
public $content_top_css;
public $content_left_css;
public $content_right_css;
public $content_space_css;
public $content_size_css;
public $content_strength_css;
public $content_color_css;
public $content_font_css;
public $buttons;
public $banner_blurb;
public $back_link;

//------------------------------------------------------------------------------



//------------------------------------------------------------------------------
//adds quotes to fonts that have two names separated by spaces for the css
function addFontQuotes($the_fonts)  {
$the_fonts = trim($the_fonts);
$font_family_array = explode(",",$the_fonts);

for($i=0; $i < count($font_family_array); $i++)  {
     $font_family_array[$i] = trim($font_family_array[$i]);
     if (preg_match("/\\s/", $font_family_array[$i])) {
         $font_type1 .= " \"$font_family_array[$i]\",";        
        }else{
          $font_type2 .= $font_family_array[$i] .",";
        }
    }
     $font_family = $font_type1 . $font_type2;
     $font_family  = substr($font_family, 0, -1);
      
return $font_family;      
}
//----------------------------------------------------------------------------------




function setBannerForm($formType)  {
global $banner_name;
global $header_top;
global $header_left;
global $header_right;
global $header_space;
global $header_size;
global $header_strength;
global $header_color;
global $header_font;

global $content_top;
global $content_left;
global $content_right;
global $content_space;
global $content_size;
global $content_strength;
global $content_color;
global $content_font;

//$banner_name = $this->banner_name;





  switch($formType) {
	             case "0":
	                         $this->back_link = "";
							 $this->title_page = "Create Banners";
							 $this->header_top_css = '0px';
							 $this->header_left_css = '0px';
                             $this->header_right_css  = '0px';
                             $this->header_space_css ='0px';
                             $this->header_size_css ='12pt';
                             $this->header_strength_css ='100';
                             $this->header_color_css = '#000000';
                             $this->header_font_css = 'Arial';
                             $this->content_top_css ='0px';
                             $this->content_left_css = '0px';
                             $this->content_right_css = '0px';
                             $this->content_space_css = '0px';
                             $this->content_size_css = '12pt';
                             $this->content_strength_css ='100';
                             $this->content_color_css = '#000000';
                             $this->content_font_css = 'Arial';
                             $this->banner_blurb = "<p class=\"headerBlurb\">$banner_name Successfully Saved</p>";
							 $this->buttons ="<input type=\"button\" value=\"Save Banner\" class=\"btn\" onClick=\"setTimeout('submitForm(1)', 2000)\"  />";
							break;			 				 
                case "1":
                             //$this->back_link = "<p><br><a href=\"edit_banners.php\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><b>Back to Edit Banners List</b></font></a></p>";
							 $this->title_page = "Edit  \"$banner_name\"  Banner";
                             $this->header_top_css = $header_top ."px";
                             $this->header_left_css = $header_left ."px";
                             $this->header_right_css = $header_right ."px";
                             $this->header_space_css = $header_space ."px";
                             $this->header_size_css = $header_size ."pt";
                             $this->header_strength_css = $header_strength;
                             $this->header_color_css = "#" . $header_color;
                             $this->header_font_css = $this->addFontQuotes($header_font);
                             $this->content_top_css = $content_top ."px";
                             $this->content_left_css = $content_left ."px";
                             $this->content_right_css = $content_right ."px";
                             $this->content_space_css = $content_space ."px";
                             $this->content_size_css = $content_size ."pt";
                             $this->content_strength_css = $content_strength;
                             $this->content_color_css = "#" . $content_color;
                             $this->content_font_css = $this->addFontQuotes($content_font);
                             $this->banner_blurb = "<p class=\"headerBlurb\">$banner_name Successfully Updated</p>";
							 $this->buttons ="<input type=\"button\" value=\"Update Banner\" class=\"btn\" onClick=\"setTimeout('submitForm(2)', 2000)\"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Delete Banner\" class=\"btn\" onClick=\"setTimeout('submitForm(3)', 2000)\"  />";	
							 //split the fonts to add quotes if needed											 
							 break;
	                    }
	
}


function getTitlePageCss() {
		       return($this->title_page);
	      }			
			
function getHeaderTopCss() {
		       return($this->header_top_css);
	      }			
				
function getHeaderLeftCss() {
		       return($this->header_left_css);
	      }														
		
function getHeaderRightCss() {
		       return($this->header_right_css);
	      }								

function getHeaderSpaceCss() {
		       return($this->header_space_css);
	      }		

function getHeaderSizeCss() {
		       return($this->header_size_css);
	      }		

function getHeaderStrengthCss() {
		       return($this->header_strength_css);
	      }		

function getHeaderColorCss() {
		       return($this->header_color_css);
	      }		

function getHeaderFontCss() {
		       return($this->header_font_css);
	      }		



function getContentTopCss() {
		       return($this->content_top_css);
	      }			
				
function getContentLeftCss() {
		       return($this->content_left_css);
	      }														
		
function getContentRightCss() {
		       return($this->content_right_css);
	      }								

function getContentSpaceCss() {
		       return($this->content_space_css);
	      }		

function getContentSizeCss() {
		       return($this->content_size_css);
	      }		

function getContentStrengthCss() {
		       return($this->content_strength_css);
	      }		

function getContentColorCss() {
		       return($this->content_color_css);
	      }		
	      
function getContentFontCss() {
		       return($this->content_font_css);
	      }			      


function getButtons() {
		       return($this->buttons);
	      }	
	      
function getBackLink() {
		       return($this->back_link);
	      }				      
	      
}
?>