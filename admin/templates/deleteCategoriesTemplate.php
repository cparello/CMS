<?php
$deleteCategoriesTemplate = <<<DELETECATEGORIES
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/deleteCategories.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">

<script type="text/javascript">

function confirmDelete()  {

var categoryValue = document.form1.pos_category.value;

      if(categoryValue == "")  {
        alert('Please select a category to delete');
               return false;
        }


var answer = confirm("Deleting this category will also delete all asscociated inventory in your warehouse, including inventory that has been assigned to club(s). If you have inventory that you wish to save, please reassign these products to another category.  Do you wish to continue?");
if (!answer) {
return false;
}
}
</script>

	<title>Delete Category</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Delete Categories 
</div>

<div id="idContent1">  
$confirmation
</div>


<div id="userForm1">
<table border="0" align="center">
<tr>
<td>
<form id="form1" name="form1" method="post" action="deleteCategories.php" >
<select name="pos_category" id="pos_category"/>$drop_menu_cat</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="cat" id="cat" value="Delete Category" onClick="return confirmDelete();"/>
</td>
</tr>
</table>
</form>
</div>



</body>
</html>
DELETECATEGORIES;


echo"$deleteCategoriesTemplate";
?>