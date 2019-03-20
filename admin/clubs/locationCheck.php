<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";    
      
$loc_id = $_REQUEST['loc_id'];  
$sid = $_REQUEST['sid'];

$loc_id = trim($loc_id);  

   
   
// check to see if the user name and password exist   
$result1 = $dbMain ->query("SELECT * FROM club_info WHERE club_id ='$loc_id' "); 
$row_count = $result1 ->num_rows; 

    if($row_count != 0) {
       $message = 1;
       }else{
       $message = 4;
       }

       echo"$message";
//close connection 
$dbMain->close();

exit;
     
?>