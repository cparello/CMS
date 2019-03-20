<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  saveGuestPass{

private $clubId = null;
private $locationId = null;
private $guestPassTitle = null;
private $termOne = null;
private $termTwo = null;
private $termThree = null;
private $termFour = null;
private $guestPassDescription = null;
private $serviceKey = null;
private $guestPassId = null;
private $confirmationMessage = null;
private $clearSwitch = null;
private $guestPassTopic = null;

   
function setGuestPassId($guestPassId) {
$this->guestPassId = $guestPassId;
}   
   
function setClubId($clubId) {
$this->clubId = $clubId;
}

function setLocationId($locationId) {
$this->locationId = $locationId;
}

function setGuestPassTitle($guestPassTitle) {
$this->guestPassTitle = $guestPassTitle;
}

function setTermOne($termOne) {
$this->termOne= $termOne;
}

function setTermTwo($termTwo) {
$this->termTwo= $termTwo;
}

function setTermThree($termThree) {
$this->termThree= $termThree;
}

function setTermFour($termFour) {
$this->termFour= $termFour;
}

function setGuestPassTopic($guestPassTopic) {
$this->guestPassTopic = $guestPassTopic;
}

function setGuestPassDescription($guestPassDescription) {
$this->guestPassDescription = $guestPassDescription;
}

function setServiceKey($serviceKey) {
$this->serviceKey = $serviceKey;
}




//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//====================================================================
function updateGuestPassBasic() {

if($this->guestPassId != "") {

$dbMain = $this->dbconnect();
$sql = "UPDATE guest_pass SET location_id= ?, pass_title= ?, term_one= ?, term_two=?, term_three=?, term_four=?, pass_message=?, pass_date=?, pass_topic= ? WHERE  pass_id= ?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isiiiisssi', $locationId, $passTitle, $termOne, $termTwo, $termThree, $termFour, $passMessage, $passDate, $passTopic, $passId);

$locationId = $this->locationId;
$passTitle = $this->guestPassTitle;
$termOne = $this->termOne;
$termTwo = $this->termTwo;
$termThree = $this->termThree;
$termFour = $this->termFour;
$passMessage = $this->guestPassDescription;
$passDate = date("Y-m-d");
$passTopic = $this->guestPassTopic;
$passId = $this->guestPassId;

		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		

$stmt->close();
$this->confirmationMessage = "Guest Pass \"$this->guestPassTitle\" Successfully Updated";
}

}
//-----------------------------------------------------------------------------------------------------------------------
function clearGuestPassServices() {

$dbMain = $this->dbconnect();
$sql1 = "DELETE FROM guest_pass_services WHERE pass_id = ?";
		
		if ($stmt = $dbMain->prepare($sql1))   {
			$stmt->bind_param("i", $this->guestPassId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql1");
		   }
		   
$this->clearSwitch = 1;

}
//-----------------------------------------------------------------------------------------------------------------------
function updateServices() {

//this clears out all of the guest passes for this service in order to do a new insert
if($this->clearSwitch == null) {
   $this->clearGuestPassServices();
  }

   $this->saveServices();

}
//-----------------------------------------------------------------------------------------------------------------------
function deleteGuestPass() {

$dbMain = $this->dbconnect();

if($this->guestPassId != null) {

$sql1 = "DELETE FROM guest_pass WHERE pass_id = ?";
		
		if ($stmt = $dbMain->prepare($sql1))   {
			$stmt->bind_param("i", $this->guestPassId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql1");
		   }
		    
$sql2 = "DELETE FROM guest_pass_services WHERE pass_id = ?";
		
		if ($stmt = $dbMain->prepare($sql2))   {
			$stmt->bind_param("i", $this->guestPassId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql2");
		   }


$this->confirmationMessage = "Guest Pass \"$this->guestPassTitle\" Successfully Deleted";

}

}
//------------------------------------------------------------------------------------------------------------------------
function saveGuestPassBasic() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO guest_pass VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiiiisss', $guestPassId, $locationId, $passTitle, $termOne, $termTwo, $termThree, $termFour, $passMessage, $passDate, $passTopic);


$guestPassId = $this->guestPassId;
$locationId = $this->locationId;
$passTitle = $this->guestPassTitle;
$termOne = $this->termOne;
$termTwo = $this->termTwo;
$termThree = $this->termThree;
$termFour = $this->termFour;
$passMessage = $this->guestPassDescription;
$passDate = date("Y-m-d");
$passTopic = $this->guestPassTopic;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$this->guestPassId = $stmt->insert_id; 

$stmt->close(); 

}
//-----------------------------------------------------------------------------------------------------------------------
function saveServices() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO guest_pass_services VALUES (?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iii', $guestPassId, $clubId, $serviceKey);

$guestPassId = $this->guestPassId;
$clubId = $this->clubId;
$serviceKey = $this->serviceKey;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }	

$stmt->close(); 

}
//====================================================================
function getConfirmationMessage()  {
    return($this->confirmationMessage);
    }



}


      








     
?>