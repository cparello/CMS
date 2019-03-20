<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$user_id = $_POST["user_id"];
$id_card = $_POST["id_card"];

include "timeClockSqlTwo.php";

if(isset($_POST['save']))  {

    foreach($_POST['update'] as $value) {
                  
                 $valueArray = explode("|", $value);
                 $salt = $valueArray[0];
                 $time_clock_key = $valueArray[1];
                 
                 $clock_in_date = $_POST["clock_in_date$salt"];
                 $clock_in_time = $_POST["clock_in_time$salt"];
                 $clock_out_date = $_POST["clock_in_date$salt"];
                 $clock_out_time = $_POST["clock_out_time$salt"];
                 
                 $update = new timeClockSql();                 
                 $update-> setClockInDate($clock_in_date);
                 $update-> setClockInTime($clock_in_time);
                 $update-> setClockOutDate($clock_out_date);
                 $update-> setClockOutTime($clock_out_time);
                 $update-> setTimeClockKey($time_clock_key);
                 $update-> setUserId($user_id);
                 $update-> setIdCard($id_card);
                 $update-> updateTimeClock();                 
                 }
                  
               $update-> setEmployeeName($employee_name);   
               $confirmation_message = $update-> getConfirmation();     
               
               $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
               $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/employeeClockIn.js\"></script>";
               $javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/loadCamera.js\"></script>";
               $javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/checkTimeClockTwo.js\"></script>";

                include  "../templates/employeeClockInTemplate.php";
                
                exit;
               
                              
 }

//===============================================================
include  "../dbConnect.php";          
    
//get the basic member info
$result = $dbMain ->query(" SELECT type_key, user_id FROM basic_compensation WHERE id_card = '$id_card'"); 
$row_count = $result->num_rows; 

     if($row_count == 0) {
         $message = 1;
         $dbMain->close();     
         echo"$message";     
         exit;       
         }else{
         $row = $result->fetch_array(MYSQLI_NUM);
         $type_key = $row[0]; 
         $user_id = $row[1]; 
         
         $load = new timeClockSql();
         $load-> setTimeLine($time_line);
         $load-> setIdCard($id_card);
         $load-> setUserId($user_id);
         $load-> loadTimeClock();
         $listings = $load-> getTimeClockListings();
         $employee_name = $load-> getEmployeeName();
         
         $timeFormStart = "<form name=\"form2\" action=\"editTimeClockTwo.php\" method=\"post\" onSubmit=\"return checkData()\">";
         $timeFormEnd = "
         <tr>
<td colspan=\"7\">
&nbsp;
</td>
</tr>
<tr>
<td align=\"left\" id=\"sub1\" colspan=\"7\">
<input  type=\"submit\" name=\"save\" value=\"Update Timeclock For $employee_name\" />
&nbsp;&nbsp;<input type=\"reset\" value=\"Reset\"/>
<input name=\"id_card\" type=\"hidden\" id=\"id_card\" value=\"$id_card\"/>
<input name=\"user_id\" type=\"hidden\" id=\"user_id\" value=\"$user_id\"/>
<input name=\"time_line\" type=\"hidden\" id=\"time_line\" value=\"$time_line\"/>
<input name=\"employee_name\" type=\"hidden\" id=\"employee_name\" value=\"$employee_name\"/>
</td>
</tr>
</form>
</table>";


         echo"$timeFormStart $listings $timeFormEnd";         
         exit;
         }


?>