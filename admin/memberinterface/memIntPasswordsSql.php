<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memIntPasswordsSql {

private $serviceLocation = null;
private $usrName = null;
private $passWord = null;

function setServiceLocation($serviceLocation) {
          $this->serviceLocation = $serviceLocation;
          }
function setUsrName($usrName) {
          $this->usrName = $usrName;
          }
function setPassWord($passWord) {
          $this->passWord = $passWord;
          }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------
function loadUserPass() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_name, pass_word FROM interface_passwords WHERE  location_id ='$this->serviceLocation'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($usrName, $passWord);         
             $stmt->fetch(); 
             $rowCount = $stmt->num_rows;
            
             if($rowCount == 0)  {
                $user_pass = "NA|NA";             
                }else{
                $user_pass = "$usrName|$passWord";
                }
               
               return $user_pass;
               
               
             $stmt->close(); 


}
//--------------------------------------------------------------------------
function updateInsertPassWords() {


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM interface_passwords WHERE  location_id ='$this->serviceLocation'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($count);         
             $stmt->fetch(); 
             $stmt->close(); 

        if($count == 0) {
        
              $sql = "INSERT INTO interface_passwords VALUES (?, ?, ?)";
              $stmt = $dbMain->prepare($sql);
              $stmt->bind_param('iss', $locationId, $usrName, $passWord);
              $locationId = $this->serviceLocation;
              $usrName = $this->usrName;
              $passWord = $this->passWord;
              
              if(!$stmt->execute())  {
	             $nameBit = 3;	  
	             printf("Error: %s.\n", $stmt->error);
                 }else{
                 $nameBit = 2;                 
                 }
                 
                $stmt->close(); 
                return $nameBit;
                                      
           }else{
           
             $sql = "UPDATE interface_passwords SET user_name =?, pass_word =? WHERE location_id = ?";
             $stmt = $dbMain->prepare($sql);
             $stmt->bind_param('ssi' , $usrName, $passWord, $locationId);              
             $usrName = $this->usrName;
             $passWord = $this->passWord;  
             $locationId = $this->serviceLocation;
             
             if(!$stmt->execute())  {
	             $nameBit = 3;	     
	             printf("Error: %s.\n", $stmt->error );
                 }else{
                 $nameBit = 2;                 
                 }
                 
                $stmt->close(); 
                return $nameBit;             
                          
           }


}
//--------------------------------------------------------------------------
function checkUsrName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(user_name) AS name_count FROM interface_passwords WHERE  location_id !='$this->serviceLocation' AND user_name ='$this->usrName'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($name_count);         
             $stmt->fetch();   
             
             if($name_count > 0) {
                $nameBit = 1;
                return $nameBit;
               }else{
                $nameBit = $this->updateInsertPassWords();
                return $nameBit;
               }
                          
             $stmt->close();             

}
//--------------------------------------------------------------------------



}
$service_location = $_REQUEST['service_location'];
$usr_name = $_REQUEST['usr_name'];
$pass_word = $_REQUEST['pass_word'];
$ajax_bit = $_REQUEST['ajax_bit'];

$parsePasswords = new memIntPasswordsSql();
$parsePasswords-> setServiceLocation($service_location);
$parsePasswords-> setUsrName($usr_name);
$parsePasswords-> setPassWord($pass_word);


//this grabs the user name and password 
if($ajax_bit == 1) {
   $user_pass = $parsePasswords-> loadUserPass();
   echo"$user_pass";
   exit;
  }

//this updates the interface passwords
if($ajax_bit == 2) {
   $insert_bit = $parsePasswords-> checkUsrName();
   echo"$insert_bit";
   exit;
  }








?>