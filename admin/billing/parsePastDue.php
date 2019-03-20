<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$list_type = $_GET['list_type'];
$amend = $_GET['amend'];
$pastMonth = $_REQUEST['pastMonth'];
$pastYear = $_REQUEST['pastYear'];

$amend = urldecode($amend);
$amend = trim($amend);
$amend = strtolower($amend);

$todays_date = date("Y-m-d");

include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();


//include "checkPastDue.php";
include "loadPastDue.php";
$parsePast = new loadPastDue();
$parsePast-> setListType($list_type);
$parsePast-> setTodaysDate($todays_Date);
$parsePast-> setImageName($image_name);
$parsePast-> setPastMonth($pastMonth);
$parsePast-> setPastYear($pastYear);

//sets the switch for saving past mailed invoices
if($amend == 'save') {
   $parsePast-> setAmendKey($amend);
  }

//$parsePast-> loadCycleDate();
$parsePast-> loadFees();
$parsePast-> loadPastDueParameters();
$parsePast-> loadBusinessInfo();
$parsePast-> loadPastDay();
$parsePast-> loadListType();

if($list_type == "mail") {

 $parsePast-> loadPdf();
 $directoryName = 'pastdue'; 
 $numberDrops = "12";
 
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
 
  
// $printable_invoice = $parsePast-> getPrintableInvoice();  
// echo"$printable_invoice";

}
?>