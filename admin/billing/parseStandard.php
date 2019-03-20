<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$list_type = $_GET['list_type'];
$amend = $_GET['amend'];
$date_start = $_GET['date_start'];
$club = $_GET['club'];
$invoiceDate = $_GET['invoiceDate'];

$amend = urldecode($amend);
$amend = trim($amend);
$amend = strtolower($amend);


include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

include "loadStandardRenewal.php";
$parseStandard = new loadStandardRenewal();
$parseStandard-> setListType($list_type);
$parseStandard-> setDateStart($date_start);
$parseStandard-> setImageName($image_name);
$parseStandard-> setInvoiceDate($invoiceDate);
$parseStandard-> setClub($club);
//sets the switch for saving past mailed invoices
if($amend == 'save') {
   $parseStandard-> setAmendKey($amend);
  }

$parseStandard-> loadBusinessInfo();
$parseStandard-> loadStandardParameters();
$parseStandard-> loadListType();

if($list_type == "mail") {

 $parseStandard-> loadPdf();
 $directoryName = 'standardrenewals'; 
 $numberDrops = "30";
 
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
 
 
 
// $printable_invoice = $parseStandard-> getPrintableInvoice();  
// echo"$printable_invoice";

}
?>