<?php
session_start();
class  newsSql{




function setFirstName($firstName) {
          $this->firstName = $firstName;
          }
function setLastName($lastName) {
          $this->lastName = $lastName;
          }
function setEmail($email) {
          $this->email = $email;
          }                  



//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------------------------------
function registerNews() {


$dbMain = $this->dbconnect();



$stmt = $dbMain ->prepare("SELECT count(*) FROM website_newsletter_subscriptions WHERE email LIKE '%$this->email%' AND first_name LIKE '%$this->firstName%' AND last_name LIKE '%$this->lastName%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

//echo "$this->email  %$this->firstName%' AND last_name LIKE '%$this->lastName";
//exit;
$news_id = "";
if($count == 0){
$sql = "INSERT INTO website_newsletter_subscriptions VALUES (?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $news_id, $this->firstName, $this->lastName, $this->email);   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }	
$stmt->close(); 

return 1;
}else{
    return 99;
}

}
//-------------------------------------------------------------------------------------------------------------------
function unsubscribe() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) FROM website_newsletter_subscriptions WHERE email LIKE '%$this->email%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();


if($count > 0){
$sql = "DELETE FROM website_newsletter_subscriptions WHERE email LIKE '%$this->email%'";
$stmt = $dbMain->prepare($sql);
if(!$stmt->execute())  {	                  
	   printf("Error: %s.\n", $stmt->error );
      }             
$stmt->close(); 

return 1;
}else{
    return 99;
}


}
//======================================================================================


    
}
//--------------------------------------------------------------------------------------

$first_name = $_REQUEST['first_name'];
$email = $_REQUEST['email'];
$last_name = $_REQUEST['last_name'];
$ajax_switch = $_REQUEST['ajax_switch'];
                


if($ajax_switch == 1) {

$register = new newsSql();
$register-> setFirstName($first_name);
$register-> setLastName($last_name);
$register-> setEmail($email);
$result1 = $register-> registerNews();
echo"$result1";
exit;
}
//==============================
if($ajax_switch == 2) {

$cancel = new newsSql();
$cancel-> setFirstName($first_name);
$cancel-> setLastName($last_name);
$cancel-> setEmail($email);
$result2 = $cancel-> unsubscribe();

echo"$result2";
exit;
}









?>