<?php
session_start();

include"loadStuff.php";
include"loadWebsitePreferences.php";

unset($_SESSION['userFirstName']);
unset($_SESSION['userContractKey']);
unset($_SESSION['userBarcode']);
header( 'Location: webIndex.php' ) ;
?>