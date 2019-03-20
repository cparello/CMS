<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}

//=======================================================

//==============================================end timeout
//date_default_timezone_set('America/Los_Angeles');
class  searchMemberAccounts{

private  $contractId = null;
private  $memberFullName = null;
private  $memberFirstName = null;
private  $memberMiddleName = null;
private  $memberLastName = null;
private  $memberId = null; 
private  $sqlNameSearch = null;
private  $resultCount = null;
private  $groupName = null;
 
function setContractId($contractId) {
    $this->contractId = $contractId;
    }
function setMemberFullName($memberFullName) {
    $this->memberFullName= $memberFullName; 
    }
function setMemberFirstName($memberFirstName) {    
    $this->memberFirstName = $memberFirstName;
    }
function setMemberMiddleName($memberMiddleName) {    
   $this->memberMiddleName = $memberMiddleName;
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
function setCCNum($cc_num){
    $this->ccNum = $cc_num;
}   
function setBank($bank){
    $this->bank = $bank;
}   
function setMemberName2($member_name2){
    $this->memberName2 = $member_name2;
}      
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
 

//====================================================
function parseMemberFullName()  {

$memberNameArray = preg_split('/\s+/', $this->memberFullName);   
$memberCount= count($memberNameArray);  

switch ($memberCount) {
         case 0:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '%$this->memberLastName%'";
        break;
        case 1:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '%$this->memberLastName%'";
        break;
        case 2:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = "";
              $this->memberLastName = $memberNameArray[1];
              $this->sqlNameSearch = "first_name LIKE '%$this->memberFirstName%' AND last_name LIKE '%$this->memberLastName%'";
        break;
        case 3:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = $memberNameArray[1];
              $this->memberLastName = $memberNameArray[2];
              $this->sqlNameSearch = "first_name LIKE '%$this->memberFirstName%' AND middle_name LIKE '%$this->memberMiddleName%' AND last_name LIKE '%$this->memberLastName%'";
        break;
        case 4:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = $memberNameArray[1];
              $this->memberLastName = "$memberNameArray[2] $memberNameArray[3]";
              $this->sqlNameSearch = "first_name LIKE '%$this->memberFirstName%' AND middle_name LIKE '%$this->memberMiddleName%' AND last_name LIKE '%$this->memberLastName%'";
        break;
    default:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '%$this->memberLastName%'";
     }
}
//===================================================
function loadIdCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(DISTINCT contract_key) AS contract_count  FROM contract_info WHERE contract_key = '$this->contractId'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "contract_key = '$this->contractId'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

 }
//=================================================== 
function  loadNameCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(DISTINCT contract_key) AS contract_count  FROM contract_info WHERE  $this->sqlNameSearch");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = $this->sqlNameSearch;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadNameIdCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(DISTINCT contract_key) AS contract_count  FROM contract_info WHERE contract_key = '$this->contractId' AND $this->sqlNameSearch");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
//set up a session var with the search sql to grab the info to parse
$_SESSION['account_search_sql'] = "contract_key = '$this->contractId' AND $this->sqlNameSearch";


if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadGroupCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(DISTINCT contract_key) AS contract_count  FROM member_groups WHERE group_name LIKE '$this->groupName%'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
$_SESSION['group_search_sql'] = "group_name LIKE '$this->groupName%'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadCCCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(DISTINCT contract_key) AS contract_count  FROM credit_info WHERE card_number LIKE '%$this->ccNum'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
$_SESSION['cc_search_sql'] = "card_number LIKE '%$this->ccNum'";

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadMemberNameCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(DISTINCT contract_key) AS contract_count  FROM member_info WHERE $this->sqlNameSearch");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
$_SESSION['member_search_sql'] = $this->sqlNameSearch;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//====================================================
function loadBankCount()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(DISTINCT contract_key) AS contract_count  FROM banking_info WHERE account_number LIKE '%$this->bank'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
$_SESSION['bank_search_sql'] = "account_number LIKE '%$this->bank'";

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
 
$member_name = $_REQUEST['member_name'];
$contract_id = $_REQUEST['contract_id'];
$group_name = $_REQUEST['group_name'];
$cc_num = $_REQUEST['cc_num'];
$member_name2 = $_REQUEST['member_name2'];
$bank = $_REQUEST['bank'];
$sid = $_REQUEST['sid'];

$cc_num = urldecode($cc_num);
$cc_num = trim($cc_num);
$contract_id = urldecode($contract_id);
$contract_id = trim($contract_id);
$member_name = urldecode($member_name);   
$member_name = trim($member_name);
$group_name = urldecode($group_name);   
$group_name = trim($group_name);
$member_name2 = urldecode($member_name2);   
$member_name2 = trim($member_name2);
$bank = urldecode($bank);   
$bank = trim($bank);
   
$searchMember = new searchMemberAccounts();

if($contract_id != "" &&  $member_name == "" &&  $cc_num == "") {
   $searchMember-> setContractId($contract_id);  
   $searchMember-> loadIdCount();
  }

if($member_name != "" && $contract_id == "" &&  $cc_num == "") {
   $searchMember-> setMemberFullName($member_name);
   $searchMember-> parseMemberFullName();
   $searchMember-> loadNameCount();
  }

if($member_name != "" && $contract_id != "" &&  $cc_num == "")  {
    $searchMember-> setMemberFullName($member_name);
    $searchMember-> parseMemberFullName();
    $searchMember-> setContractId($contract_id);
    $searchMember-> loadNameIdCount();
  }
  
if($group_name != "")  {
   $searchMember-> setGroupName($group_name);
   $searchMember-> loadGroupCount();
}

if($cc_num != "")  {
   $searchMember-> setCCNum($cc_num);
   $searchMember-> loadCCCount();
}

if($member_name2 != "")  {
   $searchMember-> setMemberFullName($member_name2);
   $searchMember-> parseMemberFullName();
   $searchMember-> loadMemberNameCount();
}

if($bank != "")  {
   $searchMember-> setBank($bank);
   $searchMember-> loadBankCount();
}

$result_count = $searchMember-> getResultCount();

//check to see if this is coming from an ajax call. if not do it sever side
if($sid != "")  {
   echo"$result_count";
   exit;
   }  
?>