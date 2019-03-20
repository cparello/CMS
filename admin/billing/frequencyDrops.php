<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  frequencyDrops{

private  $frequency = null;


function setFrequency($frequency) {
        $this->frequency = $frequency;
         }
 

function loadFrequencyMenu() {

$fiveSelected = "";
$tenSelected = "";
$fifteenSelected = "";
$twentySelected = "";
$twentyFiveSelected = "";
$thirtySelected = "";

if($this->frequency == null) {
          $frequency_group = "
          <option value=\"5\">Five Days</option>\n
          <option value=\"10\" >Ten Days</option>\n
          <option value=\"15\" >Fifteen Days</option>\n
          <option value=\"20\" >Twenty Days</option>\n
          <option value=\"25\">Twenty-Five Days</option>\n
          <option value=\"30\">Thirty Days</option>\n"; 
           }else{           
           switch($this->frequency) {          
             case"5":
             $fiveSelected = "selected";
             break;
             case"10":
             $tenSelected = "selected";
             break;
             case"15":
             $fifteenSelected = "selected";
             break;
             case"20":
             $twentySelected = "selected";
             break;
             case"25":
             $twentyFiveSelected = "selected";
             break; 
             case"30":
             $thirtySelected = "selected";
             break;             
            }
          $frequency_group = "
          <option value=\"5\" $fiveSelected>Five Days</option>\n
          <option value=\"10\" $tenSelected>Ten Days</option>\n
          <option value=\"15\" $fifteenSelected>Fifteen Days</option>\n
          <option value=\"20\" $twentySelected>Twenty Days</option>\n
          <option value=\"25\" $twentyFiveSelected>Twenty-Five Days</option>\n
          <option value=\"30\" $thirtySelected>Thirty Days</option>\n";                 
           }
          
return "$frequency_group";            

}





}

?>