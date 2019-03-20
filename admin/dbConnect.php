<?php
//session_start();
$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','cmp_1000'); 	
if ($dbMain->connect_error) {
    die('Connect Error: ' . $dbMain->connect_error);
} 		
?>