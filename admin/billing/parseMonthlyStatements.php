<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$list_type = $_GET['list_type'];
$amend = $_GET['amend'];

$amend = urldecode($amend);
$amend = trim($amend);
$amend = strtolower($amend);

$todays_date = date("Y-m-d");

include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

//include "checkPastDue.php";
include "loadMonthlyStatements.php";
$monthlyStatements = new loadMonthlyStatements();
$monthlyStatements-> setListType($list_type);
$monthlyStatements-> setTodaysDate($todays_Date);
$monthlyStatements-> setImageName($image_name);

$monthlyStatements-> loadCycleDate();
$monthlyStatements-> loadMonthlyParameters();
$monthlyStatements-> loadBusinessInfo();
$monthlyStatements-> loadListType();

if($list_type == "mail") {

 $monthlyStatements-> loadPdf();
 $directoryName = 'monthlystatements'; 
 $numberDrops = "3";
 
 include "../helper_apps/loadFileDrops.php";
 $parseFile = new loadFileDrops();
 $parseFile-> setDirectoryName($directoryName);
 $parseFile-> setNumberDrops($numberDrops);
 $parseFile-> parseFileDrops();
 $drop_options = $parseFile-> getDropOptions();

  
 $reportDrop = "
<div id=\"reportDrop\">
<select name=\"invoice_file_month\" id=\"invoice_file_month\">
<option value>Select Invoice File</option>
$drop_options
</select>
</div>";

$downLoad = "
<div id=\"downLoad\">
<input type=\"button\" name=\"down\"  id=\"down\" class=\"button1\" value=\"Down Load Invoices\"/>
<input type=\"hidden\" name=\"file_directory\"  id=\"file_directory\" value=\"$directoryName\"/>
</div>";

 echo"</table>\n</div>";
 echo"$reportDrop";
 echo"$downLoad";
 echo"\n</body>\n</html>";
 
   
// $printable_invoice = $monthlyStatements-> getPrintableInvoice();  
//echo"$printable_invoice";

}
?>