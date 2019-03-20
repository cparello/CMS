<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  invoiceSql{

private $monthlyHeader = null;
private $monthlyTxt = null;

private $pastDueHeader = null;
private $pastDueTxt = null;
private $pastDueAttempts = null;
private $pastDueFrequency = null;

private $rejectedDeclinedHeader = null;
private $rejectedDeclinedTxt = null;
private $rejectedDeclinedAttempts = null;
private $rejectedDeclinedFrequency = null;

private $finalHeader = null;
private $finalTxt = null;



function setMonthlyHeader($monthlyHeader) {
        $this->monthlyHeader = $monthlyHeader;
         }
function setMonthlyTxt($monthlyTxt) {
        $this->monthlyTxt = $monthlyTxt;
         }


function setPastDueHeader($pastDueHeader) {
        $this->pastDueHeader = $pastDueHeader;
         }
function setPastDueTxt($pastDueTxt) {
        $this->pastDueTxt = $pastDueTxt;
         }
function setPastDueAttempts($pastDueAttempts) {
        $this->pastDueAttempts = $pastDueAttempts;
        }
function setPastDueFrequency($pastDueFrequency) {
        $this->pastDueFrequency = $pastDueFrequency;
        }        
        

function setRejectedDelinedHeader($rejectedDeclinedHeader) {
        $this->rejectedDeclinedHeader = $rejectedDeclinedHeader;
         }
function setRejectedDeclinedTxt($rejectedDeclinedTxt) {
        $this->rejectedDeclinedTxt = $rejectedDeclinedTxt;
         }         
function setRejectedDeclinedAttempts($rejectedDeclinedAttempts) {
        $this->rejectedDeclinedAttempts = $rejectedDeclinedAttempts;
         }    
function setRejectedDeclinedFrequency($rejectedDeclinedFrequency) {
        $this->rejectedDeclinedFrequency = $rejectedDeclinedFrequency;
         }             
         
                 
function setFinalHeader($finalHeader) {
        $this->finalHeader = $finalHeader;
         }
function setFinalTxt($finalTxt) {
        $this->finalTxt = $finalTxt;
         }         
		  

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}


//-----------------------------------------------------------------------------------------------------------------
function loadInvoiceOptions() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT monthly_header, monthly_txt, past_header, past_txt, past_attempts, past_freq, rd_header, rd_txt, rd_attempts, rd_freq, final_header, final_txt FROM invoice_options WHERE invoice_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($monthly_header, $monthly_txt, $past_header, $past_txt, $past_attempts, $past_freq, $rd_header, $rd_txt, $rd_attempts, $rd_freq, $final_header, $final_txt); 
   $stmt->fetch();

$this->monthlyHeader = $monthly_header; 
$this->monthlyTxt = $monthly_txt;
$this->pastDueHeader = $past_header;
$this->pastDueTxt = $past_txt;
$this->pastDueAttempts = $past_attempts;
$this->pastDueFrequency = $past_freq;
$this->rejectedDeclinedHeader = $rd_header;
$this->rejectedDeclinedTxt = $rd_txt;
$this->rejectedDeclinedAttempts = $rd_attempts;
$this->rejectedDeclinedFrequency = $rd_freq;
$this->finalHeader = $final_header;
$this->finalTxt = $final_txt;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//--------------------------------------------------------------------------------------------------------------
function upadateInvoiceOptions()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE invoice_options SET monthly_header= ?, monthly_txt= ?, past_header= ?, past_txt= ?, past_attempts= ?, past_freq= ?, rd_header= ?, rd_txt= ?, rd_attempts= ?, rd_freq= ?, final_header= ?, final_txt= ? WHERE invoice_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssiissiiss', $monthlyHeader, $monthlyTxt, $pastHeader, $pastText, $pastAttempts, $pastFreq, $rdHeader, $rdText, $rdAttempts, $rdFreq, $finalHeader,$finalTxt);				

$monthlyHeader = $this->monthlyHeader;
$monthlyTxt = $this->monthlyTxt;
$pastHeader = $this->pastDueHeader;
$pastText = $this->pastDueTxt;
$pastAttempts = $this->pastDueAttempts;
$pastFreq = $this->pastDueFrequency;
$rdHeader = $this->rejectedDeclinedHeader;
$rdText = $this->rejectedDeclinedTxt;
$rdAttempts = $this->rejectedDeclinedAttempts;
$rdFreq = $this->rejectedDeclinedFrequency;
$finalHeader = $this->finalHeader;
$finalTxt = $this->finalTxt;


if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
}
//-----------------------------------------------------------------------------------------------------------------

function getMonthlyHeader() {
            return($this->monthlyHeader);
            }
function getMonthlyTxt() {
            return($this->monthlyTxt);
            }
            
function getPastDueHeader() {
            return($this->pastDueHeader);
            }
function getPastDueTxt() {
            return($this->pastDueTxt);
            }            
function getPastDueAttempts() {
            return($this->pastDueAttempts);
            }
function getPastDueFrequency() {
            return($this->pastDueFrequency);
            }

function getRejectedDeclinedHeader() {
            return($this->rejectedDeclinedHeader);
            }
function getRejectedDeclinedTxt() {
            return($this->rejectedDeclinedTxt);
            }            
function getRejectedDeclinedAttempts() {
            return($this->rejectedDeclinedAttempts);
            }                 
function getRejectedDeclinedFrequency() {
            return($this->rejectedDeclinedFrequency);
            }               
            
function getFinalHeader() {
            return($this->finalHeader);
            }
function getFinalTxt() {
            return($this->finalTxt);
            }            
            
            

}
//===================================================

$ajax_switch = $_REQUEST['ajax_switch'];
$collection_type = $_REQUEST['collection_type'];

if($ajax_switch == "1") {

$past = new invoiceSql();
$past-> loadInvoiceOptions();
$pastAttempts = $past-> getPastDueAttempts();

echo"$pastAttempts";
exit;

}


?>