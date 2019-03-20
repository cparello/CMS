<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";
require"../cybersource/parseGatewayFields.php";

//==============================================end timeout
class  renewalSql {

private  $groupType = null;
private  $groupInfo =null;
private  $addressInfo = null;
private  $productList = null;
private  $contractKey = null;
private  $serviceKey = null;
private  $renewalFee = null;
private  $newMemberFee = 0;
private  $serviceTotal =null;
private  $grandTotal = null;
private  $todaysPayment = null;
private  $balanceDue = null;
private  $balanceDueDate = null;

//address info
private $clientStreet;
private $clientCity;
private $clientState;
private $clientZip;
private $clientHomePhone;
private $clientCellPhone;
private $clientEmail;

//for contract printout
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $groupTypeContract = null;
private $groupNameContract = null;
private $contractHtml = null;

//for cc
private $cardType = null;
private $cardName = null;  //this is an array that needs to be parsed
private $cardNumber = null;
private $cardCvv = null;
private $cardExpDate = null;  //set to auth net satandards, needs to be parsed for mysql befor insert
//these are not used through the sales console but could be used later. we set to "" instead of null for SQL insert
private $cardStreet = "";
private $cardCity = "";
private $cardState = "";
private $cardZip = "";

//for banking
private $bankName = null;
private $accountType = null;
private $accountName = null;
private $accountNumber = null;
private $abaNumber = null;

//initial payment types
private $cashPayment = null;
private $creditPayment = null;
private $achPayment = null;
private $checkPayment = null;
private $checkNumber = 0;

//override status
private $overidePin = null;

//notes on the contract
private $noteTopic = null;
private $noteMessage = null;
private $noteUser = null;  //this is the user id of the logged in user
private $noteList;  //since there could be lots of notes this will hold a list of these notes 
private $noteCategory = 'RS';
private $notePriority = null;
private $targetApp = null;

//comission credit
private $commissionCredit = null;   //is email address needs to translate to user id
private $comissionId = null;
private $typeKey = null;
private $idCard = null;

//this is for the club location to be set
private $clubLocation;
private $locationId;

//contract terms and miscellaneous
private $termsConditions;
private $contractQuit;
private $gracePeriod;
private $accountStatus = null;
private $renewal = null;
private $upgrade = null;
private $internet = null;
private $contractType = 'R';
private $transfer = null;
private $productRow;
private $serviceType = 'P';
private $termType = 'T';
private $historyKey = null;
private $contractId = null;
private $serviceId = null;
private $statusId = null;
private $paymentDescription = 'Service Renewal';
private $transKey = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $ccAuthRequestId = null;

function setGroupType($groupType)  {
              $this->groupType = $groupType;
              }
function setGroupInfo($groupInfo) {
             $this->groupInfo = $groupInfo;
             }            
function setAddressInfo($addressInfo) {
             $this->addressInfo = $addressInfo;
             }   
function setFirstName($firstName) {
             $this->firstName = $firstName;
             } 
function setMiddleName($middleName) {
             $this->middleName = $middleName;
             }                          
function setLastName($lastName) {
             $this->LastName = $lastName;
             }               
             
             
function setProductList($productList) {
             $this->productList = $productList;
             }        
function setContractKey($contractKey) {
             $this->contractKey = $contractKey;
             }
function setRenewalFee($renewalFee) {
             $this->renewalFee = $renewalFee;
             }
function setServiceTotal($serviceTotal) {
             $this->serviceTotal = $serviceTotal;
             }
function  setGrandTotal($grandTotal) {
             $this->grandTotal = $grandTotal;
            }
function setTodaysPayment($todaysPayment) {
            $this->todaysPayment = $todaysPayment;
            }           
function setBalanceDue($balanceDue) {
            $this->balanceDue = $balanceDue;
            }
function setBalanceDueDate($balanceDueDate) {
            $this->balanceDueDate = $balanceDueDate;
           }

function setTermsConditions($termsConditions) {
    $this->termsConditions = $termsConditions;
    }
function setContractQuit($contractQuit) {
    $this->contractQuit = $contractQuit; 
    }
function setLiabiltyTerms($liabilityTerms) {    
    $this->liabilityTerms = $liabilityTerms;
    }
function setGracePeriod($gracePeriod) {    
   $this->gracePeriod = $gracePeriod;
   }


//for credit cards
function setCardType($cardType) {
       $this->cardType = $cardType;
       }
function setCardName($cardName) {
       $this->cardName = $cardName;
       }
function setCardNumber($cardNumber) {
       $this->cardNumber = $cardNumber;
       }
function setCardCvv($cardCvv) {
       $this->cardCvv = $cardCvv;
       }
function setCardExpDate($cardExpDate) {
       $this->cardExpDate = $cardExpDate;
       }
function setCcRequestId($ccAuthRequestId) {
       $this->ccAuthRequestId = $ccAuthRequestId;
      }

//for banking info
function setBankName($bankName) {
      $this->bankName = $bankName;
      }
function setAccountType($accountType) {
     $this->accountType = $accountType;
     }
function setAccountName($accountName) {
     $this->accountName = $accountName;
     }
function setAccountNumber($accountNumber) {
    $this->accountNumber = $accountNumber;
    }
function setAbaNumber($abaNumber) {
    $this->abaNumber = $abaNumber;
    }


//for payments on initial contract
function setCashPayment($cashPayment) {
       $this->cashPayment = $cashPayment;
       }
function setCreditPayment($creditPayment) {
       $this->creditPayment = $creditPayment;
       }
function setAchPayment($achPayment) {
       $this->achPayment = $achPayment;
       }
function setCheckPayment($checkPayment) {
       $this->checkPayment = $checkPayment;
       }
function setCheckNumber($checkNumber) {
       $this->checkNumber = $checkNumber;
       }

//overide pin set to either Yif entered or N if not
function setOveridePin($overidePin) {
       $this->overidePin = $overidePin;
       }

//this is for notes on the contract
function setNoteTopic($noteTopic) {
        $this->noteTopic = $noteTopic;
        }
function setNoteMessage($noteMessage) {
       $this->noteMessage = $noteMessage;
       }       
function setNoteUser($noteUser) {
       $this->noteUser = $noteUser;
       }
function setNotePriority($notePriority) {
       $this->notePriority = $notePriority;
       }
function setTargetApp($targetApp) {
       $this->targetApp = $targetApp;
       }       
       
function setAccountStatus($accountStatus) {
   $this->accountStatus = $accountStatus;
   }
function setRenewal($renewal) {
   $this->renewal = $renewal;
   }
function setUpgrade($upgrade) {
   $this->upgrade = $upgrade;
   }
function setInternet($internet) {
   $this->internet = $internet;
   }

//for contracts
function setGroupTypeContract($groupTypeContract) {
   $this->groupTypeContract = $groupTypeContract;
   }
function setGroupTypeName($groupTypeName) {
   $this->groupTypeName = $groupTypeName;
   }
function setContractHtml($contractHtml) {
   $this->contractHtml =$contractHtml;
   }   
function  setPifOutBool($pif_out_bool){
   $this->pifOutBool = $pif_out_bool;
   }   
function setPifOutTime($pif_out_time){
   $this->pifOutTime =$pif_out_time;
   }   
function setPifOutMoneyOwed($pif_out_money_owed){
   $this->pifOutMoneyOwed =$pif_out_money_owed;
   }   
function  setYearQuantity($year_quantity){
   $this->newServiceQuantity = $year_quantity;
   }      
function  setOldKey($old_key){
    $this->oldKey = $old_key;
}
function  setChangedServiceBool($changed_service_bool){
    $this->changedServiceBool = $changed_service_bool;
}
function setSig($sig) {
   $this->signature = $sig;
   } 
   
function  setPastDueAmount($past_due_amount) {
   $this->pastDueAmount = $past_due_amount;
   } 
//---------------------------------------------------------------------------------------
//methods go here
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------------------
function paymentHistory() {       
    $this->dueDate = $this->balanceDueDate;
   require('../helper_apps/paymentHistory.php');  


}
//--------------------------------------------------------------------------------------
function deleteRenewal() {

		unset($_SESSION['renewalSql']);
		
	    $delete_key = 1;
		return $delete_key;

}
//--------------------------------------------------------------------------------------
//these methods are for parsing prior to SQL inserts
//-----------------------------------------------------------------------------------------------------
function parseStartEndDates() {

$startDateArray = explode(" ", $this->startDate);
$dateArray = $startDateArray[0];
$dateArrayOne = explode("-", $dateArray);

$year = $dateArrayOne[0];
$month = $dateArrayOne[1];
$day = $dateArrayOne[2];

//reset start date to 0 hours min secs
$this->startDate = date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $month, $day, $year));


  switch ($this->serviceTerm) {
        case "C":
        $this->endDate = '0000-00-00 00:00:00';
        break;
        case "D":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $day+$this->newServiceQuantity, $year));
        break;
        case "W":
        $days = $this->newServiceQuantity * 7;
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $day+$days, $year));
        break;
        case "M":
        $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month+$this->newServiceQuantity, $day, $year));
        break;
        case "Y":
        if ($this->newServiceQuantity == '.25'){
            $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month+3, $day, $year));
        }elseif($this->newServiceQuantity == '.50'){ 
            $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month+6, $day, $year));
        }else{
          $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month, $day, $year+$this->newServiceQuantity));  
        }
        
        break;  
      }
//echo"fubar y $year sq $this->newServiceQuantity $this->endDate $this->startDate";
//exit;
}

//------------------------------------------------------------------------------------------------------
function loadEnhanceFee() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT enhance_fee FROM  member_enhance_pif WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($enhance_fee);   
$stmt->fetch();   

return "$enhance_fee";

 $stmt->close();
}

//------------------------------------------------------------------------------------------------------
function parseComissionId() {

$name = $_SESSION['user_name'];
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_id FROM admin_passwords WHERE user_name ='$name'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($user_id);
   $stmt->fetch();
   
   
   $this->comissionId = $user_id;
    
   
   if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }   
   $stmt->close();  

         $result2 = $dbMain ->prepare("SELECT type_key, id_card  FROM basic_compensation WHERE  user_id = '$user_id'"); 
         $result2->execute();      
         $result2->store_result(); 
         $result2->bind_result($type_key, $id_card);      
                                  while ($result2->fetch()) {   
                                                 if($type_key != null)  {                                                 
                                                          $result3 = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$type_key'");
                                                          $result3->execute();      
                                                          $result3->store_result(); 
                                                          $result3->bind_result($employee_type, $club_id);    
                                                          $result3 ->fetch();
                                                         
                                                                   if(preg_match("/sales/i", $employee_type)) {
                                                                   
                                                                   //    if($club_id == $this->locationId) {
                                                                           $this->typeKey = $type_key;
                                                                           $this->idCard = $id_card;                                                                           
                                                                   //      }
                                                                         
                                                                     }        
                                                     }

                                             }
}
//-----------------------------------------------------------------------------------------------------
function loadClubLocation()  {
$dbMain = $this->dbconnect();
$this->locationId = $_SESSION['location_id'];

if ($this->locationId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }else{
        $clubId = $this->locationId;
    }
    

   $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id ='$clubId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_name);
   $stmt->fetch();
  
$this->clubLocation = $club_name;
}
//-------------------------------------------------------------------------------------------
function loadGracePeriod() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gracePeriod);   
$stmt->fetch();   

return "$gracePeriod";

 $stmt->close();
}
//-------------------------------------------------------------------------------------------
function loadContractTerms() {

  $dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT contract_terms, contract_quit, liability_terms FROM contract_defaults WHERE contract_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($termsConditions, $contractQuit, $liabilityTerms); 
   $stmt->fetch();

$this->contractQuit = $contractQuit; 
$this->termsConditions = $termsConditions;
$this->liabilityTerms = $liabilityTerms;
$this->gracePeriod = $this->loadGracePeriod();


if(!$stmt->execute())  {
    return($this->errorMessage);
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//----------------------------------------------------------------------------------------------------
function parseAccountHolderName() {

if($this->nameSwitch == null) {
  $this->accountFirst = "";
  $this->accountMiddle = "";
  $this->accountLast = "";
  
  }else{
  
       $account_name_array = preg_split('/[\s]+/', $this->nameSwitch);
       $array_count = count($account_name_array);
    
       switch ($array_count) {
         case 0:
               $this->accountFirst = "";
               $this->accountMiddle = "";
               $this->accountLast = $this->nameSwitch;
        break;
        case 1:
             $this->accountFirst = "";
             $this->accountMiddle = "";
             $this->accountLast = $this->nameSwitch;
        break;
        case 2:
             $this->accountFirst = $account_name_array[0];
             $this->accountMiddle = "";
             $this->accountLast = $account_name_array[1];
        break;
        case 3:
             $this->accountFirst = $account_name_array[0];
             $this->accountMiddle = $account_name_array[1];
             $this->accountLast = $account_name_array[2];
        break;
        case 4:
            $this->accountFirst = $account_name_array[0];
            $this->accountMiddle = "";
            $this->accountLast = "$account_name_array[1] $account_name_array[2] $account_name_array[3]";
        break;
     }
   
 }

}
//-----------------------------------------------------------------------------------------------------
function formatCreditDate() {

if($this->cardExpDate == "") {
  $credit_date = "0000-00-00";
  }else{
  $year_front = '20';
  $card_array =  preg_split('/[\s]+/', $this->cardExpDate);
  $card_year = "$year_front$card_array[0]"; 
  $card_month = $card_array[1]; 
  
    switch ($card_month) {
         case "01":
        $card_day = "31";
        break;
        case "02":
        $card_day = "28";
        break;
        case "03":
        $card_day = "31";
        break;
        case "04":
        $card_day = "30";
        break;
        case "05":
        $card_day = "31";
        break;  
        case "06":
        $card_day = "30";
        break;
        case "07":
        $card_day = "31";
        break;
        case "08":
        $card_day = "31";
        break;    
        case "09":
        $card_day = "30";
        break;  
        case "10":
        $card_day = "31";
        break;  
        case "11":
        $card_day = "30";
        break;  
        case "12":
        $card_day = "31";
        break;        
     }
          
  $credit_date = "$card_year-$card_month-$card_day";
  }

return $credit_date; 

}
//-------------------------------------------------------------------------------------------
function parseAddressInfo() {

$contract_address_array =  explode("|", $this->addressInfo);

$this->clientStreet = $contract_address_array[0];
$this->clientCity = $contract_address_array[1];
$this->clientState = $contract_address_array[2];
$this->clientZip = $contract_address_array[3];
$this->clientHomePhone = $contract_address_array[4];
$this->clientCellPhone = $contract_address_array[5];
$this->clientEmail = $contract_address_array[6];

}
//===================================================================
function saveAccountStatus() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissid', $statusId, $contractKey, $serviceKey , $accountStatus, $statusDate, $clubId, $servicePrice);

$statusId = $this->statusId;
$contractKey = $this->contractKey; 
$serviceKey = $this->serviceKey;
$accountStatus = $this->accountStatus;
$statusDate = $this->signupDate;
$clubId = $this->clubId;
$servicePrice = $this->groupRenewRate;


if(!$stmt->execute())  {
	printf("Error: ACCOUNT STATUS%s.\n", $stmt->error);
   }		

$stmt->close(); 

}

//===================================================================
function updateGroupInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE member_groups SET group_address= ?, group_phone= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $groupAddress, $groupPhone);

//parse the group type info
$group_info_array = explode("|", $this->groupInfo);
$groupAddress = $group_info_array[0];
$groupPhone = $group_info_array[1];

 if(!$stmt->execute())  {
	printf("Error: UPDATE GROUP %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//===================================================================
function updateBankingInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE banking_info SET bank_name= ?,  account_type= ?, account_fname= ?, account_mname= ?, account_lname= ?,  account_number= ?, routing_number= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssss',  $bankName, $accountType, $accountFirst, $accountMiddle, $accountLast, $accountNumber, $abaNumber); 


$bankName = $this->bankName; 
$accountType = $this->accountType;

//divide the name attribute of the account holder
$this->nameSwitch = $this->accountName;
$this->parseAccountHolderName();
 $accountFirst = $this->accountFirst;
 $accountMiddle = $this->accountMiddle;
 $accountLast = $this->accountLast;

$accountNumber = $this->accountNumber; 
$abaNumber = $this->abaNumber; 

if(!$stmt->execute())  {
	printf("Error: UOPDATE BANKING %s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//==================================================================
function updateCreditInfo() {

$dbMain = $this->dbconnect();
$sql = "UPDATE credit_info SET card_fname= ?,  card_mname= ?, card_lname= ?, card_street= ?, card_city= ?,  card_state= ?, card_zip= ?, card_type= ?, card_number= ?, card_cvv= ?, card_exp_date= ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssss', $cardFirst, $cardMiddle, $cardLast, $cardStreet, $cardCity, $cardState, $cardZip, $cardType, $cardNumber, $cardCvv, $expDate); 
	
//divide the name attribute of the account holder
$this->nameSwitch = $this->cardName;
$this->parseAccountHolderName();
 $cardFirst = $this->accountFirst;
 $cardMiddle = $this->accountMiddle;
 $cardLast = $this->accountLast;
 $cardStreet = $this->cardStreet;
 $cardCity = $this->cardCity;
 $cardState = $this->cardState;
 $cardZip = $this->cardZip;
 $cardType = $this->cardType;
 $cardNumber = $this->cardNumber;
 $cardCvv = $this->cardCvv;
 
$expDate = $this->formatCreditDate();

 if(!$stmt->execute())  {
	printf("Error: UPDATE CREDIT%s.\n", $stmt->error);
   }		

$stmt->close(); 

}
//---------------------------------------------------------------------------------------------
function saveSignature() {
$this->signature = str_replace(' ','+',$this->signature);
$dbMain = $this->dbconnect();
$date = date('Y-m-d');
$sql = "UPDATE contract_signatures  SET sig_path = ?  WHERE contract_key = '$this->contractKey'  AND date = '$date'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $this->signature);
$stmt->execute();        
$stmt->close();
}
//==================================================================
function saveContractInfo()  {

$this->saveSignature();

$dbMain = $this->dbconnect();
//first we get all of the pertinant data from the original contract last generated
$stmt = $dbMain ->prepare("SELECT  host_type, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, license_number, transfer  FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY signup_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($host_type, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $dob, $license_number, $trans);
 $stmt->fetch();
 
 $this->transfer = $trans;
 $this->hostType = $host_type;
 $this->clientFirst = $first_name;
 $this->clientMiddle = $middle_name;
 $this->clientLast = $last_name;
  
 //check to see if they have upgraded the address info. if not store the original values
if($this->addressInfo == 'NA')  {
    $this->clientStreet = $street;
    $this->clientCity = $city;
    $this->clientState = $state;
    $this->clientZip = $zip;
    $this->clientHomePhone = $primary_phone;
    $this->clientCellPhone = $cell_phone;
    $this->clientEmail = $email;
}
  
  $this->clientDob = $dob;
  $this->clientLicense = $license_number;
  
if(!$stmt->execute())  {
	printf("Error: SAVE CONTRACT INFO%s.\n", $stmt->error);
   }		
$stmt->close(); 

//-------------------------------------------------------------------------------------------------------------------------
//now we do an insert for the new contract
$sql = "INSERT INTO contract_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisssisssisssssssisssssis', $contractId, $userId, $contractKey, $contractType, $transfer, $signDate, $clubId, $contractLocation, $contractDate, $termsConditions, $contractQuit, $hostType, $clientFirst, $clientMiddle, $clientLast, $clientStreet, $clientCity, $clientState, $clientZip, $clientHomePhone, $clientCellPhone, $clientEmail, $clientDob, $clientLicense, $gracePeriod, $contractHtml);


$contractId = $this->contractId;
//loads the liabilty terms
$this->loadContractTerms();

//get the contract location
$this->loadClubLocation();
//set the signup date to use for service ids
$this->signupDate = date("Y-m-d H:m:s"); 

//convert the contract quit grace period into seconds
$contractQuitSeconds = $this->contractQuit * 86400;
$currentTimeSecs = time();
$this->contractQuit = $currentTimeSecs + $contractQuitSeconds;

$userId = $_SESSION['user_id'];
$contractKey = $this->contractKey;
$contractType = $this->contractType;
$transfer = $this->transfer;
$signDate = $this->signupDate; 
$clubId = $this->locationId;
$contractLocation = $this->clubLocation;
$contractDate = date("Y-m-d");  //this might be different from signup date make the same for now
$termsConditions = $this->termsConditions;
$contractQuit = $this->contractQuit;
$hostType = $this->hostType;
$clientFirst = $this->clientFirst;
$clientMiddle = $this->clientMiddle;
$clientLast = $this->clientLast;
$clientStreet = $this->clientStreet;
$clientCity = $this->clientCity;
$clientState = $this->clientState;
$clientZip = $this->clientZip;
$clientHomePhone = $this->clientHomePhone;
$clientCellPhone = $this->clientCellPhone;
$clientEmail = $this->clientEmail;
$clientDob = $this->clientDob;
$clientLicense = $this->clientLicense;
$gracePeriod = $this->gracePeriod; 
$contractHtml = $this->contractHtml;

if(!$stmt->execute())  {
	printf("Error: INSERT CONTRACT INFO%s.\n", $stmt->error);
   }		
$stmt->close(); 

/*
echo"
<h3>Contract Info</h3>
User:  $userId
 <br>
Contract Key:  $contractKey
<br>
Transfer:  $transfer
<br>
Signup Date: $signDate
<br>
Club Id:   $clubId
<br>
Contract Location: $contractLocation
<br>
Contract Date:  $contractDate
<br>
Terms:  $termsConditions
<br>
Contract Quit:  $contractQuit
<br>
Host Type:  $hostType
<br>
Client First:  $clientFirst
<br>
Client Middle:  $clientMiddle
<br>
Client Last:  $clientLast
<br>
Client Street:  $clientStreet
<br>
Client City:  $clientCity
<br>
Client State:  $clientState
<br>
Client Zip:  $clientZip
<br>
Primary Phone:  $clientHomePhone
<br>
Cell Phone:  $clientCellPhone
<br>
Client Email:  $clientEmail
<br>
DOB:  $clientDob
<br>
Drivers License:  $clientLicense
<br>
Grace Period:  $gracePeriod
<br><br><br><br>";
*/



}
//==================================================================
function parseStartDate() {

$gracePeriod = $this->loadGracePeriod();
$gracePeriodSeconds = $gracePeriod * 86400;
$startDateSeconds = strtotime($this->startDate);
$todaysDateSeconds = time();

//check to see if eligible
$renewalLimitSeconds = $startDateSeconds + $gracePeriodSeconds;

  if(($todaysDateSeconds > $startDateSeconds) && ($startDateSeconds < $renewalLimitSeconds)) {
    $this->startDate = date("Y-m-d H:i:s");    
    }


}
//---------------------------------------------------------------------------------------------------------------------
function insertPaidFull() {
//echo "a $this->oldKey  b $this->changedServiceBool";
//exit;
//parse the services selected
$productFieldArray =  explode("|", $this->productRow);
$this->serviceKey = $productFieldArray[0];
$this->standardRenewal = $productFieldArray[1];
$this->earlyRenewal = $productFieldArray[2];
$this->commissionCredit = $productFieldArray[3];
//parse the email address of the sales person to a sales id for insert
$this->parseComissionId();

$dbMain = $this->dbconnect();

if($this->pifOutBool == 0){
    
    if ($this->changedServiceBool == 1){
        //first we get all of the pertinant data from the original contract last generated
                $stmt = $dbMain ->prepare("SELECT  group_type, group_number, club_id,  service_quantity, service_term, end_date, transfer FROM paid_full_services WHERE  contract_key = '$this->contractKey' AND service_key = '$this->oldKey' ORDER BY signup_date DESC LIMIT 1");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($group_type, $group_number, $club_id, $service_name, $service_term, $end_date, $transfer);
                 $stmt->fetch();
                // echo "ckey $this->contractKey okey $this->oldKey gt $group_type cid $club_id";
                // exit;
                $stmt = $dbMain ->prepare("SELECT service_type, service_cost FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_key = '$this->serviceKey' AND service_quantity = '$this->newServiceQuantity'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($newServiceName, $newServiceCost);
                $stmt->fetch();
                $stmt->close();
                 
                
                $this->groupType = $group_type;
                $this->groupNumber = $group_number;
                $this->clubId = $club_id;
                $this->serviceName = $newServiceName;
                //$this->newServiceQuantity = $service_quantity;
                $this->serviceTerm = $service_term;
                $this->unitPrice = $newServiceCost;
                $this->unitRenewRate = $newServiceCost;
                $this->groupPrice = $newServiceCost;
                
                //since this is a renewal we use the end date of the original term as the start date
                $this->startDate = $end_date;
                
                //next check to see if the service has expired and if it is in the grace period
                $this->parseStartDate();
                
                //parse the end and start dates for pif
                $this->parseStartEndDates();
                }else{
                   $stmt = $dbMain ->prepare("SELECT  group_type, group_number, club_id, service_name,  service_quantity, service_term, unit_price, unit_renew_rate,  group_price, group_renew_rate, end_date, transfer FROM paid_full_services WHERE  contract_key = '$this->contractKey' AND service_key = '$this->serviceKey' ORDER BY signup_date DESC LIMIT 1");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($group_type, $group_number, $club_id, $service_name,  $service_quantity, $service_term, $unit_price, $unit_renew_rate,  $group_price, $group_renew_rate, $end_date, $transfer);
                 $stmt->fetch();
                
                $this->groupType = $group_type;
                $this->groupNumber = $group_number;
                $this->clubId = $club_id;
                $this->serviceName = $service_name;
                //$this->newServiceQuantity = $service_quantity;
                $this->serviceTerm = $service_term;
                $this->unitPrice = $unit_price;
                $this->unitRenewRate = $unit_renew_rate;
                $this->groupPrice = $group_price;
                
                //since this is a renewal we use the end date of the original term as the start date
                $this->startDate = $end_date;
                
                //next check to see if the service has expired and if it is in the grace period
                $this->parseStartDate();
                
                //parse the end and start dates for pif
                $this->parseStartEndDates(); 
                }

}else{
    $stmt = $dbMain ->prepare("SELECT group_type, group_number FROM member_groups WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($group_type, $group_number);
    $stmt->fetch();
    $stmt->close();
    
   $stmt = $dbMain ->prepare("SELECT service_type, club_id, service_quantity, service_term, service_cost FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key WHERE service_info.service_key = '$this->serviceKey' AND service_quantity = '$this->newServiceQuantity' ORDER BY service_cost ASC LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->serviceName, $this->clubId, $this->serviceQuantity, $this->serviceTerm, $this->unitPrice);
    $stmt->fetch();
    $this->unitRenewRate = $this->unitPrice;
    $this->groupPrice = $this->unitPrice;
    $this->groupNumber = $group_number; 
    $this->groupType = $group_type;
    $this->startDate = date("Y-m-d H:i:s");
    $this->endDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date('m')+$this->pifOutTime, date('d'), date('Y')+$this->newServiceQuantity));
    $userId = $this->comissionId;
    $signup = date('Y-m-d');
    $transfer = 'N';
    $this->originalGroupRenewRate = $this->unitPrice;
    $this->groupRenewRate = $this->unitPrice;
    //echo"$this->startDate $this->endDate $this->pifOutTime $this->serviceQuantity";
    
    
    
}
//now we compare to see if this is a standard renewal or early renewal
if($this->earlyRenewal != 'NA') {
 //$this->groupRenewRate = $this->earlyRenewal;
   $this->groupRenewRate = $this->standardRenewal;
   //this is for the sales table
   $this->earlyRenewalBoon = 'Y';
}else{
   $this->groupRenewRate = $this->standardRenewal;
   $this->earlyRenewalBoon = 'N';
}

//this is for the sales table for comparison if override was present or early renewal is the case
$this->originalGroupRenewRate = $group_renew_rate;

//if(!$stmt->execute())  {
//	printf("Error: INSERT PIF %s.\n", $stmt->error);
//   }		
//$stmt->close(); 


$sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiissdsddddssiss', $serviceId, $contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTerm, $unitPrice, $unitRenewRate, $groupPrice, $groupRenewRate, $startDate, $endDate, $userId, $signup, $transfer);
$stmt->execute();

$serviceId = $this->serviceId;
$contractKey = $this->contractKey;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$serviceKey = $this->serviceKey;
$clubId = $this->clubId;
$serviceName = $this->serviceName;
$serviceQuantity = $this->newServiceQuantity;
$serviceTerm = $this->serviceTerm;
$unitPrice = sprintf("%.2f", $this->groupRenewRate / $groupNumber);
$unitRenewRate = sprintf("%.2f", $this->groupRenewRate / $groupNumber);
$groupPrice = $this->groupRenewRate;
$groupRenewRate = $this->groupRenewRate;
$startDate = $this->startDate;
$endDate = $this->endDate;
$userId = $this->comissionId;
$signup = $this->signupDate;

if(!$stmt->execute())  {
	printf("Error: INSERT PIF%s.\n", $stmt->error);
   }
   
$this->statusId = $stmt->insert_id;   
$stmt->close(); 

$this->saveAccountStatus();
$this->insertSale(); 

/*
echo"
<h3>PIF Services</h3>
Contract Key:  $contractKey
 <br>
Group Type:  $groupType
<br>
Group Number:  $groupNumber
<br>
Service Key:  $serviceKey
<br>
Club Id:   $clubId
<br>
Service Name:   $serviceName
<br>
Number Quantity:   $serviceQuantity
<br>
Service Term:  $serviceTerm
<br>
Unit Price:  $unitPrice
<br>
Unit Renew Rate:   $unitRenewRate
<br>
Group Price:    $groupPrice
<br>
Group Renew Rate:  $groupRenewRate
<br>
Start Date:   $startDate
<br>
End Date:   $endDate
<br>
Commission Id:   $userId
<br>
Signup Date:  $signup 
<br><br><br><br>";
*/

}
//==================================================================
function saveServices()  {

$productListArray = explode("#", $this->productList);
$productCount = count($productListArray);
$productCount = $productCount -1;

for($i=0; $i < $productCount; $i++)  {
       $this->productRow = $productListArray[$i];
       $this->insertPaidFull();                             
     }
     
}
//===================================================================
function insertSale()  {
    
    //delets cs subscrips and sets account status to cancel for pif outs
if ($this->pifOutBool == 1){
    $this->cancelMonthlyPIFOut();
}
    

$dbMain = $this->dbconnect();
$sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisisiiisdssddsddissssssss', $salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew);

//get the contract location
$this->loadClubLocation();

$salesKey = "";
$locationId = $this->locationId;
$contractLocation = $this->clubLocation;
$userId = $this->comissionId;
$groupType = $this->groupType;
$groupNumber = $this->groupNumber;
$clubId = $this->clubId;
$serviceKey = $this->serviceKey;
$serviceName = $this->serviceName;
$serviceQuantity = $this->newServiceQuantity;
$serviceTerm = $this->serviceTerm;
$serviceType = $this->serviceType;
$unitPrice = $this->unitRenewRate;  //changed as the renewal cost since the original price does not apply
$groupPrice = $this->unitRenewRate;  //plays off the original cost
$overidePin = $this->overidePin;

//shows an early renewal if exists or standasrd renewal if not
if($this->earlyRenewalBoon == 'N')  {
$overideUnitPrice = sprintf("%.2f", $this->groupRenewRate / $groupNumber);
$overideGroupPrice = $this->groupRenewRate; 
}else{
$overideUnitPrice = sprintf("%.2f", $this->earlyRenewal / $groupNumber);
$overideGroupPrice = $this->earlyRenewal; 
}

$contractKey = $this->contractKey;

//sets the paid full membership to T
if(($this->serviceTerm == 'Y') || ($this->serviceTerm == 'W') || ($this->serviceTerm == 'D') || ($this->serviceTerm == 'PF'))  { 
   $termType = 'T';
   }else{
   $termType = $this->termType;
   }

$renewal = $this->renewal;
$upgrade = $this->upgrade;
$internet = $this->internet;
$saleDateTime = $this->signupDate;
$amPm = date("a");
$earlyRenewalBoon = $this->earlyRenewalBoon;
$salesNew = 'N';

  if(!$stmt->execute())  {
	printf("Error: INSERT SALES %s.\n", $stmt->error);
   }		

$stmt->close(); 

include"commissionRecords.php";
/*
echo"
<h3>Sales Info</h3>
Location Id: $locationId
<br>
Contract Location: $contractLocation
<br>
Commission Credit:  $userId 
<br>
Group Type:  $groupType
<br>
Group Number: $groupNumber
<br>
Club Id: $clubId
<br>
Service Key:  $serviceKey
<br>
Service Name: $serviceName
<br>
Service Quantity:  $serviceQuantity
<br>
Service Term:  $serviceTerm
<br>
Service Type:  $serviceType
<br>
Unit Price:  $unitPrice
<br>
Group Price:  $groupPrice
<br>
Override Pin: $overidePin
<br>
Override Unit Price:  $overideUnitPrice
<br>
Override Group Price:  $overideGroupPrice
<br>
Contract Key: $contractKey
<br>
Term Type:  $termType
<br>
Sale Date Time:   $saleDateTime
<br>
AM PM:  $amPm
<br>
Early Renewal:  $earlyRenewal 
<br><br><br>";
*/

}
//===================================================================
function saveInitialPayments() {
    

$dbMain = $this->dbconnect();
$sql = "INSERT INTO initial_payments VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iddddddddddsssdsiss', $contractKey, $processFeeMonthly, $processFeePif, $enhanceFee, $newMemberFee, $todaysPayment, $cashPayment, $checkPayment, $achPayment, $creditPayment, $balanceDue, $dueDate, $processDate, $dueStatus, $minTotalDue, $signDate, $clubId, $category, $internet);

$contractKey = $this->contractKey;
$processFeeMonthly = 0;
$processFeePif = $this->renewalFee;
$enhanceFee = $this->loadEnhanceFee();
$newMemberFee = $this->newMemberFee;
$todaysPayment = $this->todaysPayment;
$cashPayment = $this->cashPayment;
$checkPayment = $this->checkPayment;
$achPayment = $this->achPayment;
$creditPayment = $this->creditPayment;
$balanceDue = $this->balanceDue;
//-------------------------------------------------
$d =  strtotime($this->balanceDueDate);
//------------------------------------------------
$dueDate = date("Y-m-d", $d);
$processDate = date("Y-m-d");
//----------------------------------------------------
//check to see if there is a balance due. if not mark status as paid
if($balanceDue == "0.00")  {
   $dueStatus = "P";
   $historyDueStatus = 'PF';
   }else{
   $dueStatus = "G";
   $historyDueStatus = 'BD';
   }
//---------------------------------------------------
$minTotalDue = $this->grandTotal;
$signDate = $this->signupDate;
$clubId = $this->locationId;
$category = $this->contractType;
$internet = 'N';

if(!$stmt->execute())  {
	printf("Error: INI PAYMENTS %s.\n", $stmt->error);
   }		

$stmt->close(); 


//here we set the payment history
//---------------------------------------------------------------------------------
$this->paymentHistory();





/*
echo"
<h3>Initial Payments</h3>
Contract Key:  $contractKey
 <br>
Month Fee:  $processFeeMonthly
<br>
PIF Fee:  $processFeePif
<br>
Enhance Fee:  $enhanceFee
<br>
Todays Payment:  $todaysPayment
<br>
Cash Payment:   $cashPayment
<br>
Check Payment:   $checkPayment
<br>
ACH Payment:    $achPayment
<br>
Credit Payment:  $creditPayment
<br>
Balance Due:  $balanceDue
<br>
Due Date:   $dueDate
<br>
Process Date:  $processDate
<br>
Due Status:  $dueStatus
<br>
Min Total Due:  $minTotalDue
<br><br><br>";
*/
}
//===================================================================
function saveNote() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssssiss', $contractKey, $noteUser, $noteDate, $amPm, $noteTopic, $noteMessage, $noteCategory, $memberId, $priority, $targetApp);

$contractKey = $this->contractKey;
$noteUser = $this->noteUser;
$noteDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")  ,date("d"), date("Y")));
$amPm = date("a");
$noteTopic  = $this->noteTopic;
$noteMessage = $this->noteMessage;
$noteCategory = $this->noteCategory;
$memberId = null;
$priority = $this->notePriority;
$targetApp = $this->targetApp;

if(!$stmt->execute())  {
	printf("Error: SAVE NOTES %s.\n", $stmt->error);
   }		
$stmt->close(); 


/*
echo"
<h3>Account Notes</h3>
Contract Key:  $contractKey
<br>
Note User:  $noteUser
<br>
Note Date:  $noteDate
<br>
AM PM: $amPm
<br>
Topic:  $noteTopic
<br>
Message:  $noteMessage
<br><br><br>";
*/
}
//=====================================================================
/*function deleteSubscription(){
        
        $dbMain = $this->dbconnect();
        
        $authOptions = new gatewayAuth();
        $authOptions->loadGatewayOptions();
        $merchantId = $authOptions->getMerchantId();
        $transactionKey = $authOptions->getTransactionKey();
        $accessLink = $authOptions->getAccessLink();

        define('MERCHANT_ID', $merchantId);
        define('TRANSACTION_KEY', $transactionKey);
        define('WSDL_URL', $accessLink);
        
        $soapClient = new ExtendedClient(WSDL_URL, array());
        
        $request2 = new stdClass();
        $paySubscriptionUpdateService = new stdClass();
        $recurringSubscriptionInfo = new stdClass();


        $request2->merchantID = MERCHANT_ID;
        $request2->merchantReferenceCode = "$this->contractKey";
        $request2->clientLibrary = "PHP";
        $request2->clientLibraryVersion = phpversion();
        $request2->clientEnvironment = php_uname();


        $paySubscriptionUpdateService->run = 'true';
        $request2->paySubscriptionUpdateService = $paySubscriptionUpdateService;

        $recurringSubscriptionInfo->status = "cancel";
        $recurringSubscriptionInfo->subscriptionID = "$this->subscriptionId";
        $request2->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        $reply2 = $soapClient->runTransaction($request2);

        $this->ccAuthDecision2 = $reply2->decision;
        $this->ccAuthReasonCode2 = $reply2->reasonCode;
        $this->ccAuthRequestId2 = $reply2->requestID;
        
         if ($this->ccAuthReasonCode2 != 100) {
                
              $sql = "INSERT INTO failed_deletions VALUES (?,?,?)";
              $stmt1 = $dbMain->prepare($sql);
              $stmt1->bind_param('isi', $this->contractKey, $this->subscriptionID,  $this->ccAuthReasonCode2);

              if (!$stmt1->execute()) {  
                    printf("Error: %s.inswert failed delete \n", $stmt1->error);
                }
               $stmt1->close();
               
                $stmt22 = $dbMain->prepare("SELECT contact_email FROM business_info WHERE bus_id = '1000'");
                $stmt22->execute();
                $stmt22->store_result();
                $stmt22->bind_result($contact_email);
                $stmt22->fetch();
                $stmt22->close();
                
                $message2 =  "A subscription cancellation has FAILED for $this->contractKey on the Renewal System - PIF Buyout!";
                $headers  = "From: ClubManagerPro@cmp.com\r\n";
                $headers .= "Content-type: text/html\r\n";   
                mail('$contact_email', 'CMP Subscription Error', $message2, $headers);
                   
            }
    

   }*/
//=====================================================================
function cancelMonthlyPIFOut(){
    
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT DISTINCT service_key FROM monthly_services WHERE contract_key ='$this->contractKey' AND service_name LIKE '%Membership%'  ORDER BY signup_date DESC");   
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key);
$stmt->fetch();
$stmt->close();

$status = 'CA';

$dbMain = $this->dbconnect();
$sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey' AND service_key = '$service_key'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $status); 

 if(!$stmt->execute())  {
	printf("Error: UPDATE ACCOUNT STAT %s.\n", $stmt->error);
   }		

$stmt->close(); 

/*$stmt99 = $dbMain ->prepare("SELECT subscription_id FROM cs_subscriptions WHERE contract_key ='$this->contractKey'");   
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($this->subscriptionId);
while($stmt99->fetch()){
     $this->deleteSubscription();
}
$stmt99->close();*/
   
}

//===================================================================
function getGroupInfo() {
             return($this->groupInfo);
             }            
function getAddressInfo() {
             return($this->addressInfo);
             }             
function getProductList() {
             return($this->productList);
             }        
function getContractKey() {
             return($this->contractKey);
             }
function getRenewalFee() {
             return($this->renewalFee);
             }
function getServiceTotal() {
             return($this->serviceTotal);
             }
function  getGrandTotal() {
             return($this->grandTotal);
            }
function getTodaysPayment() {
            return($this->todaysPayment);
            }           
function getBalanceDue() {
            return($this->balanceDue);
            }
function getBalanceDueDate() {
            return($this->balanceDueDate);
           }
           
function getFirstName() {
             return($this->firstName);
             } 
function getMiddleName() {
             return($this->middleName);
             }                          
function getLastName() {
             return($this->LastName);
             }                          
           
function getGroupTypeName() {
            return($this->groupTypeName);
            }
function getGroupTypeContract() {
            return($this->groupTypeContract);
            }  
function  getPifOutBool(){
            return($this->pifOutBool);
   }   
function getPifOutTime(){
            return($this->pifOutTime);
   }   
function getPifOutMoneyOwed(){
            return($this->pifOutMoneyOwed);
   } 
function getYearQuantity(){
            return($this->newServiceQuantity);
   }  
function  getOldKey(){
    return($this->oldKey);
}
function  getChangedServiceBool(){
    return($this->changedServiceBool);
}           
function getSig() {
       return($this->signature);
       }  
function getPastDueAmount() {
       return($this->pastDueAmount);
       }             
//------------------------------------------------------------------------------------------------------------




}



?>