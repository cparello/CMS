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
$marRgStartSecs = strtotime('2014/01/01');
$marRgEndSecs = strtotime('2014/03/31');


$stmt99 = $dbMain->prepare("SELECT DISTINCT contract_key, start_date, end_date, signup_date FROM monthly_services WHERE contract_key !='' AND service_name LIKE '%Membership%'");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($contract_key, $start_date, $end_date, $signup_date); 
while($stmt99->fetch()){
    $startSecs = strtotime($signup_date);

            if($startSecs >= $rgStartSecs AND $startSecs < $marRgStartSecs){
                //set Bi and 38.00 NS '2015-01-15'
                $eftCycle = "B";  
                $eftCycleDate = "2015-01-15 00:00:00";
                $rgFee = 38.00;                  
                  
                 $sql = "UPDATE member_guarantee_eft SET eft_cycle = ?, eft_cycle_date = ?, guarantee_fee = ? WHERE contract_key = '$contract_key'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('ssd', $eftCycle, $eftCycleDate, $rgFee);
                 if(!$stmt->execute())  {
                            	printf("Error:update1E %s.\n", $stmt->error);
                                  }	
                 $stmt->close();
                
            }else if($startSecs >= $marRgStartSecs AND $startSecs <= $marRgEndSecs){
                ///set anual and 19 '2015-03-15'
                $eftCycle = "A";  
                $eftCycleDate = "2015-03-15 00:00:00";
                $rgFee = 19.00;                  
                  
                 $sql = "UPDATE member_guarantee_eft SET eft_cycle = ?, eft_cycle_date = ?, guarantee_fee = ? WHERE contract_key = '$contract_key'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('ssd', $eftCycle, $eftCycleDate, $rgFee);
                 if(!$stmt->execute())  {
                            	printf("Error:update1E %s.\n", $stmt->error);
                                  }	
                 $stmt->close();
            }elseif(($startSecs > $marRgEndSecs)){
                 //set Bi and 38.00 NS '2015-01-15'
                $eftCycle = "B";  
                $eftCycleDate = "2015-01-15 00:00:00";
                $rgFee = 38.00;                  
                  
                 $sql = "UPDATE member_guarantee_eft SET eft_cycle = ?, eft_cycle_date = ?, guarantee_fee = ? WHERE contract_key = '$contract_key'";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('ssd', $eftCycle, $eftCycleDate, $rgFee);
                 if(!$stmt->execute())  {
                            	printf("Error:update1E %s.\n", $stmt->error);
                                  }	
                 $stmt->close();
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
