<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  holderMemberList{

private $searchSql = null;
private $contractKey = null;
private $memberId = null;
private $firstName = null;
private $lastName = null;
private $email = null;
private $phone = null;
private $locationId = null;
private $resultList = null;
private $memberName = null;
private $memberAddress = null;
private $dob = null;
private $accountAccess = null;
private $memberLogin = null;
private $serviceName = null;
private $serviceKey = null;
private $serviceTerm = null;
private $serviceDuration = null;
private $accessDay = null;
private $limitedAccess = null;
private $statusArray = null;
private $locationArray = null;
private $checkInAccess = null;
private $rowColor = null;
private $allBit = null;
private $dueFlag = null;
private $memberHoldFlag = null;
private $listingRows = null;
private $counter = 1;
private $memberTableHeader = null;

private $holderTableHeader = null;
private $accountHolderName = null;
private $accountHolderAddress = null;
private $groupName = null;


function setLocationId($locationId) {
       $this->locationId = $locationId;
       }
function setSearchSql($searchSql) {
       $this->searchSql = $searchSql;
       }
function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setMemberId($memberId) {
       $this->memberId = $memberId;
       }


 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=================================================
function loadGroupName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_name  FROM member_groups WHERE contract_key='$this->contractKey' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($group_type, $group_name);
  $stmt->fetch();

  switch ($group_type) {
        case "S":
         $this->groupName = 'Single';
        break;
        case "F":
         $this->groupName = 'Family'; 
        break;
        case "B":
         $this->groupName = $group_name;
        break;
        case "O":
         $this->groupName = $group_name;
        break;
   }

}
//--------------------------------------------------------------------------------------
function retrieveAccountHolderInfo() {

$dbMain = $this->dbconnect();

if($this->searchSql != null) {

$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, first_name, middle_name, last_name, street, city, state, zip, dob, primary_phone  FROM contract_info WHERE  $this->searchSql");   
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $dob, $primary_phone);

        while ($stmt->fetch()) { 
                 $this->contractKey = $contract_key;                 
                 $this->accountHolderName = "$first_name $middle_name $last_name";             
                 $this->accountHolderAddress = "$street $city, $state $zip";
                 $this->dob = date('M j, Y', strtotime($dob));
                 $this->loadGroupName();
                 $this->accountAccess = 'Y';
                 $this->loadAccountListings();
            }

  }else{
  
$stmt = $dbMain ->prepare("SELECT DISTINCT first_name, middle_name, last_name, street, city, state, zip, dob, primary_phone  FROM contract_info WHERE contract_key='$this->contractKey' ");  
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name, $street, $city, $state, $zip, $dob, $primary_phone);
  $stmt->fetch();
  
  $this->accountHolderName = "$first_name $middle_name $last_name";  
  $this->accountHolderAddress = "$street $city, $state $zip";
  $this->dob = date('M j, Y', strtotime($dob));
  $this->loadGroupName();
  $this->accountAccess = 'Y';
  $this->loadAccountListings();
  }


}
//--------------------------------------------------------------------------------------
function loadAccountList() {

       $this->retrieveAccountHolderInfo();
       $this->loadHolderTableHeader();
       $this->resultList = "$this->holderTableHeader $this->listingRows </table>";

}
//--------------------------------------------------------------------------------------
function loadHolderTableHeader() {

$this->holderTableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr bgcolor=\"#303030\">
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Contract #</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Group Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Account Holder Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Account Holder Address</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">DOB</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">View Account</font></th>
</tr>\n";                   

}
//--------------------------------------------------------------------------------------
function loadAccountListings() {

  //create color rows
    static $cell_count = 1;
    if($cell_count == 2) {
      $color = "#D8D8D8";
      $cell_count = "";
      }else{
      $color = "#FFFFFF";
      }
      $cell_count = $cell_count + 1;

 $this->listingRows .="<tr bgcolor=\"$color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->accountHolderName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->accountHolderAddress</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->dob</b></font></td>
<td align=\"left\"  valign =\"top\">
<form style=\"display:inline;\" method=\"post\" action=\"viewAccountInfo.php\">
<input type=\"hidden\" name=\"contract_key\" value=\"$this->contractKey\">
<input type=\"hidden\" name=\"member_id\" value=\"\">
<input type=\"hidden\" name=\"account_access\" value=\"$this->accountAccess\">
<input type=\"submit\" name=\"edit\" value=\"View Account\">
<input type=\"hidden\" id=\"whichBackBut\" name=\"whichBackBut\" value=\"1\"/></form>
</td>
</tr>\n";

$this->counter++;

}
//=================================================

//below handles a search for members. Above for account holders

//=================================================
function compareAccountHolderMember() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, dob  FROM contract_info WHERE contract_key='$this->contractKey' ");  
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($first_name, $middle_name, $last_name, $dob);
  $stmt->fetch();
  
  $holderName = "$first_name $middle_name $last_name";
  
  if(($holderName == $this->memberName) && ($dob == $this->dob)) {
     $this->accountAccess = 'Y';
     $this->memberLogin = 'Y';
     }else{
     $this->accountAccess = 'N';
     $this->memberLogin = 'N';
     }
  
$stmt->close();
}
//---------------------------------------------------------------------------------------
function retrieveMemberInfo() {

$dbMain = $this->dbconnect();

if($this->searchSql != null) {

  $stmt = $dbMain ->prepare("SELECT contract_key, member_id, first_name, middle_name, last_name, street, city, state, zip, dob  FROM member_info WHERE  $this->searchSql");   
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($contract_key, $member_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $dob);

        while ($stmt->fetch()) { 
                 $this->contractKey = $contract_key;
                 $this->memberId = $member_id;
                 $this->memberName = "$first_name $middle_name $last_name";             
                 $this->memberAddress = "$street $city, $state $zip";
                 $this->dob = $dob;
                        
                 $this->compareAccountHolderMember();
                 $this->loadPifServices();
                 $this->loadMonthlyServices();
                 $this->loadMemberFlag();
                 $this->loadMemberListings();
            }
            
   }else{
   
  $stmt = $dbMain ->prepare("SELECT contract_key, first_name, middle_name, last_name, street, city, state, zip, dob  FROM member_info WHERE  member_id= '$this->memberId' ");   
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $dob);   
  $stmt->fetch();
   
   $this->contractKey = $contract_key;
   $this->memberName = "$first_name $middle_name $last_name";
   $this->memberAddress = "$street $city, $state $zip";
   $this->dob = $dob;
   
   $this->compareAccountHolderMember();
   $this->loadPifServices();
   $this->loadMonthlyServices();
   $this->loadMemberFlag();
   $this->loadMemberListings();
   }
   
      
$stmt->close();

}
//--------------------------------------------------------------------------------------
function loadMemberList() {

       $this->retrieveMemberInfo();
       $this->loadMemberTableHeader();
       $this->resultList = "$this->memberTableHeader $this->listingRows </table>";

}
//=================================================
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name, service_quantity, service_term, club_id FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $service_quantity, $service_term, $club_id);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceName = $service_name;  
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;
                               $this->clubId = $club_id;
                               
                               if(preg_match("/Membership/i", $this->serviceName)) {
                                   $this->checkLimitedAccess();
                                  }
                                  
                                $this->checkAccountStatus(); 
                                  
                                 //make sure the account has not already been canceld or is on hold
                                  if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {                               
                                         if($this->serviceTerm != 'C') {
                                             $this->checkServiceExpiration();
                                           } 
                                      }
                                                                                                       
                                   $this->statusArray .= "$this->accountStatus,";  
                                   $this->locationArray .="$this->clubId,";
                                
                             } //end while
                             
                }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

}
//----------------------------------------------------------------------------------------
function loadMonthlyServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  number_months, club_id FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $number_months, $club_id);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $number_months;
                               $this->serviceTerm = 'M';
                               $this->serviceName = $service_name;
                               $this->clubId = $club_id;
                               
                               $this->checkAccountStatus();
                               
                                 if(preg_match("/Membership/i", $this->serviceName)) {
                                     $this->checkLimitedAccess();
                                    }
                                    
                                
                                $this->locationArray .="$this->clubId,";   
                                $this->statusArray .= "$this->accountStatus,";
                              
                             }
               }
               
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      

}                      
//----------------------------------------------------------------------------------------
function checkLimitedAccess() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT access_limit FROM service_cost WHERE service_key = '$this->serviceKey' AND service_term='$this->serviceTerm' AND service_quantity='$this->serviceDuration' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($access_limit);   
$stmt->fetch();
$stmt->close();


$today = date("w");
$accessLimitArray = str_split($access_limit);
$accessBit = $accessLimitArray[$today];

$mark = 1;
if(in_array($mark, $accessLimitArray)) {

$this->limitedAccess = true;

   switch ($today) {
        case "0":
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }
        break;
        case "1":
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }             
        break;
        case "2":
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }
        break;
        case "3":
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }
        break;
        case "4":        
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }        
        break;
        case "5": 
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }        
        break;
        case "6": 
                 if($accessBit == 1) {
                     $this->accessDay = 1;
                   }        
        break; 
  }    
  

}else{
$this->limitedAccess = false;
}

}
//---------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 if($account_status == 'CU') {
      if($this->clubId == '0') {
         $this->allBit = 1;
        }
   }else{
         if($this->clubId == '0') {
         $this->allBit = 0;  
         }
   }
 
 $this->accountStatus = $account_status;
 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//---------------------------------------------------------------------------------------
function checkServiceExpiration() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();
 
 
 if($rowCount != 0) { 
        $this->serviceEndDate = $end_date;
        $todays_date = date("Y-m-d");
        $service_end_date = $this->serviceEndDate;
        $todays_date  = strtotime($todays_date);
        $service_end_date  = strtotime($service_end_date);
   
        //check to see if the service has expired
        if($service_end_date < $todays_date) {
           $this->accountStatus  = 'EX';
           }

     }


}
//----------------------------------------------------------------------------------------
function checkBalanceDue() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT due_status, process_date, due_date FROM initial_payments WHERE  contract_key = '$this->contractKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($due_status, $process_date, $due_date);
 $stmt->fetch();
 $rowCount = $stmt->num_rows;

  if($rowCount != 0) {
  
     if($due_status == 'P') {
     
         $this->dueFlag = false;   
       
        }else{
        
         $todays_date = date("Y-m-d");
        
         $todaysDate = strtotime($todays_date);
         $dueDate = strtotime($due_date);
         $process_date = strtotime($process_date);
        
              if($todaysDate > $dueDate) {
                 $this->dueFlag = true; 
                 }else{
                 $this->dueFlag = false;
                 }
        
        }
   }

}
//----------------------------------------------------------------------------------------
function checkMemberHold() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM member_hold WHERE  member_id = '$this->memberId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();

if($count > 0) {
  $this->memberHoldFlag = true;
  }else{
  $this->memberHoldFlag = false;
  }
  

$stmt->close();
}
//----------------------------------------------------------------------------------------
function loadMemberFlag() {

$current = 'CU';
$statusArray = explode(",", $this->statusArray);
 if (in_array($current, $statusArray)) {
 
     $this->checkInAccess = true;
     
    }else{
      
     $this->checkInAccess = false;  
     $this->rowColor = '#FF3300';                   
    }
    
//does a last check to make sure the client has access to the club based on their membership access type
$locationArray = explode(",", $this->locationArray);
$allClubsId = '0';
  if (!in_array($this->locationId, $locationArray)) {
    
      if(in_array($allClubsId, $locationArray)) {      
           $this->checkInAccess = true;
         
           if (!in_array($current, $statusArray)) {            
               $this->checkInAccess = false;        
               $this->rowColor = '#FF3300';
                
               }else{
               
                  if($this->allBit == '1') {
                     $this->checkInAccess = true;
                    }else{
                     $this->checkInAccess = false;        
                     $this->rowColor = '#FF3300';
                    } 
               }  
                     
      
         }else{
                    $this->checkInAccess = false;        
                    $this->rowColor = '#FF3300';    
         }
         
     }

//this does a final check on limited access 
 if($this->limitedAccess == true) {
 
      if($this->accessDay != 1) {
         $this->checkInAccess = false;        
         $this->rowColor = '#FF3300'; 
         }
 
   }

//this checks to see if there is a balance due on an initial payment on a service
$this->checkBalanceDue();

          if($this->dueFlag == true) {
             $this->checkInAccess = false;        
             $this->rowColor = '#FF3300';                           
            }
          
//this final check looks to see if the member is on hold
$this->checkMemberHold();
          if($this->memberHoldFlag == true) {
             $this->checkInAccess = false;        
             $this->rowColor = '#FF3300';                         
            }

}
//---------------------------------------------------------------------------------------
function loadMemberTableHeader() {

$this->memberTableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr bgcolor=\"#303030\">
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Contract #</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Address</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member ID</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Check In</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">View Account</font></th>
</tr>\n";                   

}
//----------------------------------------------------------------------------------------
function loadMemberListings() {

  //create color rows
    static $cell_count = 1;
    if($cell_count == 2) {
      $color = "#D8D8D8";
      $cell_count = "";
      }else{
      $color = "#FFFFFF";
      }
     $cell_count = $cell_count + 1;
     
     if($this->checkInAccess == false) {
        $color = "#FF3300";
        $disabled1 = 'disabled="disabled"';
        $disabled2 = 'disabled="disabled"';
        }else{
        $disabled1 = 'readonly="readonly"';
        $disabled2 = "";
        }


 $this->listingRows .="<tr bgcolor=\"$color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberAddress</b></font></td>
<td align=\"left\" valign =\"top\"><form style=\"display:inline;\"><input type= \"text\" id=\"check_in$this->counter\" name=\"check_in$this->counter\" value=\"$this->memberId\" size=\"15\" maxlength=\"20\" $disabled1/></td>
<td align=\"left\" valign =\"top\"><input type=\"button\" id=\"sub_check$this->counter\" class=\"checkBut\" value=\"Check In\" $disabled2\></form></td>
<td align=\"left\"  valign =\"top\">
<form style=\"display:inline;\" method=\"post\" action=\"viewAccountInfo.php\">
<input type=\"hidden\" name=\"contract_key\" value=\"$this->contractKey\">
<input type=\"hidden\" name=\"member_id\" value=\"$this->memberId\">
<input type=\"hidden\" name=\"account_access\" value=\"$this->accountAccess\">
<input type=\"submit\" name=\"edit\" value=\"View Account\">
<input type=\"hidden\" id=\"whichBackBut\" name=\"whichBackBut\" value=\"1\"/></form>
</td>
</tr>\n";

$this->counter++;

$this->statusArray = null;
$this->locationArray = null;
}
//----------------------------------------------------------------------------------------
function loadNonMemberTableHeader() {

$this->memberTableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr bgcolor=\"#303030\">
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">First Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Last Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Phone</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Email</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Id Number</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Update</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Print Bar Code</font></th>
</tr>\n";                   

}
//--------------------------------------------------------------------------------------
function loadNonMemberListings() {

  //create color rows
    static $cell_count = 1;
    if($cell_count == 2) {
      $color = "#D8D8D8";
      $cell_count = "";
      }else{
      $color = "#FFFFFF";
      }
      $cell_count = $cell_count + 1;

 $this->listingRows .="<tr bgcolor=\"$color\">
<td align=\"left\" valign =\"middle\"><font face=\"Arial\" size=\"2\" color=\"black\">$this->counter</font></td>
<td align=\"left\" valign =\"top\"><form style=\"display:inline;\" name=\"F$this->contractKey\"><input type=\"text\" name=\"first_name\" id=\"first_name$this->contractKey\" value=\"$this->firstName\" size=\"15\" maxlength=\"20\">
<td align=\"left\" valign =\"top\"><input type=\"text\" name=\"last_name\" id=\"last_name$this->contractKey\" value=\"$this->lastName\"size=\"15\" maxlength=\"20\"></td>
<td align=\"left\" valign =\"top\"><input type=\"text\" name=\"phone\" id=\"phone$this->contractKey\" value=\"$this->phone\"size=\"15\" maxlength=\"20\"></td>
<td align=\"left\" valign =\"top\"><input type=\"text\" name=\"email\" value=\"$this->email\" id=\"email$this->contractKey\"size=\"15\" maxlength=\"20\"></td>
<td align=\"left\" valign =\"top\"><input type=\"text\" name=\"member_id\" value=\"$this->memberId\" id=\"member_id$this->contractKey\" size=\"15\" maxlength=\"20\" readonly></td>
<td align=\"left\" valign =\"top\"><input type=\"submit\" name=\"edit\" class=\"submitbutton\" value=\"Update\"></td>
<td align=\"left\" valign =\"top\"><input type=\"submit\" name=\"print\" class=\"submitbutton\" value=\"Print Bar Code\">
<input type=\"hidden\" name=\"contract_key\" value=\"$this->contractKey\" id=\"contract_key$this->contractKey\">
</form>
</td>
</tr>\n";

$this->counter++;

}
//----------------------------------------------------------------------------------------
function retrieveNonMemberInfo() {

if($this->searchSql == null) {
   $this->searchSql = " sm_member_id = '$this->memberId'";
   }

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT sm_contract_key, sm_member_id, sm_fname, sm_lname, sm_phone, sm_email  FROM schedular_member_info WHERE  $this->searchSql");   
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($smContractKey, $smMemberId, $smFname, $smLname, $smPhone, $smEmail);

        while ($stmt->fetch()) { 
                 $this->contractKey = $smContractKey;
                 $this->memberId = $smMemberId;
                 $this->firstName = $smFname;
                 $this->lastName = $smLname;
                 $this->phone = $smPhone;
                 $this->email = $smEmail;

                 $this->loadNonMemberListings();
                                           
                }

}
//----------------------------------------------------------------------------------------
function loadNonMemberList() {

$this->retrieveNonMemberInfo();
$this->loadNonMemberTableHeader();
$this->resultList = "$this->memberTableHeader $this->listingRows </table>";




}
//==================================================
function getListings() {
       return($this->resultList);
       }










}
?>