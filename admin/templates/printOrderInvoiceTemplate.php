<?php

  $printOrderInvoiceTemplate = <<<ORDERINVOICE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/user_lists.css">
    <link rel="stylesheet" href="../css/shipping.css">
    <title>Print Order Invoice</title>
  </head>
  <body class="print_page">
    <div>
      <div class="address from">
        <h2>From:</h2>
        $addressFrom
      </div>
      <div class="address to">
        <h2>To:</h2>
        $addressTo
      </div>
      <div class="clearboth">
      </div>

      <div class="userHeader">
        Order's Details:
      </div>
      <div class="userForm1">
        $productsDetails
      </div>
    </div>
  </body>
</html>
ORDERINVOICE;

  echo "$printOrderInvoiceTemplate";

?>