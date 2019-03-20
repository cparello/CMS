<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  salesScheduleSql{

private $merchantId = null;
private $accountMode = null;
private $csUserName = null;
private $csPassword = null;
private $settleMode = null;


function setShiftStart1($shiftStart1) {
        $this->shiftStart1 = $shiftStart1;
         }
function setShiftEnd1($shiftEnd1) {
        $this->shiftEnd1 = $shiftEnd1;
         }               
function setShiftStart2($shiftStart2) {
        $this->shiftStart2 = $shiftStart2;
         }
function setShiftEnd2($shiftEnd2) {
        $this->shiftEnd2 = $shiftEnd2;
         }

         
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateSalesScheduleHours()     {

//create a confirmation message for errors
$this->confirmationMessage = "There was an error updating the Sales Schedule Hours";
//echo"$this->shiftStart1,$this->shiftEnd1,$this->shiftStart2,$this->shiftEnd2";
$dbMain = $this->dbconnect();
$sql = "UPDATE sales_schedule_setup SET start1= ?, end1= ?, start2= ?, end2= ? WHERE setup_key = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('iiii', $this->shiftStart1,$this->shiftEnd1,$this->shiftStart2,$this->shiftEnd2);						

if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = "Sales Schedule Hours Successfully Updated";
   return($this->confirmationMessage);
   }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadSalesScheduleHours() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error the Sales Schedule Hours";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT start1, end1, start2, end2 FROM sales_schedule_setup WHERE setup_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->shiftStart1,$this->shiftEnd1,$this->shiftStart2,$this->shiftEnd2); 
   $stmt->fetch();
//echo "fubar";
if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();




}
//==================================================================================================
function getStart1() {
    return($this->shiftStart1);
   }
function getEnd1() {
    return($this->shiftEnd1);
   }
function getStart2() {
    return($this->shiftStart2);
   }
function getEnd2() {
    return($this->shiftEnd2);
   }






}
?>