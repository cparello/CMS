<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
//date('YmdHis')
$filename = $user_id . '.jpg';
$complete_path = "../employeephotos/$filename";
$result = file_put_contents( $complete_path, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

include  "../dbConnect.php";              
//get the basic member info
$result = $dbMain ->query("SELECT member_photo FROM employee_photo WHERE user_id = '$user_id'"); 
$row_count = $result->num_rows; 

if($row_count == 0) {
   $sql = "INSERT INTO employee_photo VALUES (?, ?)";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('is', $userId, $employeePhoto); 

   $userId = $user_id;
   $employeePhoto = $filename;

    if(!$stmt->execute())  {
       return($this->confirmation_message);
	   printf("Error: %s.\n", $stmt->error);
       }	
$stmt->close();

}


$url = "../employeephotos/$filename";

print "$url\n";

?>
