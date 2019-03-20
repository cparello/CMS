<?php
class fixRejectedPayFubar {
                         
//connect to database
function dbconnect()   {
require"dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------
function fixBugs() {

$dbMain = $this->dbconnect();
 echo "test <br>";
$stmt99 = $dbMain->prepare("SELECT contract_key, history_key, payment_amount, transaction_type, reject_message, process_attempts, transaction_id, last_attempt_date, reject_bit FROM rejected_payments WHERE contract_key !=''");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($contract_key, $history_key, $payment_amount, $transaction_type, $reject_message, $process_attempts, $transaction_id, $last_attempt_date, $reject_bit); 
while($stmt99->fetch()){
            $month = date('m',strtotime($last_attempt_date));
            $year = date('Y',strtotime($last_attempt_date));
            $day = date('d',strtotime($last_attempt_date));
            
            if($history_key == 0){
                //set Bi and 38.00 NS '2015-01-15'
                echo "ckey $contract_key <br>";
                 $stmt = $dbMain->prepare("SELECT history_key, trans_key FROM payment_history WHERE contract_key ='$contract_key' AND payment_flag = 'RE' AND MONTH(payment_date) = '$month' AND YEAR(payment_date) = '$year' AND DAY(payment_date) = '$day'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($history_keyNEW, $trans_key); 
                 $stmt->fetch();
                 $stmt->close();
                echo "test2";
                 $sql = "UPDATE rejected_payments SET history_key = ?, transaction_id = ? WHERE contract_key = '$contract_key' AND MONTH(last_attempt_date) = '$month' AND YEAR(last_attempt_date) = '$year' AND DAY(last_attempt_date) = '$day'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('ss', $history_keyNEW, $trans_key);
                 if(!$stmt->execute())  {
                            	printf("Error:update1E %s.\n", $stmt->error);
                                  }	
                 $stmt->close();
                 echo "test3";
                
            }
            $contract_key = "";
            $history_key = "";
            $payment_amount = "";
            $transaction_type = "";
            $reject_message = "";
            $process_attempts = "";
            $transaction_id = "";
            $last_attempt_date = "";
            $reject_bit = "";
            $history_keyNEW = "";
            $trans_key = "";
            $month = "";
            $year = "";
            $day = "";
}
$stmt99->close();



}

//------------------------------------------------------------------------------------------------------------------

}//end class
//----------------------------------------------------------------------

  $checkPast = new fixRejectedPayFubar();
  $checkPast-> fixBugs();
 
?>
