<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
class  accountDropList {

private  $searchSql = null;
private  $accountList = null;
private  $earlyRenewalGrace = null;
private  $earlyRenewalPercent = null;
private  $earlyAvailable = null;
private  $backGroundColor = null;
private  $elementDisabled = null;
private  $contractKey = null;
private  $firstName = null;
private  $middleName = null;
private  $lastName = null;
private  $streetAddress = null;
private  $city = null;
private  $state = null;
private  $zipCode = null;
private  $primaryPhone = null;
private  $renewButton = null;
private  $accountStatus = null;


function setSearchSql($searchSql) {
                 $this->searchSql = $searchSql;
              }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//----------------------------------------------------------------------------------------------------------------------------
function loadEarlyRenewalGrace() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT early_renewal_grace, early_renewal_percent FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($grace_days, $early_renewal_percent);
   $stmt->fetch();


$graceDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m"), date("d")+$grace_days, date("Y")));

$this->earlyRenewalGrace = $graceDate;
$this->earlyRenewalPercent = $early_renewal_percent;
   

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

}
//---------------------------------------------------------------------------------------------------------------------------
function checkEligibleRenewal()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT COUNT(*) AS result_count FROM paid_full_services  WHERE contract_key= '$this->contractKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($result_count);
$stmt->fetch();
 
 if($result_count != 0) { 
   $this->renewButton = "<input  type=\"button\" class=\"button1\" name=\"renewal\" value=\"Renewal\" onClick=\"return setRenewal('$this->contractKey');\" $this->elementDisabled />"; 
   }else{
  $this->renewButton = 'NA';
   }

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//----------------------------------------------------------------------------------------------------------------------------
function checkEarlyRenewalStatus()  {

$todaysDate = date("Y-m-d");
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(end_date) AS result_count FROM paid_full_services  WHERE contract_key= '$this->contractKey' AND end_date > '$todaysDate' AND end_date <= '$this->earlyRenewalGrace' AND service_term != 'C'");
 $stmt->execute();      
 $stmt->store_result();  
 $stmt->bind_result($result_count);
 $stmt->fetch();
 
 if($result_count != 0) { 
     $this->earlyAvailable = "<input  type=\"button\" class=\"button1\" name=\"early_renewal\" value=\"Early Renewal\" onClick=\"return earlyRenewal('$this->contractKey');\" $this->elementDisabled />"; 
   }else{
    $this->earlyAvailable = 'NA';
   }
  

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//=======================================================================
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;
 
    switch ($this->accountStatus) {
         case "CU":
               $this->backGroundColor = "#FFF";
               $this->elementDisabled = "";
        break;
        case "EX":
               $this->backGroundColor = '#390';              
               $this->elementDisabled = 'disabled="disabled"';
        break;
        case "HO":
               $this->backGroundColor = '#900';
               $this->elementDisabled = 'disabled="disabled"';
        break;
        case "CA":
               $this->backGroundColor = '#06C';
               $this->elementDisabled = 'disabled="disabled"';
        break;
      }
  
 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//========================================================================
function makeAccountList()  {

if($this->accountStatus == "HO" || $this->accountStatus == "CU") {  
$upgradeButton = "<input  type=\"button\" class=\"button1\" name=\"upgrade\" value=\"Upgrade\" onClick=\"return setUpgrade('$this->contractKey');\" $this->elementDisabled/>";  
}else{
$upgradeButton = 'NA';
$this->renewButton = 'NA';
$this->earlyAvailable = 'NA';
}


$record ="<tr style=\"background-color:  $this->backGroundColor\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText\">$this->contractKey</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->firstName $this->middleName  $this->lastName</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->streetAddress $this->city $this->state $this->zipCode</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->primaryPhone</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->earlyAvailable</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->renewButton</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$upgradeButton</td>
</tr>";



return "$record";


}
//========================================================================
function loadAccountList() {

$table_header = "<table align=\"left\" border=\"1\" rules=\"none\" frame=\"box\" cellspacing=\"0\" cellpadding=\"1\" width=100% >
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">#</th>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Contract ID</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Address</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Phone</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Early Renewal</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Standard Renewal</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Upgrade</th>
</tr>\n";     


$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT contract_key, first_name, middle_name, last_name, street, city, state, zip, primary_phone FROM contract_info WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone);
   
    while ($stmt->fetch()) {  

            $this->contractKey = $contract_key;
            $this->firstName = $first_name;
            $this->middleName = $middle_name; 
            $this->lastName = $last_name;
            $this->streetAddress = $street;
            $this->city = $city;
            $this->state = $state;
            $this->zipCode = $zip;
            $this->primaryPhone = $primary_phone;
   
            $this->checkAccountStatus();            
            $this->checkEligibleRenewal();
                                                 
               if($this->earlyRenewalPercent == 0) {
                     $this->earlyAvailable = 'NA';
                  }else{
                     $this->checkEarlyRenewalStatus(); 
                  }
                  
                 $this->cellCount++;

                 $accountList .= $this->makeAccountList();


            }
            
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   

$tableTag = '</table>';

return  "$table_header $accountList $tableTag";


        
}
//======================================================================  

function getAccountList() {
        return($this->accountList);
       }
       
function getEarlyRenewalGrace() {       
        return($this->earlyRenewalGrace);
       }
       
       
       
}
?>