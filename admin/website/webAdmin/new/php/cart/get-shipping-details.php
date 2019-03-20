<?php

  /* Get the shipping details by the userContractKey */
  function getShippingDetails() {

    $shipping_details1 = array();
//print("\$shipping_details1="); print_r($shipping_details1); return "www"; // !debug!
    $first_name		= '1';
    $middle_name	= '2';
    $last_name		= '3';
    $street_address	= '4';
    $city		= '5';
    $state		= '6';
    $zip_code		= '7';
    $home_phone		= '8';
    $email		= '9';

    if (isset($_SESSION['userContractKey']))
     {
      $contract_key = $_SESSION['userContractKey'];
      //require "../../../dbConnect.php";
      include "../../../dbConnect.php";
      $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, street, city, state, zip, primary_phone, email FROM member_info WHERE contract_key= '$contract_key'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($first_name, $middle_name, $last_name, $street_address, $city, $state, $zip_code, $home_phone, $email);
      $stmt->fetch();
      $stmt->close();
/*
    */

      $shipping_details1['first_name']		= $first_name;
      $shipping_details1['middle_name']		= $middle_name;
      $shipping_details1['last_name']		= $last_name;
      $shipping_details1['street_address']	= $street_address;
      $shipping_details1['city']		= $city;
      $shipping_details1['state']		= $state;
      $shipping_details1['zip_code']		= $zip_code;
      $shipping_details1['home_phone']		= $home_phone;
      $shipping_details1['email']		= $email;
     }

    return $shipping_details1;
  }

?>