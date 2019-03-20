<?php

class deleteMembers{

private $contractKey = null;
private $deleteList = null;
private $fieldCount = 0;

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}



//=================================================
function deleteRecords()   {

$dbMain = $this->dbconnect();

$recordHeader = "$this->fieldCount  CONTRACT KEY: $this->contractKey   TABLE ROWS DELETED<br>";
 
 
$stmt = $dbMain ->prepare("DELETE FROM sales_info WHERE contract_key = '$this->contractKey' ");
$stmt->execute();    
$rowsAffected = $stmt->affected_rows;
$rowsEffected .= "Sales Info:  $rowsAffected <br>";
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

$stmt2 = $dbMain ->prepare("DELETE FROM account_notes WHERE contract_key = '$this->contractKey' ");
$stmt2->execute();    
$rowsAffected = $stmt2->affected_rows;
$rowsEffected .= "Account Notes:   $rowsAffected <br>";
if(!$stmt2->execute())  {
	printf("Error: %s.\n", $stmt2->error);
   }		 
$stmt2->close(); 

$stmt3 = $dbMain ->prepare("DELETE FROM account_status WHERE contract_key = '$this->contractKey' ");
$stmt3->execute();    
$rowsAffected = $stmt3->affected_rows;
$rowsEffected .= "Account Status:  $rowsAffected <br>";
if(!$stmt3->execute())  {
	printf("Error: %s.\n", $stmt3->error);
   }		 
$stmt3->close(); 

$stmt4 = $dbMain ->prepare("DELETE FROM banking_info WHERE contract_key = '$this->contractKey' ");
$stmt4->execute();    
$rowsAffected = $stmt4->affected_rows;
$rowsEffected .= "Banking Info:  $rowsAffected <br>";
if(!$stmt4->execute())  {
	printf("Error: %s.\n", $stmt4->error);
   }		 
$stmt4->close(); 

$stmt5 = $dbMain ->prepare("DELETE FROM contract_info WHERE contract_key = '$this->contractKey' ");
$stmt5->execute();    
$rowsAffected = $stmt5->affected_rows;
$rowsEffected .= "Contract Info:  $rowsAffected <br>";
if(!$stmt5->execute())  {
	printf("Error: %s.\n", $stmt5->error);
   }		 
$stmt5->close(); 

$stmt6 = $dbMain ->prepare("DELETE FROM contract_keys WHERE contract_key = '$this->contractKey' ");
$stmt6->execute();    
$rowsAffected = $stmt6->affected_rows;
$rowsEffected .= "Contract Keys:  $rowsAffected <br>";
if(!$stmt6->execute())  {
	printf("Error: %s.\n", $stmt6->error);
   }		 
$stmt6->close(); 

$stmt7 = $dbMain ->prepare("DELETE FROM credit_info WHERE contract_key = '$this->contractKey' ");
$stmt7->execute();    
$rowsAffected = $stmt7->affected_rows;
$rowsEffected .= "Credit Info:  $rowsAffected <br>";
if(!$stmt7->execute())  {
	printf("Error: %s.\n", $stmt7->error);
   }		 
$stmt7->close(); 

$stmt8 = $dbMain ->prepare("DELETE FROM initial_payments WHERE contract_key = '$this->contractKey' ");
$stmt8->execute();    
$rowsAffected = $stmt8->affected_rows;
$rowsEffected .= "Initial Payments:  $rowsAffected <br>";
if(!$stmt8->execute())  {
	printf("Error: %s.\n", $stmt8->error);
   }		 
$stmt8->close(); 

$stmt9 = $dbMain ->prepare("DELETE FROM member_groups WHERE contract_key = '$this->contractKey' ");
$stmt9->execute();    
$rowsAffected = $stmt9->affected_rows;
$rowsEffected .= "Member Groups:  $rowsAffected <br>";
if(!$stmt9->execute())  {
	printf("Error: %s.\n", $stmt9->error);
   }		 
$stmt9->close(); 

$stmt10 = $dbMain ->prepare("DELETE FROM member_info WHERE contract_key = '$this->contractKey' ");
$stmt10->execute();    
$rowsAffected = $stmt10->affected_rows;
$rowsEffected .= "Member Info:  $rowsAffected <br>";
if(!$stmt10->execute())  {
	printf("Error: %s.\n", $stmt10->error);
   }		 
$stmt10->close(); 

$stmt11 = $dbMain ->prepare("DELETE FROM monthly_payments WHERE contract_key = '$this->contractKey' ");
$stmt11->execute();    
$rowsAffected = $stmt11->affected_rows;
$rowsEffected .= "Monthly Payments:  $rowsAffected <br>";
if(!$stmt11->execute())  {
	printf("Error: %s.\n", $stmt11->error);
   }		 
$stmt11->close(); 

$stmt12 = $dbMain ->prepare("DELETE FROM monthly_services WHERE contract_key = '$this->contractKey' ");
$stmt12->execute();    
$rowsAffected = $stmt12->affected_rows;
$rowsEffected .= "Monthly Services:  $rowsAffected <br>";
if(!$stmt12->execute())  {
	printf("Error: %s.\n", $stmt12->error);
   }		 
$stmt12->close(); 

$stmt13 = $dbMain ->prepare("DELETE FROM paid_full_services WHERE contract_key = '$this->contractKey' ");
$stmt13->execute();    
$rowsAffected = $stmt13->affected_rows;
$rowsEffected .= "Paid Full Services:  $rowsAffected <br>";
if(!$stmt13->execute())  {
	printf("Error: %s.\n", $stmt13->error);
   }		 
$stmt13->close(); 


$stmt14 = $dbMain ->prepare("DELETE FROM new_monthly_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt14->execute();    
$rowsAffected = $stmt14->affected_rows;
$rowsEffected .= "New Monthly Upgrades:  $rowsAffected <br>";
if(!$stmt14->execute())  {
	printf("Error: %s.\n", $stmt14->error);
   }		 
$stmt14->close(); 


$stmt15 = $dbMain ->prepare("DELETE FROM current_monthly_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt15->execute();    
$rowsAffected = $stmt15->affected_rows;
$rowsEffected .= "Current Monthly Upgrades:  $rowsAffected <br>";
if(!$stmt15->execute())  {
	printf("Error: %s.\n", $stmt15->error);
   }		 
$stmt15->close(); 


$stmt16 = $dbMain ->prepare("DELETE FROM current_pif_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt16->execute();    
$rowsAffected = $stmt16->affected_rows;
$rowsEffected .= "Current Paid Full Upgrades:  $rowsAffected <br>";
if(!$stmt16->execute())  {
	printf("Error: %s.\n", $stmt16->error);
   }		 
$stmt16->close(); 


$stmt17 = $dbMain ->prepare("DELETE FROM early_renewal_rates WHERE contract_key = '$this->contractKey' ");
$stmt17->execute();    
$rowsAffected = $stmt17->affected_rows;
$rowsEffected .= "Early Renewal Rates:  $rowsAffected <br><br>";
if(!$stmt17->execute())  {
	printf("Error: %s.\n", $stmt17->error);
   }		 
$stmt17->close(); 



$this->deleteList = "$recordHeader $rowsEffected";
$rowsEffected = "";
echo"$this->deleteList ";

}

//================================================
function loadDeleteRecords()  {

$dbMain = $this->dbconnect();

//first we start with pif services
$stmt = $dbMain ->prepare("SELECT contract_key FROM contract_keys WHERE contract_key != ''");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($contract_key);
$rowCount = $stmt->num_rows;
           
                    while ($stmt->fetch()) {  
                             $this->contractKey = $contract_key; 
                             $this->fieldCount++;
                             $this->deleteRecords();                           
                             }                                

echo"<br><br>RECORDS DELETED:  $rowCount";




}
//=================================================


}
//-----------------------------------------------------------------------------------------------------------------



$deleteMems = new deleteMembers();
//$deleteMems-> loadDeleteRecords();








?>