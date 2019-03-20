<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


include "../templates/infoTemplate2.php";
include "../templates/runManualBillingTemplate.php";

?>