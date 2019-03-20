<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  employeeNameDrops {

private  $clubId = null;
private  $employeeType = null;
private  $employeeNameDrops = null;
private  $userId = null;
private  $employeeName = null;
private  $typeKey = null;
private  $empOption = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }
        
function setEmployeeType($employeeType) {
       $this->employeeType = $employeeType;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadEmployeeName() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname  FROM employee_info WHERE user_id='$this->userId' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname);
   $stmt->fetch();
   $stmt->close();
   
   $this->employeeName = "$emp_fname $emp_mname $emp_lname";

}
//---------------------------------------------------------------------------------
function loadListings() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_id, id_card  FROM basic_compensation WHERE  type_key = '$this->typeKey' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($user_id, $id_card);
   $rowCount = $stmt->num_rows;
     
  if($rowCount > 0) {
  
            while ($stmt->fetch()) { 
                           $this->userId = $user_id;
                           $this->loadEmployeeName();
                           $this->empOption .= "<option value=\"$user_id\">$id_card $this->employeeName</option>\n"; 
                                             
                      }
           
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Employee Name</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Employee Name</option>\n<option value=\"0\">All Employee Names</option>\n";
                   }
              
                   $this->employeeNameDrops = "$dropHeader$this->empOption";
             
                                         
    }else{    
    $this->employeeNameDrops = '0';
    }

$stmt->close();


}
//---------------------------------------------------------------------------------
function loadEmployeeNameDrops() {


$dbMain = $this->dbconnect();

if(($this->clubId == '0') && ($this->employeeType == '0')) {
   $stmt = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE  club_id != '' AND employee_type LIKE '%sales%' ");
   }

if(($this->clubId == '0') && ($this->employeeType != '0')) {
   $stmt = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE  club_id !='' AND type_key = '$this->employeeType' ");
   }

if(($this->clubId != '0') && ($this->employeeType == '0')) {
   $stmt = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE  club_id ='$this->clubId' AND employee_type LIKE '%sales%'  ");
   }

if(($this->clubId != '0') && ($this->employeeType != '0')) {
   $stmt = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE  club_id ='$this->clubId' AND type_key = '$this->employeeType' ");
   }

   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($type_key);
   $rowCount = $stmt->num_rows;
     
  if($rowCount > 0) {
  
            while ($stmt->fetch()) { 
                           $this->typeKey = $type_key;
                           $this->loadListings();                                             
                      }
           

    }

$stmt->close();
}
//---------------------------------------------------------------------------------
function getEmployeeNameDrops() {
           return($this->employeeNameDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$employee_type = $_REQUEST['employee_type'];
$club_id = $_REQUEST['club_id'];

if($ajax_switch == 1) {

$empName = new employeeNameDrops();
$empName-> setClubId($club_id);
$empName-> setEmployeeType($employee_type);
$empName-> loadEmployeeNameDrops();
$emp_name_drops = $empName-> getEmployeeNameDrops();

echo"$emp_name_drops";
exit;


}
?>