$(document).ready(function() {
//----------------------------------------------------------------
function loadDataDrops(collectionType, dataBit) {

var dropOptions = "";
var dropHtml = "";
var selectHeader = ('<option value>Select Attempt</options>');

switch (collectionType) {
      case "P":
      
      for(var i = 1; i <= dataBit; i++) {         
          dropOptions += ('<option value=" ' +i+ ' ">Attempt ' +i+ '</option>');               
          } 
         
         var finalVal = dataBit + 1;
         var allSelections = ('<option value="0">All Types</options>');
         var finalSelection = ('<option value="'+finalVal+'">Final Notice</options>');      
               
         dropHtml = (selectHeader+ allSelections+ dropOptions+ finalSelection);
         return dropHtml;
                  
      break;
      case "D":
      
      var dropHtml = ('<option value>Select Type</options><option value="0">All Types</options>\n<option value="CC">Credit Card</options>\n<option value="AH">ACH</options>\n<option value="CH">Check</options>');
      return dropHtml;      
      
      break;
      }

}
//----------------------------------------------------------------
$("#collection_type").live("change", function(event) {

var collectionType = $("option:selected", this).val();
var ajaxSwitch = 1;
var dataDrops = "";

this.dropDownLable = "";

  if(collectionType != "") {  
        
     switch (collectionType) {
          case "P":
          var dropDownLable = ('<span class="black">2. Collection Attempts</span>&nbsp;');
          var parHeader1 = 'Accounts Past Due';
          var parHeader2 = 'Total Past Due';
          var parHeader3 = 'Past Due Projected';
                    
           $.ajax ({
                type: "POST",
                url: "../billing/invoiceSql.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, collection_type: collectionType},               
                     success: function(data) { 
                    // alert(data);
                     
                     dataDrops = loadDataDrops(collectionType, data);
                     
                       $("#colCat").show();
                       $("#colLable").html(dropDownLable);
                       $("#pHeader1").text(parHeader1);
                       $("#pHeader2").text(parHeader2);
                       $("#pHeader3").text(parHeader3);
                       $("#colCat").html(dataDrops);
                       $("#attempt_bit").val(data);
                       
                                                                           
                         }//end function success
                 }); //end ajax 
                    
          break;
          case "D":
          var dropDownLable = ('<span class="black">2. Transaction Type</span>&nbsp;');
          var data="";
                dataDrops = loadDataDrops(collectionType, data);
          var parHeader1 = 'Declined Transactions';
          var parHeader2 = 'Declined Total';
          var parHeader3 = 'Declined Projected';
          
                       $("#colCat").show();
                       $("#colLable").html(dropDownLable);
                       $("#colCat").html(dataDrops);                       
                       $("#pHeader1").text(parHeader1);
                       $("#pHeader2").text(parHeader2);
                       $("#pHeader3").text(parHeader3);
                                              
          break;
          case "I":
          var dropDownLable = ('<span class="black">2. Club Location</span>&nbsp;');
          var parHeader1 = 'Balance Due';
          var parHeader2 = 'Due Total';
          var parHeader3 = 'Due Projected';
          
           $.ajax ({
                type: "POST",
                url: "clubDropsTwo.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch},               
                     success: function(data) { 
                    // alert(data);
                     
                     dataDrops = loadDataDrops(collectionType, data);
                     
                         $("#colCat").show();
                         $("#colLable").html(dropDownLable);
                         $("#colCat").html(data);
                         $("#pHeader1").text(parHeader1);
                         $("#pHeader2").text(parHeader2);
                         $("#pHeader3").text(parHeader3);
                       
                         }//end function success
                 }); //end ajax           
          
          break;
        }
        
        
return false;        
             

    }else{
    $("#colLable").html("");
    $("#colCat").hide();
    }
     
});
//-----------------------------------------------------------------

});


