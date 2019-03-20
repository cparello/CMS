<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  fileExist{

private $existBit = null;
                

//-------------------------------------------------------------------------------------------------
function loadFileExist() {

   $domain = $_SERVER['HTTP_HOST'];  
   $appURL = "../qwc/cmpqwcfile.qwc";

            
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
   $listing-> loadFileExist();
   $exist_bit = $listing-> getExistBit();
   echo"$exist_bit";
   exit;
  }


?>