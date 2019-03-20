<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class checkInListingsSql {

private $serviceLocation = null;
private $listNumber = null;


function setServiceLocation($serviceLocation) {
          $this->serviceLocation = $serviceLocation;
          }
function setListNumber($listNumber) {
          $this->listNumber = $listNumber;
          }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------
function loadListNumber() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT listings_number FROM check_in_history WHERE  location_id ='$this->serviceLocation'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($listingsNumber);         
             $stmt->fetch(); 
             $rowCount = $stmt->num_rows;
            
             if($rowCount == 0)  {
                $listNumber = '0';             
                }else{
                $listNumber = $listingsNumber;
                }
               
               return $listNumber;
               
               
             $stmt->close(); 


}
//--------------------------------------------------------------------------
function updateInsertListNumber() {


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM check_in_history WHERE  location_id ='$this->serviceLocation'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($count);         
             $stmt->fetch(); 
             $stmt->close(); 

        if($count == 0) {
        
              $sql = "INSERT INTO check_in_history VALUES (?, ?)";
              $stmt = $dbMain->prepare($sql);
              $stmt->bind_param('ii', $locationId, $listNum);
              $locationId = $this->serviceLocation;
              $listNum = $this->listNumber;
              
              if(!$stmt->execute())  {
	             $listBit = 2;	  
	             printf("Error: %s.\n", $stmt->error);
                 }else{
                 $listBit = 1;                 
                 }
                 
                $stmt->close(); 
                return $listBit;
                                      
           }else{
           
             $sql = "UPDATE check_in_history SET listings_number =? WHERE location_id = ?";
             $stmt = $dbMain->prepare($sql);
             $stmt->bind_param('ii' , $listNum, $locationId);              
 
             $locationId = $this->serviceLocation;
             $listNum = $this->listNumber;
             
             if(!$stmt->execute())  {
	             $listBit = 2;	     
	             printf("Error: %s.\n", $stmt->error );
                 }else{
                 $listBit = 1;                 
                 }
                 
                $stmt->close(); 
                return $listBit;             
                          
           }


}
//--------------------------------------------------------------------------




}

$service_location = $_REQUEST['service_location'];
$list_number = $_REQUEST['list_number'];
$ajax_bit = $_REQUEST['ajax_bit'];


$parseCheckHistory = new checkInListingsSql();
$parseCheckHistory-> setServiceLocation($service_location);
$parseCheckHistory-> setListNumber($list_number);



//this grabs the user name and password 
if($ajax_bit == 1) {
   $list_num = $parseCheckHistory-> loadListNumber();
   echo"$list_num";
   exit;
  }

//this updates the interface passwords
if($ajax_bit == 2) {
   $insert_bit = $parseCheckHistory-> updateInsertListNumber();
   echo"$insert_bit";
   exit;
  }








?>