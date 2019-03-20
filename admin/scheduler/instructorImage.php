<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
error_reporting(E_ALL);

class instructorImage {

private $imgDirectory = null;
private $imageDirectory = '../instructorphotos/';
private $minSize = '6000';
private $maxSize = '300000';
private $imageName = null;
private $imageFile = null;
private $imageFileSize = null;
private $imageFileType = null;
private $imageFileName = null;
private $fileExtension = null;
private $imageAttributes = null;
private $imageFileAspect = null;
private $maxWidth = '108';
private $thumbWidth = '108';
private $errorMessage = null;

function setImageName($imageName) {
       $this->imageName = $imageName;
       }

function setImageFile($imageFile) {
   
       $this->imageFileSize = $imageFile['imagefile']['size'];
       $this->imageFileType = $imageFile['imagefile']['type'];
       $this->imageFileName = $imageFile['imagefile']['name'];
       $this->imageAttributes = getimagesize($imageFile['imagefile']['tmp_name']);
       $this->tempImage = $imageFile['imagefile']['tmp_name'];
       }


//-----------------------------------------------------------------------------------------------------------------
function checkImageFiles()   {

//first check to see if the file size is too big or small
   if($this->imageFileSize < $this->minSize) {
      $this->errorMessage = "File SIze is to Small";
      return;
     }elseif($this->imageFileSize > $this->maxSize) {
      $this->errorMessage = "File SIze is to Large";
      return;
     }
     //echo "$this->imageFileSize > $this->maxSize";
     
// check to see if it is a valid image file    
if(!preg_match('/image/', $this->imageFileType)) {
      $this->errorMessage = 'This is not a valid image file';
      return;
    }  

//check to see if the file extension is correct
$fileExtensionArray = explode(".",$this->imageFileName);
$extension = $fileExtensionArray[1];
$extension = strtolower($extension);

if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))  {
  $this->errorMessage = 'This is not a valid file extension.<br>Please use .jpg, .jpeg, .png or .gif';
  return;
  }
  
  $this->fileExtension = $extension;

}
//----------------------------------------------------------------------------------------------------------------
function loadImage()   {


//first we check to se if file is a valid image
$this->checkImageFiles();
if($this->errorMessage != null)  {
   return($this->errorMessage);
   exit;
   }
   
list($width, $height, $type, $widthHeightTags) =  $this->imageAttributes;  

//this sets the width and height tags for the html
$this->imageFileAspec = $widthHeightTags;

switch ($type) {
    case 1:
        $imgCreate = imagecreatefromgif($this->tempImage);
        break;
     case 2:
        $imgCreate = imagecreatefromjpeg($this->tempImage);
        break;
     case 3:
        $imgCreate = imagecreatefrompng($this->tempImage);
        break;
   }

//calculate the aspect ratio to use when resizing
$aspectRatio = (float) $height / $width;

//calulate the thumbnail width based on the height
$thumbHeight = round($this->thumbWidth  * $aspectRatio);
/*
while($thumbHeight > $this->maxWidth)  {
        $this->thumbWidth -= 10;
        $thumbHeight = round($this->maxWidth * $aspect_Ratio);
        }
*/   
    $newImg = imagecreatetruecolor($this->thumbWidth, $thumbHeight);


//Check if this image is PNG or GIF, then set if Transparent
    if(($type == 1) OR ($type == 3))   {
        imagealphablending($newImg, false);
        imagesavealpha($newImg,true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $this->thumbWidth, $thumbHeight, $transparent);
    }


//resample the image    
    imagecopyresampled($newImg, $imgCreate, 0, 0, 0, 0, $this->thumbWidth, $thumbHeight, $width, $height);

//Generate the file, and rename it to new file name and directory
$this->newFileName = "$this->imageName$this->fileExtension";
    switch ($type)  {
        case 1:
        imagegif($newImg, $this->imageDirectory .  $this->newFileName);
        break;
        case 2:
        imagejpeg($newImg, $this->imageDirectory .  $this->newFileName, 100);  
        break;
        case 3: 
        imagepng($newImg, $this->imageDirectory .  $this->newFileName, 0); 
        break;
        default:  trigger_error('Failed resize image!', E_USER_WARNING);  
        break;
    }

}
//----------------------------------------------------------------------------------------------------------------
function getImageFileName() {
       return($this->newFileName);
      }

function getImageFilePath() {
      return($this->imageDirectory);
      }

function getImageFileAspect() {
      return($this->imageFileAspect);
      }

function getConfirmation()  {
      return($this->confirmationMessage);
     }

function getErrorMessage() {
      return($this->errorMessage);
      }

function getFileExtension() {
      return($this->fileExtension);
      }


}




















?>