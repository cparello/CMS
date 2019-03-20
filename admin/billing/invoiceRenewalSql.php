<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  invoiceRenewalSql{

private $earlyHeader = null;
private $earlyTxt = null;
private $graceHeader = null;
private $graceTxt = null;
private $generalHeader = null;
private $generalTxt = null;


function setEarlyHeader($earlyHeader) {
        $this->earlyHeader = $earlyHeader;
         }
function setEarlyTxt($earlyTxt) {
        $this->earlyTxt = $earlyTxt;
         }

function setGraceHeader($graceHeader) {
        $this->graceHeader = $graceHeader;
         }
function setGraceTxt($graceTxt) {
        $this->graceTxt = $graceTxt;
         }

function setGeneralHeader($generalHeader) {
        $this->generalHeader = $generalHeader;
        }      
function setGeneralTxt($generalTxt) {
        $this->generalTxt = $generalTxt;
        }
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}


//-----------------------------------------------------------------------------------------------------------------
function loadInvoiceRenewalOptions() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT early_header, early_txt, grace_header, grace_txt, general_header, general_txt FROM renewal_invoice_options WHERE invoice_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($early_header, $early_txt, $grace_header, $grace_txt, $general_header, $general_txt); 
   $stmt->fetch();

$this->earlyHeader = $early_header; 
$this->earlyTxt = $early_txt;
$this->graceHeader = $grace_header; 
$this->graceTxt = $grace_txt;
$this->generalHeader = $general_header;
$this->generalTxt = $general_txt;


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//--------------------------------------------------------------------------------------------------------------
function updateInvoiceOptions()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE renewal_invoice_options SET early_header= ?, early_txt= ?, grace_header= ?, grace_txt= ?, general_header= ?, general_txt= ? WHERE invoice_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssss', $earlyHeader, $earlyTxt, $graceHeader, $graceTxt, $generalHeader, $generalTxt);				

$earlyHeader = $this->earlyHeader;
$earlyTxt = $this->earlyTxt;
$graceHeader = $this->graceHeader;
$graceTxt = $this->graceTxt;
$generalHeader = $this->generalHeader;
$generalTxt = $this->generalTxt;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
}
//-----------------------------------------------------------------------------------------------------------------

function getEarlyHeader() {
            return($this->earlyHeader);
            }
function getEarlyTxt() {
            return($this->earlyTxt);
            }
function getGraceHeader() {
            return($this->graceHeader);
            }
function getGraceTxt() {
            return($this->graceTxt);
            }            
function getGeneralHeader() {
            return($this->generalHeader);
            }
function getGeneralTxt() {
            return($this->generalTxt);
            }                 
            

}
?>