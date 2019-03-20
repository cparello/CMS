<?php
require"nmi/nmiGatewayClass.php";
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}



require"../dbConnect.php";

//$clubId = $_SESSION['location_id'];
    
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

//============================================
$card_name=$_REQUEST['card_name'];
$card_number=$_REQUEST['card_number'];
$card_month=$_REQUEST['card_month'];
$card_year=$_REQUEST['card_year'];
$ajax_switch=$_REQUEST['ajax_switch'];
//here is where we format the variables 


if($ajax_switch == "1"){
    

      
    $cardBuff = explode(' ',$card_name); 
    $fname = $cardBuff[0];
    $lname =  $cardBuff[1];
      
    $ccnumber = $card_number;//"4111111111111111";
    $ccexp = "$card_month$card_year";//"1010";
    $cvv = "";
    //==================
    $orderId = "CC Member Sales Pre-Auth";
    $merchField1 = "CC Member Sales Pre-Auth";
    $payTypeFlag = "creditcard";//"creditcard"; // '' or 'check'
    $vaultFunction = "";
    $vaultId = "";
    //========================
    $gw = new gwapi;
    $gw->setLogin("$userName", "$password");
    $r = $gw->doPreAuthCC($ccnumber, $ccexp, $cvv, $payTypeFlag, $merchField1, $fname, $lname, $orderId);
    $ccAuthDecision = $gw->responses['responsetext'];
    $authCode = $gw->responses['authcode'];    
    $transactionId = $gw->responses['transactionid'];
    $ccAuthReasonCode = $gw->responses['response_code'];
      
      
    


//$ccAuthReasonCode = 100;
    if($ccAuthReasonCode != 100) {
       
         echo"2|$ccAuthReasonCode|$ccAuthDecision";
         exit;
  
      }else{
          echo"1|$ccAuthReasonCode|$ccAuthDecision";
          exit;       

      }

}

?>