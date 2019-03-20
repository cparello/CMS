<?php
session_start();


class  changeCorpFlag{

function setContractKey($contractKey) {
          $this->contractKey = $contractKey;
          }
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function changeFlag() {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM corporate_flag WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
 if($count == 0){
    $sql = "INSERT INTO corporate_flag VALUES (?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('i', $this->contractKey);
    $stmt->execute();
    $stmt->close(); 
    $this->result = 1;
 }else{
    $sql = "DELETE FROM corporate_flag WHERE contract_key = '$this->contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->execute();
    $stmt->close();
    $this->result = 2;
 }






}
//======================================================================================
function getResult() {
          return($this->result);
          }

    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$contract_key = $_REQUEST['contract_key'];

//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new changeCorpFlag();
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeFlag();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>