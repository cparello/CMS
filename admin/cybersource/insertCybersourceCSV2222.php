<?php
 //error_reporting(E_ALL);
class insertCybersourceTransCSVFile {

function dbconnectOne()   {
require"../dbConnectOne.php";
return $dbMainOne;
}

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setMonth($month){
    $this->month = $month;
}
function setDay($day){
    $this->day = $day;
}
function setYear($year){
    $this->year = $year;
}
//==============================================================================================
function moveDataTrans(){

$dbMainOne = $this->dbconnectOne();
$dbMain = $this->dbconnect();

$sql13 = "DELETE FROM temp_cs_insert WHERE request_id != ''";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();
    
$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close();

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

$ch = curl_init();
$res= curl_setopt ($ch, CURLOPT_URL,"$reportPath$this->year/$this->month/$this->day/$merchant_id/TransactionDetailReport.csv");//$reportPath$year/$month/$day
$fp = fopen("TransactionDetailReport.csv", "w");

curl_setopt($ch,CURLOPT_USERPWD,"$username:$password");
curl_setopt($ch, CURLOPT_FAILONERROR, false); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$data = curl_exec($ch);
//echo "$data";
curl_close($ch);
fwrite($fp, $data);     
fclose($fp);

$mysqli  =  new mysqli("localhost", "emsdata", "6ym5yst3ms!", "$database_name");
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
     //mysql_select_db();

$result = $mysqli->query("LOAD DATA LOCAL INFILE 'TransactionDetailReport.csv' INTO TABLE temp_cs_insert COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r' IGNORE 2 LINES(row_descriptor,request_id,transaction_date,	merchant_ref_number,	merchant_id,	ics_applications,	auth_rcode,	auth_rflag,	auth_rmsg,	auth_reversal_rcode,	auth_reversal_rflag,	auth_reversal_rmsg,	bill_rcode,	bill_rflag,	bill_rmsg,	credit_rcode,	credit_rflag,	credit_rmsg,	ecp_debit_rcode,	ecp_debit_rflag,	ecp_debit_rmsg,	ecp_credit_rcode,	ecp_credit_rflag,	ecp_credit_rmsg,	score_rcode,	score_rflag,	score_rmsg,	tax_rcode,	tax_rflag,	tax_rmsg,	dav_rcode,	dav_rflag,	dav_rmsg,	export_rcode,	export_rflag,	export_rmsg,	elc_rcode,	elc_rflag,	elc_rmsg,	elc_revoke_rcode,	elc_revoke_rflag,	elc_revoke_rmsg,	download_rcode,	download_rflag,	download_rmsg,	create_isv_rcode,	create_isv_rflag,	create_isv_rmsg,	add_value_to_isv_rcode,	add_value_to_isv_rflag,	add_value_to_isv_rmsg,	get_isv_history_rcode,	get_isv_history_rflag,	get_isv_history_rmsg,	get_isv_info_rcode,	get_isv_info_rflag,	get_isv_info_rmsg,	get_isv_profiles_rcode,	get_isv_profiles_rflag,	get_isv_profiles_rmsg,	modify_isv_rcode,	modify_isv_rflag,	modify_isv_rmsg,	redeem_isv_rcode,	redeem_isv_rflag,	redeem_isv_rmsg,	customer_firstname,	customer_lastname,	customer_middlename,	bill_address1,	bill_address2,	bill_city,	bill_state,	bill_zip,	bill_country,	company_name,	customer_email,	customer_title,	customer_phone,	ship_to_address1,	ship_to_address2,	ship_to_city,	ship_to_state,	ship_to_zip,	ship_to_country,	ship_to_phone,	customer_ipaddress,	account_suffix,	customer_cc_expmo,	customer_cc_expyr,	customer_cc_startmo,	customer_cc_startyr,	customer_cc_issue_number,	payment_method,	amount,	currency,	auth_auth_avs,	auth_auth_code,	auth_cv_result,	shipping_method,	score_factors,	score_host_severity,	score_score_result,	score_time_local,	customer_hostname,	shipping_carrier,	customer_password_provided,	lost_password,	repeat_customer,	cookies_accepted,	customer_loyalty,	customer_promotions,	gift_wrap,	returns_accepted,	customer_id,	product_risk,	applied_score_threshold,	applied_time_hedge,	applied_velocity_hedge,	applied_host_hedge,	applied_category_gift,	applied_category_time,	avs,	cv,	payment_processor,	source,	subscription_id)");
        //while ($row = mysql_fetch_array($result)) {
        //}
        //$num_rows = mysql_num_rows($result);
        //echo "done, Num Rows = $num_rows";
        

}

//===========================================================================================================
}
//$update = new insertCybersourceTransCSVFile();
//$update->moveDataTrans();
?>