<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$payroll_cycle = $_REQUEST['payroll_cycle'];
$club_location = $_REQUEST['club_location'];
$date_start = $_REQUEST['datepicker1'];
$date_end = $_REQUEST['datepicker2'];

if($marker == 1)  {

    include "payrollClubSql.php";

    $m1 = date('m',strtotime($date_start));
    $m2 = date('m',strtotime($date_end));
    $d1 = date('d',strtotime($date_start));
    $d2 = date('d',strtotime($date_end));
    $y1 = date('Y',strtotime($date_start));
    $y2 = date('Y',strtotime($date_end));
    
    $date_start = date('Y-m-d H:i:s',mktime(0,0,0,$m1,$d1,$y1));
    $date_end = date('Y-m-d H:i:s',mktime(23,59,59,$m2,$d2,$y2));
    
    $loadRecords = new payrollClubSql();
    $loadRecords-> setPayrollCycle($payroll_cycle);
    $loadRecords-> setClubLocation($club_location);
    $loadRecords-> setDateStart($date_start);
    $loadRecords-> setDateEnd($date_end);
    $loadRecords-> loadPayrollRecords();
    $tableHeader = $loadRecords-> getTableHeader();
    $recordList = $loadRecords-> getRecordList();
    $cycleDescription = $loadRecords-> getCycleDescription();
    $dateStart = $loadRecords-> getDateStart();
    $dateEnd = $loadRecords-> getDateEnd();
    
    $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/payrollClubResults.js\"></script>";
    
    //print out results
     include "../templates/payrollClubResultsTemplate.php";
    
    
exit;
}



//get the club drop menu
include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$drop_menu = $clubDrops -> loadMenu(); 


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(39);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/payrollClubSearch.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTextPayroll.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";

//print out the search form
include "../templates/searchClubPayrollTemplate.php";

?>