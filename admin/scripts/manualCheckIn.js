$(document).ready(function(){

$('.checkBut').click(function() {

  var idString = this.id;
  var salt = idString.replace(/\D/g,'');
  var memberIdField = ('#check_in' +salt);  
  var memberId =  $(memberIdField).val();
  
  $.ajax ({
                 type: "POST",
                 url: "manualCheckIn.php",
                 cache: false,
                 dataType: 'html', 
                 data: {member_id: memberId},               
                 success: function(data) { 
             //    alert(data);
                 var dataArray = data.split('|');
                 var memberName =  dataArray[0];
                 var successBit = dataArray[1];  
                 
                 if(successBit == 1) {
                     alert(memberName+ ' successfully checked in');                 
                    }else{
                     alert('There was an error checking in the member Id: ' +memberId);  
                    }
                              
                               
                     }//end function success
              }); //end ajax 

 });

 });