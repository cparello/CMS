<?php
      $dbMain = $this->dbconnect();

      $where = "1";

      $searchType = $this->search_type; 
      $searchString = $this->search_string; 

      switch ($searchType)
       {
        case "cat":
          $where = "category_id = '$searchString'";
          break;
        case "stat":
          if ($searchString == '0')
            $where = "((status_id = '$searchString') OR (status_id IS NULL))";
          else
            $where = "status_id = '$searchString'";
          break;
        case "bar":
          $where = "bar_code = '$searchString[0]'";
          break;
        case "desc":
          $where = "product_desc LIKE '$searchString[0]%'";
          break;
       }

      
      if (isset($_POST['search_submit']))
       {
        $_SESSION['POST'] = $_POST;
       }
      else
       {
        if (isset($_SESSION['POST']))
          $_POST = $_SESSION['POST'];
       }
      
      if (isset($_POST['search_submit']))
       {
        $cmp = isset($_POST['search_range']) ? ">=" : "=";
        foreach ($_POST as $key=>$val)
          if ($val[0] != "")
            switch ($key)
             {
              case 'search_range':
              case 'search_clear':
              case 'search_submit':
              case 'marker':
                break;
              case 'purchase_date':
                $where .= " AND DATE_FORMAT($key, '%m/%d/%Y') $cmp '$val[0]'";
                break;
              case 'internet':
              case 'cof_bool':
                $where .= " AND $key = '$val'";
                break;
              case 'status_id':
                if ($val == '0')
                  $where .= " AND (($key = '$val') OR ($key IS NULL))";
                else
                  $where .= " AND $key = '$val[0]'";
                break;
              case 'contract_key':
                $where .= " AND ms.$key $cmp '$val[0]'";
                break;
              case 'total':
                $where .= " AND CONVERT($key,DECIMAL(10,2)) $cmp '$val[0]'";
                break;
              case 'product_desc':
              case 'card_name':
              case 'first_name':
              case 'middle_name':
              case 'last_name':
              case 'street':
              case 'city':
              case 'email':
                $where .= " AND $key LIKE '%$val[0]%'";
                break;
              case 'price':
                $where .= " AND (retail_cost*number_items) $cmp '$val[0]'";
                break;
              case 'card_number':
                $where .= " AND $key $cmp '************$val[0]'";
                break;
              default:
                $where .= " AND $key $cmp '$val[0]'";
             }
        
        if (isset($_POST['search_range']))
         {
          $cmp = "<=";
          foreach ($_POST as $key=>$val)
            if ($val[1] != "")
              switch ($key)
               {
                case 'search_range':
                case 'search_clear':
                case 'search_submit':
                case 'marker':
                  break;
                case 'purchase_date':
                  $where .= " AND DATE_FORMAT($key, '%m/%d/%Y') $cmp '$val[1]'";
                  break;
                case 'contract_key':
                  $where .= " AND ms.$key $cmp '$val[1]'";
                  break;
              case 'total':
                $where .= " AND CONVERT($key,DECIMAL(10,2)) $cmp '$val[1]'";
                break;
                default:
                  $where .= " AND $key $cmp '$val[1]'";
               }
         }
       }
       


      $orderscentSql = isset($_SESSION['order_scent'])? $_SESSION['order_scent'] : "ASC";
      $orderbySql = isset($_SESSION['order_by']) ? 
                      (
                       ($_SESSION['order_by'] == 'total') ?
                         (" ORDER BY CONVERT(" . $_SESSION['order_by'] . ",DECIMAL(10,2)) " . $orderscentSql) 
                        :
                         (" ORDER BY " . $_SESSION['order_by'] . " " . $orderscentSql) 
                      ) 
                     : 
                      "";

?>