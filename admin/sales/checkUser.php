<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================

//==============================================end timeout
//checks to see if a user is existing and if it cam from sales or renew script
$orig_user = $_REQUEST['orig_user'];
$user = $_REQUEST['user'];
$sid = $_REQUEST['sid'];

if(isset($orig_user)) {
$original_user = $orig_user;
}else{
$original_user = $_SESSION['user_name'];
}


include  "../dbConnect.php";          
   
$user = trim($user);

// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_name ='$user'"); 
$row_count = $result1 ->num_rows; 

     if($row_count == 0) {
       $message = "1|$original_user";
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
                                                                   $user_flag = 2;                                                                 
                                                                   }
                                                           }        
                                                     }
       
       
                      if($user_flag == 2) {          
                          $message = "2|$user";
                          $dbMain->close(); 
                          echo"$message";
                          exit;    
                       }else{   
                          $message = "3|$original_user";
                          $dbMain->close(); 
                          echo"$message";
                          exit;                              
                       }   
       
       
      }       


 
      

?>