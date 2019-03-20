<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include  "../dbConnect.php";  
 $type = $_REQUEST['type'];       
$drops = $_REQUEST['drops'];
$criterior  = $_REQUEST['criterior'];
 $sid = $_REQUEST['sid']; 
$nameStrng = trim($drops);
$dropDescription = urldecode($drops);
   

   
$searchString = trim($criterior);  

//set up  sql statement to see if records exist
switch ($type) {
    case 1:
    
        $searchStringArray = preg_split('/\s+/', $searchString);
        $searchString1 = $searchStringArray[0];
        $searchString2 = $searchStringArray[1];
           
        $result1 = $dbMain ->query("SELECT * FROM employee_info WHERE emp_fname LIKE '%$searchString1%'  AND emp_lname LIKE '%$searchString2%' "); 
        $message = 1;
        break;
            
    case 2:
        $searchStringArray = explode("|", $searchString);
        $searchString = $searchStringArray[0];
        $result1 = $dbMain ->query("SELECT * FROM basic_compensation WHERE type_key ='$searchString'");
        $message = 2;
        break;
        
    case 3:    
        $result1a = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE club_id = '$searchString'");
        $result1a->execute();      
        $result1a->store_result(); 
        $result1a-> bind_result($type_key);
        
        while ($result1a ->fetch()) {             
                 $result1 = $dbMain ->prepare("SELECT  COUNT(user_id) AS user_id  FROM basic_compensation WHERE type_key = '$type_key'");
                 $result1->execute();      
                 $result1->store_result(); 
                 $result1-> bind_result($user_id);
                 $result1->fetch();
                            if($user_id != 0) {
                               $count .= $user_id;
                              }
                                                      
               }
                                    
         $message = 3;
       
        break;        
    case 4:
        $result1 = $dbMain ->query("SELECT * FROM employee_info");
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
       $_SESSION['drop_description'] = $dropDescription;
       $message = 4;
       echo"$message";
       }

//close result set 
$result1->close();
//close connection 
$dbMain->close();

exit;
     
?>