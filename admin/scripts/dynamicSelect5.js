$(document).ready(function() {
//----------------------------------------------------------------
$("#renew_type").live("change", function(event) {

var renewType = $("option:selected", this).val();

  if(renewType != "") {  
        
     switch (renewType) {
          case "ER":
           $("#from").attr("disabled", "disabled");
           $("#to").attr("disabled", "disabled"); 
           $("#from").val("");
           $("#to").val("");
          break;
          case "GP":
           $("#from").attr("disabled", "disabled");
           $("#to").attr("disabled", "disabled"); 
           $("#from").val("");
           $("#to").val("");           
          break;
          case "SR":
           $("#from").attr("disabled", "disabled");
           $("#to").attr("disabled", "disabled"); 
           $("#from").val("");
           $("#to").val("");           
          break;
          case "EA":
           $("#from").removeAttr("disabled");
           $("#to").removeAttr("disabled");          
          break;          
        }
        
              
             

    }else{
      $("#from").attr("disabled", "disabled");
      $("#to").attr("disabled", "disabled");
      $("#from").val("");
      $("#to").val("");
    }
     
});
//-----------------------------------------------------------------

});


