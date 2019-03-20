<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  attemptRadios{

private  $attempts = null;
private  $radioName = null;


function setAttempts($attempts) {
        $this->attempts = $attempts;
         }
function setRadioName($radioName) {
        $this->radioName = $radioName;
         } 

function loadAttemptRadios() {

$oneChecked = "";
$twoChecked = "";
$threeChecked = "";
$fourChecked = "";
$one = 1;
$two = 2;
$three = 3;
$four = 4;
        
           switch($this->attempts) {          
             case"1":
             $oneChecked = "checked";
             break;
             case"2":
             $twoChecked = "checked";
             break;
             case"3":
             $threeChecked = "checked";
             break;
             case"4":
             $fourChecked = "checked";
             break;   
            }
            
$attempt_radios = "
<span class=\"blackTwo\">One</span>
<input type=\"radio\" class=\"buffer\" name=\"$this->radioName\" id=\"$this->radioName$one\" value=\"1\"$oneChecked>
<span class=\"blackTwo\">Two</span>
<input type=\"radio\" class=\"buffer\" name=\"$this->radioName\" id=\"$this->radioName$two\" value=\"2\"$twoChecked>
<span class=\"blackTwo\">Three</span>
<input type=\"radio\" class=\"buffer\" name=\"$this->radioName\" id=\"$this->radioName$three\" value=\"3\"$threeChecked>
<span class=\"blackTwo\">Four</span>
<input type=\"radio\" class=\"buffer\" name=\"$this->radioName\" id=\"$this->radioName$four\" value=\"4\"$fourChecked>";               

          
return "$attempt_radios";            

}





}

?>