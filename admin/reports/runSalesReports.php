<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
error_reporting(E_ERROR | E_PARSE);

class  runSalesReports {

private  $clubId = null;
private  $groupType = null;
private  $serviceType = null;
private  $serviceOptions = null;
private  $salesType = null;
private  $salesName = null;
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
private  $ruleType = null;
private  $xLabelDays = null;
private  $highDay = null;
private  $days = null;
private  $xLabelMonths = null;
private  $numberOfMonths = null;
private  $highMonth = null;
private  $months = null;
private  $monthStart = null;
private  $monthEnd = null;
private  $monthsSummary = null;
private  $rangeStart = null;
private  $rangeIncriment = null;
private  $numberOfYears = null;
private  $xLabelYears = null;
private  $highYear = null;
private  $years = null;
private  $yearStart = null;
private  $yearEnd = null;
private  $yearsSummary = null;


function setClubId($clubId) {
        $this->clubId = $clubId;
         }

function setGroupType($groupType) {
        $this->groupType = $groupType;
         }

function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
         }

function setServiceOptions($serviceOptions) {
        $this->serviceOptions = $serviceOptions;
         }

function setSalesType($salesType) {
        $this->salesType = $salesType;
         }

function setSalesName($salesName) {
        $this->salesName = $salesName;
         }

function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
         }
         
function setToDate($toDate) {
        $this->toDate = $toDate;
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
function loadSqlStatements() {

if(($this->clubId == '0') || ($this->clubId == 'I')) {
  $sqlOne = "club_id IS NOT NULL";
  }else{
  $sqlOne = "club_id = '$this->clubId'";
  }

if($this->groupType == '0') {
  $sqlTwo = "AND group_type != ''";
  }else{
  $sqlTwo = "AND group_type = '$this->groupType'";
  }

if($this->serviceType == '0') {
  $sqlThree = "AND service_type != ''";
  }else{
  $sqlThree = "AND service_type = '$this->serviceType'";
  }

switch ($this->serviceOptions) {
        case "AA":
        $sqlFour = "AND service_term !=''";
        break;
        case "AP":
        $sqlFour = "AND service_term !='M' AND service_term !='PM'";
        break;  
        case "AM":
        $sqlFour = "AND service_term ='M' ";
        break; 
        case "CL":
        $sqlFour = "AND service_term ='C'";
        break; 
        case "SC":
        $sqlFour = "AND service_term ='SC'";
        break;            
        case "FT":
        $sqlFour = "AND service_term !='M' AND service_term !='PM' AND service_term != 'C' AND service_term != 'SC' AND term_type='T'";
        break;   
        case "MT":
        $sqlFour = "AND service_term ='M'  AND term_type='T'";
        break;               
        case "MO":
        $sqlFour = "AND service_term ='M' AND term_type='O'";
        break;          
      }      
//echo"$this->serviceOptions";
//exit;
 switch ($this->salesType) {
      case "0":
      $sqlFive = "AND sales_key != '0'";
      break;
      case "APF":
      $sqlFive = "AND service_type = 'P'";
      break;
      case "APM":
      $sqlFive = "AND service_type = 'E'";
      break;      
      case "SN":
      $sqlFive = "AND new_sale = 'Y'";
      break;
      case "SNP":
      $sqlFive = "AND new_sale = 'Y' AND service_type = 'P'";
      break;
      case "SNM":
      $sqlFive = "AND new_sale = 'Y' AND service_type = 'E'";
      break;      
      case "SU":
      $sqlFive = "AND upgrade = 'Y'";
      
         if($this->serviceOptions == 'MT') {
          $sqlFour = "AND service_term='PM' AND term_type='T'";
            }
         if($this->serviceOptions == 'MO') {
          $sqlFour = "AND service_term='PM' AND term_type='O'";
            }             
      
      break;       
      case "SUP":
      $sqlFive = "AND upgrade = 'Y' AND service_type = 'P'";
      break;       
      case "SUM":
      $sqlFive = "AND upgrade = 'Y' AND service_type = 'E'";
      
         if($this->serviceOptions == 'MT') {
          $sqlFour = "AND service_term='PM' AND term_type='T'";
            }
         if($this->serviceOptions == 'MO') {
          $sqlFour = "AND service_term='PM' AND term_type='O'";
            }             
      
      break;          
      case "SRP":
      $sqlFive = "AND renewal= 'Y' AND early_renewal = 'N'";
      break;           
      case "ERP":
      $sqlFive = "AND early_renewal = 'Y'";
      break;        
      case "ARP":
      $sqlFive = "AND renewal= 'Y'";
      break;           
    }

if($this->salesName == '0') {
   $sqlSix = "AND service_key !='' AND";
   }else{
   $sqlSix = "AND service_key = '$this->salesName' AND";
   }
   
   
 //checks for internet sale     
   if($this->clubId == 'I') {
     $sqlSeven = "AND internet = 'Y'";
     }else{
     $sqlSeven = "";
     }   
   
   
   
$this->searchSql = "$sqlOne $sqlTwo $sqlThree $sqlFour $sqlFive $sqlSix $sqlSeven";

}
//-----------------------------------------------------------------------------------------------
function loadHighDay() {

//use to get the max sum of a day in a range
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY DAY(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$startWeekDay' AND '$endWeekDay' GROUP BY DAY(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
   $total = round($total);
    return "$total";

}
//------------------------------------------------------------------------------------------------
function loadHighWeek() {

$firstDayOfMonth = date("Y-m-d H:i:s", mktime(0,0,0,date('m'),1,date('Y')));

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY WEEK(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
   $total = round($total);
    return "$total";


/*
select sale_date_time, SUM(COALESCE(group_price,0))  as total
from sales_info
where sale_date_time between '2013-05-01 00:00:00' and now()
group by week(sale_date_time) order by sum(group_price) desc limit 1;
*/
}
//-----------------------------------------------------------------------------------------------
function loadHighMonth() {

$firstDayOfYear = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$firstDayOfYear' AND NOW() GROUP BY MONTH(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
   $total = round($total);
    return "$total";

}
//-----------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------
function loadHighQuarter() {

$firstDayOfMonth = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$firstDayOfMonth' AND NOW() GROUP BY QUARTER(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
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
$stmt = $dbMain ->prepare("SELECT sale_date_time, SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time <= NOW() AND sale_date_time >= DATE_ADD('$today',interval -'$dayOfWeek' DAY) GROUP BY DAY(sale_date_time)");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($saleDateTime, $total);
$rowCount = $stmt->num_rows;

if($rowCount != 0)  {
    while($stmt->fetch()) {

      $this->dayList ="$saleDateTime|$total";
      $this->parseWeekDays();

      }  
  
  }else{  
  $this->weekList = "null,null,null,null,null,null,null";  
  }


$this->weekList = "$this->monday,$this->tuesday,$this->wednesday,$this->thursday,$this->friday,$this->saturday,$this->sunday";
$this->weekList = explode(",",$this->weekList);

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
$stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$start' AND '$end'  ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch(); 
   
   if($total == "") {
      $total =null;
      }
   
    return "$total,";

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$start' AND '$end' GROUP BY QUARTER(sale_date_time)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();

   if($total == "") {
      $total =null;
      }
   
    return "$total,";   
   
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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$start' AND '$end' GROUP BY MONTH(sale_date_time)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();

   if($total == "") {
      $total =null;
      }
   
    return "$total,";   


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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$start' AND NOW() GROUP BY day(sale_date_time)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$thisMonday' AND NOW()");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$monthStart' AND NOW()");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql QUARTER(sale_date_time) = QUARTER(CURRENT_DATE) AND YEAR(sale_date_time) = YEAR(CURRENT_DATE)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$yearStart' AND NOW()");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

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

setlocale(LC_MONETARY, 'en_US');
$this->singleDayTotal = money_format('%n', $this->singleDayTotal);
$this->currentWeekTotal = money_format('%n', $this->currentWeekTotal);
$this->currentMonthTotal = money_format('%n', $this->currentMonthTotal);
$this->currentQuarterTotal = money_format('%n', $this->currentQuarterTotal);
$this->currentYearTotal = money_format('%n', $this->currentYearTotal);
$this->hourProjected = money_format('%n', $this->hourProjected);
$this->weekProjection = money_format('%n', $this->weekProjection);
$this->monthProjection = money_format('%n', $this->monthProjection);
$this->quarterProjection = money_format('%n', $this->quarterProjection);
$this->yearProjection = money_format('%n', $this->yearProjection);

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
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY YEAR(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
   $this->highYear = round($total);
   
}
//--------------------------------------------------------------------------------------------------------
function loadHighMonthTwo() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(COALESCE(group_price,0))  AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY MONTH(sale_date_time) ORDER BY SUM(group_price) DESC LIMIT 1");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();
 
   $this->highMonth = round($total);
   
}
//---------------------------------------------------------------------------------------------------------
function loadDayList() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDateDays' AND '$this->toDateDays' GROUP BY day(sale_date_time)");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();

   if($total == "") {
      $total =null;
      }

   $this->days .="$total,";

}
//--------------------------------------------------------------------------------------------------------
function loadMonthListTwo() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->monthStart' AND '$this->monthEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();

   if($total == "") {
      $total =null;
      }
   
   $this->months .="$total, ";

}
//--------------------------------------------------------------------------------------------------------
function loadYearList() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->yearStart' AND '$this->yearEnd' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total);
   $stmt->fetch();

   if($total == "") {
      $total =null;
      }
   
   $this->years .="$total, ";

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
  $fromYear =date("Y", strtotime($this->fromDate));
  $fromMonth=date("m", strtotime($this->fromDate));
  $fromDay = "01";
  $start = date("Y-m-01", strtotime($this->fromDate));
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

    $year = date("Y", strtotime($this->fromDate));
    $month= date("m", strtotime($this->fromDate));
    $dayLast = date("t", strtotime($this->fromDate));
          
    $i=0;
    $monthCount = $this->numberOfMonths + 1;

  while($i < $monthCount) {  

         if($i == 0) {
            $this->monthStart = $this->fromDate;
            $this->monthEnd = date("Y-m-d H:i:s", mktime(23,59,59,$month,$dayLast,$year));
            }
            
         if(($i > 0) &&  ($i < $monthCount)) {
            $this->monthStart = date("Y-m-01 00:00:00", strtotime("$this->fromDate +$i month"));
            $last = date("t", strtotime($this->monthStart));
            $last = $last -1;
            $this->monthEnd = date("Y-m-d 23:59:59", strtotime("$this->monthStart +$last day"));            
            }
            
         $i++; 
         
          if($i == $monthCount) {
            $j = $i - 1;
            $this->monthStart = date("Y-m-01 00:00:00", strtotime("$this->fromDate +$j month"));
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
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();
   
 setlocale(LC_MONETARY, 'en_US');
 $total = money_format('%n', $total); 

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
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

$monthCount = $this->numberOfMonths +1;

 setlocale(LC_MONETARY, 'en_US');
 $total = money_format('%n', $total); 

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

}
//------------------------------------------------------------------------------------------------
function createSummaryFour() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT SUM(group_price) AS total, COUNT(sales_key) AS sales_count FROM sales_info WHERE $this->searchSql sale_date_time BETWEEN '$this->fromDate' AND '$this->toDate' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($total, $sales_count);
   $stmt->fetch();

$yearCount = $this->numberOfYears +1;

 setlocale(LC_MONETARY, 'en_US');
 $total = money_format('%n', $total); 


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

}
//------------------------------------------------------------------------------------------------
function loadRuleType() {

$date1 = new DateTime($this->fromDate); //inclusive
$date2 = new DateTime($this->toDate); //exclusive
$diff = $date2->diff($date1);
$this->numberOfDays = $diff->format("%a"); 


if($this->numberOfDays <= 31) {
   $this->ruleType = 1;
   $this->loadXLabels();
   $this->loadHighDay();
   $this->parseDays();
   $this->createSummaryTwo();
   }

if(($this->numberOfDays > 31) && ($this->numberOfDays <= 365)) {
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
function getYearsSummary() {
     return($this->yearsSummary);
     }


}
//#####################################################################




//==================================================================
//==================================================================
//==================================================================
function loadChart($chartTitle, $chartType, $barValues, $xLabels, $yRangeMax, $xLabelBottom, $rangeStart, $rangeEnd, $printBit) {

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

//sets a top label for printing
if($printBit == "1") {
   $chart->add_element( $tags );
   }
   
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_number_format(2, true, false, true );
$chart->set_bg_colour( '#FFFFFF' );
$chart->set_tooltip( $t );

$chartCode = $chart->toString();

return $chartCode;
}
//===================================================
//===================================================
//===================================================

$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$group_type = $_REQUEST['group_type'];
$service_type = $_REQUEST['service_type'];
$service_options = $_REQUEST['service_options'];
$sales_type = $_REQUEST['sales_type'];                         
$sales_name = $_REQUEST['sales_name'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];                         

if($ajax_switch == "1") {

   $from_date = trim($from_date);
   $to_date = trim($to_date);
   
   if($from_date != "") {
      $start_date = date("Y-m-d H:i:s", strtotime($from_date));
     }else{
      $start_date = date("Y-m-d H:i:s", mktime(0,0,0,1,1,date('Y')));
     }
   if($to_date != "") {
      $year = date("Y", strtotime($to_date));
      $month = date("m", strtotime($to_date));
      $day = date("d", strtotime($to_date));
      $end_date = date("Y-m-d H:i:s",mktime(23,59,59,$month,$day,$year));
     }else{
      $end_date = date("Y-m-d H:i:s");
     }   
      
    $runReport = new runSalesReports();
    $runReport-> setClubId($club_id);
    $runReport-> setGroupType($group_type);
    $runReport-> setServiceType($service_type);
    $runReport-> setServiceOptions($service_options);
    $runReport-> setSalesType($sales_type);
    $runReport-> setSalesName($sales_name);
    $runReport-> setFromDate($start_date);
    $runReport-> setToDate($end_date);
    $runReport-> loadSqlStatements();
   
   
   //check to see if a date range is present. if not mage year to day report
   if($from_date == "" ||  $to_date == "")  {
     
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
      $barValues = $runReport->  parseQuarters();
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
      
      //$test =  '<tr><td class=\"black2\">Today</td><td class=\"black2\">2</td><td class=\"black2\">114.00</td><td class=\"black2\">170.00</td><td class=\"black2\">400.00</td></tr>';

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
            
            $summary = $runReport-> getYearsSummary();
            
            echo"3|$barChart1|$lineChart1|$summary|$barPrint1|$linePrint1";
                        
            break;

         }
     
     

     }


}
?>