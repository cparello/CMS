<?php

require"../dbConnect.php";



$timeStamp = date('mdyhis');

$todayDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));//
$todaySecs = strtotime($todayDay);


$ourFileHandle = fopen("../nmiBatchFiles/fubarBatch.csv", 'r') or die("can't open file");


$linesFF = file("../nmiBatchFiles/fubarBatch.csv");
foreach ($linesFF as $line) {

    $pat = ",";
    $line = preg_replace('/"/', '', $line);
    //$line = str_replace('/"/',"",$line);
    $recordDivision = explode($pat, $line);

    $transID = $recordDivision[0];
    $response = $recordDivision[1];
    $authCode = $recordDivision[2];
    $amount = $recordDivision[3];
    $responseCode = $recordDivision[4];
    $payMeth = $recordDivision[5];
    $payId = $recordDivision[6];

    echo "refund,$amount,$transID<br>";

    $batchedRecords .= "refund,$amount,$transID \n";



}
echo "done test <br>";

$ourFileHandle2 = fopen("../nmiBatchFiles/fixItFubar22.csv", 'w+') or die("can't open file");

fwrite($ourFileHandle2, $batchedRecords);

fclose($ourFileHandle2);
//====================================================================================================





//echo "$batchedRecordsCount";


//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();


?>