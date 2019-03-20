<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$list_type = $_GET['list_type'];
$amend = $_GET['amend'];
$date_end = $_GET['date_end'];
$club = $_GET['club'];
$invoiceDate = $_GET['invoiceDate'];

$amend = urldecode($amend);
$amend = trim($amend);
$amend = strtolower($amend);


include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

//include "checkPastDue.php";
include "loadGraceRenewal.php";
$parseGrace = new loadGraceRenewal();
$parseGrace-> setListType($list_type);
$parseGrace-> setDateEnd($date_end);
$parseGrace-> setImageName($image_name);
$parseGrace-> setInvoiceDate($invoiceDate);
$parseGrace-> setClub($club);


//sets the switch for saving past mailed invoices
if($amend == 'save') {
   $parseGrace-> setAmendKey($amend);
  }

$parseGrace-> loadBusinessInfo();
$parseGrace-> loadGraceParameters();
$parseGrace-> loadListType();


if($list_type == "mail") {
//echo "$list_type $date_end";
 $parseGrace-> loadPdf();
 $directoryName = 'gracerenewal'; 
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
 
  
// $printable_invoice = $parseGrace-> getPrintableInvoice();  
// echo"$printable_invoice";

}
?>