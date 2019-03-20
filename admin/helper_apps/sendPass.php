<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          
   
$user_name = $_REQUEST['user_name'];   
   
$user_name = trim($user_name);  

   
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT pass_word FROM admin_passwords WHERE user_name ='$user_name'"); 
$row_count = $result1 ->num_rows; 
$row = mysqli_fetch_row($result1);
$pass_word = $row[0];
$result1->close();
$dbMain->close();

     if($row_count == 0) {
       $message = 1;
       }else{ 
  
             mail("$user_name", "Password Confirmation",
             "Your login password is:  $pass_word",                             
              "FROM:  $user_name");
             
       $message = 2;                
      }
       
     

echo"$message";

exit;
?>