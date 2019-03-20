$(document).ready(function() {
//-----------------------------------------------------------------
$("#flow_type").live("change", function(event) {

var clubId = $("#service_location").val();
var flowType = $("option:selected", this).val();
var optionDrops = "";
var ajaxSwitch = 1;


  if(flowType != "") {  
     
     switch(flowType) { 
        case "A":
        optionDrops = "<option value>Select Sales Type</option>\n<option value='ASR'>All Sales Types</option>";
        $("#sales_type").html(optionDrops); 
        return false;
        break;
        case "S":
        optionDrops = "<option value>Select Sales Type</option>\n<option value='ASS'>All Service Types</option>\n<option value='N'>New Services</option>\n<option value='U'>Upgrade Services</option>\n<option value='R'>Renewal Services</option>";
        $("#sales_type").html(optionDrops);
        return false;
        break;
        case "R":
        
        $.ajax ({
                type: "POST",
                url: "retailCategoryDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, flow_type: flowType},               
                     success: function(data) { 
                    // alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#sales_type").html(data);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

          break;
          }

       }
     
});
//-----------------------------------------------------------------

});


