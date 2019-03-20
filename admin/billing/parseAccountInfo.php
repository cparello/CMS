<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$card_type = $_REQUEST['card_type'];
$card_name = $_REQUEST['card_name'];
$card_number = $_REQUEST['card_number'];
$card_number = $_REQUEST['card_number'];
$card_cvv = $_REQUEST['card_cvv'];
$card_month = $_REQUEST['card_month'];
$card_year = $_REQUEST['card_year'];
$credit_pay = $_REQUEST['credit_pay'];
$bank_name = $_REQUEST['bank_name'];
$account_type = $_REQUEST['account_type'];
$account_name = $_REQUEST['account_name'];
$account_num = $_REQUEST['account_num'];
$aba_num = $_REQUEST['aba_num'];
$ach_pay = $_REQUEST['ach_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$check_pay = $_REQUEST['check_pay'];
$balance_due = $_REQUEST['balance_due'];
$due_date = $_REQUEST['due_date'];
$first_name = $_REQUEST['first_name'];
$middle_name = $_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$street_address = $_REQUEST['street_address'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip_code = $_REQUEST['zip_code'];
$home_phone = $_REQUEST['home_phone'];
$cell_phone = $_REQUEST['cell_phone'];
$email = $_REQUEST['email'];
$dob = $_REQUEST['dob'];
$lic_num = $_REQUEST['lic_num'];
$update_billing_type = $_REQUEST['update_billing_type'];
$month_billing_type = $_REQUEST['month_billing_type'];
$type_name = $_REQUEST['type_name'];
$type_address = $_REQUEST['type_address'];
$type_phone = $_REQUEST['type_phone'];
$transfer_fee_confirmed = $_REQUEST['transfer_fee_confirmed'];
$transfer_fee = $_REQUEST['transfer_fee'];
$payment_description = $_REQUEST['payment_description'];
$refund_balance = $_REQUEST['refund_balance'];
$key_list_billing = $_REQUEST['key_list_billing'];
$refund_total = $_REQUEST['refund_total'];
$cancelation_balance = $_REQUEST['cancelation_balance'];
$hold_fee = $_REQUEST['hold_fee'];
$hold_grace = $_REQUEST['hold_grace'];
$hold_balance = $_REQUEST['hold_balance'];
$member_hold_fee = $_REQUEST['member_hold_fee'];
$past_due_grace = $_REQUEST['past_due_grace'];
$upgrade_service_bit = $_REQUEST['upgrade_service_bit'];
$billing_field_count = $_REQUEST['billing_field_count'];
$past_due_balance = $_REQUEST['past_due_balance'];
$hold_mem = $_REQUEST['hold_mem'];
$hold = $_REQUEST['hold'];
$cancel = $_REQUEST['cancel'];
$cancel_mem = $_REQUEST['cancel_mem'];
$refund = $_REQUEST['refund'];
$pay_dues = $_REQUEST['pay_dues'];
$contact_bit = $_REQUEST['contact_bit'];
$total_balance_due = $_REQUEST['$total_balance_due'];

$contract_key = $_SESSION['contract_key'];
$user_id = $_SESSION['user_id'];



//get the cc info 
$card_type = trim($card_type);
$card_name = trim($card_name);
$card_number = trim($card_number);
//replace anything that is not a number
$card_number = preg_replace("/[^0-9 .]+/", "" ,$card_number);
$card_cvv = trim($card_cvv);
$card_month = trim($card_month);
$card_year = trim($card_year);
$credit_pay = trim($credit_pay);
//create an experation date array for later division
$card_exp_date_array ="$card_year $card_month";

//get banking info
$bank_name = trim($bank_name);
$account_type = trim($account_type);
$account_name = trim($account_name);
$account_num = trim($account_num);
$aba_num = trim($aba_num);
$ach_pay = trim($ach_pay);

//get cash
$cash_pay = trim($cash_pay);
//get check
$check_pay = trim($check_pay);


include"updateAccountInfo.php";
$updateAccount = new updateAccountInfo;
$updateAccount-> setContractKey($contract_key);

//here we set the default balance due and due date for the history table
$balance_due = '0.00';
$due_date = date("Y-m-d");
$updateAccount-> setBalanceDue($balance_due);
$updateAccount-> setDueDate($due_date);

//first we set all of the payment types
//cc info
$updateAccount-> setCardType($card_type);
$updateAccount-> setCardName($card_name);
$updateAccount-> setCardNumber($card_number);
$updateAccount-> setCardCvv($card_cvv);
$updateAccount-> setCardExpDate($card_exp_date_array);

//banking info
$updateAccount-> setBankName($bank_name);
$updateAccount-> setAccountType($account_type);
$updateAccount-> setAccountName($account_name);
$updateAccount-> setAccountNumber($account_num);
$updateAccount-> setAbaNumber($aba_num);

//set the initial payment type
$updateAccount-> setCreditPayment($credit_pay);
$updateAccount-> setAchPayment($ach_pay);
$updateAccount-> setCashPayment($cash_pay);
$updateAccount-> setCheckPayment($check_pay);



if($check_pay != "") {
   $updateAccount-> setCheckNumber($check_number);
  }
  
//set the contract info fields
$updateAccount-> setFirstName($first_name);
$updateAccount-> setMiddleName($middle_name);
$updateAccount-> setLastName($last_name);
$updateAccount-> setStreetAddress($street_address);
$updateAccount-> setCityName($city);
$updateAccount-> setStateValue($state);
$updateAccount-> setZipCode($zip_code);
$updateAccount-> setPrimaryPhone($home_phone);
$updateAccount-> setCellPhone($cell_phone);
$updateAccount-> setEmailAddress($email);
$updateAccount-> setDob($dob);
$updateAccount-> setLicenseNumber($lic_num);

//-----------------------------------------------------------------------------------------
//update contact info if set
if(isset($_POST['contact_bit'])) {

    $updateAccount-> updateContractInfo();
  }
//-----------------------------------------------------------------------------------------  
//set monthly billing and update cs if needed update the credit or banking info
if(isset($_POST['update_billing_type'])) {

if($update_billing_type != "") {


           //first check the original monthly billing type  if CR or BA delete the subscription    
            $updateAccount-> loadMonthlyPayment();
            $monthlyBillingTypeOrig = $updateAccount-> getMonthlyBillingType(); 
            
         if($monthlyBillingTypeOrig == 'CR' || $monthlyBillingTypeOrig == 'BA') {
            //$updateAccount-> checkDeleteGuaranteeEnhanceFees();
           }

             $updateAccount-> setMonthlyBillingType($month_billing_type);


          switch($month_billing_type) {          
             case"CR":
             $updateAccount-> updateCreditInfo();
             $updateAccount-> updateMonthlyBillingType();
             break;
             case"BA":
             $updateAccount-> updateBankingInfo();
             $updateAccount-> updateMonthlyBillingType();     
             break;
             case"CA":
             $updateAccount-> updateMonthlyBillingType();
             break;
             case"CH":
             $updateAccount-> updateMonthlyBillingType();
             break;
             }
        
          //now get the new monthly billing type
           $updateAccount-> loadMonthlyPayment();
           $monthlyBillingTypeNew = $updateAccount-> getMonthlyBillingType();
           $monthlyPayment = $updateAccount-> getMonthlyPayment();
           
           if($monthlyBillingTypeNew == 'CR' || $monthlyBillingTypeNew == 'BA') {
             $updateAccount-> setMonthlyDues($monthlyPayment);
             $updateAccount-> updateCsBillingType();
             }
       }         
  }
//--------------------------------------------------------------------------------
//checks to see if there is group info to update then updates
if(isset($_POST['type_name']) && isset($_POST['type_address']) && isset($_POST['type_phone']))  {

  $updateAccount-> setGroupName($type_name);
  $updateAccount-> setGroupAddress($type_address);
  $updateAccount-> setGroupPhone($type_phone);
  $updateAccount-> updateGroupInfo();

}
//--------------------------------------------------------------------------------

//-------------------------------------------------------------------------------
//if the account is transferable and the holder has been changed then we charge the client
if($transfer_fee_confirmed == 1) {
   $payment_description = 'Transfer Fee';
   $updateAccount-> setCancelCost($transfer_fee);
   $updateAccount-> setTodaysPayment($transfer_fee);
   $updateAccount->setPaymentDescription($payment_description);
   $updateAccount-> insertPaymentHistory(); 
  }
//-------------------------------------------------------------------------------
//this checkes if refunds are available
if(isset($_POST['refund'])) {

if($refund_balance != '0.00') {
   
   //loop through the check boxes and 
     foreach($_POST['refund'] as $refund_value) {
                 $refundValueArray = explode("|", $refund_value);
                 $service_cost = $refundValueArray[0];
                 $contract_key = $refundValueArray[1];
                 $service_key = $refundValueArray[2];
                 $refund_type = $refundValueArray[3];
                 $contract_date = $refundValueArray[4];
                 $service_id = $refundValueArray[5];
 
                                  
                 $updateAccount-> setServiceCost($service_cost);
                 $updateAccount-> setContractKey($contract_key);
                 $updateAccount-> setServiceKey($service_key);                 
                 $updateAccount-> setRefundType($refund_type);
                 $updateAccount-> setContractDate($contract_date);
                 $updateAccount-> setServiceId($service_id);
                 $updateAccount-> parseRefunds();
                 $updateAccount-> updateServiceStatus();
                 
                 $payment_description = 'Service Refund'; 
                 $updateAccount-> setPaymentDescription($payment_description);                 
                 $updateAccount-> setTodaysPayment($service_cost);  
                 $updateAccount-> insertPaymentHistory(); 
                 
                 //gets the combined service cost for the canceleation history
                 $refund_total = $service_cost + $refund_total ;
                }
                
  //gets the listing of total members due for subtraction
   $member_count = $updateAccount-> loadMemberCount(); 
   //load into cancel hold history
   $ch_type = 'CO';
   $updateAccount-> setRefundTotal($refund_total);
   $updateAccount-> setChType($ch_type);
   $updateAccount-> loadCancelHoldHistory();
}                      
  }
//-------------------------------------------------------------------------------
//this checks cancel for members
if(isset($_POST['cancel_mem'])) {

   //loop through the check boxes and 
     foreach($_POST['cancel_mem'] as $cancel_value) {
                 $refundMemberArray = explode("|", $cancel_value);
                 $member_id = $refundMemberArray[0];
                 $general_id = $refundMemberArray[1];
                 $contract_key = $refundMemberArray[2];
                 $member_refund = $refundMemberArray[3];
                                                  
                 $updateAccount-> setMemberId($member_id);
                 $updateAccount-> setGeneralId($general_id);
                 $updateAccount-> setContractKey($contract_key);
                 $updateAccount-> setMemberRefund($member_refund);
                 $updateAccount-> loadMemberInfo();
                }
                
     if($member_refund_bit == 1) {
        $payment_description = 'Member Refund';
        }else{
        $payment_description = 'Member Cancel Fee';
        }
        
        $updateAccount->setPaymentDescription($payment_description);
        $updateAccount-> setKeyListBilling($key_list_billing);           
        $updateAccount-> parseMemberRefunds();
        
          //take care of subscriptions       
            $updateAccount-> loadMonthlyPayment();
            $monthlyBillingType = $updateAccount-> getMonthlyBillingType();           
            $monthlyPayment = $updateAccount-> getMonthlyPayment();
            
            if($monthlyBillingType == 'CR' || $monthlyBillingType == 'BA') {            
               $updateAccount-> checkDeleteMonthly();                        
               $updateAccount-> setMonthlyDues($monthlyPayment);
               $updateAccount-> loadCycleDate();
               //$updateAccount-> createCsSubscription();                                                      
              }        
     
    //load into cancel hold history.  Note: the cost fees are generated are generated with in the class unlike the other recored types
        $ch_type = 'CM';
        $updateAccount-> setChType($ch_type);
        $updateAccount-> loadCancelHoldHistory();      
     
}
//------------------------------------------------------------------------------------
if(isset($_POST['cancel'])) {

 foreach($_POST['cancel'] as $cancel_service) {
                 $cancelServiceArray = explode("|", $cancel_service);
                 $cancelFieldSalt = $cancelServiceArray[0];
                 $contract_key = $cancelServiceArray[1];
                 $service_key = $cancelServiceArray[2];
                 $service_id = $cancelServiceArray[3];
                 $monthly_dues = $cancelServiceArray[4];
                 
                   if($monthly_dues == "") {
                      $monthly_dues = 0;
                     }
                 
                 $cancel_field = "cancel_cost$cancelFieldSalt";
                 $cancel_cost = $_POST["$cancel_field"];
                 
                   if($cancel_cost == "")  {
                      $cancel_cost = 0;
                     }
                     
                 $payment_description = 'Service Cancel Fee'; 
                 $updateAccount-> setPaymentDescription($payment_description);
                 $updateAccount-> setContractKey($contract_key);
                 $updateAccount-> setServiceKey($service_key); 
                 $updateAccount-> setServiceId($service_id);
                 $updateAccount-> setCancelCost($cancel_cost);
                 $updateAccount-> setMonthlyDues($monthly_dues);
                 $updateAccount-> cancelServices();
                                  
                }
           
           //take care of subscriptions       
            $updateAccount-> loadMonthlyPayment();
            $monthlyBillingType = $updateAccount-> getMonthlyBillingType();           
            $monthlyPayment = $updateAccount-> getMonthlyPayment();
            $membershipMatch = $updateAccount-> getMembershipMatch();
            
            if($monthlyBillingType == 'CR' || $monthlyBillingType == 'BA') {
            
                 if($membershipMatch == 1) {
                   //$updateAccount-> checkDeleteGuaranteeEnhanceFees();
                   }else{
                   $updateAccount-> checkDeleteMonthly();
                   }
               
                      if($monthlyPayment != 0 || $monthlyPayment != '0.00')  {
                         $updateAccount-> setMonthlyDues($monthlyPayment);
                         $updateAccount-> loadCycleDate();
                         //$updateAccount-> createCsSubscription();                       
                        }          
              }
            
                
                
    //load into cancel hold history
   $ch_type = 'CA';
   $updateAccount-> setCancelTotal($cancelation_balance);
   $updateAccount-> setChType($ch_type);
   $updateAccount-> loadCancelHoldHistory();         

}
//-----------------------------------------------------------------------------------
if(isset($_POST['hold'])) {

$updateAccount-> setHoldFee($hold_fee);
$updateAccount-> setHoldGrace($hold_grace);

   foreach($_POST['hold'] as $hold_service) {
                $holdServiceArray = explode("|", $hold_service);
                $contract_key = $holdServiceArray[1];
                $service_key = $holdServiceArray[2];
                $service_status = 'HO';
                $monthly_dues = $holdServiceArray[4];
                $service_id = $holdServiceArray[5];
                
                 if($monthly_dues == "") {
                      $monthly_dues = 0;
                     }
                     
                 $updateAccount-> setContractKey($contract_key);
                 $updateAccount-> setServiceKey($service_key); 
                 $updateAccount-> setServiceStatus($service_status);
                 $updateAccount-> setMonthlyDues($monthly_dues);
                 $updateAccount-> setServiceId($service_id);
                 $updateAccount-> setServiceCost($monthly_dues);
                 $updateAccount-> holdServices();
               }
   
              //if this is set to 1 then we know to cancel and create a subscription
              $csHoldBit = $updateAccount-> getCsHoldBit();
              
              
              if($csHoldBit == 1) {
                   $monthlyPayment = $updateAccount-> getMonthlyPayment();
                   $updateAccount-> setMonthlyDues($monthlyPayment);                                      
                   $updateAccount-> checkDeleteMonthly();
                   $nextBillingDate = $updateAccount-> loadCycleDate();
                   //$updateAccount-> createCsSubscription();  
                   $updateAccount-> updateMonthlySettled();
                   
                 }elseif($csHoldBit == 2) {
                   $nextBillingDate = $updateAccount-> loadCycleDate();
                   $updateAccount-> updateMonthlySettled();
                 }
      
            $payment_description = 'Service Hold Fee'; 
            $updateAccount-> setPaymentDescription($payment_description);   
            $updateAccount-> setTodaysPayment($hold_balance);
            $updateAccount-> setCancelCost($hold_balance);
            $updateAccount-> insertPaymentHistory(); 
            
    //load into cancel hold history
   $ch_type = 'SH';
   $updateAccount-> setHoldTotal($hold_balance);
   $updateAccount-> setChType($ch_type);
   $updateAccount-> loadCancelHoldHistory();                 
            
                        
}
//-----------------------------------------------------------------------------------
if(isset($_POST['hold_mem'])) {


      foreach($_POST['hold_mem'] as $hold_member) {
                   $holdMemberArray = explode("|", $hold_member);
                   $member_id = $holdMemberArray[0];
                   $general_id = $holdMemberArray[1];
                   $contract_key = $holdMemberArray[2];
                   
                   $updateAccount-> setMemberId($member_id);
                   $updateAccount-> setGeneralId($general_id);
                   $updateAccount-> setContractKey($contract_key); 
                   $updateAccount-> holdMember();
                   
                   $payment_description = 'Member Hold Fee'; 
                   $updateAccount-> setPaymentDescription($payment_description); 
                   $updateAccount-> setTodaysPayment($member_hold_fee);
                   $updateAccount-> insertPaymentHistory();
                   
                   
                   }
                   
   //load into cancel hold history
   $ch_type = 'MH';
   $updateAccount-> setHoldTotal($hold_balance);
   $updateAccount-> setChType($ch_type);
   $updateAccount-> loadCancelHoldHistory();                 
                                
}
//-----------------------------------------------------------------------------------
//takes care of rejected payments

//-----------------------------------------------------------------------------------
//check to see if there is an addition of service credits then parse
if($upgrade_service_bit == 1) {
$billing_field_count;

for($i = 1; $i <= $billing_field_count; $i++) {

       $serv_keys = "serv_keys$i";
       $servKeysValue = $_POST["$serv_keys"];
       $servKeysArray = explode("|", $servKeysValue);
       $fieldSalt = $servKeysArray[0];
       $servNumField = "serv_num$fieldSalt";
       $servNumValue = $_POST["$servNumField"]; 
       
         if($servNumValue != "") {
            $servCreditDrop = "serv_credit$fieldSalt";
            $servCreditValue = $_POST["$servCreditDrop"];
            $contractKeyValue = $servKeysArray[1];
            $serviceKeyValue = $servKeysArray[2];
            $serviceIdValue = $servKeysArray[3];
            
            $updateAccount-> setBool($upgrade_service_bit);
            $updateAccount-> setContractKey($contractKeyValue);
            $updateAccount-> setServiceId($serviceIdValue);
            $updateAccount-> setServiceKey($serviceKeyValue); 
            $updateAccount-> setServiceCreditNumber($servNumValue);
            $updateAccount-> setServiceCreditTerm($servCreditValue);
            $updateAccount-> parseCreditServiceTerm();         
           }
       
     }
 }
 
 if($upgrade_service_bit == 2) {
$billing_field_count;

for($i = 1; $i <= $billing_field_count; $i++) {

       $serv_keys = "serv_keys$i";
       $servKeysValue = $_POST["$serv_keys"];
       $servKeysArray = explode("|", $servKeysValue);
       $fieldSalt = $servKeysArray[0];
       $servNumField = "serv_num$fieldSalt";
       $servNumValue = $_POST["$servNumField"]; 
       
         if($servNumValue != "") {
            $servCreditDrop = "serv_credit$fieldSalt";
            $servCreditValue = $_POST["$servCreditDrop"];
            $contractKeyValue = $servKeysArray[1];
            $serviceKeyValue = $servKeysArray[2];
            $serviceIdValue = $servKeysArray[3];
            
            $updateAccount-> setBool($upgrade_service_bit);
            $updateAccount-> setContractKey($contractKeyValue);
            $updateAccount-> setServiceId($serviceIdValue);
            $updateAccount-> setServiceKey($serviceKeyValue); 
            $updateAccount-> setServiceCreditNumber($servNumValue);
            $updateAccount-> setServiceCreditTerm($servCreditValue);
            $updateAccount-> parseCreditServiceTerm();         
           }
       
     }
 }
//-------------------------------------------------------------------------------------
//this checks to see if no other functions have been selected with payment options that monthly billing payments are inacted
if($hold_mem == "" && $hold == "" && $cancel == "" && $cancel_mem == "" && $refund == "" && $pay_dues == "" && $contact_bit == "" && $update_billing_type == "" && $upgrade_service_bit == "") {
  

 if($refund_balance == "" || $refund_balance == '0.00') {


//this if statement checks to see if a transfer of the account is present and there is not a past due balance
if($transfer_fee_confirmed == 0 && $past_due_balance == "0.00") {


      //make sure there is a monthly billing type selected.  If so determine if a payment field is checked then parse the monthly payment
    if($month_billing_type != "") {          

        $check_pay = trim($check_pay);
        $cash_pay = trim($cash_pay);
        $credit_pay = trim($credit_pay);
        $ach_pay = trim($ach_pay);
        $trans_key = rand(100, 10000);
                   
            if($check_pay != "") {
               $transType = 'CH';
               $payment_description = 'Monthly Dues Check'; 
               $updateAccount-> setPaymentDescription($payment_description);
               $updateAccount-> setTodaysPayment($check_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
               }else{
               $check_pay = 0;
               }
           
            if($cash_pay != "") {
               $transType = 'CA';
               $payment_description = 'Monthly Dues Cash'; 
               $updateAccount-> setPaymentDescription($payment_description);
               $updateAccount-> setTodaysPayment($cash_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
               }else{
               $cash_pay = 0;
               }
           
            if($credit_pay != "") { 
               $transType = 'CR';
               $payment_description = 'Monthly Dues CC'; 
               $updateAccount-> setPaymentDescription($payment_description); 
               $updateAccount-> setTodaysPayment($credit_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
               }else{
               $credit_pay = 0;
               }
           
            if($ach_pay != "") {
               $transType = 'BA';
               $payment_description = 'Monthly Dues ACH'; 
               $updateAccount-> setPaymentDescription($payment_description); 
               $updateAccount-> setTodaysPayment($ach_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
               }else{
               $ach_pay = 0;
               }
          
          //insert into the monthly settled table. Add up the different payment types
            $todaysPayment = $check_pay + $cash_pay + $credit_pay + $ach_pay;
            $updateAccount-> setTodaysPayment($todaysPayment);          
            $updateAccount-> saveMonthlySettled();
            $updateAccount-> deletePastDueAttempts();
            
          //alert cs to skip this payment  
          if($month_billing_type == "CR" || $month_billing_type == "BA") {  
             $updateAccount-> setMonthlyBillingType($month_billing_type);
             $updateAccount-> setMonthlyDues($todaysPayment); 
             $updateAccount-> skipCsPayment();
             }
             include "../dbConnect.php";
             
             $processed = 'Y';
             $imported = 'Y';
             $outstandingBalance = 'N';
             $sql = "UPDATE batch_recurring_records SET processed = ?, imported = ?, outstanding_balance = ? WHERE contract_key = '$contract_key' AND processed = 'N' AND payment_type = 'MS'";
             $stmt = $dbMain->prepare($sql);
             $stmt->bind_param('sss', $processed, $imported, $outstandingBalance);
             if(!$stmt->execute())  {
                 	  printf("Error:updateEHFEE %s.\n", $stmt->error);
                     }	          
             $stmt->close(); 
             
       }//end if monthly billing type is not null
    }//end if balance due is not 0 or transfer bit not set to 0
 }//end if refund balance is set to  0 or null
}
 //-----------------------------------------------------------------------------------------------------------------------------------------
//takes care of past due balance   
$pastDuesPaidBool = 0;
if($transfer_fee_confirmed == 0 && $past_due_balance != "0.00" && $past_due_balance != "") { 
    $pastDuesPaidBool = 1;
      //make sure there is a monthly billing type selected.  If so determine if a payment field is checked then parse the past due payment

    if($month_billing_type != "") {          
        
          
        $check_pay = trim($check_pay);
        $cash_pay = trim($cash_pay);
        $credit_pay = trim($credit_pay);
        $ach_pay = trim($ach_pay);
        $trans_key = rand(100, 10000);           
        
        //check to see if there are other payments other than monthly past
        if($past_due_balance ==  $total_balance_due) {
        
            if($check_pay != "") {
               $transType = 'CH';
               $payment_description = 'Past Due Check'; 
               $updateAccount-> setPaymentDescription($payment_description);
               $updateAccount-> setTodaysPayment($check_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
              }
           
            if($cash_pay != "") {
               $transType = 'CA';
               $payment_description = 'Past Due Cash'; 
               $updateAccount-> setPaymentDescription($payment_description);
               $updateAccount-> setTodaysPayment($cash_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
              }           
           
            if($credit_pay != "") {  
               $transType = 'CR';
               $payment_description = 'Past Due CC'; 
               $updateAccount-> setPaymentDescription($payment_description); 
               $updateAccount-> setTodaysPayment($credit_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
              }       
           
            if($ach_pay != "") {
               $transType = 'BA';
               $payment_description = 'Past Due ACH'; 
               $updateAccount-> setPaymentDescription($payment_description); 
               $updateAccount-> setTodaysPayment($ach_pay);
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory();
              }         
              
       }else{
        $todaysPayment = $check_pay + $cash_pay + $credit_pay + $ach_pay;
               $transType = 'CO';
               $payment_description = 'Past Due Settled'; 
               $updateAccount-> setPaymentDescription($payment_description); 
               $updateAccount-> setTodaysPayment($todaysPayment);       
               $updateAccount-> setTransKey($trans_key);
               $updateAccount-> setTransType($transType);
               $updateAccount-> insertPaymentHistory(); 
               //echo "$$$$$$$$$$$$$$$$$  $todaysPayment   $$$$$$$$$$$$$$$$$$$$";              
               
       }
       
       include "../dbConnect.php";
             
             $processed = 'Y';
             $imported = 'Y';
             $outstandingBalance = 'N';
             $sql = "UPDATE batch_recurring_records SET processed = ?, imported = ?, outstanding_balance = ? WHERE contract_key = '$contract_key'";
             $stmt = $dbMain->prepare($sql);
             $stmt->bind_param('sss', $processed, $imported, $outstandingBalance);
             if(!$stmt->execute())  {
                 	  printf("Error:updateEHFEE %s.\n", $stmt->error);
                     }	          
             $stmt->close(); 
             
               $sql = "UPDATE rejected_payments SET reject_bit= ? WHERE contract_key = '$contract_key'";
               $stmt = $dbMain->prepare($sql);
               $stmt->bind_param('i',  $rejectBit); 
               $rejectBit = 1;
            
               if(!$stmt->execute())  {
                  printf("Error: %s.\n", $stmt->error);
                 }		
               $stmt->close();  
   //echo "test";
          //insert into the monthly settled table
         $updateAccount-> saveMonthlySettled();
         $updateAccount-> deletePastDueAttempts();
       }




}
//======================================================================================
if(isset($_POST['pay_dues']) AND $pastDuesPaidBool != 1) {

     
     $updateAccount->setPastDueBalance($past_due_balance);
     //echo "<br>FDSFSDFDFSD $past_due_balance sdlksdjsdfkksdfksdjkl<br>";
     foreach($_POST['pay_dues'] as $pay_dues) {
                    //var_dump($pay_dues);
                   $payDuesArray = explode("|", $pay_dues);
                   $rejected_payment = $payDuesArray[0];
                   $contract_key = $payDuesArray[1];
                   $trans_key = $payDuesArray[2];
                   $salt = $payDuesArray[3];
                   $payment_description = $payDuesArray[4];
                   $rejection_fee_type = $payDuesArray[5];
                   $rejected_check_number = $payDuesArray[6];
                   $rejected_date = $payDuesArray[7];
                   
                   $rejection_field = "rejection_total$salt";
                   $rejection_total = $_POST["$rejection_field"];
                                      
                   $late_check = "late$salt";
                   $late_fee = $_POST["$late_check"];                   
                   
                   $reject_check = "reject$salt";
                   $rejection_fee = $_POST["$reject_check"];
                   
                   $updateAccount-> setRejectedDate($rejected_date);
                   $updateAccount-> setRejectedPayment($rejected_payment);
                   $updateAccount-> setContractKey($contract_key);
                   $updateAccount-> setTransKey($trans_key);
                   $updateAccount-> setLateFee($late_fee);
                   $updateAccount-> setRejectionFee($rejection_fee);
                   $updateAccount-> setRejectionTotal($rejection_total);
                   $updateAccount-> setPastDueGrace($past_due_grace);
                   $updateAccount-> setRejectionFeeType($rejection_fee_type);
                   $updateAccount-> setPaymentDescription($payment_description);
                   $updateAccount-> setRejectedCheckNumber($rejected_check_number);
                   
                  $updateAccount-> parseRejectedPayments();
                   }

}    
    
//-------------------------------------------------------------------------------------

include "accountInformation.php";

?>