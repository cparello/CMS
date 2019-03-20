<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  updateMemberSql {

private $contractKey = null;
private $generalKey = null;
private $memberId = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $cityName = null;
private $stateValue = null;
private $zipCode = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $dob = null;
private $licenseNumber = null;
private $emgContact = null;
private $emgRelation = null;
private $emgPhone = null;
private $memberPhoto = null;


function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setGeneralKey($generalKey) {
              $this->generalKey = $generalKey;
              }
              
function setMemberId($memberId) {
              $this->memberId = $memberId;
              }              
              
function setFirstName($firstName) {
              $this->firstName = $firstName;
              }
              
function setMiddleName($middleName) {
              $this->middleName = $middleName;
              }
              
function setLastName($lastName) {
              $this->lastName = $lastName;
              }

function setStreetAddress($streetAddress) {
              $this->streetAddress = $streetAddress;
              }
              
function setCityName($cityName) {
              $this->cityName = $cityName;
              }

function setStateValue($stateValue) {
              $this->stateValue = $stateValue;
              }
  
function setZipCode($zipCode) {
              $this->zipCode = $zipCode;
              }
              
function setPrimaryPhone($primaryPhone) {
              $this->primaryPhone = $primaryPhone;
              }
 
function setCellPhone($cellPhone) {
              $this->cellPhone = $cellPhone;
              } 
              
function setEmailAddress($emailAddress) {
              $this->emailAddress = $emailAddress;
              }
              
function setDob($dob) {
              $this->dob = $dob;
              }              
       
function setLicenseNumber($licenseNumber) {
              $this->licenseNumber = $licenseNumber;
              }
       
function setEmgContact($emgContact) {
              $this->emgContact = $emgContact;
              }
              
function setEmgRelation($emgRelation) {
              $this->emgRelation = $emgRelation;
              }
              
function setEmgPhone($emgPhone) {
              $this->emgPhone = $emgPhone;
              }
              
function setMemberPhoto($memberPhoto) {
              $this->memberPhoto = $memberPhoto;
              }



//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//===================================================================
function updateMemberFields() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_info SET member_id= ?, first_name= ?, middle_name= ?, last_name= ?, street= ?, city= ?, state=?, zip= ?, primary_phone= ?, cell_phone= ?, email= ?, dob= ?, license_number= ?, emg_contact= ?, emg_relationship= ?, emg_phone_phone= ?, member_photo=? WHERE contract_key = '$this->contractKey' AND general_id = '$this->generalKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issssssisssssssss', $memberId, $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primaryPhone, $cellPhone, $email, $dob, $licenseNumber, $emgContact, $emgRelation, $emgPhone, $memberPhoto);


$memberId = $this->memberId; 
$firstName = $this->firstName; 
$middleName = $this->middleName; 
$lastName = $this->lastName; 
$street = $this->streetAddress; 
$city = $this->cityName; 
$state = $this->stateValue; 
$zip = $this->zipCode; 
$primaryPhone = $this->primaryPhone; 
$cellPhone = $this->cellPhone; 
$email = $this->emailAddress; 
$dob = $this->dob; 
$licenseNumber = $this->licenseNumber; 
$emgContact = $this->emgContact; 
$emgRelation = $this->emgRelation; 
$emgPhone = $this->emgPhone;


if($this->memberId != '0') {
   $ext = '.jpg';
   $memberPhoto = "$this->memberId$ext";
   }else{
   $memberPhoto = "no_photo.jpg";
   }


 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }else{
   $success = 1;
   return $success;
   }

$stmt->close(); 


}
//===================================================================


}













?>