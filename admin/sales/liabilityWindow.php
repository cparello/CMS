<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}


$lib_emg_contact_array = $_SESSION['lib_emg_contact_array']; 
$lib_address_array = $_SESSION['lib_address_array']; 
$contract_key = $_SESSION['contract_key']; 
$business_name = $_SESSION['business_name'];
$business_address = $_SESSION['business_address'];

include "liabilitySql.php";
$liabilitySql = new liabilitySql();
$liabilitySql-> loadLiabilityDefaults();
$logo_image = $liabilitySql-> getLogoImage();
$waiver_header = $liabilitySql-> getWaiverTypeHeader();
$liabilitySql-> setBusinessName($business_name);
$liabilitySql-> setBusinessAddress($business_address);

$liabilitySql-> parseContactInfo($lib_address_array);
$first_name = $liabilitySql-> getFirstName();
$middle_name = $liabilitySql-> getMiddleName();
$last_name = $liabilitySql-> getLastName();
$street_address = $liabilitySql-> getStreetAddress();
$primary_phone = $liabilitySql-> getPrimaryPhone();
$cell_phone = $liabilitySql-> getCellPhone();
$email_address = $liabilitySql-> getEmailAddress();

$liability_terms = $liabilitySql-> getLiabilityTerms();
$liabilitySql-> loadContractLocation(); 
$contract_location = $liabilitySql-> getContractLocation();

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";

include "../templates/liabilityTemplate.php";


unset($_SESSION['lib_emg_contact_array']);
unset($_SESSION['lib_address_array']);
unset($_SESSION['contract_key']);


?>