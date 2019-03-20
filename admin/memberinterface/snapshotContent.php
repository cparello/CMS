<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class snapShotContent {

private $memberPhoto = null;
private $imageTag = null;
private $borderColor = '#FFF';
private $contractKey =  null;
private $memberId = null;
private $association = null;
private $memberBit = null;
private $locationId = null;
private $accountStatus = null;
private $serviceDuration = null;
private $serviceTerm = null;
private $serviceKey = null;
private $serviceName = null;
private $membershipType = null;
private $serviceEndDate = null;
private $borderColorTwo = null;
private $earlyRenewalGrace = null;
private $earlyRenewalPercent = null;
private $locationArray = null;
private $clubId = null;
private $memberFlag = null;
private $memberFlagText = null;
private $holdArray = null;
private $statusArray = null;
private $allBit = null;
private $upgradeAddOns = null;
private $upAdds = null;
private $attendanceHistory = null;
private $accessDay = null;
private $limitedAccess =null;
private $dueFlag = null;
private $memberHoldFlag = null;
private $attendanceFlag = null;
private $currentMonthDueDate = null;
private $nextMonthDueDate = null;
private $currentStatementDate = null;
private $statementRangeEndDate = null;
private $statementRangeStartDate = null;
private $originalMonthlyCycleDatePast = null;
private $monthlyCount = null;
private $prePayCount = null;
private $nextPaymentDueDate = null;
private $pastDueTotal = null;
private $ccDeclinedFlag = null;
private $nsfFlag = null;


function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }
function setMemberPhoto($memberPhoto) {
       $this->memberPhoto = $memberPhoto;
       }
function setLocationId($locationId) {
       $this->locationId = $locationId;
       }
function setMemberId($memberId) {
       $this->memberId = $memberId;
       }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------------------
function checkClassCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT SUM(class_count) AS count FROM member_class_count WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

if($count > 0) {
  $this->classCount = true;
  }else{
  $this->classCount = false;
  }

$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------
function loadNsfCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM nsf_checks WHERE check_bit = '0' AND contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

if($count > 0) {
  $this->nsfFlag = true;
  }else{
  $this->nsfFlag = false;
  }


$stmt->close();

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadDeclinedCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM rejected_payments WHERE reject_bit = '0' AND contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

if($count > 0) {
  $this->ccDeclinedFlag = true;
  }else{
  $this->ccDeclinedFlag = false;
  }
  
   
$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->todaysDate = date("Y-m-d");
           $datetime1 = new DateTime($this->nextPaymentDueDate);
           $datetime2 = new DateTime($this->todaysDate);
           $interval = $datetime1-> diff($datetime2);                    
           $this->daysPastDue = $interval-> format('%d');
           $this->monthsPastDue = $interval-> format('%m');
           $this->yearsPastDue = $interval-> format('%y');
           
           
           
           if($this->monthsPastDue >= 1) {
           
               if($this->yearsPastDue >= 1) {
                  $months = $this->yearsPastDue * 12;  
                  $this->monthsPastDue = $this->monthsPastDue + $months;
                 }          
           
           
           
             $this->monthlyPayment = $this->monthlyPayment * $this->monthsPastDue;
             }else{
                $this->monthlyPayment = 0;
             }
           

$this->pastDueTotal = $this->monthlyPayment;
$this->pastDueTotal = number_format("$this->pastDueTotal",2);

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//-------------------------------------------------------------------------------------------------------------
function loadSettledPayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($next_payment_due_date);
$stmt->fetch();


$this->nextPaymentDueDate = $next_payment_due_date;
$todaysDateSecs = time(); 
//echo "$this->nextPaymentDueDate != $this->currentMonthDueDate ";
 if($this->nextPaymentDueDate != "" && $this->prePayCount == 0 && $this->serviceCreditCount == 0) {  
          if($this->nextPaymentDueDate != $this->currentMonthDueDate ) {                                           // $this->nextMonthDueDate       
                   $this->loadMonthlyPayment();                                   
             }
     } 
     
if($this->nextPaymentDueDate != "" && $this->prePayCount > 0) {   
    $prepayEndDate = strtotime($next_payment_due_date);
       
      if($todaysDate > $prepayEndDate) {
         $this->loadMonthlyPayment();      
         }
   }

//handles first payment if overdue
if($this->nextPaymentDueDate == "") {
  
   $this->nextPaymentDueDateSecs = strtotime($this->originalMonthlyCycleDatePast);
   
      if($todaysDateSecs >= $this->nextPaymentDueDateSecs) {
         $this->nextPaymentDueDate = $this->originalMonthlyCycleDatePast;
         $this->loadMonthlyPayment();   
        }
   
   
  }
 
$stmt->close();
}
//-------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//-------------------------------------------------------------------------------------------------------------
function checkServiceCredit() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM service_credits WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->serviceCreditCount = $count;


$stmt->close();
}
//-------------------------------------------------------------------------------------------------------------
function loadMonthly() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM monthly_payments WHERE contract_key='$this->contractKey' AND billing_amount != '0.00'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

 $this->monthlyCount = $count;
   
$stmt->close();
}
//-------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($currentCount);
$stmt->fetch();

       if($currentCount > 0) {
         
           $this->loadMonthly();
           
               if($this->monthlyCount ==1 ) {   
                                        
                    $this->checkPrepay();
                    $this->checkServiceCredit();
                     
                     //  if($this->prePayCount == 0) {                        
                           $this->loadSettledPayments();
                      //   }
                                         
                 } 
             }    
         
$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT payment_date FROM monthly_settled WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($payment_date);
$stmt->fetch();

$cycle_day = date("d", strtotime($cycle_date));
$nextDueDaysPast = $past_day + $cycle_day;
$month = date("m",strtotime($payment_date));
$month++;

//create time for the original monthly cycle date in case a payment has never been made
$origCycleYear = date("Y", strtotime($cycle_date));
$origCycleMonth = date("m", strtotime($cycle_date));
$origPastDueDay = $nextDueDaysPast;
$this->originalMonthlyCycleDatePast = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $origCycleMonth, $origPastDueDay, $origCycleYear));

if(date('d') < $cycle_day){
    $this->currentMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")  , $nextDueDaysPast, date("Y")));
}else{
   $this->currentMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")+1  , $nextDueDaysPast, date("Y"))); 
}

//$this->nextMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $nextDueDaysPast, date("Y")));
$this->nextMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month  , $nextDueDaysPast, date("Y")));

$this->currentStatementDate =  date("m/d/Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$this->statementRangeEndDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m"), $nextDueDaysPast, date("Y")));
$this->statementRangeStartDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m")-1  , $cycle_day, date("Y")));

}
//------------------------------------------------------------------------------------------------------------
function checkMemberHold() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM member_hold WHERE  member_id = '$this->memberId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();

if($count > 0) {
  $this->memberHoldFlag = true;
  }

$stmt->close();
}
//------------------------------------------------------------------------------------------------------------
function checkCorporateFlag() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM corporate_flag WHERE contract_key='$this->contractKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();

if($count > 0) {
  $this->corpFlag = true;
  }

$stmt->close();
}
//------------------------------------------------------------------------------------------------------------
function checkCollections() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM billing_collections WHERE contract_key='$this->contractKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();

if($count > 0) {
  $this->collectionsFlag = true;
  }

$stmt->close();
}
//-------------------------------------------------------------------------------------------------------------
function checkBalanceDue() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT due_status, process_date, due_date, balance_due FROM initial_payments WHERE  contract_key = '$this->contractKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($due_status, $process_date, $due_date, $balance_due);
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
              if($balance_due < 0){
                $this->dueFlag = false;
              }
        
        }
   }

}
//-------------------------------------------------------------------------------------------------------------
function insertAttendanceRecord() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO attendance_records VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissss', $locationId, $memberId, $attendanceDate, $attendanceFlag, $attendanceType, $checkInType);

$locationId = $this->locationId;
$memberId = $this->memberId;
$attendanceDate = date("Y-m-d H:i:s");
$attendanceFlag = $this->attendanceFlag;
$checkInType = "BC";

 if($this->membershipType == null) {
   $attendanceType = "SA"; 
   }else{
   $attendanceType = "MA";   
   }



if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------------
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
  

}

}
//-------------------------------------------------------------------------------------------------------------
function loadMemberFreq() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT signup_date FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date ASC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($signup_date);
 $stmt->fetch();
  
 $memberSince =  date('M j, Y', strtotime($signup_date)); 
 $stmt->close();  
 
 $stmt = $dbMain ->prepare("SELECT MAX(attendance_date) FROM attendance_records WHERE  location_id = '$this->locationId' AND member_id='$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($attendance_date);
 $stmt->fetch();

 if($attendance_date == "") {
    $attendanceDate = 'NA';
    }else{
    $attendanceDate =  date('M j, Y  H:i', strtotime($attendance_date));   
    }
   
 $this->attendanceHistory  = "Member Since:  $memberSince<br>Last Attended:  $attendanceDate";
   
$stmt->close();

}
//-------------------------------------------------------------------------------------------------------------
function loadMemberFlag() {

$current = 'CU';
$statusArray = explode(",", $this->statusArray);
 if (in_array($current, $statusArray)) {
 
     if($this->membershipType != null) {
        $this->borderColor = '#339900';
        $this->memberFlagText = 'Member Access Granted';
       }elseif($this->membershipType == null) {
        $this->borderColor = '#3399FF';
        $this->memberFlagText = 'Service Access Granted';
       }       
      
      $this->attendanceFlag = 'N';
                                                                                        
      if($this->borderColorTwo == '#FFFF00') {
          $earlyRenewBox="<div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColorTwo; float:left\"></div>";
         }else{
          $earlyRenewBox="";
         }
      
      $this->memberFlag ="
     <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
     $earlyRenewBox
     <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";  
    
     
    }else{
      
       if($this->membershipType != null) {
          $this->memberFlagText = 'Member Access Denied';
         }elseif($this->membershipType == null) {
          $this->memberFlagText = 'Service Access Denied';
         }     
      
       $this->attendanceFlag = 'Y';
         
       if($this->borderColorTwo == '#FFFF00') {
          $graceRenewBox="<div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColorTwo; float:left\"></div>";
          }else{
          $graceRenewBox="";
          } 
          
     $this->memberFlag ="
     <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
     $graceRenewBox
     <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";            
                        
    }
        
       
        
//does a last check to make sure the client has access to the club based on their membership access type
$locationArray = explode(",", $this->locationArray);
$allClubsId = '0';
  if (!in_array($this->locationId, $locationArray)) {
    
      if(in_array($allClubsId, $locationArray)) {
         $this->borderColor = '#339900';   
         $this->memberFlagText = 'Member Access Granted';
         $this->attendanceFlag = 'N';
         
           if (!in_array($current, $statusArray)) {            
               $this->borderColor = '#990000'; 
               $this->memberFlagText = 'Member Access Denied'; 
               $this->attendanceFlag = 'Y';
               }else{
               
                  if($this->allBit == '1') {
                     $this->borderColor = '#339900';
                     $this->memberFlagText = 'Member Access Granted'; 
                     $this->attendanceFlag = 'N';
                    }else{
                     $this->borderColor = '#990000';  
                     $this->memberFlagText = 'Member Access Denied';  
                     $this->attendanceFlag = 'Y';
                    }
               }  
               
      if($this->borderColorTwo != '#FFFF00') {
         $this->memberFlag ="
         <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
         <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";       
         }else{
         $this->memberFlag ="
         <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
         $earlyRenewBox
         $graceRenewBox
         <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>"; 
         }

      
      
         }else{
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Non Access Member';
          $this->attendanceFlag = 'Y';
      
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";      
         }
         
     }
 
//this does a final check on limited access 
 if($this->limitedAccess == true) {
 
      if($this->accessDay != 1) {
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Limited Access Member';
          $this->attendanceFlag = 'Y';          
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>"; 
         }
 
   }

//checks to see if classes are present and if deleted flags the member if they do not have a membership
 if($this->membershipType == null  &&  $this->classCount == false && $this->serviceTerm == 'C') {
    $this->borderColor = '#FFCC00';
    $this->memberFlagText = 'Service Class(s) Expired';
    $this->attendanceFlag = 'Y';
    $this->memberFlag ="
    <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
    <div style=\"float: left; padding-left: 8px; color: #000000\">$this->memberFlagText</div>"; 
  }elseif($this->membershipType == null  &&  $this->classCount == true) {
    $this->borderColor = '#3399FF';  
    $this->memberFlagText = 'Service Access Granted';
    $this->attendanceFlag = 'N';
    $this->memberFlag ="
    <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
    <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";  
  }


//this checks to see if there is a balance due on an initial payment on a service
$this->checkBalanceDue();
     if($this->dueFlag == true) {          
        $this->borderColor = '#990000'; 
        $this->memberFlagText = 'Balance Due'; 
        $this->attendanceFlag = 'Y';
        $this->memberFlag ="
         <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
         <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";                           
       }

//this checks to se if the account is past due
  $this->loadCycleDate();
  $this->loadRecordCount();
     if($this->pastDueTotal > 0 AND $this->monthlyServicesBool == 1) {          
       $this->borderColor = '#990000'; 
       $this->memberFlagText = 'Account Past Due';
       $this->attendanceFlag = 'Y';
       $this->memberFlag ="
        <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
        <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>"; 
        }


//checks for a rejected check payment
$this->loadNsfCount();
      if($this->nsfFlag == true AND $this->monthlyServicesBool == 1) {
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Rejected ACH Transaction';
          $this->attendanceFlag = 'Y';
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";
          }


//checks for rejected cc payment        
$this->loadDeclinedCount();
      if($this->ccDeclinedFlag == true AND $this->monthlyServicesBool == 1) {
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Rejected CC Transaction';
          $this->attendanceFlag = 'Y';
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";
          }
  
  
//this final check looks to see if the member is on hold
$this->checkMemberHold();
       if($this->memberHoldFlag == true ) {          
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Member On Hold';
          $this->attendanceFlag = 'Y';
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";                           
         }
         
$this->checkCorporateFlag();
       if($this->corpFlag == true ) {          
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Flagged by Corporate - SEE NOTES';
          $this->attendanceFlag = 'Y';
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";                           
         }

$this->checkCollections();
       if($this->collectionsFlag == true ) {          
          $this->borderColor = '#990000'; 
          $this->memberFlagText = 'Collections - SEE NOTES';
          $this->attendanceFlag = 'Y';
          $this->memberFlag ="
          <div style=\"display: block; height: 21px; width: 21px; background-color: $this->borderColor; float:left\"></div>
          <div style=\"float: left; padding-left: 8px; color: $this->borderColor\">$this->memberFlagText</div>";                           
         }

}
//-------------------------------------------------------------------------------------------------------------
function parseUpgradesAddOns() {

 if(!preg_match("/Membership/i", $this->serviceName)) {
      if($this->accountStatus != "CA") {

            if (($this->accountStatus == "EX") && ($this->borderColor == '#990000')) {
                 $this->upAdds .= "$this->serviceName<br>"; 
              }
   
            if ($this->accountStatus == "CU") {
                 $this->upAdds .= "$this->serviceName<br>"; 
              }
       
            if (($this->accountStatus == "EX") && ($this->borderColor == null)) {
                 $this->upAdds .= "" ;
              }      
                             
         }
    }


}
//-------------------------------------------------------------------------------------------------------------
function checkEarlyRenewalStatus()  {

//$todaysDate = date("Y-m-d");
$todaysDate = time();
$end_date = strtotime($this->serviceEndDate); 
//$todaysDate = strtotime($todaysDate);
$early_grace = strtotime($this->earlyRenewalGrace);



if(($end_date > $todaysDate) && ($end_date <= $early_grace)) {
    $this->borderColor = '#339900';
    $this->borderColorTwo = "#FFFF00";       
    }
      
}
//-------------------------------------------------------------------------------------------------------------
function checkPastGrace() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT standard_renewal_grace, early_renewal_grace, early_renewal_percent FROM fees WHERE fee_num ='1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day, $grace_days, $early_renewal_percent);
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
           $this->borderColor = '#990000'; 
          
              if($todays_date > $end_grace_date) {
                 $this->borderColor = '#990000';
                 $this->borderColorTwo = null;
                }else{
                 $this->borderColor = '#990000';
                 $this->borderColorTwo = "#FFFF00";
               }                     
         }      


//sets up for early renewal grace
$graceDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m"), date("d")+$grace_days, date("Y")));
$this->earlyRenewalGrace = $graceDate;
$this->earlyRenewalPercent = $early_renewal_percent;
      
           
 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();       
      
}
//-------------------------------------------------------------------------------------------------------------
function checkEligibleRenewal()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT  MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($end_date);
$rowCount = $stmt->num_rows;
$stmt->fetch();
 
 
 if($rowCount != 0) { 
        $this->serviceEndDate = $end_date;
        $this->checkPastGrace();          
   }

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-------------------------------------------------------------------------------------------------------------
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
               $this->borderColor = '#339900';
               
                  if($this->clubId == '0') {
                     $this->allBit = 1;
                    }
               
        break;
        case "EX":
               $this->borderColor = '#990000';              
        break;
        case "HO":
               $this->borderColor = '#990000';
        break;
        case "CA":
               $this->borderColor = '#990000'; 
        break;
      }
  
  
$this->locationArray .="$this->clubId,";

 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-------------------------------------------------------------------------------------------------------------
function loadPifServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  service_quantity, service_term, club_id, end_date, start_date FROM paid_full_services WHERE contract_key ='$this->contractKey' ORDER BY signup_date");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $service_quantity, $service_term, $club_id, $end_date, $start_date);
$rowCount = $stmt->num_rows;
//echo"$rowCount";
             if($rowCount == 0) {
                 $pif_services = "";
                
               }else{
               
                    while ($stmt->fetch()) {  
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;
                               $this->serviceName = $service_name;  
                               $this->clubId = $club_id;
                               
                               if(preg_match("/Membership/i", $this->serviceName)) {
                                   $this->memberBit = 1;
                                   $endDate = date('m/d/Y', strtotime($end_date)); 
                                   $startDate = date('m/d/Y', strtotime($start_date));                                 
                                   $this->membershipType = "$this->serviceName<br>(Start $startDate)-(End $endDate)";
                                   $this->checkLimitedAccess();
                                  }
                                                                                             
                               $this->checkAccountStatus();
                                     //make sure the account has not already been canceld or is on hold                         
                                  if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                               
                                         if($this->serviceTerm != 'C') {
                                             $this->checkEligibleRenewal();
                                           }else{
                                             $this->checkClassCount();
                                           }
                                                 
                                      //   if($this->earlyRenewalPercent != 0) {                                          
                                            $this->checkEarlyRenewalStatus(); 
                                      //    }                                          
                                          
                                     }   
                                     
                             $this->parseUpgradesAddOns();
                                     
                             $this->statusArray .= "$this->accountStatus,";  
                                
                             } //end while
                             
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------------
function loadMonthlyServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name,  number_months, club_id, end_date, start_date, service_id FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_name, $number_months, $club_id, $end_date, $start_date, $service_id);
$rowCount = $stmt->num_rows;

             if($rowCount == 0) {
               $monthlyServices = "";
                
               }else{
               
                    while ($stmt->fetch()) { 
                        $stmt99 = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$service_key' AND service_id = '$service_id'");
                        $stmt99->execute();      
                        $stmt99->store_result();   
                        $stmt99->bind_result($account_status);
                        $stmt99->fetch();
                        $stmt99->close();
                        //echo "account status $account_status $this->contractKey $service_key $service_id";
                        if ($account_status == 'CU'){
                            $this->monthlyServicesBool = 1;
                        }else{
                            $this->monthlyServicesBool = 0;
                        }
                        
                               $this->serviceKey = $service_key;
                               $this->serviceDuration = $number_months;
                               $this->serviceTerm = 'M';
                               $this->serviceName = $service_name;
                               $this->clubId = $club_id;
                               
                               $this->checkAccountStatus();
                               
                                 if(preg_match("/Membership/i", $this->serviceName)) {
                                     $endDate = date('m/d/Y', strtotime($end_date));
                                     $startDate = date('m/d/Y', strtotime($start_date));
                                     $this->memberBit = 1;
                                     $this->membershipType = "$this->serviceName<br>(Start $startDate)-(End $endDate)";
                                     $this->checkLimitedAccess();
                                    }
                                    
                              $this->parseUpgradesAddOns();    
                                    
                              $this->statusArray .= "$this->accountStatus,";
                              
                             }
               }
               
   if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();      

}                      
//-------------------------------------------------------------------------------------------------------------
function loadServices() {


$this->loadMonthlyServices();
$this->loadPifServices();
$this->loadMemberFreq();
$this->loadMemberFlag();
$this->insertAttendanceRecord();

}
//-------------------------------------------------------------------------------------------------------------
function parsePhotoImage() {

     if($this->memberPhoto == "")  {
        $photoName = 'no_photo.jpg';
        }else{
        $photoName = $this->memberPhoto;
        }

$this->imageTag = "<img src=\"../memberphotos/$photoName\" width=\"150\" height=\"175\" style=\"border:5px solid $this->borderColor\" onError=\"this.src = '../memberphotos/no_photo.jpg'\">";
            
}
//-------------------------------------------------------------------------------------------------------------
function loadAssociation() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT group_type, group_name FROM member_groups WHERE contract_key = '$this->contractKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($group_type, $group_name);
   $stmt->fetch();

 switch ($group_type) {
        case "S":
              if($this->memberBit == 1) {                 
                 $this->association = "Single Membership";
                 }else{
                 $this->association = "Single Services";
                 }
        break;
        case "F":
              if($this->memberBit == 1) {                 
                 $this->association = "Family Membership";
                 }else{
                 $this->association = "Family Services";
                 }
        break;
        case "B":
               $this->association = "$group_name";
        break;  
        case "O":
               $this->association = "$group_name";
        break;        
   } 
   
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//============================================================================================================
function loadnotes(){
$dbMain = $this->dbconnect();
    
   $stmt = $dbMain ->prepare("SELECT MAX(note_date), note_topic FROM account_notes WHERE contract_key = '$this->contractKey' AND note_topic LIKE '%Credit Card needs Updating%'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->noteDate1, $this->noteTopic1);
   $stmt->fetch();
   $stmt->close(); 
   
   $this->noteTopic1 = trim($this->noteTopic1);
   if ($this->noteTopic1 ==''){
        $this->noteTopic1 = '';
        $this->noteDate1 = '';
   }else{
        $this->noteDate1 = date("F - Y",strtotime($this->noteDate1));
   }
   
   
   
   $stmt = $dbMain ->prepare("SELECT MAX(note_date), note_topic FROM account_notes WHERE contract_key = '$this->contractKey' AND note_category = 'BL' AND priority = 'H' AND target_app = 'MI'  AND note_topic NOT LIKE '%Credit Card needs Updating%'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->noteDate2, $this->noteTopic2);
   $stmt->fetch();
   $stmt->close(); 
   
  $this->noteTopic2 = trim($this->noteTopic2);
   if ($this->noteTopic2 ==''){
        $this->noteTopic2 = '';
        $this->noteDate2 = '';
   }else{
        $this->noteDate2 = date("F - Y",strtotime($this->noteDate2));
   }
   
   $stmt = $dbMain ->prepare("SELECT MAX(note_date), note_topic FROM account_notes WHERE contract_key = '$this->contractKey' AND note_category = 'MI' AND priority = 'H' AND target_app = 'MI'  AND note_topic NOT LIKE '%Credit Card needs Updating%'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->noteDate3, $this->noteTopic3);
   $stmt->fetch();
   $stmt->close(); 
   
   $this->noteTopic3 = trim($this->noteTopic3);
   if ($this->noteTopic3 ==''){
        $this->noteTopic3 = '';
        $this->noteDate3 = '';
  }else{
        $this->noteDate3 = date("F - Y",strtotime($this->noteDate3));
    }
}
//-------------------------------------------------------------------------------------------------------------
function getImageTag() {
     return($this->imageTag);
     }
function getAssociation() {
     return($this->association);
     }
function getMembershipType() {
     return($this->membershipType);
     }
function getMemberFlag() {
    return($this->memberFlag);
    }
function getUpAdds() {
    return($this->upAdds);
    }
function getAttendanceHistory() {
    return($this->attendanceHistory);
    }
    
function getNoteTopic1() {
     return($this->noteTopic1);
     }
function getNoteTopic2() {
    return($this->noteTopic2);
    }
function getNoteDate1() {
    return($this->noteDate1);
    }
function getNoteDate2() {
    return($this->noteDate2);
    }
function getNoteTopic3() {
    return($this->noteTopic3);
    }
function getNoteDate3() {
    return($this->noteDate3);
    }    
function getFlag() {
    return($this->attendanceFlag);
    }   

}
//=====================================================================
include  "../dbConnect.php";          
 
$member_id = $_REQUEST['member_id'];
$location_id = $_REQUEST['location_id'];

//$location_id = 3551;    
//get the basic member info
$result = $dbMain ->query(" SELECT contract_key, first_name, middle_name, last_name, emg_contact, emg_relationship,  emg_phone_phone, member_photo FROM member_info WHERE member_id = '$member_id'"); 
$row_count = $result->num_rows; 

     if($row_count == 0) {
         $message = 1;
         $dbMain->close();     
         echo"$message";     
         exit;
       
         }else{
       
         $row = $result->fetch_array(MYSQLI_NUM);
         $contract_key = $row[0]; 
         $first_name = $row[1];
         $middle_name = $row[2];
         $last_name = $row[3];
         $emerg_name = $row[4];
         $emerg_relation = $row[5];
         $emerg_phone = $row[6];
         $member_photo = $row[7];
         
         $parseMember = new snapShotContent();
         $parseMember-> setContractKey($contract_key);
         $parseMember-> setMemberPhoto($member_photo);
         $parseMember-> setLocationId($location_id);
         $parseMember-> setMemberId($member_id);
         
         
         $parseMember-> loadAssociation();
         $parseMember-> loadServices();
         $parseMember-> loadnotes();
         $parseMember-> parsePhotoImage();

         $association = $parseMember-> getAssociation();        
         $image_tag = $parseMember-> getImageTag();
         $membership_type = $parseMember-> getMembershipType();
         $member_flag = $parseMember-> getMemberFlag();
         $up_adds = $parseMember-> getUpAdds();
         $attendance_history = $parseMember-> getAttendanceHistory();
         $note_topic1 = $parseMember-> getNoteTopic1();
         $note_topic2 = $parseMember-> getNoteTopic2();
         $note_date1 = $parseMember-> getNoteDate1();
         $note_date2 = $parseMember-> getNoteDate2();
         $note_topic3 = $parseMember-> getNoteTopic3();
         $note_date3 = $parseMember-> getNoteDate3();
         $flag = $parseMember-> getFlag();
         
        //do a check to put NA if services do not exist
        if($membership_type == "") {
           $membership_type = 'NA';
           }
        if($up_adds == "") {
           $up_adds = 'NA';
           }
         
         $content_array = "$first_name $middle_name $last_name|$image_tag|$emerg_name<br>$emerg_relation<br>$emerg_phone|$association|$membership_type|$member_flag|$up_adds|$attendance_history|$note_topic1|$note_topic2|$note_date1|$note_date2|$note_topic3|$note_date3|$flag";

        echo"$content_array";     
        exit;                                                                                                                  
      }
 
?>