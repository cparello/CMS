<?php

  session_start();
  if (!isset($_SESSION['admin_access']))
   { exit; }

//print("\n<br />\$_POST="); print_r($_POST); // !debug!

  $order_salt      = $_REQUEST['order_salt'];
  $purchase_marker = $_REQUEST['purchase_marker'];
  $contract_key    = $_REQUEST['contract_key'];
  $search_string   = $_REQUEST['search_string'];
  $search_type     = $_REQUEST['search_type'];

  include "ordersSql.php";

  if (isset($_POST['edit'])) 
   {
    $editName         = "edit_switch$order_salt";
    $posStatusName    = "pos_status$order_salt";  
    $posStatusOldName = "pos_status_old$order_salt";  
    $clubIdName       = "club_id$order_salt";  
    
    $edit_switch    = $_POST[$editName];
    $pos_status     = $_POST[$posStatusName];
    $pos_status_old = $_POST[$posStatusOldName];
    $club_id        = $_POST[$clubIdName];
    
    $saveOrd = new ordersSql();
    $saveOrd->setPosStatus($pos_status);
    $saveOrd->setPosStatusOld($pos_status_old);
    $saveOrd->setClubId($club_id);
    $saveOrd->setEditSwitch($edit_switch);
    $saveOrd->setPurchaseMarker($purchase_marker);
    $saveOrd->setContractKey($contract_key);
    $saveOrd->saveEditOrder();
       
    $confirmation = "Order $purchase_marker Successfully Saved"; 
    if ($pos_status != $pos_status_old)
     {
      if ($pos_status == 2)		// When we change the status to "Sent to the customer",
        $confirmation .= "<br />The order invoice has been sent to the customer by email";	//  send an email to the customer.

      if ($pos_status == 4)		// When we change the status to "Returned by the customer",
        //$confirmation .= "<br />The inventory has been returned to `pos_inventory`";		//  return the inventory to the `pos_inventory`
        $confirmation .= "<br />The inventory has been returned to `club_inventory`";		//  return the inventory to the `club_inventory`

      if ($pos_status_old == 4)		// When we change the status from "Returned by the customer",
        //$confirmation .= "<br />The inventory has been retaken from `pos_inventory`";		//  take the inventory again from the `pos_inventory`
        $confirmation .= "<br />The inventory has been retaken from `club_inventory`";		//  take the inventory again from the `club_inventory`
     }
   }

  if (isset($_POST['delete'])) 
   {
    $deleteOrd = new ordersSql();
    $deleteOrd->setPurchaseMarker($purchase_marker);
    $deleteOrd->deleteOrder();
    
    $confirmation = "Order $purchase_marker Successfully Deleted";
   }

  include "orderList.php";
  $getLists = new orderList();
  $getLists->setSearchString($search_string);
  $getLists->setSearchType($search_type);
  $paginationForm = $getLists -> drawPaginationForm();
  $searchForm = $getLists -> drawSearchForm();
  $getLists->loadRecords(); 
  $result1 = $getLists -> getList();
  //$result2 = $getLists -> getUserForm();

  //check tp see if there are multi results or not
  if ($result1 != "") 
   {
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
?>