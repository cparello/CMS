<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  scheduleApointment{

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleName = null;
private  $rowCount = null;
private  $headerType = null;



 
function setUserId($userId){
        $this->userId = $userId;
        }
function setDate($date){
        $this->date = $date;
        }
function  setTime($time){
        $this->time = $time;
        }
function  setName($name){
        $this->name = $name;
        }
function  setPhone($phone){
        $this->phone = $phone;
        }


//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function bookApointment() {

 $dbMain = $this->dbconnect();
 
 $note = "This was set from website.";
 
 $nameArr = explode(' ',$this->name);
 
 $sql = "INSERT INTO sales_appointments VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssss', $id, $this->userId, $nameArr[0] , $nameArr[1], $this->phone, $note, $this->time);
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 
 

}

//-----------------------------------------------------------------------------------------------------------
function getHoursList() {
         return($this->hourDrops);
         }
function getUserId() {
         return($this->userId);
         }         

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$userId = $_REQUEST['userId'];
$date = $_REQUEST['day'];
$time = $_REQUEST['time'];
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];

if($ajax_switch == "1") {
//echo "$day";
//exit;
$setAppt = new scheduleApointment();
$setAppt-> setUserId($userId);
$setAppt-> setDate($userId);
$setAppt-> setTime($time);
$setAppt-> setName($name);
$setAppt-> setPhone($phone);
$setAppt-> bookApointment();

   
echo"1";
exit;

}










?>