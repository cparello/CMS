<?php
class  resetInvoice {

//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//----------------------------------------------------------------------------------------------------------------------------------------------
function resetInvoiceNumber() {//SELECT DISTINCT monthly_payments.contract_key FROM monthly_payments JOIN account_status ON monthly_payments.contract_key = account_status.contract_key WHERE account_status = 'CU'

$dbMain = $this->dbconnect();


$stmt = $dbMain ->prepare("DELETE FROM past_due_attempts WHERE contract_key != ''");
$stmt->execute();      
$stmt->close();

}
//---------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------


}
 $ajax_switch =$_REQUEST['ajax_switch'];

if($ajax_switch == 1) {
   $testPastDue = new  resetInvoice();
   $testPastDue-> resetInvoiceNumber();
   }

echo "1";
exit;
?>