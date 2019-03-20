$(document).ready(function() {

//----------------------------------------------------------------
$("#viewClasses").click( function() {

var ajaxSwitch =1;
var eventDate = $("#datepicker").val();
var scheduleTypeArray = $("#schedule_type").val();
      scheduleTypeArray = scheduleTypeArray.split(",");
var scheduleType = scheduleTypeArray[0];
var locationId =  scheduleTypeArray[1];

   
   if(eventDate == "") {
       alert('Please provide a date for this session');
               return false;
     }else{
       var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
         if(!(date_regex.test(eventDate))) {
              alert('The date you entered is not in the correct format.  Please use \"mm/dd/yyyy\" ');
                     return false;
           }                    
     }


   if(scheduleType == "") {
      alert('Please select a \"Schedule Category\"');
         return false;
     }

   $("#type_id").val(scheduleType);
   $("#location_id").val(locationId);



$.ajax ({
                type: "POST",
                url: "loadClassList.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, event_date: eventDate},               
                     success: function(data) {  

                     var dataArray = data.split('|');                        
                     var successBit = dataArray[0]; 
                     var listings = dataArray[1];
                     
                          if(successBit == 1) {                             
                             $("#classList").html(listings);
                             $("#listings").tablesorter();
                             $('#listings.tablesorter').tablesorter({
                                scrollHeight: 385,
                                widgets: ['scroller']
                               });                 
                            }else{
                            alert(data);
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
                 


 }); 
//-------------------------------------------------------------------------------
 }); 