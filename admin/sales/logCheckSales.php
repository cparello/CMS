<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================

//==============================================end timeout
include  "../dbConnect.php";          

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
       $dbMain->close();     
       echo"$message";     
       exit;
       }else{     
       $row1 = $result1 ->fetch_array(MYSQLI_NUM);
       $userId = $row1[0];      
                 
         $result2 = $dbMain ->prepare("SELECT type_key  FROM basic_compensation WHERE  user_id = '$userId'"); 
         $result2->execute();      
         $result2->store_result(); 
         $result2->bind_result($type_key);      
                                  while ($result2 ->fetch()) {   
                                                 if($type_key != null)  {                                                 
                                                          $result3 = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$type_key'");
                                                          $result3->execute();      
                                                          $result3->store_result(); 
                                                          $result3->bind_result($employee_type, $club_id);    
                                                          $result3 ->fetch();
                                                           //echo"$employee_type $type_key";
                                                                   if (preg_match("/sales/i", $employee_type)) {
                                                                   $message = 2;
                                                                   $_SESSION['location_id'] = $club_id; 
                                                                   }
                                                           }        
                                                     }
 //if tthis is not a sales asociate then deny access                                                    
        if($message != 2) {
           $message = 1;
           $dbMain->close(); 
           echo"$message";            
           exit;         
          }elseif($message == 2) {       
                  $result4 = $dbMain ->query("SELECT  emp_fname  FROM employee_info WHERE  user_id = '$userId'"); 
                  $row4 = $result4 ->fetch_array(MYSQLI_NUM);
                  $firstName = $row4[0];  
                  $_SESSION['user_name'] = $user;
                  $_SESSION['user_id'] = $userId;
                  $_SESSION['user_fname'] = $firstName; 
                  $dbMain->close();                 
                  echo"$message";  
                  exit;
          }
                                                                                                          
   
      }




     
?>