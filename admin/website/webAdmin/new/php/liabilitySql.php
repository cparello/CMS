<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//date_default_timezone_set('America/Los_Angeles');


class  liabilitySql{

private $logoImage = null;
private $imageName = null;
private $imagePath = null;
private $imageAspect = null;
private $waiverTypeHeader = "Release and Waiver of Liability";
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $liabilityTerms = null;
private $contractLocation = null;
private $businessName = null;
private $businessAddress = null;


function setBusinessName($businessName) {
          $this->businessName = $businessName;
          }
function setBusinessAddress($businessAddress) {
          $this->businessAddress = $businessAddress;
          }


//------------------------------------------------------------------
//connect to database
function dbconnect()   {
require"../../../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------
function loadContractLocation()  {
/*for now this is set manually. the final version will look for the assigned IP address of the browser and use a sql table to designate the club id and the location name etc*/

$this->locationId = '6883';
$todaysDate = date("F j, Y");
$this->contractLocation = "<p>Executed at $this->businessName $this->businessAddress on $todaysDate</p>";

}

//--------------------------------------------------------------------
function formatLogoImage() {

$this->logoImage = "<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"$this->imagePath$this->imageName\" $this->imageAspect /></a>";

}
//======================================
function loadLiabilityDefaults() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT image_name, image_path, image_aspect, liability_terms FROM contract_defaults WHERE contract_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($image_name, $image_path, $image_aspect, $liability_terms);   
$stmt->fetch();   

$this->imageName = $image_name;
$this->imagePath = $image_path;
$this->imageAspect = $image_aspect;
$this->liabilityTerms = $liability_terms;

$stmt->close();

$this->formatLogoImage();

}
//======================================
function parseContactInfo($contactInfo) {

 $contactInfo = explode("|", $contactInfo);

$this->firstName = $contactInfo[0];
$this->middleName = $contactInfo[1];
$this->lastName = $contactInfo[2];
$this->streetAddress = "$contactInfo[3] $contactInfo[4], $contactInfo[5] $contactInfo[6]";
$this->primaryPhone = $contactInfo[7];
$this->cellPhone = $contactInfo[8];
$this->emailAddress = $contactInfo[9];

}
//=======================================

function getLogoImage() {
        return($this->logoImage);
        }
function getWaiverTypeHeader() {
        return($this->waiverTypeHeader);
        }
function getFirstName() {
       return($this->firstName);
       }
function getMiddleName() {
       return($this->middleName);
       }          
function getLastName() {
       return($this->lastName);
       }          
function getStreetAddress() {
       return($this->streetAddress);
       }   
function getPrimaryPhone() {
       return($this->primaryPhone);
       }          
function getCellPhone() {
       return($this->cellPhone);
       }          
function getEmailAddress() {
       return($this->emailAddress);
       }          
function getLiabilityTerms() {
       return($this->liabilityTerms);
       }
function getContractLocation() {
       return($this->contractLocation);
       }



}
?>