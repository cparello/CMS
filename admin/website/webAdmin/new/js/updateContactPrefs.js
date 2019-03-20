//--------------------------------------------------------------------------------------
$(document).ready(function(){
    var contractKey = $('#contract_key').val();
    
    
    $("#no_call_home").live("change", function(event) {
        var ajaxSwitch = 1;
           //     alert();
           alert(contractKey);
     if(document.getElementById('no_call_home').checked == false){
         var checked = 'N';       
     }else{
         var checked = 'Y';   
     }
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                    // alert(data);
                               if(data == 1) {   
                                  //alert('Update!');
                                  $('#homeBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#homeBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
      //=============================================================================  
    $("#no_call_cell").live("change", function(event) {
        var ajaxSwitch = 2;
     if(document.getElementById('no_call_cell').checked == false){
         var checked = 'N';       
     }else{
         var checked = 'Y';   
     }
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                   $('#cellBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#cellBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });

  //===============================================================
    $("#no_email").live("change", function(event) {
        var ajaxSwitch = 4;
     if(document.getElementById('no_email').checked == false){
         var checked = 'N';       
     }else{
         var checked = 'Y';   
     }
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                   $('#emailBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#emailBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
         //===============================================================
    $("#no_text").live("change", function(event) {
        var ajaxSwitch = 3;
     if(document.getElementById('no_text').checked == false){
         var checked = 'N';       
     }else{
         var checked = 'Y';   
     }
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                   $('#textBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#textBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
         //===============================================================
    $("#no_mail").live("change", function(event) {
        var ajaxSwitch = 5;
     if(document.getElementById('no_mail').checked == false){
         var checked = 'N';       
     }else{
         var checked = 'Y';   
     }
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                   $('#mailBox').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Updated");
                                  $('#mailBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
         //===============================================================
   $("#pref_contact").live("change", function(event) {
        var ajaxSwitch = 6;
     var checked = $('#pref_contact').val();
      $.ajax ({
                     type: "POST",
                     url: "php/updateContactPrefs.php",
                     cache: false,
                     dataType: 'html', 
                     data: {ajaxSwitch: ajaxSwitch, checked: checked, contractKey: contractKey},               
                     success: function(data) {
                        //alert(data);
                               if(data == 1) {   
                                   $('#prefBox').html("&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  Updated");
                                  $('#prefBox').css( { "color" : "green"} );
                                          return false;
                                 }                             
                                 }
                       
                  }); //end ajax 
            
        });
});  //end of ready function