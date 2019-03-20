<?php
require"dbConnect.php";

$cKeyArr = array(31404, 32686, 33105,4530,45326,45327,45336,45367,45395 ,45408 ,45451 ,45467 ,45474 ,45486 ,45487 ,45488 ,45515 ,45548 ,45558 ,45590,45592,45593,45610 ,45624,45625 ,45653 ,45699 ,45768,45861,45871 ,45874 ,45954,45962 ,45968 ,45970 ,45980 ,45988 ,45997 ,45999 ,46000 ,46001 ,46002 ,46003 ,46004 ,46005 ,46014 ,46031,46713 ,47019 ,49264 ,49265 ,49268 ,49274 ,52636 ,56229 ,56236 ,56253 ,56254 ,56314 ,56334 ,56347 ,56363 ,56387 ,56406 ,56512 ,56513 ,56519 ,56521 ,56526 ,56527 ,56537 ,56540 ,56548 ,56564 ,56592 ,56596 ,56598 ,56624 ,56627 ,56630 ,56638 ,56650 ,56666 ,56674 ,56684 ,56694 ,56713 ,56719 , 56723 ,56744 ,56777 ,56795 ,56796 ,56804 ,56824 ,56854 ,56857 ,56871 ,56873 ,56874 ,56878 ,56884 ,56915 ,56974 ,56977 ,56995,57006,57010 ,57018 ,57039 ,57057 ,57088 ,57101 ,57125 ,57135 ,57136 ,57157 ,57172);

foreach($cKeyArr as $contractKey){
    $stmt = $dbMain ->prepare("SELECT email, first_name, last_name FROM contract_info WHERE contract_key ='$contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($email, $first_name, $last_name);
            $stmt->fetch();
            $stmt->close();
    
    $message2 = "Hello $first_name $last_name, As part of your membership agreement on July 15th you were to be billed $19.00. This fee was not billed to your account due to a clerical error, we will be billing $19.00 to your account on file in the next few days. 
    
    Thanks,
    Burbank Athletic Club";
    
    $headers  = "From: info@burbankathleticclub.com\r\n";
    $headers .= "Content-type: text/html\r\n";
                
    
    mail($email, "Burbank Athletic Club Payments", $message2, $headers);
    
    $eftCycle = "B";
    $eftCycleDate = "2015-07-15 00:00:00";
    $gauranteeFee = 38.00;
    $sql = "INSERT INTO member_guarantee_eft VALUES (?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('issd', $contractKey, $eftCycle, $eftCycleDate, $gauranteeFee); 
    if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }		
    
    $stmt->close();
    
    
      $email = "";
      $first_name = "";
      $last_name   = "";    
}


?>