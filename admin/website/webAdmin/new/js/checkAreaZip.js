$(document).ready(function(){

//===================================================
$('#zipAreaSearch').click(function() {
  //alert();
var zipcode = $('#zipcode2').val();
var miles = $('#miles').val();
var option = 'R';

      if(zipcode == "") {
          alert('Please enter a value into the zipcode field');
                  return false;                 
          }
      if(miles == "") {
          alert('Please select a miles option from the dropdown.');
                  return false;                 
          }
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      zipcode = zipcode.replace(/\s+/g, "");
            

if(zipcode != "")  {
      if(isNaN(zipcode)) {
         alert('Barcode can only contain numbers');
         $("#zipcode1").focus();
         return false;         
         }
   }

 if(zipcode.length < 5) {
          alert('Your zipcode must be 5 digits');
                  return false;                 
          }
                       
  //alert(barcode);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "zipDistanceBetween.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {zipcode: zipcode, option: option, miles: miles},              
                 success: function(data) {    
                //alert(data)
                
                    var dataArray = data.split("@");
                    var optionReturned = dataArray[0];
                    var zipArray = dataArray[1];
                   // alert(zipArray);
                    var clubList = zipArray.split("~");
                   // alert(clubList);
                    var numClubs = clubList.length;
                    numClubs = numClubs - 2;
                  //  var list1 = clubList[0]; 
                  //  var list2 = clubList[1]; 
                   // var items1 =  list1.split(":"); 
                   // var items2 =  list2.split(":");
                    
                        
                    if(optionReturned == 'R') {
                         var text = "";
                         var list;
                         //alert (numClubs);
                         for (var i = 0; i <= numClubs; i++) {
                            list = clubList[i].split(":");
                          // alert ( clubList[i]);
                          //  var list;
                          //  list = clubList[i];
                          //  alert(list);
                          //  var clubDetails = list.split(":");
                            var address = list[5];
                            var miles = list[4];
                            var id = list[2];
                            var name = list[1];
                           
                            
                              text += "<div class=\"gymBox\"><br><br><center><h2><u>Club Name:</u>&nbsp;&nbsp;&nbsp;"+name+"</h2><br><br><p><h5><u>Distance:</u>&nbsp;&nbsp;&nbsp;"+miles+"&nbsp;miles from your zipcode.<br><br><u>Address:</u>&nbsp;&nbsp;&nbsp;"+address+"</h5></p><br><br><button class=\"button\" id=\"clubSelect\" onclick=\"location.href = 'join.php?club_id="+id+"';\" type=\"submit\" data-text=\"Processing…\"><span>Select Club</span></button>&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"button\" id=\"goBack\" onclick=\"location.href = 'locationSelect.php';\" type=\"submit\" data-text=\"Processing…\"><span>Go Back</span></button></center><br><br></div><br><br>";
                            }
                         $("#content").html(text);  
                          var className = $('.button').attr('class');
                           //var changeClassName = $('.butColor').attr('class');
                           $(".button").css( { "padding" : "10px"} );
                           $(".button").css( { "margin" : "10px"} );
                           $(".gymBox").css( { "background" : "#C3C3C3"} );
                            $(".gymBox").css( { "border" : "5px solid black"} );
                            $(".gymBox").css( { "padding" : "30px"} );
                            $(".gymBox").css( { "margin" : "30px"} );
                          // $(".button").css("padding") = "0px";
                             $('.buttton').addClass(className);
                             
                             //$( changeClassName ).addClass(className);  
                              
                                     
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