<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          
   
$user = $_REQUEST['user'];
$pass = $_REQUEST['pass'];   
$sid = $_REQUEST['sid']; 
   
$user = trim($user);  
$pass = trim($pass);
   
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM  interface_passwords WHERE user_name ='$user' AND pass_word= '$pass'"); 
$row_count = $result1 ->num_rows; 

     if($row_count == 0) {
         $message = 1;
         $dbMain->close();     
         echo"$message";     
         exit;
       
         }else{
       
        $row1 = $result1 ->fetch_array(MYSQLI_NUM);
        $location_id = $row1[0];      
        $_SESSION['location_id'] = $location_id;  
        $dbMain->close();
        $message = 2;
        echo"$message";     
        exit;                                                                                                                  
      }
 
?>