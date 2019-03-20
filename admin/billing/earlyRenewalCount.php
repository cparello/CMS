<?php
class  earlyRenewalCount {


private $settledCount = 0;
private $dateStart = null;


function setDateStart($dateStart) {
       $this->dateStart = $dateStart;
       }
function setListType($listType) {
       $this->listType = $listType;
       }
function setEarlyClub($early_club) {
       $this->earlyClub = $early_club;
       }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadPifEarlyCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT early_renewal_grace FROM fees WHERE fee_num ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($earlyRenewalGrace);
$stmt->fetch();
$stmt->close();


if($earlyRenewalGrace == 0) {
   echo"$this->settledCount";
   exit;   
   
  }else{
  
  $earlySecondsGrace = 86400 * $earlyRenewalGrace;
  $endDateSeconds =  $this->dateStart;//$earlySecondsGrace +
  
  //$contractEndDate = date("Y-m-d" ,$endDateSeconds);
  $total = 0;
 // $i = 30;
 // do {
      $year = date('Y',$endDateSeconds);
      $month = date('m',$endDateSeconds);
      $day = date('d',$endDateSeconds);
      
      $rangeEnd = date("Y-m-d H:i:s" ,mktime(23,59,59,$month,date('t'),$year));
      $rangeStart = date("Y-m-d H:i:s" ,mktime(00,00,00,$month,$day,$year));
      
      //$contractEndDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m"), date("d")+$early_renewal_grace, date("Y")));
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
            
            if ($maxSecs <= $endSecs AND $club_id == $this->earlyClub){
                 $counter++;
            }
      }
      $stmt->close();
      
      $stmt = $dbMain ->prepare("SELECT report_key FROM accounts_renewable_spam_check WHERE report_type = 'ER' AND report_date = '$rangeStart' AND list_type = '$this->listType' AND club_id = '$this->earlyClub'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($report_key);
      $stmt->fetch();
      $stmt->close();
      
      $report_key = trim($report_key);
      
      if ($report_key > 1){
        $text = " accounts. WARNING! This $this->listType Report for Early Renewal has already been generated";
      }else{
        $text = " accounts.";
      }
 // } while ($i > 0);
    //echo "date $rangeStart list $this->listType";
   //exit;
  

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
$date_start =$_REQUEST['date_start'];
$list_type =$_REQUEST['list_type'];
$early_club =$_REQUEST['early_club'];

if($ajax_switch == 1) {
   $earlyCount = new  earlyRenewalCount();
   $earlyCount-> setDateStart($date_start);
   $earlyCount-> setListType($list_type);
   $earlyCount-> setEarlyClub($early_club);
   $earlyCount-> loadPifEarlyCount();
   }


?>