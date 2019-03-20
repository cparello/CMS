<?php
$serviceListTemplate = <<<SERVICELIST

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<script type="text/javascript">

function confirmDelete()  {
var answer = confirm("Are you sure that you want to delete this service?");
if (!answer) {
return false;
}
}
</script> 


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_lists.css">
<title>Search Edit Services</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
Search / Edit Services  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
$result1 
</table>
</div>


</body>
</html>
SERVICELIST;

echo"$serviceListTemplate";

?>