<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  searchHolderMember{

private  $contractId = null;
private  $memberId = null; 
private  $memberFullName = null;
private  $memberFirstName = null;
private  $memberMiddleName = null;
private  $memberLastName = null;
private  $sqlNameSearch = null;
private  $resultCount = null;
private  $resultCount2 = null;

 
function setContractId($contractId) {
    $this->contractId = $contractId;
    }
function setMemberId($memberId) {
    $this->memberId = $memberId;
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

   
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//====================================================
function parseNonMemberFullName()  {

$memberNameArray = preg_split('/\s+/', $this->memberFullName);   
$memberCount= count($memberNameArray);  

switch ($memberCount) {
         case 0:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "sm_lname LIKE '$this->memberLastName%'";
        break;
        case 1:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "sm_lname LIKE '$this->memberLastName%'";
        break;
        case 2:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = "";
              $this->memberLastName = $memberNameArray[1];
              $this->sqlNameSearch = "sm_fname LIKE '$this->memberFirstName%' AND sm_lname LIKE '$this->memberLastName%'";
        break;
        case 3:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = $memberNameArray[1];
              $this->memberLastName = $memberNameArray[2];
              $this->sqlNameSearch = "sm_fname LIKE '$this->memberFirstName%' AND sm_lname LIKE '$this->memberLastName%'";
        break;
    default:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "sm_lname LIKE '$this->memberLastName%'";
     }

}
//-------------------------------------------------------------------------------------------
function  loadNonMemberNameCount() {
  
     $this->parseNonMemberFullName();
  
     $dbMain = $this->dbconnect();
     $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS non_member_count  FROM schedular_member_info WHERE  $this->sqlNameSearch");   
     $stmt->execute();
     $stmt->store_result();      
     $stmt->bind_result($member_count);
     $stmt->fetch();

     $this->resultCount2 = $member_count;
     $_SESSION['member_search_sql'] = $this->sqlNameSearch;

     if(!$stmt->execute())  {
        return($this->confirmation_message);
	    printf("Error: %s.\n", $stmt->error);
       }
   
     $stmt->close();    
  

}
//--------------------------------------------------------------------------------------------
function loadNonMemberIdCount() {
    
       $dbMain = $this->dbconnect();
       $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS member_count  FROM schedular_member_info WHERE sm_member_id = '$this->memberId'");   
       $stmt->execute(); 
       $stmt->store_result();      
       $stmt->bind_result($member_count);
       $stmt->fetch();

       $this->resultCount2 = $member_count;


       if(!$stmt->execute())  {
          return($this->confirmation_message);
          printf("Error: %s.\n", $stmt->error);
         }
   
       $stmt->close();        
    
    
   
      
}
//--------------------------------------------------------------------------------------------
function parseMemberFullName()  {

$memberNameArray = preg_split('/\s+/', $this->memberFullName);   
$memberCount= count($memberNameArray);  

switch ($memberCount) {
         case 0:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '$this->memberLastName%'";
        break;
        case 1:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '$this->memberLastName%'";
        break;
        case 2:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = "";
              $this->memberLastName = $memberNameArray[1];
              $this->sqlNameSearch = "first_name LIKE '$this->memberFirstName%' AND last_name LIKE '$this->memberLastName%'";
        break;
        case 3:
              $this->memberFirstName = $memberNameArray[0];
              $this->memberMiddleName = $memberNameArray[1];
              $this->memberLastName = $memberNameArray[2];
              $this->sqlNameSearch = "first_name LIKE '$this->memberFirstName%' AND middle_name LIKE '$this->memberMiddleName%' AND last_name LIKE '$this->memberLastName%'";
        break;
    default:
               $this->memberFirstName = "";
               $this->memberMiddleName = "";
               $this->memberLastName = $this->memberFullName;
               $this->sqlNameSearch = "last_name LIKE '$this->memberLastName%'";
     }
}

//-----------------------------------------------------------------------------------------
function loadContractIdCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(DISTINCT contract_key) AS contract_count  FROM contract_info WHERE contract_key = '$this->contractId'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;


if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

 }
 
//--------------------------------------------------------------------------------------------
function  loadContractNameCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(DISTINCT contract_key) AS contract_count  FROM contract_info WHERE  $this->sqlNameSearch");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($contract_count);
$stmt->fetch();

$this->resultCount = $contract_count;
$_SESSION['account_search_sql'] = $this->sqlNameSearch;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//--------------------------------------------------------------------------------------------
function  loadMemberNameCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(*) AS member_count  FROM member_info WHERE  $this->sqlNameSearch");   
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($member_count);
$stmt->fetch();

$this->resultCount = $member_count;
$_SESSION['member_search_sql'] = $this->sqlNameSearch;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//-------------------------------------------------------------------------------------------
function loadMemberIdCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  COUNT(*) AS member_count  FROM member_info WHERE member_id = '$this->memberId'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($member_count);
$stmt->fetch();

$this->resultCount = $member_count;


if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

 }

//====================================================

function getMemberResultCount() {
          return($this->resultCount);
          }

function getNonMemberResultCount() {
          return($this->resultCount2);
          }

        

 }//end of class
 
 
 $mem_holder = $_REQUEST['mem_holder'];
 $search_id = $_REQUEST['search_id'];
 $search_name = $_REQUEST['search_name'];
 
 
$mem_holder = urldecode($mem_holder);
$mem_holder = trim($mem_holder);

$search_name = urldecode($search_name);   
$search_name = trim($search_name);

$search_id = urldecode($search_id);   
$search_id = trim($search_id);
   
$holdMem = new searchHolderMember();

switch ($mem_holder) {
        case "C":
                if($search_name != "") {
                   $holdMem-> setMemberFullName($search_name);
                   $holdMem-> parseMemberFullName();
                   $holdMem-> loadContractNameCount();
                   }else{
                   $holdMem-> setContractId($search_id); 
                   $holdMem-> loadContractIdCount();                   
                   }
                   
                   $result_count = $holdMem-> getMemberResultCount(); 
        break;
        case "M":
                 if($search_name != "") {
                   $holdMem-> setMemberFullName($search_name);
                   $holdMem-> parseMemberFullName();
                   $holdMem-> loadMemberNameCount();
                   }else{
                   $holdMem-> setMemberId($search_id); 
                   $holdMem-> loadMemberIdCount();
                   $result_count = $holdMem-> getMemberResultCount();
                   }
                   
                   $result_count = $holdMem-> getMemberResultCount();
        break;
        case "N":
                 if($search_name != "") {
                   $holdMem-> setMemberFullName($search_name);
                   $holdMem-> parseMemberFullName();
                   //$holdMem-> loadMemberNameCount();
                   $holdMem-> loadNonMemberNameCount();
                   }else{
                   $holdMem-> setMemberId($search_id); 
                   //$holdMem-> loadMemberIdCount();
                   $holdMem-> loadNonMemberIdCount();                   
                   }
                   $result_count = $holdMem-> getNonMemberResultCount();
        break;        
        }


  echo"$result_count";
  exit;

?>