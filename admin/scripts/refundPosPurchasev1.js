$(document).ready(function() {
//----------------------------------------------------------------
function refundPurchase(purchaseMarker, ajaxSwitch) {

$.ajax ({
            type: "POST",
            url: "../pos/refundPosPurchase.php",
            cache: false,
            async:false,
            dataType: 'html', 
            data: {purchase_marker: purchaseMarker, ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);                 
                         $("#delete_bool").val(data);                                                 
                     }//end function success
              }); //end ajax           

}
//----------------------------------------------------------------
$('#refund_purchase').click(function() {

var purchaseMarker = $('#purchase_marker').val();
var ajaxSwitch = 1;
var purchaseType = 'ref';
        
      if(purchaseMarker == "") {
        alert('There are currently no purcahses to refund');
               return false;
               }

  var answer = confirm("This will refund this POS transaction.  Do you wish to continue?");
   if (!answer) {
      return false;
     }


$.ajax ({
            type: "POST",
            url: "../pos/setPrintOptions.php",
            cache: false,
            dataType: 'html', 
            data: {purchase_marker: purchaseMarker, ajax_switch: ajaxSwitch, purchase_type: purchaseType},               
                 success: function(data) {    
                  //alert(data);
                 if(data == "R") {
                          refundPurchase(purchaseMarker, ajaxSwitch);
                           var deleteBool = $('#delete_bool').val();
                         if(deleteBool == "1") {                                     
                            window.open('receiptWindow.php','','scrollbars=yes, menubar=no, height=400, width=275, resizable=no, toolbar=no, loaction=no,status=no');
                           }else{
                           alert('There was an error processing this refund' +deleteBool);
                           }
                   }else if(data == "L") {                     
                   var deleteBool = refundPurchase(purchaseMarker, ajaxSwitch);
                         if(deleteBool == 1) {                                     
                            window.open('receiptWindow.php','','scrollbars=yes, menubar=no, height=600, width=800, resizable=no, toolbar=no, loaction=no,status=no');
                           }else{
                           alert('There was an error processing this refund' +deleteBool);
                           }                         
                         
                 
                   }else{
                   alert(data);
                   }
                                             
                     }//end function success
              }); //end ajax 

}); 
//--------------------------------------------------------------
}); 