<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "savedReports.php";
$report_type = 'E';
$saved = new savedReports();
$saved-> setReportType($report_type);
$saved-> loadReportDrops();
$report_drops = $saved-> getExpiredReportDrops();

$all_select =1;
$all_access = 1;
include "clubDropsTwo.php";
$clubDrops = new clubDropsTwo();
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setAllAccess($all_access);
$location_drop = $clubDrops-> loadMenu(); 


$page_title = 'Accounts Renewable Reports';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv6.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/dynamicSelect5.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtReports.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/json2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/swfobject.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/checkRenewableReportDefaults.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/toggleCharts.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/saveCharts.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/selectReport.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/printRenewableReport.js\"></script>";
$javaScript16 ="<script type=\"text/javascript\" src=\"../scripts/printRenewableList.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(63);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/renewableReportsTemplate.php";


?>