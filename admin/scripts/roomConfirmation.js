$(window).load(function() {
//----------------------------------------------------------------
var confirmation = $("#confirmation").val();

if(confirmation != "") {
   alert(confirmation);
          confirmation = "";
        $("#confirmation").val(confirmation);
  }

});