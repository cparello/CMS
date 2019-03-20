<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "dbConnect.php";          

$user = $_REQUEST['user'];
$pass = $_REQUEST['pass']; 
 $sid = $_REQUEST['sid'];
   
$user = trim($user);  
$pass = trim($pass);
   
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_name ='$user' AND pass_word= '$pass'"); 
$row_count = $result1 ->num_rows; 

     if($row_count == 0) {
       $message = 1;
       echo"$message";
       }else{     
       $message = 2;
       $row1 = $result1 ->fetch_array(MYSQLI_NUM);
       $userId = $row1[0];
       $result2 = $dbMain ->query("SELECT  file_perm, first_name FROM access_level WHERE  user_id = '$userId'"); 
       $row2 = $result2 ->fetch_array(MYSQLI_NUM);
       $filePerm = $row2[0];
       $firstName = $row2[1];
       $_SESSION['file_permissions'] = $filePerm;
       $_SESSION['perm_check'] = $filePerm;
       $_SESSION['user_name'] = $user;
       $_SESSION['user_id'] = $userId;
       $_SESSION['user_fname'] = $firstName;
       echo"$message";    
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>