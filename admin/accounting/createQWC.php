<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class createQWC {

 private $appName = 'ClubManagerPro QuickBooks Web Connector';
 private $appID = 'CMPQBWC';
 private $appURL = null;
 private $appDescrip = 'ClubManagerPro Payroll Processor';
 private $appSupportURL = null;
 private $qbUserName = null;
 private $qbPassword = null;
 private $ownerID = null;
 private $fileID = null;
 private $qWCFile = null;
 private $rightBrak = '}';
 private $leftBrak = '{';
 private $sucessBit = null;
 private $qbStatus = null;


 function setQbUserName($qbUserName) {
         $this->qbUserName = $qbUserName;
       }
       
 function setQbPassword($qbPassword) {
         $this->qbPassword = $qbPassword;
       }       
       
       
 function setQbStatus($qbStatus) {
         $this->qbStatus = $qbStatus;
       }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}           
//-------------------------------------------------------------------------------------------- 
function insertUserPass() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO qb_user VALUES (?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iss', $qb_id, $qb_name, $qb_pass);

$qb_id = "";
$qb_name = $this->qbUserName;
$qb_pass = $this->qbPassword;

 if(!$stmt->execute())  {
    printf("Error: insert %s.\n", $stmt->error);
   }		

 $stmt->close();  


}
//--------------------------------------------------------------------------------------------
function updateUserPass() {

$dbMain = $this->dbconnect();
$sql = "UPDATE qb_user SET qb_name= ?, qb_password=? WHERE qb_id ='1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $qb_name, $qb_pass);

$qb_name = $this->qbUserName;
$qb_pass = $this->qbPassword;

if(!$stmt->execute())  {
	printf("Error: update %s.\n", $stmt->error);
   }		

 $stmt->close();  

}
//--------------------------------------------------------------------------------------------
function  createUserPass() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT qb_name FROM qb_user WHERE qb_id = '1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($qb_name);
$stmt->fetch();

if($qb_name == "") {
  $this->insertUserPass();
  }else{
  $this->updateUserPass();  
  }

$stmt->close();

}
//--------------------------------------------------------------------------------------------
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
//------------------------------------------------------------------------------------------    
function loadAppURLS() {
    
      $domain = $_SERVER['HTTP_HOST'];  
      $this->appURL = "https://$domain/admin/accounting/qb_payroll_server_newway.php";
      $this->appSupportURL = "https://$domain/admin/accounting/quickbooks/errorlog.txt";
    
}
//-----------------------------------------------------------------------------------------        
function loadOwnerID(){
        // grab from user {57F3B9B1-86F1-4fcc-B1EE-566DE1813D20}
        $this->ownerID = $this->gen_uuid();
}
//------------------------------------------------------------------------------------------    
function loadFileID(){
        // grab from user {90A44FB5-33D9-4815-AC85-BC87A7E7D1EB}
        $this->fileID = $this->gen_uuid();
 }
//------------------------------------------------------------------------------------------    
function createConnectorFile(){
    $ourFileName = "../qwc/cmpqwcfile.qwc";
    $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

$this->qWCFile ="<?xml version=\"1.0\"?>        
<QBWCXML>
<AppName>$this->appName</AppName>
<AppID>$this->appID</AppID>
<AppURL>$this->appURL</AppURL>
<AppDescription>$this->appDescrip</AppDescription>
<AppSupport>$this->appSupportURL</AppSupport>
<UserName>$this->qbUserName</UserName>
<OwnerID>$this->leftBrak$this->ownerID$this->rightBrak</OwnerID>
<FileID>$this->leftBrak$this->fileID$this->rightBrak</FileID>
<QBType>QBFS</QBType>
<Scheduler>
<RunEveryNMinutes>60</RunEveryNMinutes>
</Scheduler>
</QBWCXML>";
                            
   fwrite($ourFileHandle, $this->qWCFile);                
        
   fclose($ourFileHandle);
        
 $this->successBit = 1;
 
}
//--------------------------------------------------------------------------------------------
function updateQbStatus() {

$dbMain = $this->dbconnect();
$sql = "UPDATE qb_status SET status_bit= ? WHERE status_id ='1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $status_bit);

$status_bit = $this->qbStatus;

if(!$stmt->execute())  {
	printf("Error: update %s.\n", $stmt->error);
   }		

 $stmt->close();  




}
//--------------------------------------------------------------------------------------------
function presetQBWageStatus() {

$dbMain = $this->dbconnect();
       $wage_added_qb = 'N';
       $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '1'";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('s', $wage_added_qb);
       $stmt->execute();        
       $stmt->close();
                             
       $wage_added_qb = 'N';
       $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '2'";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('s', $wage_added_qb);
       $stmt->execute();        
       $stmt->close();
                             
       $wage_added_qb = 'N';
       $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '3'";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('s', $wage_added_qb);
       $stmt->execute();        
       $stmt->close();
       
       $wage_added_qb = 'N';
       $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '4'";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('s', $wage_added_qb);
       $stmt->execute();        
       $stmt->close();
       
       $wage_added_qb = 'N';
       $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '5'";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('s', $wage_added_qb);
       $stmt->execute();        
       $stmt->close();
}                   
//--------------------------------------------------------------------------------------------
function createQwcFile(){
    
    $this->createUserPass();
    $this->loadAppURLS();
    $this->loadFileID();
    $this->loadOwnerID();
    $this->createConnectorFile();
    $this->updateQbStatus();
}
//--------------------------------------------------------------------------------------------
function getSuccessBit() {
      return($this->successBit);
      }
//--------------------------------------------------------------------------------------------

}
//==============================================================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$qb_user_name = $_REQUEST['qb_user_name'];
$qb_status = $_REQUEST['qb_status'];
$qb_password = $_REQUEST['qb_password'];

if($ajax_switch == 1) {
  $loadData = new createQWC();
  $loadData-> setQbUserName($qb_user_name);
  $loadData-> setQbPassword($qb_password);
  $loadData-> setQbStatus($qb_status);
  $loadData-> createQwcFile();
  $loadData-> presetQBWageStatus();
  $successBit = $loadData-> getSuccessBit();
  echo"$successBit";
  exit;
  }

?>