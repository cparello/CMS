<?php

  session_start();
  if (!isset($_SESSION['admin_access']))
   { exit; }

  //this class formats the dropdown menu for clubs and facilities
  class ordersSql
   {

    private $posStatus = null;
    private $posStatusOld = null;
    private $posStatNew = null;
//    private $posColNew = null;
    private $status = null;
    private $statusOld = null;
    private $editSwitch = null;
    private $purchaseMarker = null;
    private $contractKey = null;
    private $statusName = null;
//    private $statusColor = null;
    private $clubId = null;


    function setPosStatus($posStatus) {
      $this->posStatus = $posStatus;
     }

    function setPosStatusOld($posStatusOld) {
      $this->posStatusOld = $posStatusOld;
     }

    function setPosStatusNew($posStatNew) {
      $this->posStatNew = $posStatNew;
     }

//    function setPosColorNew($posColNew) {
//      $this->posColNew = $posColNew;
//     }

    function setEditSwitch($editSwitch) {
      $this->editSwitch = $editSwitch;
     }

    function setPurchaseMarker($purchaseMarker) {
      $this->purchaseMarker = $purchaseMarker;
     }

    function setContractKey($contractKey) {
      $this->contractKey = $contractKey;
     }

    function setClubId($clubId) {
      $this->clubId = $clubId;
     }


    //connect to database
    function dbconnect() {
      require"../dbConnect.php";
      return $dbMain;
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function sendEmail2Customer() 
     {
      $purchaseMarker = $this->purchaseMarker;

      $dbMain = $this->dbconnect();
      include "prepareOrderInvoice.php";

      include "../templates/emailOrderInvoiceTemplate.php";

      $to = "$firstName $middleName $lastName <$shippingEmail>";
      //$to .=  ", " . "$businessName <$businessEmail>";
      $subject = "Your Order Invoice at $businessName";

      /* main headers */
      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=utf-8\r\n";

      /* additional headers */
      $headers .= "From: $businessName <$businessEmail>\r\n";
      //$headers .= "Cc: christopherparello@gmail.com\r\n";
      //$headers .= "Bcc: don_ikar@mail.ru\r\n";

      if (!mail($to, $subject, $messageOrderInvoiceTemplate, $headers))
       {
        printf("There was error trying to send an email to %s.\n", $to);
       }

     }


    //---------------------------------------------------------------------------------------------------------------------------
    function parseStatus() 
     {
      if ($this->posStatus != "") 
       {
        $this->status    = $this->posStatus;
        $this->statusOld = $this->posStatusOld;
       }
      else
       {
        $this->posStatNew = preg_replace( '/\s+/', ' ', $this->posStatNew);
//        $this->posColNew = preg_replace( '/\s+/', ' ', $this->posColNew);
      
        $dbMain = $this->dbconnect();
        $sql = "INSERT INTO pos_shipping_status VALUES (?,?)";
//        $sql = "INSERT INTO pos_shipping_status VALUES (?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('is', $status_id, $status_name);
//        $stmt->bind_param('iss', $status_id, $status_name, $status_color);
        $status_id = null;
        $status_name = $this->posStatNew;
//        $status_color = $this->posColNew;
      
        if (!$stmt->execute()) 
         {
          printf("Error: %s.\n", $stmt->error);
         }		

        $this->status = $stmt->insert_id; 
        $stmt->close();           
       }
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function returnInventory() 
     {
      $dbMain = $this->dbconnect();

      $sql = "SELECT number_items, club_inv_marker FROM merchant_sales WHERE purchase_marker='$this->purchaseMarker'";
      $stmt = $dbMain ->prepare($sql); 
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($numberItems, $inventoryMarker);
      while ($stmt->fetch()) 
       {
        if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) 
          $club_id = 'I';
        else
          $club_id = $this->clubId;
        //$sql2 = "UPDATE pos_inventory SET inventory=`inventory`+? WHERE inventory_marker=?";
        $sql2 = "UPDATE club_inventory SET inventory=`inventory`+? WHERE inventory_marker=? AND club_id='$club_id'";
        $stmt2 = $dbMain->prepare($sql2);
        $stmt2->bind_param('ii', $numberItems, $inventoryMarker);	
        if (!$stmt2->execute())
         printf("Error: %s.\n", $stmt2->error);
        $stmt2->close();
       }
      $stmt->close();
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function retakeInventory() 
     {
      $dbMain = $this->dbconnect();

      $sql = "SELECT number_items, club_inv_marker FROM merchant_sales WHERE purchase_marker='$this->purchaseMarker'";
      $stmt = $dbMain ->prepare($sql); 
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($numberItems, $inventoryMarker);
      while ($stmt->fetch()) 
       {
        if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) 
          $club_id = 'I';
        else
          $club_id = $this->clubId;
        //$sql2 = "UPDATE pos_inventory SET inventory=`inventory`-? WHERE inventory_marker=?";
        $sql2 = "UPDATE club_inventory SET inventory=`inventory`-? WHERE inventory_marker=? AND club_id='$club_id'";
        $stmt2 = $dbMain->prepare($sql2);
        $stmt2->bind_param('ii', $numberItems, $inventoryMarker);	
        if (!$stmt2->execute())
         printf("Error: %s.\n", $stmt2->error);
        $stmt2->close();
       }
      $stmt->close();
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function updateOrder() 
     {
      $this->parseStatus();

      $dbMain = $this->dbconnect();

      $sql = "SELECT COUNT(status_id) FROM pos_shipping_details WHERE pos_identifier='$this->purchaseMarker'";
      $stmt = $dbMain->prepare($sql);
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($order_exists);   
      $stmt->fetch();                 
      $stmt->close();

      if ($order_exists)
       {
        $sql2 = "UPDATE pos_shipping_details SET status_id=? WHERE pos_identifier=?";
        $stmt2 = $dbMain->prepare($sql2);
        $stmt2->bind_param('ii', $status_id, $purchase_marker);	

        $status_id = $this->status;
        $purchase_marker = $this->purchaseMarker;
       }
      else
       {
        $sql2 = "INSERT INTO pos_shipping_details VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt2 = $dbMain->prepare($sql2);
//        $stmt2->bind_param('iiissssssissi', $general_id, $this->contractKey, $purchase_marker, $this->shippingDetails['first_name'], $this->shippingDetails['middle_name'], $this->shippingDetails['last_name'], $this->shippingDetails['street'], $this->shippingDetails['city'], $this->shippingDetails['state'], $this->shippingDetails['zip'], $this->shippingDetails['primary_phone'], $this->shippingDetails['email'], $status_id);
        $stmt2->bind_param('iiissssssissi', $general_id, $this->contractKey, $purchase_marker, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $status_id);

        $status_id = $this->status;
        $purchase_marker = $this->purchaseMarker;
        $empty = "-";
       }

      if (!$stmt2->execute())
       {
      	printf("Error: %s.\n", $stmt2->error);
        $stmt2->close();  
       }		
      else
       {
        $stmt2->close();  

        if ($this->status != $this->statusOld)
         {
          if ($this->status == 2)		// When we change the status to "Sent to the customer",
            $this->sendEmail2Customer();	//  send an email to the customer.

          if ($this->status == 4)		// When we change the status to "Returned by the customer",
            $this->returnInventory();		//  return the inventory to the `club_inventory` (/*`pos_inventory`*/)

          if ($this->statusOld == 4)		// When we change the status from "Returned by the customer",
            $this->retakeInventory();		//  take the inventory again from the `club_inventory` (/*`pos_inventory`*/)
         }
       }

     }

    //---------------------------------------------------------------------------------------------------------------------------
    function saveOrder() // Fake! We can't create new orders from the admin area!
     {
      // There should be the functionality of /www/vhosts/ems/cmp_development/htdocs/admin/website/webAdmin/new/php/processCartPurchase.php 
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function saveEditOrder() 
     {
      if ($this->editSwitch == 'new') // Fake! We can't create new orders from the admin area!
       { $this->saveOrder(); }
      if ($this->editSwitch == 'update') 
       { $this->updateOrder(); }
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function deleteOrder() 
     {
      $dbMain = $this->dbconnect();

      $sql1 = "DELETE FROM merchant_sales WHERE purchase_marker = '$this->purchaseMarker'";
      $stmt1 = $dbMain->prepare($sql1);  
      $stmt1->execute();
      $stmt1->close();

      $sql2 = "DELETE FROM merchant_refund_records WHERE pos_identifier = '$this->purchaseMarker'";
      $stmt2 = $dbMain->prepare($sql2);  
      $stmt2->execute();
      $stmt2->close();

      $sql3 = "DELETE FROM pos_shipping_details WHERE pos_identifier = '$this->purchaseMarker'";
      $stmt3 = $dbMain->prepare($sql3);  
      $stmt3->execute();
      $stmt3->close();
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function loadStatusName() 
     {
      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT status_name FROM pos_shipping_status WHERE status_id = '$this->posStatus'");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($status_name);   
      $stmt->fetch();                 
      
      $this->statusName = $status_name;
      
      $stmt->close();
     }

//    //---------------------------------------------------------------------------------------------------------------------------
//    function loadStatusColor() 
//     {
//      $dbMain = $this->dbconnect();
//      $stmt = $dbMain ->prepare("SELECT status_color FROM pos_shipping_status WHERE status_id = '$this->posStatus'");
//      $stmt->execute();      
//      $stmt->store_result();      
//      $stmt->bind_result($status_color);   
//      $stmt->fetch();                 
//      
//      $this->statusColor = $status_color;
//      
//      $stmt->close();
//     }
//
    //---------------------------------------------------------------------------------------------------------------------------
    function deleteStatus() 
     {
      $this->loadStatusName();

      $dbMain = $this->dbconnect();

      $sql = "DELETE FROM pos_shipping_status WHERE status_id = '$this->posStatus'";
      $stmt = $dbMain->prepare($sql);
      $stmt->execute();
      $stmt->close();

      /*
      // uncomment, if we want to delete all the orders with this status, when deleting the status. (unrecommended!)
      $sql1 = "SELECT pos_identifier FROM pos_shipping_details WHERE status_id = '$this->posStatus'";
      $stmt1 = $dbMain ->prepare($sql1);
      $stmt1->execute();      
      $stmt1->store_result();      
      $stmt1->bind_result($pos_identifier);   
      $stmt1->fetch();                 
      $stmt1->close();

      $sql2 = "DELETE FROM merchant_sales WHERE purchase_marker = '$pos_identifier'";
      $stmt2 = $dbMain->prepare($sql2);  
      $stmt2->execute();
      $stmt2->close();

      $sql3 = "DELETE FROM merchant_refund_records WHERE pos_identifier = '$pos_identifier'";
      $stmt3 = $dbMain->prepare($sql3);  
      $stmt3->execute();
      $stmt3->close();

      $sql4 = "DELETE FROM pos_shipping_details WHERE status_id = '$this->posStatus'";
      $stmt4 = $dbMain->prepare($sql4);  
      $stmt4->execute();
      $stmt4->close();
      */
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function getStatusName() 
     {
      return($this->statusName);
     }

//    //---------------------------------------------------------------------------------------------------------------------------
//    function getStatusColor() 
//     {
//      return($this->statusColor);
//     }
//
   }



?>