<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}



$lib_address_array = $_SESSION['lib_address_array']; 
$contract_key = $_SESSION['contract_key']; 
$location_id = $_SESSION['location_id'];
$attendee_bit = $_SESSION['attendee_bit'];


include "../clubs/locationSql.php";
$locationInfo = new locationSql();
$locationInfo-> setLocationId($location_id);
$locationInfo-> loadLocation();
$business_address = $locationInfo->getLocationAddress();

include "../headFootTwo.php";
$getHeadFoot = new headFootTwo();
$getHeadFoot -> loadNames();
$business_name = $getHeadFoot-> getBusinessName(); 

include "../sales/liabilitySql.php";
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

if($contract_key == 'NA') {
  $info_header = 'Guest Information';
  $name_header = 'Guest Name';
  $sig_blurb = 'SIGNATURE OF GUEST';
  
      //see if from schedular
      if($attendee_bit == 1) {
          $info_header = 'Attendee Information';
          $name_header = 'Attendee Name';
          $sig_blurb = 'SIGNATURE OF CLASS ATTENDEE';              
        }
  
  
  }else{
  $info_header = 'Member Information';
  $name_header = 'Member Name';
  $sig_blurb = 'SIGNATURE OF MEMBER';
  }


include "../templates/liabilityTemplate.php";


unset($_SESSION['lib_emg_contact_array']);
unset($_SESSION['lib_address_array']);
unset($_SESSION['contract_key']);
unset($_SESSION['attendee_bit']);

?>