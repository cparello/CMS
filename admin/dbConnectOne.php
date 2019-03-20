<?php
$dbMainOne = new mysqli('localhost','emsdata','6ym5yst3ms!','ems_admin');    
if ($dbMainOne->connect_error) {
    die('Connect Error: ' . $dbMainOne->connect_error);
}        
?>