<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  saveGuestPassEmail{

private  $markerId =1;
private  $fromAddress = null;
private  $replyAddress = null;
private  $fromName = null;
private  $introMessage = null;


function setMarkerId($markerId) {
          $this->markerId = $markerId;
          }
function setFromAddress($fromAddress) {
          $this->fromAddress = $fromAddress;
          }
function setReplyAddress($replyAddress) {
          $this->replyAddress = $replyAddress;
          }
function setFromName($fromName) {
          $this->fromName = $fromName;
          }
function setIntroMessage($introMessage) {
          $this->introMessage = $introMessage;
          }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=============================================
function insertGuestPassEmail() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO guest_pass_email VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issss', $markerId, $fromAddress, $replyAddress, $fromName, $introMessage);    

$markerId = $this->markerId;
$fromAddress = $this->fromAddress;
$replyAddress = $this->replyAddress;
$fromName = $this->fromName;
$introMessage = $this->introMessage;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


$stmt->close(); 

}
//-------------------------------------------------------------------------------
function updateGuestPassEmail() {

$dbMain = $this->dbconnect();
$sql = "UPDATE guest_pass_email SET from_address=?, reply_address=?, from_name=?, intro_message=?  WHERE marker_id= '$this->markerId'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssss' , $fromAddress, $replyAddress, $fromName, $introMessage);              
 
$fromAddress = $this->fromAddress;
$replyAddress = $this->replyAddress;
$fromName = $this->fromName;
$introMessage = $this->introMessage;
             
   if(!$stmt->execute())  {	                  
	   printf("Error: %s.\n", $stmt->error );
      }
                 
$stmt->close(); 

}
//-------------------------------------------------------------------------------
function parseGuestPassEmail() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM guest_pass_email WHERE  marker_id ='$this->markerId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($count);         
             $stmt->fetch(); 
             $stmt->close(); 

        if($count == 0) {
           $this->insertGuestPassEmail();
           }else{
           $this->updateGuestPassEmail();          
           }


}
//------------------------------------------------------------------------------
function loadGuestPassEmail() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT from_address, reply_address, from_name, intro_message FROM guest_pass_email WHERE  marker_id ='$this->markerId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($fromAddress, $replyAddress, $fromName, $introMessage);         
             $stmt->fetch(); 
             
             $this->fromAddress = $fromAddress;
             $this->replyAddress = $replyAddress;
             $this->fromName = $fromName;
             $this->introMessage = $introMessage;             
                          
             $stmt->close(); 

}
//------------------------------------------------------------------------------
function getFromAddress() {
       return($this->fromAddress);
       }
function getReplyAddress() {
       return($this->replyAddress);
       }       
function getFromName() {
       return($this->fromName);
       }
function getIntroMessage() {
       return($this->introMessage);
       }
//=====================================================



}
?>