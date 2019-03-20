<?php
include "firstData.php";

$data['type'] = 'Visa';
$data['number'] = '4111111111111111';
$data['name'] = "joe smith";
$data['exp'] = "0621";
$data['amount'] = "5555.00";
$data['cvv'] = "123";
$data['address'] = "223 mockingbird lane";
$data['zip'] = "91504";
$orderId = "27351";
// Purchase Transaction type
//echo"test";

define( 'API_LOGIN', 'AF7527-01' );
define( 'API_KEY', 'x6q4m77o');

$firstData = new FirstData(API_LOGIN, API_KEY, true);

// Charge
$firstData->setTransactionType(FirstData::TRAN_PURCHASE);
$firstData->setCreditCardType($data['type'])
        ->setCreditCardNumber($data['number'])
        ->setCreditCardName($data['name'])
        ->setCreditCardExpiration($data['exp'])
        ->setAmount($data['amount'])
        ->setReferenceNumber($orderId);

if($data['zip']) {
    $firstData->setCreditCardZipCode($data['zip']);
}

if($data['cvv']) {
    $firstData->setCreditCardVerification($data['cvv']);
}

if($data['address']) {
    $firstData->setCreditCardAddress($data['address']);
}

$firstData->process();

// Check
if($firstData->isError()) {
    echo "<br><br>1111111<br><br>";
     echo $firstData->getResponse();
    echo "<br><br>13111111111<br><br>";
    echo $firstData->getErrorCode();
    echo "<br><br>14111111111<br><br>";
    echo $firstData->getErrorMessage();
   
    echo "failed";// there was an error
} else {
    echo $firstData->isApproved();
    echo "<br><br>1111111<br><br>";
     echo $firstData->getResponse();
    echo "<br><br>2111111<br><br>";
    echo $firstData->getAuthNumber();
   
    echo "<br><br>5111111111<br><br>";
    echo $firstData->getBankResponseMessage();
    echo "<br><br>6111111111<br><br>";
    echo $firstData->getBankResponseCode();
    echo "<br><br>7111111111<br><br>";
    echo $firstData->getExactResponseCode();
    echo "<br><br>8111111111<br><br>";
	echo $firstData->getExactResponseMessage();
    echo "<br><br>9111111111<br><br>";
    echo $firstData->getAvs();
    echo "<br><br>10111111111<br><br>";
    echo $firstData->getBankResponseComments();
    echo "<br><br>11111111111<br><br>";
    echo $firstData->getBankResponseType();
    echo "<br><br>13111111111<br><br>";
    echo "Accepted";// transaction passed
}

?>