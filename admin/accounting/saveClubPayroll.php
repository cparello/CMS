<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$consol = $_REQUEST['$consol'];
$book_keeping = $_REQUEST['$book_keeping'];
$processArray = $_REQUEST['$processArray'];
$consolidate = $_REQUEST['$consolidate'];
$club_id = $_REQUEST['$club_id'];

if(isset($_POST['save']))  {

include "saveClubPayrollSql.php";

$payrollRecord = new saveClubPayrollSql();

//takes care of letting know to cut one check or two
if (isset($consol)) {
   $consolidate = 'Y';
   }else{
   $consolidate = 'N';
  }

//determines bookeeping type i.e. quick books peachtree etc
if (isset($book_keeping)) {
   $book_keeping = $book_keeping;
   $payrollRecord-> loadPayPeriodId();
   }else{
   $book_keeping = 0;
   }

 foreach($_POST['process'] as $processEmp) {             
              $processArray .= "$processEmp^";
             }
                
 
 $payrollRecord-> setInsertArray($processArray);
 $payrollRecord-> setConsolidate($consolidate);
 $payrollRecord-> setBookKeeping($book_keeping);
 $payrollRecord-> setClubId($club_id);
 $payrollRecord-> savePayroll();
 $confirmation_message = $payrollRecord-> getConfirmation();                
                
                            
          
}

include 'qbSecondJobFix.php';
$loadRecords = new quickbook2ndJobFix();
$loadRecords-> findSecondJobNChangeInfo();


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