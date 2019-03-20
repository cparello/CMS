<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  employeeTypeDropsTwo {

private  $clubId = null;
private  $scheduleType = null;
private  $employeeTypeDrops = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }
        

       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadClubName($clubId) {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT club_name  FROM club_info WHERE club_id='$clubId' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_id);
   $stmt->fetch();
   $stmt->close();
   
   return "$club_id";

}
//---------------------------------------------------------------------------------
function loadEmployeeTypeDrops() {

if($this->clubId == '0') {
  $whereSQL = "club_id != '' ";
  }else{
  $whereSQL = "club_id = '$this->clubId' ";
  }


$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT type_key, employee_type, club_id  FROM employee_type WHERE  $whereSQL AND employee_type LIKE '%sales%' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($type_key, $employee_type, $club_id);
   $rowCount = $stmt->num_rows;
     
  if($rowCount > 0) {
  
            while ($stmt->fetch()) { 
                          
                          if($this->clubId == '0') {
                             $clubName = $this->loadClubName($club_id);
                             }else{
                             $clubName = "";
                             }
                             
                            $retailCategories .= "<option value=\"$type_key\">$employee_type $clubName</option>\n"; 
                                             
                      }
           
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Employee Type</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Employee Type</option>\n<option value=\"0\">All Employee Types</option>\n";
                   }
              
                   $this->employeeTypeDrops = "$dropHeader$retailCategories";
             
                                         
    }else{    
    $this->employeeTypeDrops = '0';
    }

$stmt->close();
}
//---------------------------------------------------------------------------------
function getEmployeeTypeDrops() {
           return($this->employeeTypeDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
if($ajax_switch == 1) {

$empType = new employeeTypeDropsTwo();
$empType-> setClubId($club_id);
$empType-> loadEmployeeTypeDrops();
$emp_type_drops = $empType-> getEmployeeTypeDrops();

echo"$emp_type_drops";
exit;


}
?>