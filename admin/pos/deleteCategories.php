<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$pos_category = $_REQUEST['pos_category'];

if (isset($_POST['cat']))       {

include "inventorySql.php";

$deleteCategory = new inventorySql();
$deleteCategory-> setPosCategory($pos_category);
$deleteCategory-> deleteCategory();
$category_name = $deleteCategory-> getCategoryName();     
$confirmation = "Category $category_name Successfully Deleted";   

}



//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(51);
$info_text = $getText -> createTextInfo();

include "posCatDrops.php";
$default_select = 5;
$catDrops = new posCatDrops();
$catDrops-> setDefaulSelect($default_select);
$drop_menu_cat = $catDrops-> loadMenu(); 




include "../templates/infoTemplate2.php";
include "../templates/deleteCategoriesTemplate.php";


?>