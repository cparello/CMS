<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  contractSql {

private $contractKey = null;
private $contractDate = null;

function setContractKey($contractKey) {
         $this->contractKey = $contractKey;
         }

function setContractDate($contractDate) {
         $this->contractDate = $contractDate;
         }
function setBool($bool) {
         $this->bool = $bool;
         }         
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadContract()  {
$this->contractDate = date('Y-m-d H:i:s', $this->contractDate);
$date2 = date('Y-m-d', strtotime($this->contractDate));
//echo "$date2 $this->contractDate";
//exit;
if ($this->bool == '1'){
  $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT email_html FROM contract_signatures WHERE contract_key ='$this->contractKey'  AND date ='$date2'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($email_html);
    $stmt->fetch();
    $stmt->close(); 
    
    $stmt = $dbMain ->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_name);
    $stmt->fetch();
    $stmt->close(); 
    
    $stmt = $dbMain ->prepare("SELECT email FROM contract_info WHERE contract_key ='$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close(); 
    
    $headers  = "From: $business_name@info.com\r\n";
    $headers .= "Content-type: text/html\r\n";   
    $contractTemplate = trim($contractTemplate);
    mail($email, "$business_name Contract", $email_html, $headers); 
}


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_html FROM contract_info WHERE contract_key ='$this->contractKey' AND signup_date ='$this->contractDate'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contractHtml);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close();


return $contractHtml;




}
//---------------------------------------------------------------------------------------------------------------------
         
         
         
         
         
         
         
         
         
         
         
} 


?>