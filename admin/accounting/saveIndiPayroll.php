<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$add_deduct_array = $_REQUEST['add_deduct_array'];
$commission_total_array = $_REQUEST['commission_total_array'];
$salary_wage_array  = $_REQUEST['salary_wage_array'];
$hourly_wages_array = $_REQUEST['hourly_wages_array'];
$baseProrateAmount_array  = $_REQUEST['baseProrateAmount_array'];
$ot_array  = $_REQUEST['ot_array'];
$ot_doubtime_array = $_REQUEST['ot_doubtime_array'];
$hours_projected_array = $_REQUEST['hours_projected_array'];
$total_hours_array = $_REQUEST['total_hours_array'];
$sub_total_array = $_REQUEST['sub_total_array'];
$payment_cycle_array = $_REQUEST['payment_cycle_array'];
$compensation_type_array = $_REQUEST['compensation_type_array'];
$club_id_array = $_REQUEST['club_id_array'];
$consol = $_REQUEST['consol'];
$book_keeping = $_REQUEST['book_keeping'];
$user_id = $_REQUEST['user_id'];
$pt_html = $_REQUEST['pt_html'];
$pt_html_ta = $_REQUEST['pt_html_ta'];
$commissReturns = $_REQUEST['commission_returns'];
$salesHtml = $_REQUEST['sales_html'];

include "saveIndiPayrollSql.php";

$add_deduct_array = explode("@", $add_deduct_array);
//echo "**** addarray    $add_deduct_array[0]";
$commission_total_array = explode('|', $commission_total_array);
$salary_wage_array = explode('|', $salary_wage_array);
$hourly_wages_array = explode('|', $hourly_wages_array);
$baseProrateAmount_array = explode('|', $baseProrateAmount_array);
$ot_array = explode('|', $ot_array);
//echo "****ot**$ot_array[0]****hourwahgesarrray*$hourly_wages_array*";
$ot_doubtime_array = explode('|', $ot_doubtime_array);
$hours_projected_array = explode('|', $hours_projected_array);
$total_hours_array = explode('|', $total_hours_array);
$sub_total_array = explode('|', $sub_total_array);
$payment_cycle_array = explode('|', $payment_cycle_array);
$compensation_type_array = explode('|', $compensation_type_array);
$club_id_array = explode('|', $club_id_array);

$ptArray = explode('@', $pt_html);
$ptPayrollData = $ptArray[1];
$ptArrayTa = explode('@', $pt_html_ta);
$ptPayrollDataTa = $ptArrayTa[1];


$commisshArray = explode('@',$commissReturns);
foreach($commisshArray as $temp){
    $commissReturnTot += $temp[2];
}
$commissReturnTot = sprintf("%01.2f", $commissReturnTot);

$salesTempAr = explode('@',$salesHtml);
$temp22 = explode(',',$salesTempAr[0]);
$bonus_payout = $temp22[2];
//takes care of letting know to cut one check or two
if (isset($consol)) {
   $consolidate = 'Y';
   }else{
   $consolidate = 'N';
  }

//determines bookeeping type i.e. quick books peachtree etc
if (isset($book_keeping)) {
   $book_keeping = $book_keeping;
   }else{
   $book_keeping = 0;
   }
  
//sets up an idex to merge with other arrays
$i = 0;

foreach ($add_deduct_array as $add_sub) {

             if($add_sub != "") {
             
                 $group_rec = explode("|", $add_sub);
                 $user_id = $group_rec[0]; 
                 $type_key = $group_rec[1];
                 $add_sub_one = $group_rec[2];
                 $add_sub_amount_one = $group_rec[3];
                 $add_sub_desc_one = $group_rec[4];
                 $save_marker_one = $group_rec[5];
                 $add_sub_two = $group_rec[6];
                 $add_sub_amount_two = $group_rec[7];
                 $add_sub_desc_two = $group_rec[8];
                 $save_marker_two = $group_rec[9]; 
                 $add_sub_three = $group_rec[10];
                 $add_sub_amount_three = $group_rec[11];
                 $add_sub_desc_three = $group_rec[12];
                 $save_marker_three = $group_rec[13];  
                 $add_sub_four = $group_rec[14];
                 $add_sub_amount_four = $group_rec[15];
                 $add_sub_desc_four = $group_rec[16];
                 $save_marker_four = $group_rec[17]; 
                 $commission_total = $commission_total_array[$i];
                 $salary = $salary_wage_array[$i];
                 $hourly_wages =  $hourly_wages_array[$i];    
                 $OT =  $ot_array[$i];    
                 $OTDoubTime =  $ot_doubtime_array[$i];    
                 $baseProrateAmount = $baseProrateAmount_array[$i];
                 $hours_projected = $hours_projected_array[$i];
                 $total_hours = $total_hours_array[$i];
                 $sub_total = $sub_total_array[$i];
                 $payment_cycle = $payment_cycle_array[$i];
                 $compensation_type = $compensation_type_array[$i];
                 $employee_name = $employee_name;
                 $save_add_sub = $save_add_sub;
                 $club_id = $club_id_array[$i];
                 
                 $saveIndi = new saveIndiPayrollSql();
                 $saveIndi-> setUserId($user_id); 
                 $saveIndi-> setTypeKey($type_key); 
                 $saveIndi-> setAddSubOne($add_sub_one);
                 $saveIndi-> setAddSubAmountOne($add_sub_amount_one);
                 $saveIndi-> setAddSubDescOne($add_sub_desc_one);
                 $saveIndi-> setSaveMarkerOne($save_marker_one);
                 $saveIndi-> setAddSubTwo($add_sub_two);
                 $saveIndi-> setAddSubAmountTwo($add_sub_amount_two);
                 $saveIndi-> setAddSubDescTwo($add_sub_desc_two);
                 $saveIndi-> setSaveMarkerTwo($save_marker_two);
                 $saveIndi-> setAddSubThree($add_sub_three);
                 $saveIndi-> setAddSubAmountThree($add_sub_amount_three);
                 $saveIndi-> setAddSubDescThree($add_sub_desc_three);
                 $saveIndi-> setSaveMarkerThree($save_marker_three);
                 $saveIndi-> setAddSubFour($add_sub_four);
                 $saveIndi-> setAddSubAmountFour($add_sub_amount_four);
                 $saveIndi-> setAddSubDescFour($add_sub_desc_four);
                 $saveIndi-> setSaveMarkerFour($save_marker_four); 
                 
                 $saveIndi-> setCommissionTotal($commission_total);
                 $saveIndi-> setSalary($salary);
                 $saveIndi-> setHourlyWages($hourly_wages);
                 $saveIndi-> setOT($OT);
                 $saveIndi-> setOTDoubTime($OTDoubTime);
                 $saveIndi-> setPtInfo($ptPayrollData);
                 $saveIndi-> setPtTaInfo($ptPayrollDataTa);
                 $saveIndi-> setBaseProrateAmount($baseProrateAmount);
                 $saveIndi-> setHoursProjected($hours_projected);
                 $saveIndi-> setTotalHours($total_hours);
                 $saveIndi-> setSubTotal($sub_total);
                 $saveIndi-> setPaymentCycle($payment_cycle);
                 $saveIndi-> setCompensationType($compensation_type);
                 $saveIndi-> setEmployeeName($employee_name);
                 $saveIndi-> setSaveAddSub($save_add_sub);
                 $saveIndi-> setConsolidate($consolidate);
                 $saveIndi-> setBookKeeping($book_keeping);
                 $saveIndi-> setClubId($club_id);
                 
                 $saveIndi-> setBonusPayout($bonus_payout);
                 $saveIndi-> setCommissionReturnTot($commissReturnTot);
                 
                 $saveIndi-> saveSettled();
                 $saveIndi-> saveAddSub();
                 $saveIndi-> saveToBookKeeping();
                 $confirmation = $saveIndi-> getConfirmationMessage();
                                           
               $i++;
               }
         }

//-------------------------------------------------------------------------------------------------------
//here we get all of the new results and reproc the page

include "indiPayrollSql.php";
$rec_salt = 1;

$type_key_array = explode('|', $type_key_array);

              foreach ($type_key_array as $type_key) {

                               if($type_key != "") {
                           
                                   $indiRecord = new indiPayrollSql();
                                   $indiRecord-> setRecSalt($rec_salt);
                                   $indiRecord-> setUserId($user_id);
                                   $indiRecord-> setTypeKey($type_key);
                                   $indiRecord-> loadPayrollRecord();
                                   $employee_name = $indiRecord-> getEmployeeName();
                                   $indiPayrollRecords .= $indiRecord-> getPayrollRecord();
                                   $totalAmount = $indiRecord-> getTotalAmount();
                                   $totalAmountArray .= "$totalAmount|";
                                   $commissionTotal = $indiRecord-> getCommissionTotal();
                                   $commission_total_array .= "$commissionTotal|";
                                   $salaryWage = $indiRecord-> getSalaryWage();
                                   $salary_wage_array .= "$salaryWage|";
                                   $hourlyWages = $indiRecord-> getHourlyWages();
                                   $hourly_wages_array .= "$hourlyWages|";
                                   $overtime =  $indiRecord-> getOT();
                                   $ot_array .= "$overtime|";
                                   $OTDoubTime =  $indiRecord-> getOTDoubtime();
                                   $ot_doubtime_array .= "$OTDoubTime|";
                                   
                                   $baseProrateAmount = $indiRecord-> getBaseProrateAmount();
                                   $baseProrateAmount_array .= "$baseProrateAmount|";
                                   
                                  // echo "<br><br>**********$overtime*****B$OTDoubTime******<br>";
                                   $hoursProjected = $indiRecord-> getHoursProjected();
                                   $hours_projected_array .= "$hoursProjected|";
                                   $totalHours = $indiRecord-> getTotalHours();
                                   $total_hours_array .= "$totalHours|";
                                   $subTotal = $indiRecord-> getSubTotal();
                                   $sub_total_array .= "$subTotal|";
                                   $type_key_array .="$type_key|";
                                   $paymentCycle = $indiRecord-> getPaymentCycle();
                                   $payment_cycle_array .="$paymentCycle|";
                                   $compensationType = $indiRecord-> getCompensationType();
                                   $compensation_type_array .="$compensationType|";
                                   $club_id = $indiRecord-> getClubId();
                                   $club_id_array .= "$club_id|";
                                   
                 
                                   $rec_salt++;                           
                                                      
                                 }

                          }

         //a weird bug that show the string 'Array' have to filter out this word
         $pattern = '/Array/';
         $commission_total_array = preg_replace($pattern, "", $commission_total_array);
         $salary_wage_array = preg_replace($pattern, "", $salary_wage_array);
         $hourly_wages_array = preg_replace($pattern, "", $hourly_wages_array);
         
         $ot_array = preg_replace($pattern, "", $ot_array);
         $ot_doubtime_array = preg_replace($pattern, "", $ot_doubtime_array);
         $baseProrateAmount_array = preg_replace($pattern, "", $baseProrateAmount_array);
         $hours_projected_array = preg_replace($pattern, "", $hours_projected_array);
         $total_hours_array = preg_replace($pattern, "", $total_hours_array);
         $sub_total_array = preg_replace($pattern, "", $sub_total_array);
         $type_key_array = preg_replace($pattern, "", $type_key_array);
         $payment_cycle_array = preg_replace($pattern, "", $payment_cycle_array);
         $compensation_type_array = preg_replace($pattern, "", $compensation_type_array);

        $totalAmountArray = explode("|",   $totalAmountArray);
        $total_amount = array_sum($totalAmountArray);
        $total_amount = sprintf("%01.2f", $total_amount);
        
        //if the records are greater than two then we create a consolidate checkbox
          if($rec_salt >= 3) {
             $consolidate_checkbox = "<input type=\"checkbox\" name=\"consol\" value=\"1\"><span class=\"black1\">&nbsp;Consolidate Payroll</span>";
            }else{
             $consolidate_checkbox = '&nbsp;';
            }

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(38);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/showDiv4.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/addSubFunctions.js\"></script>";
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/saveAddSub.js\"></script>";

include "../templates/indiPayrollResultsTemplate.php";
exit;

?>