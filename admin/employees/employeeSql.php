<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  employeeSql{

//this is the basic info
private $userId;
private $empFirstName;
private $empMiddleName;
private $empLastName;
private $empStreet;
private $empCity;
private $empState;
private $empZip;
private $empPhone1;
private $empPhone2;
private $emergencyContact;
private $emergencyPhone;
private $empFullName;
private $basicKey;

//for user and password
private $userName;
private $passWord;

//this is the basic copensation for the employee type 1
private $typeKey1 = null;
private $compensationType1;
private $compensationAmount1;
private $paymentCycle1;

//this is the basic copensation for the employee type 2
private $typeKey2 = null;
private $compensationType2;
private $compensationAmount2;
private $paymentCycle2;

//this is the basic copensation for the employee type 3
private $typeKey3 = null;
private $compensationType3;
private $compensationAmount3;
private $paymentCycle3;

//this is the basic copensation for the employee type 4
private $typeKey4 = null;
private $compensationType4;
private $compensationAmount4;
private $paymentCycle4;

//this handles the commission percent
private $comKey = null;    
private $percent;
private $flatRate;
private $serviceKey;
private $flatRateAmount;
private $percentAmount;
private $clubId;

//handles ID cards
private $idCard1;
private $idCard2;
private $idCard3;
private $idCard4;

//handles hours projected
private $hoursProjected1;
private $hoursProjected2;
private $hoursProjected3;
private $hoursProjected4;

//designates if it is an imediate save or continue on to services
private  $continueAdd;

private $socialSecurity = null;


function setUserId($userId)  {
		$this->userId = $userId;
		  }		  
function setEmpFirstName($empFirstName)  {
		$this->empFirstName = $empFirstName;
		  }			  
function setEmpLastName($empLastName)  {
		$this->empLastName = $empLastName;
		  }			  		  
function setEmpMiddleName($empMiddleName) {
        $this->empMiddleName = $empMiddleName;
        }          
function setEmpStreet($empStreet)  {
		$this->empStreet = $empStreet;
	    }  		  
function setEmpCity($empCity)  {
		$this->empCity = $empCity;
		  }  		  		  
function setEmpState($empState)  {
		$this->empState = $empState;
		  }  		  
function setEmpZip($empZip)  {
		$this->empZip = $empZip;
		  }  		  		
function setEmpPhone1($empPhone1)  {
		$this->empPhone1 = $empPhone1;
		  }  		  		
function setEmpPhone2($empPhone2)  {
		$this->empPhone2 = $empPhone2;
		  } 		  
function setEmergencyContact($emergencyContact)  {
		$this->emergencyContact = $emergencyContact;
		  } 		  	  
function setEmergencyPhone($emergencyPhone)  {
		$this->emergencyPhone = $emergencyPhone;
		  } 		  		  
function setEmpFullName($empFullName) {
        $this->empFullName = $empFullName;
         }
		  
		  
function setUserName($userName)  {
		$this->userName = $userName;
		  }		  
function setPassWord($passWord)  {
		$this->passWord = $passWord;
		  }


function setSocialSecurity($socialSecurity)  {
		$this->socialSecurity = $socialSecurity;
		  }
function setEmail($email)  {
		$this->email = $email;
		  }


function setBasicKey($basicKey) {
        $this->basicKey = $basicKey;
        }
function setTypeKey1($typeKey1)  {
		$this->typeKey1 = $typeKey1;
		  }
function setCompensationType1($compensationType1) {
        $this->compensationType1 = $compensationType1;
        }
function setCompensationAmount1($compensationAmount1) {
        $this->compensationAmount1 = $compensationAmount1;
        }
function setPaymentCycle1($paymentCycle1) {
        $this->paymentCycle1 = $paymentCycle1;
        }

function setTypeKey2($typeKey2)  {
		$this->typeKey2 = $typeKey2;
		  }
function setCompensationType2($compensationType2) {
        $this->compensationType2 = $compensationType2;
        }
function setCompensationAmount2($compensationAmount2) {
        $this->compensationAmount2 = $compensationAmount2;
        }
function setPaymentCycle2($paymentCycle2) {
        $this->paymentCycle2 = $paymentCycle2;
        }
        
function setTypeKey3($typeKey3)  {
		$this->typeKey3 = $typeKey3;
		  }
function setCompensationType3($compensationType3) {
        $this->compensationType3 = $compensationType3;
        }
function setCompensationAmount3($compensationAmount3) {
        $this->compensationAmount3 = $compensationAmount3;
        }
function setPaymentCycle3($paymentCycle3) {
        $this->paymentCycle3 = $paymentCycle3;
        }     
        
function setTypeKey4($typeKey4)  {
		$this->typeKey4 = $typeKey4;
		  }
function setCompensationType4($compensationType4) {
        $this->compensationType4 = $compensationType4;
        }
function setCompensationAmount4($compensationAmount4) {
        $this->compensationAmount4 = $compensationAmount4;
        }
function setPaymentCycle4($paymentCycle4) {
        $this->paymentCycle4 = $paymentCycle4;
        }             
     
  
function setPercent($percent) {
        $this->percent = $percent;
        }
function setFlatRate($flatRate) {
        $this->flatRate = $flatRate;
        }   
function setPercentAmount($percentAmount) {
        $this->percentAmount = $percentAmount;
        }
function setFlatRateAmount($flatRateAmount) {
        $this->flatRateAmount = $flatRateAmount;
        }     
function setComKey($comKey) {
        $this->comKey = $comKey;
        }        
function setServiceKey($serviceKey) {
        $this->serviceKey = $serviceKey;
        }
function setClubId($clubId) {
        $this->clubId = $clubId;
        }
  
  
function setIdCard1($idCard1) {
        $this->idCard1= $idCard1;
        }  
function setIdCard2($idCard2) {
        $this->idCard2= $idCard2;
        }    
function setIdCard3($idCard3) {
        $this->idCard3= $idCard3;
        }  
function setIdCard4($idCard4) {
        $this->idCard4= $idCard4;
        }  
        
function setHoursProjected1($hoursProjected1) {
        $this->hoursProjected1= $hoursProjected1;
        }          
function setHoursProjected2($hoursProjected2) {
        $this->hoursProjected2= $hoursProjected2;
        }  
function setHoursProjected3($hoursProjected3) {
        $this->hoursProjected3= $hoursProjected3;
        }
function setHoursProjected4($hoursProjected4) {
        $this->hoursProjected4= $hoursProjected4;
        }            
  
function setContinueAdd($continueAdd)  {
         $this->continueAdd = $continueAdd;
         }
  
function setMondayStart1($mondayStart1)  {
         $this->mondayStart1 = $mondayStart1;
         }
function setMondayEnd1($mondayEnd1)  {
         $this->mondayEnd1 = $mondayEnd1;
         }
function setMondayStart2($mondayStart2)  {
         $this->mondayStart2 = $mondayStart2;
         }
function setMondayEnd2($mondayEnd2)  {
         $this->mondayEnd2 = $mondayEnd2;
         }
         
function setTuesdayStart1($tuesdayStart1)  {
         $this->tuesdayStart1 = $tuesdayStart1;
         }
function setTuesdayEnd1($tuesdayEnd1)  {
         $this->tuesdayEnd1 = $tuesdayEnd1;
         }
function setTuesdayStart2($tuesdayStart2)  {
         $this->tuesdayStart2 = $tuesdayStart2;
         }
function setTuesdayEnd2($tuesdayEnd2)  {
         $this->tuesdayEnd2 = $tuesdayEnd2;
         }
         
function setWednesdayStart1($wednesdayStart1)  {
         $this->wednesdayStart1 = $wednesdayStart1;
         }
function setWednesdayEnd1($wednesdayEnd1)  {
         $this->wednesdayEnd1 = $wednesdayEnd1;
         }
function setWednesdayStart2($wednesdayStart2)  {
         $this->wednesdayStart2 = $wednesdayStart2;
         }
function setWednesdayEnd2($wednesdayEnd2)  {
         $this->wednesdayEnd2 = $wednesdayEnd2;
         }
         
function setThursdayStart1($thursdayStart1)  {
         $this->thursdayStart1 = $thursdayStart1;
         }
function setThursdayEnd1($thursdayEnd1)  {
         $this->thursdayEnd1 = $thursdayEnd1;
         }
function setThursdayStart2($thursdayStart2)  {
         $this->thursdayStart2 = $thursdayStart2;
         }
function setThursdayEnd2($thursdayEnd2)  {
         $this->thursdayEnd2 = $thursdayEnd2;
         }
         
function setFridayStart1($fridayStart1)  {
         $this->fridayStart1 = $fridayStart1;
         }
function setFridayEnd1($fridayEnd1)  {
         $this->fridayEnd1 = $fridayEnd1;
         }
function setFridayStart2($fridayStart2)  {
         $this->fridayStart2 = $fridayStart2;
         }
function setFridayEnd2($fridayEnd2)  {
         $this->fridayEnd2 = $fridayEnd2;
         }
         
function setSaturdayStart1($saturdayStart1)  {
         $this->saturdayStart1 = $saturdayStart1;
         }
function setSaturdayEnd1($saturdayEnd1)  {
         $this->saturdayEnd1 = $saturdayEnd1;
         }
function setSaturdayStart2($saturdayStart2)  {
         $this->saturdayStart2 = $saturdayStart2;
         }
function setSaturdayEnd2($saturdayEnd2)  {
         $this->saturdayEnd2 = $saturdayEnd2;
         }
         
function setSundayStart1($sundayStart1)  {
         $this->sundayStart1 = $sundayStart1;
         }
function setSundayEnd1($sundayEnd1)  {
         $this->sundayEnd1 = $sundayEnd1;
         }
function setSundayStart2($sundayStart2)  {
         $this->sundayStart2 = $sundayStart2;
         }
function setSundayEnd2($sundayEnd2)  {
         $this->sundayEnd2 = $sundayEnd2;
         }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//this deletes service types if an employee is deeleted in update mode
function deleteServices($employee_type) {

$dbMain = $this->dbconnect();
$club_id_array = explode("|", $employee_type);
$club_id = $club_id_array[1];

$sql = "DELETE FROM commission_compensation WHERE user_id = ? AND club_id = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->userId, $club_id);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql3");
		   }


}


//=============================================================
//helper insert for employee types
function insertTypeKeys($user_id, $type_key, $comp_type, $comp_amount, $payment_cycle, $id_card, $hours_projected)  {

$dbMain = $this->dbconnect();

$type_key_array = explode("|", $type_key);
$type_key = $type_key_array[0];


$sql = "INSERT INTO basic_compensation VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidsssii', $basicKey, $user_id, $comp_amount, $type_key, $comp_type, $payment_cycle, $id_card, $hours_projected); 

$basicKey = $this->basicKey;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }	

}


//=======================================================================================

//this saves the new user into the database
function saveEmployee()  {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO admin_passwords VALUES (?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iss', $userId, $userName, $passWord); 

$userId = $this->useId; 
$userName = $this->userName; 
$passWord = $this->passWord; 

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		
//get the new user id from the primary key 
$this->userId = $stmt->insert_id;

// now we insert the info into the access level
$sql = "INSERT INTO access_level VALUES (?, ?, ?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $userId, $accessLevel, $empFirstName, $empLastName); 

$userId = $this->userId; 
$accessLevel = '00000';  // make sure to change this if other catagories are added
$empFirstName = $this->empFirstName; 
$empLastName = $this->empLastName;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		
   

//insert record into the main employee  table
$sql = "INSERT INTO employee_info VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issssssissssis', $userId, $empFirstName, $empMiddleName, $empLastName, $empStreet, $empCity, $empState, $empZip, $empPhone1, $empPhone2, $emergencyContact, $emergencyPhone, $socialSecurity, $this->email); 

$userId = $this->userId;
$empFirstName = $this->empFirstName;
$empMiddleName = $this->empMiddleName;
$empLastName = $this->empLastName;
$empStreet = $this->empStreet;
$empCity = $this->empCity;
$empState = $this->empState;
$empZip = $this->empZip;
$empPhone1 = $this->empPhone1;
$empPhone2 = $this->empPhone2;
$emergencyContact = $this->emergencyContact;
$emergencyPhone = $this->emergencyPhone;
$socialSecurity = $this->socialSecurity;

///echo" $userId, $empFirstName, $empMiddleName, $empLastName, $empStreet, $empCity, $empState, $empZip, $empPhone1, $empPhone2, $emergencyContact, $emergencyPhone, $socialSecurity, $this->email)";

/* execute prepared statement */
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

//insert record into the main employee  table
$sql = "INSERT INTO employee_schedule VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiii', $this->userId, $this->mondayStart1, $this->mondayEnd1, $this->mondayStart2, $this->mondayEnd2, $this->tuesdayStart1, $this->tuesdayEnd1, $this->tuesdayStart2, $this->tuesdayEnd2, $this->wednesdayStart1, $this->wednesdayEnd1, $this->wednesdayStart2, $this->wednesdayEnd2, $this->thursdayStart1, $this->thursdayEnd1, $this->thursdayStart2, $this->thursdayEnd2, $this->fridayStart1 , $this->fridayEnd1, $this->fridayStart2,  $this->fridayEnd2 , $this->saturdayStart1, $this->saturdayEnd1, $this->saturdayStart2 , $this->saturdayEnd2 ,  $this->sundayStart1 ,  $this->sundayEnd1,  $this->sundayStart2 ,  $this->sundayEnd2); 
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();		
//now add the employee type info
//if($this->typeKey1 != null)  { 
              $this->insertTypeKeys($this->userId, $this->typeKey1, $this->compensationType1, $this->compensationAmount1, $this->paymentCycle1, $this->idCard1, $this->hoursProjected1);
//}

//if($this->typeKey2 != null)  { 
              $this->insertTypeKeys($this->userId, $this->typeKey2, $this->compensationType2, $this->compensationAmount2, $this->paymentCycle2, $this->idCard2, $this->hoursProjected2);
//}

//if($this->typeKey3 != null)  { 
              $this->insertTypeKeys($this->userId, $this->typeKey3, $this->compensationType3, $this->compensationAmount3, $this->paymentCycle3, $this->idCard3, $this->hoursProjected3);
//}

//if($this->typeKey4 != null)  { 
              $this->insertTypeKeys($this->userId, $this->typeKey4, $this->compensationType4, $this->compensationAmount4, $this->paymentCycle4, $this->idCard4, $this->hoursProjected4);
//}

if($this->continueAdd == "save") {
 $this->confirmation_message = "$empFirstName  $empMiddleName   $empLastName  Successfully Added";
 return($this->confirmation_message);   
}


}

//================================================================================================
function loadEmployee()  {
//echo "test1";
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT monday_shift_start1, monday_shift_end1, monday_shift_start2, monday_shift_end2, tuesday_shift_start1, tuesday_shift_end1, tuesday_shift_start2, tuesday_shift_end2, wednesday_shift_start1, wednesday_shift_end1, wednesday_shift_start2, wednesday_shift_end2, thursday_shift_start1, thursday_shift_end1, thursday_shift_start2, thursday_shift_end2, friday_shift_start1, friday_shift_end1, friday_shift_start2, friday_shift_end2, saturday_shift_start1, saturday_shift_end1, saturday_shift_start2, saturday_shift_end2, sunday_shift_start1, sunday_shift_end1, sunday_shift_start2, sunday_shift_end2 FROM employee_schedule WHERE user_id=  '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->mondayStart1, $this->mondayEnd1, $this->mondayStart2, $this->mondayEnd2, $this->tuesdayStart1, $this->tuesdayEnd1, $this->tuesdayStart2, $this->tuesdayEnd2, $this->wednesdayStart1, $this->wednesdayEnd1, $this->wednesdayStart2, $this->wednesdayEnd2, $this->thursdayStart1, $this->thursdayEnd1, $this->thursdayStart2, $this->thursdayEnd2, $this->fridayStart1 , $this->fridayEnd1, $this->fridayStart2,  $this->fridayEnd2 , $this->saturdayStart1, $this->saturdayEnd1, $this->saturdayStart2 , $this->saturdayEnd2 ,  $this->sundayStart1 ,  $this->sundayEnd1,  $this->sundayStart2 ,  $this->sundayEnd2); 
   $stmt->fetch();
$stmt->close();

   $stmt = $dbMain ->prepare("SELECT * FROM employee_info WHERE user_id = '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($club_id, $emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $emergency_contact, $emergency_phone, $social_security, $this->email); 
   $stmt->fetch();

$this->empFirstName = $emp_fname;
$this->empMiddleName = $emp_mname;
$this->empLastName = $emp_lname;
$this->empStreet = $emp_street;
$this->empCity = $emp_city;
$this->empState = $emp_state;
$this->empZip = $emp_zip;
$this->empPhone1 = $emp_phone1;
$this->empPhone2 = $emp_phone2;
$this->emergencyContact = $emergency_contact;
$this->emergencyPhone = $emergency_phone;
$this->empFullName = "$emp_fname $emp_mname $emp_lname";
$this->socialSecurity = $social_security;

   $stmt = $dbMain ->prepare("SELECT user_name, pass_word FROM admin_passwords WHERE user_id = '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($user_name, $pass_word);
   $stmt->fetch();

$this->userName = $user_name;
$this->passWord = $pass_word;


$stmt = $dbMain ->prepare("SELECT basic_key,  type_key, comp_type, comp_amount, payment_cycle, id_card, hours_projected  FROM basic_compensation WHERE user_id = '$this->userId' ORDER BY basic_key ASC");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($basic_key, $type_key, $comp_type, $comp_amount, $payment_cycle, $id_card, $hours_projected);

           while ($stmt->fetch()) {
                       
                     //this sets the comp_amount to null if it is 0.00 and the id card number to 0 and hours projected to 0
                     if(($comp_amount == "0.00") && ($type_key == null)){
                        $comp_amount = null;
                       }
                       
                      if(($id_card == "0") && ($type_key == null)){
                        $id_card = null;
                       }

                      if(($hours_projected == "0") && ($type_key == null)){
                        $hours_projected = null;
                       }
            
                     $type_keys .= "$type_key|";  
                     $comp_types .= "$comp_type|"; 
                     $comp_amounts .="$comp_amount|";
                     $payment_cycles .="$payment_cycle|";
                     $id_cards .="$id_card|";
                     $hours_projecteds .="$hours_projected|";
                   }
          
                    $typeKeysArray = explode("|", $type_keys);          
                    $this->typeKey1 = $typeKeysArray[0];
                    $this->typeKey2 = $typeKeysArray[1];                    
                    $this->typeKey3 = $typeKeysArray[2];          
                    $this->typeKey4 = $typeKeysArray[3];

                    $compTypesArray = explode("|", $comp_types);          
                    $this->compensationType1 = $compTypesArray[0];
                    $this->compensationType2 = $compTypesArray[1];                    
                    $this->compensationType3 = $compTypesArray[2];          
                    $this->compensationType4 = $compTypesArray[3];                

                    $compAmountsArray = explode("|", $comp_amounts);          
                    $this->compensationAmount1 = $compAmountsArray[0];
                    $this->compensationAmount2 = $compAmountsArray[1];                    
                    $this->compensationAmount3 = $compAmountsArray[2];          
                    $this->compensationAmount4 = $compAmountsArray[3];

                    $paymentCyclesArray = explode("|", $payment_cycles);          
                    $this->paymentCycle1 = $paymentCyclesArray[0];
                    $this->paymentCycle2 = $paymentCyclesArray[1];                    
                    $this->paymentCycle3 = $paymentCyclesArray[2];          
                    $this->paymentCycle4 = $paymentCyclesArray[3];

                    $idCardsArray = explode("|", $id_cards);          
                    $this->idCard1 = $idCardsArray[0];
                    $this->idCard2 = $idCardsArray[1];                    
                    $this->idCard3 = $idCardsArray[2];          
                    $this->idCard4 = $idCardsArray[3];
                    
                    $hoursProjectedArray = explode("|", $hours_projecteds);
                    $this->hoursProjected1 = $hoursProjectedArray[0];
                    $this->hoursProjected2 = $hoursProjectedArray[1];
                    $this->hoursProjected3 = $hoursProjectedArray[2];
                    $this->hoursProjected4 = $hoursProjectedArray[3];
       //echo "test2";             
}
//=================================================================================================
function commissionSaveAll()   {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO commission_compensation VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisidi', $comKey, $userId, $clubId, $serviceKey, $flatRateAmount, $percentAmount); 

$comKey = $this->comKey;
$userId = $this->userId;
$clubId = $this->clubId;
$serviceKey = $this->serviceKey;
$flatRateAmount = $this->flatRateAmount;
$percentAmount = $this->percentAmount;

/* execute prepared statement */
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }	


}

//====================================================================================
//this is used to parse the defaults from the drop down lists when adding an employee who is in sales
function commissionSave()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT  flat_fee, commission_percent FROM service_cost WHERE service_key ='$this->serviceKey'   ORDER BY cost_key ASC");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($flat_rate, $commission_percent); 

         while ($stmt->fetch()) {                                     
                  $commissionDefaultsArray .= "$flat_rate $commission_percent|";
                }
      
      
     $commissionDefaults = explode("|", $commissionDefaultsArray);
     $commissionDefaults1 = $commissionDefaults[0];
     $commissionDefaults2 = $commissionDefaults[1];
     $commissionDefaults3 = $commissionDefaults[2];
     $commissionDefaults4 = $commissionDefaults[3];
     
      $payTypeDefaults1 = explode(" ",  $commissionDefaults1);  
      $this->flatRateAmount =  $payTypeDefaults1[0];
      $this->percentAmount = $payTypeDefaults1[1];
      $this->commissionSaveAll(); 

      $payTypeDefaults2 = explode(" ",  $commissionDefaults2);  
      $this->flatRateAmount =  $payTypeDefaults2[0];
      $this->percentAmount = $payTypeDefaults2[1];
      $this->commissionSaveAll();     
      
      $payTypeDefaults3 = explode(" ",  $commissionDefaults3);  
      $this->flatRateAmount =  $payTypeDefaults3[0];
      $this->percentAmount = $payTypeDefaults3[1];
      $this->commissionSaveAll();        
      
      $payTypeDefaults4 = explode(" ",  $commissionDefaults4);  
      $this->flatRateAmount =  $payTypeDefaults4[0];
      $this->percentAmount = $payTypeDefaults4[1];
      $this->commissionSaveAll();           
      


      
return "$commissionDefaultsArray";      
      
}

//=================================================================================================
function deleteEmployee()   {
//echo"$this->userId";
//exit;
$dbMain = $this->dbconnect();

//insert the data into the employee archives in case it is needed later
//first get the deletion date and the employee info
$deletion_date = date('Y-m-d');
$stmt = $dbMain ->prepare("SELECT * FROM employee_info WHERE user_id = '$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_id, $emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $emergency_contact, $emergency_phone, $social_security); 
$stmt->fetch();
   
$sql = "INSERT INTO employee_archives VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issssssisssss', $user_id, $emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $emergency_contact, $emergency_phone, $deletion_date); 
$stmt->execute();
$stmt->close();



$sql1 = "DELETE FROM employee_info WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql1))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql1");
		   }
$sql1 = "DELETE FROM employee_schedule WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql1))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql1");
		   }
		    
$sql2 = "DELETE FROM basic_compensation WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql2))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql2");
		   }
		   
$sql3 = "DELETE FROM commission_compensation WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql3))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql3");
		   }

$sql4 = "DELETE FROM admin_passwords WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql4))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql4");
		   }

$sql5 = "DELETE FROM access_level WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql5))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql5");
		   }
		   
$sql6 = "DELETE FROM employee_photo WHERE user_id = ?";
		
		if ($stmt = $dbMain->prepare($sql6))   {
			$stmt->bind_param("i", $this->userId);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql6");
		   }		   


 $this->confirmation_message = "Employee $this->empFullName Successfully Deleted";
 return($this->confirmation_message);

}

//==================================================================================================
function updateBasic($basicKey, $typeKey, $compType, $compAmount, $payCycle, $idCard, $hoursProjected) {

//echo"$basicKey, $typeKey, $compType, $compAmount, $payCycle<br>";


$typeKeyArray = explode("|", $typeKey);
$typeKey =$typeKeyArray[0];

$dbMain = $this->dbconnect();
$userId = $this->userId;
 
$sql = "UPDATE basic_compensation SET type_key= ?, comp_type= ?, comp_amount= ?, payment_cycle=?, id_card=?, hours_projected=? WHERE  user_id= ? AND basic_key= ?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssdsiiii', $typeKey, $compType, $compAmount, $payCycle, $idCard, $hoursProjected, $userId, $basicKey);

		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		

$stmt->close();

}
//==================================================================================================
function updateEmployee()     {
//echo "test";
$dbMain = $this->dbconnect();

//echo"$this->mondayStart1, $this->mondayEnd1, $this->mondayStart2, $this->mondayEnd2, $this->tuesdayStart1, $this->tuesdayEnd1, $this->tuesdayStart2, $this->tuesdayEnd2, $this->wednesdayStart1, $this->wednesdayEnd1, $this->wednesdayStart2, $this->wednesdayEnd2, $this->thursdayStart1, $this->thursdayEnd1, $this->thursdayStart2, $this->thursdayEnd2, $this->fridayStart1 , $this->fridayEnd1, $this->fridayStart2,  $this->fridayEnd2 , $this->saturdayStart1, $this->saturdayEnd1, $this->saturdayStart2 , $this->saturdayEnd2 ,  $this->sundayStart1 ,  $this->sundayEnd1,  $this->sundayStart2 ,  $this->sundayEnd2, $this->userId";

$sql = "UPDATE employee_schedule SET monday_shift_start1=?, monday_shift_end1=?, monday_shift_start2=?, monday_shift_end2=?, tuesday_shift_start1=?, tuesday_shift_end1=?, tuesday_shift_start2=?, tuesday_shift_end2=?, wednesday_shift_start1=?, wednesday_shift_end1=?, wednesday_shift_start2=?, wednesday_shift_end2=?, thursday_shift_start1=?, thursday_shift_end1=?, thursday_shift_start2=?, thursday_shift_end2=?, friday_shift_start1=?, friday_shift_end1=?, friday_shift_start2=?, friday_shift_end2=?, saturday_shift_start1=?, saturday_shift_end1=?, saturday_shift_start2=?, saturday_shift_end2=?, sunday_shift_start1=?, sunday_shift_end1=?, sunday_shift_start2=?, sunday_shift_end2=? WHERE user_id= ?";
						
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiii', $this->mondayStart1, $this->mondayEnd1, $this->mondayStart2, $this->mondayEnd2, $this->tuesdayStart1, $this->tuesdayEnd1, $this->tuesdayStart2, $this->tuesdayEnd2, $this->wednesdayStart1, $this->wednesdayEnd1, $this->wednesdayStart2, $this->wednesdayEnd2, $this->thursdayStart1, $this->thursdayEnd1, $this->thursdayStart2, $this->thursdayEnd2, $this->fridayStart1 , $this->fridayEnd1, $this->fridayStart2,  $this->fridayEnd2 , $this->saturdayStart1, $this->saturdayEnd1, $this->saturdayStart2 , $this->saturdayEnd2 ,  $this->sundayStart1 ,  $this->sundayEnd1,  $this->sundayStart2 ,  $this->sundayEnd2, $this->userId);	
if(!$stmt->execute())  {
	     printf("Error: update schedule%s.\n", $stmt->error);
          }		
$stmt->close();
//echo "test2";

$sql = "UPDATE employee_info SET emp_fname= ?, emp_mname =?, emp_lname= ?, emp_street= ?, emp_city= ?, emp_state= ?, emp_zip= ?, emp_phone1= ?, emp_phone2= ?, emergency_contact= ?, emergency_phone= ?, social_security= ?, email= ? WHERE user_id= ?";
						
		$stmt = $dbMain->prepare($sql);
		$stmt->bind_param('ssssssissssisi', $empFirstName, $empMiddleName, $empLastName, $empStreet, $empCity, $empState, $empZip, $empPhone1,$empPhone2, $emergencyContact, $emergencyPhone, $socialSecurity, $this->email, $userId);	
				
		 $empFirstName = $this->empFirstName;
		 $empMiddleName = $this->empMiddleName;
		 $empLastName = $this->empLastName; 
		 $empStreet = $this->empStreet;
		 $empCity = $this->empCity; 
		 $empState = $this->empState;
		 $empZip = $this->empZip;
		 $empPhone1 = $this->empPhone1;
		 $empPhone2 = $this->empPhone2;
		 $emergencyContact = $this->emergencyContact; 
		 $emergencyPhone = $this->emergencyPhone; 
		 $socialSecurity = $this->socialSecurity;
		 $userId = $this->userId;
		
		
		if(!$stmt->execute())  {
	     printf("Error: %s.update info\n", $stmt->error);
          }		
   
   $sql = "UPDATE admin_passwords SET user_name= ?, pass_word =? WHERE user_id = ?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ssi' , $userName, $passWord, $userId);
   
   $userName = $this->userName;
   $passWord = $this->passWord;
   
  		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		 
   
   
  $sql = "UPDATE access_level SET first_name= ?, last_name =? WHERE user_id = ?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ssi' , $empFirstName, $empLastName, $userId);
   
  		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		  
   
   
   
   
   $stmt = $dbMain ->prepare("SELECT basic_key FROM basic_compensation WHERE user_id = '$userId' ORDER BY basic_key ASC");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($basic_key);
   
   while ($stmt->fetch()) {
            $keys .="$basic_key|";   
             }
   
 //  echo"$keys";
   
    $keyArray = explode("|", $keys); 
    $basicKey1 = $keyArray[0];
    $basicKey2 = $keyArray[1];
    $basicKey3 = $keyArray[2];
    $basicKey4 = $keyArray[3];
   
   $this->updateBasic($basicKey1,  $this->typeKey1, $this->compensationType1, $this->compensationAmount1, $this->paymentCycle1, $this->idCard1, $this->hoursProjected1);
   $this->updateBasic($basicKey2,  $this->typeKey2, $this->compensationType2, $this->compensationAmount2, $this->paymentCycle2, $this->idCard2, $this->hoursProjected2);
   $this->updateBasic($basicKey3,  $this->typeKey3, $this->compensationType3, $this->compensationAmount3, $this->paymentCycle3, $this->idCard3, $this->hoursProjected3);
   $this->updateBasic($basicKey4,  $this->typeKey4, $this->compensationType4, $this->compensationAmount4, $this->paymentCycle4, $this->idCard4, $this->hoursProjected4);
   
   
$stmt->close();


 
 $this->confirmation_message = "$this->empFirstName  $this->empMiddleName   $this->empLastName Successfully Updated";
 return($this->confirmation_message);

}

//==================================================================================================
function updateEmployeeCommissions($comKey)   {

$dbMain = $this->dbconnect();

$sql = "UPDATE commission_compensation SET  flat_fee=?, commission_percent=? WHERE user_id= ? AND service_key=? AND com_key =?";

   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('diiii' , $flatFee, $percentAmount, $userId, $serviceKey, $comKey);
   $flatFee = $this->flatRateAmount;
   $percentAmount = $this->percentAmount;
   $userId = $this->userId;
   $serviceKey = $this->serviceKey;
   
 //  echo"$flatFee |  $percentAmount  |  $userId  |$serviceKey <br>";
   
	if(!$stmt->execute())  {
	    printf("Error: %s.\n", $stmt->error);
       }		
}
//========================================================================
function getComKey() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT com_key FROM commission_compensation WHERE user_id = '$this->userId'  AND service_key = '$this->serviceKey' ORDER BY com_key ASC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($com_key);

$stmt->fetch();

return"$com_key";

}

//========================================================================
 function deleteEmployeeCommissions($service_key)  {

$dbMain = $this->dbconnect();

$sql = "DELETE FROM commission_compensation WHERE user_id = ? AND service_key = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->userId, $service_key);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql3");
		   }

}
//========================================================================

function getUserId() {
 return($this->userId);
}

function getEmpFirstName() {
 return($this->empFirstName);
}

function getEmpMiddleName() {
 return($this->empMiddleName);
}

function getEmpLastName() {
 return($this->empLastName);
}

function getEmpStreet() {
 return($this->empStreet);
}

function getEmpCity() {
 return($this->empCity);
}

function getEmpState() {
 return($this->empState);
}

function getEmpZip() {
 return($this->empZip);
}

function getEmpPhone1() {
 return($this->empPhone1);
}

function getEmpPhone2() {
 return($this->empPhone2);
}

function getEmergencyContact() {
return($this->emergencyContact);
}

function getEmergencyPhone() {
return($this->emergencyPhone);
}

function getUserName() {
 return($this->userName);
}

function getPassWord() {
 return($this->passWord);
}

function getSocialSecurity() {
 return($this->socialSecurity);
}

function getEmail() {
 return($this->email);
}

function getEmpFullName() {
return($this->empFullName);
}

function getTypeKey1() {
return($this->typeKey1);
}

function getTypeKey2() {
return($this->typeKey2);
}

function getTypeKey3() {
return($this->typeKey3);
}

function getTypeKey4() {
return($this->typeKey4);
}

function getCompensationType1() {
return($this->compensationType1);
}

function getCompensationType2() {
return($this->compensationType2);
}

function getCompensationType3() {
return($this->compensationType3);
}

function getCompensationType4() {
return($this->compensationType4);
}

function getCompensationAmount1() {
return($this->compensationAmount1);
}

function getCompensationAmount2() {
return($this->compensationAmount2);
}

function getCompensationAmount3() {
return($this->compensationAmount3);
}

function getCompensationAmount4() {
return($this->compensationAmount4);
}

function getPaymentCycle1() {
return($this->paymentCycle1);
}

function getPaymentCycle2() {
return($this->paymentCycle2);
}

function getPaymentCycle3() {
return($this->paymentCycle3);
}

function getPaymentCycle4() {
return($this->paymentCycle4);
}


function getIdCard1() {
return($this->idCard1);
}
function getIdCard2() {
return($this->idCard2);
}
function getIdCard3() {
return($this->idCard3);
}
function getIdCard4() {
return($this->idCard4);
}

function getHoursProjected1() {
return($this->hoursProjected1);
}
function getHoursProjected2() {
return($this->hoursProjected2);
}
function getHoursProjected3() {
return($this->hoursProjected3);
}
function getHoursProjected4() {
return($this->hoursProjected4);
}

function getConfirmation() {
 $this->confirmation_message = "Employee $this->empFullName Successfully Updated";
 return($this->confirmation_message);
}
function getMondayStart1()  {
         return($this->mondayStart1);
         }
function getMondayEnd1()  {
         return($this->mondayEnd1);
         }
function getMondayStart2()  {
         return($this->mondayStart2);
         }
function getMondayEnd2()  {
         return($this->mondayEnd2);
         }
         
function getTuesdayStart1()  {
         return($this->tuesdayStart1);
         }
function getTuesdayEnd1()  {
         return($this->tuesdayEnd1);
         }
function getTuesdayStart2()  {
         return($this->tuesdayStart2);
         }
function getTuesdayEnd2()  {
         return($this->tuesdayEnd2);
         }
         
function getWednesdayStart1()  {
         return($this->wednesdayStart1);
         }
function getWednesdayEnd1()  {
         return($this->wednesdayEnd1);
         }
function getWednesdayStart2()  {
         return($this->wednesdayStart2);
         }
function getWednesdayEnd2()  {
         return($this->wednesdayEnd2);
         }
         
function getThursdayStart1()  {
         return($this->thursdayStart1);
         }
function getThursdayEnd1()  {
         return($this->thursdayEnd1);
         }
function getThursdayStart2()  {
         return($this->thursdayStart2);
         }
function getThursdayEnd2()  {
         return($this->thursdayEnd2);
         }
         
function getFridayStart1()  {
         return($this->fridayStart1);
         }
function getFridayEnd1()  {
         return($this->fridayEnd1);
         }
function getFridayStart2()  {
         return($this->fridayStart2);
         }
function getFridayEnd2()  {
         return($this->fridayEnd2);
         }
         
function getSaturdayStart1()  {
         return($this->saturdayStart1);
         }
function getSaturdayEnd1()  {
         return($this->saturdayEnd1);
         }
function getSaturdayStart2()  {
         return($this->saturdayStart2);
         }
function getSaturdayEnd2()  {
         return($this->saturdayEnd2);
         }
         
function getSundayStart1()  {
         return($this->sundayStart1);
         }
function getSundayEnd1()  {
         return($this->sundayEnd1);
         }
function getSundayStart2()  {
         return($this->sundayStart2);
         }
function getSundayEnd2()  {
         return($this->sundayEnd2);
         }

}
?>