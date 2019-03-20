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

//echo "$date_start";

include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

//include "checkPastDue.php";
include "loadEarlyRenewal.php";
$parseEarly = new loadEarlyRenewal();
$parseEarly-> setListType($list_type);
$parseEarly-> setDateStart($date_start);
$parseEarly-> setImageName($image_name);
$parseEarly-> setInvoiceDate($invoiceDate);
$parseEarly-> setClub($club);

//sets the switch for saving past mailed invoices
if($amend == 'save') {
   $parseEarly-> setAmendKey($amend);
  }

$parseEarly-> loadBusinessInfo();
$parseEarly-> loadEarlyParameters();
$parseEarly-> loadListType();


if($list_type == "mail") {

 $parseEarly-> loadPdf();
 $directoryName = 'earlyrenewal'; 
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
 
 
 //$printable_invoice = $parseEarly-> getPrintableInvoice();  
 //echo"$printable_invoice";

}
?>