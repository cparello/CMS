<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  promoSql{

private $erHeader = null;
private $erTxtOne = null;
private $erTxtTwo = null;
private $termType = null;
private $termTypeHtml = null;


function setHeader($header) {
        $this->header = $header;
         }
         
function setEmailTxt($emailTxt) {
        $this->emailTxt = $emailTxt;
         }
         
function setSmsText($smsTxt) {
        $this->smsTxt = $smsTxt;
         }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------
function loadPromoOptions() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT msg_header, email_text, sms_text FROM club_promo WHERE promo_key = '1'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->header, $this->emailTxt, $this->smsTxt); 
$stmt->fetch();
$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------
function updatePromoOptions()  {

$dbMain = $this->dbconnect();
$sql = "UPDATE club_promo SET msg_header= ?, email_text= ?, sms_text= ? WHERE promo_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sss', $this->header, $this->emailTxt, $this->smsTxt);				
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
 } 
 $stmt->close();
 
 //echo "test";
}
//-----------------------------------------------------------------------------------------------------------------

function getHeader() {
            return($this->header);
            }
function getEmailTxt() {
            return($this->emailTxt);
            }
function getSmsTxt() {
            return($this->smsTxt);
            }

            

}
?>