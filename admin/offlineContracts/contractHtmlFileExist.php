<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  fileExist{

private $existBit = null;
                

//-------------------------------------------------------------------------------------------------
function loadEftFileExist() {
 
   $appURL = "../offlineContracts/eft_contract.htm";

            
    if(file_exists($appURL)) {
      $this->existBit = 1;
      }else{
      $this->existBit = 2;
      }
      
      
}
//-------------------------------------------------------------------------------------------------
function loadPifFileExist() {

   $appURL = "../offlineContracts/pif_contract.htm";

            
    if(file_exists($appURL)) {
      $this->existBit = 1;
      }else{
      $this->existBit = 2;
      }
      
      
}
//-------------------------------------------------------------------------------------------------
function getExistBit() {
         return($this->existBit);
         }

}
//========================================================
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

   $listing = new fileExist();
   $listing-> loadPifFileExist();
   $exist_bit = $listing-> getExistBit();
   echo"$exist_bit";
   exit;
  }
  
if($ajax_switch == 2) {

   $listing = new fileExist();
   $listing-> loadEftFileExist();
   $exist_bit = $listing-> getExistBit();
   echo"$exist_bit";
   exit;
  }


?>