<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$table = $_REQUEST['table'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Renewal Report</title>
<link rel="stylesheet" media="screen" type="text/css" href="../css/reportTools.css">
<link rel="stylesheet" media="print" type="text/css" href="../css/reportTools.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<input type='button' value='Print' onclick='window.print();' style='float: right' />

<div class="tableArea2" id="tableArea2">
<?php echo $table; ?>
</div>
</body>
</html>




