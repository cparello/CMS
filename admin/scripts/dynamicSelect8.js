$(document).ready(function() {
//-----------------------------------------------------------------
function resetDropDowns(fromWhere) {

var employeeNameDrop = "<option value>Select Employee</option>";
var serviceTypeDrop = "<option value>Select Service Type</option>";

     switch(fromWhere) {
        case "SL":
        $("#employee_name").html(employeeNameDrop);
        $("#service_type").html(serviceTypeDrop);
        break;
        case "ET":
        $("#service_type").html(serviceTypeDrop);
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
                url: "employeeTypeDropsTwo.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId},               
                     success: function(data) { 
                    //alert(data);
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
//-----------------------------------------------------------------
$("#employee_type").live("change", function(event) {

var clubId = $("#service_location").val();
var employeeType = $("#employee_type").val();
var ajaxSwitch = 1;
var fromWhere ='ET';

  if(employeeType != "") {  
             
        $.ajax ({
                type: "POST",
                url: "employeeNameDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, employee_type: employeeType},               
                     success: function(data) { 
                  //  alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#employee_name").html(data);
                             resetDropDowns(fromWhere);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#employee_name").live("change", function(event) {

var clubId = $("#service_location").val();
var employeeType = $("#employee_type").val();
var employeeName = $("#employee_name").val();
var employeeArray = "";
var ajaxSwitch = 1;

if(employeeName != "") {  
       
  if(employeeName != '0') {     
      employeeArray = (employeeName+ '|');      
    }else{    
        $("#employee_name > option").each(function() {              
             if(this.selected == false) {
               employeeArray += (this.value+ '|');
               }               
          });     
     }
  

        $.ajax ({
                type: "POST",
                url: "serviceNameDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, employee_array: employeeArray},               
                     success: function(data) { 
                   //alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#service_type").html(data);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

     }
});
//----------------------------------------------------------------

});


