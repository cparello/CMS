<?php
require"../../../../nmi/nmiGatewayClass.php";
include "trainingSalesSql.php";
//include"gatewayAuth.php";
//include"../../../../cybersource/cybersourceSoapClient.php";
include"../../../../cybersource/parseGatewayFields.php";
session_start();
$clubId = $_REQUEST['clubId'];
$_SESSION['location_id'] = $clubId;


//=======================================================
require"../../../../dbConnect.php";
    
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
  
   // echo "club id $club_id";
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();
//============================================
//echo "$clubId";
//exit;
$card_type=$_REQUEST['card_type'];
$card_name=$_REQUEST['card_name'];
$card_number=$_REQUEST['card_number'];
$card_cvv=$_REQUEST['card_cvv'];
$card_month=$_REQUEST['card_month'];
$card_year=$_REQUEST['card_year'];
$credit_pay=$_REQUEST['credit_pay'];
$bank_name=$_REQUEST['bank_name'];
$account_type=$_REQUEST['account_type'];
$account_name=$_REQUEST['account_name'];
$account_number=$_REQUEST['account_number'];
$routing_number=$_REQUEST['routing_number'];
$account_street=$_REQUEST['account_street'];
$account_city=$_REQUEST['account_city'];
$account_state=$_REQUEST['account_state'];
$account_zip=$_REQUEST['account_zip'];
$account_phone=$_REQUEST['account_phone'];
$account_email=$_REQUEST['account_email'];
$lic_number=$_REQUEST['lic_number'];
$ach_pay=$_REQUEST['ach_pay'];
$merchant_reference_code=$_REQUEST['merchant_reference_code'];
$totalServiceArray=$_REQUEST['totalServiceArray'];
$totalGearArray=$_REQUEST['totalGearArray'];
$transactionBool = 0;


if($credit_pay != "" ||  $ach_pay != "") {
    
$totalServiceArray = urldecode($totalServiceArray);
$totalGearArray = urldecode($totalGearArray);
$totalServiceArray = trim($totalServiceArray);
$totalGearArray = trim($totalGearArray);

//here is where we format the variables 
$card_type = urldecode($card_type);
$card_name = urldecode($card_name);
$card_number = urldecode($card_number);
$card_cvv = urldecode($card_cvv);
$card_month = urldecode($card_month);
$card_year = urldecode($card_year);
$credit_pay = urldecode($credit_pay);

$card_type = trim($card_type);
$card_name = trim($card_name);
$card_number = trim($card_number);
$card_cvv = trim($card_cvv);
$card_month = trim($card_month);
$card_year = trim($card_year);
$credit_pay = trim($credit_pay);


$bank_name = urldecode($bank_name);
$account_type = urldecode($account_type);
$account_name = urldecode($account_name);
$account_number = urldecode($account_number);
$routing_number = urldecode($routing_number);
$account_street = urldecode($account_street);
$account_city = urldecode($account_city);
$account_state = urldecode($account_state);
$account_zip = urldecode($account_zip);
$account_phone = urldecode($account_phone);
$account_email = urldecode($account_email);
$lic_number = urldecode($lic_number);
$ach_pay = urldecode($ach_pay);

$bank_name = trim($bank_name);
$account_type = trim($account_type);
$account_name = trim($account_name);
$account_number =trim($account_number);
$routing_number = trim($routing_number);
$account_street = trim($account_street);
$account_city = trim($account_city);
$account_state = trim($account_state);
$account_zip = trim($account_zip);
$account_phone = trim($account_phone);
$account_email = trim($account_email);
$lic_number = trim($lic_number);
$ach_pay = trim($ach_pay);

//echo"$account_street";
//exit;

//replace anything that is not a number for cc routing number bank account number
$card_number = preg_replace("/[^0-9 .]+/", "" ,$card_number);
$routing_number = preg_replace("/[^0-9 .]+/", "" ,$routing_number);
$account_number = preg_replace("/[^0-9 .]+/", "" ,$account_number);

//create marker for type of transactions
$achBool = $ach_pay;
$ccBool = $credit_pay;
if($achBool == 0) {
  $achBool = "";
  }
if($ccBool == 0) {
  $ccBool = "";
  }

$ach_pay = number_format($ach_pay, 2, '.', '');
$credit_pay = number_format($credit_pay, 2, '.', '');

  $fieldParse = new parseGatewayFields(); 
  $fieldParse-> setCardName($card_name);
  $fieldParse-> setAchName($account_name);
  $fieldParse-> setCardType($card_type);
  $fieldParse-> setAccountType($account_type);
  $fieldParse-> setAccountPhone($account_phone);
  //$fieldParse-> setCardYear($card_year);
  $fieldParse-> parsePaymentFields();
 
  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
 // $ccCardYear = $fieldParse-> getCardYear();
  $ccCardYear = $card_year;
  $ccCardMonth = $card_month;
  $ccCardNumber = $card_number;
  $ccCardCvv = $card_cvv;
  $ccCardPayment = $credit_pay;
  
  if(strlen($ccCardYear) == '4'){
    $ccCardYear = substr($ccCardYear,2,2);
  }
 // echo"$ccCardCvv";
//  exit;

  //reassign vars for ACH  
  $achFirstName = $fieldParse-> getAchFirstName();
  $achLastName = $fieldParse-> getAchLastName();  
  $achStreetAddress = $account_street;
  $achCity = $account_city;
  $achState = $account_state;
  $achZip = $account_zip;
  $achPhone = $fieldParse-> getAccountPhone(); 
  $achEmail = $account_email;
  $achDriversLic = $lic_number;
  $achAccountType = $fieldParse-> getAccountType();
  $achRoutingNumber = $routing_number;
  $achAccountNumber = $account_number;
  $achPayment = $ach_pay;

//echo"ACH: $achCity  CC: $achState";
//exit;

//#######################################################################################
//do comparisons for cc and  ach.  If both are not null then we do a pre authorization. Also parsse vars for cs
if($achBool != "" &&  $ccBool != "") {

    
    $merchField1 = "ACH  Web Training  Sales";
    $payTypeFlag = "check";
    $checkname = "$achFirstName $achLastName";	//The name on the customer's ACH account.
            
           // if($account_type_cmp == 'C'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
          /*  }else if($account_type_cmp == 'B'){
               $account_holder_type = "business";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($account_type_cmp == 'S'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "savings";//*** checking/savings
            }      */
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $gw->setBilling("$achFirstName","$achLastName","","$achStreetAddress","", "$achState",
        "$achState","$achZip","US","$achPhone","$achPhone","$achEmail",
        "");
    $r = $gw->doAchSale($achPayment, $payTypeFlag, $checkName, $achRoutingNumber, $achAccountNumber, $account_holder_type, $account_type, $merchField1);
    
    $achAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $achAuthReasonCode = $gw->responses['response_code'];
     $_SESSION['ach_request_id'] = $transactionId;
//---------------------------------------------------------------------------------------------------- 
//if both the cc and ach transactions are successful then we settle the cc transaction else spit back an error
if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. Error: $achAuthDecision Code: $achAuthReasonCode.";
    echo"$ach_result";
    exit;   
   }else{
    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;
	$check = null;
	
    
        $name = "$ccFirstName $ccLastName";
     $amount = $ccCardPayment;
    $reference = "CC Web Training Sales";
        //credit"";//
        $ccnumber = $ccCardNumber;//"4111111111111111";
        $ccexp = "$ccCardMonth$ccCardYear";//"1010";
        $cvv = "";
            //==================
        //$vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
        $orderId = "$reference";
        $merchField1 = "$reference";
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        if(isset($_SESSION['track1'])){
            $track1 = $_SESSION['track1'];
        }else{
             $track1 = "";
        }
        if(isset($_SESSION['track2'])){
            $track2 = $_SESSION['track2'];
        }else{
             $track2 = "";
        }
        //$dupSecs = 3000;
            //======================== 
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $gw->setBilling("$achFirstName","$achLastName","","$achStreetAddress","", "$achState",
        "$achState","$achZip","US","$achPhone","$achPhone","$achEmail",
        "");
        $r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
        
        $ccAuthDecision = $gw->responses['responsetext'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];
 
    if($ccAuthReasonCode != 100) {
          $card_result = "There was an error processing this transaction.  This Credit Card will not be charged. Error: $ccAuthDecision Code: $ccAuthReasonCode";
            echo"$card_result";
            exit;
       }else{
            $_SESSION['cc_request_id'] = $transaction_id;
           $card_result = 1;
           $transactionBool = 1;
           
          echo"$card_result";
          //exit;       
       }
 
 
   }//end cc transaction fulfillment
    
 //}//end banking and or ccc settlement

}//end if ach and cc present
 
//#####################################################################
//this is for ach only
if($achBool != "" &&  $ccBool == "") {

    
    $merchField1 = "ACH  Web Training  Sales";
    $payTypeFlag = "check";
    $checkname = "$achFirstName $achLastName";	//The name on the customer's ACH account.
            
           // if($account_type_cmp == 'C'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
          /*  }else if($account_type_cmp == 'B'){
               $account_holder_type = "business";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "checking";//*** checking/savings
            }else if($account_type_cmp == 'S'){
               $account_holder_type = "personal";//***	The customer's ACH account entity.Values: 'personal' or 'business'
               $account_type = "savings";//*** checking/savings
            }      */
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $gw->setBilling("$achFirstName","$achLastName","","$achStreetAddress","", "$achState",
        "$achState","$achZip","US","$achPhone","$achPhone","$achEmail",
        "");
    $r = $gw->doAchSale($achPayment, $payTypeFlag, $checkName, $achRoutingNumber, $achAccountNumber, $account_holder_type, $account_type, $merchField1);
    
    $achAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $achAuthReasonCode = $gw->responses['response_code'];
     $_SESSION['ach_request_id'] = $transactionId;

if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. ERROR: $achAuthDecision Code: $debitReasonCode";
    echo"$ach_result";
    exit;   
   }else{   
    $_SESSION['ach_request_id'] = $transactionId;
    $card_result = 1; 
    $transactionBool = 1;
           
    echo"$card_result";
   // exit;          
   }

}

//######################################################################
//this is for credit cards only
if($ccBool != "" &&  $achBool == "") {

    $soapClient = null;
    $request = null;
    $ccAuthService = null;	
    $billTo = null;
    $businessRules = null;
    $card = null;
    $purchaseTotals = null;
	$item = null;   
	$pos = null; 
	$reply = null;


   
    $name = "$ccFirstName $ccLastName";
     $amount = $ccCardPayment;
    $reference = "CC  Web Training  Sales";
        //credit"";//
        $ccnumber = $ccCardNumber;//"4111111111111111";
        $ccexp = "$ccCardMonth$ccCardYear";//"1010";
        $cvv = "";
            //==================
        //$vaultFunction = "";//'add_customer';//'add_customer' or 'update_customer'
        $orderId = "$reference";
        $merchField1 = "$reference";
        $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
        if(isset($_SESSION['track1'])){
            $track1 = $_SESSION['track1'];
        }else{
             $track1 = "";
        }
        if(isset($_SESSION['track2'])){
            $track2 = $_SESSION['track2'];
        }else{
             $track2 = "";
        }
        //$dupSecs = 3000;
            //======================== 
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $gw->setBilling("$achFirstName","$achLastName","","$achStreetAddress","", "$achState",
        "$achState","$achZip","US","$achPhone","$achPhone","$achEmail",
        "");
        $r = $gw->doSale($amount, $ccnumber, $ccexp, $cvv, $payTypeFlag, $orderId, $merchField1, $track1, $track2, $ccFirstName, $ccLastName);
        
        $ccAuthDecision = $gw->responses['responsetext'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];

    if($ccAuthReasonCode != 100) {
       $card_result = "The Credit Card that was entered has been DECLINED. Reason: $ccAuthDecision Code: $ccAuthReasonCode";
         echo"$card_result";
         exit;
  
      }else{
            $_SESSION['cc_request_id'] = $transaction_id;
           $card_result = 1;
           $transactionBool = 1;
           
          echo"$card_result";
          //exit;       

      }

}
//#############################################################################################
//this sets up if there is monthly billing involved


}


 
if($transactionBool == 1){
$name_add_array=$_REQUEST['name_add_array'];

$emg_contact_array=$_REQUEST['emg_contact_array'];
$host_billing_info_array=$_REQUEST['host_billing_info_array'];
$sale_array=$_REQUEST['sale_array'];
//var_dump($sale_array);
//exit;
$length=$_REQUEST['length'];
$monthlyBillingSelected = $_REQUEST['monthlyBillingSelected'];
$hostBool = $_REQUEST['hostBool'];
$sig = $_REQUEST['sig'];
$secondaryArray = $_REQUEST['secondaryArray']; 
$gearArray = $_REQUEST['gearArray'];



include "php/trainingSalesSql.php";
$salesSql = new salesSql();
//echo "fubar";
//exit;
//set the sales form variables
$salesSql-> setNameAddArray($name_add_array);
$salesSql-> setHostBool($hostBool);
$salesSql-> setEmergConArray($emg_contact_array);
$salesSql-> setHostBillingInfoArray($host_billing_info_array);
$salesSql-> setSalesArray($sale_array);  //this to be parsed

$salesSql-> setMonthlyBilling($monthlyBillingSelected);  //to be parsed contains the name and adress info
$salesSql-> setLength($length);
$salesSql-> setSig($sig);
$salesSql-> setSetAdditionalService($secondaryArray);
$salesSql-> setGearArray($gearArray);


$card_exp_date_array = date('Y-m-d',mktime(0,0,0,$card_month,1,$card_year));
//cc info
$salesSql-> setCardType($card_type);
$salesSql-> setCardName($card_name);
$salesSql-> setCardNumber($card_number);
$salesSql-> setCardCvv($card_cvv);
$salesSql-> setCardExpDate($card_exp_date_array);
$salesSql-> setCcRequestId($ccAuthRequestId);
$salesSql-> setCreditPayment($credit_pay);
//banking info

$salesSql-> setBankName($bank_name);
$salesSql-> setAccountType($account_type);
$salesSql-> setAccountName($account_name);
$salesSql-> setAccountNumber($account_number);
$salesSql-> setAbaNumber($routing_number);
$salesSql-> setAchRequestId($achAuthRequestId);
$salesSql-> setAchPayment($ach_pay);
//set the initial payment type


//set the monthly billing



//sets up the account status to current
$account_status = 'CU';
$salesSql-> setAccountStatus($account_status);

//set renewal to no since this is for saving initial sales
$renewal = 'N';
$upgrade = 'Y';
$internet = 'Y';
$salesSql-> setRenewal($renewal);
$salesSql-> setUpgrade($upgrade);
$salesSql-> setInternet($internet);

$_SESSION['salesSql'] = $salesSql;  
//echo"fub ar";
//exit;
$salesSql-> loadMain();//save all of the info




//sets up notes if a topic is present or subject


//deletes the current sql contract session

//creates a confirmation message once the data is saved
$_SESSION['confirmation_message'] = "Contract $contract_key Successfully Saved";



}

?>