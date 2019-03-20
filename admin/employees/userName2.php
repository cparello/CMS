<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";  
        
$user = $_REQUEST['user'];
$id  = $_REQUEST['id']; 
$sid = $_REQUEST['sid'];   
   
$user = trim($user);  
$id = trim($id);
 
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_name ='$user' AND user_id ='$id'"); 
$row_count = $result1 ->num_rows; 
     if($row_count != 0) {
       $message = 2;
       echo"$message";
       
       //close result set 
       $result1->close();
      
      //close connection 
       $dbMain->close();   
      
       }else{

$result2 = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_name ='$user'"); 
$row_count2 = $result2 ->num_rows; 
     if($row_count2 != 0) {
       $message = 1;
       echo"$message";
       }else{     
       $message = 2;
       echo"$message";
       }
       
       //close result set 
      $result2->close();
      //close connection 
      $dbMain->close();   


exit;
} 
?>