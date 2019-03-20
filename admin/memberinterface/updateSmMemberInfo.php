<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class updateSmMemberInfo {

private $contractKey = null;
private $memberId = null;
private $firstName = null;
private $lastName = null;
private $email = null;
private $phone = null;
private $updateBit = null;


function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
       
function setMemberId($memberId) {
       $this->memberId = $memberId;
       }

function setFirstName($firstName) {
       $this->firstName = $firstName;
       }

function setLastName($lastName) {
       $this->lastName = $lastName;
       }

function setEmail($email) {
       $this->email = $email;
       }

function setPhone($phone) {
       $this->phone = $phone;
       }


 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------
function updateSchedulerInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE schedular_member_info SET sm_member_id= ?, sm_fname= ?, sm_lname= ?, sm_phone= ?, sm_email= ? WHERE sm_contract_key = '$this->contractKey' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issss', $memberId, $firstName, $lastName, $phone, $email);

$memberId = $this->memberId;
$firstName = $this->firstName;
$lastName = $this->lastName;
$phone = $this->phone;
$email = $this->email;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }else{
   $this->updateBit = 1;
   }      
 $stmt->close();
 
 
$sql = "UPDATE schedular_member_services SET sm_member_id= ? WHERE sm_contract_key = '$this->contractKey' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberId);

$memberId = $this->memberId;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }else{
   $this->updateBit = 1;
   }      
 $stmt->close();
 
 
$sql = "UPDATE schedular_member_class_count SET sm_member_id= ? WHERE sm_contract_key = '$this->contractKey' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberId);

$memberId = $this->memberId;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }else{
   $this->updateBit = 1;
   }      
 $stmt->close(); 
 
 
}
//-------------------------------------------------------------------------------
function getUpdateBit() {
      return($this->updateBit);
      }




}
//==============================================
if($ajax_switch == 1) {

$update = new updateSmMemberInfo();
$update-> setContractKey($contract_key);
$update-> setMemberId($member_id);
$update-> setFirstName($first_name);
$update-> setLastName($last_name);
$update-> setEmail($email_address);
$update-> setPhone($phone_number);
$update-> updateSchedulerInfo();
$update_bit = $update-> getUpdateBit();

echo"$update_bit";
exit;


}








?>