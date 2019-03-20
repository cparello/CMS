<?php
session_start();


class monthlyBillingSelector {


function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}


//===============================================================================================
function countRecord(){
$dbMain = $this->dbconnect();

               // echo "test";
$stmt999 = $dbMain->prepare("SELECT DISTINCT contract_key FROM batch_recurring_records  WHERE contract_key != '' AND club_id = '3552'");//>=
$stmt999->execute();     
$stmt999->store_result();      
$stmt999->bind_result($this->contractKey); 
while($stmt999->fetch()){
    //echo "fubar<br>";
    $contract_location = "Media Center";
    $club_id = "3551";
    
    $sql = "UPDATE contract_info SET club_id = ?, contract_location = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ss',  $club_id, $contract_location);
    $stmt->execute();
    $stmt->close(); 
    
    $sql = "UPDATE account_status SET club_id = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s',  $club_id);
    $stmt->execute();
    $stmt->close(); 
    
    $sql = "UPDATE sales_info SET location_id = ?, contract_location = ? WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ss',  $club_id, $contract_location);
    $stmt->execute();
    $stmt->close(); 
    
    $this->contractKey = "";
                         
}
$stmt999->close();
}

//===============================================

}

    
    $upload = new monthlyBillingSelector();
    $upload->countRecord();
    
   

?>