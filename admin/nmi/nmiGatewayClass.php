<?php


define("APPROVED", 1);
define("DECLINED", 2);
define("ERROR", 3);

class gwapi {
    //===============================================================
 function setLogin($username, $password) {
    $this->login['username'] = $username;
    $this->login['password'] = $password;
  }
  //===================================================================
  function setBilling($firstname, $lastname, $company, $address1, $address2, $city, $state, $zip, $country, $phone, $fax, $email, $website) {
    $this->billing['firstname'] = $firstname; 
    $this->billing['lastname']  = $lastname;
    $this->billing['company']   = $company;
    $this->billing['address1']  = $address1;
    $this->billing['address2']  = $address2;
    $this->billing['city']      = $city;
    $this->billing['state']     = $state;
    $this->billing['zip']       = $zip;
    $this->billing['country']   = $country;
    $this->billing['phone']     = $phone;
    $this->billing['fax']       = $fax;
    $this->billing['email']     = $email;
    $this->billing['website']   = $website;
  }
//============================================================================================
  function doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $fname, $lname) {
    
    
    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    //address
    $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
    $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
    $query .= "address1=" . urlencode($this->billing['address1']) . "&";
    $query .= "city=" . urlencode($this->billing['city']) . "&";
    $query .= "state=" . urlencode($this->billing['state']) . "&";
    $query .= "zip=" . urlencode($this->billing['zip']) . "&";
    $query .= "phone=" . urlencode($this->billing['phone']) . "&";
    $query .= "email=" . urlencode($this->billing['email']) . "&";
    //payment
    $query .= "payment=" . urlencode($payTypeFlag) . "&";
    //$query .= "dup_seconds=" . urlencode($dupSecs) . "&"; 
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    $query .= "orderid=" . urlencode($orderId) . "&";
    
    // Sales Information
    $query .= "first_name=" . urlencode($fname) . "&";
    $query .= "last_name=" . urlencode($lname) . "&";
    $query .= "ccnumber=" . urlencode($ccnumber) . "&";
    $query .= "ccexp=" . urlencode($ccexp) . "&";
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "cvv=" . urlencode($cvv) . "&";
    $query .= "track_1=" . urlencode($track1) . "&";
    $query .= "track_2=" . urlencode($track2) . "&";
    
    $query .= "type=sale";
    return $this->_doPost($query);
  }
  //===================================================================================================
 function doPreAuthCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $merchField1, $fname, $lname, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    //payment
    $query .= "payment=" . urlencode($payTypeFlag) . "&";
    // Sales Information
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "first_name=" . urlencode($fname) . "&";
    $query .= "last_name=" . urlencode($lname) . "&";
    $query .= "ccnumber=" . urlencode($ccnumber) . "&";
    $query .= "ccexp=" . urlencode($ccexp) . "&";
    $query .= "cvv=" . urlencode($cvv) . "&";
    $amount = 1;
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    //vault
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    
    $query .= "type=auth";
    return $this->_doPost($query);
  }
//===================================================================================================
 function doVaultCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $vaultFunction, $vaultId, $merchField1, $fname, $lname, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    //address
    $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
    $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
    $query .= "address1=" . urlencode($this->billing['address1']) . "&";
    $query .= "city=" . urlencode($this->billing['city']) . "&";
    $query .= "state=" . urlencode($this->billing['state']) . "&";
    $query .= "zip=" . urlencode($this->billing['zip']) . "&";
    $query .= "phone=" . urlencode($this->billing['phone']) . "&";
    $query .= "email=" . urlencode($this->billing['email']) . "&";
    
    //payment
    $query .= "payment=" . urlencode($payTypeFlag) . "&";
    // Sales Information
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "first_name=" . urlencode($fname) . "&";
    $query .= "last_name=" . urlencode($lname) . "&";
    $query .= "ccnumber=" . urlencode($ccnumber) . "&";
    $query .= "ccexp=" . urlencode($ccexp) . "&";
    $query .= "cvv=" . urlencode($cvv) . "&";
    //vault
    $query .= "customer_vault=" . urlencode($vaultFunction) . "&";// 'add_customer' or 'update_customer'
    $query .= "customer_vault_id=" . urlencode($vaultId) . "&";
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    
   // $query .= "type=validate";
    return $this->_doPost($query);
  }
//===================================================================================================
function doVaultAch($payTypeFlag, $vaultFunction, $vaultId, $checkName, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merchField1, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    //address
    $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
    $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
    $query .= "address1=" . urlencode($this->billing['address1']) . "&";
    $query .= "city=" . urlencode($this->billing['city']) . "&";
    $query .= "state=" . urlencode($this->billing['state']) . "&";
    $query .= "zip=" . urlencode($this->billing['zip']) . "&";
    $query .= "phone=" . urlencode($this->billing['phone']) . "&";
    $query .= "email=" . urlencode($this->billing['email']) . "&";
    //payment
    $query .= "payment=" . urlencode($payTypeFlag) . "&";
    //check
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "checkname=" . urlencode($checkName) . "&";
    $query .= "checkaba=" . urlencode($bankRoutingNumber) . "&";
    $query .= "checkaccount=" . urlencode($bankAccountNumber) . "&";
    $query .= "account_holder_type=" . urlencode($account_holder_type) . "&";
    $query .= "account_type=" . urlencode($account_type) . "&";
    //vault
    $query .= "customer_vault=" . urlencode($vaultFunction) . "&";// 'add_customer' or 'update_customer'
    $query .= "customer_vault_id=" . urlencode($vaultId) . "&";
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    
    return $this->_doPost($query);
  }
//===================================================================================================
function doAchSale($amount, $payTypeFlag, $checkName, $bankRoutingNumber, $bankAccountNumber, $account_holder_type, $account_type, $merchField1, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    //address
    $query .= "firstname=" . urlencode($this->billing['firstname']) . "&";
    $query .= "lastname=" . urlencode($this->billing['lastname']) . "&";
    $query .= "address1=" . urlencode($this->billing['address1']) . "&";
    $query .= "city=" . urlencode($this->billing['city']) . "&";
    $query .= "state=" . urlencode($this->billing['state']) . "&";
    $query .= "zip=" . urlencode($this->billing['zip']) . "&";
    $query .= "phone=" . urlencode($this->billing['phone']) . "&";
    $query .= "email=" . urlencode($this->billing['email']) . "&";
    //payment
    $query .= "payment=" . urlencode($payTypeFlag) . "&";
    //check
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    $query .= "checkname=" . urlencode($checkName) . "&";
    $query .= "checkaba=" . urlencode($bankRoutingNumber) . "&";
    $query .= "checkaccount=" . urlencode($bankAccountNumber) . "&";
    $query .= "account_holder_type=" . urlencode($account_holder_type) . "&";
    $query .= "account_type=" . urlencode($account_type) . "&";
    //vault
    $query .= "customer_vault=" . urlencode($vaultFunction) . "&";// 'add_customer' or 'update_customer'
    $query .= "customer_vault_id=" . urlencode($vaultId) . "&";
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    $query .= "type=sale";
    
    return $this->_doPost($query);
  }

//=================================================================================================  
  
  function doVaultSale($amount, $vaultId, $billMethod, $merchField1, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    $query .= "customer_vault_id=" . urlencode($vaultId) . "&";
    $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
   // $query .= "dup_seconds=" . urlencode($dupSecs) . "&";
   $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "billing_method=" . urlencode($billMethod) . "&";//'recurring' 
    $query .= "merchant_defined_field_1=" . urlencode($merchField1) . "&";
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "type=sale";
    return $this->_doPost($query);
  }
  //======================================================================================
  function doVoid($transactionid, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    $query .= "orderid=" . urlencode($orderId) . "&";
    // Transaction Information
    $query .= "transactionid=" . urlencode($transactionid) . "&";
    $query .= "type=void";
    return $this->_doPost($query);
  }
//================================================================================================
  function doRefund($transactionid, $amount, $orderId) {

    $query  = "";
    // Login Information
    $query .= "username=" . urlencode($this->login['username']) . "&";
    $query .= "password=" . urlencode($this->login['password']) . "&";
    // Transaction Information
    $query .= "orderid=" . urlencode($orderId) . "&";
    $query .= "transactionid=" . urlencode($transactionid) . "&";
    if ($amount>0) {
        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
    }
    $query .= "type=refund";
    return $this->_doPost($query);
  }
//===============================================================
function _doPost($query) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://secure.networkmerchants.com/api/transact.php");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_POST, 1);

    if (!($data = curl_exec($ch))) {
        return ERROR;
    }
    curl_close($ch);
    unset($ch);
   //print "\n$data\n";
    $data = explode("&",$data);
    for($i=0;$i<count($data);$i++) {
        $rdata = explode("=",$data[$i]);
        $this->responses[$rdata[0]] = $rdata[1];
    }
    return $this->responses['response'];
  }
}

?>