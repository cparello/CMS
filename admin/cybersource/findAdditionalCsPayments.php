<?php

class insertAdditionalCSPayments {

function dbconnectOne()   {
require"../dbConnectOne.php";
return $dbMainOne;
}

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function moveData(){
echo "fubar";

$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT merchant_ref_number FROM temp_cs_insert WHERE source = 'SCMP API' AND (bill_rcode = '1' OR ecp_debit_rcode = '1')");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($merchant_ref_number); 
while($stmt->fetch()){
    $merchant_ref_number2 = '';
    $stmt99 = $dbMain->prepare("SELECT merchant_ref_number FROM temp_cs_insert_sub WHERE merchant_ref_number = '$merchant_ref_number')");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($merchant_ref_number2); 
    $stmt99->fetch();
    $stmt99->close();
    
    if ($merchant_ref_number != $merchant_ref_number){
        echo " $merchant_ref_number <br>";
    }
    
}
$stmt->close();


}
//===========================================================================================================
}
$update = new insertAdditionalCSPayments();
$update->moveData();


?>