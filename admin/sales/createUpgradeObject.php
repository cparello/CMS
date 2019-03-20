<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout
$group_info_array=$_REQUEST['group_info_array'];
$address_info_array=$_REQUEST['address_info_array'];
$product_list_array=$_REQUEST['product_list_array'];
$new_members=$_REQUEST['new_members'];
$current_prorate_array=$_REQUEST['current_prorate_array'];
$transfer=$_REQUEST['transfer'];
$pro_rate_dues=$_REQUEST['pro_rate_dues'];
$proc_fee_eft=$_REQUEST['proc_fee_eft'];
$initial_fees_eft=$_REQUEST['initial_fees_eft'];
$monthly_payment=$_REQUEST['monthly_payment'];
$new_monthly_payment=$_REQUEST['new_monthly_payment'];
$current_monthly_prorate=$_REQUEST['current_monthly_prorate'];
$total_monthly_services=$_REQUEST['total_monthly_services'];
$open_ended=$_REQUEST['open_ended'];
$initiation_fee=$_REQUEST['initiation_fee'];
$new_total_pif_services=$_REQUEST['new_total_pif_services'];
$proc_fee_pif=$_REQUEST['proc_fee_pif'];
$new_pif_grand_total=$_REQUEST['new_pif_grand_total'];
$current_pif_prorate_total=$_REQUEST['current_pif_prorate_total'];
$new_current_pif_grand_total=$_REQUEST['new_current_pif_grand_total'];
$current_renew_total=$_REQUEST['current_renew_total'];
$current_monthly_payment=$_REQUEST['current_monthly_payment'];
$new_member_fee=$_REQUEST['new_member_fee'];
$new_services_total=$_REQUEST['new_services_total'];
$new_renewal_rate_total=$_REQUEST['new_renewal_rate_total'];
$minimum_total_due=$_REQUEST['minimum_total_due'];
$todays_payment=$_REQUEST['todays_payment'];
$balance_due=$_REQUEST['balance_due'];
$balance_due_date=$_REQUEST['balance_due_date'];
$contract_key=$_REQUEST['contract_key'];
$group_number=$_REQUEST['group_number'];
$group_name=$_REQUEST['group_name'];
$monthly_billing_type=$_REQUEST['$monthly_billing_type'];
$delete_switch = $_REQUEST['delete_switch'];
$sid = $_REQUEST['sid'];
$new_upgrade_service_key = $_REQUEST['new_upgrade_service_key'];
$sig = $_REQUEST['sig'];

$group_info_array=urldecode($group_info_array);
$address_info_array=urldecode($address_info_array);
$product_list_array=urldecode($product_list_array);
$new_members=urldecode($new_members);
$current_prorate_array=urldecode($current_prorate_array);
$transfer=urldecode($transfer);
$pro_rate_dues=urldecode($pro_rate_dues);
$proc_fee_eft=urldecode($proc_fee_eft);
$initial_fees_eft=urldecode($initial_fees_eft);
$monthly_payment=urldecode($monthly_payment);
$new_monthly_payment=urldecode($new_monthly_payment);
$current_monthly_prorate=urldecode($current_monthly_prorate);
$total_monthly_services=urldecode($total_monthly_services);
$open_ended=urldecode($open_ended);
$initiation_fee=urldecode($initiation_fee);
$new_total_pif_services=urldecode($new_total_pif_services);
$proc_fee_pif=urldecode($proc_fee_pif);
$new_pif_grand_total=urldecode($new_pif_grand_total);
$current_pif_prorate_total=urldecode($current_pif_prorate_total);
$new_current_pif_grand_total=urldecode($new_current_pif_grand_total);
$current_renew_total=urldecode($current_renew_total);
$current_monthly_payment=urldecode($current_monthly_payment);
$new_member_fee=urldecode($new_member_fee);
$new_services_total=urldecode($new_services_total);
$new_renewal_rate_total=urldecode($new_renewal_rate_total);
$minimum_total_due=urldecode($minimum_total_due);
$todays_payment=urldecode($todays_payment);
$balance_due=urldecode($balance_due);
$balance_due_date=urldecode($balance_due_date);
$contract_key=urldecode($contract_key);
$group_number=urldecode($group_number);
$group_name=urldecode($group_name);
$monthly_billing_type=urldecode($monthly_billing_type);
$new_upgrade_service_key=urldecode($new_upgrade_service_key);

//create the sales sql object to store the sales info for the contract forms
include "upgradeSql.php";
$_SESSION['upgradeSql'] = new upgradeSql();
$upgradeSql = $_SESSION['upgradeSql']; 

if($delete_switch == 1)   {
 $delete_key =  $upgradeSql-> deleteUpgrade();
 echo"$delete_key";
 exit;
}



$upgradeSql-> setGroupType($group_type); 
$upgradeSql-> setGroupName($group_name);
$upgradeSql-> setGroupInfoArray($group_info_array);
$upgradeSql-> setAddressInfoArray($address_info_array); 
$upgradeSql-> setProductListArray($product_list_array);
$upgradeSql-> setNewMembers($new_members);
$upgradeSql-> setCurrentProrateArray($current_prorate_array);
$upgradeSql-> setTransfer($transfer);
$upgradeSql-> setProRateDues($pro_rate_dues);
$upgradeSql-> setProcFeeEft($proc_fee_eft);
$upgradeSql-> setInitialFeesEft($initial_fees_eft); 
$upgradeSql-> setMonthlyPayment($monthly_payment);
$upgradeSql-> setNewMonthlyPayment($new_monthly_payment); 
$upgradeSql-> setCurrentMonthlyProrate($current_monthly_prorate);
$upgradeSql-> setTotalMonthlyServices($total_monthly_services);
$upgradeSql-> setTermType($open_ended);
$upgradeSql-> setInitiationFee($initiation_fee);
$upgradeSql-> setNewTotalPifServices($new_total_pif_services);
$upgradeSql-> setProcFeePif($proc_fee_pif);
$upgradeSql-> setNewPifgrandTotal($new_pif_grand_total);
$upgradeSql-> setCurrentPifProrateTotal($current_pif_prorate_total); 
$upgradeSql-> setNewCurrentPifGrandTotal($new_current_pif_grand_total);
$upgradeSql-> setCurrentRenewTotal($current_renew_total);
$upgradeSql-> setCurrentMonthlyPayment($current_monthly_payment);
$upgradeSql-> setNewMemberFee($new_member_fee);
$upgradeSql-> setNewServicesTotal($new_services_total);
$upgradeSql-> setNewRenewalRateTotal($new_renewal_rate_total);
$upgradeSql-> setMinimumTotalDue($minimum_total_due);
$upgradeSql-> setTodaysPayment($todays_payment);
$upgradeSql-> setBalanceDue($balance_due);
$upgradeSql-> setDueDate($balance_due_date);
$upgradeSql-> setContractKey($contract_key);
$upgradeSql-> setGroupNumber($group_number);
$upgradeSql-> setFirstName($first_name);
$upgradeSql-> setMiddleName($middle_name);
$upgradeSql-> setLastName($last_name);
$upgradeSql-> setMonthlyBillingType($monthly_billing_type);
$upgradeSql-> setNewUpgradeServiceKey($new_upgrade_service_key);
$upgradeSql-> setSig($sig);

$_SESSION['upgradeSql'] = $upgradeSql;

$value = "1";

echo"$value";
exit;

?>