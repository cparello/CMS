<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}

//=======================================================

//==============================================end timeout
//date_default_timezone_set('America/Los_Angeles');
class  searchPosSales{

private  $contractId = null;
private  $memberFullName = null;
private  $memberFirstName = null;
private  $memberMiddleName = null;
private  $memberLastName = null;
private  $memberId = null; 
private  $sqlNameSearch = null;
private  $resultCount = null;
private  $groupName = null;
 

function setContractKey($contract_key) {
    $this->contractKey= $contract_key; 
    }
function setDate($date) {    
    $this->date = $date;
    }
function setCategory($category) {    
   $this->category = $category;
   }
function setMemberLastName($memberLastName) {    
   $this->memberLastName = $memberLastName;
   }
function setSqlNameSearch($sqlNameSearch) {
   $this->sqlNameSearch = $sqlNameSearch;
   }
function setResultCount($resultCount) {
   $this->resultCount = $resultCount;
   } 
function setGroupName($groupName) {
   $this->groupName = $groupName;
   }  
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
 



//=================================================== 
function  loadNoteCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(contract_key) AS marker_count  FROM account_notes_deleted WHERE  contract_key = '$this->contractKey'");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($marker_count);
$stmt->fetch();

//echo "fubar $marker_count";
//exit;

$this->resultCount = $marker_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "contract_key = '$this->contractKey'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function getResultCount() {
          return($this->resultCount);
          }
        

 }//end of class
 

$contract_key = $_REQUEST['contract_key'];
$sid = $_REQUEST['sid'];


$contract_key = urldecode($contract_key);
$contract_key = trim($contract_key);

 
 //echo "fu $contract_key bar ";
// exit;  
$searchMember = new searchPosSales();



if($contract_key != "") {
   $searchMember-> setContractKey($contract_key);
   $searchMember-> loadNoteCount();
  }




$result_count = $searchMember-> getResultCount();

//check to see if this is coming from an ajax call. if not do it sever side
if($sid != "")  {
   echo"$result_count";
   exit;
   }  
?>