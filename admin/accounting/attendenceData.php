<?php
session_start();


//this class formats the dropdown menu for clubs and facilities
class  attendenceData{

function setClubId($clubId){
    $this->clubId = $clubId;
}

function setDate($date){
    $this->date = $date;
}

function setBin($bIn){
    $this->bIn = $bIn;
}

function setBout($bOut){
    $this->bOut = $bOut;
}

function setAin($aIn){
    $this->aIn = $aIn;
}

function setAout($aOut){
    $this->aOut = $aOut;
}

//connect to database
function dbconnect()   {
include "../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------------------
function loadData() {

 $dbMain = $this->dbconnect();
 $bool = 0;
 $buffDateSecs = strtotime($this->date);
// echo "$this->date";
$dayStart = date('Y-m-d H:i:s',mktime(0,0,0,date('m',$buffDateSecs),date('d',$buffDateSecs),date('Y',$buffDateSecs)));
$dayEnd = date('Y-m-d H:i:s',mktime(23,59,59,date('m',$buffDateSecs),date('d',$buffDateSecs),date('Y',strtotime($this->date))));

 $counterGroup = 1;
$stmt777 = $dbMain ->prepare("SELECT DISTINCT user_id FROM admin_passwords WHERE user_id != ''");
echo($dbMain->error);
$stmt777->execute();      
$stmt777->store_result();      
$stmt777->bind_result($user_id); 
while($stmt777->fetch()){
    $userClubIdArr = "";
    //echo "user $user_id";
        $testCount = 0;
        $stmt1 = $dbMain ->prepare("SELECT type_key FROM basic_compensation  WHERE user_id = '$user_id' AND type_key != ''");
        $stmt1->execute();      
        $stmt1->store_result();      
        $stmt1->bind_result($type_key); 
        while($stmt1->fetch()){
            $club_id = "";
            $stmt1 = $dbMain ->prepare("SELECT club_id FROM employee_type  WHERE type_key = '$type_key'");
            $stmt1->execute();      
            $stmt1->store_result();      
            $stmt1->bind_result($club_id); 
            $stmt1->fetch();
            $stmt1->close();
            if($club_id != ""){
                $userClubIdArr .= "$club_id|";
                $clubIdChecked = $club_id;
            }
            
        }
        $stmt1->close();
        
        $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$clubIdChecked'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($clubName); 
        $stmt->fetch();
        $stmt->close();
        
        $userClubIdArr = explode("|",$userClubIdArr);
        
   //echo "$this->clubId";
    if(in_array($this->clubId,$userClubIdArr) OR $this->clubId == 1){
        
    
   
    
    $stmt99 = $dbMain ->prepare("SELECT emp_fname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($first, $last); 
    $stmt99->fetch();
    $stmt99->close();
    
    
    
    $stmt99 = $dbMain ->prepare("SELECT monday_shift_start1, monday_shift_end1,	monday_shift_start2,	monday_shift_end2,	tuesday_shift_start1,	tuesday_shift_end1,	tuesday_shift_start2,	tuesday_shift_end2,	wednesday_shift_start1,	wednesday_shift_end1,	wednesday_shift_start2,	wednesday_shift_end2,	thursday_shift_start1,	thursday_shift_end1,	thursday_shift_start2,
	thursday_shift_end2,	friday_shift_start1,	friday_shift_end1,	friday_shift_start2,	friday_shift_end2,	saturday_shift_start1,	saturday_shift_end1,	saturday_shift_start2,	saturday_shift_end2,	sunday_shift_start1,	sunday_shift_end1,	sunday_shift_start2, sunday_shift_end2   FROM employee_schedule WHERE user_id = '$user_id'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($monday_shift_start1, $monday_shift_end1,$monday_shift_start2,$monday_shift_end2,$tuesday_shift_start1,$tuesday_shift_end1,$tuesday_shift_start2,$tuesday_shift_end2,$wednesday_shift_start1,$wednesday_shift_end1,$wednesday_shift_start2,$wednesday_shift_end2,$thursday_shift_start1,$thursday_shift_end1,$thursday_shift_start2, $thursday_shift_end2,$friday_shift_start1,$friday_shift_end1,	$friday_shift_start2,$friday_shift_end2,$saturday_shift_start1,	$saturday_shift_end1,$saturday_shift_start2,$saturday_shift_end2,$sunday_shift_start1,$sunday_shift_end1,$sunday_shift_start2,$sunday_shift_end2); 
    $stmt99->fetch();
    $stmt99->close();
    
     //echo "test $dayStart' AND '$dayEnd $user_id";
    $counter = 0;
    $stmt22 = $dbMain ->prepare("SELECT id_card, clock_in, clock_out FROM timeclock WHERE (clock_in BETWEEN '$dayStart' AND '$dayEnd') AND user_id = '$user_id'");
    $stmt22->execute();      
    $stmt22->store_result();      
    $stmt22->bind_result($id_card, $clock_in, $clock_out); 
    while($stmt22->fetch()){
         $flag = "";
        
   $dateFormatted = date('F j, Y', strtotime($dayStart));
    
    
    
    if($clock_in != ""){
    //echo"$clock_in";
        $month = date('m',strtotime($dayStart));
        $day = date('d',strtotime($dayStart));
        $year = date('Y',strtotime($dayStart));
        $numDay = date('N',strtotime($clock_in));
        switch ($numDay){
            case '1':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
             if(($monday_shift_start1 == 0 OR $monday_shift_start1 == "") AND ($monday_shift_end1 == 0 OR $monday_shift_end1 == "") AND ($monday_shift_start2 == 0 OR $monday_shift_start2 == "") AND ($monday_shift_end2 == 0 OR $monday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($monday_shift_start1) > 2){
                    $hours = substr($monday_shift_start1,0,2);
                    $mins = substr($monday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($monday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                    if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                 }
                 
                 if(strlen($monday_shift_end1) > 2){
                    $hours = substr($monday_shift_end1,0,2);
                    $mins = substr($monday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($monday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2);
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    } 
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                   
                 }
             }elseif($counter == 1){
                if(strlen($monday_shift_start2) > 2){
                    $hours = substr($monday_shift_start2,0,2);
                    $mins = substr($monday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($monday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                   
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                   
                 }
                 
                 if(strlen($monday_shift_end2) > 2){
                    $hours = substr($monday_shift_end2,0,2);
                    $mins = substr($monday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($monday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 22</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
             
             
             
            break;
            case '2':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($tuesday_shift_start1 == 0 OR $tuesday_shift_start1 == "") AND ($tuesday_shift_end1 == 0 OR $tuesday_shift_end1 == "") AND ($tuesday_shift_start2 == 0 OR $tuesday_shift_start2 == "") AND ($tuesday_shift_end2 == 0 OR $tuesday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($tuesday_shift_start1) > 2){
                    $hours = substr($tuesday_shift_start1,0,2);
                    $mins = substr($tuesday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($tuesday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($tuesday_shift_end1) > 2){
                    $hours = substr($tuesday_shift_end1,0,2);
                    $mins = substr($tuesday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($tuesday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($tuesday_shift_start2) > 2){
                    $hours = substr($tuesday_shift_start2,0,2);
                    $mins = substr($tuesday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($tuesday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }
                 
                 if(strlen($tuesday_shift_end2) > 2){
                    $hours = substr($tuesday_shift_end2,0,2);
                    $mins = substr($tuesday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($tuesday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            case '3':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($wednesday_shift_start1 == 0 OR $wednesday_shift_start1 == "") AND ($wednesday_shift_end1 == 0 OR $wednesday_shift_end1 == "") AND ($wednesday_shift_start2 == 0 OR $wednesday_shift_start2 == "") AND ($wednesday_shift_end2 == 0 OR $wednesday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($wednesday_shift_start1) > 2){
                    $hours = substr($wednesday_shift_start1,0,2);
                    $mins = substr($wednesday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($wednesday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($wednesday_shift_end1) > 2){
                    $hours = substr($wednesday_shift_end1,0,2);
                    $mins = substr($wednesday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($wednesday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($wednesday_shift_start2) > 2){
                    $hours = substr($wednesday_shift_start2,0,2);
                    $mins = substr($wednesday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($wednesday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }
                 
                 if(strlen($wednesday_shift_end2) > 2){
                    $hours = substr($wednesday_shift_end2,0,2);
                    $mins = substr($wednesday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($wednesday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            case '4':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($thursday_shift_start1 == 0 OR $thursday_shift_start1 == "") AND ($thursday_shift_end1 == 0 OR $thursday_shift_end1 == "") AND ($thursday_shift_start2 == 0 OR $thursday_shift_start2 == "") AND ($thursday_shift_end2 == 0 OR $thursday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($thursday_shift_start1) > 2){
                    $hours = substr($thursday_shift_start1,0,2);
                    $mins = substr($thursday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($thursday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($thursday_shift_end1) > 2){
                    $hours = substr($thursday_shift_end1,0,2);
                    $mins = substr($thursday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($thursday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($thursday_shift_start2) > 2){
                    $hours = substr($thursday_shift_start2,0,2);
                    $mins = substr($thursday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($thursday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }
                 
                 if(strlen($thursday_shift_end2) > 2){
                    $hours = substr($thursday_shift_end2,0,2);
                    $mins = substr($thursday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($thursday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                 
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2/span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            case '5':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($friday_shift_start1 == 0 OR $friday_shift_start1 == "") AND ($friday_shift_end1 == 0 OR $friday_shift_end1 == "") AND ($friday_shift_start2 == 0 OR $friday_shift_start2 == "") AND ($friday_shift_end2 == 0 OR $friday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($friday_shift_start1) > 2){
                    $hours = substr($friday_shift_start1,0,2);
                    $mins = substr($friday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($friday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($friday_shift_end1) > 2){
                    $hours = substr($friday_shift_end1,0,2);
                    $mins = substr($friday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($friday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($friday_shift_start2) > 2){
                    $hours = substr($friday_shift_start2,0,2);
                    $mins = substr($friday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($friday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2);  
                    if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }
                 
                 if(strlen($friday_shift_end2) > 2){
                    $hours = substr($friday_shift_end2,0,2);
                    $mins = substr($friday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($friday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            case '6':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($saturday_shift_start1 == 0 OR $saturday_shift_start1 == "") AND ($saturday_shift_end1 == 0 OR $saturday_shift_end1 == "") AND ($saturday_shift_start2 == 0 OR $saturday_shift_start2 == "") AND ($saturday_shift_end2 == 0 OR $saturday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($saturday_shift_start1) > 2){
                    $hours = substr($saturday_shift_start1,0,2);
                    $mins = substr($saturday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($saturday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                   
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($saturday_shift_end1) > 2){
                    $hours = substr($saturday_shift_end1,0,2);
                    $mins = substr($saturday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($saturday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2);
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    } 
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($saturday_shift_start2) > 2){
                    $hours = substr($saturday_shift_start2,0,2);
                    $mins = substr($saturday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($saturday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    
                 }
                 
                 if(strlen($saturday_shift_end2) > 2){
                    $hours = substr($saturday_shift_end2,0,2);
                    $mins = substr($saturday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($saturday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\"Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            case '7':
                    $scheduledStartSecs = "";
                    $scheduledEndSecs = "";
                    $actualStartSecs = "";
                    $actualEndSecs = "";
                    if(($sunday_shift_start1 == 0 OR $sunday_shift_start1 == "") AND ($sunday_shift_end1 == 0 OR $sunday_shift_end1 == "") AND ($sunday_shift_start2 == 0 OR $sunday_shift_start2 == "") AND ($sunday_shift_end2 == 0 OR $sunday_shift_end2 == "")){
                $flag .= "<span class=\"ns\">Not Scheduled</span><br>";
                $actualStartSecs = strtotime($clock_in);
                $actualEndSecs = strtotime($clock_out);
                $aStart =  date('h:i A',$actualStartSecs);
                $aEnd = date('h:i A',$actualEndSecs);
             }elseif($counter == 0){
                if(strlen($sunday_shift_start1) > 2){
                    $hours = substr($sunday_shift_start1,0,2);
                    $mins = substr($sunday_shift_start1,2);
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart1 = date('Y-m-d H:i:s',mktime($sunday_shift_start1,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart1);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\">Late Clockin $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins</span><br>";
                    }
                    
                 }
                 
                 if(strlen($sunday_shift_end1) > 2){
                    $hours = substr($sunday_shift_end1,0,2);
                    $mins = substr($sunday_shift_end1,2);
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd1 = date('Y-m-d H:i:s',mktime($sunday_shift_end1,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd1);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins</span><br>";
                    }
                    
                 }
             }elseif($counter == 1){
                if(strlen($sunday_shift_start2) > 2){
                    $hours = substr($sunday_shift_start2,0,2);
                    $mins = substr($sunday_shift_start2,2);
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftStart2 = date('Y-m-d H:i:s',mktime($sunday_shift_start2,0,0,$month,$day,$year));
                 }
                 $scheduledStartSecs = strtotime($clockInShiftStart2);
                 $actualStartSecs = strtotime($clock_in);
                 if($scheduledStartSecs > $actualStartSecs){
                    $buff = ($scheduledStartSecs - $actualStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bIn){
                        $flag .= "<span class=\"overFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early Clockin $buff Mins Shift 2</span><br>";
                    }
                    $flag .= "";
                 }elseif($scheduledStartSecs < $actualStartSecs){
                    $buff = ($actualStartSecs - $scheduledStartSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aIn){
                        $flag .= "<span class=\"overFlag\"Late Clockin $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late Clockin $buff Mins Shift 2</span><br>";
                    }
                    $flag .= "br>";
                 }
                 
                 if(strlen($sunday_shift_end2) > 2){
                    $hours = substr($sunday_shift_end2,0,2);
                    $mins = substr($sunday_shift_end2,2);
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($hours,$mins,0,$month,$day,$year));
                 }else{
                    $clockInShiftEnd2 = date('Y-m-d H:i:s',mktime($sunday_shift_end2,0,0,$month,$day,$year));
                 }
                 $scheduledEndSecs = strtotime($clockInShiftEnd2);
                 $actualEndSecs = strtotime($clock_out);
                 if($scheduledEndSecs > $actualEndSecs){
                    $buff = ($scheduledEndSecs - $actualEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->bOut){
                        $flag .= "<span class=\"overFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Early ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }elseif($scheduledEndSecs < $actualEndSecs){
                    $buff = ($actualEndSecs - $scheduledEndSecs)/60;
                    $buff = round($buff, 2); 
                     if($buff >= $this->aOut){
                        $flag .= "<span class=\"overFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }else{
                        $flag .= "<span class=\"justFlag\">Late ClockOut $buff Mins Shift 2</span><br>";
                    }
                    
                 }
             }
             if($scheduledStartSecs != ""){
                     $start = date('h:i A',$scheduledStartSecs);
                     $end = date('h:i A',$scheduledEndSecs);
                     $aStart =  date('h:i A',$actualStartSecs);
                     $aEnd = date('h:i A',$actualEndSecs);
             }else{
                     $start = "";
                     $end = "";
             }
            break;
            default:
                
            break;
        }
       
    }else{
       
                $flag = "<span class=\"abs\">Absent</span>";
                 $start = "";
             $end = "";
             $aStart =  date('h:i A',$clock_in);
             $aEnd = date('h:i A',$clock_out);
         
         
       }
        $counter++;
        if($bool == 0){
            $className = "row1";
            $bool = 1;
        }elseif($bool == 1){
            $className = "row2";
            $bool = 0;
        }
       // echo "test";
         $this->rows .="<tr id=\"a$counterGroup\" class=\"$className\">
                    <td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$counterGroup</b></font></td>
                    <td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$clubName</b></font></td>
                    <td align=\"left\" valign =\"top\">$first</td>
                    <td align=\"left\" valign =\"top\">$last</td>
                    <td align=\"left\" valign =\"top\">$dateFormatted</td>
                    <td align=\"left\" valign =\"top\">$start</td>
                    <td align=\"left\" valign =\"top\">$end</td>
                    <td align=\"left\"  valign =\"top\">$aStart</td>
                    <td align=\"left\"  valign =\"top\">$aEnd</td>
                    <td align=\"left\"  valign =\"top\">$flag</td>
                    </tr>\n";

      $counterGroup++;
     }
    $stmt22->close();
    $numDay = "";
    }
     }
$stmt777->close();

if($counterGroup == 1){
    $this->rows .="<tr id=\"a$counterGroup\" class=\"$className\"><td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"15\" color=\"black\"><b>No data</b></font></td></tr>\n";
}

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<thead>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Counter</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">First name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Last Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Scheduled Time-In</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Scheduled Time-Out</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock-In Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock-Out Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Variance</font></th>
</tr>
</thead>
<tbody>\n"; 

 $this->rows ="$table_header$this->rows";
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
$bIn = $_REQUEST['bIn'];
$bOut = $_REQUEST['bOut'];
$aIn = $_REQUEST['aIn'];
$aOut = $_REQUEST['aOut'];
//echo "tes$date";
//exit;
if($ajax_switch == "1") {

$all_select =1;
$attendence = new attendenceData();
$attendence-> setClubId($clubId);
$attendence-> setDate($date);
$attendence-> setBin($bIn);
$attendence-> setBout($bOut);
$attendence-> setAin($aIn);
$attendence-> setAout($aOut);
$attendence-> loadData();
$rows = $attendence-> getRows();

echo"$rows";
exit;


}



?>