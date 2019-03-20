<?php

  /* Needed for debug only! */

  session_start();

  //$_SESSION['cart'] = "";
  //unset($_SESSION['cart']);
  //$_SESSION = array();
  session_unset();
  session_destroy();

  //header( 'Location: ../store.php' );
  echo '<script type="text/javascript">history.back();</script>';

?>