$(document).ready(function(){

//--------------------------------------------------------------------------------------------
  $('#add').click(function() {    
    $('#service_types2 option:selected').remove().appendTo('#service_types1'); 
    
        var availableListLength = $("#service_types2 option").length;
              if(availableListLength == 0) {
                $('#service_types2').append('<option value="option1">Currently No Services Available</option>');
                }
   });  
   
   $('#remove').click(function() {
   
   $("#service_types2 option[value='option1']").remove();   
       var currentListLength = $("#service_types1 option").length;
             if(currentListLength == 1) {
               alert('Current Services list must contain a value');
                       return false;
               }
      
      $('#service_types1 option:selected').remove().appendTo('#service_types2');  
                     
   });  
//--------------------------------------------------------------------------------------------
$('.terms').keyup(function() { 

 var termVal = this.value;
          
    if(isNaN(termVal)) {
       alert('Term fields  can only contain numbers');
       $(this).val("");      
        } 

     termVal = parseInt(termVal);

    if(termVal > 31) {
       alert('Term value cannot be greater than \"31\"');
       $(this).val("");      
      }
      
    if(termVal == 0) {
       alert('Term value cannot be set to \"0\"');
       $(this).val("");      
      }      
     

});
//--------------------------------------------------------------------------------------------
$('#form1').submit(function(event) {

var guestPassTitle = $("#title").val();
var termOne = $("#term_one").val();
var currentListLength = $("#service_types1 option").length;
var passDesc = $("#pass_desc").val();
    
    
      if(guestPassTitle == "") {
         alert('Please provide a \"Guest Pass Title\"');
                 return false;
        }

      if(termOne == "") {
         alert('Please enter a value into the \"Term One\" field');
                 return false;
        }

      if(currentListLength == 0) {
         alert('Please select one or more Services');
                 return false;
         }
         
      if(passDesc == "") {
         alert('Please enter a Marketing Message');
                 return false;
        }
        
      if(passDesc.length > 100) {
         alert('Marketing Message cannot exceed 100 charachters in length');
                 return false;
        }

    //sets up the selection for services
     $('#service_types1 option').each(function(i) {  
      $(this).attr("selected", "selected");  
     });  


});
//--------------------------------------------------------------------------------------------
$('.pullConf').focus(function(){
$('#conf').html("&nbsp;");
});
//--------------------------------------------------------------------------------------------
    
   
});