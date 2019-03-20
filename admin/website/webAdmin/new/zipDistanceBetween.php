<?php

class zipFinder {


//-------------------------------------             
//connect to database
function dbconnect()   {
require"../../../dbConnect.php";
return $dbMain;              
}
//================================
//connect to database
function dbconnectOne()   {
require"../../../dbConnectOne.php";
return $dbMainOne;              
}
//====================================
function setUserZip($user_zip){
    $this->firstzip = $user_zip;
}
function setMiles($miles){
    $this->miles = $miles;
}
function setOption($option){
    $this->option = $option;
}
//-------------------------------------
function degreesDifference()
{
    $theta = $this->lon1 - $this->lon2;
    $dist = sin(deg2rad($this->lat1)) * sin(deg2rad($this->lat2)) +
            cos(deg2rad($this->lat1)) * cos(deg2rad($this->lat2)) *
            cos(deg2rad($theta));

    $dist = acos($dist);
    $dist = rad2deg($dist);

    $this->distance = sprintf("%01.2f", $dist * 60 * 1.1515);

}
//===================================================================
function differenceBetween(){
    $dbMainOne = $this->dbconnectOne();
    
    $stmt999 = $dbMainOne ->prepare("SELECT lat, lon FROM website_zipgeo WHERE zip5 = '$this->firstzip'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($this->lat1, $this->lon1);
    $stmt999->fetch();
    $stmt999->close();  
    
    $stmt999 = $dbMainOne ->prepare("SELECT lat, lon FROM website_zipgeo WHERE zip5 = '$this->secondzip'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($this->lat2, $this->lon2);
    $stmt999->fetch();
    $stmt999->close();  

    $this->degreesDifference();
}
//=========================================================================
function getZipsWithin(){
    
    $dbMainOne = $this->dbconnectOne();
    
    $milesperdegree = 69;
    $degreesdiff = $this->miles / $milesperdegree;
    
    $stmt999 = $dbMainOne ->prepare("SELECT lat, lon FROM website_zipgeo WHERE zip5 = '$this->firstzip'");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($this->lat, $this->lon);
    $stmt999->fetch();
    $stmt999->close();  

    $lat1 = $this->lat - $degreesdiff;
    $lat2 = $this->lat + $degreesdiff;
    $lon1 = $this->lon - $degreesdiff;
    $lon2 = $this->lon + $degreesdiff;
    
    $stmt999 = $dbMainOne ->prepare("SELECT zip5 FROM website_zipgeo WHERE (lat between '$lat1' and '$lat2') and (lon between '$lon1' and '$lon2')");
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($zip);
    while($stmt999->fetch()){
        $dbMain = $this->dbconnect();
        $stmt = $dbMain ->prepare("SELECT club_zip FROM website_locations_setup WHERE club_zip = '$zip'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($club_zip);
        $stmt->fetch();
        $stmt->close();   
        
        if ($club_zip == $zip){
            $stmt = $dbMain ->prepare("SELECT club_name FROM website_locations_setup WHERE club_zip = '$club_zip'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($clubName);
            $stmt->fetch();
            $stmt->close();   
            
            $stmt = $dbMain ->prepare("SELECT club_id, club_address FROM club_info WHERE club_name = '$clubName'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($clubId, $clubAddress);
            $stmt->fetch();
            $stmt->close();     
            
            $stmt = $dbMainOne ->prepare("SELECT city FROM website_zipgeo WHERE zip5 = '$club_zip'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($city);
            $stmt->fetch();
            $stmt->close(); 
            
            $this->secondzip = $club_zip;
            $this->differenceBetween();
            
            if(trim($zip) !=""){
                $zipArray .= "$zip:$clubName:$clubId:$city:$this->distance:$clubAddress~";
            }
            
        }
    
        
        $club_zip = "";
        $zip = "";
    }
    $stmt999->close();  
    //echo "fubar";
    $this->zips = trim($zipArray);
}
//==================================================================
function loadZipOptions()  {
$this->closestMiles == "";
   
   switch($this->option) {
    case 'C':
    
        $dbMain = $this->dbconnect();
        $stmt999 = $dbMain ->prepare("SELECT club_zip FROM website_locations_setup WHERE club_name != ''");
        $stmt999->execute();      
        $stmt999->store_result();      
        $stmt999->bind_result($this->secondzip);
        while($stmt999->fetch()){
            //echo"fubar";
            $this->differenceBetween();
            if($this->closestMiles > $this->distance OR $this->closestMiles == ""){
                $this->closestMiles = $this->distance;
                $this->closestZip = $this->secondzip;
            }
            
            $this->secondzip = "";
            $this->distance ="";
        }
        $stmt999->close();
        
        $stmt = $dbMain ->prepare("SELECT club_name FROM website_locations_setup WHERE club_zip = '$this->closestZip'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->clubName);
        $stmt->fetch();
        $stmt->close();   
        
        $stmt = $dbMain ->prepare("SELECT club_id, club_address FROM club_info WHERE club_name = '$this->clubName'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->clubId, $this->clubAddress);
        $stmt->fetch();
        $stmt->close();  
        
        $dbMainOne = $this->dbconnectOne();
        $stmt = $dbMainOne ->prepare("SELECT city FROM website_zipgeo WHERE zip5 = '$this->closestZip'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($this->city);
        $stmt->fetch();
        $stmt->close();    
    break;
    case 'R':
         $this->getZipsWithin();
    break;
   }   


}

//==================================================================
function getZipsList() {
          return($this->zips);
          }
function getClosestCity() {
          return($this->city);
          }
function getClosestZip() {
          return($this->closestZip);
          }
function getClosestMiles() {
          return($this->closestMiles);
          }
function getClosestClubName() {
          return($this->clubName);
          }
function getClosestClubId() {
          return($this->clubId);
          }
function getClosestAddress() {
          return($this->clubAddress);
          }          
         
}
//--------------------------------------------------------------------------------------------------------------------------

$user_zip = $_REQUEST['zipcode'];
$miles = $_REQUEST['miles'];
$option = $_REQUEST['option'];
//echo "zip $user_zip";
//exit;
$load_history = new zipFinder();
$load_history->setUserZip($user_zip);
$load_history->setMiles($miles);
$load_history->setOption($option);
$load_history->loadZipOptions();
$zipsList = $load_history-> getZipsList();
$closestZip = $load_history-> getClosestZip();
$closestMiles = $load_history-> getClosestMiles();
$closestClubName = $load_history-> getClosestClubName();
$closestClubId = $load_history-> getClosestClubId();
$closestCity = $load_history-> getClosestCity();
$closestAddress = $load_history-> getClosestAddress();
 switch($option) {
    case 'C':
        echo "$option|$closestZip|$closestMiles|$closestClubName|$closestClubId|$closestCity|$closestAddress";
        exit;
    break;
    case 'R':
        echo "$option@$zipsList";
        exit;
    break;
   }   

?>