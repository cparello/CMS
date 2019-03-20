<?php
$invoice = $_REQUEST['invoice'];

$invoice = urldecode($invoice);
$invoice = trim($invoice);

echo $invoice;
exit;
?>