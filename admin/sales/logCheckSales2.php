<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================

//==============================================end timeout
include  "../dbConnect.php";

$id_card = $_REQUEST['id_card'];          
$sid = $_REQUEST['sid'];   
$id_card = trim($id_card);  

// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT user_id, type_key FROM basic_compensation WHERE id_card ='$id_card'"); 
$row_count = $result1 ->num_rows;  

   
 if($row_count == 0) {
       $message = 1;
       $dbMain->close();     
       echo"$message";     
       exit;
       
    }else{        
   
          // check to see if the user name and password exist  
           $row1 = $result1 ->fetch_array(MYSQLI_NUM);
           $userId = $row1[0];
           $typeKey = $row1[1];
           
           $result2 = $dbMain ->query("SELECT user_name FROM admin_passwords WHERE user_id ='$userId'");
           $row2 = $result2 ->fetch_array(MYSQLI_NUM);
           $userName = $row2[0];
   
           $result3 = $dbMain ->query("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$typeKey'");
           $row3 = $result3 ->fetch_array(MYSQLI_NUM);
           $employeeType = $row3[0];
           $locationId = $row3[1];
           
               if (preg_match("/sales/i", $employeeType)) {
                   $message = 2;
                   $_SESSION['location_id'] = $locationId; 
                  }   
   
           if($message != 2) {
              $message = 1;
              $dbMain->close(); 
              echo"$message";            
              exit;         
             }elseif($message == 2) {       
                  $result4 = $dbMain ->query("SELECT  emp_fname  FROM employee_info WHERE  user_id = '$userId'"); 
                  $row4 = $result4 ->fetch_array(MYSQLI_NUM);
                  $firstName = $row4[0];  
                  $_SESSION['user_name'] = $userName;
                  $_SESSION['user_id'] = $userId;
                  $_SESSION['user_fname'] = $firstName; 
                  $_SESSION['id_card'] = $id_card; 
                  $dbMain->close();                 
                  echo"$message";  
                  exit;
             }
   
  }   
     
?>