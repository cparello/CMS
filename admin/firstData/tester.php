<?php

require"../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT exp_bool, max_retries, nsf_bool FROM billing_gateway_main_fields WHERE gateway_key= '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($ccExpOverideBool, $maxRetries, $nsf_bool);
$stmt->fetch();
$stmt->close();

$stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, payment_type, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_year, transaction_type FROM billing_scheduled_recuring_payments WHERE response = '999' AND contract_key != '' AND processed = 'Y' AND club_id = '3551' AND outstanding_balance = 'Y'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($payment_id, $contract_key, $payment_type, $attempt_number, $billing_amount, $cycle_start_day, $cycle_start_month, $cycle_start_year, $transaction_type);
while($stmt99->fetch()){


        $stmt = $dbMain ->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key= '$contract_key'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_fname, $card_lname, $card_number, $card_exp_date);
        $stmt->fetch();
        $stmt->close();
                    
        $expDateSecs = strtotime($card_exp_date);
        $todayDateTest = date('Y-m-d H:i:s');
        $todayDateTestSecs = strtotime($todayDateTest);
                    
                    
                    echo "<br><br>key $contract_key*************exp Date secs $expDateSecs  TODAY SECS $todayDateTestSecs**BOOL $ccExpOverideBool***********";
                    
                    if($expDateSecs >= $todayDateTestSecs OR $ccExpOverideBool == 'Yes'){
                        echo "<br> BILLED <br>";
                    }

}
?>