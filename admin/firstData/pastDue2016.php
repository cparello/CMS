<?php

//error_reporting(E_ALL);
session_start();

class pastDueSelector {

    function dbconnect()   {
        require"../dbConnect.php";
        return $dbMain;
    }

//===============================================================================================
    function loadMonthlyPayment() {
        $count = 0;
        $dbMain = $this->dbconnect();

        $stmt = $dbMain ->prepare("SELECT billing_amount, monthly_billing_type FROM monthly_payments  WHERE contract_key = '$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->billingAmount, $this->monthlyBillingType);
        $stmt->fetch();
        $stmt->close();
    }
//===============================================================================================
    function checkAccountStatus() {
        $count = 0;
        $dbMain = $this->dbconnect();

        $stmt = $dbMain ->prepare("SELECT MONTH(start_date), MAX(end_date), service_id FROM monthly_services WHERE contract_key='$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->monthStart, $end_date, $service_id);
        $stmt->fetch();
        $stmt->close();

        $stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$service_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->statusCount);
        $stmt->fetch();
        $stmt->close();
    }
//==================================================================================================
    function checkSettledPaymentsCount() {

        $dbMain = $this->dbconnect();
        $settledPaymentAmount = 0;

        $this->numberMonthsOwed = 0;
        $this->overages = 0;

        for($i=1;$i<=2;$i++){

            //echo "$i";
            $billingDate = date('Y-m-d H:i:s',mktime(23,59,59,$i,25,2016));
            $billingDateSecs = strtotime($billingDate);
            $signUpSecs = strtotime($this->signup);



            $stmt = $dbMain ->prepare("SELECT count(*), SUM(payment_amount) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$i' AND YEAR (payment_date) = '2016' AND (payment_description LIKE '%Settled%' OR payment_description LIKE '%Prepaid%' OR payment_description LIKE '%Past Due%'  OR payment_description LIKE '%Past Monthly%')  AND payment_description NOT LIKE '%Fee%'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($SettledCount, $payment_amount);//Settled  Prepaid    Past Due
            $stmt->fetch();
            $stmt->close();

            $settledPaymentAmount += $payment_amount;

            if ($SettledCount > 0){
                $payments = $payment_amount / $this->billingAmount;
                $extraPayments = round($payments, 0, PHP_ROUND_HALF_DOWN);
                $this->overages += $extraPayments;
            }


            $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$i' AND YEAR (payment_date) = '2016' AND (payment_description = 'EFT Credit' OR payment_description = 'Monthly Dues CC' OR payment_description = 'Monthly Dues ACH' OR payment_description = 'EFT ACH'  OR payment_description = 'Monthly Dues Cash')");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            //echo "testvsvsd";
            if ($count <= 0 AND $billingDateSecs > $signUpSecs){
                $this->numberMonthsOwed++;
                $this->dueDate = date('Y-m-d',mktime(0,0,0,$i,25+6,2016));
            }elseif($count > 0){
                $overCount = $count-1;
                $this->overages += $overCount;
            }elseif($billingDateSecs <= $signUpSecs){
                $count = "X";
            }



            $stmt = $dbMain ->prepare("SELECT count(*), payment_date FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$i' AND YEAR (payment_date) = '2016' AND (payment_description LIKE '%New Service%')");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($newCount, $payment_date);//Settled  Prepaid    Past Due
            $stmt->fetch();
            $stmt->close();

            $payment_date = strtotime($payment_date);

            if ($newCount > 0 AND $count <= 0 AND $billingDateSecs > $payment_date){
                $this->overages ++;
            }



            //echo "ckey $this->contractKey month $i count $count  SETTLED AMOUNT $payment_amount  MONTHLY<br>";

            $count = "";
            $SettledCount = "";
            $payment_amount = "";
            $newCount = "";

        }
        $moneyOwed = $this->numberMonthsOwed * $this->billingAmount;

        if($settledPaymentAmount > 0 AND $settledPaymentAmount > $moneyOwed){
            $this->extraMoneies = $settledPaymentAmount - ($moneyOwed);
        }else{
            $this->extraMoneies = 0;
        }

//echo "next due date $next_payment_due_date <br>";

    }
//==================================================================================================
    function checkRateFeeSettledPaymentsCount() {

        $dbMain = $this->dbconnect();

        $this->numberRGMonthsOwed = 0;
        //echo "$i";$this->signup
        $signup_dateSecs = strtotime($this->signup);
        $rateStartSecs = strtotime('01/01/2016');
        if($signup_dateSecs < $rateStartSecs){

                    $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND YEAR (payment_date) = '2016' AND (payment_description = 'Guarantee Fee CC' OR payment_description = 'Guarantee Fee ACH' OR payment_description = 'Guarantee Fee Credit' OR payment_description = 'Guarentee Fee ACH' OR payment_description = 'Guarentee Fee CC' OR payment_description = 'Guarentee Fee Credit' OR payment_description = 'Rate Guarentee CC')");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();
                    //echo "testvsvsd";
                    if ($count <= 0){
                        $this->numberRGMonthsOwed++;
                    }

        }
//echo "next due date $next_payment_due_date <br>";

    }
//==============================================================================================
    function fileMaker(){

        $dbMain = $this->dbconnect();
        $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM monthly_services WHERE contract_key !='' AND service_name LIKE '%Membership%'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->contractKey);
        while($stmt->fetch()){
            $this->checkAccountStatus();

            if($this->statusCount >= 1){

                $this->loadMonthlyPayment();

                if($this->monthlyBillingType == 'CR') {
                    $transactionType = "CC";
                }else {                                                     //if($monthly_billing_type == 'BA')
                    $transactionType = "ACH";
                }


                $this->checkRateFeeSettledPaymentsCount();
                $this->checkSettledPaymentsCount();

                $tempBuff = $this->numberMonthsOwed - $this->overages;
                if($tempBuff < 0){
                    $tempBuff = 0;
                }

                $totalOwed = ($tempBuff * $this->billingAmount)+($this->numberRGMonthsOwed * 19.00);
                $totalOwed = $totalOwed - $this->extraMoneies;

                echo "\"$this->contractKey\",\"$totalOwed\",\"$this->dueDate\"<br>";

                //echo "test";
                //exit;


            }

            $this->numberMonthsOwed = "";
            $this->overages = "";
            $this->billingAmount = "";
            $this->contractKey = "";
            $this->statusCount = "";
            $this->monthStart = "";
            $this->monthlyBillingType = "";
        }
        $stmt->close();

        //  }

        echo "teste BIG TOT $this->bigTotal unbillable $this->unbillable";
        echo "UNBILLABLE $this->unbillableArray";
    }
//===============================================
}
//echo "test";
//exit;
$upload = new pastDueSelector();
$upload->fileMaker();

?>