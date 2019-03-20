<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  barCode{

private $text = null;
private $format = null;
private $quality = null;
private $width = null;
private $bHeight = null;
private $barcode = null;
private $type = null;
private $im = null;
private $imageStream = null;
private $imagePath = null;
private $imageName = null;
private $imageSave = null;



function setText($text) {
      $this->text = $text;
      }
function setFormat($format) {
      $this->format = $format;
      }    
function setQuality($quality) {
      $this->quality = $quality;
      }       
function setWidth($width) {
      $this->width = $width;
      }
function setBHeight($bHeight) {
      $this->bHeight = $bHeight;
      }
function setBarcode($barcode) {
      $this->barcode = $barcode;
      }
function setType($type) {
      $this->type = $type;
      }     
function setImagePath($imagePath) {
      $this->imagePath = $imagePath;
      }
function setImageName($imageName) {
      $this->imageName = $imageName;
      }      
      
      
function setImageStream($imageStream) {
      $this->imageStream = $imageStream;
      }

//=====================================================================
function barcode39() {



        switch ($this->format)  {  
                default:  
                        $this->format = "JPEG";  
                case "JPEG":   
                        header ("Content-type: image/jpeg");  
                        break;  
                case "PNG":  
                        header ("Content-type: image/png");  
                        break;  
                case "GIF":  
                        header ("Content-type: image/gif");  
                        break;  
        }  
  
  
        $this->im = ImageCreate ($this->width, $this->bHeight)  
    or die ("Cannot Initialize new GD image stream");  
        $White = ImageColorAllocate ($this->im, 255, 255, 255);  
        $Black = ImageColorAllocate ($this->im, 0, 0, 0);  
        //ImageColorTransparent ($im, $White);  
        ImageInterLace ($this->im, 1);  
  
  
  
        $NarrowRatio = 20;  
        $WideRatio = 55;  
        $QuietRatio = 35;  
  
  
        $nChars = (strlen($this->barcode)+2) * ((6 * $NarrowRatio) + (3 * $WideRatio) + ($QuietRatio));  
        $Pixels = $this->width / $nChars;  
        $NarrowBar = (int)(20 * $Pixels);  
        $WideBar = (int)(55 * $Pixels);  
        $QuietBar = (int)(35 * $Pixels);  
  
  
        $ActualWidth = (($NarrowBar * 6) + ($WideBar*3) + $QuietBar) * (strlen ($this->barcode)+2);  
          
        if (($NarrowBar == 0) || ($NarrowBar == $WideBar) || ($NarrowBar == $QuietBar) || ($WideBar == 0) || ($WideBar == $QuietBar) || ($QuietBar == 0))  
        {  
                ImageString ($this->im, 1, 0, 0, "Image is too small!", $Black);  
                
                  
        }else{  
          
        $CurrentBarX = (int)(($this->width - $ActualWidth) / 2);  
        $Color = $White;  
        $BarcodeFull = "*".strtoupper ($this->barcode)."*";  
        settype ($BarcodeFull, "string");  
          
        $FontNum = 3;  
        $FontHeight = ImageFontHeight ($FontNum);  
        $FontWidth = ImageFontWidth ($FontNum);  
        if ($this->text != 0)  
        {  
                $CenterLoc = (int)(($this->width-1) / 2) - (int)(($FontWidth * strlen($BarcodeFull)) / 2);  
                ImageString ($this->im, $FontNum, $CenterLoc, $this->bHeight-$FontHeight, "$BarcodeFull", $Black);  
        }  
		else  
		{  
			$FontHeight=-2;  
		}  
  
  
        for ($i=0; $i<strlen($BarcodeFull); $i++)  
        {  
                $StripeCode = $this->code39($BarcodeFull[$i]);  
  
  
                for ($n=0; $n < 9; $n++)  
                {  
                        if ($Color == $White) $Color = $Black;  
                        else $Color = $White;  
  
  
                        switch ($StripeCode[$n])  
                        {  
                                case '0':  
                                        ImageFilledRectangle ($this->im, $CurrentBarX, 0, $CurrentBarX+$NarrowBar, $this->bHeight-1-$FontHeight-2, $Color);  
                                        $CurrentBarX += $NarrowBar;  
                                        break;  
  
  
                                case '1':  
                                        ImageFilledRectangle ($this->im, $CurrentBarX, 0, $CurrentBarX+$WideBar, $this->bHeight-1-$FontHeight-2, $Color);  
                                        $CurrentBarX += $WideBar;  
                                        break;  
                        }  
                }  
  
  
                $Color = $White;  
                ImageFilledRectangle ($this->im, $CurrentBarX, 0, $CurrentBarX+$QuietBar, $this->bHeight-1-$FontHeight-2, $Color);  
                $CurrentBarX += $QuietBar;  
        }  
  
}//end if too small      
        $this->outputImage(); 

}
//-------------------------------------------------------------------------------------------------------------------------
function code39($Asc) {  

        switch ($Asc)  
        {  
                case ' ':  
                        return "011000100";       
                case '$':  
                        return "010101000";               
                case '%':  
                        return "000101010";   
                case '*':  
                        return "010010100"; // * Start/Stop  
                case '+':  
                        return "010001010";   
                case '|':  
                        return "010000101";   
                case '.':  
                        return "110000100";   
                case '/':  
                        return "010100010";   
				case '-':  
						return "010000101";  
                case '0':  
                        return "000110100";   
                case '1':  
                        return "100100001";   
                case '2':  
                        return "001100001";   
                case '3':  
                        return "101100000";   
                case '4':  
                        return "000110001";   
                case '5':  
                        return "100110000";   
                case '6':  
                        return "001110000";   
                case '7':  
                        return "000100101";   
                case '8':  
                        return "100100100";   
                case '9':  
                        return "001100100";   
                case 'A':  
                        return "100001001";   
                case 'B':  
                        return "001001001";   
                case 'C':  
                        return "101001000";  
                case 'D':  
                        return "000011001";  
                case 'E':  
                        return "100011000";  
                case 'F':  
                        return "001011000";  
                case 'G':  
                        return "000001101";  
                case 'H':  
                        return "100001100";  
                case 'I':  
                        return "001001100";  
                case 'J':  
                        return "000011100";  
                case 'K':  
                        return "100000011";  
                case 'L':  
                        return "001000011";  
                case 'M':  
                        return "101000010";  
                case 'N':  
                        return "000010011";  
                case 'O':  
                        return "100010010";  
                case 'P':  
                        return "001010010";  
                case 'Q':  
                        return "000000111";  
                case 'R':  
                        return "100000110";  
                case 'S':  
                        return "001000110";  
                case 'T':  
                        return "000010110";  
                case 'U':  
                        return "110000001";  
                case 'V':  
                        return "011000001";  
                case 'W':  
                        return "111000000";  
                case 'X':  
                        return "010010001";  
                case 'Y':  
                        return "110010000";  
                case 'Z':  
                        return "011010000";  
                default:  
                        return "011000100";   
        }  
}  

//-------------------------------------------------------------------------------------------------------------------------
function outputImage() {


 switch ($this->format)  {  
       case "JPEG":
       
                if($this->imageSave == null) {
                   $this->imageStream = 1;
                  }else{
                   $this->imageStream = 2;
                  }
                   
                break;  
       case "PNG":  
       
                if($this->imageSave == null) {
                   $this->imageStream = 1; 
                   }else{
                   $this->imageStream = 2;
                   }
                                
                break;  
       case "GIF":  
       
                if($this->imageSave == null) {
                   $this->imageStream = 1;  
                   }else{
                   $this->imageStream = 2;
                   } 
                                
                break;  
        }  


}
//-------------------------------------------------------------------------------------------------------
function parseImageSave() {

$this->imageSave = "$this->imagePath$this->imageName";

}
//-------------------------------------------------------------------------------------------------------
function getImageStream() {
       return($this->imageStream);
       }
function getFormat() {
       return($this->format);
       }
function getIm() {
       return($this->im);
       }   
function getQuality() {
       return($this->quality);
       }
function getImageSave() {
       return($this->imageSave);
       }
       
}
//==========================================================
//designates if call is coming from an src

$image_path = $_REQUEST['image_path'];
$stream_type = $_REQUEST['stream_type'];
$image_name = $_REQUEST['image_name'];
$ajax_switch = $_REQUEST['ajax_switch'];
/*$barcode = $_REQUEST['barcode'];
$width = $_REQUEST['width'];
$height = $_REQUEST['height'];
$quality = $_REQUEST['quality'];
$format = $_REQUEST['format'];
$stream_type = $_REQUEST['stream_type'];*/


if($stream_type == 1) {

if(isset($_GET["text"])) $text=$_GET["text"];  
if(isset($_GET["format"])) $format=$_GET["format"];  
if(isset($_GET["quality"])) $quality=$_GET["quality"];  
if(isset($_GET["width"])) $width=$_GET["width"];  
if(isset($_GET["height"])) $height=$_GET["height"];  
if(isset($_GET["type"])) $type=$_GET["type"];  
if(isset($_GET["barcode"])) $barcode=$_GET["barcode"];  
  
}

if (!isset ($text)) $text = 1;  
if (!isset ($type)) $type = 1;  
if (empty ($quality)) $quality = 100;  
if (empty ($width)) $width = 160;  
if (empty ($height)) $height = 80;  
if (!empty ($format)) $format = strtoupper ($format);  
        else $format="PNG";  
   

  
$parseBar = new barCode();
$parseBar-> setText($text); 
$parseBar-> setFormat($format);
$parseBar-> setQuality($quality);
$parseBar-> setWidth($width);
$parseBar-> setBHeight($height);
$parseBar-> setBarCode($barcode);
$parseBar-> setType($type);

if($stream_type == '2') {  
  $parseBar-> setImagePath($image_path);
  $parseBar-> setImageName($image_name);
  $parseBar-> parseImageSave();
}
  
$parseBar-> barcode39();
                                   
$format = $parseBar-> getFormat(); 
$im = $parseBar-> getIm();
$quality = $parseBar-> getQuality();
$image_stream = $parseBar-> getImageStream();
$image_save = $parseBar-> getImageSave();


switch ($format)  {        
        case "JPEG":   
        
              if($image_stream == 1) {
                 Imagejpeg($im, "", $quality); 
                 }elseif($image_stream == 2) {
                 Imagejpeg($im, "$image_save", $quality);
                 }
                                
                break;  
       case "PNG":  
       
              if($image_stream == 1) {
                 Imagepng($im); 
                 }elseif($image_stream == 2) {
                 Imagepng($im, "$image_save");
                 }
                 
                break;  
       case "GIF":  
       
              if($image_stream == 1) {
                 Imagegif($im); 
                 }elseif($image_stream == 2) {
                 Imagegif($im, "$image_save");
                 }                
                break;  
        }  
        
if($ajax_switch == 1) {
   echo"$ajax_switch";
   }
        
        
        
        
?>