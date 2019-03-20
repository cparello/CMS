<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "savedReports.php";
$report_type = 'A';
$saved = new savedReports();
$saved-> setReportType($report_type);
$saved-> loadReportDrops();
$report_drops = $saved-> getActiveInactiveDrops();

$all_select =1;
$all_access = 0;
$internet_access = 0;
include "clubDropsTwo.php";
$clubDrops = new clubDropsTwo();
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setAllAccess($all_access);
$clubDrops-> setInternetAccess($internet_access);
$location_drop = $clubDrops-> loadMenu(); 


$page_title = 'Active and Inactive Account Reports';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv6.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtReports.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/json2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/swfobject.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/checkActiveInactiveReportDefaults.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/toggleCharts.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/saveCharts.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/selectReport.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/printActiveInactiveReport.js\"></script>";
$javaScript16 ="<script type=\"text/javascript\" src=\"../scripts/printActiveInactiveList.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(78);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/activeInactiveReportsTemplate.php";


?>