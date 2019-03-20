<?php
$guestPassListTemplate = <<<GUESTPASSLIST

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<script type="text/javascript">

function confirmDelete()  {
var answer = confirm("Are you sure that you want to delete this Guest Pass?");
if (!answer) {
return false;
}
}
</script> 


<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_lists.css">
<title>Guest Pass List</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
Edit Delete Guest Pass  
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
GUESTPASSLIST;

echo"$guestPassListTemplate";

?>