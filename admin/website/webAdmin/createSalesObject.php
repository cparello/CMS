<?php
session_start();

//=======================================================

//==============================================end timeout
//decode the info from the ajax post
$service_status = $_REQUEST['service_status'];
$group_type = $_REQUEST['group_type'];
$mem_num = $_REQUEST['mem_num'];
$group_type_info_array = $_REQUEST['group_type_info_array'];
$name_address_array = $_REQUEST['name_address_array'];
$liability_host = $_REQUEST['liability_host'];
$product_list_array = $_REQUEST['product_list_array'];
$trans = $_REQUEST['trans'];
$pro_rate_fee = $_REQUEST['pro_rate_fee'];
$process_fee_eft = $_REQUEST['process_fee_eft'];
$down_pay = $_REQUEST['down_pay'];
$total_fees_monthly = $_REQUEST['total_fees_monthly'];
$monthly_payment = $_REQUEST['monthly_payment'];
$serve_month = $_REQUEST['serve_month'];
$open_end = $_REQUEST['open_end'];
$init_fee = $_REQUEST['init_fee'];
$pre_paid_service = $_REQUEST['pre_paid_service'];
$process_fee_pif = $_REQUEST['process_fee_pif'];
$grand_total_pif = $_REQUEST['grand_total_pif'];
$serve_total = $_REQUEST['serve_total'];
$ren_total = $_REQUEST['ren_total'];
$serve_total_due = $_REQUEST['serve_total_due'];
$today_payment = $_REQUEST['today_payment'];
$balance_due = $_REQUEST['balance_due'];
$due_date = $_REQUEST['due_date'];
$monthly_billing_type = $_REQUEST['monthly_billing_type'];
$datepicker = $_REQUEST['datepicker'];
$delete_switch = $_REQUEST['delete_switch'];
$contract_key = $_REQUEST['contract_key'];
$sid = $_REQUEST['sid'];
$key_switch = $_REQUEST['key_switch'];
$sig = $_REQUEST['sig'];
//exit;
//decode the info from the ajax post
$service_status = urldecode($service_status);
$group_type = urldecode($group_type);
$mem_num = urldecode($mem_num);
$group_type_info_array = urldecode($group_type_info_array);
$name_address_array = urldecode($name_address_array);
$liability_host = urldecode($liability_host);
$product_list_array = urldecode($product_list_array);
$trans = urldecode($trans);
$pro_rate_fee = urldecode($pro_rate_fee);
$process_fee_eft = urldecode($process_fee_eft);
$down_pay = urldecode($down_pay);
$total_fees_monthly = urldecode($total_fees_monthly);
$monthly_payment = urldecode($monthly_payment);
$serve_month = urldecode($serve_month);
$open_end = urldecode($open_end);
$init_fee = urldecode($init_fee);
$pre_paid_service = urldecode($pre_paid_service);
$process_fee_pif = urldecode($process_fee_pif);
$grand_total_pif = urldecode($grand_total_pif);
$serve_total = urldecode($serve_total);
$ren_total = urldecode($ren_total);
$serve_total_due = urldecode($serve_total_due);
$today_payment = urldecode($today_payment);
$balance_due = urldecode($balance_due);
$due_date = urldecode($due_date);
$monthly_billing_type = urldecode($monthly_billing_type);
$datepicker =  urldecode($datepicker);
//$sig =  urldecode($sig);
//create the sales sql object to store the sales info for the contract forms
include "salesSql.php";
$_SESSION['salesSql'] = new salesSql();
$salesSql = $_SESSION['salesSql']; 

//this redirects and closes the current sql object session variables as well as deletes the contract key 
if($delete_switch == 1)   {
 $salesSql-> setContractKey($contract_key);
 $delete_key =  $salesSql-> deleteContractKey();
 echo"$delete_key";
 exit;
}

//does a little cleanup for a couple of undefined vars from javascript
if($process_fee_eft == "undefined") {
   $process_fee_eft = "";
   }
if($process_fee_pif == "undefined") {
   $process_fee_pif = "";
   }

//set the sales form variables
$salesSql-> setContractType($service_status);
$salesSql-> setGroupType($group_type);
$salesSql-> setGroupNumber($mem_num);
$salesSql-> setGroupTypeInfo($group_type_info_array);  //this to be parsed
$salesSql-> setContractClientInfo($name_address_array);  //to be parsed contains the name and adress info
$salesSql-> setHostType($liability_host);
$salesSql-> setProductList($product_list_array);  //this to be parsed
$salesSql-> setTransfer($trans);
$salesSql-> setProRateDues($pro_rate_fee);
$salesSql-> setProcessFeeMonthly($process_fee_eft);
$salesSql-> setDownPayment($down_pay);
$salesSql-> setTotalFeesEft($total_fees_monthly);    //this will not be saved into the db. It is used just for reference when creating contracts
$salesSql-> setMonthlyDues($monthly_payment);
$salesSql-> setMonthlyServicesTotal($serve_month);   //used as reference for contracts
$salesSql-> setTermType($open_end);
$salesSql-> setInitiationFee($init_fee);
$salesSql-> setPifServicesTotal($pre_paid_service);   //used as reference for contracts
$salesSql-> setProcessFeePif($process_fee_pif);
$salesSql-> setPifGrandTotal($grand_total_pif);  //shows the total od services and proc fee. for contract reference
$salesSql-> setServicesTotal($serve_total);  //for contract reference. shows pif and monthly service totals
$salesSql-> setRenewalRateTotal($ren_total);  //for contract reference
$salesSql-> setMinTotalDue($serve_total_due);
$salesSql-> setTodaysPayment($today_payment);
$salesSql-> setBalanceDue($balance_due);
$salesSql-> setDueDate($due_date);
$salesSql-> setMonthlyBillingType($monthly_billing_type);
$salesSql-> setDatePicker($datepicker);
$salesSql-> setSig($sig);

if($key_switch == 0) {
   $salesSql-> createContractKey();
   $contract_key =  $salesSql-> getContractKey();
   echo"$contract_key";
   }elseif($key_switch == 1){
   $salesSql-> setContractKey($contract_key);
   echo"$contract_key";
   }

$_SESSION['salesSql'] = $salesSql;



exit;
?>