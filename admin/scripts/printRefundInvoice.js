 this.serviceArray = "";
$(document).ready(function(){
//---------------------------------------------------------------------------------------
function openInvoiceWindow() {

document.form1.invoice_bit.value = 1;
window.open('createRefundInvoice.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

}
//---------------------------------------------------------------------------------------
$('#refund_invoice').click(function() { 

  var refundCheck = $('#refund_check').is(':checked');
  var refundBalance = $("#refund_balance").val();
  var ajaxSwitch = 1;
  var refundArray = "";

       if(refundCheck == false) {
          alert('Please check the \"Select Refund Credit\" checkbox before printing this Refund Invoice');
                  return false;
         }

       if(refundBalance == "0.00") {
          alert('Please select a service\(s\) to refund before printing this Refund Invoice');
                  return false;              
         }


  var firstName = $("#first_name").val();
  var middleName = $("#middle_name").val();
  var lastName = $("#last_name").val();
  var streetAddress = $("#street_address").val();
  var cityName = $("#city").val();
  var stateName = $("#state").val();
  var zipCode = $("#zip_code").val();
  var contractKeyInvoice = $("#contract_key_pre").val();
  
 
  firstName = encodeURIComponent(firstName);
  middleName = encodeURIComponent(middleName);
  lastName = encodeURIComponent(lastName);
  streetAddress = encodeURIComponent(streetAddress);
  cityName = encodeURIComponent(cityName);
  stateName = encodeURIComponent(stateName);
  zipCode = encodeURIComponent(zipCode);
  contractKeyInvoice = encodeURIComponent(contractKeyInvoice);
  refundBalance = encodeURIComponent(refundBalance);
  
 
  //get the service data from the refund html table
  $('#secTab3 tr').each(function(i) {
  
     var serviceData = "";
     var refundType = "";
     var serviceName = "";
     var serviceRefund = "";
  
    if (!this.rowIndex) return; // skip first row
       
           var row = $(this);
        if (row.find('input[type="checkbox"]').is(':checked'))  {
            refundType = this.cells[1].innerHTML;
            serviceName = this.cells[2].innerHTML;
            serviceRefund = this.cells[3].innerHTML;            
            serviceArray += (refundType+ ',' +serviceName+ ',' +serviceRefund+ '|');              
           }            
                              
    });
  
 //encode the refund array
 refundArray = encodeURIComponent(serviceArray);

 //reset service array
 serviceArray = ""; 
 
 
    $.ajax ({
                 type: "POST",
                 url: "refundInvoiceVariables.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, contract_key_invoice: contractKeyInvoice, refund_balance: refundBalance, refund_array: refundArray, first_name: firstName, middle_name: middleName, last_name: lastName, street_address: streetAddress, city_name: cityName, state_name: stateName, zip_code: zipCode},              
                 success: function(data) {    
                      
                      if(data == 1) {
                        //open invoice window
                        openInvoiceWindow();
                        }else{
                         alert('There was an error printing this \"Refund Invoice\"');
                        }
                        
                                                              
                     }//end function success
              }); //end ajax              

 });
 //---------------------------------------------------------------------------------------
 });