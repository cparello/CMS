<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


//date_default_timezone_set('America/Los_Angeles');
class  prePayInfo{

private $contractKey = null;

function setContractKey($contractKey)  {
             $this->contractKey = $contractKey;
             }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//--------------------------------------------------------------------------------------------------------------------------
function checkPrePayRecords() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

if($count > 0) {
  $result = 1;
  }else{
  $result = 0;
  }

$stmt->close(); 

return $result;

}
//-------------------------------------------------------------------------------------------------------------------------


}//end class
$contract_key = $_REQUEST['contract_key'];

$prePay = new prePayInfo;
$prePay-> setContractKey($contract_key);
$result = $prePay-> checkPrePayRecords();

echo"$result";


exit;


?>