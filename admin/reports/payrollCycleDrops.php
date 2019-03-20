<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  payrollCycleDrops {

private  $clubId = null;
private  $scheduleType = null;
private  $cycleDrops = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }
        

       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadCycleDrops() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT payment_cycle  FROM payroll_settled WHERE club_id ='$this->clubId' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($paymentCycle);
   $rowCount = $stmt->num_rows;
  
  if($rowCount > 0) {
  
  while ($stmt->fetch()) { 
              
                switch($paymentCycle) {
                   case "D":
                   $cycleName = 'Daily';
                   break;
                   case "W":
                   $cycleName = "Weekly";
                   break;
                   case "B":
                   $cycleName = "Bi-Monthly";
                   break;
                   case "M":
                   $cycleName = "Monthly";
                   break;                   
                  }
                      if($paymentCycle != "") {
                          $retailCategories .= "<option value=\"$paymentCycle\">$cycleName</option>\n"; 
                          }
                          
              }
           
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Payroll Cycle</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Payroll Cycle</option>\n<option value=\"0\">All Cycle Types</option>\n";
                   }
              
                   $this->cycleDrops = "$dropHeader$retailCategories";
             
              
                           
    }else{    
    $this->cycleDrops = '0';
    }


}
//---------------------------------------------------------------------------------
function getCycleDrops() {
           return($this->cycleDrops);
           }




}
//---------------------------------------------------------------------------------

$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];

if($ajax_switch == 1) {

$cycle = new payrollCycleDrops();
$cycle-> setClubId($club_id);
$cycle-> loadCycleDrops();
$cycle_drops = $cycle-> getCycleDrops();

echo"$cycle_drops";
exit;


}