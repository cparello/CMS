<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  feesSql{

private $processFeeSingle;
private $processFeeFamily;
private $processFeeBusiness;
private $processFeeOrganization;
private $processFeeSingle2;
private $processFeeFamily2;
private $processFeeBusiness2;
private $processFeeOrganization2;
private $upgradeFeeSingle;
private $upgradeFeeFamily;
private $upgradeFeeBusiness;
private $upgradeFeeOrganization;
private $upgradeFeeSingle2;
private $upgradeFeeFamily2;
private $upgradeFeeBusiness2;
private $upgradeFeeOrganization2;
private $upgradeFeeSingle3;
private $upgradeFeeFamily3;
private $upgradeFeeBusiness3;
private $upgradeFeeOrganization3;
private $renewalFeeSingle;
private $renewalFeeFamily;
private $renewalFeeBusiness;
private $renewalFeeOrganization;
private $renewalFeeSingle2;
private $renewalFeeFamily2;
private $renewalFeeBusiness2;
private $renewalFeeOrganization2;
private $cancelFee;
private $enhanceFee;
private $rejectionFee;
private $nsfFee;
private $renewalPercent;
private $earlyRenewalPercent;
private $earlyRenewalGrace;
private $standardRenewalGrace;
private $pastDueGrace;
private $lateFee;
private $cardFee;
private $rateFee;
private $holdFee;
private $holdGrace;
private $memberHoldFee;
private $transferFee;
private $classPercent;

function setProcessFeeSingle($processFeeSingle) {
        $this->processFeeSingle = $processFeeSingle;
         }
         
function setProcessFeeFamily($processFeeFamily) {
        $this->processFeeFamily = $processFeeFamily;
         }   
         
function setProcessFeeBusiness($processFeeBusiness) {
        $this->processFeeBusiness = $processFeeBusiness;
         }   

 function setProcessFeeOrganization($processFeeOrganization) {
        $this->processFeeOrganization = $processFeeOrganization;
         }   
         
function setProcessFeeSingle2($processFeeSingle2) {
        $this->processFeeSingle2 = $processFeeSingle2;
         }
         
function setProcessFeeFamily2($processFeeFamily2) {
        $this->processFeeFamily2 = $processFeeFamily2;
         }   
         
function setProcessFeeBusiness2($processFeeBusiness2) {
        $this->processFeeBusiness2 = $processFeeBusiness2;
         }   

 function setProcessFeeOrganization2($processFeeOrganization2) {
        $this->processFeeOrganization2 = $processFeeOrganization2;
         }        

function setUpgradeFeeSingle($upgradeFeeSingle) {
        $this->upgradeFeeSingle = $upgradeFeeSingle;
         }
         
function setUpgradeFeeFamily($upgradeFeeFamily) {
        $this->upgradeFeeFamily = $upgradeFeeFamily;
         }   
         
function setUpgradeFeeBusiness($upgradeFeeBusiness) {
        $this->upgradeFeeBusiness = $upgradeFeeBusiness;
         }   

 function setUpgradeFeeOrganization($upgradeFeeOrganization) {
        $this->upgradeFeeOrganization = $upgradeFeeOrganization;
         }   
         
function setUpgradeFeeSingle2($upgradeFeeSingle2) {
        $this->upgradeFeeSingle2 = $upgradeFeeSingle2;
         }
         
function setUpgradeFeeFamily2($upgradeFeeFamily2) {
        $this->upgradeFeeFamily2 = $upgradeFeeFamily2;
         }   
         
function setUpgradeFeeBusiness2($upgradeFeeBusiness2) {
        $this->upgradeFeeBusiness2 = $upgradeFeeBusiness2;
         }   

function setUpgradeFeeOrganization2($upgradeFeeOrganization2) {
        $this->upgradeFeeOrganization2 = $upgradeFeeOrganization2;
         }      
         
function setUpgradeFeeSingle3($upgradeFeeSingle3) {
        $this->upgradeFeeSingle3 = $upgradeFeeSingle3;
         }
         
function setUpgradeFeeFamily3($upgradeFeeFamily3) {
        $this->upgradeFeeFamily3 = $upgradeFeeFamily3;
         }   
         
function setUpgradeFeeBusiness3($upgradeFeeBusiness3) {
        $this->upgradeFeeBusiness3 = $upgradeFeeBusiness3;
         }   

function setUpgradeFeeOrganization3($upgradeFeeOrganization3) {
        $this->upgradeFeeOrganization3 = $upgradeFeeOrganization3;
         }               
               
function setRenewalFeeSingle($renewalFeeSingle) {
        $this->renewalFeeSingle = $renewalFeeSingle;
         }
         
function setRenewalFeeFamily($renewalFeeFamily) {
        $this->renewalFeeFamily = $renewalFeeFamily;
         }   
         
function setRenewalFeeBusiness($renewalFeeBusiness) {
        $this->renewalFeeBusiness = $renewalFeeBusiness;
         }   

function setRenewalFeeOrganization($renewalFeeOrganization) {
        $this->renewalFeeOrganization = $renewalFeeOrganization;
         }   
         
function setRenewalFeeSingle2($renewalFeeSingle2) {
        $this->renewalFeeSingle2 = $renewalFeeSingle2;
         }
         
function setRenewalFeeFamily2($renewalFeeFamily2) {
        $this->renewalFeeFamily2 = $renewalFeeFamily2;
         }   
         
function setRenewalFeeBusiness2($renewalFeeBusiness2) {
        $this->renewalFeeBusiness2 = $renewalFeeBusiness2;
         }   

function setRenewalFeeOrganization2($renewalFeeOrganization2) {
        $this->renewalFeeOrganization2 = $renewalFeeOrganization2;
         }                 
                  
                          
function setCancelFee($cancelFee)  {
		$this->cancelFee = $cancelFee;
		  }

function setEnhanceFee($enhanceFee)  {
		$this->enhanceFee = $enhanceFee;
		  }

function setRejectionFee($rejectionFee)  {
		$this->rejectionFee = $rejectionFee;
		  }
		  
function setNsfFee($nsfFee)  {
		$this->nsfFee = $nsfFee;
		  }		  

function setRenewalPercent($renewalPercent) {
        $this->renewalPercent = $renewalPercent;
        }

function setEarlyRenewalPercent($earlyRenewalPercent) {
        $this->earlyRenewalPercent = $earlyRenewalPercent;
        }
	
function setEarlyRenewalGrace($earlyRenewalGrace) {
        $this->earlyRenewalGrace = $earlyRenewalGrace;
        }
        
function setStandardRenewalGrace($standardRenewalGrace) {
        $this->standardRenewalGrace = $standardRenewalGrace;
        }
        
function setPastDueGrace($pastDueGrace) {
        $this->pastDueGrace = $pastDueGrace;
        }        
        
function setLateFee($lateFee) {
        $this->lateFee = $lateFee;
        }             
        
function setCardFee($cardFee) {
        $this->cardFee = $cardFee;
        }  
        
function setRateFee($rateFee) {
        $this->rateFee = $rateFee;
        }  
        
function setMemberHoldFee($memberHoldFee) {
        $this->memberHoldFee = $memberHoldFee;
        }        

function setHoldFee($holdFee) {
        $this->holdFee = $holdFee;
        }
        
function setHoldGrace($holdGrace) {
        $this->holdGrace = $holdGrace;
        }        
        
function setTransferFee($transferFee) {
        $this->transferFee = $transferFee;
        }

function setClassPercent($classPercent) {
        $this->classPercent = $classPercent;
        }
function setMaintnenceFee($maintFee) {
        $this->maintFee = $maintFee;
        }
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==================================================================================================
function loadPastDueGrace() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();
   
   $this->pastDueGrace = $past_day;
   
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }

}
//==================================================================================================
function updatePastDueGrace() {

$dbMain = $this->dbconnect();
$sql = "UPDATE billing_cycle SET past_day= ? WHERE cycle_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $pastDueGrace);

$pastDueGrace = $this->pastDueGrace;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }


}
//==================================================================================================
function updateFees()     {

//create a confirmation message for errors
$this->confirmation_message = "There was an error updating these fees";

$dbMain = $this->dbconnect();


$sql = "UPDATE fees SET process_fee_single= ?,  process_fee_family= ?, process_fee_business= ?, process_fee_organization= ?, process_fee_single_two= ?,  process_fee_family_two= ?, process_fee_business_two= ?, process_fee_organization_two= ?, upgrade_fee_single= ?,  upgrade_fee_family= ?, upgrade_fee_business= ?, upgrade_fee_organization= ?, upgrade_fee_single_two= ?,  upgrade_fee_family_two= ?, upgrade_fee_business_two= ?, upgrade_fee_organization_two= ?, upgrade_fee_single_three= ?,  upgrade_fee_family_three= ?, upgrade_fee_business_three= ?, upgrade_fee_organization_three= ?, renewal_fee_single= ?,  renewal_fee_family= ?, renewal_fee_business= ?, renewal_fee_organization= ?, renewal_fee_single_two= ?,  renewal_fee_family_two= ?, renewal_fee_business_two= ?, renewal_fee_organization_two= ?, cancel_fee=?, enhance_fee=?, rejection_fee=?, renewal_percent=?, early_renewal_percent=?, early_renewal_grace=?, standard_renewal_grace=?, late_fee=?, card_fee=?, rate_fee=?, hold_fee=?, hold_grace=?, member_hold_fee=?, transfer_fee=?, nsf_fee=?, class_percent=?, maintnence_fee=? WHERE fee_num = '1'";

						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('dddddddddddddddddddddddddddddddiiiiddddidddid', $processFeeSingle, $processFeeFamily, $processFeeBusiness, $processFeeOrganization, $processFeeSingle2, $processFeeFamily2, $processFeeBusiness2, $processFeeOrganization2, $upgradeFeeSingle, $upgradeFeeFamily, $upgradeFeeBusiness, $upgradeFeeOrganization, $upgradeFeeSingle2, $upgradeFeeFamily2, $upgradeFeeBusiness2, $upgradeFeeOrganization2, $upgradeFeeSingle3, $upgradeFeeFamily3, $upgradeFeeBusiness3, $upgradeFeeOrganization3, $renewalFeeSingle, $renewalFeeFamily, $renewalFeeBusiness, $renewalFeeOrganization, $renewalFeeSingle2, $renewalFeeFamily2, $renewalFeeBusiness2, $renewalFeeOrganization2, $cancelFee, $enhanceFee, $rejectionFee, $renewalPercent, $earlyRenewalPercent, $earlyRenewalGrace, $standardRenewalGrace, $lateFee, $cardFee, $rateFee, $holdFee, $holdGrace, $memberHoldFee, $transferFee, $nsfFee, $classPercent, $this->maintFee);						


$processFeeSingle = $this->processFeeSingle; 
$processFeeFamily = $this->processFeeFamily;
$processFeeBusiness = $this->processFeeBusiness;
$processFeeOrganization = $this->processFeeOrganization;
$processFeeSingle2 = $this->processFeeSingle2; 
$processFeeFamily2 = $this->processFeeFamily2;
$processFeeBusiness2 = $this->processFeeBusiness2;
$processFeeOrganization2 = $this->processFeeOrganization2;
$upgradeFeeSingle = $this->upgradeFeeSingle; 
$upgradeFeeFamily = $this->upgradeFeeFamily;
$upgradeFeeBusiness = $this->upgradeFeeBusiness;
$upgradeFeeOrganization = $this->upgradeFeeOrganization;
$upgradeFeeSingle2 = $this->upgradeFeeSingle2; 
$upgradeFeeFamily2 = $this->upgradeFeeFamily2;
$upgradeFeeBusiness2 = $this->upgradeFeeBusiness2;
$upgradeFeeOrganization2 = $this->upgradeFeeOrganization2;
$upgradeFeeSingle3 = $this->upgradeFeeSingle3; 
$upgradeFeeFamily3 = $this->upgradeFeeFamily3;
$upgradeFeeBusiness3 = $this->upgradeFeeBusiness3;
$upgradeFeeOrganization3 = $this->upgradeFeeOrganization3;
$renewalFeeSingle = $this->renewalFeeSingle; 
$renewalFeeFamily = $this->renewalFeeFamily;
$renewalFeeBusiness = $this->renewalFeeBusiness;
$renewalFeeOrganization = $this->renewalFeeOrganization;
$renewalFeeSingle2 = $this->renewalFeeSingle2; 
$renewalFeeFamily2 = $this->renewalFeeFamily2;
$renewalFeeBusiness2 = $this->renewalFeeBusiness2;
$renewalFeeOrganization2 = $this->renewalFeeOrganization2;

$cancelFee = $this->cancelFee; 
$enhanceFee= $this->enhanceFee; 
$rejectionFee= $this->rejectionFee; 
$renewalPercent= $this->renewalPercent;
$earlyRenewalPercent = $this->earlyRenewalPercent;
$earlyRenewalGrace = $this->earlyRenewalGrace;
$standardRenewalGrace = $this->standardRenewalGrace;
$lateFee = $this->lateFee;
$cardFee = $this->cardFee;
$rateFee = $this->rateFee;
$holdFee = $this->holdFee;
$holdGrace = $this->holdGrace;
$memberHoldFee = $this->memberHoldFee;
$transferFee = $this->transferFee;
$nsfFee = $this->nsfFee;
$classPercent = $this->classPercent;

$this->updatePastDueGrace();



if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmation_message = "Contract and Club Fees Successfully Updated";
   return($this->confirmation_message);
   }
}

//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadFees() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving these fees";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT * FROM fees WHERE fee_num = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($feeNum, $processFeeSingle, $processFeeFamily, $processFeeBusiness, $processFeeOrganization, $processFeeSingle2, $processFeeFamily2, $processFeeBusiness2, $processFeeOrganization2, $upgradeFeeSingle, $upgradeFeeFamily, $upgradeFeeBusiness, $upgradeFeeOrganization, $upgradeFeeSingle2, $upgradeFeeFamily2, $upgradeFeeBusiness2, $upgradeFeeOrganization2, $upgradeFeeSingle3, $upgradeFeeFamily3, $upgradeFeeBusiness3, $upgradeFeeOrganization3,$renewalFeeSingle, $renewalFeeFamily, $renewalFeeBusiness, $renewalFeeOrganization, $renewalFeeSingle2, $renewalFeeFamily2, $renewalFeeBusiness2, $renewalFeeOrganization2, $cancelFee, $enhanceFee, $rejectionFee, $renewalPercent, $earlyRenewalPercent, $earlyRenewalGrace, $standardRenewalGrace, $lateFee, $cardFee, $rateFee, $holdFee, $holdGrace, $memberHoldFee, $transferFee, $nsfFee, $classPercent, $this->maintFee); 
   $stmt->fetch();


$this->processFeeSingle = $processFeeSingle; 
$this->processFeeFamily = $processFeeFamily; 
$this->processFeeBusiness = $processFeeBusiness;
$this->processFeeOrganization = $processFeeOrganization; 
$this->processFeeSingle2 = $processFeeSingle2; 
$this->processFeeFamily2 = $processFeeFamily2; 
$this->processFeeBusiness2 = $processFeeBusiness2;
$this->processFeeOrganization2 = $processFeeOrganization2; 
$this->upgradeFeeSingle = $upgradeFeeSingle; 
$this->upgradeFeeFamily = $upgradeFeeFamily; 
$this->upgradeFeeBusiness = $upgradeFeeBusiness;
$this->upgradeFeeOrganization = $upgradeFeeOrganization; 
$this->upgradeFeeSingle2 = $upgradeFeeSingle2; 
$this->upgradeFeeFamily2 = $upgradeFeeFamily2; 
$this->upgradeFeeBusiness2 = $upgradeFeeBusiness2;
$this->upgradeFeeOrganization2 = $upgradeFeeOrganization2; 
$this->upgradeFeeSingle3 = $upgradeFeeSingle3; 
$this->upgradeFeeFamily3 = $upgradeFeeFamily3; 
$this->upgradeFeeBusiness3 = $upgradeFeeBusiness3;
$this->upgradeFeeOrganization3 = $upgradeFeeOrganization3; 
$this->renewalFeeSingle = $renewalFeeSingle; 
$this->renewalFeeFamily = $renewalFeeFamily; 
$this->renewalFeeBusiness = $renewalFeeBusiness;
$this->renewalFeeOrganization = $renewalFeeOrganization; 
$this->renewalFeeSingle2 = $renewalFeeSingle2; 
$this->renewalFeeFamily2 = $renewalFeeFamily2; 
$this->renewalFeeBusiness2 = $renewalFeeBusiness2;
$this->renewalFeeOrganization2 = $renewalFeeOrganization2; 
$this->cancelFee = $cancelFee; 
$this->enhanceFee = $enhanceFee; 
$this->rejectionFee = $rejectionFee; 
$this->renewalPercent = $renewalPercent;
$this->earlyRenewalPercent = $earlyRenewalPercent;
$this->earlyRenewalGrace = $earlyRenewalGrace;
$this->standardRenewalGrace = $standardRenewalGrace;
$this->lateFee = $lateFee;
$this->cardFee = $cardFee;
$this->rateFee = $rateFee;
$this->holdFee = $holdFee;
$this->holdGrace = $holdGrace;
$this->memberHoldFee = $memberHoldFee;
$this->transferFee = $transferFee;
$this->nsfFee = $nsfFee;
$this->classPercent = $classPercent;
$this->loadPastDueGrace();

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }

}

//==================================================================================================
function getProcessFeeSingle() {
 return($this->processFeeSingle);
}

function getProcessFeeFamily() {
 return($this->processFeeFamily);
}

function getProcessFeeBusiness() {
 return($this->processFeeBusiness);
}

function getProcessFeeOrganization() {
 return($this->processFeeOrganization);
}

function getProcessFeeSingle2() {
 return($this->processFeeSingle2);
}

function getProcessFeeFamily2() {
 return($this->processFeeFamily2);
}

function getProcessFeeBusiness2() {
 return($this->processFeeBusiness2);
}

function getProcessFeeOrganization2() {
 return($this->processFeeOrganization2);
}

function getUpgradeFeeSingle() {
 return($this->upgradeFeeSingle);
}

function getUpgradeFeeFamily() {
 return($this->upgradeFeeFamily);
}

function getUpgradeFeeBusiness() {
 return($this->upgradeFeeBusiness);
}

function getUpgradeFeeOrganization() {
 return($this->upgradeFeeOrganization);
}

function getUpgradeFeeSingle2() {
 return($this->upgradeFeeSingle2);
}

function getUpgradeFeeFamily2() {
 return($this->upgradeFeeFamily2);
}

function getUpgradeFeeBusiness2() {
 return($this->upgradeFeeBusiness2);
}

function getUpgradeFeeOrganization2() {
 return($this->upgradeFeeOrganization2);
}

function getUpgradeFeeSingle3() {
 return($this->upgradeFeeSingle3);
}

function getUpgradeFeeFamily3() {
 return($this->upgradeFeeFamily3);
}

function getUpgradeFeeBusiness3() {
 return($this->upgradeFeeBusiness3);
}

function getUpgradeFeeOrganization3() {
 return($this->upgradeFeeOrganization3);
}

function getRenewalFeeSingle() {
 return($this->renewalFeeSingle);
}

function getRenewalFeeFamily() {
 return($this->renewalFeeFamily);
}

function getRenewalFeeBusiness() {
 return($this->renewalFeeBusiness);
}

function getRenewalFeeOrganization() {
 return($this->renewalFeeOrganization);
}

function getRenewalFeeSingle2() {
 return($this->renewalFeeSingle2);
}

function getRenewalFeeFamily2() {
 return($this->renewalFeeFamily2);
}

function getRenewalFeeBusiness2() {
 return($this->renewalFeeBusiness2);
}

function getRenewalFeeOrganization2() {
 return($this->renewalFeeOrganization2);
}

function getCancelFee() {
 return($this->cancelFee);
}

function getEnhanceFee() {
 return($this->enhanceFee);
}

function getRejectionFee() {
 return($this->rejectionFee);
}

function getNsfFee() {
 return($this->nsfFee);
}

function getRenewalPercent() {
 return($this->renewalPercent);
}

function getEarlyRenewalPercent() {
 return($this->earlyRenewalPercent);
}

function getEarlyRenewalGrace() {
 return($this->earlyRenewalGrace);
}

function getStandardRenewalGrace() {
 return($this->standardRenewalGrace);
}

function getPastDueGrace() {
 return($this->pastDueGrace);
}

function getLateFee() {
 return($this->lateFee);
}

function getCardFee() {
 return($this->cardFee);
}

function getRateFee() {
 return($this->rateFee);
}

function getMemberHoldFee() {
 return($this->memberHoldFee);
}

function getHoldFee() {
 return($this->holdFee);
}

function getTransferFee() {
 return($this->transferFee);
}

function getHoldGrace() {
 return($this->holdGrace);
}

function getClassPercent() {
 return($this->classPercent);
}
function getMaintnenceFee() {
 return($this->maintFee);
}

}
?>