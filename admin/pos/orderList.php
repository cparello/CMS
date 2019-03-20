<?php

  session_start();
  if (!isset($_SESSION['admin_access'])) {
    exit;
   }

  class orderList 
   {
   
    private $searchString = null;
    private $searchType = null;
    private $statusId = null;
    private $statusName = null;
    private $statusColor = "#000000";
    private $dropList = null;
    private $dropOptions = null;
    private $categoryId = null;
    private $categoryName = null;
    private $dropCatList = null;
    private $dropCatOptions = null;

    function setSearchString($searchString) {
      $this->search_string = $searchString;
     }

    function setSearchType($searchType) {
      $this->search_type = $searchType;
     }

    //connect to database
    function dbconnect()  {
      require"../dbConnect.php";
      return $dbMain;
     }

    //======================================================================
    function drawPaginationForm()
     {

      if (isset($_POST['search_submit']))
       {
        unset($_SESSION['rows_per_page']);
        unset($_SESSION['page_num']);
        unset($_SESSION['result_rows']);
       }

      $rows_per_page = isset($_POST['rows_per_page']) ? $_POST['rows_per_page'] : (isset($_SESSION['rows_per_page']) ? $_SESSION['rows_per_page'] : 10);
//      $_SESSION['rows_per_page'] = $rows_per_page;

      $page_num = isset($_POST['page_num']) ? $_POST['page_num'] : (isset($_SESSION['page_num']) ? $_SESSION['page_num'] : 1);
//print("<br />\$_POST="); print_r($_POST); // !debug!
      /**/
      if (isset($_POST['pagination_submit']))
        switch ($_POST['pagination_submit'])
         {
          case '&lt;': case '<':
            if ($page_num > 1) 
              $page_num--;
            break;
          case '&lt;&lt;': case '<<':
            $page_num = 1;
            break;
          case '&gt;': case '>':
            if ($page_num < ceil($_SESSION['result_rows']/$rows_per_page))
              $page_num++;
            break;
          case '&gt;&gt;': case '>>':
            $page_num = ceil($_SESSION['result_rows']/$rows_per_page);
            break;
         }
      /**/
      if (isset($_POST['rows_per_page'])  &&  $_POST['rows_per_page'] != $_SESSION['rows_per_page'])
        $page_num = 1;

      $_SESSION['rows_per_page'] = $rows_per_page;
      $_SESSION['page_num'] = $page_num;

      /* Get the orders count. */
      include "prepareQuery.php";
      
      $query = "SELECT COUNT(*) AS orders_count FROM merchant_sales ms"
              ." LEFT JOIN merchant_refund_records mrr ON (mrr.pos_identifier = ms.purchase_marker)"
              ." LEFT JOIN pos_shipping_details psd ON (psd.pos_identifier = ms.purchase_marker)"
              ." WHERE $where GROUP BY purchase_marker$orderbySql";
//print("<br />\$query=$query"); // !debug!
      $stmt = $dbMain ->prepare($query);
      $stmt->execute(); 
      $stmt->store_result();      
      $stmt->bind_result($orders_count);
      $result_rows = 0;
      while ($stmt->fetch())
        $result_rows++;

      $_SESSION['result_rows'] = $result_rows;
      /* /Get the orders count. */

      $disabled_prev = $page_num > 1 ? '' : ' disabled="disabled"';
      $disabled_next = $page_num < ceil($result_rows/$rows_per_page) ? '' : ' disabled="disabled"';
      $pagination_form = "
        <form id=\"pagination_form\" method=\"post\" action=\"\">
          <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"product_details\">
            <tr>
              <td>
                Page: <input type=\"submit\" name=\"pagination_submit\" value=\"&lt;&lt;\" $disabled_prev />
                <input type=\"submit\" name=\"pagination_submit\" value=\"&lt;\" $disabled_prev />
                <select name=\"page_num\" onChange=\"$('#pagination_form').submit();\">";
      for ($i=1; $i <= ceil($result_rows/$rows_per_page); $i++)
        $pagination_form .= "<option" . ($i == $page_num ? ' selected="selected"' : '') . ">$i</option>";
      $pagination_form .= "
                </select>
                <input type=\"submit\" name=\"pagination_submit\" value=\"&gt;\" $disabled_next />
                <input type=\"submit\" name=\"pagination_submit\" value=\"&gt;&gt;\" $disabled_next />
                by <select name=\"rows_per_page\" onChange=\"$('#pagination_form').submit();\" />";
      for ($i=10; $i < $result_rows; $i+=10)
        $pagination_form .= "<option" . ($i == $rows_per_page ? ' selected="selected"' : '') . ">$i</option>";
      $pagination_form .= "
                     <option>$result_rows</option>
                   </select> rows
              </td>
            </tr>
          </table>
          <input type=\"hidden\" name=\"marker\" value=\"1\">
        </form>";

      return $pagination_form;
     }

    //----------------------------------------------------------------------------------------------
    function drawSearchForm()
     {
      if (isset($_POST['search_submit']))
       {
        $_SESSION['POST'] = $_POST;
       }
      else
       {
        if (isset($_SESSION['POST']))
          $_POST = $_SESSION['POST'];
       }
      
      foreach ($_POST as $key=>$val)
        $$key = $val;

      $search_tabs = "<form><table class=\"product_details\"><tr><td>
                        <label><input type=\"radio\" name=\"search_tabs\" class=\"search_tabs\" value=\"search_form\" />Search by Order's details</label>
                        <label><input type=\"radio\" name=\"search_tabs\" class=\"search_tabs\" value=\"search_form_products_details\" />Search by Product's details</label>
                        <label><input type=\"radio\" name=\"search_tabs\" class=\"search_tabs\" value=\"search_form_credit_card_details\" />Search by Credit Card's details</label>
                        <label><input type=\"radio\" name=\"search_tabs\" class=\"search_tabs\" value=\"search_form_shipping_details\" />Search by Shipping's details</label>
                        <input type=\"hidden\" id=\"search_tabs\" name=\"search_tabs\" value=\"" . (isset($_SESSION['search_tabs']) ? $_SESSION['search_tabs'] : '') . "\" />
                      </td></tr></table></form>";

      $this->statusId = ($status_id!="")? $status_id : "-1";
      $this->loadDropMenu();
      $search_form = "<form id=\"search_form\" method=\"post\" action=\"\" class=\"search_form\" >
                        <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
                          <tr>
                            <th><label>Range <input type=\"checkbox\" name=\"search_range\" id=\"search_range\" " . (isset($_POST['search_range'])?'checked="checked"':'') . " /></label></th>
                            <th>Date</th>
                            <th>Purchase Marker</th>
                            <th>Transaction ID</th>
                            <th>Club ID</th>
                            <th>Internet</th>
                            <th>Contract Key</th>
                            <th>Total</th>
                            <th>Shipping Status</th>
                            <th><input type=\"button\" name=\"search_clear\" id=\"search_clear\" class=\"search_clear\" value=\"Clear\" /></th>
                          </tr>
                          <tr>
                            <td id=\"search_text_from\">Search:</td>
                            <td><input type=\"text\" name=\"purchase_date[]\" value=\"$purchase_date[0]\" id=\"datepicker_from\" /></td>
                            <td><input type=\"text\" name=\"purchase_marker[]\" value=\"$purchase_marker[0]\" /></td>
                            <td><input type=\"text\" name=\"transaction_id[]\" value=\"$transaction_id[0]\" /></td>
                            <td><input type=\"text\" name=\"club_id[]\" value=\"$club_id[0]\" /></td>
                            <td rowspan=\"2\"><select name=\"internet\"><option value=\"\">&nbsp;</option><option " . ($internet=='Y'?'selected="selected"':'') . ">Y</option><option" . ($internet=='N'?' selected':'') . ">N</option></select></td>
                            <td><input type=\"text\" name=\"contract_key[]\" value=\"$contract_key[0]\" /></td>
                            <td><input type=\"text\" name=\"total[]\" value=\"$total[0]\" class=\"short_field\" /></td>
                            <td rowspan=\"2\"><select name=\"status_id\" style=\"width:50px;\"><option value=\"\">&nbsp;</option>$this->dropOptions</select></td>
                            <td rowspan=\"2\"><input type=\"submit\" name=\"search_submit\" value=\"Search\" /></td>
                          </tr>
                          <tr id=\"search_row_to\" " . (isset($_POST['search_range'])?'':'style="display:none;"') . ">
                            <td id=\"search_text_to\">To:</td>
                            <td><input type=\"text\" name=\"purchase_date[]\" value=\"$purchase_date[1]\" id=\"datepicker_to\" /></td>
                            <td><input type=\"text\" name=\"purchase_marker[]\" value=\"$purchase_marker[1]\" /></td>
                            <td><input type=\"text\" name=\"transaction_id[]\" value=\"$transaction_id[1]\" /></td>
                            <td><input type=\"text\" name=\"club_id[]\" value=\"$club_id[1]\" /></td>
                            <td><input type=\"text\" name=\"contract_key[]\" value=\"$contract_key[1]\" /></td>
                            <td><input type=\"text\" name=\"total[]\" value=\"$total[1]\" class=\"short_field\" /></td>
                          </tr>
                        </table>
                        <input type=\"hidden\" name=\"marker\" value=\"1\">
                      </form>";

      $this->categoryId = $category_id;
      $this->loadCatDropMenu();
      $search_form_products_details = "<form id=\"search_form_products_details\" method=\"post\" action=\"\" class=\"search_form\" >
                        <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
                          <tr>
                            <th>Inventory Marker</th>
                            <th>Product Description</th>
                            <th>Barcode</th>
                            <th>Category</th>
                            <th>Whole Cost</th>
                            <th>Retail Cost</th>
                            <th>Sales Tax</th>
                            <th>Total Cost</th>
                            <th>Items Number</th>
                            <th>Price</th>
                            <th><input type=\"button\" name=\"search_clear\" id=\"search_clear_products_details\" class=\"search_clear\" value=\"Clear\" /></th>
                          </tr>
                          <tr>
                            <td><input type=\"text\" name=\"club_inv_marker[]\" value=\"$club_inv_marker[0]\" /></td>
                            <td><input type=\"text\" name=\"product_desc[]\" value=\"$product_desc[0]\" /></td>
                            <td><input type=\"text\" name=\"bar_code[]\" value=\"$bar_code[0]\" /></td>
                            <td><select name=\"category_id\" style=\"width:50px;\"><option value=\"\">&nbsp;</option>$this->dropCatOptions</select></td>
                            <td><input type=\"text\" name=\"whole_cost[]\" value=\"$whole_cost[0]\" /></td>
                            <td><input type=\"text\" name=\"retail_cost[]\" value=\"$retail_cost[0]\" /></td>
                            <td><input type=\"text\" name=\"sales_tax[]\" value=\"$sales_tax[0]\" /></td>
                            <td><input type=\"text\" name=\"total_cost[]\" value=\"$total_cost[0]\" /></td>
                            <td><input type=\"text\" name=\"number_items[]\" value=\"$number_items[0]\" class=\"short_field\" /></td>
                            <td><input type=\"text\" name=\"price[]\" value=\"$price[0]\" /></td>
                            <td><input type=\"submit\" name=\"search_submit\" value=\"Search\" /></td>
                          </tr>
                        </table>
                        <input type=\"hidden\" name=\"marker\" value=\"1\">
                      </form>";

      $search_form_credit_card_details = "<form id=\"search_form_credit_card_details\" method=\"post\" action=\"\" class=\"search_form\" >
                        <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
                          <tr>
                            <th>Card Type</th>
                            <th>Card Number (ONLY last 4 digits)</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Name on the Card</th>
                            <th>Auth ID of transaction</th>
                            <th>Billed to card on file</th>
                            <th>Transarmor token value of card</th>
                            <th><input type=\"button\" name=\"search_clear\" id=\"search_clear_credit_card_details\" class=\"search_clear\" value=\"Clear\" /></th>
                          </tr>
                          <tr>
                            <td><input type=\"text\" name=\"card_type[]\" value=\"$card_type[0]\" /></td>
                            <td><input type=\"text\" name=\"card_number[]\" value=\"$card_number[0]\" class=\"short_field\" /></td>
                            <td><input type=\"text\" name=\"month[]\" value=\"$month[0]\" /></td>
                            <td><input type=\"text\" name=\"year[]\" value=\"$year[0]\" /></td>
                            <td><input type=\"text\" name=\"card_name[]\" value=\"$card_name[0]\" /></td>
                            <td><input type=\"text\" name=\"auth_id[]\" value=\"$auth_id[0]\" /></td>
                            <td><select name=\"cof_bool\"><option value=\"\">&nbsp;</option><option " . ($cof_bool=='Yes'?'selected="selected"':'') . ">Yes</option><option" . ($cof_bool=='No'?' selected':'') . ">No</option></select></td>
                            <td><input type=\"text\" name=\"trans_token[]\" value=\"$trans_token[0]\" /></td>
                            <td><input type=\"submit\" name=\"search_submit\" value=\"Search\" /></td>
                          </tr>
                        </table>
                        <input type=\"hidden\" name=\"marker\" value=\"1\">
                      </form>";

      $search_form_shipping_details = "<form id=\"search_form_shipping_details\" method=\"post\" action=\"\" class=\"search_form\" >
                        <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
                          <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Street Adress</th>
                            <th>City</th>
                            <th title=\"(two-letter abbrev.)\">State</th>
                            <th>Zip Code</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th><input type=\"button\" name=\"search_clear\" id=\"search_clear_shipping_details\" class=\"search_clear\" value=\"Clear\" /></th>
                          </tr>
                          <tr>
                            <td><input type=\"text\" name=\"first_name[]\" value=\"$first_name[0]\" /></td>
                            <td><input type=\"text\" name=\"middle_name[]\" value=\"$middle_name[0]\" /></td>
                            <td><input type=\"text\" name=\"last_name[]\" value=\"$last_name[0]\" /></td>
                            <td><input type=\"text\" name=\"street[]\" value=\"$street[0]\" /></td>
                            <td><input type=\"text\" name=\"city[]\" value=\"$city[0]\" /></td>
                            <td><input type=\"text\" name=\"state[]\" value=\"$state[0]\" class=\"short_field\" /></td>
                            <td><input type=\"text\" name=\"zip[]\" value=\"$zip[0]\" /></td>
                            <td><input type=\"text\" name=\"primary_phone[]\" value=\"$primary_phone[0]\" /></td>
                            <td><input type=\"text\" name=\"email[]\" value=\"$email[0]\" /></td>
                            <td><select name=\"status_id\" style=\"width:50px;\"><option value=\"\">&nbsp;</option>$this->dropOptions</select></td>
                            <td><input type=\"submit\" name=\"search_submit\" value=\"Search\" /></td>
                          </tr>
                        </table>
                        <input type=\"hidden\" name=\"marker\" value=\"1\">
                      </form>";

      return $search_tabs . $search_form . $search_form_products_details . $search_form_credit_card_details . $search_form_shipping_details;
     }

    //----------------------------------------------------------------------------------------------
    function loadDropMenu() 
     {
      $dbMain = $this->dbconnect();
      $stmt = $dbMain->prepare("SELECT status_id, status_name, status_color FROM pos_shipping_status");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($status_id, $status_name, $status_color);   
      
      $this->dropOptions = "";
      while ($stmt->fetch()) 
       {
        if ($this->statusId == $status_id) {
          $selected = "selected";
          $this->statusColor = $status_color;
         } else {
           $selected = "";
         }
        $this->dropOptions .= "<option value=\"$status_id\" style=\"color:$status_color\" $selected>$status_name</option>\n";         
       }
     }

    //----------------------------------------------------------------------------------------------
    function loadCatDropMenu() 
     {
      $dbMain = $this->dbconnect();
      $stmt = $dbMain->prepare("SELECT category_id, category_name FROM pos_category");
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($category_id, $category_name);   
      
      $this->dropCatOptions = "";
      while ($stmt->fetch()) 
       {
        if ($this->categoryId == $category_id) {
          $selected = "selected";
         } else {
           $selected = "";
         }
        $this->dropCatOptions .= "<option value=\"$category_id\" $selected>$category_name</option>\n";         
       }
     }

    //---------------------------------------------------------------------------------------------------------------------------
    function loadStatusName() 
     {
      $dbMain = $this->dbconnect();
      $stmt = $dbMain ->prepare("SELECT status_name FROM pos_shipping_status WHERE status_id = '$this->statusId'");   
      $stmt->execute(); 
      $stmt->store_result();      
      $stmt->bind_result($statusName);
      $stmt->fetch();

      $this->statusName = $statusName;

      if (!$stmt->execute())  {
        printf("Error: %s.\n", $stmt->error);
       }
      $stmt->close(); 
     }

    //----------------------------------------------------------------------------------------------
    function loadRecords()
     {
      include "prepareQuery.php";
      
      $sort_form = "<form id=\"sort_form\">
                      <input type=\"hidden\" id=\"order_by_pre\" name=\"order_by_pre\" value=\"$_SESSION[order_by]\" />
                      <input type=\"hidden\" id=\"order_scent\" name=\"order_scent\" value=\"$orderscentSql\" />
                    </form>";

      /*
      $query = "SELECT * FROM merchant_sales ms"
              ." LEFT JOIN merchant_refund_records mrr ON (mrr.pos_identifier = ms.purchase_marker)"
              ." LEFT JOIN pos_shipping_details psd ON (psd.pos_identifier = ms.purchase_marker)"
              ." WHERE $where GROUP BY purchase_marker ORDER BY purchase_date DESC";
      */
      $rows_offset = ($_SESSION['page_num']-1)*$_SESSION['rows_per_page'];
      $rows_per_page = $_SESSION['rows_per_page'];
      $query = "SELECT * FROM merchant_sales ms"
              ." LEFT JOIN merchant_refund_records mrr ON (mrr.pos_identifier = ms.purchase_marker)"
              ." LEFT JOIN pos_shipping_details psd ON (psd.pos_identifier = ms.purchase_marker)"
              ." WHERE $where GROUP BY purchase_marker$orderbySql LIMIT $rows_offset, $rows_per_page";
//print("<br />\$query=$query"); // !debug!
      $stmt = $dbMain ->prepare($query); 

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($itemMarker, $purchaseMarker, $transactionId, $numberItems, $categoryId, $categoryName, $barCode, $productDesc, 
                         $salesTax, $wholeCost, $retailCost, $totalCost, $purchaseDateTime, $clubId, $clubInvMarker, $internet, $contractKey,
                         $posIdentifier, $cardName, $cardNumber, $total, $month, $year, $auth_id, $cof_bool, $card_type, $trans_token,
                         $generalId, $contractKey2, $posIdentifier2, $firstName, $middleName, $lastName, $street, $city, $state, $zip, $primaryPhone, $email, $statusId);

      $table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
        <tr>
          <th class=\"order_by\" id=\"NULL\">#</th>
          <th class=\"order_by\" id=\"purchase_date\">Date Time</th>
          <th class=\"order_by\" id=\"purchase_marker\">Purchase Marker</th>
          <th class=\"order_by\" id=\"transaction_id\">Transaction ID</th>
          <th title=\"Click [...] to see the Products Details\">Products Details</th>
          <th class=\"order_by\" id=\"club_id\">Club ID</th>
          <th class=\"order_by\" id=\"internet\">Internet</th>
          <th class=\"order_by\" id=\"ms.contract_key\">Contract Key</th>
          <th title=\"Click [...] to see the Credit Card Details\">Credit Card Details</th>
          <th class=\"order_by\" id=\"total\">Total</th>
          <th title=\"Click [...] to see the Shipping Details\">Shipping Details</th>
          <th class=\"order_by\" id=\"status_id\" width=\"150\">Shipping Status</th>
          <th>Delete</th>
        </tr>\n";                   

      //$i = 1;
      $i = $_SESSION['rows_per_page'] * ($_SESSION['page_num']-1) + 1;
      while ($stmt->fetch()) 
       {
        $this->statusId = $statusId;
        $this->loadStatusName();
        $this->loadDropMenu();
        //$purchaseDate = date("m/d/Y", strtotime($purchaseDateTime));
                                                                                               
        $counter = $i++;
        $total = sprintf("%.2f", $total);

        $productsDetails = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"product_details\">
                              <tr>
                                <th>#</th>
                                <th>Inventory<br />Marker</th>
                                <th>Product Description</th>
                                <th>Barcode</th>
                                <th>Category</th>
                                <th>Whole Cost</th>
                                <th>Retail Cost</th>
                                <th>Sales Tax</th>
                                <th>Total Cost</th>
                                <th>Items<br />Number</th>
                                <th>Price</th>
                              </tr>";
        $query2 = "SELECT number_items, category_name, bar_code, product_desc, sales_tax, whole_cost, retail_cost, total_cost, club_id, club_inv_marker FROM merchant_sales"
                ." WHERE purchase_marker='$purchaseMarker' ORDER BY product_desc ASC";
        $stmt2 = $dbMain ->prepare($query2); 
        $stmt2->execute();      
        $stmt2->store_result();      
        $stmt2->bind_result($numberItems, $categoryName, $barCode, $productDesc, $salesTax, $wholeCost, $retailCost, $totalCost, $clubId, $inventoryMarker);
        $j = 1;
        while ($stmt2->fetch()) 
         {
          $price = sprintf("%.2f", $retailCost * $numberItems);
          $productsDetails .= "\n<tr>
                                   <td>$j</td>
                                   <td>$inventoryMarker</td>
                                   <td>$productDesc</td>
                                   <td>$barCode</td>
                                   <td>$categoryName</td>
                                   <td>\$$wholeCost</td>
                                   <td>\$$retailCost</td>
                                   <td>$salesTax</td>
                                   <td>\$$totalCost</td>
                                   <td>$numberItems</td>
                                   <td>\$$price</td>
                                 </tr>\n";
          $j++;
         }
        $productsDetails .= "</table>";
        $productsDetailsTitle = "Click to see the Products Details";

        $creditCardDetails = " Card type: $card_type\n Card number: $cardNumber\n Month: $month\n Year: $year\n Name on the card: $cardName\n Auth ID of transaction: $auth_id\n Was it billed to card on file: $cof_bool\n Transarmor token value of card: $trans_token\n (The Customer's E-mail: $email)";
        $shippingDetails = " First name: $firstName" . (($middleName != "")? ("\n Middle name: ".$middleName) : "") . "\n Last name: $lastName\n Street adress: $street\n City: $city\n State: $state\n Zip code: $zip\n Phone: $primaryPhone\n E-mail: $email\n Status: $this->statusName";
        $closeBox = "<div class=\"close_box\">X</div>";
        
        $records .="<tr>
          <td>$counter<form method=\"post\" action=\"printOrderInvoice.php\" target=\"_blank\"><input type=\"hidden\" name=\"purchase_marker\" value=\"$purchaseMarker\" /><input type=\"submit\" value=\"Prn\" /></form></td>
          <td>$purchaseDateTime</td>
          <td>$purchaseMarker</td>
          <td>$transactionId</td>
          <td>
            <a href=\"javascript:void(0);\" target=\"content\" title=\"$productsDetailsTitle\" class=\"product_details open_extra_info\">...</a>
            <div class=\"extra_info left5\">$closeBox<pre><br /></pre>$productsDetails<br /></div>
          </td>
          <td>$clubId</td>
          <td>$internet</td>
          <td>$contractKey</td>
          <td>
            <a href=\"javascript:void(0);\" target=\"content\" title=\"$creditCardDetails\" class=\"product_details open_extra_info\">...</a>
            <div class=\"extra_info\">$closeBox<pre>$creditCardDetails</pre></div>
          </td>
          <td>\$$total</td>
          <td>
            <a href=\"javascript:void(0);\" target=\"content\" title=\"$shippingDetails\" class=\"product_details open_extra_info\">...</a>
            <div class=\"extra_info\">$closeBox<pre>$shippingDetails</pre></div>
          </td>
          <td>
            <form style=\"display:inline;\" action=\"editDeleteOrders.php\" method=\"post\">
              <select name=\"pos_status$counter\" id=\"pos_status$counter\" class=\"product_details\" style=\"color:$this->statusColor\">
                $this->dropOptions
              </select>
              <input type=\"hidden\" name=\"pos_status_old$counter\" value=\"$this->statusId\" />
              <input type=\"hidden\" name=\"club_id$counter\" value=\"$clubId\" />
              <input type=\"hidden\" name=\"purchase_marker\" value=\"$purchaseMarker\" />
              <input type=\"hidden\" name=\"contract_key\" value=\"$contractKey\" />
              <input type=\"hidden\" name=\"order_salt\" value=\"$counter\">
              <input type=\"hidden\" name=\"search_type\" id=\"search_type\" value=\"$searchType\" />
              <input type=\"hidden\" name=\"search_string\" id=\"search_string\" value=\"$searchString\" />
              <input type=\"hidden\" name=\"edit_switch$counter\" id=\"edit_switch$counter\" value=\"\" />
              <input type=\"submit\" name=\"edit\" id=\"$counter\" value=\"Save\" />
            </form>
          </td>
          <td>
            <form style=\"display:inline;\" action=\"editDeleteOrders.php\" method=\"post\">
              <input type=\"hidden\" name=\"purchase_marker\" value=\"$purchaseMarker\" />
              <input type=\"hidden\" name=\"search_type\" id=\"search_type\" value=\"$searchType\" />
              <input type=\"hidden\" name=\"search_string\" id=\"search_string\" value=\"$searchString\" />
              <input type=\"submit\" name=\"delete\" value=\"Delete\" id=\"delete\" onClick=\"return confirmDelete();\" />
            </form>
          </td>
        </tr>\n";
                                                            
       }

      //hear is the object for multiple records
      $drop_table = "$sort_form  $table_header  $records";
      $this->dropList = $drop_table;
      $this->dropOptions = "";
     }     

    //--------------------------------------------------------------------------------------------------------------------------------
    //these are the links for the table list that are more than one item
    function getList() {
      return($this->dropList);
     } 

  } // class

