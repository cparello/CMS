<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================

//==============================================end timeout
include "../dbConnect.php"; 
         
$pin = $_REQUEST['pin'];
 $sid = $_REQUEST['sid'];
   
$pin = trim($pin);  

   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM pins WHERE overide_pin_one ='$pin' "); 
$row_count = $result1 ->num_rows; 

     if($row_count == 0) {
       $message = 1;
       echo"$message";
       }else{     
       $message = 2;
       echo"$message";    
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>