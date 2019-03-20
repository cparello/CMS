<?php

//error_reporting(E_ALL);
session_start();


class monthlyBillingSelector {


    function dbconnect()   {
        require"../dbConnect.php";
        return $dbMain;
    }


//===============================================================================================
    function countRecord(){
        $dbMain = $this->dbconnect();

        $this->file = "\"contractKey\",\"account_status\",\"service_key\",\"status_date\"\n";


        // echo "test";
        $stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key FROM contract_info  WHERE contract_key != '' ORDER BY contract_key ASC ");//>=
        $stmt999->execute();
        $stmt999->store_result();
        $stmt999->bind_result($this->contractKey);
        while($stmt999->fetch()){
            //echo "fubar<br>";

            $stmt = $dbMain->prepare("SELECT account_status, service_key, status_date FROM account_status  WHERE contract_key = '$this->contractKey'");//>=
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($account_status, $service_key, $status_date);
            while($stmt->fetch()){

                echo "\"$this->contractKey\",\"$account_status\",\"$service_key\",\"$status_date\" <br>";
                $this->file .= "\"$this->contractKey\",\"$account_status\",\"$service_key\",\"$status_date\"\n";
            }
            $stmt->close();





        }

        //insert total projected here
        $stmt999->close();


        $ourFileName = "clubs.csv";
        $ourFileHandle = fopen($ourFileName, 'a');


        fwrite($ourFileHandle, $this->file);

        fclose($ourFileHandle);
    }

//===============================================

}


$upload = new monthlyBillingSelector();
$upload->countRecord();
$billCount = $upload->getCount();


?>