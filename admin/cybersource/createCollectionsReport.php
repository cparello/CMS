<?php

class createCollectionsReports {

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function moveData(){

$counter = 0;


 
$dbMain = $this->dbconnect(); 



$this->lines = file("/usr/local/www/vhosts/ems/cmp.burbankathleticclub.com/admin/cybersource/SubscriptionDetailReport.csv");
foreach ($this->lines as $line) {
  
if ($counter > 1){
$line = preg_replace('/"ics_auth,ics_bill"/','ics_authics_bill',$line);//"ics_bill,ics_auth"
$line = preg_replace('/"ics_bill,ics_auth"/','ics_authics_bill',$line);

//echo $line;
//var_dump($line);
//echo "<br><br>";
$pat = ",";
$recordDivision = explode($pat, $line);

//var_dump($recordDivision);
//echo "<br><br>";

  $merchant_id = $recordDivision[0];
  $temp_date = explode(' ',$recordDivision[1]);
  $transaction_date = $temp_date[0];
  
  $ics_apps = $recordDivision[2];
  $request_id = $recordDivision[3];
  $recurring_payment_event_amount = $recordDivision[4];
  $recurring_payment_amount = $recordDivision[5];
  $currency_code = $recordDivision[6];
  $subscription_id = $recordDivision[7];
  $merchant_ref_number = $recordDivision[8];
  $customer_account_id = $recordDivision[9];
  $subscription_type = $recordDivision[10];
  $subscription_title = $recordDivision[11];
  $last_subscription_status = $recordDivision[12];
  $subscription_status = $recordDivision[13];
  $subscription_payment_method = $recordDivision[14];
  $recurring_start_date = $recordDivision[15];
  $next_scheduled_date = $recordDivision[16];
  $event_retry_count = $recordDivision[17];
  $recurring_number_of_payments = $recordDivision[18];
  $payments_success = $recordDivision[19];
  $payment_success_amount = $recordDivision[20];
  $installment_sequence = $recordDivision[21];
  $installment_total_count = $recordDivision[22];
  $recurring_frequency = $recordDivision[23];
  $recurring_approval_required = $recordDivision[24];
  $recurring_payment_event_approved_by = $recordDivision[25];
  $recurring_automatic_renew = $recordDivision[26];
  $comments = $recordDivision[27];
  $setup_fee = $recordDivision[28];
  $setup_fee_currency = $recordDivision[29];
  $tax_amount = $recordDivision[30];
  $customer_firstname = $recordDivision[31];
  $customer_lastname = $recordDivision[32];
  $bill_address1 = $recordDivision[33];
  $bill_address2 = $recordDivision[34];
  $bill_city = $recordDivision[35];
  $bill_state = $recordDivision[36];
  $bill_zip = $recordDivision[37];
  $bill_country = $recordDivision[38];
  $ship_to_address1 = $recordDivision[39];
  $ship_to_address2 = $recordDivision[40];
  $ship_to_city = $recordDivision[41];
  $ship_to_state = $recordDivision[42];
  $ship_to_company_name = $recordDivision[43];
  $ship_to_country = $recordDivision[44];
  $ship_to_firstname = $recordDivision[45];
  $ship_to_lastname = $recordDivision[46];
  $ship_to_zip = $recordDivision[47];
  $company_name = $recordDivision[48];
  $customer_email = $recordDivision[49];
  $customer_phone = $recordDivision[50];
  $customer_ipaddress = $recordDivision[51];
  $card_type = $recordDivision[52];
  $customer_cc_expmo = $recordDivision[53];
  $customer_cc_expyr = $recordDivision[54];
  $customer_cc_startmo = $recordDivision[55];
  $customer_cc_startyr = $recordDivision[56];
  $customer_cc_issue_number = $recordDivision[57];
  $account_suffix = $recordDivision[58];
  $ecp_account_type = $recordDivision[59];
  $ecp_rdfi = $recordDivision[60];
  $reason_code = $recordDivision[61];
  $auth_rcode = $recordDivision[62];
  $auth_code = $recordDivision[63];
  $auth_type = $recordDivision[64];
  $auth_auth_avs = $recordDivision[65];
  $auth_auth_response = $recordDivision[66];
  $auth_cavv_response = $recordDivision[67];
  $ics_rcode = $recordDivision[68];
  $ics_rflag = $recordDivision[69];
  $ics_rmsg = $recordDivision[70];
  $request_token = $recordDivision[71];
  $payment_processor = $recordDivision[72];
  $e_commerce_indicator = $recordDivision[73];
  $transaction_ref_number = $recordDivision[74];
  $merchant_defined_data1 = $recordDivision[75];
  $merchant_defined_data2 = $recordDivision[76];
  $merchant_defined_data3 = $recordDivision[77];
  $merchant_defined_data4 = $recordDivision[78];
  $merchant_secure_data1 = $recordDivision[79];
  $merchant_secure_data2 = $recordDivision[80];
  $merchant_secure_data3 = $recordDivision[81];
  $merchant_secure_data4 = $recordDivision[82];
  
  
  $this->contractKey = $merchant_ref_number;
  $this->paymentDate = date("Y-m-d H:i:s"  , strtotime($transaction_date));
  //echo "<br><br>counter:  $counter  %% rescode $reason_code  mercrefnum  $merchant_ref_number sub title $subscription_title  payDATE $this->paymentDate<br>";
  $this->contractKey = $merchant_ref_number;
  $this->transKey = $request_id;
  $this->nextBillingFee = $recurring_payment_amount;
  $this->lastAttemptDate = $transaction_date;
  $this->historyKey = $subscription_id;
  $this->processAttempts = $event_retry_count;
  $this->rejectMSG = $ics_rmsg;
  $this->paymentAmount = $recurring_payment_amount;
  $this->subscriptionID = $subscription_id;
  $this->paymentDescription = $subscription_title;
  
  
 
        $stmt = $dbMain->prepare("SELECT card_number, card_exp_date, card_fname, card_lname, card_type  FROM credit_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname, $card_type); 
        $stmt->fetch();
        $stmt->close();
        
        $card_name = "$card_fname $card_lname";
        
        $stmt = $dbMain->prepare("SELECT description FROM cs_error_codes WHERE error_code = '$reason_code'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($description); 
        $stmt->fetch();
        $stmt->close();
  
    if ($reason_code == 204 OR $reason_code == 203){
        
        $sql = "INSERT INTO collections_good_cards VALUES (?,?,?,?,?,?,?,?,?,?)";
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsisss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$reason_code,$description,$transaction_date, $subscription_title);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSGOODCARDS %s.\n", $stmt->error);
                      }	
    	$stmt->close();
        
    }elseif ($reason_code != 100 AND $reason_code != 204 AND $reason_code != 203 AND $reason_code != 201){
       $sql = "INSERT INTO collections_bad_cards VALUES (?,?,?,?,?,?,?,?,?,?)";
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsisss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$reason_code,$description,$transaction_date, $subscription_title);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSBADCARDS %s.\n", $stmt->error);
                      }	
    	$stmt->close();
         }
        
    
    }
    $counter++;
    }
    
   
}
//===========================================================================================================
}
$createReport = new createCollectionsReports();
$createReport->moveData();

?>