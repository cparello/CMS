$(document).ready(function() {
    $('#upload').prop("disabled",true); 
//================================================================
$("#preview").click( function() {
  var app = $("#billing").val();  
    
    if(app == 'N'){
        alert('You do not have access to this application.');
        return false;
    }else{
     var response =  confirm('This will run a preview of the billing for the day and fee you have selected.  Do you wish to continue?');
                                if(!response) {         
                                   return false;
                                  }  
    
    
    var clubId = $("#locationSnap").val();
    var day = $("#day").val();
    
    if(day == ""){
        alert('Please enter a day.');
        return false;
    }
    
    if(clubId == ""){
        alert('Please select a club.');
        return false;
    }


    //window.location = "../admin/firstData/monthlyBillingSelectorPreview.php?clubId="+clubId+"&day="+day;  
    
     $.ajax ({
                 type: "POST",
                 url: "nmi/monthlyBillingSelectorPreview.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {clubId: clubId, day: day},              
                 success: function(data) {    
                //alert(data);
                    var dataArray = data.split('|');
                    var successBit = dataArray[0];
                    var billCount = dataArray[1];
                    var rateCount = dataArray[2];
                    var efCount = dataArray[3];
                    var mfCount = dataArray[4];
                    
                    if(successBit == 1) {
                      alert('Success the preview of billing is ready to be viewed!');
                      $("#monthly").val(billCount);
                      $("#rf").val(rateCount);
                      $("#ef").val(efCount);
                      $("#mf").val(mfCount);
                      return false;                            
                       }else{  
                       alert('Failed!');
                       return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax        
        
}


        

});
//----------------------------------------------------------------
$("#preload").click( function() {
//alert('fu');
var app = $("#billing").val();
if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{

var response =  confirm('This will load the billing for the day and fee you have selected.  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }  



var day = $("#day2").val();
var clubId = $("#locationMem").val();
var ajaxSwitch = 1;

if(day == ""){
    alert('Please enter a day.');
    return false;
}

if(clubId == ""){
    alert('Please select a club.');
    return false;
}


   $.ajax ({
                 type: "POST",
                 url: "nmi/monthlyBillingSelector.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {clubId: clubId, day: day, ajaxSwitch: ajaxSwitch},              
                 success: function(data) {    
                //alert(data);
                     var dataArray = data.split('|');
                        var successBit = dataArray[0];
                        var billCount = dataArray[1];
                        var rateCount = dataArray[2];
                        var efCount = dataArray[3];
                        var mfCount = dataArray[4];
                    
                    if(successBit == 1) {
                          alert('Success the billing has been loaded and is ready to be executed!');
                          $("#monthly2").val(billCount);
                          $("#rf2").val(rateCount);
                          $("#ef2").val(efCount);
                          $("#mf2").val(mfCount);
                      return false;                            
                       }else{  
                           alert('Failed!');
                           return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax      
}

});
//----------------------------------------------------------------
$("#build").click( function() {
//alert('fu');
var app = $("#billing").val();
if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
var response =  confirm('This will Create the batch file.  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }  



var ajaxSwitch = 1;


   $.ajax ({
                 type: "POST",
                 url: "nmi/buildBatchFile.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajaxSwitch: ajaxSwitch},              
                 success: function(data) {  
                    console.log(data);
                     var dataArray = data.split('|');
                        var successBit = dataArray[0];
                        var fileName = dataArray[1];
                        var recordCount = dataArray[2];
                //alert(data);
                    if(successBit == 1) {
                      alert('Success the Batch File has been created please upload. Please wait then retrieve the response file.');
                      $("#records").val(recordCount);
                      $("#filename").val(fileName);
                      $('#upload').prop("disabled",false);
                      return false;                          
                       }else if(successBit == 2){  
                       alert('No Records to process!');
                       return false;                                              
                       }else{
                        alert('Failed: ERROR');
                       }
                                             
                     }//end function success
              }); //end ajax      
}

});
//----------------------------------------------------------------
$("#upload").click( function() {
//alert('fu');
var app = $("#billing").val();
if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{

var response =  confirm('This will UPLOAD the batch file.  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }  

var filename = $("#filename").val();

var ajaxSwitch = 1;


   $.ajax ({
                 type: "POST",
                 url: "nmi/uploadBatchFile.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajaxSwitch: ajaxSwitch, filename: filename},              
                 success: function(data) {  
                    
                //alert(data);
                    if(data == 1) {
                      alert('File Uploaded! Please wait then retrieve the response file.');
                      return false;                          
                       }else{
                        alert('Failed: ERROR');
                       }
                                             
                     }//end function success
              }); //end ajax      
}

});
//----------------------------------------------------------------
$(".p2x1").click( function() {
//alert('fu');
var app = $("#billing").val();
if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{

var response =  confirm('This will download the response file.  Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }  



var ajaxSwitch = 1;


   $.ajax ({
                 type: "POST",
                 url: "nmi/processNmiResponseFile.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajaxSwitch: ajaxSwitch},              
                 success: function(data) {    
                //alert(data);
                    if(data == 1) {
                      alert('Success the Batch File has been downloaded and processed.');
                      return false;                          
                       }else{  
                       alert('Failed!');
                       return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax      
}

});
//----------------------------------------------------------------
$("#view").click( function() {

var month = $("#monthP").val();
var day = $("#dayP").val();
var year = $("#yearP").val();
var fee = $("#fee").val();
var ajaxSwitch = 1;

window.open('nmi/billingReport.php?month='+month+'&day='+day+'&year='+year+'&fee='+fee+'&ajaxSwitch='+ajaxSwitch,'scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

});
//----------------------------------------------------------------
//----------------------------------------------------------------
$("#view2").click( function() {

var month = $("#monthP2").val();
var day = $("#dayP2").val();
var year = $("#yearP2").val();
var fee = $("#fee2").val();
var passFail = $("#passFail").val();
var ajaxSwitch = 2;

window.open('nmi/billingReport.php?month='+month+'&day='+day+'&year='+year+'&fee='+fee+'&ajaxSwitch='+ajaxSwitch+'&passFail='+passFail,'scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

});
//----------------------------------------------------------------
//----------------------------------------------------------------
$("#view3").click( function() {

var month = $("#monthP").val();
var day = $("#dayP").val();
var year = $("#yearP").val();
var fee = $("#fee").val();
var ajaxSwitch = 3;

window.open('nmi/billingReport.php?month='+month+'&day='+day+'&year='+year+'&fee='+fee+'&ajaxSwitch='+ajaxSwitch,'scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

});
//----------------------------------------------------------------
//----------------------------------------------------------------
$("#view4").click( function() {

var month = $("#monthP2").val();
var day = $("#dayP2").val();
var year = $("#yearP2").val();
var fee = $("#fee2").val();
var ajaxSwitch = 4;

window.open('nmi/billingReport.php?month='+month+'&day='+day+'&year='+year+'&fee='+fee+'&ajaxSwitch='+ajaxSwitch,'scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

});
//----------------------------------------------------------------
//=====================================================
});