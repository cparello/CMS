<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  balData{

function setClubId($clubId){
    $this->clubId = $clubId;
}
function setClubName($clubName){
    $this->clubName = $clubName;
}
function setDate($date){
    $this->date = $date;
}
function setDate2($date2){
    $this->date2 = $date2;
}

//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {
      
    $this->date2 = trim($this->date2);
    if($this->date2 == ""){
         $this->date2 = $this->date;
    }
    $dateArr = explode('/',$this->date);
    $month = $dateArr[0];
    $day = $dateArr[1];
    $year = $dateArr[2];
    $dateArr2 = explode('/',$this->date2);
    $month2 = $dateArr2[0];
    $day2 = $dateArr2[1];
    $year2 = $dateArr2[2];
    
   $this->date = date('Y-m-d H:i:s', mktime(0,0,0,$month,$day,$year));
   $this->date2 = date('Y-m-d H:i:s', mktime(23,59,59,$month2,$day2,$year2)); 
//echo "nfgnfgnfghfgfgfg$this->date' AND '$this->date2";
 // exit;
   $dbMain = $this->dbconnect();
   
    if($this->clubId == 1){
        $searchString = "";
    }else{
         $searchString = " AND club_id = '$this->clubId'";
    }
    
 
 
      $bool = 0;
      $total = 0;
      $cc = 0;
      
    $counter = 1;
  
  $date = date('F d Y',strtotime($this->monthStart));
  
    $mStart = date('Y-m-d H:i:s', mktime(0,0,0,$month,1,$year));
    $mEnd = date('Y-m-d H:i:s', mktime(23,59,59,$month2,date('t',strtotime($mStart)),$year2));
    

    
  
  $this->rows .= "<div id=\"totals\"> <h2>Balances:</h2>
  </div>"; 
  
  $this->rows .= "<table id=\"listings\" class=\"tablesorter\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>
  <thead>
   <tr class=\"tableCenter\">
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Record #</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Total Cost</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Amount Paid</font></th>
  <th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Balance Due</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Due Date</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Days Pastdue</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Phone Number</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Email</font></th>
  </tr>
  </thead>
  <tbody>"; 

    $stmt3 = $dbMain->prepare("SELECT contract_key, balance_due, todays_payment, min_total_due , due_date FROM initial_payments WHERE due_status ='G' AND (process_date BETWEEN '$this->date' AND '$this->date2') $searchString");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $balance_due, $todays_payment, $min_total_due, $due_date);
    while($stmt3->fetch()){
        
        $due_dateSecs = strtotime($due_date);
        $todaySecs = time();
        $daysPast = round(($todaySecs - $due_dateSecs)/86400,0);
        
      if($min_total_due != $balance_due AND $balance_due > 0 AND $daysPast > 0 AND $min_total_due != $todays_payment){
            
        
        
        $due_date = date('m-d-Y',$due_dateSecs);
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name, primary_phone, email FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname, $primary_phone, $email);
        $stmt->fetch();
        $stmt->close();
        
        
        
        $total += $balance_due;
        
        if($daysPast > 30){
            $className2 = "cell1";
        }elseif($daysPast > 14){
            $className2 = "cell2";
        }else{
            $className2 = "cell3";
        }
        
        
        if($bool == 0){
            $className = "row1";
            $bool = 1;
        }elseif($bool == 1){
            $className = "row2";
            $bool = 0;
        }
        $this->rows .=    "<tr class=\"$className tableCenter\">
                <td>
                $counter
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" ><span id=\"contract_key\"></span></a>
                </td>
                <td>
                <a  href=\"#\" onclick=\"doSomething($contract_key);\" ><span id=\"name\">$mem_fname $mem_lname</span></a>
                </td>
                <td>
                $$min_total_due
                </td>
                <td>
                $$todays_payment
                </td>
                <td>
                $$balance_due
                </td>
                <td>
                $due_date
                </td>
                <td class=\"$className2\">
                $daysPast
                </td>
                <td>
                $primary_phone
                </td>
                <td>
                $email
                </td>
                </tr>";
                        
        
        $count++;
        $counter++;
        $balance_due  = "";
        $todays_payment  = "";
        $min_total_due  = "";
        $due_date  = "";
        $contract_key  = "";
        $mem_fname  = "";
        $mem_lname  = "";
        }
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    
    
   
    
     $this->rows .= "</tbody></table>";
    
    $this->rows .=" <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=100%>
    <thead>
    <tr class=\"tableCenter\">
  <th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Total Balances Due</font></th>
  <th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Number of Balances</font></th>
  </tr></thead><tbody>"; 
    
    $this->rows .=    "<tr class=\"tableCenter\">
                        <td>
                        $$total
                        </td>
                        <td>
                        $count
                        </td>
                        </tr>
                        </tbody>
                        </table>";
    
   
    
   
    
}
//======================================================
function getRows(){
    return($this->rows);
}
}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$clubId = $_REQUEST['clubId'];
$date = $_REQUEST['date'];
$date2 = $_REQUEST['date2'];

$clubArr = explode('|',$clubId);
$clubId = $clubArr[0];
$clubName = $clubArr[1];

if($ajax_switch == "1") {

$all_select =1;
$attendence = new balData();
$attendence-> setClubId($clubId);
$attendence-> setClubName($clubName);
$attendence-> setDate($date);
$attendence-> setDate2($date2);
$attendence-> loadData();
$rows = $attendence-> getRows();

echo"$rows";
exit;


}



?>