<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$bool = $_REQUEST['bool'];
switch($bool){
    case 'B':
        include"../firstData/manualMonthlyBillingSelector.php";
        $upload = new monthlyBillingSelector();
        $upload->fileMaker();
        //echo "test";
        $msBatchId = $upload->getBatchId();
        include"../firstData/rateGuarenteeSelector.php";
        $upload = new rateFeeSelector();
        $upload->countRecord();
        $rfBatchId = $upload->getBatchId();
        include"../firstData/enhanceFeeSelector.php";
        $upload = new enhanceFeeSelector();
        $upload->countRecord();
        $efBatchId = $upload->getBatchId();
        include"../firstData/processScheduledCCTransactions.php";
    break;
    case 'P':
        include"../firstData/manualPastDueSelector.php";
        $upload = new pastDueSelector();
        $upload->fileMaker();
        include"../firstData/processScheduledCCTransactions.php";
    break;
}

$value = "1";

echo"$value";// $month $barcode";
exit;

?>