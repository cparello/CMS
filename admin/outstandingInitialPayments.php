<?php

	require"dbConnect.php";

 $counter = 1;

$stmt2 = $dbMain ->prepare("SELECT contract_key, balance_due, todays_payment, min_total_due  FROM initial_payments WHERE due_status ='G' AND process_date > '2015-01-01 00:00:00'  AND process_date < '2016-01-01 00:00:00' ORDER BY contract_key ASC");
$stmt2->execute();      
$stmt2->store_result();      
$stmt2->bind_result($contract_key, $balance_due, $todays_payment, $min_total_due);    

while($stmt2->fetch()) {
            $stmt222 = $dbMain ->prepare("SELECT card_number, card_exp_date  FROM credit_info WHERE contract_key = '$contract_key'");
            $stmt222->execute();      
            $stmt222->store_result();      
            $stmt222->bind_result($card_number, $card_exp_date );    
            $stmt222->fetch();
            $stmt222->close();
            
            $card_number = trim($card_number);
            
            $card_exp_date = date('m/y',strtotime($card_exp_date));
            
            if($card_number != "" AND $balance_due > 0.00 AND $min_total_due != $todays_payment){
                $tot += $balance_due;
                 echo "#$counter contract_key: $contract_key  BAL: $balance_due AMT Paid: $todays_payment Min Tot Due: $min_total_due CC: $card_number EXPDATE: $card_exp_date<br>";
                 $counter++;
            }
            
           
         
        }
        echo "total $tot";

$stmt2->close();



?>