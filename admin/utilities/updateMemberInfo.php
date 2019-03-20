<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$contract_key = $_REQUEST['contract_key'];
$general_id = $_REQUEST['general_id'];
$member_id = $_REQUEST['member_id'];
$first_name = $_REQUEST['first_name'];
$middle_name = $_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$street = $_REQUEST['street'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$primary_phone = $_REQUEST['primary_phone'];
$cell_phone = $_REQUEST['cell_phone'];
$email = $_REQUEST['email'];
$dob = $_REQUEST['dob'];
$license_number = $_REQUEST['license_number'];
$emg_contact = $_REQUEST['emg_contact'];
$emg_relationship = $_REQUEST['emg_relationship'];
$emg_phone = $_REQUEST['emg_phone'];
//decode the info from the ajax post
$general_id = urldecode($general_id);
$member_id = urldecode($member_id);
$first_name = urldecode($first_name);
$middle_name = urldecode($middle_name);
$last_name = urldecode($last_name);
$street = urldecode($street);
$city = urldecode($city);
$state = urldecode($state);
$zip = urldecode($zip);
$primary_phone = urldecode($primary_phone);
$cell_phone = urldecode($cell_phone);
$email = urldecode($email);
$dob = urldecode($dob);
$license_number = urldecode($license_number);
$emg_contact = urldecode($emg_contact);
$emg_relationship = urldecode($emg_relationship);
$emg_phone = urldecode($emg_phone);


$member_id = trim($member_id);
$first_name = trim($first_name);
$middle_name = trim($middle_name);
$last_name = trim($last_name);
$street = trim($street);
$city = trim($city);
$zip = trim($zip);
$primary_phone = trim($primary_phone);
$cell_phone = trim($cell_phone);
$email = trim($email);
$dob = trim($dob);

//convert dob to mysql date type
$dob = date("Y-m-d", strtotime($dob));

$license_number = trim($license_number);
$emg_contact = trim($emg_contact);
$emg_relationship = trim($emg_relationship);
$emg_phone = trim($emg_phone);


$contract_key = $_SESSION['contract_key'];


include "../utilities/updateMemberSql.php";
$updateMember = new updateMemberSql();
$updateMember-> setContractKey($contract_key);
$updateMember-> setGeneralKey($general_id);
$updateMember-> setMemberId($member_id);
$updateMember-> setFirstName($first_name);
$updateMember-> setMiddleName($middle_name);
$updateMember-> setLastName($last_name);
$updateMember-> setStreetAddress($street);
$updateMember-> setCityName($city);
$updateMember-> setStateValue($state);
$updateMember-> setZipCode($zip);
$updateMember-> setPrimaryPhone($primary_phone);
$updateMember-> setCellPhone($cell_phone);
$updateMember-> setEmailAddress($email);
$updateMember-> setDob($dob);
$updateMember-> setLicenseNumber($license_number);
$updateMember-> setEmgContact($emg_contact);
$updateMember-> setEmgRelation($emg_relationship);
$updateMember-> setEmgPhone($emg_phone);
    
$update_result = $updateMember-> updateMemberFields();

echo"$update_result";


?>