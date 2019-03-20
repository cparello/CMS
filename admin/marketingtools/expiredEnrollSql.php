<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  expiredEnrollSql{

private $erHeader = null;
private $erTxtOne = null;
private $erTxtTwo = null;
private $termType = null;
private $termTypeHtml = null;


function setERHeader($erHeader) {
        $this->erHeader = $erHeader;
         }
         
function setERTxtOne($erTxtOne) {
        $this->erTxtOne = $erTxtOne;
         }
         
function setERTxtTwo($erTxtTwo) {
        $this->erTxtTwo = $erTxtTwo;
         }

function setTermType($termType) {
        $this->termType = $termType;
         }
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------
function parseRadioButtons() {


switch ($this->termType) {
    case 'T':
        $termChecked = 'checked';
        $classChecked = "";
        $bothChecked = "";
        break;
    case 'C':
        $termChecked = "";
        $classChecked = 'checked';
        $bothChecked = "";
        break;
     case 'B':
        $termChecked ="";
        $classChecked = "";
        $bothChecked = 'checked';
        break;
     }


$this->termTypeHtml ="
<span class=\"blackTwo\">Term Services</span>
<input type=\"radio\" class=\"buffer\" name=\"st\" id=\"st1\" value=\"T\" $termChecked>
<span class=\"blackTwo\">Class(s)</span>
<input type=\"radio\" class=\"buffer\" name=\"st\" id=\"st2\" value=\"C\" $classChecked>
<span class=\"blackTwo\">Both</span>
<input type=\"radio\" class=\"buffer\" name=\"st\" id=\"st3\" value=\"B\" $bothChecked>";



}
//-----------------------------------------------------------------------------------------------------------------
function loadExpiredEnrollOptions() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT er_header, er_txt_one, er_txt_two, service_target FROM expired_re_enroll WHERE er_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($er_header, $er_txt_one, $er_txt_two, $service_target); 
   $stmt->fetch();

$this->erHeader = $er_header; 
$this->erTxtOne = $er_txt_one; 
$this->erTxtTwo = $er_txt_two;
$this->termType = $service_target;

$this->parseRadioButtons();


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//--------------------------------------------------------------------------------------------------------------
function updateEROptions()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE expired_re_enroll SET er_header= ?, er_txt_one= ?, er_txt_two= ?, service_target= ? WHERE er_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssss', $er_header, $er_txt_one, $er_txt_two, $service_target);				

$er_header = $this->erHeader; 
$er_txt_one = $this->erTxtOne; 
$er_txt_two = $this->erTxtTwo; 
$service_target = $this->termType; 

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
   
   
}
//-----------------------------------------------------------------------------------------------------------------

function getERHeader() {
            return($this->erHeader);
            }
function getERTxtOne() {
            return($this->erTxtOne);
            }
function getERTxtTwo() {
            return($this->erTxtTwo);
            }
function getTermTypeHtml() {
            return($this->termTypeHtml);
            }            

            

}
?>