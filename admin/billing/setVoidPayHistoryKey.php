<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$date = $_REQUEST['date'];
$bill_type = $_REQUEST['bill_type'];
$c_key = $_REQUEST['c_key'];
$request_id = $_REQUEST['request_id']; 
$sid = $_REQUEST['sid'];
$descrip = $_REQUEST['descrip'];
$amount = $_REQUEST['amount'];

include "refundPayHistory.php";
$refundEx = new refundExchange();
$refundEx-> setBillType($bill_type);
$refundEx-> setRequestId($request_id);
$refundEx-> setCkey($c_key); 
$refundEx-> setAmount($amount);
$refundEx-> setPayDate($date);
$refundEx-> setDescrip($descrip);
$refundEx-> loadRefundExchange();
$refund_exchange_status = $refundEx-> getPaymentStatus();

$html = $refundEx-> getHtml();
$image_name = $refundEx->  getImageName();
$logo = $refundEx->  getLogo() ;
$bus_name  = $refundEx->  getBusinessName();
$club_name = $refundEx->  getClubName();
$club_address  = $refundEx->  getClubAddress();
$club_phone  = $refundEx->  getClubPhone();
$receiptItems = $refundEx->  getReceiptItems();
$retailCost = $refundEx->  getRetailCost();
$salesTax  = $refundEx->  getSalesTax();
$totCost  = $refundEx->  getTotalCost();
$invType = $refundEx->  getInvoiceType();
$decision = $refundEx->  getAuthDecision();
  

  
$_SESSION['html'] = $html;
$_SESSION['image_name'] = $image_name;
$_SESSION['logo'] = $logo;
$_SESSION['bus_name'] = $bus_name;
$_SESSION['club_name'] = $club_name;
$_SESSION['club_address'] = $club_address;
$_SESSION['club_phone'] = $club_phone;
$_SESSION['receiptItems'] = $receiptItems;
$_SESSION['retailCost'] = $retailCost;
$_SESSION['salesTax'] = $salesTax;
$_SESSION['totCost'] = $totCost;
$_SESSION['invType'] = $invType;
$_SESSION['decision'] = $decision;
   //echo"$refund_exchange_status";
   //exit;
//shows the copyright at bottom of page
//$_SESSION['pos_key'] = $pos_key;
//echo "fubar   $refund_exchange_status xxx";
if ($refund_exchange_status == 1)  {
    $result = 1;
    echo "$result";
    exit;
    }else{
    $result = 0;
    echo"$result";
    exit;
    }
    
    
?>