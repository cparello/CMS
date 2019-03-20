$(document).ready(function() {
//----------------------------------------------------------------
$('.re').click(function() {

var ajaxSwitch = 1;
var purchaseMarker = $('#purchase_marker').val();

if(purchaseMarker == "") {
  alert('Please submit this transaction before printing a receipt');
          return false;
  }


$.ajax ({
            type: "POST",
            url: "loadPrintOptions.php",
            cache: false,
            dataType: 'html', 
            data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                //  alert(data);
                 if(data == "R") {                                   
                            window.open('receiptWindowOwed.php','','scrollbars=yes, menubar=no, height=400, width=275, resizable=no, toolbar=no, loaction=no,status=no');
              
                   }else if(data == "L") {                                                        
                            window.open('receiptWindowOwed.php','','scrollbars=yes, menubar=no, height=600, width=800, resizable=no, toolbar=no, loaction=no,status=no');
                            
                   }else{
                           alert('There was an error processing this refund' +data);
                   }                         
                         
                                             
                     }//end function success
              }); //end ajax 
}); 
//--------------------------------------------------------------
}); 