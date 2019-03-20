<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$contract_key = $_REQUEST['contract_key'];
$sid = $_REQUEST['sid']; 
//shows the copyright at bottom of page
$_SESSION['contract_key'] = $contract_key;

if (isset($_SESSION['contract_key']))  {
    $result = 1;
    echo "$result";
    exit;
    }else{
    $result = 0;
    echo"$result";
    exit;
    }
    
    
?>