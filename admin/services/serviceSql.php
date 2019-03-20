<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  serviceSql{

private $costKey = null;
private $serviceKey = null;
private $serviceType;
private $serviceDesc;
private $serviceLocation;
private $groupType;
private $bundleClass;

private $serviceQuantityOne;
private $durationOne;
private $serviceCostOne;
private $flatFeeOne;
private $commissionPercentOne;
private $accessLevelOne;

private $serviceQuantityTwo;
private $durationTwo;
private $serviceCostTwo;
private $flatFeeTwo;
private $commissionPercentTwo;
private $accessLevelTwo;

private $serviceQuantityThree;
private $durationThree;
private $serviceCostThree;
private $flatFeeThree;
private $commissionPercentThree;
private $accessLevelThree;			

private $serviceQuantityFour;
private $durationFour;
private $serviceCostFour;
private $flatFeeFour;
private $commissionPercentFour;
private $accessLevelFour;


private $clubId;

function setClubId($clubId) {
        $this->clubId = $clubId;
         }


function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
         }
function setServiceDesc($serviceDesc) {
        $this->serviceDesc = $serviceDesc;
         }         
function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
         }         
function setServiceKey($serviceKey) {
        $this->serviceKey = $serviceKey;
        }
function setCostKey($costKey) {
        $this->costKey = $costKey;
        }
function setGroupType($groupType) {
        $this->groupType = $groupType;
        }        
function setBundleClass($bundleClass) {
        $this->bundleClass = $bundleClass;
        }     

function setServiceQuantityOne($serviceQuantityOne) {
        $this->serviceQuantityOne = $serviceQuantityOne;
        }
function setDurationOne($durationOne) {
       $this->durationOne = $durationOne;
       }       
function setServiceCostOne($serviceCostOne)  {
       $this->serviceCostOne = $serviceCostOne;
       }
function setFlatFeeOne($flatFeeOne) {
       $this->flatFeeOne = $flatFeeOne;
       }    
function setCommissionPercentOne($commissionPercentOne)  {
       $this->commissionPercentOne = $commissionPercentOne;
       }
function setAccessLevelOne($accessLevelOne)  {
       $this->accessLevelOne = $accessLevelOne;
       }         
       

function setServiceQuantityTwo($serviceQuantityTwo) {
        $this->serviceQuantityTwo = $serviceQuantityTwo;
         }
function setDurationTwo($durationTwo) {
       $this->durationTwo = $durationTwo;
       }    
function setServiceCostTwo($serviceCostTwo)  {
       $this->serviceCostTwo = $serviceCostTwo;
       }
function setFlatFeeTwo($flatFeeTwo) {
       $this->flatFeeTwo = $flatFeeTwo;
       }       
function setCommissionPercentTwo($commissionPercentTwo)  {
       $this->commissionPercentTwo = $commissionPercentTwo;
       }       
function setAccessLevelTwo($accessLevelTwo)  {
       $this->accessLevelTwo = $accessLevelTwo;
       }    
       

function setServiceQuantityThree($serviceQuantityThree) {
       $this->serviceQuantityThree = $serviceQuantityThree;
       }
function setDurationThree($durationThree) {
       $this->durationThree = $durationThree;
       }      
function setServiceCostThree($serviceCostThree)  {
       $this->serviceCostThree = $serviceCostThree;
       }
function setFlatFeeThree($flatFeeThree) {
       $this->flatFeeThree = $flatFeeThree;
       }       
function setCommissionPercentThree($commissionPercentThree)  {
       $this->commissionPercentThree = $commissionPercentThree;
       }     
function setAccessLevelThree($accessLevelThree)  {
       $this->accessLevelThree = $accessLevelThree;
       }    
       

function setServiceQuantityFour($serviceQuantityFour) {
       $this->serviceQuantityFour= $serviceQuantityFour;
        }
function setDurationFour($durationFour) {
       $this->durationFour = $durationFour;
       }      
function setServiceCostFour($serviceCostFour)  {
       $this->serviceCostFour = $serviceCostFour;
       }
function setFlatFeeFour($flatFeeFour) {
       $this->flatFeeFour = $flatFeeFour;
       }       
function setCommissionPercentFour($commissionPercentFour)  {
       $this->commissionPercentFour = $commissionPercentFour;
       }          
function setAccessLevelFour($accessLevelFour)  {
       $this->accessLevelFour = $accessLevelFour;
       }           
       


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}


//------------------------------------------------------------------------------------------------------------------------
function addTerms($serviceKey, $serviceCost, $duration, $serviceQuantity, $flatFee, $commissionPercent, $accessLimit)  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO service_cost VALUES (?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidsidis', $this->costKey, $serviceKey, $serviceCost, $duration, $serviceQuantity, $flatFee, $commissionPercent, $accessLimit); 

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
   
$stmt->close();

}

//-----------------------------------------------------------------------------------------------------------------------
function updateTerms($serviceKey, $serviceCost, $duration, $serviceQuantity, $costKey, $flatFee, $commissionPercent, $accessLimit)  {

$dbMain = $this->dbconnect();

$sql = "UPDATE service_cost SET service_cost = ?, service_term =?, service_quantity = ?, flat_fee = ?, commission_percent = ?, access_limit = ? WHERE service_key= ? AND cost_key = ?";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('dsidisii', $serviceCost, $duration, $serviceQuantity, $flatFee, $commissionPercent,  $accessLimit, $serviceKey, $costKey);	
		
		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		
   
$stmt->close();


}
//-------------------------------------------------------------------------------------------------------------------------
function  saveService()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO service_info VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isssss', $serviceKey, $serviceType, $serviceDesc, $serviceLocation, $groupType, $bundleClass); 

$serviceKey = $this->serviceKey; 
$serviceType = $this->serviceType; 
$serviceDesc = $this->serviceDesc; 
$serviceLocation = $this->serviceLocation;
$groupType = $this->groupType;
$bundleClass = $this->bundleClass;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }	

$this->serviceKey = $stmt->insert_id;

$this->addTerms($this->serviceKey, $this->serviceCostOne, $this->durationOne, $this->serviceQuantityOne, $this->flatFeeOne, $this->commissionPercentOne, $this->accessLevelOne);
$this->addTerms($this->serviceKey, $this->serviceCostTwo, $this->durationTwo, $this->serviceQuantityTwo, $this->flatFeeTwo, $this->commissionPercentTwo, $this->accessLevelTwo);
$this->addTerms($this->serviceKey, $this->serviceCostThree, $this->durationThree, $this->serviceQuantityThree, $this->flatFeeThree, $this->commissionPercentThree, $this->accessLevelThree);
$this->addTerms($this->serviceKey, $this->serviceCostFour, $this->durationFour, $this->serviceQuantityFour, $this->flatFeeFour, $this->commissionPercentFour, $this->accessLevelFour);

$stmt->close();

$this->confirmation_message = "$this->serviceType  Successfully Added";
 return($this->confirmation_message);
}

//============================================================================
function deleteService()   {

$dbMain = $this->dbconnect();
$serviceKey = $this->serviceKey; 
$serviceName = $this->serviceType;
$serviceLocation = $this->serviceLocation;

//echo"$user_id";
//exit;
 
		
		
$sql = "DELETE FROM service_info WHERE service_key = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $serviceKey);
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

$sql2 = "DELETE FROM service_cost WHERE service_key = ?";
		
		if ($stmt = $dbMain->prepare($sql2)) {
			$stmt->bind_param("i", $serviceKey);
			$stmt->execute();	
			$stmt->close();
		   }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }

$sql3 = "DELETE FROM commission_compensation WHERE service_key = ?";
		
		if ($stmt = $dbMain->prepare($sql3)) {
			$stmt->bind_param("i", $serviceKey);
			$stmt->execute();	
			$stmt->close();
		   }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }







 $this->confirmation_message = "$serviceName from $serviceLocation Successfully Deleted";
 return($this->confirmation_message);

}

//==================================================================================================
function loadClubName()  {

$dbMain = $this->dbconnect();

$clubId = $this->clubId; 

if($clubId != 0) {

 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$clubId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name);   
			$stmt->fetch();
			$this->clubName = $club_name;
}else{
$this->clubName = 'All Locations';
}

return "$this->clubName";

}

//=================================================================================================
function updateService()   {

$dbMain = $this->dbconnect();

$sql = "UPDATE service_info SET service_type = ?, service_description = ?, club_id = ?, group_type = ?, bundle_class = ? WHERE service_key= ?";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('sssssi', $serviceType, $serviceDesc, $serviceLocation, $groupType, $bundleClass, $serviceKey);						

 
$serviceType = $this->serviceType; 
$serviceDesc = $this->serviceDesc; 
$serviceLocation = $this->serviceLocation;
$groupType = $this->groupType;
$bundleClass = $this->bundleClass;
$serviceKey = $this->serviceKey;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }	
   
$stmt->close(); 


//now we split the cost key into an array
$costKey = $this->costKey;
$costKeyArray = explode("|", $costKey);
$costKey1 = $costKeyArray[0];
$costKey2 = $costKeyArray[1];
$costKey3 = $costKeyArray[2];
$costKey4 = $costKeyArray[3];

$this->updateTerms($this->serviceKey, $this->serviceCostOne, $this->durationOne, $this->serviceQuantityOne, $costKey1, $this->flatFeeOne, $this->commissionPercentOne, $this->accessLevelOne);
$this->updateTerms($this->serviceKey, $this->serviceCostTwo, $this->durationTwo, $this->serviceQuantityTwo, $costKey2, $this->flatFeeTwo, $this->commissionPercentTwo, $this->accessLevelTwo);
$this->updateTerms($this->serviceKey, $this->serviceCostThree, $this->durationThree, $this->serviceQuantityThree, $costKey3, $this->flatFeeThree, $this->commissionPercentThree, $this->accessLevelThree);
$this->updateTerms($this->serviceKey, $this->serviceCostFour, $this->durationFour, $this->serviceQuantityFour, $costKey4, $this->flatFeeFour, $this->commissionPercentFour, $this->accessLevelFour);



 $this->confirmation_message = "$this->serviceType Successfully Updated";
 return($this->confirmation_message);

}
//=================================================================================================




}
?>