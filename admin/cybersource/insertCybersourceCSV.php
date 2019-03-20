<?php
 //error_reporting(E_ALL);
class insertCybersourceCSVFile {

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

$dbMainOne = $this->dbconnectOne();
$dbMain = $this->dbconnect();


/*
$sql13 = "DELETE FROM temp_cs_insert_sub WHERE transaction_date != '' OR transaction_date = ''";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();

$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close();
//echo "fubar";

    


$stmt = $dbMainOne-> prepare("SELECT report_date FROM failed_settle_report WHERE database_name = '$database_name' AND report_flag = '0'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($report_date);
$stmt->fetch();
$stmt->close();

$report_date = trim($report_date);

if ($report_date != ''){
    $year[1] = date("Y",strtotime($report_date));//'2013';
    $month[1] = date("m",strtotime($report_date));//'12';
    $day[1] = date("j",strtotime($report_date));//'10';
    $year[2] = date("Y");//'2013';
    $month[2] = date("m");//'12';
    $day[2] = date("j");//'10';
    if ($day[2] == '1'){
        $day[2] = date('d', strtotime('last day of previous month'));
        if ($month[2] == '1'){
            $month[2] = '12';
        }else{
            $month[2]--;
        }
    }else{
        $day[2] -= 1;
    }
    
    if ($day[2] < '10'){
        $day[2] = "0$day[2]";
    }
    $totDays  = 2;
}else if ($report_date == ''){
   */ //echo "test";
    $year = date("Y");//'2013';
    $month = date("m");//'12';
    $day = date("j")-1;//'10';
/*    if ($day[1] == '1'){
        $day[1] = date('d', strtotime('last day of previous month'));
        if ($month[1] == '1'){
            $month[1] = '12';
        }else{
            $month[1]--;
        }
    }else{
        $day[1] -= 1;
    }
    
   
 if ($day[1] < '10'){
        $day[1] = "0$day[1]";
    }
    $totDays  = 1;}
if ($totDays  == 1){
    $dateTester = "$year[1]-$month[1]-$day[1]";
}else if ($totDays  == 2){
    $dateTester = "$year[2]-$month[2]-$day[2]";
}

include"dailySalesReport.php";
$report = new emailDSRReports();
$report->setMonth($month);
$report->setDay($day);
$report->setYear($year);
$report->moveData();
*/

/*
$stmt = $dbMain->prepare("SELECT date FROM cs_reporting_results WHERE date = '$dateTester'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($date);   
$stmt->fetch();
$stmt->close();

//echo"tdays $totDays date $date DATETESTER $dateTester ";



if (strtotime($date) != strtotime($dateTester)){
    //echo"FUBAR MATCH!!!!!!!!!!!!";
    


//echo "$year[1] $month[1] $day[1]";
$stmt = $dbMain->prepare("SELECT merchant_id FROM gateway_info WHERE merchant_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($merchant_id);   
$stmt->fetch();    
    
$stmt = $dbMain->prepare("SELECT passkey, user_name, password, test_link, live_link FROM cs_report_info WHERE passkey != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passkey, $username, $password, $test_link, $live_link);   
$stmt->fetch();

if ($passkey == '1'){
    $reportPath = $test_link;
}elseif ($passkey == '2'){
    $reportPath = $live_link;
}




//echo "fubar222";
include "processCybersourceCSV.php";
$update = new processCybersourceCSVFile();

for($i=1;$i<=$totDays;$i++){
$success = 0;
$update->setSuccess($success);

$ch = curl_init();
$res= curl_setopt ($ch, CURLOPT_URL,"$reportPath$year[$i]/$month[$i]/$day[$i]/$merchant_id/SubscriptionDetailReport.csv");//$reportPath$year/$month/$day
$fp = fopen("SubscriptionDetailReport.csv", "w");

curl_setopt($ch,CURLOPT_USERPWD,"$username:$password");
curl_setopt($ch, CURLOPT_FAILONERROR, false); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$data = curl_exec($ch);
//echo "$data";
curl_close($ch);
fwrite($fp, $data);     
fclose($fp);

 $mysqli  =  new mysqli("localhost", "emsdata", "6ym5yst3ms!","$database_name");
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
    // mysqli_select_db();

$result = $mysqli->query("LOAD DATA LOCAL INFILE 'SubscriptionDetailReport.csv' INTO TABLE temp_cs_insert_sub COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r' IGNORE 2 LINES (merchant_id,	transaction_date, ics_applications,	payment_request_id,	recurring_payment_event_amount,	recurring_payment_amount,	currency_code,	subscription_id,	merchant_ref_number,	customer_account_id,	subscription_type,	subscription_title,	last_subscription_status,	subscription_status,	subscription_payment_method,	recurring_start_date,	next_scheduled_date,	event_retry_count,	recurring_number_of_payments,	payments_success,	payment_success_amount,	installment_sequence,	installment_total_count,	recurring_frequency,	recurring_approval_required, recurring_payment_event_approved_by,	recurring_automatic_renew,	comments,	setup_fee,	setup_fee_currency,	tax_amount,	customer_firstname,	customer_lastname,	bill_address1,	bill_address2,	bill_city,	bill_state,	bill_zip,	bill_country,	ship_to_address1,	ship_to_address2,	ship_to_city,	ship_to_state,	ship_to_company_name,	ship_to_country,	ship_to_firstname,	ship_to_lastname,	ship_to_zip,	company_name,	customer_email,	customer_phone,	customer_ipaddress,	card_type,	customer_cc_expmo,	customer_cc_expyr,	customer_cc_startmo,	customer_cc_startyr,	customer_cc_issue_number,	account_suffix,	ecp_account_type,	ecp_rdfi,	reason_code,	auth_rcode,	auth_code,	auth_type,	auth_auth_avs,	auth_auth_response,	auth_cavv_response,	ics_rcode,	ics_rflag,	ics_rmsg,	request_token,	payment_processor,	e_commerce_indicator,	transaction_ref_number,	merchant_defined_data1,	merchant_defined_data2,	merchant_defined_data3,	merchant_defined_data4,	merchant_secure_data1,	merchant_secure_data2,	merchant_secure_data3,	merchant_secure_data4)");
        //while ($row = mysql_fetch_array($result)) {
        //}
        //$num_rows = mysql_num_rows($result);
        //echo "done, Num Rows = $num_rows";
        */

/*
include"insertCybersourceCSV2222.php";
$updateTrans = new insertCybersourceTransCSVFile();
$updateTrans->setMonth($month[$i]);
$updateTrans->setDay($day[$i]);
$updateTrans->setYear($year[$i]);
$updateTrans->moveDataTrans();
 //echo "fubar3333";   
//echo "y $year[$i] m $month[$i] d $day[$i]  totDAYS $totDays reportDATE $report_date dbName $database_name date $date date tester $dateTester<br>";

    

$update->moveData();
$success = $update->getSuccess();
if ($totDays == '2' AND $success == '1'){
    $reportFlag = '1';
    $sql = "UPDATE failed_settle_report SET report_flag = ? WHERE database_name = '$database_name' AND report_date = '$report_date'";
    $stmt = $dbMainOne->prepare($sql);
    $stmt->bind_param('i', $reportFlag);
    if(!$stmt->execute())  {
                    	printf("Error:update_failed_settle_report %s.\n", $stmt->error);
                          }	
        
    $stmt->close();
            }                   

         }
    }else{
        $message = "The Subscription Detail Report for Database $database_name has already been run today..";
        $message = wordwrap($message, 70, "\r\n"); 
        mail('christopherparello@gmail.com', 'Report Failure', $message);
    }
    
   
    

    
    
    */
    
}
//===========================================================================================================
}
//$update = new insertCybersourceCSVFile();
//$update->moveData();
?>