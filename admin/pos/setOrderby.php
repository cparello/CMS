<?php

  session_start();
  if (!isset($_SESSION['admin_access']))
   { exit; }

  $ajax_switch = $_REQUEST['ajax_switch'];
  $swap_scent  = $_REQUEST['swap_scent'];

  if ($ajax_switch == 1) 
   {
    $_SESSION['order_by'] = $_REQUEST['order_by'];

    if ($swap_scent == 1)
      $_SESSION['order_scent'] = ((!isset($_SESSION['order_scent'])) || ($_SESSION['order_scent'] == 'DESC'))? 'ASC':'DESC';

    echo "1";
    exit;
   }

?>