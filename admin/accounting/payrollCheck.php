<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  payrollCheck {

private $payrollCycle = null;
private $clubLocation = null;
private $payrollResult = null;
private $userId = null;
private $typeKey = null;
private $idCard = null;
private $lastParollCloseDate = null;
private $whereSql = null;


function setPayrollCycle($payrollCycle) {
          $this->payrollCycle = $payrollCycle;
          }
function setClubLocation($clubLocation) {
          $this->clubLocation = $clubLocation;
          }
function setDateStart($date_start){
          $this->dateStart = $date_start;
          }
function setDateEnd($date_end){
          $this->dateEnd = $date_end;
          }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------------------------
function loadLastPayrollCloseDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(close_date)  FROM payroll_settled WHERE type_key = '$this->typeKey' AND user_id = '$this->userId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($close_date); 
             $stmt->fetch();

$this->lastParollCloseDate = $close_date;

}
//----------------------------------------------------------------------------------------------------------------------
function loadHours() {

/*$this->loadLastPayrollCloseDate();

if($this->lastParollCloseDate == "") {
   $this->lastParollCloseDate = '000-00-00 00:00:00';
   }*/
$this->dateStart = date('Y-m-d H:i:s',strtotime($this->dateStart));
$this->dateEnd = date('Y-m-d H:i:s',strtotime($this->dateEnd));
    //echo "d $this->dateStart d $this->dateEnd id $this->idCard<br>";
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT timeclock_key, clock_in, clock_out FROM timeclock WHERE  id_card='$this->idCard' AND (clock_out BETWEEN '$this->dateStart' AND '$this->dateEnd')");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($timeclock_key, $clock_in, $clock_out);         
             $rowCount = $stmt->num_rows;
             
       if($rowCount != 0)  {
           
                    while ($stmt->fetch()) { 
                        $datetime1 = new DateTime($clock_in);
                        $datetime2 = new DateTime($clock_out);
                        $interval = $datetime1->diff($datetime2);
                        $hoursMinsSecs = $interval->format('%H:%I:%S');                        
                        $parts = explode(':', $hoursMinsSecs);
                        $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                        $secondsArray .= "$seconds|";  
                        }
     
               $secondsArray = explode("|", $secondsArray);
               $totalSeconds = array_sum($secondsArray);
               
               $hours = floor($totalSeconds / 3600);
               $minutes = floor(($totalSeconds / 60) % 60);
               $totalHours = "$hours.$minutes";
               
               $this->totalHours = sprintf("%01.2f", $totalHours);
               $this->payrollResult += $totalHours;
                              
           } 
    if($this->payrollResult == ''){
         $stmt = $dbMain ->prepare("SELECT user_id FROM basic_compensation WHERE id_card = '$this->idCard'");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($user_id); 
         $stmt->fetch();
         $stmt->close();
         
         $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($emp_fname, $emp_mname, $emp_lname); 
         $stmt->fetch();
         $stmt->close();
         
         $emp_fname = trim($emp_fname);
         $emp_fname = strtolower($emp_fname);
         $emp_fname = ucfirst($emp_fname);
            
         $emp_mname = trim($emp_mname);
         $emp_mname = strtolower($emp_mname);
         $emp_mname = ucfirst($emp_mname);
            
         $emp_lname = trim($emp_lname);
         $emp_lname = strtolower($emp_lname);
         $emp_lname = ucfirst($emp_lname);
            
         $name = "$emp_fname $emp_mname $emp_lname";
         
         $stmt = $dbMain ->prepare("SELECT instructor_id FROM instructor_info WHERE instructor_name LIKE '%$name%'");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($instructor_id); 
         $stmt->fetch();
         $stmt->close();
        
        
         $stmt = $dbMain ->prepare("SELECT count(*) as count  FROM pt_sessions_performed WHERE instructor_id = '$instructor_id' AND (session_date BETWEEN '$this->dateStart' AND '$this->dateEnd')");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($count); 
         $stmt->fetch();
         $stmt->close();
         
         $stmt = $dbMain ->prepare("SELECT count(*) as count  FROM pt_training_assesments_performed WHERE instructor_id = '$instructor_id' AND (session_date BETWEEN '$this->dateStart' AND '$this->dateEnd')");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($count2); 
         $stmt->fetch();
         $stmt->close();
         
         //echo "c $count c $count2  xx";
         
         if ($count > 0){
            $this->payrollResult += $count;
         }
         if ($count2 > 0){
            $this->payrollResult += $count2;
         }
    }
    
    if($this->payrollResult == ''){
        $stmt = $dbMain ->prepare("SELECT SUM(commission) as sum  FROM commission_records WHERE user_id = '$this->userId' AND (sale_date_time BETWEEN '$this->dateStart' AND '$this->dateEnd')");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($sum); 
         $stmt->fetch();
         $stmt->close();
         
         if ($sum > 0){
            $this->payrollResult += $sum;
         }
        
    }

}
//----------------------------------------------------------------------------------------------------------------------
function loadUsers() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT user_id, id_card  FROM basic_compensation WHERE type_key = '$this->typeKey' AND payment_cycle= '$this->payrollCycle'");
         $stmt->execute();      
         $stmt->store_result(); 
         $stmt->bind_result($user_id, $id_card); 
         
         while ($stmt->fetch()) {    
                   $this->userId = $user_id;
                   $this->idCard = $id_card;
                   $this->loadHours();
                  }

}
//-----------------------------------------------------------------------------------------------------------------------
function loadTypeKeys() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT type_key  FROM employee_type WHERE $this->whereSql");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($type_key); 
             
             while ($stmt->fetch()) { 
                       $this->typeKey = $type_key;
                       $this->loadUsers();
                      }

}
//-----------------------------------------------------------------------------------------------------------------------
function loadPayrollCount() {

if($this->clubLocation == 0) {
   $this->whereSql = "club_id = '0' ";
   $this->loadTypeKeys();
   }else{
   $this->whereSql = "club_id = '$this->clubLocation' ";
   $this->loadTypeKeys();
   }


}
//-----------------------------------------------------------------------------------------------------------------------
function getPayrollResult() {
       return($this->payrollResult);
       }


}
//#####################################
$club_location = $_REQUEST['club_location'];
$payroll_cycle = $_REQUEST['payroll_cycle'];
$date_start = $_REQUEST['date_start'];
$date_end = $_REQUEST['date_end'];
$sid = $_REQUEST['sid']; 

//echo "d $date_start d $date_end";
//exit;

$checkPay = new payrollCheck();
$checkPay-> setPayrollCycle($payroll_cycle);
$checkPay-> setClubLocation($club_location);
$checkPay-> setDateStart($date_start);
$checkPay-> setDateEnd($date_end);
$checkPay-> loadPayrollCount();
$payroll_result = $checkPay-> getPayrollResult();

if($payroll_result == "") {
   $payroll_result = "1";
   }else{
   $payroll_result = "4";
   }

echo"$payroll_result";

?>