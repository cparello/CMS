<?php
session_start();
class parseGatewayFields {

private $cardName = null;
private $achName = null;
private $ccFirstName = null;
private $ccLastName = null;
private $achFirstName = null;
private $achLastName = null;
private $cardType = null;
private $accountType = null;
private $cardYear = null;
private $accountPhone = null;
private $cardExpDate = null;


function setCardName($cardName) {
         $this->cardName = $cardName;
         }
function setAchName($achName) {
         $this->achName = $achName;
         }         
function setCardType($cardType) {
         $this->cardType= $cardType;
         }        
function setAccountType($accountType) {
         $this->accountType= $accountType;
         }   
function setAccountPhone($accountPhone) {
         $this->accountPhone= $accountPhone;
         }             
function setCardYear($cardYear) {
         $this->cardYear= $cardYear;
         }             
function setCardExpDate($cardExpDate) {
         $this->cardExpDate = $cardExpDate;
         }
         
//---------------------------------------------------------------------------------------------------------------------------------
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
                  $this->cardType = '004';
           break;
         }

}
//----------------------------------------------------------------------------------------------------------------------------------
function parseAccountHolderNames() {
 
 if($this->cardName != null) { 
       $card_name_array = preg_split('/[\s]+/', $this->cardName);
       $array_count1 = count($card_name_array);
    
       switch ($array_count1) {
         case 0:
               $this->ccFirstName = "";
               $this->ccLastName = $this->cardName;
         break;
         case 1:
               $this->ccFirstName = "";
               $this->ccLastName = $this->cardName;
         break;
         case 2:
               $this->ccFirstName = $card_name_array[0];
               $this->ccLastName = $card_name_array[1];
         break;
         case 3:
               $this->ccFirstName = $card_name_array[0];
               $this->ccLastName = $card_name_array[2];
         break;
         case 4:
               $this->ccFirstName = $card_name_array[0];
               $this->ccLastName = "$card_name_array[1] $card_name_array[2] $card_name_array[3]";
         break;
         
         default:
               $this->ccFirstName = $card_name_array[0];
               $this->ccLastName = "$card_name_array[1] $card_name_array[2] $card_name_array[3] $card_name_array[4]";
         break;
         }
   }
 
 if($this->achName != null) { 
       $ach_name_array = preg_split('/[\s]+/', $this->achName);
       $array_count2 = count($ach_name_array);
    
       switch ($array_count2) {
         case 0:
               $this->achFirstName = "";
               $this->achLastName = $this->achName;
         break;
         case 1:
               $this->achFirstName = "";
               $this->achLastName = $this->achName;
         break;
         case 2:
               $this->achFirstName = $ach_name_array[0];
               $this->achLastName = $ach_name_array[1];
         break;
         case 3:
               $this->achFirstName = $ach_name_array[0];
               $this->achLastName = $ach_name_array[2];
         break;
         case 4:
               $this->achFirstName = $account_name_array[0];
               $this->achLastName = "$ach_name_array[1] $ach_name_array[2] $ach_name_array[3]";
         break;
          default:
               $this->achFirstName = $card_name_array[0];
               $this->achLastName = "$card_name_array[1] $card_name_array[2] $card_name_array[3] $card_name_array[4]";
         break;
          }
   } 

  
}
//---------------------------------------------------------------------------------------------------------------------------------
function loadAccountType() {

       switch ($this->accountType) {
         case "C":
               $this->accountType = 'C';
         break;
         case "S":
               $this->accountType = 'S';
         break;
         case "B":
               $this->accountType = 'X';
         break;
        
        }

}
//---------------------------------------------------------------------------------------------------------------------------------
function formatCardYear() {


       $this->cardYear = $this->cardYear;

}
//---------------------------------------------------------------------------------------------------------------------------------
function formatCardDate() {

    if($this->cardYear == null) {
      $card_array =  preg_split('/[\s]+/', $this->cardExpDate);
      $this->cardYear = "$card_array[0]"; // "$year_front$card_array[0]"; 
      $this->cardMonth = $card_array[1]; 
      }
}
//---------------------------------------------------------------------------------------------------------------------------------
function formatAccountPhone() {
        $phoneNumber = $this->accountPhone;
        $this->accountPhone = preg_replace("/[^0-9 .]+/", "" ,$phoneNumber);
        $this->accountPhone = preg_replace("/\s+/", "", $this->accountPhone); 

}
//---------------------------------------------------------------------------------------------------------------------------------
function parsePaymentFields() {

      $this->loadAccountType();
      $this->parseAccountHolderNames();
      $this->loadCardType();
      $this->formatCardYear();
      $this->formatAccountPhone();
      //$this->formatCardDate();
      
}
//---------------------------------------------------------------------------------------------------------------------------------
function getCredtCardFirstName() {
      return($this->ccFirstName);
      }
function getCredtCardLastName() {
      return($this->ccLastName);
      }
function getAchFirstName() {
      return($this->achFirstName);
      }
function getAchLastName() {
      return($this->achLastName);
      }      
function getCardType() {
      return($this->cardType);
      }
function getAccountType() {
      return($this->accountType);
      }      
function getAccountPhone() {
      return($this->accountPhone);
      }            
function getCardYear() {
      return($this->cardYear);
      }
function getCardMonth() {
      return($this->cardMonth);
      }             

}
?>