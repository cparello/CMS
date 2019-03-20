<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "savedReports.php";
$report_type = 'R';
$saved = new savedReports();
$saved-> setReportType($report_type);
$saved-> loadReportDrops();
$report_drops = $saved-> getRetailDrops();

$all_select =1;
$internet_access = 1;
include "clubDropsTwo.php";
$clubDrops = new clubDropsTwo();
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setInternetAccess($internet_access);
$location_drop = $clubDrops-> loadMenu(); 

include "retailCategoryDrops.php";
$category = new retailCategoryDrops();
$category-> loadCategoryDrops();
$category_drops = $category-> getCategoryDrops();


$page_title = 'Retail Sales Reports';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv6.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/dynamicSelect3.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtReports.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/json2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/swfobject.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/checkRetailReportDefaults.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/toggleCharts.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/saveCharts.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/selectReport.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/printRetailReport.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(61);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/retailReportsTemplate.php";


?>