$(document).ready(function() {
//----------------------------------------------------------------
$("#button1").click( function() {

var instructorName = $("#instructor_name").val();
var instructorDescription = $("#instructor_description").val();
 

if(instructorName == "") {
  alert('Please enter the name of the instructor you wish to add. \"Instructor Description\" and \"Upload Instructor Photo\" fields are optional and may be updated through the \"Edit Instructors / Class Rooms\" interface');
          $("#instructor_name").focus();
             return false;
 }
 
if(instructorDescription != "") {
   var govenor = 1000;
   var descLength =  instructorDescription.length;
   
         if(descLength > govenor) {
            alert('The number of characters you have entered for the \"Instructor Description\" is '+descLength+'. This exceeds the maximum number of characters for this description which is '+govenor);
            return false;
           }
           
  }

 
}); 
//-------------------------------------------------------------
});