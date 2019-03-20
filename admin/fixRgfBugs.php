<?php
class fixRgfBugs {
                         
//connect to database
function dbconnect()   {
require"dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------
function fixBugs() {

$dbMain = $this->dbconnect();

$rgStartSecs = strtotime('2012/01/01');
$marRgStartSecs = strtotime('2013/01/01');
$marRgEndSecs = strtotime('2013/03/31');


$stmt99 = $dbMain->prepare("SELECT DISTINCT contract_key, start_date, end_date, signup_date FROM monthly_services WHERE contract_key !='' AND service_name LIKE '%Membership%'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($contract_key, $start_date, $end_date, $signup_date); 
while($stmt99->fetch()){
    $startSecs = strtotime($signup_date);

            if($startSecs >= $rgStartSecs AND $startSecs < $marRgStartSecs){
                //set Bi and 38.00 NS '2015-01-15'
                $count = 9;
                 $stmt = $dbMain ->prepare("SELECT count(*) as count FROM member_guarantee_eft WHERE contract_key ='$contract_key'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($count);
                 $stmt->fetch();
                 $stmt->close();
                                        
                 if ($count == 0){
                  $eftCycle = "B";  
                  $eftCycleDate = "2015-01-15 00:00:00";
                  $rgFee = 38.00;                  
                  $sql = "INSERT INTO member_guarantee_eft VALUES (?,?,?,?)";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('issd',$contract_key, $eftCycle,  $eftCycleDate, $rgFee);
                  if(!$stmt->execute())  {
                	printf("Error:insert 1 %s.\n", $stmt->error);
                  }	
                  $stmt->close();
                  echo "ckey $contract_key B 38<br>";
                 }
                
            }else if($startSecs >= $marRgStartSecs AND $startSecs <= $marRgEndSecs){
                ///set anual and 19 '2015-03-15'
                $count = 9;
                $stmt = $dbMain ->prepare("SELECT count(*) as count FROM member_guarantee_eft WHERE contract_key ='$contract_key'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($count);
                 $stmt->fetch();
                 $stmt->close();
                                        
                 if ($count == 0){
                  $eftCycle = "A";  
                  $eftCycleDate = "2015-03-15 00:00:00";
                  $rgFee = 19.00;                  
                  $sql = "INSERT INTO member_guarantee_eft VALUES (?,?,?,?)";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('issd',$contract_key, $eftCycle,  $eftCycleDate, $rgFee);
                  if(!$stmt->execute())  {
                	printf("Error:insert 2 %s.\n", $stmt->error);
                  }	
                  $stmt->close();
                   echo "ckey $contract_key A 19<br>";
                 }
            }elseif(($startSecs > $marRgEndSecs)){
                 //set Bi and 38.00 NS '2015-01-15'
                 $count = 9;
                 $stmt = $dbMain ->prepare("SELECT count(*) as count FROM member_guarantee_eft WHERE contract_key ='$contract_key'");
                 $stmt->execute();      
                 $stmt->store_result();      
                 $stmt->bind_result($count);
                 $stmt->fetch();
                 $stmt->close();
                                        
                 if ($count == 0){
                  $eftCycle = "B";  
                  $eftCycleDate = "2015-01-15 00:00:00";
                  $rgFee = 38.00;                  
                  $sql = "INSERT INTO member_guarantee_eft VALUES (?,?,?,?)";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('issd',$contract_key, $eftCycle,  $eftCycleDate, $rgFee);
                  if(!$stmt->execute())  {
                	printf("Error:insert 3 %s.\n", $stmt->error);
                  }	
                  $stmt->close();
                   echo "ckey $contract_key B 38<br>";
                 }
            }
            $contract_key = "";
            $start_date = "";
            $end_date = "";
            $signup_date = "";
            $eftCycle = "";
            $eftCycleDate = "";
            $rgFee = "";
            $count = "";
}
$stmt99->close();



}

//------------------------------------------------------------------------------------------------------------------

}//end class
//----------------------------------------------------------------------

  $checkPast = new fixRgfBugs();
  $checkPast-> fixBugs();
 
?>
