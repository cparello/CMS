<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  userSql{

private $userId = null;
private $firstName;
private $lastName;
private $userName;
private $passWord;
private $accessLevel;


function setUserId($userId) {
        $this->user_id = $userId;
         }

function setFirstName($firstName)  {
		$this->first_name = $firstName;
		  }

function setLastName($lastName)  {
		$this->last_name = $lastName;
		  }

function setUserName($userName)  {
		$this->user_name = $userName;
		  }
		  
function setPassWord($passWord)  {
		$this->pass_word = $passWord;
		  }		  

function setAccessLevel($accessLevel)  {
		$this->access_level = $accessLevel;
		  }		   
function setBilling($billing){$this->billing = $billing;}
function  setCheck($checkIn){$this->checkIn = $checkIn;}
function  setMember($memInt){$this->memInt = $memInt;}
function  setSales($sales){$this->sales = $sales;}
function  setAdmin($admin){$this->admin = $admin;}
function  setSchedule($schedule){$this->schedule = $schedule;}
//connect to database
function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------
function checkEmployeeStatus() {

$dbMain = $this->dbconnect();
$result1 = $dbMain ->prepare("SELECT COUNT(*) AS count FROM employee_info WHERE user_id ='$this->user_id'");
$result1->execute();      
$result1->store_result(); 
$result1-> bind_result($count);
                 $result1->fetch();
                            if($count != 0) {
                               return true;
                              }
}
//-----------------------------------------------------------------------------------------
//this saves the new user into the database
function saveUser()  {

//create a confirmation message for errors
$this->confirmation_message = "There was an error saving this User";

$dbMain = $this->dbconnect();
//insert record into the password table
$sql = "INSERT INTO admin_passwords VALUES (?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iss', $userId, $userName, $passWord); 

$userId = $this->user_id; 
$userName = $this->user_name; 
$passWord = $this->pass_word; 

/* execute prepared statement */
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		
//get the new user id from the primary key 
$this->user_id = $stmt->insert_id;

//------------------------------------------------------------------------------------
// now we insert the info into the access level
$sql = "INSERT INTO access_level VALUES (?, ?, ?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $userId, $accessLevel, $firstName, $lastName); 

$userId = $this->user_id; 
$accessLevel = $this->access_level; 
$firstName = $this->first_name; 
$lastName = $this->last_name;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		
   
 $stmt->close();  
 
 $sql = "INSERT INTO access_app VALUES (?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issssss', $userId, $this->checkIn, $this->memInt, $this->sales, $this->admin,  $this->schedule, $this->billing); 

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		
   
 $stmt->close();  
 
 $this->confirmation_message = "User $firstName $lastName  Successfully Added";
 return($this->confirmation_message);
}

//=================================================================================================
function deleteUser()   {

$dbMain = $this->dbconnect();
$firstName = $this->first_name; 
$lastName = $this->last_name;
$user_id = $this->user_id;

//this checks to see if the person is an employee and if is then sets the records to null insted of deleting
$empMarker = $this->checkEmployeeStatus();

if($empMarker == true)  { 

$userName = null;
$passWord = null;
$filePerm = null;
$firstName = null;
$lastName = null;

$blank = null;

   $sql = "UPDATE admin_passwords SET user_name=?, pass_word =? WHERE user_id = ?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ssi' , $userName, $passWord, $user_id);
   
  		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		 

   $sql2 = "UPDATE access_level SET file_perm=?, first_name =?, last_name=? WHERE user_id =?";
   $stmt = $dbMain->prepare($sql2);
   $stmt->bind_param('sssi' , $filePerm, $firstName, $lastName, $user_id);
   
  		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }	
  $sql2 = "UPDATE access_app SET check_in= ?, mem_int= ?, admin= ?, sales= ?, sales_schedule= ?, billing= ? WHERE user_id= ?";
   $stmt = $dbMain->prepare($sql2);
   $stmt->bind_param('ssssss' , $blank, $blank, $blank, $blank, $blank, $blank, $user_id);
   
  		if(!$stmt->execute())  {
	     printf("Error: %s.\n", $stmt->error);
          }		 
		
}else{	

$sql = "DELETE FROM admin_passwords WHERE user_id = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $this->user_id);
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

$sql2 = "DELETE FROM access_level WHERE user_id = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql2)) {
			$stmt->bind_param("i", $this->user_id);
			$stmt->execute();	
			$stmt->close();
		   }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }
$sql = "DELETE FROM access_app WHERE user_id = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $this->user_id);
			$stmt->execute();
			$stmt->close();
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		}

}
 $this->confirmation_message = "User $firstName $lastName  Successfully Deleted";
 return($this->confirmation_message);

}

//==================================================================================================
function updateUser()     {

//create a confirmation message for errors
$this->confirmation_message = "There was an error saving this User";

$dbMain = $this->dbconnect();


$sql = "UPDATE admin_passwords SET user_name= ?, pass_word=? WHERE user_id= ?";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('ssi',$userName, $passWord, $userId	);						

$userId = $this->user_id; 
$userName = $this->user_name; 
$passWord = $this->pass_word; 

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		

//----------------------------------------------------------------------------------------------------------------------------------------------------

$sql2 = "UPDATE access_level SET file_perm= ?, first_name= ?, last_name= ? WHERE user_id= ?";
						
		$stmt = $dbMain->prepare($sql2);
		echo($dbMain->error);
		$stmt->bind_param('sssi',$accessLevel, $firstName, $lastName,	$userId);						

$accessLevel = $this->access_level; 
$firstName = $this->first_name; 
$lastName = $this->last_name;
$userId = $this->user_id;

if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }		

$result1 = $dbMain ->prepare("SELECT COUNT(*) AS count FROM access_app WHERE user_id ='$this->user_id'");
$result1->execute();      
$result1->store_result(); 
$result1-> bind_result($count);
$result1->fetch();
$result1->close();
if($count == 0){
     $sql = "INSERT INTO access_app VALUES (?,?,?,?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('issssss', $this->user_id, $this->checkIn, $this->memInt, $this->sales, $this->admin,  $this->schedule, $this->billing); 
    
    if(!$stmt->execute())  {
        return($this->confirmation_message);
    	printf("Error: %s.\n", $stmt->error);
       }		
       
     $stmt->close();  
}else{
    $sql2 = "UPDATE access_app SET check_in= ?, mem_int= ?, admin= ?, sales= ?, sales_schedule= ?, billing= ? WHERE user_id= ?";
						
$stmt = $dbMain->prepare($sql2);
echo($dbMain->error);
$stmt->bind_param('ssssssi',$this->checkIn, $this->memInt, $this->admin, $this->sales, $this->schedule, $this->billing,	$this->user_id);					
if(!$stmt->execute())  {
    return($this->confirmation_message);
	printf("Error: %s.\n", $stmt->error);
   }	
}
	

 $this->confirmation_message = "User $firstName $lastName  Successfully Updated";
 return($this->confirmation_message);

}

//==================================================================================================

}
?>