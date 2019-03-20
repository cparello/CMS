<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

header('Content-disposition: attachment; filename=cmpqwcfile.qwc');
header('Content-type: application/qwc');
readfile('cmpqwcfile.qwc');
?>