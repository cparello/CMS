<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$indi_print_form = $_SESSION['indi_print_form'];

echo"$indi_print_form";


unset($_SESSION['indi_print_form']);
exit;
?>