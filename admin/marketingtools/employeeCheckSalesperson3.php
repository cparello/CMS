<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include  "../dbConnect.php";          
  
$type = $_REQUEST['type'];
$sid = $_REQUEST['sid'];
$search_string = $_REQUEST['search_string'];
   
$searchString = urldecode($search_string);   
$searchString = trim($searchString);  

unset($_SESSION['search_string']);
unset($_SESSION['submit_button']);


//set up  sql statement to see if records exist
switch ($type) {
    case 1:    
        $nameStringArray = preg_split('/\s+/', $searchString);
        $nameString1 = $nameStringArray[0];
        $nameString2 = $nameStringArray[1]; 
        
        if($nameString2 != "") {        
          $result1 = $dbMain ->query("SELECT * FROM employee_info WHERE emp_fname LIKE '%$nameString1%'  AND emp_lname LIKE '%$nameString2%' "); 
          $message = 1;
          }else{
          $result1 = $dbMain ->query("SELECT * FROM employee_info WHERE  emp_lname LIKE '%$nameString1%' ");
          $message = 1;
          }
        break;           
    case 2:    
        $result1 = $dbMain ->query("SELECT * FROM basic_compensation WHERE id_card ='$searchString'");
        $message = 2;
        break;              
      }
   

// check to see if the record exists 
$row_count = $result1->num_rows; 
     if($row_count == 0) {
       echo"$message";
       }else{     
        $_SESSION['submit_button'] = $message;
        $_SESSION['search_string'] = $searchString;
       $message = 4;
       echo"$message";
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>