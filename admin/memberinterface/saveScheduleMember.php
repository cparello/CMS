<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  saveScheduleMember {

private  $smMemberId = null;
private  $smContractKey = null;
private  $smFirstName = null;
private  $smLastName = null;
private  $smPhone = null;
private  $smEmail = null;
private  $serviceKey = null;
private  $classNumber = null;


function setSmMemberId($smMemberId) {
        $this->smMemberId = $smMemberId;
        }

function setSmFirstName($smFirstName) {
        $this->smFirstName = $smFirstName;
        }
        
function setSmLastName($smLastName) {
        $this->smLastName = $smLastName;
        }   
        
function setSmPhone($smPhone) {
        $this->smPhone = $smPhone;
        }        
        
function setSmEmail($smEmail) {
        $this->smEmail = $smEmail;
        }             
        
function setServiceKey($serviceKey) {
        $this->serviceKey = $serviceKey;
        }   
        
function setClassNumber($classNumber) {
        $this->classNumber = $classNumber;
        }           
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//-------------------------------------------------------------------------------------
function parseSchedulerMemberClassCount() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT sm_contract_key FROM schedular_member_class_count WHERE sm_contract_key='$this->smContractKey' AND service_key='$this->serviceKey'");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($smContractKey);
  $rowCount = $stmt->num_rows;
  $stmt->fetch();  
  $stmt->close();

   if($rowCount > 0) {
      $sql = "UPDATE schedular_member_class_count SET class_count= ? WHERE sm_contract_key='$this->smContractKey' AND service_key='$this->serviceKey'";
      $stmt = $dbMain->prepare($sql);
      $stmt->bind_param('i', $classCount);
      
      $classCount = $this->classNumber;
     
        if(!$stmt->execute())  {
           return($this->errorMessage);
           printf("Error: %s.\n", $stmt->error);
   	       exit;
          }

      $stmt->close();         
     
     }else{
     
      $sql = "INSERT INTO schedular_member_class_count VALUES (?, ?, ?, ?)";
      $stmt = $dbMain->prepare($sql);
      $stmt->bind_param('iiii', $smContractKey, $smMemberId, $serviceKey, $classCount);
  
      $smContractKey = $this->smContractKey;
      $smMemberId = $this->smMemberId;
      $serviceKey = $this->serviceKey;
      $classCount = $this->classNumber;

    
        if(!$stmt->execute())  {
           printf("Error: %s.\n", $stmt->error);
           }
   
      $stmt->close(); 
          
     }


}
//-------------------------------------------------------------------------------------
function insertSchedulerMemberService() {

  $dbMain = $this->dbconnect();
  $sql = "INSERT INTO schedular_member_services VALUES (?, ?, ?, ?, ?)";
  $stmt = $dbMain->prepare($sql);
  $stmt->bind_param('iiiis', $smContractKey, $smMemberId, $serviceKey, $serviceQuantity, $purchaseDate);
  
  $smContractKey = $this->smContractKey;
  $smMemberId = $this->smMemberId;
  $serviceKey = $this->serviceKey;
  $serviceQuantity = $this->classNumber;
  $purchaseDate = date("Y-m-d H:i:s");
  
  
  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
   $stmt->close(); 

}
//-------------------------------------------------------------------------------------
function updateMemberInfo() {

  $dbMain = $this->dbconnect();
  $sql = "UPDATE schedular_member_info SET sm_fname= ?, sm_lname=?, sm_phone= ?, sm_email= ? WHERE sm_contract_key = '$this->smContractKey' ";
  $stmt = $dbMain->prepare($sql);
  $stmt->bind_param('ssss', $smFirstName, $smLastName, $smPhone, $smEmail);

  $smFirstName = $this->smFirstName;
  $smLastName = $this->smLastName;
  $smPhone = $this->smPhone;
  $smEmail = $this->smEmail;
   

   if(!$stmt->execute())  {
       return($this->errorMessage);
       printf("Error: %s.\n", $stmt->error);
   	   exit;
      }

    $stmt->close();    

}
//-------------------------------------------------------------------------------------
function insertMemberInfo() {

  $dbMain = $this->dbconnect();
  $sql = "INSERT INTO schedular_member_info VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $dbMain->prepare($sql);
  $stmt->bind_param('iissss', $smContractKey, $smMemberId, $smFirstName, $smLastName, $smPhone, $smEmail);
  
  $smContractKey = null;
  $smMemberId = $this->smMemberId;
  $smFirstName = $this->smFirstName;
  $smLastName = $this->smLastName;
  $smPhone = $this->smPhone;
  $smEmail = $this->smEmail;
  
  
  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
   $this->smContractKey = $stmt->insert_id; 
   $stmt->close(); 
          
}
//-------------------------------------------------------------------------------------
function saveMember() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT sm_contract_key FROM schedular_member_info WHERE sm_member_id='$this->smMemberId' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($smContractKey);
  $rowCount = $stmt->num_rows;
  $stmt->fetch();
  
  if($rowCount > 0) {
    $this->smContractKey = $smContractKey;
    $this->updateMemberInfo();
    }else{
    $this->insertMemberInfo(); 
    }
    
    $stmt->close();
    

    $this->insertSchedulerMemberService();
    $this->parseSchedulerMemberClassCount();
    
   


}
//-------------------------------------------------------------------------------------











}
//==================================================

$ajax_switch = $_REQUEST['ajax_switch'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$email_address = $_REQUEST['email_address'];
$phone_number = $_REQUEST['phone_number'];
$member_id = $_REQUEST['member_id'];
$service_key = $_REQUEST['service_key'];
$class_number = $_REQUEST['class_number'];
             
            
if($ajax_switch == 1) {

  $save = new saveScheduleMember();
  $save-> setSmFirstName($first_name);
  $save-> setSmLastName($last_name);
  $save-> setSmEmail($email_address);
  $save-> setSmPhone($phone_number);
  $save-> setSmMemberId($member_id);
  $save-> setServiceKey($service_key);
  $save-> setClassNumber($class_number);
  $save-> saveMember();
  
  $success_bit = 1;
  echo"$success_bit";
  exit;
  
  
  
}

?>








