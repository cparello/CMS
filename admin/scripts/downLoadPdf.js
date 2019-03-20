$(document).ready(function() {
//-----------------------------------------------------------------------
$('#down').click(function() {

var invoiceDrop = $('#invoice_file_month').val();
var fileDirectory = $('#file_directory').val();

if(invoiceDrop == "") {
   alert('Please select an Invoice to Download');
          $('#invoice_file_month').focus();
             return false;

  }


location.href = "../helper_apps/downLoadPdf.php?file_dir=" +fileDirectory+ "&file_name=" +invoiceDrop;





return false;

}); 
//-----------------------------------------------------------------------
});

