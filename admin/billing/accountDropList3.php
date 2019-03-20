<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  accountDropList {

private  $searchSql = null;
private  $groupSql = null;
private  $groupName = null;
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
private  $emailAddress = null;
private  $renewButton = null;
private  $accountStatus = null;
private  $monthlyServices = null;
private  $pifServices = null;
private  $serviceTerm = null;
private  $cellCount = 1;
private  $tableTag = null;
private  $tableEndTag = null;
private  $fontClass = null;
private  $prePayButton = null;

function setSearchSql($searchSql) {
                 $this->searchSql = $searchSql;
              }

function setGroupSql($groupSql) {
                 $this->groupSql = $groupSql;
              }
function setCCSql($ccSql) {
                 $this->ccSql = $ccSql;
              }    
function setBankSql($bankSql) {
                 $this->bankSql = $bankSql;
              }       
function setMemberSql($memberSql) {
                 $this->memberSql = $memberSql;
              }                 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------------------------------
function findGroupName()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT group_name FROM member_groups WHERE  contract_key= '$this->contractKey'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($group_name);
$stmt->fetch();

$this->groupName = $group_name;

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       

}
//----------------------------------------------------------------------------------------------------------------------------
function checkPastGrace() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num ='1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();
   
   $service_end_date_array = explode('-', $this->serviceEndDate);
   $year = $service_end_date_array[0];
   $month = $service_end_date_array[1];
   $day = $service_end_date_array[2];
   
   $end_grace_date = date("Y-m-d"  ,mktime(0, 0, 0, $month, $day+$past_day, $year));
   
 //  echo"$end_grace_date";
   $todays_date = date("Y-m-d");
   $service_end_date = $this->serviceEndDate;
   
   $end_grace_date  = strtotime($end_grace_date);
   $todays_date  = strtotime($todays_date);
   $service_end_date  = strtotime($service_end_date);
   
        //check to see if the service has expired
        if($service_end_date < $todays_date) {
           $this->accountStatus  = 'EX';
           $this->backGroundColor = '#CCC';
           $this->fontClass = 'exText';
         }      
      
           
 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       
      
}
//----------------------------------------------------------------------------------------------------------------------------
function checkEligibleRenewal()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();
 
 //echo"$rowCount $this->serviceKey <br>";
 
 
 if($rowCount != 0) { 
        $this->serviceEndDate = $end_date;
        $this->checkPastGrace();          
    }

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}

//=======================================================================
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;
 
    switch ($this->accountStatus) {
         case "CU":
               $this->backGroundColor = "#FFF";
               $this->fontClass = 'keyText';
        break;
        case "EX":
               $this->backGroundColor = '#CCC';
               $this->fontClass = 'exText';
        break;
        case "HO":
               $this->backGroundColor = '#900';
               $this->fontClass = 'keyText';
        break;
        case "CA":
               $this->backGroundColor = '#06C';
               $this->fontClass = 'keyText';
        break;
        case "CO":
               $this->backGroundColor = '#7FFF00';
               $this->fontClass = 'keyText';
        break;
      }
  
 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//========================================================================
function parseServiceList()  {


 switch($this->serviceTerm) {
        case "C":
        $term = 'Class(s)';
        break;
        case "D":
        $term = 'Day(s)';
        break;
        case "W":
        $term = 'Week(s)';
        break;
        case "M":
        $term = 'Month(s)';
        
        break;
        case "Y":
        $term = 'Year(s)';
        break;  
      }


$record_list = "<tr style=\"background-color:  $this->backGroundColor \">
<td align=\"left\" valign =\"middle\" class=\"$this->fontClass\">&nbsp;</td>
<td align=\"left\"  colspan=\"2\" valign =\"middle\" class=\"$this->fontClass\">$this->serviceName</td>
<td align=\"left\"  colspan=\"2\" valign =\"middle\" class=\"$this->fontClass\">$this->serviceDuration  $term</td>
<td align=\"left\"   valign =\"middle\" class=\"$this->fontClass\">$this->prePayButton</td>
</tr>";



return $record_list;

}
//========================================================================
function makeClientInfo() {

if($this->groupName == null)  {
   $this->groupName = 'NA';
   }



$this->clientInfo = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">#</th>
<th align=\"left\" bgcolor=\"#4A4B4C\"class=\"keyHeader\">Contract ID</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Client Address</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Group Name</th>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">Account Options</th>
</tr>
<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\"class=\"keyText\">$this->contractKey</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->firstName $this->middleName  $this->lastName</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$this->streetAddress $this->city $this->state $this->zipCode</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->groupName </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\"><input  type=\"button\" class=\"button1\" name=\"view\" value=\"View Record\" onClick=\"return setContractRecord('$this->contractKey');\"/></td>
</tr>";
}


//========================================================================
function loadMonthlyServices() {
unset($_SESSION['canceled_services']);
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  number_months, user_id FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $number_months, $user_id);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $number_months;
                               $this->serviceTerm = 'M';
                               $this->serviceName = $service_name;
                               $this->checkAccountStatus();  
                               
                               if($this->accountStatus == "CU") {
                                  $this->prePayButton = "<input  type=\"button\" class=\"button1\" name=\"view\" value=\"Pre Payment\" onClick=\"return setPrePayRecord('$this->contractKey');\"/>";
                                  }else{
                                  $this->prePayButton = "";
                                  $_SESSION['canceled_services'] .= "$this->serviceKey,$this->serviceName,$user_id@";
                                  }
                                                              
                               $monthlyServices .= $this->parseServiceList();                               
                             }
              }
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      


$this->monthlyServices = $monthlyServices;

//return $monthlyServices;
                      
}
//========================================================================
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  service_quantity, service_term FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $service_quantity, $service_term);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;
                               $this->serviceName = $service_name;  
                               $this->prePayButton = "";
                               $this->checkAccountStatus();
                                     //make sure the account has not already been canceld or is on hold                         
                                  if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                               
                                         if($this->serviceTerm != 'C') {
                                             $this->checkEligibleRenewal();
                                           }
                                                
                                     }       
                                         
                               $pif_services .= $this->parseServiceList();                               
                             }
                             
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$this->pifServices = $pif_services;

}
//========================================================================
function makeAccountList() {

$service_header = "
<tr>
<th align=\"left\"  bgcolor=\"#4A4B4C\" class=\"keyHeader\">&nbsp;</th>
<th align=\"left\" colspan=\"2\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Name</th>
<th align=\"left\" colspan=\"3\" bgcolor=\"#4A4B4C\" class=\"keyHeader\">Service Duration</th>
</tr>";  


$service_footer="<tr class=\"endFoot\"><td  class=\"endFoot\" colspan=\"6\">&nbsp;</td></tr>"; 

$account_list = "$this->clientInfo $service_header $this->monthlyServices $this->pifServices $service_footer";


return "$account_list";


}
//========================================================================
function loadAccountList() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, first_name, middle_name, last_name, street, city, state, zip, primary_phone, email FROM contract_info WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $email);
   
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
            $this->emailAddress = $email;
            
            
            //creates the table with all of the client details like name etc 
            $this->findGroupName();
            $this->makeClientInfo();             
            //get the services 
            $this->loadMonthlyServices();
            $this->loadPifServices();
                                                                 
            $this->cellCount++;

                 $accountList .= $this->makeAccountList();


            }
            
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   

$this->tableEndTag = '</table>';
$this->tableTag ="<table align=\"left\"   cellspacing=\"0\" cellpadding=\"1\" width=100% >";

if($this->groupSql == null)  {
   return  "$this->tableTag $accountList $this->tableEndTag";
   }else{
   return "$accountList";
   }

        
}
//======================================================================  
function loadGroupNames()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM member_groups WHERE  $this->groupSql");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_key);

 while ($stmt->fetch()) {  
          
          $this->searchSql = "contract_key = '$contract_key'";       
          $groupList .= $this->loadAccountList();
        }


  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   


return  "$this->tableTag $groupList $this->tableEndTag";


}
//======================================================================  
function loadCCNames()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM credit_info WHERE  $this->ccSql");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_key);

 while ($stmt->fetch()) {  
          
          $this->searchSql = "contract_key = '$contract_key'";       
          $ccList .= $this->loadAccountList();
        }


  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   


return  "$this->tableTag $ccList $this->tableEndTag";


}

//======================================================================
function loadMemberNames()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM member_info WHERE  $this->memberSql");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_key);

 while ($stmt->fetch()) {  
          
          $this->searchSql = "contract_key = '$contract_key'";       
          $memberList .= $this->loadAccountList();
        }


  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   


return  "$this->tableTag $memberList $this->tableEndTag";


}

//======================================================================
function loadBankNames()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM banking_info WHERE  $this->bankSql");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($contract_key);

 while ($stmt->fetch()) {  
          
          $this->searchSql = "contract_key = '$contract_key'";       
          $bankList .= $this->loadAccountList();
        }


  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();   


return  "$this->tableTag $bankList $this->tableEndTag";


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