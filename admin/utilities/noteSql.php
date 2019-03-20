<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class noteSql {

private $assignmentSales = null;
private $assignmentMember = null;
private $assignmentBilling = null;
private $assignmentEmp = null;
private $assignmentInternet = null;
private $lowDays = null;
private $mediumDays = null;
private $highDays = null;
private $salesDrop = null;
private $assignmentDrop = null;
private $memberDrop = null;
private $billingDrop = null;
private $empDrop = null;
private $internetDrop = null;
private $salesSelected = null;
private $memberSelected = null;
private $billingSelected = null;
private $empSelected = null;
private $internetSelected = null;


//this is to set the drops for targeted applications 
private $targetApp = null;

function setTargetApp($targetApp) {
               $this->targetApp = $targetApp;
               }


//these are for saving notes
private $noteTopic = null;
private $noteMessage = null;
private $noteUser = null;  //this is the user id of the logged in user
private $noteCategory = null;
private $notePriority = null;
private $targetAppId = null;
private $memberId = null;
private $contractKey = null;

function setNoteTopic($noteTopic) {
       $this->noteTopic = $noteTopic;
       }
function setNoteMessage($noteMessage) {
       $this->noteMessage = $noteMessage;
       }       
function setNoteUser($noteUser) {
       $this->noteUser = $noteUser;
       }
function setNotePriority($notePriority) {
       $this->notePriority = $notePriority;
       }
function setTargetAppId($targetAppId) {
       $this->targetAppId = $targetAppId;
       }       
function setNoteCategory($noteCategory) {
       $this->noteCategory = $noteCategory;
       }     
function setMemberId($memberId) {
       $this->memberId = $memberId;
       }   
function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }   


function setAssignmentSales($assignmentSales) {
                 $this->assignmentSales = $assignmentSales;
              }
function setAssignmentMember($assignmentMember) {
                 $this->assignmentMember = $assignmentMember;
              }
function setAssignmentBilling($assignmentBilling) {
                 $this->assignmentBilling = $assignmentBilling;
              }
function setAssignmentEmp($assignmentEmp) {
                 $this->assignmentEmp = $assignmentEmp;
              }
function setAssignmentInternet($assignmentInternet) {
                 $this->assignmentInternet = $assignmentInternet;
              }

function setLowDays($lowDays) {
                 $this->lowDays = $lowDays;
              }
function setMediumDays($mediumDays) {
                 $this->mediumDays = $mediumDays;
              }
function setHighDays($highDays) {
                 $this->highDays = $highDays;
              }


//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadBitMap($dropValueArray)  {

if($dropValueArray != "") {
 
         if (in_array('SI', $dropValueArray)) {
             $salesBit = 1;
            }else{
             $salesBit = 0;
            }
         if (in_array('MI', $dropValueArray)) {
             $memberBit = 1;
            }else{
             $memberBit = 0;
            }      
         if (in_array('BL', $dropValueArray)) {
             $billingBit = 1;
            }else{
             $billingBit = 0;
            }           
         if (in_array('IS', $dropValueArray)) {
             $internetBit = 1;
            }else{
             $internetBit = 0;
            }     
         if (in_array('EM' , $dropValueArray)) {
             $empBit = 1;
            }else{
             $empBit = 0;
            }

}else{
$salesBit = 0;
$memberBit = 0;
$billingBit = 0;
$internetBit = 0;
$empBit = 0;
}
            
$dropValueBit = "$salesBit$memberBit$billingBit$internetBit$empBit";

return $dropValueBit;

}
//--------------------------------------------------------------------------------------------------------------------
function createDropList($assignmentDrop) {

$bit_array = str_split($assignmentDrop);


          if($bit_array[0] == 0) {
            $salesSelected = "";
            }else{
            $salesSelected = 'selected';
            }          
  
          
          if($bit_array[1] == 0) {
            $memberSelected = "";
            }else{
            $memberSelected = 'selected';
            }                   


          if($bit_array[2] == 0) {
            $billingSelected = "";
            }else{
            $billingSelected = 'selected';
            }                   
         

          if($bit_array[3] == 0) {
            $internetSelected = "";
            }else{
            $internetSelected = 'selected';
            }                   


          if($bit_array[4] == 0) {
            $empSelected = "";
            }else{
            $empSelected = 'selected';
            }                   



      $selectList ="
     <option value=\"SI\" $salesSelected>Sales Interface</option>
     <option value=\"MI\" $memberSelected>Member Interface</option>
     <option value=\"BL\" $billingSelected>Billing Interface</option>
     <option value=\"IS\" $internetSelected>Internet Services</option>
     <option value=\"EM\" $empSelected>Employee Services</option>";
     
     return $selectList;
     

}
//====================================================================
function loadNoteSettings() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT assignment_sales, assignment_member, assignment_billing, assignment_emp, assignment_internet, low_days, medium_days, high_days FROM manage_notes WHERE assignment_sales != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($assignment_sales, $assignment_member, $assignment_billing, $assignment_emp, $assignment_internet, $low_days, $medium_days, $high_days);
   $stmt->fetch();

   $this->assignmentSales = $assignment_sales;
   $this->salesDrop = $this->createDropList($this->assignmentSales);
    
   $this->assignmentMember = $assignment_member;
   $this->memberDrop = $this->createDropList($this->assignmentMember);
   
   $this->assignmentBilling = $assignment_billing;
   $this->billingDrop = $this->createDropList($this->assignmentBilling);
      
   $this->assignmentInternet = $assignment_internet;
   $this->internetDrop = $this->createDropList($this->assignmentInternet);      
      
   $this->assignmentEmp = $assignment_emp;
   $this->empDrop = $this->createDropList($this->assignmentEmp);
   

   
   
   $this->lowDays = $low_days;
   $this->mediumDays = $medium_days;
   $this->highDays = $high_days;


}
//====================================================================
function saveNoteSettings() {

$this->assignmentSales = $this->loadBitMap($this->assignmentSales);
$this->assignmentMember = $this->loadBitMap($this->assignmentMember);
$this->assignmentBilling = $this->loadBitMap($this->assignmentBilling);
$this->assignmentEmp = $this->loadBitMap($this->assignmentEmp);
$this->assignmentInternet = $this->loadBitMap($this->assignmentInternet);


$dbMain = $this->dbconnect();
$sql = "UPDATE manage_notes SET assignment_sales= ?,  assignment_member= ?, assignment_billing= ?, assignment_emp= ?, assignment_internet=?, low_days=?, medium_days=?, high_days=? WHERE assignment_sales != '' ";

$stmt = $dbMain->prepare($sql);
echo($dbMain->error);
$stmt->bind_param('sssssiii', $assignment_sales, $assignment_member, $assignment_billing, $assignment_emp, $assignment_internet, $low_days, $medium_days, $high_days);

$assignment_sales = $this->assignmentSales;
$assignment_member = $this->assignmentMember;
$assignment_billing = $this->assignmentBilling;
$assignment_emp = $this->assignmentEmp;
$assignment_internet = $this->assignmentInternet;
$low_days = $this->lowDays;
$medium_days = $this->mediumDays;
$high_days = $this->highDays;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }else{
   $confirmation_message = "Note Assignments and Durations Successfully Updated";
   return($confirmation_message);
   }


}
//=====================================================================
//function to get drop downs for target applications
function loadDropDowns() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT $this->targetApp FROM manage_notes WHERE assignment_sales != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($assignmentBit);
   $stmt->fetch();
   
  switch($this->targetApp) {          
             case"assignment_sales":
             $salesSelected = 'selected';
             break;
             case"assignment_billing":
             $billingSelected = 'selected';
             break;
             case"assignment_emp":
             $empSelected = 'selected';
             break;
             case"assignment_member":
             $memberSelected = 'selected';
             break;   
             case"assignment_internet":
             $internetSelected = 'selected';
             break;              
           }              
   
   
   

$bit_array = str_split($assignmentBit);

 if($bit_array[0] == 0) {
            $salesSelected = null;
            }else{
            $salesSelected = "<option value=\"SI\" $salesSelected>Sales Interface</option>";
            }          
  
          
          if($bit_array[1] == 0) {
            $memberSelected = null;
            }else{
            $memberSelected = "<option value=\"MI\" $memberSelected>Member Interface</option>";
            }                   


          if($bit_array[2] == 0) {
            $billingSelected = null;
            }else{
            $billingSelected = "<option value=\"BL\" $billingSelected>Billing Interface</option>";
            }                   
         

          if($bit_array[3] == 0) {
            $internetSelected = null;
            }else{
            $internetSelected = "<option value=\"IS\" $internetSelected>Internet Services</option>";
            }                   


          if($bit_array[4] == 0) {
            $empSelected = null;
            }else{
            $empSelected = "<option value=\"EM\" $empSelected>Employee Services</option>";
            }                   


    $dropList = "$salesSelected$memberSelected$billingSelected$internetSelected$empSelected"; 
     
     
return $dropList;

}

//=====================================================================
function saveNote() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssssiss', $contractKey, $noteUser, $noteDate, $amPm, $noteTopic, $noteMessage, $noteCategory, $memberId, $priority, $targetApp);

$contractKey = $this->contractKey;
$noteUser = $this->noteUser;
$noteDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")  ,date("d"), date("Y")));
$amPm = date("a");
$noteTopic  = $this->noteTopic;
$noteMessage = $this->noteMessage;
$noteCategory = $this->noteCategory;

if($this->memberId == null) {
   $memberId = "";
   }else{
   $memberId = $this->memberId;
   }
   
$priority = $this->notePriority;
$targetApp = $this->targetAppId;

$success = 1;

if(!$stmt->execute())  {
	printf("Error: %s.\n  insert account notes", $stmt->error);
   }else{
   return $success;
   }

$stmt->close(); 



}
//=====================================================================
function saveTest() {

$contractKey = $this->contractKey;
$noteUser = $this->noteUser;
$noteDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")  ,date("d"), date("Y")));
$amPm = date("a");
$noteTopic  = $this->noteTopic;
$noteMessage = $this->noteMessage;
$noteCategory = $this->noteCategory;
$memberId = $this->memberId;
$priority = $this->notePriority;
$targetApp = $this->targetAppId;

$test = "$contractKey \n $noteUser \n $noteDate \n $amPm \n $noteTopic \n $noteMessage \n $noteCategory \n $memberId \n $priority \n $targetApp";

return $test;

}
//=====================================================================

function getSalesDrop() {
          return($this->salesDrop);
          }
function getMemberDrop() {
          return($this->memberDrop);
          }
function getBillingDrop() {
          return($this->billingDrop);
          }
function getEmpDrop() {
          return($this->empDrop);
          }
function getInternetDrop() {
          return($this->internetDrop);
          }
function getLowDays() {
          return($this->lowDays);
          }          
function getMediumDays() {
          return($this->mediumDays);
          }      
function getHighDays() {
          return($this->highDays);
          }      
          
          

}





?>