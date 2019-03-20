$(document).ready(function() {
//-----------------------------------------------------------------
function resetDropDowns() {

var classNameDrop = "<option value>Select Class Name</option>";
      $("#class_name").html(classNameDrop);

}
//-----------------------------------------------------------------
$("#service_location").live("change", function(event) {

var clubId = $("option:selected", this).val();
var optionDrops = "";
var ajaxSwitch = 1;

  if(clubId != "") {       
        
        $.ajax ({
                type: "POST",
                url: "scheduleCategoryDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId},               
                     success: function(data) { 
                     //alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#schedule_type").html(data);
                               resetDropDowns();
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#schedule_type").live("change", function(event) {

var scheduleType = $("option:selected", this).val();
var clubId = $("#service_location").val();
var ajaxSwitch = 1;

  if(scheduleType != "") {       
        
        $.ajax ({
                type: "POST",
                url: "scheduleBundleDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, club_id: clubId},               
                     success: function(data) { 
                     //alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#class_name").html(data);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }


});
//----------------------------------------------------------------

});













