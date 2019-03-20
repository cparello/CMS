$(document).ready(function(){
//-------------------------------------------------
$('#print_receipt').click(function() {

   var purchaseMarker = $("#purchase_marker").val();
   var ajaxSwitch = 1;
   var purchaseType = 'C';

        if(purchaseMarker == "") {
          alert("Please make a class purchase before printing a receipt");
                  return false;
          }


$.ajax ({
            type: "POST",
            url: "../pos/setPrintOptions.php",
            cache: false,
            dataType: 'html', 
            data: {purchase_marker: purchaseMarker, ajax_switch: ajaxSwitch, purchase_type: purchaseType},               
                 success: function(data) {    
                //  alert(data);
                 if(data == "R") {
                   window.open('receiptWindow.php','','scrollbars=yes,menubar=no,height=400,width=275,resizable=no,toolbar=no,location=no,status=no');
                   }else if(data == "L") {                     
                   window.open('receiptWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');                   
                   }else{
                   alert(data);
                   }
                                             
                     }//end function success
              }); //end ajax 


 });
//-------------------------------------------------
 });