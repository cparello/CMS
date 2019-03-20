<?php

  session_start();
  if (!isset($_SESSION['admin_access']))
   { exit; }

  $ajax_switch = $_REQUEST['ajax_switch'];

  if ($ajax_switch == 1) 
   {
    $_SESSION['search_tabs'] = $_REQUEST['search_tabs'];

    echo "1";
    exit;
   }

?>