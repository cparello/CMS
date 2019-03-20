<?php

  session_start();

  $ajax_switch = $_REQUEST['ajaxSwitch'];

  if ($ajax_switch == 1) {
    $_SESSION['cart'] = "";
    $result1 = 1;
    echo "$result1";
    exit;
  }

?>