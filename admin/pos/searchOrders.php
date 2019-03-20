<?php

  session_start();
  if (!isset($_SESSION['admin_access']))  {
    exit;
   }

//print("<br /><br />\$_REQUEST="); print_r($_REQUEST); // !debug!

  $marker = $_REQUEST['marker'];
  $search_type = $_REQUEST['search_type'];
  $category_id = $_REQUEST['category_id'];
  $status_id = $_REQUEST['status_id'];
  $bar_code = $_REQUEST['bar_code'];
  $product_desc = $_REQUEST['product_desc'];
  //If the the form has been submitted then do the search
  if ($marker == 1)  {
  //echo "m $marker st $search_type";
  //exit;
    
    if (isset($_REQUEST['search_string']))
     {
      $search_string = $_REQUEST['search_string'];
     }
    else
     {
      switch ($search_type) {
          case "cat":
              $search_string = $category_id; 
              break;
          case "stat":
              $search_string = $status_id; 
              break;
          case "bar":
              $search_string = $bar_code;
              break;
          case "desc":
              $search_string = $product_desc;
              break;
       }
     }

    include "orderList.php";
    $getLists = new orderList();
    $getLists -> setSearchString($search_string);
    $getLists -> setSearchType($search_type);
    $paginationForm = $getLists -> drawPaginationForm();
    $searchForm = $getLists -> drawSearchForm();
    $getLists -> loadRecords(); 
    $result1 = $getLists -> getList();
    //$result2 = $getLists -> getUserForm();


    //check to see if there are multi results or not
    if($result1 != "") {
      include "../infoText.php";
      $getText = new infoText();
      $getText -> setTextNum(85);
      $info_text = $getText -> createTextInfo();

      $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
      $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/editOrders.js\"></script>";
      $javaScript3 = "<link rel=\"stylesheet\" href=\"../css/base/jquery.ui.all.css\">
                      <script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>
                      <script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>
                      <script>
                        $(function() {
                          $(\"#datepicker_from\").datepicker();
                        });
                        $(function() {
                          $(\"#datepicker_to\").datepicker();
                        });
                      </script>";
      include "../templates/infoTemplate2.php";
      include "../templates/orderListTemplate.php";
      exit;

     }

   }

  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
  $javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/searchOrders.js\"></script>";
  $javaScript3 = "";


  include "posCatDrops.php";
  $default_select = 4;
  $catDrops = new posCatDrops();
  $catDrops-> setDefaulSelect($default_select);
  $drop_menu_cat = $catDrops-> loadMenu(); 

  include "posStatDrops.php";
  $default_select = 0;
  $statDrops = new posStatDrops();
  $statDrops-> setDefaulSelect($default_select);
  $drop_menu_stat = $statDrops-> loadMenu(); 

  //print out the search form
  include "../infoText.php";
  $getText = new infoText();
  $getText -> setTextNum(84);
  $info_text = $getText -> createTextInfo();
  include "../templates/infoTemplate2.php";
  include "../templates/searchOrdersTemplate.php";

?>