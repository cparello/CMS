<?php
class  gracePeriodCount {

private $settledCount = 0;
private $dateEnd = null;


function setDateEnd($dateEnd) {
       $this->dateEnd = $dateEnd;
       }
function setListType($listType) {
       $this->listType = $listType;
       }

function setGraceClub($grace_club) {
       $this->graceClub = $grace_club;
       }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadPifGraceCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT standard_renewal_grace FROM fees WHERE fee_num ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($standardRenewalGrace);
$stmt->fetch();
$stmt->close();


if($standardRenewalGrace == 0) {
   echo"$this->settledCount";
   exit;   
   
  }else{
  
//  $standardSecondsGrace = 86400 * $standardRenewalGrace;
//  $endDateSeconds = $standardSecondsGrace + $this->dateEnd;  
//  $graceEndDate = date("Y-m-d" ,$endDateSeconds);
      $year = date('Y',$this->dateEnd);
      $month = date('m',$this->dateEnd);
      $day = date('d',$this->dateEnd);
      
      $rangeEnd = date("Y-m-d H:i:s" ,mktime(23,59,59,$month,date('t'),$year));
      $rangeStart = date("Y-m-d H:i:s" ,mktime(00,00,00,$month,$day,$year));
      
//$dateEnd = date("Y-m-d" ,$this->dateEnd);
 
    
   $counter = 0;
      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT contract_key, end_date, service_key FROM paid_full_services WHERE (end_date BETWEEN '$rangeStart' AND '$rangeEnd')");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($contract_key, $end_date, $service_key);
      
      while($stmt->fetch()){
            $club_id = "";
            $stmt99 = $dbMain ->prepare("SELECT contract_id, club_id FROM contract_info WHERE contract_key = '$contract_key' ORDER BY contract_id DESC LIMIT 1");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($cid, $club_id);
            $stmt99->fetch();
            $stmt99->close();
            
            $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$service_key'");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($end_dateMax);
            $stmt99->fetch();
            $stmt99->close();
            
            $maxSecs = strtotime($end_dateMax);
            $endSecs = strtotime($end_date);
            
            if ($maxSecs <= $endSecs AND $club_id == $this->graceClub){
        
                 $counter++;
            }
      }
  
   //echo "date $rangeStart list $this->listType";
   //exit;
      $stmt = $dbMain ->prepare("SELECT report_key FROM accounts_renewable_spam_check WHERE report_type = 'GP' AND report_date = '$rangeStart' AND list_type = '$this->listType' AND club_id = '$this->graceClub'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($report_key);
      $stmt->fetch();
      $stmt->close();
      
      $report_key = trim($report_key);
      
      if ($report_key  > 1){
        $text = " accounts. WARNING! This $this->listType Report for Grace Period Renewals has already been generated";
      }else{
        $text = " accounts.";
      }
  
  

     if($counter == 0) {
        echo"$this->settledCount";
        exit;   
       
       }else{
        echo"$counter$text";
        exit;     
    
       }
  
  
  }


}
//---------------------------------------------------------------------------------------------------------------------


}

$ajax_switch =$_REQUEST['ajax_switch'];
$date_end =$_REQUEST['date_end'];
$list_type =$_REQUEST['list_type'];
$grace_club =$_REQUEST['grace_club'];

$test = date('Y-m-d',$date_end);
//echo "date $date_end club $grace_club $test";
//exit;
if($ajax_switch == 1) {
   $graceCount = new  gracePeriodCount();
   $graceCount-> setDateEnd($date_end);
   $graceCount-> setListType($list_type);
   $graceCount-> setGraceClub($grace_club);
   $graceCount-> loadPifGraceCount();
   }


?>