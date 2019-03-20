<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  bookClass {

private  $memberId = null;
private  $scheduleId = null;
private  $bundleId = null;
private  $locationId = null;
private  $typeId = null;
private  $clubId = null;
private  $serviceKey = null;
private  $classDate = null;
private  $memType = null;
private  $bundleArray = null;
private  $contractKey = null;
private  $groupNumber = null;
private  $duration = null;
private  $serviceTerm = null;
private  $groupType = null;
private  $accountStatus = null;
private  $memberClassCount = null;
private  $classBit = 1;
private  $classStatus = null;
private  $timeSlot = null;
private  $bookingCount = null;
private  $bookingStatus = null;
private  $bookingQuota = null;
private  $smMemberId = null;
private  $smContractKey = null;
private  $firstName = null;
private  $lastName = null;
private  $phone = null;
private  $email = null;
private  $inArrayBit = null;
private  $classCountMember = null;


function setMemberId($memberId) {
        $this->memberId = $memberId;
        }

function setScheduleId($scheduleId) {
        $this->scheduleId = $scheduleId;
        }
        
function setBundleId($bundleId) {
        $this->bundleId = $bundleId;
        }

function setClassDate($classDate) {
        $this->classDate = $classDate;
        }
 
function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
 
function setLocationId($locationId) {
        $this->locationId = $locationId;
        }
       
function setClubId($clubId) {
        $this->clubId = $clubId;
        }        
         
function setTimeSlot($timeSlot) {
        $this->timeSlot = $timeSlot;
        }  
function setTaSalt($ta_salt)  {
        $this->taSalt = $ta_salt;
        }         
        
        
//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
} 
//-------------------------------------------------------------------------------------
function updateSmMemberClassCount() {

$dbMain = $this->dbconnect();
$sql = "UPDATE schedular_member_class_count SET class_count= ? WHERE sm_contract_key = '$this->smContractKey' AND service_key='$this->serviceKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $smMemberClassCount);

$smMemberClassCount = $this->smMemberClassCount;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//-------------------------------------------------------------------------------------
function bookSessionMemberClass() {

      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT SUM(class_count) FROM schedular_member_class_count WHERE sm_contract_key = '$this->smContractKey' AND service_key='$this->serviceKey'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($classCount);
      $stmt->fetch();
      $stmt->close();
      
           if($classCount != 0) {
              $this->smMemberClassCount = $classCount - $this->classBit;
              $this->updateSmMemberClassCount();
              $this->insertClassBook();              
             }else{
              $this->classStatus = 3;             
             }

/*
CREATE TABLE schedular_member_class_count (
sm_contract_key INT(20) NOT NULL, 
sm_member_id INT(20) NOT NULL,
service_key INT(10) NOT NULL,
class_count INT(10) NOT NULL

CREATE TABLE schedular_member_class_count (
sm_contract_key INT(20) NOT NULL, 
sm_member_id INT(20) NOT NULL,
service_key INT(10) NOT NULL,
class_count INT(10) NOT NULL
);


*/

}
//-------------------------------------------------------------------------------------
function loadSchedulerMember() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT sm_contract_key, sm_fname, sm_lname, sm_phone, sm_email FROM schedular_member_info WHERE sm_member_id='$this->smMemberId' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($smContractKey, $smFname, $smLname, $smPhone, $smEmail);
  $rowCount = $stmt->num_rows;
  $stmt->fetch();
  $stmt->close();

  $smFname = trim($smFname);

  if($rowCount > 0 AND $smFname != "") {
     
     $this->smContractKey = $smContractKey;
     
     if($this->memType == "N") {
        $this->firstName = $smFname;
        $this->lastName = $smLname;
        $this->phone = $smPhone;
        $this->email = $smEmail;
        }
         
        
    $stmt = $dbMain ->prepare("SELECT DISTINCT service_key  FROM schedular_member_services WHERE sm_contract_key = '$smContractKey' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($serviceKey);
    $pifRowCount = $stmt->num_rows;
    
        while ($stmt->fetch()) {
                
                   if(in_array($serviceKey, $this->bundleArray)) {
                             
                             $this->serviceKey = $serviceKey;
                             $this->inArrayBit = 1;
                             
                               $this->checkBookingStatus();       
                               
                                  if($this->bookingStatus != 1) {
                                     $this->bookSessionMemberClass();
                                    }
                        }                        
                 }

                             if($this->inArrayBit != 1) {
                                $this->classStatus = 5; 
                               }

   }else{
       if(($this->groupType == 'B') || ($this->groupType == 'O')) {
             $this->classStatus = 6; 
          }else{
             if($this->classStatus != 3) {
               $this->classStatus = 5;
               }
             
          }
   }


/*  
  DROP TABLE IF EXISTS schedular_member_services;
CREATE TABLE schedular_member_services (
sm_contract_key INT(20) NOT NULL, 
sm_member_id INT(20) NOT NULL,
service_key INT(10) NOT NULL,
service_quantity INT(10) NOT NULL,
purcahse_date  DATETIME NOT NULL
);
CREATE TABLE scheduar_member_info (
sm_contract_key  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
sm_member_id INT(20) NOT NULL,
sm_fname CHAR(30) NOT NULL,
sm_lname CHAR(30) NOT NULL,
sm_phone CHAR(20) NOT NULL,
sm_email CHAR(40) NOT NULL
);
*/

}
//-------------------------------------------------------------------------------------
function checkBookingQuota() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT count(booking_id) AS booking_quota FROM class_bookings WHERE member_id='$this->memberId' AND service_key='$this->serviceKey' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($booking_quota);
  $stmt->fetch();
  $stmt->close();

  $this->bookingQuota = $booking_quota;

}
//--------------------------------------------------------------------------------------
function checkBookingStatus() {

$classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";

//checks to see if member id or smMemberId
if($this->smMemberId != null) {
    $memberId = $this->smMemberId;
   }else{
    $memberId = $this->memberId;  
   }


      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT count(booking_id) AS booking_count FROM class_bookings WHERE schedule_id = '$this->scheduleId' AND class_date_time='$classDateTime' AND club_id='$this->clubId' AND member_id='$memberId'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($booking_count);
      $stmt->fetch();
      $stmt->close();
      
     
     
      if($booking_count > 0) {
         $this->bookingStatus = 1;
         $this->classStatus = 1;
         }
      
}
//-------------------------------------------------------------------------------------
function loadBookingCount() {

$classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";


$dbMain = $this->dbconnect();

//get the booking count
     $stmt = $dbMain ->prepare("SELECT capacity FROM class_schedules WHERE schedule_id = '$this->scheduleId' ");
     $stmt->execute();      
     $stmt->store_result();      
     $stmt->bind_result($capacity); 
     $stmt->fetch();
     $stmt->close();


      $stmt = $dbMain ->prepare("SELECT count(booking_id) AS booking_count FROM class_bookings WHERE schedule_id = '$this->scheduleId' AND class_date_time='$classDateTime' AND club_id='$this->clubId'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($bookingCount);
      $stmt->fetch();
      $stmt->close();
      
      $this->bookingCount = $capacity - $bookingCount;
      
      //echo "$this->bookingCount";
      //exit;

}
//-------------------------------------------------------------------------------------
function insertClassBook() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_name FROM schedule_type WHERE type_id = '$this->typeId' AND type_name LIKE '%Train%' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_name);
 $rowCount= $stmt->num_rows;
 $stmt->fetch();
 $stmt->close();

 $classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";
 
 if ($rowCount >= 1){
             $stmt = $dbMain ->prepare("SELECT instructor_id FROM class_schedules WHERE schedule_id = '$this->scheduleId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($instructor_id);
             $stmt->fetch();
             $stmt->close();
             
             $stmt = $dbMain ->prepare("SELECT instructor_name FROM instructor_info WHERE instructor_id = '$instructor_id'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($instructor_name);
             $stmt->fetch();
             $stmt->close();
           
             $nameArray = explode(' ',$instructor_name);
             $length = count($nameArray);
             //echo "$instructor_name $length";
             //exit;
             if ($length == 2){
                $firstName = $nameArray[0];
                $lastName = $nameArray[1];
                
                 $stmt = $dbMain ->prepare("SELECT email FROM employee_info WHERE emp_fname LIKE '%$firstName%' AND emp_lname LIKE '%$lastName%'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($email);
                 $stmt->fetch();
                 $stmt->close();
             }else{
                $firstName = $nameArray[0];
                $mName = $nameArray[1];
                $lastName = $nameArray[2];
               // echo "$firstName $mName $lastName";
               // exit;
                
                $stmt = $dbMain ->prepare("SELECT email FROM employee_info WHERE emp_fname LIKE '%$firstName%' AND emp_lname LIKE '%$lastName%' AND emp_mname LIKE '%$mName%'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($email);
                 $stmt->fetch();
                 $stmt->close();
             }
          //     echo "fu $this->taSalt";
       // exit; 
             $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name != ''");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($business_name, $business_nick);
             $stmt->fetch();
             $stmt->close();
             
             $date = date('F j Y h:i A',strtotime($classDateTime));
             
             $stmt = $dbMain ->prepare("SELECT contract_key, first_name, last_name, primary_phone, email FROM member_info WHERE member_id = '$this->memberId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($this->contractKey, $this->firstName, $this->lastName, $this->phone, $this->email);
             $stmt->fetch();
             $stmt->close();
             //echo "$contractKey, $firstName, $lastName, $phone, $email";
           // exit;
             $message = "$this->firstName $this->lastName has booked and appointment with you on $date. Here is their contact information if you wish to get in touch with them beforehand Phone: $this->phone Email: $this->email";
             
             $headers  = "From: $business_name@$business_nick.com\r\n";
             $headers .= "Content-type: text/html\r\n";  
             $message = wordwrap($message, 70, "\r\n");
             mail($email, 'Training Session Booked', $message, $headers);   
           //      echo "fubar";
// exit;
            $ptKey = "";
            if($this->smMemberId != "") {
              $memberId = $this->smMemberId;
              }else{
              $memberId = $this->memberId;
              }
              $reminderSent = 'N';
              if ($this->taSalt != 'T'){
                $sql = "INSERT INTO pt_sessions_performed VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('iiisis', $ptKey, $instructor_id, $memberId, $classDateTime, $this->serviceKey, $reminderSent);
                $stmt->execute();
                $stmt->close(); 
              }else{
                $sql = "INSERT INTO pt_training_assesments_performed VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('iiisis', $ptKey, $instructor_id, $memberId, $classDateTime, $this->serviceKey, $reminderSent);
                $stmt->execute();
                $stmt->close(); 
              }
            
 }else{
    $timeChecker24 = 0;
 }






$bookingId = null;
$typeId = $this->typeId;
$scheduleId = $this->scheduleId;
$bundleId = $this->bundleId;
$locationId = $this->locationId;
$clubId = $this->clubId;

if($this->smMemberId != "") {
  $memberId = $this->smMemberId;
  }else{
  $memberId = $this->memberId;
  }

$serviceKey = $this->serviceKey;


$dbMain = $this->dbconnect();
$sql = "INSERT INTO class_bookings VALUES (?, ?, ?, ?, ?,?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiiiiiis', $bookingId, $typeId, $scheduleId, $bundleId, $locationId, $clubId, $memberId, $serviceKey, $classDateTime);
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }else{
    $this->classStatus = 1;
    //echo "$this->classStatus";
    //exit;
   }
    //echo "a $this->bookingStatus b $booking_count c $this->classStatus";
    //  exit;
      
$booking = $stmt->insert_id; 
$stmt->close(); 

$this->loadBookingCount();


/*
CREATE TABLE class_bookings (
//booking_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//type_id INT(20) NOT NULL,
//schedule_id INT(20) NOT NULL,
//bundle_id INT(20) NOT NULL,
//location_id INT(20) NOT NULL,
//club_id INT(20) NOT NULL,
//member_id INT(20) NOT NULL,
service_key INT(20) NOT NULL,
class_date_time DATETIME NOT NULL
);
*/

}
//-------------------------------------------------------------------------------------
function updateMemberClassCount() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_class_count SET class_count= ? WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $memberClassCount);

$memberClassCount = $this->memberClassCount;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close();
}
//-------------------------------------------------------------------------------------
function bookMemberClass() {

 $dbMain = $this->dbconnect();
 
  
 if($this->serviceTerm == 'C' AND $this->taSalt != 'T') {
      $stmt = $dbMain ->prepare("SELECT class_count FROM member_class_count WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($classCount);
      $stmt->fetch();
      $stmt->close();
      
           if($classCount != 0) {
              $this->memberClassCount = $classCount - $this->classBit;
              $this->updateMemberClassCount();
              $this->insertClassBook();              
             }else{
             $this->classStatus = 3;
             }
             
    }else{
       
    $this->insertClassBook();
    }
    

/*
DROP TABLE IF EXISTS member_class_count;
CREATE TABLE member_class_count (
contract_key INT(20) NOT NULL, 
group_type ENUM("S","F","B","O") NOT NULL, 
service_key INT(10) NOT NULL,
class_count INT(10) NOT NULL
);
*/

}
//-------------------------------------------------------------------------------------
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND  service_id = '$this->serviceID'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
$stmt->close();
 
$status = $account_status;
 
 
$stmt = $dbMain ->prepare("SELECT  MAX(end_date) FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_key='$this->serviceKey' AND service_term != 'C' AND service_id = '$this->serviceID'");
$stmt->execute();      
$stmt->store_result();  
$stmt->bind_result($endDate);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close(); 

$endDate = trim($endDate);
 
 if($rowCount > 0 AND $endDate != "") {
    $todaysDate = time(); 
    $endDate = strtotime($endDate);

          if($endDate < $todaysDate) {
            $status = 'EX';
            }
    }
    
    
 $this->accountStatus = $status;
 
 
 }
//-------------------------------------------------------------------------------------
function loadBundleArray() {
//echo "$this->bundleId $this->typeId";
//exit;
 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT service_key FROM bundle_lists WHERE bundle_id = '$this->bundleId' AND type_id='$this->typeId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($serviceKey);

      while ($stmt->fetch()) {
                $bundleArray .= "$serviceKey,";
                }
//echo "$bundleArray";
//exit;
        $bundleArray = explode(",", $bundleArray);
        $this->bundleArray = $bundleArray;

 $stmt->close();

}
//-------------------------------------------------------------------------------------
function loadMemberClassStatus() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT contract_key, first_name, last_name, primary_phone, email FROM member_info WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($contractKey, $firstName, $lastName, $phone, $email);
 $stmt->fetch();
 $stmt->close();
 
 $this->contractKey = $contractKey;
 $this->firstName = $firstName;
 $this->lastName = $lastName;
 $this->phone = $phone;
 $this->email = $email;
 
 
 //look to see if they have paid full service that are not related to classes
 $stmt = $dbMain ->prepare("SELECT DISTINCT group_type, group_number, service_key, service_quantity, service_term, service_id FROM paid_full_services WHERE contract_key = '$this->contractKey' AND service_term != 'C'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->groupType, $this->groupNumber, $this->serviceKey, $this->duration, $this->serviceTerm, $this->serviceID);
 $pifRowCount = $stmt->num_rows;
 
  while ($stmt->fetch()) {
         $this->groupType = trim($this->groupType);
         //   echo "$pifRowCount $this->groupType, $this->groupNumber, $this->serviceKey, $this->duration, $this->serviceTerm, $this->serviceID";           
         // exit; 
         if($pifRowCount > 0 AND $this->groupType != "") {
         
                    
              $this->checkAccountStatus();  
              
                         if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA") && ($this->accountStatus != "EX")) {
                         
                                 if(in_array($this->serviceKey, $this->bundleArray)) {
                                     
                                         switch ($this->groupType) {
                                                case "S":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }                                                       
                                                break;
                                                case "F":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;
                                                case "B":
                                                $this->checkBookingStatus();                                              
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;
                                                case "O":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;                                                
                                                }
                                                                      
                                    }
                                   
                            }
    
             }
  }    
  
 $stmt->close();
 
 //check monthly services if there are no pif services booked
if($this->bookingStatus == null)  {
 
    $stmt = $dbMain ->prepare("SELECT DISTINCT group_type, group_number, service_key, number_months, service_id FROM monthly_services WHERE contract_key ='$this->contractKey'  ORDER BY signup_date DESC");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->groupType,  $this->groupNumber, $this->serviceKey, $this->duration, $this->serviceID);
    $monthlyRowCount = $stmt->num_rows;
    while ($stmt->fetch()) {
         $this->groupType = trim($this->groupType);
 //$this->email = "$monthlyRowCount $this->groupType";
          if($monthlyRowCount > 0 AND $this->groupType != "") {
     
              
 
                       $this->serviceTerm = 'M'; 
 
                       $this->checkAccountStatus();              
                            if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                               // $this->email = $this->accountStatus;
                                 if(in_array($this->serviceKey, $this->bundleArray)) {
                                     
                                         switch ($this->groupType) {
                                                case "S":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }                                                       
                                                break;
                                                case "F":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;
                                                case "B":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;
                                                case "O":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;                                                
                                                }
                                                                      
                                    }  // in array                                                              
                                
                                 } // account status
  
                       } // while count
         
       }  // if row count
 $stmt->close();   
  
  
  } //if booking status
  
//finally check if classes are purchased  if the booking status is still null

if($this->bookingStatus == null)  {  
 
 $stmt = $dbMain ->prepare("SELECT group_type, group_number, service_key, service_quantity, service_term, service_id FROM paid_full_services WHERE contract_key = '$this->contractKey' AND service_term = 'C'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->groupType, $this->groupNumber, $this->serviceKey, $this->duration, $this->serviceTerm, $this->serviceID);
 $classRowCount = $stmt->num_rows;
 
 while ($stmt->fetch()) {
    
     $this->groupType = trim($this->groupType);
     
     if($classRowCount > 0 AND $this->groupType != "") {
     
    
              $this->checkAccountStatus();              
                         if(($this->accountStatus != "HO")  &&  ($this->accountStatus != "CA")) {
                                                  
                                 if(in_array($this->serviceKey, $this->bundleArray)) {
   
                                         switch ($this->groupType) {
                                                case "S":
                                                $this->checkBookingStatus();  
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }                                                       
                                                break;
                                                case "F":
                                                $this->checkBookingStatus();                                                
                                                    if($this->bookingStatus != 1) {
                                                       $this->bookMemberClass();
                                                       }
                                                break;
                                                case "B":                                             
                                                $this->checkBookingQuota();                                                
                                                     if($this->bookingQuota < $this->duration) {
                                                           $this->checkBookingStatus();                                                                                                     
                                                               if($this->bookingStatus != 1) {
                                                                  $this->bookMemberClass();
                                                                  }                                                
                                                         }
                                                break;
                                                case "O":
                                                $this->checkBookingQuota();                                                
                                                     if($this->bookingQuota < $this->duration) {
                                                           $this->checkBookingStatus();                                                                                                     
                                                               if($this->bookingStatus != 1) {
                                                                  $this->bookMemberClass();
                                                                  }                                                
                                                         }
                                                break;                                                
                                                }
                                                                      
                                    }
                                   
                            } // account status
    
             } // while count
             
    } // if row count   
    
$stmt->close();    
}//if booking status

//if booking status is null as to contract based services we check to see if they have session status
if($this->bookingStatus == null)  {  
     if(($this->classStatus == null) || ($this->classStatus == 3)) {
          
         $this->smMemberId = $this->memberId;
         $this->loadSchedulerMember();
        
        }   
   }

}
//-------------------------------------------------------------------------------------
function loadTrainingAssesmentClassStatus() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT contract_key, first_name, last_name, primary_phone, email FROM member_info WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($contractKey, $firstName, $lastName, $phone, $email);
 $stmt->fetch();
 $stmt->close();
 
 $this->contractKey = $contractKey;
 $this->firstName = $firstName;
 $this->lastName = $lastName;
 $this->phone = $phone;
 $this->email = $email;
 
 $stmt = $dbMain ->prepare("SELECT training_assesments_given, paid_training_assesments, ta_pay_amount FROM pt_pay_options WHERE pt_key = '1'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($training_assesments_given, $paid_training_assesments, $ta_pay_amount);
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM pt_training_assesments_performed WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
 //echo "$this->memberId given $training_assesments_given $count";
 //exit;
  
 if ($count < $training_assesments_given){
    //look to see if they have paid full service that are not related to classes
     $stmt = $dbMain ->prepare("SELECT  group_type, group_number FROM member_groups WHERE contract_key = '$this->contractKey'");
     $stmt->execute();      
     $stmt->store_result();      
     $stmt->bind_result($group_type, $group_number);
     $stmt->fetch();
     $stmt->close();
        
     $this->groupType = $group_type;
     $this->groupNumber = $group_number;
     $this->serviceKey = $this->bundleArray[0];
     $this->duration = 1;
     $this->serviceTerm = 'C';
     
     $this->checkBookingStatus(); 
                                                    
     if($this->bookingStatus != 1) {
        
     $this->bookMemberClass();
     
     }                                           
 }else{
    $this->classStatus = 12;
 }
 
 
                                                                                                                      
                          
  
  


}
//-------------------------------------------------------------------------------------
function checkMember() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(contract_key) AS count FROM member_info WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
// echo "$count";
 //exit;
    if($count > 0) {
      $this->memType = 'M';   
     }else{
        $this->memType = "";   
     }

}
//--------------------------------------------------------------------------------------
function checkNonMember() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(sm_member_id ) AS count FROM schedular_member_info WHERE sm_member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
   if($count > 0) {
      $this->memType = 'N';   
     }else{
        $this->memType = "";   
     }

}
//--------------------------------------------------------------------------------------
function checkGuestPass() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(pass_id) AS count FROM guest_register WHERE bar_code = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
   if($count > 0) {
      $this->memType = 'G';       
     }else{
        $this->memType = "";   
     }

}
//--------------------------------------------------------------------------------------
function checkGuestPassQuota() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT service_quantity FROM service_cost WHERE service_key ='$this->serviceKey' AND service_term = 'C'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($serviceQuantity);
 $stmt->fetch();
 $stmt->close();

$this->duration = $serviceQuantity;
$this->checkBookingQuota();


}
//--------------------------------------------------------------------------------------
function bookGuestPassClass() {

$this->insertClassBook();

}
//---------------------------------------------------------------------------------------
function loadGuestPassStatus() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT pass_id, end_date, guest_name, guest_phone, guest_email FROM guest_register WHERE bar_code = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($passId, $endDate, $guestName, $guestPhone, $guestEmail);
 $stmt->fetch();
 $stmt->close();

$endDateSecs = strtotime($endDate);
$todaysDateSecs = time();

$classDateSecs = strtotime($this->classDate);

//split the name since it occupies one field
$guestNameArray = explode(" ", $guestName);
$arrayCount = count($guestNameArray);

if($arrayCount == 1) {
  $this->firstName = $guestNameArray[0];
  }
if($arrayCount == 2) {
  $this->firstName = $guestNameArray[0];
  $this->lastName = $guestNameArray[1];
  }
if($arrayCount == 3) {
  $this->firstName = $guestNameArray[0];
  $this->lastName = $guestNameArray[2];
  }

 $this->phone = $guestPhone;
 $this->email = $guestEmail;
 
 if($todaysDateSecs > $endDateSecs) { 
 
   $this->classStatus = 3;
   
  }elseif($classDateSecs > $endDateSecs) {
   
   $this->classStatus = 10;
     
   }else{
 
    $stmt = $dbMain ->prepare("SELECT service_key  FROM guest_pass_services WHERE pass_id = '$passId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($serviceKey);
   
             while ($stmt->fetch()) {
                        
                       $this->serviceKey = $serviceKey;
                       
                               if(in_array($this->serviceKey, $this->bundleArray)) {
                               
                                    $this->inArrayBit = 1;
                                  
                                        $this->checkGuestPassQuota();                                                
                                            if($this->bookingQuota < $this->duration) {                                  
                                                $this->checkBookingStatus();                                                
                                                  if($this->bookingStatus != 1) {
                                                     $this->bookGuestPassClass();
                                                    } 
                                              }
                                  }

                      }

       if(($this->inArrayBit != 1) || ($this->classStatus != 1)) {
          $this->classStatus = 5;
          }

    $stmt->close();
   
   }


}
//--------------------------------------------------------------------------------------
function checkStatus() {

 //first check the guest pass
  $this->checkGuestPass();

   if($this->memType == null) {
       $this->checkMember();
     }

   if($this->memType == null) {     
     $this->checkNonMember();
    }

}
//-------------------------------------------------------------------------------------
function checkClassStatus() {

    if ($this->taSalt != 'T'){
        switch ($this->memType) {
        case "G":
        $this->loadGuestPassStatus();
        break;
        case "M":
        $this->loadMemberClassStatus();
        break;
        case "N":
        $this->smMemberId = $this->memberId;        
        $this->loadSchedulerMember();
        break;
        }
    }else{
       
       $this->loadTrainingAssesmentClassStatus(); 
    }
    


}
//-------------------------------------------------------------------------------------
function loadServiceKey() {

$classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";

//checks to see if member id or smMemberId
if($this->smMemberId != null) {
    $memberId = $this->smMemberId;
   }else{
    $memberId = $this->memberId;  
   }


      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT service_key FROM class_bookings WHERE schedule_id = '$this->scheduleId' AND class_date_time='$classDateTime' AND club_id='$this->clubId' AND member_id='$memberId' ");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($serviceKey);
      $stmt->fetch();
      $stmt->close();

$this->serviceKey = $serviceKey;


}
//-------------------------------------------------------------------------------------
function deleteClass() {

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT type_name FROM schedule_type WHERE type_id = '$this->typeId' AND type_name LIKE '%Train%' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_name);
 $rowCount= $stmt->num_rows;
 $stmt->fetch();
 $stmt->close();
 
 $classTime = date("H:i:s", strtotime($this->timeSlot));
$classDate = date("Y-m-d",strtotime($this->classDate));
$classDateTime ="$classDate $classTime";
 
 if ($rowCount >= 1){
             $stmt = $dbMain ->prepare("SELECT instructor_id FROM class_schedules WHERE schedule_id = '$this->scheduleId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($instructor_id);
             $stmt->fetch();
             $stmt->close();
    
            if($this->smMemberId != "") {
              $memberId = $this->smMemberId;
              }else{
              $memberId = $this->memberId;
              }
            $sql = "DELETE FROM pt_sessions_performed WHERE instructor_id = ? AND member_id = ? AND service_key = ? AND session_date = ?";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('iiis',  $instructor_id, $memberId, $this->serviceKey, $classDateTime);
            $stmt->execute();
            $stmt->close(); 
             $sql = "DELETE FROM pt_training_assesments_performed WHERE instructor_id = ? AND member_id = ? AND service_key = ? AND session_date = ?";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('iiis',  $instructor_id, $memberId, $this->serviceKey, $classDateTime);
            $stmt->execute();
            $stmt->close(); 
 }
$clubId = $this->clubId;
$memberId = $this->memberId;
$serviceKey = $this->serviceKey;



$sql = "DELETE FROM class_bookings WHERE club_id =? AND member_id =? AND service_key =? AND class_date_time =?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param("iiis", $clubId, $memberId, $serviceKey, $classDateTime);
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }else{
    $this->classStatus = 9;
   }
//echo "$this->classStatus";

$stmt->close();

/*
CREATE TABLE class_bookings (
//booking_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//type_id INT(20) NOT NULL,
//schedule_id INT(20) NOT NULL,
//bundle_id INT(20) NOT NULL,
//location_id INT(20) NOT NULL,
//club_id INT(20) NOT NULL,
//member_id INT(20) NOT NULL,
service_key INT(20) NOT NULL,
class_date_time DATETIME NOT NULL
);
*/
}
//-------------------------------------------------------------------------------------
function cancelMemberClass() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT contract_key FROM member_info WHERE member_id = '$this->memberId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($contractKey);
 $stmt->fetch();
 $stmt->close();

 $this->contractKey = $contractKey;

 
 $stmt = $dbMain ->prepare("SELECT class_count, group_type FROM member_class_count WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($memberClassCount, $groupType);
 $rowCountOne= $stmt->num_rows;
 $stmt->fetch();
 $stmt->close();
 
 if($rowCountOne > 0) {
    $this->memberClassCount = $memberClassCount;
    $this->groupType = $groupType;
   }else{
    $this->memberClassCount = null;
    $this->groupType = null;
   }
 
 
      $stmt = $dbMain ->prepare("SELECT class_count, sm_contract_key FROM schedular_member_class_count WHERE sm_member_id = '$this->memberId' AND service_key='$this->serviceKey' ");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($smMemberClassCount, $smContractKey);
      $rowCountTwo= $stmt->num_rows;
      $stmt->fetch();
      $stmt->close();

      if($rowCountTwo > 0) {
         $this->smMemberClassCount = $smMemberClassCount;
         $this->smContractKey = $smContractKey;
         }else{
         $this->smMemberClassCount = null;
         $this->smContractKey = null;
         }



 //if checks the member and non member class count then adds to the tally
        if(($this->memberClassCount == 0) && ($this->smMemberClassCount == null)) {
            $this->memberClassCount = $this->memberClassCount + 1;
            $this->updateMemberClassCount();
            
            }elseif(($this->memberClassCount > 0) && ($this->groupType != 'B') && ($this->groupType != 'O')) {
            $this->memberClassCount = $this->memberClassCount + 1;
            $this->updateMemberClassCount();    
            
            }elseif(($this->memberClassCount == 0) && ($this->smMemberClassCount > 0)) {
             $this->smMemberClassCount = $this->smMemberClassCount + 1;
             $this->updateSmMemberClassCount();
             
            }elseif(($this->memberClassCount == 0) && ($this->smMemberClassCount == 0)) {
             $this->smMemberClassCount = $this->smMemberClassCount + 1;
             $this->updateSmMemberClassCount();
            }   
   
   
              $this->deleteClass();
}
//-------------------------------------------------------------------------------------
function cancelNonMemberClass() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT class_count, sm_contract_key FROM schedular_member_class_count WHERE sm_member_id = '$this->memberId' AND service_key='$this->serviceKey' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($smMemberClassCount, $smContractKey);
 $rowCount= $stmt->num_rows;
 $stmt->fetch();
 $stmt->close();

 $this->smMemberClassCount = $smMemberClassCount;
 $this->smMemberClassCount = $this->smMemberClassCount + 1;
 $this->smContractKey = $smContractKey;
 $this->updateSmMemberClassCount();
 $this->deleteClass();

}
//-------------------------------------------------------------------------------------
function cancelGuestPassClass() {

$this->deleteClass();

}
//-------------------------------------------------------------------------------------
function cancelSchedulerClass() {
    
 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_name FROM schedule_type WHERE type_id = '$this->typeId' AND type_name LIKE '%Train%' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_name);
 $rowCount= $stmt->num_rows;
 $stmt->fetch();
 $stmt->close();
 
 if ($rowCount >= 1){
    $timeChecker24 = 1;
 }else{
    $timeChecker24 = 0;
 }
 $classDateSecs = strtotime($this->classDate);
 $today = date('Y-m-d H:i:s');
 $todayeSecs  = strtotime($today);
 $diff = $classDateSecs - $todayeSecs;
 $secsIn24Hrs = 24*60*60;
 
 
 if ($timeChecker24 == 1 AND $diff < $secsIn24Hrs){
    $this->classStatus = 11;
 }else{
     $this->checkBookingStatus();
      
                     
              if($this->bookingStatus == null) {
                 $this->classStatus = 8;
                 }else{
                
                  $this->loadServiceKey();
                     
                      switch ($this->memType) {
                        case "G":
                        $this->cancelGuestPassClass();
                        break;
                        case "M":
                        $this->cancelMemberClass();
                        break;
                        case "N":
                        $this->cancelNonMemberClass();
                        break;
                      }
                                
                }
 }
 
    

     


}
//-------------------------------------------------------------------------------------

function getMemType() {
      return($this->memType);
      }

function getClassStatus() {
      return($this->classStatus);
      }

function getBookingCount() {
      return($this->bookingCount);
      }

function getBookingStatus() {
      return($this->bookingStatus);
      }

function getGroupType() {
      return($this->groupType);
      }

function getFirstName() {
      return($this->firstName);
      }

function getLastName() {
      return($this->lastName);
      }

function getPhone() {
      return($this->phone);
      }

function getEmail() {
      return($this->email);
      }
      
      
      

}
//=================================================

$ajax_switch = $_REQUEST['ajax_switch'];
$member_id = $_REQUEST['member_id'];
$schedule_id = $_REQUEST['schedule_id'];
$bundle_id = $_REQUEST['bundle_id'];
$class_date = $_REQUEST['class_date'];
$type_id = $_REQUEST['type_id'];
$location = $_REQUEST['location'];
$time_slot = $_REQUEST['time_slot'];
$ta_salt = $_REQUEST['ta_salt'];
                
             
if($ajax_switch == 1) {
//echo "a $member_id a $schedule_id a $bundle_id a $class_date a $time_slot a $type_id a $location a $ta_salt";
//exit;
$book = new bookClass();
$book-> setMemberId($member_id);
$book-> setScheduleId($schedule_id);
$book-> setBundleId($bundle_id);
$book-> setClassDate($class_date);
$book-> setTimeSlot($time_slot);
$book-> setTypeId($type_id);
$book-> setLocationId($location);
$book-> setClubId($location);
$book-> setTaSalt($ta_salt);
$book-> checkStatus();
$book-> loadBookingCount();
$mem_type = $book-> getMemType();
//echo "$mem_type";
//exit;
//if memtype does not exist then we return to prompt user for a payment form
if($mem_type == null) {
   $mem_type = 'N';
   $class_status = 2;
   $booking_count = $book-> getBookingCount();
   $group_type = $book-> getGroupType();
  }else{
  $book-> loadBundleArray();
  $book-> checkClassStatus();
  $class_status = $book-> getClassStatus();
  $booking_count = $book-> getBookingCount();
  $group_type = $book-> getGroupType();
  $first_name = $book-> getFirstName();
  $last_name = $book-> getLastName();
  $phone = $book-> getPhone();
  $email = $book-> getEmail();    
  }
  
   echo"$class_status|$booking_count|$mem_type|$booking_status|$group_type|$first_name|$last_name|$phone|$email";
   exit;  
  

/*NOTES on class_status

  1. class_status of 1 means that there was a succesfull insert
  2. class_status of 2 means that there are no records associated and a payment form on the front end will be displayed for non member purchases
  3. class_status of 3 means that the member or user has exausted their classes and need to purchase more
  4. class_status of 4 means the class has already been booked
  5. class_status of 5 means the person is a member but there are no services asscociated with the account
  6. class_status of 6 means the person has a group membership and their quota has been exeeded and the need to purchase classes
  7. class_status of 7 means that there are no records associated with this id for cancelation
  8. class_status of 8 means that there are no records associated with this id for the time slot cancelation
  9  class_status of 9 means class was sucessfully deleted

echo"Club ID: $club_id \n Member ID: $member_id \n Schedule ID: $schedule_id \n Bundle ID: $bundle_id \n Class Date: $class_date \n Type ID: $type_id \n Location ID: $location ";
exit;
*/

 }
///================================================================= 
 if($ajax_switch == 2) {

//$club_id = $_SESSION['location_id'];

$cancel = new bookClass();
$cancel-> setMemberId($member_id);
$cancel-> setScheduleId($schedule_id);
$cancel-> setBundleId($bundle_id);
$cancel-> setClassDate($class_date);
$cancel-> setTimeSlot($time_slot);
$cancel-> setTypeId($type_id);
$cancel-> setLocationId($location);
$cancel-> setClubId($location);
$cancel-> checkStatus();
$mem_type = $cancel-> getMemType();

if($mem_type == null) {
   $mem_type = 'N';
   $class_status = 7;
  }else{
   $cancel-> cancelSchedulerClass();
   $class_status = $cancel-> getClassStatus();
  }

   echo"$class_status|$booking_count|$mem_type|$booking_status|$group_type|$first_name|$last_name|$phone|$email";
   exit;  

//echo"Club ID: $club_id \n Member ID: $member_id \n Schedule ID: $schedule_id \n Bundle ID: $bundle_id \n Class Date: $class_date \n Type ID: $type_id \n Location ID: $location \n Time Slot: $time_slot";
//exit;



}

?>



