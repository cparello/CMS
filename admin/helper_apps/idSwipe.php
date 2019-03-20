<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//echo "test";
//exit;

class idSwipe {

function setIdArray($idArray) {
          $this->idArray = $idArray;
          }


//------------------------------------------------------------------------------
function parseIdArray() {

$idArray = explode("^",$this->idArray);

$cityState = $idArray[0];
$name = $idArray[1];
$streetAddr = $idArray[2];
$buff = $idArray[3];

$nameArray = explode("$",$name);
$first = $nameArray[1];
$mid = $nameArray[2];
$last = $nameArray[0];
//take care of cc number filter out non numeric chars
$state = substr($cityState,1,2);
$city = substr($cityState,3);


$this->idInfoArray = "$first|$mid|$last|$state|$city|$streetAddr";

//%B5572811013035768^SNOWDEN/PETER L          ^16071010000002131000000356?
//;5572811013035768=16071011308003560000?


}
//------------------------------------------------------------------------------
function getIdInfoArray() {
         return($this->idInfoArray);
         }


}
//=============================================
//$id_array = "%CAGLENDALE^CHANDLER$CHRISTOPHER$WILLIE JAMES^1133 JUSTIN AVE APT 227^?";
$ajax_switch=$_REQUEST['ajax_switch'];
$id_array=$_REQUEST['id_array'];

if($ajax_switch == 1) {

  $parseCard = new idSwipe();
  $parseCard-> setIdArray($id_array);
  $parseCard-> parseIdArray();
  $id_info_array = $parseCard-> getIdInfoArray();
  
  echo"$id_info_array";
            exit;

}


?>