<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  employeeTypeSql{

private $typeKey = null;
private $employeeType;
private $employeeDescription;
private $locationId;


function setTypeKey($typeKey)  {
		$this->typeKey = $typeKey;
		  }

function setEmployeeType($employeeType)  {
		$this->employeeType = $employeeType;
		  }

function setEmployeeDescription($employeeDescription)  {
		$this->employeeDescription = $employeeDescription;
		  }

function setLocationId($locationId)  {
		$this->locationId = $locationId;
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

if($this->locationId =="0") {
$club_name = "All Locations";
}

             
 return "$club_name";

 $stmt->close(); 
}


//=======================================================================================
//this saves the new user into the database
function saveEmployeeType()  {

$dbMain = $this->dbconnect();
//insert record into the password table
$sql = "INSERT INTO employee_type VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $typeKey, $employeeType, $employeeDescription, $locationId); 


$typeKey = $this->typeKey; 
$employeeType = $this->employeeType;
$employeeDescription = $this->employeeDescription; 
$locationId = $this->locationId; 

/* execute prepared statement */
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

   
 $stmt->close();  
 
 $this->confirmation_message = "$employeeType  Successfully Added";
 return($this->confirmation_message);
}

//=================================================================================================
function deleteEmployeeType()   {

$dbMain = $this->dbconnect();
$locationId = $this->locationId; 
$typeKey = $this->typeKey; 
$employeeType = $this->employeeType;

		
$sql = "DELETE FROM employee_type  WHERE type_key = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $typeKey);
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

$locationName = $this->parseName();

 $this->confirmation_message = "$employeeType from  $locationName Successfully Deleted";
 return($this->confirmation_message);

}

//==================================================================================================
function updateEmployeeType()     {

$dbMain = $this->dbconnect();

$sql = "UPDATE employee_type SET employee_type= ?, employee_description=?, club_id=?  WHERE type_key = ?";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('sssi', $employeeType, $employeeDescription, $locationId, $typeKey);						

$typeKey = $this->typeKey; 
$employeeType = $this->employeeType;
$employeeDescription = $this->employeeDescription; 
$locationId = $this->locationId; 

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


 $stmt->close();  
 
 $locationName = $this->parseName();
 
 $this->confirmation_message = "$employeeType From  $locationName Successfully Updated";
 return($this->confirmation_message);

}

//==================================================================================================


}
?>