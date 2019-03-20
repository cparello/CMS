<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
error_reporting(E_ERROR | E_PARSE);

class  runActiveInactiveReportsTwo {

private  $categoryType = null;
private  $seviceLocation = null;
private  $countField = null;
private  $sumTotal = null;
private  $groupDate = null;
private  $fromDate = null;
private  $toDate = null;
private  $fromDateDays = null;
private  $toDateDays = null;
private  $dayCount = null;
private  $daysSummary = null;
private  $dayList = null;
private  $monday = null;
private  $tuesday = null;
private  $wednesday = null;
private  $thursday = null;
private  $friday = null;
private  $saturday = null;
private  $sunday = null;
private  $weekDays = null;
private  $searchSql = null;
private  $sqlTable = null;
private  $ruleType = null;
private  $xLabelDays = null;
private  $highDay = null;
private  $days = null;
private  $xLabelMonths = null;
private  $numberOfMonths = null;
private  $highMonth = null;
private  $months = null;
private  $monthsTwo = null;
private  $monthStart = null;
private  $monthEnd = null;
private  $monthsSummary = null;
private  $rangeStart = null;
private  $rangeIncriment = null;
private  $numberOfYears = null;
private  $xLabelYears = null;
private  $highYear = null;
private  $years = null;
private  $yearsTwo = null;
private  $yearStart = null;
private  $yearEnd = null;
private  $yearsSummary = null;
private  $rangeCycle = null;
private  $searchSqlPif = null;
private  $searchSqlCancel = null;
private  $dateRange = null;

function setCategoryType($categoryType) {
        $this->categoryType = $categoryType;
         }

function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
         }

function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
         }
         
function setToDate($toDate) {
        $this->toDate = $toDate;
         }    
         
function setDateRange($dateRange) {
        $this->dateRange = $dateRange;
         }                
         
         
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-----------------------------------------------------------------------------------------------
function loadYRange($highValue) {

$yRange = $highValue / 7;
$yRange = round($yRange);

return $yRange;


}
//-----------------------------------------------------------------------------------------------
function loadDateRange()  {

if($this->rangeCycle != null) {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT $this->rangeCycle FROM fees WHERE fee_num='1' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($rangeCycle);   
  $stmt->fetch();


  if($this->renewType == 'ER') {
     $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d'),date('Y')));
     $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d')+$rangeCycle,date('Y')));
    }

   if($this->renewType == 'GP') {
     $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d')-$rangeCycle,date('Y')));
     $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d'),date('Y')));
    }  


  }else{
  
  //takes care of standard renewal. the default is 30 days
  $this->fromDate = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d'),date('Y')));
  $this->toDate = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),date('d')+30,date('Y')));
  }

}
//-----------------------------------------------------------------------------------------------
function loadMinSartDate() {

$dbMain = $this->dbconnect();
 
   $stmt = $dbMain ->prepare("SELECT MIN(signup_date) AS min1 FROM paid_full_services WHERE club_id != '' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($min1);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT MIN(signup_date) AS min2 FROM monthly_services WHERE club_id != '' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($min2);
   $stmt->fetch();
   $stmt->close();

   $minString1 = strtotime($min1);
   $minString2 = strtotime($min2);
   
   if($minString1 == $minString2) {
      $this->fromDate = $min1;  
      }elseif($minString1 < $minString2) {
      $this->fromDate = $min1;
      }else{
      $this->fromDate = $min2;
      }
      


}
//-----------------------------------------------------------------------------------------------
function loadSqlStatements() {

//since this his report is chronological we need to get the earleist start date for services
$this->loadMinSartDate();

switch ($this->categoryType) {
        case "AA":
         $this->sqlTable = "paid_full_services";  
         $this->sqlTableTwo = "monthly_services";
         
         if($this->serviceLocation == "0") {
            $this->searchSql = "club_id IS NOT NULL ";
            $this->searchSqlTwo = "club_id IS NOT NULL ";
            }else{            
            $this->searchSql = "club_id = '$this->serviceLocation' ";
            $this->searchSqlTwo = "club_id = '$this->serviceLocation' ";
            }
            
            $this->sumTotal = "group_renew_rate";
            $this->sumTotalTwo = "group_renew_rate";                               

            $this->groupDateStart = "signup_date";
            $this->groupDateEnd = "end_date";
            $this->groupDateStartTwo = "signup_date";
            
            $this->countField = "service_id";
            $this->countFieldTwo = "service_id";
              
        break;         
        
        
        case "IA":
         $this->sqlTable = "paid_full_services";  
         $this->sqlTableTwo = "monthly_services";
         
         if($this->serviceLocation == "0") {
            $this->searchSql = "club_id IS NOT NULL ";
            $this->searchSqlTwo = "club_id IS NOT NULL ";
            }else{            
            $this->searchSql = "club_id = '$this->serviceLocation' ";
            $this->searchSqlTwo = "club_id = '$this->serviceLocation' ";
            }
            
            $this->sumTotal = "group_renew_rate";
            $this->sumTotalTwo = "group_renew_rate";                               

            $this->groupDateStart = "signup_date";
            $this->groupDateEnd = "end_date";
            $this->groupDateStartTwo = "signup_date";
            
            $this->countField = "service_id";
            $this->countFieldTwo = "service_id";
            
        break;     
        
        
        case "AC":        
         $this->sqlTable = "paid_full_services";  
         $this->sqlTableTwo = "monthly_services";
         
         if($this->serviceLocation == "0") {
            $this->searchSql = "club_id IS NOT NULL ";
            $this->searchSqlTwo = "club_id IS NOT NULL ";
            }else{            
            $this->searchSql = "club_id = '$this->serviceLocation' ";
            $this->searchSqlTwo = "club_id = '$this->serviceLocation' ";
            }
            
            $this->sumTotal = "group_renew_rate";
            $this->sumTotalTwo = "group_renew_rate";                               

            $this->groupDateStart = "signup_date";
            $this->groupDateEnd = "end_date";
            $this->groupDateStartTwo = "signup_date";
            
            $this->countField = "service_id";
            $this->countFieldTwo = "service_id";        
                
        break;
      }



}
//-----------------------------------------------------------------------------------------------
function loadHighDay() {

//use to get the max sum of a day in a range
$dbMain = $this->dbconnect();
 
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY DAY($this->groupDate) ORDER BY SUM($this->sumTotal) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY DAY($this->groupDateTwo) ORDER BY SUM($this->sumTotalTwo) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $stmt->fetch();
   $stmt->close();   
   
   $total = $total1 + $total2; 
   $this->highDay = round($total);
   
 
}
//-----------------------------------------------------------------------------------------------
function loadHighDayWeek() {

$dayOfWeek = date("N");
$dayOfWeek = $dayOfWeek - 1;
$startWeekDay = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d')-$dayOfWeek,date('Y')));
$endWeekDay = date("Y-m-d H:i:s");
//$start = strtotime($this->fromDate);
//$end = strtotime($this->toDate);
//$daysBetween = ceil(abs($end - $start) / 86400);


//use to get the max sum of a day in a range
$dbMain = $this->dbconnect();  

   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$startWeekDay' AND '$endWeekDay' GROUP BY DAY($this->groupDate) ORDER BY SUM($this->sumTotal) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch(); 
   $stmt->close();

   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDate BETWEEN '$startWeekDay' AND '$endWeekDay' GROUP BY DAY($this->groupDateTwo) ORDER BY SUM($this->sumTotalTwo) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch(); 
   $stmt->close();

   $total = $total1 + $total2; 
   $total = round($total);
   
   return "$total";  
   
}
//------------------------------------------------------------------------------------------------
function loadHighWeek() {

$firstDayOfMonth = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));

$dbMain = $this->dbconnect();  

   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0))  AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY WEEK($this->groupDate) ORDER BY SUM($this->sumTotal) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch(); 
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0))  AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY WEEK($this->groupDateTwo) ORDER BY SUM($this->sumTotalTwo) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $stmt->fetch(); 
   $stmt->close();   
   
   $total = $total1 + $total2; 
   $total = round($total);
 

 return "$total";

}
//-----------------------------------------------------------------------------------------------
function loadHighMonth() {

$firstDayOfYear = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0))  AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$firstDayOfYear' AND NOW() GROUP BY MONTH($this->groupDate) ORDER BY SUM($this->sumTotal) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0))  AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$firstDayOfYear' AND NOW() GROUP BY MONTH($this->groupDateTwo) ORDER BY SUM($this->sumTotalTwo) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $stmt->fetch();   
   $stmt->close();
   
   $total = $total1 + $total2;
   $total = round($total);

 return "$total";

}
//-----------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------
function loadHighQuarter() {

$firstDayOfMonth = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0))  AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY QUARTER($this->groupDate) ORDER BY SUM($this->sumTotal) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0))  AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY QUARTER($this->groupDateTwo) ORDER BY SUM($this->sumTotalTwo) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $stmt->fetch();
   $stmt->close();   
   
   $total = $total1 + $total2;
   $total = round($total);

 return "$total";

}
//-----------------------------------------------------------------------------------------------
function parseWeekDays() {

$dayOfWeek = date("N");

switch ($dayOfWeek) {
        case "1":
        $mon = date("Y-m-d");
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+2,date('Y'))); 
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+3,date('Y')));
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+4,date('Y'))); 
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+5,date('Y')));
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+6,date('Y')));
        break;
        case "2":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y')));
        $tues = date("Y-m-d"); 
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+2,date('Y')));
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+3,date('Y'))); 
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+4,date('Y')));
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+5,date('Y')));
        break;
        case "3":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-2,date('Y')));
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y')));
        $wed = date("Y-m-d");        
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+2,date('Y'))); 
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+3,date('Y')));
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+4,date('Y')));
        break;
        case "4":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-3,date('Y')));
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-2,date('Y')));
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y')));       
        $thur = date("Y-m-d");       
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+2,date('Y')));
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+3,date('Y')));
        break;
        case "5":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-4,date('Y')));
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-3,date('Y')));
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-2,date('Y')));       
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y')));       
        $fri = date("Y-m-d");              
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+2,date('Y')));
        break;  
        case "6":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-5,date('Y')));
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-4,date('Y')));
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-3,date('Y')));       
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-2,date('Y')));       
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y')));
        $sat = date("Y-m-d"); 
        $sun = date("Y-m-d", mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        break;
        case "7":
        $mon = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-6,date('Y')));
        $tues = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-5,date('Y')));
        $wed = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-4,date('Y')));       
        $thur = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-3,date('Y')));       
        $fri = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-2,date('Y')));
        $sat = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y'))); 
        $sun = date("Y-m-d"); 
       }

        if(preg_match("/$mon/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->monday = $dayAmount;
           }
        if(preg_match("/$tues/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->tuesday = $dayAmount;
           }
        if(preg_match("/$wed/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->wednesday = $dayAmount;
           }
        if(preg_match("/$thur/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->thursday = $dayAmount;
           }
        if(preg_match("/$fri/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->friday = $dayAmount;
           }
        if(preg_match("/$sat/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->saturday = $dayAmount;
           }  
        if(preg_match("/$sun/", $this->dayList)) { 
           $dateTimeArray = explode("|", $this->dayList);
           $dayAmount = $dateTimeArray[1];
           $this->sunday = $dayAmount;
           }    
           

}
//------------------------------------------------------------------------------------------------
function loadCurrentWeekDays() {

$dayOfWeek = date("N");
$today = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),date('d'),date('Y')));


$dbMain = $this->dbconnect();

//sets up merchant sales
if($this->searchSql != "") {

$stmt1 = $dbMain ->prepare("SELECT $this->groupDate, SUM($this->sumTotal) AS total1 FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDate <= NOW() AND $this->groupDate >= DATE_ADD('$today',interval -'$dayOfWeek' DAY) GROUP BY DAY($this->groupDate)");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($saleDateOne, $totalOne);
$rowCount1 = $stmt1->num_rows;

if($rowCount1 != 0)  {
     //reset objects
     $this->monday = null;
     $this->tuesday = null;
     $this->wednesday = null;
     $this->thursday = null;
     $this->friday = null;
     $this->saturday = null;
     $this->sunday = null;
     
    while($stmt1->fetch()) {
      $this->dayList ="$saleDateOne|$totalOne";      
      $this->parseWeekDays();
      }  
      
  $this->weekListOne = "$this->monday,$this->tuesday,$this->wednesday,$this->thursday,$this->friday,$this->saturday,$this->sunday";    
  }else{  
  $this->weekListOne = "null,null,null,null,null,null,null";  
  }     
  
  $this->weekListOne = explode(",",$this->weekListOne);
  
//--------------------------------  
$stmt2 = $dbMain ->prepare("SELECT $this->groupDateTwo, SUM($this->sumTotalTwo) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo  $this->cancelStatus AND $this->groupDateTwo <= NOW() AND $this->groupDateTwo >= DATE_ADD('$today',interval -'$dayOfWeek' DAY) GROUP BY DAY($this->groupDateTwo)");
$stmt2->execute();      
$stmt2->store_result();      
$stmt2->bind_result($saleDateTwo, $totalTwo);
$rowCount2 = $stmt2->num_rows;  
 
if($rowCount2 != 0)  {
     //reset objects
     $this->monday = null;
     $this->tuesday = null;
     $this->wednesday = null;
     $this->thursday = null;
     $this->friday = null;
     $this->saturday = null;
     $this->sunday = null;
     
    while($stmt2->fetch()) {
      $this->dayList ="$saleDateTwo|$totalTwo";      
      $this->parseWeekDays();
      }  
      
  $this->weekListTwo = "$this->monday,$this->tuesday,$this->wednesday,$this->thursday,$this->friday,$this->saturday,$this->sunday";    
  }else{  
  $this->weekListTwo = "null,null,null,null,null,null,null";  
  }     
  
  $this->weekListTwo = explode(",",$this->weekListTwo); 
  
       
 //merge both service and retail arrays
for ($i = 0; $i < count($this->weekListOne); ++$i) {       
       $valAdd2 = $this->weekListTwo[$i] + $this->weekListOne[$i];
              if($valAdd2 == 0) {
               $valAdd2 ="";
                }    
       $this->weekList .= "$valAdd2,";
      } 

$this->weekList = substr_replace($this->weekList ,"",-1); 
$this->weekList = explode(",",$this->weekList);

//if there is no service then we just create a  services list
}else{

$this->weekList = $this->weekListService;

}


return $this->weekList;

}
//------------------------------------------------------------------------------------------------
function loadWeekList() {

switch($this->weekBit) {
        case "1":         
        $start = $this->firstWeekStart;
        $end = $this->firstWeekEnd;
        break;
        case "2":
        $start = $this->secondWeekStart;
        $end = $this->secondWeekEnd;
        break;
        case "3":
        $start = $this->thirdWeekStart;
        $end = $this->thirdWeekEnd;
        break;
        case "4":
        $start = $this->fourthWeekStart;
        $end = $this->fourthWeekEnd;
        break;
        case "5":
        $start = $this->fifthWeekStart;
        $end = $this->fifthWeekEnd;        
        break;
        }
        

$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

$stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1 FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDate BETWEEN '$start' AND '$end'  ORDER BY total3 DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($total1);
$stmt->fetch();
$stmt->close();

   if($total1 == "") {
      $total1 =null;
      }

$stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo  $this->cancelStatus AND $this->groupDateTwo BETWEEN '$start' AND '$end'  ORDER BY total2 DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($total2);
$stmt->fetch(); 
$stmt->close();

   if($total2 == "") {
      $total2 =null;
      }


$this->weekListRetailTwo = $total1 + $total2;

}

$total4 = $this->weekListRetailTwo;
if($total4 == 0) {
   $total4 = null;
  }
  
return "$total4,";

}
//------------------------------------------------------------------------------------------------
function parseMonthWeeks() {

$dayWeekMonth = date("N", mktime(0,0,0,date('m'),1,date('Y')));
$endMonthDay = date("t");


switch ($dayWeekMonth) {
        case "1":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),7,date('Y')));
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),8,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),14,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),15,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'), 21,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),22,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),28,date('Y')));            
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),29,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y')));         
        break;
        case "2":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),6,date('Y')));
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),7,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),13,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),14,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'), 20,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),21,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),27,date('Y')));            
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),28,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y'))); 
        break;
        case "3":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),5,date('Y')));        
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),6,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),12,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),13,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),19,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),20,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),26,date('Y')));                
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),27,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y')));         
        break;
        case "4":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),4,date('Y')));        
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),5,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),11,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),12,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),18,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),19,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),25,date('Y')));                
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),26,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y'))); 
        break;
        case "5":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),3,date('Y')));        
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),4,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),10,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),11,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),17,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),18,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),24,date('Y')));                
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),25,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y'))); 
        break;  
        case "6":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),2,date('Y')));        
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),3,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),9,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),10,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),16,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),17,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),23,date('Y')));                
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),24,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y')));
        break;
        case "7":
        $this->firstWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));
        $this->firstWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),1,date('Y')));        
        $this->secondWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),2,date('Y')));
        $this->secondWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),8,date('Y')));        
        $this->thirdWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),9,date('Y')));
        $this->thirdWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),15,date('Y')));        
        $this->fourtWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),16,date('Y')));
        $this->fourtWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),22,date('Y')));                
        $this->fifthWeekStart = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),23,date('Y')));
        $this->fifthWeekEnd = date("Y-m-d H:i:s", mktime(23,59,59,date('m'),$endMonthDay,date('Y')));
       }


for($i = 1; $i <=5; $i++)  {      
      $this->weekBit = $i; 
      $weekList .= $this->loadWeekList();
    }
    
$weekList = substr_replace($weekList ,"",-1);  

return "$weekList";

}
//-----------------------------------------------------------------------------------------------
function loadQuarterList() {

switch($this->quarterBit) {
        case "1":         
        $start = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,3,31,date('Y')));
        break;
        case "2":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,4,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,6,30,date('Y')));
        break;
        case "3":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,7,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,9,30,date('Y')));
        break;
        case "4":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,10,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,12,31,date('Y')));
        break;
        }


$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$start' AND '$end' GROUP BY QUARTER($this->groupDate)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1);
 $stmt->fetch();
 $stmt->close();
 
   if($total1 == "") {
      $total1 =null;
      }
 
 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2  FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$start' AND '$end' GROUP BY QUARTER($this->groupDateTwo)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2);
 $stmt->fetch();
 $stmt->close(); 
 
   if($total2 == "") {
      $total2 =null;
      } 
 
 
$this->quarterListRetail = $total1 + $total2;

}

$total4 = $this->quarterListRetail;
if($total4 == 0) {
   $total4 = null;
  }
  
return "$total4,";
  
}
//-----------------------------------------------------------------------------------------------
function parseQuarters() {

for($i = 1; $i <=4; $i++)  {      
      $this->quarterBit = $i; 
      $quarterList .= $this->loadQuarterList();
    }
    
$quarterList = substr_replace($quarterList,"",-1);  

return "$quarterList";

}
//-----------------------------------------------------------------------------------------------
function loadMonthList() {

$leapBit = date("L");
if($leapBit == 1) {
   $febDay = "29";
  }else{
   $febDay = "28";
  }

switch($this->monthBit) {
        case "1":         
        $start = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,1,31,date('Y')));
        break;
        case "2":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,2,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,2,$febDay,date('Y')));
        break;
        case "3":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,3,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,3,31,date('Y')));
        break;
        case "4":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,4,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,4,30,date('Y')));
        break;
        case "5":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,5,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,5,31,date('Y')));
        break;  
        case "6":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,6,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,6,30,date('Y')));
        break;    
        case "7":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,7,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,7,31,date('Y')));
        break;           
        case "8":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,8,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,8,31,date('Y')));
        break;   
        case "9":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,9,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,9,30,date('Y')));
        break;      
        case "10":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,10,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,10,31,date('Y')));
        break;     
        case "11":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,11,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,11,30,date('Y')));
        break; 
        case "12":
        $start = date("Y-m-d H:i:s", mktime(0,0,0,12,1,date('Y')));
        $end = date("Y-m-d H:i:s", mktime(23,59,59,12,31,date('Y')));
        break;                 
        }

$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1 FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDate BETWEEN '$start' AND '$end' GROUP BY MONTH($this->groupDate)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1);
 $stmt->fetch();   
 $stmt->close();
 
   if($total1 == "") {
      $total1 =null;
      }

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo  $this->cancelStatus AND $this->groupDateTwo BETWEEN '$start' AND '$end' GROUP BY MONTH($this->groupDateTwo)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2);
 $stmt->fetch();   
 $stmt->close();
 
   if($total2 == "") {
      $total2 =null;
      }

      
$this->monthListMerchant = $total1 + $total2;    

}

$total4 = $this->monthListMerchant;
if($total4 == 0) {
   $total4 = null;
  }

return "$total4,";   

}
//-----------------------------------------------------------------------------------------------
function parseMonths() {

for($i = 1; $i <=12; $i++)  {      
      $this->monthBit = $i; 
      $monthList .= $this->loadMonthList();
    }
    
$monthList = substr_replace($monthList,"",-1);  

return "$monthList";

}
//------------------------------------------------------------------------------------------------
function loadTodaySales() {

$start = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d"),date('Y')));

$dbMain = $this->dbconnect();
   
 //sets up merch sales
if($this->searchSql != "") {

   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal)  AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$start' AND NOW() GROUP BY day($this->groupDate)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $retail_count1);
   $stmt->fetch();
   $stmt->close();

   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo)  AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo  $this->cancelStatus AND $this->groupDateTwo BETWEEN '$start' AND NOW() GROUP BY day($this->groupDateTwo)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $retail_count2);
   $stmt->fetch();
   $stmt->close();


}
   
  $total = $total1 + $total2;
  $sales_count = $retail_count1 + $retail_count2;

   $this->singleDayTotal = $total;
   $this->singleDayCount = $sales_count;

   $hour = date("G");
   $hourProjection1 = $total / $hour;
   $hourProjection2 = $hourProjection1 * 23.5;
   $this->hourProjected = sprintf("%10.2f",$hourProjection2);
   
   if($this->singleDayTotal == "" || $this->singleDayTotal == "0") {
      $this->singleDayTotal = '0.00';
      $this->singleDayCount = '0';
     }
   
}
//------------------------------------------------------------------------------------------------
function loadWeekSales() {

$day = date("l");

if($day == "Sunday") {
  $thisMonday = date("Y-m-d H:i:s", strtotime('monday last week'));
  }else{
  $thisMonday = date("Y-m-d H:i:s", strtotime('monday this week'));
  }
  
$dbMain = $this->dbconnect();
      
//sets up merch sales
if($this->searchSql != "") {   

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$thisMonday' AND NOW()");  
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1, $retail_count1);
 $stmt->fetch();    
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$thisMonday' AND NOW()");  
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2, $retail_count2);
 $stmt->fetch();    
 $stmt->close();
  
}   

  $total = $total1 + $total2;
  $sales_count = $retail_count1 + $retail_count1;
  
   $this->currentWeekTotal = $total;
   $this->currentWeekCount = $sales_count;

   $weekProjection2 = $this->hourProjected * 7;
   $this->weekProjection = sprintf("%10.2f",$weekProjection2);
   
   if($this->currentWeekTotal == "" || $this->currentWeekTotal == "0") {
      $this->currentWeekTotal = '0.00';
      $this->currentWeekCount = '0';
     }
   
   
}
//-------------------------------------------------------------------------------------------------
function loadMonthSales() {

$monthStart = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),1,date('Y')));

$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

$stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$monthStart' AND NOW()");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1, $retail_count1);
 $stmt->fetch();
 $stmt->close();
   
$stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$monthStart' AND NOW()");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2, $retail_count2);
 $stmt->fetch();
 $stmt->close();   
   
}


  $total = $total1 + $total2;
  $sales_count = $retail_count1 + $retail_count2;

   $this->currentMonthTotal = $total;
   $this->currentMonthCount = $sales_count;
   
   $monthProjection2 = $this->hourProjected * 30.5;
   $this->monthProjection = sprintf("%10.2f",$monthProjection2);
   
   if($this->currentMonthTotal == "" || $this->currentMonthTotal == "0") {
      $this->currentMonthTotal = '0.00';
      $this->currentMonthCount = '0';
     }   

}
//-------------------------------------------------------------------------------------------------
function loadQuarterSales() {

$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND QUARTER($this->groupDate) = QUARTER(CURRENT_DATE) AND YEAR($this->groupDate) = YEAR(CURRENT_DATE)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1, $retail_count1);
 $stmt->fetch();    
 $stmt->close();  

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND QUARTER($this->groupDateTwo) = QUARTER(CURRENT_DATE) AND YEAR($this->groupDateTwo) = YEAR(CURRENT_DATE)");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2, $retail_count2);
 $stmt->fetch();    
 $stmt->close();  

}

  $total = $total1 + $total2;
  $sales_count = $retail_count1 + $retail_count2; 

   $this->currentQuarterTotal = $total;
   $this->currentQuarterCount = $sales_count;
   
   $quarterProjection2 = $this->hourProjected * 91.5;
   $this->quarterProjection = sprintf("%10.2f",$quarterProjection2); 
   
   if($this->currentQuarterTotal == "" || $this->currentQuarterTotal == "0") {
      $this->currentQuarterTotal = '0.00';
      $this->currentQuarterCount = '0';
     }      
    
}
//-------------------------------------------------------------------------------------------------
function loadYearSales() {

$yearStart = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

$dbMain = $this->dbconnect();

//sets up merch sales
if($this->searchSql != "") {

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$yearStart' AND NOW()");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total1, $retail_count1);
 $stmt->fetch();    
 $stmt->close();

 $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$yearStart' AND NOW()");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($total2, $retail_count2);
 $stmt->fetch();    
 $stmt->close();

}

  $total = $total1 + $total2;
  $sales_count = $retail_count1 + $retail_count2; 

   $this->currentYearTotal = $total;
   $this->currentYearCount = $sales_count;

   $yearProjection2 = $this->hourProjected * 375;
   $this->yearProjection = sprintf("%10.2f",$yearProjection2);
   
   if($this->currentYearTotal == "" || $this->currentYearTotal == "0") {
      $this->currentYearTotal = '0.00';
      $this->currentYearCount = '0';
     }         

}
//-------------------------------------------------------------------------------------------------
function createSummaryOne() {

$this->loadTodaySales();
$this->loadWeekSales();
$this->loadMonthSales();
$this->loadQuarterSales();
$this->loadYearSales();

$summaryRows = "
<tr>
<td class=\"black2\">
Today
</td>
<td class=\"black2\">
$this->singleDayCount
</td>
<td class=\"black2\">
$this->singleDayTotal
</td>
<td class=\"black2\">
$this->hourProjected
</td>
</tr>

<tr>
<td class=\"black2\">
Week
</td>
<td class=\"black2\">
$this->currentWeekCount
</td>
<td class=\"black2\">
$this->currentWeekTotal
</td>
<td class=\"black2\">
$this->weekProjection
</td>
</tr>

<tr>
<td class=\"black2\">
Month
</td>
<td class=\"black2\">
$this->currentMonthCount
</td>
<td class=\"black2\">
$this->currentMonthTotal
</td>
<td class=\"black2\">
$this->monthProjection
</td>
</tr>

<tr>
<td class=\"black2\">
Quarter
</td>
<td class=\"black2\">
$this->currentQuarterCount
</td>
<td class=\"black2\">
$this->currentQuarterTotal
</td>
<td class=\"black2\">
$this->quarterProjection
</td>
</tr>

<tr>
<td class=\"black2\">
Year
</td>
<td class=\"black2\">
$this->currentYearCount
</td>
<td class=\"black2\">
$this->currentYearTotal
</td>
<td class=\"black2\">
$this->yearProjection
</td>
</tr>

<tr>
<td colspan=\"4\">
&nbsp;
</td>
</tr>";

return "$summaryRows";

}
//===========================================================
//below showa all of the date range methods
//--------------------------------------------------------------------------------------------------------
function loadHighYear() {

$dbMain = $this->dbconnect();

if(($this->categoryType == 'AA') ||  ($this->categoryType == 'AC' ))  {

   //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
      
   $pifCount = $count1 - $count2;
   $yearlyCount = $count3 - $count4;
   $total = $pifCount + $yearlyCount;

  }

if($this->categoryType == 'IA')  {

   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total2, COUNT(contract_key) AS count2 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();  

   $total = $count1 + $count2;


  }

 $this->highYear = $total;
  
}
//--------------------------------------------------------------------------------------------------------
function loadHighMonthTwo() {

$dbMain = $this->dbconnect();

if(($this->categoryType == 'AA') ||  ($this->categoryType == 'AC' ))  {
   //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
      
   $pifCount = $count1 - $count2;
   $monthlyCount = $count3 - $count4;
   $total = $pifCount + $monthlyCount;
   $this->highMonth = $total;
}



if($this->categoryType == 'IA')  {

   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total2, COUNT(contract_key) AS count2 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();  

   $total = $count1 + $count2;
   $this->highMonth = $total;
  }


 
}
//---------------------------------------------------------------------------------------------------------
function loadDayList() {

$dbMain = $this->dbconnect();

if($this->searchSql != "") {

   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDate BETWEEN '$this->fromDateDays' AND '$this->toDateDays' GROUP BY day($this->groupDate)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $stmt->fetch();
   $stmt->close();
   
   if($total1 == "") {
      $total1 =null;
      }

   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateTwo BETWEEN '$this->fromDateDays' AND '$this->toDateDays' GROUP BY day($this->groupDateTwo)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $stmt->fetch();
   $stmt->close();
   
   if($total2 == "") {
      $total2 =null;
      }

 }
  
  
$total = $total1 + $total2;
        if($total == 0) {
           $total = null;
           }
  
  
   $this->days .="$total,";

}
//--------------------------------------------------------------------------------------------------------
function loadMonthListTwo() {

$dbMain = $this->dbconnect();
$signupDatePif = 0;
$endDatePif = 0;
$endDatePifTwo = 0;
$totalMonthly = 0;
$totalCancel = 0;
$totalCancelTwo = 0;


if($this->categoryType == 'AA') {

   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $signupDatePif = $signupDatePif + $total1;               
            }
           
           if($signupDatePif == 0 || $signupDatePif == '0.00') {
              $signupDatePif =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $numRows2 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total2;               
            }
           
           if($endDatePif== 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }        
   $stmt->close();   
   
        
   $stmt = $dbMain ->prepare("SELECT $this->sumTotalTwo  FROM $this->sqlTableTwo WHERE $this->searchSqlTwo AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3);
   $numRows3 = $stmt->num_rows;

   while($stmt->fetch()) {
           $totalMonthly = $totalMonthly + $total3;
           }
        
         if($totalMonthly == 0 || $totalMonthly == '0.00') {
            $totalMonthly=null;
           }            
  $stmt->close();           
  $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($total4);         
  $numRows4 = $stmt->num_rows;
            
  while($stmt->fetch()) {            
           $totalCancel = $totalCancel + $total4;
           }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           } 
                   
 $stmt->close();
     
$totalUnitsPif = $numRows1 - $numRows2;
$incomePif = $signupDatePif - $endDatePif;
$totalUnitsMonthly = $numRows3 - $numRows4;
$incomeMonthly = $totalMonthly - $totalCancel;

$totalIncome = $incomePif + $incomeMonthly;
$totalUnits = $totalUnitsPif + $totalUnitsMonthly;
$this->months .="$totalUnits, "; 
}

//takes care of inactive===================
if($this->categoryType == 'IA') {

   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total1;               
            }
           
           if($endDatePif == 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }  
      
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);         
   $numRows2 = $stmt->num_rows;
            
   while($stmt->fetch()) {            
            $totalCancel = $totalCancel + $total2;
            }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           } 
                   
          $stmt->close();

$totalUnitsInactive = $numRows1 + $numRows2;
$negativeIncome = $endDatePif + $totalCancel;

$totalIncome = $negativeIncome;
$totalUnits = $totalUnitsInactive;
$this->months .="$totalUnits, ";
 }




//takes care of attrition comaprison===============
if($this->categoryType == 'AC') {
   //takes care of active
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $signupDatePif = $signupDatePif + $total1;               
            }
           
           if($signupDatePif == 0 || $signupDatePif == '0.00') {
              $signupDatePif =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $numRows2 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total2;               
            }
           
           if($endDatePif== 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }        
   $stmt->close();   
   
        
   $stmt = $dbMain ->prepare("SELECT $this->sumTotalTwo  FROM $this->sqlTableTwo WHERE $this->searchSqlTwo AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3);
   $numRows3 = $stmt->num_rows;

   while($stmt->fetch()) {
           $totalMonthly = $totalMonthly + $total3;
           }
        
         if($totalMonthly == 0 || $totalMonthly == '0.00') {
            $totalMonthly=null;
           }            
  $stmt->close();           
  $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($total4);         
  $numRows4 = $stmt->num_rows;
            
  while($stmt->fetch()) {            
           $totalCancel = $totalCancel + $total4;
           }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           } 
                   
 $stmt->close();
     
$totalUnitsPif = $numRows1 - $numRows2;
$incomePif = $signupDatePif - $endDatePif;
$totalUnitsMonthly = $numRows3 - $numRows4;
$incomeMonthly = $totalMonthly - $totalCancel;

$totalIncome = $incomePif + $incomeMonthly;
$totalUnits = $totalUnitsPif + $totalUnitsMonthly;
$this->months .="$totalUnits, "; 


//loads the inactive info====================
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total5);
   $numRows5 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePifTwo = $endDatePifTwo + $total5;               
            }
           
           if($endDatePifTwo == 0 || $endDatePifTwo == '0.00') {
              $endDatePifTwo =null;
             }  
      
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total6);         
   $numRows6 = $stmt->num_rows;
            
   while($stmt->fetch()) {            
            $totalCancelTwo = $totalCancelTwo + $total6;
            }   
                  
         if($totalCancelTwo == 0 || $totalCancelTwo == '0.00') {
            $totalCancelTwo = null;
           } 
                   
          $stmt->close();

$totalUnitsInactive = $numRows5 + $numRows6;
$negativeIncome = $endDatePifTwo + $totalCancelTwo;

$totalIncome = $negativeIncome;
$totalUnitsTwo = $totalUnitsInactive;
$this->monthsTwo .="$totalUnitsTwo, ";

  }
  
  
  
}
//--------------------------------------------------------------------------------------------------------
function loadYearList() {

$dbMain = $this->dbconnect();
$signupDatePif = 0;
$endDatePif = 0;
$endDatePifTwo = 0;
$totalYearly = 0;
$totalCancel = 0;
$totalCancelTwo = 0;

if($this->categoryType == 'AA') {

   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $signupDatePif = $signupDatePif + $total1;               
            }
           
           if($signupDatePif == 0 || $signupDatePif == '0.00') {
              $signupDatePif =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $numRows2 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total2;               
            }
           
           if($endDatePif== 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }        
   $stmt->close();   
   
        
   $stmt = $dbMain ->prepare("SELECT $this->sumTotalTwo  FROM $this->sqlTableTwo WHERE $this->searchSqlTwo AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3);
   $numRows3 = $stmt->num_rows;

   while($stmt->fetch()) {
           $totalYearly = $totalYearly + $total3;
           }
        
         if($totalYearly == 0 || $totalYearly == '0.00') {
            $totalYearly=null;
           }             
  $stmt->close();           
  $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($total4);         
  $numRows4 = $stmt->num_rows;
            
  while($stmt->fetch()) {            
           $totalCancel = $totalCancel + $total4;
           }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           }                    
 $stmt->close();
     
$totalUnitsPif = $numRows1 - $numRows2;
$incomePif = $signupDatePif - $endDatePif;
$totalUnitsYearly = $numRows3 - $numRows4;
$incomeYearly = $totalYearly - $totalCancel;

$totalIncome = $incomePif + $incomeYearly;
$totalUnits = $totalUnitsPif + $totalUnitsYearly;
$this->years .="$totalUnits, ";  
}


//takes care of inactive===================
if($this->categoryType == 'IA') {

   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total1;               
            }
           
           if($endDatePif == 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);         
   $numRows2 = $stmt->num_rows;
            
   while($stmt->fetch()) {            
            $totalCancel = $totalCancel + $total2;
            }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           } 
                   
          $stmt->close();


$totalUnitsInactive = $numRows1 + $numRows2;
$negativeIncome = $endDatePif + $totalCancel;

$totalIncome = $negativeIncome;
$totalUnits = $totalUnitsInactive;
$this->years .="$totalUnits, ";
 }




//takes care of attrition comaprison===============
if($this->categoryType == 'AC') {

   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1);
   $numRows1 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $signupDatePif = $signupDatePif + $total1;               
            }
           
           if($signupDatePif == 0 || $signupDatePif == '0.00') {
              $signupDatePif =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2);
   $numRows2 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePif = $endDatePif + $total2;               
            }
           
           if($endDatePif== 0 || $endDatePif == '0.00') {
              $endDatePif =null;
             }        
   $stmt->close();           
   $stmt = $dbMain ->prepare("SELECT $this->sumTotalTwo  FROM $this->sqlTableTwo WHERE $this->searchSqlTwo AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3);
   $numRows3 = $stmt->num_rows;

   while($stmt->fetch()) {
           $totalYearly = $totalYearly + $total3;
           }
        
         if($totalYearly == 0 || $totalYearly == '0.00') {
            $totalYearly=null;
           }             
  $stmt->close();           
  $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($total4);         
  $numRows4 = $stmt->num_rows;
            
  while($stmt->fetch()) {            
           $totalCancel = $totalCancel + $total4;
           }   
                  
         if($totalCancel == 0 || $totalCancel == '0.00') {
            $totalCancel = null;
           }                    
 $stmt->close();
     
$totalUnitsPif = $numRows1 - $numRows2;
$incomePif = $signupDatePif - $endDatePif;
$totalUnitsYearly = $numRows3 - $numRows4;
$incomeYearly = $totalYearly - $totalCancel;

$totalIncome = $incomePif + $incomeYearly;
$totalUnits = $totalUnitsPif + $totalUnitsYearly;
$this->years .="$totalUnits, ";  


//loads the inactive info====================
   $stmt = $dbMain ->prepare("SELECT $this->sumTotal  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total5);
   $numRows5 = $stmt->num_rows;
   
   while($stmt->fetch()) {            
            $endDatePifTwo = $endDatePifTwo + $total5;               
            }
           
           if($endDatePifTwo == 0 || $endDatePifTwo == '0.00') {
              $endDatePifTwo =null;
             }        
   $stmt->close();   
   $stmt = $dbMain ->prepare("SELECT service_price  FROM account_status WHERE account_status = 'CA'  AND status_date  BETWEEN '$this->fromDate' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total6);         
   $numRows6 = $stmt->num_rows;
            
   while($stmt->fetch()) {            
            $totalCancelTwo = $totalCancelTwo + $total6;
            }   
                  
         if($totalCancelTwo == 0 || $totalCancelTwo == '0.00') {
            $totalCancelTwo = null;
           } 
                   
          $stmt->close();


$totalUnitsInactive = $numRows5 + $numRows6;
$negativeIncome = $endDatePifTwo + $totalCancelTwo;

$totalIncome = $negativeIncome;
$totalUnitsTwo = $totalUnitsInactive;
$this->yearsTwo .="$totalUnitsTwo, ";

           
  }

}
//--------------------------------------------------------------------------------------------------------
function loadXLabels() {

if($this->ruleType == "1") {
    $year =date("Y", strtotime($this->fromDate));
    $month=date("m", strtotime($this->fromDate));
    $day=date("d", strtotime($this->fromDate));
    $numberOfDays = $this->numberOfDays + 1;
    
   for($i =0; $i < $numberOfDays; $i++) {   
         $xLabel = date("d", mktime(0,0,0,$month,$day+$i,$year));
        $this->xLabelDays .= "$xLabel,";         
        }               
   $this->xLabelDays = substr_replace($this->xLabelDays,"",-1);
  }


if($this->ruleType == "2") {
  $fromDateTemp = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
  $fromYear =date("Y", strtotime($fromDateTemp));
  $fromMonth=date("m", strtotime($fromDateTemp));
  $fromDay = "01";
  $start = date("Y-m-01", strtotime($fromDateTemp));
  $startEndDay = date("t", strtotime($this->toDate));
  $end = date("Y-m-$startEndDay", strtotime($this->toDate));
  $date1 = new DateTime($start);
  $date2 = new DateTime($end);
  $this->numberOfMonths = $date2->diff($date1)->format("%m");
  
  for($i = 0; $i <= $this->numberOfMonths; $i++) {
       $xLabel = date("M", mktime(0,0,0,$fromMonth+$i,$fromDay,$fromYear));
       $this->xLabelMonths .= "$xLabel,";   
      }
   $this->xLabelMonths = substr_replace($this->xLabelMonths,"",-1);
  }


if($this->ruleType == "3") {
   $fromYear =date("Y", strtotime($this->fromDate));
   $start = date("Y-01-01", strtotime($this->fromDate));
   $end = date("Y-01-01", strtotime($this->toDate));   
   $date1 = new DateTime($start);
   $date2 = new DateTime($end);
   $this->numberOfYears = $date2->diff($date1)->format("%y");
   
  for($i = 0; $i <= $this->numberOfYears; $i++) {
       $xLabel = date("Y", mktime(0,0,0,1,1,$fromYear+$i));
       $this->xLabelYears .= "$xLabel,";   
      }
   $this->xLabelYears = substr_replace($this->xLabelYears,"",-1);
}


}
//------------------------------------------------------------------------------------------------
function parseDays() {

    $year =date("Y", strtotime($this->fromDate));
    $month=date("m", strtotime($this->fromDate));
    $day=date("d", strtotime($this->fromDate));
    $numberOfDays = $this->numberOfDays + 1;

   for($i =0; $i < $numberOfDays; $i++) {   
         $this->fromDateDays = date("Y-m-d H:i:s", mktime(0,0,0,$month,$day+$i,$year));
         $this->toDateDays = date("Y-m-d H:i:s", mktime(23,59,59,$month,$day+$i,$year)); 
         $this->dayCount = $i;
         $this->loadDayList(); 
        }

$this->days = substr_replace($this->days,"",-1);

}
//------------------------------------------------------------------------------------------------
function parseMonthsTwo() {


    $fromDateTemp = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

    $year = date("Y", strtotime($fromDateTemp));
    $month= date("m", strtotime($fromDateTemp));
    $dayLast = date("t", strtotime($fromDateTemp));
          
    $i=0;
    $monthCount = $this->numberOfMonths + 1;
   

  while($i < $monthCount) {  

         if($i == 0) {
            $this->monthStart = $fromDateTemp;
            $this->monthEnd = date("Y-m-d H:i:s", mktime(23,59,59,$month,$dayLast,$year));
            }
            
         if(($i > 0) &&  ($i < $monthCount)) {
            $this->monthStart = date("Y-m-01 00:00:00", strtotime("$fromDateTemp +$i month"));
            $last = date("t", strtotime($this->monthStart));
            $last = $last -1;
            $this->monthEnd = date("Y-m-d 23:59:59", strtotime("$this->monthStart +$last day"));            
            }
            
         $i++; 
         
          if($i == $monthCount) {
            $j = $i - 1;
            $this->monthStart = date("Y-m-01 00:00:00", strtotime("$fromDateTemp +$j month"));
            $this->monthEnd = $this->toDate;
            }
        
         $this->loadMonthListTwo();
       }
       
$this->months = trim($this->months);       
$this->months = substr_replace($this->months,"",-1);       
     
}
//------------------------------------------------------------------------------------------------
function parseYears() {

    $year = date("Y", strtotime($this->fromDate));

    $i=0;
    $yearCount = $this->numberOfYears + 1;

  while($i < $yearCount) {  

         if($i == 0) {
            $this->yearStart = $this->fromDate;
            $this->yearEnd = date("Y-m-d H:i:s", mktime(23,59,59,12,31,$year));
            }
            
         if(($i > 0) &&  ($i < $yearCount)) {
            $this->yearStart = date("Y-m-d H:i:s", mktime(00,00,0,1,1,$year +$i));
            $this->yearEnd = date("Y-m-d H:i:s", mktime(23,59,59,12,31,$year +$i));            
            }
            
         $i++; 
         
          if($i == $yearCount) {
            $j = $i - 1;
            $this->yearStart = date("Y-m-d H:i:s",  mktime(00,00,0,1,1,$year +$j));
            $this->yearEnd = $this->toDate;
            }
        
         $this->loadYearList();
       }
       
$this->years = trim($this->years);       
$this->years = substr_replace($this->years,"",-1);       
     
}
//------------------------------------------------------------------------------------------------
function createSummaryTwo() {

$dbMain = $this->dbconnect();

if($this->searchSql != "") {

   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotal) AS total1, COUNT($this->countField) AS retail_count1 FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $retail_count1);
   $stmt->fetch();   
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT SUM($this->sumTotalTwo) AS total2, COUNT($this->countFieldTwo) AS retail_count2 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $retail_count2);
   $stmt->fetch();   
   $stmt->close();   
      
  }
  
 $sales_count = $retail_count1 + $retail_count2;
 $total = $total1 + $total2;
  

$this->daysSummary = "
<tr>
<td class=\"black2\">
$this->numberOfDays Days
</td>
<td class=\"black2\">
$sales_count
</td>
<td class=\"black2\">
$total
</td>
<td class=\"black2\">
NA
</td>
</tr>

<tr>
<td colspan=\"4\">
&nbsp;
</td>
</tr>";

}
//------------------------------------------------------------------------------------------------
function createSummaryThree() {

$dbMain = $this->dbconnect();
setlocale(LC_MONETARY, 'en_US');

if($this->categoryType == 'AA')  {

   //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
     
     
$pifCount = $count1 - $count2;
$monthlyCount = $count3 - $count4;
$sales_count = $pifCount + $monthlyCount;   
   
$pifSales =  $total1 - $total2; 
$monthlySales = $total3 - $total4;
$total = $pifSales + $monthlySales;
$total = money_format('%n', $total);

}


if($this->categoryType == 'IA')  {

   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total2, COUNT(contract_key) AS count2 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();  

   $sales_count = $count1 + $count2;
   $total = $total1 + $total2;
   $total = money_format('%n', $total);
  }


if($this->categoryType == 'AC')  {

     //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
     
     
$pifCount = $count1 - $count2;
$monthlyCount = $count3 - $count4;
$sales_count_active = $pifCount + $monthlyCount;   
   
$pifSales =  $total1 - $total2; 
$monthlySales = $total3 - $total4;
$total_active = $pifSales + $monthlySales;
$total_active = money_format('%n', $total_active);  


//inactive accounts
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total5, COUNT(contract_key) AS count5  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total5, $count5);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total6, COUNT(contract_key) AS count6 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total6, $count6);
   $stmt->fetch();
   $stmt->close();  

   $sales_count_inactive = $count5 + $count6;
   $total_inactive = $total5 + $total6;
   $total_inactive = money_format('%n', $total_inactive);

 }


$monthCount = $this->numberOfMonths +1;

if($this->categoryType != 'AC')  {

   $this->monthsSummary = "
   <tr>
   <td class=\"black2\">
   $monthCount Months
   </td>
   <td class=\"black2\">
   $sales_count
   </td>
   <td class=\"black2\">
   $total
   </td>
   <td class=\"black2\">
   NA
   </td>
   </tr>

   <tr>
   <td colspan=\"4\">
   &nbsp;
   </td>
   </tr>";
   
 }else{

   $this->monthsSummary = "
   <tr>
   <td class=\"black2\">
   $monthCount Months
   </td>
   <td class=\"black2\">
   $sales_count_active
   </td>
   <td class=\"black2\">
   $sales_count_inactive
   </td>
   <td class=\"black2\">
   $total_active
   </td>
   <td class=\"black2\">
   $total_inactive
   </td>   
   
   </tr>
   <tr>
   <td colspan=\"5\">
   &nbsp;
   </td>
   </tr>";
 }


}
//------------------------------------------------------------------------------------------------
function createSummaryFour() {

$dbMain = $this->dbconnect();
setlocale(LC_MONETARY, 'en_US');

if($this->categoryType == 'AA')  {

   //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
     
     
$pifCount = $count1 - $count2;
$yearlyCount = $count3 - $count4;
$sales_count = $pifCount + $yearlyCount;   
   
$pifSales =  $total1 - $total2; 
$monthlySales = $total3 - $total4;
$total = $pifSales + $monthlySales;
$total = money_format('%n', $total);   
}


if($this->categoryType == 'IA')  {

   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total2, COUNT(contract_key) AS count2 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();  

   $sales_count = $count1 + $count2;
   $total = $total1 + $total2;
   $total = money_format('%n', $total);
  }


if($this->categoryType == 'AC')  {

   //pif signup
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total1, COUNT(contract_key) AS count1  FROM $this->sqlTable WHERE $this->searchSql AND end_date != '0000-00-00 00:00:00' AND $this->groupDateStart BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total1, $count1);
   $stmt->fetch();
   $stmt->close();
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total2, COUNT(contract_key) AS count2  FROM $this->sqlTable WHERE $this->searchSql  AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total2, $count2);
   $stmt->fetch();
   $stmt->close();
   
   
   //monthly signup   
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotalTwo,0)) AS total3, COUNT(contract_key) AS count3 FROM $this->sqlTableTwo WHERE $this->searchSqlTwo $this->cancelStatus AND $this->groupDateStartTwo BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total3, $count3);
   $stmt->fetch();
   $stmt->close();   
   
   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total4, COUNT(contract_key) AS count4 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total4, $count4);
   $stmt->fetch();
   $stmt->close();    
     
     
$pifCount = $count1 - $count2;
$yearlyCount = $count3 - $count4;
$sales_count_active = $pifCount + $yearlyCount;   
   
$pifSales =  $total1 - $total2; 
$monthlySales = $total3 - $total4;
$total_active = $pifSales + $monthlySales;
$total_active = money_format('%n', $total_active);   

   //takes car of inactive
   //pif end
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE($this->sumTotal,0)) AS total5, COUNT(contract_key) AS count5  FROM $this->sqlTable WHERE $this->searchSql AND $this->groupDateEnd BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total5, $count5);
   $stmt->fetch();
   $stmt->close();

   //cancel count
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(service_price,0)) AS total6, COUNT(contract_key) AS count6 FROM account_status WHERE account_status = 'CA' AND status_date BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total6, $count6);
   $stmt->fetch();
   $stmt->close();  

   $sales_count_inactive = $count5 + $count6;
   $total_inactive = $total5 + $total6;
   $total_inactive = money_format('%n', $total_inactive);

}

$yearCount = $this->numberOfYears +1;

   if($this->categoryType != 'AC')  {
   
     $this->yearsSummary = "
     <tr>
     <td class=\"black2\">
     $yearCount Years
     </td>
     <td class=\"black2\">
     $sales_count
     </td>
     <td class=\"black2\">
     $total
     </td>
     <td class=\"black2\">
     NA
     </td>
     </tr>

     <tr>
     <td colspan=\"4\">
     &nbsp;
     </td>
     </tr>";
     
    }else{
    
     $this->yearsSummary = "
     <tr>
     <td class=\"black2\">
     $yearCount Years
     </td>
     <td class=\"black2\">
     $sales_count_active
     </td>
     <td class=\"black2\">
     $sales_count_inactive
     </td>
     <td class=\"black2\">
     $total_active
     </td>
     <td class=\"black2\">
     $total_inactive
     </td>     
     </tr>

     <tr>
     <td colspan=\"5\">
     &nbsp;
     </td>
     </tr>";    
       
    }
    
    
    
    
}
//------------------------------------------------------------------------------------------------
function loadRuleType() {

$date1 = new DateTime($this->fromDate); //inclusive
$date2 = new DateTime($this->toDate); //exclusive
$diff = $date2->diff($date1);
$this->numberOfDays = $diff->format("%a"); 



   //handles years
if($this->dateRange == 'AY') {      
   $this->ruleType = 3;
   $this->loadXLabels();
   $this->loadHighYear();
   $this->parseYears();
   $this->createSummaryFour();
   }


   //handles months
if($this->dateRange == 'CY') {   
   $this->ruleType = 2;
   $this->loadXLabels();
   $this->loadHighMonthTwo();
   $this->parseMonthsTwo();
   $this->createSummaryThree();
   }




/*

if($this->numberOfDays <= 60) {
   $this->ruleType = 1;
   $this->loadXLabels();
   $this->loadHighDay();
   $this->parseDays();
   $this->createSummaryTwo();
   }

if(($this->numberOfDays > 60) && ($this->numberOfDays <= 365)) {
   $this->ruleType = 2;
   $this->loadXLabels();
   $this->loadHighMonthTwo();
   $this->parseMonthsTwo();
   $this->createSummaryThree();
   }

if($this->numberOfDays > 365) {
   $this->ruleType = 3;
   $this->loadXLabels();
   $this->loadHighYear();
   $this->parseYears();
   $this->createSummaryFour();
   }   
*/
return "$this->ruleType";


}
//------------------------------------------------------------------------------------------------
function getXLabelDays() {
     return($this->xLabelDays);
     }
function getHighDay() {
     return($this->highDay);
     }
function getDays() {
     return($this->days);
     }     
function getDaysSummary() {
     return($this->daysSummary);
     }        
     
function getXLabelMonths() {
     return($this->xLabelMonths);
     }    
function getHighMonth() {
     return($this->highMonth);
     }
function getMonths() {
     return($this->months);
     }
function getMonthsTwo() {
     return($this->monthsTwo);
     }     
function getMonthsSummary() {
     return($this->monthsSummary);
     }

function getXLabelYears() {
     return($this->xLabelYears);
     }    
function getHighYear() {
     return($this->highYear);
     }
function getYears() {
     return($this->years);
     }
function getYearsTwo() {
     return($this->yearsTwo);
     }     
function getYearsSummary() {
     return($this->yearsSummary);
     }


}
//#####################################################################




//==================================================================
//==================================================================
//==================================================================
function loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo) {

require_once 'php-ofc-library/open-flash-chart.php';
//--------------------------------------------------------------------------
//set tup the first object for the elements in the current week
$title = new title($chartTitle);
$title->set_style ("{padding-bottom: 20px; text-align: left; padding-left: 40px; }");

//sets up if the chart is a line or a bar
if($chartType == 'B') {
   $bar = new bar_glass();
  } 
if($chartType == 'L') {
   $bar = new line();
  }    
   
//adds the bar vals to the bar values array   
$bar_values = array();
foreach($barValues as $b) {
             $b = json_decode($b);
             array_push($bar_values,$b);
            }


$bar->set_values($bar_values);
$bar->colour( '#009D49' );

//sets up if there is a compsarison bar chart--------------------------
if($barValuesTwo != null) {

    if($chartType == 'B') {
        $bar2 = new bar_glass();
      } 
      if($chartType == 'L') {
        $bar2 = new line();
      }  
      
   $bar_values_two = array();
   foreach($barValuesTwo as $c) {
                $c = json_decode($c);
                array_push($bar_values_two,$c);
                } 
    
   $bar2->set_values($bar_values_two);
   $bar2->colour( '#990033' );    
   
   $bar-> set_key('Active', 10);
   $bar2-> set_key('Inactive', 10);
   
   
$tags2 = new ofc_tags();
$tags2->font("Verdana", 7)
->colour("#000000")
->align_y_below ()
->align_x_right()
->text('#y#')
->style(true, false, false, 0);

$v=0;
foreach($barValuesTwo as $w) {
    $tags2->append_tag(new ofc_tag($v, $w));
    $v++;
   }  
   
   
   
   
   

  }
//----------------------------------------------------



$t = new tooltip();
$t->set_shadow( false );
$t->set_colour( "#999999" );
$t->set_background_colour( "#CCCCCC" );
$t->set_title_style( "{font-size: 12px; color: #000000;}" );
$t->set_body_style( "{font-size: 10px; font-weight: bold; color: #000000;}" );


$x_labels = new x_axis_labels();

//sets up the label array
   switch ($xLabels) {
        case "DOW":   //day of week
        $label_array = array('M','T','W','TH','F','SA','SU');
        break;
        case "WOM":   //week of month
        $label_array = array('W1','W2','W3','W4','W5');
        break;        
        case "QOY":   //quarter of year
        $label_array = array('Q1','Q2','Q3','Q4');
        break;        
        case "MOY":  //months of year
        $label_array = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        break; 
        case "DAY":  //days in a range up to 31
        $label_array = array();        
           foreach($xLabelBottom as $xl) {
             array_push($label_array,$xl);
             }        
        break; 
        case "MON":  //months in a date range
        $label_array = array();        
           foreach($xLabelBottom as $xl) {
             array_push($label_array,$xl);
             }   
        break;
        case "YEA":  //years in a date range
        $label_array = array();        
           foreach($xLabelBottom as $xl) {
             array_push($label_array,$xl);
             }   
        break;             
       }



$tags = new ofc_tags();
$tags->font("Verdana", 7)
->colour("#000000")
->align_y_below ()
->align_x_right()
->text('#y#')
->style(true, false, false, 0);

$z=0;
foreach($barValues as $v) {
    $tags->append_tag(new ofc_tag($z, $v));
    $z++;
   }




$x_labels-> set_size(8);
$x_labels-> set_colour('#000000');
$x_labels-> set_labels($label_array);  	

$x = new x_axis();
$x->set_colour('#000000');
$x->set_grid_colour('#FFFFFF');
$x->set_stroke('1'); 
$x->set_labels($x_labels);


$y_labels = new y_axis_labels();
$y_labels-> set_size(8);
$y_labels-> set_colour('#000000');

$y = new y_axis();
$y->set_range( $rangeStart, $yRangeMax, $rangeEnd);
$y->set_colour('#000000');
$y->set_grid_colour('#CCCCCC');
$y->set_stroke('1');
$y->set_labels($y_labels);

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar );

if($barValuesTwo != null) {
 $chart->add_element( $bar2 ); 
  }


//sets a top label for printing
if($printBit == "1") {
   $chart->add_element( $tags );
   
      if($barValuesTwo != null) {
        $chart->add_element( $tags2 );
        }
   
   }
   
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_number_format(0, true, false, true );
$chart->set_bg_colour( '#FFFFFF' );
$chart->set_tooltip( $t );

$chartCode = $chart->toString();

return $chartCode;
}
//===================================================
//===================================================
//===================================================
$ajax_switch=$_REQUEST['ajax_switch'];
$category_type=$_REQUEST['category_type'];
$service_location=$_REQUEST['service_location'];
$date_range=$_REQUEST['date_range'];


if($ajax_switch == "1") {


      $start_date = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
      $end_date = date("Y-m-d H:i:s");

      
    $runReport = new runActiveInactiveReportsTwo();
    $runReport-> setCategoryType($category_type);    
    $runReport-> setServiceLocation($service_location);
    $runReport-> setFromDate($start_date);
    $runReport-> setToDate($end_date);
    $runReport-> setDateRange($date_range);
    $runReport-> loadSqlStatements();
   

   //check to see if a date range is present. if not mage year to day report
   if(($renew_type == 'EA') && ($from_date == "" ||  $to_date == "")) {
     
      $xLabelBottom = "";
     //first get both the the line and bar graphs for the days in the current week
      $chartType = "B";
      $chartTitle = 'This Week';
      $xLabels = 'DOW';
      $yRangeMax = $runReport-> loadHighDayWeek(); 
      $rangeStart = $runReport-> loadYRange($yRangeMax);
      $rangeEnd =  $rangeStart;
      $barValues = $runReport-> loadCurrentWeekDays();
      $printBit = "0";
      $barChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $lineChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $printBit = "1";
      $chartType = "B";
      $barPrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $linePrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit); 
 
 
      //now we get the months in weeks
      $chartType = "B";
      $chartTitle = 'This Month';
      $xLabels = 'WOM';
      $yRangeMax = $runReport-> loadHighWeek(); 
      $rangeStart = $runReport-> loadYRange($yRangeMax);
      $rangeEnd =  $rangeStart;      
      $barValues = $runReport-> parseMonthWeeks();
      $barValues = explode(",",$barValues);
      $printBit = "0";
      $barChart2 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $lineChart2 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $printBit = "1";
      $chartType = "B";
      $barPrint2 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $linePrint2 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);      
      
      //now we get the quarters
      $chartType = "B";
      $chartTitle = 'Quarters';
      $xLabels = 'QOY';
      $yRangeMax = $runReport-> loadHighQuarter();
      $rangeStart = $runReport-> loadYRange($yRangeMax);
      $rangeEnd =  $rangeStart;      
      $barValues = $runReport-> parseQuarters();
      $barValues = explode(",",$barValues);
      $printBit = "0";
      $barChart3 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $lineChart3 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $printBit = "1";
      $chartType = "B";
      $barPrint3 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $linePrint3 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);      
            
      //now we get the months in the year
      $chartType = "B";
      $chartTitle = 'Year';
      $xLabels = 'MOY';
      $yRangeMax = $runReport-> loadHighMonth();
      $rangeStart = $runReport-> loadYRange($yRangeMax);
      $rangeEnd =  $rangeStart;      
      $barValues = $runReport-> parseMonths();
      $barValues = explode(",",$barValues);
      $printBit = "0";
      $barChart4 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $lineChart4 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $printBit = "1";
      $chartType = "B";
      $barPrint4 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
      $chartType = "L";
      $linePrint4 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);      
      
      $summary = $runReport-> createSummaryOne();
      
     // $test =  '<tr><td class=\"black2\">Today</td><td class=\"black2\">2</td><td class=\"black2\">114.00</td><td class=\"black2\">170.00</td><td class=\"black2\">400.00</td></tr>';

      echo"4|$barChart1|$lineChart1|$barChart2|$lineChart2|$barChart3|$lineChart3|$barChart4|$lineChart4|$summary|$barPrint1|$linePrint1|$barPrint2|$linePrint2|$barPrint3|$linePrint3|$barPrint4|$linePrint4";
      
     }else{

     //below takes care of date range
     $ruleType = $runReport-> loadRuleType();
 
     switch($ruleType) {
            //takes care of days
            case "1":
            $chartType = "B";
            $chartTitle = 'Days';
            $xLabels = 'DAY';
            $xLabelBottom = $runReport-> getXLabelDays();
            $xLabelBottom = explode(",",$xLabelBottom);
            $yRangeMax = $runReport-> getHighDay();
            $rangeStart = $runReport-> loadYRange($yRangeMax);
            $rangeEnd =  $rangeStart;              
            $barValues = $runReport-> getDays();
            $barValues = explode(",",$barValues);
            $printBit = "0";
            $barChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
            $chartType = "L";            
            $lineChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit); 
            $printBit = "1";
            $chartType = "B";
            $barPrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);
            $chartType = "L";
            $linePrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit);            
            
            $summary = $runReport-> getDaysSummary();            
            echo"1|$barChart1|$lineChart1|$summary|$barPrint1|$linePrint1";          
            break;
            
            case "2":
            $chartType = "B";
            $chartTitle = 'Months';
            $xLabels = 'MON';
            $xLabelBottom = $runReport-> getXLabelMonths();
            $xLabelBottom = explode(",",$xLabelBottom);
            $yRangeMax = $runReport-> getHighMonth();
            $rangeStart = $runReport-> loadYRange($yRangeMax);
            $rangeEnd =  $rangeStart;  
            $barValues = $runReport-> getMonths();
            $barValuesTwo = $runReport-> getMonthsTwo();
            
            if($barValuesTwo != null) {
              $barValuesTwo = explode(",",$barValuesTwo);
              }
                            
            $barValues = explode(",",$barValues);
            $printBit = "0";
            $barChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);
            $chartType = "L";            
            $lineChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);  
            $printBit = "1";
            $chartType = "B";
            $barPrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);
            $chartType = "L";
            $linePrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);              
            
            $summary = $runReport-> getMonthsSummary(); 
      
            echo"2|$barChart1|$lineChart1|$summary|$barPrint1|$linePrint1";    
            break;
                       
            case "3":
            $chartType = "B";
            $chartTitle = 'Years';
            $xLabels = 'YEA';  
            $xLabelBottom = $runReport-> getXLabelYears();
            $xLabelBottom = explode(",",$xLabelBottom);
            $yRangeMax = $runReport-> getHighYear();
            $rangeStart = $runReport-> loadYRange($yRangeMax);
            $rangeEnd =  $rangeStart;
            $barValues = $runReport-> getYears();
            $barValuesTwo = $runReport-> getYearsTwo();
            
            if($barValuesTwo != null) {
              $barValuesTwo = explode(",",$barValuesTwo);
              }            
            
            $barValues = explode(",",$barValues);            
            $printBit = "0";
            $barChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);
            $chartType = "L";            
            $lineChart1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo); 
            $printBit = "1";
            $chartType = "B";
            $barPrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);
            $chartType = "L";
            $linePrint1 = loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit, $barValuesTwo);              
            
            $summary = $runReport-> getYearsSummary();
            
            echo"3|$barChart1|$lineChart1|$summary|$barPrint1|$linePrint1";
                        
            break;

         }
     
     

     }


}
?>