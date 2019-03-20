<?php



class  notBilled{

private  $passId =null;
private  $passTitle = null;
private  $duration = null;
private  $passMessage = null;
private  $passDateStart = null;
private  $passDateEnd = null;
private  $passTopic = null;
private  $serviceList = null;
private  $serviceKey = null;
private  $guestPass = null;
private  $guestName = null;
private  $guestPhone = null;
private  $guestEmail = null;
private  $interestOne = null;
private  $interestTwo = null;
private  $barCodeInt = null;
private  $barCodeInsert = null;
private  $barCode = null;
private  $startDate = null;
private  $endDate = null;
private  $saveBit = null;






//connect to database
function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}

//---------------------------------------------------------------------------------------------------------------
function findMissingBillings() {
$count = 1;

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT contract_key FROM billing_scheduled_recuring_payments WHERE cycle_start_month = '07' AND cycle_start_year = '2015' AND payment_type = 'MS'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);
while($stmt->fetch()){
    //echo "test";
    $stmt22 = $dbMain ->prepare("SELECT count(*) FROM billing_scheduled_recuring_payments WHERE cycle_start_month = '08' AND cycle_start_year = '2015' AND payment_type = 'MS' AND contract_key = '$contract_key'");
    $stmt22->execute();      
    $stmt22->store_result();      
    $stmt22->bind_result($count3);
    $stmt22->fetch();
    $stmt22->close();
    if($count3 == 0){
        
        $stmt22 = $dbMain ->prepare("SELECT account_status, service_key FROM account_status WHERE contract_key = '$contract_key' AND (service_key = '203' OR service_key = '262' OR service_key = '257' OR service_key = '276' OR service_key = '283' OR service_key = '284')");//(//service_key = '203)
        $stmt22->execute();      
        $stmt22->store_result();      
        $stmt22->bind_result($account_status, $service_key);
        $stmt22->fetch();
        $stmt22->close();
            //echo "$contract_key $count3 $account_status";
            if($account_status == 'CU'){
                $stmt22 = $dbMain ->prepare("SELECT card_number, MONTH(card_exp_date), YEAR(card_exp_date) FROM credit_info WHERE contract_key = '$contract_key'");//(//service_key = '203)
                $stmt22->execute();      
                $stmt22->store_result();      
                $stmt22->bind_result($card_num, $month, $year);
                $stmt22->fetch();
                $stmt22->close();
                
                $stmt22 = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$contract_key'");//(//service_key = '203)
                $stmt22->execute();      
                $stmt22->store_result();      
                $stmt22->bind_result($monthly_billing_amount);
                $stmt22->fetch();
                $stmt22->close();
                
                
               echo "$contract_key $card_num   $month/$year   $$monthly_billing_amount<br>";
               $count++;
            }
            $account_status = "";
            $service_key = "";
        
        
    }
    $contract_key = "";
    $count3 = "";
    //echo "<br>";
}
$stmt->close();

echo "total $count";

}

//======================================================================================


    
}
//--------------------------------------------------------------------------------------
//echo "fubar";
//;


$saveGuest = new notBilled();
$saveGuest-> findMissingBillings();



?>