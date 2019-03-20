<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

require"../dbConnect.php";
$clubId = $_SESSION['location_id'];
    
  
$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($clubId); 
$stmt->fetch();
$stmt->close();
    
$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($userName, $password);
$stmt->fetch();
$stmt->close();
    //=================================
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";

//============================================
$card_type = $_REQUEST['card_type'];
$card_name = $_REQUEST['card_name'];
$card_number = $_REQUEST['card_number'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$credit_pay = $_REQUEST['credit_pay'];
$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_number = $_REQUEST['account_number'];
$routing_number = $_REQUEST['routing_number'];
$account_street = $_REQUEST['account_street'];
$account_city = $_REQUEST['account_city'];
$account_state = $_REQUEST['account_state'];
$account_zip = $_REQUEST['account_zip'];
$account_phone = $_REQUEST['account_phone'];
$account_email = $_REQUEST['account_email'];
$lic_number = $_REQUEST['lic_number'];
$ach_pay =$_REQUEST['ach_pay'];
$contract_key =$_REQUEST['contractKey'];



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
$contract_key = urldecode($contract_key);

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
$contract_key = trim($contract_key);

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
  $fieldParse-> setCardYear($card_year);
  $fieldParse-> parsePaymentFields();
  
  //reassign vars for CS Credit Cards
  $ccFirstName = $fieldParse-> getCredtCardFirstName();
  $ccLastName = $fieldParse-> getCredtCardLastName();
  $ccCardType = $fieldParse-> getCardType();
  $ccCardYear = $fieldParse-> getCardYear();
  $ccCardMonth = $card_month;
  $ccCardNumber = $card_number;
  $ccCardCvv = $card_cvv;
  $ccCardPayment = $credit_pay;

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

    
     $merchField1 = "ACH Prepayment $contract_key";
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
    $r = $gw->doAchSale($achPayment, $payTypeFlag, $checkName, $achRoutingNumber, $achAccountNumber, $account_holder_type, $account_type, $merchField1, $merchField1);
    
    $achAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $achAuthReasonCode = $gw->responses['response_code'];
     $_SESSION['ach_request_id'] = $transactionId;
//---------------------------------------------------------------------------------------------------- 
//if both the cc and ach transactions are successful then we settle the cc transaction else spit back an error
if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. ";
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
    $reference = "CC Prepayment $contract_key";
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
          $card_result = "There was an error processing this transaction.  This Credit Card will not be charged. ERROR: $ccAuthDecision";
            echo"$card_result";
            exit;
       }else{
       
           $card_result = 1;
           $card_exp_date_array = "$card_year $card_month";           
          echo"$card_result";
          exit;       
       }
 
 
   }//end cc transaction fulfillment
    
// }//end banking and or ccc settlement

}//end if ach and cc present
//#####################################################################
//this is for ach only
if($achBool != "" &&  $ccBool == "") {

    
     $merchField1 = "ACH Prepayment $contract_key";
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $gw->setBilling("$achFirstName","$achLastName","","$achStreetAddress","", "$achState",
        "$achState","$achZip","US","$achPhone","$achPhone","$achEmail",
        "");
    $r = $gw->doAchSale($achPayment, $payTypeFlag, $checkName, $achRoutingNumber, $achAccountNumber, $account_holder_type, $account_type, $merchField1, $merchField1);
    
    $achAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $achAuthReasonCode = $gw->responses['response_code'];
     $_SESSION['ach_request_id'] = $transactionId;

if($achAuthReasonCode != 100) {
    $ach_result = "There was a problem verifying this Banking information.  Please check the Banking fields and re-enter this information. ERROR: $debitReasonCode";
    echo"$ach_result";
    exit;   
   }else{   
    $card_result = 1;            
    echo"$card_result";
    exit;          
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
    $reference = "CC Member Sales";
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
       $card_result = "The Credit Card that was entered has been DECLINED. ERROR: $ccAuthDecision";
         echo"$card_result";
         exit;
  
      }else{
      
           $card_result = 1;
           $card_exp_date_array = "$card_year $card_month";             
          echo"$card_result";
          exit;       

      }

}
//#############################################################################################
//this sets up if there is monthly billing involved









/*
 echo"ACH Desicion:  $achAuthDecision \n ACH Reason Code: $achAuthReasonCode \n ACH Request ID: $achAuthRequestId \n ACH Debit Reason: $debitReason \n ACH Settle Method: $debitSettleMethod \n ACH Request Date: $debitDateTime \n ACH Debit Amount: $debitAmount \n ACH Debit Verify Level: $debitVerificationLevel \n ACH Reconcile ID: $debitReconcileID \n\n CC Desicion: $ccAuthDecision \n CC Reason Code: $ccAuthReasonCode \n CC Request ID: $ccAuthRequestId \n\n";


 echo"Desicion:  $ccAuthDecision \n Reason Code: $ccAuthReasonCode \n Request ID: $requestId \n  Missing: $testFields \n Invalid: $invalidFields[0] \n AVS Result: $avsResult \n Invalid: $invalid\n\n";
 echo"ccfirstName $ccFirstName \n ccLastName  $ccLastName \n ccCardType $ccCardType \n ccCardYear  $ccCardYear \n ccCardMonth $ccCardMonth \n ccCardCvv $ccCardCvv \n ccCardPayment $ccCardPayment \n ccCardNumber $ccCardNumber \n\n achFirstName $achFirstName \n achLastName $achLastName \n achStreetAddress $achStreetAddress \n achCity $achCity \n achState $achState \n achZip $achZip \n achPhone $achPhone \n achEmail $achEmail \n achDriversLic $achDriversLic \n achAccountType $achAccountType \n achRoutingNumber $achRoutingNumber \n achAccountNumber $achAccountNumber \n achPayment $achPayment \n\n";
*/

?>