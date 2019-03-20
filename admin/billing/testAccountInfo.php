<?php


//------------------------------------------------------------------------------
//takes care of cancelations and their cost
if(isset($_POST['cancel'])) {

//loop through the check boxes
foreach ($_POST['cancel'] as $value) {

               $valueArray = explode("|", $value);
               $salt = $valueArray[0];
               $club_id = $valueArray[1];
               $service_key = $valueArray[2];

               $cancel_cost= $_POST["cancel_cost$salt"];

                    echo"$club_id  $service_key $cancel_cost <br>";

    }
}

//-----------------------------------------------------------------------------------
//this takes care of  time credits to accounts
  for ($i = 0, $t = $billing_field_count; $i < $t; $i++) {    
  
      if(isset($_POST["serv_num$i"])) {  
      
           $credit_number = $_POST["serv_num$i"];
           
             if($credit_number != "") {
                $duration_type = $_POST["serv_credit$i"];
                $service_info = $_POST["serv_keys$i"];
                
                
                 echo"$credit_number  $duration_type  $service_info<br>";             
                }
                           
   
           }
   
   
      }

//------------------------------------------------------------------------------------
//takes care of holds
if(isset($_POST['hold'])) {

//loop through the check boxes
foreach ($_POST['hold'] as $value) {

               $valueArray = explode("|", $value);
               $salt = $valueArray[0];
               $club_id = $valueArray[1];
               $service_key = $valueArray[2];

               echo"$club_id  $service_key $cancel_cost <br>";
          }

}

//-------------------------------------------------------------------------------------
//takes care of members subtracted from groups
if(isset($_POST['cancel_mem'])) {

foreach ($_POST['cancel_mem'] as $value) {

               $valueArray = explode("|", $value);
               $member_id = $valueArray[0];
               $member_name = $valueArray[1];
               $member_street = $valueArray[2];
               $member_dob = $valueArray[3];
               $contract_key = $valueArray[4];

               echo"$member_id  $member_name $member_street $member_dob $contract_key<br>";
          }
}

//--------------------------------------------------------------------------------------

?>