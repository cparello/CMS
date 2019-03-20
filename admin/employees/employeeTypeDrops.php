<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  employeeTypeDrops{

private  $allSelect;
private  $typeKey = null;
private  $employeeType;
private  $employeeDescription;
private  $clubId;
private  $userId;

private  $typeKey1;
private  $typeKey2;
private  $typeKey3;
private  $typeKey4;

private $empTypeArray;

private $marker;

//this sets up an araay of emplooyee types to weed out duplicate records
function setEmpTypeArray($empTypeArray) {
           $this->empTypeArray = $empTypeArray;
           }


function setAllSelect($allSelect) {
        $this->allSelect = $allSelect;
        }   
function setTypeKey($typeKey) {
        $this->typeKey = $typeKey;
        }         
function setEmployeeType($employeeType) {
        $this->employeeType = $employeeType;
        }
function setClubId($clubId) {
        $this->clubId = $clubId;
         }
function setUserId($userId) {
        $this->userId = $userId;
         }
    
    
//this sets all of the type keys for the drop downs selected
function setTypeKey1($typeKey1) {
        $this->typeKey1 = $typeKey1;
        }
function setTypeKey2($typeKey2) {
        $this->typeKey2 = $typeKey2;
        }
function setTypeKey3($typeKey3) {
        $this->typeKey3 = $typeKey3;
        } 
function setTypeKey4($typeKey4) {
        $this->typeKey4 = $typeKey4;
        }        

function setMarker($marker) {
        $this->marker = $marker;
        }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------------------------
function deleteTheFuckers($deleteKey)  {

$delete_types_array = $this->empTypeArray;
$delete_types = explode("|", $delete_types_array);

     if (in_array($deleteKey, $delete_types)) {
         return true;
        }
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function getClubName()    {

$dbMain = $this->dbconnect();

if($this->clubId == "0") {
   $club_id = "All Locations";
   }else{
   $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_id); 
   $stmt->fetch();
  }  
  
 return "$club_id";
}

//-----------------------------------------------------------------------------------------------------------------------------------------
function getEmployeeType($typeKey)  {
$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT employee_type, club_id FROM employee_type WHERE type_key = '$typeKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($employee_type, $club_id);   
 $stmt->fetch();
 $this->clubId = $club_id;
 $club_name = $this->getClubName();
  
  //this checks to see if a sales person has been selected and if so creates a switch
 if(preg_match("/sales/i", $employee_type)) {
      $this->marker = $club_id;       
    }else{
      $this->marker = null;     
    }



$choose_type = "<option value=\"$typeKey|$club_id\" selected>$employee_type  $club_name</option>\n"; 
return "$choose_type";

}
//-----------------------------------------------------------------------------------------------------------------------------------------

function loadTypeMenu() {

if($this->typeKey == null)  {
//this handles if there is no selection for the employee type
$choose_type = "<option value=\"\">Choose Employee Type</option>\n";
$this->marker = null; 
}else{
//this sets up the selected employe if chosen
$choose_type =$this->getEmployeeType($this->typeKey);
}

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT type_key, employee_type, club_id FROM employee_type WHERE type_key != '' ORDER BY employee_type ASC");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_key, $employee_type, $club_id);   

    while ($stmt->fetch()) {   
                 
               $this->clubId = $club_id;
               $club_name = $this->getClubName();   
               
               $emp_flag = $this->deleteTheFuckers($type_key);
               
               if($emp_flag != true) {
               $emp_type_select .= "<option value=\"$type_key|$club_id\">$employee_type $club_name</option>\n"; 
               }
 
                                    if($this->typeKey != null) {
                                     $emp_type_select = null;                                 
                                    }
 
            }
            
return "$choose_type$emp_type_select";            

}

//------------------------------------------------------------------------------------------------------------------------------------------------
function loadTypeKeys() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT type_key FROM basic_compensation WHERE user_id = '$this->userId' ORDER BY user_id ASC");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_key);

           while ($stmt->fetch()) {         
                     $keys .= "$type_key|";           
                   }
          
                    $keysArray = explode(" ", $keys);          
                    $this->typeKey1 = $keysArray[0];
                    $this->typeKey2 = $keysArray[1];                    
                    $this->typeKey3 = $keysArray[2];          
                    $this->typeKey4 = $keysArray[3];
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function getTypeKey1() {
return($this->typeKey1);
}

function getTypeKey2() {
return($this->typeKey2);
}

function getTypeKey3() {
return($this->typeKey3);
}

function getTypeKey4() {
return($this->typeKey4);
}

function getMarker() {
return($this->marker);
}

function getClubId() {
return($this->clubId);
}

function getEmpTypeArray() {
return($this->empTypeArray);
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
}

?>