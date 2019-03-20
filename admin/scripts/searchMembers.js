$(document).ready(function(){
//--------------------------------------------------------------------------------------
   $('#form1').submit(function(event) {

      var memHolderValue = $("#mem_holder").val();
      var searchName = $("#search_name").val();
      var searchId = $("#id_number").val();
        
          if(memHolderValue == "") {
            alert('Please select a \"Contract Holder\" or \"Member\"');
             $("#mem_holder").focus();
             return false;
             }

          if(searchName == "" && searchId == "") {
            alert('Please enter a value into either the \"Search by Full or Partial Name\" or \"Contract Number or Member ID\" field');
             return false;
             }

       if(searchId != "") {
           if(!$.isNumeric($('#id_number').val())) {
               alert('The search by \"Contract Number or Member ID\" field must only contain numbers');
               $("#id_number").focus();
               return false;
             }
          }


$.ajax ({
                 type: "POST",
                 url: "searchHolderMember.php",
                 cache: false,
                 async:false,
                 dataType: 'html', 
                 data: {mem_holder: memHolderValue, search_id: searchId, search_name: searchName},               
                 success: function(data) {    
        // alert(data);
                  if(data == 0)  {
                             alert('There are no records that match your query ');
                             event.preventDefault();
                             return false;                            
                            }
                            
                            if(data != 0)  {
                            var answer = confirm('There are currently ' +data+ ' record(s) that match your query.  Do you wish to view these records?');
                            
                                   if(answer)   {                                                             
                                                  return true;
                                       }else{      
                                                  event.preventDefault();
                                                  return false;    
                                       }                                                                                                                                            
                            }
                               
                     }//end function success
              }); //end ajax 


   });
//--------------------------------------------------------------------------------------------   
$('#search_name').keyup(function() {

          var searchName = $("#search_name").val();
               if(searchName != "") {
                  $('#id_number').attr('disabled', '');
                  }else{
                  $('#id_number').removeAttr('disabled', '');
                  }
});   
   
$('#id_number').keyup(function() {

          var searchId = $("#id_number").val();
               if(searchId != "") {
                  $('#search_name').attr('disabled', '');
                  }else{
                  $('#search_name').removeAttr('disabled', '');
                  }
});         
//-------------------------------------------------------------------------------------------- 
$("select").change(function(){
 
              var memHolderValue = this.value;
                     switch(memHolderValue)  {
                       case "C":
                       $('#conMem').html('<u>Contract Number</u>');
                       break;
                       case "M":
                       $('#conMem').html('<u>Member ID</u>');
                       break;
                       case "N":
                       $('#conMem').html('<u>Non Member ID</u>');
                       break;
                       default:
                       $('#conMem').html('<u>Contract Number or Member ID</u>');
                      }

});
//--------------------------------------------------------------------------------------------
    
   
});