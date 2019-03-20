$(document).ready(function(){

  //--------------------------------------------------------------------------------------

  if ($("#search_tabs").val() == "")
   {
    $(".search_tabs").eq(0).click();
    $(".search_form").hide();
    $(".search_form").eq(0).show();
   }
  
  //--------------------------------------------------------------------------------------
  $(".search_tabs").each(function() {

    if ($(this).val() == $("#search_tabs").val())
     {
      $(this).click();
      $(".search_form").hide();
      $("#"+$(this).val()).show();
     }

  });
  
  //--------------------------------------------------------------------------------------
  $(".search_tabs").on('click', function() {

    $(".search_form").hide();
    $("#"+$(this).val()).show();
    $("#search_tabs").val($(this).val());

    var searchTabs = $("#search_tabs").val();
    var ajaxSwitch = 1;

    $.ajax ({
      type: "POST",
      url: "setSearchTabs.php",
      cache: false,
      async: false,
      dataType: 'html', 
      data: {search_tabs: searchTabs, ajax_switch: ajaxSwitch},
      success: function(data) {    
        if (data != 1) 
         {
          alert('There was error while setting up the search_tab!');
          return false;
         }
       }//end function success
     }); //end ajax 

  });
  
  //--------------------------------------------------------------------------------------
  $("#search_range").on('click', function() {

    if ($(this).is(':checked'))
     {
      $("#search_row_to").show();
      $("#search_text_from").text("From:");
     }
    else
     {
      $("#search_row_to").hide();
      $("#search_text_from").text("Search:");
     }

  });
  
  //--------------------------------------------------------------------------------------
  $(".search_clear").on('click', function() {

    /*
    $("#search_form input[type='text']").val("");
    $("#search_form select").val("");
    */
    /*
    $("#search_form").find("input[type='text']").val("");
    $("#search_form").find("select").val("");
    */
    $(this).parents(".search_form").find("input[type='text']").val("");
    $(this).parents(".search_form").find("select").val("");

  });
  
  //--------------------------------------------------------------------------------------
  $(".order_by").each(function() {

    var order_by = $(this).attr('id');
    var order_by_pre = $("#order_by_pre").val();
    var order_scent = $("#order_scent").val();

    if (order_by == order_by_pre)
     {
      $(this).addClass('current_sort');
      if (order_by != 'NULL')
        $(this).addClass(order_scent);
     }
  });
  
  //--------------------------------------------------------------------------------------
  $(".order_by").on('click', function() {

    var order_by = $(this).attr('id');
    var order_by_pre = $("#order_by_pre").val();
    var order_scent = $("#order_scent").val();
    var ajaxSwitch = 1;
    var swapScent = 0;

    if (order_by == order_by_pre)
     {
      if (order_scent == 'ASC')
        order_scent = 'DESC';
      else
        order_scent = 'ASC';

      swapScent = 1;
     }

    $(".order_by").removeClass('current_sort');
    $(".order_by").removeClass('ASC');
    $(".order_by").removeClass('DESC');

    $(this).addClass('current_sort');
    if (order_by != 'NULL')
      $(this).addClass(order_scent);
    $("#order_scent").val(order_scent)

    $.ajax ({
      type: "POST",
      url: "setOrderby.php",
      cache: false,
      async: false,
      dataType: 'html', 
      data: {order_by: order_by, swap_scent: swapScent, ajax_switch: ajaxSwitch},
      success: function(data) {    
        if (data == 1) 
         {
//          window.location = "searchOrders.php?search_type=" + $("#search_type").val() + "&search_string=" + $("#search_string").val() + "&marker=" + $("#marker").val();
          window.location = "searchOrders.php?search_type=" + $("#search_type").val() + "&search_string=" + $("#search_string").val() + "&marker=1";
         }
        else
         {
          alert('There was error while setting up the sorting column!');
          return false;
         }
       }//end function success
     }); //end ajax 

  });

  //--------------------------------------------------------------------------------------
  $(".open_extra_info").on('click', function() {

    $(this).parent().children(".extra_info").show();
    $(this).hide();

  });

  //--------------------------------------------------------------------------------------
  $(".extra_info .close_box").on('click', function() {

    $(this).parent().parent().children(".open_extra_info").show();
    $(this).parent().hide();

  });

  //--------------------------------------------------------------------------------------
  $(":submit").live('click', function() {

    var subBut = $(this).attr('id');

    if (subBut != 'delete') 
     {
      var posStat = ('#pos_status'+subBut);
      var editSwitch = ('#edit_switch'+subBut);

      var dropStatValue = $(posStat).val();

      if (0) // buahahah!!!!! We can't make new orders from the admin area!
       {
        var editSwitchValue = 'new';
        $(editSwitch).val(editSwitchValue);   
       }
      else
       {
        var editSwitchValue = 'update';
        $(editSwitch).val(editSwitchValue);
       }

     } //end if not delete

  });
  //--------------------------------------------------------------------------------------------

   
});