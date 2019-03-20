<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  loadHourDrops{

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleName = null;
private  $rowCount = null;
private  $headerType = null;


function setDay($day) {
        $this->day = $day;
         }
 
function setClubId($clubId) {
        $this->clubId = $clubId;
        }



//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function loadHours() {

 $dbMain = $this->dbconnect();
 
 $this->hourDrops = "";
 
 $stmt11 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
 $stmt11->execute();      
 $stmt11->store_result();      
 $stmt11->bind_result($this->clubName); 
 $stmt11->fetch();
 $stmt11->close();
 
 $stmt = $dbMain ->prepare("SELECT user_id, monday_shift_start1, monday_shift_end1, monday_shift_start2, monday_shift_end2, tuesday_shift_start1, tuesday_shift_end1, tuesday_shift_start2, tuesday_shift_end2, wednesday_shift_start1, wednesday_shift_end1, wednesday_shift_start2, wednesday_shift_end2, thursday_shift_start1, thursday_shift_end1, thursday_shift_start2, thursday_shift_end2, friday_shift_start1, friday_shift_end1, friday_shift_start2, friday_shift_end2, saturday_shift_start1, saturday_shift_end1, saturday_shift_start2, saturday_shift_end2, sunday_shift_start1, sunday_shift_end1, sunday_shift_start2, sunday_shift_end2 FROM employee_schedule WHERE user_id != '' ");// all shcediled emps
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $monday_shift_start1, $monday_shift_end1, $monday_shift_start2, $monday_shift_end2, $tuesday_shift_start1, $tuesday_shift_end1, $tuesday_shift_start2, $tuesday_shift_end2, $wednesday_shift_start1, $wednesday_shift_end1, $wednesday_shift_start2, $wednesday_shift_end2, $thursday_shift_start1, $thursday_shift_end1, $thursday_shift_start2, $thursday_shift_end2, $friday_shift_start1, $friday_shift_end1, $friday_shift_start2, $friday_shift_end2, $saturday_shift_start1, $saturday_shift_end1, $saturday_shift_start2, $saturday_shift_end2, $sunday_shift_start1, $sunday_shift_end1, $sunday_shift_start2, $sunday_shift_end2); 
    while ($stmt->fetch()) { 
                     $stmt99 = $dbMain ->prepare("SELECT type_key FROM employee_type WHERE club_id = '$this->clubId' AND employee_type LIKE '%sales%'");//all sales people at club client wants
                     $stmt99->execute();      
                     $stmt99->store_result();      
                     $stmt99->bind_result($type_key); 
                     while($stmt99->fetch()){
                             $stmt11 = $dbMain ->prepare("SELECT user_id FROM basic_compensation WHERE type_key = '$type_key' AND user_id = '$user_id'");//gets schedule of person at club client wants
                             $stmt11->execute();      
                             $stmt11->store_result();      
                             $stmt11->bind_result($user_id_match); 
                             $stmt11->fetch();
                             $stmt11->close();
                             
                             if ($user_id_match == $user_id){
                                $dayOfWeek = date('D',strtotime($this->day));
                                
                                $this->id = $user_id_match;
                                
                                 $stmt11 = $dbMain ->prepare("SELECT emp_fname FROM employee_info WHERE user_id = '$this->id'");
                                 $stmt11->execute();      
                                 $stmt11->store_result();      
                                 $stmt11->bind_result($this->empFname); 
                                 $stmt11->fetch();
                                 $stmt11->close();
                                
                                switch($dayOfWeek){
                                    case'Mon':
                                            for($i=$monday_shift_start1;$i<=$monday_shift_end1;$i++){
                                                $appDate = date('Y-m-d g:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                 $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                           // echo "$dayOfWeek $monday_shift_start1 $monday_shift_end1 ``` $appDate ++++ $this->hourDrops";
                              //  exit;
                                            for($i=$monday_shift_start2;$i<=$monday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                 $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    
                                        
                                    break;
                                    case'Tue':
                                        for($i=$tuesday_shift_start1;$i<=$tuesday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$tuesday_shift_start2;$i<=$tuesday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    
                                    break;
                                    case'Wed':
                                        for($i=$wednesday_shift_start1;$i<=$wednesday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$wednesday_shift_start2;$i<=$wednesday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    break;
                                    case'Thu':
                                        for($i=$thursday_shift_start1;$i<=$thursday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$thursday_shift_start2;$i<=$thursday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    break;
                                    case'Fri':
                                        for($i=$friday_shift_start1;$i<=$friday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$friday_shift_start2;$i<=$friday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    break;
                                    case'Sat':
                                        for($i=$saturday_shift_start1;$i<=$saturday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$saturday_shift_start2;$i<=$saturday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                 $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    break;
                                    case'Sun':
                                        for($i=$sunday_shift_start1;$i<=$sunday_shift_end1;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                            
                                            for($i=$sunday_shift_start2;$i<=$sunday_shift_end2;$i++){
                                                $appDate = date('Y-m-d H:i:s',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $appDateFormatted = date('F j Y H:i:s A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $ampm = date('A',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $hour = date('g',mktime($i,0,0,date('m',strtotime($this->day)),date('d',strtotime($this->day)),date('Y',strtotime($this->day))));
                                                $stmt22 = $dbMain ->prepare("SELECT first_name FROM sales_appointments WHERE appointment_date_time = '$appDate'");//gets open hours for day,date('m',strtotime($this->day))
                                                 $stmt22->execute();      
                                                 $stmt22->store_result();      
                                                  $stmt22->bind_result($first_name); 
                                                 $stmt22->fetch();
                                                 $stmt22->close();
                                                 
                                                    if ($first_name == "" AND !preg_match("/$hour $ampm/",$this->hourDrops)){
                                                        $this->hourDrops .= "<option value=\"$appDate@$appDateFormatted\">$hour $ampm</option>";
                                                    }
                                                    $first_name = "";
                                                 
                                                 
                                            }
                                    break;
                                }
                             }
                             
                             $type_key = "";
                             $user_id_match = "";
                        
                     }
                     $stmt99->close();
                     
                     
                     
                     
                     $user_id = "";
                     $monday_shift_start1 = "";
                     $monday_shift_end1 = "";
                     $monday_shift_start2 = "";
                     $monday_shift_end2 = "";
                     $tuesday_shift_start1 = "";
                     $tuesday_shift_end1 = "";
                     $tuesday_shift_start2 = "";
                     $tuesday_shift_end2 = "";
                     $wednesday_shift_start1 = "";
                     $wednesday_shift_end1 = "";
                     $wednesday_shift_start2 = "";
                     $wednesday_shift_end2 = "";
                     $thursday_shift_start1 = "";
                     $thursday_shift_end1 = "";
                     $thursday_shift_start2 = "";
                     $thursday_shift_end2 = "";
                     $friday_shift_start1 = "";
                     $friday_shift_end1 = "";
                     $friday_shift_start2 = "";
                     $friday_shift_end2 = "";
                     $saturday_shift_start1 = "";
                     $saturday_shift_end1 = "";
                     $saturday_shift_start2 = "";
                     $saturday_shift_end2 = "";
                     $sunday_shift_start1 = "";
                     $sunday_shift_end1 = "";
                     $sunday_shift_start2 = "";
                     $sunday_shift_end2 = "";
                     }

}

//-----------------------------------------------------------------------------------------------------------
function getHoursList() {
         return($this->hourDrops);
         }
function getId() {
         return($this->id);
         }  
function getName() {
         return($this->empFname);
         }  
function getClubName() {
         return($this->clubName);
         }  
         
}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$clubId = $_REQUEST['clubId'];
$day = $_REQUEST['day'];

if($ajax_switch == "1") {
//echo "$day";
//exit;
$hourDrops = new loadHourDrops();
$hourDrops-> setClubId($clubId);
$hourDrops-> setDay($day);
$hourDrops-> loadHours();
//echo "fubar";
//exit;
$hourDropsList = $hourDrops-> getHoursList();
$userId = $hourDrops-> getId();
$name = $hourDrops-> getName();
$clubName = $hourDrops-> getClubName();

echo"1|$hourDropsList|$userId|$name|$clubName";
exit;

}










?>