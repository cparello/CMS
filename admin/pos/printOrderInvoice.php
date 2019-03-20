<?php

  session_start();
  if (!isset($_SESSION['admin_access'])) {
    exit;
   }

  $purchaseMarker = $_POST['purchase_marker'];
  require "../dbConnect.php";

  include "prepareOrderInvoice.php";

  include "../templates/printOrderInvoiceTemplate.php";

?>