<?php

  $messageOrderInvoiceTemplate = <<<ORDERINVOICE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Your Order Invoice</title>
  </head>
  <body class="print_page">
    <div>
      <div class="address">
        <p>Dear $firstName $middleName $lastName,<br />
        Thank you for your order with $businessName.</p>

        <p>We are pleased to inform you that your order has been shipped!<br />
        Your order is being sent to </p>

        <p>$addressTo</p>

        <p>We hope you are happy with your purchase.</p>
      </div>
      <div class="clearboth">
      </div>

      <div class="userHeader">
        <h3>Order's Details:</h3>
      </div>
      <div class="userForm1">
        $productsDetails
      </div>

      <p>$businessName</p>
    </div>
  </body>
</html>
ORDERINVOICE;

?>