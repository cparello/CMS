<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  pinsSql{

private $overidePinOne;


function setOveridePinOne($overidePinOne) {
        $this->overidePinOne = $overidePinOne;
         }
         

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updatePins()     {

//create a confirmation message for errors
$this->confirmation_message = "There was an error updating this PIN number";

$dbMain = $this->dbconnect();


$sql = "UPDATE pins SET overide_pin_one= ? WHERE pin_key = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('i', $overidePinOne);						

$overidePinOne = $this->overidePinOne; 


if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmation_message = "Overide PIN  Successfully Updated";
   return($this->confirmation_message);
   }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadPins() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving this PIN";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT * FROM pins WHERE pin_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($feeKey, $overidePinOne); 
   $stmt->fetch();

$this->overidePinOne = $overidePinOne; 

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }

}

//==================================================================================================
function getOveridePinOne() {
 return($this->overidePinOne);
}








}
?>