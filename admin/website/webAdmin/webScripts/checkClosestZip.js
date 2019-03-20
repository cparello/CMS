
$(document).ready(function(){
//===================================================
$('#zipCloseSearch').click(function() {
  
var selectButton = $('#buttonStorage').val();
var zipcode = $('#zipcode1').val();
var option = 'C';

      if(zipcode == "") {
          alert('Please enter a value into the zipcode field');
                  return false;                 
          }
      
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      zipcode = zipcode.replace(/\s+/g, "");
            

if(zipcode != "")  {
      if(isNaN(zipcode)) {
         alert('Zipcode can only contain numbers');
         $("#zipcode1").focus();
         return false;         
         }
   }

 if(zipcode.length < 5) {
          alert('Your zipcode must be 5 digits');
                  return false;                 
          }
     // alert('fu');                 
  //alert(barcode);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "zipDistanceBetween.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {zipcode: zipcode, option: option},              
                 success: function(data) {    
                //alert(data)
                
                    var dataArray = data.split("|");
                    var optionReturned = dataArray[0];
                    var closestClubZip = dataArray[1];
                    var closestMiles = dataArray[2];
                    var closestClubName = dataArray[3];
                    var closestClubId = dataArray[4];
                    var closestCity = dataArray[5];
                    var closestAddress = dataArray[6];
                    
                    if(optionReturned == 'C') {
                           $("#content").html("<div class=\"gymBox\"><center><h2><u>Club Name:</u>&nbsp;&nbsp;&nbsp;"+closestClubName+"</h2><br><br><p><h5><u>Distance:</u>&nbsp;&nbsp;&nbsp;"+closestMiles+"&nbsp;miles from your zipcode.<br><br><u>Address:</u>&nbsp;&nbsp;&nbsp;"+closestAddress+"</h5></p><br><br><button class=\"buttonPasses$middleButtons butColor\" id=\"clubSelect\" onclick=\"location.href = 'joinPage.php?club_id="+closestClubId+"';\" type=\"submit\" data-text=\"Processing…\"><span class=\"button-left\"><span class=\"button-right\">Select Club</span></span></button>&nbsp;&nbsp;&nbsp;<button class=\"buttonPasses$middleButtons butColor\" id=\"goBack\" onclick=\"location.href = 'locationSelectorPage.php';\" type=\"submit\" data-text=\"Processing…\"><span class=\"button-left\"><span class=\"button-right\">Go Back</span></span></button></center></div>");
                            // $('#name').val(name);
                             //alert(closestClubZip);
                             var className = $('.buttonJoinRed').attr('class');
                             $( "#goBack" ).addClass(className);
                             $( "#clubSelect" ).addClass(className);
                             
                            
                       }else{  
                       alert('An error has occured. Please try again later.')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });