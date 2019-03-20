//--------------------------------------------------------------------------------------
$(document).ready(function(){
    var contractKey = $('#contract_key_pre').val();
    
    
    $("#serv_locations").live("change", function(event) {
        
            var ajaxSwitch = 1;
            var locationId = $('#serv_locations').val();
            var servName = $(this).closest('tr').find('#mem_drop').val();
            var nameBuff = servName.split("|");
            var serviceKey = nameBuff[0];
               servName =  nameBuff[1];
            var termText = $(this).closest('tr').find('#termText').text();
            //alert(contractKey+'  '+locationId +'  '+ servName +'  '+ termText + ' '+serviceKey);//
      $.ajax ({
                     type: "POST",
                     url: "changeLocation.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, locationId: locationId, servName: servName, termText: termText, contractKey: contractKey, serviceKey: serviceKey},    //           
                     success: function(data) {
                        alert(data);
                               if(data == 1) {   
                                  //alert('Update!');
                                  $('#homeBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#homeBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
        
        
        
        $("#mem_drop").live("change", function(event) {
        
            var ajaxSwitch = 2;
            var locationId = $('#serv_locations').val();
             var userId = $('#user_id').val();
            var servName = $(this).closest('tr').find('#mem_drop').val();
            var nameBuff = servName.split("|");
            var serviceKey = nameBuff[0];
               servName =  nameBuff[1];
            var termText = $(this).closest('tr').find('#termText').text();
            //alert(contractKey+'  '+locationId +'  '+ servName +'  '+ termText + ' '+serviceKey);//
      $.ajax ({
                     type: "POST",
                     url: "changeLocation.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, locationId: locationId, servName: servName, termText: termText, contractKey: contractKey, serviceKey: serviceKey},    //           
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                  alert('Membership updated! Page will be reloaded with new service.');
                                  window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";
                                  //$('#homeBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  //$('#homeBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });

});  //end of ready function