<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$pos_key = $_REQUEST['pos_key'];
$sid = $_REQUEST['sid']; 
$id = $_REQUEST['id'];
$invoice = $_REQUEST['invoice'];

include "refundPos.php";
$refundEx = new refundExchange();
$refundEx-> setId($id);
$refundEx-> setPoskey($pos_key);
$refundEx-> setInvoice($invoice); 
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
  

  
$_SESSION['html'] = $html;
$_SESSION['image_name'] = $image_name;
$_SESSION['logo'] = $logo;
$_SESSION['$bus_name'] = $bus_name;
$_SESSION['$club_name'] = $club_name;
$_SESSION['$club_address'] = $club_address;
$_SESSION['$club_phone'] = $club_phone;
$_SESSION['$receiptItems'] = $receiptItems;
$_SESSION['$retailCost'] = $retailCost;
$_SESSION['$salesTax'] = $salesTax;
$_SESSION['$totCost'] = $totCost;
$_SESSION['$invType'] = $invType;
   //echo"$refund_exchange_status";
   //exit;
//shows the copyright at bottom of page
//$_SESSION['pos_key'] = $pos_key;

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