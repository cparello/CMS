$(document).ready(function(){

var barCode = "";

$(window).load(function () {
  $("#memNum").focus();  
   });
//----------------------------------------------------------------
$('#form1').submit(function() {

  var memNumber = $("#memNum").val();
  var locationId = $("#location_id").val();
  
if(/^G/.test(memNumber))  {

  memNumber = memNumber.slice(1,  memNumber.length);

$.ajax ({
                 type: "POST",
                 url: "snapShotContentGuest.php",
                 cache: false,
                 dataType: 'html', 
                 data: {barcode_int: memNumber, location_id: locationId},               
                 success: function(data) {    
                 
                    if(data == 1) {
                       alert('Invalid Guest Pass');
                       }else{  
               // alert(data);
                        var dataArray = data.split("|");
                        var memName = dataArray[0];
                        var photoImage = dataArray[1];
                        var emgInfo = dataArray[2];
                        var memType = dataArray[3];
                        var memshipType = dataArray[4];
                        var memFlag = dataArray[5];
                        var upAdds = dataArray[6];
                        var memHist = dataArray[7];
                   
                        $('#memName').html(memName);
                        $('#memPhoto').html(photoImage);
                        $('#emgCont').html(emgInfo);
                        $('#memType').html(memType);
                        $('#memshipType').html(memshipType);
                        $('#memFlag').html(memFlag);
                        $('#upAdds').html(upAdds);
                        $('#memHist').html(memHist);
                        
                        
                      }
                   
                                           
                     }//end function success
              }); //end ajax 





 }else{
 
$.ajax ({
                 type: "POST",
                 url: "snapshotContent.php",
                 cache: false,
                 dataType: 'html', 
                 data: {member_id: memNumber, location_id: locationId},               
                 success: function(data) {    
                 
                    if(data == 1) {
                       alert('Invalid Member ID Card');
                       }else{  
                //  alert(data);
                        var dataArray = data.split("|");
                        var memName = dataArray[0];
                        var photoImage = dataArray[1];
                        var emgInfo = dataArray[2];
                        var memType = dataArray[3];
                        var memshipType = dataArray[4];
                        var memFlag = dataArray[5];
                        var upAdds = dataArray[6];
                        var memHist = dataArray[7];
                        
                        var noteTopicOne = dataArray[8];
                        var noteTopicTwo = dataArray[9];
                        var noteDateOne = dataArray[10];
                        var noteDateTwo = dataArray[11];
                        var noteTopicThree = dataArray[12];
                        var noteDateThree = dataArray[13];
                        var flag = dataArray[14];
                   
                        $('#memName').html(memName);
                        $('#memPhoto').html(photoImage);
                        $('#emgCont').html(emgInfo);
                        $('#memType').html(memType);
                        $('#memshipType').html(memshipType);
                        $('#memFlag').html(memFlag);
                        $('#upAdds').html(upAdds);
                        $('#memHist').html(memHist);
                        $('#noteTopicOne').html(noteTopicOne);
                        $('#noteTopicTwo').html(noteTopicTwo);
                        $('#noteDateOne').html(noteDateOne);
                        $('#noteDateTwo').html(noteDateTwo);
                        $('#noteTopicThree').html(noteTopicThree);
                        $('#noteDateThree').html(noteDateThree);
                        
                            var audioElement = document.createElement('audio');
                            audioElement.setAttribute('src', 'BuzOut.mp3');
                            //audioElement.setAttribute('autoplay', 'autoplay');
                            //audioElement.load()
                            $.get();
                            
                            if(flag == 'Y'){
                                audioElement.play();
                            }
                      }
                   
                                           
                     }//end function success
              }); //end ajax 
              
              
} //end else function
  

$("#memNum").val("");   
 
return false;
});


});
