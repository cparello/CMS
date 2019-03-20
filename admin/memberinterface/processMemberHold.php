<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class processMemberHold {

private $contractKey = null;
private $memberId = null;
private $generalId = null;
private $memberName = null;
private $holdTotal = null;
private $chType = null;


function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }
              
function setMemberId($memberId) {
              $this->memberId = $memberId;
              }
              
function setGeneralId($generalId) {
              $this->generalId = $generalId;
              } 
              
function setMemberName($memberName) {
              $this->memberName = $memberName;
              }      
              
function setHoldTotal($holdTotal) {
             $this->holdTotal = $holdTotal;
             }             
             
function setChType($chType) {
             $this->chType = $chType;
             }             


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}            
//=====================================================================              
function holdMember() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO member_hold VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiis', $contract_key, $general_id, $member_id, $hold_date);

if($this->memberId == 'Unassigned') {
   $this->memberId = 0;
   }
   
$contract_key = $this->contractKey;
$general_id = $this->generalId;
$member_id = $this->memberId;
$hold_date = date("Y-m-d H:m:s");

if(!$stmt->execute())  {
	printf("Error: %s.\n  member_hold function holdMember  insert", $stmt->error);
   }	
   
$stmt->close(); 

$_SESSION['confirmation_message'] = "$this->memberName With Account Number $this->contractKey Successfully Placed On Hold";


$success = 1;
return $success;
}
//---------------------------------------------------------------------------------------------------------------------
function loadCancelHoldHistory() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO cancel_hold_history VALUES (?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidddss', $chId, $contractKey, $refundTotal, $cancelTotal, $holdTotal, $chType, $chDate);

$chId = "";
$contractKey = $this->contractKey;
$refundTotal = $this->refundTotal;

if($this->chType == 'CM') {
  $cancelTotal = $this->cancelCost;
  }elseif($this->chType == 'CA') {
  $cancelTotal = $this->cancelTotal;
  }else{
  $cancelTotal = null;
  }

$holdTotal = $this->holdTotal;
$chType = $this->chType;
$chDate = date("Y-m-d H:i:s");


if(!$stmt->execute())  {
	printf("Error: %s.\n function loadCancelHoldHistory table cancel_hold_history", $stmt->error);
   }		
$stmt->close(); 


}
//---------------------------------------------------------------------------------------------------------------------
                   
//=====================================================================              
}              
$contract_key = $_REQUEST['contract_key'];
$mem_member_key = $_REQUEST['mem_member_key'];
$mem_member_id = $_REQUEST['mem_member_id'];
$mem_member_name = $_REQUEST['mem_member_name'];
$hold_message = $_REQUEST['hold_message'];
                
                
$user_id = 0;
$topic = 'Member On Hold';
//decode the info from the ajax post
$hold_message = urldecode($hold_message);
$hold_message = trim($hold_message);
$priority = 'H';
$target_app = 'MI';
$from_app = 'MI';

include "../utilities/noteSql.php";
$saveNote = new noteSql();
$saveNote-> setNoteTopic($topic);
$saveNote-> setContractKey($contract_key);
$saveNote-> setNoteMessage($hold_message);
$saveNote-> setNoteUser($user_id);
$saveNote-> setMemberId($mem_member_key);
$saveNote-> setNotePriority($priority);
$saveNote-> setTargetAppId($target_app);
$saveNote-> setNoteCategory($from_app);    
$save_result = $saveNote-> saveNote();


if($save_result == 1) {

$placeHold = new processMemberHold();
$placeHold-> setContractKey($contract_key);
$placeHold-> setMemberId($mem_member_id);
$placeHold-> setGeneralId($mem_member_key);
$placeHold-> setMemberName($mem_member_name);
$success = $placeHold-> holdMember();

   //load into cancel hold history
   $ch_type = 'MH';
   $hold_balance = '0.00';
   $placeHold-> setHoldTotal($hold_balance);
   $placeHold-> setChType($ch_type);
   $placeHold-> loadCancelHoldHistory();

echo"$success";
exit;

}













