<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          
   
$type = $_REQUEST['type'];
$criterior  = $_REQUEST['criterior'];
 $sid = $_REQUEST['sid'];  
   
$searchString = trim($criterior);  

//set up  sql statement to see if records exist
switch ($type) {
    case 1:
        $result1 = $dbMain ->query("SELECT * FROM service_info WHERE service_type LIKE '%$searchString%'"); 
        $message = 1;
        break;
    case 2:
        $result1 = $dbMain ->query("SELECT * FROM service_info WHERE club_id ='$searchString'");
        $message = 2;
        break;
     case 3:
        $result1 = $dbMain ->query("SELECT * FROM service_info WHERE group_type ='$searchString'");
        $message = 3;
        break;              
    case 4:
        $result1 = $dbMain ->query("SELECT * FROM service_info");
        $message = 4;
        break;        
      }


   
   
// check to see if the record exists 
$row_count = $result1 ->num_rows; 
     if($row_count == 0) {
       echo"$message";
       }else{     
       $_SESSION['submit_button'] = $message;
       $_SESSION['search_string']  = $searchString;
       $message = 5;
       echo"$message";
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>