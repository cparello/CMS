$(document).ready(function() {

var rowCount = $('#projTable tr').length;

if(rowCount != "7") {

   var dateRange = ($('#projTable tr:eq(1) > td:eq(0)').html());
         $("#rangeCount").html(dateRange);
}

});