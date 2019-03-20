<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";    

$id_card = $_REQUEST['id_card'];  
$sid = $_REQUEST['sid'];
   
$id_card = trim($id_card);  
//$inuse_message = 1;
//$allgood_message = 2;
$message = 2;
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT count(*) FROM basic_compensation WHERE id_card ='$id_card'"); 
$row = $result1->fetch_row();
$row_count = $row[0];

     if($row_count != 0) {
        $message = 1;      
       }else{              
         $result2 = $dbMain ->query("SELECT count(*) FROM member_info WHERE member_id ='$id_card'"); 
         $row2 = $result2->fetch_row();
         $row_count2 = $row2[0];
           
          if($row_count2 != 0) {
              $message = 1;         
             }     
       }
echo "$message";
//close result set 
//$result1->close();
//$result2->close();
//close connection 
$dbMain->close();

exit;
     
?>