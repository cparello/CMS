$(document).ready(function() {
//-----------------------------------------------------------------
function resetDropDowns(fromWhere) {

var compensationDrop = "<option value>Select Compensation</option>";
var employeeDrop = "<option value>Select Employee Type</option>";

     switch(fromWhere) {
        case "SL":
        $("#compensation_type").html(compensationDrop);
        $("#employee_type").html(employeeDrop);
        $("#ot_type").val("");
        break;
        case "PC":
        $("#employee_type").html(employeeDrop);
        $("#ot_type").val("");
        break;     
        case "CT":
        $("#ot_type").val("");
        break;   
        }

}
//-----------------------------------------------------------------
$("#service_location").live("change", function(event) {

var clubId = $("#service_location").val();
var ajaxSwitch = 1;
var fromWhere ='SL';

  if(clubId != "") {  
             
        $.ajax ({
                type: "POST",
                url: "payrollCycleDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId},               
                     success: function(data) { 
                   // alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#payment_cycle").html(data);
                                resetDropDowns(fromWhere);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#payment_cycle").live("change", function(event) {

var clubId = $("#service_location").val();
var paymentCycle = $("#payment_cycle").val();
var ajaxSwitch = 1;
var fromWhere ='PC';

  if(paymentCycle != "") {  
             
        $.ajax ({
                type: "POST",
                url: "compensationTypeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, payment_cycle: paymentCycle},               
                     success: function(data) { 
                   // alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#compensation_type").html(data);
                             resetDropDowns(fromWhere);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#compensation_type").live("change", function(event) {

var clubId = $("#service_location").val();
var paymentCycle = $("#payment_cycle").val();
var compType = $("#compensation_type").val();
var ajaxSwitch = 1;
var fromWhere ='CT';

  if(compType != "") {  
             
        $.ajax ({
                type: "POST",
                url: "employeeTypeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, payment_cycle: paymentCycle, comp_type: compType},               
                     success: function(data) { 
                  // alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#employee_type").html(data);
                                resetDropDowns(fromWhere);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//----------------------------------------------------------------

});


