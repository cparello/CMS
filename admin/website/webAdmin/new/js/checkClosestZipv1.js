
$(document).ready(function(){
//===================================================
$('#zipCloseSearch').click(function() {
  
//var selectButton = $('#buttonStorage').val();
var zipcode = $('#zipcode1').val();
var miles = $('#miles').val();
var errors = "";


      if(zipcode == "") {
          //alert('Please enter a value into the zipcode field');
          //        return false;  
           errors = errors + "Please enter a value into the zipcode field.<br>";               
          }
      
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      zipcode = zipcode.replace(/\s+/g, "");
            

if(zipcode != "")  {
      if(isNaN(zipcode)) {
         //alert('Zipcode can only contain numbers');
        // $("#zipcode1").focus();
       //  return false;   
        errors = errors + "Zipcode can only contain numbers.<br>";         
         }
   }

 if(zipcode.length < 5) {
         // alert('Your zipcode must be 5 digits');
         //         return false;     
           errors = errors + "Your zipcode must be 5 digits.<br>";                            
          }
          
         if(errors !=""){
            $('#msgBox').html('Please fix these errors then resubmit!  <br>'+errors+' ');
            $("#msgBox").css( { "color" : "red"} );
            return false;
        }
           
 if(miles == ""){
    var option = 'C';
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
                           $("#content").html("<div class=\"gymBox\"><center><h2><u>Club Name:</u>&nbsp;&nbsp;&nbsp;"+closestClubName+"</h2><br><br><p><h5><u>Distance:</u>&nbsp;&nbsp;&nbsp;"+closestMiles+"&nbsp;miles from your zipcode.<br><br><u>Address:</u>&nbsp;&nbsp;&nbsp;"+closestAddress+"</h5></p><br><br><button class=\"button\" id=\"clubSelect\" onclick=\"location.href = 'join.php?club_id="+closestClubId+"';\" type=\"submit\" data-text=\"Processing…\"><span ><span>Select Club</span></button>&nbsp;&nbsp;&nbsp;<button class=\"button\" id=\"goBack\" onclick=\"location.href = 'locationSelect.php';\" type=\"submit\" data-text=\"Processing…\"><span>Go Back</span></button></center></div>");
                            // $('#name').val(name);
                             //alert(closestClubZip);
                             var className = $('.button').attr('class');
                             $(".button").css( { "padding" : "10px"} );
                             $(".button").css( { "margin" : "10px"} );
                             //$(".button").css("padding") = "0px";
                             $( "#goBack" ).addClass(className);
                             $( "#clubSelect" ).addClass(className);
                              $(".gymBox").css( { "background" : "#C3C3C3"} );
                            $(".gymBox").css( { "border" : "5px solid black"} );
                            $(".gymBox").css( { "padding" : "30px"} );
                            $(".gymBox").css( { "margin" : "30px"} );
                             
                            
                       }else{  
                       //alert('An error has occured. Please try again later.')
                       $('#msgBox').html('An error has occured. Please try again later.');
                        $("#msgBox").css( { "color" : "red"} );
                        return false;
                                                               
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      
    
 }else{
var option = 'R';
    
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
                        $('#msgBox').html('An error has occured. Please try again later.');
                        $("#msgBox").css( { "color" : "red"} );
                        return false;                                  
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      
 }
     // alert('fu');                 
  //alert(barcode);
  //send off to payment processor


          

});
//--------------------------------------------------------------------------------------



 });