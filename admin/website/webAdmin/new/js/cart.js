
  // ========================================
  function recalculateTotals() {

    var subtotal      = 0.0;
    var totalSalesTax = 0.0;
    var totalQty      = 0;

    // adjust the SubTotal
    $('.retail_cost').each(function() { 
      subtotal += parseFloat($(this).val()) * parseInt($('#item_qty_'+$(this).attr('data-item_id')).val()); // (this)retail_cost * item_qty_(this)ID
    });
    $('#subtotal').text(subtotal.toFixed(2));
    // /adjust the SubTotal

    // adjust the Total Sales Tax
    $('.taxed_cost').each(function() { 
      totalSalesTax += parseFloat($(this).val()) * parseInt($('#item_qty_'+$(this).attr('data-item_id')).val()); // (this)taxed_cost * item_qty_(this)ID
    });
    $('#totalSalesTax').text(totalSalesTax.toFixed(2));
    // /adjust the Total Sales Tax

    // adjust the Total Cost
    $('#total').text((subtotal + totalSalesTax).toFixed(2)); 
    // /adjust the Total Cost
  
    // adjust the Total Quantity
    $('.item_qty').each(function() { 
      totalQty += parseInt($(this).val())
    });
    $('#totalQty').text(totalQty);
    // /adjust the Total Quantity
   }


  // ========================================
  $(document).ready(function() {

    // --------------------------------------
    /* Add a product to the shopping cart. */
    $('.add2cart').click(function() {

      var ajaxSwitch = 1;
      var productArray = $("#product_array_"+$(this).attr('id')).val();
      var this_id = $(this).attr('id');
//alert(productArray); // !debug!

      $.ajax ({
        type: "POST",
        url: "php/cart/add-to-cart.php",
        cache: false,
        dataType: 'html', 
        data: {ajaxSwitch: ajaxSwitch, productArray: productArray},               
        success: function(data) {
//alert("data="+data); // !debug!
          var dataArray  = data.split('|');                        
          var successBit = dataArray[0]; 
          var cartCount  = dataArray[1];

          if (successBit == 1) {
            $('#alert-message').html('Your item has been added to the cart!');
            $('#master-alert-box').show().delay(3000).fadeOut();
            $('#login-cart').load('index.php #login-cart');
            $("#"+this_id).removeClass('success').addClass('secondary');
          } else {
            alert('There was an error adding this item to your cart, please try again later!');
          }                     
        }
      });
    });
    /* /Add a product to the shopping cart. */

    // --------------------------------------
    /* Decrease the product's quantity in the shopping cart. */
    $(".item_qty_minus").click( function() {
     
      var ajaxSwitch = 1;
      var itemId = $(this).attr('data-item_id');
      
      if (parseInt($('#item_qty_'+itemId).val()) > 0) {
        $.ajax ({
          type: "POST",
          url: "php/cart/minus-item-qty.php",
          cache: false,
          dataType: 'html', 
          data: {ajaxSwitch: ajaxSwitch, itemId: itemId},               
            success: function(data) {  

              if (data == 1) { 
                /*
                $('#alert-message').html('You have decreased the item's quantity.');
                $('#master-alert-box').show().delay(3000).fadeOut();
                $('#login-cart').load('index.php #login-cart');
                */

                /* v1 - just renew the page */
                /*
                window.location = "shopping-cart.php";
                */
                /* /v1 - just renew the page */

                /* v2 - stay on the page, recalculate all */
                $('#item_qty_'+itemId).val(parseInt($('#item_qty_'+itemId).val()) - 1); // adjust the item's quantity
                $('#cost_'+itemId).text((parseFloat($('#retail_cost_'+itemId).val()) * parseInt($('#item_qty_'+itemId).val())).toFixed(2)); // adjust the item's cost
                recalculateTotals();
                /* /v2 - stay on the page, recalculate all */
              } else {
                alert('There was an error decreasing this item\'s quantity, please try again later!'); // '
              }           
            } // end function success
        }); 
      } else {
        $('#'+itemId).click(); // remove
        return false;
      }
    });
    /* /Decrease the product's quantity in the shopping cart. */

    // --------------------------------------
    /* Increase the product's quantity in the shopping cart. */
    $(".item_qty_plus").click( function() {
     
      var ajaxSwitch = 1;
      var itemId = $(this).attr('data-item_id');
      
      if (parseInt($('#item_qty_'+itemId).val()) < parseInt($(this).attr('data-item_max_qty'))) {
        $.ajax ({
          type: "POST",
          url: "php/cart/plus-item-qty.php",
          cache: false,
          dataType: 'html', 
          data: {ajaxSwitch: ajaxSwitch, itemId: itemId},               
            success: function(data) {  

              if (data == 1) { 
                /*
                $('#alert-message').html('You have increased the item's quantity.');
                $('#master-alert-box').show().delay(3000).fadeOut();
                $('#login-cart').load('index.php #login-cart');
                */

                /* v1 - just renew the page */
                /*
                window.location = "shopping-cart.php";
                */
                /* /v1 - just renew the page */

                /* v2 - stay on the page, recalculate all */
                $('#item_qty_'+itemId).val(parseInt($('#item_qty_'+itemId).val()) + 1); // adjust the item's quantity
                $('#cost_'+itemId).text((parseFloat($('#retail_cost_'+itemId).val()) * parseInt($('#item_qty_'+itemId).val())).toFixed(2)); // adjust the item's cost
                recalculateTotals();
                /* /v2 - stay on the page, recalculate all */
              } else {
                alert('There was an error increasing this item\'s quantity, please try again later!'); // '
              }           
            } // end function success
        }); 
      } else {
        alert("Sorry, we don't have so many pieces in stock at the moment...");
        return false;
      }
    });
    /* /Increase the product's quantity in the shopping cart. */

    // --------------------------------------
    /* Edit the product's quantity in the shopping cart. */
    $(".item_qty").blur( function() {
     
      if (parseInt($(this).val()) == parseInt($(this).attr('data-old_value'))) {
        return false; // do nothing
      }
      if (parseInt($(this).val()) <= 0) {
        $('#'+itemId).click(); // remove
        return false;
      }
      if (parseInt($(this).val()) > parseInt($(this).attr('data-item_max_qty'))) {
        /* v1 */
        /*
        alert("Sorry, we don't have so many pieces in stock at the moment...");
        $(this).val($(this).attr('data-old_value'));
        return false;
        */
        /* /v1 */
        /* v2 */
        alert("Sorry, we have only " + $(this).attr('data-item_max_qty') + " pieces in stock at the moment...");
        $(this).val($(this).attr('data-item_max_qty'));
        /* /v2 */
      }

      var ajaxSwitch = 1;
      var itemId  = $(this).attr('data-item_id');
      var itemQty = $(this).val();
      
//alert("$(this).val()="+$(this).val()+" $(this).attr('data-item_id')="+$(this).attr('data-item_id')+" $(this).attr('data-old_value')="+$(this).attr('data-old_value')); // !debug!
      $.ajax ({
        type: "POST",
        url: "php/cart/edit-item-qty.php",
        cache: false,
        dataType: 'html', 
        data: {ajaxSwitch: ajaxSwitch, itemId: itemId, itemQty: itemQty},               
          success: function(data) {  

            if (data == 1) { 
              /*
              $('#alert-message').html('You have edited the item's quantity.');
              $('#master-alert-box').show().delay(3000).fadeOut();
              $('#login-cart').load('index.php #login-cart');
              */

              /* v1 - just renew the page */
              /*
              window.location = "shopping-cart.php";
              */
              /* /v1 - just renew the page */

              /* v2 - stay on the page, recalculate all */
              //$('#cost_'+itemId).text((parseFloat($('#retail_cost_'+itemId).val()) * parseInt($('#item_qty_'+itemId).val())).toFixed(2)); // adjust the item's cost
              $('#cost_'+itemId).text((parseFloat($('#retail_cost_'+itemId).val()) * parseInt(itemQty)).toFixed(2)); // adjust the item's cost
              recalculateTotals();
              /* /v2 - stay on the page, recalculate all */
            } else {
              alert('There was an error editing this item\'s quantity, please try again later!'); // '
            }           
          } // end function success
      }); 
    });
    /* /Edit the product's quantity in the shopping cart. */

    // --------------------------------------
    /* Remove a product from the shopping cart. */
    $(".remove").click( function() {
     
      var ajaxSwitch = 1;
      var itemId = $(this).attr('id');
      
      if (confirm('This will remove this item from your cart. Are you sure?')) {
        $.ajax ({
          type: "POST",
          url: "php/cart/remove-from-cart.php",
          cache: false,
          dataType: 'html', 
          data: {ajaxSwitch: ajaxSwitch, itemId: itemId},               
            success: function(data) {  
//alert("data="+data); // !debug!
              var dataArray  = data.split('|');                        
              var successBit = dataArray[0]; 
              var cartCount  = dataArray[1];
              var rowCounter = 0;
              var totalQty   = 0;

              if (successBit == 1) { 
                $('#alert-message').html('Your item has been removed from the cart!');
                $('#master-alert-box').show().delay(3000).fadeOut();
                $('#login-cart').load('index.php #login-cart');

                /* v1 - just renew the page */
                /*
                window.location = "shopping-cart.php";
                */
                /* /v1 - just renew the page */

                /* v2 - stay on the page, recalculate all */
                $('.item_row_'+itemId).remove(); // remove the item row from the table

                $('.row_num').each(function() { // renumerate the rows
                  $(this).text(++rowCounter)
                });
                $('#numberOfCartItems').text(rowCounter);  // adjust the numberOfCartItems at the top right corner of the page

                /* v.old
                // adjust the SubTotal, Total Sales Tax, Total Cost
                //$('#subtotal').text(parseFloat($('#subtotal').text()) - parseFloat($('#cost_'+itemId).text())); // adjust the Total Cost
                $('.cost_'+itemId).each(function() { 
                  $('#subtotal').text((parseFloat($('#subtotal').text()) - parseFloat($('.cost_'+itemId).text())).toFixed(2)) // adjust the SubTotal
                  $('#totalSalesTax').text(( parseFloat($('#totalSalesTax').text()) - parseFloat($('#taxed_cost_'+itemId).val()) * parseFloat($('#item_qty_'+itemId).val()) ).toFixed(2)) // adjust the Total Sales Tax
                });
                $('#total').text((parseFloat($('#subtotal').text()) + parseFloat($('#totalSalesTax').text())).toFixed(2)); // adjust the Total Cost
                // /adjust the SubTotal, Total Sales Tax, Total Cost

                $('.item_qty').each(function() { // adjust the Total Quantity
                  totalQty += parseInt($(this).val())
                });
                $('#totalQty').text(totalQty);
                /v.old */
                recalculateTotals();

                if (cartCount == 0) { 
                  $('.hide_buttons').hide(); // hide the buttons
                }
                /* /v2 - stay on the page, recalculate all */
              } else {
                alert('There was an error removing this item from your cart, please try again later!');
              }           
            } // end function success
        }); 
      } else {
        return false;
      }
    });
    /* /Remove a product from the shopping cart. */

    // --------------------------------------
    /* Empty the shopping cart. */
    $("#empty_cart").click( function() {
     
      var ajaxSwitch = 1;
      
      if (confirm('This will remove all the items from your cart! Are you sure?')) {
        $.ajax ({
          type: "POST",
          url: "php/cart/empty-cart.php",
          cache: false,
          dataType: 'html', 
          data: {ajaxSwitch: ajaxSwitch},               
            success: function(data) {  
              var cartCount = 0;

              if (data == 1) { 
                $('#alert-message').html('Your cart has been emptied!');
                $('#master-alert-box').show().delay(3000).fadeOut();
                $('#login-cart').load('index.php #login-cart');

                /* v1 - just renew the page */
                /*
                window.location = "shopping-cart.php";
                */
                /* /v1 - just renew the page */

                /* v2 - stay on the page, recalculate all */
                $('#totalQty').text("0");  // adjust the Total Quantity
                $('#numberOfCartItems').text("0");  // adjust the numberOfCartItems at the top right corner of the page
                $('#subtotal').text("0.00");  // adjust the SubTotal
                $('#totalSalesTax').text("0.00");  // adjust the Total Sales Tax
                $('#total').text("0.00");  // adjust the Total Cost
                $('.item_row').remove();   // remove the item rows from the table
                $('.hide_buttons').hide(); // hide the buttons
                /* /v2 - stay on the page, recalculate all */
              } else {
                alert('There was an error emptying the cart, please try again later!');
              }           
            } // end function success
        }); 
      } else {
        return false;
      }
    });
    /* /Empty the shopping cart. */

    // --------------------------------------
    /* Recalculate the shopping cart. */
    $("#recalculate_cart").click( function() {
     
      var ajaxSwitch = 1;
      
      $.ajax ({
        type: "POST",
        url: "php/cart/recalculate-cart.php",
        cache: false,
        dataType: 'html', 
        data: {ajaxSwitch: ajaxSwitch},               
          success: function(data) {  
//alert("data="+data); // !debug!
            var dataArray  = data.split('|');                        
            var successBit = dataArray[0]; 
            var cartCount  = dataArray[1];

            if (successBit == 1) { 
              /*
              $('#alert-message').html('Your cart has been recalculated!');
              $('#master-alert-box').show().delay(3000).fadeOut();
              $('#login-cart').load('index.php #login-cart');
              */

              /* (see ../shopping-cart.php #recalculate_cart) */
              /* v1 - just renew the page (working more correctly than v2) */
              window.location = "shopping-cart.php";
              /* /v1 - just renew the page */

              /* v2 - stay on the page, recalculate all */
              /*
              // do nothing - we will go to shopping-cart.php by the href of the #recalculate_cart
              */
              /* /v2 - stay on the page, recalculate all */
              /* /(see ../shopping-cart.php #recalculate_cart) */
            } else {
              alert('There was an error recalculating the cart, please try again later!');
            }           
          } // end function success
      }); 
    });
    /* /Recalculate the shopping cart. */

    // --------------------------------------
    /* Purchase the products in the shopping cart. */
    // (This button will decrement the value till 0)
    // Huh, this is realized by processWebCart.js , so disregard this function now!
    /*
    $("#purchase").click( function() {
      
      var ajaxSwitch = 1;
      var billAmount = $('#total').val(); 
      
      $.ajax ({
        type: "POST",
        url: "php/cart/change-billing-amount.php",
        cache: false,
        dataType: 'html', 
        data: {ajaxSwitch: ajaxSwitch, billAmount: billAmount, contractKey: contractKey},               
          success: function(data) {  
//alert("data="+data); // !debug!
            if (data == 1) { 
              alert('Billing Amount has been updated! Page will be reloaded.');
              window.location = "account-information.php?contract_key=" + contractKey + "&user_id=" + userId + ""; 
              //$('#month').val(billAmount);  
            } else {
              alert('There was an error!');
            }                     
          } // end function success
      }); // end ajax 
      //alert(process); // !debug!
      //alert(dueToday); // !debug!
    });
    */
    /* /Purchase the products in the shopping cart. */

  });
