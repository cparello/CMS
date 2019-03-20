<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$list_type = $_GET['list_type'];
$term_type = $_GET['term_type'];
$date_range= $_GET['date_range'];



include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

//include "checkPastDue.php";
include "loadExpiredEnroll.php";
$loadExpired = new loadExpiredEnroll();
$loadExpired-> setListType($list_type);
$loadExpired-> setDateRange($date_range);
$loadExpired-> setTermType($term_type);
$loadExpired-> setImageName($image_name);


$loadExpired-> loadBusinessInfo();
$loadExpired-> loadExpiredEnrollParameters();
$loadExpired-> loadListType();


if($list_type == "mail") {

 $loadExpired-> loadPdf();
 $directoryName = 'expired'; 
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
 
 
 //$printable_invoice = $parseEarly-> getPrintableInvoice();  
 //echo"$printable_invoice";

}
?>