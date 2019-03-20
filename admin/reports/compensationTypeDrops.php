<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  compensationTypeDrops {

private  $clubId = null;
private  $paymentCycle = null;
private  $compensationDrops = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }
        
function setPaymentCycle($paymentCycle) {
       $this->paymentCycle = $paymentCycle;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadCompensationDrops() {

if($this->paymentCycle == '0') {
  $paymentSQL = "payment_cycle !='' ";
  }else{
  $paymentSQL = "payment_cycle ='$this->paymentCycle' ";
  }

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT comp_type  FROM payroll_settled WHERE club_id ='$this->clubId' AND $paymentSQL ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($compensationType);
   $rowCount = $stmt->num_rows;
  
  if($rowCount > 0) {
  
  while ($stmt->fetch()) { 
              
                switch($compensationType) {
                   case "S":
                   $compName = 'Salary';
                   break;
                   case "H":
                   $compName = "Hourly";
                   break;
                   case "C":
                   $compName = "Commission";
                   break;
                   case "SC":
                   $compName = "Salary Commission";
                   break; 
                   case "HC":
                   $compName = "Hourly Commission";
                   break;                    
                  }
                      if($compensationType != "") {
                          $retailCategories .= "<option value=\"$compensationType\">$compName</option>\n"; 
                          }
                          
              }
           
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Compensation</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Compensation</option>\n<option value=\"0\">All Compensation Types</option>\n";
                   }
              
                   $this->compensationDrops = "$dropHeader$retailCategories";
             
              
                           
    }else{    
    $this->compensationDrops = '0';
    }


}
//---------------------------------------------------------------------------------
function getCompensationDrops() {
           return($this->compensationDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$payment_cycle = $_REQUEST['payment_cycle'];
$club_id = $_REQUEST['club_id'];
if($ajax_switch == 1) {

$comp = new compensationTypeDrops();
$comp-> setClubId($club_id);
$comp-> setPaymentCycle($payment_cycle);
$comp-> loadCompensationDrops();
$comp_drops = $comp-> getCompensationDrops();

echo"$comp_drops";
exit;


}