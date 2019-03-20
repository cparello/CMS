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

        $this->file = "\"contractKey\",\"club id\"\n";


        // echo "test";
        $stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key FROM contract_info  WHERE contract_key != ''");//>=
        $stmt999->execute();
        $stmt999->store_result();
        $stmt999->bind_result($this->contractKey);
        while($stmt999->fetch()){
            //echo "fubar<br>";

            $stmt = $dbMain->prepare("SELECT contract_location, MAX(contract_date) FROM contract_info  WHERE contract_key = '$this->contractKey'");//>=
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($contract_location, $contract_date);
            $stmt->fetch();
            $stmt->close();

            $stmt = $dbMain->prepare("SELECT club_id FROM club_info  WHERE club_name = '$contract_location'");//>=
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($club_id);
            $stmt->fetch();
            $stmt->close();

            echo "\"$this->contractKey\",\"$club_id\"<br>";
            $this->file .= "\"$this->contractKey\",\"$club_id\"\n";

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