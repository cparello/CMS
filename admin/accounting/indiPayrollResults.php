<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$payment_cycle = $_REQUEST['payment_cycle'];
$date_start = $_SESSION['date_start'];
$date_end = $_SESSION['date_end'];


if(isset($_POST['edit']))  {

include "indiPayrollSql.php";
$rec_salt = 1;

    foreach($_POST['view'] as $viewValue) {
    
                 $valueArray = explode("|", $viewValue);
                 $user_id = $valueArray[0]; 
                 $type_key = $valueArray[1];
                                  
                 $indiRecord = new indiPayrollSql();
                 $indiRecord-> setPaymentCycle($payment_cycle);
                 $indiRecord-> setRecSalt($rec_salt);
                 $indiRecord-> setUserId($user_id);
                 $indiRecord-> setTypeKey($type_key);
                 $indiRecord-> setDateStart($date_start);
                 $indiRecord-> setDateEnd($date_end);
                 $indiRecord-> loadPayrollRecord();
                 $employee_name = $indiRecord-> getEmployeeName();
                 $indiPayrollRecords .= $indiRecord-> getPayrollRecord();
                 $totalAmount = $indiRecord-> getTotalAmount();
                 $totalAmountArray .= "$totalAmount|";
                 $commissionTotal = $indiRecord-> getCommissionTotal();
                 $commission_total_array .= "$commissionTotal|";
                 $salaryWage = $indiRecord-> getSalaryWage();
                 $salary_wage_array .= "$salaryWage|";
                 $club_id = $indiRecord-> getClubId();
                 $club_id_array .= "$club_id|";
                 
                 $hours_list = $indiRecord-> getHoursList();
                 $hours_list2 = $indiRecord-> getHoursList2();
                 $pt_html = $indiRecord-> getPtHtml();
                 $pt_html_ta = $indiRecord-> getPtHtmlTA();
                 
                 $hourlyWages = $indiRecord-> getHourlyWages();
                 $hourly_wages_array .= "$hourlyWages|";
                 
                 $baseProrateAmount = $indiRecord-> getBaseProrateAmount();
                 $baseProrateAmount_array .= "$baseProrateAmount|";
                 
                 $hoursProjected = $indiRecord-> getHoursProjected();
                 $hours_projected_array .= "$hoursProjected|";
                 $totalHours = $indiRecord-> getTotalHours();
                 $total_hours_array .= "$totalHours|";
                 $overtime =  $indiRecord-> getOT();
                 $ot_array .= "$overtime|";
                 $OTDoubTime =  $indiRecord-> getOTDoubtime();
                 //echo "*$ot_array****X$overtime  ********X$OTDoubTime********";
                 $ot_doubtime_array .= "$OTDoubTime|";
                 $subTotal = $indiRecord-> getSubTotal();
                 $sub_total_array .= "$subTotal|";
                 $type_key_array .="$type_key|";
                 $paymentCycle = $indiRecord-> getPaymentCycle();
                 $payment_cycle_array .="$paymentCycle|";
                 $compensationType = $indiRecord-> getCompensationType();
                 $compensation_type_array .="$compensationType|";
                 $idCard = $indiRecord-> getIdCard();
                 $id_card_array .="$idCard|";
                 $commission_returns = $indiRecord-> getCommissionHtml();
                 $commission_returns_array .="$commission_returns|";;
                 $sales_html = $indiRecord-> getSalesHtml();
                 $rec_salt++;
                }
                
        $totalAmountArray = explode("|",   $totalAmountArray);
        $total_amount = array_sum($totalAmountArray);
        $total_amount = sprintf("%01.2f", $total_amount);
        
        //if the records are greater than two then we create a consolidate checkbox
          if($rec_salt >= 3) {
             $consolidate_checkbox = "<input type=\"checkbox\" name=\"consol\" value=\"1\"><span class=\"black1\">&nbsp;Consolidate Payroll</span>";
            }else{
             $consolidate_checkbox = '&nbsp;';
            }
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
$javaScript5 = "<script type=\"text/javascript\" src=\"../scripts/printIndiPayroll.js\"></script>";

include "../templates/indiPayrollResultsTemplate.php";
exit;



?>