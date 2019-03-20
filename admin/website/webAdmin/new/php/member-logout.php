<?php
session_start();

unset($_SESSION['userFirstName']);
unset($_SESSION['userContractKey']);
unset($_SESSION['userBarcode']);
header( 'Location: ../index.php' ) ;
?>