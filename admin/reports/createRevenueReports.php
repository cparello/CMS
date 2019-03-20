<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "savedReports.php";
$report_type = 'F';
$saved = new savedReports();
$saved-> setReportType($report_type);
$saved-> loadReportDrops();
$report_drops = $saved-> getFlowDrops();

$all_select =1;
$internet_access = 1;
include "clubDropsTwo.php";
$clubDrops = new clubDropsTwo();
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setInternetAccess($internet_access);
$location_drop = $clubDrops-> loadMenu(); 

$page_title = 'Cash Flow Reports (Revenue)';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv6.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/dynamicSelect2.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtReports.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/json2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/swfobject.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/checkRevenueReportDefaults.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/toggleCharts.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/saveCharts.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/selectReport.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/printFlowReport.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(60);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/revenueReportsTemplate.php";


?>