<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$assignment_sales = $_REQUEST['assignment_sales'];
$assignment_member = $_REQUEST['assignment_member'];
$assignment_billing = $_REQUEST['assignment_billing'];
$assignment_emp = $_REQUEST['assignment_emp'];
$assignment_internet = $_REQUEST['assignment_internet'];
$low_days = $_REQUEST['low_days'];
$medium_days = $_REQUEST['medium_days'];
$high_days = $_REQUEST['high_days'];

include "noteSql.php";


if($marker == 1) {
   $setNotePrefs = new noteSql();
   $setNotePrefs-> setAssignmentSales($assignment_sales); 
   $setNotePrefs-> setAssignmentMember($assignment_member);
   $setNotePrefs-> setAssignmentBilling($assignment_billing);
   $setNotePrefs-> setAssignmentEmp($assignment_emp);
   $setNotePrefs-> setAssignmentInternet($assignment_internet);
   $setNotePrefs-> setLowDays($low_days);
   $setNotePrefs-> setMediumDays($medium_days);
   $setNotePrefs-> setHighDays($high_days);
   $confirmation = $setNotePrefs-> saveNoteSettings();
}






$loadNotePrefs = new noteSql();
$loadNotePrefs-> loadNoteSettings();
$sales_drop = $loadNotePrefs-> getSalesDrop();
$member_drop = $loadNotePrefs-> getMemberDrop();
$billing_drop = $loadNotePrefs-> getBillingDrop();
$sales_drop = $loadNotePrefs-> getSalesDrop();
$emp_drop = $loadNotePrefs-> getEmpDrop();
$internet_drop = $loadNotePrefs-> getInternetDrop();
$low_days = $loadNotePrefs-> getLowDays();
$medium_days = $loadNotePrefs-> getMediumDays();
$high_days = $loadNotePrefs-> getHighDays();


$page_title = 'Edit Note Assignment / Duration';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtNotes.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(28);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/manageNotesTemplate.php";


?>