<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";          
   
$type = $_REQUEST['type'];
$criterior = $_REQUEST['criterior'];
$sid = $_REQUEST['sid'];
   
   
$searchString = trim($criterior);  

//set up  sql statement to see if records exist
switch ($type) {
    case 1:
        $result1 = $dbMain ->query("SELECT * FROM employee_type WHERE employee_type LIKE '%$searchString%'"); 
        $message = 1;
        break;
    case 2:
        if($searchString != "0") {
        $result1 = $dbMain ->query("SELECT * FROM employee_type WHERE club_id ='$searchString'");
        }else{
        $result1 = $dbMain ->query("SELECT * FROM employee_type");
        }
        $message = 2;
        break;
    case 3:
        $result1 = $dbMain ->query("SELECT * FROM employee_type");
        $message = 3;
        break;        
      }


   
   
// check to see if the record exists 
$row_count = $result1 ->num_rows; 
     if($row_count == 0) {
       echo"$message";
       }else{     
       $_SESSION['submit_button'] = $message;
       $_SESSION['search_string']  = $searchString;
       $message = 4;
       echo"$message";
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>