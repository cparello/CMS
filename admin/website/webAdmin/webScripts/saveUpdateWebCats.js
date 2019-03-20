$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions1]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions1]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});
$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions2]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions2]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});
$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions3]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions3]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions4]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions4]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions5]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions5]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions6]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions6]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions7]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions7]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions8]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions8]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions9]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions9]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions10]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions10]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions11]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions11]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions12]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions12]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions13]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions13]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions14]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions14]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions15]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions15]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});

$(function() {
    var ajaxSwitch = 1;
    var radios1 = $('input[name=inventoryOptions16]');
    radios1.on('change', function() {
    var inventory1 = $('input:radio[name=inventoryOptions16]:checked').val();    
    
    var dataArray = inventory1.split('|');                        
    var show = dataArray[0]; 
    var catId = dataArray[1];
    var catName = dataArray[2];
       
        $.ajax ({
                type: "POST",
                url: "saveUpdateStoreCats.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, catId: catId, catName: catName, catShow: show},               
                     success: function(data) {  

                          if(data == 1) {                             
                            alert('Updated!');
                            }else{
                            alert('There was an error!');
                            }                     
                                          
                     }//end function success
                 }); //end ajax 
        
        
    });
});