<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  parseCardType{

private $cardType = null;


function setCardType($cardType) {
        $this->cardType = $cardType;
         }
//==============================================
function loadCardType() {

switch($this->cardType) {
           case "Visa":
                  $this->cardType = '001';
           break;
           case "MC":
                  $this->cardType = '002';           
           break;
           case "Amex":
                  $this->cardType = '003'; 
           break;
           case "Disc":
                  $this->cardType = '003';
           break;
         }

}
//==============================================
function getCardType() {
       return($this->cardType);
     }


}
//----------------------------------------------------------------------------------
$parseType = new parseCardType();
$parseType-> setCardType($card_type);
$parseType-> loadCardType();
$card_type = $parseType-> getCardType();
?>