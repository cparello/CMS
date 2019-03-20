<?php
class  declinedCount {


private $contractKey = null;
private $declinedCount = null;
private $nsfCount = null;


function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }

function setAjaxSwitch($ajaxSwitch) {
       $this->ajaxSwitch= $ajaxSwitch;
       }


//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadNsfCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT distinct contract_key FROM nsf_checks WHERE check_bit = '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$rowCount = $stmt->num_rows;
$this->nsfCount = $rowCount;   
$stmt->close();

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadDeclinedCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT distinct contract_key FROM rejected_payments WHERE reject_bit = '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$rowCount = $stmt->num_rows;

$this->declinedCount = $rowCount;   
$stmt->close();

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function parseRDCount() {

$rdCount = $this->declinedCount + $this->nsfCount;

echo"$rdCount";
exit;

}
//----------------------------------------------------------------------------------------------------------------------------------------------



}
 $ajax_switch =$_REQUEST['ajax_switch'];

if($ajax_switch == 1) {
   $testPastDue = new  declinedCount();
   $testPastDue-> setAjaxSwitch($ajax_switch);
   $testPastDue-> loadDeclinedCount();
   $testPastDue-> loadNsfCount();
   $testPastDue-> parseRDCount();
   }


?>