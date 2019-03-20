<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class cardSwipe {

private $cardNumber = null;
private $cardType = null;
private $expDate = null;
private $expMonth = null;
private $expYear = null;
private $cardHolder = null;
private $cardArray = null;
private $cardInfoArray = null;


function setCardArray($cardArray) {
          $this->cardArray = $cardArray;
          }

//=============================================
function loadCardType() {

        if (preg_match("/^5[1-5][0-9]{14}$/", $this->cardNumber)) {
                $this->cardType = "MC";
           }
 
        if (preg_match("/^4[0-9]{12}(?:[0-9]{3})?$/", $this->cardNumber)) {
                $this->cardType = "Visa";
           }
 
        if (preg_match("/^3[47][0-9]{13}$/", $this->cardNumber)) {
                $this->cardType = "Amex";
           }
 
        if (preg_match("/^3(0[0-5]|[68][0-9])[0-9]{11}$/", $this->cardNumber)) {
                $this->cardType = "Diners Club";
           }
 
        if (preg_match("/^6(?:011|5[0-9]{2})[0-9]{12}$/", $this->cardNumber)) {
                $this->cardType = "Disc";
           }
 
        if (preg_match("/^(3[0-9]{4}|2131|1800)[0-9]{11}$/", $this->cardNumber)) {
                $this->cardType = "JCB";
           }


}
//------------------------------------------------------------------------------
function parseCardArray() {

$trackArr = explode(";",$this->cardArray);
$_SESSION['track1'] = "$trackArr[0];";
$_SESSION['track2'] = $trackArr[1];

$cardArray = explode("^",$this->cardArray);

$cardNumber = $cardArray[0];
$cardHolder = $cardArray[1];
$expDate = $cardArray[2];

//take care of cc number filter out non numeric chars
$this->cardNumber = preg_replace('/\D/', '', $cardNumber);

//get the card holder name
$cardHolderArray = explode("/",$cardHolder); 
$lastName = $cardHolderArray[0];
$firstName = $cardHolderArray[1];
$firstName = trim($firstName );
$lastName = trim($lastName);
$this->cardHolder = "$firstName $lastName";

//get the expiration date
$dateResult = substr($expDate, 0, 4);
$this->expMonth = substr($dateResult, -2);
$this->expYear = substr($dateResult, 0, 2);

//load the card type 
$this->loadCardType();

$this->cardInfoArray = "$this->cardNumber|$this->cardHolder|$this->expMonth|$this->expYear|$this->cardType";

//%B5572811013035768^SNOWDEN/PETER L          ^16071010000002131000000356?
//;5572811013035768=16071011308003560000?


}
//------------------------------------------------------------------------------
function getCardInfoArray() {
         return($this->cardInfoArray);
         }


}
//=============================================
//$card_array = "%B5403852015341791^DOE/JOHN^1210201901000101000100061000000?;NNNNNNNNNNNNNNNN=12102019010106111001?";
$ajax_switch=$_REQUEST['ajax_switch'];
$card_array=$_REQUEST['card_array'];

if($ajax_switch == 1) {

  $parseCard = new cardSwipe();
  $parseCard-> setCardArray($card_array);
  $parseCard-> parseCardArray();
  $card_info_array = $parseCard-> getCardInfoArray();
  
  echo"$card_info_array";
            exit;

}


?>