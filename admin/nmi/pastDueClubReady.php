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

        $stmt = $dbMain ->prepare("SELECT billing_amount, monthly_billing_type, DAY(cycle_date) FROM monthly_payments  WHERE contract_key = '$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->billingAmount, $this->monthlyBillingType, $this->billDay);
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

        $monthsArray = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $yearArray = array(2015, 2016);

        foreach($yearArray as $year){
            foreach($monthsArray as $month){
                if($year != 2016 AND $month != 3){

                    $billingDate = date('Y-m-d H:i:s',mktime(23,59,59,$month,$this->billDay,$year));
                    $billingDateSecs = strtotime($billingDate);

                    $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$month' AND YEAR (payment_date) = '$year' AND (payment_description = 'EFT Credit' OR payment_description = 'Monthly Dues CC' OR payment_description = 'Monthly Dues ACH' OR payment_description = 'EFT ACH'  OR payment_description = 'Monthly Dues Cash')");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();

                    $stmt = $dbMain ->prepare("SELECT count(*), payment_date FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$month' AND YEAR (payment_date) = '$year' AND (payment_description LIKE '%New Service%')");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($newCount, $payment_date);//Settled  Prepaid    Past Due
                    $stmt->fetch();
                    $stmt->close();

                    $payment_date = strtotime($payment_date);

                    if($count == 0){
                        if ($newCount == 1 AND  $billingDateSecs > $payment_date){
                            $this->row .= "$this->contractKey, $month-$this->billDay-$year, $this->billingAmount, Monthly <br>";
                            $this->total += $this->billingAmount;
                        }elseif($newCount == 0){
                            $this->row .= "$this->contractKey, $month-$this->billDay-$year, $this->billingAmount, Monthly <br>";
                            $this->total += $this->billingAmount;
                        }
                    }

                    $stmt = $dbMain ->prepare("SELECT count(*), SUM(payment_amount) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND MONTH (payment_date) = '$month' AND YEAR (payment_date) = '$year' AND (payment_description LIKE '%Settled%' OR payment_description LIKE '%Prepaid%' OR payment_description LIKE '%Past Due%'  OR payment_description LIKE '%Past Monthly%')  AND payment_description NOT LIKE '%Fee%'");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($settledCount, $payment_amount);//Settled  Prepaid    Past Due
                    $stmt->fetch();
                    $stmt->close();

                    if ($settledCount > 0){
                        $this->row .= "$this->contractKey, $month-$year, $payment_amount, Past Dues <br>";
                        $this->totalPayments += $payment_amount;
                        
                    }

            }

          }
        }

    }
//==================================================================================================
    function checkRateFeeSettledPaymentsCount() {

        $dbMain = $this->dbconnect();

        $stmt = $dbMain ->prepare("SELECT count(*), eft_cycle FROM member_guarantee_eft WHERE  contract_key='$this->contractKey'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($rateCount, $eftCrazy);//Settled  Prepaid    Past Due
        $stmt->fetch();
        $stmt->close();

        if($rateCount >= 1){
            $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND YEAR (payment_date) = '2015' AND MONTH (payment_date) = '1' AND (payment_description = 'Guarantee Fee CC' OR payment_description = 'Guarantee Fee ACH' OR payment_description = 'Guarantee Fee Credit' OR payment_description = 'Guarentee Fee ACH' OR payment_description = 'Guarentee Fee CC' OR payment_description = 'Guarentee Fee Credit' OR payment_description = 'Rate Guarentee CC')");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            if ($count == 0){
                $this->row .= "$this->contractKey, 1-15-2015, 19, Rate Fee <br>";
                $this->total += 19;
            }

            $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND YEAR (payment_date) = '2015' AND MONTH (payment_date) = '7' AND (payment_description = 'Guarantee Fee CC' OR payment_description = 'Guarantee Fee ACH' OR payment_description = 'Guarantee Fee Credit' OR payment_description = 'Guarentee Fee ACH' OR payment_description = 'Guarentee Fee CC' OR payment_description = 'Guarentee Fee Credit' OR payment_description = 'Rate Guarentee CC')");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            if ($count == 0){
                $this->row .= "$this->contractKey, 7-15-2015, 19, Rate Fee <br>";
                $this->total += 19;
            }

            $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND YEAR (payment_date) = '2016' AND MONTH (payment_date) = '1' AND (payment_description = 'Guarantee Fee CC' OR payment_description = 'Guarantee Fee ACH' OR payment_description = 'Guarantee Fee Credit' OR payment_description = 'Guarentee Fee ACH' OR payment_description = 'Guarentee Fee CC' OR payment_description = 'Guarentee Fee Credit' OR payment_description = 'Rate Guarentee CC')");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            if ($count == 0){
                $this->row .= "$this->contractKey, 1-15-2016, 19, Rate Fee <br>";
                $this->total += 19;
            }
            
            if($eftCrazy == 'A'){
                $stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE payment_flag ='PF' AND contract_key='$this->contractKey' AND YEAR (payment_date) = '2016' AND MONTH (payment_date) = '3' AND (payment_description = 'Guarantee Fee CC' OR payment_description = 'Guarantee Fee ACH' OR payment_description = 'Guarantee Fee Credit' OR payment_description = 'Guarentee Fee ACH' OR payment_description = 'Guarentee Fee CC' OR payment_description = 'Guarentee Fee Credit' OR payment_description = 'Rate Guarentee CC')");
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                if ($count == 0){
                    $this->row .= "$this->contractKey, 3-15-2016, 19, Rate Fee <br>";
                    $this->total += 19;
                } 
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
            $this->row = "";
            $this->totalPayments = 0;
            $this->total = 0;
            $this->checkAccountStatus();

            if($this->statusCount >= 1){

                $this->loadMonthlyPayment();

                $this->checkRateFeeSettledPaymentsCount();
                $this->checkSettledPaymentsCount();

                if($this->totalPayments >= $this->total){
                    $owed = 0;
                }else{
                    $owed = $this->total - $this->totalPayments;
                }

                echo "$this->row$this->contractKey,$this->total,$this->totalPayments,$owed<br>";

                $this->rows .= $this->row;



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