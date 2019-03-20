<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "savedReports.php";
$report_type = 'C';
$saved = new savedReports();
$saved-> setReportType($report_type);
$saved-> loadReportDrops();
$report_drops = $saved-> getCollectibleReportDrops();


$page_title = 'Accounts Collectible Reports';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/showDiv6.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/dynamicSelect4.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtReports.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/json2.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/swfobject.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/checkCollectionReportDefaults.js\"></script>";
$javaScript12 ="<script type=\"text/javascript\" src=\"../scripts/toggleCharts.js\"></script>";
$javaScript13 ="<script type=\"text/javascript\" src=\"../scripts/saveCharts.js\"></script>";
$javaScript14 ="<script type=\"text/javascript\" src=\"../scripts/selectReport.js\"></script>";
$javaScript15 ="<script type=\"text/javascript\" src=\"../scripts/printCollectionReport.js\"></script>";
$javaScript16 ="<script type=\"text/javascript\" src=\"../scripts/printCollectionList.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(62);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/collectibleReportsTemplate.php";


?>