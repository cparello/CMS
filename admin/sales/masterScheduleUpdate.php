<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
class scheduleUpdate{
    
 //connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setDate($date){
    $this->date = $date;
}
function setPhone($phone){
    $this->phone = $phone;
}
function setNotes($notes){
    $this->notes = $notes;
}
function setName($name){
    $this->name = $name;
}
function setUserId($userId){
    $this->userId = $userId;
}
//====================================================================================
function deleteAppt(){

$date = date("Y-m-d H:i:s",strtotime($this->date));    
    
$dbMain = $this->dbconnect();
$sql13 = "DELETE FROM sales_appointments WHERE user_id = '$this->userId' AND appointment_date_time = '$date'";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();
}
//====================================================================================
function saveAppt(){
    
$nameArray = explode(' ',$this->name);
$firstName = $nameArray[0];
$lastName = "$nameArray[1]$nameArray[2]$nameArray[3]";
$date = date("Y-m-d H:i:s",strtotime($this->date));    
   // echo "$key, $this->userId, $firstName, $lastName, $this->phone, $this->notes, $date";
$key = 0;
$dbMain = $this->dbconnect();
$sql = "INSERT INTO sales_appointments VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisssss',$key, $this->userId, $firstName, $lastName, $this->phone, $this->notes, $date); 
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close();  
}
 //======================================================================================  
function loadMain(){
    //$this->saveAppt();
}   
//=================================================================================================
}

$marker = $_REQUEST['marker'];
$start_range = $_REQUEST['start_range'];
$end_range = $_REQUEST['end_range'];
$user_id = $_REQUEST['user_id'];
$date = $_REQUEST['date'];
$phone = $_REQUEST['phone'];
$notes = $_REQUEST['notes'];
$phone = $_REQUEST['phone'];
$name = $_REQUEST['name'];
$datepicker = $_REQUEST['datepicker'];

if ($date == ''){
    $date = date('Y-m-d H:i:s');
}
$yesterday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')));
$yesterdayFormatted = date('F j Y',mktime(0,0,0,date('m'),date('d')-1,date('Y')));
$tomorrow = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
$tomorrowFormatted = date('F j Y',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
$dateFormated = date('Y-m-d');
$todaysDate = date('F j Y');
$todaysDate22 = date('Y-m-d');

$datePickDate = date('m-d');
$start_range = date('Y-m-d H:i:s', strtotime($start_range));
$end_range = date('Y-m-d H:i:s', mktime(23,59,59,date('m',strtotime($end_range)),date('d',strtotime($end_range)),date('Y',strtotime($end_range))));
//echo "fubar m $marker ssss $start_range eee $end_range d $date p $phone n $notesp $phone n $name uid $user_id ";//update the data base if form is submitted
//exit;
if($marker == 6)       {
$start_range = date('Y-m-d H:i:s', strtotime($datepicker));
$end_range = date('Y-m-d H:i:s', mktime(23,59,59,date('m',strtotime($datepicker)),date('d',strtotime($datepicker)),date('Y',strtotime($datepicker))));
}

//echo "fubar $marker";//update the data base if form is submitted

if($marker == 1)       {
$todaysDate = date('F j Y',strtotime($start_range));
$update = new scheduleUpdate();
$update->setDate($date);
$update->setPhone($phone);
$update->setNotes($notes);
$update->setName($name);
$update->setUserId($user_id);
$update->saveAppt();

$confirm = "<font size=\"4\" color=\"#CC0033\" face=\"arial\">Appointment Successfully Scheduled</font>";
}

if($marker == 2) { 
$todaysDate = date('F j Y',strtotime($start_range));;

$update = new scheduleUpdate();
$update->setDate($date);
$update->setUserId($user_id);
$update->deleteAppt();

$confirm = "<font size=\"4\" color=\"#CC0033\" face=\"arial\">Appointment Successfully Deleted</font>";
}

require"../dbConnect.php";
$counterUID = 1;
$stmt = $dbMain ->prepare("SELECT DISTINCT user_id FROM employee_type JOIN basic_compensation ON basic_compensation.type_key = employee_type.type_key WHERE employee_type LIKE '%sale%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_id); 
while($stmt->fetch()){
    $arrayUserID[$counterUID] = $user_id;
   $counterUID++;
}
$stmt->close();

$counterUID = 1;
foreach($arrayUserID as $userId){
        $stmt = $dbMain ->prepare("SELECT emp_fname, emp_lname FROM employee_info  WHERE user_id = '$userId'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($emp_fname, $emp_lname); 
        $stmt->fetch();
        $stmt->close();
        
        $emp_fname = strtolower($emp_fname);
        $emp_fname = ucfirst($emp_fname);
        $emp_lname = strtolower($emp_lname);
        $emp_lname = ucfirst($emp_lname);
        
        $name = "$emp_fname $emp_lname";
        if (strlen($name)>17){
            $lNameTrim = substr($emp_lname,0,1);
            $name = "$emp_fname $lNameTrim.";
        }
        $arrayUserNames[$counterUID] = $name;
        $counterUID++;
}
//echo "$start_range AND  $end_range";
$stmt = $dbMain ->prepare("SELECT start1, end1, start2, end2 FROM sales_schedule_setup WHERE setup_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($start1, $end1, $start2, $end2); 
$stmt->fetch();
$stmt->close();    
    
$counterArray = 0;
for($c = $start1;$c<=$end1;$c++){
    $timesArrayNumbers[$counterArray] = $c;
    switch($c){
        case 6:
            $timesArray[$counterArray] = "6 AM";
        break;
        case 7:
            $timesArray[$counterArray] = "7 AM";
        break;
        case 8:
            $timesArray[$counterArray] = "8 AM";
        break;
        case 9:
            $timesArray[$counterArray] = "9 AM";
        break;
        case 10:
            $timesArray[$counterArray] = "10 AM";
        break;
        case 11:
            $timesArray[$counterArray] = "11 AM";
        break;
        case 12:
            $timesArray[$counterArray] = "12 AM";
        break;
        case 13:
            $timesArray[$counterArray] = "1 PM";
        break;
        case 14:
            $timesArray[$counterArray] = "2 PM";
        break;
        case 15:
            $timesArray[$counterArray] = "3 PM";
        break;
        case 16:
            $timesArray[$counterArray] = "4 PM";
        break;
        case 17:
            $timesArray[$counterArray] = "5 PM";
        break;
        case 18:
            $timesArray[$counterArray] = "6 PM";
        break;
        case 19:
            $timesArray[$counterArray] = "7 PM";
        break;
        case 20:
            $timesArray[$counterArray] = "8 PM";
        break;
        case 21:
            $timesArray[$counterArray] = "9 PM";
        break;
        case 22:
            $timesArray[$counterArray] = "10 PM";
        break;
        case 23:
            $timesArray[$counterArray] = "11 PM";
        break;
    }
    $counterArray++;
}
   
for($c = $start2;$c<=$end2;$c++){
    $timesArrayNumbers[$counterArray] = $c;
    switch($c){
        case 6:
            $timesArray[$counterArray] = "6 AM";
        break;
        case 7:
            $timesArray[$counterArray] = "7 AM";
        break;
        case 8:
            $timesArray[$counterArray] = "8 AM";
        break;
        case 9:
            $timesArray[$counterArray] = "9 AM";
        break;
        case 10:
            $timesArray[$counterArray] = "10 AM";
        break;
        case 11:
            $timesArray[$counterArray] = "11 AM";
        break;
        case 12:
            $timesArray[$counterArray] = "12 AM";
        break;
        case 13:
            $timesArray[$counterArray] = "1 PM";
        break;
        case 14:
            $timesArray[$counterArray] = "2 PM";
        break;
        case 15:
            $timesArray[$counterArray] = "3 PM";
        break;
        case 16:
            $timesArray[$counterArray] = "4 PM";
        break;
        case 17:
            $timesArray[$counterArray] = "5 PM";
        break;
        case 18:
            $timesArray[$counterArray] = "6 PM";
        break;
        case 19:
            $timesArray[$counterArray] = "7 PM";
        break;
        case 20:
            $timesArray[$counterArray] = "8 PM";
        break;
        case 21:
            $timesArray[$counterArray] = "9 PM";
        break;
        case 22:
            $timesArray[$counterArray] = "10 PM";
        break;
        case 23:
            $timesArray[$counterArray] = "11 PM";
        break;
    }
    $counterArray++;
}
   


$stmt = $dbMain ->prepare("SELECT appointment_id, user_id, first_name, last_name, phone, notes, appointment_date_time FROM sales_appointments WHERE (appointment_date_time BETWEEN '$start_range' AND  '$end_range')");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($appointment_id, $user_id2, $first_name, $last_name, $phone2, $notes2, $appointment_date_time); 
while($stmt->fetch()){
    $num = date('G',strtotime($appointment_date_time));
    
    $arrayNames[$user_id2][$num] = "$first_name $last_name";
    $arrayPhone[$user_id2][$num] = $phone2;
    $arrayNotes[$user_id2][$num] = $notes2;
    //echo "<br>dc $dayCode num $num<br>";
}
$stmt->close();
//var_dump($arrayNames);
$numUsers = count($arrayUserID);
$numUsers--;

//foreach($arrayUserID as $userId){
    foreach($timesArrayNumbers as $i){
        for($z=1;$z<=$numUsers;$z++){
            $bigNameArray[$z][$i] = $arrayNames[$arrayUserID[$z]][$i];
            $bigNameArray[$z][$i] = trim($bigNameArray[$z][$i]);
            if ($bigNameArray[$z][$i] == ''){
              $buttonClassArray[$z][$i] = "button";
              //$buttonTextArray[$z][$i] = "Schedule Appointment";
              $buttonTextArray[$z][$i] = "Book Appt.";
               $markerArray[$z][$i] = 1;
            }else{
             $buttonClassArray[$z][$i] = "button2";
             //$buttonTextArray[$z][$i] = "Cancel Appointment";
             $buttonTextArray[$z][$i] = "Cancel Appt.";
              $markerArray[$z][$i] = 2;
            }
            $phoneArray[$z][$i] = $arrayPhone[$arrayUserID[$z]][$i];
            $notesArray[$z][$i] = $arrayNotes[$arrayUserID[$z]][$i];
        }
  //  }
   // var_dump($bigNameArray);
}
//=========================================================



foreach($timesArrayNumbers as $x){
     for($z=1;$z<=$numUsers;$z++){
        $user_id = $arrayUserID[$z];
        $mondayStart1 = 0;
        $mondayEnd1 = 0;
        $mondayStart2 = 0;
        $mondayEnd2 = 0;
        $tuesdayStart1 = 0;
        $tuesdayEnd1 = 0;
        $tuesdayStart2 = 0;
        $tuesdayEnd2 = 0;
        $wednesdayStart1 = 0;
        $wednesdayEnd1 = 0;
        $wednesdayStart2 = 0;
        $wednesdayEnd2 = 0;
        $thursdayStart1 = 0;
        $thursdayEnd1 = 0;
        $thursdayStart2 = 0;
        $thursdayEnd2 = 0;
        $fridayStart1  = 0;
        $fridayEnd1 = 0;
        $fridayStart2 = 0;
        $fridayEnd2  = 0;
        $saturdayStart1 = 0;
        $saturdayEnd1 = 0;
        $saturdayStart2  = 0;
        $saturdayEnd2  = 0;
        $sundayStart1  = 0;
        $sundayEnd1 = 0;
        $sundayStart2  = 0;
        $sundayEnd2 = 0;
                $stmt = $dbMain ->prepare("SELECT monday_shift_start1, monday_shift_end1, monday_shift_start2, monday_shift_end2, tuesday_shift_start1, tuesday_shift_end1, tuesday_shift_start2, tuesday_shift_end2, wednesday_shift_start1, wednesday_shift_end1, wednesday_shift_start2, wednesday_shift_end2, thursday_shift_start1, thursday_shift_end1, thursday_shift_start2, thursday_shift_end2, friday_shift_start1, friday_shift_end1, friday_shift_start2, friday_shift_end2, saturday_shift_start1, saturday_shift_end1, saturday_shift_start2, saturday_shift_end2, sunday_shift_start1, sunday_shift_end1, sunday_shift_start2, sunday_shift_end2 FROM employee_schedule WHERE user_id=  '$user_id'");
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($mondayStart1, $mondayEnd1, $mondayStart2, $mondayEnd2, $tuesdayStart1, $tuesdayEnd1, $tuesdayStart2, $tuesdayEnd2, $wednesdayStart1, $wednesdayEnd1, $wednesdayStart2, $wednesdayEnd2, $thursdayStart1, $thursdayEnd1, $thursdayStart2, $thursdayEnd2, $fridayStart1 , $fridayEnd1, $fridayStart2,  $fridayEnd2 , $saturdayStart1, $saturdayEnd1, $saturdayStart2 , $saturdayEnd2 ,  $sundayStart1 ,  $sundayEnd1,  $sundayStart2 ,  $sundayEnd2); 
               $stmt->fetch();
                $stmt->close();
        
        
        $numberRepDay = date('N',strtotime($date));
        //echo "fubar $date $numberRepDay";
switch($numberRepDay){
    case 1:
         if ($mondayStart1 != 0  OR $mondayStart2 != 0){
            if (($mondayStart1 <= $x AND $mondayEnd1 >= $x) OR ($mondayStart2 <= $x AND $mondayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 2:
         if ($tuesdayStart1 != 0  OR $tuesStart2 != 0){
            if (($tuesdayStart1 <= $x AND $tuesdayEnd1 >= $x) OR ($tuesdayStart2 <= $x AND $tuesdayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 3:
         if ($wednesdayStart1 != 0  OR $wednesdayStart2 != 0){
            if (($wednesdayStart1 <= $x AND $wednesdayEnd1 >= $x) OR ($wednesdayStart2 <= $x AND $wednesdayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 4:
         if ($thursdayStart1 != 0  OR $thursdayStart2 != 0){
            if (($thursdayStart1 <= $x AND $thursdayEnd1 >= $x) OR ($thursdayStart2 <= $x AND $thursdayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 5:
        if ($fridayStart1 != 0  OR $fridayStart2 != 0){
            if (($fridayStart1 <= $x AND $fridayEnd1 >= $x) OR ($fridayStart2 <= $x AND $fridayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 6:
         if ($saturdayStart1 != 0  OR $saturdayStart2 != 0){
            if (($saturdayStart1 <= $x AND $saturdayEnd1 >= $x) OR ($saturdayStart2 <= $x AND $saturdayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
    case 7:
    //echo"test";
         if ($sundayStart1 != 0  OR $sundayStart2 != 0){
            if (($sundayStart1 <= $x AND $sundayEnd1 >= $x) OR ($sundayStart2 <= $x AND $sundayEnd2 >= $x)){
            $styleArray[$z][$x] = "s3x2";
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
        }else{
            $styleArray[$z][$x] = "s2x2";
        }
    break;
}
        
       
        
    }
}




if($marker == 3)       {
    $todaysDate = $yesterdayFormatted;
    $dateFormated = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-1,date('Y')));
    $datePickDate = date('m-d', mktime(0,0,0,date('m'),date('d')-1,date('Y')));

}
if($marker == 4)       {
     $todaysDate = $tomorrowFormatted;
     $dateFormated = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+1,date('Y')));
     $datePickDate = date('m-d', mktime(0,0,0,date('m'),date('d')+1,date('Y')));

}
if($marker == 5)       {
     $todaysDate = $todaysDate;
     $dateFormated = date('Y-m-d');
     $datePickDate = date('m-d');

}

if($marker == 6)       {
    $todaysDate = date('F j Y',strtotime($datepicker));
    $dateFormated = date('Y-m-d', mktime(0,0,0,date('m',strtotime($datepicker)),date('d',strtotime($datepicker)),date('Y',strtotime($datepicker))));
    $datePickDate = date('m-d', mktime(0,0,0,date('m',strtotime($datepicker)),date('d',strtotime($datepicker)),date('Y',strtotime($datepicker))));
}

//$timesArray = array('6 AM','7 AM','8 AM','9 AM','10 AM','11 AM','12 PM','1 PM','2 PM','3 PM','4 PM','5 PM','6 PM','7 PM','8 PM','9 PM','10 PM','11 PM');
$cssArray = array('p0x0','p1x0','p2x0','p3x0','p4x0','p5x0','p6x0','p7x0','p8x0','p9x0','p10x0','p11x0','p12x0','p13x0','p14x0','p15x0','p16x0','p17x0','p18x0','p19x0','p20x0');

$formatArray[1] =  array('p0x1','p1x1','p2x1','p3x1','p4x1','p5x1','p6x1','p7x1','p8x1','p9x1','p10x1','p11x1','p12x1','p13x1','p14x1','p15x1','p16x1','p17x1','p18x1','p19x1','p20x1');
$formatArray[2] =  array('p0x2','p1x2','p2x2','p3x2','p4x2','p5x2','p6x2','p7x2','p8x2','p9x2','p10x2','p11x2','p12x2','p13x2','p14x2','p15x2','p16x2','p17x2','p18x2','p19x2','p20x2');
$formatArray[3] =  array('p0x3','p1x3','p2x3','p3x3','p4x3','p5x3','p6x3','p7x3','p8x3','p9x3','p10x3','p11x3','p12x3','p13x3','p14x3','p15x3','p16x3','p17x3','p18x3','p19x3','p20x3');
$formatArray[4] =  array('p0x4','p1x4','p2x4','p3x4','p4x4','p5x4','p6x4','p7x4','p8x4','p9x4','p10x4','p11x4','p12x4','p13x4','p14x4','p15x4','p16x4','p17x4','p18x4','p19x4','p20x4');
$formatArray[5] =  array('p0x5','p1x5','p2x5','p3x5','p4x5','p5x5','p6x5','p7x5','p8x5','p9x5','p10x5','p11x5','p12x5','p13x5','p14x5','p15x5','p16x5','p17x5','p18x5','p19x5','p20x5');
$formatArray[6] =  array('p0x6','p1x6','p2x6','p3x6','p4x6','p5x6','p6x6','p7x6','p8x6','p9x6','p10x6','p11x6','p12x6','p13x6','p14x6','p15x6','p16x6','p17x6','p18x6','p19x6','p20x6');
$formatArray[7] =  array('p0x7','p1x7','p2x7','p3x7','p4x7','p5x7','p6x7','p7x7','p8x7','p9x7','p10x7','p11x7','p12x7','p13x7','p14x7','p15x7','p16x7','p17x7','p18x7','p19x7','p20x7');
$formatArray[8] =  array('p0x8','p1x8','p2x8','p3x8','p4x8','p5x8','p6x8','p7x8','p8x8','p9x8','p10x8','p11x8','p12x8','p13x8','p14x8','p15x8','p16x8','p17x8','p18x8','p19x8','p20x8');
$formatArray[9] =  array('p0x9','p1x9','p2x9','p3x9','p4x9','p5x9','p6x9','p7x9','p8x9','p9x9','p10x9','p11x9','p12x9','p13x9','p14x9','p15x9','p16x9','p17x9','p18x9','p19x9','p20x9');
$formatArray[10] =  array('p0x10','p1x10','p2x10','p3x10','p4x10','p5x10','p6x10','p7x10','p8x10','p9x10','p10x10','p11x10','p12x10','p13x10','p14x10','p15x10','p16x10','p17x10','p18x10','p19x10','p20x10');
$formatArray[11] =  array('p0x11','p1x11','p2x11','p3x11','p4x11','p5x11','p6x11','p7x11','p8x11','p9x11','p10x11','p11x11','p12x11','p13x11','p14x11','p15x11','p16x11','p17x11','p18x11','p19x11','p20x11');
$formatArray[12] =  array('p0x12','p1x12','p2x12','p3x12','p4x12','p5x12','p6x12','p7x12','p8x12','p9x12','p10x12','p11x12','p12x12','p13x12','p14x12','p15x12','p16x12','p17x12','p18x12','p19x12','p20x12');
$formatArray[13] =  array('p0x13','p1x13','p2x13','p3x13','p4x13','p5x13','p6x13','p7x13','p8x13','p9x13','p10x13','p11x13','p12x13','p13x13','p14x13','p15x13','p16x13','p17x13','p18x13','p19x13','p20x13');
$formatArray[14] =  array('p0x14','p1x14','p2x14','p3x14','p4x14','p5x14','p6x14','p7x14','p8x14','p9x14','p10x14','p11x14','p12x14','p13x14','p14x14','p15x14','p16x14','p17x14','p18x14','p19x14','p20x14');
$formatArray[15] =  array('p0x15','p1x15','p2x15','p3x15','p4x15','p5x15','p6x15','p7x15','p8x15','p9x15','p10x15','p11x15','p12x15','p13x15','p14x15','p15x15','p16x15','p17x15','p18x15','p19x15','p20x15');
$formatArray[16] =  array('p0x16','p1x16','p2x16','p3x16','p4x16','p5x16','p6x16','p7x16','p8x16','p9x16','p10x16','p11x16','p12x16','p13x16','p14x16','p15x16','p16x16','p17x16','p18x16','p19x16','p20x16');
$formatArray[17] =  array('p0x17','p1x17','p2x17','p3x17','p4x17','p5x17','p6x17','p7x17','p8x17','p9x17','p10x17','p11x17','p12x17','p13x17','p14x17','p15x17','p16x17','p17x17','p18x17','p19x17','p20x17');
$formatArray[18] =  array('p0x18','p1x18','p2x18','p3x18','p4x18','p5x18','p6x18','p7x18','p8x18','p9x18','p10x18','p11x18','p12x18','p13x18','p14x18','p15x18','p16x18','p17x18','p18x18','p19x18','p20x18');

for($z=1;$z<=$numUsers;$z++){
   
    $divHtml .= "<div class=\"block s1x1 $cssArray[$z]\">$todaysDate<br>$arrayUserNames[$z]</div>";
    
}
//echo "num $numUsers";
 $counter = 1;
 $counter2 = 0;
foreach($timesArrayNumbers as $s){
   $formatBB = $formatArray[$counter][0];
   $time = $timesArray[$counter-1];
    $time = trim($time);
   if ($time != ''){   

   $odd = ($counter % 2)? "" : "odd";

   $gridHtml .=  "<div class=\"block s3x1 $formatBB $odd\"> $time
   <form id=\"form10\" name=\"form10\" method=\"post\" action=\"masterScheduleUpdate.php\" onSubmit=\"return checkData()\">
          <button class=\"buttonLast\" name=\"last\" value=\"Yesterday\" type=\"buttonLast\">Last</button>
          <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"3\" />
          <input type=\"hidden\" id=\"start_range\" name=\"start_range\" value=\"$yesterday\" />
          <input type=\"hidden\" id=\"end_range\" name=\"end_range\" value=\"$yesterday\" />
        </form>
        <form id=\"form10\" name=\"form10\" method=\"post\" action=\"masterScheduleUpdate.php\" onSubmit=\"return checkData()\">
          <button class=\"buttonToday\" name=\"today\" value=\"Today\" type=\"buttonToday\">Today</button>
          <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"5\" />
          <input type=\"hidden\" id=\"start_range\" name=\"start_range\" value=\"$todaysDate22\" />
          <input type=\"hidden\" id=\"end_range\" name=\"end_range\" value=\"$todaysDate22\" />
        </form>
        <form id=\"form10\" name=\"form10\" method=\"post\" action=\"masterScheduleUpdate.php\" onSubmit=\"return checkData()\">
          <button class=\"buttonLast\" name=\"next\" value=\"Tommorrow\" type=\"buttonNext\">Next</button>
          <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"4\" />
          <input type=\"hidden\" id=\"start_range\" name=\"start_range\" value=\"$tomorrow\" />
          <input type=\"hidden\" id=\"end_range\" name=\"end_range\" value=\"$tomorrow\" />
        </form></div>";
         for($z=1;$z<=$numUsers;$z++){
           $buttonClass = $buttonClassArray[$z][$s]; 
           $buttonText = $buttonTextArray[$z][$s];
           $marker = $markerArray[$z][$s];
           $Name = $bigNameArray[$z][$s];
           $phone = $phoneArray[$z][$s];
           $notes = $notesArray[$z][$s];
           $style = $styleArray[$z][$s];
           $format = $formatArray[$counter][$z];
           
           $userID = $arrayUserID[$z];
           
           if ($s < 10){
            $timeNum = "0$s";
           }else{
            $timeNum = "$s";
           }
            
          $gridHtml .=  "<div class=\"block $style $format $odd\">
                     <form id=\"form1\" name=\"form1\" method=\"post\" action=\"masterScheduleUpdate.php\" onSubmit=\"return checkData($counter2)\">
                    <td align=\"middle\" width=\"100\" valign=\"top\" class=\"calendar\" height=\"30\">
                        <p>Name:<br /><input name=\"name\" class=\"name\" type=\"text\" value=\"$Name\" size=\"20\" maxlength=\"50\"></p>
                        <p><a href = \"javascript:void(0)\" class=\"remind\"  classdate=\"$dateFormated $timeNum:00:00\" phone=\"$phone\" name=\"$Name\" >Phone:</a><br /><input name=\"phone\" class=\"phone\" type=\"text\" value=\"$phone\" size=\"20\" maxlength=\"50\"></p>
                        <p>Notes:<br /><textarea class=\"notes\" name=\"notes\" rows=\"2\" cols=\"20\">$notes</textarea></p>
                        <p><input class=\"$buttonClass\" type=\"submit\" name=\"$buttonText\" value=\"$buttonText\"/></p>
                        <input type=\"hidden\" id=\"date\" name=\"date\" value=\"$dateFormated $timeNum:00:00\" />
                        <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"$marker\" />
                        <input type=\"hidden\" id=\"start_range\" name=\"start_range\" value=\"$dateFormated\" />
                        <input type=\"hidden\" id=\"end_range\" name=\"end_range\" value=\"$dateFormated\" />
                         <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"$userID\" />
                    </td>
                    </form>
                </div>
              ";
             $counter2++;
        }
         $counter++;
         }
}


include "masterScheduleGrid.php";
echo "$html";
exit;
?>
