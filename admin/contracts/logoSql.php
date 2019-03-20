<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  logoSql{

private $imagePath;
private $imageName;
private $imageAspect;

function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
         }

function setImageName($imageName)  {
		$this->imageName = $imageName;
		  }

function setImageAspect($imageAspect)  {
		$this->imageAspect = $imageAspect;
		  }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateLogo()     {

//create a confirmation message for errors
$this->errorMessage = "There was an error updating this Image";
$this->confirmationMessage = "Image successfully Uploaded";

$dbMain = $this->dbconnect();


$sql = "UPDATE contract_defaults SET image_name= ?, image_path=?, image_aspect=? WHERE contract_key = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('sss',$imageName, $imagePath, $imageAspect);						

$imageName = $this->imageName;
$imagePath = $this->imagePath;
$imageAspect = $this->imageAspect;

if(!$stmt->execute())  {
    return($this->errorMessage);
	exit;
   }else{
   return($this->confirmationMessage);   
   }
   
  }
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadLogo() {

//create a confirmation message for errors
$this->errorMessage = "There was an error retrieving this Image";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect FROM contract_defaults WHERE contract_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($imageName, $imagePath, $imageAspect); 
   $stmt->fetch();

$this->imageName = $imageName; 
$this->imagePath = $imagePath;
$this->imageAspect = $imageAspect;

if(!$stmt->execute())  {
    return($this->errorMessage);
	printf("Error: %s.\n", $stmt->error);
   }

}

//==================================================================================================
function getImageName() {
 return($this->imageName);
}

function getImagePath() {
 return($this->imagePath);
}

function getImageAspect() {
 return($this->imageAspect);
}

function getConfirmation() {
 return($this->confirmationMessage);
}





}
?>