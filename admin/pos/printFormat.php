<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class printFormat {

private $letterSelected = null;
private $receiptSelected = null;
private $receiptFormat = null;
private $confirmation = null;

         
function setReceiptFormat($receiptFormat) {
       $this->receiptFormat = $receiptFormat;
       }


 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=================================================
function loadPrintOptions() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT print_type FROM print_options WHERE print_marker ='1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($printType);         
$stmt->fetch(); 

if($printType == "R") {
   $this->receiptSelected = 'selected';
   $this->letterSelected = "";
  }
if($printType == "L") {  
   $this->receiptSelected = "";
   $this->letterSelected = 'selected';    
  }

$stmt->close();

}
//--------------------------------------------------------------------------------------
function updatePrintType() {

$dbMain = $this->dbconnect();
$sql = "UPDATE print_options SET print_type=? WHERE print_marker='1'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s' , $printType); 
             
             $printType = $this->receiptFormat;
                          
       if(!$stmt->execute())  {    
	      printf("Error: %s.\n", $stmt->error );
          }
          
  $stmt->close();
  
$this->confirmation = "Print Format Successfully Updated";
}
//=================================================
function getReceiptSelected() {
       return($this->receiptSelected);
       }
function getLetterSelected() {
       return($this->letterSelected);
       }
function getConfirmation() {
       return($this->confirmation);
       }

}
//------------------------------------------------------------------------------------



?>