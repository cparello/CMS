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
//echo "fubar";
//$dbMain = $this->dbconnect();




 $db = mysqli_connect("localhost", "emsdata", "6ym5yst3ms!","cmp_1000");
  if(!$db){
     echo "Error:  Cannot connect to the database, please try again later";
     exit;
    }
     
$result = mysql_query("LOAD DATA LOCAL INFILE 'SubscriptionDetailReport.csv' INTO TABLE temp_cs_insert_sub COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r' IGNORE 2 LINES (merchant_id,	transaction_date, ics_applications,	payment_request_id,	recurring_payment_event_amount,	recurring_payment_amount,	currency_code,	subscription_id,	merchant_ref_number,	customer_account_id,	subscription_type,	subscription_title,	last_subscription_status,	subscription_status,	subscription_payment_method,	recurring_start_date,	next_scheduled_date,	event_retry_count,	recurring_number_of_payments,	payments_success,	payment_success_amount,	installment_sequence,	installment_total_count,	recurring_frequency,	recurring_approval_required, recurring_payment_event_approved_by,	recurring_automatic_renew,	comments,	setup_fee,	setup_fee_currency,	tax_amount,	customer_firstname,	customer_lastname,	bill_address1,	bill_address2,	bill_city,	bill_state,	bill_zip,	bill_country,	ship_to_address1,	ship_to_address2,	ship_to_city,	ship_to_state,	ship_to_company_name,	ship_to_country,	ship_to_firstname,	ship_to_lastname,	ship_to_zip,	company_name,	customer_email,	customer_phone,	customer_ipaddress,	card_type,	customer_cc_expmo,	customer_cc_expyr,	customer_cc_startmo,	customer_cc_startyr,	customer_cc_issue_number,	account_suffix,	ecp_account_type,	ecp_rdfi,	reason_code,	auth_rcode,	auth_code,	auth_type,	auth_auth_avs,	auth_auth_response,	auth_cavv_response,	ics_rcode,	ics_rflag,	ics_rmsg,	request_token,	payment_processor,	e_commerce_indicator,	transaction_ref_number,	merchant_defined_data1,	merchant_defined_data2,	merchant_defined_data3,	merchant_defined_data4,	merchant_secure_data1,	merchant_secure_data2,	merchant_secure_data3,	merchant_secure_data4)");
  
    
    
}
//===========================================================================================================
}
$update = new insertCybersourceCSVFile();
$update->moveData();
?>