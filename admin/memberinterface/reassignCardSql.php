<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class reassignCardSql {

private $memberId = null;
private $contractKey = null;
private $idCard = null;
private $assignStatus = null;
private $newPhotoImage = null;
private $oldPhotoImage = null;
private $smContractKey = null;


function setContractKey($contractKey) {
        $this->contractKey = $contractKey;
        }
function setMemberId($memberId) {
        $this->memberId = $memberId;
        }
function setIdCard($idCard) {
        $this->idCard = $idCard;
        }        

        
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==================================================
function renamePhoto() {

$exten = '.jpg';
$this->newPhotoImage = "$this->idCard$exten";
$this->oldPhotoImage = "$this->memberId$exten";

rename("../memberphotos/$this->oldPhotoImage", "../memberphotos/$this->newPhotoImage");


}
//----------------------------------------------------------------------------------------
function updateScheduleMemberClassCount() {

$dbMain = $this->dbconnect();
$sql = "UPDATE schedular_member_class_count SET sm_member_id= ? WHERE sm_contract_key = '$this->smContractKey' AND sm_member_id='$this->memberId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberId);

$memberId = $this->idCard;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
 $stmt->close();

}
//----------------------------------------------------------------------------------------
function updateScheduleMemberServices() {

$dbMain = $this->dbconnect();
$sql = "UPDATE schedular_member_services SET sm_member_id= ? WHERE sm_contract_key = '$this->smContractKey' AND sm_member_id='$this->memberId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberId);

$memberId = $this->idCard;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
 $stmt->close();

}
//----------------------------------------------------------------------------------------
function updateClassBookings() {

$dbMain = $this->dbconnect();
$sql = "UPDATE class_bookings SET member_id= ? WHERE member_id='$this->memberId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberId);

$memberId = $this->idCard;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
 $stmt->close();

}
//----------------------------------------------------------------------------------------
function reassignIdCard() {

$this->renamePhoto();

$dbMain = $this->dbconnect();
$sql = "UPDATE member_info SET member_id= ?, member_photo= ? WHERE contract_key = '$this->contractKey' AND member_id='$this->memberId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('is', $memberId, $memberPhoto);

$memberId = $this->idCard;
$memberPhoto = $this->newPhotoImage;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
 $stmt->close();

//this checks on class services and updates the member id id they have exausted classes
  $stmt = $dbMain ->prepare("SELECT sm_contract_key FROM schedular_member_info WHERE sm_member_id='$this->memberId' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($smContractKey);
  $rowCount = $stmt->num_rows;
  $stmt->fetch();
  $stmt->close();
   

  if($rowCount > 0) {
  
      $this->smContractKey = $smContractKey;
  
      $sql = "UPDATE schedular_member_info SET sm_member_id= ? WHERE sm_contract_key = '$smContractKey' AND sm_member_id='$this->memberId' ";
      $stmt = $dbMain->prepare($sql);
      $stmt->bind_param('i', $memberId);

      $memberId = $this->idCard;

        if(!$stmt->execute())  {
           return($this->errorMessage);
           printf("Error: %s.\n", $stmt->error);
           exit;
          }
      $stmt->close();
      
      $this->updateScheduleMemberServices();
      $this->updateScheduleMemberClassCount();
      $this->updateClassBookings();
      
    }
    
    
    
$this->assignStatus = 1;

}
//==================================================
function getAssignStatus() {
       return($this->assignStatus);
       }


}
//--------------------------------------------------------------------------------------
$id_card = $_REQUEST['id_card'];
$member_id = $_REQUEST['member_id'];
$contract_key = $_REQUEST['contract_key'];


$reassign = new reassignCardSql();
$reassign-> setContractKey($contract_key);
$reassign-> setMemberId($member_id);
$reassign-> setIdCard($id_card);
$reassign-> reassignIdCard();
$assign_status = $reassign-> getAssignStatus();

echo"$assign_status";

?>





