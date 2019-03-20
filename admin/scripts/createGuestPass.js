$(document).ready(function(){

//--------------------------------------------------------------------------------------------
$('#service_location').change(function(){
 
var clubId = this.value;
var serviceSwitch = 1;
              
$.ajax ({
                 type: "POST",
                 url: "guestPassServices.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {service_switch: serviceSwitch, club_id: clubId},               
                 success: function(data) {    

                $('#servList').html(data);
                               
                     }//end function success
              }); //end ajax 
              
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
var serviceTypes = $("#service_types1").val();
var passDesc = $("#pass_desc").val();

    
      if(guestPassTitle == "") {
         alert('Please provide a \"Guest Pass Title\"');
                 return false;
        }

      if(termOne == "") {
         alert('Please enter a value into the \"Term One\" field');
                 return false;
        }

      if(serviceTypes == null) {
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

});
//--------------------------------------------------------------------------------------------
$('.pullConf').focus(function(){
$('#conf').html("");
});
//--------------------------------------------------------------------------------------------
    
   
});