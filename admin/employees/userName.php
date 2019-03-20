<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          
 
$user = $_REQUEST['user'];
$pass  = $_REQUEST['pass'];  
  $sid = $_REQUEST['sid'];  
$user = trim($user);  
$pass = trim($pass);
 
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_name ='$user'"); 
$row_count = $result1 ->num_rows; 

     if($row_count != 0) {
       $message = 1;
       echo"$message";
       }else{     
       $message = 2;
       //sets the access level from the check boxes
       $_SESSION['access_level'] = $acs;
       echo"$message";
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>