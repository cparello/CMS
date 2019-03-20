$(document).ready(function(){

var barCode = "";

$(window).load(function () {
  $("#id_card").focus();  
  
  
   });
//---------------------------------------------------------
$('#form1').submit(function() {
  
var idCard = $('#id_card').val();


 if(idCard == "") {
           alert('Please fill out the New Card Number field');
           $("#id_card").focus();
           return false;
           }
 if(idCard == "0") {
           alert('The New Card Number field cannot be set to zero');
           $("#id_card").focus();
           return false;
           }         
if(isNaN(idCard)) {
           alert('The New Card Number field may only contain numbers');
           $("#id_card").focus();
           return false;
           }
if(idCard.length < 4) {
           alert('The New Card Number number is too short');
           $("#id_card").focus();
           return false;
           }

var memberId = $('#member_id').val();
var contractKey = $('#contract_key').val();
var memberName = $('#member_name').val();
           
           
 $.ajax ({
                 type: "POST",
                 url: "reassignCardSql.php",
                 cache: false,
                 dataType: 'html', 
                 data: {id_card: idCard, member_id: memberId, contract_key: contractKey},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       
                       var newImage = ('../memberphotos/' +idCard+ '.jpg');                       
                             $("#memPic").attr("src", newImage);
                             $('#currentCard').html(idCard);
                             $('#member_id').val(idCard);
                       
                       alert('Card number for ' +memberName+ ' successfully reassigned');
                              return false;                
                       }else{  
                       alert('There was an error processing the New Card Number');
                              return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax            

return false;
           
  });           
//----------------------------------------------------------------------------------------------           
           
  });               
           
           