<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          

$user_name = $_REQUEST['user_name'];
   
$user_name = trim($user_name);  
  
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT user_id FROM admin_passwords WHERE user_name ='$user_name'"); 
$row_count = $result1 ->num_rows; 
$row = mysqli_fetch_row($result1);
$userId = $row[0];
$result1->close();

     if($row_count == 0) {
       $message = 1;
       }else{ 
  
         $result2 = $dbMain ->prepare("SELECT type_key, id_card  FROM basic_compensation WHERE  user_id = '$userId'"); 
         $result2->execute();      
         $result2->store_result(); 
         $result2->bind_result($typeKey, $idCard);      
         
                      while ($result2 ->fetch()) {   
                      
                                if($typeKey != "") {
                                
                                   $result3 = $dbMain ->query("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$typeKey'");
                                   $row3 = $result3 ->fetch_array(MYSQLI_NUM);
                                   $employeeType = $row3[0];
                                   $clubId = $row3[1];  
                                   
                                   $result4 = $dbMain ->query("SELECT club_name  FROM club_info WHERE club_id = '$clubId'");
                                   $row4 = $result4 ->fetch_array(MYSQLI_NUM);
                                   $clubName = $row4[0];             
                                   
                                   $employeeIdInfo .= "$employeeType $clubName:   $idCard\n";
                                  }
                              }
                                            
  
             mail("$user_name", "Employee ID Confirmation",
             "Below are your Employee ID Number(s):  \n\n $employeeIdInfo",                             
              "FROM:  $user_name");
             
       $message = 2;                
      }
       
     

echo"$message";

exit;
?>