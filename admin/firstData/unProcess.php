<?php
require"../dbConnect.php";

 $processed = 'N';
 $attempt_number = 1;
 $outstandingBalance = 'N';
 $imported = 'N';

$stmt99 = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND response = '999' AND response_message = 'Expired Card' AND processed = 'Y'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($count);
$stmt99->fetch();

echo"count $count";

/*$sql = "UPDATE billing_scheduled_recuring_payments SET imported = ?, attempt_number = ?, processed = ?, outstanding_balance = ? WHERE contract_key != '' AND response = '999' AND response_message = 'Expired Card'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $imported, $attempt_number, $processed, $outstandingBalance);
if(!$stmt->execute())  {
                            	printf("Error:updateEHFEE %s.\n", $stmt->error);
                                  }	
                
$stmt->close();*/

$stmt99 = $dbMain ->prepare("SELECT count(*) as count FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND response = '999' AND response_message = 'Expired Card' AND processed = 'N'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($count);
$stmt99->fetch();

echo"count $count";
?>

