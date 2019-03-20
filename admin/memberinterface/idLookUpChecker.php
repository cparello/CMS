<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  idLookUp{

private $barCode = null;
private $productListing = null;
private $clubId = null;
private $inventoryMarker = null;
private $wholeCost = null;
private $categoryName = null;
private $categoryId = null;


function setId($id) {
        $this->idNumber = $id;
        }
function setIdType($idType) {
        $this->idType = $idType;
        }
function setClubId($clubId) {
        $this->clubId = $clubId;
        }
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}        
//-------------------------------------------------------------------------------------------------
function loadIdListing() {
$found = 0;
$dbMain = $this->dbconnect();

switch($this->idType){
    case 'B':
        $stmt = $dbMain ->prepare("SELECT contract_key FROM member_info WHERE member_id = '$this->idNumber'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($contract_key);         
        $stmt->fetch(); 
        $stmt->close();
        if($contract_key != ""){
            $found = 1;
        }
        $this->contractKey = $contract_key;
    break;
    case 'C':
        $stmt = $dbMain ->prepare("SELECT contract_key FROM member_info WHERE contract_key = '$this->idNumber'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($contract_key);         
        $stmt->fetch(); 
        $stmt->close();
        if($contract_key != ""){
            $found = 1;
        }
        $this->contractKey = $contract_key;
    break;
    
}
          
if($found == 1)  {
    
    $stmt = $dbMain ->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($first_name, $last_name);         
    $stmt->fetch(); 
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT COUNT(*) as count FROM billing_trans_token  WHERE contract_key = '$this->contractKey'");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($count); 
    $stmt->fetch();
    $stmt->close();
    
    if ($count <= 0){
        $this->idListing = 3;
    }else{
        $this->idListing = 2;
    }
    
    $this->name = "$first_name $last_name";
   }else{
   $this->idListing = 1;
   }
                        


}
//-------------------------------------------------------------------------------------------------
function getIdListing() {
         return($this->idListing);
         }
function getContractKey() {
         return($this->contractKey);
         }
function getName() {
         return($this->name);
         }
}
//========================================================

$id_number = $_REQUEST['id_number'];
$id_type = $_REQUEST['id_type'];
$ajax_switch = $_REQUEST['ajax_switch'];
//echo "idn $id_number idt $id_type";
//exit;
if($ajax_switch == 1) {

   $location_id = $_SESSION['location_id'];

   $listing = new idLookUp();
   $listing-> setId($id_number);
   $listing-> setIdType($id_type);
   $listing-> setClubId($location_id);
   $listing-> loadIdListing();
   $id_listing = $listing-> getIdListing();
   $contract_key = $listing-> getContractKey();
   $name = $listing-> getName();
   echo"$id_listing|$contract_key|$name";

   exit;
  }


?>