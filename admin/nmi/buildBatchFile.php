<?php


$ajaxSwitch = $_REQUEST['ajaxSwitch'];

if($ajaxSwitch == 1){
$status = 2;
require"../dbConnect.php";



$timeStamp = date('mdyhis');
$stmt = $dbMain ->prepare("SELECT exp_bool, max_retries, nsf_bool, exp_month, exp_year FROM billing_gateway_main_fields WHERE gateway_key= '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($ccExpOverideBool, $maxRetries, $nsf_bool, $exp_month, $exp_year);
$stmt->fetch();
$stmt->close();

$todayDay = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));//
$todaySecs = strtotime($todayDay);


    $ourFilePath = "../nmiBatchFiles/";
    $ourFileName = "batchFile-$timeStamp.csv";
    $ourFileHandle = fopen("$ourFilePath$ourFileName", 'x+') or die("can't open file");
    
    $batchedRecordsCount = 0;
    $batchedRecords = "";
    
    $stmt99 = $dbMain ->prepare("SELECT payment_id, contract_key, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_year, vault_id FROM batch_recurring_records WHERE contract_key != '' AND processed = 'N' AND record_batched = 'N' AND club_id != ''");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($payment_id, $contract_key, $attempt_number, $billing_amount, $cycle_start_day, $cycle_start_month, $cycle_start_year, $vault_id);
    while($stmt99->fetch()){
            $expBool = 1;
   
            
            //echo "test $contract_key";  
             switch($attempt_number){
                case 1:
                    $diffSecs = 1;
                break;
                case 2:
                    $diffSecs = 259200;
                break;
                case 3:
                    $diffSecs = 518400;
                break;
                default:
                    $diffSecs = 1;
                break;
             } 
    
                //$diffSecs = $attempt_number * 86400 + 172800;
                $startDate = date('Y-m-d H:i:s',mktime(0,0,0,$cycle_start_month, $cycle_start_day, $cycle_start_year));
                $startSecs = strtotime($startDate);
                $timeBuffer = $startSecs + $diffSecs;
               
                if($attempt_number == 1 OR $todaySecs >= $timeBuffer){
                
                  if ($attempt_number <= $maxRetries){
                    
                    $attempt_number++;
                    $batchedRecords .= "sale,$billing_amount,$vault_id,$payment_id \n";
                    $batchedRecordsCount++;
                    
                    $record_batched = "Y";
                    $sql = "UPDATE batch_recurring_records SET attempt_number = ?, record_batched = ? WHERE contract_key = '$contract_key' AND payment_id = '$payment_id'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $attempt_number, $record_batched);
                    $stmt->execute();
                    $stmt->close();
                       
                }
                } 
                $contract_key = "";
                $attempt_number = "";
                $billing_amount = "";
                $payment_id = "";
                $cycle_start_day = "";
                $cycle_start_month = "";
                $cycle_start_year = "";
                $vault_id = "";
                $timeBuffer = "";
                }
            
            $stmt99->close();
            
            fwrite($ourFileHandle, $batchedRecords);                
                            
            fclose($ourFileHandle);
                
            
            
            if($batchedRecordsCount > 0){
                
              
                $status = 1;
                }
                  
                
    




//====================================================================================================





//echo "test";

    
    echo "$status|$ourFileName|$batchedRecordsCount";
    exit;

//echo "$batchedRecordsCount";


}else{
    echo "99";
    exit;
}
//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();

?>