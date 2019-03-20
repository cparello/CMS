$(document).ready(function() {
//----------------------------------------------------------------
$("#bundle_type").live("change", function(event) {

var ajaxSwitch = 1;
var bundleType = $("#bundle_type").val();
var scheduleType = $("#schedule_type").val();

var bundleTypeArray = bundleType.split(',');
var bundleId = bundleTypeArray[0];
var locationId = bundleTypeArray[1];



if(bundleType != "") {

    $.ajax ({
                type: "POST",
                url: "serviceList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, bundle_id: bundleId, location_id: locationId},               
                     success: function(data) {  
                         
                        $("#listHouse").show("fast");
                        $("#listHouse").html(data);
                         
                         }//end function success
               }); //end ajax 

}



});
//---------------------------------------------------------------
$('input:checkbox').live("click", function(event) {
    if ($(this).attr('checked')) {
        $(this).closest('tr').addClass('checked');
    } else {
        $(this).closest('tr').removeClass('checked');
    }
});
//---------------------------------------------------------------
});