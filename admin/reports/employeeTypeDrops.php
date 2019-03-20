<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  employeeTypeDrops {

private  $clubId = null;
private  $paymentCycle = null;
private  $compensationType = null;
private  $employeeDrops = null;
private  $typeKey = null;
private  $typeName = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }
        
function setPaymentCycle($paymentCycle) {
       $this->paymentCycle = $paymentCycle;
       }
       
function setCompensationType($compensationType) {
       $this->compensationType = $compensationType;
       }       
       
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadEmployeeTypeName() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT employee_type  FROM employee_type WHERE type_key='$this->typeKey' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($employee_type);
   $stmt->fetch();
   $stmt->close();

   $this->typeName = $employee_type;

}
//---------------------------------------------------------------------------------
function loadEmployeeDrops() {

if($this->paymentCycle == '0') {
  $paymentSQL = "payment_cycle !='' ";
  }else{
  $paymentSQL = "payment_cycle ='$this->paymentCycle' ";
  }
  
if($this->compensationType == '0') {
  $compSQL = "comp_type !='' ";
  }else{
  $compSQL = "comp_type ='$this->compensationType' ";
  }  

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT type_key  FROM payroll_settled WHERE club_id ='$this->clubId' AND $paymentSQL AND $compSQL ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($typeKey);
   $rowCount = $stmt->num_rows;
  
  if($rowCount > 0) {
  
  while ($stmt->fetch()) { 
              
                      if($typeKey != "") {
                      
                          $this->typeKey = $typeKey;
                          $this->loadEmployeeTypeName();
                      
                          $retailCategories .= "<option value=\"$this->typeKey\">$this->typeName</option>\n"; 
                          }
                          
              }
           
                if($rowCount == 1) {
                   $dropHeader = "<option value>Select Employee Type</option>\n"; 
                   }else{
                   $dropHeader = "<option value>Select Employee Type</option>\n<option value=\"0\">All Employee Types</option>\n";
                   }
              
                   $this->employeeDrops = "$dropHeader$retailCategories";
             
              
                           
    }else{    
    $this->employeeDrops = '0';
    }


}
//---------------------------------------------------------------------------------
function getEmployeeDrops() {
           return($this->employeeDrops);
           }




}
//---------------------------------------------------------------------------------

$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$payment_cycle = $_REQUEST['payment_cycle'];
$comp_type = $_REQUEST['comp_type'];

if($ajax_switch == 1) {

$emp = new employeeTypeDrops();
$emp-> setClubId($club_id);
$emp-> setPaymentCycle($payment_cycle);
$emp-> setCompensationType($comp_type);
$emp-> loadEmployeeDrops();
$emp_drops = $emp-> getEmployeeDrops();

echo"$emp_drops";
exit;


}