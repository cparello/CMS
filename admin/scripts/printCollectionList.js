$(document).ready(function() {
//----------------------------------------------------------------
function loadCollectionList() {

window.open('collectionListWindow.php','','scrollbars=yes,menubar=no,height=600,width=850,resizable=no,toolbar=no,location=no,status=no');

}
//----------------------------------------------------------------
$("#printListBut").click( function() {

var reportType = $("#report_type").val();
var reportName = $("#savedDropSales").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();

if(reportType == 'C') {

var ajaxSwitch = 1;
var collectionType = $("#collection_type").val();
var collectionCategory = $("#colCat").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
this.reportName = "";


if(collectionType == "") {
  alert('Please select a \"Collection Category\"');
  $("#collection_type").focus();
  return false;
  
  }else{
          
        if(collectionCategory == "") {
        
                switch (collectionType) {
                  case "P":
                  alert('Please select a \"Collection Attempt\"');         
                  break;
                  case "D":
                  alert('Please select a \"Transaction Type\"');                        
                  break;
                  case "I":
                  alert('Please select a \"Club Location\"');          
                  break;   
                 }
      
              $("#colCat").focus();
                return false;
         }
  }


$("#savedDropSales > option").each(function() {
     if(this.selected != false) {
        reportName = this.text;
        }
  });    

  
if(reportName == "Select Collection Report") {
   reportName = 'NA';
  }    




        $.ajax ({
                type: "POST",
                url: "loadCollectionListVariables.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, collection_category: collectionCategory, collection_type: collectionType, from_date: fromDate, to_date: toDate, report_name: reportName, report_type: reportType},                 
                     success: function(data) { 
                        //alert(data);
                       
                         loadCollectionList();
                                                                           
                         }//end function success
                 }); //end ajax 




}

});
//------------------------------------------------------------------
$("#printListBut").on({
    'mouseover' : function() {
      $(this).attr('src','../images/print-list-on.png');
    },
    mouseout : function() {
  $(this).attr('src','../images/print-list-off.png');
    }
  });
//-----------------------------------------------------------------
});