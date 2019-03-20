<?php
class quickbook2ndJobFix{
    
private $lastPayrollID = null;

    
    
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------
function loadLastPayrollId() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
   
$this->lastPayrollID = $payroll_id;

}
//=========================================================================================================================
function findSecondJobNChangeInfo() {
$this->loadLastPayrollId();

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_id, type_key, emp_lname, COUNT(*) FROM  qb_payroll_settled WHERE payroll_id = '$this->lastPayrollID' GROUP BY user_id HAVING  COUNT(*) > 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($dupeUserID, $typeKey, $empLName); 
$stmt->fetch();
$stmt->close();

$empLName = "$empLName $dupeUserID";
$newUserId = 999;

$rowCount = 1;
do {
$stmt = $dbMain ->prepare("SELECT new_user_id FROM qb_second_job_userid WHERE new_user_id = '$newUserId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_id); 
$stmt->fetch();
$rowCount = $stmt->numRows();
$stmt->close();
$newUserId--;
} while ($rowCount != 0);


$sql = "INSERT INTO qb_second_job_userid VALUES (?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ii', $dupeUserID, $newUserId); 
$stmt->close(); 


$sql = "UPDATE qb_payroll_settled  SET user_id = ?, emp_lname = ? WHERE user_id = '$dupeUserID' AND type_key = '$typeKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('is', $newUserId, $empLName);
$stmt->execute();        
$stmt->close();


}
//===========================================================================================================================



   
    
}


?>