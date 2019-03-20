<?php
$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost WHERE service_key ='$serviceKey'   ORDER BY cost_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceCost); 

   while ($stmt->fetch()) { 
             $costList .= "$serviceCost|";
             }

$stmt->close();


$costArray = explode("|", $costList);
$key = array_search($unitPrice, $costArray);

$stmt = $dbMain ->prepare("SELECT flat_fee, commission_percent FROM commission_compensation WHERE service_key ='$serviceKey' AND user_id = '$userId'  ORDER BY com_key ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($flat_rate, $commission_percent); 

   while ($stmt->fetch()) { 
             $commissionDefaultsList .="$flat_rate $commission_percent|";
             }
$stmt->close();


$commissionDefaultsArray = explode("|", $commissionDefaultsList);
$commissionTypeList = $commissionDefaultsArray[$key];
$commissionTypeArray = explode(" ",  $commissionTypeList); 

$flatRate =  $commissionTypeArray[0];
$commissionPercent = $commissionTypeArray[1];
$comDec = '.';
$comZero = '0';

if($flatRate == '0.00' &&  $commissionPercent == '0')  {
   $commission = '0.00';
   $commissionType = 'NA';
   }
if($flatRate != '0.00') {
   $commission = $flatRate * $groupNumber;
   $commissionType = 'FR';
   }
if($commissionPercent != '0') {
   
   $stringLength = strlen($commissionPercent);   
        switch ($stringLength) {
        case "1":
        $commissionPercent = "$comDec$comZero$commissionPercent";
        break;
        case "2":
        $commissionPercent = "$comDec$commissionPercent";
        break;
        case "3":
        $commissionPercent = "$commissionPercent";
        break;
       }
      
   $commissionType = 'CP';   
     if($overidePin == 'Y') {        
        $commission = $commissionPercent * $overideGroupPrice;
        }else{
        $commission = $commissionPercent * $groupPrice;
        }     
   }

if($commission == "" || $commission == '0') {
   $commission = '0.00';
  }

$id_card = $this->idCard;
$typeKey = $this->typeKey;

//echo"$userId  $saleDateTime  $serviceKey  $groupNumber  $groupPrice  $commissionType  $commission $key $commissionPercent<br>";

$sql = "INSERT INTO commission_credit VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiidsdi', $ccKey, $userId, $saleDateTime, $serviceKey, $groupNumber, $groupPrice, $commissionType, $commission, $id_card);

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
$stmt->close(); 

/*
$stmt = $dbMain ->prepare("SELECT type_key FROM basic_compensation WHERE user_id = '$userId' AND id_card= '$id_card' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($typeKey); 
$stmt->fetch();
$stmt->close();
*/
$sql = "INSERT INTO commission_records VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidsis', $serviceKey, $userId, $commission, $saleDateTime, $locationId, $typeKey);

 if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		
$stmt->close(); 




?>
