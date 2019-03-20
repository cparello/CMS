<?php

class fixCancellationFubar{

//connect to database
function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}
//==============================================================================================
function fileMaker(){
  /*  
$dbMain = $this->dbconnect();


$totCount = 0;
$stmt = $dbMain ->prepare("SELECT contract_key FROM billing_scheduled_recuring_payments WHERE cycle_start_month = '08' AND cycle_start_day = '25' AND cycle_start_year = '2014'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key); 
while($stmt->fetch()){
    $count = 1;
    $stmt99 = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_recuring_payments WHERE cycle_start_month = '11' AND cycle_start_day = '25' AND cycle_start_year = '2014' AND contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($count); 
    $stmt99->fetch();
    $stmt99->close();
    
    if($count == 0){
        echo "ckey $contract_key<br>";
        $totCount++;
    }
    $contract_key = "";
}
$stmt->close();
      echo "totCount $totCount";*/
      $email = "christopherparello@gmail.com";
      $mem_fname = "chris";
      $mem_lname = "parello";
      mail("$email", "Complimentary Personal Training",

                "Hello, $mem_fname $mem_lname 
                
                You have been offered a complimentary Personal Training session as a thanks for being a member of Burbank Athletic Club. Please call (818) 563-4203 to schedule an appointment. You can also email chris@burbankathleticclub.com.
                
                
                Thank you,
                Burbank Athletic Club
                Personal Training Department
                
                (c)BAC.",
                "From: BAC PT Department<chris@burbankathleticclub.com>","-fchris@burbankathleticclub.com");  
      

}
//==============================================================================================
}
$makeFile = new fixCancellationFubar();
$makeFile->fileMaker();

?>