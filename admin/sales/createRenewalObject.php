<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout
$group_info_array = $_REQUEST['group_info_array'];
$address_info_array = $_REQUEST['address_info_array'];
$product_list_array = $_REQUEST['product_list_array'];
$contract_key= $_REQUEST['contract_key'];
$renewal_fee = $_REQUEST['$renewal_fee'];
$service_total= $_REQUEST['service_total'];
$grand_total = $_REQUEST['grand_total'];
$todays_payment = $_REQUEST['todays_payment'];
$balance_due = $_REQUEST['balance_due'];
$balance_due_date = $_REQUEST['balance_due_date'];
$first_name = $_REQUEST['first_name'];
$middle_name =$_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$group_name = $_REQUEST['group_name'];
$group_type = $_REQUEST['group_type'];
$pif_out_bool = $_REQUEST['pif_out_bool'];
$pif_out_time = $_REQUEST['pif_out_time'];
$pif_out_money_owed = $_REQUEST['pif_out_money_owed'];
$past_due_amount = $_REQUEST['past_due_amount'];
$year_quantity = $_REQUEST['year_quantity'];
$delete_switch = $_REQUEST['delete_switch'];
$old_key = $_REQUEST['old_key'];
$changed_service_bool = $_REQUEST['changed_service_bool'];
$sid = $_REQUEST['sid'];
$sig = $_REQUEST['sig'];

$group_info_array = urldecode($group_info_array);
$address_info_array = urldecode($address_info_array);
$product_list_array = urldecode($product_list_array);
$contract_key= urldecode($contract_key);
$renewal_fee = urldecode($renewal_fee);
$service_total= urldecode($service_total);
$grand_total = urldecode($grand_total);
$todays_payment = urldecode($todays_payment);
$balance_due = urldecode($balance_due);
$balance_due_date = urldecode($balance_due_date);
$first_name = urldecode($first_name);
$middle_name = urldecode($middle_name);
$last_name = urldecode($last_name);
$group_name = urldecode($group_name);
$group_type = urldecode($group_type);
$pif_out_bool = urldecode($pif_out_bool);
$pif_out_time = urldecode($pif_out_time);
$pif_out_money_owed = urldecode($pif_out_money_owed);
$past_due_amount = urldecode($past_due_amount);
$year_quantity = urldecode($year_quantity);
$old_key = urldecode($old_key);
$changed_service_bool = urldecode($changed_service_bool);
//create the sales sql object to store the sales info for the contract forms
include "renewalSql.php";
$_SESSION['renewalSql'] = new renewalSql();
$renewalSql = $_SESSION['renewalSql']; 

if($delete_switch == 1)   {
 $delete_key =  $renewalSql-> deleteRenewal();
 echo"$delete_key";
 exit;
}

$renewalSql-> setGroupInfo($group_info_array);
$renewalSql-> setAddressInfo($address_info_array);
$renewalSql-> setFirstName($first_name);
$renewalSql-> setMiddleName($middle_name);
$renewalSql-> setLastName($last_name);
$renewalSql-> setProductList($product_list_array);  
$renewalSql-> setContractKey($contract_key);
$renewalSql-> setRenewalFee($renewal_fee);  
$renewalSql-> setServiceTotal($service_total); 
$renewalSql-> setGrandTotal($grand_total);
$renewalSql-> setTodaysPayment($todays_payment);
$renewalSql-> setBalanceDue($balance_due);
$renewalSql-> setBalanceDueDate($balance_due_date);
$renewalSql-> setGroupTypeContract($group_type);
$renewalSql-> setGroupTypeName($group_name);
$renewalSql-> setPifOutBool($pif_out_bool);
$renewalSql-> setPifOutTime($pif_out_time);
$renewalSql-> setPifOutMoneyOwed($pif_out_money_owed);
$renewalSql-> setPastDueAmount($past_due_amount);
$renewalSql-> setYearQuantity($year_quantity);
$renewalSql-> setOldKey($old_key);
$renewalSql-> setChangedServiceBool($changed_service_bool);
$renewalSql-> setSig($sig);
$_SESSION['renewalSql'] = $renewalSql;

$value = "1";

echo"$value";
exit;

?>