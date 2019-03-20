<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  locationSql{

private $locationId = null;
private $locationName;
private $locationAddress;
private $locationPhone;
private $locationContact;



function setLocationId($locationId) {
        $this->locationId = $locationId;
         }

function setLocationName($locationName)  {
		$this->locationName = $locationName;
		  }

function setLocationAddress($locationAddress)  {
		$this->locationAddress = $locationAddress;
		  }

function setLocationPhone($locationPhone)  {
		$this->locationPhone = $locationPhone;
		  }
		  
function setLocationContact($locationContact)  {
		$this->locationContact = $locationContact;
		  }		  
function setState($state)  {
		$this->state = $state;
		  }	
  

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//get the name of the location if deleting
function parseName()  {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->locationId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name);   
 $stmt->fetch();             
             
 return "$club_name";

 $stmt->close(); 
}


//=======================================================================================
//this saves the new user into the database
function saveLocation()  {

$dbMain = $this->dbconnect();
//insert record into the password table
$sql = "INSERT INTO club_info VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssss', $locationId, $locationName, $locationAddress, $locationPhone, $locationContact, $this->state); 

$locationId = $this->locationId; 
$locationName = $this->locationName; 
$locationAddress = $this->locationAddress;
$locationPhone = $this->locationPhone; 
$locationContact = $this->locationContact; 

/* execute prepared statement */
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

   
 $stmt->close();  
 
 $this->confirmation_message = "$locationName  Successfully Added";
 return($this->confirmation_message);
}

//=================================================================================================
function deleteLocation()   {

$dbMain = $this->dbconnect();
$locationId = $this->locationId; 
$locationName = $this->locationName; 
		
$sql = "DELETE FROM club_info WHERE club_id = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("s", $locationId);
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}



 $this->confirmation_message = "$locationName  Successfully Deleted";
 return($this->confirmation_message);

}

//==================================================================================================
function updateLocation()     {

$dbMain = $this->dbconnect();

$sql = "UPDATE club_info SET club_name= ?, club_address=?, club_phone=?, club_contact=?, state=? WHERE club_id= ?";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('ssssss',$locationName, $locationAddress, $locationPhone, $locationContact, $this->state, $locationId);						

$locationId = $this->locationId; 
$locationName = $this->locationName; 
$locationAddress = $this->locationAddress;
$locationPhone = $this->locationPhone; 
$locationContact = $this->locationContact; 
//echo "$locationName, $locationAddress, $locationPhone, $locationContact, $locationId, $this->state";
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

 $stmt->close();  
 
 $this->confirmation_message = "$locationName  Successfully Updated";
 return($this->confirmation_message);

}

//==================================================================================================
function loadLocation() {

$dbMain = $this->dbconnect();


	    $stmt = $dbMain->prepare( "SELECT * FROM club_info WHERE club_id = ?");
		$stmt->bind_param('s', $this->locationId);
		
        $stmt->bind_result($locationId, $locationName, $locationAddress, $locationPhone, $locationContact, $this->state);

        $stmt->execute() or die ("Could not execute statement");
		$stmt->store_result();
		
	//check the number of rows 
		if( $stmt->num_rows == 0) {
			printf("ERROR: Report does not Exisit \n");	
		   }else{
			$stmt->fetch();	
			$this->locationId = $locationId;
            $this->locationName = $locationName;
            $this->locationAddress = $locationAddress;
            $this->locationPhone = $locationPhone;
            $this->locationContact = $locationContact; 
            }
            
        $stmt->close();        
}

//=================================================================================================
//set our get objects to load the form

function getLocationId() {
       return($this->locationId);
        }

function getLocationName()  {
        return($this->locationName);
        }

function getLocationAddress() {
       return($this->locationAddress);
       }

function getLocationPhone() {
       return($this->locationPhone);
       }

function getLocationContact() {
       return($this->locationContact);
       }
function getState() {
       return($this->state);
       }



}
?>